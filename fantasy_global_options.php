<?php
	
if (isset($_POST['activate'])) {
	$raceid = $_POST['race_id'];
	$query = "UPDATE races SET races.is_active_race = '1' WHERE races.id = '$raceid'";
	$result = mysql_query ($query);
}

else if (isset($_POST['deactivate'])) {
	$query = "UPDATE races SET races.is_active_race = '0' WHERE races.is_active_race != '0'";
	$result = mysql_query ($query);
}

else {

	echo "<h2>Activate Picks</h2>";

	echo "<form action=\"".$_SERVER['PHP_SELF']."?page=fantasyf1_globaloptions\" method=\"post\" name=\"active\">";
	
	// Select all Grands Prix
	$query = "SELECT races.id, grandsprix.grand_prix_name, tracks.track_name, races.race_date FROM grandsprix, races, tracks, trackstograndsprix WHERE races.trackstograndsprix_id = trackstograndsprix.id AND trackstograndsprix.tracks_id = tracks.id AND trackstograndsprix.grandsprix_id = grandsprix.id AND races.complete = '0' ORDER BY races.race_date ASC";
	$result = mysql_query ($query);
		if (mysql_num_rows ($result) > 0) {
		echo "<select name = \"race_id\">\n";
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$raceid = $row['id'];
		$grandprix = $row['grand_prix_name'];
		$track = $row['track_name'];
		$date = $row['race_date'];
		echo "<option value=\"".$raceid."\">".$grandprix." (".$date.")</option>\n";
		}
		echo "</select>\n\n";
	}
	else {
		$message .= "<p>No Grands Prix found.</p>";
	}

	echo "<input type=\"submit\" value=\"Activate Picks\" name=\"activate\" />";
	
	echo "<h2>Deactivate Picks System</h2>";
	
	echo "<input type=\"submit\" value=\"Deactivate Picks\" name=\"deactivate\" />";
	echo "</form>";
}

include 'register_users.php';

?>