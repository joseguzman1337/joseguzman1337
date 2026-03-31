<?php
/**
 * @modified Ivan Quintero <quinteroivan@unbosque.edu.do>.
 * Se modifica la estructua de consulta y se adiciona  filtros de instrumentos y categorias
 * @since Mayo 27, 2019
 */ 

session_start();

?>
    <head>
        <title>materias pendientes</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
        <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script> 
    </head>
    <body>
        <div>
            <div class="col-xs-8 col-xs-offset-2">     
                <div class="row">
                    <div class="col-xs-4 col-xs-offset-2">
                      <label for="categoria">Categoria(*):</label>
                      <select id="categoria" name="categoria"class="form-control" onchange="periodo()">
                      </select>
                    </div>
                    <div class="col-xs-4 col-xs-offset-2">
                        <label for="periodo">Periodo(*):</label>
                        <select id="periodo" name="periodo" class="form-control" onchange="instrumentos(this.value)" ></select>
                    </div>
                    <div class="col-xs-4 col-xs-offset-2">
                      <label for="instrumento">Instrumento(*):</label>
                      <select id="instrumento" name="instrumento"class="form-control" onchange="programasacademicos(this.value)"  >
                      </select>
                    </div>
                    <div class="col-xs-4 col-xs-offset-2">
                      <label for="carrera">Programa Académico(*):</label>
                      <select id="carrera" name="carrera"class="form-control" >
                      </select>
                    </div>                    
                </div>
            </div>
            <div class="col-xs-8 col-xs-offset-2" >
                <div class="row">
                    <div class="col-xs-4 col-xs-offset-2">
                        <input class="btn btn-fill-green-XL" type="button" onclick="consultardatos(1)" value="consultar">
                    </div>
                    <div class="col-xs-4 col-xs-offset-2" id="exportar">
                        <input class="btn btn-fill-green-XL" type="button" onclick="exportarExcel()" value="Exportar a Excel">
                    </div>
                </div>
            </div>
            <br>
            <div class="col-xs-4 col-xs-offset-2">
                <div id="procesando" style="display:none">
                 <img src="../../../../assets/ejemplos/img/Procesando.gif"><br>
                 <p>Procesando, por favor espere...</p>
                </div>
            </div>    
            <div class="col-xs-2 col-xs-offset-2">
            </div>
            <br>
            <div class="container">
                <div class="table-responsive" id="tabla" style="display: none"> 
                     <table id="dataR" width="80%" class="table table-bordered table-line-ColorBrandDark-headers">
                        <thead>
                            <tr id="resultadopreguntas"> 
                            </tr>
                        </thead>
                        <tbody id="resultado">
                        </tbody>
                    </table>
                </div>
            </div>    
            <form id="formInforme" style="z-index: -1;" method="post" action="../../../utilidades/imprimirReporteExcel.php">
                <input id="datos_a_enviar" type="hidden" name="datos_a_enviar">
            </form>    
        </div>
    </body>
<script type="text/javascript">
    $(document).ready(function(){
        categoria();    
    }); 

    function exportarExcel(){
        $("#datos_a_enviar").val( $("<div>").append( $("#tabla").eq(0).clone()).html());
        $("#formInforme").submit();
    }
    function iteraPag(){
        var pag = $("#pag").val();
        var totalPaginas = $("#totalPaginas").val();
        if(pag>=1 && pag<=totalPaginas-1){            
            pagina=parseInt(pag)+1;
            consultardatos(pagina);
            $("#pag").val(pagina);
        }
    }
    function desiteraPag(){        
        var pag = $("#pag").val();
        if(pag>=1){       
            pagina=parseInt(pag)-1;
            if(pagina===0){
                $("#pag").val('1');        
            }else{
                consultardatos(pagina);
                $("#pag").val(pagina);                
            }
        } 
    }

    function consultardatos(valor) {
        var carrera = $('#carrera').val();
        var periodo = $('#periodo').val();
        var instrumento = $('#instrumento').val();
        var categoria = $('#categoria').val();
        var mvalid = "";
          
        if(carrera === 0 || carrera === ''){
            mvalid+="Debe seleccionar una Carrera \n";
        }
        if(periodo === 0 || periodo === ''){
            mvalid+="Debe seleccionar un Periodo \n";
        }
        if(mvalid===""){
            $.ajax({
             type: "POST",
             dataType: "json",
             url: 'funcionesResultados.php',
             data:{action:'resultadosencuesta', carrera:carrera, periodo:periodo, instrumento:instrumento, categoria:categoria},
             beforeSend: function () {
                $('#tabla').attr("style", "display:none");
                $('#exportar').attr("style", "display:none");
                $('#procesando').attr("style", "display:inline");
             },
             success:function(data) {
                if(data.val === true){                    
                    $('#procesando').attr("style", "display:none");
                    $('#tabla').attr("style", "display:inline");
                    $('#exportar').attr("style", "display:inline");
                    $('#resultadopreguntas').html(data.preguntas);
                    $('#resultado').html(data.tabla);
                }else{
                    $('#procesando').attr("style", "display:none");
                    $('#tabla').attr("style", "display:inline");
                    $('#resultado').html(data.tabla);
                }
            }
          });
        }else{
            alert(mvalid);
        }
    }
    
    function programasacademicos(valor){  
        var valor = valor;
        $.ajax({
        type: 'POST',
        url: 'funcionesResultados.php',
        dataType: "html",
        data: {action:'Consultaprogramas', valor:valor},
        success: function (data) {            
            $('#carrera').html(data);
        },
        error: function (data, error)
        {
          alert("Error en la consulta de los datos.");
        }
        });
    }//funtion programasacademicos   

    function periodo(){  
        $.ajax({
        type: 'POST',
        url: 'funcionesResultados.php',
        dataType: "html",
        data: {action:'Consultaperiodo'},
        success: function (data) {
            $('#periodo').html(data);
        },
        error: function (data, error)
        {
          alert("Error en la consulta de los datos.");
        }
        });
    }//funtion periodo  
    
    function categoria(){  
        $.ajax({
        type: 'POST',
        url: 'funcionesResultados.php',
        dataType: "html",
        data: {action:'Consultacategoria'},
        success: function (data) {
            $('#categoria').html(data);
        },
        error: function (data, error)
        {
          alert("Error en la consulta de los datos.");
        }
        });
    }//funtion categoria  
    
    function instrumentos(periodo){
        var periodo = periodo;
        var categoria = $('#categoria').val();        
        $.ajax({
        type: 'POST',
        url: 'funcionesResultados.php',
        dataType: "html",
        data: {action:'Consultainstrumentos', categoria:categoria, periodo:periodo},
        success: function (data) {
            $('#instrumento').html(data);
        },
        error: function (data, error)
        {
          alert("Error en la consulta de los datos.");
        }
        });
    }//funtion categoria  
</script>