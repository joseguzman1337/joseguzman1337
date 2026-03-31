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
* @class The purpose of this class is to load content of external files into HTML elements on your page(<a href="../../demos/demo-dynamic-content-1.html" target="_blank">demo</a>).<br>
*	 The pane splitter, window widget and the ajax tooltip script are also using this class to put external content into HTML elements.
* @version		1.0
* @version 1.0
* 
* @author	Alf Magne Kalleland(www.dhtmlgoodies.com)
**/

DHTMLSuite.dynamicContent=function(){
	var enableCache;	
// Cache enabled.
	var jsCache;
	var ajaxObjects;
	var waitMessage;
	
	this.enableCache=true;
	this.jsCache=new Object();
	this.ajaxObjects=new Array();
	this.waitMessage='Loading content-please wait...';
	this.waitImage='dynamic-content/ajax-loader-darkblue.gif';
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

DHTMLSuite.dynamicContent.prototype={

	
// {{{ loadContent()
    /**
    *Load content from external files into an element on your web page.
     *
    *@param String divId=Id of HTML element
    *@param String url=Path to content on the server(Local content only)
    *@param String functionToCallOnLoaded=Function to call when ajax is finished. This string will be evaulated, example of string: "fixContent()" (with the quotes).
    *
    *@public
     */	
	loadContent:function(divId,url,functionToCallOnLoaded)
	{
	
	var ind=this.objectIndex;
	if(this.enableCache&&this.jsCache[url]){
		document.getElementById(divId).innerHTML=this.jsCache[url];
		DHTMLSuite.commonObj.__evaluateJs(divId);
		DHTMLSuite.commonObj.__evaluateCss(divId);	
		if(functionToCallOnLoaded)eval(functionToCallOnLoaded);	
		return;
	}
	var ajaxIndex=0;
	
	/* Generating please wait message */
	var waitMessageToShow='';
	if(this.waitImage){	
// Wait image exists ?
		waitMessageToShow=waitMessageToShow+'<div style="text-align:center;padding:10px"><img src="'+DHTMLSuite.configObj.imagePath+this.waitImage+'" border="0" alt=""></div>';
	}
	if(this.waitMessage){	
// Wait message exists ?
		waitMessageToShow=waitMessageToShow+'<div style="text-align:center">'+this.waitMessage+'</div>';
	}	
	try{
		document.getElementById(divId).innerHTML=waitMessageToShow ;
	}catch(e){		
	}	
	waitMessageToShow=false;
	var ajaxIndex=this.ajaxObjects.length;	
	
	try{
		this.ajaxObjects[ajaxIndex]=new sack();
	}catch(e){
		alert('Could not create ajax object. Please make sure that ajax.js is included');
	}
	
	
	
	if(url.indexOf('?')>=0){	
// Get variables in the url
		this.ajaxObjects[ajaxIndex].method='GET';	
// Change method to get
		var string=url.substring(url.indexOf('?'));	
// Extract get variables
		url=url.replace(string,'');
		string=string.replace('?','');
		var items=string.split(/&/g);
		for(var no=0;no<items.length;no++){
		var tokens=items[no].split('=');
		if(tokens.length==2){
			this.ajaxObjects[ajaxIndex].setVar(tokens[0],tokens[1]);
		}	
		}	
		url=url.replace(string,'');
	}	

	
	
		
	this.ajaxObjects[ajaxIndex].requestFile=url;	
// Specifying which file to get
	this.ajaxObjects[ajaxIndex].onCompletion=function(){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__ajax_showContent(divId,ajaxIndex,url,functionToCallOnLoaded); };	
// Specify function that will be executed after file has been found
	this.ajaxObjects[ajaxIndex].onError=function(){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__ajax_displayError(divId,ajaxIndex,url,functionToCallOnLoaded); };	
// Specify function that will be executed after file has been found
	this.ajaxObjects[ajaxIndex].runAJAX();	
// Execute AJAX function	
	}
	
// }}}	
	,
	
// {{{ setWaitMessage()
    /**
    *Specify which message to show when Ajax is busy.
     *
    *@param String newWaitMessage=New wait message (Default="Loading content-please wait")- use false if you don't want any wait message
    *
    *@public
     */	
	setWaitMessage:function(newWaitMessage)
	{
	this.waitMessage=newWaitMessage;	
	}
	
// }}}
	,
	
// {{{ setWaitImage()
    /**
    *Specify an image to show when Ajax is busy working.
     *
    *@param String newWaitImage=New wait image ( default=ajax-loader-blue.gif-it is by default located inside the image_dhtmlsuite folder.-If you like a new image, try to generate one at http:
//www.ajaxload.info/
    *
    *@public
     */	
	setWaitImage:function(newWaitImage)
	{
	this.waitImage=newWaitImage;
	}
	
// }}}
	,
	
// {{{ setCache()
    /**
    *Cancel selection when drag is in process
     *
    *@param Boolean enableCache=true if you want to enable cache, false otherwise(default is true). You can also send HTMl code in here, example an &lt;img> tag.
    *
    *@public
     */	
	setCache:function(enableCache)
	{
	this.enableCache=enableCache;	
	}
	
// }}}
	,
	
// {{{ __ajax_showContent()
    /**
    *Evaluate Javascript in the inserted content
     *
    *@private
     */	
	__ajax_showContent :function(divId,ajaxIndex,url,functionToCallOnLoaded)
	{
	document.getElementById(divId).innerHTML='';
	document.getElementById(divId).innerHTML=this.ajaxObjects[ajaxIndex].response;
	if(this.enableCache){	
// Cache is enabled
		this.jsCache[url]=document.getElementById(divId).innerHTML+'';	
// Put content into cache
	}	
	DHTMLSuite.commonObj.__evaluateJs(divId);	
// Call private method which evaluates JS content
	DHTMLSuite.commonObj.__evaluateCss(divId);	
// Call private method which evaluates JS content
	if(functionToCallOnLoaded)eval(functionToCallOnLoaded);
	this.ajaxObjects[ajaxIndex]=null;	
// Clear sack object
	return false;
	}
	
// }}}
	,
	
// {{{ __ajax_displayError()
    /**
    *Display error message when the request failed.
     *
    *@private
     */	
	__ajax_displayError:function(divId,ajaxIndex,url,functionToCallOnLoaded)
	{
	document.getElementById(divId).innerHTML='<h2>Message from DHTMLSuite.dynamicContent</h2><p>The ajax request for '+url+' failed</p>';	
	}
	
// }}}	
}
