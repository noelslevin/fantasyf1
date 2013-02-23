<?php

$driverid = $_POST['driver'];
$position = $_POST['position'];
$raceid = $_POST['races_id'];

switch ($position) {
	case 1:
	$points = 25;
	break;
	case 2:
	$points = 18;
	break;
	case 3:
	$points = 15;
	break;
	case 4:
	$points = 12;
	break;
	case 5:
	$points = 10;
	break;
	case 6:
	$points = 8;
	break;
	case 7:
	$points = 6;
	break;
	case 8:
	$points = 4;
	break;
	case 9:
	$points = 2;
	break;
	case 10:
	$points = 1;
	break;
default:
	$points = 0;
}

$query = "UPDATE raceentries SET race_position = '$position', race_points = '$points' WHERE id = '$driverid'";
$result = mysql_query($query);
$affected = mysql_affected_rows();
if ($affected == 0) {
	echo "<Nothing updated.</p>";
}
else if ($affected == 1) {
	echo "<p>Record updated.</p>";
}
else {
	echo "<p>Error. More than one record updated.<p>";
}

include 'jquery_submit.php';

?>