<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<html>
    <head>
        <title>ECAES CARGAR</title>
        <script type='text/javascript' language="javascript" src="../../../../js/jquery.js"></script>        
        <script type='text/javascript' language="javascript" src="../../../../js/jquery-1.9.1.js"></script> 
    </head>
    <body>
        <nav>
            <center><h1>Cargar resultados prueba de estado Ecaes</h1></center>
        </nav>
        <section>
            <center>  
            <fieldset style="width: 30%;">
            <article>  
                <form id="form" name="form" enctype="multipart/form-data" >                    
                    <input type="file" name="archivo" id="archivo" onchange="Limpiartabla();">
                    <br>
                    <input type="button" id="cargar" name="cargar" value="cargar">
                </form>
            </article>    
            </fieldset>
            </center>
        </section>
        <section>
            <center>
            <fieldset style="width:30%;">
            <article>
                <a href="tmp/plantillaEcaes.xls">Formato para carga de ECAES.</a>
            </article>
            </fieldset>
            </center>
        </section>
        <section>
            <center>
            <div id="tabla">
              </div>
            </center>
        </section>
    </body>
</html>
<script>
    $(document).ready(function()
    {
        $(':button').click(function(){ 
            var formdata = new FormData($("#form")[0]);
            formdata.append('action','v4l1d4r');
            
            $.ajax({
            type: 'post',
            datatype: 'json',
            cache: false,
            contentType: false,
            processData: false,
            url: 'VerificarDatosEcaes.php',
            data:formdata,
            success:function(data)
            {    
                var datos = JSON.parse(data);
                if (datos.success == true)
                {
                   alert(datos.message);
                }else
                {
                    alert(datos.message);                    
                    $('#tabla').append(datos.tabla);
                }
            }
            });
        });
    });
    function Limpiartabla()
    {
        $('#tabla').html(""); 
    }
    function mostrar(numero)
    {
        $.ajax({
            type:'post',
            datatype:'json',
            url: 'VerificarDatosEcaes.php',
            data: {action:'m0str4r',numero:numero},
            success: function (data)
            {
                 var datos = JSON.parse(data);
                if (datos.success == true)
                {
                    $('#tabla').html(""); 
                    $('#tabla').append(datos.tabla);    
                }
            }
        });
    }
</script>