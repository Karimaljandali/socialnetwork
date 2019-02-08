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
			// variable is set because second param must be variable.
			$cstrong = True;
			// Token is generated with oppenssl_random_pseudo_bytes and then converted from binary to hex
			$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
			// Get user id from table for later reference
			$user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
			// Add token to token table. Encrypt token with sha1 for security
			DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));

			// Set cookie in browser
			// @param 1: Cookie name
			// @param 2: token id
			// @param 3: cookie duration (1 week)
			// @param 4: where is cookie valid (all)
			// @param 5: domain cookie is valid on
			// @param 6: domain not valid on SSL
			// @param 7: http only, javascript cant access cookie
			setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
			setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
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