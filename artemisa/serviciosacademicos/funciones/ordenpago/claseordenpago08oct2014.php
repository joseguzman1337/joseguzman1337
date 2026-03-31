<?php


require_once($ruta . "funciontiempo.php");
require_once($ruta . "funcionip.php");
require_once($ruta . "zfica_sala_crea_aspirante.php");
require_once($ruta . "zfica_crea_estudiante.php");
require_once($ruta . "actualizarmatriculados.php");
 // require('tomar_saldofavorcontra.php');

/* * *********************************************************************************************************************** */
/* * ************************************************* */

//													//
//			CLASE ORDENPAGO							//
//													//
/* * ************************************************* */
/* * *********************************************************************************************************************** */

class Ordenpago {

    var $sala;
    var $numeroordenpago;
    var $codigoestudiante;
    var $fechaordenpago;
    var $idprematricula;
    var $fechaentregaordenpago;
    var $codigoperiodo;
    var $codigoestadoordenpago;
    var $codigoimprimeordenpago;
    var $observacionordenpago;
    var $codigocopiaordenpago;
    var $documentosapordenpago;
    var $idsubperiodo;
    var $idsubperiododestino;
    var $documentocuentaxcobrarsap;
    var $documentocuentacompensacionsap;
    var $fechapagosapordenpago;
    var $conexionsap;
    var $tipodocumento;
    var $numerodocumento;
    var $itemnbrps;

    // Por defecto la orden se crea con el idprematricula  en 1, por pagar, sin solicitud de credito ($codigoimprimeordenpago='01'), y original
    function Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago=0, $idprematricula=1, $fechaentregaordenpago=0, $codigoestadoordenpago=10, $codigoimprimeordenpago='01', $observacionordenpago='', $codigocopiaordenpago=100, $documentosapordenpago='', $idsubperiodo=1, $documentocuentaxcobrarsap='', $documentocuentacompensacionsap='', $fechapagosapordenpago='') {
	// EN CASO DE NO EXISTIR LA VARIABLE POR SESSION (ES DECIR PROVIENE DIRECTAMENTE DESDE LA PAGINA), SE LE ASIGNA LA RUTA DEL PATH.
	$_SESSION['path_live']=($_SESSION['path_live'])?$_SESSION['path_live']:'/usr/local/apache2/htdocs/html/serviciosacademicos/';
        $this->sala = $sala;
        $this->codigoestudiante = $codigoestudiante;
        $this->numeroordenpago = $numeroordenpago;

        // Si existe la orden de pago toma los valores de la base de datos
        $query_selnumeroordenpago = "SELECT * FROM ordenpago where numeroordenpago = '$this->numeroordenpago'";
        $selnumeroordenpago = mysql_query($query_selnumeroordenpago, $this->sala) or die("$query_selnumeroordenpago<br>" . mysql_error());
        $totalRows_selnumeroordenpago = mysql_num_rows($selnumeroordenpago);
        if ($totalRows_selnumeroordenpago != "") {
            $row_selnumeroordenpago = mysql_fetch_array($selnumeroordenpago);
            $this->fechaordenpago = $row_selnumeroordenpago['fechaordenpago'];
            $this->idprematricula = $row_selnumeroordenpago['idprematricula'];
            $this->fechaentregaordenpago = $row_selnumeroordenpago['fechaentregaordenpago'];
            $this->codigoperiodo = $row_selnumeroordenpago['codigoperiodo'];
            $this->codigoestadoordenpago = $row_selnumeroordenpago['codigoestadoordenpago'];
            $this->codigoimprimeordenpago = $row_selnumeroordenpago['codigoimprimeordenpago'];
            $this->observacionordenpago = $row_selnumeroordenpago['observacionordenpago'];
            $this->codigocopiaordenpago = $row_selnumeroordenpago['codigocopiaordenpago'];
            $this->documentosapordenpago = $row_selnumeroordenpago['documentosapordenpago'];
            $this->idsubperiodo = $row_selnumeroordenpago['idsubperiodo'];
            $this->idsubperiododestino = $row_selnumeroordenpago['idsubperiododestino'];
            $this->documentocuentaxcobrarsap = $row_selnumeroordenpago['documentocuentaxcobrarsap'];
            $this->documentocuentacompensacionsap = $row_selnumeroordenpago['documentocuentacompensacionsap'];
            $this->fechapagosapordenpago = $row_selnumeroordenpago['fechapagosapordenpago'];
            //$this->conexionsap = $this->conexion_sap();
        } else {
            $this->numeroordenpago = $this->nuevaorden();
            $this->sala = $sala;
            $this->codigoestudiante = $codigoestudiante;
            $this->fechaordenpago = date("Y-m-d", time());
            $this->idprematricula = $idprematricula;
            $this->fechaentregaordenpago = $fechaentregaordenpago;
            $this->codigoperiodo = $codigoperiodo;
            $this->codigoestadoordenpago = $codigoestadoordenpago;
            $this->codigoimprimeordenpago = $codigoimprimeordenpago;
            $this->observacionordenpago = $observacionordenpago;
            $this->codigocopiaordenpago = $codigocopiaordenpago;
            $this->documentosapordenpago = $documentosapordenpago;
            $this->idsubperiodo = $this->tomarbd_subperiodo();
            $this->idsubperiododestino = $this->idsubperiodo;
            $this->documentocuentaxcobrarsap = $documentocuentaxcobrarsap;
            $this->documentocuentacompensacionsap = $documentocuentacompensacionsap;
            $this->fechapagosapordenpago = $fechapagosapordenpago;
            //$this->conexionsap = $this->conexion_sap();
        }
    }

    function obtenerdetalleordenpago() {
        $query_tipoconcepto = "SELECT *
            from detalleordenpago
            where numeroordenpago = '" . $this->numeroordenpago . "'";
        $tipoconcepto = mysql_query($query_tipoconcepto, $this->sala) or die("$query_tipoconcepto<br>" . mysql_error());
        while ($row_tipoconcepto = mysql_fetch_assoc($tipoconcepto)) {
            $arrayretorno[] = $row_tipoconcepto;
        }

        return $arrayretorno;
    }

    function espensioncolegio() {
        $arraydetalleorden = $this->obtenerdetalleordenpago();
        $arrayconceptospension = array("159", "C9076", "C9077","C9083","C9094","C9095","C9096","C9097");
        if (is_array($arraydetalleorden)) {
            foreach ($arraydetalleorden as $i => $rowordenpago) {
                if (in_array($arraydetalleorden[$i]["codigoconcepto"], $arrayconceptospension)) {
                    return 1;
                }
            }
        }
        return 0;
    }

    /*function conexion_sap() {
        if ($this->necesita_conexionsap($row_estadoconexionexterna)) {
            $login = array(// Set login data to R/3
                "ASHOST" => $row_estadoconexionexterna['hostestadoconexionexterna'], // application server host name
                "SYSNR" => $row_estadoconexionexterna['numerosistemaestadoconexionexterna'], // system number
                "CLIENT" => $row_estadoconexionexterna['mandanteestadoconexionexterna'], // client
                "USER" => $row_estadoconexionexterna['usuarioestadoconexionexterna'], // user
                "PASSWD" => $row_estadoconexionexterna['passwordestadoconexionexterna'], // password
                "CODEPAGE" => "1100");               // codepage

            $rfc = saprfc_open($login);
            if (!$rfc) {
?>
                <script language="javascript">
                    alert("Fallo la conexión a sap");
                </script>
<?php
                //echo "RFC connection failed with error:".saprfc_error();
                return false;
            } else {
                return $rfc;
            }
        }
        return false;
    }*/

    // Trae el número de la orden que seria creado si se fuera a crear una orden
    function nuevaorden() {
        $query_selmaxnumeroordenpago = "SELECT max(numeroordenpago) as mayor FROM ordenpago";
        $selmaxnumeroordenpago = mysql_query($query_selmaxnumeroordenpago, $this->sala) or die("$query_selmaxnumeroordenpago<br>" . mysql_error());
        $row_selmaxnumeroordenpago = mysql_fetch_array($selmaxnumeroordenpago);
        $orden = $row_selmaxnumeroordenpago['mayor'] + 1;
        return $row_selmaxnumeroordenpago['mayor'] + 1;
    }

    function esCarreraActiva() {
        $query_sel = "select c.codigocarrera
        from carrera c, estudiante e
        where c.codigocarrera = e.codigocarrera
        and e.codigoestudiante = '$this->codigoestudiante'
        and now() between c.fechainiciocarrera and c.fechavencimientocarrera";
        $sel = mysql_query($query_sel, $this->sala) or die("$query_sel<br>" . mysql_error());
        $totalRows_sel = mysql_num_rows($sel);
        if ($totalRows_sel > 0)
            return true;
        return false;
    }

    /*     * *********************************************************************************************************************** */
    /*     * ************************************************* */

//													//
//	FUNCIONES DE ENVIO SAP							//
//													//
    /*     * ************************************************* */
    /*     * *********************************************************************************************************************** */

    // Aplica para todas menos para inscripcion y formulario
    function enviarsap_orden($idgrupo = 0) {
        //echo "<h1>$this->numeroordenpago</h1>";
      $query_selmaxnumeroordenpago = "SELECT do.codigoconcepto
		FROM detalleordenpago do,concepto c
		WHERE c.codigoconcepto = do.codigoconcepto
		AND do.numeroordenpago = '" . $this->numeroordenpago . "'
		AND c.cuentaoperacionprincipal = '153' ";
 /* $query_selmaxnumeroordenpago = "SELECT d.codigoconcepto
		FROM ordenpago o,detalleordenpago d
		WHERE o.numeroordenpago = d.numeroordenpago
		AND d.numeroordenpago =  '" . $this->numeroordenpago . "'";*/

        $selmaxnumeroordenpago = mysql_query($query_selmaxnumeroordenpago, $this->sala) or die("$query_selmaxnumeroordenpago<br>" . mysql_error());
        $row_selmaxnumeroordenpago = mysql_fetch_array($selmaxnumeroordenpago);
        //exit();
        if ($row_selmaxnumeroordenpago <> "") {
            $resultado = genera_prodiverso($this->sala, $this->numeroordenpago);
        } else {
            $resultado = crea_estudiante($this->sala, $this->numeroordenpago, $idgrupo); //$numeroordenpago = '1019832';
        }
	//print_r($resultado);
	if($resultado['ERRNUM']!=0 || $resultado['ERRNUM']=='') {
		echo "<script>alert('La orden número '+".$this->numeroordenpago."+' no pudo ser creada. Por favor tome nota de este número y contáctese con la universidad para recibir ayuda en este proceso. Gracias.')</script>";
		$this->anular_ordenpago();
		exit();

	}
        /* if($resultado <> 0)
          {
          //echo "error";
          }
          else
          {
          //echo "OK";
          } */
        //echo "<br>RESULTADO: ".$resultado;
        //saprfc_close($this->conexionsap);
        //exit();
    }

    /*     * *********************************************************************************************************************** */
    /*     * ************************************************* */

//													//
//	FUNCIONES DE CREACION COMPLETA DE ORDENES		//
//													//
    /*     * ************************************************* */
    /*     * *********************************************************************************************************************** */


    // Crea una orden de pago por cada uno de los conceptos que se le pasen
    function crear_ordenpago_porconcepto($codigoconcepto, $cantidaddetalleordenpago, $valorconcepto, $codigotipodetalle, $fechadetallefechafinanciera, $porcentajedetallefechafinanciera, $totalconrecargo) {

        $this->insertarordenpago();

        $this->insertardetalleordenpago($codigoconcepto, $cantidaddetalleordenpago, $valorconcepto, $codigotipodetalle);
        $this->insertarfechaordenpago($fechadetallefechafinanciera, $porcentajedetallefechafinanciera, $totalconrecargo);
        $this->insertarbancosordenpago();
    }

    // Crea una orden de pago con conceptos en un arreglo y los valores un arrreglo
    function crear_ordenpago_estadodecuenta($conceptocuota,$valorconcepto,$valortotalcuota,$fechalimite,$itemnbrps,$numeroordenpago,$porcentajedetallefechafinanciera=0, $totalconrecargo=0){
           
     
         $this->insertarordenpago();

    
    foreach ($conceptocuota as $key => $value) {
		
            $query_tipoconcepto = "SELECT codigotipodetalleordenpago
            from detalleordenpago
            where codigoconcepto = '$value'
            and numeroordenpago = '$numeroordenpago'";
            $tipoconcepto = mysql_query($query_tipoconcepto, $this->sala) or die("$query_tipoconcepto<br>" . mysql_error());
            $row_tipoconcepto = mysql_fetch_array($tipoconcepto);
          }
           
            if ($row_tipoconcepto == "") {
                $codigotipodetalle = 2;
            } else {
                $codigotipodetalle = 3;
            }

           

    
      
 

for ($i=0;$i<count($conceptocuota);$i++ ) {
	
   $this->insertardetalleordenpago($conceptocuota[$i], 1, $valorconcepto[$i], $codigotipodetalle);
  
   $this->insertarplandepagos($itemnbrps[$i], $conceptocuota[$i], $numeroordenpago);
  
}
     
        $this->insertarfechaordenpago($fechalimite, $porcentajedetallefechafinanciera, $valortotalcuota);
        $this->insertarbancosordenpago();
       $this->itemnbrps=$itemnbrps;
        $this->enviarsap_orden();
    }

 function crear_ordenpago_estadodecuentadetalles($valorconcepto, $fechadetallefechafinanciera, $numerodocumentoplandepagosap, $cuentaxcobrarplandepagosap, $numerorodenpagoplandepagosap, $porcentajedetallefechafinanciera=0, $totalconrecargo=0) {
        $this->insertarordenpago();
       

 foreach ($valorconcepto as $key => $value) {
            $query_tipoconcepto = "SELECT codigotipodetalleordenpago
            from detalleordenpago
            where codigoconcepto = '$key'
            and numeroordenpago = '$numerorodenpagoplandepagosap'";
            $tipoconcepto = mysql_query($query_tipoconcepto, $this->sala) or die("$query_tipoconcepto<br>" . mysql_error());
            $row_tipoconcepto = mysql_fetch_array($tipoconcepto);
            if ($row_tipoconcepto == "") {
                $codigotipodetalle = 2;
            } else {
                $codigotipodetalle = 3;
            }

            $this->insertardetalleordenpago($key, 1, $value, $codigotipodetalle);
            $totalconrecargo = $totalconrecargo + $value;

        }
        $this->insertarfechaordenpago($fechadetallefechafinanciera, $porcentajedetallefechafinanciera, $totalconrecargo);
        $this->insertarbancosordenpago();
        $this->insertarplandepagos($numerodocumentoplandepagosap, $cuentaxcobrarplandepagosap, $numerorodenpagoplandepagosap);
        $this->enviarsap_orden();
    }

    /* 	// Crea una orden de pago con matricula para cursos libres
      function crear_ordenpagoautomatica()
      {
      // 1. Crea la orden
      $this->insertarordenpago();
      // 2. Crea el detalle de la orden de pago
      $this->insertardetalleordenpago_cohortepecuniarios();


      // Tipo de orden indica el tipo de orden que va a ser generada para los cursos libres
      // Si va a ser por matricula con materias o sin materias
      if($tipoorden == "coninscripcion")
      {
      // Si la orden lleva inscripción la orden debe ser generada con inscripción en el grupo
      // esto ocurre si el curso libre tiene una solo grupo activo


      }
      else
      {

      }
      foreach($valorconcepto as $key => $value)
      {
      $query_tipoconcepto="SELECT codigotipodetalleordenpago
      from detalleordenpago
      where codigoconcepto = '$key'
      and numeroordenpago = '$numerorodenpagoplandepagosap'";
      $tipoconcepto=mysql_query($query_tipoconcepto,$this->sala) or die("$query_tipoconcepto<br>".mysql_error());
      $row_tipoconcepto=mysql_fetch_array($tipoconcepto);
      if($row_tipoconcepto == "")
      {
      $codigotipodetalle = 2;
      }
      else
      {
      $codigotipodetalle = 3;
      }
      $this->insertardetalleordenpago($key, 1, $value, $codigotipodetalle);
      $totalconrecargo = $totalconrecargo + $value;
      }
      $this->insertarfechaordenpago($fechadetallefechafinanciera, $porcentajedetallefechafinanciera, $totalconrecargo);
      $this->insertarbancosordenpago();
      $this->insertarplandepagos($numerodocumentoplandepagosap, $cuentaxcobrarplandepagosap, $numerorodenpagoplandepagosap);
      $this->enviarsap_orden();
      }
     */


    function poner_idprematricula($idprematricula=1) {
        $this->idprematricula = $idprematricula;
    }

    function poner_codigoestadoordenpago($codigoestadoordenpago=10) {
        $this->idprematricula = $idprematricula;
    }

    /*     * *********************************************************************************************************************** */
    /*     * ************************************************* */

//													//
//			FUNCIONES DE TOMA DE DATOS				//
//													//
    /*     * ************************************************* */
    /*     * *********************************************************************************************************************** */

    function tomar_carrerabd() {
        $query_carrera = "select codigocarrera
		from estudiante
		where codigoestudiante = '$this->codigoestudiante'";
        //echo "<br><br>SUBPERIODO".$query_selsubperiodo."<br><br>";
        $carrera = mysql_query($query_carrera, $this->sala) or die("$query_carrera<br>" . mysql_error());
        $row_carrera = mysql_fetch_array($carrera);
        return $row_carrera['codigocarrera'];
    }

    function tomarbd_subperiodo() {
        $query_selsubperiodo = "select s.idsubperiodo, s.codigoestadosubperiodo
		from subperiodo s, carreraperiodo cp, periodo p, estudiante e
		where p.codigoperiodo = '$this->codigoperiodo'
		and p.codigoperiodo = cp.codigoperiodo
		and cp.idcarreraperiodo = s.idcarreraperiodo
		AND cp.codigocarrera = e.codigocarrera
		and e.codigoestudiante = '$this->codigoestudiante'
		and s.codigoestadosubperiodo not like '2%'
		order by 2 desc";
        //echo "<br><br>SUBPERIODO".$query_selsubperiodo."<br><br>";
        $selsubperiodo = mysql_query($query_selsubperiodo, $this->sala) or die("$query_selsubperiodo<br>" . mysql_error());
        $row_selsubperiodo = mysql_fetch_array($selsubperiodo);
        return $row_selsubperiodo['idsubperiodo'];
    }

    //devuelve subperio con respecto a la fecha
    function tomarbd_subperiodo_fecha($fecha) {
       // echo "<h1>ENTRO?=$fecha</h1>";
        $query_selsubperiodo = "select s.idsubperiodo, s.codigoestadosubperiodo
		from subperiodo s, carreraperiodo cp, periodo p, estudiante e
		where p.codigoperiodo = '$this->codigoperiodo'
		and p.codigoperiodo = cp.codigoperiodo
		and cp.idcarreraperiodo = s.idcarreraperiodo
		AND cp.codigocarrera = e.codigocarrera
		and e.codigoestudiante = '$this->codigoestudiante'
		and '$fecha' between fechainiciofinancierosubperiodo and
		fechafinalfinancierosubperiodo
		order by 2 desc";
        //echo "<br><br>SUBPERIODO".$query_selsubperiodo."<br><br>";
        $selsubperiodo = mysql_query($query_selsubperiodo, $this->sala) or die("$query_selsubperiodo<br>" . mysql_error());
        $row_selsubperiodo = mysql_fetch_array($selsubperiodo);
        return $row_selsubperiodo['idsubperiodo'];
    }

    // Devuelve el numero de documento del estudiante
    function numerodocumento_ordenpago() {
        $query_documentoestudiante = "select eg.numerodocumento,td.nombrecortodocumento
		from estudiantegeneral eg, estudiante e, documento td
		where e.codigoestudiante = '$this->codigoestudiante'
		and e.idestudiantegeneral = eg.idestudiantegeneral
                and td.tipodocumento=eg.tipodocumento";
        //echo "<br><br>SUBPERIODO".$query_selsubperiodo."<br><br>";
        $documentoestudiante = mysql_query($query_documentoestudiante, $this->sala) or die("$query_documentoestudiante<br>" . mysql_error());
        $row_documentoestudiante = mysql_fetch_array($documentoestudiante);
        $this->tipodocumento = $row_documentoestudiante['nombrecortodocumento'];
        $this->numerodocumento = $row_documentoestudiante['numerodocumento'];
        return $row_documentoestudiante['numerodocumento'];
    }

    // Retorna el numeroordepago del objeto
    function tomar_numeroordenpago() {
        return $this->numeroordenpago;
    }

    // Retorna el numeroordepago del objeto
    function tomar_codigoperiodo() {
        return $this->codigoperiodo;
    }

    // Retorna el idsubperiodo
    function tomar_idsubperiodo() {
        return $this->idsubperiodo;
    }

    function tomar_codigoestadoordenpago() {
        return $this->codigoestadoordenpago;
    }

    // Retorna la fecha de creación de la orden de pago
    function tomar_fechaordenpago() {
        return $this->fechaordenpago;
    }

    function tomar_saldocontra() {
		$path = getcwd();
		$index = stripos($path, "serviciosacademicos");
		$pathFinal = substr($path,0,$index+20);
	
    require($pathFinal.'consulta/estadocredito/tomar_saldofavorcontra.php');
    
           if ($retorno == 8) {
            return $retorno;
        }
       
    
       /*echo "SAl<pre>";
       print_r($saldoencontra);
       echo"</pre>";*/
        return $saldoencontra;
  
    }
    
    
       

    function tomar_saldofavor() {
		$path = getcwd();
		$index = stripos($path, "serviciosacademicos");
		$pathFinal = substr($path,0,$index+20);
    	require($pathFinal.'consulta/estadocredito/tomar_saldofavorcontra.php');
        return $saldoafavor;
    }


    // Funcion que retorna la fecha de la orden de pago de acuerdo a los conceptos que se le pasan
    function tomar_fechaconceptosbd($conceptos) {
        $cadena = "";
        foreach ($conceptos as $key => $value) {
            //echo "$key => $value <br>";
            $cadena = "$cadena f.codigoconcepto = '$value' or";
        }
        $cadena = ereg_replace("or$", "", $cadena);
        $query_fechasconceptos = "select f.nombrefechacarreraconcepto, f.fechavencimientofechacarreraconcepto, f.codigotipofechacarreraconcepto, f.numerodiasvencimientofechacarreraconcepto
		from fechacarreraconcepto f, estudiante e
		where f.codigocarrera = e.codigocarrera
		and e.codigoestudiante = '$this->codigoestudiante'
		and f.fechavencimientofechacarreraconcepto >= '" . date("Y-m-d") . "'
		and ($cadena)
		order by 2 desc";
		//exit();
        $fechasconceptos = mysql_query($query_fechasconceptos, $this->sala) or die("$query_fechasconceptos<br>" . mysql_error());
        //echo $query_fechasconceptos."<br>";
        $totalRows_fechasconceptos = mysql_num_rows($fechasconceptos);
        $fechaanterior = "00-00-00";
        if ($totalRows_fechasconceptos != "") {
            while ($row_fechasconceptos = mysql_fetch_array($fechasconceptos)) {
                // Se analiza la fecha de cada concepto y de acuerdo al tipo de fecha se escoge la mayor fecha
                if (ereg("^1.+$", $row_fechasconceptos['codigotipofechacarreraconcepto'])) {
                    // Comparar la fecha nueva con la fecha anterior, si la nueva es mayor que la anterior tomar la nueva
                    $fechanueva = $row_fechasconceptos['fechavencimientofechacarreraconcepto'];
                }
                if (ereg("^2.+$", $row_fechasconceptos['codigotipofechacarreraconcepto'])) {
                    // Calcula la fecha de calendario de acuerdo a la fecha del concepto de acuerdo a los día habiles
                    $fechanueva = calcularfechafutura($row_fechasconceptos['numerodiasvencimientofechacarreraconcepto'], $this->sala);
                }
                if (restarfecha($fechaanterior, $fechanueva) < 0) {
                    $fechaanterior = $fechanueva;
                }
                //echo $fechanueva." - ".$fechaanterior,"<br>";
                //$this->insertarfechaordenpago($fechadetallefechafinanciera, $porcentajedetallefechafinanciera, $totalconrecargo);
            }
        }
        return $fechaanterior;
    }

    // Mira si al orden de pago esta vencida, si esta vencida retorna true, si no retorna la fecha de vencimiento mas cercana con su pago
    function ordenvigente() {
        $query_ordenesporpagar = "select f.fechaordenpago, f.valorfechaordenpago
		from fechaordenpago f
		where f.numeroordenpago = '$this->numeroordenpago'
		and f.fechaordenpago >= '" . date('Y-m-d') . "'
		order by 1";
        //and dop.codigoconcepto = '151'
        //echo "$query_ordenesporpagar<br>";
        $ordenesporpagar = mysql_query($query_ordenesporpagar, $this->sala) or die("$query_ordenesporpagar<br>" . mysql_error());
        $totalRows_ordenesporpagar = mysql_num_rows($ordenesporpagar);

        if ($totalRows_ordenesporpagar != "") {
            $row_ordenesporpagar = mysql_fetch_array($ordenesporpagar);
            return $row_ordenesporpagar;
        }
        //echo "entro<br>";
        return false;
    }

    /*     * *********************************************************************************************************************** */
    /*     * ************************************************* */

//													//
//			FUNCIONES DE INSERCIÓN					//
//													//
    /*     * ************************************************* */
    /*     * *********************************************************************************************************************** */

    // Inserta una orden de pago con los datos del objeto
    function insertarordenpago() {
        if ($this->esCarreraActiva()) {

            // Para insertar la orden de pago tiene que buscar el subperiodo para la inserción de la orden
      $query_insordenpago = "INSERT INTO ordenpago(numeroordenpago, codigoestudiante, fechaordenpago, idprematricula, fechaentregaordenpago, codigoperiodo, codigoestadoordenpago, codigoimprimeordenpago, observacionordenpago, codigocopiaordenpago, documentosapordenpago, idsubperiodo, idsubperiododestino, documentocuentaxcobrarsap, documentocuentacompensacionsap, fechapagosapordenpago)
		    VALUES('$this->numeroordenpago','$this->codigoestudiante','$this->fechaordenpago','$this->idprematricula','$this->fechaentregaordenpago','$this->codigoperiodo','$this->codigoestadoordenpago','$this->codigoimprimeordenpago','$this->observacionordenpago','$this->codigocopiaordenpago','$this->documentosapordenpago', '$this->idsubperiodo', '$this->idsubperiododestino', '$this->documentocuentaxcobrarsap', '$this->documentocuentacompensacionsap', '$this->fechapagosapordenpago')";
                       $query_insordenpago = mysql_query($query_insordenpago, $this->sala) or die("$query_insordenpago <br>" . mysql_error());

            // Cada vez que se inserte una orden de pago guardar en logordenpago si existe sesión de usuario
            if (isset($_SESSION['MM_Username'])) {

                $query_id = "select idusuario
			from usuario
			where usuario = '" . $_SESSION['MM_Username'] . "'";
                $id = mysql_query($query_id, $this->sala) or die("$query_id <br>" . mysql_error());
                $row_id = mysql_fetch_array($id);

                $idusuario = $row_id['idusuario'];

            $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
			VALUES(0, now(), '', '$this->numeroordenpago', '$idusuario', '" . tomarip() . "')";
                //echo "<br>uno".$query_inslogordenpago;
                $query_inslogordenpago = mysql_query($query_inslogordenpago, $this->sala) or die("$query_inslogordenpago <br>" . mysql_error());

            } else {

              $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
			VALUES(0, now(), '', '$this->numeroordenpago', '2', '" . tomarip() . "')";
                //echo "<br>uno".$query_inslogordenpago;
                $query_inslogordenpago = mysql_query($query_inslogordenpago, $this->sala) or die("$query_inslogordenpago <br>" . mysql_error());
            }
        } else {
?>
            <script type="text/javascript">
                alert("Para poder generar órdenes de pago la carrera debe estar activa");
                history.go(-1);
            </script>
<?php
            exit();
        }
    }

    // Inserta la prematricula de una orden de pago de matricula
    function insertarprematricula($codigoestadoprematricula) {
        // Primero se mira si el estudiante tien prematricula
        // si tiene no se inserta
        $query_prematricula = "SELECT idprematricula
		FROM prematricula
		WHERE  codigoperiodo = '$this->codigoperiodo'
		and codigoestudiante = '$this->codigoestudiante'";
        //echo "$query_bancos<br>";
        //and dop.codigoconcepto = '151'
        $prematricula = mysql_query($query_prematricula, $this->sala) or die("$query_prematricula<br>" . mysql_error());
        $totalRows_prematricula = mysql_num_rows($prematricula);
        if ($totalRows_prematricula == "") {
            // Para insertar la orden de pago tiene que buscar el subperiodo para la inserción de la orden
            $query_insprematricula = "insert into prematricula(codigoestudiante,fechaprematricula,codigoperiodo,codigoestadoprematricula,observacionprematricula,semestreprematricula)
			VALUES('$this->codigoestudiante','" . date("Y-m-d", time()) . "','$this->codigoperiodo','$codigoestadoprematricula',' ','1')";
            //echo "<br>uno".$query_insordenpago;
            $query_insprematricula = mysql_query($query_insprematricula, $this->sala) or die("$query_insprematricula <br>" . mysql_error());
            $this->idprematricula = mysql_insert_id();
        } else {
            $row_prematricula = mysql_fetch_array($prematricula);
            $this->idprematricula = $row_prematricula['idprematricula'];
        }
    }

    function insertarplandepagos($numerodocumentoplandepagosap, $cuentaxcobrarplandepagosap, $numerorodenpagoplandepagosap) {
        //$query_insplandepagos = "INSERT INTO ordenpagoplandepago(idordenpagoplandepago, fechaordenpagoplandepago, numerodocumentoplandepagosap, cuentaxcobrarplandepagosap, numerorodenpagoplandepagosap, numerorodencoutaplandepagosap, codigoestado)
        //VALUES(0, '".date("Y-m-d")."', '$numerodocumentoplandepagosap', '$cuentaxcobrarplandepagosap', '$numerorodenpagoplandepagosap', '$this->numeroordenpago', '100')";
  $query_insplandepagos = "INSERT INTO ordenpagoplandepago(idordenpagoplandepago, fechaordenpagoplandepago, numerodocumentoplandepagosap, cuentaxcobrarplandepagosap, numerorodenpagoplandepagosap, numerorodencoutaplandepagosap, codigoestado, codigoindicadorprocesosap)
    	VALUES(0, '" . date("Y-m-d") . "', '$numerodocumentoplandepagosap', '$cuentaxcobrarplandepagosap', '$numerorodenpagoplandepagosap', '$this->numeroordenpago', '100', '100')";
        $insplandepagos = mysql_query($query_insplandepagos, $this->sala) or die("$query_insplandepagos<br>" . mysql_error());
//exit();
    }

    // Inserta los detalles de una orden de pago
    function insertardetalleordenpago($codigoconcepto, $cantidaddetalleordenpago, $valorconcepto, $codigotipodetalle) {
    
 /*  echo"Concepto<pre>";
  print_r($codigoconcepto);
            echo "</pre>";
	  
	 echo"Concepto<pre>";
  print_r($valorconcepto);
            echo "</pre>";*/	
    
    
if ($cantidaddetalleordenpago == 0) {

            $cantidaddetalleordenpago = 1;
        }

 $query_insdetalleordenpago = "insert into detalleordenpago(numeroordenpago,codigoconcepto,cantidaddetalleordenpago,valorconcepto,codigotipodetalleordenpago)
		VALUES('$this->numeroordenpago','$codigoconcepto','$cantidaddetalleordenpago','$valorconcepto','$codigotipodetalle')";
      //  echo "$query_insdetalleordenpago<br>";
   
        $insdetalleordenpago = mysql_query($query_insdetalleordenpago, $this->sala) or die("$query_insdetalleordenpago<br>" . mysql_error());
    }

    // Modifica los detalles de una orden de pago
    function modificardetalleordenpago($codigoconcepto, $cantidaddetalleordenpago, $valorconcepto, $codigotipodetalle) {
        if ($cantidaddetalleordenpago == 0) {
            $cantidaddetalleordenpago = 1;
        }
        $query_upddetalleordenpago = "UPDATE detalleordenpago
		SET cantidaddetalleordenpago='$cantidaddetalleordenpago', valorconcepto='$valorconcepto', codigotipodetalleordenpago='$codigotipodetalle'
		WHERE codigoconcepto = '$codigoconcepto'
		and numeroordenpago = '$this->numeroordenpago'";
        $upddetalleordenpago = mysql_query($query_upddetalleordenpago, $this->sala) or die("$query_upddetalleordenpago<br>" . mysql_error());
    }

    // Modifica los detalles de una orden de pago
    function eliminardetalleordenpago($codigoconcepto) {
        $query_deldetalleordenpago = "DELETE FROM detalleordenpago
		WHERE codigoconcepto = '$codigoconcepto'
		and numeroordenpago = '$this->numeroordenpago'";
        $deldetalleordenpago = mysql_query($query_deldetalleordenpago, $this->sala) or die("$query_deldetalleordenpago<br>" . mysql_error());
    }

    // Inserta las fechas de una orden de pago
    function insertarfechaordenpago($fechadetallefechafinanciera, $porcentajedetallefechafinanciera=0, $totalconrecargo) {
   $query_insfechaordenpago = "insert into fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)
		VALUES('$this->numeroordenpago','$fechadetallefechafinanciera','$porcentajedetallefechafinanciera','$totalconrecargo')";
        $insfechaordenpago = mysql_query($query_insfechaordenpago, $this->sala) or die("$query_insfechaordenpago<br>" . mysql_error());

    }

    // Edita las fechas de una orden de pago
    function modificarfechaordenpago($fechaini, $valorini, $fechadetallefechafinanciera, $totalconrecargo) {
        $query_updfechaordenpago = "UPDATE fechaordenpago
    	SET fechaordenpago='$fechadetallefechafinanciera', valorfechaordenpago='$totalconrecargo'
    	WHERE fechaordenpago = '$fechaini'
		and valorfechaordenpago = '$valorini'
		and numeroordenpago = '$this->numeroordenpago'";
        $updfechaordenpago = mysql_query($query_updfechaordenpago, $this->sala) or die("$query_updfechaordenpago<br>" . mysql_error());
    }

    // Elimina las fechas de una orden de pago
    function eliminarfechaordenpago($fechaini, $valorini) {
        $query_delfechaordenpago = "DELETE FROM fechaordenpago
		WHERE fechaordenpago = '$fechaini'
		and valorfechaordenpago = '$valorini'
		and numeroordenpago = '$this->numeroordenpago'";
        $delfechaordenpago = mysql_query($query_delfechaordenpago, $this->sala) or die("$query_delfechaordenpago<br>" . mysql_error());
    }

    // Inserta las fechas de una orden de pago de fechafinaciera
    function insertarfechafinaciera($valor, $codigoestadoconceptodetallefechafinanciera = "01") {
        $query_fecha = "SELECT  d.nombredetallefechafinanciera, d.fechadetallefechafinanciera, d.porcentajedetallefechafinanciera, d.codigoconceptodetallefechafinanciera
		FROM fechafinanciera f, detallefechafinanciera d
		WHERE f.codigocarrera = '" . $this->tomar_carrerabd() . "'
		AND f.idfechafinanciera = d.idfechafinanciera
		AND d.codigoconceptodetallefechafinanciera = '$codigoestadoconceptodetallefechafinanciera'
		AND f.codigoperiodo = '$this->codigoperiodo'
		and f.idsubperiodo = '$this->idsubperiodo'
		ORDER BY 3 ASC";
        $fecha = mysql_query($query_fecha, $this->sala) or die("$query_fecha");
        $totalRows_fecha = mysql_num_rows($fecha);
        if ($totalRows_fecha == "") {
            $query_fecha = "SELECT  d.nombredetallefechafinanciera, d.fechadetallefechafinanciera, d.porcentajedetallefechafinanciera, d.codigoconceptodetallefechafinanciera
			FROM fechafinanciera f, detallefechafinanciera d, conceptodetallefechafinanciera co
			WHERE f.codigocarrera = '" . $this->tomar_carrerabd() . "'
			AND f.idfechafinanciera = d.idfechafinanciera
			AND d.codigoconceptodetallefechafinanciera = co.codigoconceptodetallefechafinanciera
			AND co.codigoestadoconceptodetallefechafinanciera = '$codigoestadoconceptodetallefechafinanciera'
			AND f.codigoperiodo = '$this->codigoperiodo'
			ORDER BY 3 ASC";
            $fecha = mysql_query($query_fecha, $this->sala) or die("$query_fecha");
        }
        //echo "<br><br>Fecha $query_fecha";
        while ($row_fecha = mysql_fetch_array($fecha)) {
            $totalconrecargo = $valor + $valor * $row_fecha['porcentajedetallefechafinanciera'] / 100;
            $this->insertarfechaordenpago($row_fecha['fechadetallefechafinanciera'], $row_fecha['porcentajedetallefechafinanciera'], $totalconrecargo);
        }
        //exit();
    }

    // Inserta las fechas de una orden de pago de fechafinaciera calculando la matricula y los valorespecuniarios
    function insertarfechasordenpago_fechafianciera($valormatricula, $valorpecuniario, $codigoestadoconceptodetallefechafinanciera = "01") {
        $query_fecha = "SELECT  d.nombredetallefechafinanciera, d.fechadetallefechafinanciera, d.porcentajedetallefechafinanciera, d.codigoconceptodetallefechafinanciera
		FROM fechafinanciera f, detallefechafinanciera d
		WHERE f.codigocarrera = '" . $this->tomar_carrerabd() . "'
		AND f.idfechafinanciera = d.idfechafinanciera
		AND d.codigoconceptodetallefechafinanciera = '$codigoestadoconceptodetallefechafinanciera'
		AND f.codigoperiodo = '$this->codigoperiodo'
		and f.idsubperiodo = '$this->idsubperiodo'
		ORDER BY 3 ASC";
        $fecha = mysql_query($query_fecha, $this->sala) or die("$query_fecha");
        $totalRows_fecha = mysql_num_rows($fecha);
        if ($totalRows_fecha == "") {
            $query_fecha = "SELECT  d.nombredetallefechafinanciera, d.fechadetallefechafinanciera, d.porcentajedetallefechafinanciera, d.codigoconceptodetallefechafinanciera
			FROM fechafinanciera f, detallefechafinanciera d, conceptodetallefechafinanciera co
			WHERE f.codigocarrera = '" . $this->tomar_carrerabd() . "'
			AND f.idfechafinanciera = d.idfechafinanciera
			AND d.codigoconceptodetallefechafinanciera = co.codigoconceptodetallefechafinanciera
			AND co.codigoestadoconceptodetallefechafinanciera = '$codigoestadoconceptodetallefechafinanciera'
			AND f.codigoperiodo = '$this->codigoperiodo'
			ORDER BY 3 ASC";
            $fecha = mysql_query($query_fecha, $this->sala) or die("$query_fecha");
        }
        //echo "<br><br>Fecha $query_fecha";
        while ($row_fecha = mysql_fetch_array($fecha)) {
            $totalconrecargo = $valormatricula + $valormatricula * $row_fecha['porcentajedetallefechafinanciera'] / 100 + $valorpecuniario;
            $this->insertarfechaordenpago($row_fecha['fechadetallefechafinanciera'], $row_fecha['porcentajedetallefechafinanciera'], $totalconrecargo);
        }
        //exit();
    }

    // Insertas las cuentas de una orden de pago
    function insertarcuentabancoordenpago($idcuentabanco) {
        $query_insordenpago = "insert into cuentabancoordenpago(numeroordenpago,idcuentabanco)
		VALUES('$this->numeroordenpago','$idcuentabanco')";
        //echo "$query_insordenpago<br>";
        $insordenpago = mysql_query($query_insordenpago, $this->sala) or die("$query_insordenpago<br>" . mysql_error());
    }

    // Insertas todos los bancos en la orden de pago
    function insertarbancosordenpago() {
        $query_bancos = "SELECT c.idcuentabanco
		FROM cuentabanco c, banco b, estudiante e
		WHERE  c.codigobanco = b.codigobanco
		AND c.codigoperiodo = '$this->codigoperiodo'
		AND c.codigocarrera = e.codigocarrera
		and e.codigoestudiante = '$this->codigoestudiante'";
        //echo "$query_bancos<br>";
        //and dop.codigoconcepto = '151'
        $bancos = mysql_query($query_bancos, $this->sala) or die("$query_bancos<br>" . mysql_error());
        $totalRows_bancos = mysql_num_rows($bancos);
        if ($totalRows_bancos == "") {
            $query_bancos = "SELECT c.idcuentabanco
			FROM cuentabanco c, banco b
			WHERE  c.codigobanco = b.codigobanco
			AND c.codigoperiodo = '$this->codigoperiodo'
			AND codigocarrera = '1'";
            //echo "$query_bancos<br>";
            //and dop.codigoconcepto = '151'
            $bancos = mysql_query($query_bancos, $this->sala) or die("$query_bancos<br>" . mysql_error());
            $totalRows_bancos = mysql_num_rows($bancos);
        }
        if ($totalRows_bancos != "") {
            while ($row_bancos = mysql_fetch_array($bancos)) {
                $this->insertarcuentabancoordenpago($row_bancos['idcuentabanco']);
            }
        }
    }

    // Esta función inserta la matricula en la orden y retorna el valor de la matricula insertada
    function insertarconcepto_matricula_cohorte($porcentaje=100, $generarordensemestreactual = true) {
        $query_datocohorte = "select c.numerocohorte, c.codigoperiodoinicial, c.codigoperiodofinal
		from cohorte c, estudiante e
		where c.codigocarrera = e.codigocarrera
		and c.codigoperiodo = '$this->codigoperiodo'
		and c.codigojornada = e.codigojornada
		and e.codigoestudiante = '$this->codigoestudiante'
		and e.codigoperiodo*1 between c.codigoperiodoinicial*1 and c.codigoperiodofinal*1";
        //echo "<br>$query_datocohorte<br>";
        $datocohorte = mysql_query($query_datocohorte, $this->sala) or die("$query_datocohorte");
        $totalRows_datocohorte = mysql_num_rows($datocohorte);
        $row_datocohorte = mysql_fetch_array($datocohorte);
        $numerocohorte = $row_datocohorte['numerocohorte'];

        // Con la cohorte ahora hay que calcular el valor de la matricula
        // Si no tiene plan de estudio hace el siguiente query
        $semestreestudiante = $this->tieneplanestudio();
        if (!$semestreestudiante || $generarordensemestreactual) {
            $query_detallecohorte = "SELECT d.valordetallecohorte, d.codigoconcepto
			FROM cohorte c, detallecohorte d, estudiante e
			WHERE c.numerocohorte = '$numerocohorte'
			AND c.codigocarrera = e.codigocarrera
			AND c.codigoperiodo = '$this->codigoperiodo'
			and c.codigojornada = e.codigojornada
			AND c.codigoestadocohorte = '01'
			AND c.idcohorte = d.idcohorte
			and e.codigoestudiante = '$this->codigoestudiante'
			and d.semestredetallecohorte = e.semestre";
            //AND d.semestredetallecohorte = '$generarordensemestreactual'
            $detallecohorte = mysql_query($query_detallecohorte, $this->sala) or die("$query_detallecohorte");
            $totalRows_detallecohorte = mysql_num_rows($detallecohorte);
            $row_detallecohorte = mysql_fetch_array($detallecohorte);
        } else {
            $query_updprematriculaestudiante = "update prematricula p, estudiante e
			set p.semestreprematricula = '$semestreestudiante', e.semestre = '$semestreestudiante'
			where e.codigoestudiante = '$this->codigoestudiante'
			and p.codigoestudiante = e.codigoestudiante
			and p.codigoperiodo = '$this->codigoperiodo'";
            //echo "$query_insordenpago<br>";
            $updprematriculaestudiante = mysql_query($query_updprematriculaestudiante, $this->sala) or die("$query_updprematriculaestudiante<br>" . mysql_error());

            $query_detallecohorte = "SELECT d.valordetallecohorte, d.codigoconcepto
			FROM cohorte c, detallecohorte d, estudiante e
			WHERE c.numerocohorte = '$numerocohorte'
			AND c.codigocarrera = e.codigocarrera
			AND c.codigoperiodo = '$this->codigoperiodo'
			and c.codigojornada = e.codigojornada
			AND c.codigoestadocohorte = '01'
			AND c.idcohorte = d.idcohorte
			and e.codigoestudiante = '$this->codigoestudiante'
			AND d.semestredetallecohorte = '$semestreestudiante'";
            $detallecohorte = mysql_query($query_detallecohorte, $this->sala) or die("$query_detallecohorte");
            $totalRows_detallecohorte = mysql_num_rows($detallecohorte);
            $row_detallecohorte = mysql_fetch_array($detallecohorte);
        }
        //echo "<br>$query_detallecohorte<br>";
        //$fechainicialentregaordenpago = $row_detallecohorte['fechainicialentregaordenpago'];
        $valordetallecohorte = $row_detallecohorte['valordetallecohorte'] * $porcentaje / 100;
        //echo "$porcentaje-----";   echo $row_detallecohorte['valordetallecohorte']; exit();
        $codigoconcepto = $row_detallecohorte['codigoconcepto'];
        $this->insertardetalleordenpago($codigoconcepto, 1, $valordetallecohorte, 1);

        return $valordetallecohorte;
    }

    // Insertar conceptos orden pago, recibe el codigoreferenciaconcepto de los conceptos que van a ser generads
    function insertarconceptospecuniariosxcodigoreferenciaconcepto($codigoreferenciaconcepto) {
        $query_pecuniarios = "select distinct v.codigoconcepto, v.valorpecuniario, '3' as codigotipodetalle
		from valorpecuniario v, facturavalorpecuniario fv, detallefacturavalorpecuniario dfv, estudiante e, concepto c
		where v.idvalorpecuniario = dfv.idvalorpecuniario
		and v.codigoperiodo = '$this->codigoperiodo'
		and fv.codigoperiodo = v.codigoperiodo
		and fv.idfacturavalorpecuniario = dfv.idfacturavalorpecuniario
		and e.codigotipoestudiante = dfv.codigotipoestudiante
		and dfv.codigoestado like '1%'
		and e.codigoestudiante = '$this->codigoestudiante'
		and e.codigocarrera = fv.codigocarrera
		and c.codigoconcepto = v.codigoconcepto
		and v.codigoindicadorprocesointernet like '2%'
		and c.codigoreferenciaconcepto = '$codigoreferenciaconcepto'
		and c.codigoconcepto <> '159'
		and v.codigoestado like '1%'";
        $pecuniarios = mysql_query($query_pecuniarios, $this->sala) or die("$query_pecuniarios<br>" . mysql_error());
        //echo $query_pecuniarios."<br><br>";
        $totalRows_pecuniarios = mysql_num_rows($pecuniarios);
        if ($totalRows_pecuniarios != "") {
            while ($row_pecuniarios = mysql_fetch_array($pecuniarios)) {
                $totalconrecargo = $totalconrecargo + $row_pecuniarios['valorpecuniario'];
                $this->insertardetalleordenpago($row_pecuniarios['codigoconcepto'], 1, $row_pecuniarios['valorpecuniario'], $row_pecuniarios['codigotipodetalle']);
            }
        }
        return $totalconrecargo;
    }

// Insertar conceptos orden pago, recibe en un arreglo los conceptos a insertar y retorna el valor de los conceptos insertados
    function insertarconceptospecuniarios_inscripcion($conceptos) {
        $aregloconceptos = $conceptos;
        $totalconrecargo = 0;

        foreach ($aregloconceptos as $key => $codigoconcepto) {
            // Selecciona los valores de la tabla detallefacturavalorpecuniario
            //echo "".$_SESSION['MM_Username']." asdasd";
            //exit();
            if (ereg("estudiante", $_SESSION['MM_Username'])) {
                $query_pecuniarios = "select v.codigoconcepto, v.valorpecuniario, '3' as codigotipodetalle
				from valorpecuniario v, facturavalorpecuniario fv, detallefacturavalorpecuniario dfv, estudiante e, concepto c
				where v.idvalorpecuniario = dfv.idvalorpecuniario
				and v.codigoperiodo = '$this->codigoperiodo'
				and fv.codigoperiodo = v.codigoperiodo
				and fv.idfacturavalorpecuniario = dfv.idfacturavalorpecuniario
				and e.codigotipoestudiante = dfv.codigotipoestudiante
				and dfv.codigoestado like '1%'
				and e.codigoestudiante = '$this->codigoestudiante'
				and e.codigocarrera = fv.codigocarrera
				and v.codigoconcepto = '$codigoconcepto'
				and c.codigoconcepto = v.codigoconcepto
				and v.codigoindicadorprocesointernet like '1%'";
                $pecuniarios = mysql_query($query_pecuniarios, $this->sala) or die("$query_pecuniarios<br>" . mysql_error());
                //echo "1<br>".$query_pecuniarios."<br><br>";
                $totalRows_pecuniarios = mysql_num_rows($pecuniarios);
                if ($totalRows_pecuniarios == "") {
                  $query_pecuniarios = "select v.codigoconcepto, v.valorpecuniario, '3' as codigotipodetalle
					from valorpecuniario v, facturavalorpecuniario fv, detallefacturavalorpecuniario dfv, estudiante e, concepto c
					where v.idvalorpecuniario = dfv.idvalorpecuniario
					and v.codigoperiodo = '$this->codigoperiodo'
					and fv.codigoperiodo = v.codigoperiodo
					and fv.idfacturavalorpecuniario = dfv.idfacturavalorpecuniario
					and e.codigotipoestudiante = dfv.codigotipoestudiante
					and dfv.codigoestado like '1%'
					and e.codigoestudiante = '$this->codigoestudiante'
					and e.codigocarrera = fv.codigocarrera
					and v.codigoconcepto = '$codigoconcepto'
					and c.codigoconcepto = v.codigoconcepto
					and v.codigoindicadorprocesointernet like '2%'";
                    $pecuniarios = mysql_query($query_pecuniarios, $this->sala) or die("$query_pecuniarios<br>" . mysql_error());
                    //echo "2<br>".$query_pecuniarios."<br><br>";
                    $totalRows_pecuniarios = mysql_num_rows($pecuniarios);
                }
            } else {
                if (!isset($_SESSION['MM_Username'])||
                        ($_SESSION['MM_Username']=="Manejo Sistema")) {
                   $query_pecuniarios = "select v.codigoconcepto, v.valorpecuniario, '3' as codigotipodetalle
                    from valorpecuniario v, facturavalorpecuniario fv, detallefacturavalorpecuniario dfv, estudiante e, concepto c
                    where v.idvalorpecuniario = dfv.idvalorpecuniario
                    and v.codigoperiodo = '$this->codigoperiodo'
                    and fv.codigoperiodo = v.codigoperiodo
                    and fv.idfacturavalorpecuniario = dfv.idfacturavalorpecuniario
                    and e.codigotipoestudiante = dfv.codigotipoestudiante
                    and dfv.codigoestado like '1%'
                    and e.codigoestudiante = '$this->codigoestudiante'
                    and e.codigocarrera = fv.codigocarrera
                    and v.codigoconcepto = '$codigoconcepto'
                    and c.codigoconcepto = v.codigoconcepto
                    and v.codigoindicadorprocesointernet like '1%'";
                    $pecuniarios = mysql_query($query_pecuniarios, $this->sala) or die("$query_pecuniarios<br>" . mysql_error());
                    //echo "3<br>".$query_pecuniarios."<br><br>";
                    $totalRows_pecuniarios = mysql_num_rows($pecuniarios);
                } else {
                      $query_pecuniarios = "select v.codigoconcepto, v.valorpecuniario, '3' as codigotipodetalle
				    from valorpecuniario v, facturavalorpecuniario fv, detallefacturavalorpecuniario dfv, estudiante e, concepto c
				    where v.idvalorpecuniario = dfv.idvalorpecuniario
				    and v.codigoperiodo = '$this->codigoperiodo'
				    and fv.codigoperiodo = v.codigoperiodo
				    and fv.idfacturavalorpecuniario = dfv.idfacturavalorpecuniario
				    and e.codigotipoestudiante = dfv.codigotipoestudiante
				    and dfv.codigoestado like '1%'
				    and e.codigoestudiante = '$this->codigoestudiante'
				    and e.codigocarrera = fv.codigocarrera
				    and v.codigoconcepto = '$codigoconcepto'
				    and c.codigoconcepto = v.codigoconcepto
				    and v.codigoindicadorprocesointernet like '2%'";
                    $pecuniarios = mysql_query($query_pecuniarios, $this->sala) or die("$query_pecuniarios<br>" . mysql_error());
                  //  echo "4<br>".$query_pecuniarios."<br><br>";
                    //exit();
                    $totalRows_pecuniarios = mysql_num_rows($pecuniarios);
                }
            }
            if ($totalRows_pecuniarios != "") {
                while ($row_pecuniarios = mysql_fetch_array($pecuniarios)) {
                    $totalconrecargo = $totalconrecargo + $row_pecuniarios['valorpecuniario'];
                    $this->insertardetalleordenpago($row_pecuniarios['codigoconcepto'], 1, $row_pecuniarios['valorpecuniario'], $row_pecuniarios['codigotipodetalle']);
                }
            }
        }
        return $totalconrecargo;
    }

    // Insertar conceptos orden pago, recibe en un arreglo los conceptos a insertar y retorna el valor de los conceptos insertados
    function insertarconceptospecuniariosvalor_inscripcion($conceptos) {
        $arregloconceptos = $conceptos;
        $totalconrecargo = 0;

        foreach ($arregloconceptos as $codigoconcepto => $valorconcepto) {
            //echo "$codigoconcepto => $valorconcepto <br>";
            // Selecciona los valores de la tabla detallefacturavalorpecuniario
         $query_pecuniarios = "select v.codigoconcepto, v.valorpecuniario, '3' as codigotipodetalle
			from valorpecuniario v, facturavalorpecuniario fv, detallefacturavalorpecuniario dfv, estudiante e, concepto c
			where v.idvalorpecuniario = dfv.idvalorpecuniario
			and v.codigoperiodo = '$this->codigoperiodo'
			and fv.codigoperiodo = v.codigoperiodo
			and fv.idfacturavalorpecuniario = dfv.idfacturavalorpecuniario
			and e.codigotipoestudiante = dfv.codigotipoestudiante
			and dfv.codigoestado like '1%'
			and e.codigoestudiante = '$this->codigoestudiante'
			and e.codigocarrera = fv.codigocarrera
			and v.codigoconcepto = '$codigoconcepto'
			and c.codigoconcepto = v.codigoconcepto";
            $pecuniarios = mysql_query($query_pecuniarios, $this->sala) or die("$query_pecuniarios<br>" . mysql_error());
            //echo $query_pecuniarios."<br><br>";
            $totalRows_pecuniarios = mysql_num_rows($pecuniarios);
            if ($totalRows_pecuniarios != "") {
                while ($row_pecuniarios = mysql_fetch_array($pecuniarios)) {
                    if ($valorconcepto == "sin valor") {
                        $totalconrecargo = $totalconrecargo + $row_pecuniarios['valorpecuniario'];
                        $this->insertardetalleordenpago($row_pecuniarios['codigoconcepto'], 1, $row_pecuniarios['valorpecuniario'], $row_pecuniarios['codigotipodetalle']);
                    } else {
                        $totalconrecargo = $totalconrecargo + $valorconcepto;
                        $this->insertardetalleordenpago($row_pecuniarios['codigoconcepto'], 1, $valorconcepto, $row_pecuniarios['codigotipodetalle']);
                    }
                }
            }
        }
        return $totalconrecargo;
    }

    // Insertar conceptos orden pago, recibe en un arreglo los conceptos a insertar y retorna el valor de los conceptos insertados
    // Ademas toma las cantidades por cada concepto y las inserta
    function insertarconceptospecuniarios_inscripcioncantidad($conceptos, $cantidades) {
        $aregloconceptos = $conceptos;
        $totalconrecargo = 0;

        foreach ($aregloconceptos as $key => $codigoconcepto) {
            // Selecciona los valores de la tabla detallefacturavalorpecuniario
            $query_pecuniarios = "select v.codigoconcepto, v.valorpecuniario, '3' as codigotipodetalle
			from valorpecuniario v, facturavalorpecuniario fv, detallefacturavalorpecuniario dfv, estudiante e, concepto c
			where v.idvalorpecuniario = dfv.idvalorpecuniario
			and v.codigoperiodo = '$this->codigoperiodo'
			and fv.codigoperiodo = v.codigoperiodo
			and fv.idfacturavalorpecuniario = dfv.idfacturavalorpecuniario
			and e.codigotipoestudiante = dfv.codigotipoestudiante
			and dfv.codigoestado like '1%'
			and e.codigoestudiante = '$this->codigoestudiante'
			and e.codigocarrera = fv.codigocarrera
			and v.codigoconcepto = '$codigoconcepto'
			and c.codigoconcepto = v.codigoconcepto";
            $pecuniarios = mysql_query($query_pecuniarios, $this->sala) or die("$query_pecuniarios<br>" . mysql_error());
            //echo $query_pecuniarios."<br><br>";
            $totalRows_pecuniarios = mysql_num_rows($pecuniarios);
            if ($totalRows_pecuniarios != "") {
                while ($row_pecuniarios = mysql_fetch_array($pecuniarios)) {
                    $valor = $cantidades[$row_pecuniarios['codigoconcepto']] * $row_pecuniarios['valorpecuniario'];
                    //echo "$valor = ".$cantidades[$row_pecuniarios['codigoconcepto']]."*".$row_pecuniarios['valorpecuniario']."";
                    $totalconrecargo = $totalconrecargo + $valor;
                    $this->insertardetalleordenpago($row_pecuniarios['codigoconcepto'], $cantidades[$row_pecuniarios['codigoconcepto']], $valor, $row_pecuniarios['codigotipodetalle']);
                }
            }
        }
        return $totalconrecargo;
    }

    // Insertar conceptos orden pago, recibe en un arreglo los conceptos a insertar y retorna el valor de los conceptos insertados
    // Ademas toma las cantidades por cada concepto y las inserta
    function insertarconceptospecuniariosvalor_inscripcioncantidad($conceptos, $cantidades) {
        $arregloconceptos = $conceptos;
        $totalconrecargo = 0;

        foreach ($arregloconceptos as $codigoconcepto => $valorconcepto) {
            //echo "$codigoconcepto => $valorconcepto <br>";
            // Selecciona los valores de la tabla detallefacturavalorpecuniario
            $query_pecuniarios = "select v.codigoconcepto, v.valorpecuniario, '3' as codigotipodetalle
			from valorpecuniario v, facturavalorpecuniario fv, detallefacturavalorpecuniario dfv, estudiante e, concepto c
			where v.idvalorpecuniario = dfv.idvalorpecuniario
			and v.codigoperiodo = '$this->codigoperiodo'
			and fv.codigoperiodo = v.codigoperiodo
			and fv.idfacturavalorpecuniario = dfv.idfacturavalorpecuniario
			and e.codigotipoestudiante = dfv.codigotipoestudiante
			and dfv.codigoestado like '1%'
			and e.codigoestudiante = '$this->codigoestudiante'
			and e.codigocarrera = fv.codigocarrera
			and v.codigoconcepto = '$codigoconcepto'
			and c.codigoconcepto = v.codigoconcepto";
            $pecuniarios = mysql_query($query_pecuniarios, $this->sala) or die("$query_pecuniarios<br>" . mysql_error());
            //echo $query_pecuniarios."<br><br>";
            $totalRows_pecuniarios = mysql_num_rows($pecuniarios);
            if ($totalRows_pecuniarios != "") {
                while ($row_pecuniarios = mysql_fetch_array($pecuniarios)) {
                    if ($valorconcepto == "sin valor") {
                        $valor = $cantidades[$row_pecuniarios['codigoconcepto']] * $row_pecuniarios['valorpecuniario'];
                        echo "$valor = " . $cantidades[$row_pecuniarios['codigoconcepto']] . "*" . $row_pecuniarios['valorpecuniario'] . "<br>";
                        $totalconrecargo = $totalconrecargo + $valor;
                        $this->insertardetalleordenpago($row_pecuniarios['codigoconcepto'], $cantidades[$row_pecuniarios['codigoconcepto']], $valor, $row_pecuniarios['codigotipodetalle']);
                    } else {
                        $valor = $cantidades[$row_pecuniarios['codigoconcepto']] * $valorconcepto;
                        echo "$valor = " . $cantidades[$row_pecuniarios['codigoconcepto']] . "*" . $row_pecuniarios['valorpecuniario'] . "<br>";
                        $totalconrecargo = $totalconrecargo + $valorconcepto;
                        $this->insertardetalleordenpago($row_pecuniarios['codigoconcepto'], $cantidades[$row_pecuniarios['codigoconcepto']], $valor, $row_pecuniarios['codigotipodetalle']);
                    }
                }
            }
        }
        return $totalconrecargo;
    }

    /*     * *********************************************************************************************************************** */
    /*     * ************************************************* */

//													//
//			FUNCIONES DE VISUALIZACION				//
//													//
    /*     * ************************************************* */
    /*     * *********************************************************************************************************************** */

    // Esta función muestra el valor a ser pagado por la orden de pago
    function mostrar_ordenpagopaga($ruta, $rutaimpresion="") {
        // Muestra orden paga
        if (ereg("^4.+$", $this->codigoestadoordenpago)) {
?>
            <tr>
                <td><?php echo "<a href='" . $ruta . "verorden.php?numeroordenpago=$this->numeroordenpago&codigoestudiante=$this->codigoestudiante&codigoperiodo=$this->codigoperiodo&ipimpresora=$rutaimpresion'>$this->numeroordenpago</a>"; ?></td>
                <td><?php
            echo $this->tomar_fechaordenpago();
            if ($this->espensioncolegio())
                echo " " . fechaatextomes(formato_fecha_defecto($this->fechaentregaordenpago));
?></td>
        <td>
        <?php
            if ($codigocomprobante = $this->existe_ticket()) {
                $this->numerodocumento_ordenpago();
                $referencias["referencia1"] = $this->numeroordenpago;
                $referencias["referencia2"] = $this->numerodocumento;
                $referencias["referencia3"] = $this->tipodocumento;
                $clave = base64_encode(serialize($referencias));

             //if($_SESSION["idusuariofinalentradaentrada"]=="19649"){

        ?>
                      <!--        <a href="<?php echo $ruta ?>ticket.php?ordenpago=<?php echo $this->numeroordenpago ?>"><?php echo $codigocomprobante; ?></a>-->
                <a href="<?php echo $ruta . "../../../libsoap/" ?>class.getRequest.php?s=<?php echo $clave ?>&origen=1"><?php echo $codigocomprobante; ?></a>
        <?php
             //}
            } else {
                echo $this->existe_ticket();
        ?>
                                        			No tiene
        <?php
            }
        ?>
        </td>

    </tr>
<?php
        }
    }

    // Esta función muestra el valor a ser pagado por la orden de pago
    function mostrar_ordenpagopaga_resumida($ruta, $rutaimpresion="") {
        // Muestra orden paga
        if (ereg("^4.+$", $this->codigoestadoordenpago)) {
?>
            <td><?php echo "<a href='" . $ruta . "verorden.php?numeroordenpago=$this->numeroordenpago&codigoestudiante=$this->codigoestudiante&codigoperiodo=$this->codigoperiodo&ipimpresora=$rutaimpresion'>$this->numeroordenpago</a>"; ?></td>
            <td>
    <?php
            if ($codigocomprobante = $this->existe_ticket()) {
                // if($_SESSION["idusuariofinalentradaentrada"]=="19649"){

    ?>
                    <!--  <a href="<?php echo $ruta ?>ticket.php?ordenpago=<?php echo $this->numeroordenpago ?>"><?php echo $codigocomprobante; ?></a>-->
                <a href="<?php echo $ruta . "../../../libsoap/"; ?>class.getRequest.php?s=<?php echo $clave ?>&origen=1"><?php echo $codigocomprobante; ?></a>
    <?php
                 //}
            } else {
                echo $this->existe_ticket();
    ?>
                                                    			No tiene
    <?php
            }
    ?>
        </td>
        <td>Pagada</td>
        </td>
        </tr>
<?php
        }
    }

    function actualizaOrdenesProceso() {

        if (ereg("^6.+$", $this->codigoestadoordenpago)) {

            $this->numerodocumento_ordenpago();
            $referencias["referencia1"] = $this->numeroordenpago;
            $referencias["referencia2"] = $this->numerodocumento;
            $referencias["referencia3"] = $this->tipodocumento;

            $clave = base64_encode(serialize($referencias));
            $rutaarchivodocumento = "http://172.16.3.202/~javeeto/libsoap/class.getRequest.php?origengenerado=WShD82374RrES&s=" . $clave;
            //$rutaarchivodocumento="https://artemisa.unbosque.edu.co/libsoap/class.getRequest.php?s=".$clave;
            $gestor = fopen($rutaarchivodocumento, "rb");
            $contenido = fread($gestor, 4096);
            //   echo $contenido;
            fclose($gestor);

            $query_selnumeroordenpago = "SELECT * FROM ordenpago where numeroordenpago = '$this->numeroordenpago'";
            $selnumeroordenpago = mysql_query($query_selnumeroordenpago, $this->sala) or die("$query_selnumeroordenpago<br>" . mysql_error());
            $totalRows_selnumeroordenpago = mysql_num_rows($selnumeroordenpago);

            if ($totalRows_selnumeroordenpago != "") {
                $row_selnumeroordenpago = mysql_fetch_array($selnumeroordenpago);
                $this->codigoestadoordenpago=$row_selnumeroordenpago["codigoestadoordenpago"];
            }
        }
    }

    function mostrar_ordenpagoproceso($ruta, $rutaimpresion="") {
        // Muestra orden en proceso de pago
        if (ereg("^6.+$", $this->codigoestadoordenpago)) {

            $this->numerodocumento_ordenpago();
            $referencias["referencia1"] = $this->numeroordenpago;
            $referencias["referencia2"] = $this->numerodocumento;
            $referencias["referencia3"] = $this->tipodocumento;

            $clave = base64_encode(serialize($referencias));
            
            // Muestra orden en proceso de pago
            $query_ordenesenproceso = "select l.TransValue as valorfechaordenpago, l.SoliciteDate, l.TicketId
			from LogPagos l
			where l.Reference1 = '$this->numeroordenpago'
			order by 2 desc";
            $ordenesenproceso = mysql_query($query_ordenesenproceso, $this->sala) or die("$query_ordenesenproceso<br>" . mysql_error());
            $row_ordenesenproceso = mysql_fetch_array($ordenesenproceso);
            $totalRows_ordenesenproceso = mysql_num_rows($ordenesenproceso);
?>
            <tr>
                <td>
        <?php
            //echo "<a href='ordenmatricula2.php?ordenpago=$this->numeroordenpago&programausadopor=".$_GET['programausadopor']."&imprimeorden=$this->codigoimprimeordenpago'>$this->numeroordenpago</a>";
            echo "<a href='" . $ruta . "verorden.php?numeroordenpago=$this->numeroordenpago&codigoestudiante=$this->codigoestudiante&codigoperiodo=$this->codigoperiodo&ipimpresora=$rutaimpresion'>$this->numeroordenpago</a>";
        ?>
        </td>
        <td>$ <?php echo number_format($row_ordenesenproceso['valorfechaordenpago']); ?></td>
        <td><?php
            echo $this->tomar_fechaordenpago();
            if ($this->espensioncolegio())
                echo " " . fechaatextomes(formato_fecha_defecto($this->fechaentregaordenpago));
        ?></td>
    <td><!--<a href="<?php echo $ruta ?>ticket.php?ordenpago=<?php echo $this->numeroordenpago ?>">Ver</a>-->
            <?php
             //if($_SESSION["idusuariofinalentradaentrada"]=="19649"){
            ?>
            <a href="<?php echo $ruta . "../../../libsoap/"; ?>class.getRequest.php?s=<?php echo $clave ?>&origen=SALA">Ver</a>
            <?php
             //}
            ?>
        </td>
    </tr>
<?php
        }
    }

   function mostrar_ordenpagoporpagar($ruta, $rutaimpresion="") {
        // Ordenes de pago por pagar
        //$this->codigoestadorodenpago = '10';
        //echo "entro $this->codigoestadoordenpago $this->numeroordenpago";
        if (ereg("^1.+$", $this->codigoestadoordenpago)) {

            $this->numerodocumento_ordenpago();
                    $query_ordenesenproceso = "select *
			from LogPagos l
			where l.StaCode='PENDING'
                        and l.Reference2='".$this->numerodocumento."'
                        and l.Reference3='".$this->tipodocumento."'
			order by 2 desc";
        $ordenesenproceso = mysql_query($query_ordenesenproceso, $this->sala) or die("$query_ordenesenproceso<br>" . mysql_error());
        $row_ordenesenproceso = mysql_fetch_array($ordenesenproceso);
        $totalRows_ordenesenproceso = mysql_num_rows($ordenesenproceso);
        $mensaje="En este momento su orden de pago ".$row_ordenesenproceso["Reference1"].
        " presenta un proceso de pago cuya transaccion se encuentra PENDIENTE de recibir".
        " confirmaci&oacute;n por parte de su entidad financiera, por favor espere unos minutos y".
        " vuelva a consultar m&aacute;s tarde para verificar si su pago fue confirmado de forma exitosa".
        " Si desea mayor informaci&oacute;n sobre el estado actual de su operaci&oacute;n puede comunicarse a".
        " nuestras l&iacute;neas de atenci&oacute;n al cliente al tel&eacute;fono 6489000 ext 1555 o enviar sus inquietudes".
        " al correo helpdesk@unbosque.edu.co y pregunte por el estado de la transacci&oacute;n: ".$row_ordenesenproceso["TrazabilityCode"];

       // $mensaje="salga";

            // Muestra orden por pagar
            if ($fechavencimiento = $this->ordenvigente()) {
                // Si la orden no esta vencida
?>
                <tr>
                    <td>
        <?php
                echo "<a href='" . $ruta . "verorden.php?numeroordenpago=$this->numeroordenpago&codigoestudiante=$this->codigoestudiante&codigoperiodo=$this->codigoperiodo&ipimpresora=$rutaimpresion'>$this->numeroordenpago</a>";
        ?>

            </td>
            <td><?php echo number_format($fechavencimiento['valorfechaordenpago']); ?></td>
            <td><?php
                echo $fechavencimiento['fechaordenpago'];
                if ($this->espensioncolegio())
                    echo " " . fechaatextomes(formato_fecha_defecto($this->fechaentregaordenpago));
        ?></td>
            <td>
        <?php
                //if($_SESSION['MM_Username'] == "estudiante" || $_SESSION['MM_Username'] == "estudianterestringido")
                //{
                // 1 Miranos si esta a paz y salvo el estudiante
                $esmatricula = $this->valida_esmatricula();
                $deudasala = true;
                if ($esmatricula) {
                    //echo "<h1>No entro bien</h1>";
                    $estaapazysalvo = $this->valida_pazysalvoestudiante();
                    $sindocumentospendientes = $this->valida_documentosestudiante();
                    $tieneevaluaciondocente = $this->valida_evaluaciondocenteestudiante();
                    $estasindeudas = $this->valida_saldoencontra();
                    //echo $estasindeudas,"pailas";
                } else {
                    //echo "<h1>No entro</h1>";
                    $estaapazysalvo = true;
                    $sindocumentospendientes = true;
                    $tieneevaluaciondocente = true;
                    $estasindeudas = true;
                }
                //echo $estasindeudas;
                if (!$this->es_ordenplandepago()) {
                    if ($estaapazysalvo and $estasindeudas and ($estasindeudas * 1) <> 8) {
                        if (!$this->es_ordenplandepagohijo()) {
                            $deudasala = false;
                                    if($totalRows_ordenesenproceso>0){

//if($_SESSION["idusuariofinalentradaentrada"]=="19649"){
        echo "<a href='javascript:' onclick=alert(\"".$mensaje."\");>Pagos Electrónicos</a>";
//}
        }
        else{
//if($_SESSION["idusuariofinalentradaentrada"]=="19649"){
        ?>
                            <a href="<?php echo $ruta . "verorden.php?pse=" . $fechavencimiento['valorfechaordenpago'] . "&numeroordenpago=$this->numeroordenpago&codigoestudiante=$this->codigoestudiante&codigoperiodo=$this->codigoperiodo&ipimpresora=$rutaimpresion"; ?>">Pagos Electrónicos</a>&nbsp;
                            <!--<a href="javascript: alert('Disculpe los inconvenientes, en estos momentos el sistema de pagos de PSE se encuentra temporalmente fuera de servicio, esperamos contar muy pronto con el servicio; le sugerimos pagar en bancos.')">Pagos Electrónicos</a>&nbsp;-->
        <?php
//}
        }
                        } else {

                                if($totalRows_ordenesenproceso>0){
                                   // if($_SESSION["idusuariofinalentradaentrada"]=="19649"){

        echo "<a href='javascript:' onclick=\"alert('".$mensaje."');\">Pagos Electrónicos</a>";
                                   // }
        }
        else{
//if($_SESSION["idusuariofinalentradaentrada"]=="19649"){
        ?>
                            <a href="<?php echo $ruta . "verorden.php?pse=" . $fechavencimiento['valorfechaordenpago'] . "&numeroordenpago=$this->numeroordenpago&codigoestudiante=$this->codigoestudiante&codigoperiodo=$this->codigoperiodo&ipimpresora=$rutaimpresion"; ?>">Pagos Electrónicos</a>&nbsp;
                            <!--<a href="javascript: alert('Disculpe los inconvenientes, en estos momentos el sistema de pagos de PSE se encuentra temporalmente fuera de servicio, esperamos contar muy pronto con el servicio; le sugerimos pagar en bancos.')">Pagos Electrónicos</a>&nbsp;-->
        <?php
//}
        }
        }
                    }
                }
                //}
                // 1 Miranos si esta a paz y salvo el estudiante
                /* 				$esmatricula = $this->valida_esmatricula(); ////////// E.G.R 17.11.2006
                  if($esmatricula)
                  {
                  $estaapazysalvo = $this->valida_pazysalvoestudiante();
                  $sindocumentospendientes = $this->valida_documentosestudiante();
                  $tieneevaluaciondocente = $this->valida_evaluaciondocenteestudiante();
                  $estasindeudas = $this->valida_saldoencontra();
                  }
                  else
                  {
                  //echo "<h1>No entro</h1>";

                  $estaapazysalvo = true;
                  $sindocumentospendientes = true;
                  $tieneevaluaciondocente = true;
                  $estasindeudas = true;
                  } */

                //echo $_SESSION['impresorasesion'];
                //echo "Deudas ".$estasindeudas;
                if ($this->codigoimprimeordenpago == "02" && !$estaapazysalvo) {
                    //echo "No se le imprime orden de pago debido a que solicito crédito y tiene deuda";
                    $onClick = "alert('No se le permite Imprimir orden para pago en bancos debido a que solicito crédito y tiene deuda en sala')";
                }
                /* else if($this->codigoimprimeordenpago == "02")
                  {
                  //echo "No se le imprime orden de pago debido a que solicito crédito";
                  ?>
                  <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le imprime orden de pago debido a que solicito crédito')">&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php
                  } */ else if (!$estaapazysalvo) {
                    //echo "No se le imprime orden de pago debido a que tiene deuda";
                    $onClick = "alert('No se le permite Imprimir orden para pago en bancos debido a que tiene deuda en sala')";
                } else if (!$sindocumentospendientes) {
                    //echo "No se le imprime orden de pago debido a que tiene documentospendientes";
                    $onClick = "alert('No se le permite Imprimir orden para pago en bancos debido a que tiene documentos pendientes')";
                } else if (!$tieneevaluaciondocente) {
                    //echo "No se le imprime orden de pago debido a que no ha hecho la evaluacion docente";
                    $onClick = "alert('No se le permite Imprimir orden para pago en bancos debido a no ha realizado la evaluación docente')";
                } else if (($estasindeudas * 1) == 8) {
                    //echo "No se le imprime orden de pago debido a que no ha tienen deudas pendientes";
                    // Este mensaje es cuando tiene deudas en sap
                    $onClick = "alert('PRESENTA DEUDAS DE PACIENTES COMUNIQUESE CON LAS CLINICAS ODONTOLOGICAS')";
                } else if (!$estasindeudas) {
                    //echo "No se le imprime orden de pago debido a que no ha tienen deudas pendientes";
                    // Este mensaje es cuando tiene deudas en sap
                    $onClick = "alert('NO SE ENCUENTRA A PAZ Y SALVO, POR FAVOR REVISE SU ESTADO DE CUENTA, SI TIENE ORDENES POR PAGAR VENCIDAS POR FAVOR ANULARLAS')";
                } else {
                    $onClick = "window.open('$ruta" . "factura_pdf_nueva/confirmacion.php?numeroordenpago=" . $this->numeroordenpago . "&codigoestudiante=" . $this->codigoestudiante . "&codigoperiodo=" . $this->codigoperiodo . "&documentoingreso=" . $this->numerodocumento_ordenpago() . "','miventana','width=550,height=550,left=10,top=10,sizeable=yes,scrollbars=yes')";
                }
                if ($this->es_ordenplandepago()) {
                    $onClick = "alert('ESTA ORDEN ES DE PLAN DE PAGO, POR ENDE NO DE SE DEJA IMPRIMIR')";
                }
                // E.G.R 17.11.2006
                if ($deudasala) {
        ?>
                    <a onClick="<?php echo $onClick; ?>" id="aparencialink">Imprimir</a>
        <?php
                } else {
                    $onClick1 = "alert('No se le permite Imprimir orden para pago en bancos debido a que tiene deuda en sala')";
        ?>
                    <a onClick="<?php echo $onClick1; ?>" id="aparencialink">Imprimir</a>
        <?php
                }
        ?>
            </td>
        </tr>
<?php
            } else {
                // Si la orden esta vencida
?>
                <tr>
                    <td>
        <?php
                //echo "<a href='ordenmatricula2.php?ordenpago=$this->numeroordenpago&programausadopor=".$_GET['programausadopor']."'>$this->numeroordenpago</a>";
                echo "<a href='" . $ruta . "verorden.php?numeroordenpago=$this->numeroordenpago&codigoestudiante=$this->codigoestudiante&codigoperiodo=$this->codigoperiodo&ipimpresora=$rutaimpresion'>$this->numeroordenpago</a>";
        ?>

            </td>
            <td><?php
                echo $this->fechaordenpago;

                if ($this->espensioncolegio())
                    echo " " . fechaatextomes(formato_fecha_defecto($this->fechaentregaordenpago));
        ?></td>
        </tr>
<?php
            }
        }
    }

    function imprimir_ordenpdf($ruta, $nombre="Imprimir") {

        if (!ereg("^4.+$", $this->codigoestadoordenpago)) {
            if ($fechavencimiento = $this->ordenvigente()) {
                $esmatricula = $this->valida_esmatricula();
                if ($esmatricula) {
                    //echo "<h1>No entro</h1>";
                    $estaapazysalvo = $this->valida_pazysalvoestudiante();
                    $sindocumentospendientes = $this->valida_documentosestudiante();
                    $tieneevaluaciondocente = $this->valida_evaluaciondocenteestudiante();
                    $estasindeudas = $this->valida_saldoencontra();
                } else {
                    //echo "<h1>No entro2</h1>";
                    $estaapazysalvo = true;
                    $sindocumentospendientes = true;
                    $tieneevaluaciondocente = true;
                    $estasindeudas = true;
                }
                //echo $_SESSION['impresorasesion'];
                //echo "Deudas ".$estasindeudas;
                if ($this->codigoimprimeordenpago == "02" && !$estaapazysalvo) {
                    //echo "No se le imprime orden de pago debido a que solicito crédito y tiene deuda";
?>
                    <input name="imprimir" type="button" id="imprimir" value="<?php echo $nombre; ?>" onClick="alert('No se le permite Imprimir orden para pago en bancos debido a que solicito crédito y tiene deuda en sala')">&nbsp;&nbsp;&nbsp;&nbsp;
<?php
                }
                /* else if($this->codigoimprimeordenpago == "02")
                  {
                  //echo "No se le imprime orden de pago debido a que solicito crédito";
                  ?>
                  <input name="imprimir" type="button" id="imprimir" value="<?php echo $nombre; ?>" onClick="alert('No se le imprime orden de pago debido a que solicito crédito')">&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php
                  } */ else if (!$estaapazysalvo) {
                    //echo "No se le imprime orden de pago debido a que tiene deuda";
?>
                    <input name="imprimir" type="button" id="imprimir" value="<?php echo $nombre; ?>" onClick="alert('No se le permite Imprimir orden para pago en bancos debido a que tiene deuda en sala')">&nbsp;&nbsp;&nbsp;&nbsp;
<?php
                } else if (!$sindocumentospendientes) {
                    //echo "No se le imprime orden de pago debido a que tiene documentospendientes";
?>
                    <input name="imprimir" type="button" id="imprimir" value="<?php echo $nombre; ?>" onClick="alert('No se le permite Imprimir orden para pago en bancos debido a que tiene documentos pendientes')">&nbsp;&nbsp;&nbsp;&nbsp;
<?php
                } else if (!$tieneevaluaciondocente) {
                    //echo "No se le imprime orden de pago debido a que no ha hecho la evaluacion docente";
?>
                    <input name="imprimir" type="button" id="imprimir" value="<?php echo $nombre; ?>" onClick="alert('No se le permite Imprimir orden para pago en bancos debido a no ha realizado la evaluación docente')">&nbsp;&nbsp;&nbsp;&nbsp;
<?php
                } else if (!$estasindeudas) {
                    //echo "No se le imprime orden de pago debido a que no ha tienen deudas pendientes";
                    // Este mensaje es cuando tiene deudas en sap
?>
                    <input name="imprimir" type="button" id="imprimir" value="<?php echo $nombre; ?>" onClick="alert('NO SE ENCUENTRA A PAZ Y SALVO, POR FAVOR REVISE SU ESTADO DE CUENTA, SI TIENE ORDENES POR PAGAR VENCIDAS POR FAVOR ANULARLAS')">&nbsp;&nbsp;&nbsp;&nbsp;
<?php
                } else if (($estasindeudas * 1) == 8) { // deudas de pacientes 16.02.2007 E.G.R.
                    //echo "No se le imprime orden de pago debido a que no ha tienen deudas pendientes";
                    // Este mensaje es cuando tiene deudas en sap
?>

                    <input name="imprimir" type="button" id="imprimir" value="<?php echo $nombre; ?>" onClick="alert('PRESENTA DEUDAS DE PACIENTES COMUNIQUESE CON LAS CLINICAS ODONTOLOGICAS')">&nbsp;&nbsp;&nbsp;&nbsp;
<?php
                } else if (!$this->es_ordenplandepagohijo()) {
?>
                    <input name="imprimir" type="button" id="imprimir" value="<?php echo $nombre; ?>" onClick="alert('No se encuentra a Paz y Salvo')">&nbsp;&nbsp;&nbsp;&nbsp;

<?php
                } else if ($this->es_ordenplandepago()) {


                    //echo "No se le imprime orden de pago debido a que no ha tienen deudas pendientes";
                    // Este mensaje es cuando tiene deudas en sap
?>
                    <input name="imprimir" type="button" id="imprimir" value="<?php echo $nombre; ?>" onClick="alert('Esta orden ha sido generada para un plan de pagos por tanto no se permite imprimirla')">&nbsp;&nbsp;&nbsp;&nbsp;
<?php
                } else {
                    //echo "No debe nada";
                    //echo $ruta;
?>
                    <input name="Descargar" type="button" id="Descargar" value="<?php echo $nombre; ?>" onClick="window.open('<?php echo $ruta; ?>factura_pdf_nueva/confirmacion.php<?php echo "?numeroordenpago=" . $this->numeroordenpago . "&codigoestudiante=" . $this->codigoestudiante . "&codigoperiodo=" . $this->codigoperiodo . "&documentoingreso=" . $this->numerodocumento_ordenpago() . ""; ?>','miventana','width=550,height=600,left=10,top=10,sizeable=yes,scrollbars=yes');">
<?php
                }
            }
        }
    }

    function mostrar_ordenpagoporpagar_resumido($ruta, $rutaimpresion="") {
        // Ordenes de pago por pagar
        //$this->codigoestadorodenpago = '10';
        //echo "entro $this->codigoestadoordenpago $this->numeroordenpago";
        if (ereg("^1.+$", $this->codigoestadoordenpago)) {
            // Muestra orden por pagar
            if ($fechavencimiento = $this->ordenvigente()) {
                // Si la orden no esta vencida
?>
                <!-- <tr> -->
                <td>
    <?php
                echo "<a href='" . $ruta . "verorden.php?numeroordenpago=$this->numeroordenpago&codigoestudiante=$this->codigoestudiante&codigoperiodo=$this->codigoperiodo&ipimpresora=$rutaimpresion'>$this->numeroordenpago</a>";
    ?>

            </td>
            <td>$ <?php echo number_format($fechavencimiento['valorfechaordenpago']); ?></td>
            <!-- <td> -->
<?php
                if ($_SESSION['MM_Username'] == "estudiante" || $_SESSION['MM_Username'] == "estudianterestringido") {
                    if (!$this->es_ordenplandepago()) {
                        //echo "aca mi pez";
?>
                        <a href="<?php echo $ruta . "verorden.php?pse=" . $fechavencimiento['valorfechaordenpago'] . "&numeroordenpago=$this->numeroordenpago&codigoestudiante=$this->codigoestudiante&codigoperiodo=$this->codigoperiodo&ipimpresora=$rutaimpresion"; ?>" id="aparencialink">Pagos Electrónicos</a>
                        <!--<a href="javascript: alert('Disculpe los inconvenientes, en estos momentos el sistema de pagos de PSE se encuentra temporalmente fuera de servicio, esperamos contar muy pronto con el servicio; le sugerimos pagar en bancos.')">Pagos Electrónicos</a>&nbsp;-->
<?php
                    }
                }
                // 1 Miranos si esta a paz y salvo el estudiante
                /* $esmatricula = $this->valida_esmatricula();
                  if($esmatricula)
                  {
                  $estaapazysalvo = $this->valida_pazysalvoestudiante();
                  $sindocumentospendientes = $this->valida_documentosestudiante();
                  $tieneevaluaciondocente = $this->valida_evaluaciondocenteestudiante();
                  $estasindeudas = $this->valida_saldoencontra();
                  }
                  else
                  {
                  //echo "<h1>No entro</h1>";

                  $estaapazysalvo = true;
                  $sindocumentospendientes = true;
                  $tieneevaluaciondocente = true;
                  $estasindeudas = true;
                  }

                  //echo $_SESSION['impresorasesion'];
                  //echo "Deudas ".$estasindeudas;
                  if($this->codigoimprimeordenpago == "02" && !$estaapazysalvo)
                  {
                  //echo "No se le imprime orden de pago debido a que solicito crédito y tiene deuda";
                  ?>
                  <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le permite Imprimir orden para pago en bancos debido a que solicito crédito y tiene deuda en sala')">&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php
                  }
                  /*else if($this->codigoimprimeordenpago == "02")
                  {
                  //echo "No se le imprime orden de pago debido a que solicito crédito";
                  ?>
                  <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le imprime orden de pago debido a que solicito crédito')">&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php
                  } */
                /* else if(!$estaapazysalvo)
                  {
                  //echo "No se le imprime orden de pago debido a que tiene deuda";
                  ?>
                  <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le permite Imprimir orden para pago en bancos debido a que tiene deuda en sala')">&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php
                  }
                  else if(!$sindocumentospendientes)
                  {
                  //echo "No se le imprime orden de pago debido a que tiene documentospendientes";
                  ?>
                  <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le permite Imprimir orden para pago en bancos debido a que tiene documentos pendientes')">&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php
                  }
                  else if(!$tieneevaluaciondocente)
                  {
                  //echo "No se le imprime orden de pago debido a que no ha hecho la evaluacion docente";
                  ?>
                  <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le permite Imprimir orden para pago en bancos debido a no ha realizado la evaluación docente')">&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php
                  }
                  else if(!$estasindeudas)
                  {
                  //echo "No se le imprime orden de pago debido a que no ha tienen deudas pendientes";
                  // Este mensaje es cuando tiene deudas en sap
                  ?>
                  <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('NO SE ENCUENTRA A PAZ Y SALVO, POR FAVOR REVISE SU ESTADO DE CUENTA')">&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php
                  }
                  else
                  {
                  //echo "No debe nada";
                  //echo $ruta;
                  ?>
                  <input name="Descargar" type="button" id="Descargar" value="Imprimir" onClick="window.open('<?php echo $ruta;?>factura_pdf/confirmacion.php<?php echo "?numeroordenpago=".$this->numeroordenpago."&codigoestudiante=".$this->codigoestudiante."&codigoperiodo=".$this->codigoperiodo."&documentoingreso=".$this->numerodocumento_ordenpago()."";?>','miventana','width=550,height=550,left=10,top=10,sizeable=yes,scrollbars=no');">
                  <?php
                  } */
?>
                <!--
                  </td> -->
                <td>Por Pagar</td>
                </tr>
<?php
            } else {
                // Si la orden esta vencida
?>
                <td>
    <?php
                $query_selordenvencida = "select f.fechaordenpago, f.valorfechaordenpago
				from fechaordenpago f
				where f.numeroordenpago = '$this->numeroordenpago'
				and f.fechaordenpago >= '" . date('Y-m-d') . "'
				order by 1";
                //and dop.codigoconcepto = '151'
                //echo "$query_ordenesporpagar<br>";
                $selordenvencida = mysql_query($query_selordenvencida, $this->sala) or die("$query_selordenvencida<br>" . mysql_error());
                $totalRows_selordenvencida = mysql_num_rows($selordenvencida);
                $row_selordenvencida = mysql_fetch_array($selordenvencida);
                //echo "<a href='ordenmatricula2.php?ordenpago=$this->numeroordenpago&programausadopor=".$_GET['programausadopor']."'>$this->numeroordenpago</a>";
                echo "<a href='" . $ruta . "verorden.php?numeroordenpago=$this->numeroordenpago&codigoestudiante=$this->codigoestudiante&codigoperiodo=$this->codigoperiodo&ipimpresora=$rutaimpresion'>$this->numeroordenpago</a>";
    ?>

            </td>
            <td>$ <?php echo number_format($row_selordenvencida['valorfechaordenpago']); ?></td>
            <td> Vencida</td>
<?php
            }
        }
    }

    // Script donde se puede visualizar la orden de pago, detalles, fechas, bancos.
    function visualizar_ordenpago($tituloorden, $rutaimpresion="") {
        require('visualizar_ordenpago.php');
    }

    // Script donde se puede visualizar la parte de pse
    function visualizar_ordenpagopse() {
        require('visualizar_ordenpagopse.php');
    }

    // Script donde se puede visualizar las notas que lleva la orden de pago
    function visualizar_notasordenpago($notas) {
        require('visualizar_notasordenpago.php');
    }

    // Script donde se puede visualizar el boton para impresion de ordenes en la kyocera
    /*function visualizar_impresionordenpago($rutaimpresion="") {
        require('visualizar_impresionordenpago.php');
    }*/

    /*     * *********************************************************************************************************************** */
    /*     * ************************************************* */

//													//
//			FUNCIONES DE VALIDACION					//
//													//
    /*     * ************************************************* */
    /*     * *********************************************************************************************************************** */

    // Esta función mira si la orden de pago tiene un concepto determinado
    function existe_ordenpagoconcepto($codigoconcepto) {
        if ($this->existe_ordenpago()) {
            $query_selconceptoordenpago = "SELECT codigoconcepto FROM detalleordenpago
			where codigoconcepto = '$codigoconcepto'
			and numeroordenpago = '$this->numeroordenpago'";
            $selconceptoordenpago = mysql_query($query_selconceptoordenpago, $this->sala) or die("$query_selconceptoordenpago<br>" . mysql_error());
            $totalRows_selconceptoordenpago = mysql_num_rows($selconceptoordenpago);
            if ($totalRows_selconceptoordenpago != "") {
                return true;
            }
        }
        return false;
    }

    // Mira si una orden de pago tiene ticket
    function existe_ticket() {
        // Si la orden fue pagada por pse, tiene ticket
        $query_ordenespagadaspse = "select o.numeroordenpago, o.fechaordenpago, o.codigoimprimeordenpago, l.TransValue as valorfechaordenpago, l.TrazabilityCode as codigocomprobante, l.SoliciteDate
		from ordenpago o, LogPagos l
		where o.codigoestudiante = '$this->codigoestudiante'
		and o.codigoperiodo = '$this->codigoperiodo'
		and l.Reference1 = o.numeroordenpago
		and o.numeroordenpago = '$this->numeroordenpago'
		and l.StaCode = 'OK'
		order by 5, 6 desc ";
        //l.SoliciteDate and dop.codigoconcepto = '151'
        //echo "sdas $query_ordenespagadaspse<br>";
        $ordenespagadaspse = mysql_query($query_ordenespagadaspse, $this->sala) or die("$query_ordenespagadaspse<br>" . mysql_error());
        $totalRows_ordenespagadaspse = mysql_num_rows($ordenespagadaspse);
        //$row_ordenespagadaspse = mysql_fetch_array($ordenespagadaspse);
        if ($totalRows_ordenespagadaspse != "") {
            $row_ordenespagadaspse = mysql_fetch_array($ordenespagadaspse);
            return $row_ordenespagadaspse['codigocomprobante'];
        }
        return false;
    }

    // Validacion conceptos, recibe el codigo de referencia del concepto y mira si existe, si existe la funcion retorna verdadero si no falso
    function existe_conceptosxcodigoreferencia($codigoreferenciaconcepto) {
        $query_conceptos = "select c.codigoconcepto
		from concepto c
		where c.codigoreferenciaconcepto = '$codigoreferenciaconcepto'";
        $conceptos = mysql_query($query_conceptos, $this->sala) or die("$query_conceptos<br>" . mysql_error());
        $totalRows_conceptos = mysql_num_rows($conceptos);
        if ($totalRows_conceptos == "") {
?>
            <script language="javascript">
                alert("En la tabla conceptos no existe codigoreferenciaconcepto igual a <?php echo $codigoreferenciaconcepto ?>");
            </script>
<?php
            return false;
        }
        return true;
    }

    // Validacion de la tabla facturavalorpecuniario, toca meter la parte de educaión continuada
    function existe_facturavalorpecuniario() {
        $query_facturavalorpecuniario = "select f.idfacturavalorpecuniario
		from facturavalorpecuniario f, estudiante e
		where f.codigoperiodo = '$this->codigoperiodo'
		and f.codigocarrera = e.codigocarrera
		and e.codigoestudiante = '$this->codigoestudiante'";
        //echo $query_facturavalorpecuniario;
        $facturavalorpecuniario = mysql_query($query_facturavalorpecuniario, $this->sala) or die("$query_facturavalorpecuniario<br>" . mysql_error());
        $totalRows_facturavalorpecuniario = mysql_num_rows($facturavalorpecuniario);
        if ($totalRows_facturavalorpecuniario == "") {
?>
            <script language="javascript">
                alert("No se ha parametrizado la tabla facturavalorpecuniario");
            </script>
<?php
            return false;
        }
        return true;
    }

    // Validacion de la tabla valorpecuniario
    function existe_valorpecuniarioxcodigoreferencia($codigoreferenciaconcepto) {
        $query_valorpecuniario = "select v.idvalorpecuniario
		from valorpecuniario v, concepto c
		where v.codigoperiodo = '$this->codigoperiodo'
		and v.codigoconcepto = c.codigoconcepto
		and c.codigoreferenciaconcepto = '$codigoreferenciaconcepto'";
        //echo $query_facturavalorpecuniario;
        $valorpecuniario = mysql_query($query_valorpecuniario, $this->sala) or die("$query_valorpecuniario<br>" . mysql_error());
        $totalRows_valorpecuniario = mysql_num_rows($valorpecuniario);
        if ($totalRows_valorpecuniario == "") {
?>
            <script language="javascript">
                alert("No se ha parametrizado la tabla valorpecuniario con los conceptos con codigoreferencia=<?php echo $codigoreferenciaconcepto ?>");
            </script>
<?php
            return false;
        }
        return true;
    }

    // Validacion de la tabla detallefacturavalorpecuniario, toca meter la parte de educaión continuada
    function existe_detallefacturavalorpecuniarioxcodigoreferencia($codigoreferenciaconcepto) {
        $query_detallefacturavalorpecuniario = "select f.idfacturavalorpecuniario
		from facturavalorpecuniario f, estudiante e, detallefacturavalorpecuniario df, concepto c, valorpecuniario v
		where f.codigoperiodo = '$this->codigoperiodo'
		and f.codigocarrera = e.codigocarrera
		and e.codigoestudiante = '$this->codigoestudiante'
		and df.idfacturavalorpecuniario = f.idfacturavalorpecuniario
		and c.codigoconcepto = v.codigoconcepto
		and c.codigoreferenciaconcepto = '$codigoreferenciaconcepto'
		and df.idvalorpecuniario = v.idvalorpecuniario
		and df.codigoestado like '1%'";
        //echo $query_detallefacturavalorpecuniario;
        $detallefacturavalorpecuniario = mysql_query($query_detallefacturavalorpecuniario, $this->sala) or die("$query_detallefacturavalorpecuniario<br>" . mysql_error());
        $totalRows_detallefacturavalorpecuniario = mysql_num_rows($detallefacturavalorpecuniario);
        if ($totalRows_detallefacturavalorpecuniario == "") {
?>
            <script language="javascript">
                alert("No se ha parametrizado la tabla detallefacturavalorpecuniario con el codigoreferenciaconcepto <?php echo $codigoreferenciaconcepto ?>");
            </script>
<?php
            return false;
        }
        return true;
    }

    // Mira si esxiste un subperiodo creado para la orden de pago
    function existe_subperiodo() {
        $query_selsubperiodo = "select s.idsubperiodo
		from subperiodo s, carreraperiodo cp, periodo p, estudiante e
		where p.codigoestadoperiodo not like '2%'
		and p.codigoperiodo = cp.codigoperiodo
		and cp.idcarreraperiodo = s.idcarreraperiodo
		AND cp.codigocarrera = e.codigocarrera
		and e.codigoestudiante = '$this->codigoestudiante'
		and p.codigoperiodo = '$this->codigoperiodo'
		and s.codigoestadosubperiodo NOT LIKE '2%'";
        //and s.fechainicioacademicosubperiodo <= '".date("Y-m-d")."'
        //and s.fechafinalacademicosubperiodo >= '".date("Y-m-d")."'
        //echo "<br><br>SUBPERIODO<br>".$query_selsubperiodo."<br><br>";
        //exit();
        $selsubperiodo = mysql_query($query_selsubperiodo, $this->sala) or die("$query_selsubperiodo<br>" . mysql_error());
        $totalRows_selsubperiodo = mysql_num_rows($selsubperiodo);
        if ($totalRows_selsubperiodo == "") {
?>
            <script language="javascript">
                alert("No se ha parametrizado la tabla subperiodo, debe existir por lo menos un subperiodo para la carrera");
            </script>
<?php
            return false;
        }
        return true;
    }

    // Mira si existen carreraperiodo con el periodo activo
    function existe_carreraperiodo() {
        $query_carreraperiodo = "select cp.codigocarrera
		from carreraperiodo cp, estudiante e, periodo p
		where cp.codigocarrera = e.codigocarrera
		and cp.codigoperiodo = p.codigoperiodo
		and p.codigoestadoperiodo not like '2%'
		and e.codigoestudiante = '$this->codigoestudiante'
		and cp.codigoestado like '1%'";
        $carreraperiodo = mysql_query($query_carreraperiodo, $this->sala) or die("$query_carreraperiodo<br>" . mysql_error());
        //echo $query_fechasconceptos."<br>";
        $totalRows_carreraperiodo = mysql_num_rows($carreraperiodo);
        if ($totalRows_carreraperiodo == "") {
?>
            <script language="javascript">
                alert("No se ha parametrizado la tabla carreraperiodo con el periodo activo");
            </script>
<?php
            return false;
        }
        return true;
    }

    // Mira si existen fechas para pago de conceptos de inscripcion por cada carrera
    function existe_fechacarreraconcepto($codigoconcepto) {
        $query_fechasconceptos = "select f.nombrefechacarreraconcepto, f.fechavencimientofechacarreraconcepto, f.codigotipofechacarreraconcepto, f.numerodiasvencimientofechacarreraconcepto
		from fechacarreraconcepto f, estudiante e, concepto c
		where f.codigocarrera = e.codigocarrera
		and e.codigoestudiante = '$this->codigoestudiante'
		and f.fechavencimientofechacarreraconcepto >= '" . date("Y-m-d") . "'
		and f.codigoconcepto = c.codigoconcepto
		and c.codigoconcepto = '$codigoconcepto'
		order by 2 desc";
        $fechasconceptos = mysql_query($query_fechasconceptos, $this->sala) or die("$query_fechasconceptos<br>" . mysql_error());
        //echo $query_fechasconceptos."<br>";
        $totalRows_fechasconceptos = mysql_num_rows($fechasconceptos);
        if ($totalRows_fechasconceptos == "") {
?>
            <script language="javascript">
                alert("No se ha parametrizado la tabla fechacarreraconcepto con el codigoconcepto <?php echo $codigoconcepto ?>");
            </script>
<?php
            return false;
        }
        return true;
    }

    // Mira si existen fechas para pago de conceptos de inscripcion por cada carrera
    function existe_fechacarrerareferenciaconcepto($codigoreferenciaconcepto) {
        $query_fechasconceptos = "select f.nombrefechacarreraconcepto, f.fechavencimientofechacarreraconcepto, f.codigotipofechacarreraconcepto, f.numerodiasvencimientofechacarreraconcepto
		from fechacarreraconcepto f, estudiante e, concepto c
		where f.codigocarrera = e.codigocarrera
		and e.codigoestudiante = '$this->codigoestudiante'
		and f.fechavencimientofechacarreraconcepto >= '" . date("Y-m-d") . "'
		and f.codigoconcepto = c.codigoconcepto
		and c.codigoreferenciaconcepto = '$codigoreferenciaconcepto'
		order by 2 desc";
        $fechasconceptos = mysql_query($query_fechasconceptos, $this->sala) or die("$query_fechasconceptos<br>" . mysql_error());
        //echo $query_fechasconceptos."<br>";
        //exit();
        $totalRows_fechasconceptos = mysql_num_rows($fechasconceptos);
        if ($totalRows_fechasconceptos == "") {
?>
            <script language="javascript">
                alert("No se ha parametrizado la tabla fechacarreraconcepto con el codigoreferenciaconcepto <?php echo $codigoreferenciaconcepto ?>");
            </script>
<?php
            return false;
        }
        return true;
    }

    // Mira si estan los bancos para generar oden de pago
    function existe_cuentabanco() {
        $query_bancos = "SELECT c.idcuentabanco
		FROM cuentabanco c, banco b, estudiante e
		WHERE  c.codigobanco = b.codigobanco
		AND c.codigoperiodo = '$this->codigoperiodo'
		AND c.codigocarrera = e.codigocarrera
		and e.codigoestudiante = '$this->codigoestudiante'";
        //echo "$query_bancos<br>";
        //and dop.codigoconcepto = '151'
        $bancos = mysql_query($query_bancos, $this->sala) or die("$query_bancos<br>" . mysql_error());
        $totalRows_bancos = mysql_num_rows($bancos);
        if ($totalRows_bancos == "") {
            $query_bancos = "SELECT c.idcuentabanco
			FROM cuentabanco c, banco b
			WHERE  c.codigobanco = b.codigobanco
			AND c.codigoperiodo = '$this->codigoperiodo'
			AND codigocarrera = '1'";
            //echo "$query_bancos<br>";
            //and dop.codigoconcepto = '151'
            $bancos = mysql_query($query_bancos, $this->sala) or die("$query_bancos<br>" . mysql_error());
            $totalRows_bancos = mysql_num_rows($bancos);
        }
        if ($totalRows_bancos == "") {
?>
            <script language="javascript">
                alert("No se ha parametrizado la tabla cuentabanco para el periodo activo");
            </script>
<?php
            return false;
        }
        return true;
    }

    // Valida orden interna
    function existe_ordeninternaocentrobeneficio(&$ordeninternaocentrobeneficio, $materiascongrupo=0, &$tipoorden) {
		
		
		
        global $ordeninternaocentrobeneficio;
        // Selecciona el codigotipocosto de la carrera
        $query_tipocosto = "select c.codigotipocosto, c.codigocentrobeneficio
		from carrera c, estudiante e
		where c.codigocarrera = e.codigocarrera
		and e.codigocarrera = c.codigocarrera
		and e.codigoestudiante = '$this->codigoestudiante'";
        $tipocosto = mysql_query($query_tipocosto, $this->sala) or die("$query_tipocosto<br>" . mysql_error());
        $totalRows_tipocosto = mysql_num_rows($tipocosto);
        
       /* echo "<pre>";
        print_r( $totalRows_tipocosto);
        echo"</pre>";*/
        if ($totalRows_tipocosto != "") {
            $row_tipocosto = mysql_fetch_array($tipocosto);
            if (ereg("^1.+$", $row_tipocosto['codigotipocosto'])) {
                $tipoorden = "Centro Beneficio";
                if ($row_tipocosto['codigocentrobeneficio'] == 1) {
?>
                    <script language="javascript">
                        alert("La carrera requiere centro de beneficio y se encuentra en 1");
                    </script>
<?php
                    return false;
                } else {
                    $ordeninternaocentrobeneficio = $row_tipocosto['codigocentrobeneficio'];
                }
            } else if (ereg("^2.+$", $row_tipocosto['codigotipocosto'])) {
                $tipoorden = "Orden Interna";
                if (!is_array($materiascongrupo)) {
                    unset($materiascongrupo);
                    $query_grupos = "select g.idgrupo
					from grupo g, materia m
					where m.codigocarrera = '" . $this->tomar_carrerabd() . "'
					and m.codigomateria = g.codigomateria
					and g.codigoperiodo = '$this->codigoperiodo'";

                    //echo $query_grupos;
                    //exit();
                    $grupos = mysql_query($query_grupos, $this->sala) or die("$query_grupos" . mysql_error());
                    $totalRows_grupos = mysql_num_rows($grupos);
                    while ($row_grupos = mysql_fetch_array($grupos)) {
                        $materiascongrupo[] = $row_grupos['idgrupo'];
                    }
                }
                if (is_array($materiascongrupo)) {
                    $gruposavalidar = "";
                    foreach ($materiascongrupo as $key => $idgrupo) {
                        //echo "$key => $idgrupo <br>";
                        $gruposavalidar = $gruposavalidar . " n.idgrupo = $idgrupo or";
                    }
                    $gruposavalidar = ereg_replace("or$", "", $gruposavalidar);
                    // Si entra aca es por que aplica orden interna sap, el número de orden interna depende del grupo al que se mete el
                    // estudiante, es decir que tengo que pasarle el idgrupo para poderlo validar
                    $query_numeroordeninterna = "select distinct n.numeroordeninternasap, n.fechavencimientonumeroordeninternasap
					from numeroordeninternasap n, grupo g, materia m, estudiante e
					where m.codigomateria = g.codigomateria
					and ($gruposavalidar)
					and m.codigocarrera = e.codigocarrera
					and g.codigoperiodo = '$this->codigoperiodo'
					and e.codigoestudiante = '$this->codigoestudiante'
					and n.fechavencimientonumeroordeninternasap >= '" . date("Y-m-d") . "'
					order by 2 desc";
                    //echo $query_numeroordeninterna;
                    //exit();
                    $numeroordeninterna = mysql_query($query_numeroordeninterna, $this->sala) or die("$query_numeroordeninterna<br>" . mysql_error());
                    $totalRows_numeroordeninterna = mysql_num_rows($numeroordeninterna);
                    if ($totalRows_numeroordeninterna != "") {
                        $row_numeroordeninterna = mysql_fetch_array($numeroordeninterna);
                        $ordeninternaocentrobeneficio = $row_numeroordeninterna['numeroordeninternasap'];
                    } else {
                        //exit();
?>
                        <script language="javascript">
                            alert("El grupo requiere orden pago interna y no posee una activa");
                        </script>
<?php
                        return false;
                    }
                } else {
?>
                    <script language="javascript">
                        alert("La carrera requiere orden pago interna y no posee una activa");
                    </script>
<?php
                    return false;
                }
            }
        } else {
?>
            <script language="javascript">
                alert("Error del sistema, la carrera no existe o tiene otro tipo de costo");
            </script>
<?php
            return false;
        }
        return true;
    }

    // Mira si hay registro de fechaeducacioncontinuada
    function existe_fechaeducacioncontinuada($materiascongrupo) {
        if (is_array($materiascongrupo)) {
            $gruposavalidar = "";
            foreach ($materiascongrupo as $key => $idgrupo) {
                //echo "$key => $idgrupo <br>";
                $gruposavalidar = $gruposavalidar . " and f.idgrupo = '$idgrupo'";
            }
            $query_fechaeducacioncontinuada = "select f.idfechaeducacioncontinuada
			from fechaeducacioncontinuada f
			where f.codigoestado like '1%'
			$gruposavalidar";
            $fechaeducacioncontinuada = mysql_query($query_fechaeducacioncontinuada, $this->sala) or die("$query_fechaeducacioncontinuada<br>" . mysql_error());
            //echo $query_fechaeducacioncontinuada."<br>";
            //exit();
            $totalRows_fechaeducacioncontinuada = mysql_num_rows($fechaeducacioncontinuada);
            if ($totalRows_fechaeducacioncontinuada == "") {
?>
                <script language="javascript">
                    alert("No se ha parametrizado la tabla fechaeducacioncontinuada para el grupo seleccionado");
                </script>
<?php
                return false;
            }
        } else {
?>
            <script language="javascript">
                alert("No se ha parametrizado la tabla fechaeducacioncontinuada para el grupo seleccionado");
            </script>
<?php
            return false;
        }
        return true;
    }

    // Mira que hallan fechas en detallefechafinaciera para el periodo activo
    function existe_detallefechaeducacioncontinuada($materiascongrupo) {
        if (is_array($materiascongrupo)) {
            $gruposavalidar = "";
            foreach ($materiascongrupo as $key => $idgrupo) {
                //echo "$key => $idgrupo <br>";
                $gruposavalidar = $gruposavalidar . " and f.idgrupo = '$idgrupo'";
            }
            $query_detallefechaeducacioncontinuada = "select f.idfechaeducacioncontinuada
			from fechaeducacioncontinuada f, detallefechaeducacioncontinuada d
			where f.codigoestado like '1%'
			and d.idfechaeducacioncontinuada = f.idfechaeducacioncontinuada
			$gruposavalidar";
            $detallefechaeducacioncontinuada = mysql_query($query_detallefechaeducacioncontinuada, $this->sala) or die("$query_detallefechaeducacioncontinuada<br>" . mysql_error());
            //echo $query_detallefechaeducacioncontinuada."<br>";
            $totalRows_detallefechaeducacioncontinuada = mysql_num_rows($detallefechaeducacioncontinuada);
            if ($totalRows_detallefechaeducacioncontinuada == "") {
?>
                <script language="javascript">
                    alert("No se ha parametrizado la tabla detallefechaeducacioncontinuada");
                </script>
<?php
                return false;
            }
        } else {
?>
            <script language="javascript">
                alert("No se ha parametrizado la tabla detallefechaeducacioncontinuada");
            </script>
<?php
        }
        return true;
    }

    // Mira si hay registro de fechafinaciera
    function existe_fechafinaciera() {
        $query_fechafinaciera = "select f.idfechafinanciera
		from fechafinanciera f, estudiante e
		where f.codigocarrera = e.codigocarrera
		and f.codigoperiodo = '$this->codigoperiodo'
		and e.codigoestudiante = '$this->codigoestudiante'";
        $fechafinaciera = mysql_query($query_fechafinaciera, $this->sala) or die("$query_fechafinaciera<br>" . mysql_error());
        //echo $query_fechasconceptos."<br>";
        $totalRows_fechafinaciera = mysql_num_rows($fechafinaciera);
        if ($totalRows_fechafinaciera == "") {
?>
            <script language="javascript">
                alert("No se ha parametrizado la tabla fechafinaciera con el periodo activo");
            </script>
<?php
            return false;
        }
        return true;
    }

    // Mira que hallan fechas en detallefechafinaciera para el periodo activo
    function existe_detallefechafinaciera() {
        $query_detallefechafinaciera = "select f.idfechafinanciera
		from fechafinanciera f, estudiante e, detallefechafinanciera d
		where f.codigocarrera = e.codigocarrera
		and f.codigoperiodo = '$this->codigoperiodo'
		and e.codigoestudiante = '$this->codigoestudiante'
		and d.idfechafinanciera = f.idfechafinanciera";
        $detallefechafinaciera = mysql_query($query_detallefechafinaciera, $this->sala) or die("$query_detallefechafinaciera<br>" . mysql_error());
        //echo $query_fechasconceptos."<br>";
        $totalRows_detallefechafinaciera = mysql_num_rows($detallefechafinaciera);
        if ($totalRows_detallefechafinaciera == "") {
?>
            <script language="javascript">
                alert("No se ha parametrizado la tabla detallefechafinaciera");
            </script>
<?php
            return false;
        }
        return true;
    }

    // 12. Que tenga cohorte para el estudiante
    function existe_cohorte() {
        $query_cohorte = "select c.idcohorte
		from cohorte c, estudiante e, carrera ca, modalidadacademica m
		where c.codigocarrera = e.codigocarrera
		and c.codigoperiodo = '$this->codigoperiodo'
		and e.codigoestudiante = '$this->codigoestudiante'
		and ca.codigocarrera = e.codigocarrera
		and ca.codigomodalidadacademica = m.codigomodalidadacademica
		and ca.codigoreferenciacobromatriculacarrera like '1%'
		and c.codigoestadocohorte = '01'";
        $cohorte = mysql_query($query_cohorte, $this->sala) or die("$query_cohorte<br>" . mysql_error());
        //echo $query_cohorte."<br>";
        $totalRows_cohorte = mysql_num_rows($cohorte);
        if ($totalRows_cohorte == "") {
            $query_cohorte = "select v.idvaloreducacioncontinuada
			from valoreducacioncontinuada v, estudiante e, carrera ca, modalidadacademica m
			where v.codigocarrera = e.codigocarrera
			and v.fechainiciovaloreducacioncontinuada <= '" . date("Y-m-d", time()) . "'
			and v.fechafinalvaloreducacioncontinuada >= '" . date("Y-m-d", time()) . "'
			and e.codigoestudiante = '$this->codigoestudiante'
			and ca.codigocarrera = e.codigocarrera
			and ca.codigomodalidadacademica = m.codigomodalidadacademica
			and ca.codigoreferenciacobromatriculacarrera like '2%'";
            $cohorte = mysql_query($query_cohorte, $this->sala) or die("$query_cohorte<br>" . mysql_error());
            //echo $query_cohorte."<br>";
            $totalRows_cohorte = mysql_num_rows($cohorte);
            if ($totalRows_cohorte == "") {
?>
                <script language="javascript">
                    alert("No se ha parametrizado la tabla cohorte o valoreducacioncontinuada");
                </script>
<?php
                return false;
            }
        }
        return true;
    }

    // 13. Que tenga detallecohorte o valoreducacioncontinuada
    function existe_detallecohorte() {
        $query_cohorte = "select c.idcohorte
		from cohorte c, estudiante e, carrera ca, modalidadacademica m, detallecohorte d
		where c.codigocarrera = e.codigocarrera
		and c.codigoperiodo = '$this->codigoperiodo'
		and e.codigoestudiante = '$this->codigoestudiante'
		and ca.codigocarrera = e.codigocarrera
		and ca.codigomodalidadacademica = m.codigomodalidadacademica
		and ca.codigoreferenciacobromatriculacarrera like '1%'
		and e.codigoperiodo*1 between c.codigoperiodoinicial*1 and c.codigoperiodofinal*1
		and d.idcohorte = c.idcohorte";
        $cohorte = mysql_query($query_cohorte, $this->sala) or die("$query_cohorte<br>" . mysql_error());
        //echo $query_cohorte."<br>";
        $totalRows_cohorte = mysql_num_rows($cohorte);
        if ($totalRows_cohorte == "") {
            $query_cohorte = "select v.idvaloreducacioncontinuada
			from valoreducacioncontinuada v, estudiante e, carrera ca, modalidadacademica m
			where v.codigocarrera = e.codigocarrera
			and v.fechainiciovaloreducacioncontinuada <= '" . date("Y-m-d", time()) . "'
			and v.fechafinalvaloreducacioncontinuada >= '" . date("Y-m-d", time()) . "'
			and e.codigoestudiante = '$this->codigoestudiante'
			and ca.codigocarrera = e.codigocarrera
			and ca.codigomodalidadacademica = m.codigomodalidadacademica
			and ca.codigoreferenciacobromatriculacarrera like '2%'";
            $cohorte = mysql_query($query_cohorte, $this->sala) or die("$query_cohorte<br>" . mysql_error());
            //echo $query_cohorte."<br>";
            $totalRows_cohorte = mysql_num_rows($cohorte);
            if ($totalRows_cohorte == "") {
?>
                <script language="javascript">
                    alert("No se ha parametrizado la tabla detallecohorte o valoreducacioncontinuada");
                </script>
<?php
                return false;
            }
        }
        return true;
    }

    // Esta función mira si existe una orden de pago
    function existe_ordenpago(&$estado) {
        $query_selnumeroordenpago = "SELECT numeroordenpago, codigoestadoordenpago FROM ordenpago where numeroordenpago = '$this->numeroordenpago'";
        //echo "$query_selnumeroordenpago";
        $selnumeroordenpago = mysql_query($query_selnumeroordenpago, $this->sala) or die("$query_selnumeroordenpago<br>" . mysql_error());
        $totalRows_selnumeroordenpago = mysql_num_rows($selnumeroordenpago);
        if ($totalRows_selnumeroordenpago != "") {
            $row_selnumeroordenpago = mysql_fetch_array($selnumeroordenpago);
            if (ereg("^1.+$", $row_selnumeroordenpago['codigoestadoordenpago'])) {
                $estado = "porpagar";
            }
            if (ereg("^2.+$", $row_selnumeroordenpago['codigoestadoordenpago'])) {
                $estado = "anulada";
            }
            if (ereg("^4.+$", $row_selnumeroordenpago['codigoestadoordenpago'])) {
                $estado = "paga";
            }
            if (ereg("^5.+$", $row_selnumeroordenpago['codigoestadoordenpago'])) {
                $estado = "paga";
            }
            if (ereg("^6.+$", $row_selnumeroordenpago['codigoestadoordenpago'])) {
                $estado = "enproceso";
            }
            return true;
        }
        return false;
    }

/*    function necesita_conexionsap(&$row_estadoconexionexterna) {
        $query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado, e.hostestadoconexionexterna,
		e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna, e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
		from estadoconexionexterna e
		where e.codigoestado like '1%'";
        //and dop.codigoconcepto = '151'
        //echo "sdas $query_ordenes<br>";
        $estadoconexionexterna = mysql_query($query_estadoconexionexterna, $this->sala) or die("$query_estadoconexionexterna<br>" . mysql_error());
        $totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
        $row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);
        if (ereg("^1.+$", $row_estadoconexionexterna['codigoestado'])) {
            return true;
        }
        return false;
    }

    function existe_conexionsap() {
        if (!$this->conexionsap) {
            if ($this->necesita_conexionsap($row_estadoconexionexterna)) {
?>
                <script language="javascript">
                    alert("Se cayo la conexion a sap y no se pueden generar ordenes de pago");
                </script>
<?php
                return false;
            }
            return true;
        }
        return $this->conexionsap;
    }*/

    // Validaciones de anulacion de orden de pago, la cual mira si la orden tiene algun concepto de matricula y es la más reciente
    function valida_anulacionordenmatricula() {
        if (!ereg("^1.+$", $this->codigoestadoordenpago)) {
            return false;
        }
        if (ereg("estudiante", $_SESSION['MM_Username'])) {
            // Si la orden tiene concepto de prematricula y es la mas reciente permite anularla
            $query_ordenesanuladas = "select o.numeroordenpago
			from ordenpago o
			where o.codigoperiodo = '$this->codigoperiodo'
			and o.codigoestadoordenpago like '2%'
			and o.codigoestudiante = '$this->codigoestudiante'";
            //and dop.codigoconcepto = '151'
            //echo "sdas $query_ordenes<br>";
            $ordenesanuladas = mysql_query($query_ordenesanuladas, $this->sala) or die("$query_ordenesanuladas<br>" . mysql_error());
            $totalRows_ordenesanuladas = mysql_num_rows($ordenesanuladas);
            //echo $totalRows_ordenesanuladas;
            if ($totalRows_ordenesanuladas > 50) {
                return false;
            }
        }

        // Si la orden tien plan de pagos no la deja anular
        $query_ordeneplandepago = "select op.idordenpagoplandepago
		from ordenpagoplandepago op
		where op.codigoestado like '1%'
		and (op.numerorodenpagoplandepagosap = '$this->numeroordenpago')";
        // and (op.numerorodenpagoplandepagosap = '$this->numeroordenpago' or op.numerorodencoutaplandepagosap = '$this->numeroordenpago')
        //and dop.codigoconcepto = '151'
        //echo "sdas $query_ordenes<br>";
        $ordeneplandepago = mysql_query($query_ordeneplandepago, $this->sala) or die("$query_ordeneplandepago<br>" . mysql_error());
        $totalRows_ordeneplandepago = mysql_num_rows($ordeneplandepago);
        if ($totalRows_ordeneplandepago != "") {
            return false;
        }

        // Si la orden tiene concepto de prematricula y es la mas reciente permite anularla E.G.R 17.11.2006 comente desde aca
        $query_ordenes = "select d.numeroordenpago, c.codigoconcepto, f.fechaordenpago
		from detalleordenpago d, concepto c, fechaordenpago f
		where d.numeroordenpago = '$this->numeroordenpago'
		and c.codigoconcepto = d.codigoconcepto
		and c.codigoreferenciaconcepto = '100'
		and f.numeroordenpago = d.numeroordenpago
		order by 3 desc";
        //and dop.codigoconcepto = '151'
        //echo "sdas $query_ordenes<br>";
        $ordenes = mysql_query($query_ordenes, $this->sala) or die("$query_ordenes<br>" . mysql_error());
        $totalRows_ordenes = mysql_num_rows($ordenes);
        if ($totalRows_ordenes != "") {
            // La orden tiene conceptos de matricula
            // Miro las demás ordenes del estudiante, en caso de haber una orden mayor con concepto de matricula
            // y si esta es la mas nueva no la deja anular
            $row_ordenes = mysql_fetch_array($ordenes);
            $query_otrasordenes = "select o.numeroordenpago
			from ordenpago o, detalleordenpago d, concepto c
			where o.codigoestudiante = '$this->codigoestudiante'
			and o.codigoestadoordenpago not like '2%'
			and o.numeroordenpago > '$this->numeroordenpago'
			and d.codigoconcepto = c.codigoconcepto
			and c.codigoreferenciaconcepto = '100'
			and d.numeroordenpago = o.numeroordenpago
			group by 1";
            //and dop.codigoconcepto = '151'
            //echo "sdas $query_ordenespagadaspse<br>";
            $otrasordenes = mysql_query($query_otrasordenes, $this->sala) or die("$query_otrasordenes<br>" . mysql_error());
            $totalRows_otrasordenes = mysql_num_rows($otrasordenes);
            if ($totalRows_otrasordenes != "") {
                //return false; hasta E.G.R 17.11.2006 comente desde aca
            }
        } //
        /* else
          {
          return false;
          } */
        return true;
    }

    function valida_ordeninscripcion() {
        $valordeverdad = true;
        require('valida_ordeninscripcion.php');
        return $valordeverdad;
    }

    function valida_ordenvarias($conceptos) {
        $valordeverdad = true;
        foreach ($conceptos as $key => $codigoconcepto) {
            $query_referenciaconcepto = "select c.codigoconcepto, c.codigoreferenciaconcepto
			from concepto c
			where c.codigoconcepto = '$codigoconcepto'";
            //echo "<br>$query_referenciaconcepto";
            $referenciaconcepto = mysql_query($query_referenciaconcepto, $this->sala) or die("$query_referenciaconcepto" . mysql_error());
            $row_referenciaconcepto = mysql_fetch_assoc($referenciaconcepto);
            $codigoreferenciaconcepto = $row_referenciaconcepto['codigoreferenciaconcepto'];
            $totalRows_referenciaconcepto = mysql_num_rows($referenciaconcepto);
            require('valida_ordenvarias.php');
            if (!$valordeverdad) {
                return false;
            }
        }
        return $valordeverdad;
    }

    function valida_ordenmatricula() {
		
		
        $valordeverdad = true;
       
        require('valida_ordenmatricula.php');
       echo $valordeverdad;
        return $valordeverdad;
         
    }

    function valida_ordenmatriculacursoscertificados() {
        $valordeverdad = true;
        require('valida_ordenmatriculacursoscertificados.php');
        return $valordeverdad;
    }

    function valida_ordenmatriculacursoslibres($materiascongrupo) {
        $valordeverdad = true;
        require('valida_ordenmatriculacursoslibres.php');
        return $valordeverdad;
    }

    function existe_bloqueo() {
        $query_conceptosbloqueo = "select d.numeroordenpago
		from detalleordenpago d, concepto c
		where d.codigoconcepto = c.codigoconcepto
		and c.codigoaplicabloqueodeuda like '1%'
		and d.numeroordenpago = '$this->numeroordenpago'";
        $conceptosbloqueo = mysql_query($query_conceptosbloqueo, $this->sala) or die("$query_conceptosbloqueo" . mysql_error());
        //echo "<h5>$query_conceptosbloqueo</h5>";
        $totalRows_conceptosbloqueo = mysql_num_rows($conceptosbloqueo);
        if ($totalRows_conceptosbloqueo == "") {
            return false;
        }
        return true;
    }

    function valida_pazysalvoestudiante() {
        if ($this->existe_bloqueo()) {
             $query_pazysalvo = "select p.idpazysalvoestudiante, e.codigocarrera
			from pazysalvoestudiante p, detallepazysalvoestudiante d, estudiante e
			where e.codigoestudiante = '$this->codigoestudiante'
			and p.idpazysalvoestudiante = d.idpazysalvoestudiante
			and d.codigoestadopazysalvoestudiante like '1%'
			and e.idestudiantegeneral = p.idestudiantegeneral";
            $pazysalvo = mysql_query($query_pazysalvo, $this->sala) or die("$query_pazysalvo" . mysql_error());
            $totalRows_pazysalvo = mysql_num_rows($pazysalvo);
            //echo "<h5>$totalRows_pazysalvo</h5>";
            if ($totalRows_pazysalvo != "") {
                return false;
            }
        }
        return true;
    }

    function es_ordenplandepago() {
        // Si la orden tien plan de pagos no la deja anular
        $query_ordeneplandepago = "select op.idordenpagoplandepago
		from ordenpagoplandepago op
		where op.codigoestado like '1%'
		and op.numerorodenpagoplandepagosap = '$this->numeroordenpago'";
        //and dop.codigoconcepto = '151'
        //echo "sdas $query_ordeneplandepago<br>";
        $ordeneplandepago = mysql_query($query_ordeneplandepago, $this->sala) or die("$query_ordeneplandepago<br>" . mysql_error());
        $totalRows_ordeneplandepago = mysql_num_rows($ordeneplandepago);

        ///// E.G.R 17-11-2006
        /*
          $query_ordeneplandepago1 = "SELECT op.idordenpagoplandepago
          FROM ordenpagoplandepago op,ordenpago o,pazysalvoestudiante p,detallepazysalvoestudiante d,estudiantegeneral eg,estudiante e
          WHERE op.codigoestado LIKE '1%'
          AND op.numerorodencoutaplandepagosap = '$this->numeroordenpago'
          AND op.numerorodencoutaplandepagosap = o.numeroordenpago
          AND o.codigoestudiante = e.codigoestudiante
          AND eg.idestudiantegeneral = e.idestudiantegeneral
          AND p.idestudiantegeneral = eg.idestudiantegeneral
          AND d.idpazysalvoestudiante = p.idpazysalvoestudiante
          AND d.codigoestadopazysalvoestudiante LIKE '1%'";
          //and dop.codigoconcepto = '151'
          //echo "sdas $query_ordeneplandepago<br>";
          $ordeneplandepago1 = mysql_query($query_ordeneplandepago1,$this->sala) or die("$query_ordeneplandepago1<br>".mysql_error());
          $totalRows_ordeneplandepago1 = mysql_num_rows($ordeneplandepago1); */

        ////// fin  E.G.R 17-11-2006

        if ($totalRows_ordeneplandepago == "") {
            return false;
        }
        return true;
    }

    ////// E.G.R 17-11-2006 determina si es hijo y tiene deuda en SALA

    function es_ordenplandepagohijo() {

        $query_ordeneplandepago1 = "SELECT op.idordenpagoplandepago
		FROM ordenpagoplandepago op,ordenpago o,pazysalvoestudiante p,detallepazysalvoestudiante d,estudiantegeneral eg,estudiante e
		WHERE op.codigoestado LIKE '1%'
		AND op.numerorodencoutaplandepagosap = '$this->numeroordenpago'
		AND op.numerorodencoutaplandepagosap = o.numeroordenpago
		AND o.codigoestudiante = e.codigoestudiante
		AND eg.idestudiantegeneral = e.idestudiantegeneral
		AND p.idestudiantegeneral = eg.idestudiantegeneral
		AND d.idpazysalvoestudiante = p.idpazysalvoestudiante
		AND d.codigoestadopazysalvoestudiante LIKE '1%'";
        //and dop.codigoconcepto = '151'
        //echo "sdas $query_ordeneplandepago1<br>";
        $ordeneplandepago1 = mysql_query($query_ordeneplandepago1, $this->sala) or die("$query_ordeneplandepago1<br>" . mysql_error());
        $totalRows_ordeneplandepago1 = mysql_num_rows($ordeneplandepago1);

        ////// fin  E.G.R 17-11-2006 determina si es hijo y tiene deuda en SALA

        if ($totalRows_ordeneplandepago1 <> "") {
            return false;
        }
        return true;
    }

    //



 function valida_saldoencontra() {
    
        if ($this->existe_bloqueo()) {
            $saldoencontra = $this->tomar_saldocontra();
            if ($saldoencontra == 8) { // E.G.R 16.02.2007
                return $saldoencontra;
            } else                        // FIN  E.G.R 16.02.2007
            if (is_array($saldoencontra)) {
				
				for($i=0;$i<count($saldoencontra);$i++) {
			
		$arr[$saldoencontra[$i]['5']]=$arr[$saldoencontra[$i]['5']];
        
	$fecha[] =$saldoencontra[$i]['5'];
	
		rsort(	$fecha);		
				
	/*$item[]=$saldoencontra[$i]['1'];
	krsort($item);*/
	
	
			}
			
			/*foreach($item as $key => $valors) {
			
		 $items=$valors;	
		$itemmatricula=substr($items,0,4);
				
				
	
	  }*/
		
		foreach($fecha as $key => $valor) {
				
				$hoy = date('Y-m-d');
				
				
	 $fechavencida=$valor;
	  }
				
			//	foreach($saldoencontra as $key => $valor)
				
				//$hoy = date('Y-m-d');
				
				/*echo"saldoencontra<pre>";
				print_r($fechavencida);
				echo"</pre>";*/
	
	// $fecha=$valor[4];
    

			   if ($fechavencida < $hoy)  
			    {
					
					/*if($fechavencida>2012-06-01)  {
						
						//echo $itemmatricula;
						if($itemmatricula=='0101' || $itemmatricula=='0102'){
						  return true;
						
						 }
						 else{
							  return false;
						 }
				   }*/
				 return false;
				  }
				
				
                //return true;
            }
        }
    return true;
    }


    /*function valida_saldoencontra() {
        if ($this->existe_bloqueo()) {
             $saldoencontra = $this->tomar_saldocontra();
            if ($saldoencontra == 8) { // E.G.R 16.02.2007
                return $saldoencontra;
            } 
            
            else                     // FIN  E.G.R 16.02.2007
            if (is_array($saldoencontra)) {
				
				
                return true;
            }
            
            
            
        }
        return true;
    }*/
    
    
  
    function valida_documentosestudiante() {
        $query_selcarrera = "select e.codigocarrera, eg.codigogenero
		from estudiante e, estudiantegeneral eg
		where e.codigoestudiante = '$this->codigoestudiante'
		and e.idestudiantegeneral = eg.idestudiantegeneral";
        $selcarrera = mysql_query($query_selcarrera, $this->sala) or die("$query_selcarrera" . mysql_error());
        $totalRows_selcarrera = mysql_num_rows($selcarrera);
        $row_selcarrera = mysql_fetch_array($selcarrera);

        // Mira si el estudiante tiene documentos pendientes
        $query_valida = "SELECT *
		FROM documentacion d,documentacionfacultad df
		where d.iddocumentacion = df.iddocumentacion
		and df.codigocarrera = '" . $row_selcarrera['codigocarrera'] . "'
		and df.codigotipoobligatoridaddocumentacionfacultad = '100'
		AND (df.codigogenerodocumento = '300' OR df.codigogenerodocumento = '" . $row_selcarrera['codigogenero'] . "')";
        //echo $query_valida,"<br>";
        $valida = mysql_query($query_valida, $this->sala) or die("$query_valida" . mysql_error());
        $totalRows_valida = mysql_num_rows($valida);
        while ($row_valida = mysql_fetch_assoc($valida)) {
            $query_documentosestuduante = "SELECT *
			FROM documentacionestudiante d,documentacionfacultad df
			where d.codigoestudiante = '$this->codigoestudiante'
			and d.iddocumentacion = '" . $row_valida['iddocumentacion'] . "'
			AND d.codigotipodocumentovencimiento = '100'
			and df.codigotipoobligatoridaddocumentacionfacultad = '100'
			and d.iddocumentacion = df.iddocumentacion
			and d.codigoperiodo = '$this->codigoperiodo'";
            $documentosestuduante = mysql_query($query_documentosestuduante, $this->sala) or die("$query_documentosestuduante" . mysql_error());
            $row_documentosestuduante = mysql_fetch_assoc($documentosestuduante);
            $totalRows_documentosestuduante = mysql_num_rows($documentosestuduante);
            if ($row_documentosestuduante['codigotipodocumentacionfacultad'] == 200 and $row_documentosestuduante['fechavencimientodocumentacionestudiante'] < date("Y-m-d")) {
                return false;
            }
        }
        return true;
    }

    function valida_evaluaciondocenteestudiante() {
        $query_selcarreraeva = "select ec.carrera
		from evaluacioncarrera ec
		where ec.carrera = '" . $this->tomar_carrerabd() . "'";
        //echo "uno $query_selcarreraeva";
        $selcarreraeva = mysql_query($query_selcarreraeva, $this->sala) or die("$query_selcarreraeva" . mysql_error());
        $totalRows_selcarreraeva = mysql_num_rows($selcarreraeva);
        if ($totalRows_selcarreraeva != "") {
            $query_selevaluacion = "select e.codigoestudiante from respuestas e
			where e.codigoestudiante = '$codigoestudiante'";
            //echo "<br>$query_selevaluacion";
            $selevaluacion = mysql_query($query_selevaluacion, $this->sala) or die("$query_selevaluacion" . mysql_error());
            $totalRows_selevaluacion = mysql_num_rows($selevaluacion);
            //echo "$totalRows_selevaluacion<br>";
            if ($totalRows_selevaluacion == "") {
                $query_selprematricula = "select p.codigoestudiante
				from prematricula p, detalleprematricula dp
				where p.codigoestudiante = '$this->codigoestudiante'
				and p.codigoperiodo = '$this->codigoperiodo'
				and dp.idprematricula = p.idprematricula
				and dp.codigoestadodetalleprematricula like '3%'
				and p.codigoestadoprematricula like '4%'";
                //echo "<br>$query_selprematricula";
                $selprematricula = mysql_query($query_selprematricula, $this->sala) or die("$query_selprematricula" . mysql_error());
                $totalRows_selprematricula = mysql_num_rows($selprematricula);
                if ($totalRows_selprematricula != "") {
                    //echo "entroaca";
                    return false;
                }
            }
        }
        return true;
    }

    // Validaciones de anulacion de orden de pago, la cual mira si la orden tiene algun concepto de matricula y es la más reciente
    function valida_esmatricula() {
        // Si la orden tiene concepto de prematricula y es la mas reciente permite anularla
        $query_ordenes = "select d.numeroordenpago, c.codigoconcepto, f.fechaordenpago
		from detalleordenpago d, concepto c, fechaordenpago f
		where d.numeroordenpago = '$this->numeroordenpago'
		and c.codigoconcepto = d.codigoconcepto
		and c.codigoreferenciaconcepto = '100'
		and f.numeroordenpago = d.numeroordenpago
		order by 3 desc";
        //echo $query_ordenes;
        //and dop.codigoconcepto = '151'
        //echo "<h5>$query_ordenes</h5><br>";
        $ordenes = mysql_query($query_ordenes, $this->sala) or die("$query_ordenes<br>" . mysql_error());
        $totalRows_ordenes = mysql_num_rows($ordenes);
        if ($totalRows_ordenes != "") {
            // La orden tiene conceptos de matricula
            // Miro las demás ordenes del estudiante, en caso de haber una orden mayor con concepto de matricula
            // y si esta es la mas nueva no la deja anular
            $row_ordenes = mysql_fetch_array($ordenes);
            $query_otrasordenes = "select o.numeroordenpago
			from ordenpago o, detalleordenpago d, concepto c
			where o.codigoestudiante = '$this->codigoestudiante'
			and o.codigoestadoordenpago not like '2%'
			and o.numeroordenpago = '$this->numeroordenpago'
			and d.codigoconcepto = c.codigoconcepto
			and c.codigoaplicabloqueodeuda = '100'
			and d.numeroordenpago = o.numeroordenpago
			group by 1";
            //echo $query_otrasordenes; and (c.codigoconcepto = '151' or c.codigoconcepto = 'C9013' or c.codigoconcepto = '159')
            //and dop.codigoconcepto = '151'
            //echo "sdasasas <h1>$query_otrasordenes  $totalRows_otrasordenes</h1><br>";
            $otrasordenes = mysql_query($query_otrasordenes, $this->sala) or die("$query_otrasordenes<br>" . mysql_error());
            $totalRows_otrasordenes = mysql_num_rows($otrasordenes);
            if ($totalRows_otrasordenes == "") {
                return false;
            }
        }
        //echo "<h1>Retorna verdad</h1>";
        return true;
    }

    function tieneplanestudio() {
        // Si la orden tiene concepto de prematricula y es la mas reciente permite anularla
        $query_planestudio = "select p.cantidadsemestresplanestudio, e.semestre
		from planestudio p, planestudioestudiante pe, estudiante e
		where pe.idplanestudio = p.idplanestudio
		and e.codigoestudiante = pe.codigoestudiante
		and e.codigoestudiante = '$this->codigoestudiante'";
        //and dop.codigoconcepto = '151'
        //echo "<h5>$query_ordenes</h5><br>";
        $planestudio = mysql_query($query_planestudio, $this->sala) or die("$query_planestudio<br>" . mysql_error());
        $totalRows_planestudio = mysql_num_rows($planestudio);
        if ($totalRows_planestudio != "") {
            $row_planestudio = mysql_fetch_assoc($planestudio);
            if ($row_planestudio['cantidadsemestresplanestudio'] > $row_planestudio['semestre']) {
                return $row_planestudio['semestre'] + 1;
            } else {
                return $row_planestudio['semestre'];
            }
        } else {
            return false;
        }
    }

    /*     * *********************************************************************************************************************** */
    /*     * ************************************************* */

//													//
//			ANULAR ORDEN DE PAGO					//
//													//
    /*     * ************************************************* */
    /*     * *********************************************************************************************************************** */
    function anular_ordenpago() {
        $base1 = "update ordenpago set  codigoestadoordenpago = 20
		where codigoestudiante ='$this->codigoestudiante'
		and numeroordenpago = $this->numeroordenpago";
        $sol1 = mysql_query($base1, $this->sala) or die("$base1<br>" . mysql_error());

        // Cada vez que se anule una orden de pago guardar en logordenpago si existe sesión de usuario
        if (isset($_SESSION['MM_Username'])) {
            $query_id = "select idusuario
            from usuario
            where usuario = '" . $_SESSION['MM_Username'] . "'";
            $id = mysql_query($query_id, $this->sala) or die("$query_id <br>" . mysql_error());
            $row_id = mysql_fetch_array($id);

            $idusuario = $row_id['idusuario'];

            $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
            VALUES(0, now(), 'ANULACION', '$this->numeroordenpago', '$idusuario', '" . tomarip() . "')";
            //echo "<br>uno".$query_inslogordenpago;
            $query_inslogordenpago = mysql_query($query_inslogordenpago, $this->sala) or die("$query_inslogordenpago <br>" . mysql_error());
        } else {
            $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
            VALUES(0, now(), 'ANULACION', '$this->numeroordenpago', '2', '" . tomarip() . "')";
            //echo "<br>uno".$query_inslogordenpago;
            $query_inslogordenpago = mysql_query($query_inslogordenpago, $this->sala) or die("$query_inslogordenpago <br>" . mysql_error());
        }


        $query_seldetalleprematriculaorden = "select idprematricula, codigomateria, idgrupo, codigomateriaelectiva, codigotipodetalleprematricula, numeroordenpago
		from detalleprematricula
		WHERE numeroordenpago = '$this->numeroordenpago'";
        $seldetalleprematriculaorden = mysql_query($query_seldetalleprematriculaorden, $this->sala) or die("$query_seldetalleprematriculaorden");
        //$row_seldetalleprematriculacambiogrupo = mysql_fetch_array($seldetalleprematriculacambiogrupo);
        $totalRows_seldetalleprematriculaorden = mysql_num_rows($seldetalleprematriculaorden);
        if ($totalRows_seldetalleprematriculaorden != "") {
            while ($row_seldetalleprematriculaorden = mysql_fetch_array($seldetalleprematriculaorden)) {
                $query_inslogdetalleprematricula = "INSERT INTO logdetalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago, fechalogfechadetalleprematricula, usuario, ip)
				VALUES('" . $row_seldetalleprematriculaorden['idprematricula'] . "','" . $row_seldetalleprematriculaorden['codigomateria'] . "','" . $row_seldetalleprematriculaorden['codigomateriaelectiva'] . "','20','" . $row_seldetalleprematriculaorden['codigotipodetalleprematricula'] . "','" . $row_seldetalleprematriculaorden['idgrupo'] . "','" . $row_seldetalleprematriculaorden['numeroordenpago'] . "','" . date("Y-m-d H:i:s", time()) . "','" . $_SESSION['MM_Username'] . "','" . tomarip() . "')";
                $inslogdetalleprematricula = mysql_query($query_inslogdetalleprematricula, $this->sala) or die("$query_inslogdetalleprematricula");
            }
        }

        $base3 = "UPDATE detalleprematricula SET codigoestadodetalleprematricula = '20'
		WHERE numeroordenpago = '$this->numeroordenpago'";
        //echo "<br> $base3 <br>";
        $sol3 = mysql_query($base3, $this->sala) or die("$base3<br>" . mysql_error());

        /*         * ***************** CALCULO DEL SEMESTRE Y CREDITOS TOMADOS DE DETALLEPLANESTUDIO *************************************** */
        // 1. Selecciona las materias que tiene en detalleprematricula, sin electivas
        $usarcondetalleprematricula = true;
        $this->calculocreditossemestre($semestrecalculado, $creditoscalculados);

        $query_updprematricula = "UPDATE prematricula p
		SET p.semestreprematricula='$semestrecalculado'
		WHERE p.codigoestudiante = '$this->codigoestudiante'
		and p.codigoperiodo = '$this->codigoperido'";
        //echo "<br>$query_updprematricula";
        $updprematricula = mysql_query($query_updprematricula, $this->sala) or die(mysql_error());

        /*         * ****************** FIN DE CALCULO SEMESTRE Y CREDITOS ************************************** */

        // Actualiza los matriculados de todos los grupos
        $base2 = "select idgrupo
		from detalleprematricula d
		where d.numeroordenpago = '$this->numeroordenpago'";
        $sol2 = mysql_query($base2, $this->sala) or die("$base2<br>" . mysql_error());

        while ($row_sol2 = mysql_fetch_array($sol2)) {
            $idgrupo = $row_sol2['idgrupo'];
            actualizarmatriculados($idgrupo, $this->codigoperiodo, $this->tomar_carrerabd(), $this->sala);
        }
    }

    function calculocreditossemestre(&$semestrecalculado, &$creditoscalculados, $usarcondetalleprematricula=true) {
        require("calculocreditossemestre.php");
    }

    // Mira si estan los bancos para generar oden de pago
    function tiene_cuentabancoorden() {
        $query_cuentabanco = "SELECT c.numeroordenpago
		FROM cuentabancoordenpago c
		WHERE  c.numeroordenpago = '$this->numeroordenpago'";
        //echo "$query_bancos<br>";
        //and dop.codigoconcepto = '151'
        $cuentabanco = mysql_query($query_cuentabanco, $this->sala) or die("$query_cuentabanco<br>" . mysql_error());
        $totalRows_cuentabanco = mysql_num_rows($cuentabanco);
        if ($totalRows_cuentabanco == "") {
            return false;
        }
        return true;
    }

}

/* * *********************************************************************************************************************** */
/* * ************************************************* */
//													//
//			CLASE ORDENESTUDIANTE					//
//													//
/* * ************************************************* */
/* * *********************************************************************************************************************** */

require("claseordenestudiante.php");
?>
  
