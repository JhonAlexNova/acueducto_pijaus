<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Session;
use App\Nivel;
use App\Medidor;
use App\Cliente;
use App\PuntoAgua;
use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
use App\Http\Requests\MedidorRequest;

class PuntoAguaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function store(ClienteRequest $request)
    {
        $medidor = new MedidorController();
        $id_medidor = $medidor->store($request);
        $cliente = new ClienteController();
        $cliente = $cliente->store($request);
        $id_cliente = $cliente{0};
        $direccion = $cliente[1];
        if ($medidor && $cliente ) {
           $punto = new PuntoAgua();
           $punto->id_cliente = $id_cliente;
           $punto->id_medidor = $id_medidor;
           $punto->estado = '1';
           $punto->zona = $direccion;
           $punto->save();
           Session::flash('success','Cliente creado con exito.');
           return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Punto_Agua  $punto_Agua
     * @return \Illuminate\Http\Response
     */
    public function show(PuntoAgua $puntoAgua)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Punto_Agua  $punto_Agua
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $cliente_ver = Cliente::findOrfail($id);
        $id_cliente = $cliente_ver->id;
        $id_nivel = $cliente_ver->id_nivel;
        //  dd($cliente_ver);
        $nivel = DB::table('nivel as n')
        ->where('n.id','=',$id_nivel)
        ->select('n.tipo')->get();

        $puntos = DB::table('punto_agua as pt')
        ->join('medidor as md','md.id','=','pt.id_medidor')
        ->where('pt.id_cliente','=',$id_cliente)
        ->where('pt.estado','=','1')
        ->select('pt.*','md.*')->get();

        
     $medidores_disponibles  = DB::table('medidor as m')
        ->where('m.estado','2')->select('*')->get();
      // dd($puntos,$nivel)
        return view('puntos.index', compact('cliente_ver','puntos','medidores_disponibles','nivel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Punto_Agua  $punto_Agua
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $puntoAgua)
    {
        
        if($request->estado==1){

            $medidor = new Medidor();
            $medidor->marca = $request->marca;
            $medidor->serial = $request->serial;
            $medidor->lectura_inicial = $request->lectura_inicial;
            $medidor->estado = '1';

            $medidor->save();

            $id_medidor = $medidor->id;


            $punto = new PuntoAgua();
            $punto->id_cliente = $request->id_cliente;
            $punto->id_medidor = $id_medidor;
            $punto->zona = strtoupper($request->zona);
            $punto->estado = '1';
            $punto->save();


            Session::flash('success','Medidor creado y asignado correctamente.');
        }else if($request->estado==2){
            $medidor = Medidor::find($request->id_medidor);
            $medidor->estado = '1';
            $medidor->save();
            //


            $punto = new PuntoAgua();
            $punto->id_medidor = $request->id_medidor;
            $punto->id_cliente = $request->id_cliente;
            $punto->zona = strtoupper($request->zona_x);
            $punto->estado = '1';
            $punto->save();


        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Punto_Agua  $punto_Agua
     * @return \Illuminate\Http\Response
     */
    public function destroy(PuntoAgua $punto_Agua)
    {
        //
    }
}
