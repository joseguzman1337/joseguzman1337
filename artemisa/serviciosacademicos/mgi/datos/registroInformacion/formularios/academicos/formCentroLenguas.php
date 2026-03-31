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
                
                /*$("#tabs").bind("tabsload",function(event,ui){
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
                $( "#tabs" ).tabs('load',2);   */ 
                
	});
</script>

<div id="tabs" class="dontCalculate">
				<ul>
					<li><a href="./formularios/docentes/_formTalentoHumanoAcademicosDocentesOtroIdioma.php?id=<?php echo $id; ?>">Profesores que cursan programas de idioma no materno</a></li>
                                        
                                </ul>

</div>
