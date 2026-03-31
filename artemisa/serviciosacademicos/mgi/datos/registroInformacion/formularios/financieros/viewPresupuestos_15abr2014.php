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


<div id="tabs" class="dontCalculate">
				<ul>
					<li><a href="./formularios/financieros/viewPresupuestoTodo.php?padre=PPROGDESPROF">Desarrollo Profesoral</a></li>
                                        <li><a href="./formularios/financieros/viewPresupuestoTodo.php?padre=P_INV_A_CON">Investigación, por &Aacute;reas del Conocimiento</a></li>
					<li><a href="./formularios/financieros/viewPresupuestoBienestar.php">Presupuesto Programas de Bienestar</a></li>
					<li><a href="./formularios/financieros/viewPresupuestoTodo.php?padre=P_BIBLIO">Biblioteca</a></li>
					<li><a href="./formularios/financieros/viewPresupuestoTodo.php?padre=P_FIN_INST">Financiamiento Institucional</a></li>
                                        <li><a href="../reportes/reportes/financieros/viewReporteFuenteRecursos.php">Fuentes de los Recursos</a></li>
                                        <li><a href="../reportes/reportes/financieros/viewReporteRecursosPresupuesto.php">Uso de los Recursos</a></li>
                                        <li><a href="../reportes/reportes/financieros/viewReporteRecursosPresupuestoA.php">Presupuesto</a></li>
                                        <li><a href="../reportes/reportes/financieros/viewReporteRecursosPatrimonio.php">Estado de Cambio en el patrimonio</a></li>
                                        <li><a href="../reportes/reportes/financieros/viewReporteRecursosDepuracion.php">Depuraci&oacute;n y ajustes sobre los activos fijos</a></li>
                                        <li><a href="../reportes/reportes/financieros/viewReportePresupuestoBalanceGeneralComparativo.php">Balance General Comparativo</a></li>
                                        <li><a href="../reportes/reportes/financieros/viewReportePresupuestoEstadoResultadosComparativo.php">Estado De Resultados Comparativo</a></li>
				</ul>

</div>

