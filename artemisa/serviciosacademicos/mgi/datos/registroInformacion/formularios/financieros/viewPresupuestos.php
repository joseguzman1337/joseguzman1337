<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({
		  cache: true,
                    select: function(event, ui) {       
                        //para que al cargarse vuelva a cargar en la que estaba
                        window.location.hash = ui.tab.hash;
                    },
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
         
         function getDataDynamic2(formName,entity,periodo,campoPeriodo,entityJoin,campoJoin,actividad){
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/docentes/saveTalentoHumano.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: campoPeriodo,entityJoin: entityJoin,joinField:campoJoin,actividad:actividad },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
</script>



<div id="tabs" class="dontCalculate">
				<ul>
					<li><a href="./formularios/financieros/viewPresupuestoTodo.php?padre=PPROGDESPROF">Desarrollo Profesoral</a></li>
					<li><a href="./formularios/financieros/viewPresupuestoTodo.php?padre=P_INV_A_CON">Investigación, por Áreas del Conocimiento</a></li>
					<li><a href="./formularios/financieros/viewPresupuestoBienestar.php">Presupuesto Programas de Bienestar</a></li>
					<li><a href="./formularios/financieros/viewPresupuestoTodo.php?padre=P_BIBLIO">Biblioteca</a></li>
					<li><a href="./formularios/financieros/viewPresupuestoTodo.php?padre=P_FIN_INST">Financiamiento Institucional</a></li>
                    <li><a href="../reportes/reportes/financieros/viewReporteFuenteRecursos.php">Fuente de los Recursos</a></li>
                    <li><a href="../reportes/reportes/financieros/viewReporteRecursosPresupuesto.php">Uso de los Recursos</a></li>
                    <li><a href="../reportes/reportes/financieros/viewReporteRecursosPresupuestoA.php">Presupuesto y Ejecución Presupuestal</a></li>
                    <li><a href="../reportes/reportes/financieros/viewReporteRecursosPatrimonio.php">Estado de Cambio en el Patrimonio</a></li>
                    <li><a href="../reportes/reportes/financieros/viewReporteRecursosDepuracion.php">Depuración Y Ajuste Sobre Los Activos Fijos</a></li>
                    <li><a href="../reportes/reportes/financieros/viewReportePresupuestoBalanceGeneralComparativo.php">Balance General Comparativo</a></li>
                    <li><a href="../reportes/reportes/financieros/viewReportePresupuestoEstadoResultadosComparativo.php">Estado De Resultados Comparativo</a></li>
				</ul>


</div>
