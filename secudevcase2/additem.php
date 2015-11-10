<?php
include 'session.php';
include 'connect.php';

if($_SESSION['accesslvl'] == "admin"){
	echo "<button type=\"button\" class=\"btn btn-warning\" onclick = \"location.href ='./store.php';\">Store</button> 
			<br><br><br>";
	echo	'Add an item in the store<br><br>';
	if(isset($_SESSION['addresult'])){
		echo $_SESSION['addresult'] . '';
		unset($_SESSION['addresult']);
	}
	echo "<td><form method='POST' action='./additemtostore.php' enctype='multipart/form-data'>"
				."<input type='file' name='fileToUpload' id ='fileToUpload'>"
				."<input type = 'text' name ='name' placeholder = 'Item Name'><br>"
				."<textarea class = \"form-control\" name='description' rows='10' cols = '50' placeholder='Item Description'></textarea>"
				."<input type = 'text' name ='price' placeholder = 'Price'><br>"
				."<input type = 'text' name = 'stock' placeholder = 'Stock'><br>"
				."<br><input class=\"btn btn-success\" type='submit' name='submit-post' value='Add Item' />"
						."</form>";
}

else{
	header("Location: ./store.php"); /* Redirect browser */
	exit();
}