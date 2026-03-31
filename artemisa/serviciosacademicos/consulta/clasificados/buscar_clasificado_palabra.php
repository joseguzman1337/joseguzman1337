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
</script>
<?php
require_once('conexion_clasificados.php');
require_once('validar_datos.php');
error_reporting(2047);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>BUSCAR CLASIFICADO PALABRA</title>
<style type="text/css">
<!--
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo6 {color: #003768}
.Estilo7 {font-family: Tahoma; font-size: 14px; font-weight: bold; color: #003768; }
.Estilo8 {color: #F7BC6C}
.Estilo11 {
	font-family: "Square721 Ex BT";
	color: #003768;
}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="">
  <table width="60%"  border="1" cellpadding="0" cellspacing="0" bordercolor="#F7BC6C" align="center">
    <tr>
	  	<td><h3 align="center" class="Estilo11">BUSCAR CLASIFICADO POR PALABRA</h3></td>
	</tr>
    <tr>
	  <?php 
	  	$accion="nula";
		$archivo="palabra";
		/*echo " ACCION ",$accion;
		echo " ARCHIVO ",$archivo;*/
	  ?>
      <td><div align="left">
          <table width="100%"  border="0" cellspacing="7" cellpadding="0">
            <tr>
              <td colspan="2" class="Estilo11"><label>Digite una Palabra</label>
                &nbsp;</td>
              <td colspan="3"><input name="palabrabuscar" type="text" id="palabrabuscar" class="Estilo11" 
			  <?php 
			  		/*if(isset($_POST['btnBuscar'])){
						if($_POST['palabrabuscar'] != NULL){ 
							echo $_POST['palabra_buscar'];
						} 						
					}*/
			  ?> >
            </div></td>
            </tr>
			<tr>
              <td colspan="2"><div align="center">
                  <input name="btnBuscar" type="submit" id="btnBuscar" value="Buscar">
              </div></td>
              <td colspan="3"><input name="btnRegresar" type="submit" id="btnRegresar" value="Regresar"></td>
            </tr>
			<?php 
			    /******************IMPRESION DE LA TABLA DE CLASIFICADOS***************/
				if( isset($_POST['btnBuscar']) ){
				  echo "<tr>
              			<td width='7%' class='Estilo11'><p>
                  			<label>Ver</label>
              				</p></td>
              			<td width='55%' class='Estilo11'>Titulo Clasificado</td>
              			<td width='24%' class='Estilo11'><label>Fecha Vencimiento</label></td>
              			<td width='7%' class='Estilo11'><label>Prioridad</label></td>
              			<td width='7%' class='Estilo11'><label>Tipo</label></td>
            			</tr>";
				  $valida_palabra_clave = validar($_POST['palabrabuscar'],"requerido",'<script language="javascript">alert("Escriba por lo menos una palabra para realizar la búsqueda")</script>',true);	
				  if( $valida_palabra_clave == true ){
    		   		mysql_select_db($database_clasificados,$clasificados);
	    		    if(isset($_POST['btnBuscar'])){
            			$fechahoy=date("Y-m-d H:i:s");
				    	$query_clasificado_palabra = "SELECT * FROM clasificado WHERE descripcionclasificado LIKE '%".$_POST['palabrabuscar']."%' AND 
						fechavencimientoclasificado >= '$fechahoy' AND fechapublicacionclasificado <= '$fechahoy' ORDER BY idprioridadclasificado";
				    	//echo $query_clasificado_palabra,"<br>","<br>";
	        		}
    	    		$obtener_clasificado_palabra = mysql_query($query_clasificado_palabra,$clasificados);
					$row_clasificado_palabra = mysql_fetch_assoc($obtener_clasificado_palabra);
					$totalRows_clasificado_palabra = mysql_num_rows($obtener_clasificado_palabra);
				  	if($totalRows_clasificado_palabra != 0){
						do{
							$prioridad = $row_clasificado_palabra['idprioridadclasificado'];
							$tipo = $row_clasificado_palabra['idtipoclasificado'];
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
							//echo $query_obtener_prioridad_nombre,"<br>";
							echo "<tr>";
							echo "<td align='justify'>";?>
								<input name="ver" type="button" id="ver" value="Ver" onClick="abrir(<?php echo "'consultar_clasificado.php?tipoclasificado=".$tipo."&idclasificado=".$row_clasificado_palabra['idclasificado']."$accion=".$accion."&archivo=".$archivo."'"; ?>,'ventana_consultar_palabra','width=560,height=460,top=200,left=150,scrollbars=yes');return false">
							<?php echo "</td>
							<td align='left' class='Estilo11'>".$row_clasificado_palabra['tituloclasificado']."</td>
							<td class='Estilo11'>".$row_clasificado_palabra['fechavencimientoclasificado']."</td>
							<td class='Estilo11'>".$row_prioridad_nombre['nombreprioridadclasificado']."</td>
							<td class='Estilo11'>".$row_tipo_nombre['nombretipoclasificado']."</td>
							</tr>";
						}
						while( $row_clasificado_palabra = mysql_fetch_assoc($obtener_clasificado_palabra) );
					}
					else{
						echo "<script language='javascript'>alert('La busqueda realizada no arrojo ningún resultado. Intente de nuevo');</script>";	
					}
  	    		} 
			} ?>
            <br/>
            <?php if(isset($_POST['btnRegresar'])){
					   echo "<script language='javascript'>window.location.reload('index.php');</script>";
			 	  }
			?>
          </table>
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>
