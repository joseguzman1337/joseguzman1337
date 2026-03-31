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
    $id = $_POST['idconvenio'];
    $idtipoconvenio = $_POST['idtipoconvenio'];
    $idinstitucion = $_POST['idinstitucion'];
    if(!isset ($idtipoconvenio)){
        
        echo "<script>alert('Error de ingreso anexos'); location.href='ConveniosActivos.php'; </script>";    
    }
    
    switch($_POST['Action_id'])
    {
        case 'Carreras':
        {
            $Modalidad= $_POST['Modalidad'];
            Carreras($db,$Modalidad);
        }
        exit;
    }

    $sqlvalida = "SELECT idconveniocarrera FROM conveniocarrera where ConvenioId = '".$id."' and codigoestado = '100'";
    $validacarrera = $db->GetRow($sqlvalida);
    if($validacarrera['idconveniocarrera']==''){
    echo '<script language="javascript">alert("el convenio no tiene carreras disponibles.");</script>';
    echo '<script>document.location="Menuconvenios.php";</script>'; 
    } 


    function Carreras($db,$Modalidad){
        $id = $_REQUEST['id'];
        ?>
        <select name="carrera" id="carrera" onchange="SemestreCarreras()" required="required">
            <option value="-1">Elige</option>
            <?php 
            $sqlcarrera = "SELECT c.codigocarrera, c.nombrecarrera FROM carrera c, conveniocarrera cc WHERE codigomodalidadacademica = '".$Modalidad."' and cc.ConvenioId = '".$id."'
    AND fechavencimientocarrera > NOW() AND cc.codigocarrera = c.codigocarrera and cc.codigoestado = '100' ORDER BY nombrecarrera ASC";
            $valorescarreras = $db->execute($sqlcarrera);
            //echo $sqlcarrera;
            foreach($valorescarreras as $datoscarrera)
            {
                ?>
                <option value="<?php echo $datoscarrera['codigocarrera']?>"><?php echo $datoscarrera['nombrecarrera']?></option>
                <?php
            }                           
            ?>
        </select>
        <?PHP
    }//function Carreras 
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nuevo Anexo convenio</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesConvenios.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesAnexos.js"></script>
        <script>
        function val_texto(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[a-zA-ZñÑ\s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        
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
            <h1>NUEVO ANEXO CONVENIO</h1>
        </center>
        <form  id="nuevoanexo" name="nuevoanexo" method="post" action="AnexosConvenios_ajax.php" enctype="multipart/form-data" >
        <input type="hidden" id="actionID" name="actionID" value="SaveData" />
        <input type="hidden" id="idconvenio" name="idconvenio" value="<?php echo $id; ?>" />
		<input type="hidden" name="idtipoconvenio" id="idtipoconvenio" value="<?php echo $_REQUEST['idtipoconvenio']; ?>" />
		<input type="hidden" name="idinstitucion" id="idinstitucion" value="<?php echo $_REQUEST['idinstitucion']; ?>" />
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
                <td>
                    Tipo de Anexo:
                </td>
                <td>
                    <select name="tipoanexos" id="tipoanexos">
                         <?php
                        if(isset($_GET['busqueda']))
                        {                            
                            $sqlTipoanexo ="select nombretipoanexo from siq_tipoanexo where idsiq_tipoanexo='".$_GET['busqueda']."' AND codigoestado=100";
                            $valortipoanexo = $db->execute($sqlTipoanexo);
                            foreach($valortipoanexo as $datostipoanexo)
                            {
                                ?>                                
                                <option value="<?php echo $datostipoanexo['idsiq_tipoanexo']?>"><?php echo $datostipoanexo['nombretipoanexo']?></option>
                                <?php
                            }
                        }
                        ?>
                        <option value=""></option>
                        <?php
                        
                            $sqlTipoanexo ="select idsiq_tipoanexo, nombretipoanexo from siq_tipoanexo WHERE  codigoestado=100";
                            $valortipoanexo = $db->execute($sqlTipoanexo);
                            foreach($valortipoanexo as $datostipoanexo){
                                ?>
                                <option value="<?php echo $datostipoanexo['idsiq_tipoanexo']?>"><?php echo $datostipoanexo['nombretipoanexo']?></option>
                                <?php
                            }
                        ?>
                    </select>
                </td>
            </tr>
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
                    <tr>
                        <td id="div_Anexos" colspan="6"></td>
		      </tr>
              <tr>
                <td>
                    <input type="submit" value="Guardar" onclick="ValidarAnexo('#nuevoanexo')"/></td>
                </td>
              </tr>
            </table>
            </form>
            <table cellpadding="3" width="60%" border="0" align="center">
            <tr><td><form action="DetalleConvenio.php" method="post" id="volver">
            <input type="hidden" id="Detalle" name="Detalle" value="<?php echo $id; ?>" />
            <input type="submit" value="Regresar" />
        </form></td></tr></table>
            
               
              
    </div>
    <?php
    ?>
  </body>
</html>