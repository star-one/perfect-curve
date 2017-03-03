<?php session_start();
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
$LoggedIn = $_SESSION['LoggedIn'];
$UserID = $_SESSION['UserID'];
$UserName = $_SESSION['UserName'];
$UserEmail = $_SESSION['UserEmail'];

$PageTitle = "Invite a member";

if(!$LoggedIn)
{
	$url = "/login";
	header("Location: " . $url);
	die();
}

$InviteEmail = sanitise(mysqli_real_escape_string($connect, $_REQUEST["InviteEmail"]));
$InviteName = sanitise(mysqli_real_escape_string($connect, $_REQUEST["InviteName"]));
$InviteMessage = sanitise(mysqli_real_escape_string($connect, $_REQUEST["InviteMessage"]));
$InviteMessage = str_replace('\r\n', '', $InviteMessage);
$InviteMessage = unescape($InviteMessage);

$timeStamp = mysqli_real_escape_string($connect, $_REQUEST['timeStamp']);
$timeNow = time();
if(($timeNow - $timeStamp) > 2) { $timeOK = 1; } else { $timeOK = 0; } // if the form is filled in in under two seconds suspect botspam

if($InviteEmail AND $timeOK)
{
			$To = $InviteEmail;
			$Subject = $UserName . " has invited you to join The Perfect Curve!";
			$Bcc = "simon gray <simon@star-one.org.uk>";
			$From = $UserName . "<" . $UserEmail . ">";
			$Headers = "From: " . $From . "\r\nCc: " . $UserName . "<" . $UserEmail . ">\r\nBcc: " . $Bcc;
			$Message .= $InviteMessage;
			$Message .= "\r\n\r\nTo join, go to " . $SiteDomain . "login/" . $UserID . "/" . base64_encode($InviteName) . "/" . base64_encode($InviteEmail) . " and complete the registration form. The site is still early in its development, but you should hopefully find enough there so far to pique your interest.";
			$Message .= "\r\n\r\nEnjoy!\r\n\r\nsimon\r\n\r\n-- \r\n" . $SiteDomain . " - brought to you by simon gray"; 
			mail($To, $Subject, $Message, $Headers);

			$Ack = "<p><strong>Invitation to " . $InviteName . " sent!</strong></p>";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title><?php echo $PageTitle . " - " . $SiteName; ?></title>
<meta name="viewport" content="width=device-width">
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
<p>
Welcome<?php if ($UserName) { echo ", " . $UserName . ","; } ?> to The Perfect Curve.	
</p>
<?php if($Ack) { echo $Ack; } ?>
	<p>
		A social media / social networking site is nothing without friends with whom to be sociable. Invite your friends to join you here!
	</p>
</div>
<form action="/invite" method="post">
<label for="InviteEmail">Email address:</label><input type="email" name="InviteEmail"><br />
<label for="InviteName">Name:</label><input type="text" name="InviteName"><br />
<label for="InviteMessage">Message:</label><br />
<textarea name="InviteMessage">
Hiya - I've been recently playing with a new social media / social networking site - The Perfect Curve - and I thought you might be interested in it too. The joining instructions are below!
</textarea>
<input type="hidden" name="timeStamp" value="<?php echo time(); ?>" />
<input type="submit" value="Invite">
</form>
<?php
$HeaderPath = $_SERVER['DOCUMENT_ROOT'];
$HeaderPath .= "/shared/footer.php";
include_once($HeaderPath);
?>
</body>
</html>