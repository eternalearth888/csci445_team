<!DOCTYPE html>
<?php
include "db_connect.php"
?>
<html>
<head>
	<?php include('includes/head.php'); ?>
</head>
<body>

<?php
session_start(); 
include('functions.php');
include('includes/header.php');

?> 
<section>
<div id="content">
<form action="save_goal.php" method="post">
<table id="goalForm_table">
<tr>
<td id="goalForm_header" colspan="2">Goal Form</td>
</tr>
<tr>
<td id="goalForm_tableLabel"><label for="title">Goal Title</label></td>
<td id="goalForm_tableContent"><input type="text" name="title" id="title"/></td>

</tr>
<tr>
<td id="goalForm_tableLabel"><label for="tag">Tag</label></td>
<td id="goalForm_tableContent"><input type="text" name="tag" id="tag"/></td>
</tr>
<tr>
<td id="goalForm_tableLabel"><label for="why">Why?</label></td>
<td id="goalForm_tableContent"><textarea name="why" id="why" onFocus="this.value=''">Why do you want to complete this goal?</textarea></td>
</tr>
<tr>
<td id="goalForm_tableLabel"><label for="how">How?</label></td>
<td id="goalForm_tableContent"><textarea name="how" id="how" onFocus="this.value=''">How will you complete your goal?</textarea></td>
</tr>
<tr>
<td id="goalForm_tableLabel"><label for="start_date">Start Date mm/dd/yy</label></td>
<td id="goalForm_tableContent"><input type="date" name="start_date" id="start_date"></td>
</tr>
<tr>
<td id="goalForm_tableLabel"><label for="intended_end_date">Intended End Date mm/dd/yy</label></td>
<td id="goalForm_tableContent"><input type="date" name="intended_end_date" id="intended_end_date"></td>
</tr>
<tr>
<td id="goalForm_tableLabel"><label for="frequency">Update Frequency</label></td>
<td id="goalForm_tableContent">
<select type="text" name="frequency" id="frequency">
<option value="daily" selected="selected">Daily - 1</option>
<option value="weekly">Weekly - 7</option>
<option value="monthly">Monthly - 30</option>
<option value="yearly">Yearly - 365</option>
</select>
</td>
</tr>
<tr id="goalForm_buttons">
<td colspan="2">
<input type="submit" value="Save Goal"/>
<input type="button" value="Cancel"/>
</td>
</tr>
</table>
</form>
</div>
</section>
<?php include('includes/footer.php'); ?>
</body>
</html>
