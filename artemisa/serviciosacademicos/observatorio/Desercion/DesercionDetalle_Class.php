<?php
class DetalleDesercion{
	public function __construct (  ) {
		
	}
	
    public function Display($CodigoCarrera,$Periodo,$C_Datos,$Tipo=0,$op=''){
        global $db;
       // echo '<pre>';print_r($C_Datos);
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
        		var oTable = $('#example_1').dataTable( {
        		    
        			"sScrollX": "100%",
        			"sScrollXInner": "100,1%",
        			"bScrollCollapse": true,
                    "bPaginate": true,
                    "sPaginationType": "full_numbers",
        			"oColReorder": {
        				"iFixedColumns": 1
        			},
                    "oColVis": {
                            "buttonText": "Ver/Ocultar Columns",
                             "aiExclude": [ 0 ]
                      }
                 	
        		} );
        		//new FixedColumns( oTable );
                                
                                new FixedColumns( oTable, {
                                         "iLeftColumns": 2,
                                         "iLeftWidth": 550
        		} );
                                
                                 var oTableTools = new TableTools( oTable, {
        			"buttons": [
        				"copy",
        				"csv",
        				"xls",
        				"pdf",
        			]
                 });
                         $('#demo').before( oTableTools.dom.container );
        	} ); 
        </script>
        <div id="container">
            <div id="demo">
                <table cellpadding="0" cellspacing="0" border="1" class="display" id="example_1">
                    <thead>
                        <tr>
                            <th><strong>N&deg;</strong></th>
                            <th><strong>Nombres y Apellidos</strong></th>
                            <th><strong>Periodo de Inicio de la Carrera</strong></th>
                            <th><strong>Ultimo Periodo Cursado (Matriculado))</strong></th>
                            <th><strong>&Uacute;ltimo Semestre Cursado</strong></th>
                            <th><strong>Causa de Deserci&oacute;n</strong></th>
                            <th><strong>Acompañamiento del PAE</strong></th>
                            <th><strong>Riesgo Identificado</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP 
                        if($op==1){
                            $Data = $this->DetalleDesercion($CodigoCarrera,$Periodo,$Tipo);    
                            
                            for($i=0;$i<count($Data);$i++){ 
                                  $SQL='SELECT
                                        MAX(codigoperiodo) AS ultimoPeriodo,
                                        MAX(semestreprematricula) AS Semestre
                                        FROM
                                        prematricula 
                                        
                                        WHERE
                                        codigoestudiante="'.$Data[$i]['codigoestudiante'].'"
                                        AND
                                        codigoestadoprematricula IN(40,41)';
                                        
                                   if($PeriodoSalida=&$db->Execute($SQL)===false){
                                    echo 'error en el Sistema...';
                                    die;
                                   }     
                                ?>
                                <tr>
                                   <td style="text-align: center;"><?PHP echo $i+1;?></td>
                                   <td style="text-align: left;"><?PHP echo $Data[$i]['NombreCompleto'];?></td> 
                                   <td style="text-align: center;"><?PHP echo $Data[$i]['Periodo_inicial'];?></td> 
                                   <td style="text-align: center;"><?PHP if($Tipo==1){ echo $Periodo;} else {echo $PeriodoSalida->fields['ultimoPeriodo'];}?></td>
                                   <td style="text-align: center;"><?PHP echo $PeriodoSalida->fields['Semestre'][$j];?></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                </tr>
                                <?PHP
                            }//for
                        }else{
                      //  echo '<pre>';print_r($$C_Datos);
                            for($j=0;$j<count($C_Datos['CodigoEstudiante']);$j++){
                                  $SQL='SELECT
                                        MAX(p.codigoperiodo) AS ultimoPeriodo,
                                        MIN(p.codigoperiodo) AS PrimerPeriodo,
                                        MAX(p.semestreprematricula) AS Semestre,
                                        CONCAT(g.nombresestudiantegeneral, " ",g.apellidosestudiantegeneral) AS fullName
                                        FROM
                                        prematricula p 
                                        INNER JOIN estudiante e ON e.codigoestudiante=p.codigoestudiante
                                        INNER JOIN  estudiantegeneral g ON g.idestudiantegeneral=e.idestudiantegeneral
                                        
                                        WHERE
                                        p.codigoestudiante="'.$C_Datos['CodigoEstudiante'][$j].'"
                                        AND
                                        p.codigoestadoprematricula IN(40,41)';
                                        
                                  if($DataSalida=&$db->Execute($SQL)===false){
                                    echo 'error en el Sistema...';
                                    die;
                                   } 
                                ?>
                                <tr>
                                   <td style="text-align: center;"><?PHP echo $j+1;?></td>
                                   <td style="text-align: left;"><?PHP echo $DataSalida->fields['fullName'];?></td> 
                                   <td style="text-align: center;"><?PHP echo $DataSalida->fields['PrimerPeriodo'];?></td> 
                                   <td style="text-align: center;"><?PHP if($Tipo==1){ echo $Periodo;} else {echo $C_Datos['P_Salida'][$j];}?></td>
                                   <td style="text-align: center;"><?PHP echo $C_Datos['Semestre'][$j];?></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                </tr>
                                <?PHP
                            }//for
                        }
                        ?>
                    </tbody>
					</table>
            </div>
        </div>
        <?PHP
    }/*public function Display*/
		public function DetalleDesercion($CodigoCarrera,$Periodo,$tipo){
			global $db;
			$periodos = ' AND dd.codigoperiodo="'.$Periodo.'"';
			if($tipo==1){
				$periodos = ' AND dd.desercionperiodo="'.$Periodo.'"';
			}
			
			 $SQL='SELECT
                
                de.id_desercionestudiante AS id, 
                de.codigoestudiante,
                e.codigoperiodo as Periodo_inicial,
                e.idestudiantegeneral,
                CONCAT(eg.nombresestudiantegeneral," ",eg.apellidosestudiantegeneral) as NombreCompleto
                
                FROM
                
                desercion d INNER JOIN deserciondetalle dd ON d.id_desercion=dd.id_desercion
                						INNER JOIN desercionEstudiante de ON dd.id_detalledesercion=de.id_detalledesercion
                						INNER JOIN estudiante e ON de.codigoestudiante=e.codigoestudiante
                                        INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral
                					 
                
                WHERE
                
                d.codigocarrera="'.$CodigoCarrera.'"
                AND
                d.tipodesercion="'.$tipo.'"  
                '.$periodos.'  
                AND
                d.codigoestado=100
                AND
                dd.codigoestado=100
                AND de.codigoestado=100';
               // echo $SQL; die;
           if($Estudiantes=&$db->Execute($SQL)===false){
                echo 'Errro en el SQL de Buscar...'.$SQL;
                die;
           }  
           
           $R_Estudiante = $Estudiantes->GetArray();  
           
           return $R_Estudiante; 
		}/*public function DetalleDesercion*/
		
	
		public function SiguientePeriodo($Periodo){
			global $db;
			
			 $SQL='SELECT                 
                codigoperiodo                 
                FROM                 
                periodo 
                WHERE                
                codigoperiodo>"'.$Periodo.'"
               ORDER BY codigoperiodo ASC LIMIT 1';
               // echo $SQL; die;
           if($Estudiantes=&$db->Execute($SQL)===false){
                echo 'Errro en el SQL de Buscar...'.$SQL;
                die;
           }  
         
           $R_Estudiante = $Estudiantes->GetArray();  
          
           return $R_Estudiante[0]["codigoperiodo"]; 
		}/*public function SiguientePeriodo*/
		
		public function PeriodoAnterior($Periodo){
			global $db;
			
			 $SQL='SELECT                 
                codigoperiodo                 
                FROM                 
                periodo 
                WHERE                
                codigoperiodo<"'.$Periodo.'"
               ORDER BY codigoperiodo DESC LIMIT 1';
               // echo $SQL; die;
           if($Estudiantes=&$db->Execute($SQL)===false){
                echo 'Errro en el SQL de Buscar...'.$SQL;
                die;
           }  
         
           $R_Estudiante = $Estudiantes->GetArray();  
          
           return $R_Estudiante[0]["codigoperiodo"]; 
		}/*public function PeriodoAnterior*/
		
	}/*class DetalleDesercion*/
?>