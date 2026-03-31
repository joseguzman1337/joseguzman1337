
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
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$fechahoy=date("Y-m-d");
//print_r($_POST);
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
//@session_start();
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_get.php');
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
$fechahoy=date("Y-m-d");
//DB_DataObject::debugLevel(5);
$descuentogrupoeducacioncontinuada=DB_DataObject::factory('descuentogrupoeducacioncontinuada');
$descuentogrupoeducacioncontinuada->whereAdd("fechahastadescuentogrupoeducacioncontinuada>='".$fechahoy."'");//fechadesdedescuentogrupoeducacioncontinuada<='".$fechahoy."' and
//$fechaeducacioncontinuada_borrar=DB_DataObject::factory('fechaeducacioncontinuada');

$grupo=DB_DataObject::factory('grupo');
$periodo=DB_DataObject::factory('periodo');
$periodo->get('codigoestadoperiodo','1');

if($_GET['idgrupo'])
{
	//DB_DataObject::debugLevel(5);
 	$descuentogrupoeducacioncontinuada->whereAdd('idgrupo="'.$_GET['idgrupo'].'"');
	//$descuentogrupoeducacioncontinuada->whereAdd('codigoestado="100"');
	$descuentogrupoeducacioncontinuada->get('','*'); 
	//DB_DataObject::debugLevel(0);
	//print_r($descuentogrupoeducacioncontinuada);
	//DB_DataObject::debugLevel(0);
	$grupo->get('idgrupo',$_GET['idgrupo']);
	//print_r($grupo);
}
?>


<form name="form1" action="" method="get">
  <p align="center" class="Estilo3"> DESCUENTO GRUPOS EDUCACION CONTINUADA - LISTADO </p>
  <table width="90%" border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Modalidad Acad&eacute;mica </div></td>
          <td bgcolor="#FEF7ED"><div align="left"></div>
            <?php $validacion['codigomodalidadacademica']=combo_valida_get("codigomodalidadacademica","modalidadacademica","codigomodalidadacademica","nombremodalidadacademica",'onChange=enviar()',"","","si","Modalidad acad&eacute;mica")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Carrera</div></td>
          <td bgcolor="#FEF7ED"><div align="left"></div>
            <?php $validacion['codigocarrera']=combo_valida_get("codigocarrera","carrera","codigocarrera","nombrecarrera",'onChange=enviar()',"codigomodalidadacademica='".$_GET['codigomodalidadacademica']."' and codigoreferenciacobromatriculacarrera='200' and fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."'","nombrecarrera asc","si","carrera")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Materia</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['codigomateria']=combo_valida_get("codigomateria","materia","codigomateria","nombremateria",'onChange=enviar()',"codigocarrera='".$_GET['codigocarrera']."' and codigoestadomateria=01","","si","Materia")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Grupo</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['idgrupo']=combo_valida_get("idgrupo","grupo","idgrupo","nombregrupo",'onChange=enviar()','codigoperiodo='.$periodo->codigoperiodo.' and codigomateria='.$_GET['codigomateria'].' and codigoestadogrupo like "1%"',"","si","Grupo")?></td>
        </tr>
      </table></td>
    </tr>
  </table>

  <br>
  <table width="90%" border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr bgcolor="#FEF7ED" class="Estilo2">
          <td colspan="6"><div align="center">GRUPOS CON DESCUENTO EDUCACION CONTINUADA </div></td>
          </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">ID</div></td>
          <td bgcolor="#CCDADD"><div align="center">Descripcion</div></td>
          <td bgcolor="#CCDADD"><div align="center">Descuento</div></td>
          <td bgcolor="#CCDADD"><div align="center">Fecha desde </div></td>
          <td bgcolor="#CCDADD"><div align="center">Fecha Hasta </div></td>
          <td bgcolor="#CCDADD"><div align="center">Directivo autoriza </div></td>
        </tr>
        <?php do{
		$nombregrupo=$descuentogrupoeducacioncontinuada->getLink('idgrupo','grupo','idgrupo');
		$nombremateriagrupo=$grupo->getlink('codigomateria','materia','codigomateria');
		$nombredescuentoeducacioncontinuada=$descuentogrupoeducacioncontinuada->getLink('iddescuentoeducacioncontinuada','descuentoeducacioncontinuada','iddescuentoeducacioncontinuada');
		$nombredirectivo=$descuentogrupoeducacioncontinuada->getLink('iddirectivo','directivo','iddirectivo');
	 ?>
        <tr class="Estilo1">
          <td><div align="center"><?php echo $descuentogrupoeducacioncontinuada->iddescuentogrupoeducacioncontinuada?></div></td>
          <td>
            <div align="center"><a href="descuentogrupoeducacioncontinuada_detalle.php" onclick="abrir('descuentogrupoeducacioncontinuada_detalle.php?idgrupo=<?php echo $_GET['idgrupo']?>&codigomateria=<?php echo $_GET['codigomateria']?>&codigoperiodo=<?php echo $periodo->codigoperiodo?>&iddescuentogrupoeducacioncontinuada=<?php echo $descuentogrupoeducacioncontinuada->iddescuentogrupoeducacioncontinuada?>','Detalledescuentogrupoeducacioncontinuada','width=600,height=300,top=50,left=50,scrollbars=yes');return false"><?php echo $descuentogrupoeducacioncontinuada->descripciondescuentogrupoeducacioncontinuada?></a></div></td>
          <td><div align="center"><?php echo $nombredescuentoeducacioncontinuada->nombredescuentoeducacioncontinuada?></div></td>
          <td><div align="center"><?php echo $descuentogrupoeducacioncontinuada->fechadesdedescuentogrupoeducacioncontinuada?></div></td>
          <td><div align="center"><?php echo $descuentogrupoeducacioncontinuada->fechahastadescuentogrupoeducacioncontinuada?></div></td>
          <td><div align="center"><?php echo $nombredirectivo->apellidosdirectivo,' ',$nombredirectivo->nombresdirectivo?></div></td>
        </tr>
        <?php }while($descuentogrupoeducacioncontinuada->fetch());?>
		<tr bgcolor="#FEF7ED" class="Estilo1">
   		    <td colspan="6"><div align="center">
			<input name="Asociar" type="submit" id="Asociar" value="Asociar Grupo">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Restablecer" type="submit" id="Restablecer" value="Restablecer">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
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
				abrir('descuentogrupoeducacioncontinuada_nuevo.php?idgrupo=<?php echo $_GET['idgrupo']?>&codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigomateria=<?php echo $_GET['codigomateria']?>&codigoperiodo=<?php echo $periodo->codigoperiodo?>','nuevoasociacionfechaeducacioncontinuada','width=700,height=300,top=200,left=150,scrollbars=yes');
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
	window.location.reload("descuentogrupoeducacioncontinuada_listado.php?idgrupo=<?php echo $_GET['idgrupo']?>&codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigomateria=<?php echo $_GET['codigomateria']?>");
}
</script>
<?php
if(isset($_GET['Restablecer']))
{
	echo '<script language="javascript">window.location.reload("descuentogrupoeducacioncontinuada_listado.php");</script>';
}
?>
<?php
if(isset($_GET['Regresar']))
{
	echo "<script language='javascript'>window.location.reload('menu.php');</script>";
}
?>