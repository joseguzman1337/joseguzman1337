<?php
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);  
 
?>
<script language="javaScript"></script>
<script language="javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
function recargar(dir) 
{
	window.location.reload("buscar_clasificado.php"+dir);
}
</script>

<?php
require_once('../../Connections/conexion_clasificados.php');
require_once('validar_datos.php');
error_reporting(2047);

mysql_select_db($database_clasificados,$clasificados);
$query_obtener_tipos_clasificados = "SELECT idtipoclasificado,nombretipoclasificado FROM tipoclasificado ORDER BY nombretipoclasificado";
$obtener_tipos_clasificados = mysql_query($query_obtener_tipos_clasificados,$clasificados);

mysql_select_db($database_clasificados,$clasificados);
$query_obtener_clasificados = "SELECT * FROM clasificado";
$obtener_clasificados = mysql_query($query_obtener_clasificados,$clasificados);
$row_obtener_clasificado = mysql_fetch_assoc($obtener_clasificados);
$totalRows_tipo_clasificado = mysql_num_rows($obtener_clasificados);
//print_r($_POST);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>BUSCAR CLASIFCADOS TIPO</title>
<style type="text/css">
<!--
.Estilo11 {
	font-family: "Square721 Ex BT";
	color: #003768;
}
.Estilo12 {color: #FF0000}
-->
</style>
</head>

<body>
 <form name="form1" method="post" action="">
  <table width="60%"  border="1" cellpadding="0" cellspacing="0" bordercolor="#F7BC6C" align="center">
	<tr>
		<td><h3 align="center" class="Estilo11">MODIFICAR CLASIFICADO</h3></td>
	</tr>
    <tr>
      <td><div align="left">
        <table width="100%" border="0" cellpadding="0" cellspacing="7">
		  <tr>
		      <td colspan="3" class="Estilo11"><div align="left">Debe Seleccionar una Opcion para Realizar la Busqueda:</div></td>
		    </tr>
			<tr></tr>
			<tr></tr>
          <tr>
            <td colspan="2" class="Estilo11">
                <div align="left">
                <label>Seleccione una Opcion</label>
              &nbsp;<span class="Estilo12">*</span> </div></td>
            <td><select name="tipoclasificado" id="tipoclasificado" class="Estilo11">
		  	<option  value="">Seleccionar</option>
			  <?php
			  /**************METODO PARA OBTENER DATOS DE LA BD PARA COLOCARLOS EN COMBO BOX*******************/
		  		while($row_obtener_tipos_clasificados = mysql_fetch_assoc($obtener_tipos_clasificados)){
		  	  ?>
		    <option value="<?php echo $row_obtener_tipos_clasificados['idtipoclasificado']?>"
				<?php
					if(isset($_POST['tipoclasificado'])){
						if(@$_POST['tipoclasificado']==$row_obtener_tipos_clasificados['idtipoclasificado']){
							echo 'selected';
						}
					}else{
						if(isset($_GET['tipo'])){
							if(@$_GET['tipo']==$row_obtener_tipos_clasificados['idtipoclasificado']){
								echo 'selected';
							}
						}
					}
				?> class="Estilo11"> 
				<?php echo $row_obtener_tipos_clasificados['nombretipoclasificado']?>
			</option> 
		        <?php }/******************METODO PARA OBTENER DATOS**********/ ?>
			<option value="99">TODOS</option>
		  	</select>
			</td>
			</tr>
			<tr>
		      <td colspan="2" class="Estilo11"><div align="center">
		        <label>Fecha desde </label>
              </div></td>
			  <td class="Estilo11"><label>
			  <input name="fechaDesde" type="text" id="fechaDesde" size="10" maxlength="10"
			  value="<?php 
			  		if(isset($_GET['fechaD'])){
						echo $_GET['fechaD'];
					}else{
						if(isset($_POST['fechaDesde'])){
							echo $_POST['fechaDesde'];
						}
					}?>">
			  &nbsp; aaaa-mm-dd</label></td>
			</tr>
			<tr>				<td colspan="2" class="Estilo11"><div align="center" class="Estilo11">
			  <label><span class="Estilo11">Fecha hasta</span></label>
			  </div></td>
			  <td class="Estilo11"><label>
			  <input name="fechaHasta" type="text" id="fechaHasta" size="10" maxlength="10"
			  value="<?php 
			  		if(isset($_GET['fechaH'])){
						echo $_GET['fechaH'];
					}else{
						if(isset($_POST['fechaHasta'])){
							echo $_POST['fechaHasta'];
						}
					}?>">
				</label>&nbsp; aaaa-mm-dd</td>
			</tr>
			<tr>
            	<td height="24">
       	          <div align="center">
       	            <input name="btnAutoriza" type="submit" id="btnAutoriza" value="Sin Autorizar">
				  </div></td>
            	<td><div align="right">
            	  <input name="btnBuscar" type="submit" id="btnBuscar" value="Buscar">
          	  </div></td>
            	<td><div align="center">
            	  <input name="btnRegresar" type="submit" id="btnRegresar" value="Regresar">
          	  </div></td>
			</tr>
			<table width="100%"  border="0" cellspacing="7" cellpadding="0">
		  <?php 
			    /******************IMPRESION DE LA TABLA DE CLASIFICADOS***************/
				if( isset($_POST['btnBuscar']) ){
					echo "<tr>
            			<td width='7%' class='Estilo11'><p><label>Ver</label>
            	  			<span class='Estilo11'>
            	  			</span>
            	  			<label></label>
       	          			</p>
           	    		</td>
	            		<td width='55%' class='Estilo11'><label>Titulo Clasificado</label></td>
    	        		<td width='14%' class='Estilo11'><label>Prioridad</label>&nbsp;</td>
        				</tr>";
				  //unset($obtener_tipo_clasificado_nombre,$row_tipo_clasificado_nombre);
				  $valida_tipo_clasificado = validar($_POST['tipoclasificado'],"requerido",'<script language=""javascript">alert("No ha Seleccionado el Tipo de Clasificado")</script>',true);	
				  if( $valida_tipo_clasificado == true ){
    		   		mysql_select_db($database_clasificados,$clasificados);
	    		    if(isset($_POST['btnBuscar'])){
            			$fechahoy=date("Y-m-d");
						if($_POST['tipoclasificado'] == 99){
							$query_clasificado_tipo = "SELECT DISTINCT * FROM clasificado";
						}else{
							$query_clasificado_tipo = "SELECT DISTINCT * FROM clasificado WHERE idtipoclasificado = '".$_POST['tipoclasificado']."'";
						}
				    	//echo $query_clasificado_tipo,"<br>","<br>";
	        		}
					$valida_general=false;
					$fecha=true;
					if($_POST['fechaDesde'] !=null and $_POST['fechaHasta'] != null){
						$fecha=false;
						if($_POST['tipoclasificado'] == 99){
							$query_clasificado_tipo = $query_clasificado_tipo." WHERE ";
						}else{
							$query_clasificado_tipo = $query_clasificado_tipo." AND ";
						}
						$valida_fecha_desde_hasta = validadosfechas($_POST['fechaDesde'],$_POST['fechaHasta'],'mayor','<script language="JavaScript">alert("La Fecha Hasta no debe ser menor que la Fecha Desde")</script>',true);
						//echo "Mira si es fecha","<br>";
						$valida_es_fecha_desde = validar($_POST['fechaDesde'],"fecha",'<script language="javascript">alert("La Fecha Desde no fue digitada correctamente. El Formato de Fecha es aaaa/mm/dd")</script>',true);
						$valida_es_fecha_hasta = validar($_POST['fechaHasta'],"fecha",'<script language="javascript">alert("La Fecha Hasta no fue digitada correctamente. El Formato de Fecha es aaaa/mm/dd")</script>',true);
						if($valida_fecha_desde_hasta == true and $valida_es_fecha_desde == true 
							and $valida_es_fecha_hasta == true){
					   			$query_clasificado_tipo=$query_clasificado_tipo." fechaclasificado >= '".$_POST['fechaDesde']."' AND fechaclasificado <= '".$_POST['fechaHasta']."'";
								$valida_general=true;
						}
					}
					$query_clasificado_tipo=$query_clasificado_tipo." ORDER BY idprioridadclasificado";
					//echo $query_clasificado_tipo,"<br>";
					if($valida_general !=  $fecha){
	    	    		$obtener_clasificado_tipo = mysql_query($query_clasificado_tipo,$clasificados);
						$row_clasificado_tipo = mysql_fetch_assoc($obtener_clasificado_tipo);
						$totalRows_tipo_clasificado = mysql_num_rows($obtener_clasificado_tipo);
						if($totalRows_tipo_clasificado != 0){
							do{
								$prioridad = $row_clasificado_tipo['idprioridadclasificado'];
								//echo "PRIORIDAD = ",$prioridad,"<br>";
								mysql_select_db($database_clasificados,$clasificados);
								$query_obtener_prioridad_nombre = "SELECT * FROM prioridadclasificado WHERE idprioridadclasificado =".$prioridad."";
								$obtener_prioridad_nombre = mysql_query($query_obtener_prioridad_nombre,$clasificados);
								$row_prioridad_nombre = mysql_fetch_assoc($obtener_prioridad_nombre);
								//echo $query_obtener_prioridad_nombre,"<br>";
								echo "<tr cols>";
								echo "<td align='justify'>";?>
								<input name="ver" type="submit" id="ver" value="Ver" onClick="abrir(<?php echo "'modificar_clasificado.php?tipoclasificado=".$_POST['tipoclasificado']."&idclasificado=".$row_clasificado_tipo['idclasificado']."&fechaD=".$_POST['fechaDesde']."&fechaH=".$_POST['fechaHasta']."'"; ?>,'ventana_modificar','width=560,height=460,top=200,left=150,scrollbars=yes');return false">
								<?php echo "</td>";
								if($row_clasificado_tipo['fechavencimientoclasificado'] == '2999-12-31' || $row_clasificado_tipo['fechapublicacionclasificado'] == '2999-01-01'){
									echo "<td align='left' class='Estilo12'>".$row_clasificado_tipo['tituloclasificado']."</td>";
								}else{
									echo "<td align='left' class='Estilo11'>".$row_clasificado_tipo['tituloclasificado']."</td>";
								}
								echo "<td class='Estilo11'>".$row_prioridad_nombre['nombreprioridadclasificado']."</td>
								</tr>";
							}
							while( $row_clasificado_tipo = mysql_fetch_assoc($obtener_clasificado_tipo) );
  						} 
						else{
							echo "<script language='javascript'>alert('La busqueda realizada no arrojo ningún resultado. Intente de nuevo');</script>";	
						}
					}
				}
			}
			if(isset($_POST['btnAutoriza'])){
				echo "<tr>
            		  <td width='7%' class='Estilo11'><p><label>Ver</label>
            	  	  <span class='Estilo11'></span>
            	  	  <label></label>
       	          	  </p></td>
	            	  <td width='55%' class='Estilo11'><label>Titulo Clasificado</label></td>
    	        	  <td width='14%' class='Estilo11'><label>Prioridad</label>&nbsp;</td>
        			  </tr>";
				$query_clasificados_autorizar="SELECT * FROM clasificado WHERE fechapublicacionclasificado = '2999-12-31' AND fechavencimientoclasificado = '2999-12-31' ORDER BY idprioridadclasificado";
				$obtener_clasificados_autorizar = mysql_query($query_clasificados_autorizar,$clasificados);
				$row_clasificados_autorizar = mysql_fetch_assoc($obtener_clasificados_autorizar);
				$totalRows_clasificados_autorizar = mysql_num_rows($obtener_clasificados_autorizar);
				if($totalRows_clasificados_autorizar != 0){
						do{
							$prioridad = $row_clasificados_autorizar['idprioridadclasificado'];
							//echo "PRIORIDAD = ",$prioridad,"<br>";
							mysql_select_db($database_clasificados,$clasificados);
							$query_obtener_prioridad_nombre = "SELECT * FROM prioridadclasificado WHERE idprioridadclasificado =".$prioridad."";
							$obtener_prioridad_nombre = mysql_query($query_obtener_prioridad_nombre,$clasificados);
							$row_prioridad_nombre = mysql_fetch_assoc($obtener_prioridad_nombre);
							//echo $query_obtener_prioridad_nombre,"<br>";
							echo "<tr cols>";
							echo "<td align='justify'>";?>
							<input name="verAutorizar" type="submit" id="verAutorizar" value="Ver" onClick="abrir(<?php echo "'modificar_clasificado.php?tipoclasificado=".$_POST['tipoclasificado']."&idclasificado=".$row_clasificados_autorizar['idclasificado']."&fechaD=".$_POST['fechaDesde']."&fechaH=".$_POST['fechaHasta']."'"; ?>,'ventana_modificar_autorizar','width=560,height=460,top=200,left=150,scrollbars=yes');return false">
							<?php echo "</td>";
							echo "<td align='left' class='Estilo12'>".$row_clasificados_autorizar['tituloclasificado']."</td>";
							echo "<td class='Estilo11'>".$row_prioridad_nombre['nombreprioridadclasificado']."</td>
								  </tr>";
						}
						while( $row_clasificados_autorizar = mysql_fetch_assoc($obtener_clasificados_autorizar) );
  					} 
					else{
						echo "<script language='javascript'>alert('La busqueda realizada no arrojo ningún resultado. Intente de nuevo');</script>";	
					}
			}?>
			<br/>
			<?php if(isset($_POST['btnRegresar'])){
					   echo "<script language='javascript'>window.location.reload('index.php');</script>";
			 	  }
			?>
			</table>
        </table>
      </div></td>
    </tr>
  </table>
  <p class="Estilo11">&nbsp;</p>
 </form>
</body>
</html>
