<?php

include 'db_connect.php';
include 'functions.php';

session_start();

if(login_check($db) == true) {

	if(isset($_POST['title'], $_POST['tag'], $_POST['why'], $_POST['how'], $_POST['start_date'], $_POST['intended_end_date'], $_POST['frequency'])) { 

		$title = $_POST['title'];
		$tag = $_POST['tag'];
		$how = $_POST['how'];
		$why = $_POST['why'];
		$start_date = date_format(date_create($_POST['start_date']), 'Y-m-d H:i:s');
		$intended_end_date = date_format(date_create($_POST['intended_end_date']), 'Y-m-d H:i:s');
		$frequency = $_POST['frequency'];

		//Get int from frequency
		if ($frequency == "daily") {
			$freq = 1;
		} else if ($frequency == "weekly") {
			$freq = 7;
		} else if ($frequency == "monthly") {
			$freq = 30;
		} else if ($frequency == "yearly") {
			$freq = 365;
		} else {	
			$freq = 1;
		}

		//Get the user id & check if goal title exists
		$grab_user_id = $db->prepare("SELECT id, (SELECT COUNT(id) FROM goal_title WHERE title = ?) AS count FROM client WHERE username = ?");
		$grab_user_id->bind_param('ss', $title, $_SESSION['username']);
		$grab_user_id->execute();
		$grab_user_id->store_result();
		$grab_user_id->bind_result($user_id, $goalTitleCount);
		$grab_user_id->fetch();
		$grab_user_id->close();

		//Insert Goal title if it doesn't exist
		if ($goalTitleCount == 0) {
			$goalTitle = $db->prepare("INSERT INTO goal_title (tag, title) VALUES (?, ?)");
			$goalTitle->bind_param('ss', $tag, ucfirst($title));
			$goalTitle->execute();
			$insertSuccessTitle = $goalTitle->affected_rows;
			$goalTitle->close();
		} else {	
			$insertSuccessTitle = 1;
		}  

		//get the goal title id & goal id
		$grab_goal_title = $db->prepare("SELECT id FROM goal_title WHERE title = ?");
		$grab_goal_title->bind_param('s', ucfirst($title));    
		$grab_goal_title->execute();
		$grab_goal_title->store_result();
		$grab_goal_title->bind_result($goalId);
		$grab_goal_title->fetch();
		$grab_goal_title->close();

		//Insert goal information into the database
		$goal_stmt = $db->prepare("INSERT INTO goal (why, how, frequency, start_date, status, intended_end_date, user_id, goal_title_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$goal_stmt->bind_param('ssisisii', $why, $how, $freq, $start_date, $status = 0, $intended_end_date, $user_id, $goalId);
		$goal_stmt->execute();
		$insertSuccessGoal = $goal_stmt->affected_rows;
		$goal_stmt->close();

		//Redirect if success
		if($insertSuccessTitle == 1 && $insertSuccessGoal == 1) {

			$get_goal_id = $db->prepare("SELECT id FROM goal WHERE last_update = (SELECT max(last_update) FROM goal WHERE user_id = ?)");
			$get_goal_id->bind_param('i', $user_id);    
			$get_goal_id->execute();
			$get_goal_id->store_result();
			$get_goal_id->bind_result($goal);
			$get_goal_id->fetch();
			$get_goal_id->close();

			//      $_SESSION['goal'] = $goal;
			header('Location: ./goal.php?q='.$goal);
		} else {
			//Error occurred submitting information to database
			header('Location: ./goal_form.php?error=1');
		}

	} else {
		echo 'Invalid request';
	}

} else {
	echo "You are not authorized to view this page!";
}

?>
