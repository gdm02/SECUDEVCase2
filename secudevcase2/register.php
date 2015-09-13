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
					echo "invalid First Name";
					//$firstnameErr = "Only letters and white space allowed"; 
				}
			}
			if (empty($_POST["lastname"])){
				$firstnameErr = "Last name must be supplied.";
			} else {
				//if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
				//if (!preg_match("/^[a-zA-Z0-9 ]*$/", $firstname)) {
				if (preg_match("/^[a-zA-Z]+$/", $_POST["lastname"])) {
					//$firstname = $_POST["firstname"];
					echo "lastnamevalid";
				} else {
					echo "invalid Last Name";
					//$firstnameErr = "Only letters and white space allowed";
				}
			}
			if (empty($_POST["username"])){
				$firstnameErr = "Username must be supplied.";
			} else {
				//if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
				//if (!preg_match("/^[a-zA-Z0-9 ]*$/", $firstname)) {
				if (preg_match("/^[a-zA-Z_]+$/", $_POST["username"])) {
					//$firstname = $_POST["firstname"];
					echo "usernamevalid";
				} else {
					echo "invalid Username";
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
		<label>Lastname: </label>
		<input type = "text" name = "lastname" maxlength = '50'/>
		<br><br>
		<label>Gender: </label>
		<select name="gender">
   			<option value = "male" >Male</option>
   			<option value = "female" >Female</option>
   		</select>
   		<br><br>
   		<label>Salutation: </label>
   		<br><br>
   		<label>Birthdate: </label>
   		<input type = "date" name = "birthdate">
   		<br><br>
   		<label>Username: </label>
   		<input type = "text" name = "username" maxlength = '50'/>
   		<br><br>
   		<label>Password: </label>
   		<input type = "password" name = "password">
   		<br><br>
   		<label>About Me: </label>
   		<textarea name="comment" rows="5" cols="40"> </textarea>
   		<br><br>
		<input type = "submit" value = "Submit"/> 
	</form>
</body>
</html>
