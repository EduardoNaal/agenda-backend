<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$lastId = DB::table('migrations')->max('id') ?? 0;
$newId = $lastId + 1;

DB::table('migrations')->insert([
    'id' => $newId,
    'migration' => '2025_03_03_204037_create_personal_access_tokens_table',
    'batch' => 3 // Usa un batch nuevo (3) para indicar que es posterior a las migraciones batch 1 y 2
]);

echo "Migración de Sanctum marcada como ejecutada. Nuevo ID: $newId\n";