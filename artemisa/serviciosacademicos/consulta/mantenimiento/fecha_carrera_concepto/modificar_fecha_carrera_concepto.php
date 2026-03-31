<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>

<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>

<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.AZUL {color: #0000FF;Tahoma;font-size: 14px; font-weight: bold;}
-->
</style>


<?php 
ini_set("include_path", ".:/usr/share/pear_");
 
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php';
require_once realpath(dirname(__FILE__)).'/../funciones/pear/DB.php';
require_once realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php';
$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}

$fechahoy=date("Y-m-d");
$query_sel_modalidadacademica = "SELECT * FROM modalidadacademica";
$sel_modalidadacademica = $sala->query($query_sel_modalidadacademica);
$row_sel_modalidadacademica = $sel_modalidadacademica->fetchRow();
$combo_carrera=DB_DataObject::factory('carrera');

$combo_carrera->query("SELECT DISTINCT * FROM carrera c WHERE c.codigomodalidadacademica = '".$_POST['combomodalidadacademica']."' AND 
c.fechainiciocarrera < '$fechahoy' AND  c.fechavencimientocarrera > '$fechahoy' 
ORDER BY c.nombrecarrera ASC");


$query_sel_concepto = "SELECT fcc.idfechacarreraconcepto, fcc.fechainiciofechacarreraconcepto, fcc.fechavencimientofechacarreraconcepto, co.nombreconcepto, c.nombrecarrera,fcc.codigotipofechacarreraconcepto FROM fechacarreraconcepto fcc, carrera c, concepto co
WHERE
c.codigocarrera=fcc.codigocarrera AND
co.codigoconcepto=fcc.codigoconcepto AND '$fechahoy' <= fcc.fechavencimientofechacarreraconcepto AND
fcc.codigocarrera='".$_POST['combocarrera']."'";
$sel_concepto = $sala->query($query_sel_concepto);
//$row_sel_concepto = $sel_concepto->fetchRow();



?>


 <form name="form1" method="post" action="">

   <p align="center"><span class="Estilo3">FECHA CARRERA CONCEPTO - MODIFICAR </span></p>
   <table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
     <tr>
       <td><table width="200" border="0" align="center" cellpadding="3">
         <tr>
           <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica<span class="Estilo4">*</span> </div></td>
           <td nowrap bgcolor="#FEF7ED"><span class="style2">
             <select name="combomodalidadacademica" id="combomodalidadacademica" onChange="enviar()">
               <option value="">Seleccionar</option>
               <?php
                  do {
?>
               <option value="<?php echo $row_sel_modalidadacademica['codigomodalidadacademica']?>"<?php if(isset($_POST['combomodalidadacademica'])){if($_POST['combomodalidadacademica'] == $row_sel_modalidadacademica['codigomodalidadacademica'] or $_GET['modalidadacademica']==$row_sel_modalidadacademica['codigomodalidadacademica']){echo "selected";}}?>><?php echo $row_sel_modalidadacademica['nombremodalidadacademica'];?></option>
               <?php
                  } while ($row_sel_modalidadacademica = $sel_modalidadacademica->fetchRow());
                  $rows = mysql_num_rows($sel_modalidadacademica);
                  if($rows > 0) {
                  	mysql_data_seek($sel_modalidadacademica, 0);
                  	$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
                  }
?>
             </select>
           </span> </td>
         </tr>
         <tr>
           <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrrera<span class="Estilo4">*</span></div></td>
           <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
             <select name="combocarrera" id="combocarrera" onChange="enviar()">
               <option value="">Seleccionar</option>
               <?php

             while ($combo_carrera->fetch()){
?>
               <option value="<?php echo $combo_carrera->codigocarrera;?>"<?php if($combo_carrera->codigocarrera == $_POST['combocarrera']){echo "selected";}?>><?php echo $combo_carrera->nombrecarrera;?></option>
               <?php
            } 


?>
             </select>
           </span></span></span></td>
         </tr>
         <tr bgcolor="#CCDADD">
           <td nowrap class="Estilo2"><div align="center">Concepto</div></td>
           <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera</div></td>
         </tr>
         <?php while ($row_sel_concepto = $sel_concepto->fetchRow()) { ?>
         <tr>
           <td nowrap><a href="modificar_fecha_carrera_concepto_detalle.php?nombreconcepto=<?php echo $row_sel_concepto['nombreconcepto'];?>&nombrecarrera=<?php echo $row_sel_concepto['nombrecarrera']; ?>&codigotipofechacarreraconcepto=<?php echo $row_sel_concepto['codigotipofechacarreraconcepto'];?>&idfechacarreraconcepto=<?php echo $row_sel_concepto['idfechacarreraconcepto']; ?>"><?php echo $row_sel_concepto['nombreconcepto']; ?></a></td>
           <td nowrap><?php echo $row_sel_concepto['nombrecarrera']; ?></td>
         </tr>
         <?php } ?>
         <tr bgcolor="#CCDADD">
           <td colspan="2" nowrap><div align="center">
               <input name="Regresar" type="submit" id="Regresar" value="Regresar">
           </div></td>
         </tr>
       </table></td>
     </tr>
   </table>
 </form>
 
 
  
 <?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.href='menu.php';</script>";
  }
?>
