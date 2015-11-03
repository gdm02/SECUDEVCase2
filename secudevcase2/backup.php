<?php
	include 'session.php';
	include 'connect.php';
	
	function getLastNo()
	{
		//$dir = "./backups/";
		//$dir = "http" . (($_SERVER["HTTPS"] == "on") ? "s://" : "://") . $_SERVER['HTTP_HOST'];
		//$dir = $_SERVER["DOCUMENT_ROOT"] . "/backups/";
		$dir = $_SERVER["HTTP_HOST"] . "/backups/";
		$fi = new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS);
		return iterator_count($fi);
	}
	
	if ($_SESSION['accesslvl'] == "admin") {
		//$dir = $_SERVER["DOCUMENT_ROOT"] . "/backups/";
		$dir = $_SERVER["HTTP_HOST"] . "/backups/";
		try {
			$query = "SELECT a.username AS 'Username', p.postdate AS 'Date Posted', p.content AS 'Post' FROM posts p, accounts a WHERE p.acc_id = a.id ORDER BY p.postdate DESC;";
			$stmt = $db->prepare($query);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$lastno = getLastNo();
			//$filename = "./backups/backup" . $lastno . ".csv";
			$filename = $dir . "backup" . $lastno . ".csv";
			
			while (file_exists($filename)) {
				$lastno++;
				//$filename = "./backups/backup" . $lastno . ".csv";
				$filename = $dir . "backup" . $lastno . ".csv";
			}
			
			
			$fp = fopen($filename, 'w');
			
			$colheaders = array ('Username', 'Date Posted', 'Post');
			fputcsv ($fp, $colheaders);
			
			foreach($results as $key=>$row) {
				fputcsv($fp, $row);
			}
			
			fclose($fp);
		} catch (PDOException $e) {
			//alert("Backup failed.");
			//return 1;
			header("Location: ./error.php");
			exit();
		}
		
		//return 0;
		header("Location: ./messageboard.php");
		exit();
	} else {
		header("Location: ./error.php");
		exit();
	}
	
?>