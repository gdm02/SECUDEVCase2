<?php 
	include 'session.php';
	include 'connect.php';
	include 'stripper.php';
	
?>
<!DOCTYPE HTML>
<html>
<head>
	<script src = "jquery-1.11.3.min.js"></script>
	<title>Edit Profile</title>
</head>
<body>
	<script>
		$(document).ready(function() {
			changeSalutation($('#gender').val());
			$('#gender').on("change", function() {
				changeSalutation($('#gender').val());
			});
			
			<?php if (isset($_SESSION['accesslvl']) && strtolower($_SESSION['accesslvl']) == "user") ?>
				$('#accesslvl').hide();
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
		include 'connect.php';
		$firstname = $lastname = $gender = $salutation = $birthdate = $password = $aboutme = $accesslvl = "";
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
		
		$valid = true;
		
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
			//echo $_SESSION['accesslvl'];
			if ($_SESSION['accesslvl'] == null && !isset($_POST["accesslvl"])) {
				$accesslvlErr = "Access level required.";
				$valid = false;
			} else {
				if (strtolower($_SESSION['accesslvl']) != "admin" && strtolower($_SESSION['accesslvl']) != "user") {
					$accesslvlErr = "Invalid access level.";
					$valid = false;
				}
			}
			
			if ($valid) { 
				$query = "UPDATE accounts SET fname = :fname, lname = :lname, gender = :gender, salutation = :salutation, birthdate = :birthdate, password = :password, about = :about WHERE username = :username";
				try{
					$stmt = $db->prepare($query);
					$stmt->execute(array
							(	':fname' => $_POST["firstname"], ':lname' =>  $_POST["lastname"], ':gender' =>  $_POST["gender"],
								':salutation' => $_POST["salutation"], ':birthdate' =>  $_POST["birthdate"],
								':password' => $_POST["password"], ':about' =>  $_POST["aboutme"], ':username' => $_SESSION["username"]
								
							)
						);
					$_SESSION['firstname'] = $_POST['firstname'];
					$_SESSION['lastname'] = $_POST['lastname'];
					$_SESSION['gender'] = $_POST['gender'];
					$_SESSION['salutation'] = $_POST['salutation'];
					$_SESSION['birthdate'] = $_POST['birthdate'];
					$_SESSION['password'] = $_POST['password'];
					$_SESSION['aboutme'] = $_POST['aboutme'];
					echo "Profile updated. <a href='messageboard.php'> Back to message board.</a>";
				}
				catch(PDOException $e){
					echo "An error occured. Click <a href='main.php'>here</a> to go back to main page.";
				}
				//header('Location: main.php');
				//exit();
			}
		}
	?>
	<form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Firstname: </label>
		<input type = "text" name = "firstname" maxlength = '50' value = "<?php echo $_SESSION['firstname']; ?>"/>
		<span class = "error">* <?php echo $firstnameErr;?></span>
		<br><br>
		<label>Lastname: </label>
		<input type = "text" name = "lastname" maxlength = '50' value = "<?php echo $_SESSION['lastname']; ?>"/>
		<span class = "error">* <?php echo $lastnameErr;?></span>
		<br><br>
		<label>Gender: </label>
		<select name = "gender" id = "gender" value = "<?php echo $_SESSION['gender']; ?>">
   			<option value = "male" >Male</option>
   			<option value = "female" >Female</option>
   		</select>
		<span class = "error">* <?php echo $genderErr;?></span>
   		<br><br>
   		<label>Salutation: </label>
		<select name = "salutation" id = "salutation"/>
		</select>
		<span class = "error">* <?php echo $salutationErr;?></span>
   		<br><br>
   		<label>Birthdate: </label>
   		<input type = "date" name = "birthdate" value = "<?php echo $_SESSION['birthdate']; ?>">
		<span class = "error">* <?php echo $birthdateErr;?></span>
   		<br><br>
   		<label>Username: </label>
		<?php echo $_SESSION['username']; ?>
   		<br><br>
   		<label>Password: </label>
   		<input type = "password" name = "password" maxlength = '50' value = "<?php echo $_SESSION['password']; ?>"/>
		<span class = "error">* <?php echo $passwordErr;?></span>
   		<br><br>
   		<label>About Me: </label>
		<br>
   		<textarea name ="aboutme" id = "aboutme" rows = "4" cols = "50" data-parsley-maxlength = "255"></textarea>
   		<br><br>
		<?php
			if (isset($_SESSION['accesslvl']) && !empty($_SESSION['accesslvl'])) {
				if (strtolower($_SESSION['accesslvl']) == "admin") { // replace with if session logged in user is admin
					echo '
					<label>Access level: </label>	
					<select name = "accesslvl" id = "accesslvl">
						<option value = "user" id = "userlvl">User</option>
						<option value = "admin" id = "adminlvl">Admin</option>
					</select>
					';
				} else {
					echo '
					<select name = "accesslvl" id = "accesslvl" value = "user">
					</select>
					';
				}
			} else {
				echo '
				<select name = "accesslvl" id = "accesslvl" value = "User">
				</select>
				';
			}
		?>
		<br><br>
		<label>* - required</label>
		<br> <br>
		<input type = "submit" value = "Submit"/> 
	</form>
</body>
</html>
