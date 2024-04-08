<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        "producto_id",
        "foto",
    ];

    protected $appends = ["url_foto", "url_file"];

    public function getUrlFotoAttribute()
    {
        return asset("imgs/productos/" . $this->foto);
    }
    
    public function getUrlFileAttribute()
    {
        return asset("imgs/productos/" . $this->foto);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
