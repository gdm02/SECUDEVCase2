<!DOCTYPE HTML>
<html>
<head>
	<title>Registration</title>
</head>

<body>
	<?php
		$firstname = $lastname = $gender = $salutation = $birthdate = $username = $password = $aboutme = $accesslvl = "";
		$firstnameErr = $lastnameErr = $genderErr = $salutationErr = $birthdateErr = $usernameErr = $passwordErr = $aboutmeErr = $accesslvlErr = "";
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST["firstname"])){
				$firstnameErr = "First name must be supplied.";
			} else {
				//if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
				//if (!preg_match("/^[a-zA-Z0-9 ]*$/", $firstname)) {
				if (preg_match("/^[a-zA-Z]+$/", $_POST["firstname"])) {
					//$firstname = $_POST["firstname"];
					echo "firstnamevalid";
				} else {
					echo "invalid";
					//$firstnameErr = "Only letters and white space allowed"; 
				}
			}
		}
		
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	?>

	<form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Firstname: </label>
		<input type = "text" name = "firstname" maxlength = '50'/>
		<br><br>
		<input type = "submit" value = "Submit"/> 
	</form>
</body>
</html>
