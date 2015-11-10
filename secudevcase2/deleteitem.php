<?php
include 'session.php';
include 'connect.php';

if($_SESSION['accesslvl'] == "admin"){
	echo "<button type=\"button\" class=\"btn btn-warning\" onclick = \"location.href ='./store.php';\">Store</button>
			<br><br><br>";
	echo	'Remove items from the store<br><br>';
	if(isset($_SESSION['deleteresult'])){
		echo $_SESSION['deleteresult'] . '';
		unset($_SESSION['deleteresult']);
	}
	
	$stmt = $db->prepare("SELECT * FROM items WHERE stock > 0");
	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	echo '<h2>Item List:</h2>';
	
	if($stmt->rowCount()>0)
	{
		echo '<table class="table">';
		foreach($results as $key=>$row) {
			if($key%4 == 0)
				echo '<tr>';
			echo '<td class = "hovers">';
			echo '<div onclick="location.href=\'./viewitem.php?item_id=' . $row['id'] . '\';" id="item' . $key . '">';
			echo $row['name'] . '<br>' . $row['description'] . '<br>' . $row['price'];
			echo '<br><form action="deleteitemfromstore.php" method="POST">
 			<input type="hidden" name="itemid" value="'. $row['id'] .'">
			<input type=submit value = "Remove Item">
 					<br><br>
 			</form>';
			echo '</div>';
			echo "</td>";
			if($key%4 == 3)
				echo '</tr>';
		}
		echo '</table>';
	}
	else{
		echo	'There are no items available.';
	}
	
	
}

else{
	header("Location: ./store.php"); /* Redirect browser */
	exit();
}