<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
?>
<script language="JavaScript" src="calendario/javascripts.js"></script>

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
   
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");

require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
?>
<?php
mysql_select_db($database_sala, $sala);
$query_sel_modalidadacademica = "SELECT * FROM modalidadacademica where codigomodalidadacademica='".$_GET['modalidadacademica']."'";
$sel_modalidadacademica = mysql_query($query_sel_modalidadacademica, $sala) or die(mysql_error());
$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
$totalRows_sel_modalidadacademica = mysql_num_rows($sel_modalidadacademica);

mysql_select_db($database_sala, $sala);
$query_sel_carrera = "SELECT * FROM carrera c where c.codigomodalidadacademica='".$_GET['modalidadacademica']."' order by c.nombrecarrera asc";
$sel_carrera = mysql_query($query_sel_carrera, $sala) or die(mysql_error());
$row_sel_carrera = mysql_fetch_assoc($sel_carrera);
$totalRows_sel_carrera = mysql_num_rows($sel_carrera);


?>


<form name="materias" method="post" action="">
  <p align="center" class="Estilo3">SELECCIONE MATERIA </p>
  <table width="29%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica</div></td>
          <td bgcolor='#FEF7ED'>
              <div align="center"><span class="style2">
<?php echo $row_sel_modalidadacademica['nombremodalidadacademica']; ?>              </span></div></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera</div></td>
          <td bgcolor='#FEF7ED'><select name="codigocarrera" id="codigocarrera" onChange="enviar()">
            <option value="">Seleccionar</option>
            <?php
              do {
?>
            <option value="<?php echo $row_sel_carrera['codigocarrera']?>"<?php if($row_sel_carrera['codigocarrera']==$_POST['codigocarrera']){echo "selected";}?>><?php echo $row_sel_carrera['nombrecarrera'];?></option>
            <?php
              } while ($row_sel_carrera = mysql_fetch_assoc($sel_carrera));
              $rows = mysql_num_rows($sel_carrera);
              if($rows > 0) {
              	mysql_data_seek($sel_carrera, 0);
              	$row_sel_carrera = mysql_fetch_assoc($sel_carrera);
              }
?>
          </select></td>
        </tr>
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
            <?php if(isset($_GET['modalidadacademica'])){ 
              	mysql_select_db($database_sala, $sala);
              $query_materias= "SELECT * from materia m where m.codigoestadomateria='01' and m.codigocarrera='".$_POST['codigocarrera']."' order by nombremateria asc";
            	//echo $query_materias;
				$materias = mysql_query($query_materias, $sala) or die(mysql_error());
             	$row_materias = mysql_fetch_assoc($materias);
              	$totalRows_materias = mysql_num_rows($materias);


   ?>
          </div></td>
        </tr>
		</table> 
	    <?php echo "<table>";
	    do{
	    	echo "<tr>
			<td align='center' valign='bottom'>$chequear</td>
			<td colspan='2'><span class='Estilo1'>
			<a href='consultar_materias_detalle.php?codigomateria=".$row_materias['codigomateria']." '>".$row_materias['nombremateria']."</a> 
			</span>&nbsp;</td>
			</tr>
		  ";}
	    	while ($row_materias = mysql_fetch_assoc($materias));
	  ?>
        <?php } echo "</table>"?>
  </table>
  <br  />
  
 <?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.href='menu.php';</script>";
  }
?>
 