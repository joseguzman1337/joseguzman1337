<?php

session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
 
?>
<link rel="stylesheet" href="../../css/styleAutoevaluacion.css" />
<div id="container">   
		<div class="demo_jui">
                    <fieldset>
                      <legend>Respuestas</legend>
                      <input type="hidden" name="texto_inicio" id="texto_inicio" value="NULL" />
                      <input type="hidden" name="texto_final" id="texto_final" value="NULL" />
                      <input type="hidden" name="multiple_respuesta" id="multiple_respuesta" value="0" />
                      <input type="hidden" name="unica_respuesta" id="unica_respuesta" value="0" />
                      <input type="hidden" name="analisis" id="analisis" value="0" />
                      <input type="hidden" name="aparejamiento" id="aparejamiento" value="1" />
                            <table align="center" width="80%" border="0">
                                
                                    <thead>
                                            <tr>
                                                    <th>Columna A</th>
                                                    <th>Columna B</th>
                                                    <th width="22">&nbsp;</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                    <td width="80%">
                                                        1.<input type="text" name="nombreA1[0]" id="nombreA1_0" style="width: 300px" >
                                                    </td>
                                                    <td><input type="text" name="nombreA2[0]" id="nombreA2_0" style="width: 150px" ></td>
                                                    <td align="right"><input type="button" value="" class="button medium clsEliminarFilaAP"></td>
                                            </tr>
                                    </tbody>
                                    <tfoot>
                                            <tr>
                                                    <td colspan="4" align="right">
                                                            <input type="button" value="Agregar Respuesta" class="button medium clsAgregarFilaAP">
                                                    </td>
                                            </tr>
                                    </tfoot>
                            </table>
                    </fieldset>
		</div>
	</div>
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script>
            var i=1; j=2;
            $(document).ready(function(){
                    //evento que se dispara al hacer clic en el boton para agregar una nueva fila
                    $(document).on('click','.clsAgregarFilaAP',function(){
                       // alert(i);
                            //almacenamos en una variable todo el contenido de la nueva fila que deseamos
                            //agregar. pueden incluirse id's, nombres y cualquier tag... sigue siendo html
                            var strNueva_FilaAP='<tr>'+
                                    '<td width="80%">'+j+'.<input type="text" name="nombreA1['+i+']" id="nombreA1_'+i+'" style="width: 300px"></td>'+
                                    '<td><input type="text" name="nombreA2['+i+']" id="nombreA2_'+i+'" style="width: 150px"></td>'+
                                    '<td align="right"><input type="button" value="" class="button medium clsEliminarFilaAP" ></td>'+
                            '</tr>';
                            i=i+1; j=j+1;
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
                            $(objTabla).find('tbody').append(strNueva_FilaAP);

                            //si el cuerpo la tabla esta oculto (al agregar una nueva fila) lo mostramos
                            if(!$(objTabla).find('tbody').is(':visible')){
                                    //le hacemos clic al titulo de la tabla, para mostrar el contenido
                                    $(objTabla).find('caption').click();
                            }
                    });

                    //cuando se haga clic en cualquier clase .clsEliminarFila se dispara el evento
                    $(document).on('click','.clsEliminarFilaAP',function(){
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
        
    </script>
<?php 

?>