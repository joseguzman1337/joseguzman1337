<?php

    include_once("../variables.php");
    include($rutaTemplate."templateNumericos.php");
    $db = writeHeader("Ver Detalle Indicador",TRUE,$proyectoNumericos); 
    
     include ('../../monitoreo/class/Utils_monitoreo.php'); $C_Utils_monitoreo = new Utils_monitoreo();

     $Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db,$_REQUEST["id"]);


$ver = $_REQUEST["ver"];
//var_dump($ver);

    if($ver == 0){ 
     // echo ("Entre");
    include("./menu.php");
    writeMenu(0);
    } else{
       //  echo ("no Entre");
     // writeMenu(0);
    }

    $data = array();
    $entity = array();
    $user1 = array();
    $user2 = array();
    
    if(isset($_REQUEST["id"])){  
       $utils = new Utils_numericos();
       $data = $utils->getDataEntity("indicador", $id);  
       $indicadorGenerico = $utils->getDataEntity("indicadorGenerico", $data["idIndicadorGenerico"]);  
       $aspecto = $utils->getDataEntity("aspecto", $indicadorGenerico["idAspecto"]); 
       $tipo = $utils->getDataEntity("tipoIndicador", $indicadorGenerico["idTipo"]); 
       $discriminacion = $utils->getDataEntity("discriminacionIndicador", $data["discriminacion"]); 
       $estado = $utils->getDataEntity("estadoIndicador", $data["idEstado"]); 
       if($discriminacion["idsiq_discriminacionIndicador"]==1){
           $entity["label"] = "Tipo";
           $entity["nombre"] = $discriminacion["nombre"];
       } else if($discriminacion["idsiq_discriminacionIndicador"]==2){
           $entity["label"] = $discriminacion["nombre"];
           $facultad = $utils->getDataNonEntity($db,"nombrefacultad","facultad","codigofacultad='".$data["idFacultad"]."'");
           $entity["nombre"] = $facultad["nombrefacultad"];           
       } else if($discriminacion["idsiq_discriminacionIndicador"]==3){
           $entity["label"] = $discriminacion["nombre"];
           $carrera = $utils->getDataNonEntity($db,"nombrecarrera","carrera","codigocarrera='".$data["idCarrera"]."'");
           $entity["nombre"] = $carrera["nombrecarrera"];  
       }       
       $user1 = $utils->getDataEntity("usuario", $data["usuario_creacion"],""); 
       $user2 = $utils->getDataEntity("usuario", $data["usuario_modificacion"],""); 
   }
?>
        
        <div id="contenido">
            <h2>Indicador Numérico Tipo 2</h2>
            <table class="detalle">
                <tr>
                    <th>Indicador:</th>
                    <td colspan="3"><?php echo $indicadorGenerico['nombre']." ". $carrera["nombrecarrera"] ;?></td>
                </tr>
                 <tr>
                    <th>Fecha de vencimiento:</th>
                    <td><?php echo $data['fecha_proximo_vencimiento']; ?></td>
                    <th>Fecha de la última actualización:</th>
                    <td><?php echo $data['fecha_ultima_actualizacion']; ?></td>
                </tr>  
                <tr>
                    <th>Estado de actualización:</th>
                    <td><?php echo $estado['nombre']; ?></td>
                    <th>Estado del registro:</th>
                    <td><?php writeStatus($data['codigoestado']); ?></td>
                </tr>         
            </table>
        </div>

<?php
//var_dump($Permisos[1][0]);
//die();
if ($Permisos[1][0] == 1){
    //var_dump($ver);
    if ($ver == 1){
      include("./detalleFuncionTipo2ver.php");
    }else if ($ver == 0 || $ver == 2){
          include("./detalleFuncionTipo2.php");
      }
}else if($Permisos[1][0] == 2){
   include("./detalleFuncionTipo2ver.php");
}else if($Permisos[1][0] == 3){
  include("./detalleFuncionTipo2ver.php");
}else if($Permisos[1][0] == null){
 echo ("El indicador numérico NO tiene asignado un responsable, ni un tipo de responsabilidad definida.");
}


 writeFooter(); ?>