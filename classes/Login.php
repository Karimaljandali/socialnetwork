<?php 

class Login{
	public static function isLoggedIn(){
		if (isset($_COOKIE['SNID'])) {
			// Check if existing cookie matches user cookie in DB.
			if (DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token' => sha1($_COOKIE['SNID'])))) {
				$userid = DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token' => sha1($_COOKIE['SNID'])))['0']['user_id'];

				// 2nd cookie "refreshes" main login cookie.  If user has signed in within 3 days of 2nd cookie do nothing
	            if (isset($_COOKIE['SNID_'])) {
	        		return $userid;
	        	// if 2nd cookie is not set delete main cookie and reset both cookies.
	        	// this prevents user from having to sign in every week.
				} else {

					$cstrong = True;
	                $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
	                DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$userid));
	                DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));
	                setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
	                setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
	                return $userid;
				}
			}

			return false;
		}
	}
}

?>