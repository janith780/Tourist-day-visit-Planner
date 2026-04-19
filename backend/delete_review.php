<?php
include("db.php");
session_start();

if (!isset($_SESSION['name'])) {
    exit("Access Denied");
}

$id = $_GET['id'];
$location_id = $_GET['loc'];

// Check owner
$res = mysqli_query($conn, "SELECT * FROM reviews WHERE id='$id'");
$row = mysqli_fetch_assoc($res);

if ($row['username'] != $_SESSION['name']) {
    exit("Not allowed");
}

// Delete
mysqli_query($conn, "DELETE FROM reviews WHERE id='$id'");

header("Location: ../frontend/location_details.php?id=$location_id");
?>