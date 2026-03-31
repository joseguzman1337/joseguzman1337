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
require_once(realpath(dirname(__FILE__)).'../../../funciones/clases/autenticacion/redirect.php');
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
$modalidadacademica=DB_DataObject::factory('modalidadacademica');
$modalidadacademica->get('codigomodalidadacademica',$_GET['codigomodalidadacademica']);
$carrera=DB_DataObject::factory('carrera');
$carrera->get('codigocarrera',$_GET['codigocarrera']);
$materia=DB_DataObject::factory('materia');
$materia->get('codigomateria',$_GET['codigomateria']);
$grupo=DB_DataObject::factory('grupo');
$grupo->get('idgrupo',$_GET['idgrupo']);

$detallefechaeducacioncontinuada=DB_DataObject::factory('detallefechaeducacioncontinuada');
$detallefechaeducacioncontinuada->get('idfechaeducacioncontinuada',$_GET['idfechaeducacioncontinuada']);


?>


<form name="form1" method="post" action="">
  <p align="center" class="Estilo3">FECHA EDUCACION CONTINUADA - DETALLE </p>
  <table width="60%" border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica </div></td>
          <td bgcolor="#FEF7ED" class="Estilo1"><div align="center">
              <input name="textfield" type="text" disabled value="<?php echo $modalidadacademica->nombremodalidadacademica?>" size="60">
          </div></td>
        </tr>
        <tr class="Estilo1">
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera</div></td>
          <td bgcolor="#FEF7ED" class="Estilo1"><div align="center">
              <input name="textfield" type="text" disabled value="<?php echo $carrera->nombrecarrera?>" size="60">
          </div></td>
        </tr>
        <tr class="Estilo1">
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Materia</div></td>
          <td bgcolor="#FEF7ED" class="Estilo1"><div align="center">
              <input name="textfield" type="text" disabled value="<?php echo $materia->nombremateria?>" size="60">
          </div></td>
        </tr>
        <tr class="Estilo1">
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Grupo</div></td>
          <td bgcolor="#FEF7ED" class="Estilo1"><div align="center">
            <input name="textfield" type="text" disabled value="<?php echo $grupo->nombregrupo?>" size="60">
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>

  <br>
  <table width="60%" border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">ID</div></td>
          <td bgcolor="#CCDADD"><div align="center">N&uacute;mero</div></td>
          <td><div align="center">Nombre</div></td>
          <td><div align="center">Fecha</div></td>
          <td bgcolor="#CCDADD"><div align="center">Porcentaje</div></td>
        </tr>
        <?php do{
		//$nombregrupo = $fechaeducacioncontinuada->getLink('idgrupo','grupo','idgrupo');
		//$nombremateriagrupo = $grupo->getlink('codigomateria','materia','codigomateria');
	 ?>
        <tr class="Estilo1">
          <td><div align="center"><a href="detallefechaeducacioncontinuada_detalle.php" onclick="abrir('detallefechaeducacioncontinuada_detalle.php?idfechaeducacioncontinuada=<?php echo $_GET['idfechaeducacioncontinuada']?>&iddetallefechaeducacioncontinuada=<?php echo $detallefechaeducacioncontinuada->iddetallefechaeducacioncontinuada?>','Editardetallefechaeducacioncontinuada','width=400,height=250,top=50,left=50,scrollbars=yes');return false"><?php echo $detallefechaeducacioncontinuada->iddetallefechaeducacioncontinuada?></a></div></td>
          <td><div align="center"><?php echo $detallefechaeducacioncontinuada->numerodetallefechaeducacioncontinuada?></div></td>
          <td><div align="center"><?php echo $detallefechaeducacioncontinuada->nombredetallefechaeducacioncontinuada?></div></td>
          <td><div align="center"><?php echo $detallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada?></div></td>
          <td><div align="center"><?php echo $detallefechaeducacioncontinuada->porcentajedetallefechaeducacioncontinuada?></div></td>
        </tr>
		    <?php }while($detallefechaeducacioncontinuada->fetch());?>
        <tr bgcolor="#CCDADD" class="Estilo1">
          <td colspan="5"><div align="center">
            <input name="Nuevo" type="submit" id="Nuevo" value="Nuevo Detalle" onclick="abrir('detallefechaeducacioncontinuada_nuevo.php?idfechaeducacioncontinuada=<?php echo $_GET['idfechaeducacioncontinuada'];?>','nuevodetallefechaeducacioncontinuada','width=300,height=250,top=200,left=150,scrollbars=yes');return false">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
          </div></td>
          </tr>
    
      </table></td>
    </tr>
  </table>
</form>
<script language="Javascript">
function recargar() 
{ 
	window.location.reload("detallefechaeducacioncontinuada_listado.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigomateria=<?php echo $_GET['codigomateria']?>&idgrupo=<?php echo $_GET['idgrupo']?>&idfechaeducacioncontinuada=<?php echo $_GET['idfechaeducacioncontinuada']?>")
}
</script>
<?php
if(isset($_POST['Regresar'])){ ?>
<script language="Javascript">window.location.reload("fechaeducacioncontinuada_listado.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigomateria=<?php echo $_GET['codigomateria']?>&idgrupo=<?php echo $_GET['idgrupo']?>&idfechaeducacioncontinuada=<?php echo $_GET['idfechaeducacioncontinuada']?>")</script>
<?php }?>