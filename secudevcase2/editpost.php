<?php
include 'session.php';
include 'connect.php';
include 'validator.php';

$valid_id = validate_post_edit($db, $_POST['post_id']);

if($_SESSION['id'] == $valid_id || $_SESSION['accesslvl'] == "admin") {

	$query = "UPDATE posts SET content = :newcontent, last_edited = NOW() WHERE id = :id";
	
	try{
		$stmt = $db->prepare($query);
		$stmt->execute(array(':id' => $_POST['post_id'], ':newcontent' =>  $_POST["new_content"]));
	}
	catch(PDOException $e){
		
	}
}

header("Location: messageboard.php"); /* Redirect browser */
exit();