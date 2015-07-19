<?php
require('creds.php');
require('queries.php');
require('validation.php');

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
if (test_zipcode($body)) {
	$statement = $DBH->prepare($getInfo);
    $lim = 4;
    $statement->bindParam(':zip', $body, PDO::PARAM_STR);
    $statement->bindParam(':lim', $lim, PDO::PARAM_INT);
	$statement->execute();
	$rows = $statement->fetchAll();
	foreach ($rows as $row) {
		$datetime_obj = DateTime::createFromFormat('Y-m-j H:i:s', $row['datetime']);
        $datetime = $datetime_obj->format('m/j/Y h:ia');
		$msg .= $datetime . " " . $row['street_address'] . ",\r\n";
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
