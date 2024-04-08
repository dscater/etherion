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
        "fecha_registro",
    ];

    protected $appends = ["fecha_registro_t", "precio_total"];

    public function getPrecioTotalAttribute()
    {
        $p_categoria = $this->categoria->p_comision;
        $p_tamano = $this->producto_tamano->p_comision;

        $p_total = (float)$p_categoria + (float)$p_tamano;

        $p_total = 1 + ($p_total / 100);

        return number_format($this->precio * $p_total, 2, ".", "");
    }

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
