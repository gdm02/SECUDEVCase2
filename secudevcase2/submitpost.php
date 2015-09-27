<?php
include 'session.php';
include 'connect.php';
include 'stripper.php';

$query = "INSERT INTO posts(acc_id, content, postdate, last_edited) " .
							"VALUES(:acc_id,:content,CURDATE(), NOW())";
try{
	$stmt = $db->prepare($query);
	$stmt->execute(array(':acc_id' => $_SESSION['id'], ':content' =>  strip($_POST["post_content"])));
	$_SESSION['search-details'] = "";
}
catch(PDOException $e){
	
}
header("Location: messageboard.php"); /* Redirect browser */
exit();