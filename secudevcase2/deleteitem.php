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
	
}

else{
	header("Location: ./store.php"); /* Redirect browser */
	exit();
}