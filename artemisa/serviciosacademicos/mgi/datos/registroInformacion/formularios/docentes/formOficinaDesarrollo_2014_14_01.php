<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({
                    cache: true,
		beforeLoad: function( event, ui ) {
			ui.jqXHR.error(function() {
				ui.panel.html(
				"Ocurrio un problema cargando el contenido." );
				});
			}
		});
        
        $("#tabs").plusTabs({
   			className: "plusTabs", //classname for css scoping
   			seeMore: true,  //initiate "see more" behavior
   			seeMoreText: "Ver más formularios", //set see more text
   			showCount: true, //show drop down count
   			expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
   			dropWidth: "auto", //width of dropdown
 			sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
   		});
	});
</script>

<?php
$utils = new Utils_datos();
$urlprocesa="./formularios/".$categoria["alias"]."/save".$formulario["alias"].".php";

//echo $urlprocesa;
//print_r($categoria);

/*$query_sectores = "select idsiq_sectores,nombre_sector from siq_sectores where idsiq_sectores not in(500,600) and codigoestado like '1%'";
                $sectores= $db->Execute($query_sectores);
                $totalRows_sectores = $sectores->RecordCount();
                //$row_sectores = $sectores->FetchRow();
*/
/*$query_sectores2 = "select idsiq_sectores,nombre_sector from siq_sectores where idsiq_sectores not in(500) and codigoestado like '1%'";
                $sectores2= $db->Execute($query_sectores2);
                $totalRows_sectores2 = $sectores2->RecordCount();*/

?>

<div id="tabs" class="dontCalculate">
				<ul>
					<li><a href="#tabs-1">Convenio Cooperación</a></li>
					<li><a href="./formularios/docentes/formOficinaDesarrolloProyeccion.php">Proyección Social</a></li>
					<li><a href="./formularios/docentes/formOficinaDesarrolloMedios.php">Medios de Comunicación</a></li>
					<li><a href="./formularios/docentes/formOficinaDesarrolloRedes.php">Redes Nacionales e Internacionales</a></li>
					<li><a href="./formularios/docentes/formOficinaDesarrolloAsociaciones.php">Redes y Asociaciones Institucionales</a></li>
				</ul>
<div id="tabs-1">
<form action="save.php" method="post" id="form_test">                      
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>
		<?php
		$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='cocoin'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();
		?>
                <legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio");
                $utils->pintarBotonCargar("popup_cargarDocumento(6,1,$('#form_test #anio').val())","popup_verDocumentos(6,1,$('#form_test #anio').val())");?>
                
                <table align="center" id="estructuraReporte"  class="formData last" width="92%">
                    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" rowspan="2"><span>Sector</span></th>
                            <th class="column" colspan="2"><span>Tipo de Convenio</span></th>
			</tr>	
			<tr id="dataColumns">
                            <th class="column" ><span>Nacional</span></th>
                            <th class="column"><span>Internacional</span></th>
			</tr>
                   </thead>
		   <tbody>

        <?php
	$query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' and aliasclasificacionesinfhuerfana is null order by clasificacionesinfhuerfana";
                $sectores= $db->Execute($query_sectores);
                $totalRows_sectores = $sectores->RecordCount();
        while($row_sectores = $sectores->FetchRow()){
        ?>
        <tr id="contentColumns" class="row">        
                <td class="column borderR" >
                    <?php echo $row_sectores['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span>
                </td>		
		<td class="column" >
                    <input type="text" class="required number" minlength="" name="<?php echo $row_papa['clasificacionesinfhuerfana'].'/'.$row_sectores['idclasificacionesinfhuerfana']; ?>/nacional" id="<?php echo $row_papa['clasificacionesinfhuerfana'].'/'.$row_sectores['idclasificacionesinfhuerfana']; ?>/nacional" title="Nacional" maxlength="60" tabindex="1" autocomplete="off" size="20" />
                </td>
                <td class="column" >
                    <input type="text" class="required number" minlength="" name="<?php echo $row_papa['clasificacionesinfhuerfana'].'/'.$row_sectores['idclasificacionesinfhuerfana']; ?>/intnacional" id="<?php echo $row_papa['clasificacionesinfhuerfana'].'/'.$row_sectores['idclasificacionesinfhuerfana']; ?>/intnacional" title="Internacional" maxlength="60" tabindex="1" autocomplete="off" size="20" />
                </td>
	</tr>
        <?php
        }
        ?>
                </tbody>
		<thead>
	<?php 
	$query_vencidos = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' and aliasclasificacionesinfhuerfana is not null order by clasificacionesinfhuerfana";
                $vencidos= $db->Execute($query_vencidos);
                $totalRows_vencidos = $vencidos->RecordCount();
        while($row_vencidos = $vencidos->FetchRow()){
	?>
	  <tr id="dataColumns" >        
		  <th class="column borderR" >
		      <?php echo $row_vencidos['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span>
		  </th>		
		  <td class="column" >
		      <input type="text" class="required number" minlength="" name="<?php echo $row_papa['clasificacionesinfhuerfana'].'/'.$row_vencidos['idclasificacionesinfhuerfana']; ?>/nacional" id="<?php echo $row_papa['clasificacionesinfhuerfana'].'/'.$row_vencidos['idclasificacionesinfhuerfana']; ?>/nacional" title="Nacional" maxlength="60" tabindex="1" autocomplete="off" size="20" />
		  </td>
		  <td class="column" >
		      <input type="text" class="required number" minlength="" name="<?php echo $row_papa['clasificacionesinfhuerfana'].'/'.$row_vencidos['idclasificacionesinfhuerfana']; ?>/intnacional" id="<?php echo $row_papa['clasificacionesinfhuerfana'].'/'.$row_vencidos['idclasificacionesinfhuerfana']; ?>/intnacional" title="Internacional" maxlength="60" tabindex="1" autocomplete="off" size="20" />
		  </td>
	  </tr>
	  <?php
	  }
	  ?>
	  </thead>
                </table>
                
                <div class="vacio"></div>
                <div id="msg-success1" class="msg-success" style="display:none"></div>
            </fieldset>
	     <fieldset>
               <?php
		$query_papa2 = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='coinrepraemp'";
                $papa2= $db->Execute($query_papa2);
                $totalRows_papa2 = $papa2->RecordCount();
		$row_papa2 = $papa2->FetchRow();
		?>
                <legend><?php echo $row_papa2['clasificacionesinfhuerfana']; ?></legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); 
                
                $utils->pintarBotonCargar("popup_cargarDocumento(6,1,$('#form_test #semestre').val())","popup_verDocumentos(6,1,$('#form_test #semestre').val())"); ?>
                <table align="center" id="estructuraReporte"  class="formData last" width="92%">
                    <thead>            			
			<tr id="dataColumns">
                            <th class="column borderR" rowspan="2"><span>Sector</span></th>
                            <th class="column" colspan="2"><span>Tipo de Convenio</span></th>
			</tr>	
			<tr id="dataColumns">
                            <th class="column" ><span>Nacional</span></th>
                            <th class="column"><span>Internacional</span></th>
			</tr>
                   </thead>
		   <tbody>
		<?php
		$query_sectores2 = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa2['idclasificacionesinfhuerfana']."' and aliasclasificacionesinfhuerfana is null order by clasificacionesinfhuerfana";
                $sectores2= $db->Execute($query_sectores2);
                $totalRows_sectores2 = $sectores2->RecordCount();
		        while($row_sectores2 = $sectores2->FetchRow()){
		        ?>
                       <tr id="contentColumns" class="row">        
                            <td class="column borderR" >
                                <?php echo $row_sectores2['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span>
                            </td>		
                            <td class="column" >
                                <input type="text" class="required number" minlength="" name="<?php echo $row_papa2['clasificacionesinfhuerfana'].'/'.$row_sectores2['idclasificacionesinfhuerfana']; ?>/nacional" id="<?php echo $row_papa2['clasificacionesinfhuerfana'].'/'.$row_sectores2['idclasificacionesinfhuerfana']; ?>/nacional" title="Nacional" maxlength="60" tabindex="1" autocomplete="off" size="20" />
                            </td>
                            <td class="column" >
                                <input type="text" class="required number" minlength="" name="<?php echo $row_papa2['clasificacionesinfhuerfana'].'/'.$row_sectores2['idclasificacionesinfhuerfana']; ?>/intnacional" id="<?php echo $row_papa2['clasificacionesinfhuerfana'].'/'.$row_sectores2['idclasificacionesinfhuerfana']; ?>/intnacional" title="Internacional" maxlength="60" tabindex="1" autocomplete="off" size="20" />
                            </td>
                       </tr>

		        <?php
		        }
        ?>
	    
                </tbody>
                <thead>
	<?php 
	$query_vencidos2 = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa2['idclasificacionesinfhuerfana']."' and aliasclasificacionesinfhuerfana is not null order by clasificacionesinfhuerfana";
                $vencidos2= $db->Execute($query_vencidos2);
                $totalRows_vencidos2 = $vencidos2->RecordCount();
        while($row_vencidos2 = $vencidos2->FetchRow()){
	?>
	  <tr id="dataColumns" >        
		  <th class="column borderR" >
		      <?php echo $row_vencidos2['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span>
		  </th>		
		  <td class="column" >
		      <input type="text" class="required number" minlength="" name="<?php echo $row_papa2['clasificacionesinfhuerfana'].'/'.$row_vencidos2['idclasificacionesinfhuerfana']; ?>/nacional" id="<?php echo $row_papa2['clasificacionesinfhuerfana'].'/'.$row_vencidos2['idclasificacionesinfhuerfana']; ?>/nacional" title="Nacional" maxlength="60" tabindex="1" autocomplete="off" size="20" />
		  </td>
		  <td class="column" >
		      <input type="text" class="required number" minlength="" name="<?php echo $row_papa2['clasificacionesinfhuerfana'].'/'.$row_vencidos2['idclasificacionesinfhuerfana']; ?>/intnacional" id="<?php echo $row_papa2['clasificacionesinfhuerfana'].'/'.$row_vencidos2['idclasificacionesinfhuerfana']; ?>/intnacional" title="Internacional" maxlength="60" tabindex="1" autocomplete="off" size="20" />
		  </td>
	  </tr>
	  <?php
	  }
	  ?>
	  </thead>
                </table>
                
                <div class="vacio"></div>
                <div id="msg-success2" class="msg-success" style="display:none"></div>
            </fieldset>
	    <input type="hidden" name="formulario" value="form_test" />
            <input type="submit" class="first" value="Registrar datos" />
        </form>
</div>
</div>
<script type="text/javascript">
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(valido){
                        sendForm();
                    }
                });

                function sendForm(){//$('#form_test').serialize()

		    //var empresanacionale = $('#empresanacionale').val();
                    
		  $.ajax({//Ajax
				   type: 'GET',
				   url: './formularios/docentes/saveOficinaDesarrollo.php',
				   async: false,
				   dataType: 'json',
				   data:$('#form_test').serialize(),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				  success:function(data){
				    if (data.success == true){
					$('#form_test #msg-success1').html('<p>' + data.message + '</p>');
					$('#form_test #msg-success1').removeClass('msg-error');
					$('#form_test #msg-success1').css('display','block');
                                        $("#form_test #msg-success1").delay(5500).fadeOut(800);
                                        
                                        
					$('#form_test #msg-success2').html('<p>' + data.message2 + '</p>');
					$('#form_test #msg-success2').removeClass('msg-error');
					$('#form_test #msg-success2').css('display','block');
                                        $("#form_test #msg-success2").delay(5500).fadeOut(800);
				    }
				    else{                        
					$('#form_test #msg-success1').html('<p>' + data.message + '</p>');
					$('#form_test #msg-success1').addClass('msg-error');
					$('#form_test #msg-success1').css('display','block');
                                        $("#form_test #msg-success1").delay(5500).fadeOut(800);
                                        
                                        
					$('#form_test #msg-success2').html('<p>' + data.message2 + '</p>');
					$('#form_test #msg-success2').addClass('msg-error');
					$('#form_test #msg-success2').css('display','block');
                                        $("#form_test #msg-success2").delay(5500).fadeOut(800);
				    }
				}
				//error: function(data,error,errorThrown){alert(error + errorThrown);}
				   
			}); //AJAX

                }
</script>
