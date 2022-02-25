<?php 
ob_start();
session_start();
include("_adminarea_/db/config.php");
unset($_SESSION['user']);
header("location: ".BASE_URL.""); 
?>