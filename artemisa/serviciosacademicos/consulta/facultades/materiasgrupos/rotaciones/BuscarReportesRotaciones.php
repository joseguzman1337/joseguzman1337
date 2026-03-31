<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
    include_once ('../../../../EspacioFisico/templates/template.php');
    $db = getBD();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="pragma" content="no-cache"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Consulta rotaciones</title>
    </head>
    <body>
       <div align="center">
            <form name="f1" action="ReporteRotaciones.php" method="post">
				<input type="hidden" name="consulta" value="1" />
                <p class="Estilo3">CONSULTA ROTACIONES 
                </p>
                <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
                    <tr>
                        <td colspan="4" align="center" class="Estilo1" >
                            <label>Lugar de Rotación:</label>
                            <?php 
                                $sql= "SELECT IF(u.IdUbicacionInstitucion IS NULL, i.InstitucionConvenioId, u.IdUbicacionInstitucion) as ID, 
										u.NombreUbicacion, i.NombreInstitucion, i.InstitucionConvenioId,u.IdUbicacionInstitucion,
										IF(u.IdUbicacionInstitucion IS NULL, 2, 1) as Tipo
										FROM InstitucionConvenios i 
										LEFT JOIN UbicacionInstituciones u ON u.InstitucionConvenioId = i.InstitucionConvenioId";
                                $datos_modalidad=$db->GetAll($sql);
                               
                                $totaldatos=count($datos_modalidad);
                                if ($totaldatos>0){
                            ?>
                            <select name="ubicacion" id="ubicacion">
                                <option value=""></option>  
                                <?php
                                    foreach($datos_modalidad as $datos){
										$nombre = $datos['NombreInstitucion'];
										if($datos['NombreUbicacion']!=null && $datos['NombreUbicacion']!=""){
											$nombre .= ' ( '.$datos['NombreUbicacion'].' ) ';
										}
                                ?>
                                <option value="<?php echo $datos['InstitucionConvenioId'].'-'.$datos['IdUbicacionInstitucion'] ?>"><?php echo $nombre; ?></option>
                                <?php
                                    }
                                    }
                                ?>
                            </select>
                       <br /><br />
                           
                            <label>Seleccione el periodo</label>
                            <?php 
                                $sql1= 'SELECT codigoperiodo FROM periodo ORDER BY codigoperiodo DESC';
                                if($Consulta=&$db->Execute($sql1)===false){
                                    echo 'Error en el SQL de la Consulta....<br><br>'.$sql1;
                                    die;
                                }   
                                $valor_periodo = &$db->Execute($sql1);
                                $datos_periodo =  $valor_periodo->getarray();
                                $totaldatos=count($datos_periodo);
                                if ($totaldatos>0){
                            ?>
                            <select name="codigoperiodo" id="codigoperiodo">
                                <option value=""></option>  
                                <?php
                                    foreach($valor_periodo as $datos){
                                ?>
                                <option value="<?php echo $datos['codigoperiodo'] ?>"><?php echo $datos['codigoperiodo'] ?></option>
                                <?php
                                    }
                                    }
                                ?>
                            </select>
                       <br /><br />
                           
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" class="Estilo1">
                        <input name="buscar" type="submit" value="Buscar">&nbsp;
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>