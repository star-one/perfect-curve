<?php
$page = explode("/",$_SERVER['REQUEST_URI']);
$headline = $page[2];

if (!$headline){
	// arrays of random words
	$verbs = array(
	"FURY",
	"RAGE",
	"OUTRAGE",
	"OUTCRY",
	"SCANDAL",
	"SHOCK",
	"HORROR",
	"FRACAS",
	"SHAME",
	"ANGER",
	"SADNESS",
	"MAYHEM",
	"UPROAR",
	"TRAGEDY",
	"TRIBUTE"
	);

	// generate a random number with range of # of array elements
	$pos = rand(0,count($verbs)-1);
	// get the quote
	$verb = $verbs[$pos];

	$prepositions = array(
	"OVER",
	"FOR",
	"AFTER"
	);

	// generate a random number with range of # of array elements
	$pos = rand(0,count($prepositions)-1);
	// get the quote
	$preposition = $prepositions[$pos];

	$nouns = array(
	"CHILDREN'S",
	"COUNCIL",
	"LIBRARY",
	"TROMBONE",
	"BABY",
	"PARKING",
	"POTHOLE",
	"SHOP",
	"VICAR",
	"RABBI",
	"PRIEST",
	"CHURCH",
	"SYNAGOGUE",
	"SWIMMING POOL",
	"PARK",
	"LEISURE CENTRE",
	"CINEMA",
	"TEACHER",
	"HEAD",
	"SCHOOL",
	"SCHOOL HEAD",
	"CELEBRITY",
	"MIGRANT",
	"BALTI",
	"RAGMARKET",
	"MARKET",
	"HOUSING",
	"STATION",
	"CHIEF",
	"SECRET",
	"HOSPITAL",
	"MEAT PIE",
	"BEES",
	"POSTMAN",
	"VILLAGE",
	"CITY",
	"COUNCILLOR",
	"MP",
	"MUM",
	"DAD",
	"PAEDO",
	"TERRORIST",
	"SCROUNGER",
	"COPS"
	);

	// generate a random number with range of # of array elements
	$pos = rand(0,count($nouns)-1);
	// get the quote
	$noun = $nouns[$pos];

	$losses = array(
	"BENEFIT",
	"FUNDING",
	"FIGURES",
	"PROFIT",
	"AFFAIR",
	"STOLEN",
	"DECISION",
	"CLOSURE",
	"CLOSURES",
	"STRIKES",
	"CHAOS",
	"PARTY"
	);

	// generate a random number with range of # of array elements
	$pos = rand(0,count($losses)-1);
	// get the quote
	$loss = $losses[$pos];

	$actions = array(
	"LOSSES",
	"INCREASE",
	"CUTS",
	"CRASH",
	"CURSE",
	"SUCCESS",
	"MYSTERY",
	"FLING",
	"ATTACK",
	"CHAOS",
	"DEBACLE",
	"FRENZY"
	);

	// generate a random number with range of # of array elements
	$pos = rand(0,count($actions)-1);
	// get the quote
	$action = $actions[$pos];
	
	
	if(rand(0,1))
	{
		$headline = $verb . " " . $preposition . " " . $noun . " " . $loss . " " . $action;
	}
	else
	{
		$headline = $noun . " " . $loss . " " . $verb;
	}
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
<title><?php echo $headline; ?> - Breaking News</title>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/shared/style.css">
<link rel="stylesheet" href="/shared/mediaqueries.css">
<script>
function makeHeadline(theheadline)
{
	headline = window.btoa(theheadline);
	theurl = "http://www.perfect-curve.co.uk/headlines/" + headline;
	window.location.assign(theurl)
}
</script>
</head>
<body>
<div id="main">
<h1>Breaking News - Extra! Extra! Read All About It!</h1>
<p>
This just in from our correspondent:
</p>

<div id="image"><img src="/generators/headline/<?php echo $urlheadline; ?>" alt="<?php echo $headline; ?>" /></div>
<div id="addyourown">
<p><em><a href="/headlines/<?php echo $urlheadline; ?>" title="<?php echo $headline; ?>">URL for this image</a></em> or <em><a href="/headlines" title="New headline">get the latest breaking news</a>.</em></p>
<h2>Make your own headline</h2>
<label for="theheadline">Headline:</label><input type="text" name="theheadline" id="theheadline">
<button onClick="makeHeadline(theheadline.value);">Make headline</button>
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