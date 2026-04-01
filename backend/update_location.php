<?php
include("db.php");
session_start();

if($_SESSION['role'] != 'admin'){
    echo "Access denied";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "UPDATE location
    SET name = '$name', description = '$description'
    WHERE id = '$id'";

    if (mysqli_query($conn, $sql)){
        echo "Updated successfully";
    }else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>