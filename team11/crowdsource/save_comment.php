<?php
include 'db_connect.php';
session_start();

// NEED TO FIX THIS!!!!!! GOAL_ID IS NULL
$comText = $_POST["comment"];
$goal_id = $_POST["goal_id"];	

//Insert goal information into the database
$comment = $db->prepare("INSERT INTO comments (note, buddy, goal_id) VALUES (?, ?, ?)");
$comment->bind_param('ssi', addslashes($comText), $_SESSION['username'], $goal_id);
$comment->execute();
$insertSuccessComment = $comment->affected_rows;
$comment->close();

header('Location: ./goal.php?q='.$goal_id);
?>
