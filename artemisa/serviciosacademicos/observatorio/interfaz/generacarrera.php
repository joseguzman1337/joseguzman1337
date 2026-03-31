<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
include('../templates/templateObservatorio.php');

   $db=writeHeaderBD();
   $ban=0;
   $val=$_REQUEST['id'];
   $sin_ind=$_REQUEST['opt'];
   $codigoperiodo=$_REQUEST['Periodo'];
   $ban=$_REQUEST['status'];
   $idfacultad=$_REQUEST['idfacultad'];
   $entity=$_REQUEST['entity'];
   $n='';
   if (!empty($_REQUEST['nom'])) $n=$_REQUEST['nom'];
   if (!empty($val)){
       if (!empty($idfacultad) and $idfacultad!='undefined') $wh=" and codigofacultad='".$idfacultad."' ";
/*        $query_carrera = "SELECT nombrecarrera, codigocarrera 
                               FROM carrera 
                               where codigomodalidadacademica='".$val."'  ".$wh." and codigocarrera not in (1,2) and fechavencimientocarrera >= '2013-01-01 00:00:00'
                                order by 1";*/
                                $query_carrera = "SELECT nombrecarrera, codigocarrera 
                                FROM carrera 
                                where codigomodalidadacademica='".$val."'  ".$wh." AND    nombrecarrera not like '%departamento%' 
AND    nombrecarrera not like '%curso%' 
                                and codigocarrera not in (30, 39, 74, 138, 2, 1, 12, 79, 3, 868, 4)  
                                and fechavencimientocarrera > now() 
ORDER BY nombrecarrera";

//and fechavencimientocarrera >= '2013-01-01 00:00:00' 

   }
    if (!empty($idfacultad) and $idfacultad!='undefined' ){
        if (!empty($val)) $wh=" and codigomodalidadacademica='".$val."'";
        $query_carrera = "SELECT nombrecarrera, codigocarrera 
                               FROM carrera 
                               where codigofacultad='".$idfacultad."' ".$wh." 
                               AND    nombrecarrera not like '%departamento%' 
                                AND    nombrecarrera not like '%curso%' 
                                and codigocarrera not in (30, 39, 74, 138, 2, 1, 12, 79, 3, 868, 4)  
                                and fechavencimientocarrera > now() 
                              ORDER BY nombrecarrera";
   }
     //echo $query_carrera;
    $data_in= $db->Execute($query_carrera);
    if ($ban==1){
        ?>
        <select id="codigocarrera<?php echo $n ?>" name="codigocarrera<?php echo $n ?>" style="width:250px;" onchange="displayMateria()" >
            <option value="">-Selccione-</option>
            <?php
                foreach($data_in as $dt){
                    $nombre=$dt['nombrecarrera'];
                    $idcarrera=$dt['codigocarrera'];
                ?>
                <option value="<?php echo $idcarrera ?>"><?php echo $nombre ?></option>
                <?php
                }
            ?>
        </select> 
     <?php 
        }else if($ban==2) {
               ?>
                <a href="javascript:void(0)" onclick="checkTodos('carr')" id="checkTodos">Todos</a>/<a href="javascript:void(0)" onclick="checkNinguno('carr')" id="checkNinguno">Ninguno</a>

                <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
                    <?php
                       foreach($data_in as $dt){ 
                    ?>
                    <tr>
                        <td><?php echo $nombre=$dt['nombrecarrera'];?></td>
                        <td><input type="checkbox" id="Carrera_1" name="Carrera_1[]" class="carr" value="<?php echo  $dt['codigocarrera'] ?>"   /></td>
                    </tr>
                    <?php
                      }
                    ?>
                </table>
               <?php
        }else if($ban==3) {
                    ?>
        <select id="codigocarrera" name="codigocarrera" style="width:250px;" onchange="displayMateria()" >
            <option value="">-Selccione-</option>
            <?php
                foreach($data_in as $dt){
                    $nombre=$dt['nombrecarrera'];
                    $idcarrera=$dt['codigocarrera'];
                ?>
                <option value="<?php echo $idcarrera ?>"><?php echo $nombre ?></option>
                <?php
                }
            ?>
        </select> 
         <?php   
        }else{
            ?>
                <table border="0" width="100%" class="CSSTableGenerator">
                <tr>
                    <td><center><b>PROGRAMAS</b></center></td>
                    <td><center><b>METAS</b></center></td>
                </tr>
            <?php
           foreach($data_in as $dt){
               $nombre=$dt['nombrecarrera'];
               $cod=$dt['codigocarrera'];
               $sql_met="select * from obs_".$entity." where codigocarrera='".$cod."' and codigoperiodo='".$codigoperiodo."'";
              // echo $sql_met;
               $data_met= $db->Execute($sql_met);
              // print_r($data_met);
                $dataM= $data_met ->GetArray();
                $dataM=$dataM[0];
             //   print_r($dataM);
              //  echo $dataM['meta'];
                $valor1=''; $tip=1; $idme='';
                if(!empty($dataM['meta'])){
                    $valor1=$dataM['meta'];
                    $idme=$dataM['idobs_'.$entity];
                    
                }
               ?>
                <tr>
                    <td>
                        <input type="hidden" name="idobs_<?php echo $entity ?>1[]" id="idobs_<?php echo $entity ?>1_<?php echo $j ?>" value="<?php echo $idme ?>" />
                        <input type="hidden" name="codigocarrera1[]" id="codigocarrera1_<?php echo $j ?>" value="<?php echo $cod ?>" /><?php echo  $nombre; ?></td>
                    <td><input type="text" name="meta1[]" id="meta1_<?php echo $j ?>" class="numeric" title="Meta" maxlength="5" placeholder="Meta" tabindex="1" value="<?php echo $valor1 ?> " /></td>
                </tr>
              <?php
              $j++;
           }
           ?>
            </table>   
           <?php
        }
     ?>