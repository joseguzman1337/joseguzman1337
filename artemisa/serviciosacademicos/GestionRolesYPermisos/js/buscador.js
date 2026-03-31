$(document).ready(function(){
	jQuery(window).load(function() {
		$(".buscador #RelacionUsuario").change(function(){
			recargarUsuario($(this).val());
			recargarTablaComponentes($(this).val(),null);
		});
                
                $("a.accion").click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    actualizaPermisos(this);
                });
                $("a.habilitarPermisos").click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    habilitarPermisos(this);
                });
                $(".paginate").click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    cambiarPagina(this);
                });
                $("#idComponente").change(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    $("#selectComponent").submit();
                });
                
	});
});//buscador

function recargarUsuario(relacionUsuario){
	var url = "index.php";
	$.ajax({
        dataType: 'json',
        type: 'GET',
        url: url,
        data: {
        	option : 'recargarUsuario',
        	json : true,
        	RelacionUsuario:relacionUsuario
        },
        success: function(data) {
        	if(data.success){
        		$("#selectUsuario").html(data.usuarios);
        		
        		$("#Usuario").chosen({
                            width: '100%',
                            no_results_text: "No hay resultados para: "
                        });
                        
                        $(".buscador #Usuario").change(function(){ 
                            recargarTablaComponentes($(".buscador #RelacionUsuario").val(), $(this).val());
                        });
        	}
        }
    }); 
}

function recargarTablaComponentes(relacionUsuario, usuario){
    var idComponente = $("#idComponente").val();
    var url = "index.php";
    var page = $("#page").val();
    var ipp = $("#ipp").val();
    $.ajax({
        dataType: 'html',
        type: 'GET',
        url: url,
        data: {
        	option : 'recargarTablaComponentes',
        	json : true,
        	RelacionUsuario: relacionUsuario,
        	Usuario: usuario,
                idComponente: idComponente,
                page: page,
                ipp: ipp
        },
        success: function(data) { 
        	$("#contenedorTabla").html(data);
                $("a.accion").click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    actualizaPermisos(this);
                });
                $("a.habilitarPermisos").click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    habilitarPermisos(this);
                });
                $(".paginate").click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    cambiarPagina(this);
                });
        }
    });	
}
function cambiarPagina(obj){ 
    var url = $(obj).attr("href");
    url = url.replace("option=componentes", "option=recargarTablaComponentes"); 
    var uri_dec = URLToArray(url);
    
    $.ajax({
        dataType: 'html',
        type: 'GET',
        url: url,
        data: {
        	json : true
        },
        success: function(data) { 
        	$("#contenedorTabla").html(data);
                $("a.accion").click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    actualizaPermisos(this);
                });
                $("a.habilitarPermisos").click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    habilitarPermisos(this);
                });
                $(".paginate").click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    cambiarPagina(this);
                });
                $("#ipp").val(uri_dec.ipp);
                $("#page").val(uri_dec.page);
        }
    });/**/
}

function actualizaPermisos(obj){
    var relacionUsuario = $(obj).attr("data-relacionUsuario");
    var idUsuario = $(obj).attr("data-idUsuario");
    var idComponent = $(obj).attr("data-idComponent");
    var tipoPermiso = $(obj).attr("data-tipoPermiso");
    var action = $(obj).attr("data-action");
    var page = $("#page").val();
    var ipp = $("#ipp").val();
    
    var url = "index.php";
    $.ajax({
        dataType: 'json',
        type: 'GET',
        url: url,
        data: {
        	option : 'actualizaPermisos',
        	json : true,
        	relacionUsuario: relacionUsuario,
        	idUsuario: idUsuario,
        	idComponent: idComponent,
        	tipoPermiso: tipoPermiso,
        	action: action,
                page: page,
                ipp: ipp
        },
        success: function(data) {
            if(data){
                var RelacionUsuario = $("#RelacionUsuario").val();
                var Usuario = $("#Usuario").val();
                if(Usuario < 0){
                    Usuario = null;
                }
                recargarTablaComponentes(RelacionUsuario, Usuario);
            }
        }
    });	
}
function habilitarPermisos(obj){
    var relacionUsuario = $(obj).attr("data-relacionUsuario");
    var idUsuario = $(obj).attr("data-idUsuario");
    var idComponent = $(obj).attr("data-idComponent");
    var tipoPermiso = $(obj).attr("data-tipoPermiso"); 
    var page = $("#page").val();
    var ipp = $("#ipp").val();
    
    var url = "index.php";
    $.ajax({
        dataType: 'json',
        type: 'GET',
        url: url,
        data: {
        	option : 'habilitarPermisosParaUsuario',
        	json : true,
        	relacionUsuario: relacionUsuario,
        	idUsuario: idUsuario,
        	idComponent: idComponent,
        	tipoPermiso: tipoPermiso, 
                page: page,
                ipp: ipp
        },
        success: function(data) {
            if(data){
                var RelacionUsuario = $("#RelacionUsuario").val();
                var Usuario = $("#Usuario").val();
                if(Usuario < 0){
                    Usuario = null;
                }
                recargarTablaComponentes(RelacionUsuario, Usuario);
            }
        }
    });	
}

function URLToArray(url) {
    var request = {};
    var arr = [];
    var pairs = url.substring(url.indexOf('?') + 1).split('&');
    for (var i = 0; i < pairs.length; i++) {
      var pair = pairs[i].split('=');

      //check we have an array here - add array numeric indexes so the key elem[] is not identical.
      if(endsWith(decodeURIComponent(pair[0]), '[]') ) {
          var arrName = decodeURIComponent(pair[0]).substring(0, decodeURIComponent(pair[0]).length - 2);
          if(!(arrName in arr)) {
              arr.push(arrName);
              arr[arrName] = [];
          }

          arr[arrName].push(decodeURIComponent(pair[1]));
          request[arrName] = arr[arrName];
      } else {
        request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
      }
    }
    return request;
}
function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
}