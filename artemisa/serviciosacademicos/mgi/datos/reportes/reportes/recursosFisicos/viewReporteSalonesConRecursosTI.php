<?php

                
session_start();
    if(isset($_POST['anio'])){
        require_once("../../../templates/template.php");
        $db = getBD();
        $utils = new Utils_datos();

    }//if

     $periodo=$_POST['anio'];

    if(($periodo)) {
        
         //echo $periodo;
         $recordsSP =$utils-> getSalonesPerio($db,$periodo);
         $recordsS =$utils-> getSalones($db);
         $num = count($records);
          
                 
         //print_r($tnum);
  ?>

<div id="tableDiv">

     <table align="center" class="previewReport" width="100%" >
                    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" rowspan="2" ><span></span></th>
                           <th class="column borderR" colspan="2"  ><span>Numero</span></th>
                             
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                N&uacute;mero de salones dotados con recursos y equipos audiovisuales e inform&aacute;ticos de apoyo / N&uacute;mero total de salones
                            </td>
                            <td>
                                <?php 
                                $to=round($recordsSP[0]["total"]/$recordsS[0]['total'],4);
                                echo $to ?>
                            </td>
                          </tr>              
                    </tbody>
     </table> 
</div>
  <?php 
  exit;
                             } //if periodo?>
      
                <form name="periodo_doc" id="periodo_doc" method="post" action="">
                        <span class="mandatory">* Son campos obligatorios</span>

                          <fieldset> 
                              <label for="semestre" class="grid-2-12">A&ntilde;o:  <span class="mandatory">(*)</span></label><?php $utils->getYearsSelect("anio"); ?> 
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
				url: './reportes/recursosFisicos/viewReporteSalonesConRecursosTI.php',
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