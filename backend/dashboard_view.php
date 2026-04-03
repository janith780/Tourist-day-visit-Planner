<h2>Welcome <?php echo $username; ?></h2>

<?php if ($role == 'admin') { ?>
    <h3>Admin Panel</h3>

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

<?php } else { ?>
    <p>User Dashboard</p>
<?php } ?>

<a href="logout.php">Logout</a>