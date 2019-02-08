<?php 
include('classes/DB.php');
include('./includes/header.php');


if (isset($_POST['createaccount'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	// Check if username exists in database
	if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

		// Check if username input is between 3 and 32
		if (strlen($username) >= 3 && strlen($username) <= 32) {
			
			// Check if username uses correct characters
			if (preg_match('/[a-zA-Z0-9_]+/', $username)) {

				// Check if password is between 6 and 60
				if(strlen($password) >= 6 && strlen($password) <= 60){

					// Check if email is valid format
					if (filter_var($email, FILTER_VALIDATE_EMAIL)){

						// Check if email is in use
						if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {

							// Create user
							DB::query('INSERT INTO users VALUES (null, :username, :password, :email)', array(':username'=>$username, ':password' => password_hash($password, PASSWORD_BCRYPT), ':email'=> $email));
							echo 'success';
						}else{
							echo "Email in use!";
						}
					}else{
						echo "Email invalid";
					}
				}else{
					echo "Password invalid";
				}
			} else{
				echo 'Username invalid';
			}
		}else {
			echo "Username invalid";
		}

	} else {
		echo "user exists";
	}
}


?>
<body>
	<div class="container">
		<div class="form-container">
			<div class="left-side">
				<h1>Register</h1>
				<form action="create-account.php" method="post">
					<input type="text" name="username" value="" placeholder="Username">
					<input type="password" name="password" value="" placeholder="Password">
					<input type="email" name="email" value="" placeholder="email">
					<input type="submit" name="createaccount" value="Create Account">
				</form>
			</div>
			<div>
				<img class="right-side" src="./imgs/register-img.jpg" alt="Register Account Img">
			</div>
		</div>

	</div>
</body>
