<?php

$userid = $_POST['user_id'];
$query = "UPDATE fantasyusers SET registered = 1 WHERE id = '$userid'";
$result = mysql_query($query);
if ($result) {
	$message .= "<p>The user was successfully updated.</p>";
}
else {
	$message .= "<p>Error: the user was not updated.</p>";
}

?>