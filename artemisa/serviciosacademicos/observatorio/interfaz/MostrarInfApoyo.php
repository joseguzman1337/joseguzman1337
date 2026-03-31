<?php 
   require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
  mysql_select_db($database_sala, $sala);


$idobs_estudiante_tutor = $_REQUEST['idobs_estudiante_tutor'];
$idApoyo = $_REQUEST['idApoyo'];


              $apEstudiante = " SELECT * 
              from obs_estudiante_tutor
              Where  
              idobs_estudiante_tutor = '".$idobs_estudiante_tutor."'";

              $apoyoEstudiante = mysql_query($apEstudiante, $sala) or die(mysql_error());
              $apoyoEstudianteDatos = mysql_fetch_assoc($apoyoEstudiante);


              $sql_tiporiesgo = " SELECT * 
              from obs_estudiante_tutor_tipo_riesgoPAE
              Where  
              idobs_estudiante_tutor = '".$idobs_estudiante_tutor."'";

              $queryRiesgo = mysql_query($sql_tiporiesgo, $sala) or die(mysql_error());


              $sql_otrosApoyos = " SELECT * 
              from obs_estudiante_tutor_otrosapoyosPAE
              Where  
              idobs_estudiante_tutor = '".$idobs_estudiante_tutor."'";

              $query_otrosApoyos = mysql_query($sql_otrosApoyos, $sala) or die(mysql_error());

              //$Observacion = nl2br($apoyoEstudianteDatos['Observacion']);


              $a = htmlentities($apoyoEstudianteDatos['Observacion']);

			  $Observacion = html_entity_decode($a);
              



?>

<!-- <textarea><?php echo htmlspecialchars($apoyoEstudianteDatos['Observacion'])?></textarea>        -->
<script type="text/javascript">
    


            $('#modal').modal();
            // $('#fechaAtencion').slideUp();
            // $('#fechaAtencion2').slideDown();
            $('#guardar').slideUp();
            $('#FechaRegistro').text("Fecha de registro: "+"<?php echo $apoyoEstudianteDatos['fechacreacion']?>");
            $('#FechaRegistro').slideDown();
            $("#idActualizar").val("<?php echo $idobs_estudiante_tutor ?>");


			
			$idA = <?php echo $idApoyo?>;
			document.getElementById("idRemision").value = "<?php echo $apoyoEstudianteDatos['IdTipoApoyo'] ?>";

            if($idA==26){


            	$('#riesgoPae').slideDown();
              $('#tutoriaPaeob').slideDown();
              // $('#resumenGen').slideUp();

              // $('#Pae').slideDown();
              // $('#Pares').slideUp();
              // $('#Psico').slideUp();
              // $('#Lpl').slideUp();
              // $('#Fin').slideUp();

            	
            // 	$( "#canalContacto" ).attr({
	           //      disabled: "disabled"
	           //  });
	           //  $( "#Lugar" ).attr({
	           //      disabled: "disabled"
	           //  });
	           //  $( "#profesionalAtencion" ).attr({
	           //      disabled: "disabled"
	           //  });
	           //  $( "#Observacion" ).attr({
	           //      disabled: "disabled"
	           //  });
	           //  $( "#RemGeneral" ).attr({
	           //      disabled: "disabled"
	           //  });
	            





	            
	           //  $( "#riesgoAcademico" ).attr({
	           //      disabled: "disabled"
	           //  });
	           //  $( "#riesgoEconomico" ).attr({
	           //      disabled: "disabled"
	           //  });
	           //  $( "#riesgoPsicosocial" ).attr({
	           //      disabled: "disabled"
	           //  });
	           //  $( "#riesgoInstitucional" ).attr({
	           //      disabled: "disabled"
	           //  });
	           //  $( "#riesgoOtras" ).attr({
	           //      disabled: "disabled"
	           //  });
	           //  $( "#TipoApoyo" ).attr({
	           //      disabled: "disabled"
	           //  });
	            


	          	
	          	// $( "#nivelAcademico" ).attr({
	           //      disabled: "disabled"
	           //  });
	          	// $( "#nivelEconomico" ).attr({
	           //      disabled: "disabled"
	           //  });
	          	// $( "#nivelPsicosocial" ).attr({
	           //      disabled: "disabled"
	           //  });
	          	// $( "#nivelInstitucional" ).attr({
	           //      disabled: "disabled"
	           //  });
	          	// $( "#nivelOtras" ).attr({
	           //      disabled: "disabled"
	           //  });
	            
	            

				document.getElementById('canalContacto').value="<?php echo $apoyoEstudianteDatos['IdCanalContacto'] ?>";
				// document.getElementById('fechaAtencion2').value="<?php echo $apoyoEstudianteDatos['FechaAtencion'] ?>";
				var dateControl = document.querySelector('input[name=fechaAtencion]');
				dateControl.value = formatDate(new Date("<?php echo $apoyoEstudianteDatos['FechaAtencion'] ?>"), "yyyy-MM-dd");
				

				document.getElementById('Lugar').value="<?php echo $apoyoEstudianteDatos['Lugar'] ?>";
				document.getElementById('profesionalAtencion').value="<?php echo $apoyoEstudianteDatos['ProfesionalQueHaceAtencion'] ?>";
				document.getElementById('Observacion').value="<?php  echo htmlspecialchars($apoyoEstudianteDatos['Observacion']) ?>";
			

				

				<?php 

				while($tiporiesgo = mysql_fetch_assoc($queryRiesgo)){

					$val = $tiporiesgo['IdTipoRiesgo'];

					if($val>=6 && $val<=13){


						?>

						$("#riesgoAcademico option[value=<?php echo $tiporiesgo['IdTipoRiesgo']?>]").attr("selected",true);
						document.getElementById('nivelAcademico').value="<?php echo $tiporiesgo['ValoracionRiesgo'] ?>";


						<?php



					}

					if($val>=14 && $val<=15){


						?>

						$("#riesgoEconomico option[value=<?php echo $tiporiesgo['IdTipoRiesgo']?>]").attr("selected",true);
						document.getElementById('nivelEconomico').value="<?php echo $tiporiesgo['ValoracionRiesgo'] ?>";

						<?php



					}

					if($val>=16 && $val<=21){


						?>

						$("#riesgoPsicosocial option[value=<?php echo $tiporiesgo['IdTipoRiesgo']?>]").attr("selected",true);
						document.getElementById('nivelPsicosocial').value="<?php echo $tiporiesgo['ValoracionRiesgo'] ?>";

						<?php



					}


					if($val>=22 && $val<=23){


						?>

						$("#riesgoInstitucional option[value=<?php echo $tiporiesgo['IdTipoRiesgo']?>]").attr("selected",true);
						document.getElementById('nivelInstitucional').value="<?php echo $tiporiesgo['ValoracionRiesgo'] ?>";

						<?php



					}


					if($val>=23 && $val<=26){


						?>

						$("#riesgoOtras option[value=<?php echo $tiporiesgo['IdTipoRiesgo']?>]").attr("selected",true);
						document.getElementById('nivelOtras').value="<?php echo $tiporiesgo['ValoracionRiesgo'] ?>";

						<?php



					}
				}



				?>


				<?php 

				while($otrosApoyos = mysql_fetch_assoc($query_otrosApoyos)){

				


						?>

						$("#TipoApoyo option[value=<?php echo $otrosApoyos['IdOtroApoyo']?>]").attr("selected",true);

						<?php



					

				}

				?>

				
				//$('#riesgoAcademico option').prop('selected', true);


            }else{

              $('#riesgoPae').slideUp();
              $('#resumenGen').slideDown();
              $('#tutoriaPaeob').slideUp();

              if ($idA==27){

	              $('#Pae').slideUp();
	              $('#Pares').slideDown();
	              $('#Psico').slideUp();
	              $('#Lpl').slideUp();
	              $('#Fin').slideUp();

              }
              if ($idA==28){

	              $('#Pae').slideUp();
	              $('#Pares').slideUp();
	              $('#Psico').slideDown();
	              $('#Lpl').slideUp();
	              $('#Fin').slideUp();
              	
              }
              if ($idA==29){

	              $('#Pae').slideUp();
	              $('#Pares').slideUp();
	              $('#Psico').slideUp();
	              $('#Lpl').slideDown();
	              $('#Fin').slideUp();
              	
              }
              if ($idA==30){

	              $('#Pae').slideUp();
	              $('#Pares').slideUp();
	              $('#Psico').slideUp();
	              $('#Lpl').slideUp();
	              $('#Fin').slideDown();
              	
              }

	           	// $( "#canalContacto" ).attr({
	            //     disabled: "disabled"
	            // });
	            // $( "#Lugar" ).attr({
	            //     disabled: "disabled"
	            // });
	            // $( "#profesionalAtencion" ).attr({
	            //     disabled: "disabled"
	            // });
	            // $( "#Observacion2" ).attr({
	            //     disabled: "disabled"
	            // });
	            // $( "#RemGeneral" ).attr({
	            //     disabled: "disabled"
	            // });


				document.getElementById('canalContacto').value="<?php echo $apoyoEstudianteDatos['IdCanalContacto'] ?>";
				// document.getElementById('fechaAtencion2').value="<?php echo $apoyoEstudianteDatos['FechaAtencion'] ?>";
				var dateControl = document.querySelector('input[name=fechaAtencion]');
				dateControl.value = formatDate(new Date("<?php echo $apoyoEstudianteDatos['FechaAtencion'] ?>"), "yyyy-MM-dd");

				document.getElementById('Lugar').value="<?php echo $apoyoEstudianteDatos['Lugar'] ?>";
				document.getElementById('profesionalAtencion').value="<?php echo $apoyoEstudianteDatos['ProfesionalQueHaceAtencion'] ?>";
				document.getElementById('Observacion2').value="<?php echo nl2br($apoyoEstudianteDatos['Observacion']) ?>";
				document.getElementById('RemGeneral').value="<?php echo $apoyoEstudianteDatos['ResumenGeneralAtencion'] ?>";


            }





    
</script>