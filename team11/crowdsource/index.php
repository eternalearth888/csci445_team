<!DOCTYPE html>
<?php
include "db_connect.php";
include "functions.php";

if (!isset($_GET['search'])) {
	$new_goals = "SELECT goal.id AS goal_id, title, start_date, intended_end_date, last_update, client.id, username from goal, goal_title, profile, client WHERE goal.user_id = profile.user_id and goal_title.id = goal_title_id AND goal.user_id = client.id AND last_update > DATE_SUB(NOW(), INTERVAL 10 DAY) AND status = 0;";
} else {
	$search = $_GET['search'];
	$new_goals = "SELECT goal.id AS goal_id, title, start_date, intended_end_date, last_update, client.id, username from goal, goal_title, profile, client WHERE goal.user_id = profile.user_id and goal_title.id = goal_title_id AND goal.user_id = client.id AND last_update > DATE_SUB(NOW(), INTERVAL 10 DAY) AND title REGEXP '$search' AND status = 0;";
}
$new_results = mysqli_query($db, $new_goals);
$countNew = 0;
while($row = mysqli_fetch_array($new_results)) {
	$countNew = $countNew+1;
}

if (!isset($_GET['search'])) {
	$all_goals = "SELECT goal.id AS goal_id, title, start_date, intended_end_date, last_update, client.id, username, status FROM goal, goal_title, profile, client WHERE goal.user_id = profile.user_id AND goal_title.id = goal_title_id AND goal.user_id = client.id AND status = 0";
} else {
	$search = $_GET['search'];
	$all_goals = "SELECT goal.id AS goal_id, title, start_date, intended_end_date, last_update, client.id, username, status FROM goal, goal_title, profile, client WHERE goal.user_id = profile.user_id AND goal_title.id = goal_title_id AND goal.user_id = client.id AND title REGEXP '$search' AND status = 0";
}
$goal_results = mysqli_query($db, $all_goals);
$countCurrent = 0;
while ($row = mysqli_fetch_array($goal_results)) {
	$countCurrent = $countCurrent+1;
}	

if (!isset($_GET['search'])) {
	$all_goals = "SELECT goal.id AS goal_id, title, start_date, intended_end_date, last_update, client.id, username, status FROM goal, goal_title, profile, client WHERE goal.user_id = profile.user_id AND goal_title.id = goal_title_id AND goal.user_id = client.id AND status = 1";
} else {
	$search = $_GET['search'];
	$all_goals = "SELECT goal.id AS goal_id, title, start_date, intended_end_date, last_update, client.id, username, status FROM goal, goal_title, profile, client WHERE goal.user_id = profile.user_id AND goal_title.id = goal_title_id AND goal.user_id = client.id AND title REGEXP '$search' AND status = 1";
}
$goal_results = mysqli_query($db, $all_goals);
$countComplete = 0;
while ($row = mysqli_fetch_array($goal_results)) {
	$countComplete = $countComplete+1;
}

?>
<html>
<meta charset="utf-8">
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

//this is inefficient - these two functions are the same except they use the 2 different bxsliders. I tried to change the class name of bxslider to bxslider1 and 2  but then they stopped working. please investigate!


function addNewGoals(id, title, start_date, num_mentors, goal_id) {
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
        start.innerHTML = "Start Date: " + start_date;
        element.appendChild(start);
        var mentors = document.createElement('p');
        mentors.id = "index_sliderGoal";
	mentors.innerHTML = "Buddies: " + num_mentors;
        element.appendChild(mentors);
        var div = document.getElementsByClassName(id)[0];
        div.appendChild(element);
        //div.innerHTML = div.innerHTML + title;
}

function addGoals(id, title, start_date, num_mentors, goal_id) {
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
	start.innerHTML = "Start Date: " + start_date;
        element.appendChild(start);
        var mentors = document.createElement('p');
        mentors.id = "index_sliderGoal";
	mentors.innerHTML = "Buddies: " + num_mentors;
        element.appendChild(mentors);
        var div = document.getElementsByClassName(id)[1];
        div.appendChild(element);
        //div.innerHTML = div.innerHTML + title;
}

function addAllGoals(id, title, start_date, num_mentors, goal_id) {
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
	start.innerHTML = "Start Date: " + start_date;
        element.appendChild(start);
        var mentors = document.createElement('p');
        mentors.id = "index_sliderGoal";
	mentors.innerHTML = "Buddies: " + num_mentors;
        element.appendChild(mentors);
        var div = document.getElementsByClassName(id)[2];
        div.appendChild(element);
        //div.innerHTML = div.innerHTML + title;
}


//function viewGoal(goal_id) {
//	location.href = "goal.php?q="+goal_id;
//}

</script>
</head>
<script type="text/javascript" src="goals.js"></script>
<body>

<?php
session_start(); 
include('includes/header.php');

?> 
<section>
<div id="content">
<table id="index_table">
<tr>
<td id="index_searchCell">
<div id="search">
	<form action="search.php" method="post">
		<input type="text" value="Enter Goal to Search" name="search" onFocus="this.value=''">
		<input type="submit" value="Search"/>
	</form>	
</div>
</td>
</tr>
<tr>
<td>
<div id="index_goalHeader">New Goals</div>

<div class="bxslider">
<?php if ($countNew == 0) { ?>
	<div id="index_goalCells">There are no new goals.</div>
		<?php } ?>
		</div>

		<div id="index_goalHeader">Current User Goals</div>
	
		<div class="bxslider">
		<?php if ($countCurrent == 0) { ?>
		<div id="index_goalCells">There are no current goals.</div>
		<?php } ?>
		</div>

		<div id="index_goalHeader">Completed User Goals</div>
		<div class="bxslider">
		<?php if ($countComplete == 0) { ?>
		<div id="index_goalCells">There are no completed goals.</div>
		<?php } ?>

		</div>
		</td>
		</tr>
		</table>	
	
		</div>
		</section>
		<?php include('includes/footer.php'); ?>
		<?php

		$new_results = mysqli_query($db, $new_goals);
		while($row = mysqli_fetch_array($new_results)) {
			$buds = $db->prepare("SELECT id FROM mentors WHERE goal_id = ?");
			$buds->bind_param('i', $row['goal_id']);
         		$buds->execute();
         		$buds->store_result();
         		$num = $buds->num_rows;

			echo "<script type='text/javascript'>"
				, "addNewGoals('bxslider', '".$row['title']."', '".$row['start_date']."', '".$num."', '".$row['goal_id']."')"
				, "</script>";
		}

if (!isset($_GET['search'])) {
	$all_goals = "SELECT goal.id AS goal_id, title, start_date, intended_end_date, last_update, client.id, username, status FROM goal, goal_title, profile, client WHERE goal.user_id = profile.user_id AND goal_title.id = goal_title_id AND goal.user_id = client.id";
} else {
	$search = $_GET['search'];
	$all_goals = "SELECT goal.id AS goal_id, title, start_date, intended_end_date, last_update, client.id, username, status FROM goal, goal_title, profile, client WHERE goal.user_id = profile.user_id AND goal_title.id = goal_title_id AND goal.user_id = client.id AND title REGEXP '$search'";
}
$goal_results = mysqli_query($db, $all_goals);

while($row2 = mysqli_fetch_array($goal_results)) {
	 $buds = $db->prepare("SELECT id FROM mentors WHERE goal_id = ?");
         $buds->bind_param('i', $row2['goal_id']);
         $buds->execute();
         $buds->store_result();
         $num = $buds->num_rows;
	if ($row2['status'] == 0) {
	echo "<script type='text/javascript'>"
		, "addGoals('bxslider', '".$row2['title']."', '".$row2['start_date']."', '".$num."', '".$row2['goal_id']."')"
		, "</script>";
	} else {
		echo "<script type='text/javascript'>"
		, "addAllGoals('bxslider', '".$row2['title']."', '".$row2['start_date']."', '".$num."', '".$row2['goal_id']."')"
		, "</script>";
	}
}
?>
</body>
</html>
