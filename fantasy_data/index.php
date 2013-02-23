<h2>Fantasy Data</h2>

<p>For creating FF1 users and teams.</p>

<?php

$year = date("Y");

$message = NULL;
if (isset($_POST['createfantasyteam'])) {
	include 'create_fantasy_team.php';
}

if (isset($_POST['fantasyuserstoseasons'])) {
	include 'fantasy_users_to_seasons.php';
}
if (isset($_POST['fantasyteamstoseasons'])) {
	include 'fantasy_teams_to_seasons.php';
}
if (isset($_POST['fantasyusersupdate'])) {
	include 'reregister_fantasy_users.php';
}

?>

<h2>Create A New Fantasy Team</h2>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?page=fantasyf1_fantasy_data" method="post">

<label for="teamname">Team Name: </label><input type="text" name="teamname" id="teamname" value="" />

<input type="submit" name="createfantasyteam" value="Create Fantasy Team" />
</form>

<h2>Fantasy Users To Seasons</h2>

<?php

echo "<form action =\"".$_SERVER['PHP_SELF']."?page=fantasyf1_fantasy_data\" method=\"post\">\n\n";

// Select all fantasy users from the database – only displays those marked as registered
$query = "SELECT fantasyusers.id, fantasyusers.username FROM fantasyusers WHERE registered = 1 ORDER BY fantasyusers.username ASC";
$result = mysql_query ($query);
if (mysql_num_rows ($result) > 0) {
	echo "<select name = \"fantasy_user_id\">\n";
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$id = $row['id'];
		$username = $row['username'];
		echo "<option value=\"".$id."\">".$username."</option>\n";
	}
	echo "</select>\n\n";
}
else {
	$message .= "<p>No fantasy users found.</p>\n";
}
// Select all fantasy teams from the database – only displays teams from the current year
$query = "SELECT fantasyteamstoseasons.id, fantasyteamstoseasons.teamname, fantasyteamstoseasons.season FROM fantasyteamstoseasons WHERE fantasyteamstoseasons.season = '$year' ORDER BY fantasyteamstoseasons.season DESC, fantasyteamstoseasons.teamname ASC";
$result = mysql_query ($query);
if (mysql_num_rows ($result) > 0) {
	echo "<select name = \"fantasyteam_id\">\n";
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$id = $row['id'];
		$name = $row['teamname'];
		$season = $row['season'];
		echo "<option value=\"".$id."\">".$name." (".$season.")</option>\n";
	}
	echo "</select>\n\n";
}
else {
	$message .= "<p>No fantasy teams found.</p>\n";
}

echo "<input type=\"submit\" value=\"Create Association\" name=\"fantasyuserstoseasons\" />\n\n";
echo "</form>\n\n";

echo "<h2>Fantasy Teams To Seasons</h2>\n\n";

echo "<form action =\"".$_SERVER['PHP_SELF']."?page=fantasyf1_fantasy_data\" method=\"post\">\n\n";

// Select all fantasy teams from the database
$query = "SELECT fantasyteams.id, fantasyteams.fantasyteam_name FROM fantasyteams ORDER BY fantasyteams.fantasyteam_name ASC";
$result = mysql_query ($query);
if (mysql_num_rows ($result) > 0) {
	echo "<select name = \"fantasyteam_id\">\n";
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$id = $row['id'];
		$name = $row['fantasyteam_name'];
		echo "<option value=\"".$id."\">".$name."</option>\n";
	}
	echo "</select>\n\n";
}
else {
	$message .= "<p>No fantasy teams found.</p>\n";
}

?>

<label for="year">Year: </label><input type="text" name="year" id="year" value="" />
<label for="fantasy_team_name">Team Name: </label><input type="text" name="fantasy_team_name" id="fantasy_team_name" value="" />

<?php

echo "<input type=\"submit\" value=\"Create Association\" name=\"fantasyteamstoseasons\" />\n\n";
echo "</form>\n\n";

echo "<h2>Re-Register Fantasy Users For Current Season</h2>";
echo "<form action =\"".$_SERVER['PHP_SELF']."?page=fantasyf1_fantasy_data\" method=\"post\">\n\n";
$query = "SELECT fantasyusers.id, fantasyusers.username FROM fantasyusers WHERE registered = 0";
$result = mysql_query($query);
$num = mysql_num_rows($result);
if ($num > 0) {
	echo "<select name = \"user_id\">\n";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$id = $row['id'];
		$name = $row['username'];
		echo "<option value=\"".$id."\">".$name."</option>\n";
	}
	echo "</select>\n\n";
}

else {
	echo "<p>No unregistered users found.<p>";
}
echo "<input type=\"submit\" value=\"Update User\" name=\"fantasyusersupdate\" />\n\n";
echo "</form>\n\n";

echo $message;

?>