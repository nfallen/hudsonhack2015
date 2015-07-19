<?php
require('creds.php');
require('queries.php');
require('validation.php');
// define variables and set to empty values
$name = $date = $time = $num_meals = $street_address = $zipcode = $recurring = "";
$nameErr = $dateErr = $timeErr = $numMealsErr = $addressErr = $zipcodeErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = test_input($_POST['name']);
	if (!$name) {
		$nameErr = "Please enter a name.";
	}
	$date = test_input($_POST['date']);
	if (!$date) {
		$dateErr = "Please enter a date.";
	}
	$time = test_input($_POST['time']);	
	if (!$time) {
		$timeErr = "Please enter a time.";
	}
	$street_address = test_address($_POST['street_address']);
	if (!$street_address) {
		$addressErr = "Please enter a street address less than 40 characters.";
	}
	$zipcode = test_zipcode($_POST['zipcode']);
	if (!$zipcode) {
		$zipcodeErr = "Please enter a valid zipcode.";
	}
	$num_meals = test_num_meals($_POST['quantity']);
	if (!$num_meals) {
		$numMealsErr = "Please enter a valid number.";
	}

	$recurring = $_POST['recurring'];

	if (!($nameErr || $dateErr || $timeErr || $numMealsErr || $addressErr || $zipcodeErr)){
		submit($name, $date, $time, $num_meals, $street_address, $zipcode, $recurring, $store, $user, $pass);
		//TODO: give confirmation and clear form
	}

}

function submit($name, $date, $time, $num_meals, $street_address, $zipcode, $recurring, $store, $user, $pass){
	try {
		$DBH = new PDO("mysql:host=localhost;dbname=hudsonhack", $user, $pass);
		$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	catch(PDOException $e) {
		echo $e->getMessage(); 
	}

	$datetime_obj = DateTime::createFromFormat('j/m/Y H:i:s', $date . ' ' . $time . ':00');
	$datetime = $datetime_obj->format ('Y-j-m H:i:s');

	$STH = $DBH->prepare($store);
	$STH->execute(array(
		':name' => $name, 
		':datetime' => $datetime, 
		':recurring' => $recurring, 
		':street_address' => $street_address, 
		':zipcode' => $zipcode, 
		':num_meals' => $num_meals,
		)
	);
	header("Location: thanks.html");
}

?>
<html>
    <head>
      <meta charset="utf-8">
      <title>Wasteless</title>
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

	  <link rel="stylesheet" href="jquery.ui.timepicker.css?v=0.3.3" type="text/css" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="jquery.ui.timepicker.js?v=0.3.3"></script>

      <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,900' rel='stylesheet' type='text/css'>
      <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <link rel="stylesheet" type="text/css" href="style.css">  
      <script>
      $(function() {
        $( "#datepicker" ).datepicker();
        $( "#timepicker" ).timepicker();
        $(this).parents(".input-group-btn").find('.btn').text($(this).text());
        $(this).parents(".input-group-btn").find('.btn').val($(this).text());
        });
      </script>
    </head>
    <body>
    <header class="main-header clearfix">
        <h1 class="title">WASTELESS</h1>
    </header>
    <div class="spacer"></div>
    <div class= "login-wrap">
    <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
    <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    <a href="/view.php">View Events in My Zipcode</a><!-- <p>Food is wasted every hour of everyday, and we're going to change that.</p> -->
    </div>
    <div class= "login-wrap">  
        <div class="form">
             <form class="form-class" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <h2>SIGN UP TO DONATE FOOD</h2>
                        <div class="form-item"> 
                            <input type="text" class="form-control" placeholder="Name of Organization" value="<?php echo $name;?>" name="name" /> 
                            <span class="error"><?php echo $nameErr;?></span>
                        </div>
                        <div class="form-item">
                            <input type="text" class="form-control" placeholder="Street Address" value="<?php echo $street_address;?>" name="street_address" />
                            <span class="error"><?php echo $addressErr;?></span>
                        </div>
                        <div class="form-item">
                            <input type="text" class="form-control" placeholder="Zip Code" value="<?php echo $zipcode;?>" name="zipcode" /> 
                            <span class="error"><?php echo $zipcodeErr;?></span>
                        </div>
                        <div class="form-item"> 
                            <input type="text" class="form-control" placeholder="Date" value="<?php echo $date;?>" name='date' id="datepicker" />
                            <span class="error"><?php echo $dateErr;?></span> 
                        </div>
                        <div class="form-item">
                            <input type="text" class="form-control" placeholder="Time" value="<?php echo $time;?>" name='time' id="timepicker">                            
                            <span class="error"><?php echo $timeErr;?></span> 
                        </div>
                        <div class="form-item"> 
                            <input type="text" class="form-control" placeholder="Number of Meals" value="<?php echo $num_meals;?>" name="quantity">                            
                            <span class="error"><?php echo $numMealsErr;?></span>
                        </div>
                        <div class="dropdown">
                          <select name="recurring" value="<?php echo $recurring;?>">                      
                          <option value="0">One Time</option>
                          <option value="1">Daily</option>
                          <option value="2">Weekly</option>
                          <option value="3">Monthly</option>
                          </select>
                        </div>
                        
                        <!--<div class="submit-btn">
                        <button type="button" class="btn btn-success" value-"Submit">Success</button>
                        </div>-->
                        <div class="submit-btn"> <input type="submit" value="Submit"></div>
            </form>
        </div>    
    </div> 
 </body>
</html>

