<div id="contentPage">
<?php
	session_start;
/*	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
    include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = getBD();
    
    $data = array();
	$dataDetalle = array();
	$grupos = array();
    $docentes = array();;
	$proyecto = array();
    $costo = array();
	$empresas = array();
	$id = "";
	$numGrupos = 0;
        $pagina = 1;
        $ultimoGrupo = 0;
        $totalPaginas = 0;
        $totalPaginasPintar = 0;
        $numVersiones = 0;
        $limite = 0;
	
    if(isset($_REQUEST["id"])){  
	   $id = $_REQUEST["id"];
	   $utils = Utils::getInstance();
       $data = $utils->getDataEntity("carrera", $id, "codigocarrera");  
       $dataDetalle = $utils->getDataEntity("detalleCursoEducacionContinuada", $data["codigocarrera"], "codigocarrera");
       
       if(!isset($_REQUEST["total"])){
	   $numVersiones = $utils->getTotalGruposCursoEducacionContinuada($db,$data["codigocarrera"]);
           $numVersiones = $numVersiones["total"];
       } else {
          $numVersiones =  intval($_REQUEST["total"]);
       }
           if($numVersiones>0){
               $totalPaginas = ceil($numVersiones/10);
               if(!isset($_REQUEST["pag"])){
                  $grupos = $utils->getTotalGruposCursoEducacionContinuadaPaginado($db,$data["codigocarrera"]);
               } else {
                   $pagina = $_REQUEST["pag"];
                        $limite = ($pagina-1) * 10;
         
                   $grupos = $utils->getTotalGruposCursoEducacionContinuadaPaginado($db,$data["codigocarrera"],$limite);
               }
           }
            if($grupos!=null && count($grupos)>0){	   
			$numGrupos = count($grupos);
                        //$ultimoGrupo = $grupos[$numGrupos-1]["idgrupo"];
	   }
   }
   if($totalPaginas===0){
       $totalPaginasPintar = 1;
   }else {
       $totalPaginasPintar = $totalPaginas;
   }
?>

				<div id="tabs-3">
					<h4>Ver Detalle Programa de Educación Continuada</h4>
						<table class="detalle" style="width:100%">
							<tr>
								<th class="center" >Id Grupo</th>
								<th class="center" ># de Proyecto</th>
								<th class="center" >Última fecha para<br/>pago de matrícula</th>
								<th class="center" >Código Periodo</th>
								<th class="center" >Fecha de inicio</th>
								<th class="center" >Fecha de finalización</th>
								<?php if($dataDetalle["categoria"]==1) { ?> <th class="center">Ciudad</th> <?php } ?>
								<th class="center" >Tipo</th>
								<th class="center" >Cupo</th>
								<th class="center" ># matriculados</th>
								<th class="center" >Estado</th>
								<th class="center" >Acciones</th>
							</tr>
							<?php for($i = 0; $i < $numGrupos; ++$i) { 
								//var_dump($grupos[$i]);
								
								$proyecto = $utils->getDataEntity("numeroordeninternasap", $grupos[$i]["idgrupo"], "idgrupo");
								$dataDetalleGrupo = $utils->getDataEntity("detalleGrupoCursoEducacionContinuada", $grupos[$i]["idgrupo"], "idgrupo");
								//$grupo = $utils->getDataEntity("grupo", $grupos[$i]["idgrupo"], "idgrupo");
								//$costo = $utils->getCostoCursoEducacionContinuada($db,$grupos[$i]["idgrupo"],$data["codigocarrera"]);
								$tipo = $utils->getDataEntity("tipoEducacionContinuada", $dataDetalleGrupo["tipo"], "idtipoEducacionContinuada"); 
								$ciudad= $utils->getDataEntity("ciudad", $dataDetalleGrupo["ciudad"], "idciudad"); 
								$fecha = $utils->getFechaMatricula($db, $grupos[$i]["idgrupo"]);
							?>
								<tr>
									<td><?php echo $grupos[$i]["idgrupo"]; ?></td>
									<td><?php echo $proyecto['numeroordeninternasap']; ?></td>
									<td class="center"><?php if($dataDetalleGrupo["tipo"]!=2){ echo $fecha; } ?></td>
									<td class="center"><?php echo $grupos[$i]["codigoperiodo"]; ?></td>
									<td class="center"><?php echo $grupos[$i]["fechainiciogrupo"]; ?></td>
									<td class="center"><?php echo $grupos[$i]["fechafinalgrupo"]; ?></td>
								<?php if($dataDetalle["categoria"]==1) { ?> <td><?php echo $ciudad["nombreciudad"]; ?></td> <?php } ?>
									<td class="center"><?php echo $tipo["nombre"]; ?></td>
									<td class="center"><?php echo $grupos[$i]["maximogrupo"]; ?></td>
									<td class="center"><?php echo $grupos[$i]["matriculadosgrupo"]; ?></td>
									<td class="center"><?php echo $grupos[$i]["nombreestadogrupo"]; ?></td>
									<td>
                                        <div class="center">
                                            <button class="soft image participantes" type="button" id="participantes_<?php echo $grupos[$i]["idgrupo"]; ?>" title="Ver participantes" ><img src="../images/users.png" alt="Participantes" width="32"/></button>
                                            <button class="soft image docentesB" type="button" id="docentes_<?php echo $grupos[$i]["idgrupo"]; ?>" title="Ver docente(s)" ><img src="../images/teachers.png" alt="Docente(s)" width="32"/></button>
                                            <button class="soft image empresasB" type="button" id="empresas_<?php echo $grupos[$i]["idgrupo"]; ?>" title="Ver empresa(s)" ><img src="../images/company.png" alt="Empresa(s)" width="32"/></button>
                                            <button class="soft image pagos" type="button" id="pagos_<?php echo $grupos[$i]["idgrupo"]; ?>" title="Gestionar pagos patrocinados" ><img src="../images/money.png" alt="Pagos patrocinados" width="32"/></button>
											<button class="soft image editarGrupo" type="button" id="idgrupo_<?php echo $grupos[$i]["idgrupo"]; ?>" title="Editar grupo del programa" ><img src="../images/edit.png" alt="Editar grupo" width="32"/></button>
											<?php if($grupos[$i]["matriculadosgrupo"]==0 && $grupos[$i]["codigoestadogrupo"]==10){ ?>
                                                <button class="soft image eliminarGrupo" type="button" id="idgrupo_<?php echo $grupos[$i]["idgrupo"]; ?>" title="Cerrar grupo" ><img src="../../mgi/images/delete.png" alt="Eliminar grupo" width="32"/></button>
                                            <?php } ?>
                                        </div>
                                    </td>
								</tr> 
							<?php } ?>         
						</table>
                                        <div class="vacio"></div>
                                        <div class="pagination" style="text-align:center;">
                                            <?php if($pagina>1){ ?>
                                                <a class="before"  href="javascript:void(0)" onclick="before();" >< Anteriores</a>
                                            <?php } ?>
                                                <span><?php echo $pagina." de ".$totalPaginasPintar; ?></span>
                                            <?php if($pagina<$totalPaginas){ ?>
                                                <a class="next" href="javascript:void(0)" onclick="next();" >Siguientes ></a>
                                            <?php } ?>
                                        </div>
                                        <div class="vacio"></div>
				</div>
				
<script type="text/javascript">
	$(document).ready(function() {
		// Handler for .ready() called.
		calculateWidthMenuTabs(); 
		calculateWidthMenu(); 
	});
        
        function before(){
            $('#contentPage').load('detalleVersiones.php?id=<?php echo $id; ?>&total=<?php echo $numVersiones; ?>&next=0&pag=<?php echo ($pagina-1); ?>');
        } 
        
        function next(){
            $('#contentPage').load('detalleVersiones.php?id=<?php echo $id; ?>&total=<?php echo $numVersiones; ?>&next=1&pag=<?php echo ($pagina+1); ?>');
        }
        
        //on es porque como estoy creando y quitanto elementos dinamicamente, me los reconozca
        $(".participantes").on('click',function(){
            // get number of column
            var idgrupo = $(this).attr('id');
            idgrupo = idgrupo.replace("participantes_",""); 

            popup_carga('./participantes.php?idGrupo='+idgrupo); 
           
        });
        
        //on es porque como estoy creando y quitanto elementos dinamicamente, me los reconozca
        $(".editarGrupo").on('click',function(){
            // get number of column
            var idgrupo = $(this).attr('id');
            idgrupo = idgrupo.replace("idgrupo_",""); 

            window.location.href='./registrarNuevaVersion.php?id=<?php echo $id; ?>&idGrupo='+idgrupo; 
           
        });
        
        //on es porque como estoy creando y quitanto elementos dinamicamente, me los reconozca
        $(".eliminarGrupo").on('click',function(){
            // get number of column
            var idgrupo = $(this).attr('id');
            idgrupo = idgrupo.replace("idgrupo_",""); 
			
			$.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'process.php',
                    data: 'id='+idgrupo+'&action=inactivateGrupo',
                    success:function(data){ 
                        if (data.success == true){
                             $('#contentPage').load('detalleVersiones.php?id=<?php echo $id; ?>&total=<?php echo $numVersiones-1; ?>&next=0&pag=<?php echo ($pagina); ?>');
                        }
                },
                    error: function(data,error){}
            }); 
           
        });
        
        $(".pagos").on('click',function(){
            // get number of column
            var idgrupo = $(this).attr('id');
            idgrupo = idgrupo.replace("pagos_",""); 

            popup_carga('./pagosGrupos.php?idGrupo='+idgrupo); 
           
        });
        
        $(".empresasB").on('click',function(){
            // get number of column
            var idgrupo = $(this).attr('id');
            idgrupo = idgrupo.replace("empresas_",""); 

            popup_carga('./empresasGrupo.php?idGrupo='+idgrupo); 
           
        });
        
        $(".docentesB").on('click',function(){
            // get number of column
            var idgrupo = $(this).attr('id');
            idgrupo = idgrupo.replace("docentes_",""); 

            popup_carga('./docentesGrupo.php?idGrupo='+idgrupo); 
           
        });

</script>
</div>