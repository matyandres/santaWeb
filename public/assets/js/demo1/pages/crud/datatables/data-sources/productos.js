'use strict';

$('li#menuProductos').removeClass('kt-menu__item kt-menu__item--submenu kt-menu__item--rel');
$('li#menuProductos').addClass('kt-menu__item kt-menu__item--submenu kt-menu__item--rel');
$('li#menuProductos').addClass('kt-menu__item kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open kt-menu__item--here  kt-menu__item--open kt-menu__item--here');


var KTDatatablesDataSourceAjaxClient = function () {

	var initTable1 = function () {
		var table = $('#kt_table_1');
		// begin first table
		table.DataTable({
			responsive: true,
			destroy: true,
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
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: 'in/productos/datosProductos',
				type: 'POST',
				data: {
					pagination: {
						perpage: 50,
					},
				},
			},
			columns: [

				{ data: 'nombre', responsivePriority: 1 },
				{ data: 'descripcion' },
				{ data: 'precio' },
				{ data: 'idEstado' },
				{ data: 'oferta' },

				{ data: 'created_at' },


				{ data: 'Acciones', responsivePriority: -1 },
			],
			columnDefs: [
				{
					targets: -1,
					title: 'Acciones',
					orderable: false,
					render: function (data, type, full, meta) {
						if (full.oferta  == 0) {
							return/*html*/ ` 
							<span class="dropdown">
								<a class="btn btn-sm btn-clean btn-icon btn-icon-md" onclick="cambiarEstado(${full.idProducto})" >
									<i class="fas fa-exchange-alt"></i>
								</a>
								<a class="btn btn-sm btn-clean btn-icon btn-icon-md" onclick="historialPrecio(${full.idProducto},'${full.nombre}')" >
									<i class="fab fa-readme"></i>
								</a>
								<a class="btn btn-sm btn-clean btn-icon btn-icon-md" onclick="setPrecio(${full.idProducto})" >
									<i class="fab fas fa-dollar-sign"></i>
								</a>
								<a class="btn btn-sm btn-clean btn-icon btn-icon-md" onclick="setOferta(${full.idProducto})" >
									<i class="fab fas fa-piggy-bank"></i>
								</a>
								<a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
									<i class="la la-ellipsis-h"></i>
								</a>

								<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" onclick="editar(${full.idProducto},'${full.avatar}','${full.nombre}','${full.descripcion}');"><i class="la la-edit"></i> EDITAR</a>
									
									<a class="dropdown-item" onclick="eliminar(${full.idProducto})"><i class="la la-trash"></i> ELIMINAR</a>
								</div>
							</span>
						
							
							`;
						} else {
							return/*html*/ ` 
								<span class="dropdown">
									<a class="btn btn-sm btn-clean btn-icon btn-icon-md" onclick="cambiarEstado(${full.idProducto})" >
										<i class="fas fa-exchange-alt"></i>
									</a>
									<a class="btn btn-sm btn-clean btn-icon btn-icon-md" onclick="historialPrecio(${full.idProducto},'${full.nombre}')" >
										<i class="fab fa-readme"></i>
									</a>
									<a class="btn btn-sm btn-clean btn-icon btn-icon-md" onclick="setPrecio(${full.idProducto})" >
										<i class="fab fas fa-dollar-sign"></i>
									</a>
									<a class="btn btn-sm btn-clean btn-icon btn-icon-md" onclick="quitarOferta(${full.idProducto})" >
										<i class="flaticon2-cancel-music"></i>
									</a>
									<a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
										<i class="la la-ellipsis-h"></i>
									</a>

									<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" onclick="editar(${full.idProducto},'${full.avatar}','${full.nombre}','${full.descripcion}');"><i class="la la-edit"></i> EDITAR</a>
										
										<a class="dropdown-item" onclick="eliminar(${full.idProducto})"><i class="la la-trash"></i> ELIMINAR</a>
									</div>
								</span>
						
							
							`;
						}

					},
				},
				{
					targets: -3,
					render: function (data, type, full, meta) {
						var status = {
							1: { 'title': 'Con stock', 'class': 'kt-badge--success' },
							2: { 'title': 'Sin stock', 'class': 'kt-badge--info' },
							3: { 'title': 'No disponible', 'class': 'kt-badge--danger' },
							4: { 'title': 'Logistica', 'class': ' kt-badge--success' },

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
		init: function () {
			initTable1();
		},

	};

}();

function setPrecio(id) {
	swal.fire({
		title: 'AGREGAR PRECIOS',
		customClass: 'swal-wide',
		html:/*html*/
			`	
			<div class="row">
				
				<div class="offset-2 col-8">
				
					<div class="form-group row">
						<div class="col-12">
							<input class="form-control" type="number" style="text-align: center" name="valor" id="valor" placeholder="Valor del producto" required>
							<span class="form-text text-muted">Nuevo precio ( Este precio quedara predefinido para el producto )</span>
						</div>
					</div>
					<button class="btn btn-primary form-control" id="btnGuardar">Guardar</button>
				</div>
				
			</div>
		
		`,
		showConfirmButton: false,
	});
	$("#btnGuardar").click(function (e) {
		e.preventDefault();
		var dat = {
			'id': id,
			'valor': $('#valor').val()
		}
		$.ajax({
			type: "post",
			url: "/in/productos/setPrecio",
			data: dat,
			dataType: "json",
			success: function (response) {
				if (response.cod == 200) {

					swal.fire({ title: response.mensaje, type: "success" });
					KTDatatablesDataSourceAjaxClient.init();

				} else {
					swal.fire({ text: response.mensaje, title: response.cod, type: "error" });
				}
			}
		});
	});
}

function setOferta(id) {
	$.ajax({
		type: "post",
		url: "/in/productos/searchOffer",
		data: {
			id
		},
		success: function (response) {
			if (response.response) {
				var x = response.data.oferta;
				var template = `	
			<div class="row">
			<div class="offset-2 col-8">
		
			<div class="form-group row">
				<div class="col-12">
		     `;
				if (response.data.oferta == 0) {
					template += `
							<input class="form-control" type="number" style="text-align: center" name="valor" id="valorOferta" placeholder="% de descuento" required>
							<span class="form-text text-muted">Nueva oferta ( Se cambiara el precio del producto segun el % de la oferta )</span>`;
				}
				template += `</div>
						</div>
						`;
				if (x == 0) {
					template += `
							<button class="btn btn-primary form-control" id="btnGuardar">Guardar</button>	
				`;
				} else {
					template +=
						`
							<button class="btn btn-danger form-control" id="btnQuitar">Quitar oferta</button>	
				`;
				}
				template += `</div >
			</div >
				`;
				swal.fire({
					title: 'AGREGAR OFERTA',
					customClass: 'swal-wide',
					html: template,
					showConfirmButton: false,
				});
				$("#btnGuardar").click(function (e) {
					e.preventDefault();
					var dat = {
						'id': id,
						'valor': $('#valorOferta').val()
					}
					$.ajax({
						type: "post",
						url: "/in/productos/setOferta",
						data: dat,
						dataType: "json",
						success: function (response) {
							if (response.cod == 200) {

								swal.fire({ title: response.mensaje, type: "success" });
								KTDatatablesDataSourceAjaxClient.init();

							} else {
								swal.fire({ text: response.mensaje, title: response.cod, type: "error" });
							}
						}
					});
				});
				$("#btnQuitar").click(function (e) {
					e.preventDefault();
					var dat = {
						'id': id,
					}
					$.ajax({
						type: "post",
						url: "/in/productos/quitarOferta",
						data: dat,
						dataType: "json",
						success: function (response) {
							if (response.cod == 200) {

								swal.fire({ title: response.mensaje, type: "success" });
								KTDatatablesDataSourceAjaxClient.init();

							} else {
								swal.fire({ text: response.mensaje, title: response.cod, type: "error" });
							}
						}
					});
				});
			}
		}
	});


}

function editar(id, avatar, nombre, descripcion) {

	let divDinamico = /* html */`
		< div class="kt-avatar__holder" id = "imge"
	style = "width: 100px;height: 100px;background-image: url('./assets/media/users/pdefault.jpg');" >
			</div >
		`;
	if (id != '') {
		divDinamico = /* html */`
		< div class="kt-avatar__holder" id = "imge"
	style = "width: 100px;height: 100px;background-image: url(${avatar});" >
			</div >
		`;
	}
	swal.fire({
		title: 'EDITAR PRODUCTO',
		customClass: 'swal-wide',
		html:/*html*/
			`
		< form id = "formIngresar" >
			<div class="row">
				<div class="offset-3 col-6">
					<div class="form-group row">
						<div class="col-12">
							<div class="col-lg-12 col-xl-12">
								<div class="kt-avatar kt-avatar--outline kt-avatar--circle-" id="kt_user_edit_avatar">


									${divDinamico}

									<label class="kt-avatar__upload" data-toggle="kt-tooltip" title=""
										data-original-title="Cambiar avatar">
										<i class="fa fa-pen"></i>
										<input type="file" name="avatar" id="imagenForm" accept=".jpg, .jpeg">
							
							</label>
										<span class="kt-avatar__cancel" data-toggle="kt-tooltip" title=""
											data-original-title="Cancel avatar">
											<i class="fa fa-times"></i>
										</span>
						</div>
								</div>
								<span class="form-text text-muted">AVATAR</span>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group row">
							<div class="col-12">
								<input class="form-control" style="text-align: center" type="text" value="${nombre}" name="nombre" id="nombre" placeholder="Nombre" required>
									<span class="form-text text-muted">Nombre del producto</span>
						</div>
							</div>

							<div class="form-group row">
								<div class="col-12">
									<input class="form-control" type="text" style="text-align: center" value="${descripcion}" name="descripcion" id="descripcion" placeholder="Descripcion" required>
										<span class="form-text text-muted">Descripcion del producto</span>
						</div>
								</div>







							</div>





						</div>



						<div class="alert alert-custom alert-outline-2x alert-outline-danger fade show mb-5" id="errores" style="display:none" role="alert">
							<div class="alert-icon"><i class="flaticon-warning"></i></div>
							<div class="alert-text" id="erroresTexto"></div>
							<div class="alert-close">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true"><i class="ki ki-close"></i></span>
								</button>
							</div>
						</div>



						<button class="btn btn-primary form-control" id="btnGuardar">Guardar</button>
			</form>
			`,
		showConfirmButton: false,



	});

	function readFile(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				var filePreview = document.createElement('img');
				filePreview.id = 'file-preview';
				filePreview.style.width = "100px";
				filePreview.style.height = "100px";

				filePreview.src = e.target.result;


				var previewZone = document.getElementById('imge');
				var preview1 = $("#imge");
				preview1.empty().append(filePreview);

			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	var fileUpload = document.getElementById('imagenForm');
	fileUpload.onchange = function (e) {
		readFile(e.srcElement);
	}

	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		type: "post",
		url: "in/util/estadoProducto",
		dataType: "json",
		success: function (response) {
			$('#estadoProducto').select2({
				language: {

					noResults: function () {

						return "No hay resultado";
					},
					searching: function () {

						return "Buscando..";
					}
				},
				placeholder: "Seleccione el estado",
				data: response,

			});



		}
	});



	$("#btnGuardar").click(function (e) {

		e.preventDefault();
		$("#dv").css("border-color", "gray");
		$("#idT").css("border-color", "gray");
		$("#password").css("border-color", "gray");
		$("#password1").css("border-color", "gray");
		$("#nombreC").css("border-color", "gray");
		$("#email").css("border-color", "gray");
		$("#telefono").css("border-color", "gray");
		$("#comunas").css("border-color", "gray");
		$("#username").css("border-color", "gray");
		$("#direccion").css("border-color", "gray");

		var formData = new FormData(document.getElementById("formIngresar"));
		formData.append("id", id);


		var erros = '';
		var inputs = [];

		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: "post",
			url: "/in/productos/update",
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,

			success: function (response) {
				if (response.cod == 100) {

					response.mensaje.forEach(element => {
						if (element.indexOf("El campo nombre") != -1) {
							inputs.push('nombre')
						}

						if (element.indexOf("El campo descripcion") != -1) {
							inputs.push('descripcion')
						}

						if (element.indexOf("El campo avatar") != -1) {
							inputs.push('imagenForm')
						}
						if (element.indexOf("El campo valor ") != -1) {
							inputs.push('Valor')


						}
						if (element.indexOf("estado producto") != -1) {
							inputs.push('estadoProducto')


						}

						erros += element + '</br>';

					});

				}


				if (erros.length > 0) {
					$("#erroresTexto").html(erros)
					$("#errores").show();
					inputs.forEach(element => {
						if (element == 'password') {
							$("#password1").val("");
						}
						$("#" + element).val("");
						$("#" + element).css("border-color", "red");
					});
					return;
				}
				$("#errores").hide();
				$("#btnGuardar").prop('disabled', 'false');
				if (response.cod == 200) {

					swal.fire({ title: response.mensaje, type: "success" });
					KTDatatablesDataSourceAjaxClient.init();

				} else {
					swal.fire({ html: response.mensaje, title: response.cod, type: "error", customClass: 'swal-wide', });
				}
			}
		});
	});




}

function historialPrecio(id, nombre1) {
	var dat = {
		'id': id
	}
	$.ajax({
		type: "post",
		url: "/in/productos/historialPrecio",
		data: dat,
		dataType: "json",
		success: function (response) {
			var td = '';

			if (response.cod == 200) {

				response.resp.forEach(value => {



					if (value.estado == 1) {
						td = td + '<td>' + value.precio + '</td><td><b>Activo</b></td>';
					} else {
						td = td + '<td>' + value.precio + '</td><td>Inactivo</td>';
					}

					td = td + '</tr>';
				});



				swal.fire({
					title: `HISTORIAL PRECIOS : <b> ${nombre1} </b>`,
					customClass: 'swal-wide',
					html:/*html*/
						`
					<div class="row">

						<div class=" col-10">
							<div class="col-12">
								<table class="table-bordered table">
									<thead>
										<tr>
											<th>Precio</th>
											<th>Estado</th>
										</tr>
									</thead>
									<tbody>
										${td}
									</tbody>
								</table>
							</div>

						</div>





					</div>

					`,
					showConfirmButton: false,
				});




			} else {

			}
		}
	});


}
function cambiarEstado(id) {
	swal.fire({
		title: 'CAMBIAR ESTADO',
		customClass: 'swal-wide',
		html:/*html*/
			`	
		<div class="row">
			<div class="offset-3 col-6">
				<div class="col-12">
					<select class="form-control" type="text" name="estadoProducto" id="estadoProducto" required>
						<option value="" selected disabled>Estado productos</option>
						
					</select>
					<span class="form-text text-muted">Seleccione el estado del producto</span>
				</div>
				<button class="btn btn-primary form-control" id="btnGuardar">Guardar</button>
			</div>
		</div>
		
		`,
		showConfirmButton: false,
	});
	$("#btnGuardar").prop('disabled', true)
	$.ajax({
		type: "post",
		url: "in/util/getIdProducto",
		data: {
			'id': id
		},
		dataType: "json",
		success: function (reg) {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: "post",
				url: "in/util/estadoProducto",
				dataType: "json",
				success: function (response) {
					$('#estadoProducto').select2({
						language: {

							noResults: function () {

								return "No hay resultado";
							},
							searching: function () {

								return "Buscando..";
							}
						},
						placeholder: "Seleccione la region",
						data: response,

					});
					$("#estadoProducto").val(reg).trigger('change.select2');

					$("#btnGuardar").prop('disabled', false)
				}
			});
		}
	});
	$("#btnGuardar").click(function (e) {
		e.preventDefault();
		var dat = {
			'idProducto': id,
			'estado': $("#estadoProducto").val()
		}
		$.ajax({
			type: "post",
			url: "/in/productos/cambiaEstado",
			data: dat,
			dataType: "json",
			success: function (response) {
				if (response.cod == 200) {

					swal.fire({ title: response.mensaje, type: "success" });
					KTDatatablesDataSourceAjaxClient.init();

				} else {
					swal.fire({ text: response.mensaje, title: response.cod, type: "error" });
				}
			}
		});

	});

}

function eliminar(id) {

	Swal.fire({
		type: 'question',
		text: 'Esta seguro que desea eliminar este producto y la informacion asociada?',
		title: 'Confirmar',
		showCancelButton: true,
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Confirmar',

	}).then(function (result) {
		if (result.value) {
			var dat = {
				'id': id
			}
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: "post",
				url: "/in/productos/delete",
				data: dat,
				dataType: "json",
				success: function (response) {

					if (response.cod == 200) {

						swal.fire({ title: 'Producto eliminado', type: "success" });
						KTDatatablesDataSourceAjaxClient.init();

					} else {
						swal.fire({ text: response.mensaje, title: response.cod, type: "error" });
					}
				}
			});
		}
	});

}
function quitarOferta(id) {

	Swal.fire({
		type: 'question',
		text: 'Esta seguro que desea eliminar la oferta de este producto?',
		title: 'Confirmar',
		showCancelButton: true,
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Confirmar',

	}).then(function (result) {
		if (result.value) {
			var dat = {
				'id': id
			}
			$.ajax({
				type: "post",
				url: "/in/productos/quitarOferta",
				data: dat,
				dataType: "json",
				success: function (response) {
					if (response.cod == 200) {

						swal.fire({ title: response.mensaje, type: "success" });
						KTDatatablesDataSourceAjaxClient.init();

					} else {
						swal.fire({ text: response.mensaje, title: response.cod, type: "error" });
					}
				}
			});
		}
	});

}


jQuery(document).ready(function () {
	KTDatatablesDataSourceAjaxClient.init();
});


$("#btnAgregar").click(function (e) {
	e.preventDefault();



	swal.fire({
		title: 'AGREGAR PRODUCTO',
		customClass: 'swal-wide',
		html:/*html*/
			`
		<form id="formIngresar">
						<div class="row">
							<div class="offset-3 col-6">
								<div class="form-group row">
									<div class="col-12">
										<div class="col-lg-12 col-xl-12">
											<div class="kt-avatar kt-avatar--outline kt-avatar--circle-" id="kt_user_edit_avatar">

												<div class="kt-avatar__holder" id="imge"
													style="width: 100px;height: 100px;background-image: url('./assets/media/users/pdefault.jpg');">
												</div>


												<label class="kt-avatar__upload" data-toggle="kt-tooltip" title=""
													data-original-title="Cambiar avatar">
													<i class="fa fa-pen"></i>
													<input type="file" name="avatar" id="imagenForm" accept=".jpg, .jpeg">
						
						</label>
													<span class="kt-avatar__cancel" data-toggle="kt-tooltip" title=""
														data-original-title="Cancel avatar">
														<i class="fa fa-times"></i>
													</span>
					</div>
											</div>
											<span class="form-text text-muted">AVATAR</span>
										</div>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group row">
										<div class="col-12">
											<input class="form-control" style="text-align: center" type="text" name="nombre" id="nombre" placeholder="Nombre" required>
												<span class="form-text text-muted">Nombre del producto</span>
					</div>
										</div>

										<div class="form-group row">
											<div class="col-12">
												<input class="form-control" type="text" style="text-align: center" name="descripcion" id="descripcion" placeholder="Descripcion" required>
													<span class="form-text text-muted">Descripcion del producto</span>
					</div>
											</div>
											<div class="form-group row">
												<div class="col-12">
													<input class="form-control" type="number" style="text-align: center" name="Valor" id="Valor" placeholder="Valor" required>
														<span class="form-text text-muted">Valor del producto</span>
					</div>
												</div>
												<div class="form-group row">
													<div class="col-12">
														<select class="form-control" type="text" name="estadoProducto" id="estadoProducto" required>
															<option value="" selected disabled>Estado productos</option>

														</select>
														<span class="form-text text-muted">Seleccione el estado del producto</span>
													</div>


												</div>



											</div>





										</div>



										<div class="alert alert-custom alert-outline-2x alert-outline-danger fade show mb-5" id="errores" style="display:none" role="alert">
											<div class="alert-icon"><i class="flaticon-warning"></i></div>
											<div class="alert-text" id="erroresTexto"></div>
											<div class="alert-close">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true"><i class="ki ki-close"></i></span>
												</button>
											</div>
										</div>



										<button class="btn btn-primary form-control" id="btnGuardar">Guardar</button>
		</form>
		`,
		showConfirmButton: false,



	});

	function readFile(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				var filePreview = document.createElement('img');
				filePreview.id = 'file-preview';
				filePreview.style.width = "100px";
				filePreview.style.height = "100px";

				filePreview.src = e.target.result;


				var previewZone = document.getElementById('imge');
				var preview1 = $("#imge");
				preview1.empty().append(filePreview);

			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	var fileUpload = document.getElementById('imagenForm');
	fileUpload.onchange = function (e) {
		readFile(e.srcElement);
	}

	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		type: "post",
		url: "in/util/estadoProducto",
		dataType: "json",
		success: function (response) {
			$('#estadoProducto').select2({
				language: {

					noResults: function () {

						return "No hay resultado";
					},
					searching: function () {

						return "Buscando..";
					}
				},
				placeholder: "Seleccione el estado",
				data: response,

			});



		}
	});



	$("#btnGuardar").click(function (e) {

		e.preventDefault();
		$("#dv").css("border-color", "gray");
		$("#idT").css("border-color", "gray");
		$("#password").css("border-color", "gray");
		$("#password1").css("border-color", "gray");
		$("#nombreC").css("border-color", "gray");
		$("#email").css("border-color", "gray");
		$("#telefono").css("border-color", "gray");
		$("#comunas").css("border-color", "gray");
		$("#username").css("border-color", "gray");
		$("#direccion").css("border-color", "gray");

		var formData = new FormData(document.getElementById("formIngresar"));
		formData.append("dato", "valor");


		var erros = '';
		var inputs = [];

		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: "post",
			url: "/in/productos/store",
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,

			success: function (response) {
				if (response.cod == 100) {

					response.mensaje.forEach(element => {
						if (element.indexOf("El campo nombre") != -1) {
							inputs.push('nombre')
						}

						if (element.indexOf("El campo descripcion") != -1) {
							inputs.push('descripcion')
						}

						if (element.indexOf("El campo avatar") != -1) {
							inputs.push('imagenForm')
						}
						if (element.indexOf("El campo valor ") != -1) {
							inputs.push('Valor')


						}
						if (element.indexOf("estado producto") != -1) {
							inputs.push('estadoProducto')


						}

						erros += element + '</br>';

					});

				}


				if (erros.length > 0) {
					$("#erroresTexto").html(erros)
					$("#errores").show();
					inputs.forEach(element => {
						if (element == 'password') {
							$("#password1").val("");
						}
						$("#" + element).val("");
						$("#" + element).css("border-color", "red");
					});
					return;
				}
				$("#errores").hide();
				$("#btnGuardar").prop('disabled', 'false');
				if (response.cod == 200) {

					swal.fire({ title: response.mensaje, type: "success" });
					KTDatatablesDataSourceAjaxClient.init();

				} else {
					swal.fire({ html: response.mensaje, title: response.cod, type: "error", customClass: 'swal-wide', });
				}
			}
		});
	});



});


