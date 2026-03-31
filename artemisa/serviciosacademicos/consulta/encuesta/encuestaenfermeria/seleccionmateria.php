<?php
function seleccionmateria($codigoestudiante,$objetobase,$formulario,$codigoperiodo) {    
    echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
    echo "	<form id=\"formescogemateria\" name=\"formescogemateria\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"".$idencuestaaleatorio."\">";

    //valida las materias matriculadas por periodo
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
        and now() between e.fechainicioencuesta and e.fechafinalencuesta)
	group by m.codigomateria";   
    $resultado=$objetobase->conexion->query($query);
  
    $formulario->filatmp[""]="Seleccionar";
    
    //verifica la cantidad de preguntas para la encuesta y la compara con la cantidad de respuestas
    // si las cantidades coinciden oculta la materia y muestra las demas
    while($rowmateria=$resultado->fetchRow()){
        
         $query2="SELECT count(distinct r.idrespuestaautoevaluacion) cuenta  FROM respuestaautoevaluacion r,
        encuestapregunta ep,pregunta p where
        r.idencuestapregunta=ep.idencuestapregunta and
        p.idpregunta=ep.idpregunta and
        p.codigoestado = '100' and
        ep.codigoestado = '100' and
        p.idtipopregunta NOT IN (100,101,201) and
        r.codigoestudiante=".$codigoestudiante." and
        r.codigoperiodo='".$codigoperiodo."' and
        r.codigomateria='".$rowmateria["codigomateria"]."'
         and r.codigoestado = '100'";
         
        $query1=$query2." and r.valorrespuestaautoevaluacion <> ''";
     
        $resultadorespuesta1=$objetobase->conexion->query($query1);
        $registros1=$resultadorespuesta1->fetchRow( );
        
        $resultadorespuesta2=$objetobase->conexion->query($query2);
        $registros2=$resultadorespuesta2->fetchRow( );

        if($registros1["cuenta"]== 0){
            $formulario->filatmp[$rowmateria["codigomateria"]]=$rowmateria["nombremateria"];
            $materias[$rowmateria["codigomateria"]]=$rowmateria; 
        }else{
            if($registros1["cuenta"] <> $registros2["cuenta"]){
                $formulario->filatmp[$rowmateria["codigomateria"]]=$rowmateria["nombremateria"];
                $materias[$rowmateria["codigomateria"]]=$rowmateria;
            }
        }
    }
    $formulario->dibujar_fila_titulo('Encuesta evaluacion docente seleccion de asignaturas','labelresaltado',"2","align='center'");

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
