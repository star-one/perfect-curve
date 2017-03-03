<?php session_start();
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
$LoggedIn = $_SESSION['LoggedIn'];
$UserID = $_SESSION['UserID'];
$UserName = $_SESSION['UserName'];
$UserEmail = $_SESSION['UserEmail'];
$DefaultPostPrivacy = $_SESSION['DefaultPostPrivacy'];

$PageTitle = "Home";

$page = explode("/",$_SERVER['REQUEST_URI']);
$PageNum = mysqli_real_escape_string($connect, $page[1]);

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
Welcome<?php if ($UserName) { echo ", " . $UserName . ","; echo $PageNum;} ?> to The Perfect Curve.
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
	<textarea name="PostContent" id="PostContent"></textarea><br />
	        <script>
				CKEDITOR.replace( 'PostContent',
                {
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
			echo "<option value=\"" . $row['GroupID'] . "\">" . unescape($row['GroupName']) . "</option>\r\n";
		}
		?>
		</select><br />
		<label for="PostDate">Posting date:</label>
		<input type="date" name="PostDate" id="PostDate" value="" />
		<label for="PostTime">Posting time:</label>
		<input type="time" name="PostTime" id="PostTime" value="" /><br />
		<label for="PostPrivacy">Privacy:</label>
		<select name="PostPrivacy" id="PostPrivacy">
		<option value="0"<?php if($DefaultPostPrivacy == 0) { echo " selected"; } ?>>Anybody browsing the site</option>
		<option value="1"<?php if($DefaultPostPrivacy == 1) { echo " selected"; } ?>>Public stream, only logged in users</option>
		<option value="2"<?php if($DefaultPostPrivacy == 2) { echo " selected"; } ?>>Public stream, your followers and friends</option>
		<option value="3"<?php if($DefaultPostPrivacy == 3) { echo " selected"; } ?>>Private stream, people you follow only</option>
		<option value="4"<?php if($DefaultPostPrivacy == 4) { echo " selected"; } ?>>Secret - yourself only</option>
		</select><br />
	</div>
	<input type="hidden" name="timeStamp" value="<?php echo time(); ?>" />
	<input type="submit" value="Post Curve" />
	</form>
</div>
<?php
	}
?>
<div id="count"></div>
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

/* function resumeRefresh()
{
	loadCurves();
	$refreshing = setInterval(function(){loadCurves()}, 5000);
}
$count = 0;
function loadCurves(){
  $("#curvelist").load("/curves");
	$count++;
	if($count == 360 ) { document.getElementById("count").innerHTML = "<p>Autorefresh paused: <button onClick='resumeRefresh();'>Resume</button></p>"; clearInterval($refreshing); $refreshing = 0; $count = 0; } // pauses autorefresh after 30 minutes / 360 refreshes
}
loadCurves();
$refreshing = setInterval(function(){loadCurves()}, 5000); */
</script>
</body>
</html>