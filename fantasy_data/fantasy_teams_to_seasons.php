<?php

$teamid = $_POST['fantasyteam_id'];
$teamname = $_POST['fantasy_team_name'];
$year = $_POST['year'];
$query = "INSERT INTO fantasyteamstoseasons (fantasyteams_id, teamname, season) VALUES ('$teamid', '$teamname', '$year')";
$result = mysql_query($query);
if ($result) {
	$message .= "<p>The record was successfully added into the database.</p>";
}
else {
	$message .= "<p>Error: the record was not entered into the database.</p>";
}

?>