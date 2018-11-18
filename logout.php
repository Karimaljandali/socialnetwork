<?php 
include('./classes/DB.php');
include('./classes/Login.php');

if (!Login::isLoggedIn()) {
	die('Not logged in.');
}

// Check if form was sent
if (isset($_POST['confirm'])) {

	// Check if checkbox to delete all cookies was checked
	if (isset($_POST['alldevices'])) {
		// Delete all cookies for user
        DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid'=>Login::isLoggedIn()));
	} else {
		if (isset($_COOKIE['SNID'])) {
			// Delete cookie from current device
			DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));
		}
		// Expire cookies by setting time to negative number
        setcookie('SNID', '1', time()-3600);
        setcookie('SNID_', '1', time()-3600);
	}
}
?>

<h1>Logout of your Account?</h1>
<p>Are you sure you'd like to logout?</p>
<form action="logout.php" method="post">
        <input type="checkbox" name="alldevices" value="alldevices"> Logout of all devices?<br />
        <input type="submit" name="confirm" value="Confirm">
</form>