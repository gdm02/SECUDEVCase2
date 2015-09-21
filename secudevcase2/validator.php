<?php

function validate_post_edit($db, $id){
	$valid_id = "";
	try{
		$stmt = $db->prepare("SELECT acc_id FROM posts WHERE id = :id");
		$stmt->execute(array(':id' => $id));
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			$valid_id = $row['acc_id'];
	}
	catch(PDOException $e){
		
	}
	return $valid_id;
}