<?php

include 'db_connect.php';
include 'functions.php';

// The hashed password from the form
$password = $_POST['p']; 
$lastname = $_POST['lname'];
$firstname = $_POST['fname'];
$username = $_POST['username']; 

// Create a random salt
$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
// Create salted password (Careful not to over season)
$password = hash('sha512', $password.$random_salt);

// Insert client information into the database
$insert_stmt = $db->prepare("INSERT INTO client (username, password, salt) VALUES (?, ?, ?)");   
$insert_stmt->bind_param('sss', $username, $password, $random_salt); 
$insert_stmt->execute();

//get the user id
$grab_user_id = $db->prepare("SELECT id FROM client WHERE username = ?");
$grab_user_id->bind_param('s', $username);
$grab_user_id->execute();
$grab_user_id->store_result();
$grab_user_id->bind_result($user_id);
$grab_user_id->fetch();

// Insert profile information into the database
$profile_stmt = $db->prepare("INSERT INTO profile (last_name, first_name, user_id, image_id) VALUES (?, ?, ?, ?)");
$profile_stmt->bind_param('ssii', $lastname, $firstname, $user_id, $loc = 1);
$profile_stmt->execute();

//Go ahead and login after creating the account
session_start();

if(login($username, $_POST['p'], $db) == true) {
	session_write_close();
	header('Location: ./personal.php');
} else {
	//Login failure
	header('Location: ./login.php?error=1');
}

?>
