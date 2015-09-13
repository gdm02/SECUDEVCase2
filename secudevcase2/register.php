<!DOCTYPE HTML>
<html>
<head>
	<script src = "jquery-1.11.3.min.js"></script>
	<title>Registration</title>
</head>

<body>
	<script>
		$(document).ready(function() {
			changeSalutation($('#gender').val());
			$('#gender').on("change", function() {
				changeSalutation($('#gender').val());
			});
		});
		
		function changeSalutation(gender) {
			$('#salutation').empty();
			if (gender == "male") {
				$('#salutation').append('<option value = "Mr">Mr</option>');
				$('#salutation').append('<option value = "Sir">Sir</option>');
				$('#salutation').append('<option value = "Senior">Senior</option>');
				$('#salutation').append('<option value = "Count">Count</option>');
			} else if (gender == "female") {
				$('#salutation').append('<option value = "Miss">Miss</option>');
				$('#salutation').append('<option value = "Ms">Ms</option>');
				$('#salutation').append('<option value = "Mrs">Mrs</option>');
				$('#salutation').append('<option value = "Madame">Madame</option>');
				$('#salutation').append('<option value = "Majesty">Majesty</option>');
				$('#salutation').append('<option value = "Seniora">Seniora</option>');
			}
		}
	</script>
	
	<?php
		$firstname = $lastname = $gender = $salutation = $birthdate = $username = $password = $aboutme = $accesslvl = "";
		$firstnameErr = $lastnameErr = $genderErr = $salutationErr = $birthdateErr = $usernameErr = $passwordErr = $aboutmeErr = $accesslvlErr = "";
		
		// For checking
		$maleSalutations = array('Mr', 'Sir', 'Senior', 'Count');
		$femaleSalutations = array('Miss', 'Ms', 'Mrs', 'Madame', 'Majesty', 'Seniora');
		$dateToday = date_create(date("Y-m-d"));
	
		/*
		function pageRedirect ($page) {
			if (!@header("Location: ".$page))
				echo '\n<script type=\"text/javascript\">window.location.replace('$page');</script>\n';
			exit;
		}
		*/
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST["firstname"])){
				$firstnameErr = "First name must be supplied.";
				$valid = false;
			} else {
				if (preg_match("/^[a-zA-Z0-9 ]+$/", $_POST["firstname"])) {
					$firstname = $_POST["firstname"];
				} else {
					$firstnameErr = "Invalid input."; 
					$valid = false;
				}
			}
			
			if (empty($_POST["lastname"])){
				$lastnameErr = "Last name must be supplied.";
				$valid = false;
			} else {
				if (preg_match("/^[a-zA-Z0-9 ]+$/", $_POST["lastname"])) {
					$lastname = $_POST["lastname"];
				} else {
					$lastnameErr = "Invalid input.";
					$valid = false;
				}
			}
			
			if (empty($_POST["gender"])) {
				$genderErr = "Gender must not be left blank.";
				$valid = false;
			} else {
				if (strtolower($_POST["gender"]) == "male" || strtolower($_POST["gender"]) == "female") {
					$gender = $_POST["gender"];
				} else {
					$genderErr = "Invalid gender.";
					$valid = false;
				}
			}
			
			if (empty($_POST["salutation"])) {
				$salutationErr = "Salutation must not be left blank.";
				$valid = false;
			} else {
				if ($_POST["gender"] == "male" && in_array($_POST["salutation"], $maleSalutations) || $_POST["gender"] == "female" && in_array($_POST["salutation"], $femaleSalutations)) {
					$salutation = $_POST["salutation"];
				} else {
					$salutationErr = "Invalid salutation.";
					$valid = false;
				}
			}
			
			if (empty($_POST["birthdate"])) {
				$birthdateErr = "Birthdate must not be left blank.";
				$valid = false;
			} else {
				$inputDate = date_create($_POST["birthdate"]);
				$interval = $inputDate -> diff ($dateToday);
				$age = $interval -> y;
				if ($age >= 18) {
					$birthdate = $_POST["birthdate"];
				} else {
					$birthdateErr = "You must be over 18 to register.";
					$valid = false;
				}
			}
			
			if (empty($_POST["username"])){
				$usernameErr = "Username must be supplied.";
				$valid = false;
			} else {
				if (preg_match("/^[a-zA-Z0-9_ ]+$/", $_POST["username"])) {
					$username = $_POST["username"];
				} else {
					$usernameErr = "Invalid username.";
					$valid = false;
				}
			}
			
			if (empty($_POST["password"])){
				$passwordErr = "Password must be supplied.";
				$valid = false;
			} else {
				if (preg_match("/^[^\s]+$/", $_POST["password"])) {
					$password = $_POST["password"];
				} else {
					$passwordErr = "Passwords cannot contain whitespaces.";
					$valid = false;
				}
			}
			
			$aboutme = $_POST["aboutme"];
			
			if (empty($_POST["accesslvl"])){
				$accesslvlErr = "Access level required.";
				$valid = false;
			} else {
				if (strtolower($_POST["accesslvl"]) == "admin" || strtolower($_POST["accesslvl"]) == "user") {
					$accesslvl = $_POST["accesslvl"];
				}
				else {
					$accesslvlErr = "Invalid access level.";
					$valid = false;
				}
			}
			
			if ($valid) {
				header('Location: main.php');
				exit();
			}
		}
		
		// To be added later, for security
		/*
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		*/
		/*<form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">*/
	?>
	<form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Firstname: </label>
		<input type = "text" name = "firstname" maxlength = '50'/>
		<span class = "error">* <?php echo $firstnameErr;?></span>
		<br><br>
		<label>Lastname: </label>
		<input type = "text" name = "lastname" maxlength = '50'/>
		<span class = "error">* <?php echo $lastnameErr;?></span>
		<br><br>
		<label>Gender: </label>
		<select name = "gender" id = "gender">
   			<option value = "male" >Male</option>
   			<option value = "female" >Female</option>
   		</select>
		<span class = "error">* <?php echo $genderErr;?></span>
   		<br><br>
   		<label>Salutation: </label>
		<select name = "salutation" id = "salutation">
		</select>
		<span class = "error">* <?php echo $salutationErr;?></span>
   		<br><br>
   		<label>Birthdate: </label>
   		<input type = "date" name = "birthdate">
		<span class = "error">* <?php echo $birthdateErr;?></span>
   		<br><br>
   		<label>Username: </label>
   		<input type = "text" name = "username" maxlength = '50'/>
		<span class = "error">* <?php echo $usernameErr;?></span>
   		<br><br>
   		<label>Password: </label>
   		<input type = "password" name = "password" maxlength = '50'>
		<span class = "error">* <?php echo $passwordErr;?></span>
   		<br><br>
   		<label>About Me: </label>
		<br>
   		<textarea name ="aboutme" id = "aboutme" rows = "4" cols = "50" data-parsley-maxlength = "255"></textarea>
   		<br><br>
		<label>Access level: </label>	
		<select name = "accesslvl" id = "accesslvl">
			<option value = "User" id = "userlvl">User</option>
			<option value = "Admin" id = "adminlvl">Admin</option>
		</select>
		<br><br>
		<label>* - required</label>
		<br> <br>
		<input type = "submit" value = "Submit"/> 
	</form>
</body>
</html>
