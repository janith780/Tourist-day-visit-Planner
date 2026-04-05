<?php
include("db.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    //  FIXED condition
    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.php");
        exit();

    } else {
        echo "Invalid email or password!";
    }
}
?>
?>