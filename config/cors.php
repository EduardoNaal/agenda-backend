<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar las opciones de CORS para tu aplicación.
    | Esto determina qué dominios pueden acceder a tu API y qué métodos y cabeceras
    | están permitidos.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Rutas a las que se aplicará CORS
    |--------------------------------------------------------------------------
    |
    | Aquí defines las rutas de tu aplicación a las que se aplicará CORS.
    | Puedes usar patrones como 'api/*' para aplicar CORS a todas las rutas bajo 'api/'.
    |
    */
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    /*
    |--------------------------------------------------------------------------
    | Métodos HTTP permitidos
    |--------------------------------------------------------------------------
    |
    | Define los métodos HTTP que están permitidos en las solicitudes CORS.
    | Usa ['*'] para permitir todos los métodos.
    |
    */
    'allowed_methods' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Dominios permitidos
    |--------------------------------------------------------------------------
    |
    | Define los dominios que tienen permitido acceder a tu API.
    | Usa ['*'] para permitir todos los dominios, o especifica dominios concretos.
    | Ejemplo: ['http://localhost:3000', 'https://tudominio.com']
    |
    */
    'allowed_origins' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Patrones de dominios permitidos
    |--------------------------------------------------------------------------
    |
    | Define patrones de expresiones regulares para permitir dominios dinámicos.
    | Por ejemplo, puedes permitir todos los subdominios de un dominio específico.
    |
    */
    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | Cabeceras permitidas
    |--------------------------------------------------------------------------
    |
    | Define las cabeceras HTTP que están permitidas en las solicitudes CORS.
    | Usa ['*'] para permitir todas las cabeceras.
    |
    */
    'allowed_headers' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Cabeceras expuestas
    |--------------------------------------------------------------------------
    |
    | Define las cabeceras HTTP que se expondrán en la respuesta CORS.
    | Esto es útil si necesitas que el frontend acceda a ciertas cabeceras.
    |
    */
    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Tiempo de caché para las opciones CORS
    |--------------------------------------------------------------------------
    |
    | Define el tiempo (en segundos) que el navegador debe almacenar en caché
    | la configuración de CORS. Un valor de 0 desactiva la caché.
    |
    */
    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Soporte para credenciales
    |--------------------------------------------------------------------------
    |
    | Define si las solicitudes CORS pueden incluir credenciales (cookies,
    | autenticación HTTP, etc.). Cambia a `true` si necesitas soportar credenciales.
    |
    */
    'supports_credentials' => false,
];