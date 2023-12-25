// app.js
function getCurrentLocationWeather() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Add a hidden form to submit the current location
                const form = document.createElement('form');
                form.action = 'weather.php';
                form.method = 'GET';

                const cityInput = document.createElement('input');
                cityInput.type = 'hidden';
                cityInput.name = 'city';
                cityInput.value = 'current_location';
                form.appendChild(cityInput);

                const latInput = document.createElement('input');
                latInput.type = 'hidden';
                latInput.name = 'lat';
                latInput.value = latitude;
                form.appendChild(latInput);

                const lonInput = document.createElement('input');
                lonInput.type = 'hidden';
                lonInput.name = 'lon';
                lonInput.value = longitude;
                form.appendChild(lonInput);

                document.body.appendChild(form);
                form.submit();
            },
            function (error) {
                console.error(`Error getting location: ${error.message}`);
            }
        );
    } else {
        console.error('Geolocation is not supported by this browser.');
    }
}
