/**
 * @author arizaandres
*/
$(document).ready(function() {
	//$(window).load(function() {
		if(typeof $(".chosen-select") != "undefined" ){
			$(".chosen-select").chosen({
				width: '100%',
				no_results_text: "No hay resultados para: "
			});
		}
	//});

	$('body ').bind('DOMNodeInserted DOMNodeRemoved', function() {
		if($(".chosen-select").css('display')!='none'){
			$(".chosen-select").chosen({
				width: '100%',
				no_results_text: "No hay resultados para: "
			});
		}
	});
});
//contenidoPlan
