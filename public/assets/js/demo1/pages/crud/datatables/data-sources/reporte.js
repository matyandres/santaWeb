'use strict';

$('li#menuReporte').removeClass('kt-menu__item kt-menu__item--submenu kt-menu__item--rel');
$('li#menuReporte').addClass('kt-menu__item kt-menu__item--submenu kt-menu__item--rel');
$('li#menuReporte').addClass('kt-menu__item kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open kt-menu__item--here  kt-menu__item--open kt-menu__item--here');


$(document).ready(function () {
    $('#selectProveedor').select2({
        width: "100%"
    });
    cargarProveedores();
    cargarAños();
});

const cargarAños = () => {
    const fecha = new Date();
    var template = `<option value="${fecha.getFullYear()}">${fecha.getFullYear()}</option>`;
    var año = fecha.getFullYear();
    for (let index = 0; index < 5; index++) {
        template += `<option value="${año - 1}">${año - 1}</option>`;
        año--;
    }
    $('#selectAñoReporte').append(template);
}

$('#selectAñoReporte').change(function (e) {
    e.preventDefault();
    listarClientes($('#selectAñoReporte').val());
    listarVentas($('#selectAñoReporte').val());
    listarProductos($('#selectAñoReporte').val());
    var idProveedor = $('#selectProveedor').val();
    var mesProveedor = $('#selectMesProveedor').val();
    listarVentasProveedor(idProveedor, mesProveedor, $('#selectAñoReporte').val());
});

$('#selectTipoReporte').change(function (e) {
    e.preventDefault();
    var idTipo = $('#selectTipoReporte').val();
    switch (idTipo) {
        case '0':
            $('#divClientes').attr("hidden", true);
            $('#divVentas').attr("hidden", true);
            $('#divProductos').attr("hidden", true);
            $('#divVentasProveedor').attr("hidden", true);
            break;
        case '1':
            $('#divClientes').removeAttr('hidden');

            $('#divVentas').attr('hidden', true);
            $('#divProductos').attr('hidden', true);
            $('#divVentasProveedor').attr('hidden', true);
            listarClientes($('#selectAñoReporte').val());
            break;
        case '2':
            $('#divVentas').removeAttr('hidden');

            $('#divClientes').attr('hidden', true);
            $('#divProductos').attr('hidden', true);
            $('#divVentasProveedor').attr('hidden', true);
            listarVentas($('#selectAñoReporte').val());
            break;
        case '3':
            $('#divProductos').removeAttr('hidden');

            $('#divClientes').attr('hidden', true);
            $('#divVentas').attr('hidden', true);
            $('#divVentasProveedor').attr('hidden', true);
            listarProductos($('#selectAñoReporte').val());
            break;
        case '4':
            $('#divVentasProveedor').removeAttr('hidden');

            $('#divClientes').attr('hidden', true);
            $('#divVentas').attr('hidden', true);
            $('#divProductos').attr('hidden', true);
            var idProveedor = $('#selectProveedor').val();
            var mesProveedor = $('#selectMesProveedor').val();
            listarVentasProveedor(idProveedor, mesProveedor, $('#selectAñoReporte').val());
            break;
    }
});

const cargarProveedores = () => {
    $.ajax({
        type: "get",
        url: "in/reportes/getProveedores",
        success: function (response) {
            if (response.response) {
                var template = `<option value="0">Todo</option>`;
                response.data.forEach(element => {
                    template += `<option value="${element.id}">${element.name}</option>`;
                });
                $('#selectProveedor').append(template);

            }
        }
    });
}
$('#selectProveedor').change(function (e) {
    e.preventDefault();
    var idProveedor = $('#selectProveedor').val();
    var mesProveedor = $('#selectMesProveedor').val();
    listarVentasProveedor(idProveedor, mesProveedor,  $('#selectAñoReporte').val());
});
$('#selectMesProveedor').change(function (e) {
    e.preventDefault();
    var idProveedor = $('#selectProveedor').val();
    var mesProveedor = $('#selectMesProveedor').val();
    listarVentasProveedor(idProveedor, mesProveedor,  $('#selectAñoReporte').val());
});

var listarClientes = function (e) {
    var table = $("#ktClientes").DataTable({
        lengthMenu: [
            [5, 10, 30, 50, -1],
            [5, 10, 30, 50, "Todo"]
        ],
        destroy: true,
        ordentable: true,
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": " _START_ - _END_ de _TOTAL_ ",
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
        sDom: "B<'row'><'row'<'col-md-9'l><'col-md-2'f>r>t<'row'<'col-md-3'i>><'row'<'#colvis'>p>",
        buttons: [{
            extend: 'pdf',
            text: 'PDF'
        },
        {
            extend: 'excel',
            text: 'EXCEL'
        },
        {
            extend: 'csv',
            text: 'CSV'
        },
        {
            extend: 'print',
            text: 'Imprimir'
        },
        {
            extend: 'copy',
            text: 'Copiar'
        }
        ],
        "ajax": {
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            "method": "post",
            "url": "in/usuario/datosCliente",
            "data": {
                'fecha': e
            }
        },
        "columns": [{
            "data": "name"
        },
        {
            "data": "direccion"
        },
        {
            "data": "rutCompleto"
        },
        {
            "data": "telefono"
        },
        {
            "data": "nombreComuna"
        },
        {
            "data": "created_at"
        },
        {
            "data": "username"
        },
        ],
    });
}

var listarProductos = function (e) {
    var table = $("#kt_table_1").DataTable({
        lengthMenu: [
            [5, 10, 30, 50, -1],
            [5, 10, 30, 50, "Todo"]
        ],
        destroy: true,
        ordentable: true,
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": " _START_ - _END_ de _TOTAL_ ",
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
        sDom: "B<'row'><'row'<'col-md-9'l><'col-md-2'f>r>t<'row'<'col-md-3'i>><'row'<'#colvis'>p>",
        buttons: [{
            extend: 'pdf',
            text: 'PDF'
        },
        {
            extend: 'excel',
            text: 'EXCEL'
        },
        {
            extend: 'csv',
            text: 'CSV'
        },
        {
            extend: 'print',
            text: 'Imprimir'
        },
        {
            extend: 'copy',
            text: 'Copiar'
        }
        ],
        "ajax": {
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            "method": "post",
            "url": "in/productos/datosProductos",
            "data": {
                "fecha": e
            }
        },
        "columns": [{
            "data": "nombre"
        },
        {
            "data": "descripcion"
        },
        {
            "data": "precio"
        },
        {
            "data": "idEstado"
        },
        {
            "data": "created_at"
        },
        ],
        "columnDefs": [
            {
                targets: -2,
                render: function (data, type, full, meta) {
                    console.log(data);
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
}


var listarVentas = function (e) {
    var table = $("#tablaVentas").DataTable({
        lengthMenu: [
            [5, 10, 30, 50, -1],
            [5, 10, 30, 50, "Todo"]
        ],
        destroy: true,
        ordentable: true,
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": " _START_ - _END_ de _TOTAL_ ",
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
        sDom: "B<'row'><'row'<'col-md-9'l><'col-md-2'f>r>t<'row'<'col-md-3'i>><'row'<'#colvis'>p>",
        buttons: [{
            extend: 'pdf',
            text: 'PDF'
        },
        {
            extend: 'excel',
            text: 'EXCEL'
        },
        {
            extend: 'csv',
            text: 'CSV'
        },
        {
            extend: 'print',
            text: 'Imprimir'
        },
        {
            extend: 'copy',
            text: 'Copiar'
        }
        ],
        "ajax": {
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            "method": "post",
            "url": "in/ventas/getVentas",
            "data": {
                'fecha': e
            }
        },
        "columns": [{
            "data": "idUsuario"
        },
        {
            "data": "idCupon"
        },
        {
            "data": "created_at"
        },
        {
            "data": "total"
        },
        {
            "data": "idEstadoTicket"
        },
        ],
        "columnDefs": [
            {
                targets: 4,
                render: function (data, type, full, meta) {
                    var status = {
                        1: { 'title': 'Pagado', 'class': 'kt-badge--success' },
                        2: { 'title': 'Entregado', 'class': 'kt-badge--info' },
                        3: { 'title': 'Verificando informacion', 'class': 'kt-badge--warning' },
                        4: { 'title': 'En produccion', 'class': ' kt-badge--success' },
                        5: { 'title': 'Producto enviado', 'class': ' kt-badge--success' },
                        6: { 'title': 'Sin respuesta del cliente', 'class': ' kt-badge--success' },
                        7: { 'title': 'Cancelado', 'class': ' kt-badge--danger' },

                    };
                    if (typeof status[data] === 'undefined') {
                        return data;
                    }
                    return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
                },
            },

        ],
    });
}
var listarVentasProveedor = function (e, f, año) {
    var table = $("#reporteVentasProveedor").DataTable({
        lengthMenu: [
            [5, 10, 30, 50, -1],
            [5, 10, 30, 50, "Todo"]
        ],
        destroy: true,
        ordentable: true,
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": " _START_ - _END_ de _TOTAL_ ",
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
        sDom: "B<'row'><'row'<'col-md-9'l><'col-md-2'f>r>t<'row'<'col-md-3'i>><'row'<'#colvis'>p>",
        buttons: [{
            extend: 'pdf',
            text: 'PDF'
        },
        {
            extend: 'excel',
            text: 'EXCEL'
        },
        {
            extend: 'csv',
            text: 'CSV'
        },
        {
            extend: 'print',
            text: 'Imprimir'
        },
        {
            extend: 'copy',
            text: 'Copiar'
        }
        ],
        "ajax": {
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            "method": "post",
            "url": "in/ventas/getVentasProveedor",
            "data": {
                'id_proveedor': e,
                'mesProveedor': f,
                'anho': año
            },
        },
        "columns": [{
            "data": "idUsuario"
        },
        {
            "data": "idCupon"
        },
        {
            "data": "created_at"
        },
        {
            "data": "total"
        },
        {
            "data": "idEstadoTicket"
        },
        ],
        "columnDefs": [
            {
                targets: 4,
                render: function (data, type, full, meta) {
                    console.log(data);
                    var status = {
                        1: { 'title': 'Pagado', 'class': 'kt-badge--success' },
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
}
