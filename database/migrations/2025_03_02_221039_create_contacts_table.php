<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); // Identificador único del contacto
            $table->string('name'); // Nombre del contacto
            $table->string('email')->unique(); // Correo electrónico único
            $table->string('phone')->nullable(); // Número de teléfono (opcional)
            $table->text('notes')->nullable(); // Notas adicionales (opcional)
            $table->unsignedBigInteger('user_id'); // Clave foránea para relacionar con el usuario
            $table->timestamps(); // Fechas de creación y actualización

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Relación con la tabla users
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts'); // Eliminar la tabla si existe
    }
};
