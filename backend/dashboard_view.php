
<?php
include("db.php");

// Get all locations
$result = mysqli_query($conn, "SELECT * FROM location");
$result2 = mysqli_query($conn, "SELECT * FROM location");

// Include frontend (HTML with PHP code)
include("../frontend/dashboard_view.html");
?>