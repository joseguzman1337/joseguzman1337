<?php 
session_start();
/*include_once('../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);*/
 
include_once ('../EspacioFisico/templates/template.php');
$db = getBD();
 
 
?>
<div class="">
	<div id="contenidoReporteGeneral" style="">
		<h3 class="title"><font color="white">Reporte Total de la Planeación de Actividades Docentes</font></h3>
		<div class="botones" style="text-align:right;">
			<button class="buttons-menu" type="button" style="cursor:pointer;padding:8px 22px;height:auto;width:auto;" id="exportExcel">Exportar a Excel</button>
			<button class="buttons-menu" type="button" style="cursor:pointer;padding:8px 22px;height:auto;width:auto;" id="reloadReport">Actualizar Reporte</button>
		</button>
		<div id="reporteGeneral">
		<?php include("_tablaReporteGeneral.php"); ?>
		</div>
		  <form id="formInforme" style="z-index: -1; width:100%" method="post" action="../utilidades/imprimirReporteExcel.php">
			<input id="datos_a_enviar" type="hidden" name="datos_a_enviar">
		</form>
	</div>
</div>  
<script type="text/javascript">
$(document).ready(function () { 
   $('#reloadReport').click(function(e){
		<?php if(isset($_GET["iddocente"])){ ?>
			$( "#reporteGeneral" ).load( "_tablaReporteGeneral.php?iddocente="+<?php echo $_GET["iddocente"]; ?> );
		<?php } else { ?>
			$( "#reporteGeneral" ).load( "_tablaReporteGeneral.php" );
		<?php } ?>
	});
	
	$('#exportExcel').click(function(e){
        $("#datos_a_enviar").val( $("<div>").append( $("#tablaReporteGeneral").eq(0).clone()).html());
        $("#formInforme").submit();
	});
});

function popup_carga(url){        
        
            var centerWidth = (window.screen.width - 910) / 2;
            var centerHeight = (window.screen.height - 700) / 2;
    
          var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=960, height=700, top="+centerHeight+", left="+centerWidth;
          var mypopup = window.open(url,"",opciones);
          //Para que me refresque la página apenas se cierre el popup
          //mypopup.onunload = windowClose;​
          
          //para poner la ventana en frente
          window.focus();
          mypopup.focus();
          
      }
</script>