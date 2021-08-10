@extends('layouts.app')


@section('link')

<link href="{{ asset('./assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

@endsection



@section('content')

<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label col-lg-6">
			<span class="kt-portlet__head-icon">
				<i class="kt-font-brand flaticon2-line-chart"></i>
			</span>
			<div class="col-lg-3">
				<h3 class="kt-portlet__head-title">
					Reportes

				</h3>
			</div>
			<div class="col-lg-6">
				<select name="selectTipoReporte" id="selectTipoReporte" class="form-control">
					<option value="0">Seleccione un Tipo</option>
					<option value="1">Reporte Clientes</option>
					<option value="2">Reporte Ventas</option>
					<option value="3">Reporte Productos</option>
					<option value="4">Reporte Ventas por Vendedor</option>
				</select>
			</div>
			<div class="col-lg-6">
				<select name="selectAñoReporte" id="selectAñoReporte" class="form-control">
				
				</select>
			</div>

		</div>
		<div class="col-lg-6">

		</div>
	</div>
</div>

<div class="kt-portlet kt-portlet--mobile" id="divProductos" hidden>
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="kt-font-brand flaticon-layers"></i>
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
					<!-- 	@if (Auth::user()->id_perfilUsuario == 1)
					<button id="btnAgregar" class="btn btn-brand btn-elevate btn-icon-sm">
						<i class="la la-plus"></i>
						Nuevo Producto
					</button>
					@endif -->

				</div>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable responsive" id="kt_table_1">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Descripcion</th>
					<th>Precio</th>
					<th>Estado</th>
					<th>Fecha registrado</th>
				</tr>
			</thead>
		</table>
		<!--end: Datatable -->
	</div>
</div>
<div class="kt-portlet kt-portlet--mobile" id="divClientes" hidden>
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="kt-font-brand flaticon-user"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Clientes
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
					<div class="dropdown dropdown-inline">

					</div>
					&nbsp;
					<!-- 	@if (Auth::user()->id_perfilUsuario == 1)
					<button id="btnAgregar" class="btn btn-brand btn-elevate btn-icon-sm">
						<i class="la la-plus"></i>
						Nuevo Cliente
					</button>
					@endif -->

				</div>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="ktClientes">
			<thead>
				<tr>
					<th>Cliente</th>
					<th>Dirección</th>
					<th>Rut</th>
					<th>Teléfono</th>
					<th>Comuna</th>
					<th>Fecha Registrado</th>
					<th>Nombre Usuario</th>

				</tr>
			</thead>


		</table>
		<!--end: Datatable -->
	</div>
</div>
<div class="kt-portlet kt-portlet--mobile" id="divVentas" hidden>
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="kt-font-brand flaticon-piggy-bank"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Ventas
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
					<div class="dropdown dropdown-inline">

					</div>
					&nbsp;
					<!-- @if (Auth::user()->id_perfilUsuario == 1)
					<button id="btnAgregar" class="btn btn-brand btn-elevate btn-icon-sm">
						<i class="la la-plus"></i>
						Nuevo Producto
					</button>
					@endif -->

				</div>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable" id="tablaVentas">
			<thead>
				<tr>
					<th>Usuario</th>
					<th>Cupon Descuento</th>
					<th>Fecha Venta</th>
					<th>Total</th>
					<th>Estado</th>
				</tr>
			</thead>


		</table>
		<!--end: Datatable -->
	</div>
</div>
<div class="kt-portlet kt-portlet--mobile" id="divVentasProveedor" hidden>
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="kt-font-brand flaticon2-line-chart"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Ventas por Vendedor
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
					<div class="dropdown dropdown-inline">

					</div>
					&nbsp;
					<!-- @if (Auth::user()->id_perfilUsuario == 1)
					<button id="btnAgregar" class="btn btn-brand btn-elevate btn-icon-sm">
						<i class="la la-plus"></i>
						Nuevo Producto
					</button>
					@endif
 -->
				</div>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-3">
					<div class="form-group">
						<label for="">Selecciones un vendedor</label>
						<select name="selectProveedor" id="selectProveedor" class="form-control">
						</select>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="form-group">
						<label for="">Selecciones mes</label>
						<select name="selectMesProveedor" id="selectMesProveedor" class="form-control">
							<option value="0">Todo</option>
							<option value="01">Enero</option>
							<option value="02">Febrero</option>
							<option value="03">Marzo</option>
							<option value="04">Abril</option>
							<option value="05">Mayo</option>
							<option value="06">Junio</option>
							<option value="07">Julio</option>
							<option value="08">Agosto</option>
							<option value="09">Septiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>
							<option value="12">Diciembre</option>
						</select>
					</div>
				</div>

			</div>
		</div>
		<table class="table table-striped- table-bordered table-hover table-checkable" id="reporteVentasProveedor">
			<thead>
				<tr>
					<th>Usuario</th>
					<th>Cupon Descuento</th>
					<th>Fecha Venta</th>
					<th>Total</th>
					<th>Estado</th>
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
<script src="{{ asset('./assets/js/demo1/pages/crud/datatables/data-sources/reporte.js') }}" type="text/javascript"></script>

@endsection