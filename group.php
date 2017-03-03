<?php session_start();
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
$LoggedIn = $_SESSION['LoggedIn'];
$UserID = $_SESSION['UserID'];
$UserName = $_SESSION['UserName'];
$DefaultPostPrivacy = $_SESSION['DefaultPostPrivacy'];

$PageTitle = "Group";

// sort out getting the group name in due course

$page = explode("/",$_SERVER['REQUEST_URI']);
$GroupID = mysqli_real_escape_string($connect, $page[2]);
$GroupSlug = mysqli_real_escape_string($connect, $page[3]);

$Flag = "group";
$ID = $GroupID;

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
<script src="/ckeditor/ckeditor.js"></script>
<script src="//code.jquery.com/jquery-latest.js"></script>
<script src="/shared/sjgscripts.js"></script>
</head>
<body>
<?php
$HeaderPath = $_SERVER['DOCUMENT_ROOT'];
$HeaderPath .= "/shared/header.php";
include_once($HeaderPath);

$sql = "SELECT * FROM Groups WHERE GroupID = $GroupID";
$result = mysqli_query($connect,$sql);
while($row = mysqli_fetch_array($result))
{
	$GroupName = $row['GroupName'];
}
?>
<h1>Group - <?php echo $GroupName; ?></h1>
<div id="intro">
Welcome<?php if ($UserName) { echo ", " . $UserName . ","; } ?> to The Perfect Curve.
</div>
<?php
	if($LoggedIn) {
?>
<div id="post">
	<form id="post-form" action="/postcurve" method="post">
	<h2>Post a Curve</h2>
	<label for="PostTitle">Title:</label><br />
	<input type="text" name="PostTitle" id="PostTitle" /><br />
	<label for="PostContent">Post:</label><br />
	<textarea name="PostContent" id="PostContent" required></textarea><br />
	        <script>
				CKEDITOR.replace( 'PostContent', {
					filebrowserBrowseUrl :'/filemanager/browser/default/browser.php?Connector=/filemanager/connectors/php/connector.php',
          filebrowserImageBrowseUrl : '/filemanager/browser/default/browser.php?Type=Image&Connector=/filemanager/connectors/php/connector.php',
					filebrowserUploadUrl  :'/filemanager/connectors/php/upload.php?Type=File',
					filebrowserImageUploadUrl : '/filemanager/connectors/php/upload.php?Type=Image',
					filebrowserWindowWidth : 800,
					filebrowserWindowHeight: 480
				});
        </script>
<a href="javascript:showHide('postadvanced')" title="Advanced">Advanced</a>
	<div id="postadvanced" class="hidden">
		<br /><label for="GroupID">In group:</label>
		<select name="GroupID" id="GroupID">
		<option value="0">-- In the public stream --</option>
		<?php
		$sql = "SELECT * FROM Groups INNER JOIN GroupMembers on Groups.GroupID = GroupMembers.GroupID WHERE UserID = '$UserID' ORDER BY GroupName ASC";
		$result = mysqli_query($connect,$sql);
		while($row = mysqli_fetch_array($result))
		{
			echo "<option value=\"" . $row['GroupID'] . "\"";
			if($row['GroupID'] == $GroupID) { echo " selected"; }
			echo ">" . unescape($row['GroupName']) . "</option>\r\n";
		}
		?>
		</select><br />
		<label for="PostDate">Posting date:</label>
		<input type="date" name="PostDate" id="PostDate" value="" />
		<label for="PostTime">Posting time:</label>
		<input type="time" name="PostTime" id="PostTime" value="" /><br />
		<label for="PostPrivacy">Privacy:</label>
		<select name="PostPrivacy" id="PostPrivacy">
		<option value="0">Anybody browsing the site</option>
		<option value="1">Public stream, only logged in users</option>
		<option value="2">Public stream, your followers and friends</option>
		<option value="3">Private stream, people you follow only</option>
		<option value="5">Group privacy settings</option>
		<option value="4">Secret - yourself only</option>
		</select><br />
	</div>
	<input type="hidden" name="GroupID" value="<?php echo $GroupID; ?>" />
	<input type="hidden" name="GroupSlug" value="<?php echo $GroupSlug; ?>" />
	<input type="hidden" name="timeStamp" value="<?php echo time(); ?>" />
	<input type="submit" value="Post Curve" />
	</form>
</div>
<?php
	}
?>
<div id="curvelist">
<?php
$HeaderPath = $_SERVER['DOCUMENT_ROOT'];
$HeaderPath .= "/curves.php";
include_once($HeaderPath);
?>
</div>
<div id="right-sidebar">
<?php
$HeaderPath = $_SERVER['DOCUMENT_ROOT'];
$HeaderPath .= "/right-sidebar.php";
include_once($HeaderPath);
?>
</div>
<?php
$HeaderPath = $_SERVER['DOCUMENT_ROOT'];
$HeaderPath .= "/shared/footer.php";
include_once($HeaderPath);
?>
</body>
</html>