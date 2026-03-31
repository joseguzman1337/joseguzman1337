<?php
function selecciongrupo($objetobase,$formulario,$codigoperiodo) {
    echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
    echo "	<form id=\"formescogemateria\" name=\"formescogemateria\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"".$idencuestaaleatorio."\">";
 $usuario=$formulario->datos_usuario();
 //print_r($_SESSION);
    if($usuario["idusuario"]==4186) {
    //if(1) {
        //codigomodalidadacademica='".$_SESSION['admisiones_codigomodalidadacademica']."'
        $condicion="now()  between fechainiciocarrera and fechavencimientocarrera
                and codigocarrera=71 
			order by nombrecarrera2";
        $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
        $formulario->filatmp[""]="Seleccionar";
        		

    }
    else {
		//echo"<h1>entro</h1>";
		//print_r($_POST);
        $condicion=" c.codigocarrera=uf.codigofacultad
					and u.idusuario='".$usuario["idusuario"]."'
					and uf.usuario=u.usuario and c.codigocarrera='".$_SESSION["codigofacultad"]."'
					and now()  between fechainiciocarrera and fechavencimientocarrera
					order by nombrecarrera2";
        $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c, usuariofacultad uf, usuario u","c.codigocarrera","c.nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
        $formulario->filatmp[""]="Seleccionar";
    }
    $menu="menu_fila";
    $parametrosmenu="'codigocarrera','".$_POST['codigocarrera']."','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"CARRERA","tdtitulogris","codigocarrera","requerido");



   /* $condicion=" now() between e.fechainicioencuesta and e.fechafinalencuesta
            and e.codigocarrera='".$_POST['codigocarrera']."'";
    $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("encuesta e","idencuesta","nombreencuesta",$condicion);
    $formulario->filatmp[""]="Seleccionar";
    $menu="menu_fila";
    $condicion.=" and em.idencuesta=e.idencuesta and em.codigomateria='".$rowmateria["codigomateria"]."'";
    $datosencuestamateria=$objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em","e.codigocarrera",$_POST['codigocarrera']," and ".$condicion,"",0);

    $parametrosmenu="'idencuesta','".$_POST["idencuesta"]."','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"Encuesta","tdtitulogris","idencuesta","requerido");*/

    $condicion=" p.idplanestudio=dp.idplanestudio
           and dp.codigomateria=m.codigomateria
           and p.codigocarrera='".$_POST['codigocarrera']."'
           and p.codigoestadoplanestudio like '1%'
           and dp.codigoestadodetalleplanestudio like '1%'
            
            union 
select  m.codigomateria,m.nombremateria from materia m , planestudio p, lineaenfasisplanestudio le,detallelineaenfasisplanestudio dl
where 
dl.idlineaenfasisplanestudio=le.idlineaenfasisplanestudio
and dl.codigomateriadetallelineaenfasisplanestudio=m.codigomateria
           and p.codigocarrera='".$_POST['codigocarrera']."'
           and p.codigoestadoplanestudio like '1%'
           and dl.codigoestadodetallelineaenfasisplanestudio like '1%'
            and le.idplanestudio=p.idplanestudio
order by nombremateria
";
    $tablas="materia m , planestudio p, detalleplanestudio dp";
    $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila($tablas, "m.codigomateria","m.nombremateria",$condicion,"",0);
    $formulario->filatmp[""]="Seleccionar";

    $parametrosmenu="'codigomateria','".$_POST["codigomateria"]."','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"MATERIA","tdtitulogris","codigomateria","requerido");

   $condicion="md.codigomateria=m.codigomateria and
md.codigomateria='".$_POST['codigomateria']."'";
        $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modulopostind md,materia m","md.codigomodulopostind","md.nombremodulopostind",$condicion,"",0);
        $formulario->filatmp[""]="Seleccionar";


$menu="menu_fila";
    $parametrosmenu="'codigomodulopostind','".$_POST['codigomodulopostind']."','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"MODULO","tdtitulogris","codigomodulopostind","requerido");


    $condicion="d.iddocentemodulo=dm.iddocentemodulo and
md.codigomodulopostind=dm.codigomodulopostind and md.codigomodulopostind='".$_POST['codigomodulopostind']."'";
    $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modulopostind md,docentemodulo d,docentepormodulo dm ", "d.iddocentemodulo","d.nombredocentemodulo",$condicion,"",0,1);
    $formulario->filatmp[""]="Seleccionar";
    $parametrosmenu="'iddocente','".$_POST["iddocente"]."','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"DOCENTE","tdtitulogris","iddocente","requerido");

    $parametrosmenu="'button','Exportar','Exportar','onclick=\'enviarexportar();\''";
    $formulario->dibujar_campo("boton_tipo",$parametrosmenu,"Enviar","tdtitulogris","exportar","");

    echo "</form></table>";
}
?>
