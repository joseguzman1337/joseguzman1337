<?php
/**
 * @created Ivan Quintero <quinteroivan@unbosque.edu.do>.
 * Permite al estudiante genrar el certificado de su participacion de encuestas
 * @since Junio 10 2019
 */
session_start();
//echo '<pre>', print_r($_SESSION);
?>
<head>
    <title>Certificado Estudiante</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
    <script type="text/javascript" src="../../../../assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="../../../../assets/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $_SESSION["idusuario"];?>">
        <input type="hidden" name="codigocarrera" id="codigocarrera" value="<?php echo $_SESSION["idCarrera"];?>">
        <div class="row">
            <div class="col-md-5">
                <label for="periodo">Periodo(*):</label>
                <select id="codigoperiodo" name="codigoperiodo"  class="form-control" onchange="categoria(this.value)">
                </select>
            </div>
            <div class="col-xs-4 col-xs-offset-2">
                <label for="categoria">Categoria(*):</label>
                <select id="categoria" name="categoria"class="form-control" onchange="instrumentos(this.value)">
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <label for="instrumento">Instrumento(*):</label>
                <select id="instrumento" name="instrumento"class="form-control">
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <input class="btn btn-fill-green-XL" type="button" onclick="consultardatos()" value="consultar resultados">
            </div>
        </div>
        <div class="col-xs-4 col-xs-offset-2">
            <div id="procesando" style="display:none">
                <img src="../../../../assets/ejemplos/img/Procesando.gif"><br>
                <p>Procesando, por favor espere...</p>
            </div>
        </div>
        <br>
        <div class="table-responsive" id="tablaparticipacion" style="display: none">
            <table class="table table-borderless">
                <thead>
                <tr>
                    <th>CERTIFICADO DE PARTICIPACION </th>
                </tr>
                </thead>
                <tbody id="resultadoparticipante">
                </tbody>
            </table>
            <img src='../../../../imagenes/ico_print.jpg' width='58' height='52' onClick='print()'>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        periodo();
    });

    function periodo(){
        $.ajax({
            type: 'POST',
            url: 'funcionesResultados.php',
            dataType: "html",
            data: {action:'Consultaperiodo'},
            success: function (data) {
                $('#codigoperiodo').html(data);
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

    function instrumentos(categoria){
        var periodo = $('#codigoperiodo').val();
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
    }//instrumentos


    function consultardatos(valor) {
        var idusuario = $('#idusuario').val();
        var carrera = $('#codigocarrera').val();
        var periodo = $('#codigoperiodo').val();
        var instrumento = $('#instrumento').val();
        var categoria = $('#categoria').val();
        var mvalid = "";

        if(instrumento === '0' || instrumento === '' || instrumento === 0){
            mvalid+="Debe seleccionar una Carrera \n";
        }
        if(periodo === 0 || periodo === '' || periodo === '0'){
            mvalid+="Debe seleccionar un Periodo \n";
        }
        if(categoria === 0 || categoria === '' || categoria === '0'){
            mvalid+="Debe seleccionar un Periodo \n";
        }
        if(mvalid===""){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: 'funcionesResultados.php',
                data:{action:'participacionestudiante', carrera:carrera, periodo:periodo, instrumento:instrumento, categoria:categoria, idusuario:idusuario},
                beforeSend: function () {
                    $('#tablaparticipacion').attr("style", "display:none");
                    $('#procesando').attr("style", "display:inline");
                },
                success:function(data) {
                    if(data.val === true){
                        $('#procesando').attr("style", "display:none");
                        $('#tablaparticipacion').attr("style", "display:inline");
                        $('#resultadoparticipante').html(data.tabla);
                    }else{
                        $('#procesando').attr("style", "display:none");
                        $('#tablaparticipacion').attr("style", "display:inline");
                        $('#resultadoparticipante').html(data.tabla);
                    }
                }
            });
        }else{
            alert(mvalid);
        }
    }
</script>