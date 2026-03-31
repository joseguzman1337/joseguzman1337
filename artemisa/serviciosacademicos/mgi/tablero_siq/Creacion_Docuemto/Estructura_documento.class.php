<?php
class Estructura_documento{
    public function Principal(){
        global $userid,$db;
        ?>
        <div id="container">
            <h2>Estructurar Documento</h2> 
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend style=" font-size:15px;" class="full_width big"><strong>Construci&oacute;n Del Documento</strong></legend>
                <table border="0" align="center" width="95%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="Border">&nbsp;</td>
                        <td class="Border"><strong>Fecha Inicial de la Vigencia</strong></td>
                        <td class="Border" colspan="2">&nbsp;</td>
                        <td class="Border"><strong>Fecha Final de la Vigencia</strong></td>
                        <td class="Border">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="Border">&nbsp;</td>
                        <td class="Border"><input type="text" name="fechainicio" size="12" id="fechainicio" title="Fecha Inicio" maxlength="12" tabindex="7" placeholder="Fecha Inicio" autocomplete="off" value="<?php echo date('Y-m-d')?>" readonly /></td>
                        <td class="Border" colspan="2">&nbsp;</td>
                        <td class="Border"><input type="text" name="fechafin" size="12" id="fechafin" title="Fecha Fin" maxlength="12" placeholder="Fecha Fin" tabindex="8" autocomplete="off" value="<?php echo date('Y-m-d')?>" readonly /></td>
                        <td class="Border">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="Border">&nbsp;</td>
                        <td class="Border"><strong>Nombre Documento.<span class="mandatory">(*)</span></strong></td>
                        <td class="Border" colspan="2">&nbsp;&nbsp;</td>
                        <td class="Border"><strong>Nombre Entidad a Presentar.<span class="mandatory">(*)</span></strong></td>
                        <td class="Border">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="Border">&nbsp;</td>
                        <td class="Border"><input type="text" class="cajas" id="Nom_Documento" name="Nom_Documento" style="text-align:center" size="70"></td>
                        <td class="Border" colspan="2">&nbsp;&nbsp;</td>
                        <td class="Border"><input type="text" class="cajas" id="Nom_entidad" name="Nom_entidad" style="text-align:center" size="50"></td>
                        <td class="Border">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="Border">&nbsp;</td>
                        <td class="Border"><strong>Tipo de Documento.<span class="mandatory">(*)</span></strong></td>
                        <td class="Border" colspan="2">&nbsp;&nbsp;</td>
                        <td class="Border" id="Td_Facultad" style="visibility:collapse"><strong>Facultad.<span class="mandatory">(*)</span></strong></td>
                        <td class="Border">&nbsp;</td>
                    </tr>
                    <?php
                    $SQL_Discriminacion='SELECT
                            idsiq_discriminacionIndicador as id,
                            nombre
                        FROM  siq_discriminacionIndicador
                        WHERE codigoestado=100';

                    if($Discriminacion=&$db->Execute($SQL_Discriminacion)===false){
                        echo 'Error en el SQL Discriminacion....<br>'.$SQL_Discriminacion;
                        die;
                    }
                    
                    $SQL_falcutad='SELECT 
                            codigofacultad as id,
                            nombrefacultad
                        FROM facultad
                        ORDER BY nombrefacultad ASC';
                    
                    if($Facultad=&$db->Execute($SQL_falcutad)===false){
                        echo 'Error en el SQL Facultad...<br>'.$SQL_falcutad;
                        die;
                    }
                    ?>
                    <tr>
                        <td class="Border">&nbsp;</td>
                        <td class="Border">
                                <select id="Tipo_doc" name="Tipo_doc" style="width:auto" class="cajas" onchange="Ver()">
                                <option value="-1">Elige...</option>
                                <?php
                                    while(!$Discriminacion->EOF){
                                        ?>
                                        <option value="<?php echo $Discriminacion->fields['id']?>"><?php echo $Discriminacion->fields['nombre']?></option>
                                        <?php
                                        $Discriminacion->MoveNext();
                                    }
                                ?>
                            </select>
                        </td>
                        <td class="Border" colspan="2">&nbsp;&nbsp;</td>
                        <td class="Border">
                        <div id="Div_Facultad" style="display:none">
                            <select id="Faculta_id" name="Faculta_id"  style="width:auto" class="cajas">
                                <option value="-1">Elige...</option>
                                    <?php
                                        while(!$Facultad->EOF){
                                            ?>
                                            <option value="<?php echo $Facultad->fields['id']?>" onclick="VerPrograma(<?php echo $Facultad->fields['id']?>)"><?php echo $Facultad->fields['nombrefacultad']?></option>
                                            <?php
                                            $Facultad->MoveNext();	
                                        }
                                    ?>
                                </option>
                            </select> 
                        </div>     
                        </td>
                        <td class="Border">&nbsp;</td>
                    </tr>
                    <tr>
                        <td  colspan="6" align="center" > 
                            <table class="Border" align="center">
                                <tr>
                                    <td id="Contenedor_Td" style="visibility:collapse"><strong>Programa: <span class="mandatory">(*)</span></strong></td>
                                </tr>
                                <tr>
                                    <td><div id="Carga"></div></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="Border" colspan="2">&nbsp;</td>
                        <td class="Border" colspan="2" align="center"><input type="button" id="Buscar_Factores" name="Buscar_Factores" value="Buscar Factores." class="first" onClick="BuscarFactores()"></td>
                        <td class="Border" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="Border" colspan="6">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="Border" colspan="6" align="center">
                                <div id="DivCargar" align="left"></div>
                        </td>
                    </tr>
                </table>
         </fieldset> 
        </div>   
        <?php
    }
    public function BuscarFactoresInstitucionales($Tipo_doc, $Estructura_id){
        global $userid,$db;
        
        $SQL_Institucional='SELECT
                ind.idsiq_indicador, 
                ind.idIndicadorGenerico,
                indGen.idsiq_indicadorGenerico,
                indGen.nombre,
                indGen.idAspecto,
                asp.idsiq_aspecto,
                asp.idCaracteristica,
                Cart.idsiq_caracteristica,
                Cart.idFactor,
                fac.idsiq_factor,
                fac.nombre as Nom_Factor
            FROM siq_indicador as ind 
            INNER JOIN siq_indicadorGenerico as indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
            INNER JOIN siq_aspecto as asp ON indGen.idAspecto=asp.idsiq_aspecto
            INNER JOIN siq_caracteristica as Cart ON asp.idCaracteristica=Cart.idsiq_caracteristica
            INNER JOIN siq_factor  as fac ON Cart.idFactor=fac.idsiq_factor
            WHERE ind.discriminacion="'.$Tipo_doc.'"
                AND ind.codigoestado=100
                AND indGen.codigoestado=100
                AND asp.codigoestado=100
                AND Cart.codigoestado=100
                AND fac.codigoestado=100
            GROUP BY fac.idsiq_factor';
        //d($SQL_Institucional);
								
        if($Factores_institucionales=&$db->Execute($SQL_Institucional)===false){
            echo 'Error en el SQL Factores Institucionales....<br>'.$SQL_Institucional;
            die;
        }
        if($Factores_institucionales->EOF){
            ?>
            <span style="color:#666666; font-family:'Times New Roman', Times, serif; font-size:24px; text-align:center">No hay Informaci&oacute;n</span>
            <?php
        }
        ?>
        <fieldset>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="90%">
                <tr>
                    <td class="Border">
                    <div id="fastLiveFilter" >
                        <input class="filter_input" placeholder="Buscar Factor..">
                        <ul id="sortable1" class="connectedSortable">
                            <?php 
                                $i =0;
                                while(!$Factores_institucionales->EOF){
                                    ?>
                                    <script>				
                                        $(function() {
                                            $('#search_input').fastLiveFilter('#sortablexxx<?php echo $i?>');
                                        });
                                        $(function() {
                                            $( "#sortablexxx<?php echo $i?>" ).sortable().disableSelection();  
                                        });
                                        $(function() { 
                                            $( "#dialog-form_<?php echo $i?>" ).dialog({
                                                autoOpen: false,
                                                height: 400,
                                                width: 800,
                                                modal: true,
                                                position: 'center',
                                                buttons: {
                                                    "Save": function() {
                                                        var list = $("#sortablexxx<?php echo $i?>").sortable('toArray');
                                                        var Factor_id = $('#Factor_id_<?php echo $i?>').val();
                                                        $('#Cadena_<?php echo $i?>').val(Factor_id+'-'+list);
                                                        $(this).dialog( "close" );
                                                    },
                                                    Cancel: function() {
                                                        $( this ).dialog( "close" );
                                                    }
                                                },
                                                close: function() {
                                                    allFields.val( "" ).removeClass( "ui-state-error" );
                                                }
                                            });

                                            $( "#Indi_ver_<?php echo $i?>" ).click(function() {
                                                if($(this).is(":checked")){
                                                    $( "#dialog-form_<?php echo $i?>" ).dialog( "open" );                        
                                                }else{
                                                    $('.hijoCheck_<?php echo $i?>').attr('checked',false);
                                                    $('#Cadena_<?php echo $i?>').val('');
                                                    $('#Cadena_hijo_<?php echo $i?>').val('');
                                                }
                                            });
                                            $( "#Open_<?php echo $i?>" ).click(function() {
                                                $( "#dialog-form_<?php echo $i?>" ).dialog( "open" );
                                            });	
                                        });
                                    </script>
                                    <li class="ui-state-default" style="text-align:left; width:auto;cursor:pointer; height:auto" id="<?php echo $Factores_institucionales->fields['idsiq_factor']?>" ><span class="ui-icon ui-icon-arrowthick-2-n-s" id="Open_<?php echo $i?>" title="Editar Indicadores del Factor"></span><?php echo $i+1?>.&nbsp;<?php echo $Factores_institucionales->fields['Nom_Factor']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  type="checkbox" id="Indi_ver_<?php echo $i?>" onClick="Add(<?php echo $i?>,'<?php echo $Factores_institucionales->fields['idsiq_factor']?>')"></li>
                                    <?php $this->Dialogo($i,$Factores_institucionales->fields['idsiq_factor'],$Tipo_doc);?>
                                    <?php
                                    $Factores_institucionales->MoveNext();
                                    $i++;
                                }
                            ?>
                        </ul>
                     </div>   
                    </td>
                </tr>
                <tr>
                    <td class="Border">
                        <input type="hidden" id="Cadena_padre">
                        <input type="hidden" id="index_Padre" value="<?php echo $i?>">
                        <input type="hidden" name="Estructura_id" id="Estructura_id" value="<?php echo $Estructura_id?>">
                        <input type="hidden" id="CadenaListaPadre">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" id="CadenaPadreFin"><br><input type="hidden" id="CadenaHijoFin">
                    </td>
                </tr>
                <tr>
                    <td><input type="button" value="..Guardar Estructura Institucional.." onClick="Save();"  class="first" /></td>
                </tr>
            </table>
        </fieldset>
        <?php
    }
    
    public function BuscarFactoresPrograma($Tipo_doc,$Programa_id, $Estructura_id){
        global $userid,$db;
        
        $SQL_Programa='SELECT
                ind.idsiq_indicador, 
                ind.idIndicadorGenerico,
                indGen.idsiq_indicadorGenerico,
                indGen.nombre,
                indGen.idAspecto,
                asp.idsiq_aspecto,
                asp.idCaracteristica,
                Cart.idsiq_caracteristica,
                Cart.idFactor,
                fac.idsiq_factor,
                fac.nombre as Nom_Factor,
                indGen.area
            FROM siq_indicador as ind 
            INNER JOIN siq_indicadorGenerico as indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
            INNER JOIN siq_aspecto as asp ON indGen.idAspecto=asp.idsiq_aspecto
            INNER JOIN siq_caracteristica as Cart ON asp.idCaracteristica=Cart.idsiq_caracteristica
            INNER JOIN siq_factor  as fac ON Cart.idFactor=fac.idsiq_factor
            WHERE (ind.discriminacion="'.$Tipo_doc.'" OR ind.discriminacion=1)
                AND ind.idCarrera="'.$Programa_id.'"
                AND ind.codigoestado=100
                AND indGen.codigoestado=100
                AND asp.codigoestado=100
                AND Cart.codigoestado=100
                AND fac.codigoestado=100 OR indGen.area=1
            GROUP BY fac.idsiq_factor
            ORDER BY fac.idsiq_factor';

        if($Factores_Programa=&$db->Execute($SQL_Programa)===false){
            echo 'Error en el SQL Factores Programa....<br>'.$SQL_Programa;
            die;
        }
        
        if($Factores_Programa->EOF){
            ?>
            <span style="color:#666666; font-family:'Times New Roman', Times, serif; font-size:24px; text-align:center">No hay Informaci&oacute;n</span>
            <?php
        }			
        ?>
        <fieldset>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="90%" class="Border">
                <tr>
                    <td class="Border">
                        <div id="fastLiveFilter" >
                            <input class="filter_input" placeholder="Buscar Factor..">
                            <ul id="sortable1" class="connectedSortable">
                            <?php 
                                $i =0;
                                while(!$Factores_Programa->EOF){
                                    ?>
                                    <script>
                                        $(function() {
                                                $('#search_input').fastLiveFilter('#sortablexxx<?php echo $i?>');
                                        });
                                        $(function() {
                                                $( "#sortablexxx<?php echo $i?>" ).sortable().disableSelection();  
                                        });

                                        $(function() {
                                            $( "#dialog-form_<?php echo $i?>" ).dialog({
                                                autoOpen: false,
                                                height: 400,
                                                width: 800,
                                                modal: true,
                                                position: 'center',
                                                buttons: {
                                                    "Save": function() {
                                                        var list = $("#sortablexxx<?php echo $i?>").sortable('toArray');
                                                        var Factor_id = $('#Factor_id_<?php echo $i?>').val();
                                                        $('#Cadena_<?php echo $i?>').val(Factor_id+'-'+list);


                                                        $(this).dialog( "close" );
                                                    },
                                                    Cancel: function() {
                                                        $( this ).dialog( "close" );
                                                    }
                                                },
                                                close: function() {
                                                    allFields.val( "" ).removeClass( "ui-state-error" );
                                                }
                                            });

                                            $( "#Indi_ver_<?php echo $i?>" ).click(function() {
                                                if($(this).is(":checked")){
                                                    $( "#dialog-form_<?php echo $i?>" ).dialog( "open" );                        
                                                }else{
                                                    $('.hijoCheck_<?php echo $i?>').attr('checked',false);
                                                    $('#Cadena_<?php echo $i?>').val('');
                                                    $('#Cadena_hijo_<?php echo $i?>').val('');
                                                }
                                            });

                                            $( "#Open_<?php echo $i?>" ).click(function() {
                                                $( "#dialog-form_<?php echo $i?>" ).dialog( "open" );                        

                                            });	
                                        });
                                    </script>
                                    <li class="ui-state-default" style="text-align:left; width:auto;cursor:pointer; height:auto" id="<?php echo $Factores_Programa->fields['idsiq_factor']?>" ><span class="ui-icon ui-icon-arrowthick-2-n-s" id="Open_<?php echo $i?>" title="Editar Indicadores del Factor"></span><?php echo $i+1?>.&nbsp;<?php echo $Factores_Programa->fields['Nom_Factor'].''?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  type="checkbox" id="Indi_ver_<?php echo $i?>" onClick="Add(<?php echo $i?>,'<?php echo $Factores_Programa->fields['idsiq_factor']?>')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                                    <?php $this->DialogoPrograma($i,$Factores_Programa->fields['idsiq_factor'],$Tipo_doc,$Programa_id);#,$Factores_Programa->fields['area']?>
                                    <?php
                                    $Factores_Programa->MoveNext();
                                    $i++;
                                }
                            ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="Border">
                        <input type="hidden" id="Cadena_padre">
                        <input type="hidden" id="index_Padre" value="<?php echo $i?>">
                        <input type="hidden" name="Estructura_id" id="Estructura_id" value="<?php echo $Estructura_id?>">
                        <input type="hidden" id="CadenaListaPadre">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" id="CadenaPadreFin"><br><input type="hidden" id="CadenaHijoFin">
                    </td>
                </tr>
                <tr>
                    <td><input type="button" value="..Guardar Estructura Programa.." onClick="Save();" class="first"/></td>
                </tr>
            </table>
        </fieldset>
        <?php
    }	
		
    public function Gestion(){
        global $userid,$db;
        ?>
        <div id="container">
            <h1>Administracion de la Estructura de los Documentos.</h1>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar</span>
                    </button>
                    <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Eliminar</span> 
                    </button>
                    <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Duplicar</span> 
                    </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                            
                            <th>Nombre del Documento</th>
                            <th>Nombre de la Entidad</th>
                            <th>Tipo de Documento</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Fecha Inicial de Vigencia</th>
                            <th>Fecha Final de Vigencia</th>
                            <th>Fecha Creaci&oacute;n Documento</th>
                        </tr>
                    </thead>
                    <tbody>                       
                    </tbody>
                </table>
            </div>
        </div>            
        <?php	
    }	
	
    public function Editar($id){
        global $userid, $db;

        $SQL_Estructura='SELECT 
                Estru.idsiq_estructuradocumento,
                Estru.nombre_documento, 
                Estru.nombre_entidad , 
                dis.nombre, 
                date(Estru.entrydate) AS fecha ,
                Estru.tipo_documento,
                Estru.id_carrera,
                Estru.fechainicial,
                Estru.fechafinal
            FROM siq_estructuradocumento AS Estru 
            INNER JOIN siq_discriminacionIndicador AS dis ON Estru.tipo_documento=dis.idsiq_discriminacionIndicador 
            WHERE Estru.codigoestado=100 
                AND dis.codigoestado=100
                AND Estru.idsiq_estructuradocumento="'.$id.'"';
        
        if($Estructura=&$db->Execute($SQL_Estructura)===false){
            echo 'Error en el SQl ....de la Estructura.......<br>'.$SQL_Estructura;
            die;
        }
        ?>
        <br /><br />
        <div style="font-size:44px; font-family:'Times New Roman', Times, serif"><strong>Editar Estructura del Documento.</strong></div>
        <span class="mandatory">* Son campos obligatorios</span>
        <fieldset>
            <legend>Información de la Estructura.</legend>
            <table class="Border" align="center" width="90%" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="Border">&nbsp;</td>
                    <td class="Border"><strong>Fecha Inicial de la Vigencia</strong></td>
                    <td class="Border" colspan="2">&nbsp;</td>
                    <td class="Border"><strong>Fecha Final de la Vigencia</strong></td>
                    <td class="Border">&nbsp;</td>
                </tr>
                <tr>
                    <td class="Border">&nbsp;</td>
                    <td class="Border"><input type="text" name="fechainicio" size="12" id="fechainicio" title="Fecha Inicio" maxlength="12" tabindex="7" placeholder="Fecha Inicio" autocomplete="off" value="<?php echo $Estructura->fields['fechainicial']?>" readonly /></td>
                    <td class="Border" colspan="2">&nbsp;</td>
                    <td class="Border"><input type="text" name="fechafin" size="12" id="fechafin" title="Fecha Fin" maxlength="12" placeholder="Fecha Fin" tabindex="8" autocomplete="off" value="<?php echo $Estructura->fields['fechafinal']?>" readonly /></td>
                    <td class="Border">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;<input type="hidden" id="Estructura_id" value="<?php echo $id?>" /><input type="hidden" id="tipo" value="<?php echo $Estructura->fields['tipo_documento']?>" /><input type="hidden" id="Programa" value="<?php echo $Estructura->fields['id_carrera']?>" /></td>
                    <td><strong>Nombre Documento.<span class="mandatory">(*)</span></strong></td>
                    <td colspan="2">&nbsp;&nbsp;</td>
                    <td><strong>Nombre Entidad a Presentar.<span class="mandatory">(*)</span></strong></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="text" class="cajas" id="Nom_Documento" name="Nom_Documento" style="text-align:center" size="70" value="<?php echo $Estructura->fields['nombre_documento']?>"></td>
                    <td colspan="2">&nbsp;&nbsp;</td>
                    <td><input type="text" class="cajas" id="Nom_entidad" name="Nom_entidad" style="text-align:center" size="50" value="<?php echo $Estructura->fields['nombre_entidad']?>"></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><strong>Tipo de Documento.<span class="mandatory">(*)</span></strong></td>
                    <td colspan="2">&nbsp;&nbsp;</td>
                    <td id="Td_Facultad" style="visibility:collapse"><strong>Facultad.<span class="mandatory">(*)</span></strong></td>
                    <td>&nbsp;</td>
                </tr>
                <?php
                $SQL_Discriminacion='SELECT  
                        idsiq_discriminacionIndicador as id,
                        nombre
                    FROM siq_discriminacionIndicador
                    WHERE
                        codigoestado=100';
                
                if($Discriminacion=&$db->Execute($SQL_Discriminacion)===false){
                    echo 'Error en el SQL Discriminacion....<br>'.$SQL_Discriminacion;
                    die;
                }
                
                $SQL_falcutad='SELECT 
                        codigofacultad as id,
                        nombrefacultad
                    FROM facultad
                    ORDER BY nombrefacultad ASC';
                
                if($Facultad=&$db->Execute($SQL_falcutad)===false){
                    echo 'Error en el SQL Facultad...<br>'.$SQL_falcutad;
                    die;
                }
                
                $SQL_falcutad_Edit='SELECT
                        carrera.codigocarrera ,
                        carrera.nombrecarrera,
                        facultad.codigofacultad,
                        facultad.nombrefacultad
                    FROM carrera,
                        facultad
                    WHERE carrera.codigofacultad=facultad.codigofacultad
                        AND carrera.codigocarrera="'.$Estructura->fields['id_carrera'].'"';
                
                if($Facultad_Ex=&$db->Execute($SQL_falcutad_Edit)===false){
                    echo 'Error en el SQL Facultad...<br>'.$SQL_falcutad;
                    die;
                }					

                if($Estructura->fields['tipo_documento']==3){
                    $Style = '';
                    $Style_Td = '';
                }else{
                    $Style = 'style="display:none"';
                    $Style_Td = 'style="visibility:collapse"';
                }							

                ?>
                <tr>
                    <td class="Border">&nbsp;</td>
                    <td class="Border">
                        <select id="Tipo_doc" name="Tipo_doc" style="width:auto" class="cajas" onchange="Ver()" disabled="disabled">
                           <option value="<?php echo $Estructura->fields['tipo_documento']?>"><?php echo $Estructura->fields['nombre']?></option>
                           <?php 
                           while(!$Discriminacion->EOF){
                               if($Estructura->fields['tipo_documento']!=$Discriminacion->fields['id']){
                                   ?>
                                   <option value="<?php echo $Discriminacion->fields['id']?>"><?php echo $Discriminacion->fields['nombre']?></option>
                                   <?php
                                }
                                $Discriminacion->MoveNext();
                            }
                            ?>
                       </select>
                    </td>
                    <td class="Border" colspan="2">&nbsp;&nbsp;</td>
                    <td class="Border">
                        <div id="Div_Facultad" <?php echo $Style?>>
                            <select id="Faculta_id" name="Faculta_id"  style="width:auto" class="cajas" disabled="disabled"> 
                                <option value="<?php echo $Facultad_Ex->fields['codigofacultad']?>"><?php echo $Facultad_Ex->fields['nombrefacultad']?></option>
                                <?php
                                while(!$Facultad->EOF){
                                    if($Facultad_Ex->fields['id']!=$Facultad->fields['id']){
                                        ?>
                                        <option value="<?php echo $Facultad->fields['id']?>" onclick="VerPrograma(<?php echo $Facultad->fields['id']?>)"><?php echo $Facultad->fields['nombrefacultad']?></option>
                                        <?php
                                    }
                                    $Facultad->MoveNext();
                                }
                                ?>
                                </option>
                            </select> 
                        </div>     
                    </td>
                    <td class="Border">&nbsp;</td>
                </tr>
                <tr>
                    <td  colspan="6" align="center" > 
                        <table class="Border" align="center">
                            <tr>
                                <td id="Contenedor_Td" <?php echo $Style_Td?>><strong>Programa: <span class="mandatory">(*)</span></strong></td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="Carga">
                                        <?php
                                        if($Estructura->fields['tipo_documento']==3){
                                            $SQL='SELECT
                                                    codigocarrera as id,
                                                    nombrecarrera
                                                FROM carrera
                                                WHERE codigofacultad="'.$Facultad_Ex->fields['codigofacultad'].'"
                                                ORDER BY nombrecarrera ASC';

                                            if($Select_Option=&$db->Execute($SQL)===false){
                                                echo 'Error en el SQL Secte del Ajax...<br>'.$SQL;
                                                die;
                                            }
                                            ?>   
                                            <select id="Programa_id" name="Programa_id" class="cajas" style="width:auto" disabled="disabled">
                                                <option value="<?php echo $Facultad_Ex->fields['codigocarrera']?>"><?php echo $Facultad_Ex->fields['nombrecarrera']?></option>
                                                <?php 
                                                while(!$Select_Option->EOF){
                                                    if($Facultad_Ex->fields['codigocarrera']!=$Select_Option->fields['id']){
                                                    ?>
                                                    <option value="<?php echo $Select_Option->fields['id']?>"><?php echo $Select_Option->fields['nombrecarrera']?></option>
                                                    <?php
                                                    }
                                                    $Select_Option->MoveNext();
                                                }
                                                ?>
                                            </select>
                                            <?php
                                        }
                                        ?>		                                                
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="Border" colspan="2" align="left"><input type="button" id="Buscar_Factores" name="Buscar_Factores" value="Agregar Factores" class="first" onClick="BuscarFactores()"></td>
                    <td class="Border" colspan="2">&nbsp;</td>
                    <td class="Border" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center"><input type="radio" name="VerOpcion" id="Factores" onclick="EditarContenido()" />&nbsp;&nbsp;<strong>Ver Factores</strong></td>
                    <td colspan="2">&nbsp;</td>
                    <td align="center"><input type="radio" name="VerOpcion" id="Indicadores" onclick="EditarContenido()"  />&nbsp;&nbsp;<strong>Ver Indicadores</strong></td>
                    <td>&nbsp;</td>
                </tr>
                
                <tr>
                    <td class="Border" colspan="6" align="center">
                            <div id="DivCargar" align="left"></div>
                    </td>
                </tr>
            </table>
        </fieldset>
        <br /><br /><div align="center"><input type="button" id="Update_in" value="Guardar Cambio" onClick="Update(<?php echo $id?>)" class="first"/></div><br /><br />
        <?php
    }
    
    public function Factores($id,$tipo,$programa){
        global $userid, $db;
        ?>
        <fieldset>
            <table class="Border" align="center" width="80%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center"><div id="DivMasFactor"></div></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                    <tr>
                    <td align="center">
                        <div id="DivFactor" style="display:block;"><?php $this->FactorEdit($id)?></div>
                        <input type="hidden" id="Cadena_List" />
                    </td>                       	 
                 </tr>
                <tr>
                    <td align="center"><input type="button" value="..Guardar Cambio.." onClick="Modifcar(<?php echo $id?>)" class="first"/></td>
                </tr>
            </table>
        </fieldset>
        <?php
    }
    
    public function Indicadores($id,$tipo,$programa){
        global $userid, $db;
        
        $SQL_Factore_Estructura='SELECT 
                Estru_Fac.idsiq_factoresestructuradocumento as id,
                fac.nombre,
                fac.idsiq_factor
            FROM siq_factoresestructuradocumento AS Estru_Fac 
            INNER JOIN siq_factor AS fac ON Estru_Fac.factor_id=fac.idsiq_factor 
            WHERE Estru_Fac.idsiq_estructuradocumento="'.$id.'" 
                AND Estru_Fac.codigoestado=100 AND fac.codigoestado=100 
            ORDER BY Estru_Fac.Orden ASC';

        if($Factor_Estructura=&$db->Execute($SQL_Factore_Estructura)===false){
            echo 'Error en el SQL del los Factores de la Estructura.....<br>'.$SQL_Factore_Estructura;
            die;
        }
        ?>
        <fieldset>
            <table class="Border" align="center" width="80%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div id="DivMasIndicadores"></div>
                    </td>
                </tr>
                    <?php
                    $i=0; 
                    while(!$Factor_Estructura->EOF){
                        ?>
                        <style>
                            #sortable_Indicador_ { list-style-type: none; margin: 0; padding: 0; width: 60%; }
                            #sortable_Indicador_ li{ margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
                            #sortable_Indicador_ li span{ position: absolute; margin-left: -1.3em; }
                        </style>
                        <script>
                            $(function() {
                                $( "#sortable_Indicador_<?php echo $i?>" ).sortable();//{connectWith: ".connectedSortable"} .disableSelection()
                            });
                        </script>
                        <tr>
                            <td align="left"><strong><?php echo $i+1?>.&nbsp;&nbsp;<?php echo $Factor_Estructura->fields['nombre']?><input type="hidden" id="Factor_id_<?php echo $i?>" value="<?php echo $Factor_Estructura->fields['id']?>"</strong></td>
                        </tr>
                        <tr>      
                            <td align="center">
                                <fieldset>
                                    <ul id="sortable_Indicador_<?php echo $i?>" class="connectedSortable">
                                        <?php 
                                        $this->IndicadoresEdit($i,$id,$Factor_Estructura->fields['id']);
                                        ?>
                                    </ul>
                                </fieldset>  
                                <input type="hidden" id="Cadena_ind_<?php echo $i?>" />   
                            </td>
                        </tr>
                        <?php
                        $i++;
                        $Factor_Estructura->MoveNext();
                    }
                    ?>
                <tr>
                    <td align="center"><input type="hidden" id="index" value="<?php echo $i?>" /><input type="button" value="..Guardar Cambio.." onClick="ModificarInd(<?php echo $id?>)" class="first"/><input type="hidden" id="Cadena_UP" /><input type="hidden" id="Cadena_temp" /></td>
                </tr>
            </table>
        </fieldset>
        <?php
    }
    
    public function Dialogo($i,$Factores_id,$Tipo_doc){
        global $userid, $db;
        ?>
        <script type="text/javascript" language="javascript" src="../../js/jquery.fastLiveFilter.js"></script>
        <div id="dialog-form_<?php echo $i?>" title="Estructurar Indicadores Institucionales">
            <fieldset>
                <input type="hidden" id="Factor_id_<?php echo $i?>" value="<?php echo $Factores_id?>"><br>
                <input type="hidden" id="Cadena_<?php echo $i?>" >
                <?php 
                $SQL_Indicadores='SELECT 
                        ind.idsiq_indicador, 
                        ind.idIndicadorGenerico, 
                        indGen.idsiq_indicadorGenerico, 
                        indGen.nombre,
                        indGen.codigo
                    FROM siq_indicador as ind 
                    INNER JOIN siq_indicadorGenerico as indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                    INNER JOIN siq_aspecto as asp ON indGen.idAspecto=asp.idsiq_aspecto 
                    INNER JOIN siq_caracteristica as Cart ON asp.idCaracteristica=Cart.idsiq_caracteristica 
                    INNER JOIN siq_factor as fac ON Cart.idFactor=fac.idsiq_factor
                    WHERE ind.discriminacion="'.$Tipo_doc.'"
                        AND fac.idsiq_factor="'.$Factores_id.'" 
                        AND ind.codigoestado=100 
                        AND indGen.codigoestado=100 
                        AND asp.codigoestado=100 
                        AND Cart.codigoestado=100 
                        AND fac.codigoestado=100 
                    GROUP BY indGen.idsiq_indicadorGenerico';
                //d($SQL_Indicadores);
                if($Indicadores=&$db->Execute($SQL_Indicadores)===false){
                    echo 'Error en el SQL Indicadores......<br>'.$SQL_Indicadores;
                    die;
                }

                if($Indicadores->EOF){
                    ?>
                    <span style="color:#666; font-family:'Times New Roman', Times, serif; font-size:24px; text-align:center">No hay Infirmaci&oacute;n</span>
                    <?php
                }				
                ?>

                <input id="search_input" placeholder="Buscar Indicador..">
                <ul id="sortablexxx<?php echo $i?>" >
                    <?php 
                        $t = 0;
                        while(!$Indicadores->EOF){
                            ?>
                             <li class="ui-state-default" style="text-align:left; width:auto;cursor:pointer; font-size:12px; height:auto" id="<?php echo $Indicadores->fields['idsiq_indicador']?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $t+1?>.&nbsp;<?php echo $Indicadores->fields['codigo'].'-'.$Indicadores->fields['nombre']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="item_<?php echo $i?>_<?php echo $t?>" onClick="Add_hijo(<?php echo $t?>,'<?php echo $Indicadores->fields['idsiq_indicador']?>','<?php echo $i?>')" class="hijoCheck_<?php echo $i?>"></li>	
                            <?php
                            $Indicadores->MoveNext();
                            $t++;
                            }
                    ?>
                </ul>
                <input type="hidden" id="Cadena_hijo_<?php echo $i?>"><input type="hidden" id="index_hijo_<?php echo $i?>" value="<?php echo $t?>">  
            </fieldset>
        </div>
        <?php
    }
    
    public function DialogoPrograma($i,$Factores_id,$Tipo_doc,$Programa_id){
        global $userid, $db;
        ?>
        <div id="dialog-form_<?php echo $i?>" title="Estructurar Indicadores Institucionales">
            <fieldset>
                <input type="hidden" id="Factor_id_<?php echo $i?>" value="<?php echo $Factores_id?>"><br>
                <input type="hidden" id="Cadena_<?php echo $i?>" >
                <?php
                $SQL_Indicadores='SELECT 
                        ind.idsiq_indicador, 
                        ind.idIndicadorGenerico, 
                        indGen.idsiq_indicadorGenerico, 
                        indGen.nombre,
                        indGen.area,
                        indGen.codigo  

                    FROM siq_indicador as ind 
                    INNER JOIN siq_indicadorGenerico as indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                    INNER JOIN siq_aspecto as asp ON indGen.idAspecto=asp.idsiq_aspecto 
                    INNER JOIN siq_caracteristica as Cart ON asp.idCaracteristica=Cart.idsiq_caracteristica 
                    INNER JOIN siq_factor as fac ON Cart.idFactor=fac.idsiq_factor
                    WHERE ind.discriminacion="'.$Tipo_doc.'" 
                        AND ind.idCarrera="'.$Programa_id.'"
                        AND fac.idsiq_factor="'.$Factores_id.'" 
                        AND ind.codigoestado=100 
                        AND indGen.codigoestado=100 
                        AND asp.codigoestado=100 
                        AND Cart.codigoestado=100 
                        AND fac.codigoestado=100 OR indGen.area=1
                    GROUP BY indGen.idsiq_indicadorGenerico';
                //d($SQL_Indicadores);
                if($Indicadores=&$db->Execute($SQL_Indicadores)===false){
                    echo 'Error en el SQL Indicadores......<br>'.$SQL_Indicadores;
                    die;
                }

                if($Indicadores->EOF){
                    ?>
                    <span style="color:#666; font-family:'Times New Roman', Times, serif; font-size:24px; text-align:center">No hay Infirmaci&oacute;n</span>
                    <?php
                }
                ?>
                <input id="search_input" placeholder="Buscar Indicador..">
                <ul id="sortablexxx<?php echo $i?>">
                    <?php 
                    $t = 0;
                    while(!$Indicadores->EOF){
                        if($Indicadores->fields['area']==1){
                            $Nombre_Institucional = 'Institucional.';
                        }else{
                            $Nombre_Institucional = '';
                        }
                        ?>
                        <li class="ui-state-default" style="text-align:left; width:auto;cursor:pointer; font-size:12px; height:auto" id="<?php echo $Indicadores->fields['idsiq_indicador']?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $t+1?>.&nbsp;<?php echo $Indicadores->fields['codigo'].'-'.$Indicadores->fields['nombre']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#FF0000; font-size:10px"><?php echo $Nombre_Institucional?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="item_<?php echo $i?>_<?php echo $t?>" onClick="Add_hijo(<?php echo $t?>,'<?php echo $Indicadores->fields['idsiq_indicador']?>','<?php echo $i?>')" class="hijoCheck_<?php echo $i?>"></li>	
                        <?php
                        $Indicadores->MoveNext();
                        $t++;
                    }
                    ?>
                </ul>
                <input type="hidden" id="Cadena_hijo_<?php echo $i?>"><input type="hidden" id="index_hijo_<?php echo $i?>" value="<?php echo $t?>">  
            </fieldset>
        </div>
        <?php
    }
    
    public function Buscar_Factores($id,$tipo,$programa){
        global $userid, $db;

        if($programa!=0){
            $ProgramaBusca = '   AND  ind.idCarrera="'.$programa.'"';
        }else{
            $ProgramaBusca ='';
        }
        
        $SQL_MasFactores='SELECT
                fac.idsiq_factor,
                fac.nombre as Nom_Factor
            FROM siq_indicador as ind 
            INNER JOIN siq_indicadorGenerico as indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
            INNER JOIN siq_aspecto as asp ON indGen.idAspecto=asp.idsiq_aspecto
            INNER JOIN siq_caracteristica as Cart ON asp.idCaracteristica=Cart.idsiq_caracteristica
            INNER JOIN siq_factor  as fac ON Cart.idFactor=fac.idsiq_factor
            WHERE ind.discriminacion="'.$tipo.'"
                AND ind.codigoestado=100
                AND indGen.codigoestado=100
                AND asp.codigoestado=100
                AND Cart.codigoestado=100
                AND fac.codigoestado=100
                AND fac.idsiq_factor NOT IN (   SELECT fac.idsiq_factor
                                                FROM siq_factoresestructuradocumento AS Estru_Fac 
                                                INNER JOIN siq_factor AS fac ON Estru_Fac.factor_id=fac.idsiq_factor
                                                WHERE Estru_Fac.idsiq_estructuradocumento="'.$id.'" 
                                                    AND Estru_Fac.codigoestado=100
                                                    AND fac.codigoestado=100)'
                .$ProgramaBusca.'
                GROUP BY fac.idsiq_factor';
								
								
        if($Factores_Mas=&$db->Execute($SQL_MasFactores)===false){
            echo 'Error en el SQL Mas Factores....<br>'.$SQL_MasFactores;
            die;
        }
        ?>
        <script>
            $(function() {
                $('#search_input').fastLiveFilter('#sortable_F');
            });
        </script>
        <fieldset>
            <br /><br />  
            <table class="Border" width="90%" align="center">
             	<tr>
                    <td align="left"><input id="search_input" placeholder="Buscar Factor.."></td>
                </tr>
                <tr>
                    <td>
                    	<ul id="sortable_F" class="connectedSortable">
                            <?php
                            if($Factores_Mas->EOF){
                                ?>
                                <span style="color:#999999; font-size:14px"><strong>No Hay Factores Disponibles</strong></span>
                                <?php
                            }else{
                                $i = 0;
                                while(!$Factores_Mas->EOF){
                                    ?>
                                    <script>
                                        $(function() {
                                            $( "#sortableZZZ_<?php echo $i?>" ).sortable().disableSelection();  
                                        });
												
                                        $(function() {
                                            $( "#dialog-form_<?php echo $i?>" ).dialog({
                                                autoOpen: false,
                                                height: 400,
                                                width: 800,
                                                modal: true,
                                                position: 'center',
                                                buttons: {
                                                    "Save": function() {
                                                        var list = $("#sortableZZZ_<?php echo $i?>").sortable('toArray');
                                                        var Factor_id = $('#Factor_id_<?php echo $i?>').val();
                                                        $('#Cadena_<?php echo $i?>').val(Factor_id+'-'+list);
                                                        $(this).dialog( "close" );
                                                    },
                                                    Cancel: function() {
                                                        $( this ).dialog( "close" );
                                                    }
                                                },
                                                close: function() {
                                                    allFields.val( "" ).removeClass( "ui-state-error" );
                                                }
                                            });

                                            $( "#item_<?php echo $i?>" ).click(function() {
                                                if($(this).is(":checked")){
                                                    $( "#dialog-form_<?php echo $i?>" ).dialog( "open" );                        
                                                }else{
                                                    $('.hijoCheck_<?php echo $i?>').attr('checked',false);
                                                    $('#Cadena_<?php echo $i?>').val('');
                                                    $('#Cadena_hijo_<?php echo $i?>').val('');
                                                }
                                            });

                                            $( "#Open_<?php echo $i?>" ).click(function() {
                                                $( "#dialog-form_<?php echo $i?>" ).dialog( "open" );

                                            });	
                                        });
                                    </script>
                                    <li class="ui-state-default" style="text-align:left; width:auto;cursor:pointer; font-size:12px; height:auto" id="<?php echo $Factores_Mas->fields['idsiq_factor']?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $i+1?>.&nbsp;<?php echo $Factores_Mas->fields['Nom_Factor'].'&nbsp;&nbsp;<span style="color:#F00">Agregado.</span>'?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="item_<?php echo $i?>"  onClick="NuevoFactor(<?php echo $Factores_Mas->fields['idsiq_factor']?>,'<?php echo $id?>','<?php echo $i?>')"  ></li>
                                    <?php
                                    $Factores_Mas->MoveNext();
                                    $i++;
                                }
                            }
                            ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </fieldset>								
        <?php					
    }
    
    public function FactorEdit($id){
        global $userid, $db;
        
        $SQL_Factore_Estructura='SELECT 
                Estru_Fac.idsiq_factoresestructuradocumento as id,
                fac.nombre,
                fac.idsiq_factor
            FROM siq_factoresestructuradocumento AS Estru_Fac 
            INNER JOIN siq_factor AS fac ON Estru_Fac.factor_id=fac.idsiq_factor 
            WHERE Estru_Fac.idsiq_estructuradocumento="'.$id.'" 
                AND Estru_Fac.codigoestado=100 
                AND fac.codigoestado=100 
            ORDER BY Estru_Fac.Orden ASC';
        
        if($Factor_Estructura=&$db->Execute($SQL_Factore_Estructura)===false){
            echo 'Error en el SQL del los Factores de la Estructura.....<br>'.$SQL_Factore_Estructura;
            die;
        }
        ?>
        <ul id="sortable_Factores" class="connectedSortable">
            <li class="ui-state-highlight" style="text-align:left;">Arrastre Aqui....</li>
            <?php 
            $i=0;
            $Cadena_P='';
            while(!$Factor_Estructura->EOF){
                ?>
                <li class="ui-state-default" style="text-align:left; width:auto;cursor:pointer; height:auto" id="<?php echo $Factor_Estructura->fields['idsiq_factor']?>" ><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $i+1?>.&nbsp;&nbsp;<?php echo $Factor_Estructura->fields['nombre']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  type="checkbox" id="Factor_<?php echo $i?>" onClick="EliminarFactor(<?php echo $Factor_Estructura->fields['idsiq_factor']?>,'<?php echo $id?>','<?php echo $i?>')" checked="checked"></li>
                <?php
                $Cadena_P = $Cadena_P.'-'.$Factor_Estructura->fields['idsiq_factor'];
                
                $Factor_Estructura->MoveNext();
                $i++;
            }
            ?>
        </ul>
        <input type="hidden" id="CadenaFactor_P" value="<?php echo $Cadena_P?>" />
        <?php
    }
    
    public function IndicadoresEdit($i,$id,$Factor_id){
        global $userid, $db;
        
        $SQL_Indicador='SELECT 

                indGen.nombre,
                indEstru.idsiq_indicadoresestructuradocumento,
                indEstru.indicador_id,
                ind.idsiq_indicador,
                indGen.codigo,
                carct.idsiq_caracteristica,
                carct.nombre AS Caract_Nom,
                carct.codigo AS Cod
            FROM siq_indicadoresestructuradocumento AS indEstru 
            INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento
            INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
            INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico
            INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto
            INNER JOIN siq_caracteristica AS carct ON asp.idCaracteristica=carct.idsiq_caracteristica
            WHERE facEstru.idsiq_estructuradocumento="'.$id.'"
                AND indEstru.idsiq_factoresestructuradocumento="'.$Factor_id.'"
                AND facEstru.codigoestado=100
                AND indEstru.codigoestado=100
                AND ind.codigoestado=100
                AND indGen.codigoestado=100
                AND asp.codigoestado=100
                AND carct.codigoestado=100
            ORDER BY indEstru.Orden ASC';
						
        if($Indicador_Estructura=&$db->Execute($SQL_Indicador)===false){
            echo 'Error en el SQL Indicador Estructura......<br>'.$SQL_Indicador;
            die;
        }			
				
        $j=0;
        ?>
        <li class="ui-state-highlight" style="text-align:left;">Arrastre Aqui....</li>
        <?php
        while(!$Indicador_Estructura->EOF){
            ?>
            <li class="ui-state-default" style="text-align:left; width:auto;cursor:pointer; height:auto" id="<?php echo $Indicador_Estructura->fields['idsiq_indicador'].'_'.$Indicador_Estructura->fields['idsiq_indicadoresestructuradocumento']?>" ><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><strong><?php echo $i+1?>.<?php echo $j+1?></strong>.&nbsp;&nbsp;<?php echo 'Cod. '.$Indicador_Estructura->fields['codigo'].'&nbsp;&nbsp;'.$Indicador_Estructura->fields['nombre'].'&nbsp;&nbsp;('.$Indicador_Estructura->fields['Cod'].''.$Indicador_Estructura->fields['Caract_Nom'].')';?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  type="checkbox" id="Indicador_<?php echo $i?>_<?php echo $j?>" onClick="EliminarIndicador(<?php echo $Indicador_Estructura->fields['idsiq_indicador']?>,'<?php echo $Indicador_Estructura->fields['idsiq_indicadoresestructuradocumento']?>','<?php echo $i?>_<?php echo $j?>','<?php echo $i?>','<?php echo $id?>','<?php echo $Factor_id?>')" checked="checked"></li>
            <?php
            $Indicador_Estructura->MoveNext();
            $j++;
        }			
    }
    
    public function BuscarIndicadores($id,$tipo,$programa){
        global $userid, $db;
        
        if($programa!=0){
            $ProgramaBusca = '   AND  ind.idCarrera="'.$programa.'"';
        }else{
            $ProgramaBusca ='';
        }
        
        $SQL_Factore_Estructura='SELECT 
                Estru_Fac.idsiq_factoresestructuradocumento as id,
                fac.nombre,
                fac.idsiq_factor
            FROM siq_factoresestructuradocumento AS Estru_Fac 
            INNER JOIN siq_factor AS fac ON Estru_Fac.factor_id=fac.idsiq_factor 
            WHERE Estru_Fac.idsiq_estructuradocumento="'.$id.'" 
                AND Estru_Fac.codigoestado=100 AND fac.codigoestado=100';
								
        if($Factor_Estructura=&$db->Execute($SQL_Factore_Estructura)===false){
            echo 'Error en el SQL del los Factores de la Estructura.....<br>'.$SQL_Factore_Estructura;
            die;
        }					
        ?>							
        <script>
            $(function() {
                $('#search_input').fastLiveFilter('#sortable_Ind');
            });
        </script>	
        <fieldset>
            <br /><br />  
            <table class="Border" width="90%" align="center">
             	<tr>
                    <td align="left"><input id="search_input" placeholder="Buscar Indicador.."></td>
                </tr>
                <tr>
                    <td>
                    	<ul id="sortable_Ind" class="connectedSortable">
                        <?php
                        $SQL_Indicador='SELECT
                                indGen.idsiq_indicadorGenerico,
                                indGen.nombre,
                                ind.idsiq_indicador,
                                factor.nombre as fac_nom,
                                indGen.codigo
                            FROM siq_factor AS factor 
                            INNER JOIN siq_caracteristica AS caract ON factor.idsiq_factor=caract.idFactor
                            INNER JOIN siq_aspecto AS asp ON caract.idsiq_caracteristica=asp.idCaracteristica
                            INNER JOIN siq_indicadorGenerico AS indGen ON asp.idsiq_aspecto=indGen.idAspecto
                            INNER JOIN siq_indicador AS ind ON indGen.idsiq_indicadorGenerico=ind.idIndicadorGenerico
                            WHERE ind.idsiq_indicador NOT IN ( SELECT ind.idsiq_indicador
                                    FROM  siq_factor AS factor 
                                    INNER JOIN siq_caracteristica AS caract ON factor.idsiq_factor=caract.idFactor 
                                    INNER JOIN siq_aspecto AS asp ON caract.idsiq_caracteristica=asp.idCaracteristica 
                                    INNER JOIN siq_indicadorGenerico AS indGen ON asp.idsiq_aspecto=indGen.idAspecto 
                                    INNER JOIN siq_indicador AS ind ON indGen.idsiq_indicadorGenerico=ind.idIndicadorGenerico 
                                    INNER JOIN siq_indicadoresestructuradocumento AS inddoc ON ind.idsiq_indicador=inddoc.indicador_id
                                    INNER JOIN siq_factoresestructuradocumento AS facEstru ON   inddoc.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento
                                    INNER JOIN siq_estructuradocumento ON facEstru.idsiq_estructuradocumento=siq_estructuradocumento.idsiq_estructuradocumento AND siq_estructuradocumento.idsiq_estructuradocumento="'.$id.'"
                                    WHERE factor.codigoestado=100 
                                        AND caract.codigoestado=100 
                                        AND asp.codigoestado=100 
                                        AND indGen.codigoestado=100 
                                        AND ind.codigoestado=100
                                        AND inddoc.codigoestado=100
                                )
                                AND factor.codigoestado=100
                                AND caract.codigoestado=100
                                AND asp.codigoestado=100
                                AND indGen.codigoestado=100
                                AND ind.codigoestado=100'.$ProgramaBusca.'
                                AND ind.discriminacion="'.$tipo.'"
                            GROUP BY ind.idsiq_indicador';
										
                        if($Indicador_Estructura=&$db->Execute($SQL_Indicador)===false){
                            echo 'Error en el SQL Indicador Estructura......<br>'.$SQL_Indicador;
                            die;
                        }

                        $i = 0;
                        while(!$Indicador_Estructura->EOF){
                            ?>
                            <li class="ui-state-default" style="text-align:left; width:auto;cursor:pointer; font-size:12px; height:auto" id="<?php echo $Indicador_Estructura->fields['idsiq_indicador']?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $i+1?>&nbsp;&nbsp;<?php echo 'Cod. '.$Indicador_Estructura->fields['codigo'].'&nbsp;&nbsp;'.$Indicador_Estructura->fields['nombre'].'&nbsp;&nbsp;('.$Indicador_Estructura->fields['fac_nom'].')&nbsp;&nbsp;<span style="color:#F00">Agregar.</span>'?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="item_<?php echo $Indicador_Estructura->fields['idsiq_indicador']?>" onClick="NuevoIndicador(<?php echo $Indicador_Estructura->fields['idsiq_indicador']?>,'<?php echo $id?>')" ><input type="hidden" id="Ultimo_id_<?php echo $Indicador_Estructura->fields['idsiq_indicador']?>" /></li>
                            <?php
                            $i++;
                            $Indicador_Estructura->MoveNext();
                        }
                        ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </fieldset>	
            <?php						
    }
    
    public function Dialogo_Edit($i,$Factores_id,$Tipo_doc){
        global $userid, $db;
        ?>
        <script>
            $(function() {
                $('#search_inputo').fastLiveFilter('#sortableZZZ_<?php echo $i?>');
            });
        </script>
        <div id="dialog-form_<?php echo $i?>" title="Estructurar Indicadores Institucionales">
            <fieldset>
                <input type="hidden" id="Factor_id_<?php echo $i?>" value="<?php echo $Factores_id?>"><br>
                <input type="hidden" id="Cadena_<?php echo $i?>" >
                <?php
                $SQL_Indicadores='SELECT 
                        ind.idsiq_indicador, 
                        ind.idIndicadorGenerico, 
                        indGen.idsiq_indicadorGenerico, 
                        indGen.nombre,
                        indGen.codigo 
                    FROM siq_indicador as ind 
                    INNER JOIN siq_indicadorGenerico as indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                    INNER JOIN siq_aspecto as asp ON indGen.idAspecto=asp.idsiq_aspecto 
                    INNER JOIN siq_caracteristica as Cart ON asp.idCaracteristica=Cart.idsiq_caracteristica 
                    INNER JOIN siq_factor as fac ON Cart.idFactor=fac.idsiq_factor 
                    WHERE ind.discriminacion="'.$Tipo_doc.'"
                        AND fac.idsiq_factor="'.$Factores_id.'" 
                        AND ind.codigoestado=100 
                        AND indGen.codigoestado=100 
                        AND asp.codigoestado=100 
                        AND Cart.codigoestado=100 
                        AND fac.codigoestado=100 ';
                                            
                if($Indicadores=&$db->Execute($SQL_Indicadores)===false){
                    echo 'Error en el SQL Indicadores......<br>'.$SQL_Indicadores;
                    die;
                }
                
                if($Indicadores->EOF){
                    ?>
                    <span style="color:#666; font-family:'Times New Roman', Times, serif; font-size:24px; text-align:center">No hay Infirmaci&oacute;n</span>
                    <?php
                }				
                ?>
                <input id="search_inputo" placeholder="Buscar Indicadores...">
                <ul id="sortableZZZ_<?php echo $i?>" >
                    <?php 
                    $t = 0;
                    while(!$Indicadores->EOF){
                        ?>
                        <li class="ui-state-default" style="text-align:left; width:auto;cursor:pointer; font-size:12px; height:auto" id="<?php echo $Indicadores->fields['idsiq_indicador']?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $t+1?>.&nbsp;<?php echo $Indicadores->fields['codigo'].'-'.$Indicadores->fields['nombre']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="item_<?php echo $i?>_<?php echo $t?>" onClick="Add_hijo(<?php echo $t?>,'<?php echo $Indicadores->fields['idsiq_indicador']?>','<?php echo $i?>')" class="hijoCheck_<?php echo $i?>"></li>	
                        <?php
                        $Indicadores->MoveNext();
                        $t++;
                    }
                    ?>
                </ul>
                <input type="hidden" id="Cadena_hijo_<?php echo $i?>"><input type="hidden" id="index_hijo_<?php echo $i?>" value="<?php echo $t?>">  
            </fieldset>
        </div>
        <?php
    }
    
    public function DuplicarDialogo($id){
        global $userid, $db;

        $SQL='SELECT 
                Doc.idsiq_estructuradocumento AS id,
                Doc.nombre_documento,
                Doc.tipo_documento,
                Doc.id_carrera,
                car.nombrecarrera,
                fac.nombrefacultad
            FROM siq_estructuradocumento AS Doc 
            INNER JOIN carrera AS car ON car.codigocarrera=Doc.id_carrera 
            INNER JOIN facultad AS fac ON car.codigofacultad=fac.codigofacultad
            WHERE Doc.idsiq_estructuradocumento="'.$id.'" AND Doc.codigoestado=100 ';

            if($Datos=&$db->Execute($SQL)===false){
                echo 'Error en el SQl de los Datos....<br>'.$SQL;
                die;
            }
        ?>
        <br /><br /><br />
        <fieldset>
            <legend>Duplicar Documento de Programa...</legend>
            <table border="0" class="Border" cellpadding="0" cellspacing="0" width="90%">
                <tr>
                    <td>&nbsp;</td>
                    <td><strong>Nombre del Documento:</strong></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo $Datos->fields['nombre_documento']?>_Duplicado</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center">
                        <table width="100%" align="center" class="Border">
                            <tr>
                                <td><strong>Facultad:</strong></td>
                                <td>&nbsp;</td>
                                <td><strong>Programa:</strong></td>
                            </tr>
                            <?php 
                            $SQL_falcutad='SELECT 
                                    codigofacultad as id,
                                    nombrefacultad
                                FROM facultad
                                ORDER BY nombrefacultad ASC';								

                            if($Facultad=&$db->Execute($SQL_falcutad)===false){
                                echo 'Error en el SQL Facultad...<br>'.$SQL_falcutad;
                                die;
                            }	

                            $SQL_falcutad_Edit='SELECT
                                    carrera.codigocarrera ,
                                    carrera.nombrecarrera,
                                    facultad.codigofacultad,
                                    facultad.nombrefacultad
                                FROM arrera,
                                    facultad
                                WHERE
                                    carrera.codigofacultad=facultad.codigofacultad
                                    AND carrera.codigocarrera="'.$Datos->fields['id_carrera'].'"';			

                            if($Facultad_Ex=&$db->Execute($SQL_falcutad_Edit)===false){
                                echo 'Error en el SQL Facultad...<br>'.$SQL_falcutad;
                                die;
                            }
                            ?>
                            <tr>
                                <td>
                                    <select id="Faculta_id" name="Faculta_id"  style="width:auto" class="cajas"> 
                                        <option value="<?php echo $Facultad_Ex->fields['codigofacultad']?>" onclick="VerPrograma(<?php echo $Facultad_Ex->fields['codigofacultad']?>)"><?php echo $Facultad_Ex->fields['nombrefacultad']?></option>
                                            <?php 
                                            while(!$Facultad->EOF){
                                                if($Facultad_Ex->fields['codigofacultad']!=$Facultad->fields['id']){
                                                    ?>
                                                    <option value="<?php echo $Facultad->fields['id']?>" onclick="VerPrograma(<?php echo $Facultad->fields['id']?>)"><?php echo $Facultad->fields['nombrefacultad']?></option>
                                                    <?php
                                                }
                                                $Facultad->MoveNext();
                                            } 
                                            ?>
                                        </option>
                                    </select> 
                                </td>
                                <td>&nbsp;<input type="hidden" id="id_Programa" value="<?php echo $Facultad_Ex->fields['codigocarrera']?>"/></td>
                                <td>
                                    <div id="Carga">
                                        <?php
                                        $SQL='SELECT 
                                                codigocarrera as id,
                                                nombrecarrera
                                            FROM carrera
                                            WHERE codigofacultad="'.$Facultad_Ex->fields['codigofacultad'].'"
                                            ORDER BY nombrecarrera ASC';

                                        if($Select_Option=&$db->Execute($SQL)===false){
                                            echo 'Error en el SQL Secte del Ajax...<br>'.$SQL;
                                            die;
                                        }
                                        ?>   
                                        <select id="Programa_id" name="Programa_id" class="cajas" style="width:auto">
                                                <option value="<?php echo $Facultad_Ex->fields['codigocarrera']?>"><?php echo $Facultad_Ex->fields['nombrecarrera']?></option>
                                                <?php 
                                                while(!$Select_Option->EOF){
                                                    if($Facultad_Ex->fields['codigocarrera']!=$Select_Option->fields['id']){
                                                        ?>
                                                        <option value="<?php echo $Select_Option->fields['id']?>"><?php echo $Select_Option->fields['nombrecarrera']?></option>
                                                        <?php
                                                    }
                                                    $Select_Option->MoveNext();
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </fieldset>
        <br /><br /><div align="center"><input type="button" id="DuplicaPrograma" value="..Generar Duplicado.." onclick="DuplicarPrograma(<?php echo $id?>)"/></div><br />
        <?php
    }		
}#Class
?>