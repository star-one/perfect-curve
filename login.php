<?php session_start();
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
$Loggedin = $_SESSION['LoggedIn'];
$UserID = $_SESSION['UserID'];
$UserName = $_SESSION['UserName'];
$UserEmail = $_SESSION['UserEmail'];

$PageTitle = "Login or register";

$page = explode("/",$_SERVER['REQUEST_URI']);
$InviterID = sanitise(mysqli_real_escape_string($connect, $page[2]));
$InviteName = base64_decode(sanitise(mysqli_real_escape_string($connect, $page[3])));
$InviteEmail = base64_decode(sanitise(mysqli_real_escape_string($connect, $page[4])));

$NewUser = sanitise(mysqli_real_escape_string($connect, $_REQUEST["NewUser"]));
$UserName = sanitise(mysqli_real_escape_string($connect, $_REQUEST["UserName"]));
$UserEmail = strtolower(sanitise(mysqli_real_escape_string($connect, $_REQUEST["UserEmail"])));
$DefaultPostPrivacy = sanitise(mysqli_real_escape_string($connect, $_REQUEST["DefaultPostPrivacy"]));
$JoinDate = date("Y-m-d");

$LoginEmail = strtolower(sanitise(mysqli_real_escape_string($connect, $_REQUEST["LoginEmail"])));
$LoginPassword = sanitise(mysqli_real_escape_string($connect, $_REQUEST["LoginPassword"]));
$LostPassword = sanitise(mysqli_real_escape_string($connect, $_REQUEST["LostPassword"]));

if($LoginEmail && $LoginPassword) {
	$Password = sanitise(mysqli_real_escape_string($connect, $_REQUEST["LoginPassword"]));
	$Saltword = $LoginEmail . $Password . $SiteDomain;
}
else{
	$Password = sanitise(mysqli_real_escape_string($connect, $_REQUEST["Password"]));
	$Saltword = $UserEmail . $Password . $SiteDomain;
}
$Passwordconfirm = sanitise(mysqli_real_escape_string($connect, $_REQUEST["Passwordconfirm"]));
$options = [
    'cost' => 10,
];
$Hashword = password_hash($Saltword, PASSWORD_DEFAULT, $options);

$timeStamp = sanitise(mysqli_real_escape_string($connect, $_REQUEST['timeStamp']));
$timeNow = time();
if(($timeNow - $timeStamp) > 2) { $timeOK = 1; } else { $timeOK = 0; } // if the form is filled in in under two seconds suspect botspam

if ($UserName && $timeOK == 1 && $NewUser)
{
	if ($Password != $Passwordconfirm)
	{
		$Badpassword = 1;
		$Ack = "<p><strong>Sorry, the two passwords do not match - try again.</strong></p>";
	}

	if ($Badpassword != 1)
	{
		// Prepared statements
		// Bindings: i - integer, d - double, s - string, b - BLOB
		$addUserSQL = $connect->prepare("INSERT INTO Users (UserName,
		UserEmail,
		UserPassword,
		DefaultPostPrivacy,
		JoinDate) VALUES (?, ?, ?, ?, ?)");
		$addUserSQL->bind_param("sssis", 
		$UserName, 
		$UserEmail, 
		$Hashword,
		$DefaultPostPrivacy,
		$JoinDate);

		$addUserSQL->execute();
		$addUserSQL->close();

			$sql = "SELECT * FROM Users ORDER BY UserID DESC LIMIT 1";
			$result = mysqli_query($connect,$sql);
			while($row = mysqli_fetch_array($result))
			{
				$UserID = $row['UserID'];
			}

			$_SESSION['LoggedIn'] = 1;
			$_SESSION['UserID'] = $UserID;
			$_SESSION['UserName'] = $UserName;
			$_SESSION['UserEmail'] = $UserEmail;
			$_SESSION['DefaultPostPrivacy'] = $DefaultPostPrivacy;
			$_SESSION['ThisLoginPostID'] = 0;
			$_SESSION['LastLoginPostID'] = 0;
	
			$To = $UserEmail;
			$Subject = "Welcome to " . $SiteName . "!";
			$Bcc = "simon gray <simon@star-one.org.uk>";
			$From = "simon gray <simon@star-one.org.uk>";
			$Headers = "From: " . $From . "\r\nReply-To: simon gray <simon@star-one.org.uk>\r\nBcc: " . $Bcc;
			$Message = "Welcome " . $UserName . " to " . $SiteName . " - you can find it again at " . $SiteDomain . "\r\n\r\nEnjoy!\r\n\r\nsimon\r\n\r\n-- \r\n" . $SiteDomain . " - brought to you by simon gray"; 
			mail($To, $Subject, $Message, $Headers);

			if($InviterID)
			{
				$addFriendSQL = $connect->prepare("INSERT INTO Friendships (UserID,
				FriendID) VALUES (?, ?)");
				$addFriendSQL->bind_param("ii", 
				$UserID, 
				$InviterID);
				$addFriendSQL->execute();
				$addFriendSQL->close();

				$addFriendSQL = $connect->prepare("INSERT INTO Friendships (UserID,
				FriendID) VALUES (?, ?)");
				$addFriendSQL->bind_param("ii", 
				$InviterID, 
				$UserID);
				$addFriendSQL->execute();
				$addFriendSQL->close();
			}
		
			$referrer = "Location: " . $SiteDomain;
			header($referrer);
			die();
	}
}


if ($LoginEmail)
{
  $sql = "SELECT * FROM Users WHERE UserEmail = '" . $LoginEmail . "'";

  $result = mysqli_query($connect,$sql);
  $row = mysqli_fetch_array($result);
  $Saltword = $LoginEmail . $Password . $SiteDomain;
  $Hashword = $row['UserPassword'];

  if (!$row)
  {
    $login = -1;
	$found = -1;
	echo "<p><strong>Sorry, that username or password is incorrect.</strong></p>";
  }
  
  if (!password_verify($Saltword, $Hashword))
  {
    $login = -1;
	$goodpassword = -1;
	$Ack = "<p><strong>Sorry, that username or password is incorrect.</strong></p>";
  }
	
  if ($LostPassword)
  {
    $login = -1;
	$goodpassword = -1;
	$PasswordReset = 1;

	$Password = mt_rand(100000,99999999) . "changemenow" . mt_rand(100000,99999999);
	$Saltword = $LoginEmail . $Password . $SiteDomain;
	$Hashword = password_hash($Saltword, PASSWORD_DEFAULT, $options);

	$sql = "UPDATE Users SET UserPassword = '$Hashword' WHERE UserEmail = '$LoginEmail'";
	if (mysqli_query($connect,$sql))
	{
		$Ack = "<p><strong>OK, your password has been reset and a temporary one emailed to you.</strong></p>";

		$To = $LoginEmail;
		$Subject = "That thing from " . $SiteName . "!";
		$From = "simon gray <simon@star-one.org.uk>";
		$Headers = "From: " . $From . "\r\nReply-To: simon gray <simon@star-one.org.uk>";
		$Message = "You forgot something! It's been reset to " . $Password . " - you can login again at " . $SiteDomain . "login and then change to one you prefer to use on " . $SiteDomain . "change-password\r\n\r\n-- \r\n" . $SiteDomain . " - brought to you by simon gray";
		mail($To, $Subject, $Message, $Headers);
	}
  }

  if ((password_verify($Saltword, $Hashword) && $found != -1 && $goodpassword != -1) || $adminpassword)
  {
	$sql = "SELECT PostID FROM Posts ORDER BY PostID DESC LIMIT 1";
	$comments = mysqli_query($connect,$sql);
	while($comment = mysqli_fetch_array($comments))
	{
		$LastCommentID = $comment['PostID'];
	}

	$UserID = $row['UserID'];
	$_SESSION['LoggedIn'] = 1;
	$_SESSION['UserID'] = $UserID;
	$_SESSION['UserName'] = $row['UserName'];
	$_SESSION['UserEmail'] = $row['UserEmail'];
	$_SESSION['DefaultPostPrivacy'] = $row['DefaultPostPrivacy'];
	$_SESSION['ThisLoginPostID'] = $LastCommentID;
	$_SESSION['LastLoginPostID'] = $row['ThisLoginPostID'];

	$sql = "UPDATE Users SET ThisLoginPostID = '$LastCommentID', LastLoginPostID = '" . $row['ThisLoginPostID'] . "' WHERE UserID = '$UserID'";
	if (mysqli_query($connect,$sql))
	{
		$referrer = "Location: " . $SiteDomain; // . "dashboard"; dashboard to be implemented later, maybe
		header($referrer);
		die();
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
<link rel="shortcut icon" href="/shared/frence_curve.ico">
<link rel="stylesheet" href="/shared/style.css">
<link rel="stylesheet" href="/shared/mediaqueries.css">
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
<h1><?php echo $PageTitle; ?></h1>
<?php
if (!$LoggedIn)
{
	if ($Badpassword OR $PasswordReset or $goodpassword == -1) { echo $Ack; }
}
?>
</div>

<div id="login" class="half-left"<?php if($InviteEmail) { echo " style=\"display: none;\""; } ?>>
<h2>Login</h2>
<form action="login" method="post">
<label for="LoginEmail">Email address:</label><input type="email" name="LoginEmail"><br />
<label for="LoginPassword">Password:</label><input type="password" name="LoginPassword"><br />
<em>(<label for="LostPassword">Tick this box if you've forgotten your password and want a reset one emailed to you:</label> <input type="checkbox" name="LostPassword" value="lost" />)</em><br />
<input type="submit" value="Login">
</form>
</div>

<div id="register" class="half-right">
<h2>Register</h2>
You'll be able to set more detailed profile information in due course.<br />
<form action="login?NewUser=1" method="post">
<label for="UserName">Your name:</label><input type="text" value="<?php echo $InviteName; ?>" name="UserName" required /> <em><strong>(Required)</strong></em><br />
<label for="UserEmail">Email address:</label><input type="text" value="<?php echo $InviteEmail; ?>" name="UserEmail" required /> <em><strong>(Required)</strong></em><br />
<label for="Password">Password:</label><input type="password" name="Password" required /> <em><strong>(Required)</strong></em><br />
<label for="Passwordconfirm">Password confirm:</label><input type="password" name="Passwordconfirm" required /><br />
<label for="DefaultPostPrivacy">Default post privacy:</label>
<select name="DefaultPostPrivacy" id="DefaultPostPrivacy">
<option value="0">Anybody browsing the site</option>
<option value="1">Public stream, only logged in users</option>
<option value="2" selected>Public stream, your followers and friends</option>
<option value="3">Private stream, your friends only</option>
<option value="4">Secret - yourself only</option>
</select><br /><em>You can change this for individual posts</em><br />
<input type="hidden" name="timeStamp" value="<?php echo time(); ?>" />
<input type="submit" value="Register" />
</form>
</div>
<?php
$HeaderPath = $_SERVER['DOCUMENT_ROOT'];
$HeaderPath .= "/shared/footer.php";
include_once($HeaderPath);
?>
</body>
</html>