<?php
// Para los ordenes de inscripción se debentener los siguientes datos:
// 1. Que existan los conceptos de inscripción, la inscripcion tiene el valor 600
if(!$this->existe_conceptosxcodigoreferencia("600"))
{
	$valordeverdad = false;
}
// 2. Que exista valor pecuniario para el periodo y para inscripcion
if(!$this->existe_valorpecuniarioxcodigoreferencia("600"))
{
	$valordeverdad = false;
}
// 3. Que exista factura para la carrera del estudiante y para el periodo activo
if(!$this->existe_facturavalorpecuniario("600"))
{
	$valordeverdad = false;
}
// 4. Que existan valores pecuniarios para inscripcion
if(!$this->existe_valorpecuniarioxcodigoreferencia("600"))
{
	$valordeverdad = false;
}
// 5. Que exista detalles de facturavalorpecuniario para inscripcion
if(!$this->existe_detallefacturavalorpecuniarioxcodigoreferencia("600"))
{
	$valordeverdad = false;
}
// 6. Que exista registro en carreraperido para 
if(!$this->existe_carreraperiodo())
{
	$valordeverdad = false;
}
// 7. Que exista subperiodo para la carrera
if(!$this->existe_subperiodo())
{
	$valordeverdad = false;
}
// 8. Que exista fechas para los conceptos de inscripcion
if(!$this->existe_fechacarrerareferenciaconcepto("600"))
{
	$valordeverdad = false;
}
// 9. Que exista bancos para las cuentas de la orden de pago
if(!$this->existe_cuentabanco())
{
	$valordeverdad = false;
}
// 10. Que exista ordeninterna o centrobeneficio para la carrera
if(!@$this->existe_ordeninternaocentrobeneficio($ordeninternaocentrobeneficio))
{
	$valordeverdad = false;
}
// 11. Que exista concexion sap
/*if(!$this->existe_conexionsap())
{
	$valordeverdad = false;
}*/
?>
