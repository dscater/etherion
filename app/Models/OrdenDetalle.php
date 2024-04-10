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
        "precio_total",
    ];


    public function orden_venta()
    {
        return $this->belongsTo(OrdenVenta::class, 'orden_venta_id');
    }
}
