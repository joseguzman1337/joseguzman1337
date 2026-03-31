<?php
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);  

require_once('../../Connections/conexion_clasificados.php');
require_once('validar_datos.php');
//error_reporting(2047);
/*****************CREACION DE LOS QUERIES PARA LA APLICACION*******************/
mysql_select_db($database_clasificados,$clasificados);
$query_obtener_clasificados = "SELECT * FROM clasificado";
$obtener_clasificados = mysql_query($query_obtener_clasificados,$clasificados);
$row_obtener_clasificado = mysql_fetch_assoc($obtener_clasificados);

mysql_select_db($database_clasificados,$clasificados);
$query_obtener_tipos_clasificados = "SELECT idtipoclasificado,nombretipoclasificado FROM tipoclasificado ORDER BY nombretipoclasificado";
$obtener_tipos_clasificados = mysql_query($query_obtener_tipos_clasificados,$clasificados);
//$row_obtener_tipos_clasificados = mysql_fetch_assoc($obtener_tipos_clasificados);

mysql_select_db($database_clasificados,$clasificados);
$query_obtener_prioridad_clasificado = "SELECT idprioridadclasificado,nombreprioridadclasificado FROM prioridadclasificado ORDER BY ubicacionprioridadclacificado";
$obtener_prioridad_clasificado = mysql_query($query_obtener_prioridad_clasificado,$clasificados);
//print_r($_POST);
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>CREAR CLASIFICADO</title>
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
</head>

<body>
<form name="form1" method="post" action="">
  <div align="center">
   <table border="1" bordercolor="#F7BC6C" cellspacing="0">
   <tr>
   		<td><h3 align="center" class="Estilo11">CREAR CLASIFICADO</h3></td>
   </tr>
   <tr><td>
    <table  border="0" cellpadding="5" cellspacing="4" align="center" >
      <tr>
	  	<?php /*echo $_GET['regreso'];*/?>
        <td><div align="left" class="Estilo11">Titulo</div></td>
        <td colspan="2"><div align="left">
          <input name="txtTitulo" type="text" id="txtTitulo" size="50" class="Estilo11">
        </div></td>
      </tr>
      <tr>
        <td><div align="left" class="Estilo11">Descripcion</div></td>
        <td colspan="2"><div align="left">
          <textarea name="txtDescripcion" cols="39" rows="5" id="txtDescripcion"class="Estilo11"></textarea>
        </div></td>
      </tr>
      <tr>
        <td><div align="left" class="Estilo11">Informes</div></td>
        <td colspan="2"><div align="left">
          <input name="txtInformes" type="text" id="txtInformes" size="50" class="Estilo11">
        </div></td>
      </tr>
      <tr>
        <td><div align="left" class="Estilo11">Tipo del Clasificado </div></td>
        <td colspan="2"><div align="left">
		<select name="tipoclasificado" id="tipoclasificado">
		  <option value="" class="Estilo11">Seleccionar</option>
		  <?php
		  /**************METODO PARA OBTENER DATOS DE LA BD PARA COLOCARLOS EN COMBO BOX*******************/
		  	while($row_obtener_tipos_clasificados = mysql_fetch_assoc($obtener_tipos_clasificados)){
		  ?>
		  <option value="<?php echo $row_obtener_tipos_clasificados['idtipoclasificado']?>" 
		  	<?php 
				if(@$_GET['tipoclasificado']==$row_obtener_tipos_clasificados['idtipoclasificado']){
					echo 'selected';
				}?> class="Estilo11"> 
			<?php echo $row_obtener_tipos_clasificados['nombretipoclasificado']?>
		  </option>
          <?php } /******************METODO PARA OBTENER DATOS**********/ ?>
		  </select>
        </div></td>
      </tr>
      <tr>
        <td><div align="left" class="Estilo11">Prioridad del Clasificado</div></td>
		<td colspan="2"><div align="left">
		  <select name="cbPrioridad" id="cbPrioridad">
		  <option value="" class="Estilo11">Seleccionar</option>
		  <?php 
		  	/**************METODO PARA OBTENER DATOS DE LA BD PARA COLOCARLOS EN COMBO BOX*******************/
		  	while($row_obtener_prioridad_clasificado = mysql_fetch_assoc($obtener_prioridad_clasificado)){
		  ?>
		  <option value="<?php echo $row_obtener_prioridad_clasificado['idprioridadclasificado'] ?>"
		  <?php 
		  	  if(@$_POST['cbPrioridad']==$row_obtener_prioridad_clasificado['idprioridadclasificado']){
					echo 'selected';
			  }
		  ?> class="Estilo11"> 
		  <?php echo $row_obtener_prioridad_clasificado['nombreprioridadclasificado'] ?>
		  </option>
		  <?php } /******************METODO PARA OBTENER DATOS**********/?>
		  </select>
        </div></td>
      </tr>
      
      <tr>
        <td align="center">
          <div align="right">
            <input name="btnCrear" type="submit" id="btnCrear" value="Crear">        
          </div></td>
        <td align="center"><input name="btnRegresar" type="submit" id="btnRegresar" value="Regresar"></td>
      </tr>
    </table>
	</td></tr>
	</table>
  </div>
  <p align="center">&nbsp;</p>
  <p>&nbsp;</p>
</form>
<p align="center">&nbsp; </p>
</body>
</html>


<?php
	if( isset($_POST['btnCrear']) ){
		
		mysql_select_db($database_clasificados,$clasificados);
		$query_obtener_numero_dias_tipo = "SELECT diasmaximotipoclasificado FROM tipoclasificado WHERE idtipoclasificado=".$_POST['tipoclasificado']."";
		$obtener_numero_dias_tipo = mysql_query($query_obtener_numero_dias_tipo,$clasificados);
		$row_obtener_numero_dias_tipo = mysql_fetch_assoc($obtener_numero_dias_tipo);
		//echo "Luego de oprimir el Boton Crear  ","<br>";
		$numDias = $row_obtener_numero_dias_tipo['diasmaximotipoclasificado'];
		/***********************VALIDACION DE LOS DATOS DATSO DEL FORMULARIO*************************************/		
		$fecha_clasificado = date("Y-m-d");
		$fecha = "2999-12-31";
		$valida_titulo_clasificado = validar($_POST['txtTitulo'],"requerido",'<script language="javascript">alert("No ha Digitado el Titulo del Clasificado")</script>', true);
		$valida_descripcion_clasificado = validar($_POST['txtDescripcion'],"requerido",'<script language="javascript">alert("No ha Digitado la Descripcion del clasificado")</script>',true);
		$valida_informes_clasificado = validar($_POST['txtInformes'],"requerido",'<script language=""javascript">alert("No ha Digitado Informes")</script>',true);
		$valida_tipo_clasificado = validar($_POST['tipoclasificado'],"requerido",'<script language=""javascript">alert("No ha Seleccionado el Tipo de Clasificado")</script>',true);
		$valida_prioridad_clasificado = validar($_POST['cbPrioridad'],"requerido",'<script language=""javascript">alert("No ha Seleccionado la Prioridad del Clasificado")</script>',true);
									
		if($valida_titulo_clasificado == true and $valida_descripcion_clasificado == true and
		   $valida_informes_clasificado == true and $valida_tipo_clasificado == true and
		   $valida_prioridad_clasificado == true){
			//echo "al pelo REGISTRO VALIDO";
			$query_insertar_clasificado=
			"insert into clasificado(fechaclasificado,fechapublicacionclasificado,fechavencimientoclasificado,
			tituloclasificado,descripcionclasificado,informesclasificado,idtipoclasificado,idprioridadclasificado)
			values(
			'".$fecha_clasificado."','".$fecha."',
			'".$fecha."','".$_POST['txtTitulo']."',
			'".$_POST['txtDescripcion']."','".$_POST['txtInformes']."',
			'".$_POST['tipoclasificado']."','".$_POST['cbPrioridad']."')";
			$ingresar_clasificado = mysql_query($query_insertar_clasificado,$clasificados) or die (mysql_error());
			if($ingresar_clasificado){
				echo '<script language="javascript">alert("El clasificado fue ingresado satisfactoriamente.\n Estara publicado durante '.$numDias.' dias.");</script>';	
				if(isset($_GET['regreso'])){
					echo '<script language="javascript">alert("Su clasificado no sera publicado hasta que el administrador lo active, \n escriba un correo electronico a la dirección del menú principal.");</script>';	
					echo '<script language="javascript">window.close();</script>';
				}else{
					echo "<script language='javascript'>window.location.reload('index.php');</script>";
				}
			}
			else{
  					echo mysql_error();
			}
  		}
		else{
  			echo "<script language='javascript'>history.go(-1);</script>";
	  	}
	}
?>
<?php 
if(isset($_POST['btnRegresar'])){
	if(isset($_GET['regreso'])){
		echo '<script language="javascript">window.close();</script>';
	}
 	echo "<script language='javascript'>window.location.reload('index.php');</script>";
 }
?>