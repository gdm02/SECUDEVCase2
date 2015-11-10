<?php
include 'session.php';
include 'connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$query = "SELECT * FROM items WHERE id = :id";
	
	try{
		$stmt = $db->prepare($query);
		$stmt->execute(array(':id' => $_POST['itemid']));
		
		//show item
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo "Share this item<br><br>";
			echo "<form method='POST' class='post-form' action='./submitpost.php'>"
					."<textarea class = \"form-control\" name='post_content' rows='10' cols = '50' placeholder='Say something about this'></textarea>";
						
			echo '<div>' . $row['name'] . '<br>'
						. $row['price'] . '<br>
							<img src="/'. $row['imgpath'] .'" alt="Item: '. $row['name'].'" style = "width:128px;height:128px"> <br>';
			echo "<br><input class=\"btn btn-success\" type='submit' name='submit-post' value='Share' /></form>";
			echo "<button type=\"button\" class=\"btn btn-warning\" onclick = \"history.go(-1);\">Cancel</button>
			";
			
			$_SESSION['itemid'] = $row['id'];
		}
	}
	catch(Exception $e){
		echo "Error, please try again. Back to <a href='./store.php'>store</a>";	
	}
	
}
else{
	header("Location: ./store.php"); /* Redirect browser */
	exit();
}
