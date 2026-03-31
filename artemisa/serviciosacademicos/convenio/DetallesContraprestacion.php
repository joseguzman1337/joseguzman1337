<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    $db = getBD();
    
    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $usuario = $db->GetRow($sqlS);
    $user = $usuario['idusuario'];

    $idconvenio = $_POST['idconvenio'];
    if(!isset ($idconvenio)){
        
        echo "<script>alert('Error de ingreso a los detalles de una contraprestacion'); location.href='ConveniosActivos.php'; </script>";    
    }
    function limpiarCadena($cadena) {
         $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
         return $cadena;
    }

if($_POST['Action_id']=='SaveData')
{
    $IdContraprestacion            = $_POST['IdContraprestacion'];
    $tipocontraprestacion          = $_POST['tipocontraprestacion'];
    $estado                        = $_POST['estado'];
    $tipopracticante               = $_POST['tipopracticante'];
    $tipopago                      = $_POST['tipopago'];
    $valorcontraprestacion         = $_POST['valorcontraprestacion'];
    $idconvenio                    = $_POST['idconvenio'];
    $FechaCreacion                 = date("Y-m-d H:i:s");
    
    $IdContraprestacion = limpiarCadena(filter_var($IdContraprestacion,FILTER_SANITIZE_NUMBER_INT));
    $tipocontraprestacion = limpiarCadena(filter_var($tipocontraprestacion,FILTER_SANITIZE_NUMBER_INT));
    $estado = limpiarCadena(filter_var($estado,FILTER_SANITIZE_NUMBER_INT));
    $tipopracticante = limpiarCadena(filter_var($tipopracticante,FILTER_SANITIZE_NUMBER_INT));
    $tipopago = limpiarCadena(filter_var($tipopago,FILTER_SANITIZE_NUMBER_INT));
    $valorcontraprestacion = limpiarCadena(filter_var($valorcontraprestacion,FILTER_SANITIZE_NUMBER_INT));
    $idconvenio = limpiarCadena(filter_var($idconvenio,FILTER_SANITIZE_NUMBER_INT));
            

    $slq3="update Contraprestaciones set idsiq_contraprestacion = '".$tipocontraprestacion."', IdTipoPracticante = '".$tipopracticante."', IdTipoPagoContraprestacion = '".$tipopago."',
     ValorContraprestacion = '".$valorcontraprestacion."', codigoestado = '".$estado."', UsuarioUltimaModificacion = '".$user."', FechaUltimaModificacion = '".$FechaCreacion."' where (IdContraprestacion = '".$IdContraprestacion."')"; 
     
     if($Consulta=$db->Execute($slq3)===true)
    {
         $descrip = "No se guardaron los datos";
    }else
    {
       $descrip = "La contraprestacion fue actualizada."; 
    }
    
    
    $a_vectt['val']			=true;
    $a_vectt['descrip']		=$descrip;
    echo json_encode($a_vectt);
    exit;
    
}else
{
    if(!empty($_POST['Detalle']))
    {
        $id = $_POST['Detalle'];
       
        $sql1="SELECT c.IdContraprestacion, u.NombreUbicacion, c.idsiq_contraprestacion, c.IdTipoPracticante, c.IdTipoPagocontraprestacion, c.ValorContraprestacion, c.codigoestado, c.ConvenioId FROM Contraprestaciones c, UbicacionInstituciones u WHERE IdContraprestacion = '".$id."' and u.IdUbicacionInstitucion = c.IdUbicacionInstitucion";
        
        $detalles = $db->GetAll($sql1);
        foreach($detalles as $datos1)
        {
            $IdContraprestacion            = $datos1['IdContraprestacion'];
            $IdUbicacionInstitucion        = $datos1['NombreUbicacion']; 
            $idsiq_contraprestacion        = $datos1['idsiq_contraprestacion'];
            $IdTipoPracticante             = $datos1['IdTipoPracticante'];
            $IdTipoPagocontraprestacion    = $datos1['IdTipoPagocontraprestacion'];
            $ValorContraprestacion         = $datos1['ValorContraprestacion'];
            $codigoestado                  = $datos1['codigoestado'];
            $idsiq_convenio                = $datos1['ConvenioId'];
        }
    }
}         
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Detalles Contraprestación</title>
        
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
            <h1>DETALLE CONTRAPRESTACIÓN</h1>
        </center>
        <form  id="detallecontraprestacion" action="../convenio/DetalleConvenio.php" method="post" enctype="multipart/form-data" >
        <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
        <input type="hidden" id="idconvenio" name="idconvenio" value="<?php echo $idconvenio;?>" />
        <input type="hidden" id="IdContraprestacion" name="IdContraprestacion" value="<?php echo $IdContraprestacion;?>" />
            <table cellpadding="3" width="60%" border="0" align="center">
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                    <?php 
                        $sql = "select NombreConvenio from Convenios where ConvenioId = '".$idconvenio."'";
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
                        <input type="text" value="<?php echo $IdUbicacionInstitucion; ?>" size="50" readonly="readonly"/>
                    </td>
                    <td>Tipo de Contraprestación:<span style="color: red;">*</span></td>
                    <td>
                        <?php 
                        $sqltipocontraprestacion = "select idsiq_contraprestacion, nombretipocontraprestacion from siq_contraprestacion where idsiq_contraprestacion = '".$idsiq_contraprestacion."'";
                        $valorestipocontraprestacion = $db->GetRow($sqltipocontraprestacion);
                        ?>
                        <input type="hidden" name="tipocontraprestacion" id="tipocontraprestacion" value="<?php echo $valorestipocontraprestacion['idsiq_contraprestacion'];?>" />
                        <input type="text" name="tipo_contraprestacion" id="tipo_contraprestacion" value="<?php echo $valorestipocontraprestacion['nombretipocontraprestacion'];?>" readonly="readonly" />    
                    </td>
                    <td>Estado:</td>
                    <td>
                       <select name="estado" id="estado">
                       <?php 
                            $sqlestado = "select codigoestado, nombreestado from estado where codigoestado <> '300';";
                            $valoresestado = $db->GetAll($sqlestado);
                            foreach($valoresestado as $datosetado)
                            {
                                if($datosetado['codigoestado']==$codigoestado)
                                {
                                ?>
                                <option selected="selected" value="<?php echo $datosetado['codigoestado']?>"><?php echo $datosetado['nombreestado']?></option>    
                                <?php 
                                }else
                                {
                                ?>
                                <option value="<?php echo $datosetado['codigoestado']?>"><?php echo $datosetado['nombreestado']?></option>                                
                                <?php    
                                }
                            }
                        ?>
                        </select> 
                    </td>
                   </tr>
                <tr>
                    <td>Tipo de practicante:</td>
                    <td>
                        <select name="tipopracticante" id="tipopracticante" >
                        <?php
                        $sqltipopracticante = "select IdTipoPracticante, NombrePracticante from TipoPracticantes where codigoestado = '100';";
                        $valorestipopracticante = $db->GetaLL($sqltipopracticante);
                        foreach($valorestipopracticante as $datostipopracticante)
                        {
                            if($datostipopracticante['IdTipoPracticante']==$IdTipoPracticante)
                            {
                                ?>
                                <option selected="selected" value="<?php echo $datostipopracticante['IdTipoPracticante']?>"><?php echo $datostipopracticante['NombrePracticante']?></option>
                                <?php
                            }else
                            {
                                ?>
                                <option value="<?php echo $datostipopracticante['IdTipoPracticante']?>"><?php echo $datostipopracticante['NombrePracticante']?></option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </td>
                    <td>Tipo de pago:</td>
                    <td>
                        <select name="tipopago" id="tipopago" >
                        <?php 
                        $sqltipopago = "select IdTipoPagoContraprestacion, NombrePagoContraprestacion from TipoPagoContraprestaciones where IdTipoPagoContraprestacion <> '3';";
                        $valorestipopago = $db->GetAll($sqltipopago);
                        foreach($valorestipopago as $datostipopago)
                        {
                            if($datostipopago['IdTipoPagoContraprestacion'] == $IdTipoPagocontraprestacion)
                            {
                            ?>
                            <option selected="selected" value="<?php echo $datostipopago['IdTipoPagoContraprestacion']?>"><?php echo $datostipopago['NombrePagoContraprestacion']?></option>
                            <?php 
                            }else
                            {
                               ?>
                                <option value="<?php echo $datostipopago['IdTipoPagoContraprestacion']?>"><?php echo $datostipopago['NombrePagoContraprestacion']?></option>
                                <?php 
                            }
                        }
                        ?>
                        </select> 
                    </td>
                    <td>Valor del pago</td>
                    <td>           
                        <input type="text" name="valorcontraprestacion" id="valorcontraprestacion" size="10" value="<?php echo (int)$ValorContraprestacion?>" class="required" onkeypress="return val_numero(event)" />
                    </td>
                </tr>  
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
            </table>
            <center>
            <table width="600" id="botones"><tr>
            <td>
            <input type="button" value="Guardar" onclick="validarDatosDetallesContraprestacion('#detallecontraprestacion');" /></td>
            <td align='right'>
            <form action="DetalleConvenio.php" method="post">
            <input type="hidden" id="Detalle" name="Detalle" value="<?php echo $idconvenio;?>" />
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