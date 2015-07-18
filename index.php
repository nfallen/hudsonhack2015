

<html>
	<head>
	  <meta charset="utf-8">
	  <title>jQuery UI Datepicker - Default functionality</title>
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
	  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	  <script>
	  $(function() {
	    $( "#datepicker" ).datepicker();
	  });
	  </script>
 	</head>
 	<body>
	 <?php 
	 	echo '<p>Hello World</p>';
	 ?> 
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
			<div class="form-item"> Description: 
				<textarea name="comments" rows="10" cols="40"></textarea>
			</div>
			<div class="submit-btn"> <input type="submit" value="Submit"></div>
		</form>
 </body>
</html>