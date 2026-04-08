<?php
include("db.php");

if (isset($_POST['register'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // check email already exists
    $check = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0){
        //  email exists
        header("Location: ../frontend/register.html?error=1");
        exit();
    } else {

        $sql = "INSERT INTO users(name, email, password, role)
                VALUES ('$name', '$email', '$password', 'user')";

        if(mysqli_query($conn, $sql)) {
            //  success
            header("Location: ../frontend/register.html?success=1");
            exit();
        } else {
            header("Location: ../frontend/register.html?error=2");
            exit();
        }
    }
}
?>

