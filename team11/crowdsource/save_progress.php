<?php
include 'db_connect.php';
session_start();

$progText = $_POST["progress"];

//Insert goal information into the database
$goal_id = $_POST["goal_id"];

$progress = $db->prepare("INSERT INTO progress (status_text, goal_id) VALUES (?, ?)");
$progress->bind_param('si', addslashes($progText), $goal_id);
$progress->execute();
$insertSuccessProgress = $progress->affected_rows;
//$progress->close();

$goalUpdate = $db->prepare("UPDATE goal SET last_update = NOW() WHERE goal.id = ?");
$goalUpdate->bind_param('i', $goal_id);
$goalUpdate->execute();
//$goal->close();

header('Location: ./goal.php?q='.$goal_id);
?>
