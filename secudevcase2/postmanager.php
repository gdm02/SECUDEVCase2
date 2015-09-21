<?php
include 'validator.php';

function submitpost(){

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
}
function editpost(){
	$valid_id = validate_post_edit();
	
	if($_SESSION['id'] == $valid_id) {
	
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
}

function deletepost(){
	$valid_id = validate_post_edit();
	
	if($_SESSION['id'] == $valid_id) {
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
}