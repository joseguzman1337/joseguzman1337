<?php
class TiposAnexos{
    public function Tecnico($db,$id){
         $sqlModalidad ="SELECT codigomodalidadacademica, nombremodalidadacademica FROM modalidadacademica where codigoestado ='100' AND codigomodalidadacademica='200' OR codigomodalidadacademica='300'";
         $valorModalidad = $db->execute($sqlModalidad);
        ?>
        <table style="width:930px">
            <tr>
                <?PHP $this->Consecutivo();?>
            </tr>
            <tr>
                <td>Modalidad Academica<span style='color: red;'>*</span></td>
                <td>
                    <select id='Modalidad' name='Modalidad' onchange='CarrerasModalidad()' required='required'>
                        <option value=''></option>
                        <?PHP
            
             foreach($valorModalidad as $datosModalidad)
             {
                ?>
                <option value="<?PHP echo $datosModalidad['codigomodalidadacademica']?>"><?PHP echo $datosModalidad['nombremodalidadacademica'];?></option>
                <?PHP 
             }
             ?>
                   </select>
                </td>
             </tr>
             <tr>
                <td>Carrera<span style='color: red;'>*</span></td>
                <td id='Td_Carreras'>
                    <select name='carrera' id='carrera' required='required' onchange='SemestreCarreras()'>
                        <option value=''></option>
                    </select>
                </td>
             </tr>
              <tr>
                <td>Semestre<span style='color: red;'>*</span></td>
                <td id='Td_Semestres'>
                    <input type="checkbox" id="none" value="" /> 
                </td>
             </tr>
             <tr>
                <td colspan='6' align='center'>
                    <table border='2'>
                        <tr>
                            <td align='center'>Ubicaciones:</td>
                            <td align='center'>Cupos:</td>
                        </tr>
             <?PHP        
             $sqlUbicaciones ="SELECT IdUbicacionInstitucion, u.NombreUbicacion, i.NombreInstitucion from Convenios c JOIN InstitucionConvenios i ON i.InstitucionConvenioId = c.InstitucionConvenioId JOIN UbicacionInstituciones u ON u.InstitucionConvenioId = i.InstitucionConvenioId where ConvenioId = '".$id."' and u.codigoestado='100'";
             $valoresUbicacion = $db->execute($sqlUbicaciones);
             foreach($valoresUbicacion as $datosUbicacion)
             {
                ?>
                    <tr>
                        <td>
                            <li><?PHP echo $datosUbicacion['NombreInstitucion'].' - '.$datosUbicacion['NombreUbicacion']?></li>
                        </td>
                        <td>
                            <input type='text' name='cuposubicacion_[<?PHP echo $datosUbicacion['IdUbicacionInstitucion']?>]' id='cuposubicacion_[<?PHP echo $datosUbicacion['IdUbicacionInstitucion']?>]' required='required' onkeypress="return val_numero(event)"/>
                        </td>
                    </tr>  
              <?PHP      
             }     
             ?>                   
                   </table>
                </td>
             </tr>
             <tr>
                <td>Archivo: </td>
                <td>
                    <input type='hidden' name='archivo' id='archivo' value='100000' />
                    <input type='file' name='dato' id='dato'  accept='.pdf'  />
                </td>
             </tr>
             <tr>
                <td colspan='6'>
                    <hr />
                </td>
             </tr>
        </table>     
        <?PHP
    }//public function Tecnico
    public function Prorroga($db,$id){
        $sqlfechafin="select fechafin from Convenios where ConvenioId = '".$id."'";
        $valoresfechafin= $db->execute($sqlfechafin);
        
        
         $SQL='SELECT
                	idsiq_tipoValorPeriodicidad AS id,
                	nombre
                FROM
                	siq_tipoValorPeriodicidad
                WHERE
                	idsiq_tipoValorPeriodicidad IN (2, 3)
                ORDER BY
                	nombre';
                    
        $Tiempo=$db->Execute($SQL);            
        ?>
       <script type="text/javascript">
    	
       function Calcular(id){
        var fecha = $('#FechaIni').val();
        var valor = $('#NumProrroga').val();
            $.ajax({
                type: 'POST',
                url: 'AnexosConvenios_ajax.php',
                async: false,
                dataType: 'html',
                data:({actionID: 'Calcular',id:id,fecha:fecha,valor:valor}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert(data.descrip);
                        return false;
                    }else{
                       $('#Div_FechaFin').html(data);
                    }
                }
            });
       }
       </script>  
        <table style="width:930px">
            <tr>
                <?PHP $this->Consecutivo();?>
            </tr>    
            <tr>
                <td>Fecha final actual</td>
                <td>
            <?PHP
            foreach($valoresfechafin as $datosfecha)
            {
                ?>
                <input type='text' name='fechafin' id='fechafin' value='<?PHP echo $datosfecha['fechafin']?>' readonly="readonly"/>
                <?PHP    
            }
            ?>
                </td>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <?PHP $this->FechaBox('FechaIni','Fecha Inicial');?>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Prórroga<span style='color: red;'>*</span></td>
                <td>
                    <input type='text' style="text-align: center;" size="3" max="3" name='NumProrroga' id='NumProrroga' required='required' onkeypress="return val_numero(event)" />
                </td>
                <td>Tiempo<span style='color: red;'>*</span></td>
                <td>
                    <select id="Tiempo" name="Tiempo" onchange="Calcular(this.value)">
                        <option value="-1"></option>
                        <?PHP 
                        while(!$Tiempo->EOF){
                            ?>
                            <option value="<?PHP echo $Tiempo->fields['id']?>"><?PHP echo $Tiempo->fields['nombre']?></option>
                            <?PHP
                            $Tiempo->MoveNext();
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                   Fecha Final 
                </td>
                <td>
                    <div style="margin-left:10px;" id="Div_FechaFin"></div>
                </td>
                <td colspan="5">&nbsp;</td>
            </tr>
            <?PHP $this->Modalidad($db);?>
            <tr>
                <td colspan="2">
                    <fieldset>
                        <legend>Observación</legend>
                        <table style="width: 100%;">
                            <tr>
                                <td>
                                    <textarea rows="50" cols="70" id="Observacion" name="Observacion" onkeypress="return val_texto(event)"></textarea>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
            <?PHP $this->FileBox();?>
            <tr>
                <td colspan='6'>
                    <hr />
                </td>
            </tr>
        </table>
        <?PHP 
    }//public function Prorroga
    public function calculaFecha($modo,$valor,$fecha_inicio=false){ 
 
       if($fecha_inicio!=false) {
              $fecha_base = strtotime($fecha_inicio);
       }else {
              $time=time();
              $fecha_actual=date("Y-m-d",$time);
              $fecha_base=strtotime($fecha_actual);
       }
     
       $calculo = strtotime("$valor $modo","$fecha_base");
      
       return date("Y-m-d", $calculo);
     
    }//public function calculaFecha
    public function Adicion($db){
        ?>
        <table style="width:930px">
            <tr>
                <?PHP $this->Consecutivo();?>
            </tr>   
            <?PHP $this->Modalidad($db);?>
            <tr>
                <?PHP $this->FechaBox('FechaIni','Fecha Inicial');?>
            </tr>
            <?PHP $this->FileBox();?>
            <tr>
                <td colspan='6'>
                    <hr />
                </td>
            </tr>
        </table>
        <?PHP
    }//public function Adicion
    public function ModalidadCarreraConvenio($db){
         $sqlModalidad ="SELECT codigomodalidadacademica, nombremodalidadacademica FROM modalidadacademica where codigoestado ='100' AND codigomodalidadacademica='200' OR codigomodalidadacademica='300'";
         $valorModalidad = $db->execute($sqlModalidad);
       
        ?>
        <tr>
            <td>Modalidad Academica</td>
            <td>
                <select id='Modalidad' name='Modalidad' onchange='CarrerasModalidad()' >
                    <option value=''></option>
                    <?PHP
        
         foreach($valorModalidad as $datosModalidad)
         {
            ?>
            <option value="<?PHP echo $datosModalidad['codigomodalidadacademica']?>"><?PHP echo $datosModalidad['nombremodalidadacademica'];?></option>
            <?PHP 
         }
         ?>
               </select>
            </td>
         </tr>
         <tr>
            <td>Carrera</td>
            <td id='Td_Carreras'>
                <select name='carrera' id='carrera'>
                    <option value=''></option>
                </select>
            </td>
        </tr> 
        <?PHP
    }//public function ModalidadCarrera
    public function FechaBox($name,$label){
        ?>
        <script type="text/javascript">
    	$(document).ready( function () {
			   $("#<?PHP echo $name?>").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "dd-mm-yy"
                });
                
               $('#ui-datepicker-div').css('display','none');
       });  
       </script>
        <td><?PHP echo $label?><span style='color: red;'>*</span></td>
        <td>
            <input type='text' name='<?PHP echo $name?>' id='<?PHP echo $name?>' required='required' readonly="readonly" />
        </td>
        <?PHP
    }// public function FechaBox
    public function FileBox(){
        ?>
        <tr>
            <td>Archivo <span style='color: red;'>*</span>:</td>
            <td colspan='5'>
                <input type='hidden' name='archivo' id='archivo' value='100000' />
                <input type='file' name='dato' id='dato' />
            </td>
        </tr>
        <?PHP
    }//public function FileBox
    public function Consecutivo(){
        ?>
        <td>Consecutivo N&deg;</td>
        <td>
            <input type="text" name="Consecutivo" id="Consecutivo" style="text-align: center;" required='required' onkeypress="return val_numero(event)" />
        </td>
        <?PHP
    }//public function Consecutivo
    public function Liquidacion($db){
         ?>
        <table style="width:930px">
            <tr>
                <?PHP $this->FechaBox('FechaFin','Fecha Finalización');?>
            </tr>
            <?PHP $this->FileBox();?>
            <tr>
                <td colspan='6'>
                    <hr />
                </td>
            </tr>
        </table>
        <?PHP
    }//public function Liquidacion
    public function Modificar($db){
        ?>
        <table style="width:930px">
            <tr>
                <?PHP $this->Consecutivo();?>
            </tr>   
            <?PHP $this->ModalidadCarreraConvenio($db);?>
            <tr>
                <?PHP $this->FechaBox('FechaIni','Fecha Inicial');?>
            </tr>
            <?PHP $this->FileBox();?>
            <tr>
                <td colspan='6'>
                    <hr />
                </td>
            </tr>
        </table>
        <?PHP
    }//public function Modificar
    public function Modalidad($db){
        $sqlModalidad ="SELECT codigomodalidadacademica, nombremodalidadacademica FROM modalidadacademica where codigoestado ='100' AND codigomodalidadacademica IN('200','300')";
         $valorModalidad = $db->execute($sqlModalidad);
         
         ?>
        <tr>
            <td>Modalidad Academica</td>
            <td>
                <select id='Modalidad' name='Modalidad' onchange='Carreras(this.value)' >
                    <option value=''></option>
                    <?PHP
                     foreach($valorModalidad as $datosModalidad)
                     {
                        ?>
                        <option value="<?PHP echo $datosModalidad['codigomodalidadacademica']?>"><?PHP echo $datosModalidad['nombremodalidadacademica'];?></option>
                        <?PHP 
                     }
                     ?>
               </select>
            </td>
         </tr>
         <tr>
            <td>Carrera</td>
            <td id='Td_Carrera'>
                <select name='carrera' id='carrera'>
                    <option value=''></option>
                </select>
            </td>
        </tr> 
        <?PHP
    }//public function Modalidad
    public function Carrera($db,$id){
          $SQL='SELECT
                	codigocarrera,
                	nombrecarrera
                FROM
                	carrera
                WHERE
                	codigomodalidadacademica = "'.$id.'"
                AND fechavencimientocarrera >= CURDATE()
                AND codigocarrera <> 1
                ORDER BY
                	nombrecarrera';
                    
         $Carrera = $db->Execute($SQL);
         ?>
         <div style="width:650px;height:150px;overflow:scroll;">
             <ul>
                <?PHP 
                foreach($Carrera as $DataCarrera){
                    ?>
                    <li><?PHP echo $DataCarrera['nombrecarrera']?><div style="text-align: right;width:auto;display: inline-block;float: right;"><input type="checkbox" value="<?PHP echo $DataCarrera['codigocarrera']?>" name="Carrera[]" id="Carrera" /></span></li>
                    <?PHP
                }
                ?>
             </ul>
         </div>
         <?PHP                    
    }//public function Carrera
}//class

?>