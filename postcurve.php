<?php session_start();
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
$LoggedIn = $_SESSION['LoggedIn'];
$UserID = $_SESSION['UserID'];
$UserName = $_SESSION['UserName'];

if(!$LoggedIn)
{
	$url = "/login";
	header("Location: " . $url);
	die();
}

$PostTitle = sanitise(mysqli_real_escape_string($connect, $_REQUEST["PostTitle"]));
$PostContent = sanitise(mysqli_real_escape_string($connect, $_REQUEST["PostContent"]));
$GroupID = sanitise(mysqli_real_escape_string($connect, $_REQUEST["GroupID"]));
$PostPrivacy = sanitise(mysqli_real_escape_string($connect, $_REQUEST["PostPrivacy"]));
$InReplyTo = sanitise(mysqli_real_escape_string($connect, $_REQUEST["ReplyTo"]));
$Flag = sanitise(mysqli_real_escape_string($connect, $_REQUEST["Flag"]));
$PostDate = sanitise(mysqli_real_escape_string($connect, $_REQUEST["PostDate"]));
$PostTime = sanitise(mysqli_real_escape_string($connect, $_REQUEST["PostTime"]));

if(!$PostDate) { $PostDate = date("Y-m-d"); }
if(!$PostTime) { $PostTime = date("H:i:s"); }  else { $PostTime .= ":" . date("s"); }

$GroupID = sanitise(mysqli_real_escape_string($connect, $_REQUEST['GroupID']));
$GroupSlug = sanitise(mysqli_real_escape_string($connect, $_REQUEST['GroupSlug']));

$timeStamp = sanitise(mysqli_real_escape_string($connect, $_REQUEST['timeStamp']));
$timeNow = time();
if(($timeNow - $timeStamp) > 2) { $timeOK = 1; } else { $timeOK = 0; } // if the form is filled in in under two seconds suspect botspam

if($PostContent AND $timeOK)
{
	if(!$InReplyTo)
	{
	$addDataSQL = $connect->prepare("INSERT INTO Posts (PostTitle,
	PostContent,
	PostUserID,
	GroupID,
	InReplyTo,
	PostPrivacy,
	PostDate,
	PostTime,
	ReplyDate,
	ReplyTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$addDataSQL->bind_param("ssiiiissss",
	$PostTitle,
	$PostContent,
	$UserID,
	$GroupID,
	$InReplyTo,
	$PostPrivacy,
	$PostDate,
	$PostTime,
	$PostDate,
	$PostTime);
	$addDataSQL->execute();
	$addDataSQL->close();
	}
	
	if($InReplyTo)
	{
		$NumReplies = 1; // make it the actual number in due course
		$UpdateDataSQL = $connect->prepare("UPDATE Posts SET NumReplies = ?, ReplyDate = ?, ReplyTime = ? WHERE PostID = ?");
		$UpdateDataSQL->bind_param("isss",
		$NumReplies,
		$PostDate,
		$PostTime,
		$InReplyTo);
		$UpdateDataSQL->execute();
		$UpdateDataSQL->close();

		$addDataSQL = $connect->prepare("INSERT INTO Replies (PostTitle,
		PostContent,
		PostUserID,
		GroupID,
		InReplyTo,
		PostPrivacy,	
		PostDate,
		PostTime,
		ReplyDate,
		ReplyTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$addDataSQL->bind_param("ssiiiissss",
		$PostTitle,
		$PostContent,
		$UserID,
		$GroupID,
		$InReplyTo,
		$PostPrivacy,
		$PostDate,
		$PostTime,
		$ReplyDate,
		$ReplyTime);	
		$addDataSQL->execute();
		$addDataSQL->close();	
		
		if($Flag == "newpost")
		{
			$copyDataSQL = $connect->prepare("INSERT INTO Posts SELECT * FROM Replies WHERE ReplyID = ?");
			$addDataSQL->bind_param("i", $InReplyTo);
			$copyDataSQL->execute();
			$copyDataSQL->close();
			
			$getPostSQL = $connect->prepare("SELECT PostID FROM Posts ORDER BY PostID DESC LIMIT 1");
			$getPostSQL->execute();
			$getPostSQL->store_result();
			$results = array();
			bind_all($getPostSQL, $results);
			while($getPostSQL->fetch())
			{
				$InReplyTo = $results['PostID'];
			}
			$getPostSQL->close();

			$addDataSQL = $connect->prepare("INSERT INTO Replies (PostTitle,
			PostContent,
			PostUserID,
			GroupID,
			InReplyTo,
			PostPrivacy,	
			PostDate,
			PostTime,
			ReplyDate,
			ReplyTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$addDataSQL->bind_param("ssiiiissss",
			$PostTitle,
			$PostContent,
			$UserID,
			$GroupID,
			$InReplyTo,
			$PostPrivacy,
			$PostDate,
			$PostTime,
			$ReplyDate,
			$ReplyTime);		
			$addDataSQL->execute();
			$addDataSQL->close();	
		}
	}	
}
$url = "/";
if($GroupID) { $url = "/group/" . $GroupID . "/" . $GroupSlug; }
header("Location: " . $url);
die();
?>