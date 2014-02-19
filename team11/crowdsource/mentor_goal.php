<?php

include 'db_connect.php';
include 'functions.php';

session_start();

if(login_check($db) == true) {

	$user_id = $_SESSION['user_id'];
	$goal_id = $_GET["q"];

	$addMentor = $db->prepare("INSERT INTO mentors (mentor, goal_id) VALUES (?, ?)");
	$addMentor->bind_param('ii', $user_id, $goal_id);
	$addMentor->execute();
	$addMentor->close();

	header('Location: ./goal.php?q='.$goal_id);

} else {
	echo "You must be logged in to mentor goals";
}
?>
