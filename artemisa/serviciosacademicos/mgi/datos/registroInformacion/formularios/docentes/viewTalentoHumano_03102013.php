<?php         
    $records = $utils->getDataForm($db,"siq_formTalentoHumanoNumeroPersonas","codigoperiodo");
    $recordsEscalafon = $utils->getDataForm($db,"siq_formTalentoHumanoDocentesEscalafon","codigoperiodo");
    $recordsFormacion = $utils->getDataForm($db,"siq_formTalentoHumanoDocentesFormacion","codigoperiodo");
    $recordsPrestacion = $utils->getDataFormCategory($db,"siq_formTalentoHumanoPersonalPrestacionServicios","codigoperiodo","siq_actividadPrestacionServicios","idActividad");
    $recordsPrestamos = $utils->getDataForm($db,"siq_formTalentoHumanoPrestamosCondonables","codigoperiodo");
    //$recordsApoyos = $utils->getDataForm($db,"siq_formTalentoHumanoApoyosEconomicos","codigoperiodo");
    $recordsIndices = $utils->getDataFormCategory($db,"siq_formTalentoIndiceSelectividad","codigoperiodo","siq_dedicacionPersonal","idDedicacion");
    $recordsDesvinculados = $utils->getDataForm($db,"siq_formTalentoHumanoAcademicosDesvinculados","codigoperiodo");
    $recordsExtranjerosFacultad = $utils->getDataFormCategoryDynamic($db,"formTalentoHumanoAcademicosExtranjerosFacultad","codigoperiodo","facultad","nombrefacultad",false);
    $recordsExtranjerosPais = $utils->getDataFormCategoryDynamic($db,"formTalentoHumanoAcademicosExtranjerosPais","codigoperiodo","pais","nombrepais");
    
    $num = count($records);    
?>



<script type="text/javascript">
	$(function() {
            
		$( "#tabs" ).tabs({
                    beforeLoad: function( event, ui ) {
                            ui.jqXHR.error(function() {
                                    ui.panel.html(
                                    "Ocurrio un problema cargando el contenido." );
                                    });
                            } 
		});
                
                $("#tabs").plusTabs({
   			className: "plusTabs", //classname for css scoping
   			seeMore: true,  //initiate "see more" behavior
   			seeMoreText: "Ver más información", //set see more text
   			showCount: true, //show drop down count
   			expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
   			dropWidth: "auto", //width of dropdown
 			sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
   		});
                
                 //$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
                //$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	});
                
                
</script>
<div id="tabs" class="dontCalculate">
				<ul>
					<li class="tab0"><a href="#tabs-1">Número de Personas</a></li>
					<li class="tab1"><a href="#tabs-8">Docentes por Vinculación</a></li>
					<li class="tab2"><a href="#tabs-9">Docentes por dedicación de tiempo</a></li>
					<li class="tab3"><a href="#tabs-10">Docentes por escalafón docente</a></li>
					<li class="tab4"><a href="#tabs-2">Docentes por nivel de Formación</a></li>
					<li class="tab5"><a href="#tabs-11">Docentes por nivel de Formación (especializaciones médico – quirúrgicas)</a></li>
					<li class="tab6"><a href="#tabs-12">Docentes en Formación</a></li>
					<li class="tab7"><a href="#tabs-3">Personal por prestación de servicios</a></li>
					<li class="tab8"><a href="#tabs-4">Préstamos Condonables</a></li>
					<!--<li class="tab9"><a href="#tabs-5">Apoyos económicos </a></li>-->
					<li class="tab10"><a href="#tabs-6">Índice de selectividad de los académicos</a></li>
					<li class="tab11"><a href="#tabs-7">Académicos desvinculados</a></li>     
					<li class="tab12"><a href="#tabs-13">Académicos extranjeros por Unidad Académica</a></li>      
					<li class="tab13"><a href="#tabs-14">Académicos extranjeros por país de origen</a></li>            
				</ul>
<div id="tabs-1">
     <table align="center" class="formData viewData" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Número de Personas</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Período</span></th> 
                            <th class="column" ><span>Académicos</span></th> 
                            <th class="column" ><span>Administrativos</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                    </thead>
                    <tbody>                        
                        <?php for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center"><?php echo $records[$i]["codigoperiodo"]; ?></td>
                                <td class="column center"><?php echo $records[$i]["numAcademicos"]; ?></td>
                                <td class="column center"><?php echo $records[$i]["numAdministrativos"]; ?></td>
                                <td class="column center"><?php echo ($records[$i]["numAdministrativos"]+$records[$i]["numAcademicos"]); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>   
</div>
    
    <div id="tabs-8">
                  
               <table align="center" class="formData viewData" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Docentes por Vinculación</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Período</span></th> 
                            <th class="column" ><span>Académicos Adjuntos (semestral)</span></th> 
                            <th class="column" ><span>Académicos (11 meses)</span></th> 
                            <th class="column" ><span>Núcleo Académico (núcleo profesoral)</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                     </thead>
                     <tbody>                                            
                        <?php for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center"><?php echo $records[$i]["codigoperiodo"]; ?></td>
                                <td class="column center"><?php echo $records[$i]["numAcademicosSemestral"]; ?></td>
                                <td class="column center"><?php echo $records[$i]["numAcademicosAnual"]; ?></td>
                                <td class="column center"><?php echo $records[$i]["numAcademicosNucleoProfesoral"]; ?></td>
                                <td class="column center"><?php echo ($records[$i]["numAcademicosNucleoProfesoral"]+
                                        $records[$i]["numAcademicosSemestral"]+$records[$i]["numAcademicosAnual"]); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table> 
              
</div>
    
    <div id="tabs-9">
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="6"><span>Docentes por dedicación de tiempo</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Período</span></th> 
                            <th class="column" ><span>1/4 de Tiempo</span></th> 
                            <th class="column" ><span>1/2 Tiempo</span></th> 
                            <th class="column" ><span>3/4 de Tiempo</span></th> 
                            <th class="column" ><span>Tiempo Completo</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <?php for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center"><?php echo $records[$i]["codigoperiodo"]; ?></td>
                                <td class="column center"><?php echo $records[$i]["numAcademicos14T"]; ?></td>
                                <td class="column center"><?php echo $records[$i]["numAcademicosMT"]; ?></td>
                                <td class="column center"><?php echo $records[$i]["numAcademicos34T"]; ?></td>
                                <td class="column center"><?php echo $records[$i]["numAcademicosTC"]; ?></td>
                                <td class="column center"><?php echo ($records[$i]["numAcademicos14T"]+$records[$i]["numAcademicosTC"]+
                                        $records[$i]["numAcademicosMT"]+$records[$i]["numAcademicos34T"]); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
</div>
    
    <div id="tabs-10">
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="8"><span>Docentes por escalafón docente</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Período</span></th> 
                            <th class="column" ><span>Instructor asistente</span></th> 
                            <th class="column" ><span>Instructor Asociado</span></th> 
                            <th class="column" ><span>Profesor Asistente</span></th> 
                            <th class="column" ><span>Profesor Asociado</span></th> 
                            <th class="column" ><span>Profesor Titular</span></th> 
                            <th class="column" ><span>Otros</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <?php $num = count($recordsEscalafon);
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center"><?php echo $recordsEscalafon[$i]["codigoperiodo"]; ?></td>
                                <td class="column center"><?php echo $recordsEscalafon[$i]["numAcademicosIAsistente"]; ?></td>
                                <td class="column center"><?php echo $recordsEscalafon[$i]["numAcademicosIAsociado"]; ?></td>
                                <td class="column center"><?php echo $recordsEscalafon[$i]["numAcademicosPAsistente"]; ?></td>
                                <td class="column center"><?php echo $recordsEscalafon[$i]["numAcademicosPAsociado"]; ?></td>
                                <td class="column center"><?php echo $recordsEscalafon[$i]["numAcademicosPTitular"]; ?></td>
                                <td class="column center"><?php echo $recordsEscalafon[$i]["numAcademicosOtros"]; ?></td>
                                <td class="column center"><?php echo ($recordsEscalafon[$i]["numAcademicosOtros"]+$recordsEscalafon[$i]["numAcademicosPTitular"]+
                                        $recordsEscalafon[$i]["numAcademicosPAsociado"]+$recordsEscalafon[$i]["numAcademicosPAsistente"])+
                                        $recordsEscalafon[$i]["numAcademicosIAsociado"]+$recordsEscalafon[$i]["numAcademicosIAsistente"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
</div>
    
    <div id="tabs-2">
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="9"><span>Docentes por nivel de Formación</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Período</span></th> 
                            <th class="column" ><span>T. Doctorado</span></th> 
                            <th class="column" ><span>T. Maestría</span></th> 
                            <th class="column" ><span>T. Especialización</span></th> 
                            <th class="column" ><span>T. Profesional</span></th> 
                            <th class="column" ><span>T. Técnico/ Tecnólogo</span></th> 
                            <th class="column" ><span>T. Licenciado</span></th> 
                            <th class="column" ><span>Sin Titulo</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <?php $num = count($recordsFormacion);
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center"><?php echo $recordsFormacion[$i]["codigoperiodo"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosDoctorado"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosMaestria"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosEspecializacion"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosProfesional"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosTecnico"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosLicenciado"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosNoTitulo"]; ?></td>
                                <td class="column center"><?php echo ($recordsFormacion[$i]["numAcademicosNoTitulo"]+$recordsFormacion[$i]["numAcademicosLicenciado"]+
                                        $recordsFormacion[$i]["numAcademicosTecnico"]+$recordsFormacion[$i]["numAcademicosProfesional"])+
                                        $recordsFormacion[$i]["numAcademicosEspecializacion"]+$recordsFormacion[$i]["numAcademicosMaestria"]+
                                $recordsFormacion[$i]["numAcademicosDoctorado"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
</div>
    
    <div id="tabs-11">
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="9"><span>Docentes por nivel de formación <br/>(especializaciones médico – quirúrgicas)</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Período</span></th> 
                            <th class="column" ><span>T. Doctorado</span></th> 
                            <th class="column" ><span>T. Maestría</span></th> 
                            <th class="column" ><span>T. Especialización</span></th> 
                            <th class="column" ><span>T. Profesional</span></th> 
                            <th class="column" ><span>T. Técnico/ Tecnólogo</span></th> 
                            <th class="column" ><span>T. Licenciado</span></th> 
                            <th class="column" ><span>Sin Titulo</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center"><?php echo $recordsFormacion[$i]["codigoperiodo"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosDoctoradoMedico"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosMaestriaMedico"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosEspecializacionMedico"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosProfesionalMedico"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosTecnicoMedico"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosLicenciadoMedico"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosNoTituloMedico"]; ?></td>
                                <td class="column center"><?php echo ($recordsFormacion[$i]["numAcademicosNoTituloMedico"]+$recordsFormacion[$i]["numAcademicosLicenciadoMedico"]+
                                        $recordsFormacion[$i]["numAcademicosTecnicoMedico"]+$recordsFormacion[$i]["numAcademicosProfesionalMedico"])+
                                        $recordsFormacion[$i]["numAcademicosEspecializacionMedico"]+$recordsFormacion[$i]["numAcademicosMaestriaMedico"]+
                                $recordsFormacion[$i]["numAcademicosDoctoradoMedico"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
</div>
    
    <div id="tabs-12">
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Docentes en formación</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Período</span></th> 
                            <th class="column" ><span>Doctorado</span></th> 
                            <th class="column" ><span>Maestría</span></th> 
                            <th class="column" ><span>Especialización</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center"><?php echo $recordsFormacion[$i]["codigoperiodo"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosEnDoctorado"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosEnMaestria"]; ?></td>
                                <td class="column center"><?php echo $recordsFormacion[$i]["numAcademicosEnEspecializacion"]; ?></td>
                                <td class="column center"><?php echo ($recordsFormacion[$i]["numAcademicosEnEspecializacion"]+
                                        $recordsFormacion[$i]["numAcademicosEnMaestria"]+$recordsFormacion[$i]["numAcademicosEnDoctorado"]); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
</div>
    
    
        <div id="tabs-3" class="longTable">
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                             <?php 
                             $numP = count($recordsPrestacion["dataPeriodos"]);
                                $colspan = 1 + $numP*2; ?>
                            <th class="column" colspan="<?php echo $colspan; ?>"><span>Personal por prestación de servicios</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2" ><span>Actividad</span></th> 
                            <?php                             
                            for ($i = 0; $i < $numP; $i++) { ?>
                                <th class="column borderR" colspan="2"><span><?php echo $recordsPrestacion["dataPeriodos"][$i]["periodo"]; ?></span></th>
                            <?php } ?>
                        </tr>
                        <tr class="dataColumns category">
                            <?php for ($i = 0; $i < $numP; $i++) { ?>                                
                                        <th class="column" ><span>Número de Personas</span></th> 
                                        <th class="column borderR" ><span>Valor Total de los Servicios</span></th>                                 
                                <?php }  ?>     
                        </tr>
                     </thead>
                     <tbody>
                        <?php $num = count($recordsPrestacion["data"])/count($recordsPrestacion["dataPeriodos"]);    
                        $totales = array();
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column borderR"><?php echo $recordsPrestacion["data"][$i]["nombre"]; ?></td>
                                <?php for ($j = 1; $j <= $numP; $j++) { ?>  
                                <td class="column center"><?php echo $recordsPrestacion["data"][$i*$j]["numPersonas"]; 
                                    $totales["numPersonas"][$j] = $totales["numPersonas"][$j] + $recordsPrestacion["data"][$i*$j]["numPersonas"]; ?></td>
                                <td class="column center borderR"><?php echo number_format($recordsPrestacion["data"][$i*$j]["valorServicios"]);
                                 $totales["valorServicios"][$j] = $totales["valorServicios"][$j] + $recordsPrestacion["data"][$i*$j]["valorServicios"]; ?></td>
                                <?php }  ?> 
                            </tr>   
                          <?php }  ?>                               
                            <tr class="dataColumns">
                                <th class="column total center borderR"><span>Total</span></th>
                                <?php for ($j = 1; $j <= $numP; $j++) { ?>  
                                <th class="column total center"><?php echo $totales["numPersonas"][$j]; ?></th>
                                <th class="column total center borderR"><?php echo number_format($totales["valorServicios"][$j]); ?></th>
                                <?php }  ?> 
                            </tr>  
                    </tbody>
                </table>
</div>
    
     <div id="tabs-4">
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="6"><span>Préstamos Condonables (Aprobados por Consejo Directivo)</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Período</span></th>  
                            <th class="column borderR" rowspan="2"><span>Ámbito</span></th>   
                            <th class="column borderR" colspan="3"><span>Nivel de Formación</span></th>  
                            <th class="column" rowspan="2"><span>Valor</span></th>                                   
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Especialización</span></th> 
                            <th class="column" ><span>Maestría</span></th> 
                            <th class="column borderR" ><span>Doctorado</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <?php $num = count($recordsPrestamos);
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center borderR" rowspan="3"><?php echo $recordsPrestamos[$i]["codigoperiodo"]; ?></td>
                                <td class="column center borderR">Nacional</td>
                                <td class="column center"><?php echo number_format($recordsPrestamos[$i]["valorNacionalEspecializacion"]); ?></td>
                                <td class="column center"><?php echo number_format($recordsPrestamos[$i]["valorNacionalMaestria"]); ?></td>
                                <td class="column center borderR"><?php echo number_format($recordsPrestamos[$i]["valorNacionalDoctorado"]); ?></td>
                                <td class="column center"><?php $total[$i]["nacional"] = ($recordsPrestamos[$i]["valorNacionalEspecializacion"]+
                                        $recordsPrestamos[$i]["valorNacionalMaestria"]+$recordsPrestamos[$i]["valorNacionalDoctorado"]);
                                        echo number_format($total[$i]["nacional"]); ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column center borderR">Internacional</td>
                                <td class="column center"><?php echo $recordsPrestamos[$i]["valorInternacionalEspecializacion"]; ?></td>
                                <td class="column center"><?php echo $recordsPrestamos[$i]["valorInternacionalMaestria"]; ?></td>
                                <td class="column center borderR"><?php echo $recordsPrestamos[$i]["valorInternacionalDoctorado"]; ?></td>
                                <td class="column center"><?php $total[$i]["internacional"] = ($recordsPrestamos[$i]["valorInternacionalEspecializacion"]+
                                        $recordsPrestamos[$i]["valorInternacionalMaestria"]+$recordsPrestamos[$i]["valorInternacionalDoctorado"]);
                                    echo number_format($total[$i]["internacional"]); ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <th class="column center borderR"><span>Total</span></th>
                                <th class="column center"><?php echo number_format($recordsPrestamos[$i]["valorNacionalEspecializacion"]+
                                        $recordsPrestamos[$i]["valorInternacionalEspecializacion"]); ?></th>
                                <th class="column center"><?php echo number_format($recordsPrestamos[$i]["valorNacionalMaestria"]+
                                        $recordsPrestamos[$i]["valorInternacionalMaestria"]); ?></th>
                                <th class="column center borderR"><?php echo number_format($recordsPrestamos[$i]["valorNacionalDoctorado"]+
                                        $recordsPrestamos[$i]["valorInternacionalDoctorado"]); ?></th>
                                <th class="column center"><?php echo number_format($total[$i]["internacional"]+
                                        $total[$i]["nacional"]); ?></th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
</div>
    
     <!--<div id="tabs-5" >
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="6"><span>Apoyos económicos (Aprobados por Consejo Directivo)</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Período</span></th>  
                            <th class="column borderR" rowspan="2"><span>Ámbito</span></th>   
                            <th class="column borderR" colspan="3"><span>Tipo de evento</span></th>  
                            <th class="column" rowspan="2"><span>Valor</span></th>                                   
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Congreso</span></th> 
                            <th class="column" ><span>Diplomado</span></th> 
                            <th class="column borderR" ><span>Taller</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <?php /*$num = count($recordsApoyos);
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center borderR" rowspan="3"><?php echo $recordsApoyos[$i]["codigoperiodo"]; ?></td>
                                <td class="column center borderR">Nacional</td>
                                <td class="column center"><?php echo number_format($recordsApoyos[$i]["valorNacionalCongreso"]); ?></td>
                                <td class="column center"><?php echo number_format($recordsApoyos[$i]["valorNacionalDiplomado"]); ?></td>
                                <td class="column center borderR"><?php echo number_format($recordsApoyos[$i]["valorNacionalTaller"]); ?></td>
                                <td class="column center"><?php $total[$i]["nacional"] = ($recordsApoyos[$i]["valorNacionalCongreso"]+
                                        $recordsApoyos[$i]["valorNacionalDiplomado"]+$recordsApoyos[$i]["valorNacionalTaller"]);
                                        echo number_format($total[$i]["nacional"]); ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column center borderR">Internacional</td>
                                <td class="column center"><?php echo $recordsApoyos[$i]["valorInternacionalCongreso"]; ?></td>
                                <td class="column center"><?php echo $recordsApoyos[$i]["valorInternacionalDiplomado"]; ?></td>
                                <td class="column center borderR"><?php echo $recordsApoyos[$i]["valorInternacionalTaller"]; ?></td>
                                <td class="column center"><?php $total[$i]["internacional"] = ($recordsApoyos[$i]["valorInternacionalCongreso"]+
                                        $recordsApoyos[$i]["valorInternacionalDiplomado"]+$recordsApoyos[$i]["valorInternacionalTaller"]);
                                    echo number_format($total[$i]["internacional"]); ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <th class="column center borderR"><span>Total</span></th>
                                <th class="column center"><?php echo number_format($recordsApoyos[$i]["valorNacionalCongreso"]+
                                        $recordsApoyos[$i]["valorInternacionalCongreso"]); ?></th>
                                <th class="column center"><?php echo number_format($recordsApoyos[$i]["valorInternacionalDiplomado"]+
                                        $recordsApoyos[$i]["valorNacionalDiplomado"]); ?></th>
                                <th class="column center borderR"><?php echo number_format($recordsApoyos[$i]["valorNacionalTaller"]+
                                        $recordsApoyos[$i]["valorInternacionalTaller"]); ?></th>
                                <th class="column center"><?php echo number_format($total[$i]["internacional"]+
                                        $total[$i]["nacional"]); ?></th>
                            </tr>
                        <?php }*/ ?>
                    </tbody>
                </table>
</div>-->
    
    <div id="tabs-6" class="longTable">
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                             <?php $numP = count($recordsIndices["dataPeriodos"]);
                                $colspan = 2 + $numP*4; ?>
                            <th class="column" colspan="<?php echo $colspan; ?>"><span>Índice de selectividad de los académicos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR"  rowspan="2" ><span>Dedicación</span></th>                             
                            <?php                             
                            for ($i = 0; $i < $numP; $i++) { ?>
                                <th class="column borderR" colspan="4"><span><?php echo $recordsIndices["dataPeriodos"][$i]["periodo"]; ?></span></th>
                            <?php } ?>
                        </tr>
                        <tr class="dataColumns category">                            
                            <?php for ($i = 0; $i < $numP; $i++) { ?>                                    
                                        <th class="column "  ><span>Número procesos de selección</span></th> 
                                        <th class="column "  ><span>Número de Aspirantes</span></th> 
                                        <th class="column "  ><span>Número de seleccionados</span></th> 
                                        <th class="column borderR"  ><span>Índice de selectividad</span></th>                                
                                <?php }  ?>     
                        </tr>
                     </thead>
                     <tbody>
                        <?php $num = count($recordsIndices["data"])/count($recordsIndices["dataPeriodos"]);    
                        $totales = array();
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column borderR"><?php echo $recordsIndices["data"][$i]["nombre"]; ?></td>
                                <?php for ($j = 1; $j <= $numP; $j++) { ?>  
                                <td class="column center"><?php echo $recordsIndices["data"][$i*$j]["numProcesosSeleccion"]; 
                                    $totales["numProcesosSeleccion"][$j] = $totales["numProcesosSeleccion"][$j] + $recordsIndices["data"][$i*$j]["numProcesosSeleccion"]; ?></td>
                                <td class="column center "><?php echo ($recordsIndices["data"][$i*$j]["numAspirantes"]);
                                 $totales["numAspirantes"][$j] = $totales["numAspirantes"][$j] + $recordsIndices["data"][$i*$j]["numAspirantes"]; ?></td>
                                <td class="column center "><?php echo ($recordsIndices["data"][$i*$j]["numSeleccionados"]);
                                 $totales["numSeleccionados"][$j] = $totales["numSeleccionados"][$j] + $recordsIndices["data"][$i*$j]["numSeleccionados"]; ?></td>
                                <td class="column center borderR"><?php $index=$recordsIndices["data"][$i*$j]["numSeleccionados"]/$recordsIndices["data"][$i*$j]["numAspirantes"];
                                    if($index == intval($index)){
                                        echo $index;
                                    } else {
                                        echo number_format($index,3);
                                    }
                                 $totales["indice"][$j] = $totales["indice"][$j] + $index;
                                 $totales["contador"][$j] = $totales["contador"][$j] + 1; ?></td>
                                <?php }  ?> 
                            </tr>   
                          <?php }  ?>                               
                            <tr class="dataColumns">
                                <th class="column total center borderR"><span>Total</span></th>
                                <?php for ($j = 1; $j <= $numP; $j++) { ?>  
                                <th class="column total center"><?php echo $totales["numProcesosSeleccion"][$j]; ?></th>
                                <th class="column total center "><?php echo ($totales["numAspirantes"][$j]); ?></th>
                                <th class="column total center"><?php echo $totales["numSeleccionados"][$j]; ?></th>
                                <th class="column total center borderR"><?php echo number_format($totales["indice"][$j]/$totales["contador"][$j],3); ?></th>
                                <?php }  ?> 
                            </tr>  
                    </tbody>
                </table>
</div>
    
    <div id="tabs-7" >
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Académicos desvinculados</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Período</span></th>  
                            <th class="column borderR" ><span>Motivo del retiro</span></th>   
                            <th class="column borderR" ><span>Número de Académicos</span></th>                                 
                        </tr>
                     </thead>
                     <tbody>
                        <?php $num = count($recordsDesvinculados);
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center borderR" rowspan="7"><?php echo $recordsDesvinculados[$i]["codigoperiodo"]; ?></td>
                                <td class="column borderR">Terminación de Contrato</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numTerminacionContrato"]); 
                                $total = $recordsDesvinculados[$i]["numTerminacionContrato"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column borderR">Renuncia por nueva oportunidad laboral</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numRenunciaOportunidad"]); 
                                $total += $recordsDesvinculados[$i]["numRenunciaOportunidad"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column borderR">Renuncia por motivos personales</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numRenunciaMotivosPersonales"]); 
                                $total += $recordsDesvinculados[$i]["numRenunciaMotivosPersonales"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column borderR">Renuncia  por mejores condiciones laborales</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numRenunciaCondicionesLaborales"]); 
                                $total += $recordsDesvinculados[$i]["numRenunciaCondicionesLaborales"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column borderR">Renuncia por viaje</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numRenunciaViaje"]); 
                                $total += $recordsDesvinculados[$i]["numRenunciaViaje"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column borderR">Despido</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numDespido"]); 
                                $total += $recordsDesvinculados[$i]["numDespido"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column borderR">Otro</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numOtro"]); 
                                $total += $recordsDesvinculados[$i]["numOtro"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <th class="column center borderR"><span>Total</span></th>
                                <th class="column center borderR"></th>
                                <th class="column center"><?php echo number_format($total); ?></th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
</div>
    
     <div id="tabs-13">
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Académicos extranjeros por Unidad Académica</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Período</span></th> 
                            <th class="column" ><span>Facultad</span></th> 
                            <th class="column" ><span>Número de Académicos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php $num = count($recordsExtranjerosFacultad["actividades"]);    
                         $numP = count($recordsExtranjerosFacultad["dataPeriodos"]);
                        $totales = array();$periodoAnterior = "";
                        for ($i = 0; $i < $numP; $i++) { ?>
                         <?php for ($j = 0; $j < $num; $j++) {  ?>  
                            <tr class="dataColumns">
                              <?php if($periodoAnterior!=$recordsExtranjerosFacultad["dataPeriodos"][$i]["periodo"]) { $periodoAnterior =$recordsExtranjerosFacultad["dataPeriodos"][$i]["periodo"]; ?>
                                <td class="column borderR center" rowspan="<?php echo $num; ?>"><?php echo $recordsExtranjerosFacultad["dataPeriodos"][$i]["periodo"]; ?></td>
                               <?php } ?>
                                <td class="column borderR"><?php echo $recordsExtranjerosFacultad["actividades"][$j]["nombrefacultad"]; 
                                $data = $utils->getValorDynamic($db,"formTalentoHumanoAcademicosExtranjerosFacultad","codigoperiodo","facultad",$recordsExtranjerosFacultad["dataPeriodos"][$i]["periodo"],$recordsExtranjerosFacultad["actividades"][$j]["codigofacultad"],"codigofacultad","nombrefacultad");
                                    $totales["numAcademicos"][$i] = $totales["numAcademicos"][$i] + $data["valor"]; ?></td>
                                <td class="column center borderR"><?php echo number_format($data["valor"]); ?></td>
                            </tr>    
                            <?php }  ?> 
                            <tr class="dataColumns">
                                <th class="column total "></th>
                                <th class="column total right borderR"><span>Total</span></th>
                                <th class="column total center borderR"><?php echo $totales["numAcademicos"][$i]; ?></th>
                                
                            </tr>  
                            <?php }  ?> 
                     </tbody>
                </table>   
</div>
     
     <div id="tabs-14">
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Académicos extranjeros por país de origen</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Período</span></th> 
                            <th class="column" ><span>País de Origen</span></th> 
                            <th class="column" ><span>Número de Académicos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php $num = count($recordsExtranjerosPais["actividades"]);    
                         $numP = count($recordsExtranjerosPais["dataPeriodos"]);
                        $totales = array();$periodoAnterior = "";
                        for ($i = 0; $i < $numP; $i++) { ?>
                         <?php for ($j = 0; $j < $num; $j++) {  ?>  
                            <tr class="dataColumns">
                              <?php if($periodoAnterior!=$recordsExtranjerosPais["dataPeriodos"][$i]["periodo"]) { $periodoAnterior =$recordsExtranjerosPais["dataPeriodos"][$i]["periodo"]; ?>
                                <td class="column borderR center" rowspan="<?php echo $num; ?>"><?php echo $recordsExtranjerosPais["dataPeriodos"][$i]["periodo"]; ?></td>
                               <?php } ?>
                                <td class="column borderR"><?php echo $recordsExtranjerosPais["actividades"][$j]["nombrepais"]; 
                                $data = $utils->getValorDynamic($db,"formTalentoHumanoAcademicosExtranjerosPais","codigoperiodo","pais",$recordsExtranjerosPais["dataPeriodos"][$i]["periodo"],$recordsExtranjerosPais["actividades"][$j]["idpais"],"","nombrepais");
                                    $totales["numAcademicos"][$i] = $totales["numAcademicos"][$i] + $data["valor"]; ?></td>
                                <td class="column center borderR"><?php echo number_format($data["valor"]); ?></td>
                            </tr>    
                            <?php }  ?> 
                            <tr class="dataColumns">
                                <th class="column total "></th>
                                <th class="column total right borderR"><span>Total</span></th>
                                <th class="column total center borderR"><?php echo $totales["numAcademicos"][$i]; ?></th>
                                
                            </tr>  
                            <?php }  ?> 
                     </tbody>
                </table>   
</div>