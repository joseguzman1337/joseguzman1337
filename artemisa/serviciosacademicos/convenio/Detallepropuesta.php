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
    $datosusuario = $db->GetRow($sqlS);
    $usuario =  $datosusuario['idusuario'];
    
    $detalle = $_POST['Detalle'];

    $sqldetalles = "SELECT Nombreconvenio, Representante, SupervisorBosque, SupervisorInstitucion, Estado, idsiq_tipoconvenio, InstitucionConvenioId, PaisId FROM Convenios WHERE ConvenioId  = '".$detalle."'";
    $detalles = $db->GEtRow($sqldetalles);
    
    $nombreconvenio = $detalles['Nombreconvenio'];
    $Representante = $detalles['Representante'];
    $SupervisorBosque = $detalles['SupervisorBosque'];
    $SupervisorInstitucion = $detalles['SupervisorInstitucion'];
    $InstitucionConvenioId = $detalles['InstitucionConvenioId'];
    $PaisId = $detalles['PaisId'];
    $idsiq_tipoconvenio = $detalles['idsiq_tipoconvenio'];
    $Estado = $detalles['Estado'];

    switch($_REQUEST['Action_id'])
    {
        case 'UpdateData':
        {
            $nombreconvenio = $_POST['nombreconvenio'];
            $representante = $_POST['representante'];
            $supervisorbosque =$_POST['supervisorbosque'];
            $supervisorinstitucion = $_POST['supervisorinstitucion'];
            $tipocontraprestacion = $_POST['tipocontraprestacion'];
            $fechamodificacion = date("Y-m-d H:i:s");
            $estado = $_POST['estado'];
            $tipoconvenio = $_POST['tipoconvenio'];
            $institucion = $_POST['institucion'];
            $pais = $_POST['pais'];
            $detalle = $_POST['detalle'];
            
            $sqlupdate = "UPDATE Convenios set NombreConvenio = '".$nombreconvenio."', Representante = '".$representante."', SupervisorBosque = '".$supervisorbosque."', SupervisorInstitucion='".$supervisorinstitucion."', Estado='".$estado."', idsiq_tipoconvenio='".$tipoconvenio."', InstitucionConvenioId='".$institucion."' where ConvenioId='".$detalle."'";
            $update = $db->execute($sqlupdate);
            $descrip =  $update;
         
         $a_vectt['val']			=true;
         $a_vectt['descrip']		=$descrip;
         echo json_encode($a_vectt);
         exit;
            
        }break;  
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nueva Propuesta</title>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesPropuestas.js"></script>
        <script>
            function Regresar()
            {
                location.href="../convenio/Propuestaconvenio.php";
            }
        </script>
    </head>
    <body>
        <div id="container">
            <center>
                <h2>DETALLES SOLICITUD DE CONVENIO</h2>
            </center>
            <form id="propuesta" name="propuesta" method="post" enctype="multipart/form-data">
                <input type="hidden" id="Action_id" name="Action_id" value="UpdateData" />
                <table cellpadding="3" width="60%" border="0" align="center" >
                    <tr>
                        <td colspan="5"><hr /></td>
                    </tr>
                    <tr>
                        <td>Nombre Convenio:</td>
                        <td><input type="text" name="nombreconvenio" id="nombreconvenio" size="50%" value="<?php echo $nombreconvenio;?>" readonly="readonly" />
                            <input type="hidden" name="detalle" id="detalle" value="<?php echo $detalle;?>" readonly="readonly" /></td>
                        <td></td>
                        <td>Representante</td>
                        <td><input type="text" name="representante" id="representante" size="50%" value="<?php echo $Representante; ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td>Nombre Supervisor U. el bosque</td>
                        <td><input type="text" name="supervisorbosque" id="supervisorbosque" size="50%" value="<?php echo $SupervisorBosque;?>" readonly="readonly" /></td>
                        <td></td>
                        <td>Nombre Supervisor Institución</td>
                        <td><input type="text" name="supervisorinstitucion" id="supervisorinstitucion" size="50%" value="<?php echo $SupervisorInstitucion; ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>    
                        <td>Institución</td>
                        <td colspan="4">
                            <select name="institucion" id="institucion">
                                <?php
                                    $sqlinstitucion = "select InstitucionConvenioId, NombreInstitucion from InstitucionConvenios";
                                    $instituciones = $db->execute($sqlinstitucion);
                                    foreach($instituciones as $datos)
                                    {
                                        if($InstitucionConvenioId ==$datos['InstitucionConvenioId'])
                                        {
                                            echo "<option value='".$datos['InstitucionConvenioId']."' selected='selected'>".$datos['NombreInstitucion']."</option>";
                                            echo "<option value=''></option>";
                                        }else
                                        {
                                            echo "<option value='".$datos['InstitucionConvenioId']."'>".$datos['NombreInstitucion']."</option>";     
                                        }
                                        
                                    } 
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>País</td>
                        <td>
                            <select name="pais" id="pais">
                                <option value=""></option>
                                <?php
                                    $sqlpais = "select idpais, nombrecortopais from pais where codigoestado='100'";
                                    $paices =$db->execute($sqlpais);
                                    foreach($paices as $datospais)
                                    {
                                        if($PaisId == $datospais['idpais'])
                                        {
                                            echo "<option value='".$datospais['idpais']."' selected='selected'>".$datospais['nombrecortopais']."</option>";
                                             echo "<option value=''></option>";
                                        }else
                                        {
                                            echo "<option value='".$datospais['idpais']."'>".$datospais['nombrecortopais']."</option>";
                                        }
                                    } 
                                ?>
                            </select>
                        </td>
                         <td></td>
                        <td>Tipo de convenio</td>
                        <td>
                            <select name="tipoconvenio" id="tipoconvenio">
                            <option value=""></option>
                            <?php
                                $sqltipoconvenio = "select idsiq_tipoconvenio, nombretipoconvenio from siq_tipoconvenio";
                                $datostipo = $db->execute($sqltipoconvenio);
                                foreach($datostipo as $tipos)
                                {
                                    if($idsiq_tipoconvenio == $tipos['idsiq_tipoconvenio'])
                                    {
                                        echo "<option value='".$tipos['idsiq_tipoconvenio']."' selected='selected'>".$tipos['nombretipoconvenio']."</option>";
                                        echo "<option value=''></option>";
                                    }else
                                    {
                                        echo "<option value='".$tipos['idsiq_tipoconvenio']."'>".$tipos['nombretipoconvenio']."</option>";
                                    }    
                                }
                            ?>
                            </select>
                        </td>
                    </tr>
                        <td>Estado</td>
                        <td>
                            <?php  if($usuario == '4186')
                            {
                                switch($Estado)
                                {
                                    case 'Aprobado':
                                    {
                                    ?>
                                    <select name="estado" id="estado">
                                        <option value="Aprobado" selected="selected">Aprobado</option>
                                        <option value=""></option>
                                        <option value="Solicitado">Solicitado</option>
                                        <option value="Rechazado">Rechazado</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                    <?php
                                    }break;
                                    case 'Solicitado':
                                    {
                                     ?>
                                    <select name="estado" id="estado">
                                        <option value="Solicitado" selected="selected">Solicitado</option>
                                        <option value=""></option>
                                        <option value="Aprobado">Aprobado</option>
                                        <option value="Rechazado">Rechazado</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                    <?php   
                                    }break;
                                    case 'Rechazado':
                                    {
                                     ?>
                                    <select name="estado" id="estado">
                                        <option value="Rechazado" selected="selected">Rechazado</option>
                                        <option value=""></option>
                                        <option value="Aprobado">Aprobado</option>
                                        <option value="Solicitado">Solicitado</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                    <?php   
                                    }break;
                                    case 'Inactivo':
                                    {
                                     ?>
                                    <select name="estado" id="estado">
                                        <option value="Inactivo" selected="selected">Inactivo</option>
                                        <option value=""></option>
                                        <option value="Aprobado">Aprobado</option>
                                        <option value="Solicitado">Solicitado</option>
                                        <option value="Rechazado">Rechazado</option>
                                    </select>
                                    <?php   
                                    }break;
                                }
                            }else
                            {
                                ?>
                                <input type="text" name="estado" id="estado" value="<?php echo $Estado;?>" readonly="readonly" />
                                 <?php
                            } ?>
                        </td>
                    <tr>
                    </tr>
                      <tr>
                        <td colspan="5"><hr /></td>
                    </tr>
                </table>
                <div>
                    <center>
                    <?php
                    if($usuario == '4186')
                    {
                        ?> <input type="button" id="Guardar" name="Guardar" value="Guardar" onclick="validardatospropuestaactualizar('#propuesta');"/><?php
                    } 
                    ?>
                        <input type="button" value="Regresar" onclick="Regresar()" />
                    </center>
                </div>
            </form>
        </div>
    </body>
</html>