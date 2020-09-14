<?php
DEFINE ('DB_USER', 'testuser');
DEFINE ('DB_PASSWORD', 'zCiE22ntghMnLOxW');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'phpdb');

$db_connection = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die("Connection could not be established. " . mysqli_connect_error());
?>