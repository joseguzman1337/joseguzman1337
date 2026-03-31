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

$Id = $_POST['Detalle'];
if($Id)
{
   // echo $Id;
    $sqldatos = "SELECT c.nombrecarrera, m.nombremodalidadacademica, ac.RutaArchivo, ic.NombreInstitucion, ac.Cupos, ac.CodigoEstado FROM AcuerdoConvenios ac JOIN carrera c ON c.codigocarrera = ac.codigocarrera JOIN modalidadacademica m on m.codigomodalidadacademica = c.codigomodalidadacademica join InstitucionConvenios ic on ic.InstitucionConvenioId = ac.InstitucionConvenioId WHERE ac.AcuerdoConvenioId =  '".$Id."'";
    $datos = $db->execute($sqldatos);
    
    $modalidad = $datos->fields['nombremodalidadacademica'];
    $carrera = $datos->fields['nombrecarrera'];
    $archivo = $datos->fields['RutaArchivo'];
    $InstitucionId = $datos->fields['InstitucionConvenioId'];
    $NombreInstitucion = $datos->fields['NombreInstitucion'];
    $Cupos = $datos->fields['Cupos'];
    $estado = $datos->fields['CodigoEstado'];
    
    
}else
{
   ?>
   <script>
         alert('Error en los datos enviados.');
         location.href="../convenio/AcuerdosCarreras.php";  
   </script>
   <?php 
}



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" />
        <link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet"> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nuevo Acuerdos</title>
        
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.13.1/jquery.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesAcuerdos.js"></script>
        <script type="text/javascript" language="javascript" src="js/custom.js"></script>
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
                <h2>DETALLES ACUERDO</h2>
            </center>
            <form  id="nuevoacuerdo" name="nuevoacuerdo" method="post" enctype="multipart/form-data" >
                <input type="hidden" id="id" name="id" value="<?php echo $Id?>" /> 
                <input type="hidden" id="user" name="user" value="<?php echo $user;?>" />     
                <table id="expense_table" cellpadding="3" width="60%" border="0" align="center">
                    <tr>
                        <td colspan="4">
                            <hr /> 
                        </td>
                    </tr>                  
                    <tr>
                        <td>Modalidad</td>
                        <td>
                            <input type="text" name="modalidad" id="modalidad" value="<?php echo $modalidad?>" size="30%" readonly="true" />
                        </td>                        					
                        <td>Programa adscrito</td> 
                        <td>
                        <input type="text" name="programa" id="programa" value="<?php echo $carrera?>" size="60%" readonly="true"/>
                        </td>
                        <td></td> 
                    </tr>
                    <tr>
                        <td colspan="4">
                            <hr />
                        </td>
                    </tr>
                     <tr>
                     <td></td>
                     <td>Archivo: </td>
                     <td>
                        <a href="files/<?php echo $archivo?>"><img src='../mgi/images/file_document.png' width='50' height='37' border='0'/></a></td>                    
                    </tr>           
                    </table>
                    <table cellpadding="3" width="60%" border="0" align="center">     
                    <tr>
                        <td align='center'><strong>Institución</strong></td>
                        <td align='center'><strong>Cupos</strong></td>
                        <td align='center'><strong>Estado</strong></td>
                    </tr>
                    <tr>
                        <td  align='center'>
						<input type="text" name="institucion" id="institucion" style="width:80%" readonly="true" value="<?php echo $NombreInstitucion?>">
                        <input type="hidden" name="institucionid" id="institucionid" value="<?php echo $InstitucionId?>" />
                        </td>
                        <td  align='center'>
                        <input type="numb" name="cupos" id="cupos" value="<?php echo $Cupos ?>" onkeypress="return val_numero(event)"/>
                        </td>
                        <td  align='center'>
                            <select name="estado" id="estado">
                                <?php
                                if($estado == '100')
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
                    <table width="600" id="botones"><tr>
                    <td><input type="button" value="Guardar" onclick="guradarcambiosacuerdo()"></td>
                    <td align='right'><input type="button" value="Regresar" onclick="RegresarAcuerdo()" /></td>
                    </tr>
                    </table>
                    </center>
	
             </form>
        </div>

  </body>
</html>