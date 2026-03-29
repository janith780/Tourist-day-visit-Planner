<?php
include("db.php");

if (isset($_POST['register'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    //chack email already in db

    $check = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result)>0){
        echo "Email already exists!";
    }else{
        $sql = "INSERT INTO users(name, email, password, role)
                VALUES ('$name', '$email', '$password', 'user')";

        if(mysqli_query($conn, $sql)) {
            echo "Registration successful!";
        }else{
            echo "Error: ". mysqli_error($conn);
        }       
    }
}
?>

