@extends('layouts.admin')

@section('content')
<script>
    var id;
    var valor;
    function pagar(id){
        var action = '{{ url("app/credito") }}/'+id;
        $('#pago-credito').attr('action',action);
        $('input[name=id_credito]').val(id);
        $('#form-create').modal('show');
    }


    function editar(id, valor){
        this.id = id;
        this.valor = valor;
        $('input[name=valor]').val(valor);
         $('input[name=id]').val(id);
        $('#editar-credito').modal('show');
    }

    function post_edit(){
        url = "{{url('/app/editar/credito')}}/"+this.id+"/"+$('input[name=valor]').val();
        location.href = url;
    }

    function eliminar(id){
        url = "{{url('/app/eliminar/credito')}}/"+id;
        location.href = url; 
    }
</script>
<div class="row">
	<div class="container-fluid">

            <div class="row">
                <div class="col-md-2">
                    <a href="{{ url('app/credito') }}" class="btn btn-success btn-block btn-outline-dark">Volver</a>
                </div>
                <div class="col-md-10"></div>
            </div>



	<div class="row justify-content-center">
		<div class="col-12 col-md-12">
			<div class="tabla">
        @if(empty($data))
          <div class="card" style="padding: 50px; text-align: center;">
            <h2>Este medidor no tiene ningun credito asociado..</h2>
          </div>

        @else
          <table class="table table-bordered table-striped" id="myTable">
                    <thead>

                      <tr>
                        <td>#</td>
                        <td>Nombre</td>
                        <td>Primer Apellido</td>
                        <td>Segundo Apellido</td>
                        <td>Documento</td>
                        <td>Valor Credito</td>
                        <td>Saldo</td>
                        <td>No de Cuotas</td>
                        <td>Fecha de pago</td>
                        <td>Estado del Credito</td>
                        <td colspan="3">Opciones</td>

                      </tr>
                    </thead>
                    <tbody>
                      <tr>

                        <td>{{ $data['credito']->id  }}</td>
                        <td>{{$data['credito']->nombre}}</td>
                        <td>{{$data['credito']->primer_apellido}}</td>
                        <td>{{$data['credito']->segundo_apellido}}</td>
                        <td>{{$data['credito']->documento}}</td>
                        <td>{{$data['credito']->valor}}</td>
                        <td> {{ $data['saldo_credito'] }} </td>
                        <td>{{$data['credito']->cuota}}</td>

                        <td>{{$data['credito']->fecha_pago}}</td>
                        @if ($data['credito']->estado == 1)
                        <td>Activo</td>
                        @else
                        <td>Cancelado</td>
                        @endif
                        <td>
                        <a href="#" class="btn btn-outline-success" onclick="pagar('{{$data['credito']->id_credito}}')">ABONO</a>
                        </td>
                        <td>
                        <a href="#" class="btn btn-outline-primary" onclick="editar('{{$data['credito']->id_credito}}','{{$data['credito']->valor_cuota}}')">Editar</a>
                        </td>
                        <td>
                        <a href="#" class="btn btn-outline-danger" onclick="eliminar('{{$data['credito']->id_credito}}')">Eliminar</a>
                        </td>


                      </tr>



                    </tbody>
                          </table>

        @endif
				


	    </div>
    </div>
</div>


<form action="{{route('credito.update',0)}}" autocomplete="off" method="post" id="pago-credito">
  {{csrf_field()}}
  {{method_field('put')}}
  <div class="modal fade" id="form-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Abonar a la deuda</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <span>Valor</span>
                <input type="hidden" class="form-control" required="on" name="id_credito">
                  <input type="number" class="form-control" required="on" name="valor_abono" placeholder="Valor a abonar">
                </div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
          <button type="submit  " class="btn btn-primary">ABONAR DINERO</button>
        </div>
      </div>
    </div>
  </div>
</form>


<!--editar -->
<div class="modal fade" id="editar-credito" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Eliminar lectura</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
       <div class="form-group">
           <span>Valor</span>
           <input type="text" name="valor" class="form-control">
           <input type="hidden" name="id">
       </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" onclick="post_edit()">ACTUALIZAR</button>
    </div>
  </div>
</div>
</div>


<!---- --- >





@if(Session::has('mensaje'))
    <?php
        echo "<script>
            window.onload = function(){
                toastr.success('".Session::get('mensaje')."');
            }
        </script>";
    ?>
@endif

@if(Session::has('error'))
    <?php
        echo "<script>
            window.onload = function(){
                toastr.error('".Session::get('error')."');
            }
        </script>";
    ?>
@endif


@endsection
