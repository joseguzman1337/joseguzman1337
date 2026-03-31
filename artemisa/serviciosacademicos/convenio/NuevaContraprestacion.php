<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');

    $db = getBD();
    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $datosusuario = $db->GetRow($sqlS);
    $user = $datosusuario['idusuario'];

    $id = $_POST['idconvenio'];
    if(!isset ($id)){
        
        echo "<script>alert('Error de ingreso a las contraprestaciones'); location.href='ConveniosActivos.php'; </script>";    
    }
    function limpiarCadena($cadena) {
         $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑ\s]', '', $cadena));
         return $cadena;
    }
    $sqlvalida = "SELECT si.NombreInstitucion, u.NombreUbicacion,u.IdUbicacionInstitucion FROM Convenios sc JOIN InstitucionConvenios si ON si.InstitucionConvenioId = sc.InstitucionConvenioId join UbicacionInstituciones u ON u.InstitucionConvenioId = si.InstitucionConvenioId WHERE sc.ConvenioId = '".$id."' and u.codigoestado = '100'";
    $datosvalidacion = $db->GetRow($sqlvalida);

if($datosvalidacion['NombreInstitucion']==''){
echo '<script language="javascript">alert("La institucion no tiene ubicaciones disponibles.");</script>';
echo '<script>document.location="MenuConvenios.php";</script>'; 
}                                       
if($_POST['Action_id']=='SaveData')
{
    $institucionubicacion          = $_POST['institucionubicacion']; 
    $tipocontraprestacion          = $_POST['tipocontraprestacion'];
    $estado                        = $_POST['estado'];
    $tipopracticante               = $_POST['tipopracticante'];
    $tipopago                      = $_POST['tipopago'];
    $valorcontraprestacion         = $_POST['valorcontraprestacion'];
    $idconvenio                    = $_POST['idconvenio'];
    $FechaCreacion                 = date("Y-m-d H:i:s");

    $institucionubicacion = limpiarCadena(filter_var($institucionubicacion,FILTER_SANITIZE_NUMBER_INT));
    $tipocontraprestacion = limpiarCadena(filter_var($tipocontraprestacion,FILTER_SANITIZE_NUMBER_INT));
    $estado = limpiarCadena(filter_var($estado,FILTER_SANITIZE_NUMBER_INT));
    $tipopracticante = limpiarCadena(filter_var($tipopracticante,FILTER_SANITIZE_NUMBER_INT));
    $valorcontraprestacion = limpiarCadena(filter_var($valorcontraprestacion,FILTER_SANITIZE_NUMBER_INT));
    $tipopago = limpiarCadena(filter_var($tipopago,FILTER_SANITIZE_NUMBER_INT));
    $idconvenio = limpiarCadena(filter_var($idconvenio,FILTER_SANITIZE_NUMBER_INT));
            
    $sql1="SELECT count(IdUbicacionInstitucion) FROM Contraprestaciones WHERE ConvenioId = '".$idconvenio."' AND IdTipoPracticante = '".$tipopracticante."' AND IdTipoPagoContraprestacion = '".$tipopago."' AND ValorContraprestacion = '".$valorcontraprestacion."'";
    if($Consulta=$db->Execute($sql1)===true)
    {
        $a_vectt['val']			=false;
        $a_vectt['descrip']		='Error al Consultar..';
        echo json_encode($a_vectt);
        exit;
    }
    $valores = $db->Execute($sql1);
    $datos =  $valores->getarray();
    if (!empty($datos[0][0]))
    {
        //$descrip = $sql1;
        $descrip = 'La contraprestacion que esta intentando ingresar ya se encuentra registrada.';
    }else
    {
        $sql2="insert into Contraprestaciones(IdUbicacionInstitucion,idsiq_contraprestacion, IdTipoPracticante, IdTipoPagocontraprestacion, ValorContraprestacion, codigoestado, UsuarioCreacion, FechaCreacion, ConvenioId) values('".$institucionubicacion."', '".$tipocontraprestacion."','".$tipopracticante."', '".$tipopago."', '".$valorcontraprestacion."', '".$estado."', '".$user."', '".$FechaCreacion."', '".$idconvenio."')"; 
        $agregar = $db->Execute($sql2);
        $descrip = 'La contraprestacion fue agregada';
        //$descrip =  $sql2;
        
    }
$a_vectt['val']			=true;
$a_vectt['descrip']		=$descrip;
echo json_encode($a_vectt);
exit;
}//if($_POST['Action_id']=='SaveData')        
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nueva Contraprestación</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesConvenios.js"></script>
        
        <script>
         function val_numero(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron =/[0-9-]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script>        
    </head>
    <body> 
        <div id="container">
        <center>
            <h1>NUEVA CONTRAPRESTACIÓN</h1>
        </center>
        <form  id="nuevacontraprestacion" action="../convenio/DetalleConvenio.php" method="post" enctype="multipart/form-data" >
        <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
        <input type="hidden" id="idconvenio" name="idconvenio" value="<?php echo $id?>" />
            <table cellpadding="3" width="60%" border="0" align="center">
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                    <?php 
                        $sql = "select NombreConvenio from Convenios where ConvenioId = '".$id."'";
                        $Consulta=$db->GetRow($sql);
                    ?>
                    <center><?php echo $Consulta['NombreConvenio']; ?></center>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Institución:<span style="color: red;">*</span></td>
                    <td>
                        <select name="institucionubicacion" id="institucionubicacion"  class="required">
                            <option value="0"></option>
                        <?php
                            $sqlubicacion = "SELECT si.NombreInstitucion, u.NombreUbicacion,u.IdUbicacionInstitucion FROM Convenios sc JOIN InstitucionConvenios si ON si.InstitucionConvenioId = sc.InstitucionConvenioId join UbicacionInstituciones u ON u.InstitucionConvenioId = si.InstitucionConvenioId WHERE sc.ConvenioId = '".$id."' and u.codigoestado = '100'";
                            $valoresubicacion = $db->execute($sqlubicacion);
                           foreach($valoresubicacion as $datosUbicacion)
                           {  
                                ?>
                                <option value="<?php echo $datosUbicacion['IdUbicacionInstitucion']?>"><?php echo $datosUbicacion['NombreInstitucion']." - ".$datosUbicacion['NombreUbicacion']; ?></option>
                                <?php
                            }
                        ?>
                        </select>                        
                    </td>
                    <td>Tipo de Contraprestación:<span style="color: red;">*</span></td>
                    <td>
                        <select name="tipocontraprestacion" id="tipocontraprestacion" >
                            <option value=""></option>
                            <option value="1">En Especie</option>
                            <option value="2">Económica</option>
                        </select>
                    </td>
                    <td>Estado:</td>
                    <td>
                       <select name="estado" id="estado">
                       <option value=""></option>
                        <?php 
                            $sqlestado = "select codigoestado, nombreestado from estado where codigoestado <> '300'";
                            $valoresestado = $db->execute($sqlestado);
                            foreach($valoresestado as $datosetado)
                            {
                                ?>
                                <option value="<?php echo $datosetado['codigoestado']?>"><?php echo $datosetado['nombreestado']?></option>
                                <?php
                            }
                        ?>
                        </select> 
                    </td>
                   </tr>
                <tr>
                    <td>Nivel de Formación:</td>
                    <td>
                        <select name="tipopracticante" id="tipopracticante" >
                        <option value=""></option>
                        <?php
                        $sqltipopracticante = "select IdTipoPracticante, NombrePracticante from TipoPracticantes where codigoestado = '100'";
                        $valorestipopracticante = $db->execute($sqltipopracticante);
                        foreach($valorestipopracticante as $datostipopracticante)
                        {
                            ?>
                            <option value="<?php echo $datostipopracticante['IdTipoPracticante']?>"><?php echo $datostipopracticante['NombrePracticante']?></option>
                            <?php
                        }
                        ?>
                        </select>
                    </td>
                    <td>Forma de Pago:</td>
                    <td>
                        <select name="tipopago" id="tipopago" >
                        <option value=""></option>
                            <?php 
                                $sqltipopago = "select IdTipoPagoContraprestacion, NombrePagoContraprestacion from TipoPagoContraprestaciones ";
                                $valorestipopago = $db->execute($sqltipopago);
                                foreach($valorestipopago as $datostipopago)
                                {
                                    ?>
                                    <option value="<?php echo $datostipopago['IdTipoPagoContraprestacion']?>"><?php echo $datostipopago['NombrePagoContraprestacion']?></option>
                                    <?php
                                }
                            ?>
                        </select> 
                    </td>
                    <td>Valor de la Contraprestación</td>
                    <td>
                        <input type="text" name="valorcontraprestacion" id="valorcontraprestacion" class="required" size="15" onkeypress="return val_numero(event)"/>
                    </td>
                </tr>  
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
            </table>
            <center>
            <table width="600" id="botones">
            <tr>
            <td><input type="button" value="Guardar" onclick="validarDatosContraprestacion('#nuevacontraprestacion');" /></td>
            <td align='right'><form action="DetalleConvenio.php" method="post">
            <input type="hidden" id="Detalle" name="Detalle" value="<?php echo $id;?>" />
            <input type="submit" value="Regresar" /></form></td>
            </tr>
            </table>
            </center>  
        </form>
    </div>
    <?php
       
    ?>
  </body>
</html>