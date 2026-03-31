<script language="javaScript"></script>
<script language="javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<?php
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
<title>Clasificados</title>
<style type="text/css">
<!--
.Estilo11 {
	font-family: "Square721 Ex BT";
	color: #003768;
}
.Estilo12 {
	font-family: "Square721 Ex BT";
	font-size: 14px;
	color: #003768;
}
.Estilo13 {
	font-family: "Square721 Ex BT";
	font-size: 14px;
	font-weight: bold;
	color: #003768;
}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="">
  <table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#F7BC6C">
  	<tr>
	  <td><h3 align="center" class="Estilo11">MENU PRINCIPAL</h3></td>
	</tr>
    <tr>
      <td><div align="center">
	    <table width="80%" height="50%"  border="0" cellpadding="0" cellspacing="5">
          <tr>
            <td width="150" class="Estilo11"><div align="right">
                <label>Por Palabra</label></div></td>
            <td width="300" height="35" colspan="3" bgcolor="#EFEBDE"><div align="left">
                <input name="txtPalabra" type="text" id="txtPalabra" class="Estilo11" align="absmiddle" 
				value="<?php if($_POST['txtPalabra'] != NULL ){ 
						echo $_POST['txtPalabra'];
				}?>">
            </div></td>
          </tr>
          <tr>
            <td class="Estilo11" width="150"><div align="right">
                <label>Por Tipo </label>
            </div></td>
            <td width="300" height="35" colspan="2" bgcolor="#EFEBDE"><div align="left">
                <select name="cbTipo" id="cbTipo" class="Estilo11">
                  <option value="">Seleccionar</option>
                  <?php
			  /**************METODO PARA OBTENER DATOS DE LA BD PARA COLOCARLOS EN COMBO BOX*******************/
		  		while($row_obtener_tipos_clasificados = mysql_fetch_assoc($obtener_tipos_clasificados)){
		  	  ?>
                  <option value="<?php echo $row_obtener_tipos_clasificados['idtipoclasificado']?>"
				<?php 
					if(@$_POST['cbTipo']==$row_obtener_tipos_clasificados['idtipoclasificado']){
						echo 'selected';
					}?> class="Estilo11"> <?php echo $row_obtener_tipos_clasificados['nombretipoclasificado']?> </option>
                  <?php } /******************METODO PARA OBTENER DATOS**********/ ?>
				  <option value="99">TODOS</option>
                </select>
            </div></td>
          </tr>
          <br/>
		  <tr></tr>
		  <tr></tr>
          <tr>
            <td colspan="3" class="Estilo11">Si encuentra alguna inconsistencia la puede dirigir a: 
			<a href="mailto:juanforero@sistemasunbosque.edu.co">juanforero@sistemasunbosque.edu.co</a>
			</td>
		  </tr>
		  <tr></tr>
		  <tr></tr>
          <tr>
            <td><div align="right">
                <input name="btnBuscar" type="submit" id="btnBuscar" value="Buscar">
            </div></td>
            <td><div align="center">
              <input name="btnReset" type="submit" id="btnReset" value="Restablecer">
            </div></td>
            <td><input name="btnCrear" type="submit" id="btnCrear" value="Crear Clasificado" onClick="abrir(<?php echo "'ingresar_clasificados.php?regreso=15'"?>,'ventana_ingresar_clasificado','width=560,height=460,top=200,left=150,scrollbars=yes');return false"></td>
          </tr>
		  <tr></tr>
		  <tr></tr>
		  <table width="70%" height="50%"  border="0" cellpadding="0" cellspacing="5">
          <?php if(isset($_POST['btnBuscar'])){
		  	unset($query_clasificados_busqueda,$obtener_clasificados_busqueda,$row_clasificados_busqueda,$totalRows_clasificados_busqueda);
		  	if($_POST['cbTipo'] == null && $_POST['txtPalabra'] == null){
				echo "<script language='javascript'>alert('Debe seleccionar por lo menos uno de los criterios para realizar la búsqueda');</script>";	
			}else{
				$fechahoy=date("Y-m-d");
				$query_clasificados_busqueda="SELECT * FROM clasificado WHERE";
		  		//////////////CUANDO SOLO DIGITA UNA PALABRA//////////////
			  	if($_POST['cbTipo'] == null && $_POST['txtPalabra'] != null){
					mysql_select_db($database_clasificados,$clasificados);
					$query_clasificados_busqueda = $query_clasificados_busqueda." (descripcionclasificado LIKE '%".$_POST['txtPalabra']."%' 
					OR tituloclasificado LIKE '%".$_POST['txtPalabra']."%') AND";
				}
		 	    ////////////CUANDO SELECCIONA UN TIPO////////////////
			  	if($_POST['cbTipo'] != null && $_POST['txtPalabra'] == null){
					if($_POST['cbTipo'] == 99){
						$query_clasificados_busqueda = "SELECT * FROM clasificado WHERE ";
					}else{
						mysql_select_db($database_clasificados,$clasificados);
						$query_clasificados_busqueda = $query_clasificados_busqueda." idtipoclasificado = ".$_POST['cbTipo']." AND"; 
					}
				}
				//////////////CUANDO SELECCIONA PALABRA Y TIPO////////////////							
					if($_POST['cbTipo'] != null && $_POST['txtPalabra'] != null){
						if($_POST['cbTipo'] == 99){
							$query_clasificados_busqueda ="SELECT * FROM clasificado WHERE 
							(descripcionclasificado LIKE '%".$_POST['txtPalabra']."%' OR tituloclasificado LIKE '%".$_POST['txtPalabra']."%') 
							AND";
						}else{
							mysql_select_db($database_clasificados,$clasificados);
							$query_clasificados_busqueda = $query_clasificados_busqueda." (descripcionclasificado LIKE '%".$_POST['txtPalabra']."%' OR tituloclasificado LIKE '%".$_POST['txtPalabra']."%') 
							AND idtipoclasificado = ".$_POST['cbTipo']." AND "; 
						}
				}
				$query_clasificados_busqueda=$query_clasificados_busqueda." fechavencimientoclasificado >= '".$fechahoy."' 
				AND fechapublicacionclasificado <= '".$fechahoy."' ORDER BY idprioridadclasificado";
				//echo $query_clasificados_busqueda;
				$obtener_clasificados_busqueda = mysql_query($query_clasificados_busqueda,$clasificados);
				$row_clasificados_busqueda = mysql_fetch_assoc($obtener_clasificados_busqueda);
				$totalRows_clasificados_busqueda = mysql_num_rows($obtener_clasificados_busqueda);
				if($totalRows_clasificados_busqueda != 0){
					do{
						$prioridad = $row_clasificados_busqueda['idprioridadclasificado'];
						$tipo = $row_clasificados_busqueda['idtipoclasificado'];
						//echo "PRIORIDAD = ",$prioridad,"<br>";
						//echo "TIPO = ",$tipo,"<br>";
			 			mysql_select_db($database_clasificados,$clasificados);
						$query_obtener_tipos_nombre = "SELECT * FROM tipoclasificado WHERE idtipoclasificado =".$tipo."";
						$obtener_tipo_nombre = mysql_query($query_obtener_tipos_nombre,$clasificados);
						$row_tipo_nombre = mysql_fetch_assoc($obtener_tipo_nombre);
						//echo $query_obtener_tipos_nombre,"<br>";
						mysql_select_db($database_clasificados,$clasificados);
						$query_obtener_prioridad_nombre = "SELECT * FROM prioridadclasificado WHERE idprioridadclasificado =".$prioridad."";
						$obtener_prioridad_nombre = mysql_query($query_obtener_prioridad_nombre,$clasificados);
						$row_prioridad_nombre = mysql_fetch_assoc($obtener_prioridad_nombre);
						$archivo = 'palabra';
						//echo $query_obtener_prioridad_nombre,"<br>";
						echo "
						<tr>
							<td align='left' class='Estilo13' bgcolor='#EFEBDE' colspan='2'>".$row_clasificados_busqueda['tituloclasificado']."</td>
						</tr>
						<tr>
							<td align='left' class='Estilo12'>Descripción :</td>
							<td align='left'>".$row_clasificados_busqueda['descripcionclasificado']."</td>
						</tr>
						<tr>
							<td align='left' class='Estilo12'>Informes :</td>
							<td align='left'>".$row_clasificados_busqueda['informesclasificado']."</td>
						</tr>					
						<tr>
							<td align='left' class='Estilo12'>Fecha Vencimiento :</td>
							<td align='left'>".$row_clasificados_busqueda['fechavencimientoclasificado']."</td>
						</tr>
						<tr>
							<td align='left' class='Estilo12'>Tipo :</td>
							<td align='left'>".$row_tipo_nombre['nombretipoclasificado']."</td>
						</tr>
						<tr></tr>
						<tr></tr>";					
					}
					while( $row_clasificados_busqueda = mysql_fetch_assoc($obtener_clasificados_busqueda) );
				}
				else{
					echo "<script language='javascript'>alert('La busqueda realizada no arrojo ningún resultado. Intente de nuevo');</script>";	
				}
			}
		}
		if(isset($_POST['btnReset'])){
			echo "<script language='javascript'>window.location.reload('index_usuario.php');</script>";
		}?>
		<tr></tr>
		<tr></tr>
		</table>
        </table>
        </div>
      </td>
    </tr>
  </table>
</form>
</body>
</html>