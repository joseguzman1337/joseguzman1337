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
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_get.php');
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validardosfechas.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/arreglarfecha.php');


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
$grupo=DB_DataObject::factory('grupo');
$materia=DB_DataObject::factory('materia');
$fechahoy=date("Y-m-d");
$fechaeducacioncontinuada=DB_DataObject::factory('fechaeducacioncontinuada');
$detallefechaeducacioncontinuada=DB_DataObject::factory('detallefechaeducacioncontinuada');
$periodo=DB_DataObject::factory('periodo');
$periodo->get('codigoestadoperiodo','1');
$grupo->get('idgrupo',$_GET['idgrupo']);
$materia->get('codigomateria',$_GET['codigomateria']);
$query_ultimo_detallefechaeducacioncontinuada="select max(iddetallefechaeducacioncontinuada)as iddetallefechaeducacioncontinuada from detallefechaeducacioncontinuada where idfechaeducacioncontinuada='".$_GET['idfechaeducacioncontinuada']."'";
//echo $query_ultimo_detallefechaeducacioncontinuada;
$ultimo_detallefechaeducacioncontinuada=$sala->query($query_ultimo_detallefechaeducacioncontinuada);
$row_ultimodetallefechaeducacioncontinuada=$ultimo_detallefechaeducacioncontinuada->fetchRow();
$consultadetallefechaeducacioncontinuada=DB_DataObject::factory('detallefechaeducacioncontinuada');
$consultadetallefechaeducacioncontinuada->get('iddetallefechaeducacioncontinuada',$row_ultimodetallefechaeducacioncontinuada['iddetallefechaeducacioncontinuada']);
//print_r($consultadetallefechaeducacioncontinuada);


?>


<form name="form1" action="" method="get">
  <p align="center" class="Estilo3"> FECHA EDUCACION CONTINUADA - ASOCIAR NUEVO GRUPO </p>
  <table width="60%" border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Materia</div></td>
          <td bgcolor="#FEF7ED"><input name="textfield" type="text" disabled value="<?php echo $materia->nombremateria;?>" size="40">
            <input name="codigomateria" type="hidden" id="codigomateria" value="<?php echo $_GET['codigomateria']?>"></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Grupo</div></td>
          <td bgcolor="#FEF7ED"><input name="textfield" type="text" disabled value="<?php echo $grupo->nombregrupo;?>" size="40">
            <input name="idgrupo" type="hidden" id="idgrupo" value="<?php echo $_GET['idgrupo']?>">            
            </td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Fecha</div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php escribe_formulario_fecha_vacio("fechadetallefechaeducacioncontinuada","form1","",$_GET['fechadetallefechaeducacioncontinuada']);
				  $validacion['fechadetallefechaeducacioncontinuada']=validaciongenerica($_GET['fechadetallefechaeducacioncontinuada'], "requerido", "Fecha detalle");
				  $fechadetallefechaeducacioncontinuada=arreglarfecha($_GET['fechadetallefechaeducacioncontinuada']);
				  //echo $fechadetallefechaeducacioncontinuada;echo $consultadetallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada;
				  if($fechadetallefechaeducacioncontinuada <= $consultadetallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada)
					  {
							echo "<style type='text/css'><!--.Estilo99{font-size: 18px;color: #FF0000;}--></style>";
							echo "<span class='Estilo99'>*</span>";
							$valido['mensaje']="La fecha seleccionada, se cruza con fechas anteriores";
							$valido['valido'] = 0;
							$validacion['fechamayordetallefecuaeducacioncontinuada']=$valido;
					  }
		  ?>
          </span></span></span></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">N&uacute;mero</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['numerodetallefechaeducacioncontinuada']=campotexto_valida_get("numerodetallefechaeducacioncontinuada","numero","Número","5")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Nombre</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['nombredetallefechaeducacioncontinuada']=campotexto_valida_get("nombredetallefechaeducacioncontinuada","requerido","Nombre","10")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Porcentaje</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['porcentajedetallefechaeducacioncontinuada']=campotexto_valida_get("porcentajedetallefechaeducacioncontinuada","porcentaje","porcentaje","10")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td colspan="2" bgcolor="#FEF7ED"><div align="center">
            <input name="Asociar" type="submit" id="Asociar" value="Asociar">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
          </div></td>
          </tr>
      </table></td>
    </tr>
  </table>

  <br>
</form>
<?php
if(isset($_GET['Asociar']))
{
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		$fechaeducacioncontinuada->idgrupo=$grupo->idgrupo;
		$fechaeducacioncontinuada->codigoestado='100';
		//DB_DataObject::debugLevel(5);
		$insertar=$fechaeducacioncontinuada->insert();
		//DB_DataObject::debugLevel(0);
		if($insertar)
		{
			$detallefechaeducacioncontinuada->idfechaeducacioncontinuada=$insertar;
			$detallefechaeducacioncontinuada->numerodetallefechaeducacioncontinuada=$_GET['numerodetallefechaeducacioncontinuada'];
			$detallefechaeducacioncontinuada->nombredetallefechaeducacioncontinuada=$_GET['nombredetallefechaeducacioncontinuada'];
			$detallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada=$_GET['fechadetallefechaeducacioncontinuada'];
			$detallefechaeducacioncontinuada->porcentajedetallefechaeducacioncontinuada=$_GET['porcentajedetallefechaeducacioncontinuada'];
			$insertar_detalle=$detallefechaeducacioncontinuada->insert();
			if($insertar_detalle)
			{
				echo "<script language='javascript'>alert('Grupo asociado correctamente');</script>";
				echo '<script language="javascript">window.close();</script>';
				echo '<script language="javascript">window.opener.recargar();</script>';
			}
		}
	}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}
?>
<?php
if(isset($_POST['Regresar']))
{
	echo '<script language="javascript">window.close();</script>';
	echo '<script language="javascript">window.opener.recargar();</script>';
}
?>
