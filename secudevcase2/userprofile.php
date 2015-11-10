

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
include 'session.php';
include 'connect.php';
if(isset($_REQUEST['userprofile']) && isset($_SESSION['signed_in']) && $_SESSION['signed_in'] = true)
{
	try{
		$stmt = $db->prepare("SELECT fname,lname, gender, birthdate, salutation, username, about, level, joindate, amount_donated, amount_purchased, num_posts FROM accounts WHERE username=:username");
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
							.'<br>
					<label>Badges: </label>';
					
					$postbadges = array(
							"Participant" => 1,
							"Chatter" => 2,
							"Socialite" => 3,
					);
					
					$donationbadges = array(
							"Participant" => 1,
							"Chatter" => 2,
							"Socialite" => 3,
					);
					
					$purchasebadges = array(
							"Participant" => 1,
							"Chatter" => 2,
							"Socialite" => 3,
					);
				
					$postbadge = "";
					$donationbadge = "";
					$purchasebadge = "";
					$collectionbadge= "";
					
					//posts
					$value = $row['num_posts'];
					if($value >= 10)
						$postbadge = 'Socialite';
					else if ($value >= 5)
						$postbadge = 'Chatter';
					else if ($value >= 3)
						$postbadge = 'Participant';
					
					//donations
					$value = $row['amount_donated'];
					if($value >= 100)
						$donationbadge = 'Pillar';
					else if ($value >= 20)
						$donationbadge = 'Contributor';
					else if ($value >= 5)
						$donationbadge = 'Supporter';
					
					//purchase
					$value = $row['amount_purchased'];
					if($value >= 100)
						$purchasebadge = 'Elite';
					else if ($value >= 20)
						$purchasebadge = 'Promoter';
					else if ($value >= 5)
						$purchasebadge = 'Shopper';
					
					//purchase
					if($value >= 100)
						$postbadge = 'Elite';
					else if ($value >= 20)
						$postbadge = 'Promoter';
					else if ($value >= 5)
						$postbadge = 'Shopper';
					
					echo $postbadge . ', ' . $donationbadge . ', ' . $purchasebadge;
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