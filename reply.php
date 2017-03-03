<div class="white-popup">
<?php session_start();
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);
$LoggedIn = $_SESSION['LoggedIn'];
$UserID = $_SESSION['UserID'];
$UserName = $_SESSION['UserName'];

$page = explode("/",$_SERVER['REQUEST_URI']);
$ID = sanitise(mysqli_real_escape_string($connect, $page[2]));
$GroupID = sanitise(mysqli_real_escape_string($connect, $page[3]));
$Flag = sanitise(mysqli_real_escape_string($connect, $page[4]));
?>
	<form id="reply-form" action="/postcurve" method="post">
	<h2>Reply</h2>
	<label for="PostTitle">Title:</label><br />
	<input type="text" name="PostTitle" id="PostTitle" /><br />
	<label for="PostContent">Post:</label><br />
	<script src="/ckeditor/ckeditor.js"></script>
	<textarea name="PostContent" id="PostContent" required></textarea><br />
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
		<option value="0"<?php if($DefaultPostPrivacy == 0) { echo " selected"; } ?>>Anybody browsing the site</option>
		<option value="1"<?php if($DefaultPostPrivacy == 1) { echo " selected"; } ?>>Public stream, only logged in users</option>
		<option value="2"<?php if($DefaultPostPrivacy == 2) { echo " selected"; } ?>>Public stream, your followers and friends</option>
		<option value="3"<?php if($DefaultPostPrivacy == 3) { echo " selected"; } ?>>Private stream, people you follow only</option>
		<option value="5"<?php if($GroupID) { echo " selected"; } ?>>Group privacy settings</option>
		<option value="4"<?php if($DefaultPostPrivacy == 4) { echo " selected"; } ?>>Secret - yourself only</option>
		</select><br />
	</div>
	<input type="hidden" name="timeStamp" value="<?php echo time(); ?>" />
	<input type="hidden" name="ReplyTo" value="<?php echo $ID; ?>" />
	<input type="hidden" name="Flag" value="<?php echo $Flag; ?>" />
	<input type="submit" value="Post Curve" />
	</form>
</div>