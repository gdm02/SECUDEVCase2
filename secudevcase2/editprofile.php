<?php 
	session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Edit Profile</title>
</head>
<body>
	<?php
		$_SESSION["firstname"] = "Gabriel";
		$_SESSION["lastname"] = "del Mundo";
		$_SESSION["gender"] = "Male";
		$_SESSION["salutation"] = "Count";
		$_SESSION["birthdate"] = "March 16 1996";
		$_SESSION["aboutme"] = "Hi\nI'm a noob";
		print_r($_SESSION);
	?>
	
	<form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Firstname: </label>
		<?php echo $_SESSION["firstname"]?>
		<input type = "text" name = "firstname" maxlength = "50"/>
		<br> <br>
		<label>Surname: </label>
		<?php echo $_SESSION["lastname"]?>
		<br> <br>
		<label>Gender: </label>
		<?php echo $_SESSION["gender"]?>
		<br> <br>
		<label>Salutation:</label>
		<?php echo $_SESSION["salutation"]?>
		<br> <br>
		<label>Birthdate: </label>
		<?php echo $_SESSION["birthdate"]?>
		<br> <br>
		<label>Password: </label>
		<br> <br>
		<label>About Me: </label>
		<?php echo $_SESSION["aboutme"]?>
		<br> <br>
		<input type = "submit" name = "submit" id = "submit" value = "Confirm changes"/>
	</form>
</body>
</html>
