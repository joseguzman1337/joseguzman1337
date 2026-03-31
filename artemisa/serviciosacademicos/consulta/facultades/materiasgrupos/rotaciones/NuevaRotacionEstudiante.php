<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php');
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once (realpath(dirname(__FILE__)).'/../../../../EspacioFisico/templates/template.php');
    $db = getBD();

    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $usuario = $db->GetRow($sqlS);
    $user = $usuario['idusuario'];
    $codigoestudiante = $_REQUEST['codigoestudiante'];

    $Sqlperiodo ="select codigoperiodo from periodo where codigoestadoperiodo = '1'";
    $valorperiodo = $db->execute($Sqlperiodo);

    foreach($valorperiodo as $datosperiodo)
    {
        $codigoperiodo = $datosperiodo['codigoperiodo'];
    }

    $modalidad = "select c.codigomodalidadacademica from carrera c where c.codigocarrera = '".$_SESSION['codigofacultad']."'";
    $tipomodalidad = $db->GetRow($modalidad);

    function limpiarCadena($cadena)
    {
        $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑ\s]', '', $cadena));
        return $cadena;
    }

    switch($_REQUEST['Action_id'])
    {
        case 'Ubicaciones':{
            $idconvenio= $_REQUEST['convenio'];
            Ubicaciones($db,$idconvenio);
        }break;
        case 'Servicio':{
            $materia = $_REQUEST['materia'];
            Servicio($db,$materia);
        }break;
        case 'SaveData':{
           include_once(realpath(dirname(__FILE__)).'/../subgrupos/controller/RotacionSubGrupos_class.php'); $RotacionSubGrupos =  new RotacionSubGrupos();

            $idestudiante              = $_POST['idestudiante'];
            $feIngres                  = $_POST['fechaingreso'];
            $fechaingreso              = date("Y-m-d", strtotime($feIngres));
            $feEgres                   = $_POST['fechaegreso'];
            $fechaegreso               = date("Y-m-d", strtotime($feEgres));
            $convenio                  = $_POST['convenio'];
            $institucionID             = $_POST['institucionID'];//array
            $datos                     = explode("-",$institucionID);
            $institucionID             = $datos[0];
            $Ubicacion                 = $datos[1];
            $materia                   = $_POST['materia'];
            $estadorotacion            = $_POST['estadorotacion'];
            $FechaCreacion             = date("Y-m-d");
            $usuarioCreacion           =$user;
            $codigocarrera             = $_POST['carrera'];
            $periodo                   = $_POST['periodo'];
            $dias                      = $_POST['Totaldias'];
            $jornada                   = $_POST['jornada'];
            $CodigoEstudiante          = $_POST['CodigoEstudiante'];
            $DocenteCargo              = $_POST['docentecargo'];
            $DocenteEmail              = $_POST['docenteemail'];
            $DocenteCel                = $_POST['docentecel'];
            $totalhoras                = $_POST['TotalHoras'];


            $codigodia = array();
            if(isset($_POST['Semanadias1'])){$codigodia[0] = '1';}
            if(isset($_POST['Semanadias2'])){$codigodia[1] = '2';}
            if(isset($_POST['Semanadias3'])){$codigodia[2] = '3';}
            if(isset($_POST['Semanadias4'])){$codigodia[3] = '4';}
            if(isset($_POST['Semanadias5'])){$codigodia[4] = '5';}
            if(isset($_POST['Semanadias6'])){$codigodia[5] = '6';}
            if(isset($_POST['Semanadias7'])){$codigodia[6] = '7';}


            $idestudiante = limpiarCadena(filter_var($idestudiante,FILTER_SANITIZE_NUMBER_INT));
            $convenio = limpiarCadena(filter_var($convenio,FILTER_SANITIZE_NUMBER_INT));
            $materia = limpiarCadena(filter_var($materia,FILTER_SANITIZE_NUMBER_INT));
            $estadorotacion = limpiarCadena(filter_var($estadorotacion,FILTER_SANITIZE_NUMBER_INT));
            $codigocarrera = limpiarCadena(filter_var($codigocarrera,FILTER_SANITIZE_NUMBER_INT));
            $periodo = limpiarCadena(filter_var($periodo,FILTER_SANITIZE_NUMBER_INT));
            $dias = limpiarCadena(filter_var($dias,FILTER_SANITIZE_NUMBER_INT));
            $jornada = limpiarCadena(filter_var($jornada,FILTER_SANITIZE_NUMBER_INT));
            $CodigoEstudiante = limpiarCadena(filter_var($CodigoEstudiante,FILTER_SANITIZE_NUMBER_INT));
            $DocenteCargo = limpiarCadena(filter_var($DocenteCargo,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            $DocenteEmail = filter_var($DocenteEmail,FILTER_SANITIZE_EMAIL);
            $DocenteCel = limpiarCadena(filter_var($DocenteCel,FILTER_SANITIZE_NUMBER_INT));
            $totalhoras = limpiarCadena(filter_var($totalhoras,FILTER_SANITIZE_NUMBER_INT));

            if(empty($Ubicacion))
            {
                $Ubicacion='0';
            }

            $sqlNuevarotacion = "INSERT INTO RotacionEstudiantes (codigoestudiante, codigomateria,  idsiq_convenio, IdUbicacionInstitucion,IdInstitucion, FechaIngreso, FechaEgreso, codigoestado, UsuarioCreacion, FechaCreacion,  EstadoRotacionId, codigoperiodo, codigocarrera, TotalDias, SubgrupoId, JornadaId, TotalHoras)
         VALUES ('".$CodigoEstudiante ."', '".$materia."', '".$convenio."', '".$Ubicacion."','".$institucionID."', '".$fechaingreso."', '".$fechaegreso."', '100','".$usuarioCreacion."', NOW(), '".$estadorotacion."', '".$periodo."', '".$codigocarrera."', '".$dias."','1', '".$jornada."', '".$totalhoras."');";
            $Valida = $RotacionSubGrupos->ValidarInfo($db,$CodigoEstudiante,$fechaingreso,$fechaegreso,$jornada);

            if($Valida==0)
            {
                if($Consulta=$db->execute($sqlNuevarotacion)===true)
                {
                        $a_vectt['val']         =false;
                        $a_vectt['descrip']     ='La rotacion no fue agregada..';
                        echo json_encode($a_vectt);
                        exit;
                }//if
                $RotacionEstudianteId = $db->insert_ID();

                //log auditoria
                 $sqllog = "INSERT INTO LogRotacionEstudiantes(RotacionEstudianteId, FechaIngreso_new, FechaEgreso_new, jornada_new, codigoperiodo_new, TotalDias_new, SubGrupoId_new, TotalHoras_new, UsuarioActividad, FechaActividad, TipoActividad)
                values ('".$RotacionEstudianteId."', '".$fechaingreso."', '".$fechaegreso."', '".$jornada."', '".$periodo."', '".$dias."', '1', '".$totalhoras."', '".$usuarioCreacion."', NOW(), 'Insert')";
                $db->execute($sqllog);

                for($t=1;$t<20;$t++)
                {
                    if(isset($_POST['Especialidad'.$t]))
                    {
                        $sqlespecialidades = "INSERT INTO RotacionEspecialidades (RotacionEstudianteId, EspecialidadCarreraId, UsuarioCreacion, FechaCreacion, FechaUltimaModificacion, UsuarioUltimaModificacion, CodigoEstado)
                        values ('".$RotacionEstudianteId."', '".$_POST['Especialidad'.$t]."', '".$user."', NOW(), NOW(), '".$user."', '100');";
                        $insertespecialidad = $db->execute($sqlespecialidades);
                    }//if
                }//for


                foreach($codigodia as $numerodia)
                {
                    $sqlDetallerotacion = "INSERT INTO DetalleRotaciones (RotacionEstudianteId, codigodia, codigoestado, NombreDocenteCargo, EmailDocente, TelefonoDocente, FechaCreacion, UsuarioCreacion)
                    VALUES ('".$RotacionEstudianteId."', '".$numerodia."', '100', '".$DocenteCargo."', '".$DocenteEmail."', '".$DocenteCel."',  NOW(), '".$usuarioCreacion."')";
                   //echo "slq detalle rotacion   ".$sqlDetallerotacion;
                    $Consultadetalle=$db->execute($sqlDetallerotacion);
                }//foreach
                $a_vectt['val']         =false;
                $a_vectt['descrip']     ='La rotacion no fue agregada..';
                echo json_encode($a_vectt);
                exit;
            }//if valida
            else
            {
                $a_vectt['val']         =99;
                echo json_encode($a_vectt);
                exit;
            }

            $a_vectt['val']         =true;
            echo json_encode($a_vectt);
             exit;
        }break; //SAVEDATA
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Rotación Estudiante</title>
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
                    dateFormat: "dd-mm-yy"
                });
                $("#fechaegreso").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../../../../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "dd-mm-yy"
                });
               $('#ui-datepicker-div').css('display','none');

				$("#fechaegreso").change(function()
				{
					var fechaInicial = $('#fechaingreso').val();
					var fechaFinal = $('#fechaegreso').val();

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
							var html = "<input id='Totaldias' name='Totaldias' size='8' value='"+data+"' onkeypress='return val_numero(event)' />"
							$('#Totaldias').html(html);
                            $("#Semanadias1").prop("checked", "checked");
                            $("#Semanadias2").prop("checked", "checked");
                            $("#Semanadias3").prop("checked", "checked");
                            $("#Semanadias4").prop("checked", "checked");
                            $("#Semanadias5").prop("checked", "checked");
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
					var html = "<input id='Totaldias' name='Totaldias' size='8' onkeypress='return val_numero(event)' value='"+data+"' />"
					$('#Totaldias').html(html);
				}//data
			});// AJAX
        }
        </script>
    </head>
    <body>
        <?php
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
                $buscar = "SELECT eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,pl.idplanestudio,d.codigomateria,c.nombrecarrera,  m.nombremateria, p.semestreprematricula,m.numerocreditos,do.nombredocente,do.apellidodocente,d.codigomateriaelectiva, eg.numerodocumento, per.nombreperiodo
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
        ?>
        <div id="container">
        <center>
            <h1>NUEVA ROTACIÓN ESTUDIANTE</h1>
        </center>
        <?php
            $sqlEstudiante = "SELECT
                        eg.nombresestudiantegeneral,
                        eg.apellidosestudiantegeneral,
                        ee.codigocarrera,
                        pm.semestreprematricula,
                        ee.idestudiantegeneral
                        FROM
                        estudiantegeneral eg
                        JOIN estudiante ee ON ee.idestudiantegeneral = eg.idestudiantegeneral
                        JOIN carrera c ON c.codigocarrera = ee.codigocarrera
                        JOIN prematricula pm ON pm.codigoestudiante = ee.codigoestudiante
                        WHERE
                        ee.codigoestudiante = '".$codigoestudiante."'
                        ORDER BY pm.codigoperiodo DESC ";

            $valoresesEstudiante = $db->GetRow($sqlEstudiante);
			$DatosEstudiante = $valoresesEstudiante;
			if($valoresesEstudiante!=null && count($valoresesEstudiante)>0){
                $nombre  = $DatosEstudiante['nombresestudiantegeneral']." ". $DatosEstudiante['apellidosestudiantegeneral'];
                $carrera = $DatosEstudiante['codigocarrera'];
                $semestre = $DatosEstudiante['semestreprematricula'];
                $idestudiante = $DatosEstudiante['idestudiantegeneral'];
				$codigocarrera = $DatosEstudiante['codigocarrera'];
			}else { ?>
				<script type="text/javascript">
				alert("El estudiante no se encuentra matriculado.");
				 window.history.back();
				</script>
			<?php }
       ?>
        <form  id="nuevarotacionestudiante" action="../rotaciones/NuevaRotacionEstudiante.php" method="post" enctype="multipart/form-data" >
        <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
        <input type="hidden" id="idestudiante" name="idestudiante" value="<?php echo $idestudiante?>" />
        <input type="hidden" id="CodigoEstudiante" name="CodigoEstudiante" value="<?php echo $codigoestudiante?>" />
        <input type="hidden" id="carrera" name="carrera" value="<?php echo $carrera?>" />
            <table align="center" border="1"  width="70%">
                <tr>
                    <td>
                        Nombre:
                    </td>
                    <td>
                        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre?>" size="50" readonly/>
                    </td>
                </tr>
                <tr>
                    <td>
                        Ingreso:<span style="color: red;">*</span>
                    </td>
                    <td>
                        <input type="text" id="fechaingreso" name="fechaingreso" class="requerido" size="12" style="text-align:center;" readonly placeholder="" required  />
                    </td>
                    <td>
                        Egreso:<span style="color: red;">*</span>
                    </td>
                    <td>
                        <input type="text" id="fechaegreso" name="fechaegreso" class="requerido" size="12" style="text-align:center;" readonly placeholder="" required />
                    </td>

                </tr>
                <tr>
                    <td>Convenio:<span style="color: red;">*</span></td>
					<td colspan="3">
                        <select id="convenio" name="convenio" onchange="BuscarInstituciones(this.value)" />
						<option value="0"></option>
                        <?php
                         $SQL ="SELECT c.ConvenioId as id, c.NombreConvenio as Nombre FROM Convenios c where c.idsiq_estadoconvenio = '1' ORDER BY c.NombreConvenio";
                         $listaconvenios = $db->GetAll($SQL);
                         foreach($listaconvenios as $convenios)
                         {
                            ?>
                            <option value="<?php echo $convenios['id'] ;?>"><?php echo $convenios['Nombre'] ;?></option>
                            <?php
                         }
                        ?>
                        </select>
					</td>
                </tr>
                <tr>
					<td>Lugar de rotación:<span style="color: red;">*</span></td>
                    <td colspan="3">
                    <div id="TD_LugarRotacion">
					    <select id="institucionID" name="institucionID"  >
						<option></option>
						</select>
                    </div>
                    </td>
				</tr>

                <tr>
					<td>Periodo:<span style="color: red;">*</span></td>
                    <td >
                        <select id="periodo" name="periodo"  onchange="MateriaPeriodo()">
                            <?php
							$Sqlperiodo ="select codigoperiodo from periodo ORDER BY codigoperiodo DESC";
                            $periodoData=$db->execute($Sqlperiodo);
                            foreach($periodoData as $periodo){
                                ?>
                                <option value="<?php echo $periodo['codigoperiodo']?>" <?php if($periodo['codigoestadoperiodo']==1){ echo "selected"; }?>><?php echo $periodo['codigoperiodo'] ?></option>
                                <?php
                            }
                         ?>
						 </select>
                    </td>
                    <td>
                        Materia:<span style="color: red;">*</span>
                    </td>
                    <td>
                    <?php
                        $sqlMaterias = $buscar;
                        //echo $sqlMaterias; die;
                        $valoresMaterias = $db->GetAll($sqlMaterias);
                        ?>
    					<input type="hidden" value="<?php echo $codigoestudiante?>" name="cestudiante" id="cestudiante"/>
                        <input type="hidden" name="modalidad" id="modalidad" value="<?php echo $tipomodalidad['codigomodalidadacademica']; ?>" />
                        <select id="materia" name="materia" >
                            <option value=""></option>
                           <?php
                                foreach($valoresMaterias as $datosMaterias)
                                {
                                    ?>
                                    <option value="<?php echo $datosMaterias['codigomateria']?>"><?php echo $datosMaterias['nombremateria']?></option>
                                    <?php
                                }
                              ?>
                          </select>
                    </td>
                </tr>
				<tr>
                <td>Dias opcionales</td>
                    <td>
                        <form id="diasemana" name="diasemana">
                        <input type="checkbox" name="Semanadias1" id="Semanadias1" value="1" /> Lunes<br />
                        <input type="checkbox" name="Semanadias2" id="Semanadias2" value="2" /> Martes<br />
                        <input type="checkbox" name="Semanadias3" id="Semanadias3" value="3" /> Miercoles<br />
                        <input type="checkbox" name="Semanadias4" id="Semanadias4" value="4" /> Jueves<br />
                        <input type="checkbox" name="Semanadias5" id="Semanadias5" value="5" /> Viernes<br />
                        <input type="checkbox" name="Semanadias6" id="Semanadias6" value="6" /> Sabado<br />
                        <input type="checkbox" name="Semanadias7" id="Semanadias7" value="7" /> Domingo<br />
                        <input type="button" name="calculardias" id="calculardias" onclick="CambioDiasSemana('#diasemana')" value="Calcular"/>
                    </form>
                  </td>
                    <td>Dias: <span style="color: red;">*</span>
                    </td>
                    <td>
						<div id="Totaldias" name="Totaldias">
                        </div>
                    </td>
                    </tr><tr>
					<td>Jornada: <span style="color: red;">*</span></td>
                    <td >
                        <select id="jornada" name="jornada" onchange="CalcularHoras()"  >
                            <option value=""></option>
                            <?php

                             $sqlInstitu ="SELECT JornadaRotacionesId, Jornada FROM JornadaRotaciones j WHERE j.CodigoEstado='100' order by Jornada";
                            $valoresInstitu=$db->GetAll($sqlInstitu);
                            foreach($valoresInstitu as $datosInstitu)
							{
                                ?>
                                <option value="<?php echo $datosInstitu['JornadaRotacionesId']?>"><?php echo $datosInstitu['Jornada'] ?></option>
                                <?php
                            }
                         ?>
						</select>
                        <input type="text" id="horario" name="horario" readonly="true" />
                    </td>
                        <td>Total Horas <span style="color: red;">*</span></td>
                        <td  style="width:20%;text-align: center;">
                            <input id='TotalHoras' name='TotalHoras' value=''  size="5" maxlength="5" onkeypress="return val_numero(event)" />
                        </td>
                     </tr><tr>
                   <td>
                        Estado: <span style="color: red;">*</span>
                    </td>
                    <td>
                        <select id="estadorotacion" name="estadorotacion" />
                            <!--<option value="">Seleccione:</option>-->
                            <option value="1">Activo</option>
                            <!--<option value="2">Inactivo</option>
                            <option value="3">Bloqueado</option>-->
                        </select>
                    </td>
                   <td>Especialidades <br/> o servicios:</td>
						<td>
                            <?php
                            $sqlInstitu ="SELECT j.EspecialidadCarreraId, j.Especialidad FROM EspecialidadCarrera j WHERE j.CodigoEstado = '100' AND j.codigocarrera='".$carrera."'";
                            $valoresInstitu=$db->GetAll($sqlInstitu);
                            $t=1;
                            foreach($valoresInstitu as $datosInstitu)
							{
                                ?>
                                <input type="checkbox" value="<?php echo (string)(int)$datosInstitu['EspecialidadCarreraId']?>" name="Especialidad<?php echo $t; ?>" id="Especialidad<?php echo $t; ?>"><?php echo $datosInstitu['Especialidad'] ?><br />
                                <?php
                                $t++;
                            } ?>
						</td>
                  </tr><tr>
                  <td>Docente a Cargo o Coordinador:</td>
                  <td>
                    <input type="text" name="docentecargo" id="docentecargo" onkeypress="return val_texto(event)" />
                  </td>
                    <td>Email Docente:</td>
                    <td>
                        <input type="text" name="docenteemail" id="docenteemail" onkeypress="return val_email(event)"/>
                    </td>
                    </tr><tr>
                    <td>Telefono Cel:</td>
                    <td>
                        <input type="text" name="docentecel" id="docentecel" onkeypress="return val_numero(event)" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <table width='600'>
                            <tr>
                             <td><input type="hidden" id="codigoestudiante" name="codigoestudiante" value="<?php echo $_REQUEST["codigoestudiante"];?>" />
                             <input type="button" id="guardar" name="guardar" value="Guardar" onclick="ValidaNuevaRotacionEstudiante('#nuevarotacionestudiante')" /></td>
                             <td style="aling: right;"><input type="button" id="regresar" name="regresar" value="Regresar" onclick="RegresarNuevaRotacion()" /></td>
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