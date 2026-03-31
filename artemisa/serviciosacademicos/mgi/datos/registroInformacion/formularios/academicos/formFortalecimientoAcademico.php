<script type="text/javascript">
	$(function() {
		$("#tabs").tabs({
			cache: true,
			beforeLoad: function( event, ui ) {
				ui.jqXHR.error(function() {
					ui.panel.html("Ocurrio un problema cargando el contenido." );
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
		//$("#tabs").tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		//$("#tabs li").removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	});
</script>
<div id="tabs" class="dontCalculate">
	<ul>
		<li><a href="formularios/academicos/formFortalecimientoAcademicoCapacitacionAcademicos.php">Capacitación a los académicos – Aprendizaje significativo</a></li>
		<!--<li><a href="formularios/academicos/formFortalecimientoAcademico2.php?alias=apeirbyh">Asignaturas del Plan de Estudios que incorporan el referente de la bioética y las humanidades</a></li>
		<li><a href="formularios/academicos/formFortalecimientoAcademico2.php?alias=auleaaecpupa">Asignaturas que utilizan lengua extranjera en las actividades de aprendizaje y evaluación del curso y porcentaje de utilización en el Programa Académico</a></li>
		<li><a href="formularios/academicos/formFortalecimientoAcademico2.php?alias=aaiaaepu">Asignaturas que articulan la internacionalización  con las actividades de aprendizaje y evaluación y porcentaje de utilización</a></li>
		<li><a href="formularios/academicos/formFortalecimientoAcademico2.php?alias=aihmtaeaaput">Asignaturas que incluyen herramientas mediadas por las  TIC en las actividades de evaluación y actividades de aprendizaje y porcentaje de utilización en total</a></li>-->
	</ul>
</div>

<script type="text/javascript">
    function addTableRow(formName) {
         var row = $(formName + ' table').children('tbody').children('tr:last').clone(true);
         row.find( 'input' ).each( function(){
            $( this ).val( '' );
            $(this).removeAttr("id");
            $(this).removeClass("hasDatepicker");       
        });
         $(formName + ' table').children('tbody').find('tr:last').after(row);  
         return true;
   }
   
   function removeTableRow(formName,inputName,action) {
       action = typeof action !== 'undefined' ? action : 'save2';
       
        if($(formName + ' table > tbody > tr').length>1){
         $(formName + ' table').children('tbody').children('tr:last').remove(); 
        } else if ($(formName + ' table').children('tbody').children('tr:last').find(inputName).val()=="") {
            alert("No puede eliminar la única fila. Debe por lo menos ingresar 1 dato.");
        } else {
            $(formName + ' table tbody input').each(function() {                                     
                   $(this).val("");                                       
             });
             $(formName + ' #action').val(action);
        }
         return true;
   }
</script>
