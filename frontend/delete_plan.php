<?php
// 🔥 NEW CODE (session)
session_start();
include("../backend/db.php");

$id = $_GET['id'];
$user_id = $_SESSION['user_id']; // 🔥 NEW CODE

// 🔥 NEW CODE (check ownership)
$check = mysqli_query($conn, "SELECT * FROM day_plans 
                             WHERE id=$id AND user_id='$user_id'");

if(mysqli_num_rows($check) > 0){
    mysqli_query($conn, "DELETE FROM plan_places WHERE plan_id=$id");
    mysqli_query($conn, "DELETE FROM day_plans WHERE id=$id");
}

header("Location: view_plans.php");
?>