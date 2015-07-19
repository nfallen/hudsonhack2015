<?php
require('creds.php');
require('queries.php');

// now greet the sender
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

//establish database connection
try {
	$DBH = new PDO("mysql:host=localhost;dbname=hudsonhack", $user, $pass);
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(PDOException $e) {
	echo $e->getMessage(); 
}

$msg = "";
$body = strtolower($_REQUEST['Body']);
if (strlen($body) === 5 && is_numeric($body)) {
	$statement = $DBH->prepare($getInfo);
	$statement->execute(array(':zip' => $body));
	$rows = $statement->fetchAll();
	foreach ($rows as $row) {
		$msg .= $row['datetime'] . " " . $row['street_address'] . ", ";
	}
	if ($msg === ""){
		$msg = "Sorry, there are no events in this zipcode at this time.";
	}
}
else {
	$msg = "You've messaged Wasteless. Send a message with your zipcode for food giveaways near you.";
}

?>
<Response>
	<Message><?php echo $msg?></Message>
</Response>
