<?php
	header("content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	$t = date('l F jS h:i:s A')
	file_put_contents("dump.txt", $_REQUEST['Body']);
	$body = $_REQUEST['Body'];
?>
<Response>
	<Message>You messaged me: <?php echo $body?>.</Message>
</Response>
