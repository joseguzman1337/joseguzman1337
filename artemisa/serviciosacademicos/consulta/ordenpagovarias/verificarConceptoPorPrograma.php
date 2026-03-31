<?php
/**
 * VERIFICAR SI EL CONCEPTO QUE LLEGA SE ENCUENTRA RELACIONADO A LA CARRERA/PROGRAMA
 */

require_once(__DIR__ .'/../../../sala/includes/adaptador.php' );
require_once (__DIR__ . '/../../funciones/phpmailer/class.phpmailer.php');


/**
 * Se ejecuta desde la llamada Asincrona apartir del archivo ./conceptosxreferencia.php
 */
if (@$_GET['accion'] == 'verificarConcepto'){

    @session_start();

    $idConcepto = @$_GET['idconcepto'];
    $idCodigoEstudiante = @$_GET['idCodigoEstudiante'];

    $objVerificarConcepto = new VerificarConcepto($idConcepto, $idCodigoEstudiante, $db);
    $resultado = $objVerificarConcepto->generarVerificacion();

    echo VerificarConcepto::impresionJSON($resultado, $resultado['status']);

}





/**
 * Clase para la verificación y respuesta de vinculo entre concepto y programa
 *
 * Class VerificarConcepto
 */
class VerificarConcepto
{

    /**
     * @var string
     */
    private $idConcepto;

    /**
     * @var
     */
    private $idCodigoEstudiante;

    /**
     * @var array
     * <p>Almacena los vinculos que se obtengan del query ejecutado</p>
     */
    private $vinculo;

    /**
     * @var adodb Object
     */
    private $connectDB;

    const STATUS_WITH_LINK = 'Con Vinculo';         // Programa con vinculo
    const STATUS_WITHOUT_LINK = 'Sin Vinculo';      // Programa sin vinculo
    const STATUS_FAILED = 'Falla en el proceso';    // Falla en el proceso

    public function __construct($idConcepto, $idCodigoEstudiante, $db)
    {
        $this->idConcepto = $idConcepto;
        $this->idCodigoEstudiante = $idCodigoEstudiante;

        $this->connectDB = $db;
        $this->connectDB->setFetchMode(ADODB_FETCH_ASSOC);
    }

    /**
     * Verificar e imprimir vinculo entre programa y concepto de pago
     *
     * @return array
     */
    public function generarVerificacion()
    {

        // variable para almacenar notificacion si se produce envío de correo
        $notificacionSMS = 'Sin envio de correo';

        try{

            // Validar si la consulta arroja por lo menos una coincidencia
            if($this->consultarVinculo())
            {
                // Validar si viene el programa pero sin vinculo
                if (empty($this->vinculo['codigoconcepto']))
                {
                    $status = static::STATUS_WITHOUT_LINK;
                    $notificacionSMS = $this->envioCorreo();
                }
                else
                {
                    $status = static::STATUS_WITH_LINK;
                }

            }
            else
                $status = static::STATUS_WITHOUT_LINK;

            $resultado = $this->resultados($status);
            $resultado['envioNotificacion'] = $notificacionSMS;

            return $resultado;

        }catch (Exception $e)
        {

            $this->vinculo['error'] = array(
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message' => $e->getMessage()
            );

            return $this->resultados(static::STATUS_FAILED);

        }
    }

    /**
     * Busqueda de registros en BD
     *
     * @return bool
     * @throws Exception
     */
    private function consultarVinculo()
    {

        $sentencias = $this->obtenerSenteciasMYSQL(__DIR__ . "/sentenciasSQL.json");
        $sentencia = $sentencias['sentencias']['sentencia_01']['sql'];
        $sentencia = vsprintf($sentencia, array($this->idConcepto, $this->idCodigoEstudiante));
        $this->vinculo = $this->connectDB->Execute($sentencia)->FetchRow();

        // Retorna true si el arreglo es diferente a vacio
        return (! empty($this->vinculo));

    }

    /**
     * Función para la lectura y retorno de sentencias MYSQL's
     *
     * @param string $pathArchivo
     * @return array
     * @throws Exception
     */
    private function obtenerSenteciasMYSQL($pathArchivo)
    {

        if (! file_exists($pathArchivo)) throw new \Exception('No se encuntra el archivo de sentencias : ' . $pathArchivo);

        $archivoSentencias = file_get_contents( $pathArchivo );
        $sentencias = json_decode($archivoSentencias, true);

        if ($sentencias == null) throw new \Exception('Error en la estructura del archivo : ' . $pathArchivo);

        return $sentencias;

    }

    /**
     * Impresión y retorno de resultados
     *
     * @param $status
     * @return array
     */
    public function resultados($status)
    {

        $contenidoRespuesta = array(
            'status' => $status,
            'vinculo' => $this->vinculo,
            'envioNotificacion' => null
        );

        return $contenidoRespuesta;

    }

    /**
     * @return array
     * @throws phpmailerException
     */
    public function envioCorreo()
    {

        $mail = new PHPMailer();
        $mail->From = 'UNIVERSIDAD EL BOSQUE';
        $mail->FromName = 'UNIVERSIDAD EL BOSQUE';
        $mail->ContentType = "text/html";
        $mail->Subject = 'Error en creación orden pago';

        //aquí en $cuerpo se guardan, el encabezado(carreta) y la firma
        $mail->Body = 'Error al crear orden de pago: ';
        $mail->Body .= '<br> Origina: serviciosacademicos/consulta/ordenpagovarias/verificarConceptoPorPrograma.php :' . __LINE__;
        $mail->Body .= '<br> Data : <pre>' . json_encode($this->vinculo) . '</pre>';

        $mail->AddAddress("castanedamiguel@unbosque.edu.co");
        $mail->AddAddress("quinterioivan@unbosque.edu.co");

        return array('status' => $mail->Send(),'error' => $mail->ErrorInfo);

    }

    /**
     * @param $content
     * @param $status
     * @return string
     */
    public static function impresionJSON($content, $status)
    {

        /* Verificamos si hay ajax  */
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            if ($status == static::STATUS_FAILED)
                header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

            header('Content-Type: application/json');

        }

        return json_encode($content);

    }

}