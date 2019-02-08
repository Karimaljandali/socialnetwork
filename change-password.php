<?php 
include('./classes/DB.php');
include('./classes/Login.php');
include('./includes/header.php');

if (Login::isLoggedIn()) {
	echo "loggedin";
	// Echo user id
	echo Login::isLoggedIn();
}else{
	die("notloggedin"); 
}
?>
<h1>Change your Password</h1>
<form action="change-password.php" method="post">
	<input type="password" name="oldpassword" value="" placeholder="Current Password">
	<input type="password" name="newpassword" value="" placeholder="New Password">
	<input type="password" name="newpasswordrepeat" value="" placeholder="Repeat Password">
	<input type="submit" name="changepassword" value="Change Password"> 
</form>