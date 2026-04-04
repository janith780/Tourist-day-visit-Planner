<?php
session_start();

// If user not logged in → redirect to login
if (!isset($_SESSION['user'])){
    header("Location: frontend/login.html");
    exit();
}

// Pass session variables to frontend
$username = $_SESSION['user'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';

// Include dashboard view
include("dashboard_view.php");
?>