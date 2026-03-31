<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se incluye el parametro  instrumento de configuracion con sus respectivos datos y clases para que muestre tambien las respuestas. 
 * @since Abril 9, 2019
 */ 
function selecciongrupo($objetobase, $formulario, $codigoperiodo) {
    echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
    echo "<form id=\"formescogemateria\" name=\"formescogemateria\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
        <input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<input type=\"hidden\" name=\"idencuesta\" value=\"" . $idencuestaaleatorio . "\">";
    $usuario = $formulario->datos_usuario();

    $condicion = " p.codigoperiodo>'20102' order by p.codigoperiodo desc";
    $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("periodo p", "p.codigoperiodo", "p.nombreperiodo", $condicion, " ", 0);
    $formulario->filatmp[""] = "Seleccionar";

    $menu = "menu_fila";
    $parametrosmenu = "'codigoperiodo','" . $_POST['codigoperiodo'] . "','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu, $parametrosmenu, "Periodo", "tdtitulogris", "codigoperiodo", "requerido");

    $condicion = "cat_ins = 'EDOCENTES'  AND s.codigoestado = '100' and s.fecha_inicio >= (select fechainicioperiodo from periodo where codigoperiodo = '" . $_POST['codigoperiodo'] . "')  AND s.fecha_fin <= (select fechavencimientoperiodo from periodo where codigoperiodo = '" . $_POST['codigoperiodo'] . "')";
    $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("siq_Ainstrumentoconfiguracion s", "s.idsiq_Ainstrumentoconfiguracion", "s.nombre", $condicion, " ", 0);
    $formulario->filatmp[""] = "Seleccionar Instrumento";

    $menu = "menu_fila";
    $parametrosmenu = "'idinstrumento','" . $_POST['idinstrumento'] . "'";
    $formulario->dibujar_campo($menu, $parametrosmenu, "Instrumento", "tdtitulogris", "idinstrumento", "");

    $condicion = " g.codigoperiodo='" . $_POST['codigoperiodo'] . "' and g.codigotipogrupomateria ='100' and CodigoEstado=100 ";
    $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("grupomateria g", "g.idgrupomateria", "g.nombregrupomateria", $condicion, " ", 0);
    if (empty($formulario->filatmp)) {
        $formulario->filatmp[""] = "Seleccionar";
    }

    $parametrosmenu = "'idgrupomateria','" . $_POST['idgrupomateria'] . "','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu, $parametrosmenu, "Grupo Materia", "tdtitulogris", "idgrupomateria", "requerido");


    $condicion = " gm.codigoperiodo= '" . $_POST['codigoperiodo'] . "' and gm.idgrupomateria=dgm.idgrupomateria
                    and m.codigomateria=dgm.codigomateria and gm.codigotipogrupomateria ='100'
                    and dgm.idgrupomateria ='" . $_POST['idgrupomateria'] . "' group by m.codigomateria order by m.nombremateria";
    $tablas = "materia m , grupomateria gm, detallegrupomateria dgm";
    $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila($tablas, "m.codigomateria", "m.nombremateria", $condicion, "", 0);
    $formulario->filatmp[""] = "Seleccionar";

    $parametrosmenu = "'codigomateria','" . $_POST["codigomateria"] . "','onchange=\'enviarmateria();\''";
    $formulario->dibujar_campo($menu, $parametrosmenu, "Materia", "tdtitulogris", "codigomateria", "requerido");

    $condicion = "g.codigomateria='" . $_POST["codigomateria"] . "' and g.numerodocumento=d.numerodocumento  and
        g.codigoperiodo='" . $_POST['codigoperiodo'] . "' group by d.iddocente order by nombredocentecompleto ";
    $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("grupo g, docente d", "concat(d.iddocente,'**',g.idgrupo) iddocgru", "concat(g.idgrupo,') ',d.apellidodocente,' ',d.nombredocente) nombredocentecompleto", $condicion, "", 0, 0);
    $formulario->filatmp[""] = "Seleccionar";
    $parametrosmenu = "'iddocgru','" . $_POST["iddocgru"] . "','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu, $parametrosmenu, "Grupo) Docente", "tdtitulogris", "iddocgru", "requerido");


    echo "<input type=\"hidden\" id=\"iddocente\" name=\"iddocente\" value=\"" . $_POST['iddocente'] . "\">";
    echo "<input type=\"hidden\" id=\"idgrupo\" name=\"idgrupo\" value=\"" . $_POST['idgrupo'] . "\">";

    $parametrosmenu = "'button','Exportar','Exportar','onclick=\'enviarexportar();\''";
    $formulario->dibujar_campo("boton_tipo", $parametrosmenu, "Enviar", "tdtitulogris", "exportar", "");

    echo "</form></table>";
}

?>
