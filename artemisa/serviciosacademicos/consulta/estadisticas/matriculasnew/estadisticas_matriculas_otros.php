<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php');
error_reporting(0);
if(isset($_GET['codigomodalidadacademica']) and isset($_GET['codigocarrera']) and isset($_GET['codigoperiodo']))
{
	$_SESSION['codigomodalidadacademica']=$_GET['codigomodalidadacademica'];
	$_SESSION['codigocarrera']=$_GET['codigocarrera'];
	$_SESSION['codigoperiodo']=$_GET['codigoperiodo'];
}
?>
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
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}

.verdoso {
	background-color: #CCDADD;
	font-family: Tahoma; font-size: 12px; font-weight: bold;
}
.amarrillento {
	background-color: #FEF7ED;
	font-family: Tahoma; font-size: 11px
}
.rojo {color: #FF0000}
.verde {background-color: #CCDADD;}
-->
</style>
<?php
require_once("../../../../funciones/conexion/conexionpear.php");
require_once("../../../../funciones/gui/combo_valida_get.php");
require_once("filtro.php");
require_once("clases/obtener_datos.php");
require_once("imprimir_arrays_bidimensionales.php");
require_once("ordenar_matrices.php");
require_once("totales_matrices.php");
?>
<?php
if(isset($_GET['Filtrar']) and $_GET['Filtrar']!="")
{
	$_SESSION['muestrafiltro']=$_GET['Filtrar'];
}
setlocale(LC_MONETARY, 'en_US');
$fechahoy=date("Y-m-d H:i:s");
?>
<?php
$contador=0;
$datos_matriculas=new obtener_datos_matriculas($sala,$_SESSION['codigoperiodo']);
if(isset($_SESSION['codigomodalidadacademica']) and isset($_SESSION['codigocarrera']))
{
	if($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']=="todos")
	{
		$row_obtener_carreras=$datos_matriculas->obtener_carreras("","");
	}
	elseif($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']!="todos")
	{
		$row_obtener_carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
	}
	elseif($_SESSION['codigomodalidadacademica']!="todos" and $_SESSION['codigocarrera']=="todos")
	{
		$row_obtener_carreras=$datos_matriculas->obtener_carreras($_SESSION['codigomodalidadacademica'],"");
	}
	else
	{
		$row_obtener_carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
	}
}

$row_datos_151=$datos_matriculas->obtener_datos_base("151");
$row_datos_152=$datos_matriculas->obtener_datos_base("152");
$row_datos_153=$datos_matriculas->obtener_datos_base("153");

$row_cantidades_151=$datos_matriculas->contar_cantidades("151");
$row_cantidades_152=$datos_matriculas->contar_cantidades("152");
$row_cantidades_153=$datos_matriculas->contar_cantidades("153");

$row_cantidades_matriculas_tipoestudiante_10=$datos_matriculas->contar_valores_por_tipestudiante("10");
$row_cantidades_matriculas_tipoestudiante_11=$datos_matriculas->contar_valores_por_tipestudiante("11");
$row_cantidades_matriculas_tipoestudiante_20=$datos_matriculas->contar_valores_por_tipestudiante("20");
$row_cantidades_matriculas_tipoestudiante_21=$datos_matriculas->contar_valores_por_tipestudiante("21");


$row_pagoxinternet_151=$datos_matriculas->obtener_cantidad_pagosxinternet("151");
$row_pagoxinternet_152=$datos_matriculas->obtener_cantidad_pagosxinternet("152");
$row_pagoxinternet_153=$datos_matriculas->obtener_cantidad_pagosxinternet("153");

$row_cantidad_alumnos_matriculados_nuevos=$datos_matriculas->obtener_cantidad_alumnos_matriculados("10");
$row_cantidad_alumnos_matriculados_transferencia=$datos_matriculas->obtener_cantidad_alumnos_matriculados("11");
$row_cantidad_alumnos_matriculados_antiguos=$datos_matriculas->obtener_cantidad_alumnos_matriculados("20");
$row_cantidad_alumnos_matriculados_reintegro=$datos_matriculas->obtener_cantidad_alumnos_matriculados("21");

$row_cantidad_alumnos_preinscritos=$datos_matriculas->contar_cantidad_alumnos_codigosituacioncarreraestudiante("106");
$row_cantidad_alumnos_inscritos=$datos_matriculas->contar_cantidad_alumnos_codigosituacioncarreraestudiante("107");


foreach($row_obtener_carreras as $clave => $valor)
{
	$array_datos[$contador]['codigocarrera']=$valor['codigocarrera'];
	$array_datos[$contador]['nombrecarrera']=$valor['nombrecarrera'];
	if($row_cantidades_151[$contador]==""){$array_datos[$contador]['cantidad_matricula']=0;}else{$array_datos[$contador]['cantidad_matricula']=$row_cantidades_151[$contador];};
	if($row_pagoxinternet_151[$contador]['cantidad']==""){$array_datos[$contador]['cantidad_matricula_internet']=0;}else{$array_datos[$contador]['cantidad_matricula_internet']=$row_pagoxinternet_151[$contador]['cantidad'];};
	$array_datos[$contador]['cantidad_matricula_presencial']=$row_cantidades_151[$contador]-$row_pagoxinternet_151[$contador]['cantidad'];
	if($row_pagoxinternet_151[$contador]['valor']==""){$array_datos[$contador]['valor_matricula_internet']=0;}else{$array_datos[$contador]['valor_matricula_internet']=$row_pagoxinternet_151[$contador]['valor'];}
	$array_datos[$contador]['valor_matricula_presencial']=$row_datos_151[$contador]['total']-$row_pagoxinternet_151[$contador]['valor'];
	if($row_datos_151[$contador]['total']==""){$array_datos[$contador]['total_matricula']=0;}else{$array_datos[$contador]['total_matricula']=$row_datos_151[$contador]['total'];};

	if($row_cantidades_152[$contador]==""){$array_datos[$contador]['cantidad_formulario']=0;}else{$array_datos[$contador]['cantidad_formulario']=$row_cantidades_152[$contador];};
	if($row_pagoxinternet_152[$contador]['cantidad']==""){$array_datos[$contador]['cantidad_formulario_internet']=0;}else{$array_datos[$contador]['cantidad_formulario_internet']=$row_pagoxinternet_152[$contador]['cantidad'];};
	$array_datos[$contador]['cantidad_formulario_presencial']=$row_cantidades_152[$contador]-$row_pagoxinternet_152[$contador]['cantidad'];
	if($row_pagoxinternet_152[$contador]['valor']==""){$array_datos[$contador]['valor_formulario_internet']=0;}else{$array_datos[$contador]['valor_formulario_internet']=$row_pagoxinternet_152[$contador]['valor'];};
	$array_datos[$contador]['valor_formulario_presencial']=$row_datos_152[$contador]['total']-$row_pagoxinternet_152[$contador]['valor'];
	if($row_datos_152[$contador]['total']==""){$array_datos[$contador]['total_formulario']=0;}else{$array_datos[$contador]['total_formulario']=$row_datos_152[$contador]['total'];};


	if($row_cantidades_153[$contador]==""){$array_datos[$contador]['cantidad_inscripcion']=0;}else{$array_datos[$contador]['cantidad_inscripcion']=$row_cantidades_153[$contador];};
	if($row_pagoxinternet_153[$contador]['cantidad']==""){$array_datos[$contador]['cantidad_inscripcion_internet']=0;}else{$array_datos[$contador]['cantidad_inscripcion_internet']=$row_pagoxinternet_153[$contador]['cantidad'];};
	$array_datos[$contador]['cantidad_inscripcion_presencial']=$row_cantidades_153[$contador]-$row_pagoxinternet_153[$contador]['cantidad'];
	if($row_pagoxinternet_153[$contador]['valor']==""){$array_datos[$contador]['valor_inscripcion_internet']=0;}else{$array_datos[$contador]['valor_inscripcion_internet']=$row_pagoxinternet_153[$contador]['valor'];};
	$array_datos[$contador]['valor_inscripcion_presencial']=$row_datos_153[$contador]['total']-$row_pagoxinternet_153[$contador]['valor'];
	if($row_datos_153[$contador]['total']==""){$array_datos[$contador]['total_inscripcion']=0;}else{$array_datos[$contador]['total_inscripcion']=$row_datos_153[$contador]['total'];};

	if($row_cantidad_alumnos_matriculados_nuevos[$contador]['total']==""){$array_datos[$contador]['valor_matriculados_nuevos']=0;}else{$array_datos[$contador]['valor_matriculados_nuevos']=$row_cantidad_alumnos_matriculados_nuevos[$contador]['total'];};
	if($row_cantidades_matriculas_tipoestudiante_10[$contador]==""){$array_datos[$contador]['cantidad_matriculados_nuevos']=0;}else{$array_datos[$contador]['cantidad_matriculados_nuevos']=$row_cantidades_matriculas_tipoestudiante_10[$contador];};

	if($row_cantidad_alumnos_matriculados_transferencia[$contador]['total']==""){$array_datos[$contador]['valor_matriculados_transferencia']=0;}else{$array_datos[$contador]['valor_matriculados_transferencia']=$row_cantidad_alumnos_matriculados_transferencia[$contador]['total'];};
	if($row_cantidades_matriculas_tipoestudiante_11[$contador]==""){$array_datos[$contador]['cantidad_matriculados_transferencia']=0;}else{$array_datos[$contador]['cantidad_matriculados_transferencia']=$row_cantidades_matriculas_tipoestudiante_11[$contador];};

	if($row_cantidad_alumnos_matriculados_antiguos[$contador]['total']==""){$array_datos[$contador]['valor_matriculados_antiguos']=0;}else{$array_datos[$contador]['valor_matriculados_antiguos']=$row_cantidad_alumnos_matriculados_antiguos[$contador]['total'];};
	if($row_cantidades_matriculas_tipoestudiante_20[$contador]==""){$array_datos[$contador]['cantidad_matriculados_antiguos']=0;}else{$array_datos[$contador]['cantidad_matriculados_antiguos']=$row_cantidades_matriculas_tipoestudiante_20[$contador];};

	if($row_cantidad_alumnos_matriculados_reintegro[$contador]['total']==""){$array_datos[$contador]['valor_matriculados_reintegro']=0;}else{$array_datos[$contador]['valor_matriculados_reintegro']=$row_cantidad_alumnos_matriculados_reintegro[$contador]['total'];};
	if($row_cantidades_matriculas_tipoestudiante_21[$contador]==""){$array_datos[$contador]['cantidad_matriculados_reintegro']=0;}else{$array_datos[$contador]['cantidad_matriculados_reintegro']=$row_cantidades_matriculas_tipoestudiante_21[$contador];};
	
	$array_datos[$contador]['preinscritos']=$row_cantidad_alumnos_preinscritos[$contador]['total'];
	$array_datos[$contador]['inscritos']=$row_cantidad_alumnos_inscritos[$contador]['total'];
	
	$contador++;
}
//listar($array_datos);
$ordenamiento=new matriz($array_datos);
$matriz_ordenada=$ordenamiento->ordenamiento("nombrecarrera","ASC");
//print_r($row_totales);
?>
<form name="form1" action="" method="get">
<p align="center" class="Estilo3">ESTADISTICAS ORDENES DE PAGO PERIODO <?php echo $_SESSION['codigoperiodo']?><br>
</p>
<table width="25%"  border="1" align="center">
  <tr>
    <td nowrap><div align="left"><strong>I</strong>=internet</div></td>
    <td nowrap><div align="left"><strong>P</strong>=presencial</div></td>
    <td nowrap>&nbsp;</td>
    <td nowrap>&nbsp;</td>
  </tr>
  <tr>
    <td nowrap><div align="left"><strong>N</strong>=Estudiantes nuevos </div></td>
    <td nowrap><div align="left">A=Estudiantes antiguos</div></td>
    <td nowrap><strong>R</strong>=Estudiantes de reintegro </td>
    <td nowrap><strong>T</strong>=Estudiantes de transferencia</td>
  </tr>
</table>
<br>
<table width="200%"  border="1" align="center">
  <tr class="verdoso">
    <td nowrap><div align="center">
      <input type="submit" name="Filtrar" value="<?php if(!isset($_GET['F'])){if(!isset($_GET['Filtrar'])){echo "si";}elseif($_GET['Filtrar']=="si"){echo "no";};if($_GET['Filtrar']=="no"){echo "si";}}else{echo "si";}?>">
    </div>      
    <div align="center"></div></td>
    <td nowrap><div align="center">Programa acad&eacute;mico</div></td>
    <td colspan="7" nowrap><div align="center">Matr&iacute;culas</div>      </td>
    <td colspan="3" nowrap><div align="center">Formularios</div>      </td>
    <td colspan="3" nowrap><div align="center">Inscripci&oacute;n</div>      
      <div align="center"></div></td>
    <td colspan="2" nowrap><div align="center">Estado de Inscripci&oacute;n </div></td>
    </tr>
    <?php if(isset($_SESSION['muestrafiltro']) and $_SESSION['muestrafiltro']=="si"){?>
  <tr class="Estilo1">
	<td nowrap><div align="center">
      <input name="F" type="submit" id="F" value="F">
	</div></td>
    <td nowrap><div align="center">
      <input name="nombrecarrera" type="text" size="25" value="<?php if(isset($_GET['nombrecarrera'])){echo $_GET['nombrecarrera'];}?>">
    </div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_matricula" id="f_cantidad_matricula">
        <option value="<>"<?php if($_GET['f_cantidad_matricula']=="<>"){echo "Selected";}?>><></option>
		<option value="="<?php if($_GET['f_cantidad_matricula']=="="){echo "Selected";}?>>=</option>
		<option value=">"<?php if($_GET['f_cantidad_matricula']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_matricula']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_matricula']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;="><?php if($_GET['f_cantidad_matricula']=="<="){echo "Selected";}?>&lt;=</option>
      </select>
      <input name="cantidad_matricula" type="text" size="1" value="<?php if(isset($_GET['cantidad_matricula'])){echo $_GET['cantidad_matricula'];}?>">
    </div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_matricula_internet" id="f_cantidad_matricula_internet">
        <option value="<>"<?php if($_GET['f_cantidad_matricula_internet']=="<>"){echo "Selected";}?>><></option>
		<option value="="<?php if($_GET['f_cantidad_matricula_internet']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_cantidad_matricula_internet']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_matricula_internet']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_matricula_internet']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;="><?php if($_GET['f_cantidad_matricula_internet']=="<="){echo "Selected";}?>&lt;=</option>
      </select>
      <input name="cantidad_matricula_internet" type="text" size="1" value="<?php if(isset($_GET['cantidad_matricula_internet'])){echo $_GET['cantidad_matricula_internet'];}?>">
</div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_matricula_presencial" id="f_cantidad_matricula_presencial">
        <option value="<>"<?php if($_GET['f_cantidad_matricula_presencial']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_cantidad_matricula_presencial']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_cantidad_matricula_presencial']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_matricula_presencial']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_matricula_presencial']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_cantidad_matricula_presencial']=="<="){echo "Selected";}?>
      &lt;=</option>
      </select>
      <input name="cantidad_matricula_presencial" type="text" size="1" value="<?php if(isset($_GET['cantidad_matricula_presencial'])){echo $_GET['cantidad_matricula_presencial'];}?>">

      </div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_matriculados_nuevos" id="f_cantidad_matriculados_nuevos">
        <option value="<>"<?php if($_GET['f_cantidad_matriculados_nuevos']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_cantidad_matriculados_nuevos']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_cantidad_matriculados_nuevos']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_matriculados_nuevos']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_matriculados_nuevos']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_cantidad_matriculados_nuevos']=="<="){echo "Selected";}?>
      &lt;=</option>
      </select>
      <input name="cantidad_matriculados_nuevos" type="text" size="1" value="<?php if(isset($_GET['cantidad_matriculados_nuevos'])){echo $_GET['cantidad_matriculados_nuevos'];}?>">
</div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_matriculados_transferencia" id="f_cantidad_matriculados_transferencia">
        <option value="<>"<?php if($_GET['f_cantidad_matriculados_transferencia']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_cantidad_matriculados_transferencia']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_cantidad_matriculados_transferencia']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_matriculados_transferencia']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_matriculados_transferencia']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_cantidad_matriculados_transferencia']=="<="){echo "Selected";}?>
&lt;=</option>
      </select>
      <input name="cantidad_matriculados_transferencia" type="text" size="1" value="<?php if(isset($_GET['cantidad_matriculados_transferencia'])){echo $_GET['cantidad_matriculados_transferencia'];}?>">
</div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_matriculados_antiguos" id="f_cantidad_matriculados_antiguos">
        <option value="<>"<?php if($_GET['f_cantidad_matriculados_antiguos']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_cantidad_matriculados_antiguos']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_cantidad_matriculados_antiguos']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_matriculados_antiguos']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_matriculados_antiguos']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_cantidad_matriculados_antiguos']=="<="){echo "Selected";}?>
&lt;=</option>
      </select>
      <input name="cantidad_matriculados_antiguos" type="text" size="1" value="<?php if(isset($_GET['cantidad_matriculados_antiguos'])){echo $_GET['cantidad_matriculados_antiguos'];}?>">
</div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_matriculados_reintegro" id="f_cantidad_matriculados_reintegro">
        <option value="<>"<?php if($_GET['f_cantidad_matriculados_reintegro']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_cantidad_matriculados_reintegro']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_cantidad_matriculados_reintegro']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_matriculados_reintegro']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_matriculados_reintegro']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_cantidad_matriculados_reintegro']=="<="){echo "Selected";}?>
&lt;=</option>
      </select>
      <input name="cantidad_matriculados_reintegro" type="text" size="1" value="<?php if(isset($_GET['cantidad_matriculados_reintegro'])){echo $_GET['cantidad_matriculados_reintegro'];}?>">
</div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_formulario" id="f_cantidad_formulario">
        <option value="<>"<?php if($_GET['f_cantidad_formulario']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_cantidad_formulario']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_cantidad_formulario']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_formulario']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_formulario']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_cantidad_formulario']=="<="){echo "Selected";}?>
      &lt;=</option>
      </select>
      <input name="cantidad_formulario" type="text" size="1" value="<?php if(isset($_GET['cantidad_formulario'])){echo $_GET['cantidad_formulario'];}?>">
</div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_formulario_internet" id="f_cantidad_formulario_internet">
        <option value="<>"<?php if($_GET['f_cantidad_formulario_internet']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_cantidad_formulario_internet']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_cantidad_formulario_internet']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_formulario_internet']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_formulario_internet']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_cantidad_formulario_internet']=="<="){echo "Selected";}?>
      &lt;=</option>
      </select>
      <input name="cantidad_formulario_internet" type="text" size="1" value="<?php if(isset($_GET['cantidad_formulario_internet'])){echo $_GET['cantidad_formulario_internet'];}?>">
</div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_formulario_presencial" id="f_cantidad_formulario_presencial">
        <option value="<>"<?php if($_GET['f_cantidad_formulario_presencial']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_cantidad_formulario_presencial']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_cantidad_formulario_presencial']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_formulario_presencial']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_formulario_presencial']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_cantidad_formulario_presencial']=="<="){echo "Selected";}?>
      &lt;=</option>
      </select>
      <input name="cantidad_formulario_presencial" type="text" size="1" value="<?php if(isset($_GET['cantidad_formulario_presencial'])){echo $_GET['cantidad_formulario_presencial'];}?>">
</div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_inscripcion" id="f_cantidad_inscripcion">
        <option value="<>"<?php if($_GET['f_cantidad_inscripcion']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_cantidad_inscripcion']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_cantidad_inscripcion']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_inscripcion']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_inscripcion']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_cantidad_inscripcion']=="<="){echo "Selected";}?>
&lt;=</option>
      </select>
      <input name="cantidad_inscripcion" type="text" size="1" value="<?php if(isset($_GET['cantidad_inscripcion'])){echo $_GET['cantidad_inscripcion'];}?>">
</div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_inscripcion_internet" id="f_cantidad_inscripcion_internet">
        <option value="<>"<?php if($_GET['f_cantidad_inscripcion_internet']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_cantidad_inscripcion_internet']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_cantidad_inscripcion_internet']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_inscripcion_internet']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_inscripcion_internet']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_cantidad_inscripcion_internet']=="<="){echo "Selected";}?>
&lt;=</option>
      </select>
      <input name="cantidad_inscripcion_internet" type="text" size="1" value="<?php if(isset($_GET['cantidad_inscripcion_internet'])){echo $_GET['cantidad_inscripcion_internet'];}?>">
</div></td>
    <td nowrap><div align="center">
      <select name="f_cantidad_inscripcion_presencial" id="f_cantidad_inscripcion_presencial">
        <option value="<>"<?php if($_GET['f_cantidad_inscripcion_presencial']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_cantidad_inscripcion_presencial']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_cantidad_inscripcion_presencial']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_cantidad_inscripcion_presencial']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_cantidad_inscripcion_presencial']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_cantidad_inscripcion_presencial']=="<="){echo "Selected";}?>
&lt;=</option>
      </select>
      <input name="cantidad_inscripcion_presencial" type="text" size="1" value="<?php if(isset($_GET['cantidad_inscripcion_presencial'])){echo $_GET['cantidad_inscripcion_presencial'];}?>">
</div></td>
    <td nowrap><div align="center">
      <select name="f_preinscritos" id="f_preinscritos">
        <option value="<>"<?php if($_GET['f_preinscritos']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_preinscritos']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_preinscritos']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_preinscritos']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_preinscritos']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_preinscritos']=="<="){echo "Selected";}?>
&lt;=</option>
      </select>
      <input name="preinscritos" type="text" size="1" value="<?php if(isset($_GET['preinscritos'])){echo $_GET['preinscritos'];}?>">
</div></td>
    <td nowrap><div align="center">
      <select name="f_inscritos" id="f_inscritos">
        <option value="<>"<?php if($_GET['f_inscritos']=="<>"){echo "Selected";}?>><></option>
        <option value="="<?php if($_GET['f_inscritos']=="="){echo "Selected";}?>>=</option>
        <option value=">"<?php if($_GET['f_inscritos']==">"){echo "Selected";}?>>&gt;</option>
        <option value=">="<?php if($_GET['f_inscritos']==">="){echo "Selected";}?>>&gt;=</option>
        <option value="<"<?php if($_GET['f_inscritos']=="<"){echo "Selected";}?>>&lt;</option>
        <option value="&lt;=">
        <?php if($_GET['f_inscritos']=="<="){echo "Selected";}?>
&lt;=</option>
      </select>
      <input name="inscritos" type="text" size="1" value="<?php if(isset($_GET['inscritos'])){echo $_GET['inscritos'];}?>">
</div></td>
  </tr>
  <?php } ?>
  <tr class="Estilo1">
    <td nowrap><div align="center">Cod</div></td>
    <td nowrap><div align="center">Programa</div></td>
    <td nowrap><div align="center">Cant</div></td>
    <td nowrap><div align="center">I</div></td>
    <td nowrap><div align="center">P</div></td>
    <td nowrap><div align="center">Cant N </div></td>
    <td nowrap><div align="center">Cant T </div></td>
    <td nowrap><div align="center">Cant A </div></td>
    <td nowrap><div align="center">Cant R </div></td>
    <td nowrap><div align="center">Cant</div></td>
    <td nowrap><div align="center">I</div></td>
    <td nowrap><div align="center">P</div></td>
    <td nowrap><div align="center">Cant</div></td>
    <td nowrap><div align="center">I</div></td>
    <td nowrap><div align="center">P</div></td>
    <td nowrap><div align="center">Preinscritos</div></td>
    <td nowrap><div align="center">Inscritos</div></td>
  </tr>
  <?php 
  if(isset($_GET['F']))
  {
  	$ordenamiento->agregarcolumna_filtro("nombrecarrera",$_GET['nombrecarrera'],"like");
  	$ordenamiento->agregarcolumna_filtro("cantidad_matricula",$_GET['cantidad_matricula'],$_GET['f_cantidad_matricula']);
  	$ordenamiento->agregarcolumna_filtro("cantidad_matricula_internet",$_GET['cantidad_matricula_internet'],$_GET['f_cantidad_matricula_internet']);
  	$ordenamiento->agregarcolumna_filtro("cantidad_matricula_presencial",$_GET['cantidad_matricula_presencial'],$_GET['f_cantidad_matricula_presencial']);
  	$ordenamiento->agregarcolumna_filtro("total_matricula",$_GET['total_matricula'],$_GET['f_total_matricula']);
  	$ordenamiento->agregarcolumna_filtro("valor_matricula_internet",$_GET['valor_matricula_internet'],$_GET['f_valor_matricula_internet']);
  	$ordenamiento->agregarcolumna_filtro("valor_matricula_presencial",$_GET['valor_matricula_presencial'],$_GET['f_valor_matricula_presencial']);
  	$ordenamiento->agregarcolumna_filtro("cantidad_matriculados_nuevos",$_GET['cantidad_matriculados_nuevos'],$_GET['f_cantidad_matriculados_nuevos']);
  	$ordenamiento->agregarcolumna_filtro("cantidad_matriculados_transferencia",$_GET['cantidad_matriculados_transferencia'],$_GET['f_cantidad_matriculados_transferencia']);
  	$ordenamiento->agregarcolumna_filtro("cantidad_matriculados_antiguos",$_GET['cantidad_matriculados_antiguos'],$_GET['f_cantidad_matriculados_antiguos']);
  	$ordenamiento->agregarcolumna_filtro("cantidad_matriculados_reintegro",$_GET['cantidad_matriculados_reintegro'],$_GET['f_cantidad_matriculados_reintegro']);
  	$ordenamiento->agregarcolumna_filtro("valor_matriculados_nuevos",$_GET['valor_matriculados_nuevos'],$_GET['f_valor_matriculados_nuevos']);
  	$ordenamiento->agregarcolumna_filtro("valor_matriculados_transferencia",$_GET['valor_matriculados_transferencia'],$_GET['f_valor_matriculados_transferencia']);
  	$ordenamiento->agregarcolumna_filtro("valor_matriculados_antiguos",$_GET['valor_matriculados_antiguos'],$_GET['f_valor_matriculados_antiguos']);
  	$ordenamiento->agregarcolumna_filtro("valor_matriculados_reintegro",$_GET['valor_matriculados_reintegro'],$_GET['f_valor_matriculados_reintegro']);
  	$ordenamiento->agregarcolumna_filtro("total_formulario",$_GET['total_formulario'],$_GET['f_total_formulario']);
  	$ordenamiento->agregarcolumna_filtro("cantidad_formulario",$_GET['cantidad_formulario'],$_GET['f_cantidad_formulario']);
  	$ordenamiento->agregarcolumna_filtro("valor_formulario_internet",$_GET['valor_formulario_internet'],$_GET['f_valor_formulario_internet']);
  	$ordenamiento->agregarcolumna_filtro("valor_formulario_presencial",$_GET['valor_formulario_presencial'],$_GET['f_valor_formulario_presencial']);
  	$ordenamiento->agregarcolumna_filtro("total_inscripcion",$_GET['total_inscripcion'],$_GET['f_total_inscripcion']);
  	$ordenamiento->agregarcolumna_filtro("valor_inscripcion_internet",$_GET['valor_inscripcion_internet'],$_GET['f_valor_inscripcion_internet']);
  	$ordenamiento->agregarcolumna_filtro("valor_inscripcion_presencial",$_GET['valor_inscripcion_presencial'],$_GET['f_valor_inscripcion_presencial']);
  	$ordenamiento->agregarcolumna_filtro("cantidad_inscripcion",$_GET['cantidad_inscripcion'],$_GET['f_cantidad_inscripcion']);
  	$ordenamiento->agregarcolumna_filtro("cantidad_inscripcion_internet",$_GET['cantidad_inscripcion_internet'],$_GET['f_cantidad_inscripcion_internet']);
  	$ordenamiento->agregarcolumna_filtro("cantidad_inscripcion_presencial",$_GET['cantidad_inscripcion_presencial'],$_GET['f_cantidad_inscripcion_presencial']);
  	$ordenamiento->agregarcolumna_filtro("cantidad_formulario_internet",$_GET['cantidad_formulario_internet'],$_GET['f_cantidad_formulario_internet']);
  	$ordenamiento->agregarcolumna_filtro("cantidad_formulario_presencial",$_GET['cantidad_formulario_presencial'],$_GET['f_cantidad_formulario_presencial']);
	$ordenamiento->agregarcolumna_filtro("preinscritos",$_GET['preinscritos'],$_GET['f_preinscritos']);
	$ordenamiento->agregarcolumna_filtro("inscritos",$_GET['inscritos'],$_GET['f_inscritos']);


  	$matriz_mostrar=$ordenamiento->filtrar();
  }
  else
  {
  	$matriz_mostrar=$matriz_ordenada;
  }
  $totales=new totales($matriz_mostrar);
  $totales->leer_columnas();
  $row_totales=$totales->totales_matriz();
   foreach($matriz_mostrar as $clave => $valor){?>
  <tr class="Estilo1">
    <td><div align="center"><?php echo $valor['codigocarrera']?></div></td>
    <td><div align="left"><?php echo strtoupper($valor['nombrecarrera'])?></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=151&codigotipoestudiante=0&tipopago=0"><?php echo $valor['cantidad_matricula']?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=151&codigotipoestudiante=0&tipopago=internet"><?php echo $valor['cantidad_matricula_internet']?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=151&codigotipoestudiante=0&tipopago=presencial"><?php echo $valor['cantidad_matricula_presencial']?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=151&codigotipoestudiante=10&tipopago=0"><?php echo $valor['cantidad_matriculados_nuevos'];?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=151&codigotipoestudiante=11&tipopago=0"><?php echo $valor['cantidad_matriculados_transferencia'];?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=151&codigotipoestudiante=20&tipopago=0"><?php echo $valor['cantidad_matriculados_antiguos'];?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=151&codigotipoestudiante=20&tipopago=0"><?php echo $valor['cantidad_matriculados_reintegro'];?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=152&codigotipoestudiante=0&tipopago=0"><?php echo $valor['cantidad_formulario']?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=152&codigotipoestudiante=0&tipopago=internet"><?php echo $valor['cantidad_formulario_internet']?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=152&codigotipoestudiante=0&tipopago=presencial"><?php echo $valor['cantidad_formulario_presencial']?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=153&codigotipoestudiante=0&tipopago=0"><?php echo $valor['cantidad_inscripcion']?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=153&codigotipoestudiante=0&tipopago=internet"><?php echo $valor['cantidad_inscripcion_internet']?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&codigoconcepto=153&codigotipoestudiante=0&tipopago=presencial"><?php echo $valor['cantidad_inscripcion_presencial']?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&tipopago=no&codigosituacioncarreraestudiante=106"><?php echo $valor['preinscritos']?></a></div></td>
    <td><div align="center"><a href="estadisticas_matriculas_detalle.php?codigocarrera=<?php echo $valor['codigocarrera']?>&tipopago=no&codigosituacioncarreraestudiante=107"><?php echo $valor['inscritos']?></a></div></td>
  </tr>
<?php } ?>
  <tr class="Estilo1">
    <td><div align="center">&nbsp;</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="Estilo1">
    <td colspan="2"><div align="center"><strong>SUBTOTALES</strong></div></td>
    <td><div align="center"><?php if($row_totales['cantidad_matricula']==""){echo "&nbsp;";}else{echo $row_totales['cantidad_matricula'];}?></div></td>
    <td><div align="center"><?php echo $row_totales['cantidad_matricula_internet']?></div></td>
    <td><div align="center"><?php echo $row_totales['cantidad_matricula_presencial']?></div></td>
    <td><div align="center"><?php echo $row_totales['cantidad_matriculados_nuevos']?></div></td>
    <td><div align="center"><?php echo $row_totales['cantidad_matriculados_transferencia']?></div></td>
    <td><div align="center"><?php echo $row_totales['cantidad_matriculados_antiguos']?></div></td>
    <td><div align="center"><?php echo $row_totales['cantidad_matriculados_reintegro']?></div></td>
    <td><div align="center"><?php if($row_totales['cantidad_formulario']==""){echo "&nbsp;";}else{echo $row_totales['cantidad_formulario'];}?></div></td>
    <td><div align="center"><?php echo $row_totales['cantidad_formulario_internet']?></div></td>
    <td><div align="center"><?php echo $row_totales['cantidad_formulario_presencial']?></div></td>
    <td><div align="center"><?php if($row_totales['cantidad_inscripcion']==""){echo "&nbsp;";}else{echo $row_totales['cantidad_inscripcion'];}?></div></td>
    <td><div align="center"><?php echo $row_totales['cantidad_inscripcion_internet']?></div></td>
    <td><div align="center"><?php echo $row_totales['cantidad_inscripcion_presencial']?></div></td>
    <td><div align="center"><?php echo $row_totales['preinscritos']?></div></td>
    <td><div align="center"><?php echo $row_totales['inscritos']?></div></td>
  </tr>
  <tr class="Estilo1">
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="Estilo1">
    <td colspan="17"><div align="center">
      <input name="Restablecer" type="submit" id="Restablecer" value="Restablecer">
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="Regresar" type="submit" id="Regresar" value="Regresar">
    </div></td>
    </tr>
</table>
</form>
<?php
echo date("Y-m-d H:i:s");
?>
<br>
<?php if(isset($_GET['Restablecer'])){unset($_SESSION['muestrafiltro']);?>
<script language="javascript">window.location.reload("estadisticas_matriculas_otros.php")</script>
<?php } ?>
<?php if(isset($_GET['Regresar']))
{
	echo '<script language="javascript">window.location.reload("menu.php?codigomodalidadacademica='.$_SESSION['codigomodalidadacademica'].'&codigocarrera='.$_SESSION['codigocarrera'].'&codigoperiodo='.$_SESSION['codigoperiodo'].'");</script>';
}
?>
<?php
//listar($array_datos);
?>