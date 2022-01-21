<?php

require 'paypal/autoload.php';

define("URL_SITIO", "http://localhost:3000"); // Crear una constante para utilizar el dominio general del sitio, por ejemplo 'http://localhost/gdlwebcamp'

$apiContext = new \PayPal\Rest\ApiContext(
  new \PayPal\Auth\OAuthTokenCredential(
    'AXmT2Z5QxGbysjy-FAzdjj7pqKMxK9w8zwANXZIw7MnZ1-0O-R8zw_aodf2c8sGLUoUbp3iudt0aaCwa', // ClienteID
    'EEccvpAKdZLFDhnFKIq6Vyhh8OJ0BhirpN7Rv5cOMnZ3Ob0q4bnnkQGbkbmJshRKZcC6p1iT7bEytLYY' // Secret
  )
);
