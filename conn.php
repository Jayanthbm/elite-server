<?php
$server = 'localhost';
$username = 'root';
$password = '';
$dbname = 'elite';

$conn = mysqli_connect($server, $username, $password, $dbname);
date_default_timezone_set('Asia/Kolkata');
$date_time = date('Y-m-d H:i:s', time ());