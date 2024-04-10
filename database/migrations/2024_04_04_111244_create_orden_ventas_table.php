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
        Schema::create('orden_ventas', function (Blueprint $table) {
            $table->id();
            $table->string("codigo", 255)->unique();
            $table->bigInteger("nro");
            $table->unsignedBigInteger("configuracion_pago_id");
            $table->string("celular");
            $table->string("comprobante", 255);
            $table->string("lat", 255);
            $table->string("lng", 255);
            $table->decimal("total_sc", 24, 2);
            $table->decimal("total", 24, 2);
            $table->string("estado", 155);
            $table->date("fecha_registro");
            $table->timestamps();

            $table->foreign("configuracion_pago_id")->on("configuracion_pagos")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_ventas');
    }
};
