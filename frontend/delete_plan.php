<?php
include("../backend/db.php");

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM plan_places WHERE plan_id=$id");
mysqli_query($conn, "DELETE FROM day_plans WHERE id=$id");

header("Location: view_plans.php");
?>