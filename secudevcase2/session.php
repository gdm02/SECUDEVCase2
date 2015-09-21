<?php
	session_start();
	if(!isset($_SESSION['signed_in']) || $_SESSION['signed_in'] == false)
	{
		header("Location: /main.php"); /* Redirect browser */
		exit();
	}
?>