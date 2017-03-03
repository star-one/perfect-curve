<script src="/shared/jquery-ias.min.js"></script>
<!-- Infinite scroll by http://infiniteajaxscroll.com/ -->

<div id="posts">
		
<?php
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
 /*       $content = "
        <p>Have a laugh...</p>
        http://youtu.be/dMH0bHeiRNg
        <p>Hahahaha, awesome!</p>
        <p>Want to learn something interesting?</p>
        https://flic.kr/p/tMwZbN
        <p>Something else perhaps?</p>
        http://vimeo.com/62571137
        <p>Maybe music is more your style?</p>
        https://soundcloud.com/nanaperadze/f-chopin-dernier-nocturne
        <p>A stylized photo could be just the ticket.</p>
        http://instagram.com/p/BUG/
        <p>Now that's easy.</p>
        ";
        echo '<h2>Before</h2>';
        echo '<pre>'.htmlspecialchars($content, ENT_QUOTES, 'UTF-8').'</pre>';
        echo '<h2>After</h2>';
        require 'shared/autoembed.php';
        $autoembed = new AutoEmbed();
        $content = $autoembed->parse($content);
        echo $content;
*/

function hashtag($text)
{
	$text = str_replace("<p>#", "<p> #", $text);
	$text = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="/tag/$1">#$1</a>', $text);
  return $text;
}

$DateNow = date("Y-m-d");
$TimeNow = date("H:i:s");

$sqlStart = "SELECT * FROM Posts INNER JOIN Users ON Posts.PostUserID = Users.UserID LEFT JOIN Groups ON Posts.GroupID = Groups.GroupID";
$sqlFollowing = " LEFT JOIN Friendships ON Posts.PostUserID = Friendships.FriendID LEFT JOIN GroupMembers ON Posts.GroupID = GroupMembers.GroupID";
$sqlGroupMembership = ""; // this might be the place to handle group memberships
$sqlPastPosts =  "(PostDate < '$DateNow' OR (PostDate = '$DateNow' AND PostTime < '$TimeNow'))";

$sqlLoggedInStream .= "(";
$sqlLoggedInStream .= " (Posts.PostUserID = '$UserID')";
//	$sqlLoggedInStream .= " OR (PostPrivacy < 2)"; we don't want to see any posts from people we're not following if we're logged in - sort out properly when group posts go in the stream
$sqlLoggedInStream .= " OR (Friendships.UserID = $UserID AND Posts.PostPrivacy < 4 )"; // only people following me can view; formerly AND PostPrivacy < 3 - changed whilst trying to work out the next commented out clause
$sqlLoggedInStream .= " OR (Friendships.FriendID = $UserID AND Posts.PostPrivacy = 3)"; // only people i'm following can view
$sqlLoggedInStream .= " OR (Groups.GroupPrivacy < 2)"; // lets anybody see unprivate group posts; add another line for members of private groups
$sqlLoggedInStream .= " OR (GroupMembers.UserID = $UserID AND Groups.GroupID = Posts.GroupID)";
$sqlLoggedInStream .= ")";
//	$sqlLoggedInStream .= " AND (Posts.GroupID = 0)"; // this will be where group posts appearing in the stream will be done

$sqlNotLoggedInStream = "(";
$sqlNotLoggedInStream .= " (Posts.PostPrivacy = 0 AND Posts.GroupID = 0)";
$sqlNotLoggedInStream .= " OR (Groups.GroupPrivacy = 0 AND Posts.PostPrivacy < 3)";
$sqlNotLoggedInStream .= ")";

if(!$LoggedIn)
{
	$sql = $sqlStart . " WHERE " . $sqlPastPosts . " AND " . $sqlNotLoggedInStream;
}
if($LoggedIn)
{
	$sql = $sqlStart . $sqlFollowing . " WHERE " . $sqlPastPosts . " AND " . $sqlLoggedInStream;
}

if($Flag == "group")
{
	$sql .= " AND ";
	$sql .= "(";
	$sql .= "Posts.GroupID = '$ID' ";
	$sql .= ")";
}

if($Flag == "post")
{
	$sql .= " AND (Posts.PostID = '$ID') ";
}

if($Flag == "tag")
{
	$sql .= " AND (Posts.PostContent LIKE '%#" . $ID . "%') ";
}

$sql .= " GROUP BY Posts.PostID ORDER BY Posts.ReplyDate DESC, Posts.ReplyTime DESC";
$posts = mysqli_query($connect,$sql);
$numrows = mysqli_num_rows($posts);

// Pagination adapted from http://stackoverflow.com/questions/3705318/simple-php-pagination-script
// number of rows to show per page
$rowsperpage = 10;
// find out total pages
$totalpages = ceil($numrows / $rowsperpage);

// get the current page or set a default
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
   // cast var as int
   $currentpage = (int) $_GET['page'];
} else {
   // default page num
   $currentpage = 1;
} // end if

// if current page is greater than total pages...
if ($currentpage > $totalpages) {
   // set current page to last page
   $currentpage = $totalpages;
} // end if
// if current page is less than first page...
if ($currentpage < 1) {
   // set current page to first page
   $currentpage = 1;
} // end if

// the offset of the list, based on current page 
$offset = ($currentpage - 1) * $rowsperpage;

$sql .= " LIMIT $offset, $rowsperpage";

$posts = mysqli_query($connect,$sql);
while($post = mysqli_fetch_array($posts))
{
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
		echo "<article ";
//		if(strlen($post['PostContent']) < 800) { echo "style=\"column-width: initial; -webkit-column-width: initial; -moz-column-width: initial\" "; }
		echo "id=\"post-" . unescape($post['PostID']) . "\" class=\"post\">\r\n";
		echo "<div class=\"article-header\">\r\n";
		echo "<img src=\"" . get_gravatar($post['UserEmail'], 50) . "\" alt=\"\" class=\"gravatar\" /><h2 class=\"posttitle\">" . unescape($post['PostTitle']) . "</h2>\r\n";
		echo "<strong><a href=\"/miniprofile/" . $post['PostUserID'] . "\" class=\"popup\">" . unescape($post['UserName']) . "</a></strong> - <em><a href=\"/post/" . $post['PostID'] . "/" . slugify($post['PostTitle']) . "\">" . $post['PostDate'] . ", " . $post['PostTime'] . "</a></em>";
/* 		if($LoggedIn) { echo " - <a href=\"/reply/" . $post['PostID'] . "/" . $post['GroupID'] . "\" class=\"popup\">Reply</a>"; } else { echo " - <a href=\"/login\">Login to reply</a>"; } */
		if($post['PostTitle']) { echo "</div>\r\n"; }
		echo hashtag(unescape($post['PostContent']));
		if($post['NumReplies'])
		{
			$InReplyTo = $post['PostID'];
			if(!$LoggedIn)
			{
				$sql = "SELECT * FROM Replies INNER JOIN Users ON Replies.PostUserID = Users.UserID WHERE " . $sqlPastPosts . " AND InReplyTo = $InReplyTo ORDER BY PostDate DESC, PostTime DESC";
			}
			if($LoggedIn)
			{
				$sql = "SELECT * FROM Replies INNER JOIN Users ON Replies.PostUserID = Users.UserID WHERE " . $sqlPastPosts . " AND InReplyTo = $InReplyTo ORDER BY PostDate DESC, PostTime DESC";
			}
			$replies = mysqli_query($connect,$sql);
			while($reply = mysqli_fetch_array($replies))
			{
				echo "<div class=\"reply\" id=\"reply-" . unescape($reply['ReplyID']) . "\">\r\n";
				echo "<img src=\"" . get_gravatar($reply['UserEmail'], 50) . "\" alt=\"\" class=\"gravatar\" /><h2 class=\"posttitle\">" . unescape($reply['PostTitle']) . "</h2>\r\n";
				echo "<strong><a href=\"/miniprofile/" . $reply['PostUserID'] . "\" class=\"popup\">" . unescape($reply['UserName']) . "</a></strong> - <em>" . $reply['PostDate'] . ", " . $reply['PostTime'] . "</em>";
				if($LoggedIn) { echo " - <a href=\"/reply/" . $reply['ReplyID'] . "/" . $reply['GroupID'] . "/newpost\" class=\"popup\">Reply</a>"; }
				echo "<br />\r\n" . hashtag(unescape($reply['PostContent'])) . "</div>";
			}

		}
		if($post['GroupID'] AND $Flag != "group")
		{
			echo "<em>In group <strong><a href=\"/group/" . $post['GroupID'] . "/" . slugify(unescape($post['GroupName'])) . "\" title=\"". unescape($post['GroupName']) . "\">" . unescape($post['GroupName']) . "</a></strong></em>\r\n";
		}
		if(!$post['PostTitle']) { echo "</div>\r\n"; }
		echo "</article>\r\n\r\n";
	}
}

/******  build the pagination links ******/
// range of num links to show
$range = 10;
echo "<div id=\"pagination\">\r\n";
// if not on page 1, don't show back links
if ($currentpage > 1) {
   // show << link to go back to page 1
   echo " <a href='?page=1'>first</a> / ";
   // get previous page num
   $prevpage = $currentpage - 1;
   // show < link to go back to 1 page
   echo " <a href='{?page=$prevpage' class='previous'>previous</a> ";
} // end if 

// loop to show links to range of pages around current page
for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
   // if it's a valid page number...
   if (($x > 0) && ($x <= $totalpages)) {
      // if we're on current page...
      if ($x == $currentpage) {
         // 'highlight' it but don't make a link
         echo " [<b>$x</b>] ";
      // if not current page...
      } else {
         // make it a link
         echo " <a href='?page=$x'>$x</a> ";
      } // end else
   } // end if 
} // end for

// if not on last page, show forward and last page links        
if ($currentpage != $totalpages) {
   // get next page
   $nextpage = $currentpage + 1;
    // echo forward link for next page 
   echo " <a href='?page=$nextpage' class='next'>next</a> / ";
   // echo forward link for lastpage
   echo " <a href='?page=$totalpages'>last</a> ";
} // end if
echo "</div>\r\n";
/****** end build pagination links ******/
?>
</div>
<script>
var ias = jQuery.ias({
  container:  '#posts',
  item:       '.post',
  pagination: '#pagination',
  next:       '.next'
});
// Add a loader image which is displayed during loading
ias.extension(new IASSpinnerExtension());
// Add a text when there are no more pages left to load
ias.extension(new IASNoneLeftExtension({text: "No more posts to load!"}));
// Add the page number and history extension
jQuery.ias().extension(new IASPagingExtension());
ias.extension(new IASHistoryExtension({
    prev: '.previous',
}));
</script>