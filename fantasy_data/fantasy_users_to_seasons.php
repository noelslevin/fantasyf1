<?php

$userid = $_POST['fantasy_user_id'];
$teamid = $_POST['fantasyteam_id'];
$query = "INSERT INTO fantasyuserstoseasons (fantasyusers_id, fantasyteamstoseasons_id) VALUES ('$userid', '$teamid')";
$result = mysql_query($query);
if ($result) {
	$message .= "<p>The record was successfully added into the database.</p>";
}
else {
	$message .= "<p>Error: the record was not entered into the database.</p>";
}

?>