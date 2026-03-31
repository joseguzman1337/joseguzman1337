<?php
// Test CVS
session_start;
	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
	
include '../Excel/reader.php';
include_once(realpath(dirname(__FILE__))."/../variables.php");
include($rutaTemplate."template.php");
?>
<img src="../images/ajax-loader2.gif" style="display:block;clear:both;margin:20px auto;" id="loading"/>
<?php 

$db = getBD();
$utils = Utils::getInstance();
$user=$utils->getUser();
$login=$user["idusuario"];

$data = new Spreadsheet_Excel_Reader();
$respuesta="";

// Set output Encoding.
$data->setOutputEncoding('CP1251');

$data->read($_FILES["file"]["tmp_name"]);

$dateHoy=date('Y-m-d H:i:s');
$todobien = true;
$total = $data->sheets[0]['numRows'];
$fila = 2;
$errores = 0;
$mensajesError = array();
for ($i = 2; $i <= $total; $i++) {
    $docente=array();
    $filaReal = false;
    for ($j = 1; $j <= 12; $j++) {
        //echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
        $docente[$j]=$data->sheets[0]['cells'][$i][$j];
        if($docente[$j]!=""){
            $filaReal = true;
        }
    }
    $nombres=utf8_encode($docente[1]);
    $apellidos=utf8_encode($docente[2]);
    $genero=0;
    if(strcmp($docente[3],'Femenino')==0){
        $genero=100;
    }
    else{
        $genero=200;
    }
    $tipodedocumento=$docente[4];
    $documento=$docente[5];
    $email="";
    if(filter_var($docente[6], FILTER_VALIDATE_EMAIL)){
        $email=$docente[6];
    }
    $ciudadResidencia=utf8_encode($docente[7]);
    $profesion=utf8_encode($docente[8]);
    $especialidad=utf8_encode($docente[9]);
    $direccion=utf8_encode($docente[10]);
    $telefono=$docente[11];
    $celular=$docente[12];

    $idCiudad=0;
    $ciudadSelectSql="select * from ciudad where nombreciudad like '%$ciudadResidencia%' OR nombrecortociudad like '%$ciudadResidencia%';";
    $ciudadSelectRow = $db->GetRow($ciudadSelectSql);
    if(($ciudadSelectRow==null || count($ciudadSelectRow)==0) && $ciudadResidencia!="" && $ciudadResidencia!=NULL){
        $ciudadInsertSql="INSERT into `ciudad` (`nombrecortociudad`, `nombreciudad`, `iddepartamento`, `codigosapciudad`, `codigoestado`) VALUES (''.$ciudadResidencia, ''.$ciudadResidencia, '216', '0', '100');";            
        $db->Execute($ciudadInsertSql);
        $ciudadSelectRow = $db->GetRow($ciudadSelectSql);
    }
    if($ciudadSelectRow!=null && count($ciudadSelectRow)>0){
        $idCiudad=$ciudadSelectRow['idciudad'];
    }
    
    //echo $nombres."-".$apellidos."-".$genero."-".$tipodedocumento."-".$documento."-".$idCiudad;
    //echo "<br/><pre>";print_r($docente);
    if($nombres!=""&&$apellidos!=""&&$genero!=""&&$tipodedocumento!=""&&$documento!=""&&$idCiudad!=0 && $email!="" 
            && $nombres!=NULL && $apellidos!=NULL && $genero!=NULL && $tipodedocumento!=NULL && $documento!=NULL) {
        $docenteSelectSql="select * from docenteEducacionContinuada where numerodocumento='$documento';";
        $docenteSelectRow = $db->GetRow($docenteSelectSql);
        if($docenteSelectRow==null || count($docenteSelectRow)==0){
            $docenteInsertSql="INSERT into `docenteEducacionContinuada` (`apellidodocente`, `nombredocente`, `tipodocumento`, `numerodocumento`, `emaildocente`, `codigogenero`, `direcciondocente`, `idciudadresidencia`, `telefonoresidenciadocente`, `numerocelulardocente`, `profesion`, `especialidad`, `fecha_creacion`, `usuario_creacion`, `codigoestado`, `fecha_modificacion`, `usuario_modificacion`) VALUES ('$apellidos', '$nombres', '$tipodedocumento', '$documento', '$email', '$genero', '$direccion', '$idCiudad', '$telefono', '$celular', '$profesion', '$especialidad','$dateHoy','$login','100','$dateHoy','$login');";            
            $db->Execute($docenteInsertSql); 
        } else {
            $docenteInsertSql="UPDATE `docenteEducacionContinuada` SET `apellidodocente`='$apellidos', `nombredocente`='$nombres',
            `tipodocumento`='$tipodedocumento', `emaildocente`='$email', `codigogenero`='$genero', 
            `direcciondocente`='$direccion', `idciudadresidencia`='$idCiudad', `telefonoresidenciadocente`='$telefono', 
            `numerocelulardocente`='$celular', `profesion`='$profesion', `especialidad`='$especialidad', 
            `codigoestado`=100, `fecha_modificacion`='$dateHoy', `usuario_modificacion`='$login'  
            WHERE numerodocumento='$documento';";            
            $db->Execute($docenteInsertSql); 
        } 
        //var_dump($docenteInsertSql);
    } else if($filaReal&&$email===""){        
		$errores = $errores + 1;     
	   $todobien = false;
	$mensajesError[] = "El correo indicado en la Fila ".$fila." no es válido.";

	} else if($filaReal&&$idCiudad==0){	
		$errores = $errores + 1;     
	   $todobien = false;
		$mensajesError[] = "Ocurrio un error con la ciudad indicada en la fila ".$fila.".";

	}else if($filaReal) {
        $errores = $errores + 1;
        $todobien = false;
	 $mensajesError[] = "Fila ".$fila." No contiene todos los campos obligatorios.";
    } 
    $fila++;
}

if($todobien){
    $respuesta= "exito:Los docentes fueron registrados exitosamente.";
}   else {
    $respuesta= "fail:Ocurrio un error con ".$errores." docente(s) al tratar de realizar el registro.";
	foreach($mensajesError as $error){
		$respuesta.= "<br/>".$error;
	}
}
    

?>

<script language="javascript" type="text/javascript">
    window.location.href="registrarDocentes.php?mensaje=<?php echo $respuesta;?>";
</script>