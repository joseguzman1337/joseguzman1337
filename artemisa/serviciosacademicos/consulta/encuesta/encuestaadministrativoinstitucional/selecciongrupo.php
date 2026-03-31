<?php
function seleccionCarrera($objetobase,$formulario,$codigoperiodo) {
    echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
    echo "	<form id=\"formescogemateria\" name=\"formescogemateria\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"".$idencuestaaleatorio."\">";
 $usuario=$formulario->datos_usuario();
  //  if($usuario["idusuario"]==4186) {
    //if(1) {
        //codigomodalidadacademica='".$_SESSION['admisiones_codigomodalidadacademica']."'
        $condicion = " ( c.codigomodalidadacademica in  ('200')
                            and now() between fechainiciocarrera and fechavencimientocarrera )
and codigocarrera not in (1,2,156,124,119,134,496,484,483,417,492) or  
(c.codigomodalidadacademica like '5%' and codigocarrera not in (1,2,156,124,119,134,496,484,483,417,492)  ) 
or codigocarrera in (3) 
				and (c.codigocarrera not in (7,560,554))
			and codigocarrera in (select codigocarrera from respuestainstitucionaldocente group by codigocarrera)	
				order by nombrecarrera2";

        $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
        $formulario->filatmp[""]="Seleccionar";
    /*}
    else {
        $condicion=" c.codigocarrera=uf.codigofacultad
					and u.idusuario='".$usuario["idusuario"]."'
					and uf.usuario=u.usuario
					and now()  between fechainiciocarrera and fechavencimientocarrera
					order by nombrecarrera2";
        $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c, usuariofacultad uf, usuario u","c.codigocarrera","c.nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
        $formulario->filatmp[""]="Seleccionar";
    }*/
    $menu="menu_fila";
    $parametrosmenu="'codigocarrera','".$_POST['codigocarrera']."','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"Carrera","tdtitulogris","codigocarrera","requerido");


  
  
    $parametrosmenu="'button','Exportar','Exportar','onclick=\'enviarexportar();\''";
    $formulario->dibujar_campo("boton_tipo",$parametrosmenu,"Enviar","tdtitulogris","exportar","");

    echo "</form></table>";
}
?>
