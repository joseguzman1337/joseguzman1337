$(document).ready(function(){
	//evento que se dispara al hacer clic en el boton para agregar una nueva fila
	$(document).on('click','.clsAgregarFila',function(){
		//almacenamos en una variable todo el contenido de la nueva fila que deseamos
		//agregar. pueden incluirse id's, nombres y cualquier tag... sigue siendo html
		var strNueva_Fila='<tr>'+
			'<td><input type="text" class="clsAnchoTotal"></td>'+
			'<td><input type="text" class="clsAnchoTotal"></td>'+
			'<td><input type="text" class="clsAnchoTotal"></td>'+
			'<td align="right"><input type="button" value="-" class="clsEliminarFila"></td>'+
		'</tr>';
		
		/*obtenemos el padre del boton presionado (en este caso queremos la tabla, por eso
		utilizamos get(3)
			table -> padre 3
				tfoot -> padre 2
					tr -> padre 1
						td -> padre 0
		nosotros queremos utilizar el padre 3 para agregarle en la etiqueta
		tbody una nueva fila*/
		var objTabla=$(this).parents().get(3);
				
		//agregamos la nueva fila a la tabla
		$(objTabla).find('tbody').append(strNueva_Fila);
				
		//si el cuerpo la tabla esta oculto (al agregar una nueva fila) lo mostramos
		if(!$(objTabla).find('tbody').is(':visible')){
			//le hacemos clic al titulo de la tabla, para mostrar el contenido
			$(objTabla).find('caption').click();
		}
	});
	
	//cuando se haga clic en cualquier clase .clsEliminarFila se dispara el evento
	$(document).on('click','.clsEliminarFila',function(){
		/*obtener el cuerpo de la tabla; contamos cuantas filas (tr) tiene
		si queda solamente una fila le preguntamos al usuario si desea eliminarla*/
		var objCuerpo=$(this).parents().get(2);
			if($(objCuerpo).find('tr').length==1){
				if(!confirm('Esta es el única fila de la lista ¿Desea eliminarla?')){
					return;
				}
			}
					
		/*obtenemos el padre (tr) del td que contiene a nuestro boton de eliminar
		que quede claro: estamos obteniendo dos padres
					
		el asunto de los padres e hijos funciona exactamente como en la vida real
		es una jergarquia. imagine un arbol genealogico y tendra todo claro ;)
				
			tr	--> padre del td que contiene el boton
				td	--> hijo de tr y padre del boton
					boton --> hijo directo de td (y nieto de tr? si!)
		*/
		var objFila=$(this).parents().get(1);
			/*eliminamos el tr que contiene los datos del contacto (se elimina todo el
			contenido (en este caso los td, los text y logicamente, el boton */
			$(objFila).remove();
	});
	
			
});