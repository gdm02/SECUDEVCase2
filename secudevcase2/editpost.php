<?php
include 'session.php';
include 'connect.php';

$query = "UPDATE posts SET content = :newcontent, last_edited = NOW() WHERE id = :id";

$stmt = $db->prepare($query);
$stmt->execute(array(':id' => $_POST['post_id'], ':newcontent' =>  $_POST["new_content"]));

header("Location: messageboard.php"); /* Redirect browser */
exit();