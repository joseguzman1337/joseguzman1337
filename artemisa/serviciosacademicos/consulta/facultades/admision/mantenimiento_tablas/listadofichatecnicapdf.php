<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    
    $rutaado=("../../../../funciones/adodb/");
    require_once("../../../../Connections/salaado-pear.php");
    require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
    require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
    require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
    require_once("../../../../funciones/sala_genericas/FuncionesMatriz.php");
    require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
    require_once("funciones/ObtenerDatos.php");
    
    define('FPDF_FONTPATH','../../../../funciones/clases/fpdf/font/');
    require('../../../../funciones/clases/fpdf/fpdf.php');
    require_once("../../../../funciones/sala_genericas/clasedocumentopdf.php");

    function RecuperarResultadosEstudiante($objetobase,$objetotablaadmisiones,$idadmision,$codigoestudiante)
    {
        $condicion=" and dea.codigotipodetalleadmision=ta.codigotipodetalleadmision";

        $tablas=" detalleadmision dea, tipodetalleadmision ta";
        $resultado=$objetobase->recuperar_resultado_tabla($tablas,"dea.idadmision",$idadmision,$condicion,"",0);
        $i=0;

        while($row=$resultado->fetchRow())
        {
            $arrayresultadoestudiante[$i]=$objetotablaadmisiones->ObtenerResultadoExamen($codigoestudiante,$idadmision,$row["codigotipodetalleadmision"]);
            $arrayresultadoestudiante[$i]["nombreprueba"]=$row["nombredetalleadmision"];
            $arrayresultadoestudiante[$i]["tipodetalleadmision"]=$row["codigotipodetalleadmision"];
            $arrayresultadoestudiante[$i]["porcentaje"]=$row["porcentajedetalleadmision"];
            if($row["codigotipodetalleadmision"]=="4")
            $arrayresultadoestudiante[$i]["total_preguntas"]=100;
            $i++;
        }

        return $arrayresultadoestudiante;
    }//function RecuperarResultadosEstudiante

    function encuentra_array_materias($objetobase,$objetotablaadmisiones)
    {
        if($codigocarrera!="todos")
            $carreradestino="AND c.codigocarrera='".$codigocarrera."'";
        else
            $carreradestino="";

        if($codigomateria!="todos")
            $materiadestino= "AND m.codigomateria='".$codigomateria."'";
        else
            $materiadestino= "";

        /**
        * @modified David Perez <perezdavid@unbosque.edu.do>
        * Se modifica la consulta para incluir el codigo carrera y el codigo periodo de los estudiantes para eliminar duplicados. 
        * Caso reportado por Diana Rojas - Registro y control <dianarojas@unbosque.edu.co> Fecha: 29 de Octubre de 2018
        * @since Octubre 30, 2018
       */
        $query=" SELECT idadmision,codigoestudiante,concat(apellidosestudiantegeneral,' ',nombresestudiantegeneral) nombre,numerodocumento documento,fechanacimiento,
        nombreestadoestudianteadmision estado, nombregenero genero,
        if(nombreinstitucioneducativa='INSTITUCION DEL SISTEMA',otrainstitucioneducativaestudianteestudio,nombreinstitucioneducativa) Institucion,nombreestadoestudianteadmision estado,
        sum(ponderado) puntaje
        FROM (
        (select a.idadmision,e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
        eg.numerodocumento,
        round(SUM(dr.notadetalleresultadopruebaestado) / count(dr.notadetalleresultadopruebaestado),2) resultado,

        (select da2.iddetalleadmision from detalleadmision da2 where da2.idadmision=a.idadmision and da2.codigotipodetalleadmision=4) codigotipoprueba,
        (select da2.nombredetalleadmision from detalleadmision da2 where da2.idadmision=a.idadmision and da2.codigotipodetalleadmision=4) tipoprueba,
        (select da2.porcentajedetalleadmision from detalleadmision da2 where da2.idadmision=a.idadmision and da2.codigotipodetalleadmision=4) porcentaje,
        truncate((SUM(dr.notadetalleresultadopruebaestado) / count(dr.notadetalleresultadopruebaestado)*((select da2.porcentajedetalleadmision 
        from detalleadmision da2 where da2.idadmision=a.idadmision and da2.codigotipodetalleadmision=4)/100))+0.006,2) ponderado,  
        ge.nombregenero,
        ie.nombreinstitucioneducativa, 
        ee.otrainstitucioneducativaestudianteestudio, 
        eea.nombreestadoestudianteadmision,
        eg.fechanacimientoestudiantegeneral fechanacimiento

        from carrera c, subperiodo sp, admision a, estudianteadmision ea,  estudiante e,detalleadmision da, detallesitioadmision dsa,horariodetallesitioadmision hdsa,detalleestudianteadmision dea,carreraperiodo cp,estadoestudianteadmision eea,estudiantegeneral eg
        left join resultadopruebaestado rp on rp.idestudiantegeneral=eg.idestudiantegeneral
        left join detalleresultadopruebaestado dr on dr.idresultadopruebaestado = rp.idresultadopruebaestado
        left join asignaturaestado ae on dr.idasignaturaestado = ae.idasignaturaestado AND ae.codigoestado like '1%'
        left join genero ge on ge.codigogenero=eg.codigogenero
        left join estudianteestudio ee on ee.idestudiantegeneral=eg.idestudiantegeneral
        left join institucioneducativa ie on ee.idinstitucioneducativa=ie.idinstitucioneducativa and ie.codigomodalidadacademica='".($_SESSION['admisiones_codigomodalidadacademica']-100)."'
        where 
        ea.codigoestadoestudianteadmision=eea.codigoestadoestudianteadmision and
        c.codigocarrera=a.codigocarrera and
        sp.idsubperiodo=a.idsubperiodo and
        cp.codigocarrera=c.codigocarrera and
        cp.idcarreraperiodo=sp.idcarreraperiodo and
        a.idadmision=ea.idadmision and
        ea.codigoestudiante=e.codigoestudiante and
        e.idestudiantegeneral=eg.idestudiantegeneral and

        da.iddetalleadmision=dsa.iddetalleadmision and
        dsa.idadmision=a.idadmision and
        hdsa.iddetallesitioadmision=dsa.iddetallesitioadmision and
        dea.idhorariodetallesitioadmision=hdsa.idhorariodetallesitioadmision and
        dea.idestudianteadmision=ea.idestudianteadmision and
        cp.codigoperiodo=".$_SESSION['admisiones_codigoperiodo']." and
        cp.codigocarrera=".$_SESSION['admisiones_codigocarrera']." and
        e.codigoperiodo=".$_SESSION['admisiones_codigoperiodo']." and
        e.codigocarrera=".$_SESSION['admisiones_codigocarrera']." and
        dea.codigoestado like '1%' and
        da.codigoestado like '1%' and
        dsa.codigoestado like '1%' and 
        hdsa.codigoestado like '1%' 
        group by e.codigoestudiante)

        UNION ALL

        (select a.idadmision,e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
        eg.numerodocumento,
        (max(dea.resultadodetalleestudianteadmision)/da.totalpreguntasdetalleadmision * 100) resultado,
        da.iddetalleadmision codigotipoprueba,
        da.nombredetalleadmision tipoprueba,
        da.porcentajedetalleadmision porcentaje,
        round((max(dea.resultadodetalleestudianteadmision)/da.totalpreguntasdetalleadmision * 100)*(porcentajedetalleadmision/100),2) ponderado,
        ge.nombregenero ,
        (select nombreinstitucioneducativa from institucioneducativa ie where  ee.idinstitucioneducativa=ie.idinstitucioneducativa and ie.codigomodalidadacademica='200' ) nombreinstitucioneducativa,
        ee.otrainstitucioneducativaestudianteestudio, 
        eea.nombreestadoestudianteadmision,
        eg.fechanacimientoestudiantegeneral fechanacimiento

        from carrera c, subperiodo sp,  estudianteadmision ea,  estudiante e, horariodetallesitioadmision hdsa,detalleestudianteadmision dea,carreraperiodo cp,estudiantegeneral eg,genero ge,
        admision a,estudianteestudio ee,estadoestudianteadmision eea,detallesitioadmision dsa
        left join detalleadmision da on da.idadmision=dsa.idadmision and da.iddetalleadmision=dsa.iddetalleadmision
        where 
        ea.codigoestadoestudianteadmision=eea.codigoestadoestudianteadmision and
        ee.idestudiantegeneral=eg.idestudiantegeneral and
         ge.codigogenero=eg.codigogenero and
        c.codigocarrera=a.codigocarrera and
        sp.idsubperiodo=a.idsubperiodo and
        cp.codigocarrera=c.codigocarrera and
        cp.idcarreraperiodo=sp.idcarreraperiodo and
        a.idadmision=ea.idadmision and
        ea.codigoestudiante=e.codigoestudiante and
        e.idestudiantegeneral=eg.idestudiantegeneral and

        dsa.idadmision=a.idadmision and
        hdsa.iddetallesitioadmision=dsa.iddetallesitioadmision and
        dea.idhorariodetallesitioadmision=hdsa.idhorariodetallesitioadmision and
        dea.idestudianteadmision=ea.idestudianteadmision and
        cp.codigoperiodo=".$_SESSION['admisiones_codigoperiodo']." and
        cp.codigocarrera=".$_SESSION['admisiones_codigocarrera']." and
        e.codigoperiodo=".$_SESSION['admisiones_codigoperiodo']." and
        e.codigocarrera=".$_SESSION['admisiones_codigocarrera']." and
        dea.codigoestado like '1%' and
        da.codigoestado like '1%' and
        dsa.codigoestado like '1%' and 
        hdsa.codigoestado like '1%' 
        group by  ea.idestudianteadmision,da.iddetalleadmision
        ) 

        ) tabla1
        group by codigoestudiante
        order by puntaje desc,3";        
        if($imprimir)
            echo $query;
	
        $operacion=$objetobase->conexion->query($query);
        $i=0;
        while ($row_operacion=$operacion->fetchRow())
        {
            $arrayresultadoestudiante=RecuperarResultadosEstudiante($objetobase,$objetotablaadmisiones,$row_operacion["idadmision"],$row_operacion["codigoestudiante"]);
            $resultadoicfes=$objetotablaadmisiones->ObtenerResultadoIcfes($row_operacion["codigoestudiante"]);		
            $puntajeglobalicfes=$objetotablaadmisiones->ObtenerPuntajeGeneralIcfes($row_operacion["codigoestudiante"]);	
            
            $segundaopcion=$objetotablaadmisiones->ObetnerSegundaOpcion($row_operacion["codigoestudiante"], $row_operacion["idadmision"]);            
		
            $row_operacion["Institucion"]=substr(strtoupper($row_operacion["Institucion"]),0,40);
            $fechanacimiento=formato_fecha_defecto(sacarpalabras($row_operacion["fechanacimiento"],0,0));
            $edadmeses=(int) (diferencia_fechas($fechanacimiento,date("d/m/Y"),"meses",0)/12);
            $row_operacion["fechanacimiento"]=$fechanacimiento;
            unset($row_operacion["fechanacimiento"]);

            $rowtmp["edad"]=$edadmeses;
            $row_operacion=InsertarColumnaFila($row_operacion,$rowtmp,6);
            unset($rowtmp);
            $rowtmp["estado"]=$row_operacion["estado"];
            $arrayfichaestado[$rowtmp["estado"]]=0;
            unset($row_operacion["estado"]);
            $row_operacion=InsertarColumnaFila($row_operacion,$rowtmp,7);
            unset($rowtmp);

            $arrayponderado[]=$row_operacion["puntaje"];
            unset($row_operacion["codigoestudiante"]);
            unset($row_operacion["idadmision"]);
            $array_interno[$i]=$row_operacion;
		
            foreach($arrayresultadoestudiante as $conprueba => $filaprueba)
            {
                $nombrecolumna="(".sacarpalabras($filaprueba["nombreprueba"],0,0)."x/".$filaprueba["total_preguntas"].")_".$filaprueba["porcentaje"]."%";
                $array_interno[$i][trim("PORCENTAJE_".sacarpalabras($filaprueba["nombreprueba"],0,0))]=$filaprueba["porcentaje"];
                $array_interno[$i][trim("PREGUNTAS_".sacarpalabras($filaprueba["nombreprueba"],0,0))]=$filaprueba["total_preguntas"];
                if($arrayresultadoestudiante[$conprueba]["tipodetalleadmision"]!="4")
                {
                    $array_interno[$i][$nombrecolumna]=$filaprueba["resultado"];
                    if($arrayresultadoestudiante[$conprueba]["tipodetalleadmision"]=="1")
                    {
                        $array_interno[$i]["EXAMEN"]=$filaprueba["resultado"];
                    }	
                    if($arrayresultadoestudiante[$conprueba]["tipodetalleadmision"]=="3")
                    {
                        $array_interno[$i]["ENTREVISTA"]=$filaprueba["resultado"];
                    }	
                }
                else
                {
                    if(isset($resultadoicfes)&&trim($resultadoicfes)!='')
                        $array_interno[$i][$nombrecolumna]=$resultadoicfes;
                }
            }
            $array_interno[$i]["ICFES"]=$resultadoicfes;
            $array_interno[$i]["PUNTAJEGLOBAL"]=$puntajeglobalicfes;         
            $array_interno[$i]["SEGUNDA_OPCION"]=$segundaopcion['nombrecarrera'];         
            $array_interno[$i]["SEGUNDA_OPCION_CODIGO"]=$segundaopcion['codigocarrera'];         
            $i++;
        }
        asort($arrayponderado);        
        
        for($i=0;$i<count($array_interno);$i++)
        {
            $j=count($arrayponderado)+1;
            foreach($arrayponderado as $orden=>$valor){
                $j--;
                if($i==$orden)
                    $array_interno[$i]["Puesto"]=$j;
            }
        }
        return $array_interno;
    }// function encuentra_array_materias

    $objetobase=new BaseDeDatosGeneral($sala);
    $objetotablaadmisiones=new TablasAdmisiones($sala);
    $datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_SESSION['admisiones_codigocarrera'],"","",0);

    $vigilada = utf8_decode("Vigilada Mineducación");

    $tituloprincipal="UNIVERSIDAD EL BOSQUE\nFICHA TECNICA\n PROCESO DE ADMISIONES PERIODO ".$_SESSION['admisiones_codigoperiodo']." ".$datoscarrera["nombrecarrera"]." \n ".$vigilada."  ";


    $objetopdfhtml=new DocumentoPDF($tituloprincipal,'P');
    $objetopdfhtml->anchofuente=3;
    $objetopdfhtml->tamanofuente=5;
    $objetopdfhtml->saltolinea=4;
    $objetopdfhtml->lineasxpagina=58;
    $objetopdfhtml->mostrarpiefecha=0;
    $objetopdfhtml->mostrarpiepagina=1;
    $objetopdfhtml->mostrarenumeracion=0;
    //$objetopdfhtml=new HTML2FPDF('P','mm','A4',7);

    $cantidadestmparray=encuentra_array_materias($objetobase,$objetotablaadmisiones);
    $arrayfichatecnica["edad_minima"]=100;
    $arrayfichatecnica["edad_maxima"]=0;
    $arrayfichatecnica["puntaje_minimo_total"]=100;
    $arrayfichatecnica["puntaje_maximo_total"]=0;
    $arrayfichatecnica["puntaje_minimo_entrevista"]=100;
    $arrayfichatecnica["puntaje_maximo_entrevista"]=0;
    $arrayfichatecnica["puntaje_minimo_icfes"]=100;
    $arrayfichatecnica["puntaje_maximo_icfes"]=0;

    $arrayfichatecnica["puntaje_global_icfes_maximo"]=0;
    $arrayfichatecnica["puntaje_global_icfes_minimo"]=0;
    $arrayfichatecnica["puntaje_global_icfes_media"]=0;

    $arrayfichatecnica["media_icfes"]=0;
    $arrayfichatecnica["puntaje_minimo_examen"]=100;
    $arrayfichatecnica["puntaje_maximo_examen"]=0;

    $arrayfichatecnica["total_mujeres"]=0;
    $arrayfichatecnica["total_hombres"]=0;

    $contador = 0;
    $puntaje = 0;

    foreach($cantidadestmparray as $llave=>$row)
    {        
        $contador++;
        $puntaje+=$row["ICFES"];
        $puntajeglobal+=$row["PUNTAJEGLOBAL"];
        
        if($row["genero"]=="Masculino")
            $arrayfichatecnica["total_hombres"]++;
        if($row["genero"]=="Femenino")
            $arrayfichatecnica["total_mujeres"]++;
        if($arrayfichatecnica["edad_minima"]>$row["edad"]&&$row["edad"]!=0)
            $arrayfichatecnica["edad_minima"]=$row["edad"];

        if($arrayfichatecnica["edad_maxima"]<$row["edad"]&&$row["edad"]<60)
            $arrayfichatecnica["edad_maxima"]=$row["edad"];

        //Toca hacer regla de 3: Si el puntaje es 30 sobre 30 preguntas entonces la persona saco 100% de nota o 100 puntos
        $row["puntaje"]=((floatval($row["ICFES"])*100/floatval($row["PREGUNTAS_ICFES"]))*floatval($row["PORCENTAJE_ICFES"])/100) 
		+ ((floatval($row["EXAMEN"])*100/floatval($row["PREGUNTAS_EXAMEN"]))*floatval($row["PORCENTAJE_EXAMEN"])/100) 
		+ ((floatval($row["ENTREVISTA"])*100/floatval($row["PREGUNTAS_ENTREVISTA"]))*floatval($row["PORCENTAJE_ENTREVISTA"])/100);
        $row["puntaje"]=round($row["puntaje"], 2); 

        if($arrayfichatecnica["puntaje_minimo_total"]>$row["puntaje"]&&$row["puntaje"]>2)
            $arrayfichatecnica["puntaje_minimo_total"]=$row["puntaje"];

        if($arrayfichatecnica["puntaje_maximo_total"]<$row["puntaje"]&&$row["puntaje"]<100)
            $arrayfichatecnica["puntaje_maximo_total"]=$row["puntaje"];

        if($arrayfichatecnica["puntaje_minimo_icfes"]>$row["ICFES"]&&$row["ICFES"]>2)
            $arrayfichatecnica["puntaje_minimo_icfes"]=$row["ICFES"];

        if($arrayfichatecnica["puntaje_maximo_icfes"]<$row["ICFES"]&&$row["ICFES"]<100)
            $arrayfichatecnica["puntaje_maximo_icfes"]=$row["ICFES"];

        if($arrayfichatecnica["puntaje_minimo_examen"]>$row["EXAMEN"]&&$row["EXAMEN"]>2)
            $arrayfichatecnica["puntaje_minimo_examen"]=$row["EXAMEN"];

        if($arrayfichatecnica["puntaje_maximo_examen"]<$row["EXAMEN"]&&$row["EXAMEN"]<100)
            $arrayfichatecnica["puntaje_maximo_examen"]=$row["EXAMEN"];

        if($arrayfichatecnica["puntaje_minimo_entrevista"]>$row["ENTREVISTA"]&&$row["ENTREVISTA"]>2)
            $arrayfichatecnica["puntaje_minimo_entrevista"]=$row["ENTREVISTA"];

        if($arrayfichatecnica["puntaje_maximo_entrevista"]<$row["ENTREVISTA"]&&$row["ENTREVISTA"]<100)
            $arrayfichatecnica["puntaje_maximo_entrevista"]=$row["ENTREVISTA"];
        
        if($arrayfichatecnica["puntaje_global_icfes_maximo"]<$row["PUNTAJEGLOBAL"])
            $arrayfichatecnica["puntaje_global_icfes_maximo"]=$row["PUNTAJEGLOBAL"];
        if($contador==1)
        {
            $arrayfichatecnica["puntaje_global_icfes_minimo"]=$row["PUNTAJEGLOBAL"];            
        }
        if($arrayfichatecnica["puntaje_global_icfes_minimo"]>$row["PUNTAJEGLOBAL"]&&$row["PUNTAJEGLOBAL"]<>0)
            $arrayfichatecnica["puntaje_global_icfes_minimo"]=$row["PUNTAJEGLOBAL"];
        
        $arrayfichacolegio[$row["Institucion"]]++;
        $arrayfichaestado[$row["estado"]]++;
    }//foreach

    $arrayfichatecnica["media_icfes"] = round($puntaje/$contador, 2); 
    $arrayfichatecnica["puntaje_global_icfes_media"] = round($puntajeglobal/$contador, 2); 
    $i=0;
    foreach($arrayfichatecnica as $nombrellave=>$valor)
    {
        $arrayinterno[$i]["aspecto"]=str_replace("_"," ",strtoupper($nombrellave));
        $arrayinterno[$i]["valor"]=$valor;
        $i++;
    }//foreach
    
    $arrayinterno[$i]["aspecto"]="";
    $arrayinterno[$i]["valor"]="";
    $i++;
    $arrayinterno[$i]["aspecto"]="FICHA TOTALES POR ESTADO";
    $arrayinterno[$i]["valor"]="";
    $i++;

    foreach($arrayfichaestado as $nombrellave=>$valor)
    {
        if($valor>0&&trim($nombrellave)!='')
        {	
            $arrayinterno[$i]["aspecto"]=str_replace("_"," ",strtoupper($nombrellave));
            $arrayinterno[$i]["valor"]=$valor;
            $i++;
        }//if
    }//foreach


    $arrayinterno[$i]["aspecto"]="";
    $arrayinterno[$i]["valor"]="";
    $i++;

    /*$arrayinterno[$i]["aspecto"]="FICHA TOTALES SEGUNDA OPCION";
    $arrayinterno[$i]["valor"]="";
    $i++;
    $arrayinterno[$i]["aspecto"]="";
    $arrayinterno[$i]["valor"]="";
*/


    /*
    $arrayinterno[$i]["aspecto"]="FICHA TOTALES POR INSTITUCIONES";
    $arrayinterno[$i]["valor"]="";
    $i++;
    $arrayinterno[$i]["aspecto"]="";
    $arrayinterno[$i]["valor"]="";
    $i++;
    foreach($arrayfichacolegio as $nombrellave=>$valor){
        if($valor>1&&trim($nombrellave)!=''){	
            $arrayinterno[$i]["aspecto"]=str_replace("_"," ",strtoupper($nombrellave));
            $arrayinterno[$i]["valor"]=$valor;
            $i++;
        }
    }*/
    $objetopdfhtml->CargarArray($arrayinterno);
    //$objetopdfhtml->DibujarTitulo($tituloprincipal);
    $objetopdfhtml->DibujarFilas($tituloprincipal);

    $objetopdfhtml->CerrarDocumento();

?>