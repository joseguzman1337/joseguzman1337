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

?>

<div id="tabs" class="dontCalculate">
				<ul>
					<li><a href="./formularios/financieros/formPresupuestoDesarrollo.php">Desarrollo Profesoral</a></li>
                                        <li><a href="./formularios/financieros/formPresupuestoInvestigacion.php">Investigaci&oacute;n, por &Aacute;reas del Conocimiento</a></li>
					<li><a href="./formularios/financieros/formPresupuestoBienestar.php">Presupuesto Programas de Bienestar</a></li>
					<li><a href="./formularios/financieros/formPresupuestoBiblioteca.php">Biblioteca</a></li>
					<li><a href="./formularios/financieros/formPresupuestoFinanciamiento.php">Financiamiento Institucional</a></li>
                                        <li><a href="./formularios/financieros/_formPresupuestoRecursos.php?tipo=1">Fuentes de los Recursos</a></li>
                                        <li><a href="./formularios/financieros/_formPresupuestoRecursos.php?tipo=2">Usos de los Recursos</a></li>
                                        <li><a href="./formularios/financieros/_formPresupuestoRecursos.php?tipo=3">Presupuesto  </a></li>
                                        <li><a href="./formularios/financieros/_formRecursosFinancieros.php?tipo=39">Estado de Cambios en el Patrimonio</a></li>
                                        <li><a href="./formularios/financieros/_formRecursosFinancieros.php?tipo=40">Depuración y Ajustes Sobre los Activos Fijos</a></li>
                                        <li><a href="./formularios/financieros/formPresupuestoBalanceGeneral.php">Balance General Comparativo</a></li>
                                        <li><a href="./formularios/financieros/formEstadoResultadosComparativo.php">Estado De Resultados Comparativo</a></li>
				</ul>

</div>

