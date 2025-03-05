<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Identificador único del evento
            $table->string('title'); // Título del evento
            $table->text('description')->nullable(); // Descripción del evento (opcional)
            $table->dateTime('start_time'); // Fecha y hora de inicio
            $table->dateTime('end_time'); // Fecha y hora de finalización
            $table->foreignId('contact_id')->constrained()->onDelete('cascade'); // Relación con la tabla contacts
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('events'); // Eliminar la tabla si existe
    }
};
