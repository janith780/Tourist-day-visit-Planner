    <?php
    include("../backend/db.php");
    include("../backend/weather_api.php");

    if (!isset($_GET['id'])) {
        echo "Invalid location";
        exit();
    }

    $id = $_GET['id'];

    $res = mysqli_query($conn, "SELECT * FROM location WHERE id=$id");
    $loc = mysqli_fetch_assoc($res);

    $district = $loc['district'];

// Fix Sri Lanka districts
$districtMap = [
    "Gampaha" => "Colombo",
    "Kalutara" => "Colombo",
    "Matara" => "Galle",
    "Nuwara Eliya" => "Kandy"
];

$apiCity = isset($districtMap[$district]) ? $districtMap[$district] : $district;

$weather = getWeather($apiCity);

$temp = "";
$desc = "";
$icon = "";

if ($weather && isset($weather['main'])) {
    $temp = $weather['main']['temp'];
    $desc = $weather['weather'][0]['description'];
    $icon = $weather['weather'][0]['icon'];
}
    ?>

    <!DOCTYPE html>
    <html>
    <head>
    <title>Location Details</title>

    <style>
    body{
    font-family:'Segoe UI', sans-serif;
    background: linear-gradient(to right, #e0f2fe, #f8fafc);
    margin:0;
    padding:0;
}

/* ===== DETAILS BLOCK ===== */
.details {
    margin-top: 20px;
}

/* DESCRIPTION */
.details .desc {
    font-size: 15px;
    color: #475569;
    margin-bottom: 15px;
    line-height: 1.6;
}

/* GRID LAYOUT */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
}

/* EACH BOX */
.info-item {
    background: #f8fafc;
    padding: 12px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    transition: 0.3s;
}

/* HOVER EFFECT */
.info-item:hover {
    transform: translateY(-3px);
    background: #e0f2fe;
}

/* TITLE */
.info-item span {
    display: block;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 4px;
}

/* VALUE */
.info-item p {
    font-size: 15px;
    font-weight: 600;
    color: #1e293b;
}

/* ===== NAVBAR (NEW) ===== */
.topbar{
    background:#1e293b;
    color:white;
    padding:15px 25px;
    font-size:18px;
    font-weight:bold;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* ===== MAIN CONTAINER ===== */
.container{
    max-width:1100px;
    margin:30px auto;
    background:white;
    border-radius:15px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    animation:fadeIn 0.6s ease;
}

/* ===== TITLE ===== */
.container h2{
    font-size:28px;
    margin-bottom:15px;
    color:#1e293b;
}

/* ===== IMAGE GALLERY ===== */
.gallery{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    margin-bottom:20px;
}

.gallery img{
    width:200px;
    height:140px;
    object-fit:cover;
    border-radius:10px;
    transition:0.3s;
    cursor:pointer;
}

/* IMAGE HOVER EFFECT */
.gallery img:hover{
    transform:scale(1.05);
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
}

/* ===== DETAILS TEXT ===== */
.details{
    margin-top:10px;
}

.details p{
    margin:8px 0;
    font-size:15px;
    color:#334155;
}

/* ===== BUTTON GROUP ===== */
.actions{
    margin-top:20px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

/* ===== BUTTON STYLE ===== */
button{
    padding:10px 16px;
    border:none;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

/* PRIMARY BUTTON */
.btn-primary{
    background:#3b82f6;
    color:white;
}

.btn-primary:hover{
    background:#2563eb;
    transform:translateY(-2px);
}

/* SECONDARY BUTTON */
.btn-secondary{
    background:#64748b;
    color:white;
}

.btn-secondary:hover{
    background:#475569;
}

/* BACK BUTTON */
.btn-back{
    background:#ef4444;
    color:white;
}

.btn-back:hover{
    background:#b91c1c;
}

/* ===== DISTANCE TEXT ===== */
#distance{
    margin-top:10px;
    font-weight:bold;
    color:#0f172a;
}

/* ===== ANIMATION ===== */
@keyframes fadeIn{
    from{opacity:0; transform:translateY(10px);}
    to{opacity:1; transform:translateY(0);}
}
    </style>
    </head>

    <body>

    <div class="container">

    <h2><?php echo $loc['name']; ?></h2>

    <div class="gallery">
    <?php
    $imgs = mysqli_query($conn, "SELECT * FROM location_images WHERE location_id=$id");
    while($img = mysqli_fetch_assoc($imgs)){
        echo "<img src='../images/".$img['image']."'>";
    }
    ?>
    </div>

    <div class="details">

    <p class="desc"><?php echo $loc['description']; ?></p>

    <div class="info-grid">

        <div class="info-item">
            <span>📍 District</span>
            <p><?php echo $loc['district']; ?></p>
        </div>

        <div class="info-item">
            <span>🏷 Category</span>
            <p><?php echo $loc['category']; ?></p>
        </div>

        <div class="info-item">
        <span>⏰ Opening Hours</span>
        <p>
        <?php 
        if ($loc['always_open'] == 1) {
            echo "🟢 Always Open";
        } else {
            echo $loc['open_time'] . " - " . $loc['close_time'];
        }
        ?>
        </p>
        </div>
        <div class="info-item">
            <span>🎟 Ticket Price</span>
            <p>
            <?php 
            if ($loc['free_entry'] == 1) {
                echo "🟢 Free Entry";
            } else {
                echo "LKR " . $loc['ticket_price'];
            }
            ?>
            </p>
        </div>

        <div class="info-item">
            <span>🌍 Coordinates</span>
            <p><?php echo $loc['latitude']; ?> , <?php echo $loc['longitude']; ?></p>
        </div>

        <div class="info-item">
        <span>🌦 Weather</span>
        <?php if ($temp != "") { ?>
            <p>
                <img src="https://openweathermap.org/img/wn/<?php echo $icon; ?>.png">
                <?php echo $temp; ?> °C <br>
                <?php echo $desc; ?>
            </p>
        <?php } else { ?>
            <p>Not available</p>
        <?php } ?>
        </div>

    </div>

</div>

<!-- ===== BUTTON GROUP (NEW) ===== -->
<div class="actions">

    <button class="btn-primary"
    onclick="getLocation(<?php echo $loc['latitude']; ?>,<?php echo $loc['longitude']; ?>)">
    📍 Show Distance
    </button>

    <a target="_blank"
    href="https://www.google.com/maps?q=<?php echo $loc['latitude']; ?>,<?php echo $loc['longitude']; ?>">
        <button class="btn-secondary">🗺 Navigate</button>
    </a>

    <a href="dashboard_view.php">
        <button class="btn-back">⬅ Back</button>
    </a>

</div>

<p id="distance"></p>

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