<?php

$getNames = "SELECT name FROM food_events";

$store = "insert into food_events (event_id, name, date, recurring, location, num_meals) values (:id, :name, :date, :recurring, :location, :num_meals)";

?>
