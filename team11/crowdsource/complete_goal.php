<?php

include 'db_connect.php';
session_start();

$goal_id = $_GET["q"];

$finishGoal = $db->prepare("UPDATE goal SET status = 1 WHERE goal.id = ?");
$finishGoal->bind_param('i', $goal_id);
$finishGoal->execute();
$finishGoal->close();
header('Location: ./goal.php?q='.$goal_id);
?>
