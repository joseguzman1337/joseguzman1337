<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

class Observatorio{
    
    public function bus_tiporiesgo($db,$tipo=false){
        $sql="SELECT * FROM obs_tipocausas WHERE codigoestado=100 ";
       $data_in= $db->Execute($sql);
       ?>
       <a href="javascript:void(0)" onclick="checkTodos('ries_1')">Todos</a>/<a href="javascript:void(0)" onclick="checkNinguno('ries_1')">Ninguno</a>
       <div style="overflow-x: hidden; overflow-y: scroll; width: 100%; height: 110px;">
          <table width="50%" border="0"  class="CSSTableGenerator">
       <?php
       foreach($data_in as $dt){
           ?>
              <tr>
                    <td><?php echo $dt['nombretipocausas'];?></td>
                    <td><input type="checkbox" class="ries_1" id="idobs_tipocausas" name="idobs_tipocausas[]"  value="<?php echo  $dt['idobs_tipocausas'] ?>"   /></td>
            </tr>
           <?php
       }
       ?>
          </table>
       </div>
       <?php
    }
    public function bus_salas($db,$tipo=false){
        ?>
        <table border="0" class="CSSTableGenerator">
         <?php
            $wh="";
            if ($tipo!=false){
                $wh=" and idobs_grupos='".$tipo."' ";
            }
            $query_tipo="SELECT * FROM obs_grupos where codigoestado=100 ".$wh." ";
            //echo $query_tipo;
            $reg_tipo =$db->Execute($query_tipo);
            $i=0;
            ?>
            <tr>
                <td><label class="titulo_label"><b>Salas de Aprendizaje</b></label>
                        <br>
                        <a href="javascript:void(0)" onclick="checkTodos('grupo_<?php echo $dt['idobs_grupos'] ?>')">Todos</a>/<a href="javascript:void(0)" onclick="checkNinguno('grupo_<?php echo $dt['idobs_grupos'] ?>')">Ninguno</a>
                </td> 
                <td>
                  <div style="overflow-x: hidden; overflow-y: scroll; width: 100%; height: 100px;">
                      <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
            <?php
            foreach($reg_tipo as $dt){ 
                ?>
                    <tr>
                            <td><?php echo $dt['nombregrupos'];?></td>
                            <td><input type="checkbox" class="grupo_<?php echo $dt['idobs_grupos'] ?>" id="idobs_grupos_1" name="idobs_grupos_1[]"  value="<?php echo  $dt['idobs_grupos'] ?>"   /></td>
                    </tr>
            <?php
            }
            ?>
                    </table>
                </div>
            </td>
            </tr>
        </table>
       <?php
       
    }
    
    
    public function bus_ries($db,$tipo=false){
        ?>
        <table border="0" class="CSSTableGenerator">
         <?php
            $wh="";
            if ($tipo!=false){
                $wh=" and idobs_tipocausas='".$tipo."' ";
            }
            
            $query_tipo="SELECT * FROM obs_tipocausas WHERE codigoestado=100 ".$wh." ";
            //echo $query_tipo;
            $reg_tipo =$db->Execute($query_tipo);
            $i=0;
            foreach($reg_tipo as $dt){ $md=$i%2;?>
                      
                <?php if ($md==0){ ?><tr> <?php } ?>
                    <td><label class="titulo_label"><b><?php echo $dt['nombretipocausas']; ?></b></label>
                            <br>
                            <a href="javascript:void(0)" onclick="checkTodos('ries_<?php echo $dt['idobs_tipocausas'] ?>')">Todos</a>/<a href="javascript:void(0)" onclick="checkNinguno('ries_<?php echo $dt['idobs_tipocausas'] ?>')">Ninguno</a>
                    </td>
                    <td>
                        <div style="overflow-x: hidden; overflow-y: scroll; width: 100%; height: 100px;">
                            <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
                        <?php
                        $sql_cau="SELECT * FROM obs_causas WHERE idobs_tipocausas='".$dt['idobs_tipocausas']."' ";
                        $reg_cau =$db->Execute($sql_cau);
                        foreach($reg_cau as $ca){
                            ?>
                            <tr>
                                    <td><?php echo $ca['nombrecausas'];?></td>
                                    <td><input type="checkbox" class="ries_<?php echo $dt['idobs_tipocausas'] ?>" id="idobs_causas_1" name="idobs_causas_1[]"  value="<?php echo  $ca['idobs_causas'] ?>"   /></td>
                            </tr>
                            <?php
                        }
                        ?>
                            </table>
                        </div>
                    </td>
                 <?php if ($md==1){ ?></tr><?php } ?>
                <?php
                $i++;
            }
         ?>
        </table> 
        <?php
    }
    
    public function registro_riesgo($db, $idresgitro_riesgo){
        ?>
         <!--<table border="0" class="CSSTableGenerator">
         <?php

            $query_tipo="SELECT * FROM obs_tipocausas WHERE codigoestado=100 ";
            //echo $query_tipo;
            $reg_tipo =$db->Execute($query_tipo);
            $i=0;
            foreach($reg_tipo as $dt){ $md=$i%2;?>
                      
                <?php if ($md==0){ ?><tr> <?php } ?>
                    <td><label class="titulo_label"><b><?php echo $dt['nombretipocausas']; ?></b></label></td>
                    <td>
                        <div style="overflow-x: hidden; overflow-y: scroll; width: 100%; height: 100px;">
                            <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
                        <?php
                        $sql_cau="SELECT * FROM obs_registro_riesgo_causas as rr INNER JOIN obs_causas as c on (c.idobs_causas=rr.idobs_causas) 
                                 WHERE c.idobs_tipocausas='".$dt['idobs_tipocausas']."' and idobs_registro_riesgo='".$idresgitro_riesgo."' ";
                        $reg_cau =$db->Execute($sql_cau);
                        foreach($reg_cau as $ca){
                            ?>
                            <tr>
                                    <td><?php echo $ca['nombrecausas'];?></td>
                            </tr>
                            <?php
                        }
                        ?>
                            </table>
                        </div>
                    </td>
                 <?php if ($md==1){ ?></tr><?php } ?>
                <?php
                $i++;
            }
         ?>
        </table> -->
       <?php
       $sql_res="SELECT * FROM obs_registro_riesgo AS rr INNER JOIN obs_tiporiesgo as t on (rr.idobs_tiporiesgo=t.idobs_tiporiesgo) WHERE rr.idobs_registro_riesgo='".$idresgitro_riesgo."' ";
       // echo $sql_res;
        $reg_res =$db->Execute($sql_res);
        $data= $reg_res->GetArray();
        $data=$data[0];
        ?>
        <table border="0" class="CSSTableGenerator">
                   <tr>
                       <td width="145px"><label class="titulo_label"><b>Nivel:</b></label></td>
                       <td><?php echo $data['nombretiporiesgo']; ?></td>
                   </tr>
                    <tr>
                        <td><label class="titulo_label"><b>Descripci&oacute;n:</b></label></td>
                        <td><?php echo $data['observacionesregistro_riesgo']; ?></td>
                  </tr>
                  <tr>
                       <td><label class="titulo_label"><b>Intervenci&oacute;n Primera Instancia:</b></label></td>
                       <td><?php echo $data['intervencionregistro_riesgo']; ?></td>
                  </tr>
          </table>
        <?php
        
    }


    public function riesgos($db,$tipo=FALSE, $idriesgos=false, $idtab=null, $idR=null){
        ?>
        <table border="0" class="CSSTableGenerator">
         <?php
            $wh="";
            if ($tipo!=false){
                $wh=" and idobs_tipocausas='".$tipo."' ";
            }
            
            $query_tipo="SELECT * FROM obs_tipocausas WHERE codigoestado=100 ".$wh." ";
            //echo $query_tipo;
            $reg_tipo =$db->Execute($query_tipo);
            $i=0; $j=0;
            foreach($reg_tipo as $dt){ $md=$i%2;?>
                      
                <?php if ($md==0){ ?><tr> <?php } ?>
                    <td><label class="titulo_label"><b><?php echo $dt['nombretipocausas']; ?></b></label>
                            <br>
                            <a href="javascript:void(0)" onclick="checkTodos('ries_<?php echo $dt['idobs_tipocausas'] ?>')">Todos</a>/<a href="javascript:void(0)" onclick="checkNinguno('ries_<?php echo $dt['idobs_tipocausas'] ?>')">Ninguno</a>
                    </td>
                    <td>
                        <div style="overflow-x: hidden; overflow-y: scroll; width: 100%; height: 100px;">
                            <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
                        <?php
                        
                        $sql_cau="SELECT * FROM obs_causas WHERE idobs_tipocausas='".$dt['idobs_tipocausas']."' ";
                        $reg_cau =$db->Execute($sql_cau);
    
                        $z=0;
                        foreach($reg_cau as $ca){
                           $che="";
                            ?>
                            <tr>
                                    <td><?php echo $ca['nombrecausas'];
                                        $sql_tab="SELECT * FROM obs_registro_riesgo_causas WHERE idobs_causas='".$ca['idobs_causas']."' and idobs_registro_riesgo='".$idR."' ";
                                        $reg_tab=$db->Execute($sql_tab);
                                        $F_data= $reg_tab->GetArray();
                                        $idReg='';
                                        if (count($F_data)>0 ){
                                            $idReg=$F_data[0]['idobs_registro_riesgo_causas'];
                                            if($F_data[0]['codigoestado']==100 ){
                                                $che="checked";
                                            }
                                        }
                                      
                                        //echo $sql_tab;
                                        if(!empty($idtab)){ ?> <input type="hidden" name="<?php echo $idtab ?>[]" id="<?php echo $idtab ?>" value="<?php echo $idReg ?>"> <?php } ?>
                                            
                                    </td>
                                    <td><input type="checkbox" class="ries_<?php echo $dt['idobs_tipocausas'] ?>" <?php echo $che?> id="idobs_causas_<?php echo $j?>" name="idobs_causas[]"  value="<?php echo  $ca['idobs_causas'] ?>"   /></td>
                            </tr>
                            <?php
                            $j++; $z++;
                        }
                        ?>
                            </table>
                        </div>
                    </td>
                 <?php if ($md==1){ ?></tr><?php } ?>
                <?php
                $i++;
            }
         ?>
        </table> 
       <input type="hidden" name="nriesgos" id="nriesgo" value="<?php echo $j ?>" />
        <?php
    }
   public function primera_ins($db,$idpri=null,$riesgos=null){
                            $query_tipo="SELECT p.idobs_primera_instancia, pi.idobs_causas, c.nombrecausas, 
                            pi.idobs_herramientas_deteccion,  pi.idobs_tiporiesgo, t.nombretiporiesgo, 
                            p.aspectosprimera_instancia, r.idobs_herramientas_deteccion, h.nombre as herramientas
                            FROM obs_primera_instancia as p
                            inner join obs_primera_instancia_causas as pi on (p.idobs_primera_instancia=pi.idobs_primera_instancia and pi.codigoestado=100)
                            INNER JOIN obs_registro_riesgo as r on (p.idobs_registro_riesgo=r.idobs_registro_riesgo)
                            INNER JOIN obs_herramientas_deteccion as h on (h.idobs_herramientas_deteccion=r.idobs_herramientas_deteccion)
                            INNER JOIN obs_causas as c on (pi.idobs_causas=c.idobs_causas)
                            INNER JOIN obs_tiporiesgo as t on (pi.idobs_tiporiesgo=t.idobs_tiporiesgo)
                            WHERE p.codigoestado=100 and p.idobs_primera_instancia='".$idpri."' ";
                           // echo $query_tipo; 
                            $reg_tipo =$db->Execute($query_tipo);
                            $i=0;
                            ?>
                            <table border="0" class="CSSTableGenerator">
                                           <tr>
                                              <td width="250px"><center><label class="titulo_label"><b>TIPO DE NECESIDAD</b></label></td>
                                              <td ><center><label class="titulo_label"><b>HERRAMIENTAS DE DETECCI&Oacute;N</b></label></td>
                                              <td ><center><label class="titulo_label"><b>NIVEL DE RIESGO</b></label></td>
                                          </tr>
                            <?php foreach($reg_tipo as $dt){
                                $aspec=$dt['aspectosprimera_instancia'];
                                ?>
                                    <tr>
                                          <td width="250px"><?php echo $dt['nombrecausas'] ?></td>
                                          <td ><?php echo $dt['herramientas'] ?></td>
                                          <td ><?php echo $dt['nombretiporiesgo'] ?></td>
                                      </tr>      
                            <?php } ?>
                            <tr>
                                <td ><label class="titulo_label"><b>Aspectos esp&eacute;cificos Identificados</b></label></td>
                                <td colspan="2"><?php echo $aspec; ?></td>
                            </tr>
                        </table>
       <?php
   }
   
    public function remision($db,$id_estu=NULL, $id_res=NULL, $per=null){
        $sql="SELECT * FROM obs_tiporemision WHERE codigoestado=100 " ;
        $reg_tipo =$db->Execute($sql);
        ?>
        <table class="CSSTableGenerator">
        <?php
        foreach($reg_tipo as $dt1){
            ?>
                <td><center><b><?php echo $dt1['nombretiporemision'] ?></b></center></td>
            <?php
        } 
        ?>
          </tr>
          <tr>
          <?php
        foreach($reg_tipo as $dt1){
            if($id_estu!=null and $id_res!=null){
                $sql2="SELECT * FROM obs_remision WHERE codigoestudiante='".$id_estu."' and idobs_registro_riesgo='".$id_res."' and idobs_tiporemision='".$dt1['idobs_tiporemision']."' ";
                $reg_tipo2=$db->Execute($sql2);
                $T_data=$reg_tipo2->GetArray();
                $vidR=''; $che=""; $dis="";
                if(count($T_data)>0){
                    $vidR=$T_data[0]['idobs_remision'];
                    if ($T_data[0]['codigoestado']==100){
                        $che="checked";
                    }
                    if($per=='V'){
                        $dis="DISABLED";
                    }
                }
            }
            ?>
                <td><div class="roundedOne">
                     <input type="hidden" name="idobs_remision[]" id="idobs_remision" value="<?php echo $vidR ?>" />
                     <input type="checkbox" value="<?php echo $dt1['idobs_tiporemision'] ?>" <?php echo $che ?> class="roundedOne" <?php echo $dis ?> id="remision_<?php echo $dt1['idobs_tiporemision'] ?>" <?php echo $chef ?> name="remision[]"  />
                     <label for="remision_<?php echo $dt1['idobs_tiporemision'] ?>"></label>
                    </div></td>
            <?php
        } 
        ?>
          </tr>
       </table>
        <?php
    }
    public function riesgos2($db,$tipo=FALSE, $idriesgos=false,$con,$Th=NULL){
        $wh="";
        if ($tipo!=false){
            $wh=" and idobs_tipocausas='".$tipo."' ";
        }

        $query_tipo="SELECT * FROM obs_causas WHERE codigoestado=100  ".$wh." and idobs_causas in (".$idriesgos.") ";
        //echo $query_tipo;
        $reg_tipo =$db->Execute($query_tipo);
        $T_data= $reg_tipo ->GetArray();
        $cD=count($T_data);
        if ($cD>0){
        ?>
        <!--<div style="overflow-x: hidden; overflow-y: scroll; width: 100%; height: 80px;">-->
        <table border="0" class="CSSTableGenerator">
           <tr>
              <td rowspan="2" width="250px"><center><label class="titulo_label"><b>TIPO DE NECESIDAD</b></label></td>
              <td rowspan="2"><center><label class="titulo_label"><b>HERRAMIENTAS DE DETECCI&Oacute;N</b></label></td>
              <td colspan="4"><center><label class="titulo_label"><b>NIVEL DE RIESGO</b></label></td>
          </tr>
          <tr>
                      <?php
                        $sql_tipo1="SELECT * FROM obs_tiporiesgo where codigoestado='100' ";
                        $reg_tipo1 =$db->Execute($sql_tipo1);
                        $i=0;
                        foreach($reg_tipo1 as $dt1){
                            ?>
                                <td><center><label class="titulo_label"><b><?php echo $dt1['nombretiporiesgo'] ?></b></label></center></td>
                            <?php
                            $i++;
                        }
                      ?>
           </tr>
         <?php
            $i=0; $j=0;
            if (empty($Th)) $the=2; if ($Th=='Adm') $the=1; if ($Th=='Acc') $the=3;
            if ($Th=='4') $the=4;
            foreach($reg_tipo as $dt){ 
                 ?>  
                    <tr>
                            <td><?php echo $dt['nombrecausas'];?>
                                <input type="hidden" name="idobs_primera_instancia_causas[]" id="obs_primera_instancia_causas" value="" />
                                <input type="hidden" name="idobs_causas[]" id="idobs_causas" value="<?php echo $dt['idobs_causas'];?>" />
                            </td>
                            <td>
                            <input type="hidden" id="idobs_herramientas_deteccion" name="idobs_herramientas_deteccion[]" value="<?php echo $the?>" />
                            <?php
                                    $query_dec = "SELECT nombre, idobs_herramientas_deteccion FROM obs_herramientas_deteccion where codigoestado='100' and idobs_herramientas_deteccion='".$the."' ";
                                   // echo $query_dec;
                                    $reg_dec =$db->Execute($query_dec);
                                    $F_data= $reg_dec->GetArray();
                                    echo '<b>'.$F_data[0]['nombre'].'</b>';
                            ?>
                            </td>
                             <?php
                                $sql_tipo1="SELECT * FROM obs_tiporiesgo where codigoestado='100' ";
                                $reg_tipo1 =$db->Execute($sql_tipo1);
                                  foreach($reg_tipo1 as $dt1){
                                    ?>
                                        <td><center><input type="radio" id="idobs_tiporiesgo_<?php echo $dt['idobs_causas'];?>" name="idobs_tiporiesgo_<?php echo $dt['idobs_causas'];?>[]" value="<?php echo $dt1['idobs_tiporiesgo'] ?>"></center></td>
                                    <?php
                                 }
                              ?>
                    </tr>
                    <?php
                    
                    $j++; $z++;
                }
         ?>
        </table> 
       <!-- </div> -->
        <?php
        return $j;
        }
    }

    
    public function bus_doc($db){
        ?>
        <table border="0" class="CSSTableGenerator" width="100%">
             <tr>
                <td><label class="titulo_label"><b>Numero Documuento Docente:</b></label></td>
                <td><input type="text" name="docente" id="docente" /></td>
            </tr>
        </table>
        <?php
    }
    public function registro_academico($db, $matriz_completa){
        ?>
            <table width="909" border="0" class="CSSTableGenerator">
                <?php
                   $i=0; $dat='';
                   foreach($matriz_completa as $in=>$dt){
                       if($i>4){
                           if($in=='detallenota1') $in='Pierde Mas del 50%';
                           if($in=='detallenota2') $in='Promedio Ponderado Acumulado Menor a 3.3';
                           if($in=='detallenota3') $in='Esta en Prueba Academica';
                           if($in=='nombremateria') $in='Pierde Asignatura Otra vez';
                           if($in=='detallenota4') $in='Materias Perdidas';
                           if($in=='riesgo' && $dt==1) $dt='Alto';
                           if($in=='riesgo' && $dt==2) $dt='Medio';
                           if($in=='riesgo' && $dt==3) $dt='Bajo';
                       ?>
                        <tr>
                            <td><?php echo $in ?>:</td>
                            <td><?php echo $dt ?></td>
                        </tr>
                       <?php
                       $dat.=$in.':'.$dt.',';
                       }
                       $i++;
                   }
                ?>
            </table>
            <input type="hidden" name="matriz" id="matriz" value="<?php echo $dat ?>" />
       <?php
        
    }
    public function registro_prueba($db, $id_estu){
        ?>
            <table width="909" border="0" class="CSSTableGenerator">
                <tr>
                <td><b><center>Pregunta</center></b></td>
                <td><b><center>Opciones</center></b></td>
                <td><b><center>Nivel</center></b></td>
                <td><b><center>Descripci&oacute;n</center></b></td>
              </tr>
              <?php
              $sql="SELECT c1.nombre as  nombreP, c.nombre, nombretiporiesgo, descripcion
                    FROM obs_admitidos_entrevista_conte as a
                    INNER JOIN obs_admitidos_contexto as c1 on (a.idobs_admitidos_contextoP=c1.idobs_admitidos_contexto)
                    INNER JOIN obs_admitidos_contexto as c on (a.idobs_admitidos_contexto=c.idobs_admitidos_contexto)
                    INNER JOIN obs_tiporiesgo as t on (a.idobs_tiporiesgo=t.idobs_tiporiesgo)
                    inner join estudiante as e on (a.codigoestudiante=e.codigoestudiante) 
                    where e.idestudiantegeneral='".$id_estu."'";
              
              // echo $sql;
              $data_in= $db->Execute($sql);
              foreach($data_in as $dt){
                 ?>
                  <tr>
                      <td><?php echo $dt['nombreP'] ?></td>
                      <td><?php echo $dt['nombre'] ?></td>
                      <td><?php echo $dt['nombretiporiesgo'] ?></td>
                      <td><?php echo $dt['descripcion'] ?></td>
                  </tr>
                 <?php
              }
              ?>
            </table>
        <?php
    }
    
    public function estudiantesimple($db,$id=false,$tip=NULL){
            if ($id==false){
        ?>
                <table width="909" border="0" class="CSSTableGenerator">
                        <tbody>
                           <tr>
                               <input type="hidden" name="nombre" id="nombre" />
                               <input type="hidden" name="apellido" id="apellido" />
                                <td><label class="titulo_label"><b>Modalidas Academica:</b></label></td>
                                <td><?php
                                                $query_programa = "SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                                $reg_programa =$db->Execute($query_programa);
                                                echo $reg_programa->GetMenu2('codigomodalidadacademica','',true,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                         ?>
                                </td>
                                <td><label class="titulo_label"><b>Programa:</b></label></td>
                                <td colspan="3"><div  id="carreraAjax" style="display: none;"></div></td>
                                
                           </tr>
                                                      <tr>
                                <td width="305">
                                    <label class="titulo_label"><b>N&uacute;mero de Identifiaci&oacute;n Estudiante:</b>
                                </label></td>
                                <td width="153"><input type="texto" name="numero" id="numero" /></td>
                                <td>&nbsp;</td>
                                <td><button type="button" id="buscar_estu" onclick="buscarestu(0)"><img src="../img/lupa.png" height="25" width="25"  /></button></td>
                           </tr>
                           <tr>
                               <td colspan="4">
                                   <div id="EstudianteAjax" style=" height:auto;">
                            
                                   </div>
                                   <div id="EstudianteAjax2" style="display: none">
                            
                                   </div>
                               </td>
                           </tr>
                          </tbody>
                    </table>
        <?php
            }else{
              
               $query_carrera = "SELECT * 
                    FROM `estudiantegeneral` as eg
                    inner join estudiante as e on (eg.idestudiantegeneral=e.idestudiantegeneral)
                    inner join carrera as c on (e.codigocarrera=c.codigocarrera)
                    inner join facultad as f on (c.codigofacultad=f.codigofacultad)
                    where eg.idestudiantegeneral='".$id."' ";
             //echo $query_carrera;
             $data_in= $db->Execute($query_carrera);
            ?>
              <legend>Datos del Estudiante</legend>
            <?php
                 foreach($data_in as $dt){
            ?>
                <input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?php echo $codigo=$dt['idestudiantegeneral'] ?>" />
                    <table border="0" width="100%" class="CSSTableGenerator">
                          <tbody>  
                          <?php
			    if ($i==0){
						  ?>
                          
                            <tr>
                                <td><label class="titulo_label"><b>Nombre:</b></label></td>
                                <td><?php echo $nombre=$dt['nombresestudiantegeneral'].' '.$dt['apellidosestudiantegeneral']; ?></td>
                                <td><label class="titulo_label"><b>N&uacute;mero de Identificaci&oacute;n:</b></td>
                                <td><?php echo $iden=$dt['numerodocumento']; ?></td>
                               
                            </tr>
                            <tr>
                              <td><label class="titulo_label"><b>Edad:</b></td>
                              <td><?php
                                //fecha actual
                                        $dia=date('j');
                                        $mes=date('n');
                                        $ano=date('Y');
                                        
                                        //fecha de nacimiento
                                        $fec_naci1=explode(' ', $dt['fechanacimientoestudiantegeneral']); 
                                        $fec_naci=explode('-',$fec_naci1[0]);
                                        $dianaz=$fec_naci[2];
                                        $mesnaz=$fec_naci[1];
                                        $anonaz=$fec_naci[0];

                                        //si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
                                         if (($mesnaz == $mes) && ($dianaz > $dia)) {
                                        $ano=($ano-1); }

                                        //si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
                                        if ($mesnaz > $mes) {
                                        $ano=($ano-1);}

                                        //ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
                                        $edad=($ano-$anonaz);
                                        
                                        echo $edad;
                                    ?>
                              </td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>                              
                              
                            </tr>
                            <tr>
                              <td><label class="titulo_label"><b>Celular:</b></td>
                              <td><?php echo $celular=$dt['celularestudiantegeneral']; ?></td>
                              <td><label class="titulo_label"><b>Fijo:</b></td>
                              <td><?php echo $fijo=$dt['telefonoresidenciaestudiantegeneral']; ?></td>
                              
                            </tr>
                            <tr>
                              <td><label class="titulo_label"><b>E-mail Institucional:</b></td>
                              <td><?php echo $email1=$dt['emailestudiantegeneral']; ?></td>
                              <td><label class="titulo_label"><b>E-mail Personal:</b></td>
                              <td><?php echo $email2=$dt['email2estudiantegeneral']; ?></td>
                              
                            </tr>
                        </tbody>
                       </table>
                
                       		
                            <?PHP  } 
							$i++;
	                 }
					 ?>
				<br><b>DATOS DE LA(S) CARRERA(S)</b><br>
                <p>
                    <table border="0" width="100%" class="CSSTableGenerator">
                     <tbody>  
                     <?php
					 $cat=$i;
					// echo $cat.'-->';
					 $i=0;
		 foreach($data_in as $dt){?>
                            <tr>
                                <td><label class="titulo_label"><b>Facultad:</b></label></td>
                                <td><?php echo $facultad=$dt['nombrefacultad']; ?></td>
                                <td><label class="titulo_label"><b>Carrera:</b></td>
                                <td><?php echo $carrera=$dt['nombrecarrera']; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><label class="titulo_label"><b>Semestre:</b></td>
                                <td><?php echo $semestre=$dt['semestre']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                	<?php if ($cat>1) {?>   <hr style="color: #88ab0c"> <?php } ?>
                                </td>
                            </tr>
                          <?php
						 $i++;
						}
						?>
                        </tbody>
                    </table>
               <?php 
                }
            }
    
    public function estudiante($db,$id=false,$tip=NULL){
            if ($id==false){
        ?>
                <table width="909" border="0" class="CSSTableGenerator">
                        <tbody>
                           <tr>
                                <td width="305">
                                    <label class="titulo_label"><b>N&uacute;mero de Identifiaci&oacute;n Estudiante:</b>
                                </label></td>
                                <td width="153"><input type="texto" name="numero" id="numero" /></td>
                                <td>&nbsp;</td>
                                <td><button type="button" id="buscar_estu" onclick="buscarestu(0)"><img src="../img/lupa.png" height="25" width="25"  /></button></td>
                           </tr>
                           <tr>
                                <td><label class="titulo_label"><b>Nombre del Estudiante:</b></label></td>
                                <td><input type="texto" name="nombre" id="nombre" /></td>
                                <td><label class="titulo_label"><b>Apellido Estudiante:</b></label></td>
                                <td><input type="texto" name="apellido" id="apellido" /></td>
                           </tr>
                           <tr>
                                <td><label class="titulo_label"><b>Modalidas Academica:</b></label></td>
                                <td><?php
                                                $query_programa = "SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                                $reg_programa =$db->Execute($query_programa);
                                                echo $reg_programa->GetMenu2('codigomodalidadacademica','',true,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                         ?>
                                </td>
                                <td><label class="titulo_label"><b>Programa:</b></label></td>
                                <td colspan="3"><div  id="carreraAjax" style="display: none;"></div></td>
                                
                           </tr>
                           <tr>
                               <td colspan="4">
                                   <div id="EstudianteAjax" style=" height:auto;">
                            
                                   </div>
                                   <div id="EstudianteAjax2" style="display: none">
                            
                                   </div>
                               </td>
                           </tr>
                          </tbody>
                    </table>
        <?php
            }else{
              
               $query_carrera = "SELECT * 
                    FROM `estudiantegeneral` as eg
                    inner join estudiante as e on (eg.idestudiantegeneral=e.idestudiantegeneral)
                    inner join carrera as c on (e.codigocarrera=c.codigocarrera)
                    inner join facultad as f on (c.codigofacultad=f.codigofacultad)
                    where eg.idestudiantegeneral='".$id."' ";
             //echo $query_carrera;
             $data_in= $db->Execute($query_carrera);
            ?>
              <legend>Datos del Estudiante</legend>
            <?php
                 foreach($data_in as $dt){
            ?>
                <input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?php echo $codigo=$dt['idestudiantegeneral'] ?>" />
                    <table border="0" width="100%" class="CSSTableGenerator">
                          <tbody>  
                          <?php
			    if ($i==0){
						  ?>
                          
                            <tr>
                                <td><label class="titulo_label"><b>Nombre:</b></label></td>
                                <td><?php echo $nombre=$dt['nombresestudiantegeneral'].' '.$dt['apellidosestudiantegeneral']; ?></td>
                                <td><label class="titulo_label"><b>N&uacute;mero de Identificaci&oacute;n:</b></td>
                                <td><?php echo $iden=$dt['numerodocumento']; ?></td>
                               
                            </tr>
                            <tr>
                              <td><label class="titulo_label"><b>Edad:</b></td>
                              <td><?php
                                //fecha actual
                                        $dia=date('j');
                                        $mes=date('n');
                                        $ano=date('Y');
                                        
                                        //fecha de nacimiento
                                        $fec_naci1=explode(' ', $dt['fechanacimientoestudiantegeneral']); 
                                        $fec_naci=explode('-',$fec_naci1[0]);
                                        $dianaz=$fec_naci[2];
                                        $mesnaz=$fec_naci[1];
                                        $anonaz=$fec_naci[0];

                                        //si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
                                         if (($mesnaz == $mes) && ($dianaz > $dia)) {
                                        $ano=($ano-1); }

                                        //si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
                                        if ($mesnaz > $mes) {
                                        $ano=($ano-1);}

                                        //ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
                                        $edad=($ano-$anonaz);
                                        
                                        echo $edad;
                                    ?>
                              </td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>                              
                              
                            </tr>
                            <tr>
                              <td><label class="titulo_label"><b>Celular:</b></td>
                              <td><?php echo $celular=$dt['celularestudiantegeneral']; ?></td>
                              <td><label class="titulo_label"><b>Fijo:</b></td>
                              <td><?php echo $fijo=$dt['telefonoresidenciaestudiantegeneral']; ?></td>
                              
                            </tr>
                            <tr>
                              <td><label class="titulo_label"><b>E-mail Institucional:</b></td>
                              <td><?php echo $email1=$dt['emailestudiantegeneral']; ?></td>
                              <td><label class="titulo_label"><b>E-mail Personal:</b></td>
                              <td><?php echo $email2=$dt['email2estudiantegeneral']; ?></td>
                              
                            </tr>
                        </tbody>
                       </table>
                
                       		
                            <?PHP  } 
							$i++;
	                 }
					 ?>
				<br><b>DATOS DE LA(S) CARRERA(S)</b><br>
                <p>
                    <table border="0" width="100%" class="CSSTableGenerator">
                     <tbody>  
                     <?php
					 $cat=$i;
					// echo $cat.'-->';
					 $i=0;
		 foreach($data_in as $dt){?>
                            <tr>
                                <td><label class="titulo_label"><b>Facultad:</b></label></td>
                                <td><?php echo $facultad=$dt['nombrefacultad']; ?></td>
                                <td><label class="titulo_label"><b>Carrera:</b></td>
                                <td><?php echo $carrera=$dt['nombrecarrera']; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><label class="titulo_label"><b>Semestre:</b></td>
                                <td><?php echo $semestre=$dt['semestre']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                	<?php if ($cat>1) {?>   <hr style="color: #88ab0c"> <?php } ?>
                                </td>
                            </tr>
                          <?php
						 $i++;
						}
						?>
                        </tbody>
                    </table>
               <?php 
                }
            }

            public function busc_docente($db,$id=false){
            if ($id==false){
        ?>
                <table width="909" border="0" class="CSSTableGenerator">
                        <tbody>
                           <tr>
                                <td width="305">
                                    <label class="titulo_label"><b>N&uacute;mero de Identifiaci&oacute;n del docente:</b>
                                </label></td>
                                <td width="153"><input type="texto" name="numeroD" id="numeroD" /></td>
                                <td>&nbsp;</td>
                                <td><button type="button" id="buscar_estu" onclick="buscardoc(0)"><img src="../img/lupa.png" height="25" width="25"  /></button></td>
                           </tr>
                           <tr>
                                <td><label class="titulo_label"><b>Nombre del Docente:</b></label></td>
                                <td><input type="texto" name="nombreD" id="nombreD" /></td>
                                <td><label class="titulo_label"><b>Apellido Docente:</b></label></td>
                                <td><input type="texto" name="apellidoD" id="apellidoD" /></td>
                           </tr>
                           <tr>
                                <td><label class="titulo_label"><b>Modalidas Academica:</b></label></td>
                                <td><?php
                                                $query_programa = "SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                                $reg_programa =$db->Execute($query_programa);
                                                echo $reg_programa->GetMenu2('codigomodalidadacademica1','',true,false,1,' id=codigomodalidadacademica1  style="width:150px;"');
                                         ?>
                                </td>
                                <td><label class="titulo_label"><b>Programa:</b></label></td>
                                <td colspan="3"><div  id="carrera1Ajax" style="display: none;"></div></td>
                                
                           </tr>
                           <tr>
                               <td colspan="4">
                                   <div id="DocenteAjax" style=" height: 100px">
                            
                                   </div>
                                   <div id="DocenteAjax2" style="display: none">
                            
                                   </div>
                               </td>
                           </tr>
                          </tbody>
                    </table>
        <?php
            }else{
              
               $query_carrera = "select d.numerodocumento, nombredocente, apellidodocente, d.iddocente,
                                f.nombrefacultad, c.nombrecarrera
                     from docente as d
                     inner join grupo as g on (g.numerodocumento=d.numerodocumento and codigogrupo<>0) 
                     INNER JOIN materia as m on (g.codigomateria=m.codigomateria)
                     INNER JOIN carrera as c on (m.codigocarrera=c.codigocarrera) 
                     INNER JOIN facultad as f  ON (f.codigofacultad=c.codigofacultad)
                     where d.codigoestado=100 and d.numerodocumento<>'' and d.iddocente='".$id."' group by d.iddocente ";
            // echo $query_carrera;
             $data_in= $db->Execute($query_carrera);
            ?>
              <legend>Datos del Docente</legend>
            <?php
                 foreach($data_in as $dt){
            ?>
                <input type="hidden" name="iddocente" id="iddocente" value="<?php echo $codigo=$dt['iddocente'] ?>" />
                    <table border="0" width="100%" class="CSSTableGenerator">
                          <tbody>                       
                            <tr>
                                <td><label class="titulo_label"><b>Nombre:</b></label></td>
                                <td><?php echo $nombre=$dt['nombredocente'].' '.$dt['apellidodocente']; ?></td>
                                <td><label class="titulo_label"><b>N&uacute;mero de Identificaci&oacute;n:</b></td>
                                <td><?php echo $iden=$dt['numerodocumento']; ?></td>
                            </tr>
                            <tr>
                              <td><label class="titulo_label"><b>Facultad:</b></td>
                              <td><?php echo $celular=$dt['nombrefacultad']; ?></td>
                              <td><label class="titulo_label"><b>Carrera:</b></td>
                              <td><?php echo $fijo=$dt['nombrecarrera']; ?></td>
                              
                            </tr>
                        </tbody>
                       </table>
                <?php
	                 } 
                }
            }

            
        public function saber11($db, $id=false){
            $sql='SELECT a.nombreasignaturaestado, numeroregistroresultadopruebaestado,
                        puestoresultadopruebaestado, notadetalleresultadopruebaestado 
                FROM resultadopruebaestado as r
                INNER JOIN detalleresultadopruebaestado as ed on (r.idresultadopruebaestado=ed.idresultadopruebaestado)
                INNER JOIN asignaturaestado a ON (a.idasignaturaestado = ed.idasignaturaestado)
                INNER JOIN estudiantegeneral as e on (r.idestudiantegeneral=e.idestudiantegeneral)
                INNER JOIN estudiante as es on (e.idestudiantegeneral=es.idestudiantegeneral)
                WHERE codigoestudiante="'.$id.'" order by nombreasignaturaestado';
            //echo $sql;
            $data_in= $db->Execute($sql);
            $F_data= $data_in->GetArray();
            
            ?>
                <table border="1">
                        <tr>
                            <td><b><center>SUBPRUEBAS</center></b></td>
                            <td><b><center>PUNTAJE</center></b></td>
                            <td><b><center>FACULTAD</center></b></td>
                        </tr>
                        <tr>
                            <td>Lenguaje</td>
                            <td><center><input type="text" id="lenguaje" name="lenguaje" value="<?php echo $F_data[6]['notadetalleresultadopruebaestado'] ?>" style="width:50px" onblur="suma()" /></center></td>
                            <td><center><input type="checkbox" id="lenguajef" name="lenguajef" onclick="promedio()"></center></td>
                        </tr>
                        <tr>
                            <td>Matem&aacute;ticas</td>
                            <td><center><input type="text" id="matematicas" name="matematicas" value="<?php echo $F_data[7]['notadetalleresultadopruebaestado'] ?>" style="width:50px" onblur="suma()" /></center></td>
                            <td><center><input type="checkbox" id="matematicasf" name="matematicasf" onclick="promedio()"></center></td>
                        </tr>
                        <tr>
                            <td>Ciencias sociales</td>
                            <td><center><input type="text" id="sociales" name="sociales" value="<?php echo $F_data[3]['notadetalleresultadopruebaestado'] ?>" style="width:50px" onblur="suma()" /></center></td>
                            <td><center><input type="checkbox" id="socialesf" name="socialesf" onclick="promedio()"></center></td>
                        </tr>
                        <tr>
                            <td>Biolog&iacute;a</td>
                            <td><center><input type="text" id="biologia" name="biologia" value="<?php echo $F_data[0]['notadetalleresultadopruebaestado'] ?>" style="width:50px" onblur="suma()" /></center></td>
                            <td><center><input type="checkbox" id="biologiaf" name="biologiaf" onclick="promedio()"></center></td>
                        </tr>
                        <tr>
                            <td>Filosof&iacute;a</td>
                            <td><center><input type="text" id="filosofia" name="filosofia" value="<?php echo $F_data[1]['notadetalleresultadopruebaestado'] ?>" style="width:50px" onblur="suma()" /></center></td>
                            <td><center><input type="checkbox" id="filosofiaf" name="filosofiaf" onclick="promedio()"></center></td>
                        </tr>
                        <tr>
                            <td>Qu&iacute;mica</td>
                            <td><center><input type="text" id="quimica" name="quimica" value="<?php echo $F_data[8]['notadetalleresultadopruebaestado'] ?>" style="width:50px" onblur="suma()" /></center></td>
                            <td><center><input type="checkbox" id="quimicaf" name="quimicaf" onclick="promedio()"></center></td>
                        </tr>
                        <tr>
                            <td>F&iacute;sica</td>
                            <td><center><input type="text" id="fisica" name="fisica" value="<?php echo $F_data[2]['notadetalleresultadopruebaestado'] ?>" style="width:50px" onblur="suma()" /></center></td>
                            <td><center><input type="checkbox"  id="fisicaf" name="fisicaf" name="fisicaf" onclick="promedio()"></center></td>
                        </tr>
                        <tr>
                            <td>Puesto<input type="text" id="puesto" name="puesto" value="<?php echo $F_data[0]['puestoresultadopruebaestado'] ?>" style="width:50px" />/1000</td>
                            <td>Ponderado Total<input type="text" id="ponderado" name="ponderado" value="" style="width:50px" readonly />/1000</td>
                            <td>Ponderado Fac.<input type="text" id="puntajef" name="puntajef" value="" style="width:50px" readonly /></td>
                        </tr>
                    </table>   
                    <br>
                    <table border="1">
                        <tr>
                            <td><b><center>Idioma</center></b></td>
                            <td><b><center>A-</center></b></td>
                            <td><b><center>A1</center></b></td>
                            <td><b><center>A2</center></b></td>
                            <td><b><center>B1</center></b></td>
                            <td><b><center>B+</center></b></td>
                        </tr>
                        <tr>
                            <td><input type="text" id="idioma" name="idioma" value="" style="width:100px" /></td>
                            <td><input type="radio" name="nivel_idioma" id="nivel_idioma" value="A-"></td>
                            <td><input type="radio" name="nivel_idioma" id="nivel_idioma" value="A1"></td>
                            <td><input type="radio" name="nivel_idioma" id="nivel_idioma" value="A2"></td>
                            <td><input type="radio" name="nivel_idioma" id="nivel_idioma" value="B1"></td>
                            <td><input type="radio" name="nivel_idioma" id="nivel_idioma" value="B2"></td>
                        </tr>
                    </table>
            <?php
        }
        public function docente($db, $id=false, $idrol=null){
            if ($id!=false){
                 if ($idrol==2){
                    $sql_user="SELECT * FROM usuario WHERE idusuario='".$id."' ";
                 }else{
                     $sql_user="SELECT * FROM usuario WHERE idusuario='".$id."' ";
                 }
               // echo '<br>'.$sql_user;
                $reg_user =$db->Execute($sql_user);
                $data_user=$reg_user->GetArray();
                $data_user=$data_user[0];
                
                if ($idrol==2){
                    $sql_doc="SELECT * FROM docente WHERE numerodocumento='".$data_user['numerodocumento']."' ";
                }else{
                    $sql_doc=$sql_user;
                }
                
                //echo '<br>'.$sql_doc;
                $reg_doc =$db->Execute($sql_doc);
                $data_docente= $reg_doc->GetArray();
                $data_docente=$data_docente[0];
                 if ($idrol==2){
                    $nombre=$data_docente['nombredocente'];
                    $apellido=$data_docente['apellidodocente'];
                    $celular=$data_docente['numerocelulardocente'];
                    $telefono=$data_docente['telefonoresidenciadocente'];
                    $email=$data_docente['emaildocente'];
                 }else{
                    $nombre=$data_docente['nombres']; 
                    $apellido=$data_docente['apellidos']; 
                    $celular=''; $telefono=''; $email='';
                 }
                ?>
                  <input type="hidden" name="iddocente" id="iddocente" value="<?php echo $data_docente['iddocente'] ?>" />
                                <table border="0" class="CSSTableGenerator">
                                    <tbody>
                                        <tr>
                                            <td><label class="titulo_label"><b>Nombre:</b></label></td>
                                            <td><?php echo $nombre?></td>
                                            <td><label class="titulo_label"><b>Apellido:</b></label></td>
                                            <td><?php echo $apellido?></td>
                                        </tr>
                                        <!--<tr>
                                            <td><label class="titulo_label"><b>Faculta:</b></label></td>
                                            <td><?php //echo $data_docente['nombredocente'].' '.$data_docente['apellidodocente']?></td>
                                        </tr>-->
                                        <tr>
                                            <td><label class="titulo_label"><b>Celular:</b></label></td>
                                            <td><?php echo $celular ?></td>
                                            <td><label class="titulo_label"><b>Fijo:</b></label></td>
                                            <td><?php echo $telefono ?></td>
                                        </tr>
                                        <tr>
                                            <td><label class="titulo_label"><b>E-mail Institucional:</b></label></td>
                                            <td><?php  echo $email  ?></td>
                                            <td></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                <?php
            }
        }

        public function bus_est($db){
        ?>
        <table border="0" class="CSSTableGenerator" width="100%">
            <tr>
             <td><label class="titulo_label"><b>Numero Documuento Estuante:</b></label></td>
              <td><input type="text" name="documento" id="documento" /> </td>  
            </tr>
        </table>
        <?php
    }
    
    public function estu_admision($db,$cod){
    
    $sql_Estu="SELECT es.codigoestudiante, e.nombresestudiantegeneral, apellidosestudiantegeneral, numerodocumento,
                      i.nombreinstitucioneducativa,  c.codigocarrera, c.nombrecarrera, m.nombremodalidadacademica, fa.nombrefacultad
               from estudiantegeneral as e 
               INNER JOIN estudiante as es on (e.idestudiantegeneral=es.idestudiantegeneral)
               INNER JOIN carrera c ON c.codigocarrera=es.codigocarrera 
               INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
               INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
               LEFT JOIN institucioneducativaestudiante AS ie on (ie.codigoestudiante=es.codigoestudiante)
               LEFT JOIN institucioneducativa AS i on (i.idinstitucioneducativa=ie.idinstitucioneducativa)
               WHERE es.codigoestudiante='".$cod."'";
    //echo $sql_Estu;
    $data_in= $db->Execute($sql_Estu);
    $E_data = $data_in->GetArray();
    $E_data=$E_data[0];
    $cod_carrera=$E_data['codigocarrera'];
        ?>
            <table border="0" class="CSSTableGenerator" style=" width:  1330px">
                <tr>
                    <td colspan="4"><h2><center><b>UNIVERSIDAD EL BOSQUE <BR>
                                    Proceso de Selecci&oacute;n de Aspirantes<br>
                            Formato Institucional de entrevista</b></center></h2>
             </td>
                </tr>
                <tr>
                    <td>Nombre:</td>
                    <td><?php echo   $E_data['nombresestudiantegeneral'].' '. $E_data['apellidosestudiantegeneral']  ?></td>
                    <td>N&uacute;mero de Documento:</td>
                    <td><?php echo   $E_data['numerodocumento'];  ?></td>
                </tr>
                <tr>
                    <td>Carrera:</td>
                    <td><?php echo   $E_data['nombrecarrera'];  ?></td>
                    <td>Facultad:</td>
                    <td><?php echo   $E_data['nombrefacultad'];  ?></td>
                </tr>
            </table>
        <?php
        return $cod_carrera;
    }


    public function bus_periodo($db){
        ?>
        <table border="0" class="CSSTableGenerator" width="100%">
            <tr>
                        <td><label class="titulo_label"><b>Periodo:</b></label></td>
                        <td><?php
                                 $query_tipo_periodo = "SELECT nombreperiodo, codigoperiodo FROM periodo order by codigoperiodo desc";
                                 $reg_tipoper = $db->Execute ($query_tipo_periodo);
                                 echo $reg_tipoper->GetMenu2('codigoperiodo','',true,false,1,' tabindex="17" id="codigoperiodo" ');
                            ?>
                        </td>
                    </tr>
        </table>
        <?php
    }

        public function bus_ins($db,$moda=false, $facul=false,$prog=false,$seme=false,$nivel=false){
        ?>
            <table border="0" class="CSSTableGenerator">
                    <tr>
                        <?php if($moda==false){ ?>
                        <td><label class="titulo_label"><b>Modalidas Academica:</b></label></td>
                        <td><?php
                                        $query_programa = "SELECT ' ' as nombremodalidadacademica, '0' as codigomodalidadacademica UNION SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica','',false,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                 ?>
                        </td>
                        <?php } ?>
                        <?php if($facul==false){ ?>
                        <td><label class="titulo_label"><b>Facultad:</b></label></td>
                        <td><?php
                                        $query_programa = "SELECT ' ' as nombrefacultad, '0' as codigofacultad UNION SELECT nombrefacultad, codigofacultad FROM facultad";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigofacultad','',false,false,1,' id=codigofacultad  style="width:150px;"');
                             ?></td>  
                        <?php } ?>
                        
                    </tr>
                    <tr>
                        <?php if($prog==false){ ?>
                        <td><label class="titulo_label"><b>Programa:</b></label></td>
                        <td colspan="3"><div  id="carreraAjax" style="display: none; overflow-x: hidden; overflow-y: scroll; width: 100%; height: 100px;"></div></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <?php if($seme==false){ ?>
                        <td><label class="titulo_label"><b>Semestre:</b></label>
                            <br>
                            <a href="javascript:void(0)" onclick="checkTodos('ck')">Todos</a>/<a href="javascript:void(0)" onclick="checkNinguno('ck')">Ninguno</a>
                        </td>
                        <td><div style="overflow-x: hidden; overflow-y: scroll; width: 100%; height: 100px;">
                            <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
                                <?php
                                    for ($i=1;$i<=12;$i++){
                                        ?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><input type="checkbox" id="semestre_1" class="ck" name="semestre_1[]" value="<?php echo  $i ?>"   /></td>
                                        </tr>
                                       <?php
                                    }
                                ?>
                            </table>
                            </div>
                        </td>  
                        <?php } ?>
                        <?php if($nivel==false){ ?>
                         <td><label class="titulo_label"><b>Nivel de Riesgo:</b></label>
                             <br>
                             <a href="javascript:void(0)" onclick="checkTodos('ries')">Todos</a>/<a href="javascript:void(0)" onclick="checkNinguno('ries')">Ninguno</a>

                         </td>
                        <td><div style="overflow-x: hidden; overflow-y: scroll; width: 100%; height: 100px;">
                             <?php
                                  $query_riesgo = "SELECT nombretiporiesgo, idobs_tiporiesgo FROM obs_tiporiesgo where codigoestado='100'";
                                  $reg_riesgo =$db->Execute($query_riesgo);
                                  ?>
                            <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
                                <?php
                                   foreach($reg_riesgo as $dt){ 
                                ?>
                                <tr>
                                    <td><?php echo $dt['nombretiporiesgo'];?></td>
                                    <td><input type="checkbox" id="idobs_tiporiesgo" name="idobs_tiporiesgo[]" class="ries" value="<?php echo  $dt['idobs_tiporiesgo'] ?>"   /></td>
                                </tr>
                                <?php
                                  }
                                ?>
                            </table>
                            </div>
                        </td>
                        <?php } ?>
                    </tr>
                </table>
        <?php
    }
    
}
   
  
?>