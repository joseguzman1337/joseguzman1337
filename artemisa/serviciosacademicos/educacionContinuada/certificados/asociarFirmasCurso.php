<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Asociar firmas a certificado",TRUE);

    $utils = Utils::getInstance(); 
	initializeCertificados();
	$utilsC = Utils_Certificados::getInstance();
	$columns = $utilsC->getFirmasPlantilla($_REQUEST["idplantilla"]);
	//$dataPlantilla = $utils->getDataEntityActive("plantillaCursoEducacionContinuada", $_REQUEST["idplantilla"],"idplantillaCursoEducacionContinuada");
	//$dataCampo = $utils->getDataEntity("campoParametrizadoPlantillaEducacionContinuada", "{{firmasPrograma}}","etiqueta");
    //$data = $utils->getDataEntity("carrera", $dataPlantilla["codigocarrera"],"codigocarrera");
    
	//$columns = $utils->getDetalleReporte($db, $data["idsiq_reporte"]); 
	//$columns = array();
    $numC = count($columns);
    if($numC>0){
        $col = $columns["columnas"];
		$row = $columns["filas"];
    } else {
        $col = 1;
		$row = 1;
    }
	
	if(isset($_SESSION['colFirmas']) && $_SESSION['colFirmas']!=""){
		$col = $_SESSION['colFirmas'];
		$row = $_SESSION['rowFirmas'];
		unset($_SESSION['colFirmas']);
		unset($_SESSION['rowFirmas']);
	}
    
    //solo php 5.2 pa arriba
    $js_array = json_encode($columns["data"]);
    //var_dump($js_array);
?>

<div id="contenido">
        <h4>Firmas Certificación <?php echo $data["nombrecarrera"]; ?></h4>
        <div id="form"> 
			<div id="msg-error"><?php if(isset($_REQUEST["success"])&& $_REQUEST["success"]==false) { echo $_REQUEST["mensaje"]; } ?></div>
    
    <form action="process.php" method="post" id="form_test" name="signForm" >
            <input type="hidden" name="action" value="asociarFirmas" />
			<input type="hidden" name="numFirmas" id="numFirmas" value="1" />
			<input type="hidden" name="numColsAnterior" id="numColsAnterior" value="1" />
			<input type="hidden" name="numFilasAnterior" id="numFilasAnterior" value="1" />
			<input type="hidden" name="idPlantilla" id="numFilasAnterior" value="<?php echo $_REQUEST["idplantilla"]; ?>" />
			<fieldset>   
                <label for="firma" style="margin-left:10px;margin-top:5px;width:160px;clear:none;">Número de columnas: <span class="mandatory">(*)</span></label>
				<select name="columnas" id="numCols" style="clear:none;" class="required">
					<?php for ($i = 1; $i <= 5; $i++) {
							if($i==$col){
								echo '<option value="'.$i.'" selected >'.$i.'</option>';
							} else {
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						} ?>
				</select>
				<label for="filas" style="margin-left:10px;margin-top:5px;width:160px;clear:none;">Número de filas: <span class="mandatory">(*)</span></label>
				<select name="filas" id="numFilas" class="required">
					<?php for ($i = 1; $i <= 5; $i++) {
							if($i==$row){
								echo '<option value="'.$i.'" selected>'.$i.'</option>';
							} else {
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						} ?>
				</select>
				
				<table align="left" id="estructuraFirmas" style="text-align:left;clear:both;margin: 10px 30px;">
					<tbody>
						<tr class="row1 row">
							<?php if($numC==0){ ?>
							<td class="pickData column column1"><button class="soft elegirFirma" type="button" id="firma_1" style="margin:0 auto;">Elegir firma</button></td>
							<?php } else { ?>
								<td class="pickData column column1 picked id<?php echo $columns["data"][0]["iddetalleFirmasPlantillaCursoEducacionContinuada"]; ?>"><button class="soft elegirFirma" type="button" id="firma_1" style="margin:0 auto;"><?php echo $columns["data"][0]["nombre"]."<br/>".$columns["data"][0]["cargo"]; ?></button></td>
							<?php } ?>
						</tr>
					</tbody>
				</table>
            </fieldset>
			<input type="submit" value="Guardar cambios" class="first" style="margin-left:10px;" />
        </form>
</div>

<script type="text/javascript">
    var maxCols = 5;
	
	$(document).ready(function() {
		columnChange();
		rowChange();
	});
	
	$('#numCols').change(function() {
        columnChange();
    });
    
    function columnChange(){
        var num = parseInt($('select#numCols option:selected').val());
        var numActual = parseInt($('#numColsAnterior').val());
        if(num>numActual){
            addColumns(numActual,num-numActual);
        } else if(num<numActual){
            removeColumns(numActual,numActual-num);
        }
		$('#numColsAnterior').val(num);
    }
    
    function addColumns(numActual,toAdd){
        <?php echo "var myArray = ". $js_array . ";\n";
        ?>
        var rows= parseInt($('#numFilasAnterior').val());
        for (var i=1;i<=toAdd;i++)
        {
            var index = numActual + i;
             
            if(typeof myArray !== "undefined" && myArray !== null && myArray.length>=index){
                for (var z=1;z<=rows;z++){
                    var encontrado = false;
                    var orden = (maxCols*(z)-maxCols+index);
                    for (var j=0;j<myArray.length&&!encontrado;j++){
                        if(myArray[j]["orden"]==orden){
                            $('.row'+z).append('<td class="pickData column column'+orden+' picked id'+myArray[j]["iddetalleFirmasPlantillaCursoEducacionContinuada"]+'"><button class="soft elegirFirma" type="button" style="margin:0 auto;">'+myArray[j]["nombre"]+'<br/>'+myArray[j]["cargo"]+'</button></td>');
                            encontrado = true;
                            myArray.splice(j, 1);
                        }                     
                    }

                    if(!encontrado){
                        $('.row'+z).append('<td class="column pickData column'+orden+'"><button class="soft elegirFirma" type="button" style="margin:0 auto;">Elegir firma</button></td>');
                    }

               }
            } else {
                //$('#dataColumns').append('<th class="column'+index+' pickData"><span>Elegir dato/información</span></th>');
                for (var j=1;j<=rows;j++){
                    var indexVer = (maxCols*(j)-maxCols+index);
                    //if($('.column'+(indexVer-1)).hasClass( "picked" )){
                        $('.row'+j).append('<td class="column pickData column'+indexVer+'"><button class="soft elegirFirma" type="button" style="margin:0 auto;">Elegir firma</button></td>');
                    /*} else {
                        $('.row'+j).append('<td class="column pickData column'+indexVer+'"><button class="soft elegirFirma disable" type="button" style="margin:0 auto;">Elegir firma</button></td>');
                    }*/
                }
            }
        }
    }
    
    function removeColumns(numActual,toRemove){
        var rows= parseInt($('#numFilasAnterior').val());
        for (var j=1;j<=rows;j++){
            for (var i=0;i<toRemove;i++)
            {
                var index = numActual - i;            
                var indexVer = (maxCols*(j)-maxCols+index);
                //console.log(indexVer);
                $('.column'+indexVer).remove();
            }
        }
    }
    
    $('#numFilas').change(function() {
        rowChange();
    });
    
    function rowChange(){
        var num = parseInt($('select#numFilas option:selected').val());
        var numActual = parseInt($('#numFilasAnterior').val());
        if(num>numActual){
            addRows(numActual,num-numActual);
        } else if(num<numActual){
            removeRows(numActual,numActual-num);
        }     
        $('#numFilasAnterior').val(num);   
        //$('#numFirmas').val(num);        
    }
    
    function addRows(numActual,toAdd){
        <?php echo "var myArray = ". $js_array . ";\n";  ?>
             var rows= numActual;
             var cols= parseInt($('#numColsAnterior').val());
             var indexCols = 1;
        for (var i=1;i<=toAdd;i++)
        {
            var index = numActual + i;
            //console.log(cols);
            if(typeof myArray !== "undefined" && myArray !== null && myArray.length>=index){
                    var encontrado = false;
                    var orden = (maxCols*(rows+1)-maxCols+indexCols);
                //console.log(orden);
                    for (var j=0;j<myArray.length&&!encontrado;j++){
                        if(myArray[j]["orden"]==orden){
                            $('.row'+rows).after('<tr class="row'+(rows+1)+' row"><td class="pickData column column'+orden+' picked id'+myArray[j]["iddetalleFirmasPlantillaCursoEducacionContinuada"]+'"><button class="soft elegirFirma" type="button" style="margin:0 auto;">'+myArray[j]["nombre"]+'<br/>'+myArray[j]["cargo"]+'</button></td></tr>');
                            encontrado = true;
                            myArray.splice(j, 1);
                        }                     
                    }

                if(!encontrado){
                    $('.row'+rows).after('<tr class="row'+(rows+1)+' row"><td class="column pickData column'+orden+'"><button class="soft elegirFirma" type="button" style="margin:0 auto;">Elegir firma</button></td></tr>');
                }
                //
                if(cols-1>0){
                //console.log("llame al metodo");
                        addColumnsRow(1,(cols-1),(rows+1));
                    }
                //$('#contentColumns').append('<td class="column'+index+'"></td>');
                //$('#totalColumns').append('<td class="column'+index+' total"></td>');
               
            } else {
                //$('#dataColumns').append('<th class="column'+index+' pickData"><span>Elegir dato/información</span></th>');
                
                //$curr = $('.row').last();
                //console.log($curr);
                //var myClass = $($curr).attr("class");
                //var clases=myClass.split(" ");
                //console.log(clases[0]);
                //myClass = $("tr."+clases[0]+" td:last-child").attr("class");
                //clases=myClass.split(" ");
                //console.log(clases[2]);
                //if($(clases[2]).hasClass( "picked" )){
                    $('.row'+rows).after('<tr class="row'+(rows+1)+' row"><td class="column pickData column'+(maxCols*(rows+1)-maxCols+indexCols)+'"><button class="soft elegirFirma" type="button" style="margin:0 auto;">Elegir firma</button></td></tr>');
                /*} else {
                    $('.row'+rows).after('<tr class="row'+(rows+1)+' row"><td class="column pickData column'+(maxCols*(rows+1)-maxCols+indexCols)+'"><button class="soft elegirFirma disable" type="button" style="margin:0 auto;">Elegir firma</button></td></tr>');
                }*/
                if(cols-1>0){
                    addColumnsRow(1,(cols-1),(rows+1));
                }
            }
            rows = rows + 1;
        }
    }
    
    function addColumnsRow(numActual,toAdd,row){
        <?php echo "var myArray = ". $js_array . ";\n"; ?>
        for (var i=1;i<=toAdd;i++)
        {
            //console.log(toAdd);
            var index = numActual + i;
             
            if(typeof myArray !== "undefined" && myArray !== null && myArray.length>=index){
               var encontrado = false;
                var orden = (maxCols*(row)-maxCols+index);
                //console.log(orden);
                for (var j=0;j<myArray.length&&!encontrado;j++){
                    if(myArray[j]["orden"]==orden){
                        $('.row'+row).append('<td class="pickData column column'+orden+' picked id'+myArray[j]["iddetalleFirmasPlantillaCursoEducacionContinuada"]+'"><button class="soft elegirFirma" type="button" style="margin:0 auto;">'+myArray[j]["nombre"]+'<br/>'+myArray[j]["cargo"]+'</button></td>');
                        encontrado = true;
                        myArray.splice(j, 1);
                    }                     
                }
               
               if(!encontrado){
                   $('.row'+row).append('<td class="column pickData column'+orden+'"><button class="soft elegirFirma" type="button" style="margin:0 auto;">Elegir firma</button></td>');
               }
            } else {
                    var indexVer = (maxCols*(row)-maxCols+index);
                    //if($('.column'+(indexVer-1)).hasClass( "picked" )){
                        $('.row'+row).append('<td class="column pickData column'+indexVer+'"><button class="soft elegirFirma" type="button" style="margin:0 auto;">Elegir firma</button></td>');
                    /*} else {
                        $('.row'+row).append('<td class="column pickData column'+indexVer+'"><button class="soft elegirFirma disable" type="button" style="margin:0 auto;">Elegir firma</button></td>');
                    } */               
            }
        }
    }
    
    function removeRows(numActual,toRemove){
        for (var i=0;i<toRemove;i++)
        {
            var index = numActual - i;
            $('.row'+index).remove();
        }
    }
    
    //Para asociar firmas
    $(document).on("click", ".pickData", function(event){        
        //si no esta deshabilitado entonces puede pasar
        if(!$(this).has(".disable").length){
            // get order
            var columnArray = $(this).attr('class').split(" ");
            column = columnArray[2].replace("column",""); 
        
            // get row      
            var row = $(".column"+column).parent().attr('class').split(" ");
            row = row[0].replace("row",""); 
			
			var cols = parseInt($('#numColsAnterior').val());
			var rows = parseInt($('#numFilasAnterior').val());

            //console.log(column + " - " + row);
            var name = "idColumn" + column;
            if(!$(this).hasClass('picked')){
                //open dialog. 
                popup_carga('./formAsociarFirma.php?idP='+<?php echo $_REQUEST["idplantilla"]; ?>+'&columna='+column+'&fila='+row+'&cols='+cols+'&filas='+rows); 
            } else {
				var idFirma = columnArray[4].replace("id",""); 
                popup_carga('./formAsociarFirma.php?idP='+<?php echo $_REQUEST["idplantilla"]; ?>+'&columna='+column+'&fila='+row+'&id='+idFirma+'&cols='+cols+'&filas='+rows); 
            }
            
        } /*else {
            console.log("deshabilitado");
        } */
    });
    
    function windowClose() {
       window.location.reload();
    }
    
</script>
<?php  writeFooter(); ?>