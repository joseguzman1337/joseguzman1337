<?PHP 
$rutaInc = "./";
if(isset($UrlView)){
$rutaInc = "../registroInformacion/";
}
?>
<script type="text/javascript">
	$(function() {
            
		$( "#tabs" ).tabs({
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
   			seeMoreText: "Ver más información", //set see more text
   			showCount: true, //show drop down count
   			expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
   			dropWidth: "auto", //width of dropdown
 			sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
   		});
                
                 //$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
                //$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	});
         
         /*function Eliminar(id, entity, metodo){
                 $.ajax({
                      dataType: 'json',
                      type: 'POST',
                      url: './formularios/academicos/saveUnidadesAcademicas.php',
                      data: { action: "inactivateEntity", id: id, entity: entity },     
                      success:function(data){
                            //todo bien :)
                            mainfunc(metodo);
                      },
                      error: function(data,error,errorThrown){alert(error + errorThrown);}
                });  
         }
         
         function mainfunc (func){
            this[func].apply(this, Array.prototype.slice.call(arguments, 1));
        }*/
         
         function getDataDynamic(formName,entity,periodo,campoPeriodo,entityJoin){
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: '<?PHP echo $rutaInc?>formularios/recursosFisicos/saveDesarrolloFisicoYMantenimiento.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: campoPeriodo,entityJoin: entityJoin },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
                
</script>
<?PHP 
if($UrlView){
    if($UrlView==1){
		echo "<br/>";
        ?>
        <div id="tabs-1" class="formsHuerfanos">
     
                    <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
					<?php $utils->getSemestresSelect($db,"codigoperiodo");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
		<?php if($UrlView==1){
				echo '<div id="tableDiv">';
				}
				?>
            <table align="center" class="formData viewData previewReport" width="100%" >
                        <thead>            
                            <tr class="dataColumns">
                                <th class="column" colspan="5"><span>Uso del espacio, área, número de unidades y tenencia</span></th>                                    
                            </tr>
                            <tr class="dataColumns category">
                                <th class="column borderR" ><span>Espacio</span></th> 
                                <th class="column borderR" ><span>M<sup>2</sup> </span></th> 
                                <th class="column borderR" ><span>Número de unidades</span></th> 
                                <th class="column borderR" ><span>Tenencia</span></th> 
                                <th class="column" ><span>Observaciones</span></th> 
                            </tr>
                        </thead>
                        <tbody>      
                        </tbody>
                    </table>   
					<?php if($UrlView==1){
				echo '</div>';
				}
				?>
            <script type="text/javascript">
                $('#tabs-1 .consultar').bind('click', function(event) {
                    getData1("#tabs-1");
                });            
                
                function getData1(name){
                    html = "";                    
                        var periodo = $(name + ' #codigoperiodo').val();
                        var promise = getDataDynamic(name,'formDesarrolloFisicoUsoEspacio',periodo,"codigoperiodo","siq_espaciosFisicos");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){
                                    var totalSalud = 0;
                                    var totalCalidad = 0;
                                    for (var i=0;i<data.total;i++)
                                        {     
                                            totalSalud = totalSalud + parseInt(data.data[i].metros);                                        
                                            totalCalidad = totalCalidad + parseInt(data.data[i].numUnidades);       

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].metros+'</td>';
                                            html = html + '<td class="column borderR center">'+data.data[i].numUnidades+'</td>';
                                            html = html + '<td class="column borderR">'+data.data[i].tenencia+'</td>';
                                            html = html + '<td class="column">'+data.data[i].observaciones+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                        }

                                        html = '<tr class="dataColumns">';
                                        html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                        html = html + '<th class="column total center borderR">'+totalSalud+'</th>"';        
                                        html = html + '<th class="column total center borderR" >'+totalCalidad+'</th>"';            
                                        html = html + '<th class="column total center borderR"></th>"';                
                                        html = html + '<th class="column total center"></th>"';                                        
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

                /*$('#tabs-1 #mes').add($('#tabs-1 #anio')).bind('change', function(event) {
                    var name = "#tabs-1";
                    if($(name + ' #anio').val()=="" || $(name + ' #mes').val()==""){
                        $(name + ' tbody').html("");
                    } else {
                        getData1(name);
                    }
                });*/
            </script>
    </div><!--- tab 1 -->
        <?PHP
    }else if($UrlView==3){
        echo "<br/>"; ?>
        <div id="tabs-3" class="formsHuerfanos">
     
            <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
			<?php $utils->getSemestresSelect($db,"codigoperiodo");  ?>

            <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
            
            <div class="vacio"></div>
			<?php if($UrlView==3){
				echo '<div id="tableDiv">';
				}
				?>
            <table align="center" class="formData viewData previewReport" width="100%" >
                        <thead>            
                            <tr class="dataColumns">
                                <th class="column" colspan="2"><span>Áreas</span></th>                                    
                            </tr>
                            <tr class="dataColumns category">
                                <th class="column borderR" ><span>Áreas</span></th> 
                                <th class="column borderR" ><span>Total áreas en M<sup>2</sup></span></th> 
                            </tr>
                        </thead>
                        <tbody>      
                        </tbody>
                    </table>   
					<?php if($UrlView==3){
				echo '</div>';
				}
				?>
            <script type="text/javascript">
                $('#tabs-3 .consultar').bind('click', function(event) {
                    getData3("#tabs-3");
                });            
                
                function getData3(name){
                    html = "";                    
                        var periodo = $(name + ' #codigoperiodo').val();
                        var promise = getDataDynamic(name,'formDesarrolloFisicoAreas',periodo,"codigoperiodo","siq_areasFisicas");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){
                                    var totalCalidad = 0;
                                    var totalUnidades = 0;
                                    for (var i=0;i<data.total;i++)
                                        {                                           
                                            totalCalidad = totalCalidad + parseInt(data.data[i].metros);      

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].metros+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                        }

                                        html = '<tr class="dataColumns">';
                                        html = html + '<th class="column total right borderR"><span>Total</span></th>"';    
                                        html = html + '<th class="column total center borderR" >'+totalCalidad+'</th>"';                                      
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }
            </script>
    </div><!--- tab 3 -->
        <?PHP
    }
}else{
?>
<div id="tabs" class="dontCalculate">
	<ul>
            <li><a href="#tabs-1">Uso del espacio</a></li>
            <li><a href="#tabs-2">Puestos de trabajo para alumnos</a></li>
            <li><a href="#tabs-3">Áreas</a></li>
	</ul>
    
    <div id="tabs-1" class="formsHuerfanos">
     
                    <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
					<?php $utils->getSemestresSelect($db,"codigoperiodo");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>

            <table align="center" class="formData viewData" width="100%" >
                        <thead>            
                            <tr class="dataColumns">
                                <th class="column" colspan="5"><span>Uso del espacio, área, número de unidades y tenencia</span></th>                                    
                            </tr>
                            <tr class="dataColumns category">
                                <th class="column borderR" ><span>Espacio</span></th> 
                                <th class="column borderR" ><span>M<sup>2</sup> </span></th> 
                                <th class="column borderR" ><span>Número de unidades</span></th> 
                                <th class="column borderR" ><span>Tenencia</span></th> 
                                <th class="column" ><span>Observaciones</span></th> 
                            </tr>
                        </thead>
                        <tbody>      
                        </tbody>
                    </table>   
            <script type="text/javascript">
                $('#tabs-1 .consultar').bind('click', function(event) {
                    getData1("#tabs-1");
                });            
                
                function getData1(name){
                    html = "";                    
                        var periodo = $(name + ' #codigoperiodo').val();
                        var promise = getDataDynamic(name,'formDesarrolloFisicoUsoEspacio',periodo,"codigoperiodo","siq_espaciosFisicos");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){
                                    var totalSalud = 0;
                                    var totalCalidad = 0;
                                    for (var i=0;i<data.total;i++)
                                        {     
                                            totalSalud = totalSalud + parseInt(data.data[i].metros);                                        
                                            totalCalidad = totalCalidad + parseInt(data.data[i].numUnidades);       

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].metros+'</td>';
                                            html = html + '<td class="column borderR center">'+data.data[i].numUnidades+'</td>';
                                            html = html + '<td class="column borderR">'+data.data[i].tenencia+'</td>';
                                            html = html + '<td class="column">'+data.data[i].observaciones+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                        }

                                        html = '<tr class="dataColumns">';
                                        html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                        html = html + '<th class="column total center borderR">'+totalSalud+'</th>"';        
                                        html = html + '<th class="column total center borderR" >'+totalCalidad+'</th>"';            
                                        html = html + '<th class="column total center borderR"></th>"';                
                                        html = html + '<th class="column total center"></th>"';                                        
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

                /*$('#tabs-1 #mes').add($('#tabs-1 #anio')).bind('change', function(event) {
                    var name = "#tabs-1";
                    if($(name + ' #anio').val()=="" || $(name + ' #mes').val()==""){
                        $(name + ' tbody').html("");
                    } else {
                        getData1(name);
                    }
                });*/
            </script>
    </div><!--- tab 1 -->
    
    <div id="tabs-2" class="formsHuerfanos">
     
                    <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
					<?php $utils->getSemestresSelect($db,"codigoperiodo");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>

            <table align="center" class="formData viewData" width="100%" >
                        <thead>            
                                <tr class="dataColumns">
                                    <th class="column" colspan="3"><span>Puestos de trabajo para alumnos</span></th>                                    
                                </tr>
                                <tr class="dataColumns category">
                                    <th class="column borderR" ><span>Espacio</span></th> 
                                    <th class="column borderR" ><span>Puestos</span></th> 
                                    <th class="column" ><span>Observaciones</span></th> 
                                </tr>
                            </thead>
                        <tbody>      
                        </tbody>
                    </table>   
            <script type="text/javascript">

                $('#tabs-2 .consultar').bind('click', function(event) {
                    getData2("#tabs-2");
                });            
                
                function getData2(name){
                    html = "";                    
                        //var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
						var periodo = $(name + ' #codigoperiodo').val();
                        var promise = getDataDynamic(name,'formDesarrolloFisicoPuestosAlumnos',periodo,"codigoperiodo","siq_espaciosFisicos");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){
                                    var totalCalidad = 0;
                                    for (var i=0;i<data.total;i++)
                                        {                                           
                                            totalCalidad = totalCalidad + parseInt(data.data[i].tenencia);       

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].tenencia+'</td>';
                                            html = html + '<td class="column">'+data.data[i].observaciones+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                        }

                                        html = '<tr class="dataColumns">';
                                        html = html + '<th class="column total right borderR"><span>Total</span></th>"';    
                                        html = html + '<th class="column total center borderR" >'+totalCalidad+'</th>"';            
                                        html = html + '<th class="column total center"></th>"';                                        
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }
            </script>
    </div><!--- tab 2 -->
   
    <div id="tabs-3" class="formsHuerfanos">
     
                    <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
					<?php $utils->getSemestresSelect($db,"codigoperiodo");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>

            <table align="center" class="formData viewData" width="100%" >
                        <thead>            
                            <tr class="dataColumns">
                                <th class="column" colspan="3"><span>Áreas</span></th>                                    
                            </tr>
                            <tr class="dataColumns category">
                                <th class="column borderR" ><span>Áreas</span></th> 
                                <th class="column borderR" ><span>Total áreas en M<sup>2</sup></span></th> 
                            </tr>
                        </thead>
                        <tbody>      
                        </tbody>
                    </table>   
            <script type="text/javascript">
                $('#tabs-3 .consultar').bind('click', function(event) {
                    getData3("#tabs-3");
                });            
                
                function getData3(name){
                    html = "";                    
                        var periodo = $(name + ' #codigoperiodo').val();
                        var promise = getDataDynamic(name,'formDesarrolloFisicoAreas',periodo,"codigoperiodo","siq_areasFisicas");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){
                                    var totalCalidad = 0;
                                    var totalUnidades = 0;
                                    for (var i=0;i<data.total;i++)
                                        {                                           
                                            totalCalidad = totalCalidad + parseInt(data.data[i].metros);         

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].metros+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                        }

                                        html = '<tr class="dataColumns">';
                                        html = html + '<th class="column total right borderR"><span>Total</span></th>"';    
                                        html = html + '<th class="column total center borderR" >'+totalCalidad+'</th>"';                                  
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }
            </script>
    </div><!--- tab 3 -->
    
</div> <!--- tabs -->
<?PHP 
}
?>