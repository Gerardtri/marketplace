<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre')->unique();
            $table->string('slug')->unique();
            $table->string('descripcion')->nullable();
            $table->decimal('valor',10,2);
            $table->string('imagen')->nullable();
            $table->enum('estado_producto', ['nuevo','poco uso','usado']);
            $table->boolean('estado')->default(true);
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->foreignId('ciudad_id')->constrained('ciudades');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
