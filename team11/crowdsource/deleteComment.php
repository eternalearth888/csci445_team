<?php

include 'db_connect.php';

$goal_id = $_GET["q"];
$goal_id = intval($goal_id);
$index = intval($_GET["index"]);

$getGoals = $db->prepare("SELECT id FROM comments
		WHERE goal_id = ?");
$getGoals->bind_param('i', $goal_id);
$getGoals->execute();
$getGoals->store_result();
$getGoals->bind_result($id);
for ($i=1; $i<=$index; $i++) {
	$getGoals->fetch();
}

$delete_stmt = $db->prepare("DELETE FROM comments WHERE id = ?");	
$delete_stmt->bind_param("i", $id);
$delete_stmt->execute();

header('Location: ./goal.php?q='.$goal_id);
?>
