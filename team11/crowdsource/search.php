<?php
include 'db_connect.php';
session_start();

$search= $_POST["search"];

if ($search=="") {
	header('Location: ./index.php');
} else {
	header('Location: ./index.php?search='.$search);
}
?>
