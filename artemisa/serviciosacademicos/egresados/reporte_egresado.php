<?php
/*
* Caso 90158
* @modified Luis Dario Gualteros 
* <castroluisd@unbosque.edu.co>
 * Se modifica la variable session_start por la session_start( ) ya que es la funcion la que contiene el valor de la variable $_SESSION.
 * @since Mayo 18 de 2017
*/
session_start( );
//End Caso  90158
include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    $db = getBD();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Reportes</title>
<link rel="stylesheet" type="text/css" href="../estilos/sala.css">
<style>
    button,select , input[type="submit"], input[type="reset"], input[type="button"], .button {
    background-color: #ECF1F4;
    background-image: url("../../../../index.php?entryPoint=getImage&themeName=Sugar5&imageName=bgBtn.gif");
    border-color: #ABC3D7;
    color: #000000;
}
</style>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script> 
<script>
    function ReporteNew(id){
       
       location.href='New_Report_html.php?id='+id; 
    }
</script>
</head>
<body>
<table align="center" width="50%" style="" >
    <tr><td colspan="3">
            <div id="studiofields">
        <input class="button" type="button" onclick="document.location ='admin_egresado.php'" value="Regresar" name="addfieldbtn"/>
        </div>
        </td></tr>
    <tr><td colspan="3">Reportes de Egresados<hr></td></tr>
    <tr><td colspan="3">
            <table>
                <tr>
                    <td><a href="../consulta/facultades/graduar_estudiantes/importarDatosViejos/menu.php" title="Egresados Anteriores 2006">Egresados Anteriores 2006</td></tr>
                <tr>
                    <td><a href="../consulta/facultades/registro_graduados/listados/menu.php" title="Egresados Posteriores 2006">Egresados Posteriores 2006</td>
                 </tr>
                 <tr>
                    <td><strong><a onclick="ReporteNew('67,68,69,70,71,72');" style="cursor: pointer; color: #0080FF;" title="Click para reporte...">Autoevaluacion Institucional (RECIEN EGRESADOS,CONSOLIDACIÓN)</a></strong></td>
                </tr>
                 <tr>
                    <td><a href="resultado_gestion.php" title="Resultado de Gestion">Resultado de Gestión</td>
                 </tr>				 
				 <tr>
                    <td><strong><a onclick="ReporteNew('67,68,69');" style="cursor: pointer; color: #0080FF;" title="Click para reporte...">Recién Egresados</a></strong></td>
                </tr>			 
				 <tr>
                    <td><strong><a onclick="ReporteNew('70,71,72');" style="cursor: pointer; color: #0080FF;" title="Click para reporte...">Egresados en Consolidación</a></strong></td>
                </tr>
                 <?PHP 
                             $SQL='SELECT 

                            ins.idsiq_Ainstrumentoconfiguracion AS id,
                            ins.nombre
                            
                            FROM 
                            
                            siq_Ainstrumentoconfiguracion ins INNER JOIN actualizacionusuario act ON act.id_instrumento=ins.idsiq_Ainstrumentoconfiguracion																			
                            
                            WHERE  
                            
                            ins.cat_ins="EGRESADOS" 
                            AND 
                            ins.codigoestado =100 
                            AND
                            act.codigoestado=100
                            
                            
                            GROUP BY act.id_instrumento';
                            
                      if($InstruName=&$db->Execute($SQL)===false){
                        echo 'Error en la Consulta de los Name de los Instrumentos.....<br><br>'.$SQL;
                        die;
                      }
                      while(!$InstruName->EOF){
                        /***********************************************/
                        ?>
                        <tr>
                            <td><strong><a onclick="ReporteNew('<?PHP echo $InstruName->fields['id']?>');" style="cursor: pointer; color: #0080FF;" title="Click para reporte..."><?PHP echo $InstruName->fields['nombre'];?></a></strong></td>
                        </tr>
                        <?PHP
                        /***********************************************/
                        $InstruName->MoveNext();
                      }//while      
                 ?>
                 
            </table>
            </td>
            </tr>
</table>
</body>
</html>
