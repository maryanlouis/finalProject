<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db = "groupbuy";

	$conn = mysqli_connect($server, $username, $password, $db);
	if (!$conn) {
		die("Connection faild: ". mysqli_connect_error());
	}
	//echo"Connected successfully!";
?>