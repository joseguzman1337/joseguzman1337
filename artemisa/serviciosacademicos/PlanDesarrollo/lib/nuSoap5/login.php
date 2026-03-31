<?php
require_once('nusoap.php');
require_once('nsLib.php');

$client = new soapclientw('https://webservices.netsuite.com/services/NetSuitePort_2_0', false);

$result = login($client, $_POST['email'], $_POST['password'], $_POST['account'], $_POST['role']);

if ($result['sessionResponse']['status']['!isSuccess'])
{
$cookieStr = 'Cookies:<br>';
foreach ($client->cookies as $cookie)
{
        $cookieStr .= 'Cookie Name: ' . $cookie['name'] . '<br>Cookie Value: ' .$cookie['value'] . '<br><br>'; 
	setcookie($cookie['name'], $cookie['value']);
}
?>
<html><body>
<?php echo '<h2>Login Successful!</h2><br>' . '<br>';echo $cookieStr; ?>
<h4>Enter zip code you want to see leads in:</h4><br>
<form action="searchMap.php" method="post">
Zipcode to Search: <input name="zip" type="text" /><br>
<input type="submit" />
</form>
</body></html>
<?php
}
else
{
echo '<html><body>';
echo '<h2>Login FAILED</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
}

?>
</body></html>