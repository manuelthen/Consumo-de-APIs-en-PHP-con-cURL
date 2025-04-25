<?php
$apiKey = "8a831a6b65affb6e946a46b85096039d";  // Reemplazar con la clave correcta
$ciudad = isset($_GET["ciudad"]) ? urlencode($_GET["ciudad"]) : "Santiago";
$url = "https://api.openweathermap.org/data/2.5/weather?q=$ciudad&appid=$apiKey&units=metric&lang=es";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$respuesta = curl_exec($ch);

// Verificar si hubo un error en cURL
if (curl_errno($ch)) {
    echo 'Error en cURL: ' . curl_error($ch);
    exit;
}

curl_close($ch);

// Verificar si la respuesta está vacía
if (empty($respuesta)) {
    echo 'No se recibió respuesta de la API.';
    exit;
}

// Decodificar la respuesta JSON
$datos = json_decode($respuesta, true);

// Verificar si la respuesta es válida
if ($datos === null) {
    echo "Error: No se pudo decodificar la respuesta de la API.";
    exit;
}

// Verificar si la API respondió con un código exitoso (200)
if ($datos["cod"] != 200) {
    echo "Error en la API. Código de error: " . $datos["cod"];
    echo "<pre>";
    print_r($datos);
    echo "</pre>";
    exit;
}

// Si todo es correcto, mostrar los datos del clima
echo "<h2>Clima en " . $datos["name"] . "</h2>";
echo "<p><strong>Descripción:</strong> " . $datos["weather"][0]["description"] . "</p>";
echo "<p><strong>Temperatura:</strong> " . $datos["main"]["temp"] . "°C</p>";
echo '<br><button onclick="window.location.href=\'index.html\'">Volver al inicio</button>';
?>