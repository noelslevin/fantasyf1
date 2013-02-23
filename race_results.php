<h2>Submit Results</h2>
<p>Use this page to submit race results.</p>

<?php

// Set output message to NULL
$message = NULL;

if (isset($_POST['submitresults'])) {
	$position = $_POST['position'];
	$points = $_POST['points'];
	$raceentryid = $_POST['raceentryid'];
	$query = "UPDATE raceentries SET race_position = '$position', race_points = '$points' WHERE id = '$raceentryid'";
	$result = mysql_query ($query);
	if (mysql_affected_rows() > 0) {
		echo "<p>Updated.</p>";
		}
	else {
		echo "<p>Nothing updated.</p>";
		}
}

// This runs if any data has been submitted
if (isset($_POST['resultspage'])) {
	$raceid = $_POST['race_id'];
	
	// Select all drivers from the race_id specified

	$query = "SELECT raceentries.id AS raceentryid, raceentries.driverstoseasons_id, drivers.forename, drivers.surname, teams.team_name, raceentries.fantasy_value, races.id AS races_id, teamstoseasons.base_price, races.race_date FROM races, trackstograndsprix, tracks, grandsprix, drivers, teams, raceentries, driverstoseasons, teamstoseasons WHERE raceentries.races_id = races.id AND raceentries.driverstoseasons_id = driverstoseasons.id AND races.trackstograndsprix_id = trackstograndsprix.id AND driverstoseasons.drivers_id = drivers.id AND driverstoseasons.teamstoseasons_id = teamstoseasons.id AND teamstoseasons.teams_id = teams.id AND trackstograndsprix.tracks_id = tracks.id AND trackstograndsprix.grandsprix_id = grandsprix.id AND races.id = '$raceid' ORDER BY teams.id ASC, drivers.id ASC";
	$result = mysql_query ($query);
	if (mysql_num_rows($result) > 0) {
		echo "<form action =\"".$_SERVER['PHP_SELF']."?page=fantasyf1_submitresults\" method=\"post\">\n\n";
		echo "<select name=\"raceentryid\">\n";
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			$raceentryid = $row['raceentryid'];
			// How do I do this?
			echo "<option value=\"".$raceentryid."\">".$row['forename']." ".$row['surname']."</option>";
		}
		echo "</select>";
		echo "Position: <input type=\"text\" name=\"position\" />\n\n";
		echo "Points: <input type=\"text\" name=\"points\" />\n\n";
		echo "<input type=\"submit\" value=\"Submit Result\" name=\"submitresults\" />\n\n";
		echo "</form>\n\n";

	}
	else {
		$message .= "<p>Error: no driver entries found for the specified Grand Prix.</p>";
	}
}

echo "<form action =\"".$_SERVER['PHP_SELF']."?page=fantasyf1_submitresults\" method=\"post\">\n\n";

// Select all Grands Prix
$query = "SELECT races.id, grandsprix.grand_prix_name, tracks.track_name, races.race_date FROM grandsprix, races, tracks, trackstograndsprix WHERE races.trackstograndsprix_id = trackstograndsprix.id AND trackstograndsprix.tracks_id = tracks.id AND trackstograndsprix.grandsprix_id = grandsprix.id AND races.drivers_entered = '0' ORDER BY races.race_date DESC";
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

echo "<input type=\"submit\" value=\"View Results Page\" name=\"resultspage\" />\n\n";
echo "</form>\n\n";

echo $message;

?>
