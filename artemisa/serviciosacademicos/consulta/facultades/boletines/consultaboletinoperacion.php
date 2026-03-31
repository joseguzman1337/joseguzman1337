<?php
/*
 * Ivan Dario quintero Rios
 * Junio 13 del 2018
 * limpieza de codigo y organizacion de textos.
 */
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    $creditos=0;
    $indicadorhistorico =0 ;
    mysql_select_db($database_sala, $sala);
    if (isset($_GET['busqueda_codigo'])){
        //consulta los datos del estudiante por el codigo de estudiante
        $query_Recordset2 = "SELECT  eg.idestudiantegeneral, est.codigoestudiante, ".
        "concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, ".
        "c.nombrecarrera, eg.numerodocumento, est.codigoperiodo,est.codigocarrera ".
        "FROM estudiante est INNER JOIN estudiantegeneral eg on (est.idestudiantegeneral = eg.idestudiantegeneral) ".
        "INNER JOIN carrera c on (c.codigocarrera = est.codigocarrera) ".
        "WHERE  est.codigoestudiante = '$codigoestudiante'";               
	$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
	$row_Recordset2 = mysql_fetch_assoc($Recordset2);
	$totalRows_Recordset2 = mysql_num_rows($Recordset2);
	$facultad=$row_Recordset2['codigocarrera'];
    }else{        
        //consulta los datos del estudiante por el codigo de estudiante y periodo de la session
	$query_Recordset2 = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, ".
        "concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, ".
        "c.nombrecarrera, eg.numerodocumento, est.codigoperiodo,est.codigocarrera  ".
        "FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, documento d, carrera c ".
        "WHERE ed.numerodocumento LIKE '$codigoestudiante%' ".
        "and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."' ".
        "and eg.idestudiantegeneral = est.idestudiantegeneral ".
        "and ed.idestudiantegeneral = eg.idestudiantegeneral ".
        "and c.codigocarrera = est.codigocarrera ".
        "and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."' ".
        "and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."' ".
        "ORDER BY 3, est.codigoperiodo";
	$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
	$row_Recordset2 = mysql_fetch_assoc($Recordset2);
	$totalRows_Recordset2 = mysql_num_rows($Recordset2);
	$facultad=$row_Recordset2['codigocarrera'];
    }

    unset($codigoestudiante);
    if ($row_Recordset2){
        $codigoestudiante = $row_Recordset2['codigoestudiante'];
    }
 
    //consulta el estado del periodo para la carrera
    $query_Recordset2 = "SELECT p.codigoestadoprocesoperiodo,p.codigocarrera ".
    "FROM procesoperiodo p INNER JOIN estudiante e on e.codigocarrera=p.codigocarrera ".
    "WHERE e.codigoestudiante='$codigoestudiante' AND p.codigoperiodo='".$periodoactual."' ";
    $Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
    $row_proceso = mysql_fetch_assoc($Recordset2);
    $yacerro = false;

    if($row_proceso["codigoestadoprocesoperiodo"]==200){
        $yacerro = true;
    }
    //require('calculopromedioacumulado.php');

    //consulta las materias del estudiante para el periodo especifico
    $query_Recordset1 = "SELECT m.nombremateria, m.codigomateria, ".
    "d.codigomateriaelectiva, m.numerocreditos, g.idgrupo, ".
    "p.codigoestudiante ".
    "FROM detalleprematricula d ".
    "INNER JOIN prematricula p on (d.idprematricula = p.idprematricula ) ".
    "INNER JOIN materia m on (d.codigomateria = m.codigomateria)  ".
    "INNER JOIN grupo g on (d.idgrupo = g.idgrupo) ".
    "WHERE  p.codigoestudiante = '".$codigoestudiante."' ".
    "AND m.codigoestadomateria = '01' ".
    "AND g.codigoperiodo = '".$periodoactual."' ".
    "AND p.codigoestadoprematricula in (40, 41, 42) ".
    "AND d.codigoestadodetalleprematricula = 30";    
    $Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysql_num_rows($Recordset1);
    
    //consulta los datos del pie de pagia para los datos de la universdiad
    $query_universidad = "SELECT direccionuniversidad, c.nombreciudad, ".
    "p.nombrepais, u.paginawebuniversidad, u.imagenlogouniversidad, ".
    "u.telefonouniversidad, u.faxuniversidad, u.nituniversidad, ".
    "u.personeriauniversidad, u.entidadrigeuniversidad ".
    "FROM universidad u ".
    "INNER JOIN ciudad c on (u.idciudad = c.idciudad) ".
    "INNER JOIN departamento d on (c.iddepartamento = d.iddepartamento) ".
    "INNER JOIN pais p on (d.idpais = p.idpais) WHERE u.iduniversidad = 1;";    
    $universidad = mysql_query($query_universidad, $sala) or die(mysql_error());
    $row_universidad = mysql_fetch_assoc($universidad);
    $totalRows_universidad = mysql_num_rows($universidad);
?>
<html>
    <head>
        <title>Documento sin t&iacute;tulo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style type="text/css">
            <!--
            .Estilo1 {font-family: Tahoma; font-size: 10px}
            .Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
            .Estilo5 {font-family: Tahoma; font-size: 12px; }
            -->
        </style>
        <script language="JavaScript" type="text/JavaScript">
            <!--
                function MM_jumpMenu(targ,selObj,restore){ //v3.0
                  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
                  if (restore) selObj.selectedIndex=0;
                }

            //-->
        </script>
    </head>
    <body>
        <form name="form1" method="post" action="consultanotassala.php">
            <table width="600" border="0" align="center">
                <tr>
                    <td>
                        <div align="center">
                            <img src="<?php echo $row_universidad['imagenlogouniversidad'];?>" width="200" height="62" onClick="print()"><br>
                            <span class="Estilo5"><?php echo $row_universidad['personeriauniversidad'];?><br>
                                <?php echo $row_universidad['entidadrigeuniversidad'];?><br><?php echo $row_universidad['nituniversidad'];?>
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
            <p>&nbsp;</p>
            <table width="600"  border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
                <tr>
                    <td colspan="10" align="center" class="Estilo2"><?php echo $row_Recordset2['nombre']; ?></td>
                    <td colspan="2" align="center" class="Estilo2">Documento</td>
                    <td colspan="3" align="center" class="Estilo5"><?php echo $row_Recordset2['numerodocumento']; ?></td>
                </tr>
                <tr>
                    <td colspan="6"><span class="Estilo2">&nbsp;Programa: </span>&nbsp;&nbsp;<span class="Estilo5"><?php echo $row_Recordset2['nombrecarrera']; ?></span></td>
                    <td colspan="2" align="center" class="Estilo2">Periodo</td>
                    <td colspan="2" align="center" class="Estilo5"><?php echo $periodoactual; ?>&nbsp;</td>
                    <td colspan="2" align="center" class="Estilo2">Fecha</td>
                    <td colspan="3" align="center" class="Estilo5"><?php echo date("j/m/Y",time());?>&nbsp;</td>
                </tr>
                <?php
                $ultimocorte = 0;
                if ($row_Recordset1 <> ""){// if1 
                    ?>
                    <tr>
                    <?php 
                    $promedio=0;
                    $guardaidgrupo[]=0;
                    $g = 0;
                    $banderaimprime = 0;
                    $numerocreditos = 0;

                    //consulta de materias y creditos del estudiante para cierto periodo
                    $query_Recordset9 = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante ".
                    "from prematricula p INNER JOIN detalleprematricula d on (p.idprematricula = d.idprematricula) ".
                    "INNER JOIN materia m on (d.codigomateria = m.codigomateria) ".
                    "INNER JOIN grupo g on (d.idgrupo = g.idgrupo) ".
                    "WHERE  p.codigoestudiante = '".$codigoestudiante."' ".
                    "AND m.codigoestadomateria = '01' ".
                    "AND g.codigoperiodo = '".$periodoactual."' ".
                    "AND p.codigoestadoprematricula in (40, 41, 42) ".
                    "AND d.codigoestadodetalleprematricula = 30";                                
                    $Recordset9 = mysql_query($query_Recordset9, $sala) or die(mysql_error());
                    $row_Recordset9 = mysql_fetch_assoc($Recordset9);
                    $totalRows_Recordset9 = mysql_num_rows($Recordset9);

                    do{
                        //consulta el numero de cortes por materia
                        $query_fecha ="SELECT c.numerocorte FROM corte c WHERE c.codigomateria = '".$row_Recordset9['codigomateria']."' ".
                        " AND c.codigoperiodo = '".$periodoactual."'";                    
                        $fecha = mysql_query($query_fecha,$sala) or die(mysql_error());
                        $row_fecha = mysql_fetch_assoc($fecha);
                        $totalRows_fecha = mysql_num_rows($fecha);
                        $i= 1;
                        $contadorcortes = 0;
                        if ($totalRows_fecha <> 0){
                            do {
                                $contadorcortes +=1;
                            } while ($row_fecha = mysql_fetch_assoc($fecha));
                        }else{
                            if ($totalRows_fecha==0){
                                //consulta los cortes genericos para la carrera                            
                                $query_fecha = "SELECT * FROM corte
                                WHERE codigocarrera = '".$facultad."'
                                and codigoperiodo = '".$periodoactual."'
                                order by numerocorte";                         
                                $fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
                                $row_fecha = mysql_fetch_assoc($fecha);
                                $totalRows_fecha = mysql_num_rows($fecha);
                                do {
                                    $contadorcortes +=1;
                                } while ($row_fecha = mysql_fetch_assoc($fecha));
                            }//if
                        }//else

                        if ($totalRows_fecha==0){
                            $contadorcortes = 0;
                            //
                            $query_fecha = "SELECT distinct numerocorte
                            FROM detallenota,materia,corte
                            WHERE  materia.codigoestadomateria = '01'
                            AND detallenota.codigomateria=materia.codigomateria
                            AND detallenota.idcorte=corte.idcorte
                            AND detallenota.codigoestudiante = '".$codigoestudiante."'
                            AND detallenota.codigomateria = '".$row_Recordset9['codigomateria']."'
                            AND corte.codigoperiodo = '".$periodoactual."'";                        
                            $fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
                            $row_fecha = mysql_fetch_assoc($fecha);
                            $totalRows_fecha = mysql_num_rows($fecha);

                            do {
                                $contadorcortes +=1;
                            } while ($row_fecha = mysql_fetch_assoc($fecha));
                        }//if		

                        if ($ultimocorte < $contadorcortes){
                            $ultimocorte = $contadorcortes;
                        }		
                    } while ($row_Recordset9 = mysql_fetch_assoc($Recordset9));

                    do {
                        if ($banderaimprime == 0){
                            echo "<td colspan='1' align='center' class='Estilo2'>C&oacute;digo</td>";
                            echo "<td colspan='1' align='center' class='Estilo2'>Nombre Asignatura</td>";
                            echo "<td colspan='1' align='center' class='Estilo2'>Cr</td>";
                            for ($i=1;$i<=$ultimocorte;$i++){
                                echo "<td colspan='1' align='center' class='Estilo2'>C".$i."</td>";
                                echo "<td colspan='1' align='center' class='Estilo2'>%</td>";
                            }
                            echo "<td colspan='1' align='center' class='Estilo2'>T%</td>";
                            echo "<td colspan='1' align='center' class='Estilo2'>DEF</td>";
                            echo "<td colspan='1' align='center' class='Estilo2'>R</td>";
                            echo "<td colspan='1' align='center' class='Estilo2'>LETRAS</td>";
                            echo "<td colspan='1' align='center' class='Estilo2'>FT</td>";
                            echo "<td colspan='1' align='center' class='Estilo2'>FP</td>";
                            echo "</tr>";
                            $banderaimprime = 1;
                        }//if
                        ////////////////////////

                        $contador= 1;
                        $mostrarpapa = "";                    
                        //consulta las notas por corte, por materia y por periodo para el estudiante
                        $query_Recordset8 ="SELECT dn.*, m.nombremateria, m.numerocreditos, g.codigomateria, ".
                        "c.porcentajecorte FROM detallenota dn ".
                        "INNER JOIN grupo g on (dn.idgrupo = g.idgrupo) ".
                        "INNER JOIN materia m on (m.codigomateria = g.codigomateria) ".
                        "INNER JOIN corte c on (dn.idcorte = c.idcorte) ".
                        "WHERE m.codigoestadomateria  = '01' ".
                        "AND dn.codigoestudiante = '".$codigoestudiante."' ".
                        "AND dn.codigomateria = '".$row_Recordset1['codigomateria']."' ".
                        "AND dn.codigoestado = '100' AND g.codigoperiodo = '".$periodoactual."' ORDER BY c.numerocorte";                           
                        $Recordset8 = mysql_query($query_Recordset8, $sala) or die(mysql_error());
                        $row_Recordset8 = mysql_fetch_assoc($Recordset8);
                        $totalRows_Recordset8 = mysql_num_rows($Recordset8);	

                        if($row_Recordset1['codigomateriaelectiva'] != 0){
                            //consulta los datos de la materia 
                            $query_materiaelectiva = "SELECT * FROM materia 
                            WHERE codigoindicadoretiquetamateria LIKE '1%'
                            and codigomateria = ".$row_Recordset1['codigomateriaelectiva']."";                        
                            $row_Recordset1['codigomateria']." as ".$query_materiaelectiva;
                            $materiaelectiva = mysql_query($query_materiaelectiva, $sala) or die(mysql_error());
                            $row_materiaelectiva = mysql_fetch_assoc($materiaelectiva);
                            $totalRows_materiaelectiva = mysql_num_rows($materiaelectiva);

                            if($totalRows_materiaelectiva != ""){
                                
                                $row_Recordset1['codigomateria']  = $row_materiaelectiva['codigomateria'];
                                $row_Recordset1['nombremateria']  = $row_materiaelectiva['nombremateria'];
                                $row_Recordset1['numerocreditos'] = $row_materiaelectiva['numerocreditos'];
                                // Toca definir como hacer con el calculo de creditos (Se hace con el papa o con el hijo)
                                //$solicitud_historico['codigoindicadorcredito'] = $row_materiaelectiva['codigoindicadorcredito'];
                            }else{
                                //consulat el nombre de la materia 
                                $query_materiaelectiva1 = "SELECT nombremateria FROM materia ".
                                "WHERE codigomateria = ".$row_Recordset1['codigomateriaelectiva']."";
                                $materiaelectiva1 = mysql_query($query_materiaelectiva1, $sala) or die(mysql_error());
                                $row_materiaelectiva1 = mysql_fetch_assoc($materiaelectiva1);
                                $totalRows_materiaelectiva1 = mysql_num_rows($materiaelectiva1);
                                $mostrarpapa = $row_materiaelectiva1['nombremateria'];
                            }
                        }//if

                        if($row_PeriodoActivo==""){
                            //consulta la nota de la materia definitiva para la materia del estudiante
                            $query_notagrabada = "select notadefinitiva,codigomateriaelectiva,m.nombremateria ".
                            "from notahistorico nh ".
                            "left join materia m on nh.codigomateriaelectiva=m.codigomateria  ".
                            "where codigoestudiante = '".$codigoestudiante."' ".
                            "and nh.codigomateria = '".$row_Recordset1['codigomateria']."' ".
                            "and nh.codigoperiodo = '".$periodoactual."' ".
                            "AND codigoestadonotahistorico = '100' ".
                            "AND codigotiponotahistorico in ('100', '200')";                                  
                            $notagrabada = mysql_query($query_notagrabada, $sala) or die(mysql_error());
                            $row_notagrabada= mysql_fetch_assoc($notagrabada);

                            if($row_notagrabada["codigomateriaelectiva"]!=1 && $row_notagrabada["codigomateriaelectiva"]!=null && $row_notagrabada <> ""){
                                $mostrarpapa = $row_notagrabada['nombremateria'];
                            }else{
                                //consulta la modalidad academica de la carrera
                                $sqlmodalida = "select codigomodalidadacademica from carrera where codigocarrera = '".$facultad."'";                            
                                $valoresmodalidad = mysql_query($sqlmodalida, $sala) or die(mysql_error());
                                $valores = mysql_fetch_assoc($valoresmodalidad);

                                $modalidad = $valores['codigomodalidadacademica'];    
                                if($modalidad == '400' || $modalidad == '200' || $modalidad == '300'){
                                    $row_notagrabada= 1;    
                                }
                            }//else
                        }else{	   
                            $row_notagrabada = 1;
                        }

                        $row_historico2 = verificarHistoricoMateria($sala,$codigoestudiante,$periodoactual,$row_Recordset1['codigomateria']);	  
                        if($row_notagrabada <> "" && !$row_historico2){
                            ?>
                            <tr>
                                <td colspan="1" class="Estilo1" align="center"><?php echo $row_Recordset1['codigomateria'];?></td>
                                <td colspan="1" class="Estilo1"><?php if ($mostrarpapa <> "") echo "<strong>$mostrarpapa</strong> /  "; echo $row_Recordset1['nombremateria']; ?></td>
                                <td colspan="1" class="Estilo1" align="center"><?php echo $row_Recordset1['numerocreditos'];
                                    $numerocreditos = $numerocreditos + $row_Recordset1['numerocreditos'];?>&nbsp;
                                </td>
                                <?php
                                $habilitacion = 0;
                                $notafinal = 0;
                                $porcentajefinal = 0;
                                $fallasteoricasperdidas = 0;
                                $fallaspracticasperdidas = 0;
                                $banderafallas = "";
                                $contadorfallas = 0;
                                $cols=$ultimocorte * 2;
                                do{
                                    if ($row_Recordset8['codigotiponota'] == 10){
                                        // Valida si l aperdida es por fallas.
                                        $query_perdidafallas = "SELECT  *
                                        FROM notahistorico
                                        WHERE codigoestudiante = '".$codigoestudiante."'
                                        AND codigoperiodo = '".$periodoactual."'
                                        AND codigomateria = '".$row_Recordset1['codigomateria']."'
                                        AND codigotiponotahistorico = '102'
                                        AND codigoestadonotahistorico like '1%'";             
                                        $perdidafallas = mysql_query($query_perdidafallas, $sala) or die(mysql_error());
                                        $row_perdidafallas = mysql_fetch_assoc($perdidafallas);
                                        $totalRows_perdidafallas = mysql_num_rows($perdidafallas);

                                        if ($row_perdidafallas <> ""){
                                            $banderafallas = "MATERIA PERDIDA POR FALLAS";
                                            if ($contadorfallas == 0){
                                                echo "<td class='Estilo1' align='center' colspan= '$cols'>$banderafallas</td>";
                                            }
                                            $contadorfallas++;
                                        }else{
                                            $query_historico = "SELECT  * FROM notahistorico
                                            WHERE codigoestudiante = '".$codigoestudiante."'
                                            AND codigoperiodo = '".$periodoactual."'
                                            AND codigomateria = '".$row_Recordset1['codigomateria']."'
                                            AND codigoestadonotahistorico LIKE '1%'
                                            AND codigotiponotahistorico <> 100";
                                            $historico = mysql_query($query_historico, $sala) or die(mysql_error());
                                            $row_historico = mysql_fetch_assoc($historico);			  
                                            $totalRows_historico = mysql_num_rows($historico);

                                            if (!$row_historico){		          
                                                if($row_Recordset8['codigoestado']==100){
                                                    echo "<td class='Estilo1' align='center'>".$row_Recordset8['nota']."&nbsp;</td>";
                                                }else{
                                                    echo "<td class='Estilo1' align='center'>&nbsp;</td>";
                                                }
                                            }else{
                                                echo "<td class='Estilo1' align='center'>&nbsp;</td>";
                                            }
                                        }//else
                                        if (!$row_historico ){
                                            if ( !$banderafallas){
                                                if($row_Recordset8['codigoestado']==100){
                                                    echo "<td class='Estilo1' align='center'>".$row_Recordset8['porcentajecorte']."%&nbsp;</td>";
                                                }else{
                                                    echo "<td class='Estilo1' align='center'>&nbsp;</td>";
                                                }
                                            }
                                        }else{
                                            echo "<td class='Estilo1' align='center'>&nbsp;</td>";
                                        }
                                        if($row_Recordset8['codigoestado']==100){
                                            $notafinal = $notafinal + ($row_Recordset8['nota'] * $row_Recordset8['porcentajecorte'])/100;
                                            $porcentajefinal = $porcentajefinal + $row_Recordset8['porcentajecorte'];
                                            $fallasteoricasperdidas = $fallasteoricasperdidas + $row_Recordset8['numerofallasteoria'];
                                            $fallaspracticasperdidas = $fallaspracticasperdidas + $row_Recordset8['numerofallaspractica'];
                                            $contador++;
                                        }
                                    }else{
                                        if ($row_Recordset8['codigotiponota'] == 20){
                                            $habilitacion = $row_Recordset8['nota'];
                                        }else{
                                            //si la nota no es tipo 10 o tipo 20 se verifica si existe una nota en el historico activa.
                                            $sqlhistoriconotas= "select * from notahistorico where codigoestudiante = '".$codigoestudiante."' 
                                            and codigoperiodo = '".$periodoactual."' and codigomateria = '".$row_Recordset1['codigomateria']."' and codigoestadonotahistorico = '100'";
                                            $historiconota = mysql_query($sqlhistoriconotas, $sala) or die(mysql_error());
                                            $row_historiconota = mysql_fetch_assoc($historiconota);
                                            $porcentajefinal = '100';
                                        }
                                    }
                                } while ($row_Recordset8 = mysql_fetch_assoc($Recordset8));

                                if($porcentajefinal <> 0){
                                    $creditosnota = (number_format($notafinal/($porcentajefinal/100),1)) * $row_Recordset1['numerocreditos'];
                                    $promedio =  $promedio + $creditosnota;
                                    $suma = $ultimocorte - $contador;
                                    for ($i=0;$i<=$suma;$i++){
                                        echo "<td class='Estilo1' align='center'>&nbsp;</td>";
                                        echo "<td class='Estilo1' align='center'>&nbsp;</td>";
                                    }
                                }

                                $notafinal = redondeo($notafinal);

                                if ($porcentajefinal <> 0){
                                    if ( !$banderafallas){
                                        $total =  $notafinal ;
                                    }else{
                                        $total =  substr($row_perdidafallas['notadefinitiva'],0,3);
                                    }
                                    if (!$row_historico){
                                        echo "<td colspan='1' class='Estilo1' align='center'>".$porcentajefinal."%&nbsp;</td>";
                                    }else{
                                        echo "<td colspan='1' class='Estilo1' align='center'>&nbsp;</td>";
                                    }
                                    if (!$row_historico){
                                        $query_notagrabada = "select notadefinitiva from notahistorico where codigoestudiante = '".$codigoestudiante."'
                                        and codigomateria = '".$row_Recordset1['codigomateria']."' and codigoperiodo = '".$periodoactual."' and codigotiponotahistorico = '100'
                                        AND codigoestadonotahistorico LIKE '1%'";
                                        $notagrabada = mysql_query($query_notagrabada, $sala) or die(mysql_error());
                                        $row_notagrabada= mysql_fetch_assoc($notagrabada);
                                        $totalRows_notagrabada= mysql_num_rows($notagrabada);

                                        if($row_notagrabada <> ""){
                                            $total1 = substr($row_notagrabada['notadefinitiva'],0,3);
                                            $indicadorhistorico = 1;
                                            $resultadodatos= 1;
                                        }
                                    }

                                    if($total1 == ""){
                                        if ($row_historiconota <> ""){
                                            echo "<td colspan='1' class='Estilo2' align='center'>&nbsp;</td>";
                                            $recuperacion = number_format ($row_historiconota['notadefinitiva'],1);
                                            echo "<td colspan='1' class='Estilo2' align='center'>".$recuperacion."&nbsp;</td>";
                                            $total=$recuperacion;			
                                        }else{
                                            echo "<td colspan='1' class='Estilo2' align='center'>".$total."&nbsp;</td>";
                                            echo "<td colspan='1' class='Estilo2' align='center'>&nbsp;</td>";
                                        } 
                                    }else{
                                        echo "<td colspan='1' class='Estilo2' align='center'>".$total1."&nbsp;</td>";
                                        $total = $total1;
                                        echo "<td colspan='1' class='Estilo2' align='center'>&nbsp;</td>";
                                    }

                                    $numero =  substr($total,0,1);
                                    $numero2 = substr($total,2,2);       
                                    require('convertirnumeros.php');
                                }
                                echo "<td colspan='1' class='Estilo1' >".$numu." ".$numu2."&nbsp;</td>";
                                echo "<td class='Estilo1' align='center'>".$fallasteoricasperdidas."&nbsp;</td>";
                                echo "<td class='Estilo1' align='center'>".$fallaspracticasperdidas."&nbsp;</td>";
                                unset($numu);
                                unset($numu2);
                                unset($total1);
                                unset($total);
                                echo "</tr>";
                            }//if
                            $g++;
                        } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                        <tr class="Estilo2">
                            <td height="25" colspan="7"><div align="center">
                                Promedio Ponderado Acumulado: 
                                <?php
                                $promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado']="",$sala);
                                echo $promedioacumulado;
                                ?>
                                </div>
                            </td>
                            <td colspan="20">
                                <div align="center">Promedio Ponderado Semestral:&nbsp;
                                <?php
    //////////////////////////////////////////////////////////////  calculo promedio periodo ///////////////////////
                                if($indicadorhistorico == 1){
                                    $query_selperiodos = "SELECT distinct codigoperiodo
                                    from notahistorico where codigoestudiante = '$codigoestudiante' order by 1";
                                    $selperiodos = mysql_query($query_selperiodos, $sala) or die("$query_selperiodos".mysql_error());
                                    $total_selperiodos = mysql_num_rows($selperiodos);
                                    $_GET['totalperiodos'] = $total_selperiodos;
                                    $estei = 1;
                                    while($row_selperiodos = mysql_fetch_assoc($selperiodos)){
                                        $_GET["periodo".$estei] = $row_selperiodos['codigoperiodo'];
                                        $estei++;
                                    }
                                    // Tomo todas las materias que vio el estudiante con su nota y las coloco en un arreglo por periodo
                                    $query_materiashistorico = "select n.codigomateria, n.notadefinitiva, case n.notadefinitiva > '5'
                                    when 0 then n.notadefinitiva
                                    when 1 then n.notadefinitiva / 100
                                    end as nota, n.codigoperiodo, m.nombremateria
                                    from notahistorico n, materia m
                                    where n.codigoestudiante = '$codigoestudiante'
                                    and n.codigomateria = m.codigomateria
                                    AND codigoestadonotahistorico LIKE '1%'
                                    order by 5, 3 ";

                                    $materiashistorico = mysql_query($query_materiashistorico, $sala) or die(mysql_error());
                                    $totalRows_materiashistorico = mysql_num_rows($materiashistorico);
                                    $cadenamateria = "";
                                    while($row_materiashistorico = mysql_fetch_assoc($materiashistorico)){
                                        // Coloco las materias equivalentes del estudiante en un arreglo y selecciono
                                        // la mayor de esas notas, con el codigo de la materia mayor.
                                        // Arreglo de las materias con las mejores notas del estudiante
                                        if($materiapapaito = seleccionarequivalenciapapa($row_materiashistorico['codigomateria'],$codigoestudiante,$sala)){
                                            //echo "PAPA ".$row_materiashistorico['codigomateria']." $materiapapaito<br>";
                                            $formato = " n.codigomateria = ";
                                            // Con la materia papa selecciono las equivalencias y miro si estan en estudiante, y selecciono la mayor nota con su codigo
                                            // $Cad_equivalencias = seleccionarequivalenciascadena($materiapapaito, $codigoestudiante, $formato, $sala)."<br>";
                                            // $Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
                                            //echo "$Cad_equivalencias<br>";
                                            // exit();
                                            $row_mejornota =  seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
                                            //echo "<br><br>".seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
                                            $Array_materiashistorico[$row_mejornota['codigomateria']] = seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
                                            //echo "<br>materia: ".$row_mejornota['codigomateria']." nota ".$row_mejornota['nota']."<br>";
                                        }else{
                                            $Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
                                        }
                                    }	
                                    $Array_materiashistoricoinicial = $Array_materiashistorico;
                                    // Del arreglo que forme anteriormente debo quitar las equivalencias con menor nota
                                    // Para esto primero creo un arreglo con las equivalencias de cada materia        
                                    foreach($Array_materiashistorico as $codigomateria => $row_materia){		
                                        $otranota = $row_materia['nota']*100;
                                        // Arreglo bidimensional con las materias en cada periodo
                                        $cadenamateria = "$cadenamateria (n.codigomateria = '".$row_materia['codigomateria']."' and (n.notadefinitiva = '".$row_materia['nota']."' or n.notadefinitiva = '$otranota')) or";
                                        $Array_materiasperiodo[$row_materia['codigoperiodo']][] = $row_materia;
                                    }
                                    $cadenamateria = $cadenamateria."fin";
                                    $cadenamateria = ereg_replace("orfin","",$cadenamateria);
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                    // $periodosemestral = $periodoactual;
                                    // require('calculopromediosemestralmacheteado.php');
                                    //$promediosemestralperiodo = PeriodoSemestralReglamento ($codigoestudiante,$periodoactual,$cadenamateria,$_GET['tipocertificado']="",$sala, 1);
                                    $promediosemestralperiodo =PeriodoSemestralTodo($codigoestudiante,$periodoactual,$_GET['tipocertificado']="",$sala, 1);
                                    echo $promediosemestralperiodo;
                                }//if
                                ?>
                                </div>
                            </td>
                        </tr>
                        <tr class="Estilo2">
                            <td><div align="center">Cr: Cr&eacute;ditos</div></td>
                            <td><div align="center">R: Modificaci&oacute;n<br></div></td>
                            <td colspan="2"><div align="center">C: Corte</div></td>
                            <td colspan="3"><div align="center">T%:Porcentaje total</div></td>
                            <td colspan="3"><div align="center">FT:Fallas te&oacute;ricas</div></td>
                            <td colspan="2"><div align="center">FP:Fallas pr&aacute;cticas</div></td>
                            <td colspan="3"><div align="center">DEF: Definitiva</div></td>
                        </tr>
                        <tr>
                            <td  colspan="20"><div align="center" class="Estilo5">
                                <p align="justify">
                                <?php   
                                if ($_GET['tipodetalleseguimiento'] == 100){
                                    $query_sel_seguimiento= "SELECT DISTINCT descripciondetalleseguimientoacademico
                                    FROM seguimientoacademico sa,detalleseguimientoacademico dsa,tipodetalleseguimiento tdsa
                                    WHERE sa.idseguimientoacademico = dsa.idseguimientoacademico
                                    AND dsa.codigotipodetalleseguimientoacademico = tdsa.codigotipodetalleseguimiento
                                    AND notadesdedetalleseguimientoacademico <= '$promediosemestralperiodo'
                                    AND notahastadetalleseguimientoacademico >= '$promediosemestralperiodo'
                                    AND sa.codigoestado LIKE '1%'
                                    AND dsa.codigoestado LIKE '1%'
                                    AND tdsa.codigoestado LIKE '1%'
                                    AND sa.codigocarrera = '$facultad'
                                    and sa.codigoperiodo = '$periodoactual'
                                    AND codigotipodetalleseguimientoacademico = '".$_GET['tipodetalleseguimiento']."'";			
                                    $sel_seguimiento = mysql_query($query_sel_seguimiento, $sala) or die(mysql_error());
                                    $row_sel_seguimiento = mysql_fetch_assoc($sel_seguimiento);
                                    $totalRows_sel_seguimiento = mysql_num_rows($sel_seguimiento);
                                }else{
                                    if ($_GET['tipodetalleseguimiento'] == 200){
                                        $query_sel_seguimiento= " SELECT DISTINCT descripciondetalleseguimientoacademico
                                        FROM seguimientoacademico sa,detalleseguimientoacademico dsa,tipodetalleseguimiento tdsa
                                        WHERE sa.idseguimientoacademico = dsa.idseguimientoacademico
                                        AND dsa.codigotipodetalleseguimientoacademico = tdsa.codigotipodetalleseguimiento
                                        AND notadesdedetalleseguimientoacademico <= '$promedioacumulado'
                                        AND notahastadetalleseguimientoacademico >= '$promedioacumulado'
                                        AND sa.codigoestado LIKE '1%'
                                        AND dsa.codigoestado LIKE '1%'
                                        AND tdsa.codigoestado LIKE '1%'
                                        AND sa.codigocarrera = '$facultad'
                                        and sa.codigoperiodo = '$periodoactual'
                                        AND codigotipodetalleseguimientoacademico = '".$_GET['tipodetalleseguimiento']."'";                                    
                                        $sel_seguimiento = mysql_query($query_sel_seguimiento, $sala) or die(mysql_error());
                                        $row_sel_seguimiento = mysql_fetch_assoc($sel_seguimiento);
                                        $totalRows_sel_seguimiento = mysql_num_rows($sel_seguimiento);
                                    }
                                }
                                if ($row_sel_seguimiento <> ""){
                                    echo $row_sel_seguimiento['descripciondetalleseguimientoacademico'];		   
                                }else{
                                    echo "<br><br><br><br><br>";
                                }
                                ?>
                                <p>
                                <table>
                                    <tr>
                                        <?php
                                        $contador = 0;
                                        do{
                                            ?>
                                            <td>
                                                <span class="Estilo2">____________________________<br>
                                                <a style='cursor: pointer' onClick="window.location.href='../../prematricula/matriculaautomaticaordenmatricula.php?programausadopor=facultad'"><?php echo $row_responsable['nombresdirectivo'],"&nbsp;",$row_responsable['apellidosdirectivo'];?><br>
                                                <?php echo $row_responsable['cargodirectivo'];?></a></span></p>
                                            </td>
                                            <?php
                                            if ($totalRows_responsable > 1 and $contador == 0){
                                                ?>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <?php
                                                $contador = 1;
                                            }
                                        } while($row_responsable = mysql_fetch_assoc($responsable));
                                        ?>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
            </table>
        </form>
    </body>
</html>
<?php
}//if 1
mysql_free_result($Recordset2);
?>