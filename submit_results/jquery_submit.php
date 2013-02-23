<?php echo "<form action =\"".$_SERVER['PHP_SELF']."?page=fantasyf1_submitresults\" method=\"post\">\n\n";

$query = "SELECT raceentries.id AS raceentryid, raceentries.driverstoseasons_id, drivers.forename, drivers.surname, teams.team_name, raceentries.fantasy_value, races.id AS races_id, teamstoseasons.base_price, races.race_date FROM races, trackstograndsprix, tracks, grandsprix, drivers, teams, raceentries, driverstoseasons, teamstoseasons WHERE raceentries.races_id = races.id AND raceentries.driverstoseasons_id = driverstoseasons.id AND races.trackstograndsprix_id = trackstograndsprix.id AND driverstoseasons.drivers_id = drivers.id AND driverstoseasons.teamstoseasons_id = teamstoseasons.id AND teamstoseasons.teams_id = teams.id AND trackstograndsprix.tracks_id = tracks.id AND trackstograndsprix.grandsprix_id = grandsprix.id AND races.id = '$raceid' AND ISNULL(raceentries.race_position) ORDER BY teams.id ASC, drivers.id ASC";
$result = mysql_query($query);
$num = mysql_num_rows($result);
if ($num > 0) {
	echo "<select name=\"driver\">\n";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$value = $row['raceentryid'];
		$driver = $row['forename']." ".$row['surname'];
		echo "<option value=\"".$value."\">".$driver."</option>\n";
	}
	echo "</select>";
}
else {
	echo "<p>Looks like there are no entries for that race.</p>";
}
?>
Position: <select name="position">
<?php
for ($x = 1; $x < 25; $x++) {
	echo "<option value=\"".$x."\">".$x."</option>\n"; 
}
echo "</select>\n";
echo "<input type=\"hidden\" name=\"races_id\" value=\"".$raceid."\" />\n";
echo "<input type=\"submit\" name=\"submitresult\" value=\"Submit Result\" />";
?><br/>