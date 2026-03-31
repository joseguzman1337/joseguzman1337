<?php
/**
 * Description of TitulosIndicadores
 *
 * @author javeeto
 */
class TitulosIndicadores{
	var $arraytitulos;
	var $datoscarrera;
	function TitulosIndicadores($datoscarrera)
	{
		$this->arraytitulos=array("");
		$this->datoscarrera=$datoscarrera;
	}
	function perspectivaCliente(){
		$fin["fin"]=1;
		

		/*$arrayperspectiva1["( # ) De Inscritos"]=$fin;
		$arrayperspectiva1["( # ) Presupuesto de Matriculados Nuevos"]=$fin;
		$arrayperspectiva1["( # ) De Matriculados Nuevos"]=$fin;
		$arrayperspectiva1["( % )  Matriculados Nuevos / Presupuesto de Matriculados Nuevos"]=$fin;
		$arrayperspectiva1["(#) Cupos Total"]=$fin;
		$arrayperspectiva1["(  /  )  Matriculados Nuevos /  Inscritos (Capacidad de selección)"]=$fin;
		$arrayperspectiva1["# de nuevos estudiantes  de Colegios Privados/Públicosl"]=$fin;*/
		$arrayperspectiva1["# de nuevos estudiantes por estrato"]=$fin;
		$arrayperspectiva1["# de nuevos estudiantes por estrato"]["funcion"]="estudianteEstrato";
		$arrayperspectiva1["# de nuevos estudiantes por estrato"]["ayuda"]="Numero de estudiantes nuevos clasificados por estrato";

		$arrayperspectiva1["( # ) De Inscritos"]=$fin;
		$arrayperspectiva1["( # ) De Inscritos"]["funcion"]="numeroInscritos";
		$arrayperspectiva1["( # ) De Inscritos"]["ayuda"]="Numero de estudiantes inscritos en el periodo";

		$arrayperspectiva1["( # ) De Matriculados Nuevos"]=$fin;
		$arrayperspectiva1["( # ) De Matriculados Nuevos"]["funcion"]="numeroMatriculadosNuevos";
		$arrayperspectiva1["( # ) De Matriculados Nuevos"]["ayuda"]="Numero de estudiantes matriculados en el periodo";

	


		$arrayperspectiva1["# de nuevos estudiantes por región"]=$fin;
		$arrayperspectiva1["# de nuevos estudiantes por región"]["funcion"]="estudiantesRegion";
		$arrayperspectiva1["# de nuevos estudiantes por región"]["ayuda"]="Número de nuevos estudiantes por región";

		$arrayperspectiva1["Matriculados Nuevos Sobre Inscritos"]=$fin;
		$arrayperspectiva1["Matriculados Nuevos Sobre Inscritos"]["funcion"]="numeroMatriculadosInscritos";
		$arrayperspectiva1["Matriculados Nuevos Sobre Inscritos"]["ayuda"]="Porcentaje de estudiantes nuevos matriculados Numero de inscritos al programa";

		//$arrayperspectiva1["# de nuevos estudiantes por estrato"]["ayuda"]="estudianteEstrato";

		//$arrayperspectiva1["# de nuevos estudiantes por región"]=$fin;
		$arrayperspectiva["Nuevos Estudiantes"]=$arrayperspectiva1;
		
		$arrayperspectiva2["( # ) Total de Estudiantes"]=$fin;
		$arrayperspectiva2["( # ) Total de Estudiantes"]["funcion"]="totalEstudiantes";
		$arrayperspectiva2["( # ) Total de Estudiantes"]["ayuda"]="Número Total de estudiantes matriculados en la facultad por periodo académico";

		$arrayperspectiva2["Porcentaje Deserción en el primer año"]=$fin;
		$arrayperspectiva2["Porcentaje Deserción en el primer año"]["funcion"]="desercionPrimerAnio";
		$arrayperspectiva2["Porcentaje Deserción en el primer año"]["ayuda"]="Porcentaje de estudiantes que tuvieron deserción dentro los dos primeros periodos despues de matriculado por primera vez en la carrera, el periodo relacionado corresponde al año despues de la primera matricula";

		$arrayperspectiva2["Porcentaje Deserción"]=$fin;
		$arrayperspectiva2["Porcentaje Deserción"]["funcion"]="desercionEstudiante";
		$arrayperspectiva2["Porcentaje Deserción"]["ayuda"]="Porcentaje de estudiantes en estado de deserción";


		$arrayperspectiva2["# de nuevos estudiantes  de Colegios Privados/Públicos"]=$fin;
		$arrayperspectiva2["# de nuevos estudiantes  de Colegios Privados/Públicos"]["funcion"]="estudiantesColegio";
		$arrayperspectiva2["# de nuevos estudiantes  de Colegios Privados/Públicos"]["ayuda"]="# de nuevos estudiantes  de Colegios Privados sobre numero de estudiantes de colegios Publicos";




		$arrayperspectiva["Estudiantes"]=$arrayperspectiva2;
	
		
		$arrayperspectiva3[" % # graduados / # de nuevos estudiantes por Cohorte"]=$fin;
		$arrayperspectiva3[" % # graduados / # de nuevos estudiantes por Cohorte"]["funcion"]="graduadosPeriodo";

		$arrayperspectiva3[" % # graduados / # de nuevos estudiantes por Cohorte"]["ayuda"]="Numero de graduados en el periodo dividido sobre el numero de estudiantes nuevos en el mismo periodo";

		$arrayperspectiva3["# de años para graduarse"]=$fin;
		$arrayperspectiva3["# de años para graduarse"]["funcion"]="aniosGradoEstudiante";
		$arrayperspectiva3["# de años para graduarse"]["ayuda"]="Cantidad promedio de años que necesita un estudiante graduado en el periodo ";

		$arrayperspectiva3["( # ) Graduados por semestre"]=$fin;
		$arrayperspectiva3["( # ) Graduados por semestre"]["funcion"]="graduadosSemestre";
		$arrayperspectiva3["( # ) Graduados por semestre"]["ayuda"]="Numero de graduados por semestre";


		$arrayperspectiva3["( # ) Graduados Total"]=$fin;
		$arrayperspectiva3["( # ) Graduados Total"]["funcion"]="totalGraduados";
		$arrayperspectiva3["( # ) Graduados Total"]["ayuda"]="Numero total de graduados ";

		$arrayperspectiva3["( # ) Egresados por Semestre"]=$fin;
		$arrayperspectiva3["( # ) Egresados por Semestre"]["funcion"]="numeroEgresados";
		$arrayperspectiva3["( # ) Egresados por Semestre"]["ayuda"]="Numero total de egresados";

		$arrayperspectiva3["( # )  Egresados por Semestre - Graduados por Semestre "]=$fin;
		$arrayperspectiva3["( # )  Egresados por Semestre - Graduados por Semestre "]["funcion"]="diferenciaEgresadosGraduados";
		$arrayperspectiva3["( # )  Egresados por Semestre - Graduados por Semestre "]["ayuda"]="Numero de graduados por semestre menos numero de egresados del mismo semestre";
		
		$arrayperspectiva["Graduados"]=$arrayperspectiva3;
		if(is_array($this->datoscarrera))
			$arrayretorno["titulo"]=$this->datoscarrera["nombrecarrera"]."- PERSPECTIVA DEL USUARIO";
		else
			$arrayretorno["titulo"]="PERSPECTIVA DEL USUARIO";
		$arrayretorno["titulovertical"]=$arrayperspectiva;
		/*echo "<pre>";
		print_r($arrayretorno);
		echo "</pre>";*/
		$this->arraytitulos=$arrayretorno;
		return $arrayretorno;
	}
	function filtraTitulos($arrayseleccion)
	{
		//echo "<h1>Filtra titulos=no encuentra array</h1>";
		if(is_array($arrayseleccion)&&(count($arrayseleccion)>0)){
			$nuevoarraytitulos["titulo"]=$this->arraytitulos["titulo"];
		//	echo "<pre>".print_r($this->arraytitulos)."</pre>";
			foreach($this->arraytitulos["titulovertical"] as $llave => $valor){
				foreach($valor as $llave2 => $valor2){
					//echo "<br>".$llave2."<pre>".print_r($arrayseleccion)."</pre>";
					if(in_array($llave2,$arrayseleccion))
						$nuevoarraytitulos["titulovertical"][$llave][$llave2]=$valor2;
				}
			}
		}
		else{
			//echo "<h1>Filtra titulos=no encuentra array</h1>";
			$nuevoarraytitulos=$this->arraytitulos;
		}
		return $nuevoarraytitulos;
		//$tipo,$parametros,$titulo,$estilo_titulo,$idtitulo,$tipo_titulo="",$imprimir=0,$tdcomentario="",$ayuda=""
	}
	
	function perspectivaProcesos(){
		$fin["fin"]=1;
		$arrayperspectiva1["% # Publicaciones / # Docentes"]=$fin;
		$arrayperspectiva1["% # Publicaciones / # Docentes"]["funcion"]="publicacionDocente";	
		$arrayperspectiva1["% # Publicaciones / # Docentes"]["ayuda"]="Porcentaje dado en la relacion entre Publicaciones y docentes de la carrera";	
	
		$arrayperspectiva1["# Revistas Indexadas"]=$fin;
		$arrayperspectiva1["# Revistas Indexadas"]["funcion"]="publicacionIndexadaDocente";	
		$arrayperspectiva1["# Revistas Indexadas"]["ayuda"]="Numero de revistas indexadas realizadas por docentes de la carrera";	
	
		$arrayperspectiva1[" # de investigadores de tiempo completo en la Universidad"]=$fin;
		$arrayperspectiva1[" # de investigadores de tiempo completo en la Universidad"]["funcion"]="docenteInvestigador";
		$arrayperspectiva1[" # de investigadores de tiempo completo en la Universidad"]["ayuda"]="Numero de docentes dedicados en tiempo completo en la división de investigaciones en toda la universidad";		

		$arrayperspectiva1["% # de contratos de investigación / # docentes"]=$fin;
		$arrayperspectiva1["% # de contratos de investigación / # docentes"]["funcion"]="contratoInvestigacionDocente";	
		$arrayperspectiva1["% # de contratos de investigación / # docentes"]["ayuda"]="Numero de docentes que se encuentran relacionados a la división de investigaciones y también a la carrera dividido sobre el numero total de  docentes de la carrera";	

		$arrayperspectiva1["( # ) de Semestres"]=$fin;
		$arrayperspectiva1["( # ) de Semestres"]["funcion"]="numeroSemestres";	
		$arrayperspectiva1["( # ) de Semestres"]["ayuda"]="Numero de semestres del plan de estudios";

		$arrayperspectiva1["( # ) de Asignaturas"]=$fin;
		$arrayperspectiva1["( # ) de Asignaturas"]["funcion"]="numeroAsignaturas";	
		$arrayperspectiva1["( # ) de Asignaturas"]["ayuda"]="Numero de asignaturas del plan de estudios";

		$arrayperspectiva1["( # ) de Creditos"]=$fin;
		$arrayperspectiva1["( # ) de Creditos"]["funcion"]="numeroCreditos";	
		$arrayperspectiva1["( # ) de Creditos"]["ayuda"]="Numero de creditos del plan de estudios";

		$arrayperspectiva1["( # ) Total horas practicas"]=$fin;
		$arrayperspectiva1["( # ) Total horas practicas"]["funcion"]="numeroHorasPractica";	
		$arrayperspectiva1["( # ) Total horas practicas"]["ayuda"]="Numero total de horas practicas ( Disciplinares ) del plan de estudios ";


		$arrayperspectiva1["( # ) Total horas teóricas"]=$fin;
		$arrayperspectiva1["( # ) Total horas teóricas"]["funcion"]="numeroHorasTeorica";	
		$arrayperspectiva1["( # ) Total horas teóricas"]["ayuda"]="Numero total de horas del plan de estudios";

		$arrayperspectiva["Academico Investigación"]=$arrayperspectiva1;


		if(is_array($this->datoscarrera))
			$arrayretorno["titulo"]=$this->datoscarrera["nombrecarrera"]."- PERSPECTIVA DE LOS PROCESOS INTERNOS";	
		else
			$arrayretorno["titulo"]=" PERSPECTIVA DE LOS PROCESOS INTERNOS";
		$arrayretorno["titulovertical"]=$arrayperspectiva;
		$this->arraytitulos=$arrayretorno;
		return $arrayretorno;
	}
	function perspectivaCapital(){
		$fin["fin"]=1;
        $arrayperspectiva1["# Docente & Investigador"]=$fin;
        $arrayperspectiva1["# Docente & Investigador"]["funcion"]="docenteInvestigadorCarrera";
        $arrayperspectiva1["# Docente & Investigador"]["ayuda"]="Numero de docentes que se encuentran relacionados a la división de investigaciones y también a la carrera";

        $arrayperspectiva1["% #estudiantes / # docente doctorado"]=$fin;
        $arrayperspectiva1["% #estudiantes / # docente doctorado"]["funcion"]="docenteDoctoradoEstudiante";
        $arrayperspectiva1["% #estudiantes / # docente doctorado"]["ayuda"]="Relacion entre docentes con doctorado y estudiantes matriculados de la carrera";

        $arrayperspectiva1["# Docentes por Escalafón"]=$fin;
        $arrayperspectiva1["# Docentes por Escalafón"]["funcion"]="docenteEscalafon";
        $arrayperspectiva1["# Docentes por Escalafón"]["ayuda"]="Número de docentes que hay por escalafón";

        $arrayperspectiva1["# Total Docentes"]=$fin;
        $arrayperspectiva1["# Total Docentes"]["funcion"]="docente";
        $arrayperspectiva1["# Total Docentes"]["ayuda"]="Total de docentes";

        $arrayperspectiva1["# Horas Docentes por Escalafón"]=$fin;
        $arrayperspectiva1["# Horas Docentes por Escalafón"]["funcion"]="docenteEscalafonHoras";
        $arrayperspectiva1["# Horas Docentes por Escalafón"]["ayuda"]="Número de horas de docentes que hay por escalafón";

        $arrayperspectiva1["# Total Horas Docentes"]=$fin;
        $arrayperspectiva1["# Total Horas Docentes"]["funcion"]="docenteHoras";
        $arrayperspectiva1["# Total Horas Docentes"]["ayuda"]="Total horas de los docentes";

        $arrayperspectiva1["% # docentes / #estudiantes"]=$fin;
        $arrayperspectiva1["% # docentes / #estudiantes"]["funcion"]="docenteEstudiante";
        $arrayperspectiva1["% # docentes / #estudiantes"]["ayuda"]="Número de docentes por cada estudiante";
 
       $arrayperspectiva1["% #estudiantes / # docentes"]=$fin;
        $arrayperspectiva1["% #estudiantes / # docentes"]["funcion"]="estudianteDocente";
        $arrayperspectiva1["% #estudiantes / # docentes"]["ayuda"]="Número de estudiantes por cada docente";


        $arrayperspectiva1["% # Docentes / # Horas"]=$fin;
        $arrayperspectiva1["% # Docentes / # Horas"]["funcion"]="docentePromedioHoras";
        $arrayperspectiva1["% # Docentes / # Horas"]["ayuda"]="Promedio de horas por docente";

        $arrayperspectiva1["# Docentes por Formación Profesional"]=$fin;
        $arrayperspectiva1["# Docentes por Formación Profesional"]["funcion"]="docenteFormacionProfesional";
        $arrayperspectiva1["# Docentes por Formación Profesional"]["ayuda"]="Número de docentes por formación profesional";

		$arrayperspectiva["Academicos"]=$arrayperspectiva1;

		if(is_array($this->datoscarrera))		
			$arrayretorno["titulo"]=$this->datoscarrera["nombrecarrera"]."- PERSPECTIVA DEL CAPITAL ORGANIZACIONAL";
		else
			$arrayretorno["titulo"]=" PERSPECTIVA DEL CAPITAL ORGANIZACIONAL";
		$arrayretorno["titulovertical"]=$arrayperspectiva;
		$this->arraytitulos=$arrayretorno;
		return $arrayretorno;
	}
}
?>