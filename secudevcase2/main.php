<!DOCTYPE html>
<html>
<head>
<style>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	body {
		background-color:lavander;
	}
	
	#header {
		font-family: "Comic Sans MS", cursive, sans-serif;
		font-size: 30px;
	}
	
	form {
		display: inline-block;
		width: 100px;
		padding: 75px;
	}
	
	#submit {
		background-color: #1975FF;
    	border-radius: 5px;
    	color: white;
    	font-family: "Comic Sans MS", cursive, sans-serif;
    	font-size: 15px;
    	border: 2px solid black;
    	width: 150px;
	}
	
	#submit:hover {
    	border: 2px solid white;
    	background: red;
    	box-shadow: 2px 2px 10px #777;
	}
	
</style>
<meta charset="ISO-8859-1">
<title>Main Page</title>
</head>
<body>
	<div align = "center" id = "header">
		<h2> Welcome to Main Page! </h2>
	</div>
	<div align = "center">
		<form action="/register.php" method="get">
		    <input id = "submit" type="submit" value="Register"/>
		</form>
		<form action="/login.php" method="get">
		    <input id = "submit" type="submit" value="Login"  />
		</form>
	</div>
</body>
</html>