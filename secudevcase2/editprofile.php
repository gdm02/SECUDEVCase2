<?php 
	include 'session.php';
	include 'connect.php';
	include 'stripper.php';
	
?>
<!DOCTYPE HTML>
<html>
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	<script src = "jquery-1.11.3.min.js"></script>
	
	<style>
	
		body {
			background-color: lavender;
		}
		
		textarea {
   			resize: none;
		}
		
		#header {
			font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
			font-size: 40px;
		}
		
		#success{
			text-align: center;
			color: #33CC33;
			font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
			font-size: 25px;
		}
		
		#fail{
			text-align: center;
			color: red;
			font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
			font-size: 25px;
		}
		
		#required{
			color: red;
		}
		
		span{
			color: red;
		}
	
	</style>
	
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
		
		echo "<br><a class=\"btn btn-success\" href='messageboard.php'> < Back to Message Board </a>";
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
					echo "<div id = \"success\"> Profile updated.</div> ";
				}
				catch(PDOException $e){
					echo "<div id = \"fail\">An error occured. Click <a href='main.php'>here</a> to go back to main page.</div>";
				}
				//header('Location: main.php');
				//exit();
			}
		}
	?>
	<h2 id = "header" align = "center">Edit Profile</h2>
	<form class="form-horizontal" role="form" method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class = "form-group">		
		<label class="control-label col-sm-4">Firstname: </label>
		<div class = "col-sm-4">
		<input class = "form-control" type = "text" name = "firstname" maxlength = '50' value = "<?php echo $_SESSION['firstname']; ?>"/>
		</div>
		<span class = "error">* <?php echo $firstnameErr;?></span>
	</div>
	<div class = "form-group">
		<label class="control-label col-sm-4">Lastname: </label>
		<div class = "col-sm-4">
		<input class = "form-control" type = "text" name = "lastname" maxlength = '50' value = "<?php echo $_SESSION['lastname']; ?>"/>
		</div>
		<span class = "error">* <?php echo $lastnameErr;?></span>
	</div>
	<div class = "form-group">
		<label class="control-label col-sm-4">Gender: </label>
		<div class = "col-sm-4 selectContainer">
		<select class = "form-control" name = "gender" id = "gender" value = "<?php echo $_SESSION['gender']; ?>">
   			<option value = "male" >Male</option>
   			<option value = "female" >Female</option>
   		</select>
   		</div>
		<span class = "error">* <?php echo $genderErr;?></span>
   	</div>
   	<div class = "form-group">
   		<label class="control-label col-sm-4">Salutation: </label>
   		<div class = "col-sm-4 selectContainer">
		<select class = "form-control" name = "salutation" id = "salutation">
		</select>
		</div>
		<span class = "error">* <?php echo $salutationErr;?></span>
   	</div>
   	<div class = "form-group">
   		<label class="control-label col-sm-4">Birthdate: </label>
   		<div class = "col-sm-4">
   		<input class = "form-control" type = "date" name = "birthdate" value = "<?php echo $_SESSION['birthdate']; ?>">
   		</div>
		<span class = "error">* <?php echo $birthdateErr;?></span>
   	</div>
   	<div class = "form-group">
   		<label class="control-label col-sm-4">Username: </label>
   		<div class = "col-sm-4">
		<label class = "form-control"> <?php echo $_SESSION['username']; ?> </label>
		</div>
   	</div>
   	<div class = "form-group">
   		<label class="control-label col-sm-4">Password: </label>
   		<div class = "col-sm-4">
   		<input class = "form-control" type = "password" name = "password" maxlength = '50' value = "<?php echo $_SESSION['password']; ?>"/>
   		</div>
		<span class = "error">* <?php echo $passwordErr;?></span>
   	</div>
   	<div class = "form-group">
   		<label class="control-label col-sm-4">About Me: </label>
		<div class = "col-sm-4">
   		<textarea class = "form-control" name ="aboutme" id = "aboutme" rows = "4" cols = "50" data-parsley-maxlength = "255"></textarea>
   		</div>
   </div>
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
		<div class = "form-group">
		<label class="control-label col-sm-6" id = "required">* - required</label>
	</div>
		<div class="control-label col-sm-6">
			<input class="btn btn-success" id = "submit" type = "submit" value = "Submit"/>
		</div>
	</form>
</body>
</html>
