<?php
include("db.php");

$sql = "SELCET * FROM locations";
$result = mysqli_query($conn, $sql);

$locations = [];

while($row = mysqli_fetch_assoc($result)){
    $locations[] = $row;
}

echo json_encode($locations);
?>