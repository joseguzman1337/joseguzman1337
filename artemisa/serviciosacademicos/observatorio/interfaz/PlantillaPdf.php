<?php 

require 'pdf/fpdf.php';


class PDF extends FPDF{

    function Header(){

        Global $modalidadacademica,$programa;


        $this->SetFont('Arial','B',15);
        $this->Cell(30);
        $this->Cell(200,10,utf8_decode('Reporte de Estudiantes en Prueba Académica'),0,0,'C');


        $this->Ln(20);

    }

    function Footer(){

        $this->SetY(-15);
        $this->SetFont('Arial','I',8);

    }
}
?>