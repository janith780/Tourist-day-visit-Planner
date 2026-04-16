<?php
include("db.php");
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: ../frontend/login.html");
    exit();
}

$username = $_SESSION['name'];
$location_id = $_POST['location_id'];
$review = $_POST['review'];

$sql = "INSERT INTO reviews (location_id, username, review)
        VALUES ('$location_id', '$username', '$review')";

mysqli_query($conn, $sql);

header("Location: ../frontend/location_details.php?id=$location_id");
?>