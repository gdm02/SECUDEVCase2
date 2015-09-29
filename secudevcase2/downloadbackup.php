<?php
	include 'session.php';
	
	if ($_SESSION['accesslvl'] == "admin") {
		$file = basename($_GET['file']);
		$filename = $file;
		$file = './backups/' . $file;
		
		if ($file) {
			header("Content-type: text/csv");
			header("Content-disposition: attachment; filename=\"$filename\"");
			readfile($file);
		} else {
			die ('File not found');
		}
	} else {
		header ("Location: ./error.php");
		exit();
	}
?>