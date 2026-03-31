<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
include_once ('../../../EspacioFisico/templates/template.php');
$db = getBD();


?>
<html>
    <head>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <title>Busqueda de Notas</title>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>    
        <script type="text/javascript" language="javascript" src="js/funcionesreportes.js"></script>
        
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
          //mypopup.onunload = windowClose;?
          
          //para poner la ventana en frente
          window.focus();
          mypopup.focus();
          
      }
</script>
    </head>
    <body>
    <div class="botones" style="text-align:right;">
			<button class="buttons-menu" type="button" style="cursor:pointer;padding:8px 22px;height:auto;width:auto;" id="exportExcel">Exportar a Excel</button>
    </button>
      <form id="formInforme" style="z-index: -1; width:100%" method="post" action="../../../utilidades/imprimirReporteExcel.php">
			<input id="datos_a_enviar" type="hidden" name="datos_a_enviar">
		</form>
     <div align="center">
        <p class="Estilo3"></p>
        <form name="form1" id="form1">
        <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
            <tr>
                <td bgcolor="#C5D5D6" class="Estilo2" align="center">
                    Periodo 
                    <select name='periodo' id='periodo'>
                        <option value='0'>Seleccione</option>";
                        <?php
                            $sqlperiodo = "select codigoperiodo from periodo order by codigoperiodo DESC";
                            $valoresperiodo = $db->execute($sqlperiodo);
                            foreach($valoresperiodo as $datosperiodo)
                            {
                            echo '<option value='.$datosperiodo['codigoperiodo'].'>'.$datosperiodo['codigoperiodo'].'</option>';
                            }
                        ?>
                        </select>
                </td>
                <td bgcolor="#C5D5D6" class="Estilo2" align="center">
                    Carrera <select name='carrera' id='carrera'>
                        <option value='0'>Seleccione</option>
                        <?php
                        $sqlcarrera = "SELECT DISTINCT nombrecarrera, codigocarrera FROM carrera WHERE codigofacultad = '05' UNION (SELECT DISTINCT nombrecarrera, codigocarrera FROM carrera WHERE codigocarrera in ('341','320','758')) ORDER BY nombrecarrera";
                        //muestra las carreras que tienen un codigo de faculta en 05 que es "Facultad Ciencias Humanas" y se agregan las carreras INGLES, curso virtual y PORTUGUES. 
                        
                        $valorescarrera = $db->execute($sqlcarrera);
                        foreach($valorescarrera as $datoscarrera)
                        {
                          echo '<option value='.$datoscarrera['codigocarrera'].'>'.$datoscarrera['nombrecarrera'].'</option>';
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center>
                    <input type="button" value="Consultar" id="consultar_bt" onclick="consultar()" />
                    </center>
                </td>
            </tr>
            <tr>
            </tr>
        </table>
        </form>
        <br />
        <div id="resultado">
            <table border="2" id="tablaReporteGeneral">
                
            </table>
        </div>
     </div>        
    </body>
</html>