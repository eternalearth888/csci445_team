<?php

//Source: http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL
// This is a very useful wiki page that provided these functions for login functionality

//this generates new session id everytime, so doesn't store session variables. not using this functionf or the time being since we can't get it to work
//however, it adds lots of security - hackers cannot access session id cookie through javascript
function secure_session_start() {
	$session_name = 'secure_session_id'; // set custom session name
	$secure = false;  // set to true if using https
	$httponly = true; //stops javascript being able to access the session id

	ini_set('session.use_only_cookies', 1); // forces session to only use cookies
	$cookieParams = session_get_cookie_params(); // gets current cookies params
	session_set_cookie_params($cookieParams["lifetime"], $cookieParams["domain"], $secure, $httponly);
	session_name($session_name); // Sets the session name to the one set above.
	session_start(); // Start the php session

	//  session_regenerate_id(); //regenerated the session, delete the old one
}

//checkes username & password against database and returns true if a match is found
function login($username, $password, $db) {
	if ($stmt = $db->prepare("SELECT id, username, password, salt FROM client WHERE username = ? LIMIT 1")) { 
		$stmt->bind_param('s', $username); // Bind "$username" to parameter.
		$stmt->execute(); // Execute the prepared query.
		$stmt->store_result();
		$stmt->bind_result($user_id, $username, $db_password, $salt); // get variables from result.
		$stmt->fetch();

		$password = hash('sha512', $password.$salt); // hash the password with the unique salt.

		echo "Password: ".$password."<br>";
		echo "username: ".$username."<br>";
		if($stmt->num_rows == 1) { // If the user exists
			// We check if the account is locked from too many login attempts
			if(checkbrute($user_id, $db) == true) { 
				// Account is locked
				echo "ACCOUNT LOCKED";
				return false;
			} else {
				if($db_password == substr($password, 0, 20)) { // Check if the password in the database matches the password the user submitted. 
					// Password is correct!
					$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
					$user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
					$_SESSION['user_id'] = $user_id; 
					$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
					$_SESSION['username'] = $username;
					$_SESSION['login_string'] = hash('sha512', substr($password,0,20).$user_browser);
					// Login successful.
					return true;    
				} else {
					// Password is not correct
					// We record this attempt in the database
					$now = time();
					$db->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
					return false;
				}
			}
		} else {
			echo "Error: This user doesn't exist";
			// No user exists. 
			return false;
		}
	}
}


//account becomes blocked if user fails to login more than 50 times (for now)
function checkbrute($user_id, $db) {
	// Get timestamp of current time
	$now = time();
	// All login attempts are counted from the past 2 hours. 
	$valid_attempts = $now - (2 * 60 * 60); 

	if ($stmt = $db->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) { 
		$stmt->bind_param('i', $user_id); 
		// Execute the prepared query.
		$stmt->execute();
		$stmt->store_result();
		// If there has been more than 50 failed logins
		if($stmt->num_rows > 50) {
			return true;
		} else {
			return false;
		}
	}
}

//checks if user is logged in
function login_check($db) {
	// Check if all session variables are set
	if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
		$user_id = $_SESSION['user_id'];
		$login_string = $_SESSION['login_string'];
		$username = $_SESSION['username'];

		$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

		if ($stmt = $db->prepare("SELECT password FROM client WHERE id = ? LIMIT 1")) { 
			$stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
			$stmt->execute(); // Execute the prepared query.
			$stmt->store_result();

			if($stmt->num_rows == 1) { // If the user exists
				$stmt->bind_result($password); // get variables from result.
				$stmt->fetch();
				$login_check = hash('sha512', $password.$user_browser);
				if($login_check == $login_string) {
					// Logged In!!!!
					return true;
				} else {
					// Not logged in
					return false;
				}
			} else {
				// Not logged in
				return false;
			}
		} else {
			// Not logged in
			return false;
		}
	} else {
		// Not logged in
		return false;
	}
}


?>
