<html>
  <head>
  </head>
  <body>  
<?php
include "BambooHR/API/API.php";
use \BambooHR\API\BambooAPI as BHR;


$api = new BHR("quadrotech");

$api->setSecretKey('d3f65ab599205f8efb5d3b7ff25d50133099b5e4');


$authenticated = $api->login('d3f65ab599205f8efb5d3b7ff25d50133099b5e4', 'wayne.humphrey@quadrotech-it.com', 'tPEbbiRkqocxavwKek3urUMe');
echo "<hr>Auth done <hr>";


$response = $api->getDirectory();

if($response->isError()) {
   trigger_error("Error communicating with BambooHR: " . $response->getErrorMessage());
}

$xml = $response->getContent();

//echo $xml->asXML();
echo $xml->employees->employee[0]->field[0];

?>
</body>
</html>