<?php
include 'session.php';
include 'connect.php';

if(!isset($_SESSION['signed_in']) || $_SESSION['signed_in'] == false)
{
	header("Location: /main.php"); /* Redirect browser */
	exit();
}

$query = "DELETE FROM posts WHERE id = :id";

try{
	$stmt = $db->prepare($query);
	$stmt->execute(array(':id' => $_POST['post_id']));
}
catch(PDOException $e){

}
header("Location: messageboard.php"); /* Redirect browser */
exit();