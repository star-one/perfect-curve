<div id="grouplist">
<?php
$sql = "SELECT * FROM Groups INNER JOIN GroupCategories ON Groups.GroupCategoryID = GroupCategories.GroupCategoryID INNER JOIN GroupMembers ON Groups.GroupID = GroupMembers.GroupID WHERE UserID = '$UserID' ORDER BY GroupName DESC";
	
$groups = mysqli_query($connect,$sql);
while($group = mysqli_fetch_array($groups))
{
	echo "<article id=\"group-" . unescape($group['GroupID']) . "\">\r\n";
	echo "<h2 class=\"groupname\"><a href=\"/group/" . $group['GroupID'] . "/" . slugify($group['GroupName']) . "\" title=\"" . unescape($group['GroupName']) . "\">" . unescape($group['GroupName']) . "</a></h2>\r\n";
	echo "<p>" . unescape($group['GroupDescription']) . "<br /><em>In category <strong>" . unescape($group['GroupCategoryName']) . "</strong></em> - ";
	echo "<a href=\"/dashboard/leave/" . $group['GroupID'] . "\" title=\"Leave " . unescape($group['GroupName']) . "\">Leave group</a></p>"; 
	echo "</p>\r\n</article>\r\n\r\n";
}
?>
</div>
<div id="winterval">
	<article>
		Simon's choons go here
	</article>
</div>
