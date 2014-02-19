<?php

include 'db_connect.php';
session_start();

$goal_id = $_GET["q"];

	$goals = $db->prepare("SELECT id FROM mentors WHERE goal_id = ?");
        $goals->bind_param('i', $goal_id);
        $goals->execute();
        $goals->store_result();
        $num_goals = $goals->num_rows;
        echo $num_goals;
        $goals->close();

header('Location: ./profile.php);
?>
