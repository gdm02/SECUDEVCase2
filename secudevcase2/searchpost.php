<?php
include 'session.php';

$_SESSION['search-details'] = "WHERE posts.content LIKE '%". trim($_POST['search_box']). "%'";
header("Location: messageboard.php"); /* Redirect browser */
exit();