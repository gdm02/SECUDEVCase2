<?php

include 'session.php';
include 'connect.php';

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['item_id'])) {
	echo "<button type=\"button\" class=\"btn btn-warning\" onclick = \"location.href ='./store.php';\">Store</button>
			<br><br><br>";
	
	try{
		$stmt = $db->prepare("SELECT * FROM items WHERE id = :itemid");
		$stmt->execute(array(':itemid' => $_GET['item_id']));
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo '<table><tr halign=left valign=top><td>';
			echo '<img src="/'. $row['imgpath'] .'" alt="Item: '. $row['name'].'" style = "width:128px;height:128px">';
			echo '</td><td>';
			echo '<table>
			<tr>
				<td>Price</td>
				<td><h3>'. $row['price'] . '</h3></td>
			</tr>
			<tr  halign=left valign=top>
				<td>Name</td>
				<td><h4>'. $row['name'] . '</h4></td>
				
			</tr>
			<tr  halign=left valign=top>
				<td>Description</td>
				<td>'. $row['description'] . '</td>
			</tr>
			</table></td></tr></table>';
			
			echo '<br><form action="shareitem.php" method=POST>
					<input type=hidden name=itemid value='. $row['id'] . '>
					<input type=submit value="Share this item"></form>';
		}
	}
	catch(Exception $e){
		echo 'Item cannot be displayed.';
	}
}