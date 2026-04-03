<?php
session_start();
if (!isset($_SESSION['user'])){
    header("Location: frontend/login.html");
    exit();
}
//pass to html
$username = $_SESSION['user'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';

include("dashboard_view.php");
?>