<?php
include 'session.php';
include 'connect.php';

if(!isset($_SESSION['signed_in']) || $_SESSION['signed_in'] == false)
{
	header("Location: /main.php"); /* Redirect browser */
	exit();
}

$query = "INSERT INTO posts(acc_id, content, postdate, last_edited) " .
							"VALUES(:acc_id,:content,CURDATE(), NOW())";
try{
	$stmt = $db->prepare($query);
	$stmt->execute(array(':acc_id' => $_SESSION['id'], ':content' =>  $_POST["post_content"]));
}
catch(PDOException $e){
	
}
header("Location: messageboard.php"); /* Redirect browser */
exit();