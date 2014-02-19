<!DOCTYPE html>
<meta charset="utf-8">
<?php

include 'db_connect.php';
include 'functions.php';

session_start();

if(isset($_Get['error'])) {
	echo 'Error: Cannot log in at this time';
} else {

	if (login_check($db) == true) {
		//protected page content

		$current_goals = $db->prepare("SELECT title, goal.id AS goal_id, status FROM goal_title INNER JOIN goal ON goal.goal_title_id = goal_title.id WHERE goal.user_id = ?");
		$current_goals->bind_param('i', $_SESSION['user_id']);
		$current_goals->execute();
		$current_goals->store_result();
		$current_goals->bind_result($title, $goal_id, $status);

		$countCurrent = 0;
		$countOld = 0;
		while($current_goals->fetch()) {
			if ($status == 0) {
				$countCurrent=$countCurrent+1;
			} else {
				$countOld=$countOld+1;
			}
		}

		$buddy_goals = $db->prepare("SELECT title, goal_id FROM mentors INNER JOIN goal ON mentors.goal_id = goal.id INNER JOIN goal_title ON goal_title.id = goal_title_id WHERE mentor = ? AND status = ?");
		$buddy_goals->bind_param('ii', $_SESSION['user_id'], $status = 0);
		$buddy_goals->execute();
		$buddy_goals->store_result();
		$buddy_goals->bind_result($buddyTitle, $buddyGoalId);

		$countBuddy = 0;
		while($buddy_goals->fetch()) {
			$countBuddy=$countBuddy+1;
		}

		?>
			<html>
			<head>
			<?php include('includes/head.php'); ?>
			<!-- jQuery library (served from Google) -->
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
			<!-- bxSlider Javascript file -->
			<script src="bxslider_plugin/jquery.bxslider.min.js"></script>
			<!-- bxSlider CSS file -->
			<link href="bxslider_plugin/jquery.bxslider.css" rel="stylesheet" />
			<script>
			$(document).ready(function(){
					$('.bxslider').bxSlider({
slideWidth: 250,
minSlides: 2,
maxSlides: 4,
slideMargin: 10
});
					});


function addCurrentGoals(id, title, start_date, num_mentors, goal_id, notify) {
	var element = document.createElement('div');
	element.setAttribute('id', 'index_goalCells');

	var link = document.createElement('a');
	var linkText = document.createTextNode(title);
	link.appendChild(linkText);
	link.title = title;
	link.href = "goal.php?q="+goal_id;
	element.appendChild(link);
	var start = document.createElement('p');
	start.id = "index_sliderGoal";
	start.innerHTML = "Start Date: " + start_date + "<br>Buddies: " + num_mentors;
        element.appendChild(start);
	if (notify == 1) {
		var notification = document.createElement('p');
		notification.id = "index_sliderGoal";
		notification.style.color="red";
		notification.innerHTML = "PROGRESS OVERDUE";
		element.appendChild(notification);
	}
	var div = document.getElementsByClassName(id)[0];
	div.appendChild(element);
	//div.innerHTML = div.innerHTML + title;
}

function addOldGoals(id, title, start_date, num_mentors, goal_id) {
	var element = document.createElement('div');
	element.setAttribute('id', 'index_goalCells');

	var link = document.createElement('a');
	var linkText = document.createTextNode(title);
	link.appendChild(linkText);
	link.title = title;
	link.href = "goal.php?q="+goal_id;
	//link.setAttribute('onclick', 'viewGoal(\''+goal_id+'\');');
	element.appendChild(link);
	var start = document.createElement('p');
	start.id = "index_sliderGoal";
        start.innerHTML = "Start Date: " + start_date;
        element.appendChild(start);
        var mentors = document.createElement('p');
	mentors.id = "index_sliderGoal";
        mentors.innerHTML = "Buddies: " + num_mentors;
        element.appendChild(mentors);
	var div = document.getElementsByClassName(id)[1];
	div.appendChild(element);

}

function addBuddyGoals(id, title, start_date, goal_id, help) {
	var element = document.createElement('div');
	element.setAttribute('id', 'index_goalCells');

	var link = document.createElement('a');
	var linkText = document.createTextNode(title);
	link.appendChild(linkText);
	link.title = title;
	link.href = "goal.php?q="+goal_id;
	//link.setAttribute('onclick', 'viewGoal(\''+goal_id+'\');');
	element.appendChild(link);
	var start = document.createElement('p');
	start.id = "index_sliderGoal";
        start.innerHTML = "Start Date: " + start_date;
	element.appendChild(start);
	if (help == 1) {
		var notification = document.createElement('p');
		notification.id = "index_sliderGoal";
		notification.style.color="red";
		notification.innerHTML = "SUPPORT YOUR BUDDY!";
		element.appendChild(notification);
	}
	var div = document.getElementsByClassName(id)[2];
	div.appendChild(element);

	//div.innerHTML = 'onclick = "Javascript:viewGoal(this, \''+goal_id+'\') "';
	//div.innerHTML = div.innerHTML + title;
}
</script>


</head>
<body>
<?php include('includes/header.php'); ?>
<section>
<div id="content">
<div id="personal_goalHeader">Current Goals</div>

<div class="bxslider">
<?php if ($countCurrent == 0) { ?>
	<div id="index_goalCells">You don't have any goals yet!</div>
		<?php } ?>
		</div>

		<!-- <table id="personal_goalTable">
		<tr>
		<td id="personal_goalCells"><a href="goal.php">PANEL1</a></td>
		<td id="personal_goalCells">PANEL2</td>
		<td id="personal_goalCells">PANEL3</td>
		<td id="personal_goalCells">PANEL4</td>
		<td id="personal_goalCells">PANEL5</td>
		<td id="personal_goalCells">PANEL6</td>
		</tr>
		</table> -->
		<div id="personal_goalHeader">Completed Goals</div>

		<div class="bxslider">
		<?php if ($countOld == 0) { ?>
			<div id="index_goalCells">You have not completed any goals yet!</div>
				<?php } ?>
				</div>

				<!-- <table id="personal_goalTable">
				<tr>
				<td id="personal_goalCells">PANEL1</td>
				<td id="personal_goalCells">PANEL2</td>
				<td id="personal_goalCells">PANEL3</td>
				<td id="personal_goalCells">PANEL4</td>
				<td id="personal_goalCells">PANEL5</td>
				<td id="personal_goalCells">PANEL6</td>
				</tr>
				</table>-->

				<div id="personal_goalHeader">Buddies Goals</div>

				<div class="bxslider"> 
				<?php if ($countBuddy == 0) { ?>
					<div id="index_goalCells">You aren't mentoring any active goals!</div>
						<?php } ?>
						</div>
						</div>
						</section>
						<?php include('includes/footer.php'); ?>
						</body>
						</html>

						<?php

						$current_goals = $db->prepare("SELECT title, start_date, goal.id, status AS goal_id FROM goal_title INNER JOIN goal 
							ON goal.goal_title_id = goal_title.id WHERE goal.user_id = ?");
						$current_goals->bind_param('i', $_SESSION['user_id']);
						$current_goals->execute();
						$current_goals->store_result();
						$current_goals->bind_result($title, $start, $goal_id, $status);

						while($current_goals->fetch()) {
							$buds = $db->prepare("SELECT id FROM mentors WHERE goal_id = ?");
							$buds->bind_param('i', $goal_id);
							$buds->execute();
							$buds->store_result();
							$num = $buds->num_rows;

							$notification = $db->prepare("SELECT goal.id FROM goal WHERE (
							(frequency = 1 AND DATE(last_update) < DATE_SUB(NOW(), INTERVAL 1 DAY)) OR
							(frequency = 7 AND DATE(last_update) < DATE_SUB(NOW(), INTERVAL 7 DAY)) OR
							(frequency = 30 AND DATE(last_update) < DATE_SUB(NOW(), INTERVAL 30 DAY)) OR
							(frequency = 365 AND DATE(last_update) < DATE_SUB(NOW(), INTERVAL 365 DAY))
							) AND start_date < NOW() AND goal.id = ?;");
							$notification->bind_param('i', $goal_id);
							$notification->execute();
							$notification->store_result();
							$notify = $notification->num_rows;
	
							if ($status == 0) {
								echo "<script type='text/javascript'>"
									, "addCurrentGoals('bxslider', '".$title."', '".$start."', '".$num."', '".$goal_id."', '".$notify."')"
									, "</script>";
							} else {
								echo "<script type='text/javascript'>"
									, "addOldGoals('bxslider', '".$title."', '".$start."', '".$num."', '".$goal_id."')"
									, "</script>";
							}
						}


$buddy_goals = $db->prepare("SELECT title, start_date, goal_id FROM mentors INNER JOIN goal 
	ON mentors.goal_id = goal.id INNER JOIN goal_title ON goal_title.id = goal_title_id WHERE mentor = ? AND status = ?");
$buddy_goals->bind_param('ii', $_SESSION['user_id'], $status = 0);
$buddy_goals->execute();
$buddy_goals->store_result();
$buddy_goals->bind_result($buddyTitle, $buddyStart, $buddyGoalId);

$countBuddy = 0;
while($buddy_goals->fetch()) {
	$support = $db->prepare("SELECT goal.id FROM goal WHERE (
							(frequency = 1 AND DATE(last_update) < DATE_SUB(NOW(), INTERVAL 1 DAY)) OR
							(frequency = 7 AND DATE(last_update) < DATE_SUB(NOW(), INTERVAL 7 DAY)) OR
							(frequency = 30 AND DATE(last_update) < DATE_SUB(NOW(), INTERVAL 30 DAY)) OR
							(frequency = 365 AND DATE(last_update) < DATE_SUB(NOW(), INTERVAL 365 DAY))
							) AND start_date < NOW() AND goal.id = ?;");
							$support->bind_param('i', $buddyGoalId);
							$support->execute();
							$support->store_result();
							$help = $support->num_rows;


	echo "<script type='text/javascript'>"
		, "addBuddyGoals('bxslider', '".$buddyTitle."', '".$buddyStart."', '".$buddyGoalId."', '".$help."')"
		, "</script>";
	$countBuddy=$countBuddy+1;
}

} else {
	echo 'You are not authorized to access this page, please login. <br/>';  	
	header('Location: ./login.php');
}

}

?>
