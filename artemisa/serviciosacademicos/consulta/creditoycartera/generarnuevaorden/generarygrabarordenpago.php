<?php
     require_once('../../interfacespeople/funcionesPS.php');

    // Tomo los datos de la primera orden
    // Verifico si hay conceptos nuevos y los adiciono
    $numeroordenpagoini = $numeroordenpago;
    $paramodificar = false;
    $totalrecargos = 0;
    $totaldescuentos = 0;
    $valormatricula = 0;
    $pecuniarios = 0;
    $totalextemporanea = 0;

    $ordenesmodificacion = new OrdenesModificacion();

    /***PRIMERO SE VALIDA SI LA ORDEN PUEDE SER GENERADA ***/
    /** SE REALIZA COPIA DE LA ORDEN ACTUAL POR LA CONSULTA **/
    $row_selordenpago = $ordenesmodificacion->ordenPago($db,$numeroordenpagoini);

    /** SI LA CONUSLTA OBTIENE DATOS **/
    if(isset($row_selordenpago['codigoperiodo']) && !empty($row_selordenpago['codigoperiodo'])){
        /************* Agregado Para adicionar la nueva orden ******************************/
        $query_selmaxnumeroordenpago="SELECT max(numeroordenpago) as mayor FROM ordenpago";        
        $row_selmaxnumeroordenpago=$db->GetRow($query_selmaxnumeroordenpago);
        $numeroordenpago = $row_selmaxnumeroordenpago['mayor'] + 1;

        if(!isset($codigoestudiante) || empty($codigoestudiante)){
            $codigoestudiante= $row_selordenpago['codigoestudiante'];
        }

        $query_selsubperiodo="SELECT s.idsubperiodo,e.codigocarrera,p.codigoperiodo,fechainiciofinancierosubperiodo,".
        " fechafinalfinancierosubperiodo ".
        " FROM periodo p, carreraperiodo cp, subperiodo s,estudiante e ".
        " WHERE p.codigoperiodo  = cp.codigoperiodo AND s.idcarreraperiodo = cp.idcarreraperiodo ".
        " AND cp.codigocarrera = e.codigocarrera  AND e.codigoestudiante = '$codigoestudiante' ".
        " and p.codigoperiodo = '".$row_selordenpago['codigoperiodo']."' ".
        " AND fechafinalfinancierosubperiodo >= '".date("Y-m-d")."'";
        $row_selsubperiodo = $db->GetRow($query_selsubperiodo);

        if(isset($row_selsubperiodo['idsubperiodo']) && !empty($row_selsubperiodo['idsubperiodo'])){
            $codigoperiodo = $row_selsubperiodo['codigoperiodo'];
            $codigocarrera = $row_selsubperiodo['codigocarrera'];

            //Sí la carrera es 98 = COLEGIO BILINGUE DE LA UNIVERS
            if($codigocarrera == 98){
                //Valida si estan los dias de interes y el porcentaje
                if(empty($_POST['diasinteres']) && !empty($_POST['porcentaje'])){
                    ?>
                    <script language="javascript">
                        alert("Para generar una nueva orden de colegio debe colocar el número de días para el calculo de intereses.")
                    </script>
                    <?php
                    exit();
                }
            }//if
            if(!isset($_POST['porcentaje']) || empty($_POST['porcentaje'])){
                $_POST['porcentaje'] = 0;
            }

            $row_selordenpago['idsubperiodo'] = $row_selsubperiodo['idsubperiodo'];
            $ordenvalida = true;

            // Selecciona el codigotipocosto de la carrera
            $tipocosto = $ordenesmodificacion->costoBeneficio($db, $codigoestudiante);

            if(isset($tipocosto['codigotipocosto']) && !empty($tipocosto['codigotipocosto'])){
                $tipoorden="";
                $row_tipocosto = $tipocosto;
                if(preg_match("/^1.+$/",$row_tipocosto['codigotipocosto'])){
                    $tipoorden = "Centro Beneficio";
                    if($row_tipocosto['codigocentrobeneficio'] == 1){
                        ?>
                        <script language="javascript">
                            alert("La carrera requiere centro de beneficio y se encuentra en 1");
                        </script>
                        <?php
                        $ordenvalida = false;
                    }
                    else{
                        $ordeninternaocentrobeneficio = $row_tipocosto['codigocentrobeneficio'];
                    }
                }
                else if(preg_match("/^2.+$/",$row_tipocosto['codigotipocosto'])){
                    $tipoorden="Orden Interna";
                    if(!is_array($materiascongrupo)){
                        unset($materiascongrupo);
                        $query_grupos= "select g.idgrupo from grupo g, materia m ".
                        " where m.codigocarrera = '$codigocarrera' and m.codigomateria = g.codigomateria ".
                        " and g.codigoperiodo = '$codigoperiodo'";
                        $row_grupos=$db->GetAll($query_grupos);
                        foreach($row_grupos as $grupos){
                            $materiascongrupo[] = $grupos['idgrupo'];
                        }
                    }//if

                    if(is_array($materiascongrupo)){
                        $gruposavalidar = "";
                        foreach($materiascongrupo as $key => $idgrupo){
                            $gruposavalidar = $gruposavalidar." n.idgrupo = $idgrupo or";
                        }
                        $gruposavalidar = ereg_replace("or$","",$gruposavalidar);
                        // Si entra aca es por que aplica orden interna sap, el número de orden interna depende del grupo al que se mete el
                        // estudiante, es decir que tengo que pasarle el idgrupo para poderlo validar
                        $query_numeroordeninterna = "select distinct n.numeroordeninternasap, ".
                        " n.fechavencimientonumeroordeninternasap ".
                        " from numeroordeninternasap n, grupo g, materia m, estudiante e ".
                        " where m.codigomateria = g.codigomateria ".
                        " and ($gruposavalidar) and m.codigocarrera = e.codigocarrera ".
                        " and g.codigoperiodo = '$codigoperiodo' and e.codigoestudiante = '$codigoestudiante' ".
                        " and n.fechavencimientonumeroordeninternasap >= '".date("Y-m-d")."' order by 2 desc";
                        $numeroordeninterna = $db->GetRow($query_numeroordeninterna);

                        if(isset($numeroordeninterna['numeroordeninternasap']) && !empty($numeroordeninterna['numeroordeninternasap'])){
                            $ordeninternaocentrobeneficio = $numeroordeninterna['numeroordeninternasap'];
                        }
                        else{
                            ?>
                            <script language="javascript">
                                alert("El grupo requiere orden pago interna y no posee una activa");
                            </script>
                            <?php
                            $ordenvalida = false;
                        }
                    }
                    else{
                        ?>
                        <script language="javascript">
                            alert("La carrera requiere orden pago interna y no posee una activa");
                        </script>
                        <?php
                        $ordenvalida = false;
                    }
                }
            }
            else
            {
                ?>
                <script language="javascript">
                    alert("Error del sistema, la carrera no existe o tiene otro tipo de costo");
                </script>
                <?php
                $ordenvalida = false;
            }
        }
        else{
            ?>
            <script language="javascript">
                alert("El programa académico no tiene un subperiodo activo, por favor solicitar que se le adicione un subperiodo activo al programa académico con una fecha finaciera válida.")
            </script>
            <?php
            exit();
        }
    }
    else{
        $ordenvalida = false;        
    }

    if($ordenvalida){
        // EN ESTA PARTE SE INVOCA EL WEB SERVICE PARA ANULAR LA ORDEN
        $_GET['numeroordenpago']=$_REQUEST['orden'];
        $_GET['documentoingreso']=$_REQUEST['codigo'];

        //inactivacion por proceso de validcion por people
        /*require_once($_SESSION['path_live'].'consulta/interfacespeople/ordenesdepago/anularordenespagosala.php');
        if($result['ERRNUM']!=0){
            echo "<script>alert('La orden numero '+".$_GET['numeroordenpago']."+' no pudo ser anulada. ' +".$result['DESCRLONG']." +
            'Por favor tome nota de este numero y contactese con la universidad para recibir ayuda en este proceso. Gracias.')</script>";
            exit;
            //********************************************************************************************************
        }*/
                
        //Se actualiza el estado de la orden de pago a anulada (21)
        $ordenesmodificacion->updateorden($db, $numeroordenpagoini, 21);

        // Cada vez que se anule una orden de pago guardar en logordenpago si existe sesión de usuario
        if(isset($_SESSION['MM_Username']) && !empty($_SESSION['MM_Username'])){
            //consulta el idusuario  del usuario de la session
            $idusuario = $ordenesmodificacion->usuario($db, $_SESSION['MM_Username']);
            //Crea un registro en el log de pagos
            $ordenesmodificacion->logordenpago($db,$numeroordenpagoini, $idusuario,'ANULACION - MODIFICAR ORDEN' );
        }
        else{
            //Crea un registro en el log de pagos
            $ordenesmodificacion->logordenpago($db,$numeroordenpagoini, 2,'ANULACION - MODIFICAR ORDEN' );
        }
	
        //Crea registro para la nueva orden de pago al estudiante
        $datos = Array();

        $datos['numeroorden']= $numeroordenpago;
        $datos['codigoestudiante'] = $codigoestudiante;
        $datos['fecha'] = date("Y-m-d",time());
        $datos['prematricula'] = $row_selordenpago['idprematricula'];
        $datos['fechaentregaordenpago'] = $row_selordenpago['fechaentregaordenpago'];
        $datos['periodo'] = $codigoperiodo;
        $datos['estadoordenpago'] = '11';
        $datos['imprimeorden'] = '01';
        $datos['observacionordenpago'] = $numeroordenpagoini;
        $datos['codigocopiaordenpago'] = '100';
        $datos['documentosapordenpago'] = '';
        $datos['idsubperiodo'] = $row_selordenpago['idsubperiodo'];
        $datos['idsubperiododestino'] =  $row_selsubperiodo['idsubperiodo'];
        $datos['fechapagosapordenpago'] =  '0000-00-00';

        $ordenesmodificacion->crearOrden($db, $datos);

        // Cada vez que se inserte una orden de pago guardar en logordenpago si existe sesión de usuario
        if(isset($_SESSION['MM_Username'])){
            //consulta el id del usuario
            $idusuario = $ordenesmodificacion->usuario($db, $_SESSION['MM_Username']);
            //inserta un registro en el log depagos
            $ordenesmodificacion->logordenpago($db,$numeroordenpago, $idusuario,'CREACION- MODIFICAR ORDEN' );
        }
        else{
            //crea un registro en el log de pagos
            $ordenesmodificacion->logordenpago($db,$numeroordenpago, 2,'CREACION- MODIFICAR ORDEN' );
        }
    }
    else{
	   exit();
    }

    //consulta el detalle de la orden de pago
    $rows_seldetalleordenpago = $ordenesmodificacion->detallesOrdenpago($db, $numeroordenpagoini);
    $countrow = count($rows_seldetalleordenpago);

    if($countrow > 0) {
        foreach($rows_seldetalleordenpago as $row_seldetalleordenpago) {
            if (isset($row_seldetalleordenpago['codigotipodetalleordenpago']) && !empty($row_seldetalleordenpago['codigotipodetalleordenpago'])) {
                //inserta los registro en el detalle de la orden de pag
                if($row_seldetalleordenpago['codigoconcepto'] != "C9110" &&
                    $row_seldetalleordenpago['codigoconcepto'] != "C9111"){
                    $detalles = array();
                    $detalles['numeroordenpago']= $numeroordenpago;
                    $detalles['codigoconcepto'] = $row_seldetalleordenpago['codigoconcepto'];
                    $detalles['cantidaddetalleordenpago'] = "1";
                    $detalles['valorconcepto'] = $row_seldetalleordenpago['valorconcepto'];
                    $detalles['codigotipodetalle'] = $row_seldetalleordenpago['codigotipodetalleordenpago'];

                    $ordenesmodificacion->crearDetalleOrden($db, $detalles);
                }
            }
        }
    }

    //si no existe una fecha se asignan la fechas esistentes
    if(!isset($_POST['fecha'])) {
        //consulta los detalles de la orden
        $rows_selfechaordenpago = $ordenesmodificacion->fechaOrden($db, $numeroordenpagoini);
        $countrows = count($rows_selfechaordenpago);

        if($countrows > 0) {
            foreach ($rows_selfechaordenpago as $row_selfechaordenpago) {
                if (isset($row_selfechaordenpago['numeroordenpago']) && !empty($row_selfechaordenpago['numeroordenpago'])) {
                    //crea registro de la fecha de orden de pago para cada detalle
                    $datosfecha = array();
                    $datosfecha['numeroordenpago'] = $numeroordenpago;
                    $datosfecha['fechaordenpago'] = $row_selfechaordenpago['fechaordenpago'];
                    $datosfecha['porcentajefechaordenpago'] = $row_selfechaordenpago['porcentajefechaordenpago'];
                    $datosfecha['valorfechaordenpago'] = $row_selfechaordenpago['valorfechaordenpago'] ;

                    $ordenesmodificacion->crearFechaOrden($db, $datosfecha);
                }
            }//foreach
        }
    }

    //actualiza el registro del detalle prematricula
    $ordenesmodificacion->updateDetallePrematricula($db, $numeroordenpago, $numeroordenpagoini);

    // Elimino los que esten en dos e inserto los que aparezcan en dvd
    // Si son orginales o adicionados los inserta
    // Elimina los conceptos que no son del tipo arp

    $condicion = "and codigotipodetalleordenpago = 2  and codigoconcepto <> '165'";
    $ordenesmodificacion->eliminarDetalle($db, $numeroordenpago, $condicion);

    //Calculo valor extraordinario.
    if (isset($_POST['porcentaje']) && !empty($_POST['porcentaje'])){
        //si la carrera es de colegio
        if($codigocarrera != 98){
            //consulta los datos de la orden
            $query_detallesordenpago151 = "select sum(d.valorconcepto) as valormatriculita ".
            " from detalleordenpago d, concepto c where d.numeroordenpago = '$numeroordenpago' ".
            " and c.codigoconcepto = d.codigoconcepto and d.codigoconcepto = 151";
            $row_detallesordenpago151 = $db->GetRow($query_detallesordenpago151);        
            // Calculo Extemporanea
            $totalextemporanea = $row_detallesordenpago151['valormatriculita'] * $_POST['porcentaje'] / 100;
        }
        else{
            //consulta los datos de la orden
            $query_detallesordenpago151 = "select sum(d.valorconcepto) as valormatriculita ".
            " from detalleordenpago d, concepto c where d.numeroordenpago = '$numeroordenpago' ".
            " and c.codigoconcepto = d.codigoconcepto and d.codigoconcepto in (159, 'C9076', 'C9077')";
            $row_detallesordenpago151 = $db->GetRow($query_detallesordenpago151);

            // Calculo Extemporanea E:G:R 18-12-2006
            $totalextemporanea = $row_detallesordenpago151['valormatriculita'] * $_POST['porcentaje'] / 100 * $_POST['diasinteres'] / 30;
            $totalextemporanea = round($totalextemporanea/100, 0)*100;
        }
    }
    
    // Selecciona los detalles de la orden de pago
    $query_detallesordenpago = "select d.codigoconcepto, d.valorconcepto, d.codigotipodetalleordenpago, ".
    " c.codigotipoconcepto,idsubperiodo from detalleordenpago d, concepto c , ordenpago o ".
    " where d.numeroordenpago = '$numeroordenpago' and o.numeroordenpago = d.numeroordenpago ".
    " and c.codigoconcepto = d.codigoconcepto";
    $rows_detallesordenpago = $db->GetAll($query_detallesordenpago);

    foreach($rows_detallesordenpago as $row_detallesordenpago){
        $subperiodo = $row_detallesordenpago['idsubperiodo'];
		if($row_detallesordenpago['codigoconcepto'] == '151'){
			$valormatricula = $valormatricula + $row_detallesordenpago['valorconcepto'];
		}
		else if($row_detallesordenpago['codigoconcepto'] == '154'){
			$valormatricula = $valormatricula + $row_detallesordenpago['valorconcepto'];
		}
		else if($row_detallesordenpago['codigoconcepto'] == '165'){
			$pecuniarios = $pecuniarios + $row_detallesordenpago['valorconcepto'];
		}
		else if($row_detallesordenpago['codigotipodetalleordenpago'] == '3'){
			$pecuniarios = $pecuniarios + $row_detallesordenpago['valorconcepto'];
		}
		else if($row_detallesordenpago['codigoconcepto'] == '159'){
			$valormatricula = $valormatricula + $row_detallesordenpago['valorconcepto'];
		}
        else if($row_detallesordenpago['codigoconcepto'] == 'C9076'){
            $valormatricula = $valormatricula + $row_detallesordenpago['valorconcepto'];
        }
        else if($row_detallesordenpago['codigoconcepto'] == 'C9077'){
            $valormatricula = $valormatricula + $row_detallesordenpago['valorconcepto'];
        }
        else if($row_detallesordenpago['codigoconcepto'] == '149'){
			$valormatricula = $valormatricula + $row_detallesordenpago['valorconcepto'];
		}
		else if($row_detallesordenpago['codigoconcepto'] == '110'){
			$valormatricula = $valormatricula + $row_detallesordenpago['valorconcepto'];
		}
		else if($row_detallesordenpago['codigoconcepto'] == '114'){
			$valormatricula = $valormatricula + $row_detallesordenpago['valorconcepto'];
		}
		else if($row_detallesordenpago['codigoconcepto'] == 'C9018'){
			$valormatricula = $valormatricula - $row_detallesordenpago['valorconcepto'];
		}
		else if($row_detallesordenpago['codigoconcepto'] == 'C9066'){
			$valormatricula = $valormatricula + $row_detallesordenpago['valorconcepto'];
		}
    }//foreach
    /*****************************************************************************************************/
    // OJO Toma los conceptos de las deudas y se mira si estan en la orden (u ordenes del estudiante?)
    // Aca toma para sala
    $query_descuentodeuda = "select dvd.codigoconcepto, dvd.valordescuentovsdeuda, ".
    " c.codigotipoconcepto, dvd.codigoactualizo from descuentovsdeuda dvd, concepto c ".
    " where dvd.codigoestudiante = '$codigoestudiante' and dvd.codigoestadodescuentovsdeuda = '01' ".
    " and dvd.codigoperiodo = '$codigoperiodo' and c.codigoconcepto = dvd.codigoconcepto ".
    " order by dvd.codigoconcepto";
    $rows_descuentodeuda = $db->GetAll($query_descuentodeuda);

    // Si el numero de conceptos de dvd son iguales a los de la orden de pago
    // entonces los genera
    // Deberia verificar para todas las ordenes del estudiante
    $paramodificar = false;

    foreach($rows_descuentodeuda as $row_descuentodeuda){
        if(isset($row_descuentodeuda['codigoconcepto']) && !empty($row_descuentodeuda['codigoconcepto'])){
            if($row_descuentodeuda['codigotipoconcepto'] == 01){
                $totalrecargos = $totalrecargos + $row_descuentodeuda['valordescuentovsdeuda'];
            }
            if($row_descuentodeuda['codigotipoconcepto'] == 02){
                $totaldescuentos = $totaldescuentos + $row_descuentodeuda['valordescuentovsdeuda'];
            }
            if($row_descuentodeuda['codigoconcepto'] != "C9110" &&
                $row_descuentodeuda['codigoconcepto'] != "C9111") {
                //insert al detalleordenpago
                $detalles = array();
                $detalles['numeroordenpago'] = $numeroordenpago;
                $detalles['codigoconcepto'] = $row_descuentodeuda['codigoconcepto'];
                $detalles['cantidaddetalleordenpago'] = "1";
                $detalles['valorconcepto'] = $row_descuentodeuda['valordescuentovsdeuda'];
                $detalles['codigotipodetalle'] = '2';

                $ordenesmodificacion->crearDetalleOrden($db, $detalles);
                $paramodificar = true;
            }
        }
    }//foreach

    // Toma las deudas de sap
    require_once('../../estadocredito/tomar_saldofavorcontra.php');

    if(isset($saldoafavor) && !empty($saldoafavor)){
        foreach($saldoafavor as $key => $arregloconceptos){
            // Si la deuda ya se referencia en un concepto de orden no se toma en cuenta
            // Si no se debe adicionar a la orden de pago

            // Las ordenes que se usan para ver si existe la deuda es la del periodo activo
            // Es decir que si generan una orden de pago este tomaria la deuda para cada periodo
            /*if($arregloconceptos[0] == $codigocarrera)
            {*/
			
            function convertirPositivo($valortotal){
                $valortotal=$valortotal * (-1);
                return $valortotal;
            }//function convertirPositivo
			
			
            $valorsaldofavor=convertirPositivo($arregloconceptos[4]);
			
            if($codigomodalidadacademica != 100){
				$query_selconceptoexiste = "SELECT o.numeroordenpago FROM ordenpago o, detalleordenpago d ".
				" where o.codigoestudiante = '$codigoestudiante' ".
				" and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%') ".
				" and o.codigoperiodo = '$codigoperiodo' and d.numeroordenpago = o.numeroordenpago ".
				" and d.codigoconcepto  = '".$arregloconceptos[1]."' and d.valorconcepto   = '".$arregloconceptos[4]."'";
			}
			else{
				$query_selconceptoexiste = "SELECT o.numeroordenpago ".
				" FROM ordenpago o, detalleordenpago d, grupoperiodocarrera g, detallegrupoperiodocarrera dg ".
				" where o.codigoestudiante = '$codigoestudiante' ".
				" and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%') ".
				" and o.codigoperiodo = dg.codigoperiodo and d.numeroordenpago = o.numeroordenpago ".
				" and d.codigoconcepto = '".$arregloconceptos[1]."' and d.valorconcepto   = '".$arregloconceptos[4]."' ".
				" and g.codigocarrera = '$codigocarrera' and g.idgrupoperiodocarrera = dg.idgrupoperiodocarrera ".
				" and g.fechainiciogrupoperiodocarrera <= '".date("Y-m-d")."' ".
				" and g.fechafinalgrupoperiodocarrera >= '".date("Y-m-d")."'";
			}			
			$totalRows_selconceptoexiste = $db->GetRow($query_selconceptoexiste);			
            
			if($totalRows_selconceptoexiste['numeroordenpago'] == ""){
				$valormatricula= $valormatricula - $valorsaldofavor;
				$saldo = ($saldo + $arregloconceptos[4]);

                $detalles = array();
                $detalles['numeroordenpago'] = $numeroordenpago;
                $detalles['codigoconcepto'] = $arregloconceptos[1];
                $detalles['cantidaddetalleordenpago'] = "1";
                $detalles['valorconcepto'] =$arregloconceptos[4];
                $detalles['codigotipodetalle'] = '2';

                $ordenesmodificacion->crearDetalleOrden($db, $detalles);
            }//if
        }//foreach
    }//if

    // Si viene una fecha adicional se debe insertar calculandola con el recargo adecuado.
    if(isset($_POST['fecha']) && !empty($_POST['fecha'])){
        //si es un descuento
        if($_POST['porcentajedescuento'] == "descuento"){
            $totalconrecargo = $valormatricula  + $pecuniarios + $totalrecargos - $totaldescuentos -$totalextemporanea;
        }
        //si es un incremento
        if( $_POST['porcentajedescuento'] == 'incremento'){
            // Si entra es por que se debe insertar una fecha adicional
            $totalconrecargo = $valormatricula + $totalextemporanea + $pecuniarios + $totalrecargos - $totaldescuentos;
        }

        $datosfecha = array();
        $datosfecha['numeroordenpago'] = $numeroordenpago;
        $datosfecha['fechaordenpago'] =$_POST['fecha'];
        $datosfecha['porcentajefechaordenpago'] = $_POST['porcentaje'];
        $datosfecha['valorfechaordenpago'] = $totalconrecargo;
        $ordenesmodificacion->crearFechaOrden($db, $datosfecha);

        if($totalextemporanea <> 0){
            $query_fechasubperiodo="SELECT * from subperiodo where idsubperiodo = '$subperiodo'";
            $row_fechasubperiodo=$db->GetRow($query_fechasubperiodo);

            //si la carrera es colegio
            if($codigocarrera == 98){
                $detalles = array();
                $detalles['numeroordenpago'] = $numeroordenpago;
                $detalles['codigoconcepto'] = '115';
                $detalles['cantidaddetalleordenpago'] = "1";
                $detalles['valorconcepto'] =$totalextemporanea;
                $detalles['codigotipodetalle'] = '2';
                $ordenesmodificacion->crearDetalleOrden($db, $detalles);
            }
            else{
                if ($row_fechasubperiodo['fechainiciofinancierosubperiodo'] <= date("Y-m-d")
                    && $row_fechasubperiodo['fechafinalfinancierosubperiodo'] >= date("Y-m-d")){
                    $detalles = array();
                    $detalles['numeroordenpago'] = $numeroordenpago;
                    $detalles['cantidaddetalleordenpago'] = "1";
                    $detalles['valorconcepto'] =$totalextemporanea;
                    //si es descuento y pregrado o pregrado virtual
                    if($_POST['porcentajedescuento'] == "descuento" &&
                        ($tipocosto['codigomodalidadacademica'] == 200 || $tipocosto['codigomodalidadacademica'] == 800)){
                        //concepto de Apoyo
                        $detalles['codigoconcepto'] = 'C9110';
                        $detalles['codigotipodetalle'] = '1';
                    }
                    //si es descuento y postgrado o postgrado virtual
                    else if($_POST['porcentajedescuento'] == "descuento" &&
                        ($tipocosto['codigomodalidadacademica'] == 300 || $tipocosto['codigomodalidadacademica'] == 810)){
                        //concepto de apoyo
                        $detalles['codigoconcepto'] = 'C9111';
                        $detalles['codigotipodetalle'] = '1';
                    }
                    //si no es descuento
                    else{
                        $detalles['codigoconcepto'] = 'C9064';
                        $detalles['codigotipodetalle'] = '2';
                    }
                    $ordenesmodificacion->crearDetalleOrden($db, $detalles);
                }
                //si no esta en las fechas
                else{

                    $detalles = array();
                    $detalles['numeroordenpago'] = $numeroordenpago;
                    $detalles['cantidaddetalleordenpago'] = "1";
                    $detalles['valorconcepto'] =$totalextemporanea;

                    //si es descuento
                    if($_POST['porcentajedescuento'] == "descuento"){
                        $detalles['codigoconcepto'] = 'C9110';
                        $detalles['codigotipodetalle'] = '2';
                    }
                    else{
                        $detalles['codigoconcepto'] = '105';
                        $detalles['codigotipodetalle'] = '2';
                    }
                    $ordenesmodificacion->crearDetalleOrden($db, $detalles);
                }
            }//else
        }//if   
    }   
    else{
        //consulta los datos de la oderden y la fecha
        $query_fecha="SELECT o.numeroordenpago, f.valorfechaordenpago, f.porcentajefechaordenpago, f.fechaordenpago ".
        " FROM ordenpago o, fechaordenpago f where o.codigoestudiante = '$codigoestudiante' ".
        " and o.codigoestadoordenpago like '1%' and o.codigoperiodo = '$codigoperiodo' ".
        " and f.numeroordenpago = o.numeroordenpago and o.numeroordenpago = '$numeroordenpago'";

        while($row_fecha=$db->GetRow($query_fecha)){
            $totalconrecargo = $valormatricula + ($valormatricula * $row_fecha['porcentajefechaordenpago'] / 100)+
            $pecuniarios +$totalrecargos - $totaldescuentos;
            $ordenesmodificacion->updateFechaOrden($db, $totalconrecargo, $numeroordenpago, $row_fecha['porcentajefechaordenpago']);
        }
    }

    // Informar a sap
    $query_selgrupos = "select dp.idgrupo, dp.codigomateria from detalleprematricula dp ".
    " where dp.numeroordenpago = '$numeroordenpago' ".
    " and (dp.codigoestadodetalleprematricula like '1%' or dp.codigoestadodetalleprematricula like '3%')";
    $rows_selgrupos=$db->GetAll($query_selgrupos);
    foreach($rows_selgrupos as $row_selgrupos){
        $idgrupo = $row_selgrupos['idgrupo'];
    }

    $resultado = estudianteOrden($db,$numeroordenpago, "Modificacion", $idgrupo);

    if (isset($resultado['ERRNUM']) && !empty($resultado['ERRNUM'])) {
        $errornum = $resultado['ERRNUM'];
    } else {
        if(isset($resultado['faultcode']) && !empty($resultado['faultcode'])){
            $errornum = $resultado['detail']['IBResponse']['DefaultTitle'];
            $errornum.= "-".$resultado['detail']['IBResponse']['DefaultMessage'];
        }else{
            $errornum = " ";
        }
    }?>

    <div class="table">
        <h4>Resultado People: </h4>
        <p>La orden creada es <?php echo $numeroordenpago;?></p>
        <p><?php echo "$errornum ".$resultado['DESCRLONG'];?></p>
    </div>
    <script language="javascript">
        alert("Se ha generado la orden de pago <?php echo $numeroordenpago ?>,puede imprimirla");
    </script>
