<!DOCTYPE html>				
<?php

include 'db_connect.php';
include 'functions.php';

session_start();

if(login_check($db) == true) {

	//get the user id
	$grab_user_id = $db->prepare("
			SELECT user_id, last_name, first_name, img_path FROM profile
			INNER JOIN client ON client.id = profile.user_id
			LEFT OUTER JOIN image ON image.id = profile.image_id
			WHERE client.username = ?");
	$grab_user_id->bind_param('s', $_SESSION['username']);
	$grab_user_id->execute();
	$grab_user_id->store_result();
	$grab_user_id->bind_result($user_id, $last_name, $first_name, $image_path);
	$grab_user_id->fetch();

	?>
		<html>

		<head>
		<?php include('includes/head.php'); ?>
		</head>

		<body>
		<script type="text/javascript">
		function addRow(tableID, title, tag, start_date, end_date, freq, goal_id, user_id, numBuds) {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);
			var goalCount = row.insertCell(0);
			goalCount.innerHTML = rowCount;
			var titleText = row.insertCell(1);
			titleText.innerHTML = title;
			var tagText = row.insertCell(2);
			tagText.innerHTML = tag;
			var startText = row.insertCell(3);
			startText.innerHTML = start_date;
			var endText = row.insertCell(4);
                        endText.innerHTML = end_date;
			var freqText = row.insertCell(5);
                        freqText.innerHTML = freq;
			var buddies = row.insertCell(6);
			buddies.innerHTML = numBuds;
			var edit = row.insertCell(7);
			edit.innerHTML = '<img src="images/edit.png" alt="EDIT" onclick = "Javascript:editGoal(this, \''+user_id+'\') ">';
			var del = row.insertCell(8);
			del.innerHTML = '<img src="images/delete.png" alt="DELETE" onClick = "Javascript:deleteRow(this, \''+user_id+'\') ">';
			var complete = row.insertCell(9);
			complete.innerHTML = '<img src="images/complete.png" alt="COMPLETE" onClick = "Javascript:completeGoal(\''+goal_id+'\') ">';
		}

	function editGoal(obj, user_id) {
		var index = obj.parentNode.parentNode.rowIndex;
		var table = document.getElementById("profile_dataTable");
		location.href = "editGoal.php?q="+user_id+"&index="+index;
	}

	function deleteRow(obj, user_id) {

		//useful link for interactive pages!: http://www.w3schools.com/php/php_ajax_php.asp

		var index = obj.parentNode.parentNode.rowIndex;
		var table = document.getElementById("profile_dataTable");

		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}
		//xmlhttp.onreadystatechange = function() {
		//	if(xmlhttp.readyState==4 && xmlhttp.status==200) {
		//		document.getElementById("profile_dataTable").innerHTML=xmlhttp.responseText;
		//	}
		//}

		var r=confirm("Are you sure?");
		if(r==true) {
			xmlhttp.open("GET", "deleteFromDatabase.php?q="+user_id+"&index="+index,true);
			xmlhttp.send();
			table.deleteRow(index);
		}
	}

	function completeGoal(goal_id) {
        	var r=confirm("Are you sure?");
        	if(r==true) {
                	location.href = "complete_goal_no_change.php?q="+goal_id;
        	}
	}

	</script>
		<?php include('includes/header.php'); ?>	
		<section>
		<div id="content">
		<table id="profile_content">
		<tr>
		<td id="profile_userName" colspan="2">
		<?php echo $first_name." ".$last_name ?>
		</td>
		</tr>
		<tr>
		<td id="profile_asideCell">
		<div id="profile_picture">
		<img id="profile_image" alt="Profile Pic" src="<?php echo $image_path ?>">
		</div>
		<div id="profile_settings">
		<form id="profile_upload_file" action="upload_file.php" method="post"
		enctype="multipart/form-data">
		<table id="profile_changePic">
		<tr>
		<td id="profile_changePic_top">
		<label for="file">Change Image</label>
		</td>
		</tr>
		<tr>
		<td id="profile_changeButton" >
		<div class="fileUpload btn btn-primary">
		<input type="file" name="file" id="profile_file">
		</div>
		</td>
		</tr>
		<tr>
		<td id="profile_changeButton" >
		<input type="submit" name="submit" value="Submit">
		</td>
		</tr>
		</td>
		</table>
		</form>			
		<table id="profile_stats">
		<tr>
		<td id="profile_stats_top" colspan="2">
		<label for="stats">Statistics</label>	
		</td>
		</tr>
		<tr>
		<td id="stat_list">Current Goals:</td>
		<td id="stat_val">	
		<?php
			$goals = $db->prepare("SELECT id FROM goal WHERE user_id = ? AND status = 0");
			$goals->bind_param('i', $user_id);
			$goals->execute();
			$goals->store_result();
			$num_goals = $goals->num_rows;
			echo $num_goals;
			$goals->close();
		?>		
		</td>
		</tr>
		<tr>
                <td id="stat_list">Goals Completed:</td>
                <td id="stat_val">    
                <?php
                        $goals = $db->prepare("SELECT id FROM goal WHERE user_id = ? AND status = 1");
                        $goals->bind_param('i', $user_id);
                        $goals->execute();
                        $goals->store_result();
                        $num_goals = $goals->num_rows;
                        echo $num_goals;
                        $goals->close();
                ?>              
                </td>
                </tr>
		<tr>
                <td id="stat_list">Mentoring:</td>
                <td id="stat_val">    
                <?php
                        $goals = $db->prepare("SELECT id FROM mentors WHERE mentor = ?");
                        $goals->bind_param('i', $user_id);
                        $goals->execute();
                        $goals->store_result();
                        $num_goals = $goals->num_rows;
                        echo $num_goals;
                        $goals->close();
                ?>              
                </td>
                </tr>
		</table>
		</div>
		</td>
		<td id="profile_articleCell">
		<table id="profile_dataTable">
		<tr id="profile_dataTable_top">
		<td>Goal</td>
		<td>Goal Title</td>
		<td>Tag</td>
		<td>Start Date</td>
		<td>Intended End Date</td>
		<td>Update Frequency</td>
		<td># Mentors</td>
		<td>Edit</td>
		<td>Delete</td>
		<td>Complete</td>
		</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td id="profile_addGoal_Button" colspan=6>
		<form id="goal_form" action="goal_form.php" method="post">
		<input type="submit" value="Add Goal"/>
		</form>
		</td>
		</tr>
		</table>
		</div>
		</section>
		<?php include('includes/footer.php'); ?>
		<?php
		$query = "select title, tag, goal.id, frequency, start_date, 
		status, intended_end_date, last_update from goal, 
		goal_title where goal_title_id = goal_title.id
			and user_id = ?;";
	$result = $db->prepare($query);
	$result->bind_param('i', $user_id);
	$result->execute();
	$result->store_result();
	$result->bind_result($title, $tag, $goal_id, $freq, $start_date, $status, $end_date, $last_update);
	$i = 0;
	while ($result->fetch()) {
		//        $num_results = $result->num_rows;
		//        for ($i=1; $i<=$num_results; $i++) {
		//        	$row = $result->fetch_assoc();
		
		$buds = "select id from mentors where goal_id = ?";
                $num = $db->prepare($buds);
                $num->bind_param('i', $goal_id);
                $num->execute();
                $num->store_result();
		$num_buddies = $num->num_rows;
                $num->close();

		if (!$status) {

			//			$title = stripslashes($title);
			//			$start_date = stripslashes($start_date);	
			echo "<script type='text/javascript'>"
				, "addRow('profile_dataTable', '".$title."', '".$tag."', '".$start_date."', '".$end_date."', '".$freq."', '".$goal_id."', '".$user_id."', '".$num_buddies."')"
				, "</script>";
		}
	}

	?>

		</body>
		</html>

		<?php 

	} else {
		echo 'You are not authorized to access this page, please login. <br/>';
		header('Location: ./login.php');
	}

	?>
