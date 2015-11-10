<?php

include 'session.php';
include 'connect.php';
include_once 'library/HTMLPurifier.auto.php';


if($_SESSION['accesslvl'] == "admin"){
	$result = 'Item added to store.';
	$purifier = new HTMLPurifier();
	
	/*
	$query = "INSERT INTO items (name,price,description,stock) VALUES(
			:name, :price, :description, :stock)";
	*/
	
	$target_dir = "itemimg/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	//$target_file = $_SERVER["DOCUMENT_ROOT"] . $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "File already exists in the server.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 10000000) {
		echo "Please upload an image lower than 10MB file size.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Please only upload JPG, JPEG, PNG & GIF files.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "There was an error with your upload.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
			echo "There was an error with your upload.";
		}
	}
	
	$query = "INSERT INTO items (name,price,description,stock,imgpath) VALUES(?, ?, ?, ?, ?)";
	try{
		if ($uploadOk == 1) {
			$stmt = $db->prepare($query);
		/*
		$stmt->execute(array(':name' => $purifier->purify($_POST['name']),':price' => $purifier->purify($_POST['price']),
				':description' => $purifier->purify($_POST['description']),':stock' => $purifier->purify($_POST['stock']), ':img' => $target_file));
		*/
		//$imgfp = fopen($_FILES['fileToUpload']['tmp_name'], 'rb');
		//$imgtype = pathinfo($_FILES['fileToUpload']['tmp_name'], PATHINFO_EXTENSION);
		$stmt->bindParam(1, $purifier->purify($_POST['name']));
        $stmt->bindParam(2, $purifier->purify($_POST['price']));
        $stmt->bindParam(3, $purifier->purify($_POST['description']));
        $stmt->bindParam(4, $purifier->purify($_POST['stock']));
		$stmt->bindParam(5, $target_file);
        //$stmt->bindParam(5, $imgfp, PDO::PARAM_LOB);
		$stmt->execute();
		}
		
	}
	catch(PDOException $e){
		$result = 'Failed to add item';
	}
}
$_SESSION['addresult'] = $result;
header("Location: ./additem.php"); /* Redirect browser */
exit();


