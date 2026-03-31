<?php
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
  
require_once('conexion_clasificados.php');
require_once('validar_datos.php');
error_reporting(2047);

mysql_select_db($database_clasificados,$clasificados);
$query_obtener_tipos_clasificados = "SELECT idtipoclasificado,nombretipoclasificado FROM tipoclasificado";
$obtener_tipos_clasificados = mysql_query($query_obtener_tipos_clasificados,$clasificados);

mysql_select_db($database_clasificados,$clasificados);
$query_obtener_clasificados = "SELECT * FROM clasificado";
$obtener_clasificados = mysql_query($query_obtener_clasificados,$clasificados);
$row_obtener_clasificado = mysql_fetch_assoc($obtener_clasificados);
$totalRows_tipo_clasificado = mysql_num_rows($obtener_clasificados);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo5 {
	color: #F7BC6C;
	font-family: Tahoma;
	font-size: 14px;
	font-weight: bold;
}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo6 {color: #003768}
.Estilo7 {font-family: Tahoma; font-size: 14px; font-weight: bold; color: #003768; }
.Estilo11 {
	font-family: "Square721 Ex BT";
	color: #003768;
}
-->
</style>
</head>

<body>
 <div align="center"><span class="Estilo5">MODIFICAR CLASIFICADO</span>
 </div>
 <form name="form1" method="post" action="">
  <table width="60%"  border="1" cellpadding="0" cellspacing="0" bordercolor="#F7BC6C" align="center">
    <tr>
      <td><div align="left">
	    <table width="100%"  border="0" cellspacing="7" cellpadding="0">
          <tr class="Estilo11">
            <td colspan="2" class="Estilo11"><label>Seleccione un Tipo de Clasificado</label>
			&nbsp; </td>
            <td colspan="2"><select name="cbTipo" id="cbTipo">
                <option value="">Seleccionar</option>
                <?php
			  /**************METODO PARA OBTENER DATOS DE LA BD PARA COLOCARLOS EN COMBO BOX*******************/
		  		while($row_obtener_tipos_clasificados = mysql_fetch_assoc($obtener_tipos_clasificados)) 
				{	
		  	  ?>
                <option value="<?php echo $row_obtener_tipos_clasificados['idtipoclasificado']?>" 
		  	
				<?php 
					if(@$_POST['cbTipo']==$row_obtener_tipos_clasificados['idtipoclasificado'])
					{
						echo 'selected';
					}?>> <?php echo $row_obtener_tipos_clasificados['nombretipoclasificado']?> </option>
                <?php } /******************METODO PARA OBTENER DATOS**********/ ?>
              </select>
            </td>
          </tr>
          <tr class="Estilo11">
            <td width="7%" class="Estilo11"><p>
                <label>Ver</label>
            </p></td>
            <td width="55%" class="Estilo11">Titulo Clasificado</td>
            <td width="24%" class="Estilo11"><label>Fecha Vencimiento</label></td>
            <td width="14%" class="Estilo11"><label>Prioridad</label>
&nbsp;</td>
          </tr>
          <?php 
			    /******************IMPRESION DE LA TABLA DE CLASIFICADOS***************/
				if( isset($_POST['btnBuscar']) ){
				  //unset($obtener_tipo_clasificado_nombre,$row_tipo_clasificado_nombre);
				  $valida_tipo_clasificado = validar($_POST['cbTipo'],"requerido",'<script language=""javascript">alert("No ha Seleccionado el Tipo de Clasificado")</script>',true);	
				  if( $valida_tipo_clasificado == true )
				  { 			
    		   		mysql_select_db($database_clasificados,$clasificados);
	    		    if(isset($_POST['btnBuscar']))
		    	    {
            			$fechahoy=date("Y-m-d H:i:s");
				    	$query_clasificado_tipo = " SELECT DISTINCT * FROM clasificado WHERE idtipoclasificado = '".$_POST['cbTipo']."' AND 
						fechavencimientoclasificado >= '$fechahoy' AND fechapublicacionclasificado <= '$fechahoy' ORDER BY idprioridadclasificado";
				    	//echo $query_clasificado_tipo,"<br>","<br>";
	        		}
    	    		$obtener_clasificado_tipo = mysql_query($query_clasificado_tipo,$clasificados);
					$row_clasificado_tipo = mysql_fetch_assoc($obtener_clasificado_tipo);
					$totalRows_tipo_clasificado = mysql_num_rows($obtener_clasificado_tipo);
					if($totalRows_tipo_clasificado !=0){
						do{
							$prioridad = $row_clasificado_tipo['idprioridadclasificado'];
							//echo "PRIORIDAD = ",$prioridad,"<br>";
					
							mysql_select_db($database_clasificados,$clasificados);
							$query_obtener_prioridad_nombre = "SELECT * FROM prioridadclasificado WHERE idprioridadclasificado =".$prioridad."";
							$obtener_prioridad_nombre = mysql_query($query_obtener_prioridad_nombre,$clasificados);
							$row_prioridad_nombre = mysql_fetch_assoc($obtener_prioridad_nombre);
							//echo $query_obtener_prioridad_nombre,"<br>";
							echo "<tr>
							<td align='justify'><a href='modificar_clasificado.php?tipoclasificado=".$_POST['cbTipo']."&idclasificado=".$row_clasificado_tipo['idclasificado']."'><img src='../../../../imagenes/semaforo_verde.png' width='08' height='08' border='0'></a></td>
							<td align='left' class='Estilo11'>".$row_clasificado_tipo['tituloclasificado']."</td>
							<td class='Estilo11'>".$row_clasificado_tipo['fechavencimientoclasificado']."</td>
							<td class='Estilo11'>".$row_prioridad_nombre['nombreprioridadclasificado']."</td>
							</tr>";
						}
						while( $row_clasificado_tipo = mysql_fetch_assoc($obtener_clasificado_tipo) );
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
          <tr>
            <td colspan="2"><div align="center">
                <input name="btnBuscar" type="submit" id="btnBuscar" value="Buscar">
            </div></td>
            <td colspan="2"><input name="btnRegresar" type="submit" id="btnRegresar" value="Regresar"></td>
          </tr>
        </table>
    </tr>
  </table>
</form>

</body>
</html>
