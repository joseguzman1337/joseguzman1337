/**
 * @author arizaandres
*/
jQuery(document).ready(function() {
	jQuery(window).load(function() {
		$(".chosen-select").chosen({
			width: '100%',
			no_results_text: "No hay resultados para: "
		});
	});

	$('#contenidoPlan').bind('DOMNodeInserted DOMNodeRemoved', function() { 
		if($(".chosen-select").css('display')!='none'){
			$(".chosen-select").chosen({
				width: '100%',
				no_results_text: "No hay resultados para: "
			});
		}
	});
});
//contenidoPlan
