<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../../Connections/sala2.php');
session_start();
$salatmp=$sala;
 
$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];
mysql_select_db($database_sala, $sala);
	session_start();
	mysql_select_db($database_sala, $sala);
	$query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
	$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
	$row_tipousuario = mysql_fetch_assoc($tipousuario);
	$totalRows_tipousuario = mysql_num_rows($tipousuario);


if (isset($_GET['codigocreado']))
  {
  print_r($_GET['codigocreado']);
    $codigoestudiante = $_GET['codigocreado'];
  }
else
  if (isset($_SESSION['codigo']))
  {
    $codigoestudiante = $_SESSION['codigo'];
  }
$znumerodocumento = $codigoestudiante;

$query_dataestudiante = "SELECT distinct c.nombrecarrera, c.codigocarrera, eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral, d.nombredocumento, d.tipodocumento,e.codigoestudiante,
						eg.numerodocumento, eg.fechanacimientoestudiantegeneral,eg.expedidodocumento,eg.idestudiantegeneral,gr.nombregenero,e.codigoperiodo,
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
$totalRows_dataestudiante = mysql_num_rows($dataestudiante);

if($totalRows_dataestudiante != "")
{
	$idestudiante = $row_dataestudiante['idestudiantegeneral']; 
	//mysql_select_db($database_sala, $sala);
	$query_carreras = "SELECT codigocarrera, nombrecarrera FROM carrera where codigocarrera = '".$_SESSION['codigofacultad']."' order by 2 asc";
	$carreras = mysql_query($query_carreras, $sala) or die(mysql_error());
	$row_carreras = mysql_fetch_assoc($carreras);
	$totalRows_carreras = mysql_num_rows($carreras);
	
	/////*****************
	$varencuesta=28;
	
	function realizoencuesta($idestudiante,$idencuesta,$db,$sala)
	{
	
	mysql_select_db($db, $sala);
	$sqlencuesta="SELECT sid,uid,completed,user FROM sala.enc_completed_surveys e where sid=".$idencuesta." and user=".$idestudiante;
	$varver= mysql_query($sqlencuesta, $sala) or die("QUERY: $sqlencuesta ".mysql_error());
	$total_varver = mysql_num_rows($varver);

	if ($total_varver!=0)
 
 	return  true;
	
	else 
 	return  false;
	} 

	/*if (isset($_POST['codigocreado']))
	 $codigoestudiante=$_POST['codigocreado']; 
	else 
	 $codigoestudiante;*/
	//print_r($codigoestudiante);
	//print_r($varencuesta." ".$codigoestudiante." ".$database_sala." ".$salatmp);
	
	$valencuesta=realizoencuesta($codigoestudiante,$varencuesta,$database_sala,$salatmp);
	//print_r("<br>".$valencuesta);
	/* valida si  presento  la encuesta, si la presento muestra la informacion del alumno sino muestra la encuesta*/
	if (ereg("^estudiante",$_SESSION['MM_Username']) && $valencuesta==false )
	 {
		//$url="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/creacionestudiante/estudiante.php";
		//header("Location: $url");
		$_SESSION['codigocreado']=$_SESSION['codigo'];		
		$_SESSION['varenc']=$varencuesta;
		 
		require("survey.php");


		
		} 
		else{
		
		///*******************/
	
	
	if(ereg("^estudiante",$_SESSION['MM_Username']) && !isset($_GET['sinestadocuenta']) && !isset($_POST['codigocreado']))
	{
		
		// Es estudiante Muestre el estado de cuenta
		//echo "Muestra estado";
		$ruta = '../../../'; 
		$rutaado = $ruta."funciones/adodb/";
		$rutazado = "../../../funciones/zadodb/";
		require_once($ruta.'Connections/salaado.php');
		
		$link = $ruta."../imagenes/estudiantes/"; 	 
		require_once($ruta.'funciones/datosestudiante.php');
		require_once($ruta.'funciones/sala/estadocuenta/estadocuenta.php');
		
		$codigoestudiante = $row_dataestudiante['codigoestudiante'];
		//echo "<h1>asdasd $codigoestudiante</h1>";
		//print_r($row_dataestudiante);
		$estadocuenta = new estadocuenta($codigoestudiante);
		
		if(isset($_POST['continuar']))
		{
			if(!isset($_POST['respuesta']))
			{
		?>
		<script language="javascript">
			alert("Debe seleccionar Si o No a la pregunta para poder continuar");
		</script>
		<?php	
				//exit();	
			}
			else
			{
				$guardar = true;
				$observacion = '';
				if($_POST['respuesta'] == 0)
				{
					// Se valida que sean solo letras
					/*if(!ereg("^[A-z0-9áéíóúÁÉÍÓÚ]+[A-z0-9áéíóúÁÉÍÓÚ ]+",$_POST['observacion']))
					{*/
					$observacion = trim($_POST['observacion']);
					if($observacion == '')
					{
						$guardar = false;
					?>
					<script language="javascript">
						alert("Debe escribir la razón por la que no se encuentra de acuerdo con su estado de cuenta o su plan de pago");
					</script>
					<?php
						//exit();	
					}
					$observacion = htmlspecialchars($observacion);	
				}
				// Inserta en la base de datos de estudianteestadocuenta.
				//echo "RTA = ".$_POST['respuesta'];
				if($guardar)
				{
					//$db->debug = true;
					$estadocuenta->guardarEstudianteestadocuenta($_POST['respuesta'], $observacion);
					//$db->debug = false;
				}
			}
		}

		
		if(!$estadocuenta->tieneEstadocuentaactiva())
		{
			require("../../estadocredito/estado_cuenta_nuevo.php");
			exit();
		}
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
<form name="form1" method="post" action="editarestudiante.php?codigocreado=<?php echo $codigoestudiante;?>&usuarioeditar=<?php echo $usuarioeditar;?>">
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
<?php    
  //}
?>
</table>
  </td>
 </tr>
</table>
<br>
<div align="center" class="Estilo3">CARRERA(S)  ESTUDIANTE</div>
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

<?php 
 do{
 ?>     
	  <tr class="Estilo1">
	  <td><div align="center"><?php echo $row_dataestudiante['codigoestudiante'];?></div></td>
	  <td align="center">
<?php
	  if ($_SESSION['rol'] == 1 && $varencuesta==true)
	   {  
	   		//print_r($varencuesta);
			// Esto lo hace cuando el rol es estudiante
			// Para cada carrera selecciona el código del estudiante y el periodo, pasandolo a mensajesestudianteaviso.php
			// Primero intenta seleccionar precierre si no hay selecciona el activo
			$query_selperiodo = "select p.codigoperiodo, p.codigoestadoperiodo 
			from periodo p, carreraperiodo cp 
			where p.codigoestadoperiodo = '1' 
			and cp.codigocarrera = '".$row_dataestudiante['codigocarrera']."'
			and p.codigoperiodo = cp.codigoperiodo";					
			//echo "$query_selperiodo<br>";
			$selperiodo = mysql_query($query_selperiodo, $sala) or die("$query_selperiodo");
			$totalRows_selperiodo=mysql_num_rows($selperiodo);	
			if($totalRows_selperiodo == "")
			{
				$query_selperiodo = "select p.codigoperiodo, p.codigoestadoperiodo 
				from periodo p, carreraperiodo cp 
				where p.codigoestadoperiodo = '1' 
				and cp.codigocarrera = '".$row_dataestudiante['codigocarrera']."'
				and p.codigoperiodo = cp.codigoperiodo";					
				//echo "$query_selperiodo<br>";
				$selperiodo = mysql_query($query_selperiodo, $sala) or die("$query_selperiodo");
				$totalRows_selperiodo=mysql_num_rows($selperiodo);	
			}
			$row_selperiodo=mysql_fetch_array($selperiodo);
			
			//echo "<br>".$row_selperiodo['codigoperiodo'];
	 
?>  
	    <a href="../../mensajesestudianteaviso.php?codigo=<?php echo $row_dataestudiante['codigoestudiante']."&codperiodo=".$row_selperiodo['codigoperiodo'];?>"><?php echo $row_dataestudiante['nombrecarrera']; ?></a>	        <?php	  
	   }
	   else
	   if ($row_dataestudiante['codigocarrera'] == $_SESSION['codigofacultad'] or $row_tipousuario['codigotipousuariofacultad'] == 200 or $usuario == "admintecnologia" or $usuario == "dirsecgeneral")          
	   {
	   		//$_SESSION['codigo'] = $row_dataestudiante['codigoestudiante'];         
?>
              <a href="../../prematricula/loginpru.php?codigocarrera=<?php echo $row_dataestudiante['codigocarrera'];?>&estudiante=<?php echo $row_dataestudiante['codigoestudiante'];?>"><?php echo $row_dataestudiante['nombrecarrera']; ?></a>              <?php  
	  }
	  else	   
	   {
	     echo $row_dataestudiante['nombrecarrera']; 	   
	   }
?>          
            </td>
	    <td><div align="center">
          <?php 
	 //if ($_SESSION['rol'] == 1)
	   //{ 	
		echo $row_dataestudiante['codigocarrera'];
       //}
	  
?>
	      </div></td>
	 <td><div align="center"><?php echo $row_dataestudiante['nombresituacioncarreraestudiante'];?></div></td>
	 <td><div align="center"><?php echo $row_dataestudiante['codigoperiodo'];?></div></td>
	 </tr>
<?php 
 }while($row_dataestudiante = mysql_fetch_assoc($dataestudiante));
?>	
	</table>
	</td>
	</tr>	
</table> 
	
<!-- <br><br><br><br>
<p><hr></p>
<div align="center" class="Estilo7"></div>
<br><br>  -->
<?php 
}}//}//requ<ire('../../estadocredito/estadocredito.php');

?>