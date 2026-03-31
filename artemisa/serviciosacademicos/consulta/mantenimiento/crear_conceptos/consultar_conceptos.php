<script language="JavaScript" src="../crear_materias/calendario/javascripts.js"></script>



<style type="text/css">

<!--

.Estilo1 {font-family: Tahoma; font-size: 12px}

.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }

.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}

.Estilo4 {color: #FF0000}

.AZUL {color: #0000FF;Tahoma;font-size: 14px; font-weight: bold;}

-->

</style>

<script language="JavaScript1.2">

function abrir(pagina,ventana,parametros) {

	window.open(pagina,ventana,parametros);

}

</script>



<script language="javascript">

function enviar()

{

	document.materias.submit();

}

</script>



<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');

require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');

require(realpath(dirname(__FILE__)).'/../funciones/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
?>

<?php



mysql_select_db($database_sala, $sala);

$query_sel_concepto = "SELECT * FROM concepto c where codigoestado='100' order by c.nombreconcepto asc";

$sel_concepto = mysql_query($query_sel_concepto, $sala) or die(mysql_error());

$row_sel_concepto = mysql_fetch_assoc($sel_concepto);

$totalRows_sel_concepto = mysql_num_rows($sel_concepto);





?>





<form name="materias" method="post" action="">

  <p align="center" class="Estilo3">CREAR CONCEPTOS - CONSULTAR </p>

  <table width="29%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">

    <tr>

      <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">

        <tr>

          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">

            <input name="Regresar" type="button" id="Regresar" value="Regresar" onclick="window.location.href='menu.php';">



          </div></td>

        </tr>

		</table> 

	    <?php echo "<table>";

	    do{

	    	echo "<tr>

			<td align='center' valign='bottom'>$chequear</td>

			<td colspan='2'><span class='Estilo1'>

			<a href='consultar_conceptos_detalle.php?codigoconcepto=".$row_sel_concepto['codigoconcepto']." '>".$row_sel_concepto['nombreconcepto']."</a> 

			</span>&nbsp;</td>

			</tr>

		  ";}

	    	while ($row_sel_concepto = mysql_fetch_assoc($sel_concepto));

	  ?>

        <?php  echo "</table>"?>

  </table>

  <br  />

  

 <?php if(isset($_POST['Regresar'])){

  	echo "<script language='javascript'>window.location.reload('menu.php');</script>";

  }

?>

 