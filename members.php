<?php session_start();
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
$LoggedIn = $_SESSION['LoggedIn'];
$UserID = $_SESSION['UserID'];
$UserName = $_SESSION['UserName'];

$PageTitle = "Members";

$UserID = sanitise(mysqli_real_escape_string($connect, $_REQUEST["UserID"]));
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
<div id="intro">
Welcome<?php if ($UserName) { echo ", " . $UserName . ","; } ?> to The Perfect Curve.
</div>

<div id="memberlist">
<?php
$sql = "SELECT * FROM Users";
if(!$LoggedIn)
{
	$sql .= "";
}
else
{
	$sql .= "";
}
$sql .= " ORDER BY UserName";
$members = mysqli_query($connect,$sql);
while($member = mysqli_fetch_array($members))
{
	echo "<div id=\"member-" . $member['UserID'] . "\">\r\n";
	echo "<h2 class=\"membername\"><a href=\"/member/" . $member['UserID'] . "/" . slugify($member['UserName']) . "\" title=\"" . unescape($member['UserName']) . "\">" . unescape($member['UserName']) . "</a></h2>\r\n";
	echo "<p>" . unescape($member['UserName']);
	echo "<br ><a href=\"/dashboard/follow/" . $member['UserID'] . "\" title=\"Follow " . unescape($member['UserName']) . "\">Follow " . unescape($member['UserName']) . "</a></p>"; // needs to be made to be follow / unfollow when you get round to it
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