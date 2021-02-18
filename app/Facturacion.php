<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturacion extends Model
{
    protected $table = 'facturacion';
    protected $fillable = ['id_cliente','id_factura','id_medidor','id_credito','id_acuerdo','id_precio','fecha_facturacion','fecha_limite'];//metro adicional

    public function clientes()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
    public function medidores()
    {
        return $this->belongsTo(Medidor::class, 'id_medidor');
    }

    public function facturas()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }

    public function creditos()
    {
        return $this->hasMany('App\Credito');
    }

    public function acuerdos()
    {
        return $this->hasMany('App\Acuerdo');
    }
}
