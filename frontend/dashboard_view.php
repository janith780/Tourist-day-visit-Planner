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
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

<style>
/* ===== GLOBAL STYLES ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: url('../images/red.jpg') no-repeat center center fixed;
    background-size: cover;
    padding: 0;
    margin: 0;
}

form label {
    display: block;
    margin-top: 12px;
    margin-bottom: 5px;
    font-weight: 600;
    color: #1e293b;
    font-size: 14px;
    letter-spacing: 0.3px;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #1e293b;
    padding: 12px 20px;
    color: white;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 100;
}

.navbar .logo {
    font-size: 22px;
    font-weight: bold;
    letter-spacing: 1px;
}

.navbar .user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.navbar .user-info span {
    font-size: 16px;
}

.navbar .logout-btn {
    background: #ef4444;
    border: none;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    color: white;
    font-weight: bold;
    transition: background 0.3s;
}

.navbar .logout-btn:hover {
    background: #b91c1c;
}

h2 {
    text-align: center;
    margin: 20px 0;
    font-size: 28px;
    color: #ffffff;
}

.category-bar {
    display: flex;
    gap: 10px;
    margin: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.category-bar a {
    padding: 10px 18px;
    background: #e2e8f0;
    color: #1e293b;
    text-decoration: none;
    border-radius: 25px;
    font-weight: bold;
    transition: 0.3s;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
}

.category-bar a:hover {
    background: #3b82f6;
    color: white;
    transform: translateY(-3px);
}

.card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 0 20px;
}

.card {
    width: 240px;
    border-radius: 12px;
    background: white;
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}

.card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
}

.card h3 {
    margin: 10px;
    font-size: 18px;
}

.card h3 a {
    text-decoration: none;
    color: #1e293b;
    transition: 0.3s;
}

.card h3 a:hover {
    color: #3b82f6;
}

.card p {
    margin: 0 10px 10px 10px;
    color: #334155;
}

.admin-panel {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin: 0 auto;
    max-width: 1200px;
}

.add-card {
    background: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.add-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}

.add-card h3 {
    margin-bottom: 15px;
    color: #1e293b;
    text-align: center;
}

.add-card form input, .add-card form select, .add-card form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 15px;
}

.add-card form button {
    width: 100%;
    padding: 10px;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.add-card form button:hover {
    background: #2563eb;
}

.admin-table-container { 
    overflow-x: auto;
}
.admin-table input{
    width: 120px;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    margin: 0 auto; 
}

.admin-table th, .admin-table td {
    padding: 12px;
    text-align: center;
}

.admin-table th {
    background: #1e293b;
    color: white;
    font-weight: 600;
}

.admin-table tr:nth-child(even) {
    background: #f1f5f9;
}

.admin-table tr:hover {
    background: #e0f2fe;
    transform: scale(1.01);
    transition: 0.3s;
}

.admin-table button {
    padding: 6px 12px;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}

.admin-table button:hover {
    background: #2563eb;
}

.admin-table a {
    color: #ef4444;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}

.admin-table a:hover {
    color: #b91c1c;
}

.nav-tabs {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
}

.tab-btn {
    flex: 1;
    padding: 10px 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    background: #e2e8f0;
    transition: 0.3s;
}

.tab-btn.active {
    background: #3b82f6;
    color: white;
}

@media(max-width:768px){
    .card-container {
        flex-direction: column;
        align-items: center;
    }
    .nav-tabs {
        justify-content: flex-start;
    }
    .category-bar {
        gap: 5px;
        margin: 10px;
    }
}

.hero {
    height: 220px;
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                url('') center/cover;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-radius: 0 0 20px 20px;
}

.hero h1 {
    font-size: 32px;
}

.hero p {
    font-size: 16px;
    opacity: 0.9;
}

.plan-links {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin: 20px;
}

.plan-links a {
    background: #3b82f6;
    color: white;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    transition: 0.3s;
}

.plan-links a:hover {
    background: #2563eb;
    transform: translateY(-3px);
}

.category-bar {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin: 20px;
    flex-wrap: wrap;
}

.category-bar a {
    padding: 10px 18px;
    background: white;
    border-radius: 25px;
    text-decoration: none;
    color: #1e293b;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: 0.3s;
}

.category-bar a:hover {
    background: #3b82f6;
    color: white;
    transform: translateY(-3px);
}

.card-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
}

.card {
    border-radius: 15px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
}

.card-img img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: 0.5s;
}

.overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 15px;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    transform: translateY(100%);
    transition: 0.4s;
}

.card:hover .overlay {
    transform: translateY(0);
}

.card:hover img {
    transform: scale(1.1);
}

.overlay button {
    margin-top: 8px;
    padding: 6px 12px;
    background: #3b82f6;
    border: none;
    color: white;
    border-radius: 6px;
    cursor: pointer;
}

.alert {
    width: 100%;
    padding: 12px;
    text-align: center;
    background: #22c55e;
    color: white;
    font-weight: bold;
    position: sticky;
    top: 60px;
    z-index: 999;
    animation: fadeOut 4s forwards;
}

@keyframes fadeOut {
    0% {opacity: 1;}
    80% {opacity: 1;}
    100% {opacity: 0; display:none;}
}

.checkbox-group {
    margin-top: 10px;
    margin-bottom: 10px;
}

.checkbox-group label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #1e293b;
    cursor: pointer;
}

.checkbox-group input[type="checkbox"] {
    width: auto;   
    margin: 0;
    transform: scale(1.2);
}

@media (max-width:768px){
    .navbar{
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    .navbar .user-info{
        flex-direction: column;
        gap: 8px;
    }

    h2{
        font-size: 20px;
    }
      .card-img img{
        height: 180px;
    }
}
</style>
</head>
<body>

<div class="navbar">
    <div class="logo">Tourist Day Visit Planner</div>
    <div class="user-info">
        <span><?php echo $username; ?> | <?php echo $role; ?></span>
        <form action="../backend/logout.php" method="POST" style="display:inline;">
            <button class="logout-btn" type="submit">Logout</button>
        </form>
    </div>
</div>

<?php if (isset($_GET['msg'])) { ?>
    <div class="alert">
        <?php 
        if ($_GET['msg'] == 'updated') echo "✅ Updated successfully";
        elseif ($_GET['msg'] == 'added') echo "✅ Added successfully";
        elseif ($_GET['msg'] == 'deleted') echo "🗑 Deleted successfully";
        elseif ($_GET['msg'] == 'error') echo "❌ Something went wrong";
        elseif ($_GET['msg'] == 'invalid') echo "⚠ Invalid request";
        elseif ($_GET['msg'] == 'invalidData') echo "⚠ Invalid input values";
        elseif ($_GET['msg'] == 'AccessDenied') echo "⛔ Access Denied";
        ?>
    </div>
<?php } ?>

<h2>Welcome <?php echo $username; ?></h2>

<?php if ($role == 'admin') { ?>
<div class="admin-panel">
    <h3 style="text-align:center;">Admin Panel</h3>

    <div class="nav-tabs">
        <button class="tab-btn active" onclick="showTab('add', this)">Add</button>
        <button class="tab-btn" onclick="showTab('update', this)">Update</button>
        <button class="tab-btn" onclick="showTab('delete', this)">Delete</button>
    </div>

    <div id="add" class="add-card box">
        <h3>Add New Location</h3>
        <form action="../backend/add_location.php" method="POST" enctype="multipart/form-data">
            <label>Location Name</label>
            <input type="text" name="name" placeholder="Location Name" required>
            <label>Description</label>
            <textarea name="description" placeholder="Description" rows="3" required></textarea>
            <label>District</label>
            <input type="text" name="district" placeholder="District" required>
            <label>Category</label>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="Beach">Beach</option>
                <option value="Historical">Historical</option>
                <option value="Wildlife">Wildlife</option>
                <option value="Religious">Religious</option>
                <option value="Park">Park</option>
                <option value="Mountain">Mountain</option>
                <option value="Waterfall">Waterfall</option>
                <option value="Monument">Monument</option>
                <option value="Museum">Museum </option>
                <option value="Air Port">Air Port </option>
                <option value="City">City</option>
            </select>
            <label>Open Time</label>
            <input type="time" name="open_time" placeholder="Open Time" >
            <label>Close Time</label>
            <input type="time" name="close_time" placeholder="Close Time" >
            <div class="checkbox-group">
                <label>
                <input type="checkbox" name="always_open" value="1">
                Always Open (24 Hours)
                </label>
            </div>
            <label>Ticket Price</label>
            <input type="number" name="ticket_price" placeholder="Ticket Price" >
            <div class="checkbox-group">
            <label>
                <input type="checkbox" name="free_entry" value="1">
                Free Entry (No Ticket)
            </label>
            </div>
            <label>Latitude</label>
            <input type="text" name="latitude" placeholder="Latitude" required>
            <label>Longitude</label>
            <input type="text" name="longitude" placeholder="Longitude" required>
            <label>Main Image</label>
            <input type="file" name="image" required>
            <label>Gallery Pictures</label>
            <input type="file" name="images[]" multiple>
            <button type="submit">Add Location</button>
        </form>
    </div>

    <div id="update" class="box" style="display:none;">
        <h3 style="text-align:center;">Update Locations</h3>
        <div class="admin-table-container">
            <table class="admin-table">
                <tr>
                    <th>Name</th><th>Description</th><th>District</th><th>Category</th>
                    <th>Open</th><th>Close</th><th>Price</th><th>Free Entry</th><th>Lat</th><th>Lon</th><th>Action</th>
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
                        <td>
                        <input type="checkbox" name="free_entry" value="1"
                        <?php if($row['free_entry'] == 1) echo "checked"; ?>>
                        </td>
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
    </div>

    <div id="delete" class="box" style="display:none;">
        <h3 style="text-align:center;">Delete Locations</h3>
        <div class="admin-table-container">
            <table class="admin-table">
                <tr><th>Name</th><th>Action</th></tr>
                <?php while($row = mysqli_fetch_assoc($result2)) { ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><a href="../backend/delete_location.php?id=<?php echo $row['id']; ?>">Delete</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<script>
function showTab(tab,el){
    document.getElementById('add').style.display='none';
    document.getElementById('update').style.display='none';
    document.getElementById('delete').style.display='none';

    document.getElementById(tab).style.display='block';

    document.querySelectorAll('.tab-btn').forEach(btn=>btn.classList.remove('active'));
    el.classList.add('active');
}
</script>

<?php } else { ?>
<div class="hero">
    <h1>Explore Beautiful Places 🌍</h1>
    <p>Find the best destinations in Near Moratuwa</p>
    <div class="plan-links">
    <a href="../frontend/create_plan.php">➕ Create Plan</a>
    <a href="../frontend/view_plans.php">📋 View Plans</a>
</div>
</div>

>

<div class="category-bar">
    <a href="?category=Beach">🏖 Beach</a>
    <a href="?category=Historical">🏛 Historical</a>
    <a href="?category=Wildlife">🐘 Wildlife</a>
    <a href="?category=Religious">🛕 Religious</a>
    <a href="?category=Park">🌳 Park</a>
    <a href="?category=Mountain">⛰ Mountain</a>
    <a href="?category=Waterfall">💧 Waterfall</a>
    <a href="?category=Monument"> Monument</a>
    <a href="?category=Museum"> Museum </a>
    <a href="?category=Air Port"> Air Port </a>
    <a href="?">✨ All</a>
</div>

<?php
if (isset($_GET['category']) && $_GET['category'] != "") {
    $category = $_GET['category'];
    $result = mysqli_query($conn, "SELECT * FROM location WHERE category='$category'");
} else {
    $result = mysqli_query($conn, "SELECT * FROM location");
}
?>

<div class="card-container">

<?php while($row = mysqli_fetch_assoc($result)) { ?>
    <div class="card">
        <div class="card-img">
            <img src="../images/<?php echo $row['image']; ?>">
            <div class="overlay">
                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['district']; ?></p>
                <a href="../frontend/location_details.php?id=<?php echo $row['id']; ?>">
                    <button>View Details</button>
                </a>
            </div>
        </div>
    </div>
<?php } ?>

</div>

<?php } ?>

</body>
</html>