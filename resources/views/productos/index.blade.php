@extends('layouts.app')


@section('link')

<link href="{{ asset('./assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

@endsection



@section('content')

<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="kt-font-brand flaticon2-line-chart"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Productos
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
					<div class="dropdown dropdown-inline">

					</div>
					&nbsp;
					@if (Auth::user()->id_perfilUsuario == 1)
					<button id="btnAgregar" class="btn btn-brand btn-elevate btn-icon-sm">
						<i class="la la-plus"></i>
						Nuevo Producto
					</button>
					@endif

				</div>
			</div>
		</div>
	</div>

	<div class="kt-portlet__body">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Descripcion</th>
					<th>Precio</th>
					<th>Estado</th>
					<th>Oferta(%)</th>
					<th>Fecha registrado</th>
					<th>Acciones</th>
				</tr>
			</thead>
		</table>
		<!--end: Datatable -->
	</div>
</div>



@endsection


@section('scripts')
<style>
	.swal-wide {
		width: 850px !important;
	}
</style>
<script>
	var tipoUsuario = '<?php echo Auth::user()->id_perfilUsuario ?>';
</script>
<script src="{{ asset('./assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('./assets/js/demo1/pages/crud/datatables/data-sources/productos.js') }}" type="text/javascript"></script>

@endsection