

<html>
	<head>
	  <meta charset="utf-8">
	  <title>jQuery UI Datepicker - Default functionality</title>
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	  <link rel="stylesheet" href="jquery.ui.timepicker.css?v=0.3.3" type="text/css" />
	  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
	  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	  
    <script type="text/javascript" src="jquery.ui.timepicker.js?v=0.3.3"></script>

    <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
	  
	  <script>
	  $(function() {
	    $( "#datepicker" ).datepicker();
	    $( "#timepicker" ).timepicker();
	  });
	  </script>
 	</head>
 	<body>
	 <form action="submit.php" method="post">
			<div class="form-item"> 
				Name of Organization: <input type="text" name="name" /> 
			</div>
			<div class="form-item">	Location: 
				<input type="text" name="location" /> 
			</div>
			<div class="form-item">	Date: 
				<input type="text" name='date' id="datepicker"> 
			</div>
			<div class="form-item">	Time: 
				<input type="text" name='time' id="timepicker"> 
			</div>
			<div class="form-item">	How often will this event occur? 
				<div class="radio-item"><input type="radio" name="recurring" value="one_time">One time</input></div>
				<div class="radio-item"><input type="radio" name="recurring" value="weekly">Daily</input></div>
				<div class="radio-item"><input type="radio" name="recurring" value="weekly">Weekly</input></div>
			</div>
			<div class="form-item">	How many people will you be able to feed?
				<input type="text" name="num_meals"> 
			</div>
			<div class="form-item"> Description: 
				<textarea name="comments" rows="10" cols="40"></textarea>
			</div>
			<div class="submit-btn"> <input type="submit" value="Submit"></div>
		</form>
 </body>
</html>