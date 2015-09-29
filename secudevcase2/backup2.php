<?php
	//include 'connect.php';
?>
<?php
	class backup 
	{
		/*
		private $db;
 
		function __construct($DB_con)
		{
			$this->db = $DB_con;
		}
		*/
		function getLastNo()
		{
			$dir = "./backups/";
			$fi = new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS);
			return iterator_count($fi);
		}
		
		function create()
		{
			try {
				$query = "SELECT a.username AS 'Username', p.postdate AS 'Date Posted', p.content AS 'Post' FROM posts p, accounts a WHERE p.acc_id = a.id ORDER BY p.postdate DESC;";
				$stmt = $db->prepare($query);
				$stmt->execute();
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				$lastno = getLastNo();
				$filename = "./backups/backup" . $lastno . ".csv";
				echo $filename;
				echo $query;
				$fp = fopen($filename, 'w');
				
				foreach($results as $key=>$row) {
					fputcsv($fp, $row);
				}
				
				fclose($fp);
			} catch (PDOException $e) {
				//alert("Backup failed.");
				//return 1;
				echo("Backup failed.");
				return 1;
			}
			
			echo("Backup success.");
			return 0;
			//alert("Backup success.");
			//return 0;
		}
	}
	
?>