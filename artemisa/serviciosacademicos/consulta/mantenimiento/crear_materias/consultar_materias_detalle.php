<?php
 session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
//echo "	ENTRO O NO ENTRO?";
?>
<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>

<?php
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
//require_once('../../../funciones/clases/autenticacion/redirect.php');
//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
?>
<?php
mysql_select_db($database_sala, $sala);
$query_materias = "SELECT * FROM materia m  where m.codigomateria='".$_GET['codigomateria']."'";
$materias = mysql_query($query_materias, $sala) or die(mysql_error());
$row_materias = mysql_fetch_assoc($materias);
$totalRows_materias = mysql_num_rows($materias);

mysql_select_db($database_sala, $sala);
$query_sel_modalidadmateria = "SELECT * FROM modalidadmateria mm  order by nombremodalidadmateria";
$sel_modalidadmateria = mysql_query($query_sel_modalidadmateria, $sala) or die(mysql_error());
$row_sel_modalidadmateria = mysql_fetch_assoc($sel_modalidadmateria);
$totalRows_sel_modalidadmateria = mysql_num_rows($sel_modalidadmateria);

mysql_select_db($database_sala, $sala);
$query_sel_lineaacademica = "SELECT * FROM lineaacademica  order by nombrelineaacademica";
$sel_lineaacademica = mysql_query($query_sel_lineaacademica, $sala) or die(mysql_error());
$row_sel_lineaacademica = mysql_fetch_assoc($sel_lineaacademica);
$totalRows_sel_lineaacademica = mysql_num_rows($sel_lineaacademica);

mysql_select_db($database_sala, $sala);
$query_sel_codigocarrera = "SELECT distinct * FROM carrera c, carreraperiodo cp
where cp.codigoestado='100' and c.codigocarrera=cp.codigocarrera group by cp.codigocarrera
 order by c.nombrecarrera
 ";
$sel_codigocarrera = mysql_query($query_sel_codigocarrera, $sala) or die(mysql_error());
$row_sel_codigocarrera = mysql_fetch_assoc($sel_codigocarrera);
$totalRows_sel_codigocarrera = mysql_num_rows($sel_codigocarrera);

mysql_select_db($database_sala, $sala);
$query_sel_codigoindicadorgrupomateria = "SELECT * FROM indicadorgrupomateria order by nombreindicadorgrupomateria";
$sel_codigoindicadorgrupomateria = mysql_query($query_sel_codigoindicadorgrupomateria, $sala) or die(mysql_error());
$row_sel_codigoindicadorgrupomateria = mysql_fetch_assoc($sel_codigoindicadorgrupomateria);
$totalRows_sel_codigoindicadorgrupomateria = mysql_num_rows($sel_codigoindicadorgrupomateria);


mysql_select_db($database_sala, $sala);
$query_sel_codigotipomateria = "SELECT * FROM tipomateria order by nombretipomateria";
$sel_codigotipomateria = mysql_query($query_sel_codigotipomateria, $sala) or die(mysql_error());
$row_sel_codigotipomateria = mysql_fetch_assoc($sel_codigotipomateria);
$totalRows_sel_codigotipomateria = mysql_num_rows($sel_codigotipomateria);

mysql_select_db($database_sala, $sala);
$query_sel_codigoindicarcredito = "SELECT * FROM indicarcredito order by nombreindicarcredito";
$sel_codigoindicarcredito = mysql_query($query_sel_codigoindicarcredito, $sala) or die(mysql_error());
$row_sel_codigoindicarcredito = mysql_fetch_assoc($sel_codigoindicarcredito);
$totalRows_sel_codigoindicarcredito = mysql_num_rows($sel_codigoindicarcredito);

mysql_select_db($database_sala, $sala);
$query_sel_codigoindicadoretiquetamateria = "SELECT * FROM indicadoretiquetamateria order by nombreindicadoretiquetamateria";
$sel_codigoindicadoretiquetamateria = mysql_query($query_sel_codigoindicadoretiquetamateria, $sala) or die(mysql_error());
$row_sel_codigoindicadoretiquetamateria = mysql_fetch_assoc($sel_codigoindicadoretiquetamateria);
$totalRows_sel_codigoindicadoretiquetamateria = mysql_num_rows($sel_codigoindicadoretiquetamateria);

mysql_select_db($database_sala, $sala);
$query_sel_codigotipocalificacionmateria = "SELECT * FROM tipocalificacionmateria order by nombretipocalificacionmateria";
$sel_codigotipocalificacionmateria = mysql_query($query_sel_codigotipocalificacionmateria, $sala) or die(mysql_error());
$row_sel_codigotipocalificacionmateria = mysql_fetch_assoc($sel_codigotipocalificacionmateria);
$totalRows_sel_codigotipocalificacionmateria = mysql_num_rows($sel_codigotipocalificacionmateria);


mysql_select_db($database_sala, $sala);
$query_sel_codigoestadomateria = "SELECT * FROM estadomateria order by nombreestadomateria";
$sel_codigoestadomateria = mysql_query($query_sel_codigoestadomateria, $sala) or die(mysql_error());
$row_sel_codigoestadomateria = mysql_fetch_assoc($sel_codigoestadomateria);
$totalRows_sel_codigoestadomateria = mysql_num_rows($sel_codigoestadomateria);

mysql_select_db($database_sala, $sala);
$query_periodo="select p.codigoperiodo from periodo p order by p.codigoperiodo desc";
$periodo=mysql_query($query_periodo, $sala);
$row_periodo=mysql_fetch_assoc($periodo);
$num_rows_codigoperiodo=mysql_num_rows($periodo);

?>


<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>


<form id="form1" name="form1" method="post" action="">
<p align="center"><span class="Estilo3">CREAR MATERIAS - MODIFICAR </span>

<table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td bordercolor="#000000"><table border="0" align="center" cellpadding="3">
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">codigomateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="codigomateria" type="text" disabled id="codigomateria" value="<?php echo $row_materias['codigomateria']?>">
</span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">codigomodalidadmateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="Estilo1"><span class="style2">
          <select name="codigomodalidadmateria" id="codigomodalidadmateria">
            <option value="">Seleccionar</option>
            <?php
            do {
?>
            <option value="<?php echo $row_sel_modalidadmateria['codigomodalidadmateria']?>"<?php if($row_materias['codigomodalidadmateria'] == $row_sel_modalidadmateria['codigomodalidadmateria']){echo "selected";}?>><?php echo $row_sel_modalidadmateria['nombremodalidadmateria']?></option>
            <?php
            } while ($row_sel_modalidadmateria = mysql_fetch_assoc($sel_modalidadmateria));


?>
          </select>
        </span></span> </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">codigolineaacademica<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="Estilo1"><span class="style2">
          <select name="codigolineaacademica" id="codigolineaacademica">
            <option value="">Seleccionar</option>
            <?php
            do {
?>
            <option value="<?php echo $row_sel_lineaacademica['codigolineaacademica']?>"<?php if($row_materias['codigolineaacademica'] == $row_sel_lineaacademica['codigolineaacademica']){echo "selected";}?>><?php echo $row_sel_lineaacademica['nombrelineaacademica']?></option>
            <?php
            } while ($row_sel_lineaacademica = mysql_fetch_assoc($sel_lineaacademica));

?>
          </select>
        </span></span> </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">codigocarrera<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="Estilo1"><span class="style2">
          <select name="codigocarrera" id="codigocarrera">
            <option value="">Seleccionar</option>
            <?php
            do {
?>
            <option value="<?php echo $row_sel_codigocarrera['codigocarrera']?>"<?php if($row_materias['codigocarrera'] == $row_sel_codigocarrera['codigocarrera']){echo "selected";}?>><?php echo $row_sel_codigocarrera['nombrecarrera']?></option>
            <?php
            } while ($row_sel_codigocarrera = mysql_fetch_assoc($sel_codigocarrera));

?>
          </select>
        </span></span> </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">codigoindicadorgrupomateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="style2">
          <select name="codigoindicadorgrupomateria" id="codigoindicadorgrupomateria">
            <option value="">Seleccionar</option>
            <?php
            do {
?>
            <option value="<?php echo $row_sel_codigoindicadorgrupomateria['codigoindicadorgrupomateria']?>"<?php if($row_materias['codigoindicadorgrupomateria'] == $row_sel_codigoindicadorgrupomateria['codigoindicadorgrupomateria']){echo "selected";}?>><?php echo $row_sel_codigoindicadorgrupomateria['nombreindicadorgrupomateria']?></option>
            <?php
            } while ($row_sel_codigoindicadorgrupomateria = mysql_fetch_assoc($sel_codigoindicadorgrupomateria));

?>
          </select>
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">codigotipomateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
          <select name="codigotipomateria" id="codigotipomateria">
            <option value="">Seleccionar</option>
            <?php
            do {
?>
            <option value="<?php echo $row_sel_codigotipomateria['codigotipomateria']?>"<?php if($row_materias['codigotipomateria'] == $row_sel_codigotipomateria['codigotipomateria']){echo "selected";}?>><?php echo $row_sel_codigotipomateria['nombretipomateria']?></option>
            <?php
            } while ($row_sel_codigotipomateria = mysql_fetch_assoc($sel_codigotipomateria));

?>
          </select>
        </span></span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo2"><span class="phpmaker" style="color: ;">codigoestadomateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
          <select name="codigoestadomateria" id="codigoestadomateria">
            <option value="">Seleccionar</option>
            <?php
            do {
?>
            <option value="<?php echo $row_sel_codigoestadomateria['codigoestadomateria']?>"<?php if($row_materias['codigoestadomateria'] == $row_sel_codigoestadomateria['codigoestadomateria']){echo "selected";}?>><?php echo $row_sel_codigoestadomateria['nombreestadomateria']?></option>
            <?php
            } while ($row_sel_codigoestadomateria = mysql_fetch_assoc($sel_codigoestadomateria));

?>
          </select>
        </span> </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">codigoindicadoretiquetamateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
          <select name="codigoindicadoretiquetamateria" id="codigoindicadoretiquetamateria">
            <option value="">Seleccionar</option>
            <?php
            do {
?>
            <option value="<?php echo $row_sel_codigoindicadoretiquetamateria['codigoindicadoretiquetamateria']?>"<?php if($row_materias['codigoindicadoretiquetamateria'] == $row_sel_codigoindicadoretiquetamateria['codigoindicadoretiquetamateria']){echo "selected";}?>><?php echo $row_sel_codigoindicadoretiquetamateria['nombreindicadoretiquetamateria']?></option>
            <?php
            } while ($row_sel_codigoindicadoretiquetamateria = mysql_fetch_assoc($sel_codigoindicadoretiquetamateria));

?>
          </select>
        </span> </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">codigotipocalificacionmateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
          <select name="codigotipocalificacionmateria" id="codigotipocalificacionmateria">
            <option value="">Seleccionar</option>
            <?php
            do {
?>
            <option value="<?php echo $row_sel_codigotipocalificacionmateria['codigotipocalificacionmateria']?>"<?php if($row_materias['codigotipocalificacionmateria'] == $row_sel_codigotipocalificacionmateria['codigotipocalificacionmateria']){echo "selected";}?>><?php echo $row_sel_codigotipocalificacionmateria['nombretipocalificacionmateria']?></option>
            <?php
            } while ($row_sel_codigotipocalificacionmateria = mysql_fetch_assoc($sel_codigotipocalificacionmateria));

?>
          </select>
        </span> </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo2"><span class="phpmaker" style="color: ;">codigoindicarcredito<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
          <select name="codigoindicadorcredito" id="codigoindicadorcredito" onChange="enviar()">
            <option value="">Seleccionar</option>
            <?php
            do {
?>
            <option value="<?php echo $row_sel_codigoindicarcredito['codigoindicarcredito']?>"<?php if(isset($_POST['codigoindicadorcredito'])){if($row_sel_codigoindicarcredito['codigoindicarcredito'] == $_POST['codigoindicadorcredito']){echo "selected";}}elseif($row_materias['codigoindicadorcredito'] == $row_sel_codigoindicarcredito['codigoindicarcredito']){echo "selected";}?>><?php echo $row_sel_codigoindicarcredito['nombreindicarcredito']?></option>
            <?php
            } while ($row_sel_codigoindicarcredito = mysql_fetch_assoc($sel_codigoindicarcredito));

?>
          </select>
        </span> </span></td>
      </tr>
      <?php if(@$_POST['codigoindicadorcredito']==100 or  $row_materias['codigoindicadorcredito']==100){ ?>
	  <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">numerocreditos<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="numerocreditos"  type="text" id="numerocreditos" value="<?php echo $row_materias['numerocreditos']?>">
        </span></td>
      </tr>
      <?php } ?>
	  <?php if(@$_POST['codigoindicadorcredito']==200 or $row_materias['codigoindicadorcredito']==200){ ?>
	  <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">ulasa<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="ulasa" type="text" id="ulasa" value="<?php echo $row_materias['ulasa']?>">
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo2"><span class="phpmaker" style="color: ;">ulasb<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="ulasb" type="text" id="ulasb" value="<?php echo $row_materias['ulasb']?>">
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">ulasc<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="ulasc" type="text" id="ulasc" value="<?php echo $row_materias['ulasc']?>">
        </span></td>
      </tr>
      <tr>
        <?php }?>
		<td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">nombrecortomateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="nombrecortomateria" type="text" id="nombrecortomateria" value="<?php echo $row_materias['nombrecortomateria']?>">
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">nombremateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="nombremateria" type="text" id="nombremateria" value="<?php echo $row_materias['nombremateria']?>">
        </span></td>
      </tr>

      
       <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">codigoperiodo<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="Estilo1"><span class="style2">
          <select name="codigoperiodo" id="codigoperiodo">
            <option value="">Seleccionar</option>
            <?php
            do {
?>
            <option value="<?php echo $row_periodo['codigoperiodo']?>"<?php if($row_periodo['codigoperiodo'] == $row_materias['codigoperiodo']){echo "selected";}?>><?php echo $row_periodo['codigoperiodo']?></option>
            <?php
            } while ($row_periodo = mysql_fetch_assoc($periodo));

?>
          </select>
        </span></span> </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">notaminimaaprobatoria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="notaminimaaprobatoria" type="text" id="notaminimaaprobatoria" value="<?php echo $row_materias['notaminimaaprobatoria']?>">
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">notaminimahabilitacion<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="notaminimahabilitacion" type="text" id="notaminimahabilitacion" value="<?php echo $row_materias['notaminimahabilitacion']?>">
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">numerosemana<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="numerosemana" type="text" id="numerosemana" value="<?php echo $row_materias['numerosemana']?>">
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">numerohorassemanales<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="numerohorassemanales" type="text" id="numerohorassemanales" value="<?php echo $row_materias['numerohorassemanales']?>">
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">porcentajeteoricamateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="porcentajeteoricamateria" type="text" id="porcentajeteoricamateria" value="<?php echo $row_materias['porcentajeteoricamateria']?>">
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">porcentajepracticamateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="porcentajepracticamateria" type="text" id="porcentajepracticamateria" value="<?php echo $row_materias['porcentajepracticamateria']?>">
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">porcentajefallasteoriamodalidadmateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="porcentajefallasteoriamodalidadmateria" type="text" id="porcentajefallasteoriamodalidadmateria" value="<?php echo $row_materias['porcentajefallasteoriamodalidadmateria']?>">
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD"><div align="center" class="Estilo3"><span class="Estilo2" style="color: ;">porcentajefallaspracticamodalidadmateria<span class="Estilo2 Estilo1 phpmaker" style="color: ;"><strong><span class="Estilo4">*</span></strong></span></span></div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker">
          <input name="porcentajefallaspracticamodalidadmateria" type="text" id="porcentajefallaspracticamodalidadmateria" value="<?php echo $row_materias['porcentajefallaspracticamodalidadmateria']?>">
        </span></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#CCDADD"><div align="center">
          <input name="Enviar" type="submit" id="Enviar" value="Enviar">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="Regresar" type="submit" id="Regresar" value="Regresar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="Anular" type="submit" id="Anular" value="Anular">
</div></td>
        </tr>
    </table></td>
  </tr>
</table>
</form>



<?php
if(isset($_POST['Enviar'])){
	//print_r($_POST);
	$validaciongeneral=true;
	$validacion['req_nombrecortomateria']=validar($_POST['nombrecortomateria'],"requerido",'<script language="JavaScript">alert("No digitado el nombre corto de la materia")</script>', true);
	$validacion['req_nombremateria']=validar($_POST['nombremateria'],"requerido",'<script language="JavaScript">alert("No digitado el nombre de la materia")</script>', true);
	if(@$_POST['codigoindicadorcredito']==100){
	$validacion['req_numerocreditos']=validar($_POST['numerocreditos'],"requerido",'<script language="JavaScript">alert("No digitado el número de créditos de la materia")</script>', true);
	$validacion['num_numerocreditos']=validar($_POST['numerocreditos'],"numero",'<script language="JavaScript">alert("No digitado correctamente el número de créditos de la materia")</script>', true);
	}
	$validacion['req_notaminimaaprobatoria']=validar($_POST['notaminimaaprobatoria'],"requerido",'<script language="JavaScript">alert("No digitado la nota mínima aprobatoria de la materia")</script>', true);
	$validacion['flot_notaminimaaprobatoria']=validar($_POST['notaminimaaprobatoria'],"flotante",'<script language="JavaScript">alert("No digitado correctamente la nota mínima aprobatoria de la materia")</script>', true);
	$validacion['req_notaminimahabilitacion']=validar($_POST['notaminimahabilitacion'],"requerido",'<script language="JavaScript">alert("No digitado la nota mínima de habilitación de la materia")</script>', true);
	$validacion['flot_notaminimahabilitacion']=validar($_POST['notaminimahabilitacion'],"flotante",'<script language="JavaScript">alert("No digitado correctamente la nota mínima de habilitación de la materia")</script>', true);
	$validacion['req_numerosemana']=validar($_POST['numerosemana'],"requerido",'<script language="JavaScript">alert("No digitado el número de semanas de la materia")</script>', true);
	$validacion['num_numerosemana']=validar($_POST['numerosemana'],"numero",'<script language="JavaScript">alert("No digitado correctamente el número de semanas de la materia")</script>', true);
	$validacion['req_numerohorassemanales']=validar($_POST['numerohorassemanales'],"requerido",'<script language="JavaScript">alert("No digitado el número de horas semanales de la materia")</script>', true);
	$validacion['num_numerohorassemanales']=validar($_POST['numerohorassemanales'],"numero",'<script language="JavaScript">alert("No digitado correctamente el número de horas semanales de la materia")</script>', true);
	$validacion['req_porcentajeteoricamateria']=validar($_POST['porcentajeteoricamateria'],"requerido",'<script language="JavaScript">alert("No digitado el porcentaje de teoría de la materia")</script>', true);
	$validacion['flot_porcentajeteoricamateria']=validar($_POST['porcentajeteoricamateria'],"flotante",'<script language="JavaScript">alert("No digitado correctamente el porcentaje de teoría de la materia")</script>', true);
	$validacion['req_porcentajepracticamateria']=validar($_POST['porcentajepracticamateria'],"requerido",'<script language="JavaScript">alert("No digitado el porcentaje de práctica de la materia")</script>', true);
	$validacion['flot_porcentajepracticamateria']=validar($_POST['porcentajepracticamateria'],"flotante",'<script language="JavaScript">alert("No digitado correctamente el porcentaje de práctica de la materia")</script>', true);
	$validacion['req_porcentajefallasteoriamodalidadmateria']=validar($_POST['porcentajefallasteoriamodalidadmateria'],"requerido",'<script language="JavaScript">alert("No digitado porcentaje de fallas de la materia")</script>', true);
	$validacion['flot_porcentajefallasteoriamodalidadmateria']=validar($_POST['porcentajefallasteoriamodalidadmateria'],"requerido",'<script language="JavaScript">alert("No digitado correctamente el porcentaje de fallas de la materia")</script>', true);
	$validacion['req_codigomodalidadmateria']=validar($_POST['codigomodalidadmateria'],"requerido",'<script language="JavaScript">alert("No digitado la modalidad de la materia")</script>', true);
	$validacion['req_codigolineaacademica']=validar($_POST['codigolineaacademica'],"requerido",'<script language="JavaScript">alert("No digitado la línea académica de la materia")</script>', true);
	$validacion['req_codigocarrera']=validar($_POST['codigocarrera'],"requerido",'<script language="JavaScript">alert("No digitado la carrera a la que pertenece la materia")</script>', true);
	$validacion['req_codigoindicadorgrupomateria']=validar($_POST['codigoindicadorgrupomateria'],"requerido",'<script language="JavaScript">alert("No digitado el indicador grupomateria de la materia")</script>', true);
	$validacion['req_codigotipomateria']=validar($_POST['codigotipomateria'],"requerido",'<script language="JavaScript">alert("No ha selecciondo el tipo de materia")</script>', true);
	$validacion['req_codigoestadomateria']=validar($_POST['codigoestadomateria'],"requerido",'<script language="JavaScript">alert("No digitado el estado de la materia")</script>', true);
	if(@$_POST['codigoindicadorcredito']==200){
	$validacion['req_ulasa']=validar($_POST['ulasa'],"requerido",'<script language="JavaScript">alert("No digitado campo Ulasa de la materia")</script>', true);
	$validacion['req_ulasb']=validar($_POST['ulasb'],"requerido",'<script language="JavaScript">alert("No digitado campo ulasb de la materia")</script>', true);
	$validacion['req_ulasc']=validar($_POST['ulasc'],"requerido",'<script language="JavaScript">alert("No digitado campo ulasc de la materia")</script>', true);
	}
	
	$validacion['req_codigoindicadorcredito']=validar($_POST['codigoindicadorcredito'],"requerido",'<script language="JavaScript">alert("No digitado el indicador de crédito de la materia")</script>', true);
	$validacion['req_codigoindicadoretiquetamateria']=validar($_POST['codigoindicadoretiquetamateria'],"requerido",'<script language="JavaScript">alert("No ha digitado el indicador de etiqueta de la materia")</script>', true);
	$validacion['req_codigotipocalificacionmateria']=validar($_POST['codigotipocalificacionmateria'],"requerido",'<script language="JavaScript">alert("No digitado el indicador de cafilicación de la materia")</script>', true);


	if($_POST['porcentajefallasteoriamodalidadmateria'] > 100)
	{
		$validaciongeneral=false;
		echo '<script language="JavaScript">alert("El porcentaje de fallas no puede exceder el 100%")</script>';
	}	

	if($_POST['notaminimaaprobatoria'] > 5.0 or $_POST['notaminimahabilitacion'] > 5.0 )
	{
		$validaciongeneral=false;
		echo '<script language="JavaScript">alert("Las notas no pueden exceder el valor 5.0")</script>';
	}	
	
	if($_POST['notaminimaaprobatoria'] < $_POST['notaminimahabilitacion'])
	{
		$validaciongeneral=false;
		echo '<script language="JavaScript">alert("La nota minima de habilitacion no puede ser mayor a la nota minima aprobatoria")</script>';
	}
	$suma_porcentajes=($_POST['porcentajeteoricamateria']+$_POST['porcentajepracticamateria']);
	if($suma_porcentajes!=100)
	{
		$validaciongeneral=false;
		echo '<script language="JavaScript">alert("El total de los porcentajes teorico-practico de las materias no puede ser diferente del 100%")</script>';
	}
		

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
		$materia = DB_DataObject::factory('materia');
		//DB_DataObject::debugLevel(5);

		$materia->get($_GET['codigomateria']);
		$original=clone($materia);
		
		$materia->nombrecortomateria=$_POST['nombrecortomateria'];
		$materia->nombremateria=$_POST['nombremateria'];
				
		$materia->codigoperiodo=$_POST['codigoperiodo'];
		$materia->notaminimaaprobatoria=$_POST['notaminimaaprobatoria'];
		$materia->notaminimahabilitacion=$_POST['notaminimahabilitacion'];
		$materia->numerosemana=$_POST['numerosemana'];
		$materia->numerohorassemanales=$_POST['numerohorassemanales'];
		$materia->porcentajeteoricamateria=$_POST['porcentajeteoricamateria'];
		$materia->porcentajepracticamateria=$_POST['porcentajepracticamateria'];
		$materia->porcentajefallasteoriamodalidadmateria=$_POST['porcentajefallasteoriamodalidadmateria'];
		//$materia->porcentajefallaspracticamodalidadmateria=$_POST['porcentajefallaspracticamodalidadmateria'];
		$materia->codigomodalidadmateria=$_POST['codigomodalidadmateria'];
		
		$materia->codigolineaacademica=$_POST['codigolineaacademica'];
		
		$materia->codigocarrera=$_POST['codigocarrera'];
		
		$materia->codigoindicadorgrupomateria=$_POST['codigoindicadorgrupomateria'];
		
		$materia->codigotipomateria=$_POST['codigotipomateria'];
		$materia->codigoestadomateria=$_POST['codigoestadomateria'];
		if(@$_POST['codigoindicadorcredito']==100){
			$materia->numerocreditos=$_POST['numerocreditos'];
			$materia->ulasa=0;
			$materia->ulasb=0;
			$materia->ulasc=0;
		}
		elseif(@$_POST['codigoindicadorcredito']==200){
		$materia->numerocreditos=0;
		$materia->ulasa=$_POST['ulasa'];
		$materia->ulasb=$_POST['ulasb'];
		$materia->ulasc=$_POST['ulasc'];
		}
		$materia->codigoindicadorcredito=$_POST['codigoindicadorcredito'];
		$materia->codigoindicadoretiquetamateria=$_POST['codigoindicadoretiquetamateria'];
		$materia->codigotipocalificacionmateria=$_POST['codigotipocalificacionmateria'];

			
		
		//print_r($materia);
		DB_DataObject::debugLevel(5);
		$actualizar=$materia->update($original);
		DB_DataObject::debugLevel(0);
		unset($_POST);
		if($actualizar)
		{
			echo "<script language='javascript'>alert('Registros actualizados correctamente');</script>";
			echo "<script language='javascript'>window.location.href='consultar_materias_detalle.php?codigomateria=".$_GET['codigomateria']."';</script>";
		}
		else
		{
			echo "<script language='javascript'>alert('Fallo Actualizacion');</script>";
			unset($_POST['Enviar']);
			echo "<script language='javascript'>history.go(-1);</script>"; 
		}
		
	}
}
?> 

 <?php if(isset($_POST['Regresar'])){
 	echo "<script language='javascript'>window.location.href='menu.php';</script>";
 }
?>

<?php if(isset($_POST['Anular'])){
		$materia = DB_DataObject::factory('materia');
		DB_DataObject::debugLevel(5);

		$materia->get($_GET['codigomateria']);
		$original=clone($materia);
	$materia->codigoestadomateria='02';
	$anular=$materia->update($original);
		if($anular)
		{
			echo "<script language='javascript'>alert('El registro ha sido anulado correctamente');</script>";
			echo "<script language='javascript'>window.location.href='menu.php';</script>";
		}
		
 	echo "<script language='javascript'>window.location.href='menu.php';</script>";
 }
?>
 