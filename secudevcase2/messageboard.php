<?php 
	include 'session.php';
	include 'connect.php';
	include 'stripper.php';
	
	$current_id = $_SESSION['id'];
?>
<!DOCTYPE HTML>
<html>
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	<title>Global Message Boards</title>
	<style>
	
		/* body{
			background-color: #ADD6FF;
		}
	
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
		
		div, textarea, table, td, th, code, pre, samp {
			word-wrap: break-word;
		}
		.left {
   			float: left;
		}
		.w50 {
    		width: 50%;
		} */
		
		body{
			background-color: lavender;
		}
		
		label{
			font-size: 18px;
		}
		
		.maint{
			text-align: center;
			width: 90%;
		}
		
		td {
			padding: 12px;
		}
		
		textarea {
   			resize: none;
   			width: 90%;
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
		    		'class': 'post-form',
		    		action:'./editpost.php',
		    		method:'POST' 
			    })
	    newForm.append('<input type="hidden" name="post_id" value="' + id + '" />');
	    newForm.append(editableText);
	    newForm.append('<input type="submit" name="edit-post" value="Save Changes" />');

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
		var _cur_id = <?php echo json_encode($_SESSION['id']) ?>;
	    $(".editpost").click(divClicked); //calls the function on button click
	    
	    	
	});
</script>

</head>
<body>

	<?php 
	
	function showInputBox(){
// 		echo 'Color:
// 					<select id = "postcolor">
// 					<option value = "black">Black</option>
// 					<option value = "blue">Blue</option>
// 					<option value = "red">Red</option>
// 					<option value = "yellow">Yellow</option>
// 					<option value = "green">Green</option>
// 					</select>
// 					Font:
// 					<select id = "postfont">
// 					<option value = "arial">Arial</option>
// 					<option value = "times new roman">Times New Roman</option>
// 					</select>
// 					Font Size: <input id = "postfontsize" type = "number" min = "12" max = "14" value = "12">';
		
		echo "<td><form method='POST' class='post-form' action='./submitpost.php'>"
				."<textarea name='post_content' rows='10' cols = '50'/></textarea>"
				."<br><input class=\"btn btn-success\" type='submit' name='submit-post' value='Post' />"
						."</form> </td>";
	}
	?>

	<?php
		/*
		function __construct ( $conn, $query ) {
			$this->_conn = $conn;
			$this->_query = $query;
			
			$rs = $this -> _conn -> query ( $this -> _query );
			$this -> total = $rs -> num_rows;
		}
		
		$submit_key = "submit-post";
		$delete_key = "delete-post";
		$edit_key = "edit-post";
		*/
		if($current_id != $_SESSION['id']){
			header("Location: userreset.php"); /* Redirect browser */
			// 				exit();
		}
// 		if($_SERVER['REQUEST_METHOD'] == 'POST'){
// 			if($current_id == $_SESSION['id']){
// 				if(isset($_POST[$submit_key]))
// 					echo "submit submitted";
// 				else if(isset($_POST[$delete_key]))
// 					echo "delete submitted";
// 				else if(isset($_POST[$edit_key]))
// 					echo "edit submitted";
// 				else 
// 					echo "Invalid request.";
// 			}
// 			else{
// 				header("Location: userreset.php"); /* Redirect browser */
// 				exit();
// 			}
// 		}
		
			echo "<table class = \"maint\"><tr><td valign=\"top\" rowspan=\"2\">
				<div class=\"btn-group\">
				<button type=\"button\" class=\"btn btn-warning\" onclick = \"location.href ='./editprofile.php';\">Edit Profile</button> 
				<button type=\"button\" class=\"btn btn-danger\" onclick = \"location.href ='./signout.php';\">Logout</button>
				 </div>";
			echo 
					'<h3 class="text-info">User Info: </h3>
					<label class="text-info">Firstname: </label>'.
					$_SESSION["firstname"]
					.'<br>
					<label class="text-info">Surname: </label>'.
					$_SESSION["lastname"]
					.'<br>
					<label class="text-info">Gender: </label>'.
					$_SESSION["gender"]
					.'<br>
					<label class="text-info">Date Joined:</label>'.
					$_SESSION["joindate"]
					.'<br>
					<label class="text-info">Salutation:</label>'.
					$_SESSION["salutation"]
					.'<br>
					<label class="text-info">Birthdate: </label>'.
					$_SESSION["birthdate"]
					.'<br>
					<label class="text-info">About Me: </label>'.
					clean_data($_SESSION["aboutme"])
					.'<br> <br> </td>';
			
			showInputBox();
			
			echo " </tr>";
			
			$sql = 'SELECT posts.id, acc_id, content, postdate, last_edited, fname, username, joindate  
								FROM posts 
								INNER JOIN accounts
								ON posts.acc_id = accounts.id 
								ORDER BY last_edited DESC
								LIMIT :limit';
			$limit = 10;
			
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			echo "<td> <table class=\"table table-bordered\" align='center' width='50%'>
				<tr>
					<td>
						<table align='center' border='1' width='100%' height='100%' id='data'>";
						//$query = "SELECT * FROM posts";       
						$query = 'SELECT posts.id, acc_id, content, postdate, last_edited, fname, username, joindate  
								FROM posts 
								INNER JOIN accounts
								ON posts.acc_id = accounts.id 
								ORDER BY last_edited DESC';
						$records_per_page=10;
						$newquery = $paginate->paging($query,$records_per_page);
						$paginate->dataview($newquery);
						$paginate->paginglink($query,$records_per_page);  
						echo "
						</table>
					</td>
				</tr>
			</table>
			</td>
	    	</table>";
			/*
			if($stmt->rowCount() > 0) {
				echo "<table align='center' width='50%' border='1'>
				<tr>
					<td>
						<table align='center' border='1' width='100%' height='100%' id='data'>";
						$query = "SELECT posts.id, acc_id, content, postdate, last_edited, fname, username, joindate  
								FROM posts 
								INNER JOIN accounts
								ON posts.acc_id = accounts.id 
								ORDER BY last_edited DESC";       
						$records_per_page=10;
						$newquery = $paginate->paging($query,$records_per_page);
						$paginate->dataview($newquery);
						$paginate->paginglink($query,$records_per_page);  
						echo "
						</table>
					</td>
				</tr>
			</table>";
			} else {
				echo "No posts to show. <br>";
			}
			*/
			/*
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
						<td><form class="post-form" action="/deletepost.php" method="POST">
	    				<input type="hidden" name="post_id" value="' . $row['id'] . '"/>
	    				<input type="submit" value="Delete"/>
	    				</form></td>';
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
			*/
		
	?>


	
</body>
</html>
