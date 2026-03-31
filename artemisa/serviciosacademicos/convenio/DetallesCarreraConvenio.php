<?php
session_start();
include_once ('../EspacioFisico/templates/template.php');
if(!isset ($_SESSION['MM_Username']))
{
    //header('Location: ../../consulta/facultades/consultafacultadesv22.htm');
    echo "No ha iniciado sesión en el sistema";
    exit();
}
$db = getBD();
$sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
$usuario = $db->Execute($sqlS);
$datosusuario =  $usuario->getarray();
$user = $datosusuario[0][0];

$idconvenio = $_POST['idconvenio'];
if(!isset ($idconvenio)){
    
    echo "<script>alert('Error de ingreso a los programas academicos'); location.href='ConveniosActivos.php'; </script>";    
}

if(!empty($_POST['Detalle']))
{
    $id = $_POST['Detalle'];
   
    $sql1="select idconveniocarrera, ConvenioId, codigocarrera, IdContraprestacion, codigoestado from conveniocarrera where idconveniocarrera = '".$id."'";
    
    $detalles = $db->Execute($sql1);
    $datodetalles =  $detalles->GetArray();
    foreach($datodetalles as $datos1)
    {
        $idconveniocarrera      = $datos1['idconveniocarrera'];
        $idconvenio             = $datos1['ConvenioId']; 
        $codigocarrera          = $datos1['codigocarrera'];
        $IdContraprestacion     = $datos1['IdContraprestacion'];
        $codigoestado           = $datos1['codigoestado'];
    }
}
else
{   
    if($_POST['Action_id']=='SaveData')
    {
        $idconveniocarrera      = $_POST['idconveniocarrera'];
        $idconvenio             = $_POST['ConvenioId']; 
        $codigocarrera          = $_POST['carrera'];
        $IdContraprestacion     = $_POST['IdContraprestacion'];
        $FechaUltimaModificacion  = date("Y-m-d H:i:s");
        $codigoestado           = $_POST['estado'];
        $UsuarioUltimaModificacion   = $user;
    
        $slq3="update conveniocarrera set codigocarrera = '".$codigocarrera."', FechaUltimaModificacion = '".$FechaUltimaModificacion."', UsuarioUltimaModificacion = '".$UsuarioUltimaModificacion."', codigoestado = '".$codigoestado."'  where idconveniocarrera = '".$idconveniocarrera."' and ConvenioId = '".$idconvenio."' and IdContraprestacion = '".$IdContraprestacion."'"; 
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
        <title>Detalles Carrera convenio</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesConvenios.js"></script> 
    </head>
    <body> 
        <div id="container">
        <center>
            <h1>DETALLE CARRERA CONVENIO</h1>
        </center>
        <form  id="detalleCarreraConvenio" name="detalleCarreraConvenio" method="post" enctype="multipart/form-data" >
        <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
        <input type="hidden" id="idconvenio" name="idconvenio" value="<?php echo $idconvenio;?>" />
        <input type="hidden" id="IdContraprestacion" name="IdContraprestacion" value="<?php echo $IdContraprestacion;?>" />
        <input type="hidden" id="idconveniocarrera" name="idconveniocarrera" value="<?php echo $idconveniocarrera;?>" />
            <table cellpadding="3" width="60%" border="0" align="center">
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <td>Carreras:</td>
                    <td>
                        <select id="carrera" name="carrera">
                            <?php
                                $sqlCarrera =" select codigocarrera, nombrecarrera from carrera where codigocarrera = '".$codigocarrera."'";
                                $valoresCarrera = $db->execute($sqlCarrera);
                                foreach($valoresCarrera as $datosCarrera)
                                {   
                                    ?>
                                    <option value="<?php echo $datosCarrera['codigocarrera']?>" selected="selected"><?php echo $datosCarrera['nombrecarrera']?></option>
                                    <?php
                                }
                            ?>
                            <?php
                                $sqlModalidad= "select codigomodalidadacademica from carrera where codigocarrera ='".$codigocarrera."'";
                                $valoreModalidad = $db->execute($sqlModalidad);
                                foreach($valoreModalidad as $datosModalidad)
                                {
                                    $modalidad = $datosModalidad['codigomodalidadacademica'];
                                }                          
                                $sqlCarrera =" select codigocarrera, nombrecarrera from carrera where codigomodalidadacademica = '".$modalidad."'";
                                $valoresCarrera = $db->execute($sqlCarrera);
                                foreach($valoresCarrera as $datosCarrera)
                                {   
                                    ?>
                                    <option value="<?php echo $datosCarrera['codigocarrera']?>"><?php echo $datosCarrera['nombrecarrera']?></option>
                                    <?php
                                }
                            ?>
                        
                        </select>                        
                    </td>
                    <td>Modalidad: </td>
                    <td>
                        <?php
                            $sqlModalidad = "select nombremodalidadacademica from modalidadacademica where codigomodalidadacademica = '".$modalidad."'";
                             $valoresModalidad = $db->execute($sqlModalidad);
                                foreach($valoresModalidad as $datosmodalidad)
                                {   
                                    ?>
                                    <label><?php echo $datosmodalidad['nombremodalidadacademica']?></label>
                                    <?php
                                }
                        ?>
                    </td>
                </tr>  
                <tr>
                <td>estado:</td>
                <td>
                <select name="estado" id="estado">
                       <?php 
                            $sqlestado = "select codigoestado, nombreestado from estado where codigoestado = '".$codigoestado."'";
                            $valoresestado = $db->execute($sqlestado);
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
                    <td colspan="4">
                    <hr />
                </td>
                </tr>
            </table>
            <center>
             <table width="600" id="botones"><tr><td>
            <input type="button" value="Guardar" onclick="validarDatosDetallesCarreraConvenio('#detalleCarreraConvenio');" /></td>
            <td align='right'><input type="button" value="Regresar" onclick="RegresarCarreraConvenio()" /></td>
            </tr>
            </table>
            </center>  
        </form>
    </div>
    <?php
       
    ?>
  </body>
</html>