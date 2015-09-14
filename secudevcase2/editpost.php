<?php
include 'session.php';
include 'connect.php';
if(!isset($_SESSION['signed_in']) || $_SESSION['signed_in'] == false)
{
	header("Location: /main.php"); /* Redirect browser */
	exit();
}

$query = "UPDATE posts SET content = :newcontent, last_edited = NOW() WHERE id = :id";

try{
	$stmt = $db->prepare($query);
	$stmt->execute(array(':id' => $_POST['post_id'], ':newcontent' =>  $_POST["new_content"]));
}
catch(PDOException $e){
	
}
header("Location: messageboard.php"); /* Redirect browser */
exit();