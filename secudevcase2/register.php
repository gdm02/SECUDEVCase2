<?php 
	session_start();
	include 'connect.php';
	include 'stripper.php';
?>
<!DOCTYPE HTML>
<html lang = "en">
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	
	<style>
		
		/* body{
			background-color: #ADD6FF;
		}
		
		#header{
			font-family: "Comic Sans MS", cursive, sans-serif;
			font-size: 30px;
		}
		
		
		
		form {
			background-color: #94FF94;
			margin: auto;
			position: relative;
			width: 380px;
			height: 440px;
			font-family: "Comic Sans MS", cursive, sans-serif;
			font-size: 15px;
			font-style: italic;
			line-height: 23px;
			font-weight: bold;
			color: #1975FF;
			border-radius: 5px;
			padding: 10px;
			border: 1px solid black;
			box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
		}
		
		input{
			width: 370px;
		}
		
		
		
		#submit {
			background-color: #1975FF;
    		border-radius: 5px;
    		color: white;
    		font-family: "Comic Sans MS", cursive, sans-serif;
    		font-size: 15px;
    		border: 1px solid black;
    		width: 150px;
		}
	
		#submit:hover {
    		border: 1px solid white;
    		background: red;
    		box-shadow: 2px 2px 10px #777;
		}
		
		.buttonholder{
			text-align: center;
		}
		 */
		
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
		include 'validator.php';
		
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
		
		$valid = true;
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST["firstname"])){
				$firstnameErr = "First name must be supplied.";
				$valid = false;
			} else {
				if (preg_match("/^[a-zA-Z0-9 ]+$/", $_POST["firstname"])) {
					$firstname = clean_data($_POST["firstname"]);
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
					$lastname = clean_data($_POST["lastname"]);
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
				try{
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
				catch(Exception $e){
					$birthdateErr = "Invalid birthdate.";
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
			
			$aboutme = clean_data($_POST["aboutme"]);
			
			if (!isset($_POST["accesslvl"])){
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
				$query = "INSERT INTO accounts(fname, lname, gender, salutation, birthdate, username,password, about,level,joindate ) " .
						"VALUES(:fname,:lname,:gender, :salutation, :birthdate, :username, :password, :about, :level, CURDATE())";
				try{
					$stmt = $db->prepare($query);
					$stmt->execute(array
							(	':fname' => $_POST["firstname"], ':lname' =>  $_POST["lastname"], ':gender' =>  $_POST["gender"],
								':salutation' => $_POST["salutation"], ':birthdate' =>  $_POST["birthdate"], ':username' =>  $_POST["username"],
								':password' => $_POST["password"], ':about' =>  $_POST["aboutme"], ':level' =>  $_POST["accesslvl"]
								
							)
						);
					echo "<div id = \"success\">Registration successful. <a href='login.php'>Login</a> </div>";
				}
				catch(PDOException $e){
					echo "<div id = \"fail\">An error occured. Click <a href='main.php'>here</a> to go back to main page.</div>";
				}
				//header('Location: main.php');
				//exit();
			}
		}
		
		
	?>
	
	<h2 id = "header" align = "center">Registration Form</h2>
	<form class="form-horizontal" role="form" method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class = "form-group">	
		<label class="control-label col-sm-4">Firstname: </label>
		<span class = "error">* <?php echo $firstnameErr;?></span>
		<div class = "col-sm-4">
		<input class = "form-control" type = "text" name = "firstname" maxlength = '50' placeholder = "Enter first name"/>
		</div>
	</div>
	<div class = "form-group">	
		<label class="control-label col-sm-4">Lastname: </label>
		<span class = "error">* <?php echo $lastnameErr;?></span>
		<div class = "col-sm-4">
		<input class = "form-control" type = "text" name = "lastname" maxlength = '50' placeholder = "Enter last name"/>
		</div>
	</div>
	<div class = "form-group">
		<label class="control-label col-sm-4">Gender: </label>
		<div class = "col-sm-4 selectContainer">
		<select class = "form-control" name = "gender" id = "gender">
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
   		<span class = "error">* <?php echo $birthdateErr;?></span>
   		<div class = "col-sm-4">
   		<input class = "form-control" type = "date" name = "birthdate">
   		</div>
   	</div>
   	<div class = "form-group">
   		<label class="control-label col-sm-4">Username: </label>
   		<span class = "error">* <?php echo $usernameErr;?></span>
   		<div class = "col-sm-4">
   		<input class = "form-control" type = "text" name = "username" maxlength = '50' placeholder = "Enter username"/>
   		</div>
   	</div>
   	<div class = "form-group">
   		<label class="control-label col-sm-4">Password: </label>
   		<span class = "error">* <?php echo $passwordErr;?></span>
   		<div class = "col-sm-4">
   		<input class = "form-control" type = "password" name = "password" maxlength = '50' placeholder = "Enter password">
   		</div>
   	</div>
   	<div class = "form-group">
   		<label class="control-label col-sm-4">About Me: </label>
		<div class = "col-sm-4">
   		<textarea class = "form-control" name ="aboutme" id = "aboutme" rows = "4" cols = "50" data-parsley-maxlength = "255" placeholder = "Type something about yourself"></textarea>
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
					<option value = "User" id = "userlvl">User</option>
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
