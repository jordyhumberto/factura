<?php
$mysqli = new mysqli("localhost","root","","sistemau_matricula");
$mysqli ->set_charset("utf8");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} 
/* echo "Connected successfully"; */
?>
