<?php
// Path to our font file
$font = 'Chalk-hand-lettering-shaded_demo.ttf';
$fontsize = 13;

$page = explode("/",$_SERVER['REQUEST_URI']);
$caption = $page[3];

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
	"snails"
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
	"dreams",
	"the points"
	);

	// generate a random number with range of # of array elements
	$pos = rand(0,count($nouns)-1);
	// get the quote
	$noun = $nouns[$pos];

	$caption = "Delay caused by " . $excuse . " " . $preposition . " " . $noun . ".";
}
else
{
	$caption = base64_decode($caption);
}

// create a bounding box for the text
$dims = imagettfbbox($fontsize, 0, $font, $caption);

// make some easy to handle dimension vars from the results of imagettfbbox
// since positions aren't measures in 1 to whatever, we need to
// do some math to find out the actual width and height
$width = $dims[4] - $dims[6]; // upper-right x minus upper-left x 
$height = $dims[3] - $dims[5]; // lower-right y minus upper-right y

$caption = wordwrap($caption,30);

// Create image and add attribution
$image = imagecreatefromjpeg("london-midland.jpg");

// pick color for the background
$bgcolor = imagecolorallocate($image, 100, 100, 100);
// pick color for the text
$fontcolor = imagecolorallocate($image, 255, 216, 61 );

// fill in the background with the background color
//imagefilledrectangle($image, 0, 0, $width, $height, $bgcolor);

// x,y coords for imagettftext defines the baseline of the text: the lower-left corner
// so the x coord can stay as 0 but you have to add the font size to the y to simulate
// top left boundary so we can write the text within the boundary of the image
$x = 115; 
$y = $fontsize+337;
$angle = 0;
imagettftext($image, $fontsize, $angle, $x, $y, $fontcolor, $font, $caption);

// tell the browser that the content is an image
header('Content-type: image/jpg');
// output image to the browser
imagejpeg($image);

// delete the image resource 
imagedestroy($image);
?>