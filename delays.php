<?php
$page = explode("/",$_SERVER['REQUEST_URI']);
$caption = $page[2];

if (!$caption){
	// arrays of random words
	$excuses = array(
	"a failure",
	"the wrong kind",
	"the driver",
	"a problem",
	"snow",
	"leaves",
	"the sun",
	"the moon",
	"wind",
	"rain",
	"cats",
	"babies",
	"pedestrians",
	"trespassers",
	"a lack",
	"a reduction",
	"an excess",
	"too many",
	"too much",
	"cows",
	"sheep",
	"goats",
	"snails",
	"crows",
	);

	// generate a random number with range of # of array elements
	$pos = rand(0,count($excuses)-1);
	// get the quote
	$excuse = $excuses[$pos];

	$prepositions = array(
	"of",
	"on"
	);

	// generate a random number with range of # of array elements
	$pos = rand(0,count($prepositions)-1);
	// get the quote
	$preposition = $prepositions[$pos];

	$nouns = array(
	"lineside equipment",
	"signalling",
	"the line",
	"the driver",
	"snow",
	"leaves",
	"wind",
	"rain",
	"the sun",
	"the moon",
	"the economy",
	"cats",
	"the toilet",
	"the government",
	"the council",
	"HS2",
	"the rampage",
	"excuses",
	"your dreams",
	"the points",
	"the overhead cabling",
	);

	// generate a random number with range of # of array elements
	$pos = rand(0,count($nouns)-1);
	// get the quote
	$noun = $nouns[$pos];

	$caption = "Delay caused by " . $excuse . " " . $preposition . " " . $noun . ".";
}
else
{
$urlcaption = $caption;
$caption = base64_decode($caption);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title><?php echo $caption; ?> - London Midland Excuses</title>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/shared/style.css">
<link rel="stylesheet" href="/shared/mediaqueries.css">
<script>
function makeCaption(thecaption)
{
	caption = window.btoa('Delay caused by ' + thecaption + '.');
	theurl = "http://www.perfect-curve.co.uk/delays/" + caption;
	window.location.assign(theurl)
}
</script>
</head>
<body>
<div id="main">
<h1>The train has been delayed</h1>
<p>
We're very, sorry, for the inconvenience.
</p>

<div id="image"><img src="/generators/excuse/<?php echo $urlcaption; ?>" alt="<?php echo $caption; ?>" /></div>
<div id="addyourown">
<p><em><a href="/delays/<?php echo $urlcaption; ?>" title="<?php echo $caption; ?>">URL for this image</a></em> or <em><a href="/delays" title="New headline">get the latest excuse</a>.</em></p>
<h2>Make your own excuse</h2>
<label for="thecaption">Delay caused by...</label><input type="text" name="thecaption" id="thecaption">
<button onClick="makeCaption(thecaption.value);">Make excuse</button>
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