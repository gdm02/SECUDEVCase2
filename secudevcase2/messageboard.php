<?php 
	session_start();
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

#noborder {
	border: 0;
}
</style>
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
		
		print_r($_SESSION);

	?>
	
	<a href ="editprofile">Edit your profile</a>
	
	<br><br>
	
	<div id = "forumpost">
	<table border = "1" style = "width:40%">
	<tr>
		<td><button>First Name</button></td>
		<td>Date Posted: </td>
		<td><button>Edit</button></td>
		<td><button>Delete</button></td>
	</tr>
	<tr>
		<td><button>Username</button></td>
		<td colspan="3"> 
		 Color: 
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
		 Font Size: <input id = "postfontsize" type = "number" min = "12" max = "14" value = "12">
		 <br><br> 
		 <textarea name = "textpost" id = "textpost" rows="4" cols="50">POST</textarea>
		 </td>
	</tr>
	<tr>
		<td>Date Joined: </td>
		<td colspan="3">Last Edited</td>
	</tr>
	</table>
	</div>
	
</body>
</html>
