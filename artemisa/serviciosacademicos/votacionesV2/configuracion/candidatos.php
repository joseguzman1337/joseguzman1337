<?php
/**
 * Se hace reorganizacion de codigo general
 * @modified Andres Ariza <andresariza@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 18 de septiembre de 2018.
 */
/* error_reporting(E_ALL);
  ini_set('display_errors', '1'); */
if ($_REQUEST["acc"] == "list") {
    require_once("../utilidades/datosEstudiante.php");
    $resP = $db->Execute("select	nombredestinoplantillavotacion
								,nombretipoplantillavotacion
								,nombreplantillavotacion
								,idnombreplantillavotacion, iddestinoplantillavotacion, nombrevotacion
							from plantillavotacion pv
							join tipoplantillavotacion tpv using(idtipoplantillavotacion)
							join destinoplantillavotacion dpv using(iddestinoplantillavotacion)
							join votacion v using(idvotacion)
							left join nombreplantillavotacion using(nombreplantillavotacion)
							join estado e on pv.codigoestado=e.codigoestado
							WHERE idplantillavotacion in (" . $_REQUEST["idspl"] . ") AND pv.codigoestado in (100,200) ");
    $rowPlantilla = $resP->FetchRow();


    $res = $db->Execute("select	 numerodocumentocandidatovotacion
							,apellidoscandidatovotacion
							,nombrescandidatovotacion
							,telefonocandidatovotacion
							,celularcandidatovotacion
							,direccioncandidatovotacion
							,nombrecargo, idplantillavotacion, idcargo,idcandidatovotacion, idtipocandidatodetalleplantillavotacion
						from candidatovotacion cv 
						join (	select	 distinct
								 idcandidatovotacion
								,idcargo, idplantillavotacion
							from detalleplantillavotacion
							where idplantillavotacion in (" . $_REQUEST["idspl"] . ")
						) sub using(idcandidatovotacion)
						join cargo c using(idcargo) WHERE cv.codigoestado=100 AND idcargo<>1
						GROUP BY idcargo");
    $numero_filas = mysql_num_rows($res);
    ?>
    <fieldset class="ui-widget ui-widget-content ui-corner-all">
        <legend class="ui-widget ui-widget-header ui-corner-all">CANDIDATOS (<?php echo $rowPlantilla["nombreplantillavotacion"] . " - " . $rowPlantilla["nombretipoplantillavotacion"] . " - " . $rowPlantilla["nombredestinoplantillavotacion"]; ?>)</legend>
        <div class="CSSTableGenerator" >
            <table>
                <?php if ($numero_filas == 0) { ?>
                    <caption><img src="images/nuevo.png" style="cursor:pointer;" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href = '?opc=<?php echo $_REQUEST["opc"] ?>&acc=new&idvot=<?php echo $_REQUEST["idvot"] ?>&idtip=<?php echo $rowPlantilla["iddestinoplantillavotacion"] ?>&idspl=<?php echo $_REQUEST["idspl"] ?>&idnompl=<?php echo $_REQUEST["idnompl"] ?>'">
                        <a id="1" style="cursor:pointer"  onclick="location.href = '?opc=<?php echo $_REQUEST["opc"] ?>&acc=new&idvot=<?php echo $_REQUEST["idvot"] ?>&idtip=<?php echo $rowPlantilla["iddestinoplantillavotacion"] ?>&idspl=<?php echo $_REQUEST["idspl"] ?>&idnompl=<?php echo $_REQUEST["idnompl"] ?>'"><b>Nuevo Candidato</b></a></caption>
                <?php } ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>Documento</td>
                    <td>Apellidos</td>
                    <td>Nombres</td>
                    <td>Tel&eacute;fono</td>
                    <td>Celular</td>
                    <td>Direcci&oacute;n</td>
                    <td>Cargo</td>
                    <td>Acci&oacute;n</td>
                </tr>
                <?php
                while ($row = $res->FetchRow()) {
                    $foto = "";
                    $foto = obtenerFotoDocumentoEstudiante($db, $row["numerodocumentocandidatovotacion"], "../../imagenes/estudiantes/");
                    if (strpos($foto, 'no_foto') !== false) {
                        if (file_exists("../../imagenes/estudiantes/" . $row["numerodocumentocandidatovotacion"] . ".jpg")) {
                            $foto = "../../imagenes/estudiantes/" . $row["numerodocumentocandidatovotacion"] . ".jpg";
                        }
                    }
                    ?>
                    <tr>
                        <td width="10%" align="center"><img src="<?php echo $foto; ?>" width="90" height="125"></td>
                        <td align="right"><?php echo $row["numerodocumentocandidatovotacion"] ?></td>
                        <td><?php echo $row["apellidoscandidatovotacion"] ?></td>
                        <td><?php echo $row["nombrescandidatovotacion"] ?></td>
                        <td><?php echo $row["telefonocandidatovotacion"] ?></td>
                        <td><?php echo $row["celularcandidatovotacion"] ?></td>
                        <td><?php echo $row["direccioncandidatovotacion"] ?></td>
                        <td align="center"><?php echo $row["nombrecargo"] ?></td>
                        <td align="center">
                            <img src="images/edit_user.png" style="cursor:pointer;" title="Modificar candidato" onclick="location.href = '?opc=<?php echo $_REQUEST["opc"] ?>&acc=edit&id=<?php echo $row["idcandidatovotacion"] ?>&car=<?php echo $row["idcargo"] ?>&idvot=<?php echo $_REQUEST["idvot"] ?>&idtip=<?php echo $rowPlantilla["iddestinoplantillavotacion"] ?>&idspl=<?php echo $_REQUEST["idspl"] ?>&idnompl=<?php echo $_REQUEST["idnompl"] ?>'">
                            <img src="images/Remove_User.png" style="cursor:pointer;margin-left:10px;" title="Eliminar candidato" onclick="location.href = '?opc=<?php echo $_REQUEST["opc"] ?>&acc=delete&id=<?php echo $row["idcandidatovotacion"] ?>&car=<?php echo $row["idcargo"] ?>&idvot=<?php echo $_REQUEST["idvot"] ?>&idtip=<?php echo $_REQUEST["idtip"] ?>&idspl=<?php echo $_REQUEST["idspl"] ?>&idnompl=<?php echo $_REQUEST["idnompl"] ?>'">
                        </td>
                    </tr>
        <?php
    }
    ?>
            </table>
            <p>
            <div id="submit">
                <button type="button" style="cursor:pointer;" Onclick="location.href = '?opc=p&acc=list&idvot=<?php echo $_REQUEST["idvot"] ?>&idtip=<?php echo $_REQUEST["idtip"] ?>'">Volver</button>
            </div>
            </p>
        </div>
    </fieldset>
    <?php
}
if ($_REQUEST["acc"] == "new" || $_REQUEST["acc"] == "edit") {
    $rowP = array();
    $rowC = array();

    $resP = $db->Execute("select	nombredestinoplantillavotacion
								,nombretipoplantillavotacion
								,nombreplantillavotacion
								,idnombreplantillavotacion, iddestinoplantillavotacion, nombrevotacion
							from plantillavotacion pv
							join tipoplantillavotacion tpv using(idtipoplantillavotacion)
							join destinoplantillavotacion dpv using(iddestinoplantillavotacion)
							join votacion v using(idvotacion)
							left join nombreplantillavotacion using(nombreplantillavotacion)
							join estado e on pv.codigoestado=e.codigoestado
							WHERE idplantillavotacion in (" . $_REQUEST["idspl"] . ") AND pv.codigoestado in (100,200) ");
    $rowPlantilla = $resP->FetchRow();

    if (isset($_REQUEST["id"]) && $_REQUEST["acc"] == "edit") {
        $res = $db->Execute("select	 numerodocumentocandidatovotacion
							,apellidoscandidatovotacion
							,nombrescandidatovotacion
							,telefonocandidatovotacion
							,celularcandidatovotacion
							,direccioncandidatovotacion
							,idplantillavotacion, idcargo,idcandidatovotacion
						from candidatovotacion cv 
						join (	select	 distinct
								 idcandidatovotacion
								,idcargo, idplantillavotacion
							from detalleplantillavotacion
							where idplantillavotacion in (" . $_REQUEST["idspl"] . ")
						) sub using(idcandidatovotacion) WHERE cv.codigoestado=100
						GROUP BY idcargo");
        while ($row = $res->FetchRow()) {
            if ($row["idcargo"] == 2) {
                $rowP = $row;
            } else if ($row["idcargo"] == 3) {
                $rowC = $row;
            }
        }

        //var_dump($rowP);
    }

    $principal = $rowP["numerodocumentocandidatovotacion"];
    $suplente = $rowC["numerodocumentocandidatovotacion"];
    $idP = $rowP["idcandidatovotacion"];
    $idC = $rowC["idcandidatovotacion"];
    ?>
    <script>
        function datosCandidato(tc, idtip) {
            //console.log("#numerodocumento"+tc);
            //console.log($("#numerodocumento"+tc).val());
            $('#divDatosCandidato' + tc).html('<img src="images/cargando.gif">&nbsp;&nbsp;<span class="search">Buscando...</span>');
            $.ajax({
                url: 'datosCandidato.php'
                , data: 'id=' + $("#numerodocumento" + tc).val() + '&tc=' + tc + '&idtip=' + idtip
                , success: function (resp) {
                    $('#divDatosCandidato' + tc).html(resp)
                }
            });
        }
    </script>
    <legend class="ui-widget ui-widget-header ui-corner-all">CANDIDATOS <?php echo $rowPlantilla["nombrevotacion"] ?> (<?php echo $rowPlantilla["nombreplantillavotacion"] . " - " . $rowPlantilla["nombretipoplantillavotacion"] . " - " . $rowPlantilla["nombredestinoplantillavotacion"]; ?>)</legend>
    <br/>
    <fieldset class="ui-widget ui-widget-content ui-corner-all">
        <legend class="ui-widget ui-widget-header ui-corner-all">CANDIDATO PRINCIPAL</legend>
        <p> <?php echo $obj->numberBox("Documento", "numerodocumentoP", $principal, 1, "15", "right") ?> <button type="button" style="cursor:pointer;" Onclick="datosCandidato('P',<?php echo $_REQUEST["idtip"] ?>)">Buscar</button> </p>
        <div id="divDatosCandidatoP"></div>
    </fieldset>
    <br>
    <fieldset class="ui-widget ui-widget-content ui-corner-all">
        <legend class="ui-widget ui-widget-header ui-corner-all">CANDIDATO SUPLENTE</legend>
        <p> <?php echo $obj->numberBox("Documento", "numerodocumentoS", $suplente, 0, "15", "right") ?> <button type="button" style="cursor:pointer;" Onclick="datosCandidato('S',<?php echo $_REQUEST["idtip"] ?>)">Buscar</button> </p>
        <div id="divDatosCandidatoS"></div>
    </fieldset>
    <p>
    <?php echo $obj->hiddenBox("opc", $_REQUEST["opc"]) ?>
        <?php echo $obj->hiddenBox("acc", $_REQUEST["acc"]) ?>
        <?php echo $obj->hiddenBox("idvot", $_REQUEST["idvot"]) ?>
        <?php echo $obj->hiddenBox("idtip", $_REQUEST["idtip"]) ?>
        <?php echo $obj->hiddenBox("idspl", $_REQUEST["idspl"]) ?>
        <?php echo $obj->hiddenBox("idnompl", $_REQUEST["idnompl"]) ?>
        <?php echo $obj->hiddenBox("idcanP", $idP) ?>
        <?php echo $obj->hiddenBox("idcanS", $idC) ?>
    <div id="submit">
        <button type="submit" style="cursor:pointer;">Guardar</button>
        <button type="button" style="cursor:pointer;margin-left:20px;" Onclick="history.back()">Volver</button>
    </div>
    </p>
    <script type="text/javascript">
        $(':submit').click(function (event) {
            /*event.preventDefault();
             
             if($('#numerodocumentoP').val()!=$('#numerodocumentoS').val()){        
             document.forma.submit();
             } else {
             alert("El principal y suplente no pueden ser la misma persona.");
             }*/

        });
    </script>
    <?php
} else if ($_REQUEST["acc"] == "delete") {
    $resP = $db->Execute("UPDATE `candidatovotacion` SET `codigoestado`='200' WHERE (`idcandidatovotacion`='" . $_REQUEST["id"] . "')");
    $resP = $db->Execute("UPDATE `detalleplantillavotacion` SET `codigoestado`='200' WHERE (`idcandidatovotacion`='" . $_REQUEST["id"] . "') AND idplantillavotacion in (" . $_REQUEST["idspl"] . ")");

    echo "<script>alert('¡¡ Se ha eliminado el candidato de forma correcta. !!');location.href='?opc=c&acc=list&idvot=" . $_REQUEST["idvot"] . "&idtip=" . $_REQUEST["idtip"] . "&idspl=" . $_REQUEST["idspl"] . "&idnompl=" . $_REQUEST["idnompl"] . "';</script>";
}
?>
<div id="resultado"></div>
