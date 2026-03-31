<?php
    @session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    require_once("generarcargaestudiante.php");
	
    function cupopertenecemateria($codigomateria,$codigocarrera,$row_datosgrupos1,$eselectivalibre=0){
        $query_pertenecemateria = "select codigomateria from materia ".
        " where codigomateria = '".$codigomateria."' and codigocarrera = '$codigocarrera'";
        $pertenecemateria=mysql_query($query_pertenecemateria);		
        $totalRows_pertenecemateria = mysql_num_rows($pertenecemateria);
        $sincupo = false;
        if($totalRows_pertenecemateria != ""){
            $estructuradatosmateria[$codigomateria]['pertenecemateria']=1;
        }else{
            $estructuradatosmateria[$codigomateria]['pertenecemateria']=0;
        }
        if($row_datosgrupos1['summatriculadosgrupo'] == '00'){
            $row_datosgrupos1['summatriculadosgrupo']= 0;
        }
		
        $cupo=($row_datosgrupos1['summaximogrupo']-$row_datosgrupos1['summaximogrupoelectiva'])-$row_datosgrupos1['summatriculadosgrupo'];		
		
        if(!$estructuradatosmateria[$codigomateria]['pertenecemateria']){
            if($row_datosgrupos1['summaximogrupoelectiva']!=0||$eselectivalibre){
                /* @modified Ivan quintero <quinteroivan@unbosque.edu.co>
                 *  @since  Diciembre 21, 2016
                 *  en la siguiente consulta se agrega la tabla grupo y la validacion de estado del grupo activo
                */
                $SQL="SELECT COUNT(d.idgrupo) AS matriculados FROM detalleprematricula d, "
                . "estudiante e, prematricula p,	grupo g WHERE "
                . "(d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%') "
                . "and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%') "
                . "and p.idprematricula = d.idprematricula and p.codigoestudiante = e.codigoestudiante "
                . "AND g.idgrupo = d.idgrupo AND g.codigoestadogrupo = '10' and e.codigosituacioncarreraestudiante "
                . "not like '1%' and e.codigosituacioncarreraestudiante not like '5%' "
                . "AND d.codigomateria =  '".$codigomateria."' and p.codigoperiodo ='".$_SESSION['codigoperiodosesion']."'";	                
                /*END*/
                $pertenecemateria=mysql_query($SQL);

                $row_pertenecemateria = mysql_fetch_array($pertenecemateria);
                if($row_pertenecemateria['matriculados']>$row_datosgrupos1['summaximogrupo']){
                    $cupo =0;
                }else{
                    $cupo=$row_datosgrupos1['summaximogrupoelectiva']-$row_datosgrupos1['summatriculadosgrupoelectiva'];
                } 
            }//if   
        }//if 
        return $cupo;
    }//function cupopertenecemateria

    if(!$tieneunplandeestudios){
        $query_selmodalidad = "select c.codigomodalidadacademica from modalidadacademica m, carrera c "
        . "where m.codigomodalidadacademica = c.codigomodalidadacademica and c.codigocarrera = '".$row_estudiante['codigocarrera']."'";		
        $selmodalidad = mysql_db_query($database_sala,$query_selmodalidad) or die("$query_selmodalidad");
        $totalRows_selmodalidado = mysql_num_rows($selmodalidad);
        $row_selmodalidad = mysql_fetch_array($selmodalidad);
        //LA SIGUIENTE VALIDACION PLAICA PARA POSTGRADOS, COLEGIOS Y EDUCACION CONTINUADA
        if($row_selmodalidad['codigomodalidadacademica'] == 100 || $row_selmodalidad['codigomodalidadacademica'] == 300 || $row_selmodalidad['codigomodalidadacademica'] == 400){
            ?>
            <script language="javascript">
            if (confirm("El estudiante no tiene un plan de estudios, si continua no se le matricularan materias \n y la orden le sera generada al 100%")) {
                window.location.href = "matriculaautomaticahorarios.php?programausadopor=<?php echo $_GET['programausadopor'];?>";
            } else {
                window.location.href = "matriculaautomaticaordenmatricula.php?programausadopor=<?php echo $_GET['programausadopor'];?>";
            }
            </script>
            <?php
        }//if
        
        // LA SIGUIENTE VALIDACION PARA PREGRADO
        if($row_selmodalidad['codigomodalidadacademica'] == 200){
            ?>
            <script language="javascript">
                alert("El estudiante no tiene un plan de estudios, si no le coloca un plan de estudios\n no le sera generada la matricula y por ende no se le generara orden de pago");
                window.location.href = "matriculaautomaticaordenmatricula.php?programausadopor=<?php echo $_GET['programausadopor'];?>";
            </script>
            <?php
        }//if
    }//if planestudio

    // Con este semestre debe mirar que la cantidad de materias sea mayor en creditos, con respecto al semestre
    // que mas se repita

    // Materias que quedaron y que son propuestas
    // Pone primero las que tienen corequisito doble
    $query_materiascarga = "select DISTINCT d.idplanestudio, d.codigomateria, m.nombremateria, d.semestredetalleplanestudio*1 as "
    . "semestredetalleplanestudio, t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio, "
    . "c.codigoestadocargaacademica from planestudioestudiante p, detalleplanestudio d, materia m, tipomateria t, "
    . "cargaacademica c where p.codigoestudiante = '".$codigoestudiante."' and p.idplanestudio = d.idplanestudio"
    . " and p.codigoestadoplanestudioestudiante in ('100', '101') and d.codigoestadodetalleplanestudio in ('100', '101') and "
    . "d.codigomateria = m.codigomateria and d.codigotipomateria = t.codigotipomateria and d.codigotipomateria "
    . "NOT IN ('5') and c.codigoestudiante = p.codigoestudiante and c.idplanestudio = p.idplanestudio "
    . "and c.codigomateria = d.codigomateria and c.codigoperiodo = '".$codigoperiodo."' order by 4,3";      
    $materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
    $totalRows_materiascarga = mysql_num_rows($materiascarga);

    $quitarmaterias1 = "";
    if($totalRows_materiascarga != ""){
        while($row_materiascarga = mysql_fetch_array($materiascarga)){
            if(preg_match("/^2/",$row_materiascarga['codigoestadocargaacademica'])){
                $materiasquitarcarga[] = $row_materiascarga['codigomateria'];
                $semestre[$row_materiascarga['semestredetalleplanestudio']]--;
            }
            if(preg_match("/^1/",$row_materiascarga['codigoestadocargaacademica'])){
                $materiasponercarga[] = $row_materiascarga['codigomateria'];
                $materiasfinal[] = $row_materiascarga;
                $quitarmaterias1 = "$quitarmaterias1 and c.codigomateria <> ".$row_materiascarga['codigomateria']."";
                // Selección de la carga obligatoria
                $semestre[$row_materiascarga['semestredetalleplanestudio']]++;
            }//if
        }//while
    }//if

    // Pone las materias de la carga que no aparecen en el plan de estudio
    $query_materiascarga = "select distinct m.codigomateria, m.nombremateria, d.semestredetalleplanestudio, ".
    " t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio, ".
    " c.codigoestadocargaacademica ".
    " from materia m, tipomateria t, cargaacademica c, detalleplanestudio d ".
    " where m.codigotipomateria = t.codigotipomateria ".
    " and c.codigoestudiante = '$codigoestudiante' ".
    " and c.codigomateria = m.codigomateria ".
    " and c.codigoperiodo = '$codigoperiodo' ".
    " and c.codigoestadocargaacademica like '1%' ".
    " and c.idplanestudio = d.idplanestudio ".
    " and d.codigomateria = c.codigomateria ".$quitarmaterias1." ".
    " order by 3,2";        

    $materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
    $totalRows_materiascarga = mysql_num_rows($materiascarga);	

    if($totalRows_materiascarga != ""){
        while($row_materiascarga = mysql_fetch_array($materiascarga)){
            if(preg_match("/^1/",$row_materiascarga['codigoestadocargaacademica'])){
                $quitarmaterias1 = "$quitarmaterias1 and c.codigomateria <> ".$row_materiascarga['codigomateria']."";
                $materiasponercarga[] = $row_materiascarga['codigomateria'];
                $materiasfinal[] = $row_materiascarga;
            }//if
        }//while
    }//if
    
    // OJO: El siguiente codigo toca quitarlo despues del 20052
    // Se coloco para pasar por alto el error generado por no guardar el idplanestudio en cargaacademica
    $query_materiascarga = "select m.codigomateria, m.nombremateria, d.semestredetalleplanestudio,
	t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio,
	c.codigoestadocargaacademica
	from materia m, tipomateria t, cargaacademica c, detalleplanestudio d
	where m.codigotipomateria = t.codigotipomateria
	and c.codigoestudiante = '$codigoestudiante'
	and c.codigomateria = m.codigomateria
	and c.codigoperiodo = '$codigoperiodo'
	and c.codigoestadocargaacademica like '1%'
	and d.codigomateria = c.codigomateria
	$quitarmaterias1
	group by 1 order by 3,2";        
	$materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
	$totalRows_materiascarga = mysql_num_rows($materiascarga);
        
	if($totalRows_materiascarga != ""){
            while($row_materiascarga = mysql_fetch_array($materiascarga)){
                if(preg_match("/^1/",$row_materiascarga['codigoestadocargaacademica'])){
                    $quitarmaterias1 = "$quitarmaterias1 and c.codigomateria <> ".$row_materiascarga['codigomateria']."";
                    $materiasponercarga[] = $row_materiascarga['codigomateria'];
                    $materiasfinal[] = $row_materiascarga;
                }//if
            }//while
	}//if
        
	// Esta consulta se usa para obtener las materias que no pertenecen a ningun plan de estudio (Electivas y materias no definidas en algun plan de estudio)
	$query_materiascarga = "select m.codigomateria, m.nombremateria, 1 as semestredetalleplanestudio, ".
	" t.nombretipomateria, t.codigotipomateria, m.numerocreditos as numerocreditosdetalleplanestudio, ".
	" c.codigoestadocargaacademica ".
	" from materia m, tipomateria t, cargaacademica c".
	" where m.codigotipomateria = t.codigotipomateria ".
	" and c.codigoestudiante = '$codigoestudiante' ".
	" and c.codigomateria = m.codigomateria ".
	" and c.codigoperiodo = '$codigoperiodo' ".
	" and c.codigoestadocargaacademica like '1%'".
	"".$quitarmaterias1."".
	" group by 1 order by 3,2";                    
	$materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
	$totalRows_materiascarga = mysql_num_rows($materiascarga);	
	if($totalRows_materiascarga != ""){
            while($row_materiascarga = mysql_fetch_array($materiascarga)){
                if(preg_match("/^1/",$row_materiascarga['codigoestadocargaacademica'])){
                    $quitarmaterias1 = "$quitarmaterias1 and c.codigomateria <> ".$row_materiascarga['codigomateria']."";
                    $materiasponercarga[] = $row_materiascarga['codigomateria'];
                    $materiasfinal[] = $row_materiascarga;
                }//if
            }//while
	}//if

	$entroenalgo = false;
?>
<br>
<table class="table table-striped">
    <tr id="trtitulogris">
        <td>C&oacute;digo</td>
        <td>Asignatura</td>
        <td>Sem.</td>
        <td>Tipo</td>
        <td title="Credios Materia Plan de Estudio"> Cr&eacute;ditos PL</td>
        <td>Cupos disponibles</td>
        <td>Seleccionar</td>
    </tr>
    <?php
    if(isset($materiaspropuestas)){
        $numeromateriaschequeadas = 0;
        foreach($materiaspropuestas as $key3 => $value3){
            // Miro si la materia tiene un grupo derivado de ella
            // Si el grupo es diferente a elestiva libre se trata de un grupo de materias
            // Si no la materia es enfasis
            if(isset($quitarporcursosvacacionales[$value3['codigomateria']])){
                continue;
            }
            if($value3['codigoindicadorgrupomateria'] == '100'){
                $query_selgrupomaterialinea = "SELECT * FROM ".
                " grupomaterialinea g, grupomateria gm, carrera c ".
                " WHERE g.idgrupomateria = gm.idgrupomateria ".
                " AND g.codigomateria = '".$value3['codigomateria']."' ".
                " AND gm.codigoperiodo = '$codigoperiodo' ".
                " AND gm.codigotipogrupomateria <> '100' ".
                " AND c.codigocarrera = '".$row_estudiante['codigocarrera']."' ".
                " AND gm.CodigoEstado = '100' ".
                " AND gm.codigomodalidadacademica = c.codigomodalidadacademica";
                $selgrupomaterialinea = mysql_db_query($database_sala,$query_selgrupomaterialinea) or die("$query_selgrupomaterialinea");
                $totalRows_selgrupomaterialinea = mysql_num_rows($selgrupomaterialinea);
                if($totalRows_selgrupomaterialinea != ""){
                    $materiascongrupo[] = $value3;
                }
            }
            else if(isset($value3['idlineaenfasisplanestudio']) && !empty($value3['idlineaenfasisplanestudio'])){
                $materiasenfasis[] = $value3;
            }else{
                if(!@in_array($value3['codigomateria'],$materiasquitarcarga)){
                    if(!@in_array($value3['codigomateria'],$materiasponercarga)){
                        // Variables para los correquisitos
                        $title = "";
                        $onclic = "";
                        $id = "";

                        $valueserial3 = serialize($value3);
                        $valueserial3 = htmlentities($valueserial3, ENT_QUOTES, 'UTF-8');
                        if($res_sem[0] >= $value3['semestredetalleplanestudio']){
                            $tipomateriacarga = "Propuesta";
                            $chequear = "checked";
                            $numeromateriaschequeadas++;
                        }else{
                            $tipomateriacarga = "Sugerida";
                            $chequear = "";
                        }
                        $desabilitar = "";
                        if(isset($materiasobligatorias)){
                            foreach($materiasobligatorias as $key4 => $value4){
                                if($value4['codigomateria'] == $value3['codigomateria']){
                                    $tipomateriacarga="Perdida";
                                    break;
                                }//if
                            }//foreach
                        }//if

                        if(isset($prematricula_inicial)){
                            foreach($prematricula_inicial as $llave => $codigomateriaprematricula){
                                if($codigomateriaprematricula == $value3['codigomateria']){
                                    $prematriculafiltrar[] = $value3;
                                    $desabilitar = "disabled";
                                    $id = "id='habilita'";
                                    $chequear = "checked";
                                    $tipomateriacarga="Escogida";
                                    break;
                                }//if
                            }//foreach
                        }//if


                        // Mira si la materia tiene corequisitos si el corequisito es doble
                        // A las materias que son corequisitos debe seleccionarlas al tiempo
                        // 1. Al seleccionarala manualmente seleccionar automaticamente los corequisitos

                        // 1. Mira si la materia solamente tiene corequisitos dobles, es decir que primero busca sencillos
                        $query_materiascorequisitosencillo = "select distinct r.codigomateria
                        from referenciaplanestudio r
                        where r.idplanestudio = '".$value3['idplanestudio']."'
                        and r.codigomateria = '".$value3['codigomateria']."'
                        and r.codigotiporeferenciaplanestudio like '201'
                        and r.codigoestadoreferenciaplanestudio = '101'";
                        $materiascorequisitosencillo=mysql_query($query_materiascorequisitosencillo, $sala) or die("$query_materiascorequisitosencillo");
                        $totalRows_materiascorequisitosencillo = mysql_num_rows($materiascorequisitosencillo);
                        if($totalRows_materiascorequisitosencillo == ""){
                            // Mira si tiene corequisitos sencillos como hija
                            $query_materiascorequisitosencillo = "select distinct r.codigomateria from referenciaplanestudio r where r.idplanestudio = '".$value3['idplanestudio']."' and r.codigomateriareferenciaplanestudio = '".$value3['codigomateria']."' and r.codigotiporeferenciaplanestudio like '201' and r.codigoestadoreferenciaplanestudio = '101'";
                            $materiascorequisitosencillo=mysql_query($query_materiascorequisitosencillo, $sala) or die("$query_materiascorequisitosencillo");
                            $totalRows_materiascorequisitosencillo = mysql_num_rows($materiascorequisitosencillo);
                        }
                        // Si no tiene corequisitos sencillos busca los dobles
                        if($totalRows_materiascorequisitosencillo == ""){
                            // Mira si es papa
                            $query_materiascorequisito = "select distinct r.codigomateria
                            from referenciaplanestudio r
                            where r.idplanestudio = '".$value3['idplanestudio']."'
                            and r.codigomateria = '".$value3['codigomateria']."'
                            and r.codigotiporeferenciaplanestudio like '200'
                            and r.codigoestadoreferenciaplanestudio = '101'";
                            $materiascorequisito=mysql_query($query_materiascorequisito, $sala) or die("$query_materiascorequisito");
                            $totalRows_materiascorequisito = mysql_num_rows($materiascorequisito);
                            if($totalRows_materiascorequisito == ""){
                                // Mira si es hija y si es asi pone en title el papa
                                $query_materiascorequisito = "select distinct r.codigomateria
                                from referenciaplanestudio r
                                where r.idplanestudio = '".$value3['idplanestudio']."'
                                and r.codigomateriareferenciaplanestudio = '".$value3['codigomateria']."'
                                and r.codigotiporeferenciaplanestudio like '200'
                                and r.codigoestadoreferenciaplanestudio = '101'";
                                $materiascorequisito=mysql_query($query_materiascorequisito, $sala) or die("$query_materiascorequisito");
                                $totalRows_materiascorequisito = mysql_num_rows($materiascorequisito);
                            }
                            // Si encontro solamente dobles los deja asociados al papa
                            if($totalRows_materiascorequisito != ""){
                                $row_materiascorequisito = mysql_fetch_array($materiascorequisito);
                                $title = "title=".$row_materiascorequisito['codigomateria'];
                                $onclic = "onClick='ChequearTodos(this,$title)'";
                                $id = "id='habilita'";
                            }//if
                        }//if
                        $entroenalgo = true;

                        // Selecciona los datos de los grupos para una materia
                        $query_datosgrupos1 = "SELECT SUM(g.maximogrupo) AS totalgrupo,SUM(matriculadosgrupo + matriculadosgrupoelectiva) ".
                        " AS matriculaditos,".
                        " SUM(g.matriculadosgrupo) summatriculadosgrupo,".
                        " SUM(g.matriculadosgrupoelectiva) summatriculadosgrupoelectiva, ".
                        " SUM(g.maximogrupo) summaximogrupo, SUM(g.maximogrupoelectiva) summaximogrupoelectiva ".
                        " FROM grupo g ".
                        " WHERE g.codigomateria = '".$value3['codigomateria']."' ".
                        " AND g.codigoperiodo = '$codigoperiodo' ".
                        " AND g.codigoestadogrupo = '10'";

                        $datosgrupos1=mysql_query($query_datosgrupos1, $sala) or die("$query_datosgrupos1");
                        $row_datosgrupos1 = mysql_fetch_array($datosgrupos1);
                        $totalRows_datosgrupos1 = mysql_num_rows($datosgrupos1);

                        $cupo=cupopertenecemateria($value3['codigomateria'],$codigocarrera,$row_datosgrupos1);
                        ?>
                        <tr>
                            <td><?php echo $value3['codigomateria'];?></td>
                            <td><?php echo $value3['nombremateria'];?></td>
                            <td><?php echo $value3['semestredetalleplanestudio'];?></td>
                            <td><?php echo "$tipomateriacarga";?></td>
                            <td><?php echo $value3['numerocreditosdetalleplanestudio'];?></td>
                            <td><?php //$cupo = $row_datosgrupos1['totalgrupo'] - $row_datosgrupos1['matriculaditos'];
                            if($cupo < 0){echo '0';}else{echo $cupo;} ?>
                            </td>
                            <td><?php
                            if($cupo <= 0){
                                $desabilitar="disabled";
                            }
                            echo "<input name='sugerida$key3' type='checkbox' $id $title value='$valueserial3' $onclic $chequear $desabilitar> ";
                            ?></td>
                        </tr>
                        <?php
        $materiaspantallainicial[] = $value3['codigomateria'];
    }//if
                }//if
            }//else
        }//foreach
    }//if

    if(isset($materiasfinal)){
        foreach($materiasfinal as $key5 => $value5){
            $desabilitar = "";
            if(isset($quitarporcursosvacacionales[$value5['codigomateria']])){
                continue;
            }
            $valueserial5 = serialize($value5);
            if(isset($prematricula_inicial)){
                $desabilitar = "";
                $id = "";
                $chequear = "";
                foreach($prematricula_inicial as $llave => $codigomateriaprematricula){
    if($codigomateriaprematricula == $value5['codigomateria']){
                        $prematriculafiltrar[] = $value5;
                        $desabilitar = "disabled";
                        $id = "id='habilita'";
                        $chequear = "checked";
                        //break;
    }//if
                }//forach
            }//if
            $entroenalgo = true;

            $query_datosgrupos1 = "SELECT SUM(g.maximogrupo) AS totalgrupo,SUM(matriculadosgrupo + matriculadosgrupoelectiva) AS matriculaditos, ".
"  SUM(g.matriculadosgrupo) summatriculadosgrupo, ".
" SUM(g.matriculadosgrupoelectiva) summatriculadosgrupoelectiva, ".
" SUM(g.maximogrupo) summaximogrupo, SUM(g.maximogrupoelectiva) summaximogrupoelectiva ".
            " FROM grupo g ".
            " WHERE g.codigomateria = '".$value5['codigomateria']."' ".
            " AND g.codigoperiodo = '$codigoperiodo' ".
            " AND g.codigoestadogrupo = '10'";
            $datosgrupos1=mysql_query($query_datosgrupos1, $sala) or die("$query_datosgrupos1");
            $row_datosgrupos1 = mysql_fetch_array($datosgrupos1);
            $totalRows_datosgrupos1 = mysql_num_rows($datosgrupos1);
            $cupo=cupopertenecemateria($value5['codigomateria'],$codigocarrera,$row_datosgrupos1);
            ?>
            <tr>
                <td><?php echo $value5['codigomateria'];?></td>
                <td><?php echo $value5['nombremateria'];?></td>
                <td><?php echo $value5['semestredetalleplanestudio'];?></td>
                <td>Sin Restricción</td>
                <td><?php echo $value5['numerocreditosdetalleplanestudio'];?></td>

                <td><?php //$cupo = $row_datosgrupos1['totalgrupo'] - $row_datosgrupos1['matriculaditos'];
                    if($cupo < 0){echo '0';}else{echo $cupo;} ?>
                </td>
                <td><?php
                    //$desabilitar="";
                    if($cupo <= 0){
                        $desabilitar="disabled";
                    }
                    echo "<input name='sinrestriccion$key5' type='checkbox' value='$valueserial5' $id $desabilitar $chequear>";
                    ?>
                </td>
                <?php
                $materiaspantallainicial[] = $value5['codigomateria'];
        }//foreach
        ?>
        </tr>
        <?php
    }//if
    if(isset($prematriculafiltrar)){
        foreach($prematriculafiltrar as $key6 => $value6){
            if(isset($quitarporcursosvacacionales[$value6['codigomateria']])){
                continue;
            }

            $valueserial6 = serialize($value6);
            if(isset($prematricula_inicial)){
                $desabilitar = "";
                $id = "";
                $chequear = "";

                $estamateria = false;
                foreach($prematricula_inicial as $llave => $codigomateriaprematricula){
    if($codigomateriaprematricula == $value6['codigomateria']){
                        $prematriculaencontrada[] = $codigomateriaprematricula;
                        $estamateria = true;
                        break;
    }//if
                }//foreach
            }//if
            $desabilitar = "disabled";
            $id = "id='habilita'";
            $chequear = "checked";
            if(!$estamateria){
                $entroenalgo = true;
    $query_datosgrupos1 = "SELECT SUM(g.maximogrupo) AS totalgrupo,SUM(matriculadosgrupo + matriculadosgrupoelectiva) AS matriculaditos ".
                " , SUM(g.matriculadosgrupo) summatriculadosgrupo, ".
                " SUM(g.matriculadosgrupoelectiva) summatriculadosgrupoelectiva, ".
                " SUM(g.maximogrupo) summaximogrupo, SUM(g.maximogrupoelectiva) summaximogrupoelectiva ".
                " FROM grupo g ".
                " WHERE g.codigomateria = '".$value6['codigomateria']."' ".
                " AND g.codigoperiodo = '$codigoperiodo' ".
                " AND g.codigoestadogrupo = '10'";
                $datosgrupos1=mysql_query($query_datosgrupos1, $sala) or die("$query_datosgrupos1");
                $row_datosgrupos1 = mysql_fetch_array($datosgrupos1);
                $totalRows_datosgrupos1 = mysql_num_rows($datosgrupos1);

                $cupo=cupopertenecemateria($value6['codigomateria'],$codigocarrera,$row_datosgrupos1);
                ?>
                <tr>
                    <td><?php echo $value6['codigomateria'];?></td>
                    <td><?php echo $value6['nombremateria'];?></td>
                    <td><?php echo $value6['semestredetalleplanestudio'];?></td>
                    <td>Sin Restricción</td>
                    
                    <td><?php echo $value6['numerocreditosdetalleplanestudio'];?></td>
                    <td><?php // $cupo = $row_datosgrupos1['totalgrupo'] - $row_datosgrupos1['matriculaditos'];
                    if($cupo < 0){echo '0';}else{echo $cupo;} ?>
                    </td>
                    <td><?php
                    if($cupo <= 0){
                        $desabilitar="disabled";
                    }
                    echo "<input name='sinrestriccion$key5' type='checkbox' value='$valueserial5' $id $desabilitar $chequear>";
                    ?>
                    </td>
                    <?php
                    $materiaspantallainicial[] = $value6['codigomateria'];
            }//if
        }//foreach
        ?>
        </tr>
        <?php
    }//if

    if(isset($prematricula_inicial)){
        foreach($prematricula_inicial as $key7 => $value7){
            if(isset($prematriculaencontrada)){
                $estamateria = true;
                foreach($prematriculaencontrada as $key8 => $value8){
    if($value8 == $value7){
                        $estamateria = true;
                        break;
    }//if
                }//foreach
                $desabilitar = "disabled";
                $id = "id='habilita'";
                $chequear = "checked";
                if(!$estamateria){
    if(isset($quitarporcursosvacacionales[$value7])){
                        continue;
    }
    $query_datosmateriafinal = "select m.nombremateria, d.semestredetalleplanestudio, ".
                    " d.codigotipomateria, d.numerocreditosdetalleplanestudio,m.numerocreditos as numCreditoTbMateria ".
    " from materia m, detalleplanestudio d, planestudioestudiante pe ".
    " where m.codigomateria = '$value7' ".
    " and d.codigomateria = m.codigomateria ".
    " and pe.codigoestudiante = '$codigoestudiante' ".
    " and pe.idplanestudio = d.idplanestudio ".
    " and pe.codigoestadoplanestudioestudiante = '101'";
    $datosmateriafinal=mysql_query($query_datosmateriafinal, $sala) or die("$query_datosmateriafinal");
    $totalRows_datosmateriafinal = mysql_num_rows($datosmateriafinal);
    // Si encontro solamente dobles los deja asociados al papa
    if($totalRows_datosmateriafinal != ""){
                        $row_datosmateriafinal = mysql_fetch_array($datosmateriafinal);
                        $entroenalgo = true;
                        $query_datosgrupos1 = "SELECT SUM(g.maximogrupo) AS totalgrupo,SUM(matriculadosgrupo + matriculadosgrupoelectiva) AS matriculaditos
                        , SUM(g.matriculadosgrupo) summatriculadosgrupo,
                        SUM(g.matriculadosgrupoelectiva) summatriculadosgrupoelectiva,
                        SUM(g.maximogrupo) summaximogrupo, SUM(g.maximogrupoelectiva) summaximogrupoelectiva
                        FROM grupo g
                        WHERE g.codigomateria = '".$row_datosmateriafinal['codigomateria']."'
                        AND g.codigoperiodo = '$codigoperiodo'
                        AND g.codigoestadogrupo = '10'";
                        $datosgrupos1=mysql_query($query_datosgrupos1, $sala) or die("$query_datosgrupos1");
                        $row_datosgrupos1 = mysql_fetch_array($datosgrupos1);
                        $totalRows_datosgrupos1 = mysql_num_rows($datosgrupos1);
                        $cupo=cupopertenecemateria($row_datosmateriafinal['codigomateria'],$codigocarrera,$row_datosgrupos1);
                        ?>
                        <tr>
                            <td><?php echo $row_datosmateriafinal['codigomateria'];?></td>
                            <td><?php echo $row_datosmateriafinal['nombremateria'];?>&nbsp;</td>
                            <td><?php echo $row_datosmateriafinal['semestredetalleplanestudio'];?></td>
                            <td><?php //echo row_datosmateriafinal['']?></td>
                             <td><?php echo $row_datosmateriafinal['numCreditoTbMateria'];?></td>
                            <td><?php echo $row_datosmateriafinal['numerocreditosdetalleplanestudio'];?></td>
                            <td><?php //$cupo = $row_datosgrupos1['totalgrupo'] - $row_datosgrupos1['matriculaditos'];
                            if($cupo < 0){echo '0';}else{echo $cupo;} ?>
                            </td>
                            <td>
                            <?php
        if($cupo <= 0){
                                $desabilitar="disabled";
                            }
                            echo "<input name='sinrestriccion$key5' type='checkbox' value='$valueserial5' $id $desabilitar $chequear>";
        ?>
                            </td>
                            <?php
        $materiaspantallainicial[] = $row_datosmateriafinal['codigomateria'];
    }//if
                }//if
            }//if
            ?>
            </tr>
            <?php
        }//foreach
    }//if
    if(!$entroenalgo){
        ?>
        <tr>
            <td colspan="6">
            <label id="labelresaltado">El estudiante no tiene carga académica</label>
            </td>
        </tr>
        <?php
    }//if
    ?>
</table>
<?php

    $entroengrupo = false;

    // Materias con grupo
    if(isset($materiascongrupo)){
        $title = "";
        $onclic = "";
        $id = "";
        $chequear = "";
        ?>
        <br>
        <div class="col-md-12">
        <table class="table table-striped">
            <?php
                foreach($materiascongrupo as $key11 => $value11){
            $chequear = "";
            $desabilitar = "";
            if(isset($quitarporcursosvacacionales[$value11['codigomateria']])){
                continue;
            }
            if(!@in_array($value11['codigomateria'],$materiasquitarcarga)){
                //echo "$query_mategrupos dasda<br>";
                if(!@in_array($value11['codigomateria'],$materiasponercarga)){
    $valueserial11 = serialize($value11);
    $title = "title=".$value11['codigomateria'];
    // Si la materia existe en detalle prematricula desabilita todas las demas, dejando chequeada la activa en prematricula
    $query_mategrupo = "SELECT d.codigomateria ".
    " FROM detalleprematricula d, prematricula p, materia m, estudiante e ".
    " where d.codigomateria = m.codigomateria ".
    " and d.idprematricula = p.idprematricula ".
    " and p.codigoestudiante = e.codigoestudiante ".
    " and e.codigoestudiante = '$codigoestudiante' ".
    " and d.codigomateriaelectiva = '".$value11['codigomateria']."' ".
    " and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') ".
    " and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula = '23') ".
    " and p.codigoperiodo = '$codigoperiodo'";
    $mategrupo=mysql_query($query_mategrupo, $sala) or die("$query_mategrupo");
    $totalRows_mategrupo = mysql_num_rows($mategrupo);
    if($totalRows_mategrupo != ""){
                        $row_mategrupo = mysql_fetch_array($mategrupo);
                        if(isset($quitarporcursosvacacionales[$row_mategrupo['codigomateria']])){
                            continue;
                        }
                        $materiaescogida = $row_mategrupo['codigomateria'];
                        $desabilitar = "disabled";
                        $chequear = "checked";
                        $id = "id='habilita'";
                    }else{
                        $desabilitar = "";
                        $materiaescogida = "";
    }
    $numeromateriaschequeadas++;
    //$chequear = "checked";
    $onclic = "onClick='HabilitarGrupoCheck($title)'";
    if(isset($materiasobligatoriascongrupo) && !empty($materiasobligatoriascongrupo)) {
        if (@in_array($value11['codigomateria'], $materiasobligatoriascongrupo)) {
            $chequear = "checked";
            $desabilitar = "disabled";
            $id = "id='habilita'";
            $esobligatoria = true;
        }
    }
                    ?>
                    <tr>
                        <td><strong><?php echo $value11['codigomateria'];?></strong></td>
                        <td colspan="6">
                            <label id="labelresaltado">
                            <?php echo $value11['nombremateria']; ?>
                            </label>
                        </td>
                        <td colspan="1">
                        <?php
                        echo "<input name='grupopapa$key11' type='checkbox' $id $title value='$valueserial11' $chequear $desabilitar $onclic>";
                        ?>
                        </td>
                    </tr>
                    <tr id="trtitulogris">
                        <td>C&oacute;digo</td>
                        <td>Asignatura</td>
                        <td>Sem.</td>
                        <td width="116"> Tipo</td>
                        <td title="Creditos Materia">Cr&eacute;ditos Materia</td>
                        <td title="Creditos Materia Plan de Estudio"> Cr&eacute;ditos PL</td>
                        <td>Cupos disponibles</td>
                        <td>Seleccionar</td>
                    </tr>
                    <?php
    $chequear = "";
    $id = "";

    /*
    * Ivan Dario Quintero Rios
    * ajustes de consulta de materias electivas tecnicas y no vistas por el estudiante
    * dicimebre 7 del 2017
    */
    // Selleciono el grupo de la materia -- Solamente aquellas que no ha vsto el estudiante
    $query_datosgrupo = "select distinct d.codigomateria, m.nombremateria, m.numerohorassemanales, ".
                    " m.numerocreditos as numerocreditosdetalleplanestudio ".
    " from detallegrupomateria d, materia m, grupomaterialinea gm ".
    " where d.codigomateria = m.codigomateria ".
    " and gm.codigomateria = '".$value11['codigomateria']."' ".
    " and gm.idgrupomateria = d.idgrupomateria ".
    " and gm.codigoperiodo = '$codigoperiodo' ".
                    " order by m.nombremateria";
                    /*
                    * END
                    */

    $datosgrupo=mysql_query($query_datosgrupo, $sala) or die("$query_datosgrupo");
    $totalRows_datosgrupo = mysql_num_rows($datosgrupo);
    if($totalRows_datosgrupo != ""){
                        $entroengrupo = false;
                        $creditoshijo = "";
                        while($row_datosgrupo = mysql_fetch_array($datosgrupo)){
                            $creditoshijo = $row_datosgrupo['numerocreditosdetalleplanestudio'];
                            $row_datosgrupo['semestredetalleplanestudio'] = $value11['semestredetalleplanestudio'];
                            $row_datosgrupo['numerocreditosdetalleplanestudio'] = $value11['numerocreditosdetalleplanestudio'];

                            // Variables para los correquisitos
                            $valueserial12 = serialize($row_datosgrupo);
                            if($materiaescogida == $row_datosgrupo['codigomateria']){
                                $chequear = "checked";
                                $id = "id='habilita'";
                            }else{
                                if(!$entroengrupo){
                                    $chequear = "";
                                }else{
                                    $chequear = "";
                                    $id = "";
                                }
                            }
                            $desabilitar = "disabled";
                            $entroengrupo = true;
                            if($esobligatoria){
                                $desabilitar = "";
                            }

                            // Selecciona los datos de los grupos para una materia
                            $query_datosgrupos1 = "SELECT SUM(g.maximogrupo) AS totalgrupo,SUM(matriculadosgrupo + matriculadosgrupoelectiva) AS matriculaditos,
                            SUM(g.matriculadosgrupo) summatriculadosgrupo,
                            SUM(g.matriculadosgrupoelectiva) summatriculadosgrupoelectiva,
                            SUM(g.maximogrupo) summaximogrupo, SUM(g.maximogrupoelectiva) summaximogrupoelectiva
                            FROM grupo g
                            WHERE g.codigomateria = '".$row_datosgrupo['codigomateria']."'
                            AND g.codigoperiodo = '$codigoperiodo'
                            AND g.codigoestadogrupo = '10'";
                            $datosgrupos1=mysql_query($query_datosgrupos1, $sala) or die("$query_datosgrupos1");
                            $row_datosgrupos1 = mysql_fetch_array($datosgrupos1);
                            $totalRows_datosgrupos1 = mysql_num_rows($datosgrupos1);

                            $cupo=cupopertenecemateria($row_datosgrupo['codigomateria'],$codigocarrera,$row_datosgrupos1);
                            /******  agrego para mostrar el cupo de las electivas 17.01.2007 ******/
                            ?>
                            <tr>
                                <td><?php echo $row_datosgrupo['codigomateria'];?></td>
                                <td><?php echo $row_datosgrupo['nombremateria'];?>&nbsp;</td>
                                <td><?php echo $row_datosgrupo['semestredetalleplanestudio'];?></td>
                                <td width="116"><?php echo "Propuesta";?></td>
                                <td><?php echo /*$creditoshijo;*/$creditoshijo; ?></td>
                                <td><?php echo /*$creditoshijo;*/$row_datosgrupo['numerocreditosdetalleplanestudio']; ?></td>
                                <td><?php
                                //$cupo = $row_datosgrupos1['totalgrupo'] - $row_datosgrupos1['matriculaditos'];
                                if($cupo < 0){echo '0';}else{echo $cupo;} ?>
                                </td>
                                <td><?php
                                if($cupo <= 0){
                                    $desabilitar="disabled";
                                    echo "<input name='grupohijo$key11' type='checkbox' value='$valueserial12' $id $desabilitar $chequear>";
                                }else{
                                    echo "<input name='grupohijo$key11' type='radio' $id $title value='$valueserial12' $chequear $desabilitar>"; //ACA ES ELECTIVA TECNICA
                                }
                                ?>
                                </td>
                                <?php
                        }//while
    }//if
                    ?>
                    </tr>
                    <?php
                }//if
            }//if
        }//foreach
            ?>
        </table>
        </div>
    <?php
    }// if(isset($materiascongrupo))

    $entroenenfasis = false;
    // Materias que que son enfasis
    if(isset($materiasenfasis)){
        ?>
        <br><br>
        <div class="col-md-12">
        <table class="table table-striped">
            <tr>
                <td colspan="7"><strong>LINEAS DE &Eacute;NFASIS</strong></td>
            </tr>
                <?php
                    foreach($materiasenfasis as $key8 => $value8){
                //$idvievo = 1;
                if(isset($quitarporcursosvacacionales[$value8['codigomateria']])){
                    continue;
                }

                if(!@in_array($value8['codigomateria'],$materiasquitarcarga)){
                    if(!@in_array($value8['codigomateria'],$materiasponercarga)){
        // Variables para los correquisitos
        $title = "";
        $onclic = "";
        $id = "";

        $valueserial8 = serialize($value8);
        //echo $valueserial3;
        if($res_sem[0] >= $value8['semestredetalleplanestudio']){
                            $tipomateriacarga = "Propuesta";
                            $chequear = "checked";
                            $numeromateriaschequeadas++;
        }else{
                            $tipomateriacarga = "Sugerida";
                            $chequear = "";
        }
        if(!$estudiantetieneenfasis){
                            $desabilitar = "disabled";
        }else{
                            $desabilitar = "";
        }
        if(isset($prematricula_inicial)){
                            foreach($prematricula_inicial as $llave => $codigomateriaprematricula){
                                if($codigomateriaprematricula == $value8['codigomateria']){
                                    $prematriculafiltrar[] = $value8;
                                    $desabilitar = "disabled";
                                    $id = "id='habilita'";
                                    $chequear = "checked";
                                    break;
                                }//if
                            }//foreach
        }//if
        $entroenenfasis = true;
        $enfasisget = "tieneenfasis";
        if(!isset($idviejo)){
            $idviejo ="";
        }

        if($idviejo != $value8['idlineaenfasisplanestudio']){
                            $query_sellinea = "select l.nombrelineaenfasisplanestudio from lineaenfasisplanestudio l ".
                            " where l.idlineaenfasisplanestudio = '".$value8['idlineaenfasisplanestudio']."'";
                            $sellinea=mysql_query($query_sellinea, $sala) or die("$query_sellinea");
                            $totalRows_sellinea = mysql_num_rows($sellinea);
                            // Si encontro solamente dobles los deja asociados al papa
                            if($totalRows_sellinea != ""){
                                $row_sellinea = mysql_fetch_array($sellinea);
                                $title = "title=".$value8['idlineaenfasisplanestudio'];
                                ?>
                                <tr>
                                    <td colspan="6"><?php echo $row_sellinea['nombrelineaenfasisplanestudio'];?></td>
                                    <td><?php
                                        if(!$estudiantetieneenfasis){
                                            ?>
                                            <input name="lineaunica" type="radio" onClick="HabilitarGrupo(<?php echo $title; ?>)" value="<?php echo $value8['idlineaenfasisplanestudio'];?>">
                                            <?php
                                        }else{
                                            ?>
                                            <input name="lineaunica" type="hidden" value="<?php echo $value8['idlineaenfasisplanestudio'];?>">
                                            <?php
                                        }
                ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>C&oacute;digo</strong></td>
                                    <td><strong>Asignatura</strong></td>
                                    <td><strong>Sem</strong></td>
                                    <td><strong>Tipo</strong></td>
                                    <td><strong>Cr&eacute;ditos</strong></td>
                                    <td><strong>Cupos disponibles</strong></td>
                                    <td><strong>Seleccionar</strong></td>
                                </tr>
                                <?php
                                $idviejo = $value8['idlineaenfasisplanestudio'];
                            }//if
        }//if
        $title = "title=".$idviejo;

                        // Selecciona los datos de los grupos para una materia
        $query_datosgrupos = "SELECT SUM(g.maximogrupo) AS totalgrupo,SUM(matriculadosgrupo + matriculadosgrupoelectiva) "
                        ." AS matriculaditos, SUM(g.matriculadosgrupo) summatriculadosgrupo, SUM(g.matriculadosgrupoelectiva) ".
                        " summatriculadosgrupoelectiva, SUM(g.maximogrupo) summaximogrupo, SUM(g.maximogrupoelectiva) summaximogrupoelectiva ".
                        "FROM grupo g WHERE g.codigomateria = '".$value8['codigomateria']."' AND g.codigoperiodo = '$codigoperiodo' AND ".
                        "g.codigoestadogrupo = '10'";
        $datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
        $row_datosgrupos = mysql_fetch_array($datosgrupos);
        $totalRows_datosgrupos = mysql_num_rows($datosgrupos);

        $cupo=cupopertenecemateria($value8['codigomateria'],$codigocarrera,$row_datosgrupos);
        /******  agrego para mostrar el cupo de las electivas 17.01.2007 ******/
                        ?>
                        <tr>
                            <td><?php echo $value8['codigomateria'];?></td>
                            <td><?php echo $value8['nombremateria'];?></td>
                            <td><?php echo $value8['semestredetalleplanestudio'];?></td>
                            <td><?php echo "$tipomateriacarga";?></td>
                            <td><?php echo $value8['numerocreditosdetalleplanestudio'];?></td>
                            <td><?php //$cupo = $row_datosgrupos['totalgrupo'] - $row_datosgrupos['matriculaditos'];
                                if($cupo < 0){echo '0';}else{echo $cupo;} ?>
                            </td>
                            <td><?php
                            if($cupo <= 0){
                                $desabilitar="disabled";
                            }
                            echo "<input name='electoblig$key8' type='checkbox' $id $title value='$valueserial8' $chequear $desabilitar>";
                            ?></td>
                            <?php
                    }//if
                }//if
            }//foreach
                 ?>
            </tr>
            <?php if(!$entroenenfasis){ ?><tr>
                <td colspan="6">
                    <label id="labelresaltado">El estudiante ha cumplido con las línea de énfasis del plan de estudio</label>
                </td>
            </tr>
            <?php
        }//if
            ?>
        </table>
        </div>
        <?php
    }// if(isset($materiasenfasis))
    if(!isset($_SESSION['cursosvacacionalessesion'])){

        include_once("../facultades/registro_graduados/carta_egresados/functionsElectivasPendientes.php");

        $query_electivaslibresvistas = getQueryMateriasElectivasCPEstudiante($codigoestudiante);
        $electivaslibresvistas=mysql_query($query_electivaslibresvistas, $sala) or die("$query_electivaslibresvistas");
        $totalRows_electivaslibresvistas = mysql_num_rows($electivaslibresvistas);
        $numerocreditoselectivasvistas = null;
        $sinelectivas = "";

        if($totalRows_electivaslibresvistas != ""){
            while($row_electivaslibresvistas = mysql_fetch_array($electivaslibresvistas)){
                if($row_electivaslibresvistas['codigoindicadorcredito'] == "100"){
                    $numerocreditoselectivasvistas = $numerocreditoselectivasvistas + $row_electivaslibresvistas['numerocreditos'];
                }else if($row_electivaslibresvistas['codigoindicadorcredito'] == "200"){
                    $creditosulas = round(($row_electivaslibresvistas['ulasa'] + $row_electivaslibresvistas['ulasb'] + $row_electivaslibresvistas['ulasc'])/48);
                    $numerocreditoselectivasvistas = $numerocreditoselectivasvistas + $creditosulas;
                }
                $sinelectivas = "$sinelectivas and codigomateria <> ".$row_electivaslibresvistas['codigomateria']."";
                $electivasaprobadas[] = $row_electivaslibresvistas;
            }//while
        }else{
            $numerocreditoselectivasvistas = 0;
        }

        if($tieneelectivas){
            $numerocreditosfaltantes = $numerocreditoselectivas - $numerocreditoselectivasvistas;
            if($numerocreditosfaltantes != 0){
                ?>
                <br><br>
                <?php
                /*
                * Ivan Dario quintero rios
                * Noviembre 14 del 2017
                * Adicion de consulta del estado del grupomateria en 100 y la modalidad academica de la carrera
                */
                $query_grupomateria = "SELECT * FROM ".
                " grupomateria gm, carrera c ".
                " WHERE codigotipogrupomateria = '100' ".
                " AND codigoperiodo = '".$codigoperiodo."' ".
                " AND gm.CodigoEstado = '100' ".
                " AND c.codigocarrera = '".$row_estudiante['codigocarrera'] ."' ".
                " AND gm.codigomodalidadacademica = c.codigomodalidadacademica";
                /*
                * END
                */
                $datosgrupomateria=mysql_query($query_grupomateria, $sala) or die("$query_grupomateria");
                $totalRows_datosgrupomateria = mysql_num_rows($datosgrupomateria);

                if($totalRows_datosgrupomateria != ""){
                    while($row_grupomateria = mysql_fetch_array($datosgrupomateria)){
                        ?>
                        <div class="col-md-12">
                        <table class="table table-striped">
                            <tr id="trtitulogris">
                                <td colspan="5"><?php echo $row_grupomateria["nombregrupomateria"]; ?></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
                                        <tr>
                                            <td><label id="labelresaltado">CREDITOS VISTOS</label></td>
                                            <td><?php echo $numerocreditoselectivasvistas; ?></td>
                                            <td><label id="labelresaltado">CREDITOS FALTANTES</label></td>
                                            <td>
                                                <?php $numerocreditosfaltantes = $numerocreditoselectivas - $numerocreditoselectivasvistas;
                                                if($numerocreditosfaltantes > 0){
                                                    echo $numerocreditosfaltantes;
                                                }else{
                                                    echo "0";
                                                }?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr id="trtitulogris">
                                <td height="23">C&oacute;digo</td>
                                <td> Asignatura</td>
                                <td> Cr&eacute;ditos</td>
                                <td> Cupos disponibles</td>
                                <td> Seleccionar</td>
                            </tr>
                            <?php
                            /*Ivan Quintero - 19 diciembre */
                            // CONSULTA LAS MATERIAS ELECTIVAS QUE NO HA VISTO EL ESTUDIANTE
                            // En caso de que exista una electiva libre que se halla escogido como obligatoria tampoco deberia aparecer aca
                            // Es decir que hay que quitar las materias que tenga el plan de estudios
                            /*
                            * Ivan Dario quintero rios
                            * Noviembre 14 del 2017
                            * Adicion de consulta del estado del grupomateria en 100 y la modalidad academica de la carrera
                            */
                            $query_datoselectivas = "SELECT DISTINCT ".
                            " m.codigomateria, m.nombremateria, m.numerohorassemanales, m.numerocreditos ".
                            " FROM materia m, grupomateria gm, detallegrupomateria d, carrera c ".
                            " WHERE gm.codigotipogrupomateria = '100' ".
                            " AND gm.codigoperiodo = '$codigoperiodo' ".
                            " AND d.idgrupomateria = gm.idgrupomateria ".
                            " AND m.codigomateria = d.codigomateria ".
                            " AND c.codigocarrera = '".$row_estudiante['codigocarrera']."' ".
                            " AND gm.CodigoEstado = '100' ".
                            " AND gm.codigomodalidadacademica = c.codigomodalidadacademica ".
                            " AND gm.idgrupomateria = '".$row_grupomateria["idgrupomateria"]."' ".$quitarmateriasdelplandestudios." ".
                            " ORDER BY m.nombremateria";
                            /*
                            * END
                            */
                            $datoselectivas=mysql_query($query_datoselectivas, $sala) or die("$query_datoselectivas");
                            $totalRows_datoselectivas = mysql_num_rows($datoselectivas);
                            if($totalRows_datoselectivas != ""){
                                $electivasaprobadas1 = $electivasaprobadas;
                                $cuentamateriaselectivas = 0;
                                while($row_datoselectivas = mysql_fetch_array($datoselectivas)){
                                    // Selecciona los datos de los grupos para una materia
                                    $query_datosgrupos = "SELECT SUM(g.maximogrupo) AS totalgrupo, ".
                                    " SUM(matriculadosgrupo + matriculadosgrupoelectiva) AS matriculaditos, ".
                                    " SUM(g.matriculadosgrupo) summatriculadosgrupo, SUM(g.matriculadosgrupoelectiva) ".
                                    " summatriculadosgrupoelectiva, SUM(g.maximogrupo) summaximogrupo, SUM(g.maximogrupoelectiva) ".
                                    " summaximogrupoelectiva FROM grupo g WHERE g.codigomateria = '".$row_datoselectivas['codigomateria']."' ".
                                    " AND g.codigoperiodo = '$codigoperiodo' AND g.codigoestadogrupo = '10'";
                                    $datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
                                    $row_datosgrupos = mysql_fetch_array($datosgrupos);
                                    $totalRows_datosgrupos = mysql_num_rows($datosgrupos);

                                    $SQL="SELECT COUNT(p.codigoestudiante) AS numeromatriculados FROM detalleprematricula d, ".
                                    " prematricula p, estudiante e, grupo g, materia m WHERE d.idprematricula = p.idprematricula ".
                                    " AND p.codigoestudiante = e.codigoestudiante AND (p.codigoestadoprematricula LIKE '1%' OR ".
                                    " p.codigoestadoprematricula LIKE '4%' ) AND (d.codigoestadodetalleprematricula LIKE '1%' OR ".
                                    " d.codigoestadodetalleprematricula LIKE '3%' ) AND g.idgrupo = d.idgrupo AND g.codigomateria ".
                                    "= '".$row_datoselectivas['codigomateria']."' AND p.codigoperiodo = '".$codigoperiodo."' AND ".
                                    "g.codigoestadogrupo = '10'	AND e.codigocarrera != m.codigocarrera	AND g.codigomateria = m.codigomateria";
                                    $NumGrup=mysql_query($SQL, $sala) or die("$SQL");
                                    $row_NumGrup = mysql_fetch_array($NumGrup);

                                    $row_datosgrupos[3] = $row_NumGrup['numeromatriculados'];
                                    $row_datosgrupos['summatriculadosgrupoelectiva'] = $row_NumGrup['numeromatriculados'];
                                    $cupo=cupopertenecemateria($row_datoselectivas['codigomateria'],$codigocarrera,$row_datosgrupos,1);

                                    $desabilitar = "";
                                    $chequear = "";

                                    $electivavista = false;
                                    $electivasuperiorencreditos = false;

                                    if($numerocreditosfaltantes < $row_datoselectivas['numerocreditos']){
                                        $electivasuperiorencreditos = true;
                                    }
                                    else if(isset($electivasaprobadas))
                                    {
                                        foreach($electivasaprobadas1 as $key1 => $value1){
                                            if($value1['codigomateria'] == $row_datoselectivas['codigomateria']){
                                                $electivavista = true;
                                            }
                                        }//foreach
                                    }//else

                                    if(!$electivavista && !$electivasuperiorencreditos){
                                        $row_datoselectivasserial = serialize($row_datoselectivas);
                                        if(isset($prematricula_inicial)){
                                            foreach($prematricula_inicial as $llave2 => $codigomateriaprematricula){

                                                if($codigomateriaprematricula == $row_datoselectivas['codigomateria']){

                                                    $desabilitar = "disabled";

                                                    $query_detalle = "SELECT d.codigomateriaelectiva,dp.codigotipomateria ".
                                                    " FROM prematricula p,detalleprematricula d,detalleplanestudio dp ".
                                                    " WHERE p.idprematricula = d.idprematricula ".
                                                    " AND dp.codigomateria = d.codigomateriaelectiva ".
                                                    " AND dp.idplanestudio = '".$idplan."' ".
                                                    " AND d.codigomateria = '".$codigomateriaprematricula."' ".
                                                    " AND p.codigoestudiante = '".$codigoestudiante."' ".
                                                    " AND dp.codigotipomateria = '4' ".
                                                    " AND (codigoestadodetalleprematricula LIKE '1%' OR codigoestadodetalleprematricula LIKE '3%')";

                                                    $detalle = mysql_query($query_detalle, $sala) or die("$query_detalle");
                                                    $row_detalle = mysql_fetch_array($detalle);
                                                    $totalRows_detalle = mysql_num_rows($detalle);

                                                    if ($row_detalle <> ""){
                                                        $chequear = "checked";
                                                    }

                                                    break;
                                                }// if($codigomateriaprematricula == $row_datoselectivas['codigomateria'])
                                            }// foreach($prematricula_inicial as $llave2 => $codigomateriaprematricula)
                                        }// if(!$electivavista && !$electivasuperiorencreditos)
                                        ?>
                                        <tr>
                                            <td><?php echo $row_datoselectivas['codigomateria'];?></td>
                                            <td><?php echo $row_datoselectivas['nombremateria'];?></td>
                                            <td><?php echo $row_datoselectivas['numerocreditos'];?></td>
                                            <td><?php if($cupo < 0){echo '0';}else{echo $cupo;} ?></td>
                                            <td><?php
                                                if($cupo <= 0)
                                                {
                                                    $desabilitar="disabled";
                                                }
                                                echo "<input name='electiva$cuentamateriaselectivas' type='checkbox' id='habilita' value='$row_datoselectivasserial' $chequear $desabilitar>";
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $cuentamateriaselectivas++;
                                    }// if(!$electivavista && !$electivasuperiorencreditos)
                                }// while($row_datoselectivas = mysql_fetch_array($datoselectivas))
                                ?>
                            </table>
                                </div>
                            <?php
                            }//if
                    }//while
                }//if
            }//end while grupomateria
        }//end if total grupomateria
    }//if
    ?>
    <p>
        <?php

        /****************** VALIDACION FECHA PARA PREMATRICULA FACULTAD ***********************************/
        $fecha= "select * from fechaacademica f where f.codigocarrera = '".$_SESSION['codigofacultad']."' ".
        " and f.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'";
        $db=mysql_query($fecha, $sala) or die("$fecha");
        $total = mysql_num_rows($db);
        $resultado=mysql_fetch_array($db);
        $fechavalidaprematricula = true;

        if ($resultado <> ""){
            if (
                    (date("Y-m-d",(time())) < $resultado['fechainicialprematriculacarrera']) or
                    (date("Y-m-d",(time())) > $resultado['fechafinalprematriculacarrera'])
            )
            {
                $fechavalidaprematricula = false;
            }
        }
        if ($fechavalidaprematricula){?>
            <input  class="btn btn-info btn-sm" name="manual" type="submit" id="manual" value="Horario Manual" onClick="habilitar(this.form.habilita)">
        <?php }//if

        /****************** FIN VALIDACION FECHA PARA PREMATRICULA ***********************************/
        ?>
        <input class="btn btn-danger btn-sm" name="regresar1" type="button" value="Regresar" onClick="regresar()">
    </p>
    <?php

        $sumacredtitoselectivas = 0;
        $numeromateriaselegidas = 0;
        $cont = 0;

        foreach($_POST as $llavepost => $valorpost){
                if(preg_match("/sugerida/",$llavepost)){
                    $materiasugerida = unserialize(stripcslashes($valorpost));
                    $numeromateriaselegidas++;
                    $materiasseleccionadas[] = $materiasugerida['codigomateria'];
                }
                if(preg_match("/obligatoria/",$llavepost)){
                    $materiaobligatoria = unserialize(stripcslashes($valorpost));
                    $numeromateriaselegidas++;
                    $materiasseleccionadas[] = $materiaobligatoria['codigomateria'];
                }
                if(preg_match("/grupopapa/",$llavepost)){
                    $llaveini = ereg_replace("grupopapa","",$llavepost);
                    $materiagrupo = unserialize(stripcslashes($valorpost));
                    $materiahija = unserialize(stripcslashes($_POST['grupohijo'.$llaveini.'']));
                    if($materiahija <> ""){
                        $materiasseleccionadas["grupo".$materiagrupo['codigomateria']] = $materiahija['codigomateria'];
                        end($materiasseleccionadas);
                        reset($materiasseleccionadas);
                        $numeromateriaselegidas++;
                    }else{
                        ?>
                        <script language="javascript">
                            alert("Debido a que selecciono ver un grupo, debe selecionar una materia del grupo deseado");
                            history.go(-1);
                        </script>
                        <?php
                    }//else
                }// if(preg_match("grupopapa",$llavepost))
                if(preg_match("/electoblig/",$llavepost)){
                    $materiaenfasis = unserialize(stripcslashes($valorpost));
                    $numeromateriaselegidas++;
                    $materiasseleccionadas[] = $materiaenfasis['codigomateria'];
                }
                if(preg_match("/electiva/",$llavepost)){
                    $materiaelectiva = unserialize(stripcslashes($valorpost));
                    $sumacredtitoselectivas = $sumacredtitoselectivas + $materiaelectiva['numerocreditos'];

                    $codigomateriaelectivapapa = false;
                    foreach ($materiasseleccionadas as $vava => $code){
                        if(preg_match("/grupo/",$vava)){
                            $query_selcreditosmateria = "select m.numerocreditos from materia m where m.codigomateria = '$vava'";
                            $selcreditosmateria=mysql_query($query_selcreditosmateria, $sala) or die("$query_selcreditosmateria");
                            $totalRows_selcreditosmateria = mysql_num_rows($selcreditosmateria);
                            $row_selcreditosmateria = mysql_fetch_array($selcreditosmateria);

                            if ($row_selcreditosmateria <> 4){
                                $codigomateriaelectivapapa = true;
                            }//if
                        }//if
                    }// foreach ($materiasseleccionadas as $vava => $code)

                    if ($codigomateriaelectivapapa){
                        $materiasseleccionadas["grupo".$materiaelectiva['codigomateria']] = $materiaelectiva['codigomateria'];
                    }else{
                        $materiasseleccionadas[] = $materiaelectiva['codigomateria'];
                    }//else
                }// if(preg_match("electiva",$llavepost))
                if(preg_match("/sinrestriccion/",$llavepost)){
                    $materiasinrestriccion = unserialize(stripcslashes($valorpost));
                    $materiasseleccionadas[] = $materiasinrestriccion['codigomateria'];
                    $numeromateriaselegidas = $numeromateriaschequeadas + 1;
                }
        }// foreach($_POST as $llavepost => $valorpost)

        $materiasserial = serialize($materiasseleccionadas);
        $cargaescogida = $materiasseleccionadas;

        if(isset($_POST['automatico'])||isset($_POST['manual']))
        {
                // Validar los corequisitos sencillos y dobles de las materias elegidas, con respecto a la carga generada
                // la carga generada es la que se imprime en la pantalla
                // Comparo la carga obligatoria con la carga escogida, tomando las materias diferentes
                // Si no se escoogen materias se devuelve
                // exit();
                if(!isset($cargaescogida)){
                    echo '<script language="javascript">
                    alert("Debe seleccionar materias para realizar la inscripción");
                    window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
                    </script>';
                }

                foreach($cargaescogida as $llavecarga => $codigomateriacarga)
                {
                    $query_materiascorequisito = "select distinct r.codigomateriareferenciaplanestudio, r.codigotiporeferenciaplanestudio ".
                    " from referenciaplanestudio r where r.idplanestudio = '$idplanestudioini' ".
                    " and r.codigomateria = '$codigomateriacarga' ".
                    " and r.codigotiporeferenciaplanestudio in (200,201) ".
                    " and r.codigoestadoreferenciaplanestudio = '101'";

                    $materiascorequisito=mysql_query($query_materiascorequisito, $sala) or die("$query_materiascorequisito");
                    $totalRows_materiascorequisito = mysql_num_rows($materiascorequisito);
                    $row_materiascorequisito = mysql_fetch_array($materiascorequisito);
                    $materiascorrequisitopsesion["materiapapa"][]=$codigomateriacarga;
                    $materiascorrequisitopsesion["materiahija"][]=$row_materiascorequisito["codigomateriareferenciaplanestudio"];
                    $materiascorrequisitopsesion["estado"][]=$row_materiascorequisito["codigotiporeferenciaplanestudio"];
                }// foreach($cargaescogida as $llavecarga => $codigomateriacarga)

                $_SESSION["materiascorrequisitosesion"]=$materiascorrequisitopsesion;

                // Validar la carga escogida
                $cargaValidar = $cargaescogida;
                require_once("validarcarga.php");

                if(is_array($cargaValidar))
                {
                    foreach($cargaValidar as $codigomateriaEscogida) :
                        //Valida co-requisitos dobles
                        if(faltaCorrequisitoDoble($codigomateriaEscogida, $cargaescogida))
                        {
                            echo '<script language="javascript">
                                    window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
                                </script>';
                        }
                        if(faltaCorrequisitoSencillo($codigomateriaEscogida, $cargaescogida))
                        {
                            echo '<script language="javascript">
                            window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
                            </script>';
                        }
                    endforeach;//foreach($cargaValidar as $codigomateriaEscogida)
                }

                $numerocreditos = 0;
                unset($yacontocreditos);
                foreach($cargaescogida as $llave2 => $codigomateria2)
                {
                    if(preg_match("/grupo/",$llave2))
                    {
                        $materiahijo = $codigomateria2;
                        $codigomateria2 = str_replace("grupo",null,$llave2);
                    }

                    $query_selcreditosmateria = "select m.numerocreditos from materia m where m.codigomateria = '$codigomateria2'";
                    $selcreditosmateria=mysql_query($query_selcreditosmateria, $sala) or die("$query_selcreditosmateria");
                    $totalRows_selcreditosmateria = mysql_num_rows($selcreditosmateria);
                    $row_selcreditosmateria = mysql_fetch_array($selcreditosmateria);

                    $yacontocreditos[$codigomateria2] =  $row_selcreditosmateria['numerocreditos'];
                    /**** valida que no selecciones dos veces la misma materia  ***/

                    $flagrepetida = false;
                    $flagmaterias = "";
                    foreach ($cargaescogida as $llave4 => $$codigomateria4)
                    {
                        if ($llave4 <> $llave2)
                        {
                            if ($codigomateria4 == $codigomateria2)
                            {
                                $flagmaterias = $codigomateria4;
                                $flagrepetida = true;
                            }
                        }
                    }//foreach
                }// foreach($cargaescogida as $llave2 => $codigomateria2)

                if (is_array($yacontocreditos))
                {
                    foreach($yacontocreditos as $llave3 => $codigocreditos)
                    {
                        $numerocreditos = $numerocreditos + $codigocreditos;
                    }
                }//if

                if ($flagrepetida)
                {
                    echo
                        '<script language="javascript">
                            alert("Ha seleccionado doble vez la misma materia");
                            window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
                        </script>';
                }

                $query_selcreditoscarrera = "select jc.numeromaximocreditosjornadacarrera as maximonumerocredito ".
                " from jornadacarrera jc ".
                " where jc.codigocarrera = '".$row_estudiante['codigocarrera']."' ".
                " and jc.codigojornada = '".$row_estudiante['codigojornada']."' ".
                " and ( NOW() between fechadesdejornadacarrera and fechahastajornadacarrera)";
                $selcreditoscarrera=mysql_query($query_selcreditoscarrera, $sala) or die("$query_selcreditoscarrera");
                $totalRows_selcreditoscarrera = mysql_num_rows($selcreditoscarrera);
                $row_selcreditoscarrera = mysql_fetch_array($selcreditoscarrera);
                $maximonumerocredito = $row_selcreditoscarrera['maximonumerocredito'];

                if($maximonumerocredito == "" || $maximonumerocredito == null){
                    $jornada = "DIURNA";
                    if($row_estudiante['codigojornada']!="01")
                    {
                        $jornada = "NOCTURNA";
                    }

                    echo
                        '<script language="javascript">
                            alert("No se ha definido el máximo número de créditos para este programa en la jornada actual del estudiante: '.$jornada.'");
                            window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
                        </script>';
                }
                else if($maximonumerocredito < $numerocreditos)
                {
                    echo
                        '<script language="javascript">
                            alert("El número de créditos seleccionados supera a '.$maximonumerocredito.' que es el máximo permitido, por lo tanto debe seleccionar menos materias");
                            window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
                        </script>';
                }

                if($numeromateriaselegidas == $numeromateriaschequeadas){
                    if($_REQUEST['automatico'])
                    {
                        echo
                            "<script language='javascript'>
                                window.location.href='asignahorarios/asignaautomaticahorarios.php?programausadopor=".$_GET['programausadopor']."&materiassinhorarios=$materiasserial&$enfasisget&lineaunica=".$_POST['lineaunica']."';
                            </script>";
                    }else{
                        echo "<script language='javascript'>
                            window.location.href='matriculaautomaticahorarios.php?programausadopor=".$_GET['programausadopor']."&materiassinhorarios=$materiasserial&$enfasisget&lineaunica=".$_POST['lineaunica']."';
                        </script>";
                    }
                }else{
                    echo "DOS: $enfasisget";
                    //exit();
                    if($_REQUEST['automatico'])
                    {
                        echo "<script language='javascript'>
                            window.location.href='asignahorarios/asignaautomaticahorarios.php?programausadopor=".$_GET['programausadopor']."&materiassinhorarios=$materiasserial&$enfasisget&lineaunica=".$_POST['lineaunica']."';
                        </script>";
                    }else{
                        echo "<script language='javascript'>
                            window.location.href='matriculaautomaticahorarios.php?programausadopor=".$_GET['programausadopor']."&materiassinhorarios=$materiasserial&$enfasisget&lineaunica=".$_POST['lineaunica']."';
                        </script>";
                    }
                    //Se dirige a los horarios donde un estudiante elige
                }
        }// if(isset($_POST['automatico'])||isset($_POST['manual']))
?>