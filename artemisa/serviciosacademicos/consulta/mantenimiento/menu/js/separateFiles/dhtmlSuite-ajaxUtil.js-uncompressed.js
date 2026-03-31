if(!window.DHTMLSuite)var DHTMLSuite=new Object();/************************************************************************************************************
*	Ajax dynamic content script
*
*	Created:			August, 23rd, 2006
*
*		
* 	Update log:
*
************************************************************************************************************/

/**
* @constructor
* @class The purpose of this class is to load content of external files into HTML elements on your page(<a href="../../demos/demo-dynamic-content-1.html" target="_blank">demo</a>).
* @version		1.0
* @version 1.0
* 
* @author	Alf Magne Kalleland(www.dhtmlgoodies.com)
**/

DHTMLSuite.ajaxUtil=function(){
	var ajaxObjects;
	this.ajaxObjects=new Array();	
	try{
	if(!standardObjectsCreated)DHTMLSuite.createStandardObjects();	
// This line starts all the init methods
	}catch(e){
	alert('You need to include the dhtmlSuite-common.js file');
	}
	var objectIndex;	
	this.objectIndex=DHTMLSuite.variableStorage.arrayDSObjects.length;
	DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex]=this;
	
}

DHTMLSuite.ajaxUtil.prototype={	
	
// {{{ sendRequest()
    /**
    *Sends an ajax request to the server
     *
    *@param String url=Path on the server
    *@param String paramString-Parameters,  Example: "varA=2&varB=3";
    *@param String functionNameOnComplete=Function to execute on complete, example: "myFunction". The ajax object will be sent to this function and you can get the response from the "reponse" attribute.
     *			NB! This ajax object will be cleared automatically by the script after a 3 second delay.
    *
    *@public
     */	
	sendRequest:function(url,paramString,functionNameOnComplete)
	{
	var ind=this.objectIndex;
	var ajaxIndex=this.ajaxObjects.length;
	try{
		this.ajaxObjects[ajaxIndex]=new sack();
	}catch(e){
		alert('Could not create ajax object. Please make sure that ajax.js is included');
	}
	if(paramString){		
		var params=this.__getArrayByParamString(paramString);	
		for(var no=0;no<params.length;no++){
		this.ajaxObjects[ajaxIndex].setVar(params[no].key,params[no].value);		
		}	
	}
	this.ajaxObjects[ajaxIndex].requestFile=url;	
// Specifying which file to get
	this.ajaxObjects[ajaxIndex].onCompletion=function(){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__onComplete(ajaxIndex,functionNameOnComplete); };	
// Specify function that will be executed after file has been found
	this.ajaxObjects[ajaxIndex].onError=function(){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__onError(ajaxIndex,url); };	
// Specify function that will be executed after file has been found
	this.ajaxObjects[ajaxIndex].runAJAX();	
// Execute AJAX function	
	}
	
// }}}
	,
	
// {{{ __getArrayByParamString()
    /**
    *Sends an ajax request to the server
     *
    *@param String paramString-Parameters,  Example: "varA=2&varB=3";
    *@return Array of key+value
    *
    *@private
     */	
	__getArrayByParamString:function(paramString)
	{
	var retArray=new Array();
	var items=paramString.split(/&/g);
	for(var no=0;no<items.length;no++){
		var tokens=items[no].split(/=/);
		var index=retArray.length;
		retArray[index]={ key:tokens[0],value:tokens[1] }
	}
	return retArray;
	}
	
// }}}
	,
	
// {{{ __onError()
    /**
    *On error event
     *
    *@param Integer ajaxIndex-Index of ajax object
    *@return String url-failing url
    *
    *@private
     */	
	__onError:function(ajaxIndex,url)
	{
	alert('Could not send Ajax request to '+url);
	}
	
// }}}
	,
	
// {{{ __onComplete()
    /**
    *On complete event
     *
    *@param Integer ajaxIndex-Index of ajax object
    *@return String functionNameOnComplete-function to execute
    *
    *@private
     */	
	__onComplete:function(ajaxIndex,functionNameOnComplete)
	{
	var ind=this.objectIndex;	
	if(functionNameOnComplete){		
		eval(functionNameOnComplete+'(DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].ajaxObjects['+ajaxIndex+'])');
	}	
	
	setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__deleteAjaxObject('+ajaxIndex+')',3000);
	}
	
// }}}
	,
	
// {{{ __deleteAjaxObject()
    /**
    *Remove ajax object from memory
     *
    *@param Integer ajaxIndex-Index of ajax object
    *
    *@private
     */
	__deleteAjaxObject:function(ajaxIndex)
	{
	this.ajaxObjects[ajaxIndex]=false;	
	}
}

// Creating global variable of this class
DHTMLSuite.ajax=new DHTMLSuite.ajaxUtil();
