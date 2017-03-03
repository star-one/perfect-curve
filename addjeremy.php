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

$Headline = sanitise(mysqli_real_escape_string($connect, $_REQUEST["Headline"]));
$Summary = sanitise(mysqli_real_escape_string($connect, $_REQUEST["Summary"]));
$URL = sanitise(mysqli_real_escape_string($connect, $_REQUEST["URL"]));
$PubDate = sanitise(mysqli_real_escape_string($connect, $_REQUEST["PubDate"]));

if($Headline)
{
$addDataSQL = $connect->prepare("INSERT INTO Annoyances (Headline,
Summary,
URL,
PubDate) VALUES (?, ?, ?, ?)");
$addDataSQL->bind_param("ssss",
$Headline,
$Summary,
$URL,
$PubDate);
$addDataSQL->execute();
$addDataSQL->close();
	
$Ack = "<p><strong>Annoyance added!</strong></p>";
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
</head>
<body>
<div id="main">
<h1>Has Jeremy Corbyn annoyed the mainstream media today?</h1>
	    <div id="content">
	    <p>Has he annoyed them today? If so, add it here!</p>
		<?php echo $Ack; ?>
		<form name="addJeremy" id="addJeremy" action="addjeremy" method="post">
			<label for="Headline">Headline:</label><br />
			<input type="text" name="Headline" id="Headline" required /><br />
			<label for="Summary">Summary:</label><br />
			<textarea name="Summary" id="Summary"></textarea><br />
			<label for="URL">URL:</label><br />
			<input type="text" name="URL" id="URL" /><br />
			<label for="PubDate">Publication date:</label><br />
			<input type="date" name="PubDate" id="PubDate" value="<?php echo date("Y-m-d"); ?>" /><br />
			<input type="submit" id="Submit" value="Add an annoyance!" />
		</form>
	    </div>
</div>
<div id="colophon">
<p>
Brought to you by <a href="http://about.me/simon.gray" title="About me - simon gray">simon gray</a>, fr teh lolz. If you like this, it'd be nice if you could have a listen to <a href="http://www.winterval.org.uk/" title="The Winterval Conspiracy">some of my music</a>.
</p>
</div>
</body>
</html>