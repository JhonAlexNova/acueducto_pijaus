<?php

namespace App\Http\Controllers\Api_v2;

use App\Http\Controllers\Controller;
use App\Factura;
use Illuminate\Http\Request;
use App\Http\Requests\FacturaRequest;
use Session;
use DB;
use App\Cliente;
use App\Precio;
use PDF;
use App\Nivel;
use App\Medidor;
use App\Facturacion;
use App\PuntoAgua;




class LecturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //periodo 03
    {
         $puntos = PuntoAgua::with(['clientes','medidores'])->where('estado',1)->get();


            $dato = array();
            $lecturas = array();
            foreach ($puntos as $key => $punto) {
        
             //ultima medicion
            $facturacion = Facturacion::with(['clientes','facturas'])->where('id_medidor',$punto->id_medidor)->where('id_cliente',$punto->id_cliente)->get();
            if(!empty($facturacion)){//ultima factura
                $ultima_facturacion =  $facturacion[count($facturacion) - 1];
            }

             $nivel = DB::table('cliente as c')
            ->join('nivel as n','n.id','=','c.id_nivel')
            ->where('c.id','=',$punto->id_cliente)
            ->select('n.tipo','n.porcentaje','id_nivel')->get();

             $dato['user'] = $ultima_facturacion->clientes;
             $dato['factura'] = $ultima_facturacion->facturas;
             $dato['medidor'] = $ultima_facturacion->medidores;

            //$facturacion_anterior =Facturacion::with(['clientes','facturas'])->where('id_medidor',$punto->id_medidor)->where('id_cliente',$punto->id_cliente)->get();
            $index = count($facturacion) - 2;
            //dd();
            if(!empty($facturacion[$index]->facturas->lectura)){//el medidor tiene mas de un regitro en la tabla facturacion
              $dato['factura']['lectura_anterior'] = $facturacion[$index]->facturas->lectura;
            }else{
                //
                if(count($facturacion)==1){
                   $lectura_medidor = Medidor::where('id','=',$id_medidor)->select('*')->get()->last();
                    $dato['factura']['lectura_anterior'] = $lectura_medidor->lectura_inicial;
                }
            }

           
            $precio = Precio::get()->last();

            $dato['precio_metro'] = $precio->precio_metro;
            $dato['cargo_fijo'] = $precio->cargo_fijo;
            
            
            //consumo
            if(empty($ultima_facturacion->facturas->consumo)){
                $dato['factura']->consumo =0;
            }

            //totalpagar
            if(empty($ultima_facturacion->facturas->total_pagar)){
                $dato['total_pagar']=0;
            }else{
                $dato['total_pagar'] = $ultima_facturacion->facturas->total_pagar;
            }

            if(empty($facturacion)){
                if( empty($facturacion_temporal)){//medidor es nuevo
                    //medidor nuevo sin facturaciones anteriores
                    $lectura_medidor = Medidor::where('id','=',$id_medidor)->select('*')->get()->last();
                    $dato['lectura'] = $lectura_medidor->lectura_inicial;
                    
                }else{//medidor es usado pero con nuevo cliente
                    $lectura_medidor = DB::table('facturacion as fn')
                     ->join('factura as f','f.id','=','fn.id_factura')
                     ->where('fn.id_medidor','=',$id_medidor)
                     ->select('*')->get()->last();
                     $dato['lectura'] = $lectura_medidor->lectura;
                }
            }else{//este tiene una facturacion con el cliente activo
              //  $dato['lectura'] = $facturacion->lectura;
                

            }



            array_push($lecturas, $dato);

            //dd($lecturas);


            }

           return $lecturas;

       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(empty($_REQUEST['consulta'])){
             return view('medicion.create');
        }else{
            $lecturas = $this->index();
            dd($lecturas);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\acuerdo  $acuerdo
     * @return \Illuminate\Http\Response
     */
    public function show(acuerdo $acuerdo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\acuerdo  $acuerdo
     * @return \Illuminate\Http\Response
     */
    public function edit(acuerdo $acuerdo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\acuerdo  $acuerdo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, acuerdo $acuerdo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\acuerdo  $acuerdo
     * @return \Illuminate\Http\Response
     */
    public function destroy(acuerdo $acuerdo)
    {
        //
    }
}
