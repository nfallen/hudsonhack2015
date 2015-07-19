<?php
require('creds.php');
require('queries.php');

try {
	$DBH = new PDO("mysql:host=localhost;dbname=hudsonhack", $user, $pass);
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(PDOException $e) {
	echo $e->getMessage(); 
}

$name = $_POST['name'];
$datetime = $_POST['date'] . ' ' . $_POST['time'] . ':00';
$recurring = $_POST['recurring'];
$street_address = $_POST['street_address'];
$zipcode = $_POST['zipcode'];
$num_meals = $_POST['quantity'];

error_log($_POST['time']);

$STH = $DBH->prepare($store);
$STH->execute(array(
	':name' => $name, 
	':datetime' => $datetime, 
	':recurring' => $recurring, 
	':street_address' => $street_address, 
	':zipcode' => $zipcode, 
	':num_meals' => $num_meals,
	));

echo "Successful insert";
?>
