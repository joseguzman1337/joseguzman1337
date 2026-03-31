<?php

                
session_start();
    if(isset($_POST['semestre'])){
        require_once("../../../templates/template.php");
        $db = getBD();
        $utils = new Utils_datos();

    }//if

     $periodo=$_POST['semestre'];

    if(($periodo)) {
        
         
         $records =$utils-> getDataViewTacadForm($db,$periodo);
         $num = count($records);
         
                 
         //print_r($tnum);
  ?>

<div id="tableDiv">

     <table align="center" class="previewReport" width="100%" >
                    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" rowspan="2" ><span>MAYOR NIVEL DE FORMACIÓN</span></th>
                           <th class="column borderR" colspan="2"  ><span><?php echo $periodo ; ?></span></th>
                             
                        </tr>
                        <tr id="dataColumns">
                            <th class="column borderR" rowspan="1"><span>Numero</span></th>
                              <th class="column borderR" rowspan="1" ><span>Porcentaje</span></th>
                        </tr>
                        <tr>
                            <td <span>Tecnico/Tecnologo</span></td>
                            <?php
                            
                             for ($i = 0; $i < $num; $i++) { 
                                 $sum=$records[$i]["numAcademicosTecnico"]+$records[$i]["numAcademicosLicenciado"]+$records[$i]["numAcademicosProfesional"]+
                                                $records[$i]["numAcademicosEspecializacion"]+$records[$i]["numAcademicosEnEspecializacion"]+
                                                $records[$i]["numAcademicosMaestria"]+$records[$i]["numAcademicosEnMaestria"]+$records[$i]["numAcademicosDoctorado"]+$records[$i]["numAcademicosEnDoctorado"];
                                  //  print_r( $sum);
                            ?>
                              
                                    
                                    <td><span><?php echo $records[$i]["numAcademicosTecnico"]; ?></span></td>
                                    <td><?php  ($num_t=($records[$i]["numAcademicosTecnico"])/$sum); echo number_format($num_t,3,".",","); ?></td>
                            
                        </tr>
                        <tr>
                          <td>  <span>Licenciado</span></td>
                           <td ><?php echo $records[$i]["numAcademicosLicenciado"]; ?></td>
                          <td><?php  ($num_t=($records[$i]["numAcademicosLicenciado"])/$sum); echo number_format($num_t,3,".",","); ?></td>
                        </tr>
                        <tr>
                          <td>  <span>Pregrado</span></td>
                          <td ><?php echo $records[$i]["numAcademicosProfesional"]; ?></td>
                          <td><?php  ($num_t=($records[$i]["numAcademicosProfesional"])/$sum); echo number_format($num_t,3,".",","); ?></td>
                        </tr>
                        <tr>
                            <td><span>Especialización</span></td>
                            <td><?php echo $records[$i]["numAcademicosEspecializacion"]; ?></td>
                            <td><?php  ($num_t=($records[$i]["numAcademicosEspecializacion"])/$sum); echo number_format($num_t,3,".",","); ?></td>
                        </tr>
                         <tr>
                            <td><span>Especialización en Curso</span></td>
                            <td><?php echo $records[$i]["numAcademicosEnEspecializacion"]; ?></td>
                            <td><?php  ($num_t=($records[$i]["numAcademicosEnEspecializacion"])/$sum); echo number_format($num_t,3,".",","); ?></td>
                        </tr>
                         <tr>
                           <td><span>Maestria</span></td>
                           <td ><?php echo $records[$i]["numAcademicosMaestria"]; ?></td>
                           <td><?php  ($num_t=($records[$i]["numAcademicosMaestria"])/$sum); echo number_format($num_t,3,".",","); ?></td>
                         </tr>
                         <tr>
                           <td><span>Maestria en Curso</span></td>
                           <td><?php echo $records[$i]["numAcademicosEnMaestria"]; ?></td>
                           <td><?php  ($num_t=($records[$i]["numAcademicosEnMaestria"])/$sum); echo number_format($num_t,3,".",","); ?></td>
                        </tr>
                        <tr>
                           <td><span>Doctorado</span></td>
                            <td><?php echo $records[$i]["numAcademicosDoctorado"]; ?></td>
                            <td><?php  ($num_t=($records[$i]["numAcademicosDoctorado"])/$sum); echo number_format($num_t,3,".",","); ?></td>
                        </tr>
                        <tr>
                            <td> <span>Doctorado en Curso</span></td>
                             <td><?php echo $records[$i]["numAcademicosEnDoctorado"]; ?></td>
                             <td><?php  ($num_t=($records[$i]["numAcademicosEnDoctorado"])/$sum); echo number_format($num_t,3,".",","); ?></td>
                        </tr>
                        <tr id="dataColumns">
                            <td class="column borderR"> <span>Total</span></td>
                             <td class="column borderR"><?php echo  $sum; ?></td>
                             <td class="column borderR"><?php  ($num_t=$sum/$sum); echo number_format($num_t,3,".",","); ?></td>
                        </tr>
                        
                      						
                        
                   </thead>
                    <tbody>  
                        
                         <?php }exit;?> 
                                                
                    </tbody>
     </table> 
</div>
  <?php } //if periodo?>
      
                <form name="periodo_doc" id="periodo_doc" method="post" action="">
                        <span class="mandatory">* Son campos obligatorios</span>

                          <fieldset> 
                            <label for="semestre" class="grid-2-12">Semestre:  <span class="mandatory">(*)</span></label><?php $utils->getSemestresSelect($db,"semestre"); ?> 
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
				url: './reportes/docentes/viewReporteNivelFormacionAcademicos.php',
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






