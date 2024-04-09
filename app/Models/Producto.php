<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "descripcion",
        "categoria_id",
        "producto_tamano_id",
        "precio",
        "precio_total",
        "fecha_registro",
    ];

    protected $appends = ["fecha_registro_t"];

    public function getFechaRegistroTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_registro));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function producto_tamano()
    {
        return $this->belongsTo(ProductoTamano::class, 'producto_tamano_id');
    }

    public function foto_productos()
    {
        return $this->hasMany(FotoProducto::class, 'producto_id');
    }
}
