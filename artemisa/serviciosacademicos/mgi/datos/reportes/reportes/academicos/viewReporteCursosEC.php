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
         $records =$utils-> getDataViewCursosEC($db,$periodo);
         $num = count($records);
          
                 
         //print_r($tnum);
  ?>

<div id="tableDiv">

     <table align="center" class="previewReport" width="100%" >
                    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" rowspan="2" ><span>CURSOS (Duraci&oacute;n m&iacute;nima de 8 horas)</span></th>
                            <th class="column borderR" colspan="2"  ><span>A&ntilde;o</span></th>
                             
                        </tr>
                        <tr id="dataColumns">
                            <th class="column borderR"  ><span>Cantidad</span></th>
                            <th class="column borderR"  ><span>Porcentaje</span></th>
                             
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            $tper=0; $tval=0;
                             for ($i = 0; $i < $num; $i++) { 
                                $canT=$canT+($records[$i]["num_abierto"]+$records[$i]["num_cerrado"]);
                               
                             }
                             
                             for ($i = 0; $i < $num; $i++) { 
                                $tval=$tval+$records[$i]["valor"];
                                $can=$records[$i]["num_abierto"]+$records[$i]["num_cerrado"];
                                $pro=$can/$canT;
    
                                $cnT1=$cnT1+$can;
                                $cpro=$cpro+$pro;
                            ?>
                        <tr>
                            <td>
                                <?php echo $records[$i]["clasificacion"] ?>
                            </td>
                            <td>
                                <?php echo $can ?>
                            </td>
                            <td>
                                <?php echo $pro ?>
                            </td>
                          </tr>
                         <?php }?> 
                          <tr>
                            <td>
                                TOTAL
                            </td>
                             <td>
                                <?php echo $cnT1 ?>
                            </td>
                             <td>
                                <?php echo $cpro ?>
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
				url: './reportes/academicos/viewReporteCursosEC.php',
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