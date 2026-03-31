<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se hace el formateo de codigo y en los paranetros de los querys se le coloca el $db->qstr(). 
 * @since Abril 25, 2019
 */
$res = $db->Execute("select * from votacion where idvotacion=" . $db->qstr($_REQUEST["idvot"]));
$row = $res->FetchRow();
$tipo = $row["idtipocandidatodetalleplantillavotacion"];
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
    <legend class="ui-widget ui-widget-header ui-corner-all">PLANTILLAS (<?php echo $row["nombrevotacion"] ?>)</legend>
    <?php
    if ($_REQUEST["acc"] == "list") {
        ?>			
        <div id="pendiente"></div>
        <div class="CSSTableGenerator" >
            <table>
                <caption><img src="images/nuevo.png" style="cursor:pointer" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href = 'index.php?opc=<?php echo $_REQUEST["opc"] ?>&acc=new&idvot=<?php echo $row["idvotacion"] ?>&idtip=<?php echo $tipo; ?>'">
                    <a id="1" style="cursor:pointer"  onclick="location.href = 'index.php?opc=<?php echo $_REQUEST["opc"] ?>&acc=new&idvot=<?php echo $row["idvotacion"] ?>&idtip=<?php echo $tipo; ?>'"><b>Nueva Plantilla</b></a></caption>
                <tr>
                    <td>Facultad</td>
                    <td>Carreras</td>
                    <td>Tipo de plantilla</td>
                    <td>Tipo de candidato</td>
                    <td>Plantilla</td>
                    <td>Estado</td>
                    <td>Acci&oacute;n</td>
                </tr>
                <?php
                $query = "select codigofacultad
                                ,nombrefacultad
                                ,group_concat(idplantillavotacion separator ',') as idsplantillas
                                ,group_concat(nombrecarrera order by nombrecarrera separator '<br>') as carreras
                                ,nombretipoplantillavotacion
                                ,nombreplantillavotacion
                                ,idnombreplantillavotacion
                                ,nombreestado, idtipoplantillavotacion, idplantillavotacion, nombredestinoplantillavotacion
                                from plantillavotacion pv
                                join tipoplantillavotacion tpv using(idtipoplantillavotacion)
                                join destinoplantillavotacion dpv using(iddestinoplantillavotacion)
                                join carrera using(codigocarrera)
                                join facultad using(codigofacultad)
                                left join nombreplantillavotacion using(nombreplantillavotacion)
                                join estado e on pv.codigoestado=e.codigoestado
                                where idvotacion=" . $db->qstr($_REQUEST["idvot"]) . " AND pv.codigoestado in (100,200)
                                group by codigofacultad
                                        ,nombretipoplantillavotacion
                                        ,nombreplantillavotacion
                                order by nombretipoplantillavotacion
                                        ,nombrefacultad
                                        ,nombreplantillavotacion";

                $res = $db->Execute($query);
                while ($row = $res->FetchRow()) {
                    ?>
                    <tr>
                        <td><?php echo $row["nombrefacultad"] ?></td>
                        <td><?php echo $row["carreras"] ?></td>
                        <td><?php echo $row["nombretipoplantillavotacion"] ?></td>
                        <td><?php echo $row["nombredestinoplantillavotacion"] ?></td>
                        <td><?php echo $row["nombreplantillavotacion"] ?></td>
                        <td><?php echo $row["nombreestado"] ?></td>
                        <td align="center">
                            <?php
                            if (!strpos($row["nombreplantillavotacion"], "Blanco")) {
                                ?>
                                <img src="images/edit_file.png" style="cursor:pointer;margin-bottom:5px" title="Modificar plantilla" onclick="location.href = 'index.php?opc=<?php echo $_REQUEST["opc"] ?>&acc=edit&idplvot=<?php echo $row["idplantillavotacion"] ?>&idvot=<?php echo $_REQUEST["idvot"] ?>&idtip=<?php echo $tipo; ?>'">
                                <?php
                            }
                            ?>
                            <img src="images/Search_User.png" style="cursor:pointer" title="Ver candidatos" onclick="location.href = 'index.php?opc=c&acc=list&idvot=<?php echo $_REQUEST["idvot"] ?>&idtip=<?php echo $tipo; ?>&idspl=<?php echo $row["idsplantillas"] ?>&idnompl=<?php echo $row["idnombreplantillavotacion"] ?>'">
                        </td>
                    </tr>
                    <?php
                    $facultades[] = $row["codigofacultad"];
                }
                ?>				
            </table>
            <p>
            <div id="submit">
                <button type="button" style="cursor:pointer" Onclick="location.href = '?opc=v&acc=list'">Volver</button>
            </div>
            </p>
        </div>
        <?php
    }
    if ($_REQUEST["acc"] == "new" || $_REQUEST["acc"] == "edit") {

        $condicion = "1,2,3,5";
        switch ($_REQUEST['idtip']) {
            case '1':
                $iddestinoplantillavotacion = "3";
                break;
            case '2':
                $iddestinoplantillavotacion = "2";
                break;
            case '3':
                $iddestinoplantillavotacion = "1";
                break;
            case '4':
                /**
                 * Se modifica el valor de la variable $iddestinoplantillavotacion de 1 por 4 
                 * para los administrativos
                 * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                 * @copyright Dirección de Tecnología Universidad el Bosque
                 * @since 18 de septiembre de 2018.
                 */
                $iddestinoplantillavotacion = "4";
                $condicion = "1,2,3,4,5";
                break;
        }


        $dest = $iddestinoplantillavotacion;
        if (isset($_REQUEST["idplvot"]) && $_REQUEST["acc"] == "edit") {
            $res = $db->Execute("select * from plantillavotacion where idplantillavotacion=" . $db->qstr($_REQUEST["idplvot"]));
            $rowP = $res->FetchRow();
            $dest = $rowP["iddestinoplantillavotacion"];
            $iddestinoplantillavotacion = $iddestinoplantillavotacion . "," . $rowP["iddestinoplantillavotacion"];
        }

        $funcionHideViewDivs = "function hideViewDivs(id) {
							if(id==3)
								\$('#div_facultad').css('display','block');
							else
								\$('#div_facultad').css('display','none');
						}";
        ?>
        <p> <?php echo $obj->select("Tipo de plantilla", "idtipoplantillavotacion", $rowP["idtipoplantillavotacion"], 1, "select idtipoplantillavotacion,nombretipoplantillavotacion from tipoplantillavotacion where idtipoplantillavotacion in (" . $condicion . ")", "", "hideViewDivs(this.value)", $funcionHideViewDivs) ?> </p>
        <p> <?php echo $obj->select("Plantilla", "nombreplantillavotacion", $rowP["nombreplantillavotacion"], 1, "select nombreplantillavotacion,nombreplantillavotacion from nombreplantillavotacion order by nombreplantillavotacion") ?> </p>
        <p> <?php echo $obj->select("Programa académico", "codigocarrera", $rowP["codigocarrera"], 1, "select codigocarrera,nombrecarrera from carrera where (fechavencimientocarrera>NOW() AND codigomodalidadacademica in (200)) OR codigocarrera=1 order by nombrecarrera") ?> </p>
        <p> <?php echo $obj->select("Modalidad Plantilla", "iddestinoplantillavotacion", $dest, 1, "select iddestinoplantillavotacion,nombredestinoplantillavotacion from destinoplantillavotacion where codigoestado=100 AND iddestinoplantillavotacion in (" . $iddestinoplantillavotacion . ")") ?> </p>
        <p> <?php echo $obj->select("Estado", "codigoestado", $rowP["codigoestado"], 1, "select codigoestado,nombreestado from estado") ?></p>
        <p> <?php
            //consulta para saber la cantidad de registros si fue por facultad (>1) o por programa(==1)
            $progfac = "select count(codigocarrera) as ncarreras from plantillavotacion where idvotacion=" . $db->qstr($rowP["idvotacion"]) . " AND nombreplantillavotacion=" . $db->qstr($rowP["nombreplantillavotacion"]) . " ";
            $rowPf = $db->GetRow($progfac);
            if ($rowPf['ncarreras'] == 1) {
                $checkPrograma = 'checked';
            } else {
                $checkFacultad = 'checked';
            }
            echo $obj->radioButton("Programas", "Programa", 1, 0, $checkPrograma);
            ?> </p>
        <p> <?php
            echo $obj->radioButton("Facultades", "Programa", 2, 0, $checkFacultad);
            ?> </p>
        <p>
            <?php echo $obj->hiddenBox("opc", $_REQUEST["opc"]) ?>
            <?php echo $obj->hiddenBox("acc", $_REQUEST["acc"]) ?>
            <?php echo $obj->hiddenBox("idvot", $_REQUEST["idvot"]) ?>
            <?php echo $obj->hiddenBox("idplvot", $_REQUEST["idplvot"]) ?>
            <?php echo $obj->hiddenBox("idtip", $_REQUEST["idtip"]) ?>

        <div id="submit">
            <button type="submit" style="cursor:pointer;">Guardar</button>
            <button type="button" style="cursor:pointer;margin-left:20px;" Onclick="history.back()">Volver</button>
        </div>
    </p>
    <?php
}
?>
</fieldset>
<div id="resultado"></div>
<script>
    $(document).ready(function ()
    {
        var facultades = <?php echo json_encode($facultades); ?>;
        $.ajax({
            dataType: 'html',
            type: 'POST',
            url: 'configuracion/validarFacultad.php',
            data: {
                facultades: facultades,
                action: 'consultaFacultades'
            },
            success: function (data) {
                $("#pendiente").html(data);
            },
            error: function (data, error, errorThrown) {
                alert(error + errorThrown);
            }
        });
    });

</script>
