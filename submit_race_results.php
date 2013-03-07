<h2>Submit Results</h2>
<p>Use this page to submit race results.</p>

<?php

// Set output message to NULL
$message = NULL;

// This runs if the dropdown menu form has been submitted
if (isset($_POST['resultspage'])) {
	$raceid = $_POST['race_id'];
	include 'submit_results/jquery_submit.php';
}

if (isset($_POST['submitresult'])) {
	include 'submit_results/process_results.php';
}

echo "<h2>Select A Race</h2>";
// This is the dropdown menu to select a race
echo "<form action =\"".$_SERVER['PHP_SELF']."?page=fantasyf1_submitresults\" method=\"post\">\n\n";

// Select all Grands Prix
$query = "SELECT races.id, grandsprix.grand_prix_name, tracks.track_name, races.race_date FROM grandsprix, races, tracks, trackstograndsprix WHERE races.trackstograndsprix_id = trackstograndsprix.id AND trackstograndsprix.tracks_id = tracks.id AND trackstograndsprix.grandsprix_id = grandsprix.id AND races.drivers_entered = '1' AND races.complete = '0' ORDER BY races.race_date ASC";
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