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
				Usuarios
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
						Nuevo Usuario
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
					<th>Telefono</th>
					<th>Username</th>
					<th>Dirección</th>
					<th>Comuna</th>
					<th>Región</th>
					<th>Fecha Registro</th>

					<th>Codigo Referencia</th>

					<th>Perfil Usuario</th>
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

	$('li#menuUsuario').removeClass('kt-menu__item kt-menu__item--submenu kt-menu__item--rel');
	$('li#menuUsuario').addClass('kt-menu__item kt-menu__item--submenu kt-menu__item--rel');
	$('li#menuUsuario').addClass('kt-menu__item kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open kt-menu__item--here  kt-menu__item--open kt-menu__item--here');
</script>
<script src="{{ asset('./assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('./assets/js/demo1/pages/crud/datatables/data-sources/ajax-client-side.js') }}" type="text/javascript"></script>

@endsection