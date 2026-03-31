<?php

                
session_start();
    if(isset($_POST['semestre'])){
        require_once("../../../templates/template.php");
        $db = getBD();
        $utils = new Utils_datos();

    }//if

     $periodo=$_POST['semestre'];

    if(($periodo)) {
        
         //echo $periodo;
         $records =$utils->getDataViewExtran($db,$periodo);
         $num = count($records);
          
                 
        //echo "<pre>"; print_r($records);
  ?>

<div id="tableDiv">

     <table align="center" class="previewReport" class="previewReport" width="70%" >
                    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" ><span>Programa Académico</span></th>
                           <th class="column borderR" ><span>Número de Académicos</span></th>
                             
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            $tper=0; $tval=0;
                             for ($i = 0; $i < $num; $i++) { 
                                $tval=$tval+$records[$i]["valor"];
                            ?>
                        <tr class="dataColumns">
                            <td>
                                <?php echo $records[$i]["nombre"] ?>
                            </td>
                            <td class="center">
                                <?php echo $records[$i]["valor"] ?>
                            </td>
                          </tr>
                         <?php }?> 
                          <tr class="dataColumns">
                            <th class="column center borderR">
                                TOTAL
                            </th>
                             <th class="column center borderR">
                                <?php echo $tval ?>
                            </th>
                        </tr>                      
                    </tbody>
     </table> 
</div>
  <?php 
  exit;
                             } //if periodo?>
  
                 <form name="periodo_doc" id="periodo_doc" method="post" action="" class="report">
				 <br/>
                        <span class="mandatory">* Son campos obligatorios</span>

                          <fieldset> 
                              <label for="semestre" class="grid-2-12">Semestre:  <span class="mandatory">(*)</span></label>
							<?php if(isset($_REQUEST["semestre"])) {$utils->getSemestresSelect($db,"semestre",false,$_REQUEST["semestre"]); } 
								else { $utils->getSemestresSelect($db,"semestre"); } ?>
                            <input type="submit" value="Consultar" id="consultar" name="consultar" class="first small" /><br/>
                    <br/><div id='respuesta_form1_au'></div>
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
				url: './reportes/docentes/viewReporteAcademicosExtranjerosPorFacultad.php',
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