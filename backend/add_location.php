<?php
include('db.php');
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
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
    $always_open = isset($_POST['always_open']) ? 1 : 0;
    $ticket_price = $_POST['ticket_price'];
    $free_entry = isset($_POST['free_entry']) ? 1 : 0;
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    

    // ✅ Fix empty values
    if ($latitude == '') $latitude = 0;
    if ($longitude == '') $longitude = 0;
    if ($ticket_price == '') $ticket_price = 0;

    // ===============================
    // ✅ MAIN IMAGE (for dashboard)
    // ===============================
    $mainImage = '';

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $tmp = $_FILES['image']['tmp_name'];
        $mainImage = time() . '_main_' . $_FILES['image']['name'];
        $path = "../images/" . $mainImage;

        if(!move_uploaded_file($tmp, $path)){
            echo "Main image upload failed!";
            exit();
        }
    }

    // ===============================
    // ✅ INSERT LOCATION
    // ===============================
   $sql = "INSERT INTO location 
(name, description, district, category, open_time, close_time, ticket_price, latitude, longitude, image, always_open, free_entry)
VALUES 
('$name','$description','$district','$category','$open_time','$close_time','$ticket_price','$latitude','$longitude','$mainImage','$always_open','$free_entry')";
    if(mysqli_query($conn, $sql)){

        // Get inserted location ID
        $location_id = mysqli_insert_id($conn);

        // ===============================
        // ✅ MULTIPLE IMAGES (gallery)
        // ===============================
        if(isset($_FILES['images'])){
            $total = count($_FILES['images']['name']);

            for($i = 0; $i < $total; $i++){

                if($_FILES['images']['error'][$i] == 0){

                    $tmp = $_FILES['images']['tmp_name'][$i];
                    $imageName = time() . '_gallery_' . $_FILES['images']['name'][$i];
                    $path = "../images/" . $imageName;

                    if(move_uploaded_file($tmp, $path)){
                        mysqli_query($conn, "INSERT INTO location_images (location_id, image)
                        VALUES ('$location_id', '$imageName')");
                    }
                }
            }
        }

        header("Location: dashboard.php?msg=added");
        exit();

    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
