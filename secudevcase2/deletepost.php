<?php
include 'session.php';
include 'connect.php';
include 'validator.php';

$valid_id = validate_post_edit($db, $_POST['post_id']);

if($_SESSION['id'] == $valid_id || $_SESSION['accesslvl'] == "admin") {
	$query = "DELETE FROM posts WHERE id = :id";
	
	try{
		$stmt = $db->prepare($query);
		$stmt->execute(array(':id' => $_POST['post_id']));
	}
	catch(PDOException $e){
	
	}
}
header("Location: messageboard.php"); /* Redirect browser */
exit();
