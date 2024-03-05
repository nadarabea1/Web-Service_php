<?php
require_once("./vendor/autoload.php");

$weatherApp = new Weather(__API_KEY, __WEATHER_URL, __CITIES_FILE);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['city'])) {
    $cityId = $_POST['city'];
    if (!empty($cityId)) {
        $weather = $weatherApp->getWeather($cityId);
        echo "<h1>Weather Report for " . $weather['name'] . "</h1>";
        echo "<p>Temperature: " . $weather['main']['temp_min'] . "°C - " . $weather['main']['temp_max'] . "°C</p>";
        echo "<p>Humidity: " . $weather['main']['humidity'] . "%</p>";
    } else {
        echo "<p>Please select a city.</p>";
    }
}

$cities = $weatherApp->getCities();
?>
<html>
<head>
    <title>Sunny Day Weather App</title>
</head>
<body>
    <form method="post">
        <select name="city">
            <option value="">Select a city</option>
            <?php foreach ($cities as $cityId => $cityName): ?>
                <option value="<?php echo $cityId; ?>"><?php echo $cityName; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Get Weather">
    </form>
</body>
</html>
