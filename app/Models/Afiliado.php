<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "banco",
        "nro_cuenta",
        "acepto_contrato",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
