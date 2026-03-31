<?php 
//var_dump(is_file('../../../templates/template.php'));die;
session_start();
 
include_once("../../../templates/template.php");
		
        $db = getBD();
        
        
       
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];

switch($_REQUEST['actionID']){
    case 'Color':{
        //echo '<pre>';print_r($_POST);
        
        $id = $_POST['c'];
        
        $SQL_Color='SELECT 
                    IdCarreraColor AS id,
                    Color
                    FROM CarreraColor  WHERE CodigoCarrera="'.$id.'"';
                    
             if($Color=&$db->Execute($SQL_Color)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Buscar Color';
                echo json_encode($a_vectt);
                exit;
             }       
            
            if(!$Color->EOF){
                $C = $Color->fields['Color'];
            }else{
                $C = '803C3C';
            }
                    
            $a_vectt['val']			=true;
            $a_vectt['Color']		=$C;
            echo json_encode($a_vectt);
            exit;         
    }exit;
    case 'AutoGrupo':{
        //$Letra      = $_REQUEST['term'];
        $Programa  = $_REQUEST['Programa'];
        $Materia    = $_REQUEST['Materia'];
        
        $Consulta = Grupo($db,$Programa,$Materia);
        
        $op       = $_REQUEST['OP'];
        
        if($op=='Multiple'){
            ?>
            <fieldset style="height:120px;border:1px solid #ccc;overflow:auto;">
                <legend>Multiple Grupos</legend>
                <table>
                <?PHP 
                while(!$Consulta->EOF){
                    ?>
                    <tr>
                    <td ><?PHP echo $Consulta->fields['id'].' :: '.$Consulta->fields['Nombre'].'  Periodo '.$Consulta->fields['codigoperiodo']?><td>
                    <td>
                        <div id="Div_Horario_<?PHP echo $Consulta->fields['id']?>" title="Horario"></div>
                        <input type="checkbox" value="<?PHP echo $Consulta->fields['id']?>" id="GrupoText_<?PHP echo $Consulta->fields['id']?>" name="GrupoText[]" class="Gropup" onclick="AddNumGrupo('<?PHP echo $Consulta->fields['id']?>','<?PHP echo $Consulta->fields['Cupo']?>','Div_Horario_');" style="cursor: pointer;" />
                    </td>
                    </tr>
                    <?PHP
                    $Consulta->MoveNext();
                }
                ?>
               </table>
            </fieldset>
            <?PHP
        }else{
        
        ?>
        <input type="hidden" id="Grupo" name="Grupo[]" />
        <select id="GrupoText" name="GrupoText" onchange="NumGroup()">
            <option value="-1"></option>
            <?PHP 
            while(!$Consulta->EOF){
                ?>
                <option value="<?PHP echo $Consulta->fields['id'].'::'.$Consulta->fields['Cupo']?>"><?PHP echo $Consulta->fields['id'].' :: '.$Consulta->fields['Nombre']?></option>
                <?PHP
                $Consulta->MoveNext();
            }
            ?>
        </select>
        <?PHP
        }
    }exit;
    case 'AutoMateria':{
        $Letra      = $_REQUEST['term'];
        $Programa  = $_REQUEST['Programa'];
        
        $Consulta = Materia($db,$Programa,$Letra);
        
        $DataMateria = array();
        
        if(!$Consulta->EOF){
            while(!$Consulta->EOF){
                
                    $Ini_Vectt['label']=$Consulta->fields['id'].' :: '.$Consulta->fields['Nombre'];
                    $Ini_Vectt['value']=$Consulta->fields['id'].' :: '.$Consulta->fields['Nombre'];
                    $Ini_Vectt['id']   =$Consulta->fields['id'];
                    
                    array_push($DataMateria, $Ini_Vectt);
                
                $Consulta->MoveNext();
            }//while
        }else{
            $Ini_Vectt['label']='No Hay Informacion';
            $Ini_Vectt['value']='No Hay Informacion';
            $Ini_Vectt['id']   ='-1';
            
            array_push($DataMateria, $Ini_Vectt);
        } 
        
        
       echo json_encode($DataMateria);
    }exit;
    case 'AutoPrograma':{
        $Letra      = $_REQUEST['term'];
        $Modalidad  = $_REQUEST['Modalidad'];
         
        
        $Consulta = Programa($db,$Modalidad,'',$Letra);
        
        
        $DataPrograma = array();
        
        if(!$Consulta->EOF){
            while(!$Consulta->EOF){
                
                    $Ini_Vectt['label']=$Consulta->fields['id'].' :: '.$Consulta->fields['Nombre'];
                    $Ini_Vectt['value']=$Consulta->fields['id'].' :: '.$Consulta->fields['Nombre'];
                    $Ini_Vectt['id']   =$Consulta->fields['id'];
                    
                    array_push($DataPrograma, $Ini_Vectt);
                
                $Consulta->MoveNext();
            }//while
        }else{
            $Ini_Vectt['label']='No Hay Informacion';
            $Ini_Vectt['value']='No Hay Informacion';
            $Ini_Vectt['id']   ='-1';
            
            array_push($DataPrograma, $Ini_Vectt);
        } 
        
        
       echo json_encode($DataPrograma);
       	
    }exit;
    case 'NuevoEventoSolicitud':{
        
        /*
            [Grupo] => 71212
            [Campus] => 4
            [TipoSalon] => 01
            [FechaUnica] => 
            [HoraInicial_unica] => 
            [HoraFin_unica] => 
            [FechaIni] => 2014-07-14
            [FechaFin] => 2014-07-25
            [numIndices] => 1
            [DiaSemana] => Array
                (
                    [0] => 1
                )
        
           [AulaSelecionada] => on
            [indicador] => 4
            [Observacion] => 
        */
        include_once('../../../Solicitud/AsignacionSalon.php');
        include_once('../../../Solicitud/festivos.php');
        
        
        $C_Festivo  = new festivos();
        
        $C_AsignacionSalon = new AsignacionSalon();
        
        $FechaUnica = $_POST['FechaUnica'];
        $Max          = $_POST['NumEstudiantes'];
        $Acceso       = $_POST['Acceso'];
        if($Acceso=='on'){
            $Acceso = 1;
        }else{
            $Acceso = 0;
        }
        $Sede        = $_POST['Campus'];
        $TipoSalon   = $_POST['TipoSalon'];
        $Grupo_id       = $_POST['Grupo'];
        
        if($FechaUnica){
            $HoraInicial_unica  = $_POST['HoraInicial_unica'];
            $HoraFin_unica      = $_POST['HoraFin_unica']; 
            
            $CodigoDia[] = $C_AsignacionSalon->DiasSemana($FechaUnica,'Codigo');
            
            $Hora        = $C_AsignacionSalon->Horas($HoraInicial_unica,$HoraFin_unica);
            
            $Info[0][0]=$FechaUnica.' '.$Hora['Horaini'];
            $Info[0][1]=$FechaUnica.' '.$Hora['Horafin'];
        }else{
            $Data = $_POST;
        
            $Info = $C_AsignacionSalon->DisponibilidadMultiple($db,$Data,'arreglo');
            $FechaIni    = $_POST['FechaIni'];
            $FechaFin    = $_POST['FechaFin'];
            $CodigoDia   = $_POST['DiaSemana'];
            $numIndices  = $_POST['numIndices'];
            
            
        }
        
        $EspacioCheck  = $_POST['EspacioCheck'];
        
        for($i=0;$i<count($EspacioCheck);$i++){
            /***************************************************/
            if($EspacioCheck[$i]){
                $Espacios[] = $EspacioCheck[$i];    
            }
            /***************************************************/
        }//for
        
        $Limit  = Count($CodigoDia)-1;
        
        for($i=0;$i<=$Limit;$i++){
            /****************************************************/
            
            if($FechaUnica){
                $Fecha_inicial = $FechaUnica;
                $Fecha_final   = $FechaUnica;
                
            }else{
                $Fecha_inicial = $FechaIni;
                $Fecha_final   = $FechaFin;
                
            }
            
            
            
            $SQL_Insert='INSERT INTO SolicitudAsignacionEspacios(codigotiposalon,AccesoDiscapacitados,FechaInicio,FechaFinal,idsiq_periodicidad,ClasificacionEspaciosId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion,codigodia)VALUES("'.$TipoSalon.'","'.$Acceso.'","'.$Fecha_inicial.'","'.$Fecha_final.'","35","'.$Sede.'","'.$userid.'","'.$userid.'",NOW(),NOW(),"'.$CodigoDia[$i].'")';
            
            if($InsertSolicituNew=&$db->Execute($SQL_Insert)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Insertar Solicitud..';
                echo json_encode($a_vectt);
                exit;
            }
            
            ##########################
            $Last_id=$db->Insert_ID();
            ##########################
            
           $InserGrupo='INSERT INTO SolicitudEspacioGrupos(SolicitudAsignacionEspacioId,idgrupo)VALUES("'.$Last_id.'","'.$Grupo_id.'")';  
             
             if($GrupoSolicitud=&$db->Execute($InserGrupo)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Insertar Solicitud Grupo..';
                echo json_encode($a_vectt);
                exit;
             }
            /****************************************************/
            
            for($x=0;$x<count($Info);$x++){
                /******************************************************/
                 $FechaFutura_1 = $Info[$x][0];
                 $FechaFutura_2 = $Info[$x][1];
                 
                 $C_FechaData_1  = explode(' ',$FechaFutura_1);
                 $C_FechaData_2  = explode(' ',$FechaFutura_2);
                 
                 $C_DatosDia  = explode('-',$C_FechaData_1[0]);
                    
                 $dia  = $C_DatosDia[2];
                 $mes  = $C_DatosDia[1];
                    
                 $Festivo = $C_Festivo->esFestivo($dia,$mes);
                 $DomingoTrue = $C_AsignacionSalon->DiasSemana($Fecha);
                 if($Festivo==false){//$Festivo No es Festivo
                    if(($DomingoTrue!=7)  ||  ($DomingoTrue!='7')){
                        $Fecha  = $C_FechaData_1[0];
                        $Hora_1 = $C_FechaData_1[1];
                        $Hora_2 = $C_FechaData_2[1]; 

                        $Asignacion='INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin)VALUES("'.$Fecha.'","'.$Last_id.'","'.$userid.'","'.$userid.'",NOW(),NOW(),"'.$Espacios[$x].'","'.$Hora_1.'","'.$Hora_2.'")';

                           if($InsertAsignar=&$db->Execute($Asignacion)===false){
                                $a_vectt['val']			=false;
                                $a_vectt['descrip']		='Error al Insertar Asignacion del Espacio..';
                                echo json_encode($a_vectt);
                                exit;
                            }
                    }//Diferente de Domingo 
                 }//if
                /******************************************************/
            }//for
            /****************************************************/
        }//for
        
          
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Creado la Solicitud y Asignacion Correctamente...';
        $a_vectt['Data'] =rand();
        echo json_encode($a_vectt);
        
        exit;
        
        //echo '<pre>';print_r($Info);
        /*
        Array(
            [0] => Array
                (
                    [0] => 2014-07-14 9:00
                    [1] => 2014-07-14 11:00
                )
        
            [1] => Array
                (
                    [0] => 2014-07-14 14:00
                    [1] => 2014-07-14 16:00
                )
        
            [2] => Array
                (
                    [0] => 2014-07-21 9:00
                    [1] => 2014-07-21 11:00
                )
        
            [3] => Array
                (
                    [0] => 2014-07-21 14:00
                    [1] => 2014-07-21 16:00
                )

            )
        */
        
        //echo '<pre>';print_r($Espacios);
         /*
         Array
            (
                [0] => 38
                [1] => 29
                [2] => 76
                [3] => 34
            )
         */
         
         
    }exit;
    case 'DisponibilidadMultiple':{
        /*
            [NumEstudiantes] => 41
            [Acceso] => on
            [Campus] => 4
            [TipoSalon] => 01
            [FechaIni] => 2014-07-14
            [FechaFin] => 2014-07-25
            [DiaSemana] => Array
            (
                [0] => 1
                [1] => 3
                [2] => 5
            )
            
            [HoraInicial_0] => Array
            (
                [0] => 9:00 AM
                [1] => 
                [2] => 7:00 AM
                [3] => 
                [4] => 2:00 PM
                [5] => 
                [6] => 
            )
            
            [HoraFin_0] => Array
            (
                [0] => 11:00 AM
                [1] => 
                [2] => 9:00 AM
                [3] => 
                [4] => 5:00 PM
                [5] => 
                [6] => 
            )
            
            [HoraInicial_1] => Array
            (
                [0] => 
                [1] => 
                [2] => 2:00 PM
                [3] => 
                [4] => 
                [5] => 
                [6] => 
            )
            
            [HoraFin_1] => Array
            (
                [0] => 
                [1] => 
                [2] => 5:00 PM
                [3] => 
                [4] => 
                [5] => 
                [6] => 
            )
            
            [Observacion] => 
         */
         
        include_once('../../../Solicitud/AsignacionSalon.php');
        
        $C_AsignacionSalon = new AsignacionSalon();
        
        $Data = $_POST;
        
        $C_AsignacionSalon->DisponibilidadMultiple($db,$Data,'pintar');
        
    }exit;
    case 'BuscarDisponibilidad':{
         
        /*
            [Userid] => 4186
            [actionID] => BuscarDisponibilidad
            [Campus] => 4
            [TipoSalon] => 01
            [FechaUnica] => 2014-07-14
            [HoraInicial_unica] => 11:00 AM
            [HoraFin_unica] => 1:00 PM
            [Acceso] => on
            [NumEstudiantes] => 41
            [TipoSalon]  => 01
        */
        
        include_once('../../../Solicitud/AsignacionSalon.php');
        
        $C_AsignacionSalon = new AsignacionSalon();
        
        $Sede       = $_POST['Campus'];
        $TipoSalon  = $_POST['TipoSalon'];
        $F_inicial  = $_POST['FechaUnica'];
        $F_final    = $_POST['FechaUnica'];
        $H_inicial  = $_POST['HoraInicial_unica'];
        $H_final    = $_POST['HoraFin_unica'];
        $Acceso     = $_POST['Acceso'];
        $Max        = $_POST['NumEstudiantes'];
        $TipoSalon  = $_POST['TipoSalon'];
        
        if($Acceso=='on'){
            $Acceso = 1;
        }else{
            $Acceso = 0;
        }
        
        $C_AsignacionSalon->Disponibilidad($db,$Sede,$TipoSalon,$F_inicial,$F_final,$H_inicial,$H_final,$Acceso,$Max);
        
    }exit;
    case 'Programa':{
        Programa($db,$_POST['Modalidad']);
    }exit;
    case 'Grupo':{
       Grupo($db,$_POST['Programa'],$_POST['Materia']);
    }exit;
    case 'Materia':{
       Materia($db,$_POST['Programa']);
    }exit;
    case 'Cupo':{
         
        $SQL='SELECT
                
                g.idgrupo,
                g.maximogrupo AS Cupo
                
              FROM
                
                grupo g
                
              WHERE
                
                g.idgrupo="'.$_POST['Grupo'].'"';
                
            if($Cupo=&$db->Execute($SQL)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error en El SQL ... <br><br>'.$SQL;
                echo json_encode($a_vectt);
                exit;  
            }   
            
            if(!$Cupo->EOF){
                $a_vectt['val']			=true;
                $a_vectt['Cupo']		=$Cupo->fields['Cupo'];
                echo json_encode($a_vectt);
                exit; 
            }else{
                $a_vectt['val']			=true;
                $a_vectt['Cupo']		='';
                echo json_encode($a_vectt);
                exit;
            } 
    }exit;
    
}

?>
<!DOCTYPE HTML  "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="../../../css/jquery.clockpick.1.2.9.css" type="text/css" /> 
        <link rel="stylesheet" href="../../../css/Styleventana.css" type="text/css" />
        
        <link rel="stylesheet" href="../../../../mgi/../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        
        <script type="text/javascript" language="javascript" src="EventoSolicitud.js"></script>
        
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        
        <script src="./src/Plugins/Common.js" type="text/javascript"></script>
        
        <script type="text/javascript" language="javascript" src="../../../js/jquery.clockpick.1.2.9.js"></script>
        <script type="text/javascript" language="javascript" src="../../../js/jquery.clockpick.1.2.9.min.js"></script>
        <script type="text/javascript" language="javascript" src="../../../js/jquery.bpopup.min.js"></script>
        
        <script src="../../../wdCalendar/wdCalendar/src/Plugins/Common.js" type="text/javascript"></script>  
        <script>
        function SaveEventoNew(){
            /**************************************************************/
            $('#actionID').val('NuevoEventoSolicitud');
           
            $.ajax({//Ajax
              type: 'POST',
              url: 'php/datafeed.php',
              async: false,
              dataType: 'json',
              data:$('#SolicitudEspacio').serialize(),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                   if(data.val===false){
                        alert(data.descrip);
                        return false;
                   }else{
                        alert(data.descrip);
                        window.parent.ParentWindowFunction();
                        CloseModelWindow(null,true);  
                   }
                  }  
            });
           /**************************************************************/
        }//function SaveEventoNew
        </script>
 </head>
    <body>
        <div id="pageContainer">
        <fieldset style="width:90%;" aling="center">
        	<legend>Solicitud de Espacios F&iacute;sicos</legend>
                <form id="SolicitudEspacio">
                    <input id="method" name="method" value="addNew" type="hidden" />
                    <input id="actionID" name="actionID" type="hidden" value="Save" />
                    <table  border="0" style="width: 100%; " cellpadding="0" cellspacing="0"  >
                        <thead>
                           <?PHP 
                            if($_SESSION['codigofacultad']==1){
                                ?>
                                <tr>
                                    <td style="text-align: left; width: 20%;">Modalidad Acad&eacute;mica</td>
                                    <td><?PHP  Modalidad($db);?></th>
                                    <td colspan="2">&nbsp;</th>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Programa Acad&eacute;mico</td>
                                    <td id="Th_Progra" style=" width: 20%;">
                                       <?PHP 
                                       AutocompletarBox('ProgramaText','Programa','AutocomplePrograma');
                                       ?>
                                    </td>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <?PHP
                            }else{
                                ?>
                                <tr>
                                    <td style="text-align: left;">Programa Acad&eacute;mico</td>
                                    <td>
                                    <?PHP 
                                        AutoPrograma('ProgramaText','Programa',$db,$_SESSION['codigofacultad']);
                                        //Programa($db,'',$_SESSION['codigofacultad']);
                                    ?>
                                    </td>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <?PHP
                            }
                           ?>
                                <tr>
                                    <td style="text-align: left;">Materia</td>
                                    <td id="Th_Materia"><?PHP AutocompletarBox('MateriaText','Materia','BuscarMateria');?></td>
                                    <td style="text-align: left; width: 20%;">Grupo</td>
                                    <td id="Th_Grupo" style="width: 20%;"><?PHP AutocompletarBox('GrupoText','Grupo','BuscarGrupo');?></td>
                               </tr>
                               <tr>
                                    <td style="text-align: left;">Numero De Estudiantes</td>
                                    <td>
                                        <input type="text" readonly="readonly" id="NumEstudiantes" name="NumEstudiantes" style="text-align: center;" placeholder="Digite Numero de Estudiantes" size="45" />
                                    </td>
                                    <td style="text-align: left;">Acceso a Discapacitados</td>
                                    <td>
                                        <input type="checkbox" id="Acceso" name="Acceso" />
                                    </td>
                               </tr>
                               <tr>
                                    <td style="text-align: left;">Campus</td>
                                    <td id="Th_Campus"><?PHP EspacioCategoria($db,'Campus',3,'');?></td> 
                                    <td colspan="2">&nbsp;</td>
                               </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">
                                    <fieldset style="width: auto;">
                                        <legend>Periodicidad</legend>
                                        <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 100%;">
                                            <tr>
                                                <td>Tipo Aula</td>
                                                <td><?PHP TipoSalon($db);?></td>
                                                <td colspan="2">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                <?PHP Tabs($db);?>
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
                                    <input type="button" id="SaveSolicitud" name="SaveSolicitud" value="Guardar" onclick="SaveEventoNew();" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
        </fieldset>
        </div>
    </body>
</html>
 <?PHP
 function Modalidad($db){
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
        <select id="Modalidad" name="Modalidad" style="width: auto;">
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
          
 }//function Modalidad
function Programa($db,$Modalidad='',$Programa_id='',$Letra=''){
        
        if($Modalidad){
            $Condicion = 'AND codigomodalidadacademica="'.$Modalidad.'"';
        }else{
            $Condicion = 'AND codigocarrera="'.$Programa_id.'"';
        }
        
        if($Letra){
            
            $Condicion_2 = ' AND  (codigocarrera LIKE "'.$Letra.'%" OR nombrecarrera LIKE "'.$Letra.'%")';
        }else{
            $Condicion_2 = ' ';
        }
        
          $SQL='SELECT 

                codigocarrera AS id,
                nombrecarrera AS Nombre
                
                FROM carrera
                
                WHERE
                (carrera.fechavencimientocarrera >= NOW() OR carrera.EsAdministrativa = 1)
                AND carrera.codigomodalidadacademica <> 400
                '.$Condicion.'
                '.$Condicion_2.'
                
                ORDER BY  nombrecarrera ASC';
                
          if($Programa=&$db->Execute($SQL)===false){
                echo 'Error En el SQL .....<br><br>'.$SQL;
                die;
          }   
        
         if($Modalidad){
           return $Programa; 
         }else{
           $Cadena[] = $Programa->fields['id'];
           $Cadena[] = $Programa->fields['Nombre'];
            
           return $Cadena; 
         }
        
        
             
    }//function Programa
     function Materia($db,$Programa_id,$Letra){
        
        
        $SQL='SELECT 
          
                        m.nombremateria AS Nombre,
                        m.codigomateria AS id
                
                FROM 
                        grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria
        						INNER JOIN carrera c ON c.codigocarrera=m.codigocarrera
        						INNER JOIN periodo p ON p.codigoperiodo=g.codigoperiodo
        
                WHERE
                
                        
                        m.codigoestadomateria="01"
                        AND
                        c.codigocarrera="'.$Programa_id.'"
                        AND
                        (m.nombremateria LIKE "'.$Letra.'%" OR  m.codigomateria LIKE "'.$Letra.'%")
                
                GROUP BY m.codigomateria
                
                ORDER BY m.nombremateria ASC';
                
           if($Materia=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de las Materias..<br><br>'.$SQL;
                die;
           } 
           
           return  $Materia;
               
    }// function Materia
     function Grupo($db,$Programa_id,$Materia_id){
         
            $Year = date('Y');
            
            if((date('m')>=01 || date('m')>='01') && (date('m')<=06 || date('m')<='06')){
                $Periodo   = 1;
                $Periodo_2 = 2;
            }else{
                $Periodo   = 2;
                $Periodo_2 = 1;
            }
            
            if($Periodo==2){
                $Year_2  = $Year+1;
            }else{
                $Year_2  = $Year;
            }
         
         $C_Periodo_1 = $Year.$Periodo;
         $C_Periodo_2 = $Year_2.$Periodo_2;
         
        $SQL='SELECT 

                        g.idgrupo AS id,
                        g.codigogrupo,
                        g.nombregrupo AS Nombre,
                        m.nombremateria,
                        g.codigoperiodo,
                        m.codigomateria,
                        g.maximogrupo AS Cupo
                
                FROM grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria
    						 INNER JOIN carrera c ON c.codigocarrera=m.codigocarrera
    						 INNER JOIN periodo p ON p.codigoperiodo=g.codigoperiodo
                
                WHERE
                
                    p.codigoperiodo IN ("'.$C_Periodo_1.'","'.$C_Periodo_2.'")
                    AND
                    c.codigocarrera="'.$Programa_id.'"
                    AND
                    g.codigomateria="'.$Materia_id.'"
                    AND
                    g.codigoestadogrupo=10';
                    
         if($Grupo=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de los Grupos...<br><br>'.$SQL;
            die;
         }          
         
         return $Grupo; 
    }// function Grupo
      function EspacioCategoria($db,$name,$filtro,$funcion='',$op='',$id=''){
        
        
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
    }// function EspacioCategoria
     function Periocidad($db){
       
        $SQL='SELECT idsiq_periodicidad AS id, periodicidad AS Nombre, valor, tipo_valor 
              FROM siq_periodicidad 
              WHERE  idsiq_periodicidad IN(3,35,36)
              ORDER BY tipo_valor';
              
              
        if($Frecuencia=&$db->Execute($SQL)===false){
            echo 'Error en el SQl ...<br><br>'.$SQL;
            die;
        }    
        
       ?>
       <fieldset id="Frecu_Cont" style="width: auto;">
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
    }// function Periocidad
     function Horario($db){
        //var_dump(is_file('../../../Administradores/Admin_Categorias_class.php'));die;
        include_once('../../../Administradores/Admin_Categorias_class.php');  $C_Admin_Categorias = new Admin_Categorias();
        
        $SQL='SELECT codigodia, nombredia FROM dia';
        
        if($Dia=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Dia...<br><br>'.$SQL;
            die;
        }
      
        ?>
       <fieldset style="width: auto;">
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
                                <input style=" float: right;" type="checkbox" class="DiaChekck"  id="Dia_<?PHP echo $Dia->fields['codigodia']?>" name="DiaSemana[]" value="<?PHP echo $Dia->fields['codigodia']?>" />
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
                        <input type="text" size="10" class="Hora_1" id="HoraInicial_<?PHP echo $x?>" name="HoraInicial_0[]" readonly="readonly" style="text-align: center;" placeholder="Hora Inicial" />
                        <br />
                        <label style="font-size: 14px;">Hora Final</label>
                        <input type="text" size="10" class="Hora_2" id="HoraFin_<?PHP echo $x?>" name="HoraFin_0[]" readonly="readonly" style="text-align: center;" placeholder="Hora Final" />
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
    }// function Horario
     function FechaBox($db,$Label,$name,$Ejemplo='',$value='',$readonly='',$Ver='',$url=''){
        
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
        			dateFormat: "yy-mm-dd",
                    minDate: new Date()
        		});
                $('#ui-datepicker-div').css('display','none');
              }); 
            </script>
            <?PHP
        }
        ?>
        
        <?PHP
    }// function FechaBox
     function AddTrNewwww($NumFiles){
         
       $i = 7; 
       
       for($x=1;$x<=$i;$x++){
        ?>
        
             <td style="border: black 1px solid;">
                <label style="font-size: 14px;">Hora Inicial</label>
                <input type="text" size="10" class="Hora_1" id="HoraInicial_<?PHP echo $x?>_<?PHP echo $NumFiles?>" name="HoraInicial_<?PHP echo $NumFiles?>[]" readonly="readonly" style="text-align: center;" placeholder="Hora Inicial" />
                <br />
                <label style="font-size: 14px;">Hora Final</label>
                <input type="text" size="10" class="Hora_2" id="HoraFin_<?PHP echo $x?>_<?PHP echo $NumFiles?>" name="HoraFin_<?PHP echo $NumFiles?>[]" readonly="readonly" style="text-align: center;" placeholder="Hora Final" />
            </td>
            
                
           
        <?PHP
       }
               
    }// function AddTrNew
    function Tabs($db){
        ?>
        <script>
        $(function() {
            $( "#tabs" ).tabs();
        });
        </script>
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Unico Evento</a>&nbsp;&nbsp;<input type="checkbox" id="AvilitarUnico" onclick="AvilitarFormulario(1)" /></li>
                <li><a href="#tabs-2">Multiple Evento</a>&nbsp;&nbsp;<input type="checkbox" id="AvilitarMultiple" onclick="AvilitarFormulario(2)" /></li>
            </ul>
            <div id="tabs-1">
                <table cellpadding="0" cellspacing="0" >
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <?PHP FechaBox($db,'Fecha ','FechaUnica','Fecha','','readonly="readonly"','','../../');?>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <label style="font-size: 14px;">Hora Inicial</label>
                            <input type="text" size="10" id="HoraInicial_unica" name="HoraInicial_unica" readonly="readonly" style="text-align: center;" placeholder="Hora Inicial" />
                        </td>
                        <td>
                            <label style="font-size: 14px;">Hora Final</label>
                            <input type="text" size="10" id="HoraFin_unica" name="HoraFin_unica" readonly="readonly" style="text-align: center;" placeholder="Hora Final" />
                        </td>
                        <script>
                            $("#HoraInicial_unica").clockpick({
                            starthour : 6,
                            endhour : 23,
                            showminutes : true
                            });
                            $("#HoraFin_unica").clockpick({
                            starthour : 6,
                            endhour : 23,
                            showminutes : true
                            });
                            </script>
                    </tr>
                </table>
                <br />
                <fieldset>
                <legend>Buscar Espacios</legend>
                    <div style="text-align: center;">
                        <div style="text-align: right;" >
                            <img src="../../../imagenes/Perspective Button - Search.png" style="display: none;" id="BuscarUnico" title="Buscar Disponibilidad" width="30" height="30" onclick="BuscarDisponibilidad()" />
                        </div>
                        <div id="DivDisponibilidad"></div>
                    </div>
                </fieldset>
            </div>
            <div id="tabs-2">
               <?PHP Multiple($db);?>
            </div>
        </div>
        <?PHP
    }//function Tabs
    function Multiple($db){
        ?>
        <table border=0 cellpadding="0" cellspacing="0" >
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <?PHP FechaBox($db,'Fecha Inicial','FechaIni','Fecha Inicial','','readonly="readonly"','','../../');?>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <?PHP FechaBox($db,'Fecha Final','FechaFin','Fecha Final','','readonly="readonly"','','../../');?>
            </tr>
        </table>
        <?PHP Horario($db)?>
        <br />
        <fieldset>
        <legend>Buscar Espacios</legend>
            <div style="text-align: center;" id="DivContenedor">
                <div style="text-align: right;" >
                    <img src="../../../imagenes/Perspective Button - Search.png" style="display: none;" id="BuscarMultiple" title="Buscar Disponibilidad" width="30" height="30" onclick="BuscarDisponibilidadMultiple()" />
                </div>
                <div id="DivDisponibilidadMultiple"></div>
            </div>
        </fieldset>
        <?PHP
        
    }//Multiple
    function TipoSalon($db,$id=''){
         
        
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
        
    }//function TipoSalon
    function AutocompletarBox($name,$name_id,$funcion,$Disable){
        if($Disable){
            $Ver  = 'disabled="disabled"';    
        }else{
            $Ver = '';
        }
        
        
        ?>
        <input type="text"  <?PHP echo $Ver?>   id="<?PHP echo $name?>" name="<?PHP echo $name?>" autocomplete="off"  style="text-align:center;width:90%;" size="70" onClick="formReset('<?PHP echo $name?>','<?PHP echo $name_id?>');" onKeyPress="<?PHP echo $funcion?>()"  /><input type="hidden" id="<?PHP echo $name_id?>" name="<?PHP echo $name_id?>"/>
        <?PHP
    }//function AutocompletarBox
    function AutoPrograma($name,$name_id,$db,$Codigo){
        
        $Data = Programa($db,'',$Codigo,'');
        
       ?>
        <input type="text" readonly="readonly" id="<?PHP echo $name?>" name="<?PHP echo $name?>" autocomplete="off"  style="text-align:center;width:90%;" size="70" value="<?PHP echo $Data[0].' :: '.$Data[1]?>" /><input type="hidden" id="<?PHP echo $name_id?>" name="<?PHP echo $name_id?>" value="<?PHP echo $Data[0]?>"/>
        <?PHP
    }//function AutocompletarBox
    
 ?>       