<?php
//para que no me lo guarde en cache o no me actualiza cuando el usuario elige otro asi tenga la variable de sesion bien
 header("Cache-Control: no-cache"); 
 
if(session_id() == '' )
 {
      // session has NOT been started
      session_start();
 }
 else
 {
      // session has been started
     //var_dump($_SESSION);
 }
$ruta = "../";
while (!is_file($ruta.'templates/template.php'))
{
    $ruta = $ruta."../";
}
require_once($ruta."templates/template.php");
if((is_file('./functionsProgramasModalidad.php'))){
    include_once("./functionsProgramasModalidad.php");
} else if((is_file('./formularios/academicos/functionsProgramasModalidad.php'))){
    include_once("./formularios/academicos/functionsProgramasModalidad.php");
}
if(!isset($db) || $db==null){
    $db = getBD();
} else {
    $ruta = "../";
    while (!is_file($ruta.'datos/class/Utils_datos.php'))
    {
            $ruta = $ruta."../";
    }
    require_once ($ruta.'datos/class/Utils_datos.php');
}
$utils = new Utils_Datos();
$permisos = $utils->getDataPermisos($db);
if(isset($_REQUEST["action"])){
    $_SESSION['modalidad'] = $_REQUEST["modalidad"]; 
    $_SESSION['programa'] = $_REQUEST["carrera"];
    $data["success"] = true;
    $data["data"] = $_SESSION;
   echo json_encode($data);
   exit();
} else {
    
    $disable="";
    if($permisos["formulario"]!==NULL && $permisos["rol"][0]!=1) { $disable = 'disabled="disabled"'; } 
    
    if(!isset($_SESSION["programa"]) || !isset($_SESSION['modalidad']) || ($disable!=="" && $_SESSION["programa"]!=$_SESSION['codigofacultad'])){
        $_SESSION['programa'] = $_SESSION['codigofacultad'];
        $carrera = $utils->getDataEntity("carrera", $_SESSION['programa'],"","codigocarrera");
        $_SESSION['modalidad'] = $carrera["codigomodalidadacademicasic"]; 
//var_dump($_SESSION);
    }
    
    //TOCO CLAVARLE EL OR codigocarrera IN (6) PARA INCLUIR AL DPTO DE HUMANIDADES
    if(isset($_SESSION['modalidad'])) {
        getFormacion($_SESSION['modalidad'],$disable);
        $currentdate  = date("Y-m-d H:i:s");
        $query_programa = "SELECT codigocarrera,nombrecarrera FROM carrera WHERE codigomodalidadacademicasic='".$_SESSION['modalidad']."' 
					AND (fechavencimientocarrera>'".$currentdate."' OR codigocarrera IN ('6','7','417','781','782')) ORDER BY nombrecarrera ASC";
					//echo $query_programa;
        $result =$db->GetAll($query_programa);
        getProgramas($result,$_SESSION['programa'],$disable);
    } else if(!isset($_SESSION['programa']) && !isset($_SESSION['modalidad'])){ 
        $currentdate  = date("Y-m-d H:i:s");
        $sql = "SELECT * FROM carrera WHERE codigocarrera=".$_SESSION['codigofacultad']." AND codigomodalidadacademicasic IN (200,300,301,302) 
		AND (fechavencimientocarrera>'".$currentdate."' OR codigocarrera IN ('6','7','417','781','782'))";
        $row = $db->GetRow($sql);
        if(count($row)==0){ 
            getFormacion("");
            getProgramas(array(),"");
        ?>
    <?php } else { 
            $query_programa = "SELECT codigocarrera,nombrecarrera FROM carrera WHERE codigomodalidadacademicasic='".$row["codigomodalidadacademicasic"]."' 
			AND (fechavencimientocarrera>'".$currentdate."' OR codigocarrera IN ('6','7','417','781','782')) ORDER BY nombrecarrera ASC";
            $result =$db->GetAll($query_programa);
            getFormacion($row["codigomodalidadacademicasic"],$disable);
            getProgramas($result,$_SESSION['codigofacultad'],$disable);
        ?>
    <?php } }
    
} ?>

