<?php
   include("../../templates/templateAutoevaluacion.php");
   $db = writeHeader("Instrumento",true,"Autoevaluacion");
   
		$nombrecarrera="";
		$carrera = "";
		
       if($_REQUEST["cat_ins"]=="EDOCENTES"&&$_SESSION["codigofacultad"]!=1&&$_SESSION["codigofacultad"]!=156 ){
			$carrera = " AND c.codigocarrera = ".$_SESSION["codigofacultad"];
			$nombrecarrera = " - ".$_SESSION["nombrefacultad"];
	   } else if($_REQUEST["cat_ins"]=="EDOCENTES"&&($_SESSION["codigofacultad"]==1||$_SESSION["codigofacultad"]==156)){
			$nombrecarrera = " - ".$_SESSION["nombrefacultad"];
	   }
   //$_REQUEST['cat_ins'];
   /* include("./menu.php");
    writeMenu(0);*/
	
	if(!isset($_REQUEST["cat_ins"]) || $_REQUEST["cat_ins"]==="MGI") { 
            $sql="SELECT c.idsiq_Ainstrumentoconfiguracion, c.nombre, c.mostrar_bienvenida, c.mostrar_despedida, 
				c.fecha_inicio, c.fecha_fin, c.estado, c.secciones, d.nombre as tipo, nombrecarrera, p.periodicidad 
				FROM siq_Ainstrumentoconfiguracion AS c 
				left join carrera as r on (r.codigocarrera=c.codigocarrera)
				WHERE c.codigoestado=100 AND cat_ins IN ('".$_REQUEST["cat_ins"]."') ".$carrera;
	}else if( $_REQUEST["cat_ins"]==="EC") {
		$sql="SELECT c.idsiq_Ainstrumentoconfiguracion, c.nombre, c.mostrar_bienvenida, c.mostrar_despedida, 
			c.fecha_inicio, c.fecha_fin, c.estado, c.secciones, '' as tipo, nombrecarrera, '' as periodicidad 
			FROM siq_Ainstrumentoconfiguracion AS c 
			left join carrera as r on (r.codigocarrera=c.codigocarrera)
			WHERE c.codigoestado=100 AND cat_ins IN ('".$_REQUEST["cat_ins"]."') ".$carrera."
			UNION
			SELECT c.idsiq_Ainstrumentoconfiguracion, c.nombre, c.mostrar_bienvenida, c.mostrar_despedida, 
			c.fecha_inicio, c.fecha_fin, c.estado, c.secciones, '' as tipo, nombrecarrera, '' as periodicidad 
			FROM siq_Ainstrumentoconfiguracion AS c 
			left join carrera as r on (r.codigocarrera=c.codigocarrera)
			WHERE c.codigoestado=100 AND cat_ins IN ('OTRAS') ".$carrera." AND c.nombre LIKE '%EDUCACIÓN CONTINUADA%'
			";	
	} else {
		$sql="SELECT c.idsiq_Ainstrumentoconfiguracion, c.nombre, c.mostrar_bienvenida, c.mostrar_despedida, 
			c.fecha_inicio, c.fecha_fin, c.estado, c.secciones, '' as tipo, nombrecarrera, '' as periodicidad 
			FROM siq_Ainstrumentoconfiguracion AS c 
			left join carrera as r on (r.codigocarrera=c.codigocarrera)
			WHERE c.codigoestado=100 AND cat_ins IN ('".$_REQUEST["cat_ins"]."') ".$carrera;	
	}
	
	$datos = $db->Execute($sql);      
    ?>
        <div id="container">
            <div class="full_width big">Instrumentos</div>
            <h1>Configuraci&oacute;n de Instrumentos<?php echo $nombrecarrera; ?></h1>
            <div class="demo_jui">
                <div class="DTTT_container">
                <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text">
                    <span>Nuevo</span>
                </button>
                <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Editar</span>
                </button>
                <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Eliminar</span> 
                </button>
				<?php if(!isset($_REQUEST["cat_ins"]) || $_REQUEST["cat_ins"]!=="OBS" ) { ?>
					<button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
					<span>Asignar Público Objetivo</span> 
					</button>
				<?php } ?>
                    <?php if(!isset($_REQUEST["cat_ins"]) || ($_REQUEST["cat_ins"]!=="MGI" &&
                            $_REQUEST["cat_ins"]!=="OBS")) { 
                                if($_REQUEST["cat_ins"]!=="EC" && $_REQUEST["cat_ins"]!=="EDOCENTES") { ?>
				<button id="ToolTables_example_4" class="DTTT_button DTTT_button_text DTTT_disabled">
                                    <span>Publicación de Instrumento</span> 
				</button>
                                <?php } ?>
					<button id="ToolTables_example_5" class="DTTT_button DTTT_button_text DTTT_disabled">
					<span>Ver Reporte</span> 
					</button>
                    <?php }
                    
                    if($_REQUEST["cat_ins"]=="OTRAS"){
                     ?>
                    <button id="ToolTables_example_6" class="DTTT_button DTTT_button_text DTTT_disabled">
					<span>Ver Reporte Detalle o Filtro </span> 
					</button>
                    <?PHP }                    
                    if($_REQUEST["cat_ins"]=="EDOCENTES"){
                     ?>
                    <button id="ToolTables_example_7" class="DTTT_button DTTT_button_text DTTT_disabled">
					<span>Ver Materias por Evaluar </span> 
					</button>
                    <button id="ToolTables_example_8" class="DTTT_button DTTT_button_text DTTT_disabled">
					<span>Ver Resultados</span> 
					</button>
                    <?PHP }?>    
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                            
                            <th>Nombre</th>
                            <!--<th>Bienvenida</th>
                            <th>Despedida</th>-->
                            <th>Inicio</th>
                            <th>Fin</th>
                            <!--<th>Estado</th>   
                            <th>Secciones</th> -->
                            <th>tipo</th> 
                            <th>programa</th> 
                            <th>periodicidad</th> 
                        </tr>
						</thead>
                    <tbody>  
						<?php foreach($datos  as $campos)
						{
							echo "<tr id='row_".$campos['idsiq_Ainstrumentoconfiguracion']."'><td>".$campos['nombre']."</td>";
							//echo "<td>".$campos['mostrar_bienvenida']."</td>";
							//echo "<td>".$campos['mostrar_despedida']."</td>";
							echo "<td>".$campos['fecha_inicio']."</td>";
							echo "<td>".$campos['fecha_fin']."</td>";
							//echo "<td>".$campos['estado']."</td>";
							//echo "<td>".$campos['secciones']."</td>";
							echo "<td>".$campos['tipo']."</td>";
							echo "<td>".$campos['nombrecarrera']."</td>";
							echo "<td>".$campos['periodicidad']."</td></tr>";
						}
					?>
                                         
                    </tbody>
                </table>
            </div>
        </div>            
   <script type="text/javascript">
        var oTable;
        var aSelected = [];
       
        $(document).ready(function() {  
		
			oTable = $('#example').dataTable({
                "sDom": '<"H"Cfrltip>',
                "bJQueryUI": true,
                "bPaginate": true,
                "sPaginationType": "full_numbers",
                "oColVis": {
                        "buttonText": "Ver/Ocultar Columns",
                        "aiExclude": [ 0 ]
                }, 
                "fnInitComplete": function() {
                            this.fnAdjustColumnSizing(true); 
                            var maxWidth = $('#container').width();  
                            this.width(maxWidth);
                        }
            });
		
        /*var sql;
			<?php if(!isset($_REQUEST["cat_ins"]) || $_REQUEST["cat_ins"]==="MGI") { ?>
            sql="SELECT c.idsiq_Ainstrumentoconfiguracion, c.nombre, c.mostrar_bienvenida, c.mostrar_despedida, ";
            sql+="c.fecha_inicio, c.fecha_fin, c.estado, c.secciones, d.nombre as tipo, nombrecarrera, p.periodicidad ";
            sql+="FROM siq_Ainstrumentoconfiguracion AS c ";
            sql+="left join siq_discriminacionIndicador as d on (d.idsiq_discriminacionIndicador=c.idsiq_discriminacionIndicador) ";
			sql+="left join siq_periodicidad as p on (p.idsiq_periodicidad=c.idsiq_periodicidad) ";
			<?php } else if($_REQUEST["cat_ins"]==="EC"){ ?>
			sql="SELECT c.idsiq_Ainstrumentoconfiguracion, c.nombre, c.mostrar_bienvenida, c.mostrar_despedida, ";
            sql+="c.fecha_inicio, c.fecha_fin, c.estado, c.secciones, '' as tipo, nombrecarrera, '' as periodicidad ";
            sql+="FROM siq_Ainstrumentoconfiguracion AS c ";
			<?php } else { ?>
			sql="SELECT c.idsiq_Ainstrumentoconfiguracion, c.nombre, c.mostrar_bienvenida, c.mostrar_despedida, ";
            sql+="c.fecha_inicio, c.fecha_fin, c.estado, c.secciones, '' as tipo, nombrecarrera, '' as periodicidad ";
            sql+="FROM siq_Ainstrumentoconfiguracion AS c ";
			<?php } ?>
            sql+="left join carrera as r on (r.codigocarrera=c.codigocarrera) ";
           //console.log(sql);
            oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "../../server_processing.php?active=true&table=siq_Ainstrumentoconfiguracion&sql="+sql+"&wh=c.codigoestado&tableNickname=c&join=true&cwh=cat_ins IN (\'<?php echo $_REQUEST["cat_ins"]; ?>\') <?php echo $carrera; ?>",   
                "aoColumns": [
                { "sTitle": "Nombre" },
                { "sTitle": "Bienvenida", "bVisible":false },
                { "sTitle": "Despedida", "bVisible":false },
                { "sTitle": "Fecha Inicio"},
                { "sTitle": "Fecha Expiración"},
                { "sTitle": "Estado", "bVisible":false,"bSearchable": true},
                { "sTitle": "Secciones", "bVisible":false,"bSearchable": true  },
                { "sTitle": "Tipo"},
                { "sTitle": "Programa"},
                { "sTitle": "periodicidad"}
                ], 
                "fnInitComplete": function() {
                            this.fnAdjustColumnSizing(true); 
                            var maxWidth = $('#container').width();  
                            this.width(maxWidth);
                        }
            }); */
            /* Click event handler */
           
             $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).hasClass('row_selected') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
                    $("#ToolTables_example_3").addClass('DTTT_disabled');
                    $("#ToolTables_example_4").addClass('DTTT_disabled');
                    $("#ToolTables_example_5").addClass('DTTT_disabled');
                    $("#ToolTables_example_6").addClass('DTTT_disabled');
                    $("#ToolTables_example_7").addClass('DTTT_disabled');
                    $("#ToolTables_example_8").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');                    
                    $("#ToolTables_example_2").removeClass('DTTT_disabled');
                    $("#ToolTables_example_3").removeClass('DTTT_disabled');
                    $("#ToolTables_example_4").removeClass('DTTT_disabled');
                    $("#ToolTables_example_5").removeClass('DTTT_disabled');
                    $("#ToolTables_example_6").removeClass('DTTT_disabled');
                    $("#ToolTables_example_7").removeClass('DTTT_disabled');
                    $("#ToolTables_example_8").removeClass('DTTT_disabled');
                }
             } );
             $('#ToolTables_example_0').click( function () {  
                if(!$('#ToolTables_example_0').hasClass('DTTT_disabled'))
                {gotonuevo('configuracion.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>');  }
            } );
            
            $('#ToolTables_example_1').click( function () {  
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled'))
                {updateForm2('configuracion.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>'); }               
            } );
            $('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                {deleteForm("Ainstrumentoconfiguracion");}                
            } );
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {asignarPOB('instrumento_publico.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>');}                
            } );
            $('#ToolTables_example_4').click( function () {  
                if(!$('#ToolTables_example_4').hasClass('DTTT_disabled'))
                {updateForm2('instrumento_publicacion.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>'); }  
            } );
            
            $('#ToolTables_example_5').click( function () {  
                if(!$('#ToolTables_example_5').hasClass('DTTT_disabled'))
                {updateForm2('instrumento_reporte.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>'); }               
            } );
            
            $('#ToolTables_example_6').click( function () {  
                if(!$('#ToolTables_example_6').hasClass('DTTT_disabled'))
                {updateForm2('VisualizarReporte_html.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>'); }               
            } );
            
            $('#ToolTables_example_7').click( function () {  
                if(!$('#ToolTables_example_7').hasClass('DTTT_disabled'))
                {updateForm2('listadoMateriasPendientes.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>'); }               
            } );
            
            $('#ToolTables_example_8').click( function () {  
                if(!$('#ToolTables_example_8').hasClass('DTTT_disabled'))
                {updateForm2('listadoRespuestasEvaluacionDocente.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>'); }               
            } );
      } );
        </script>
    
<?php    writeFooter();
        ?>  