<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./includes/header.php');

if (Login::isLoggedIn()) {
	echo "loggedin";
	// Echo user id
	echo Login::isLoggedIn();
}else{
	echo "notloggedin";
}
?>