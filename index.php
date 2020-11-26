<?php
session_start();
if (!$_SESSION) {
  include('login.php');
}
if ($_SESSION) {
  include('dashboard.php');
}