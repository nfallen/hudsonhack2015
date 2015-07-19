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
$date= $_POST['date'];
$recurring = $_POST['recurring'];
$location = $_POST['location'];
$num_meals = $_POST['num_meals'];

$STH = $DBH->prepare($store);
$STH->execute(array(':name' => $name, ':date' => $date, ':recurring' => $recurring, ':location' => $location, ':num_meals' => $num_meals));

echo "Successful insert";
?>
