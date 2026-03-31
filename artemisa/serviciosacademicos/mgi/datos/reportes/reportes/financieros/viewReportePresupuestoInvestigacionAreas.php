<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    if(isset($_POST['anio'])){
        require_once("../../../templates/template.php");
        $db = getBD();
        $utils = new Utils_datos();

    }//if

     $periodo=$_POST['anio'];

    if(($periodo)) {
        
         //echo $periodo;
         $records =$utils-> getDataViewInvestigaciones($db,$periodo);
         $num = count($records);
          
                 
         //print_r($tnum);
  ?>

<div id="tableDiv">

     <table align="center" class="previewReport" width="100%" >
                    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR"  ><span>Area de Conocimiento</span></th>
                            <th class="column borderR"   ><span>Valor</span></th>
                            <th class="column borderR"  ><span>% de Presupuesto Asignado</span></th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            for ($i = 0; $i < $num; $i++) { 
                               $tval=$tval+$records[$i]["ejecutado"];
                            }
                            $tper=0; 
                             for ($i = 0; $i < $num; $i++) { 
                                //$tval=$tval+$records[$i]["presupuesto"];
                            ?>
                        <tr>
                            <td>
                                <?php echo $records[$i]["clasificacionesinfhuerfana"] ?>
                            </td>
                            <td>
                                <?php echo $records[$i]["ejecutado"] ?>
                            </td>
                            <td>
                                <?php echo $records[$i]["ejecutado"]/$tval ?>
                            </td>
                          </tr>
                         <?php }?> 
                          <tr>
                            <td>
                                TOTAL
                            </td>
                             <td>
                                <?php echo $tval ?>
                            </td>
                            <td>
                                <?php echo $tval/$tval ?>
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
				url: './reportes/financieros/viewReportePresupuestoInvestigacionAreas.php',
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