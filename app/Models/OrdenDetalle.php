<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        "orden_venta_id",
        "producto_id",
        "cantidad",
        "precio",
        "comision_cat",
        "comision_tam",
        "precio_total",
    ];
}
