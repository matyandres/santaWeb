'use strict';

var KTDatatablesDataSourceAjaxClient = function() {

	var initTable1 = function() {
		var table = $('#kt_table_1');

		// begin first table
		table.DataTable({
			responsive: true,
			destroy:true,	
			language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
				"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
				"infoFiltered": "(Filtrado de _MAX_ total entradas)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ Entradas",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "Sin resultados encontrados",
				"paginate": {
					"first": "Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			},
			ajax: {
				url: '/in/u_data',
				type: 'GET',
				data: {
					pagination: {
						perpage: 50,
					},
				},
			},
			columns: [
				{data: 'name'},
				{data: 'email'},
				{data: 'id_tipo'},
				{data: 'Acciones', responsivePriority: -1},
			],
			columnDefs: [
				{
					targets: -1,
					title: 'Acciones',
					orderable: false,
					render: function(data, type, full, meta) {
						return `
                        <span class="dropdown">
                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                              <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" onclick="editar(${full.id},'${full.name}','${full.email}');"><i class="la la-edit"></i> EDITAR</a>
                                
                                <a class="dropdown-item" onclick="eliminar(${full.id})"><i class="la la-trash"></i> ELIMINAR</a>
							</div>
						</span>
						<a onclick="view(${full.id},'${full.id_tipo}')" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="ver proyectos">
                          <i class="la la-edit"></i>
						</a>
						<a onclick="asignar(${full.id},'${full.id_tipo}')" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Asignar proyecto">
                          <i class="la la-edit"></i>
                        </a>
                        `;
					},
				},
				{
					targets: -2,
					render: function(data, type, full, meta) {
						var status = {
							1: {'title': 'ADMIN', 'class': ' kt-badge--success'},
							2: {'title': 'USUARIO', 'class': 'kt-badge--info'},
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
					},
				},
				
			],
		});
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxClient.init();
});