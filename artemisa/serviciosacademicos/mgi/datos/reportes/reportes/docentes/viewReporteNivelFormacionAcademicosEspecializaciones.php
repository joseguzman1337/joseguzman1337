<?php

                
session_start();
    if(isset($_POST['semestre'])){
        require_once("../../../templates/template.php");
        $db = getBD();
        $utils = new Utils_datos();

    }//if

     $periodo=$_POST['semestre'];

    if(($periodo)) {
        
         
         $records =$utils-> getDataViewTacadEspe($db,$periodo);
         //$num = count($records);
         $num = 1;
                 
         //print_r($tnum);
  ?>

<div id="tableDiv">

     <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;" width="70%" >
        <thead>    
                          <tr id="dataColumns">
						  <th class="column borderR" rowspan="2" ><span>Titulo</span></th>
                           <th class="column borderR" colspan="2"  ><span><?php echo $periodo; ?></span></th>
                             
                        </tr>
                        <tr id="dataColumns">
                            <th class="column borderR" rowspan="1"><span>Número Académicos</span></th>
                              <th class="column borderR" rowspan="1" ><span>Porcentaje</span></th>
                        </tr>
        </thead>   			
		<tbody>
                            <?php
                                 $sum=$records["numAcademicosDoctoradoMedico"]+$records["numAcademicosMaestriaMedico"]+ $records["numAcademicosEspecializacionMedico"]+ $records["numAcademicosProfesionalMedico"]+ $records["numAcademicosLicenciadoMedico"]+ $records["numAcademicosTecnicoMedico"]+ $records["numAcademicosNoTituloMedico"];
                                                   //print_r( $sum);
                            ?>
                           <td><span>T.Doctorado</span></td>
                            <td class="center"><?php echo $records["numAcademicosDoctoradoMedico"]; ?></td>
                            <td class="center"><?php  ($num_t=($records["numAcademicosDoctoradoMedico"])/$sum); echo number_format($num_t*100,2,".",","); ?></td>
                        </tr>
                        <tr>
                           <td><span>T.Maestria</span></td>
                           <td class="center"><?php echo $records["numAcademicosMaestriaMedico"]; ?></td>
                           <td class="center"><?php  ($num_t=($records["numAcademicosMaestriaMedico"])/$sum); echo number_format($num_t*100,2,".",","); ?></td>
                         </tr>
                        <tr>
                            <td><span>T.Especialización</span></td>
                            <td class="center"><?php echo $records["numAcademicosEspecializacionMedico"]; ?></td>
                            <td class="center"><?php  ($num_t=($records["numAcademicosEspecializacionMedico"])/$sum); echo number_format($num_t*100,2,".",","); ?></td>
                        </tr>
                        <tr>
                            <td><span>T.Profesional</span></td>
                            <td class="center"><?php echo $records["numAcademicosProfesionalMedico"]; ?></td>
                            <td class="center"><?php  ($num_t=($records["numAcademicosProfesionalMedico"])/$sum); echo number_format($num_t*100,2,".",","); ?></td>
                        </tr>
                        <tr>
                            <td><span>T.Licenciado</span></td>
                            <td class="center"><?php echo $records["numAcademicosLicenciadoMedico"]; ?></td>
                            <td class="center"><?php  ($num_t=($records["numAcademicosLicenciadoMedico"])/$sum); echo number_format($num_t*100,2,".",","); ?></td>
                        </tr>
                        <tr>
                            <td><span>T. Técnico/ Tecnólogo</span></td>
                            <td class="center"><?php echo $records["numAcademicosTecnicoMedico"]; ?></td>
                            <td class="center"><?php  ($num_t=($records["numAcademicosTecnicoMedico"])/$sum); echo number_format($num_t*100,2,".",","); ?></td>
                        </tr>
                        <tr>
                            <td><span>Sin Titulo</span></td>
                            <td class="center"><?php echo $records["numAcademicosNoTituloMedico"]; ?></td>
                            <td class="center"><?php  ($num_t=($records["numAcademicosNoTituloMedico"])/$sum); echo number_format($num_t*100,2,".",","); ?></td>
                        </tr>
                         <tr>
                            <td><span>Total</span></td>
                            <td class="center"><?php echo $sum; ?></td>
                            <td class="center"><?php  ($num_t=$sum/$sum); echo number_format($num_t*100,2,".",","); ?></td>
                        </tr>
                                                
                    </tbody>
					<?php exit;?> 
     </table> 
</div>
  <?php } //if periodo?>
      
                <form name="periodo_doc" id="periodo_doc" method="post" action="" class="report">
                        <span class="mandatory">* Son campos obligatorios</span>

                          <fieldset> 
                            <label for="semestre" class="grid-2-12">Semestre:  <span class="mandatory">(*)</span></label>
							<?php if(isset($_REQUEST["semestre"])) {$utils->getSemestresSelect($db,"semestre",false,$_REQUEST["semestre"]); } 
								else { $utils->getSemestresSelect($db,"semestre"); } ?>
                            <input type="submit" value="consultar" id="consultar" name="consultar"class="first small" />
                         </fieldset>
                    <div id='respuesta_form1_au'></div>
                    
               </form>
   


<script type="text/javascript">
	$(':submit').click(function(event) {
            
		event.preventDefault();
		var valido= validateForm("#periodo_doc");
		if(valido){
                    
			sendForm_un();
		}//valido
	
	function sendForm_un(){
                datos = $('#periodo_doc').serialize();
               // alert (datos);
		$.ajax({
				type: 'POST',
				url: './reportes/docentes/viewReporteNivelFormacionAcademicosEspecializaciones.php',
				async: false,
				data: datos ,                
				success:function(data){					
					$('#respuesta_form1_au').html(data);
                                },//succes,
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		}); //ajax
	
            }//function
        });//submit
</script>






