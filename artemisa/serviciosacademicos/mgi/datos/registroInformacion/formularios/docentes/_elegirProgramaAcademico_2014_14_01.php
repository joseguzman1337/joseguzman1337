<?php
//para que no me lo guarde en cache o no me actualiza cuando el usuario elige otro asi tenga la variable de sesion bien
 header("Cache-Control: no-cache"); 
if(session_id() == '')
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
if(!isset($db) || $db==null){
    $db = getBD();
}

if(isset($_REQUEST["action"])){
    $_SESSION['modalidad'] = $_REQUEST["modalidad"]; 
    $_SESSION['programa'] = $_REQUEST["carrera"];
    $data["success"] = true;
    $data["data"] = $_SESSION;
   echo json_encode($data);
   exit();
} else {
//var_dump($_SESSION);
    function getFormacion1($selected=null){ 
  ?>
        <label for="modalidad" class="fixedLabel">Nivel De Formación: <span class="mandatory">(*)</span></label>
        <select name="modalidad" id="modalidad" class="modalidad" style='font-size:0.8em'>
                <option value="" <?php if($selected=="" || $selected==null) { echo "selected"; } ?> ></option>
                <option value='200' <?php if($selected==200) { echo "selected"; } ?> >Pregrado</option>
                <option value='300' <?php if($selected==300) { echo "selected"; } ?> >Especialización</option>
                <option value='301' <?php if($selected==301) { echo "selected"; } ?> >Maestría</option>
                <option value='302' <?php if($selected==302) { echo "selected"; } ?> >Doctorado</option>
        </select>
    <?php }

    function getProgramas($carreras,$selected=null){ ?>   

        <label for="unidadAcademica" class="fixedLabel">Programa: <span class="mandatory">(*)</span></label>
        <select name="codigocarrera" id="unidadAcademica" class="required unidadAcademica" style='font-size:0.8em;width:auto'>
                <option value="" <?php if($selected=="" || $selected==null) { echo "selected"; } ?> ></option>
                <?php foreach ($carreras as $row) {
                    if($row["codigocarrera"]==$selected){
                        echo '<option value="'.$row["codigocarrera"].'" selected >'.$row["nombrecarrera"].'</option>';
                    } else {
                        echo '<option value="'.$row["codigocarrera"].'" >'.$row["nombrecarrera"].'</option>';}

                    } ?>
        </select>
    <?php }
    if(isset($_SESSION['modalidad']) ) {
        getFormacion($_SESSION['modalidad']);
        $currentdate  = date("Y-m-d H:i:s");
        $query_programa = "SELECT codigocarrera,nombrecarrera FROM carrera WHERE codigomodalidadacademicasic='".$_SESSION['modalidad']."' AND fechavencimientocarrera>'".$currentdate."' ORDER BY nombrecarrera ASC";
        $result =$db->GetAll($query_programa);
        getProgramas($result,$_SESSION['programa']);
    } else if(!isset($_SESSION['programa']) && !isset($_SESSION['modalidad'])){ 
        $currentdate  = date("Y-m-d H:i:s");
        $sql = "SELECT * FROM carrera WHERE codigocarrera=".$_SESSION['codigofacultad']." AND codigomodalidadacademicasic IN (200,300,301,302) AND fechavencimientocarrera>'".$currentdate."' ";
        $row = $db->GetRow($sql);
        if(count($row)==0){ 
            getFormacion1("");
            getProgramas(array(),"");
        ?>
    <?php } else { 
            $query_programa = "SELECT codigocarrera,nombrecarrera FROM carrera WHERE codigomodalidadacademicasic='".$row["codigomodalidadacademicasic"]."' AND fechavencimientocarrera>'".$currentdate."' ORDER BY nombrecarrera ASC";
            $result =$db->GetAll($query_programa);
            getFormacion1($row["codigomodalidadacademicasic"]);
            getProgramas($result,$_SESSION['codigofacultad']);
        ?>
    <?php } }
    
} ?>
