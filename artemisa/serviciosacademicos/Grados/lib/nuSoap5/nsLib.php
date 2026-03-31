<?php

require_once('nusoap.php');

// Netsuite WS API classes

// Base class, we need to always serialize literally because nusoap does not handle our namespaces/types correctly
class nsSoapval extends soapval {

  	function nsSoapval($name='soapval',$type=false,$value=-1,$element_ns=false,$type_ns=false,$attributes=false) {
  		parent::soapval($name,$type,$value,$element_ns,$type_ns,$attributes);
  	}


	// Always encode literally
	function serialize($use='literal')
	{
		return parent::serialize('literal');
	}

}

class nsRecordRef extends nsSoapval {

	/**
	* Ubiquitous RecordRef, used both to indicate a reference on a record, and as input to a "get" type operation.
	*
	* @param	String	$elementName REQUIRED The element level name that this RecordRef represents (eg "role" on login)
	* @param	String	$internalId REQUIRED You always need to know the internalId of the recordRef you are specifying
	* @param	String	$name OPTIONAL Name specified on RecordRef, in general this is a read parameter
	* @param	String	$type OPTIONAL Type specified on RecordRef, eg "customer" or "salesOrder" (see RecordType in core.xsd) use this if you are doing a get. Not needed during adds.
	* @param	String	$elementNamespace OPTIONAL The namespace of the owning element. EG "role" on login is defined in the Core namespace.
	* @access	public
	*/
	function nsRecordRef($elementName, $internalId,$name='',$type='', $elementNamespace='')
	{
		parent::nusoap_base();
		$this->name = $elementName;
		$this->type = 'RecordRef';
		$this->value = $name;
		$this->element_ns = $elementNamespace;

		$rr = array('xsi:type' => 'nsRecordRef:RecordRef', 'xmlns:nsRecordRef' => 'urn:core_2_0.platform.webservices.netsuite.com');
		if ($internalId != '')
			$rr['internalId'] = $internalId;
		if ($type != '')
		    $rr['type'] = $type;

		$this->attributes = $rr;
	}

}

class nsRecord extends nsSoapval {

	/**
	* Record object. You need of these to do writes ("update" and "add" operations)
	*
	* @param	String	$recordType REQUIRED What you are adding/updateing. See RecordType in core.xsd
	* @param	String	$internalId OPTIONAL If adding, required if updating
	* @param	associative_array	$fields REQUIRED This is the array of all your fields, including lists, etc.
	* @access	public
	*/
	function nsRecord($recordType, $internalId='', $fields)
	{
		parent::nusoap_base();
		$ns = lookupNamespace($recordType);
		$this->name = 'record';
		$this->type = 'Record';
		$this->value = array();
		$this->element_ns = '';
		$this->type_ns = $ns;

		$attr = array('xsi:type' => 'nsRecord:' . ucfirst($recordType), 'xmlns:nsRecord' => $ns);
		if ($internalId != '')
			$attr['internalId'] = $internalId;
		$this->attributes = $attr;

		foreach ($fields as $fieldName => $fieldValue)
		{
			$this->debug($fieldName . (is_a($fieldValue, 'soapval') ? (' is a soapval.' . $fieldValue->serialize()) : (' is NOT a soapval : ' . $fieldValue)));
			array_push($this->value, is_a($fieldValue, 'soapval') ? $fieldValue : new nsSoapval($fieldName, '', $fieldValue, $ns ));
		}
	}

}

class nsList extends nsSoapval {

	function nsList($recordType, $listName, $listArray)
	{
		parent::nusoap_base();
		$ns = lookupNamespace(lcfirst($recordType) . ucfirst($listName) . 'List');
		$this->name = lcfirst($listName) . 'List';
		$this->type = ucfirst($listName) . 'List';
		$this->element_ns = $ns;
		$this->attributes = array('replaceAll' => 'false', 'xsi:type' => 'nsList:' . ucfirst($recordType) . ucfirst($listName) . 'List', 'xmlns:nsList' => $ns);

		$nsListArray = array();
		foreach ($listArray as $listEntry)
		{
			$nsListValue = array();
			foreach ($listEntry as $fieldName => $fieldValue)
			{
				array_push($nsListValue, new nsSoapval($fieldName, '', $fieldValue, $ns ));
			}
			array_push($nsListArray, new nsSoapval(lcfirst($listName), '', $nsListValue, $ns));
		}
		$this->value = $nsListArray;

	}
}


class nsEnum extends nsSoapval {

	/**
	* Record object. You need of these to do writes ("update" and "add" operations)
	*
	* @param	String	$enumType REQUIRED eg 'Country', 'SupportCaseStage' or 'AccountType'
	* @param	String	$enumValue REQUIRED The String value, not the '_' for everything but platform types : '_unitedStates', '_open' or '_accountsPayable'.
	* @param	String  $elementName OPTIONAL But you'll probably always want it. This is the name of the Record Element that has the enum as data (eg 'stage' for SupportCaseStage)
	* @param	String  $elementNamespace OPTIONAL But again you'll probably always want it. This is the namepace of the owning
	*						of the Record Element, for supportCase, it would be 'support...' while the ENUM's namespace is 'types.support...'
	* @access	public
	*/
	function nsEnum($enumType, $enumValue, $elementName='', $elementNamespace='')
	{
		parent::nusoap_base();
		$ns = lookupNamespace(ucfirst($enumType));
		$this->name = isset($elementName) ? $elementName : lcfirst($enumType);
		$this->type = ucfirst($enumType);
		$this->value = $enumValue;
		$this->element_ns = $elementNamespace;

		$this->attributes = array('xsi:type' => 'nsEnum:' . ucfirst($enumType), 'xmlns:nsEnum' => $ns);
	}
}

class nsSearchBasic extends nsSoapval {

	function nsSearchBasic($searchType, $searchFields)
	{
		parent::nusoap_base();
		$this->name = 'searchRecord';
		$this->type = 'SearchRecord';

		$this->attributes = array('xsi:type' => 'nsCommon:' . ucfirst($searchType), 'xmlns:nsCommon' => 'urn:common_2_0.platform.webservices.netsuite.com');

		$this->value = $searchFields;
	}
}

class nsSearchField extends nsSoapval {

	function nsSearchField($fieldType, $fieldName,  $operator, $searchValue='', $searchValue2='', $predefinedSearchValue='')
	{
		parent::nusoap_base();
		$nsCore = 'urn:core_2_0.platform.webservices.netsuite.com';
		$this->name = 'nsCommon:' . $fieldName;
		$this->type = '';

		$this->attributes = array('operator' => $operator, 'xsi:type' => 'nsCommon:' . ucfirst($fieldType), 'xmlns:nsCore' => $nsCore);

		$this->value = array(new nsSoapval('nsCore:' . 'searchValue', '', $searchValue));

	}
}





// --- Netsuite API methods ---
function login ($port, $email, $password, $account, $role)
{
	$ns='urn:core_2_0.platform.webservices.netsuite.com';
	$ns1='urn:messages_2_0.platform.webservices.netsuite.com';

	$soapemail = new nsSoapval('email', '',$email, $ns, '');
	$soappassword = new nsSoapval('password', '',$password, $ns, '');
	$soapaccount = new nsSoapval('account', '',$account, $ns, '');
	$soaprole = new nsSoapval('role', '','',$ns,'',array('internalId' => $role));

	$ppt = new nsSoapval('passport', 'Passport', array($soapemail , $soappassword, $soapaccount, $soaprole));
	$login = new nsSoapval('login','LoginRequest', array('login' => $ppt), $ns1);
	$msg = $port->serializeEnvelope($login->serialize('literal'));

	return $port->send($msg,'login');

}

function add ($port, $record)
{
	$ns1='urn:messages_2_0.platform.webservices.netsuite.com';

	$soapRecord = array();
	$add = new nsSoapval('add','AddRequest', array('add' => $record), '', $ns1);
	$addMsg = $port->serializeEnvelope($add->serialize('literal'));

	return $port->send($addMsg, 'add');
}

function get ($port, $recordRef)
{
	$ns1='urn:messages_2_0.platform.webservices.netsuite.com';

	$soapRecord = array();
	$add = new nsSoapval('get','GetRequest', array('get' => $recordRef), '', $ns1);
	$addMsg = $port->serializeEnvelope($add->serialize('literal'));

	return $port->send($addMsg, 'add');
}

function searchBasic($port, $searchRecord, $pageSize=false, $bodyFieldsOnly=true)
{
	$ns1='urn:messages_2_0.platform.webservices.netsuite.com';
	$soapHeader = false;
	if (!$bodyFieldsOnly || $pageSize)
	{
		$soapHeader='<ns1:searchPreferences xmlns:ns1="urn:messages.platform.webservices.netsuite.com">';
		$soapHeader .= '<ns2:bodyFieldsOnly xmlns:ns2="urn:messages_2_0.platform.webservices.netsuite.com">' . ($bodyFieldsOnly ? 'true' : 'false') . '</ns2:bodyFieldsOnly>';
		if ($pageSize)
			$soapHeader .= '<ns3:pageSize xmlns:ns3="urn:messages_2_0.platform.webservices.netsuite.com">' . $pageSize . '</ns3:pageSize>';
	    $soapHeader .= '</ns1:searchPreferences>';
	}

	$search = new nsSoapval('search','SearchRequest', array('search' => $searchRecord), $ns1);
	$msg = $port->serializeEnvelope($search->serialize('literal'), $soapHeader );
	$result = $port->send($msg,'search');
	return $result;
}




// --- Utility Methods ---
function lcfirst($strIn)
{
	return strtolower(substr($strIn,0,1)) . substr($strIn,1);
}

function lookupNamespace($objectName)
{
	$namespaceMap = array(
	'customer' => 'urn:relationships_2_0.lists.webservices.netsuite.com',
	'contact' => 'urn:relationships_2_0.lists.webservices.netsuite.com',
	'contactAddressbookList' => 'urn:relationships_2_0.lists.webservices.netsuite.com',
	'contactAddressbook' => 'urn:relationships_2_0.lists.webservices.netsuite.com',
	'country' => 'urn:types.common_2_0.platform.webservices.netsuite.com'
	);

	return $namespaceMap[lcfirst($objectName)];
}

function in($toCheck, $targetArray)
{
	foreach ($targetArray as $i)
	{
		if ($i == $toCheck)
			return true;
	}
	return false;
}

?>