<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
include('../templates/templateObservatorio.php');

   $db=writeHeaderBD();
   
   $val='';
   if (!empty($_REQUEST['id'])) $val=$_REQUEST['id'];
   $semestre=$_REQUEST['semestre'];
   $identi=$_REQUEST['identificacion'];
   $modalidad=$_REQUEST['modalidad'];
   $codigocarrea=$_REQUEST['codigocarrera'];
   $idobs_grupos=$_REQUEST['sala'];
   
   $wv=''; $wn=''; $wa=''; $wi=''; $wcr='';
   
  
   if(!empty($val)){
       $wv=" and  eg.idestudiantegeneral='".$val."'";
   }
   
   if(!empty($modalidad)){
       $wm=" and  eg.codigomodalidadacademica='".$modalidad."'";
   }
   
   if(!empty($codigocarrea)){
       if ($codigocarrea=='undefined'){
           $wcr=""; 
       }else{
        $wcr=" and  e.codigocarrera='".$codigocarrea."'";
       }
   }
   
   if(!empty($semestre)){
       $wa=" and  eg.semestre like '%".$semestre."%'";
   }
   
   if(!empty($identi)){
       $wi=" and  eg.numerodocumento='".$identi."'";
   }
   
   $query_estudiante = "SELECT eg.idestudiantegeneral, nombresestudiantegeneral, apellidosestudiantegeneral, numerodocumento
                    FROM `estudiantegeneral` as eg
                    INNER JOIN estudiante as e on (eg.idestudiantegeneral=e.idestudiantegeneral)
                    where 1
                    ".$wv."
                    ".$wn."
                    ".$wa."
                    ".$wi." 
                    ".$wcr." ";
   //echo $query_estudiante;
   $data_in= $db->Execute($query_estudiante);
   $F_data1 = $data_in->GetArray();
   $F_total1=count($F_data1);
   
      if ($F_total1>0){
         ?>
                               Estudiantes<br>
                               <div class="sel" >
                                    <select name="origen[]" id="origen" multiple="multiple" size="8" class="selec">
                                        <?php
                                           foreach($F_data1 as $dt){
                                               ?>
                                                <option value="<?php echo $dt['idestudiantegeneral'] ?>"><?php echo $dt['numerodocumento'].'-'.$dt['nombresestudiantegeneral'].' '.$dt['apellidosestudiantegeneral'] ?></option>
                                               <?php
                                           }
                                        ?>
                                    </select>
                                </div>
                                  <div class="sel1">
                                        <input type="button" class="pasar izq" style="margin:25px 1px 0x 1px;border:1px solid #ccc;padding:10px;" value="Pasar &gt;&gt;"><input type="button" style="margin:25px 1px 0 1px;border:1px solid #ccc;padding:10px;" class="quitar der" value="&lt;&lt; Quitar"><br />
                                        <input type="button" class="pasartodos izq" style="margin:25px 1px 0 1px;border:1px solid #ccc;padding:10px;" value="Todos &gt;&gt;"><input type="button" style="margin:25px 1px 0 1px;border:1px solid #ccc;padding:10px;" class="quitartodos der" value="&lt;&lt; Todos">
                                  </div>
                                  <div class="sel" >
                                        <?php
                                            if(!empty($idobs_grupos)){
                                                $sql_gr="SELECT r.id_estudiantes_grupos_riesgo, eg.idestudiantegeneral, nombresestudiantegeneral, 
                                                        apellidosestudiantegeneral, numerodocumento, idobs_grupos
                                                        FROM obs_estudiantes_grupos_riesgo as r
                                                        INNER JOIN estudiantegeneral as eg ON (r.idestudiantegeneral=eg.idestudiantegeneral)
                                                        WHERE r.idobs_grupos='".$idobs_grupos."' and r.codigoestado=100 ";
                                                $data_gr= $db->Execute($sql_gr);
                                                $G_data1 = $data_gr->GetArray();
                                                $G_total1=count($G_data1);
                                                
                                            }
                                        ?>
                                        <select name="destino[]" id="destino" multiple="multiple" size="8" class="selec" >
                                            <?php
                                             if ($G_total1>0){
                                                 $j=0;
                                                 foreach($G_data1 as $dtg){
                                                    ?>
                                                     <option selected='selected' value="<?php echo $dtg['id_estudiantes_grupos_riesgo'].'-'.$dtg['idestudiantegeneral'] ?>"><?php echo $dtg['numerodocumento'].'-'.$dtg['nombresestudiantegeneral'].' '.$dtg['apellidosestudiantegeneral'] ?></option>
                                                    <?php
                                                    $j++;
                                                }
                                             }
                                            ?>
                                        </select>
                                  </div>

<?php
      }
?>
<script type="text/javascript">
         $(document).ready(function(){
                $('.pasar').click(function() { return !$('#origen option:selected').remove().appendTo('#destino'); });
                $('.quitar').click(function() { return !$('#destino option:selected').remove().appendTo('#origen'); });
                $('.pasartodos').click(function() { $('#origen option').each(function() { $(this).remove().appendTo('#destino'); }); });
                $('.quitartodos').click(function() { $('#destino option').each(function() { $(this).remove().appendTo('#origen'); }); });
                $('.submit').click(function() { $('#destino option').prop('selected', 'selected'); });
            });
</script>