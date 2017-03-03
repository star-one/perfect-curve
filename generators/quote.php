<?php
// Path to our font file
$font = 'LaurenScript.ttf';
$fontsize = 14;

$page = explode("/",$_SERVER['REQUEST_URI']);
$authorid = $page[3];
$quote = $page[4];

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
"There’s nothing you can do now",
"There’s no point fretting over it",
"You’re only going to make it worse by complaining",
"I don’t understand what all the fuss is about",
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
"They won't get there any quicker"
);
$authorid = rand(0,10);

// generate a random number with range of # of array elements
$pos = rand(0,count($quotes)-1);
// get the quote
$quote = $quotes[$pos];
}
else
{
$quote = base64_decode($quote);
}
$quote = wordwrap($quote,25);

// create a bounding box for the text
$dims = imagettfbbox($fontsize, 0, $font, $quote);

// make some easy to handle dimension vars from the results of imagettfbbox
// since positions aren't measures in 1 to whatever, we need to
// do some math to find out the actual width and height
$width = $dims[4] - $dims[6]; // upper-right x minus upper-left x 
$height = $dims[3] - $dims[5]; // lower-right y minus upper-right y

// Create image and add attribution
switch($authorid)
{
	case 0:
		$image = imagecreatefromjpeg("ghandi.jpg");
		$quote .= "\r\n\r\n- Mahatma Ghandi";
		break;
	case 1:
		$image = imagecreatefromjpeg("king.jpg");
		$quote .= "\r\n\r\n- Martin Luther King Jr";
		break;
	case 2:
		$image = imagecreatefromjpeg("caroline.jpg");
		$quote .= "\r\n\r\n- Caroline Lucas";
		break;
	case 3:
		$image = imagecreatefromjpeg("jeremy.jpg");
		if(!$page[5]) { $quote .= "\r\n\r\n- Jeremy Corbyn"; } // don't show his name if it's come from Has Jeremy Corbyn Annoyed the Mainstream Nedia Today?
		break;
	case 4:
		$image = imagecreatefromjpeg("nelson.jpg");
		$quote .= "\r\n\r\n- Nelson Mandela";
		break;
	case 5:
		$image = imagecreatefromjpeg("albert.jpg");
		$quote .= "\r\n\r\n- Albert Einstein";
		break;
	case 6:
		$image = imagecreatefromjpeg("dalai.jpg");
		$quote .= "\r\n\r\n- His Holiness\r\nthe Dalai Lama";
		break;
	case 7:
		$image = imagecreatefromjpeg("malala.jpg");
		$quote .= "\r\n\r\n- Malala Yousafzai";
		break;
	case 8:
		$image = imagecreatefromjpeg("kiri.jpg");
		$quote .= "\r\n\r\n- Dame Kiri Te Kanawa";
		break;
	case 9:
		$image = imagecreatefromjpeg("hillary.jpg");
		$quote .= "\r\n\r\n- Sir Edmund Hillary";
		break;
	case 10:
		$image = imagecreatefromjpeg("lincoln.jpg");
		$quote .= "\r\n\r\n- Abraham Lincoln";
		break;
}

// pick color for the background
$bgcolor = imagecolorallocate($image, 100, 100, 100);
// pick color for the text
$fontcolor = imagecolorallocate($image, 47, 56, 60 );

// fill in the background with the background color
//imagefilledrectangle($image, 0, 0, $width, $height, $bgcolor);

// x,y coords for imagettftext defines the baseline of the text: the lower-left corner
// so the x coord can stay as 0 but you have to add the font size to the y to simulate
// top left boundary so we can write the text within the boundary of the image
$x = 320; 
$y = $fontsize+50;
imagettftext($image, $fontsize, 0, $x, $y, $fontcolor, $font, $quote);

// tell the browser that the content is an image
header('Content-type: image/jpg');
// output image to the browser
imagejpeg($image);

// delete the image resource 
imagedestroy($image);
?>