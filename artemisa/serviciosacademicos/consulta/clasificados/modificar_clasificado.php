<?php
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
?>
<script language="javascript">
function recargar(dir) 
{
	window.location.reload("modificar_clasificado.php"+dir);
}
</script>
<?php
require_once('../../Connections/conexion_clasificados.php');
require_once('validar_datos.php');
error_reporting(2047);

mysql_select_db($database_clasificados,$clasificados);
$query_clasificado = "SELECT * FROM clasificado WHERE idclasificado='".$_GET['idclasificado']."'";
$obtener_clasificado = mysql_query($query_clasificado,$clasificados) or die(mysql_error());
$row_obtener_clasificado = mysql_fetch_assoc($obtener_clasificado);
$num_rows_obtener_clasificado = mysql_num_rows($obtener_clasificado);

mysql_select_db($database_clasificados,$clasificados);
$query_obtener_tipos_clasificados = "SELECT idtipoclasificado,nombretipoclasificado FROM tipoclasificado ORDER BY nombretipoclasificado";
$obtener_tipos_clasificados = mysql_query($query_obtener_tipos_clasificados,$clasificados);
//$row_obtener_tipos_clasificados = mysql_fetch_assoc($obtener_tipos_clasificados);

mysql_select_db($database_clasificados,$clasificados);
$query_obtener_prioridad_clasificado = "SELECT idprioridadclasificado,nombreprioridadclasificado FROM prioridadclasificado";
$obtener_prioridad_clasificado = mysql_query($query_obtener_prioridad_clasificado,$clasificados);
//print_r($_GET);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>MODIFICAR CLASIFICADO</title>
<style type="text/css">
<!--
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo5 {color: #F7BC6C}
.Estilo6 {color: #003768}
.Estilo11 {
	font-family: "Square721 Ex BT";
	color: #003768;
}
-->
</style>
</style>
</head>
<body>
<form name="form1" method="post" action="">
  <div align="center">
    <table border="1" bordercolor="#F7BC6C" cellspacing="0">
	  <tr>
	  	<td><h3 align="center" class="Estilo11">MODIFICAR CLASIFICADO</h3></td>
	  </tr>
	  <?php
			$tipoclasificado=$_GET['tipoclasificado'];
			$fechaD=$_GET['fechaD'];
			$fechaH=$_GET['fechaH'];
			$idclasificado=$_GET['idclasificado'];
			//echo $_GET['tipoclasificado'];
			$dir = "?tipo=$tipoclasificado&fechaD=$fechaD&fechaH=$fechaH";
			//echo $dir;
	  ?>
      <tr>
        <td><table  border="0" cellpadding="5" cellspacing="4" align="center" >
            <tr>
              <td><div align="left" class="Estilo11">Titulo</div></td>
              <td colspan="2"><div align="left">
                  <input name="txtTitulo" class="Estilo11" type="text" id="txtTitulo" size="50" value="<?php echo $row_obtener_clasificado['tituloclasificado']?>">
              </div></td>
            </tr>
            <tr>
              <td><div align="left" class="Estilo11">Descripcion</div></td>
              <td colspan="2"><div align="left">
                  <textarea name="txtDescripcion" class="Estilo11" cols="39" rows="5" id="txtDescripcion"><?php echo $row_obtener_clasificado['descripcionclasificado']?>
				  </textarea>
              </div></td>
            </tr>
            <tr>
              <td><div align="left" class="Estilo11">Informes</div></td>
              <td colspan="2"><div align="left">
                  <input name="txtInformes" class="Estilo11" type="text" id="txtInformes" size="50" value="<?php echo $row_obtener_clasificado['informesclasificado']?>" >
              </div></td>
            </tr>
            <tr>
              <td><div align="left" class="Estilo11">Tipo del Clasificado </div></td>
              <td colspan="2"><div align="left">
                  <select name="cbTipo" id="cbTipo">
                    <option class="Estilo11">Seleccionar</option>
                    <?php
		  			/********METODO PARA OBTENER DATOS DE LA BD PARA COLOCARLOS EN COMBO BOX***********/
		  			while($row_obtener_tipos_clasificados = mysql_fetch_assoc($obtener_tipos_clasificados)){
					?>
                    	<option value="<?php echo $row_obtener_tipos_clasificados['idtipoclasificado']?>"
		  				<?php 
						if($row_obtener_clasificado['idtipoclasificado'] == $row_obtener_tipos_clasificados['idtipoclasificado']){
							echo 'selected';
						}?> class="Estilo11"> 
						<?php echo $row_obtener_tipos_clasificados['nombretipoclasificado']?> </option>
	               	<?php 
					}?>
                  </select>
              </div></td>
            </tr>
            <tr>
              <td><div align="left" class="Estilo11">Prioridad del Clasificado</div></td>
              <td colspan="2"><div align="left">
                  <select name="cbPrioridad" id="cbPrioridad">
				  	<option class="Estilo11">Seleccionar</option>
                    <?php 
		  			/******METODO PARA OBTENER DATOS DE LA BD PARA COLOCARLOS EN COMBO BOX*********/
				  	while($row_obtener_prioridad_clasificado = mysql_fetch_assoc($obtener_prioridad_clasificado)){
				 	?>
                    	<option value="<?php echo $row_obtener_prioridad_clasificado['idprioridadclasificado']?>"
		  				<?php 
		  	  			if($row_obtener_clasificado['idprioridadclasificado'] == $row_obtener_prioridad_clasificado['idprioridadclasificado']){
							echo 'selected';
						}
						?> class="Estilo11"> 
						<?php echo $row_obtener_prioridad_clasificado['nombreprioridadclasificado'] ?> </option>
                    <?php 
					}?>
                  </select>
              </div></td>
            </tr>
            <tr>
              <td><div align="left" class="Estilo11">Fecha Publicacion </div></td>
              <td colspan="2"><div align="left">
                  <input name="txtFechaPublicacion" class="Estilo11" type="text" id="txtFechaPublicacion" 
				  value="<?php 
				  if(isset($_GET['fechapublica'])){
				  	echo $_GET['fechapublica'];
				  }else{
				  	echo $row_obtener_clasificado['fechapublicacionclasificado'];
				  }				  
				  ?>">
                  <span class="Estilo11">aaaa-mm-dd </span></div></td>
            </tr>
            <tr>
              <td><div align="left" class="Estilo11">Fecha Vencimiento </div></td>
              <td colspan="2"><div align="left">
                  <input name="txtFechaVencimiento" class="Estilo11" type="text" id="txtFechaVencimiento" 
				  value="<?php 
				  if(isset($_GET['fecha_correcta_vence'])){
				  		echo $_GET['fecha_correcta_vence'];
				  }else{
				  	echo $row_obtener_clasificado['fechavencimientoclasificado'];
				  }?>">
                  <span class="Estilo11">                  aaaa-mm-dd </span></div></td>
            </tr>
			
            <tr>
              <td align="center"><div align="right">
                  <input name="btnModificar" type="submit" id="btnModificar" value="Modificar">
              </div></td>
              <td align="center"><input name="btnRegresar" type="submit" id="btnRegresar" value="Regresar"></td>
            </tr>
			
        </table></td>
      </tr>
    </table>
  </div>
  </form>
</body>
</html>
<?php 
	if( isset($_POST['btnModificar']) ){	
		mysql_select_db($database_clasificados,$clasificados);
		$query_obtener_numero_dias_tipo = "SELECT diasmaximotipoclasificado FROM tipoclasificado WHERE idtipoclasificado=".$_POST['cbTipo']."";
		$obtener_numero_dias_tipo = mysql_query($query_obtener_numero_dias_tipo,$clasificados);
		$row_obtener_numero_dias_tipo = mysql_fetch_assoc($obtener_numero_dias_tipo);
		//echo "Luego de oprimir el Boton Crear  ","<br>";
		$numDias = $row_obtener_numero_dias_tipo['diasmaximotipoclasificado'];
		/***********************VALIDACION DE LOS DATOS DATSO DEL FORMULARIO*************************************/		
		$fecha_clasificado = date("Y-m-d");
		$valida_titulo_clasificado = validar($_POST['txtTitulo'],"requerido",'<script language="javascript">alert("No ha Digitado el Titulo del Clasificado")</script>', true);
		$valida_descripcion_clasificado = validar($_POST['txtDescripcion'],"requerido",'<script language="javascript">alert("No ha Digitado la Descripcion del clasificado")</script>',true);
		$valida_informes_clasificado = validar($_POST['txtInformes'],"requerido",'<script language=""javascript">alert("No ha Digitado Informes")</script>',true);
		$valida_tipo_clasificado = validar($_POST['cbTipo'],"requerido",'<script language=""javascript">alert("No ha Seleccionado el Tipo de Clasificado")</script>',true);
		$valida_prioridad_clasificado = validar($_POST['cbPrioridad'],"requerido",'<script language=""javascript">alert("No ha Seleccionado la Prioridad del Clasificado")</script>',true);
		$valida_fecha_publica_clasificado = validar($_POST['txtFechaPublicacion'],"requerido",'<script language=""javascript">alert("No ha Digitado la Fecha de Publicacion del Clasificado")</script>',true);
		$valida_fecha_vence_clasificado = validar($_POST['txtFechaVencimiento'],"requerido",'<script language=""javascript">alert("No ha Digitado la Fecha de Vencimiento del Clasificado")</script>',true);
		//echo "Continuidad fechas","<br>";
		$valida_fecha_publica_vence = validadosfechas($_POST['txtFechaPublicacion'],$_POST['txtFechaVencimiento'],'mayor','<script language="JavaScript">alert("La Fecha de Vencimiento no debe ser menor que la Fecha de Publicacion ")</script>',true);
		//echo "Mira si es fecha","<br>";
		$valida_es_fecha_publica = validar($_POST['txtFechaPublicacion'],"fecha",'<script language="javascript">alert("La Fecha de Publicacfion no fue digitada correctamente. El Formato de Fecha es aaaa/mm/dd")</script>',true);
		$valida_es_fecha_vence = validar($_POST['txtFechaVencimiento'],"fecha",'<script language="javascript">alert("La Fecha de Vencimiento no fue digitada correctamente. El Formato de Fecha es aaaa/mm/dd")</script>',true);
		//echo "Mayor que hoy","<br>";
		$valida_fecha_mayor_publica = validar($_POST['txtFechaPublicacion'],"fechamayor",'<script language="javascript">alert("La Fecha de Publicacfion debe ser mayor o igual que la Fecha de hoy")</script>',true); 
		$valida_fecha_mayor_vence = validar($_POST['txtFechaVencimiento'],"fechamayor",'<script language="javascript">alert("La Fecha de Vencimiento debe ser mayor o igual que la Fecha de hoy")</script>',true);;		
		//echo "Número de Dias Clasificado deb ser Publicado";
		$fecha_correcta_vence = obtenerFechaVence($_POST['txtFechaPublicacion'],$_POST['txtFechaVencimiento'],$numDias);
		//echo "FECHA CORRECTA VENCE ",$fecha_correcta_vence,"<br>";
		$valida_fechas_publicacion = validarPublicacion($_POST['txtFechaPublicacion'],$_POST['txtFechaVencimiento'],$numDias,'<script language="javascript">alert("La diferencia entre las fechas debe ser '.$numDias.' de dias")</script>',true);
		$fechapublica=$_POST['txtFechaPublicacion'];		
		//echo "FECHA Publicacion ",$fechapublica,"<br>";
								
		if($valida_titulo_clasificado == true and $valida_descripcion_clasificado == true and
		   $valida_informes_clasificado == true and $valida_tipo_clasificado == true and
		   $valida_prioridad_clasificado == true and $valida_fecha_publica_clasificado == true and
		   $valida_fecha_mayor_publica == true and $valida_fecha_vence_clasificado == true and
		   $valida_es_fecha_publica == true and $valida_es_fecha_vence == true and
		   $valida_fecha_mayor_vence == true and $valida_fecha_publica_vence ==true and
		   $valida_fechas_publicacion == true){
			//echo "al pelo REGISTRO VALIDO";
			$query_actualizar_clasificado=
			"UPDATE clasificado SET fechaclasificado='".$fecha_clasificado."',fechapublicacionclasificado='".$_POST['txtFechaPublicacion']."',
			fechavencimientoclasificado='".$_POST['txtFechaVencimiento']."',tituloclasificado='".$_POST['txtTitulo']."',
			descripcionclasificado='".$_POST['txtDescripcion']."',informesclasificado='".$_POST['txtInformes']."',
			idtipoclasificado='".$_POST['cbTipo']."',idprioridadclasificado='".$_POST['cbPrioridad']."' 
			WHERE idclasificado='".$row_obtener_clasificado['idclasificado']."'";
			//echo $query_actualizar_clasificado,"<br>";
			$actualizar_clasificado = mysql_query($query_actualizar_clasificado,$clasificados) or die (mysql_error());
			if($actualizar_clasificado){
				echo "<script language='javascript'>alert('El clasificado fue modificado satisfactoriamente');</script>";	
				echo '<script language="javascript">
				window.opener.recargar("'.$dir.'");
				window.opener.focus();
				window.close();</script>';
			}
  			else{
  				echo mysql_error();
	  		}
  		}
		else{
			$dirnuevo="?tipoclasificado=$tipoclasificado&idclasificado=$idclasificado&fechaD=$fechaD&fechaH=$fechaH&fecha_correcta_vence=$fecha_correcta_vence&fechapublica=$fechapublica";
  			echo "<script language='javascript'>window.recargar('".$dirnuevo."');</script>";
	  	}
	}
?>
<?php if(isset($_POST['btnRegresar'])){
			echo "<script language='javascript'>window.close();</script>";
	  }
?>
