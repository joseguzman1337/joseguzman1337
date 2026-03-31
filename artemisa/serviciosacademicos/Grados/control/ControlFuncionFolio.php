<?php

/**
 * Ivan Dario Quintero rios <quinteroivan@unbosque.edu.co>
 * Ajustes de linea eliminacion de texto basusa "echo"
 * Agosto 3, 2017
 */
include '../control/ControlFolio.php';
include '../control/ControlFolioTemporal.php';
include '../control/ControlDetalleRegistroGradoFolio.php';
include '../control/ControlIncentivoAcademico.php';

class ControlFuncionFolio extends FPDF {

    /**
     * @type Singleton
     * @access private
     */
    private $persistencia;

    /**
     * @type boolean
     * @access private
     */
    private $previsualizacion;

    /**
     * @type String
     * @access private
     */
    private $array_registrograduadofolio = array();

    /**
     * Modifica el estado de la previsualizacion
     * @param $previsualizacion boolean
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     */
    public function setPrevisualizacion($previsualizacion) {
        $this->previsualizacion = $previsualizacion;
    }

    /**
     * Retorna el estado de la previsualizacion
     * @access public
     * @return previzualizacion
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     */
    public function getPrevisualizacion() {
        return $this->previsualizacion;
    }

    /**
     * @type FDPF
     * @access private
     */
    //private $nuevo_registrograduadofolio;

    /**
     * Constructor
     * @param Singleton $persistencia
     * @access public
     */
    public function ControlFuncionFolio($persistencia) {
        $this->persistencia = $persistencia;
    }

    function directivo() {
        $controlDirectivo = new ControlDirectivo($this->persistencia);
        $directivo = $controlDirectivo->buscarSecretarioGeneral();
        return $directivo->getNombreDirectivo();
    }

    function anioActual() {

        /* Modified Diego Rivera <riveradiego@unbosque.edo.co>
         * Se añade  validacion de años respecto al dia  y mes     
          codigo anterior  $anioActual = "20".date("y", fechaActual( ));
          return $anioActual;
         */


        $dia = date("j");
        $anio = date("Y");
        $mes = date("m");

        if ($dia <= 31 and $mes == 1) {
            $anioActual = $anio - 1;
        } else {
            $anioActual = $anio;
        }

        return $anioActual;
    }

    /**
     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Se hacen ajustes para que la foliacion quede compatible con el papel membrete.
     * @since Febrero 20, 2019
     */
    function Header() {
        if ($this->getPrevisualizacion()) {
            $this->Image("../../consulta/facultades/graduar_estudiantes/mantenimiento_folios/pre.jpg", 65, 130, 100, 20);
        }

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(7);
        $this->Cell(186, 5, 'FOLIO No. ' . $this->contador_paginas, 0, 1, 'R');
        $this->Cell(7);
        if ($this->contador_paginas == '727') {
            $this->Ln(8);
        } else {
            $this->Ln(12);
        }
        $this->Ln(18); //
        $this->Cell(7);
        if ($this->contador_paginas == '727') {
            $this->Cell(190, 4, utf8_decode("REGISTRO DE TITULOS AÑO " . $this->anioActual() . ""), 0, 0, 'L');
        } else {
            $this->Cell(190, 6, utf8_decode("REGISTRO DE TITULOS AÑO " . $this->anioActual() . " "), 0, 0, 'L');
        }
        $this->Ln(8);
        $this->Cell(7);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 10, 'REG. No', 1, 0, 'C');
        $this->Cell(86, 10, 'NOMBRE DEL GRADUADO', 1, 0, 'C');
        $this->Cell(65, 5, 'DOCUMENTO DE IDENTIDAD', 1, 1, 'C');
        $this->Cell(108);
        $this->Cell(20, 5, 'NUMERO', 1, 0, 'C');
        $this->Cell(45, 5, 'LUGAR DE EXPEDICION', 1, 0, 'C');
        if ($this->contador_paginas == '727') {
            $this->SetXY(183, 46);
        } else {
            $this->SetXY(183, 50);
        }
        $this->Cell(20, 10, 'No. DIPLOMA', 1, 1, 'C');
        $this->Ln(4);
    }

    function Footer() {
        $this->SetY(-39);
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 7);
        $nombre = $this->directivo();
        $cargodirectivo = strtoupper("SECRETARIA GENERAL");
        $this->Cell(7);
        $this->Cell(190, 5, $nombre, 0, 1, 'L');
        $this->Cell(7);
        $this->Cell(190, 3, $cargodirectivo, 0, 0, 'L');
    }

    /**
     * Funcion Folio FPDF
     * @param $pdf, $carrera, $titulo, $estudiante, $registroGrados, $directivo
     * @access public
     * @return PDF
     */
    function folioPDF($registroGrados, $idPersona, $controlRegistroGrado, $previsualizacion = true) {
        $this->setPrevisualizacion($previsualizacion);
        $controlFolio = new ControlFolio($this->persistencia);
        $controlIncentivoAcademico = new ControlIncentivoAcademico($this->persistencia);
        $controlFolioTemporal = new ControlFolioTemporal($this->persistencia);
        $controlFechaGrado = new ControlFechaGrado($this->persistencia);
        $controlDetalleRegistroGradoFolio = new ControlDetalleRegistroGradoFolio($this->persistencia);

        $nuevo_registrograduadofolio = $controlFolio->buscarMaximoFolio();
        $this->FPDF('P', 'mm', 'Letter', $nuevo_registrograduadofolio);

        $array_incentivos_impresos = array();

        $this->SetTopMargin(7);
        $this->SetAutoPageBreak(true, 45);
        $this->AddPage();
        $this->SetFont('Arial', '', 8);
        $contador_armado_arreglo = 0;
        $y_general = $this->GetY();
        $codigocarrera_ini = "";
        $numeropromocion_ini = "";
        $numeroacta_ini = "";
        $numeroacuerdo_ini = "";
        $fechagrado_ini = "";
        $contador = -1;
        $contador_limite = count($registroGrados);
        $contador_busca_incentivos = 0;
        $array_acumulativo = 0;

        $conteoLineasMachete709 = 0;
        reset($registroGrados);
        $txtFechaGrados = array();
        $numerofolio = 0;



        foreach ($registroGrados as $registroGrad) {

            $txtCodigoCarrera = $registroGrad->getActaAcuerdo()->getFechaGrado()->getCarrera()->getCodigoCarrera();
            $txtFechaGrado = $registroGrad->getActaAcuerdo()->getFechaGrado()->getIdFechaGrado();
            $txtNumeroacuerdo = $registroGrad->getActaAcuerdo()->getnumeroAcuerdo();
            $txtCodigoModalidadAcademicaSic = $registroGrad->getActaAcuerdo()->getFechaGrado()->getCarrera()->getModalidadAcademicaSic()->getCodigoModalidadAcademicaSic();
            /** CONSULTA LOS ESTUDIANTES PARA GRADO POR EL CODIGOCARRERA Y NUMER DE ACUERDO * */
            $estudiantes = $controlRegistroGrado->consultarRegistroGradoFolio($txtCodigoCarrera, $txtNumeroacuerdo);


            /*             * * INICIO DE DIPLOMAS  * */
            foreach ($estudiantes as $registroGrado) {

                $numeroAcuerdo = $registroGrado->getActaAcuerdo()->getNumeroAcuerdo();
                if (
                        $registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getCodigoCarrera() != $codigocarrera_ini or
                        $registroGrado->getActaAcuerdo()->getNumeroActaConsejoDirectivo() != $numeroacta_ini or
                        $registroGrado->getActaAcuerdo()->getNumeroAcuerdo() != $numeroacuerdo_ini
                ) {

                    $buscarincentivos = true;
                    $promocion = strtoupper($registroGrado->getNumeroPromocion());
                    if (empty($promocion)) {
                        $promocion = 'NO APLICA';
                    }

                    /** CONSULTA EL TITULO QUE SE LE OTORGA A LOS ESTUDIANTES DE LA CARRERA* */
                    $titulo = strtoupper($registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getTituloProfesion()->getNombreTitulo());
                    $nombrecarrera = strtoupper($registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getNombreCarrera());

                    $this->Ln(3);

                    $this->Cell(7);
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell(186, 7, "PROGRAMA: " . substr(utf8_decode($nombrecarrera), 0, 100), 1, 1, 'C');
                    $this->SetFont('Arial', '', 7);
                    $this->Cell(7);
                    $this->Cell(186, 7, "TITULO: " . utf8_decode($titulo), 1, 1, 'L');
                    $this->Cell(7);
                    $this->Cell(44, 7, "PROMOCION:" . $promocion, 1, 0, 'L');
                    $this->Cell(49, 7, "ACTA: " . $registroGrado->getActaAcuerdo()->getNumeroActaConsejoDirectivo() . "   FECHA: " . date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo())), 1, 0, 'L');
                    $this->Cell(54, 7, "ACUERDO: " . $registroGrado->getActaAcuerdo()->getNumeroAcuerdo() . "  FECHA: " . date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo())), 1, 0, 'L');
                    $this->Cell(39, 7, "FECHA GRADO: " . date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo())), 1, 1, 'L');

                    $buscarincentivos = false;
                } else {
                    $buscarincentivos = false;
                }
                $this->Cell(7);
                $expedicion = substr(strtoupper(utf8_decode($registroGrado->getEstudiante()->getExpedicion())), 0, 27);

                if ($registroGrado->getEstadoGrado() == 200) {
                    $this->Cell(15, 7, $registroGrado->getIdRegistroGrado(), 1, 0, 'C');
                    $this->Cell(86, 7, "ANULADO", 1, 0, 'L');
                    $this->Cell(20, 7, "ANULADO", 1, 0, 'C');
                    $this->Cell(45, 7, "ANULADO", 1, 0, 'C');
                    $this->Cell(20, 7, "ANULADO", 1, 1, 'C');
                } else {
                    $this->Cell(15, 7, $registroGrado->getIdRegistroGrado(), 1, 0, 'C');
                    $this->Cell(86, 7, utf8_decode($registroGrado->getEstudiante()->getNombreEstudiante()), 1, 0, 'L');
                    $this->Cell(20, 7, $registroGrado->getEstudiante()->getNumeroDocumento(), 1, 0, 'C');
                    $this->Cell(45, 7, $expedicion, 1, 0, 'C');
                    $this->Cell(20, 7, $registroGrado->getNumeroDiploma(), 1, 1, 'C');
                    if ($this->getPrevisualizacion()) {
                        /** CREA EL FOLIO TEMPORAL * */
                        $controlFolioTemporal->insertarFolioTemporal($registroGrado->getIdRegistroGrado(), $this->contador_paginas);
                    } else {
                        if ($this->contador_paginas != $numerofolio) {
                            /**  ACTUALIZA EL FOLIO DEL GRADUADO * */
                            $controlFolio->actualizarFolioGraduado($this->contador_paginas, $idPersona);
                            $numerofolio = $this->contador_paginas;
                        }
                        /** ACTUALIZA EL DETALLE DEL FOLIO * */
                        $controlDetalleRegistroGradoFolio->actualizarFolioDetalleRegistro($this->contador_paginas, $registroGrado->getIdRegistroGrado());
                    }
                }

                /** CREA LAS VARIABLES TEMPORALES PARA COMPARACION * */
                $codigocarrera_ini = $registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getCodigoCarrera();
                $numeropromocion_ini = $registroGrado->getNumeroPromocion();
                $numeroacta_ini = $registroGrado->getActaAcuerdo()->getNumeroActaConsejoDirectivo();
                $numeroacuerdo_ini = $registroGrado->getActaAcuerdo()->getNumeroAcuerdo();

                $contador_armado_arreglo++;
                $contador_busca_incentivos++;
            }
            /** FIN DE LISTADO DE DIPLOMAS ** */
            /** INICIO LISTADO DE INCENTIVOS  * */
            //Si es una carrera de pregrado

            /* Modified Diego Rivera<riveradiegounbosque.edu.co>
             * Se inicializan variable $txtIncentivoIdMagna debido a que no encuentra las variables si no ingresa a la condicion lo cual genera error , s
             * se incializar array vacio $incentivosGHM = array();  con el fin de que su valor si no existe la condicion sea igual a cero y realice de forma correcta las validaciones
             * SInce octuber 4 ,2017  
             */
            $txtIncentivoIdMagna = '';
            $incentivosGHM = array();
            //fin modificación

            if ($txtCodigoModalidadAcademicaSic == 200) {
                $txtIncentivoId = 2;
                $txtIncentivoIdOtro = 3;
                $nombreIncentivo1 = "Mención de Honor";
                $nombreIncentivo2 = "Grado de Honor";
            }

            //si es una carrera de postgrado - especializacion
            if ($txtCodigoModalidadAcademicaSic == 300) {
                $txtIncentivoId = 4;
                $txtIncentivoIdOtro = 9;
                $nombreIncentivo1 = "Mención de Meritorio";
                $nombreIncentivo2 = "Mención de Honor";
            }
            //Si es una carrera de postgrado - maestria
            if ($txtCodigoModalidadAcademicaSic == 301) {
                $nombreIncentivo1 = "Mención de Meritorio";
                $txtIncentivoId = 4;
                //si la carrera es MAESTRIA EN BIOETICA o MAESTRIA EN CIENCIAS BASICAS BIOMEDICAS
                if ($txtCodigoCarrera == 70 || $txtCodigoCarrera == 260) {
                    $txtIncentivoIdOtro = 8;
                    $nombreIncentivo2 = "Mención Laureada";
                } else {
                    $txtIncentivoIdOtro = 9;
                    $nombreIncentivo2 = "Mención de Honor";
                }
            }
            //si es una carrera de postgrado - Doctorado
            if ($txtCodigoModalidadAcademicaSic == 302) {
                $txtIncentivoId = 5;
                $txtIncentivoIdOtro = 7;
                $txtIncentivoIdMagna = 6;
                $nombreIncentivo1 = "Mención Cum Laude";
                $nombreIncentivo2 = "Mención Summa Cum Laude";
                $nombreIncentivo3 = "Mención Magna Cum Laude";
            }
            /*             * *  FIN LISTADO DE INCENTIVOS ** */

            /*             * ** INICIO DE LOS TITULOS DE LOS INCENTIVOS ** */

            $incentivos = $controlRegistroGrado->consultarRegistroGradoIncentivo($txtFechaGrado, $numeroAcuerdo, $txtCodigoCarrera);
            $incentivosMH = $controlRegistroGrado->consultarRegistroGradoIncentivoMH($txtFechaGrado, $numeroAcuerdo, $txtCodigoCarrera, $txtIncentivoId);
            $incentivosGH = $controlRegistroGrado->consultarRegistroGradoIncentivoGH($txtFechaGrado, $numeroAcuerdo, $txtCodigoCarrera, $txtIncentivoIdOtro);

            if ($txtIncentivoIdMagna == 6) {
                /* Modified Diego Rivera <riveradiego@unbosque.edu.co>
                 * se modifica parametro  $txtIdAcuerdoActa por $numeroAcuerdo
                 * Since august 27,2018
                 */
                $incentivosGHM = $controlRegistroGrado->consultarRegistroGradoIncentivoGH($txtFechaGrado, $numeroAcuerdo, $txtCodigoCarrera, $txtIncentivoIdMagna);
            }
            /**
             * @Modified Diego Rivera<riveradiego@unbosque.edu.co>
             * Se agrega validacion con el fin asignar nombre de incentivo(Mencion de meritorio el cual no estaba contemplado para doctorado) cuando cumpla la condicion, 
             * los doctorados solo tienen un incentivo
             * @since March 5,2019 
             */
            if ($txtCodigoModalidadAcademicaSic == 302 and count($incentivosMH) == 0 and count($incentivosGH) == 0 and count($incentivosGHM) == 0) {
                $nombreIncentivo3 = "Mención de Meritorio";
                $incentivosGHM = $controlRegistroGrado->consultarRegistroGradoIncentivoGH($txtFechaGrado, $numeroAcuerdo, $txtCodigoCarrera, 4);
            }

            if (count($incentivos) != 0) {
                $y_incentivo = $this->GetY();

                /**
                 * @modified Diego Rivera <riveradeigo@unbosque.edu.co>
                 * Se elimina validadicion  bloqueaba la folicion quedando en ciclo infinito
                 *  if ($y_incentivo >= 219) {
                  $this->SetFont('Arial', 'B', 9);
                  do {
                  $y_pos = $this->GetY();
                  $this->Cell(7);
                  $this->Cell(186, 3, '', 'C', 1);
                  } while ($y_pos < 235);
                  }
                 * @since July 23,2019  
                 */
                $this->Ln(4);
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(7);
                //sí existen tres incentivos caso 1
                if (count($incentivosMH) != 0 && count($incentivosGH) != 0 && count($incentivosGHM) != 0) {
                    $this->Cell(93, 6, utf8_decode($nombreIncentivo1), 1, 0, 'C');
                    $this->Cell(93, 6, utf8_decode($nombreIncentivo3), 1, 1, 'C');
                   

                    $this->Cell(7);
                    $this->SetFont('Arial', '', 7);
                    $this->Cell(18.5, 6, "Acta: " . $incentivosMH[0]->getIncentivoAcademico()->getNumeroActaAcuerdoIncentivo(), 1, 0);
                    $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosMH[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 0);
                    $this->SetFont('Arial', '', 6);
                    $this->Cell(19.5, 6, "Acuerdo: " . $incentivosMH[0]->getIncentivoAcademico()->getNumeroAcuerdoIncentivo(), 1, 0);
                    $this->SetFont('Arial', '', 7);
                    $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosMH[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 0);

                    $this->Cell(18.5, 6, "Acta: " . $incentivosGH[0]->getIncentivoAcademico()->getNumeroActaAcuerdoIncentivo(), 1, 0);
                    $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosGH[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 0);
                    $this->SetFont('Arial', '', 6);
                    $this->Cell(19.5, 6, "Acuerdo: " . $incentivosGH[0]->getIncentivoAcademico()->getNumeroAcuerdoIncentivo(), 1, 0);
                    $this->SetFont('Arial', '', 7);
                    $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosGH[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 1);

                    foreach ($incentivos as $incentivoMH) {
                        if ($incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 2 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 4 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 5) {
                            $this->Cell(7);
                            if ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                //caso5
                                if (count($incentivosMH) != 0 && count($incentivosGH) != 0 && count($incentivosGHM) != 0) {
                                    $this->Cell(93, 6, utf8_decode($incentivoMH->getEstudiante()->getNombreEstudiante()), 1, 0, 'C');
                                }
                            } elseif ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                $this->Cell(93, 6, $incentivoMH->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 0, 'C');
                            }
                        }
                    }

                    foreach ($incentivos as $incentivosGHMM) {
                        if ($incentivosGHMM->getIncentivoAcademico()->getCodigoIncentivo() == 6) {
                            if ($incentivosGHMM->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                //caso7
                                if (count($incentivosMH) != 0 && count($incentivosGH) != 0 && count($incentivosGHM) != 0) {
                                    $this->Cell(93, 6, utf8_decode($incentivosGHMM->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                }
                            } elseif ($incentivosGHMM->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                $this->Cell(93, 6, $incentivosGHMM->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                            }
                        }
                    }
                    $this->Ln(4);
                    $this->Cell(7);

                    $this->SetFont('Arial', 'B', 9);
                    $this->Cell(186, 6, utf8_decode($nombreIncentivo2), 1, 1, 'C');
                    $this->SetFont('Arial', '', 7);

                    $this->Cell(7);
                    $this->Cell(18.5, 6, "Acta: " . $incentivosGHM[0]->getIncentivoAcademico()->getNumeroActaAcuerdoIncentivo(), 1, 0);
                    $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosGHM[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 0);
                    $this->SetFont('Arial', '', 6);
                    $this->Cell(19.5, 6, "Acuerdo: " . $incentivosGHM[0]->getIncentivoAcademico()->getNumeroAcuerdoIncentivo(), 1, 0);
                    $this->SetFont('Arial', '', 7);
                    $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosGHM[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 1);

                    foreach ($incentivos as $incentivoGH) {
                        if ($incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 3 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 9 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 8 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 7) {
                            //la siguiente linea indica que se muestra a partir del centro de la hoja

                            if ($incentivoGH->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                $this->Cell(7);
                                $this->Cell(93, 6, utf8_decode($incentivoGH->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                            } elseif ($incentivoGH->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                $this->Cell(93, 6, $incentivoGH->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                            }
                        }
                    }
                    
                    
                }
                
                
                //sí existen dos incentivos caso 2
                if (count($incentivosMH) != 0 && count($incentivosGH) != 0 && count($incentivosGHM) == 0) {
                    $this->Cell(93, 6, utf8_decode($nombreIncentivo1), 1, 0, 'C');
                    $this->Cell(93, 6, utf8_decode($nombreIncentivo2), 1, 1, 'C');
                }
                //sí existen dos incentivos caso 3
                if (count($incentivosMH) == 0 && count($incentivosGH) != 0 && count($incentivosGHM) != 0) {
                    $this->Cell(93, 6, utf8_decode($nombreIncentivo2), 1, 0, 'C');
                    $this->Cell(93, 6, utf8_decode($nombreIncentivo3), 1, 1, 'C');
                }
                //sí existen dos incentivos caso 4
                if (count($incentivosMH) != 0 && count($incentivosGH) == 0 && count($incentivosGHM) != 0) {
                    $this->Cell(93, 6, utf8_decode($nombreIncentivo1), 1, 0, 'C');
                    $this->Cell(93, 6, utf8_decode($nombreIncentivo3), 1, 1, 'C');
                }
                //sí existe un incentivo caso 5
                if (count($incentivosMH) != 0 && count($incentivosGH) == 0 && count($incentivosGHM) == 0) {
                    $this->Cell(93, 6, utf8_decode($nombreIncentivo1), 1, 0, 'C');
                    $this->Cell(93, 6, "", 1, 1, 'C');
                }
                //sí existe un incentivo caso 6
                if (count($incentivosGH) != 0 && count($incentivosMH) == 0 && count($incentivosGHM) == 0) {
                    $this->Cell(93, 6, utf8_decode($nombreIncentivo2), 1, 0, 'C');
                    $this->Cell(93, 6, "", 1, 1, 'C');
                }
                //sí existe un incentivo caso 7
                if (count($incentivosGHM) != 0 && count($incentivosMH) == 0 && count($incentivosGH) == 0) {
                    $this->Cell(93, 6, utf8_decode($nombreIncentivo3), 1, 0, 'C');
                    $this->Cell(93, 6, "", 1, 1, 'C');
                }

                $this->SetFont('Arial', '', 7);
                $this->Cell(7);
                /*                 * ** FIN TITULO DE LOS INCENTIVOS **** */
                /*                 * **  INICIO DE LOS ENCABEZADOS DE LOS INCENTIVOS*** */
                if (count($incentivosMH) != 0) {
                    if (count($incentivosMH) > 1 && count($incentivosGH) == 0 && count($incentivosGHM) == 0) {
                        $this->Cell(18.5, 6, "Acta: " . $incentivosMH[0]->getIncentivoAcademico()->getNumeroActaAcuerdoIncentivo(), 1, 0);
                        $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosMH[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 0);
                        $this->SetFont('Arial', '', 6);
                        $this->Cell(19.5, 6, "Acuerdo: " . $incentivosMH[0]->getIncentivoAcademico()->getNumeroAcuerdoIncentivo(), 1, 0);
                        $this->SetFont('Arial', '', 7);
                        $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosMH[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 1);
                    } else {

                        if (count($incentivosMH) != 0 && count($incentivosGH) != 0 && count($incentivosGHM) != 0) {
                            
                        } else if (count($incentivosMH) > 0 || count($incentivosMH) == 1) {
                            $this->Cell(18.5, 6, "Acta: " . $incentivosMH[0]->getIncentivoAcademico()->getNumeroActaAcuerdoIncentivo(), 1, 0);
                            $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosMH[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 0);
                            $this->SetFont('Arial', '', 6);
                            $this->Cell(19.5, 6, "Acuerdo: " . $incentivosMH[0]->getIncentivoAcademico()->getNumeroAcuerdoIncentivo(), 1, 0);
                            $this->SetFont('Arial', '', 7);
                            $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosMH[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 0);
                        }
                    }
                }//if incentivosMH

                if (count($incentivosGH) != 0) {
                    if (count($incentivosGH) > 1 && count($incentivosMH) == 0 && count($incentivosGHM) == 0) {
                        $this->Cell(18.5, 6, "Acta: " . $incentivosGH[0]->getIncentivoAcademico()->getNumeroActaAcuerdoIncentivo(), 1, 0);
                        $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosGH[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 0);
                        $this->SetFont('Arial', '', 6);
                        $this->Cell(19.5, 6, "Acuerdo: " . $incentivosGH[0]->getIncentivoAcademico()->getNumeroAcuerdoIncentivo(), 1, 0);
                        $this->SetFont('Arial', '', 7);
                        $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosGH[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 1);
                    } else {
                        if (count($incentivosMH) != 0 && count($incentivosGH) != 0 && count($incentivosGHM) != 0) {
                            
                        } else if (count($incentivosGH) > 0 || count($incentivosGH) == 1) {
                            $this->Cell(18.5, 6, "Acta: " . $incentivosGH[0]->getIncentivoAcademico()->getNumeroActaAcuerdoIncentivo(), 1, 0);
                            $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosGH[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 0);
                            $this->SetFont('Arial', '', 6);
                            $this->Cell(19.5, 6, "Acuerdo: " . $incentivosGH[0]->getIncentivoAcademico()->getNumeroAcuerdoIncentivo(), 1, 0);
                            $this->SetFont('Arial', '', 7);
                            $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosGH[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 1);
                        }
                    }
                }//if incentivoGH
                if (count($incentivosGHM) != 0) {
                    if (count($incentivosGHM) > 1 && count($incentivosMH) == 0 && count($incentivosGH) == 0) {
                        $this->Cell(18.5, 6, "Acta: " . $incentivosGHM[0]->getIncentivoAcademico()->getNumeroActaAcuerdoIncentivo(), 1, 0);
                        $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosGHM[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 0);
                        $this->SetFont('Arial', '', 6);
                        $this->Cell(19.5, 6, "Acuerdo: " . $incentivosGHM[0]->getIncentivoAcademico()->getNumeroAcuerdoIncentivo(), 1, 0);
                        $this->SetFont('Arial', '', 7);
                        $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosGHM[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 1);
                    } else {
                        if (count($incentivosMH) != 0 && count($incentivosGH) != 0 && count($incentivosGHM) != 0) {
                            
                        } else if (count($incentivosGHM) > 0 || count($incentivosGHM) == 1) {

                            $this->Cell(18.5, 6, "Acta: " . $incentivosGHM[0]->getIncentivoAcademico()->getNumeroActaAcuerdoIncentivo(), 1, 0);
                            $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosGHM[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 0);
                            $this->SetFont('Arial', '', 6);
                            $this->Cell(19.5, 6, "Acuerdo: " . $incentivosGHM[0]->getIncentivoAcademico()->getNumeroAcuerdoIncentivo(), 1, 0);
                            $this->SetFont('Arial', '', 7);
                            $this->Cell(27.5, 6, "Fecha: " . date("Y-m-d", strtotime($incentivosGHM[0]->getIncentivoAcademico()->getFechaAcuerdoIncentivo())), 1, 1);
                        }
                    }
                }//if incentivoGHM
                $y_ini = $this->GetY();
                /*                 * **  FIN DE LOS ENCABEZADOS DE LOS INCENTIVOS ** */
                /*                 * **  INICIO DE ESTUDIANTES CON INCENTIVOS *** */
                if (count($incentivosMH) != 0) {
                    if (count($incentivosMH) > 1 && count($incentivosGH) == 0 && count($incentivosGHM) == 0) {

                        foreach ($incentivos as $incentivoMH) {
                            if ($incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 2 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 4 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 5) {
                                $this->Cell(7);
                                if ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                    //caso1
                                    $this->Cell(93, 6, utf8_decode($incentivoMH->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                } elseif ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                    $this->Cell(93, 6, $incentivoMH->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                }
                            }
                        }
                    } else {
                        if (count($incentivosMH) > 1) {
                            $k = 0;
                            foreach ($incentivos as $incentivoMH) {
                                if ($incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 2 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 4 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 5) {
                                    if ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                        $this->Cell(7);
                                        //caso2
                                        $this->Cell(93, 6, utf8_decode($incentivoMH->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                    } elseif ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                        $this->Cell(93, 6, $incentivoMH->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                    }
                                }
                            }
                        } else {
                            /* @Modified Diego Rivera<riveradiego@unbosque.edu.co>
                             * se inactiva if  esta duplicado solo cambia el orden de los incentivos
                             * @Since 
                             */
                            if (count($incentivosMH) == 1 && count($incentivosGH) == 0 && count($incentivosGHM) == 0) {
                                foreach ($incentivos as $incentivoMH) {
                                    if ($incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 2 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 4 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 5) {
                                        if ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                            //caso3
                                            $this->Cell(93, 6, utf8_decode($incentivoMH->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                        } elseif ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                            $this->Cell(93, 6, $incentivoMH->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                        }
                                    }
                                }
                            } else {
                                if (count($incentivosGH) == 0 && count($incentivosMH) == 1 && count($incentivosGHM) == 0) {
                                    foreach ($incentivos as $incentivoMH) {
                                        if ($incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 2 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 4 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 5) {
                                            $this->Cell(7);
                                            if ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                                //caso4
                                                $this->Cell(93, 6, utf8_decode($incentivoMH->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                            } elseif ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                                $this->Cell(93, 6, $incentivoMH->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                            }
                                        }
                                    }
                                } else {
                                    if (count($incentivosMH) == 1 && count($incentivosGHM) == 0) {
                                        foreach ($incentivos as $incentivoMH) {
                                            if ($incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 2 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 4 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 5) {
                                                $this->Cell(7);
                                                if ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                                    //caso5
                                                    $this->Cell(93, 6, utf8_decode($incentivoMH->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                                } elseif ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                                    $this->Cell(93, 6, $incentivoMH->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                                }
                                            }
                                        }
                                    } else {
                                        if (count($incentivosGHM) == 1 && count($incentivosMH) == 1) {



                                            foreach ($incentivos as $incentivoMH) {
                                                if ($incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 2 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 4 || $incentivoMH->getIncentivoAcademico()->getCodigoIncentivo() == 5) {
                                                    $this->Cell(7);
                                                    if ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                                        //caso5
                                                        if (count($incentivosMH) != 0 && count($incentivosGH) != 0 && count($incentivosGHM) != 0) {
                                                            
                                                        } else {
                                                            $this->Cell(93, 6, utf8_decode($incentivoMH->getEstudiante()->getNombreEstudiante()), 1, 0, 'C');
                                                        }
                                                    } elseif ($incentivoMH->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                                        $this->Cell(93, 6, $incentivoMH->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 0, 'C');
                                                    }
                                                }
                                            }

                                            foreach ($incentivos as $incentivosGHM) {
                                                if ($incentivosGHM->getIncentivoAcademico()->getCodigoIncentivo() == 6) {
                                                    if ($incentivosGHM->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                                        //caso7
                                                        if (count($incentivosMH) != 0 && count($incentivosGH) != 0 && count($incentivosGHM) != 0) {
                                                            
                                                        } else {
                                                            $this->Cell(93, 6, utf8_decode($incentivosGHM->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                                        }
                                                    } elseif ($incentivosGHM->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                                        $this->Cell(93, 6, $incentivosGHM->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                                    }
                                                }
                                            }
                                        } else {
                                            /**
                                             * @Modified Diego Rivera<riveradiego@unbosque.edu.co>
                                             * Se agrega validacion con el fin de mostrar la informacion del estudiante a quien se  otorga incentivo Mencion de meritorio 
                                             * Aplica unicamente para doctorado
                                             * @since March 5,2019 
                                             */
                                            if (count($incentivosGHM) == 1 and count($incentivosMH) == 0 and count($incentivosGH) == 0) {
                                                foreach ($incentivos as $incentivosGHM) {
                                                    if ($incentivosGHM->getIncentivoAcademico()->getCodigoIncentivo() == 6 or $incentivosGHM->getIncentivoAcademico()->getCodigoIncentivo() == 4) {
                                                        if ($incentivosGHM->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                                            //caso7
                                                            $this->Cell(93, 6, utf8_decode($incentivosGHM->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                                        } elseif ($incentivosGHM->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                                            $this->Cell(93, 6, $incentivosGHM->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                /* END */
                            }
                        }
                    }
                } else {
                    $this->Ln(6);
                }
                $y_fin = $this->GetY();
                $y_incentivo_mencion_2 = $y_fin;

                if ($y_fin < $y_ini) {
                    $this->SetY($y_general);
                } else {
                    $this->setY($y_ini);
                }

                if (count($incentivosGH) != 0) {
                    if (count($incentivosGH) > 1 && count($incentivosMH) == 0 && count($incentivosGHM) == 0) {
                        foreach ($incentivos as $incentivoGH) {
                            if ($incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 3 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 9 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 8 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 7) {
                                $this->Cell(7);
                                if ($incentivoGH->getIncentivoAcademico()->getEstadoIncentivo() == 100) {

                                    /**
                                     * @modified Diego Rivera <riveradiego@unbosque.edu.co>
                                     * Se sobreescribe variable  $y_incentivo_mencion_2 con la posicion actual en la hoja  para calcular el valor de la posicion de Y(alto de la pagina)
                                     * esto con fin de realizar calculos de finalizacion de la hoja
                                     * @since Febreary 28,2019
                                     * */
                                    $y_incentivo_mencion_2 = $this->GetY();
                                    $this->Cell(93, 6, utf8_decode($incentivoGH->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                } elseif ($incentivoGH->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                    $this->Cell(93, 6, $incentivoGH->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                }
                            }
                        }
                    } else {
                        if (count($incentivosGH) > 1) {
                            foreach ($incentivos as $incentivoGH) {
                                if ($incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 3 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 9 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 8 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 7) {
                                    $this->Cell(100);
                                    if ($incentivoGH->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                        //caso9
                                        $this->Cell(93, 6, utf8_decode($incentivoGH->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                    } elseif ($incentivoGH->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                        $this->Cell(93, 6, $incentivoGH->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                    }
                                }
                            }
                        } else {
                            if (count($incentivosGH) == 1 && count($incentivosMH) == 0 && count($incentivosGHM) == 0) {
                                foreach ($incentivos as $incentivoGH) {
                                    if ($incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 3 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 9 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 8 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 7) {
                                        //la siguiente linea indica que se muestra apartir de la margen izquerda de la hoja
                                        $this->Cell(7);
                                        if ($incentivoGH->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                            //caso10
                                            $this->Cell(93, 6, utf8_decode($incentivoGH->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                        } elseif ($incentivoGH->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                            $this->Cell(93, 6, $incentivoGH->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                        }
                                    }
                                }
                            } else {
                                if (count($incentivosGH) == 1) {
                                    foreach ($incentivos as $incentivoGH) {
                                        if ($incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 3 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 9 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 8 || $incentivoGH->getIncentivoAcademico()->getCodigoIncentivo() == 7) {
                                            //la siguiente linea indica que se muestra a partir del centro de la hoja
                                            $this->Cell(100);
                                            if ($incentivoGH->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                                //caso11
                                                if (count($incentivosMH) != 0 && count($incentivosGH) != 0 && count($incentivosGHM) != 0) {
                                                    
                                                } else {
                                                    $this->Cell(93, 6, utf8_decode($incentivoGH->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                                }
                                            } elseif ($incentivoGH->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                                $this->Cell(93, 6, $incentivoGH->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if (count($incentivosGHM) > 1 && count($incentivosMH) == 0 && count($incentivosGH) == 0) {
                        foreach ($incentivos as $incentivoGHM) {
                            if ($incentivoGHM->getIncentivoAcademico()->getCodigoIncentivo() == 6) {
                                $this->Cell(7);
                                if ($incentivoGHM->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                    //caso12
                                    $this->Cell(93, 6, utf8_decode($incentivoGHM->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                } elseif ($incentivoGHM->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                    $this->Cell(93, 6, $incentivoGHM->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                }
                            }
                        }
                    }
                } else {
                    if (count($incentivosGHM) >= 1 && count($incentivosMH) == 0 && count($incentivosGH) == 0) {
                        foreach ($incentivos as $incentivoGHM) {
                            if ($incentivoGHM->getIncentivoAcademico()->getCodigoIncentivo() == 6 or $incentivoGHM->getIncentivoAcademico()->getCodigoIncentivo() == 4) {
                                $this->Cell(7);
                                if ($incentivoGHM->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                    //caso12
                                    $this->Cell(93, 6, utf8_decode($incentivoGHM->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                } elseif ($incentivoGHM->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                    $this->Cell(93, 6, $incentivoGHM->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                }
                            }
                        }
                    }elseif (count($incentivosGHM) >= 1 && count($incentivosMH) != 0 && count($incentivosGH) == 0) {
                     // echo "ingreso 2";
                        foreach ($incentivos as $incentivoGHM) {
                            if ($incentivoGHM->getIncentivoAcademico()->getCodigoIncentivo() == 6 or $incentivoGHM->getIncentivoAcademico()->getCodigoIncentivo() == 4) {
                                $this->Cell(100);
                                if ($incentivoGHM->getIncentivoAcademico()->getEstadoIncentivo() == 100) {
                                    //caso12
                                    $this->Cell(93, 6, utf8_decode($incentivoGHM->getEstudiante()->getNombreEstudiante()), 1, 1, 'C');
                                } elseif ($incentivoGHM->getIncentivoAcademico()->getEstadoIncentivo() == 200) {
                                    $this->Cell(93, 6, $incentivoGHM->getEstudiante()->getNombreEstudiante() . '(**ANULADO**)', 1, 1, 'C');
                                }
                            }
                        }
                    }
                    else {
                        $this->Ln(6);
                    }
                }

                $y_incentivo_mencion_3 = $this->GetY();
                if ($y_incentivo_mencion_3 > $y_incentivo_mencion_2) {
                    $this->setY($y_incentivo_mencion_3);
                } else {
                    $this->setY($y_fin);
                }
                /*                 * ******imprime incentivos si existen al final****************************** */
                $this->Ln(4);

                /*                 * ** FIN DE LOS ESTUDIANTES CON INCENTIVOS **** */
            }
        }
        $this->SetFont('Arial', 'B', 10);
        $this->ln(3);
        $y = $this->GetY();

        if ($y <= 235) {
            do {
                $pos_y = $this->GetY();
                $this->Cell(7);
                $this->Cell(186, 3, ' * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *', 'C', 1);
            } while ($pos_y <= 225);
            $this->Cell(7);
            $this->Cell(186, 3, ' * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *', 'C', 1);
        }
        $this->Output();
        ob_end_flush();
    }

}

//class 
?>
