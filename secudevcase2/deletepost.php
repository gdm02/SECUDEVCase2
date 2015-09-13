<?php
include 'session.php';
include 'connect.php';

$query = "DELETE FROM posts WHERE id = :id";

try{
	$stmt = $db->prepare($query);
	$stmt->execute(array(':id' => $_POST['post_id']));
}
catch(PDOException $e){

}
header("Location: messageboard.php"); /* Redirect browser */
exit();