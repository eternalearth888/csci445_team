<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
<?php include('includes/head.php'); ?>
<script type="text/javascript" src="javascript/sha512.js"></script>
<script type="text/javascript" src="javascript/forms.js"></script>
<?php

//http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL
// onclick="formhash(this.form, this.form.password);"
if(isset($_Get['error'])) {
	echo 'Error: Cannot log in at this time';
}

?>
</head>
<body>
<div id="login_background">
<?php include('includes/headerLogIn.php'); ?>
<section>
<div id="login_box">
<form action="processing.php" method="post" name="login_form" defaultbutton="enter">
<table id="login_table">
<tr>
<td>Username: </td>
<td><input type="text" name="username" /></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="password" name="password" id="password"/></td>
</tr>
<tr>
<td colspan="2">
<table id="login_buttons">
<tr>
<td>
<input value="Login" type="submit"  onclick="formhash(this.form, this.form.password);" />
</form>
</td>
<td>
<form action="register.php"><input type="submit" value="Or Register" /></form>
</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
</section>
<?php include('includes/footer.php'); ?>
</div>
</body>
</html>

