<h2>The Noelinho.org Fantasy F1 Championship</h2>

<?php

	$currentyear = date("Y"); // Get the current year - used for querying the fantasyuserstoseasons id for the picks
	$current_user = wp_get_current_user(); // Get WordPress id
	$userid = $current_user->ID;
	// Need to query fantasyuserstoseasons id from wordpress_id
	$userquery = "SELECT fantasyuserstoseasons.id, fantasyusers.username, fantasyteamstoseasons.season, fantasyteams.fantasyteam_name FROM fantasyuserstoseasons, fantasyusers, fantasyteamstoseasons, fantasyteams WHERE fantasyteamstoseasons.fantasyteams_id = fantasyteams.id AND fantasyuserstoseasons.fantasyusers_id = fantasyusers.id AND fantasyuserstoseasons.fantasyteamstoseasons_id = fantasyteamstoseasons.id AND season = '".$currentyear."' AND fantasyusers.wordpress_id = '".$userid."'"; // Get fantasyusers id from related WordPress id
	$userresult = mysql_query($userquery);
	if (mysql_num_rows ($userresult) == 1) {
		while ($row = mysql_fetch_array ($userresult, MYSQL_ASSOC)) {
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

?>