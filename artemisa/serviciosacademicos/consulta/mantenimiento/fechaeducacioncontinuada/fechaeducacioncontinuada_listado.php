<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<script language="JavaScript" src="../funciones/calendario/javascripts.js"></script><script language="JavaScript" src="../funciones/calendario/javascripts.js"></script>
<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>

<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.Estilo5 {font-family: Tahoma; font-size: 12px}
-->
</style>
<?php

//print_r($_POST);
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
//@session_start();
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_get.php');
//require_once('calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validardosfechas.php');


//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;	
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
?>

<?php
$fechaeducacioncontinuada=DB_DataObject::factory('fechaeducacioncontinuada');
$fechaeducacioncontinuada_borrar=DB_DataObject::factory('fechaeducacioncontinuada');
$grupo=DB_DataObject::factory('grupo');
$periodo=DB_DataObject::factory('periodo');
/*$periodo->get('codigoestadoperiodo','4');
$periodo->whereAdd("codigoestadoperiodo = '1'", 'OR');*/
$periodo->query("select * from periodo where codigoestadoperiodo in('1','4') order by codigoestadoperiodo desc");
	

if($_GET['idgrupo'])
{
	//DB_DataObject::debugLevel(5);
 	$fechaeducacioncontinuada->whereAdd('idgrupo="'.$_GET['idgrupo'].'"');
	$fechaeducacioncontinuada->whereAdd('codigoestado="100"');
	$fechaeducacioncontinuada->get('','*'); 
	//print_r($fechaeducacioncontinuada);
	//DB_DataObject::debugLevel(0);
	$grupo->get('idgrupo',$_GET['idgrupo']);
	//print_r($grupo);
}
?>


<form name="form1" action="" method="get">
  <p align="center" class="Estilo3"> FECHA EDUCACION CONTINUADA</p>
  <table width="70%" border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Modalidad Acad&eacute;mica </div></td>
          <td bgcolor="#CCDADD"><div align="left"></div>
              <?php $validacion['codigomodalidadacademica']=combo_valida_get("codigomodalidadacademica","modalidadacademica","codigomodalidadacademica","nombremodalidadacademica",'onChange=enviar()',"","","si","Modalidad acad&eacute;mica")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Carrera</div></td>
          <td bgcolor="#CCDADD"><div align="left"></div>
              <?php $validacion['codigocarrera']=combo_valida_get("codigocarrera","carrera","codigocarrera","nombrecarrera",'onChange=enviar()',"codigoreferenciacobromatriculacarrera='200' and codigomodalidadacademica='".$_GET['codigomodalidadacademica']."'","nombrecarrera asc","si","carrera")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Materia</div></td>
          <td bgcolor="#CCDADD"><?php $validacion['codigomateria']=combo_valida_get("codigomateria","materia","codigomateria","nombremateria",'onChange=enviar()',"codigocarrera='".$_GET['codigocarrera']."' and codigoestadomateria=01","","si","Materia")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Grupo</div></td>
          <td bgcolor="#CCDADD"><?php $validacion['idgrupo']=combo_valida_get("idgrupo","grupo","idgrupo","nombregrupo",'onChange=enviar()','codigoperiodo='.$periodo->codigoperiodo.' and codigomateria='.$_GET['codigomateria'].' and codigoestadogrupo like "1%"',"","si","Grupo")?></td>
        </tr>
      </table></td>
    </tr>
  </table>

  <br>
  <table width="70%" border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr bgcolor="#FEF7ED" class="Estilo2">
          <td colspan="4"><div align="center">FECHA EDUACION CONTINUADA</div></td>
          </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">ID Grupo </div></td>
          <td><div align="center">Nombre Grupo </div></td>
          <td><div align="center">Materia Grupo </div></td>
          <td><div align="center">Eliminar</div></td>
        </tr>
        <?php do{
		$nombregrupo = $fechaeducacioncontinuada->getLink('idgrupo','grupo','idgrupo');
		$nombremateriagrupo = $grupo->getlink('codigomateria','materia','codigomateria');
	 ?>
        <tr class="Estilo1">
          <td><div align="center"><?php echo $fechaeducacioncontinuada->idgrupo?></div></td>
          <td><div align="center"><?php if($fechaeducacioncontinuada->idgrupo!=""){ ?><a href="detallefechaeducacioncontinuada_listado.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigomateria=<?php echo $_GET['codigomateria']?>&idgrupo=<?php echo $_GET['idgrupo']?>&idfechaeducacioncontinuada=<?php echo $fechaeducacioncontinuada->idfechaeducacioncontinuada?>"><?php echo $nombregrupo->nombregrupo?></a><?php }?></div></td>
          <td><div align="center"><?php if($fechaeducacioncontinuada->idgrupo!=""){echo $nombremateriagrupo->nombremateria;}?></div></td>
          <td><div align="center"><?php if($fechaeducacioncontinuada->idgrupo!=""){?><a href="fechaeducacioncontinuada_listado.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigomateria=<?php echo $_GET['codigomateria']?>&idgrupo=<?php echo $_GET['idgrupo']?>&eliminar=<?php echo $fechaeducacioncontinuada->idfechaeducacioncontinuada?>"><img src="../../../../imagenes/eliminar.png" width="23" height="23" border="0"></a><?php }?></div></td>
        </tr>
        <?php }while($fechaeducacioncontinuada->fetch());?>
		<tr bgcolor="#FEF7ED" class="Estilo1">
   		    <td colspan="4"><div align="center">
            <?php 
			if($fechaeducacioncontinuada->idfechaeducacioncontinuada==""){?>
			<input name="Asociar" type="submit" id="Asociar" value="Asociar Grupo">
			<?php } ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Restablecer" type="submit" id="Restablecer" value="Restablecer">
</div></td>
          </tr>
        
      </table></td>
    </tr>
  </table>
</form>
<?php 
if(isset($_GET['eliminar']) and $_GET['eliminar']!="")
{
	$fechaeducacioncontinuada_borrar->get('idfechaeducacioncontinuada',$_GET['eliminar']);
	//print_r($fechaeducacioncontinuada_borrar);
	$fechaeducacioncontinuada_borrar->codigoestado='200';
	$cancelar=$fechaeducacioncontinuada_borrar->update();
	if($cancelar)
	{
		echo "<script language='javascript'>alert('Asociación cancelada correctamente');</script>";
		echo "<script language='javascript'>window.location.reload('fechaeducacioncontinuada_listado.php?codigomodalidadacademica=".$_GET['codigomodalidadacademica']."&codigocarrera=".$_GET['codigocarrera']."&codigomateria=".$_GET['codigomateria']."&idgrupo=".$_GET['idgrupo']."');</script>";
	}
}
?>
<?php
if(isset($_GET['Asociar'])){
//print_r($_GET);
	unset($_GET['Asociar']);
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
		   { ?> 
		<script language="javascript">
			{
				abrir('fechaeducacioncontinuada_nuevo.php?idgrupo=<?php echo $_GET['idgrupo']?>&codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigomateria=<?php echo $_GET['codigomateria']?>','nuevoasociacionfechaeducacioncontinuada','width=700,height=250,top=200,left=150,scrollbars=yes');
			}
		</script>
	<?php }
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
	}

?>

<script language="Javascript">
function recargar() 
{ 
	window.location.reload("fechaeducacioncontinuada_listado.php?idgrupo=<?php echo $_GET['idgrupo']?>&codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigomateria=<?php echo $_GET['codigomateria']?>");
}
</script>
<?php
if(isset($_GET['Restablecer']))
{
	echo '<script language="javascript">window.location.reload("fechaeducacioncontinuada_listado.php");</script>';
}
?>
