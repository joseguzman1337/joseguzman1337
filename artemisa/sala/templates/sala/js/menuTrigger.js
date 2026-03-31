$(document).ready(function(){
	$('.menuItem').click(function(e){
		e.stopPropagation();
		e.preventDefault();
		loadMenuContent(this);
	});
	$("#txt_buscador").keyup(function() {
		ajax_showOptions(this,'leeMenus',$(this).val()); 
	});
});
function loadMenuContent(obj){
	var hr = $(obj).attr('href').trim();
	var reliframe = $(obj).attr('rel').trim();
	$("ul#mainnav-menu>li, ul.collapse>li").removeClass("active-link");
	$(obj).parent().addClass("active-link");
	if(reliframe=="iframe" && (hr!="" && hr!="#")){
		var height = $(document).outerHeight() - 175;
		var frame = '<iframe width="100%" height="'+height+'" frameborder="0" scrolling="auto" marginheight="0" marginwidth="0" name="contenidocentral" id="contenidocentral" src="'+hr+'"></iframe>';
		 
		$( "#page-content" ).html( frame );
		//alert(boxed); 
	}else if(reliframe=="" && hr!="" && hr!="#" ){
		$.ajax({
			url: $(obj).attr('href'),
			type: "GET",
			data: {tmpl : 'json'},
			success: function( data ){
				$( "#page-content" ).html( data );
			}
		});
	}
}
function triggerMenu(obj){
	$('#menuId_'+obj ).trigger('click'); 
}
