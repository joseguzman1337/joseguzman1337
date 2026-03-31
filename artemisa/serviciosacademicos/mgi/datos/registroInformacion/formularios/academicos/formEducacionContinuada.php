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
                //$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
                //$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
                
     $("#tabs").plusTabs({
   			className: "plusTabs", //classname for css scoping
   			seeMore: true,  //initiate "see more" behavior
   			seeMoreText: "Ver más formularios", //set see more text
   			showCount: true, //show drop down count
   			expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
   			dropWidth: "auto", //width of dropdown
 			sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
   		});
                
                $("#tabs").bind("tabsload",function(event,ui){
                    var total = $("#tabs").find('.ui-tabs-nav li').length;
                    if(ui.index<total){
                        try {
                            $(this).tabs( "load" , ui.index+1);
                        } catch (e) {
                        }
                    } else {
                        $(this).unbind('tabsload');
                    }
                });
                                
                //Para cargar todas las de ajax por debajo
                $( "#tabs" ).tabs('load',2);    
                
	});
	function addObjetos(seccion,idclasif,id='') { 
	   if(id >= '1' && id!=''){ 
	       var idSig=id;
        }else{ 
	       var id = parseInt($('#hidden'+seccion+'_'+idclasif).val());
           var idSig=(id+1);
	   }
       
    
			
		var paises=$("#listpaises").val();
		eval('var objPaises={'+paises+'}');
		//$('#div'+seccion+'_'+idclasif).append('<select name="pais'+seccion+'_'+idclasif+'_'+idSig+'" id="pais'+seccion+'_'+idclasif+'_'+idSig+'" style="width:86px" class="required">');
		var cadena='<select name="pais'+seccion+'_'+idclasif+'[]" id="pais'+seccion+'_'+idclasif+'_'+idSig+'" style="width:90%" class="required">';
		$.each(objPaises,function(key,value) {
			selected=(key==1)?"selected":"";
			cadena+='<option value="'+key+'" '+selected+'>'+value+'</option>';
			//alert( key + ": " + value );
		});
		cadena+='</select>';
		$('#div'+seccion+'_'+idclasif).append('<table border="0" cellpadding="0" cellspacing="0" style="border: white 1px solid;" id="par'+seccion+'_'+idclasif+'_'+idSig+'"><tr style="border: white 1px solid;"><td style="border: white 1px solid;"><br /><input type="hidden" id="id_detalle'+seccion+'_'+idclasif+'_'+idSig+'" name="id_detalle'+seccion+'_'+idclasif+'[]" /><br />'+cadena+'</td><td style="border: white 1px solid;">&nbsp;</td><td style="border: white 1px solid;"><input type="text" class="required number" name="cant'+seccion+'_'+idclasif+'[]" id="cant'+seccion+'_'+idclasif+'_'+idSig+'" title="Número" size="6" /></td></tr></table>');
		$('#hidden'+seccion+'_'+idclasif).val(idSig);
        
        /*<td style="border: white 1px solid;">&nbsp;</td>
        <td style="border: white 1px solid;">*/
        //<p style="margin:20px"
	}
	function delObjetos(seccion,idclasif) {
		var id = parseInt($('#hidden'+seccion+'_'+idclasif).val());
		if(id==1) {
			alert("No puede eliminar la única fila. Debe por lo menos ingresar 1 dato.");
		} else {
			var idAnt=(id-1);
			$('#par'+seccion+'_'+idclasif+'_'+id).remove();
			$('#hidden'+seccion+'_'+idclasif).val(idAnt);
		}
	}
    function BuscarData(){
       var mes  = $('#program_edu #mes').val();
       var year = $('#program_edu #anio').val();
       
       $("#form_uno #action").val('UpdateDynamic');
       
       $.ajax({//Ajax
			   type: 'GET',
			   url: './formularios/academicos/procesarEducacionCon.php',
			   async: false,
			   dataType: 'json',
			   data:({procesID: 'BuscarData',mes:mes,year:year}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			   success: function(data){
						//console.log(data);	
                        if(data.val=='FALSE'){
                            alert(data.descrip);
                            return false;
                        }else{
                            var Unicos = data.Datos_Uni;
                            
                            var Multi  = data.Datos_Multi; 
                            
                            if(typeof Unicos['id']=='undefined'){
                                var num    = 0;
                            }else{
                               var num    = Unicos['id'].length; 
                            }
                            
                            
                           if(num>0){ 
                                for(i=0;i<num;i++){
                                    /******************************************************/
                                    var id                = Unicos['id'][i];
                                    var idclasificacion   = Unicos['idclasificacion'][i];
                                    var idcategorias      = Unicos['idcategorias'][i];
                                    var num_abierto       = Unicos['num_abierto'][i];
                                    var num_cerrado       = Unicos['num_cerrado'][i];
                                    var num_pres          = Unicos['num_pres'][i];
                                    var num_vir           = Unicos['num_vir'][i];
                                    var num_sem           = Unicos['num_sem'][i];
                                    var numero_asistentes = Unicos['numero_asistentes'][i];
                                    /*******************************************************/
                                    $('#program_edu #num_abierto_'+idclasificacion).val(num_abierto);
                                    $('#program_edu #num_cerrado_'+idclasificacion).val(num_cerrado);
                                    $('#program_edu #num_pres_'+idclasificacion).val(num_pres);
                                    $('#program_edu #num_vir_'+idclasificacion).val(num_vir);
                                    $('#program_edu #num_sem_'+idclasificacion).val(num_sem);
                                    $('#program_edu #numero_asistentes_'+idclasificacion).val(numero_asistentes);
                                    $('#program_edu #idcategorias_'+idclasificacion).val(idcategorias);
                                    $('#program_edu #idSave_'+idclasificacion).val(id);
                                    /*******************************************************/
                                    var X = Multi['id_detalle'][1][idclasificacion].length;
                                    $('#divparticipantes_'+idclasificacion).html('');
                                    for(j=0;j<X;j++){
                                        /*********************************************************/
                                        var id_detalle   = Multi['id_detalle'][1][idclasificacion][j];
                                        var Cant_1       = Multi['cantidad'][1][idclasificacion][j];
                                        var Pais_1       = Multi['pais'][1][idclasificacion][j];
                                        /*********************************************************/
                                        var l            = 1;
                                        var n            = parseInt(j)+parseInt(l);                                        
                                        var k            = n;
                                       
                                             addObjetos('participantes',idclasificacion,k);  
                                             $('#program_edu #paisparticipantes_'+idclasificacion+'_'+n).val(Pais_1);
                                             $('#program_edu #cantparticipantes_'+idclasificacion+'_'+n).val(Cant_1); 
                                             $('#program_edu #id_detalleparticipantes_'+idclasificacion+'_'+n).val(id_detalle);
                                        
                                        /*********************************************************/
                                    }//for
                                    
                                    /*******************************************************/
                                    var H = Multi['id_detalle'][2][idclasificacion].length;
                                    $('#divconferencistas_'+idclasificacion).html('');
                                    for(j=0;j<H;j++){ 
                                        /*********************************************************/
                                        var id_detalle   = Multi['id_detalle'][2][idclasificacion][j];
                                        var Cant_2       = Multi['cantidad'][2][idclasificacion][j];
                                        var Pais_2       = Multi['pais'][2][idclasificacion][j];
                                        /*********************************************************/
                                        var l            = 1;
                                        var n            = parseInt(j)+parseInt(l);
                                        var k            = n;
                                        
                                             addObjetos('conferencistas',idclasificacion,k);  
                                             $('#program_edu #paisconferencistas_'+idclasificacion+'_'+n).val(Pais_2);
                                             $('#program_edu #cantconferencistas_'+idclasificacion+'_'+n).val(Cant_2);
                                             $('#program_edu #id_detalleconferencistas_'+idclasificacion+'_'+n).val(id_detalle); 
                                        
                                        /*********************************************************/
                                    }//for
                                    /*******************************************************/
                                }//for
                                
                               
                            }else{ 
                                
                                 var num    = Unicos['idclasificacion'].length;
                                 
                                 $("#form_uno #action").val('SaveDynamic');
                                 
                                    for(i=0;i<num;i++){
                                        var idclasificacion   = Unicos['idclasificacion'][i];
                                        /*************************************/
                                            $('#program_edu #num_abierto_'+idclasificacion).val('');
                                            $('#program_edu #num_cerrado_'+idclasificacion).val('');
                                            $('#program_edu #num_pres_'+idclasificacion).val('');
                                            $('#program_edu #num_vir_'+idclasificacion).val('');
                                            $('#program_edu #num_sem_'+idclasificacion).val('');
                                            $('#program_edu #numero_asistentes_'+idclasificacion).val('');
                                            $('#program_edu #idcategorias_'+idclasificacion).val('');
                                            $('#program_edu #idSave_'+idclasificacion).val('');
                                        /*************************************/
                                        $('#divparticipantes_'+idclasificacion).html('');
                                           /********************************************************/
                                            var seccion  = 'participantes';
                                            var idclasif = idclasificacion;
                                           	var id       = parseInt(0);
                                            var idSig    = (id+1);
                                            var paises=$("#listpaises").val(); 
                                            
                                    		eval('var objPaises={'+paises+'}');
                                    		
                                    		var cadena='<select name="pais'+seccion+'_'+idclasif+'[]" id="pais'+seccion+'_'+idclasif+'_'+idSig+'" style="width:90%" class="required">';
                                    		$.each(objPaises,function(key,value) {
                                    			selected=(key==1)?"selected":"";
                                    			cadena+='<option value="'+key+'" '+selected+'>'+value+'</option>';
                                    			//alert( key + ": " + value );
                                    		});
                                            
                                    		cadena+='</select>';
                                            
                                    		$('#div'+seccion+'_'+idclasif).append('<table border="0" cellpadding="0" cellspacing="0" style="border: white 1px solid;" id="par'+seccion+'_'+idclasif+'_'+idSig+'"><tr style="border: white 1px solid;"><td style="border: white 1px solid;"><br /><input type="hidden" id="id_detalle'+seccion+'_'+idclasif+'_'+idSig+'" name="id_detalle'+seccion+'_'+idclasif+'[]" /><br />'+cadena+'</td><td style="border: white 1px solid;">&nbsp;</td><td style="border: white 1px solid;"><input type="text" class="required number" name="cant'+seccion+'_'+idclasif+'[]" id="cant'+seccion+'_'+idclasif+'_'+idSig+'" title="Número" size="6" /></td></tr></table>');
                                    		$('#hidden'+seccion+'_'+idclasif).val(idSig);
                                           /********************************************************/
                                          $('#divconferencistas_'+idclasificacion).html('');
                                               /********************************************************/
                                                var seccion  = 'conferencistas'; 
                                                var idclasif = idclasificacion;
                                               	var id       = parseInt(0);
                                                var idSig    = (id+1);
                                                var paises=$("#listpaises").val(); 
                                                
                                        		eval('var objPaises={'+paises+'}');
                                        		
                                        		var cadena='<select name="pais'+seccion+'_'+idclasif+'[]" id="pais'+seccion+'_'+idclasif+'_'+idSig+'" style="width:90%" class="required">';
                                        		$.each(objPaises,function(key,value) {
                                        			selected=(key==1)?"selected":"";
                                        			cadena+='<option value="'+key+'" '+selected+'>'+value+'</option>';
                                        			//alert( key + ": " + value );
                                        		});
                                                
                                        		cadena+='</select>';
                                                
                                        		$('#div'+seccion+'_'+idclasif).append('<table border="0" cellpadding="0" cellspacing="0" style="border: white 1px solid;" id="par'+seccion+'_'+idclasif+'_'+idSig+'"><tr style="border: white 1px solid;"><td style="border: white 1px solid;"><br /><input type="hidden" id="id_detalle'+seccion+'_'+idclasif+'_'+idSig+'" name="id_detalle'+seccion+'_'+idclasif+'[]" /><br />'+cadena+'</td><td style="border: white 1px solid;">&nbsp;</td><td style="border: white 1px solid;"><input type="text" class="required number" name="cant'+seccion+'_'+idclasif+'[]" id="cant'+seccion+'_'+idclasif+'_'+idSig+'" title="Número" size="6" /></td></tr></table>');
                                        		$('#hidden'+seccion+'_'+idclasif).val(idSig);
                                               /********************************************************/  
                                        /*************************************/
                                    }//for
                                
                            }//if
                        }//if
			   } 
		}); //AJAX
    }
    function EliminarReg(idCatgoria,name){
        /****************************************/
        var id = parseInt($('#hidden'+name+'_'+idCatgoria).val());
        
        if(id>1){
            /**************************************/
            var id_detalle = $('#program_edu #id_detalle'+name+'_'+idCatgoria+'_'+id).val();
            
            /****************************************/
            $.ajax({//Ajax
    			   type: 'GET',
    			   url: './formularios/academicos/procesarEducacionCon.php',
    			   async: false,
    			   dataType: 'json',
    			   data:({procesID: 'EliminarData',id_detalle:id_detalle}),
    			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    			   success: function(data){
    			         if(data.val=='FALSE'){
    			             alert(data.descrip);
                             return false;
    			         }
    			   }
             });//AJAX
            /**************************************/
        }
        
        /****************************************/
    }//EliminarReg
</script>

<div id="tabs" class="dontCalculate">
	<ul>
		<li><a href="#form_uno">Programas ofrecidos por la división</a></li>
		<li><a href="./formularios/academicos/_formEducacionProgramasOfrecidos.php">Número de programas ofrecidos por la división</a></li>
		<li><a href="./formularios/academicos/_formEducacionEstadoProgramas.php">Programas de Educación Continuada (abiertos o cerrados)</a></li>
		<li><a href="./formularios/academicos/_formEducacionUnidadAcademica.php?id=<?php echo $id; ?>">Programas de Educación Continuada por Unidad Académica</a></li>
	</ul>
	<div id="form_uno">
        <form  method="post" id="program_edu" name="program_edu">
                            <input type="hidden" name="action" value="SelectDynamic" id="action" />
                            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
                            <input type="hidden" name="actividad" value="programas" id="actividad" />
                            <input type="hidden" name="procesID" value="registrar_formEducacion_Continuada" id="procesID" />
			    <input type="hidden" name="formulario_edu" value="programas" />
			<span class="mandatory">* Son campos obligatorios</span>
			<fieldset id="numPersonas">   
				<legend>Programas y asistentes ofertados por Educación Continuada</legend>
				<div class="vacio"></div>
				<label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
<?php 
				$utils->getMonthsSelect("mes",false,'BuscarData()');//
?>
				<label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
<?php
				$utils->getYearsSelect("anio");  
				$utils->pintarBotonCargar("popup_cargarDocumento(14,1,$('#program_edu #mes').val()+'-'+$('#program_edu #anio').val())","popup_verDocumentos(14,1,$('#program_edu #mes').val()+'-'+$('#program_edu #anio').val())");
				$sectores = $utils->getActives($db,"siq_sectores","idsiq_sectores");
?>
				<input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
				<table align="center" class="formData last" width="100%" >
					<thead>            
						<tr class="dataColumns">
							<th class="column" colspan="13"><span>Número programas y de asistentes ofertados por la División de Educación Continuada</span></th>                                    
						</tr>
						<tr class="dataColumns category">
							<th class="column borderR" rowspan="3" width="10%"><span>Tipos de Programas</span></th>
							<th class="column borderR" rowspan="3" width="10%"><span>Categoria</span></th>
							<th class="column borderR" colspan="5" width="40%"><span>Modalidad</span></th>
							<th class="column borderR" rowspan="3" width="10%"><span>Número Asistentes</span></th>
							<th class="column borderR" colspan="4" width="30%"><span>Componente Internacional</span></th>
						</tr>
						<tr >
							<th class="column borderR" rowspan="2" width="8%">ABI</th>
							<th class="column borderR" rowspan="2" width="8%">CER</th>	
							<th class="column borderR" rowspan="2" width="8%">PRE</th>
							<th class="column borderR" rowspan="2" width="8%">VIR</th>
							<th class="column borderR" rowspan="2" width="8%">SEMI</th>
							<th class="column borderR" width="15%">Participantes</th>
							<th class="column borderR" width="15%">Conferencistas</th>
						</tr>
						<tr>
							<th class="column borderR" width="15%">Pais / Cantidad</th>
							<th class="column borderR" width="15%">Pais / Cantidad</th>
						</tr>
					</thead> 
					<tbody>              	 
<?php
						$query="select nombrepais,idpais from pais order by nombrepais";
						$reg=$db->Execute($query);
						$cadenaPaisesJSON="";
						while($row=$reg->FetchRow()) {
							$cadenaPaisesJSON.='"'.$row['idpais'].'": "'.$row['nombrepais'].'",';
							$arrPaisesPHP[$row['idpais']]=$row['nombrepais'];
						}
						$cadenaPaisesJSON=rtrim($cadenaPaisesJSON,',');
?>									
						<input type="hidden" name="listpaises" id="listpaises" value='<?php echo $cadenaPaisesJSON?>'>
<?php
						$query="select iec.idclasificacion
								,iec.clasificacion
							from infoEducacionContinuada iec
							join (
								select idclasificacion
								from infoEducacionContinuada
								where alias='program'
							) sub on iec.idpadreclasificacion=sub.idclasificacion";
						$reg=$db->Execute($query); 
						$i=1;
						while($row=$reg->FetchRow()){

?> 
							<tr id="contentColumns" class="row">
								<td class="column borderR">
                                        <?php echo $row['clasificacion']; ?>:<span class="mandatory">(*)</span>
                                        <input type="hidden" name="idclasificacion[] " id="idclasificacion_<?php echo $row['idclasificacion']; ?>" value="<?php echo $row['idclasificacion']; ?>"/>
                                        <input type="hidden" name="id[] "  id="id_<?php echo $row['idclasificacion']; ?>" value=''  />
                                
                                </td>
								<td class="column borderR">
<?php 
									if($row['idclasificacion']==43) {
										$sql="select nombrecategorias,idCategorias from programasEducacionContinuada";
										$rows = $db->Execute($sql);
										echo $rows->GetMenu2("idcategorias[]",1,false,false,1,"id='idcategorias_".$row['idclasificacion']."' style='width:99px' class='required'");
									} else{
									?>	
                                 <input type="hidden" name="idcategorias[] "  id="idcategorias_<?php echo $rows['calificacion']; ?>" />
                                 <?php } ?>
								</td>			  	      				
								<td class="column borderR center"><input type="hidden" id="idSave_<?php echo$row['idclasificacion']?>" name="idSave[]" /><input type="text" class="required number" minlength="" name="num_abierto[]" id="num_abierto_<?php echo$row['idclasificacion']?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
								<td class="column borderR center"><input type="text" class="required number" minlength="" name="num_cerrado[]" id="num_cerrado_<?php echo$row['idclasificacion']?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
								<td class="column borderR center"><input type="text" class="required number" minlength="" name="num_pres[]" id="num_pres_<?php echo$row['idclasificacion']?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
								<td class="column borderR center"><input type="text" class="required number" minlength="" name="num_vir[]" id="num_vir_<?php echo$row['idclasificacion']?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
								<td class="column borderR center"><input type="text" class="required number" minlength="" name="num_sem[]" id="num_sem_<?php echo$row['idclasificacion']?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
								<td class="column borderR center"><input type="text" class="required number" minlength="" name="numero_asistentes[]" id="numero_asistentes_<?php echo$row['idclasificacion']?>"  title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6"/></td>
								<td class="column borderR">
									<div id="divparticipantes_<?php echo$row['idclasificacion']?>">
										<!--<p style="margin:20px" id="parparticipantes_<?php echo$row['idclasificacion']?>_1">-->
                                        <table border="0" cellpadding="0" cellspacing="0" style="border: white 1px solid;" id="parparticipantes_<?php echo$row['idclasificacion']?>_1">
                                            <tr style="border: white 1px solid;">
                                                <td style="border: white 1px solid;" id="">
                                                  <br />
                                                    <input type="hidden" id="id_detalleparticipantes_<?php echo$row['idclasificacion']?>_1" name="id_detalleparticipantes_<?php echo$row['idclasificacion']?>[]" /><br />
                                                    <select name="paisparticipantes_<?php echo$row['idclasificacion']?>[]" id="paisparticipantes_<?php echo$row['idclasificacion']?>_1" style="width:90%" class="required"> <
<?php 
        												foreach ($arrPaisesPHP as $key => $value) {
        													$selected=($key==1)?"selected":"";
        ?>
        													<option value="<?php echo$key?>" <?php echo$selected?>><?php echo$value?></option>
        <?php
        												}
        ?>
        											</select>
                                               </td>
                                               <td style="border: white 1px solid;">&nbsp;</td>
                                               <td style="border: white 1px solid;">
                                                    <input type="text" class="required number" name="cantparticipantes_<?php echo$row['idclasificacion']?>[]" id="cantparticipantes_<?php echo$row['idclasificacion']?>_1" title="Número" size="6" />
                                              </td>
                                           </tr>               
                                        </table>
                                        <!--</p>-->
									</div>
									<p style="margin:40px;">
										<input type="hidden" name="hiddenparticipantes[]" id="hiddenparticipantes_<?php echo$row['idclasificacion']?>" value="1">
										<input type="button" style="width: 20%; height: 50%;" name="add" class="add" value="+" onclick="addObjetos('participantes',<?php echo$row['idclasificacion']?>)">
										<input type="button" style="width: 20%; height: 50%;" name="del" class="del" value="-" onclick="EliminarReg('<?php echo$row['idclasificacion']?>','participantes');delObjetos('participantes',<?php echo$row['idclasificacion']?>);">
									</p>
								</td>
								<td class="column borderR">
									<div id="divconferencistas_<?php echo$row['idclasificacion']?>">
										<!--<p style="margin:20px; border: red 1px solid;" id="parconferencistas_<?php echo$row['idclasificacion']?>_1"> cellpadding="0" cellspacing="0" class="display" -->
                                            <table border="0" cellpadding="0" cellspacing="0" style="border: white 1px solid;" id="parconferencistas_<?php echo$row['idclasificacion']?>_1">
                                                <tr style="border: white 1px solid;">
                                                    <td style="border: white 1px solid;">
                                                        <br />  
                                                            <input type="hidden" id="id_detalleconferencistas_<?php echo$row['idclasificacion']?>_1" name="id_detalleconferencistas_<?php echo$row['idclasificacion']?>[]" /><br />
                                                        <select name="paisconferencistas_<?php echo$row['idclasificacion']?>[]" id="paisconferencistas_<?php echo$row['idclasificacion']?>" style="width:90%; " class="required"><!--vertical-align: middle; display: block;-->
                                                        <?php
                                                        foreach ($arrPaisesPHP as $key => $value) {
                                                            $selected=($key==1)?"selected":"";
                                                        ?>
                                                        <option value="<?php echo$key?>" <?php echo$selected?>><?php echo$value?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                        </select>
                                                    </td>
                                                    <td style="border: white 1px solid;">&nbsp;</td>
                                                    <td style="border: white 1px solid;">
                                                        <input type="text" class="required number" minlength="" name="cantconferencistas_<?php echo$row['idclasificacion']?>[]" id="cantconferencistas_<?php echo$row['idclasificacion']?>_1" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /><!--style="vertical-align: middle; display: block;"-->
                                                    </td>
                                                </tr>
                                            </table>
										<!--</p>-->
									</div>
									<p style="margin:40px;">
										<input type="hidden" name="hiddenconferencistas_<?php echo$row['idclasificacion']?>" id="hiddenconferencistas_<?php echo$row['idclasificacion']?>" value="1">
										<input type="button" style="width: 20%; height: 50%;" name="add" class="add" value="+" onclick="addObjetos('conferencistas',<?php echo$row['idclasificacion']?>)"> 
										<input type="button" style="width: 20%; height: 50%;" name="del" class="del" value="-" onclick="EliminarReg('<?php echo$row['idclasificacion']?>','conferencistas');delObjetos('conferencistas',<?php echo$row['idclasificacion']?>)">
									</p>
								</td>
							</tr>

<?php
							$i++;
						}
?>
					</tbody>    
				</table>                   
				<div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
			</fieldset>
			<input type="submit" id="submit_fom_continuada"  value="Guardar datos" class="first" />
		</form>
	</div>
</div>
<script type="text/javascript">
     var tipo=$("#actividad").val()
     getformulario_edu("#program_edu");
     BuscarData();
     //getformulario_edu("#program_edu");
    
         
                $('#submit_fom_continuada').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#program_edu");
                    if(valido){
                       //sendDetalleFormacionActividadesAcademicos("#form_DedicacionSemanal3");
                    
                       sendformulario_edu("#program_edu");
                    }
                });
                
                
                $('#program_edu'+' #anio').bind('change', function(event) {
                    //getformulario_edu("#program_edu");
                    BuscarData();
                });
                
             
                function getformulario_edu(formName){ 
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var actividad = $(formName + " #actividad").val();
                    var entity = $(formName + " #entity").val();
                    $(formName + " #action").val('SelectDynamic');
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: "./formularios/academicos/procesarEducacionCon.php",
                            data: $(formName).serialize(),      
                            success:function(data){
                                if (data.success == true){
                                    for (var i=0;i<data.total;i++){   
                                     //  alert(data[i].id_academicoscontinuada+'-->'+data[i].idclasificacion+'-->'+data[i].id_academicoscontinuada+'-->'+data[i].cantidad_salud+'-->'+data[i].cantidad_nucleo+'-->'+data[i].cantidad_academica);                                
                                    //alert(data[i].idcategorias)
                                        $(formName + " #idclasificacion_"+data[i].idclasificacion).val(data[i].idclasificacion);
                                        $(formName + " #id_"+data[i].idclasificacion).val(data[i].id);
                                        $(formName + " #idcategorias_"+data[i].idclasificacion+" option[value="+data[i].idcategorias+"]").attr("selected",true);
                                        //$(formName + " #idcategorias_"+data[i].idclasificacion).val(data[i].idcategorias);
                                        $(formName + " #num_abierto_"+data[i].idclasificacion).val(data[i].num_abierto);
                                        $(formName + " #num_cerrado_"+data[i].idclasificacion).val(data[i].num_cerrado);
                                        $(formName + " #num_pres_"+data[i].idclasificacion).val(data[i].num_pres);
                                        $(formName + " #num_vir_"+data[i].idclasificacion).val(data[i].num_vir);
                                        $(formName + " #num_sem_"+data[i].idclasificacion).val(data[i].num_sem);
                                        $(formName + " #numero_asistentes_"+data[i].idclasificacion).val(data[i].numero_asistentes);
                                         for (var j=0;j<data[i].totalP;j++){ 
                                             $(formName + " #paisconferencistas_"+data[i].idclasificacion+"_"+j).val(data[j].paisconferencistas+"_"+data[i].idclasificacion);
                                         }
                                      }
                                    $(formName + " #action").val("UpdateDynamic");
                                    
                                }else{                        
                                    var mes = $(formName + ' #mes').val();
                                    var anio = $(formName + ' #anio').val();
                                    document.forms[formName.replace("#","")].reset();
                                    $(formName + ' #mes').val(mes);
                                    $(formName + ' #anio').val(anio);
                                    $(formName + " #action").val("SaveDynamic");
                                            
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                 }
                
                function sendformulario_edu(formName){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                         url: "./formularios/academicos/procesarEducacionCon.php",
                         data: $(formName).serialize(),                
                        success:function(data){
                            //console.log(data);
                            if (data.success == true){
                                 $(formName + " #msg-success").css('display','');
                                 $(formName + " #msg-success").html('<p>' + data.descrip + '</p>');
                                 $(formName + " #msg-success").delay(900).fadeOut(800);
                                 /***********************************************************/
                                 
                                 var Datos_id = data.id;
                                 
                                 var num      = Datos_id['idclasificacion'].length;
                                 
                                 for(i=0;i<num;i++){//for...1
                                    /*************************************************/
                                    var idclasificacion = Datos_id['idclasificacion'][i];
                                    var id              = Datos_id['cabeza_'+idclasificacion][0];
                                    var num_p = Datos_id['detalle_Participante_'+idclasificacion].length;
                                    var num_c = Datos_id['detalle_conferencias_'+idclasificacion].length;
                                    
                                    
                                    /*************************************************/
                                    $('#program_edu #idSave_'+idclasificacion).val(id);
                                    /*************************************************/
                                    for(j=0;j<num_p;j++){//for....2
                                        /*********************************************/
                                        var id_detalle   = Datos_id['detalle_Participante_'+idclasificacion][j];
                                        var l            = 1;
                                        var n            = parseInt(j)+parseInt(l);
                                        
                                        $('#program_edu #id_detalleparticipantes_'+idclasificacion+'_'+n).val(id_detalle);
                                        /*********************************************/
                                    }//for...2
                                    for(j=0;j<num_c;j++){//for....3
                                        /*********************************************/
                                        var id_detalle   = Datos_id['detalle_conferencias_'+idclasificacion][j];
                                        var l            = 1;
                                        var n            = parseInt(j)+parseInt(l);
                                        
                                        $('#program_edu #id_detalleconferencistas_'+idclasificacion+'_'+n).val(id_detalle); 
                                        /*********************************************/
                                    }//for...3
                                    /*************************************************/
                                 }//for...1
                                 
                                
                                 $("#form_uno #action").val('UpdateDynamic');
                                // getformulario_edu("#program_edu");
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
    
//	$('#submit_fom_continuada').click(function(event) {
//		event.preventDefault();
//		var valido= validateForm("#program_edu");
//		if(valido){
//			var dataString = $('#program_edu').serialize();
//			// alert('Datos serializados: '+dataString);
//			$.ajax({
//				type: "POST",
//				url: "./formularios/academicos/procesarEducacionCon.php?procesID=registrar_formEducacion_Continuada",
//				async: false,
//				dataType: 'json',
//				data: dataString,
//				success: function(data) {
//					if(data.val=='FALSE') {
//						$('#program_edu #msg-success').html('<p>' + data.descrip + '</p>');
//						$('#program_edu #msg-success').addClass('msg-error');
//						$('#program_edu #msg-success').css('display','block');
//						$("#program_edu #msg-success").delay(5500).fadeOut(800);
//						return false;
//					} else {	
//						$('#program_edu #msg-success').html('<p>' + data.descrip + '</p>');
//						$('#program_edu #msg-success').removeClass('msg-error');
//						$('#program_edu #msg-success').css('display','block');
//						$("#program_edu #msg-success").delay(5500).fadeOut(800);
//						document.getElementById("program_edu").reset();
//					}
//				},
//                                error: function(data,error,errorThrown){alert(error + errorThrown);}
//			});//$.ajax
//		}//if(valido)
//	});//$('#submit_fom_continuada').click(function(event) 
</script>









