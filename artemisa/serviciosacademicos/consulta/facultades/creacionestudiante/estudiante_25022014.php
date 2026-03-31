<?php



require_once('../../../Connections/sala2.php');
$salatmp=$sala;
$rutaado = ("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
$salatmp2=$sala;
unset($sala);
$sala=$salatmp;

require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/encuestav2/ValidaEncuesta.php");
require_once("../../encuesta/encuestaautoevaluacion/validaencuestainstitucional.php");

require_once("validaevaluaciondocente.php");
session_start();
?>
<?php
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";  */
$salatmp=$sala;
$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];
//echo $periodoactual;
mysql_select_db($database_sala, $sala);
	//session_start();
	mysql_select_db($database_sala, $sala);
	$query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
	$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
	$row_tipousuario = mysql_fetch_assoc($tipousuario);
	$totalRows_tipousuario = mysql_num_rows($tipousuario);
if (isset($_GET['codigocreado']))
  {
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
    if ($_SESSION['rol'] == 1 /*&& $varencuesta==true*/)
    {
        if (!isset($_REQUEST['decidir'])){
            if (isset($_REQUEST['IngresoEmpleosi'])){
            
                $query_guardar = "INSERT INTO estudianteelempleo (idestudianteelempleo, idestudiantegeneral, confimacionestudianteelempleo, fechaestudiantelempleo, codigoestado) values (0, '{$row_dataestudiante['idestudiantegeneral']}', 'SI', now(), 100)";
                $guardar = mysql_query($query_guardar, $sala) or die(mysql_error());                    
                echo '<script language="JavaScript">alert("Se ha autorizado el envio de información a elempleo.com")</script>';
            }
            else if (isset($_REQUEST['IngresoEmpleono'])){
                $query_guardar = "INSERT INTO estudianteelempleo (idestudianteelempleo, idestudiantegeneral, confimacionestudianteelempleo, fechaestudiantelempleo, codigoestado) values (0, '{$row_dataestudiante['idestudiantegeneral']}', 'NO', now(), 100)";
                $guardar = mysql_query($query_guardar, $sala) or die(mysql_error());    
                
            }
            
        
            
            $query_elempleo = "SELECT idestudianteelempleo, idestudiantegeneral FROM estudianteelempleo  where idestudiantegeneral = '".$row_dataestudiante['idestudiantegeneral']."'
            and codigoestado like '1%' ";
            $elempleo = mysql_query($query_elempleo, $sala) or die(mysql_error());
            $row_elempleo = mysql_fetch_assoc($elempleo);
            $totalRows_elempleo = mysql_num_rows($elempleo);
            
            if ($totalRows_elempleo == 0){
                    
                $query_egresado = "SELECT e.idestudiantegeneral, e.codigosituacioncarreraestudiante FROM estudiante e, carrera c, modalidadacademica m  
                where 
                e.codigosituacioncarreraestudiante = '104'
                and e.idestudiantegeneral = '".$row_dataestudiante['idestudiantegeneral']."'
                and e.codigocarrera=c.codigocarrera
                and c.codigomodalidadacademica = m.codigomodalidadacademica
                and m.codigomodalidadacademica like '2%'";
                $egresado = mysql_query($query_egresado, $sala) or die(mysql_error());
                $row_egresado = mysql_fetch_assoc($egresado);
                $totalRows_egresado = mysql_num_rows($egresado);
                
                if ($totalRows_egresado != 0) {
                    require_once('../../estudianteelempleo/ingresoalempleo.php');                    
                }
                else {
                    $query_estadoestudiante = "SELECT e.idestudiantegeneral, e.semestre, c.codigocarrera, m.codigomodalidadacademica from estudiante e, planestudio p, planestudioestudiante pe, estudiantegeneral eg, carrera c, modalidadacademica m
                    where 
                    e.idestudiantegeneral=eg.idestudiantegeneral
                    and e.codigoestudiante=pe.codigoestudiante
                    and e.codigocarrera=c.codigocarrera
                    and c.codigomodalidadacademica=m.codigomodalidadacademica
                    and m.codigomodalidadacademica like '2%'
                    and pe.idplanestudio=p.idplanestudio
                    and e.idestudiantegeneral = '".$row_dataestudiante['idestudiantegeneral']."'
                    and e.semestre = p.cantidadsemestresplanestudio
                    and (e.codigosituacioncarreraestudiante like '3%'  or e.codigosituacioncarreraestudiante like '2%')";
                    $estadoestudiante = mysql_query($query_estadoestudiante, $sala) or die(mysql_error());
                    $row_estadoestudiante = mysql_fetch_assoc($estadoestudiante);
                    $totalRows_estadoestudiante = mysql_num_rows($estadoestudiante);
                    
                    if ($totalRows_estadoestudiante != 0) {            
                    require_once('../../estudianteelempleo/ingresoalempleo.php');
                    }                    
                }                
            }
        }    
    }        





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
    $sqlencuesta="select *
    from estadocuenta
    where codigoestado like '1%'";
    //echo "$sqlencuesta";
	$varver= mysql_query($sqlencuesta, $sala) or die("QUERY: $sqlencuesta ".mysql_error());
	$total_varver = mysql_num_rows($varver);

    /*$sqlencuesta="SELECT sid,uid,completed,user FROM sala.enc_completed_surveys e where sid=".$idencuesta." and user=".$idestudiante;
    $varver= mysql_query($sqlencuesta, $sala) or die("QUERY: $sqlencuesta ".mysql_error());
    $total_varver = mysql_num_rows($varver);*/

    if ($total_varver!=0)

 	return  true;

	else
 	return  false;
	}


	//$valencuesta=realizoencuesta($codigoestudiante,$varencuesta,$database_sala,$salatmp);
    $valencuesta=realizoencuesta($idestudiante,$varencuesta,$database_sala,$salatmp);



	/* valida si  presento  la encuesta, si la presento muestra la informacion del alumno sino muestra la encuesta*/
	/*if (ereg("^estudiante",$_SESSION['MM_Username']) && $valencuesta==false && $_SESSION["codigo"]==80428223 )
	 {
	  $_SESSION['varenc']=$varencuesta;
	   $url="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/creacionestudiante/survey.php";
	  	header("Location: $url");

		}
		else{*/

		///****************** && !isset($_POST['codigocreado'])
	if(ereg("^estudiante",$_SESSION['MM_Username']) && !isset($_GET['sinestadocuenta']) && $valencuesta)
    {
    	// Es estudiante Muestre el estado de cuenta
		//echo "Muestra estado";
		$ruta = '../../../';
		$rutaado = $ruta."funciones/adodb/";
		$rutazado = "../../../funciones/zadodb/";
		require_once($ruta.'Connections/salaado.php');

		$link = $ruta."../imagenes/estudiantes/";
		require_once($ruta.'funciones/datosestudiante.php');
        require_once('../../../funciones/sala/estadocuenta/estadocuenta.php');

		$codigoestudiante = $row_dataestudiante['codigoestudiante'];
		//echo "<h1>asdasd $codigoestudiante</h1>";
		//print_r($row_dataestudiante);
        //$db->debug = true;
        $estadocuenta = new estadocuenta($codigoestudiante);
        if($estadocuenta->codigoestudiante == '')
            $estadocuenta->estadocuenta($codigoestudiante);
        //print_r($estadocuenta);
        //exit();
        if(isset($_POST['continuar']))
		{
			if(!isset($_POST['respuesta']))
			{
			?>
		<script language="javascript">
			alert("Debe seleccionar Si o No a la pregunta para poder continuar");
		</script>
		<?php	//exit();
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
					$estadocuenta->guardarEstudianteestadocuenta($_POST['respuesta'], $observacion, $_POST['acumuladocontra'], $_POST['acumuladofavor']);
					//$db->debug = false;
				}
			}
		}

        //$db->debug = true;

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
              <tr>
<?php
$query_usuario = "select u.usuario
from usuario u, estudiantedocumento ed
where ed.numerodocumento = '".$row_dataestudiante['numerodocumento']."'
and ed.numerodocumento = u.numerodocumento
and u.codigotipousuario='600'
limit 1";
//echo "$query_selperiodo<br>";
$selusuario = mysql_query($query_usuario, $sala) or die("$query_usuario");
$totalRows_usuario=mysql_num_rows($selusuario);
$row_usuario = mysql_fetch_assoc($selusuario);
?>
              <td bgcolor="#C5D5D6" class="Estilo2"><div align="center" class="Estilo10"><strong>Usuario</div></td>
        <td class="Estilo1"><div align="center"><?php echo $row_usuario['usuario'];?></div></td>
              <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">&nbsp;</div></td>
              <td class="Estilo1"><div align="center">&nbsp;</div></td>
     </tr>
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
	if ($_SESSION['rol'] == 1 /*&& $varencuesta==true*/)
	   {
          /*  if(validaEncuestaPendiente($row_dataestudiante['idestudiantegeneral'],$row_dataestudiante['codigocarrera'],"20111",$salatmp2)){
                echo "<a href='../../encuesta/encuestaautoevaluacion/encuestainduccion.php?idusuario=".$row_dataestudiante['codigoestudiante']."'>".$row_dataestudiante['nombrecarrera']."</a>";
            }
            else if(!validaevaluaciondocente($sala,$row_dataestudiante['codigoestudiante'],"20102",$row_dataestudiante['codigocarrera'])){
//echo $row_dataestudiante['nombrecarrera'];

echo "<a href='../../eva20061/ffacultad.php?entradadirecta=1&codigoestudiante=".$row_dataestudiante['codigoestudiante'].
                "&codperiodo=".$row_selperiodo['codigoperiodo']."'>".$row_dataestudiante['nombrecarrera']."</a>";

            }
            else{*/


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
            //}
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
<?php
}
//}//requ<ire('../../estadocredito/estadocredito.php');
?>
