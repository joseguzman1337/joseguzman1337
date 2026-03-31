<style type="text/css">@import url(../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar-setup.js"></script>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
</script>

<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.Estilo5 {font-family: Tahoma; font-size: 12px}
.verdoso {background-color: #CCDADD;font-family: Tahoma; font-size: 12px; font-weight: bold;}
.amarrillento {background-color: #FEF7ED;font-family: Tahoma; font-size: 11px}
-->
</style>
<?php
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
require_once('../funciones/validacion.php');
require_once('../funciones/conexion/conexion.php');
require_once('../funciones/pear/PEAR.php');
require_once('../funciones/pear/DB.php');
require_once('../funciones/pear/DB/DataObject.php');
require_once('../funciones/gui/combo_valida_post_bd.php');
require_once('../funciones/gui/campotexto_valida_post_bd.php');
require_once('../funciones/gui/campofecha_valida_post_bd.php');
require_once('../funciones/validaciones/validardosfechas.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');
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
$fechahoy=date("Y-m-d H:i:s");
//$valoreducacioncontinuada=DB_DataObject::factory('valoreducacioncontinuada');
//$valoreducacioncontinuada->get('idvaloreducacioncontinuada',$_GET['idvaloreducacioncontinuada']);


$query_valeducon = "select * from valoreducacioncontinuada 
where idvaloreducacioncontinuada  ='".$_GET['idvaloreducacioncontinuada']."'";
$valeducon = $sala->query($query_valeducon);
$row_valeducon = $valeducon->fetchRow();

$query_conceptos = "select * from concepto
where codigoestado like '1%'
order by 2;";
$conceptos = $sala->query($query_conceptos);
$row_conceptos = $conceptos->fetchRow();

//print_r($valoreducacioncontinuada);
?>
<form name="form1" method="post" action="">
  <p align="center" class="Estilo3">VALORE EDUCACION CONTINUADA - EDITAR </p>
  <table width="100%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" cellpadding="2" cellspacing="2">
        <tr>
          <td class="verdoso">Carrera</td>
          <td class="amarrillento"><div align="left"><?php echo $_GET['nombrecarrera']?></div></td>
        </tr>
        <tr>
          <td class="verdoso">Nombre</td>
          <td class="amarrillento"><div align="left">
		 <input name="nombrevaloreducacioncontinuada" type="text" id="nombrevaloreducacioncontinuada" value="<?php echo $row_valeducon['nombrevaloreducacioncontinuada'];?>">
          </div></td>
        </tr>
        <tr>
          <td class="verdoso">Concepto</td>
          <td class="amarrillento">
		<select name="codigoconcepto" id="codigoconcepto">
                <option value="">Seleccionar</option>
                <?php
                  do {
                ?>
                <option value="<?php echo $row_conceptos['codigoconcepto'];?>"
                <?php if(isset($_POST['codigoconcepto']) && $_POST['codigoconcepto'] == $row_conceptos['codigoconcepto']){
                                        echo "selected";
                        }
                        else{
                        if($row_valeducon['codigoconcepto'] == $row_conceptos['codigoconcepto']){
                                        echo "selected"; }

                        }
                        ?>><?php echo $row_conceptos['nombreconcepto'];?></option>
                <?php
                  } while ($row_conceptos = $conceptos->fetchRow());
                ?>
            </select>
            <div align="left"></div></td>
        </tr>
        <tr>
          <td class="verdoso">Precio</td>
          <td class="amarrillento"><div align="left">
		<input name="preciovaloreducacioncontinuada" type="text" id="preciovaloreducacioncontinuada" value="<?php echo $row_valeducon['preciovaloreducacioncontinuada'];?>">
          </div></td>
        </tr>
        <tr>
          <td class="verdoso">Fecha Inicio </td>
          <td class="amarrillento"><div align="left">
		<input name="fechainiciovaloreducacioncontinuada" type="text" id="fechainiciovaloreducacioncontinuada" value="<?php echo $row_valeducon['fechainiciovaloreducacioncontinuada'];?>">
              <button id="btfechainiciovaloreducacioncontinuada">...</button>
          </div></td>
        </tr>
        <tr>
          <td class="verdoso">Fecha Final </td>
          <td class="amarrillento"><div align="left">
		<input name="fechafinalvaloreducacioncontinuada" type="text" id="fechafinalvaloreducacioncontinuada" value="<?php echo $row_valeducon['fechafinalvaloreducacioncontinuada'];?>">
              <button id="btfechafinalvaloreducacioncontinuada">...</button>
          </div></td>
        </tr>
        <tr>
          <td colspan="2" class="verdoso"><div align="center">
              <input name="Guardar" type="submit" id="Guardar" value="Guardar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
        $validacion['req_nombrevaloreducacioncontinuada']=validar($_POST['nombrevaloreducacioncontinuada'],"requerido",'<script language="JavaScript">alert("No ha digitado el nombre")</script>', true);
        $validacion['req_codigoconcepto']=validar($_POST['codigoconcepto'],"requerido",'<script language="JavaScript">alert("No ha seleccionado un concepto")</script>', true);
        $validacion['req_preciovaloreducacioncontinuada']=validar($_POST['preciovaloreducacioncontinuada'],"numero",'<script language="JavaScript">alert("No ha digitado un valor.")</script>', true);
        $validacion['req_fechainiciovaloreducacioncontinuada']=validar($_POST['fechainiciovaloreducacioncontinuada'],"requerido",'<script language="JavaScript">alert("No ha digitado o seleccionado una fecha inicio.")</script>', true);
        $validacion['fechafinalvaloreducacioncontinuada']=validar($_POST['fechafinalvaloreducacioncontinuada'],"requerido",'<script language="JavaScript">alert("No ha digitado o seleccionado una fecha final.")</script>', true);

        foreach ($validacion as $key => $valor)
        {
                if($valor==0)
                {
                        $validaciongeneral=false;
                }
        }
        if($validaciongeneral==true)
        {


                $query_actualiza="update valoreducacioncontinuada set nombrevaloreducacioncontinuada='".$_POST['nombrevaloreducacioncontinuada']."'
                ,codigoconcepto='".$_POST['codigoconcepto']."'
                ,preciovaloreducacioncontinuada='".$_POST['preciovaloreducacioncontinuada']."'
                ,fechainiciovaloreducacioncontinuada='".$_POST['fechainiciovaloreducacioncontinuada']."'
                ,fechafinalvaloreducacioncontinuada='".$_POST['fechafinalvaloreducacioncontinuada']."'
                where idvaloreducacioncontinuada='".$_GET['idvaloreducacioncontinuada']."'";
                $sel_actualiza = $sala->query($query_actualiza);
  
                if($sel_actualiza)
                {
                        echo "<script language='javascript'>alert('Datos modificados correctamente');</script>";
                        echo '<script language="javascript">window.close();</script>';
			echo '<script language="javascript">window.opener.recargar();</script>';
                }
        }
}
?>

<?php 
if(isset($_POST['Eliminar']))
{
                $query_anula = "update valoreducacioncontinuada set fechainiciovaloreducacioncontinuada='0000-00-00'
		,fechafinalvaloreducacioncontinuada='0000-00-00', fechavaloreducacioncontinuada='".$fechahoy."'
                where idvaloreducacioncontinuada='".$_GET['idvaloreducacioncontinuada']."'";
                $sel_anula = $sala->query($query_anula);

                if ($sel_anula)
                {
			echo "<script language='javascript'>alert('Datos eliminados correctamente');</script>";
	                echo '<script language="javascript">window.close();</script>';
        	        echo '<script language="javascript">window.opener.recargar();</script>';
                }
}
?>

<script type="text/javascript">
Calendar.setup(
{
inputField : "fechainiciovaloreducacioncontinuada", // ID of the input field
ifFormat : "%Y-%m-%d", // the date format
button : "btfechainiciovaloreducacioncontinuada" // ID of the button
}
);
</script>

<script type="text/javascript">
Calendar.setup(
{
inputField : "fechafinalvaloreducacioncontinuada", // ID of the input field
ifFormat : "%Y-%m-%d", // the date format
button : "btfechafinalvaloreducacioncontinuada" // ID of the button
}
);
</script>
