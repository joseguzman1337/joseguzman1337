<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../Connections/salaado.php');
$rutaJS = "../sic/librerias/js/";
session_start();
//$db->debug=true;
if (!$_SESSION['MM_Username'])
 {
   header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");
 }
//echo $_REQUEST['codigoperiodo'];
$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];
$codigoestudiante = $_REQUEST['codigoestudiante'];
$codigofacultad = $_SESSION['codigofacultad'];

                $query_modalidadacademica = "SELECT codigomodalidadacademica, nombremodalidadacademica from modalidadacademica where codigoestado=100
                and codigomodalidadacademica in (200, 300)";
                $modalidadacademica= $db->Execute($query_modalidadacademica);
                $totalRows_modalidadacademica = $modalidadacademica->RecordCount();
                
                

?>

<html>
<head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
        <script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>
<script language="javascript">
    function prueba()
    {
        document.form1.submit();
    }
</script>
        
<SCRIPT language="JavaScript" >
$(document).ready(function (){
  $("input[type='checkbox']").click(function () {
    var codigocarrera = $(this).attr("name");
    var mensajecarreraordenpago = $("#" + codigocarrera).val();
    var check = $(this).is(":checked");
    $.ajax({
                    type: "GET",
                    url: 'asociarmensajecarreraordenpago.php',                    
                    data: 'codigocarrera=' + codigocarrera + '&mensajecarreraordenpago=' + mensajecarreraordenpago + '&check=' + check,
                    success: function(datos){
                        //$("#central").html(datos);
                        //$("#dialog").append(datos);
                        //alert(datos);
                    }
                });
    //alert("sadasdasd" + codigocarrera +  'este es el check ' + check);
    
  })
})

</SCRIPT>        
        
</head>
<body>
<form name="form1" id="form1" method="POST" action="" >
    
    <table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">
        <tr id="trtitulogris">
            <TD align="center"  colspan="2"><LABEL  id="labelresaltadogrande">MENSAJE CARRERA ORDEN DE PAGO</LABEL></TD>
        </tr>
        <tr>
            <td  id="tdtitulogris" align="center">Seleccione la Modalidad</td>                            
            <TD>
            <select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="prueba()">
                    <option value="seleccionar">
                        Seleccionar
                    </option><?php while($row_modalidadacademica = $modalidadacademica->FetchRow()){?><option value="<?php echo $row_modalidadacademica['codigomodalidadacademica'];?>"
                    <?php
                            if($row_modalidadacademica['codigomodalidadacademica']==$_REQUEST['codigomodalidadacademica']) {
                        echo "Selected";
                            }?>>
                    <?php echo $row_modalidadacademica['nombremodalidadacademica'];?>
                    </option><?php }?>
                    </select>                
            </td>
        </tr>
    </table>
    
    <?php 
    if (isset ($_REQUEST['codigomodalidadacademica']) && $_REQUEST['codigomodalidadacademica']!="seleccionar")
    {
        $query_carrera ="SELECT codigocarrera, nombrecarrera from carrera
        where codigomodalidadacademica='".$_REQUEST['codigomodalidadacademica']."'
        and now() between fechainiciocarrera and fechavencimientocarrera
        order by nombrecarrera";
        $carrera= $db->Execute($query_carrera);
        $totalRows_carrera = $carrera->RecordCount();
        $row_carrera = $carrera->FetchRow();
        if($totalRows_carrera !=0){        
            
    ?>
        <TABLE width="50%" border="1" align="center" cellpadding="2">
                <TR id="trtitulogris">                    
                    <TD align="center">Código</TD>
                    <TD align="center">Carrera</TD>
                    <TD align="center">Mensaje</TD>                                                          
                    <TD align="center">Guardar</TD>
                </TR>
                <?php do { 
                
                    $query_activos = "SELECT m.idmensajecarreraordenpago, m.codigocarrera, m.observacionmensajecarreraordenpago FROM mensajecarreraordenpago m 
                    where  m.codigocarrera = '".$row_carrera['codigocarrera']."'
                    and m.codigoestado like '1%'";
                    $activos = $db->Execute($query_activos);
                    $totalRows_activos = $activos->RecordCount();
                    $row_activos = $activos->FetchRow();
                    $checked="";
                    $mensaje="";
                    if ($totalRows_activos>0)
                        $checked='checked';
                        $mensaje=$row_activos['observacionmensajecarreraordenpago'];
                    $totalRows_activos;    
                ?>
                <TR>
                    <TD align="center"><?php echo $row_carrera['codigocarrera']; ?>
                    </TD>                            
                    <TD align="center"><?php echo $row_carrera['nombrecarrera']; ?>
                    </TD>
                    <TD align="center"><INPUT type="text" name="observacionmensajecarreraordenpago" id="<?php echo $row_carrera['codigocarrera']; ?>" value="<?php echo $mensaje; ?>">
                    </TD>
                    <TD align="center"><INPUT type="checkbox" name="<?php echo $row_carrera['codigocarrera']; ?>"
                    <?php echo $checked;?>>
                    </TD>                                                                   
                </TR>                        
                <?php } while($row_carrera = $carrera->FetchRow()) ?>
                </TABLE>         
    <?php             
        }
    }
    ?>
</form>
</body>
</html>