<?php
$page = explode("/",$_SERVER['REQUEST_URI']);
$headline = $page[2];

if (!$headline){
	// arrays of random words
	$words = array(
		"Racist liar",
		"Racist arse",
		"Lying idiot",
		"Racist idiot",
		"Bell-end racist",
		"Lying xenophobe",
		"Racist bell-end",
		"Lying bell-end",
		"Lying tool",
		"Racist knob",
		"Lying knob"
	);

	// generate a random number with range of # of array elements
	$wordpos = rand(0,count($words)-1);
	// get the quote
	$word = $words[$wordpos];
	
	$headline = $word;
	
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
<title><?php echo $headline; ?> - Nigel in the European Parliament</title>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/shared/style.css">
<link rel="stylesheet" href="/shared/mediaqueries.css">
<script>
function makeHeadline(theheadline)
{
	headline = window.btoa(theheadline);
	theurl = "https://www.perfect-curve.co.uk/nigel/" + headline;
	window.location.assign(theurl)
}
</script>
</head>
<body>
<div id="main">
<h1>He's lying to you!</h1>
<p>
The latest sign for Nigel Farage:
</p>

<div id="image"><img src="/generators/nigelsign/<?php echo $urlheadline; ?>" alt="<?php echo $headline; ?>" /></div>
<div id="addyourown">
<p><em><a href="/nigel" title="New Executive Order">Get the latest Nigel sign</a>.</em></p>
<h2>Make your own Nigel sign</h2>
<label for="theheadline">Sign:</label><input type="text" name="theheadline" id="theheadline">
<button onClick="makeHeadline(theheadline.value);">Make Nigel sign</button>
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