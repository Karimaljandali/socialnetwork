<?php 
include('classes/DB.php');

if (isset($_POST['login'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	// Check if username exists in DB
	if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {
		
		// Check if password is correct
		if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array('username'=>$username))[0]['password'])){
			echo "Logged in";
		} else{
			echo "Incorrect password";
		}

	} else {
		echo "user not registered";
	}
}
?>

<h1>Login to your account</h1>
<form action="login.php" method="post">
	<input type="text" name="username" value=""	placeholder="Username">
	<input type="password" name="password" value=""	placeholder="Password">
	<input type="submit" name="login" value="login">
</form>