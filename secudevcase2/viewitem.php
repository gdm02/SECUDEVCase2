<?php

include 'session.php';
include 'connect.php';

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['item_id'])) {
	try{
		$stmt = $db->prepare("SELECT * FROM items WHERE id = :itemid");
		$stmt->execute(array(':itemid' => $_GET['item_id']));
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo '<table>
			<tr>
				<td>Item</td>
				<td>Description</td>
				<td>Price</td>
			</tr>
			<tr>
				<td>'. $row['name'] . '</td>
				<td>'. $row['description'] . '</td>
				<td>'. $row['price'] . '</td>
			</tr>
			</table>';
		}
	}
	catch(Exception $e){
		
	}
}