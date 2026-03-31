<?php 
    require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));
    Factory::validateSession($variables);
    $usuario = Factory::getSessionVar('usuario');

    header('Content-Type: text/html; charset=UTF-8');
    session_start();

    if($db==null){
        include_once ('../EspacioFisico/templates/template.php');
        $db = getBD();
    }

    if(isset($_REQUEST["codigoPeriodo"])){
            $Periodo = $_REQUEST["codigoPeriodo"];
    }

    // OBTENER LOS ULTIMOS 5 PERIODOS DIFERENTE AL PERIODO DE INSCRIPCIONES 
    $SQL = "SELECT p.codigoperiodo, p.nombreperiodo, p.codigoestadoperiodo ".
    " FROM periodo p WHERE p.codigoestadoperiodo <> '4' ".
    " and PeriodoId is not null ".
    " ORDER BY p.codigoperiodo DESC LIMIT 6";
       
    if($Periodos=&$db->Execute($SQL)===false){    
           echo 'Error en consulta a base de datos';
           die;     
       }

$userDecano = $_SESSION['usuario'];

$nombreCarrera = $_SESSION['nombrefacultad'];


$id_Programa = $_SESSION['codigofacultad'];
	
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Planeación de Actividades Académicas</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link type="text/css" rel="stylesheet" href="tema/themes/base/jquery.ui.all.css" />
		<link type="text/css" rel="stylesheet" href="css/estiloui.css" />
		<link type="text/css" rel="stylesheet" href="css/estilo.css" />
        <!--<link type="text/css" rel="stylesheet" href="tema/paginador/css/demo_page.css" />-->
        <!--<link type="text/css" rel="stylesheet" href="tema/paginador/css/demo_table.css" />-->
        <link type="text/css" rel="stylesheet" href="tema/paginador/css/jquery.dataTables.css" />
        <script type="text/javascript" language="javascript" src="tema/paginador/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="tema/paginador/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/MainDetalleVocacion.js"></script>
        <script type="text/javascript">
        
       
        	$(function() {
				$('#tablaActividadesDocentes').dataTable({
			"sPaginationType": "full_numbers",
			"oLanguage": {
			"sLengthMenu": "Mostrando _MENU_ registros por página",
			"sInfo": "Mostrando _PAGE_ of _PAGES_ páginas",
			     	 "sLoadingRecords": "Espere un momento, cargando...",
			     "sSearch": "Buscar:",
			     "sZeroRecords": "No hay datos con esa busqueda",
			     	 "oPaginate": {
			         "sFirst": "Primero",
			     "sLast": "Ultimo",
			     "sNext": "Siguiente",
			     "sPrevious": "Anterior"
			     	}
			   }
			});
			
			$('#tablaSinActividadesDocentes').dataTable({
			"sPaginationType": "full_numbers",
			"oLanguage": {
			"sLengthMenu": "Mostrando _MENU_ registros por página",
			"sInfo": "Mostrando _PAGE_ of _PAGES_ páginas",
			     	 "sLoadingRecords": "Espere un momento, cargando...",
			     "sSearch": "Buscar:",
			     "sZeroRecords": "No hay datos con esa busqueda",
			     	 "oPaginate": {
			         "sFirst": "Primero",
			     "sLast": "Ultimo",
			     "sNext": "Siguiente",
			     "sPrevious": "Anterior"
			     	}
			   }
			});
			
			$("#planDocente").click(function(){
				    $("#dvDetalleDocente").slideToggle( function(){
				    	var property = $("#dvDetalleDocente").css("display");
				        if(property == "block"){
				        $("#planDocente").addClass("active");
				        $("#sinPLanDocente").removeClass("active");
				        }
				        else
				        $("#planDocente").removeClass("active");
				    });
				  $("#dvDocentesSinPlan").css("display", "none");  
				    
			});			    

			});
        </script>
        <style type="text/css">
        
		  	.programasDocentes{
			    border: 0 none;
				border-radius: 2px 2px 2px 2px;
			  	color: #FFFFFF;
			  	cursor: pointer;
			  	display: inline-block;
			  	font-size: 12px;
			  	font-weight: normal;
			  	line-height: 16px;
			  	margin-bottom: 0;
			  	margin-top: 10px;
			  	padding: 7px 10px;
			  	text-transform: none;
			  	transition: all 0.3s ease 0s;
			  	-moz-transition: all 0.3s ease 0s;
			  	-webkit-transition: all 0.3s ease 0s;
			   	background: none repeat scroll 0 0 #f7f7f7;
			    color: #000000;
			}
			.programasDocentes button:hover {
			      background: none repeat scroll 0 0 #7f7f7f;
			      color: #FFFFFF;
				}
				
			.soportesPortafolios{
			    border: 0 none;
				border-radius: 2px 2px 2px 2px;
			  	color: #FFFFFF;
			  	cursor: pointer;
			  	display: inline-block;
			  	font-size: 12px;
			  	font-weight: normal;
			  	line-height: 16px;
			  	margin-bottom: 0;
			  	margin-top: 10px;
			  	padding: 7px 10px;
			  	text-transform: none;
			  	transition: all 0.3s ease 0s;
			  	-moz-transition: all 0.3s ease 0s;
			  	-webkit-transition: all 0.3s ease 0s;
			   	background: none repeat scroll 0 0 #f7f7f7;
			    color: #000000;
			}
			.soportesPortafolios button:hover {
			      background: none repeat scroll 0 0 #7f7f7f;
			      color: #FFFFFF;
				}
			
			.detallesAutoEvaluaciones{
			    border: 0 none;
				border-radius: 2px 2px 2px 2px;
			  	color: #FFFFFF;
			  	cursor: pointer;
			  	display: inline-block;
			  	font-size: 12px;
			  	font-weight: normal;
			  	line-height: 16px;
			  	margin-bottom: 0;
			  	margin-top: 10px;
			  	padding: 7px 10px;
			  	text-transform: none;
			  	transition: all 0.3s ease 0s;
			  	-moz-transition: all 0.3s ease 0s;
			  	-webkit-transition: all 0.3s ease 0s;
			   	background: none repeat scroll 0 0 #f7f7f7;
			    color: #000000;
			}
			.detallesAutoEvaluaciones button:hover {
			      background: none repeat scroll 0 0 #7f7f7f;
			      color: #FFFFFF;
				}
				
			.detallesPlanMejoras{
			    border: 0 none;
				border-radius: 2px 2px 2px 2px;
			  	color: #FFFFFF;
			  	cursor: pointer;
			  	display: inline-block;
			  	font-size: 12px;
			  	font-weight: normal;
			  	line-height: 16px;
			  	margin-bottom: 0;
			  	margin-top: 10px;
			  	padding: 7px 10px;
			  	text-transform: none;
			  	transition: all 0.3s ease 0s;
			  	-moz-transition: all 0.3s ease 0s;
			  	-webkit-transition: all 0.3s ease 0s;
			   	background: none repeat scroll 0 0 #f7f7f7;
			    color: #000000;
			}
			.detallesPlanMejoras button:hover {
			      background: none repeat scroll 0 0 #7f7f7f;
			      color: #FFFFFF;
				}
				
			#planDocente{
		    background: #ccc;
		    cursor: pointer;
		    border-top: solid 2px #eaeaea;
		    border-left: solid 2px #eaeaea;
		    border-bottom: solid 2px #777;
		    border-right: solid 2px #777;
		    padding: 5px 5px;
		    font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
		    }
		    
		    .active{
		    	background: none repeat scroll 0 0 #7f7f7f;
			      color: white;
		    }

			#menuPlanes{
				padding-bottom:10px;border-bottom:1px solid #ccc;margin:0 10%;
			}
			
			#menuPlanes a{
					background: transparent;
					border:0;
					color:#333;
					font-size: 1.2em;
			}
			
			#menuPlanes a#planDocente{
					margin-right: 20px;
					padding-right: 20px;
					border-right: 1px solid #ccc;
			}
			#menuPlanes a:hover,#menuPlanes a.active{
				color:#4d79ba;
			}
        </style>
	</head>
<body>
	<br>
	<p id="tituloPlan">Plan de actividades del programa de <?php echo $DocentesSinPlan->fields['programas']; ?></p>
	<div id="menuPlanes">
		<a id="planDocente" >Listado de Planes Docentes</a>
		<!--<a id="sinPLanDocente" >Listado de Docentes sin diligenciar plan docente</a>-->
	</div>
	<div id="dvDetalleDocente" style="display: none;">
	<br>
	<br>
	<span id="tituloDecanoFacultad">Listado de Planes Docentes</span>
	<br />
	<br />
	<div class="periodo" id="periodo">
		Periodo actual:
		<select id="periodoVocacion" class="periodoVocacion">
			<?php
                foreach($Periodos as $period)
                {
                    if( $period['codigoestadoperiodo'] == 2 ){
                    	$Periodo = $period['codigoperiodo'];
                    }
					echo "<option value='".$period['codigoperiodo']."' >".$period['nombreperiodo']."</option>";
                }
				
            ?>
		</select>
    	<!--Periodo actual: <?php echo $Periodo; ?>-->	
        <input type="hidden" value="<?php if(isset($_REQUEST["codigoPeriodo"])){ $Periodo = $_REQUEST["codigoPeriodo"]; echo $Periodo; }else{ echo $Periodo; } ?>" id="Periodo" />
    </div>
    <?php 
		    if(isset($userDecano)){
			$sqlIdDecano = "SELECT idusuario 
							FROM usuario 
							WHERE usuario = '$userDecano'";
			
			$identificadorDecano = $db->Execute($sqlIdDecano);
			
			$idDecano = $identificadorDecano->fields['idusuario'];

			$sqlDecano = "SELECT DISTINCT U.idusuario, U.usuario, F.nombrefacultad, F.codigofacultad , U.numerodocumento , U.nombres
							FROM usuario U 
								INNER JOIN usuariofacultad UF ON ( UF.usuario = U.usuario )
								INNER JOIN carrera C ON ( C.codigocarrera = UF.codigofacultad ) AND C.codigocarrera='$id_Programa'
								INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
								AND F.codigoestado = 100
								AND U.idusuario = '$idDecano'";
			$decano = $db->Execute($sqlDecano);
			
        /**
        * Caso 87930
        * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
        * Se modificá la consulta para quE muestre el nuevo campo de innovación para nueva funcionalidad de Innovación según
        * solicitud de Liliana Ahumada.
        * @since Marzo 6 de 2017
        */     
                
			$sqlActividadesDocentesF = "SELECT DISTINCT 
				a.iddocente, 
				a.apellidodocente, 
				a.nombredocente, 
				a.numerodocumento, 
				SUM(totalHoras) AS totalHoras, 
				GROUP_CONCAT(DISTINCT vocaciones ORDER BY orden SEPARATOR '|') AS vocaciones, 
				GROUP_CONCAT(DISTINCT vocacionesid ORDER BY orden SEPARATOR '|') AS vocacionesid, 
				GROUP_CONCAT(DISTINCT programas ORDER BY programas SEPARATOR '|') AS programas, 
				Carrera_id
					FROM docente a, (
						SELECT DISTINCT 
							iddocente, 
							'ENSENANZA', 
							SUM(HorasPresencialesPorSemana + HorasPreparacion + HorasEvaluacion + HorasAsesoria + HorasTIC + HorasInnovar + HorasTaller + HorasPAE) AS totalHoras, 
							'Enseñanza y aprendizaje' AS vocaciones, 
							1 AS vocacionesid, 
							1 AS orden, 
							GROUP_CONCAT(DISTINCT c.nombrecarrera ORDER BY nombrecarrera SEPARATOR '|') AS programas, 
							c.codigocarrera AS Carrera_id
							FROM PlanesTrabajoDocenteEnsenanza pl
							INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
							INNER JOIN facultad F ON (F.codigofacultad = c.codigofacultad)
							WHERE pl.codigoestado = 100 
							AND pl.codigoperiodo='".$Periodo."'
							AND pl.codigocarrera = '$id_Programa'
							GROUP BY pl.iddocente, Carrera_id
							UNION ALL
								SELECT DISTINCT 
									iddocente, 
									'OTROS', 
									SUM(HorasDedicadas) AS totalHoras,
									GROUP_CONCAT(DISTINCT v.Nombre ORDER BY v.Nombre SEPARATOR '|') AS vocaciones, 
									GROUP_CONCAT(DISTINCT v.VocacionesPlanesTrabajoDocenteId ORDER BY v.Nombre SEPARATOR '|') AS vocacionesid, 2 AS orden, 
									GROUP_CONCAT(DISTINCT c.nombrecarrera ORDER BY nombrecarrera SEPARATOR '|') AS programas, 
									c.codigocarrera AS Carrera_id
									FROM PlanesTrabajoDocenteOtros pl
									INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
									INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
									INNER JOIN facultad F ON (F.codigofacultad = c.codigofacultad)
									WHERE pl.codigoestado = 100 
									AND pl.codigoperiodo='".$Periodo."'
									AND pl.codigocarrera = '$id_Programa'							
									GROUP BY pl.iddocente, Carrera_id) b
									WHERE a.iddocente = b.iddocente
									GROUP BY a.iddocente, a.apellidodocente, a.nombredocente, a.numerodocumento, Carrera_id
									ORDER BY a.apellidodocente, a.nombredocente";
									
			$actividadesDocentesF = $db->Execute($sqlActividadesDocentesF);	
			
			$sqlDocenteSinPLan = "SELECT * FROM (
							    SELECT DISTINCT
							    D.iddocente, D.apellidodocente, D.nombredocente, D.numerodocumento, C.nombrecarrera AS programas
							    FROM
							    docente D
									INNER JOIN grupo G ON ( G.numerodocumento = D.numerodocumento )
									INNER JOIN materia M ON ( M.codigomateria = G.codigomateria )
									INNER JOIN carrera C ON ( C.codigocarrera = M.codigocarrera )
									INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
									INNER JOIN periodo P ON ( P.codigoperiodo = G.codigoperiodo )
									WHERE C.codigocarrera = '$id_Programa'
									AND G.codigoperiodo = '".$Periodo."'
									AND D.codigoestado = 100
									AND D.numerodocumento != 1
									AND G.codigoestadogrupo = 10
							    AND D.iddocente NOT IN (
							    SELECT DISTINCT
							    iddocente
							    FROM
							    PlanesTrabajoDocenteEnsenanza pl
							    INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
							    INNER JOIN facultad F ON (
							    F.codigofacultad = c.codigofacultad
							    )
							    WHERE
							    pl.codigoestado = 100
							    AND pl.codigoperiodo = '".$Periodo."'
							    AND pl.codigocarrera = '$id_Programa'
							    GROUP BY
							    pl.iddocente
							    UNION ALL
							    SELECT DISTINCT
							    iddocente
							    FROM
							    PlanesTrabajoDocenteOtros pl
							    INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
							    INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
							    INNER JOIN facultad F ON (
							    F.codigofacultad = c.codigofacultad
							    )
							    WHERE
							    pl.codigoestado = 100
							    AND pl.codigoperiodo = '".$Periodo."'
							    AND pl.codigocarrera = '$id_Programa'
							    GROUP BY
							    pl.iddocente
							    )
							    UNION 
							    (
							    SELECT DISTINCT
							    D.iddocente, D.apellidodocente, D.nombredocente, D.numerodocumento, C.nombrecarrera AS programas
							    FROM docentesvoto DV
									INNER JOIN docente D ON ( D.numerodocumento = DV.numerodocumento )
									INNER JOIN carrera C ON ( C.codigocarrera = DV.codigocarrera )
									INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
							    WHERE DV.codigocarrera = '$id_Programa'
									AND D.codigoestado = 100
									AND D.numerodocumento != 1 
							    AND D.iddocente NOT IN (
							            SELECT DISTINCT
							            iddocente
							            FROM
							            PlanesTrabajoDocenteEnsenanza pl
							            INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
							            INNER JOIN facultad F ON (
							            F.codigofacultad = c.codigofacultad
							            )
							            WHERE
							            pl.codigoestado = 100
							            AND pl.codigoperiodo = '".$Periodo."'
							            AND pl.codigocarrera = '$id_Programa'
							            GROUP BY
							            pl.iddocente
							            UNION ALL
							            SELECT DISTINCT
							            iddocente
							            FROM
							            PlanesTrabajoDocenteOtros pl
							            INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
							            INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
							            INNER JOIN facultad F ON (
							            F.codigofacultad = c.codigofacultad
							            )
							            WHERE
							            pl.codigoestado = 100
							            AND pl.codigoperiodo = '".$Periodo."'
							            AND pl.codigocarrera = '$id_Programa'
							            GROUP BY
							            pl.iddocente
							            )
							    )
							) AS D 
							GROUP BY
							D.numerodocumento
							ORDER BY
							D.apellidodocente,
							D.nombredocente";
					$DocentesSinPlan = $db->Execute($sqlDocenteSinPLan);
			
			
		}
    ?>
    <br />
	<table id="tablaActividadesDocentes" align="center" class="cell-border" width="100%" style="margin: 20px 0;">
	<br />
    <thead>      
        <tr >
        	<th ><span>No.</span> </th>
            <th ><span>Apellido docente</span></th> 
            <th ><span>Nombre docente</span></th> 
            <th ><span>Número documento</span></th> 
            <th ><span>Total horas por Programa</span></th> 
            <th ><span>Programas</span></th>
            <th ><span>Soportes</span></th>
            <th ><span>AutoEvaluación</span></th>
            <th ><span>Plan Mejora</span></th>
        </tr>
    </thead>
    <tbody class="listaRadicaciones">
		<?php
		$i = 1;
		while(!$actividadesDocentesF->EOF){ ?>			
			<tr >
				<td><?php echo $i++; ?></td>
				<td align="left"><?php echo strtoupper($actividadesDocentesF->fields['apellidodocente']); ?></td>
				<td align="left"><?php echo strtoupper($actividadesDocentesF->fields['nombredocente']); ?></td>
				<td align="left"><?php echo $actividadesDocentesF->fields['numerodocumento']; ?></td>
				<td align="center"><?php echo $actividadesDocentesF->fields['totalHoras']; ?></td>
				<td align="left"><?php
				$idDocente = $actividadesDocentesF->fields['iddocente'];	
				
				$sqlExisteAE = "SELECT 
									COUNT(DocenteId) AS existe 
								FROM AutoevaluacionDocentes
								WHERE DocenteId = $idDocente
								AND CodigoPeriodo = $Periodo
								AND CodigoCarrera = $id_Programa
								AND CodigoEstado = 100";
				
				$existeAutoEvaluacion = $db->Execute($sqlExisteAE);

				$existeAutoEvaluacion = $existeAutoEvaluacion->fields["existe"];
				
				$sqlExistePM = "SELECT 
									COUNT(DocenteId) AS existePM
								FROM PlanMejoraDocentes
								WHERE DocenteId = $idDocente
								AND CodigoPeriodo = $Periodo
								AND CodigoCarrera = $id_Programa
								AND CodigoEstado = 100";
				
				$existePM = $db->Execute($sqlExistePM);

				$existePM = $existePM->fields["existePM"];
					
				 
				$vocacionesDocentes = $actividadesDocentesF->fields['vocacionesid'];
				
				?>
					<button id="programaDocente_<?php echo $actividadesDocentesF->fields['Carrera_id'];?>_<?php echo $actividadesDocentesF->fields['iddocente']; ?>_<?php echo $vocacionesDocentes; ?>_<?php echo $idDecano; ?>_<?php echo $Periodo; ?>" class="programasDocentes" title="Ver datos vocación" style="margin:2px;display: inline-block;" type="button">
						Ver Plan Docente
					</button>
				</td>
				<td align="center"><?php 
				$rutaFichero = "documentos/".$actividadesDocentesF->fields['iddocente']."/".$Periodo."/".$actividadesDocentesF->fields['Carrera_id']."";
				if (file_exists($rutaFichero)) {
				?>
					<button id="soportePortafolio_<?php echo $actividadesDocentesF->fields['Carrera_id'];?>_<?php echo $actividadesDocentesF->fields['iddocente']; ?>_<?php echo $Periodo; ?>_<?php echo $vocacionesDocentes; ?>" class="soportesPortafolios" title="Ver Soportes" style="margin:2px;display: inline-block;" type="button">
						Ver Soportes
					</button>
				<?php } ?>
				</td>
				<td align="center">
					<?php if( $existeAutoEvaluacion != 0 ) {?>
					<button id="detalleAutoEvaluacion_<?php echo $actividadesDocentesF->fields['Carrera_id'];?>_<?php echo $actividadesDocentesF->fields['iddocente']; ?>_<?php echo $vocacionesDocentes; ?>_<?php echo $Periodo; ?>" class="detallesAutoEvaluaciones" title="Ver AutoEvaluación" style="margin:2px;display: inline-block;" type="button">
						Ver AutoEvaluación
					</button>
					<?php } ?>	
				</td>
				<td align="center">
					<?php if( $existePM != 0 ) {?>
					<button id="detallePlanMejora_<?php echo $actividadesDocentesF->fields['Carrera_id'];?>_<?php echo $actividadesDocentesF->fields['iddocente']; ?>_<?php echo $vocacionesDocentes; ?>_<?php echo $Periodo; ?>" class="detallesPlanMejoras" title="Ver Plan Mejora" style="margin:2px;display: inline-block;" type="button">
						Ver Plan Mejora
					</button>
					<?php } ?>	
				</td>
			</tr>                      
        <?php  $actividadesDocentesF->MoveNext();} ?>
	</tbody>
</table>
</div>
<br>
<br>

<script type="text/javascript">
function popup_carga(url){        
        
            var centerWidth = (window.screen.width - 910) / 2;
            var centerHeight = (window.screen.height - 700) / 2;
    
          var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=960, height=700, top="+centerHeight+", left="+centerWidth;
          var mypopup = window.open(url,"",opciones);
          //Para que me refresque la página apenas se cierre el popup
          //mypopup.onunload = windowClose;​
          
          //para poner la ventana en frente
          window.focus();
          mypopup.focus();
          
      }
//on es porque como estoy creando y quitanto elementos dinamicamente, me los reconozca
        $(".programasDocentes").on('click',function(){
            // get number of column
            var ids = $(this).attr('id');
            ids = ids.replace("programaDocente_","");
			ids = ids.split("_");

            popup_carga('./verDatosDocenteVocacion.php?idPrograma='+ids[0]+'&idDocente='+ids[1]+'&idVocacion='+ids[2]+'&idDecano='+ids[3]+'&idPeriodo='+ids[4]); 
           
        });
        
        $(".soportesPortafolios").on('click',function(){
        	var ids = $(this).attr('id');
            ids = ids.replace("soportePortafolio_","");
			ids = ids.split("_");
        	popup_carga('./verDatosPortafolio.php?idPrograma='+ids[0]+'&idDocente='+ids[1]+'&idPeriodo='+ids[2]+'&idVocacion='+ids[3]);
        });
        
        $(".detallesAutoEvaluaciones").on('click',function(){
        	var ids = $(this).attr('id');
            ids = ids.replace("detalleAutoEvaluacion_","");
			ids = ids.split("_");
        	popup_carga('./verAutoEvaluacion.php?idPrograma='+ids[0]+'&idDocente='+ids[1]+'&idVocacion='+ids[2]+'&idPeriodo='+ids[3]);
        });
        
        $(".detallesPlanMejoras").on('click',function(){
        	var ids = $(this).attr('id');
            ids = ids.replace("detallePlanMejora_","");
			ids = ids.split("_");
        	popup_carga('./verPlanMejora.php?idPrograma='+ids[0]+'&idDocente='+ids[1]+'&idVocacion='+ids[2]+'&idPeriodo='+ids[3]);
        });

</script>
</body>
</html>