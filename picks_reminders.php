<?php

echo "<h2>Send Reminder Emails</h2>";

$query = "SELECT fantasyuserstoseasons.id, fantasyusers.username, fantasyteams.fantasyteam_name, fantasyusers.email_address FROM fantasyusers INNER JOIN fantasyteams INNER JOIN fantasyuserstoseasons ON (fantasyuserstoseasons.fantasyusers_id = fantasyusers.id) INNER JOIN fantasyteamstoseasons ON (fantasyteamstoseasons.fantasyteams_id = fantasyteams.id AND fantasyteamstoseasons.id = fantasyuserstoseasons.fantasyteamstoseasons_id) WHERE fantasyteamstoseasons.season = 2013 ORDER by fantasyusers.username ASC";
$result = mysql_query($query);
$num = mysql_num_rows ($result);
if ($num > 0) {
	echo "<table>\n
	<thead>\n
	<tr><td>Username</td><td>Team</td><td>Email Address</td></tr>\n
	</thead>\n
	<tbody>\n";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$id = $row['id'];
		$username = $row['username'];
		$team = $row['fantasyteam_name'];
		$email = $row['email_address'];
		$query2 = "SELECT drivers.forename, drivers.surname, teams.team_name FROM races, trackstograndsprix, tracks, grandsprix, drivers, teams, raceentries, driverstoseasons, teamstoseasons, fantasyusers, fantasyuserstoseasons, fantasypicks WHERE raceentries.races_id = races.id AND raceentries.driverstoseasons_id = driverstoseasons.id AND races.trackstograndsprix_id = trackstograndsprix.id AND driverstoseasons.drivers_id = drivers.id AND driverstoseasons.teamstoseasons_id = teamstoseasons.id AND teamstoseasons.teams_id = teams.id AND trackstograndsprix.tracks_id = tracks.id AND trackstograndsprix.grandsprix_id = grandsprix.id AND races.is_active_race = 1 AND fantasypicks.fantasyuserstoseasons_id = fantasyuserstoseasons.id AND fantasypicks.raceentries_id = raceentries.id AND fantasypicks.races_id = races.id AND fantasyuserstoseasons.fantasyusers_id = fantasyusers.id AND fantasyuserstoseasons.id = '$id' ORDER BY teams.id ASC, drivers.id ASC";
		$result2 = mysql_query($query2);
		$num2 = mysql_num_rows($result2);
		if ($num2 > 0) {
			//echo "<tr><td>".$username."</td><td>".$team."</td><td></td></tr>\n";
		}
		else {
			echo "<tr><td>".$username."</td><td>".$team."</td><td><a href=\"mailto:".$email."&subject=FantasyF1%20Picks%20Reminder&body=It%20looks%20like%20you%20haven't%20made%20any%20FantasyF1%20picks%20for%20the%20Grand%20Prix%20this%20weekend.%20Please%20make%20your%20picks%20by%20midnight%20GMT%20on%20Thursday%20evening%20at%20http://noelinho.org/wp-admin/\">".$email."</a></td></tr>\n";
		}
		
	}
	echo "</tbody>\n
	</table>\n";
}
else {
	echo "<p>Error: No records found.</p>";
}

?>