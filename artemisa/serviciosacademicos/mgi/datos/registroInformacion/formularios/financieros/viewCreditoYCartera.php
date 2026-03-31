<?php         
    $recordsBecas = $utils->getDataForm($db,"siq_formCreditoYCarteraBecas","codigoperiodo");
    //$recordsApoyos = $utils->getDataForm($db,"siq_formCreditoYCarteraApoyos","codigoperiodo");
    $recordsCreditos = $utils->getDataForm($db,"siq_formCreditoYCarteraCreditos","codigoperiodo");
    //$recordsDescuentos = $utils->getDataFormCategoryDynamic($db,"formCreditoYCarteraDescuentos","codigoperiodo","siq_tipoDescuento");
    
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
                
                
</script>
<div id="tabs" class="dontCalculate">
	<ul>
		<li><a href="./formularios/financieros/viewCreditoYCarteraDescuentos.php">Estudiantes beneficiados por descuentos</a></li>
		<li><a href="./formularios/financieros/viewCreditoYCarteraApoyos.php">Estudiantes beneficiados por apoyos o estímulos</a></li>
		<li><a href="./formularios/financieros/viewBecasBeneficio.php">Estudiantes beneficiados por becas</a></li>
		<li><a href="./formularios/financieros/viewCreditosBeneficio.php">Estudiantes beneficiados por créditos</a></li>
		<li><a href="./formularios/financieros/viewPoblacion.php">Estudiantes admitidos por programas y convenios de poblaciones especiales y estratos bajos</a></li>
		<li><a href="./formularios/financieros/viewEstudiantesBeneficiados.php">Estudiantes que se han beneficiado de estas modalidades</a></li>
    
    
		
	</ul>      
    
    
    
    
    
</div> <!--- tabs -->
