<?php
$url = 'https://petition.parliament.uk/petitions.json';
$JSON = file_get_contents($url);
$JSON = str_replace("'", "\'", $JSON);

$startPos = strpos($JSON, "signatures_by_country") + 23;
$endPos = strpos($JSON, "signatures_by_constituency") - 2;
$signaturesJSON = substr($JSON, $startPos, $endPos-$startPos);

$url = 'https://petition.parliament.uk/petitions/171928.json';
$JSON = file_get_contents($url);
$JSON = str_replace("'", "\'", $JSON);

$startPos = strpos($JSON, "signatures_by_country") + 23;
$endPos = strpos($JSON, "signatures_by_constituency") - 2;
$signaturesJSON = substr($JSON, $startPos, $endPos-$startPos);

$startPos = strpos($JSON, "attributes") + 12;
$endPos = strpos($JSON, "created_at") - 2;
$attributesJSON = "[" . substr($JSON, $startPos, $endPos-$startPos) ."}]";


$attributes = json_decode($attributesJSON);
$signatures = json_decode($signaturesJSON, true);

$total = $attributes[0]->signature_count;

// echo $attributesJSON;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title><?php echo $attributes[0]->action; ?></title>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/shared/style.css">
<link rel="stylesheet" href="/shared/mediaqueries.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="//code.jquery.com/jquery-latest.js"></script>
</head>
<body>
<div id="main">
  <h1><a href="https://petition.parliament.uk/petitions/171928" title="<?php echo $attributes[0]->action; ?>"><?php echo $attributes[0]->action; ?></a></h1>
  <p>
    <?php echo $attributes[0]->background; ?>
  </p>
  <div id="data">Loading...</div>
  <div id="count"></div>
<div id="piechart" style="width: 900px; height: 500px;"></div>
<div id="countries" style="-webkit-column-count: 4; -moz-column-count: 4;  column-count: 4;"></div>
</div>
<div id="colophon">
<p>
  Brought to you by <a href="http://about.me/simon.gray" title="About me - simon gray">simon gray</a>. If you like this, it'd be nice if you could have a listen to <a href="http://www.winterval.org.uk/" title="The Winterval Conspiracy">some of my music</a>.
</p>
</div>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Country', 'Signatures'],
<?php
$chartData = "";
foreach($signatures as $signature)
{
  if($signature['name'] == "United Kingdom") { $chartData .= "['" . $signature['name'] . "', " . $signature['signature_count'] . "],\r\n"; $uk = $signature['signature_count']; }
}
$rotw = $total-$uk;
$chartData .= "['Rest of the world', " . $rotw . "]";
echo $chartData;
?>
        ]);

        var options = {
          title: 'Signatures by country',
          backgroundColor: '#ddd6b9'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  <script>
function resumeRefresh()
{
	document.getElementById("count").innerHTML = "";
	loadCurves();
	$refreshing = setInterval(function(){loadCurves()}, 1000);
}
    $count = 0;
  function loadCurves(){
  $("#data").load("petitiondata");
	$count++;
	if($count == 600 ) { document.getElementById("count").innerHTML = "<p>Autorefresh paused: <button onClick='resumeRefresh();'>Resume</button></p>"; clearInterval($refreshing); $refreshing = 0; $count = 0; } // pauses autorefresh after 10 minutes / 600 refreshes
}
loadCurves();
$refreshing = setInterval(function(){loadCurves()}, 1000);
  </script>
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