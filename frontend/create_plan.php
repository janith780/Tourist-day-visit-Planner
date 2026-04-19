<?php
//  (start session + get user)
session_start();
include("../backend/db.php");

$user_id = $_SESSION['user_id']; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $plan_name = $_POST['plan_name'];
    $visit_date = $_POST['visit_date'];
    $places = $_POST['places'];

 
    mysqli_query($conn, "INSERT INTO day_plans (user_id, plan_name, visit_date)
                         VALUES ('$user_id', '$plan_name', '$visit_date')");

    $plan_id = mysqli_insert_id($conn);

    foreach ($places as $place_id) {
        mysqli_query($conn, "INSERT INTO plan_places (plan_id, location_id)
                             VALUES ($plan_id, '$place_id')");
    }

    echo "<script>alert('Plan Saved');</script>";
}

$locations = mysqli_query($conn, "SELECT * FROM location");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Plan</title>
    <style>
        body {
    font-family: Arial;
    background:  #e0f2fe;
    margin: 0;
}

.container {
    width: 90%;
    margin: auto;
    padding: 20px;
}

h2 {
    text-align: center;
}

.card {
    background: white;
    padding: 15px;
    margin: 15px 0;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.nav {
    display: flex;
    justify-content: center;
    gap: 10px;
    padding: 15px;
    background: #333;
}

.nav a {
    color: white;
    text-decoration: none;
    padding: 10px;
}

.btn {
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    color: white;
    cursor: pointer;
    text-decoration: none;
}

.btn-danger { background: red; }
.btn-primary { background: blue; }
    </style>
</head>
<body>

<div class="nav">
    <a href="create_plan.php">Create Plan</a>
    <a href="view_plans.php">View Plans</a>
</div>

<div class="container">

<h2>Create Day Plan</h2>

<div class="card">
<form method="POST">

Plan Name:<br>
<input type="text" name="plan_name" required><br><br>

Date:<br>
<input type="date" name="visit_date" required><br><br>

<h3>Select Locations</h3>

<?php while ($row = mysqli_fetch_assoc($locations)) { ?>
    <input type="checkbox" name="places[]" value="<?php echo $row['id']; ?>">
    <?php echo $row['name']; ?> (<?php echo $row['district']; ?>)<br>
<?php } ?>

<br>
<button class="btn btn-primary">Save Plan</button>
<button class="btn btn-primary" onclick="window.location.href='../frontend/dashboard_view.php'">
    ⬅ Back
</button>
</form>
</div>

</div>

</body>
</html>