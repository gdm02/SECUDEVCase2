<?php
ini_set('display_errors', 1); // change to 0 for production version
error_reporting(E_ALL);

session_start();

include 'connect.php';
 
echo '<h3>Sign in</h3>';
 
//first, check if the user is already signed in. If that is the case, there is no need to display this page
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        echo '<form method="post" action="">
            Username: <input type="text" name="user_name" />
            Password: <input type="password" name="user_pass">
            <input type="submit" value="Sign in" />
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
            
            $stmt = $db->prepare("SELECT * FROM accounts WHERE username=:username AND password=:password");
            $stmt->execute(array(':username' => $username, ':password' => $password));
			//handle try catch later
          
            
           
            if($stmt -> rowCount() == 0)
                {
                    echo 'You have supplied a wrong user/password combination. <a href="login.php"> Please try again. </a>';
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
                        $_SESSION['salutation'] = $row['salutation'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['password'] = $row['password'];
                        $_SESSION['aboutme'] = $row['about'];
                        $_SESSION['accesslvl'] = $row['level'];
                        $_SESSION['joindate'] = $row['joindate'];
                    }
                    
                    echo 'Welcome, ' . $_SESSION['firstname'] . '. <a href="messageboard.php">Proceed to the forum overview</a>.';
                }
            
        }
    }
}
 


