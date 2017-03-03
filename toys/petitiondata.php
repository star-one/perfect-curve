<?php
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

// echo $attributesJSON;
?>
  <p>
    Total signatures: <strong><?php echo $attributes[0]->signature_count; ?></strong>
  </p>
<?php
$countries = "";
foreach($signatures as $signature)
{
  $countries .= $signature['name'] . ": " . $signature['signature_count'] . "<br />";
}
?>
<script>
document.getElementById("countries").innerHTML = "<?php echo $countries; ?>";
</script>
