<?php
include("../backend/db.php");

$result = mysqli_query($conn, "SELECT * FROM day_plans ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Plans</title>
    <style>
        body {
    font-family: Arial;
    background: #f4f6f9;
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

<h2>My Day Plans</h2>

<?php while ($plan = mysqli_fetch_assoc($result)) { ?>

<div class="card">

    <h3><?php echo $plan['plan_name']; ?></h3>
    <p>Date: <?php echo $plan['visit_date']; ?></p>

    <b>Locations:</b>
    <ul>
    <?php
    $pid = $plan['id'];

    $places = mysqli_query($conn, "
        SELECT l.name, l.district
        FROM plan_places pp
        JOIN location l ON pp.location_id = l.id
        WHERE pp.plan_id = $pid
    ");

    while ($p = mysqli_fetch_assoc($places)) {
        echo "<li>{$p['name']} ({$p['district']})</li>";
    }
    ?>
    </ul>

    <a class="btn btn-danger"
       href="delete_plan.php?id=<?php echo $plan['id']; ?>"
       onclick="return confirm('Delete this plan?')">
       Delete
    </a>

</div>

<?php } ?>

</div>
<a href="dashboard_view.php">
        <button class="btn btn-primary">⬅ Back</button>
    </a>
</body>
</html>