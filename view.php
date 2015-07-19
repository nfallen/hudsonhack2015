<?php
require('creds.php');
require('queries.php');
require('validation.php');

$emptymsg = $list_events = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    $DBH = new PDO("mysql:host=localhost;dbname=hudsonhack", $user, $pass);
    $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  }
  catch(PDOException $e) {
    echo $e->getMessage(); 
  }
  $zip = test_input($_POST['zipcode']);
  if (test_zipcode($zip)) {
    $statement = $DBH->prepare($getInfo);
    $lim = 20;
    $statement->bindParam(':zip', $zip, PDO::PARAM_STR);
    $statement->bindParam(':lim', $lim, PDO::PARAM_INT);
    $statement->execute();
    $rows = $statement->fetchAll();
    if ($rows) {
      $list_events .= '<ul class="list-events">';
      $list_events .= '<li class="event-item">' . 
                        '<h3 class="event-item-header" id="search-zip-title">' .
                        'Zipcode: ' . $zip . 
                        '</h3>' . '</li>';
      foreach ($rows as $row) {
        $datetime_obj = DateTime::createFromFormat('Y-m-j H:i:s', $row['datetime']);
        $datetime = $datetime_obj->format('l M j, Y g:i A');
        $meal_string = $row['num_meals'] === 1 ? 'meal available' : 'meals available';
        $list_events .= '<li class="event-item">' . 
                        '<h3 class="event-item-header">' . $row['name'] . '</h3>' . $row['street_address'] . ' ' .
                        '</br>' . $datetime .
                        '</br>' . $row['num_meals'] . ' meals available' . '</li>';
      }
      $list_events .= '</ul>';

    }
    else {
      $emptymsg = '<div class="no-events">Sorry, there are no upcoming events in this zipcode at this time.</div>';
    }
  }
  else {
    $emptymsg = '<div class="no-events">Invalid zipcode</div>';
  }
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
</head>
<body>
  <header class="main-header clearfix">
      <h1 class="title">WASTELESS</h1>
  </header>
  <div class="spacer"></div>
  <div class="find-container">
    <h1 class="find-title">FIND FOOD NEAR ME</h1>
    <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <input type="text" class="form-control" id="zipcode-search" placeholder="Zipcode" name="zipcode" maxlength="5">
        <button type="submit" class="btn btn-primary search-submit">SEARCH</button>
        <a href="/index.php" class="btn btn-primary search-submit">HOME</a>
        <?php echo $list_events ?>
        <?php echo $emptymsg ?>
    </form>
  </div>
</body>
</html>