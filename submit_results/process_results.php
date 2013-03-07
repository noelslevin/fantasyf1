<?php

$num = 0;
$raceid = $_POST['races_id'];

for ($x = 1; $x < 23; $x++) {

$driverid = $_POST[$x];

switch ($x) {
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

$query = "UPDATE raceentries SET race_position = '$x', race_points = '$points' WHERE id = '$driverid'";
$result = mysql_query($query);
$affected = mysql_affected_rows();
if ($affected == 0) {
	echo "Error: Entry ID ".$driverid."not updated.</p>";
}
else if ($affected == 1) {
	$num++;
}
else {
	echo "<p>Error. More than one record updated.</p>";
}

}

echo "<p>".$num." records successfully updated.</p>";

?>