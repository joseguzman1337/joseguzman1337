<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../Connections/sala2.php');
session_start();
$GLOBALS['grupos'];
$GLOBALS['materias'];
$GLOBALS['cortes'];
$MM_authorizedUsers = "";

$MM_donotCheckaccess = "true";

if (!$_SESSION['codigofacultad'] or !$_SESSION['codigoperiodosesion'])
 {
   header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");
 }

if ($_SESSION['codigofacultad'] == '98')
 {
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=notascolegio/ingresonotas.php'>";
  exit();
 }

// *** Restrict Access To Page: Grant or deny access to this page

function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {

  // For security, start by assuming the visitor is NOT authorized.

  $isValid = False;



  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.

  // Therefore, we know that a user is NOT logged in if that Session variable is blank.

  if (!empty($UserName)) {

    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.

    // Parse the strings into arrays.

    $arrUsers = Explode(",", $strUsers);

    $arrGroups = Explode(",", $strGroups);

    if (in_array($UserName, $arrUsers)) {

      $isValid = true;

    }

    // Or, you may restrict access to only certain users based on their username.

    if (in_array($UserGroup, $arrGroups)) {

      $isValid = true;

    }

    if (($strUsers == "") && true) {

      $isValid = true;

    }

  }

  return $isValid;

}

mysql_select_db($database_sala, $sala);

$periodoactivo= $_SESSION['codigoperiodosesion'];



$colname2_cursos = "0";

if (isset($periodoactivo)) {

  $colname2_cursos = (get_magic_quotes_gpc()) ? $periodoactivo : addslashes($periodoactivo);

}

$colname_cursos = "0";

if (isset($_SESSION['codigofacultad'])) {

  $colname_cursos = (get_magic_quotes_gpc()) ? $_SESSION['codigofacultad'] : addslashes($_SESSION['codigofacultad']);

}

mysql_select_db($database_sala, $sala);
$query_cursos =sprintf("SELECT CONCAT(materia.nombremateria,' - G:',grupo.idgrupo)  as materia,
CONCAT(grupo.codigomateria,'-',grupo.idgrupo) AS codgrupo, materia.codigocarrera
FROM materia,grupo
WHERE materia.codigomateria=grupo.codigomateria
and materia.codigoestadomateria = '01'
and  materia.codigocarrera = %s
and grupo.codigoperiodo = %s
and grupo.codigoestadogrupo = 10
order by materia", $colname_cursos,$colname2_cursos,$estagogrupo);
//AND materia.codigomaterianovasoft=grupo.codigomaterianovasoft
//echo $query_cursos;
$cursos = mysql_query($query_cursos,$sala) or die(mysql_error());
$row_cursos = mysql_fetch_assoc($cursos);
$totalRows_cursos = mysql_num_rows($cursos);

$colname3_estudiantes = "0";
if (isset($periodoactivo)) {
  $colname3_estudiantes = (get_magic_quotes_gpc()) ? $periodoactivo : addslashes($periodoactivo);
}

mysql_select_db($database_sala, $sala);
$query_estudiantes ="SELECT e.codigoestudiante,eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral
FROM prematricula p,detalleprematricula d,estudiante e,estudiantegeneral eg
WHERE eg.idestudiantegeneral = e.idestudiantegeneral
AND p.codigoestudiante = e.codigoestudiante
AND p.idprematricula = d.idprematricula
AND d.idgrupo = '".$_SESSION['grupos']."'
AND p.codigoperiodo = '".$periodoactivo."'
AND p.codigoestadoprematricula LIKE '4%'
AND d.codigoestadodetalleprematricula LIKE '3%'
ORDER BY 4";
$estudiantes = mysql_query($query_estudiantes,$sala) or die(mysql_error());
$row_estudiantes = mysql_fetch_assoc($estudiantes);
$totalRows_estudiantes = mysql_num_rows($estudiantes);

mysql_select_db($database_sala, $sala);
$query_fecha ="SELECT *
FROM corte c,grupo g
WHERE g.idgrupo = '".$_SESSION['grupos']."'
AND c.codigoperiodo = '".$periodoactivo."'
AND c.numerocorte = '".$_SESSION['cortes']."'
AND c.codigomateria = g.codigomateria
AND c.codigoperiodo =g.codigoperiodo";
//AND c.codigomaterianovasoft = g.codigomaterianovasoft
//echo $query_fecha;
$fecha = mysql_query($query_fecha,$sala) or die(mysql_error());
$row_fecha = mysql_fetch_assoc($fecha);
$totalRows_fecha = mysql_num_rows($fecha);

$i= 1;

$contadorcortes = 0;

if ($totalRows_fecha <> 0)
  {

  }

else
if ($totalRows_fecha==0)
{
	mysql_select_db($database_sala, $sala);
	$query_fecha = "SELECT *
    FROM corte
	WHERE codigocarrera = '".$_SESSION['codigofacultad']."'
	AND numerocorte = '".$_SESSION['cortes']."'
    and codigoperiodo = '".$periodoactivo."'
    order by numerocorte";
	$fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
	$row_fecha = mysql_fetch_assoc($fecha);
	$totalRows_fecha = mysql_num_rows($fecha);
}

if (! $row_fecha and $_SESSION['cortes'] <> "")
	{
	  session_unregister('cortes');
	  session_unregister('grupos');
	  echo '<script language="JavaScript">alert("No se produjo ningun resultado");history.go(-1);</script>';
	}

////////////////////////////////
mysql_select_db($database_sala, $sala);

$query_nombremateria = "SELECT materia.nombremateria
FROM materia,grupo
WHERE grupo.codigomateria = '".$_SESSION['materias']."'
AND grupo.idgrupo = '".$_SESSION['grupos']."'
AND grupo.codigomateria = materia.codigomateria
and materia.codigoestadomateria = '01'";
$nombremateria = mysql_query($query_nombremateria,$sala) or die(mysql_error());
$row_nombremateria = mysql_fetch_assoc($nombremateria);
$totalRows_nombremateria = mysql_num_rows($nombremateria);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

<title>Modificacion de Notas</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<script language="JavaScript" type="text/JavaScript">

<!--





function MM_jumpMenu(targ,selObj,restore){ //v3.0

  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");

  if (restore) selObj.selectedIndex=0;

}

//-->

</script>

<style type="text/css">

<!--

.style1 {

	font-family: Tahoma;

	font-size: small;

}

.style3 {

	font-size: x-small;

	font-weight: bold;

	font-family: Tahoma;

}

.style4 {

	font-size: x-small;

	font-family: Tahoma;

}

.style5 {

	font-family: Tahoma;

	font-size: x-small;

}

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

a:link {

	text-decoration: none;

	color: #000000;

}

a:visited {

	text-decoration: none;

	color: #000000;

}

a:hover {

	text-decoration: none;

	color: #000000;

}

a:active {

	text-decoration: none;

	color: #000000;

}

.Estilo1 {

	font-family: Tahoma;

	font-weight: bold;

	font-size: small;

}

.Estilo2 {font-size: 14px}

.Estilo4 {font-size: 12; font-weight: bold; }

.Estilo5 {font-family: Tahoma; font-size: 12px; }

.Estilo6 {font-family: Tahoma; font-weight: bold;}

.Estilo7 {font-size: 12px; font-weight: bold; }

.Estilo9 {font-size: 12}

-->

</style>

</head>



<body>

<span class="style5">  </span>

<form name="form1" method="post" action="cargavariablesmodificarnotas_sinres.php">

<?php

$banderagrabar =0;

if ($_POST['Submit2'] == true)
  {
	 for($q=1; $q <= $totalRows_estudiantes; $q++)
	   {
		if ((!eregi("^[0-5]{1,1}\.[0-9]{1,1}$", $_POST['nota1'.$q])) or ($_POST['nota1'.$q] > 5))
		  {
		   echo '<script language="JavaScript">alert("Las Notas se deben Digitar en Formato 0.0 a 5.0 con separador PUNTO(.)")</script>';
		   $q = $totalRows_estudiantes + 1 ;
		   $banderagrabar = 1;
		   $_POST['Submit'] == false;
		  }
	     else
		   if ((!eregi("^[0-9]{1,2}$", $_POST['fallateorica1'.$q])) or (!eregi("^[0-9]{1,2}$", $_POST['fallapractica1'.$q])))
		  {
		   echo '<script language="JavaScript">alert("Las fallas se deben digitar en formato numerico")</script>';
		   $q = $totalRows_estudiantes + 1 ;
		   $banderagrabar = 1;
		   $_POST['Submit'] == false;
		 }
	   }
	  if ( $banderagrabar == 0)
	    {
		  require_once('validarmodificacionsala.php');
		  exit();
		}
  }// fin if de boton
?>
  <div align="center">
    <p class="Estilo1 Estilo2">LISTADO GRUPO ACAD&Eacute;MICO</p>
  </div>
  <table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td colspan="4" class="Estilo5"><span class="Estilo6">Facultad: </span> <?php echo "".$_SESSION['codigofacultad']." ".$_SESSION['nombrefacultad'] ?> </td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="style5"><div align="center" class="Estilo7">Materia
      </div></td>
      <td class="style5"><span class="Estilo4">
<select name="materiagrupo" id="materiagrupo">
<option value="0"<?php if (!(strcmp(0, $_POST['materiagrupo']))) {echo "SELECTED";} ?>>Seleccionar Materia</option>
<?php
do {
?>
    <option value="<?php echo $row_cursos['codgrupo']?>"><?php echo $row_cursos['materia']?></option>
<?php

} while ($row_cursos = mysql_fetch_assoc($cursos));

  $rows = mysql_num_rows($cursos);

  if($rows > 0) {

      mysql_data_seek($cursos, 0);

	  $row_cursos = mysql_fetch_assoc($cursos);
  }
?>
        </select>
      </span></td>
      <td bgcolor="#C5D5D6" class="style5"><div align="center" class="Estilo7">Corte</div></td>
      <td class="style5">
       <input name="corte" type="text" id="corte" size="1" maxlength="2">
	  </td>
    </tr>
</table>
  <div align="center">
    <input type="submit" name="Submit" value="Consultar">
    <input name="periodo" type="hidden" id="periodo" value="<?php echo $periodoactivo ?>">
   <span class="style5">  </span>  <span class="style5">  </span>  <span class="style5">  </span><span class="style5">
     </span>
  </div>
</form>
<?php

if ($row_fecha <> "")
 {
?>
<span class="style5"></span>
  <table width="500"  border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
   <tr>
      <td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Materia</strong></div></td>
      <td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Porcentaje</strong></div></td>
      <td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Corte</strong></div></td>
      <td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Fecha</strong></div></td>
    </tr>
    <tr>
      <td class="Estilo5"><div align="center"><strong> </strong><?php echo $row_nombremateria['nombremateria']; ?></div></td>
      <td class="Estilo5">
        <div align="center"><?php echo $row_fecha['porcentajecorte'];?></div></td>
      <td class="Estilo5"><div align="center"><?php echo $_SESSION['cortes'] ?></div></td>
      <td class="Estilo5"><div align="center"><?php echo date("j/m/Y G:i:s",time());?></div></td>
    </tr>
</table>
<form name="form2" method="post" action="notassala_sinres.php">
 <div align="center">
    <table width="500" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#E97914">
        <tr>
          <td align="left" valign="top" class="style5"><div align="center" class="Estilo7">N&ordm;</div></td>
          <td align="left" valign="top" class="style5"><div align="center" class="Estilo7">Documento</div></td>
          <td align="left" valign="top" class="style5"><div align="center" class="Estilo7">Apellidos</div></td>
          <td align="left" valign="top" class="style5"><div align="center" class="Estilo7">Nombres</div></td>
          <td align="left" valign="top" class="style5"><div align="center" class="Estilo7">Nota</div></td>
          <td align="left" valign="top" class="style5"><div align="center" class="Estilo7">FT</div></td>
          <td align="left" valign="top" class="style5"><div align="center" class="Estilo7">FP</div></td>
        </tr>
        <?php if ($totalRows_estudiantes > 0 ) {
	  $j=1;
	  do {
	     	$query_estudiantes1="SELECT e.codigoestudiante,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,c.numerocorte,c.porcentajecorte,
			dn.nota,c.fechafinalcorte,c.fechainicialcorte,dn.numerofallasteoria,dn.numerofallaspractica
			FROM estudiante e,corte c,detallenota dn,estudiantegeneral eg
			WHERE eg.idestudiantegeneral = e.idestudiantegeneral
			AND dn.codigoestudiante = e.codigoestudiante
			AND c.idcorte = dn.idcorte
			AND c.numerocorte = '".$_SESSION['cortes']."'
			AND dn.idgrupo ='".$_SESSION['grupos']."'
			AND dn.codigoestudiante = '".$row_estudiantes['codigoestudiante']."'";
			//echo $query_estudiantes1;
			$estudiantes1 = mysql_query($query_estudiantes1,$sala) OR die(mysql_error());
			$row_estudiantes1 = mysql_fetch_assoc($estudiantes1);
			$totalRows_estudiantes1 = mysql_num_rows($estudiantes1);
 ?>
        <tr>
          <td align="center" valign="middle" class="style5 Estilo9"><?php if ($row_fecha <> "") { echo $j; ?>
            <div align="center"></div></td>
          <td align="right" valign="middle" class="style5"><div align="center" class="Estilo9"><?php echo $row_estudiantes['numerodocumento']; ?></div></td>
          <td align="left" valign="middle" class="style5"><div align="center" class="Estilo9"><?php echo $row_estudiantes['apellidosestudiantegeneral']; ?> </div></td>
          <td align="left" valign="middle" class="style5"><div align="center" class="Estilo9"><?php echo $row_estudiantes['nombresestudiantegeneral']; ?></div></td>
    <?php

		if((!$row_estudiantes1))
		 {
				if ($_POST['nota1'.$j] == "")
				   {
					 $_POST['nota1'.$j]="0.0";
				   }
			  // else
			   if ($_POST['fallateorica1'.$j] == "")
				   {
					 $_POST['fallateorica1'.$j]="0";
				   }
			   //else
			   if ($_POST['fallapractica1'.$j] == "")
				   {
					 $_POST['fallapractica1'.$j]="0";
				   }
				 echo "<td align='center' valign='top'><span class='style4'><strong><input type='text' size='1' maxlength='3' name='nota1".$j."' value='".$_POST['nota1'.$j]."'>&nbsp;</strong></span></td>";
				 echo "<td align='center' valign='top'><span class='style4'><strong><input type='text' size='1' maxlength='2' name='fallateorica1".$j."' value='".$_POST['fallateorica1'.$j]."'>&nbsp;</strong></span></td>";
				 echo "<td align='center' valign='top'><span class='style4'><strong><input type='text' size='1' maxlength='2' name='fallapractica1".$j."' value='".$_POST['fallapractica1'.$j]."'>&nbsp;</strong></span></td>";
		 }
		else
		 if (($row_estudiantes1 <> ""))
		    {
			   echo "<td align='center' valign='top'><span class='style4'><strong><input type='text' size='1' maxlength='3' name='nota1".$j."' value='".$row_estudiantes1['nota']."'>&nbsp;</strong></span></td>";
			   echo "<td align='center' valign='top'><span class='style4'><strong><input type='text' size='1' maxlength='2' name='fallateorica1".$j."' value='".$row_estudiantes1['numerofallasteoria']."'>&nbsp;</strong></span></td>";
			   echo "<td align='center' valign='top'><span class='style4'><strong><input type='text' size='1' maxlength='2' name='fallapractica1".$j."' value='".$row_estudiantes1['numerofallaspractica']."'>&nbsp;</strong></span></td>";
			}
?>
        </tr>
 <?php
	   //}
	   }
	   $j++;
	   } while ($row_estudiantes = mysql_fetch_assoc($estudiantes));

   $query_actividad="SELECT actividadesacademicasteoricanota,actividadesacademicaspracticanota
   from nota n,corte c
   where c.idcorte = n.idcorte
   and c.numerocorte = '".$_SESSION['cortes']."'
   and n.idgrupo ='".$_SESSION['grupos']."'";
     //echo $query_estudiantes1;
   $actividad = mysql_query($query_actividad,$sala) OR die(mysql_error());
   $row_actividad = mysql_fetch_assoc($actividad);
   $totalRows_actividad = mysql_num_rows($actividad);
   //echo $query_actividad;


?>
       <tr>
		 <td colspan="2" class="style5"><div align="center" class="Estilo7">Actividades Teóricas</div></td>
		 <td ><input name="teorico" type="text" value="<?php echo $row_actividad['actividadesacademicasteoricanota']; ?>" size="1" maxlength="3"></td>
		 <td colspan="2"  class="style5"><div align="center" class="Estilo7">Actividades Prácticas</div></td>
		 <td colspan="2"><input name="practico" type="text" value="<?php echo $row_actividad['actividadesacademicaspracticanota']; ?>" size="1" maxlength="3"></td>
		</tr>
        <tr align="center" valign="top">

          <td colspan="7" class="Estilo5"><?php //echo "<input name='porcentaje".$_POST['corte']."' type='hidden' id='porcentaje".$_POST['corte']."' value='$porcent'>"; ?> <?php //echo "<input name='corte' type='hidden' id='corte' value='".$_POST['corte']."'>"; ?>

            <input name="idcorte" type="hidden" id="idcorte" value="<?php echo $row_fecha['idcorte'];?>">

            <input name="materia" type="hidden" id="materia" value="<?php echo $materiagrupo[0];?>">

            <input name="grupo" type="hidden" id="grupo" value="<?php echo $materiagrupo[1];?>">
<?php
    $query_procesoperiodo = "SELECT	*
	FROM procesoperiodo
	WHERE codigoperiodo = '$periodoactivo'
    and codigocarrera = '$colname_cursos'
	and idproceso = '1'
	and codigoestadoprocesoperiodo = '200'";
	//echo $query_procesoperiodo;
	$procesoperiodo = mysql_query($query_procesoperiodo, $sala) or die(mysql_error());
	$row_procesoperiodo = mysql_fetch_assoc($procesoperiodo);
	$totalRows_procesoperiodo = mysql_num_rows($procesoperiodo);

		//if ($_SESSION['codigoestadoperiodosesion'] <> 2 and !$row_procesoperiodo)
		  {
			echo "<input name='Submit2' type='submit' value='Guardar Cambios'> ";
		  }
		 /*else
		  {
		   echo "No es posible modificar notas ya que fue generado el cierre";
		  }*/
?></td>
       </tr>
    </table>
    <?php }
	   }
	  ?>
  </div>
    <p>&nbsp;</p>

    <p>&nbsp;</p>

    <p>&nbsp;</p>

</form>

  <br>

  <span class="style5">  </span>  <span class="style5">  </span>

  <span class="style5"><br>

	<br>

	<br>



</span><span class="style4"></span><span class="style1"><br>

    </span>

    <span class="style1"> </span>

</body>

</html>

<?php

mysql_free_result($cursos);

mysql_free_result($estudiantes);

mysql_free_result($nombremateria);

?>

