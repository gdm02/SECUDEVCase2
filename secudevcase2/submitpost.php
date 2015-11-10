<?php
include 'session.php';
include 'connect.php';
include_once 'library/HTMLPurifier.auto.php';

$query = "INSERT INTO posts(acc_id, content, postdate, last_edited) " .
							"VALUES(:acc_id,:content,CURDATE(), NOW())";
try{
	if($_POST["post_content"] == ""){
		header("Location: ./messageboard.php"); /* Redirect browser */
		exit();
	}
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
			$append = '<br><br><div>' . $row['name'] . '<a href=viewitem.php?item_id=' . $itemid . '>
					<br><img src="/'. $row['imgpath'] .'" alt="Item: '. $row['name'].'" style = "width:128px;height:128px"></div>';
		}
		
		$content .= $append;
	}
	
	$stmt = $db->prepare($query);
	$stmt->execute(array(':acc_id' => $_SESSION['id'], ':content' => $content));
	
	//update user stats
	$stmt = $db->prepare("SELECT num_posts FROM accounts WHERE id = :id");
	$stmt->execute(array(':id'=>$_SESSION['id']));
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$value = $row['num_posts'];
		$value++;
	}
	//echo $value;
	$stmt = $db->prepare("UPDATE accounts SET num_posts = :value WHERE id = :id");
	$stmt->execute(array(':value'=>$value,':id' => $_SESSION['id']));
	
	unset($_SESSION['search-details']);
	unset($_SESSION['parameters']);
}
catch(PDOException $e){
	echo $e;
}
catch(Exception $e){
	echo $e;
}

	//header("Location: ./messageboard.php"); /* Redirect browser */
	//exit();
