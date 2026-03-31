<?php
function selecciongrupo($objetobase,$formulario,$codigoperiodo) {
    echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
    echo "	<form id=\"formescogemateria\" name=\"formescogemateria\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"".$idencuestaaleatorio."\">";
 $usuario=$formulario->datos_usuario();
   
    




        $condicion=" g.codigoperiodo=20112
and g.codigotipogrupomateria ='100'
and g.nombregrupomateria like '%apoyo%'";
        $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("grupomateria g","g.idgrupomateria","g.nombregrupomateria",$condicion," ",0);
        $formulario->filatmp[""]="Seleccionar";
    //}
    $menu="menu_fila";
    $parametrosmenu="'idgrupomateria','".$_POST['idgrupomateria']."','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"Grupo Materia","tdtitulogris","idgrupomateria","requerido");
   
   
    $condicion=" gm.codigoperiodo= '20112'
                    and gm.idgrupomateria=dgm.idgrupomateria
                    and m.codigomateria=dgm.codigomateria
                    and gm.codigotipogrupomateria ='100'
                    and dgm.idgrupomateria ='".$_POST['idgrupomateria']."'
                    group by m.codigomateria order by m.nombremateria";
    $tablas="materia m , grupomateria gm, detallegrupomateria dgm";
    $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila($tablas, "m.codigomateria","m.nombremateria",$condicion,"",0);
    $formulario->filatmp[""]="Seleccionar";

    $parametrosmenu="'codigomateria','".$_POST["codigomateria"]."','onchange=\'enviarmateria();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"Materia","tdtitulogris","codigomateria","requerido");
    
    
    
    $condicion="g.codigomateria='".$_POST["codigomateria"]."'
        and g.numerodocumento=d.numerodocumento  and
        g.codigoperiodo='".$_SESSION["codigoperiodo_autoenfermeria"]."'
        group by d.iddocente
        order by nombredocentecompleto
        ";
    $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("grupo g, docente d", "d.iddocente","concat(g.idgrupo,') ',d.apellidodocente,' ',d.nombredocente) nombredocentecompleto",$condicion,"",0,0);
    $formulario->filatmp[""]="Seleccionar";
    $parametrosmenu="'iddocente','".$_POST["iddocente"]."','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"Grupo) Docente","tdtitulogris","iddocente","requerido");

    $parametrosmenu="'button','Exportar','Exportar','onclick=\'enviarexportar();\''";
    $formulario->dibujar_campo("boton_tipo",$parametrosmenu,"Enviar","tdtitulogris","exportar","");

    echo "</form></table>";
}
?>
