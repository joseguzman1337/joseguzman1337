<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarModuloNota.php');
include_once(realpath(dirname(__FILE__)).'/../../../utilidades/Ipidentificar.php');

//identificaicon de la ip del usuario
$A_Validarip = new ipidentificar();
$ip = $A_Validarip->tomarip();
//validacion del ingreso del modulo
$C_ValidarFecha = new ValidarModulo(); 
$alerta = $C_ValidarFecha->ValidarIngresoModulo($_SESSION['usuario'], $ip, 'Homologacion nueva materias.');
//si el usuario ingresa durante fecha no autorizadas se genera la alerta.
if($alerta)
{
    echo $alerta;
    die;
}
   
$fechahoy=date("Y-m-d H:i:s");
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require('../../../Connections/salaado.php');
$rutaJS = "../../sic/librerias/js/";
require_once('../../../utilidades/notas/funcionesModificarNotas.php' );
session_start();
//$db->debug=true;
if (!$_SESSION['MM_Username'] or !$_SESSION['codigoperiodosesion'])
 {
   header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");
 }
//echo $_REQUEST['codigoperiodo'];
$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];
$codigoestudiante = $_REQUEST['codigoestudiante'];
$codigofacultad = $_SESSION['codigofacultad'];
$plan = "";

        $query_datos ="SELECT pe.idplanestudio, p.nombreplanestudio, concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento, c.nombrecarrera 
        FROM planestudioestudiante pe, planestudio p, estudiante e, estudiantegeneral eg, carrera c        
	WHERE pe.codigoestudiante = '".$codigoestudiante."'
	and e.codigoestudiante=pe.codigoestudiante
	and e.codigocarrera=c.codigocarrera
	and e.idestudiantegeneral=eg.idestudiantegeneral
	and pe.idplanestudio=p.idplanestudio
	AND pe.codigoestadoplanestudioestudiante LIKE '1%'";
	//AND materia.codigoestudiantematerianovasoft=grupo.codigoestudiantematerianovasoft
    // echo $query_cursos;
	$datos = $db->Execute($query_datos);
	$row_datos = $datos->FetchRow();
	$totalRows_datos = $datos->RecordCount();
            

        $query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
        $tipousuario = $db->Execute($query_tipousuario);
        $row_tipousuario = $tipousuario->FetchRow();
        $totalRows_tipousuario = $tipousuario->RecordCount();
    
    if ($row_tipousuario['codigotipousuariofacultad'] == 200)
    { // if
   $query_materias="SELECT m.nombremateria,m.codigomateria, m.numerocreditos, d.semestredetalleplanestudio*1 semestredetalleplanestudio
        FROM materia m,planestudio p,detalleplanestudio d,planestudioestudiante pe 
        WHERE  m.codigoestadomateria = '01'
        AND  p.codigocarrera = '".$row_tipousuario['codigofacultad']."'
        and pe.codigoestudiante = '$codigoestudiante'
        AND p.idplanestudio = d.idplanestudio
        AND d.codigomateria = m.codigomateria
        and pe.idplanestudio = p.idplanestudio
        AND p.codigoestadoplanestudio LIKE '1%'
        AND pe.codigoestadoplanestudioestudiante LIKE '1%'
        ORDER BY 4,1";
        $materias = $db->Execute($query_materias);
        $totalRows_materias = $materias->RecordCount();
        $row_materias = $materias->FetchRow();
            $plan = $row_materias['idplanestudio'];
    }
    else
    {
        $query_materias="SELECT m.nombremateria,m.codigomateria, m.numerocreditos, d.semestredetalleplanestudio*1 semestredetalleplanestudio
        FROM materia m,planestudio p,detalleplanestudio d,planestudioestudiante pe
        WHERE  m.codigoestadomateria = '01'
        AND  p.codigocarrera = '$codigofacultad'
        and pe.codigoestudiante = '$codigoestudiante'
        AND p.idplanestudio = d.idplanestudio
        AND d.codigomateria = m.codigomateria
        and pe.idplanestudio = p.idplanestudio
        AND p.codigoestadoplanestudio LIKE '1%'
        AND pe.codigoestadoplanestudioestudiante LIKE '1%'
        ORDER BY 4,1";
        $materias = $db->Execute($query_materias);
        $totalRows_materias = $materias->RecordCount();
        //$row_materias = $materias->FetchRow();
        $plan = $row_materias['idplanestudio'];
    }
    
    if ($plan == "")
 {
    $query_study ="SELECT idplanestudio
    FROM planestudioestudiante
	WHERE codigoestudiante = '".$codigoestudiante."'
	AND codigoestadoplanestudioestudiante LIKE '1%'";
	//AND materia.codigoestudiantematerianovasoft=grupo.codigoestudiantematerianovasoft
    // echo $query_cursos;
	$study = $db->Execute($query_study);
	$row_study = $study->FetchRow();
	$totalRows_study = $study->RecordCount();
   $plan = $row_study['idplanestudio'];
 }
               

?>
<SCRIPT language="JavaScript" type="text/javascript">


function confirmar() {
        if(confirm('¿Estás seguro de Hacer la Solicitud?')) {
            document.getElementById('guardar').value='ok';
            document.form1.submit();
        }
    }
</SCRIPT>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>
        
                
    <SCRIPT language="JavaScript" >
                function cancelar(id) {
                        if(confirm('Esta seguro de cancelar la solictud "'+id+'"?')){
                                document.form1.IdSolicitud.value=id;
                                document.form1.accion.value="cancelar";
                                document.form1.submit();
                        }
                }

$(document).ready(function (){
  $("input[type='checkbox']").click(function () {
    var id = $(this).attr('id');
    var tiponota = '400';
    var codigoestudiante = '<?php echo $codigoestudiante; ?>';
    var periodo = '<?php echo $_REQUEST['codigoperiodo']; ?>';
    var materia = $(this).attr("name");
    var notas = $("#nota"+materia).attr("value");
    var planestudiante = '<?php echo $plan; ?>';
    var observacion = $("#observacion").val();
    var semestre = $("#semestre"+id).html();
    var creditos = $("#creditos"+id).html();
    var nombremateria = $("#nombre_materia"+id).html(); 
    var chulito = $(this);
        if($(this).attr('checked') == true){ 
      //if (confirm("¿Esta seguro de agregar esta nota?" )){
      //if (confirm=true){
        //$(this).attr('disabled', true);            

      $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'guardamateriahomologacion.php',
                    data:({tiponota: tiponota, codigoestudiante:codigoestudiante, periodo:periodo, materia:materia, notas:notas, planestudiante:planestudiante, semestre:semestre, creditos:creditos, nombremateria:nombremateria, observacion:observacion}),
                    success: function(data){
                    if (data.val == true)
                    {
                        if (data.descrip !="guarda")
                        {
                            if(data.descrip =="invalida") {
			    	alert ('Las Notas se deben Digitar en Formato 0.0 a 5.0 con separador PUNTO(.)');
                            } else if(data.descrip =="vacio") {
                            	alert ('Debe digitar una Nota');
                            } else if(data.descrip =="observacion") {
                            	alert ('Debe digitar la Observación');
                            } else if(data.descrip =="ipfailed") {
                            	alert ('La dirección IP '+data.ip+' no es válida para realizar modificaciones. Por favor comuniquese con la mesa de ayuda');
                            } else if(data.descrip =="aprob_notfound") {
                            	alert ('No se encontro aprobador de notas definido para esta carrera. Por favor comuniquese con el área de registro y control');
                            } else {
                            	alert ("Error: " + data.descrip);
                            }
                            //alert ($(this).attr('checked' ) + "hola");
                            chulito.removeAttr('checked'); 
                        } else if(data.descrip=="guarda") {
                            //alert ('La nota queda pendiente de aprobación o rechazo');                        
                            alert ('La nota fue aprobada');
                            chulito.attr('disabled', true); 
                           // document.form1.submit();
                           $('#tr'+id).html(data.respuesta);
                           
                        }
                        }
                        //$("#central").html(datos);
                        //$("#dialog").append(datos);
                       //alert(datos);
                    }
                });
    
        /*}
        else { return false; }*/
    }    
  })
})

</SCRIPT>
 

</head>
    <body>
<form name="form1" id="form1" method="POST" action="" >

                <input type="hidden" name="accion">
                <input type="hidden" name="IdSolicitud">

<?php
                if ($_REQUEST['accion'] == "cancelar") {
                        $query = "update solicitudaprobacionmodificacionnotas set codigoestadosolicitud='21' where id=".$_REQUEST["IdSolicitud"];
                        mysql_query($query,$sala);
                        $query=queryAprobadorSolicitud($_REQUEST["IdSolicitud"]);						
                        $reg = mysql_query($query,$sala);
                        $row = mysql_fetch_assoc($reg);
                        $tabla="<table border='1' align='center' bordercolor='#003333'>
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
                                                <td align='center'><font face='Tahoma' size='2'>".$_REQUEST["IdSolicitud"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$_SESSION["MM_Username"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$row['fechasolicitud']."</font></td>
                                                <td align='center'><font face='Tahoma' size='2'>".$row['numerodocumento']."</font></td>
                                                <td align='center'><font face='Tahoma' size='2'>".$row["apellidosestudiantegeneral"]." ".$row["nombresestudiantegeneral"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$row['nombrecarrera']."</font></td>
                                                <td align='center'><font face='Tahoma' size='2'>".$row["nombremateria"]."</font></td>
                                                <td align='center'><font face='Tahoma' size='2'>".$row["notamodificada"]."</font></td>
                                                <td align='center'><font face='Tahoma' size='2'>".$row["observaciones"]."</font></td>
                                        </tr>
                                </table>";
                        require_once("../../../funciones/phpmailer/class.phpmailer.php");
                        $mail = new PHPMailer();
                        $mail->From = "no-reply@unbosque.edu.co";
                        $mail->FromName = "Sistema SALA";
                        $mail->ContentType = "text/html";
                        $mail->Subject = "Solicitud de modificación de notas cancelada";
                        $mail->Body = "<b>La siguiente solicitud ha sido cancelada por el usuario que la creó:</b><br><br>".$tabla;
			//$mail->AddAddress("dianarojas@unbosque.edu.co","Diana Rojas");
			//$mail->AddBCC("quinteroivan@unbosque.edu.co","Ivan Dario Quintero");
			//$mail->AddAddress("it@unbosque.edu.co","Jorge Martínez");
			//$mail->AddAddress("stipmp@gmail.com","Edwin Murcia");
                        $mail->AddAddress($row["emailaprobador"],$row["nombreaprobador"]);
                        $mail->Send();
                }

?>

    <TABLE width="70%" border="1" align="center" cellpadding="2">
    <tr><TD colspan="6"><label id="labelasterisco" >*</label><b>El estado MATRICULADA en la materia indica que el estudiante tiene cortes con notas  para el periodo seleccionado, por lo tanto debe eliminar la materia de la matricula para poder insertar en el histórico o esperar hasta el cierre</b>
</TD></tr>
        <tr>
            
            <td align="center" colspan="6" id="tdtitulogris"><LABEL id="labelresaltadogrande"><?php echo $row_datos['nombrecarrera']; ?></LABEL></td>
            
        </tr>
        <tR>
            <td align="center" id="tdtitulogris">Nombre</td>
            <td align="center"><?php echo $row_datos['nombre']; ?></td>
            <td align="center" id="tdtitulogris">Documento</td>
            <td align="center"><?php echo $row_datos['numerodocumento']; ?></td>
            <td align="center" id="tdtitulogris">Plan de Estudio</td>
            <td align="center"><?php echo $row_datos['idplanestudio']." - ".$row_datos['nombreplanestudio']; ?></td>
        </tR>                
    </TABLE>
<?php 
if ($totalRows_materias !=0){
?> 
    <TABLE width="70%" border="1" align="center" cellpadding="2">
            <TR id="trtitulogris">
                    <TD colspan="8" align="center">Observación &nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="text" name="observacion" size="50" id="observacion"> 
                    </TD>
            </TR>
                <TR id="trtitulogris">
                    <TD align="center">Semestre</TD>
                    <TD align="center">Código</TD>
                    <TD align="center">Créditos</TD>
                    <TD align="center">Materia</TD>                                                    
                    <TD align="center">Tipo Nota</TD>                                        
                    <TD align="center">Nota</TD>
                    <TD align="center">Guardar</TD>
                </TR>         
                     
                            
                <?php 
                $i=1;
                while($row_materias = $materias->FetchRow()) {
                        $query_notas="SELECT n.codigomateria, m.nombremateria, n.notadefinitiva, t.nombretiponotahistorico, concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento, c.nombrecarrera, p.nombreperiodo  from notahistorico n,materia m,tiponotahistorico t, estudiante e,estudiantegeneral eg, carrera c, periodo p
                        where n.codigoestudiante = '$codigoestudiante'
                        and t.codigotiponotahistorico = n.codigotiponotahistorico                        
                        and n.codigomateria = '".$row_materias['codigomateria']."'
                        and m.codigomateria = n.codigomateria
                        and codigoestadonotahistorico like '1%'        
                        and e.idestudiantegeneral = eg.idestudiantegeneral
                        and e.codigoestudiante = n.codigoestudiante
                        and e.codigocarrera=c.codigocarrera
                        and n.codigoperiodo=p.codigoperiodo
                        order by nombremateria";
            $notas = $db->Execute($query_notas);
            $totalRows_notas = $notas->RecordCount();
            $row_notas = $notas->FetchRow();
            //echo '<pre>'; echo $query_notas;

            $query_corte = "SELECT distinct c.numerocorte
                            FROM detallenota dn
                                INNER JOIN materia m on m.codigomateria = dn.codigomateria AND m.codigoestadomateria = '01'
                                INNER JOIN corte c on dn.idcorte = c.idcorte
                            WHERE dn.codigoestudiante = '".$codigoestudiante."' 
                                  AND dn.codigomateria = '".$row_materias['codigomateria']."'
                                  AND c.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'  
                                  AND dn.codigoestado=100
                            UNION      
                            SELECT dp.idgrupo as numerocorte
                            FROM detalleprematricula dp
                            INNER JOIN prematricula p on dp.idprematricula = p.idprematricula
                            WHERE dp.codigomateria = '".$row_materias['codigomateria']."'
                                AND (dp.codigoestadodetalleprematricula like '1%' or dp.codigoestadodetalleprematricula like '3%')
                                AND p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
                                AND p.codigoestudiante = '".$codigoestudiante."'";

            $corte = mysql_query($query_corte, $sala) or die(mysql_error());
            $row_corte = mysql_fetch_assoc($corte);
            $totalRows_corte = mysql_num_rows($corte);
                        
            if ($totalRows_notas == 0 && $totalRows_corte==0){
            
                 
                 ?>
                <TR id="<?php echo 'tr'.$i?>">
                    <TD align="center" id="<?php echo 'semestre'.$i?>"><?php echo $row_materias['semestredetalleplanestudio']; ?>
                    </TD>
                    <TD align="center" id="<?php echo 'materia'.$i?>"><?php echo $row_materias['codigomateria']; ?>
                    </TD>
                    <TD align="center" id="<?php echo 'creditos'.$i?>"><?php echo $row_materias['numerocreditos']; ?>
                    </TD>
                    <TD align="center" id="<?php echo 'nombre_materia'.$i?>"><?php echo $row_materias['nombremateria']; ?>
                    </TD>                            
                    <TD align="center">Homologación
                    </TD>
<?php
			$query_modif = "select	 id
						,notamodificada
						,observaciones
						,codigoestadosolicitud
						,nombreestadosolicitudcredito
					from solicitudaprobacionmodificacionnotas s 
					join estadosolicitudcredito e on s.codigoestadosolicitud=e.codigoestadosolicitudcredito
					where codigoperiodo='".$_REQUEST["codigoperiodo"]."'
						and codigoestudiante=".$_REQUEST["codigoestudiante"]."
						and codigomateria=".$row_materias['codigomateria']."
						and codigoestadosolicitud=10
						and idtiposolicitudaprobacionmodificacionnotas=40";
			$reg_modif = mysql_query($query_modif, $sala) or die(mysql_error());
            //echo '<pre>'; echo $query_modif;
			$count_modif = mysql_num_rows($reg_modif);
			if($count_modif>0) {
				$row_modif = mysql_fetch_assoc($reg_modif);
				echo "	<TD align='center' colspan='2'>
						<table width='100%' bgcolor='#CFFFEC'>
							<tr><td>NUEVA NOTA:</td><td align='right'><b>".$row_modif['notamodificada']."</b></td></tr>
						</table>
						<table width='100%' style='border: solid 2px #000000; '>
							<tr><td>Id Solicitud:</td><td><b>".$row_modif['id']."</b></td></tr>
							<tr><td>Estado:</td><td><b><font color='#000000'>".$row_modif['nombreestadosolicitudcredito']."</font></b></td></tr>
						</table>
						<table width='100%'><tr><th><input type='button' value='Cancelar solicitud' style='font-size:10px' onclick='cancelar(".$row_modif['id'].")'></th></tr></table>
				       </TD>";
			} else {
?>
				<TD align="center"><INPUT type="text" name="nota" id="nota<?php echo $row_materias['codigomateria']; ?>" size="5">                  
				</TD>
				<TD align="center"><INPUT id="<?php echo $i;?>" type="checkbox" name="<?php echo $row_materias['codigomateria']; ?>" value="<?php echo $row_materias['codigomateria']; ?>" >                  
				</TD>
<?php
				$query_modif = "select	 id
							,notamodificada
							,nombreestadosolicitudcredito
							,fechaaprobacion
						from solicitudaprobacionmodificacionnotas s 
						join estadosolicitudcredito e on s.codigoestadosolicitud=e.codigoestadosolicitudcredito
						where codigoperiodo='".$_REQUEST["codigoperiodo"]."'
							and codigoestudiante=".$_REQUEST["codigoestudiante"]."
							and codigomateria=".$row_materias['codigomateria']."
							and codigoestadosolicitud=20
							and idtiposolicitudaprobacionmodificacionnotas=40
						order by id desc
						limit 1";
                  //echo '<pre>'; echo $query_modif;      
                        
				$reg_modif = mysql_query($query_modif, $sala) or die(mysql_error());
				$count_modif = mysql_num_rows($reg_modif);
				if($count_modif>0) {
					$row_modif = mysql_fetch_assoc($reg_modif);
					echo "	<TD align='center'>
							<table width='100%' bgcolor='#CFFFEC'>
								<tr><td>NUEVA NOTA:</td><td align='right'><b>".$row_modif['notamodificada']."</b></td></tr>
							</table>
							<table width='100%' style='border: solid 2px #000000; '>
								<tr><td>Id Solicitud:</td><td><b>".$row_modif['id']."</b></td></tr>
								<tr><td>Fecha rechazo:</td><td><b>".$row_modif['fechaaprobacion']."</b></td></tr>
								<tr><td>Estado:</td><td><b><font color='#D20D00'>".$row_modif['nombreestadosolicitudcredito']."</font></b></td></tr>
							</table>
					       </TD>";
				}
			}
?>
                </TR>                        
                <?php 
                } 
                else { ?>
                 <TR>
                 
                    <TD align="center"><?php echo $row_materias['semestredetalleplanestudio']; ?>
                    </TD>
                     <TD align="center"><?php echo $row_materias['codigomateria']; ?>
                    </TD>
                    <TD align="center"><?php echo $row_materias['numerocreditos']; ?>
                    </TD>
                    <TD align="center"><?php echo $row_materias['nombremateria']; ?>
                    </TD>
                    <?php
                    ?>                            
                    <TD align="center"><?php if($totalRows_corte == 0) {
                                echo $row_notas['nombretiponotahistorico'];
                                }
                                else   {
                                echo "MATRICULADA";
                                }
                                 ?>
                    </TD>
                    <TD align="center"><?php echo $row_notas['notadefinitiva']; ?>               
                    </TD>
                    <TD align="center"><INPUT type="checkbox" name="notatraida" disabled="true" checked="">                  
                    </TD>
                                
                </TR>       
                <?php
                }
                $i++;
                } 
                ?>
                
                <TR>
                    <TD colspan="8" align="center">
                        <INPUT type="button" value="Regresar" onclick="window.location.href='materiashomologacion.php?codigoestudiante=<?php echo $codigoestudiante; ?>';">
                    </TD>
                    
                </TR>
            </TABLE>
<?php 
}
else 
{
echo "<script language='JavaScript'>alert('No se encuentre un plan de estudios asigando a este estudiante');
            window.history.back();
            </script>";
}
?>
            

</form>
</body>
</html>
