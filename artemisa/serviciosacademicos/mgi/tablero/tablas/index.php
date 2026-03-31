<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

echo "prueba ->".$controller->getTextoPrueba();
?>
Estoy en las tablas

<a href="javascript:void(0)" onclick="cargarContenido('index.php?page=caracteristicas');">Cargar detalle contenido</a>

    <select id="encuesta">
        <option value="prueba">PRUEBA</option>
    </select>
    <button id="detalleEncuesta">Consultar</button>

<script type="text/javascript">
        $('#detalleEncuesta').bind('click', function(event) {
                   cargarContenidoParametros("index.php?page=detalleEncuesta", { encuesta: $("#encuesta").val()  });
         }); 
</script>