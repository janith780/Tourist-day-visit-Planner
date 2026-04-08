<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['name'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['name'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';

include("../backend/db.php");

// Admin data
if ($role == 'admin') {
    $result = mysqli_query($conn, "SELECT * FROM location");
    $result2 = mysqli_query($conn, "SELECT * FROM location");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <style>
        .card {
            border: 1px solid #ccc;
            padding: 10px;
            width: 200px;
            margin: 10px;
            display: inline-block;
            vertical-align: top;
        }

        .card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        button {
            margin: 5px;
        }
    </style>
</head>

<body>

<p>Logged in as: <?php echo $username; ?> | Role: <?php echo $role; ?></p>

<?php if (isset($_GET['msg'])) { ?>
    <div style="background: lightgreen; padding: 10px;">
        <?php
        if($_GET['msg'] == 'added') echo "Location added successfully";
        if($_GET['msg'] == 'deleted') echo "Location deleted successfully!";
        if($_GET['msg'] == 'updated') echo "Location updated successfully!";
        ?>
    </div>
<?php } ?>

<h2>Welcome <?php echo $username; ?></h2>

<?php if ($role == 'admin') { ?>

<!-- ================= ADMIN PANEL ================= -->

<h3>Admin Panel</h3>

<button onclick="showTab('add')">Add</button>
<button onclick="showTab('update')">Update</button>
<button onclick="showTab('delete')">Delete</button>

<hr>

<!-- ADD -->
<div id="add" style="display:none;">
    <form action="../backend/add_location.php" method="POST">
        Name: <input type="text" name="name"><br>
        Description: <input type="text" name="description"><br>
        District: <input type="text" name="district"><br>
        Category: <input type="text" name="category"><br>
        Open Time: <input type="time" name="open_time"><br>
        Close Time: <input type="time" name="close_time"><br>
        Ticket Price: <input type="number" name="ticket_price"><br>
        Latitude: <input type="text" name="latitude"><br>
        Longitude: <input type="text" name="longitude"><br>
        Image: <input type="text" name="image"><br>
        <button type="submit">Add</button>
    </form>
</div>

<!-- UPDATE -->
<div id="update" style="display:none;">
<table border="1">
<tr>
<th>Name</th><th>Description</th><th>District</th><th>Category</th>
<th>Open</th><th>Close</th><th>Price</th><th>Lat</th><th>Lon</th><th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<form action="../backend/update_location.php" method="POST">
<td><input name="name" value="<?php echo $row['name']; ?>"></td>
<td><input name="description" value="<?php echo $row['description']; ?>"></td>
<td><input name="district" value="<?php echo $row['district']; ?>"></td>
<td><input name="category" value="<?php echo $row['category']; ?>"></td>
<td><input type="time" name="open_time" value="<?php echo $row['open_time']; ?>"></td>
<td><input type="time" name="close_time" value="<?php echo $row['close_time']; ?>"></td>
<td><input name="ticket_price" value="<?php echo $row['ticket_price']; ?>"></td>
<td><input name="latitude" value="<?php echo $row['latitude']; ?>"></td>
<td><input name="longitude" value="<?php echo $row['longitude']; ?>"></td>
<td>
<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
<button type="submit">Update</button>
</td>
</form>
</tr>
<?php } ?>
</table>
</div>

<!-- DELETE -->
<div id="delete" style="display:none;">
<table border="1">
<tr><th>Name</th><th>Action</th></tr>

<?php while($row = mysqli_fetch_assoc($result2)) { ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td>
<a href="../backend/delete_location.php?id=<?php echo $row['id']; ?>">Delete</a>
</td>
</tr>
<?php } ?>

</table>
</div>

<script>
function showTab(tab) {
    document.getElementById('add').style.display = 'none';
    document.getElementById('update').style.display = 'none';
    document.getElementById('delete').style.display = 'none';
    document.getElementById(tab).style.display = 'block';
}
</script>

<?php } else { ?>

<!-- ================= USER DASHBOARD ================= -->

<h3>User Dashboard</h3>

<!-- CATEGORY FILTER -->
<form method="GET">
    <button name="category" value="Beach">Beach</button>
    <button name="category" value="Historical">Historical</button>
    <button name="category" value="Wildlife">Wildlife</button>
    <button name="category" value="Religious">Religious</button>
    <button type="submit">All</button>
</form>

<br>

<?php
// FILTER QUERY
if (isset($_GET['category']) && $_GET['category'] != "") {
    $category = $_GET['category'];
    $result = mysqli_query($conn, "SELECT * FROM location WHERE category='$category'");
} else {
    $result = mysqli_query($conn, "SELECT * FROM location");
}
?>

<!-- LOCATION CARDS -->
<div>
<?php while($row = mysqli_fetch_assoc($result)) { ?>
    <div class="card">
        <img src="../images/panadura beach.jpg<?php echo $row['image']; ?>">
        <h3>
            <a href="?category=<?php echo isset($_GET['category']) ? $_GET['category'] : ''; ?>&location=<?php echo $row['id']; ?>">
                <?php echo $row['name']; ?>
            </a>
        </h3>
        <p><?php echo $row['district']; ?></p>
    </div>
<?php } ?>
</div>

<?php
// LOCATION DETAILS
if (isset($_GET['location'])) {
    $id = $_GET['location'];
    $res = mysqli_query($conn, "SELECT * FROM location WHERE id=$id");
    $loc = mysqli_fetch_assoc($res);
?>

<hr>

<h3><?php echo $loc['name']; ?></h3>
<img src="../images/panadura beach.jpg<?php echo $loc['image']; ?>" width="300">
<p><?php echo $loc['description']; ?></p>
<p>District: <?php echo $loc['district']; ?></p>
<p>Category: <?php echo $loc['category']; ?></p>

<button onclick="getLocation(<?php echo $loc['latitude']; ?>, <?php echo $loc['longitude']; ?>)">Show Distance</button>
<p id="distance"></p>

<a target="_blank" href="https://www.google.com/maps?q=<?php echo $loc['latitude']; ?>,<?php echo $loc['longitude']; ?>">
    <button>Navigate</button>
</a>

<script>
function getLocation(lat, lon) {
    navigator.geolocation.getCurrentPosition(function(pos){
        let d = calc(pos.coords.latitude, pos.coords.longitude, lat, lon);
        document.getElementById("distance").innerHTML = d.toFixed(2) + " km";
    });
}

function calc(a,b,c,d){
    let R=6371;
    let x=(c-a)*Math.PI/180;
    let y=(d-b)*Math.PI/180;
    let z=Math.sin(x/2)**2 + Math.cos(a*Math.PI/180)*Math.cos(c*Math.PI/180)*Math.sin(y/2)**2;
    return R * (2*Math.atan2(Math.sqrt(z),Math.sqrt(1-z)));
}
</script>

<?php } ?>

<?php } ?>

<br><br>
<a href="logout.php">Logout</a>

</body>
</html>