<?php
	session_start();
	if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
	{
		echo 'You are logged in with a different account. Go back to <a href="/messageboard.php">message board</a>.';
	}
	else{
		echo 'Your session has expired. Go back to <a href="/main.php">main page</a>.';
	}