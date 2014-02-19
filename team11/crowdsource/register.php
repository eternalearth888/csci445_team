<!DOCTYPE html>
<html>
<head>
<?php include('includes/head.php'); ?>
<script type="text/javascript" src="javascript/sha512.js"></script>
<script type="text/javascript" src="javascript/forms.js"></script>

<?php


if(isset($_Get['error'])) {
	echo 'Error: Cannot log in at this time';
}

?>
</head>
<body>
<div id="register_background">
<?php include('includes/headerRegister.php'); ?>
<section>
<div id="register_box">
<form action="success.php" method="post" name="login_form" defaultbutton="enter">
<table id="register_table">
<tr>
<td>First Name: </td>
<td><input type="text" name="fname">
</tr>
<tr>
<td>Last Name: </td>
<td><input type="text"  name="lname"></td>
</tr>
<tr>
<td>Username: </td>
<td><input type="text" name="username" /></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="password" name="password" id="password"/></td>
</tr>
<tr>
<td colspan="2"><input id="register_button" type="submit" value="Create Account" onclick="formhash(this.form, this.form.password);" /></td>
</tr>
</table>
</form>
</div>
</section>
<?php include('includes/footer.php'); ?>
</div>
</body>
</html>

