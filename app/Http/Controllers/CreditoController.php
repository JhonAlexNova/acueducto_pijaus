<?php

namespace App\Http\Controllers;

use App\Cliente;
use DB;
use App\Credito;
use Illuminate\Http\Request;
use App\Http\Requests\CreditoRequest; 
use App\PuntoAgua;
use PhpParser\Node\Expr\New_;
use Session;
use App\Facturacion;
use App\PagoCredito;

class CreditoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd('aca estpoy');
       
      //dd($creditos);


 
      if(!empty($_REQUEST['buscar'])){
          $creditos = DB::table('medidor as m')
          ->join('punto_agua as pt','pt.id_medidor','=','m.id')
          ->join('cliente as c','c.id','pt.id_cliente')
          ->where('m.id','LIKE','%'.$_REQUEST['buscar'].'%')
          ->select('m.id as id_medidor','c.nombre','c.primer_apellido','c.segundo_apellido','c.documento','pt.zona','c.telefono','pt.id as id_punto')->get();
          //dd($creditos);

          }else{
             $creditos = DB::table('medidor as m')
               ->join('punto_agua as pt','pt.id_medidor','m.id')  ///
              ->join('cliente as c','c.id','pt.id_cliente')
              ->select('m.id as id_medidor','c.nombre','c.primer_apellido','c.segundo_apellido','c.documento','pt.zona','c.telefono','pt.id as id_punto')->get();
          }


        return view('credito.index',compact("creditos"));
    }

    public function lista($id)
    {
        $punto = PuntoAgua::find($id);
        //dd($punto);

          $creditos = DB::table('punto_agua as pt')
        ->join('credito as c','c.id_punto_agua','=','pt.id')
        ->join('cliente as cl','cl.id','=','pt.id_cliente')
        ->where('pt.id_medidor','=',$punto->id_medidor)
        ->where('c.estado','=','1')
        ->select('*','c.id as id_credito')->get();

       // dd($creditos);

        $data = array();
        $saldo_credito = 0;
        foreach ($creditos as $key => $credito) {
          $data['credito'] = $credito;
          $data['valor'] = $credito->valor;
         // dd($credito->id_credito);

          $abonos = PagoCredito::where('id_credito',$credito->id_credito)->select('saldo')->get()->last();

          if($abonos){
            $data['saldo_credito'] = $abonos->saldo;
          }else{
             $data['saldo_credito'] = $credito->valor;
          }
        }

        

        //dd($data);
         return view('credito.detalles',compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function actualizar($id, $valor){
        $credito = Credito::find($id);
        $credito->valor_cuota = $valor;
        $credito->save();
        return redirect()->back();
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreditoRequest $request)
    {
       //dd($request->all());


        //verificar si tiene creditos

        $creditos = DB::table('credito')
        ->where('id_punto_agua','=',$request->id_punto)
        ->where('estado','=','1')
        ->select('*')->get();
        
        if(count($creditos)>0){
            $valor_anterior = $creditos[0]->valor_cuota;
            $nuevo_valor = $valor_anterior + $request->valor;
            //
            $credito = Credito::find($creditos[0]->id);
            $credito->valor_cuota = $nuevo_valor;
            $credito->valor = $nuevo_valor;
            $credito->save();
        }else{
               $valor_cuota = ($request->valor / $request->cuotas);
               $credito = New Credito();
               $credito->id_punto_agua = $request->id_punto;
               $credito->valor = $request->valor;
               $credito->cuota = $request->cuotas;
               $credito->estado = '1';
               $credito->descripcion = $request->descripcion;
               $credito->fecha_pago = $request->fecha;
               $credito->valor_cuota = $valor_cuota;
               $credito->save();
               //sacar id_credito
               $punto_agua = DB::table('punto_agua')
               ->where('id','=',$request->id_punto)
               ->select('*')->get();

               //verificar facturacion
               $id_medidor = $punto_agua[0]->id_medidor;


               $facturacion = DB::table('facturacion')
               ->where('id_medidor','=',$id_medidor)
               ->select('*')->get();

               $fac = Facturacion::find($facturacion[0]->id);
               $fac->id_credito = $credito->id;
               $fac->save();
        }
       
       // dd($valor_cuota);

          
           Session::flash('credito_crear','Credito creado con exito.');
           return redirect()->back();






    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Credito  $credito
     * @return \Illuminate\Http\Response
     */
    public function show($id_punto)
    {

       $table = DB::table('credito')
       ->where('id_punto_agua','=',$id_punto)
       ->select('*')->get();
       dd();

       $id_credito = $table[0]->id;

       $credito = Credito::find($id_credito);
       $credito->estado = 2;
       $credito->save();
       
       return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Credito  $credito
     * @return \Illuminate\Http\Response
     */
    public function edit(Credito $credito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Credito  $credito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      //dd('salkdj');

        $credito = Credito::find($id);

         $abonos = PagoCredito::where('id_credito',$id)->select('saldo')->get()->last();
          if(!empty($abonos)){
            $valor_actual  = $abonos->saldo;
          }else{
             $valor_actual = $credito->valor;
          }




         if($valor_actual >= $request->valor_abono){
          
          $saldo = $valor_actual - $request->valor_abono;
          //dd($saldo);
          $pago = new PagoCredito();
          $pago->id_credito = $id;
          $pago->valor = $request->valor_abono;
          $pago->saldo = $saldo;
          $pago->fecha = date('Y-m-d');
          $pago->save();
          Session::flash('mensaje','Abono realizado con exito.');
  
        }else{
          Session::flash('error','EL valor de la cuota no puede superar al valor de la deuda total.');
          return redirect()->back();
        }

        //dd('aca1');
        
        /*$credito->valor = $valor_actual - $request->valor_abono;
        $credito->valor_cuota = $valor_actual - $request->valor_abono;¨*/


        

        if($saldo==0){
            $credito->estado = 2;
        }

        $credito->save();
        return redirect()->back();  // no analizamos bien el algoritmo paso jajja POR QUE   el valor del formulario no puede superarra al credito jajajjaj y si paso
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Credito  $credito
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $facturacion = DB::table('facturacion')->where('id_credito','=',$id)->select('*')->get();

          
          foreach ($facturacion as $key => $value) {
            $id_f = $value->id;
            $fac = Facturacion::find($id_f);
            $fac->id_credito = null;
            $fac->save();
          }

          $credito = Credito::find($id);
          $credito->delete();
         return redirect()->back();
    }
}
