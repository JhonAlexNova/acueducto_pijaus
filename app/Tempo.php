<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tempo extends Model
{
    protected $table = 'tempo';

    protected $fillable = ['id_medidor','valor_factura','periodo','ano'];


}
