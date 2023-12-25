<?php
if (isset($_GET['city'])) {
    // Input validation
    $city = urlencode(htmlspecialchars($_GET['city']));

    $apiKey = 'API KEYS';

    // Check if the request is for the current location
    if ($city === 'current_location') {
        // Get coordinates using geolocation
        $lat = $_GET['lat'];
        $lon = $_GET['lon'];

        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&units=metric&lang=en&appid={$apiKey}";
    } else {
        // Request weather data for the provided city
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&units=metric&lang=en&appid={$apiKey}";
    }

    // Use a more robust method to fetch content, like cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $weatherData = json_decode(curl_exec($ch), true);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 && $weatherData && isset($weatherData['main'])) {
        $tempCelsius = round($weatherData['main']['temp'], 2);
        $description = $weatherData['weather'][0]['description'];
        $humidity = $weatherData['main']['humidity'];
        $windSpeed = $weatherData['wind']['speed'];

        echo '<div class="container mt-5">';
        echo "<h2>Weather in ";
        echo ($city === 'current_location') ? "Current Location" : $_GET['city'];
        echo ":</h2>";
        echo "<p>Temperature: {$tempCelsius} &#8451;</p>";
        echo "<p>Description: {$description}</p>";
        echo "<p>Humidity: {$humidity}%</p>";
        echo "<p>Wind Speed: {$windSpeed} m/s</p>";
        echo '<a href="index.html" class="btn btn-primary mt-3">Back to Home</a>';
        echo '</div>';
    } else {
        // Log the error and display a user-friendly message
        error_log("Weather API request failed: HTTP Code $httpCode");
        echo '<div class="container mt-5">';
        echo "<p class='text-danger'>Error fetching weather data. Please try again.</p>";
        echo '<a href="index.html" class="btn btn-primary mt-3">Back to Home</a>';
        echo '</div>';
    }
}
?>
