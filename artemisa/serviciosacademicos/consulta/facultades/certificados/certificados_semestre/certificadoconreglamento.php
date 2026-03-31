<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php');
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
	ksort  ($Array_materiasperiodo);
	ksort  ($Array_materiassinsemestre);
    mysql_select_db($database_sala, $sala);
    
    require_once('../nombrePromedio.php');

	$query_historico = "SELECT 	c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,eg.numerodocumento,
	eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,e.codigoestudiante,
	doc.nombredocumento,e.codigotipoestudiante,e.codigocarrera, e.codigosituacioncarreraestudiante,codigomodalidadacademica
	FROM estudiante e,carrera c,titulo ti,documento doc,estudiantegeneral eg
	WHERE e.idestudiantegeneral = eg.idestudiantegeneral
	and e.codigoestudiante = '".$codigoestudiante."'
	AND eg.tipodocumento = doc.tipodocumento
	AND e.codigocarrera = c.codigocarrera
	AND c.codigotitulo = ti.codigotitulo";	
	$res_historico = mysql_query($query_historico, $sala) or die(mysql_error());
	$solicitud_historico = mysql_fetch_assoc($res_historico);
	$carreraestudiante = $solicitud_historico['codigocarrera'];
	$moda = $solicitud_historico['codigomodalidadacademica'];
	if($solicitud_historico <> "") 	{// if 1
            if($solicitud_historico['codigosituacioncarreraestudiante'] == 400) $graduadoegresado = true;
            if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400 and $row_tipousuario['codigotipousuariofacultad'] == 100 and !isset($_GET['consulta'])){
                echo '<script language="JavaScript">alert("Este estudiante es Graduado, por lo que el certificado se expide en Secretaria General")</script>';
                echo '<script language="JavaScript">history.go(-1)</script>';
            }
            $html.='<form name="form1" method="post" action="">';
            $html.='<table width="80%"  border="0" align="center" cellpadding="0">';
            $html.='<tr>';
            if(!isset($_GET['periodos'])){
                $html.='<td colspan="7"><div align="center" class="Estilo1 Estilo2">';
                $html.='<p><span class="Estilo3">';
                if($row_tipousuario['codigotipousuariofacultad'] == 200){
                    $html.="$suscrito_secretario $cargodirectivosecretario</span><br>";                                          
                    /*
                     * Se quita la palabra Vigilada Mineducación
                     * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                     * Universidad el Bosque - Direccion de Tecnologia.
                     * Modificado 9 de Mayo de 2018.
                     */
                    $html.='En cumplimiento de lo dispuesto en el literal d) del art&iacute;culo 21 del Reglamento General de la Universidad</p>';
                    //end
                }else {
                    $html.='<span class="Estilo4"><strong><a class="Estilo4"style="cursor: pointer" ';
                    $html.="\"window.location.reload('../../prematricula/matriculaautomaticaordenmatricula.php?programausadopor=facultad')\">EL SUSCRITO</a></strong></span></span><br>";
                    $html.='En cumplimiento de lo dispuesto en el literal h) del art&iacute;culo 29 del Reglamento General de la Universidad<br>Vigilada Mineducaci&oacute;n</p>';
                }
                $html.='<p class="Estilo3">HACE CONSTAR:</p>';
				
                /*
				 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
				 * Por solicitud de Consuelo Martinez se modifica el texto para que quede de la forma :
				 * Después de la ciudad de Expedición del documento debe ir una coma (,) y las palabras cursó y aprobó.
				 * @since  Febrero 28, 2017
				*/
                $html.='<p align="justify">Que <strong>'.$solicitud_historico['nombresestudiantegeneral'].'&nbsp;'.$solicitud_historico['apellidosestudiantegeneral'].'</strong>, identificado(a) con '.$solicitud_historico['nombredocumento'];
                $html.=' No. '.$solicitud_historico['numerodocumento'].' de '.$solicitud_historico['expedidodocumento'].', ';
                /* FIN MODIFICACION */
                if ($solicitud_historico['codigosituacioncarreraestudiante'] == 400 and $row_tipousuario['codigotipousuariofacultad'] == 200){
                    /*
					 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
					 * Por solicitud de Consuelo Martinez se modifica el texto para que quede de la forma :
					 * Después de la ciudad de Expedición del documento debe ir una coma (,) y las palabras cursó y aprobó.
					 * @since  Febrero 28, 2017
					*/
                    $html.=' curs&oacute; y aprob&oacute; las asignaturas correspondientes al programa de '.$solicitud_historico['nombrecortocarrera'].', y obtuvo el t&iacute;tulo de <strong>'.$solicitud_historico['nombretitulo'].'</strong>.</p>';
					/* FIN MODIFICACION */
                }else if ($solicitud_historico['codigosituacioncarreraestudiante'] <> 400){
                    $html.=' las asignaturas abajo relacionadas correspondientes al programa de '.$solicitud_historico['nombrecortocarrera'].'.';
                }
                $html.='<p align="justify">Que de conformidad con la información que reposa en los registros académicos de la Universidad, obtuvo las siguientes calificaciones:</p>';
                $html.='</div>';
                $html.='</td>';
            }else{
                $html.='<td colspan="4" class="Estilo6"><strong>Estudiante : </strong>'.$solicitud_historico['nombresestudiantegeneral'].'"&nbsp;"'.$solicitud_historico['apellidosestudiantegeneral'].'</td>';
                $html.='</tr>';
                $html.='<tr><td colspan="4" class="Estilo6"><strong>Documento No : </strong>'.$solicitud_historico['numerodocumento'].'</td></tr>';
                $html.='<tr><td colspan="7" class="Estilo1 Estilo5" align="center"><strong><font color="#990000">No válido como certificado de notas.</font></strong></span></td>';
                $html.='</tr><tr></tr><tr></tr><tr></tr><tr>';
            }

            $html.='</tr>';
            $html.='<tr>';
            $html.='<td width="11%" class="Estilo2 Estilo1"><strong>C&oacute;digo</strong></td>';
            $html.='<td width="32%" class="Estilo2 Estilo1"><strong>Materia</strong></td>';
            
            if($_GET['concredito'] == 1){
                $html.='<td width="5%"><div align="center" class="Estilo2 Estilo1"><strong>Ulas</strong></div></td>';
                $html.='<td width="7%"><div align="center" class="Estilo2 Estilo1"><strong>Cr&eacute;ditos</strong></div></td>';
            }

            $html.='<td width="7%"><div align="center" class="Estilo2 Estilo1"><strong>Nota</strong></div></td>';
            if($_GET['tiponota'] == 2){
                $html.='<td width="15%"><div align="center" class="Estilo2 Estilo1"><strong>Tipo Nota </strong></div></td>';
            }
            $html.='<td width="23%" class="Estilo2 Estilo1"><strong>Letras</strong></td>';
            $html.='</tr>';
            //echo $html;
            $cuentacambioperiodo = 0;
            $sumaulas="&nbsp;";
            $sumacreditos = "&nbsp;";
            $periodocalculo = "";
            $indicadorperiodo = 0;
            $ultimoperiodo = 0;
            $periodo = "";
            
            foreach($Array_materiasperiodo as $idsemestre => $Array_materia){

                $cuentaper="";
                $indicadorulas = 0;
                $creditos = 0;
                $notatotal = 0;
                foreach ($Array_materia as $num => $sem) if ($sem['semestre'] == $idsemestre) $cuentaper++;
                if ($idsemestre <> ""){ // if  $idsemestre
                    foreach($Array_materia as $key => $row_materiaperiodo) { // foreach 2
                        //$html ="";
                        if ($periodo <> $row_materiaperiodo['semestre']){ // if 1
                             $nombreultimoperiodo = $row_materiaperiodo['semestre'];
                             $html.='<tr><td colspan="7">&nbsp;</td></tr>';
                             $html.='<tr><td colspan="7" class="Estilo2"><strong>';
                            if ($row_materiaperiodo['semestre'] < 20){
                                $arabigo  =  $row_materiaperiodo['semestre'];
                                require('../convertirnumeros.php');
                                $html.="$sem ".strtoupper($nombreTipoPeriodo);
                            }else{
                                $query_nombreperiodo = "select nombreperiodo from periodo  where codigoperiodo = '".$row_materiaperiodo['semestre']."'";
                                $res_nombreperiodo = mysql_query($query_nombreperiodo, $sala) or die(mysql_error());
                                $solicitud_nombreperiodo = mysql_fetch_assoc($res_nombreperiodo);
                                $html.=$solicitud_nombreperiodo['nombreperiodo'];
                            }
                           $html.='</strong></td>';
                           $html.='</tr>';
                        } // if 1

                        $query_historico = "SELECT m.nombremateria,m.codigomateria,(m.ulasa+m.ulasb+m.ulasc) AS total,m.codigoindicadorcredito,m.numerocreditos, m.codigotipocalificacionmateria,t.nombretiponotahistorico,n.codigomateriaelectiva
                        FROM materia m,tiponotahistorico t,notahistorico n
                        WHERE n.codigotiponotahistorico = t.codigotiponotahistorico
                        and   n.codigomateria = m.codigomateria
                        and   n.codigoestudiante = '".$codigoestudiante."'
                        AND   m.codigomateria = '".$row_materiaperiodo['codigomateria']."'
                        and   n.codigoestadonotahistorico like '1%'";

                        $res_historico = mysql_query($query_historico, $sala) or die("$query_historico".mysql_error());
                        $solicitud_historico = mysql_fetch_assoc($res_historico);
                        $mostrarpapa = "";
                        if ($solicitud_historico['codigomateriaelectiva'] <> 1){
                            $query_electiva = "select nombremateria  from  materia where codigomateria = '".$solicitud_historico['codigomateriaelectiva']."'";
                            $electiva = mysql_query($query_electiva, $sala) or die(mysql_error());
                            $totalRows_electiva = mysql_num_rows($electiva);
                            $row_electiva = mysql_fetch_assoc($electiva);
                            if ($row_electiva <> "") $mostrarpapa = $row_electiva['nombremateria'];
                         }
                        $query_detallemateria = "select descripciontemasdetalleplanestudio
                        from  temasdetalleplanestudio
                        where codigomateria = '".$solicitud_historico['codigomateria']."'
                        and   codigoperiodo = '".$solicitud_historico['codigoperiodo']."'
                        and   codigoestado like '1%'";
                        $detallemateria = mysql_query($query_detallemateria, $sala) or die(mysql_error());
                        $totalRows_detallemateria = mysql_num_rows($detallemateria);
                        $row_detallemateria = mysql_fetch_assoc($detallemateria);

                        $html.='<tr>';
                        $html.='<td valign="top" class="Estilo1 Estilo2">'.$row_materiaperiodo['codigomateria'].'</td>';
                        $html.='<td class="Estilo1 Estilo2">';
                        if ($mostrarpapa <> "") $html.=$mostrarpapa.' / ';
                        $html.=$row_materiaperiodo['nombremateria'].$lugaresderotacion;

                        if ($row_detallemateria <> ""){
                            $html.='<table width="100%"  border="0" align="left" cellpadding="0">';
                            do{
                              $descmateplanesd = $row_detallemateria['descripciontemasdetalleplanestudio'];
                              $html.='<tr><td class="Estilo1 Estilo2">- '.$descmateplanesd.'</td></tr>';
                            }while($row_detallemateria = mysql_fetch_assoc($detallemateria));
                            $html.=' </table>';
                        }
                        $html.='</td>';
                        if($_GET['concredito'] == 1){ // if creditos
                            $html.='<td valign="top"><div align="center" class="Estilo1 Estilo2">';
                            if($solicitud_historico['codigoindicadorcredito'] == 200){
                                if (ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])){
                                    $html.= "&nbsp;";
                                }else{
                                    $html.=$solicitud_historico['total'];
                                }
                                $sumaulas=$sumaulas+$solicitud_historico['total'];
                                $indicadorulas = 1;
                            }
                            $html.='</div></td>';
                            $html.='<td valign="top"><div align="center" class="Estilo1 Estilo2">';
                            if($solicitud_historico['codigoindicadorcredito'] == 100){
                                if (ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])){
                                    $html.="&nbsp;";
                                }else{
                                    $html.=$solicitud_historico['numerocreditos'];
                                }
                                $sumacreditos=$sumacreditos+$solicitud_historico['numerocreditos'];
                            }
                            $html.='</div></td>';
                        } // if creditos

                        $html.='<td valign="top"><div align="center" class="Estilo1 Estilo2">';
                        $Anotas[$solicitud_historico['codigoperiodo']][$solicitud_historico['codigomateria']][$solicitud_historico['numerocreditos']] = $row_materiaperiodo['nota'];
                        $nota = number_format($row_materiaperiodo['nota'], 1, '.', '');						
                        if ($solicitud_historico['codigotiponotahistorico'] == 110 || ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])){
                            $html.="&nbsp;";
                        }else{
                            $html.=$nota;
                        }
                        $html.='</div></td>';

                        if($_GET['tiponota'] == 2){ // if nota
                            $html.='<td valign="top"><div align="center" class="Estilo1 Estilo2">';
                            if($solicitud_historico['codigotiponotahistorico'] != 110 && !ereg("^2",$solicitud_historico['codigotipocalificacionmateria'])){
                                $html.=$solicitud_historico['nombretiponotahistorico'];
                            }
                            $html.='</div></td>';
                        }// if nota
                        $html.='<td valign="top" class="Estilo1 Estilo2">';
                        $total   = substr($nota,0,3);
                        $numero  = substr($total,0,1);
                        $numero2 = substr($total,2,2);
                        require('../convertirnumeros.php');
                        if ($solicitud_historico['codigotiponotahistorico'] == 110 || ereg("^2",$solicitud_historico['codigotipocalificacionmateria']))	{
                            $html.="APROBADO";
                        } else{$html.=$numu."&nbsp;&nbsp;".$numu2."&nbsp;";}
                        $html.='&nbsp;</td>';
                        $html.='</tr>';
                        $cuentacambioperiodo ++;
                        require('calculopromediosemestralmacheteado.php');
                        if ($cuentaper == $cuentacambioperiodo ) {
                            $cuentacambioperiodo = 0;
                            $html.='<tr>';
                            $html.='<td colspan="2" class="Estilo2 Estilo1"><strong>'.$nombrePromPonderado.'</strong></td>';
                            if($_GET['concredito'] == 1){
                                $html.='<td><div align="center" class="Estilo2 Estilo1"><strong>'.$sumaulas.'</strong></div></td>';
                                $html.='<td><div align="center" class="Estilo2 Estilo1"><strong>'.$sumacreditos.'</strong></div></td>';
                            }
                            $html.='<td><div align="center" class="Estilo2 Estilo1"><strong>';
                            if ($promediosemestralperiodo > 5){
                                $promediosemestralperiodo =  round(($promediosemestralperiodo / 100),2);
                            }
                            $promediosemestralperiodo = round($promediosemestralperiodo,2);
                            $html.=round($promediosemestralperiodo,2);
                            $html.='&nbsp;</strong></div></td>';
                            if($_GET['tiponota'] == 2) $html.='<td></td>';
                            $html.='<td class="Estilo2 Estilo1"><strong>';
                            $numero =  substr($promediosemestralperiodo,0,1);
                            $numero2 = substr($promediosemestralperiodo,2,2);
                            require('../convertirnumeros.php');
                            $html.=$numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                            $html.='&nbsp;</strong></td>';
                            $html.='</tr>';
                            if($_GET['ppsa'] == 3){
                                $promedioacumuladop = AcumuladoReglamentoPeriodos ($codigoestudiante,$_GET['tipocertificado'],$Anotas,$sala);
                                if($promedioacumuladop > 5){
                                    $promedioacumuladop =  round(($promedioacumuladop / 100),2);
                                }
                                $html.='<tr>';
                                $html.='<td colspan="2"><span class="Estilo2 Estilo1"><strong>'.$nombrePromPonderadoAcumulado.'</strong></span></td>';
                                if($_GET['concredito'] == 1)$html.= "<td></td><td></td>";
                                $html.='<td><div align="center"><span class="Estilo2 Estilo1"><strong>';   
								/*
								 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
								 * Por solicitud de Consuelo Martinez se modifica el formato del promedio para que muestre un decimal separado por punto.
								 * @since  Febrero 28, 2017
								*/                             
                                $html.=  number_format($promedioacumuladop, 1, '.', '').'</strong></span></div></td>';
								/* FIN MODIFICACION */
                                if($_GET['tiponota'] == 2) $html.= '<td></td>';
                                $html.='<td><span class="Estilo2 Estilo1"><strong>';
                                $numero =  number_format(substr($promedioacumuladop,0,1), 1, '.', '');
                                $numero2 = number_format(substr($promedioacumuladop,2,2), 1, '.', '');
                                require('../convertirnumeros.php');
                                $html.=$numu."&nbsp;&nbsp;".$numu2."&nbsp;";
                                $html.='&nbsp;</strong></span></td>';
                                $html.='</tr>';
                            }
                            $sumaulas="&nbsp;";
                            $sumacreditos = "&nbsp;";
                        } // semestre
                        $periodo = $row_materiaperiodo['semestre'];                        
                    }//foreach 2
                } // if  $idsemestre
            } //foreach 1            
        }

        $html.='<tr><td colspan="7">&nbsp;</td></tr>';
        $html.='<tr>';
        $html.='<td colspan="2" class="Estilo2 Estilo1"><strong>Promedio Ponderado Acumulado </strong></td>';
	if($_GET['concredito'] == 1)  $html.="<td>&nbsp;</td><td>&nbsp;</td>";
        $html.='<td><div align="center" class="Estilo2 Estilo1"><strong>';
	require ('../../../../funciones/notas/calculopromedioacumulado.php');
	if($promedioacumulado > 5){ $promedioacumulado =  round(($promedioacumulado / 100),2);
	} else {
		$promedioacumulado = round(($promedioacumulado),1);
	}		
	$html.=number_format($promedioacumulado, 1, '.', '');
        $html.='</strong></div></td>';
	if($_GET['tiponota'] == 2) $html.="<td>&nbsp;</td>";
        $html.='<td class="Estilo2 Estilo1"><strong>';
	$numero =  substr($promedioacumulado,0,1);
	$numero2 = substr($promedioacumulado,2,2);

	require('../convertirnumeros.php');
	$html.=$numu."&nbsp&nbsp;".$numu2."&nbsp;";
	/*
	 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
	 * Se modifica el origen de la fecha de expedicion para que muestre la que se envía por el formulario
	 * @since  Marzo 01, 2017
	*/
	$fecha_exp=explode("/",$_REQUEST['fechaexpedicion']);
    $ano = $fecha_exp[2];
    $mes = $fecha_exp[1];
    $dia = $fecha_exp[0];
	/*$ano = substr(date("Y-m-d"),0,4);
	$mes = substr(date("Y-m-d"),5,2);
	$dia = substr(date("Y-m-d"),8,2);/**/
	/*FIN MODIFICACION*/ 
        $html.= '&nbsp;</strong></td>';
        $html.= '</tr>';
        $html.= '<tr><td colspan="7" class="Estilo2">&nbsp;</td></tr>';

	if(!isset($_GET['periodos'])){
          $articulo = '51';
          $notanumero = '3.0';
          $notaletra = 'tres punto cero';
           if ($moda == '300' ) {
              $articulo = '46';
              $notanumero = '3.0';
              $notaletra = 'tres punto cero';
            }
            $html.='<tr>';
            $html.='<td colspan="7"><p align="justify" class="Estilo1 Estilo2"><br>';
            $html.="De conformidad con lo dispuesto en el art&iacute;culo $articulo del reglamento estudiantil de la Universidad, la escala de calificaciones que aplica la Institución est&aacute; dentro de un rango de cero punto cero (0.0) a cinco punto cero (5.0) y la calificación m&iacute;nima aprobatoria es de $notaletra ($notanumero) sobre cinco punto cero (5.0).</p>";
            $html.='<p align="justify" class="Estilo1 Estilo2">La presente certificaci&oacute;n se expide a solicitud del interesado(a), en Bogot&aacute; D.C., a los ';
            $day = $dia;
            $mesesano = $mes;
            require('../convertirnumeros.php');
            $html.=$dias;
            $html.=" ( $dia ) d&iacute;as del mes de  $meses ( $mes ) del a&ntilde;o dos mil ";
            $day = substr($ano,2,4);
            require('../convertirnumeros.php');
            $html.=$dias . " ( $ano ).</p>";
            $html.='<p class="Estilo1 Estilo2">&nbsp;</p>';
            $html.='<span class="Estilo1 Estilo2">';

            $query_responsable = "SELECT *
            FROM directivo d,directivocertificado di,certificado c
            WHERE d.codigocarrera = '".$codigocarrera."'
            AND d.iddirectivo = di.iddirectivo
            AND di.idcertificado = c.idcertificado
            AND di.fechainiciodirectivocertificado <='".date("Y-m-d")."'
            AND di.fechavencimientodirectivocertificado >= '".date("Y-m-d")."'
            AND c.idcertificado = '2'
            ORDER BY fechainiciodirectivo";	
			
            $responsable = mysql_query($query_responsable, $sala) or die(mysql_error());
            $row_responsable = mysql_fetch_assoc($responsable);
            $totalRows_responsable = mysql_num_rows($responsable);
			//var_dump($row_responsable);
            $html.='</span>';
            $html.='<p class="Estilo1 Estilo2"><strong><a class="Estilo4" style="cursor: pointer" onClick="JavaScript:window.print()">'.$row_responsable['nombresdirectivo'].'&nbsp;'.$row_responsable['apellidosdirectivo'].'</a><br>';
            $html.=$row_responsable['cargodirectivo'];
            $html.='</strong>&nbsp;</p>';
            $html.='</td>';
            $html.='</tr>';
        }else{
                $html.='<tr></tr>';
                $html.='<tr></tr>';
                $html.='<tr></tr>';
                $html.='<tr>';
                $html.='<td align="center" colspan="3"><input type="button" onClick="history.go(-1)" name="regresar" value="Regresar">&nbsp;&nbsp;<input type="button" onClick="print()" name="imprimir" value="Imprimir"></td>';
                $html.='</tr>';

        }
    echo    $html.='</table></form>';
?>
  
