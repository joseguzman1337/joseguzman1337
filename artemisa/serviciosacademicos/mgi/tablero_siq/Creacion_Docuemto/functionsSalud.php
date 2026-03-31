<?php
    function pintarActividadesPromocionYPrevencion($db,$DisableSalud,$periodo=null,$idbienestar=null){ 
        $Consulta = consultaActividadesPromocionYPrevencion($db,$periodo,$idbienestar);
        $respuesta = "";
        while(!$Consulta->EOF){ 
                    $respuesta .= "<tr><td width='3%'>&nbsp;&nbsp;</td>";
                    $respuesta .= "<td width='35%'><strong>".$Consulta->fields['Nombre']."</strong></td>";
                    $respuesta .= "<td width='1%'>&nbsp;&nbsp;</td>";
                    $respuesta .= "<td width='57%'><input type='text' id='".$Consulta->fields['nombrecorto']."' name='actividadesPromocion[]' class='CajasHoja required' value='".$Consulta->fields['cantidad']."' ".$DisableSalud." /><input type='hidden' name='idsActividadesPromocion[]' value='".$Consulta->fields['id']."' ".$DisableSalud." /></td>";
                    $respuesta .= "<td width='4%'>&nbsp;&nbsp;</td></tr>";
                    $respuesta .= "<tr><td colspan='5'>&nbsp;&nbsp;</td></tr>";
                       $Consulta->MoveNext(); 
                }//while                             
		
        ?>                                                 
<?php return $respuesta; } 

    function consultaActividadesPromocionYPrevencion($db,$periodo=null,$idbienestar=null){
        $count = 0;
        if($idbienestar!=null){
            $selectsql = "select s.id_saludbienestar as id,
                                            s.nombre as Nombre,
                                            s.nombrecorto, a.cantidad from bienestar b
                        INNER JOIN bienestar_saludActividadesPromociones a ON a.idbienestar=b.idbienestar AND a.codigoestado=100 
                        INNER JOIN saludbienestar s ON s.id_saludbienestar=a.id_saludbienestar 
                        WHERE b.idbienestar='".$idbienestar."' AND b.codigoestado=100";
            $selectquery = $db->Execute($selectsql);
            $count = $selectquery->RecordCount();
        }
        if($count>0){
            return $selectquery;
        } else { 
            $SQL='SELECT 
                                            id_saludbienestar as id,
                                            nombre as Nombre,
                                            nombrecorto, 0 as cantidad

                                            FROM 

                                            saludbienestar 

                                            WHERE

                                            promocionPrevencion=1
                                            AND
                                            codigoestado=100';

                                            if($Consulta=&$db->Execute($SQL)===false){
                                                            echo 'Error en el SQL ...<br><br>'.$SQL;
                                                            die;
                                                    }
            return $Consulta;
        }
    }
    
    function buscarDatoBienestar($Estudiante_id,$P_General,$db){
        $SQL='SELECT 

					idbienestar,
					idestudiantegenral,
					codigoestado
					
					FROM 
					
					bienestar
					
					WHERE
					
					codigoestado=100
					AND
					idestudiantegenral="'.$Estudiante_id.'"
					AND
					codigoperiodo="'.$P_General.'"';
			
            $ExisteR=&$db->Execute($SQL);
            return array($ExisteR,$SQL);
    }
    
    function actualizarRegistroBienestarSalud($db,$id_Bienestar,$P_General,$Estudiante_id,$Num_Ase_PsicoSalud){
        $SQL_UP='UPDATE		 bienestar  SET		 asesoriapsicologicaSalud="'.$Num_Ase_PsicoSalud.'"
					 WHERE idestudiantegenral="'.$Estudiante_id.'"  
								AND 
								codigoperiodo="'.$P_General.'"  
								AND 
								idbienestar="'.$id_Bienestar.'" 
								AND  
								codigoestado=100';
        $UpBienestar=&$db->Execute($SQL_UP);
        return array($UpBienestar,$SQL_UP);
    }
    
    function actualizarActividadesPromocion($db,$idbienestar,$valoresActividades,$idsActividades){
        $i = 0;
        foreach($valoresActividades as $value){
            //verifico si ya se habia guardado registro
            $sql = "SELECT cantidad FROM bienestar_saludActividadesPromociones WHERE idbienestar='".$idbienestar."' 
                AND id_saludbienestar='".$idsActividades[$i]."' AND codigoestado=100";
            $result = $db->GetAll($sql);
            if($result!==false && count($result)>0){
                //update
                 $SQL_UP='UPDATE bienestar_saludActividadesPromociones  SET cantidad="'.$value.'"
					 WHERE 
								idbienestar="'.$idbienestar.'"  
								AND 
								id_saludbienestar="'.$idsActividades[$i].'" 
								AND  
								codigoestado=100';
            } else {
                //insert
                $SQL_UP='INSERT INTO bienestar_saludActividadesPromociones(idbienestar,id_saludbienestar,cantidad,codigoestado)VALUES("'.$idbienestar.'","'.$idsActividades[$i].'","'.$value.'",100)';
            }
            //var_dump($SQL_UP);
            $db->Execute($SQL_UP);
            $i+=1;
        }
    }
    
    function actualizarIncapacidades($db,$idbienestar,$cadena){
         $incapacidades	= explode('_',$cadena);	
         //1 porque el primero me va a salir vacio
            for($t=1;$t<count($incapacidades);$t++){
		$incapacidad	= explode('::',$incapacidades[$t]);
                if($incapacidad[4]==null||$incapacidad[4]==""){
                    $SQL_UP='INSERT INTO bienestar_saludIncapacidades(idbienestar,tipoIncapacidad,fechaInicio,fechaFin,motivo,codigoestado)VALUES("'.$idbienestar.'","'.$incapacidad[0].'","'.$incapacidad[1].'","'.$incapacidad[2].'","'.$incapacidad[3].'",100)';
                } else {
                    $SQL_UP='UPDATE bienestar_saludIncapacidades  SET tipoIncapacidad="'.$incapacidad[0].'", fechaInicio="'.$incapacidad[1].'", 
                                            fechaFin="'.$incapacidad[2].'", motivo="'.$incapacidad[3].'" 
					 WHERE 
								idbienestar="'.$idbienestar.'"  
								AND  idbienestar_saludIncapacidades="'.$incapacidad[4].'" 
								AND codigoestado=100';
                }
                //var_dump($SQL_UP);
                $db->Execute($SQL_UP);
             }
    }
    
    function pintarIncapacidades($db,$disableSalud,$idbienestar){
        $respuesta = "";
        $j = 0;
        if($idbienestar!=null){
            $selectsql = "select * from bienestar_saludIncapacidades b
                        WHERE b.idbienestar='".$idbienestar."' AND b.codigoestado=100";
            $Consulta = $db->Execute($selectsql);
            while(!$Consulta->EOF){ 
                    $respuesta .= "<tr><td align='center'><strong>".($j+1).". Incapacidad estudiante</strong></td>";
                    $respuesta .= "<td align='center'><strong>Transcrita</strong>&nbsp;&nbsp;&nbsp;";
                    $check1 = "";
                    $check2 = "";
                    if($Consulta->fields['tipoIncapacidad']==1){
                        $check1 = "checked=true";
                    } else if($Consulta->fields['tipoIncapacidad']==2){
                        $check2 = "checked=true";
                    }                    
                    $respuesta .= "<input type='radio' value='1' name='tipoIncapacidad_".$j."' id='transcrita_incapacidad_".$j."' ".$disableSalud." ".$check1." >&nbsp;&nbsp;&nbsp;";
                    $respuesta .= "<strong>Emitida</strong>&nbsp;&nbsp;&nbsp;";
                    $respuesta .= "<input type='radio' value='2' name='tipoIncapacidad_".$j."' id='emitida_incapacidad_".$j."' ".$disableSalud." ".$check2." ></td>";
                    $respuesta .= "<td align='center'>&nbsp;&nbsp;</td>";
                    $respuesta .= "<td align='center'><input type='text' name='Fecha_InicioIncapacida_".$j."' size='14' id='Fecha_InicioIncapacida_".$j."' title='Fecha de inico de la incapacidad' maxlength='12' tabindex='7' placeholder='Fecha de Inicio' autocomplete='off' value='".$Consulta->fields['fechaInicio']."' readonly ".$disableSalud." class='dateInput' /></td>";
                    $respuesta .= "<td align='center'>&nbsp;&nbsp;</td>";
                    $respuesta .= "<td align='center'><input type='text' name='Fecha_FinalizacionIncapacidad_".$j."' size='14' id='Fecha_FinalizacionIncapacidad_".$j."' title='Fecha final de la incapacidad' maxlength='12' tabindex='7' placeholder='Fecha Final' autocomplete='off' value='".$Consulta->fields['fechaFin']."' readonly ".$disableSalud." class='dateInput' /></td>";
                    $respuesta .= "<td align='center'>&nbsp;&nbsp;</td>";
                    $respuesta .= "<td align='center'><input type='text' id='Motivo_incapacida_".$j."' name='Motivo_incapacida_".$j."' class='CajasHoja' placeholder='Motivo de la Incapacidad' size='50' ".$disableSalud." value='".$Consulta->fields['motivo']."' />";
                    $respuesta .= "<input type='hidden' value='".$Consulta->fields['idbienestar_saludIncapacidades']."' id='idIncapacidad_".$j."' name='idIncapacidad_".$j."' /></td></tr>";
             
                       $Consulta->MoveNext(); 
                       $j+=1;
                }
        }
        return array($respuesta,($j-1));
    }
?>
