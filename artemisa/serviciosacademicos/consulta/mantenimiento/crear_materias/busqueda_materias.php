<?php
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once('../../../funciones/clases/autenticacion/redirect.php');
?>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FF0000}
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
<?php

//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
$inicial=ini_get('include_path');
//error_reporting(2048);
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/combo.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/combo_bd.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$materia_consulta = DB_DataObject::factory('materia');
//$carrera_consulta = DB_DataObject::factory('carrera');
if(isset($_POST['Enviar']))
{
	$materia_consulta->query("select * from materia where nombremateria like '%".$_POST['palabra']."%' order by nombremateria asc");
}
 ?>

      <form name="form1" method="post" action="">
        <p align="center" class="Estilo3">BUSQUEDA DE MATERIAS POR PALABRA</p>
        <table width="329" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
              <tr>
                <td width="51%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Palabra<span class="Estilo4">*</span></div></td>
                <td width="49%" bgcolor='#FEF7ED'><div align="center">
                    <input name="palabra" type="text" id="palabra">
                    <span class="style2"> </span></div></td>
              </tr>
              <tr bgcolor="#CCDADD">
                <td class="Estilo2"><div align="center">Materia</div></td>
                <td class="Estilo2"><div align="center">Carrera</div></td>
              </tr>
              <?php while ($materia_consulta->fetch()){ 
			  $carrera_consulta=$materia_consulta->getlink('codigocarrera','carrera','codigocarrera');
			   ?>
		      <tr>
                <th nowrap class="Estilo1"><div align="center"><a href="consultar_materias_detalle.php?codigomateria=<?php echo $materia_consulta->codigomateria;?>"><?php echo $materia_consulta->nombremateria;?></a></div></th>
				<td class="Estilo1"><div align="center"><?php echo $carrera_consulta->nombrecarrera;?></div></td>
              </tr>
              <?php } ?>
              <tr bgcolor="#CCDADD">
                <td colspan="2" class="Estilo2"><div align="center">
                    <input name="Regresar" type="submit" id="Regresar" value="Regresar">
                    <input name="Enviar" type="submit" id="Enviar" value="Enviar">
</div></td>
              </tr>
            </table></td>
          </tr>
        </table>
		<br>
        <p>&nbsp;</p>
      </form>
		  
 <?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.href='menu.php';</script>";
  }
?>	 

