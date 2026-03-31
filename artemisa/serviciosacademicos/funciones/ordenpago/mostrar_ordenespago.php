<?php
/**
* @modifed Ivan dario quintero rios <quinteroivan@unbosque.edu.co>
* @since Mayo 8 del 2019
* funcion depreciada en linea 71
*/
$ordenesvencidas = false;
//$cuentaconceptos = $this->existe_conceptosinscripcion($pagos, $porpagar, $enproceso, $sinpagar, $cuentaconceptos);
if ($this->existe_ordenespagas() || $this->existe_ordenesenproceso() || $this->existe_ordenesporpagar()) {
    ?>
<style>
    @import url('https://fonts.googleapis.com/css?family=Darker+Grotesque&display=swap');
    #trtituloNaranjaInst{
        background-color:#008876;
        font-size:15px;
        color:#FFFFFF;
        font-family: 'Darker Grotesque', sans-serif;
        /*font-family: "Acherus Grotesque";*/
        font-weight: bold;
    }
</style>

<br>
    <table class="table table-bordered" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
        <tr>
            <th id="trtituloNaranjaInst">
                PERIODO <?php echo $this->codigoperiodo ?>
            </th>
        </tr>
    </table>
                <?php
            }
            if ($this->existe_ordenespagas()) {
                ?>
                <table class="table table-bordered" width="100%" border="1" cellpadding="1" cellspacing="0" style="font-size: 12px">
                    <tr id="">
                        <th colspan="3">
                            ORDENES <?php echo $titulo ?> PAGADAS
                            <small>
                                Haga click en el n&uacute;mero orden de pago para mayor informaci&oacute;n
                            </small>
                        </th>
                    </tr>
                    <tr id="trtituloNaranjaInst">
                        <th>No. Orden</th>
                        <th>Fecha</th>
                        <th>Comprobante</th>
                    </tr>
                    <?php
                    foreach ($this->ordenesdepago as $key => $value) {
                        $value->mostrar_ordenpagopaga($ruta, $rutaimpresion);
                    }
                    ?>
                </table>
                <br>
                    <?php
                }

                if ($this->existe_ordenesenproceso()) {
                    ?>
                    <table class="table table-bordered" width="100%" border="1" cellpadding="1" cellspacing="0" style="font-size: 12px">
                        <tr id="">
                            <th colspan="4">
                                <strong>ORDENES <?php echo $titulo ?> EN PROCESO DE PAGO</strong>
                                <small>
                                    Haga click en el n&uacute;mero orden de pago para mayor informaci&oacute;n <br>
                                        La transacción está siendo confirmada en la Entidad Financiera. Por favor verifique en 10 minutos
                                </small>
                            </th>
                        </tr>
                        <tr id="trtituloNaranjaInst">
                            <th>No. Orden</th>
                            <th>Valor</th>
                            <th>Fecha</th>
                            <th>Comprobante</th>
                        </tr>
                        <?php
                        foreach ($this->ordenesdepago as $key => $value) {
                            $value->mostrar_ordenpagoproceso($ruta, $rutaimpresion);
                        }
                        ?>
                    </table>
                    <br>
                    <?php
                }
                if ($this->existe_ordenesporpagar()) {
                    $ordenesvencidas = false;
                    $ordenesvigentes = false;
                    foreach ($this->ordenesdepago as $key => $value) {
                        if (preg_match("/^1.+$/", $value->tomar_codigoestadoordenpago())) {                            
                            if (!$value->ordenvigente()) {
                                // Hay ordenes vencidas
                                $ordenesvencidas = true;
                            } else {
                                $ordenesvigentes = true;
                            }
                        }
                    }//foreach
                    if ($ordenesvigentes) {
                        ?>
                    <table class="table table-bordered" width="100%" border="1" cellpadding="1" cellspacing="0" style="font-size: 12px">
                        <tr id="">
                            <th colspan="3">
                                <strong>ORDENES <?php echo $titulo ?> POR PAGAR</strong>
                                <small>
                                    Haga click en el n&uacute;mero orden de pago para mayor informaci&oacute;n
                                </small>
                            </th>
                        </tr>
                        <tr id="trtituloNaranjaInst">
                            <th>No. Orden</th> 	
                            <th>Valor</th>
                            <th>Fecha</th>
                    <?php
                    if ($_SESSION['MM_Username'] == "estudiante" || $_SESSION['MM_Username'] == "estudianterestringido") {
                        ?>
                                <!-- <th>Pagar</th> -->
                        <?php
                    }
                    ?>
                            <th>Acción</th>
                        </tr>
                        <?php
                        $this->mostrar_ordenesporpagarvigentes($ruta, $rutaimpresion);
                        ?>
                    </table>
                    <br>

                            <?php
                        }
                        if ($ordenesvencidas) {
                            ?>
                    <table class="table table-bordered " width="100%" border="1" cellpadding="1" cellspacing="0" style="font-size: 12px">
                        <tr id="">
                            <th colspan="2">
                                <strong>ORDENES <?php echo $titulo ?> POR PAGAR FUERA DE LA FECHA LIMITE</strong>
                                <small>
                                    Haga click en el n&uacute;mero orden de pago para mayor informaci&oacute;n
                                </small>
                            </th>
                        </tr>
                        <tr id="trtituloNaranjaInst">
                            <th>No. Orden</th>
                            <th>Fecha </th>
                        </tr>
                    <?php
                    $this->mostrar_ordenesporpagarvencidas($ruta, $rutaimpresion);
                    ?>
                    </table>
        <?php
    }
}
?>

<!--end-->