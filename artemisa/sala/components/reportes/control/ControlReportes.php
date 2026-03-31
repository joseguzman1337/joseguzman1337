<?php
/**
 * @author Diego Rivera<riveradiego@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package control
*/
defined('_EXEC') or die;
require_once(PATH_SITE."/components/reportes/modelo/Reportes.php");
require_once(PATH_ROOT."/assets/lib/phpexcel/PHPExcel.php");
require_once(PATH_ROOT."/assets/lib/phpexcel/PHPExcel/Writer/Excel2007.php"); 



class ControlReportes{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type stdObject
     * @access private
     */
    private $variables;
    
    public function __construct($variables) {
        $this->db = Factory::createDbo();
        $this->variables = $variables; 
    }
    
    public function descargarReporteEnfasisMusica() {
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
        $reporteExcel = new PHPExcel();
        $reporteExcel->getProperties()->setCreator("SALA"); 
        $reporteExcel->getProperties()->setTitle("REPORTE");
        $reporteExcel->setActiveSheetIndex(0);
        
        $reporteExcel->getActiveSheet()->getStyle("A1:E1")->getFont()->setBold(true);   
        $reporteExcel->getActiveSheet()->SetCellValue('A1', '#');
        $reporteExcel->getActiveSheet()->SetCellValue('B1', 'Documento');
        $reporteExcel->getActiveSheet()->SetCellValue('C1', 'Apellido');
        $reporteExcel->getActiveSheet()->SetCellValue('D1', 'Nombre');
        $reporteExcel->getActiveSheet()->SetCellValue('E1', 'Enfasis');
                
        $ModeloReportes = new Reportes($this->db);
        $reporte = $ModeloReportes->getVariablesReporte($this->variables); /**/
        $n=2;
        $numerador=1;
    
        foreach (range('A','E')as $columna){
            $reporteExcel->getActiveSheet()->getColumnDimension($columna)->setAutoSize(True);            
        }
        
        foreach($reporte as $datos){
            $reporteExcel->getActiveSheet()->SetCellValue('A'.$n, $numerador );
            $reporteExcel->getActiveSheet()->SetCellValue('B'.$n, $datos->getEstudianteGeneral()->getNumerodocumento() );
            $reporteExcel->getActiveSheet()->SetCellValue('C'.$n, $datos->getEstudianteGeneral()->getapellidosestudiantegeneral() );
            $reporteExcel->getActiveSheet()->SetCellValue('D'.$n, $datos->getEstudianteGeneral()->getnombresestudiantegeneral() );
            $reporteExcel->getActiveSheet()->SetCellValue('E'.$n, $datos->getNombrelineaenfasisplanestudio() );
            $n++;
            $numerador++;
        }
        $reporteExcel->getActiveSheet()->calculateColumnWidths();
        $reporteExcel->getActiveSheet()->setTitle("Reporte");
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Reporte.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel2007");
        $objWriter->save('php://output');            
        exit(); /**/ 
     }
    
    public function sesionEstudiante (  ){
        return $_SESSION["codigo"]=$this->variables->codigoEstudiante; 
    }
}
?>
