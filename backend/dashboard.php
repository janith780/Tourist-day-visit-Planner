<?php
session_start();
if (!isset($_SESSION['user'])){
    header("Location: login.html");
    exit();
}
//pass to html
$username = $_SESSION['user'];
$role = $_SESSION['role'];

include("dashboard.html");
?>