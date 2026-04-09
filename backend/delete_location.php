<?php
include("db.php");
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../frontend/dashboard_view.php?msg=AccessDenied");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM location WHERE id='$id'";

    if(mysqli_query($conn, $sql)) {
        header("Location: ../frontend/dashboard_view.php?msg=deleted");
    } else {
        header("Location: ../frontend/dashboard_view.php?msg=error");
    }
} else {
    header("Location: ../frontend/dashboard_view.php?msg=invalid");
}
exit();
?>