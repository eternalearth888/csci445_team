<?php

include 'db_connect.php';
include 'functions.php';

session_start(); // Our custom secure way of starting a php session. 

if(isset($_POST['username'], $_POST['p'])) { 
	$username = $_POST['username'];
	$password = $_POST['p']; // The hashed password.

	if(login($username, $password, $db) == true) {
		// Login success
		session_write_close();
		header('Location: ./personal.php');
	} else {
		// Login failed
		header('Location: ./login.php?error=1');
	}
} else { 
	// The correct POST variables were not sent to this page.
	echo 'Invalid Request';
}

?>
