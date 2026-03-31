<?php
session_start();
include_once('../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

class Documento_Ver {

    public function Principal($id_doc) {

        global $db, $userid, $C_Utils_monitoreo;
        ?>

        <style>
            fieldset {
                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                border-radius: 8px;
                border-color:#316FC0;
                border-style: solid;
                border-width: 1px;

            }
            legend {
                color: #316FC0; 
                font-size:14px;
                font-weight: bold;
                letter-spacing:-1px;
                padding-bottom:20px;
                padding-top:8px;
                text-transform:capitalize;
            }
            .Border{
                border:0px solid #000;
                padding:.5em;
            }
        </style>
        <html>
            <head>
                <title></title>        
            <div id="container">

            </head>  
            <body id="dt_example">
                <div id="container">
                    <div style="font-size:24px"><strong>Ver/Modificar Documentos</strong></div>      
                    <fieldset> 
                        <legend>Ver/Modificar Documentos</legend>
                        <div>
                            <?php
                            /* $SQL_Datos='SELECT 

                              Doc.idsiq_documento as id,
                              Doc.siqfactor_id,
                              Fac.nombre AS nom_factor,
                              Doc.siqcaracteristica_id,
                              Car.nombre AS nom_Carat,
                              Doc.siqaspecto_id,
                              Asp.nombre AS nom_aspecto,
                              Doc.siqindicador_id,
                              Ind.nombre AS nom_indicador,
                              Doc.estado,
                              date(Doc.fecha_ingreso) AS Fecha_carga,
                              date(Ind.fecha_proximo_vencimiento) AS fecha_ven,
                              Ind.idTipo,
                              Ind.es_objeto_analisis,
                              Ind.tiene_anexo,
                              Ind.idEstado,
                              Est.nombre AS estado



                              FROM

                              siq_documento AS Doc,
                              siq_factor AS Fac,
                              siq_caracteristica AS Car,
                              siq_aspecto AS Asp,
                              siq_indicador AS Ind,
                              siq_estadoIndicador  As Est

                              WHERE

                              Doc.idsiq_documento="'.$id_doc.'"
                              AND
                              Doc.siqfactor_id=Fac.idsiq_factor
                              AND
                              Doc.siqcaracteristica_id=Car.idsiq_caracteristica
                              AND
                              Doc.siqaspecto_id=Asp.idsiq_aspecto
                              AND
                              Doc.siqindicador_id=Ind.idsiq_indicador
                              AND
                              Doc.codigoestado=100
                              AND
                              Fac.codigoestado=100
                              AND
                              Car.codigoestado=100
                              AND
                              Asp.codigoestado=100
                              AND
                              Ind.codigoestado=100
                              AND
                              Ind.codigoestado=100
                              AND
                              Est.idsiq_estadoIndicador=Ind.idEstado'; */


                            $SQL_Datos = 'SELECT 
													Doc.idsiq_documento as id, 
													Doc.siqfactor_id, 
													Doc.siqcaracteristica_id, 
													Doc.siqaspecto_id, 
													Doc.siqindicador_id, 
													Gene.nombre AS nom_indicador, 
													Doc.estado, 
													date(Doc.fecha_ingreso) AS Fecha_carga, 
													date(Ind.fecha_proximo_vencimiento) AS fecha_ven, 
													Gene.idTipo, 
													Ind.es_objeto_analisis, 
													Ind.tiene_anexo, 
													Ind.idEstado, 
													Est.nombre AS estado, 
													Gene.idAspecto, 
													Ind.discriminacion, 
													Ind.idCarrera, 
													tipo.nombre, 
													Ind.es_objeto_analisis, 
													Ind.tiene_anexo,
													Gene.codigo 
													 
										FROM 
													siq_documento AS Doc, 
													siq_indicador AS Ind, 
													siq_estadoIndicador As Est, 
													siq_indicadorGenerico AS Gene ,
													siq_tipoIndicador AS tipo  
										
										WHERE 
													Doc.idsiq_documento="' . $id_doc . '"
													AND 
													Doc.siqindicador_id=Ind.idsiq_indicador 
													AND 
													Doc.codigoestado=100 
													AND 
													Ind.codigoestado=100 
													AND 
													Ind.codigoestado=100 
													AND 
													Est.idsiq_estadoIndicador=Ind.idEstado 
													AND 
													Gene.idsiq_indicadorGenerico=Ind.idIndicadorGenerico 
													AND 
													Gene.codigoestado=100
													AND 
													Gene.idTipo=tipo.idsiq_tipoIndicador';

                            if ($Result = &$db->Execute($SQL_Datos) === false) {
                                echo 'Error en el SQL De los Datos....<br>' . $SQL_Datos;
                                die;
                            }

                            $Datos_Ver = $Result->GetArray();

                            $SQL_OtherData = 'SELECT  

													siq_aspecto.idsiq_aspecto,
													siq_aspecto.idCaracteristica,
													siq_aspecto.nombre As aspecto_nom,
													siq_caracteristica.idsiq_caracteristica,
													siq_caracteristica.idFactor,
													siq_caracteristica.nombre As caracteristica_nom,
													siq_factor.idsiq_factor,
													siq_factor.nombre As factor_nom
										
										FROM 
										
													siq_aspecto,
													siq_caracteristica,
													siq_factor
										
										WHERE
										
													siq_aspecto.idsiq_aspecto="' . $Datos_Ver[0]['idAspecto'] . '"
													AND
													siq_aspecto.idCaracteristica=siq_caracteristica.idsiq_caracteristica
													AND
													siq_caracteristica.idFactor=siq_factor.idsiq_factor
													AND
													siq_aspecto.codigoestado=100
													AND
													siq_caracteristica.codigoestado=100
													AND
													siq_factor.codigoestado=100';

                            if ($Other_Data = &$db->Execute($SQL_OtherData) === false) {
                                echo 'Error en el SQL Other data ....<br>' . $SQL_OtherData;
                                die;
                            }

                            $OtherData = $Other_Data->GetArray();


                            switch ($Datos_Ver[0]['discriminacion']) {

                                case '1': {
                                        $Mas_data = '';
                                    }break;
                                case '2': {

                                        $SQL_falcutad = 'SELECT 
		
																codigofacultad,
																nombrefacultad
													
													FROM 
													
																facultad
													
													WHERE
													
																codigofacultad="' . $Datos_Ver[0]['idFacultad'] . '"';


                                        if ($Facultad = &$db->Execute($SQL_falcutad) === false) {
                                            echo 'Error en el SQL Facultad...<br>' . $SQL_falcutad;
                                            die;
                                        }

                                        $Mas_data = '  ::  ' . $Facultad->fields['nombrefacultad'];
                                    }break;
                                case '3': {

                                        $SQL_Carrera = 'SELECT 
		
															codigocarrera,
															nombrecarrera
													
													FROM 
													
															carrera
													
													WHERE
													
															codigocarrera="' . $Datos_Ver[0]['idCarrera'] . '"';

                                        if ($Carrera = &$db->Execute($SQL_Carrera) === false) {
                                            echo 'Error al Buscar la Carrera...<br>' . $SQL_Carrera;
                                            die;
                                        }

                                        $Mas_data = '  ::  ' . $Carrera->fields['nombrecarrera'];
                                    }break;
                            }





                            $SQL_Discriminacion = 'SELECT  

															idsiq_discriminacionIndicador,
															nombre
												
												FROM 
												
															siq_discriminacionIndicador
												
												WHERE
															codigoestado=100
															AND
															idsiq_discriminacionIndicador="' . $Datos_Ver[0]['discriminacion'] . '"';

                            if ($Discriminacion = &$db->Execute($SQL_Discriminacion) === false) {
                                echo 'Error en el SQL Discriminacion....<br>' . $SQL_Discriminacion;
                                die;
                            }
                            ?>
                            <form action="Modificar_carga.php" method="post" enctype="multipart/form-data" name="Principal">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0" >
                                    <tr>
                                        <td width="1%"><input type="hidden" id="User_id" name="User_id" value="<?php echo $userid ?>"><input type="hidden" name="modificar" id="modificar" value="0">&nbsp;<input type="hidden" id="id_Documento" name="id_Documento" value="<?php echo $id_doc ?>"><br /><input type="hidden" id="Analisi" name="Analisi" value="<?php echo $Datos_Ver[0]['es_objeto_analisis'] ?>" /><br /><input type="hidden" id="Anexo" name="Anexo"  value="<?php echo $Datos_Ver[0]['tiene_anexo'] ?>"/><br /><input type="hidden" id="Tipo_indicador" name="Tipo_indicador" value="<?php echo $Datos_Ver[0]['idTipo'] ?>" /></td>
                                        <td width="99%">
                                            <table  border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                                                <tr>
                                                    <td width="19%"><strong>Factor:</strong></td>
                                                    <td colspan="3" style="font-size:13px"><?php echo $OtherData[0]['factor_nom'] ?><input type="hidden" id="id_factor" name="id_factor" value="<?php echo $OtherData[0]['idsiq_factor'] ?>"></td>
                                                    <td width="6%">&nbsp;</td>
                                                    <td width="12%"><strong>Fecha Carga:</strong></td>
                                                    <td width="12%" align="center" style="font-size:13px"><?php echo $Datos_Ver[0]['Fecha_carga'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Caracteristica:</strong></td>
                                                    <td colspan="3" style="font-size:13px"><?php echo $OtherData[0]['caracteristica_nom'] ?><input type="hidden" id="id_Caract" name="id_Caract" value="<?php echo $OtherData[0]['idsiq_caracteristica'] ?>"></td>
                                                    <td>&nbsp;</td>
                                                    <td><strong>Fecha de Vencimiento:</strong></td>
                                                    <td align="center" style="font-size:13px"><?php echo $Datos_Ver[0]['fecha_ven'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Aspecto:</strong></td>
                                                    <td colspan="3" style="font-size:13px"><?php echo $OtherData[0]['aspecto_nom'] ?><input type="hidden" id="id_aspecto" name="id_aspecto" value="<?php echo $OtherData[0]['idsiq_aspecto'] ?>"></td>
                                                    <td>&nbsp;</td>
                                                    <td><strong>Estado:</strong></td>
                                                    <?php
                                                    if ($Datos_Ver[0]['idEstado'] == 1) {#Desactualizado
                                                        $Color = 'color:#FF0000';

                                                        $Radio_ver_Revision = 'disabled';
                                                        $Radio_ver_Rechazado = 'disabled';
                                                        $Radio_ver_Aprobado = 'disabled';
                                                    }
                                                    if ($Datos_Ver[0]['idEstado'] == 2) {#en proceso
                                                        $Color = 'color:#0000FF';

                                                        $Radio_ver_Revision = '';
                                                        $Radio_ver_Rechazado = 'disabled';
                                                        $Radio_ver_Aprobado = 'disabled';
                                                    }
                                                    if ($Datos_Ver[0]['idEstado'] == 3) {#en revision
                                                        $Color = 'color:#990099';

                                                        $Radio_ver_Revision = 'disabled';
                                                        $Radio_ver_Rechazado = '';
                                                        $Radio_ver_Aprobado = '';
                                                    }
                                                    if ($Datos_Ver[0]['idEstado'] == 4) {#actualizado
                                                        $Color = 'color:#009900';

                                                        $Radio_ver_Revision = 'disabled';
                                                        $Radio_ver_Rechazado = 'disabled';
                                                        $Radio_ver_Aprobado = 'disabled';
                                                    }
                                                    ?>
                                                    <td align="center"><blink><strong style="font-size:14px;<?php echo $Color ?>"><?php echo $Datos_Ver[0]['estado'] ?></strong></blink><input type="hidden" id="estato_actual" name="estato_actual" value="<?php echo $Datos_Ver[0]['idEstado'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Indicador:</strong></td>
                                                    <td colspan="3" style="font-size:13px"><?php echo $Datos_Ver[0]['nom_indicador'] . '  ::  ' . $Discriminacion->fields['nombre'] . $Mas_data; ?><input type="hidden" id="id_indicador" name="id_indicador" value="<?php echo $Datos_Ver[0]['siqindicador_id'] ?>"></td>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr >
                                                    <td ><strong>Tipo Indicador:</strong></td>
                                                    <td class="Border" colspan="3" style="font-size:13px"><?php echo $Datos_Ver[0]['nombre'] ?></td>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <?php
                                                if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 0 && $Datos_Ver[0]['tiene_anexo'] == 0) {
                                                    $Archivo = 'Principal';
                                                }
                                                if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 0) {
                                                    $Archivo = 'Principal &oacute; Analisis';
                                                }
                                                if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 1) {
                                                    $Archivo = 'Principal &oacute; Analisis &oacute; Anexo';
                                                }
                                                if ($Datos_Ver[0]['idTipo'] != 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 0) {
                                                    $Archivo = 'Analisis';
                                                }
                                                if ($Datos_Ver[0]['idTipo'] != 1 && $Datos_Ver[0]['es_objeto_analisis'] == 0 && $Datos_Ver[0]['tiene_anexo'] == 1) {
                                                    $Archivo = 'Anexo';
                                                }
                                                if ($Datos_Ver[0]['idTipo'] != 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 1) {
                                                    $Archivo = 'Analisis &oacute; Anexo';
                                                }
                                                if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 0 && $Datos_Ver[0]['tiene_anexo'] == 1) {
                                                    $Archivo = 'Principal &oacute; Anexo';
                                                }
                                                ?>
                                                <tr >
                                                    <td ><strong>Tipo Archivo:</strong></td>
                                                    <td class="Border" colspan="3" style="font-size:13px"><?php echo $Archivo ?></td>
                                                    <td class="Border" colspan="2">&nbsp;</td>
                                                </tr>
                                                <?php
                                                switch ($Datos_Ver[0]['discriminacion']) {
                                                    case '1': {
                                                            $Nombre = 'Institucional';
                                                            $Relacion = '&nbsp;&nbsp;';
                                                            $ver = ' style="visibility:collapse"';
                                                        }break;
                                                    case '2': {
                                                            $Nombre = 'Faculta';
                                                            $Relacion = '&nbsp;&nbsp;';
                                                            $ver = ' style="visibility:collapse"';
                                                        }break;
                                                    case '3': {
                                                            $Nombre = 'Programa';

                                                            $SQL_Carrera = 'SELECT 
							
																								codigocarrera,
																								nombrecarrera
																						
																						FROM 
																						
																								carrera
																						
																						WHERE
																						
																								codigocarrera="' . $Datos_Ver[0]['idCarrera'] . '"';

                                                            if ($Carrera = &$db->Execute($SQL_Carrera) === false) {
                                                                echo 'Error alBuscar la Carrera...<br>' . $SQL_Carrera;
                                                                die;
                                                            }

                                                            $Relacion = $Carrera->fields['nombrecarrera'];
                                                            $ver = '';
                                                        }break;
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>Discriminaci&oacute;n</strong></td>
                                                    <td class="Border"  colspan="3" style="font-size:13px"><?php echo $Nombre ?></td>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <?php
                                                #echo '<pre>';print_r($C_Utils_monitoreo);
                                                $Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db, $Datos_Ver[0]['siqindicador_id']);

                                                #echo '<pre>';print_r($Permisos);  

                                                if ($Permisos[1][0] == 1) {
                                                    $C_Permiso = 1; #Todos
                                                } else if ($Permisos[1][0] == 2 || $Permisos[1][0] == 3) {
                                                    $C_Permiso = 2; #ver
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="7">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" align="center">
                                                        <input type="button" value="Ver Archivos Adjuntos" style="font-size:12px" onClick="Open(<?php echo $id_doc ?>)" class="full_width big" title="Click para ver..." >

                                                        <div id="Contenedor_archivos" style="display:none;width:100%;">

                                                        </div>	        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">&nbsp;&nbsp;</td>
                                                </tr>
                                                <?php
                                                if ($C_Permiso == 1) {
                                                    ?>
                                                    <tr>
                                                        <td colspan="7">
                                                            <table border="0" width="100%">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td colspan="6"><input type="checkbox" id="Otro" onClick="Ver_Box()">Cargar Otro Documento</td>
                                                                </tr>
                                                                <tr id="Tr_Op" style="visibility:collapse"><!--style="visibility:collapse"-->
                                                                    <td >&nbsp;&nbsp;</td>
                                                                    <td colspan="6">
                                                                        <table border="0" width="100%"><!--tabla 1-->
                                                                            <tr>
                                                                                <td>

                                                                                    <br>
                                                                                    <table border="0"><!--Tabla3-->
                                                                                        <tr id="TR_Cargar" style="visibility:collapse"><!--TR_Cargar-->
                                                                                            <td>&nbsp;&nbsp;</td>
                                                                                            <td colspan="3" >
                                                                                                <table border="0"  cellpadding="0" cellspacing="0">
                                                                                                    <tr>
                                                                                                        <td align="left"><strong style="font-size:12px">&nbsp;&nbsp;Cargar Archivo:&nbsp;&nbsp;<span style="color:#F00">*</span></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>&nbsp;</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td align="left"><input type="file" id="file" name="file" height="80px" class="cajas" size="50"/><span id="tipoDoc" style="color:#000; font-size:9px">10 Mb Max / Word</span></td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                            <td align="center" colspan="3">
                                                                                                <table>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <strong style="font-size:12px">&nbsp;&nbsp;Tipo Archivo:</strong>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <select id="Tipo_Carga" name="Tipo_Carga" class="cajas" style="width:90%">
                                                                                                                <option value="-1">Elige...</option>
                                                                                                                <option value="1" onClick="validar_tipo('0');CambiarDoc('3')">Principal</option>
                                                                                                                <option value="2" onClick="validar_tipo('1');CambiarDoc('0')">An&aacute;lisis</option>
                                                                                                                <option value="3" onClick="validar_tipo('2');CambiarDoc('1')">Anexo</option>
                                                                                                            </select>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr><!--TR_Cargar-->
                                                                                    </table><!--Tabla3-->
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    <table border="0" width="100%">
                                                                                        <tr>
                                                                                            <td align="left"><strong>&nbsp;&nbsp;Descripcion del Archivo:&nbsp;&nbsp;<span style="color:#F00">*</span></strong></td>
                                                                                        </tr>
                                                                                        <tr>    
                                                                                            <td><textarea class="cajas" id="Descripcion" name="Descripcion" style="width:90%" cols="20" rows="10"></textarea></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table><!--Tabla 1-->
                                                                    </td>

                                                                </tr><!--Fin del TR Tr_Op-->
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="7">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        <table border="0" width="100%">
                                                            <tr>
                                                                <td colspan="2">
                                                                    &nbsp;
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_Modifcar">
                                                    <td colspan="2" align="center">
                                                        <table width="100%">
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            <td><!--<input type="button" id="Update" value="Modificar" onClick="Modificar()" class="full_width big" style="font-size:12px; display:none">--></td>

                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr id="tr_Cargar_New" style="visibility:collapse">
                                                    <td colspan="2" align="right"><input type="submit" id="Update" value="Modificar / Cargar."  class="full_width big" style="font-size:12px" onClick="return ValidarSubt()"></td>

                                                </tr>  
                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                </td>
                                </tr>
                                <tr>
                                    <td width="1%">&nbsp;</td>
                                    <td width="99%">&nbsp;</td>
                                </tr>    
                                </table>
                            </form>
                    </fieldset>  
                </div>    
        </div>     
        </body>
        </html>
        <?php
    }

    public function Archivos($idsiq_estructuradocumento, $id, $ver, $VF = '', $RH = '', $Fecha_ini = '', $Fecha_fin = '', $soloVer = false) {
        global $db, $C_Utils_monitoreo;

        $SQL_Indi = 'SELECT siqindicador_id FROM siq_documento WHERE idsiq_documento="' . $id . '" and codigoestado=100';

        if ($Indicador = &$db->Execute($SQL_Indi) === false) {
            echo 'Error en el SQL del Indicador ...<br>' . $SQL_Indi;
            die;
        }
        $Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db, $Indicador->fields['siqindicador_id']);

        if ($Permisos[1][0] == 1) {
            $C_Ver = 1; #Todos
        } else if ($Permisos[1][0] == 2 || $Permisos[1][0] == 3) {
            $C_Ver = 2; #ver
        }

        if ($Fecha_ini != '' && $Fecha_fin != '' && (strtotime($Fecha_ini) < strtotime($Fecha_fin))) {

            $BETWEEN = 'AND (a.fecha_carga BETWEEN "' . $Fecha_ini . '" AND  "' . $Fecha_fin . '" OR  a.changedate BETWEEN "' . $Fecha_ini . '" AND  "' . $Fecha_fin . '")';
        } else {
            $BETWEEN = '';
        }

        $SQL_Archivos = 'SELECT  
                a.idsiq_archivodocumento as id,
                a.nombre_archivo,
                a.file_size,
                a.tamano_unida,
                a.tipo_documento,
                a.fecha_carga,
                a.Ubicaicion_url,
                a.descripcion,
                a.version_final,
                a.extencion,
                a.rechazado,
                a.changedate,
                a.fecha_carga
            FROM siq_documento d 
            INNER JOIN siq_archivo_documento a ON d.idsiq_documento=a.siq_documento_id 
            WHERE a.siq_documento_id="' . $id . '"
                AND a.codigoestado=100
                AND d.idsiq_estructuradocumento = "'.$idsiq_estructuradocumento.'"
                ' . $BETWEEN . '
            ORDER BY a.tipo_documento,a.nombre_archivo ASC ';
        //d($SQL_Archivos);
        if ($Result_Archivos = &$db->Execute($SQL_Archivos) === false) {
            echo 'Error en el SQl de los Archivos...<br>' . $SQL_Archivos;
            die;
        }

        $Datos_Archivos = $Result_Archivos->GetArray();
        //echo '<pre>';print_r($Datos_Archivos);	die;
        #echo 'vf-->'.$VF;		
        //echo dirname($_SERVER['PHP_SELF']);
        ?>

        <img src="<?php echo dirname($_SERVER['PHP_SELF']) . "/../images/Close_Box_Red.png"; ?>"  style="cursor:pointer;" align="right" width="16" onClick="Close()">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <tr bgcolor="#D7D7D7">
                <td align="center" style="border:#FFFFFF groove 1px"><strong style=" font-size:12px">N&deg;</strong></td>
                <td align="center" style="border:#FFFFFF groove 1px"><strong style=" font-size:12px">Nombre Archivo o Link.</strong></td>
                <td align="center" style="border:#FFFFFF groove 1px"><strong style=" font-size:12px">Tama&ntilde;o del Archivo.</strong></td>
                <td align="center" style="border:#FFFFFF groove 1px"><strong style=" font-size:12px">Tipo de Documento.</strong></td>
                <td align="center" style="border:#FFFFFF groove 1px"><strong style=" font-size:12px">Fecha Carga.</strong></td>
                <td align="center" style="border:#FFFFFF groove 1px"><strong style=" font-size:12px">Fecha Modificaci&oacute;n.</strong></td>
                <td align="center" style="border:#FFFFFF groove 1px"><strong style=" font-size:12px">Opciones.</strong></td>
                <?php if (!$soloVer) { ?>
                    <td align="center" style="border:#FFFFFF groove 1px"><strong style=" font-size:12px">Última Versi&oacute;n.</strong></td>
                    <td align="center" style="border:#FFFFFF groove 1px"><strong style=" font-size:12px">Rechazado.</strong></td>
                <?php } ?>
            </tr>
            <input type="hidden" id="Num_Archivos" value="<?php echo count($Datos_Archivos) ?>">
            <?php
            //$j=count($Datos_Archivos);
            $j = 1;
            for ($i = 0; $i < count($Datos_Archivos); $i++) {

                $val = esPar($i + 1);
                if ($val == 0) {
                    $Color = 'bgcolor="#EFEFF1"';
                } else {
                    $Color = 'bgcolor="#DEDDF6"';
                }
                $estilo = "font-size:10px;";
                switch ($Datos_Archivos[$i]['tipo_documento']) {#1=Principal 2=analisis 3=Anexo
                    case '1': {
                            $Tipo_Doc = 'Principal';
                            $estilo = "font-size:10px;font-weight:bold;color:#222222;";
                        }break;
                    case '2': {
                            $Tipo_Doc = 'An&aacute;lisis';
                        }break;
                    case '3': {
                            $Tipo_Doc = 'Anexo';
                        }break;
                }
                ?>	
                <tr <?php echo $Color ?> style="<?php echo $estilo; ?>">
                    <td align="center" style="<?php echo $estilo; ?>" ><strong><?php echo $j++; ?></strong></td>
                    <?php
                    if ($Datos_Archivos[$i]['extencion']) {
                        ?>
                        <td>
                            <table border="0" width="100%" >
                                <tr>
                                    <td style="<?php echo $estilo; ?>"><?php echo $Datos_Archivos[$i]['nombre_archivo'] ?></td>
                                    <td align="right"><img src="<?php echo dirname($_SERVER['PHP_SELF']) . "/../images/eye.png"; ?>"  style="cursor:pointer;" title="Ver Descripcion..." onClick="Ventana_OPen('dialog_Document', '<?php echo $i ?>')" width="20">
                                        <div id="dialog_Document_<?php echo $i ?>" title="Descripcion del Documento" style="display:none">
                                            <div align="justify">
                                                <p><?php echo $Datos_Archivos[$i]['descripcion'] ?></p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <!-- modal content -->
                        </td>  
                        <?php
                    } else {
                        ?>
                        <td>
                            <table border="0" width="100%"  >
                                <tr>
                                    <td><a onClick="Ventana('<?php echo $Datos_Archivos[$i]['Ubicaicion_url'] ?>')" ><?php echo $Datos_Archivos[$i]['Ubicaicion_url'] ?></a></td>
                                    <td align="right"><img src="<?php echo dirname($_SERVER['PHP_SELF']) . "/../images/eye.png"; ?>" title="Ver Descripcion..." onClick="Ventana_OPen('dialog_link', '<?php echo $i ?>')" width="20">
                                        <div id="dialog_link_<?php echo $i ?>" title="Descripcion del Link" style="display:none">
                                            <div align="justify">
                                                <p><?php echo $Datos_Archivos[$i]['descripcion'] ?></p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <?php
                    }
                    ?>
                    <td align="center" style="font-size:10px;"><?php echo $Datos_Archivos[$i]['file_size'] . '&nbsp;' . $Datos_Archivos[$i]['tamano_unida'] ?></td>
                    <td align="center"><input type="hidden" id="Tipo_<?php echo $Datos_Archivos[$i]['id'] ?>" value="<?php echo $Datos_Archivos[$i]['tipo_documento'] ?>"><?php echo $Tipo_Doc ?></td>
                    <td align="center" style="font-size:10px;"><?php echo $Datos_Archivos[$i]['fecha_carga'] ?></td>
                    <td align="center" style="font-size:10px;"><?php echo $Datos_Archivos[$i]['changedate'] ?></td>
                    <td align="center">
                        <table border="0" width="100%" align="center">
                            <tr>
                                <?php
                                if ($Datos_Archivos[$i]['nombre_archivo']) {
                                    ?>
                                    <td align="center" ><img src="<?php echo dirname($_SERVER['PHP_SELF']) . "/../images/folder_apollon.png"; ?>" style="cursor:pointer;" title="Descargar." width="20" onClick="Download('<?php echo dirname($_SERVER['PHP_SELF']) . "/" . $Datos_Archivos[$i]['Ubicaicion_url'] ?>')"></td>
                                    <?php if ($C_Ver == 1) { ?><td align="center"><img style="padding-left:5px;" src="<?php echo dirname($_SERVER['PHP_SELF']) . "/../images/Close_Box_Red.png"; ?>" style="cursor:pointer;" title="Eliminar Documento." width="16" onClick="Eliminar(<?php echo $Datos_Archivos[$i]['id'] ?>, '<?php echo $id ?>', '0')"></td><?php } ?>
                                    <?php if ($C_Ver == 1) { ?><td align="center" ><a style="padding-left:5px;display:inline-block;" href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/editarDescripcion.php?archivo=<?php echo $Datos_Archivos[$i]['id'] ?>&doc=<?php echo $id; ?>"><img src="<?php echo dirname($_SERVER['PHP_SELF']) . "/../images/file_edit.png"; ?>" style="cursor:pointer;" title="Editar Descripción" width="16"/></a></td><?php } ?>
                                    <?php
                                } else {
                                    ?>
                                    <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td align="center">&nbsp;&nbsp;<?php if ($C_Ver == 1) { ?><img src="<?php echo dirname($_SERVER['PHP_SELF']) . "/../images/Close_Box_Red.png"; ?>" title="Eliminar URL." width="16" style="cursor:pointer;" onClick="Eliminar(<?php echo $Datos_Archivos[$i]['id'] ?>, '<?php echo $id ?>', '1')"><?php } ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                        </table>
                    </td>
                    <?php
                    if (!$soloVer) {
                        if ($VF == 1) {
                            if ($Datos_Archivos[$i]['version_final'] == 1) {
                                $Checkd = '<input type="checkbox" checked id="Avilita_' . $Datos_Archivos[$i]['id'] . '" onClick="AvilitarCheckd(' . $Datos_Archivos[$i]['id'] . ',' . $id . ')">';
                            } else {
                                $Checkd = '<input type="checkbox" id="Avilita_' . $Datos_Archivos[$i]['id'] . '" onClick="AvilitarCheckd(' . $Datos_Archivos[$i]['id'] . ',' . $id . ')">';
                            }
                        } else {
                            if ($Datos_Archivos[$i]['version_final'] == 1) {
                                $Checkd = '<input type="checkbox" checked id="Avilita_' . $Datos_Archivos[$i]['id'] . '" onClick="AvilitarCheckd(' . $Datos_Archivos[$i]['id'] . ',' . $id . ')"  disabled>';
                            } else {
                                $Checkd = '<input type="checkbox" id="Avilita_' . $Datos_Archivos[$i]['id'] . '" onClick="AvilitarCheckd(' . $Datos_Archivos[$i]['id'] . ',' . $id . ')" disabled>';
                            }
                        }
                        ?>
                        <td align="center"><?php echo $Checkd ?></td>
                        <?php
                        if ($RH == 1) {
                            if ($Datos_Archivos[$i]['rechazado'] == 1) {
                                $CheckdRechazo = '<input type="checkbox" checked id="Rechazo_' . $Datos_Archivos[$i]['id'] . '" onClick="AvilitarRechazo(' . $Datos_Archivos[$i]['id'] . ',' . $id . ')">';
                            } else {
                                $CheckdRechazo = '<input type="checkbox" id="Rechazo_' . $Datos_Archivos[$i]['id'] . '" onClick="AvilitarRechazo(' . $Datos_Archivos[$i]['id'] . ',' . $id . ')">';
                            }
                        } else {
                            if ($Datos_Archivos[$i]['rechazado'] == 1) {
                                $CheckdRechazo = '<input type="checkbox" checked id="Rechazo_' . $Datos_Archivos[$i]['id'] . '" onClick="AvilitarRechazo(' . $Datos_Archivos[$i]['id'] . ',' . $id . ')"  disabled>';
                            } else {
                                $CheckdRechazo = '<input type="checkbox" id="Rechazo_' . $Datos_Archivos[$i]['id'] . '" onClick="AvilitarRechazo(' . $Datos_Archivos[$i]['id'] . ',' . $id . ')" disabled>';
                            }
                        }
                        ?>
                        <td align="center"><?php echo $CheckdRechazo ?></td>
                    <?php } // if ver
                    ?>
                </tr>		
                <?php
            }
            ?>
        </table>
        <?php
    }

    public function New_Modificar($id_doc) {

        global $db, $userid, $C_Utils_monitoreo;
        ?>
        <style>
            fieldset {
                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                border-radius: 8px;
                border-color:#316FC0;
                border-style: solid;
                border-width: 1px;

            }
            legend {
                color: #316FC0; 
                font-size:14px;
                font-weight: bold;
                letter-spacing:-1px;
                padding-bottom:20px;
                padding-top:8px;
                text-transform:capitalize;
            }
            .Border{
                border:0px solid #000;
                padding:.5em;
            }
        </style>
        <html>
            <head>
                <title></title>        
            <div id="container">

            </head>  
            <body id="dt_example">
                <div id="container">
                    <div style="font-size:24px"><strong>Ver/Modificar Documentos</strong></div>      
                    <fieldset>  
                        <legend>Ver/Modificar Documentos</legend>
                        <div>
                            <?php
                            /* $SQL_Datos='SELECT 

                              Doc.idsiq_documento as id,
                              Doc.siqfactor_id,
                              Fac.nombre AS nom_factor,
                              Doc.siqcaracteristica_id,
                              Car.nombre AS nom_Carat,
                              Doc.siqaspecto_id,
                              Asp.nombre AS nom_aspecto,
                              Doc.siqindicador_id,
                              Ind.nombre AS nom_indicador,
                              Doc.estado,
                              date(Doc.fecha_ingreso) AS Fecha_carga,
                              date(Ind.fecha_proximo_vencimiento) AS fecha_ven,
                              Ind.idTipo,
                              Ind.es_objeto_analisis,
                              Ind.tiene_anexo,
                              Ind.idEstado,
                              Est.nombre AS estado



                              FROM

                              siq_documento AS Doc,
                              siq_factor AS Fac,
                              siq_caracteristica AS Car,
                              siq_aspecto AS Asp,
                              siq_indicador AS Ind,
                              siq_estadoIndicador  As Est

                              WHERE

                              Doc.idsiq_documento="'.$id_doc.'"
                              AND
                              Doc.siqfactor_id=Fac.idsiq_factor
                              AND
                              Doc.siqcaracteristica_id=Car.idsiq_caracteristica
                              AND
                              Doc.siqaspecto_id=Asp.idsiq_aspecto
                              AND
                              Doc.siqindicador_id=Ind.idsiq_indicador
                              AND
                              Doc.codigoestado=100
                              AND
                              Fac.codigoestado=100
                              AND
                              Car.codigoestado=100
                              AND
                              Asp.codigoestado=100
                              AND
                              Ind.codigoestado=100
                              AND
                              Ind.codigoestado=100
                              AND
                              Est.idsiq_estadoIndicador=Ind.idEstado'; */


                            $SQL_Datos = 'SELECT 
													Doc.idsiq_documento as id, 
													Doc.siqfactor_id, 
													Doc.siqcaracteristica_id, 
													Doc.siqaspecto_id, 
													Doc.siqindicador_id, 
													Gene.nombre AS nom_indicador, 
													Doc.estado, 
													date(Doc.fecha_ingreso) AS Fecha_carga, 
													date(Ind.fecha_proximo_vencimiento) AS fecha_ven, 
													Gene.idTipo, 
													Ind.es_objeto_analisis, 
													Ind.tiene_anexo, 
													Ind.idEstado, 
													Est.nombre AS estado, 
													Gene.idAspecto, 
													Ind.discriminacion, 
													Ind.idCarrera, 
													tipo.nombre, 
													Ind.es_objeto_analisis, 
													Ind.tiene_anexo,
													Gene.codigo 
													 
										FROM 
													siq_documento AS Doc, 
													siq_indicador AS Ind, 
													siq_estadoIndicador As Est, 
													siq_indicadorGenerico AS Gene ,
													siq_tipoIndicador AS tipo 
										
										WHERE 
													Doc.idsiq_documento="' . $id_doc . '"
													AND 
													Doc.siqindicador_id=Ind.idsiq_indicador 
													AND 
													Doc.codigoestado=100 
													AND 
													Ind.codigoestado=100 
													AND 
													Ind.codigoestado=100 
													AND 
													Est.idsiq_estadoIndicador=Ind.idEstado 
													AND 
													Gene.idsiq_indicadorGenerico=Ind.idIndicadorGenerico 
													AND 
													Gene.codigoestado=100
													AND 
													Gene.idTipo=tipo.idsiq_tipoIndicador';

                            if ($Result = &$db->Execute($SQL_Datos) === false) {
                                echo 'Error en el SQL De los Datos....<br>' . $SQL_Datos;
                                die;
                            }



                            $Datos_Ver = $Result->GetArray();

                            $SQL_OtherData = 'SELECT  

													siq_aspecto.idsiq_aspecto,
													siq_aspecto.idCaracteristica,
													siq_aspecto.nombre As aspecto_nom,
													siq_caracteristica.idsiq_caracteristica,
													siq_caracteristica.idFactor,
													siq_caracteristica.nombre As caracteristica_nom,
													siq_factor.idsiq_factor,
													siq_factor.nombre As factor_nom
										
										FROM 
										
													siq_aspecto,
													siq_caracteristica,
													siq_factor
										
										WHERE
										
													siq_aspecto.idsiq_aspecto="' . $Datos_Ver[0]['idAspecto'] . '"
													AND
													siq_aspecto.idCaracteristica=siq_caracteristica.idsiq_caracteristica
													AND
													siq_caracteristica.idFactor=siq_factor.idsiq_factor
													AND
													siq_aspecto.codigoestado=100
													AND
													siq_caracteristica.codigoestado=100
													AND
													siq_factor.codigoestado=100';

                            if ($Other_Data = &$db->Execute($SQL_OtherData) === false) {
                                echo 'Error en el SQL Other data ....<br>' . $SQL_OtherData;
                                die;
                            }


                            $OtherData = $Other_Data->GetArray();


                            switch ($Datos_Ver[0]['discriminacion']) {

                                case '1': {
                                        $Mas_data = '';
                                    }break;
                                case '2': {

                                        $SQL_falcutad = 'SELECT 
		
																codigofacultad,
																nombrefacultad
													
													FROM 
													
																facultad
													
													WHERE
													
																codigofacultad="' . $Datos_Ver[0]['idFacultad'] . '"';


                                        if ($Facultad = &$db->Execute($SQL_falcutad) === false) {
                                            echo 'Error en el SQL Facultad...<br>' . $SQL_falcutad;
                                            die;
                                        }

                                        $Mas_data = '  ::  ' . $Facultad->fields['nombrefacultad'];
                                    }break;
                                case '3': {

                                        $SQL_Carrera = 'SELECT 
		
															codigocarrera,
															nombrecarrera
													
													FROM 
													
															carrera
													
													WHERE
													
															codigocarrera="' . $Datos_Ver[0]['idCarrera'] . '"';

                                        if ($Carrera = &$db->Execute($SQL_Carrera) === false) {
                                            echo 'Error alBuscar la Carrera...<br>' . $SQL_Carrera;
                                            die;
                                        }

                                        $Mas_data = '  ::  ' . $Carrera->fields['nombrecarrera'];
                                    }break;
                            }





                            $SQL_Discriminacion = 'SELECT  

															idsiq_discriminacionIndicador,
															nombre
												
												FROM 
												
															siq_discriminacionIndicador
												
												WHERE
															codigoestado=100
															AND
															idsiq_discriminacionIndicador="' . $Datos_Ver[0]['discriminacion'] . '"';

                            if ($Discriminacion = &$db->Execute($SQL_Discriminacion) === false) {
                                echo 'Error en el SQL Discriminacion....<br>' . $SQL_Discriminacion;
                                die;
                            }
                            ?>
                            <form action="Modificar_carga.php" method="post" enctype="multipart/form-data" name="Principal">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0" >
                                    <tr>
                                        <td width="1%"><input type="hidden" id="User_id" name="User_id" value="<?php echo $userid ?>"><input type="hidden" name="modificar" id="modificar" value="0">&nbsp;<input type="hidden" id="id_Documento" name="id_Documento" value="<?php echo $id_doc ?>"><br /><input type="hidden" id="Analisi" name="Analisi" value="<?php echo $Datos_Ver[0]['es_objeto_analisis'] ?>" /><br /><input type="hidden" id="Anexo" name="Anexo"  value="<?php echo $Datos_Ver[0]['tiene_anexo'] ?>"/><br /><input type="hidden" id="Tipo_indicador" name="Tipo_indicador" value="<?php echo $Datos_Ver[0]['idTipo'] ?>" /></td>
                                        <td width="99%">
                                            <table  border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                                                <tr>
                                                    <td width="19%"><strong>Factor:</strong></td>
                                                    <td colspan="3" style="font-size:13px"><?php echo $OtherData[0]['factor_nom'] ?><input type="hidden" id="id_factor" name="id_factor" value="<?php echo $OtherData[0]['idsiq_factor'] ?>"></td>
                                                    <td width="6%">&nbsp;</td>
                                                    <td width="12%"><strong>Fecha Carga:</strong></td>
                                                    <td width="12%" align="center" style="font-size:13px"><?php echo $Datos_Ver[0]['Fecha_carga'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Caracteristica:</strong></td>
                                                    <td colspan="3" style="font-size:13px"><?php echo $OtherData[0]['caracteristica_nom'] ?><input type="hidden" id="id_Caract" name="id_Caract" value="<?php echo $OtherData[0]['idsiq_caracteristica'] ?>"></td>
                                                    <td>&nbsp;</td>
                                                    <td><strong>Fecha de Vencimiento:</strong></td>
                                                    <td align="center" style="font-size:13px"><?php echo $Datos_Ver[0]['fecha_ven'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Aspecto:</strong></td>
                                                    <td colspan="3" style="font-size:13px"><?php echo $OtherData[0]['aspecto_nom'] ?><input type="hidden" id="id_aspecto" name="id_aspecto" value="<?php echo $OtherData[0]['idsiq_aspecto'] ?>"></td>
                                                    <td>&nbsp;</td>
                                                    <td><strong>Estado:</strong></td>
                                                    <?php
                                                    if ($Datos_Ver[0]['idEstado'] == 1) {#Desactualizado
                                                        $Color = 'color:#FF0000';

                                                        $Radio_ver_Revision = 'disabled';
                                                        $Radio_ver_Rechazado = 'disabled';
                                                        $Radio_ver_Aprobado = 'disabled';
                                                    }
                                                    if ($Datos_Ver[0]['idEstado'] == 2) {#en proceso
                                                        $Color = 'color:#0000FF';

                                                        $Radio_ver_Revision = '';
                                                        $Radio_ver_Rechazado = 'disabled';
                                                        $Radio_ver_Aprobado = 'disabled';
                                                    }
                                                    if ($Datos_Ver[0]['idEstado'] == 3) {#en revision
                                                        $Color = 'color:#990099';

                                                        $Radio_ver_Revision = 'disabled';
                                                        $Radio_ver_Rechazado = '';
                                                        $Radio_ver_Aprobado = '';
                                                    }
                                                    if ($Datos_Ver[0]['idEstado'] == 4) {#actualizado
                                                        $Color = 'color:#009900';

                                                        $Radio_ver_Revision = 'disabled';
                                                        $Radio_ver_Rechazado = 'disabled';
                                                        $Radio_ver_Aprobado = 'disabled';
                                                    }
                                                    ?>
                                                    <td align="center"><blink><strong style="font-size:14px;<?php echo $Color ?>"><?php echo $Datos_Ver[0]['estado'] ?></strong></blink><input type="hidden" id="estato_actual" name="estato_actual" value="<?php echo $Datos_Ver[0]['idEstado'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Indicador:</strong></td>
                                                    <td colspan="3" style="font-size:13px"><?php echo $Datos_Ver[0]['nom_indicador'] . '  ::  ' . $Discriminacion->fields['nombre'] . $Mas_data; ?><input type="hidden" id="id_indicador" name="id_indicador" value="<?php echo $Datos_Ver[0]['siqindicador_id'] ?>"></td>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Codigo Indicador:</strong></td>
                                                    <td colspan="3" style="font-size:13px"><?php echo $Datos_Ver[0]['codigo'] ?></td>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr >
                                                    <td ><strong>Tipo Indicador:</strong></td>
                                                    <td class="Border" colspan="3" style="font-size:13px"><?php echo $Datos_Ver[0]['nombre'] ?></td>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <?php
                                                if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 0 && $Datos_Ver[0]['tiene_anexo'] == 0) {
                                                    $Archivo = 'Principal';
                                                }
                                                if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 0) {
                                                    $Archivo = 'Principal &oacute; Analisis';
                                                }
                                                if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 1) {
                                                    $Archivo = 'Principal &oacute; Analisis &oacute; Anexo';
                                                }
                                                if ($Datos_Ver[0]['idTipo'] != 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 0) {
                                                    $Archivo = 'Analisis';
                                                }
                                                if ($Datos_Ver[0]['idTipo'] != 1 && $Datos_Ver[0]['es_objeto_analisis'] == 0 && $Datos_Ver[0]['tiene_anexo'] == 1) {
                                                    $Archivo = 'Anexo';
                                                }
                                                if ($Datos_Ver[0]['idTipo'] != 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 1) {
                                                    $Archivo = 'Analisis &oacute; Anexo';
                                                }
                                                if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 0 && $Datos_Ver[0]['tiene_anexo'] == 1) {
                                                    $Archivo = 'Principal &oacute; Anexo';
                                                }
                                                ?>
                                                <tr >
                                                    <td ><strong>Tipo Archivo:</strong></td>
                                                    <td class="Border" colspan="3" style="font-size:13px"><?php echo $Archivo ?></td>
                                                    <td class="Border" colspan="2">&nbsp;</td>
                                                </tr>
                                                <?php
                                                switch ($Datos_Ver[0]['discriminacion']) {
                                                    case '1': {
                                                            $Nombre = 'Institucional';
                                                            $Relacion = '&nbsp;&nbsp;';
                                                            $ver = ' style="visibility:collapse"';
                                                        }break;
                                                    case '2': {
                                                            $Nombre = 'Faculta';
                                                            $Relacion = '&nbsp;&nbsp;';
                                                            $ver = ' style="visibility:collapse"';
                                                        }break;
                                                    case '3': {
                                                            $Nombre = 'Programa';

                                                            $SQL_Carrera = 'SELECT 
							
																								codigocarrera,
																								nombrecarrera
																						
																						FROM 
																						
																								carrera
																						
																						WHERE
																						
																								codigocarrera="' . $Datos_Ver[0]['idCarrera'] . '"';

                                                            if ($Carrera = &$db->Execute($SQL_Carrera) === false) {
                                                                echo 'Error alBuscar la Carrera...<br>' . $SQL_Carrera;
                                                                die;
                                                            }

                                                            $Relacion = $Carrera->fields['nombrecarrera'];
                                                            $ver = '';
                                                        }break;
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>Discriminaci&oacute;n</strong></td>
                                                    <td class="Border"  colspan="3" style="font-size:13px"><?php echo $Nombre ?></td>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <?php
                                                #echo '<pre>';print_r($C_Utils_monitoreo);
                                                $Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db, $Datos_Ver[0]['siqindicador_id']);

                                                #echo '<pre>';print_r($Permisos);  

                                                if ($Permisos[1][0] == 1) {
                                                    $C_Permiso = 1; #Todos
                                                } else if ($Permisos[1][0] == 2 || $Permisos[1][0] == 3) {
                                                    $C_Permiso = 2; #ver
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="7">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" align="center">
                                                        <input type="button" value="Ver Archivos Adjuntos" style="font-size:12px" onClick="Open(<?php echo $id_doc ?>)" class="full_width big" title="Click para ver..." >

                                                        <div id="Contenedor_archivos" style="display:none;width:100%">

                                                        </div>	        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">&nbsp;&nbsp;</td>
                                                </tr>
                                                <?php
                                                if ($C_Permiso == 1) {
                                                    ?>
                                                    <tr>
                                                        <td colspan="7">
                                                            <table border="0" width="100%">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td colspan="6"><input type="checkbox" id="Otro" onClick="Ver_Box()">Cargar Otro Documento</td>
                                                                </tr>
                                                                <tr id="Tr_Op" style="visibility:collapse"><!--style="visibility:collapse"-->
                                                                    <td >&nbsp;&nbsp;</td>
                                                                    <td colspan="6">
                                                                        <table border="0" width="100%"><!--tabla 1-->
                                                                            <tr>
                                                                                <td>
                                                                                    <br>
                                                                                    <table border="0"><!--Tabla3-->
                                                                                        <tr id="TR_Cargar" style="visibility:collapse"><!--TR_Cargar-->
                                                                                            <td>&nbsp;&nbsp;</td>
                                                                                            <td colspan="3" >
                                                                                                <table border="0"  cellpadding="0" cellspacing="0">
                                                                                                    <tr>
                                                                                                        <td align="left"><strong style="font-size:12px">&nbsp;&nbsp;Cargar Archivo:&nbsp;&nbsp;<span style="color:#F00">*</span></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>&nbsp;</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td align="left"><input type="file" id="file" name="file" height="80px" class="cajas" size="50"/><span id="tipoDoc" style="color:#000; font-size:9px">10 Mb Max / Word</span></td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                            <td align="center" colspan="3">
                                                                                                <table>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <strong style="font-size:12px">&nbsp;&nbsp;Tipo Archivo:</strong>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <select id="Tipo_Carga" name="Tipo_Carga" class="cajas" style="width:90%">
                                                                                                                <option value="-1">Elige...</option>
                                                                                                                <option value="1" onClick="validar_tipo('0');CambiarDoc('3')">Principal</option>
                                                                                                                <option value="2" onClick="validar_tipo('1');CambiarDoc('0')">An&aacute;lisis</option>
                                                                                                                <option value="3" onClick="validar_tipo('2');CambiarDoc('1')">Anexo</option>
                                                                                                            </select>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr><!--TR_Cargar-->
                                                                                    </table><!--Tabla3-->
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    <table border="0" width="100%">
                                                                                        <tr>
                                                                                            <td align="left"><strong>&nbsp;&nbsp;Descripcion del Archivo:&nbsp;&nbsp;<span style="color:#F00">*</span></strong></td>
                                                                                        </tr>
                                                                                        <tr>    
                                                                                            <td><textarea class="cajas" id="Descripcion" name="Descripcion" style="width:90%" cols="20" rows="10"></textarea></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table><!--Tabla 1-->
                                                                    </td>

                                                                </tr><!--Fin del TR Tr_Op-->
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="7">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        <table border="0" width="100%">
                                                            <tr>
                                                                <td colspan="2">
                                                                    &nbsp;
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_Modifcar">
                                                    <td colspan="2" align="center">
                                                        <table width="100%">
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            <td><!--<input type="button" id="Update" value="Modificar" onClick="Modificar_new()" class="full_width big" style="font-size:12px; display:none">--></td>
                                                                <td>&nbsp;</td>
                                                                <td> <!--<input type="button" id="Salir" value="Salir" onClick="afuera()" class="full_width big" style="font-size:12px">--></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr id="tr_Cargar_New" style="visibility:collapse">
                                                    <td colspan="2" align="right"><input type="submit" id="Update" value="Modificar / Cargar."  class="full_width big" style="font-size:12px" onClick="return ValidarSubt()"></td>
                                                    <td>&nbsp;</td>
                                                    <td> <input type="button" id="Salir" value="Salir" onClick="afuera()" class="full_width big" style="font-size:12px"></td>
                                                    <td>&nbsp;</td>
                                                </tr>  
                                                <tr>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                </td>
                                </tr>
                                <tr>
                                    <td width="1%">&nbsp;</td>
                                    <td width="99%">&nbsp;</td>
                                </tr>    
                                </table>
                            </form>
                    </fieldset>
                </div>    
        </div>     
        </body>
        </html>
        <?php
    }

    public function Ver($id_doc, $VF = '', $RH = '', $Fecha_ini = '', $Fecha_fin = '', $idInd = "", $idsiq_estructuradocumento="") {
        global $db, $userid;
        ?> 
        <style>
            fieldset {
                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                border-radius: 8px;
                border-color:#316FC0;
                border-style: solid;
                border-width: 1px;

            }
            legend {
                color: #316FC0; 
                font-size:14px;
                font-weight: bold;
                letter-spacing:-1px;
                padding-bottom:20px;
                padding-top:8px;
                text-transform:capitalize;
            }
            .Border{
                border:0px solid #000;
                padding:.5em;
            }
        </style>
        <html>
            <head>
                <title></title>        
            <div id="container">

            </head>  
            <body id="dt_example">
                <div id="container">
                    <div style="font-size:24px"><strong>Ver Documentos</strong></div>      
                    <fieldset> 
                        <legend>Ver Documentos</legend>
                        <div>
                            <?php
                            if ($id_doc == "") {
                                $SQL_Datos = 'SELECT 
                                            -1 as id, 
                                            fac.idsiq_factor as siqfactor_id, 
                                            car.idsiq_caracteristica as siqcaracteristica_id, 
                                            asp.idsiq_aspecto as siqaspecto_id, 
                                            Ind.idsiq_indicador as siqindicador_id, 
                                            Gene.nombre AS nom_indicador, 
                                            Gene.descripcion AS desc_indicador, 
                                            "" as estado, 
                                            "" AS Fecha_carga, 
                                            date(Ind.fecha_proximo_vencimiento) AS fecha_ven, 
                                            Gene.idTipo, 
                                            Ind.es_objeto_analisis, 
                                            Ind.tiene_anexo, 
                                            Ind.idEstado, 
                                            Est.nombre AS estado,
                                            Gene.idAspecto,
                                            Ind.discriminacion,
                                            Ind.idCarrera,
                                            tipo.nombre, 
                                            Ind.es_objeto_analisis, 
                                            Ind.tiene_anexo,
                                            Gene.codigo 
                                        FROM 
                                            siq_indicador AS Ind, 
                                            siq_estadoIndicador As Est, 
                                            siq_indicadorGenerico AS Gene ,
                                            siq_aspecto as asp,
                                            siq_caracteristica as car,
                                            siq_factor as fac,
                                            siq_tipoIndicador AS tipo

                                        WHERE 
                                            Ind.idsiq_indicador="' . $idInd . '"
                                            AND  Ind.codigoestado=100 
                                            AND Ind.codigoestado=100 
                                            AND Est.idsiq_estadoIndicador=Ind.idEstado 
                                            AND Gene.idsiq_indicadorGenerico=Ind.idIndicadorGenerico 
                                            AND Gene.codigoestado=100
                                            AND Gene.idTipo=tipo.idsiq_tipoIndicador
                                            AND asp.idsiq_aspecto=Gene.idAspecto
                                            AND car.idsiq_caracteristica=asp.idCaracteristica
                                            AND fac.idsiq_factor=car.idFactor';
                                // var_dump($SQL_Datos);
                            } else {

                                $SQL_Datos = 'SELECT
                                        Doc.idsiq_documento as id, 
                                        Doc.siqfactor_id, 
                                        Doc.siqcaracteristica_id, 
                                        Doc.siqaspecto_id, 
                                        Doc.siqindicador_id, 
                                        Gene.nombre AS nom_indicador, 
                                        Gene.descripcion AS desc_indicador, 
                                        Doc.estado, 
                                        date(Doc.fecha_ingreso) AS Fecha_carga, 
                                        date(Ind.fecha_proximo_vencimiento) AS fecha_ven, 
                                        Gene.idTipo, 
                                        Ind.es_objeto_analisis, 
                                        Ind.tiene_anexo, 
                                        Ind.idEstado, 
                                        Est.nombre AS estado,
                                        Gene.idAspecto,
                                        Ind.discriminacion,
                                        Ind.idCarrera,
                                        tipo.nombre, 
                                        Ind.es_objeto_analisis, 
                                        Ind.tiene_anexo,
                                        Gene.codigo 
                                    FROM  siq_documento AS Doc, 
                                        siq_indicador AS Ind, 
                                        siq_estadoIndicador As Est, 
                                        siq_indicadorGenerico AS Gene ,
                                        siq_tipoIndicador AS tipo
                                    WHERE  Doc.idsiq_documento="' . $id_doc . '"
                                        AND Doc.siqindicador_id=Ind.idsiq_indicador 
                                        AND Doc.codigoestado=100 
                                        AND Ind.codigoestado=100 
                                        AND Ind.codigoestado=100 
                                        AND Est.idsiq_estadoIndicador=Ind.idEstado 
                                        AND Gene.idsiq_indicadorGenerico=Ind.idIndicadorGenerico 
                                        AND Gene.codigoestado=100
                                        AND Gene.idTipo=tipo.idsiq_tipoIndicador';
                            }
                            if ($Result = &$db->Execute($SQL_Datos) === false) {
                                echo 'Error en el SQL De los Datos....<br>' . $SQL_Datos;
                                die;
                            }

                            $Datos_Ver = $Result->GetArray();

                            $SQL_OtherData = 'SELECT
                                    siq_aspecto.idsiq_aspecto,
                                    siq_aspecto.idCaracteristica,
                                    siq_aspecto.nombre As aspecto_nom,
                                    siq_caracteristica.idsiq_caracteristica,
                                    siq_caracteristica.descripcion as descCaracteristica,
                                    siq_caracteristica.idFactor,
                                    siq_caracteristica.nombre As caracteristica_nom,
                                    siq_factor.idsiq_factor,
                                    siq_factor.nombre As factor_nom
                                FROM siq_aspecto,
                                    siq_caracteristica,
                                    siq_factor
                                WHERE siq_aspecto.idsiq_aspecto="' . $Datos_Ver[0]['idAspecto'] . '"
                                    AND siq_aspecto.idCaracteristica=siq_caracteristica.idsiq_caracteristica
                                    AND siq_caracteristica.idFactor=siq_factor.idsiq_factor
                                    AND siq_aspecto.codigoestado=100
                                    AND siq_caracteristica.codigoestado=100
                                    AND siq_factor.codigoestado=100';

                            if ($Other_Data = &$db->Execute($SQL_OtherData) === false) {
                                echo 'Error en el SQL Other data ....<br>' . $SQL_OtherData;
                                die;
                            }

                            $OtherData = $Other_Data->GetArray();


                            switch ($Datos_Ver[0]['discriminacion']) {

                                case '1': {
                                        $Mas_data = '';
                                    }break;
                                case '2': {

                                        $SQL_falcutad = 'SELECT
                                                codigofacultad,
                                                nombrefacultad
                                            FROM facultad
                                            WHERE codigofacultad="' . $Datos_Ver[0]['idFacultad'] . '"';


                                        if ($Facultad = &$db->Execute($SQL_falcutad) === false) {
                                            echo 'Error en el SQL Facultad...<br>' . $SQL_falcutad;
                                            die;
                                        }

                                        $Mas_data = '  ::  ' . $Facultad->fields['nombrefacultad'];
                                    }break;
                                case '3': {

                                        $SQL_Carrera = 'SELECT 
                                                codigocarrera,
                                                nombrecarrera
                                            FROM carrera
                                            WHERE codigocarrera="' . $Datos_Ver[0]['idCarrera'] . '"';

                                        if ($Carrera = &$db->Execute($SQL_Carrera) === false) {
                                            echo 'Error alBuscar la Carrera...<br>' . $SQL_Carrera;
                                            die;
                                        }

                                        $Mas_data = '  ::  ' . $Carrera->fields['nombrecarrera'];
                                    }break;
                            }
                            
                            $SQL_Discriminacion = 'SELECT 
                                    idsiq_discriminacionIndicador,
                                    nombre
                                FROM siq_discriminacionIndicador
                                WHERE codigoestado=100
                                    AND idsiq_discriminacionIndicador="' . $Datos_Ver[0]['discriminacion'] . '"';

                            if ($Discriminacion = &$db->Execute($SQL_Discriminacion) === false) {
                                echo 'Error en el SQL Discriminacion....<br>' . $SQL_Discriminacion;
                                die;
                            }
                            ?>

                            <table border="0" width="100%" cellpadding="0" cellspacing="0" >
                                <tr>
                                    <td width="1%"><input type="hidden" id="User_id" name="User_id" value="<?php echo $userid ?>"><input type="hidden" name="modificar" id="modificar" value="0">&nbsp;<input type="hidden" id="id_Documento" name="id_Documento" value="<?php echo $id_doc ?>"><br /><input type="hidden" id="Analisi" name="Analisi" value="<?php echo $Datos_Ver[0]['es_objeto_analisis'] ?>" /><br /><input type="hidden" id="Anexo" name="Anexo"  value="<?php echo $Datos_Ver[0]['tiene_anexo'] ?>"/><br /><input type="hidden" id="Tipo_indicador" name="Tipo_indicador" value="<?php echo $Datos_Ver[0]['idTipo'] ?>" /></td>
                                    <td width="99%">
                                        <table  border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                                            <tr>
                                                <td width="19%"><strong>Factor:</strong></td>
                                                <td colspan="3" style="font-size:13px"><?php echo $OtherData[0]['factor_nom'] ?><input type="hidden" id="id_factor" name="id_factor" value="<?php echo $OtherData[0]['idsiq_factor'] ?>"></td>
                                                <td width="6%">&nbsp;</td>
                                                <td width="12%"><strong>Fecha Carga:</strong></td>
                                                <td width="12%" align="center" style="font-size:13px"><?php echo $Datos_Ver[0]['Fecha_carga'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Caracteristica:</strong></td>
                                                <td colspan="3" style="font-size:13px"><?php echo $OtherData[0]['caracteristica_nom'] ?><input type="hidden" id="id_Caract" name="id_Caract" value="<?php echo $OtherData[0]['idsiq_caracteristica'] ?>"></td>
                                                <td>&nbsp;</td>
                                                <td><strong>Fecha de Vencimiento:</strong></td>
                                                <td align="center" style="font-size:13px"><?php echo $Datos_Ver[0]['fecha_ven'] ?></td>
                                            </tr>
                                            <tr><td colspan="7">&nbsp;</td></tr>
                                            <tr>
                                                <td><strong>Descripción de la característica:</strong></td>
                                                <td colspan="6" style="font-size: 13px;"><?php echo $OtherData[0]['descCaracteristica']; ?></td>
                                            </tr>
                                            <tr><td colspan="7">&nbsp;</td></tr>
                                            <tr>
                                                <td><strong>Aspecto:</strong></td>
                                                <td colspan="3" style="font-size:13px"><?php echo $OtherData[0]['aspecto_nom'] ?><input type="hidden" id="id_aspecto" name="id_aspecto" value="<?php echo $OtherData[0]['idsiq_aspecto'] ?>"></td>
                                                <td colspan="2">&nbsp;</td>
                                            </tr>
                                            <tr><td colspan="7">&nbsp;</td></tr>
                                            <tr>
                                                <td><strong>Indicador:</strong></td>
                                                <td colspan="3" style="font-size:13px"><?php echo $Datos_Ver[0]['codigo'] . " - " . $Datos_Ver[0]['nom_indicador']; ?><input type="hidden" id="id_indicador" name="id_indicador" value="<?php echo $Datos_Ver[0]['siqindicador_id'] ?>"></td>
                                                <td>&nbsp;</td>
                                                <td><strong>Estado:</strong></td>
                                                <?php
                                                if ($Datos_Ver[0]['idEstado'] == 1) {#Desactualizado
                                                    $Color = 'color:#FF0000';

                                                    $Radio_ver_Revision = 'disabled';
                                                    $Radio_ver_Rechazado = 'disabled';
                                                    $Radio_ver_Aprobado = 'disabled';
                                                }
                                                if ($Datos_Ver[0]['idEstado'] == 2) {#en proceso
                                                    $Color = 'color:#0000FF';

                                                    $Radio_ver_Revision = '';
                                                    $Radio_ver_Rechazado = 'disabled';
                                                    $Radio_ver_Aprobado = 'disabled';
                                                }
                                                if ($Datos_Ver[0]['idEstado'] == 3) {#en revision
                                                    $Color = 'color:#990099';

                                                    $Radio_ver_Revision = 'disabled';
                                                    $Radio_ver_Rechazado = '';
                                                    $Radio_ver_Aprobado = '';
                                                }
                                                if ($Datos_Ver[0]['idEstado'] == 4) {#actualizado
                                                    $Color = 'color:#009900';

                                                    $Radio_ver_Revision = 'disabled';
                                                    $Radio_ver_Rechazado = 'disabled';
                                                    $Radio_ver_Aprobado = 'disabled';
                                                }
                                                ?>
                                                <td align="center"><blink><strong style="font-size:14px;<?php echo $Color ?>"><?php echo $Datos_Ver[0]['estado'] ?></strong></blink><input type="hidden" id="estato_actual" name="estato_actual" value="<?php echo $Datos_Ver[0]['idEstado'] ?>"></td>
                                            </tr>
                                            <tr><td colspan="7">&nbsp;</td></tr>
                                            <tr>
                                                <td><strong>Descripción del indicador:</strong></td>
                                                <td colspan="6" style="font-size: 13px;"><?php echo $Datos_Ver[0]['desc_indicador']; ?></td>
                                            </tr>
                                            <tr><td colspan="7">&nbsp;</td></tr>
                                            <tr>
                                                <td ><strong>Discriminación:</strong></td>
                                                <td class="Border" colspan="3" style="font-size:13px"><?php echo $Discriminacion->fields['nombre'] . $Mas_data; ?></td>
                                                <td class="Border" colspan="2">&nbsp;</td>
                                            </tr>
                                            <tr >
                                                <td ><strong>Tipo Indicador:</strong></td>
                                                <td class="Border" colspan="3" style="font-size:13px"><?php echo $Datos_Ver[0]['nombre'] ?></td>
                                                <td colspan="2">&nbsp;</td>
                                            </tr>
                                            <?php
                                            if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 0 && $Datos_Ver[0]['tiene_anexo'] == 0) {
                                                $Archivo = 'Principal';
                                            }
                                            if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 0) {
                                                $Archivo = 'Principal &oacute; Analisis';
                                            }
                                            if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 0 && $Datos_Ver[0]['tiene_anexo'] == 1) {
                                                $Archivo = 'Principal &oacute; Anexo';
                                            }
                                            if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 1) {
                                                $Archivo = 'Principal &oacute; Analisis &oacute; Anexo';
                                            }
                                            if ($Datos_Ver[0]['idTipo'] != 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 0) {
                                                $Archivo = 'Analisis';
                                            }
                                            if ($Datos_Ver[0]['idTipo'] != 1 && $Datos_Ver[0]['es_objeto_analisis'] == 0 && $Datos_Ver[0]['tiene_anexo'] == 1) {
                                                $Archivo = 'Anexo';
                                            }
                                            if ($Datos_Ver[0]['idTipo'] != 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 1) {
                                                $Archivo = 'Analisis &oacute; Anexo';
                                            }
                                            ?>
                                            <tr>
                                                <td ><strong>Tipo Archivo:</strong></td>
                                                <td class="Border" colspan="3" style="font-size:13px"><?php echo $Archivo ?></td>
                                                <td class="Border" colspan="2">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="7">&nbsp;</td>
                                            </tr>
                                            <?php if ($id_doc == "") { ?>
                                                <tr>
                                                    <td colspan="7" align="center" style="font-size:12px">No tiene documentos vigentes asociados.</td>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="7" align="center">
                                                        <input type="button" value="Ver Archivos Adjuntos" style="font-size:12px" onClick="Open(<?php echo $id_doc ?>, '<?php echo $VF ?>', '<?php echo $RH ?>', '<?php echo $Fecha_ini ?>', '<?php echo $Fecha_fin ?>', '<?php echo $idsiq_estructuradocumento; ?>')" class="full_width big" title="Click para ver..." >

                                                        <div id="Contenedor_archivos" style="display:none;width:100%; ">

                                                        </div>	        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">&nbsp;&nbsp;</td>
                                                </tr>
                                            <?php } //else   ?>
                                        </table>

                                        </div> 
                                        </fieldset>    
                                        </div>
                                        </body>
                                        </html>     
                                        <?php
                                    }

                                    public function Modificar_New($id_doc, $Fecha_ini = '', $Fecha_fin = '') {

                                        global $db, $userid, $C_Utils_monitoreo;
                                        ?>
                                        <style>
                                            fieldset {
                                                -webkit-border-radius: 8px;
                                                -moz-border-radius: 8px;
                                                border-radius: 8px;
                                                border-color:#316FC0;
                                                border-style: solid;
                                                border-width: 1px;

                                            }
                                            legend {
                                                color: #316FC0; 
                                                font-size:14px;
                                                font-weight: bold;
                                                letter-spacing:-1px;
                                                padding-bottom:20px;
                                                padding-top:8px;
                                                text-transform:capitalize;
                                            }
                                            .Border{
                                                border:0px solid #000;
                                                padding:.5em;
                                            }
                                        </style>
                                <html>
                                    <head>
                                        <title></title>        
                                    <div id="container">

                                        </head>  
                                        <body id="dt_example">
                                            <div id="container">
                                                <div style="font-size:24px"><strong>Ver/Modificar Documentos</strong></div>      
                                                <fieldset>  
                                                    <legend>Ver/Modificar Documentos</legend>
                                                    <div>
                                                        <?php
                                                        $SQL_Datos = 'SELECT 
													Doc.idsiq_documento as id, 
													Doc.siqfactor_id, 
													Doc.siqcaracteristica_id, 
													Doc.siqaspecto_id, 
													Doc.siqindicador_id, 
													Gene.nombre AS nom_indicador, 
													Doc.estado, 
													date(Doc.fecha_ingreso) AS Fecha_carga, 
													date(Ind.fecha_proximo_vencimiento) AS fecha_ven, 
													Gene.idTipo, 
													Ind.es_objeto_analisis, 
													Ind.tiene_anexo, 
													Ind.idEstado, 
													Est.nombre AS estado, 
													Gene.idAspecto, 
													Ind.discriminacion, 
													Ind.idCarrera, 
													tipo.nombre, 
													Ind.es_objeto_analisis, 
													Ind.tiene_anexo,
													Gene.codigo 
													 
										FROM 
													siq_documento AS Doc, 
													siq_indicador AS Ind, 
													siq_estadoIndicador As Est, 
													siq_indicadorGenerico AS Gene ,
													siq_tipoIndicador AS tipo

										
										WHERE 
													Doc.idsiq_documento="' . $id_doc . '"
													AND 
													Doc.siqindicador_id=Ind.idsiq_indicador 
													AND 
													Doc.codigoestado=100 
													AND 
													Ind.codigoestado=100 
													AND 
													Ind.codigoestado=100 
													AND 
													Est.idsiq_estadoIndicador=Ind.idEstado 
													AND 
													Gene.idsiq_indicadorGenerico=Ind.idIndicadorGenerico 
													AND 
													Gene.codigoestado=100
													AND 
													Gene.idTipo=tipo.idsiq_tipoIndicador ';

                                                        if ($Result = &$db->Execute($SQL_Datos) === false) {
                                                            echo 'Error en el SQL De los Datos....<br>' . $SQL_Datos;
                                                            die;
                                                        }



                                                        $Datos_Ver = $Result->GetArray();

                                                        $SQL_OtherData = 'SELECT  

													siq_aspecto.idsiq_aspecto,
													siq_aspecto.idCaracteristica,
													siq_aspecto.nombre As aspecto_nom,
													siq_caracteristica.idsiq_caracteristica,
													siq_caracteristica.idFactor,
													siq_caracteristica.nombre As caracteristica_nom,
													siq_factor.idsiq_factor,
													siq_factor.nombre As factor_nom
										
										FROM 
										
													siq_aspecto,
													siq_caracteristica,
													siq_factor
										
										WHERE
										
													siq_aspecto.idsiq_aspecto="' . $Datos_Ver[0]['idAspecto'] . '"
													AND
													siq_aspecto.idCaracteristica=siq_caracteristica.idsiq_caracteristica
													AND
													siq_caracteristica.idFactor=siq_factor.idsiq_factor
													AND
													siq_aspecto.codigoestado=100
													AND
													siq_caracteristica.codigoestado=100
													AND
													siq_factor.codigoestado=100';

                                                        if ($Other_Data = &$db->Execute($SQL_OtherData) === false) {
                                                            echo 'Error en el SQL Other data ....<br>' . $SQL_OtherData;
                                                            die;
                                                        }


                                                        $OtherData = $Other_Data->GetArray();


                                                        switch ($Datos_Ver[0]['discriminacion']) {

                                                            case '1': {
                                                                    $Mas_data = '';
                                                                }break;
                                                            case '2': {

                                                                    $SQL_falcutad = 'SELECT 
		
																codigofacultad,
																nombrefacultad
													
													FROM 
													
																facultad
													
													WHERE
													
																codigofacultad="' . $Datos_Ver[0]['idFacultad'] . '"';


                                                                    if ($Facultad = &$db->Execute($SQL_falcutad) === false) {
                                                                        echo 'Error en el SQL Facultad...<br>' . $SQL_falcutad;
                                                                        die;
                                                                    }

                                                                    $Mas_data = '  ::  ' . $Facultad->fields['nombrefacultad'];
                                                                }break;
                                                            case '3': {

                                                                    $SQL_Carrera = 'SELECT 
		
															codigocarrera,
															nombrecarrera
													
													FROM 
													
															carrera
													
													WHERE
													
															codigocarrera="' . $Datos_Ver[0]['idCarrera'] . '"';

                                                                    if ($Carrera = &$db->Execute($SQL_Carrera) === false) {
                                                                        echo 'Error alBuscar la Carrera...<br>' . $SQL_Carrera;
                                                                        die;
                                                                    }

                                                                    $Mas_data = '  ::  ' . $Carrera->fields['nombrecarrera'];
                                                                }break;
                                                        }





                                                        $SQL_Discriminacion = 'SELECT  

															idsiq_discriminacionIndicador,
															nombre
												
												FROM 
												
															siq_discriminacionIndicador
												
												WHERE
															codigoestado=100
															AND
															idsiq_discriminacionIndicador="' . $Datos_Ver[0]['discriminacion'] . '"';

                                                        if ($Discriminacion = &$db->Execute($SQL_Discriminacion) === false) {
                                                            echo 'Error en el SQL Discriminacion....<br>' . $SQL_Discriminacion;
                                                            die;
                                                        }
                                                        ?>
                                                        <form action="Modificar_carga.php" method="post" enctype="multipart/form-data" name="Principal">
                                                            <table border="0" width="100%" cellpadding="0" cellspacing="0" >
                                                                <tr>
                                                                    <td width="1%"><input type="hidden" id="User_id" name="User_id" value="<?php echo $userid ?>"><input type="hidden" name="modificar" id="modificar" value="0">&nbsp;<input type="hidden" id="id_Documento" name="id_Documento" value="<?php echo $id_doc ?>"><br /><input type="hidden" id="Analisi" name="Analisi" value="<?php echo $Datos_Ver[0]['es_objeto_analisis'] ?>" /><br /><input type="hidden" id="Anexo" name="Anexo"  value="<?php echo $Datos_Ver[0]['tiene_anexo'] ?>"/><br /><input type="hidden" id="Tipo_indicador" name="Tipo_indicador" value="<?php echo $Datos_Ver[0]['idTipo'] ?>" /></td>
                                                                    <td width="99%">
                                                                        <table  border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                                                                            <tr>
                                                                                <td width="19%"><strong>Factor:</strong></td>
                                                                                <td colspan="3" style="font-size:13px"><?php echo $OtherData[0]['factor_nom'] ?><input type="hidden" id="id_factor" name="id_factor" value="<?php echo $OtherData[0]['idsiq_factor'] ?>"></td>
                                                                                <td width="6%">&nbsp;</td>
                                                                                <td width="12%"><strong>Fecha Carga:</strong></td>
                                                                                <td width="12%" align="center" style="font-size:13px"><?php echo $Datos_Ver[0]['Fecha_carga'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><strong>Caracteristica:</strong></td>
                                                                                <td colspan="3" style="font-size:13px"><?php echo $OtherData[0]['caracteristica_nom'] ?><input type="hidden" id="id_Caract" name="id_Caract" value="<?php echo $OtherData[0]['idsiq_caracteristica'] ?>"></td>
                                                                                <td>&nbsp;</td>
                                                                                <td><strong>Fecha de Vencimiento:</strong></td>
                                                                                <td align="center" style="font-size:13px"><?php echo $Datos_Ver[0]['fecha_ven'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><strong>Aspecto:</strong></td>
                                                                                <td colspan="3" style="font-size:13px"><?php echo $OtherData[0]['aspecto_nom'] ?><input type="hidden" id="id_aspecto" name="id_aspecto" value="<?php echo $OtherData[0]['idsiq_aspecto'] ?>"></td>
                                                                                <td>&nbsp;</td>
                                                                                <td><strong>Estado:</strong></td>
        <?php
        if ($Datos_Ver[0]['idEstado'] == 1) {#Desactualizado
            $Color = 'color:#FF0000';

            $Radio_ver_Revision = 'disabled';
            $Radio_ver_Rechazado = 'disabled';
            $Radio_ver_Aprobado = 'disabled';
        }
        if ($Datos_Ver[0]['idEstado'] == 2) {#en proceso
            $Color = 'color:#0000FF';

            $Radio_ver_Revision = '';
            $Radio_ver_Rechazado = 'disabled';
            $Radio_ver_Aprobado = 'disabled';
        }
        if ($Datos_Ver[0]['idEstado'] == 3) {#en revision
            $Color = 'color:#990099';

            $Radio_ver_Revision = 'disabled';
            $Radio_ver_Rechazado = '';
            $Radio_ver_Aprobado = '';
        }
        if ($Datos_Ver[0]['idEstado'] == 4) {#actualizado
            $Color = 'color:#009900';

            $Radio_ver_Revision = 'disabled';
            $Radio_ver_Rechazado = 'disabled';
            $Radio_ver_Aprobado = 'disabled';
        }
        ?>
                                                                                <td align="center"><blink><strong style="font-size:14px;<?php echo $Color ?>"><?php echo $Datos_Ver[0]['estado'] ?></strong></blink><input type="hidden" id="estato_actual" name="estato_actual" value="<?php echo $Datos_Ver[0]['idEstado'] ?>"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><strong>Indicador:</strong></td>
                                                                                <td colspan="3" style="font-size:13px"><?php echo $Datos_Ver[0]['nom_indicador'] . '  ::  ' . $Discriminacion->fields['nombre'] . $Mas_data; ?><input type="hidden" id="id_indicador" name="id_indicador" value="<?php echo $Datos_Ver[0]['siqindicador_id'] ?>"></td>
                                                                                <td colspan="2">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><strong>Codigo Indicador:</strong></td>
                                                                                <td colspan="3" style="font-size:13px"><?php echo $Datos_Ver[0]['codigo'] ?></td>
                                                                                <td colspan="2">&nbsp;</td>
                                                                            </tr>
                                                                            <tr >
                                                                                <td ><strong>Tipo Indicador:</strong></td>
                                                                                <td class="Border" colspan="3" style="font-size:13px"><?php echo $Datos_Ver[0]['nombre'] ?></td>
                                                                                <td colspan="2">&nbsp;</td>
                                                                            </tr>
        <?php
        if (($Datos_Ver[0]['idTipo'] == 1 || $Datos_Ver[0]['idTipo'] == 2 || $Datos_Ver[0]['idTipo'] == 3) && $Datos_Ver[0]['es_objeto_analisis'] == 0 && $Datos_Ver[0]['tiene_anexo'] == 0) {
            $Archivo = 'Principal';
        }
        if (($Datos_Ver[0]['idTipo'] == 1 || $Datos_Ver[0]['idTipo'] == 2 || $Datos_Ver[0]['idTipo'] == 3) && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 0) {
            $Archivo = 'Principal &oacute; Analisis';
        }
        if (($Datos_Ver[0]['idTipo'] == 1 || $Datos_Ver[0]['idTipo'] == 2 || $Datos_Ver[0]['idTipo'] == 3) && ($Datos_Ver[0]['es_objeto_analisis'] == 0 && $Datos_Ver[0]['tiene_anexo'] == 1)) {
            $Archivo = 'Principal &oacute; Anexo';
        }
        if ($Datos_Ver[0]['idTipo'] == 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 1) {
            $Archivo = 'Principal &oacute; Analisis &oacute; Anexo';
        }
        if ($Datos_Ver[0]['idTipo'] != 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 0) {
            $Archivo = 'Analisis';
        }
        if ($Datos_Ver[0]['idTipo'] != 1 && $Datos_Ver[0]['es_objeto_analisis'] == 0 && $Datos_Ver[0]['tiene_anexo'] == 1) {
            $Archivo = 'Anexo';
        }
        if ($Datos_Ver[0]['idTipo'] != 1 && $Datos_Ver[0]['es_objeto_analisis'] == 1 && $Datos_Ver[0]['tiene_anexo'] == 1) {
            $Archivo = 'Analisis &oacute; Anexo';
        }
        ?>
                                                                            <tr>
                                                                                <td ><strong>Tipo Archivo:</strong></td>
                                                                                <td class="Border" colspan="3" style="font-size:13px"><?php echo $Archivo ?></td>
                                                                                <td class="Border" colspan="2">&nbsp;</td>
                                                                            </tr>
        <?php
        switch ($Datos_Ver[0]['discriminacion']) {
            case '1': {
                    $Nombre = 'Institucional';
                    $Relacion = '&nbsp;&nbsp;';
                    $ver = ' style="visibility:collapse"';
                }break;
            case '2': {
                    $Nombre = 'Faculta';
                    $Relacion = '&nbsp;&nbsp;';
                    $ver = ' style="visibility:collapse"';
                }break;
            case '3': {
                    $Nombre = 'Programa';

                    $SQL_Carrera = 'SELECT 
							
																								codigocarrera,
																								nombrecarrera
																						
																						FROM 
																						
																								carrera
																						
																						WHERE
																						
																								codigocarrera="' . $Datos_Ver[0]['idCarrera'] . '"';

                    if ($Carrera = &$db->Execute($SQL_Carrera) === false) {
                        echo 'Error alBuscar la Carrera...<br>' . $SQL_Carrera;
                        die;
                    }

                    $Relacion = $Carrera->fields['nombrecarrera'];
                    $ver = '';
                }break;
        }
        ?>
                                                                            <tr>
                                                                                <td><strong>Discriminaci&oacute;n</strong></td>
                                                                                <td class="Border"  colspan="3" style="font-size:13px"><?php echo $Nombre ?></td>
                                                                                <td colspan="2">&nbsp;</td>
                                                                            </tr>
        <?php
        #echo '<pre>';print_r($C_Utils_monitoreo);
        $Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db, $Datos_Ver[0]['siqindicador_id']);

        #echo '<pre>';print_r($Permisos);  

        if ($Permisos[1][0] == 1) {
            $C_Permiso = 1; #Todos
        } else if ($Permisos[1][0] == 2 || $Permisos[1][0] == 3) {
            $C_Permiso = 2; #ver
        }
        ?>
                                                                            <tr>
                                                                                <td colspan="7">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="7" align="center">
                                                                                    <input type="button" value="Ver Archivos Adjuntos" style="font-size:12px" onClick="Open(<?php echo $id_doc ?>, '', '', '<?php echo $Fecha_ini ?>', '<?php echo $Fecha_fin ?>', '<?php echo $_REQUEST['idsiq_estructuradocumento'] ?>')" class="full_width big" title="Click para ver..." >

                                                                                    <div id="Contenedor_archivos" style="display:none;width:100%">

                                                                                    </div>	        
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="7">&nbsp;&nbsp;</td>
                                                                            </tr>
        <?php
        if ($C_Permiso == 1) {
            ?>
                                                                                <tr>
                                                                                    <td colspan="7">
                                                                                        <table border="0" width="100%">
                                                                                            <tr>
                                                                                                <td>&nbsp;&nbsp;</td>
                                                                                                <td colspan="6"><input type="checkbox" id="Otro" onClick="Ver_Box()">Cargar Otro Documento</td>
                                                                                            </tr>
                                                                                            <tr id="Tr_Op" style="visibility:collapse"><!--style="visibility:collapse"-->
                                                                                                <td >&nbsp;&nbsp;</td>
                                                                                                <td colspan="6">
                                                                                                    <table border="0" width="100%"><!--tabla 1-->
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <br>
                                                                                                                <table border="0"><!--Tabla3-->
                                                                                                                    <tr id="TR_Cargar" style="visibility:collapse"><!--TR_Cargar-->
                                                                                                                        <td>&nbsp;&nbsp;</td>
                                                                                                                        <td colspan="3" >
                                                                                                                            <table border="0"  cellpadding="0" cellspacing="0">
                                                                                                                                <tr>
                                                                                                                                    <td align="left"><strong style="font-size:12px">&nbsp;&nbsp;Cargar Archivo:&nbsp;&nbsp;<span style="color:#F00">*</span></strong></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td>&nbsp;</td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td align="left"><input type="file" id="file" name="file" height="80px" class="cajas" size="50"/><span id="tipoDoc" style="color:#000; font-size:9px">10 Mb Max / Word</span></td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                        <td align="center" colspan="3">
                                                                                                                            <table>
                                                                                                                                <tr>
                                                                                                                                    <td>
                                                                                                                                        <strong style="font-size:12px">&nbsp;&nbsp;Tipo Archivo:</strong>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td>
                                                                                                                                        <select id="Tipo_Carga" name="Tipo_Carga" class="cajas" style="width:90%">
                                                                                                                                            <option value="-1">Elige...</option>
                                                                                                                                            <option value="1" onClick="validar_tipo('0');CambiarDoc('3')">Principal</option>
                                                                                                                                            <option value="2" onClick="validar_tipo('1');CambiarDoc('0')">An&aacute;lisis</option>
                                                                                                                                            <option value="3" onClick="validar_tipo('2');CambiarDoc('1')">Anexo</option>
                                                                                                                                        </select>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr><!--TR_Cargar-->
                                                                                                                </table><!--Tabla3-->
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <table border="0" width="100%">
                                                                                                                    <tr>
                                                                                                                        <td align="left"><strong>&nbsp;&nbsp;Descripcion del Archivo:&nbsp;&nbsp;<span style="color:#F00">*</span></strong></td>
                                                                                                                    </tr>
                                                                                                                    <tr>    
                                                                                                                        <td><textarea class="cajas" id="Descripcion" name="Descripcion" style="width:90%" cols="20" rows="10"></textarea></td>
                                                                                                                    </tr>
                                                                                                                </table>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </table><!--Tabla 1-->
                                                                                                </td>

                                                                                            </tr><!--Fin del TR Tr_Op-->
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
            <?php
        }
        ?>
                                                                            <tr>
                                                                                <td colspan="7">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="7">
                                                                                    <table border="0" width="100%">
                                                                                        <tr>
                                                                                            <td colspan="2">
                                                                                                &nbsp;
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2">&nbsp;</td>
                                                                            </tr>
                                                                            <tr id="Tr_Modifcar">
                                                                                <td colspan="2" align="center">

                                                                                </td>
                                                                            </tr>
                                                                            <tr id="tr_Cargar_New" style="visibility:collapse">
                                                                                <td colspan="2" align="right"><input type="submit" id="Update" value="Modificar / Cargar."  class="full_width big" style="font-size:12px" onClick="return ValidarSubt()"></td>

                                                                            </tr>  
                                                                            <tr>
                                                                                <td colspan="2">&nbsp;</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="1%">&nbsp;</td>
                                                                <td width="99%">&nbsp;</td>
                                                            </tr>    
                                                            </table>
                                                        </form>
                                                    </div>
                                                </fieldset>      
                                            </div>     
                                        </body>
                                </html>
        <?php
    }

}

#class

function esPar($numero) {
    $resto = $numero % 2;
    if (($resto == 0) && ($numero != 0)) {
        return 1; #true
    } else {
        return 0; #false
    }
}
?>