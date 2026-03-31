
<?php 


        include('../templates/templateObservatorio.php');
        $db = writeHeaderBD();


$idestudiantegeneral = $_REQUEST['idestudiantegeneral'];
$idusuario = $_REQUEST['idusuario'];
$NombreRemitente = $_REQUEST['NomRem'];
$FacultadRemitente = $_REQUEST['FacRem'];
$CelularRemitente = $_REQUEST['CelRem'];
$FijoRemitente = $_REQUEST['FijoRem'];
$EmailRemitente = $_REQUEST['EmailRem'];
$MotivoRemision = $_REQUEST['DescripcionRemision'];
$ComportamientoObRemision = $_REQUEST['DescripcionCompObs'];
$IntervencionPaeRemision = $_REQUEST['DescripcionIntervenPae'];
$SolicitudEcRemision = $_REQUEST['DescripcionSolAcademica'];
$PeriodoAcademico = $_REQUEST['periodo'];
$hoy = date("Y-m-d H:i:s");
$TipoRemisionId = $_REQUEST['idRemision']; 
$tipoPeticion = $_REQUEST['tipoEnvio'];
$idCampoAct = $_REQUEST['idActualizar'];

echo $idestudiantegeneral."<br>";
echo $idusuario."<br>";
echo $NombreRemitente."<br>";
echo $FacultadRemitente."<br>";
echo $CelularRemitente."<br>";
echo $FijoRemitente."<br>";
echo $EmailRemitente."<br>";
echo $MotivoRemision."<br>";
echo $ComportamientoObRemision."<br>";
echo $IntervencionPaeRemision."<br>";
echo $SolicitudEcRemision."<br>";
echo $PeriodoAcademico."<br>";
echo $hoy."<br>";
echo $TipoRemisionId."<br>";


if ($tipoPeticion == 'delete')
{
	$RemEstudiante = "DELETE FROM RemisionEstudiante WHERE RemisionEsudianteId = '$idCampoAct'";

	if ($insert = $db->Execute($RemEstudiante) === false) {
    	echo 'Error en el SQL de DELETE';
    	exit;
    }else{
		echo "Actualización exitoso";
		return true;
    }
}
else 
if ($tipoPeticion == 'update') 
{
	$RemEstudiante = "UPDATE RemisionEstudiante SET NombreRemitente = '$NombreRemitente', FacultadRemitente = '$FacultadRemitente', CelularRemitente = '$CelularRemitente', FijoRemitente = '$FijoRemitente', EmailRemitente = '$EmailRemitente', MotivoRemision = '$MotivoRemision', ComportamientoObRemision = '$ComportamientoObRemision', IntervencionPaeRemision = '$IntervencionPaeRemision', SolicitudEcRemision = '$SolicitudEcRemision' 
		WHERE RemisionEsudianteId = '$idCampoAct'";

	if ($insert = $db->Execute($RemEstudiante) === false) {
    	echo 'Error en el SQL de UPDATE';
    	exit;
    }else{
		echo "Actualización exitoso";
		return true;
    }
}
else 
{
	$RemEstudiante = 'INSERT INTO RemisionEstudiante (idestudiantegeneral, idusuario, NombreRemitente, FacultadRemitente, CelularRemitente, FijoRemitente, EmailRemitente, MotivoRemision, ComportamientoObRemision, IntervencionPaeRemision, SolicitudEcRemision, PeriodoAcademico, FechaRegistro, TipoRemisionId)
	VALUES ("'.$idestudiantegeneral.'","'.$idusuario.'","'.$NombreRemitente.'","'.$FacultadRemitente.'","'.$CelularRemitente.'","'.$FijoRemitente.'","'.$EmailRemitente.'","'.$MotivoRemision.'","'.$ComportamientoObRemision.'","'.$IntervencionPaeRemision.'","'.$SolicitudEcRemision.'","'.$PeriodoAcademico.'","'.date("Y-m-d H:i:s").'","'.$TipoRemisionId.'")'; 



    if ($insert = $db->Execute($RemEstudiante) === false) {
    	echo 'Error en el SQL de INSERT';
    	exit;
    }else{
		echo "registro exitoso";
		return true;
    }
}










?>
<!--<SCRIPT>window.location='form_registro_riesgo.php?id=<?php echo $_REQUEST['idR']?>&periodo=<?php echo $PeriodoAcademico?>';</SCRIPT>"; -->







