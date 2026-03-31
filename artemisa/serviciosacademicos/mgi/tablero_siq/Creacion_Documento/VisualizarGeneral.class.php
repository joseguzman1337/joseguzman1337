<?php

class VisualizarGeneral {

    public function Principal($id = NULL) {
        global $userid, $db;

        if ($id === NULL) {
            $SQL_DeterminId = 'SELECT idsiq_estructuradocumento
                FROM `siq_estructuradocumento`
                WHERE codigoestado = 100
                ORDER BY fechainicial DESC
                LIMIT 1';

            if ($idSQL = &$db->Execute($SQL_DeterminId) === false) {
                echo 'Error en el SQl ....de la Estructura.......<br>' . $SQL_DeterminId;
                die;
            }
            $id = $idSQL->fields['idsiq_estructuradocumento'];
        }
        $SQL_Estructura = 'SELECT Estru.idsiq_estructuradocumento,
                Estru.nombre_documento, 
                Estru.nombre_entidad , 
                dis.nombre, 
                date(Estru.entrydate) AS fecha ,
                Estru.tipo_documento,
                Estru.id_carrera
            FROM siq_estructuradocumento AS Estru 
            INNER JOIN siq_discriminacionIndicador AS dis ON (Estru.tipo_documento=dis.idsiq_discriminacionIndicador )
            WHERE Estru.codigoestado=100 
                AND dis.codigoestado=100
                AND Estru.idsiq_estructuradocumento="' . $id . '"';


        if ($Estructura = &$db->Execute($SQL_Estructura) === false) {
            echo 'Error en el SQl ....de la Estructura.......<br>' ;
        }

        $SQL_Instrumentos = 'SELECT idsiq_estructuradocumento,
                nombre_documento
            FROM siq_estructuradocumento
            WHERE codigoestado = 100
                AND idsiq_estructuradocumento <> "' . $id . '"
            ORDER BY fechafinal DESC
            LIMIT 1';

        if ($Instrumentos = &$db->Execute($SQL_Instrumentos) === false) {
            echo 'Error en el SQl ....de la Estructura.......<br>'  ;
        }
        
        if (!isset($_REQUEST['action'])) {
        ?>
        <header>
            <a class="menuHeader" href="#"  id="<?php echo $Estructura->fields['idsiq_estructuradocumento'] ?>" onclick="cambioInstrumento(<?php echo $Estructura->fields['idsiq_estructuradocumento'] ?>);">
                <h3 class="underline h3active"><?php echo $Estructura->fields['nombre_documento'] ?></h3>
            </a>
            <a href="#" class="menuHeader" id="<?php echo $Instrumentos->fields['idsiq_estructuradocumento'] ?>" onclick="cambioInstrumento(<?php echo $Instrumentos->fields['idsiq_estructuradocumento'] ?>);">
                <h3><?php echo $Instrumentos->fields['nombre_documento'] ?></h3>
            </a>
        </header>
        <?php
        }

        $SQL_Datos = 'SELECT facEstru.idsiq_factoresestructuradocumento as id,
                facEstru.factor_id,
                Fac.codigo,
                Fac.idsiq_factor,
                Fac.nombre
            FROM siq_indicadoresestructuradocumento AS indEstru 
            INNER JOIN siq_factoresestructuradocumento AS facEstru ON (indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento )
            INNER JOIN siq_indicador AS ind ON (indEstru.indicador_id=ind.idsiq_indicador )
            INNER JOIN siq_indicadorGenerico AS indGen ON (ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico )
            INNER JOIN siq_aspecto AS asp ON (indGen.idAspecto=asp.idsiq_aspecto)
            INNER JOIN siq_caracteristica AS caract ON (asp.idCaracteristica=caract.idsiq_caracteristica)
            INNER JOIN siq_factor AS Fac ON (caract.idFactor=Fac.idsiq_factor)
            WHERE facEstru.idsiq_estructuradocumento="' . $id . '"
                AND facEstru.codigoestado=100
                AND indEstru.codigoestado=100
                AND ind.codigoestado=100
                AND indGen.codigoestado=100
                AND asp.codigoestado=100
                AND caract.codigoestado=100
                AND Fac.codigoestado=100
            GROUP BY facEstru.factor_id
            ORDER BY facEstru.Orden  ';

        if ($Datos = &$db->Execute($SQL_Datos) === false) {
            echo 'Error en el SQl -...<br>';
        }


        $SQL_Texto = 'SELECT											
                TextoInicio_id,
                titulo,
                cuerpo,
                autor,
                dependencia,
                orden
            FROM siq_Textoinicio

            WHERE documento_id="' . $id . '"
                AND codigoestado=100 
            ORDER BY orden';
        $Texto = $db->Execute($SQL_Texto);
        ?>        
        <div id="contenido">
            <div align="center" class="contentButtons"> 
                <?php
                $i = 0;
                $class = "";
                while (!$Datos->EOF) { 
                    ?>
                    <button type="button" class="btn btn-default CargarMenuFactor" 
                            onclick="CargarMenuFactor(<?php echo $Datos->fields['factor_id'] ?>, '<?php echo $Datos->fields['id'] ?>', '<?php echo $id ?>', '<?php echo $i ?>', this);" >
                                <?php echo strtoupper($Datos->fields['codigo']) ?>
                    </button>
                    <?php
                    $i++;
                    $Datos->MoveNext();
                }
                ?>
            </div>  
            <div id="CargarInfo" class="cajon"><!--Div >Contenedor de Texto -->
                <?php
                while (!$Texto->EOF) {
                    ?>
                <main>
                    <section> 
                        <div class="tituloFactor" align="center"><?php echo $Texto->fields['titulo'] ?></div> 
                        <div class="texto">
                            <p>
                                <?php echo $Texto->fields['cuerpo'] ?>
                                
                                <div id="autor_<?php echo $Texto->fields['orden'] ?>" class="autor">
                                    <strong><?php echo $Texto->fields['autor'] ?></strong><br /> 
                                    <strong><?php echo $Texto->fields['dependencia'] ?></strong>
                                </div>
                            </p>
                        </div>
                    </section>
                </main> 
                    <?php
                    $Texto->MoveNext();
                }
                ?>	
            </div>

            <?php
        }

        public function MenuFactor($Factor_id, $Estructura_id, $Doc_id, $i = 0) {
            global $userid, $db;

            $SQL_Factor = 'SELECT
                    idsiq_factor,
                    nombre,
                    codigo,
                    descripcion
                FROM siq_factor 
                WHERE codigoestado=100
                    AND idsiq_factor="' . $Factor_id . '"';

            if ($Factor = &$db->Execute($SQL_Factor) === false) {
                echo 'Error en el SQL ...<br>' ;
            }
            /**
             * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Se quita la pestaña 'Proceso de auto-evaluación'
             * @since Septiembre 23, 2019
             */ 
            ?>
            
            <main>
                <section> 
                    <div class="tituloFactor" align="center"><?php echo $Factor->fields['nombre'] ?></div> 
                    <div class="texto"><p><?php echo $Factor->fields['descripcion'] ?></p></div>
                </section>
            </main>
            
            <footer>
                <section>
                    <div class="divItemsFooter" id="divItemsFooter">
                        <a class="itemFooter itemFooterActive underline" onclick="Cargar('<?php echo $Factor_id; ?>', '<?php echo $Estructura_id; ?>', '<?php echo $Doc_id ?>', '<?php echo $i; ?>');">Caracteristicas<div class="arrow"></div></a>
                        <a class="itemFooter" onclick="cargarAnalisisFactor('<?php echo $Factor_id; ?>', 1, '<?php echo $Doc_id; ?>')">Análisis del factor<div class="arrow"></div></a>
                        <a class="itemFooter" onclick="cargarMejoraConsolidacion('<?php echo $Factor_id; ?>', '2', '<?php echo $Doc_id; ?>');">Oportunidades de consolidación<div class="arrow"></div></a>
                        <a class="itemFooter" onclick="cargarMejoraConsolidacion('<?php echo $Factor_id; ?>', '3', '<?php echo $Doc_id; ?>');">Oportunidades de mejora<div class="arrow"></div></a>
                        <a class="itemFooter" onclick="cargarAnalisisFactor('<?php echo $Factor_id; ?>', 4, '<?php echo $Doc_id; ?>')">Plan de desarrollo y mejora<div class="arrow"></div></a>
                    </div>
                    <div class="emergenteItem" id="emergenteItem">
                        <div id="caracteristica">
                        </div>
                    </div>
                </section>
            </footer>
            <script type="text/javascript">
                $(document).ready(function (){
                    $(".itemFooter").click(function(){
                        $(".itemFooter").removeClass("itemFooterActive").removeClass("underline");
                        $(this).addClass("itemFooterActive").addClass("underline");
                    });
                    $(".itemFooterActive").trigger("click");
                });
            </script>
            <?php
        }

        public function ListaCaracteristicas($Factor_id, $Estructura_id, $Doc_id, $i = 0) {

            global $userid, $db;
            ?>
            <?php $this->pintarCaracteristicas($db, $Estructura_id, $Factor_id, $Doc_id); ?> 
            <?php
        }

        public function pintarCaracteristicas($db, $Estructura_id, $Factor_id, $Doc_id) {
            $SQL_Caracteristica = 'SELECT  caract.idFactor,
                    caract.idsiq_caracteristica as id,
                    caract.nombre,
                    facEstru.factor_id,
                    caract.codigo
                FROM siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON (indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento )
                INNER JOIN siq_indicador AS ind ON  (indEstru.indicador_id=ind.idsiq_indicador )
                INNER JOIN siq_indicadorGenerico AS indGen ON (ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico )
                INNER JOIN siq_aspecto AS asp ON (indGen.idAspecto=asp.idsiq_aspecto )
                INNER JOIN siq_caracteristica AS caract ON (asp.idCaracteristica=caract.idsiq_caracteristica)
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura_id . '"
                    AND facEstru.codigoestado=100 
                    AND indEstru.codigoestado=100 
                    AND ind.codigoestado=100 
                    AND indGen.codigoestado=100 
                    AND asp.codigoestado=100 
                    AND caract.codigoestado=100 
                    AND facEstru.factor_id="' . $Factor_id . '" 
                GROUP BY caract.idsiq_caracteristica
                ORDER BY  indEstru.Orden';
            
            if ($Caractersiticas = &$db->Execute($SQL_Caracteristica) === false) {
                echo 'Error en el SQl de las Caracteristicas.....<br>' . $SQL_Caracteristica;
                die;
            }
            ?>
            <h4>Caracter&iacute;sticas:</h4>
            <ul class="caracteristicas">
                <?php
                $i = 0;
                while (!$Caractersiticas->EOF) {
                    ?>
                    <li><a class="caracteristica" id="Sombra_id_<?php echo $i ?>" onclick="CargarSub(<?php echo $i ?>, '<?php echo $Caractersiticas->fields['id']; ?>', '<?php echo $Factor_id; ?>', '<?php echo $Estructura_id; ?>', '<?php echo $Doc_id; ?>')"><?php echo $Caractersiticas->fields['codigo'] . '&nbsp;' . $Caractersiticas->fields['nombre'] ?></a></li>
                    <?php
                    $i++;
                    $Caractersiticas->MoveNext();
                }
                ?>
            </ul>
            <input type="hidden" id="Index" value="<?php echo $i ?>" />
            <?php
        }

        public function ListaAspecto($Caract_id, $Factor_id, $Estructura_id, $Doc_id) {
            global $userid, $db;

            $SQL_Factor = 'SELECT idsiq_factor,
                    nombre,
                    codigo,
                    descripcion
                FROM siq_factor 
                WHERE codigoestado=100
                    AND idsiq_factor="' . $Factor_id . '"';

            if ($Factor = &$db->Execute($SQL_Factor) === false) {
                echo 'Error en el SQL ...<br>' ;
            }


            $SQL_Caract = 'SELECT idsiq_caracteristica,
                    nombre,
                    descripcion,
                    codigo
                FROM siq_caracteristica
                WHERE idsiq_caracteristica="' . $Caract_id . '"
                    AND codigoestado=100';

            if ($Caracteristica = &$db->Execute($SQL_Caract) === false) {
                echo 'Error en el SQL ...<br>' ;
            }
            ?>
            
            <main>
                <section> 
                    <div class="tituloFactor" align="center">
                        <a class="volver" onclick="PreVolver('<?php echo $Factor_id ?>', '<?php echo $Estructura_id ?>', '<?php echo $Doc_id ?>')">
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-stop fa-stack-2x"></i>
                                <i class="fa fa-chevron-left fa-stack-1x fa-inverse"></i>
                            </span> 
                        </a>
                        <?php echo $Factor->fields['nombre'] ?>
                    </div> 
                    <div class="texto">
                        <p>
                            <strong class="caracteristica_nombre" style="display:block;"><?php echo $Caracteristica->fields['codigo'] . " " . $Caracteristica->fields['nombre'] ?></strong><br>
                            <?php echo $Caracteristica->fields['descripcion'] ?>
                        </p>
                        <p class="botones">
                            <button type="button" class="btn btn-success analisisCaracteristica" onclick="cargarAnalisisCaracteristica('<?php echo $Estructura_id ?>', '<?php echo $Factor_id ?>', '<?php echo $Caract_id; ?>', '<?php echo $Doc_id; ?>')" >Análisis de la Característica</button>
                        </p>
                    </div>
                    <div class="texto">
                        <div id="aspectos">
                            <?php $this->pintarAspectos($db, $Estructura_id, $Factor_id, $Caract_id); ?>
                        </div>
                    </div>
                </section>
            </main>
            <footer>
                <section>
                    <div class="emergenteItem" id="emergenteItem" style="display: block;">
                    </div>
                </section>
            </footer>
            <?php
        }

        public function pintarAspectos($db, $Estructura_id, $Factor_id, $Caract_id) {

            $SQL_Aspecto = 'SELECT caract.idFactor,
                    asp.idsiq_aspecto,
                    asp.nombre,
                    facEstru.factor_id,
                    facEstru.idsiq_estructuradocumento as Doc_id
                FROM  siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON (indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento )
                INNER JOIN siq_indicador AS ind ON (indEstru.indicador_id=ind.idsiq_indicador )
                INNER JOIN siq_indicadorGenerico AS indGen ON (ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico )
                INNER JOIN siq_aspecto AS asp ON (indGen.idAspecto=asp.idsiq_aspecto )
                INNER JOIN siq_caracteristica AS caract ON (asp.idCaracteristica=caract.idsiq_caracteristica )
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura_id . '" 
                    AND facEstru.codigoestado=100 
                    AND indEstru.codigoestado=100 
                    AND ind.codigoestado=100 
                    AND indGen.codigoestado=100 
                    AND asp.codigoestado=100 
                    AND caract.codigoestado=100 
                    AND facEstru.factor_id="' . $Factor_id . '"
                    AND asp.idCaracteristica="' . $Caract_id . '"
                GROUP BY asp.idsiq_aspecto
                ORDER BY CAST(SUBSTRING(asp.codigo,LOCATE("A",asp.codigo)+1) AS UNSIGNED) ASC';
            
            if ($Aspecto = &$db->Execute($SQL_Aspecto) === false) {
                echo 'Error en el SQl de los Aspecto.....<br>';
            }
            ?>
            <h4>Aspectos</h4>
            <ul class="aspectos">
            <?php
            $j = 0;
            while (!$Aspecto->EOF) {
                ?>
                <li>
                    <a class="aspecto" id="Sombra_id_<?php echo $j ?>" onclick="VerIndicaores(<?php echo $j ?>, '<?php echo $Aspecto->fields['idsiq_aspecto'] ?>', '<?php echo $Estructura_id ?>', '<?php echo $Factor_id ?>', '<?php echo $Aspecto->fields['Doc_id'] ?>', 'SubCargaInd_<?php echo $j ?>', this)">
                        <?php echo $Aspecto->fields['nombre'] ?>
                        <i class="fa fa-chevron-down icono"></i>
                    </a>
                    <div class="SubCargaInd" id="SubCargaInd_<?php echo $j ?>"></div>
                </li>
                <?php
                $j++;
                $Aspecto->MoveNext();
            }
            ?>
            </ul>
            <input type="hidden" id="Index" value="<?php echo $j ?>" />
            <input type="hidden" id="Index_Asp" value="<?php echo $j ?>" />
            <?php
        }

        public function AnalisisCaracteristica($db, $Caract_id, $Doc_id) {
            $sql = "select concat(c.codigo,c.nombre) as nombre
                        ,cig.idsiq_caracteristicainformaciongeneral
                        ,cig.resumen,
                        c.idFactor 
                from siq_caracteristica c
                left join siq_caracteristicainformaciongeneral cig using(idsiq_caracteristica)
                where idsiq_caracteristica=" . $Caract_id . " and cig.codigoestado=100 and cig.idsiq_estructuradocumento=" . $Doc_id;

            if ($caracteristica = &$db->Execute($sql) === false) {
                echo 'Error en el SQl de la descripción de la caracteristica.....<br>';
            }
            ?>
            <h4>Análisis</h4>
            <p style="margin-top:20px;"><?php echo $caracteristica->fields['resumen']; ?></p>

            <?php
        }

        public function pintarAnalisisFactor($db, $Factor_id, $tipo, $Doc_id) {
            $sql = "select f.nombre
                    ,fig.idsiq_factorinformaciongeneral
                    ,fig.resumen
                    ,fig.valoracion
                    ,fig.op_consolodacion
                    ,fig.op_mejora
                    ,fig.plan_desarrollo
                from siq_factor f
                left join siq_factorinformaciongeneral fig using(idsiq_factor) 
                where idsiq_factor=" . $Factor_id . " and fig.codigoestado=100 and fig.idsiq_estructuradocumento = " . $Doc_id;
            if ($factor = &$db->Execute($sql) === false) {
                echo 'Error en el SQl de la descripción del factor.....<br> ';
            }

            $texto = "";
            $titulo = "";
            if ($tipo == 1) {
                $texto = $factor->fields['resumen'];
                $titulo = "Análisis general";
            } else if ($tipo == 2) {
                $texto = $factor->fields['op_consolodacion'];
                $titulo = "Oportunidades de consolidación";
            } else if ($tipo == 3) {
                $texto = $factor->fields['op_mejora'];
                $titulo = "Oportunidades de mejora";
            } else if ($tipo == 4) {
                $texto = $factor->fields['plan_desarrollo'];
                $titulo = "Plan de desarrollo y mejora";
            }

            if ($texto === "" || $texto == null) {
                $texto = "Por incluir.";
            }

            $valoracion = $factor->fields['valoracion'];
            if ($valoracion === "" || $valoracion == null) {
                $valoracion = "0";
            }
            ?>
            <h4 style="display:inline-block;"><?php echo $titulo; ?></h4>
            <p style="margin-top:20px;"><?php echo $texto; ?></p>		
            <?php
        }

        public function procesosAutoevaluacionFactor($db, $Factor_id, $Doc_id) {
            $sql = "select idsiq_factorautoevaluacion
                ,nombre
                ,descripcion
                ,idsiq_documento
                ,fecha_creacion
                from siq_factorautoevaluacion f 
                join siq_documento using(idsiq_documento)
                where idsiq_factor=" . $Factor_id . " and f.codigoestado=100 
                order by fecha_creacion desc ";
            if ($procesos = &$db->Execute($sql) === false) {
                echo 'Error en el SQl de los procesos.....<br>' . $sql;
                die;
            }

            $i = 1;
            ?>
            <h4>Procesos de Autoevaluación</h4>
            <?php
            while (!$procesos->EOF) {
                $sql2 = "select idsiq_archivodocumento
                            ,nombre_archivo
                            ,descripcion
                            ,fecha_carga
                            ,Ubicaicion_url
                            ,changedate
                    from siq_archivo_documento
                    where siq_documento_id=" . $procesos->fields["idsiq_documento"] . " and codigoestado=100";

                $reg2 = &$db->Execute($sql2);
                ?>
                <div class="proceso">
                    <h5><?php echo $procesos->fields["nombre"] ?></h5>
                    <p><?php echo $procesos->fields["descripcion"] ?></p>
                    <ul class="archivos">
                        <?php
                        while (!$reg2->EOF) {
                            $ubicacion = explode(".", $reg2->fields["Ubicaicion_url"]);
                            $nombre = str_replace(" ", "_", str_replace(";", ".", str_replace(".", "", str_replace(".pdf", ";pdf", $reg2->fields['nombre_archivo']))));
                            if ($ubicacion[1] === "pdf") {
                                ?>
                                <li><a href="<?php echo "descargarPDF.php?ubicacion=" . $reg2->fields["Ubicaicion_url"]; ?>&nombre=<?php echo $nombre; ?>" style="text-decoration:none;color:#88AB0C;display:inline-block;width:95%;" ><?php echo $reg2->fields["nombre_archivo"] ?></a><br/><?php echo $reg2->fields["descripcion"] ?></li>
                            <?php } else { ?>
                                <li><a href="<?php echo "../../SQI_Documento/" . $reg2->fields["Ubicaicion_url"]; ?>" style="text-decoration:none;color:#88AB0C;display:inline-block;width:95%;" download="<?php echo $reg2->fields['nombre_archivo']; ?>"><?php echo $reg2->fields["nombre_archivo"] ?></a><br/><?php echo $reg2->fields["descripcion"] ?></li>
                                <?php
                            }
                            $reg2->MoveNext();
                        }
                        ?>
                    </ul>
                </div>
                <?php
                $i++;
                $procesos->MoveNext();
            }
            if ($i === 1) {
                echo "<p style='margin-top:20px;'>No hay procesos de autoevaluación.</p>";
            }
        }

        public function IndicadoresList($Aspecto_id, $Estructura_id, $Factor_id, $Doc_id) {
            global $userid, $db;
            ?>
            <div class="emergenteIndicador" id="indicador" >
                <?php
                $SQL_indicador = 'SELECT indEstru.idsiq_indicadoresestructuradocumento, 
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
                    FROM siq_indicadoresestructuradocumento AS indEstru 
                    INNER JOIN siq_factoresestructuradocumento AS facEstru ON (indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento )
                    INNER JOIN siq_indicador AS ind ON (indEstru.indicador_id=ind.idsiq_indicador )
                    INNER JOIN siq_indicadorGenerico AS indGen ON (ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico )
                    INNER JOIN siq_aspecto AS asp ON (indGen.idAspecto=asp.idsiq_aspecto )
                    INNER JOIN siq_caracteristica AS caract ON (asp.idCaracteristica=caract.idsiq_caracteristica )
                    WHERE  indEstru.idsiq_factoresestructuradocumento="' . $Estructura_id . '"
                        AND facEstru.codigoestado=100 
                        AND indEstru.codigoestado=100 
                        AND ind.codigoestado=100 
                        AND indGen.codigoestado=100 
                        AND asp.codigoestado=100 
                        AND caract.codigoestado=100
                        AND facEstru.factor_id="' . $Factor_id . '"
                        AND asp.idsiq_aspecto="' . $Aspecto_id . '"
                        AND ind.idsiq_estructuradocumento = "' . $Doc_id . '"
                    ORDER BY indEstru.Orden';
                if ($Indicador = &$db->Execute($SQL_indicador) === false) {
                    echo 'Error en el SQl ....<br>' ;
                }

                $d = 0;
                while (!$Indicador->EOF) {
                    ?>
                    <ul class="indicadores">
                        <li><a class="indicador" id="Open_<?php echo $d ?>" onclick="Ventana(<?php echo $Estructura_id ?>, '<?php echo $Factor_id ?>', '<?php echo $Indicador->fields['indicador_id'] ?>')"><?php echo $Indicador->fields['codigo'] . ' - ' . $Indicador->fields['nombre'] ?></a></li
                        <?php
                        $d++;
                        $Indicador->MoveNext();
                    }
                    ?>>
                </ul> 
                <input type="hidden" id="Index" value="<?php echo $d ?>" />
            </div>
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
                    ind.discriminacion,
                    f.codigo as codigoFactor  
                FROM siq_estructuradocumento as Estru_doc 
                INNER JOIN siq_factoresestructuradocumento  AS facEstru ON (Estru_doc.idsiq_estructuradocumento=facEstru.idsiq_estructuradocumento)
                INNER JOIN siq_indicadoresestructuradocumento AS indEstru  ON (indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento )
                INNER JOIN siq_indicador AS ind ON (indEstru.indicador_id=ind.idsiq_indicador )
                INNER JOIN siq_indicadorGenerico AS indGen ON (ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico) 
                INNER JOIN siq_aspecto AS asp ON (indGen.idAspecto=asp.idsiq_aspecto )
                INNER JOIN siq_caracteristica AS caract ON (asp.idCaracteristica=caract.idsiq_caracteristica )
                INNER JOIN siq_factor f ON (f.idsiq_factor=caract.idFactor )
                WHERE  indEstru.idsiq_factoresestructuradocumento="' . $Estructura_id . '"
                    AND facEstru.codigoestado=100 
                    AND indEstru.codigoestado=100 
                    AND ind.codigoestado=100 
                    AND indGen.codigoestado=100 
                    AND asp.codigoestado=100 
                    AND caract.codigoestado=100
                    AND facEstru.factor_id="' . $Factor_id . '"
                    AND indEstru.indicador_id="' . $Indicador_id . '"
                ORDER BY indEstru.Orden';

            if ($Indicador = &$db->Execute($SQL_indicador) === false) {
                echo 'Error en el SQl ....<br>';
            }
            ?>
            <div id="blanco">
                <div id="FormularioIndicador" class="cajon">
                    <h3 class="anaranjado"><?php echo $Indicador->fields['nombre'] ?></h2>
                        <div id="descripcion"><?php echo $Indicador->fields['descripcion'] ?></div>

                        <?php
                        /*                         * ************************************************************* */


                        $Fecha_ini = $Indicador->fields['fechainicial'];
                        $Fecha_fin = $Indicador->fields['fechafinal'];

                        $Permiso = 0;

                        if ($Indicador->fields['idTipo'] == 1) {#Si es Documental
                            $Permiso = 1;
                        }
                        if ($Indicador->fields['idTipo'] == 2) {#Percepción
                            $Permiso = 1;
                        }
                        if ($Indicador->fields['idTipo'] == 3) {#Numerico     
                            $Permiso = 1;
                        }
                        if ($Permiso = 1) {

                            $SQL_Doc = 'SELECT idsiq_documento,
                                    siqindicador_id
                                FROM siq_documento
                                WHERE codigoestado=100
                                    AND siqindicador_id="' . $Indicador->fields['idsiq_indicador'] . '"
                                    AND idsiq_estructuradocumento = "' . $Indicador->fields['Doc_id'] . '"';

                            if ($Documento = &$db->Execute($SQL_Doc) === false) {
                                echo 'Error en el SQL .....<br>';
                            }
                            //echo $SQL_Doc;

                            if ($Fecha_ini != '' && $Fecha_fin != '') {

                                $BETWEEN = 'AND (fecha_carga BETWEEN "' . $Fecha_ini . '" AND  "' . $Fecha_fin . '" OR  changedate BETWEEN "' . $Fecha_ini . '" AND  "' . $Fecha_fin . '")';
                            } else {
                                $BETWEEN = '';
                            }

                            $SQL_Archivos = 'SELECT idsiq_archivodocumento as id,
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
                                FROM siq_archivo_documento
                                WHERE siq_documento_id="' . $Documento->fields['idsiq_documento'] . '"
                                    AND version_final=1
                                    AND codigoestado=100
                                ' . $BETWEEN . '
                                ORDER BY tipo_documento ASC, nombre_archivo ASC';
                            
                            if ($Result_Archivos = &$db->Execute($SQL_Archivos) === false) {
                                echo 'Error en el SQl de los Archivos...<br>';
                            }

                            $C_Archivos = $Result_Archivos->GetArray();
                             
                            ?>

                            <div style="margin-top:20px; text-align:center;">
                                <?php
                                if ($Indicador->fields['idTipo'] == 2) {
                                    include_once("../../autoevaluacion/interfaz/funcionesAcreditacion.php");
                                    getInformePercepcion(trim($Indicador->fields['codigoFactor']), "color:#E77F18;font-weight:bold;text-decoration:none;");
                                }
                                ?>
                            </div>
                            <?php
                            $totalDocumentos = count($C_Archivos);
                            if ($totalDocumentos > 0) {
                                ?>
                                <h3 style="margin-top:30px;margin-bottom:0">Documentos Asociados</h3>
                                <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="margin-top:16px;">
                                    <?php
                                    for ($i = 0; $i < $totalDocumentos; $i++) {
                                        $nombre = $C_Archivos[$i]['descripcion'];
                                        if ($C_Archivos[$i]['tipo_documento'] == 1) {
                                            $nombre = "Documento Principal " . $Indicador->fields['codigo'];
                                        }
                                        ?>
                                        <tr>
                                            <td style="border:#FFFFFF 1px solid" align="justify">
                                                <fieldset style="height:90%; width:98%;border:0;border-bottom:#bbb solid 1px;padding: 10px 10px 15px;">
                                                    <div style="width:95%;margin-left:5px;" align="justify">
                                                        <?php
                                                        if ($C_Archivos[$i]['extencion'] == 'doc' || $C_Archivos[$i]['extencion'] == 'docx') {
                                                            //PARA LOS DOCUMENTOS PRINCIPALES QUISIERON DEJAR EL NOMBRE FIJO 
                                                            ?>
                                                            <a href="<?php echo "../../SQI_Documento/" . $C_Archivos[$i]['Ubicaicion_url']; ?>" style="text-decoration:none;color:#88AB0C;display:inline-block;width:95%;" download="Documento Principal <?php echo $Indicador->fields['codigo']; ?>"><?php echo $nombre; ?></a>
                                                            <?php
                                                        }
                                                        if ($C_Archivos[$i]['extencion'] == 'pdf') {
                                                            ?>
                                                            <a href="<?php echo "descargarPDF.php?ubicacion=" . $C_Archivos[$i]['Ubicaicion_url']; ?>&nombre=<?php echo str_replace(" ", "_", str_replace(";", ".", str_replace(".", "", str_replace(".pdf", ";pdf", $C_Archivos[$i]['nombre_archivo'])))); ?>" style="text-decoration:none;color:#88AB0C;display:inline-block;width:95%;" ><?php echo $nombre; ?></a>
                                                            <?php
                                                        } if ($C_Archivos[$i]['extencion'] == 'doc' || $C_Archivos[$i]['extencion'] == 'docx') {
                                                            ?>
                                                            <img src="../../images/Microsoft_Office_2007_Word.png" width="20" style="float:right;margin-top:2px;">
                                                            <?php
                                                        }
                                                        if ($C_Archivos[$i]['extencion'] == 'pdf') {
                                                            ?>
                                                            <img src="../../images/Adobe_PDF_Reader.png" width="20" style="float:right;margin-top:2px;">
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
                            <?php } ?>
                            <?php
                        }
                        ?>
                </div>
            </div>
        </div>
        <?php
    }

    public function DetallesIndicadorMejoraConsolidacion($Estructura_id, $Factor_id, $Indicador_id) {
        global $userid, $db;

        $SQL_indicador = 'SELECT o.idsiq_oportunidad as oid,
                o.nombre as onombre,
                o.descripcion as odescripcion,
                o.Valoracion,
                o.descripcionavance,
                e.nombre,
                e.descripcion
            FROM siq_oportunidades o
            INNER JOIN siq_factoresestructuradocumento f ON (o.idsiq_factorestructuradocumento = f.idsiq_factoresestructuradocumento)
            LEFT JOIN siq_evidenciaoportunidades e ON (e.idsiq_oportunidad = o.idsiq_oportunidad AND e.codigoestado = 100)
            WHERE f.factor_id = ' . $Factor_id . '
                AND o.codigoestado = 100
                AND f.codigoestado = 100
                AND o.idsiq_oportunidad = ' . $Indicador_id;

        if ($Indicador = &$db->Execute($SQL_indicador) === false) {
            echo 'Error en el SQl ....<br>';
        }
        ?>
        <div id="blanco">
            <div id="FormularioIndicador" class="cajon">
                <h3 class="anaranjado"><?php echo $Indicador->fields['onombre'] ?></h2>
                    <div id="descripcion"><?php echo  preg_replace('/style=\\"[^\\"]*\\"/', '', $Indicador->fields['odescripcion']); ?></div>			
                    <?php
                    if ($Indicador->fields['Valoracion'] < 25) {
                        $valoracion = 'Bajo';
                    } elseif ($Indicador->fields['Valoracion'] > 25 and $Indicador->fields['Valoracion'] <= 50) {
                        $valoracion = 'Medio';
                    } elseif ($Indicador->fields['Valoracion'] > 50 and $Indicador->fields['Valoracion'] < 75) {
                        $valoracion = 'Alto';
                    } else {
                        $valoracion = 'Muy Alto';
                    }

                    echo '<br /><b>Valoración de la oportunidad:</b> ' . $valoracion . '<br /><b>Descripción avance:</b> ' . preg_replace('/style=\\"[^\\"]*\\"/', '', $Indicador->fields['descripcionavance']);

                    $SQL_Archivos = 'SELECT nombre,
                            descripcion,
                            Ubicacion_url
                        FROM siq_evidenciaoportunidades
                        WHERE idsiq_oportunidad = ' . $Indicador->fields['oid'];
                    
                    if ($Result_Archivos = &$db->Execute($SQL_Archivos) === false) {
                        echo 'Error en el SQl de los Archivos...<br>' ;
                    }

                    $C_Archivos = $Result_Archivos->GetArray();

                    $totalDocumentos = count($C_Archivos);
                    if ($totalDocumentos > 0) {
                        ?>					
                        <h3 >Documentos de Evidencias</h3>
                        <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="margin-top:16px;">
                            <?php
                            for ($i = 0; $i < $totalDocumentos; $i++) {
                                $nombre = $C_Archivos[$i]['descripcion']; 
                                ?>
                                <tr>
                                    <td  style="position:relative; " align="justify">
                                        <fieldset style="position:relative; border-bottom:#bbb solid 1px;padding: 10px 10px 15px;">
                                            <div  align="justify">
                                                <a href="<?php echo "../Creacion_Docuemto/" . $C_Archivos[$i]['Ubicacion_url'] . $C_Archivos[$i]['nombre']; ?>" style="display:inline-block; " ><?php echo $nombre; ?></a>
                                                <a href="<?php echo "../Creacion_Docuemto/" . $C_Archivos[$i]['Ubicacion_url'] . $C_Archivos[$i]['nombre']; ?>" style="position:absolute; right: 0px; display:inline-block; " ><img src="../../images/download.png" width="20" ></a>

                                            </div>
                                        </fieldset>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    <?php } ?>
            </div>
        </div>
        </div>
        <?php
    }

    public function listaMejoraConsolidacion($db, $Factor_id = 0, $tipo = 0, $Doc_id = 0) {
        $sql = "select f.nombre
                ,fig.idsiq_factorinformaciongeneral
                ,fig.resumen
                ,fig.valoracion
                ,fig.op_consolodacion
                ,fig.op_mejora
                ,fig.plan_desarrollo
            from siq_factor f
            left join siq_factorinformaciongeneral fig using(idsiq_factor) 
            where idsiq_factor=" . $Factor_id . " and fig.codigoestado=100 and "
                . "fig.idsiq_estructuradocumento = " . $Doc_id;
        if ($factor = &$db->Execute($sql) === false) {
            echo 'Error en el SQl de la descripción del factor.....<br>'  ;
        }

        $tipoMejoraConsolidacion = ($tipo == 2) ? 2 : 1;

        $sqlMejoraConsolidacion = "SELECT
                o.idsiq_oportunidad,
                o.nombre
            FROM
                    siq_oportunidades o
            INNER JOIN siq_factoresestructuradocumento f ON o.idsiq_factorestructuradocumento = f.idsiq_factoresestructuradocumento
            WHERE
                    o.idsiq_tipooportunidad = " . $tipoMejoraConsolidacion . "
            AND f.factor_id = " . $Factor_id . "
            AND f.idsiq_estructuradocumento = " . $Doc_id . " 
            AND o.codigoestado = 100
            AND f.codigoestado = 100";

        /* END */
        if ($mejoraConsolidacion = &$db->Execute($sqlMejoraConsolidacion) === false) {
            echo 'Error en el SQl de la descripción del factor.....<br>'  ;
        }

        $texto = "";
        $titulo = "";
        if ($tipo == 2) {
            $texto = $factor->fields['op_consolodacion'];
            $titulo = "Oportunidades de consolidación";
        } else if ($tipo == 3) {
            $texto = $factor->fields['op_mejora'];
            $titulo = "Oportunidades de mejora";
        }

        if ($texto === "" || $texto == null) {
            $texto = "Por incluir.";
        }

        $valoracion = $factor->fields['valoracion'];
        if ($valoracion === "" || $valoracion == null) {
            $valoracion = "0";
        }
        ?>
        <h4 style="display:inline-block;"><?php echo $titulo; ?></h4> 


        <ul class="caracteristicas">
            <?php
            $i = 0;
            while (!$mejoraConsolidacion->EOF) {
                ?>
                <li><a class="caracteristica" id="Sombra_id_<?php echo $i ?>" onclick="Ventana(<?php echo $i ?>, '<?php echo $Factor_id; ?>', '<?php echo $mejoraConsolidacion->fields['idsiq_oportunidad']; ?>', 1)"><?php echo $mejoraConsolidacion->fields['nombre'] ?></a></li>
                <?php
                $i++;
                $mejoraConsolidacion->MoveNext();
            }
            ?>
        </ul>
        <input type="hidden" id="Index" value="<?php echo $i ?>" />
        <?php
    }

}


function esPar($numero) {
    $resto = $numero % 2;
    if (($resto == 0) && ($numero != 0)) {
        return 1; #true
    } else {
        return 0; #false 
    }
}
?>