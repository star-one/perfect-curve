 <div class="white-popup">
 <?php session_start();
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
$LoggedIn = $_SESSION['LoggedIn'];
$UserID = $_SESSION['UserID'];
$UserName = $_SESSION['UserName'];

$page = explode("/",$_SERVER['REQUEST_URI']);
$ID = mysqli_real_escape_string($connect, $page[2]);

$DateNow = date("Y-m-d");
$TimeNow = date("H:i:s");

$sql = "SELECT * FROM Posts INNER JOIN Users ON Posts.PostUserID = Users.UserID LEFT JOIN Groups ON Posts.GroupID = Groups.GroupID";

if($LoggedIn)
{
	$sql .= " LEFT JOIN Friendships ON Posts.PostUserID = Friendships.FriendID";
}

$sql .= " WHERE (PostDate < '$DateNow' OR (PostDate = '$DateNow' AND PostTime < '$TimeNow'))";

if($LoggedIn)
{
	$sql .= " AND ";
	$sql .= "(";
	$sql .= " (Posts.PostUserID = '$ID')";
//	$sql .= " OR (PostPrivacy < 2)"; we don't want to see any posts from people we're not following if we're logged in - sort out properly when group posts go in the stream
	$sql .= " OR (Friendships.UserID = $ID AND PostPrivacy < 4 )"; // only people following me can view; formerly AND PostPrivacy < 3 - changed whilst trying to work out the next commented out clause
	$sql .= " OR (Friendships.FriendID = $ID AND PostPrivacy = 3)"; // only people i'm following can view
	$sql .= ")";
//	$sql .= " AND (Posts.GroupID = 0)"; // this will be where group posts appearing in the stream will be done
}
else
{
	$sql .= " AND PostPrivacy = 0 AND ";
	$sql .= "(";
	$sql .= " (Posts.GroupID = 0)";
	$sql .= " OR (Groups.GroupPrivacy = 0)";
	$sql .= ")";
}
$sql .= " AND Posts.PostUserID = $ID ORDER BY PostDate DESC, PostTime DESC LIMIT 5";

$posts = mysqli_query($connect,$sql);

$heading = 0;
while($post = mysqli_fetch_array($posts))
{
	if(!$heading) { echo "<h1>Recent posts by " . unescape($post['UserName']) . "</h1>"; $heading = 1; }
	
	$ShowPost = 1;
	if($post['PostPrivacy'] == 3) // This is temporary until I work out the proper sql query above
	{
		if($UserID != $post['PostUserID']) { $ShowPost = 0; }
		$sql = "SELECT * FROM Friendships WHERE UserID = " . $post['PostUserID'] . " AND FriendID = $UserID";
		$privacies = mysqli_query($connect,$sql);
		while($privacy = mysqli_fetch_array($privacies))
		{
			$ShowPost = 1;
		}
	}
	if($ShowPost)
	{
		echo "<article id=\"post-" . unescape($post['PostID']) . "\">\r\n";
		echo "<h2 class=\"posttitle\">" . unescape($post['PostTitle']) . "</h2>\r\n";
		echo "<strong><em>" . $post['PostDate'] . ", " . $post['PostTime'] . "</em></strong><br />\r\n" . unescape($post['PostContent']);
		if($post['GroupID'] AND $Flag != "group")
		{
			echo "<br /><em>In group <strong>" . unescape($post['GroupName']) . "</strong></em>\r\n";
		}
 		echo "</article>\r\n\r\n";
	}
}
?>
</div>
