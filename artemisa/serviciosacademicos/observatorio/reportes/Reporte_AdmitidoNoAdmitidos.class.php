<?php
class Reporte_AdmitidoNoAdmitidos{
    public function Principal(){
        global $db,$userid;
        ?>
         <div id="container">
            <fieldset >
                <legend>Estudiantes Admitidos y No Admitidos</legend>
                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center">
                    <thead>
                        <tr>
                            <th class="titulo_label">Periodo</th>
                            <th>
                                <select id="Periodo" name="Periodo" style="width: auto;text-align: center;">
                                    <option value="-1"></option>
                                    <?PHP 
                                    $C_Periodo=$this->Periodo('Todos');
                                    
                                    for($i=0;$i<count($C_Periodo);$i++){
                                        ?>
                                        <option value="<?PHP echo $C_Periodo[$i]['codigoperiodo']?>"><?PHP echo $C_Periodo[$i]['codigoperiodo']?></option>
                                        <?PHP
                                    }//for
                                    ?>
                                </select>
                            </th>
                            <th>&nbsp;</th>
                            <th class="titulo_label">Modalidad Acad&eacute;mica</th>
                            <th><?PHP $this->ModalidadAcademica();?></th>
                        </tr>
                        <tr>
                            <th>Programa Acad&eacute;mico</th>
                            <th id="Th_Programa">
                                <select id="Programa" name="Programa" style="width: auto;">
                                    <option value="-1"></option>
                                </select>    
                            </th>
                            <th colspan="3">&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="5" aling="center">&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="5" aling="center"><button class="submit" type="button" tabindex="3" onclick="CargarInfo()">Buscar</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" aling="center">
                                <hr style="width:95%;margin-left: 2.5%;" aling="center" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" aling="center">
                                <div id="Rerporte" style="width: 95%;margin-left: 2.5%;height:auto;" aling="center"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" id="Cadena" />
            </fieldset>
        </div> 
        <?PHP
    }//public function Principal
    public function Periodo($Opcion,$Periodo_ini='',$Periodo_fin=''){
    global  $db;
    
    if($Opcion=='Actual'){
        $Condicion ='WHERE  codigoestadoperiodo=1';
    }else if($Opcion=='Cadena'){
        
        $Condicion ='WHERE  codigoperiodo BETWEEN "'.$Periodo_ini.'" AND "'.$Periodo_fin.'"';
    }else if($Opcion=='Todos'){
        
        $Condicion ='ORDER BY codigoperiodo DESC';//codigoestadoperiodo, 
    }
    
      $SQL='SELECT 

            codigoperiodo,
            codigoestadoperiodo
            
            FROM 
            
            periodo
            
            '.$Condicion;
            
        if($Periodo=&$db->Execute($SQL)===false){
            echo 'Error en Calcular el Periodo...<br><br>'.$SQL;
            die;
        } 
        
       if($Opcion=='Actual'){
            return $Periodo->fields['codigoperiodo'];
       }else if($Opcion=='Cadena' || $Opcion=='Todos'){
        
            $C_Periodo  = $Periodo->GetArray();
            
            return $C_Periodo;
       }    
  }//public function Periodo
   public function Respuesta($Codigoperiodo,$Carrera){
        global $db,$userid;
        
        include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
        
        $datos_estadistica=new obtener_datos_matriculas($db,$Codigoperiodo);
        
       
            $Cadena1 = $datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos($Carrera,'arreglo');    
        
            $Cadena2 = $datos_estadistica->No_Admitidos($Carrera,'arreglo');    
       
       
            $Result_1  = $this->DataEstudiante($Cadena1,1);
      
            $Result_2  = $this->DataEstudiante($Cadena2,2);
         
            $this->Unir($Result_1,$Result_2);
       
   }//public function Respuesta
   public function DataEstudiante($Cadena,$Op){ 
    global $db;
        $C_Data = array();
        if($Op==1){
            $Estado = 'Admitido';
        }else{
            $Estado = 'No Admitido';
        }
        for($i=0;$i<count($Cadena);$i++){
            /***********************************************/
              $SQL='SELECT 
    
                    CONCAT(es.nombresestudiantegeneral," ",es.apellidosestudiantegeneral) AS Nombre,
                    es.numerodocumento
                    
                    FROM estudiantegeneral  es INNER JOIN estudiante e ON e.idestudiantegeneral=es.idestudiantegeneral  
                    
                    WHERE
                    
                    e.codigoestudiante="'.$Cadena[$i]['codigoestudiante'].'"';
                    
                    
              if($Data=&$db->Execute($SQL)===false){
                echo 'Error en el SQL del data en el Indexe...<br>'.$i.' y el SQL <br>'.$SQL;
                die;
              }
              
              $C_Data[$i]['Nombre']           = $Data->fields['Nombre'];    
              $C_Data[$i]['Numerodocumento']  = $Data->fields['numerodocumento'];
              $C_Data[$i]['Codigoestudiante'] = $Cadena[$i]['codigoestudiante'];
              $C_Data[$i]['Estado']           = $Estado;
            /***********************************************/
        }//for
        
        return $C_Data;
       }//function DataEstudiante
    public function ModalidadAcademica(){
        global $db;
        
        $SQL='SELECT codigomodalidadacademica, nombremodalidadacademica FROM modalidadacademica  WHERE codigoestado=100';
        
        if($Modalidad=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de las Modalidades Academicas...<br><br>'.$SQL;
            die;
        }
        ?>
        <select id="Modalidad" name="Modalidad" style="width:auto;" onchange="Programa();">
            <option value="-1"></option>
            <?PHP 
            while(!$Modalidad->EOF){
                ?>
                <option value="<?PHP echo $Modalidad->fields['codigomodalidadacademica']?>"><?PHP echo $Modalidad->fields['nombremodalidadacademica']?></option>
                <?PHP
                $Modalidad->MoveNext();
            }//while
            ?>
        </select>
        <?PHP
    }//public function ModalidadAcademica   
    public function Programas($Modalidad){
        global $db;
        
        $SQL='SELECT codigocarrera, nombrecarrera FROM carrera WHERE  codigomodalidadacademica="'.$Modalidad.'" ORDER BY nombrecarrera ASC';
        
        if($Programa=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de los programas...<br><br>'.$SQL;
            die;
        }
        ?>
        <select id="Programa" name="Programa" style="width: auto;">
            <option value="-1"></option>
            <?PHP 
            while(!$Programa->EOF){
                ?>
                <option value="<?PHP echo $Programa->fields['codigocarrera']?>"><?PHP echo $Programa->fields['nombrecarrera']?></option>
                <?PHP
                $Programa->MoveNext();
            }//while
            ?>
        </select>
        <?PHP
    }//public function Programas
    public function Unir($Uno,$Dos){
        global $db;
        /*
        $C_Data[$i]['Nombre']           = $Data->fields['Nombre'];    
              $C_Data[$i]['Numerodocumento']  = $Data->fields['numerodocumento'];
              $C_Data[$i]['Codigoestudiante'] = $Cadena[$i]['codigoestudiante'];
              $C_Data[$i]['Estado']           = $Estado;
        */
        $Resultado = array();
        for($i=0;$i<count($Uno);$i++){
            $Resultado[$i]['Nombre']             = $Uno[$i]['Nombre'];
            $Resultado[$i]['Numerodocumento']    = $Uno[$i]['Numerodocumento'];
            $Resultado[$i]['Codigoestudiante']   = $Uno[$i]['Codigoestudiante'];
            $Resultado[$i]['Estado']             = $Uno[$i]['Estado'];
        }//for
        
        for($i=0;$i<count($Dos);$i++){
            $Num = count($Resultado);
            $Resultado[$Num]['Nombre']             = $Dos[$i]['Nombre'];
            $Resultado[$Num]['Numerodocumento']    = $Dos[$i]['Numerodocumento'];
            $Resultado[$Num]['Codigoestudiante']   = $Dos[$i]['Codigoestudiante'];
            $Resultado[$Num]['Estado']             = $Dos[$i]['Estado'];
        }//for
        
        //echo '<pre>';print_r($Resultado);
        ?>
        <style type="text/css" title="currentStyle">
                @import "../data/media/css/demo_page.css";
                @import "../data/media/css/demo_table_jui.css";
                @import "../data/media/css/ColVis.css";
                @import "../data/media/css/TableTools.css";
                @import "../data/media/css/ColReorder.css";
                @import "../data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../data/media/css/jquery.modal.css";
                
        </style>
        <script type="text/javascript" language="javascript" src="../data/media/js/jquery.js"></script>
        <script type="text/javascript" charset="utf-8" src="../jquery/js/jquery-3.6.0.js"></script>
        <script type="text/javascript" language="javascript" src="../data/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="../data/media/js/ColVis.js"></script>
        <script type="text/javascript" charset="utf-8" src="../data/media/js/ZeroClipboard.js"></script>
        <script type="text/javascript" charset="utf-8" src="../data/media/js/TableTools.js"></script>
        <script type="text/javascript" charset="utf-8" src="../data/media/js/FixedColumns.js"></script>
        <script type="text/javascript" charset="utf-8" src="../data/media/js/ColReorder.js"></script>
        <script type="text/javascript" language="javascript">
            
            $(document).ready( function () {//"sDom": '<Cfrltip>',
    				var oTable = $('#example').dataTable( {
    				    
      				"sDom": '<"H"Cfrltip>',
                            "bJQueryUI": true,
                            "bPaginate": true,
                            "sPaginationType": "full_numbers",
                            "oColVis": {
                                  "buttonText": "Ver/Ocultar Columns",
                                   "aiExclude": [ 0 ]
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
                             $('#demo_1').before( oTableTools.dom.container );
    			} ); 
            
        </script>
        <div id="demo_1">
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="example" style="width: 100%;" >
                <thead>
                    <tr>
                        <th><strong>N&deg;</strong></th>
                        <th><strong>Nombres Y Apellidos</strong></th>
                        <th><strong>N&deg; de Documento</strong></th>
                        <th><strong>Estado</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?PHP 
                    for($i=0;$i<count($Resultado);$i++){
                        
                        ?>
                        <tr>    
                            <td style="text-align: center;"><?PHP echo $i+1;?></td><!--num-->
                            <td style="text-align: center;"><?PHP echo $Resultado[$i]['Nombre'];?></td><!--Nombre-->
                            <td style="text-align: center;"><?PHP echo $Resultado[$i]['Numerodocumento'];?></td><!--Num Inscritos-->
                            <td style="text-align: center;"><?PHP echo $Resultado[$i]['Estado'];?></td><!--Entrevistas-->
                            </tr>
                        <?PHP
                    }//for
                    ?>
                </tbody>
            </table>
        </div> 
      <?PHP  
    }//public function Unir
}//class Reporte_AdmitidoNoAdmitidos



?>