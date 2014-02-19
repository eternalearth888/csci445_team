<?php

define("HOST", "localhost");
define("USER", "team11");
define("PASSWORD", "banana");
define("DATABASE", "team11");

@ $db = new mysqli(HOST, USER, PASSWORD, DATABASE);
if (mysqli_connect_errno()) {
	echo "Error. Could not connect to database. Please try again later.";
	printf("Connect failed: %s\n", $db->connect_error);
	exit;
}

?>
