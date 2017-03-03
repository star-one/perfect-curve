<?php
$ServerPath = $_SERVER['DOCUMENT_ROOT'];
$ServerPath .= "/shared/connexion.php";
include_once($ServerPath);

$host_name  = "db592556227.db.1and1.com";
$database   = "db592556227";
$user_name  = "dbo592556227";
$password   = "Tr1p1t4k4";

$connect = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title>Has Jeremy Corbyn annoyed the mainstream media today?</title>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/shared/style.css">
<link rel="stylesheet" href="/shared/mediaqueries.css">
<style>
h1 {
	font-size: 2em;
	line-height: 2em;
}
.yes {
    font-size: 1.5em;
    line-height: 1.3em;
    border: 1px solid #aaa;
    background: #efe;
    padding: 15px;
    margin-bottom: 15px;	
}
.yes h2 {
	font-size: 2em;
}
.no {
    border: 1px solid #aaa;
    background: #eee;
    padding: 15px;
    margin-bottom: 15px;	
}
.no h2 {
	font-size: 2em;
}
</style>
</head>
<body>
<div id="main">
<h1>Has Jeremy Corbyn annoyed the mainstream media today?</h1>
    <div id="content">
	<?php
	$stmt = $connect->prepare("SELECT * FROM Annoyances ORDER BY PubDate DESC");
//	$stmt->bind_param('i', $PostID);
	$stmt->execute();
	$stmt->store_result();
	$results = array();
	bind_all($stmt, $results);
	$firstone = 1;
	while($stmt->fetch())
	{
		if($results['PubDate'] == date("Y-m-d"))
		{
			echo "<div class=\"yes\" id=\"annoyance-" . $results['ID'] . "\">\r\n";
			if($firstone) { echo "<h2>Yes he has!</h2>"; }
		}
		else
		{
			echo "<div class=\"no\" id=\"annoyance-" . $results['ID'] . "\">\r\n";
			if($firstone) { echo "<h2>Not yet - but there's still time yet!</h2>"; }
		}
		echo "<strong><a href=\"" . $results['URL'] . "\" title=\"" . unescape($results['Headline']) . "\">" . unescape($results['Headline']) . "</a></strong> - <em>" . $results['PubDate'] . "</em><br />\r\n\r\n";
		echo "<p>" . unescape($results['Summary']) . "</p>\r\n\r\n";
		if($firstone) { echo "<img src=\"/generators/quote/3/" . base64_encode(unescape($results['Headline'])) . "/jeremy\" />\r\n\r\n"; $firstone = 0; }
		echo "</div>";
	}
	$stmt->close();
	?>
    </div>
</div>
<div id="colophon">
<p>
Brought to you by <a href="http://about.me/simon.gray" title="About me - simon gray">simon gray</a>, fr teh lolz. If you like this, it'd be nice if you could have a listen to <a href="http://www.winterval.org.uk/" title="The Winterval Conspiracy">some of my music</a>.
</p>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-18234627-8', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>