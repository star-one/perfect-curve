<?php session_start();
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
$LoggedIn = $_SESSION['LoggedIn'];
$UserID = $_SESSION['UserID'];
$UserName = $_SESSION['UserName'];

$PageTitle = "Groups";

$GroupName = sanitise(mysqli_real_escape_string($connect, $_REQUEST["GroupName"]));
$GroupDescription = sanitise(mysqli_real_escape_string($connect, $_REQUEST["GroupDescription"]));
$GroupPrivacy = sanitise(mysqli_real_escape_string($connect, $_REQUEST["GroupPrivacy"]));
$GroupCategoryID = sanitise(mysqli_real_escape_string($connect, $_REQUEST["GroupCategoryID"]));
	$GroupCategoryNew = sanitise(mysqli_real_escape_string($connect, $_REQUEST["GroupCategoryNew"]));
	if($GroupCategoryNew)
	{
		// Prepared statements
		// Bindings: i - integer, d - double, s - string, b - BLOB
		$addInfoSQL = $connect->prepare("INSERT INTO GroupCategories (GroupCategoryName) VALUES (?)");
		$addInfoSQL->bind_param("s", $GroupCategoryNew);
		$addInfoSQL->execute();
		$addInfoSQL->close();
	
		$sql = "SELECT GroupCategoryID FROM GroupCategories ORDER BY GroupCategoryID DESC LIMIT 1";
		$result = mysqli_query($connect,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$GroupCategoryID = $row['GroupCategoryID'];
		}
	}

$timeStamp = mysqli_real_escape_string($connect, $_REQUEST['timeStamp']);
$timeNow = time();
if(($timeNow - $timeStamp) > 2) { $timeOK = 1; } else { $timeOK = 0; } // if the form is filled in in under two seconds suspect botspam

if($GroupName AND $timeOK)
{
	$addDataSQL = $connect->prepare("INSERT INTO Groups (GroupName,
	GroupDescription,
	GroupPrivacy,
	GroupCategoryID) VALUES (?, ?, ?, ?)");
	$addDataSQL->bind_param("ssii",
	$GroupName,
	$GroupDescription,
	$GroupPrivacy,
	$GroupCategoryID);
	$addDataSQL->execute();
	$addDataSQL->close();

	$sql = "SELECT * FROM Groups ORDER BY GroupID DESC LIMIT 1";
	$result = mysqli_query($connect,$sql);
	while($row = mysqli_fetch_array($result))
	{
		$GroupID = $row['GroupID'];
	}

	$UserLevel = 0; // Level 0 is the Group Creator
	$addDataSQL = $connect->prepare("INSERT INTO GroupMembers (GroupID,
	UserID,
	UserLevel) VALUES (?, ?, ?)");
	$addDataSQL->bind_param("iii",
	$GroupID,
	$UserID,
	$UserLevel);
	$addDataSQL->execute();
	$addDataSQL->close();
	
	$url = "/dashboard";
	header("Location: " . $url);
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title><?php echo $PageTitle . " - " . $SiteName; ?></title>
<meta name="viewport" content="width=device-width">
<link rel="shortcut icon" href="/shared/french_curve.ico">
<link rel="stylesheet" href="/shared/style.css">
<link rel="stylesheet" href="/shared/mediaqueries.css">
<link href='//fonts.googleapis.com/css?family=Crete+Round' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.css">
<script src="//cdn.ckeditor.com/4.5.6/basic/ckeditor.js"></script>
<script src="//code.jquery.com/jquery-latest.js"></script>
<script src="/shared/sjgscripts.js"></script>
</head>
<body>
<?php
$HeaderPath = $_SERVER['DOCUMENT_ROOT'];
$HeaderPath .= "/shared/header.php";
include_once($HeaderPath);
?>
<h1><?php echo $PageTitle; ?></h1>
<div id="intro">
Welcome<?php if ($UserName) { echo ", " . $UserName . ","; } ?> to The Perfect Curve.
</div>
<?php
	if($LoggedIn) {
?>
<div id="post">
	<form action="groups" method="post">
	<label for="GroupName">Group name:</label><br />
	<input type="text" name="GroupName" id="GroupName" required /><br />
	<label for="GroupDescription">Description:</label><br />
	<textarea name="GroupDescription" id="GroupDescription"></textarea><br />
	<label for="GroupPrivacy">Group privacy:</label><br />
	<select name="GroupPrivacy" id="GroupPrivacy">
	<option value="0">Group, members, and posts visible in public stream</option>
	<option value="1">Group, members, and posts visible only to logged in users</option>
	<option value="2">Group and members visible to logged in users; posts visible only to group members</option>
	<option value="3">Group visible to logged in users; members and posts visible only to group members</option>
	<option value="4">Private group, invited members only</option>
	</select><br />
	<label for="GroupCategoryID">Category:</label>
	<select name="GroupCategoryID" onChange="addNew('GroupCategoryNew', this.value)">
	<option value="0">-- select --</option>
	<?php
	$sql = "SELECT * FROM GroupCategories ORDER BY GroupCategoryName ASC";
	$result = mysqli_query($connect,$sql);
	while($row = mysqli_fetch_array($result))
	{
		echo "<option value=\"" . $row['GroupCategoryID'] . "\">" . unescape($row['GroupCategoryName']) . "</option>\r\n";
	}
	?>
	<option value="-1">-- add new --</option>
	</select> <input type="text" name="GroupCategoryNew" id="GroupCategoryNew" placeholder="New category" style="display: none;" /><br />
	<input type="hidden" name="timeStamp" value="<?php echo time(); ?>" />
	<input type="submit" value="Add group" />
	</form>
</div>
<?php
	}
?>
<div id="postlist">
<?php
$sql = "SELECT * FROM Groups INNER JOIN GroupCategories ON Groups.GroupCategoryID = GroupCategories.GroupCategoryID";
if(!$LoggedIn)
{
	$sql .= " WHERE GroupPrivacy = 0";
}
else
{
	$sql .= " WHERE GroupPrivacy < 4";
}
$sql .= " ORDER BY GroupName DESC";
$groups = mysqli_query($connect,$sql);
while($group = mysqli_fetch_array($groups))
{
	echo "<div id=\"group-" . $group['GroupID'] . "\">\r\n";
	echo "<h2 class=\"groupname\"><a href=\"/group/" . $group['GroupID'] . "/" . slugify($group['GroupName']) . "\" title=\"" . unescape($group['GroupName']) . "\">" . unescape($group['GroupName']) . "</a></h2>\r\n";
	echo "<p>" . unescape($group['GroupDescription']) . "<br /><em>In category <strong>" . unescape($group['GroupCategoryName']) . "</strong></em> - ";
	if($LoggedIn) { echo "<a href=\"/dashboard/join/" . $group['GroupID'] . "\" title=\"Join " . unescape($group['GroupName']) . "\">Join group</a></p>"; }
	echo "</p>\r\n</div>\r\n\r\n";
}
?>
</div>
<?php
$HeaderPath = $_SERVER['DOCUMENT_ROOT'];
$HeaderPath .= "/shared/footer.php";
include_once($HeaderPath);
?>
</body>
</html>