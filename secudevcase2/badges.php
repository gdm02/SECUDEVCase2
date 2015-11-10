<?php

$postlevel = 0;
$donationlevel = 0;
$purchaselevel = 0;

$postbadge = "";
$donationbadge = "";
$purchasebadge = "";
$collectionbadge= "";
	
//posts
$value = $row['num_posts'];
if($value >= 3){
	$postbadge .= 'Participant ';
	$postlevel++;
}
if ($value >= 5){
	$postbadge .= 'Chatter ';
	$postlevel++;
}
if ($value >= 10){
	$postbadge .= 'Socialite ';
	$postlevel++;
}
	
//donations
$value = $row['amount_donated'];
if($value >= 5){
	$donationbadge .= 'Supporter ';
	$donationlevel++;
}
if ($value >= 20){
	$donationbadge .= 'Contributor ';
	$donationlevel++;
}
if ($value >= 100){
	$donationbadge .= 'Pillar ';
	$donationlevel++;
}
	
//purchase
$value = $row['amount_purchased'];
if($value >= 5){
	$purchasebadge .= 'Shopper ';
	$purchaselevel++;
}
if ($value >= 20){
	$purchasebadge .= 'Promoter ';
	$purchaselevel++;
}
if ($value >= 100){
	$purchasebadge .= 'Elite ';
	$purchaselevel++;
}
	
if($postlevel>=1 && $donationlevel>=1 && $purchaselevel>=1)
	$collectionbadge .= "Explorer ";
if($donationlevel>=2 && $purchaselevel>=2)
	$collectionbadge .= "Backer ";
if($postlevel>2 && $donationlevel>2 && $purchaselevel>2)
	$collectionbadge .= "Evangelist ";


if($postbadge != " ")
	echo $postbadge . ' ';
if($donationbadge != " ")
	echo $donationbadge . ' ';
if($purchasebadge != " ")
	echo $purchasebadge . ' ';
if($collectionbadge != " ")
	echo $collectionbadge . ' ';
