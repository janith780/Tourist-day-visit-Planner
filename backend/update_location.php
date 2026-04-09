<?php
include("db.php");
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../frontend/dashboard_view.php?msg=AccessDenied");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $district = $_POST['district'];
    $category = $_POST['category'];
    $open_time  = $_POST['open_time'];
    $close_time = $_POST['close_time'];
    $ticket_price = $_POST['ticket_price'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    if(!is_numeric($ticket_price) || !is_numeric($latitude) || !is_numeric($longitude)){
        header("Location: ../frontend/dashboard_view.php?msg=invalidData");
        exit();
    }

    $sql = "UPDATE location SET 
        name = '$name', 
        description = '$description',
        district = '$district',
        category = '$category',
        open_time = '$open_time',
        close_time = '$close_time',
        ticket_price = '$ticket_price',
        latitude = '$latitude',
        longitude = '$longitude'
        WHERE id = '$id'";

    if (mysqli_query($conn, $sql)){
        header("Location: ../frontend/dashboard_view.php?msg=updated");
    } else {
        header("Location: ../frontend/dashboard_view.php?msg=error");
    }
}
exit();
?>