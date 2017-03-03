<?php
$page = explode("/",$_SERVER['REQUEST_URI']);
$headline = $page[2];

if (!$headline){
	// arrays of random words
	$verbs = array(
	"Ban",
	"Make"
	);

	// generate a random number with range of # of array elements
	$verbpos = rand(0,count($verbs)-1);
	// get the quote
	$verb = $verbs[$verbpos];

	// generate a random number with range of # of array elements
	$pos = rand(0,count($prepositions)-1);
	// get the quote
	$preposition = $prepositions[$pos];

	$nouns = array(
	"kittens",
	"dolphins",
	"babies",
	"British comedy",
	"Canadian beer",
	"foreign language films",
	"electronic music",
	"free-form jazz"
	);

	// generate a random number with range of # of array elements
	$pos = rand(0,count($nouns)-1);
	// get the quote
	$noun = $nouns[$pos];

	if(!$verbpos)
	{
		$outcomes = array(
		"entering the USA",
		);
	}
	else
	{
		$outcomes = array(
		"leave the USA",
		"from the USA",
		"illegal in the USA",
		"leave NATO"
		);		
	}

	// generate a random number with range of # of array elements
	$pos = rand(0,count($outcomes)-1);
	// get the quote
	$outcome = $outcomes[$pos];
	
	$headline = $verb . " " . $noun . " " . $outcome;
	
	// base64 encode it to make a url
	$urlheadline = base64_encode($headline);
}
else
{
$urlheadline = $headline;
$headline = base64_decode($headline);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title><?php echo $headline; ?> - Executive Order</title>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/shared/style.css">
<link rel="stylesheet" href="/shared/mediaqueries.css">
<script>
function makeHeadline(theheadline)
{
	headline = window.btoa(theheadline);
	theurl = "http://www.perfect-curve.co.uk/donald/" + headline;
	window.location.assign(theurl)
}
</script>
</head>
<body>
<div id="main">
<h1>Hear Ye! Hear Ye! Hear Ye!</h1>
<p>
The latest Executive Order signed by The President:
</p>

<div id="image"><img src="/generators/eo/<?php echo $urlheadline; ?>" alt="<?php echo $headline; ?>" /></div>
<div id="addyourown">
<p><em><a href="/donald" title="New Executive Order">Get the latest Executive Order</a>.</em></p>
<h2>Make your own Executive Order</h2>
<label for="theheadline">Order:</label><input type="text" name="theheadline" id="theheadline">
<button onClick="makeHeadline(theheadline.value);">Make Executive Order</button>
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