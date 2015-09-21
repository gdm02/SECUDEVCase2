<?php
include 'session.php';

if($_POST['cur_id'] == $_SESSION['id'])
	echo true;
else{
	echo false;
}