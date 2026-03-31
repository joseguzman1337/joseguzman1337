<?php



/**
*
* soapclient higher level class for easy usage.
*
* usage:
*
* // instantiate client with server info
* $soapclient = new soapclient( string path [ ,boolean wsdl] );
*
* // call method, get results
* echo $soapclient->call( string methodname [ ,array parameters] );
*
* // bye bye client
* unset($soapclient);
*
* @author   Dietrich Ayala <dietrich@ganx4.com>
* @version  v 0.6.3
* @access   public
*/
class soapclient extends nusoap_base  {

	var $username = '';
	var $password = '';
	var $requestHeaders = false;
	var $responseHeaders;
	var $endpoint;
	var $error_str = false;
    var $proxyhost = '';
    var $proxyport = '';
    var $xml_encoding = '';
	var $http_encoding = false;
	var $timeout = 0;
	var $endpointType = '';
	var $persistentConnection = false;
	var $defaultRpcParams = false;
	
	/**
	* fault related variables
	*
	* @var      fault
	* @var      faultcode
	* @var      faultstring
	* @var      faultdetail
	* @access   public
	*/
	var $fault, $faultcode, $faultstring, $faultdetail;

	/**
	* constructor
	*
	* @param    string $endpoint SOAP server or WSDL URL
	* @param    bool $wsdl optional, set to true if using WSDL
	* @param	int $portName optional portName in WSDL document
	* @access   public
	*/
	function soapclient($endpoint,$wsdl = false){
		$this->endpoint = $endpoint;

		// make values
		if($wsdl){
			$this->endpointType = 'wsdl';
			$this->wsdlFile = $this->endpoint;
			
			// instantiate wsdl object and parse wsdl file
			$this->debug('instantiating wsdl class with doc: '.$endpoint);
			$this->wsdl =& new wsdl($this->wsdlFile,$this->proxyhost,$this->proxyport);
			$this->debug("wsdl debug: \n".$this->wsdl->debug_str);
			$this->wsdl->debug_str = '';
			// catch errors
			if($errstr = $this->wsdl->getError()){
				$this->debug('got wsdl error: '.$errstr);
				$this->setError('wsdl error: '.$errstr);
			} elseif($this->operations = $this->wsdl->getOperations()){
				$this->debug( 'got '.count($this->operations).' operations from wsdl '.$this->wsdlFile);
			} else {
				$this->debug( 'getOperations returned false');
				$this->setError('no operations defined in the WSDL document!');
			}
		}
	}

	/**
	* calls method, returns PHP native type
	*
	* @param    string $method SOAP server URL or path
	* @param    array $params array of parameters, can be associative or not
	* @param	string $namespace optional method namespace
	* @param	string $soapAction optional SOAPAction value
	* @param	boolean $headers optional array of soapval objects for headers
	* @param	boolean $rpcParams optional treat params as RPC for use="literal"
	*                   This can be used on a per-call basis to overrider defaultRpcParams.
	* @return	mixed
	* @access   public
	*/
	function call($operation,$params=array(),$namespace='',$soapAction='',$headers=false,$rpcParams=null){
		$this->operation = $operation;
		$this->fault = false;
		$this->error_str = '';
		$this->request = '';
		$this->response = '';
		$this->faultstring = '';
		$this->faultcode = '';
		$this->opData = array();
		
		$this->debug("call: $operation, $params, $namespace, $soapAction, $headers, $rpcParams");
		$this->debug("endpointType: $this->endpointType");
		// if wsdl, get operation data and process parameters
		if($this->endpointType == 'wsdl' && $opData = $this->getOperationData($operation)){

			$this->opData = $opData;
			foreach($opData as $key => $value){
				$this->debug("$key -> $value");
			}
			$soapAction = $opData['soapAction'];
			$this->endpoint = $opData['endpoint'];
			$namespace = isset($opData['input']['namespace']) ? $opData['input']['namespace'] :	'http://testuri.org';
			$style = $opData['style'];
			// add ns to ns array
			if($namespace != '' && !isset($this->wsdl->namespaces[$namespace])){
				$this->wsdl->namespaces['nu'] = $namespace;
            }
			// serialize payload
			
			if($opData['input']['use'] == 'literal') {
				if (is_null($rpcParams)) {
					$rpcParams = $this->defaultRpcParams;
				}
				if ($rpcParams) {
					$this->debug("serializing literal params for operation $operation");
					$payload = $this->wsdl->serializeRPCParameters($operation,'input',$params);
					$defaultNamespace = $this->wsdl->wsdl_info['targetNamespace'];
				} else {
					$this->debug("serializing literal document for operation $operation");
					$payload = is_array($params) ? array_shift($params) : $params;
				}
			} else {
				$this->debug("serializing encoded params for operation $operation");
				$payload = "<".$this->wsdl->getPrefixFromNamespace($namespace).":$operation>".
				$this->wsdl->serializeRPCParameters($operation,'input',$params).
				'</'.$this->wsdl->getPrefixFromNamespace($namespace).":$operation>";
			}
			$this->debug('payload size: '.strlen($payload));
			// serialize envelope
			$soapmsg = $this->serializeEnvelope($payload,$this->requestHeaders,$this->wsdl->usedNamespaces,$style);
			$this->debug("wsdl debug: \n".$this->wsdl->debug_str);
			$this->wsdl->debug_str = '';
		} elseif($this->endpointType == 'wsdl') {
			$this->setError( 'operation '.$operation.' not present.');
			$this->debug("operation '$operation' not present.");
			$this->debug("wsdl debug: \n".$this->wsdl->debug_str);
			return false;
		// no wsdl
		} else {
			// make message
			if(!isset($style)){
				$style = 'rpc';
			}
            if($namespace == ''){
            	$namespace = 'http://testuri.org';
                $this->wsdl->namespaces['ns1'] = $namespace;
            }
			// serialize envelope
			$payload = '';
			foreach($params as $k => $v){
				$payload .= $this->serialize_val($v,$k);
			}
			$payload = "<ns1:$operation xmlns:ns1=\"$namespace\">\n".$payload."</ns1:$operation>\n";
			$soapmsg = $this->serializeEnvelope($payload,$this->requestHeaders);
		}
		$this->debug("endpoint: $this->endpoint, soapAction: $soapAction, namespace: $namespace");
		// send
		$this->debug('sending msg (len: '.strlen($soapmsg).") w/ soapaction '$soapAction'...");
		$return = $this->send($soapmsg,$soapAction,$this->timeout);
		if($errstr = $this->getError()){
			$this->debug('Error: '.$errstr);
			return false;
		} else {
			$this->return = $return;
			$this->debug('sent message successfully and got a(n) '.gettype($return).' back');
			
			// fault?
			if(is_array($return) && isset($return['faultcode'])){
				$this->debug('got fault');
				$this->setError($return['faultcode'].': '.$return['faultstring']);
				$this->fault = true;
				foreach($return as $k => $v){
					$this->$k = $v;
					$this->debug("$k = $v<br>");
				}
				return $return;
			} else {
				// array of return values
				if(is_array($return)){
					// multiple 'out' parameters
					if(sizeof($return) > 1){
						return $return;
					}
					// single 'out' parameter
					return array_shift($return);
				// nothing returned (ie, echoVoid)
				} else {
					return "";
				}
			}
		}
	}

	/**
	* get available data pertaining to an operation
	*
	* @param    string $operation operation name
	* @return	array array of data pertaining to the operation
	* @access   public
	*/
	function getOperationData($operation){
		if(isset($this->operations[$operation])){
			return $this->operations[$operation];
		}
		$this->debug("No data for operation: $operation");
	}

    /**
    * send the SOAP message
    *
    * Note: if the operation has multiple return values
    * the return value of this method will be an array
    * of those values.
    *
	* @param    string $msg a SOAPx4 soapmsg object
	* @param    string $soapaction SOAPAction value
	* @param    integer $timeout set timeout in seconds
	* @return	mixed native PHP types.
	* @access   private
	*/
	function send($msg, $soapaction = '', $timeout=0) {
		// detect transport
		switch(true){
			// http(s)
			case ereg('^http',$this->endpoint):
				$this->debug('transporting via HTTP');
				if($this->persistentConnection && is_object($this->persistentConnection)){
					$http =& $this->persistentConnection;
				} else {
					$http = new soap_transport_http($this->endpoint);
					// pass encoding into transport layer, so appropriate http headers are sent
					$http->soap_defencoding = $this->soap_defencoding;
				}
				$http->setSOAPAction($soapaction);
				if($this->proxyhost && $this->proxyport){
					$http->setProxy($this->proxyhost,$this->proxyport);
				}
                if($this->username != '' && $this->password != '') {
					$http->setCredentials($this->username,$this->password);
				}
				if($this->http_encoding != ''){
					$http->setEncoding($this->http_encoding);
				}
				$this->debug('sending message, length: '.strlen($msg));
				if(ereg('^http:',$this->endpoint)){
				//if(strpos($this->endpoint,'http:')){
					$response = $http->send($msg,$timeout);
				} elseif(ereg('^https',$this->endpoint)){
				//} elseif(strpos($this->endpoint,'https:')){
					//if(phpversion() == '4.3.0-dev'){
						//$response = $http->send($msg,$timeout);
                   		//$this->request = $http->outgoing_payload;
						//$this->response = $http->incoming_payload;
					//} else
					if (extension_loaded('curl')) {
						$response = $http->sendHTTPS($msg,$timeout);
					} else {
						$this->setError('CURL Extension, or OpenSSL extension w/ PHP version >= 4.3 is required for HTTPS');
					}								
				} else {
					$this->setError('no http/s in endpoint url');
				}
				$this->request = $http->outgoing_payload;
				$this->response = $http->incoming_payload;
				$this->debug("transport debug data...\n".$http->debug_str);
				// save transport object if using persistent connections
				if($this->persistentConnection && !is_object($this->persistentConnection)){
					$this->persistentConnection = $http;
				}
				if($err = $http->getError()){
					$this->setError('HTTP Error: '.$err);
					return false;
				} elseif($this->getError()){
					return false;
				} else {
					$this->debug('got response, length: '.strlen($response));
					return $this->parseResponse($response);
				}
			break;
			default:
				$this->setError('no transport found, or selected transport is not yet supported!');
			return false;
			break;
		}
	}

	/**
	* processes SOAP message returned from server
	*
	* @param	string unprocessed response data from server
	* @return	mixed value of the message, decoded into a PHP type
	* @access   private
	*/
    function parseResponse($data) {
		$this->debug('Entering parseResponse(), about to create soap_parser instance');
		$parser = new soap_parser($data,$this->xml_encoding,$this->operation);
		// if parse errors
		if($errstr = $parser->getError()){
			$this->setError( $errstr);
			// destroy the parser object
			unset($parser);
			return false;
		} else {
			// get SOAP headers
			$this->responseHeaders = $parser->getHeaders();
			// get decoded message
			$return = $parser->get_response();
			// add parser debug data to our debug
			$this->debug($parser->debug_str);
            // add document for doclit support
            $this->document = $parser->document;
			// destroy the parser object
			unset($parser);
			// return decode message
			return $return;
		}
	 }

	/**
	* set the SOAP headers
	*
	* @param	$headers string XML
	* @access   public
	*/
	function setHeaders($headers){
		$this->requestHeaders = $headers;
	}

	/**
	* get the response headers
	*
	* @return	mixed object SOAPx4 soapval object or empty if no headers
	* @access   public
	*/
	function getHeaders(){
	    if($this->responseHeaders != '') {
			return $this->responseHeaders;
	    }
	}

	/**
	* set proxy info here
	*
	* @param    string $proxyhost
	* @param    string $proxyport
	* @access   public
	*/
	function setHTTPProxy($proxyhost, $proxyport) {
		$this->proxyhost = $proxyhost;
		$this->proxyport = $proxyport;
	}

	/**
	* if authenticating, set user credentials here
	*
	* @param    string $username
	* @param    string $password
	* @access   public
	*/
	function setCredentials($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}
	
	/**
	* use HTTP encoding
	*
	* @param    string $enc
	* @access   public
	*/
	function setHTTPEncoding($enc='gzip, deflate'){
		$this->http_encoding = $enc;
	}
	
	/**
	* use HTTP persistent connections if possible
	*
	* @access   public
	*/
	function useHTTPPersistentConnection(){
		$this->persistentConnection = true;
	}
	
	/**
	* gets the default RPC parameter setting.
	* If true, default is that call params are like RPC even for document style.
	* Each call() can override this value.
	*
	* @access public
	*/
	function getDefaultRpcParams() {
		return $this->defaultRpcParams;
	}

	/**
	* sets the default RPC parameter setting.
	* If true, default is that call params are like RPC even for document style
	* Each call() can override this value.
	*
	* @param    boolean $rpcParams
	* @access public
	*/
	function setDefaultRpcParams($rpcParams) {
		$this->defaultRpcParams = $rpcParams;
	}
	
	/**
	* dynamically creates proxy class, allowing user to directly call methods from wsdl
	*
	* @return   object soap_proxy object
	* @access   public
	*/
	function getProxy(){
		$evalStr = '';
		foreach($this->operations as $operation => $opData){
			if($operation != ''){
				// create param string
				$paramStr = '';
				if(sizeof($opData['input']['parts']) > 0){
					foreach($opData['input']['parts'] as $name => $type){
						$paramStr .= "\$$name,";
					}
					$paramStr = substr($paramStr,0,strlen($paramStr)-1);
				}
				$opData['namespace'] = !isset($opData['namespace']) ? 'http://testuri.com' : $opData['namespace'];
				$evalStr .= "function $operation ($paramStr){
					// load params into array
					\$params = array($paramStr);
					return \$this->call('$operation',\$params,'".$opData['namespace']."','".$opData['soapAction']."');
				}";
				unset($paramStr);
			}
		}
		$r = rand();
		$evalStr = 'class soap_proxy_'.$r.' extends soapclient {
				'.$evalStr.'
			}';
		//print "proxy class:<pre>$evalStr</pre>";
		// eval the class
		eval($evalStr);
		// instantiate proxy object
		eval("\$proxy = new soap_proxy_$r('');");
		// transfer current wsdl data to the proxy thereby avoiding parsing the wsdl twice
		$proxy->endpointType = 'wsdl';
		$proxy->wsdlFile = $this->wsdlFile;
		$proxy->wsdl = $this->wsdl;
		$proxy->operations = $this->operations;
		$proxy->defaultRpcParams = $this->defaultRpcParams;
		return $proxy;
	}
}

?>