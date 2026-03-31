<?php

                
session_start();
    if(isset($_POST['semestre'])){
        require_once("../../../templates/template.php");
        $db = getBD();
        $utils = new Utils_datos();

    }//if

     $periodo=$_POST['semestre'];

    if(($periodo)) {
        
         
         $records =$utils->getDataViewTacadForm($db,$periodo);
		 //echo "<pre>";print_r($records);
         $num = 1;
         
                 
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
                                 $sum=$records["numAcademicosEnDoctorado"]+$records["numAcademicosEnMaestria"]+ $records["numAcademicosEnEspecializacion"];
                                                   //print_r( $sum);
                            ?>
                           <td><span>Doctorado</span></td>
                            <td class="center"><?php echo $records["numAcademicosEnDoctorado"]; ?></td>
                            <td class="center"><?php  ($num_t=($records["numAcademicosEnDoctorado"])/$sum); echo number_format($num_t*100,2,".",","); ?></td>
                        </tr>
                        <tr>
                           <td><span>Maestria</span></td>
                           <td class="center"><?php echo $records["numAcademicosEnMaestria"]; ?></td>
                           <td class="center"><?php  ($num_t=($records["numAcademicosEnMaestria"])/$sum); echo number_format($num_t*100,2,".",","); ?></td>
                         </tr>
                        <tr>
                            <td><span>Especialización</span></td>
                            <td class="center"><?php echo $records["numAcademicosEnEspecializacion"]; ?></td>
                            <td class="center"><?php  ($num_t=($records["numAcademicosEnEspecializacion"])/$sum); echo number_format($num_t*100,2,".",","); ?></td>
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
				<br>
                        <span class="mandatory">* Son campos obligatorios</span>

                          <fieldset> 
                            <label for="semestre" class="grid-2-12">Semestre:  <span class="mandatory">(*)</span></label>
							<?php if(isset($_REQUEST["semestre"])) {$utils->getSemestresSelect($db,"semestre",false,$_REQUEST["semestre"]); } 
								else { $utils->getSemestresSelect($db,"semestre"); } ?>
                            <input type="submit" value="Consultar" id="consultar" name="consultar" class="first small" />
                    <div id='respuesta_form1_au'></div>
                         </fieldset>                    
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
				url: './reportes/docentes/viewReporteDocentesEnFormacion.php',
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






