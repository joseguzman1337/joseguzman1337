<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
class ValidaEncuesta {
    var $objetobase;
    var $codigoperiodo;
    var $codigoestudiante;
    var $idasistente;

    

    function ValidaEncuesta($objetobase,$codigoperiodo,$codigoestudiante) {
        $this->objetobase=$objetobase;
        $this->codigoperiodo=$codigoperiodo;
        $this->codigoestudiante=$codigoestudiante;
    }
    function setidasistente($idasistente) {
        $this->idasistente=$idasistente;
    }
    function encuestaCarreraActiva(){
      //  echo "<H1>ENTRO1</H1>";
        $condicion=" and ec.codigocarrera=e.codigocarrera"
         ." and now() between ec.fechainiciomenubotoncarrera and fechafinalmenubotoncarrera"
        ." and idmenuboton not in (85,82) and e.codigoestudiante='".$this->codigoestudiante."'";
        if($datosencuesta=$this->objetobase->recuperar_datos_tabla("menubotoncarrera ec , estudiante e","1","1",$condicion,"",0))
                {
            return 1;
        }
        return 0;
    }
    function encuestaCarreraActivahumanidades(){
      //  echo "<H1>ENTRO1</H1>";
        $condicion=" and ec.codigocarrera=e.codigocarrera"
         ." and now() between ec.fechainiciomenubotoncarrera and fechafinalmenubotoncarrera"
        ." and idmenuboton=85 and e.codigoestudiante='".$this->codigoestudiante."'";
        if($datosencuesta=$this->objetobase->recuperar_datos_tabla("menubotoncarrera ec , estudiante e","1","1",$condicion,"",0))
                {
            return 1;
        }
        return 0;
    }
    //Hacer el nuevo query para validar
    function validaEncuestaCompleta() {
	 $query="select *,if(h.horainicial>='18:00','Nocturna','Diurna') jornada
            from prematricula p,detalleprematricula dp,
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
	p.codigoperiodo='20122' and
	p.codigoestudiante=".$this->codigoestudiante." and
        m.codigomateria in (select codigomateria from encuestamateria em , encuesta e
        where em.idencuesta=e.idencuesta
        and now() between e.fechainicioencuesta and e.fechafinalencuesta and e.idencuesta not in (64,59,60,61))
	group by m.codigomateria";
        $resultado=$this->objetobase->conexion->query($query);
        $formulario->filatmp[""]="Seleccionar";
        while($rowmateria=$resultado->fetchRow()) {
			echo "<br>";
			echo "<br>";
         $query=" select count(distinct r.idrespuestaautoevaluacion) cuenta from respuestaautoevaluacion r,
                                encuestapregunta ep,pregunta p where
                                r.idencuestapregunta=ep.idencuestapregunta and
                                p.idpregunta=ep.idpregunta and
                                p.codigoestado like '1%' and
                                ep.codigoestado like '1%' and
                                p.idtipopregunta not in (100,101,201) and
				r.codigoestudiante=".$this->codigoestudiante." and
				r.codigoperiodo='20122'
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
				r.codigoestudiante=".$this->codigoestudiante." and
				r.codigoperiodo='20122' and
r.codigomateria='".$rowmateria["codigomateria"]."'
				 and r.codigoestado like '1%'

)";


            $resultadorespuesta=$this->objetobase->conexion->query($query);
            $registros=$resultadorespuesta->fetchRow( );

            if(!($registros["cuenta"]>0)) {
                return 0;
            }
        }
        return 1;
    }
    
    
     function validaEncuestaCompletahuminadesmedicina() {
		
		
       $query="select *,if(h.horainicial>='18:00','Nocturna','Diurna') jornada
            from prematricula p,detalleprematricula dp,
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
	p.codigoperiodo='20122' and
	p.codigoestudiante=".$this->codigoestudiante." and
        m.codigomateria in (select codigomateria from encuestamateria em , encuesta e
        where em.idencuesta=e.idencuesta
        and now() between e.fechainicioencuesta and e.fechafinalencuesta and e.idencuesta in(64,72))
	group by m.codigomateria";
        $resultado=$this->objetobase->conexion->query($query);
        $formulario->filatmp[""]="Seleccionar";
        while($rowmateria=$resultado->fetchRow()) {
           $query=" select count(distinct r.idrespuestaautoevaluacion) cuenta from respuestaautoevaluacion r,
                                encuestapregunta ep,pregunta p where
                                r.idencuestapregunta=ep.idencuestapregunta and
                                p.idpregunta=ep.idpregunta and
                                p.codigoestado like '1%' and
                                ep.codigoestado like '1%' and
                                p.idtipopregunta not in (100,101,201) and
				r.codigoestudiante=".$this->codigoestudiante." and
				r.codigoperiodo='20122'
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
				r.codigoestudiante=".$this->codigoestudiante." and
				r.codigoperiodo='20122' and
r.codigomateria='".$rowmateria["codigomateria"]."'
				 and r.codigoestado like '1%'

)";

            $resultadorespuesta=$this->objetobase->conexion->query($query);
            $registros=$resultadorespuesta->fetchRow( );

            if(!($registros["cuenta"]>0)) {
                return 0;
            }
        }
        return 1;
    }
    
    //funcion para la encuesta de los certificados
    function validaEncuestaEducontinuada() {
        
            $query="select count(distinct r.idrespuestaeducacioncontinuada) cuenta 
                    from respuestaeducacioncontinuada r,
                    encuestapregunta ep,pregunta p 
                    where r.idencuestapregunta=ep.idencuestapregunta and
                    p.idpregunta=ep.idpregunta and
                    p.codigoestado like '1%' and
                    ep.codigoestado like '1%' and
                    p.idtipopregunta not in (100,101,201) and
		    r.numerodocumento=".$this->idasistente." 				
                    and r.valorrespuestaeducacioncontinuada <> ''				
		    and r.codigoestado like '1%'
                    having cuenta = (
                    select count(distinct r.idrespuestaeducacioncontinuada) cuenta 
                    from respuestaeducacioncontinuada r,
                    encuestapregunta ep,pregunta p 
                    where r.idencuestapregunta=ep.idencuestapregunta and
                    p.idpregunta=ep.idpregunta and
                    p.codigoestado like '1%' and
                    ep.codigoestado like '1%' and
                    p.idtipopregunta not in (100,101,201) and
	            r.numerodocumento=".$this->idasistente."
		    and r.codigoestado like '1%')";

            $resultadorespuesta=$this->objetobase->conexion->query($query);
            $registros=$resultadorespuesta->fetchRow( );

            if(!($registros["cuenta"]>0)) {
                return 0;
            }
        
        return 1;
    }

}

?>
