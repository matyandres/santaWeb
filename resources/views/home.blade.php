@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
<script src="https://cdnjs.com/libraries/Chart.js"></script>
<div class="row">
    <div class="col-xl-6 col-lg-6 order-lg-6 order-xl-6">
        <!--begin:: Widgets/Daily Sales-->
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-widget14">
                <div class="kt-widget14__header kt-margin-b-30">
                    <h3 class="kt-widget14__title">
                        Nuevos clientes
                    </h3>
                    <span class="kt-widget14__desc">
                        Cantidad de clientes por mes de año {{ date('Y') }}
                    </span>
                </div>
                <div class="kt-widget14__chart">
                    <canvas id="chart_div" width="200%" height="100hv"></canvas>
                </div>
            </div>
        </div>
        <!--end:: Widgets/Daily Sales-->
    </div>

    <div class="col-xl-6 col-lg-6 order-lg-6 order-xl-6">
        <!--begin:: Widgets/Daily Sales-->
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-widget14">
                <div class="kt-widget14__header kt-margin-b-30">
                    <h3 class="kt-widget14__title">
                        Ventas Mensuales
                    </h3>
                    <span class="kt-widget14__desc">
                        Cantidad de ventas realizadas por mes de año {{ date('Y') }}
                    </span>
                </div>
                <div class="kt-widget14__chart">
                    <canvas id="myChart" width="200%" height="100hv"></canvas>
                </div>
            </div>
        </div>
        <!--end:: Widgets/Daily Sales-->
    </div>
    <div class="col-xl-6 col-lg-6 order-lg-6 order-xl-6">
        <!--begin:: Widgets/Daily Sales-->
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-widget14">
                <div class="kt-widget14__header kt-margin-b-30">
                    <h3 class="kt-widget14__title">
                        Gráficos historial de precio
                    </h3>
                    <span class="kt-widget14__desc">
                        Historial de precio de productos<br>
                        <br>
                    </span>
                    <div class="row justify-content-around">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Seleccione un producto</label>
                                <select name="selectProductoHistorial" id="selectProductoHistorial" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Seleccione un año</label>
                                <select name="selectAño" id="selectAño" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Seleccione un mes</label>
                                <select name="selectMes" id="selectMes" class="form-control">
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
                <div class="kt-widget14__chart">
                    <canvas id="myChart2" width="200%" height="100hv"></canvas>
                </div>
            </div>
        </div>
        <!--end:: Widgets/Daily Sales-->
    </div>
    <div class="col-xl-6 col-lg-6 order-lg-6 order-xl-6">
        <!--begin:: Widgets/Daily Sales-->
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-widget14">
                <div class="kt-widget14__header kt-margin-b-30">
                    <h3 class="kt-widget14__title">
                        Ventas de Productos
                    </h3>
                    <span class="kt-widget14__desc">
                        Cantidad de productos vendidos en el mes actual
                    </span>
                    <div class="row justify-content-around">
                         <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Seleccione un año</label>
                                <select name="selectAño" id="selectAño1" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Seleccione un mes</label>
                                <select name="selectMes" id="selectMes1" class="form-control">
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
                <div class="kt-widget14__chart">
                    <canvas id="myChart3" width="200%" height="100hv"></canvas>
                </div>
            </div>
        </div>
        <!--end:: Widgets/Daily Sales-->
    </div>
</div>

<script>
    $('li#menuHome').removeClass('kt-menu__item kt-menu__item--submenu kt-menu__item--rel');
    $('li#menuHome').addClass('kt-menu__item kt-menu__item--submenu kt-menu__item--rel');
    $('li#menuHome').addClass('kt-menu__item kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open kt-menu__item--here  kt-menu__item--open kt-menu__item--here');
    var ano = $("#selectAño1").val()
    var mes = $("#selectMes1").val();
    $("#selectMes1").change(function (e) { 
        e.preventDefault();
        mes = $("#selectMes1").val();
        ano = $("#selectAño1").val();
        cantidadVentasProducto();
    });
    $("#selectAño1").change(function (e) { 
        e.preventDefault();
        mes = $("#selectMes1").val();
        ano = $("#selectAño1").val();
        cantidadVentasProducto();
    });
    $(document).ready(function() {
        nuevosClientes();
        ventasMes();
        cantidadVentasProducto();
        //  pruebaGrafico2();
        //     pruebaGrafico3();


        getProductosPrecios();
        $('#selectProductoHistorial').select2({}).on('change', function() {
            var idProducto = $('#selectProductoHistorial').val();
            var selectAnho = $('#selectAño').val();
            var selectMes = $('#selectMes').val();
            historialPrecio(idProducto, selectAnho, selectMes);
        });
        cargarAños();

    });
    $('#selectAño').change(function(e) {
        e.preventDefault();
        var idProducto = $('#selectProductoHistorial').val();
        var selectAnho = $('#selectAño').val();
        var selectMes = $('#selectMes').val();
        historialPrecio(idProducto, selectAnho, selectMes);
    });
    $('#selectMes').change(function(e) {
        e.preventDefault();
        var idProducto = $('#selectProductoHistorial').val();
        var selectAnho = $('#selectAño').val();
        var selectMes = $('#selectMes').val();
        historialPrecio(idProducto, selectAnho, selectMes);
    });

    const cargarAños = () => {
        const fecha = new Date();
        var template = '<option value="0">Todo</option>';
        template += `<option value="${fecha.getFullYear()}">${fecha.getFullYear()}</option>`;
        var año = fecha.getFullYear();
        for (let index = 0; index < 5; index++) {
            template += `<option value="${año - 1}">${año - 1}</option>`;
            año--;
        }
        $('#selectAño').append(template);
        $('#selectAño1').append(template);
    }

    const getProductosPrecios = () => {
        $.ajax({
            type: "get",
            url: "/in/productos/getProductosPrecios",
            success: function(response) {
                if (response.response) {
                    var template = `<option value="0"> Seleccione un producto </option>`;
                    response.data.forEach(element => {
                        template += `<option value="${element.idProducto}">${element.nombre}</option>`;
                    });
                    $('#selectProductoHistorial').append(template);
                }
            }
        });
    }

    function historialPrecio(id_producto, anho, mes) {
        $.ajax({
            type: "post",
            url: "/in/productos/historialPrecioProducto",
            data: {
                'id_producto': id_producto,
                'anho': anho,
                'mes': mes
            },
            success: function(response) {
                if (response.response) {
                    precio = [];
                    fecha = [];

                    response.data.forEach(element => {
                        precio.push(element.precio);
                        fecha.push(element.created_at);
                    });
                    pruebaGrafico2(precio, fecha);
                }else{
                    pruebaGrafico2(0, 0);
                }
            }
        });
    }

    function nuevosClientes() {
        $.ajax({
            type: "get",
            url: "/in/usuario/getClientesChard",
            success: function(response) {
                cantidad = [];
                mes = [];
                
                for (let index = 1; index <= 12; index++) {
                    var push = 0;
                    response.forEach(key => {
                       
                        if(key.months == index){
                            cantidad.push(key.cantidad)
                            push = 1;
                            
                        }
                    });
                    if(push == 0){
                        cantidad.push(0)
                    }
                    
                }
               
                pruebaGrafico0(cantidad, mes);
            }
        });
    }

    function ventasMes() {
        $.ajax({
            type: "get",
            url: "/in/ventas/getVentasMes",
            success: function(response) {
                cantidad = [];
                mes = [];

                for (let index = 1; index <= 12; index++) {
                    var push = 0;
                    response.data.forEach(key => {
                       
                        if(key.months == index){
                            cantidad.push(key.cantidad)
                            push = 1;
                            
                        }
                    });
                    if(push == 0){
                        cantidad.push(0)
                    }
                    
                }
                
                

                pruebaGrafico1(cantidad, mes);
            }
        });
    }

    function cantidadVentasProducto() {
        $.ajax({
            type: "get",
            url: "/in/ventas/getVentasProducto",
            data: {
                'mes':mes,
                'ano':ano
            },
            success: function(response) {
                if(response.response){
                    cantidad = [];
                    mes = [];
                    response.data.forEach(element => {
                        cantidad.push(element.cantidad);
                        mes.push(element.nombre);
                    });
                    pruebaGrafico3(cantidad, mes);
                }else{
                    pruebaGrafico3(0, 0);
                }
            }
        });
    }

    function setearFecha(fecha) {
        switch (fecha) {
            case "01":
                return "Enero"
                break;
            case "02":
                return "Febrero"
                break;
            case "03":
                return "Marzo"
                break;
            case "04":
                return "Abril"
                break;
            case "05":
                return "Mayo"
                break;
            case "06":
                return "Junio"
                break;
            case "07":
                return "Julio"
                break;
            case "08":
                return "Agosto"
                break;
            case "09":
                return "Septiembre"
                break;
            case "10":
                return "Octubre"
                break;
            case "11":
                return "Noviembre"
                break;
            case "12":
                return "Diciembre"
                break;
        }
    }

    function pruebaGrafico0(x, z) {
        y = "chart_div";
        medida = "Clientes";
        var ctx = document.getElementById(y);
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                datasets: [{
                    label: medida,
                    data: x,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(85, 180, 220, 1)',
                        'rgba(54, 162, 235, 1)',

                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }

    function pruebaGrafico1(x, z) {
        y = "myChart";
        medida = "Ventas Mensuales";
        var ctx = document.getElementById(y);
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels:  ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                datasets: [{
                    label: medida,
                    data: x,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(85, 180, 220, 1)',
                        'rgba(54, 162, 235, 1)',

                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }

    function pruebaGrafico2(x, z) {
        /*    x = ["1", "2", "3", "4", "2"];
           z = ["a", "b", "c", "d", "e"]; */

        medida = "Precio";


        var ctx = document.getElementById('myChart2');
        if (window.grafica) {
            window.grafica.clear();
            window.grafica.destroy();
        }
        window.grafica = new Chart(ctx, {
            type: 'line',
            data: {
                labels: z,
                datasets: [{
                    label: medida,
                    data: x,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(85, 180, 220, 1)',
                        'rgba(54, 162, 235, 1)',

                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }

    function pruebaGrafico3(x, z) {
        y = "myChart3";
        medida = "Productos";
        var ctx = document.getElementById(y);
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: z,
                datasets: [{
                    label: medida,
                    data: x,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(85, 180, 220, 1)',
                        'rgba(54, 162, 235, 1)',

                    ],
                    borderWidth: 1
                }]
            },
            options: {
                /*   scales: {
                      yAxes: [{
                          ticks: {
                              beginAtZero: true
                          }
                      }]
                  } */
            }
        });
    }
</script>
@endsection