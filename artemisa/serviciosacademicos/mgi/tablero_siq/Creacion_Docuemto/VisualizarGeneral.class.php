<?php

class VisualizarGeneral {

    public function Principal($id) {
        global $userid, $db;

        $id = 1;
        //$id = 1; 
        $SQL_Estructura = 'SELECT 
									Estru.idsiq_estructuradocumento,
									Estru.nombre_documento, 
									Estru.nombre_entidad , 
									dis.nombre, 
									date(Estru.entrydate) AS fecha ,
									Estru.tipo_documento,
									Estru.id_carrera
							
							FROM 
									siq_estructuradocumento AS Estru INNER JOIN siq_discriminacionIndicador AS dis ON Estru.tipo_documento=dis.idsiq_discriminacionIndicador 
									
							WHERE
									Estru.codigoestado=100 
									AND 
									dis.codigoestado=100
									AND
									Estru.idsiq_estructuradocumento="' . $id . '"';


        if ($Estructura = &$db->Execute($SQL_Estructura) === false) {
            echo 'Error en el SQl ....de la Estructura.......<br>' . $SQL_Estructura;
            die;
        }
        ?>
        <div id="container">
            <h1></h1>
            <div class="Baner" >
                <br />
                <div class="encabezado"><strong class="ColorTitulo" ><?php echo $Estructura->fields['nombre_documento'] ?></strong></div>
                <div align="right"><img src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png"   style=" margin-right:3%" /></div>
            </div>    
            <br />
            <?php
            $SQL_Datos = 'SELECT
								
											facEstru.idsiq_factoresestructuradocumento as id,
											facEstru.factor_id,
											Fac.codigo,
											Fac.idsiq_factor,
											Fac.nombre
								
								FROM 
											siq_indicadoresestructuradocumento AS indEstru 
											INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
											INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
											INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
											INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto
											INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica
											INNER JOIN siq_factor AS Fac ON caract.idFactor=Fac.idsiq_factor

								
								WHERE
								
											facEstru.idsiq_estructuradocumento="' . $id . '"
											AND
											facEstru.codigoestado=100
											AND
											indEstru.codigoestado=100
											AND
											ind.codigoestado=100
											AND
											indGen.codigoestado=100
											AND
											asp.codigoestado=100
											AND
											caract.codigoestado=100
											AND
											Fac.codigoestado=100
								
								GROUP BY facEstru.factor_id
								ORDER BY facEstru.Orden  ';

            if ($Datos = &$db->Execute($SQL_Datos) === false) {
                echo 'Error en el SQl -...<br>' . $SQL_Datos;
                die;
            }
            ?>
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" >
                <tr>
                    <td>
                        <fieldset  class="ContenedorFactor">
                            <div id="MenuFactor" class="monitoreoIndicador" align="center" style="width:90%; margin-left:1%">
                                <ul class="drop">
                                    <li class="level1-li BotonImagen" id="Botn_A" onclick="CargarRepositorio('/var/ftp/pub/REPOSITORIO DOCUMENTOS INSTITUCIONALES/*', false, '<?php echo $id ?>')" >
                                        <button type="button"><strong id="LetraColor_A"><?php echo strtoupper("Documentos Institucionales") ?></strong></button>
                                    </li>
                                </ul>
                                <?php
                                $i = 0;
                                while (!$Datos->EOF) {

                                    /* $SQL_Factor='SELECT
                                      idsiq_factor,
                                      nombre,
                                      codigo
                                      FROM
                                      siq_factor
                                      WHERE

                                      codigoestado=100
                                      AND
                                      idsiq_factor="'.$Datos->fields['factor_id'].'"';

                                      if($Factor=&$db->Execute($SQL_Factor)===false){
                                      echo 'Error en el SQL ...<br>'.$SQL_Factor;
                                      die;
                                      } */
                                    ?>
                                    <ul class="drop">
                                        <li class="level1-li BotonImagen"  id="Botn_<?php echo $i ?>" onclick="Cargar(<?php echo $Datos->fields['factor_id'] ?>, '<?php echo $Datos->fields['id'] ?>', '<?php echo $id ?>', '<?php echo $i ?>');" >
                                            <button type="button" ><strong id="LetraColor_<?php echo $i ?>" style="font-size:9px"><?php echo strtoupper($Datos->fields['nombre']) ?></strong></button>
                                        </li>
                                    </ul>				
                                    <?php
                                    $i++;
                                    $Datos->MoveNext();
                                }
                                ?>
                                <input id="indesBtn" value="<?php echo $i ?>" type="hidden" />
                            </div>
                        </fieldset>
                        <fieldset class="TextoInicial">
                            <?php
                            $SQL_Texto = 'SELECT
											
													TextoInicio_id,
													titulo,
													cuerpo,
													autor,
													dependencia,
													orden
											
											FROM
											
													siq_Textoinicio
											
											WHERE
													documento_id="' . $id . '"
													AND
													codigoestado=100
													
													ORDER BY orden';


                            if ($Texto = &$db->Execute($SQL_Texto) === false) {
                                echo 'Error en el SQL ...<br>' . $SQL_Texto;
                                die;
                            }
                            ?>
                            <div id="CargarInfo" style=" margin-left:2%"><!--Div >Contenedor de Texto -->
                                <?php
                                while (!$Texto->EOF) {
                                    /*                                     * **************************************************** */
                                    ?>
                                    <div id="Titulo_<?php echo $Texto->fields['orden'] ?>" align="center"><strong><?php echo $Texto->fields['titulo'] ?></strong></div><!--Titulo-->
                                    <br />	
                                    <br />
                                    <div id="Cuerpo_<?php echo $Texto->fields['orden'] ?>" align="justify" style="width:95%; margin-left:2%"><!--Cuerpo-->
                                        <?php echo $Texto->fields['cuerpo'] ?>
                                    </div>
                                    <br />
                                    <br />
                                    <div align="right" id="Autor_<?php echo $Texto->fields['orden'] ?>" style="margin-left:2%; margin-right:3%"><!--Autor_1-->
                                        <strong><?php echo $Texto->fields['autor'] ?></strong>
                                        <br /> 
                                        <strong><?php echo $Texto->fields['dependencia'] ?></strong>
                                    </div><!--Autor_1-->
                                    <br />
                                    <br />
                                    <br />
                                    <?php
                                    /*                                     * **************************************************** */
                                    $Texto->MoveNext();
                                }
                                ?>	
                            </div>
                        </fieldset>
                    </td>
                </tr>
            </table>
            <div class="BanerInferior" ></div>        
        </div> 
        <?php
    }

    public function ListaCaracteristicas($Factor_id, $Estructura_id, $Doc_id) {

        global $userid, $db;

        $SQL_Factor = 'SELECT
								idsiq_factor,
								nombre,
								codigo,
								descripcion
						FROM
								siq_factor 
						WHERE
						
								codigoestado=100
								AND
								idsiq_factor="' . $Factor_id . '"';

        if ($Factor = &$db->Execute($SQL_Factor) === false) {
            echo 'Error en el SQL ...<br>' . $SQL_Factor;
            die;
        }
        ?>
        <div id="Descrip_Factor">
            <strong style="font-size:24px; cursor:pointer" onclick="VolverPrincipal('<?php echo $Doc_id ?>');"><?php echo $Factor->fields['codigo'] ?></strong>
            <br />
            <strong style="font-size:18px; cursor:pointer" onclick="VolverPrincipal('<?php echo $Doc_id ?>');"><?php echo $Factor->fields['nombre'] ?></strong>
            <br />
            <br />
            <div align="justify"><?php echo $Factor->fields['descripcion'] ?></div>
            <br />
        </div>
        <br />
        <?php
        $SQL_Caracteristica = 'SELECT 


											caract.idFactor,
											caract.idsiq_caracteristica as id,
											caract.nombre,
											facEstru.factor_id,
											caract.codigo
													 
								
								FROM 
								
											siq_indicadoresestructuradocumento AS indEstru 
											INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
											INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
											INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
											INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
											INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
								
								WHERE 
								
											indEstru.idsiq_factoresestructuradocumento="' . $Estructura_id . '" 
											AND 
											facEstru.codigoestado=100 
											AND 
											indEstru.codigoestado=100 
											AND 
											ind.codigoestado=100 
											AND 
											indGen.codigoestado=100 
											AND 
											asp.codigoestado=100 
											AND 

											caract.codigoestado=100 
											AND 
											facEstru.factor_id="' . $Factor_id . '" 
								
								GROUP BY caract.idsiq_caracteristica
								
								ORDER BY  indEstru.Orden';

        if ($Caractersiticas = &$db->Execute($SQL_Caracteristica) === false) {
            echo 'Error en el SQl de las Caracteristicas.....<br>' . $SQL_Caracteristica;
            die;
        }
        ?>
        <fieldset class="ConteCaracteristica" >
            <legend>Caracter&iacute;sticas...</legend>
            <?php
            $i = 0;
            while (!$Caractersiticas->EOF) {
                ?>
                <ul id="sortable_Caracteristica" class="connectedSortable">
                    <li class="ui-state-default" id="Sombra_id_<?php echo $i ?>" onmouseover="Sombralight(<?php echo $i ?>)" onmouseout="SinSombra(<?php echo $i ?>)" onclick="CargarSub(<?php echo $i ?>, '<?php echo $Caractersiticas->fields['id'] ?>', '<?php echo $Factor_id ?>', '<?php echo $Estructura_id ?>', '<?php echo $Doc_id ?>')" style="cursor:pointer"><?php echo $Caractersiticas->fields['codigo'] . '&nbsp;' . $Caractersiticas->fields['nombre'] ?></li>
                </ul>   
            <?php
            $i++;
            $Caractersiticas->MoveNext();
        }
        ?>
        </fieldset>
        <input type="hidden" id="Index" value="<?php echo $i ?>" />
        <?php
    }

    public function ListaAspecto($Caract_id, $Factor_id, $Estructura_id, $Doc_id) {
        global $userid, $db;

        $SQL_Factor = 'SELECT
								idsiq_factor,
								nombre,
								codigo,
								descripcion
						FROM
								siq_factor 
						WHERE
						
								codigoestado=100
								AND
								idsiq_factor="' . $Factor_id . '"';

        if ($Factor = &$db->Execute($SQL_Factor) === false) {
            echo 'Error en el SQL ...<br>' . $SQL_Factor;
            die;
        }


        $SQL_Caract = 'SELECT 

									idsiq_caracteristica,
									nombre,
									descripcion,
									codigo
							
							FROM 
							
									siq_caracteristica
							
							WHERE
							
									idsiq_caracteristica="' . $Caract_id . '"
									AND
									codigoestado=100';

        if ($Caracteristica = &$db->Execute($SQL_Caract) === false) {
            echo 'Error en el SQL ...<br>' . $SQL_Caract;
            die;
        }
        //$Factor_id,$Estructura_id,$Doc_id		
        ?>
        <div id="Descrip">
            <strong style="font-size:24px; cursor:pointer" onclick="VolverPrincipal('<?php echo $Doc_id ?>');"><?php echo $Factor->fields['codigo'] ?></strong>
            <br />
            <strong style="font-size:18px;cursor:pointer" onclick="VolverPrincipal('<?php echo $Doc_id ?>');"><?php echo $Factor->fields['nombre'] ?></strong>
            <br />
            <br />
            <strong style="font-size:16px; cursor:pointer" onclick="PreVolver('<?php echo $Factor_id ?>', '<?php echo $Estructura_id ?>', '<?php echo $Doc_id ?>')"><?php echo $Caracteristica->fields['codigo'] ?></strong>
            <br />
            <strong style="font-size:16px; cursor:pointer"  onclick="PreVolver('<?php echo $Factor_id ?>', '<?php echo $Estructura_id ?>', '<?php echo $Doc_id ?>')"><?php echo $Caracteristica->fields['nombre'] ?></strong>
            <br />
            <br />
            <div align="justify"><?php echo $Caracteristica->fields['descripcion'] ?></div>
            <br />
        </div>
        <br />
        <?php
        $SQL_Aspecto = 'SELECT 


											caract.idFactor,
											asp.idsiq_aspecto,
											asp.nombre,
											facEstru.factor_id
													 
								
								FROM 
								
											siq_indicadoresestructuradocumento AS indEstru 
											INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
											INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
											INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
											INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
											INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
								
								WHERE 
								
											indEstru.idsiq_factoresestructuradocumento="' . $Estructura_id . '" 
											AND 
											facEstru.codigoestado=100 
											AND 
											indEstru.codigoestado=100 
											AND 
											ind.codigoestado=100 
											AND 
											indGen.codigoestado=100 
											AND 
											asp.codigoestado=100 
											AND 

											caract.codigoestado=100 
											AND 
											facEstru.factor_id="' . $Factor_id . '"
											AND
											asp.idCaracteristica="' . $Caract_id . '"
 
								
								
								GROUP BY asp.idsiq_aspecto
								ORDER BY asp.idsiq_aspecto';

        if ($Aspecto = &$db->Execute($SQL_Aspecto) === false) {
            echo 'Error en el SQl de los Aspecto.....<br>' . $SQL_Aspecto;
            die;
        }
        ?>
        <fieldset class="ContAspecto">
            <legend>Aspectos...</legend>
        <?php
        $j = 0;
        while (!$Aspecto->EOF) {
            ?>
                <ul id="sortable_Aspecto" class="connectedSortable">
                    <li class="ui-state-default" id="Sombra_id_<?php echo $j ?>" onmouseover="Sombralight(<?php echo $j ?>)" onmouseout="SinSombra(<?php echo $j ?>)" onclick="VerIndicaores(<?php echo $j ?>, '<?php echo $Aspecto->fields['idsiq_aspecto'] ?>', '<?php echo $Estructura_id ?>', '<?php echo $Factor_id ?>')" style="cursor:pointer"><?php echo $Aspecto->fields['nombre'] ?></li>
                    <div id="SubCargaInd_<?php echo $j ?>"></div>
                </ul>  
            <?php
            $j++;
            $Aspecto->MoveNext();
        }
        ?>
            <input type="hidden" id="Index" value="<?php echo $j ?>" />
            <input type="hidden" id="Index_Asp" value="<?php echo $j ?>" />
        </fieldset>
            <?php
        }

        public function IndicadoresList($Aspecto_id, $Estructura_id, $Factor_id) {
            global $userid, $db;
            ?>
        <br />
        <fieldset class="ContIndicador" >
            <legend>Indicadores...</legend>
        <?php
        $SQL_indicador = 'SELECT 

									indEstru.idsiq_indicadoresestructuradocumento, 
									indGen.nombre, 
									indEstru.idsiq_indicadoresestructuradocumento, 
									indEstru.indicador_id, 
									ind.idsiq_indicador,
									ind.idEstado,
									indGen.idTipo,
									ind.inexistente, 
									ind.es_objeto_analisis,
									ind.tiene_anexo,
									indGen.idsiq_indicadorGenerico,
									facEstru.idsiq_estructuradocumento As Doc_id,
									indGen.codigo
							
							FROM 
							
									siq_indicadoresestructuradocumento AS indEstru 
									INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
									INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
									INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
									INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
									INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
							
							WHERE 
							
									indEstru.idsiq_factoresestructuradocumento="' . $Estructura_id . '"
									AND 
									facEstru.codigoestado=100 
									AND 
									indEstru.codigoestado=100 
									AND 
									ind.codigoestado=100 
									AND 
									indGen.codigoestado=100 
									AND 
									asp.codigoestado=100 
									AND 
									caract.codigoestado=100
									AND
									facEstru.factor_id="' . $Factor_id . '"
									AND
									asp.idsiq_aspecto="' . $Aspecto_id . '"
							
							
							ORDER BY indEstru.Orden';

        if ($Indicador = &$db->Execute($SQL_indicador) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indicador;
            die;
        }

        $d = 0;
        while (!$Indicador->EOF) {
            ?>
                <ul id="sortable_Aspecto" class="connectedSortable">
                    <li class="ui-state-default" id="Open_<?php echo $d ?>"  style="cursor:pointer" onmouseover="Sombralight_2(<?php echo $d ?>)" onmouseout="SinSombra_2(<?php echo $d ?>)" onclick="Ventana(<?php echo $Estructura_id ?>, '<?php echo $Factor_id ?>', '<?php echo $Indicador->fields['indicador_id'] ?>')"><?php echo $Indicador->fields['codigo'] . ' - ' . $Indicador->fields['nombre'] ?></li>
                </ul> 
                <?php
                $d++;
                $Indicador->MoveNext();
            }
            ?>
            <input type="hidden" id="Index" value="<?php echo $d ?>" />
        </fieldset>
            <?php
        }

        public function DetallesIndicador($Estructura_id, $Factor_id, $Indicador_id) {
            global $userid, $db;

            $SQL_indicador = 'SELECT 

									indEstru.idsiq_indicadoresestructuradocumento, 
									indGen.nombre, 
									indEstru.idsiq_indicadoresestructuradocumento, 
									indEstru.indicador_id, 
									ind.idsiq_indicador,
									ind.idEstado,
									indGen.idTipo,
									ind.inexistente, 
									ind.es_objeto_analisis,
									ind.tiene_anexo,
									indGen.idsiq_indicadorGenerico,
									facEstru.idsiq_estructuradocumento As Doc_id,
									indGen.codigo,
									indGen.descripcion,
									Estru_doc.fechainicial,
									Estru_doc.fechafinal,
									ind.discriminacion

							
							FROM 
							
								siq_estructuradocumento as Estru_doc 
								INNER JOIN siq_factoresestructuradocumento  AS facEstru ON Estru_doc.idsiq_estructuradocumento=facEstru.idsiq_estructuradocumento
								INNER JOIN siq_indicadoresestructuradocumento AS indEstru  ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
								INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
								INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
								INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
								INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
								 
							
							WHERE 
							
									indEstru.idsiq_factoresestructuradocumento="' . $Estructura_id . '"
									AND 
									facEstru.codigoestado=100 
									AND 
									indEstru.codigoestado=100 
									AND 
									ind.codigoestado=100 
									AND 
									indGen.codigoestado=100 
									AND 
									asp.codigoestado=100 
									AND 
									caract.codigoestado=100
									AND
									facEstru.factor_id="' . $Factor_id . '"
									AND
									indEstru.indicador_id="' . $Indicador_id . '"
							
							
							ORDER BY indEstru.Orden';

            if ($Indicador = &$db->Execute($SQL_indicador) === false) {
                echo 'Error en el SQl ....<br>' . $SQL_indicador;
                die;
            }
            ?>
        <div class="BanerDetalle"><img src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png"   style="margin-left:3%;" width="130" /></div>
        <br />
        <br />
        <div id="FormularioIndicador"  title="Indicador...">
            <fieldset class="ContenedorInicial" >
                <legend>Informaci&oacute;n del Indicador</legend>
                <div id="Descrip">
                    <table border="0" width="90%" cellpadding="0" cellspacing="0" align="center" bordercolor="#FFFFFF" style="border:#FFFFFF 1px solid">
                        <tr>
                            <td style="border:#FFFFFF 1px solid" align="center"><strong><?php echo $Indicador->fields['codigo'] . ' - ' . $Indicador->fields['nombre'] ?></strong></td>
                        </tr>
                        <tr>
                            <td style="border:#FFFFFF 1px solid" align="justify">
                                <fieldset class="ContDescrip" >
                                    <div align="justify" style="width:95%; margin-left:2%;">
        <?php echo $Indicador->fields['descripcion'] ?></td>
                                    </div>
                                </fieldset>
                        </tr>
                    </table>
                </div>
                <br />
                <hr class="ClassHr" align="center" >
                <br />
        <?php
        /*         * ************************************************************* */



        $Fecha_ini = $Indicador->fields['fechainicial'];
        $Fecha_fin = $Indicador->fields['fechafinal'];

        $Permiso = 0;

        if ($Indicador->fields['idTipo'] == 1) {#Si es Documental
            $Permiso = 1;
        }
        if ($Indicador->fields['idTipo'] == 2 && ($Indicador->fields['es_objeto_analisis'] == 1 || $Indicador->fields['tiene_anexo'] == 1)) {#Perspcion 
            $Permiso = 1;
        }
        if ($Indicador->fields['idTipo'] == 3 && ($Indicador->fields['es_objeto_analisis'] == 1 || $Indicador->fields['tiene_anexo'] == 1)) {#Numerico     
            $Permiso = 1;
        }
        if ($Permiso = 1) {

            $SQL_Doc = 'SELECT 

							idsiq_documento,
							siqindicador_id
					
					FROM 
					
							siq_documento
					
					WHERE
					
							codigoestado=100
							AND
							siqindicador_id="' . $Indicador->fields['idsiq_indicador'] . '"';

            if ($Documento = &$db->Execute($SQL_Doc) === false) {
                echo 'Error en el SQL .....<br>' . $SQL_Doc;
                die;
            }


            if ($Fecha_ini != '' && $Fecha_fin != '') {

                $BETWEEN = 'AND (fecha_carga BETWEEN "' . $Fecha_ini . '" AND  "' . $Fecha_fin . '" OR  changedate BETWEEN "' . $Fecha_ini . '" AND  "' . $Fecha_fin . '")';
            } else {
                $BETWEEN = '';
            }

            $SQL_Archivos = 'SELECT  

						idsiq_archivodocumento as id,
						nombre_archivo,
						file_size,
						tamano_unida,
						tipo_documento,
						fecha_carga,
						Ubicaicion_url,
						descripcion,
						version_final,
						extencion,
						rechazado,
						changedate  
						
						
						FROM 
						
						siq_archivo_documento
						
						WHERE
						
						siq_documento_id="' . $Documento->fields['idsiq_documento'] . '"
						AND
						version_final=1
						AND
						codigoestado=100
						' . $BETWEEN . '
						
						ORDER BY idsiq_archivodocumento DESC';

            if ($Result_Archivos = &$db->Execute($SQL_Archivos) === false) {
                echo 'Error en el SQl de los Archivos...<br>' . $SQL_Archivos;
                die;
            }

            $C_Archivos = $Result_Archivos->GetArray();
            /* echo '<br>';
              echo '<pre>';print_r($C_Archivos); */

            ##############################################################



            if ($Indicador->fields['idTipo'] == 2) {
                #Numerico
                #../../autoevaluacion/interfaz/prueba_resul.php-->Persepcion
                $VerUrl = "VerIndicador(" . $Indicador->fields['idsiq_indicador'] . ",'2','" . $Indicador->fields['discriminacion'] . "','','')";
            }

            if ($Indicador->fields['idTipo'] == 3) {
                #Numerico
                #$urlVer = '../../datos/reportes/detalle.php?idIndicador='.$data["idsiq_indicador"]."";--->Numerico
                $VerUrl = "VerIndicador(" . $Indicador->fields['idsiq_indicador'] . ",'3','" . $Indicador->fields['discriminacion'] . "','','')";
            }

            $VerIndicador = '<img src="../../images/view_multicolumn.png" width="20%" title="Ver Indicador"  style="cursor:pointer" onclick="' . $VerUrl . '" />';

            ###############################################################
            ?>
                    <table border="0" align="center" cellpadding="0" cellspacing="0" width="90%">
                    <?php
                    for ($i = 0; $i < count($C_Archivos); $i++) {
                        ?>
                            <tr>
                                <td style="border:#FFFFFF 1px solid" align="justify">
                                    <fieldset style="height:90%; width:98%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
                                        <div style="width:95%; margin-left:2%;" align="justify">
                            <?php echo $C_Archivos[$i]['descripcion'] ?>&nbsp;&nbsp;<a href="" style="cursor:pointer" onclick="DescargarDoc('<?php echo $C_Archivos[$i]['Ubicaicion_url'] ?>')" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">Documento Completo</a>
                            <?php
                            if ($C_Archivos[$i]['extencion'] == 'doc') {
                                ?>
                                                <img src="../../images/Microsoft Office 2007 Word.png" width="15" onclick="DescargarDoc('<?php echo $C_Archivos[$i]['Ubicaicion_url'] ?>')" style="cursor:pointer">
                                                <?php
                                            }
                                            if ($C_Archivos[$i]['extencion'] == 'pdf') {
                                                ?>
                                                <img src="../../images/Adobe_PDF_Reader.png" width="15" onclick="DescargarDoc('<?php echo $C_Archivos[$i]['Ubicaicion_url'] ?>')" style="cursor:pointer">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </fieldset>
                                </td>
                            </tr>
                                            <?php
                                        }
                                        ?>
                    </table>
                    <table border="0" align="center" cellpadding="0" cellspacing="0" width="90%">
                        <tr>
                            <td style="border:#FFFFFF 1px solid" align="justify">
                        <?php
                        if ($Indicador->fields['idTipo'] == 2) {
                            echo $VerIndicador = '<img src="../../images/view_multicolumn.png" width="20" title="Ver Indicador"  style="cursor:pointer" onclick="' . $VerUrl . '" />';
                        }

                        if ($Indicador->fields['idTipo'] == 3) {
                            echo $VerIndicador = '<img src="../../images/view_multicolumn.png" width="20" title="Ver Indicador"  style="cursor:pointer" onclick="' . $VerUrl . '" />';
                        }
                        ?>
                            </td>
                        </tr>
                    </table>
                                <?php
                            }
                            ?>
                <br />
                <hr class="ClassHr" align="center" >
                <br />
            </fieldset>
            <div class="BanerIndoDetalle" >&nbsp;&nbsp;</div>
        </div>
        <?php
    }

}

        #Fin Class

        function esPar($numero) {
            $resto = $numero % 2;
            if (($resto == 0) && ($numero != 0)) {
                return 1; #true
            } else {
                return 0; #false 
            }
        }
        ?>