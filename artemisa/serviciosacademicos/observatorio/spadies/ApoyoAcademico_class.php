<?php
class ApoyoAcademico{
    public function Display(){
        global $db;
        ?>
        <div style="width: 100%;" align="center">
            <fieldset>
            <legend>Apoyos Acad&eacute;micos</legend>
                <table border="0" align="center" width="100%">
                    <tr>
                        <td><strong>Modalidad</strong><span style="color: red;">*</span></td>
                        <?PHP 
                        $Modalidad  = $this->Modalidad();
                        ?>
                        <td>
                            <select id="Modalidad_id" name="Modalidad_id" onchange="BuscarPrograma()"> 
                                <option value="-1"></option>
                                <?PHP 
                                while(!$Modalidad->EOF){
                                    ?>
                                    <option value="<?PHP echo $Modalidad->fields['id']?>"><?PHP echo $Modalidad->fields['nombre']?></option>
                                    <?PHP
                                    $Modalidad->MoveNext();
                                }
                                ?>
                            </select>
                        </td>
                        <td></td>
                        <td><strong>Periodo</strong><span style="color: red;">*</span></td>
                        <?PHP 
                        $Periodo  = $this->Periodo();
                        ?>
                        <td>
                            <select id="Periodo_id" name="Periodo_id">
                                <?PHP 
                                while(!$Periodo->EOF){
                                    
                                    if($Periodo->fields['estado']==1){
                                        $Selecte  = 'selected="selected"';
                                    }else{
                                        $Selecte  = '';
                                    }
                                    
                                    ?>
                                    <option value="<?PHP echo $Periodo->fields['id']?>" <?PHP echo $Selecte?>><?PHP echo $Periodo->fields['id']?></option>
                                    <?PHP
                                    $Periodo->MoveNext();
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr>
                        <td><strong>Programa</strong><span style="color: red;">*</span></td>
                        <td colspan="3">
                            <div id="DivPrograma">
                                <select id="Programa_id" name="Programa_id">
                                    <option value="-1"></option>
                                </select>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr>
                        <td><strong>Estudiante</strong><span style="color: red;">*</span></td>
                        <td>
                            <input type="text" id="Estudiante" name="Estudiante" autocomplete="off" size="70" onkeypress="AutocompletarEstudiante()" onclick="Format()" /><input type="hidden" id="id_estudiantegeneral" name="id_estudiantegeneral" />
                        </td>
                        <td></td>
                        <td><strong>N&deg; Identificaci&oacute;n</strong><span style="color: red;">*</span></td>
                        <td>
                            <input type="text" id="NumDocumento" name="NumDocumento" autocomplete="off" size="15" onkeypress="AutocompleteDocumento()" onclick="Format()" /><input type="hidden" id="codigoestudiante" name="codigoestudiante" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr>
                        <td><strong>Tipo de Apoyo</strong><span style="color: red;">*</span></td>
                        <td>
                        <?PHP $this->TipoAcademico();?>    
                        </td>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr>
                        <td><strong>Descripci&oacute;n</strong></td>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3">
                            <textarea id="Descripcion" name="Descripcion" rows="20" cols="60"></textarea>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center" >
                            <input type="button" id="SaveApoyo" name="SaveApoyo" onclick="Save()" value="Guardar" />
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <?PHP
    }//public function Display
    public function Modalidad(){
        global $db;
        
          $SQL='SELECT 

                codigomodalidadacademica as id,
                nombremodalidadacademica as nombre
                
                FROM 
                
                modalidadacademica  
                
                WHERE  
                codigoestado=100 AND codigomodalidadacademica in (200,300)';
                
           if($Modalidad=&$db->Execute($SQL)===false){
                echo 'Error en el SQL ...<br><br>'.$SQL;
                die;            
           }     
           
         return $Modalidad;  
    }//public function Modalidad
    public function Periodo(){
        global $db;
        
          $SQL='SELECT 

                codigoperiodo as id,
                codigoestadoperiodo as estado
                
                FROM 
                
                periodo
                
                ORDER BY 
                
                codigoperiodo DESC';
                
            if($Periodo=&$db->Execute($SQL)===false){
                echo 'Error en el SQl ...<br><br>'.$SQL;
                die;
            }    
            
         return $Periodo;   
    }//public function Periodo
    public function Programas($id){
        global $db;
        
          $SQL='SELECT codigocarrera,nombrecarrera,codigomodalidadacademica
		  FROM carrera WHERE  codigomodalidadacademica="'.$id.'"
                AND
                codigocarrera NOT IN (1,2,3)
        AND fechavencimientocarrera>NOW()  
		AND (EsAdministrativa=0 OR EsAdministrativa IS NULL) 
		ORDER BY nombrecarrera ASC';
                
         if($Carrera=&$db->Execute($SQL)===false){
            echo 'Error en el SQL De las Carreras..<br><br>'.$SQL;
            die;
         }       
        
        ?>
        <select id="Programa_id" name="Programa_id">
            <option value="-1"></option>
            <?PHP 
            while(!$Carrera->EOF){
                ?>
                <option value="<?PHP echo $Carrera->fields['codigocarrera']?>"><?PHP echo $Carrera->fields['nombrecarrera']?></option>
                <?PHP
                $Carrera->MoveNext();
            }
            ?>
        </select>
        <?PHP
    }//public function Programas
    public function TipoAcademico(){
        global $db;
        
          $SQL='SELECT 

                idtipoapoyoacademico as id,
                nombretipoapoyoacademico as nombre
                
                FROM 
                
                TipoApoyoAcademico 
                
                WHERE
                
                codigoestado=100';
                
           if($TipoAcademico=&$db->Execute($SQL)===false){
                echo 'Error en el SQL ...<br><br>'.$SQL;
                die;
           } 
           
         ?>
        <select id="TipoApoyo" name="TipoApoyo">
            <option value="-1"></option>
            <?PHP 
            while(!$TipoAcademico->EOF){
                ?>
                <option value="<?PHP echo $TipoAcademico->fields['id']?>"><?PHP echo $TipoAcademico->fields['nombre']?></option>
                <?PHP
                $TipoAcademico->MoveNext();
            }
            ?>
        </select>
         <?PHP      
    }//public function TipoAcademico
}//Class

?>