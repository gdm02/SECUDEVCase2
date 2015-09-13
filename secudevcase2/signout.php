<?php
	session_start();
	session_destroy();
	echo "You have been logged out.";
	header("Location: login.php"); /* Redirect browser */
	exit();
?>