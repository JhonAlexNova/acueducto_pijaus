<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use DB;
use App\PagoCredito;

class AppController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('auth.login');
    }

    public function update(){
    	$sql = Factura::all();

    	foreach ($sql as $key => $value) {
    		$id = $value->id;
    		$updated_at = $value->updated_at;

    		if($value->estado==2){
    			$fecha_pago = substr($updated_at, 0,10);
	    		$factura = Factura::find($id);
	    		$factura->fecha_pago = $fecha_pago;
	    		$factura->updated_at = $updated_at;
	    		$factura->save();
    		}
    		
    		
    	}
    }


    public function update_creditos(){
        set_time_limit(0);
        $facturas = DB::table('factura as f')
        ->join('facturacion as fn','fn.id_factura','f.id')
        ->select('f.valor','f.total_pagar','fn.id_cliente','f.created_at')->select()->get();
        foreach ($facturas as $key => $value) {
            $valor_pagado = $value->valor;
            $valor_factura = $value->total_pagar;
            $id_cliente = $value->id_cliente;
            $id_factura = $value->id_factura;

            if($valor_pagado!='' && $valor_pagado > $valor_factura){
                 $cuota_pagada = $valor_pagado - $valor_factura;
                 $credito = DB::table('punto_agua as pt')
                 ->join('medidor as m','m.id','pt.id_medidor')
                ->join('credito as c','c.id_punto_agua','=','pt.id')
               ->where('pt.id_medidor','=',$value->id_medidor)
                ->select('c.valor as valor_credito','pt.id')->get()->last();
                if(!empty($credito)){
                    $credito->id_factura = $id_factura;
                    $credito->cuota_pagada = $cuota_pagada;
                    $credito->fecha_pago = $value->created_at;

                    $credito->valor_pagado = 'Factura mas credito = '.$valor_pagado.' Solo fac: '.$valor_factura;
                    $credito->periodo = $value->periodo;
                    dump($credito);
                }

               // $saldo = $credito->valor_credito - $cuota_pagada;
                
                //
                $pago = new PagoCredito();// ['id_credito','valor','saldo','fecha'];
                $pago->id_credito = $value->id_credito;
                $pago->valor = $cuota_pagada;
                

               
               
            }
        }
    }



}
