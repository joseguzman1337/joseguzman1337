<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once('../../Connections/sala2.php' );

require_once("../../funciones/seleccioncarrera.php");
$fechahoy=date("Y-m-d H:i:s");
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');

?>
<html>
<head>

<title>Busqueda estudiante</title>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<body>
<form name="f1" method="get" >
  <LABEL id="labelresaltadogrande">CRITERIO DE BÚSQUEDA</LABEL>
    <table  border="0"  cellpadding="3" cellspacing="3">
        <tr id="trtitulogris">
            <td align="center">Nombre:</td>
            <td align="center"><INPUT type="text" name="nombre" value="<?php echo $_REQUEST['nombre'] ?>"></td>
            <td align="center">Apellido:</td>
            <td align="center"><INPUT type="text" name="apellido" value="<?php echo $_REQUEST['apellido'] ?>"></td>
            <td align="center">Documento:</td>
            <td align="center"><INPUT type="text" name="documento" value="<?php echo $_REQUEST['documento'] ?>"></td>      
        </tr>
    </table>
    <?php
    periodo (); 
    modalidad ();
    ?>
    <table  border="0"  cellpadding="3" cellspacing="3">
        <TR>
            <TD><INPUT type="submit" name="aceptar" value="Aceptar"></TD>
        </TR>
    </table>
  
    <?php 
    if (isset($_REQUEST['aceptar'])){
        $parametros="";
        if (isset ($_REQUEST['nombre']) && $_REQUEST['nombre']!=''){
        
        $parametros .=" and eg.nombresestudiantegeneral like '%".$_REQUEST['nombre']."%'" ;
        }
        if (isset ($_REQUEST['apellido']) && $_REQUEST['apellido']!=''){
        
        $parametros .=htmlspecialchars(" and eg.apellidosestudiantegeneral like '%".$_REQUEST['apellido']."%'");
        }
        if (isset ($_REQUEST['documento']) && $_REQUEST['documento']!=''){
        
        $parametros .=" and eg.numerodocumento = ".$_REQUEST['documento'];
        }
        if (isset ($_REQUEST['nacodigomodalidadacademica']) && $_REQUEST['nacodigomodalidadacademica']!=''){
        
        $parametros .=" and c.codigomodalidadacademica = ".$_REQUEST['nacodigomodalidadacademica'];
        }
        if (isset ($_REQUEST['nacodigocarrera']) && $_REQUEST['nacodigocarrera']!='' && $_REQUEST['nacodigocarrera']!='todas'){
        
        $parametros .=" and e.codigocarrera = ".$_REQUEST['nacodigocarrera'];
        }
        if (isset ($_REQUEST['periodo']) && $_REQUEST['periodo']!=''){
        
        $parametros .=" and e.codigoperiodo = ".$_REQUEST['periodo'];
        }
        if ($parametros ==''){
        $parametros=" and e.codigoestudiante = '' ";
        }
    
        
        $query_estudiante = "SELECT eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, eg.numerodocumento, c.nombrecarrera, e.codigoperiodo, s.nombresituacioncarreraestudiante
        FROM estudiante e, estudiantegeneral eg, carrera c, situacioncarreraestudiante s
        where
        e.idestudiantegeneral=eg.idestudiantegeneral
        and e.codigocarrera=c.codigocarrera
        and e.codigosituacioncarreraestudiante=s.codigosituacioncarreraestudiante
        $parametros
        order by eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral";
        $estudiante= $db->Execute($query_estudiante);
        $totalRows_estudiante = $estudiante->RecordCount();
        $row_estudiante = $estudiante->FetchRow();
               
        if ($totalRows_estudiante >0){ ?>
        
            <table   border="1"  cellpadding="3" cellspacing="3">
                <TR id="trtitulogris">
                    <TD colspan="6" align="center"><LABEL id="labelresaltadogrande">ESTUDIANTES</LABEL></TD>
                </TR>
                <TR id="trtitulogris">
                    <TD align="center">Documento</TD>
                    <TD align="center">Apellidos</TD>
                    <TD align="center">Nombres</TD>
                    <TD align="center">Situación</TD>
                    <TD align="center">Carrera</TD>                   
                </TR>
                <?php                  
                do { ?>                
                <TR>
                    <TD align="left">
                    <A id="apariencialink" href="../facultades/creacionestudiante/estudiante.php?codigocreado=<?php echo $row_estudiante['numerodocumento']; ?>">
                    <?php echo $row_estudiante['numerodocumento']; ?>
                    </A>
                    </TD>
                    <TD align="left"><?php echo $row_estudiante['apellidosestudiantegeneral']; ?>
                    </TD>
                    <TD align="left"><?php echo $row_estudiante['nombresestudiantegeneral']; ?>
                    </TD>
                    <TD align="left"><?php echo $row_estudiante['nombresituacioncarreraestudiante']; ?>
                    </TD>
                    <TD align="left"><?php echo $row_estudiante['nombrecarrera']; ?>
                    </TD>
                </TR>
                <?php 
                } while($row_estudiante = $estudiante->FetchRow());
                ?>                
            </table>     
        <?
        }
        else {        
            echo "<script language='javascript'> 
            alert ('La busqueda no arroja resultados');
            </script>";
        }
    }
    ?>
  
    
</form>
</body>
</html>
