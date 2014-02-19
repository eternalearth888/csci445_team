<?php

include 'db_connect.php';

$user_id = $_GET["q"];
$user_id = intval($user_id);
$index = intval($_GET["index"]);

$getGoals = $db->prepare("SELECT goal.id, title FROM goal_title
		INNER JOIN goal ON goal.goal_title_id = goal_title.id 
		WHERE goal.user_id = ?");
$getGoals->bind_param('i', $user_id);
$getGoals->execute();
$getGoals->store_result();
$getGoals->bind_result($goal_id, $title);
for ($i=1; $i<=$index; $i++) {
	$getGoals->fetch();
}

$deleteProgress = $db->prepare("DELETE FROM progress WHERE goal_id = ?");
$deleteProgress->bind_param("i", $goal_id);
$deleteProgress->execute();

$deleteComments = $db->prepare("DELETE FROM comments WHERE goal_id = ?");
$deleteComments->bind_param("i", $goal_id);
$deleteComments->execute();

$deleteMentors = $db->prepare("DELETE FROM mentors WHERE goal_id = ?");
$deleteMentors->bind_param("i", $goal_id);
$deleteMentors->execute();

$delete_stmt = $db->prepare("DELETE FROM goal WHERE goal.id = ?");	
$delete_stmt->bind_param("i", $goal_id);
$delete_stmt->execute();

?>
