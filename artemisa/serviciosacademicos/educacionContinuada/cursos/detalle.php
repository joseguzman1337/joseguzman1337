<?php
    /*
    * Ivan Dario Quintero Rios
    * Febrero 8 del 2018
    * Adicion de campos nuevos de agrupacion
    */
	session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
    include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Ver Detalle Curso",TRUE);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
	$dataDetalle = array();
	$centro = array();
    $titulo = array();
    $facultad = array();
    $directivo = array();
    $categoria = array();
    $actividad = array();
    $ciudad = array();
    //$tipo = array();
    $nucleo = array();
	$id = "";
	
    if(isset($_REQUEST["id"]))
    {  
        $id = str_replace('row_','',$_REQUEST["id"]);
        $utils = Utils::getInstance();
        $data = $utils->getDataEntity("carrera", $id, "codigocarrera");                  
        $facultad = $utils->getDataEntity("facultad", $data["codigofacultad"], "codigofacultad"); 
        $carreraAgrupaciones = "select AgrupacionCarreraEducacionContinuadaId from CarrerasEducacionContinuada where codigocarrera = '".$data["codigocarrera"]."' and CodigoEstado= '100'";
        $carreraagrupacion = $db->GetRow($carreraAgrupaciones); 
        $Agrupacion = $utils->getDataEntity("AgrupacionCarreraEducacionContinuada",$carreraagrupacion['AgrupacionCarreraEducacionContinuadaId'], "AgrupacionCarreraEducacionContinuadaId");         
        $titulo = $utils->getDataEntity("titulo", $data["codigotitulo"], "codigotitulo");   
        $directivo = $utils->getDataEntity("directivo", $data["iddirectivo"], "iddirectivo"); 
        $centro = $utils->getDataEntity("centrobeneficio", $data["codigocentrobeneficio"], "codigocentrobeneficio");
        $dataDetalle = $utils->getDataEntity("detalleCursoEducacionContinuada", $data["codigocarrera"], "codigocarrera");
		
        if($dataDetalle!=null && count($dataDetalle)>0)
        {	   
            $categoria = $utils->getDataEntity("categoriaCursoEducacionContinuada", $dataDetalle["categoria"], "idcategoriaCursoEducacionContinuada");   
            $actividad = $utils->getDataEntity("actividadEducacionContinuada", $dataDetalle["actividad"], "idactividadEducacionContinuada"); 
	
            if($dataDetalle["categoria"]==1 || $dataDetalle["categoria"]==3)
            { 
                $ciudad = $utils->getDataEntity("ciudad", $dataDetalle["ciudad"], "idciudad");
            }
            //$tipo = $utils->getDataEntity("tipoEducacionContinuada", $dataDetalle["tipo"], "idtipoEducacionContinuada"); 
            $nucleo = $utils->getDataEntity("nucleoEstrategico", $dataDetalle["nucleoEstrategico"], "idnucleoEstrategico"); 
        }
           
        $valorM = $utils->getValorMatriculaCurso($db, $id);     
        $fechasInscripcion = $utils->getFechasInscripcionCurso($db, $id);          
    }
?>
<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({
                select: function(event, ui) {       
                        //para que al cargarse vuelva a cargar en la que estaba
                        window.location.hash = ui.tab.hash;
                    },
		beforeLoad: function( event, ui ) {
			ui.jqXHR.error(function() {
				ui.panel.html(
				"Ocurrio un problema cargando el contenido." );
				});
			}
		});
	});
    
  
</script>

    <div id="contenido" style="margin:10px 0;">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Información básica</a></li>
                <li><a href="detalleVersiones.php?id=<?php echo $id; ?>">Grupos del Programa</a></li>
                <li><a href="detalleCertificacion.php?id=<?php echo $id; ?>">Información de la Certificación</a></li>
                <li><a href="detalleValores.php?id=<?php echo $id; ?>">Valores pecunarios</a></li>
                <li><a href="detalleAgrupacion.php?id=<?php echo $id; ?>">Agrupaciones</a></li>
            </ul>
            <div id="tabs-1">
                <h4 style="display:inline-block;">Ver Detalle Programa de Educación Continuada</h4>  <button class="soft addBtn" type="button" id="btnEditarPrograma" style="font-size:0.8em;margin-left:15px;">Editar Programa</button>
                <table class="detalle">
                    <tr>
                        <th>Código:</th>
                        <td><?php echo $data['codigocarrera']; ?></td>
                        <th>Tipo de actividad:</th>
                        <td><?php echo $actividad['nombre']; ?></td>
                    </tr>
                    <tr>
                        <th>Nombre:</th>
                        <td colspan="3"><?php echo $data['nombrecarrera']; ?></td>
                    </tr>
                    <tr>
                        <th>Facultad:</th>
                        <td colspan="3"><?php echo $facultad['nombrefacultad']; ?></td>
                    </tr>
                    <tr>
                        <th>Título:</th>
                        <td><?php echo $titulo['nombretitulo']; ?></td>
                        <th>Núcleo estratégico:</th>
                        <td><?php echo $nucleo['nombre']; ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de inicio de inscripción:</th>
                        <td><?php echo $fechasInscripcion['inicio']; ?></td>
                        <th>Fecha final de inscripción:</th>
                        <td><?php echo $fechasInscripcion['final']; ?></td>
                    </tr>
                    <tr>
                        <th>Valor Matrícula:</th>
                        <td>$<?php echo number_format($valorM, 0, '.', ','); ?></td>
                        <th>Duración en horas:</th>
                        <td><?php echo $dataDetalle['intensidad']; ?></td>
                    </tr> 
                    <tr>
                        <th>Categoría:</th>
                        <td><?php echo $categoria['nombre']; if($dataDetalle["categoria"]==1 || $dataDetalle["categoria"]==3){ echo " en ".$ciudad["nombreciudad"]; } ?></td>
                        <th>Porcentaje de fallas permitidas:</th>
                        <td><?php echo $dataDetalle['porcentajeFallasPermitidas']."%"; ?></td>
                    </tr> 
                    <tr>								
                                                        <th>Directivo:</th>
                        <td><?php echo $directivo['nombresdirectivo']." ".$directivo["apellidosdirectivo"]; ?></td>
                        <th>Centro de beneficio:</th>
                        <td><?php echo $data['codigocentrobeneficio']; ?></td>
                    </tr> 
                    <tr>
                        <th>Fecha de inicio:</th>
                        <td><?php echo $data['fechainiciocarrera']; ?></td>
                        <th>Fecha de vencimiento:</th>
                        <td><?php echo $data['fechavencimientocarrera']; ?></td>
                    </tr>   
                    <tr>
                        <th>Autorizado por:</th>
                        <td ><?php echo $dataDetalle['autorizacion']; ?></td>
                        <th>Genera Orden Automática:</th>
                        <td><?php if($dataDetalle['generaOrdenAutomatica']){echo "Si";}else { echo "No";} ?></td>
                    </tr>          
                    <tr>
                        <th>Nombre Agrupacion</th>
                        <td><?php echo $Agrupacion['NombreAgrupacion'];?></td>
                        <th>Codigo agrupacion</th>
                        <td><?php echo $Agrupacion['AgrupacionCarreraEducacionContinuadaId'];?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<script type="text/javascript">
	$(document).ready(function() {
		// Handler for .ready() called.
		calculateWidthMenuTabs(); 
		calculateWidthMenu(); 
	});

    
    //Para que arregle el menu al cambiar el tamaño de la página
    $(window).resize(function() {
		 calculateWidthMenuTabs();
         calculateWidthMenu();
    }); 
    
   $('#btnEditarPrograma').click(function(event) {
                    window.location.href="./editar.php?id="+<?php echo $id; ?>;
    });	
</script>

<?php   //include("./detalleResponsables.php");

 writeFooter(); ?>