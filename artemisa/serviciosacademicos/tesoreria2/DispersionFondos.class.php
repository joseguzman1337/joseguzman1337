<?php

/* $líneas = file('inicial.txt');
  if($linea == false)
  echo "QUE??";
 * print_r($lineas);
  var arregloarchivo = array();
  var nombrearchivo = 'inicial.txt';
 */

class RegistroDispersionFondos {

    var $secuencia;
    var $secuenciaproveedor;
    var $fechamovimientoproveedor;
    var $nitproveedor;
    var $nombreproveedor;
    var $codigobanco;
    var $tipocuenta;
    var $numerocuenta;
    var $tipotransaccion;
    var $valor;
    var $observacion;
    var $secuenciaxregistro;
    var $nitcliente;
    var $numerocuentacliente;
    var $tipocuentacliente;
    var $tipooperacioncliente;

    function RegistroDispersionFondos($registro) {
        $this->secuencia = substr($registro, 0, 5);
        $this->secuenciaproveedor = substr($registro, 5, 5);
        $this->fechamovimientoproveedor = substr($registro, 10, 6);
        $this->nitproveedor = substr($registro, 16, 15);
        $this->nombreproveedor = substr($registro, 31, 22);
        $this->codigobanco = substr($registro, 53, 2);
        $this->tipocuenta = substr($registro, 55, 2);
        $this->numerocuenta = substr($registro, 57, 17);
        $this->tipotransaccion = substr($registro, 74, 2);
        $this->valor = substr($registro, 76, 10);
        $this->observacion = substr($registro, 86, 65);
        $this->secuenciaxregistro = substr($registro, 151, 2);
        $this->nitcliente = substr($registro, 153, 15);
        $this->numerocuentacliente = substr($registro, 168, 17);
        $this->tipocuentacliente = substr($registro, 185, 2);
        $this->tipooperacioncliente = substr($registro, 187, 2);
    }

}

class DispersionFondos {

    var $nombrearchivo;
    var $lineas = array();

    function DispersionFondos($nombrearchivo = 'inicial.txt') {
        $this->nombrearchivo = $nombrearchivo;
    }

    function setCargarregistros() {
        $handle = @fopen($this->nombrearchivo, "r");
        if ($handle) {
            while (!feof($handle)) {
                $lineas = fgets($handle, 4096);
                if ($lineas != '') {
                    $registro = new RegistroDispersionfondos($lineas);
                    if(isset($_REQUEST['fecha']) && $_REQUEST['fecha'] != '') {
                        $mes = substr ($_REQUEST['fecha'], 5, 2);
                        $dia = substr ($_REQUEST['fecha'], 8, 2);
                        $ano = substr ($_REQUEST['fecha'], 2, 2);
                        //echo $_REQUEST['fecha']."<br>mes $mes, dia $dia, año $ano<br>";
                        $registro->fechamovimientoproveedor = $mes.$dia.$ano;
                    }
                    $registro->tipocuentacliente = 'CC';
                    $this->lineas[] = $registro;
                }
            }
            fclose($handle);
        }
    }

    function imprimirRegistros() {
        foreach ($this->lineas as $registro) {
            //echo "<pre>";
            //print_r($registro);
            $vars_registro = get_class_vars(get_class($registro));
            //echo "<pre>"; print_r($vars_registro); echo "</pre>";
            foreach ($vars_registro as $nombre => $valor) {
                echo $registro->$nombre;
            }
            echo "\r\n";
        }
    }

    function modificarRegistros() {

    }

}

/* $nuevadispersion = new DispersionFondos();
  $nuevadispersion->setCargarregistros();
  $nuevadispersion->imprimirRegistros(); */
?>