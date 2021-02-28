<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoCredito extends Model
{
    protected $table = 'pagos_credito';
    protected $fillable = ['id_credito','valor','saldo','fecha'];
}
