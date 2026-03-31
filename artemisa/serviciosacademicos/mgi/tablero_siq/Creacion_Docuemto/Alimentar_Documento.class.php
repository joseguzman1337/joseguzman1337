<?php

class Alimentar_Documento {

    public function Principal() {
        global $userid, $db;
        ?>
        <div id="container">
            <h1>Gestionar Documento.</h1>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ver</span>
                    </button>
                    <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Generar Documento</span>
                    </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
                    <thead>
                        <tr>                            
                            <th>Nombre del Documento</th>
                            <th>Nombre de la Entidad</th>
                            <th>Tipo de Documento</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Fecha Inicial de Vigencia</th>
                            <th>Fecha Final de Vigencia</th>
                            <th>Fecha Creaci&oacute;n Documento</th>
                        </tr>
                    </thead>
                    <tbody>                       
                    </tbody>
                </table>
            </div>
            <br/>
        </div> 
        <?php
    }

    public function Ver($id) {
        include_once ('../../API_Monitoreo.php');
        $C_Api_Monitoreo = new API_Monitoreo();
        $List = $C_Api_Monitoreo->getQueryIndicadoresACargo();
        global $userid, $db;

        $SQL_Datos = 'SELECT				
                facEstru.idsiq_factoresestructuradocumento,
                facEstru.factor_id
            FROM
                siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto
                INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica
            WHERE facEstru.idsiq_estructuradocumento="' . $id . '"
                AND facEstru.codigoestado=100
                AND indEstru.codigoestado=100
                AND ind.codigoestado=100
                AND indGen.codigoestado=100
                AND asp.codigoestado=100
                AND caract.codigoestado=100
            GROUP BY facEstru.factor_id
            ORDER BY facEstru.Orden ';

        if ($Datos = &$db->Execute($SQL_Datos) === false) {
            echo 'Error en el SQl -...<br>' . $SQL_Datos;
            die;
        }
        ?>	
        <table border="0" width="90%" align="center" cellpadding="0" cellspacing="0">
            <?php
            $i = 1;
            while (!$Datos->EOF) {
                $SQL_Factor = 'SELECT
                        idsiq_factor,
                        nombre
                    FROM siq_factor 
                    WHERE odigoestado=100
                        AND idsiq_factor="' . $Datos->fields['factor_id'] . '"';

                if ($Factor = &$db->Execute($SQL_Factor) === false) {
                    echo 'Error en el SQL ...<br>' . $SQL_Factor;
                    die;
                }

                $SQL_Caract = 'SELECT
                        idsiq_caracteristica,
                        nombre
                        FROM siq_caracteristica
                        WHERE codigoestado=100
                        AND idsiq_caracteristica IN ( SELECT caract.idsiq_caracteristica
                            FROM siq_indicadoresestructuradocumento AS indEstru 
                            INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                            INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                            INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                            INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                            INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica
                            WHERE indEstru.idsiq_factoresestructuradocumento="' . $Datos->fields['idsiq_factoresestructuradocumento'] . '"
                            AND facEstru.codigoestado=100 
                            AND indEstru.codigoestado=100 
                            AND ind.codigoestado=100 
                            AND indGen.codigoestado=100 
                            AND asp.codigoestado=100 
                            AND caract.codigoestado=100
                            AND facEstru.factor_id="' . $Datos->fields['factor_id'] . '"
                                    ORDER BY indEstru.Orden
                        )';

                if ($Caracteristica = &$db->Execute($SQL_Caract) === false) {
                    echo 'Error en el SQl ....<br>' . $SQL_Caract;
                    die;
                }
                ?>
                <tr>
                    <td><br /><br /><strong><?php echo $i . '.&nbsp;&nbsp;' . $Factor->fields['nombre'] ?></strong><br /></td>
                </tr>    
                <?php
                $j = 1;
                while (!$Caracteristica->EOF) {
                    ?>
                    <tr>
                        <td><?php echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $i . '.' . $j . '.&nbsp;&nbsp;' . $Caracteristica->fields['nombre']; ?></td>
                    </tr>
                    <?php
                    $SQL_Aspecto = 'SELECT
                            idsiq_aspecto,
                            nombre
                            FROM iq_aspecto
                            WHERE codigoestado=100
                            AND idsiq_aspecto  IN ( SELECT asp.idsiq_aspecto
                                FROM siq_indicadoresestructuradocumento AS indEstru 
                                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                                INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                                INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                                INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
                                WHERE  indEstru.idsiq_factoresestructuradocumento="' . $Datos->fields['idsiq_factoresestructuradocumento'] . '"
                                AND facEstru.codigoestado=100 
                                AND indEstru.codigoestado=100 
                                AND ind.codigoestado=100 
                                AND indGen.codigoestado=100 
                                AND asp.codigoestado=100 
                                AND caract.codigoestado=100
                                AND caract.idsiq_caracteristica="' . $Caracteristica->fields['idsiq_caracteristica'] . '"
                                ORDER BY indEstru.Orden
                            )';

                    if ($Aspecto = &$db->Execute($SQL_Aspecto) === false) {
                        echo 'Error en el SQl ....<br>' . $SQL_Aspecto;
                        die;
                    }

                    $k = 1;
                    while (!$Aspecto->EOF) {
                        ?>
                        <tr>
                            <td><?php echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $i . '.' . $j . '.' . $k . '.&nbsp;&nbsp;' . $Aspecto->fields['nombre']; ?></td>
                        </tr>
                        <?php
                        $SQL_indicador = 'SELECT
                                indEstru.idsiq_indicadoresestructuradocumento, 
                                indGen.nombre, 
                                indEstru.idsiq_indicadoresestructuradocumento, 
                                indEstru.indicador_id, 
                                ind.idsiq_indicador,
                                ind.idEstado,
                                indGen.idTipo,
                                indGen.codigo 
                            FROM siq_indicadoresestructuradocumento AS indEstru 
                            INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                            INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                            INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                            INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                            INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
                            WHERE indEstru.idsiq_factoresestructuradocumento="' . $Datos->fields['idsiq_factoresestructuradocumento'] . '"
                                AND facEstru.codigoestado=100 
                                AND indEstru.codigoestado=100 
                                AND ind.codigoestado=100 
                                AND indGen.codigoestado=100 
                                AND asp.codigoestado=100 
                                AND caract.codigoestado=100
                                AND asp.idsiq_aspecto="' . $Aspecto->fields['idsiq_aspecto'] . '"
                                AND caract.idsiq_caracteristica="' . $Caracteristica->fields['idsiq_caracteristica'] . '"
                                AND facEstru.factor_id="' . $Datos->fields['factor_id'] . '"
                            ORDER BY indEstru.Orden';

                        if ($Indicador = &$db->Execute($SQL_indicador) === false) {
                            echo 'Error en el SQl ....<br>' . $SQL_indicador;
                            die;
                        }

                        $D_Indicador = $Indicador->GetArray();

                        if ($Mi_lista = &$db->Execute($List) === false) {
                            echo 'Error en SQL <br>..........' . $List;
                            die;
                        }

                        $Lista = $Mi_lista->GetArray();

                        for ($N = 0; $N < count($D_Indicador); $N++) {

                            $l = $N + 1;

                            if ($D_Indicador[$N]['idTipo'] == 1) {
                                $Tipo = 'Documental...';
                                $OnClick = 'Docuemtal(' . $i . ',' . $j . ',' . $k . ',' . $l . ');';
                                $Download = 'BuscarUrl(' . $i . ',' . $j . ',' . $k . ',' . $l . ');';
                            }
                            if ($D_Indicador[$N]['idTipo'] == 2) {
                                $Tipo = 'Percepci&oacute;n...';
                            }
                            if ($D_Indicador[$N]['idTipo'] == 3) {
                                $Tipo = 'Num&eacute;rico...';
                            }


                            if ($D_Indicador[$N]['idEstado'] == 1) {
                                $imagen = '<img src="../../images/delete.png" width="20%" title="' . $Tipo . '" onclick="' . $OnClick . '"/>';
                            }
                            if ($D_Indicador[$N]['idEstado'] == 2 || $D_Indicador[$N]['idEstado'] == 3) {
                                $imagen = '<span style="color:#93C">En Proceso</span>';
                            }
                            if ($D_Indicador[$N]['idEstado'] == 4) {
                                $imagen = '<img src="../../images/Check.png" width="20%" title="' . $Tipo . '" onclick="' . $Download . '" />';
                            }

                            for ($p = 0; $p < count($Lista); $p++) {

                                if ($D_Indicador[$N]['idsiq_indicador'] == $Lista[$p]['idsiq_indicador']) {
                                    $Color = '#FFFFFF';
                                    $funcion = 'onmouseover="Sombra(' . $i . ',' . $j . ',' . $k . ',' . $l . ')" onmouseout="Sin(' . $i . ',' . $j . ',' . $k . ',' . $l . ')"';
                                    ;
                                    break;
                                } else {
                                    $Color = '#CCCCCC';
                                }
                            }
                            ?>
                            <tr bgcolor="<?php echo $Color ?>">
                                <td  id="Td_indicador_<?php echo $i . '_' . $j . '_' . $k . '_' . $l ?>" <?php echo $funcion ?>><?php echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $i . '.' . $j . '.' . $k . '.' . $l . '.&nbsp;&nbsp;' . $D_Indicador[$N]['nombre']; ?><input type="hidden" id="id_ind_<?php echo $i . '_' . $j . '_' . $k . '_' . $l ?>" value="<?php echo $D_Indicador[$N]['idsiq_indicador'] ?>" /></td>
                                <td align="left" id="Td_imagen_<?php echo $i . '_' . $j . '_' . $k . '_' . $l ?>"><?php echo $imagen ?></td>
                            </tr>
                            <?php
                        }

                        $Aspecto->MoveNext();
                        $k++;
                    }

                    $Caracteristica->MoveNext();
                    $j++;
                }
                $Datos->MoveNext();
                $i++;
            }
            ?>
        </table>
        <?php
    }

    public function Nuevo_Ver($id) {
        global $userid, $db;

        $SQL_Estructura = 'SELECT 
                    Estru.idsiq_estructuradocumento,
                    Estru.nombre_documento, 
                    Estru.nombre_entidad , 
                    dis.nombre, 
                    date(Estru.entrydate) AS fecha ,
                    Estru.tipo_documento,
                    Estru.id_carrera
                    FROM siq_estructuradocumento AS Estru 
                    INNER JOIN siq_discriminacionIndicador AS dis ON Estru.tipo_documento=dis.idsiq_discriminacionIndicador 
                    WHERE Estru.codigoestado=100 
                    AND dis.codigoestado=100
                    AND Estru.idsiq_estructuradocumento="' . $id . '"';

        if ($Estructura = &$db->Execute($SQL_Estructura) === false) {
            echo 'Error en el SQl ....de la Estructura.......<br>' . $SQL_Estructura;
            die;
        }
        ?>

        <br /><br />
        <fieldset>
            <style>
                th, td{
                    border: 0px #FFFFFF;
                    padding: 0;
                }	
            </style>
            <table border="0"  cellpadding="0" cellspacing="0" width="90%" align="center" class="Table" >
                <tr>
                    <td style="font-size:30px"><strong><?php echo $Estructura->fields['nombre_documento'] ?></strong></td>
                </tr>
                <tr>
                    <td style="font-size:24px"><strong><?php echo $Estructura->fields['nombre_entidad'] ?></strong></td>
                </tr>
                <?php
                $SQL_Discriminacion = 'SELECT  
                                        idsiq_discriminacionIndicador as id,
                                        nombre
                                        FROM siq_discriminacionIndicador
                                        WHERE codigoestado=100
                                        AND idsiq_discriminacionIndicador="' . $Estructura->fields['tipo_documento'] . '"';

                if ($Discriminacion = &$db->Execute($SQL_Discriminacion) === false) {
                    echo 'Error en el SQL Discriminacion....<br>' . $SQL_Discriminacion;
                    die;
                }



                $SQL_falcutad_Edit = 'SELECT 
                                        carrera.codigocarrera ,
                                        carrera.nombrecarrera,
                                        facultad.codigofacultad,
                                        facultad.nombrefacultad
                                        FROM carrera, facultad
                                        WHERE carrera.codigofacultad=facultad.codigofacultad
                                        AND carrera.codigocarrera="' . $Estructura->fields['id_carrera'] . '"';


                if ($Facultad_Ex = &$db->Execute($SQL_falcutad_Edit) === false) {
                    echo 'Error en el SQL Facultad...<br>' . $SQL_falcutad;
                    die;
                }
                if ($Estructura->fields['tipo_documento'] == 3) {
                    $Style = '';
                    $Style_Td = '';
                } else {
                    $Style = 'style="display:none"';
                    $Style_Td = 'style="visibility:collapse"';
                }
                ?>
                <tr>
                    <td style="font-size:20px"><strong><?php echo $Discriminacion->fields['nombre'] ?></strong></td>
                </tr>
                <tr <?php echo $Style ?>>
                    <td style="font-size:20px"><strong><?php echo $Facultad_Ex->fields['nombrecarrera'] ?></strong></td>
                </tr>
            </table>
            <hr width="85%" />
            <br />
            <?php
            $SQL_Datos = 'SELECT
                        facEstru.idsiq_factoresestructuradocumento as id, 
                        facEstru.factor_id, 
                        fact.nombre 
                        FROM siq_indicadoresestructuradocumento AS indEstru 
                        INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                        INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                        INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                        INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto
                        INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica
                        INNER JOIN siq_factor AS fact ON facEstru.factor_id=fact.idsiq_factor
                        WHERE facEstru.idsiq_estructuradocumento="' . $id . '"
                        AND facEstru.codigoestado=100
                        AND indEstru.codigoestado=100
                        AND ind.codigoestado=100
                        AND indGen.codigoestado=100
                        AND asp.codigoestado=100
                        AND caract.codigoestado=100
                        GROUP BY facEstru.factor_id
                        ORDER BY facEstru.Orden ';

            if ($Datos = &$db->Execute($SQL_Datos) === false) {
                echo 'Error en el SQl -...<br>' . $SQL_Datos;
                die;
            }
            ?>
            <div style="width:95%; margin-left:2%" align="center" >
                <fieldset style="border:#316FC0 solid 1px; border-radius:8px; -moz-border-radius: 8px; -webkit-border-radius: 8px; display: table-cell; height:100%; width:30%; float:left; margin-right:1%; margin-left:1%">
                    <legend style="color:#316FC0;font-size:20px;font-weight: bold;letter-spacing:-1px;padding-bottom:20px;padding-top:8px;ext-transform:capitalize;">Factores...</legend>  
                    <div id="DivFactores" align="center" style="overflow:scroll;width:100%; height:345px; overflow-x:hidden;" >
                        <ul id="sortable_Factores" class="connectedSortable" style="list-style-type: none;padding: 0px;margin: 0px;">
                            <?php
                            $i = 0;
                            while (!$Datos->EOF) {
                                $SQL_Caracteristica = 'SELECT 
                                        caract.idFactor,
                                        caract.idsiq_caracteristica as id,
                                        caract.nombre,
                                        caract.codigo,
                                        facEstru.factor_id
                                        FROM siq_indicadoresestructuradocumento AS indEstru 
                                        INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                                        INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                                        INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                                        INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                                        INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
                                        WHERE  indEstru.idsiq_factoresestructuradocumento="' . $Datos->fields['id'] . '" 
                                        AND facEstru.codigoestado=100 
                                        AND indEstru.codigoestado=100 
                                        AND ind.codigoestado=100 
                                        AND indGen.codigoestado=100 
                                        AND asp.codigoestado=100 
                                        AND caract.codigoestado=100 
                                        AND facEstru.factor_id="' . $Datos->fields['factor_id'] . '" 
                                        GROUP BY caract.idsiq_caracteristica
                                        ORDER BY CAST(SUBSTRING(caract.codigo,LOCATE(" ",caract.codigo)+1) AS UNSIGNED),LENGTH(caract.codigo), caract.codigo';

                                if ($Caractersiticas = &$db->Execute($SQL_Caracteristica) === false) {
                                    echo 'Error en el SQl de las Caracteristicas.....<br>' . $SQL_Caracteristica;
                                    die;
                                }
                                $Color = $this->SemaforoColor($Datos->fields['factor_id'], $Datos->fields['id']);
                                ?>
                                <li class="ui-state-default selectFactores" style="text-align:left; width:auto;cursor:pointer; height:auto;clear:both;"  id="<?php echo $i; ?>" >
                                    <a href="#" style="width:100%;display:block;">
                                        <strong>
                                            <?php echo $Datos->fields['nombre'] ?>&nbsp;<?php $this->num_indicadores($Datos->fields['factor_id'], $Datos->fields['id'], $Color) ?>
                                            <div align="right" style="width:100%">
                                                <?php $this->SemaforoFactor($Datos->fields['factor_id'], $Datos->fields['id']); ?>
                                                <input type="hidden" id="id_<?php echo $i; ?>" value="<?php echo $Datos->fields['id']; ?>" />
                                            </div>
                                        </strong>
                                    </a>
                                    <ul id="sortable_menuFactores_<?php echo $i; ?>" class="connectedSortable" style="width:98%;list-style-type: none;padding: 0px;margin: 0px;float:right;clear:both;display:none;">
                                        <li class="ui-state-default noAction" style="text-align:left; width:auto;cursor:pointer; height:auto;" onclick="window.open('emergente.php?idsiq_estructuradocumento=<?php echo $id; ?>&idsiq_factor=<?php echo $Datos->fields['factor_id']; ?>&tp=dg1', '_blank', 'width=800,height=800');return false;" >
                                            <strong>Descripción general</strong>
                                        </li>
                                        <li class="ui-state-default noAction" style="text-align:left; width:auto;cursor:pointer; height:auto" onclick="window.open('emergente.php?idsiq_estructuradocumento=<?php echo $id; ?>&idsiq_factor=<?php echo $Datos->fields['factor_id']; ?>&tp=pa', '_blank', 'width=1200,height=630');return false;" >
                                            <strong>Procesos de autoevaluación</strong>
                                        </li>
                                        <li class="ui-state-default selectCaracteristicas" style="text-align:left; width:auto;cursor:pointer; height:auto"  >
                                            <a href="#" style="width:100%;display:block;"><strong>Características</strong></a>
                                            <ul class="connectedSortable" style="width:95%;list-style-type: none;padding: 0px;margin: 0px;float:right;clear:both;display:none;">
                                                <?php
                                                $j = 0;
                                                while (!$Caractersiticas->EOF) {
                                                    $Color = $this->SemaColorCaracteristica($Datos->fields['factor_id'], $Datos->fields['id'], $Caractersiticas->fields['id']);
                                                    ?>
                                                    <li class="ui-state-default selectCaracteristica" style="text-align:left;width:100%; cursor:pointer;clear:both;" >
                                                        <a href="#" style="width:100%;display:block;"><?php echo $Caractersiticas->fields['codigo'] . " " . $Caractersiticas->fields['nombre']; ?>
                                                            <?php $this->num_Caracteristica($Datos->fields['factor_id'], $Datos->fields['id'], $Color, $Caractersiticas->fields['id']); ?>
                                                        </a>
                                                        <input type="hidden" id="Caracteristica_id_<?php echo $j; ?>" value="<?php echo $Caractersiticas->fields['id']; ?>" />
                                                        <ul class="connectedSortable" style="width:95%;list-style-type: none;padding: 0px;margin: 0px;float:right;clear:both;display:none;" >
                                                            <li class="ui-state-default" style="text-align:left; width:auto;cursor:pointer; height:auto" onclick="window.open('emergente.php?idsiq_estructuradocumento=<?php echo $id; ?>&idsiq_caracteristica=<?php echo $Caractersiticas->fields['id'] ?>&tp=dg2', '_blank', 'width=800,height=800');return false;" >
                                                                <strong>Descripción general</strong>
                                                            </li>														
                                                            <li class="ui-state-default" style="text-align:left; width:auto;cursor:pointer; height:auto" 
                                                                onclick="Ver_indicador(<?php echo $j; ?>, '<?php echo $Datos->fields['factor_id']; ?>', '<?php echo $Datos->fields['id']; ?>',
                                                                                                '<?php echo $Estructura->fields['idsiq_estructuradocumento']; ?>', '<?php echo $Caractersiticas->fields['id']; ?>')" >
                                                                <strong>Indicadores</strong>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                    $Caractersiticas->MoveNext();
                                                    $j++;
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <?php
                                $Datos->MoveNext();
                                $i++;
                            }
                            ?>
                        </ul>
                        <input type="hidden" id="List_Factores" value="<?php echo $i ?>" />
                    </div>
                </fieldset>
                <fieldset style="border:#316FC0 solid 1px; border-radius:8px; -moz-border-radius: 8px; -webkit-border-radius: 8px; width:67%; margin-right:1%">
                    <legend style="color:#316FC0;font-size:20px;font-weight: bold;letter-spacing:-1px;padding-bottom:20px;padding-top:8px;ext-transform:capitalize;">Indicadores...</legend>  
                    <div align="right" style="width:100%">
                        <input type="hidden" id="cargado" value="0"  />
                        <input type="hidden" id="Factor_carga" />
                        <input type="hidden" id="Estructura_Carga"  />
                        <input type="hidden" id="Caracteristica_Carga"  />
                        <div id="DivIndicadores" align="center" style="overflow:scroll;width:100%; height:345px; overflow-x:hidden;" >
                            <table border="1" cellpadding="0" cellspacing="0" width="98%" align="center">
                                <tr bgcolor="#2964B1">
                                    <td width="10%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>N&deg;.</strong></td>
                                    <td width="55%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>Nombre.</strong></td>
                                    <td width="10%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>Tipo de Indicador.</strong></td>
                                    <td width="10%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>Estado.</strong></td>
                                    <td width="20%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>Acciones</strong></td>
                                </tr>
                            </table>
                        </div>
                </fieldset>
            </div>
        </fieldset>
        <?php
    }

    public function Todos($id, $Estructura, $Caracteristica_id, $id_Doc) {
        global $userid, $db;
        include_once ('../../API_Monitoreo.php');
        $C_Api_Monitoreo = new API_Monitoreo();
        include ('../monitoreo/class/Utils_monitoreo.php');
        $C_Utils_monitoreo = new Utils_monitoreo();
        $List = $C_Api_Monitoreo->getQueryIndicadoresACargo();

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
                    ind.discriminacion
                    FROM siq_indicadoresestructuradocumento AS indEstru 
                    INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                    INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                    INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                    INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                    INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
                    WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                    AND facEstru.codigoestado=100 
                    AND indEstru.codigoestado=100 
                    AND ind.codigoestado=100 
                    AND indGen.codigoestado=100 
                    AND asp.codigoestado=100 
                    AND caract.codigoestado=100
                    AND facEstru.factor_id="' . $id . '"
                    AND caract.idsiq_caracteristica="' . $Caracteristica_id . '"
                    AND facEstru.idsiq_estructuradocumento="' . $id_Doc . '"
                    AND ind.idsiq_estructuradocumento="' . $id_Doc . '"
                    ORDER BY indEstru.Orden';

        if ($Indicador = &$db->Execute($SQL_indicador) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indicador;
            die;
        }

        $D_Indicador = $Indicador->GetArray();

        $SQL_Fechas = 'SELECT 
                    fechafinal,
                    fechainicial
                    FROM siq_estructuradocumento
                    WHERE idsiq_estructuradocumento="' . $id_Doc . '"
                    AND codigoestado=100';

        if ($Fechas = &$db->Execute($SQL_Fechas) === false) {
            echo 'Error en el SQl De Buscar el Fechas....<br>' . $SQL_Fechas;
            die;
        }
        ?>
        <input type="hidden" id="Factor_id" value="<?php echo $id ?>" />
        <input type="hidden" id="Estructura" value="<?php echo $Estructura ?>" />
        <input type="hidden" id="id_doc" value="<?php echo $id_Doc ?>" />
        <input type="hidden" id="Caracteristica_id" value="<?php echo $Caracteristica_id ?>" />
        <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
            <tr bgcolor="#2964B1">
                <td width="10%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>N&deg;.</strong></td>
                <td width="55%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>Nombre.</strong></td>
                <td width="10%" align="center" style="border:#FFF solid 1px; color:#FFF; font-size:9px"><strong>Tipo de Indicador.</strong></td>
                <td width="10%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>Estado.</strong></td>
                <td width="20%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>Acciones</strong></td>
            </tr>
        <?php
        if ($Mi_lista = &$db->Execute($List) === false) {
            echo 'Error en SQL <br>..........' . $List;
            die;
        }

        $Lista = $Mi_lista->GetArray();

        for ($N = 0; $N < count($D_Indicador); $N++) {
            if ($D_Indicador[$N]['idTipo'] == 1) {
                $Tipo = 'Documental';
                $Download = 'BuscarUrl(' . $N . ');';
                $opc = '1';
            }
            if ($D_Indicador[$N]['idTipo'] == 2) {
                $Tipo = 'Percepci&oacute;n';
                $opc = '2';
            }
            if ($D_Indicador[$N]['idTipo'] == 3) {
                $Tipo = 'Num&eacute;rico';
                $opc = '3';
            }

            if ($D_Indicador[$N]['idEstado'] == 1) {
                $Estado = 'Desactualizado';
                $imagen = '<img src="../../images/Circle_Red.png" width="10%" title="' . $Estado . '" />';
            }

            if ($D_Indicador[$N]['idEstado'] == 2) {
                $Estado = 'En Proceso';
                $imagen = '<img src="../../images/Circle_Orange.png" width="10%" title="' . $Estado . '" />';
            }

            if ($D_Indicador[$N]['idEstado'] == 3) {
                $Estado = 'En Revisión';
                $imagen = '<img src="../../images/Circle_Orange.png" width="10%" title="' . $Estado . '" />';
            }

            if ($D_Indicador[$N]['idEstado'] == 4) {
                $Estado = 'Actualizado';
                $imagen = '<img src="../../images/Circle_Green.png" width="10%" title="' . $Estado . '" />'; #
                $Edit = '<img src="../../images/Check.png" width="30%" title="' . $Tipo . '" style="cursor:pointer" />';
            }

            for ($p = 0; $p < count($Lista); $p++) {
                if ($D_Indicador[$N]['idsiq_indicador'] == $Lista[$p]['idsiq_indicador']) {
                    $Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db, $D_Indicador[$N]['idsiq_indicador']);
                    $Edit_all = '<img src="../../images/file_search.png" width="20%" title="Visualizar Seguimiento y Control"  style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="Visualizar(' . $D_Indicador[$N]['idsiq_indicador'] . ')" />';

                    $Color = '#FFFFFF';
                    $funcion = 'onmouseover="Sombra(' . $i . ',' . $j . ',' . $k . ',' . $l . ')" onmouseout="Sin(' . $i . ',' . $j . ',' . $k . ',' . $l . ')"';

                    $Actualizar = array_search(1, $Permisos[1]);
                    $Seguimeinto = array_search(2, $Permisos[1]);
                    $Control = array_search(3, $Permisos[1]);

                    $SQL = 'SELECT 
                                    d.idsiq_documento,
                                    d.siqindicador_id, 
                                    a.idsiq_archivodocumento,
                                    a.siq_documento_id
                                    FROM siq_documento d 
                                    INNER JOIN siq_archivo_documento a ON d.idsiq_documento=a.siq_documento_id  AND d.codigoestado=100 AND a.codigoestado=100
                                    WHERE d.siqindicador_id="' . $D_Indicador[$N]['idsiq_indicador'] . '"
                                    AND d.idsiq_estructuradocumento = ' . $id_Doc;

                    if ($ExistenDocumentos = &$db->Execute($SQL) === false) {
                        echo 'error en el SQl de existen documento para el indicador...<br><br>' . $SQL;
                        die;
                    }

                    if ($D_Indicador[$N]['idEstado'] == 1 && ($D_Indicador[$N]['idTipo'] == 1 || $D_Indicador[$N]['idTipo'] == 2 || $D_Indicador[$N]['idTipo'] == 3)) {
                        $Cargar = $this->getScriptFunction($D_Indicador[$N]['idsiq_indicador'], $id_Doc, $ExistenDocumentos);
                    }

                    if (($D_Indicador[$N]['idEstado'] == 2 || $D_Indicador[$N]['idEstado'] == 3 || $D_Indicador[$N]['idEstado'] == 4) && ($D_Indicador[$N]['idTipo'] == 1 || $D_Indicador[$N]['idTipo'] == 2 || $D_Indicador[$N]['idTipo'] == 3)) {
                        $update = $this->getScriptFunction($D_Indicador[$N]['idsiq_indicador'], $id_Doc, $ExistenDocumentos);
                    }

                    if (($D_Indicador[$N]['idEstado'] == 2 || $D_Indicador[$N]['idEstado'] == 3 || $D_Indicador[$N]['idEstado'] == 4) && ($D_Indicador[$N]['es_objeto_analisis'] == 1 || $D_Indicador[$N]['tiene_anexo'] == 1)) {
                        $update = $this->getScriptFunction($D_Indicador[$N]['idsiq_indicador'], $id_Doc, $ExistenDocumentos);
                    }

                    if (($D_Indicador[$N]['idEstado'] == 2 || $D_Indicador[$N]['idEstado'] == 3 || $D_Indicador[$N]['idEstado'] == 4) && $D_Indicador[$N]['inexistente'] == 1) {
                        $update = $this->getScriptFunction($D_Indicador[$N]['idsiq_indicador'], $id_Doc, $ExistenDocumentos);
                    }

                    $ActualizaFormulario = "";
                    if ($D_Indicador[$N]['idEstado'] == 1) {
                        $Estado_0 = 'Desactualizado';
                        $imagen = '<img src="../../images/Circle_Red.png" width="10%" title="' . $Estado_0 . '" />'; #
                        $Edit_0 = '<img src="../../images/file_edit.png" width="20%" title="Actualizar indicador"  style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="' . $Cargar . '"   />';
                    }

                    if ($D_Indicador[$N]['idEstado'] == 2) {
                        $Estado_0 = 'En Proceso';
                        $imagen = '<img src="../../images/Circle_Orange.png" width="10%" title="' . $Estado_0 . '" />';
                        $Edit_0 = '<img src="../../images/file_edit.png" width="20%"  style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="' . $update . '"/>&nbsp;<img src="../../images/done2.png" width="20%" title="Enviar a Revision" style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="EnvairRevision(' . $D_Indicador[$N]['idsiq_indicador'] . ')"/>';
                    }

                    if ($D_Indicador[$N]['idEstado'] == 3) {
                        $Estado_0 = 'En Revisión';
                        $imagen = '<img src="../../images/Circle_Orange.png" width="10%" title="' . $Estado_0 . '" />';
                        $Edit_0 = '<img src="../../images/file_edit.png" width="20%" title="Actualizar" style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="' . $update . '" />';
                    }

                    if ($D_Indicador[$N]['idEstado'] == 4) {
                        $Edit_0 = '<img src="../../images/file_edit.png" width="20%" title="Actualizar " style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="' . $update . '" />';
                    }

                    if ($Permisos[1][$Seguimeinto] == 2) {
                        if ($D_Indicador[$N]['idEstado'] == 1) {
                            $Estado_1 = 'Desactualizado';
                            $imagen = '<img src="../../images/Circle_Red.png" width="10%" title="' . $Estado_1 . '" />'; #
                            $Edit_1 = '<img src="../../images/missed_call.png" width="20%" title="Realizar seguimiento" style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="IrSeguimiento(' . $D_Indicador[$N]['idsiq_indicadorGenerico'] . ',' . $D_Indicador[$N]['idsiq_indicador'] . ')" />';
                        }
                        if ($D_Indicador[$N]['idEstado'] == 2) {
                            $Estado_1 = 'En Proceso';
                            $imagen = '<img src="../../images/Circle_Orange.png" width="10%" title="' . $Estado_1 . '" />';
                            $Edit_1 = '<img src="../../images/missed_call.png" width="20%" title="Realizar seguimiento" style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="IrSeguimiento(' . $D_Indicador[$N]['idsiq_indicadorGenerico'] . ',' . $D_Indicador[$N]['idsiq_indicador'] . ')" />';
                        }
                        if ($D_Indicador[$N]['idEstado'] == 3) {
                            $Estado_1 = 'En Revisión';
                            $imagen = '<img src="../../images/Circle_Orange.png" width="10%" title="' . $Estado_1 . '" />';
                            $Edit_1 = '<img src="../../images/missed_call.png" width="20%" title="Realizar seguimiento" style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="IrSeguimiento(' . $D_Indicador[$N]['idsiq_indicadorGenerico'] . ',' . $D_Indicador[$N]['idsiq_indicador'] . ')" />';
                        }
                        if ($D_Indicador[$N]['idEstado'] == 4) {
                            $Estado_1 = 'Actualizado';
                            $imagen = '<img src="../../images/Circle_Green.png" width="10%"  title="' . $Estado_1 . '" />';
                            $Edit_1 = '<img src="../../images/missed_call.png" width="20%" title="Realizar seguimiento" style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="IrSeguimiento(' . $D_Indicador[$N]['idsiq_indicadorGenerico'] . ',' . $D_Indicador[$N]['idsiq_indicador'] . ')" />';
                        }
                    }

                    if ($Permisos[1][$Control] == 3 && $D_Indicador[$N]['idEstado'] == 3) {
                        $Estado_2 = 'En Revisión';
                        $imagen = '<img src="../../images/Circle_Orange.png" width="10%" title="' . $Estado_2 . '" />';
                        $Edit_2 = '<img src="../../images/seo_successful_planning_checkmark-256.png" width="20%" title="Realizar revisión" style="cursor:pointer;margin:2px;max-height:26px;width:auto" onclick="Control(' . $D_Indicador[$N]['idsiq_indicadorGenerico'] . ',' . $D_Indicador[$N]['idsiq_indicador'] . ',' . $D_Indicador[$N]['Doc_id'] . ')" />';
                    }

                    if ($D_Indicador[$N]['idEstado'] == 4) {
                        $Estado = 'Actualizado';
                        $imagen = '<img src="../../images/Circle_Green.png" width="10%"  title="' . $Estado . '" />'; #
                        $Edit_2 = '<img src="../../images/seo_successful_planning_checkmark-256.png" width="20%" title="Realizar revisión" style="cursor:pointer;margin:2px;max-height:26px;width:auto" onclick="Control(' . $D_Indicador[$N]['idsiq_indicadorGenerico'] . ',' . $D_Indicador[$N]['idsiq_indicador'] . ',' . $D_Indicador[$N]['Doc_id'] . ')" />';
                    }
                    break;
                } else {
                    $Edit = '';
                    $Edit_0 = '';
                    $Edit_1 = '';
                    $Edit_2 = '';
                    $Edit_all = '';
                    $VerIndicador = '';
                    $ActualizaFormulario = '';
                }
            }
            $i = $N + 1;

            $val = esPar($i);

            if ($val == 0) {
                $Color = 'bgcolor="#FFFFFF"';
            } else {
                $Color = 'bgcolor="#DEDDF6"';
            }

            $Principal = '';
            $Otras = '';
            $Other = '';

            if ($D_Indicador[$N]['idTipo'] == 1 && $D_Indicador[$N]['idEstado'] == 1) {
                $Principal = 'Documental';
            }
            if ($D_Indicador[$N]['inexistente'] == 1 && $D_Indicador[$N]['idTipo'] == 3 && $D_Indicador[$N]['idEstado'] == 1) {
                $Otras = 'Num&eacute;rico Documental';
            }
            if (($D_Indicador[$N]['es_objeto_analisis'] == 1 || $D_Indicador[$N]['tiene_anexo'] == 1) && $D_Indicador[$N]['idTipo'] == 2) {
                $Other = 'Percepci&oacute;n Documental';
            }

            if ($D_Indicador[$N]['idTipo'] == 1) {
                $SQL_Doc = 'SELECT idsiq_documento
                            FROM siq_documento
                            WHERE siqindicador_id="' . $D_Indicador[$N]['idsiq_indicador'] . '"
                            AND codigoestado=100
                            AND idsiq_estructuradocumento="' . $id_Doc . '"';

                if ($Documento = &$db->Execute($SQL_Doc) === false) {
                    echo 'Error en el SQl De Buscar el Documento....<br>' . $SQL_Doc;
                    die;
                }

                $VerUrl = "VerIndicador('" . $Documento->fields['idsiq_documento'] . "','1','" . $D_Indicador[$N]['discriminacion'] . "','" . $Fechas->fields['fechainicial'] . "','" . $Fechas->fields['fechafinal'] . "'," . $D_Indicador[$N]['idsiq_indicador'] . ", '" . $id_Doc . "')";
            }

            if ($D_Indicador[$N]['idTipo'] == 2) {
                $VerUrl = "VerIndicador(" . $D_Indicador[$N]['idsiq_indicador'] . ",'2','" . $D_Indicador[$N]['discriminacion'] . "','" . $Fechas->fields['fechainicial'] . "','" . $Fechas->fields['fechafinal'] . "','', '" . $id_Doc . "')";
            }

            if ($D_Indicador[$N]['idTipo'] == 3) {
                $VerUrl = "VerIndicador(" . $D_Indicador[$N]['idsiq_indicador'] . ",'3','" . $D_Indicador[$N]['discriminacion'] . "','" . $Fechas->fields['fechainicial'] . "','" . $Fechas->fields['fechafinal'] . "','', '" . $id_Doc . "')";
            }

            $VerIndicador = '<img src="../../images/viewNumbers.png" width="20%" title="Ver Indicador"  style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="' . $VerUrl . '" />';
            ?>
                <tr <?php echo $Color ?>>
                    <td align="center"><?php echo $i ?></td>
                    <td><?php echo $D_Indicador[$N]['codigo'] . '&nbsp;-&nbsp;' . $D_Indicador[$N]['nombre'] ?><input type="hidden" id="id_ind_<?php echo $N ?>" value="<?php echo $D_Indicador[$N]['idsiq_indicador'] ?>" /></td>
                    <td align="center" style="font-size:12px"><?php echo $Tipo ?></td>
                    <td align="center">
            <?php echo $imagen ?>
                    </td>
                    <td>
                        <div style="margin:0;text-align:center;">
            <?php echo $VerIndicador . '' . $ActualizaFormulario . '' . $Edit . '' . $Edit_0 . '' . $Edit_1 . '' . $Edit_2 . '' . $Edit_all ?>
                        </div>
                    </td>
                </tr>
                <tr><td colspan="5">&nbsp;</td></tr>
            <?php
        }
        ?>
        </table>
            <?php
        }

        private function getScriptFunction($idsiq_indicador, $id_Doc, $ExistenDocumentos) {
            if (!$ExistenDocumentos->EOF) {
                $return = 'VerModificarDocumentos(' . $idsiq_indicador . ',' . $id_Doc . ')';
            } else {
                $return = 'CargarDocumento(' . $idsiq_indicador . ',' . $id_Doc . ')';
            }
            return $return;
        }

        public function Dialogo($id_ind, $id_Doc) {
            global $userid, $db;
            $this->Documentos($id_ind, $id_Doc);
        }

        public function Documentos($indicador_id, $id_Doc) {
            global $userid, $db;
            ini_set('error_reporting', E_ALL);

            include ('../monitoreo/class/Utils_monitoreo.php');
            $C_Utils_monitoreo = new Utils_monitoreo();

            $Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db, $indicador_id);

            $year = date('Y');
            $monunt = date('m');

            if ($monunt < 6) {
                $Periodo_num = '1';
            } else {
                $Periodo_num = '2';
            }

            $Periodo = $year . '-' . $Periodo_num;

            $SQL = 'SELECT idsiq_documento '
                    . ' FROM siq_documento  '
                    . ' WHERE  siqindicador_id="' . $indicador_id . '" '
                    . ' AND periodo="' . $Periodo . '" '
                    . ' AND idsiq_estructuradocumento="' . $id_Doc . '" '
                    . ' AND codigoestado=100';

            if ($Existe = &$db->Execute($SQL) === false) {
                echo 'Error en el SQl...<br><br>' . $SQL;
                die;
            }

            if (!$Existe->EOF) {
                $Documento_id = $Existe->fields['idsiq_documento'];

                $url = HTTP_ROOT . '/serviciosacademicos/mgi/SQI_Documento/Documento_Ver.html.php?actionID=Modificar_New&idsiq_estructuradocumento=' . $id_Doc . '&Docuemto_id=' . $Documento_id;
                ?>
            <script>
                var url = '<?php echo $url ?>';
                window.location.href = url;
            </script>
            <?php
        } else {
            $SQL_Datos = 'SELECT
                        ind.idsiq_indicador,
                        ind.idIndicadorGenerico,
                        ind.idCarrera,
                        ind.discriminacion,
                        gen.idsiq_indicadorGenerico,
                        gen.idAspecto,
                        gen.nombre as nombre_ind,
                        asp.idsiq_aspecto,
                        asp.idCaracteristica,
                        asp.nombre as Nombre_asp,
                        carct.idsiq_caracteristica,
                        carct.idFactor,
                        carct.nombre as nombre_carct,
                        fac.idsiq_factor,
                        fac.nombre as nombre_fac,
                        gen.idTipo,
                        tipo.nombre,
                        ind.es_objeto_analisis,
                        ind.tiene_anexo,
                        gen.codigo
                        FROM siq_indicador as ind 
                        INNER JOIN siq_indicadorGenerico as gen ON  ind.idIndicadorGenerico=gen.idsiq_indicadorGenerico 
                        INNER JOIN siq_tipoIndicador AS tipo ON gen.idTipo=tipo.idsiq_tipoIndicador
                        INNER JOIN siq_aspecto as asp ON gen.idAspecto=asp.idsiq_aspecto  
                        INNER JOIN siq_caracteristica as carct  ON asp.idCaracteristica=carct.idsiq_caracteristica 
                        INNER JOIN  siq_factor as fac  on carct.idFactor=fac.idsiq_factor 
                        WHERE ind.idsiq_indicador="' . $indicador_id . '"
                        AND ind.codigoestado=100 
                        AND gen.codigoestado=100 
                        AND asp.codigoestado=100 
                        AND carct.codigoestado=100 
                        AND fac.codigoestado=100 
                        AND tipo.codigoestado=100';

            if ($Datos = &$db->Execute($SQL_Datos) === false) {
                echo 'Error en el SQL Datos de percepcion......<br>' . $SQL_Datos;
                die;
            }

            $P_Datos = $Datos->GetArray();
            ?>
            <link rel="stylesheet" href="../../css/style.css" type="text/css" />
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
            <fieldset>
                <legend>Cargar Documentos Indicadores Documental</legend>  
                <form action="../../SQI_Documento/Cargar_archivoDinamico.php?id=<?php echo $P_Datos[0]['idsiq_indicador']; ?>" method="post" enctype="multipart/form-data" name="Principal">
                    <table width="90%" border="0" cellpadding="0" cellspacing="0" style="font-family:'Times New Roman', Times, serif" align="center" class="Border">
                        <tr class="Border">
                            <td class="Border"><strong>Factor:</strong></td>
                            <td class="Border"><?php echo $P_Datos[0]['nombre_fac'] ?></td>
                        </tr>
                        <tr class="Border">
                            <td class="Border"><strong>Caracteristica:</strong></td>
                            <td class="Border"><?php echo $P_Datos[0]['nombre_carct'] ?></td>
                        </tr>
                        <tr class="Border">
                            <td class="Border"><strong>Aspecto a Evaluar:</strong></td>
                            <td class="Border"><?php echo $P_Datos[0]['Nombre_asp'] ?></td>
                        </tr>
                        <tr class="Border">
                            <td class="Border"><strong>Indicador:</strong></td>
                            <td class="Border"><?php echo $P_Datos[0]['codigo'] . '&nbsp;--&nbsp;' . $P_Datos[0]['nombre_ind'] ?></td>
                        </tr>
                        <tr class="Border">
                            <td class="Border"><strong>Tipo Indicador:</strong></td>
                            <td class="Border"><?php echo $P_Datos[0]['nombre'] ?></td>
                        </tr>
            <?php
            if (($P_Datos[0]['idTipo'] == 1 || $P_Datos[0]['idTipo'] == 2 || $P_Datos[0]['idTipo'] == 3) && $P_Datos[0]['es_objeto_analisis'] == 0 && $P_Datos[0]['tiene_anexo'] == 0) {
                $Archivo = 'Principal';
            }
            if (($P_Datos[0]['idTipo'] == 1 || $P_Datos[0]['idTipo'] == 2 || $P_Datos[0]['idTipo'] == 3) && $P_Datos[0]['es_objeto_analisis'] == 1 && $P_Datos[0]['tiene_anexo'] == 0) {
                $Archivo = 'Principal &oacute; Analisis';
            }
            if (($P_Datos[0]['idTipo'] == 1 || $P_Datos[0]['idTipo'] == 2 || $P_Datos[0]['idTipo'] == 3) && $P_Datos[0]['es_objeto_analisis'] == 1 && $P_Datos[0]['tiene_anexo'] == 1) {
                $Archivo = 'Principal &oacute; Analisis &oacute; Anexo';
            }
            if ($P_Datos[0]['idTipo'] != 1 && $P_Datos[0]['es_objeto_analisis'] == 1 && $P_Datos[0]['tiene_anexo'] == 0) {
                $Archivo = 'Analisis';
            }
            if ($P_Datos[0]['idTipo'] != 1 && $P_Datos[0]['es_objeto_analisis'] == 0 && $P_Datos[0]['tiene_anexo'] == 1) {
                $Archivo = 'Anexo';
            }
            if ($P_Datos[0]['idTipo'] != 1 && $P_Datos[0]['es_objeto_analisis'] == 1 && $P_Datos[0]['tiene_anexo'] == 1) {
                $Archivo = 'Analisis &oacute; Anexo';
            }
            if ($P_Datos[0]['idTipo'] == 1 && $P_Datos[0]['es_objeto_analisis'] == 0 && $P_Datos[0]['tiene_anexo'] == 1) {
                $Archivo = 'Principal &oacute; Anexo';
            }
            ?>
                        <tr class="Border">
                            <td class="Border"><strong>Tipo Archivo:</strong></td>
                            <td class="Border"><?php echo $Archivo ?></td>
                        </tr>
            <?php
            switch ($P_Datos[0]['discriminacion']) {
                case '1':
                    $Nombre = 'Institucional';
                    $Relacion = '&nbsp;&nbsp;';
                    $ver = ' style="visibility:collapse"';
                    break;
                case '2':
                    $Nombre = 'Faculta';
                    $Relacion = '&nbsp;&nbsp;';
                    $ver = ' style="visibility:collapse"';
                    break;
                case '3':
                    $Nombre = 'Programa';

                    $SQL_Carrera = 'SELECT codigocarrera,
                                        nombrecarrera
                                        FROM carrera
                                        WHERE codigocarrera="' . $P_Datos[0]['idCarrera'] . '"';

                    if ($Carrera = &$db->Execute($SQL_Carrera) === false) {
                        echo 'Error alBuscar la Carrera...<br>' . $SQL_Carrera;
                        die;
                    }

                    $Relacion = $Carrera->fields['nombrecarrera'];
                    $ver = '';
                    break;
            }
            ?>
                        <tr class="Border">
                            <td class="Border"><strong>Discriminaci&oacute;n</strong></td>
                            <td class="Border"><?php echo $Nombre ?></td>
                        </tr>
                        <tr class="Border">
                            <td colspan="2" class="Border">&nbsp;</td>
                        </tr>
                        <tr class="Border">
                            <td colspan="2" class="Border"><input type="file" id="file" name="file" height="80px"  size="50" accept="application/pdf"/><br><samp style="color:#000; font-size:9px">10 Mb Max / Word </samp></td>
                        </tr>
                        <tr class="Border">
                            <td align="center" colspan="2" class="Border">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Border">
                                    <tr class="Border">
                                        <td width="30%" class="Border"><strong>Tipo Documento:</strong></td>
                                        <td width="30%" class="Border"><strong>Periodo:</strong></td>
                                        <td width="40%" class="Border"><strong <?php echo $ver ?>><?php echo $Nombre ?></strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="Border">
                            <td align="center" colspan="2" class="Border">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Border">
                                    <tr class="Border">
                                        <td width="30%" class="Border">
                                            <select id="Tipo_Carga_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" name="Tipo_Carga_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" style="width: auto">
                                                <option value="-1">Elige...</option>
                                                <option value="1">Principal</option>
                                                <option value="2" onClick="validar_tipo('1', '<?php echo $P_Datos[0]['idsiq_indicador'] ?>')">An&aacute;lisis</option>
                                                <option value="3" onClick="validar_tipo('2', '<?php echo $P_Datos[0]['idsiq_indicador'] ?>')">Anexo</option>
                                            </select>
                                        </td>
                                        <td width="30%" class="Border">
            <?php
            $year = date('Y');
            $monunt = date('m');

            if ($monunt < 6) {
                $Periodo_num = '1';
            } else {
                $Periodo_num = '2';
            }
            ?>
                                            <input type="text" value="<?php echo $year . '-' . $Periodo_num; ?>"  id="Periodo_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" name="Periodo_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" size="8" readonly style="text-align:center">
                                        </td>
                                        <td width="40%" <?php echo $ver ?> class="Border"><?php echo $Relacion ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="Border">
                            <td align="left" colspan="2" class="Border"><strong>&nbsp;&nbsp;Descripcion del Archivo:&nbsp;&nbsp;<span style="color:#F00; font-size:10px">(*)</span></strong></td>
                        </tr>
                        <tr class="Border">
                            <td colspan="2" class="Border">&nbsp;</td>
                        </tr>
                        <tr class="Border">
                            <td align="center" colspan="2" class="Border"><textarea  id="Descripcion_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" name="Descripcion_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" style="width:90%" cols="20" rows="10"></textarea></td>
                        </tr>
                        <tr class="Border">
                            <td colspan="2" align="center" class="Border"><input type="submit" id="Save" name="Save" value="Guardar" onClick="return Validar(<?php echo $P_Datos[0]['idsiq_indicador'] ?>);" /></td>
                        </tr>
                        <tr class="Border">
                            <td colspan="2" class="Border">&nbsp;
                                <input type="hidden" id="Factor_id_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" name="Factor_id_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" value="<?php echo $P_Datos[0]['idsiq_factor'] ?>"/>
                                <br>  
                                <input type="hidden" id="caracteristica_id_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" name="caracteristica_id_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" value="<?php echo $P_Datos[0]['idsiq_caracteristica'] ?>" />
                                <br>
                                <input type="hidden" id="Aspecto_id_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" name="Aspecto_id_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" value="<?php echo $P_Datos[0]['idsiq_aspecto'] ?>" />
                                <br>
                                <input type="hidden" id="Inicador_id_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" name="Inicador_id_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" value="<?php echo $indicador_id; ?>" />
                                <br />
                                <input type="hidden" id="Analisi_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" name="Analisi_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" value="<?php echo $P_Datos[0]['es_objeto_analisis']; ?>" />
                                <br />
                                <input type="hidden" id="Anexo_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" name="Anexo_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" value="<?php echo $P_Datos[0]['tiene_anexo'] ?>" />
                                <br />
                                <input type="hidden" id="Tipo_indicador_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" name="Tipo_indicador_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" value="<?php echo $P_Datos[0]['idTipo'] ?>" />
                                <br>
                                <input type="hidden" id="id_DocumentoEstrucutra_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" name="id_DocumentoEstrucutra_<?php echo $P_Datos[0]['idsiq_indicador'] ?>" value="<?php echo $id_Doc ?>" />
                        </tr>
                    </table>
                </form>
            </fieldset>
            <?php
        }
    }

    public function Propios($id, $Estructura, $Caracteristica_id, $id_Doc) {
        $session_recarga = $_SESSION["session_recarga"];
        $id = $session_recarga["id"];
        $id_estructura = $session_recarga["id_estructura"];
        $id_doc = $session_recarga["id_doc"];
        $Caracteristica_id = $session_recarga["Caracteristica_id"];

        global $userid, $db;

        include_once ('../../API_Monitoreo.php');
        $C_Api_Monitoreo = new API_Monitoreo();
        include ('../monitoreo/class/Utils_monitoreo.php');
        $C_Utils_monitoreo = new Utils_monitoreo();

        $List = $C_Api_Monitoreo->getQueryIndicadoresACargo();

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
                    facEstru.idsiq_estructuradocumento AS Doc_id,
                    indGen.codigo,
                    ind.discriminacion
                    FROM siq_indicadoresestructuradocumento AS indEstru 
                    INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                    INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                    INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                    INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                    INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica
                    WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                    AND facEstru.codigoestado=100 
                    AND indEstru.codigoestado=100 
                    AND ind.codigoestado=100 
                    AND indGen.codigoestado=100 
                    AND asp.codigoestado=100 
                    AND caract.codigoestado=100
                    AND facEstru.factor_id="' . $id . '"
                    AND caract.idsiq_caracteristica="' . $Caracteristica_id . '"
                    ORDER BY indEstru.Orden';

        if ($Indicador = &$db->Execute($SQL_indicador) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indicador;
            die;
        }

        $D_Indicador = $Indicador->GetArray();
        ?>
        <input type="hidden" id="Factor_id" value="<?php echo $id ?>" />
        <input type="hidden" id="Estructura" value="<?php echo $Estructura ?>" />
        <input type="hidden" id="id_doc" value="<?php echo $id_Doc ?>" />
        <input type="hidden" id="Caracteristica_id" value="<?php echo $Caracteristica_id ?>" />
        <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
            <tr bgcolor="#2964B1">
                <td width="10%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>N&deg;.</strong></td>
                <td width="55%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>Nombre.</strong></td>
                <td width="10%" align="center" style="border:#FFF solid 1px; color:#FFF; font-size:9px"><strong>Tipo de Indicador.</strong></td>
                <td width="10%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>Estado.</strong></td>
                <td width="20%" align="center" style="border:#FFF solid 1px; color:#FFF"><strong>Opcion.</strong></td>
            </tr>
        <?php
        if ($Mi_lista = &$db->Execute($List) === false) {
            echo 'Error en SQL <br>..........' . $List;
            die;
        }

        $Lista = $Mi_lista->GetArray();

        for ($N = 0; $N < count($D_Indicador); $N++) {
            if ($D_Indicador[$N]['idTipo'] == 1) {
                $Tipo = 'Documental';
                $Download = 'BuscarUrl(' . $N . ');';
                $opc = '1';
            }
            if ($D_Indicador[$N]['idTipo'] == 2) {
                $Tipo = 'Percepci&oacute;n';
                $opc = '2';
            }
            if ($D_Indicador[$N]['idTipo'] == 3) {
                $Tipo = 'Num&eacute;rico';
                $opc = '3';
            }

            for ($p = 0; $p < count($Lista); $p++) {
                $Estado_0 = "";
                $imagen = "";
                $Edit_0 = "";
                $Edit_1 = "";
                $Edit_2 = "";
                $Edit_all = '';

                if ($D_Indicador[$N]['idsiq_indicador'] == $Lista[$p]['idsiq_indicador']) {

                    $Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db, $D_Indicador[$N]['idsiq_indicador']);

                    $Edit_all = '<img src="../../images/file_search.png" width="20%" title="Visualizar Seguimiento y Control"  style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="Visualizar(' . $D_Indicador[$N]['idsiq_indicador'] . ')" />';

                    $Color = '#FFFFFF';
                    $funcion = 'onmouseover="Sombra(' . $i . ',' . $j . ',' . $k . ',' . $l . ')" onmouseout="Sin(' . $i . ',' . $j . ',' . $k . ',' . $l . ')"';

                    $Actualizar = array_search(1, $Permisos[1]);
                    $Seguimeinto = array_search(2, $Permisos[1]);
                    $Control = array_search(3, $Permisos[1]);

                    if ($D_Indicador[$N]['idEstado'] == 1 && $D_Indicador[$N]['idTipo'] == 1) {
                        $Cargar = 'CargarDocumento(' . $D_Indicador[$N]['idsiq_indicador'] . ',' . $id_Doc . ')';
                    }

                    if ($D_Indicador[$N]['idEstado'] == 1 && $D_Indicador[$N]['idTipo'] == 2) {
                        $Cargar = 'CargarDocumento(' . $D_Indicador[$N]['idsiq_indicador'] . ',' . $id_Doc . ')';
                    }

                    if ($D_Indicador[$N]['idEstado'] == 1 && $D_Indicador[$N]['idTipo'] == 3) {
                        $Cargar = 'CargarDocumento(' . $D_Indicador[$N]['idsiq_indicador'] . ',' . $id_Doc . ',' . $D_Indicador[$N]['idTipo'] . ')';
                    }

                    if ($D_Indicador[$N]['idEstado'] == 1 && $D_Indicador[$N]['idTipo'] == 3) {
                        $Actualizaar_Doc = 'ActualizaFormulario(' . $D_Indicador[$N]['idsiq_indicador'] . ')';
                    }
                    /**
                     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
                     * Se agrega el parametro $id_Doc para que visualice los documentos adjuntos
                     * @since Junio 11, 2019
                     */ 
                    if (($D_Indicador[$N]['idEstado'] == 2 || $D_Indicador[$N]['idEstado'] == 3 || $D_Indicador[$N]['idEstado'] == 4) && ($D_Indicador[$N]['idTipo'] == 1 || $D_Indicador[$N]['idTipo'] == 2 || $D_Indicador[$N]['idTipo'] == 3)) {
                        $update = 'VerModificarDocumentos(' . $D_Indicador[$N]['idsiq_indicador'] . ',' . $id_Doc . ')';
                    }

                    if (($D_Indicador[$N]['idEstado'] == 2 || $D_Indicador[$N]['idEstado'] == 3 || $D_Indicador[$N]['idEstado'] == 4) && ($D_Indicador[$N]['es_objeto_analisis'] == 1 || $D_Indicador[$N]['tiene_anexo'] == 1)) {
                        $update = 'VerModificarDocumentos(' . $D_Indicador[$N]['idsiq_indicador'] . ',' . $id_Doc . ')';
                    }

                    if (($D_Indicador[$N]['idEstado'] == 2 || $D_Indicador[$N]['idEstado'] == 3 || $D_Indicador[$N]['idEstado'] == 4) && $D_Indicador[$N]['inexistente'] == 1) {
                        $update = 'VerModificarDocumentos(' . $D_Indicador[$N]['idsiq_indicador'] . ',' . $id_Doc . ')';
                    }

                    if ($D_Indicador[$N]['idEstado'] == 1 && $Permisos[1][$Actualizar] == 1) {
                        $Estado_0 = 'Desactualizado';
                        $imagen = '<img src="../../images/Circle_Red.png" width="10%" title="' . $Estado_0 . '" />'; #
                        $Edit_0 = '<img src="../../images/file_edit.png" width="20%" title="Actualizar" style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="' . $Cargar . '" />';
                    }

                    if ($D_Indicador[$N]['idEstado'] == 2 && $Permisos[1][$Actualizar] == 1) {
                        $Estado_0 = 'En Proceso';
                        $imagen = '<img src="../../images/Circle_Orange.png" width="10%" title="' . $Estado_0 . '" />';
                        $Edit_0 = '<img src="../../images/file_edit.png" width="20%" title="Actualizar" style="cursor:pointer;margin-right:5px;" onclick="' . $update . '" />&nbsp;<img src="../../images/done2.png" width="20%" title="Enviar a Revision" style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="EnvairRevision(' . $D_Indicador[$N]['idsiq_indicador'] . ')"/>';
                    }

                    if ($D_Indicador[$N]['idEstado'] == 3 && $Permisos[1][$Actualizar] == 1) {
                        $Estado_0 = 'En Revisión';
                        $imagen = '<img src="../../images/Circle_Orange.png" width="10%" title="' . $Estado_0 . '" />';
                        $Edit_0 = '<img src="../../images/file_edit.png" width="20%" title="Actualizar " style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="' . $update . '" />';
                    }

                    if ($D_Indicador[$N]['idEstado'] == 4 && $Permisos[1][$Actualizar] == 1) {
                        $Edit_0 = '<img src="../../images/file_edit.png" width="20%" title="Actualizar " style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="' . $update . '" />';
                    }

                    if ($Permisos[1][$Seguimeinto] == 2) {
                        if ($D_Indicador[$N]['idEstado'] == 1) {
                            $Estado_1 = 'Desactualizado';
                            $imagen = '<img src="../../images/Circle_Red.png" width="10%" title="' . $Estado_1 . '" />'; #
                            $Edit_1 = '<img src="../../images/missed_call.png" width="20%" title="Realizar seguimiento" style="cursor:pointer;margin:2px;max-height:25px;width:auto"  onclick="IrSeguimiento(' . $D_Indicador[$N]['idsiq_indicadorGenerico'] . ',' . $D_Indicador[$N]['idsiq_indicador'] . ')"/>';
                        }

                        if ($D_Indicador[$N]['idEstado'] == 2) {
                            $Estado_1 = 'En Proceso';
                            $imagen = '<img src="../../images/Circle_Orange.png" width="10%" title="' . $Estado_1 . '" />';
                            $Edit_1 = '<img src="../../images/missed_call.png" width="20%" title="Realizar seguimiento" style="cursor:pointer;margin:2px;max-height:25px;width:auto"  onclick="IrSeguimiento(' . $D_Indicador[$N]['idsiq_indicadorGenerico'] . ',' . $D_Indicador[$N]['idsiq_indicador'] . ')"/>';
                        }

                        if ($D_Indicador[$N]['idEstado'] == 3) {
                            $Estado_1 = 'En Revisión';
                            $imagen = '<img src="../../images/Circle_Orange.png" width="10%" title="' . $Estado_1 . '" />';
                            $Edit_1 = '<img src="../../images/missed_call.png" width="20%" title="Realizar seguimiento" style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="IrSeguimiento(' . $D_Indicador[$N]['idsiq_indicadorGenerico'] . ',' . $D_Indicador[$N]['idsiq_indicador'] . ')" />';
                        }

                        if ($D_Indicador[$N]['idEstado'] == 4) {
                            $Estado_1 = 'Actualizado';
                            $imagen = '<img src="../../images/Circle_Green.png" width="10%"  title="' . $Estado_1 . '" />';
                            $Edit_1 = '<img src="../../images/missed_call.png" width="20%" title="Realizar seguimiento" style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="IrSeguimiento(' . $D_Indicador[$N]['idsiq_indicadorGenerico'] . ',' . $D_Indicador[$N]['idsiq_indicador'] . ')"/>';
                        }
                    }

                    if ($Permisos[1][$Control] == 3 && $D_Indicador[$N]['idEstado'] == 3) {
                        $Estado_2 = 'En Revisión';
                        $imagen = '<img src="../../images/Circle_Orange.png" width="10%" title="' . $Estado_2 . '" />';
                        $Edit_2 = '<img src="../../images/seo_successful_planning_checkmark-256.png" width="20%" title="Realizar revisión" style="cursor:pointer;margin:2px;max-height:26px;width:auto" onclick="Control(' . $D_Indicador[$N]['idsiq_indicadorGenerico'] . ',' . $D_Indicador[$N]['idsiq_indicador'] . ',' . $D_Indicador[$N]['Doc_id'] . ')"  />';
                    }

                    $Edit = '';
                    if ($D_Indicador[$N]['idEstado'] == 4) {
                        $Estado = 'Actualizado';
                        $imagen = '<img src="../../images/Circle_Green.png" width="10%"  title="' . $Estado . '" />'; #
                        $Edit_2 = '<img src="../../images/seo_successful_planning_checkmark-256.png" width="20%" title="Realizar revisión" style="cursor:pointer;margin:2px;max-height:26px;width:auto" onclick="Control(' . $D_Indicador[$N]['idsiq_indicadorGenerico'] . ',' . $D_Indicador[$N]['idsiq_indicador'] . ',' . $D_Indicador[$N]['Doc_id'] . ')"  />';
                    }

                    $i = $N + 1;
                    $val = esPar($i);
                    if ($val == 0) {
                        $Color = 'bgcolor="#FFFFFF"';
                    } else {
                        $Color = 'bgcolor="#DEDDF6"';
                    }

                    $Principal = '';
                    $Otras = '';
                    $Other = '';

                    if ($D_Indicador[$N]['idTipo'] == 1 && $D_Indicador[$N]['idEstado'] == 1) {
                        $Principal = 'Documental';
                    }
                    if ($D_Indicador[$N]['inexistente'] == 1 && $D_Indicador[$N]['idTipo'] == 3 && $D_Indicador[$N]['idEstado'] == 1) {
                        $Otras = 'Num&eacute;rico Documental';
                    }
                    if (($D_Indicador[$N]['es_objeto_analisis'] == 1 || $D_Indicador[$N]['tiene_anexo'] == 1) && $D_Indicador[$N]['idTipo'] == 2) {
                        $Other = 'Percepci&oacute;n Documental';
                    }

                    $SQL_Fechas = 'SELECT 
                            fechafinal,
                            fechainicial
                            FROM siq_estructuradocumento
                            WHERE idsiq_estructuradocumento="' . $id_Doc . '"
                            AND codigoestado=100';

                    if ($Fechas = &$db->Execute($SQL_Fechas) === false) {
                        echo 'Error en el SQl De Buscar el Fechas....<br>' . $SQL_Fechas;
                        die;
                    }

                    if ($D_Indicador[$N]['idTipo'] == 1) {
                        $SQL_Doc = 'SELECT idsiq_documento
                                FROM siq_documento
                                WHERE siqindicador_id="' . $D_Indicador[$N]['idsiq_indicador'] . '"
                                AND codigoestado=100';

                        if ($Documento = &$db->Execute($SQL_Doc) === false) {
                            echo 'Error en el SQl De Buscar el Documento....<br>' . $SQL_Doc;
                            die;
                        }
                        /**
                         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
                         * Se agregan y se modifican los parametros para que se visualicen los documentos por MGI.
                         * @since Abril 26, 2019
                         */
                        $VerUrl = "VerIndicador(" . $Documento->fields['idsiq_documento'] . ",'1','" . $D_Indicador[$N]['discriminacion'] . "','" . $Fechas->fields['fechainicial'] . "','" . $Fechas->fields['fechafinal'] . "', " . $Documento->fields['idsiq_documento'] . ", '" . $D_Indicador[$N]['Doc_id'] . "')";
                    }

                    if ($D_Indicador[$N]['idTipo'] == 2) {
                        $VerUrl = "VerIndicador(" . $D_Indicador[$N]['idsiq_indicador'] . ",'2','" . $D_Indicador[$N]['discriminacion'] . "','" . $Fechas->fields['fechainicial'] . "','" . $Fechas->fields['fechafinal'] . "', " . $D_Indicador[$N]['idsiq_indicador'] . ",'" . $D_Indicador[$N]['Doc_id'] . "')";
                    }

                    if ($D_Indicador[$N]['idTipo'] == 3) {
                        $VerUrl = "VerIndicador(" . $D_Indicador[$N]['idsiq_indicador'] . ",'3','" . $D_Indicador[$N]['discriminacion'] . "','" . $Fechas->fields['fechainicial'] . "','" . $Fechas->fields['fechafinal'] . "', " . $D_Indicador[$N]['idsiq_indicador'] . ",'" . $D_Indicador[$N]['Doc_id'] . "')";
                    }

                    $VerIndicador = '<img src="../../images/viewNumbers.png" width="20%" title="Ver Indicador"  style="cursor:pointer;margin:2px;max-height:25px;width:auto" onclick="' . $VerUrl . '" />';
                    ?>
                        <tr <?php echo $Color ?>>
                            <td align="center"><?php echo $i ?></td>
                            <td><?php echo $D_Indicador[$N]['codigo'] . '&nbsp;-&nbsp;' . $D_Indicador[$N]['nombre'] ?><input type="hidden" id="id_ind_<?php echo $N ?>" value="<?php echo $D_Indicador[$N]['idsiq_indicador'] ?>" /></td>
                            <td align="center" style="font-size:12px"><?php echo $Tipo ?></td>
                            <td align="center">
                    <?php echo $imagen; ?>
                            </td>
                            <td align="center">
                                <div style="margin:0;text-align:center;">
                    <?php echo $VerIndicador . '' . $ActualizaFormulario . '' . $Edit . '' . $Edit_0 . '' . $Edit_1 . '' . $Edit_2 . '' . $Edit_all ?>
                                </div>
                            </td>
                        </tr>
                        <tr><td colspan="5">&nbsp;</td></tr>
                    <?php
                }
            }
        }
        ?>
        </table>
        <script type="text/javascript">
            var id = <?php echo!empty($id) ? $id : 0; ?>;
            var id_estructura = <?php echo!empty($id_estructura) ? $id_estructura : 0; ?>;
            var id_doc = <?php echo!empty($id_doc) ? $id_doc : 0; ?>;
            var Caracteristica_id = <?php echo!empty($Caracteristica_id) ? $Caracteristica_id : 0; ?>;
            function validarReload() {
                $.ajax({//Ajax
                    type: 'GET',
                    url: 'Alimentar_Documento.html.php',
                    async: false,
                    dataType: 'json',
                    data: ({actionID: 'reloadIndicadores'}),
                    error: function (objeto, quepaso, otroobj) {
                        alert('Error de Conexión , Favor Vuelva a Intentar');
                    },
                    success: function (data) {
                        if (data.s === true) {
                            Ver_indicador(0, id, id_estructura, id_doc, Caracteristica_id);
                        }
                    }
                });
            }
            var inervalReload = setInterval(function () {
                validarReload();
            }, 1733);
        </script>
        <?php
    }

    public function SemaforoFactor($id, $Estructura) {
        global $userid, $db;

        $SQL_indiNumTotal = 'SELECT COUNT(indEstru.indicador_id) AS num_indi
                FROM  siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                AND facEstru.codigoestado=100 
                AND indEstru.codigoestado=100 
                AND ind.codigoestado=100 
                AND indGen.codigoestado=100 
                AND facEstru.factor_id="' . $id . '"';

        if ($IndicadorTotal = &$db->Execute($SQL_indiNumTotal) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indiNumTotal;
            die;
        }

        $NumTotal = $IndicadorTotal->fields['num_indi'];

        $SQL_indiDesactualizado = 'SELECT COUNT(indEstru.indicador_id) AS num_indi
                FROM siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                AND facEstru.codigoestado=100 
                AND indEstru.codigoestado=100 
                AND ind.codigoestado=100 
                AND indGen.codigoestado=100 
                AND facEstru.factor_id="' . $id . '"
                AND ind.idEstado=1';

        if ($IndicadorDesactualizado = &$db->Execute($SQL_indiDesactualizado) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indiDesactualizado;
            die;
        }

        $NumDesactualizado = 0;

        $NumDesactualizado = ($IndicadorDesactualizado->fields['num_indi'] * 100) / $NumTotal;

        $SQL_indiProceso = 'SELECT COUNT(indEstru.indicador_id) AS num_indi
                FROM siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                AND facEstru.codigoestado=100 
                AND indEstru.codigoestado=100 
                AND ind.codigoestado=100 
                AND indGen.codigoestado=100 
                AND facEstru.factor_id="' . $id . '"
                AND (ind.idEstado=2 OR ind.idEstado=3)';

        if ($IndicadorProceso = &$db->Execute($SQL_indiProceso) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indiProceso;
            die;
        }

        $NumProceso = 0;
        $NumProceso = ($IndicadorProceso->fields['num_indi'] * 100) / $NumTotal;

        $SQL_indiActualizado = 'SELECT COUNT(indEstru.indicador_id) AS num_indi
                FROM siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                AND facEstru.codigoestado=100 
                AND indEstru.codigoestado=100 
                AND ind.codigoestado=100 
                AND indGen.codigoestado=100 
                AND facEstru.factor_id="' . $id . '"
                AND ind.idEstado=4';

        if ($IndicadorActualizado = &$db->Execute($SQL_indiActualizado) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indiActualizado;
            die;
        }

        $NumActualizado = 0;

        $NumActualizado = ($IndicadorActualizado->fields['num_indi'] * 100) / $NumTotal;

        $NumFinal = $NumProceso + $NumActualizado;

        if ($NumDesactualizado >= 50) {
            ?>
            <img src="../../images/Circle_Red.png" width="3%"  />
            <?php
        }
        if ($NumFinal > 50 && $NumActualizado != 100) {
            ?>
            <img src="../../images/Circle_Orange.png" width="3%"  />
            <?php
        }
        if ($NumActualizado == 100) {
            ?>
            <img src="../../images/Circle_Green.png" width="3%"  />
            <?php
        }
    }

    public function num_indicadores($id, $Estructura, $Color) {
        global $userid, $db;
        include_once ('../../API_Monitoreo.php');
        $C_Api_Monitoreo = new API_Monitoreo();
        $List = $C_Api_Monitoreo->getQueryIndicadoresACargo();

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
                    indGen.idsiq_indicadorGenerico
                    FROM siq_indicadoresestructuradocumento AS indEstru 
                    INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                    INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                    INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                    INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                    INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
                    WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                    AND facEstru.codigoestado=100 
                    AND indEstru.codigoestado=100 
                    AND ind.codigoestado=100 
                    AND indGen.codigoestado=100 
                    AND asp.codigoestado=100 
                    AND caract.codigoestado=100
                    AND facEstru.factor_id="' . $id . '"
                    ORDER BY indEstru.Orden';

        if ($Indicador = &$db->Execute($SQL_indicador) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indicador;
            die;
        }

        if ($Lista = &$db->Execute($List) === false) {
            echo 'Error en  el sql de la lista ....<br>' . $List;
            die;
        }

        $C_indicadores = $Indicador->GetArray();
        $C_Lista = $Lista->GetArray();

        $r = 0;
        for ($i = 0; $i < count($C_indicadores); $i++) {
            for ($j = 0; $j < count($C_Lista); $j++) {
                if ($C_indicadores[$i]['idsiq_indicador'] == $C_Lista[$j]['idsiq_indicador']) {
                    $r++;
                }
            }
        }

        if ($r != 0) {
            ?>
            <span style="color:<?php echo $Color ?>; font-size:10px"><strong><?php echo $r; ?></strong></span>
            <?php
        }
    }

    public function SemaforoColor($id, $Estructura) {
        global $userid, $db;

        $SQL_indiNumTotal = 'SELECT COUNT(indEstru.indicador_id) AS num_indi
                FROM siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                AND facEstru.codigoestado=100 
                AND indEstru.codigoestado=100 
                AND ind.codigoestado=100 
                AND indGen.codigoestado=100 
                AND facEstru.factor_id="' . $id . '"';

        if ($IndicadorTotal = &$db->Execute($SQL_indiNumTotal) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indiNumTotal;
            die;
        }

        $NumTotal = $IndicadorTotal->fields['num_indi'];

        $SQL_indiDesactualizado = 'SELECT COUNT(indEstru.indicador_id) AS num_indi
                FROM siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                AND facEstru.codigoestado=100 
                AND indEstru.codigoestado=100 
                AND ind.codigoestado=100 
                AND indGen.codigoestado=100 
                AND facEstru.factor_id="' . $id . '"
                AND ind.idEstado=1';

        if ($IndicadorDesactualizado = &$db->Execute($SQL_indiDesactualizado) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indiDesactualizado;
            die;
        }

        $NumDesactualizado = 0;

        $NumDesactualizado = ($IndicadorDesactualizado->fields['num_indi'] * 100) / $NumTotal;

        $SQL_indiProceso = 'SELECT COUNT(indEstru.indicador_id) AS num_indi
                FROM siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                AND facEstru.codigoestado=100 
                AND indEstru.codigoestado=100 
                AND ind.codigoestado=100 
                AND indGen.codigoestado=100 
                AND facEstru.factor_id="' . $id . '"
                AND(ind.idEstado=2 OR ind.idEstado=3)';

        if ($IndicadorProceso = &$db->Execute($SQL_indiProceso) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indiProceso;
            die;
        }

        $NumProceso = 0;
        $NumProceso = ($IndicadorProceso->fields['num_indi'] * 100) / $NumTotal;

        $SQL_indiActualizado = 'SELECT COUNT(indEstru.indicador_id) AS num_indi
                FROM siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                AND facEstru.codigoestado=100 
                AND indEstru.codigoestado=100 
                AND ind.codigoestado=100 
                AND indGen.codigoestado=100 
                AND facEstru.factor_id="' . $id . '"
                AND ind.idEstado=4';

        if ($IndicadorActualizado = &$db->Execute($SQL_indiActualizado) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indiActualizado;
            die;
        }

        $NumActualizado = 0;

        $NumActualizado = ($IndicadorActualizado->fields['num_indi'] * 100) / $NumTotal;

        $NumFinal = $NumProceso + $NumActualizado;

        if ($NumDesactualizado >= 50) {
            $Color = '#FF0000';
        }
        if ($NumFinal > 50 && $NumActualizado != 100) {
            $Color = '#FF9F04';
        }
        if ($NumActualizado == 100) {
            $Color = '#0F0';
        }

        return $Color;
    }

    public function num_Caracteristica($id, $Estructura, $Color, $carateristica_id) {
        global $userid, $db;
        include_once ('../../API_Monitoreo.php');
        $C_Api_Monitoreo = new API_Monitoreo();

        $List = $C_Api_Monitoreo->getQueryIndicadoresACargo();


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
                    indGen.idsiq_indicadorGenerico
                    FROM siq_indicadoresestructuradocumento AS indEstru 
                    INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento 
                    INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                    INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                    INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                    INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
                    WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                    AND facEstru.codigoestado=100 
                    AND indEstru.codigoestado=100 
                    AND ind.codigoestado=100 
                    AND indGen.codigoestado=100 
                    AND asp.codigoestado=100 
                    AND caract.codigoestado=100
                    AND facEstru.factor_id="' . $id . '"
                    AND caract.idsiq_caracteristica="' . $carateristica_id . '"
                    ORDER BY indEstru.Orden';

        if ($Indicador = &$db->Execute($SQL_indicador) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indicador;
            die;
        }

        if ($Lista = &$db->Execute($List) === false) {
            echo 'Error en  el sql de la lista ....<br>' . $List;
            die;
        }

        $C_indicadores = $Indicador->GetArray();
        $C_Lista = $Lista->GetArray();

        $r = 0;
        for ($i = 0; $i < count($C_indicadores); $i++) {
            for ($j = 0; $j < count($C_Lista); $j++) {
                if ($C_indicadores[$i]['idsiq_indicador'] == $C_Lista[$j]['idsiq_indicador']) {
                    $r++;
                }
            }
        }

        if ($r != 0) {
            ?>
            <span style="color:<?php echo $Color ?>; font-size:10px"><strong><?php echo $r; ?></strong></span>
            <?php
        }
    }

    public function SemaColorCaracteristica($id, $Estructura, $Carac) {
        global $userid, $db;

        $SQL_indiNumTotal = 'SELECT COUNT(indEstru.indicador_id) AS num_indi
                FROM siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                AND facEstru.codigoestado=100 
                AND indEstru.codigoestado=100 
                AND ind.codigoestado=100 
                AND indGen.codigoestado=100 
                AND facEstru.factor_id="' . $id . '"
                AND caract.idsiq_caracteristica="' . $Carac . '"';

        if ($IndicadorTotal = &$db->Execute($SQL_indiNumTotal) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indiNumTotal;
            die;
        }

        $NumTotal = $IndicadorTotal->fields['num_indi'];

        $SQL_indiDesactualizado = 'SELECT COUNT(indEstru.indicador_id) AS num_indi
                FROM siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                AND facEstru.codigoestado=100 
                AND indEstru.codigoestado=100 
                AND ind.codigoestado=100 
                AND indGen.codigoestado=100 
                AND facEstru.factor_id="' . $id . '"
                AND ind.idEstado=1
                AND caract.idsiq_caracteristica="' . $Carac . '"';

        if ($IndicadorDesactualizado = &$db->Execute($SQL_indiDesactualizado) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indiDesactualizado;
            die;
        }

        $NumDesactualizado = 0;

        $NumDesactualizado = ($IndicadorDesactualizado->fields['num_indi'] * 100) / $NumTotal;

        $SQL_indiProceso = 'SELECT COUNT(indEstru.indicador_id) AS num_indi
                FROM siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica 
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                AND facEstru.codigoestado=100 
                AND indEstru.codigoestado=100 
                AND ind.codigoestado=100 
                AND indGen.codigoestado=100 
                AND facEstru.factor_id="' . $id . '"
                AND (ind.idEstado=2 OR ind.idEstado=3)
                AND caract.idsiq_caracteristica="' . $Carac . '"';

        if ($IndicadorProceso = &$db->Execute($SQL_indiProceso) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indiProceso;
            die;
        }

        $NumProceso = 0;

        $NumProceso = ($IndicadorProceso->fields['num_indi'] * 100) / $NumTotal;

        $SQL_indiActualizado = 'SELECT COUNT(indEstru.indicador_id) AS num_indi
                FROM siq_indicadoresestructuradocumento AS indEstru 
                INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
                INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                INNER JOIN siq_caracteristica AS caract ON asp.idCaracteristica=caract.idsiq_caracteristica  
                WHERE indEstru.idsiq_factoresestructuradocumento="' . $Estructura . '"
                AND facEstru.codigoestado=100 
                AND indEstru.codigoestado=100 
                AND ind.codigoestado=100 
                AND indGen.codigoestado=100 
                AND facEstru.factor_id="' . $id . '"
                AND ind.idEstado=4
                AND caract.idsiq_caracteristica="' . $Carac . '"';

        if ($IndicadorActualizado = &$db->Execute($SQL_indiActualizado) === false) {
            echo 'Error en el SQl ....<br>' . $SQL_indiActualizado;
            die;
        }

        $NumActualizado = 0;

        $NumActualizado = ($IndicadorActualizado->fields['num_indi'] * 100) / $NumTotal;

        $NumFinal = $NumProceso + $NumActualizado;

        if ($NumDesactualizado >= 50) {
            $Color = '#FF0000';
        }
        if ($NumFinal > 50 && $NumActualizado != 100) {
            $Color = '#FF9F04';
        }
        if ($NumActualizado == 100) {
            $Color = '#0F0';
        }

        return $Color;
    }

    public function GenerarDocumento($id) {
        global $db, $userid;

        $SQL = 'SELECT 
                Estru_Fac.idsiq_factoresestructuradocumento as id,
                fac.nombre,
                fac.idsiq_factor
                FROM siq_factoresestructuradocumento AS Estru_Fac 
                INNER JOIN siq_factor AS fac ON Estru_Fac.factor_id=fac.idsiq_factor 
                WHERE Estru_Fac.idsiq_estructuradocumento="' . $id . '" 
                AND Estru_Fac.codigoestado=100 
                AND fac.codigoestado=100 
                ORDER BY Estru_Fac.Orden ASC';

        if ($Factor_Estructura = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL del los Factores de la Estructura.....<br>' . $SQL;
            die;
        }
        ?>   
        <fieldset>
            <table class="Border" align="center" width="80%" cellpadding="0" cellspacing="0">
        <?php
        $i = 0;
        while (!$Factor_Estructura->EOF) {
            ?>
                    <tr>
                        <td align="left"><strong><?php echo $i + 1 ?>.&nbsp;&nbsp;<?php echo $Factor_Estructura->fields['nombre'] ?><input type="hidden" id="Factor_id_<?php echo $i ?>" value="<?php echo $Factor_Estructura->fields['id'] ?>"</strong></td>
                    </tr>
                    <tr>      
                        <td align="center">
                        <?php
                        $this->CaracteristicaDocumento($id, $Factor_Estructura->fields['id']);
                        ?> 
                        </td>
                    </tr>
                            <?php
                            $i++;
                            $Factor_Estructura->MoveNext();
                        }
                        ?>
                <tr>
                    <td align="center">
                        <input type="hidden" id="index" value="<?php echo $i ?>" />
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td id="ImagenCarga" style="text-align: center;">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <button id="CreateDoc" name="CreateDoc" onclick="CrearDocumento(<?php echo $id ?>)" title="Generar Documento" style="text-align: center; font-size: 17px; cursor: pointer;" >Generar Documento&nbsp;&nbsp;&nbsp;<img src="../../images/Microsoft Office 2007 Word.png" width="30" title="Generar Documento" /></button>&nbsp;&nbsp;<button id="CreatePDF" name="CreatePDF" onclick="CrearDocumentoPDF(<?php echo $id ?>)" title="Generar Anexos PDF" style="text-align: center; font-size: 17px; cursor: pointer;" >Generar Anexos PDF&nbsp;&nbsp;&nbsp;<img src="../../images/file_document.png" width="30" title="Generar Anexos PDF" /></button>
                    </td>
                </tr>
            </table>
        </fieldset>     
        <?php
    }

    public function IndicadoresDocumento($id, $id_FactorEstru, $id_Caracteristica, $op = '') {
        global $db, $userid;

        $SQL_Indicador = 'SELECT 
                    indGen.nombre,
                    indEstru.idsiq_indicadoresestructuradocumento,
                    indEstru.indicador_id,
                    ind.idsiq_indicador,
                    indGen.codigo,
                    carct.idsiq_caracteristica,
                    carct.nombre AS Caract_Nom,
                    carct.codigo AS Cod,
                    facEstru.factor_id
                    FROM siq_indicadoresestructuradocumento AS indEstru 
                    INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento
                    INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                    INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico
                    INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto
                    INNER JOIN siq_caracteristica AS carct ON asp.idCaracteristica=carct.idsiq_caracteristica
                    WHERE facEstru.idsiq_estructuradocumento="' . $id . '"
                    AND indEstru.idsiq_factoresestructuradocumento="' . $id_FactorEstru . '"
                    AND carct.idsiq_caracteristica="' . $id_Caracteristica . '"
                    AND facEstru.codigoestado=100
                    AND indEstru.codigoestado=100
                    AND ind.codigoestado=100
                    AND indGen.codigoestado=100
                    AND asp.codigoestado=100
                    AND carct.codigoestado=100
                    ORDER BY indEstru.Orden ASC';

        if ($Indicador_Estructura = &$db->Execute($SQL_Indicador) === false) {
            echo 'Error en el SQL Indicador Estructura......<br>' . $SQL_Indicador;
            die;
        }

        if ($op == 1) {

            return $C_indicador = $Indicador_Estructura->GetArraY();
        } else {
            ?>
            <table cellpadding="0" cellspacing="0" border="0" class="display"  width="100%" >
            <?php
            $i = 0;
            while (!$Indicador_Estructura->EOF) {
                $id_Factor = $Indicador_Estructura->fields['factor_id'];
                $id_indicador = $Indicador_Estructura->fields['indicador_id'];
                $img = $this->VerVerificarDocumentosIndicador($id_Factor, $id_Caracteristica, $id_indicador, 1);
                ?>   
                    <tr id="Tr_<?php echo $i ?>_<?php echo $id_indicador ?>" onmouseover="Color('<?php echo $i ?>', '1', '<?php echo $id_indicador ?>');" onmouseout="Color('<?php echo $i ?>', '0', '<?php echo $id_indicador ?>');" onclick="VerDocumentosIndicadores('<?php echo $id_indicador ?>', '<?php echo $id_Factor ?>', '<?php echo $id_Caracteristica ?>')">
                        <td><?php echo $i + 1; ?></td>
                        <td></td>
                        <td style="cursor: pointer;">
                <?php echo $Indicador_Estructura->fields['nombre']; ?>
                        </td>
                        <td>
                            <?php
                            if ($img == true) {
                                ?>
                                <img src="../../images/Check.png" width="15" style="cursor: pointer;" onclick="VerDocumentosIndicadores('<?php echo $id_indicador ?>', '<?php echo $id_Factor ?>', '<?php echo $id_Caracteristica ?>')" /> 
                                <?php
                            }
                            ?>    
                        </td>
                    </tr>
                    <tr id="Tr_Detalle_<?php echo $id_indicador ?>" style="visibility: collapse;">
                        <td colspan="4" id="Td_Cargar_<?php echo $id_indicador ?>"></td>
                    </tr>
                <?php
                $i++;
                $Indicador_Estructura->MoveNext();
            }
            ?>
            </table>
                <?php
            }
        }

        public function CaracteristicaDocumento($id, $id_FactorEstru, $op = '') {
            global $db, $userid;

            $SQL = 'SELECT 
                    carct.idsiq_caracteristica,
                    carct.nombre AS Caract_Nom,
                    carct.codigo AS Cod
                    FROM siq_indicadoresestructuradocumento AS indEstru 
                    INNER JOIN siq_factoresestructuradocumento AS facEstru ON indEstru.idsiq_factoresestructuradocumento=facEstru.idsiq_factoresestructuradocumento
                    INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador 
                    INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico
                    INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto
                    INNER JOIN siq_caracteristica AS carct ON asp.idCaracteristica=carct.idsiq_caracteristica
                    WHERE facEstru.idsiq_estructuradocumento="' . $id . '"
                    AND indEstru.idsiq_factoresestructuradocumento="' . $id_FactorEstru . '"
                    AND facEstru.codigoestado=100
                    AND indEstru.codigoestado=100
                    AND ind.codigoestado=100
                    AND indGen.codigoestado=100
                    AND asp.codigoestado=100
                    AND carct.codigoestado=100
                    GROUP BY carct.idsiq_caracteristica
                    ORDER BY indEstru.Orden ASC';

            if ($Caracteristica_Estructura = &$db->Execute($SQL) === false) {
                echo 'Error en el SQL Caracteristica Estructura......<br>' . $SQL;
                die;
            }

            if ($op == 1) {
                return $C_Caract = $Caracteristica_Estructura->GetArray();
            } else {
                while (!$Caracteristica_Estructura->EOF) {
                    $id_Caracteristica = $Caracteristica_Estructura->fields['idsiq_caracteristica'];
                    ?>
                <fieldset>
                    <legend><?php echo $Caracteristica_Estructura->fields['Caract_Nom'] ?></legend>
                <?php $this->IndicadoresDocumento($id, $id_FactorEstru, $id_Caracteristica); ?>
                </fieldset>
                    <?php
                    $Caracteristica_Estructura->MoveNext();
                }
            }
        }

        public function VerVerificarDocumentosIndicador($id_Factor, $id_Carat, $id_ind, $op = '') {
            global $db, $userid;

            if ($op == 1) {
                $Condicion = ' AND a.tipo_documento=1 ';
            } else if ($op == 2) {
                $Condicion = '';
            } else {
                $Condicion = '';
            }

            $SQL = 'SELECT 
                    d.idsiq_documento,
                    a.idsiq_archivodocumento,
                    a.descripcion,
                    a.nombre_archivo,
                    a.extencion,
                    a.tipo_documento,
                    a.version_final,
                    a.Ubicaicion_url
                    FROM siq_documento d 
                    INNER JOIN siq_archivo_documento a ON d.idsiq_documento=a.siq_documento_id 
                    WHERE d.siqfactor_id="' . $id_Factor . '"
                    AND d.siqcaracteristica_id="' . $id_Carat . '"
                    AND d.siqindicador_id="' . $id_ind . '"
                    AND d.codigoestado=100
                    AND a.codigoestado=100 ' . $Condicion . ' 
                    ORDER BY tipo_documento ASC';

            if ($Data = &$db->Execute($SQL) === false) {
                echo 'Error en el SQL Verificar...<br><br>' . $SQL;
                die;
            }

            if ($op == 1) {
                if (!$Data->EOF) {
                    return true;
                } else {
                    return false;
                }
            } else if ($op == 2) {

                return $C_Data = $Data->GetArray();
            } else {
                return $Data;
            }
        }

        public function DetalleDocumentoIndicador($id_Factor, $id_Caract, $id_ind) {
            global $db, $userid;
            ?>
        <div style="width: 100%; text-align: right;">
            <img style="top: auto; cursor: pointer; text-align: right;" src="../../images/delete.png" width="15" onclick="CerrarAdjunto('<?php echo $id_ind ?>');" />
        </div>  
        <fieldset>
            <legend>Archivos Adjuntos</legend>
            <table cellpadding="0" cellspacing="0" border="0" class="display"  width="100%" style="text-align: left;" >
                <thead>
                    <tr>
                        <th><strong>N&deg;</strong></th>
                        <th><strong>Descripci&oacute;n</strong></th>
                        <th><strong>Nombre del Archivo</strong></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
        <?php
        $C_Data = $this->VerVerificarDocumentosIndicador($id_Factor, $id_Caract, $id_ind);
        $i = 0;
        while (!$C_Data->EOF) {
            $N = $i + 1;

            $X = esPar($N);

            if ($X == 1) {
                $Color = '#F0F9FE';
            } else {
                $Color = '#FCFFFD';
            }
            ?>
                        <tr bgcolor="<?php echo $Color ?>">
                            <td><?php echo $N ?></td>
                            <td><?php echo $C_Data->fields['descripcion'] ?></td>
                            <td><?php echo $C_Data->fields['nombre_archivo'] ?></td>
                            <td>
            <?php
            if ($C_Data->fields['version_final'] == 1 && $C_Data->fields['tipo_documento'] != 1) {
                ?>
                                    <input type="checkbox" id="Incluir_<?php echo $C_Data->fields['idsiq_archivodocumento'] ?>" checked="checked" />
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                                <?php
                                $i++;
                                $C_Data->MoveNext();
                            }
                            ?>
                </tbody>
            </table>
        </fieldset>    
        <?php
    }

    public function ConstruirDocumento($id, $PDF = '') {
        global $db, $userid;

        $SQL = 'SELECT 
                    Estru_Fac.idsiq_factoresestructuradocumento as id,
                    fac.nombre,
                    fac.idsiq_factor
                    FROM siq_factoresestructuradocumento AS Estru_Fac 
                    INNER JOIN siq_factor AS fac ON Estru_Fac.factor_id=fac.idsiq_factor 
                    WHERE Estru_Fac.idsiq_estructuradocumento="' . $id . '" 
                    AND Estru_Fac.codigoestado=100 
                    AND fac.codigoestado=100 
                    ORDER BY Estru_Fac.Orden ASC';

        if ($Factor_Estructura = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL del los Factores de la Estructura.....<br>' . $SQL;
            die;
        }

        $C_Archivos = array();
        $C_Url = array();

        while (!$Factor_Estructura->EOF) {
            $id_FactorEstru = $Factor_Estructura->fields['id'];
            $C_Caract = $this->CaracteristicaDocumento($id, $id_FactorEstru, 1);

            for ($i = 0; $i < count($C_Caract); $i++) {
                $id_Caract = $C_Caract[$i]['idsiq_caracteristica'];
                $C_indi = $this->IndicadoresDocumento($id, $id_FactorEstru, $id_Caract, 1);
                for ($j = 0; $j < count($C_indi); $j++) {
                    $id_indi = $C_indi[$j]['indicador_id'];
                    $id_Factor = $C_indi[$j]['factor_id'];

                    $C_Data = $this->VerVerificarDocumentosIndicador($id_Factor, $id_Caract, $id_indi, 2);

                    for ($n = 0; $n < count($C_Data); $n++) {
                        if (!$PDF) {
                            if (($C_Data[$n]['tipo_documento'] == 1 || $C_Data[$n]['tipo_documento'] == 2) && $C_Data[$n]['extencion'] == 'docx') {
                                $C_Archivos[$id_Factor]['id_archivo'][] = $C_Data[$n]['idsiq_archivodocumento'];
                                $C_Archivos[$id_Factor]['Url'][] = $C_Data[$n]['Ubicaicion_url'];
                                $C_Url['Url'][] = $C_Data[$n]['Ubicaicion_url'];
                            }
                        } else {
                            if ($C_Data[$n]['tipo_documento'] == 3 && $C_Data[$n]['extencion'] == 'pdf') {
                                $C_Archivos[$id_Factor]['id_archivo'][] = $C_Data[$n]['idsiq_archivodocumento'];
                                $C_Archivos[$id_Factor]['Url'][] = $C_Data[$n]['Ubicaicion_url'];
                                $C_Url['Url'][] = '../../SQI_Documento/' . $C_Data[$n]['Ubicaicion_url'];
                            }
                        }
                    }
                }
            }
            $Factor_Estructura->MoveNext();
        }

        if (!$PDF) {
            $this->UnirDocumentos($C_Url['Url']);
        } else {
            $this->UnirPDF($C_Url['Url']);
        }
    }

    public function UnirDocumentos($Url) {
        global $db, $userid;
        require_once './classes/DocxUtilities.inc';
        $docx = new DocxUtilities();
        $newDocx = new DocxUtilities();
        $options = array('mergeType' => 0);


        for ($i = 1; $i < count($Url); $i++) {
            if ($i == 1) {

                $newDocx->mergeDocx('../../SQI_Documento/' . $Url[0], '../../SQI_Documento/' . $Url[$i], '../../SQI_Documento/DocumentosCreados/mergedDocx.docx', $options);
            } else {

                $newDocx->mergeDocx('../../SQI_Documento/DocumentosCreados/mergedDocx.docx', '../../SQI_Documento/' . $Url[$i], '../../SQI_Documento/DocumentosCreados/mergedDocx.docx', $options);
            }
        }
    }

    public function UnirPDF($url) {
        global $db, $userid;
        include_once ('pdf/index.php');

        $pdf = new concat_pdf();
        $pdf->setFiles($url);
        $pdf->concat();
        $pdf->Output("Anexos.pdf", "F");
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
