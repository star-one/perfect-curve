<?php
$page = explode("/",$_SERVER['REQUEST_URI']);
$authorid = $page[2];
$quote = $page[3];

if (!$quote){
// array of random quotes
$quotes = array(
"That was a lovely cup of tea",
"Is it bin day tomorrow?",
"I love a good roast potato",
"See the match last night?",
"Excuse me, can you tell me where the nearest toilet is please?",
"Those roast potatoes were perfect",
"I'd like a first class stamp, please",
"Quite a nice day today, isn't it?",
"Where is the train station?",
"Are we nearly there yet?",
"I think it might rain later",
"There's nothing you can do about it now",
"There's no point in crying over spilt milk",
"There's no point fretting over it",
"You're only going to make it worse by complaining",
"I don't understand what all the fuss is about",
"Someday the shoe will be on the other foot",
"I might join you later",
"Excuse me, is anybody sitting there?",
"Bit wet out there",
"Right then, I suppose I really should start thinking about going",
"Not too bad, actually",
"It could be worse",
"Each to their own",
"Pop round anytime",
"I'm just going to the shop, does anybody want anything?",
"They won't get there any quicker",
"My feet are killing me",
"Is it lunchtime yet",
"I can't be bothered with that",
"My underpants are slipping down in this",
"Has the cat been fed today?",
"I'm a bit peckish"
);

// generate the random author
$authorid = rand(0,10);
// generate a random number with range of # of array elements to choose the quote
$pos = rand(0,count($quotes)-1);
// get the quote
$quote = $quotes[$pos];
// base64 encode it to make a url
$urlquote = base64_encode($quote);
}
else
{
$urlquote = $quote;
$quote = base64_decode($quote);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title><?php echo $quote; ?> - Inspiring words from inspiring people</title>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/shared/style.css">
<link rel="stylesheet" href="/shared/mediaqueries.css">
<script>
function makeQuote(thequote, theauthor)
{
	quote = window.btoa(thequote);
	author = theauthor;
	theurl = "http://www.perfect-curve.co.uk/inspiration/" + author + "/" + quote;
	window.location.assign(theurl)
}
</script>
</head>
<body>
<div id="main">
<h1>Inspiring words from inspiring people</h1>
<p>
We all need a little inspiration from time to time. Let these words spoken by our heroes of old and great Leaders of Men get you through the day.
</p>

<div id="image"><img src="/generators/quote/<?php echo $authorid . "/" . $urlquote; ?>" alt="<?php echo $quote; ?>" /></div>
<div id="addyourown">
<p><em><a href="/inspiration/<?php echo $authorid . "/" . $urlquote; ?>" title="<?php echo $quote; ?>">URL for this image</a></em> or <em><a href="/inspiration" title="New inspiration">get some fresh inspiration</a>.</em></p>
<h2>Make your own quote</h2>
<label for="thequote">Quote:</label><input type="text" name="thequote" id="thequote">
<label for="theauthor"> by </label>
<select name="theauthor" id="theauthor">
<option value="0">Mahatma Ghandi</option>
<option value="1">Martin Luther King Jr</option>
<option value="2">Caroline Lucas</option>
<option value="3">Jeremy Corbyn</option>
<option value="4">Nelson Mandela</option>
<option value="5">Albert Einstein</option>
<option value="6">The Dalai Lama</option>
<option value="7">Malala Yousafzai</option>
<option value="8">Kiri Te Kanawa</option>
<option value="9">Sir Edmund Hillary</option>
<option value="10">Abraham Lincoln</option>
</select>
<button onClick="makeQuote(thequote.value, theauthor.value);">Make quote</button>
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