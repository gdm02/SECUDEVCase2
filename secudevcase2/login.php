<!DOCTYPE HTML>
<html>
<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	<style>
	
		/* body{
			background-color: #ADD6FF;
		}
		
		#header{
			font-family: "Comic Sans MS", cursive, sans-serif;
			font-size: 30px;
		}
		
		div{
			display: block;
			text-align: center;
		}
		
		form{
			background-color: #94FF94;
			margin: auto;
			position: relative;
			width: 300px;
			height: 150px;
			font-family: "Comic Sans MS", cursive, sans-serif;
			font-size: 17px;
			font-style: italic;
			line-height: 23px;
			font-weight: bold;
			color: #1975FF;
			border-radius: 5px;
			padding: 10px;
			border: 1px solid black;
			box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
		}
		
		input{
			width: 290px;
		}
		
		#submit{
			background-color: #1975FF;
    		border-radius: 5px;
    		color: white;
    		font-family: "Comic Sans MS", cursive, sans-serif;
    		font-size: 15px;
    		border: 1px solid black;
    		width: 150px;
		}
		
		.buttonholder{
			text-align: center;
		}
		
		
		
		 */	
		
		body {
			background-color: lavender;
		}
		
		#header {
			font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
			font-size: 40px;
		}
		
		#success{
			text-align: center;
			color: #33CC33;
			font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
			font-size: 25px;
		}
		
		#fail{
			text-align: center;
			color: red;
			font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
			font-size: 25px;
		}
		
	</style>
	
</head>


<body>
<?php

session_start();

include 'connect.php';
 
echo "<div id = \"header\" align = \"center\" > <h2>Sign in</h2> </div>";
 
//first, check if the user is already signed in. If that is the case, there is no need to display this page
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo '<div id = "success">You are already signed in, you can <a href="./signout.php">sign out</a> if you want.</div>';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        echo '<form class="form-horizontal" role="form" method="post" action="">
		<div class = "form-group">				
            <label class="control-label col-sm-5">Username: </label>
			<div class = "col-sm-2">		
			<input class = "form-control" type="text" name="user_name" />
			</div>
		</div>
		<div class = "form-group">			
            <label class="control-label col-sm-5">Password: </label>
			<div class = "col-sm-2">
			<input class = "form-control" type="password" name="user_pass">
			</div>
		</div>			
            <div align = "center"> <input class="btn btn-success" id = "submit" type="submit" value="Sign in" /> </div>
         </form>';
    }
    else
    {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Varify if the data is correct and return the correct response
        */
        $errors = array(); /* declare the array for later use */
         
        if(!isset($_POST['user_name']))
        {
            $errors[] = 'The username field must not be empty.';
        }
         
        if(!isset($_POST['user_pass']))
        {
            $errors[] = 'The password field must not be empty.';
        }
         
        if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
        {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
            {
                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
            }
            echo '</ul>';
        }
        else
        {
                        
            $username = $_POST['user_name'];
            //$password = sha1($_POST['user_pass']); encrypted password
            $password = $_POST['user_pass'];
            
            try{
	            $stmt = $db->prepare("SELECT * FROM accounts WHERE username=:username AND password=:password");
	            $stmt->execute(array(':username' => $username, ':password' => $password));
				//handle try catch later
	          
	            
	           
	            if($stmt -> rowCount() == 0)
	                {
	                    echo '<div id = "fail">You have supplied a wrong user/password combination. <a href="login.php"> Please try again. </a> </div>';
	                }
	                else
	                {
	                    //set the $_SESSION['signed_in'] variable to TRUE
	                    $_SESSION['signed_in'] = true;
	                     
	                    //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
	                    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	                    {
	                        $_SESSION['id']    = $row['id'];
	                        $_SESSION['firstname']  = $row['fname'];
	                        $_SESSION['lastname'] = $row['lname'];
	                        $_SESSION['gender'] = $row['gender'];
	                        $_SESSION['birthdate'] = $row['birthdate'];
	                        $_SESSION['salutation'] = $row['salutation'];
	                        $_SESSION['username'] = $row['username'];
	                        $_SESSION['password'] = $row['password'];
	                        $_SESSION['aboutme'] = $row['about'];
	                        $_SESSION['accesslvl'] = $row['level'];
	                        $_SESSION['joindate'] = $row['joindate'];
	                        
	                        //no search details by default
	                        $_SESSION['search-details'] = "";
	                    }
	                    
	                    echo '<div id = "success">Welcome, ' . $_SESSION['firstname'] . '. <a href="messageboard.php">Proceed to the forum overview</a>.</div>';
	                }
            }
            catch(PDOException $e){
            	echo '<div id = "fail"> An error occured. <a href="login.php"> Please try again. </a> </div>';
            }
            
        }
    }
}
?>
</body>
</html>
