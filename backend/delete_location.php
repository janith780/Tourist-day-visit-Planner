<?php
include("db.php");
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "Access denied";
    exit();
}

// ✅ Check if id is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM location WHERE id='$id'";

    if(mysqli_query($conn, $sql)) {
        echo "Deleted successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "Invalid request: ID not found";
}
?>