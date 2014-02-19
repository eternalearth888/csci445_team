<?php

include 'db_connect.php';
include 'functions.php';

session_start();

if(login_check($db) == true) {

	$user_id = intval($_GET["q"]);
	$index = intval($_GET["index"]);

	$getGoals = $db->prepare("SELECT id FROM goal WHERE goal.user_id = ? AND status = 0");
	$getGoals->bind_param('i', $user_id);
	$getGoals->execute();
	$getGoals->store_result();
	$getGoals->bind_result($goal_id);
	for ($i=1; $i<=$index; $i++) {
		$getGoals->fetch();
	}

	//$_SESSION['goal'] = $goal_id;
	header('Location: ./goal.php?q='.$goal_id);

} else {

	echo "You are not authorized to view this page";

}
?>
