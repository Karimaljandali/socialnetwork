<?php 
include('./classes/DB.php');
include('./classes/Login.php');

if (Login::isLoggedIn()) {
	echo "loggedin";
	// Echo user id
	echo Login::isLoggedIn();
}else{
	echo "notloggedin";
}
?>