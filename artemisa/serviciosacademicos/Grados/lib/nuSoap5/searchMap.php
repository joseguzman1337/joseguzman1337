<?php
// Pull in the NuSOAP code
require_once('nusoap.php');
require_once('nsLib.php');
require_once('phoogle.php');

$client = new soapclientw('https://webservices.netsuite.com/services/NetSuitePort_2_0', false);
foreach ($_COOKIE as $cName => $cValue)
	$client->setCookie($cName, $cValue);

$zip = $_POST['zip'];
$zipSF = new nsSearchField('SearchStringField','zipCode','is', $zip);
$zipSB = new nsSearchBasic('CustomerSearchBasic', array($zipSF));
$result = searchBasic ($client, $zipSB, 10, false);



$map = new PhoogleMap();
$map->setAPIKey("ABQIAAAAk_MnI0RS_5O9S_MVWFZMURSSAzFK-n-8maDN5TKAEWAU9Uz6YBRyBq34dP1_nYUEFgc0WffOVw3H4A");

    //customization options are here
    $map->zoomLevel = 3;             //zoom in as far as we can
    $map->setWidth(1024);            //pixels
    $map->setHeight(768);           //pixels
    $map->controlType = 'large';    //show large controls on the side
    $map->showType = false;         //hide the map | sat | hybrid buttons

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <?php $map->printGoogleJS(); ?>
   </head>
  <body>
  <?php
if ($result['searchResult']['totalRecords'] == 0)
{
  print 'No leads found in zip code ' . $zip;
}
else
{
  foreach ($result['searchResult']['recordList']['record'] as $lead)
  {
 	$addy = $lead['addressbookList']['addressbook']['addr1'];
	$zip = $lead['addressbookList']['addressbook']['zip'];
	$map->addAddress($addy . ', ' . $zip,
	    '<a href=\'https://system.netsuite.com/app/common/entity/custjob.nl?id=' . $lead['!internalId'] . '\'>' . $lead['entityId'] . '</a>' . '<br>' . $addy . ', ' . $zip); 
  }
  $map->showMap();
}

  ?>
</body>
</html>
