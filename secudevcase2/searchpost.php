<?php
include 'session.php';

function getCondition($cond_array,$index){
	foreach($cond_array as $cond){
		if(isset($_POST[$cond . $index]))
			return $cond;
	}
}

//array of possible conditions
$cond_array = array("Username", "Date");

$count = $_POST['parameter-count'];

$details = "WHERE posts.content LIKE '%". trim($_POST['search_box']). "%'";


if($count > 0){
	$added = "";
	//generate additional conditions
	for ($x = 0; $x < $count ; $x++) {
		
		//concat logical operator
		$name = 
		$added .= " " . $_POST['logic' . $x];
		
		//concat condition	
		$condition = getCondition($cond_array,$x);
		$param = trim($_POST[$condition . $x]);
		switch($condition){
			case "Username": 
				$added .= " username LIKE '%". $param . "%'"; 
				break;
			case "Date": 
				$param = str_replace('"', "", $param);
				$param = str_replace("'", "", $param);
				
				$start_pos  = 0;
				for($i = 0; $i < strlen($param); $i++){
					if(ctype_digit($param[$i])){
						$start_pos = $i;
						break;
					}
				}
				//echo $start_pos;
				$newstr = substr_replace($param, "'", $start_pos, 0);
				$newstr = substr_replace($newstr, "'", strlen($newstr), 0);
				$added .= " postdate " . $newstr; 
				break;
		}
		
	}
	$details .= $added;
	echo $details;
}
 
$_SESSION['search-details'] = $details;
header("Location: messageboard.php"); /* Redirect browser */
exit();