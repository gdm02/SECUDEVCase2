<?php
	include 'session.php';
	
	if ($_SESSION['accesslvl'] == "admin") {
		echo '<label>Choose backup to download: <label><br><br>';
		$list = array();
		$list2 = array();
		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator('./backups/')) as $filename)
		{
			// filter out "." and ".."
			if ($filename->isDir()) continue;
			array_push($list, $filename);
			//echo "$filename" ;
		}
		
		foreach ($list as $value) {
			array_push($list2, str_replace('./backups\\', '', $value));
		}
		natsort($list2);
		foreach ($list2 as $value) {
			echo '<a href="downloadbackup.php?file=' . $value . '">' . $value . '<br>';
		}
		
		echo '<br><br><a href="./messageboard.php">Back to message board.';
	} else { //if not admin, cannot access
		header ("Location: ./error.php");
		exit();
	}
?>