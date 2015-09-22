<!DOCTYPE html>
<html lang = "en">
<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">

<style>
	
	/* body {
		background-color: lavender;
	}
	
	#header {
		font-family: "Comic Sans MS", cursive, sans-serif;
		font-size: 30px;
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
	} */

	#header {
		font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
		font-size: 40px;
	}

	body {
		background-color: lavender;
	}
	
	form {
		display: inline-block;
		padding: 75px;
	}

</style>

<title>Main Page</title>

</head>
<body>
<div align = "center">
	<div>
		<h2 id = "header"> Welcome to Main Page! </h2>
	</div>
	<div>
		<form action="/register.php" method="get">
		    <input class="btn btn-primary" id = "submit" type="submit" value="Register"/>
		</form>
		<form action="/login.php" method="get">
		    <input class="btn btn-primary" id = "submit" type="submit" value="Login"  />
		</form>
	</div>
</div>
</body>
</html>