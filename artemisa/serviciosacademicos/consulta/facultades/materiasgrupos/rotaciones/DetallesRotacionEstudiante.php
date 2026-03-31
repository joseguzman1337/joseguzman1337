<?php
session_start();
include_once (realpath(dirname(__FILE__)).'/../../../../EspacioFisico/templates/template.php');

$db = getBD();
$sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
$datosusuario = $db->GetRow($sqlS);
$user = $datosusuario['idusuario'];

$modalidad = "select c.codigomodalidadacademica from carrera c where c.codigocarrera = '".$_SESSION['codigofacultad']."'";
$tipomodalidad = $db->GetRow($modalidad);

function limpiarCadena($cadena) {
    $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑ\s]', '', $cadena));
    return $cadena;
}

//echo $_POST['detalle'];
if(!empty($_POST['detalle']))
{
    $Idrotacion = $_REQUEST['detalle'];    
   
       $sql1="SELECT
            	M.nombremateria,
            	eg.nombrecortoestudiantegeneral,
            	eg.nombresestudiantegeneral,
            	eg.apellidosestudiantegeneral,
            	c.NombreConvenio,
                c.ConvenioId,
            	r.RotacionEstudianteId,
            	e.codigoestudiante,
            	r.codigomateria,
            	r.idsiq_convenio,
            	r.IdUbicacionInstitucion,
                r.IdInstitucion,
            	r.FechaIngreso,
            	r.FechaEgreso,
            	r.codigoestado,
            	r.codigoperiodo,
            	r.codigocarrera,
            	r.TotalDias,
            	r.EstadoRotacionId,
            	I.NombreInstitucion,
            	U.NombreUbicacion,
            	r.JornadaId,
                r.TotalHoras,
				r.SubGrupoId
            FROM
					RotacionEstudiantes r
				INNER JOIN estudiante e ON (
					e.codigoestudiante = r.codigoestudiante
				)
				INNER JOIN estudiantegeneral eg ON (
					eg.idestudiantegeneral = e.idestudiantegeneral
				)
				INNER JOIN Convenios c ON (
					c.ConvenioId = r.idsiq_convenio
				)
				INNER JOIN InstitucionConvenios I ON (
					I.InstitucionConvenioId = r.IdInstitucion
				)
				INNER JOIN materia M ON (
					M.codigomateria = r.codigomateria
				)
				INNER JOIN UbicacionInstituciones U ON (
					U.IdUbicacionInstitucion=r.IdUbicacionInstitucion
				)
			WHERE     r.RotacionEstudianteId = '".$Idrotacion."' 
			LIMIT 1;";  
    $datos1 = $db->GetRow($sql1);
   // echo '<pre>'; print_r($datos1); die;       
    $nombre						 = $datos1['nombresestudiantegeneral'];
	$apellido				     = $datos1['apellidosestudiantegeneral'];
    $RotacionEstudianteId        = $datos1['RotacionEstudianteId'];
    $codigoestudiante            = $datos1['codigoestudiante']; 
    $codigomateria               = $datos1['codigomateria'];
    $nombreconvenio              = $datos1['NombreConvenio'];
    $ConvenioId                  = $datos1['ConvenioId'];
    $IdUbicacionInstitucion      = $datos1['IdUbicacionInstitucion'];
    $IdInstitucion               = $datos1['IdInstitucion'];
	$nombreInstitucion			 = $datos1['NombreInstitucion'];
	$nombreUbicacion			 = $datos1['NombreUbicacion'];
    $FechaIngreso                = $datos1['FechaIngreso'];
    $FechaEgreso                 = $datos1['FechaEgreso'];
    $codigoestado                = $datos1['codigoestado'];
    $codigoperiodo               = $datos1['codigoperiodo'];
    $carrera                     = $datos1['codigocarrera'];
    $TotalDias                   = $datos1['TotalDias'];
    $EstadoRotacionId            = $datos1['EstadoRotacionId'];
	$periodo            		 = $datos1['codigoperiodo'];
	$idConvenio            		 = $datos1['idsiq_convenio'];
	$nombremateria               = $datos1['nombremateria'];
	$jornadaID            		 = $datos1['JornadaId'];
    $TotalHoras            		 = $datos1['TotalHoras'];     
    $SubGrupoId					 = $datos1['SubGrupoId'];

    if($IdUbicacionInstitucion == '0' || $IdInstitucion == '0')
    {        
        $sqlconvenio = "select c.InstitucionConvenioId from Convenios c where c.ConvenioId ='".$ConvenioId."';";
        $institucion = $db->GetRow($sqlconvenio);
        $IdInstitucion = $institucion['InstitucionConvenioId']; 
    }


    $sqldetallerotacion = "select DetalleRotacionId, codigodia, codigoestado, NombreDocenteCargo, EmailDocente, TelefonoDocente from DetalleRotaciones where RotacionEstudianteId = '".$RotacionEstudianteId."'";
    $datosdetallerotacion = $db->GetAll($sqldetallerotacion);
    $y=1;
    foreach($datosdetallerotacion as $valoresdetallerotacion)
    {
        $diasvalores[$y] = array($valoresdetallerotacion['DetalleRotacionId'], $valoresdetallerotacion['codigodia'], $valoresdetallerotacion['codigoestado'], $valoresdetallerotacion['NombreDocenteCargo'], $valoresdetallerotacion['EmailDocente'], $valoresdetallerotacion['TelefonoDocente']);
        $y++;
    }    
    switch($tipomodalidad['codigomodalidadacademica'])
    {
        case '300':{
            $buscar = "select m.nombremateria, m.codigomateria 
            from 
            planestudioestudiante pl 
            INNER JOIN planestudio pe on pe.idplanestudio = pl.idplanestudio
            INNER JOIN materia m ON m.codigocarrera = pe.codigocarrera and m.TipoRotacionId <> '1'
             where pl.codigoestudiante = '".$codigoestudiante."'
            AND 
            pl.codigoestadoplanestudioestudiante LIKE '1%';";
        }break;
        case '200':{
            $buscar = "SELECT eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral,pl.idplanestudio,d.codigomateria,c.nombrecarrera,  m.nombremateria, p.semestreprematricula,m.numerocreditos,do.nombredocente,do.apellidodocente,d.codigomateriaelectiva, eg.numerodocumento, per.nombreperiodo 
            FROM 
            estudiante e,prematricula p,detalleprematricula d,planestudioestudiante pl,carrera c,materia m,grupo g,docente do, estudiantegeneral eg, periodo per
             where p.codigoestudiante = e.codigoestudiante
             and p.idprematricula = d.idprematricula    
             and d.idgrupo = g.idgrupo
             and do.numerodocumento = g.numerodocumento         
             and pl.codigoestudiante = p.codigoestudiante
             and c.codigocarrera = e.codigocarrera
             and m.codigomateria = d.codigomateria
             AND m.TipoRotacionId <> '1' 
             and p.codigoestadoprematricula like '4%'
             and d.codigoestadodetalleprematricula like '3%'
             and pl.codigoestadoplanestudioestudiante like '1%'
             and p.codigoestudiante = '".$codigoestudiante."'
             and p.codigoperiodo = '".$codigoperiodo."'
             and eg.idestudiantegeneral = e.idestudiantegeneral
             and per.codigoperiodo = p.codigoperiodo
             order by m.nombremateria ";
        }break;
    }
}
else
{   
    if($_POST['Action_id']=='SaveData')
    {         
        $fechaingreso                = $_POST['fechaingreso'];
        $fechaegreso                 = $_POST['fechaegreso']; 
        $idrotacion                  = $_POST['idrotacion'];
        $estadorotacion              = $_POST['estadorotacion'];
        $Totaldias                   = $_POST['Totaldias'];
        $jornada                     = $_POST['jornada'];
        $TotalHoras                  = $_POST['TotalHoras'];
        $IdInstitucion               = $_POST['institucion'];
        $docenteEmail                = $_POST['docenteemail'];
        $docentecargo                = $_POST['docentecargo'];
        $Docentecel                  = $_POST['docentecel'];
        $Materia                     = $_POST['Materia'];
        $idconvenio                  = $_POST['idconvenio'];
        $Ubicacion                   = $_POST['Ubicacion'];
        $periodo                     = $_POST['periodo'];
        $Observacion                 = $_POST['Observacion'];
		$SubGrupo                    = $_POST['SubGrupoId'];
        
        $fecha = date("Y-m-d");
        $codigodia = array();
        if(isset($_POST['Semanadias1'])){$codigodia[0] = '1';}
        if(isset($_POST['Semanadias2'])){$codigodia[1] = '2';}
        if(isset($_POST['Semanadias3'])){$codigodia[2] = '3';}
        if(isset($_POST['Semanadias4'])){$codigodia[3] = '4';}
        if(isset($_POST['Semanadias5'])){$codigodia[4] = '5';}
        if(isset($_POST['Semanadias6'])){$codigodia[5] = '6';}
        if(isset($_POST['Semanadias7'])){$codigodia[6] = '7';}
        
        $idrotacion =  limpiarCadena(filter_var($idrotacion,FILTER_SANITIZE_NUMBER_INT));
        $estadorotacion =  limpiarCadena(filter_var($estadorotacion,FILTER_SANITIZE_NUMBER_INT));
        $docentecargo = limpiarCadena(filter_var($docentecargo,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $docenteEmail = filter_var($docenteEmail,FILTER_SANITIZE_EMAIL);
        $Docentecel = limpiarCadena(filter_var($Docentecel,FILTER_SANITIZE_NUMBER_INT));

		if($estadorotacion==2){
			$codigoestado=200;
		} else {
			$codigoestado=100;
		}
        $Totaldias =  limpiarCadena(filter_var($Totaldias,FILTER_SANITIZE_NUMBER_INT));
        $jornada =  limpiarCadena(filter_var($jornada,FILTER_SANITIZE_NUMBER_INT));
        $TotalHoras =  limpiarCadena(filter_var($TotalHoras,FILTER_SANITIZE_NUMBER_INT));
        
        //si la fecha fue modificada se reorganiza para poderse guardar
        $fech = explode("-",$fechaegreso);
        $numero = strlen($fech[2]);
        if($numero == '4')
        {
            $fechaegreso= $fech[2].'-'.$fech[1].'-'.$fech[0];
        }    
        
        $slq3="UPDATE RotacionEstudiantes set  FechaIngreso = '".$fechaingreso."', FechaEgreso = '".$fechaegreso."', TotalDias ='".$Totaldias."', EstadoRotacionId ='".$estadorotacion."', JornadaId='".$jornada."', TotalHoras = '".$TotalHoras."', codigoestado ='".$codigoestado."', 
                IdInstitucion = '".$IdInstitucion."', IdUbicacionInstitucion = '".$Ubicacion."', FechaUltimaModificacion=NOW(), UsuarioUltimaModificacion='".$user."', codigomateria ='".$Materia."' where  RotacionEstudianteId = '".$idrotacion."';"; 
        if($Consulta=$db->Execute($slq3)===true)
        {
             $descrip = "Se genero un problema al guardar, por favor verifique los datos.";
        }else
        {
            //log auditoria
            $sqllog_anterior = "SELECT FechaIngreso_new, FechaEgreso_new, jornada_new, codigoperiodo_new, TotalDias_new, SubGrupoId_new, TotalHoras_new from LogRotacionEstudiantes where RotacionEstudianteId ='".$idrotacion."' ORDER BY FechaActividad desc";
            $datos_old = $db->GetRow($sqllog_anterior);


            $sqllog = "INSERT INTO LogRotacionEstudiantes(RotacionEstudianteId, FechaIngreso_old, FechaEgreso_old, jornada_old, codigoperiodo_old, TotalDias_old, SubGrupoId_old, TotalHoras_old, FechaIngreso_new, FechaEgreso_new, jornada_new, codigoperiodo_new, TotalDias_new, SubGrupoId_new, TotalHoras_new, UsuarioActividad, FechaActividad, TipoActividad, Observacion) values ('".$idrotacion."', '".$datos_old['FechaIngreso_new']."', '".$datos_old['FechaEgreso_new']."', '".$datos_old['jornada_new']."', '".$datos_old['codigoperiodo_new']."', '".$datos_old['TotalDias_new']."', '".$datos_old['SubGrupoId_new']."', '".$datos_old['TotalHoras_new']."', '".$fechaingreso."', '".$fechaegreso."', '".$jornada."', '".$periodo."', '".$Totaldias."', '".$SubGrupo."', '".$TotalHoras."', '".$user."', NOW(), 'Update', '".$Observacion."')";
            $db->execute($sqllog);

            $sqlvalidaespecialidad = "select EspecialidadCarreraId from RotacionEspecialidades where RotacionEstudianteId = '".$idrotacion."';";
            $rotaciones= $db->GetAll($sqlvalidaespecialidad);            
            foreach($rotaciones as $datos)
            { 
                $especialidadrotaciones[] = $datos[EspecialidadCarreraId];
            }
            $t=1;
            while($t <= 20)          
            {
                $numespe = $_POST['Especialidad'.$t];
                $listaespecilialidades[]=$numespe;
                if(in_array($numespe, $especialidadrotaciones))
                {
                    if(isset($numespe))
                    {
                        $updateespecialidad1 = "UPDATE RotacionEspecialidades SET CodigoEstado='100', FechaUltimaModificacion='".$fecha."', UsuarioUltimaModificacion='".$user."' 
                        WHERE EspecialidadCarreraId ='".$numespe."' and RotacionEstudianteId ='".$idrotacion."';";                      
                        $update1 = $db->execute($updateespecialidad1);    
                    }
                }
                else
                {
                    if(isset($numespe))
                    {
                    $especialidadrotaciones[] = $numespe;
                    $insertespecialidad = "INSERT INTO RotacionEspecialidades (RotacionEstudianteId, EspecialidadCarreraId, UsuarioCreacion, FechaCreacion, FechaUltimaModificacion, UsuarioUltimaModificacion, CodigoEstado)
                     values ('".$idrotacion."', '".$numespe."', '".$user."', NOW(), NOW(), '".$user."', '100');";                                          
                    $insert = $db->execute($insertespecialidad);
                    }
                }
                $t++;                
            }
            $faltantes = array_diff($especialidadrotaciones, $listaespecilialidades);
            foreach($faltantes as $deactivar)
            {
               $updateespecialidad = "UPDATE RotacionEspecialidades SET CodigoEstado = '200', FechaUltimaModificacion = '".$fecha."', UsuarioUltimaModificacion = '".$user."' WHERE RotacionEstudianteId = '".$idrotacion."' and EspecialidadCarreraId = '".$deactivar."';"; 
               $update = $db->execute($updateespecialidad);
            }
            
            foreach($codigodia as $numerodia)
            {
                $conteodias = array('1', '2', '3', '4', '5', '6', '7');
                $numerodias[] = $numerodia;
                $sqldetallerotacionvalida = "select DetalleRotacionId, codigoestado, codigodia from DetalleRotaciones where RotacionEstudianteId='".$idrotacion."' and codigodia = '".$numerodia."'";
                $valordetalle = $db->GetRow($sqldetallerotacionvalida);
                if($valordetalle['DetalleRotacionId']!= null)
                {                    
                   $updateDetallerotacion = "UPDATE DetalleRotaciones SET codigoestado = '100', FechaModificacion=NOW(), UsuarioModificacion='".$user."', NombreDocenteCargo = '".$docentecargo."', EmailDocente='". $docenteEmail."', TelefonoDocente ='".$Docentecel."' 
                   WHERE (DetalleRotacionId = '".$valordetalle['DetalleRotacionId']."' and codigodia= '".$numerodia."')";                   
                   $Consultadetalle=$db->execute($updateDetallerotacion); 
                }else
                {
                     $insertDetallerotacion = "INSERT INTO DetalleRotaciones (RotacionEstudianteId, codigodia, codigoestado, FechaCreacion, UsuarioCreacion, NombreDocenteCargo, EmailDocente, TelefonoDocente) 
                     VALUES ('".$idrotacion."', '".$numerodia."', '100', NOW(), '".$user."', '".$docentecargo."', '".$docenteEmail."', '".$Docentecel."');";
                     $Consultadetalle=$db->execute($insertDetallerotacion); 
                }      
            }
            $diferencia = array_diff($conteodias, $numerodias);
            foreach($diferencia as $negativos)
            {
                 $sqldetallerotacionvalida = "select DetalleRotacionId, codigoestado, codigodia from DetalleRotaciones where RotacionEstudianteId='".$idrotacion."' and codigodia = '".$negativos."'";
                $valordetalle = $db->GetRow($sqldetallerotacionvalida);
                 if($valordetalle['DetalleRotacionId']!= null)
                {
                    $updateDetallerotacion = "UPDATE DetalleRotaciones SET codigoestado = '200', FechaModificacion=NOW(), UsuarioModificacion='".$user."', NombreDocenteCargo = '".$docentecargo."', EmailDocente='". $docenteEmail."', TelefonoDocente ='".$Docentecel."'  
                    WHERE (DetalleRotacionId = '".$valordetalle['DetalleRotacionId']."' and codigodia= '".$negativos."')";
                    $Consultadetalle=$db->execute($updateDetallerotacion);     
                }
            }
            $descrip = "La rotacion fue actualizada."; 
           //$descrip = $slq3;
        }
        $a_vectt['val']			=true;
        $a_vectt['descrip']		=$descrip;
        echo json_encode($a_vectt);
        exit;
    }//if($_POST['Action_id']=='SaveData')
    
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
        <title>Detalle Rotación Estudiante</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       <link rel="stylesheet" href="../../../../mgi/css/cssreset-min.css" type="text/css" /> 
        <link rel="stylesheet" href="../../../../css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="../../../../css/demo_table_jui.css" type="text/css" />
         <link rel="stylesheet" href="../../../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../../../../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../../../../mgi/css/styleDatos.css" type="text/css" /> 
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.fastLiveFilter.js"></script>   
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/functionsMonitoreo.js"></script> 
        <script type="text/javascript" language="javascript" src="js/funcionesRotaciones.js"></script>
       <script type="text/javascript" language="javascript">
        /****************************************************************/
        	$(document).ready( function () {
				var selectPerido="<?php echo $codigoperiodo; ?>";
				$('#periodo > option[value="'+selectPerido+'"]').attr('selected', 'selected');
        		$("#fechaingreso").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../../../../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
                $("#fechaegreso").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../../../../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
               $('#ui-datepicker-div').css('display','none');
				
				$("#fechaegreso").change(function()
				{
					var fechaInicial = $('#fechaingreso').val();
					var fechaFinal = $('#fechaegreso').val();
				    
                    var fecha = fechaInicial.split("-");
                    if(fecha['0'].length == '4')
                    {
                        fechaInicial = fecha['2']+"-"+fecha['1']+"-"+fecha['0'];  
                        var update ='1';      
                    }
					if(!validate_fechaMayorQue(fechaInicial,fechaFinal))
					{
						alert("La fecha de Egreso no debe ser infrerior a la fecha Ingreso");
						$('#Totaldias').html('');
                        $('#fechaegreso').val('');
						return false;
					}
                    
                    
                    
					$.ajax({//Ajax
						 type: 'POST',
						 url: '../rotaciones/classSolicitudRotacion.php',
						 async: false,
						 dataType: 'json',
						 data:{Action_id:'calcularfechas',fechaingreso: fechaInicial,fechaegreso:fechaFinal},
						 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						 success: function(data)
						{
							var html = "<input id='Totaldias' name='Totaldias' size='10' value='"+data+"' onkeypress='return val_numero(event)' required />" 
							$('#Totaldiasdetalle').html(html);
                            $("#Semanadias1").prop("checked", "checked");
                            $("#Semanadias2").prop("checked", "checked");
                            $("#Semanadias3").prop("checked", "checked");
                            $("#Semanadias4").prop("checked", "checked");
                            $("#Semanadias5").prop("checked", "checked");
                            $('#fechaegreso').val(fechaFinal);
                            if(update == '1')
                            {
                                CalcularHoras();
                            }
						}//data
					});// AJAX
				});
			} );
		function validate_fechaMayorQue(fechaInicial,fechaFinal)
        {
            valuesStart=fechaInicial.split("-");
            valuesEnd=fechaFinal.split("-");
            // Verificamos que la fecha no sea posterior a la actual
		    var dateStart=new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
		    var dateEnd=new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
            if(dateStart>=dateEnd)
            {
                return 0;
            }
            return 1;
        }
        	/**************************************************************/
        </script>
        <script>
        function val_texto(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[a-zA-ZñÑ\s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        function val_numero(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron =/[0-9]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script> 
        <script>
        function val_email(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[0-9a-zA-Z\-\.\@\s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script>
        <script type="text/javascript" language="javascript">
         function CambioDiasSemana()       
        {
            var estado1 = $("#Semanadias1").prop("checked");
            var estado2 = $("#Semanadias2").prop("checked");
            var estado3 = $("#Semanadias3").prop("checked");
            var estado4 = $("#Semanadias4").prop("checked");
            var estado5 = $("#Semanadias5").prop("checked");
            var estado6 = $("#Semanadias6").prop("checked");
            var estado7 = $("#Semanadias7").prop("checked");
            var dia = [estado1, estado2, estado3, estado4, estado5, estado6, estado7];
           
           	var fechaInicial = $('#fechaingreso').val();
			var fechaFinal = $('#fechaegreso').val();
            
            $.ajax({//Ajax
				 type: 'POST',
				 url: '../rotaciones/classSolicitudRotacion.php',
				 async: false,
				 dataType: 'json',
				 data:{Action_id:'calculardias',fechaingreso:fechaInicial,fechaegreso:fechaFinal,dias:dia},
				 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				 success: function(data)
				{				   
					var html = "<input id='Totaldias' name='Totaldias' value='"+data+"' />" 
					$('#Totaldiasdetalle').html(html);                    
				}//data
			});// AJAX
        }
        
        </script>
        <body onload="CalcularHoras()">
        <div id="container">
        <center>
            <h1>DETALLES ROTACIÓN ESTUDIANTE</h1>
        </center>
        <form  id="detallerotacionestudiante" action="../rotaciones/NuevaRotacionEstudiante.php" method="post" enctype="multipart/form-data" >
        <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
        <input type="hidden" id="idrotacion" name="idrotacion" value="<?php echo $RotacionEstudianteId?>" />
		<input type="hidden" id="SubGrupoId" name="SubGrupoId" value="<?php echo $SubGrupoId;?>" />
        <input type="hidden" id="carrera" name="carrera" value="<?php echo $carrera?>" />
            <table align="center" border="1"  width="70%">
                <tr>
                    <td>
                        Nombre:<span style="color: red;">*</span>
                    </td>
                    <td>
                        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre." ".$apellido ?>" size="50" disabled required />
                    </td>
                </tr>
                <tr>
                    <td>
                        Ingreso:<span style="color: red;">*</span>
                    </td>
                    <td>
                        <input type="text" id="fechaingreso" name="fechaingreso" class="requerido" value="<?php echo $FechaIngreso?>" required />
                    </td>
                    <td>
                        Egreso:<span style="color: red;">*</span>
                    </td>
                    <td>
                        <input type="text" id="fechaegreso" name="fechaegreso" class="requerido" value="<?php echo $FechaEgreso?>" required />
                    </td>
                    
                </tr>
                <tr>
					<td>Convenio:<span style="color: red;">*</span></td>
					<td colspan="3">
                        <input size="95" type="text" name="convenio" id="convenio" value="<?php echo $nombreconvenio?>" readonly="true"/>						
                        <input type="hidden" name="idconvenio" id="idconvenio" value="<?php echo $idConvenio?>" readonly="true"/>
					</td>
                </tr>
                <tr>    
                	<td>Lugar de rotación:<span style="color: red;">*</span></td>
                    <td colspan="3">
                        <input type="hidden" id="institucion" name="institucion" value="<?php echo $IdInstitucion;?>" >
                        <select id="Ubicacion" name="Ubicacion" required>                            
                            <?php
                            $lugarroatcion = "select IdUbicacionInstitucion, NombreUbicacion from UbicacionInstituciones where InstitucionConvenioId = '".$IdInstitucion."'";
                            $listaubicaicon = $db->GetAll($lugarroatcion);
                            $nvalidar = count($listaubicaicon);
                            if($nvalidar == 0)
                            {
                                $lugarroatcion = "select IdUbicacionInstitucion, NombreUbicacion from UbicacionInstituciones where InstitucionConvenioId = '".$IdUbicacionInstitucion."'";
                                $listaubicaicon = $db->GetAll($lugarroatcion);
                            }
                            foreach($listaubicaicon as $ubicaciones)
                            {
                                if($ubicaciones['IdUbicacionInstitucion'] ==  $IdUbicacionInstitucion)
                                {
                                    ?>
                                    <option value="<?php echo $ubicaciones['IdUbicacionInstitucion'];?>" selected='selected'><?php echo $ubicaciones['NombreUbicacion'];?></option>    
                                    <?php
                                }else
                                {
                                    ?>
                                    <option value="<?php echo $ubicaciones['IdUbicacionInstitucion'];?>"><?php echo $ubicaciones['NombreUbicacion'];?></option>    
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>                            
                </tr>
                <tr>   
                    <td>Periodo:<span style="color: red;">*</span></td>
                    <td>
                        <input type="text" id="periodo" name="periodo" value="<?php echo $codigoperiodo; ?>" readonly="true" required/>
                    </td>
				    <td>Materia:<span style="color: red;">*</span></td>
				    <td>
                        <select id="Materia" name="Materia" required>
                        <?php 
                            $materias = $db->GetAll($buscar);
                            foreach($materias as $listas)
                            {                                
                                if($codigomateria == $listas['codigomateria'])
                                {
                                    ?>
                                    <option value="<?php echo $listas['codigomateria'];?>" selected="selected"><?php echo $listas['nombremateria'];?></option>
                                    <?php
                                }else
                                {
                                    ?>
                                    <option value="<?php echo $listas['codigomateria'];?>"><?php echo $listas['nombremateria'];?></option>
                                    <?php
                                }
                            }
                        ?>
                        </select>
				    </td>
                </tr>
                <tr>
                    <td>Dias opcionales</td>
                    <td>
                        <?php 
                            foreach($diasvalores as $codigodias)
                            {
                                switch($codigodias['1'])
                                {
                                    case '1':
                                    {
                                        if($codigodias[2]== '100')
                                        {
                                            $check1 = 'checked="checked"';     
                                        }
                                    }break;
                                    case '2':
                                    {
                                        if($codigodias[2]== '100')
                                        {
                                            $check2 = 'checked="checked"';     
                                        }
                                    }break;
                                    case '3':
                                    {
                                        if($codigodias[2]== '100')
                                        {
                                            $check3 = 'checked="checked"';     
                                        }
                                    }break;
                                    case '4':
                                    {
                                        if($codigodias[2]== '100')
                                        {
                                            $check4 = 'checked="checked"';     
                                        }
                                    }break;
                                    case '5':
                                    {
                                        if($codigodias[2]== '100')
                                        {
                                            $check5 = 'checked="checked"';     
                                        }
                                    }break;
                                    case '6':
                                    {
                                        if($codigodias[2]== '100')
                                        {
                                            $check6 = 'checked="checked"';     
                                        }
                                    }break;
                                    case '7':
                                    {
                                        if($codigodias[2]== '100')
                                        {
                                            $check7 = 'checked="checked"';     
                                        }
                                    }break;
                                }
                                $Docentecargo = $codigodias[3];
                                $Docenteemial = $codigodias[4];
                                $Docentecel = $codigodias[5];  
                            }
                        ?>
                        <form id="diasemana" name="diasemana">
                        <input type="checkbox" name="Semanadias1" id="Semanadias1" value="1" <?php echo $check1; ?> /> Lunes<br />
                        <input type="checkbox" name="Semanadias2" id="Semanadias2" value="2" <?php echo $check2; ?> /> Martes<br />
                        <input type="checkbox" name="Semanadias3" id="Semanadias3" value="3" <?php echo $check3; ?> /> Miercoles<br />
                        <input type="checkbox" name="Semanadias4" id="Semanadias4" value="4" <?php echo $check4; ?> /> Jueves<br />
                        <input type="checkbox" name="Semanadias5" id="Semanadias5" value="5" <?php echo $check5; ?> /> Viernes<br />
                        <input type="checkbox" name="Semanadias6" id="Semanadias6" value="6" <?php echo $check6; ?> /> Sabado<br />
                        <input type="checkbox" name="Semanadias7" id="Semanadias7" value="7" <?php echo $check7; ?> /> Domingo<br />
                        <input type="button" name="calculardias" id="calculardias" onclick="CambioDiasSemana('#diasemana')" value="Calcular"/>
                    </form>  
                    </td>
                     <td>Dias:<span style="color: red;">*</span>
                    </td>
                    <td>                        
                        <div id="Totaldiasdetalle">
                            <input type="text" name="Totaldias" id="Totaldias" size="10" value="<?php echo (int)$TotalDias ?>" onkeypress="return val_numero(event)" required/>
                        </div>
                    </td>
                    </tr>
				<tr>
                    <td>
                        Estado:<span style="color: red;">*</span>
                    </td>
                    <td>
                        <select id="estadorotacion" name="estadorotacion" required />
                            <?php
                            switch($EstadoRotacionId){
                                case 1:
                                    ?>
                                     <option value="1" selected="selected">Activo</option>
                                     <option value="2">Inactivo</option>
                                     <option value="3">Bloqueado</option>
                                    <?php
                                break;
                                case 2:
                                    ?>
                                     <option value="2" selected="selected">Inactivo</option>
                                     <option value="1">Activo</option>
                                     <option value="3">Bloqueado</option>
                                    <?php
                                break;
                                case 3:
                                    ?>
                                     <option value="3" selected="selected">Bloqueado</option>
                                     <option value="1">Activo</option>
                                     <option value="2">Inactivo</option>
                                    <?php
                                break;
                            }
                            ?>
                        </select>
                    </td>
					<td>Especialidad:</td>
						<td>						
							<?php
                            $sqlespecialidadescarrera = "select EspecialidadCarreraId, Especialidad from EspecialidadCarrera where codigocarrera ='".$carrera."' and CodigoEstado='100'";
                            $especialidadescarrera=$db->GetAll($sqlespecialidadescarrera);
                                
                            $sqlEspecialidades ="SELECT j.EspecialidadCarreraId, j.Especialidad FROM EspecialidadCarrera j inner JOIN RotacionEspecialidades re ON re.EspecialidadCarreraId = j.EspecialidadCarreraId WHERE re.CodigoEstado = '100' AND j.codigocarrera = '".$carrera."' and re.RotacionEstudianteId = '".$Idrotacion."'"; 
                            $valoresespecial=$db->GetAll($sqlEspecialidades);
                            foreach($valoresespecial as $numeroscarreras){$lista2[]=(string)(int)$numeroscarreras['EspecialidadCarreraId'];}
                            //echo '<pre>';print_r($lista2);
                            $t=1;             
							foreach($especialidadescarrera as $datosespeciales)
							{
							     $numeroespecialidadcarrera = (string)(int)$datosespeciales['EspecialidadCarreraId'];                                
                                if(in_array($numeroespecialidadcarrera, $lista2))
                                {
                                    ?>
                                    <input type="checkbox" value="<?php echo $numeroespecialidadcarrera;?>" name="Especialidad<?php echo $t;?>" id="Especialidad<?php echo $t;?>" checked="checked"><?php echo $datosespeciales['Especialidad']?><br />	
                                    <?php
                                }else
                                {
                                     ?>
                                    <input type="checkbox" value="<?php echo $numeroespecialidadcarrera;?>" name="Especialidad<?php echo $t;?>" id="Especialidad<?php echo $t;?>" ><?php echo $datosespeciales['Especialidad']?><br />	
                                    <?php
                                }
                                $t++;
                            } ?>
						</td>
                </tr>
                <tr>
					<td>Jornada:<span style="color: red;">*</span></td>
                    <td >
                        <select id="jornada" name="jornada"  onchange="CalcularHoras()" required>
                            <?php
                            $sqlInstitu ="SELECT JornadaRotacionesId, Jornada  FROM JornadaRotaciones j WHERE j.CodigoEstado=100 order by Jornada ";  
                            $valoresInstitu=$db->execute($sqlInstitu);
                            foreach($valoresInstitu as $datosInstitu)
							{
                                ?>
                                <option value="<?php echo $datosInstitu['JornadaRotacionesId']?>" 
                                <?php if($jornadaID==$datosInstitu['JornadaRotacionesId'])
                                {
                                    echo "selected";
                                } ?> 
                                >
								<?php echo $datosInstitu['Jornada'] ?></option><?php
                            }
                         ?>
						 </select>
                         <input type="text" id="horario" name="horario" readonly="true" />
                    </td>
                    <td>Total Horas<span style="color: red;">*</span></td>
                    <td>
                        <input id='TotalHoras' name='TotalHoras' value='<?php echo $TotalHoras; ?>'  size="5" maxlength="5"  onkeypress="return val_numero(event)" required />
                    </td>
                </tr>
                <tr>
                    <td>Docente a Cargo o Coordinador:</td>
                    <td>
                        <input type="text" name="docentecargo" id="docentecargo" value="<?php echo $Docentecargo; ?>" onkeypress="return val_texto(event)" />
                    </td>
                </tr>
                <tr>
                    <td>Email Docente:</td>
                    <td>
                        <input type="text" name="docenteemail" id="docenteemail" value="<?php echo $Docenteemial; ?>" onkeypress="return val_email(event)" />
                    </td>
                    <td>Telefono Cel:</td>
                    <td>
                        <input type="text" name="docentecel" id="docentecel" value="<?php echo $Docentecel; ?>"  onkeypress="return val_numero(event)" />
                    </td>
                </tr>
                <tr>
                    <td>Observacion:<span style="color: red;">*</span></td>
                    <td colspan="3">
                        <input type="text" size="120" id="Observacion" name="Observacion"  required>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                        <table width="600">
                        <tr>
                        <td> 
                            <input type="hidden" id="codigoestudiante" name="codigoestudiante" value="<?php echo $codigoestudiante;?>" />
                            <input type="button" id="guardar" name="guardar" value="Guardar" onclick="DetalleValidaRotacionEstudiante('#detallerotacionestudiante')" />
                        </td>
                        <td style="aling: right;">
                            <input type="button" id="regresar" name="regresar" value="Regresar" onclick="RegresarNuevaRotacion()" />
                        </td>
                        </tr>
                        </table>
                        </center>
                    </td>
                </tr>
            </table>
            </form>
            </div>	 
        </body>
      </html>