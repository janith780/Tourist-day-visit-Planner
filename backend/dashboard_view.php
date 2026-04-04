<?php if (isset($_GET['msg'])) { ?>
    <div style="background: lightgreen; padding: 10px; margin-bottom:10px;">
        <?php
        if($_GET['msg'] == 'added') echo "Location added successfully";
        if($_GET['msg'] == 'deleted') echo "Location deleted successfully!";
        if($_GET['msg'] == 'updated') echo "Location updated successfully!";
        ?>

    </div>
<?php } ?>

<h2>Welcome <?php echo $username; ?></h2>

<?php if ($role == 'admin') { ?>
    <h3>Admin Panel</h3>

    <!-- TABS -->
    <button onclick="showTab('add')">Add location</button>
    <button onclick="showTab('update')">Update location</button>
    <button onclick="showTab('delete')">Delete location</button>
<hr>

<?php
include("db.php");
$result = mysqli_query($conn, "SELECT * FROM location");
?>

  <!--add_location-->
<div id="add" style="display:none;">
    <h3>Add Location</h3>
    <form action="add_location.php" method="POST">
        Name: <input type="text" name="name"><br>
        Description: <input type="text" name="description"><br>
        District: <input type="text" name="district"><br>
        Category: <input type="text" name="category"><br>
        Open Time: <input type="time" name="open_time"><br>
        Close Time: <input type="time" name="close_time"><br>
        Ticket Price: <input type="number" name="ticket_price"><br>
        Latitude: <input type="text" name="latitude"><br>
        Longitude: <input type="text" name="longitude"><br>
        <button type="submit">Add Location</button>
    </form>
</div>

<!-- UPDATE LOCATION -->
<div id="update" style="display:none;">
    <h3>Update Location</h3>

    <table border="1" cellpadding="10">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>District</th>
            <th>Category</th>
            <th>Open Time</th>
            <th>Close Time</th>
            <th>Ticket Price</th>
            <th> Latitude</th>
            <th>Longitude</th>
            <th>Action</th>
        </tr>

       <?php
       $result = mysqli_query($conn, "SELECT * FROM location");
       while($row = mysqli_fetch_assoc($result)){?>
        <tr>
            <form action="update_location.php" method="POST">
                <td>
                    <input type="text" name="name" value="<?php echo $row['name']; ?>">required
                </td>
                <td>
                    <input type="text" name="description" value="<?php echo $row['description']; ?>">
                </td>
                <td>
                    <input type="text" name="district" value="<?php echo $row['district']; ?>">
                </td>
                <td>
                    <input type="text" name="category" value="<?php echo $row['category']; ?>">
                </td>
                <td>
                    <input type="time" name="open_time" value="<?php echo $row['open_time']; ?>">
                </td>
                <td>
                    <input type="time" name="close_time" value="<?php echo $row['close_time']; ?>">
                </td>
                <td>
                    <input type="number" name="ticket_price" value="<?php echo $row['ticket_price']; ?>">
                </td>
                <td>
                    <input type="text" name="latitude" value="<?php echo $row['latitude']; ?>">
                </td>
                <td>
                    <input type="text" name="longitude" value="<?php echo $row['longitude']; ?>">
                </td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Update</button>
                </td>
            </form>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- DELETE LOCATION -->
<div id="delete" style="display:none;">
    <h3>Delete Location</h3>

    <?php
    $result2 = mysqli_query($conn, "SELECT * FROM location");
    ?>

    <table border="1" cellpadding="10">
        <tr>
            <th>Name</th>
            <th>Action</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result2)) { ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td>
                <a href="delete_location.php?id=<?php echo $row['id']; ?>" 
                onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- JAVASCRIPT -->
<script>
function showTab(tab) {
    document.getElementById('add').style.display = 'none';
    document.getElementById('update').style.display = 'none';
    document.getElementById('delete').style.display = 'none';

    document.getElementById(tab).style.display = 'block';
}
</script>

<?php } else { ?>
    <p>User Dashboard</p>
<?php } ?>

<a href="logout.php">Logout</a>