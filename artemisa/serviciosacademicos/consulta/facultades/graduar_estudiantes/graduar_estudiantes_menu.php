<script language="Javascript">
function abrir(pagina) {
	window.open(pagina,'window','params');
}
</script>
<?php require_once('../../../Connections/sala2.php');
@session_start();
if ($_SESSION['rol'] == 1)
{
	require_once('../../encabezado.php');
}
$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];

mysql_select_db($database_sala, $sala);

mysql_select_db($database_sala, $sala);
$query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
$row_tipousuario = mysql_fetch_assoc($tipousuario);
$totalRows_tipousuario = mysql_num_rows($tipousuario);


if (isset($_GET['codigoestudiante']))
{
	$codigoestudiante = $_GET['codigoestudiante'];
	$query_dataestudiante = "SELECT distinct c.nombrecarrera, c.codigocarrera, eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral, d.nombredocumento, d.tipodocumento,e.codigoestudiante,
						eg.numerodocumento, eg.fechanacimientoestudiantegeneral,eg.expedidodocumento,eg.idestudiantegeneral,gr.nombregenero, gr.codigogenero, e.codigoperiodo,
						 eg.celularestudiantegeneral,eg.emailestudiantegeneral, eg.codigogenero,s.nombresituacioncarreraestudiante,
						 eg.direccionresidenciaestudiantegeneral, eg.telefonoresidenciaestudiantegeneral,eg.ciudadresidenciaestudiantegeneral,
						eg.direccioncorrespondenciaestudiantegeneral, eg.telefonocorrespondenciaestudiantegeneral,eg.ciudadcorrespondenciaestudiantegeneral,e.codigocarrera
						FROM estudiante e, carrera c,documento d,estudiantegeneral eg,estudiantedocumento ed,situacioncarreraestudiante s,genero gr
						WHERE e.codigocarrera = c.codigocarrera
						and gr.codigogenero = eg.codigogenero
						AND eg.tipodocumento = d.tipodocumento
						and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
						AND ed.idestudiantegeneral = eg.idestudiantegeneral
						AND e.idestudiantegeneral = eg.idestudiantegeneral 
						AND e.idestudiantegeneral = ed.idestudiantegeneral
						AND ed.numerodocumento = '$codigoestudiante'
						order by e.codigosituacioncarreraestudiante desc";
	//echo $query_dataestudiante;
	$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
	$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
	//print_r($row_dataestudiante);
	$totalRows_dataestudiante = mysql_num_rows($dataestudiante);


	$query_periodosestudiante = "SELECT p.codigoperiodo FROM carreraperiodo c,periodo p WHERE p.codigoestadoperiodo='1'
AND c.codigoperiodo = p.codigoperiodo AND c.codigocarrera='".$row_dataestudiante['codigocarrera']."'";
	$periodosestudiante = mysql_query($query_periodosestudiante, $sala) or die("$query_periodosestudiante".mysql_error());
	$row_periodosestudiante = mysql_fetch_assoc($periodosestudiante);
	$totalRows_periodosestudiante = mysql_num_rows($periodosestudiante);
	$codigoperiodo=$row_periodosestudiante['codigoperiodo'];
	//echo $query_periodosestudiante;
	//echo $codigoperiodo;
}

?>
<html>
<head>
<title>Crear Estudiante</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="">
    <p align="center" class="Estilo3">DATOS ESTUDIANTE</p>
    <table width="600" border="2" align="center" cellpadding="2" bordercolor="#003333">
    <tr>
	<td>
	<table width="600" border="0" align="center" cellpadding="0" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Apellidos</div></td>
        <td class="Estilo1">
          <div align="center"><?php if(isset($_POST['apellidos'])) echo $_POST['apellidos']; else echo $row_dataestudiante['apellidosestudiantegeneral'];?></div></td>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Nombres</div></td>
        <td class="Estilo1"><div align="center"><?php if(isset($_POST['nombres'])) echo $_POST['nombres']; else echo $row_dataestudiante['nombresestudiantegeneral'];?></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Tipo de Documento</div></td>
        <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['nombredocumento']?></div></td>
        <td colspan="1" bgcolor="#C5D5D6" class="Estilo2"><div align="center">N&uacute;mero</div></td>
		<td colspan="1" class="Estilo1"><div align="center"><?php if(isset($_POST['documento'])) echo $_POST['documento']; else echo $row_dataestudiante['numerodocumento'];?></div></td>
      </tr>     
	  <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Expedido en</div></td>
        <td class="Estilo1"><div align="center"><?php if(isset($_POST['expedido'])) echo $_POST['expedido']; else echo $row_dataestudiante['expedidodocumento'];?></div></td>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Fecha de Nacimiento</div></td>
        <td class="Estilo1"><div align="center">
        <?php if(isset($_POST['fnacimiento'])) echo $_POST['fnacimiento']; else echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_dataestudiante['fechanacimientoestudiantegeneral']); ?>
        </div></td>
      </tr>
	   <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">G&eacute;nero</div></td>
        <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['nombregenero'];?></div></td>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Id</div></td>
		<td class="Estilo1" ><div align="center"><?php echo $row_dataestudiante['idestudiantegeneral']; ?></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Celular</div></td>
        <td class="Estilo1"><div align="center"><?php if(isset($_POST['celular'])) echo $_POST['celular']; else echo $row_dataestudiante['celularestudiantegeneral'];?></div></td>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">E-mail</div></td>
		<td class="Estilo1" ><div align="center">
		  <?php if(isset($_POST['email'])) echo $_POST['email']; else echo $row_dataestudiante['emailestudiantegeneral'];?>
		</div></td>
      </tr>
      <tr>        
      <td  bgcolor="#C5D5D6" class="Estilo2"><div align="center">Dir. Estudiante</div></td>
      <td class="Estilo1"><div align="center"><?php if(isset($_POST['direccion1'])) echo $_POST['direccion1']; else echo $row_dataestudiante['direccionresidenciaestudiantegeneral'];?></div></td>
      <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Tel&eacute;fono</div></td>
      <td class="Estilo1"><div align="center"><?php if(isset($_POST['telefono1'])) echo $_POST['telefono1']; else echo $row_dataestudiante['telefonoresidenciaestudiantegeneral'];?></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center" class="Estilo10"><strong>Dir. Correspondencia</strong></div></td>
        <td class="Estilo1"><div align="center"><?php if(isset($_POST['direccion2'])) echo $_POST['direccion2']; else echo $row_dataestudiante['direccioncorrespondenciaestudiantegeneral'];?></div></td>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Tel&eacute;fono</div></td>
        <td class="Estilo1"><div align="center"><?php if(isset($_POST['telefono2'])) echo $_POST['telefono2']; else echo $row_dataestudiante['telefonocorrespondenciaestudiantegeneral'];?></div></td>
      </tr>	  

</table>
  </td>
 </tr>
</table>
<br>
<div align="center" class="Estilo3">CARRERA GRADUACION ESTUDIANTE</div>
<br>
 <table width="600" border="2" align="center" cellpadding="2" bordercolor="#003333">
    <tr>	
	<td>	
	<table width="600" border="0" align="center" cellpadding="0" bordercolor="#003333">
    <tr class="Estilo2">	
	  <td bgcolor="#C5D5D6"><div align="center">Id</div></td>
	 <td bgcolor="#C5D5D6"><div align="center">Nombre Carrera</div></td>
	 <td bgcolor="#C5D5D6"><div align="center">Código Carrera</div></td>
	 <td bgcolor="#C5D5D6"><div align="center">Situaci&oacute;n Carrera</div></td>    
	 <td bgcolor="#C5D5D6"><div align="center">Periodo Ingreso</div></td>
	</tr>

    
	  <tr class="Estilo1">
	  <td><div align="center"><?php echo $row_dataestudiante['codigoestudiante'];?></div></td>
	  <td><a href="graduar_estudiantes_ingreso.php?codigocarrera=<?php echo $row_dataestudiante['codigocarrera'];?>&estudiante=<?php echo $row_dataestudiante['codigoestudiante'];?>&codigogenero=<?php echo $row_dataestudiante['codigogenero'];?>"</a><?php echo $row_dataestudiante['nombrecarrera'];?></td>
	    <td><div align="center">
          <?php 
          echo $row_dataestudiante['codigocarrera'];

?>
	      </div></td>
	 <td><div align="center"><?php echo $row_dataestudiante['nombresituacioncarreraestudiante'];?></div></td>
	 <td><div align="center"><?php echo $row_dataestudiante['codigoperiodo'];?></div></td>
	 </tr>
	</table>
	</td>
	</tr>	
</table> 
  

