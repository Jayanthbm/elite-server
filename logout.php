<?php
session_start();
include './conn.php';
$userid = $_SESSION['userId'];
$uq = "UPDATE users SET isLoggedin =0 WHERE userId = $userid";
if (!mysqli_query($conn, $uq)) {
} else {
  session_destroy();
  header("Location: index.php");
}