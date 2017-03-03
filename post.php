<?php session_start();
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
$LoggedIn = $_SESSION['LoggedIn'];
$UserID = $_SESSION['UserID'];
$UserName = $_SESSION['UserName'];
$UserEmail = $_SESSION['UserEmail'];
$DefaultPostPrivacy = $_SESSION['DefaultPostPrivacy'];

$sql = ""; // sort out getting the post title here

$PageTitle = "Home";

$page = explode("/",$_SERVER['REQUEST_URI']);
$PostID = mysqli_real_escape_string($connect, $page[2]);
$PostSlug = mysqli_real_escape_string($connect, $page[3]);

$Flag = "post";
$ID = $PostID;
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
?>
<div id="intro">
Welcome<?php if ($UserName) { echo ", " . $UserName . ","; } ?> to The Perfect Curve.
</div>
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
<script>
$('.popup').magnificPopup({
  type:'ajax',
	overflowY: 'scroll' // as we know that popup content is tall we set scroll overflow by default to avoid jump
});
</script>
</body>
</html>