<?php

// Definerer konstante værdier
DEFINE ('DB_USER', 'Atobadmin');
DEFINE ('DB_PASSWORD', 'paNpRYgTiSD6zRwq');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'atob');

// En variabel der forbinder til databasen
$db_connection = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die("Connection could not be established. " . mysqli_connect_error());
?>