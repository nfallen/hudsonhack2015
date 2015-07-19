<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function test_address($data) {
	$data = test_input($data);
	if (strlen($data) > 40) {
		return FALSE;
	}
	return $data;
}

function test_zipcode($data) {
	$data = test_input($data);
	if (strlen($data) !== 5 || !is_numeric($data)) {
		return FALSE;
	}
	return $data;
}

function test_num_meals($data) {
	$data = test_input($data);
	if (!is_numeric($data)) {
		return FALSE;
	}
	return $data;
}