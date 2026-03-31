<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<html>
    <head>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/chosen.css">
        <script type="text/javascript" src="../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../assets/js/bootstrap.js"></script>         
        <script type="application/javascript">
          $(document).ready(function() {              
                $.ajax({
                    type: 'POST',
                    data: {action:"carreras" },
                    dataType: 'html',                    
                    url: 'funciones/funcionConsultas.php',
                    success: function(data) 
                    {
                        $("#carrera").append(data);                        
                    }
                });
              
                $.ajax({
                    type: 'POST',
                    data: {action:"periodos" },
                    dataType: 'html',                    
                    url: 'funciones/funcionConsultas.php',
                    success: function(data) 
                    {
                        $("#periodo").append(data);                        
                    }
                });
            });
                
            
            function consultarDatos()
            {
                var modalidad = $('#modalidad').val();
                var carrera = $('#carrera').val();
                var periodo = $('#periodo').val();
                $.ajax({
                    type:post,
                    data: {modalidad:modalidad, carrera:carrera, periodo:periodo, action:'consultacanceladas' },
                    url: 'funciones/funcionConsultas.php',
                    success: function(data)
                    {
                        alert(data);
                    }
                });
            }
        </script>
    </head>
    <body>
        <div class="container">
            <h2>Informe Entrevistas Canceladas</h2>
            <div class="row">
                <div class="col-md-3">
                    <label>Programa Academico</label>
                    <select id="carrera" name="carrera" >
                        <option>Seleccione</option>                        
                    </select>                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label>Periodo</label>
                     <select id="periodo" name="periodo" >
                        <option>Seleccione</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="button" id="consultar" value="consultar" name="consultar" onclick="consultarDatos()">
                </div>
            </div>
            <div class="row">
                <div id="resultad">
                    <div></div>
                </div>
            </div>
        </div>
        <div class="table" style="display:none">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Programa</th>
                        <th>Observacion</th>
                        <th>Fecha cancelada</th>
                    </tr>
                </thead>
                <tbody>
                    <div id="valores">
                    </div>
                </tbody>
            </table>
        </div>
    </body>
</html>
