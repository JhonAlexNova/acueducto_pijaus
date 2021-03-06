
@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="container-fluid">
		<form action="">
			<div class="row">
				<div class="col-md-3">
					  <a href="{{url('app')}}" class="btn btn-outline-info">Volver</a>
				</div>
				<div class="col-md-6" style="display: none">
					@include('filtro.index')
				</div>
				<div class="col-md-3" style="display: none">
					<button class="btn btn-primary btn-outline-primary btn-block">Buscar</button>
				</div>
			</div>
		</form>
		<div class="justify-content-center">
            <div class="card text-center">
                <div class="justify-content-center">
					<div class="tabla">
						<table class="table table-bordered table-striped table-condensed" id="myTable" style="width: 100%">
							<thead>
								<tr>
									<td>Nombre</td>
									<td>N° Documento</td>
									<td>Telefono</td>
									<td>Periodo</td>
									<td>Cod_medidor</td>
		                            <td>Nivel</td>
		                            <td>Predio</td>
									<td>Opciones</td>
								</tr>
							</thead>
							<tbody>
		                       @foreach($data as $key => $c)
		                       	@if(!empty($c))
		                       		<tr>
										<td> {{$c->nombre}}  {{$c->primer_apellido}}  {{$c->segundo_apellido}} </td>
										<td> {{$c->documento}} </td>
										<td> {{$c->telefono}} </td>
										<td> {{$c->periodo}} / {{$c->ano}} </td>
										<td> {{$c->id_medidor}} </td>
		                                <td> {{$c->tipo}} </td>
		                           		<td> {{ $c->zona}}</td>
										<td style="width: 5%"><a href="{{url('app/pago',$c->id_medidor)}}" class="btn btn-outline-primary">Ver/Pagar</a></td>
									</tr>
		                       	@endif
									
		                       @endforeach
							</tbody>
						</table>
					</div>
                </div>
            </div>
         </div>
	</div>
</div>



<script src="{{asset('js/controller/FacturaController.js')}}"></script>
@include('medicion.form')
@if(Session::has('success'))
    <?php
        echo "<script>
            window.onload = function(){
                toastr.success('".Session::get('success')."');
            }
        </script>";
    ?>
@endif

<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
       var table = $('#myTable').DataTable({
        	"lengthMenu": [[300], ["todos"]]
        });
        table.order( [ 4, 'asc' ] ).draw();
    });
</script>
@endsection
