

<head>
	
	<style>
	
		body {
			background-color: #ADD6FF;
			text-align: center;
			color: green;
			font-family: "Comic Sans MS", cursive, sans-serif;
			font-size: 20px;
		}
		
		label{
			font-size: 20px;
			font-style: italic;
			font-weight: bold;
			color: #1975FF;
		}
		
	</style>
	
</head>

<body>

<?php
session_start();
include 'connect.php';
if(isset($_REQUEST['userprofile']) && isset($_SESSION['signed_in']) && $_SESSION['signed_in'] = true)
{
	try{
		$stmt = $db->prepare("SELECT fname,lname, gender, birthdate, salutation, username, about, level, joindate FROM accounts WHERE username=:username");
		$stmt->execute(array(':username' => $_REQUEST['userprofile']));
		if($stmt->rowCount() > 0)
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
					<label>Date Joined: </label>'.
							$row['joindate']
							.'<br>
					<label>Salutation: </label>'.
							$row['salutation']
							.'<br>
					<label>Birthdate: </label>'.
							$row['birthdate']
							.'<br>
					<label>About Me: </label>'.
							$row['about']
							.'<br> <br>';
			}
		else{
			echo '<label>No information can be displayed.</label>';
		}
	}
	catch(PDOException $e){
		echo '<label>No information can be displayed.</label>';
	}
}
else{
	echo '<label>No information can be displayed.</label>';
}
?>

</body>