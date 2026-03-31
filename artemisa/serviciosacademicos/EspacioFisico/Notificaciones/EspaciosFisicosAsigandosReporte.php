<?php 
//session_start();
$_SESSION['MM_Username'] = 'Manejo Sistema';
	
   switch($_POST['actionID']){
        case 'horario':{
            
            // var_dump(is_file(dirname(__FILE__)."../../../EspacioFisico/templates/template.php"));
             require_once(dirname(__FILE__)."../../../EspacioFisico/templates/template.php");
            // echo 'paso..';
             $db= getBD();
             
             $fecha_Now = date('Y-m-d');
    
             $dia = DiasSemana($fecha_Now);
            
           
                $Falta  =  1-$dia;
                //$X = '-4';
                $FechaFutura_1 = dameFecha($fecha_Now,$Falta);
                $FechaFutura_2 = dameFecha($FechaFutura_1,6);
             
             $datos = Consulta($db,'','1033715602','','',$FechaFutura_1,$FechaFutura_2);
             Resultado($datos);
        }break;
        case 'Buscar':{
            define(AJAX,true);
            $db= General();
            JsGeneral();
            $Num_Docente     = $_POST['Num_Docente']; 
            $Num_Estudiante  = $_POST['Num_Estudiante'];
            $Name_Grupo      = $_POST['Name_Grupo'];
            $Name_Materia    = $_POST['Name_Materia'];
            $Fecha_Actual    = $_POST['Fecha_ini'];
            $Fecha_Fin       = $_POST['Fecha_Fin'];
          
            $Datos = Consulta($db,$Num_Docente,$Num_Estudiante,$Name_Grupo,$Name_Materia,$Fecha_Actual,$Fecha_Fin);
            Resultado($Datos);
        }exit;
        default:{  //echo 'aca..2.';die;
            define(AJAX,false);	
             $db= General();
            Display();
        }break;
    }
function General(){
    
    include_once("../templates/template.php");
    
    if(AJAX==false){
        $db = writeHeader('Consulatar Espacio Fisico',true);
    }else{
       $db = getBD(); 
    }
    
    return $db;
}//function General    
function JsGeneral(){
    ?>
    <style type="text/css" title="currentStyle">
                @import "../../observatorio/data/media/css/demo_page.css";
                @import "../../observatorio/data/media/css/demo_table_jui.css";
                @import "../../observatorio/data/media/css/ColVis.css";
                @import "../../observatorio/data/media/css/TableTools.css";
                @import "../../observatorio/data/media/css/ColReorder.css";
                @import "../../observatorio/data/media/css/tdemes/smoothness/jquery-ui-1.8.4.custom.css";
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
    <?PHP
}//function JsGeneral
?>

<style>
    th{
        text-align: left;

    }
</style>
<script type="text/javascript" language="javascript">
    function InformacionResultado(){
        /*******************************************/
        var Num_Docente    = $('#Num_Docente').val();
        var Num_Estudiante = $('#Num_Estudiante').val();
        var Name_Grupo     = $('#Name_Grupo').val();
        var Name_Materia   = $('#Name_Materia').val();
        
        if(!$.trim(Num_Docente) && !$.trim(Num_Estudiante) && !$.trim(Name_Grupo) && !$.trim(Name_Materia)){
            alert('Por favor Ingrese uno de los Items de Busqueda');
            /***************************************************/
            $('#Num_Docente').effect("pulsate", {times:3}, 500);
            $('#Num_Docente').css('border-color','#F00');
            /***************************************************/
            $('#Num_Estudiante').effect("pulsate", {times:3}, 500);
            $('#Num_Estudiante').css('border-color','#F00');
            /***************************************************/
            $('#Name_Grupo').effect("pulsate", {times:3}, 500);
            $('#Name_Grupo').css('border-color','#F00');
            /***************************************************/
            $('#Name_Materia').effect("pulsate", {times:3}, 500);
            $('#Name_Materia').css('border-color','#F00');
            /***************************************************/
			return false; 
        }
        /*******************************************/
        $('#actionID').val('Buscar');
           
        $.ajax({//Ajax
              type: 'POST',
              url: 'EspaciosFisicosAsigandosReporte.php',
              async: false,
              dataType: 'html',
              data:$('#EspaciosFisicos').serialize(),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
              success: function(data){
                  $('#Carga').html(data);
              }  
        });
        /*******************************************/
    }//function Buscar
</script>

     
<?PHP
function DiasSemana($Fecha,$Op=''){
    
        if($Op=='Nombre'){
            $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');    
        }else{
            $dias = array('','1','2','3','4','5','6','7');    
        }
        
        $fecha = $dias[date('N', strtotime($Fecha))]; 
        
        return $fecha;

}//  function DiasSemana
function dameFecha($fecha,$dia){   
        list($year,$mon,$day) = explode('-',$fecha);
        return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));        
}//function dameFecha
function Display(){
    $fecha_Now = date('Y-m-d');
    
     $dia = DiasSemana($fecha_Now);
    
   
        $Falta  =  1-$dia;
        //$X = '-4';
        $FechaFutura_1 = dameFecha($fecha_Now,$Falta);
        $FechaFutura_2 = dameFecha($FechaFutura_1,6);
    
    ?>
    <script>
    $(document).ready(function(){
		$("#Fecha_Fin").datepicker({ 
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
    <div id="container">
           <h2>Consultar Horario</h2>
            <div class="demo_jui">
            <form id="EspaciosFisicos">
            <input type="hidden" id="actionID" name="actionID" />
                <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;" class="display" >
                    <thead>
                        <tr>
                            <th>
                                <table>
                                    <tr>
                                        <th>Fecha Actual</th>
                                        <th>
                                            <input type="text" id="Fecha_ini" style="text-align: center;" name="Fecha_ini" readonly="readonly" value="<?PHP echo $FechaFutura_1;?>"/>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Fecha Final</th>
                                        <th>
                                            <input type="text" id="Fecha_Fin" style="text-align: center;" name="Fecha_Fin" readonly="readonly" value="<?PHP echo $FechaFutura_2;?>" />
                                        </th> 
                                    </tr>
                                    <tr>
                                        <th>N&deg; Documento Docente</th>
                                        <th>
                                            <input type="text" id="Num_Docente" name="Num_Docente"/>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>N&deg; Documento Estudiante</th>
                                        <th>
                                            <input type="text" id="Num_Estudiante" name="Num_Estudiante" />
                                        </th> 
                                    </tr>
                                    <tr>
                                        <th colspan="2">&nbsp;</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: center;">
                                            <input type="button" id="Buscar" name="Buscar" value="Buscar" onclick="InformacionResultado()" /> 
                                        </th>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <div id="Carga">
                                 
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div>
    </div>
    <?PHP
}//function Display
function Consulta($db,$Num_Docente='',$Num_Estudiante='',$Name_Grupo='',$Name_Materia='',$Fecha_Actual,$Fecha_Fin){
        /*************************************************/
        
        $Fecha = date('Y-m-d');
        $Periodo = Periodo($db);
        
        //echo '<br><br>$Num_Docente->'.$Num_Docente.'<br><br>$Num_Estudiante->'.$Num_Estudiante.'<br><br>$Name_Grupo->'.$Name_Grupo.'<br><br>$Name_Materia->'.$Name_Materia;
       
        $Data = array();
        
        if($Num_Docente!='' && $Num_Estudiante=='' && $Name_Grupo=='' && $Name_Materia==''){
            /******************Filtro Docente**************************************/
            $Condicion = '  g.numerodocumento="'.$Num_Docente.'"';
            $Gruop_By  = 'GROUP BY a.AsignacionEspaciosId';
        }else if($Num_Docente=='' && $Num_Estudiante!='' && $Name_Grupo=='' && $Name_Materia==''){
            /******************Filtro Estudioante**************************************/
            $Condicion = '  eg.numerodocumento="'.$Num_Estudiante.'"';
            $Gruop_By  = 'GROUP BY   x.codigodia,m.codigomateria,d.idgrupo,HoraInicio,HoraFin,a.FechaAsignacion';
        }else if($Num_Docente=='' && $Num_Estudiante=='' && $Name_Grupo!='' & $Name_Materia==''){
            /******************Filtro Nombre Grupo**************************************/
            $Condicion = '  g.nombregrupo LIKE "'.$Name_Grupo.'%"';
            $Gruop_By  = '';
        }else if($Num_Docente=='' && $Num_Estudiante=='' && $Name_Grupo=='' && $Name_Materia!=''){
            /******************Filtro Nombre Materia**************************************/
            $Condicion = '  m.nombremateria LIKE "'.$Name_Materia.'%"';
            $Gruop_By  = '';
        }else if($Num_Docente!='' && $Num_Estudiante!='' && $Name_Grupo=='' && $Name_Materia==''){
            /******************Filtro Num Docente y Estudiante**************************************/
            $Condicion = '  g.numerodocumento="'.$Num_Docente.'" AND eg.numerodocumento="'.$Num_Estudiante.'"';
            $Gruop_By  = '';
        }else if($Num_Docente!='' && $Num_Estudiante=='' && $Name_Grupo!='' && $Name_Materia==''){
            /******************Filtro Num Docente y Name Grupo**************************************/
            $Condicion = '  g.numerodocumento="'.$Num_Docente.'" AND g.nombregrupo LIKE "'.$Name_Grupo.'%"';
            $Gruop_By  = '';
        }else if($Num_Docente!='' && $Num_Estudiante=='' && $Name_Grupo=='' && $Name_Materia!=''){
            /******************Filtro Num Docente y Name Materia**************************************/
            $Condicion = '  g.numerodocumento="'.$Num_Docente.'" AND m.nombremateria LIKE "'.$Name_Materia.'%"';
            $Gruop_By  = '';
        }else if($Num_Docente=='' && $Num_Estudiante!='' && $Name_Grupo!='' && $Name_Materia==''){
            /******************Filtro Num Estudiante y Name Grupo**************************************/
            $Condicion = '  eg.numerodocumento="'.$Num_Estudiante.'" AND g.nombregrupo LIKE "'.$Name_Grupo.'%"';
            $Gruop_By  = '';
        }else if($Num_Docente=='' && $Num_Estudiante!='' && $Name_Grupo=='' && $Name_Materia!=''){
            /******************Filtro Num Estudiante y Name Materia**************************************/
            $Condicion = '  eg.numerodocumento="'.$Num_Estudiante.'" AND m.nombremateria LIKE "'.$Name_Materia.'%"';
            $Gruop_By  = '';
        }else if($Num_Docente=='' && $Num_Estudiante=='' && $Name_Grupo!='' && $Name_Materia!=''){
            /******************Filtro Name Grupo y Name Materia**************************************/
            $Condicion = '  g.nombregrupo LIKE "'.$Name_Grupo.'%"" AND m.nombremateria LIKE "'.$Name_Materia.'%"';
            $Gruop_By  = '';
        }else if($Num_Docente!='' && $Num_Estudiante!='' && $Name_Grupo!='' && $Name_Materia==''){
            /******************Filtro Num Docente, num Estudiante Y Name Grupo **************************************/
            $Condicion = '  g.numerodocumento="'.$Num_Docente.'" AND eg.numerodocumento="'.$Num_Estudiante.'" AND g.nombregrupo LIKE "'.$Name_Grupo.'%"';
            $Gruop_By  = '';
        }else if($Num_Docente!='' && $Num_Estudiante!='' && $Name_Grupo=='' && $Name_Materia!=''){
            /******************Filtro Num Docente, num Estudiante Y Name Materia **************************************/
            $Condicion = '  g.numerodocumento="'.$Num_Docente.'" AND eg.numerodocumento="'.$Num_Estudiante.'" AND m.nombremateria LIKE "'.$Name_Materia.'%"';
            $Gruop_By  = '';
        }else if($Num_Docente=='' && $Num_Estudiante!='' && $Name_Grupo!='' && $Name_Materia!=''){
            /*****************Filtro num Estudiante, Name grupo Y Name Materia **************************************/
            $Condicion = '   eg.numerodocumento="'.$Num_Estudiante.'"  AND g.nombregrupo LIKE "'.$Name_Grupo.'%"  AND m.nombremateria LIKE "'.$Name_Materia.'%"';
            $Gruop_By  = '';
        }else if($Num_Docente!='' && $Num_Estudiante!='' && $Name_Grupo!='' && $Name_Materia!=''){
            /******************Filtro Num Docente ,num Estudiante, Name grupo Y Name Materia **************************************/
            $Condicion = '   g.numerodocumento="'.$Num_Docente.'"  AND eg.numerodocumento="'.$Num_Estudiante.'"  AND g.nombregrupo LIKE "'.$Name_Grupo.'%"  AND m.nombremateria LIKE "'.$Name_Materia.'%"';
            $Gruop_By  = '';
        }else if($Num_Docente=='' && $Num_Estudiante=='' && $Name_Grupo=='' && $Name_Materia==''){
            /******************Error Data**************************************/
           
            $Data['val']     = false;
            $Data['Descrip'] = 'Error en la Data...'; 
           return $Data; 
           exit;
        }          
        
       $ValidaModalidadData = false;
         if($Num_Estudiante){
               $SQL='SELECT 
                    e.codigoestudiante
                    FROM
                    estudiantegeneral ee 
                    INNER JOIN estudiante e ON e.idestudiantegeneral=ee.idestudiantegeneral
                    INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
                    WHERE
                    ee.numerodocumento="'.$Num_Estudiante.'"
                    AND
                    c.codigomodalidadacademica=300';
                    
                  if($ValidaModalidad=&$db->Execute($SQL)===false){
                    echo 'Error en el Sistema .....';
                    die;
                  } 
                  
                  if(!$ValidaModalidad->EOF){
                    $ValidaModalidadData = true;
                  } else{
                    $ValidaModalidadData = false;
                  }
        }     
        //var_dump($ValidaModalidadData);
        if($ValidaModalidadData==false){
        
        $SQL='SELECT
                    p.idprematricula,
                    d.idgrupo,
                    x.codigodia,
                    x.nombredia,
                    m.nombremateria,
                    g.nombregrupo,
                    sg.SolicitudAsignacionEspacioId,
                    IF(c.Nombre IS NULL,"Falta Por Asignar",c.Nombre) AS Nombre,
                    a.FechaAsignacion,
                    if(a.HoraInicio IS NULL,h.horainicial,a.HoraInicio) AS  HoraInicio,
                    IF(a.HoraFin IS NULL, h.horafinal,a.HoraFin) AS HoraFin,
                    cc.Nombre AS Bloke,
                    ccc.Nombre AS Campus,
                    g.numerodocumento AS numDocente,
                    m.nombremateria,
                    CONCAT(dc.nombredocente," ",dc.apellidodocente) AS DocenteName,
                    p.idprematricula,
                    p.codigoestudiante,
                    CONCAT(eg.nombresestudiantegeneral," ",eg.apellidosestudiantegeneral) AS NameEstudiante,
                    eg.numerodocumento
                    
                    
                FROM 
               
                    prematricula p
                        INNER JOIN detalleprematricula d ON d.idprematricula = p.idprematricula
                        INNER JOIN horario h ON h.idgrupo = d.idgrupo
                        INNER JOIN dia x ON x.codigodia = h.codigodia
                        INNER JOIN grupo g ON g.idgrupo = d.idgrupo
                        INNER JOIN materia m ON m.codigomateria = g.codigomateria
                        INNER JOIN estudiante e ON e.codigoestudiante=p.codigoestudiante
                        INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
                        INNER JOIN docente dc ON dc.numerodocumento=g.numerodocumento
                        LEFT JOIN SolicitudEspacioGrupos sg ON sg.idgrupo = d.idgrupo
                        LEFT JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                        LEFT JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                        LEFT JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
                        LEFT JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId=c.ClasificacionEspacionPadreId
                        LEFT JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId=cc.ClasificacionEspacionPadreId

                    
                    WHERE
                            '.$Condicion.'
                            AND (a.EstadoAsignacionEspacio = 1 OR a.EstadoAsignacionEspacio IS NULL)
                            AND d.codigoestadodetalleprematricula = 30
                            AND p.codigoestadoprematricula IN (40,41)
                            AND p.codigoperiodo="'.$Periodo.'"
                            AND (sg.codigoestado=100 OR sg.codigoestado IS NULL)
                            AND (a.codigoestado=100 OR a.codigoestado IS NULL)
                            AND (a.FechaAsignacion BETWEEN "'.$Fecha_Actual.'" AND "'.$Fecha_Fin.'" OR a.FechaAsignacion IS NULL)
                            AND (s.codigodia=h.codigodia OR s.codigodia IS NULL)
                            AND s.codigoestado=100 
                            '.$Gruop_By.'
                            
                    ORDER BY x.codigodia,a.FechaAsignacion ,a.HoraInicio, a.HoraFin';
            }else{
                $SQL='SELECT
                        	p.idprematricula,
                        	g.idgrupo,
                        	x.codigodia,
                        	x.nombredia,
                        	m.nombremateria,
                        	g.nombregrupo,
                        	sg.SolicitudAsignacionEspacioId,
                        
                        IF (
                        	c.Nombre IS NULL,
                        	"Falta Por Asignar",
                        	c.Nombre
                        ) AS Nombre,
                         a.FechaAsignacion,
                        
                        
                        	a.HoraInicio,
                        	a.HoraFin,
                        	
                         cc.Nombre AS Bloke,
                         ccc.Nombre AS Campus,
                         g.numerodocumento AS numDocente,
                         m.nombremateria,
                         
                         p.idprematricula,
                         p.codigoestudiante,
                         CONCAT(
                        	ee.nombresestudiantegeneral,
                        	" ",
                        	ee.apellidosestudiantegeneral
                        ) AS NameEstudiante,
                         ee.numerodocumento,
                         if(g.numerodocumento=1," "," ") AS DocenteName
                        FROM
                        estudiantegeneral ee 
                        INNER JOIN estudiante e ON e.idestudiantegeneral=ee.idestudiantegeneral
                        INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                        INNER JOIN detalleprematricula dp ON dp.idprematricula=p.idprematricula
                        INNER JOIN grupo g ON g.idgrupo=dp.idgrupo
                        INNER JOIN materia m ON m.codigomateria=g.codigomateria
                        LEFT JOIN SolicitudEspacioGrupos sg ON sg.idgrupo=dp.idgrupo
                        LEFT JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId AND s.codigoestado = 100
                        LEFT JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                        LEFT JOIN AsociacionSolicitud aso ON aso.SolicitudAsignacionEspaciosId=s.SolicitudAsignacionEspacioId
                        LEFT JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=a.ClasificacionEspaciosId
                        LEFT JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
                        LEFT JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId
                        LEFT JOIN dia x ON x.codigodia=s.codigodia 
                        
                        WHERE
                        
                        ee.numerodocumento="'.$Num_Estudiante.'" 
                        AND
                        p.codigoperiodo="'.$Periodo.'"
                        AND 
                        dp.codigoestadodetalleprematricula = 30
                        AND 
                        p.codigoestadoprematricula IN (40, 41)
                        AND (
                        	sg.codigoestado = 100
                        	OR sg.codigoestado IS NULL
                        )
                        AND (
                        	a.codigoestado = 100
                        	OR a.codigoestado IS NULL
                        )
                        AND (
                        	a.FechaAsignacion BETWEEN "'.$Fecha_Actual.'" AND "'.$Fecha_Fin.'"
                        
                        	OR a.FechaAsignacion IS NULL
                        )
                        
                        GROUP BY 
                          x.codigodia,
                        	m.codigomateria,
                        	g.idgrupo,
                        	a.HoraInicio,
                        	a.HoraFin,
                        	a.FechaAsignacion
                        
                        ORDER BY
                        	x.codigodia,
                        	a.FechaAsignacion,
                        	a.HoraInicio,
                        	a.HoraFin';
            }    
			//echo $SQL;
                 if($Resultao=&$db->Execute($SQL)===false){
                    Echo 'Error en el SQL de la Consulta....<br><br>'.$SQL;
                    die;
                 }  
           $C_Resultado = $Resultao->GetArray();
          
           $Data['val']   = true;
           $Data['Datos'] = $C_Resultado; 
          return $Data;              
        /*************************************************/
    }//function Consulta
    function Periodo($db){ //echo '<pre>';print_r($db);
        /****************************************************/
          $SQL='SELECT 
                
                codigoperiodo AS id,
                codigoperiodo
                
                FROM periodo
                
                WHERE
                
                codigoestadoperiodo IN(1,3)';
                
            if($Periodos=&$db->Execute($SQL)===false){
                echo 'Error en el SQl Periodos...<br><br>'.$SQL;
                die;
            }   
            
        return $Periodos->fields['id'];     
        /****************************************************/
    }//function Periodo
function Resultado($Datos){
    ?>
              <table cellpadding="0" cellspacing="0" border="0" class="display" style="width: 100%;" id="example">
                    <thead>
                        <tr>    
                            <th>#</th>    
                            <th>Sede o Campus</th> 
                            <th>Bloque</th> 
                            <th>Espacio F&iacute;sico</th>
                            <th>Grupo</th>
                            <th>Materia</th> 
                            <th>Fecha</th> 
                            <th>D&iacute;a</th>
                            <th>Hora Inicial</th>                     
                            <th>Hora Final</th>
                            <th>Nombre Docente</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?PHP 
                    //echo '<pre>';print_r($Datos);die;
                    for($i=0;$i<count($Datos['Datos']);$i++){
                        ?>
                        <tr>
                            <td><?PHP echo $i+1?></td>    
                            <td><?PHP echo $Datos['Datos'][$i]['Campus']?></td>                             
                            <td><?PHP echo $Datos['Datos'][$i]['Bloke']?></td>  
                            <td><?PHP echo $Datos['Datos'][$i]['Nombre']?></td>                          
                            <td><?PHP echo $Datos['Datos'][$i]['nombregrupo']?></td>
                            <td><?PHP echo $Datos['Datos'][$i]['nombremateria']?></td> 
                            <td><?PHP echo $Datos['Datos'][$i]['FechaAsignacion']?></td> 
                            <td><?PHP echo $Datos['Datos'][$i]['nombredia'];?></td>
                            <td><?PHP echo $Datos['Datos'][$i]['HoraInicio']?></td>                     
                            <td><?PHP echo $Datos['Datos'][$i]['HoraFin']?></td>
                            <td><?PHP echo $Datos['Datos'][$i]['DocenteName']?></td>
                            
                        </tr>
                        <?PHP
                    }//for
                    ?>      
                    </tbody>
               </table>    
            
    <?PHP
}//function Resultado    
?> 
        
