<?php

echo "<h2>Register Users</h2>";

// Set output message to NULL
$message = NULL;

// This runs if any data has been submitted
if (isset($_POST['registeruser'])) {
	$userid = $_POST['user_id'];
	// Need to select user from database to get data
	$selectquery = "SELECT id, user_email, display_name FROM wp_users WHERE id = '$userid'";
	$selectresult = mysql_query($selectquery);
	$num = mysql_num_rows ($selectresult);
	if ($num > 0) {
		while ($row = mysql_fetch_array($selectresult, MYSQL_ASSOC)) {
			$username = $row['display_name'];
			$wordpressid = $row['id'];
			$email = $row['user_email'];
			
			$query = "INSERT INTO fantasyusers (username, email_address, wordpress_id) VALUES ('$username', '$email', '$wordpressid')";
			$result = mysql_query ($query);
			if (mysql_affected_rows () > 0) {
				$message .= "<p>The record was successfully added into the database.</p>";
			}
			else {
				$message .= "<p>Error: the record was not entered into the database.</p>";
			}
		} // endwhile
	} // Endif
} //End isset

echo "<form action =\"".$_SERVER['PHP_SELF']."?page=fantasyf1_globaloptions\" method=\"post\">\n\n";

// Select all non-registered users from the WordPress database
$query = "SELECT wp_users.id, wp_users.display_name, fantasyusers.email_address FROM wp_users LEFT JOIN fantasyusers ON wp_users.id = fantasyusers.wordpress_id";
$result = mysql_query ($query);
// If users are found
if (mysql_num_rows ($result) > 0) {
	echo "<select name = \"user_id\">\n";
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		$id = $row['id'];
		$name = $row['display_name'];
		$email = $row['email_address'];
		if ($email == NULL) {
			echo "<option value=\"".$id."\">".$name."</option>\n";
		}
	}
	echo "</select>\n\n";
}
else {
	$message .= "<p>No unregistered users found.</p>\n";
}

echo "<input type=\"submit\" value=\"Register\" name=\"registeruser\" />\n\n";
echo "</form>\n\n";

echo $message;

?>