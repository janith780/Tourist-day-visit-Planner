<?php
session_start();
if (!isset($_SESSION['name'])){
    header("Location: frontend/login.html");
    exit();
}
//pass to html
$username = $_SESSION['name'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';

include("dashboard_look.php");
?>