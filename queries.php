<?php

$getNames = "SELECT name FROM food_events";

$store = "insert into food_events (name, datetime, recurring, street_address, zipcode, num_meals) values (:name, :datetime, :recurring, :street_address, :zipcode, :num_meals)";

$getInfo = "select name, datetime, street_address, num_meals from food_events where zipcode = :zip and datetime > now() order by datetime asc limit :lim";
?>
