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
$location = $_POST['location'];
$num_meals = $_POST['num_meals'];

$STH = $DBH->prepare($store);
$STH->execute(array(':name' => $name, ':date' => $datetime, ':recurring' => $recurring, ':location' => $location, ':num_meals' => $num_meals));

echo "Successful insert";
?>
