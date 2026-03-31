<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
//require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
//error_reporting(2047);
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script language="javascript">
function reCarga(pagina){
	document.location.href=pagina;
}
</script>

<?php

ini_set('memory_limit', '64M');
ini_set('max_execution_time','90');
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../funciones/clases/motor/motor.php');
require_once('../../../../funciones/clases/debug/SADebug.php');
require_once('funciones/ObtenerDatos.php');

$fechahoy=date("Y-m-d H:i:s");
$_SESSION['get']=$_GET;
/*echo "_SESSION<pre>";
print_r($_SESSION);
echo "</pre>";*/

$debug=false;
if($_GET['depurar']=='si')
{
	$debug=true;
	$sala->debug=true;
}
?>
<form name="admitir" method="get" action="">
<input type="hidden" value="<?php echo $_GET['codigocarrera']?>" name="codigocarrera">
<input type="hidden" value="<?php echo $_GET['codigoperiodo']?>" name="codigoperiodo">
<input type="hidden" value="<?php echo $_GET['link_origen']?>" name="link_origen">
<p align="left" class="Estilo3">MENU PARAMETRIZACION ADMISIONES</p>
  <table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
  	<tr>
  		<td>Cantidad de aspirantes a admitir</td>
  		<td><input type="text" name="cantidad" value="<?php echo $_GET['cantidad']?>">&nbsp;<input type="submit" name="Enviar" value="Enviar"></td>
		

  	</tr>
<tr>
  		<td>Plan estudios</td>
  		<td>

<?php

	$query_planestudios = "SELECT * FROM planestudio where codigocarrera = '".$_SESSION['admisiones_codigocarrera']."'
    and codigoestadoplanestudio like '1%'";
	$planestudios = $sala->execute($query_planestudios);
	
	$totalRows_planestudios = $planestudios->RecordCount();
    //echo $query_prematriculaviva;
	//print_r($row_planestudios);
	if($totalRows_planestudios > 0)
		{
			$row_planestudios = $planestudios->fetchRow();
?>
<select name="planestudio" id="planestudio">


            <?php


			do
			{
			//if($row_planestudios['idplanestudio'] != $row_dataestudianteplan['idplanestudio'])
				//{
?>
            <option value="<?php echo $row_planestudios['idplanestudio'];?>"<?php if(!(strcmp($row_planestudios['idplanestudio'],$row_dataestudianteplan['idplanestudio']))) {echo "SELECTED";} ?>><?php echo $row_planestudios['nombreplanestudio']?></option>
 <?php
				//}
    			}
			while ($row_planestudios = $planestudios->fetchRow());
			//$totalRows_planestudios = mysql_num_rows($planestudios);
			?>
          </select>

 <?php  }?>

</td>
		

  	</tr>
  </table>
<?php
$codigocarrera=$_GET['codigocarrera'];
$codigoperiodo=$_GET['codigoperiodo'];
$link_origen=$_GET['link_origen'];

$admisiones_consulta=new TablasAdmisiones($sala,$debug);
$array_subperiodo=$admisiones_consulta->LeerCarreraPeriodoSubperiodosRecibePeriodo($codigocarrera,$codigoperiodo);
$idsubperiodo=$array_subperiodo['idsubperiodo'];
$idadmision=$admisiones_consulta->LeerIdadmision($codigocarrera,$idsubperiodo);
$array_parametrizacion_admisiones=$admisiones_consulta->LeerParametrizacionPruebasAdmision($idadmision);

$matriz=ordenamiento($_SESSION['array_listado_asignacion_pruebas'],'PUNTAJE_TOTAL',"DESC");
/*echo "matriz<pre>";
print_r($matriz);
echo "</pre>";*/
$tabla = new matriz($matriz,"Listado resultados de las pruebas $codigoperiodo","listado_admitir.php",'si','si','menuadministracionresultados.php',"calcula_listado_resultados.php",true,'no');
$tabla->mostrar();
?>
</form>

<?php
if(isset($_GET['Enviar']))
{

	$sala->debug=true;
	if(isset($_GET['cantidad']) and $_GET['cantidad']<>"")
	{
		for ($i=0; $i < $_GET['cantidad'];$i++)
		{
			if($matriz[$i]['nombreestadoestudianteadmision']=="ADMITIDO"){

				$queryActualizaSituacionCarreraEstudiante="
				UPDATE estudiante SET codigosituacioncarreraestudiante='300'
				WHERE
				codigoestudiante = '".$matriz[$i]['codigoestudiante']."'
				";
	
				$queryIdEstudianteGeneral="SELECT eg.idestudiantegeneral FROM estudiantegeneral eg, estudiante e
				WHERE
				e.codigoestudiante = '".$matriz[$i]['codigoestudiante']."'
				AND e.idestudiantegeneral=eg.idestudiantegeneral
				";
				$op=$sala->execute($queryIdEstudianteGeneral);
				$idestudiantegeneral=$op->fields['idestudiantegeneral'];
	
				$queryIdInscripcion="SELECT i.idinscripcion FROM inscripcion i
				inner join estudiantecarrerainscripcion eci on i.idinscripcion=eci.idinscripcion
				AND eci.codigocarrera='$codigocarrera'
				AND eci.idestudiantegeneral='$idestudiantegeneral'
				AND i.codigoperiodo='$codigoperiodo'";				
				$opI=$sala->execute($queryIdInscripcion);
				$idinscripcion=$opI->fields['idinscripcion'];
	
				$queryActualizaInscripcion="UPDATE inscripcion i SET codigosituacioncarreraestudiante='300' WHERE i.idinscripcion = '".$matriz[$i]['idinscripcion']."'";
				$admitir=$sala->query($QueryActualizaEstado);
				$opAI=$sala->execute($queryActualizaInscripcion);
				$admitirSCE=$sala->query($queryActualizaSituacionCarreraEstudiante);
	
				//idplanestudios=20
				echo "<h1>IDINSCRIPCION=".$matriz[$i]['idinscripcion']."</h1>";
				echo $queryInsertaPlanEstudios="
				insert into planestudioestudiante
				(`idplanestudio`, `codigoestudiante`, `fechaasignacionplanestudioestudiante`, 
				`fechainicioplanestudioestudiante`, 
				`fechavencimientoplanestudioestudiante`, 
				`codigoestadoplanestudioestudiante`
				)
				values
				('".$_GET["planestudio"]."', '".$matriz[$i]['codigoestudiante']."', '$fechahoy', 
				'$fechahoy', 
				'2999-12-31', 
				'100'
				)
				";
				$pe=$sala->execute($queryInsertaPlanEstudios);
			}
			else
			{

	
				$queryActualizaSituacionCarreraEstudiante="
				UPDATE estudiante SET codigosituacioncarreraestudiante='113'
				WHERE
				codigoestudiante = '".$matriz[$i]['codigoestudiante']."'
				";
	
				$queryIdEstudianteGeneral="SELECT eg.idestudiantegeneral FROM estudiantegeneral eg, estudiante e
				WHERE
				e.codigoestudiante = '".$matriz[$i]['codigoestudiante']."'
				AND e.idestudiantegeneral=eg.idestudiantegeneral
				";
				$op=$sala->execute($queryIdEstudianteGeneral);
				$idestudiantegeneral=$op->fields['idestudiantegeneral'];
	
				$queryIdInscripcion="SELECT i.idinscripcion FROM inscripcion i
				inner join estudiantecarrerainscripcion eci on i.idinscripcion=eci.idinscripcion
				AND eci.codigocarrera='$codigocarrera'
				AND eci.idestudiantegeneral='$idestudiantegeneral'
				AND i.codigoperiodo='$codigoperiodo'";				
				$opI=$sala->execute($queryIdInscripcion);
				$idinscripcion=$opI->fields['idinscripcion'];
	
				$queryActualizaInscripcion="UPDATE inscripcion i SET codigosituacioncarreraestudiante='113' WHERE i.idinscripcion = '".$matriz[$i]['idinscripcion']."'";
				$admitir=$sala->query($QueryActualizaEstado);
				$opAI=$sala->execute($queryActualizaInscripcion);
				$admitirSCE=$sala->query($queryActualizaSituacionCarreraEstudiante);
	

			}

		}

		echo '<script language="javascript">alert("Estudiantes Admitidos Correctamente")</script>';
		/*echo '<meta http-equiv="REFRESH" content="30;URL=calcula_listado_resultados.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'&link_origen=menu.php"/>';*/
	}
	else
	{
		echo '<script language="javascript">alert("Debe digitar una cantidad de estudiantes a admitir")</script>';
	}
}

function ordenamiento($matriz,$columna,$orden="ASC")
{
	foreach($matriz as $llave => $fila)
	{
		$arreglo_interno[$llave] = $fila[$columna];
	}
	if($orden=="ASC" or $orden=="asc")
	{
		array_multisort($arreglo_interno, SORT_ASC, $matriz);
	}
	elseif($orden=="DESC" or $orden=="desc")
	{
		array_multisort($arreglo_interno, SORT_DESC, $matriz);
	}
	return $matriz;
}
?>