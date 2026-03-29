<?php
include("db.php");
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if($email && $password_verify($password, $user['password'])){
        $_SESSION['user'] = $user['name'];
        echo "Login successful!";
        //header("Location: dashboard.php");
    }else{
        echo "Invalid email or password!";
    }
}
?>