<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    

$fechahoy=date("Y-m-d H:i:s");
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require('../../../Connections/salaado.php');
require_once('../../../funciones/funcionip.php' );
require_once('../../../utilidades/notas/funcionesModificarNotas.php' );
$ip = (tomarip())?tomarip():"SIN DEFINIR";

/*
echo $_REQUEST['tiponota'];
echo "  ".$_REQUEST['codigoestudiante'];
echo " ".$_REQUEST['periodo'];
echo "  ".$_REQUEST['materia'];
echo " ".$_REQUEST['observacion'];
echo "  ".$_REQUEST['notas'];
echo " ".$_REQUEST['planestudiante'];
*/
$varguardar = 0;
if ($_POST['notas']=='') {
	$descrip = "vacio";
	$varguardar = 1;
} else if ((!ereg("^[0-5]{1,1}\.[0-9]{1,1}$", $_POST['notas'])) or ($_POST['notas'] > 5)) {
	$descrip =  "invalida";
	$varguardar = 1;
} else if ($_POST['observacion'] == '') {
	$descrip =  "observacion";  
	$varguardar = 1;
} elseif ($varguardar==0) {
	$a_vectt['ip'] =$ip;
	$query="select * from ipsvalidasmodificacionnotas where (ip='".$ip."') and '".date("Y-m-d")."' between fechadesde and fechahasta";
	$regIP = mysql_query($query,$sala);
	if (mysql_num_rows($regIP)==0) {
		$descrip = "ipfailed";
	} else {
		$query=queryAprobadorCodigoEstudiante($_POST["codigoestudiante"]);
		//echo $query; die;
		$regAprobador = mysql_query($query,$sala);
		if (mysql_num_rows($regAprobador)==0) {
			$descrip = "aprob_notfound";
		} else {
			

			$rowAprobador = mysql_fetch_assoc($regAprobador);

			$query="select idusuario from usuario where usuario='".$_SESSION['MM_Username']."'";
			$regSolicitante = mysql_query($query,$sala) OR die(mysql_error());
			$rowSolicitante = mysql_fetch_assoc($regSolicitante);

			$query="select	 numerodocumento
					,apellidosestudiantegeneral
					,nombresestudiantegeneral
				from estudiante
				join estudiantegeneral using(idestudiantegeneral)
				where codigoestudiante=".$_POST["codigoestudiante"];
			$regEstudiante = mysql_query($query,$sala) OR die(mysql_error());
			$rowEstudiante = mysql_fetch_assoc($regEstudiante);
				
			$query_mat = "	SELECT nombremateria
					FROM materia
					WHERE codigomateria = '".$_POST['materia']."'";	
			$mat = mysql_query($query_mat,$sala) OR die(mysql_error());
			$row_mat = mysql_fetch_assoc($mat);
			
			/*$query="insert into solicitudaprobacionmodificacionnotas
					(codigotiponotahistorico
					,codigoestudiante
					,codigoperiodo
					,codigomateria
					,notamodificada
					,idplanestudio
					,observaciones
					,idsolicitante
					,fechasolicitud
					,ipsolicitante
					,idaprobador
					,insdelupd
					,idtiposolicitudaprobacionmodificacionnotas
					,codigoestadosolicitud)
				values ( '".$_POST["tiponota"]."'
					,".$_POST["codigoestudiante"]."
					,'".$_POST["periodo"]."'
					,".$_POST["materia"]."
					,".$_POST["notas"]."
					,".$_POST["planestudiante"]."
					,'".$_POST["observacion"]."'
					,'".$rowSolicitante["idusuario"]."'
					,'".$fechahoy."'
					,'".$ip."'
					,'".$rowAprobador["idaprobador"]."'
					,'I'
					,40
					,10)";
			mysql_query($query,$sala);*/
            
            $query="insert into solicitudaprobacionmodificacionnotas
					(codigotiponotahistorico
					,codigoestudiante
					,codigoperiodo
					,codigomateria
					,notamodificada
					,idplanestudio
					,observaciones
					,idsolicitante
					,fechasolicitud
					,ipsolicitante
					,idaprobador
                    ,fechaaprobacion
					,insdelupd
					,idtiposolicitudaprobacionmodificacionnotas
					,codigoestadosolicitud)
				values ( '".$_POST["tiponota"]."'
					,".$_POST["codigoestudiante"]."
					,'".$_POST["periodo"]."'
					,".$_POST["materia"]."
					,".$_POST["notas"]."
					,".$_POST["planestudiante"]."
					,'".$_POST["observacion"]."'
					,'".$rowSolicitante["idusuario"]."'
					,'".$fechahoy."'
					,'".$ip."'
					,'".$rowAprobador["idaprobador"]."'
                    ,'".$fechahoy."'
					,'I'
					,40
					,11)";
			mysql_query($query,$sala);

			$idSol=mysql_insert_id();
            
            $grupo = 1;
            $electivahistorico = 1;
            $planestudio = 1;
                       
            $estadonotahistorico = 100;
            $fecha = date("Y-m-j G:i:s",time());
            
            //consulta el tipo de materia 
            $sqltipomateria = "select codigotipomateria from materia where codigomateria = '".$_POST["materia"]."'";
            $Record = mysql_query($sqltipomateria, $sala) or die(mysql_error());
            $row_Record = mysql_fetch_assoc($Record);
            if ($row_Recordset <> "")
            {
                $tipomateria = $row_Record['codigotipomateria'];
            }
            else
            {
                $tipomateria = 1;
            }
            //echo $sqltipomateria;
            
            //verifica la linea del plan de estudios asignado a la materia
            $query_Recordset ="select idlineaenfasisplanestudio from detallelineaenfasisplanestudio where codigomateriadetallelineaenfasisplanestudio = '".$_POST["materia"]."'
             and idplanestudio = '".$_POST["planestudiante"]."' and codigoestadodetallelineaenfasisplanestudio LIKE '1%'";

            //echo $query_Recordset,"</br>";
            $Recordset = mysql_query($query_Recordset, $sala) or die(mysql_error());
            $row_Recordset = mysql_fetch_assoc($Recordset);
            
            if ($row_Recordset <> "")
            {
                $idlinea = $row_Recordset['idlineaenfasisplanestudio'];
            }
            else
            {
                $idlinea = 1;
            } 
            
            //inserta la nota al historico                          
            $sqlnotainsert = "insert into notahistorico(idnotahistorico,codigoperiodo,codigomateria,codigomateriaelectiva,codigoestudiante,notadefinitiva, codigotiponotahistorico,
            origennotahistorico, fechaprocesonotahistorico,idgrupo,idplanestudio,idlineaenfasisplanestudio,observacionnotahistorico,codigoestadonotahistorico,codigotipomateria)
           VALUES('0','".$_POST['periodo']."','".$_POST["materia"]."','".$electivahistorico."','".$_POST['codigoestudiante']."','".$_POST["notas"]."','".$_POST['tiponota']."','10','".$fechahoy."',
           '".$grupo."','".$planestudio."','".$idlinea."','".$_POST['observacion']."','".$estadonotahistorico."','".$tipomateria."')";
            mysql_query($sqlnotainsert,$sala);
 

			/*$tabla="<table border='1' align='center' bordercolor='#003333'>
					<tr>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Id Solicitud</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Usuario solicitante</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Fecha solicitud</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Documento</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Apellidos y Nombres</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Carrera</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Materia</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Nota</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Observaciones</strong></font></td>
					</tr>
					<tr>
						<td align='center'><font face='Tahoma' size='2'>".$idSol."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$_SESSION["MM_Username"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$fechahoy."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$rowEstudiante['numerodocumento']."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$rowEstudiante["apellidosestudiantegeneral"]." ".$rowEstudiante["nombresestudiantegeneral"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$_SESSION["nombrefacultad"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$row_mat["nombremateria"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$_POST["notas"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$_POST["observacion"]."</font></td>
					</tr>
				</table>";
		
			require_once("../../../funciones/phpmailer/class.phpmailer.php");
                        $mail = new PHPMailer();
                        $mail->From = "no-reply@unbosque.edu.co";
                        $mail->FromName = "Sistema SALA";
                        $mail->ContentType = "text/html";
                        $mail->Subject = "Tiene una nueva solicitud de ingreso de notas por homologación";
                        $mail->Body = "<b>Las siguiente solicitud está pendientes de aprobación o rechazo:</b><br><br>".$tabla;
			//$mail->AddAddress("dianarojas@unbosque.edu.co","Diana Rojas");
			//$mail->AddBCC("quinteroivan@unbosque.edu.co","Ivan Dario Quintero");
			//$mail->AddAddress("it@unbosque.edu.co","Jorge Martínez");
			//$mail->AddAddress("stipmp@gmail.com","Edwin Murcia");
                        $mail->AddAddress($rowAprobador["emailaprobador"],$rowAprobador["nombreaprobador"]);
                        $mail->Send();

			//$ruta= "../../../";
			//require_once("../modificahistoricooperacionmedicina.php");*/
            
         $descrip = 'guarda';
          
           
           $a_vectt['respuesta'] =' 
                    <td align="center">'.$_POST['semestre'].'</td>
                    <td align="center">'.$_POST['materia'].'</td>
                    <td align="center">'.$_POST['creditos'].'</td>
                    <td align="center">'.$_POST['nombremateria'].'</td>                            
                    <td align="center">Homologación</td>
                    <td align="right">'.$_POST["notas"].'</td>';
           
           
            /* <table width="100%" style="border: solid 2px #000000; ">
					   <tbody><tr><td>Id Solicitud:</td><td><b>'.$idSol.'</b></td></tr>
					   <tr><td>Estado:</td><td><b><font color="#000000">Solicitud</font></b></td></tr>
					   </tbody>
                       </table>
					   <table width="100%"><tbody><tr><th><input type="button" onclick="cancelar('.$idSol.')" style="font-size:10px" value="Cancelar solicitud"></th></tr></tbody></table>
				    </td>*/
            //echo "guarda";
		}
        
	}
}
$a_vectt['val']     = TRUE;
$a_vectt['descrip'] =$descrip;
echo json_encode($a_vectt);
?>
