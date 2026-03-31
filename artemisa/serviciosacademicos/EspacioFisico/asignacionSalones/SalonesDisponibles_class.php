<?php
class SalonesDisponibles{
    public function SemanaDias($db){
        $SQL='SELECT * FROM dia';
        
        if($Dias=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de los Dias...<br><br>'.$SQL;
            die;
        }
        
        $C_Dias = $Dias->GetArray();
        
        Return $C_Dias;
    }//public function SemanaDias
    public function salonesOcupados($db,$fecha,$hIS,$hFS,$accesoDiscapacitados,$Data){ 
        
        $listaSalonesOcupados = array();
         $condicion = "";
        if($accesoDiscapacitados){
            $condicion = " AND ce.AccesoDiscapacitados = '".$accesoDiscapacitados."'";
        }
        
        for($Q=0;$Q<count($Data);$Q++){
            /*********************************************************/
             $SQL="SELECT 
                                ce1.Nombre as ubicacion, 
                                ce.ClasificacionEspaciosId, 
                                ce.Nombre as Espacio,
                                ts.nombretiposalon ,
                                ce.CapacidadEstudiantes,
                                ce.AccesoDiscapacitados,
                                ae.FechaAsignacion, 
                                ae.HoraInicio, 
                                ae.HoraFin,
                                ts.codigotiposalon
            		FROM AsignacionEspacios ae 
            		INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId = ae.ClasificacionEspaciosId
            		INNER JOIN tiposalon ts ON ts.codigotiposalon=ce.codigotiposalon
            		INNER JOIN ClasificacionEspacios ce1 ON ce.ClasificacionEspacionPadreId = ce1.ClasificacionEspaciosId
            		where ae.FechaAsignacion='".$fecha."' 
            		
            		".$condicion."
                    AND ce.ClasificacionEspaciosId='".$Data[$Q]['id']."'
                    AND ae.codigoestado=100
                      
            		ORDER BY ce.Nombre, ae.HoraInicio";
                    
                   
                                    
                if($ejecutaQuerySalonOcupado=&$db->Execute($SQL)===false){
                    echo 'Error en el SQl de Salones Ocupados...<br><br>'.$SQL;
                    die;
                }
               
               
               $i=0;
               if(!$ejecutaQuerySalonOcupado->EOF){
                   while(!$ejecutaQuerySalonOcupado->EOF){
                    /***************************************************/
                        $listaSalonesOcupados[$fecha][$ejecutaQuerySalonOcupado->fields['ClasificacionEspaciosId']][] = array(
            				'Ubicacion' => $ejecutaQuerySalonOcupado->fields['Espacio']
            				,'Nombre' =>$ejecutaQuerySalonOcupado->fields['ubicacion']
            				,'id' => $ejecutaQuerySalonOcupado->fields['ClasificacionEspaciosId']
            				,'tipoSalon' => $ejecutaQuerySalonOcupado->fields['nombretiposalon']
            				,'capacidadEstudiantes' => $ejecutaQuerySalonOcupado->fields['CapacidadEstudiantes']
            				,'accesoDiscapacitados' => $ejecutaQuerySalonOcupado->fields['AccesoDiscapacitados']
            				,'horaInicio' => $ejecutaQuerySalonOcupado->fields['HoraInicio']
            				,'horaFin' => $ejecutaQuerySalonOcupado->fields['HoraFin']
                            ,'Fecha' => $ejecutaQuerySalonOcupado->fields['FechaAsignacion']
            				);
                        
                   /***************************************************/
                    $i++;
                    $ejecutaQuerySalonOcupado->MoveNext();
                   }//while
              }else{
                $listaSalonesOcupados[$fecha][$Data[$Q]['id']][] = array('Libre'=>1,'id'=>$Data[$Q]['id'],'Ubicacion'=>$Data[$Q]['Nombre'],'tipoSalon'=>$Data[$Q]['nombretiposalon'],'capacidadEstudiantes'=>$Data[$Q]['CapacidadEstudiantes'],'accesoDiscapacitados'=>$Data[$Q]['AccesoDiscapacitados'],'Nombre'=>$Data[$Q]['Bloke']);
                
              }
            /*********************************************************/
        }//FOR  
                  
                    
		Return $listaSalonesOcupados;
	}// public function salonesOcupados
    public function SalonesLibres($db,$fecha,$hIS,$hFS,$accesoDiscapacitados){
      $consultaSalonesTodoElDia = "SELECT 
                                            ce1.Nombre as ubicacion, 
                                            ce.ClasificacionEspaciosId, 
                                            ce.Nombre as Espacio,
                                            ts.nombretiposalon,
                                            ce.CapacidadEstudiantes, 
                                            ce.AccesoDiscapacitados
                                            
                            		FROM AsignacionEspacios ae 
                            		INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId = ae.ClasificacionEspaciosId
                            		INNER JOIN tiposalon ts ON ts.codigotiposalon=ce.codigotiposalon
                            		INNER JOIN ClasificacionEspacios ce1 ON ce.ClasificacionEspacionPadreId = ce1.ClasificacionEspaciosId
                            		where ce.ClasificacionEspaciosId NOT IN (
                            			SELECT ce.ClasificacionEspaciosId
                            			FROM AsignacionEspacios ae 
                            			INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId = ae.ClasificacionEspaciosId
                            			INNER JOIN tiposalon ts ON ts.codigotiposalon=ce.codigotiposalon
                            			INNER JOIN ClasificacionEspacios ce1 ON ce.ClasificacionEspacionPadreId = ce1.ClasificacionEspaciosId
                            			where ae.FechaAsignacion='".$fecha."' 
                            			
                                        AND ce.AccesoDiscapacitados = '".$accesoDiscapacitados."' 
                                        AND ae.codigoestado=100
                            			ORDER BY ce.Nombre, ae.HoraInicio) ";
                                        /*
                                        AND ae.HoraInicio >= '".$hIS."'
                            			AND ae.HoraFin <=  '".$hFS."'  
                                        */
         
         if($SalonesTodoDia=&$db->Execute($consultaSalonesTodoElDia)===false){
            echo 'Error en el SQL de Salones Todo el Dia...<br><br>'.$consultaSalonesTodoElDia;
            die;
         }
         
         $arregloSalonLibres = array();
         $i=0;
         while(!$SalonesTodoDia->EOF){
            /******************************************/
                $arregloSalonLibres[$fecha][$i]['ClasificacionEspaciosId'][]  = $SalonesTodoDia->fields['ClasificacionEspaciosId'];
                $arregloSalonLibres[$fecha][$i]['Ubicacion'][]  = $SalonesTodoDia->fields['ubicacion'];
                $arregloSalonLibres[$fecha][$i]['Nombre'][]  = $SalonesTodoDia->fields['Espacio'];
                $arregloSalonLibres[$fecha][$i]['tipoSalon'][]  = $SalonesTodoDia->fields['nombretiposalon'];
                $arregloSalonLibres[$fecha][$i]['capacidadEstudiantes'][]  = $SalonesTodoDia->fields['CapacidadEstudiantes'];
                $arregloSalonLibres[$fecha][$i]['accesoDiscapacitados'][]  = $SalonesTodoDia->fields['AccesoDiscapacitados'];
                $arregloSalonLibres[$fecha][$i]['horaInicio'][]  = $hIS;
                $arregloSalonLibres[$fecha][$i]['horaFin'][]  = $hFS;
                $i++;
            /******************************************/
            $SalonesTodoDia->MoveNext();
         }
         Return $arregloSalonLibres;
    }//public function SalonesLibres
    public function DataEspaciosLibres($Data,$fecha,$hIS,$hFS,$Espacios,$db){
       //echo '<pre>';print_r($Data[$fecha]);
       
       foreach ($Data[$fecha] as $key => $value) {
        	$horaInicioSolicitud = $hIS.':00';
			$horaFinSolicitud = $hFS.':00';
			$control = count($value)-1;
            //echo '<pre>';print_r($value);
            
			for ($i=0; $i <=$control; $i++) { 
		     
                if($value[$i]['Libre']==1){
                    $arregloSalonLibres[$fecha][$value[$i]['id']][] = array(
						'Ubicacion' => $value[$i]['Ubicacion']
						,'Nombre' => $value[$i]['Nombre']
						,'tipoSalon' => $value[$i]['tipoSalon']
						,'capacidadEstudiantes' => $value[$i]['capacidadEstudiantes']
						,'accesoDiscapacitados' => $value[$i]['accesoDiscapacitados']
						,'HoraInicio' =>$horaInicioSolicitud
						,'HoraFin' => $horaFinSolicitud
					);
                }else{
                    
                    if($i<1){
                        
                        /*if('13:00:00'<'13:30:00'){
                            echo 'Si es Menor...';
                        }else{
                            echo 'Falso';
                        }
                        die;*/
                        if($horaInicioSolicitud!=$value[$i]['horaInicio']){
                            if($horaInicioSolicitud<$value[$i]['horaInicio']){
                            
                                $Result = $this->ConsultaLibre($db,$value[$i]['id'],$horaInicioSolicitud,$value[$i]['horaInicio'],$value[$i]['Fecha']);
                                
                                if($Result==true){
                                    $arregloSalonLibres[$fecha][$value[$i]['id']][] = array(
                						'Ubicacion' => $value[$i]['Ubicacion']
                						,'Nombre' => $value[$i]['Nombre']
                						,'tipoSalon' => $value[$i]['tipoSalon']
                						,'capacidadEstudiantes' => $value[$i]['capacidadEstudiantes']
                						,'accesoDiscapacitados' => $value[$i]['accesoDiscapacitados']
                						,'HoraInicio' => $horaInicioSolicitud
                						,'HoraFin' => $value[$i]['horaInicio']
                					);
                                }
                            }
                        }
                        
                        if($value[$i+1]['horaInicio']){
                            if($value[$i]['horaFin']!=$value[$i+1]['horaInicio']){
                                if($value[$i]['horaFin']<$value[$i+1]['horaInicio']){
                                    $Result =$this->ConsultaLibre($db,$value[$i]['id'],$value[$i]['horaFin'],$value[$i+1]['horaInicio'],$value[$i]['Fecha']);
                                    
                                    if($Result==true){
                                        $arregloSalonLibres[$fecha][$value[$i]['id']][] = array(
                    						'Ubicacion' => $value[$i]['Ubicacion']
                    						,'Nombre' => $value[$i]['Nombre']
                    						,'tipoSalon' => $value[$i]['tipoSalon']
                    						,'capacidadEstudiantes' => $value[$i]['capacidadEstudiantes']
                    						,'accesoDiscapacitados' => $value[$i]['accesoDiscapacitados']
                    						,'HoraInicio' => $value[$i]['horaFin']
                    						,'HoraFin' => $value[$i+1]['horaInicio']
                    					);
                                    }
                                }    
                            }
                        }else{
                            if($value[$i]['horaFin']!=$horaFinSolicitud){
                                if($value[$i]['horaFin']<$horaFinSolicitud){
                                    $Result =$this->ConsultaLibre($db,$value[$i]['id'],$value[$i]['horaFin'],$horaFinSolicitud,$value[$i]['Fecha']);
                                    
                                    if($Result==true){
                                        $arregloSalonLibres[$fecha][$value[$i]['id']][] = array(
                    						'Ubicacion' => $value[$i]['Ubicacion']
                    						,'Nombre' => $value[$i]['Nombre']
                    						,'tipoSalon' => $value[$i]['tipoSalon']
                    						,'capacidadEstudiantes' => $value[$i]['capacidadEstudiantes']
                    						,'accesoDiscapacitados' => $value[$i]['accesoDiscapacitados']
                    						,'HoraInicio' => $value[$i]['horaFin']
                    						,'HoraFin' => $horaFinSolicitud
                    					);
                                    }
                                }
                            }
                        }
                        
                        
                    }else{
                        
                        if($value[$i+1]['horaInicio']){
                            if($value[$i]['horaFin']!=$value[$i+1]['horaInicio']){
                               if($value[$i]['horaFin']<$value[$i+1]['horaInicio']){
                                    $Result = $this->ConsultaLibre($db,$value[$i]['id'],$value[$i]['horaFin'],$value[$i+1]['horaInicio'],$value[$i]['Fecha']);
                                    
                                    if($Result==true){
                                        $arregloSalonLibres[$fecha][$value[$i]['id']][] = array(
                    						'Ubicacion' => $value[$i]['Ubicacion']
                    						,'Nombre' => $value[$i]['Nombre']
                    						,'tipoSalon' => $value[$i]['tipoSalon']
                    						,'capacidadEstudiantes' => $value[$i]['capacidadEstudiantes']
                    						,'accesoDiscapacitados' => $value[$i]['accesoDiscapacitados']
                    						,'HoraInicio' => $value[$i]['horaFin']
                    						,'HoraFin' => $value[$i+1]['horaInicio']
                    					);
                                    }
                                 }   
                            }
                        }else{
                           if($value[$i]['horaFin']!=$horaFinSolicitud){
                              if($value[$i]['horaFin']<$horaFinSolicitud){
                                   $Result = $this->ConsultaLibre($db,$value[$i]['id'],$value[$i]['horaFin'],$horaFinSolicitud,$value[$i]['Fecha']);
                                   
                                   if($Result==true){
                                        $arregloSalonLibres[$fecha][$value[$i]['id']][] = array(
                    						'Ubicacion' => $value[$i]['Ubicacion']
                    						,'Nombre' => $value[$i]['Nombre']
                    						,'tipoSalon' => $value[$i]['tipoSalon']
                    						,'capacidadEstudiantes' => $value[$i]['capacidadEstudiantes']
                    						,'accesoDiscapacitados' => $value[$i]['accesoDiscapacitados']
                    						,'HoraInicio' => $value[$i]['horaFin']
                    						,'HoraFin' => $horaFinSolicitud
                    					);
                                    }
                                }    
                            }    
                        }
                       
                        
                    }
                  
               }
			}//for
		}//foreach
        
       // echo '<pre>';print_r($arregloSalonLibres);
        
       Return $arregloSalonLibres;
    }//public function DataEspaciosLibres
    public function ConsultaLibre($db,$id,$hora1,$hora2,$fecha){
              $SQL="SELECT 
                                ce1.Nombre as ubicacion, 
                                ce.ClasificacionEspaciosId, 
                                ce.Nombre as Espacio,
                                ts.nombretiposalon ,
                                ce.CapacidadEstudiantes,
                                ce.AccesoDiscapacitados,
                                ae.FechaAsignacion, 
                                ae.HoraInicio, 
                                ae.HoraFin,
                                ts.codigotiposalon
            		FROM AsignacionEspacios ae 
            		INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId = ae.ClasificacionEspaciosId
            		INNER JOIN tiposalon ts ON ts.codigotiposalon=ce.codigotiposalon
            		INNER JOIN ClasificacionEspacios ce1 ON ce.ClasificacionEspacionPadreId = ce1.ClasificacionEspaciosId
            		where ae.FechaAsignacion='".$fecha."' 
            		AND ae.HoraInicio >= '".$hora1."'
            		AND ae.HoraFin <=  '".$hora2."' 
            		AND ce.ClasificacionEspaciosId='".$id."'
                    AND ae.codigoestado=100
                      
            		ORDER BY ce.Nombre, ae.HoraInicio";
              if($Consulta=&$db->Execute($SQL)===false){
                echo 'Error en el SQl .....<br>'.$SQL;
                die;
              }    
              
              if($Consulta->EOF){
                return true;
              }  
    }//public function ConsultaLibre
    public function DataFuncion($db,$op,$fecha,$hIS,$hFS,$accesoDiscapacitados='',$Sede='',$userid){
        $Num = count($fecha);
        for($i=0;$i<$Num;$i++){
            /*************************************************/
            $Count = count($fecha[$i]);
            for($j=0;$j<$Count;$j++){
                /**********************************************/
                $Fecha_Momento = $fecha[$i][$j];
                if($op==1){
                    $this->salonesOcupados($db,$Fecha_Momento,$hIS,$hFS,$accesoDiscapacitados);
                }else{
                    $Espacios = $this->SalonesAll($db,$Sede,$userid);
                    $Salones = $this->salonesOcupados($db,$Fecha_Momento,$hIS,$hFS,$accesoDiscapacitados,$Espacios);
                    //echo '<pre>';print_r($Salones);die;
                    $ResultadoEspacio[] = $this->DataEspaciosLibres($Salones,$Fecha_Momento,$hIS,$hFS,$Espacios,$db);
                }
                /**********************************************/
            }//for
            /*************************************************/
        }//for
        
        Return $ResultadoEspacio;
    }//public function DataFuncion
    public function SalonesAll($db,$Sede='',$userid){
        include_once('../Interfas/InterfazSolicitud_class.php');  $C_InterfazSolicitud = new InterfazSolicitud();
        $Data = $C_InterfazSolicitud->UsuarioMenu($db,$userid);
        
        $RolEspacioFisico   = $Data['Data'][0]['RolEspacioFisicoId']; 
        
        if($Sede=='-1' || $Sede==-1){
            $Condicion = '';
        }else{
            $Condicion = '  AND ccc.ClasificacionEspaciosId="'.$Sede.'"';
        }
        $InnerCondicon = '';
        $Condicion_1   = '';
        if($RolEspacioFisico==2){
            $InnerCondicon = ' INNER JOIN ResponsableEspacioFisico r ON r.EspaciosFisicosId=c.EspaciosFisicosId  AND r.CodigoTipoSalon=c.codigotiposalon';
            $Condicion_1   = ' AND r.UsuarioId="'.$userid.'" AND r.CodigoEstado=100';
        }
        
         $SQL='SELECT

                c.ClasificacionEspaciosId AS id,
                c.Nombre,
                c.CapacidadEstudiantes,
                cc.Nombre AS Bloke,
                t.nombretiposalon,
                c.AccesoDiscapacitados
                
                FROM
                
                ClasificacionEspacios c INNER JOIN DetalleClasificacionEspacios d ON c.ClasificacionEspaciosId=d.ClasificacionEspaciosId
									    INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId=c.ClasificacionEspacionPadreId
									    INNER JOIN tiposalon t ON c.codigotiposalon=t.codigotiposalon
                                        INNER JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId=cc.ClasificacionEspacionPadreId
                                        '.$InnerCondicon.'

                
                WHERE
                
                c.EspaciosFisicosId=5
                AND
                c.codigoestado=100'.$Condicion.$Condicion_1;
                
          if($Espacios=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Espacios....<br><br>'.$SQL;
            die;
          }    
          
          $Data = $Espacios->GetArray();
          
          Return $Data;  
    }//public function SalonesAll
  public function Sedes($db){
          $SQL='SELECT
                        c.ClasificacionEspaciosId AS id,
                        c.Nombre
                FROM
                        ClasificacionEspacios c 
                WHERE
                        c.ClasificacionEspacionPadreId=1
                        AND
                        c.EspaciosFisicosId=3';
                        
          if($Sedes=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Sedes....<br><br>'.$SQL;
            die;
          }
               
          $C_Sedes = $Sedes->GetArray();
          
         Return $C_Sedes;           
  }//public function Sedes
}//class SalonesDisponibles

?>