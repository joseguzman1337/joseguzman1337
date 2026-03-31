<?php 
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
function getPlantillaConsulta($db,$tipo){ ?>
	
                <div class="formModalidad">
                     <?php $rutaModalidad = "./_elegirProgramaAcademico.php";
					 //echo "1";
					 if(!is_file($rutaModalidad)){
						$rutaModalidad = './formularios/academicos/_elegirProgramaAcademico.php';
						//echo "2";
					 }
					 if(!is_file($rutaModalidad)){
						$rutaModalidad = dirname(__FILE__).'/academicos/_elegirModalidadAcademica.php';
						//echo "3";
					 }
					include($rutaModalidad);  ?>
                </div>
                
                <div class="vacio"></div>
                
				<?php if($tipo==="m") { ?>
					<label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
					<?php $utils->getMonthsSelect();  ?>
					
					<label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
					<?php $utils->getYearsSelect("anio");  ?>
					<div class="vacio"></div>
					<span style="margin-left:220px;position:relative;top:-10px;">a</span>
					<div class="vacio"></div>
					<label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
					<?php $utils->getMonthsSelect("mes2");  ?>
					
					<label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
					<?php $utils->getYearsSelect("anio2");    

				} else if($tipo==="s") {  ?>
					<label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
					<?php $utils->getSemestresSelect($db,"codigoperiodo");  
					?>
					<div class="vacio"></div>
					<span style="margin-left:220px;position:relative;top:-10px;">a</span>
					<div class="vacio"></div>
					
					<label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
					<?php $utils->getSemestresSelect($db,"codigoperiodo2");  
					?>
				<?php } ?>
                
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                
                <div class="vacio"></div>
	
<?php } 

function getPlantillaConsultaSimple($db,$tipo){ ?>
	
                <div class="formModalidad">
                     <?php $rutaModalidad = "./_elegirProgramaAcademico.php";
					 if(!is_file($rutaModalidad)){
						$rutaModalidad = './formularios/academicos/_elegirProgramaAcademico.php';
					 }
					 if(!is_file($rutaModalidad)){
						$rutaModalidad = dirname(__FILE__).'/academicos/_elegirModalidadAcademica.php';
					 }
					include($rutaModalidad);  ?>
                </div>
                
                <div class="vacio"></div>
                
				<?php if($tipo==="m") { ?>
					<label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
					<?php $utils->getMonthsSelect();  ?>
					
					<label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
					<?php $utils->getYearsSelect("anio");  ?>
					
					<?php    
				} else if($tipo==="s") {  ?>
					<label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
					<?php $utils->getSemestresSelect($db,"codigoperiodo");  
					?>
					
				<?php } ?>
                
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                                 
                <div class="vacio"></div>
	
<?php } ?>