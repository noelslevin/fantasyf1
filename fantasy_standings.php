<?php

$thisyear = date(Y);

// Drivers' standings.
echo "<h2>Drivers' Standings</h2>\n";
$query = "SELECT fantasyusers.username, fantasyteamstoseasons.teamname AS team, SUM(fantasy_championship_points) AS points, SUM(fantasy_race_points) AS total FROM fantasyteamstoseasons, fantasyteams, fantasyuserstoseasons, fantasyusers, fantasyraceentries
WHERE fantasyteamstoseasons.fantasyteams_id = fantasyteams.id
AND fantasyuserstoseasons.fantasyteamstoseasons_id = fantasyteamstoseasons.id
AND fantasyuserstoseasons.fantasyusers_id = fantasyusers.id
AND fantasyraceentries.fantasyuserstoseasons_id = fantasyuserstoseasons.id
AND fantasyteamstoseasons.season = '$thisyear'
GROUP BY fantasyuserstoseasons.id
ORDER BY points DESC, total DESC, team ASC";
$result = mysql_query($query);
if (mysql_num_rows($result) > 0) {
	$num = 0;
	echo "<table>\n";
	echo "<tr><td>Position</td><td>Name</td><td>Team</td><td>Points</td><td>(Score)</td></tr>\n";
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$num++;
		$username = $row['username'];
		$total = $row['total'];
		$team = $row['team'];
		$points = $row['points'];
		echo "<tr><td>".$num."</td><td>".$username."</td><td>".$team."</td><td>".$points."</td><td>".$total."</td></tr>\n";
	}
	echo "</table>\n\n";
}
else {
	echo "<p>Error. No users found.</p>";
}

// Constructors' standings.
echo "<h2>Constructors' Standings</h2>\n";
$query = "SELECT fantasyteamstoseasons.teamname AS team, SUM(fantasy_championship_points) AS points, SUM(fantasy_race_points) AS total FROM fantasyteamstoseasons, fantasyteams, fantasyuserstoseasons, fantasyusers, fantasyraceentries
WHERE fantasyteamstoseasons.fantasyteams_id = fantasyteams.id
AND fantasyuserstoseasons.fantasyteamstoseasons_id = fantasyteamstoseasons.id
AND fantasyuserstoseasons.fantasyusers_id = fantasyusers.id
AND fantasyraceentries.fantasyuserstoseasons_id = fantasyuserstoseasons.id
AND fantasyteamstoseasons.season = '$thisyear'
GROUP BY team
ORDER BY points DESC, total DESC, team ASC";
$result = mysql_query($query);
if (mysql_num_rows($result) > 0) {
	$num = 0;
	echo "<table>\n";
	echo "<tr><td>Position</td><td>Team</td><td>Points</td><td>(Score)</td></tr>\n";
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$num++;
		$team = $row['team'];
		$total = $row['total'];
		$points = $row['points'];
		echo "<tr><td>".$num."</td><td>".$team."</td><td>".$points."</td><td>".$total."</td></tr>\n";
	}
	echo "</table>\n\n";
}
else {
	echo "<p>Error. No users found.</p>";
}

?>