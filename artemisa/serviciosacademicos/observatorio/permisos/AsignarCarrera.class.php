<?PHP
class AsignarCarrera{
    public function Principal(){
        global $userid,$db;
        ?>
        <style>
            fieldset{
                border:1px solid #C0C0C0;
            }
            .AsignarButton{
                background:-moz-linear-gradient(#fc0 0%,#F60 100%);
                background:-ms-linear-gradient(#fc0 0%,#F60 100%);
                background:-o-linear-gradient(#fc0 0%,#F60 100%);
                background:-webkit-linear-gradient(#fc0 0%,#F60 100%);
                background:linear-gradient(#fc0 0%,#F60 100%);
                border:solid 1px #DEDEDE;
                border-radius:5px;
                text-align:center;
                padding:5px;
                color:#fff;
                width:150px;
            }
            .AsignarButton:hover{
                background:-moz-linear-gradient(#fff 0%,#DEDEDE 100%);
                color:#999;
            }

        </style>
        <div id="container">
            <fieldset>
                <legend>Asignar Carrera a Docentes</legend>
                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center"  style="width: 100%;" >
                    <thead>
                        <tr>
                            <th><strong>Docente</strong></th>
                        </tr>
                        <tr>
                            <th>
                                <input type="text" size="75" placeholder="Digite Nombre , Usuario o Numero de Documento" id="Docente" name="Docente" autocomplete="off" style="text-align: center;" onkeypress="AutocompleteDocente()" onclick="FormatDocente()" /><input type="hidden" id="id_Docente" name="id_Docente" />
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>&nbsp;&nbsp;</td>
                        </tr>
                        <tr style="text-align: center;">
                            <td>
                                 <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center"  style="width: 100%;" >
                                    <tr>
                                        <th style="width: 45%;"><strong>Programa Acad&eacute;mico</strong></th>
                                        <th style="width: 10%;">&nbsp;&nbsp;</th>
                                        <th style="width: 45%;"><strong>Per&iacute;odo Inicial</strong></th>
                                    </tr>
                                    <tr>
                                        <th style="width: 45%;"><?PHP $this->Carreras();?></th>
                                        <th style="width: 10%;">&nbsp;&nbsp;</th>
                                        <th style="width: 45%;"><?PHP echo $this->Periodo();?><input type="hidden" value="<?php echo $this->Periodo();?>" name="codigoperiodoinicial" id="codigoperiodoinicial" /></th>
                                    </tr>
                                 </table>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="button" id="SaveAsignar" name="SaveAsignar" value="Asignar Carrera" onclick="SaveAsignar()" class="AsignarButton" />
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <th>
                                <hr style="width: 90%;margin: 1em auto;" />
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <fieldset style="width:90%;margin: 1em auto;">
                                    <legend>Carreras Asignadas</legend>
                                    <div id="DIV_AsignacionCarrera">
                                        <br />
                                            <span style="color: silver;text-align: center;">No hay Informaci&oacute;n...</span>
                                        <br />
                                    </div>
                                </fieldset>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <hr style="width: 90%;margin: 1em auto;" />
                            </th>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
       </div>         
        <?PHP 
    }//public function Principal
    public function Periodo(){
        global $userid,$db;
        
         $SQL='SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';
        
        if($Periodo=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Periodo...<br>'.$SQL;
            die;
        }
        
        return  $Periodo->fields['codigoperiodo'];
    }//public function Periodo
    public function Carreras(){
        global $userid,$db;
        
        $SQL='SELECT codigocarrera, nombrecarrera FROM carrera WHERE codigomodalidadacademicasic=200  ORDER BY nombrecarrera ASC';
        
        if($Carrera=&$db->Execute($SQL)===false){
            echo 'Error en el SQL De la Carrera...<br><br>'.$SQL;
            die;
        }
        
        ?>
        <select id="id_Carrera" name="id_Carrera" style="width: 90%;">
            <option value="-1"></option>
            <?PHP 
            while(!$Carrera->EOF){
            /***************************************/
                ?>
                <option value="<?PHP echo $Carrera->fields['codigocarrera']?>"><?PHP echo $Carrera->fields['nombrecarrera']?></option>
                <?PHP
                /***************************************/
                $Carrera->MoveNext();
            }
            ?>
        </select>
        <?PHP
        
    }//public function Carreras
    public function BuscarData($id_Docente,$Periodo){
        global $userid,$db;
        
          $SQL='SELECT 

                c.nombrecarrera,
                a.id_AsignarCarrera
                
                FROM 
                
                Obs_AsignarCarrera  a INNER JOIN carrera c ON c.codigocarrera=a.id_Carrera 
                
                AND 
                a.codigoestado=100 
                AND 
                a.id_Docente="'.$id_Docente.'"
                AND 
                a.codigoperiodo<="'.$Periodo.'" 				
                AND
                (a.CodigoPeriodoFinal>="'.$Periodo.'" OR a.CodigoPeriodoFinal IS NULL)
				';
            // echo '<pre>';print_r($db);die;
             if($DocentesAsignar=&$db->Execute($SQL)===false){
                echo 'Error en el SQlde doscente Asignacion Carrera...<br><br>'.$SQL;
                die;
             }   
          if(!$DocentesAsignar->EOF){   
          ?>
          <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center"  style="width: 70%;" >
            <thead>
                <tr>
                    <th><strong>N&deg;</strong></th>
                    <th><strong>Programa Acad&eacute;mico</strong></th>
                    <th><strong>Opci&oacute;n</strong></th>
                </tr>
            </thead>
            <tbody>
                <?PHP 
                $i=0;
                    while(!$DocentesAsignar->EOF){
                        /**********************************************/
                        ?>
                        <tr>
                            <td style="text-align: center;"><?PHP echo $i+1;?></td>
                            <td style="text-align: left;"><?PHP echo $DocentesAsignar->fields['nombrecarrera']?></td>
                            <td style="text-align: center;"><img src="../../mgi/images/delete.png" width="20" style="cursor: pointer;" onclick="EliminarAsinacion('<?PHP echo $DocentesAsignar->fields['id_AsignarCarrera']?>')" title="Eliminar Carrera Asignada" /></td>
                        </tr>
                        <?PHP
                        /**********************************************/
                        $DocentesAsignar->MoveNext();
                        $i++;
                    }//while
               ?>
            </tbody>
          </table>
          <?PHP 
          }else{
            ?>
            <br />
                <span style="color: silver;text-align: center;">No hay Informaci&oacute;n...</span>
            <br />
            <?PHP
        }//if  
    }//public function BuscarData
}//class AsignarCarrera
?>