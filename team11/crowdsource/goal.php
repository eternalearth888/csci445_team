<!DOCTYPE html>
<?php

include 'db_connect.php';
include 'functions.php';

session_start();

//if(login_check($db) == true) {

if(isset($_SESSION['goal'])) { 
	$goal_id = $_SESSION['goal'];
} else {
	$goal_id = intval($_GET["q"]);
}

$getGoal = $db->prepare("SELECT title, how, why, tag, user_id, status FROM goal_title
		INNER JOIN goal ON goal.goal_title_id = goal_title.id
		WHERE goal.id = ?");
$getGoal->bind_param('i', $goal_id);
$getGoal->execute();
$getGoal->store_result();
$getGoal->bind_result($title, $how, $why, $tag, $user_id, $status);
$getGoal->fetch();

if (login_check($db) == true) {
$getMentor = $db->prepare("SELECT mentor FROM mentors WHERE goal_id = ? AND mentor = ?");
$getMentor->bind_param('ii', $goal_id, $_SESSION['user_id']);
$getMentor->execute();
$getMentor->store_result();
$getMentor->bind_result($mentor);
$getMentor->fetch();

}
/*
SELECT mentor
FROM mentors
INNER JOIN goal ON goal.id = mentors.goal_id
INNER JOIN goal_title ON goal_title.id = goal.goal_title_id
WHERE goal_title REGEXP ?;
*/

?>
<html>
<head>
<?php include('includes/head.php'); ?>
<title>AccountabiliBuddies | Goal</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/master.css" type="text/css">
</head>
<script type="text/javascript">
function addRow(tableID, dt, text, user, id, goal_id) {
	//var textField = "default text";
	//if (id == 1) {
	//	var progress = document.getElementById("progress");
	//	textField = progress.value;
	//	progress.value = "";
	//} else {
	//	var comment = document.getElementById("comment");
	//       textField = comment.value;
	//	comment.value = "";
	//}
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);
	var firstCell = row.insertCell(0);
	firstCell.innerHTML = rowCount;
	if (id == 1) {
		var secondCell = row.insertCell(1);
		secondCell.innerHTML = user;
		var thirdCell = row.insertCell(2);
		thirdCell.innerHTML = dt;
		var fourthCell = row.insertCell(3);
		fourthCell.id = "goal_commentProgress";
		fourthCell.innerHTML = text;
		var del = row.insertCell(4);
		del.innerHTML = '<img src="images/delete.png" alt="DELETE" onClick = "Javascript:deleteRow(this, \''+goal_id+'\') ">';
	} else {
		var thirdCell = row.insertCell(1);
                thirdCell.innerHTML = dt;
                var fourthCell = row.insertCell(2);
		fourthCell.id = "goal_commentProgress";
                fourthCell.innerHTML = text;
	}
}

function deleteRow(obj, goal_id) {

//useful link for interactive pages!: http://www.w3schools.com/php/php_ajax_php.asp

	var index = obj.parentNode.parentNode.rowIndex;
        var table = document.getElementById("comments_dataTable");
/*
        if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
        }

        var r=confirm("Are you sure?");
        if(r==true) {
		xmlhttp.open("GET", "deleteComment.php?q="+goal_id+"&index="+index,true);
                xmlhttp.send();
       //         table.deleteRow(index);
        }
*/

	var r=confirm("Are you sure?");
        if(r==true) {
                location.href = "deleteComment.php?q="+goal_id+"&index="+index;
        }


} 

function mentor(goal_id) {	
	location.href = "mentor_goal.php?q="+goal_id;
}

function completeGoal(goal_id) {
	var r=confirm("Are you sure?");
	if(r==true) {
		location.href = "complete_goal.php?q="+goal_id;
	}
}
</script>
<body>

<?php include('includes/header.php'); ?>
<section>

<div id="content">
<table id="goal_table">
<tr>
<td id="goal_title" colspan="2"><?php echo $title ?></td>
</tr>
<tr>
<td id="goal_tags" colspan="2"><?php echo $tag ?></td>
</tr>
<tr>
<td id="goal_mentors" colspan="2">
<?php
	$buds = "select id from mentors where goal_id = ?";
        $num = $db->prepare($buds);
        $num->bind_param('i', $goal_id);
        $num->execute();
        $num->store_result();
        $num_buddies = $num->num_rows;
        $num->close();
	echo "Number of Mentors: ".$num_buddies;
?>
</td>
</tr>
<tr>
<td id="goal_complete" colspan="2"><?php if ($status==1) echo "GOAL COMPLETE"?></td>
</tr>
<tr>
<td id="goal_label" colspan="2"><label for="how">How</label></td>
</tr>
<tr>
<td id="goal_content"><?php echo $how ?></td>
</tr>
<tr>
<td id="goal_label" colspan="2"><label for="how">Why</label></td>
</tr>
<tr>
<td id="goal_content"><?php echo $why ?></td>
</tr>
<tr>
<td id="goal_label" colspan="2"><label for="updates">Progess Updates</label></td>
</tr>
<tr>
<td id="goal_progressUpdatesContent" colspan="2">
<table id="progress_dataTable">
<tr id="progress_dataTable_top">
<td id="profile_num"><label for="num">#</label></td>
<td id="profile_date"><label for="date_time">Date/Time</label></td>
<td id="profile_content"><label for="content">Progress</label></td>
</tr>
</table>
</td>
</tr>

<?php if(login_check($db) == true && $_SESSION['user_id'] == $user_id && $status == 0) { ?>
	<tr>
		<td id="progress_add" colspan="2">
		<form id="progress_form" action="save_progress.php" method="post">
		<input type="text" id="progress" name="progress">
		<input type="hidden" id="goal_id" name="goal_id" value="<?php echo $goal_id; ?>">
		<input type="submit" value="Add Progress Update"/>
		</form>
		</td>
		</tr>
		<?php } ?>

		</tr>
		<tr>
		<td id="goal_label" colspan="2"><label for="comments">Goal Comments</label></td>
		</tr>
		<tr>
		<td id="goal_commentsContent" colspan="2">
		<table id="comment_dataTable">
		<tr id="comment_dataTable_top">
		<td id="profile_num"><label for="num">#</label></td>
		<td id="profile_user"><label for="user">Buddy</label></td>
		<td id="profile_date"><label for="date_time">Date/Time</label></td>
		<td id="profile_content"><label for="content">Comment</label></td>
		<td id="profile_delete"><label for="delete">Delete?</label></td>
		</tr>
		</table>
		</td>
		</tr>
		<?php if(login_check($db) == true) { ?>
			<tr>
				<td id="comment_add" colspan="2">
				<form id="comment_form" defaultbutton="enter" action="save_comment.php" method="post">
				<input type="text" id="comment" name="comment">
				<input type="hidden" id="goal_id" name="goal_id" value="<?php echo $goal_id; ?>">
				<input type="submit" value="Add Comment"/>
				</form>
				</td>
				</tr>
				 </tr>
                <tr id="goal_stat" colspan="2">
<td>
<?php
//$new_results = mysqli_query($db, $new_goals);
//$countNew = 0;
//while($row = mysqli_fetch_array($new_results)) {
//        $countNew = $countNew+1;
//}
/*
$stat = "select from_unixtime(avg(unix_timestamp(start_date)-unix_timestamp(last_update))) AS diff from goal, goal_title where goal_title_id = goal_title.id AND title REGEXP '$title' AND status = 1;";
$stat_result = mysqli_query($db, $stat);
$res = mysqli_fetch_array($stat_result);
$diff = $res['diff'];
$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
echo "Avg Similar Goal Completion Time: ".$years." Years, ".$months." Months, ".$days." Days";
*/?>
</td>
</tr>

				<?php if($_SESSION['user_id'] != $mentor && $_SESSION['user_id'] != $user_id) { ?>
					<tr>
						<td id="goal_edit" colspan="2">
						<button type="button" value="mentor_goal" onclick="Javascript:mentor('<?php echo $goal_id; ?>');">Mentor This Goal</button>
						</td>
						</tr>
						<?php } if ($_SESSION['user_id'] == $user_id && $status == 0) { ?>
							<tr>
								<td id="complete_goal" colspan="2">
								<button type="button" value="complete_goal" onclick="Javascript:completeGoal('<?php echo $goal_id; ?>');">Mark Goal As Completed</button>
								</tr>
								<?php } } ?>
								</table>
								</div>
								</section>
								<?php include('includes/footer.php'); ?>
								<?php
								$progress = "select status_text, status_update 
								from progress where goal_id = ?";
								$progress_result = $db->prepare($progress);
								$progress_result->bind_param('i', $goal_id);
								$progress_result->execute();
								$progress_result->store_result();
								$progress_result->bind_result($progtext, $progupdate);
								while ($progress_result->fetch()) {
									echo "<script type='text/javascript'>"
										, "addRow('progress_dataTable', '".$progupdate."', '".$progtext."', '".$_SESSION['username']."', 0)"
										, "</script>";
								}

$comment = "select note, note_update, buddy 
from comments where goal_id = ?";
$comment_result = $db->prepare($comment);
$comment_result->bind_param('i', $goal_id);
$comment_result->execute();
$comment_result->store_result();
$comment_result->bind_result($comtext, $comupdate, $buddy);
while ($comment_result->fetch()) {
	echo "<script type='text/javascript'>"
		, "addRow('comment_dataTable', '".$comupdate."', '".$comtext."', '".$buddy."', 1, '".$goal_id."')"
		, "</script>";
}

?>
</body>
</html>

<?php
//} else {
//	echo "You are not authorized to view this page!";
//}
?>
