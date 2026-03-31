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
$alerta = $C_ValidarFecha->ValidarIngresoModulo($_SESSION['usuario'], $ip, 'Homologacion materias.');
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
session_start();

$codigoestudiante = $_GET['codigoestudiante'];

  
                $query_periodo="select p.codigoperiodo, p.nombreperiodo
                from periodo p, estudiante e, carreraperiodo cp
                where cp.codigocarrera = e.codigocarrera
                and p.codigoperiodo = cp.codigoperiodo
                and e.codigoestudiante = '$codigoestudiante'
                and p.codigoperiodo <= (select  max(codigoperiodo) from periodo where codigoestadoperiodo in(1, 4))
                and p.codigoperiodo >= e.codigoperiodo
                ORDER BY p.codigoperiodo DESC";
                $periodo = $db->Execute($query_periodo);
                $totalRows_periodo = $periodo->RecordCount();
               
          
?>
<SCRIPT language="JavaScript" type="text/javascript">
function consultar()
{

    document.form1.submit();
}
</SCRIPT>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
    <body>
<form name="form1" id="form1" method="POST" action="" >

    
    <TABLE width="50%" border="0" align="center" cellpadding="3">
        <TR id="trgris">
            
            <TD align="center"><label id="labelresaltadogrande" > Nueva Materia Homologación</label></br></br>
                    </TD>
        </TR>
        <TR id="trgris">
            
            <TD align="justify"><label id="labelasterisco" >*</label>No se puede seleccionar periodos inferiores al de la cohorte del estudiante
                    </TD>
        </TR>    
        <tr align="center" id="trgris">
            <td id="tdtitulogris">
            <select name="periodo" id="periodo" onchange="consultar()" ><option value="seleccionar">Seleccionar Periodo</option>
            <?php while($row_periodo = $periodo->FetchRow()){?><option value="<?php echo $row_periodo['codigoperiodo']?>"
            <?php if($row_periodo['codigoperiodo']==$_POST['periodo']){echo "Selected";}?>>
            <?php echo $row_periodo['codigoperiodo']." - ".$row_periodo['nombreperiodo']; ?>
            </option><?php }?>
            </select>
            </TD>
        </tr>
        <TR >
            <TD align="center" id="tdtitulogris"><INPUT type="button" name="Regresar" value="Regresar" onclick="window.location.href='../../prematricula/matriculaautomaticaordenmatricula.php'"></TD>
        </TR>
    </TABLE>
    
    <?php 
    if (isset ($_REQUEST['periodo']) && $_REQUEST['periodo']!="seleccionar")
    {
        $query_notas="SELECT n.codigomateria, m.nombremateria, n.notadefinitiva, t.nombretiponotahistorico, concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento, c.nombrecarrera, p.nombreperiodo  from notahistorico n,materia m,tiponotahistorico t, estudiante e,estudiantegeneral eg, carrera c, periodo p
        where n.codigoestudiante = '$codigoestudiante'
        and t.codigotiponotahistorico = n.codigotiponotahistorico
        and n.codigoperiodo = '".$_REQUEST['periodo']."'
        and m.codigomateria = n.codigomateria
        and codigoestadonotahistorico like '1%'
        and n.codigotiponotahistorico = '400'
        and e.idestudiantegeneral = eg.idestudiantegeneral
        and e.codigoestudiante = n.codigoestudiante
        and e.codigocarrera=c.codigocarrera
        and n.codigoperiodo=p.codigoperiodo
        order by nombremateria";
            $notas = $db->Execute($query_notas);
            $totalRows_notas = $notas->RecordCount();
            $row_notas = $notas->FetchRow();
        
        if ($totalRows_notas !=0){ ?>
            </BR>
            <TABLE width="50%" border="1" align="center" cellpadding="2">
                <tr>
                    <td align="center" id="tdtitulogris">Nombre</td>
                    <td align="center"><?php echo $row_notas['nombre']; ?></td>
                    <td align="center" id="tdtitulogris">Documento</td>
                    <td align="center"><?php echo $row_notas['numerodocumento']; ?></td>
                </tr>
                <tr>
                    <td align="center" id="tdtitulogris">Programa</td>
                    <td align="center"><?php echo $row_notas['nombrecarrera']; ?></td>
                    <td align="center" id="tdtitulogris">Periodo </td>
                    <td align="center"><?php echo $row_notas['nombreperiodo'];?></td>
                </tr>
            </TABLE>
            <TABLE width="50%" border="1" align="center" cellpadding="2">
                <TR id="trtitulogris">
                    <TD align="center">Código</TD>                            
                    <TD align="center">Nombre Materia</TD>
                    <TD align="center">Nota</TD>                            
                    <TD align="center">Tipo Nota</TD>                                        
                </TR>
                <?php do { ?>
                <TR>
                    <TD align="center"><?php echo $row_notas['codigomateria']; ?>
                    </TD>                            
                    <TD align="center"><?php echo $row_notas['nombremateria']; ?>
                    </TD>
                    <TD align="center"><?php echo $row_notas['notadefinitiva']; ?>
                    </TD>                            
                    <TD align="center"><?php echo $row_notas['nombretiponotahistorico']; ?>
                    </TD>
<?php
			$query_modif = "select	 id
						,notamodificada
						,nombreestadosolicitudcredito
						,fechaaprobacion
					from solicitudaprobacionmodificacionnotas s 
					join estadosolicitudcredito e on s.codigoestadosolicitud=e.codigoestadosolicitudcredito
					where codigoperiodo='".$_REQUEST["periodo"]."'
						and codigoestudiante='".$codigoestudiante."'
						and codigomateria=".$row_notas['codigomateria']."
						and codigoestadosolicitud=11
						and idtiposolicitudaprobacionmodificacionnotas=40
					order by id desc
					limit 1";
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
							<tr><td>Estado:</td><td><b><font color='#006822'>".$row_modif['nombreestadosolicitudcredito']."</font></b></td></tr>
						</table>
				       </TD>";
			}
?>
                </TR>                        
                <?php } while($row_notas = $notas->FetchRow()) ?>
                <TR id="trtitulogris">
                    <TD colspan="4" align="center"><INPUT type="button" name="nuevamateria" value="Nueva Materia" onclick="window.location.href='nuevamateriahomologacion.php?codigoestudiante=<?php echo "$codigoestudiante&codigoperiodo=".$_REQUEST['periodo'].""; ?>'">
                    </TD>
                </TR>
            </TABLE>
        <?php           
        }
        else {
            echo "<script language='javascript'> 
                  alert('No se encuentran materias de homologación  para este periodo');
                  window.location.href='nuevamateriahomologacion.php?codigoestudiante=$codigoestudiante&codigoperiodo=".$_REQUEST['periodo']."';
                  </script>";                              
        }
    }
       
    ?>
    
    
    
</form>
</body>
</html>
