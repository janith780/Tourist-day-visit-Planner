<?php
include("../backend/db.php");

if (!isset($_GET['id'])) {
    echo "Invalid location";
    exit();
}

$id = $_GET['id'];

$res = mysqli_query($conn, "SELECT * FROM location WHERE id=$id");
$loc = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>
<head>
<title>Location Details</title>

<style>
body{
    font-family:Segoe UI;
    background:#f1f5f9;
    padding:20px;
}

.container{
    background:white;
    padding:20px;
    border-radius:10px;
}

img{
    width:200px;
    margin:5px;
    border-radius:8px;
}

button{
    padding:10px;
    background:#3b82f6;
    color:white;
    border:none;
    border-radius:6px;
}
</style>
</head>

<body>

<div class="container">

<h2><?php echo $loc['name']; ?></h2>

<?php
$imgs = mysqli_query($conn, "SELECT * FROM location_images WHERE location_id=$id");
while($img = mysqli_fetch_assoc($imgs)){
    echo "<img src='../images/".$img['image']."'>";
}
?>

<p><?php echo $loc['description']; ?></p>
<p><b>District:</b> <?php echo $loc['district']; ?></p>
<p><b>Category:</b> <?php echo $loc['category']; ?></p>

<button onclick="getLocation(<?php echo $loc['latitude']; ?>,<?php echo $loc['longitude']; ?>)">
Show Distance
</button>

<p id="distance"></p>

<a target="_blank" href="https://www.google.com/maps?q=<?php echo $loc['latitude']; ?>,<?php echo $loc['longitude']; ?>">
<button>Navigate</button>
</a>

<br><br>
<a href="dashboard_view.php"><button>⬅ Back</button></a>

</div>

<script>
function getLocation(lat,lon){
navigator.geolocation.getCurrentPosition(function(pos){
let d=calc(pos.coords.latitude,pos.coords.longitude,lat,lon);
document.getElementById("distance").innerHTML=d.toFixed(2)+" km";
});
}

function calc(a,b,c,d){
let R=6371;
let x=(c-a)*Math.PI/180;
let y=(d-b)*Math.PI/180;
let z=Math.sin(x/2)**2+Math.cos(a*Math.PI/180)*Math.cos(c*Math.PI/180)*Math.sin(y/2)**2;
return R*(2*Math.atan2(Math.sqrt(z),Math.sqrt(1-z)));
}
</script>

</body>
</html>