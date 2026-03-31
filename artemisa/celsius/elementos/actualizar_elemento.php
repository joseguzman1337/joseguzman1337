<?
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

if (empty($Anterior)){	
	 $elemento= array ( "Codigo_Pantalla"=>$Codigo_Pagina, "Codigo_Elemento"=>$Codigo_Elemento ); 
	 $res = $servicesFacade->agregarElemento($elemento);
	 
}
else{
   	 $elemento= array ( "Codigo_Pantalla"=>$Codigo_Pagina, "Codigo_Elemento"=>$Codigo_Elemento ,"Anterior"=>$Anterior, "PaginaAnterior"=>$PaginaAnterior  );	 
	 $res = $servicesFacade->modificarElemento($elemento);
	 $traduccion= array ( "Codigo_Pantalla"=>$Codigo_Pagina, "Codigo_Elemento"=>$Codigo_Elemento ,"Anterior"=>$Anterior, "PaginaAnterior"=>$PaginaAnterior  );
	 $res = $servicesFacade->modificarTraduccion($traduccion);
}  

header('Location:mostrarElemento.php?CodElemento='.$Codigo_Elemento.'&CodPantalla='.$Codigo_Pagina);
?>
