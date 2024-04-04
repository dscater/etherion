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
        Schema::create('pago_afiliados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("orden_venta_id");
            $table->text("descripcion");
            $table->string("estado");
            $table->date("fecha_registro");
            $table->timestamps();

            $table->foreign("orden_venta_id")->on("orden_ventas")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_afiliados');
    }
};
