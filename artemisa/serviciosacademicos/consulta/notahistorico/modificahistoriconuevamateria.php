<?php 

session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require('../../Connections/sala2.php' ); 
$salatmp=$sala;
mysql_select_db($database_sala, $salatmp);

$rutaado=("../../funciones/adodb/");
require_once(realpath(dirname(__FILE__)).'/../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__))."/../../funciones/funcionboton.php");
require_once(realpath(dirname(__FILE__))."/../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__)).'/../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once(realpath(dirname(__FILE__)).'/../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
include_once(rrealpath(dirname(__FILE__)).'/../../utilidades/ValidarModuloNota.php');
include_once(realpath(dirname(__FILE__)).'/../../utilidades/Ipidentificar.php');

//identificaicon de la ip del usuario
$A_Validarip = new ipidentificar();
$ip = $A_Validarip->tomarip();
//validacion del ingreso del modulo
$C_ValidarFecha = new ValidarModulo(); 
$alerta = $C_ValidarFecha->ValidarIngresoModulo($_SESSION['usuario'], $ip, 'NotaHistorico-NuevaMateria');
//si el usuario ingresa durante fecha no autorizadas se genera la alerta.
if($alerta)
{
    echo $alerta;
    die;
}


$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

$idmenuboton=51;
if(!validaUsuarioMenuBoton($idmenuboton,$formulario,$objetobase))
{
	 echo "
	 <script language='javascript'>
		 alert('Usted no tiene permiso para entrar a esta opcion');
	   parent.location.href='https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm';
	 </script>";
}


if (! isset ($_SESSION['nombreprograma']))
 {?>
	<script language='javascript'>
	 // window.location.reload("../login.php");
	</script>
<?php	
 }
$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];

  mysql_select_db($database_sala, $salatmp);
  $query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
  $tipousuario = mysql_query($query_tipousuario, $salatmp) or die(mysql_error());
  $row_tipousuario = mysql_fetch_assoc($tipousuario);
  $totalRows_tipousuario = mysql_num_rows($tipousuario);

if (isset($_GET['periodo']))
  {
   $periodo = $_GET['periodo'];   
  }
 
 if (isset($_GET['codigoestudiante']))
  {
   $codigoestudiante = $_GET['codigoestudiante'];
  }
  if ($_GET['Submit2'])
   {
   echo '<script language="JavaScript">window.location.href="modificahistoricoformulario.php?codigoestudiante='.$codigoestudiante.'&periodo='.$periodo.'";</script>';					
   } 

//mysql_select_db($database_sala, $sala);
$query_Recordset2 = "SELECT * FROM estudiante e,estudiantegeneral eg
                      WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					  and e.codigoestudiante = '$codigoestudiante'";
$Recordset2 = mysql_query($query_Recordset2, $salatmp) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);


?>
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: small;
}
.style3 {
	font-size: x-small;
	font-weight: bold;
}
.style4 {font-size: x-small}
.style5 {
	color: #FF0000;
	font-weight: bold;
}
body {
	margin-top: 0px;
}
.style41 {	font-size: x-small;
	font-family: Tahoma;
}
.style51 {	font-family: Tahoma;
	font-size: x-small;
}
.style31 {	font-size: x-small;
	font-weight: bold;
	font-family: Tahoma;
}
.Estilo28 {
	font-family: Tahoma;
	font-weight: bold;
}
-->
</style>
<?php
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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

//mysql_select_db($database_sala, $sala);
$query_tiponota = "SELECT * FROM tiponotahistorico 
                   WHERE codigotiponotahistorico = '100'";
$tiponota = mysql_query($query_tiponota, $salatmp) or die(mysql_error());
$row_tiponota = mysql_fetch_assoc($tiponota);
$totalRows_tiponota = mysql_num_rows($tiponota);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<form name="form1" method="get" action="modificahistoriconuevamateria.php">
<?php
$tipomateria = "";
$plan = "";
$banderaelectiva = 0;
//mysql_select_db($database_sala, $sala);

if ($row_tipousuario['codigotipousuariofacultad'] == 200)
 { // if
   $query_cursos ="SELECT DISTINCT m.codigomateria,m.nombremateria
					FROM materia m, estudiante e
					WHERE  m.codigoestadomateria = '01'
					AND m.codigocarrera = '".$row_tipousuario['codigofacultad']."'	
					";
					//AND materia.codigoestudiantematerianovasoft=grupo.codigoestudiantematerianovasoft 
	  
	 // echo $query_cursos; 				
	$cursos = mysql_query($query_cursos,$salatmp) or die(mysql_error());
	$row_cursos = mysql_fetch_assoc($cursos);
	$totalRows_cursos = mysql_num_rows($cursos);
	$plan = ""; 
 }
else
 {
	$query_cursos ="SELECT m.nombremateria,m.codigomateria
					FROM materia m
					WHERE  m.codigoestadomateria = '01'
					AND  m.codigocarrera = '".$_SESSION['codigofacultad']."'
					ORDER BY 1";
					//AND materia.codigoestudiantematerianovasoft=grupo.codigoestudiantematerianovasoft 
	 // echo $query_cursos; 				
	$cursos = mysql_query($query_cursos,$salatmp) or die(mysql_error());
	$row_cursos = mysql_fetch_assoc($cursos);
	$totalRows_cursos = mysql_num_rows($cursos);
	$plan = "";
 }
if ($plan == "")
 {
    $query_study ="SELECT idplanestudio 
                FROM planestudioestudiante
				WHERE codigoestudiante = '".$codigoestudiante."'
				AND codigoestadoplanestudioestudiante LIKE '1%'
				";
				//AND materia.codigoestudiantematerianovasoft=grupo.codigoestudiantematerianovasoft 
	 // echo $query_cursos; 				
	$study = mysql_query($query_study,$salatmp) or die(mysql_error());
	$row_study = mysql_fetch_assoc($study);
	$totalRows_study = mysql_num_rows($study);
   $plan = $row_study['idplanestudio'];
 }
if ($_GET['materia'] <> 0)
 {
        mysql_select_db($database_sala, $salatmp);
		$query_car = "SELECT m.codigoindicadorgrupomateria,d.codigotipomateria
					 FROM detalleplanestudio d,materia m  
					 where d.codigomateria = m.codigomateria
					 and d.codigomateria = '".$_GET['materia']."'
					 and idplanestudio = '$plan'
					 order by 1";		
		//echo $query_car;
		$car = mysql_query($query_car, $salatmp) or die(mysql_error());
		$row_car = mysql_fetch_assoc($car);
		$totalRows_car = mysql_num_rows($car);
   
   $tipomateria = $row_car['codigotipomateria'];   
   
   if ($row_car['codigoindicadorgrupomateria'] == 100) 	
	{ 
	    mysql_select_db($database_sala, $salatmp);
		$query_grupomateria = "select *
				from grupomaterialinea gml, materia m, grupomateria gm, detallegrupomateria d
				where  gm.codigoperiodo = '$periodoactual'
				and d.idgrupomateria = gm.idgrupomateria
				and m.codigomateria = d.codigomateria
				and gml.codigomateria = '".$_GET['materia']."'
				and gml.idgrupomateria = d.idgrupomateria
				and gml.codigoperiodo = '$periodoactual'
				and gm.codigoperiodo = gml.codigoperiodo
				order by m.nombremateria
				";		
		//echo $query_car;
		$grupomateria = mysql_query($query_grupomateria, $salatmp) or die(mysql_error());
		$row_grupomateria = mysql_fetch_assoc($grupomateria);
		$totalRows_grupomateria = mysql_num_rows($grupomateria);   
	
	   $tipomateria = 4; 
	}
   else
    {
	  if ($row_car['codigoestudiantetipomateria'] == 5)
	   {
	            mysql_select_db($database_sala, $salatmp);
				$query_electiva = "SELECT distinct d.codigomateriadetallelineaenfasisplanestudio,m.nombremateria
								 FROM detallelineaenfasisplanestudio d,materia m  
								 where d.codigomateria = '".$_GET['materia']."'
								 and d.idplanestudio = '$plan'
								 and d.codigomateriadetallelineaenfasisplanestudio = m.codigoestudiantemateria
								 order by m.nombremateria
								 ";		
				//echo $query_electiva;
				$electiva = mysql_query($query_electiva, $salatmp) or die(mysql_error());
				$row_electiva = mysql_fetch_assoc($electiva);
				$totalRows_electiva = mysql_num_rows($electiva);			 
	   
	      
	   }
	  else
	    if ($row_car['codigoestudiantetipomateria'] == 4)
	   {
	     mysql_select_db($database_sala, $salatmp);
		$query_electiva = "select *
							from materia m, grupomateria gm, detallegrupomateria d
							where gm.codigotipogrupomateria = '100'
							and gm.codigoperiodo = '$periodoactual'
							and d.idgrupomateria = gm.idgrupomateria
							and m.codigomateria = d.codigomateria
							order by m.nombremateria
";		
		$electiva = mysql_query($query_electiva, $salatmp) or die(mysql_error());
		$row_electiva = mysql_fetch_assoc($electiva);
		$totalRows_electiva = mysql_num_rows($electiva);  
	   
	     
	  }
	}
 }

?>
<script language="javascript">
function enviar()
			{
			 document.form1.submit();
			}
</script>
 <p align="center"><span class="Estilo3 Estilo28">Modificaci&oacute;n Historico de Notas </span></p>
  <table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td colspan="5" class="style51" bgcolor="#C5D5D6">  <div align="center"><strong><?php echo "".$_SESSION['codigofacultad']." ".$_SESSION['nombrefacultad'];?></strong></div></td>
    </tr>
    <tr>
      <td class="style51" bgcolor="#C5D5D6"><div align="center"><span class="style31">Nombre</span></div></td>
      <td colspan="2" class="style51"><?php  echo $row_Recordset2['apellidosestudiantegeneral']."&nbsp;".$row_Recordset2['nombresestudiantegeneral'];?></td>
      <td class="style51" bgcolor="#C5D5D6"><div align="center"><span class="style31">Documento</span></div></td>
      <td class="style51"><?php echo $row_Recordset2['numerodocumento']; ?></td>
    </tr>
    <tr>
      <td class="style51" bgcolor="#C5D5D6"><div align="center"><strong><strong>Materia</strong></strong></div></td>
      <td class="style51">
<?php 
if ($row_tipousuario['codigotipousuariofacultad'] == 100)
 { // if materia
?>  
	   <select name="materia" id="materia" onChange="enviar()">
       <option value="0" <?php if (!(strcmp(0, $_GET['materia']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
$quitarmaterias = "";
$query_enfasis ="SELECT distinct codigomateriadetallelineaenfasisplanestudio
                FROM detallelineaenfasisplanestudio
				where idplanestudio = '$plan'";
				//AND materia.codigoestudiantematerianovasoft=grupo.codigoestudiantematerianovasoft 
 // echo $query_cursos; 				
$enfasis = mysql_query($query_enfasis,$salatmp) or die(mysql_error());
$row_enfasis = mysql_fetch_assoc($enfasis);
$totalRows_enfasis = mysql_num_rows($enfasis);
do {  
  $quitarmaterias = "$quitarmaterias and codigomateria <> '".$row_enfasis['codigomateriadetallelineaenfasisplanestudio']."'";
} while($row_enfasis = mysql_fetch_assoc($enfasis));


do {  
$quitarmaterias = "$quitarmaterias and m.codigomateria <> '".$row_cursos['codigomateria']."'";

?>
          <option value="<?php echo $row_cursos['codigomateria']?>"<?php if (!(strcmp($row_cursos['codigomateria'], $_GET['materia']))) {echo "SELECTED";} ?>><?php echo $row_cursos['codigomateria']?>&nbsp;&nbsp;<?php echo $row_cursos['nombremateria']?></option>
          <?php
} while ($row_cursos = mysql_fetch_assoc($cursos));
  
  $rows = mysql_num_rows($cursos);
  if($rows > 0) {
      mysql_data_seek($cursos, 0);
	  $row_cursos = mysql_fetch_assoc($cursos);
  }
$query_cursos ="SELECT m.nombremateria,m.codigomateria 
                FROM materia m
				WHERE  m.codigoestadomateria = '01'
				AND m.codigocarrera = '".$_SESSION['codigofacultad']."'
				$quitarmaterias
				ORDER BY 1";
				//AND materia.codigoestudiantematerianovasoft=grupo.codigoestudiantematerianovasoft 
 // echo $query_cursos; 				
$cursos = mysql_query($query_cursos,$salatmp) or die(mysql_error());
$row_cursos = mysql_fetch_assoc($cursos);
$totalRows_cursos = mysql_num_rows($cursos);
do {

?>
          <option value="<?php echo $row_cursos['codigomateria']?>"<?php if (!(strcmp($row_cursos['codigomateria'], $_GET['materia']))) {echo "SELECTED";} ?>><?php echo $row_cursos['codigomateria']?>&nbsp;&nbsp;<?php echo $row_cursos['nombremateria']?></option>
          <?php
} while ($row_cursos = mysql_fetch_assoc($cursos));
  
  $rows = mysql_num_rows($cursos);
  if($rows > 0) {
      mysql_data_seek($cursos, 0);
	  $row_cursos = mysql_fetch_assoc($cursos);
  }
?>
        </select>
<?php 
} // if materia
else
 { // else 1 ?>
     <select name="materia" id="materia" onChange="enviar()">
     <option value="0" <?php if (!(strcmp(0, $_GET['materia']))) {echo "SELECTED";} ?>>Seleccionar</option> 
<?php     
	 do {

?>
          <option value="<?php echo $row_cursos['codigomateria']?>"<?php if (!(strcmp($row_cursos['codigomateria'], $_GET['materia']))) {echo "SELECTED";} ?>><?php echo $row_cursos['codigoestudiantemateria']?>&nbsp;&nbsp;<?php echo $row_cursos['nombremateria']?></option>
          <?php
} while ($row_cursos = mysql_fetch_assoc($cursos));
  
  $rows = mysql_num_rows($cursos);
  if($rows > 0) {
      mysql_data_seek($cursos, 0);
	  $row_cursos = mysql_fetch_assoc($cursos);
  }

 } // else 1 
?>  
      <td class="style51"><select name="tiponota" id="tiponota">
          <option value="0" <?php if (!(strcmp(0, $_GET['tiponota']))) {echo "SELECTED";} ?>>Tipo Nota</option>
          <?php
do {  
?>
          <option value="<?php echo $row_tiponota['codigotiponotahistorico']?>"<?php if (!(strcmp($row_tiponota['codigotiponotahistorico'], $_GET['tiponota']))) {echo "SELECTED";} ?>><?php echo $row_tiponota['nombretiponotahistorico']?></option>
          <?php
} while ($row_tiponota = mysql_fetch_assoc($tiponota));
  $rows = mysql_num_rows($tiponota);
  if($rows > 0) {
      mysql_data_seek($tiponota, 0);
	  $row_tiponota = mysql_fetch_assoc($tiponota);
  }
?>
      </select>    
	  
	 
      <td class="style51" bgcolor="#C5D5D6"><div align="center"><strong>Nota</strong></div></td>
      <td class="style51"><input name="notas" type="text" id="notas" value="<?php echo $_GET['notas'];?>" size="1" maxlength="3">
&nbsp;</td>
    </tr>
    <tr>
      <?php 
	 //if ($row_grupomateria <> "")
     //{ // if materia electiva	 
	  
	 if ($row_electiva <> "")
	  { 
	     $banderaelectiva = 1;
	   ?>
      <td colspan="5" class="style51" bgcolor="#C5D5D6"><div align="left"><strong><strong> Seleccione la electiva</strong>: </strong>
              <select name="materiaelectiva" id="materiaelectiva">
                <option value="0" <?php if (!(strcmp("0", $_GET['materiaelectiva']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
			do {  
			?>
                <option value="<?php echo $row_electiva['codigomateriadetallelineaenfasisplanestudio']?>"<?php if (!(strcmp($row_electiva['codigomateriadetallelineaenfasisplanestudio'], $_GET['materiaelectiva']))) {echo "SELECTED";} ?>><?php echo $row_electiva['codigomateriadetallelineaenfasisplanestudio']?>&nbsp;&nbsp;<?php echo $row_electiva['nombremateria']?></option>
                <?php
			} while ($row_electiva = mysql_fetch_assoc($electiva));
			  $rows = mysql_num_rows($electiva);
			  if($rows > 0) {
				  mysql_data_seek($electiva, 0);
				  $row_car = mysql_fetch_assoc($electiva);
			  }
?>
              </select>
      </div></td>
      <?php 
       }
	  else
	   if ($row_grupomateria <> "") 
	   {
	      $banderaelectiva = 1;
	    ?>
      <td colspan="5" class="style51" bgcolor="#C5D5D6"><div align="left"><strong><strong> Seleccione la electiva</strong>: </strong>
              <select name="materiaelectiva" id="materiaelectiva">
                <option value="0" <?php if (!(strcmp("0", $_GET['materiaelectiva']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
			do {  
			?>
                <option value="<?php echo $row_grupomateria['codigomateria']?>"<?php if (!(strcmp($row_grupomateria ['codigomateria'], $_GET['materiaelectiva']))) {echo "SELECTED";} ?>><?php echo $row_grupomateria['codigomateria']?>&nbsp;&nbsp;<?php echo $row_grupomateria ['nombremateria']?></option>
                <?php
			} while ($row_grupomateria  = mysql_fetch_assoc($grupomateria ));
			  $rows = mysql_num_rows($grupomateria );
			  if($rows > 0) {
				  mysql_data_seek($grupomateria , 0);
				  $row_grupomateria  = mysql_fetch_assoc($grupomateria );
			  }
?>
              </select>
      </div></td>
      <?php		
		
		} 
	//  } // if materia electiva	  
?>
    </tr>
    <tr>
       <td colspan="5" class="style51"><div align="center"><strong><strong>Observaci&oacute;n</strong>:
                <input name="observacion" type="text" value="<?php echo $_GET['observacion'];?>" size="50">
      </strong></div></td>
   </tr>
    <tr>
      <td colspan="5" class="style51"><div align="center"><strong>
          <input type="submit" name="Submit" value="Guardar">
  &nbsp;&nbsp;
          <input type="submit" name="Submit2" value="Regresar">
      </strong></div></td>
    </tr>
  </table>
  <br>  
  <input name="periodo" type="hidden" id="periodo" value="<?php echo $periodo; ?>">
  <input name="codigoestudiante" type="hidden" id="codigoestudiante" value="<?php echo $codigoestudiante; ?>">
  <input name="nombre" type="hidden" id="nombre" value="<?php echo $nombre; ?>">
  <input type="hidden" name="tipomateria" value="<?php echo $tipomateria;?>">  
  <input type="hidden" name="planestudiante" value="<?php echo $plan;?>">  
<?php
$banderagrabar= 0;

 if ($_GET['Submit'])
  {	 	  
	  if ((!eregi("^[0-5]{1,1}\.[0-9]{1,1}$", $_GET['notas'])) or ($_GET['notas'] > 5))
		  {
		   echo '<script language="JavaScript">alert("Las Notas se deben Digitar en Formato 0.0 a 5.0 con separador PUNTO(.)")</script>';
		   $banderagrabar= 1;
		 }	     
	  else
	    if($_GET['tiponota'] == 0)
		  {
		    echo '<script language="JavaScript">alert("Debe elegir el tipo de nota")</script>';
		    $banderagrabar= 1;
		  }  
	   else
	    if($_GET['materia'] == 0)
		  {
		    echo '<script language="JavaScript">alert("Debe elegir la  materia")</script>';
		    $banderagrabar= 1;
		  }  
	   else
	    // echo $_GET['materiaelectiva'],"&nbsp;",$banderaelectiva;
	    if($_GET['materiaelectiva'] == 0 and $banderaelectiva == 1)
		  {
		    echo '<script language="JavaScript">alert("Debe elegir una Electiva")</script>';
		    $banderagrabar= 1;
		  }  
	  else
	    if($banderagrabar == 0)	  
	    {
		  require_once('modificahistoricooperacion.php');
		  exit();
		}	
  }// fin if de boton
?>
</form>
</body>
</html>
<?php 
mysql_free_result($cursos);
mysql_free_result($tiponota);
?>
