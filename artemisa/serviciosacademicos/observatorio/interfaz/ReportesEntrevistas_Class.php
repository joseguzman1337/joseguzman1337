<?php
class ReportesEntrevistas{
    public function RerporteSaberOnce(){
        global $db,$CodigoCarreraUser;
        
        ?>
        <div id="container">
            <fieldset>
                <legend>Reporte Saber 11</legend>
                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center"  style="width: 100%;" >
                    <thead>
                        <tr>
                            <th><strong>Programa acad&eacute;mico</strong></th>
                            <th><?PHP $this->ProgramasAcademicos($CodigoCarreraUser);?></th>
                            <th>&nbsp;</th>
                            <th><strong>Periodo</strong></th>
                            <th><?PHP $this->Periodos();?></th>
                        </tr>
                        <tr>
                            <th colspan="5">&nbsp;</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;" colspan="5">
                                <input type="button" id="Buscar" name="Buscar" value="Buscar." onclick="BuscarData('BuscarInfo','Div_Carga','1')" />
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5">
                                <div id="Div_Carga" style="width: 100%;"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </div>        
        <?PHP
    }//public function RerporteSaberOnce
    public function QueryExamenEstado($CodigoCarrera,$codigoPeriodo,$Op){
        global $db;
        
       $SQL='SELECT 
                        eg.numerodocumento,
                        CONCAT(eg.nombresestudiantegeneral," ",eg.apellidosestudiantegeneral) as nombreEstudiante, 
                        ee.codigoperiodo,
                        IFNULL(SUM(drp.notadetalleresultadopruebaestado),0) as resultado, 
                        COUNT(drp.idasignaturaestado) as asignaturas, 
                        IFNULL(rp.idresultadopruebaestado,UUID()) as unique_id
                        
                        FROM estudianteestadistica ee INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante and e.codigocarrera="'.$CodigoCarrera.'"
                                                      INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
                                                      INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral
                                                      LEFT JOIN resultadopruebaestado rp on rp.idestudiantegeneral=e.idestudiantegeneral
                                                      LEFT JOIN detalleresultadopruebaestado drp on drp.idresultadopruebaestado=rp.idresultadopruebaestado                        
                        WHERE ee.codigoperiodo="'.$codigoPeriodo.'" 
                              AND  ee.codigoprocesovidaestudiante= 400
                              AND 
                              ee.codigoestado = 100  AND
                              rp.codigoestado =100
							  AND drp.notadetalleresultadopruebaestado IS NOT NULL
                        GROUP BY unique_id
                        ORDER BY 3,2,nombreEstudiante';

         if($DataExamenEstado=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Los Reultados Prueba Estado....<br>'.$SQL;
            die;
         }    
         
         $D_ExamenEstado = $DataExamenEstado->GetArray();
         
         $Data = array();
            
            $Num = count($D_ExamenEstado);
            
            
            
            $Suma  = 0;
           
            $Data_P = array();
            $cont   = 0;
            $documento=null;
            for($i=0;$i<$Num;$i++){
                /**********************************************/
                if($D_ExamenEstado[$i]['numerodocumento']!=$documento){
                    $Pre_Promedio = $D_ExamenEstado[$i]['resultado']/$D_ExamenEstado[$i]['asignaturas'];
                    $Suma = $Suma+$Pre_Promedio;
                    
                    
                    $Data_P[$cont]['numerodocumento']        = $D_ExamenEstado[$i]['numerodocumento'];
                    $Data_P[$cont]['nombreEstudiante']       = $D_ExamenEstado[$i]['nombreEstudiante'];
                    $Data_P[$cont]['codigoperiodo']          = $D_ExamenEstado[$i]['codigoperiodo'];
                    $Data_P[$cont]['resultado']              = $D_ExamenEstado[$i]['resultado'];
                    $Data_P[$cont]['asignaturas']            = $D_ExamenEstado[$i]['asignaturas'];
                    
                    $cont++;
					$documento=$D_ExamenEstado[$i]['numerodocumento'];
                }
                //$Suma = $Suma+$D_ExamenEstado[$i]['resultado'];
                /**********************************************/
            }//for
            
            
            $Promedio = $Suma/count($Data_P);
         
         if($Op=='Conteo'){
            $Data['Promedio']          = number_format($Promedio,'2','.','.');
            $Data['NumeroEstudiantes'] = count($Data_P);
            return $Data;
         }else if($Op=='Arreglo'){
            return $Data_P;                        
         }//if           
        
    }//public function QueryExamenEstado
	public function QueryDetalleExamenEstado($CodigoCarrera,$codigoPeriodo){
        global $db;
		
		//las materias de la prueba antes del 2014
		$SQL='select idasignaturaestado,nombreasignaturaestado from asignaturaestado WHERE TipoPrueba=1 AND codigoestado=100 ORDER BY nombreasignaturaestado ASC';
        $MateriasExmane2013 = $db->GetAll($SQL);
		
		//las materias de la prueba desde el 2014 hasta el 2016
		$SQL='select idasignaturaestado,nombreasignaturaestado from asignaturaestado WHERE TipoPrueba=2 AND codigoestado=100 ORDER BY nombreasignaturaestado ASC';
        $MateriasExmane2014 = $db->GetAll($SQL);
        
        //las materias de la prueba a partir del 2016
		$SQL='select idasignaturaestado,nombreasignaturaestado from asignaturaestado WHERE TipoPrueba=3 AND codigoestado=100 ORDER BY nombreasignaturaestado ASC';
        $MateriasExmane2016 = $db->GetAll($SQL);
	
        
        $SQL='select idasignaturaestado,nombreasignaturaestado from asignaturaestado WHERE TipoPrueba=0 AND codigoestado=100 ORDER BY nombreasignaturaestado ASC';
        $MateriasExmanePIR = $db->GetAll($SQL);
	
        
        $SQL='SELECT   *
                        FROM(
                        SELECT
                        	eg.numerodocumento,
                        	CONCAT(
                        		eg.nombresestudiantegeneral,
                        		" ",
                        		eg.apellidosestudiantegeneral
                        	) AS nombreEstudiante,
                        	ee.codigoperiodo,
                        	e.codigoestudiante,
                        	ae.TipoPrueba,
                        	rp.PuntajeGlobal,
                        COUNT(drp.iddetalleresultadopruebaestado) AS num
                        FROM
                        	estudianteestadistica ee
                        INNER JOIN estudiante e ON e.codigoestudiante = ee.codigoestudiante AND e.codigocarrera = "'.$CodigoCarrera.'"
                        INNER JOIN carrera c ON c.codigocarrera = e.codigocarrera
                        INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral
                        INNER JOIN resultadopruebaestado rp ON rp.idestudiantegeneral = e.idestudiantegeneral
                        INNER JOIN detalleresultadopruebaestado drp ON drp.idresultadopruebaestado = rp.idresultadopruebaestado
                        INNER JOIN asignaturaestado ae ON ae.idasignaturaestado = drp.idasignaturaestado
                        WHERE
                        	ee.codigoperiodo = "'.$codigoPeriodo.'"
                        AND ee.codigoprocesovidaestudiante = 400
                        AND ee.codigoestado LIKE "1%"
                        AND drp.codigoestado = 100
                        AND rp.codigoestado = 100
                        GROUP BY eg.idestudiantegeneral , ae.TipoPrueba
                        
                        ORDER BY
                        	3,
                        	2,
                        	ae.nombreasignaturaestado
                        ) x  INNER JOIN (
                        SELECT
                        e.codigoestudiante AS codigo,	
                         drp.notadetalleresultadopruebaestado AS resultado,
                        drp.idasignaturaestado AS asignaturas,
                        		ae.TipoPrueba as tipo_b,
                        	ae.nombreasignaturaestado
                        
                        
                        FROM
                        	estudianteestadistica ee
                        INNER JOIN estudiante e ON e.codigoestudiante = ee.codigoestudiante AND e.codigocarrera = "'.$CodigoCarrera.'"
                        INNER JOIN carrera c ON c.codigocarrera = e.codigocarrera
                        INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral
                        INNER JOIN resultadopruebaestado rp ON rp.idestudiantegeneral = e.idestudiantegeneral
                        INNER JOIN detalleresultadopruebaestado drp ON drp.idresultadopruebaestado = rp.idresultadopruebaestado
                        INNER JOIN asignaturaestado ae ON ae.idasignaturaestado = drp.idasignaturaestado
                        WHERE
                        	ee.codigoperiodo ="'.$codigoPeriodo.'"
                        AND ee.codigoprocesovidaestudiante = 400
                        AND ee.codigoestado LIKE "1%"
                        AND drp.codigoestado = 100 AND rp.codigoestado = 100
                        ) y ON y.codigo=x.codigoestudiante AND  y.tipo_b=x.TipoPrueba';
                        //WHERE x.num >=7';                       
        $DataExamenEstado=&$db->Execute($SQL); 
        $D_ExamenEstado = $DataExamenEstado->GetArray();
                 
        $Data = array();
        $suma = 0;
        $asignaturas = 0;
        $asignaturasOpcionDos = 0;
        $asignaturasOpcionTres = 0;
        $asignaturasOpcionCero = 0;
        $sumaOpcionDos=0;
        $sumaOpcionTres=0;
        $sumaOpcionCero=0;
        
        foreach($D_ExamenEstado as $dato)
        {
            if($dato["TipoPrueba"]== '1')
            {                
                $Data['1'][$dato["codigoestudiante"]]["numerodocumento"]=$dato['numerodocumento'];
                $Data['1'][$dato["codigoestudiante"]]["nombre"]=$dato['nombreEstudiante'];
                $Data['1'][$dato["codigoestudiante"]]['asignaturas'][$dato['asignaturas']] = $dato['resultado'];
                $suma = $suma+$dato["resultado"];
                $asignaturas++;
                if($asignaturas == '9')
                {
                    $Data['1'][$dato["codigoestudiante"]]["promedio"]=$suma/$asignaturas; 
                    $asignaturas=0;
                    $suma=0;
                }
            }    
           if($dato["TipoPrueba"]== '2')
            {
                $Data['2'][$dato["codigoestudiante"]]["numerodocumento"]=$dato['numerodocumento'];
                $Data['2'][$dato["codigoestudiante"]]["nombre"]=$dato['nombreEstudiante'];
                $Data['2'][$dato["codigoestudiante"]]['asignaturas'][$dato['asignaturas']] = $dato['resultado'];
                $Data['2'][$dato["codigoestudiante"]]['PuntajeGlobal'] = $dato['PuntajeGlobal'];
                $sumaOpcionDos = $sumaOpcionDos+$dato["resultado"];
                $asignaturasOpcionDos++;
                if($asignaturasOpcionDos == '7')
                {
                    $Data['2'][$dato["codigoestudiante"]]["promedio"]=$sumaOpcionDos/$asignaturasOpcionDos;    
                    $asignaturasOpcionDos=0;
                    $sumaOpcionDos=0;
                }
            }
            if($dato["TipoPrueba"]== '3')
            {
                $Data['3'][$dato["codigoestudiante"]]["numerodocumento"]=$dato['numerodocumento'];
                $Data['3'][$dato["codigoestudiante"]]["nombre"]=$dato['nombreEstudiante'];
                $Data['3'][$dato["codigoestudiante"]]['asignaturas'][$dato['asignaturas']] = $dato['resultado'];
                $Data['3'][$dato["codigoestudiante"]]['PuntajeGlobal'] = $dato['PuntajeGlobal'];
                $sumaOpcionTres = $sumaOpcionTres+$dato["resultado"];
                $asignaturasOpcionTres++;
                if($asignaturasOpcionTres == '5')
                {
                    $Data['3'][$dato["codigoestudiante"]]["promedio"]=$sumaOpcionTres/$asignaturasOpcionTres;    
                    $asignaturasOpcionTres=0;
                    $sumaOpcionTres=0;
                }
            }  
            
            if($dato["TipoPrueba"]== '0')
            {
                $Data['0'][$dato["codigoestudiante"]]["numerodocumento"]=$dato['numerodocumento'];
                $Data['0'][$dato["codigoestudiante"]]["nombre"]=$dato['nombreEstudiante'];
                $Data['0'][$dato["codigoestudiante"]]['asignaturas'][$dato['asignaturas']] = $dato['resultado'];
                $Data['0'][$dato["codigoestudiante"]]['PuntajeGlobal'] = $dato['PuntajeGlobal'];
                $sumaOpcionCero = $sumaOpcionCero+$dato["resultado"];
                $asignaturasOpcionCero++;
                
            }
            
        }//for           
        return array("materias1"=>$MateriasExmane2013,"materias2"=>$MateriasExmane2014,"materias3"=>$MateriasExmane2016,"materias4"=>$MateriasExmanePIR,"resultados"=>$Data);               
    }//public function QueryDetalleExamenEstado
    
    
    public function SelectBox($Resultado,$name,$T,$Funcion=''){
        ?>
        <select id="<?PHP echo $name?>" name="<?PHP echo $name?>" onchange="<?PHP echo $Funcion?>" style="width:<?PHP echo $T?>%;">
            <option value="-1"></option>
            <?PHP 
            while(!$Resultado->EOF){
                /**************************************/
                ?>
                <option value="<?PHP echo $Resultado->fields['id']?>"><?PHP echo $Resultado->fields['Nombre']?></option>
                <?PHP 
                /**************************************/
                $Resultado->MoveNext();
            }//While
            ?>
        </select>
        <?PHP 
    }//public function SelectBox
    
    
    public function ProgramasAcademicos($CodigoCarreraUser,$Op="select")
    {
        global $db;
        if($CodigoCarreraUser=='156' || !$CodigoCarreraUser || $CodigoCarreraUser=='1' || $CodigoCarreraUser=='2'){
            $Condicion = '';
        }else{
            $Condicion = 'AND codigocarrera="'.$CodigoCarreraUser.'"'; 
        }
        
        $SQL='SELECT 
                        codigocarrera AS id, 
                        nombrecarrera AS Nombre  
                        
              FROM carrera 
              
              WHERE 
                        codigomodalidadacademicasic =200 
                        '.$Condicion.'
              
              ORDER BY nombrecarrera ASC';
        
        if($Carreras=&$db->Execute($SQL)===false){
            echo 'Error en el SQl De Programas Academicos....<br>'.$SQL;
            die;
        }
        
        if($Op=="select"){
			$this->SelectBox($Carreras,'Carrera_id','90');
		} else if($Op=="arreglo"){
			return $Carreras->GetArray();
		}
    }//public function ProgramasAcademicos
    
    
    public function Periodos(){
        global $db;
        
        $SQL='SELECT codigoperiodo AS id, codigoperiodo AS Nombre FROM  periodo  ORDER BY codigoperiodo DESC';
        
        if($Periodo=&$db->execute($SQL)===false){
            echo 'Error en el SQl de los Periodos....<br>'.$SQL;
            die;
        }
        
        $this->SelectBox($Periodo,'CodigoPeriodo','90');
    }//public function Periodos
    public function ViewReport($Carrera_id,$CodigoPeriodo){
        global $db;
        
        $Datos  = $this->QueryExamenEstado($Carrera_id,$CodigoPeriodo,'Conteo');
         
        $arrayP = str_split($CodigoPeriodo, strlen($CodigoPeriodo)-1);
        
        
        $Periodo = $arrayP[0].'-'.$arrayP[1];
        
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
                        <th><strong>Periodo</strong></th>
                        <th><strong>N&deg; de Estudiantes</strong></th>
                        <th><strong>Promedio Saber 11</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;"><?PHP echo $Periodo;?></td><!--Periodo-->
                        <td style="text-align: center;cursor: pointer;" title="Ver Detalle." onclick="VerDetalle();"><span style="color: #0063dc;"><?PHP echo $Datos['NumeroEstudiantes'];?></span></td><!--Num Estudiantes-->
                        <td style="text-align: center;"><?PHP echo $Datos['Promedio'];?></td><!--Promedio-->
                    </tr>
                </tbody>
            </table>
        </div>
        
        
        <?PHP
    }//public function ViewReport
    public function ViewDetalleReport($Carrera_id,$CodigoPeriodo){
        global $db;
        
        //$Datos  = $this->QueryExamenEstado($Carrera_id,$CodigoPeriodo,'Arreglo');
        $DatosDetalle  = $this->QueryDetalleExamenEstado($Carrera_id,$CodigoPeriodo);

		$carrera = $this->ProgramasAcademicos($Carrera_id,"arreglo");
		//var_dump($carrera);
        $arrayP = str_split($CodigoPeriodo, strlen($CodigoPeriodo)-1);
        
        
        $Periodo = $arrayP[0].'-'.$arrayP[1];
        
        ?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
            
            $(document).ready( function () {
			
			oTable = $('#Cambio').dataTable({
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
			
			oTable2 = $('#Cambio2').dataTable({
                            "sDom": '<"H"Cfrltip>',
                            "bJQueryUI": true,
                            "bPaginate": true,
                            "sPaginationType": "full_numbers",
                            "oColVis": {
                                  "buttonText": "Ver/Ocultar Columns",
                                   "aiExclude": [ 0 ]
                            }
                        });
                        var oTableTools2 = new TableTools( oTable2, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
						{ "type": "print", "buttonText": "Print me!" }
					]
		         });   oTable3 = $('#Cambio3').dataTable({
                            "sDom": '<"H"Cfrltip>',
                            "bJQueryUI": true,
                            "bPaginate": true,
                            "sPaginationType": "full_numbers",
                            "oColVis": {
                                  "buttonText": "Ver/Ocultar Columns",
                                   "aiExclude": [ 0 ]
                            }
                        });
                          oTable4 = $('#Cambio4').dataTable({
                            "sDom": '<"H"Cfrltip>',
                            "bJQueryUI": true,
                            "bPaginate": true,
                            "sPaginationType": "full_numbers",
                            "oColVis": {
                                  "buttonText": "Ver/Ocultar Columns",
                                   "aiExclude": [ 0 ]
                            }
                        });
                        var oTableTools2 = new TableTools( oTable2, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
						{ "type": "print", "buttonText": "Print me!" }
					]
		         });
                         $('#demo_2').before( oTableTools.dom.container );
                         $('#demo_21').before( oTableTools2.dom.container );
                         $('#demo_22').before( oTableTools3.dom.container );
                         $('#demo_23').before( oTableTools3.dom.container );
						 
						resizeWindow('#container',oTable);
						//resizeWindow('#demo_2',oTable);
						resizeWindow('#demo_21',oTable2);
						resizeWindow('#demo_22',oTable3);
                                                resizeWindow('#demo_23',oTable3);
		} );
            
			//Para que al cambiar el tamaño de la página se arreglen las tablas
			/*$(window).resize(function() {
				resizeWindow('#container',oTable);
				//console.log("hola");
				//resizeWindow('#demo_21',oTable2);
			});*/
			
			//Para que al cambiar el tamaño de la página se arreglen las tablas
			function resizeWindow(tableContainer,table){
				 //window.location.href=window.location.href;
				 //alert("aja ey");
				 if(typeof table != 'undefined'){
					//var maxWidth = $(tableContainer).width();  
					//console.log(maxWidth + " - " + table.width());
					//table.width(maxWidth);
					$(tableContainer).width(table.width()+10);
				 }
			}
        </script>
		</head>
		<body>
        <div id="container">
		
        <div id="demo_2">
            <table cellpadding="0" cellspacing="0" border="1" class="display responsive" id="Cambio" style="font-size:12px">
                <thead>
					<tr>
						<th colspan="<?php echo (count($DatosDetalle["materias1"])+5); ?>"><strong>SABER 11 - Antes de Agosto 2014</strong></th>
					</tr>
					<tr>
						<th colspan="<?php echo (count($DatosDetalle["materias1"])+5); ?>"><strong><?php echo $carrera[0]["Nombre"]; ?></strong></th>
					</tr>
                    <tr>
                        <th><strong>N&deg;</strong></th>
                        <th><strong>Periodo</strong></th>
                        <th><strong>N&deg; de Documento</strong></th>
                        <th><strong>Nombres y Apellidos</strong></th>
						<?php foreach ($DatosDetalle["materias1"] as $asignatura) { ?>
						<th><strong><?php echo $asignatura["nombreasignaturaestado"]; ?></strong></th>
						<?php } ?>
                        <th><strong>Promedio Saber 11</strong></th>
                    </tr>
                </thead>
                <tbody>
                <?PHP 
                foreach($DatosDetalle['resultados'][1] as $resultadoAntiguo){
                /*@modified Diego Rivera<riveradiego@unbosque.edu.co>
                 *se añade variables $puntaje para identificar cuantas materias del tipo de icfes tiene varlor
                 *se añade variabel $acumulaValor para sumar los resultado de las materias del tipo de icfes 
                 *@since octuber 31 ,2018 
                 */ 
                $puntaje=0;
                $acumulaValor=0;
                  ?>
                    <tr>
                        <td style="text-align: center;"><?PHP echo $i+1;$i++;?></td>
                        <td style="text-align: center;"><?PHP echo $Periodo;?></td><!--Periodo-->
                        <td style="text-align: center;"><?PHP echo $resultadoAntiguo['numerodocumento'];?></td><!--Num Documetno-->
                        <td ><?PHP echo $resultadoAntiguo['nombre'];?></td><!--Nombres y Apellidos-->
                        <?php foreach ($DatosDetalle["materias1"] as $asignatura) { ?>
                        <td style="text-align: center;">
                            <?PHP 
                                if(isset($resultadoAntiguo['asignaturas'][$asignatura["idasignaturaestado"]])){
                                     echo $resultadoAntiguo['asignaturas'][$asignatura["idasignaturaestado"]];
                                     $puntaje++;
                                     $acumulaValor=$acumulaValor+$resultadoAntiguo['asignaturas'][$asignatura["idasignaturaestado"]];
                                }
                            ?></td>
                        <?php } ?>
                        <td style="text-align: center;">
                            <?PHP 
                               /*@modified Diego Rivera<riveradiego@unbosque.edu.co>
                                *Se reemplaza validacion 
                                * if(isset($resultadoAntiguo['promedio'])){
                                    echo number_format($resultadoAntiguo['promedio'],'2','.','.');
                                }
                                *se crea manual debido a que el promedio saber 11 no es el correcto 
                                *@since octuber 31 ,2018 
                                */  
                                if($puntaje==9){
                                   
                                  echo number_format($acumulaValor/9,"2");
                                }
                            ?>
                        </td><!--Promedio-->
                    </tr>
                    <?PHP
                    /*****************************************/
                }//for
                ?>
                </tbody>
            </table>
        </div>
		<br/><br/><br/>
		<div id="demo_21">
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="Cambio2" style="font-size:12px" >
                <thead>
					<tr>
						<th colspan="<?php echo (count($DatosDetalle["materias2"])+6); ?>"><strong>SABER 11 - Entre Agosto 2014 y Febrero 2016 </strong></th>
					</tr>
					<tr>
						<th colspan="<?php echo (count($DatosDetalle["materias2"])+6); ?>"><strong><?php echo $carrera[0]["Nombre"]; ?></strong></th>
					</tr>
                    <tr>
                        <th><strong>N&deg;</strong></th>
                        <th><strong>Periodo</strong></th>
                        <th><strong>N&deg; de Documento</strong></th>
                        <th><strong>Nombres y Apellidos</strong></th>
						<?php foreach ($DatosDetalle["materias2"] as $asignatura) { ?>
						<th><strong><?php echo $asignatura["nombreasignaturaestado"]; ?></strong></th>
						<?php } ?>
                        <th><strong>Promedio Saber 11</strong></th>
                        <th><strong>Puntaje Global</strong></th>
                    </tr>
                </thead>
                <tbody>
                <?PHP 
                $i=0;
                foreach($DatosDetalle['resultados'][2] as $resultadoAntiguo){
                /*@modified Diego Rivera<riveradiego@unbosque.edu.co>
                *se añade variables $puntaje para identificar cuantas materias del tipo de icfes tiene varlor
                *se añade variabel $acumulaValor para sumar los resultado de las materias del tipo de icfes 
                *@since octuber 31 ,2018 
                */ 
                $puntaje=0;
                $acumulaValor=0;
                  ?>
                    <tr>
                        <td style="text-align: center;"><?PHP echo $i+1;$i++;?></td>
                        <td style="text-align: center;"><?PHP echo $Periodo;?></td><!--Periodo-->
                        <td style="text-align: center;"><?PHP echo $resultadoAntiguo['numerodocumento'];?></td><!--Num Documetno-->
                        <td ><?PHP echo $resultadoAntiguo['nombre'];?></td><!--Nombres y Apellidos-->
                        <?php foreach ($DatosDetalle["materias2"] as $asignatura) { ?>
                        <td style="text-align: center;">
                            <?PHP 
                                if(isset($resultadoAntiguo['asignaturas'][$asignatura["idasignaturaestado"]])){
                                    echo $resultadoAntiguo['asignaturas'][$asignatura["idasignaturaestado"]];
                                    $puntaje++;
                                    $acumulaValor=$acumulaValor+$resultadoAntiguo['asignaturas'][$asignatura["idasignaturaestado"]];
                                }
                            ?>
                        </td>
                        <?php } ?>
                        <td style="text-align: center;">
                            <?PHP 
                            /*@modified Diego Rivera<riveradiego@unbosque.edu.co>
                            *Se reemplaza validacion 
                            * if(isset($resultadoAntiguo['promedio'])){
                                echo number_format($resultadoAntiguo['promedio'],'2','.','.');
                            }
                            *se crea manual debido a que el promedio saber 11 no es el correcto 
                            *@since octuber 31 ,2018 
                            */  
                                if($puntaje==7){
                                    echo number_format($acumulaValor/7,"2");
                                } 
                            ?>
                        </td><!--Promedio-->
                        <td style="text-align: center;"><?PHP echo $resultadoAntiguo['PuntajeGlobal'];?></td>
                    </tr>
                    <?PHP
                    /*****************************************/
                }//for
                ?>
                </tbody>
            </table>
        </div><br/><br/><br/>
		<div id="demo_22">
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="Cambio3" style="font-size:12px" >
                <thead>
					<tr>
						<th colspan="<?php echo (count($DatosDetalle["materias3"])+5); ?>"><strong>SABER 11 - A partir de Marzo 2016 </strong></th>
					</tr>
					<tr>
						<th colspan="<?php echo (count($DatosDetalle["materias3"])+5); ?>"><strong><?php echo $carrera[0]["Nombre"]; ?></strong></th>
					</tr>
                    <tr>
                        <th><strong>N&deg;</strong></th>
                        <th><strong>Periodo</strong></th>
                        <th><strong>N&deg; de Documento</strong></th>
                        <th><strong>Nombres y Apellidos</strong></th>
                        <?php foreach ($DatosDetalle["materias3"] as $asignatura) { ?>
                        <th><strong><?php echo $asignatura["nombreasignaturaestado"]; ?></strong></th>
                        <?php } ?>                        
                        <th><strong>Puntaje Global</strong></th>
                    </tr>
                </thead>
                <tbody>
                <?PHP 
                $i=0;
                foreach($DatosDetalle['resultados'][3] as $resultadoAntiguo){
                    /*****************************************/
					//var_dump($resultadoAntiguo); echo "<br/><br/>";
                  ?>
                    <tr>
                        <td style="text-align: center;"><?PHP echo $i+1;$i++;?></td>
                        <td style="text-align: center;"><?PHP echo $Periodo;?></td><!--Periodo-->
                        <td style="text-align: center;"><?PHP echo $resultadoAntiguo['numerodocumento'];?></td><!--Num Documetno-->
                        <td ><?PHP echo $resultadoAntiguo['nombre'];?></td><!--Nombres y Apellidos-->
						<?php foreach ($DatosDetalle["materias3"] as $asignatura) { ?>
						<td style="text-align: center;"><?PHP if(isset($resultadoAntiguo['asignaturas'][$asignatura["idasignaturaestado"]])){ echo $resultadoAntiguo['asignaturas'][$asignatura["idasignaturaestado"]];}?></td>
						<?php } ?>
                       <td style="text-align: center;"><?PHP echo $resultadoAntiguo['PuntajeGlobal'];?></td>
                    </tr>
                    <?PHP
                    /*****************************************/
                }//for
                ?>
                </tbody>
            </table>
        </div>
        
        <br/><br/><br/>
		<div id="demo_23">
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="Cambio4" style="font-size:12px" >
                <thead>
					<tr>
						<th colspan="<?php echo (count($DatosDetalle["materias4"])+5); ?>"><strong>SABER 11 - PIR</strong></th>
					</tr>
					<tr>
						<th colspan="<?php echo (count($DatosDetalle["materias4"])+5); ?>"><strong><?php echo $carrera[0]["Nombre"]; ?></strong></th>
					</tr>
                    <tr>
                        <th><strong>N&deg;</strong></th>
                        <th><strong>Periodo</strong></th>
                        <th><strong>N&deg; de Documento</strong></th>
                        <th><strong>Nombres y Apellidos</strong></th>
						<?php foreach ($DatosDetalle["materias4"] as $asignatura) { ?>
						<th><strong><?php echo $asignatura["nombreasignaturaestado"]; ?></strong></th>
						<?php } ?>                        
                        <th><strong>Puntaje Global</strong></th>
                    </tr>
                </thead>
                <tbody>
                <?PHP 
                $i=0;
                foreach($DatosDetalle['resultados'][0] as $resultadoAntiguo){
                    /*****************************************/
					//var_dump($resultadoAntiguo); echo "<br/><br/>";
                  ?>
                    <tr>
                        <td style="text-align: center;"><?PHP echo $i+1;$i++;?></td>
                        <td style="text-align: center;"><?PHP echo $Periodo;?></td><!--Periodo-->
                        <td style="text-align: center;"><?PHP echo $resultadoAntiguo['numerodocumento'];?></td><!--Num Documetno-->
                        <td ><?PHP echo $resultadoAntiguo['nombre'];?></td><!--Nombres y Apellidos-->
						<?php foreach ($DatosDetalle["materias4"] as $asignatura) { ?>
                                                <td style="text-align: center;"><?PHP  if (isset($resultadoAntiguo['asignaturas'][$asignatura["idasignaturaestado"]])){echo $resultadoAntiguo['asignaturas'][$asignatura["idasignaturaestado"]];}?></td>
						<?php } ?>
                        <td style="text-align: center;"><?PHP echo $resultadoAntiguo['PuntajeGlobal'];?></td>
                    </tr>
                    <?PHP
                    /*****************************************/
                }//for
                ?>
                </tbody>
            </table>
        </div>
		</div>
		</body>
		</html>
        <?PHP
    }//public function ViewDetalleReport
    public function EntrevistasReport(){
        global $db,$CodigoCarreraUser;
        ?>
        <div id="container">
            <fieldset>
                <legend>Entrevistas Realizadas</legend>
                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center"  style="width: 100%;" >
                    <thead>
                        <tr>
                            <th><strong>Programa acad&eacute;mico</strong></th>
                            <th><?PHP $this->ProgramasAcademicos($CodigoCarreraUser);?></th>
                            <th>&nbsp;</th>
                            <th><strong>Periodo</strong></th>
                            <th><?PHP $this->Periodos();?></th>
                        </tr>
                        <tr>
                            <th colspan="5">&nbsp;</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;" colspan="5">
                                <input type="button" id="Buscar" name="Buscar" value="Buscar." onclick="BuscarData('Entrevistas','Div_Entrevista')" />
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5">
                                <div id="Div_Entrevista" style="width: 100%;"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </div>  
        <?PHP
    }//public function EntrevistasReport
    public function ViewEntrevista($Carrera_id,$CodigoPeriodo=''){
        global $db;
        
        $Datos = $this->QueryEntrevistas($Carrera_id,$CodigoPeriodo);
        
        
        
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
                        <th><strong>Periodo</strong></th>
                        <th><strong>N&deg; de Inscritos</strong></th>
                        <th><strong>N&deg; de Entrevistas</strong></th>
                        <th><strong>Promedio %</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?PHP 
                    for($i=0;$i<count($Datos);$i++){
                        $arrayP = str_split($Datos[$i]['Periodo'], strlen($Datos[$i]['Periodo'])-1);
        
                        $Periodo = $arrayP[0].'-'.$arrayP[1];
                        
                        ?>
                        <tr>    
                            <td style="text-align: center;"><?PHP echo $i+1;?></td><!--Periodo-->
                            <td style="text-align: center;"><?PHP echo $Periodo;?></td><!--Periodo-->
                            <td style="text-align: center;"><?PHP echo $Datos[$i]['Num_Estudiantes'];?></td><!--Num Inscritos-->
                            <td style="text-align: center;"><?PHP echo $Datos[$i]['Num_Entrevistas'];?></td><!--Entrevistas-->
                            <td style="text-align: center;"><?PHP echo $Datos[$i]['Promedio'];?> %</td><!--Promedio-->
                        </tr>
                        <?PHP
                    }//for
                    ?>
                </tbody>
            </table>
        </div>
        <?PHP
        
    }//public function ViewEntrevista
    public function QueryEntrevistas($CodigoCarrera,$CodigoPeriodo=''){
        global $db;
        
        if($CodigoPeriodo==-1 || $CodigoPeriodo=='-1'){
            $Condicion    = '';
            $Condicion_2  = '';
        }else{
            $Condicion    = ' AND  cab.codigoperiodo="'.$CodigoPeriodo.'"';
            $Condicion_2  = ' AND ee.codigoperiodo ="'.$CodigoPeriodo.'" ';
        }
        
          $SQL_Num='SELECT

                    x.nombrecarrera as Nombre,
                    COUNT(x.nombrecarrera) as num,
                    x.codigoperiodo
                    
                    
                    FROM
                    (SELECT 
                    
                    c.codigocarrera,
                    c.nombrecarrera,
                    cab.codigoperiodo
                    
                    
                    FROM 
                    
                    obs_admitidos_cab_entrevista cab INNER JOIN  obs_admitidos_entrevista ae ON cab.idobs_admitidos_cab_entrevista=ae.idobs_admitidos_cab_entrevista 
													 INNER JOIN  estudiante e ON cab.codigoestudiante=e.codigoestudiante
													 INNER JOIN  carrera c ON e.codigocarrera=c.codigocarrera
                    
                    WHERE
                    
                    cab.codigoestado=100
                    AND
                    ae.codigoestado=100
                    AND
                    c.codigocarrera="'.$CodigoCarrera.'"
                    '.$Condicion.'
                                        
                    GROUP BY cab.idobs_admitidos_cab_entrevista ) x GROUP BY x.codigocarrera  ORDER BY x.codigoperiodo DESC';
                    
             if($Num_Entrevistas=&$db->Execute($SQL_Num)===false){
                echo 'Error en el SQL de los Numero de Enttrevistas...<br><br>'.$SQL_Num;
                die;
             }     
             
        $D_Entrevistas  = $Num_Entrevistas->GetArray();
        
        $SQL_NumEstud = 'SELECT 

                        x.nombrecarrera as Nombre,
                        COUNT(x.nombrecarrera) as num,
                        x.codigoperiodo
                        
                        FROM(
                        
                        SELECT 

                        ee.codigoestudiante, 
                        ee.codigoperiodo, 
                        ee.codigoprocesovidaestudiante, 
                        e.codigocarrera, 
                        ee.estudianteestadisticafechafinal,
                        eg.nombresestudiantegeneral, 
                        eg.apellidosestudiantegeneral, 
                        eg.numerodocumento, 
                        c.nombrecarrera, 
                        m.nombremodalidadacademica, 
                        fa.nombrefacultad 
                        
                        FROM 
                        
                        estudianteestadistica ee INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante 
												 INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral 
												 INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
												 INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
												 INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100) 

                        WHERE
                        ee.codigoprocesovidaestudiante= 200 
                        AND 
                        e.codigocarrera="'.$CodigoCarrera.'"
                        '.$Condicion_2.'
                        AND 
                        c.codigomodalidadacademicasic=200 
                        AND 
                        ee.codigoprocesovidaestudiante= 200 
                        AND 
                        ee.codigoestado like "1%") x GROUP BY x.codigoperiodo ORDER BY x.codigoperiodo DESC '; 
                        
            if($Num_Estudiante=&$db->Execute($SQL_NumEstud)===false){
                echo 'Error en el SQl de Num Estudiantes....<br><br>'.$SQL_NumEstud;
                die;
            }       
            
         $C_Estudiantes = $Num_Estudiante->GetArray();
         
         $D_Result  = array();
         
         $num   = count($D_Entrevistas);
         $num_2 = count($C_Estudiantes);
         
         if($num==0){
            $num=1;
         }
         
         for($i=0;$i<$num;$i++){
            /******************************************/
            for($j=0;$j<$num_2;$j++){
                if($D_Entrevistas[$i]['codigoperiodo']==$C_Estudiantes[$j]['codigoperiodo']){
                    
                     $Promedio  = (($D_Entrevistas[$i]['num']/$C_Estudiantes[$j]['num'])*100); 
                    
                     $D_Result[$j]['Num_Entrevistas']   = $D_Entrevistas[$i]['num'];
                     $D_Result[$j]['Num_Estudiantes']   = $C_Estudiantes[$j]['num'];
                     $D_Result[$j]['Promedio']          = number_format($Promedio,'2','.','.');
                     $D_Result[$j]['Periodo']           = $C_Estudiantes[$j]['codigoperiodo'];
                    
                }else{
                    $num_3  = count($D_Result);
                    
                    for($x=0;$x<=$num_3;$x++){
                        
                         $D_Result[$j]['Num_Entrevistas']   = 0;
                         $D_Result[$j]['Num_Estudiantes']   = $C_Estudiantes[$j]['num'];
                         $D_Result[$j]['Promedio']          = 0;
                         $D_Result[$j]['Periodo']           = $C_Estudiantes[$j]['codigoperiodo'];
                        
                    }//for...3
                }//if
            }//for...2     
            /******************************************/
         }//for...1  
         
        //echo '<pre>';print_r($D_Result); 
            
        return $D_Result; 
                           
    }//public function QueryEntrevistas
}//class ReportesEntrevistas
?>