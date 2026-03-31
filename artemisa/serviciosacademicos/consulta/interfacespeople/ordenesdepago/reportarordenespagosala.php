<?php
require_once(dirname(__FILE__) . '/../../../Connections/sala2.php');
$rutaado = dirname(__FILE__) . "/../../../funciones/adodb/";
require_once(dirname(__FILE__) . '/../../../Connections/salaado.php');
require_once(dirname(__FILE__) . '/../../../consulta/interfacespeople/conexionpeople.php');
require_once(dirname(__FILE__) . '/../../../../nusoap/lib/nusoap.php');
require_once(dirname(__FILE__) . '/../../../consulta/interfacespeople/cambia_fecha_people.php');
require_once(realpath(dirname(__FILE__)) . '/../../../utilidades/funcionesTexto.php');

$results = array();

require_once(dirname(__FILE__) . '/../../interfacespeople/reporteCaidaPeople.php');

$envio = 0;
$servicioPS = verificarPSEnLinea();

if ($servicioPS) {

    // SE PONE UN TIEMPO DE RESPUESTA DE 30 SEGUNDOS
    $client = new nusoap_client(WEBORDENDEPAGO, true, false, false, false, false, 0, 30);
    $err = $client->getError();

    if ($err)
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';

    $proxy = $client->getProxy();
    $err = $client->getError();

}

if ($datos['paisnacionalidad'] == "" || $datos['paisnacionalidad'] == null || $datos['paisnacionalidad'] == 0) {
    //bogota colombia
    $datos['paisnacionalidad'] = "CO";
    $datos['departamentonacionalidad'] = 11;
    $datos['ciudadnacionalidad'] = 11001;
}

$parametros['UBI_OPERACION_ORD'] = 'C';
$parametros['NATIONAL_ID_TYPE'] = $datos['tipodocumento'];
$parametros['NATIONAL_ID'] = $datos['documento'];
$parametros['NATIONAL_ID_TYPE_OLD'] = "";
$parametros['NATIONAL_ID_OLD'] = "";
$parametros['FIRST_NAME'] = sanear_string($datos['primernombre'], false);
$parametros['MIDDLE_NAME'] = sanear_string($datos['segundonombre'], false);
$parametros['LAST_NAME'] = sanear_string($datos['primerapellido'], false);
$parametros['SECOND_LAST_NAME'] = sanear_string($datos['segundoapellido'], false);
$parametros['BIRTHDATE'] = $datos['fechanacimiento'];
$parametros['BIRTHCOUNTRY'] = $datos['paisnacionalidad'];
$parametros['BIRTHSTATE'] = $datos['departamentonacionalidad'];
$parametros['BIRTHPLACE'] = $datos['ciudadnacionalidad'];
$parametros['SEX'] = $datos['genero'];
$parametros['MAR_STATUS'] = $datos['estadocivil'];
$parametros['ADDRESS1'] = $datos['direccion'];
if ($datos['direccion'] == null || trim($parametros['ADDRESS1']) == "") {
    $parametros['ADDRESS1'] = 'KR 7B BIS No. 132-11';
}
$parametros['PHONE'] = $datos['telefono'];
$parametros['EMAIL_ADDR'] = $datos['email'];
$parametros['BUSINESS_UNIT'] = 'UBSF0';
$parametros['INVOICE_ID'] = $datos['numeroordenpago'];
$parametros['INVOICE_DT'] = $datos['fechacreacion'];
$parametros['DUE_DT'] = $datos['fechavencimiento'];
$parametros['TOTAL_BILL'] = $datos['totalordenpago'];
$anio = substr($datos['periodo'], 2, 2);
$mes = str_pad(substr($datos['periodo'], 4, strlen($datos['periodo'])), 2, 0, STR_PAD_LEFT);
$parametros['STRM'] = $anio . $mes;


$query = "select tipocuenta "
    . "from detalleordenpago dop "
    . "join carreraconceptopeople ccp on dop.codigoconcepto=ccp.codigoconcepto "
    . "where numeroordenpago='".$datos['numeroordenpago']."' ".
    " and ccp.codigocarrera in ('".$datos['codigocarrera']."', 1) ".
    " group by tipocuenta";

$exec = mysql_query($query, $sala) or die("$query" . mysql_error());
while ($row = mysql_fetch_array($exec))
    $arrTiposCuenta[] = $row['tipocuenta'];

$xml_det = "";
$auxCreacionAporte = false;

$valida_hay_descuento = false;
$query_hay_descuento = "SELECT * from detalleordenpago ".
" where codigoconcepto in ('C9110','C9111') AND numeroordenpago in (". $datos['numeroordenpago'] .")";
$exec_hay_descuento = mysql_query($query, $sala) or die("$query" . mysql_error());

if (mysql_num_rows($exec_hay_descuento) > 0) {
    $valida_hay_descuento = true;
}

//Aca va la primera parte de descuentos
require_once(dirname(__FILE__). "/../../../../sala/includes/adaptador.php");
require_once(dirname(__FILE__).'/../../prematricula/descuentos/descuento.php');
$db = Factory::createDbo();
$descuento = new Descuento($datos['numeroordenpago'],$datos['periodo'],$db, $valida_hay_descuento);

if (in_array("MAT", $arrTiposCuenta)) {
    $sqlCodigo="SELECT codigoestudiante FROM ordenpago ".
    " WHERE numeroordenpago=".$datos['numeroordenpago'];
    $execSqlCodigo= mysql_query($sqlCodigo);
    $rowCodigo = mysql_fetch_array($execSqlCodigo);

    // VERIFICA SI LA ORDEN GENERADA TIENE CONCEPTOS ADICIONALES AL DE MATRICULA COMO POR EJEMPLO (TEXTOS, CARNET, SALDO A FAVOR)
    $query = "SELECT COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) as itemcarreraconceptopeople ".
    " ,COALESCE(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta ,dop.valorconcepto ".
    " FROM detalleordenpago dop ".
    " LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto AND " . $datos['codigocarrera'] . "=ccp.codigocarrera ".
    " LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera ".
    " JOIN concepto c ON dop.codigoconcepto=c.codigoconcepto ".
    " WHERE numeroordenpago='" . $datos['numeroordenpago'] . "' AND concat(trim(cuentaoperacionprincipal),".
    " trim(cuentaoperacionparcial))<>'1510001'AND concat(trim(cuentaoperacionprincipal),".
    " trim(cuentaoperacionparcial))<>'0590005'";
    $exec = mysql_query($query, $sala) or die("$query" . mysql_error());
 
    if (mysql_num_rows($exec) == 0) {
        $query2 = "SELECT COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) as item_ccp ".
        ",COALESCE(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta ".
        ",dop.valorconcepto AS vlr_dop ,sub.fechaordenpago ,sub.valorfechaordenpago AS vlr_sub ".
        ",sub.itempagoextraordinario as item_sub, a.numeroordenpago as numeroaporte ".
        " FROM detalleordenpago dop ".
        " LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto and ".
        $datos['codigocarrera']."=ccp.codigocarrera ".
        " LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera ".
        " LEFT JOIN (     select distinct f.numeroordenpago, f.fechaordenpago, f.porcentajefechaordenpago, ".
        " f.valorfechaordenpago, '010210020002' as itempagoextraordinario ".
        " from fechaordenpago f where f.numeroordenpago='" . $datos['numeroordenpago'] . "' ".
        " ) AS sub ON dop.numeroordenpago=sub.numeroordenpago ".
        " LEFT JOIN AportesBecas a on a.numeroordenpago = dop.numeroordenpago ".
        " WHERE dop.numeroordenpago='" . $datos['numeroordenpago'] . "' ".
        " AND dop.codigoconcepto not in ('C9110','C9111') ORDER BY sub.fechaordenpago";
        $exec2 = mysql_query($query2, $sala) or die("$query2" . mysql_error());

        $valorCargoAdd = 0;
        $itemConceptoPeople = $descuento->conceptoPeople('itemcarreraconceptopeople');
        
        while ($row2 = mysql_fetch_array($exec2)) {
            if ($row2['vlr_dop'] == $row2['vlr_sub'] || $row2['item_ccp']==$itemConceptoPeople || $valida_hay_descuento) {
                $item_type = $row2['item_ccp'];
                $item_type_to = "";
            } else {
                $item_type = $row2['item_sub'];
                $item_type_to = $row2['item_ccp'];
            }
            $item_nbr = "";

            if($row2['item_ccp']==$itemConceptoPeople || $valida_hay_descuento){
                $item_amt = $row2['vlr_dop'];
            }else{
                $item_amt = $row2['vlr_sub'];
            }

            $account_type_sf = $row2['tipocuenta'];
            $item_effective_dt = cambiaf_a_people($parametros['INVOICE_DT']);
            $due_dt2 = cambiaf_a_people($row2['fechaordenpago']);

            $xml_det .= "	<UBI_ITEM_WRK>
						<ITEM_TYPE>" . $item_type . "</ITEM_TYPE>
						<ITEM_TYPE_TO>" . $item_type_to . "</ITEM_TYPE_TO>
						<ITEM_NBR>" . $item_nbr . "</ITEM_NBR>
						<ITEM_AMT>" . $item_amt . "</ITEM_AMT>
						<ACCOUNT_TYPE_SF>" . $account_type_sf . "</ACCOUNT_TYPE_SF>
						<ITEM_EFFECTIVE_DT>" . $item_effective_dt . "</ITEM_EFFECTIVE_DT>
						<DUE_DT2>" . $due_dt2 . "</DUE_DT2>
					</UBI_ITEM_WRK>";
            $valorCargoAdd = $row2['vlr_sub'];          
        }//while
    } else {
        $items_excluir = "";
        $suma_items_excluir1 = 0;
        $suma_items_excluir2 = 0;
        while ($row = mysql_fetch_array($exec)) {
            // SI EL VALOR DE LOS CONCEPTOS ADICIONALES ES MENOR A CERO, SE TOMA COMO UN SALDO A FAVOR
            if (!empty($row['itemcarreraconceptopeople'])) {
                $items_excluir .= $row['itemcarreraconceptopeople'] . ",";
            } else {
                $items_excluir .= "";
            }

            if ($row['valorconcepto'] > 0) {
                $auxCreacionAporte = true;
                $suma_items_excluir2 += $row['valorconcepto'];
                $item_type = $row['itemcarreraconceptopeople'];
                $item_type_to = "";
                $item_nbr = "";
                $item_amt = $row['valorconcepto'];
                $account_type_sf = $row['tipocuenta'];
                $item_effective_dt = cambiaf_a_people($parametros['INVOICE_DT']);
                $due_dt2 = cambiaf_a_people($parametros['DUE_DT']);

                //se corrgie la fecha del aporte de semillas
                //=============================
                $sql = "SELECT fechaordenpago from fechaordenpago"
                ." where numeroordenpago =". $datos['numeroordenpago']
                ." order by fechaordenpago desc limit 1";

                $sql_exec = mysql_query($sql, $sala) or die("$queryAporte" . mysql_error());
                $fechaAporte = mysql_fetch_array($sql_exec);
                $fechaAporte = $fechaAporte['fechaordenpago'];
                $fechaAporte = cambiaf_a_people($fechaAporte);
                //=============================

                $xml_det .= "	<UBI_ITEM_WRK>
							<ITEM_TYPE>" . $item_type . "</ITEM_TYPE>
							<ITEM_TYPE_TO>" . $item_type_to . "</ITEM_TYPE_TO>
							<ITEM_NBR>" . $item_nbr . "</ITEM_NBR>
							<ITEM_AMT>" . $item_amt . "</ITEM_AMT>
							<ACCOUNT_TYPE_SF>" . $account_type_sf . "</ACCOUNT_TYPE_SF>
							<ITEM_EFFECTIVE_DT>" . $item_effective_dt . "</ITEM_EFFECTIVE_DT>
							<DUE_DT2>" . $fechaAporte . "</DUE_DT2>
						</UBI_ITEM_WRK>";
            } else {
                $suma_items_excluir1 += $row['valorconcepto'];
            }
        }//while

        if (!empty($items_excluir)) {
            $sqlitem = "NOT IN (" . trim($items_excluir, ',') . ")";
        } else {
            $sqlitem = "";
        }

        $query2 = "SELECT COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) AS item_ccp ".
        " ,COALESCE(ccp.tipocuenta,ccp2.tipocuenta)	AS tipocuenta ".
        " ,dop.valorconcepto							AS vlr_dop ".
        " ,sub.fechaordenpago ,dop.valorconcepto + " . abs($suma_items_excluir1) . "		AS vlr_sub ".
        " ,sub.itempagoextraordinario						AS item_sub ".
        " FROM detalleordenpago dop ".
        " LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto and ".
        $datos['codigocarrera']."=ccp.codigocarrera ".
        " LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera ".
        " LEFT JOIN (     ".
            " select distinct f.numeroordenpago, f.fechaordenpago, f.porcentajefechaordenpago,".
            " f.valorfechaordenpago, '010210020002' as itempagoextraordinario ".
            " from fechaordenpago f ".
            " where f.numeroordenpago='" . $datos['numeroordenpago'] . "' ".
			" ) ".
        " AS sub ON dop.numeroordenpago=sub.numeroordenpago ".
        " WHERE dop.numeroordenpago='" . $datos['numeroordenpago'] . "' ".
        " AND COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) ".$sqlitem." ".
        " ORDER BY sub.fechaordenpago";
        $exec2 = mysql_query($query2, $sala) or die("$query2" . mysql_error());
        $valorCargoAdd = 0;

        while ($row2 = mysql_fetch_array($exec2)) {
            $vlrReal = $row2['vlr_sub'];

            if ($row2['vlr_dop'] == $vlrReal) {
                $item_type = $row2['item_ccp'];
                $item_type_to = "";
                $suma_items_excluir2 = 0;
            } else {
                $item_type = $row2['item_sub'];
                $item_type_to = $row2['|'];
            }
            $item_nbr = "";
            $item_amt = $vlrReal;

            $account_type_sf = $row2['tipocuenta'];
            $item_effective_dt = cambiaf_a_people($parametros['INVOICE_DT']);
            $due_dt2 = cambiaf_a_people($row2['fechaordenpago']);

            $xml_det .= "	<UBI_ITEM_WRK>
						<ITEM_TYPE>" . $item_type . "</ITEM_TYPE>
						<ITEM_TYPE_TO>" . $item_type_to . "</ITEM_TYPE_TO>
						<ITEM_NBR>" . $item_nbr . "</ITEM_NBR>
						<ITEM_AMT>" . $item_amt . "</ITEM_AMT>
						<ACCOUNT_TYPE_SF>" . $account_type_sf . "</ACCOUNT_TYPE_SF>
						<ITEM_EFFECTIVE_DT>" . $item_effective_dt . "</ITEM_EFFECTIVE_DT>
						<DUE_DT2>" . $due_dt2 . "</DUE_DT2>
					</UBI_ITEM_WRK>";
        }//while
    }
} elseif (in_array("PPA", $arrTiposCuenta)) {
    $parametros['UBI_OPERACION_ORD'] = 'F';
    $query = "select  COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) as itemcarreraconceptopeople ".
    " ,COALESCE(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta ,dop.valorconcepto ".
    " ,oppp.numerodocumentoplandepagosap as item_nbr ".
    " from detalleordenpago dop ".
    " LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto AND ".
    $datos['codigocarrera'] . "=ccp.codigocarrera ".
    " LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera ".
    " join ordenpagoplandepago oppp on dop.numeroordenpago=oppp.numerorodencoutaplandepagosap ".
    " and dop.codigoconcepto=oppp.cuentaxcobrarplandepagosap WHERE numeroordenpago=" . $datos['numeroordenpago'];
    $exec = mysql_query($query, $sala) or die("$query" . mysql_error());
    while ($row = mysql_fetch_array($exec)) {
        $item_type = $row['itemcarreraconceptopeople'];
        $item_type_to = "";
        $item_nbr = $row['item_nbr'];
        $item_amt = $row['valorconcepto'];
        $account_type_sf = $row['tipocuenta'];
        $item_effective_dt = cambiaf_a_people($parametros['INVOICE_DT']);
        $due_dt2 = cambiaf_a_people($parametros['DUE_DT']);
        $xml_det .= "	<UBI_ITEM_WRK>
					<ITEM_TYPE>" . $item_type . "</ITEM_TYPE>
					<ITEM_TYPE_TO>" . $item_type_to . "</ITEM_TYPE_TO>
					<ITEM_NBR>" . $item_nbr . "</ITEM_NBR>
					<ITEM_AMT>" . $item_amt . "</ITEM_AMT>
					<ACCOUNT_TYPE_SF>" . $account_type_sf . "</ACCOUNT_TYPE_SF>
					<ITEM_EFFECTIVE_DT>" . $item_effective_dt . "</ITEM_EFFECTIVE_DT>
					<DUE_DT2>" . $due_dt2 . "</DUE_DT2>
				</UBI_ITEM_WRK>";
    }//while
} else {
    $sqlFechaOrdenPago = "SELECT fechaordenpago  FROM ordenpago  WHERE  numeroordenpago=".$datos['numeroordenpago'];
    $execsqlFechaOrdenPago= mysql_query($sqlFechaOrdenPago,$sala) or die("$sqlFechaOrdenPago" . mysql_error());
    $rowsqlFechaOrdenPago = mysql_fetch_array($execsqlFechaOrdenPago);

    if($rowsqlFechaOrdenPago['fechaordenpago']  <= '2020-09-17'){
    // SI LA CONSULTA RETORNA RESULTADOS ES PORQUE LA ORDEN ES POR CONCEPTO DE INSCRIPCION.
    $query = "select count(*) as conteo from detalleordenpago dop ".
    " join concepto c on dop.codigoconcepto=c.codigoconcepto".
    "  where numeroordenpago ='" . $datos['numeroordenpago'] . "' and cuentaoperacionprincipal='153' ".
    "  and cuentaoperacionparcial='0001'";
    $exec = mysql_query($query, $sala) or die("$query" . mysql_error());
    $row = mysql_fetch_array($exec);
    if ($row['conteo'] > 0) {
        // PROCESO PARA DETERMINAR EL DUMMY AL QUE SE ASOCIARÁ LA ORDEN DE PAGO DE INSCRIPCIÓN
        //************************************************************************************
        $execDummy = mysql_query("select * from logdummyintregracionps where '" . $datos['numeroordenpago'] . "' between numeroordenpagoinicial and numeroordenpagofinal", $sala);

        //$execDummy = mysql_query("select * from logdummyintregracionps where codigoestado='100'",$sala);
        if (mysql_num_rows($execDummy) == 0) {
            $execPer = mysql_query("select concat(substr(codigoperiodo,1,4),0,substr(codigoperiodo,5,1)) as codigoperiodo from periodo where codigoestadoperiodo=1", $sala);
            $rowPer = mysql_fetch_array($execPer);
            $NATIONAL_ID = "PER" . $rowPer["codigoperiodo"] . date("Ymd");
            $cadenaDummy = "insert into logdummyintregracionps (dummy,contador,codigoestado,numeroordenpagoinicial,numeroordenpagofinal) values ('" . $NATIONAL_ID . "',1,'100'," . $datos['numeroordenpago'] . ",9999999)";
        } else {
            $rowDummy = mysql_fetch_array($execDummy);
            //En 1 solo para las pruebas, debe estar en 799
            if ($rowDummy["contador"] >= 799 && $rowDummy["codigoestado"] == 100)
                $cadenaDummy = "update logdummyintregracionps set contador=contador+1,numeroordenpagofinal=" . $datos['numeroordenpago'] . ",codigoestado='200' where idlogdummyintregracionps=" . $rowDummy["idlogdummyintregracionps"];
            else
                $cadenaDummy = "update logdummyintregracionps set contador=contador+1 where idlogdummyintregracionps=" . $rowDummy["idlogdummyintregracionps"];
            $NATIONAL_ID = $rowDummy["dummy"];
        }
        mysql_query($cadenaDummy, $sala);
        //************************************************************************************
        $parametros['INVOICE_ID'] = $_GET['numeroordenpago'];
        $parametros['NATIONAL_ID_TYPE'] = 'CC';
        $parametros['NATIONAL_ID'] = $NATIONAL_ID;
        $parametros['FIRST_NAME'] = 'DUMMY';
        $parametros['MIDDLE_NAME'] = 'DUMMY';
        $parametros['LAST_NAME'] = $NATIONAL_ID;
        $parametros['SECOND_LAST_NAME'] = $NATIONAL_ID;

        $parametros['BIRTHDATE'] = '1900-01-01';
        $parametros['BIRTHCOUNTRY'] = 'CO';
        $parametros['BIRTHSTATE'] = '11';
        $parametros['BIRTHPLACE'] = '11001';
        $parametros['SEX'] = 'F';
        $parametros['MAR_STATUS'] = 'S';
        $parametros['ADDRESS1'] = 'KR 7B BIS No. 132-11';
        $parametros['PHONE'] = '57 1 6331368';
        $parametros['EMAIL_ADDR'] = 'dummy@unbosque.edu.co';
        $parametros['INVOICE_ID'] = $datos['numeroordenpago'] . "-" . $datos['tipodocumento'] . $datos['documento'];
    }
}
    //se consulta los conceptos de la orden de pago
    $query2 = "SELECT	 COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) as itemcarreraconceptopeople
			,COALESCE(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta
			,dop.valorconcepto 
		FROM detalleordenpago dop
		LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto AND " . $datos['codigocarrera'] . "=ccp.codigocarrera
		LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera
		WHERE numeroordenpago=" . $datos['numeroordenpago'];
    $exec2 = mysql_query($query2, $sala) or die("$query2" . mysql_error());

    while ($row2 = mysql_fetch_array($exec2)) {
        $item_type = $row2['itemcarreraconceptopeople'];
        $item_type_to = "";
        $item_nbr = "";
        $item_amt = $row2['valorconcepto'];
        $account_type_sf = $row2['tipocuenta'];
        $item_effective_dt = cambiaf_a_people($parametros['INVOICE_DT']);
        $due_dt2 = cambiaf_a_people($parametros['DUE_DT']);

        $xml_det .= "	<UBI_ITEM_WRK>
					<ITEM_TYPE>" . $item_type . "</ITEM_TYPE>
					<ITEM_TYPE_TO>" . $item_type_to . "</ITEM_TYPE_TO>
					<ITEM_NBR>" . $item_nbr . "</ITEM_NBR>
					<ITEM_AMT>" . $item_amt . "</ITEM_AMT>
					<ACCOUNT_TYPE_SF>" . $account_type_sf . "</ACCOUNT_TYPE_SF>
					<ITEM_EFFECTIVE_DT>" . $item_effective_dt . "</ITEM_EFFECTIVE_DT>
					<DUE_DT2>" . $due_dt2 . "</DUE_DT2>
				</UBI_ITEM_WRK>";
    }
}

/**
 * @modified David Perez <perezdavid@unbosque.edu.do>
 * Se modifica el armado del xml para que se envíe el detalle de semillas a people siempre que exista en la tabla de AportesBecas.
 * Caso reportado por Orlando Sarmiento - Finanzas estudiantiles <sarmientoorlando@unbosque.edu.co> Fecha: 24 de Octubre de 2018,  Caso Mesa 106668
 * @since Diciembre 20, 2018
 */
$queryAporte = 'SELECT
                        ccp.itemcarreraconceptopeople as item_sub,
                        ccp.tipocuenta,
                        v.valorpecuniario
                    FROM
                        AportesBecas a
                    LEFT JOIN valorpecuniario v ON v.idvalorpecuniario = a.idvalorpecuniario
                    LEFT JOIN carreraconceptopeople ccp ON ccp.codigoconcepto = v.codigoconcepto
                    WHERE
                        a.numeroordenpago = ' . $datos['numeroordenpago'] . ' LIMIT 1';
$execAporte = mysql_query($queryAporte, $sala) or die("$queryAporte" . mysql_error());
$rowAporte = mysql_fetch_array($execAporte);




if ($rowAporte['item_sub'] != '' and !$auxCreacionAporte) {

    //=============================
    $sql = "SELECT fechaordenpago from fechaordenpago"
        ." where numeroordenpago =". $datos['numeroordenpago']
        ." order by fechaordenpago desc limit 1";

    $sql_exec = mysql_query($sql, $sala) or die("$queryAporte" . mysql_error());
    $fechaAporte = mysql_fetch_array($sql_exec);
    $fechaAporte = $fechaAporte['fechaordenpago'];
    $fechaAporte = cambiaf_a_people($fechaAporte);
    //=============================

    $xml_det .= "<UBI_ITEM_WRK>
                        <ITEM_TYPE>" . $rowAporte['item_sub'] . "</ITEM_TYPE>
                        <ITEM_TYPE_TO></ITEM_TYPE_TO>
                        <ITEM_NBR></ITEM_NBR>
                        <ITEM_AMT>" . $rowAporte['valorpecuniario'] . "</ITEM_AMT>
                        <ACCOUNT_TYPE_SF>" . $rowAporte['tipocuenta'] . "</ACCOUNT_TYPE_SF>
                        <ITEM_EFFECTIVE_DT>" . $item_effective_dt . "</ITEM_EFFECTIVE_DT>
                        <DUE_DT2>" . $fechaAporte . "</DUE_DT2>
                    </UBI_ITEM_WRK>";
    //$parametros['TOTAL_BILL'] += $rowAporte['valorpecuniario'];
}

//aplica items de los descuentos vigentes
//La variable $_GET['modulo'] se asigna antes del metodo enviar_ordensap() en el respectivo modulo

/*
Si la solicitud de envio de orden de pago proviene de una orden manual no agregue el descuento

Si la solicitud proviene de volver a activar ordenes o reenviar ordenes a people, agregue el xml de descuentos
pero no los adicione como items en la base de datos.
*/

if (isset($_GET['modulo'])) {

    if ($_GET['modulo']=='reenvio_ordenes_ps' || $_GET['modulo']=='activar_ordenes') {
        $item_effective_dt = cambiaf_a_people($parametros['INVOICE_DT']);
        $xmlDescuento = $descuento->xmlDescuento($item_effective_dt);
        $xml_det .= $xmlDescuento;  
    }
       
}else{
    $descuento->descuentoMatricula();
    $item_effective_dt = cambiaf_a_people($parametros['INVOICE_DT']);
    $xmlDescuento = $descuento->xmlDescuento($item_effective_dt);
    $xml_det .= $xmlDescuento;    
    $parametros['TOTAL_BILL'] = $descuento->modificarTotalBill($parametros['TOTAL_BILL']);
}


$xml = "	<m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
		<UBI_OPERACION_ORD>" . $parametros['UBI_OPERACION_ORD'] . "</UBI_OPERACION_ORD>
		<NATIONAL_ID_TYPE>" . $parametros['NATIONAL_ID_TYPE'] . "</NATIONAL_ID_TYPE>
		<NATIONAL_ID>" . $parametros['NATIONAL_ID'] . "</NATIONAL_ID>
		<NATIONAL_ID_TYPE_OLD>" . $parametros['NATIONAL_ID_TYPE_OLD'] . "</NATIONAL_ID_TYPE_OLD>
		<NATIONAL_ID_OLD>" . $parametros['NATIONAL_ID_OLD'] . "</NATIONAL_ID_OLD>
		<FIRST_NAME>" . utf8_encode($parametros['FIRST_NAME']) . "</FIRST_NAME>
		<MIDDLE_NAME>" . utf8_encode($parametros['MIDDLE_NAME']) . "</MIDDLE_NAME>
		<LAST_NAME>" . utf8_encode($parametros['LAST_NAME']) . "</LAST_NAME>
		<SECOND_LAST_NAME>" . utf8_encode($parametros['SECOND_LAST_NAME']) . "</SECOND_LAST_NAME>
		<BIRTHDATE>" . cambiaf_a_people($parametros['BIRTHDATE']) . "</BIRTHDATE>
		<BIRTHCOUNTRY>" . $parametros['BIRTHCOUNTRY'] . "</BIRTHCOUNTRY>
		<BIRTHSTATE>" . $parametros['BIRTHSTATE'] . "</BIRTHSTATE>
		<BIRTHPLACE>" . $parametros['BIRTHPLACE'] . "</BIRTHPLACE>
		<SEX>" . $parametros['SEX'] . "</SEX>
		<MAR_STATUS>" . $parametros['MAR_STATUS'] . "</MAR_STATUS>
		<ADDRESS1>" . utf8_encode($parametros['ADDRESS1']) . "</ADDRESS1>
		<PHONE>" . $parametros['PHONE'] . "</PHONE>
		<EMAIL_ADDR>" . utf8_encode($parametros['EMAIL_ADDR']) . "</EMAIL_ADDR>
		<BUSINESS_UNIT>" . $parametros['BUSINESS_UNIT'] . "</BUSINESS_UNIT>
		<INVOICE_ID>" . $parametros['INVOICE_ID'] . "</INVOICE_ID>
		<INVOICE_DT>" . cambiaf_a_people($parametros['INVOICE_DT']) . "</INVOICE_DT>
		<DUE_DT1>" . cambiaf_a_people($parametros['DUE_DT']) . "</DUE_DT1>
		<TOTAL_BILL>" . $parametros['TOTAL_BILL'] . "</TOTAL_BILL>
		<STRM>" . $parametros['STRM'] . "</STRM>
		<UBI_ESTADO>I</UBI_ESTADO>
		<UBI_ITEMS_WRK>
			" . $xml_det . "
		</UBI_ITEMS_WRK>
	</m:messageRequest>";

// Envio de parametros con arreglo
//$result = $client->call('PS_UBI_SALA_ORDPAG',array($parametros));
// Envio de parametros por xml

if ($servicioPS) {

    $hayResultado = false;
    for ($i = 0; $i <= 5 && !$hayResultado; $i++) {
        // Envio de parametros por xml
        $start = time();
        $result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV', $xml);
        $soapError = $client->getError();
        $time = time() - $start;
        $envio = 1;
        if ($time >= 40 || $result === false) {
            $envio = 0;
            if ($i >= 5) {
                reportarCaida(1, 'Creacion Orden Pago');
                $result['ERRNUM'] = 0;
            }
        } else {
            $hayResultado = true;
        }
        sleep(3); // this should halt for 3 seconds for every loop
    }
} else {
    //para que si la cree en SALA de todas formas
    $result['ERRNUM'] = 0;
}
$query = "INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,respuestalogtraceintegracionps,documentologtraceintegracionps,estadoenvio) VALUES ('Creacion Orden Pago','" . $xml . "','id:" . $result['ERRNUM'] . " descripcion: " . $result['DESCRLONG'] . "'," . $datos['numeroordenpago'] . "," . $envio . ")";
$orden = mysql_query($query, $sala) or die("$query" . mysql_error());
