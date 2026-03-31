<?php
class DisenoEspacioFisico{
    public function Principal(){
        ?>
        <fieldset style="width: auto;">
    	<legend>Dise&ntilde;o Espacio F&iacute;sico</legend>
        <form id="DisenoEspacio">
            <input id="actionID" name="actionID" type="hidden" value="Save" />
            <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 65%; margin-left: 10%;">
                <thead>
                    <tr>
                        <th style="text-align: left;">Tipo Espacio F&iacute;sico &nbsp;<span style="color: red;">*</span></th>
                        <th>
                            <?PHP $this->Categoria();?>
                        </th>
                    </tr>
                    <tr id="Tr_Jerarquia" style="visibility: collapse;">
                        <th colspan="2" style="text-align: left;">
                            <fieldset style="width:auto; ">
                                <legend>Jerarquia Espacios F&iacute;sicos</legend>
                                <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 100%;">
                                    <tr>
                                        <th>Campus &nbsp;<span style="color: red;" class="valida">*</span></th>
                                        <th>
                                            <?PHP $this->EspacioCategoria('Campus',3,'BuscarEdificio()');?>
                                        </th>
                                        <th>&nbsp;</th>
                                        <th class="Th_Jerarquia">Edificio &nbsp;<span style="color: red;" class="valida">*</span></th>
                                        <th class="Th_Jerarquia" id="Th_Edificio">
                                          <select name="Edificio" id="Edificio">
                                            <option value="-1">Elige</option>
                                          </select>
                                        </th>
                                    </tr>
                                </table>
                            </fieldset>
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Nombre del Nuevo Espacio F&iacute;sico &nbsp;<span style="color: red;" class="valida">*</span></th>
                        <th>
                            <input type="text" id="newEspacio" name="newEspacio" style="text-align: center;" placeholder="Digite Nombre del Nuevo Espacio Fisico" size="50" />
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <table border="0" align="left" cellpadding="0" cellspacing="0" style="width:auto;">
                                <tr>
                                    <th style="text-align: left;">Descripci&oacute;n<span style="color: red;" class="valida" id="v_descrip">&nbsp;*</span></th>
                                    <th>
                                        <input type="text" id="Descrip" name="Descrip" placeholder="Ejemplo: Bloque..." style="text-align: center;" />
                                    </th>
                                    <th style="text-align: left;">Dirreci&oacute;n<span style="color: red;" class="valida" id="v_Dir">&nbsp;*</span></th>
                                    <th>
                                        <input type="text" id="Dirrecion" name="Dirrecion" placeholder="Ejemplo: Calle o Carrera..." style="text-align: center;" />
                                    </th>
                                    <th style="text-align: left;">Acceso a Discapacitados</th>
                                    <th>
                                        <input type="checkbox" id="Acceso" name="Acceso" />
                                    </th>
                                </tr>
                                <tr class="Tr_Detalle" style="visibility: collapse;">
                                    <th style="text-align: left;">Tipo Sal&oacute;n &nbsp;<span style="color: red;" class="valida">*</span></th>
                                    <th>
                                        <?PHP $this->TipoSalon()?>
                                    </th>
                                    <th style="text-align: left;">Capacidad &nbsp;<span style="color: red;" class="valida">*</span></th>
                                    <th>
                                        <input type="text" id="Capacidad" name="Capacidad" placeholder="Digite Cantidad" style="text-align: center;" />
                                    </th>
                                    <th colspan="2">&nbsp;</th>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Fecha Inicial de Vigencia &nbsp;<span style="color: red;" class="valida">*</span></th>
                                    <th>
                                        <input type="text" id="FechaIni" name="FechaIni" size="12" style="text-align:center;" readonly="readonly" />
                                    </th>
                                    <th style="text-align: left;">Fecha Final de Vigencia &nbsp;<span style="color: red;" class="valida">*</span></th>
                                    <th>
                                        <input type="text" id="FechaFin" name="FechaFin" size="12" style="text-align:center;" readonly="readonly" />
                                    </th>
                                    <th colspan="2">&nbsp;</th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">
                                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="button" id="SaveEspacio" name="SaveEspacio" value="Guardar" style="margin-left: 6%;" onclick="GuardarEspacio()" /><!---class="Boton"-->
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>    
        </fieldset>
        <?PHP
    }//public function Principal
    public function AddExepciones($id){
        global $db,$userid;
        ?>
        <fieldset style="width: auto;">
            <legend>Adicionar Exepci&oacute;n</legend>
            <input type="hidden" id="Registro" name="Registro" value="<?PHP echo $id?>" />
            <table border="0" align="left" cellpadding="0" cellspacing="0" style="width:auto; margin-left: 10%;">
                <thead>
                    <tr>
                        <th style="text-align: left;">Modalidad Acad&eacute;mica</th>
                        <th style="text-align: left;">
                            <?PHP $this->Modalidad();?>
                        </th>
                   </tr>
                   <tr>     
                        <th style="text-align: left;">Programa Acad&eacute;mico</th>
                        <th style="text-align: left;" id="Th_Programa">
                            <select id="Programa"  name="Programa" style="width: 90%;">
                                <option value="-1"></option>
                            </select>
                        </th>
                   </tr>
                   <tr>
                        <th>&nbsp;</th>
                        <th>Todos&nbsp;<input type="checkbox" id="AllPrograma" name="AllPrograma" onclick="InavilitaPrograma()" /></th>
                   </tr>
                   <tr>
                    <th style="text-align: right;">
                        <img src="../../mgi/images/photo_add.png" style="cursor: pointer;" width="30" title="Click Para Adicionar Preferencia" onclick="AddExepcionView('1');" />
                    </th>
                    <th style="text-align: right;">
                        <img src="../../mgi/images/photo_delete.png" style="cursor: pointer;" width="30" title="Click Para Adicionar Restricci&oacute;n" onclick="AddExepcionView('0');" />
                    </th>
                   </tr>
                </thead>
                <tbody>
                     <tr>
                        <td colspan="2">
                            <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="ViewExepcion">
                            <?PHP $this->ViewExpecionesRestriciones($id)?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        <?PHP
    }//public function AddExepciones
    public function ViewExpecionesRestriciones($id=''){
        global $db;
         include_once('Admin_Categorias_class.php'); $C_Admin_Categorias = new Admin_Categorias(); 
        if($id){
            $SQL='SELECT   Nombre
                
                  FROM    ClasificacionEspacios
                
                  WHERE   ClasificacionEspaciosId="'.$id.'"
                          AND
                          codigoestado=100';
                          
              if($Name=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL ...<br>'.$SQL;
                    die;
              }            
                
            $Titulo = $Name->fields['Nombre'];
                        
        }else{
            $Titulo = '';
        }
          
        $SQl_View='SELECT 

                    p.PrioridadesRestriccionesId AS id,
                    p.codigocarrera,
                    c.nombrecarrera AS Nombre,
                    p.Estatus,
                    p.codigoestado
                    
                    
                    FROM PrioridadesRestricciones p INNER JOIN PrioridadesRestriccionesEspaciosFisicos pf ON p.PrioridadesRestriccionesId=pf.PrioridadesRestriccionesId 
				                                    INNER JOIN carrera c ON c.codigocarrera=p.codigocarrera 
                    
                    AND pf.ClasificacionEspaciosId="'.$id.'" ';
                    
            if($View=&$db->Execute($SQl_View)===false){
                echo 'Error en el SQl de las Lista de Restriciones y Prioridades....<br>'.$SQl_View;
                die;
            }        
        ?>
        <fieldset style="width: auto; margin-left: 6%;">
            <legend>Espacio F&iacute;sico <?PHP echo $Titulo?></legend>
            <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 90%; margin-left: 5%;">  
                <thead>
                    <tr>
                        <th>Programa Acad&eacute;mico</th>
                        <th style="font-size: 13px;">Preferencia &oacute; Restricci&oacute;n</th>
                        <th colspan="2" style="font-size: 13px;">Activar &oacute; Inactivar</th>
                    </tr>
                </thead> 
                <tbody>
                <?PHP 
                if(!$View->EOF){
                    $c = 0;
                    while(!$View->EOF){
                        $x = $C_Admin_Categorias::ispar($c);
                        if($x==1){
                            $color = 'style="background:#F2EAFB"';
                        }else{
                            $color = 'style="background:#F7FFFF"';
                        }
                        if($View->fields['codigoestado']==100){
                           $opacity_OK     = 'opacity:0.4;';
                           $opacity_delete = '';
                           $onclick_OK        = '';
                           $onclick_delete    = "CambiarEstado('".$View->fields['id']."','200','".$id."');";
                        }else{
                           $opacity_OK        = '';
                           $opacity_delete    = 'opacity:0.4;';
                           $onclick_OK        = "CambiarEstado('".$View->fields['id']."','100','".$id."');";
                           $onclick_delete    = '';
                        }
                        if($View->fields['Estatus']==1){
                            $img ='../../mgi/images/photo_add.png';
                            $tittle = 'Prioridad';
                            $OnclickRestricion = "CambiarRestricion(0,'".$View->fields['id']."','".$id."');";
                        }else{
                            $img ='../../mgi/images/photo_delete.png';
                            $tittle = 'Restrinccion';
                            $OnclickRestricion = "CambiarRestricion(1,'".$View->fields['id']."','".$id."');";;
                        }
                        ?>
                        <tr <?PHP echo $color?>> 
                            <td id="<?PHP echo $View->fields['id']?>" style="cursor: pointer;"  title="Para Editar dar Click"><?PHP echo $View->fields['Nombre']?>
                                <!--<span id="label_<?PHP echo $View->fields['id']?>"></span>
                                <input type="text" id="TextoEdit_<?PHP echo $View->fields['id']?>" name="TextoEdit_<?PHP echo $View->fields['id']?>" value="<?PHP echo $View->fields['Nombre']?>" style="text-align: center; display: none;" />-->
                            </td>
                            <td style="text-align: center;">
                                <img  src="<?PHP echo $img?>" style="  cursor: pointer; " width="20" title="<?PHP echo $tittle?>" onclick="<?PHP echo $OnclickRestricion;?>" />
                            </td>
                            <td style="text-align: right;" width="22">
                                <img  src="../../mgi/images/Check.png" style="  cursor: pointer;<?PHP echo $opacity_OK?> " width="20" title="Activar Registro" onclick="<?PHP echo $onclick_OK?>" />
                            </td>
                            <td style="text-align: right;" width="22">
                                <img  src="../../mgi/images/delete.png" style=" cursor: pointer;<?PHP echo $opacity_delete?>" width="20" title="Inactivar Registro" onclick="<?PHP echo $onclick_delete?>" />  
                            </td>
                        </tr>
                           
                        <?PHP
                        $c++;
                        $View->MoveNext();
                    }
                }else{
                   ?>
                   <tr>
                    <td style="text-align: center;color: gray;">No hay Informaci&oacute;n</td>
                   </tr>
                   <?PHP 
                }
                ?>
                </tbody>
            </table>
        </fieldset>
        <?PHP
    }//public function ViewExpecionesRestriciones
    public function Modalidad(){
        global $db;
        
          $SQL='SELECT 
                
                codigomodalidadacademica AS id,
                nombremodalidadacademica AS Nombre
                
                FROM modalidadacademica
                
                WHERE
                
                codigoestado=100';
                
          if($Modalidad=&$db->Execute($SQL)===false){
            echo 'Error en el SQL Modalidad....<br><br>'.$SQL;
            die;
          }  
          
       ?>
        <select id="Modalidad" name="Modalidad" style="width: auto;" onchange="Programa()">
            <option value="-1"></option>
            <?PHP 
            while(!$Modalidad->EOF){
                ?>
                <option value="<?PHP echo $Modalidad->fields['id']?>"><?PHP echo $Modalidad->fields['Nombre']?></option>
                <?PHP
                $Modalidad->MoveNext();
            }
            ?>
        </select>
       <?PHP       
    }//public function Modalidad
    public function Programa($Modalidad){
        global $db;
        
          $SQL='SELECT 

                codigocarrera AS id,
                nombrecarrera AS Nombre 
                
                FROM carrera
                
                WHERE
                
                codigomodalidadacademica="'.$Modalidad.'"
                
                ORDER BY  nombrecarrera ASC';
                
          if($Programa=&$db->Execute($SQL)===false){
                echo 'Error En el SQL .....<br><br>'.$SQL;
                die;
          }   
        ?>
        <select id="Programa" name="Programa" style="width:80%;">
            <option value="-1"></option>
            <?PHP 
            while(!$Programa->EOF){
                ?>
                <option value="<?PHP echo $Programa->fields['id']?>"><?PHP echo $Programa->fields['Nombre']?></option>
                <?PHP
                $Programa->MoveNext();
            }
            ?>
        </select>
        <?PHP     
    }//public function Programa
    public function Categoria($id=''){
        global $db;
        
          $SQL='SELECT 
                
                EspaciosFisicosId AS id,
                Nombre
                
                FROM EspaciosFisicos
                
                WHERE
                
                codigoestado=100
                AND
                EspaciosFisicosId<>6
                
                ORDER BY Nombre ASC';
                
        if($Espacio=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Espacio Fisico...<br><br>'.$SQL;
            die;
        } 
        
        if($id){
            $disabled = 'disabled="disabled"';   
        }else{
            $disabled = '';
        }
          
            
        ?>
        <select onchange="Activar()" id="Espacio" name="Espacio" style="width: 90%;" <?PHP echo $disabled?>>
            <option value="-1">Elige</option>
            <?PHP 
            while(!$Espacio->EOF){
                if($id==$Espacio->fields['id']){
                    $selected = 'selected="selected"';   
                }else{
                    $selected = '';
                }
                ?>
                <option <?PHP echo $selected?>  value="<?PHP echo $Espacio->fields['id']?>"><?PHP echo $Espacio->fields['Nombre']?></option>
                <?PHP
                $Espacio->MoveNext();
            }
            ?>
        </select>
        <?PHP         
    }//public function Categoria
    public function EspacioCategoria($name,$filtro,$funcion='',$op='',$id=''){
        global $db;
        
        if($op){
           $Add   = ' AND ClasificacionEspacionPadreId="'.$op.'"';
           $Bloke = ', descripcion AS Bloke';
        }else{
           $Add   = '';
           $Bloke = '';
        }
        
          $SQL='SELECT 

                ClasificacionEspaciosId AS id,
                Nombre'.$Bloke.'
                
                FROM ClasificacionEspacios
                
                WHERE
                
                EspaciosFisicosId="'.$filtro.'"
                AND
                codigoestado=100'.$Add.'
                ORDER BY Nombre ASC';
                
        if($Respuesta=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Campus...<br><br>'.$SQL;
            die;
        }  
        
            
        ?>
        <select <?PHP echo $disabled?> onchange="<?PHP echo $funcion?>" name="<?PHP echo $name?>" id="<?PHP echo $name?>" style="width: 90%;">
            <option value="-1">Elige</option>
            <?PHP 
            while(!$Respuesta->EOF){
                if($id==$Respuesta->fields['id']){
                    $selected = 'selected="selected"';    
                }else{
                    $selected = '';
                }
                ?>
                <option <?PHP echo $selected?>  value="<?PHP echo $Respuesta->fields['id']?>"><?PHP echo $Respuesta->fields['Nombre']; if($op){ echo '&nbsp;&nbsp;'.$Respuesta->fields['Bloke'];}?></option>
                <?PHP
                $Respuesta->MoveNext();
            }
            ?>
        </select>
        <?PHP 
    }//public function EspacioCategoria
   public function TipoSalon($id=''){
    global $db;
    
          $SQL='SELECT 

                codigotiposalon AS id,
                nombretiposalon AS Nombre
                
                FROM tiposalon
                
                WHERE  codigoestado=100
                
                ORDER BY nombretiposalon ASC';
                
          if($TipoSalon=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Tipo SQL..... <br><br>'.$SQL;
            die;
          }   
       ?>
        <select id="T_salon" name="T_salon" style="width: 90%;">
            <option value="-1">Elige</option>
            <?PHP 
            while(!$TipoSalon->EOF){
                if($id==$TipoSalon->fields['id']){
                    $selected  = 'selected="selected"';
                }else{
                    $selected  = '';
                }
                ?>
                <option <?PHP echo $selected?> value="<?PHP echo $TipoSalon->fields['id']?>"><?PHP echo $TipoSalon->fields['Nombre']?></option>
                <?PHP
                $TipoSalon->MoveNext();
            }    
            ?>
        </select>   
       <?PHP      
   }//public function TipoSalon
   public function Consola($db){
    $Data = $this->DataConsola($db);
    ?>
    <style>
        tr.odd:hover,tr.even:hover{
            background-color: yellow;
            cursor: pointer;
        }
        .ClasOnclikColor{
             background-color: red;
        }
        .odd{
            background-color: #e2e4ff;
        }
        .even{
          background-color: white;  
        }
        
        </style>
    <style type="text/css" title="currentStyle">
                @import "../../observatorio/data/media/css/demo_page.css";
                @import "../../observatorio/data/media/css/demo_table_jui.css";
                @import "../../observatorio/data/media/css/ColVis.css";
                @import "../../observatorio/data/media/css/TableTools.css";
                @import "../../observatorio/data/media/css/ColReorder.css";
                @import "../../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../../observatorio/data/media/css/jquery.modal.css";
                
        </style>
       
        <!--<script type="text/javascript" language="javascript" src="../../observatorio/data/media/js/jquery.js"></script>
        <script type="text/javascript" charset="utf-8" src="../jquery/js/jquery-3.6.0.js"></script>-->
        <script type="text/javascript" language="javascript" src="../../observatorio/data/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ColVis.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ZeroClipboard.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/TableTools.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/FixedColumns.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ColReorder.js"></script>
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        	$(document).ready( function () {
        			
        			oTable = $('#example').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columns",
                                           //"aiExclude": [ 0 ]
                                    }
                                });
                                var oTableTools = new TableTools( oTable, {
        					"buttons": [
        						"copy",
        						"csv",
        						"xls",
        						"pdf",
        						{ "type": "print", "buttonText": "Print me!" }
        					]
        		         });
                                 //$('#demo').before( oTableTools.dom.container );
        		} );
        	/**************************************************************/
        </script>
  <div id="container">
        <h2>Administraci&oacute;n del Espacio F&iacute;sico</h2>
        <input type="hidden" id="id_Carga" name="id_Carga" />
        <div class="demo_jui">
            <div class="DTTT_container">
                <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text " onclick="NuevoDiseno()" title="Crear Nuevo Espacio">
                    <span>Nuevo</span>                
                </button>
                <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled" onclick="EditarEspacio()" title="Editar Espacio">
                    <span>Editar</span>                
                </button>
                <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled" onclick="ExepcioneConsola()" title="Adicionar Exepcion">
                    <span>Exepciones</span>
                </button>
            </div>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th>#</th>   
                        <th>Nombre del Espacio F&iacute;sico</th>
                        <th>Descripci&oacute;n</th>
                        <th>Tipo de Espacio</th>
                        <th>Fecha Inicial Vigencia</th>
                        <th>Fecha Final Vigencia</th>
                    </tr>
                </thead>
                <tbody>  
                    <?PHP 
                    for($i=0;$i<count($Data);$i++){
                        $id = $Data[$i]['ClasificacionEspaciosId'];
                        ?>
                        <tr id="Tr_File_<?PHP echo $i?>" onclick="CargarNum('<?PHP echo $i?>','<?PHP echo $id?>')" onmouseover="CambioClass('<?PHP echo $i?>')">
                            <td><?PHP echo $i+1?></td>
                            <td><?PHP echo $Data[$i]['Nombre'];?></td>
                            <td><?PHP echo $Data[$i]['Nickname'];?></td>
                            <td><?PHP echo $Data[$i]['Tipo'];?></td>
                            <td><?PHP echo $Data[$i]['FechaInicioVigencia'];?></td>
                            <td><?PHP echo $Data[$i]['FechaFinVigencia'];?></td>
                        </tr>
                        <?PHP
                    }
                    ?>                     
                </tbody>
            </table>
        </div>
    </div> 
    <?PHP
   }//public function Consola
   public function DataConsola($db){
          $SQL='SELECT
                	c.ClasificacionEspaciosId,
                	c.Nombre,
                	c.descripcion,
                	e.Nombre AS Tipo,
                	d.FechaInicioVigencia,
                	d.FechaFinVigencia,
                    cc.Nombre AS Nickname
                FROM
                	ClasificacionEspacios c
                INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId = c.EspaciosFisicosId
                INNER JOIN DetalleClasificacionEspacios d ON d.ClasificacionEspaciosId = c.ClasificacionEspaciosId
                INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId=c.ClasificacionEspacionPadreId

                AND e.codigoestado = 100
                AND c.codigoestado = 100
                WHERE
                	c.ClasificacionEspaciosId <> 1';
                    
            if($Datos=&$db->Execute($SQL)===false){
                echo 'Error en el SQL ...<br><br>'.$SQL;
                die;
            }   
            
         $C_Data = $Datos->GetArray();
         
         Return $C_Data;        
   }//public function DataConsola
   public function Editar($Dato){
    global $db;
    //echo '<pre>';print_r($Dato);
  
    
    if($Dato[0]['AccesoDiscapacitados']==1){
        $Acceso = 'checked="checked"';
    }else{
        $Acceso = '';
    }
    
    if($Dato[0]['EspaciosFisicosId']>=4 || $Dato[0]['EspaciosFisicosId']>='4'){
        
        $Tr_Jerarquia = 'style="visibility: visible;"';
        
        if($Dato[0]['EspaciosFisicosId']==4){
            
            $Th_Jerarquia = 'style="visibility: collapse;"';
            $Tr_Detalle   = 'style="visibility: collapse;"';
            $v_descrip    = 'visibility: collapse;';
            $v_Dir        = 'visibility: collapse;';
            ?>
            <script>
                /**********************************************/
                $('#Edificio').val('-1');
                $('#T_salon').val('-1');
                $('#Capacidad').val('');
            </script>
            <?PHP
        }else{
            
            $Th_Jerarquia = 'style="visibility: visible;"';
            $Tr_Detalle   = 'style="visibility: visible;"';
            $v_descrip    = 'visibility: collapse;';
            $v_Dir        = 'visibility: collapse;';
            
        }
    }else{
        $Tr_Jerarquia = 'style="visibility: collapse;"';
        $Tr_Detalle   = 'style="visibility: collapse;"';
        $v_descrip    = 'visibility: visible;';
        $v_Dir        = 'visibility: visible;';
        ?>
        <script>
            $('#Campus').val('-1'); 
            $('#Edificio').val('-1');
            $('#T_salon').val('-1');
            $('#Capacidad').val('');
        
        </script>
        <?PHP
        
    }
    ?>
    <fieldset style="width: auto;">
    	<legend>Editar Dise&ntilde;o Espacio F&iacute;sico</legend>
        <form id="DisenoEspacio">
            <input id="actionID" name="actionID" type="hidden" value="Update" />
            <input id="id_Registro" name="id_Registro" type="hidden" value="<?PHP echo $Dato[0]['id']?>" />
            <input id="PadreId" name="PadreId" type="hidden" value="<?PHP echo $Dato[0]['EspaciosFisicosId']?>" />
            <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 65%; margin-left: 10%;">
                <thead>
                    <tr>
                        <th style="text-align: left;">Tipo Espacio F&iacute;sico &nbsp;<span style="color: red;">*</span></th>
                        <th>
                            <?PHP $this->Categoria($Dato[0]['EspaciosFisicosId']);?>
                        </th>
                    </tr>
                    <tr id="Tr_Jerarquia" <?PHP echo $Tr_Jerarquia?> >
                        <th colspan="2" style="text-align: left;">
                            <fieldset style="width:auto; ">
                                <legend>Jerarquia Espacios F&iacute;sicos</legend>
                                <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 100%;">
                                    <tr>
                                        <th>Campus &nbsp;<span style="color: red;" class="valida">*</span></th>
                                        <th>
                                            <?PHP echo $this->EspacioCategoria('Campus',3,'BuscarEdificio()','',$Dato[0]['PadreId2']);?>
                                        </th>
                                        <th>&nbsp;</th>
                                        <th class="Th_Jerarquia" <?PHP echo $Th_Jerarquia?>>Edificio &nbsp;<span style="color: red;" class="valida">*</span></th>
                                        <th class="Th_Jerarquia" id="Th_Edificio" <?PHP echo $Th_Jerarquia?>>
                                          <?PHP echo $this->EspacioCategoria('Edificio','4','',$Dato[0]['PadreId2'],$Dato[0]['ClasificacionEspacionPadreId'])?>
                                        </th>
                                    </tr>
                                </table>
                            </fieldset>
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Nombre del Nuevo Espacio F&iacute;sico &nbsp;<span style="color: red;" class="valida">*</span></th>
                        <th>
                            <input type="text" id="newEspacio" name="newEspacio" style="text-align: center;" placeholder="Digite Nombre del Nuevo Espacio Fisico" size="50" value="<?PHP echo $Dato[0]['Nombre']?>" />
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <table border="0" align="left" cellpadding="0" cellspacing="0" style="width:auto;">
                                <tr>
                                    <th style="text-align: left;">Descripci&oacute;n<span style="color: red;<?PHP echo $v_descrip?>" class="valida" id="v_descrip" >&nbsp;*</span></th>
                                    <th>
                                        <input type="text" id="Descrip" name="Descrip" placeholder="Ejemplo: Bloque..." style="text-align: center;" value="<?PHP echo $Dato[0]['descripcion']?>" />
                                    </th>
                                    <th style="text-align: left;">Dirreci&oacute;n<span style="color: red;<?PHP echo $v_Dir?>" class="valida" id="v_Dir" >&nbsp;*</span></th>
                                    <th>
                                        <input type="text" id="Dirrecion" name="Dirrecion" placeholder="Ejemplo: Calle o Carrera..." style="text-align: center;" value="<?PHP echo $Dato[0]['direccion']?>" />
                                    </th>
                                    <th style="text-align: left;">Acceso a Discapacitados</th>
                                    <th>
                                        <input type="checkbox" id="Acceso" name="Acceso" <?PHP echo $Acceso?> />
                                    </th>
                                </tr>
                                <tr class="Tr_Detalle" <?PHP echo $Tr_Detalle?>><!-- style="visibility: collapse;"-->
                                    <th style="text-align: left;">Tipo Sal&oacute;n &nbsp;<span style="color: red;" class="valida">*</span></th>
                                    <th>
                                        <?PHP $this->TipoSalon($Dato[0]['codigotiposalon'])?>
                                    </th>
                                    <th style="text-align: left;">Capacidad &nbsp;<span style="color: red;" class="valida">*</span></th>
                                    <th>
                                        <input type="text" id="Capacidad" name="Capacidad" placeholder="Digite Cantidad" style="text-align: center;" value="<?PHP echo $Dato[0]['CapacidadEstudiantes']?>" />
                                    </th>
                                    <th colspan="2">&nbsp;</th>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Fecha Inicial de Vigencia &nbsp;<span style="color: red;" class="valida">*</span></th>
                                    <th>
                                        <input type="text" id="FechaIni" name="FechaIni" size="12" style="text-align:center;" readonly="readonly" value="<?PHP echo $Dato[0]['FechaInicioVigencia']?>" />
                                    </th>
                                    <th style="text-align: left;">Fecha Final de Vigencia &nbsp;<span style="color: red;" class="valida">*</span></th>
                                    <th>
                                        <input type="text" id="FechaFin" name="FechaFin" size="12" style="text-align:center;" readonly="readonly" value="<?PHP echo $Dato[0]['FechaFinVigencia']?>" />
                                    </th>
                                    <th style="text-align: left; " class="Tr_Detalle" <?PHP echo $Tr_Detalle?>>Alguna Excepci&oacute;n</th><!--visibility: collapse;-->
                                    <th class="Tr_Detalle" <?PHP echo $Tr_Detalle?> ><!--style="visibility: collapse;"-->
                                        <input type="button" id="Exepcion" name="Exepcion" onclick="VentanaExepciones(<?PHP echo $Dato[0]['id']?>)" class="button white" value="Exepci&oacute;n" />
                                    </th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <td colspan="2">
                            <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
                        </td>
                    <tr>
                        <td colspan="2">
                            <input type="button" id="SaveEspacio" name="SaveEspacio" value="Guardar" style="margin-left: 6%;" class="Boton" onclick="UpdateEspacio()" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>    
        </fieldset>
    <?PHP
   }//public function Editar
}//class
?>