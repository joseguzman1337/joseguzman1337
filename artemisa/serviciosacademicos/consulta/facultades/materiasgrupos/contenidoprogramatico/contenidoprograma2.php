<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../../Connections/sala2.php');
$rutaado = "../../../../funciones/adodb/";
require_once('../../../../Connections/salaado.php');

$query_tipo_usuario ="SELECT u.idusuario,concat(u.apellidos,' ',u.nombres) as nombre,
u.codigorol,u.numerodocumento FROM usuario u  WHERE u.usuario='".$_SESSION['MM_Username']."'";

$tipo_usuario = $db->Execute ($query_tipo_usuario) or die("$query_tipo_usuario".mysql_error());
$total_Rows_tipo_usuario = $tipo_usuario->RecordCount();
$row_tipo_usuario = $tipo_usuario->FetchRow();
            $html = '<table width="70%"  border="1"  cellpadding="3" cellspacing="3">';
                    if(isset($_REQUEST['codigomateria'])&& $_REQUEST['codigomateria']!=""){
			$query_pertenecemateria="SELECT m.codigomateria,m.nombremateria, m.numerohorassemanales, m.numerosemana
			, c.nombrecarrera, f.nombrefacultad, t.nombretipomateria, t.codigotipomateria, p.nombreplanestudio, p.idplanestudio
			, coalesce(d.numerocreditosdetalleplanestudio,m.numerocreditos) as numerocreditosdetalleplanestudio
                        , d.semestredetalleplanestudio, m.porcentajeteoricamateria, m.porcentajepracticamateria
			FROM materia m
			left join detalleplanestudio d on m.codigomateria=d.codigomateria 
			left join planestudio p on d.idplanestudio = p.idplanestudio and p.codigoestadoplanestudio = '100' and p.codigocarrera = (select codigocarrera from materia where codigomateria='".$_REQUEST['codigomateria']."') 
			, carrera c , facultad f , tipomateria t
			where m.codigomateria='".$_REQUEST['codigomateria']."' 
			and m.codigocarrera=c.codigocarrera 
			and c.codigofacultad=f.codigofacultad 
			and m.codigotipomateria=t.codigotipomateria 
			group by semestredetalleplanestudio";		
                        $pertenecemateria = $db->Execute ($query_pertenecemateria) or die("$query_pertenecemateria".mysql_error());
                        $total_Rows_pertenecemateria = $pertenecemateria->RecordCount();
                        $row_pertenecemateria=$pertenecemateria->FetchRow();
                        $horaspresencialessemestre=$row_pertenecemateria['numerohorassemanales']*$row_pertenecemateria['numerosemana'];
                        $horastotales= 48 * $row_pertenecemateria['numerocreditosdetalleplanestudio'];
                        $horastrabajoindependiente=$row_pertenecemateria['numerohorassemanales']*2;
                        
                   $html .= '<tr id="trtitulogris" align="left" >';
                   $html .= '<TD >Facultad</TD>';
                   $html .= '<TD align="left" colspan="7">'.$row_pertenecemateria['nombrefacultad'].'</TD>';
                   $html .= '</tr><tr id="trtitulogris" align="left" >';
                   $html .= '<TD id="tdtitulogris">Programa</TD>';
                   $html .= '<TD align="left" colspan="7">'.$row_pertenecemateria['nombrecarrera'].'</TD>';
                   $html .= '</tr><tr id="trtitulogris" align="left" ><TD id="tdtitulogris">Código Asignatura</TD>';
                   $html .= '<TD align="left" colspan="7">'.$row_pertenecemateria['codigomateria'].'</TD>';
                   $html .= '</tr><tr id="trtitulogris" align="left" ><TD id="tdtitulogris">Periodo</TD>';
                   $html .= '<TD align="left" colspan="7">'.$_SESSION['codigoperiodosesion'].'</TD>';
                   $html .= '</tr><tr id="trtitulogris" align="left" ><TD id="tdtitulogris">Tipo Asignatura</TD>';
                   $html .= '<TD align="left" colspan="7" >Obligatoria <input name="1" type="checkbox" ';
                    if($row_pertenecemateria['codigotipomateria']==1){$html .=  "checked" ;}$html .= ' disabled>';
                   $html .= '&nbsp;Propuesta<input name="2" type="checkbox"';
                   if($row_pertenecemateria['codigotipomateria']==2){ $html .= "checked" ;} $html .= ' disabled>';
                   $html .= '&nbsp;Sugerida<input name="2" type="checkbox"';
                   if($row_pertenecemateria['codigotipomateria']==3){ $html .= "checked" ;} $html .= ' disabled>';
                   $html .= '&nbsp;Electivas Libres<input name="2" type="checkbox"';
                   if($row_pertenecemateria['codigotipomateria']==4){ $html .= "checked" ;} $html .= ' disabled>';
                   $html .= '&nbsp;Electivas Obligatorias<input name="2" type="checkbox"';
                   if($row_pertenecemateria['codigotipomateria']==5){ $html .= "checked" ;} $html .= ' disabled>';
                   $html .= '</TD>';
                   $html .= '</tr><tr id="trtitulogris" align="left" ><TD colspan="8" id="tdtitulogris">Modalidad Asignatura en %</TD>';
                   $html .= '</tr><tr id="trtitulogris" align="left" ><TD  id="tdtitulogris" width="20%">Teoríca</TD>';
                   $html .= '<TD  id="tdtitulogris" width="5%">'.$row_pertenecemateria['porcentajeteoricamateria'].'</TD>';
                   $html .= '<TD  id="tdtitulogris" width="20%">Práctica</TD>';
                   $html .= '<TD  id="tdtitulogris" width="5%">'.$row_pertenecemateria['porcentajepracticamateria'].'</TD>';
                   $html .= '<TD  id="tdtitulogris" width="20%">Teórica-Práctica</TD>';
                   $html .= '<TD  id="tdtitulogris"width="5%">0</TD>';
                   $html .= '<TD  id="tdtitulogris" width="20%">Salidas de Campo</TD>';
                   $html .= '<TD  id="tdtitulogris" width="5%">0</TD>';
                   $html .= '</tr><tr id="trtitulogris" align="left" ><TD id="tdtitulogris">Pre-requisitos</TD>';
                   $html .= '<TD align="left" colspan="7">';
                        /*
                         * Este query selecciona las materias que son prerequisito, trae las materias prerequisito
                         * en los distintos planes de estudio.
                         */
                        $query_planestudio="SELECT m.codigomateria
						,m.nombremateria
						, m.numerohorassemanales
						, d.numerocreditosdetalleplanestudio
						, d.semestredetalleplanestudio
						, p.idplanestudio
					FROM materia m
					left join detalleplanestudio d on m.codigomateria=d.codigomateria 
					left join planestudio p on d.idplanestudio = p.idplanestudio and p.codigoestadoplanestudio = '100' 
					where m.codigomateria='".$_REQUEST['codigomateria']."'"; 
                        
                        $planestudio = $db->Execute ($query_planestudio) or die("$query_pertenecemateria".mysql_error());
                        $total_Rows_planestudio = $planestudio->RecordCount();
                        $i=0;
                        while ($row_planestudio = $planestudio->FetchRow()){
			$planes_est=($row_planestudio['idplanestudio']=='')?"''":$row_planestudio['idplanestudio'];
                        if($i==0)
                        { $idplanes.=$planes_est;}
                        else{
                        $idplanes.=",".$planes_est;}
                        $i++;                        
                        }
                        //echo $idplanes;
                        $query_prerequisitos="select r.codigomateriareferenciaplanestudio, m.nombremateria
                            from referenciaplanestudio r, materia m
                            where r.idplanestudio in($idplanes)
                            and r.codigomateria = '".$_REQUEST['codigomateria']."'
                            and idlineaenfasisplanestudio = 1
                            and codigotiporeferenciaplanestudio = '100'
                            and r.codigomateriareferenciaplanestudio = m.codigomateria
                            group by 1";
                        $prerequisitos = $db->Execute ($query_prerequisitos) or die("$query_prerequisitos".mysql_error());
                        $total_Rows_prerequisitos= $prerequisitos->RecordCount();
                   
                        if($total_Rows_prerequisitos == 0){
                            $html .= "&nbsp;";
                        }
                        else{
                            $j=0;
                            while ($row_prerequisitos= $prerequisitos->FetchRow()){
                            if($j==0)
                            { $nombrepre.=$row_prerequisitos['codigomateriareferenciaplanestudio']."-".$row_prerequisitos['nombremateria'];}
                            else{
                            $nombrepre.=", ".$row_prerequisitos['codigomateriareferenciaplanestudio']."-".$row_prerequisitos['nombremateria'];}
                            $j++;
                            }
                            $html .= $nombrepre;
                        }

                        $html .= '</TD>';
                       $html .= '</tr><tr id="trtitulogris" align="left" ><TD id="tdtitulogris">Co-requisitos</TD>';
                   $html .= '<TD align="left" colspan="7">';
                          $query_corequisitos="select r.codigomateriareferenciaplanestudio, m.nombremateria
                            from referenciaplanestudio r, materia m
                            where r.idplanestudio in($idplanes)
                            and r.codigomateria = '".$_REQUEST['codigomateria']."'
                            and idlineaenfasisplanestudio = 1
                            and codigotiporeferenciaplanestudio in(200, 201)
                            and r.codigomateriareferenciaplanestudio = m.codigomateria
                            group by 1";
                        $corequisitos = $db->Execute ($query_corequisitos) or die("$query_corequisitos".mysql_error());
                        $total_Rows_corequisitos= $corequisitos->RecordCount();
                        if($total_Rows_corequisitos == 0){
                            $html .= "&nbsp;";
                        }
                        else{
                            $k=0;
                            while ($row_corequisitos= $corequisitos->FetchRow()){
                            if($k==0)
                            { $nombreco.=$row_corequisitos['codigomateriareferenciaplanestudio']."-".$row_corequisitos['nombremateria'];}
                            else{
                            $nombreco.=", ".$row_corequisitos['codigomateriareferenciaplanestudio']."-".$row_corequisitos['nombremateria'];}
                            $k++;
                            }
                            $html .= $nombreco;
                        }
                       $html .= '</TD><tr id="trtitulogris" align="left" ><TD id="tdtitulogris">Número de Créditos</TD>';
                       $html .= '<TD align="left" colspan="7">'.$row_pertenecemateria['numerocreditosdetalleplanestudio'].'</TD>';
                       $html .= '</tr><tr id="trtitulogris" align="left" ><TD id="tdtitulogris" width="20%">Horas Presenciales/Semana</TD>';
                       $html .= '<TD align="left" width="40%" colspan="2" >'.$row_pertenecemateria['numerohorassemanales'].'</TD>';
                       $html .= '<TD id="tdtitulogris" colspan="3">Número horas semestrales</TD>';
                       $html .= '<TD align="left" width="10%" colspan="2">'.$horaspresencialessemestre.'</TD>';
                       $html .= '</tr><tr id="trtitulogris" align="left" ><TD id="tdtitulogris">Semestre al que corresponde la asignatura:</TD>';
                       $html .= '<TD align="left" colspan="2">';
                        
                        $z=0;
                        do{
                            if($z==0)
                            { $sem.=$row_pertenecemateria['semestredetalleplanestudio'];}
                            else{
                            $sem.="; ".$row_pertenecemateria['semestredetalleplanestudio'];}
                            $z++;
                        }while ($row_pertenecemateria = $pertenecemateria->FetchRow());
                       $html .= $sem;
                       $html .= '</TD><TD id="tdtitulogris" colspan="3">Horas de Trabajo Independiente/Semana</TD>';
                       echo $html .= '<TD align="left" colspan="2">'.$horastrabajoindependiente.'</TD></tr></table>';
                    $query_registros="SELECT c.idcontenidoprogramatico, c.urlcontenidoprogramatico,
                    c.urlactividadescontenidoprogramatico, c.urlaarchivofinalcontenidoprogramatico,c.codigoperiodo,c.urlasyllabuscontenidoprogramatico
                    FROM contenidoprogramatico  c
                    where c.codigomateria = '".$_REQUEST['codigomateria']."'
                    and c.codigoperiodo = '".$_SESSION["codigoperiodosesion"]."'
                    and c.codigoestado like '1%'
		    order by fechainiciocontenidoprogramatico desc
		    limit 1";
                    $registros = $db->Execute ($query_registros) or die("$query_registros".mysql_error());
                    $total_Rows_registros= $registros->RecordCount();
                    $row_registros = $registros->FetchRow();
                    $idcontenidoprogramatico=$row_registros['idcontenidoprogramatico'];
                    }
 ?>