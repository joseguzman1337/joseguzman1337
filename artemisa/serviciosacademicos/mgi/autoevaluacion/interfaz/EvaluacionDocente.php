<?php
/*
 * @author Quintrero Ivan <quintreroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología 
 * @Modified : 28 de Septiembre
 */
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);    
    
    $id= $_REQUEST['id'];
    
    $userid  = $_REQUEST['userid'];
    if(empty($userid)){
        $userid = $_SESSION['idusuario'];
    }
    switch($_REQUEST['actionID']){
        case 'BuscarMateria':{
            global $db;
            include_once("../../../ReportesAuditoria/templates/mainjson.php");
            Materias($db,$_POST['instrumento'],$_POST['Userid'],$_POST['CodigoEstudiante']);
        }
        exit;
        case 'DataAdicional':{
            global $db;
            include_once("../../../ReportesAuditoria/templates/mainjson.php");
            DataAdicional($db,$_POST['CodigoEstudiante'],$_POST['Materia'],$_POST['instrumento']);
        }exit;
    }//switch
    
    include_once("../../../EspacioFisico/templates/template.php");
    $db = writeHeader('Evaluacion Docente',true,'../../../mgi/');

    if(empty($id)){
        $queryinstrumento ="select idsiq_Ainstrumentoconfiguracion from siq_Ainstrumentoconfiguracion 
            where fecha_inicio <= NOW() and fecha_fin > NOW() and 
            codigoestado = 100 and cat_ins LIKE '%EDOCENTES%'";    
        $datos = $db->GetRow($queryinstrumento);    
        $id_instrumento = $datos['idsiq_Ainstrumentoconfiguracion'];             
    }else{
        $id_instrumento = $id;
    }
        
    $sql = "select nombre from siq_Ainstrumentoconfiguracion WHERE idsiq_Ainstrumentoconfiguracion=".$id_instrumento; 
    $dataInstrumento = $db->GetRow($sql);
?>
<script>
     function BuscarMaterias(){
        var CodigoEstudiante = $('#Carreras').val();
        var instrumento      = $('#instrumento').val();
        var Userid           = $('#Userid').val();
        
        $.ajax({//Ajax
            type: 'POST',
            url: 'EvaluacionDocente.php',
            async: false,
            dataType: 'html',
            data:({actionID: 'BuscarMateria',CodigoEstudiante:CodigoEstudiante,instrumento:instrumento,Userid:Userid}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data)
            {			
                $('#th_materia').html(data);					
            } 
        }); //AJAX
    }//function BuscarMaterias
    
    function DataAdicional()
    {
        var CodigoEstudiante = $('#Carreras').val();
        var Materia          = $('#Materia').val();
        var instrumento      = $('#instrumento').val();
        
        $.ajax({//Ajax
            type: 'POST',
            url: 'EvaluacionDocente.php',
            async: false,
            dataType: 'html',
            data:({actionID: 'DataAdicional',CodigoEstudiante:CodigoEstudiante,Materia:Materia,instrumento:instrumento}),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data)
            {				
                $('#Td_DataAdicional').html(data);					
            }
        }); //AJAX       
    }// function DataAdicional
    
    function Evaluar()
    {
        var instrumento      = $('#instrumento').val();
        var CodigoEstudiante = $('#Carreras').val();
        var Materia          = $('#Materia').val();
        var Grupo_id         = $('#Grupo_id').val();
        var CodigoJornada    = $('#CodigoJornada').val();
        
        if(CodigoEstudiante===-1 || CodigoEstudiante==='-1')
        {
            $('#Carreras').effect("pulsate", {times:3}, 500);
            $('#Carreras').css('border-color','#F00');
            return false;
        }
        if(Materia===-1 || Materia==='-1')
        {
            $('#Materia').effect("pulsate", {times:3}, 500);
            $('#Materia').css('border-color','#F00');
            return false;
        }
        
        location.href='instrumento_aplicar.php?id_instrumento='+instrumento+'&Ver=1&Grupo_id='+Grupo_id+'&CodigoEstudiante='+CodigoEstudiante+'&CodigoJornada='+CodigoJornada;        
     }//function Evaluar
</script>
<input type="hidden" id="Userid" name="Userid" value="<?PHP echo $userid?>" />
<input type="hidden" id="instrumento" name="instrumento" value="<?PHP echo $id_instrumento?>" />
<table style="margin:20px auto;width:auto;">
    <thead>
        <tr>
            <th colspan="2"><?php echo $dataInstrumento["nombre"]; ?></th>
        </tr>
        <tr>
            <th>Carrera</th>
            <th>
            <?PHP CarrerasEstudiante($db,$userid,$id_instrumento);?>
            </th>
        </tr>
        <tr>
            <th>Materias</th>
            <th id="th_materia"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" id="Td_DataAdicional"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center">
                <input type="button" id="Evaluar" name="Evaluar" value="Realizar evaluación" onclick="Evaluar()" style="  background: -moz-linear-gradient(center top , #7db72f, #4e7d0e) repeat scroll 0 0 transparent;
                border: 1px solid #538312;
                border-radius: 10px;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
                color: #e8f0de;
                cursor: pointer;
                display: inline-block;
                font-size: 14px;
                padding: 8px 19px 9px;
                text-align: center;
                text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);"/>
            </td>
        </tr>
    </tbody>
</table>
<?PHP 
    function ValidoData($db,$userid,$id_instrumento){
	$SQL='SELECT
            p.idsiq_Apublicoobjetivo AS id,
            d.cadena
            FROM
            siq_Apublicoobjetivo p INNER JOIN siq_Adetallepublicoobjetivo d ON d.idsiq_Apublicoobjetivo=p.idsiq_Apublicoobjetivo
            WHERE
            p.idsiq_Ainstrumentoconfiguracion = "'.$id_instrumento.'"
            AND p.codigoestado = 100
            AND cadena IS NOT NULL
            AND cadena NOT IN ("NULL")';
                    
        $CarreasProgramadas=$db->Execute($SQL);
        $C_Carreas  = explode('::',$CarreasProgramadas->fields['cadena']);       
                        
        $Carreras = '';
        $totalCarreras = count($C_Carreas);        

        if($C_Carreas[$i] == 0 && $totalCarreras== 1){
            $carrera = "";
        }else{
            for($i=1;$i<$totalCarreras;$i++){
                if($i==1){
                    $Carreras = '"'.$C_Carreas[$i].'"'; 
                }else{
                    $Carreras = $Carreras.',"'.$C_Carreas[$i].'"';
                }
            }//for                  
            $carrera = " AND e.codigocarrera in ('.$Carreras.') ";
        }
        
        $SQL_Info='SELECT
        e.codigoestudiante,
        e.codigocarrera,
        e.codigotipoestudiante,
        t.nombretipoestudiante,
        e.codigosituacioncarreraestudiante  AS situacion,
        s.nombresituacioncarreraestudiante,
        c.nombrecarrera,
        m.nombremodalidadacademicasic
        FROM
        estudiante e INNER JOIN situacioncarreraestudiante s ON s.codigosituacioncarreraestudiante=e.codigosituacioncarreraestudiante
        INNER JOIN tipoestudiante t ON t.codigotipoestudiante=e.codigotipoestudiante
        INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera '.$carrera.' 
        INNER JOIN modalidadacademicasic m ON m.codigomodalidadacademicasic=c.codigomodalidadacademicasic
        INNER JOIN usuario u INNER JOIN estudiantegeneral eg ON  u.numerodocumento=eg.numerodocumento AND eg.idestudiantegeneral=e.idestudiantegeneral
        WHERE
        u.idusuario="'.$userid.'"
        AND
        m.codigomodalidadacademicasic NOT IN (000,100,101,400)
        AND
        m.codigoestado=100
        AND e.codigosituacioncarreraestudiante IN (200,300,301)';        
        $Info_Estudiante=$db->Execute($SQL_Info);
                    
        /****Filtro Para estudiantes Nuevos o en Trasferencia***/
        if($Info_Estudiante->fields['codigotipoestudiante']==10 || $Info_Estudiante->fields['codigotipoestudiante']==11){
            if($Info_Estudiante->fields['situacion']==300){
                $Condicion = ' E_New=1';
            }
        }
              
        if($Info_Estudiante->fields['codigotipoestudiante']==20 || $Info_Estudiante->fields['codigotipoestudiante']==21){
            if($Info_Estudiante->fields['situacion']==301 || $Info_Estudiante->fields['situacion']==200){ 
                $Condicion = ' E_Old=1';
            }
        }  
        if(empty($carrera)){
           $Carreras = $Info_Estudiante->fields['codigocarrera'];
        }
             
        if($Condicion===null || $Condicion===''){
            $Carreras = '';
        }     
        return $Carreras;
    }//function ValidoData
    
    function CarrerasEstudiante($db,$userid,$id_instrumento){
        $CarrerasCondicion = ValidoData($db,$userid,$id_instrumento);
        $SQL='SELECT     
                u.idusuario,
                eg.idestudiantegeneral,
                e.codigoestudiante,
                c.codigocarrera,
                c.nombrecarrera
            FROM 
                usuario u INNER JOIN estudiantegeneral eg ON u.numerodocumento=eg.numerodocumento
                INNER JOIN estudiante e ON eg.idestudiantegeneral=e.idestudiantegeneral 
                AND e.codigosituacioncarreraestudiante in (300,301,200)
                INNER JOIN carrera c ON e.codigocarrera=c.codigocarrera
            WHERE
                u.idusuario="'.$userid.'"
                AND c.codigocarrera IN ('.$CarrerasCondicion.')';        
        $Carreras=$db->Execute($SQL);
        
        ?>
        <select id="Carreras" name="Carreras" onchange="BuscarMaterias()">
            <option value="-1"></option>
            <?PHP 
                while(!$Carreras->EOF)
                {
                    ?>
                    <option value="<?PHP echo $Carreras->fields['codigoestudiante']?>"><?PHP echo $Carreras->fields['nombrecarrera']?></option>
                    <?PHP
                    $Carreras->MoveNext();
                }
            ?>
       </select>
       <?PHP          
    }//function CarrerasEstudiante
    
    function Periodo($db,$id_instrumento){
        $SQL='SELECT
                p.codigoperiodo,
                c.fecha_inicio,
                c.fecha_fin,
                p.fechainicioperiodo,
                p.fechavencimientoperiodo
            FROM
                siq_Ainstrumentoconfiguracion c ,
                periodo p
            WHERE
                c.idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'"
                AND p.fechainicioperiodo<=c.fecha_inicio
                AND p.fechavencimientoperiodo>=c.fecha_fin';
                    
        $Periodos=$db->Execute($SQL);
        return  $Periodos->fields['codigoperiodo'];     
    }//function Periodo
    
    function Materias($db,$id_instrumento,$userid,$codigoestudiante){
        /*
        * @author Quintrero Ivan <quintreroivan@unbosque.edu.do>
        * @copyright Universidad el Bosque - Dirección de Tecnología 
        * @Modified : 28 de Septiembre
         */
        $Periodo = Periodo($db,$id_instrumento);        
        $SQL='SELECT g.idgrupo, m.codigomateria, m.nombremateria,
            IF (h.horainicial >= "18:00","Nocturna","Diurna") jornada
            FROM
            	prematricula p,
            	detalleprematricula dp,
            	materia m,
            	docente d,
            	grupo g
            LEFT JOIN horario h ON h.idgrupo = g.idgrupo
            LEFT JOIN dia di ON di.codigodia = h.codigodia
            WHERE
            	p.idprematricula = dp.idprematricula
            AND dp.codigomateria = m.codigomateria
            AND p.codigoestadoprematricula LIKE "4%"
            AND dp.codigoestadodetalleprematricula LIKE "3%"
            AND g.idgrupo = dp.idgrupo AND g.idgrupo NOT IN (76993,80085,77029,77050,76812,77056)
            AND g.numerodocumento = d.numerodocumento
            AND p.codigoperiodo = "'.$Periodo.'"
            AND p.codigoestudiante = "'.$codigoestudiante.'"
            AND m.codigomateria NOT IN (
            	SELECT
            		m.codigomateria
            	FROM
            		siq_ADetallesRespuestaInstrumentoEvaluacionDocente e
            	INNER JOIN actualizacionusuario a ON a.idactualizacionusuario = e.idactualizacionusuario
            	INNER JOIN grupo g ON e.idgrupo = g.idgrupo
            	INNER JOIN materia m ON m.codigomateria = g.codigomateria
            	WHERE
            		a.id_instrumento ="'.$id_instrumento.'"
            	AND a.usuarioid = "'.$userid.'"
            	AND e.codigoestado = 100
            )
            AND
                m.codigomateria NOT IN(SELECT
                	codigomateria
                FROM
                	MateriasExcluidasEncuesta
                
                WHERE
                 idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'"
                AND
                codigoestado=100
				)
            GROUP BY
            	m.codigomateria';    
        $Materias = $db->Getall($SQL);
        $listaMaterias= array();
        foreach($Materias as $listado){
            $grupo = $listado['idgrupo'];
            $materia = $listado['codigomateria'];
            $nombremateria = $listado['nombremateria'];
            
            $sqlgrupos ="SELECT COUNT(*) as contador FROM siq_Arespuestainstrumento r 
                INNER JOIN usuario u on r.usuariocreacion = u.idusuario
                INNER JOIN estudiantegeneral g on g.numerodocumento = u.numerodocumento and u.codigotipousuario = 600
                INNER JOIN estudiante e on g.idestudiantegeneral = e.idestudiantegeneral
            where r.idsiq_Ainstrumentoconfiguracion = ".$id_instrumento."
            and e.codigoestudiante = ".$codigoestudiante." and r.codigoestado = 100 and r.idgrupo = ".$grupo." ";
            $grupos = $db->GetRow($sqlgrupos );
            
            $sqltotalpreguntas = "select count(*) as total from siq_Ainstrumento a "
            . "where a.idsiq_Ainstrumentoconfiguracion = ".$id_instrumento." and a.codigoestado = '100'";
            $total = $db->GetRow($sqltotalpreguntas);
            
            if($grupos['contador'] > $total['total']){
                unset($listado['idgrupo']);
                unset($listado['0']);
                unset($listado['codigomateria']);
                unset($listado['1']);
                unset($listado['nombremateria']);
                unset($listado['2']);
            }else{
                $listaMaterias[]= $listado;                      
            }
        }//foreach        
        
        ?>
        <select id="Materia" name="Materia" onchange="DataAdicional()">
            <option value="-1"></option>
            <?PHP 
            foreach($listaMaterias as $nombres){
                ?>
                <option value="<?PHP echo $nombres['codigomateria']?>"><?PHP echo $nombres['nombremateria']?></option>
                <?PHP 
            }
        ?>
        </select>
      <?PHP   
    }//function Materias
    
    function DataAdicional($db,$codigoestudiante,$codigomateria,$id_instrumento){
        $Periodo = Periodo($db,$id_instrumento);
        $SQL='SELECT d.nombredocente,d.apellidodocente, 
        IF ( h.horainicial >= "18:00", "02", "01" ) jornada,
        g.idgrupo AS Grupo_id,
	di.nombredia, h.horainicial, h.horafinal
            FROM
            	prematricula p,
            	detalleprematricula dp,
            	materia m,
            	docente d,
            	grupo g
            LEFT JOIN horario h ON h.idgrupo = g.idgrupo
            LEFT JOIN dia di ON di.codigodia = h.codigodia
            WHERE
            	p.idprematricula = dp.idprematricula
            AND dp.codigomateria = m.codigomateria
            AND p.codigoestadoprematricula LIKE "4%"
            AND dp.codigoestadodetalleprematricula LIKE "3%"
            AND g.idgrupo = dp.idgrupo
            AND g.numerodocumento = d.numerodocumento
            AND p.codigoperiodo = "'.$Periodo.'"
            AND p.codigoestudiante = "'.$codigoestudiante.'"
            AND m.codigomateria="'.$codigomateria.'"
            GROUP BY
            	m.codigomateria';          
        
        $MateriaData=$db->GetRow($SQL);
        ?>
        <table>
            <tr>
                <td><strong>Docente:</strong></td>
                <td><?PHP echo $MateriaData['nombredocente'].' '.$MateriaData['apellidodocente']?><input type="hidden" id="Grupo_id" name="Grupo_id" value="<?PHP echo $MateriaData['Grupo_id']?>" /></td>
            </tr>
            <tr>
                <td><strong>D&iacute;a:</strong></td>
                <td><?PHP echo $MateriaData['nombredia']?><input type="hidden" id="CodigoJornada" name="CodigoJornada" value="<?PHP echo $MateriaData['jornada']?>" /></td>
            </tr>
            <tr>
                <td><strong>Hora Inicial:</strong></td>
                <td><?PHP echo $MateriaData['horainicial']?></td>
            </tr>
            <tr>
                <td><strong>Hora Final:</strong></td>
                <td><?PHP echo $MateriaData['horafinal']?></td>
            </tr>
            <tr>
                <td><strong>Jornada:</strong></td>
                <td><?PHP echo $MateriaData['jornada']?></td>
            </tr>
        </table>
        <?PHP
    }//function DataAdicional