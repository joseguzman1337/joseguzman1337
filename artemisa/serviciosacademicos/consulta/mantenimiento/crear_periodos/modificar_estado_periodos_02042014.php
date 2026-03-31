<script language="javascript">
function enviar()
{
	document.periodos.submit()
}
</script>
<script language="JavaScript" src="calendario/javascripts.js"></script>
<?php
ini_set("include_path", ".:/usr/share/pear_");
//print_r($_POST);
//error_reporting(2047);
require_once('../funciones/validacion.php');
require_once('../../../Connections/sala2.php');
require_once '../funciones/pear/PEAR.php';
require_once '../funciones/pear/DB.php';
require_once('../funciones/pear/DB/DataObject.php');
require_once '../funciones/combo.php';
require_once '../funciones/combo_bd.php';
require_once '../funciones/conexion/conexion.php';
require_once('calendario/calendario.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');
//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
?>

<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FF0000}
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
<form name="periodos" method="post" action="">

  <p align="center"><span class="Estilo2"><span class="Estilo3">CREAR PERIODOS - MODIFICACION DE ESTADO PERIODO </span></span></p>
  <table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="200" border="0" align="center" cellpadding="3">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">A&ntilde;o<span class="Estilo4">*</span> </div></td>
          <td bgcolor="#FEF7ED"><?php combo("ano","ano","codigoano","codigoano",'onchange="enviar()"','');?>
          </td>
        </tr>
        <tr>
          <td colspan="2" bgcolor="#CCDADD"><div align="center">
              <input name="Regresar" type="submit" id="Regresar" value="Regresar">
          </div></td>
        </tr>
        <?php
  if(isset($_POST['ano']))
{ 
  
$query_periodo="select * from periodo p
where codigoperiodo like '".$_POST['ano']."%'";
$periodo=$sala->query($query_periodo);

	
 /* $periodo = DB_DataObject::factory('periodo');
  $periodo->get('codigoperiodo',$_POST['codigoperiodo']);
  $periodo_mod=clone($periodo);
  $periodo_mod->query("select distinct * FROM {$periodo->__table} where codigoperiodo like '".$_POST['ano']."%'");*/
  
  ?>
        <tr>
          <td bgcolor="#CCDADD"><div align="center"><span class="Estilo2">Periodo</span><span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><select name="codigoperiodo" id="codigoperiodo" onchange="enviar()" >
              <option value="">Seleccionar</option>
              <?php

            while ($row_periodo=$periodo->fetchRow()){
?>
              <option value="<?php echo $row_periodo['codigoperiodo'];?>"<?php if($_POST['codigoperiodo'] == $row_periodo['codigoperiodo']){echo "selected";}?>><?php echo $row_periodo['nombreperiodo'];?></option>
              <?php
            }
?>
            </select>
          </td>
        </tr>

        <?php if(isset($_POST['codigoperiodo'])){ 
	$query_periododtl="select * from periodo p
	where codigoperiodo= '".$_POST['codigoperiodo']."'";
	$periododtl=$sala->query($query_periododtl);
	$row_periododtl=$periododtl->fetchRow()

	?>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha inicio periodo<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php escribe_formulario_fecha_vacio("fechainicioperiodo","periodos","",$row_periododtl['fechainicioperiodo']); ?>
          </span> </span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha vencimiento  periodo<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php escribe_formulario_fecha_vacio("fechavencimientoperiodo","periodos","",$row_periododtl['fechavencimientoperiodo']); ?>
          </span> </span></span></td>
        </tr>
	<input type="hidden" name="estadoanterior" value="<?php echo $row_periododtl['codigoestadoperiodo']; ?>">
        <tr>
	<?php 
	$query_estperiodo="select * from estadoperiodo";
        $estperiodo=$sala->query($query_estperiodo);
	 ?>
          <td bgcolor="#CCDADD"><div align="center"><span class="Estilo2">Estado</span><span class="Estilo4">*</span></div></td>
<td bgcolor="#FEF7ED"><select name="codigoestadoperiodo" id="codigoestadoperiodo">
              <option value="">Seleccionar</option>
              <?php

            while ($row_estperiodo=$estperiodo->fetchRow()){
?>              
              <option value="<?php echo $row_estperiodo['codigoestadoperiodo'];?>"<?php if($row_periododtl['codigoestadoperiodo'] == $row_estperiodo['codigoestadoperiodo']){echo "selected";}?>><?php echo $row_estperiodo['nombreestadoperiodo'];?></option>
              <?php
            }
?>        
            </select>
          </td>
        </tr>
        <?php }?>
        <tr>
          <td colspan="2" bgcolor="#CCDADD"><div align="center">
              <input name="Cambiar" type="submit" id="Cambiar" value="Cambiar">
          </div></td>
        </tr>
        <?php } ?>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>

<?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.href='menu.php';</script>";
  }
?>

<?php
if(isset($_POST['Cambiar']))
{
	$validaciongeneral=true;

	$validacion['req_fechainicioperiodo']=validar($_POST['fechainicioperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de incio del  periodo")</script>', true);
	$validacion['num_ano_fechainicioperiodo']=validafechaano($_POST['ano'],$_POST['fechainicioperiodo'],'mayor','<script language="JavaScript">alert("La fecha de inicio del periodo no corresponde con el año seleccionado")</script>', true);

	$validacion['req_fechavencimientoperiodo']=validar($_POST['fechavencimientoperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de vencimiento del  periodo")</script>', true);
	$validacion['num_ano_fechavencimientoperiodo']=validafechaano($_POST['ano'],$_POST['fechavencimientoperiodo'],'mayor','<script language="JavaScript">alert("La fecha vencimiento del periodo, no corresponde con el año seleccionado")</script>', true);

	$validacion['dat_fechainicio_fechavem_periodo']=validadosfechas($_POST['fechainicioperiodo'],$_POST['fechavencimientoperiodo'],'mayor','<script language="JavaScript">alert("La fecha de vencimiento del  periodo no puede ser menor menor a la fecha de inicio")</script>', true);

	foreach ($validacion as $key => $valor)
	{
		//echo $valor;
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}	
	$codigoestadoperiodo=$_POST['codigoestadoperiodo'];
	//echo $codigoestadoperiodo;
	if($codigoestadoperiodo != $_POST['estadoanterior']){
	switch ($codigoestadoperiodo)
		{
			case "1":
				$query_periodos_activos="select * from periodo where codigoestadoperiodo ='1';";
				$periodos_activos=$sala->query($query_periodos_activos);
				$num_peridos_activos=$periodos_activos->numRows();
				if($num_peridos_activos>0){
					echo "<script language='javascript'>alert('No puede haber mas de un periodo en estado vigente para el año seleccionado');</script>";
					$validaciongeneral=false;
				}
				
				break;
				
			case "3":
				$query_periodos_precierre="select * from periodo where codigoestadoperiodo ='3';";
				$periodos_precierre=$sala->query($query_periodos_precierre);
				$num_peridos_precierre=$periodos_precierre->numRows();
				if($num_peridos_precierre>0){
					echo "<script language='javascript'>alert('No puede haber mas de un periodo en estado precierre para el año seleccionado');</script>";
					$validaciongeneral=false;}
				break;
	
		}
	}
	if($validaciongeneral==true){

		$query_actualiza="update periodo set codigoestadoperiodo='".$_POST['codigoestadoperiodo']."'
                ,fechainicioperiodo='".$_POST['fechainicioperiodo']."'
                ,fechavencimientoperiodo='".$_POST['fechavencimientoperiodo']."'
                where codigoperiodo='".$_POST['codigoperiodo']."'";

                $sel_actualiza = $sala->query($query_actualiza);

	/*$periodo->codigoestadoperiodo=$_POST['codigoestadoperiodo'];
	$periodo->fechainicioperiodo=$_POST['fechainicioperiodo'];
	$periodo->fechavencimientoperiodo=$_POST['fechavencimientoperiodo'];
	//DB_DataObject::debugLevel(5);
	$actualizar=$periodo->update();
	//DB_DataObject::debugLevel(0);*/
	if($sel_actualiza)
	{
		echo "<script language='javascript'>alert('Cambio de estado de periodo realizado');</script>";
		echo "<script language='javascript'>window.location.href='menu.php';</script>"; 
	}
  }
	
}
?>
