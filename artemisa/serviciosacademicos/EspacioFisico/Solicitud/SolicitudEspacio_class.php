<?PHP 
session_start();
class SolicitudEspacio{
    public function Principal(){
        //var_dump(is_file('../../../mgi/js/jquery.js'));die;  .
          
           
         ?>
        <script type="text/javascript" language="javascript" src="../js/jquery.bpopup.min.js"></script>
        <fieldset style="width: auto;">
        	<legend>Solicitud de Espacios F&iacute;sicos</legend>
                <form id="SolicitudEspacio">
                    <input id="actionID" name="actionID" type="hidden" value="Save" />
                    <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 65%; margin-left: 10%;">
                        <thead>
                           <?PHP 
                            if($_SESSION['codigofacultad']==1){
                                ?>
                                <tr>
                                    <th style="text-align: left;">Modalidad Acad&eacute;mica</th>
                                    <th><?PHP echo $this->Modalidad();?></th>
                                    <th colspan="2">&nbsp;</th>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Programa Acad&eacute;mico</th>
                                    <th id="Th_Progra">
                                        <select id="Programa" name="Programa" style="width:80%;">
                                            <option value="-1"></option>
                                        </select>
                                    </th>
                                    <th colspan="2">&nbsp;</th>
                                </tr>
                                <?PHP
                            }else{
                                ?>
                                <tr>
                                    <th style="text-align: left;">Programa Acad&eacute;mico</th>
                                    <th>
                                    <?PHP 
                                        $this->Programa('',$_SESSION['codigofacultad']);
                                    ?>
                                    </th>
                                    <th colspan="2">&nbsp;</th>
                                </tr>
                                <?PHP
                            }
                           ?>
                                <tr>
                                    <th style="text-align: left;">Materia</th>
                                    <th id="Th_Materia"><?PHP $this->Materia()?></th>
                                    <th style="text-align: left;">Grupo</th>
                                    <th id="Th_Grupo"><?PHP $this->Grupo()?></th>
                               </tr>
                               <tr>
                                    <th style="text-align: left;">Numero De Estudiantes</th>
                                    <th>
                                        <input type="text" readonly="readonly" id="NumEstudiantes" name="NumEstudiantes" style="text-align: center;" placeholder="Digite Numero de Estudiantes" size="45" />
                                    </th>
                                    <th style="text-align: left;">Acceso a Discapacitados</th>
                                    <th>
                                        <input type="checkbox" id="Acceso" name="Acceso" />
                                    </th>
                               </tr>
                               <tr>
                                    <th style="text-align: left;">Campus</th>
                                    <th id="Th_Campus"><?PHP $this->EspacioCategoria('Campus',3,'');?></th> 
                                    <th colspan="2">&nbsp;</th>
                               </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">
                                    <fieldset>
                                        <legend>Periodicidad</legend>
                                        <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 100%;">
                                            <tr>
                                                <td colspan="2">
                                                    <table>
                                                        <tr>
                                                        <?PHP $this->FechaBox('Fecha Inicial','FechaIni','Fecha Inicial','','','','../');?>
                                                        <?PHP $this->FechaBox('Fecha Final','FechaFin','Fecha Final','','','','../');?>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <?PHP $this->Periocidad()?>
                                                </td>
                                                <td>
                                                <?PHP $this->Horario()?>    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: right;">
                                                    <img src="../../mgi/images/calendar.png" title="Click para Configuracion Final" style="cursor: pointer;" width="50" id="my-button" onclick="VerCalendario()"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <div id="VentanaNew" ></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Observaciones</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: center;">
                                    <textarea id="Observacion" name="Observacion" cols="160" rows="10"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;">
                                    <input type="button" id="SaveSolicitud" name="SaveSolicitud" value="Guardar" onclick="SolicitudSave();" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
        </fieldset>
        <?PHP
    }//public function Principal
    public function Modalidad($Url){ 
        global $db;
        
        if(!$db){
           //var_dump(is_file("../../templates/template.php"));die; 
           include_once("../../templates/template.php");
		
		   $db = getBD();
         }
         
        // echo '<pre>';print_r($db);
        
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
        <select id="Modalidad" name="Modalidad" style="width: auto;" onchange="BuscarPrograma();">
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
    public function Programa($Modalidad='',$Programa_id=''){
        global $db;
        
        if(!$db){
           //var_dump(is_file("../../templates/template.php"));die; 
           include_once("../../templates/template.php");
		
		   $db = getBD();
         }
        
        if($Modalidad){
            $Condicion = 'codigomodalidadacademica="'.$Modalidad.'"';
        }else{
            $Condicion = 'codigocarrera="'.$Programa_id.'"';
        }
        
          $SQL='SELECT 

                codigocarrera AS id,
                nombrecarrera AS Nombre 
                
                FROM carrera
                
                WHERE
                
                '.$Condicion.'
                
                ORDER BY  nombrecarrera ASC';
                
          if($Programa=&$db->Execute($SQL)===false){
                echo 'Error En el SQL .....<br><br>'.$SQL;
                die;
          }   
        ?>
        <select id="Programa" name="Programa" style="width:80%;" onchange="BuscarMateria();">
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
    public function Materia($Programa_id){
        global $db;
        
        if(!$db){
           //var_dump(is_file("../../templates/template.php"));die; 
           include_once("../../templates/template.php");
		
		   $db = getBD();
         }
        
          $SQL='SELECT 
          
                        m.nombremateria AS Nombre,
                        m.codigomateria AS id
                
                FROM 
                        grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria
        						INNER JOIN carrera c ON c.codigocarrera=m.codigocarrera
        						INNER JOIN periodo p ON p.codigoperiodo=g.codigoperiodo
        
                WHERE
                
                        p.codigoestadoperiodo=1
                        AND
                        c.codigocarrera="'.$Programa_id.'"
                
                GROUP BY m.codigomateria
                
                ORDER BY m.nombremateria ASC';
                
           if($Materia=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de las Materias..<br><br>'.$SQL;
                die;
           } 
       ?>
       <select id="Materia" name="Materia" style="width: 80%;" onchange="BuscarGrupo();">
        <option value="-1"></option>
        <?PHP 
            while(!$Materia->EOF){
                ?>
                <option value="<?PHP echo $Materia->fields['id']?>"><?PHP echo $Materia->fields['Nombre']?></option>
                <?PHP
                $Materia->MoveNext();
            }
        ?>
       </select>
       <?PHP        
    }//public function Materia
    public function Grupo($Programa_id,$Materia_id){
        global $db;
        
        
        if(!$db){
           //var_dump(is_file("../../templates/template.php"));die; 
           include_once("../../templates/template.php");
		
		   $db = getBD();
         }
         
        $SQL='SELECT 

                        g.idgrupo,
                        g.codigogrupo,
                        g.nombregrupo,
                        m.nombremateria,
                        g.codigoperiodo,
                        m.codigomateria
                
                FROM grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria
    						 INNER JOIN carrera c ON c.codigocarrera=m.codigocarrera
    						 INNER JOIN periodo p ON p.codigoperiodo=g.codigoperiodo
                
                WHERE
                
                    p.codigoestadoperiodo=1
                    AND
                    c.codigocarrera="'.$Programa_id.'"
                    AND
                    g.codigomateria="'.$Materia_id.'"';
                    
         if($Grupo=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de los Grupos...<br><br>'.$SQL;
            die;
         }          
         ?>
         <select id="Grupo" name="Grupo" onchange="MaxCupo()">
            <option value="-1"></option>
            <?PHP 
            while(!$Grupo->EOF){
                ?>
                <option value="<?PHP echo $Grupo->fields['idgrupo']?>"><?PHP echo $Grupo->fields['nombregrupo']?></option>
                <?PHP
                $Grupo->MoveNext();
            }
            ?>
         </select>
         <?PHP 
    }//public function Grupo
     public function EspacioCategoria($name,$filtro,$funcion='',$op='',$id=''){
        global $db;
        
        if(!$db){
           //var_dump(is_file("../../templates/template.php"));die; 
           include_once("../../templates/template.php");
		
		   $db = getBD();
         }
        
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
                codigoestado=100'.$Add;
                
        if($Respuesta=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Campus...<br><br>'.$SQL;
            die;
        }  
        
            
        ?>
        <select <?PHP echo $disabled?> onchange="<?PHP echo $funcion?>" name="<?PHP echo $name?>" id="<?PHP echo $name?>" style="width: 80%;">
            <option value="-1"></option>
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
    public function Periocidad(){
        global $db;
        
        if(!$db){
           //var_dump(is_file("../../templates/template.php"));die; 
           include_once("../../templates/template.php");
		
		   $db = getBD();
         }
        
        $SQL='SELECT idsiq_periodicidad AS id, periodicidad AS Nombre, valor, tipo_valor 
              FROM siq_periodicidad 
              WHERE  idsiq_periodicidad IN(3,35,36)
              ORDER BY tipo_valor';
              
              
        if($Frecuencia=&$db->Execute($SQL)===false){
            echo 'Error en el SQl ...<br><br>'.$SQL;
            die;
        }    
        
       ?>
       <fieldset id="Frecu_Cont">
            <legend>Frecuencia</legend>
            <input type="hidden" id="FrecuenciaOnline" name="FrecuenciaOnline" />
            <table>
                <?PHP 
                while(!$Frecuencia->EOF){
                    ?>
                    <tr>
                        <td><?PHP echo $Frecuencia->fields['Nombre']?></td>
                        <td>
                            <input type="radio" id="Fre_<?PHP echo $Frecuencia->fields['id']?>" name="Frecuencia" value="<?PHP echo $Frecuencia->fields['id']?>" onclick="CargarFrecuencia('<?PHP echo $Frecuencia->fields['id']?>');"  />
                        </td>
                    </tr>
                    <?PHP
                    $Frecuencia->MoveNext();
                }
                ?>
            </table>
        </fieldset>
      <?PHP   
    }//public function Periocidad
    public function Horario(){
        
        global $db;
        
        if(!$db){
           //var_dump(is_file("../../templates/template.php"));die; 
           include_once("../../templates/template.php");
		
		   $db = getBD();
         }
        
        include_once('../Administradores/Admin_Categorias_class.php');  $C_Admin_Categorias = new Admin_Categorias();
        
        $SQL='SELECT codigodia, nombredia FROM dia';
        
        if($Dia=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Dia...<br><br>'.$SQL;
            die;
        }
        
       
        ?>
        
        <fieldset style="width: 100%;">
            <legend>Horario</legend>
            <input type="hidden" id="DiasOnline" name="DiasOnline" />
            <input type="hidden" id="numIndices" name="numIndices" value="0" />
            <table style="border: black 1px solid; width: 90%; margin-left: 1%; margin-right: 5%;" id="TablaHorario" >
                <tr id="Tr_Dias">
                    <?PHP 
                    $i=0;
                    while(!$Dia->EOF){
                        $l = $C_Admin_Categorias->ispar($i);
                        if($l==1){
                            $color = 'background:#F2EAFB;';
                        }else{
                            $color = 'background:#F7FFFF;';
                        }
                        ?>
                        <td style="border: black 1px solid;<?PHP echo $color?>font-size: 14px;">
                            <div style="text-align: left; width: 50%; float: left;">
                                <?PHP echo $Dia->fields['nombredia']?>
                            </div>
                            <div style="text-align: right; width: 30%; float: right;">
                                <input style=" float: right;" type="checkbox"  onclick="DiasCargar('<?PHP echo $Dia->fields['codigodia']?>');" id="Dia_<?PHP echo $Dia->fields['codigodia']?>" name="DiaSemana[]" value="<?PHP echo $Dia->fields['codigodia']?>" />
                            </div>    
                        </td>
                        <?PHP
                        $i++;
                        $Dia->MoveNext();
                    }    
                    ?>
                </tr>
                <tr style="border: black 1px solid;" id="trNewDetalle0">
                   <?PHP 
                   for($x=1;$x<=$i;$x++){
                    ?>
                    <td style="border: black 1px solid;">
                        <label style="font-size: 14px;">Hora Inicial</label>
                        <input type="text" size="10" id="HoraInicial_<?PHP echo $x?>" name="HoraInicial_0[]" readonly="readonly" style="text-align: center;" placeholder="Hora Inicial" />
                        <br />
                        <label style="font-size: 14px;">Hora Final</label>
                        <input type="text" size="10" id="HoraFin_<?PHP echo $x?>" name="HoraFin_0[]" readonly="readonly" style="text-align: center;" placeholder="Hora Final" />
                    </td>
                    <script>
                        $("#HoraInicial_<?PHP echo $x?>").clockpick({
                        starthour : 6,
                        endhour : 23,
                        showminutes : true
                        });
                        $("#HoraFin_<?PHP echo $x?>").clockpick({
                        starthour : 6,
                        endhour : 23,
                        showminutes : true
                        });
                        </script>
                    <?PHP
                   }
                   ?> 
                </tr>
                
            </table>
            <input type="button" value="+" onclick="AddTr()" />
            <input type="button" value="-" onclick="DeleteTr()" />
        </fieldset>
        <?PHP
    }//public function Horario
    public function FechaBox($Label,$name,$Ejemplo='',$value='',$readonly='',$Ver='',$url=''){
        global $db;
        
        if(!$db){
           //var_dump(is_file("../../templates/template.php"));die; 
           include_once("../../templates/template.php");
		
		   $db = getBD();
         }
       
        ?>
        <td style="text-align: left;"><?PHP echo $Label?> &nbsp;<span style="color: red;">*</span></td>
        <td>
            <input type="text" id="<?PHP echo $name?>" name="<?PHP echo $name?>" size="12" style="text-align:center;" readonly="readonly" value="<?PHP echo $value?>" placeholder="<?PHP echo $Ejemplo?>" <?PHP echo $readonly;?> />
        </td>
        <?PHP 
        if($Ver!=1){
            ?>
            <script type="text/javascript" >
               $(document).ready(function(){
        		$("#<?PHP echo $name?>").datepicker({ 
        			changeMonth: true,
        			changeYear: true,
        			showOn: "button",
        			buttonImage: "<?PHP echo $url?>../../css/themes/smoothness/images/calendar.gif",
        			buttonImageOnly: true,
        			dateFormat: "yy-mm-dd"
        		});
                $('#ui-datepicker-div').css('display','none');
              }); 
            </script>
            <?PHP
        }
        ?>
        
        <?PHP
    }//public function FechaBox
    public function Calendario(){
        global $db;
        if(!$db){
           //var_dump(is_file("../../templates/template.php"));die; 
           include_once("../../templates/template.php");
		
		   $db = getBD();
         }
       
        include_once('../wdCalendar/wdCalendar/sample.php');
        
        ?>
       
        <?PHP
    }//public function Calendario
    public function AddTrNew($NumFiles){
       global $db;
       if(!$db){
           //var_dump(is_file("../../templates/template.php"));die; 
           include_once("../../templates/template.php");
		
		   $db = getBD();
         }
        
       $i = 7; 
       
       for($x=1;$x<=$i;$x++){
        ?>
        <td style="border: black 1px solid;">
            <label style="font-size: 14px;">Hora Inicial</label>
            <input type="text" size="10" id="HoraInicial_<?PHP echo $x?>_<?PHP echo $NumFiles?>" name="HoraInicial_<?PHP echo $NumFiles?>[]" readonly="readonly" style="text-align: center;" placeholder="Hora Inicial" />
            <br />
            <label style="font-size: 14px;">Hora Final</label>
            <input type="text" size="10" id="HoraFin_<?PHP echo $x?>_<?PHP echo $NumFiles?>" name="HoraFin_<?PHP echo $NumFiles?>[]" readonly="readonly" style="text-align: center;" placeholder="Hora Final" />
        </td>
        <script>
            $("#HoraInicial_<?PHP echo $x?>_<?PHP echo $NumFiles?>").clockpick({
            starthour : 6,
            endhour : 23,
            showminutes : true
            
            });
            $("#HoraFin_<?PHP echo $x?>_<?PHP echo $NumFiles?>").clockpick({
            starthour : 6,
            endhour : 23,
            showminutes : true
            });
            </script>
        <?PHP
       }
               
    }//public function AddTrNew
    public function CalcularFechas($Datos){ 
        //global $db,$userid;
        //var_dump(is_file("../../../templates/template.php"));die;
        include_once("../../../templates/template.php");
		
		$db = getBD();
        //echo '<pre>';print_r($db);die;
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
        
        //echo '<pre>';print_r($Datos);
        
        $Fecha_inicial = $Datos['FechaIni'];
        $Fecha_final   = $Datos['FechaFin'];
        $Frecuencia    = $Datos['Frecuencia'];//valores 3 -> Mese , 36-> Quincenal , 35-> Semanal // tipos ->1	días , 2	meses , 3	años , 
        /*
        semana se suman 7 dias
        Quincenal       14 dias
        mes             30 dias.
        */
        $C_dias        = $Datos['DiaSemana'];//Arregloa o Array
        $numIndices    = $Datos['numIndices'];//index de cuantas horas tiene el horario ejemplo [HoraInicial_0][HoraInicial_1] y susecivamente al igual con la hora final HoraFin.
        $sede          = $Datos['sede'];//sede
        /******************************************************************************/
        /*
          Array
                (
                    [events] => Array
                                    (
                                        [0] => Array
                                            (
                                                [0] => 51695            -->id
                                                [1] => annual report    -->Titulo, tipo salon 
                                                [2] => 06/19/2014 02:06 -->Fecha Y hora de inicio 
                                                [3] => 01/01/1970 01:43 -->Fecha y Hora final
                                                [4] => 0                -->Visulizar es mejor cero=0
                                                [5] => 0                -->Evento mas DE Un DIA
                                                [6] => 0                -->Evento Concurrente
                                                [7] => rand(-1,13)      -->Color
                                                [8] => 1                -->Editable 
                                                [9] => Belion           -->Localizacion
                                                [10] => 
                                            )
                                           
                                    )
                
                    [issort] => 1
                    [start] => 06/09/2014 00:00
                    [end] => 06/15/2014 23:59
                    [error] => 
                )
          */
          
        $FechaFuturas = $this->FechasFuturas($Frecuencia,$Fecha_inicial,$Fecha_final,$C_dias);
        
        //echo '<pre>';print_r($FechaFuturas);
        
         
            $Horas = array();
             
            $num = count($C_dias);
            
            for($i=0;$i<$num;$i++){
                /************************************************************/
                for($j=0;$j<=$numIndices;$j++){
                    /********************************************************/
                      $x         = $C_dias[$i]-1;
                      
                      $Hora_ini  = $Datos['HoraInicial_'.$j][$x];  
                      $Hora_fin  = $Datos['HoraFin_'.$j][$x];
                      
                      $C_HoraIni = explode(' ',$Hora_ini);
                      $C_HoraFin = explode(' ',$Hora_fin);
                      
                      if($Hora_ini){  
                        if($C_HoraIni[1]=='AM'){
                            $Horas['Inicial'][$i][] = $C_HoraIni[0];
                        }else{
                            $H = explode(':',$C_HoraIni[0]);
                            if($H[0]==12){
                                
                                $Horas['Inicial'][$i][] =  $H[0].':'.$H[1]; 
                            }else{
                                $H_ini = $H[0]+12;
                                $Horas['Inicial'][$i][]   = $H_ini.':'.$H[1];    
                            }//if
                            
                        }//if
                        
                      }//if 
                      if($Hora_fin){ 
                         if($C_HoraFin[1]=='AM'){
                            $Horas['Final'][$i][]   = $C_HoraFin[0];
                        }else{
                            $H = explode(':',$C_HoraFin[0]);
                            if($H[0]==12){
                                $Horas['Final'][$i][]   = $H[0].':'.$H[1];
                            }else{
                                $H_fin = $H[0]+12;
                                $Horas['Final'][$i][]   = $H_fin.':'.$H[1];
                            }
                        }
                      } 
                    /********************************************************/
                }//for
                /************************************************************/
            }//for  
            
            $C_Result = array();
            $X_Result = array();
            $n = 0;
            
            for($i=0;$i<$num;$i++){
                /******************************************************************/
                for($x=0;$x<count($FechaFuturas[$i]);$x++){
                    /**************************************************************/
                        for($l=0;$l<count($Horas['Inicial'][$i]);$l++){
                            /******************************************************/
                               $Fecha = $this->FormatoFecha($FechaFuturas[$i][$x]);
                               
                               $C_Result[$n][] = $Fecha.' '.$Horas['Inicial'][$i][$l];
                               $C_Result[$n][] = $Fecha.' '.$Horas['Final'][$i][$l];
                               /****************************************************/
                               $X_Result[$n][] = $FechaFuturas[$i][$x].' '.$Horas['Inicial'][$i][$l];
                               $X_Result[$n][] = $FechaFuturas[$i][$x].' '.$Horas['Final'][$i][$l];
                               $n++;
                            /******************************************************/
                        }//for
                    /**************************************************************/
                }//for
                /******************************************************************/
            }//for
            
            
            $Result = array();
            
            if($Frecuencia!=3){
                
                $Update_temp='UPDATE temp_solicitud
                          SET    codigoestado=200
                          WHERE  usuario="'.$userid.'" AND codigoestado=100';
                              
                if($Inactivar=&$db->Execute($Update_temp)===false){
                    echo 'Error en el Update de Incativar<br><br>'.$Update_temp;
                    die;
                 } 
                
            }
           
            for($t=0;$t<count($C_Result);$t++){
                /**********************************************************************/
                   
                
                $SQL_Temp='SELECT 
                                  id_temp,
                                  DATE(fecha_ini) AS f_inicial
                           
                           FROM   temp_solicitud 
                           
                           WHERE  usuario="'.$userid.'" 
                                  AND 
                                  fecha_ini="'.$X_Result[$t][0].'" 
                                  AND 
                                  fecha_fin="'.$X_Result[$t][1].'" 
                                  AND 
                                  codigoestado=200';
                                  
                 if($Existe_Temp=&$db->Execute($SQL_Temp)===false){
                    echo 'Error en el SQL Temp <br><br>'.$SQL_Temp;
                    die;
                 }                 
                
                if(!$Existe_Temp->EOF){
                    
                    $id = $Existe_Temp->fields['id_temp'];
                    
                    $C_DatosDia = explode('-',$Existe_Temp->fields['f_inicial']);
                    
                    $dia  = $C_DatosDia[2];
                    $mes  = $C_DatosDia[1];
                    /******************************************************************************/
                    
                    include_once('festivos.php');
                    $C_Festivo  = new festivos();
                    
                    $Festivo = $C_Festivo->esFestivo($dia,$mes);
                    
                    /******************************************************************************/
                    
                    if($Festivo==false){//$Festivo
                    
                        $Update_temp='UPDATE temp_solicitud
                                      SET    codigoestado=100,
                                             start="'.$Fecha_inicial.'",
                                             end="'.$Fecha_final.'",
                                             sede="'.$sede.'"
                                      WHERE  usuario="'.$userid.'" AND  id_temp="'.$id.'"';
                                  
                         if($Activar=&$db->Execute($Update_temp)===false){
                            echo 'Error en el Update de Activar <br><br>'.$Update_temp;
                            die;
                         } 
                   }//$Festivo 
                }else{
                        
                /**********************************************************************/
                    include_once('festivos.php');
                    $C_Festivo  = new festivos();
                    
                    
                    $C_Fecha     = explode(' ',$X_Result[$t][0]);
                    $C_DatosDia  = explode('-',$C_Fecha[0]);
                    
                    $dia  = $C_DatosDia[2];
                    $mes  = $C_DatosDia[1];
                    $Year  = $C_DatosDia[0];
                   
                    $Festivo = $C_Festivo->esFestivo($dia,$mes,$Year);
                /**********************************************************************/
                    if($Festivo==false){//$Festivo
                    
                        $DiaSemana = $this->DiasSemana($X_Result[$t][0]);
                    
                        $Insert_temp='INSERT INTO  temp_solicitud(id_tiposalon,fecha_ini,fecha_fin,start,end,usuario,sede,codigodia)VALUES("32","'.$X_Result[$t][0].'","'.$X_Result[$t][1].'","'.$Fecha_inicial.'","'.$Fecha_final.'","'.$userid.'","'.$sede.'","'.$DiaSemana.'")';
                        
                        if($TempDatos=&$db->Execute($Insert_temp)===false){
                            echo 'Error en el SQL <br><br>'.$Insert_temp;
                            die;
                        }
                        
                        $id=$db->Insert_ID();
                    
                    }//$Festivo
                }
                /**********************************************************************/
                $SQL='SELECT 
    
                     
                      s.nombretiposalon,
                      t.status
                    
                      FROM temp_solicitud t  INNER JOIN tiposalon s ON s.codigotiposalon=t.id_tiposalon
                    
                      WHERE t.id_temp="'.$id.'" AND t.codigoestado=100  AND t.status=0';//AND t.status=0
             
             if($SelectTemp=&$db->Execute($SQL)===false){
                echo 'Error en el SQl de Data Tem...<br><br>'.$SQL;
                die;
             }
             if(!$SelectTemp->EOF){
                /**********************************************************************/
                    //$Result['events'][$t][]  = $id;
    //                $Result['events'][$t][]  = $SelectTemp->fields['nombretiposalon']; 
    //                $Result['events'][$t][]  = $C_Result[$t][0];
    //                $Result['events'][$t][]  = $C_Result[$t][1];
    //                $Result['events'][$t][]  = 0;//0              
    //                $Result['events'][$t][]  = 0;               
    //                $Result['events'][$t][]  = 0;               
    //                $Result['events'][$t][]  = rand(-1,13);      
    //                $Result['events'][$t][]  = 1;               
    //                $Result['events'][$t][]  = 'Sin Localizacion';          
    //                $Result['events'][$t][] = '';
                /******************************************************************/
               }    
            }//for
            $Fecha_1 = $this->FormatoFecha($Fecha_inicial);
            $Fecha_2 = $this->FormatoFecha($Fecha_final);            
                
            //$Result['issort'] = true;
    //        $Result['start']  = $Fecha_1.' 00:00';
    //        $Result['end']    = $Fecha_2.' 23:59';
    //        $Result['error']  = null;
            
            if($Frecuencia==3){ 
                $Result = $this->ViewFechas($db,$userid,$Fecha_inicial,$Fecha_final);
            }else{
                $Result = $this->ViewFechas($db,$userid);    
            }
            
            
            return $Result;
      
       
       /******************************************************************************/
    }//public function CalcularFechas
     public function CalcularFechasArray($Datos){ 
        include_once('festivos.php');               $C_Festivo          = new festivos();
       
        $Fecha_inicial = $Datos['FechaIni'];
        $Fecha_final   = $Datos['FechaFinal'];
        $Frecuencia    = 35;//valores 3 -> Mese , 36-> Quincenal , 35-> Semanal // tipos ->1	días , 2	meses , 3	años , 
        /*
        semana se suman 7 dias
        Quincenal       14 dias
        mes             30 dias.
        */
        $C_dias        = $Datos['DiaSemana'];//Arregloa o Array
        $numIndices    = $Datos['numIndices'];//index de cuantas horas tiene el horario ejemplo [HoraInicial_0][HoraInicial_1] y susecivamente al igual con la hora final HoraFin.
        //$sede          = $Datos['Campus_'];//sede
        /******************************************************************************/
      
        $FechaFuturas = $this->FechasFuturas($Frecuencia,$Fecha_inicial,$Fecha_final,$C_dias);
        
        $NumResult = count($FechaFuturas);
        
        $N_Result = array();
        
        for($i=0;$i<$NumResult;$i++){
            /**********************************************/
            for($j=0;$j<count($FechaFuturas[$i]);$j++){
                /******************************************/
                $C_Fecha     = explode('-',$FechaFuturas[$i][$j]);
                
                $dia  = $C_Fecha[2];
                $mes  = $C_Fecha[1];
                $Year  = $C_Fecha[0];
               
                $Festivo = $C_Festivo->esFestivo($dia,$mes,$Year);
                
                if($Festivo==false){//$Festivo
                    $N_Result[$i][]=$FechaFuturas[$i][$j];        
                }//if
                /******************************************/
            }//for
            /**********************************************/
        }//for
            
        return $N_Result;
      
       
       /******************************************************************************/
    }//public function CalcularFechasArray
    public function ViewFechas($db,$userid,$F_1='',$F_2=''){
                 
           $SQL='SELECT 

                 t.id_temp,
                 t.id_tiposalon,
                 DATE(t.fecha_ini) AS f_inicial,
                 DATE(t.fecha_fin) AS f_final,
                 TIME(t.fecha_ini) AS h_inicial,
                 TIME(t.fecha_fin) AS h_final,
                 t.`start`,
                 t.`end`,
                 s.nombretiposalon
                
                
                 FROM temp_solicitud t  INNER JOIN tiposalon s ON s.codigotiposalon=t.id_tiposalon
                
                 WHERE t.usuario="'.$userid.'" AND t.codigoestado=100 AND t.status=0';
         
         if($SelectTemp=&$db->Execute($SQL)===false){
            echo 'Error en el SQl de Data Tem...<br><br>'.$SQL;
            die;
         }
         
         $C_Data = $SelectTemp->GetArray();
         
         if(count($C_Data)!=0){
             for($t=0;$t<count($C_Data);$t++){
                /**************************************************/
                $F_inicial = $this->FormatoFecha($C_Data[$t]['f_inicial']);
                $F_final   = $this->FormatoFecha($C_Data[$t]['f_final']);
                /**************************************************/
                    $Result['events'][$t][]  = $C_Data[$t]['id_temp'];
                    $Result['events'][$t][]  = $C_Data[$t]['nombretiposalon'];; 
                    $Result['events'][$t][]  = $F_inicial.' '.$C_Data[$t]['h_inicial'];
                    $Result['events'][$t][]  = $F_final.' '.$C_Data[$t]['h_final'];
                    $Result['events'][$t][]  = 0;              
                    $Result['events'][$t][]  = 0;               
                    $Result['events'][$t][]  = 0 ;               
                    $Result['events'][$t][]  = rand(-1,13);      
                    $Result['events'][$t][]  = 1;               
                    $Result['events'][$t][]  = 'Sin Localizacion';          
                    $Result['events'][$t][] = '';
                /**************************************************/
                $Fecha_1 = $this->FormatoFecha($C_Data[$t]['start']);
                $Fecha_2 = $this->FormatoFecha($C_Data[$t]['end']);        
                /**************************************************/
             }//for
        }else{
            $Result['events'] = '';      
        }
        
        if($F_1 && $F_2){
             $Fecha_1 = $this->FormatoFecha($F_1);
             $Fecha_2 = $this->FormatoFecha($F_2);  
             
        }
            
        $Result['issort'] = true;
        $Result['start']  = $Fecha_1.' 00:00';
        $Result['end']    = $Fecha_2.' 23:59';
        $Result['error']  = null;
        
        return $Result;
    }//public function ViewFechas
    public function FechasFuturas($Frecuencia,$Fecha_inicial,$Fecha_final,$C_dias){
       // global $db;
       
        switch($Frecuencia){
            case '3':{
                /**********************************************************/
                $Fecha_1 = $this->FormatoFecha($Fecha_inicial);
                $Fecha_2 = $this->FormatoFecha($Fecha_final);    
                
                $F_New['events'] = '';
                $F_New['issort'] = true;
                $F_New['start']  = $Fecha_1.' 00:00';
                $F_New['end']    = $Fecha_2.' 23:59';
                $F_New['error']  = null;
                /**********************************************************/
            }break;
            case '36':{
                /**********************************************************/
                $F_New = array();
                
                $Dia = $this->DiasSemana($Fecha_inicial);
                
                $num = count($C_dias);
                
                for($i=0;$i<$num;$i++){
                    
                    $C_Dia = $C_dias[$i];
                    
                    if($C_Dia==$Dia){
                        
                        $FechaCalculada = $Fecha_inicial;
                        
                        $F_New[$i][]    = $FechaCalculada;
                        
                    }else{
                        
                        $Dia_1 = $C_Dia-$Dia;
                        
                         if($Dia_1>0){   
                             
                             $FechaCalculada = $this->dameFecha($Fecha_inicial,$Dia_1);
                             
                             $F_New[$i][]    = $FechaCalculada;  
                             
                         }else{
                            
                            $FechaCalculada_2 = $this->dameFecha($Fecha_inicial,$Dia_1);
                            
                            $FechaCalculada   = $this->dameFecha($FechaCalculada_2,7);
                            
                            $F_New[$i][]      = $FechaCalculada;  
                         }     
                       
                        
                    }
                   
                    while(strtotime($Fecha_final)>=strtotime($FechaCalculada)){
                        
                            $X = $this->compararFechas($FechaCalculada,$Fecha_final);
                            
                            if($X>=14){
                                            
                                $FechaCalculada = $this->dameFecha($FechaCalculada,14);
                                
                                $F_New[$i][]    = $FechaCalculada;
                            
                            }else{
                                $FechaCalculada = $this->dameFecha($FechaCalculada,14); 
                            }//if
                        
                    }//while
                    
                }//for
                /**********************************************************/
            }break;
            case '35':{
                //echo '<pre>';print_r($C_dias);die;
                /**********************************************************/
                $F_New = array();
                
                $Dia = $this->DiasSemana($Fecha_inicial);
                
                $num = count($C_dias);
                
                for($i=0;$i<$num;$i++){
                    
                    $C_Dia = $C_dias[$i];
                    
                    if($C_Dia==$Dia){
                        
                        $FechaCalculada = $Fecha_inicial;
                        
                        $F_New[$i][]    = $FechaCalculada;
                        
                    }else{
                        
                        $Dia_1 = $C_Dia-$Dia;
                        
                         if($Dia_1>0){   
                             
                             $FechaCalculada = $this->dameFecha($Fecha_inicial,$Dia_1);
                             
                             $F_New[$i][]    = $FechaCalculada;  
                             
                         }else{
                            
                            $FechaCalculada_2 = $this->dameFecha($Fecha_inicial,$Dia_1);
                            
                            $FechaCalculada   = $this->dameFecha($FechaCalculada_2,7);
                            
                            $F_New[$i][]      = $FechaCalculada;  
                         }     
                       
                        
                    }
                   
                    while(strtotime($Fecha_final)>=strtotime($FechaCalculada)){
                        
                            $X = $this->compararFechas($FechaCalculada,$Fecha_final);
                            
                            if($X>=7){
                                            
                                $FechaCalculada = $this->dameFecha($FechaCalculada,7);
                                
                                $F_New[$i][]    = $FechaCalculada;
                            
                            }else{
                                
                                $FechaCalculada = $this->dameFecha($FechaCalculada,7);
                                 
                            }//if
                        
                    }//while
                    
                }//for
                /**********************************************************/
            }break;
         }//switch
        
          return $F_New;
         
    }//public function FechasFuturas
    public function FormatoFecha($fecha,$op){
        
        $FechaData = array();
            switch($op){
                case'1':{}break;
                case'2':{
                    $FechaDetalle = array();
                    
                    $C_fecha = explode('/',$fecha);
                    
                    $FechaNew = $C_fecha[2].'-'.$C_fecha[1].'-'.$C_fecha[0];
                    
                    /*$FechaData[] = $FechaNew;
                    
                    $FechaDetalle[] = $C_fecha[2];//año
                    $FechaDetalle[] = $C_fecha[1];//mes
                    $FechaDetalle[] = $C_fecha[0];//dia
                    
                    $FechaData[] = $FechaDetalle;*/
                }break;
                default:{
                    $FechaDetalle = array();
                    
                    $C_fecha = explode('-',$fecha);
                    
                    $FechaNew = $C_fecha[1].'/'.$C_fecha[2].'/'.$C_fecha[0];
                    
                    /*$FechaData[] = $FechaNew;
                    
                    $FechaDetalle[] = $C_fecha[0];//año
                    $FechaDetalle[] = $C_fecha[1];//mes
                    $FechaDetalle[] = $C_fecha[2];//dia
                    
                    $FechaData[] = $FechaDetalle;*/
                    
                }break;
            }
         
         return $FechaNew;   
            
    }//public function FormatoFecha
    public function dameFecha($fecha,$dia){   
        list($year,$mon,$day) = explode('-',$fecha);
        return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));        
    }//public function dameFecha
    public function compararFechas($primera, $segunda){
     
      $valoresPrimera = explode ("-", $primera);   
      $valoresSegunda = explode ("-", $segunda); 
    
      $diaPrimera    = $valoresPrimera[2];  
      $mesPrimera    = $valoresPrimera[1];  
      $anyoPrimera   = $valoresPrimera[0]; 
    
      $diaSegunda   = $valoresSegunda[2];  
      $mesSegunda   = $valoresSegunda[1];  
      $anyoSegunda  = $valoresSegunda[0];
    
      $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);  
      $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);     
    
      if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
        // "La fecha ".$primera." no es válida";
        return 0;
      }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
        // "La fecha ".$segunda." no es válida";
        return 0;
      }else{
        return   $diasSegundaJuliano - $diasPrimeraJuliano;
      } 
    
    }//public function compararFechas
    public function DiasSemana($Fecha,$Op=''){
        if($Op=='Nombre'){
            $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');    
        }else{
            $dias = array('','1','2','3','4','5','6','7');    
        }
        
        $fecha = $dias[date('N', strtotime($Fecha))]; 
        
        return $fecha;
    }// public function DiasSemana
    public function EditarEvento($id){ 
       
        include_once("../../templates/template.php");
		
        $db = getBD();
        //echo '<pre>';print_r($db);die;
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
         
        $Data = $this->BuscarEvento($db,$id);
        
        ?>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script src="../wdCalendar/src/Plugins/Common.js" type="text/javascript"></script>  
           
        <script type="text/javascript" language="javascript">
        
            function EditEventoSolicitud(){
                
                $.ajax({//Ajax
                  type: 'POST',
                  url: 'php/datafeed.php',
                  async: false,
                  dataType: 'json',
                  data:$('#EditarFormulario').serialize(),
                  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                  success: function(data){
                       if(data.IsSuccess==false){
                                alert(data.Msg)
                            }else{
                                alert(data.Msg);
                                window.parent.ParentWindowFunction();
                                CloseModelWindow(null,true);  
                            }
                	}//data 
                        
                });
            }//function EditEventoSolicitud
            function ElininarEventoSolicitud(){
               
                if(confirm('Desea Eliniar Solicitd')){
                
                    $('#method').val('remove');
                    
                    
                    $.ajax({//Ajax
                      type: 'POST',
                      url: 'php/datafeed.php',
                      async: false,
                      dataType: 'json',
                      data:$('#EditarFormulario').serialize(),
                      error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                      success: function(data){
                           if(data.IsSuccess==false){
                                    alert(data.Msg)
                                }else{
                                    alert(data.Msg);
                                    window.parent.ParentWindowFunction();
                                    CloseModelWindow(null,true);  
                                }
                    	}//data 
                            
                    });
                }
            }//function ElininarEventoSolicitud
        
        </script>
        <form  id="EditarFormulario" method="post">
            <input id="method" name="method" value="adddetails" type="hidden" />
            <input id="Temp_id" name="Temp_id" value="<?PHP echo $id?>" type="hidden" />
            <fieldset>
                <legend>Editar Evento</legend>
                <table>
                    <thead>
                        <tr>
                            <td>Sede o Campus</td>
                            <td><?PHP $this->SedesCampus($db,$Data[0]['sede']);?></td>
                        </tr>
                        <tr>
                            <td>Tipo Salon</td>
                            <td><?PHP $this->TipoSalon($db,$Data[0]['id_tiposalon']);?></td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <table>
                                    <tr>
                                        <?PHP $this->FechaBox('Fecha Inicio Evento','F_inicial','',$Data[0]['f_inicial'],'readonly="readonly"',1)?>
                                        <?PHP $this->FechaBox('Fecha Fin Evento','F_final','',$Data[0]['f_final'],'readonly="readonly"',1)?>
                                    </tr>
                                    <tr>
                                        <td>Hora Inicial</td>
                                        <td><input type="text" style="text-align: center;" id="H_inicial" name="H_inicial" value="<?PHP echo $Data[0]['h_inicial']?>" readonly="readonly" /></td>
                                        <td>Hora Final</td>
                                        <td><input type="text" style="text-align: center;" id="H_final" name="H_final" value="<?PHP echo $Data[0]['h_final']?>" readonly="readonly" /></td>
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
                            <td id="Td_Buton" colspan="2">
                                <input type="button" value="Guardar" onclick="EditEventoSolicitud()" id="SaveEvento" name="SaveEvento" />
                                <input type="button" value="Elininar" onclick="ElininarEventoSolicitud()" id="Elinina" name="Elinina" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </form>
        <?PHP
    }//public function EditarEvento
    public function BuscarEvento($db,$id){
        //global $db;
        
          $SQL='SELECT 

                id_tiposalon,
                DATE(fecha_ini) AS f_inicial,
                DATE(fecha_fin) AS f_final,
                TIME(fecha_ini) AS h_inicial,
                TIME(fecha_fin) AS h_final,
                sede
                
                FROM temp_solicitud 
                
                WHERE  id_temp="'.$id.'" AND codigoestado=100';
                
           if($Temp=&$db->Execute($SQL)===false){
                echo 'Error en el SQl de Temp...<br><br>'.$SQL;
                die;
           }    
           
           $Datos = $Temp->GetArray();
           
           return $Datos; 
        
    }//public function BuscarEvento
    public function TipoSalon($db,$id=''){
         
        
          $SQL='SELECT 

                t.codigotiposalon AS id,
                t.nombretiposalon


                
                FROM tiposalon t INNER JOIN EspaciosFisicos e ON t.EspaciosFisicosId=e.EspaciosFisicosId
                
                WHERE 
                t.codigoestado=100
                AND
                e.PermitirAsignacion=1';
                
         if($TipoSalon=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Tipo Salon....<br><br>'.$SQL;
            die;
         }      
         ?>
         <select id="TipoSalon" name="TipoSalon">
            <option value="-1"></option>
            <?PHP 
             while(!$TipoSalon->EOF){
                if($TipoSalon->fields['id']==$id){
                    $selected = 'selected="selected"';
                }else{
                    $selected = '';
                }
            ?>
                <option <?PHP echo $selected?>  value="<?PHP echo $TipoSalon->fields['id']?>"><?PHP echo $TipoSalon->fields['nombretiposalon']?></option>
            <?PHP
                $TipoSalon->MoveNext();
            } 
            ?>
         </select>
         <?PHP
        
    }//public function TipoSalon
    public function SedesCampus($db,$id=''){
        
          $SQL='SELECT 

                ClasificacionEspaciosId AS id,
                Nombre
                
                FROM ClasificacionEspacios 
                
                
                WHERE
                
                EspaciosFisicosId=3
                AND
                codigoestado=100';
                
         if($Sedes=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Sedes...<br><br>'.$SQL;
            die;
         }
         ?>
         <select id="Sedes" name="Sedes">
            <?PHP 
            while(!$Sedes->EOF){
                if($Sedes->fields['id']==$id){
                    $selected = 'selected="selected"';
                }else{
                   $selected = ''; 
                }
                ?>
                <option <?PHP echo $selected?> value="<?PHP echo $Sedes->fields['id']?>"><?PHP echo $Sedes->fields['Nombre']?></option>p
                <?PHP
                $Sedes->MoveNext();
            }
            ?>
         </select>
         <?PHP       
    }//public function SedesCampus
    public function NewEvento($FechaIni='',$FechaFin='',$sede='',$BuscarSalones=''){
        include_once("../../templates/template.php");
		
        $db = getBD();
        //echo '<pre>';print_r($db);die;
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
         $rutaCss = '../../../mgi/';
         ?>
   
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../../css/jquery.clockpick.1.2.9.css" type="text/css" /> 
        
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../../js/jquery.clockpick.1.2.9.js"></script>
        <script type="text/javascript" language="javascript" src="../../js/jquery.clockpick.1.2.9.min.js"></script>
     
        <script src="../wdCalendar/src/Plugins/Common.js" type="text/javascript"></script>  
        
        <script type="text/javascript" language="javascript">
        
            function SaveEventoNew(){
                
                $.ajax({//Ajax
                  type: 'POST',
                  url: 'php/datafeed.php',
                  async: false,
                  dataType: 'json',
                  data:$('#NewEventoAdd').serialize(),
                  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                  success: function(data){
                       if(data.IsSuccess==false){
                                alert(data.Msg)
                            }else{
                                alert(data.Msg);
                                window.parent.ParentWindowFunction();
                                CloseModelWindow(null,true);  
                            }
                	}//data 
                        
                });
            }//function SaveEventoNew
            
           
        </script>
        <br />
        
        <form  id="NewEventoAdd" method="post">
            <input id="method" name="method" value="add" type="hidden" />
            <input id="FechaIni" name="FechaIni" value="<?PHP echo $FechaIni?>" type="hidden" />
            <input id="FechaFin" name="FechaFin" value="<?PHP echo $FechaFin?>" type="hidden" />
            <input id="Userid" name="Userid" value="<?PHP echo $userid?>" type="hidden" />
            <input id="actionID" name="actionID" value="BuscarDisponibilidad" type="hidden" />
            <fieldset>
                <legend>Nuevo Evento</legend>
                <br />
                <br />
                <table>
                    <thead>
                        <tr>
                            <td>Sede o Campus</td>
                            <td><?PHP $this->SedesCampus($db,$sede);?></td>
                        </tr>
                        <tr>
                            <td>Tipo Salon</td>
                            <td><?PHP $this->TipoSalon($db);?></td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <table>
                                    <tr>
                                        <?PHP $this->FechaBox('Fecha Inicio Evento','F_inicial','','','readonly="readonly"','','../')?>
                                        <?PHP $this->FechaBox('Fecha Fin Evento','F_final','','','readonly="readonly"','','../')?>
                                    </tr>
                                    <tr>
                                        <td>Hora Inicial</td>
                                        <td><input type="text" style="text-align: center;" id="H_inicial" name="H_inicial" readonly="readonly"  /></td>
                                        <td>Hora Final</td>
                                        <td><input type="text" style="text-align: center;" id="H_final" name="H_final" readonly="readonly"  /></td>
                                        <script>
                                         $("#H_inicial").clockpick({
                                                starthour : 6,
                                                endhour : 23,
                                                showminutes : true
                                            
                                            });
                                            $("#H_final").clockpick({
                                                starthour : 6,
                                                endhour : 23,
                                                showminutes : true
                                            });
                                        </script>   
                                    </tr>
                                    <?PHP 
                                    if($BuscarSalones==1){
                                        ?>
                                        <tr>
                                            <td>Acceso A Discapacitados</td>
                                            <td>
                                                <input type="checkbox" id="AccesoDisca" name="AccesoDisca" />
                                            </td>
                                        </tr>
                                        <?PHP
                                    }
                                    ?>
                                    
                                </table>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <?PHP 
                        if($BuscarSalones==1){
                            ?>
                            <tr>
                                <td colspan="2">
                                    <fieldset>
                                    <legend>Buscar Espacios</legend>
                                        <div style="text-align: center;">
                                            <div style="text-align: right;" >
                                                <img src="../../imagenes/Perspective Button - Search.png" title="Buscar Disponibilidad" width="30" height="30" onclick="BuscarDisponibilidad()" />
                                            </div>
                                            <div id="DivDisponibilidad"></div>
                                        </div>
                                    </fieldset>
                                </td>
                            </tr>
                            <?PHP
                        }
                        ?>
                        <tr>
                            <td colspan="2">
                                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
                            </td>
                            <td id="Td_Buton" colspan="2">
                                <input type="button" value="Guardar" onclick="SaveEventoNew()" id="SaveEvento" name="SaveEvento" />
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </form>
        <?PHP
    }//public function NewEvento
    
}//class
?>