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
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: 'in/usuario/datosUsuarios',
				type: 'POST',
				data: {
					pagination: {
						perpage: 50,
					},
				},
			},
			columns: [
				
				{data: 'name' , responsivePriority: 1},
				{data: 'telefono'},
				{data: 'username'},
				{data: 'direccion'},
				{data: 'comuna'},
				{data: 'region'},
				{data: 'created_at'},
				
				{data: 'codigoReferencia'},
				{data: 'id_perfilUsuario'},
				{data: 'Acciones', responsivePriority: -1},
			],
			columnDefs: [
				{
					targets: -1,
					title: 'Acciones',
					orderable: false,
					render: function(data, type, full, meta) {
						var btnTextoGenerar = '',generarActualizar = 1;
						
						if(full.codigoReferencia == null){
							btnTextoGenerar = 'GENERAR CODIGO REFERENCIA';
							generarActualizar = 1;
						}else{
							btnTextoGenerar = 'MODIFICAR CODIGO REFERENCIA';
							generarActualizar = 2;
							
						}
					
						if(tipoUsuario != full.id_perfilUsuario)
						{
							return `
							<span class="dropdown">
								<a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
								<i class="la la-ellipsis-h"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" onclick="editar(${full.id},'${full.name}','${full.email}','${full.rut}','${full.dv}','${full.username}','${full.telefono}','${full.direccion}','${full.idComuna}',${full.id_perfilUsuario});"><i class="la la-edit"></i> EDITAR</a>
									
									<a class="dropdown-item" onclick="eliminar(${full.id})"><i class="la la-trash"></i> ELIMINAR</a>

									<a class="dropdown-item" onclick="generarCodigo(${full.id},${generarActualizar})"><i class="la la-edit"></i>${btnTextoGenerar}</a>
								</div>
							</span>
						
							
							`;
						}else{
							return `
							<span class="dropdown">
								<a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
								<i class="la la-ellipsis-h"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" onclick="editar(${full.id},'${full.name}','${full.email}','${full.rut}','${full.dv}','${full.username}','${full.telefono}','${full.direccion}','${full.idComuna}',${full.id_perfilUsuario});"><i class="la la-edit"></i> EDITAR</a>
									<a class="dropdown-item" onclick="generarCodigo(${full.id},${generarActualizar})"><i class="la la-trash"></i>${btnTextoGenerar}</a>
								</div>
							</span>
						
							
							`;
						}
					},
				},
				{
					targets: -2,
					render: function(data, type, full, meta) {
						var status = {
							1: {'title': 'Administrador', 'class': 'kt-badge--success'},
							2: {'title': 'Cliente', 'class': 'kt-badge--primary'},
							3: {'title': 'Produccion', 'class': 'kt-badge--info'},
							4: {'title': 'Logistica', 'class': ' kt-badge--success'},
							
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

$("#btnAgregar").click(function (e) { 
	e.preventDefault();
	
	
	
	swal.fire({
		title:'AGREGAR USUARIO',
		customClass: 'swal-wide',
		html:
		`
		
		<div class="row">
			<div class="offset-3 col-6">
				<div class="form-group row">
					<div class="col-12">
						<input class="form-control" type="text" name="username" readonly id="username" placeholder="USERNAME" required>
						<span class="form-text text-muted">USERNAME</span>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="form-group row">
					<div class="col-10">
						<input class="form-control" type="text" name="rut" id="rut" placeholder="Rut" required>
						<span class="form-text text-muted">Rut del usuario</span>
					</div>
					<div class="col-2">
						<input class="form-control" type="text" name="dv" id="dv" placeholder="DV" readonly required>
						<span class="form-text text-muted">DV</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<input class="form-control" type="text" name="email" id="email" placeholder="E-Mail" required>
						<span class="form-text text-muted">Ingrese un email que sea valido(opcional)</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<select class="form-control" type="text" name="idT" id="idT" required>
												<option value="" selected disabled>Tipo usuario</option>
												<option value="1">ADMINISTRADOR</option>
												<option value="2">CLIENTE</option>
												<option value="3">PRODUCCION</option>
												<option value="4">LOGISTICA</option>
						</select>
						<span class="form-text text-muted">Tipo de usuario ( rol del usuario dentro del sistema )</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<select class="form-control" type="text" name="region" id="region" required>
							<option value="" selected disabled>Region</option>
							
						</select>
						<span class="form-text text-muted">Seleccione la region correspondiente a su direccion</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<input class="form-control" type="password" name="password" id="password" placeholder="Contraseña" required>
						<span class="form-text text-muted">Ingrese una contraseña minimo 6 caracteres</span>
					</div>
				</div>
			</div>




			<div class="col-6">
				<div class="form-group row">
					<div class="col-12">
						<input class="form-control" type="text" name="nombreC" id="nombreC" placeholder="Nombre" required>
						<span class="form-text text-muted">Nombre del nuevo usuario que desea agregar</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<input class="form-control" type="text" name="telefono" id="telefono" placeholder="Telefono" required>
						<span class="form-text text-muted">Numero de telefono del usuario</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<input class="form-control" type="text" name="direccion" id="direccion" placeholder="Direccion" required>
						<span class="form-text text-muted">Direccion calle-pasaje , numero</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<select class="form-control" type="text" name="comunas" id="comunas" required>
							<option value="" selected disabled>Comuna</option>
							
						</select>
						<span class="form-text text-muted">Seleccione la comuna correspondiente a su direccion</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<input class="form-control" type="password" name="password_confirmation" id="password1" placeholder="Confirme contraseña" required>
						<span class="form-text text-muted">Confirme la contraseñe</span>
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
		
		`,
		showConfirmButton: false,
		
		
		
	});
	$("#telefono").keypress(function (e) { 
		soloNumeros(e)
		maximoCaracteres(e,8,$("#telefono"))
	});
	
	$("#rut").keypress(function (e) { 
		soloNumeros(e);
		
		maximoCaracteres(e,7,$("#rut"))
		
	});
	$("#rut").keyup(function (e) { 
		if($("#rut").val().length >= 7){
			$("#dv").val(dgv($("#rut").val()))
			$("#dv").css("border-color","blue");
		}
		else{
			$("#dv").val("")
			$("#dv").css("border-color","gray");
		}
			
	});

	$("#telefono").keyup(function (e) { 
		if($("#nombreC").val() == ''){
			$("#username").val($("#telefono").val());
		}else{
			$("#username").val($("#nombreC").val().charAt(0)+ $("#telefono").val());
		}
	});

	$("#nombreC").keyup(function (e) { 
		if($("#telefono") == ''){
			$("#username").val($("#nombreC").val().charAt(0));
		}else{
			$("#username").val($("#nombreC").val().charAt(0)+ $("#telefono").val());
		}
	});
	
	$("#idT").select2({
		language: {

			noResults: function() {
		
			  return "No hay resultado";        
			},
			searching: function() {
		
			  return "Buscando..";
			}
		  },
		placeholder: "Seleccione tipo de usuario",
		
		
	});
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		type: "post",
		url: "in/util/regiones",
		dataType: "json",
		success: function (response) {
			$('#region').select2({
				language: {

					noResults: function() {
				
					  return "No hay resultado";        
					},
					searching: function() {
				
					  return "Buscando..";
					}
				  },
				placeholder: "Seleccione la region",
				data: response,
				
			});

			
			
		}
	});
	
	$('#region').change(function (e) { 
		e.preventDefault();
	
		$('#comunas').empty();
		$('#comunas').append('<option value="" selected disabled>Comuna</option>')
		$.ajax({
			type: "post",
			url: "in/util/comunas",
			data: {
				'idRegion': $('#region').val()
			},
			dataType: "json",
			success: function (response) {
				
				$('#comunas').select2({
					
					language: {
						
						noResults: function() {
					
						  return "No hay resultado";        
						},
						searching: function() {
					
						  return "Buscando..";
						}
					  },
				
					placeholder: "Seleccione la comuna",
					data: response
				});
				
			}
		});
	});
	
	$("#btnGuardar").click(function (e) { 
		
		e.preventDefault();
		$("#dv").css("border-color","gray");
		$("#idT").css("border-color","gray");
		$("#password").css("border-color","gray");
		$("#password1").css("border-color","gray");
		$("#nombreC").css("border-color","gray");
		$("#email").css("border-color","gray");
		$("#telefono").css("border-color","gray");
		$("#comunas").css("border-color","gray");
		$("#username").css("border-color","gray");
		$("#direccion").css("border-color","gray");
		//$("#btnGuardar").prop('disabled','true')
		var dat = {
			'rut': $("#rut").val(),
			'nombre':$('#nombreC').val(),
			'email':$('#email').val(),
			'password':$('#password').val(),
			'password_confirmation':$('#password1').val(),
			'seleccionTipoUsuario':$('#idT').val(),
			'dv': $("#dv").val(),
			'telefono': $("#telefono").val(),
			'comunas': $("#comunas").val(),
			'username': $("#username").val(),
			'direccion': $("#direccion").val()
		}
		var erros = '';
		var inputs = [];
		//console.log(erros.length);
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: "post",
			url: "/in/usuario/store",
			data: dat,
			dataType: "json",
			success: function (response) {
				if (response.cod == 100) {
					
					response.mensaje.forEach(element => {
						if (element.indexOf("El campo password") != -1) {
							inputs.push('password')
						}
						if (element.indexOf("seleccion") != -1) {
							inputs.push('idT')
						}
						if (element.indexOf("El campo nombre") != -1) {
							inputs.push('nombreC')
						}
						if (element.indexOf("email") != -1) {
							inputs.push('email')
						}
						if (element.indexOf("El campo confirmación") != -1) {
							inputs.push('password1')
						}
						if (element.indexOf("El campo comunas") != -1) {
							inputs.push('comunas')
							inputs.push('region')
							
						}
						if (element.indexOf("El campo username") != -1) {
							inputs.push('username')
						
							
						}
						if (element.indexOf("El campo dv") != -1) {
							inputs.push('dv')
						
							
						}
						if (element.indexOf("El campo telefono") != -1) {
							inputs.push('telefono')
						
							
						}
						if (element.indexOf("El campo rut") != -1) {
							inputs.push('rut')
						
							
						}
						if (element.indexOf("El campo direccion") != -1) {
							inputs.push('direccion')
						
							
						}
			
						
						
						erros+= element+'</br>';
						
					});
					
				}
				
				
				if (erros.length > 0) {
					$("#erroresTexto").html(erros)
					$("#errores").show();
					inputs.forEach(element => {
						if (element == 'password') {
							$("#password1").val("");
						}
						$("#"+element).val("");
						$("#"+element).css("border-color","red");
					});
					return;
				}
				$("#errores").hide();
				$("#btnGuardar").prop('disabled','false');
				if(response.cod == 200){
					
						swal.fire({title:'Usuario agregado', type: "success"});
						KTDatatablesDataSourceAjaxClient.init();
					
				}else{
					swal.fire({html:erros,title:response.cod, type: "error",customClass: 'swal-wide',});
				}
			}
		});
	});
});




function eliminar(id) {
   
	Swal.fire({
		type: 'question',
		text: 'Esta seguro que desea eliminar este usuario?',
		title: 'Confirmar',
		showCancelButton: true,
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Confirmar',
		
		}).then(function(result) {
			if(result.value){
				var dat = {
					'id': id
				}
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: "post",
					url: "/in/usuario/delete",
					data: dat,
					dataType: "json",
					success: function (response) {
					   
						if(response.cod == 200){
					
					swal.fire({title:'Usuario eliminado', type: "success"});
					KTDatatablesDataSourceAjaxClient.init();
				
						}else{
							swal.fire({text:response.mensaje,title:response.cod, type: "error"});
						}
					}
				});
			}
		});
}

function editar(id,nombre,email,rut,dv,username,telefono,direccion,idcomuna,idT){

	if(email =='null')
	{
		var email = '';
	}

	

	swal.fire({
		title:'EDITAR USUARIO',
		customClass: 'swal-wide',
		html:
		`
		
		<div class="row">
			<div class="offset-3 col-6">
				<div class="form-group row">
					<div class="col-12">
						<input class="form-control" type="text" name="username" readonly id="username" value="${username}" placeholder="USERNAME" required>
						<span class="form-text text-muted">USERNAME</span>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="form-group row">
					<div class="col-10">
						<input class="form-control" type="text" name="rut" id="rut" readonly value="${rut}" placeholder="Rut" required>
						<span class="form-text text-muted">Rut del usuario</span>
					</div>
					<div class="col-2">
						<input class="form-control" type="text" name="dv" id="dv" readonly value="${dv}" placeholder="DV" readonly required>
						<span class="form-text text-muted">DV</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<input class="form-control" type="text" name="email" value="${email}" id="email" placeholder="E-Mail" required>
						<span class="form-text text-muted">Ingrese un email que sea valido(opcional)</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<select class="form-control" type="text" name="idT" id="idT" required>
												<option value="" selected disabled>Tipo usuario</option>
												<option value="1">ADMINISTRADOR</option>
												<option value="2">CLIENTE</option>
												<option value="3">PRODUCCION</option>
												<option value="4">LOGISTICA</option>
						</select>
						<span class="form-text text-muted">Tipo de usuario ( rol del usuario dentro del sistema )</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<select class="form-control" type="text" name="region" id="region" required>
							<option value="" selected disabled>Region</option>
							
						</select>
						<span class="form-text text-muted">Seleccione la region correspondiente a su direccion</span>
					</div>
				</div>

			
			</div>




			<div class="col-6">
				<div class="form-group row">
					<div class="col-12">
						<input class="form-control" type="text" value="${nombre}" name="nombreC" id="nombreC" placeholder="Nombre" required>
						<span class="form-text text-muted">Nombre del nuevo usuario que desea agregar</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<input class="form-control" type="text" name="telefono" value="${telefono}" id="telefono" placeholder="Telefono" required>
						<span class="form-text text-muted">Numero de telefono del usuario</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<input class="form-control" type="text" name="direccion" value="${direccion}" id="direccion" placeholder="Direccion" required>
						<span class="form-text text-muted">Direccion calle-pasaje , numero</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<select class="form-control" type="text" name="comunas" id="comunas" required>
							<option value="" selected disabled>Comuna</option>
							
						</select>
						<span class="form-text text-muted">Seleccione la comuna correspondiente a su direccion</span>
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
		
		`,
		showConfirmButton: false,
		
		
	});
	$.ajax({
		type: "post",
		url: "in/util/getIdRegion",
		data: {
			'idComuna':idcomuna
		},
		dataType: "json",
		success: function (reg) {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: "post",
				url: "in/util/regiones",
				dataType: "json",
				success: function (response) {
					$('#region').select2({
						language: {
		
							noResults: function() {
						
							  return "No hay resultado";        
							},
							searching: function() {
						
							  return "Buscando..";
							}
						  },
						placeholder: "Seleccione la region",
						data: response,
						
					});
					$("#region").val(reg).trigger('change.select2');
					selectComuna(reg)
					
				}
			}); 
		}
	});

	function selectComuna(idRegion) {
		$('#comunas').empty();
		$('#comunas').append('<option value="" selected disabled>Comuna</option>')
		$.ajax({
			type: "post",
			url: "in/util/comunas",
			data: {
				'idRegion': idRegion
			},
			dataType: "json",
			success: function (response) {
				
				$('#comunas').select2({
					
					language: {
						
						noResults: function() {
					
						  return "No hay resultado";        
						},
						searching: function() {
					
						  return "Buscando..";
						}
					  },
				
					placeholder: "Seleccione la comuna",
					data: response
				});
				$("#comunas").val(idcomuna).trigger('change.select2');
				
			}
		});
	}

	$('#region').change(function (e) { 
		e.preventDefault();
	
		$('#comunas').empty();
		$('#comunas').append('<option value="" selected disabled>Comuna</option>')
		$.ajax({
			type: "post",
			url: "in/util/comunas",
			data: {
				'idRegion': $('#region').val()
			},
			dataType: "json",
			success: function (response) {
				
				$('#comunas').select2({
					
					language: {
						
						noResults: function() {
					
						  return "No hay resultado";        
						},
						searching: function() {
					
						  return "Buscando..";
						}
					  },
				
					placeholder: "Seleccione la comuna",
					data: response
				});
				$("#comunas").val(idcomuna).trigger('change.select2');
				
			}
		});
	});
	$("#idT").select2({
		language: {

			noResults: function() {
		
			  return "No hay resultado";        
			},
			searching: function() {
		
			  return "Buscando..";
			}
		  },
		placeholder: "Seleccione tipo de usuario",
		
		
	});
	$("#idT").val(idT).trigger('change.select2');
	$("#telefono").keypress(function (e) { 
		soloNumeros(e)
		maximoCaracteres(e,8,$("#telefono"))
	});
	$("#telefono").keyup(function (e) { 
		if($("#nombreC").val() == ''){
			$("#username").val($("#telefono").val());
		}else{
			$("#username").val($("#nombreC").val().charAt(0)+ $("#telefono").val());
		}
	});

	$("#nombreC").keyup(function (e) { 
		if($("#telefono") == ''){
			$("#username").val($("#nombreC").val().charAt(0));
		}else{
			$("#username").val($("#nombreC").val().charAt(0)+ $("#telefono").val());
		}
	});
	$("#btnGuardar").click(function (e) { 
		e.preventDefault();
		$("#idT").css("border-color","gray");
		$("#password").css("border-color","gray");
		$("#password1").css("border-color","gray");
		$("#nombreC").css("border-color","gray");
		$("#email").css("border-color","gray");

		
	
		var dat = {
			'id':id,
			'rut': $("#rut").val(),
			'nombre':$('#nombreC').val(),
			'email':$('#email').val(),
			'seleccionTipoUsuario':$('#idT').val(),
			'dv': $("#dv").val(),
			'telefono': $("#telefono").val(),
			'comunas': $("#comunas").val(),
			'username': $("#username").val(),
			'direccion': $("#direccion").val()
		}
		var erros = '';
		var inputs = [];
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: "post",
			url: "/in/usuario/update",
			data: dat,
			dataType: "json",
			success: function (response) {
				if (response.cod == 100) {
					
					response.mensaje.forEach(element => {
						if (element.indexOf("El campo password") != -1) {
							inputs.push('password')
						}
						if (element.indexOf("seleccion") != -1) {
							inputs.push('idT')
						}
						if (element.indexOf("El campo nombre") != -1) {
							inputs.push('nombreC')
						}
						if (element.indexOf("email") != -1) {
							inputs.push('email')
						}
						if (element.indexOf("El campo confirmación") != -1) {
							inputs.push('password1')
						}
						if (element.indexOf("El campo comunas") != -1) {
							inputs.push('comunas')
							inputs.push('region')
							
						}
						if (element.indexOf("El campo username") != -1) {
							inputs.push('username')
						
							
						}
						if (element.indexOf("El campo dv") != -1) {
							inputs.push('dv')
						
							
						}
						if (element.indexOf("El campo telefono") != -1) {
							inputs.push('telefono')
						
							
						}
						if (element.indexOf("El campo rut") != -1) {
							inputs.push('rut')
						
							
						}
						if (element.indexOf("El campo direccion") != -1) {
							inputs.push('direccion')
						
							
						}
			
						
						
						erros+= element+'</br>';
						
					});
					
				}
				
				
				if (erros.length > 0) {
					$("#erroresTexto").html(erros)
					$("#errores").show();
					inputs.forEach(element => {
						if (element == 'password') {
							$("#password1").val("");
						}
						$("#"+element).val("");
						$("#"+element).css("border-color","red");
					});
					return;
				}
				$("#errores").hide();
				$("#btnGuardar").prop('disabled','false');
				if(response.cod == 200){
					
						swal.fire({title:'Usuario editado correctamente', type: "success"});
						KTDatatablesDataSourceAjaxClient.init();
					
				}else{
					swal.fire({text:response.mensaje,title:response.cod, type: "error"});
				}
			}
		});
	});
}



function generarCodigo(id,marca){
	var mensajeSweetAlert ='';
	console.log(marca)
	if(marca == 1){
		mensajeSweetAlert = 'Esta seguro que desea generar un codigo de referencia?'
	}else{
		mensajeSweetAlert = 'Esta seguro que desea modificar el codigo de referencia?'
	}
	Swal.fire({
		type: 'question',
		text: mensajeSweetAlert,
		title: 'Confirmar',
		showCancelButton: true,
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Confirmar',
		
		}).then(function(result) {
			if(result.value){
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: "post",
					url: "in/usuario/generarCodigo",
					data: {
						'idUsuario': id,
						'marca':marca

					},
					dataType: "json",
					success: function (response) {
						
						if(response.cod == 200){
										
							swal.fire({title:response.mensaje, type: "success"});
							KTDatatablesDataSourceAjaxClient.init();
						
						}else{
							swal.fire({title:response.cod,text:response.mensaje, type: "error"});
						}
					}
				});
			}
		});
	
}