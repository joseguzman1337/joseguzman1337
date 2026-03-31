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
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_post_bd.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_post_bd.php');
require_once realpath(dirname(__FILE__)).'/../funciones/combo.php';
require_once realpath(dirname(__FILE__)).'/../funciones/combo_bd.php';
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validarporcentaje.php');


//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;	
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
?>
<?php

$query_detallefechafinanciera="select * from detallefechafinanciera d
join conceptodetallefechafinanciera c on c.codigoconceptodetallefechafinanciera=d.codigoconceptodetallefechafinanciera
where d.iddetallefechafinanciera='".$_GET['iddetallefechafinanciera']."'";
$detallefechafinanciera=$sala->query($query_detallefechafinanciera);
$row_detallefechafinanciera=$detallefechafinanciera->fetchRow();

/*$detallefechafinanciera=DB_DataObject::factory('detallefechafinanciera');
$detallefechafinanciera->get('iddetallefechafinanciera',$_GET['iddetallefechafinanciera']);
//print_r($detallefechafinanciera);*/
?>
<form name="form1" action="" method="post">
  <p align="center" class="Estilo3">FECHA FINANCIERA - EDITAR DETALLE </p>
  <table width="100%" border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%" height="100%" border="0" align="center" cellpadding="2">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha detalle </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php escribe_formulario_fecha_vacio("fechadetallefechafinanciera","form1","",$row_detallefechafinanciera['fechadetallefechafinanciera']);
				  $validacion['fechadetallefechafinanciera']=validaciongenerica($_POST['fechadetallefechafinanciera'], "requerido", "Fecha detalle");?>
            </span></span></span>
              <div align="left"></div></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto<span class="Estilo4">*</span></div></td>
              <td nowrap bgcolor="#FEF7ED"><?php
                //($nombrevar,$nombreobjeto,$dato,$etiqueta_dato,$tablaexistente,$indicetablaexistente,$accion)
                combo_bd("codigoconceptodetallefechafinanciera","conceptodetallefechafinanciera","codigoconceptodetallefechafinanciera","nombreoconceptodetallefechafinanciera","detallefechafinanciera",$_GET['iddetallefechafinanciera'],"");?></td>
 
  </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">N&uacute;mero detalle<span class="Estilo4">*</span></div></td>          
	 <td nowrap bgcolor="#FEF7ED"><input name="numerodetallefechafinanciera" type="text" id="numerodetallefechafinanciera" size=4 value="<?php echo $row_detallefechafinanciera['numerodetallefechafinanciera'];?>"></td>

        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre detalle<span class="Estilo4">*</span></div></td>
	<td nowrap bgcolor="#FEF7ED"><input name="nombredetallefechafinanciera" type="text" id="nombredetallefechafinanciera" size=10 value="<?php echo $row_detallefechafinanciera['nombredetallefechafinanciera'];?>"></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Porcentaje<span class="Estilo4">*</span></div></td>
        	<td nowrap bgcolor="#FEF7ED"><input name="porcentajedetallefechafinanciera" type="text" id="porcentajedetallefechafinanciera" size=5 value="<?php echo $row_detallefechafinanciera['porcentajedetallefechafinanciera'];?>"></td>

        </tr>
        <tr bgcolor="#CCDADD">
          <td colspan="2" class="Estilo2"><div align="center">
              <input name="Enviar" type="submit" id="Enviar" value="Enviar">
&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Regresar" type="submit" id="Regresar" value="Regresar">
&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Eliminar" type="submit" id="Eliminar" value="Eliminar">
            </div>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<?php
if(isset($_POST['Enviar']))
{	
	$validaciongeneral=true;

	$validacion['req_codigoconceptodetallefechafinanciera']=validar($_POST['codigoconceptodetallefechafinanciera'],"requerido",'<script language="JavaScript">alert("No ha seleccionado el  concepto")</script>', true);
        $validacion['req_numerodetallefechafinanciera']=validar($_POST['numerodetallefechafinanciera'],"requerido",'<script language="JavaScript">alert("No digitado el número")</script>', true);
	$validacion['req_nombredetallefechafinanciera']=validar($_POST['nombredetallefechafinanciera'],"requerido",'<script language="JavaScript">alert("No digitado nombre detalle")</script>', true); 
      $validacion['req_porcentajedetallefechafinanciera']=validar($_POST['porcentajedetallefechafinanciera'], "numero",'<script language="JavaScript">alert("No digitado porcentaje, es valor númerico")</script>',true); 


	        foreach ($validacion as $key => $valor)
        {
                //echo $valor;
                if($valor==0)
                {
                        $validaciongeneral=false;
                }
        }

        if($validaciongeneral==true)
        {

                $query_actualiza="update detallefechafinanciera set numerodetallefechafinanciera='".$_POST['numerodetallefechafinanciera']."'
                ,nombredetallefechafinanciera='".$_POST['nombredetallefechafinanciera']."'
                ,fechadetallefechafinanciera='".$_POST['fechadetallefechafinanciera']."'
                ,porcentajedetallefechafinanciera='".$_POST['porcentajedetallefechafinanciera']."'
                ,codigoconceptodetallefechafinanciera='".$_POST['codigoconceptodetallefechafinanciera']."'
                where iddetallefechafinanciera='".$_GET['iddetallefechafinanciera']."'"; 

                $sel_actualiza = $sala->query($query_actualiza);

                if ($sel_actualiza)
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
	 $query_elimina="delete from detallefechafinanciera where iddetallefechafinanciera='".$_GET['iddetallefechafinanciera']."'";
         $sel_elimina = $sala->query($query_elimina);

	if($sel_elimina)
	{
		echo "<script language='javascript'>alert('Datos eliminados correctamente');</script>";
		echo '<script language="javascript">window.close();</script>';
		echo '<script language="javascript">window.opener.recargar();</script>';
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
