<?php

echo "<h2>Create Drivers</h2>";

$message = NULL;
if (isset($_POST['submitdrivers'])) {
	$forename = $_POST['forename'];
	$surname = $_POST['surname'];
	$query = "SELECT * FROM drivers WHERE forename = '$forename' AND surname = '$surname'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 0) {
		// Driver not already there, can enter
		$query = "INSERT INTO drivers (forename, surname) VALUES ('$forename', '$surname')";
		$result = mysql_query($query);
		if ($result) {
			$message .= "<p>Record entered successfully.</p>";
			}
		else {
			// Record not entered.
			$message .= "<p>Error: Record not entered. ".mysql_error()."</p>";
			}
		}
	else {
		// Driver already on database
		$message .="<p>Error: Driver already on database – not entered.</p>";
		}
	}

echo $message;

?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?page=fantasyf1_f1data" method="post">

<label for="forename">Forename: </label><input type="text" name="forename" value="" /><br/>
<label for="surname">Surname: </label><input type="text" name="surname" value="" /><br/>

<input type="submit" name="submitdrivers" value="Add Driver" />
</form>