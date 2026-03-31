
$( document ).ready(function() {
    $('#agregarEvidencia').on('click',function(){
          var id = $(this).attr("attr-id");
          $('.modal-body').load('registrarEvidencia.php?id='+id+'',function(){
              $("#tituloModal").html("<strong>Registrar evidencia</strong>");
              $('#myModal').modal({show:true});
        });
   
    });
    
	$('#modificarAvance').on('click',function(){
          var id = $(this).attr("attr-id");
          $('.modal-body').load('modificarAvance.php?id='+id+'',function(){
              $("#tituloModal").html("<strong>Modificar avance</strong>");
              $('#myModal').modal({show:true});
        });
   
    });
    
    $(".modificar").on('click',function(){
        var id = $(this).attr("attr-id");
          $('.modal-body').load('modificarEvidencia.php?id='+id+'',function(){
              $("#tituloModal").html("<strong>Modificar evidencia</strong>");
              $('#myModal').modal({show:true});
        });
    })
    
     var faIcon = {
            valid: 'fa fa-check-circle fa-lg text-success',
            invalid: 'fa fa-times-circle fa-lg',
            validating: 'fa fa-refresh'
    };
    
     $('#actualizarEvidencia').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: faIcon,
        fields: {
            descripcion:{
                validators: {
                    notEmpty: {
                        message: 'Debe digitar el nombre de la evidencia'
                    }
                }
            }
         }
    }) ;
    
    $('#registroEvidencia').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: faIcon,
        fields: {
             archivo: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar un  archivo'
                    }
                }
            },
            descripcion:{
                validators: {
                    notEmpty: {
                        message: 'Debe digitar el nombre de la evidencia'
                    }
                }
            }
         }
    })  .on('success.form.bv', function(e) {
        e.stopPropagation();
	e.preventDefault();
        var inputFile = document.getElementById( "archivo" );
        var descripcion =$("#descripcion").val();
        var valoracion = $("#valoracion").val();
        var tipoAccion = $("#tipoAccion").val();
        var id = $("#id").val();
        var file = inputFile.files;
		var filesize = inputFile.files[0].size;
        var data = new FormData();
        
	if(filesize > 8000000){
            alert("El archivo excede el tamaño permitido ( máximo 8mb)");
            location.reload(); 
	}
        
        data.append("id",id);
        data.append("descripcion",descripcion);
        data.append("tipoAccion",tipoAccion);
        data.append("archivo",file[0]);
        
        
        $.ajax({
            url: "registrar.php",
            type: "POST",
            contentType:false,
            data: data ,
            processData:false,
            cache:false,
            success: function( data ) {
                if(data==1){
                    alert("Se ha registrado la evidencia");
                    $('#myModal').modal('hide');
                    location.reload(); 
                } else if (data==0){
                    alert("El tipo de archivo seleccionado no es valido");
                }else if (data==2){
                    alert("No puede ingresar mas evidencias a la oportunidad");
                    location.reload(); 
                }else if (data==3){
                    alert("El archivo excede el tamaño permitido");
                    location.reload(); 
                }
                  
              }
           });
        });
             
    /**
     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Se inhabilitan algunos iconos, se hace traduccion de estos con la nueva libreria del editor de texto.
     * @since Agosto 15, 2019
     */          
     $('.content').richText({
                videoEmbed: false,
                imageUpload: false,
                fileUpload: false,
                code: false,
                translations: {
                    'title': 'Título',
                    'white': 'Blanco',
                    'black': 'Negro',
                    'brown': 'Café',
                    'beige': 'Beige',
                    'darkBlue': 'Azul Oscuro',
                    'blue': 'Azul',
                    'lightBlue': 'Azul Claro',
                    'darkRed': 'Rojo Oscuro',
                    'red': 'Rojo',
                    'darkGreen': 'Verde Oscuro',
                    'green': 'Verde',
                    'purple': 'Morado',
                    'darkTurquois': 'Turquesa Oscuro',
                    'turquois': 'Turques',
                    'darkOrange': 'Naranja Oscuro',
                    'orange': 'Naranja',
                    'yellow': 'Amarillo',
                    'imageURL': 'URL Imagen',
                    'fileURL': 'URL Archivo',
                    'linkText': 'Texto de enlace',
                    'url': 'URL',
                    'size': 'Tamaño',
                    'responsive': 'Responsive',
                    'text': 'Texto',
                    'openIn': 'Abrir en',
                    'sameTab': 'Mismo tab',
                    'newTab': 'Nuevo tab',
                    'align': 'Alinear',
                    'left': 'Izquierda',
                    'center': 'Centro',
                    'right': 'Derecha',
                    'rows': 'Filas',
                    'columns': 'Columnas',
                    'add': 'Agregar',
                    'pleaseEnterURL': 'Por favor ingrese una URL',
                    'videoURLnotSupported': 'URL del video no soportada',
                    'pleaseSelectImage': 'Por favor seleccione una imagen',
                    'pleaseSelectFile': 'Por favor seleccione un archivo',
                    'bold': 'Negrita',
                    'italic': 'Cursiva',
                    'underline': 'Subrayado',
                    'alignLeft': 'Alinear a la izquierda',
                    'alignCenter': 'Centrar',
                    'alignRight': 'Alinear a la derecha',
                    'addOrderedList': 'Agregar una lista ordenada',
                    'addUnorderedList': 'Agregar una lista desordenada',
                    'addHeading': 'Agregar cabecera',
                    'addFont': 'Agregar fuente',
                    'addFontColor': 'Agregar color de fuente',
                    'addFontSize': 'Agregar tamaño de fuente',
                    'addImage': 'Agregar imagen',
                    'addVideo': 'Agregar video',
                    'addFile': 'Agregar archivo',
                    'addURL': 'Agregar URL',
                    'addTable': 'Agregar tabla',
                    'removeStyles': 'Eliminar estilos',
                    'code': 'Mostrar código HTML',
                    'undo': 'Deshacer',
                    'redo': 'Rehacer',
                    'close': 'Cerrar'
                  }
            });   
    
    $("#accionAvance").on('click',function( e ){
        e.stopPropagation();
	e.preventDefault();
        var avanceevidencia =$("#avanceevidencia").val();
        var valoracion = $("#Valoracion").val();
        var tipoAccion = $("#tipoAccion").val();
        var id = $("#id").val();
        var data = new FormData();
        
        if(valoracion < 0 || valoracion > 100){
                alert('Debe ingresar una valoración entre 0 y 100');
                return false;
        }
		
        data.append("id",id);
        data.append("avanceevidencia",avanceevidencia);
        data.append("valoracion",valoracion);
        data.append("tipoAccion",tipoAccion);
        
        $.ajax({
            url: "registrar.php",
            type: "POST",
            contentType:false,
            data: data ,
            processData:false,
            cache:false,
            success: function( data ) {
                if(data==1){
                    alert("Se ha registrado correctamente el avance.")
                    window.history.go(-1); 
					return false;
                } else{
                    alert("Datos ingresados no validos")
                }
                  
              }
           });
        });
        
     $("#accionActualizar").on('click',function( e ){
        e.stopPropagation();
	e.preventDefault();
        
        var inputFile = document.getElementById( "archivo" );
        var descripcion =$("#descripcion").val();
        var tipoAccion = $("#tipoAccion").val();
        var archivoActual = $("#archivoActual").val();
        var id = $("#id").val();
        var nuevoArchivo = $("#archivo").val();
        var verificarArchivo = 0;
        var data = new FormData();
        if( nuevoArchivo!=null && nuevoArchivo!="" ){
            var file = inputFile.files;
            verificarArchivo=1;
             data.append("archivo",file[0]);
        }else{
           verificarArchivo = 0
        }
        data.append("id",id);
        data.append("descripcion",descripcion);
        data.append("tipoAccion",tipoAccion);
        data.append("archivoActual",archivoActual);   
        data.append("verificarArchivo",verificarArchivo);
        $.ajax({
            url: "registrar.php",
            type: "POST",
            contentType:false,
            data: data ,
            processData:false,
            cache:false,
            success: function( data ) {
                
                if(data==1){
                    alert("Evidencia actualizada")
                    $('#myModal').modal('hide');
                    location.reload(); 
                } else{
                    alert("El tipo de archivo seleccionado no es valido")
                }
            }
       });
        
        
    });   
    
 
    $(".eliminar").on("click",function(e){
        var id = $(this).attr("attr-id");
        var idOportunidad = $(this).attr("attr-idOportunidad");
        e.preventDefault();;
        var eliminar =  confirm("¿Deseas eliminar este registro?");
         if (eliminar){
            $.ajax({
                url: "registrar.php",
                type: "POST",
                data: {tipoAccion:"eliminar",id:id,idOportunidad:idOportunidad} ,
                success: function( data ) {

                    if(data==1){
                        alert("Registro eliminado")
                        location.reload(); 
                    } else{
                        alert("No se puede eliminar la unica evidencia");
                        location.reload(); 
                    }
                }
            });   
       }
        
    });
    
});
