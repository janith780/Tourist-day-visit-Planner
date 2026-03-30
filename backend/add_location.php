<?php
include('db.php');
session_start();

if($_SESSION['role']!='admin'){
    echo "Access Denied";
    exit();
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $district = $_POST['district'];
    $category = $_POST['category'];
    $open_time = $_POST['open_time'];
    $close_time = $_POST['close_time'];
    $ticket_price = $_POST['ticket_price'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    
    $sql = "INSERT INTO location
    (name, description, district, category, open_time, close_time, ticket_price, latitude, longitude)
    VALUES
    ('$name','$description','$district','$category','$open_time','$close_time','$ticket_price','$latitude','$longitude')";
    
    if(mysqli_query($conn, $sql)){
        echo "Location added successfully";
    }else {
        echo "Error: ". mysqli_error($conn);
    }
}
?>
