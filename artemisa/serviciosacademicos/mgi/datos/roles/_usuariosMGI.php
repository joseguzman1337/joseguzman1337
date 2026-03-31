<?php

include("../templates/template.php");
$db = getBD();
$utils = new Utils_Datos();
//var_dump($_REQUEST["rol"]);var_dump($_REQUEST);die;
$usuarios = $utils->getUsuariosRol($db,$_REQUEST["rol"]); 
?>

<ul id="sortableN<?php echo $_REQUEST["rol"]; ?>" class="connectedSortable" style="min-height: 460px;list-style-type: none;margin: 5px 0 0;">  
      <?php
       if (!empty($usuarios)){
               $i=0;
            foreach($usuarios as $dt_sec){
                  // print_r($dt);
                  $nombre=$dt_sec['nombre']." (".$dt_sec['usuario'].")";
                  $id_in=$dt_sec['idusuario'];
                  //$id_in=$dt_sec['usuario'];
                                                    
                  //$id=$dt_sec['codigo'];
                  echo '<li class="ui-state-default idUsuario'.$id_in.' usuario'.$rol["idsiq_rolesMGI"].'" id="'.$id_in.' " style="font-size: 1.2em; margin: 0 0px 0px;padding: 5px;border-bottom:0px;background-color: #EDEDED;">'.$nombre;
                  echo'</li>';
                  $i++;
            }
     }
       ?>
</ul>
