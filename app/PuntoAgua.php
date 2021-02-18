<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PuntoAgua extends Model
{
    protected $table = 'punto_agua';
    protected $fillable = ['id_cliente','id_medidor','zona'];

    public function clientes()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente','id');
    }

    public function medidores()
    {
        return $this->belongsTo(Medidor::class, 'id_medidor','id');
    }

}
