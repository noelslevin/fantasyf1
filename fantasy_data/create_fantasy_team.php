<?php

$teamname = $_POST['teamname'];
if (!empty($teamname)) {
	$query = "INSERT INTO fantasyteams (fantasyteam_name) VALUES ('$teamname')";
	$result = mysql_query($query);
	if ($result) {
		echo "<p>Success. Team name added to the database.</p>";
	}
	else {
		echo "<p>Error. Team name not added to the database.</p>";
	}
}
else {
	echo "<p>Error. Team name field was left empty.</p>";
}
?>