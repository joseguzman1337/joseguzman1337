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
$usuario = $db->GetRow($sqlS);
$user = $usuario['idusuario'];
  
if(!empty($_POST['detalle']))
{
    $id = $_POST['detalle'];
    
    $sql1="SELECT u.IdUbicacionInstitucion, u.NombreUbicacion, u.codigoestado, u.idpais, u.idciudad, u.Direccion FROM UbicacionInstituciones u where u.IdUbicacionInstitucion = '".$id."'";
    
    $detalles = $db->Execute($sql1);
    $datodetalles =  $detalles->GetArray();
    foreach($datodetalles as $datos1)
    {
        $IdUbicacionInstitucion        = $datos1['IdUbicacionInstitucion'];
        $NombreUbicacion               = $datos1['NombreUbicacion']; 
        $codigoestado                  = $datos1['codigoestado'];
        $pais                          = $datos1['idpais'];
        $ciudad                        = $datos1['idciudad'];
        $Direccion                     = $datos1['Direccion'];
    }
}
else
{
    if($_POST['Action_id']=='SaveData')
    {
        $nombreubicacion               = $_POST['nombreubicacion']; 
        $estado                        = $_POST['estado'];
        $UbicacionInstitucion          = $_POST['IdUbicacionInstitucion'];
        $pais                          = $_POST['pais'];
        $ciudad                        = $_POST['ciudad'];
        $Direccion                     = $_POST['direccion'];
        
        $sql2="UPDATE UbicacionInstituciones SET NombreUbicacion = '".$nombreubicacion."', codigoestado = '".$estado."', idciudad = '".$ciudad."', idpais = '".$pais."', Direccion = '".$Direccion."' WHERE ( IdUbicacionInstitucion = '".$UbicacionInstitucion."')";
        if($Consulta=$db->Execute($sql2)===true)
        {
             $descrip = "No se guardaron los datos";
        }else
        {
           $descrip = "La ubicacion fue actualizada."; 
           //$descrip = $slq2;
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
        <title>Detalles Ubicacion Institucion</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesInstituciones.js"></script>
        <script>
        function val_texto(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[a-zA-ZñÑ\s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        
        function val_dirrecion(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron =/[0-9a-zA-ZñÑ-\s]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        
       </script>
             
    </head>
    <body> 
        <div id="container">
        <center>
            <h1>DETALLES UBICACION INSTITUCION</h1>
        </center>
        <form  id="detallesubicacion" action="../convenio/listaInstituciones.php" method="post" enctype="multipart/form-data" >
        <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
        <input type="hidden" id="IdUbicacionInstitucion" name="IdUbicacionInstitucion" value="<?php echo $id?>" />
            <table cellpadding="3" width="60%" border="0" align="center">
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Nombre Ubicacion:<span style="color: red;">*</span></td>
                    <td>
                        <input type="text" name="nombreubicacion" id="nombreubicacion" value="<?php echo $NombreUbicacion ?>" size="50" class="required" onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Estado:</td>
                    <td>
                       <select name="estado" id="estado">
                       <?php 
                            $sqlestado = "select codigoestado, nombreestado from estado where codigoestado = '".$codigoestado."'";
                            $valoresestado = $db->execute($sqlestado);
                            foreach($valoresestado as $datosetado)
                            {
                                if($datosetado['codigoestado'] == '100')
                                {
                                ?>
                                    <option value="100" selected="selected">Activo</option>
                                    <option value="200">Inactivo</option>
                                <?php    
                                }else
                                {
                                ?>
                                    <option value="100">Activo</option>
                                    <option value="200" selected="selected">Inactivo</option>
                                <?php
                                }                                
                            }
                        ?>
                        </select> 
                    </td>
                    </tr>
                    <tr>
                        <td>Pais:</td>
                        <td>
                            <select name="pais" id="pais">
                                <?php
                                    $slqpais = "select idpais, nombrecortopais from pais where idpais = '".$pais."'";
                                    $valorespais = $db->execute($slqpais);
                                    foreach($valorespais as $datospais)
                                    {
                                        ?>
                                        <option value="<?php echo $datospais['idpais'];?>"><?php echo $datospais['nombrecortopais'];?></option>
                                        <?php
                                    }
                                ?>                            
                            </select>
                        </td>
                        <td>Ciudad:</td>
                        <td>
                            <select name="ciudad" id="ciudad">
                                <?php
                                    $sqlciudad = "SELECT c.idciudad, c.nombreciudad FROM ciudad c JOIN departamento d ON d.iddepartamento = c.iddepartamento JOIN pais p ON p.idpais = d .idpais WHERE p.idpais = '".$pais."' ORDER BY nombreciudad ASC";
                                    $valoresciudad = $db->execute($sqlciudad);
                                    foreach($valoresciudad as $datosciudad)
                                    {
                                        if($ciudad == $datosciudad['idciudad'])
                                        {
                                            ?>
                                            <option value="<?php echo $datosciudad['idciudad'];?>" selected="selected"><?php echo $datosciudad['nombreciudad'];?></option>
                                            <?php
                                        }else
                                        {
                                            ?>
                                            <option value="<?php echo $datosciudad['idciudad'];?>"><?php echo $datosciudad['nombreciudad'];?></option>
                                            <?php
                                        }     
                                    }
                                ?>                            
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Dirrecion:</td>
                        <td>
                        <input type="text" name="direccion" id="direccion" value="<?php echo $Direccion ?>" size="50" class="required" onkeypress="return val_dirrecion(event)"/>
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
                <tr><td><input type="button" value="Guardar" onclick="validarDatosUbicacionDetalle('#detallesubicacion');" /></td>
                <td align='right'><input type="button" value="Regresar" onclick="Regresar()" /></td></tr>
                </table>
            </center>  
        </form>
    </div>
    <?php
       
    ?>
  </body>
</html>