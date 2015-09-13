<?php
include 'session.php';
include 'connect.php';

$query = "INSERT INTO posts(acc_id, content, postdate, last_edited) " .
							"VALUES(:acc_id,:content,CURDATE(), NOW())";

$stmt = $db->prepare($query);
$stmt->execute(array(':acc_id' => $_SESSION['id'], ':content' =>  $_POST["post_content"]));

header("Location: messageboard.php"); /* Redirect browser */
exit();