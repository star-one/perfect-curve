<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title>Which Birmingham constituency are you?</title>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/shared/style.css">
<link rel="stylesheet" href="/shared/mediaqueries.css">
      <script>
		questionNumber = 0;
		asked = "-";

      function nextQuestion() {
		questions = [
		'<p>Bore<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Whitby?</p>',
		'<p>Peaky Blinders<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Boon?</p>',
		'<p>Doctors<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">A Very Peculiar Practice?</p>',
		'<p>Snobs<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">The Dome?</p>',
		'<p>The M6<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">the M40?</p>',
		'<p>Lenny Henry<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Frank Skinner?</p>',
		'<p>Sutton Park<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Cannon Hill Park?</p>',
		'<p>John Madin<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Francine Houben?</p>',
		'<p>New Street<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Snow Hill?</p>',
		'<p>Pigeon Park<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Lancaster Flyover?</p>',
		'<p>Rackhams<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Selfridges?</p>',
		'<p>Stirchley<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Moseley?</p>',
		'<p>Hemming<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Tilsley?</p>',
		'<p>Bore<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Howell?</p>',
		'<p>Whitby<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Brew?</p>',
		'<p>Alden<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Whitby?</p>',
		'<p>11<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">8?</p>',
		'<p>11a<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">11c?</p>',
		'<p>Moseley<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Kings Heath?</p>',
		'<p>Perry Barr<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Digbeth?</p>',
		'<p>Purnell\'s<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Mr Egg?</p>',
		'<p>Gay Quarter<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Chinese Quarter?</p>',
		'<p>Big John\'s<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">eat4less?</p>',
		'<p>Hustle<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Survivors?</p>',
		'<p>James Turner Street<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Broad Street?</p>',
		'<p>Broad Street<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">John Bright Street?</p>',
		'<p>Handsworth riots<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Priestley riots?</p>',
		'<p>Frank Skinner<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Jasper Carrott?</p>',
		'<p>ThinkTank<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Birmingham Museum of Science and Industry?</p>',
		'<p>Rackhams<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">House of Fraser?</p>',
		'<p>Pallasades<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Pavilions?</p>',
		'<p>Critical Mass<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Birmingham Super Prix?</p>',
		'<p>Hummingbird<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">O2 Academy?</p>',
		'<p>Queensway<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Middleway?</p>',
		'<p>UCE<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">BCU?</p>',
		'<p>University of Birmingham<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Birmingham City University?</p>',
		'<p>Soweto Kinch<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Andy Hamilton?</p>',
		'<p>Steel Pulse<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Musical Youth?</p>',
		'<p>ELO<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Black Sabbath?</p>',
		'<p>J R R Tolkein<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Reverend W Awdry?</p>',
		'<p>Boulton<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Watt?</p>',
		'<p>The Rotter\'s Club<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Felicia\'s Journey?</p>',
		'<p>Take Me High<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Sex Lives of the Potato Men?</p>',
		'<p>Pallasades<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Grand Central?</p>',
		'<p>Bull Ring<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Bullring?</p>',
		'<p>Hughes<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">Rogers?</p>',
		'<p>Birmingham City University<input type="radio" name="input" value="0" checked> or <input type="radio" name="input" value="1">City of Birmingham Polytechnic?</p>',
		];
		
		if(questionNumber < 10)
		{
		randomIndex = Math.floor(Math.random() * questions.length);
		checkq = "-" + randomIndex + "-";
			if(asked.indexOf(checkq) > -1)
			{
				nextQuestion();	
			}
			else
			{
				questionText = questions[randomIndex];
				questionNumber++;
				asked = "-" + randomIndex + asked;
			}
		}
		else
		{
		answers = [
		'Edgbaston!</strong></p><p>The lair of Gisela Stuart, you are one of the biggest towns in Western Europe, owned mostly by the Calthorpe-Anstruther-Gough-Winterbottom-Johnson-Smith family. A great battle was fought here many years ago in which the Jizzilla Monster fought and defeated Deirdre and her Shiny Army. You are an area of Birmingham containing more canals than Venice, and some folks say parts of you were part of the inspiration for Tolkein\'s Lord of the Rings.',
		'Erdington!</strong></p><p>The manor of Jack Dromey, you are sextaviamal in outlook, and the home of the Gravelly Hill Interchange - which has more road junctions than Venice and is said by some to have provided some of the inspiration for Tolkein\'s Lord of the Rings.',
		'Hall Green!</strong></p><p>The haunt of Roger Godsiff, you\'re never quite sure whether you\'re actually in Birmingham or want to be in Solihull. The location of Moseley - home of the famous Moseley Folk (which tends to have few folk acts) and Mostly Jazz (which tends to have few jazz acts) Festivals, you have a fiercely independent spirit, successfully seeing off an unwanted Tesco in favour of holding out for a Waitrose. You contain Sarehole Mill, said by some to be part of the inspiration for Tolkein\'s Lord of the Rings, and through part of you passes more canals than Venice.',
		'Hodge Hill!</strong></p><p>The baileywick of Liam Byrne, you are flatter than a pancake; the squeezed middle of the east of the city, you\'re in the unfortunately embarrassing position that nobody anywhere else in the city really knows where you are beyond \'just, kind of, over there, somewhere\'; some say parts of you became the inspiration for Tolkein\'s Lord of the Rings, and through a part of you winds more canals than Venice.',
		'Ladywood!</strong></p><p>The fiefdom of Shabana Mahmood, you just have to be the centre of everything. A noted glutton, you have gobbled up all nine of the city\'s historic quarters, but fortunately since many of the canals (of which Birmingham has more than Venice) flow through you, you\'ve got plenty of water to wash them all down with. Your most famous feature is said by many to have been Tolkein\'s inspiration for The Lord of the Rings.',
		'Northfield!</strong></p><p>The barony of Richard Burden, you are, erm, how can I put this delicately, erm, a little pasty looking. No sod it, I\'m just going to come right out and say it, you\'re downright white - <em>very</em> white. You are by far the whitest part of Birmingham. Some say your whiteness provided Tolkein with his inspiration for Saruman the White when he wrote The Lord of the Rings, but this assertion is as yet unproven. Even though none of Birmingham\'s canals pass through you, you are still part of the reason Birmingham has more canals than Venice.',
		'Perry Barr!</strong></p><p>The realm of Khalid Mahmood, you once were the home of the General Augusto Pinochet Church of the Virgin before it was demolished when the congregation realised that was a bit embarrassing. Home of Britain\'s first ever shopping centre, some say your One Stop provided some of the inspiration for Tolkein as he was writing The Lord of the Rings, and just across your thigh skirt more canals than can be found in Venice.',
		'Selly Oak!</strong></p><p>The duchy of Steve McCabe, you\'re rarely out of bed before 11am. An up and coming area of Birmingham, you also contain the villages of Stirchley and Cotteridge, widely held by many to be the jewels in Birmingham\'s crown of independent culture. It goes without saying that more canals than Venice wind right through your middle, and of course the Selly Oak New Road was instrumental in inspiring Tolkein as he conceived the journeys in The Lord of the Rings.',
		'Sutton Coldfield!</strong></p><p>The dominion of Andrew Mitchell, you are a keen cyclist and classical scholar. Your flighty reputation is such that it is well known that whenever you arrive in a place you immediately want to leave it, resenting having gone there in the first place, and your fine park is said to have provided Tolkein with the inspiration for The Shire when he was writing The Lord of the Rings - a park so big that it holds within it more canals than Venice.',
		'Yardley!</strong></p><p>The former maison close of John Hemming, you were once a noted lover of cats until Jess Phillips moved in with her caravan. Your Hay Mills underpass is so tricky for pedestrians to negotiate that it inspired Tolkein for the Stairs of Cirith Ungol when he was writing The Lord of the Rings, and of course close to your A45 road flows more canals than Venice.'
		];
		
		randomIndex = Math.floor(Math.random() * answers.length);
		questionText = "<p>Congratulations - you are <strong>"; 
		questionText += answers[randomIndex];
		questionText += "</p><h2>Share this</h2><p>To share this on <em>Twitter</em> or <em>Facebook</em>, move your cursor to the beginning of the text, click and hold and drag to the end of the text, let go of the button, select edit then copy from the menu at the top of your browser, and then paste into the box that says \'What\'s on your mind?\'.</p><p>To share this on <em>Instagram</em>, take your phone out of your back pocket, straighten it out, take a picture of the screen, and poke the Instagram button.</p>";
		questionNumber = 0;
		var txt=document.getElementById("theButton");
		txt.innerHTML="Try again!";
		asked = "-";
		}
		
		var txt=document.getElementById("question")
		txt.innerHTML=questionText;
		}
		</script>
	</head>
<body>
<div id="main">
<h1>Which Birmingham constituency are you?</h1>
	    <div id="question">
	    <p>Welcome to our 'which Birmingham constituency are you?' Internet Quiz! Simply answer a few questions and we'll be able to tell you which Birmingham constituency you are.</p>
	    <p>Let's go!</p>
	    </div>
	    <button id="theButton" onClick="nextQuestion()">Next</button>
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