<?php 
	session_start();
	//session_unset();
	//session_destroy();
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
		// vulnerable?
		$_SESSION["firstname"] = "Gabriel";
		$_SESSION["lastname"] = "del Mundo";
		$_SESSION["gender"] = "Male";
		$_SESSION["salutation"] = "Count";
		$_SESSION["birthdate"] = "March 16 1996";
		$_SESSION["aboutme"] = "Hi\nI'm a noob";
		print_r($_SESSION);

	?>
	
	<form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Firstname: </label>
		<?php echo $_SESSION["firstname"]?>
		<br> <br>
		<label>Surname: </label>
		<?php echo $_SESSION["lastname"]?>
		<br> <br>
		<label>Gender: </label>
		<?php echo $_SESSION["gender"]?>
		<br> <br>
		<label>Salutation:</label>
		<?php echo $_SESSION["salutation"]?>
		<br> <br>
		<label>Birthdate: </label>
		<?php echo $_SESSION["birthdate"]?>
		<br> <br>
		<label>Password: </label>
		<br> <br>
		<label>About Me: </label>
		<?php echo $_SESSION["aboutme"]?>
		<br> <br>
		<input type = "submit" name = "submit" id = "submit" value = "Confirm changes"/>
	</form>
	
	<br><br>
	
	<div id = "forumpost">
	<table border = "1" style = "width:40%">
	<tr>
		<td><button>First Name</button></td>
		<td>Date Posted</td>
		<td><button>Edit</button></td>
		<td><button>Delete</button></td>
	</tr>
	<tr >
		<td><button>Username</button></td>
		<td colspan="3"><textarea name = "textpost" id = "textpost" rows="4" cols="50">POST</textarea></td>
	</tr>
	<tr>
		<td>Date Joined</td>
		<td colspan="3">Last Edited</td>
	</tr>
	</table>
	</div>
	
</body>
</html>
