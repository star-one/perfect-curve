<?php
// Path to our font file
$font = 'typewriter.ttf';
$fontsize = 10;

$page = explode("/",$_SERVER['REQUEST_URI']);
$headline = $page[3];

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
	"TRIBUTE",
	"CHAOS"
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
	"ATTACK"
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
}
else
{
	$headline = base64_decode($headline);
}

// create a bounding box for the text
$dims = imagettfbbox($fontsize, 0, $font, $headline);

// make some easy to handle dimension vars from the results of imagettfbbox
// since positions aren't measures in 1 to whatever, we need to
// do some math to find out the actual width and height
$width = $dims[4] - $dims[6]; // upper-right x minus upper-left x 
$height = $dims[3] - $dims[5]; // lower-right y minus upper-right y

$headline = wordwrap($headline,15);

// Create image and add attribution
$image = imagecreatefromjpeg("donald.jpg");

// pick color for the background
$bgcolor = imagecolorallocate($image, 100, 100, 100);
// pick color for the text
$fontcolor = imagecolorallocatealpha($image, 0, 0, 0, 50 );

// fill in the background with the background color
//imagefilledrectangle($image, 0, 0, $width, $height, $bgcolor);

// x,y coords for imagettftext defines the baseline of the text: the lower-left corner
// so the x coord can stay as 0 but you have to add the font size to the y to simulate
// top left boundary so we can write the text within the boundary of the image
$x = 330; 
$y = $fontsize+190;
imagettftext($image, $fontsize, -7, $x, $y, $fontcolor, $font, $headline);

// tell the browser that the content is an image
header('Content-type: image/jpg');
// output image to the browser
imagejpeg($image);

// delete the image resource 
imagedestroy($image);
?>