<?php

	echo "<h1>Fantasy F1 Admin</h1>";

$query = "SELECT picksdeadline FROM races WHERE is_active_race = '1'";
$result = mysql_query ($query);
if (mysql_num_rows ($result) == 1) {
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$deadline = $row['picksdeadline'];
		$now = strtotime('now');
		$seconds = $deadline - $now;
		print sprintf("There are %d hours, %02d minutes until picks deadline.",$seconds/3600,($seconds/60)%60);
		
	}
}
else {
	$deadline = NULL;
}

echo "<h1>Who's Picked?</h1>";

$query = "SELECT fantasyusers.username, fantasyteamstoseasons.teamname, FROM_UNIXTIME(fantasypicks.timepicked) AS pick_time 
FROM fantasyusers
INNER JOIN fantasyteams
INNER JOIN fantasyteamstoseasons ON (fantasyteamstoseasons.fantasyteams_id = fantasyteams.id)
INNER JOIN fantasyuserstoseasons ON (fantasyuserstoseasons.fantasyusers_id = fantasyusers.id AND fantasyuserstoseasons.fantasyteamstoseasons_id = fantasyteamstoseasons.id)
INNER JOIN fantasypicks ON (fantasypicks.fantasyuserstoseasons_id = fantasyuserstoseasons.id)
INNER JOIN races ON (races.id = fantasypicks.races_id)
WHERE races.is_active_race = 1 
GROUP BY fantasyusers.username 
ORDER BY FROM_UNIXTIME(fantasypicks.timepicked) ASC";
$result = mysql_query($query);
if (mysql_num_rows($result) > 0) {
	echo "<table><thead><tr><th>Username</th><th>Team</th><th>Time Picked</th></tr></thead>\n<tbody>\n";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$username = $row['username'];
		$team = $row['teamname'];
		$picktime = $row['pick_time'];
		echo "<tr><td>".$username."</td><td>".$team."</td><td>".$picktime."</td></tr>\n";
	}
	echo "</tbody>\n</table>\n";
}
else {
	echo "<p>Either no-one has picked, or there is no active race.</p>";
}

if ($deadline != NULL) {
	include 'picks_reminders.php';
}

?>