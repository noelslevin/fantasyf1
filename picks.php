<style type="text/css">
table th {
text-align: left;
}

h1 {
margin-bottom: 10px;
}

input:disabled {
display: none;
}

</style>

<script type="text/javascript">
// The counter for i must agree with the number of race entries
//<![CDATA[
function UpdateCost() {
  var submitObj = document.getElementById('submitpicks');
  var sum = 0;
  var gn, elem;
  for (i=1; i<23; i++) {
    gn = 'pick'+i;
    elem = document.getElementById(gn);
    hn = 'driverpick'+i;
    elem2 = document.getElementById(hn);
    if (elem.checked == true) { sum += Number(elem2.value); }
  }
  document.getElementById('totalcost').value = sum.toFixed(1);
  if (sum <= 45.0) {
  submitObj.disabled = false;
  }
  else {
  submitObj.disabled = true;
  }
}
//]]>
</script>

<h1>Fantasy F1 Picks</h1>

<?php

	$currentyear = date("Y"); // Get the current year - used for querying the fantasyuserstoseasons id for the picks
	$current_user = wp_get_current_user(); // Get WordPress id
	$userid = $current_user->ID;
	// Need to query fantasyuserstoseasons id from wordpress_id
	$userquery = "SELECT fantasyuserstoseasons.id, fantasyusers.username, fantasyteamstoseasons.season, fantasyteams.fantasyteam_name FROM fantasyuserstoseasons, fantasyusers, fantasyteamstoseasons, fantasyteams WHERE fantasyteamstoseasons.fantasyteams_id = fantasyteams.id AND fantasyuserstoseasons.fantasyusers_id = fantasyusers.id AND fantasyuserstoseasons.fantasyteamstoseasons_id = fantasyteamstoseasons.id AND season = '".$currentyear."' AND fantasyusers.wordpress_id = '".$userid."'"; // Get fantasyusers id from related WordPress id
	$userresult = mysql_query($userquery);
	if (mysql_num_rows ($userresult) == 1) {
		while ($row = mysql_fetch_array ($userresult, MYSQL_ASSOC)) {
			$fantasyuserstoseasonsid = $row['id'];
			$username = $row['username'];
					$fantasyteam = $row['fantasyteam_name'];
					?>
					<p>Your registration details for this season:</p>
					<table>
					<thead>
					<th>Username</th>
					<th>Team</th>
					</thead>
					<tbody>
					<td><?php echo $username; ?></td>
					<td><?php echo $fantasyteam; ?></td>
					</tbody>
					</table>
					<?php
				}
			}
	else {
		exit("You do not appear to be registered for this year's Fantasy F1 Championship.");
		}

$message = NULL;
if (isset($_POST['submitpicks'])) {
	// Retrieve the raceid
	$raceid = $_POST['raceid'];
	
	// Check if picks are still open
	$racequery = "SELECT picksdeadline FROM races WHERE id = '$raceid'";
	$raceresult = mysql_query($racequery);
	$num = mysql_num_rows($raceresult);
	if ($num > 0) {
		while ($row = mysql_fetch_array($raceresult, MYSQL_ASSOC)) {
			$deadline = $row['picksdeadline'];
			$now = strtotime('now');
			if ($deadline < $now) {
				//exit("Sorry, picks are now closed. Any existing picks have been kept. Be more organised next time, OK? (But tell me when you encounter this message because then I'll disable it and we'll pretend the 2011 Australian GP hasn't happened yet!)");
				
			}
		}
	}
	// We need to process the picked drivers.
	$driverpicks = $_POST['driverpicks'];
if(empty($driverpicks)) {
	echo "<p>Error: you didn't select any picks.</p>";
  }
else {
	// Must delete any picks previously made for this race.
	$query = "DELETE FROM fantasypicks WHERE fantasyuserstoseasons_id = '$fantasyuserstoseasonsid' AND races_id = '$raceid'";
	$result = mysql_query($query);
	if (mysql_affected_rows() > 0) {
		// Picks deleted.
		$message .= "<p>Previous picks found and deleted.</p>";
		}
	else {
		// No picks found to delete.
		$message .="<p>No previous picks found for this race.</p>";
		}
	$N = count($driverpicks);
    echo "<p>You selected $N pick(s).</p>";
    for($i=0; $i < $N; $i++) {
		$query = "INSERT INTO fantasypicks (fantasyuserstoseasons_id, raceentries_id, races_id, timepicked) VALUES ('$fantasyuserstoseasonsid', '$driverpicks[$i]', '$raceid', '$now')";
		$result = mysql_query($query);
		if ($result) {
			//$message .= "<p>Pick entered successfully.</p>";
			}
		else {
			// Record not entered.
			$message .= "<p>Error: Pick not entered. ".mysql_error()."</p>";
			}
		}
    }
}

echo $message;

$query = "SELECT picksdeadline FROM races WHERE is_active_race = '1'";
$result = mysql_query ($query);
if (mysql_num_rows ($result) == 1) {
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$deadline = $row['picksdeadline'];
		$now = strtotime('now');
		$seconds = $deadline - $now;
		print sprintf("<p><strong>There are %d hours, %02d minutes until picks deadline.</strong> You may spend up to 45 points. If your picks total more than 45 points, you will be disqualified.</p>",$seconds/3600,($seconds/60)%60);
		
	}
}

$query = "SELECT drivers.forename, drivers.surname, teams.team_name
FROM races, trackstograndsprix, tracks, grandsprix, drivers, teams, raceentries, driverstoseasons, teamstoseasons, fantasyusers, fantasyuserstoseasons, fantasypicks 
WHERE raceentries.races_id = races.id AND raceentries.driverstoseasons_id = driverstoseasons.id AND races.trackstograndsprix_id = trackstograndsprix.id AND driverstoseasons.drivers_id = drivers.id AND driverstoseasons.teamstoseasons_id = teamstoseasons.id AND teamstoseasons.teams_id = teams.id AND trackstograndsprix.tracks_id = tracks.id AND trackstograndsprix.grandsprix_id = grandsprix.id AND races.is_active_race = 1 AND fantasypicks.fantasyuserstoseasons_id = fantasyuserstoseasons.id AND fantasypicks.raceentries_id = raceentries.id AND fantasypicks.races_id = races.id AND fantasyuserstoseasons.fantasyusers_id = fantasyusers.id AND fantasyuserstoseasons.id = '$fantasyuserstoseasonsid' ORDER BY teams.id ASC, drivers.id ASC";
$result = mysql_query($query);
if (mysql_num_rows ($result) > 0) {
	echo "<h1>Current Picks</h1>";
	echo "<p>Picks found for this race and are shown below. Please note, if you resubmit your picks, your current picks will be deleted from the database and cannot be reinstated.</p>";
	echo "<table><thead><tr><th>Driver</th><th>Team</th></tr></thead><tbody>";
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$driver = $row['forename']." ".$row['surname'];
		$team = $row['team_name'];
		echo "<tr><td>".$driver."</td><td>".$team."</td></tr>";
	}
	echo "</tbody></table>";
}
else {
	echo "<p>You have not entered your picks for this race. Please make your picks below.</p>";
}

if ($deadline < $now) {
	echo "<p>Sorry, the picks deadline has passed. You're too late.</p>";
}

else {

$query = "SELECT raceentries.id AS raceentryid, drivers.forename, drivers.surname, teams.team_name, raceentries.fantasy_value, races.id AS races_id, races.picksdeadline FROM races, trackstograndsprix, tracks, grandsprix, drivers, teams, raceentries, driverstoseasons, teamstoseasons WHERE raceentries.races_id = races.id AND raceentries.driverstoseasons_id = driverstoseasons.id AND races.trackstograndsprix_id = trackstograndsprix.id AND driverstoseasons.drivers_id = drivers.id AND driverstoseasons.teamstoseasons_id = teamstoseasons.id AND teamstoseasons.teams_id = teams.id AND trackstograndsprix.tracks_id = tracks.id AND trackstograndsprix.grandsprix_id = grandsprix.id AND races.is_active_race = 1 ORDER BY teams.id ASC, drivers.id ASC";
$result = mysql_query($query);
if (mysql_num_rows ($result) > 0) {
	echo "<form action=\"".$_SERVER['PHP_SELF']."?page=fantasyf1_picks\" method=\"post\">\n";
	echo "<h1>Make Your Picks</h1>";
	echo "<table><thead><th>Name</th><th>Cost</th><th>Pick</th></thead>\n";
	$number = 0;
	while ($row = mysql_fetch_array( $result, MYSQL_ASSOC)) {
		$name = $row['forename']. " ".$row['surname'];
		$fantasyvalue = $row['fantasy_value'];
		$raceentryid = $row['raceentryid'];
		$id = $row['id'];
		$raceid = $row['races_id'];
		$number++;
		echo "<tr><td>".$name."</td><td>".$fantasyvalue."</td><td><input type=\"checkbox\" name=\"driverpicks[]\" id=\"pick".$number."\" onclick=\"UpdateCost()\" value=\"".$raceentryid."\" /></td></tr>\n";
		echo "<input type=\"hidden\" id=\"driverpick".$number."\" value=\"".$fantasyvalue."\" />\n";
		}
	echo "</table>\n";
	echo "<input type=\"text\" readonly=\"readonly\" id=\"totalcost\" value=\"0.0\">\n";
	echo "<input type=\"hidden\" name=\"raceid\" id=\"raceid\" value=\"".$raceid."\">\n";
	echo "<input type=\"submit\" name=\"submitpicks\" id=\"submitpicks\" value=\"Submit Picks\" />\n";
	echo "</form>";
	echo "<p>Submitting picks will remove any previous picks for this race from the database.</p>";
	}
else {
	// No data found.
	echo "<p>There is currently no active race.</p>";
	}
	
	}

?>