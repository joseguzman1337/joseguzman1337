<?php

                
session_start();
    if(isset($_POST['semestre'])){
        require_once("../../../templates/template.php");
        $db = getBD();
        $utils = new Utils_datos();

    }//if

     $periodo=$_POST['semestre'];

    if(($periodo)) {
        
         
         $records =$utils-> getDataViewPresServ($db,$periodo);
		 //echo "<pre>";print_r($records);
		 $val = $records[1]["costoServicios"];
		 $records = $records[0];
         $num = count($records);
         
                 
         //print_r($tnum);
  ?>

<div id="tableDiv">

     <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;" width="70%" >
        <thead>       			
			<tr id="dataColumns">
                            <th class="column borderR" rowspan="1" ><span>Actividad</span></th>  
                            <th class="column borderR" rowspan="1"><span>Número de personas</span></th>                           
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            $tper=0; $tval=0;
							for($i=0;$i<$num;$i++){
                                $tper=$tper+$records[$i]["numPersonas"];
                                $tval=$tval+$records[$i]["ValorServicios"];
                            ?>
                        <tr class="dataColumns">
                            <td>
                                <?php echo $records[$i]["nombre"] ?>
                            </td>
                            <td class="center">
                                <?php echo $records[$i]["numPersonas"] ?>
                            </td>
                        </tr>
						<?php } ?>
                          <tr class="dataColumns">
                            <th class="column center borderR">
                                Total
                            </th>
                            <th class="center">
                                <?php echo $tper ?>
                            </th>
                        </tr>    
                          <tr  class="dataColumns">
                            <th class="column center borderR">
                                Valor total mensual de los servicios
                            </th>
                            <th class="column center borderR">
                                <?php if($val){echo "$".number_format($val,0,".",","); } else { echo "$0";} ?>
                            </th>
                        </tr>  
					
                    </tbody>
     </table> 
</div>
  <?php 
  exit;
                             } //if periodo?>
      
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
				url: './reportes/docentes/viewReportePersonalPrestacionServicios.php',
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