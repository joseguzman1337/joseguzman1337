<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FF0000}
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
<?php
//print_r($_POST);
ini_set("include_path", ".:/usr/share/pear_");
require_once '../funciones/pear/PEAR.php';
require_once '../funciones/pear/DB.php';
require_once('../funciones/validacion.php');
require_once('../../../Connections/sala2.php');
require_once '../funciones/combo.php';
require_once '../funciones/combo_bd.php';
require_once '../funciones/pear/DB/DataObject.php';
require_once '../funciones/gui/combo_valida_post_bd.php';
require_once '../funciones/gui/campotexto_valida_post_bd.php';
require_once '../funciones/conexion/conexion.php';
require_once('../../../funciones/clases/autenticacion/redirect.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
?>
<?php
//@session_start();

$query_caconcepto = "select * from valorpecuniario v, concepto p
where v.idvalorpecuniario='".$_GET['idvalorpecuniario']."'
and v.codigoconcepto=p.codigoconcepto";
$sel_caconcepto = $sala->query($query_caconcepto);
$row_caconcepto = $sel_caconcepto->fetchRow();

$query_indicador = "SELECT * from indicadorprocesointernet";
$indicador = $sala->query($query_indicador);
$row_indicador = $indicador->fetchRow();


//$consulta_valorpecuniario=DB_DataObject::factory('valorpecuniario');
//$valorpecuniario=DB_DataObject::factory('valorpecuniario');
//$periodo = DB_DataObject::factory('periodo');
//$periodo->whereADD('codigoestadoperiodo=1');
//$periodo->get('','*');
//$valorpecuniario->get('idvalorpecuniario',$_GET['idvalorpecuniario']);
?>

<form name="form1" method="post" action="">

<p align="center" class="Estilo3">Editar valor  pecuniario </p>
<table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="200" border="0" align="center" cellpadding="3">
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Codigoperiodo<span class="Estilo4"></span> </div></td>
        <td nowrap bgcolor="#FEF7ED"><?php echo $_GET['codigoperiodo'];?> </td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto</div></td>
        <td nowrap bgcolor="#FEF7ED"><?php echo $row_caconcepto['nombreconcepto'];?></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor pecuniario</div></td>
        <td nowrap bgcolor="#FEF7ED"><input name="valorpecuniario" type="text" id="valorpecuniario" value="<?php echo $row_caconcepto['valorpecuniario'];?>">
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Indicador proceso internet </div></td>
        <td nowrap bgcolor="#FEF7ED">
	    <select name="codigoindicadorprocesointernet" id="codigoindicadorprocesointernet">
                <option value="">Seleccionar</option>
                <?php
                  do {
		?>
                <option value="<?php echo $row_indicador['codigoindicadorprocesointernet'];?>"
		<?php if(isset($_POST['codigoindicadorprocesointernet']) && $_POST['codigoindicadorprocesointernet'] == $row_indicador['codigoindicadorprocesointernet']){
					echo "selected";
			}
			else{
			if($row_caconcepto['codigoindicadorprocesointernet'] == $row_indicador['codigoindicadorprocesointernet']){
                                        echo "selected"; }
			
			}
			?>><?php echo $row_indicador['nombreindicadorprocesointernet'];?></option>
                <?php
                  } while ($row_indicador = $indicador->fetchRow());
		?>
            </select>
	</td>
      </tr>
      <tr>
        <td colspan="2" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">
            <input name="Guardar" type="submit" id="Guardar" value="Guardar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Eliminar" type="submit" id="Eliminar" value="Eliminar">
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>

<?php
if(isset($_POST['Guardar']))
{
	$validaciongeneral=true;
       
       	$validacion['req_valorpecuniario']=validar($_POST['valorpecuniario'],"numero",'<script language="JavaScript">alert("No ha digitado un valor valido")</script>', true);
        $validacion['req_codigoindicadorprocesointernet']=validar($_POST['codigoindicadorprocesointernet'],"requerido",'<script language="JavaScript">alert("No ha seleccionado un indicador proceso internet")</script>', true);

	foreach ($validacion as $key => $valor)
	{
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}
	if($validaciongeneral==true)
	{

		$query_actualiza="update valorpecuniario set codigoindicadorprocesointernet='".$_POST['codigoindicadorprocesointernet']."'
                ,valorpecuniario='".$_POST['valorpecuniario']."'
                where idvalorpecuniario='".$_GET['idvalorpecuniario']."'";
                $sel_actualiza = $sala->query($query_actualiza);


		/*$valorpecuniario->codigoconcepto=$_POST['codigoconcepto'];
		$valorpecuniario->valorpecuniario=$_POST['valorpecuniario'];
		$valorpecuniario->codigoindicadorprocesointernet=$_POST['codigoindicadorprocesointernet'];
		//DB_DataObject::debugLevel(5);
		$actualizar=$valorpecuniario->update();
		//DB_DataObject::debugLevel(0);*/
		if($sel_actualiza)
		{
			echo "<script language='javascript'>alert('Datos modificados correctamente');</script>";
			echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';
		}
	}
	
}
?>

<?php
if(isset($_POST['Eliminar']))
{
	
		$query_anula = "update valorpecuniario set codigoestado='200'
                where idvalorpecuniario='".$_GET['idvalorpecuniario']."'";
                $sel_anula = $sala->query($query_anula);

                /*$mod_fecha_carrera_concepto->fechafechacarreraconcepto=$fechacarreraconcepto;
                $mod_fecha_carrera_concepto->fechainiciofechacarreraconcepto='0000-00-00';
                $mod_fecha_carrera_concepto->fechavencimientofechacarreraconcepto='0000-00-00';
                $mod_fecha_carrera_concepto->idusuario=$usuario->idusuario;
                $mod_fecha_carrera_concepto->ip=$ip;
                $anular=$mod_fecha_carrera_concepto->update();*/
                if ($sel_anula)
                {
                echo "<script language='javascript'>alert('Dato eliminado correctamente');</script>";
		echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';
	}	
}
?>
