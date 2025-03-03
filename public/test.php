<?php

// Mostrar todos los errores en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cargar el autoloader de Laravel
require __DIR__ . '/../vendor/autoload.php';

// Verificar si el autoloader se cargó
echo "Autoloader cargado.<br>";

// Inicializar la aplicación de Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
echo "Aplicación inicializada.<br>";

// Simular una solicitud HTTP
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$kernel->handle(Illuminate\Http\Request::capture());
echo "Kernel manejado.<br>";

// Usar la fachada DB
use Illuminate\Support\Facades\DB;

// Obtener el último ID existente en la tabla migrations
$lastId = DB::table('migrations')->max('id') ?? 0;
$newId = $lastId + 1;

// Insertar la fila en la tabla migrations
DB::table('migrations')->insert([
    'id' => $newId,
    'migration' => '2025_03_03_185240_create_sessions_table',
    'batch' => 2
]);

echo "Migración marcada como ejecutada. Nuevo ID: " . $newId;