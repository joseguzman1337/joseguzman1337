<?php
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
function filtroDependencia() {
    global $db;
    $query_dependencia = "SELECT codigomodalidadacademica, nombremodalidadacademica
    FROM modalidadacademica m ";
    //echo "$query_hijos<br>";
    $dependencia = $db->Execute($query_dependencia);
    $totalRows_dependencia = $dependencia->RecordCount();
    //if($totalRows_dependencia != 0) {
    $row_dependencia = $dependencia->FetchRow();
    ?>
<form method="post" action="" name="fsel">
    <table border="0" align="center">
        <tr>
            <td>Dependencia:</td>
            <td><select name="codigodependencia" onchange="document.fsel.submit()">
                    <option value="" selected>Seleccionar</option>
                        <?php
                        do {
                            $selected = "";
                            if($row_dependencia['codigomodalidadacademica'] == $_REQUEST['codigodependencia'])
                                $selected = "selected";
                            ?>
                    <option value="<?php echo $row_dependencia['codigomodalidadacademica']; ?>" <?php echo $selected; ?>>
                                <?php echo substr($row_dependencia['nombremodalidadacademica'], 0, 30); ?>
                    </option>
                        <?php
                        }
                        while($row_dependencia = $dependencia->FetchRow());
                        ?>
                </select>
            </td>
        </tr>
            <?php
            if(isset($_REQUEST['codigodependencia'])) {
                $filtro = "";
                if(!preg_match('/^5.+$/',$_REQUEST['codigodependencia'])) {
                    $filtro = "and date(now()) between c.fechainiciocarrera and c.fechavencimientocarrera";
                }
                $query_carrera = "SELECT c.codigocarrera, c.nombrecarrera
    FROM carrera c
    where c.codigomodalidadacademica = '".$_REQUEST['codigodependencia']."'
                    $filtro
    order by 2";
                //echo "$query_hijos<br>";
                $carrera = $db->Execute($query_carrera);
                $totalRows_carrera = $carrera->RecordCount();
                if($totalRows_carrera != 0) {
                    $row_carrera = $carrera->FetchRow();
                    ?>
        <tr>
            <td colspan="2"><select name="nacodigocarrera" onchange="document.fsel.submit()">
                    <option value="" selected>Seleccionar</option>
                                <?php
                                $entro=false;
                                do {
                                    $selected = "";
                                    if($row_carrera['codigocarrera'] == $_REQUEST['nacodigocarrera']){
                                        $selected = "selected";
                                        $entro = true;
                                    }
                                    ?>
                    <option value="<?php echo $row_carrera['codigocarrera']; ?>" <?php echo $selected; ?>>
                                        <?php echo substr($row_carrera['nombrecarrera'], 0, 30); ?>
                    </option>
                                <?php
                                }
                                while($row_carrera = $carrera->FetchRow());
                                ?>
                </select>
            </td>
        </tr>
                <?php
                }
                else {

                    ?>
        <tr><td colspan="2">No hay información</td></tr>
                <?php
                }
                if (!$entro)
                 $_REQUEST['nacodigocarrera']="";
            }
            ?>
    </table>
</form>
<?php
}

?>
