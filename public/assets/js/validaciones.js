//INPUT SOLO NUMEROS
function soloNumeros(e){
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
      e.preventDefault();
    }
}
//INPUT CON MAIMO DE CARCTERES
function maximoCaracteres(e,maximo,input) {
    if(input.val().length > maximo){
        e.preventDefault();
    }
}
//GENERA DIGITO VERIFICADOR DEL RUT
function dgv(T)    //digito verificador
{  
      var M=0,S=1;
	  for(;T;T=Math.floor(T/10))
      S=(S+T%10*(9-M++%6))%11;
	  return S?S-1:'k'; 
 }

 

 function getComunas(idRegion) {    
    var data;
    $.ajax({
        type: "post",
        url: "in/util/comunas",
        data: {
            'idRegion': idRegion
        },
        dataType: "json",
        async:false,
        success: function (response) {
            data = response;
        }
    });

    return data;
     
 }


 function getRegiones() {
     var data;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "in/util/regiones",
        dataType: "json",
        async:false,
        success: function (response) {
            data = response
            
        }
    });
    return data; 
 }

 function getIdRegion(idComuna) {
    var data;
    $.ajax({
		type: "post",
		url: "in/util/getIdRegion",
		data: {
			'idComuna':idComuna
		},
        dataType: "json",
        async:false,
		success: function (response) {
			data = response;
		}
	});
     return data;
 }