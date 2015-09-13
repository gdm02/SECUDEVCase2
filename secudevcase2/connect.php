<?php
	$servername = 'localhost';
	$username   = 'root';
	$password   = '1234';
	$database   = 'forum';
	
	$db = new PDO('mysql:host=' . $servername . ';dbname=' . $database . ';charset=utf8', $username, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>