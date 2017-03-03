<?php session_start();
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
$LoggedIn = $_SESSION['LoggedIn'];
$UserID = $_SESSION['UserID'];
$UserName = $_SESSION['UserName'];

$PageTitle = "My dashboard";

if(!$LoggedIn)
{
	$url = "/login";
	header("Location: " . $url);
	die();
}

$page = explode("/",$_SERVER['REQUEST_URI']);
$PageFlag = mysqli_real_escape_string($connect, $page[2]);
$PageID = mysqli_real_escape_string($connect, $page[3]);

$timeStamp = mysqli_real_escape_string($connect, $_REQUEST['timeStamp']);
$timeNow = time();
if(($timeNow - $timeStamp) > 2) { $timeOK = 1; } else { $timeOK = 0; } // if the form is filled in in under two seconds suspect botspam

if($PageFlag == "join-group")
{
	$GroupID = $PageID;

	$UserLevel = 2;
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
if($PageFlag == "follow")
{
	$FriendID = $PageID;

	$addDataSQL = $connect->prepare("INSERT INTO Friendships (UserID,
	FriendID) VALUES (?, ?)");
	$addDataSQL->bind_param("ii",
	$UserID,
	$FriendID);
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
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.css">
<script src="//code.jquery.com/jquery-latest.js"></script>
<script src="/shared/sjgscripts.js"></script>
</head>
<body>
<?php
$HeaderPath = $_SERVER['DOCUMENT_ROOT'];
$HeaderPath .= "/shared/header.php";
include_once($HeaderPath);
?>
<div id="intro">
Welcome<?php if ($UserName) { echo ", " . $UserName . ","; } ?> to The Perfect Curve.
</div>

<div id="grouplist">
<?php
$sql = "SELECT * FROM Groups INNER JOIN GroupCategories ON Groups.GroupCategoryID = GroupCategories.GroupCategoryID INNER JOIN GroupMembers ON Groups.GroupID = GroupMembers.GroupID WHERE UserID = '$UserID' ORDER BY GroupName DESC";
$groups = mysqli_query($connect,$sql);
while($group = mysqli_fetch_array($groups))
{
	echo "<article id=\"group-" . unescape($group['GroupID']) . "\">\r\n";
	echo "<h2 class=\"groupname\"><a href=\"/group/" . $group['GroupID'] . "/" . slugify($group['GroupName']) . "\" title=\"" . unescape($group['GroupName']) . "\">" . unescape($group['GroupName']) . "</a></h2>\r\n";
	echo "<p>" . unescape($group['GroupDescription']) . "<br /><em>In category <strong>" . unescape($group['GroupCategoryName']) . "</strong></em> - ";
	echo "<a href=\"/dashboard/leave/" . $group['GroupID'] . "\" title=\"Leave " . unescape($group['GroupName']) . "\">Leave group</a></p>"; 
	echo "</p>\r\n</article>\r\n\r\n";
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