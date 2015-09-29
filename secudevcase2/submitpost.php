<?php
include 'session.php';
include 'connect.php';
include 'stripper.php';

$query = "INSERT INTO posts(acc_id, content, postdate, last_edited) " .
							"VALUES(:acc_id,:content,CURDATE(), NOW())";
try{
	$stmt = $db->prepare($query);
	$stmt->execute(array(':acc_id' => $_SESSION['id'], ':content' =>  strip($_POST["post_content"])));
	unset($_SESSION['search-details']);
	unset($_SESSION['parameters']);
}
catch(PDOException $e){
	
}
header("Location: messageboard.php"); /* Redirect browser */
exit();