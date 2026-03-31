<?php
function seleccionmateria($codigoestudiante,$objetobase,$formulario,$codigoperiodo) {
    echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
    echo "	<form id=\"formescogemateria\" name=\"formescogemateria\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
              	<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"".$idencuestaaleatorio."\">";


   
      $formulario->dibujar_fila_titulo('Encuesta evaluacion docente seleccion de asignaturas ','labelresaltado',"2","align='center'");

 $query="select * 
from prematricula p,detalleprematricula dp, materia m,modulopostind mmt, 
docentemodulo dm,docentepormodulo dpm, grupo g left join horario h on h.idgrupo=g.idgrupo 
left join dia di on di.codigodia=h.codigodia
where p.idprematricula=dp.idprematricula 
and dp.codigomateria=m.codigomateria 
and mmt.codigomateria=m.codigomateria 
and mmt.codigomodulopostind=dpm.codigomodulopostind 
and dm.iddocentemodulo=dpm.iddocentemodulo 
and p.codigoestadoprematricula like '4%' 
and dp.codigoestadodetalleprematricula like '3%' 
and g.idgrupo=dp.idgrupo 
and p.codigoperiodo='".$codigoperiodo."' 
and p.codigoestudiante=".$codigoestudiante."
and m.codigomateria in (select codigomateria from encuestamateria em , encuesta e 
where em.idencuesta=e.idencuesta and now() between e.fechainicioencuesta 
and e.fechafinalencuesta) 
";
    $resultado=$objetobase->conexion->query($query);
 $formulario->filatmp[""]="Seleccionar";
   
   while($rowmateria=$resultado->fetchRow()) {

   $query="select count(distinct r.idrespuestaautoevaluacionpost) cuenta from respuestaautoevaluacionpost r,
                                encuestapregunta ep,pregunta p where
                                r.idencuestapregunta=ep.idencuestapregunta and
                                p.idpregunta=ep.idpregunta and
                                p.codigoestado like '1%' and
                                ep.codigoestado like '1%' and
                                p.idtipopregunta not in (100,101,201) and
				r.codigoestudiante=".$codigoestudiante." and
				r.codigoperiodo='".$codigoperiodo."'
                                 and r.valorrespuestaautoevaluacionpost <> ''
                                and r.codigomateria='".$rowmateria["codigomateria"]."' and r.codigomodulopostind='".$rowmateria["codigomodulopostind"]."'
				 and r.codigoestado like '1%'
having cuenta = (
select count(distinct r.idrespuestaautoevaluacionpost) cuenta from respuestaautoevaluacionpost r,
                                encuestapregunta ep,pregunta p where
                                r.idencuestapregunta=ep.idencuestapregunta and
                                p.idpregunta=ep.idpregunta and
                                p.codigoestado like '1%' and
                                ep.codigoestado like '1%' and
                                p.idtipopregunta not in (100,101,201) and
				r.codigoestudiante=".$codigoestudiante." and
				r.codigoperiodo='".$codigoperiodo."' and
 r.codigomateria='".$rowmateria["codigomateria"]."' and r.codigomodulopostind='".$rowmateria["codigomodulopostind"]."'
				 and r.codigoestado like '1%'

)";

        $resultadorespuesta=$objetobase->conexion->query($query);
        $registros=$resultadorespuesta->fetchRow( );

        if(!($registros["cuenta"]>0)) {
            $formulario->filatmp[$rowmateria["codigomodulopostind"]]=$rowmateria["nombremodulopostind"];
            $materias[$rowmateria["codigomodulopostind"]]=$rowmateria;
        }
            $_SESSION["codigomateria"]=$rowmateria["codigomateria"];
    }


    $menu="menu_fila";
    $parametrosmenu="'codigomodulopostind','".$_POST['codigomodulopostind']."','onchange=\'enviar();\''";
    
    $formulario->dibujar_campo($menu,$parametrosmenu,"MODULO","tdtitulogris","codigomodulopostind","requerido");
    
    
     $condicion="d.iddocentemodulo=dm.iddocentemodulo and
md.codigomodulopostind=dm.codigomodulopostind and md.codigomodulopostind='".$_POST['codigomodulopostind']."'";
    $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modulopostind md,docentemodulo d,docentepormodulo dm ", "d.iddocentemodulo","d.nombredocentemodulo",$condicion,"",0,1);
    $formulario->filatmp[""]="Seleccionar";
    $parametrosmenu="'iddocentemodulo','".$_POST['iddocentemodulo']."','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"Docente","tdtitulogris","iddocentemodulo","requerido");    
    echo "</form></table>";
}
?>
