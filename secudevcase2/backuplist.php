<?php
	include 'session.php';
	
	if ($_SESSION['accesslvl'] == "admin") {
		$list = array();
		
		echo '<label>Choose backup to download: <label><br><br>';
		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator('./backups/')) as $filename) {
			if ($filename->isDir()) continue;
			array_push($list, str_replace('./backups\\', '', $filename));
		}
		
		natsort($list);
		
		foreach ($list as $value) {
			echo '<a href="downloadbackup.php?file=' . $value . '">' . $value . '<br>';
		}
		
		echo '<br><br><a href="./messageboard.php">Back to message board.';
	} else { //if not admin, cannot access
		header ("Location: ./error.php");
		exit();
	}
?>