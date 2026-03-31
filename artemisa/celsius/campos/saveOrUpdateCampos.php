<?
/**
 * @var int $texto1
 * @var int $abreviatura1
 * @var int $ayuda1
 * @var int $error1
 * @var int $texto2
 * @var int $abreviatura2
 * @var int $ayuda2
 * @var int $error2
 * @var int $texto3
 * @var int $abreviatura3
 * @var int $ayuda3
 * @var int $error3
 * @var int $id_campo
 * @var int cantIdiomas
 * @var int idIdiomaPredeterminado
 * 
 */
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$pageName= "campos";
$Mensajes = Comienzo ($pageName,$IdiomaSitio);


/*verifico que esten cargados todos los campos del idioma predeterminado*/
$textoIdiomaPred= 'texto'.$idIdiomaPredeterminado;
$abrevIdiomaPred= 'abreviatura'.$idIdiomaPredeterminado;
$ayudaIdiomaPred= 'ayuda'.$idIdiomaPredeterminado;
$errorIdiomaPred= 'error'.$idIdiomaPredeterminado;

if ((empty($textoIdiomaPred))||(empty($abrevIdiomaPred))||(empty($ayudaIdiomaPred))||(empty($errorIdiomaPred)))
	return false;

for($i=1;$i<=$cantIdiomas;$i++){
	$datos=array();

	$campo= 'texto'.$i;
	if (!empty($$campo)) {
		$texto=$$campo;
		$datos['texto']=$texto;
	}
	else{
		$campo= 'texto'.$idIdiomaPredeterminado;
		if (!empty($$campo)) {
			$texto=$$campo;
			$datos['texto']=$texto;
		}
	}
		
	$campo= 'abreviatura'.$i;
	if (!empty($$campo)) {
		$abreviatura=$$campo;
		$datos['abreviatura']=$abreviatura;
	}
	else{
		$campo= 'abreviatura'.$idIdiomaPredeterminado;
			if (!empty($$campo)) {
			$abreviatura=$$campo;
			$datos['abreviatura']=$abreviatura;
		}
	}
	
	$campo= 'ayuda'.$i;
	if (!empty($$campo)){
		$ayuda=$$campo;
		$datos['mensaje_ayuda']=$ayuda;
	}
	else{
		$campo= 'ayuda'.$idIdiomaPredeterminado;
		if (!empty($$campo)) {
			$ayuda=$$campo;
			$datos['mensaje_ayuda']=$ayuda;
		}
	}
		
	$campo= 'error'.$i;
	if (!empty($$campo)){
		$error=$$campo;
		$datos['mensaje_error']=$error;
	}
	else{
		$campo= 'error'.$idIdiomaPredeterminado;
		if (!empty($$campo)) {
			$error=$$campo;
			$datos['mensaje_error']=$error;
		} 
	}
		
	//si existe la tupla la modifico sino la agrego
	$res= $servicesFacade->insertCampoPedidos($i, $id_campo, $datos);
	if (is_a($res,"Celsius_Exception"))
       	return $res;
}
	
	header('Location:mostrarCampos.php?id='.$id_campo);
?>