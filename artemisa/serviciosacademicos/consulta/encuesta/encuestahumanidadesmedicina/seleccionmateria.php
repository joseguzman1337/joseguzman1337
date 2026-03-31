<?php
function seleccionmateria($codigoestudiante,$objetobase,$formulario,$codigoperiodo) {
    echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
    echo "	<form id=\"formescogemateria\" name=\"formescogemateria\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
              	<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"".$idencuestaaleatorio."\">";


   // echo $idencuestaaleatorio;
      /* $formulario->dibujar_fila_titulo('Encuesta evaluacion docente seleccion de asignaturas ','labelresaltado',"2","align='center'");

        $condicion="g.codigoperiodo='".$codigoperiodo."'
            and g.codigotipogrupomateria ='100'
            and g.nombregrupomateria like '%apoyo%';";
$formulario->filatmp[""]="Seleccionar";
        $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("grupomateria g","idgrupomateria","nombregrupomateria",$condicion,'',0);
        
       	$campo='menu_fila'; $parametros="'idgrupomateria','".$_POST['idgrupomateria']."','onchange=enviargrupo();'";
	$formulario->dibujar_campo($campo,$parametros,"Grupo Materia ","tdtitulogris",'codigocarrera','requerido');*/

 $query="select *,if(h.horainicial>='18:00','Nocturna','Diurna') jornada from prematricula p,detalleprematricula dp,
	materia m,docente d,grupo g
	left join horario h on h.idgrupo=g.idgrupo
	left join dia di on di.codigodia=h.codigodia
	where
	p.idprematricula=dp.idprematricula and
	dp.codigomateria=m.codigomateria and
	p.codigoestadoprematricula like '4%' and
	dp.codigoestadodetalleprematricula like '3%' and
	g.idgrupo=dp.idgrupo and
	g.numerodocumento=d.numerodocumento and
	p.codigoperiodo='".$codigoperiodo."' and
	p.codigoestudiante=".$codigoestudiante." and
        m.codigomateria in (select codigomateria from encuestamateria em , encuesta e
        where em.idencuesta=e.idencuesta
        and now() between e.fechainicioencuesta and e.fechafinalencuesta and e.idencuesta in(64,72))
	group by m.codigomateria";
    $resultado=$objetobase->conexion->query($query);
 $formulario->filatmp[""]="Seleccionar";
   
   while($rowmateria=$resultado->fetchRow()) {

   /*echo "<pre>";
   print_r($rowmateria);
   echo "</pre>";*/

  //echo "<br>";
 $query=" select count(distinct r.idrespuestaautoevaluacion) cuenta from respuestaautoevaluacion r,
                                encuestapregunta ep,pregunta p where
                                r.idencuestapregunta=ep.idencuestapregunta and
                                p.idpregunta=ep.idpregunta and
                                p.codigoestado like '1%' and
                                ep.codigoestado like '1%' and
                                p.idtipopregunta not in (100,101,201) and
				r.codigoestudiante=".$codigoestudiante." and
				r.codigoperiodo='".$codigoperiodo."'
                                 and r.valorrespuestaautoevaluacion <> ''
				and r.codigomateria='".$rowmateria["codigomateria"]."'
				 and r.codigoestado like '1%'
having cuenta = (
select count(distinct r.idrespuestaautoevaluacion) cuenta from respuestaautoevaluacion r,
                                encuestapregunta ep,pregunta p where
                                r.idencuestapregunta=ep.idencuestapregunta and
                                p.idpregunta=ep.idpregunta and
                                p.codigoestado like '1%' and
                                ep.codigoestado like '1%' and
                                p.idtipopregunta not in (100,101,201) and
				r.codigoestudiante=".$codigoestudiante." and
				r.codigoperiodo='".$codigoperiodo."' and
r.codigomateria='".$rowmateria["codigomateria"]."'
				 and r.codigoestado like '1%'

)";
        $resultadorespuesta=$objetobase->conexion->query($query);
        $registros=$resultadorespuesta->fetchRow( );

        if(!($registros["cuenta"]>0)) {
            $formulario->filatmp[$rowmateria["codigomateria"]]=$rowmateria["nombremateria"];
            $materias[$rowmateria["codigomateria"]]=$rowmateria;
        }
    }

    $menu="menu_fila";
    $parametrosmenu="'codigomateria','".$_POST['codigomateria']."','onchange=\'enviarmateria();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"Materia","tdtitulogris","codigomateria","requerido");

    $nombredocente=$materias[$_POST['codigomateria']]['apellidodocente']." ".$materias[$_POST['codigomateria']]['nombredocente'];
    $menu="boton_tipo";
    $parametrosmenu="'docente','docente','".$nombredocente."',' size=50 readonly=yes '";
    $formulario->dibujar_campo($menu,$parametrosmenu,"Docente","tdtitulogris","docente","");
    echo "</form></table>";
}
?>
