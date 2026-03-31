<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    if(!isset ($_SESSION['MM_Username']))
    {
        //header('Location: ../../consulta/facultades/consultafacultadesv22.htm');
        echo "No ha iniciado sesión en el sistema";
        exit();
    }
    $db = getBD();
    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $usuario = $db->GetRow($sqlS);
    $user = $usuario['idusuario'];
    
    $idconvenio = $_POST['idconvenio'];
    $idconveniocarrera = $_POST['idconveniocarrera'];
    if(!isset ($idconveniocarrera)){
        echo "<script>alert('Error de ingreso a los detalles un programa academico'); location.href='ConveniosActivos.php'; </script>";    
    }
    $idcarrera = $_POST['Detalle'];
    function limpiarCadena($cadena) {
         $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
         return $cadena;
    }
    if(!empty($idcarrera))
    {  
        $sql1="select codigocarrera, nombrecarrera, codigomodalidadacademica, codigofacultad, codigosucursal, fechainiciocarrera, fechavencimientocarrera, codigotitulo  from carrera where codigocarrera = '".$idcarrera."'";
        $detallescarrera = $db->GetAll($sql1);
        foreach($detallescarrera as $datoscarrera)
        {
            $codigocarrera            = $datoscarrera['codigocarrera'];
            $nombrecarrera            = $datoscarrera['nombrecarrera']; 
            $modalidad                = $datoscarrera['codigomodalidadacademica'];
            $facultad                 = $datoscarrera['codigofacultad'];
            $sucursal                 = $datoscarrera['codigosucursal'];
            $fechainicio              = $datoscarrera['fechainiciocarrera'];
            $fechavencimiento         = $datoscarrera['fechavencimientocarrera'];
            $titulo                   = $datoscarrera['codigotitulo'];
        }
        
        $sql2="select idconveniocarrera, codigoestado from conveniocarrera where idconveniocarrera = '".$idconveniocarrera."'";
        $detalles = $db->GetRow($sql2);
        $codigoestado = $detalles['codigoestado'];
        $idconveniocarrera = $detalles['idconveniocarrera'];
    }else
    {
         if($_POST['Action_id']=='SaveData')
        {
            $idconveniocarrera      = $_POST['idconveniocarrera'];
            $FechaUltimaModificacion  = date("Y-m-d H:i:s");
            $codigoestado           = $_POST['estado'];
            $UsuarioUltimaModificacion   = $user;
            
            $idconveniocarrera = limpiarCadena(filter_var($idconveniocarrera,FILTER_SANITIZE_NUMBER_INT));
            $codigoestado = limpiarCadena(filter_var($codigoestado,FILTER_SANITIZE_NUMBER_INT));
            $UsuarioUltimaModificacion = limpiarCadena(filter_var($UsuarioUltimaModificacion,FILTER_SANITIZE_NUMBER_INT));
        
            $slq3="UPDATE conveniocarrera SET codigoestado='".$codigoestado."', UsuarioUltimaModificacion='".$UsuarioUltimaModificacion."', FechaUltimaModificacion ='".$FechaUltimaModificacion."'  WHERE (idconveniocarrera='".$idconveniocarrera."')"; 
             if($Consulta=$db->Execute($slq3)===true)
            {
                 $descrip = "No se guardaron los datos";
            }else
            {
               $descrip = "La carrera-convenio fue actualizada."; 
               //$descrip = $slq3;
            }
            $a_vectt['val']			=true;
            $a_vectt['descrip']		=$descrip;
            echo json_encode($a_vectt);
            exit;
        }//if($_POST['Action_id']=='SaveData')
    }      
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Detalles Programa Academico</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesConvenios.js"></script>     
    </head>
    <body> 
        <div id="container">
        <center>
            <h1>DETALLE PROGRAMA ACADEMICO</h1>
        </center>
        <form  id="detalleCarreraConvenio" name="detalleCarreraConvenio" method="post" enctype="multipart/form-data" >
        <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
        <input type="hidden" id="idconvenio" name="idconvenio" value="<?php echo $idconvenio;?>" />
        <input type="hidden" id="idconveniocarrera" name="idconveniocarrera" value="<?php echo $idconveniocarrera;?>" />
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
                <td>Nombre Carrera:</td>
                    <td>
                        <input name="nombrecarrera" id="nombrecarrera" value="<?php echo $nombrecarrera?>" size="40" readonly="readonly"/>
                    </td>
                    <td>Modalidad</td>
                    <td>
                        <?php
                            $sqlModalidad = "select nombremodalidadacademica from modalidadacademica where codigomodalidadacademica = '".$modalidad."'";
                             $valoresModalidad = $db->GetAll($sqlModalidad);
                                foreach($valoresModalidad as $datosmodalidad)
                                {   
                                    ?>
                                    <input name="modalidad" id="modalidad" value="<?php echo $datosmodalidad['nombremodalidadacademica']?>" size="40" readonly="readonly"/>
                                    <?php
                                }
                        ?>
                    </td>
                    <td>Facultad:
                    </td>
                    <td>
                        <?php 
                            $sqlfacultad = "select nombrefacultad from facultad where codigofacultad = '".$facultad."'";
                            $valoresFacultad = $db->GetAll($sqlfacultad);
                                foreach($valoresFacultad as $datosFacultad)
                                {   
                                    ?>
                                    <input name="facultad" id="facultad" value="<?php echo $datosFacultad['nombrefacultad']?>" size="30" readonly="readonly"/>
                                    <?php
                                }                            
                        ?>                        
                    </td>
                </tr>
                <tr>
                    <td>Sucursal:</td>
                    <td>
                        <?php 
                            $sqlsucursal = "select nombresucursal from sucursal where codigosucursal = '".$sucursal."'";
                            $valoressucursal = $db->GetAll($sqlsucursal);
                                foreach($valoressucursal as $datosSucursal)
                                {   
                                    ?>
                                    <input name="nombresucursal" id="nombresucursal" value="<?php echo $datosSucursal['nombresucursal']?>" size="30" readonly="readonly"/>
                                    <?php
                                }                            
                        ?>
                    </td>
                    <td>Fecha inicio:</td>
                    <td><input name="fechainicio" id="fechainicio" value="<?php echo $fechainicio?>" size="30" readonly="readonly"/></td>
                    <td>Fecha vencimiento</td>
                    <td><input name="fechavencimiento" id="fechavencimiento" value="<?php echo $fechavencimiento?>" size="30" readonly="readonly"/></td>
                </tr>
                <tr>
                    <td>Titulo que otorga:</td>
                    <td>
                        <?php 
                        $sqltitulo = "select nombretitulo from titulo where codigotitulo = '".$titulo."'";                        
                        $valorestitulo = $db->GetRow($sqltitulo);
                        ?>
                        <input name="nombretitulo" id="nombretitulo" value="<?php echo $valorestitulo['nombretitulo']?>" size="30" readonly="readonly"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <hr />
                </td>
                </tr>
                <tr>
                    <td>Estado</td>
                    <td>
                    <select name="estado" id="estado">
                       <?php 
                            $sqlestado = "select codigoestado, nombreestado from estado where codigoestado = '".$codigoestado."'";
                            $valoresestado = $db->GetAll($sqlestado);
                            foreach($valoresestado as $datosetado)
                            {
                                if($datosetado['codigoestado']=='100')
                                {
                                ?>
                                <option value="<?php echo $datosetado['codigoestado']?>"><?php echo $datosetado['nombreestado']?></option>
                                <option value="200">Inactivo</option>        
                                <?php 
                                }else
                                {
                                ?>
                                <option value="<?php echo $datosetado['codigoestado']?>"><?php echo $datosetado['nombreestado']?></option>
                                <option value="100">Activo</option>
                                <?php    
                                }
                                
                            }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                <td><input type="button" value="Guardar" onclick="validarDatosDetallesCarreraConvenio('#detalleCarreraConvenio');" /></td>  
                </tr>
            </table>
            </form>                              
            <table cellpadding="3" width="70%" border="0" align="center">
            <tr>
            <td>
            <form action="DetalleConvenio.php" method="post">
            <input type="hidden" id="Detalle" name="Detalle" value="<?php echo $idconvenio?>" />
            <input type="submit" value="Regresar" />
            </form>
            </td>
            </tr>
            </table>
    </div>
  </body>
</html>
<script>
    $('#detalleCarreraConvenio').click(function(event) {
    event.preventDefault();
    });
    $('#volver').click(function(event) {
    event.preventDefault();
    });
</script>

