<?php
require_once "Celsius_Dao.php";
require_once "../soap-celsius/CelsiusSOAPClient.php";

require_once "PedidosUtils.php";
require_once "../files/FilesUtils.php";
require_once "../exceptions/Application_Exception.php";
//require_once "../utils/make_zip.php";
//require_once "../common/includes.php";
require_once "constants.php";

class ServicesFacade{
 	var $dao;
 	var $celsiusSoapClient;
  	    
 	function getInstance(){
 		
 		return new ServicesFacade();
 	}
 	
 	function ServicesFacade(){
 		$dao = new Celsius_Dao();
 		
 		if (is_a($dao,"Celsius_Exception")){
 			return $dao;
 		}
 		$this->dao = $dao;
 			
 	}
 	
 	function getCelsiusSOAPClient(){
 	if (empty($this->celsiusSoapClient))
 			$this->celsiusSoapClient = new CelsiusSOAPClient($this);
 	     
 		return $this->celsiusSoapClient;
 	}

	function getDao(){
		return $this->dao;
	}
	
	//////////////////////////////////////////////////////////////////
	////////////////////////////// Paises ////////////////////////////
	//////////////////////////////////////////////////////////////////
 
 	function agregarPais($pais){
 		return $this->dao->insert("paises", $pais);
 	}
 	
 	function modificarPais($pais){
 		$Id = $pais["Id"];
 		unset($pais["Id"]); 
 		return  $this->dao->update("paises", $pais, "Id = '$Id'");
 	}
	
	
 	function getPais($idPais) {
		$conditions= array("Id" => $idPais);
		return $this->getObject("paises", $conditions);
	}
	
	function getPaises($conditions=array()) {
	  	
	 
		return $this->getAllObjects("paises", $conditions, "*", "Nombre");
	}

	//////////////////////////////////////////////////////////////////
	/////////////////////////// Instituciones ////////////////////////
	//////////////////////////////////////////////////////////////////
 	
 	function agregarInstitucion($institucion){
 		return $this->dao->insert("instituciones", $institucion);
 		
	}
 	
 	/**
 	 * Modifica la institucion recibida como parametro y actualiza todas las referencias foraneas a su Codigo_Pais
 	 * @param array $institucion La institucion a modificar. 
 	 * @throws DB_Exception En caso de error con la base de datos
 	 * @throws Application_Exception En caso de encontrar errores en los parametros
 	 */
 	function modificarInstitucion($institucion){
 		$idInstitucion = $institucion["Codigo"];
 		if (empty($idInstitucion))
 			return new Application_Exception("Debe especificar el Codigo de la institucion a modificar");
 		$id_pais_institucion = $institucion["Codigo_Pais"];
 		unset($institucion["Codigo"]); 
 		
 		//BEGIN
 		$resModificacion = $this->dao->updateAll("instituciones", $institucion, "Codigo = $idInstitucion");
 		if(is_a($resModificacion, "Celsius_Exception"))
			return $resModificacion;
 		
	    $datosPedidos = array("Ultimo_Pais_Solicitado"=>$id_pais_institucion);
	    $resultUpd=$this->dao->updateAll("pedidos",$datosPedidos,"Ultima_Institucion_Solicitado=".$idInstitucion);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;

	    $datosPedidos=array("Codigo_Pais_Tesis"=>$id_pais_institucion);
	    $resultUpd=$this->dao->updateAll("pedidos",$datosPedidos,"Codigo_Institucion_Tesis=".$idInstitucion); 
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	   
	   
	    $datosPedidos=array("Ultimo_Pais_Solicitado"=>$id_pais_institucion);
	    $resultUpd=$this->dao->updateAll("pedhist",$datosPedidos,"Ultima_Institucion_Solicitado=".$idInstitucion); 
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	   
	    $datosPedidos=array("Codigo_Pais_Tesis"=>$id_pais_institucion);
	    $resultUpd=$this->dao->updateAll("pedhist",$datosPedidos,"Codigo_Institucion_Tesis=".$idInstitucion);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	   
	    $datosPedidos=array("Ultimo_Pais_Solicitado"=>$id_pais_institucion);
	    $resultUpd=$this->dao->updateAll("pedanula",$datosPedidos,"Ultima_Institucion_Solicitado=".$idInstitucion); 
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	   
	    $datosPedidos=array("Codigo_Pais_Tesis"=>$id_pais_institucion);
	    $resultUpd=$this->dao->updateAll("pedanula",$datosPedidos,"Codigo_Institucion_Tesis=".$idInstitucion);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	 
	    $datosEventos=array("Codigo_Pais"=>$id_pais_institucion);
	    $resultUpd=$this->dao->updateAll("eventos",$datosEventos,"Codigo_Institucion=".$idInstitucion);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	 
	    $datosEventosHistorico=array("Codigo_Pais"=>$id_pais_institucion);
	    $resultUpd=$this->dao->updateAll("evhist",$datosEventosHistorico,"Codigo_Institucion=".$idInstitucion);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	 
	    $datosEventosAnulado=array("Codigo_Pais"=>$id_pais_institucion);
	    $resultUpd=$this->dao->updateAll("evanula",$datosEventosAnulado,"Codigo_Institucion=".$idInstitucion);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	 
	    $datosUsuarios=array("Codigo_Pais"=>$id_pais_institucion);
	    $resultUpd=$this->dao->updateAll("usuarios",$datosUsuarios,"Codigo_Institucion=".$idInstitucion);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	 
		$datosCandidatos=array("Codigo_Pais"=>$id_pais_institucion);
	    $resultUpd=$this->dao->updateAll("candidatos",$datosCandidatos,"Codigo_Institucion=".$idInstitucion);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
		
		return $resModificacion;
		//COMMIT :D
	   
 	}
	
	
 	function getInstitucion($idInstitucion) {
		$conditions= array("Codigo" => $idInstitucion);
		return $this->getObject("instituciones", $conditions);
	}
	
	function getInstituciones($conditions=array()) {
		return $this->getAllObjects("instituciones",$conditions, "*" , "Nombre");
	}
	
	function getInstitucionesCompletas($conditions=array()) {
		$select = $this->dao->select();
		$select->from("instituciones as i","i.*");
		$select->joinLeft("paises as p","p.Id = i.Codigo_Pais","p.Nombre");
		
		foreach($conditions as $fieldName => $fieldValue){
			if (!isset($fieldValue))
				$select->where($fieldName);
			else
 				$select->where("i.$fieldName = ?", $fieldValue);
 		}
 		$select->order("i.Nombre");
		return $this->dao->fetchAll($select);
	}
	
	//////////////////////////////////////////////////////////////////
	////////////////////////// Dependencias //////////////////////////
	//////////////////////////////////////////////////////////////////
 	
 	function agregarDependencia($dependencia){
 		return $this->dao->insert("dependencias", $dependencia);
 		
 	}
 	
 	function modificarDependencia($dependencia){
 		$IdDependencia = $dependencia["Id"];
 		$id_institucion_dependencia = $dependencia["Codigo_Institucion"];
 		
 		$Institucion_dependencia=$this->getInstitucion($id_institucion_dependencia);
	    $id_pais_dependencia = $Institucion_dependencia["Codigo_Pais"];
 		
 		//BEGIN
 		unset($dependencia["Id"]); 
 		$resModificacion = $this->dao->update("dependencias", $dependencia, "Id = $IdDependencia");
 		if(is_a($resModificacion, "Celsius_Exception"))
			return $resModificacion;
 		
	    $datosUnidades=array("Codigo_Institucion"=>$id_institucion_dependencia);
	    $resultUpd=$this->dao->updateAll("unidades",$datosUnidades,"Codigo_Dependencia=".$IdDependencia); 
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	      
	    $datosSolicitud=array("Ultimo_Pais_Solicitado"=>$id_pais_dependencia,"Ultima_Institucion_Solicitado"=>$id_institucion_dependencia);
	    $datosTesis=array("Codigo_Pais_Tesis"=>$id_pais_dependencia,"Codigo_Institucion_Tesis"=>$id_institucion_dependencia);
	    
	    $resultUpd=$this->dao->updateAll("pedidos",$datosSolicitud,"Ultima_Dependencia_Solicitado=".$IdDependencia);
	    if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd; 
	   	$resultUpd=$this->dao->updateAll("pedidos",$datosTesis,"Codigo_Dependencia_Tesis=".$IdDependencia);
	   	if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd; 
	   
		$resultUpd=$this->dao->updateAll("pedhist",$datosSolicitud,"Ultima_Dependencia_Solicitado=".$IdDependencia);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd; 
		$resultUpd=$this->dao->updateAll("pedhist",$datosTesis,"Codigo_Dependencia_Tesis=".$IdDependencia);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd; 
		
		$resultUpd=$this->dao->updateAll("pedanula",$datosSolicitud,"Ultima_Dependencia_Solicitado=".$IdDependencia);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd; 
		$resultUpd=$this->dao->updateAll("pedanula",$datosTesis,"Codigo_Dependencia_Tesis=".$IdDependencia);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd; 
		
		
		$datosEventos=array("Codigo_Pais"=>$id_pais_dependencia,"Codigo_Institucion"=>$id_institucion_dependencia);
		$resultUpd=$this->dao->updateAll("eventos",$datosEventos,"Codigo_Dependencia=".$IdDependencia);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	
		$resultUpd=$this->dao->updateAll("evhist",$datosEventos,"Codigo_Dependencia=".$IdDependencia);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	 
		$resultUpd=$this->dao->updateAll("evanula",$datosEventos,"Codigo_Dependencia=".$IdDependencia);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	 
		$datosUsuarios=array("Codigo_Pais"=>$id_pais_dependencia,"Codigo_Institucion"=>$id_institucion_dependencia);
		$resultUpd=$this->dao->updateAll("usuarios",$datosUsuarios,"Codigo_Dependencia=".$IdDependencia);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	 
		$datosCandidatos=array("Codigo_Pais"=>$id_pais_dependencia,"Codigo_Institucion"=>$id_institucion_dependencia);
		$resultUpd=$this->dao->updateAll("candidatos",$datosCandidatos,"Codigo_Dependencia=".$IdDependencia);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
		
		//COMMIT
		return $resModificacion;
 	}
	
	
 	function getDependencia($idDependencia) {
		$conditions= array("Id" => $idDependencia);
		return $this->getObject("dependencias", $conditions);
	}
	
	function getPIDU() {
		$select = $this->dao->select();
		$select->from("paises as tPaises","tPaises.Nombre as Nombre_Pais,tPaises.Id as Id_Pais");
		$select->joinLeft("instituciones as tInstituciones","tInstituciones.Codigo_Pais = tPaises.Id","tInstituciones.Nombre as Nombre_Institucion,tInstituciones.Abreviatura as Abreviatura_Institucion,tInstituciones.Codigo as Id_Institucion");
		$select->joinLeft("dependencias as tdependencias","tdependencias.Codigo_Institucion = tInstituciones.Codigo","tdependencias.Nombre as Nombre_Dependencia,tdependencias.Id as Id_Dependencia");
		$select->joinLeft("unidades as tUnidades","tUnidades.Codigo_Dependencia = tdependencias.Id","tUnidades.Nombre as Nombre_Unidad,tUnidades.Id as Id_Unidad");
		$select->order("tPaises.Nombre,tInstituciones.Nombre,tdependencias.Nombre,tUnidades.Nombre");
		return $this->dao->fetchAll($select);
	}
	
	function getPID_LibLink() {
		$select = $this->dao->select();
		$select->from("paises as tPaises","tPaises.Nombre as Nombre_Pais");
		$select->joinInner("instituciones as tInstituciones","tInstituciones.Codigo_Pais = tPaises.Id","tInstituciones.Nombre as Nombre_Institucion,tInstituciones.Sitio_Web as Sitio_Web_Institucion");
		$select->joinLeft("dependencias as tdependencias","tdependencias.Codigo_Institucion = tInstituciones.Codigo","tdependencias.Nombre as Nombre_Dependencia,tdependencias.Hipervinculo1 as Sitio_Web_Dependencia");
		$select->where("((tdependencias.Es_LibLink = 1) or (isNull(tdependencias.Id)))");
		$select->where("tInstituciones.Participa_Proyecto = 1");
 		
		$select->order("tPaises.Nombre,tInstituciones.Nombre,tdependencias.Nombre");
		//var_export($select->__toString());
		$res = $this->dao->fetchAll($select);
			
		return $res;
	}

	function getDependencias($conditions=array()) {
		return $this->getAllObjects("dependencias",$conditions, "*" , "Nombre");
	
	}
	
	function getDependenciasFromInstitucion($idInstitucion){
		$conditions= array("Codigo_Institucion" => $idInstitucion);
		return $this->getAllObjects("dependencias", $conditions);
	}
	
	//////////////////////////////////////////////////////////////////
	//////////////////////////// Unidades ////////////////////////////
	//////////////////////////////////////////////////////////////////
 	
 	function agregarUnidad($unidad){
 		return $this->dao->insert("unidades", $unidad);
 		
 	}
 	
 	function modificarUnidad($unidad){
 		$IdUnidad = $unidad["Id"];
 		$id_dependencia_unidad = $unidad["Codigo_Dependencia"];
 		$id_institucion_unidad = $unidad["Codigo_Institucion"];
 		$institucion_unidad=$this->getObject("instituciones",array("Codigo"=>$id_institucion_unidad));
    	$id_pais_unidad = $institucion_unidad["Codigo_Pais"];
 		
 		unset($unidad["Id"]); 
 		$resModificacion = $this->dao->update("unidades", $unidad, "Id = $IdUnidad");
 		if(is_a($resModificacion, "Celsius_Exception"))
			return $resModificacion;
 		
    
		//Actualizo las tablas referentes
		
		$datosPedidos=array("Ultimo_Pais_Solicitado"=>$id_pais_unidad,"Ultima_Institucion_Solicitado"=>$id_institucion_unidad,"Ultima_Dependencia_Solicitado"=>$id_dependencia_unidad);
	    $resultUpd=$this->dao->updateAll("pedidos",$datosPedidos,"Ultima_Unidad_Solicitado=".$IdUnidad);
		if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd; 
	   
	    $resultUpd=$this->dao->updateAll("pedhist",$datosPedidos,"Ultima_Unidad_Solicitado=".$IdUnidad);
	    if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd; 

	    $resultUpd=$this->dao->updateAll("pedanula",$datosPedidos,"Ultima_Unidad_Solicitado=".$IdUnidad);
	    if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd; 
	        
	    $datosEventos=array("Codigo_Pais"=>$id_pais_unidad,"Codigo_Institucion"=>$id_institucion_unidad,"Codigo_Dependencia"=>$id_dependencia_unidad);
	    $resultUpd=$this->dao->updateAll("eventos",$datosEventos,"Codigo_Unidad=".$IdUnidad);
	    if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	    $resultUpd=$this->dao->updateAll("evhist",$datosEventos,"Codigo_Unidad=".$IdUnidad);
	    if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	    $resultUpd=$this->dao->updateAll("evanula",$datosEventos,"Codigo_Unidad=".$IdUnidad);
	    if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	 	
	    $datosUsuarios=array("Codigo_Pais"=>$id_pais_unidad,"Codigo_Institucion"=>$id_institucion_unidad,"Codigo_Dependencia"=>$id_dependencia_unidad);
	    $resultUpd=$this->dao->updateAll("usuarios",$datosUsuarios,"Codigo_Unidad=".$IdUnidad);
	    if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
	 
	    $datosCandidatos=array("Codigo_Pais"=>$id_pais_unidad,"Codigo_Institucion"=>$id_institucion_unidad,"Codigo_Dependencia"=>$id_dependencia_unidad);
	    $resultUpd=$this->dao->updateAll("candidatos",$datosCandidatos,"Codigo_Unidad=".$IdUnidad);
	    if(is_a($resultUpd, "Celsius_Exception"))
			return $resultUpd;
			
		return $resModificacion;
 	}
	
 	function getUnidad($idUnidad) {
		$conditions= array("Id" => $idUnidad);
		return $this->getObject("unidades", $conditions);
	}
	
	function getUnidades($conditions=array()) {
		return $this->getAllObjects("unidades",$conditions);
	}
	
	function getUnidadesFromDependencia($idDependencia){
		$conditions= array("Codigo_Dependencia" => $idDependencia);
		return $this->getAllObjects("unidades", $conditions);
	}
	
	//////////////////////////////////////////////////////////////////
	/////////////////////////// Localidades //////////////////////////
	//////////////////////////////////////////////////////////////////
 	
 	function agregarLocalidad($localidad){
		return $this->dao->insert("localidades", $localidad);
 	}
 	
 	function modificarLocalidad($localidad){
 		$IdLocalidad = $localidad["Id"];
 		unset($localidad["Id"]); 
 		$result = $this->dao->update("localidades", $localidad, "Id = $IdLocalidad");
 		if (is_a($result, "Exception"))
			return $result;
		return $IdLocalidad;
 	}
	
 	function getLocalidad($idLocalidad) {
		$conditions= array("Id" => $idLocalidad);
		return $this->getObject("localidades", $conditions);
	}
	
	function getLocalidades($conditions= array()) {
		return $this->getAllObjects("localidades",$conditions,"*", "Nombre");
	}

	
	function eliminarLocalidad($idLocalidad) {
		$res = $this->dao->delete("localidades",'Id='.$idLocalidad);
		if (is_a($res, "Celsius_Exception"))
			return $res;
	}
	

	//////////////////////////////////////////////////////////////////
	///////////////////////////// Noticias ///////////////////////////
	//////////////////////////////////////////////////////////////////
	
	function getNoticia($idNoticia){
		$conditions= array("Id" => $idNoticia);
		return $this->getObject("noticias", $conditions);
	}
	
	function getNoticias($conditions= array(), $order="Id Desc") {
		return $this->getAllObjects("noticias",$conditions,"*", $order);
	}
	
	function borrarNoticia($idNoticia){
		return $this->dao->delete("noticias","Id=".$idNoticia);
	}
	
	function agregarNoticia($noticia){
		return $this->dao->insert("noticias", $noticia);
	}
	
	function modificarNoticia($noticia){
		$Id = $noticia["Id"];
 		unset($noticia["Id"]); 
 		return  $this->dao->update("noticias", $noticia, "Id = '$Id'");
	}
	
	function buscarNoticias($parametros){
		$select = $this->dao->select();
		$select->from("noticias");
		if(isset($parametros["FechaInicio"])){
			$select->where(" Fecha >= ?", $parametros['FechaInicio']);}
		if(isset($parametros["FechaFin"])){
			$select->where(" Fecha<= ?", $parametros['FechaFin']);}	
		if(isset($parametros["Codigo_Idioma"])){
			$select->where(" Codigo_Idioma= ?", $parametros['Codigo_Idioma']);}
			
		$select->order("Fecha DESC");
		return $this->dao->fetchAll($select);
	}
			
		
	//////////////////////////////////////////////////////////////////
	////////////////////////////// Auxiliares ////////////////////////
	//////////////////////////////////////////////////////////////////
	
	function getObject($table, $conditions = array(), $cols = "*"){
		$select = $this->dao->select();
		$select->from($table,$cols);
		foreach($conditions as $fieldName => $fieldValue){
 			$select->where("$fieldName = ?", $fieldValue);
 		}
		
		return $this->dao->fetchRow($select);
	}
	
	function getAllObjects($table, $conditions= array(), $cols = "*", $order = null, $groupBy = null){
		$select = $this->dao->select();
		$select->from($table,$cols);
		if ($conditions!=null){
			foreach($conditions as $fieldName => $fieldValue){
				if (!isset($fieldValue))
					$select->where($fieldName);
				else
 					$select->where("$fieldName = ?", $fieldValue);
 			}
		}
 		if ($order != null)
			$select->order($order);
		if ($groupBy != null)
			$select->group($groupBy);
		
		return $this->dao->fetchAll($select);
	}
	
	
	/**
	 * Encuentra resultados que sean similares
	 */
	function findAllObjects($select, $conditions= array(), $bool="and"){
		if ($bool == "or")
			$operador = "orWhere";
		else
			$operador = "where"; 
		
		foreach($conditions as $fieldName => $fieldValue){
 			if (is_string($fieldValue))
 				$select->$operador("$fieldName LIKE ?", $fieldValue);
 			elseif (is_null($fieldValue))
 				$select->$operador("isNull($fieldName)");
 			else
 				$select->$operador("$fieldName = ?", $fieldValue);
 		}
		
 		return $this->dao->fetchAll($select);
	}

	function getObjectsIn($table, $set_of_ids){
		$select = $this->dao->select();
		$select->from($table,"*");
		$string_set = implode(", ", $set_of_ids);
		$select->where("Id in ($string_set)");
		return $this->dao->fetchAll($select);
	}
	//////////////////////////////////////////////////////////////////
	//////////////////////// Archivos Pedidos ///////////////////////
	//////////////////////////////////////////////////////////////////
		
	function registrarDownload($codigo_archivo, $id_usuario, $ip_usuario) {
		return $this->dao->insert("downloads", array ("codigo_archivo" => $codigo_archivo,"codigo_usuario" => $id_usuario,
			"Fecha" => date("Y-m-d H:i:s"), "IP_usuario" => $ip_usuario));
	}
	
	function incrementarArchivosPedido($id_pedido){
		return $this->dao->query("UPDATE pedidos SET Archivos_Totales = Archivos_Totales + 1 WHERE Id = '$id_pedido'");
	}
			
	function registrarDescargaArchivoPedido($archivo, $id_usuario, $rol_usuario) {
		$codigo_archivo = $archivo["codigo"];
		$id_pedido = $archivo["codigo_pedido"];
	
		if ($rol_usuario != ROL__ADMINISTADOR) {
			//si es usuario comun o bibliotecario, deberï¿½ registrarse el download, verificar si va al historico (y en tal caso, enviarlo).
			//Si es un usuario administrador el que realiza el download, no deberï¿½a incrementar en uno la cantidad de downloads,
			//ni enviar el pedido al historico
	
			$res = $this->dao->update("archivos_pedidos", array ("Permitir_Download" => 0), "codigo = $codigo_archivo");
			if (is_a($res, "Celsius_Exception"))
				return $res;
	
			$pedido = $this->getPedido($id_pedido);
								
			//sumo uno a la cantidad de archivos bajados
			$res = $this->dao->update("pedidos", array ("Archivos_Bajados" => $pedido["Archivos_Bajados"] + 1), "Id = '$id_pedido'");
			if (is_a($res, "Celsius_Exception"))
				return $res;
	
			$pedido = $this->getPedido($id_pedido);
			
			if ($pedido["Archivos_Totales"] <= $pedido["Archivos_Bajados"]) {
				//ya se han bajado todos los archivos del pedido. El mismo deberï¿½ pasar al historial
				$evento = array ();
				$evento["Id_Pedido"] = $id_pedido;
				$evento["Codigo_Evento"] = EVENTO__A_PDF_DESCARGADO;
				$res = $this->generarEvento_OrigenLocal($evento);
				if (is_a($res, "Celsius_Exception"))
					return $res;
					
			
			}
	
		}
		
		//registro el Download que se acaba de realizar
		$res = $this->registrarDownload($codigo_archivo, $id_usuario, $_SERVER['REMOTE_ADDR']);
		if (is_a($res, "Celsius_Exception"))
			return $res;
	}

	function agregarArchivoPedido($archivo_pedido){
		return $this->dao->insert("archivos_pedidos", $archivo_pedido);
	}
	
	function getArchivosPedido($id_pedido, $rol = ROL__ADMINISTADOR){
		$select = $this->dao->select();
		$select->from("archivos_pedidos");
		$select->where("codigo_pedido = ?",$id_pedido);
		if ($rol != ROL__ADMINISTADOR)
			//no deberia estar hardcodeado la extension pdf. deberia sacars de la configuracion la lista de extensiones permitidas
			$select->where("nombre_archivo LIKE '%.pdf'");
		return $this->dao->fetchAll($select);
	}

	function getArchivoPedido($codigo) {
		$conditions= array("codigo" => $codigo);
		return $this->getObject("archivos_pedidos", $conditions);
	}

	/**
	 * Devuelve todos los catalogos junto con los resultados de las buquedas realizadsa sobre ellos
	 */
	function getBusquedasPedido($id_pedido){
		$select = $this->dao->select();
		$select->from("catalogos", "catalogos.Id as Id_Catalogo,catalogos.Nombre as Nombre_Catalogo,catalogos.Link as URL_Catalogo, " .
			"catalogos.observaciones as Observaciones_Catalogo");
		$select->joinLeft("busquedas", "(busquedas.Id_Catalogo=catalogos.Id AND busquedas.Id_Pedido = '$id_pedido')","busquedas.Fecha as Fecha_Busqueda, busquedas.Resultado as Resultado_Busqueda");
		
		$select->order("catalogos.numero");
		
		return $this->dao->fetchAll($select);
	}
	
	function getBusqueda($id_pedido, $id_catalogo){
		$select = $this->dao->select();
		$select->from("busquedas", "busquedas.*");
		$select->joinLeft("usuarios", "busquedas.Id_Usuario=usuarios.Id", "Apellido as Apellido_Usuario, Nombres as Nombre_Usuario");
		$select->where("Id_Pedido = ?", $id_pedido);
		$select->where("Id_Catalogo = ?", $id_catalogo);
		return $this->dao->fetchRow($select);
	}
	
	function guardarBusqueda($busqueda){
		$camposNuevos = "Fecha = :Fecha, Resultado = :Resultado, Comentarios = :Comentarios, Id_Usuario = :Id_Usuario";
		$inst = "INSERT INTO busquedas SET " .
				"Id_Catalogo = :Id_Catalogo,Id_Pedido = :Id_Pedido, $camposNuevos " .
				"ON DUPLICATE KEY UPDATE $camposNuevos";
		
		return $this->dao->query($inst, $busqueda);
		
	}
	
	
	//////////////////////////////////////////////////////////////////
	//////////////////////// Administracion Uniones //////////////////
	//////////////////////////////////////////////////////////////////
	
	
	////////////////////// Paises////////////////////////////////////
	function unirPaises($IdPaisAEliminar,$IdPais,$id_usuario){
	
	
	$datosCandidatos=array("Codigo_Pais"=>$IdPais);
	$resultCantidatos = $this->dao->updateAll("candidatos", $datosCandidatos,"Codigo_Pais=".$IdPaisAEliminar);
   if (is_a($resultCantidatos, "DB_Exception"))
			return $resultCantidatos;   
    
	
		
	$datosInstitucion=array("Codigo_Pais"=>$IdPais);
	$resultInstitucion = $this->dao->updateAll("instituciones", $datosInstitucion,"Codigo_Pais=".$IdPaisAEliminar);
	if (is_a($resultInstitucion, "DB_Exception"))
			return $resultInstitucion;
	
	$datosLocalidades=array("Codigo_Pais"=>$IdPais);
	$resultLocalidades = $this->dao->updateAll("localidades", $datosLocalidades,"Codigo_Pais=".$IdPaisAEliminar);
	if (is_a($resultLocalidades, "DB_Exception"))
			return $resultLocalidades; 
	
	$datosPedidos=array("Ultimo_Pais_Solicitado"=>$IdPais);
	$resultPedidos = $this->dao->updateAll("pedidos", $datosPedidos,"Ultimo_Pais_Solicitado=".$IdPaisAEliminar); 
	if (is_a($resultPedidos, "DB_Exception"))
			return $resultPedidos; 
		      
    $datosPedidos=array("Codigo_Pais_Tesis"=>$IdPais);
	$resultPedidos = $this->dao->updateAll("pedidos", $datosPedidos,"Codigo_Pais_Tesis=".$IdPaisAEliminar);
	if (is_a($resultPedidos, "DB_Exception"))
			return $resultPedidos; 
	
	$datosPedidos=array("Codigo_Pais_Patente"=>$IdPais);
	$resultPedidos = $this->dao->updateAll("pedidos", $datosPedidos,"Codigo_Pais_Patente=".$IdPaisAEliminar);
   if (is_a($resultPedidos, "DB_Exception"))
			return $resultPedidos; 
   
    $datosPedidos=array("Codigo_Pais_Congreso"=>$IdPais);
	$resultPedidos = $this->dao->updateAll("pedidos", $datosPedidos,"Codigo_Pais_Congreso=".$IdPaisAEliminar);
     if (is_a($resultPedidos, "DB_Exception"))
			return $resultPedidos; 
   
   
    $datosPedidosHistoricos=array("Ultimo_Pais_Solicitado"=>$IdPais);
	$resultPedidosHistorico = $this->dao->updateAll("pedhist", $datosPedidosHistoricos,"Ultimo_Pais_Solicitado=".$IdPaisAEliminar); 
	if (is_a($resultPedidosHistorico, "DB_Exception"))
			return $resultPedidosHistorico; 
		      
    $datosPedidosHistoricos=array("Codigo_Pais_Tesis"=>$IdPais);
	$resultPedidosHistorico = $this->dao->updateAll("pedhist", $datosPedidosHistoricos,"Codigo_Pais_Tesis=".$IdPaisAEliminar);
	if (is_a($resultPedidosHistorico, "DB_Exception"))
			return $resultPedidosHistorico; 
	
	$datosPedidosHistoricos=array("Codigo_Pais_Patente"=>$IdPais);
	$resultPedidosHistorico = $this->dao->updateAll("pedhist", $datosPedidosHistoricos,"Codigo_Pais_Patente=".$IdPaisAEliminar);
   if (is_a($resultPedidosHistorico, "DB_Exception"))
			return $resultPedidosHistorico; 
   
    $datosPedidosHistoricos=array("Codigo_Pais_Congreso"=>$IdPais);
	$resultPedidosHistorico = $this->dao->updateAll("pedhist", $datosPedidosHistoricos,"Codigo_Pais_Congreso=".$IdPaisAEliminar);
     if (is_a($resultPedidosHistorico, "DB_Exception"))
			return $resultPedidosHistorico;   
    
    $datosPedidosAnulado=array("Ultimo_Pais_Solicitado"=>$IdPais);
	$resultPedidosAnulado = $this->dao->updateAll("pedanula", $datosPedidosAnulado,"Ultimo_Pais_Solicitado=".$IdPaisAEliminar); 
	if (is_a($resultPedidosAnulado, "DB_Exception"))
			return $resultPedidosAnulado; 
		      
    $datosPedidosAnulado=array("Codigo_Pais_Tesis"=>$IdPais);
	$resultPedidosAnulado = $this->dao->updateAll("pedanula", $datosPedidosAnulado,"Codigo_Pais_Tesis=".$IdPaisAEliminar);
	if (is_a($resultPedidosAnulado, "DB_Exception"))
			return $resultPedidosAnulado; 
	
	$datosPedidosAnulado=array("Codigo_Pais_Patente"=>$IdPais);
	$resultPedidosAnulado = $this->dao->updateAll("pedanula", $datosPedidosAnulado,"Codigo_Pais_Patente=".$IdPaisAEliminar);
   if (is_a($resultPedidosAnulado, "DB_Exception"))
			return $resultPedidosAnulado; 
   
    $datosPedidosAnulado=array("Codigo_Pais_Congreso"=>$IdPais);
	$resultPedidosAnulado = $this->dao->updateAll("pedanula", $datosPedidosAnulado,"Codigo_Pais_Congreso=".$IdPaisAEliminar);
     if (is_a($resultPedidosAnulado, "DB_Exception"))
			return $resultPedidosAnulado;  
    
   $datosEventos=array("Codigo_Pais"=>$IdPais);
   $resultEventos = $this->dao->updateAll("eventos", $datosEventos,"Codigo_Pais=".$IdPaisAEliminar);
   if (is_a($resultEventos, "DB_Exception"))
			return $resultEventos;    
   
   $datosEventosHistoricos=array("Codigo_Pais"=>$IdPais);
   $resultEventosHistoricos = $this->dao->updateAll("evhist", $datosEventosHistoricos,"Codigo_Pais=".$IdPaisAEliminar);
   if (is_a($resultEventosHistoricos, "DB_Exception"))
			return $resultEventosHistoricos; 
      
   $datosEventosAnulados=array("Codigo_Pais"=>$IdPais);
   $resultEventosAnulados = $this->dao->updateAll("evanula", $datosEventosAnulados,"Codigo_Pais=".$IdPaisAEliminar);
   if (is_a($resultEventosAnulados, "DB_Exception"))
			return $resultEventosAnulados; 
      
   $datosUsuarios=array("Codigo_Pais"=>$IdPais);
   $resultUsuarios = $this->dao->updateAll("usuarios", $datosUsuarios,"Codigo_Pais=".$IdPaisAEliminar);
   if (is_a($resultUsuarios, "DB_Exception"))
			return $resultUsuarios;     
      
   $resultEliminarPaises=$this->dao->delete("paises","Id=".$IdPaisAEliminar);
   if (is_a($resultEliminarPaises, "DB_Exception"))
			return $resultEliminarPaises;              
    
    return $this->registrarUnionEntidades($id_usuario, UNION_PAISES, $IdPaisAEliminar, $IdPais); 
    

}
	
	////////////////////// Instituciones////////////////////////////////////
	
	function unirInstituciones($IdInstitucionAEliminar,$IdInstitucion,$id_usuario){

	// Calculo el paï¿½s de la nueva instituciï¿½n 
    $InstitucionNueva=$this->getObject("instituciones",array("Codigo"=>$IdInstitucion));
    $InstitucionVieja=$this->getObject("instituciones",array("Codigo"=>$IdInstitucionAEliminar));
    $Pais_Nuevo = $InstitucionNueva["Codigo_Pais"];
   
    
   
    $datosDependencia=array("Codigo_Institucion"=>$IdInstitucion);
    $resultDependencias=$this->dao->updateAll("dependencias",$datosDependencia,"Codigo_Institucion=".$IdInstitucionAEliminar); 
  	if (is_a($resultDependencias, "DB_Exception"))
			return $resultDependencias;              
  
    $datosUnidades=array("Codigo_Institucion"=>$IdInstitucion);
    $resultUnidades=$this->dao->updateAll("unidades",$datosUnidades,"Codigo_Institucion=".$IdInstitucionAEliminar); 
   	if (is_a($resultUnidades, "DB_Exception"))
			return $resultUnidades;              
  
    $datosPedidos=array("Ultimo_Pais_Solicitado"=>$Pais_Nuevo,"Ultima_Institucion_Solicitado"=>$IdInstitucion);
    $resultPedidos=$this->dao->updateAll("pedidos",$datosPedidos,"Ultima_Institucion_Solicitado=".$IdInstitucionAEliminar); 
  	if (is_a($resultPedidos, "DB_Exception"))
			return $resultPedidos;              
   
    $datosPedidos=array("Codigo_Pais_Tesis"=>$Pais_Nuevo,"Codigo_Institucion_Tesis"=>$IdInstitucion);
    $resultPedidos=$this->dao->updateAll("pedidos",$datosPedidos,"Codigo_Institucion_Tesis=".$IdInstitucionAEliminar); 
   	if (is_a($resultPedidos, "DB_Exception"))
			return $resultPedidos;              
   
   
    $datosPedidos=array("Ultimo_Pais_Solicitado"=>$Pais_Nuevo,"Ultima_Institucion_Solicitado"=>$IdInstitucion);
    $resultPedidos=$this->dao->updateAll("pedhist",$datosPedidos,"Ultima_Institucion_Solicitado=".$IdInstitucionAEliminar); 
    if (is_a($resultPedidos, "DB_Exception"))
			return $resultPedidos;              
   
    $datosPedidos=array("Codigo_Pais_Tesis"=>$Pais_Nuevo,"Codigo_Institucion_Tesis"=>$IdInstitucion);
    $resultPedidos=$this->dao->updateAll("pedhist",$datosPedidos,"Codigo_Institucion_Tesis=".$IdInstitucionAEliminar);
    if (is_a($resultPedidos, "DB_Exception"))
			return $resultPedidos;              
   
    $datosPedidos=array("Ultimo_Pais_Solicitado"=>$Pais_Nuevo,"Ultima_Institucion_Solicitado"=>$IdInstitucion);
    $resultPedidos=$this->dao->updateAll("pedanula",$datosPedidos,"Ultima_Institucion_Solicitado=".$IdInstitucionAEliminar); 
    if (is_a($resultPedidos, "DB_Exception"))
			return $resultPedidos;              
   
    $datosPedidos=array("Codigo_Pais_Tesis"=>$Pais_Nuevo,"Codigo_Institucion_Tesis"=>$IdInstitucion);
    $resultPedidos=$this->dao->updateAll("pedanula",$datosPedidos,"Codigo_Institucion_Tesis=".$IdInstitucionAEliminar);
 	if (is_a($resultPedidos, "DB_Exception"))
			return $resultPedidos;              
  
   
    $datosEventos=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$IdInstitucion);
    $resultEventos=$this->dao->updateAll("eventos",$datosEventos,"Codigo_Institucion=".$IdInstitucionAEliminar);
 	if (is_a($resultEventos, "DB_Exception"))
			return $resultEventos;              
  
    $datosEventosHistorico=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$IdInstitucion);
    $resultEventosHistorico=$this->dao->updateAll("evhist",$datosEventosHistorico,"Codigo_Institucion=".$IdInstitucionAEliminar);
 	if (is_a($resultEventosHistorico, "DB_Exception"))
			return $resultEventosHistorico;              
  
    $datosEventosAnulado=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$IdInstitucion);
    $resultEventosAnulado=$this->dao->updateAll("evanula",$datosEventosAnulado,"Codigo_Institucion=".$IdInstitucionAEliminar);
 	if (is_a($resultEventosAnulado, "DB_Exception"))
			return $resultEventosAnulado;              
  
    $datosUsuarios=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$IdInstitucion);
    $resultUsuarios=$this->dao->updateAll("usuarios",$datosUsuarios,"Codigo_Institucion=".$IdInstitucionAEliminar);
 	if (is_a($resultUsuarios, "DB_Exception"))
			return $resultUsuarios;              
  
   $datosCandidatos=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$IdInstitucion);

    $resultCandidatos=$this->dao->updateAll("candidatos",$datosCandidatos,"Codigo_Institucion=".$IdInstitucionAEliminar);

	if (is_a($resultCandidatos, "DB_Exception"))
			return $resultCandidatos;              
  


  $datosInstitucion=array("Codigo_Pedidos"=>$InstitucionVieja['Codigo_Pedidos']+$InstitucionNueva['Codigo_Pedidos']);
  $actualizarInstitucion=$this->dao->update("instituciones",$datosInstitucion,"Codigo=".$IdInstitucion);
  if (is_a($actualizarInstitucion, "DB_Exception"))
		return $actualizarInstitucion;              
  
     
   $resultEliminarInstitucion=$this->dao->delete("instituciones","Codigo=".$IdInstitucionAEliminar);
   if (is_a($resultEliminarInstitucion, "DB_Exception"))
			return $resultEliminarInstitucion;              
  
   $abreviaturaNueva=$InstitucionNueva['Abreviatura'];
   $abreviaturaVieja=$InstitucionVieja['Abreviatura'];
   $mapeoReplace=Devolver_Mapeo_ReplaceIdPedido();
   foreach ($mapeoReplace as $tabla=>$campoIdPedido){
      $this->replace_IdPedido($tabla,$campoIdPedido,$abreviaturaVieja,$abreviaturaNueva); 	 
   }
  
  return $this->registrarUnionEntidades($id_usuario, UNION_INSTITUCIONES, $IdInstitucionAEliminar, $IdInstitucion);
 }
	
function replace_IdPedido($tabla,$campoIdPedido,$abreviaturaVieja,$abreviaturaNueva){
  $consulta="UPDATE".$tabla."SET".$campoIdPedido."=REPLACE(".$campoIdPedido.",".$abreviaturaVieja.",".$abreviaturaNueva.") WHERE".$campoIdPedido." LIKE '%-".$abreviaturaVieja."-%'";
  //echo $consulta; 
 }	
	
	///////////////////////////////Dependencias//////////////////////////////////////////
	
	function unirDependencias($IdDependenciaAEliminar,$IdDependencia,$id_usuario){
		// Calculo el cï¿½digo de la nueva instituciï¿½n 
   
   
    $DependenciaNueva=$this->getObject("dependencias",array("Id"=>$IdDependencia));
    $Institucion_Nueva = $DependenciaNueva["Codigo_Institucion"];
   
    $InstitucionNueva=$this->getObject("instituciones",array("Codigo"=>$Institucion_Nueva));
    $Pais_Nuevo = $InstitucionNueva["Codigo_Pais"];
   
    $datosUnidades=array("Codigo_Dependencia"=>$IdDependencia,"Codigo_Institucion"=>$Institucion_Nueva);
    $resultUnidades=$this->dao->updateAll("unidades",$datosUnidades,"Codigo_Dependencia=".$IdDependenciaAEliminar); 
   
      
    $datosPedidos=array("Ultimo_Pais_Solicitado"=>$Pais_Nuevo,"Ultima_Institucion_Solicitado"=>$Institucion_Nueva);
    $resultPedidos=$this->dao->updateAll("pedidos",$datosPedidos,"Ultima_Dependencia_Solicitado=".$IdDependenciaAEliminar); 
   
   $datosPedidos=array("Codigo_Pais_Tesis"=>$Pais_Nuevo,"Codigo_Institucion_Tesis"=>$Institucion_Nueva,"Codigo_Dependencia_Tesis"=>$IdDependencia);
   $resultPedidos=$this->dao->updateAll("pedidos",$datosPedidos,"Codigo_Dependencia_Tesis=".$IdDependenciaAEliminar); 
   
   $datosPedidosHistoricos=array("Ultimo_Pais_Solicitado"=>$Pais_Nuevo,"Ultima_Institucion_Solicitado"=>$Institucion_Nueva,"Ultima_Dependencia_Solicitado"=>$IdDependencia);
   $resultPedidosHistoricos=$this->dao->updateAll("pedhist",$datosPedidosHistoricos,"Ultima_Dependencia_Solicitado=".$IdDependenciaAEliminar); 
   
   $datosPedidosHistoricos=array("Codigo_Pais_Tesis"=>$Pais_Nuevo,"Codigo_Institucion_Tesis"=>$Institucion_Nueva,"Codigo_Dependencia_Tesis"=>$IdDependencia);
   $resultPedidosHistoricos=$this->dao->updateAll("pedhist",$datosPedidosHistoricos,"Codigo_Dependencia_Tesis=".$IdDependenciaAEliminar); 
       
   
   
   $datosPedidosHistoricos=array("Ultimo_Pais_Solicitado"=>$Pais_Nuevo,"Ultima_Institucion_Solicitado"=>$Institucion_Nueva,"Ultima_Dependencia_Solicitado"=>$IdDependencia);
   $resultPedidosHistoricos=$this->dao->updateAll("pedanula",$datosPedidosHistoricos,"Ultima_Dependencia_Solicitado=".$IdDependenciaAEliminar); 
   
   $datosPedidosHistoricos=array("Codigo_Pais_Tesis"=>$Pais_Nuevo,"Codigo_Institucion_Tesis"=>$Institucion_Nueva,"Codigo_Dependencia_Tesis"=>$IdDependencia);
   $resultPedidosHistoricos=$this->dao->updateAll("pedanula",$datosPedidosHistoricos,"Codigo_Dependencia_Tesis=".$IdDependenciaAEliminar); 
   
   
   
   $datosEventos=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$Institucion_Nueva,"Codigo_Dependencia"=>$IdDependencia);
    $resultEventos=$this->dao->updateAll("eventos",$datosEventos,"Codigo_Dependencia=".$IdDependenciaAEliminar);
 
    $datosEventosHistorico=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$Institucion_Nueva,"Codigo_Dependencia"=>$IdDependencia);
    $resultEventosHistorico=$this->dao->updateAll("evhist",$datosEventosHistorico,"Codigo_Dependencia=".$IdDependenciaAEliminar);
 
    $datosEventosAnulado=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$Institucion_Nueva,"Codigo_Dependencia"=>$IdDependencia);
    $resultEventosAnulado=$this->dao->updateAll("evanula",$datosEventosAnulado,"Codigo_Dependencia=".$IdDependenciaAEliminar);
 
     
     $datosUsuarios=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$Institucion_Nueva,"Codigo_Dependencia"=>$IdDependencia);
    $resultUsuarios=$this->dao->updateAll("usuarios",$datosUsuarios,"Codigo_Dependencia=".$IdDependenciaAEliminar);
 
   $datosCandidatos=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$Institucion_Nueva,"Codigo_Dependencia"=>$IdDependencia);
    $resultCandidatos=$this->dao->updateAll("candidatos",$datosCandidatos,"Codigo_Dependencia=".$IdDependenciaAEliminar);

   
   $resultEliminarDependencia=$this->dao->delete("dependencias","Id=".$IdDependenciaAEliminar);
   if (is_a($resultEliminarDependencia, "DB_Exception"))
			return $resultEliminarDependencia;              
  
  return $this->registrarUnionEntidades($id_usuario, UNION_DEPENDENCIAS, $IdDependenciaAEliminar, $IdDependencia); 
 }
	
	////////////////////////////////Union unidades///////////////////////////////////////////////////////
	function unirUnidades($IdUnidadAEliminar,$IdUnidadNuevo,$id_usuario){
	
	$UnidadNueva=$this->getObject("unidades",array("Id"=>$IdUnidadNuevo));
    $Institucion_Nueva = $UnidadNueva["Codigo_Institucion"];
	$Dependencia_Nueva=$UnidadNueva["Codigo_Dependencia"];
	  
    $InstitucionNueva=$this->getObject("instituciones",array("Codigo"=>$Institucion_Nueva));
    $Pais_Nuevo = $InstitucionNueva["Codigo_Pais"];
    
	///////////////////////////////////////////////////////////////////////////////////////
	
	$datosPedidos=array("Ultimo_Pais_Solicitado"=>$Pais_Nuevo,"Ultima_Institucion_Solicitado"=>$Institucion_Nueva,"Ultima_Dependencia_Solicitado"=>$Dependencia_Nueva,"Ultima_Unidad_Solicitado"=>$UnidadNueva);
    $resultPedidos=$this->dao->updateAll("pedidos",$datosPedidos,"Ultima_Unidad_Solicitado=".$IdUnidadAEliminar); 
   
    $datosPedidos=array("Ultimo_Pais_Solicitado"=>$Pais_Nuevo,"Ultima_Institucion_Solicitado"=>$Institucion_Nueva,"Ultima_Dependencia_Solicitado"=>$Dependencia_Nueva,"Ultima_Unidad_Solicitado"=>$UnidadNueva);
    $resultPedidos=$this->dao->updateAll("pedhist",$datosPedidos,"Ultima_Unidad_Solicitado=".$IdUnidadAEliminar); 
   
    $datosPedidos=array("Ultimo_Pais_Solicitado"=>$Pais_Nuevo,"Ultima_Institucion_Solicitado"=>$Institucion_Nueva,"Ultima_Dependencia_Solicitado"=>$Dependencia_Nueva,"Ultima_Unidad_Solicitado"=>$UnidadNueva);
    $resultPedidos=$this->dao->updateAll("pedanula",$datosPedidos,"Ultima_Unidad_Solicitado=".$IdUnidadAEliminar); 
        
     
    $datosEventos=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$Institucion_Nueva,"Codigo_Dependencia"=>$Dependencia_Nueva,"Codigo_Unidad"=>$UnidadNueva);
    $resultEventos=$this->dao->updateAll("eventos",$datosEventos,"Codigo_Unidad=".$IdUnidadAEliminar);
 
    $datosEventosHistorico=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$Institucion_Nueva,"Codigo_Dependencia"=>$Dependencia_Nueva,"Codigo_Unidad"=>$UnidadNueva);
    $resultEventosHistorico=$this->dao->updateAll("evhist",$datosEventosHistorico,"Codigo_Unidad=".$IdUnidadAEliminar);
 
    $datosEventosAnulado=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$Institucion_Nueva,"Codigo_Dependencia"=>$Dependencia_Nueva,"Codigo_Unidad"=>$UnidadNueva);
    $resultEventosAnulado=$this->dao->updateAll("evanula",$datosEventosAnulado,"Codigo_Unidad=".$IdUnidadAEliminar);
 	
	//////////////////////////////////////////////////////////////////////////////////////////
    $datosUsuarios=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$Institucion_Nueva,"Codigo_Dependencia"=>$Dependencia_Nueva,"Codigo_Unidad"=>$IdUnidadNuevo);
    $resultUsuarios=$this->dao->updateAll("usuarios",$datosUsuarios,"Codigo_Unidad=".$IdUnidadAEliminar);
 
    $datosCandidatos=array("Codigo_Pais"=>$Pais_Nuevo,"Codigo_Institucion"=>$Institucion_Nueva,"Codigo_Dependencia"=>$Dependencia_Nueva,"Codigo_Unidad"=>$IdUnidadNuevo);
    $resultCandidatos=$this->dao->updateAll("candidatos",$datosCandidatos,"Codigo_Unidad=".$IdUnidadAEliminar);
      
     
   
   $resultEliminarUnidad=$this->dao->delete("unidades","Id=".$IdUnidadAEliminar);
   if (is_a($resultEliminarUnidad, "DB_Exception"))
		return $resultEliminarUnidad;              
   
   return $this->registrarUnionEntidades($id_usuario, UNION_UNIDADES, $IdUnidadAEliminar, $IdUnidadNuevo);
   
}

function registrarUnionEntidades($id_usuario, $tipo_union, $IdEntidadAEliminar, $IdEntidadNueva){
	$datosLog=array();
   $datosLog["idOperador"]=$id_usuario;
   $datosLog["fecha"]=date("Y-m-d H:i:s");
   $datosLog["tipoEvento"]=$tipo_union;
   $datosLog["idViejo"]=$IdEntidadAEliminar;
   $datosLog["idNuevo"]=$IdEntidadNueva;
   return $this->dao->insert("log", $datosLog); 
}


/////////////////////////////////////////////Titulos Colecciones//////////////////////////////////////////////
function getTituloColeccion($id_coleccion){
	return $this->getObject("titulos_colecciones",array("Id" => $id_coleccion));
}

function unirTitulosColecciones($IdTituloAEliminar,$IdTitulo,$id_usuario){
	

	$Titulo=$this->getObject("titulos_colecciones",array("Id"=>$IdTitulo));
    $TituloNuevo = $Titulo["Nombre"];
	
	$datosPedidos=array("Codigo_Titulo_Revista"=>$IdTitulo,"Titulo_Revista"=>$TituloNuevo);
    $resultPedidos=$this->dao->updateAll("pedidos",$datosPedidos,"Codigo_Titulo_Revista=".$IdTituloAEliminar); 
   
    $datosPedidos=array("Codigo_Titulo_Revista"=>$IdTitulo,"Titulo_Revista"=>$TituloNuevo);
    $resultPedidos=$this->dao->updateAll("pedhist",$datosPedidos,"Codigo_Titulo_Revista=".$IdTituloAEliminar); 
   
    $datosPedidos=array("Codigo_Titulo_Revista"=>$IdTitulo,"Titulo_Revista"=>$TituloNuevo);
    $resultPedidos=$this->dao->updateAll("pedanula",$datosPedidos,"Codigo_Titulo_Revista=".$IdTituloAEliminar); 
   

   $resultEliminarTitulo=$this->dao->delete("titulos_colecciones","Id=".$IdTituloAEliminar);
   if (is_a($resultEliminarTitulo, "DB_Exception"))
			return $resultEliminarTitulo;              

  return $this->registrarUnionEntidades($id_usuario, UNION_TITULOS_COLECCIONES, $IdTituloAEliminar, $IdTitulo);
  
}

////////////////////////////////////////Tipos de usuarios/////////////////////////////////////////////


function unirCategoria($IdCategoriaAEliminar,$IdCategoria,$id_usuario){						
    
   $datosUsuario=array("Codigo_Categoria"=>$IdCategoria);
   $resultUsuarios=$this->dao->updateAll("usuarios",$datosUsuario,"Codigo_Categoria=".$IdCategoriaAEliminar); 
     
   $datosCategoria=array("Codigo_Categoria"=>$IdCategoria);
   $resultUsuarios=$this->dao->updateAll("candidatos",$datosCategoria,"Codigo_Categoria=".$IdCategoriaAEliminar); 
       
 $resultEliminarCategoria=$this->dao->delete("tab_categ_usuarios","Id=".$IdCategoriaAEliminar);
   if (is_a($resultEliminarCategoria, "DB_Exception"))
			return $resultEliminarCategoria;              
  
   return $this->registrarUnionEntidades($id_usuario, UNION_CATEGORIAS, $IdCategoriaAEliminar, $IdCategoria);

}

//////////////////////////////////////////////////Usuarios ////////////////////////////////////////

function unirUsuarios($IdUsuarioAEliminar,$IdUsuario,$id_usuario){
	
   $datosUsuario=array("Codigo_Usuario"=>$IdUsuario);
   $resultUsuarios=$this->dao->updateAll("pedidos",$datosUsuario,"Codigo_Usuario=".$IdUsuarioAEliminar); 
    
   $datosUsuario=array("Usuario_Creador"=>$IdUsuario);
   $resultUsuarios=$this->dao->updateAll("pedidos",$datosUsuario,"Usuario_Creador=".$IdUsuarioAEliminar);
   

   $datosUsuario=array("Codigo_Usuario"=>$IdUsuario);
   $resultUsuarios=$this->dao->updateAll("pedhist",$datosUsuario,"Codigo_Usuario=".$IdUsuarioAEliminar); 
    
   $datosUsuario=array("Usuario_Creador"=>$IdUsuario);
   $resultUsuarios=$this->dao->updateAll("pedhist",$datosUsuario,"Usuario_Creador=".$IdUsuarioAEliminar);

   $datosUsuario=array("Codigo_Usuario"=>$IdUsuario);
   $resultUsuarios=$this->dao->updateAll("pedanula",$datosUsuario,"Codigo_Usuario=".$IdUsuarioAEliminar); 
    
   $datosUsuario=array("Usuario_Creador"=>$IdUsuario);
   $resultUsuarios=$this->dao->updateAll("pedanula",$datosUsuario,"Usuario_Creador=".$IdUsuarioAEliminar);
    
   $datosUsuario=array("Codigo_Usuario"=>$IdUsuario);
   $resultUsuarios=$this->dao->updateAll("mail",$datosUsuario,"Codigo_Usuario=".$IdUsuarioAEliminar);
    
   

    $resultEliminarCategoria=$this->dao->delete("usuarios","Id=".$IdUsuarioAEliminar);
   if (is_a($resultEliminarCategoria, "DB_Exception"))
			return $resultEliminarCategoria;              
  
  	return $this->registrarUnionEntidades($id_usuario, UNION_USUARIOS, $IdUsuario, $IdUsuarioAEliminar);
   
}

function tipo_pedido_x_defecto($id_usuario){
	$usuario= $this->getUsuario($id_usuario);
	$institucion= $this->getInstitucion($usuario["Codigo_Institucion"]);
	return $institucion["tipo_pedido_nuevo"];
}







///////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////Categorias de Usuarios////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

	function getCategoria($idCategoria) {
		$conditions= array("Id" => $idCategoria);
		return $this->getObject("tab_categ_usuarios", $conditions);
	}
	
	function getCategoriasUsuarios($conditions=array()){
		return $this->getAllObjects("tab_categ_usuarios", $conditions, $cols = "*", $order = "Nombre");
	}
	
	function insertCategoriaUsuario($Categoria){
		return $this->dao->insert("tab_categ_usuarios", array("Nombre" => $Categoria));
	}
	
	function updateCategoriaUsuario($Categ){
		$id_tab_categ_usuarios = $Categ["Id"];
		unset($Categ["Id"]);
		return $this->dao->update("tab_categ_usuarios", array("Nombre" => $Categ["nombre"]), "Id = $id_tab_categ_usuarios");
	}
	
	
	
	
	//////////////////////////////////////////////////////////////////
	//////////////////////// Instancia Celsius ///////////////////////
	//////////////////////////////////////////////////////////////////
	
 	 function getInstancia_Celsius($idInstanciaCelsius){
 		$select = $this->dao->select();
 		$select->from("instancias_celsius");
 		/*$select->joinInner("instituciones", "instituciones.id=instancias_celsius.id_institucion", "instituciones.nombre as institucion, instituciones.id_pais as id_pais");
 		$select->joinInner("paises", "paises.id=instituciones.id_pais", "paises.nombre as pais");
 		$select->joinLeft("dependencias", "dependencias.id=instancias_celsius.id_dependencia", "dependencias.nombre as dependencia");
 		$select->joinLeft("unidades", "unidades.id=instancias_celsius.id_unidad", "unidades.nombre as unidad");
 		*/
 		$select->where("id = ?", $idInstanciaCelsius);
 		
 		$resul1= $this->dao->fetchRow($select);

 		return $resul1;
 		 		
 	}
 	function agregarPlantilla($plantilla){
 		return $this->dao->insert("plantmail",$plantilla );
		
 	}
 	
 	function modificarPlantilla($plantilla){
 		$id=$plantilla["Id"];
 		return $this->dao->update("plantmail", $plantilla,"Id=".$id);
 	}
 	function getInstancias_Celsius($cols = "*"){
 		return $this->getAllObjects("instancias_celsius",null,$cols,"id");
 	}


    function getPlantilla($conditions=array(), $cols="*"){
		return $this->getObject("plantmail", $conditions);
    }

	function getPlantillas($conditions=array()){
		return $this->getAllObjects("plantmail", $conditions);
    }
	//////////////////////////////////////////////////////////////////
	//////////////////////// parametros  /////////////////////////////
	//////////////////////////////////////////////////////////////////
	
	function getParametros(){
		return $this->getObject("parametros");
	}
	
	function modificarParametros($parametros){
 		return $this->dao->update("parametros", $parametros,"id=1");
 	}

	//////////////////////////////////////////////////////////////////
	//////////////////////// mail//////  /////////////////////////////
	//////////////////////////////////////////////////////////////////
	
	function agregarMail($mail){
  		return $this->dao->insert("mail", $mail);
	}

	function getMail($id_mail){
		$select = $this->dao->select();
		$select->from("mail","mail.*");
		$select->joinInner("usuarios", "usuarios.Id = mail.Codigo_Usuario", "usuarios.Nombres as Nombre_Usuario,usuarios.Apellido as Apellido_Usuario");
		$select->where("mail.Id = $id_mail");
		return $this->dao->fetchRow($select);
	}
	
	function getMails($conditions = array()){
		return $this->getAllObjects("mail", $conditions, "*", "Fecha DESC, Hora DESC");
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////// Mensajes_Usuarios ////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////
	
	function agregarMensaje_Usuario($mensaje_usuario){
		return $this->dao->insert("mensajes_usuarios", $mensaje_usuario);
	}
	
	function getMensajes_Usuarios($conditions){
		return $this->getAllObjects("mensajes_usuarios", $conditions,"*","leido DESC");
	}

	function setMensajeLeido($idMensaje){
		return $this->dao->update("mensajes_usuarios", array("leido" =>1, "fecha_leido"=>date("Y-m-d H:i:s")), "id ='".$idMensaje."'");
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////Funciones que estaban FGenPed///////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////


	/**
	 * Envia un mail a un destinatario.
	 * @param string $to la direccion q sera usada como destino del mail
	 * @param string $subject el asunto del mail
	 * @param string $text el texto del mail
	 * @param int $id_usuario el id del usuario al que se le esta enviando el mail ( en el caso de candidatos es el id de la tabla candidatos)
	 * @return bool true si el mail ue enviado satisfactoriamente, false si ocurrio un error en el envio de mail
	 * @throws Celsius_Exception si se produjo algun error al tratar de insertar el mail enviado en la base de datos
	 */
	function enviar_mail($to,$subject,$text, $id_usuario, $id_candidato = 0,$id_operador = 0,$id_pedido = 0){
		$from = Configuracion::getMailContacto();
		
		//comentar esta linea para desarrollo
		$crlf = "\r\n";
		$additionalHeaders = 'From: ' . $from . $crlf;
     	$additionalHeaders .= 'Return-Path: ' . $from . $crlf;
    	$additionalHeaders .= 'Reply-To: ' .$from . $crlf;
    	$additionalHeaders .= 'Errors-To: ' .$from;
		@$resultado = mail($to, $subject , $text, $additionalHeaders,"-f $from");
		
		if ($resultado === true){
			$mail = array();
			$mail["Codigo_Usuario"] = $id_usuario;
			$mail["Id_Candidato"] = $id_candidato;
			$mail["Codigo_Usuario_From"] = $id_operador;
			$mail["Fecha"] = date("Y-m-d");
			$mail["Hora"] = date("H:i:s");
			$mail["Direccion"] = $to;
			$mail["Asunto"] = $subject;
			$mail["Texto"] = $text;
			$mail["Codigo_Pedido"] = $id_pedido;
			return $this->agregarMail($mail);
		}else
			return $resultado;
	}

	/**
	 * Se usa en el contexto del envï¿½o de mails dirigidos a listas de usuarios 
	 * que poseen pedidos para entregar, en las plantillas contruidas a tal fin
	 * va a figurar como variable los valores de nï¿½mero total de pedidos por 
	 * entregar y mï¿½nimo de fecha en la que se recibiï¿½ un pedido. 
	 */
	function reemplazar_variables_plantilla($origen, $usuario_destino, $campos = array()) {
		

		if ((strpos($origen, "/*pedido*/") !== false) && isset($campos["Id_Pedido"])){
				$origen = substr_replace($origen, $campos["Id_Pedido"], strpos($origen, "/*pedido*/")) . substr(strstr($origen, "/*pedido*/"), 10, strlen($origen));
		}
		if (strpos($origen, "/*usuario*/") !== false) {
			$origen = substr_replace($origen, $usuario_destino["Apellido"].", ".$usuario_destino["Nombres"], strpos($origen, "/*usuario*/")) . substr(strstr($origen, "/*usuario*/"), 11, strlen($origen));
		}
		if ((strpos($origen, "/*paginas*/") !== false) && isset($campos["Id_Pedido"]) && isset($campos["paginas"])) {
			$origen = substr_replace($origen, $campos["paginas"], strpos($origen, "/*paginas*/")) . substr(strstr($origen, "/*paginas*/"), 11, strlen($origen));
		}
		if ((strpos($origen, "/*cita*/") !== false) && isset($campos["Id_Pedido"]) && isset($campos["cita"])) {
			$origen = substr_replace($origen, $campos["cita"], strpos($origen, "/*cita*/")) . substr(strstr($origen, "/*cita*/"), 8, strlen($origen));
		}
		if ((strpos($origen, "/*numero_pedidos*/") !== false) && isset($campos["numero_pedidos"])) {
			$origen = substr_replace($origen, $campos["numero_pedidos"], strpos($origen, "/*numero_pedidos*/")) . substr(strstr($origen, "/*numero_pedidos*/"), 18, strlen($origen));
		}
		if ((strpos($origen, "/*minima_fecha*/") !== false)  && isset($campos["Id_Pedido"]) && isset($campos["minima_fecha"])){
			$origen = substr_replace($origen, $campos["minima_fecha"], strpos($origen, "/*minima_fecha*/")) . substr(strstr($origen, "/*minima_fecha*/"), 16, strlen($origen));
		}
		if (strpos($origen, "/*login*/") !== false) {
			$origen = substr_replace($origen, $usuario_destino["Login"], strpos($origen, "/*login*/")) . substr(strstr($origen, "/*login*/"), 9, strlen($origen));
		}
		if (strpos($origen, "/*password*/") !== false) {
			$origen = substr_replace($origen, $usuario_destino["Password"], strpos($origen, "/*password*/")) . substr(strstr($origen, "/*password*/"), 12, strlen($origen));
		}

		return $origen;
	}
	
	function getPedidoCompleto($id_pedido, $tablaPedidos = "pedidos"){
		$select = $this->armarSelectPedidosCompletos($tablaPedidos);
		$select->where("tPedidos.Id = ?", $id_pedido);
 		return $this->dao->fetchRow($select);
 		
	}

    function pasarPedidoABusqueda($id_pedido,$colsToUpdate){
    	return $this->dao->update("pedidos", $colsToUpdate, "Id='$id_pedido'");
    }
	function getPedidosConEventos($conditionsEventos, $tablaEventos = "eventos"){
		if ($tablaEventos == "eventos")
			$tablaPedidos = "pedidos";
		elseif ($tablaEventos == "evhist")
			$tablaPedidos = "pedhist";
		elseif ($tablaEventos == "evanula")
			$tablaPedidos = "pedanula";
		
		$select = $this->armarSelectPedidosCompletos($tablaPedidos);
		$select->joinInner("$tablaEventos as tEventos","tEventos.Id_Pedido = tPedidos.Id","tEventos.Id as Id_Evento");
		
		foreach($conditionsEventos as $fieldName => $fieldValue){
 			$select->where("tEventos.$fieldName = ?", $fieldValue);
 		}
 		
		return $this->dao->fetchAll($select);
	}
	
	function getCountPedidosEnEstados($estados,$conditions = array(),$tablaPedidos = "pedidos",$rol_usuario = ROL__ADMINISTADOR, $id_usuario = 0){
		$select = $this->dao->select();
		$select->from("$tablaPedidos as tPedidos", "count(*) as cantidad");
		
		foreach($conditions as $fieldName => $fieldValue)
			$select->where("tPedidos.$fieldName = ?", $fieldValue);
		
		if ($tablaPedidos == "pedidos")
			$tablaEventos = "eventos";
		elseif ($tablaPedidos == "pedhist")
			$tablaEventos = "evhist";
		elseif ($tablaPedidos == "pedanula")
			$tablaEventos = "evanula";
			
		$eventosOr = "";
		foreach($estados as $estado){
			
			if ($estado == ESTADO__SOLICITADO){
				$eventosOr = "(" .
						"EXISTS (" .
						"	SELECT * FROM $tablaEventos as tEventos WHERE (tEventos.Id_Pedido = tPedidos.Id) AND (tEventos.Codigo_Evento = ".EVENTO__A_SOLICITADO.") AND (tEventos.vigente = 1)" .
						"		) " .
						"AND " .
						"NOT EXISTS (
							SELECT * 
							FROM $tablaEventos as tEventos 
							WHERE 
								(tEventos.Codigo_Evento IN (6,7,8,9,11,13,14,15)) 
								AND 
								(tEventos.vigente = 1)
							)"
						.") OR ";
				
			}elseif ($estado == ESTADO__BUSQUEDA){
				$eventosOr = "(tPedidos.En_Busqueda = 1) OR ";
			}else{
				switch($estado){
					case ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_USUARIO:
						$codigo_evento = EVENTO__A_ESPERA_DE_CONF_USUARIO;
						break;
					case ESTADO__CONFIRMADO_POR_EL_USUARIO:
						 $codigo_evento = EVENTO__CONFIRMADO_POR_USUARIO;
						break; 
					case ESTADO__EN_OBSERVACION:
						 $codigo_evento = EVENTO__A_OBSERVACION;
						break; 
					case ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_OPERADOR:
						 $codigo_evento = EVENTO__A_ESPERA_DE_CONF_OPERADOR;
						break;
					case ESTADO__CONFIRMADO_POR_EL_OPERADOR:
						 $codigo_evento = EVENTO__CONFIRMADO_POR_OPERADOR;
						break;
					default:
						$codigo_evento = 0;
				}
				if ($codigo_evento != 0)
					$eventosOr = "(" .
						"EXISTS (" .
						"	SELECT * FROM $tablaEventos as tEventos WHERE (tEventos.Id_Pedido = tPedidos.Id) AND (tEventos.Codigo_Evento = $codigo_evento) AND (tEventos.vigente = 1)" .
						"		) " .
						") OR ";
			}
		}
		if (sizeof($estados) > 0)
			$select->where("(".$eventosOr."tPedidos.Estado in (".implode(", ",$estados)."))");
		
		if ($rol_usuario == ROL__BIBLIOTECARIO)
			$select->where("((tPedidos.Codigo_Usuario = $id_usuario) OR (tPedidos.Usuario_Creador = $id_usuario))");
		elseif ($rol_usuario == ROL__USUARIO)
			$select->where("tPedidos.Codigo_Usuario = $id_usuario");
		
        $result = $this->dao->fetchRow($select, $conditions);
        if (is_a($result,"Celsius_Exception"))
        	return $result;
        return $result['cantidad'];
	}
	
	/**
	 * Devuelve la lista de pedidos que estan en un estado determinado para todos los usuarios
	 * que cumplan con las condiciones especificadas como parametro
	 */
	function getPedidosEntregadosDeUsuarios($conditions=array(), $Estado=0, $rol_usuario = ROL__ADMINISTADOR, $id_usuario = 0){
		
		$select = $this->dao->select();
		$select->from("pedhist as tPedidos", "tPedidos.*");
		$select->joinInner("usuarios as tUsuario", "tPedidos.Codigo_Usuario=tUsuario.Id","tUsuario.Id as idUsuario, tUsuario.Apellido as Apellido_Usuario, tUsuario.Nombres as Nombre_Usuario");
		if ($Estado == 0)
			$select->where("((tPedidos.Estado = ".ESTADO__ENTREGADO_IMPRESO.") OR (tPedidos.Estado = ".ESTADO__DESCAGADO_POR_EL_USUARIO."))");
		else
			$select->where("(tPedidos.Estado = ?",$Estado);
		//$select->limit(300);
		foreach ($conditions as $fieldName => $fieldValue){
			$select->where("tUsuario.$fieldName = ?",$fieldValue);
		}
		
		if ($rol_usuario == ROL__BIBLIOTECARIO)
			$select->where("((tPedidos.Codigo_Usuario = $id_usuario) OR (tPedidos.Usuario_Creador = $id_usuario))");
		elseif ($rol_usuario == ROL__USUARIO)
			$select->where("tPedidos.Codigo_Usuario = $id_usuario");
		
		$select->order("Apellido_Usuario");
		
		return $this->dao->fetchAll($select);
	}
	
	
	
	function getPedidosEnEstados($estados,$conditions = array(),$tablaPedidos = "pedidos", $rol_usuario = ROL__ADMINISTADOR, $id_usuario = 0){
		if (!is_array($estados))
			$estados = (array)$estados;
		
		$select = $this->armarSelectPedidosCompletos($tablaPedidos);
		
		foreach($conditions as $fieldName => $fieldValue){
 			$select->where("tPedidos.$fieldName = ?", $fieldValue);
 		}
		
		if ($tablaPedidos == "pedidos")
			$tablaEventos = "eventos";
		elseif ($tablaPedidos == "pedhist")
			$tablaEventos = "evhist";
		elseif ($tablaPedidos == "pedanula")
			$tablaEventos = "evanula";
			
		$eventosOr = "";
		foreach($estados as $estado){
			
			if ($estado == ESTADO__SOLICITADO){
				$eventosOr = "(" .
						"EXISTS (" .
						"	SELECT * FROM $tablaEventos as tEventos WHERE (tEventos.Id_Pedido = tPedidos.Id) AND (tEventos.Codigo_Evento = ".EVENTO__A_SOLICITADO.") AND (tEventos.vigente = 1)" .
						"		) " .
						"AND " .
						"NOT EXISTS (
							SELECT * 
							FROM $tablaEventos as tEventos 
							WHERE 
								(tEventos.Codigo_Evento IN (6,7,8,9,11,13,14,15)) 
								AND 
								(tEventos.vigente = 1)
							)"
						.") OR ";
				
			}elseif ($estado == ESTADO__BUSQUEDA){
				$eventosOr = "(tPedidos.En_Busqueda = 1) OR ";
			}else{
			
				switch($estado){
					case ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_USUARIO:
						$codigo_evento = EVENTO__A_ESPERA_DE_CONF_USUARIO;
						break;
					case ESTADO__CONFIRMADO_POR_EL_USUARIO:
						 $codigo_evento = EVENTO__CONFIRMADO_POR_USUARIO;
						break; 
					case ESTADO__EN_OBSERVACION:
						 $codigo_evento = EVENTO__A_OBSERVACION;
						break; 
					case ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_OPERADOR:
						 $codigo_evento = EVENTO__A_ESPERA_DE_CONF_OPERADOR;
						break;
					case ESTADO__CONFIRMADO_POR_EL_OPERADOR:
						 $codigo_evento = EVENTO__CONFIRMADO_POR_OPERADOR;
						break;
					case ESTADO__RECLAMADO_POR_USUARIO:
						 $codigo_evento = EVENTO__A_RECLAMADO_POR_USUARIO;
						break;
					default:
						$codigo_evento = 0;
				}
				if ($codigo_evento != 0)
					$eventosOr = "(" .
						"EXISTS (" .
						"	SELECT * FROM $tablaEventos as tEventos WHERE (tEventos.Id_Pedido = tPedidos.Id) AND (tEventos.Codigo_Evento = $codigo_evento) AND (tEventos.vigente = 1)" .
						"		) " .
						") OR ";
			}
		}
		if (sizeof($estados) > 0)
			$select->where("(".$eventosOr."tPedidos.Estado in (".implode(", ",$estados)."))");
		
		if ($rol_usuario == ROL__BIBLIOTECARIO){
			$select->where("((Codigo_Usuario = $id_usuario) OR (Usuario_Creador = $id_usuario))");
		}elseif ($rol_usuario == ROL__USUARIO){
			$select->where("Codigo_Usuario = $id_usuario");
		}
		$select->order("tPedidos.Fecha_Alta_Pedido");
		return $this->dao->fetchAll($select);
		
	}

	function getPedidosCompletos($conditions = array(),$tablaPedidos = "pedidos"){
		//$joins = array ("usuario", "creador","operador","unidad_usuario");
		$select = $this->armarSelectPedidosCompletos($tablaPedidos);
		foreach($conditions as $fieldName => $fieldValue){
 			$select->where("tPedidos.$fieldName = ?", $fieldValue);
 		}
 		
		return $this->dao->fetchAll($select);
	}
	
	function findPedidosCompletos($conditions = array(),$tablaPedidos = "pedidos",$bool = "and"){
		//$joins = array ("usuario", "creador","operador","unidad_usuario");
		$select = $this->armarSelectPedidosCompletos($tablaPedidos);
		//$select->limit(300);
		$conditions2 = array();
		foreach($conditions as $fieldName => $fieldValue){
 			if (is_string($fieldValue) && ($fieldName != "Id")){
 				$conditions2["tPedidos.".$fieldName] = '%'.$fieldValue.'%';
 			}else
 				$conditions2["tPedidos.".$fieldName] = $fieldValue;
 		}
 		//var_dump($select);
		return $this->findAllObjects($select, $conditions2,$bool);
		
	}
	
	/*
	 * 
	 * */
	 function getPedidoDescripcion($datosPedido){
	 	$TipoMaterial = $datosPedido["Tipo_Material"];
	 	switch ($TipoMaterial) {
			case TIPO_MATERIAL__REVISTA :
	 	         	$resul= $datosPedido['Titulo_Revista'];
					break;
			case TIPO_MATERIAL__LIBRO :
					$resul= $datosPedido['Titulo_Libro'];
					break;
			case TIPO_MATERIAL__PATENTE :
					$resul= $datosPedido['Numero_Patente'];
					break;
			case TIPO_MATERIAL__TESIS :
					$resul= $datosPedido['TituloTesis'];
					break;
			case TIPO_MATERIAL__CONGRESO :	 	    
					$resul= $datosPedido['TituloCongreso'];
					break;
	 	}
	 	return $resul;
	 }
	
	
	
	
	/**
	 * genera el sql para el cambio de tipo de material
	 */
	function cambiar_tipo_material($id_pedido, $tipoOrigen, $tipoDestino, $campos_tipo){
	  $pedido= $this->getPedido($id_pedido, "pedidos", '*');
	  $sql= "UPDATE pedidos SET ";
	  $observaciones= $pedido['Observaciones'].' // ';
	  	  
	  /*cambiar el tipo*/
	  $sql.= "Tipo_Material='".$tipoDestino."'";
	  	  
	  /*campos destino --> son los campos del pedido que van a tomar valor del tipo de material viejo*/
	  $campos_destino=array();
	  foreach($campos_tipo as $campo){
	  	$campos_destino[]=$campo[$tipoDestino];
	  }
	  
	  /*campos origen --> son los campos del pedido (tipo de material actual) que van a tomar valor ''*/ 
	  $campos_origen= array_keys($campos_tipo);
	 	  	 
	  /*array que contiene (campo_origen, campo_destino)*/
	  $aux=array();
	  for($i=0;$i<sizeof($campos_destino);$i++){
	  	if (!empty($campos_destino[$i])){
				$aux[]= array("origen"=>$campos_origen[$i],"destino"=> $campos_destino[$i]);
			}
			else{
				/*el contenido de los viejos campos  que machean con nulo se van a cargar en el campo observaciones*/
				$observaciones.= $campos_origen[$i].'='.$pedido[$campos_origen[$i]].' // ';	
			}
	  }
	  
	  /*genero las sentencia sql para el nuevo tipo*/
	  foreach ($aux as $par){
	  	$datosOrigen= $pedido[$par["origen"]];
	  	$sql.= ", ".$par["destino"]."="."'".$datosOrigen."'";
	  }
	  
	  
	  /*genero las sentencias sql para "borrar" el contenido de los campos del viejo tipo*/
	  foreach($campos_origen as $campo){
	  	if($campo!='Autor_Detalle1')
	  		$sql.= ", ".$campo."=''";
	  }
	
	  /*genero la sentencia sql para el campo observaciones*/
	  $sql.= ", "."Observaciones='".$observaciones."'";
	  	  	  
	  $sql.=" where Id='".$id_pedido."';";			  	  

 	  $res= $this->ejecutarSQL($sql);
	  if (is_a($res, "Celsius_Exception")){
			return $res;
	  }	  
	  return true;
	}
	
	function armarSelectPedidosCompletos($tablaPedidos = "pedidos", $joins =array ("usuario", "creador","operador","unidad_usuario","pais_solicitado","institucion_solicitada","dependencia_solicitada","Pais_Congreso","Pais_Patente", "Pais_Tesis", "Institucion_Tesis", "Dependencia_Tesis","titulos_colecciones")){
		/*el parametro tipo indica si la consulta debe realizarse con condiciones and u or de los valores que son pasados en conditions
		 * el parametro aprox indica si la busqueda es exacta o aproximada
		*/
		$select = $this->dao->select("tPedidos.*");
	
		//TODO if $tablaPedidos is array hacer una union
		$select->from("$tablaPedidos as tPedidos", "tPedidos.*");
		if (array_search("usuario", $joins) !== FALSE){
			$select->joinLeft("usuarios as tUsuario", "tPedidos.Codigo_Usuario=tUsuario.Id", "tUsuario.Apellido as Apellido_Usuario,tUsuario.Nombres as Nombre_Usuario");
			
		if (array_search("unidad_usuario", $joins) !== FALSE)
			$select->joinLeft("unidades as tUnidadUsuario", "tUsuario.Codigo_Unidad=tUnidadUsuario.Id","tUnidadUsuario.Nombre as Nombre_Unidad_Usuario");
		}

		if (array_search("creador", $joins) !== FALSE)
			$select->joinLeft("usuarios as tCreador", "tPedidos.Usuario_Creador=tCreador.Id","tCreador.Apellido as Apellido_Creador,tCreador.Nombres  as Nombre_Creador");
		if (array_search("operador", $joins) !== FALSE)
			$select->joinLeft("usuarios as tOperador", "tPedidos.Operador_Corriente=tOperador.Id","tOperador.Apellido as Apellido_Operador,tOperador.Nombres  as Nombre_Operador");
		if (array_search("pais_solicitado", $joins) !== FALSE)
			$select->joinLeft("paises as tPaisSolicitado", "tPedidos.Ultimo_Pais_Solicitado=tPaisSolicitado.Id","tPaisSolicitado.Nombre as Nombre_Pais_Solicitado");
		if (array_search("institucion_solicitada", $joins) !== FALSE)
			$select->joinLeft("instituciones as tInstitucionSolicitada", "tPedidos.Ultima_Institucion_Solicitado=tInstitucionSolicitada.Codigo","tInstitucionSolicitada.Nombre as Nombre_Institucion_Solicitada");
		if (array_search("dependencia_solicitada", $joins) !== FALSE)
			$select->joinLeft("dependencias as tdependenciaSolicitada", "tPedidos.Ultima_Dependencia_Solicitado=tdependenciaSolicitada.Id","tdependenciaSolicitada.Nombre as Nombre_Dependencia_Solicitada");
		if (array_search("titulos_colecciones", $joins) !== FALSE)
			$select->joinLeft("titulos_colecciones", "tPedidos.Codigo_Titulo_Revista=titulos_colecciones.Id","titulos_colecciones.Id as Id_Titulo_Colecciones,titulos_colecciones.Nombre as Nombre_Titulo_Colecciones");
		if (array_search("Pais_Congreso", $joins) !== FALSE)
			$select->joinLeft("paises as tPaisCongreso", "tPedidos.Codigo_Pais_Congreso=tPaisCongreso.Id","tPaisCongreso.Id as Id_Pais_Congreso,tPaisCongreso.Nombre as Nombre_Pais_Congreso");
		if (array_search("Pais_Patente", $joins) !== FALSE)
			$select->joinLeft("paises as tPaisPatente", "tPedidos.Codigo_Pais_Patente=tPaisPatente.Id","tPaisPatente.Id as Cod_Pais_Patente,tPaisPatente.Nombre as Nombre_Pais_Patente");
		if (array_search("Pais_Tesis", $joins) !== FALSE)
			$select->joinLeft("paises as tPaisTesis", "tPedidos.Codigo_Pais_Tesis=tPaisTesis.Id","tPaisTesis.Id as Cod_Pais_Tesis,tPaisTesis.Nombre as Nombre_Pais_Tesis");
		if (array_search("Institucion_Tesis", $joins) !== FALSE)
			$select->joinLeft("instituciones as tInstitucionTesis", "tPedidos.Codigo_Institucion_Tesis=tInstitucionTesis.Codigo","tInstitucionTesis.Codigo as Cod_Institucion_Tesis,tInstitucionTesis.Nombre as Nombre_Institucion_Tesis");
		if (array_search("Dependencia_Tesis", $joins) !== FALSE)
			$select->joinLeft("dependencias as tDependenciaTesis", "tPedidos.Codigo_Dependencia_Tesis=tDependenciaTesis.Id","tDependenciaTesis.Id as Cod_Dependencia_Tesis,tDependenciaTesis.Nombre as Nombre_Dependencia_Tesis");
 		
 		
 		
 		$select->order("tPedidos.Id");
 		return $select;
	}


	function modificarPedido($id_pedido,$colsToUpdate){
		return $this->dao->update("pedidos", $colsToUpdate, "Id='$id_pedido'");
	}

/**
 * Devuelve un conjunto de eventos de un pedido segun los parametros indicados
 * @param string tablaEventos La tabla de eventos que se debe utilizar para la consulta. Puede ser eventos, evhist o evanula
 * @param array conditions El conjunto de condiciones q deben cumplir los eventos retornados
 */
	function getEventosCompletos($conditions = array(),$tablaEventos = "eventos") {
		$select = $this->dao->select();
		$select->from("$tablaEventos as tEventos", "tEventos.*");
		$select->joinLeft("paises as tPaises","tEventos.Codigo_Pais = tPaises.Id","tPaises.Nombre as Nombre_Pais");
		$select->joinLeft("instituciones as tInstituciones","tEventos.Codigo_Institucion = tInstituciones.Codigo","tInstituciones.Nombre as Nombre_Institucion");
		$select->joinLeft("dependencias as tdependencias","tEventos.Codigo_Dependencia = tdependencias.Id","tdependencias.Nombre as Nombre_Dependencia");
		$select->joinLeft("usuarios as tOperador","tEventos.Operador = tOperador.Id","tOperador.Apellido as Apellido_Operador,tOperador.Nombres as Nombre_Operador");
				
		foreach($conditions as $fieldName => $fieldValue){
 			$select->where("tEventos.$fieldName = ?", $fieldValue);
 		}
	 	
		$select->order("tEventos.Fecha,tEventos.Codigo_Evento");
		$res = $this->dao->fetchAll($select);
		return $res;
	}

	function getEventoCompleto($id_evento,$tablaEventos = "eventos") {
		$select = $this->dao->select();
		$select->from("$tablaEventos as tEventos", "tEventos.*");
		$select->joinLeft("paises as tPaises","tEventos.Codigo_Pais = tPaises.Id","tPaises.Nombre as Nombre_Pais");
		$select->joinLeft("instituciones as tInstituciones","tEventos.Codigo_Institucion = tInstituciones.Codigo","tInstituciones.Nombre as Nombre_Institucion");
		$select->joinLeft("dependencias as tdependencias","tEventos.Codigo_Dependencia = tdependencias.Id","tdependencias.Nombre as Nombre_Dependencia");
		$select->joinLeft("usuarios as tOperador","tEventos.Operador = tOperador.Id","tOperador.Apellido as Apellido_Operador,tOperador.Nombres as Nombre_Operador");
		$select->joinLeft("mail","tEventos.Id_Correo = mail.Id","mail.Asunto as Asunto_Mail,mail.Texto as Texto_Mail,mail.Direccion as Direccion_Mail");
		
		$select->where("tEventos.Id = ?", $id_evento);
 		
		$select->order("tEventos.Fecha,tEventos.Codigo_Evento");
		$res = $this->dao->fetchRow($select);	
		return $res;
	}


	/**
	 * Devuelve todos los eventos de un pedido agrupados de acuerdo a la solicitud a la que perteneces. 
	 */
	function getEventosCompletosAgrupados($conditions = array(),$tablaEventos = "eventos") {
		$eventos= $this->getEventosCompletos($conditions, $tablaEventos);
		$eventosSeparados= array();
		foreach($eventos as $evento){
			if (($evento["id_evento_origen"]!=0) && 
				($evento["Codigo_Evento"]==EVENTO__A_RECIBIDO || 
				$evento["Codigo_Evento"]==EVENTO__A_ENTREGADO_IMPRESO || 
				$evento["Codigo_Evento"]==EVENTO__A_AUTORIZADO_A_BAJARSE_PDF || 
				$evento["Codigo_Evento"]==EVENTO__A_PDF_DESCARGADO || 
				$evento["Codigo_Evento"]==EVENTO__A_INTERMEDIO_POR_NT || 
				$evento["Codigo_Evento"]==EVENTO__A_ESPERA_DE_CONF_OPERADOR || 
				$evento["Codigo_Evento"]==EVENTO__CONFIRMADO_POR_OPERADOR || 
				$evento["Codigo_Evento"]==EVENTO__A_RECLAMADO_POR_OPERADOR || 
				$evento["Codigo_Evento"]==EVENTO__A_RECLAMADO_POR_USUARIO))
				
				$clave="id_evento_origen";
			else
				$clave="Id";
			
			if (!array_key_exists($evento[$clave],$eventosSeparados)){
				$eventosSeparados[$evento[$clave]]=array();
			}
			array_push($eventosSeparados[$evento[$clave]], $evento);
		}
		
		$extraerfecha = create_function('$array', 'return $array["Fecha"];');
		$extraerprimero = create_function('$array', 'if(count($array)==0)return null; else return $array[0];');
 		$aplicadoShift=array_map($extraerprimero,$eventosSeparados);
		$fechas = array_map($extraerfecha,$aplicadoShift);
		array_multisort($fechas,$eventosSeparados);
		/*echo "<pre>";
		//var_dump($eventosSeparados);
		echo "</pre>";
		*/
		return $eventosSeparados;
	}
	
	
	function getEventos($conditions, $tablaEventos = "eventos"){
  		return $this->getAllObjects($tablaEventos, $conditions);	
	}

	function getEvento($id_evento, $tablaEventos = "eventos"){
		if (!is_array($id_evento))
			$id_evento = array("Id" => $id_evento);
		return $this->getObject($tablaEventos, $id_evento );
	}
	
	function getEventosDestinoRemoto($conditions){
		$client=$this->getCelsiusSOAPClient();
		$eventosDestinoRemoto=$client->getEventosDestinoRemoto($conditions['Id_Instancia_Celsius'],$conditions['Id_Pedido']);
        
        return $eventosDestinoRemoto;
	}
	function getEventosOrigenRemoto($id_pedido){

		return $this->getEventosCompletos(array('Id_Pedido'=>$id_pedido));

	}
	
	/**
	 * 
	 * Esto inserta los eventos historicos nuevamente en eventos, actualiza el estado del pedido y pasa lso eventos de entrega a vigente=0
	 */
	function cancelarEventoEntrega($id_Pedido,$motivo_anulacion, $operador_anulacion){
		$pedido=$this->getPedido($id_Pedido, "pedhist");
		if(empty($pedido))
			return new Application_Exception("El pedido $Id_Pedido no se encontro en la base de datos");
		
		
		if (($pedido["Estado"] != ESTADO__DESCAGADO_POR_EL_USUARIO) && ($pedido["Estado"] != ESTADO__ENTREGADO_IMPRESO)){
			return new Application_Exception("El pedido $id_Pedido nunca fue entregado. Esta en estado ".$pedido["Estado"]);
		}  	
		
		 //dejo los eventos de entrega en vigente=0
		 $result = $this->dao->updateAll("evhist", 
		 	array("vigente" => 0, "motivo_anulacion" => $motivo_anulacion, "fecha_anulacion" => date("Y-m-d H:i:s"), "operador_anulacion" => $operador_anulacion),
		 	"Id_Pedido ='".$id_Pedido."' AND (Codigo_Evento IN (7,14))"); 
		if (is_a($result, "Celsius_Exception"))
			return $result;
		
		//paso el pedido y sus eventos de historico a corriente
		//se hace asi de forma explicita para q no hayan conflictos de Id de evento
		$instruccion="INSERT INTO eventos SELECT * FROM evhist WHERE Id_Pedido='$id_Pedido'";
		 		
		$res=$this->dao->query($instruccion);
		 if (is_a($res, "Celsius_Exception"))
			return $res;  
		   
		$instruccion="INSERT INTO pedidos SELECT * FROM pedhist WHERE Id='".$id_Pedido."' LIMIT 1";
		 $res=$this->dao->query($instruccion);
		 if (is_a($res, "Celsius_Exception"))
			return $res;
		
		// actualizo archivos de  pedidos
		
		if ($pedido["Estado"] == ESTADO__DESCAGADO_POR_EL_USUARIO){
			$datos=array('Permitir_Download'=>'1');
			$actualizacionArchivosPedidos=$this->dao->update('archivos_pedidos',$datos,"codigo_pedido='".$id_Pedido."'");
		    if (is_a($actualizacionArchivosPedidos, "Celsius_Exception"))
			return $actualizacionArchivosPedidos;                  
		
		}
			
	  	// Por ultimo elimina la info de los pedidos y eventos
	  	$res=$this->dao->delete("pedhist","Id='".$id_Pedido."'");
		 if (is_a($res, "Celsius_Exception"))
			return $res;                  
			
	  	$res=$this->dao->deleteAll("evhist","Id_Pedido='".$id_Pedido."'");
		 if (is_a($res, "Celsius_Exception"))
			return $res; 
    	
    	
    	//actualiza el estado del pedido
    	if ($pedido['Estado'] == ESTADO__ENTREGADO_IMPRESO)
    		$estado=ESTADO__RECIBIDO;
    	else
    		$estado=ESTADO__LISTO_PARA_BAJARSE;
    	
    	$result = $this->dao->update("pedidos", array("Estado" => $estado), "Id ='".$id_Pedido."'"); 
		if (is_a($result, "Celsius_Exception"))
			return $result;
		
		return true;
    }
 	
 	
 
 	
 	/**
	 * 
	 * Esto inserta los eventos historicos nuevamente en eventos, actualiza el estado del pedido y pasa lso eventos de entrega a vigente=0
	 */
	function cancelarCancelacion($id_Pedido,$fecha_cancelacion,$motivo_anulacion, $operador_anulacion){
		$pedido=$this->getPedido($id_Pedido, "pedhist");
		if(empty($pedido))
			return new Application_Exception("El pedido $Id_Pedido no se encontro en la base de datos");
		
		
		if ($pedido["Estado"] != ESTADO__CANCELADO) {
			return new Application_Exception("El pedido $id_Pedido nunca fue cancelado. Esta en estado ".$pedido["Estado"]);
		}  	
		
		 //dejo los eventos de entrega en vigente=0
		/* $result = $this->dao->updateAll("evhist", 
		 	array("vigente" => 0, "motivo_anulacion" => $motivo_anulacion, "fecha_anulacion" => date("Y-m-d H:i:s"), "operador_anulacion" => $operador_anulacion),
		 	"Id_Pedido ='".$id_Pedido."' AND (Codigo_Evento IN (7,14))"); 
		if (is_a($result, "Celsius_Exception"))
			return $result;
		*/
		//paso el pedido y sus eventos de historico a corriente
		//se hace asi de forma explicita para q no hayan conflictos de Id de evento
		$instruccion="INSERT INTO eventos SELECT * FROM evhist WHERE Id_Pedido='$id_Pedido'";
		 		
		$res=$this->dao->query($instruccion);
		 if (is_a($res, "Celsius_Exception"))
			return $res;  
		   
		$instruccion="INSERT INTO pedidos SELECT * FROM pedhist WHERE Id='".$id_Pedido."' LIMIT 1";
		 $res=$this->dao->query($instruccion);
		 if (is_a($res, "Celsius_Exception"))
			return $res;
		
		// actualizo archivos de  pedidos
		
		
			
	  	// Por ultimo elimina la info de los pedidos y eventos
	  	$res=$this->dao->delete("pedhist","Id='".$id_Pedido."'");
		 if (is_a($res, "Celsius_Exception"))
			return $res;                  
			
	  	$res=$this->dao->deleteAll("evhist","Id_Pedido='".$id_Pedido."'");
		 if (is_a($res, "Celsius_Exception"))
			return $res; 
    	
    	
    	//actualiza el estado del pedido
    	$estado=ESTADO__BUSQUEDA;
    	
    	$result = $this->dao->update("pedidos", array("Estado" => $estado), "Id ='".$id_Pedido."'"); 
		if (is_a($result, "Celsius_Exception"))
			return $result;
		
		return true;
    }
 	
 	
 	
//	TODO revisar los cancelar remotos con paciencia
	function cancelarEvento_OrigenLocal($evento,$motivo_anulacion, $operador_anulacion){
		
		$pedido = $this->getPedido($evento["Id_Pedido"]);
		$estadoNuevo = 0;
		
		if ($evento["Codigo_Evento"] == EVENTO__A_SOLICITADO){
			
			if($evento["destino_remoto"]){//es un pedido NT, debo cancelarle el pedido al proveedor
				$result = $this->generarEvento_DestinoRemoto($evento["Id_Instancia_Celsius"],$evento["Id_Pedido_Remoto"],EVENTO__A_CANCELADO_POR_USUARIO,$motivo_anulacion,"creador");
			 	if (is_a($result, "WS_Exception")){
    		 		//no hago nada. Ya se hizo en generarEvento_DestinoRemoto
		 		}elseif (is_a($result, "Celsius_Exception")){
					return $result;
				}
			}
			
			//dejo en vigente=false los eventos reclamados asociados a esta solicitud
			$res = $this->dao->updateAll("eventos", array("vigente" => 0), array("id_evento_origen" => $evento["Id"], "Codigo_Evento"=>EVENTO__A_RECLAMADO_POR_OPERADOR));
			if (is_a($res, "Celsius_Exception")){
					return $result;		
			}
			//si no quedan mas solicitudes para este pedido lo paso a busqueda
			$cantSolicitudes = $this->getCount("eventos", array("vigente" => 1, "Codigo_Evento" => EVENTO__A_SOLICITADO, "Id_Pedido" => $evento["Id_Pedido"]));
			
			if ($cantSolicitudes == 1)
			  	$estadoNuevo = ESTADO__BUSQUEDA;
			
		}elseif (($evento["Codigo_Evento"] == EVENTO__A_AUTORIZADO_A_BAJARSE_PDF) || ($evento["Codigo_Evento"] == EVENTO__A_RECIBIDO)){
			
			//TODO: HACER UN MODIFICAR UPLOAD PDF PARA QUE SE PUEDA CAMBIAR EL PDF SUBIDO POR EQUIVOCACION???
			
			if ($evento["Codigo_Evento"] == EVENTO__A_AUTORIZADO_A_BAJARSE_PDF){
				$archivos_delete=$this->borrarArchivosPedidos($evento["Id_Pedido"]);
			}
			
			if ($pedido["origen_remoto"] == 1){
				//cancelo la solicitud			
				if (!empty($evento["id_evento_origen"])){
					$result = $this->dao->update("eventos", array("vigente" => 0), "Id = '".$evento["id_evento_origen"]."'");
					if (is_a($result, "Celsius_Exception"))
						return $result;
				}	
				
				$result = $this->cancelarEvento_DestinoRemoto($pedido["id_instancia_origen"],$evento["Id_Pedido"],EVENTO__A_INTERMEDIO_POR_NT);
				if (is_a($result, "Celsius_Exception")){
					//como hubo un error no se guarda el evento. que intente mas tarde
					return $result;
				}
				$estadoNuevo = ESTADO__BUSQUEDA;
			}
			else
				$estadoNuevo = ESTADO__SOLICITADO;
			
			
		}elseif ($evento["Codigo_Evento"] == EVENTO__A_ESPERA_DE_CONF_USUARIO){
			if ($pedido["origen_remoto"] == 1){
				$result = $this->cancelarEvento_DestinoRemoto($pedido["id_instancia_origen"],$evento["Id_Pedido"],EVENTO__A_ESPERA_DE_CONF_USUARIO);
				if (is_a($result, "Celsius_Exception")){
					//como hubo un error no se guarda el evento. que intente mas tarde
					return $result;
				}
			}
		}elseif ($evento["Codigo_Evento"] == EVENTO__A_RECLAMADO_POR_USUARIO){
			//no hago nada. No se debe comunicar nada a nadie
		}elseif ($evento["Codigo_Evento"] == EVENTO__A_INTERMEDIO_POR_NT){
			//no cancelo la solicitud correspondiente al evento de intermedio por nt
			
			//cancela el evento de recepcion remoto 
			$eventoOrigen = $this->getEvento($evento["id_evento_origen"]);
			$result = $this->cancelarEvento_DestinoRemoto($eventoOrigen["Id_Instancia_Celsius"],$eventoOrigen["Id_Pedido_Remoto"],EVENTO__A_RECIBIDO);
			if (is_a($result, "WS_Exception")){
    			//no hago nada. Ya se hizo en generarEvento_DestinoRemoto
		 	}elseif (is_a($result, "Celsius_Exception")){
				return $result;
			}
			
			$estadoNuevo = ESTADO__SOLICITADO;
		}else
			return new Application_Exception("Los eventos ".$evento["Codigo_Evento"]."no se pueden cancelar");
		
		
		
		$result = $this->dao->update("eventos",
			array("vigente" => 0, "motivo_anulacion" => $motivo_anulacion, "fecha_anulacion" => date("Y-m-d H:i:s"), "operador_anulacion" => $operador_anulacion) 
			, "Id = '".$evento["Id"]."'");
		if (is_a($result, "Celsius_Exception")){
			//como hubo un error no se guarda el evento. que intente mas tarde
			return $result;
		}
		
		if ($estadoNuevo !== 0){
			$fields = array("Estado" => $estadoNuevo);
			if ($estadoNuevo==ESTADO__BUSQUEDA)
				$fields["En_Busqueda"]=1;
			
			$result = $this->dao->update("pedidos",$fields, "Id = '".$evento["Id_Pedido"]."'");
			if (is_a($result, "Celsius_Exception")){
				//como hubo un error no se guarda el evento. que intente mas tarde
				return $result;
			}
		}

		return true;

	}
	
	/**
	 * @param string $idInstanciaRemota
	 * @param string $id_pedido
	 * @param int $codigo_evento
	 */
 	function cancelarEvento_DestinoRemoto($idInstanciaRemota, $id_pedido, $codigo_evento){
 		
 		$clienteSOAP = $this->getCelsiusSOAPClient(); 
 		return $clienteSOAP->cancelarEvento_DestinoRemoto($idInstanciaRemota,$id_pedido,PedidosUtils::getEventoNT($codigo_evento));
 	}
 	
 	function cancelarEvento_OrigenRemoto($idInstanciaRemota, $id_pedido_remoto, $codigo_evento_nt){
 		
 		switch ($codigo_evento_nt){
			case EVENTO_NT__ESPERAR_CONFIRMACION:
				//el celsius remoto solicita la confirmacion de datos por parte  del operador local 
				$codEventoACancelar = EVENTO__A_ESPERA_DE_CONF_OPERADOR;
				break;
			case EVENTO_NT__ENVIADO:
				//el celsius remoto ya consiguio el pedido, y me lo manda de alguna manera 
				$codEventoACancelar = EVENTO__A_INTERMEDIO_POR_NT;
				break;
			default:
				break;
		}
		$conditions = array("Id_Pedido_Remoto" => $id_pedido_remoto,"Id_Instancia_Celsius" => $idInstanciaRemota, 
							"Codigo_Evento" => $codEventoACancelar, "vigente" => 1, "destino_remoto" => 1);
		$eventoACancelar = $this->getObject("eventos", $conditions);
		$result = $this->dao->update("eventos", array("vigente" => 0,"fecha_anulacion" => date("Y-m-d H:i:s")), "Id ='".$eventoACancelar["Id"]."'"); 
		if (is_a($result, "Celsius_Exception")){
			//como hubo un error no se guarda el evento. que intente mas tarde
			return $result;
		}
		
		if ($codEventoACancelar == EVENTO__A_INTERMEDIO_POR_NT){
			$conditions = array("Id_Pedido_Remoto" => $id_pedido_remoto, "Codigo_Evento" => EVENTO__A_SOLICITADO, 
							"Id_Instancia_Celsius" => $idInstanciaRemota, "destino_remoto" => 1);
			$solicitud = $this->getObject("eventos", $conditions);
			$result = $this->dao->update("eventos", array("vigente" => 1), "Id ='".$solicitud["Id"]."'"); 
			if (is_a($result, "Celsius_Exception")){
				//como hubo un error no se guarda el evento. que intente mas tarde
				return $result;
			}
		}
		return true;
 	}
 	
	function getPedido($IdPedido,$tablaPedidos = "pedidos", $cols="*"){
		return $this->getObject($tablaPedidos, array("Id"=>$IdPedido), $cols);	
	}
	
	function getUsuario($IdUsuario,$cols = "*"){
		$conditions=array("Id"=>$IdUsuario);
		return $this->getObject("usuarios", $conditions,$cols);	
	}
	
	function agregarUsuario($usuario){
		return $this->dao->insert("usuarios", $usuario);
	}
	
	function modificarUsuario($usuario){
		$id_usuario = $usuario["Id"];
		unset($usuario["Id"]);
		return $this->dao->update("usuarios", $usuario, "Id = $id_usuario");
	}
	
	function getUsuariosBibliotecarios($conditions = array()){
		$select = $this->armarSelectUsuariosCompletos($conditions);
		$select->where("tUsuarios.Bibliotecario > ?", "0");
		return $this->dao->fetchAll($select);
	}
	
	function getUsuariosCompletos($conditions) {
		$select = $this->armarSelectUsuariosCompletos($conditions);
		return $this->dao->fetchAll($select);
	}
	
	function existeLoginUsuario($loginUsuario){
		$usuario = $this->getObject("usuarios", array("Login"=>$loginUsuario));
		return (!empty($usuario));
		
	}
	
	function getUsuarioCompleto($id_usuario){
		$select = $this->armarSelectUsuariosCompletos(array("Id" => $id_usuario));
		return $this->dao->fetchRow($select);
	}

	function armarSelectUsuariosCompletos ($conditions){
		$select = $this->dao->select();
		$select->from("usuarios as tUsuarios", "tUsuarios.*");
		$select->joinLeft("paises as tPaises","tUsuarios.Codigo_Pais = tPaises.Id","tPaises.Nombre as Nombre_Pais");
		$select->joinLeft("instituciones as tInstituciones","tUsuarios.Codigo_Institucion = tInstituciones.Codigo","tInstituciones.Nombre as Nombre_Institucion");
		$select->joinLeft("dependencias as tdependencias","tUsuarios.Codigo_Dependencia = tdependencias.Id","tdependencias.Nombre as Nombre_Dependencia");
		$select->joinLeft("unidades as tUnidades","tUsuarios.Codigo_Unidad = tUnidades.Id","tUnidades.Nombre as Nombre_Unidad");
		$select->joinLeft("localidades as tlocalidades","tUsuarios.Codigo_Localidad = tlocalidades.Id","tlocalidades.Nombre as Nombre_Localidad");
		$select->joinLeft("tab_categ_usuarios as tCategorias","tUsuarios.Codigo_Categoria = tCategorias.Id","tCategorias.Nombre as Nombre_Categoria");
		$select->joinLeft("forma_entrega as tforma_entrega","tUsuarios.Codigo_FormaEntrega  = tforma_entrega.Id","tforma_entrega.Nombre as Nombre_FormaEntrega");

		foreach($conditions as $fieldName => $fieldValue){
 			$select->where("tUsuarios.$fieldName = ?", $fieldValue);
 		}
 		$select->order("tUsuarios.Apellido");

		return $select;
	}
	
	function borrarArchivosPedidos($Id_Pedido){
		if(empty($Id_Pedido))
			return new Application_Exception("El campo $Id_Pedido no puede ser vacio");
		$archivos_pedidos=$this->getAllObjects('archivos_pedidos',array('codigo_pedido'=>$Id_Pedido));
		$directorio = Configuracion::getDirectorioUploads();
		foreach ($archivos_pedidos as $archivos){
			$filename = $archivos["nombre_archivo"];
			$pathCompleto = $directorio . "/" . $filename;
			if(file_exists($pathCompleto))
				unlink($pathCompleto);
		}
		$res=$this->dao->deleteAll("archivos_pedidos"," codigo_pedido='".$Id_Pedido."'");
		if (is_a($res, "Celsius_Exception"))
			return $res;
		
	}
	function getAllUsuarios($conditions){
		$select = $this->dao->select();
		$select->from("usuarios","usuarios.*");
		$select->joinLeft("instituciones", "usuarios.Codigo_Institucion=instituciones.Codigo","instituciones.Nombre as Nombre_Institucion,instituciones.habilitado_crear_pedidos as habilitado_crear_pedidos");
		$select->joinLeft("dependencias", "usuarios.Codigo_Dependencia=dependencias.Id","dependencias.Nombre as Nombre_Dependencia");
		$select->joinLeft("unidades", "usuarios.Codigo_Unidad=unidades.Id","unidades.Nombre as Nombre_Unidad");

		$select->order("usuarios.Apellido,usuarios.Nombres");
		$conditions2 = array();
		foreach($conditions as $key => $value) {
			if (is_string($value))
				$conditions2["usuarios.".$key] = $value.='%';
		}
		
		return $this->findAllObjects($select, $conditions2);
	}
	
	function agregarCandidato($candidato){
		return $this->dao->insert("candidatos", $candidato);
	}
	
	function modificarCandidato($candidato){
		$id_candidato = $candidato["Id"];
		unset($candidato["Id"]);
		return $this->dao->update("candidatos", $candidato, "Id = $id_candidato");
	}
	
	function getCandidato($id_candidato){
		$conditions=array("Id"=>$id_candidato);
		return $this->getObject("candidatos", $conditions);	
	}
	
	function getCandidatoCompleto($id_candidato){
		$select = $this->dao->select();
		$select->from("candidatos as tcandidatos", "tcandidatos.*");
		$select->joinLeft("paises as tPaises","tcandidatos.Codigo_Pais = tPaises.Id","tPaises.Nombre as Nombre_Pais,tPaises.Abreviatura as Abreviatura_Pais");
		$select->joinLeft("instituciones as tInstituciones","tcandidatos.Codigo_Institucion = tInstituciones.Codigo","tInstituciones.Nombre as Nombre_Institucion,tInstituciones.Abreviatura as Abreviatura_Institucion");
		$select->joinLeft("dependencias as tdependencias","tcandidatos.Codigo_Dependencia = tdependencias.Id","tdependencias.Nombre as Nombre_Dependencia");
		$select->joinLeft("unidades as tUnidades","tcandidatos.Codigo_Unidad = tUnidades.Id","tUnidades.Nombre as Nombre_Unidad");
		$select->joinLeft("localidades as tlocalidades","tcandidatos.Codigo_Localidad = tlocalidades.Id","tlocalidades.Nombre as Nombre_Localidad");
		$select->joinLeft("tab_categ_usuarios as tCategorias","tcandidatos.Codigo_Categoria = tCategorias.Id","tCategorias.Nombre as Nombre_Categoria");
		$select->where("tcandidatos.Id = ?", $id_candidato);
		return $this->dao->fetchRow($select);
	}
	
	function getCandidatos($conditions = array()){
		return $this->getAllObjects("candidatos", $conditions,"*","Fecha_Registro");
	}

	function validarUsuario($loginName){
		return $this->getObject("usuarios",array("Login" =>$loginName));
	}
	
	function agregarTituloColeccion($colNueva){
		return $this->dao->insert("titulos_colecciones", $colNueva);
 		
	}
	

//	function getTituloColeccion($idTituloColeccion) {
//		$conditions= array("Id" => $idTituloColeccion);
//		return $this->getObject("titulos_colecciones", $conditions);
//	}

	
	
 
	function modificarTituloColeccion($coleccion){
 		
 		$Id = $coleccion["Id"];
 		unset($coleccion["Id"]); 
 		return $this->dao->update("titulos_colecciones", $coleccion, "Id=".$Id);
 		
 	}
	function getAllTitulosColecciones($conditions = array()){
		$select = $this->dao->select();
		$select->from("titulos_colecciones");
		$select->order("Nombre");
		foreach($conditions as $key => $value) {
			if (is_string($value))
				$conditions[$key] = $value.='%';
		}
		
		return $this->findAllObjects($select, $conditions);
	}
	
	function getPIDUfromPedidoConEstado($idPedido, $pedidoEstado){
		$select =$this->dao->select();
		$select->from("evhist as tEventosHistoricos", "tEventosHistoricos.*" );
		$select->joinLeft("instituciones as tInstituciones","tEventosHistoricos.Codigo_Institucion = tInstituciones.Codigo","tInstituciones.Nombre as Nombre_Institucion, tInstituciones.Abreviatura as Abreviatura_Institucion");
		$select->joinLeft("dependencias as tdependencias","tEventosHistoricos.Codigo_Dependencia = tdependencias.Id","tdependencias.Nombre as Nombre_Dependencia");
		$select->where("tEventosHistoricos.Codigo_Evento = ?", $pedidoEstado);
		$select->where("tEventosHistoricos.Id_Pedido = ?",$idPedido);
		$select->order("Fecha");
		return $this->dao->fetchRow($select);
	}



 	//////////////////////////////////////////////////////////////////
	////////////////// administracion de pedidos /////////////////////
	//////////////////////////////////////////////////////////////////
 	
 	function crearPedido_OrigenLocal($datosPedidoLocal){
 		$usuarioLocal = $this->getUsuario($datosPedidoLocal["Codigo_Usuario"]);
 		if (empty($usuarioLocal))
 			return new Application_Exception("El usuario con id '" . $datosPedidoLocal["Codigo_Usuario"]  . "' no existe en la base de datos");
 		$idInstitucion = $usuarioLocal["Codigo_Institucion"];
 		if (empty($idInstitucion))
 			return new Application_Exception("El usuario ".$datosPedidoLocal["Codigo_Usuario"]." no tiene una institucion seteada. No puede crear pedidos");
 		$idPedidoLocal = $this->getIdPedidoNuevo($idInstitucion);
 		if (is_a($idPedidoLocal, "Celsius_Exception"))
			return $idPedidoLocal;
			
 		$datosPedidoLocal["Id"]= $idPedidoLocal;
 		$datosPedidoLocal["Tipo_Pedido"]= $datosPedidoLocal["Tipo_Pedido"];
 		$datosPedidoLocal["Estado"]=ESTADO__PENDIENTE;
 		$datosPedidoLocal["Fecha_Alta_Pedido"]= date("Y-m-d H:i:s");
 		
 		$res = $this->dao->insert("pedidos", $datosPedidoLocal);
		if (is_a($res, "Celsius_Exception"))
			return $res;
		
		return $idPedidoLocal;
 	}
 	

 	
 	/**
 	 * Crea un pedido nuevo en base a una solicitud de un celsius remoto por medio de SOAP.
 	 * Y devuelve el id del pedido creado junto con el error si es que se genero alguno. 
 	 */
	function crearPedido_OrigenRemoto($idInstanciaRemota, $datosPedidoRemoto){
		$instancia_celsius = $this->getInstancia_Celsius($idInstanciaRemota);
 		$idInstitucion = $instancia_celsius["id_institucion"];
 		$idPedidoLocal = $this->getIdPedidoNuevo($idInstitucion);
 		if (is_a($idPedidoLocal, "Celsius_Exception")){
			return $idPedidoLocal;
		}
 		
 		$pedido = array();
 		$pedido["Id"]=$idPedidoLocal;
 		$pedido["origen_remoto"]=1;
 		$pedido["id_instancia_origen"]=$idInstanciaRemota;
 		$pedido["Codigo_Usuario"]=0;//????
 		$pedido["Usuario_Creador"]=0;//????
 		$pedido["Tipo_Usuario_Crea"]=0;//????
 		$pedido["Estado"]=ESTADO__PENDIENTE;//estado pendiente
 		$pedido["Fecha_Alta_Pedido"]=date("Y-m-d");
 		
 		if (isset($datosPedidoRemoto["Biblioteca_Sugerida"]))
 			$pedido["Biblioteca_Sugerida"]=$datosPedidoRemoto["Biblioteca_Sugerida"];
 		$pedido["Observaciones"]="";
 		$pedido["Ultimo_Pais_Solicitado"]=0;
 		$pedido["Ultima_Institucion_Solicitado"]=0;
 		$pedido["Ultima_Dependencia_Solicitado"]=0;
 		$pedido["Operador_Corriente"]=0;
 		$pedido["Observado"]=0;
 		
 		$pedido["Tipo_Pedido"]=TIPO_PEDIDO__PROVISION;
 		$pedido["Tipo_Material"]=$datosPedidoRemoto["Tipo_Material"];
 		if (isset($datosPedidoRemoto["Titulo_Libro"]))
 			$pedido["Titulo_Libro"]=$datosPedidoRemoto["Titulo_Libro"];
 		if (isset($datosPedidoRemoto["Autor_Libro"]))
 			$pedido["Autor_Libro"]=$datosPedidoRemoto["Autor_Libro"];
 		if (isset($datosPedidoRemoto["Editor_Libro"]))
 			$pedido["Editor_Libro"]=$datosPedidoRemoto["Editor_Libro"];
 		if (isset($datosPedidoRemoto["Anio_Libro"]))
 			$pedido["Anio_Libro"]=$datosPedidoRemoto["Anio_Libro"];
 		if (isset($datosPedidoRemoto["Desea_Indice"]))
 			$pedido["Desea_Indice"]=$datosPedidoRemoto["Desea_Indice"];
 		if (isset($datosPedidoRemoto["Capitulo_Libro"]))
 			$pedido["Capitulo_Libro"]=$datosPedidoRemoto["Capitulo_Libro"];
 		if (isset($datosPedidoRemoto["Numero_Patente"]))
 			$pedido["Numero_Patente"]=$datosPedidoRemoto["Numero_Patente"];
 		$pedido["Codigo_Pais_Patente"]=0;
 		if (isset($datosPedidoRemoto["Pais_Patente"]))
 			$pedido["Pais_Patente"]=$datosPedidoRemoto["Pais_Patente"];
 		if (isset($datosPedidoRemoto["Anio_Patente"]))
 			$pedido["Anio_Patente"]=$datosPedidoRemoto["Anio_Patente"];
 		
 		if (isset($datosPedidoRemoto["Autor_Detalle1"]))
 			$pedido["Autor_Detalle1"]=$datosPedidoRemoto["Autor_Detalle1"];
 		if (isset($datosPedidoRemoto["Autor_Detalle2"]))
 			$pedido["Autor_Detalle2"]=$datosPedidoRemoto["Autor_Detalle2"];
 		if (isset($datosPedidoRemoto["Autor_Detalle3"]))
 			$pedido["Autor_Detalle3"]=$datosPedidoRemoto["Autor_Detalle3"];
 		
 		$pedido["Codigo_Titulo_Revista"]=0;
 		
 		if (isset($datosPedidoRemoto["Titulo_Revista"]))
 			$pedido["Titulo_Revista"]=$datosPedidoRemoto["Titulo_Revista"];
 		if (isset($datosPedidoRemoto["Titulo_Articulo"]))
 			$pedido["Titulo_Articulo"]=$datosPedidoRemoto["Titulo_Articulo"];
 		if (isset($datosPedidoRemoto["Volumen_Revista"]))
 			$pedido["Volumen_Revista"]=$datosPedidoRemoto["Volumen_Revista"];
 		if (isset($datosPedidoRemoto["Numero_Revista"]))
 			$pedido["Numero_Revista"]=$datosPedidoRemoto["Numero_Revista"];
 		if (isset($datosPedidoRemoto["Anio_Revista"]))
 			$pedido["Anio_Revista"]=$datosPedidoRemoto["Anio_Revista"];
 		if (isset($datosPedidoRemoto["Pagina_Hasta"]))
 			$pedido["Pagina_Hasta"]=$datosPedidoRemoto["Pagina_Hasta"];
 		if (isset($datosPedidoRemoto["Pagina_Desde"]))
 			$pedido["Pagina_Desde"]=$datosPedidoRemoto["Pagina_Desde"];
 		if (isset($datosPedidoRemoto["TituloCongreso"]))
 			$pedido["TituloCongreso"]=$datosPedidoRemoto["TituloCongreso"];
 		
 		if (isset($datosPedidoRemoto["Organizador"]))
 			$pedido["Organizador"]=$datosPedidoRemoto["Organizador"];
 		if (isset($datosPedidoRemoto["NumeroLugar"]))
 			$pedido["NumeroLugar"]=$datosPedidoRemoto["NumeroLugar"];
 		if (isset($datosPedidoRemoto["Anio_Congreso"]))
 			$pedido["Anio_Congreso"]=$datosPedidoRemoto["Anio_Congreso"];
 		if (isset($datosPedidoRemoto["PaginaCapitulo"]))
 			$pedido["PaginaCapitulo"]=$datosPedidoRemoto["PaginaCapitulo"];
 		if (isset($datosPedidoRemoto["PonenciaActa"]))
 			$pedido["PonenciaActa"]=$datosPedidoRemoto["PonenciaActa"];
 		$pedido["Codigo_Pais_Congreso"]=0;
 		if (isset($datosPedidoRemoto["Otro_Pais_Congreso"]))
 			$pedido["Otro_Pais_Congreso"]=$datosPedidoRemoto["Otro_Pais_Congreso"];
 		
 		if (isset($datosPedidoRemoto["TituloTesis"]))
 			$pedido["TituloTesis"]=$datosPedidoRemoto["TituloTesis"];
 		if (isset($datosPedidoRemoto["AutorTesis"]))
 			$pedido["AutorTesis"]=$datosPedidoRemoto["AutorTesis"];
 		if (isset($datosPedidoRemoto["DirectorTesis"]))
 			$pedido["DirectorTesis"]=$datosPedidoRemoto["DirectorTesis"];
 		if (isset($datosPedidoRemoto["GradoAccede"]))
 			$pedido["GradoAccede"]=$datosPedidoRemoto["GradoAccede"];
 		$pedido["Codigo_Pais_Tesis"]=0;
 		if (isset($datosPedidoRemoto["Otro_Pais_Tesis"]))
 			$pedido["Otro_Pais_Tesis"]=$datosPedidoRemoto["Otro_Pais_Tesis"];
 		$pedido["Codigo_Institucion_Tesis"]=0;
 		if (isset($datosPedidoRemoto["Otra_Institucion_Tesis"]))
 			$pedido["Otra_Institucion_Tesis"]=$datosPedidoRemoto["Otra_Institucion_Tesis"];
 		$pedido["Codigo_Dependencia_Tesis"]=0;
 		if (isset($datosPedidoRemoto["Otra_Dependencia_Tesis"]))
 			$pedido["Otra_Dependencia_Tesis"]=$datosPedidoRemoto["Otra_Dependencia_Tesis"];
 		if (isset($datosPedidoRemoto["Anio_Tesis"]))
 			$pedido["Anio_Tesis"]=$datosPedidoRemoto["Anio_Tesis"];
 		if (isset($datosPedidoRemoto["PagCapitulo"]))
 			$pedido["PagCapitulo"]=$datosPedidoRemoto["PagCapitulo"];
 		
 		$pedido["Tardanza_Atencion"]=0;
 		$pedido["Tardanza_Busqueda"]=0;
 		$pedido["Tardanza_Recepcion"]=0;
		
		$res = $this->dao->insert("pedidos", $pedido);
		if (is_a($res, "Celsius_Exception")){
			return $res;
		}
		
		return $idPedidoLocal;
 	}
 	
 	function crearPedido_DestinoRemoto($idInstanciaRemota, $datosPedidoLocal){
 		
 		
 		$pedido = array();
 		$pedido["Biblioteca_Sugerida"]=$datosPedidoLocal["Biblioteca_Sugerida"];
 		$pedido["Tipo_Material"]=$datosPedidoLocal["Tipo_Material"];
 		$pedido["Titulo_Libro"]=$datosPedidoLocal["Titulo_Libro"];
 		$pedido["Autor_Libro"]=$datosPedidoLocal["Autor_Libro"];
 		$pedido["Editor_Libro"]=$datosPedidoLocal["Editor_Libro"];
 		$pedido["Anio_Libro"]=$datosPedidoLocal["Anio_Libro"];
 		$pedido["Desea_Indice"]=$datosPedidoLocal["Desea_Indice"];
 		$pedido["Capitulo_Libro"]=$datosPedidoLocal["Capitulo_Libro"];
 		$pedido["Numero_Patente"]=$datosPedidoLocal["Numero_Patente"];
 		$pedido["Pais_Patente"]=$datosPedidoLocal["Pais_Patente"];
 		$pedido["Anio_Patente"]=$datosPedidoLocal["Anio_Patente"];
 		$pedido["Autor_Detalle1"]=$datosPedidoLocal["Autor_Detalle1"];
 		$pedido["Autor_Detalle2"]=$datosPedidoLocal["Autor_Detalle2"];
 		$pedido["Autor_Detalle3"]=$datosPedidoLocal["Autor_Detalle3"];
 		$pedido["Titulo_Revista"]=$datosPedidoLocal["Titulo_Revista"];
 		$pedido["Titulo_Articulo"]=$datosPedidoLocal["Titulo_Articulo"];
 		$pedido["Volumen_Revista"]=$datosPedidoLocal["Volumen_Revista"];
 		$pedido["Numero_Revista"]=$datosPedidoLocal["Numero_Revista"];
 		$pedido["Anio_Revista"]=$datosPedidoLocal["Anio_Revista"];
 		$pedido["Pagina_Desde"]=$datosPedidoLocal["Pagina_Desde"];
 		$pedido["Pagina_Hasta"]=$datosPedidoLocal["Pagina_Hasta"];
 		$pedido["TituloCongreso"]=$datosPedidoLocal["TituloCongreso"];
 		$pedido["Organizador"]=$datosPedidoLocal["Organizador"];
 		$pedido["NumeroLugar"]=$datosPedidoLocal["NumeroLugar"];
 		$pedido["Anio_Congreso"]=$datosPedidoLocal["Anio_Congreso"];
 		$pedido["PaginaCapitulo"]=$datosPedidoLocal["PaginaCapitulo"];
 		$pedido["PonenciaActa"]=$datosPedidoLocal["PonenciaActa"];
 		$pedido["Otro_Pais_Congreso"]=$datosPedidoLocal["Otro_Pais_Congreso"];
 		$pedido["TituloTesis"]=$datosPedidoLocal["TituloTesis"];
 		$pedido["AutorTesis"]=$datosPedidoLocal["AutorTesis"];
 		$pedido["DirectorTesis"]=$datosPedidoLocal["DirectorTesis"];
 		$pedido["GradoAccede"]=$datosPedidoLocal["GradoAccede"];
 		$pedido["Otro_Pais_Tesis"]=$datosPedidoLocal["Otro_Pais_Tesis"];
 		$pedido["Otra_Institucion_Tesis"]=$datosPedidoLocal["Otra_Institucion_Tesis"];
 		$pedido["Otra_Dependencia_Tesis"]=$datosPedidoLocal["Otra_Dependencia_Tesis"];
 		$pedido["Anio_Tesis"]=$datosPedidoLocal["Anio_Tesis"];
 		$pedido["PagCapitulo"]=$datosPedidoLocal["PagCapitulo"];
 			
 		$client=$this->getCelsiusSOAPClient();
 		
 		$idPedido=$client->crearPedido_DestinoRemoto($idInstanciaRemota,$pedido);
 		return $idPedido; 
		
 	}
 	
 	function getIdPedidoNuevo($idInstitucion){
		if (empty($idInstitucion))
			return new Application_Exception("Es imprescindible que indique cual es la instituicion para poder crear un nuevo pedido.");
 		//bloquea la tabla de INSTITUCIONES,asi no se usa el mismo idPedido en dos pedidos  
 		//$res = $this->dao->query("LOCK TABLES instituciones WRITE");
		//if (is_a($res, "Celsius_Exception"))
			//return $res;
			
		$instruccion = "SELECT instituciones.Abreviatura as inst,paises.Abreviatura as pais,instituciones.Codigo_Pedidos as codigo_pedido 
						FROM instituciones INNER JOIN paises ON paises.Id=instituciones.Codigo_Pais
						WHERE Codigo='$idInstitucion'";
		
		$row = $this->dao->fetchRow($instruccion);
		if (is_a($row, "Celsius_Exception"))
			return $row;
		
		if (empty($row))
			return new Application_Exception("La institucion con codigo == $idInstitucion no existe en la base de datos. No podra crear un nuevo pedido.");
			
		$numero_sig = $row["codigo_pedido"] + 1;
		$Codigo_Pedido = $row["pais"]."-".$row["inst"]."-".sprintf("%07d",$numero_sig);

		$res = $this->dao->update("instituciones",array("Codigo_Pedidos" => $numero_sig),"Codigo=$idInstitucion");
		if (is_a($res, "Celsius_Exception"))
			return $res;
			
		//$res = $this->dao->query("UNLOCK TABLES");
		if (is_a($res, "Celsius_Exception"))
			return $res;
			
		return $Codigo_Pedido;
 	}
 	
 		
 	function anularPedido($id_Pedido,$Fecha_Anulacion,$Causa_Anulacion,$Operador_Anulacion){  	
		if(empty($id_Pedido))
			return new Application_Exception("El campo $id_Pedido no puede ser vacio");
			
		$pedido= $this->getPedido($id_Pedido);

		$instruccion="INSERT INTO pedanula SELECT *,'".$Fecha_Anulacion."','".$Causa_Anulacion."',".$Operador_Anulacion." FROM pedidos where Id='".$id_Pedido."' LIMIT 1";
		 $res=$this->dao->query($instruccion);
		 if (is_a($res, "Celsius_Exception"))
			return $res;
		 
		 $instruccion="INSERT INTO evanula SELECT Id, Id_Pedido, Codigo_Evento, Operador, vigente, Es_Privado, Fecha, id_evento_origen, Id_Correo, Codigo_Pais, Codigo_Institucion, Codigo_Dependencia, Codigo_Unidad, Id_Instancia_Celsius, destino_remoto, Id_Pedido_Remoto, Numero_Paginas, Observaciones, '".$Causa_Anulacion."' as motivo_anulacion ,'".$Fecha_Anulacion."' as fecha_anulacion ,".$Operador_Anulacion." as operador_anulacion FROM eventos where Id_Pedido='".$id_Pedido."'";
		 $res=$this->dao->query($instruccion);
		 if (is_a($res, "Celsius_Exception"))
				return $res;
			   
		 $res=$this->dao->delete("pedidos","Id='".$id_Pedido."'");
		if (is_a($res, "Celsius_Exception"))
			return $res;
				
		$res=$this->dao->deleteAll("eventos","Id_Pedido='".$id_Pedido."'");
		if (is_a($res, "Celsius_Exception"))
			return $res;
		
		$eventoRemoto=array();
		$eventoRemoto["Codigo_Evento"]=EVENTO__A_CANCELADO_POR_OPERADOR;
		$eventoRemoto["Observaciones"] = $Causa_Anulacion;
		
		if ($pedido["origen_remoto"]){
				//es un pedido NT, debo cancelarle el pedido al creador	
			 	//busco el evento en la instancia remota por id_instancia, id_pedido y que este vigente --> lo pongo no vigente y le agrego los motivos de anulacion, etc
  			 	$result = $this->generarEvento_DestinoRemoto($pedido["id_instancia_origen"], $id_Pedido, $eventoRemoto["Codigo_Evento"],$eventoRemoto["Observaciones"],"proveedor");
    		 	
    		 	if (is_a($result, "WS_Exception")){
		 			//como hubo un error se permite la creacion del evento, pero se guarda en la cola de envios y en la cola de eventos.
		 			//agrego el evento a la cola de envios
    		 		//no hago nada. Ya se hizo en generarEvento_DestinoRemoto
		 		}
		 		elseif (is_a($result, "Celsius_Exception")){
					return $result;
				}
		}
		
		$conditions = array("Id_Pedido" => $id_Pedido,"Codigo_Evento" => EVENTO__A_SOLICITADO, "destino_remoto" => 1,"vigente" => 1);
		$eventosSolicitud = $this->getEventos($conditions);
    	foreach ($eventosSolicitud as $solicitud){
    		if ($solicitud["destino_remoto"]){
				$result = $this->generarEvento_DestinoRemoto($solicitud["Id_Instancia_Celsius"],$solicitud["Id_Pedido_Remoto"],$eventoRemoto["Codigo_Evento"],$eventoRemoto["Observaciones"],"creador");
			 	if (is_a($result, "WS_Exception")){
					//como hubo un error se permite la creacion del evento, pero se guarda en la cola de pendientes.
					//agrego el evento a la cola de envios
		    	}elseif (is_a($result, "Celsius_Exception")){
					return $result;
				}
    		}
    	}
    		
		
		return true;
		 
    }	
    
	
 	 	
	function Es_InstanciaNT($Id_Instancia_Celsius){
	  	$instancia = $this->getObject("instancias_celsius", array("id"=>$Id_Instancia_Celsius));
		return $instancia["nt_habilitado"];
	}
	 
	function getConfiguracion($campo = ""){
 		if (empty($campo))
 			$res = $this->getObject("parametros");
 		else{
 			$res = $this->getObject("parametros",array(),$campo);
 			if (is_a($res, "Celsius_Exception")){
 				//throw new Exception(var_export($res,true));
 				return $res;
 			}
 			$res = $res[$campo];
 		}
 		return $res;
 		
	}
	

/**
 * 
 * 
 * @param array datosPedido 
 * @throws Celsius_Exception si no se pudo realizar el pedido por algun otro motivo
 */
function generarEvento_OrigenLocal($evento,$archivos = array(), $manual = false){
    $idPedido = $evento["Id_Pedido"];
    $evento["vigente"] = 1;
    $evento["Fecha"] = date("Y-m-d H:i:s");
    $datosPedido = $this->getPedido($idPedido);
    
    $conditionsPedidos = array();
    $nuevoEstado = PedidosUtils::Determinar_Estado($evento["Codigo_Evento"]);
    
    //el evento produce un cambio de estado en el pedido
    if (!empty($nuevoEstado)){
    	$conditionsPedidos["Estado"] = $nuevoEstado;
    	
    	
    }
    
    //si hay un evento de confirmacion con vigente=1 hay que ponerle vigente=0
    $conditions = "Id_Pedido ='".$idPedido."' AND Codigo_Evento=".EVENTO__CONFIRMADO_POR_USUARIO." AND vigente = 1";
  	$result = $this->modificarEventos(array("vigente" => 0),$conditions);
	if (is_a($result, "Celsius_Exception")){
		return $result;
	}
	
	$conditions = "Id_Pedido ='".$idPedido."' AND Codigo_Evento=".EVENTO__CONFIRMADO_POR_OPERADOR." AND vigente = 1";
  	$result = $this->modificarEventos(array("vigente" => 0),$conditions);
	if (is_a($result, "Celsius_Exception")){
		return $result;
	}
        
    if  (!($evento["Codigo_Evento"]==EVENTO__CONFIRMADO_POR_USUARIO))
			$conditionsPedidos["Operador_Corriente"] = $evento["Operador"];
	
	switch ($evento["Codigo_Evento"]){
		case EVENTO__A_BUSQUEDA:{    
			$conditionsPedidos["Fecha_Inicio_Busqueda"]=$evento["Fecha"];
			$conditionsPedidos["En_Busqueda"] = 1;
			if ($datosPedido["Estado"] == ESTADO__PENDIENTE)
				$conditionsPedidos["Estado"] = ESTADO__BUSQUEDA;
    		break;
    	}
    	case EVENTO__A_SOLICITADO:{
			//Se guarda la fecha de la primer solicitud. Esto se hace por ya estaba, pero no es util,
			//ya que un pedido puede tener mas de una solicitud 
			$conditionsPedidos["Ultimo_Pais_Solicitado"]= $evento["Codigo_Pais"];
			$conditionsPedidos["Ultima_Institucion_Solicitado"]=$evento["Codigo_Institucion"];
			$conditionsPedidos["Ultima_Dependencia_Solicitado"]=$evento["Codigo_Dependencia"];
			$conditionsPedidos["Ultima_Unidad_Solicitado"]=$evento["Codigo_Unidad"];
			
			if(empty($datosPedido["Fecha_Solicitado"]))
				$conditionsPedidos["Fecha_Solicitado"]=$evento["Fecha"];
			
			if (!$manual && $this->Es_InstanciaNT($evento["Id_Instancia_Celsius"])){
				
				$result = $this->crearPedido_DestinoRemoto($evento["Id_Instancia_Celsius"],$datosPedido);
				if (is_a($result, "WS_Exception")){
					return $result;
				}
				$evento["Id_Pedido_Remoto"]=$result;
				$evento["destino_remoto"] = 1;
			}
			$conditionsPedidos["En_Busqueda"]=0;
    		 break;
    	} 	
		case EVENTO__A_ESPERA_DE_CONF_USUARIO:{
    		if ($datosPedido["origen_remoto"]){
    	    	$result = $this->generarEvento_DestinoRemoto($datosPedido["id_instancia_origen"],$idPedido,$evento["Codigo_Evento"], $evento["Observaciones"],"proveedor");
    	       	if (is_a($result, "WS_Exception")){
    	       		//no hago nada. sigo con la ejecucion nomral ya que el evento quedo en la cola de envios
    	       	}elseif(is_a($result, "Celsius_Exception")){
					return $result;
				}
    		}
    		break;
		}
 		case EVENTO__CONFIRMADO_POR_USUARIO:{
  			$conditions = "Id_Pedido ='".$idPedido."' AND Codigo_Evento=".EVENTO__A_ESPERA_DE_CONF_USUARIO." AND vigente = 1";
  			$result = $this->modificarEventos(array("vigente" => 0),$conditions);
			if (is_a($result, "Celsius_Exception")){
				return $result;
			}
			break;	
  		}   
    	case EVENTO__A_RECIBIDO:
    		
    		$id_solicitud = $evento["id_evento_origen"]; //el id de la solicitud q corresponde a esta recepcion
    		if (empty($datosPedido["Fecha_Alta_Pedido"]))  $datosPedido["Fecha_Alta_Pedido"]=$evento["Fecha"]; 
			if (empty($datosPedido["Fecha_Inicio_Busqueda"]))  $datosPedido["Fecha_Inicio_Busqueda"]=$datosPedido["Fecha_Alta_Pedido"];        			          			       
   			if (empty($datosPedido["Fecha_Solicitado"]))  $datosPedido["Fecha_Solicitado"]=$evento["Fecha"];
       		$Tardanza_Atencion = calcular_dias($datosPedido["Fecha_Alta_Pedido"],$datosPedido["Fecha_Inicio_Busqueda"]);
       		$Tardanza_Busqueda = calcular_dias($datosPedido["Fecha_Inicio_Busqueda"],$datosPedido["Fecha_Solicitado"]);
			$Tardanza_Recepcion = calcular_dias($datosPedido["Fecha_Solicitado"],$evento["Fecha"]);
            
            $conditionsPedidos["Ultimo_Pais_Solicitado"]= $evento["Codigo_Pais"];
			$conditionsPedidos["Ultima_Institucion_Solicitado"]=$evento["Codigo_Institucion"];
			$conditionsPedidos["Ultima_Dependencia_Solicitado"]=$evento["Codigo_Dependencia"];
			$conditionsPedidos["Ultima_Unidad_Solicitado"]=$evento["Codigo_Unidad"];
			$conditionsPedidos["Fecha_Recepcion"]=$evento["Fecha"];
			$conditionsPedidos["Numero_Paginas"]=$evento["Numero_Paginas"];
			$conditionsPedidos["Tardanza_Atencion"]=$Tardanza_Atencion;
			$conditionsPedidos["Tardanza_Busqueda"]=$Tardanza_Busqueda;
			$conditionsPedidos["Tardanza_Recepcion"]=$Tardanza_Recepcion;
			$conditionsPedidos["En_Busqueda"]=0;
            
            $hayArchivos = FilesUtils::containsFiles($archivos);
            
            $cola_envio=array();
            $id_instancia_remota = $datosPedido["id_instancia_origen"];
            
            if($hayArchivos){
            	
            	$conditionsPedidos["Estado"]=ESTADO__LISTO_PARA_BAJARSE;
                $evento["Codigo_Evento"]=EVENTO__A_AUTORIZADO_A_BAJARSE_PDF;
                
                require_once "../files/upload_archivos_pedido.php";
                
                //upload de archivos en forma local
		     	$resUpld = subirArchivoYAsociarAPedido($archivos['userfile'],$idPedido,"01");
		     	if (is_a($resUpld, "Celsius_Exception"))
    				return $resUpld;
				$resUpd = subirArchivoYAsociarAPedido($archivos['userfile1'],$idPedido,"02");
				if (is_a($resUpld, "Celsius_Exception"))
    				return $resUpld;
				$resUpd = subirArchivoYAsociarAPedido($archivos['userfile2'],$idPedido,"03");
				if (is_a($resUpld, "Celsius_Exception"))
    				return $resUpld;
				$resUpd = subirArchivoYAsociarAPedido($archivos['userfile3'],$idPedido,"04");
				if (is_a($resUpld, "Celsius_Exception"))
    				return $resUpld;
				$resUpd = subirArchivoYAsociarAPedido($archivos['userfile4'],$idPedido,"05");
				if (is_a($resUpld, "Celsius_Exception"))
    				return $resUpld;
	
		     	if ($datosPedido["origen_remoto"]){
		 			 //GENERA el archivo zip para enviarlo por SOAP
		 			
					$directorio_uploads = Configuracion::getDirectorioUploads();
					if (is_a($directorio_uploads, "File_Exception")){
    					return $directorio_uploads;
    				}
					
					$directorio_temp = Configuracion::getDirectorioTemporal();
					if (is_a($directorio_temp, "File_Exception")){
    					return $directorio_temp;
    				}
					
					$nombre_archivos = array();
					$archivos_pedido= $servicesFacade->getArchivosPedido($idPedido);
					foreach($archivos_pedido as $archivo_pedido)
			 			$nombre_archivos[]= $directorio_uploads.$archivo_pedido["nombre_archivo"];
			 			
			 		$nombreZipFile=$idPedido."__".$id_instancia_remota.".zip";
			 		$nombrePathZipFile = $directorio_temp.$nombreZipFile;
			 		
			 		
			 		$resCreacionZip = FilesUtils::createZipFile($nombre_archivos,$nombrePathZipFile);
			 		if ($resCreacionZip !== true){
			 			return $resCreacionZip;	
			 		}
		     		 
		     		$cola_envio['nombre_archivo']=$nombreZipFile;
		 		}
            }else{
                //Si no habia archivos, se registra como listo para entrega
 
				 $conditionsPedidos["Estado"]=ESTADO__RECIBIDO;
				 $evento["Codigo_Evento"]=EVENTO__A_RECIBIDO;

				 $cola_envio['nombre_archivo']="";
			}
		     
		     
			if ($datosPedido["origen_remoto"]){
				//agrego el evento a la cola de envios. Se agrega directamente en la cola para evitar q el usuario se quede esperando a q se envie el adjunto completo
            	$cola_envio['id_pedido']=$idPedido;
		     	$cola_envio['id_instancia_remota']=$id_instancia_remota;
		     	$cola_envio['enviado']=0;
		     	$cola_envio['fecha_ingreso']=date("Y-m-d H:i:s");
		     	$cola_envio['codigo_evento_local']=$evento["Codigo_Evento"];
		     	$cola_envio['observaciones']=$evento["Observaciones"];
		     	$cola_envio['rol_local']= "proveedor";
		     	 
		         $result = $this->agregarEventoNT_EnCola($cola_envio);
		     	if (is_a($result, "Celsius_Exception")){
					return $result;
				}
            }
            
    		$conditions = array("Id_Pedido" => $idPedido,"Codigo_Evento" => EVENTO__A_SOLICITADO, "vigente" => 1);
			$eventosSolicitud = $this->getEventos($conditions);
			
    		foreach ($eventosSolicitud as $solicitud){
    			if ($solicitud["destino_remoto"]){
    				$result = $this->generarEvento_DestinoRemoto($solicitud["id_instancia_destino"],$solicitud["Id_Pedido_Remoto"],$evento["Codigo_Evento"], $evento["Observaciones"],"creador");
		 		 	
		 		 	if (is_a($result, "WS_Exception")){
						//como hubo un error se permite la creacion del evento, pero se guarda en la cola de pendientes.
						//agrego el evento a la cola de envios
			         	
					}elseif (is_a($result, "Celsius_Exception")){
						return $result;
		 		 	}
    			}
    		}
    		
    		//actualizo las solicitudes
    		$conditions = "Id_Pedido ='".$idPedido."' AND Codigo_Evento=".EVENTO__A_SOLICITADO." AND vigente = 1 AND NOT(Id = ".$id_solicitud.")";
    		$result = $this->modificarEventos(array("vigente" => 0), $conditions);
    		if (is_a($result, "Celsius_Exception")){
    			return $result;
    		}
    		
    		$conditionsPedidos["En_Busqueda"]=0;
		     break;
		case EVENTO__A_ENTREGADO_IMPRESO:
  			 
  			 $conditions = array("Id_Pedido" => $idPedido,"Codigo_Evento" => EVENTO__A_RECIBIDO,"vigente" => 1);
			 $eventosRecepcion = $this->getEvento($conditions);
			 $evento["id_evento_origen"]=$eventosRecepcion["id_evento_origen"];
  			 $conditionsPedidos["Fecha_Entrega"]=$evento["Fecha"];
  			 $conditionsPedidos["En_Busqueda"]=0;
  		   	break;
        case EVENTO__A_CANCELADO_POR_USUARIO:
        case EVENTO__A_CANCELADO_POR_OPERADOR:
          		       	
          	if ($datosPedido["origen_remoto"]){
    		
    			$result = $this->generarEvento_DestinoRemoto($datosPedido["id_instancia_origen"],$idPedido,$evento["Codigo_Evento"], $evento["Observaciones"],"proveedor");
    			
    			if (is_a($result, "WS_Exception")){
    	       		//no hago nada. sigo con la ejecucion normal ya que el evento quedo en la cola de envios
    	       	}elseif(is_a($result, "Celsius_Exception")){
					return $result;
				}
    		}
    		
    		$conditions = array("Id_Pedido" => $idPedido,"Codigo_Evento" => EVENTO__A_SOLICITADO, "destino_remoto" => 1,"vigente" => 1);
			$eventosSolicitud = $this->getEventos($conditions);
    		foreach ($eventosSolicitud as $solicitud){
    			if ($solicitud["destino_remoto"]){
		 			$result = $this->generarEvento_DestinoRemoto($solicitud["Id_Instancia_Celsius"],$solicitud["Id_Pedido_Remoto"],$evento["Codigo_Evento"], $evento["Observaciones"],"creador");
		 		 	if (is_a($result, "WS_Exception")){
	    	       		//no hago nada. sigo con la ejecucion normal ya que el evento quedo en la cola de envios
	    	       	}elseif(is_a($result, "Celsius_Exception")){
						return $result;
					}
    			}
    		}
    		$conditionsPedidos["En_Busqueda"]=0;
         	break;
		 case EVENTO__A_OBSERVACION:
		  	$conditionsPedidos["Observado"]=1;
         	break;
         case EVENTO__A_PDF_DESCARGADO:
             $conditions = array("Id_Pedido" => $idPedido,"Codigo_Evento" => EVENTO__A_AUTORIZADO_A_BAJARSE_PDF,"vigente" => 1);
			 $eventosRecepcion = $this->getEvento($conditions);
  			 $evento["id_evento_origen"]=$eventosRecepcion["Id"];
		  	$conditionsPedidos["Fecha_Entrega"]=$evento["Fecha"];
		  	$conditionsPedidos["En_Busqueda"]=0;
         	break;
        case EVENTO__CONFIRMADO_POR_OPERADOR:

  			//se informa de la revision del operador solo a la instancia q solicito la confirmacion de datos 
  			$id_pedido_confirmacion = $evento["id_evento_origen"]; 
			
  			$evento_pedido_confirmacion = $this->getEvento($id_pedido_confirmacion);
  			$evento["Id_Pedido_Remoto"] = $evento_pedido_confirmacion["Id_Pedido_Remoto"];
  			
  			if (!empty($evento_pedido_confirmacion)){
  					  	
	  			$result = $this->generarEvento_DestinoRemoto($evento_pedido_confirmacion["Id_Instancia_Celsius"],$evento_pedido_confirmacion["Id_Pedido_Remoto"],$evento["Codigo_Evento"], $evento["Observaciones"],"creador");
			 	if (is_a($result, "WS_Exception")){
    	       		//no hago nada. sigo con la ejecucion normal ya que el evento quedo en la cola de envios
    	       	}elseif(is_a($result, "Celsius_Exception")){
					return $result;
				}
				$result = $this->dao->update("eventos", array("vigente" => 0) , "Id = $id_pedido_confirmacion");
				if (is_a($result, "Celsius_Exception"))
					return $result;
  			}
			break;
		case EVENTO__A_RECLAMADO_POR_OPERADOR:
			// 
  			$id_solicitud= $evento["id_evento_origen"]; 
			
  			$evento_solicitud = $this->getEvento($id_solicitud);
			$evento["Codigo_Pais"] = $evento_solicitud["Codigo_Pais"];
			$evento["Codigo_Institucion"] = $evento_solicitud["Codigo_Institucion"];
			$evento["Codigo_Dependencia"] = $evento_solicitud["Codigo_Dependencia"];
			$evento["Codigo_Unidad"] = $evento_solicitud["Codigo_Unidad"];
			$evento["Id_Instancia_Celsius"] = $evento_solicitud["Id_Instancia_Celsius"];
  			
  			if ($evento_solicitud["destino_remoto"] == 1){
  				$evento["Id_Pedido_Remoto"] = $evento_solicitud["Id_Pedido_Remoto"];
  				
	  			$result = $this->generarEvento_DestinoRemoto($evento_solicitud["Id_Instancia_Celsius"],$evento_solicitud["Id_Pedido_Remoto"],$evento["Codigo_Evento"], $evento["Observaciones"],"creador");
			 	if (is_a($result, "WS_Exception")){
    	       		//no hago nada. sigo con la ejecucion normal ya que el evento quedo en la cola de envios
    	       	}elseif(is_a($result, "Celsius_Exception")){
					return $result;
				}
  			}
    	 	break;
    	default:
			break;
       }// Fin del case
		
		$id_evento = $this->dao->insert("eventos",$evento);
		if (is_a($id_evento, "Celsius_Exception"))
			return $id_evento;
        
        if (!empty($conditionsPedidos)){
        	$res = $this->dao->update("pedidos",$conditionsPedidos,"Id ='$idPedido'");
        	if (is_a($res, "Celsius_Exception"))
				return $res;
        }
        
        if (!empty($conditionsPedidos["Estado"])){
        	if (PedidosUtils::Pedido_Pasa_Historico($conditionsPedidos["Estado"])){
        		
				$res = $this->Bajar_Historico_($idPedido);
				if (is_a($res, "Celsius_Exception"))
					return $res;
        	}
        }	
		return $id_evento;
    }
    
    
    function Bajar_Historico_($id_pedido){
    	if(empty($id_pedido))
			return new Application_Exception("El campo $id_pedido no puede ser vacio");
			
    	 $directorioUploads= Configuracion::getDirectorioUploads();
    	 if (is_a($directorioUploads, "File_Exception")){
    		return $directorioUploads;
    	 }
    	 
    	 $instruccion="INSERT INTO pedhist SELECT * FROM pedidos WHERE Id='".$id_pedido."' LIMIT 1";
    	 $res=$this->dao->query($instruccion);
    	 if (is_a($res, "Celsius_Exception"))
			return $res;
		 
		 $instruccion="INSERT INTO evhist SELECT * FROM eventos where Id_Pedido='$id_pedido'";
		 $res=$this->dao->query($instruccion);
    	 if (is_a($res, "Celsius_Exception"))
			return $res;
		
		 $res=$this->dao->delete("pedidos","Id='$id_pedido'");
		 if (is_a($res, "Celsius_Exception"))
			return $res;
			
		 $res=$this->dao->deleteAll("eventos","Id_Pedido='$id_pedido'");
		 if (is_a($res, "Celsius_Exception"))
			return $res;
			
		//borrar los zips del pedido
		$zipFiles = FilesUtils::getFilesNamed($directorioUploads, $id_pedido."__*.zip");
		FilesUtils::borrarArchivos($directorioUploads, $zipFiles);
		
		return TRUE;
    }
    
    /**
	 * @param string idPedido El id del pedido local si rol==proveedor, o el id del pedido remoto si rol == creador
	 * @param string rol ("proveedor" | "creador")
	 */
	function generarEvento_OrigenRemoto($idInstanciaRemota, $idPedido, $datosEvento, $miRol,$attached_file){
		
		$eventoNuevo = array();
		$tipoEvento = $datosEvento["tipo_evento_nt"];
		
		if ($miRol == "proveedor"){//el origen del pedido es remoto
			/** BEGIN **************************************************************/
			$idPedidoLocal = $idPedido;
			
			switch ($tipoEvento){
				case EVENTO_NT__CONFIRMADO:
					//el celsius remoto confirmo los datos del pedido

					//set vigente en false para el pedido de solicitud de confirmacion del usuario
					$conditions = "Id_Pedido ='".$idPedido."' AND Codigo_Evento=".EVENTO__A_ESPERA_DE_CONF_USUARIO." AND vigente = 1";
					$result = $this->modificarEventos(array("vigente" => 0),$conditions);
					if (is_a($result, "Celsius_Exception")){
						return $result;
					}					
					
					$idEventoNuevo = EVENTO__CONFIRMADO_POR_USUARIO;
					break;
				case EVENTO_NT__RECIBIDO:
					//el celsius remoto ya consiguio el pedido
					$pedidoLocal = $this->getPedido($idPedidoLocal); 
					if ($pedidoLocal["Estado"] == ESTADO__LISTO_PARA_BAJARSE){
						//El pedido fue satisfecho por mi
						$idEventoNuevo = EVENTO__A_PDF_DESCARGADO;
					}if ($pedidoLocal["Estado"] == ESTADO__RECIBIDO){
						//El pedido fue satisfecho por mi
						$idEventoNuevo = EVENTO__A_ENTREGADO_IMPRESO;
					}else{
						//El pedido no fue satisfecho por mi. Se cancela el pedido
						$idEventoNuevo = EVENTO__A_CANCELADO_POR_USUARIO;
					}
					break;
				case EVENTO_NT__CANCELADO:
					$idEventoNuevo = EVENTO__A_CANCELADO_POR_USUARIO;
					break;
				case EVENTO_NT__RECLAMADO:
					$idEventoNuevo = EVENTO__A_RECLAMADO_POR_USUARIO;
					break;
				default:
				 
					break;
			}
			
			/** END ****************************************************************/
		}else{//$miRol == "creador"
			$idPedidoRemoto = $idPedido;
			$conditions = array("Id_Pedido_Remoto" => $idPedidoRemoto,"Id_Instancia_Celsius" => $idInstanciaRemota, 
								"Codigo_Evento" => EVENTO__A_SOLICITADO, "vigente" => 1, "destino_remoto" => 1); 
			$solicitudRemota = $this->getObject("eventos", $conditions);
			
			$idPedidoLocal = $solicitudRemota["Id_Pedido"];
			$eventoNuevo["Id_Pedido_Remoto"] = $idPedidoRemoto;
			$eventoNuevo["id_evento_origen"] = $solicitudRemota["Id"];
			$eventoNuevo["Codigo_Pais"] = $solicitudRemota["Codigo_Pais"];
			$eventoNuevo["Codigo_Institucion"] = $solicitudRemota["Codigo_Institucion"];
			$eventoNuevo["Codigo_Dependencia"] = $solicitudRemota["Codigo_Dependencia"];
			$eventoNuevo["Codigo_Unidad"] = $solicitudRemota["Codigo_Unidad"];
			$eventoNuevo["Id_Instancia_Celsius"] = $solicitudRemota["Id_Instancia_Celsius"];
			
			switch ($tipoEvento){
				case EVENTO_NT__ESPERAR_CONFIRMACION:
					//el celsius remoto solicita la confirmacion de datos por parte  del operador local 
					
					$idEventoNuevo = EVENTO__A_ESPERA_DE_CONF_OPERADOR;
					break;
				case EVENTO_NT__ENVIADO://RECIBIDO POR EL PROVEEDOR
					//el celsius remoto ya consiguio el pedido, y me lo manda de alguna manera 
					$idEventoNuevo = EVENTO__A_INTERMEDIO_POR_NT;
					if (!empty($attached_file)){
						//viene un zip con los pdfs
						$directorio= Configuracion::getDirectorioUploads();
						if (is_a($directorio, "File_Exception")){
				    		return $directorio;
    	 				}	
						
						$nombreZipFile=$idPedidoLocal."__".$idInstanciaRemota.".zip";
						$nombrePathZipFile = $directorio.$nombreZipFile;
																		
						$res = FilesUtils::escribirArchivoCompleto($nombrePathZipFile,$attached_file);
						if (is_a($res, "Celsius_Exception"))
							return $res;
						
						$archivo_pedido_nuevo = array();
						$archivo_pedido_nuevo["Fecha_Upload"]= date("Y-m-d H:i:s");
						$archivo_pedido_nuevo["nombre_archivo"]= $nombreZipFile;
						$archivo_pedido_nuevo["codigo_pedido"]= $idPedidoLocal;
						$archivo_pedido_nuevo["Permitir_Download"]= 0;
						$codigo_archivo = $this->agregarArchivoPedido($archivo_pedido_nuevo);
						if (is_a($codigo_archivo, "Celsius_Exception"))
							return $codigo_archivo;
					}
					break;
				case EVENTO_NT__CANCELADO:
					//el celsius remoto cancelo el pedido. Puede ser q no tenga lo q se le pidio
					//se debe cancelar la solicitud hecha
										
					$eventoSolicitudModificado = array();
					$eventoSolicitudModificado["vigente"] =0;
					$eventoSolicitudModificado["motivo_anulacion"] = $datosEvento["Observaciones"];
					$eventoSolicitudModificado["fecha_anulacion"] = date("Y-m-d H:i:s");
					
					$res=$this->dao->update("eventos", $eventoSolicitudModificado, "Id=".$solicitudRemota["Id"]);
					if (is_a($res,"Celsius_Exception")){
					  return $res;
					}
					$cantSolicitudes = $this->getCount("eventos", array("Id_Pedido" => $idPedidoLocal,"Codigo_Evento" => EVENTO__A_SOLICITADO, "vigente" => 1));
					if ($cantSolicitudes == 0){
						$camposPedido = array("Estado" => ESTADO__BUSQUEDA);
						$res=$this->dao->update("pedidos", $camposPedido, "Id = '$idPedidoLocal'");
						if (is_a($res,"Celsius_Exception")){
						    return $res;
						 }
					}
					return TRUE;
							  
					break;
				default:
				
					break;
			}
			
		}
		$eventoNuevo["Fecha"] = date("Y-m-d H:i:s");
		$eventoNuevo["vigente"] = 1;
		$eventoNuevo["Observaciones"] = $datosEvento["Observaciones"];
		$eventoNuevo["Id_Pedido"] = $idPedidoLocal;
		$eventoNuevo["Codigo_Evento"]=$idEventoNuevo;
		
		$res=$this->dao->insert("eventos", $eventoNuevo);
		if (is_a($res, "Celsius_Exception"))
			return $res;
			
		$codEstadoNuevo = PedidosUtils::Determinar_Estado($idEventoNuevo);
		
		if ($codEstadoNuevo != 0){
			$result=$this->dao->update("pedidos", array("Estado" => $codEstadoNuevo), "Id = '$idPedidoLocal'");
			if (is_a($result, "Celsius_Exception"))
				return $result;
			if (PedidosUtils::Pedido_Pasa_Historico($codEstadoNuevo)){
				$res = $this->Bajar_Historico_($idPedidoLocal);
				if (is_a($res, "Celsius_Exception"))
					return $res;
		     }
		}
		return TRUE;
	}
	
	function getCount($table,$conditions){
	  	$where='';
        foreach($conditions as $fieldName => $fieldValue){
			if ($where) 
	 			$where .= "AND ($fieldName = :$fieldName)";
	 		else
	 			$where .= "WHERE ($fieldName = :$fieldName)";
	 	}

        // build the statement
        $sql = "select count(*) as cantidad from ".$table.' '.$where; 
         
        // execute the statement and return the number of affected rows
        $result = $this->dao->fetchRow($sql, $conditions);

        if (is_a($result,"Celsius_Exception")){
        	return $result;
        }
        return $result['cantidad'];
		
	}
		 
	/**
	 * Genera un evento en una instancia celsius remota, si es que se puede. 
	 * @param string $id_instancia_remota
	 * @param string $idPedido
	 * @param int $codigo_evento_local
	 * @param string $observaciones_evento
	 * @param string $rol_local
	 * @param string $attach_file_name? default = ""
	 * @param int $id_evento_envio? default = 0 El id del evento de envio que se corresponde con el evento
	 * remoto que se esta tratando de generar. Si no se especifica, se asume que dicho evento de envio no existe, 
	 * y por ello, sera creado
	 * @throws WS_Exception En caso de no poder concretar la invocacion exitosa del metodo remoto
	 * @throws DB_Exception En caso de producirse un error de BDD
	 * @throws File_Exception En caso de no poder leer el archivo indicado por $attach_file_name (si es que el parametro fue especificado)
	 * @throws Celsius_Exception en caso de producirse alghun otro tipo de error
	 */
	function generarEvento_DestinoRemoto($id_instancia_remota,$idPedido,$codigo_evento_local, $observaciones_evento, $rol_local, $attach_file_name = "", $id_evento_envio = 0){
		
		//carga en la cola el evento NT si se indica
		if (empty($id_evento_envio)){
			$cola_envio['id_pedido']=$idPedido;
			$cola_envio['id_instancia_remota']=$id_instancia_remota;
			$cola_envio['nombre_archivo'] = $attach_file_name;
			$cola_envio['codigo_evento_local']=$codigo_evento_local;
			$cola_envio['observaciones']=$observaciones_evento;
			$cola_envio['rol_local']= $rol_local;
			
			$cola_envio['fecha_ingreso']=date("Y-m-d H:i:s");
			$cola_envio['enviado']=0;
						    	 
			$result = $id_evento_envio = $this->agregarEventoNT_EnCola($cola_envio);
			if (is_a($result, "Celsius_Exception"))
				return $result;
		}
		
		//creo el evento NT
		$eventoNTNuevo = array();
		$eventoNTNuevo["Observaciones"] = $observaciones_evento;
		$eventoNTNuevo["tipo_evento_nt"] = PedidosUtils::getEventoNT($codigo_evento_local,$rol_local);
		
		//leo el archivo si corresponde
		$directorio_temp= Configuracion::getDirectorioTemporal();
		if (is_a($directorio_temp, "File_Exception")){
    		return $directorio_temp;
    	 }
				
		if (!empty($attach_file_name))
			$attach_file_contents = file_get_contents($directorio_temp.$attach_file_name);
		else
			$attach_file_contents = "";
		if ($attach_file_contents === false)
			return new File_Exception("No se pudo abrir el archivo '".$directorio_temp.$attach_file_name."'");
		
		$clienteSOAP = $this->getCelsiusSOAPClient();
		//var_dump($clienteSOAP);
		$inicio = microtime_float();
		$res = $clienteSOAP->generarEvento_DestinoRemoto($id_instancia_remota,$idPedido,$eventoNTNuevo,$rol_local,$attach_file_contents);
		
		$evento_cola = array();
		$evento_cola["duracion"] = (int)((microtime_float() - $inicio) * 1000) ;
		$evento_cola["id_envio"] = $id_evento_envio;
		$evento_cola["fecha"] = date("Y-m-d H:i:s");
		if (is_a($res, "WS_Exception")){
			//no se pudo enviar el evento, sigo iterando
			$evento_cola["error_msg"] = $res->getMessage();
		}elseif (is_a($res, "Celsius_Exception")){
			return $res;
		}else{
			//el envio se realizo correctamente
			$resUpd = $this->modificarEventoNT_EnCola(array("enviado" => 1, "id" => $id_evento_envio));
			if (is_a($resUpd, "Celsius_Exception"))
				return $resUpd;
		}
			
		$resUpd = $this->agregarEnvioNT_EnCola($evento_cola);
		if (is_a($resUpd, "Celsius_Exception"))
			return $resUpd;
		
		//termino. O bien se envio el evento, u ocurrio algun error con WS.
		return $res;
	}
	
	/**
	 * Vacia la cola de eventos NT. 
	 * @return int $cant_eventos_enviados La cantidad de eventos enviados satisfactoriamente.
	 * @throws Celsius_Exception en caso de generarse alun error (no de WS) 
	 */
	function vaciarColaEventosNT(){
		$conditions = array("enviado" => 0);
			
		$eventos_a_enviar = $this->getColaEventosNT($conditions);
		$cant_eventos_enviados =0;
		foreach($eventos_a_enviar as $envio){
			$res = $this->generarEvento_DestinoRemoto($envio["id_instancia_remota"],$envio["id_pedido"],$envio["codigo_evento_local"],$envio["observaciones"],$envio["rol_local"], $envio["nombre_archivo"], $envio["id"]);
			if (is_a($res, "WS_Exception")){
				//no hago nada. tampoco sumo $cant_eventos_enviados porq el evento no se pudo generar remotamente
		    }elseif (is_a($res, "Celsius_Exception"))
				return $res;
			else
				$cant_eventos_enviados++;
		}
		return $cant_eventos_enviados;
		
	}
	

	function getUsuarios($conditions, $cols ="Id,Apellido,Nombres, Login, Password"){
		return $this->getAllObjects("usuarios", $conditions, $cols,"Apellido,Nombres");
	}
	
	function getUsuarios_CantidadPedidos($estado){
	  	
	  	$select= $this->dao->select();
	  	$select->from("usuarios","usuarios.*");
	  	$select->joinInner("pedidos","pedidos.Codigo_Usuario = usuarios.Id","COUNT(pedidos.Id) as cantPedidos,MIN(pedidos.Fecha_Recepcion) as min_recepcion");
	  	if (!empty($estado))
	  		$select->where("pedidos.Estado = ?",$estado);
	  	$select->group("pedidos.Codigo_Usuario");
	  	$select->order("usuarios.Apellido");
	  	return $this->dao->fetchAll($select);
	}
	
	function ejecutarSQL($sentenciaSQL){
		return $this->dao->fetchAll($sentenciaSQL);
	}
		
	function ejecutarActualizacionDirectorio($updateSQL){
		foreach ($updateSQL as $sentenciaSQL){
			$result= $this->dao->query($sentenciaSQL);
			if (is_a($result,"Celsius_Exception")){
        		return $result;
        	}
		}
		return true;
	}
	
	function modificarEventos($colsToUpdate, $conditions = ""){
		return $this->dao->updateAll("eventos", $colsToUpdate, $conditions);
	}
	
	//////////////////////////////////////////////////////////////////////
	///////////////////////////// campos pedidos ////////////////////////////////
	//////////////////////////////////////////////////////////////////////
	

	function getCampoPedidos($id_idioma, $id_campo){
		return $this->getObject("campos_pedidos_traducidos",array("id_idioma" => $id_idioma, "id_campo" => $id_campo));
	}
	
	function getAllCamposPedidosTraducidos($id_campo){
		return $this->getAllObjects("campos_pedidos_traducidos",array("id_campo" => $id_campo));
	}
	
		
	function insertCampoPedidos($id_idioma, $id_campo, $datos){
		
		$fieldValues= "texto='".$datos['texto']."', abreviatura='".$datos['abreviatura']."', mensaje_ayuda='".$datos['mensaje_ayuda']."', mensaje_error='".$datos['mensaje_error']."'";
		
		$sql = " INSERT INTO campos_pedidos_traducidos "
			  ." SET id_campo='".$id_campo."', id_idioma='".$id_idioma."', ".$fieldValues
			  ." ON DUPLICATE KEY UPDATE ".$fieldValues;
		
		$result= $this->dao->query($sql);
		if (is_a($result,"Celsius_Exception"))
        	return $result;
		return true;	
	}
	
	
	
	function getCamposPedidos($id_idioma, $tipo_material){
		$select = $this->dao->select();
		$select->from("campos_pedidos as cp");
		$select->joinInner("campos_pedidos_traducidos as cpt", "cp.id = cpt.id_campo");
		$select->where("id_idioma = ?", $id_idioma);
		$select->where("tipo_material = ?", $tipo_material);
		$camposPedidos = $this->dao->fetchAll($select);
		$camposPorCodigo = array();
		foreach ($camposPedidos as $campo){
			$camposPorCodigo[$campo["codigo"]]=$campo;
		}
		return $camposPorCodigo;
	}
	
	function getCampoPedido($idCampo){
		return $this->getObject("campos_pedidos", array("id" => $idCampo));
	}
	
	
	function getAllCamposPedidos($idTipo= 0){
		if (isset($idTipo)){
			$conditions= array("tipo_material" => $idTipo);}
				
		return $this->getAllObjects('campos_pedidos', $conditions);
	}
	
	function getTiposMateriales(){
		$IdiomaSitio = SessionHandler::getIdioma();
		$VectorIdioma= $this->ObtenerVectorIdioma($IdiomaSitio);
		$descripcionesTipoDeMaterial= PedidosUtils::getTiposMateriales($VectorIdioma);
		$nombres= array();
			
		foreach ($descripcionesTipoDeMaterial as $indice => $valor){
			$nombres[] = array("idTipoMaterial"=>$indice, "descripcion"=>$valor);
		}
		return $nombres;
	}
		
	function getPaisPredeterminado(){
		$select = $this->dao->select();
		$select->from("paises","paises.*");
		$select->joinInner("parametros", "paises.Id=parametros.id_pais");
		return $this->dao->fetchRow($select);
	}
	
	function getInstitucionPredeterminada(){
		$select = $this->dao->select();
		$select->from("instituciones","instituciones.*");
		$select->joinInner("parametros", "instituciones.Codigo=parametros.id_institucion");
		return $this->dao->fetchRow($select);
	}
	function getDependenciaPredeterminada(){
		$select = $this->dao->select();
		$select->from("dependencias","dependencias.*");
		$select->joinInner("parametros", "dependencias.Id=parametros.id_dependencia");
		return $this->dao->fetchRow($select);
	}
	function getUnidadPredeterminada(){
		$select = $this->dao->select();
		$select->from("unidades","unidades.*");
		$select->joinInner("parametros", "unidades.Id=parametros.id_unidad");
		return $this->dao->fetchRow($select);
	}
	
	

	//////////////////////////////////////////////////////////////////
	/////////////////////////// Formas de Entrega ////////////////////
	//////////////////////////////////////////////////////////////////
	function getFormasDeEntrega($conditions=array()) {
		return $this->getAllObjects("forma_entrega", $conditions, "*", "nombre");
	}
	
	function modificarFormaDeEntrega($formadeentrega){
 		
 		$Id = $formadeentrega["id"];
 		unset($formadeentrega["id"]); 
 		return $this->dao->update("forma_entrega", $formadeentrega, "id=".$Id);
 		
 	}
 	function getFormaDeEntrega($idFormaEntrega) {
		$conditions= array("Id" => $idFormaEntrega);
		return $this->getObject("forma_entrega", $conditions);
	}
 	function agregarFormaDeEntrega($formadeentrega){
 		return $this->dao->insert("forma_entrega", $formadeentrega); 		
 	}
 	//////////////////////////////////////////////////////////////////
	////////////////////////////// Catalogos /////////////////////////
	//////////////////////////////////////////////////////////////////
	
 	function getCatalogos($conditions=array()) {
		return $this->getAllObjects("catalogos", $conditions, "*", "Nombre");
	}
	
	function modificarCatalogo($catalogo){
 		
 		$Id = $catalogo["Id"];
 		unset($catalogo["Id"]); 
 		return $this->dao->update("catalogos", $catalogo, "Id=".$Id);
 		
 	}
 	function getCatalogo($idCatalogo) {
		$conditions= array("Id" => $idCatalogo);
		return $this->getObject("catalogos", $conditions);
	}
 	function agregarCatalogo($catalogo){
 		return $this->dao->insert("catalogos", $catalogo); 		
 	}
	//////////////////////////////////////////////////////////////////
	////////////////////////////// Pantallas /////////////////////////
	//////////////////////////////////////////////////////////////////
	
 	
 	function modificarPantalla($pantalla , $IdAnterior){
 		
 		$res  = $this->dao->update("pantalla", $pantalla, "Id='".$IdAnterior."'");
 		if (is_a($res, "Celsius_Exception"))
			return $res;
 		
 		$updFields = array("Codigo_Pantalla" => $pantalla["Id"]);
 		$res  = $this->dao->updateAll("elementos", $updFields, "Codigo_Pantalla='".$IdAnterior."'");
 		if (is_a($res, "Celsius_Exception"))
			return $res;

		$res  = $this->dao->updateAll("traducciones", $updFields, "Codigo_Pantalla='".$IdAnterior."'");
 		if (is_a($res, "Celsius_Exception"))
			return $res;
			
		return true;	
 	}
 	
 	function getPantalla($idPantalla) {
		$conditions= array("Id" => $idPantalla);
		return $this->getObject("pantalla", $conditions);
	}
 	function agregarPantalla($pantalla){
 		return $this->dao->insert("pantalla", $pantalla); 		
 	}
 	
 	function getPantallas($conditions=array()) {
		return $this->getAllObjects("pantalla", $conditions, "*", "Id");
	}
	
	//////////////////////////////////////////////////////////////////
	////////////////////////////// Traducciones///////////////////////
	//////////////////////////////////////////////////////////////////
	function modificarTraduccion($traduccion){
 		$condicion = '';
 		
 		if (isset($traduccion["Anterior"])) {
	 		$Codigo_Elemento = $traduccion["Anterior"];
	 		unset($traduccion["Anterior"]); 
 		}
 		else{
 			$Codigo_Elemento = $traduccion["Codigo_Elemento"];
	 		unset($traduccion["Codigo_Elemento"]); 
 		}
 		
 		if (isset($traduccion["PaginaAnterior"])) {
	 		$Codigo_Pantalla = $traduccion["PaginaAnterior"];
	 		unset($traduccion["PaginaAnterior"]);
 		} 		
 		else
 		{
 			$Codigo_Pantalla = $traduccion["Codigo_Pantalla"];
	 		unset($traduccion["Codigo_Pantalla"]); 
 			
 		}
 		
 		$condicion = 'Codigo_Elemento=\''.$Codigo_Elemento.'\' AND Codigo_Pantalla=\''.$Codigo_Pantalla.'\'';
 		
 		if (isset($traduccion["Codigo_Idioma"])) {
	 		$Codigo_Idioma = $traduccion["Codigo_Idioma"];
	 		unset($traduccion["Codigo_Idioma"]);
	 		$condicion .= ' AND Codigo_Idioma=\''.$Codigo_Idioma.'\'';
 		} 	
 		
 		
 		return $this->dao->update("traducciones", $traduccion,  $condicion);
 		
 	}
 	
 	
 	function agregarTraduccion($traduccion){
 		return $this->dao->insert("traducciones", $traduccion);
 		
 	}
 	
 	
 	function getTraduccion($Codigo_Pagina , $Codigo_Elemento , $Codigo_Idioma) {
		$conditions= array("Codigo_Elemento" => $Codigo_Elemento,"Codigo_Pantalla" => $Codigo_Pagina,"Codigo_Idioma" => $Codigo_Idioma);
		
		return $this->getObject("traducciones", $conditions);
	}
	
	
	function getTraducciones($conditions ,$cols="*" , $order = null){
		return $this->getAllObjects("traducciones",$conditions , $cols);
	}
	
	//////////////////////////////////////////////////////////////////
	////////////////////////////// Elementos /////////////////////////
	//////////////////////////////////////////////////////////////////
 	
 	function getElemento($Codigo_Pagina , $Codigo_Elemento) {
		$conditions= array("Codigo_Elemento" => $Codigo_Elemento,"Codigo_Pantalla" => $Codigo_Pagina);
		return $this->getObject("elementos", $conditions);
	}
 	
 	function agregarElemento($elemento){
 		return $this->dao->insert("elementos", $elemento); 		
 	}
 	
 	function getElementos($conditions=array()) {
		return $this->getAllObjects("elementos", $conditions, "*", "Codigo_Elemento");
	}
	
	function modificarElemento($elemento){
 		
 		$Codigo_Elemento = $elemento["Anterior"];
 		unset($elemento["Anterior"]); 
 		$Codigo_Pagina = $elemento["PaginaAnterior"];
 		unset($elemento["PaginaAnterior"]);
 		return  $this->dao->update("elementos", $elemento,  'Codigo_Elemento=\''.$Codigo_Elemento.'\' AND Codigo_Pantalla=\''.$Codigo_Pagina.'\'');
 		
 		$res = $this->dao->updateAll("traducciones", $elemento,  'Codigo_Elemento=\''.$Codigo_Elemento.'\' AND Codigo_Pantalla=\''.$Codigo_Pagina.'\'');
 		
 	}
 	
 	function obtenerElementosSinTraducciones($cod_pantalla, $cod_idioma){
 		$cantIdiomas= sizeof($this->getIdiomas());
 		 		
 		$sql=  'SELECT e.Codigo_Pantalla, e.Codigo_Elemento
				FROM elementos e
				WHERE (e.Codigo_Pantalla="'.$cod_pantalla.'") and (e.Codigo_Elemento) NOT IN (
					SELECT t.Codigo_Elemento 
					FROM traducciones t 
					WHERE (t.Codigo_Pantalla="'.$cod_pantalla.'")and(t.traduccion_completa=1) ';
		
		if(!empty($cod_idioma))							
			$sql.= ' and(t.Codigo_Idioma='.$cod_idioma.') ';
		else
			$sql.= ' GROUP BY t.Codigo_Elemento ' .
				   ' HAVING count(*)='.$cantIdiomas.' ';

		$sql.=');';
		
		$resul= $this->dao->fetchAll($sql);
		return $resul;
 	}
 	 	
 	
 	//////////////////////////////////////////////////////////////////
	////////////////////////////// Idiomas ///////////////////////////
	//////////////////////////////////////////////////////////////////
	
	function getIdiomaPredeterminado(){
		return $this->getObject("idiomas",array("Predeterminado" => 1));
	}
	

	function getIdiomaDisponible($conditions = array()){
		return $this->getObject("idiomas", $conditions,"Id, Nombre, Predeterminado");
	}
	
	function getIdiomasDisponibles(){
		return $this->getAllObjects("idiomas", array(), "Id, Nombre, Predeterminado", "Nombre");
	}
	
	function ObtenerVectorIdioma($id_idioma){
		return $this->getObject("idiomas", array("Id"=>$id_idioma));
	}	
	
	function getIdiomas($conditions=array()) {
		return $this->getAllObjects("idiomas", $conditions, "*", "Nombre");
	}
	
	function getIdioma($Codigo_Idioma, $cols="*") {
		$conditions= array("Id" => $Codigo_Idioma);		
		return $this->getObject("idiomas", $conditions,$cols);
	}
	function agregarIdioma($idioma){
 		return $this->dao->insert("idiomas", $idioma); 		
 	}
 	function modificarIdioma($idioma){
 		
 		$Id = $idioma["Id"];
 		unset($idioma["Id"]); 
 		return $this->dao->update("idiomas", $idioma, "Id=".$Id);
 	}
 	
 	function deshacerIdiomaPredeterminado(){
 		$idioma =array("Predeterminado" =>"0");
 		return $this->dao->updateAll("idiomas", $idioma, "");
 	}
 	//////////////////////////////////////////////////////////////////
	////////////////////////////// Sugerencias ///////////////////////
	//////////////////////////////////////////////////////////////////
	
	function eliminarSugerencia($CodigoSugerencia ){	
		$res = $this->dao->delete("sugerencias",'Id='.$CodigoSugerencia);
		if (is_a($res, "Celsius_Exception"))
			return $res;	
	}
	function getSugerencias($conditions=array()) {
		return $this->getAllObjects("sugerencias", $conditions);
	}
	
	function getSugerencia($CodigoSugerencia) {
		$conditions= array("Id" => $CodigoSugerencia);		
		return $this->getObject("sugerencias", $conditions);
	}
	function agregarSugerencia($sugerencia){
 		return $this->dao->insert("sugerencias", $sugerencia); 		
 	}
 	function modificarSugerencia($sugerencia){ 		
 		$Id = $sugerencia["Id"];
 		unset($sugerencia["Id"]); 
 		return $this->dao->update("sugerencias", $sugerencia, "Id=".$Id);
 		
 	}
 	
 	///////////////////////////////////////////////////////////////////////////
	/////////////////////////// COLA DE ENVIOS NT /////////////////////////////
	///////////////////////////////////////////////////////////////////////////
 	
 	function agregarEventoNT_EnCola($envio){
 		return $this->dao->insert("cola_eventos_nt", $envio);
 	}
 	
 	 	
 	function modificarEventoNT_EnCola($envio){
 		$Id = $envio["id"];
 		unset($envio["id"]); 
 		return $this->dao->update("cola_eventos_nt", $envio, "Id=".$Id);
 	}
 	
 	function getColaEventosNT ($conditions=array(), $cols = "*") {
		return $this->getAllObjects("cola_eventos_nt", $conditions,$cols,"fecha_ingreso");
	}
	
 	function agregarEnvioNT_EnCola($evento_envio){
 		return $this->dao->insert("cola_envios_nt", $evento_envio);
 	}
 	
 	function modificarEnvioNT_EnCola($evento_envio){
 		$Id = $evento_envio["Id"];
 		unset($evento_envio["Id"]); 
 		return $this->dao->update("cola_envios_nt", $evento_envio, "Id=".$Id);
 	}
 	
 	function getColaEnviosNT($conditions=array()) {
		return $this->getAllObjects("cola_envios_nt", $conditions);
	}
	
	
	///////////////////////////////////////////////////////////////////////////
	/////////////////////////// EXISTENCIAS ///////////////////////////////////
	///////////////////////////////////////////////////////////////////////////
 	
	function getExistencias($conditions=array()) {
		return $this->getAllObjects("existencia", $conditions);
	}
 }
 
 if (! function_exists('is_a')) {
   function is_a($anObject, $aClass) {
      return strtolower(get_class($anObject)) == strtolower($aClass)
        or is_subclass_of($anObject, $aClass);
   }
}
if (!function_exists("stripos")) {
	function stripos($str,$needle,$offset=0){
		return strpos(strtolower($str),strtolower($needle),$offset);
	}
}


if(!function_exists('array_combine')){
	function array_combine($keys = array(), $values) {
   		$out=array();
  		foreach($keys as $key) 
   			$out[$key] = array_shift($values);
   		return $out;
	}
}



/**
 * Retorna la diferencia de dias entre dos fechas. El formato de la fecha debera se "Y-m-d".
 * 
 */
function calcular_dias($inicio,$fin = 0){
	if (empty($inicio))
		$inicio= date("Y-m-d");
	if (empty($fin))
		$fin= date("Y-m-d");
	$inicio_ts = strtotime($inicio);
	$fin_ts = strtotime($fin);
	$deltats = $fin_ts - $inicio_ts;
	if( $deltats > 0 )
		return (int) floor( $deltats / 86400 );
	else
		return (int) ceil( $deltats / 86400 );
}

if (!function_exists("microtime_float")) {
	function microtime_float()
	{
		list($useg, $seg) = explode(" ", microtime());
		return ((float)$useg + (float)$seg);
	}
}
?>