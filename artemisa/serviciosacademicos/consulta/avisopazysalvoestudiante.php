<?php  require_once('../Connections/sala2.php');
//$GLOBALS['codigo'];
//session_start();
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once('encabezado.php'); 
$codigoestudiante=$_SESSION['codigo'];
//echo "<br>".$_SESSION['codigoperiodosesion'];
if(isset($_GET['codigoest']))
{
	$codigoestudiante = $_GET['codigoest'];
}

//$fecha = date("Y-m-d G:i:s",time());
mysql_select_db($database_sala, $sala);
$query_valida = "SELECT *
				 FROM detallepazysalvoestudiante dp,carrera c,estadopazysalvoestudiante e,
				 tipopazysalvoestudiante t,pazysalvoestudiante p,estudiante es
				 WHERE dp.codigotipopazysalvoestudiante = t.codigotipopazysalvoestudiante
				 AND dp.idpazysalvoestudiante=p.idpazysalvoestudiante
				 AND p.codigocarrera = c.codigocarrera
				 AND dp.codigoestadopazysalvoestudiante = e.codigoestadopazysalvoestudiante 
				 AND es.idestudiantegeneral = p.idestudiantegeneral
				 AND es.codigoestudiante = '$codigoestudiante'
				 AND dp.codigoestadopazysalvoestudiante LIKE '1%'
				 ORDER BY dp.fechainiciodetallepazysalvoestudiante ASC";
$valida = mysql_query($query_valida, $sala) or die(mysql_error());
$row_valida = mysql_fetch_assoc($valida);
$totalRows_valida = mysql_num_rows($valida);	
  if ($row_valida <> "")
  {//validadocente
 ?>
<style type="text/css">
<!--
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {
	color: #990000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Estilo5 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
 <form name="form1" method="post" action="avisodocumentacionestudiante.php">
<table width="60%"  border="3" bordercolor="#003333">
  <tr>
 
    <td><p align="center" class="Estilo3 Estilo4">USTED TIENE DEUDAS ADMINISTRATIVAS Y/O ACAD&Eacute;MICAS:</p>
      <p align="center" class="Estilo2">Por favor ac&eacute;rquese al &aacute;rea respectiva.</p>
      <table width="100%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#003333">
      <tr class="Estilo2">
        <td align="center" bgcolor="#C5D5D6" class="Estilo5">Fecha Registro</td>
        <td align="center" bgcolor="#C5D5D6" class="Estilo5">&Aacute;rea</td>
        <td align="center" bgcolor="#C5D5D6" class="Estilo5">Tipo</td>
        <td align="center" bgcolor="#C5D5D6" class="Estilo5">Descripci&oacute;n</td>        
      </tr>
            <?php 
		do{
                $nombrearea = $row_valida["nombrecarrera"];
				$nombretipo = $row_valida["nombretipopazysalvoestudiante"];
				$descripcion = $row_valida["descripciondetallepazysalvoestudiante"];				
				$fecha = $row_valida["fechainiciodetallepazysalvoestudiante"];;
				echo '<tr>					
					<td><div align="center" class="Estilo1">'.$fecha.'&nbsp;</div></td>
					<td><div align="center" class="Estilo1">'.$nombrearea.'&nbsp;</div></td>					
					<td><div align="center" class="Estilo1">'.$nombretipo.'&nbsp;</div></td>
					<td><div align="center" class="Estilo1">'.$descripcion.'&nbsp;</div></td>
					</tr>';		
		}while ($row_valida = mysql_fetch_assoc($valida));	
		?>
       </table>
       
      <p align="center" class="Estilo2 Estilo4">Recuerde que al no estar a paz y salvo con la(s) &aacute;rea(s) mencionadas anteriormente, NO le ser&aacute; entregada la orden de pago del pr&oacute;ximo semestre.</p></td>
  </tr>
</table>

 
    <div align="center"></div>
   <?php
if(!isset($_GET['prema']))
{
?>
    <div align="left">
  <input name="Aceptar" type="submit" id="Aceptar" value="Continuar"> 
  <?php
}
else
{
?>
       <input name="Aceptar" type="button" id="Aceptar" value="Cerrar" onClick="window.close()"> 
      <?php
}
?>
&nbsp;
      </div>
 </form>
<?php 
 }
else
{
   if(!isset($_GET['prema']))
	{
	//echo "ENTRE HABER";
	//exit();
		 echo "<script language='javascript'>
		 		//alert('Usted no tiene permiso para entrar a esta opcion');
	   			document.location.href='avisodocumentacionestudiante.php';
	 	  </script>";

	//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=avisodocumentacionestudiante.php'>";
	}
}
?>
