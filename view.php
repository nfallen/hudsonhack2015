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
  if (strlen($zip) === 5 && is_numeric($zip)) {
    $statement = $DBH->prepare($getInfo);
    $statement->execute(array(':zip' => $zip));
    $rows = $statement->fetchAll();
    if ($rows) {
      $list_events .= '<ul class="list-events">';
      foreach ($rows as $row) {
        $list_events .= '<li class="event-item">' . 
                        '<h3>' . $row['name'] . '</h3>' . $row['street_address'] . $row['datetime'] . '</li>';
      }
      $list_events .= '</ul>';

    }
    else {
      $emptymsg = "Sorry, there are no events in this zipcode at this time.";
    }
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
        <input type="text" class="form-control" id="zipcode_search" placeholder="Zipcode" name="zipcode" maxlength="5">
        <button type="submit" class="btn btn-primary">SEARCH</button>
        <?php echo $list_events ?>
        <?php echo $emptymsg ?>
    </form>
  </div>
</body>
</html>