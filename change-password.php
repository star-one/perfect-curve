<?php session_start();
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
$Loggedin = $_SESSION['LoggedIn'];
$UserID = $_SESSION['UserID'];
$UserName = $_SESSION['UserName'];
$UserEmail = $_SESSION['UserEmail'];

$PageTitle = "Change password";

if(!$LoggedIn)
{
	$url = "/login";
	header("Location: " . $url);
	die();
}

$sql = "SELECT UserEmail FROM Users WHERE UserID = '" . $UserID . "'";
$Emails = mysqli_query($connect,$sql);
$Email = mysqli_fetch_array($Emails);
$UserEmail = $Email['UserEmail'];

$Password = sanitise(mysqli_real_escape_string($connect, $_REQUEST["Password"]));
$Saltword = $UserEmail . $Password . $SiteDomain;

$Passwordconfirm = sanitise(mysqli_real_escape_string($connect, $_REQUEST["Passwordconfirm"]));
$options = [
    'cost' => 10,
];
$Hashword = password_hash($Saltword, PASSWORD_DEFAULT, $options);

$timeStamp = sanitise(mysqli_real_escape_string($connect, $_REQUEST['timeStamp']));
$timeNow = time();
if(($timeNow - $timeStamp) > 2) { $timeOK = 1; } else { $timeOK = 0; } // if the form is filled in in under two seconds suspect botspam

if ($Password) 
{
	if ($Password != $Passwordconfirm)
	{
		$Badpassword = 1;
		$Ack = "<p><strong>Sorry, the two passwords do not match - try again.</strong></p>";
	}

	if ($Badpassword != 1)
    {
		$sql = "UPDATE Users SET UserPassword = '$Hashword' WHERE UserID = '$UserID'";
		if (mysqli_query($connect,$sql))
		{	
			$To = $UserEmail; // currently doesn't work - need to get the email address somehow, cos it's not yet been got on this page
			$Subject = "Your " . $SiteName . " profile has been changed!";
			$From = "simon gray <simon@star-one.org.uk>";
			$Headers = "From: " . $From . "\r\nBcc: " . $Bcc . "\r\n";
			$Message = "Hi " . $UserName . " - your " . $SiteName . " profile has just been changed; if it wasn't you who did this, please reply to me immediately. \r\n\r\nEnjoy!\r\n\r\nsimon\r\n\r\n-- \r\n" . $SiteDomain . " - brought to you by simon gray"; 
			mail($To, $Subject, $Message, $Headers);

			$Ack = "<p><strong>Your password has been changed.</strong></p>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title><?php echo $PageTitle . " - " . $SiteName; ?></title>
<meta name="viewport" content="width=device-width">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="/shared/sjgscripts.js"></script>
<link rel="stylesheet" href="/shared/style.css">
<link rel="stylesheet" href="/shared/mediaqueries.css">
</head>
<body>
<?php
$HeaderPath = $_SERVER['DOCUMENT_ROOT'];
$HeaderPath .= "/shared/header.php";
include_once($HeaderPath);
?>
<div id="intro">
<h1><?php echo $PageTitle; ?></h1>
<?php
if (!$LoggedIn)
{
	if ($Badpassword OR $PasswordReset or $goodpassword == -1) { echo $Ack; }
}
?>
<h1>Change password</h1>
<?php
if ($Ack) { echo $Ack; }
?>
<p>
<em>You can change your password here.</em>
</p>

<form action="change-password" method="post">
<label for="Password">Password:</label><input type="password" name="Password" required /> <em><strong>(Required)</strong></em><br />
<label for="Passwordconfirm">Password confirm:</label><input type="password" name="Passwordconfirm" required /> <em>(Just to check you typed it right!)</em><br />
<input type="hidden" name="timeStamp" value="<?php echo time(); ?>" />
<input type="submit" value="Update password" />
</form>
</div>

<?php
$HeaderPath = $_SERVER['DOCUMENT_ROOT'];
$HeaderPath .= "/shared/footer.php";
include_once($HeaderPath);
?>
</body>
</html>