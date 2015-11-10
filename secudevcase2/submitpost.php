<?php
include 'session.php';
include 'connect.php';
include_once 'library/HTMLPurifier.auto.php';

$query = "INSERT INTO posts(acc_id, content, postdate, last_edited) " .
							"VALUES(:acc_id,:content,CURDATE(), NOW())";
try{
	$purifier = new HTMLPurifier();
	$content = $purifier->purify($_POST["post_content"]);
	
	$share = false;
	
	//if sharing item
	if(isset($_SESSION['itemid'])){
		$share = true;
		
		$itemid = $_SESSION['itemid'];
		unset($_SESSION['itemid']);
		
		$stmt = $db->prepare("SELECT * FROM items WHERE id = :id");
		$stmt->execute(array(':id' => $itemid));
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$append = '<br><div>' . $row['name'] . '<a href=viewitem.php?item_id=' . $itemid . '>
					<br><img src=""></div>';
		}
		
		$content .= $append;
	}
	
	$stmt = $db->prepare($query);
	$stmt->execute(array(':acc_id' => $_SESSION['id'], ':content' => $content));
	unset($_SESSION['search-details']);
	unset($_SESSION['parameters']);
}
catch(PDOException $e){
	
}

	header("Location: ./messageboard.php"); /* Redirect browser */
	exit();
