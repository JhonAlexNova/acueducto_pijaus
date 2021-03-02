<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use DB;
use App\PagoCredito;
use App\Credito;
use App\Tempo;

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
	    		//$factura->save();
    		}
    		
    		
    	}
    }


    public function update_creditos(){
        set_time_limit(0);
        $facturas = DB::table('factura as f')
        ->join('facturacion as fn','fn.id_factura','f.id')
        ->select('f.valor','f.total_pagar','fn.id_cliente','f.created_at','fn.id_credito','f.anno')->select()->get();

        //creditos




        $count = 0;
        foreach ($facturas as $key => $value) {
            
            $valor_pagado = $value->valor;
            
            if($valor_pagado=='' && $value->estado==2){

                $tempo = new Tempo();
                $tempo->id_medidor = $value->id_medidor;
                $tempo->periodo = $value->periodo;
                $tempo->valor_factura = $value->total_pagar;
                $tempo->ano = $value->ano;
                //$tempo->save();

                $count = $count + 1;
            }
            
            $valor_factura = $value->total_pagar;
            $id_cliente = $value->id_cliente;
            $id_factura = $value->id_factura;

            if($valor_pagado!='' && $value->valor > $valor_factura){



                 
                $credito = DB::table('punto_agua as pt')
                ->join('medidor as m','m.id','pt.id_medidor')
                ->join('credito as c','c.id_punto_agua','=','pt.id')
                ->where('pt.id_medidor','=',$value->id_medidor)
                ->select('c.valor as valor_credito','pt.id','c.id as id_credito')->get()->last();



                //dump($value->id_medidor);
                    $temporal = Tempo::where('id_medidor', $value->id_medidor)
                    ->where('periodo','<=',$value->periodo)
                    ->where('ano','=',$value->ano)
                    ->where('estado','=',1)
                    ->select('*')->get();

                    if(count($temporal)>0){
                      //  dd($temporal);
                    }

                    $total = 0;
                    foreach ($temporal as $key => $temp) {
                        $total = $total + $temp->valor_factura;
                        
                    }

                    

                    if(count($temporal)>0){
                        $total_facturas = round($total+$value->total_pagar,2);
                        $total_pago = round($value->valor,2);

                        
                        if($total_pago==$total_facturas){

                          foreach ($temporal as $key => $temp) {//borrrar datos para que no los encuentre luego de cambiar mes siguiente
                                $db_temp = Tempo::find($temp->id);
                                $db_temp->estado = 2;
                                $db_temp->save();
                            }  
                        }else{
                           //verificar si hay abonos
                            if(!empty($credito)){
                                $abonos = DB::table('pagos_credito as pc')
                                ->where('pc.id_credito',$credito->id_credito)->select('*')->get()->last();

                                //dump($total_facturas.'|'.$total_pago);
                                if($total_pago>$total_facturas){
                                   // dd('aca');
                                    $cuota = $total_pago - $total_facturas;
                                    if($abonos){
                                        $saldo = $abonos->saldo - $cuota;
                                    }else{

                                        $saldo = $credito->valor_credito - $cuota;
                                        //dd($saldo);
                                    }
                                    //
                                    foreach ($temporal as $key => $temp) {//borrrar datos para que no los encuentre luego de cambiar mes siguiente
                                        $db_temp = Tempo::find($temp->id);
                                        $db_temp->estado = 2;
                                        $db_temp->save();
                                    } 
                                     $pago = new PagoCredito();// ['id_credito','valor','saldo','fecha'];
                                        $pago->id_credito = $credito->id_credito;
                                        $pago->valor = $cuota;
                                        $pago->saldo = $saldo;
                                        $pago->fecha = $value->fecha_pago;
                                        $pago->save();
                                        //dd('lsjl');
                                }
                            //dd($abonos);
                            }
                           
                        }
                        
                    }

                
                
                    

                  

               
               
            }
        }
        //dd($count);

        $creditos = Credito::where('estado',2)->select('*')->get();


        foreach ($creditos as $key => $cred) {
            $pagos = PagoCredito::where('id_credito',$cred->id)
            ->select('*')->get();
            //
            if(count($pagos)==0){
                $pago = new PagoCredito();// ['id_credito','valor','saldo','fecha'];
                $pago->id_credito = $cred->id;
                $pago->valor = $cred->valor;
                $pago->saldo = 0;
                $pago->fecha = $cred->updated_at;
                $pago->save();
            }
        }

        dd('success');
    }



}
