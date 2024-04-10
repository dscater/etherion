<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenVenta extends Model
{
    use HasFactory;

    protected $fillable = [
        "codigo",
        "nro",
        "configuracion_pago_id",
        "celular",
        "comprobante",
        "lat",
        "lng",
        "total_sc",
        "total",
        "estado",
        "fecha_registro",
    ];

    public function configuracion_pago()
    {
        return $this->belongsTo(ConfiguracionPago::class, 'configuracion_pago_id');
    }

    public function orden_detalles()
    {
        return $this->hasMany(OrdenDetalle::class, 'orden_venta_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getNuevoCodigo()
    {
        $ultimo = OrdenVenta::orderBy("id", "desc")->first();
        if ($ultimo) {
            $nuevo_nro = (int)$ultimo->nro + 1;
            return ["ORD." . $nuevo_nro, $nuevo_nro];
        }

        return ["ORD.1", 1];
    }
}
