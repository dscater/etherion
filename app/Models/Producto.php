<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        "nombre",
        "gerente_regional_id",
        "encargado_producto_id",
        "fecha_pent",
        "fecha_peje",
        "descripcion",
        "lat",
        "lng",
        "categoria_id",
        "fecha_registro",
    ];

    protected $appends = ["fecha_registro_t"];
    public function getFechaRegistroTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_registro));
    }
}
