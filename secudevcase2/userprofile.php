<?php
session_start();
include 'connect.php';
if(isset($_REQUEST['userprofile']) && isset($_SESSION['signed_in']) && $_SESSION['signed_in'] = true)
{
	$stmt = $db->prepare("SELECT fname,lname, gender, birthdate, salutation, username, about, level, joindate FROM accounts WHERE username=:username");
	$stmt->execute(array(':username' => $_REQUEST['userprofile']));
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		echo
			'User profile: <br><label>Firstname: </label>'.
			$row['fname']
			.'<br>
			<label>Surname: </label>'.
					$row['lname']
					.'<br>
			<label>Username: </label>'.
					$row['username']
					.'<br>
			<label>Gender: </label>'.
					$row['gender']
					.'<br>
			<label>Date Joined:</label>'.
					$row['joindate']
					.'<br>
			<label>Salutation:</label>'.
					$row['salutation']
					.'<br>
			<label>Birthdate: </label>'.
					$row['birthdate']
					.'<br>
			<label>About Me: </label>'.
					$row['about']
					.'<br> <br>';
	}
}
else{
	echo 'No information can be displayed.';
}