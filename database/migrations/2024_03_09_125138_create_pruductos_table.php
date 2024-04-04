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
            $table->unsignedBigInteger("user_id")->nullable();
            $table->text("descripcion");
            $table->unsignedBigInteger("categoria_id");
            $table->unsignedBigInteger("producto_tamano_id");
            $table->decimal("precio", 24, 2);
            $table->date("fecha_registro");
            $table->timestamps();

            $table->foreign("categoria_id")->on("categorias")->references("id");
            $table->foreign("producto_tamano_id")->on("producto_tamanos")->references("id");
            $table->foreign("user_id")->on("users")->references("id");
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
