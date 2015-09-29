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
$logic_array = array("AND", "OR");

//number of parameters
$count = $_POST['parameter-count'];

//array to be binded
$param_array = array();

//container for whole where clause
$details = "WHERE posts.content LIKE ?";

//first question mark
$param_array[] = "%" . trim($_POST['search_box']) . "%";

if($count > 0){
	$added = "";
	//generate additional conditions
	for ($x = 0; $x < $count ; $x++) {
		
		//concat logical operator
		$logic_operator = $_POST['logic' . $x];
		if(in_array($logic_operator, $logic_array))
			$added .= " " . $logic_operator;
		
		//concat condition	
		$condition = getCondition($cond_array,$x);
		$param = trim($_POST[$condition . $x]);
		switch($condition){
			case "Username": 
				$added .= " username = ?"; 
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
				if($start_pos == 0 || $start_pos == strlen($param)-1)//no operator or invalid value
					$cond_operator = "=";
				else
					$cond_operator = substr($param, 0, $start_pos-1);
				
				if(substr($param, $start_pos))
					$param = substr($param, $start_pos);
				else 
					$param = "";
				//$newstr = substr_replace($param, "'", $start_pos, 0);
				//$newstr = substr_replace($newstr, "'", strlen($newstr), 0);
				$added .= " postdate " . $cond_operator . " ?"; 
				break;
		}
		
		//add parameter to bind
		$param_array[] = $param;
		
	}
	$details .= $added;
	
}
//echo $details;
//echo json_encode($param_array);

$_SESSION['search-details'] = $details;
$_SESSION['parameters'] = $param_array;
header("Location: messageboard.php"); /* Redirect browser */
exit();