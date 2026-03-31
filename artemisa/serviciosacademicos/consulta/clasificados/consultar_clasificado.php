<?php
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);  

require_once('conexion_clasificados.php');
require_once('validar_datos.php');
error_reporting(2047);

mysql_select_db($database_clasificados,$clasificados);
$query_clasificado = "SELECT * FROM clasificado where idclasificado='".$_GET['idclasificado']."'";
$obtener_clasificado = mysql_query($query_clasificado,$clasificados) or die(mysql_error());
$row_obtener_clasificado = mysql_fetch_assoc($obtener_clasificado);
$num_rows_obtener_clasificado = mysql_num_rows($obtener_clasificado);
//print_r($_POST);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>CONSULTAR CLASIFICADO</title>
<style type="text/css">
<!--
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo5 {color: #F7BC6C }
.Estilo6 {color: #003768}
.Estilo11 {
	font-family: "Square721 Ex BT";
	color: #003768;
}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="">
  <div align="center">
    <table border="1" bordercolor="#F7BC6C" cellspacing="0">
	  <tr>
	  	<td><h3 align="center" class="Estilo11">CONSULTAR CLASIFICADO</h3></td>
	  </tr>
      <tr>
        <td><table  border="0" cellpadding="5" cellspacing="4" align="center" >
            <tr>
			  <?php
			  		if($_GET['archivo'] != "palabra"){
						$accion=$_GET['accion'];
						//echo "ACCION ",$accion;
					}
					$tipoclasificado=$_GET['tipoclasificado'];
					$archivo=$_GET['archivo'];
					/*echo "TIPO ",$tipoclasificado;
					echo "ARCHIVO ",$archivo;*/
			  ?>
              <td><div align="left" class="Estilo11">Titulo</div></td>
              <td><div align="left" class="Estilo11">
                  <?php echo $row_obtener_clasificado['tituloclasificado']?>
              </div></td>
            </tr>
            <tr>
              <td><div align="left" class="Estilo11">Descripcion</div></td>
              <td><div align="left" class="Estilo11">
                <textarea name="txtDescripcion"  readonly cols="39" rows="5" id="txtDescripcion" class="Estilo11"><?php echo $row_obtener_clasificado['descripcionclasificado']?>
				</textarea>
				</div></td>
            </tr>
            <tr>
              <td ><div align="left" class="Estilo11">Informes</div></td>
              <td><div align="left" class="Estilo11">
                  <?php echo $row_obtener_clasificado['informesclasificado']?>
              </div></td>
            </tr>
            <tr>
              <td><div align="left" class="Estilo11">Fecha Publicacion </div></td>
              <td><div align="left" class="Estilo11">
                 <?php echo $row_obtener_clasificado['fechapublicacionclasificado']?>
				 </div></td>
            </tr>
            <tr>
              <td><div align="left" class="Estilo11">Fecha Vencimiento </div></td>
              <td><div align="left" class="Estilo11">
                  <?php echo $row_obtener_clasificado['fechavencimientoclasificado']?>
                  </div></td>
            </tr>
            <tr>
              <td align="center"><div align="right">
              </div></td>
              <td align="center">
                <div align="left">
                  <input name="btnRegresar" type="submit" id="btnRegresar" value="Regresar">
                  </div></td>
			</tr>
        </table></td>
      </tr>
    </table>
  </div>
  <p align="center">&nbsp;</p>
</form>
</body>
</html>

<?php 
	if(isset($_POST['btnRegresar'])){
		if($archivo == "tipo"){
				echo "<script language='javascript'>window.close();</script>";
		}
		if($archivo == "palabra"){
				echo "<script language='javascript'>window.close();</script>";
		}
 	}
?>
