<?php
function getWeather($city)
{
    $apiKey = "325ca8a600fec538401e01cfd1e792b1"; //API KEY

    $url = "https://api.openweathermap.org/data/2.5/weather?q=" 
        . urlencode($city) 
        . "&appid=" . $apiKey . "&units=metric";

    $response = @file_get_contents($url);

    if ($response === FALSE) {
        return null;
    }

    return json_decode($response, true);
}
?>