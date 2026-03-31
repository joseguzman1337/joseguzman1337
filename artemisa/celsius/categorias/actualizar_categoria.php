<?
/*
 * IdCategoria int 
 *  */
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

if (empty($operacion)){
	$res= $servicesFacade->insertCategoriaUsuario($Categoria);
    $IdCategoria= $res;
}
else{ 
	$Categ= array("nombre"=>$Categoria, "Id"=>$IdCategoria);
	$res = $servicesFacade->updateCategoriaUsuario($Categ); 
}  

if (is_a($res, "Celsius_Exception"))
	return $res;

header('Location:mostrarCategoria.php?IdCategoria=' . $IdCategoria);
?>