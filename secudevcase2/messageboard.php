<?php 
	session_start();
	include 'connect.php';
	include 'stripper.php';
	
	function showInputBox(){

		echo '<br><br>Color:
					<select id = "postcolor">
					<option value = "black">Black</option>
					<option value = "blue">Blue</option>
					<option value = "red">Red</option>
					<option value = "yellow">Yellow</option>
					<option value = "green">Green</option>
					</select>
					Font:
					<select id = "postfont">
					<option value = "arial">Arial</option>
					<option value = "times new roman">Times New Roman</option>
					</select>
					Font Size: <input id = "postfontsize" type = "number" min = "12" max = "14" value = "12">';
		
		echo "<br><br><form method='POST' action='/submitpost.php'>"
				."<textarea name='post_content' rows='10' cols = '50'/></textarea>"
				."<input type='submit' value='Post' />"
						."</form>";
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Global Message Boards</title>
	<style>
table, th, td {
    border: 2px solid black;
    border-collapse: collapse;
    text-align: center;
    padding: 4px;
}

button {
	color: blue;
	background-color: white;
	border: 0;
}
.post-container-odd {
	background-color: #FFFFCC;
	border: 0;
}
.post-container-even {
	background-color: white;
	border: 0;
}
#noborder {
	border: 0;
}
</style>
<script src = "jquery-1.11.3.min.js"></script>
<script type="text/javascript">
	function divClicked() {
	    var divToReplace = $(this).parent().closest('table').find('div.textpost'); //select's the contents of div immediately previous to the button
		var divHtml = divToReplace.html();
		var id = divToReplace.attr('id');
		//var divclass = divToReplace.attr('class');
		
	    var editableText = $("<textarea />", {
			name: 'new_content',
	        rows: '4',
	        cols: '50'
	    });
	    editableText.val(divHtml);

	    var newDiv = $('<div/>');
	    
	    var newForm = $('<form />', { 
		    		action:'/editpost.php',
		    		method:'POST' 
			    })
	    newForm.append('<input type="hidden" name="post_id" value="' + id + '" />');
	    newForm.append(editableText);
	    newForm.append('<input type="submit" value="Save Changes" />');

	    newDiv.append(newForm);
	    
	    var cancel = $('<button/>',
	    	    {
	    	        text: 'Cancel',
	    	        click: function () { 
		    	        editableText.blur(editableTextBlurred(id, newDiv, divHtml)); 
		    	        }
	    	    });
		newDiv.append(cancel);
	    
	    divToReplace.replaceWith(newDiv); //replaces the required div with textarea
	    editableText.focus();
	}
	
	function editableTextBlurred(div_id, target, html) {
	    var viewableText = $("<div>",{
		    	'class': 'textpost',
		    	id: div_id
	    	});
	    viewableText.html(html);
	    target.replaceWith(viewableText);
	}
	
	$(document).ready(function () {
	    $(".editpost").click(divClicked); //calls the function on button click
	});
</script>

</head>
<body>
	<?php
		class Paginator {
			private $_conn; //sql connection
			private $_limit;
			private $_page;
			private $_query;
			private $_total;
		}
		
		function __construct ( $conn, $query ) {
			$this->_conn = $conn;
			$this->_query = $query;
			
			$rs = $this -> _conn -> query ( $this -> _query );
			$this -> total = $rs -> num_rows;
		}
		

		
			showInputBox();

			$stmt = $db->query('SELECT posts.id, acc_id, content, postdate, last_edited, fname, username, joindate  
								FROM posts 
								INNER JOIN accounts
								ON posts.acc_id = accounts.id 
								ORDER BY last_edited DESC');
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			if($stmt->rowCount() > 0){
				foreach($results as $key=>$row) {
					echo "<div class='post-container-";
					if($key % 2 == 0)
						echo "even";
					else
						echo "odd";
					echo "'>";
					
					echo '<table border = "1" style = "width:100%">
					<tr>';
					echo 
					"<td> <a href='/userprofile.php?userprofile=" . $row['username'] . "'>". $row['fname'] . '</a></td>
					<td>Date Posted: ' .$row['postdate'] . '</td>';
					
					if($_SESSION['accesslvl'] == "admin" || $_SESSION['id'] == $row['acc_id']){
						echo '<td><button class="editpost">Edit</button></td>
						<td><button>Delete</button></td>';
					}
					
					echo "</tr>
					<tr>
					<td><a href='/userprofile.php?userprofile=" . $row['username'] . "'>" . $row['username'] . '</a></td>
					<td colspan="3">
					
					<div class = "textpost" id="'. $row['id'] .'">'. strip($row['content']) . '</div>
					</td>
					</tr>
					<tr>
					<td>Date Joined:'  . $_SESSION['joindate'] . '</td>
					<td colspan="3">Last Edited: ' . $row['last_edited'] . '</td>
					</tr>
					</table>';
					echo "</div>";
				}
			}
			else{
				echo "No posts to show. <br>";
			}
		
		
		//}
		
// 		form has been submitted
// 		else{
// 			$query = "INSERT INTO posts(acc_id, content, postdate, last_edited) " .
// 					"VALUES(:acc_id,:content,CURDATE(), NOW())";
		
// 			$stmt = $db->prepare($query);
// 			$stmt->execute(array(':acc_id' => $_SESSION['id'], ':content' =>  $_POST["post_content"]));
		
// 			header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"])); /* Redirect browser */
// 			exit();
// 		}
	?>
	

	
</body>
</html>
