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
			width: 100%;
		}
		
		.uinfo{
			width: 20%;
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
		var selectValues = ['Username','Date'];
		var logicValues = ['AND', 'OR'];
		var field_count = 0;
		$(".search-form input[name=parameter-count]").attr("value",field_count);
		
	    $("#editpost").click(divClicked); //calls the function on button click
  
	    $(document).on('change','.select_field', function() {
	        var id = $(this).attr("id");
	        var val = $(this).find("option[value=" + $(this).val() + "]").text();
	        $(".search-form input:text[id='" + id + "']").attr("name", val + "" + id);
	       // var input = $(".search-form input#" + id);
	        
			//if(val == "Username")
			//	input.attr("type","text");
	        //else if(val == "Date")
	        //	input.attr("type","date");
	        
	    });

	    $(document).on('change','.logic_field', function() {
	        var id = $(this).attr("id");
	        var val = $(this).find("option[value=" + $(this).val() + "]").text();
	        $(".search-form input#" + id + "[type='hidden']").attr("value", val);
	        
	    });
	    
	    $("#add-field").click(function(){
		    //add logic field
		    $("<input type='hidden' value='' />")
	        .attr("id", "" + field_count)
	        .attr("name", "logic" + field_count)
	        .attr("value", "" + logicValues[0])
	        .insertBefore(".search-form input[type=submit]");
		    
		    //add input field
	    	$("<input type='text' value='' />")
	        .attr("id", "" + field_count)
	        .attr("name", "" + selectValues[0] + field_count)
	        .insertBefore(".search-form input[type=submit]");

			//append detail selector
			var newSelection = $("<select class='select_field' id='" + field_count + "' />");
	    	$.each(selectValues, function(key, value) {   
	    	     newSelection
	    	     	.append($('<option>', { value : key })
	    	        .text(value))  
	    	});
	    	newSelection.insertBefore(".search-form input[type=submit]");

	    	//append detail selector
			var logicSelection = $("<select class='logic_field' id='" + field_count + "' />");
	    	$.each(logicValues, function(key, value) {   
	    		logicSelection
	    	     	.append($('<option>', { value : key })
	    	        .text(value))  
	    	});
	    	logicSelection.insertBefore(".search-form input[type=submit]");
	    	$("<br>").insertBefore(".search-form input[type=submit]");

	   		field_count++;
	    	$(".search-form input[name=parameter-count]").attr("value",field_count);
	   		//newSelection.find('option[value="Date"]').prop('selected', true);
	   		//$('.select_field0 option:eq(1)').prop('selected', true)
		   	});
	    
	    	
	    
	    	
	});
</script>

</head>
<body>

	<?php 
	
	function showInputBox(){
		echo "<td><form method='POST' class='post-form' action='./submitpost.php'>"
				."<textarea class = \"form-control\" name='post_content' rows='10' cols = '50'/></textarea>"
				."<br><input class=\"btn btn-success\" type='submit' name='submit-post' value='Post' />"
						."</form>";
	}
	function showSearchBox(){
		echo  "
    			<br>
    			<form method='POST' class='search-form' action='./searchpost.php'>"
				."<textarea class = \"form-control\" name='search_box' rows='1' cols = '50'/></textarea><br>"
				."<input name='parameter-count' type='hidden' value='0'>"
				."<div>
    			<input class=\"btn btn-success\" type='submit' name='search-post' value='Search' />
    			</div>
    			</form>
				<button class=\"btn btn-primary\" id='add-field'>Add search field</button> 
   			</td>";
	
	}
	
		
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
		
			echo "<table class = \"maint\"> <tr> <td class = \"uinfo\" valign=\"top\" rowspan=\"2\">
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
					.'<br> ';
			
			showInputBox();
			showSearchBox();
			
			if ($_SESSION['accesslvl'] == "admin") {
				//include 'backup.php';
				//$backup = new backup();
				//echo $backup->getLastNo();
				//echo $backup->create();
				/*
				echo '
	    			<button type="button" class="btn btn-success" onclick = "$backup->create()">Backup</button> 
	    			<br> </td>
				';
				*/
				echo '
	    			<button type="button" class="btn btn-success" onclick = "location.href = \'./backup.php\';">Backup</button> 
	    			<br></td>
					<button type="button" class="btn btn-success" onclick = "location.href = \'./backuplist.php\';">Backup List</button>
					<br></td>
				';
			}
			echo " </tr>";
			
			if(!isset($_SESSION['search-details'])){
				$_SESSION['search-details'] = "";
			}
			if(!isset($_SESSION['parameters'])){
				$_SESSION['parameters'] = null;
			}
			echo "<td> <table align='center' width='50%'>
				<tr>
					<td>
						<table align='center' border='1' width='100%' height='100%' id='data'>";
						//$query = "SELECT * FROM posts";       
						$query = 'SELECT posts.id, acc_id, content, postdate, last_edited, fname, username, joindate  
								FROM posts 
								INNER JOIN accounts
								ON posts.acc_id = accounts.id ' . $_SESSION['search-details'] . 
								' ORDER BY last_edited DESC';
						
						$records_per_page=10;
						$newquery = $paginate->paging($query,$records_per_page);
						$paginate->dataview($newquery, $_SESSION['parameters']);
						$paginate->paginglink($query, $_SESSION['parameters'], $records_per_page);  
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
			
		
	?>


	
</body>
</html>
