<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Asegúrate de incluir las rutas de tu API aquí.
    'allowed_methods' => ['*'], // Permite todos los métodos.
    'allowed_origins' => ['*'], // Permite todos los orígenes o agrega el origen específico, como 'http://localhost:3000'
    'allowed_headers' => ['*'], // Permite todos los encabezados.
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
