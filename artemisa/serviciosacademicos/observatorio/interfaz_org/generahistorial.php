<?php
include('../templates/templateObservatorio.php');

$db=writeHeader('Observatorio',true,'');
$tabla=$_REQUEST['entity'];
$codigoestudiante=$_REQUEST['codigoestudiante'];
$direc=$_REQUEST['direc'];
$tipoT=$_REQUEST['tipoT'];
//echo $tipoT.'-->>';
?>
<script type="text/javascript">
        $(document).ready(function () {
            $('#buttons').akordeon();
            
            
        });
</script>
<?php
$sql_per="SELECT DISTINCT codigoperiodo from obs_".$tabla." where codigoestudiante='".$codigoestudiante."' ";
$data_in= $db->Execute($sql_per);
$E_data = $data_in->GetArray();
$cat=count($E_data);
$status=$_REQUEST['status'];
$tipo=$_REQUEST['tipo'];
     
$wh='';
if ($tabla=='remision_psicologica' and empty($tipo)){
    $camp=" calificacion ";
}else if ($tabla=='remision_financiera' and empty($tipo)){
    $camp=" descripcionremision_financiera ";
}else if ($tabla=='tutorias' and empty($tipo) and empty($tipoT)){
    $wh=' and idobs_tipotutoria=1 ';
    if (empty($direc)){
      $camp=" n_tutoria, objetivotutoria, estrategiatutoria, compromisoestudiantetutoria, compromisodocentetutoria, logrostutoria, objetivospropuestotutoria, recomendaciontutoria ";
    }else{
      $camp=" n_tutoria";
    }
}else if ($tabla=='tutorias' and empty($tipo) and !empty($tipoT)){
    $wh=' and idobs_tipotutoria=2 ';
     $camp=" n_tutoria, logrostutoria, objetivotutoria";
}

if ($tabla=='remision_psicologica' and $tipo=='estu'){
    $camp="fecha_creacion ";
}else if ($tabla=='remision_financiera' and $tipo=='estu'){
    $camp="fecha_creacion ";
}else if ($tabla=='tutorias' and $tipo=='estu' and empty($tipoT)){
      $camp=" n_tutoria, objetivotutoria, estrategiatutoria, compromisoestudiantetutoria, compromisodocentetutoria, logrostutoria, objetivospropuestotutoria, recomendaciontutoria ";
   
}else if ($tabla=='tutorias' and $tipo=='estu' and !empty($tipoT)){
      $camp="  n_tutoria, logrostutoria, objetivotutoria ";
}
//echo $camp.'<br>';
if ($cat>0){
    ?>
    <div id="demo-wrapper">
        <div class="akordeon" id="buttons">
    <?php
    foreach($data_in as $dt){
        $codigoperiodo=$dt['codigoperiodo'];
    ?>
        <div class="akordeon-item expanded">
            <div class="akordeon-item-head">
                    <div class="akordeon-item-head-container">
                        <div class="akordeon-heading">
                            <?php echo $codigoperiodo.' '.ucwords($tabla) ?>
                        </div>
                    </div>
             </div>
            <div class="akordeon-item-body">
                <div class="akordeon-item-content">
                    <?php
                    if (empty($tipoT)){
                    $sql_per1="SELECT r.idobs_registro_riesgo, ".$camp.", rp.idobs_".$tabla.",
                          nombredocente, apellidodocente,
                          d.numerodocumento as numerodocumentodocente, pi.idobs_primera_instancia, 
                          f.nombrecausas as causas, t.nombretipocausas, t.nombretipocausas, 
                          rp.fechacreacion, rp.usuariocreacion, u.nombres, u.apellidos, u.numerodocumento, tr.nombretiporiesgo
                          FROM obs_".$tabla." as rp 
                          INNER JOIN obs_primera_instancia as pi ON (rp.idobs_registro_riesgo=pi.idobs_registro_riesgo and pi.codigoestado=100) 
                          INNER JOIN obs_registro_riesgo as r on (r.idobs_registro_riesgo=pi.idobs_registro_riesgo and r.codigoestado=100) 
                          INNER JOIN obs_registro_riesgo_causas as ro on (r.idobs_registro_riesgo=ro.idobs_registro_riesgo)
                          INNER JOIN obs_tiporiesgo AS tr on (r.idobs_tiporiesgo=tr.idobs_tiporiesgo) 
                          INNER JOIN usuario as u on (u.idusuario=r.usuariocreacion)
                          LEFT JOIN docente as d on (d.numerodocumento=u.numerodocumento) 
                          LEFT JOIN obs_causas as f on (f.idobs_causas=ro.idobs_causas and f.codigoestado=100) 
                          LEFT JOIN obs_tipocausas as t on (f.idobs_tipocausas=t.idobs_tipocausas) 
                          WHERE rp.codigoestudiante='".$codigoestudiante."' and rp.codigoperiodo='".$codigoperiodo."'  ".$wh."
                          group by rp.idobs_".$tabla." ";
                    }else{
                         $sql_per1="SELECT ".$camp.", rp.idobs_".$tabla.",
                          g.nombregrupos, nombredocente, apellidodocente, 
                            d.numerodocumento as numerodocumentodocente,  rp.fechacreacion, rp.usuariocreacion, 
                            u.nombres, u.apellidos, u.numerodocumento, eg.idestudiantegeneral, 
                            eg.id_estudiantes_grupos_riesgo
                          FROM obs_".$tabla." as rp 
                          INNER JOIN usuario as u on (u.idusuario=rp.usuariocreacion) 
                          INNER JOIN obs_grupos as g on (rp.idobs_grupos=g.idobs_grupos)
                          INNER JOIN obs_estudiantes_grupos_riesgo AS eg on (g.idobs_grupos=eg.idobs_grupos)
                          LEFT JOIN docente as d on (d.numerodocumento=u.numerodocumento) 
                          WHERE rp.codigoestudiante='".$codigoestudiante."' and rp.codigoperiodo='".$codigoperiodo."' ".$wh."
                          group by rp.idobs_".$tabla." ";
                    }
                    //echo $sql_per1; 
                        $data_in1= $db->Execute($sql_per1);
                        if (empty($tipoT)){
                        ?>
                            <table border="0" class="CSSTableGenerator">
                                <tr>
                                    <td>Docente </td>
                                    <td>Nivel</td>
                                    <td>Fecha de la Cita</td>
                                    <td>Quien lo Atendio</td>
                                    <?php
                                    if (!empty($direc)){

                                    ?>
                                   <td><?php echo $camp ?></td>
                                    <td>+ Mas Info</td>
                                    <?php
                                    }else{
                                        $cols = explode(",", $camp);
                                        foreach($cols as $c){
                                            $c=trim($c);
                                            if(!empty($c)){
                                            ?>
                                            <td><?php echo $c ?></td>
                                           <?php
                                            }
                                        }
                                    }
                                    ?>

                                </tr>
                            <?php

                            foreach($data_in1 as $dt1){
                                if (!empty($dt1['nombredocente'])){
                                 $docente=$dt1['numerodocumentodocente'].' '.$dt1['nombredocente'].' '.$dt1['apellidodocente'];
                                }else{
                                 $docente="No fue remitido por un docente";   
                                }
                                $niv=$dt1['nombretiporiesgo'];
                                $fec=$dt1['fechacreacion'];
                                $usu=$dt1['nombres'].' '.$dt1['apellidos'];
                                $id_res=$dt1['idobs_registro_riesgo'];
                               
                                $id=$dt1["idobs_".$tabla];
                                $camp=trim($camp);
                                //$dc=$dt1[1]['$camp'];
                                //$camp = substr($camp, 0, -1);
                               // print_r($camp);
                               // echo $camp.'-->'.$dc;
                                ?>
                                <tr>
                                    <td><?php echo $docente ?></td>
                                    <td><?php echo $niv ?></td>
                                    <td><?php echo $fec ?></td>
                                    <td><?php echo $usu ?></td>

                                    <?php
                                     if (!empty($direc)){
                                    ?>
                                    <td><?php
                                    if ($tabla=='tutorias' and empty($tipo)){
                                         echo $dt1[1]['$camp'];
                                    }else{

                                        echo $dt1[$camp];
                                    }
                                    ?>
                                    </td>
                                   <td><a href="<?php echo $direc.'?id=row_'.$id.'&id_res='.$id_res ?>">+ Mas Info</a></td>
                               
                                    <?php
                                         }else{
                                        $cols2 = explode(",", $camp);
                                        foreach($cols2 as $c1){
                                           $c1=trim($c1);
                                           if(!empty($c1)){
                                            ?>
                                             <td><?php echo $dt1[trim($c1)] ?></td>
                                           <?php
                                           }
                                        }
                                     }
                                     ?>
                                </tr>
                                <?php
                            }
                            ?>
                             </table>  
                        <?php }else{ ?>
                                <table border="0" class="CSSTableGenerator">
                                <tr>
                                    <td>Docente </td>
                                    <td>Fecha de la Cita</td>
                                    <?php
                                        $cols = explode(",", $camp);
                                        foreach($cols as $c){
                                            $c=trim($c);
                                            if(!empty($c)){
                                            ?>
                                            <td><?php echo $c ?></td>
                                           <?php
                                            }
                                        }
                                    ?>
                                     <td>+ Mas Info</td>
                                </tr>
                            <?php

                            foreach($data_in1 as $dt1){
                                $fec=$dt1['fechacreacion'];
                                $usu=$dt1['nombres'].' '.$dt1['apellidos'];
                                 $id_res=$dt1['id_estudiantes_grupos_riesgo'];
                                $id=$dt1["idobs_".$tabla];
                                $camp=trim($camp);
                                //$dc=$dt1[1]['$camp'];
                                //$camp = substr($camp, 0, -1);
                               // print_r($camp);
                               // echo $camp.'-->'.$dc;
                                ?>
                                <tr>
                                    <td><?php echo $usu ?></td>
                                    <td><?php echo $fec ?></td>
                                    <?php
                                        $cols2 = explode(",", $camp);
                                        foreach($cols2 as $c1){
                                           $c1=trim($c1);
                                           if(!empty($c1)){
                                            ?>
                                             <td><?php echo $dt1[trim($c1)] ?></td>
                                           <?php
                                           }
                                        }
                                     ?>
                                   
                                    <td><a href="<?php echo $direc.'?id=row_'.$id.'&id_grupos='.$id_res ?>">+ Mas Info</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                             </table>  
                        <?php } ?>
                </div>
            </div>
        </div>
<?php
    }
 ?>
       </div>
     </div>
<?php
}else{
     echo "No tiene registros en ".$tabla;   
    }
?>