<?php
/**
 * 
 */
  
if (!defined("constantes")){
	define("constantes",TRUE);
	
	//tipos de pedido
	define("TIPO_PEDIDO__BUSQUEDA", 1);
	define("TIPO_PEDIDO__PROVISION", 2);
	
	//Eventos
	//define("EVENTO__1",1); //no se usa
	define("EVENTO__A_BUSQUEDA",2);
	define("EVENTO__A_SOLICITADO",3);
	define("EVENTO__A_ESPERA_DE_CONF_USUARIO",4);
	define("EVENTO__CONFIRMADO_POR_USUARIO",5);
	define("EVENTO__A_RECIBIDO",6);
	define("EVENTO__A_ENTREGADO_IMPRESO",7);
	define("EVENTO__A_CANCELADO_POR_USUARIO",8);
	define("EVENTO__A_CANCELADO_POR_OPERADOR",9);
	define("EVENTO__A_OBSERVACION",10);
	define("EVENTO__A_CANCELADO_POR_ESTAR_EN_SECYT",11);
	//define("EVENTO__12",12);//no se usa
	define("EVENTO__A_AUTORIZADO_A_BAJARSE_PDF",13);
	define("EVENTO__A_PDF_DESCARGADO",14);
	define("EVENTO__A_INTERMEDIO_POR_NT",15);
	define("EVENTO__A_ESPERA_DE_CONF_OPERADOR",16);
	define("EVENTO__CONFIRMADO_POR_OPERADOR",17);
    define("EVENTO__A_RECLAMADO_POR_OPERADOR",18);
    define("EVENTO__A_RECLAMADO_POR_USUARIO",19);
    
    
    
	//corrientes: 1,2,3,4,5,13,14 
	//listos: 6,11
	//hist 7,12,8
	//no existen: 9,10
	
	//ESTADOS
	define("ESTADO__PENDIENTE",1);
	define("ESTADO__BUSQUEDA",2);
	define("ESTADO__SOLICITADO",3);
	define("ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_USUARIO",4);
	define("ESTADO__CONFIRMADO_POR_EL_USUARIO",5);
	define("ESTADO__RECIBIDO",6);
	define("ESTADO__ENTREGADO_IMPRESO",7);
	define("ESTADO__CANCELADO",8);
	//define("ESTADO__9",9);//NO SE USA
	define("ESTADO__EN_OBSERVACION",10);
	define("ESTADO__LISTO_PARA_BAJARSE",11);
	define("ESTADO__DESCAGADO_POR_EL_USUARIO",12);
	define("ESTADO__PENDIENTE_LLEGADA_NT",13);
	define("ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_OPERADOR",14);
	define("ESTADO__CONFIRMADO_POR_EL_OPERADOR",15);
	define("ESTADO__RECLAMADO_POR_OPERADOR",16);
	define("ESTADO__RECLAMADO_POR_USUARIO",17);
	//prioridad de estados: 8,7,14,13,6
	
	
    define("EVENTO_NT__RECIBIDO" , "RECIBIDO");
	define("EVENTO_NT__CANCELADO" , "CANCELADO");
	define("EVENTO_NT__ENVIADO" , "ENVIADO");
	define("EVENTO_NT__ESPERAR_CONFIRMACION" , "ESPERAR_CONFIRMACION");
	define("EVENTO_NT__CONFIRMADO" , "CONFIRMADO");
    define("EVENTO_NT__RECLAMADO" , "RECLAMADO");

	define("TIPO_MATERIAL__REVISTA" , 1);
	define("TIPO_MATERIAL__LIBRO" , 2);
	define("TIPO_MATERIAL__PATENTE" , 3);
	define("TIPO_MATERIAL__TESIS" , 4);
	define("TIPO_MATERIAL__CONGRESO" , 5);
	
	
	define("ROL__INVITADO" , 0);
	define("ROL__USUARIO" , 1);
	define("ROL__BIBLIOTECARIO" , 2);
	define("ROL__ADMINISTADOR" , 3);
	define("ROL__SUPER_ROOT" , 4);
	
	define("TIPO__BIBLIOTECARIO_UNIDAD" , 3);
	define("TIPO__BIBLIOTECARIO_DEPENDENCIA" , 2);
	define("TIPO__BIBLIOTECARIO_INSTITUCION" , 1);
	
	//estados de la cola de envios
	define("EVENTO_COLA_NO_ENVIADO" , 0);
	define("EVENTO_COLA_ENVIADO" , 1);
	define("EVENTO_COLA_CANCELADO" , 2);
	
	
	//uniones
	define("UNION_DEPENDENCIAS", 1);
	define("UNION_INSTITUCIONES", 2);
	define("UNION_PAISES", 3);
	define("UNION_TITULOS_COLECCIONES", 4);
	define("UNION_CATEGORIAS", 5);
	define("UNION_UNIDADES", 6);
	define("UNION_USUARIOS",7);
	
}

function Devolver_Mapeo_ReplaceIdPedido(){
	return array(
		"archivos_pedidos"=>"codigo_pedido",
		"busquedas" => "Id_Pedido",
		"cola_eventosnt"=> "id_pedido",
		"evanula" =>"Id_Pedido",
		"eventos" =>"Id_Pedido",
		"evhist"=>"Id_Pedido",
		"pedidos"=>"Id",
		"pedhist"=>"Id",
		"pedanula"=>"Id",
		"mail"=>"Codigo_Pedido"
	);
}

?>