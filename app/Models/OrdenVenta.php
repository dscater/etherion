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
        "user_id",
        "fecha_registro",
    ];

    protected $appends = ["fecha_registro_t", "url_comprobante", "tipo"];

    public function getFechaRegistroTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_registro));
    }

    public function getUrlComprobanteAttribute()
    {
        return asset("imgs/comprobantes/" . $this->comprobante);
    }

    public function getTipoAttribute()
    {
        $array_str =  explode(".", $this->comprobante);
        $ext  = $array_str[count($array_str) - 1];

        $imgs = ["jpg", "jpeg", "png", "gif", "webp"];

        if (in_array($ext, $imgs)) {
            return "img";
        }

        return "file";
    }

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
