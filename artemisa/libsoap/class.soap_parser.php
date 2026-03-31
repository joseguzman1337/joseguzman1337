<?php



/**
*
* soap_parser class parses SOAP XML messages into native PHP values
*
* @author   Dietrich Ayala <dietrich@ganx4.com>
* @version  v 0.6.3
* @access   public
*/
class soap_parser extends nusoap_base {

	var $xml = '';
	var $xml_encoding = '';
	var $method = '';
	var $root_struct = '';
	var $root_struct_name = '';
	var $root_header = '';
    var $document = '';
	// determines where in the message we are (envelope,header,body,method)
	var $status = '';
	var $position = 0;
	var $depth = 0;
	var $default_namespace = '';
	var $namespaces = array();
	var $message = array();
    var $parent = '';
	var $fault = false;
	var $fault_code = '';
	var $fault_str = '';
	var $fault_detail = '';
	var $depth_array = array();
	var $debug_flag = true;
	var $soapresponse = NULL;
	var $responseHeaders = '';
	var $body_position = 0;
	// for multiref parsing:
	// array of id => pos
	var $ids = array();
	// array of id => hrefs => pos
	var $multirefs = array();

	/**
	* constructor
	*
	* @param    string $xml SOAP message
	* @param    string $encoding character encoding scheme of message
	* @access   public
	*/
	function soap_parser($xml,$encoding='UTF-8',$method=''){
		$this->xml = $xml;
		$this->xml_encoding = $encoding;
		$this->method = $method;

		// Check whether content has been read.
		if(!empty($xml)){
			$this->debug('Entering soap_parser()');
			// Create an XML parser.
			$this->parser = xml_parser_create($this->xml_encoding);
			// Set the options for parsing the XML data.
			//xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
			xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
			// Set the object for the parser.
			xml_set_object($this->parser, $this);
			// Set the element handlers for the parser.
			xml_set_element_handler($this->parser, 'start_element','end_element');
			xml_set_character_data_handler($this->parser,'character_data');

			// Parse the XML file.
			if(!xml_parse($this->parser,$xml,true)){
			    // Display an error message.
			    $err = sprintf('XML error on line %d: %s',
			    xml_get_current_line_number($this->parser),
			    xml_error_string(xml_get_error_code($this->parser)));
				$this->debug('parse error: '.$err);
				$this->errstr = $err;
			} else {
				$this->debug('parsed successfully, found root struct: '.$this->root_struct.' of name '.$this->root_struct_name);
				// get final value
				$this->soapresponse = $this->message[$this->root_struct]['result'];
				// get header value
				if($this->root_header != '' && isset($this->message[$this->root_header]['result'])){
					$this->responseHeaders = $this->message[$this->root_header]['result'];
				}
				// resolve hrefs/ids
				if(sizeof($this->multirefs) > 0){
					foreach($this->multirefs as $id => $hrefs){
						$this->debug('resolving multirefs for id: '.$id);
						$idVal = $this->buildVal($this->ids[$id]);
						foreach($hrefs as $refPos => $ref){
							$this->debug('resolving href at pos '.$refPos);
							$this->multirefs[$id][$refPos] = $idVal;
						}
					}
				}
			}
			xml_parser_free($this->parser);
		} else {
			$this->debug('xml was empty, didn\'t parse!');
			$this->errstr = 'xml was empty, didn\'t parse!';
		}
	}

	/**
	* start-element handler
	*
	* @param    string $parser XML parser object
	* @param    string $name element name
	* @param    string $attrs associative array of attributes
	* @access   private
	*/
	function start_element($parser, $name, $attrs) {
		// position in a total number of elements, starting from 0
		// update class level pos
		$pos = $this->position++;
		// and set mine
		$this->message[$pos] = array('pos' => $pos,'children'=>'','cdata'=>'');
		// depth = how many levels removed from root?
		// set mine as current global depth and increment global depth value
		$this->message[$pos]['depth'] = $this->depth++;

		// else add self as child to whoever the current parent is
		if($pos != 0){
			$this->message[$this->parent]['children'] .= '|'.$pos;
		}
		// set my parent
		$this->message[$pos]['parent'] = $this->parent;
		// set self as current parent
		$this->parent = $pos;
		// set self as current value for this depth
		$this->depth_array[$this->depth] = $pos;
		// get element prefix
		if(strpos($name,':')){
			// get ns prefix
			$prefix = substr($name,0,strpos($name,':'));
			// get unqualified name
			$name = substr(strstr($name,':'),1);
		}
		// set status
		if($name == 'Envelope'){
			$this->status = 'envelope';
		} elseif($name == 'Header'){
			$this->root_header = $pos;
			$this->status = 'header';
		} elseif($name == 'Body'){
			$this->status = 'body';
			$this->body_position = $pos;
		// set method
		} elseif($this->status == 'body' && $pos == ($this->body_position+1)){
			$this->status = 'method';
			$this->root_struct_name = $name;
			$this->root_struct = $pos;
			$this->message[$pos]['type'] = 'struct';
			$this->debug("found root struct $this->root_struct_name, pos $this->root_struct");
		}
		// set my status
		$this->message[$pos]['status'] = $this->status;
		// set name
		$this->message[$pos]['name'] = htmlspecialchars($name);
		// set attrs
		$this->message[$pos]['attrs'] = $attrs;

		// loop through atts, logging ns and type declarations
        $attstr = '';
		foreach($attrs as $key => $value){
        	$key_prefix = $this->getPrefix($key);
			$key_localpart = $this->getLocalPart($key);
			// if ns declarations, add to class level array of valid namespaces
            if($key_prefix == 'xmlns'){
				if(ereg('^http://www.w3.org/[0-9]{4}/XMLSchema$',$value)){
					$this->XMLSchemaVersion = $value;
					$this->namespaces['xsd'] = $this->XMLSchemaVersion;
					$this->namespaces['xsi'] = $this->XMLSchemaVersion.'-instance';
				}
                $this->namespaces[$key_localpart] = $value;
				// set method namespace
				if($name == $this->root_struct_name){
					$this->methodNamespace = $value;
				}
			// if it's a type declaration, set type
            } elseif($key_localpart == 'type'){
            	$value_prefix = $this->getPrefix($value);
                $value_localpart = $this->getLocalPart($value);
				$this->message[$pos]['type'] = $value_localpart;
				$this->message[$pos]['typePrefix'] = $value_prefix;
                if(isset($this->namespaces[$value_prefix])){
                	$this->message[$pos]['type_namespace'] = $this->namespaces[$value_prefix];
                } else if(isset($attrs['xmlns:'.$value_prefix])) {
					$this->message[$pos]['type_namespace'] = $attrs['xmlns:'.$value_prefix];
                }
				// should do something here with the namespace of specified type?
			} elseif($key_localpart == 'arrayType'){
				$this->message[$pos]['type'] = 'array';
				/* do arrayType ereg here
				[1]    arrayTypeValue    ::=    atype asize
				[2]    atype    ::=    QName rank*
				[3]    rank    ::=    '[' (',')* ']'
				[4]    asize    ::=    '[' length~ ']'
				[5]    length    ::=    nextDimension* Digit+
				[6]    nextDimension    ::=    Digit+ ','
				*/
				$expr = '([A-Za-z0-9_]+):([A-Za-z]+[A-Za-z0-9_]+)\[([0-9]+),?([0-9]*)\]';
				if(ereg($expr,$value,$regs)){
					$this->message[$pos]['typePrefix'] = $regs[1];
					$this->message[$pos]['arraySize'] = $regs[3];
					$this->message[$pos]['arrayCols'] = $regs[4];
				}
			}
			// log id
			if($key == 'id'){
				$this->ids[$value] = $pos;
			}
			// root
			if($key_localpart == 'root' && $value == 1){
				$this->status = 'method';
				$this->root_struct_name = $name;
				$this->root_struct = $pos;
				$this->debug("found root struct $this->root_struct_name, pos $pos");
			}
            // for doclit
            $attstr .= " $key=\"$value\"";
		}
        // get namespace - must be done after namespace atts are processed
		if(isset($prefix)){
			$this->message[$pos]['namespace'] = $this->namespaces[$prefix];
			$this->default_namespace = $this->namespaces[$prefix];
		} else {
			$this->message[$pos]['namespace'] = $this->default_namespace;
		}
        if($this->status == 'header'){
        	$this->responseHeaders .= "<$name$attstr>";
        } elseif($this->root_struct_name != ''){
        	$this->document .= "<$name$attstr>";
        }
	}

	/**
	* end-element handler
	*
	* @param    string $parser XML parser object
	* @param    string $name element name
	* @access   private
	*/
	function end_element($parser, $name) {
		// position of current element is equal to the last value left in depth_array for my depth
		$pos = $this->depth_array[$this->depth--];

        // get element prefix
		if(strpos($name,':')){
			// get ns prefix
			$prefix = substr($name,0,strpos($name,':'));
			// get unqualified name
			$name = substr(strstr($name,':'),1);
		}

		// build to native type
		if(isset($this->body_position) && $pos > $this->body_position){
			// deal w/ multirefs
			if(isset($this->message[$pos]['attrs']['href'])){
				// get id
				$id = substr($this->message[$pos]['attrs']['href'],1);
				// add placeholder to href array
				$this->multirefs[$id][$pos] = "placeholder";
				// add set a reference to it as the result value
				$this->message[$pos]['result'] =& $this->multirefs[$id][$pos];
            // build complex values
			} elseif($this->message[$pos]['children'] != ""){
				$this->message[$pos]['result'] = $this->buildVal($pos);
			} else {
            	$this->debug('adding data for scalar value '.$this->message[$pos]['name'].' of value '.$this->message[$pos]['cdata']);
				if(is_numeric($this->message[$pos]['cdata']) ){
                	if( strpos($this->message[$pos]['cdata'],'.') ){
                		$this->message[$pos]['result'] = doubleval($this->message[$pos]['cdata']);
                    } else {
                    	$this->message[$pos]['result'] = intval($this->message[$pos]['cdata']);
                    }
                } else {
                	$this->message[$pos]['result'] = $this->message[$pos]['cdata'];
                }
			}
		}

		// switch status
		if($pos == $this->root_struct){
			$this->status = 'body';
		} elseif($name == 'Body'){
			$this->status = 'header';
		 } elseif($name == 'Header'){
			$this->status = 'envelope';
		} elseif($name == 'Envelope'){
			//
		}
		// set parent back to my parent
		$this->parent = $this->message[$pos]['parent'];
        // for doclit
        if($this->status == 'header'){
        	$this->responseHeaders .= "</$name>";
        } elseif($pos >= $this->root_struct){
        	$this->document .= "</$name>";
        }
	}

	/**
	* element content handler
	*
	* @param    string $parser XML parser object
	* @param    string $data element content
	* @access   private
	*/
	function character_data($parser, $data){
		$pos = $this->depth_array[$this->depth];
		if ($this->xml_encoding=='UTF-8'){
			$data = utf8_decode($data);
		}
        $this->message[$pos]['cdata'] .= $data;
        // for doclit
        if($this->status == 'header'){
        	$this->responseHeaders .= $data;
        } else {
        	$this->document .= $data;
        }
	}

	/**
	* get the parsed message
	*
	* @return	mixed
	* @access   public
	*/
	function get_response(){
		return $this->soapresponse;
	}

	/**
	* get the parsed headers
	*
	* @return	string XML or empty if no headers
	* @access   public
	*/
	function getHeaders(){
	    return $this->responseHeaders;
	}

	/**
	* decodes entities
	*
	* @param    string $text string to translate
	* @access   private
	*/
	function decode_entities($text){
		foreach($this->entities as $entity => $encoded){
			$text = str_replace($encoded,$entity,$text);
		}
		return $text;
	}

	/**
	* builds response structures for compound values (arrays/structs)
	*
	* @param    string $pos position in node tree
	* @access   private
	*/
	function buildVal($pos){
		if(!isset($this->message[$pos]['type'])){
			$this->message[$pos]['type'] = '';
		}
		$this->debug('inside buildVal() for '.$this->message[$pos]['name']."(pos $pos) of type ".$this->message[$pos]['type']);
		// if there are children...
		if($this->message[$pos]['children'] != ''){
			$children = explode('|',$this->message[$pos]['children']);
			array_shift($children); // knock off empty
			// md array
			if(isset($this->message[$pos]['arrayCols']) && $this->message[$pos]['arrayCols'] != ''){
            	$r=0; // rowcount
            	$c=0; // colcount
            	foreach($children as $child_pos){
					$this->debug("got an MD array element: $r, $c");
					$params[$r][] = $this->message[$child_pos]['result'];
				    $c++;
				    if($c == $this->message[$pos]['arrayCols']){
				    	$c = 0;
						$r++;
				    }
                }
            // array
			} elseif($this->message[$pos]['type'] == 'array' || $this->message[$pos]['type'] == 'Array'){
                $this->debug('adding array '.$this->message[$pos]['name']);
                foreach($children as $child_pos){
                	$params[] = &$this->message[$child_pos]['result'];
                }
            // apache Map type: java hashtable
            } elseif($this->message[$pos]['type'] == 'Map' && $this->message[$pos]['type_namespace'] == 'http://xml.apache.org/xml-soap'){
                foreach($children as $child_pos){
                	$kv = explode("|",$this->message[$child_pos]['children']);
                   	$params[$this->message[$kv[1]]['result']] = &$this->message[$kv[2]]['result'];
                }
            // generic compound type
            //} elseif($this->message[$pos]['type'] == 'SOAPStruct' || $this->message[$pos]['type'] == 'struct') {
            } else {
            	// is array or struct? better way to do this probably
            	foreach($children as $child_pos){
            		if(isset($keys) && isset($keys[$this->message[$child_pos]['name']])){
            			$struct = 1;
            			break;
            		}
            		$keys[$this->message[$child_pos]['name']] = 1;
            	}
            	//
            	foreach($children as $child_pos){
            		if(isset($struct)){
            			$params[] = &$this->message[$child_pos]['result'];
            		} else {
				    	$params[$this->message[$child_pos]['name']] = &$this->message[$child_pos]['result'];
                	}
                }
			}
			return is_array($params) ? $params : array();
		} else {
        	$this->debug('no children');
            if(strpos($this->message[$pos]['cdata'],'&')){
		    	return  strtr($this->message[$pos]['cdata'],array_flip($this->entities));
            } else {
            	return $this->message[$pos]['cdata'];
            }
		}
	}
}



?>