<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id(); // Identificador único del recordatorio
            $table->dateTime('reminder_time'); // Fecha y hora del recordatorio
            $table->boolean('sent')->default(false); // Indica si el recordatorio fue enviado
            $table->foreignId('event_id')->constrained()->onDelete('cascade'); // Relación con la tabla events
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('reminders'); // Eliminar la tabla si existe
    }
};
