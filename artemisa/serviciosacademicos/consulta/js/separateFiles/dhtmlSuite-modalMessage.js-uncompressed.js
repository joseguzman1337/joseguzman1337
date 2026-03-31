if(!window.DHTMLSuite)var DHTMLSuite=new Object();/************************************************************************************************************
*	DHTML modal dialog box
*
*	Created:			August, 26th, 2006
*	@class Purpose of class:	Display a modal dialog box on the screen.
*		
*	Css files used by this script:	modal-message.css
*
*	Demos of this class:		demo-modal-message-1.html
*
* 	Update log:
*
************************************************************************************************************/


/**
* @constructor
* @class Purpose of class:	Display a modal DHTML message on the page. All other page controls will be disabled until the message is closed(<a href="../../demos/demo-modal-message-1.html" target="_blank">demo</a>).
* @param Array-Associative array of properties. These properties can also be set by calling invidiual set-methods. Possible keys in this array:<br>
*	url-Url to file displayed in the message
*	htmlOfModalMessage-Static HTML to display.
*   domRef-Reference to dom element. This dom element will be cloned and displayed inside the message box. You will typically set display:none or visibility:hidden on this element
*	width-Width of box
*	height-Height of box
*	cssClassOfMessageBox-Alternative css class for the message box
*	shadowOffset-Size of drop shadow in pixels
*   shadowDivVisible-Shadow visible (default=true)
*	isModal	- Is the dialog modal?(default=true)
*
* @version 1.0
* @author	Alf Magne Kalleland(www.dhtmlgoodies.com)
*/

DHTMLSuite.modalMessage=function(props)
{
	var url;				
// url of modal message
	var htmlOfModalMessage;			
// html of modal message
	var domRef;				
// Reference to DOM element
	
	var divs_transparentDiv;		
// Transparent div covering page content
	var divs_content;			
// Modal message div.
	var iframeEl;			
// Iframe element used to cover select boxes in ie
	var layoutCss;				
// Name of css file;
	var width;				
// Width of message box
	var height;				
// Height of message box
	var isModal;				
// Is the modal message modal ?
	
	var existingBodyOverFlowStyle;		
// Existing body overflow css
	var dynContentObj;			
// Reference to dynamic content object
	var cssClassOfMessageBox;		
// Alternative css class of message box-in case you want a different appearance on one of them
	var shadowDivVisible;			
// Shadow div visible?
	var shadowOffset; 			
// X and Y offset of shadow(pixels from content box)
	
	var objectIndex;
	
	
	this.url='';				
// Default url is blank
	this.htmlOfModalMessage='';		
// Default message is blank
	this.layoutCss='modal-message.css';	
// Default CSS file
	this.height=200;			
// Default height of modal message
	this.width=400;			
// Default width of modal message
	this.cssClassOfMessageBox=false;	
// Default alternative css class for the message box
	this.shadowDivVisible=true;		
// Shadow div is visible by default
	this.shadowOffset=5;			
// Default shadow offset.
	this.isModal=true;
	
	try{
	if(!standardObjectsCreated)DHTMLSuite.createStandardObjects();	
// This line starts all the init methods
	}catch(e){
	alert('You need to include the dhtmlSuite-common.js file');
	}

	this.objectIndex=DHTMLSuite.variableStorage.arrayDSObjects.length;
	DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex]=this;
	var ind=this.objectIndex;
	
	DHTMLSuite.commonObj.addEvent(window,"resize",function(){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__resizeTransparentDiv(); });	
	
	if(props)this.__setInitialProps(props);
}

DHTMLSuite.modalMessage.prototype={
	
// {{{ __setInitialProps
    /**
     *	Save properties sent to the constructor.
    *	
    *@private	
     */	
	__setInitialProps:function(props)
	{
	if(props.url)this.setSource(props.url);
	if(props.htmlOfModalMessage)this.setHtmlContent(props.htmlOfModalMessage);
	if(props.domRef)this.setDomReference(props.domRef);
	if(props.width)this.width=props.width;
	if(props.height)this.height=props.height;
	if(props.cssClassOfMessageBox)this.cssClassOfMessageBox=props.cssClassOfMessageBox;
	if(props.shadowOffset)this.shadowOffset=props.shadowOffset;
	if(props.shadowDivVisible)this.shadowDivVisible=props.shadowDivVisible;
	if(props.isModal||props.isModal===false||props.isModal===0)this.isModal=props.isModal;
	if(props.waitMessage)this.setWaitMessage(waitMessage);	
	}
	
// }}}
	,
	
// {{{ setIsModal(urlOfSource)
    /**
     *	Specify if the box should be modal, i.e. a transparent div behind the box covering page content.
    *	
    *@public	
     */	
	setIsModal:function(isModal)
	{
	this.isModal=isModal;
	}	
	
// }}}
	,
	
// {{{ setSource(urlOfSource)
    /**
     *	Set source of the modal dialog box
    *	
     *
    *@public	
     */	
	setSource:function(urlOfSource)
	{
	if(urlOfSource)this.__clearProperties();
	this.url=urlOfSource;	
	}	
	
// }}}	
	,
	
// {{{ setHtmlContent(newHtmlContent)
    /**
     *	Setting static HTML content for the modal dialog box.
    *	
     *	@param String newHtmlContent=Static HTML content of box
     *
    *@public	
     */	
	setHtmlContent:function(newHtmlContent)
	{
	if(newHtmlContent)this.__clearProperties();
	this.htmlOfModalMessage=newHtmlContent;	
	}
	
// }}}
	,
	
// {{{ setDomReference
    /**
     *	Specify reference to DOM element which will be displayed inside the modal message box.
    *	
     *	@param Object domRef=Dom reference
     *
    *@public	
     */	
	setDomReference:function(domRef)
	{
	if(domRef)this.__clearProperties();
	if(domRef)domRef=DHTMLSuite.commonObj.getEl(domRef);
	if(domRef){
		domRef=domRef.cloneNode(true);
	}
	this.domRef=domRef;		
	}
	
// }}}	
	,
	
// {{{ setSize
    /**
     *	Set the size of the modal dialog box
    *	
     *	@param int width=width of box
     *	@param int height=height of box
     *
    *@public	
     */	
	setSize:function(width,height)
	{
	if(width)this.width=width;
	if(height)this.height=height;	
	}
	
// }}}	
	,	
	
// {{{ setCssClassMessageBox(newCssClass)
    /**
     *	Assign the message box to a new css class.(in case you wants a different appearance on one of them)
    *	
     *	@param String newCssClass=Name of new css class (Pass false if you want to change back to default)
     *
    *@public	
     */	
	setCssClassMessageBox:function(newCssClass)
	{
	this.cssClassOfMessageBox=newCssClass;
	if(this.divs_content){
		if(this.cssClassOfMessageBox)
		this.divs_content.className=this.cssClassOfMessageBox;
		else
		this.divs_content.className='modalDialog_contentDiv';	
	}
			
	}
	
// }}}	
	,	
	
// {{{ setShadowOffset(newShadowOffset)
    /**
     *	Specify the size of shadow
    *	
     *	@param Int newShadowOffset=Offset of shadow div(in pixels from message box-x and y)
     *
    *@public	
     */	
	setShadowOffset:function(newShadowOffset)
	{
	this.shadowOffset=newShadowOffset
			
	}
	
// }}}	
	,	
	
// {{{ setWaitMessage(newMessage)
    /**
     *	Set a wait message when Ajax is busy inserting content
    *	
     *	@param String newMessage=New wait message
     *
    *@public	
     */	
	setWaitMessage:function(newMessage)
	{
	if(!this.dynContentObj){
		try{
		this.dynContentObj=new DHTMLSuite.dynamicContent();	
// Creating dynamic content object if it doesn't already exist.
		}catch(e){
		alert('You need to include dhtmlSuite-dynamicContent.js');
		}
	}	
	this.dynContentObj.setWaitMessage(newMessage);	
// Calling the DHTMLSuite.dynamicContent setWaitMessage
	}
	
// }}}	
	,	
	
// {{{ setWaitImage(newImage)
    /**
     *	Set a wait Image when Ajax is busy inserting content
    *	
     *	@param String newImage=New wait Image
     *
    *@public	
     */	
	setWaitImage:function(newImage)
	{
	if(!this.dynContentObj){
		try{
		this.dynContentObj=new DHTMLSuite.dynamicContent();	
// Creating dynamic content object if it doesn't already exist.
		}catch(e){
		alert('You need to include dhtmlSuite-dynamicContent.js');
		}
	}	
	this.dynContentObj.setWaitImage(newImage);	
// Calling the DHTMLSuite.dynamicContent setWaitImage
	}
	
// }}}	
	,	
	
// {{{ setCache()
    /**
     *	Enable or disable cache for the ajax object
    *	
     *	@param Boolean cacheStatus=false=off, true=on
     *
    *@public	
     */	
	setCache:function(cacheStatus)
	{
	if(!this.dynContentObj){
		try{
		this.dynContentObj=new DHTMLSuite.dynamicContent();	
// Creating dynamic content object if it doesn't already exist.
		}catch(e){
		alert('You need to include dhtmlSuite-dynamicContent.js');		
		}
	}	
	this.dynContentObj.setCache(cacheStatus);	
// Calling the DHTMLSuite_dynamicContent setCache
	
	}
	
// }}}	
	,
	
// {{{ display()
    /**
     *	Display the modal dialog box
    *	
     *
    *@public	
     */	
	display:function()
	{
	var ind=this.objectIndex;
	
	if(!this.divs_transparentDiv){
		DHTMLSuite.commonObj.loadCSS(this.layoutCss);
		this.__createDivElements();
	}
	this.__resizeAndPositionDivElements();
	
// Redisplaying divs
	if(this.isModal){
		this.divs_transparentDiv.style.display='block';
	}else{
		this.divs_transparentDiv.style.display='none';
	}
	this.divs_content.style.display='block';
	this.divs_shadow.style.display='block';	
	
		
	if(this.iframeEl){
		setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].iframeEl.style.display="block"',150);
	}


			
	this.__resizeAndPositionDivElements();
	
	/* Call the __resizeAndPositionDivElements method twice in case the css file has changed. The first execution of this method may not catch these changes */
	window.refToThisModalBoxObj=this;	
	setTimeout('window.refToThisModalBoxObj.__resizeAndPositionDivElements()',100);
	
	this.__addHTMLContent();	
// Calling method which inserts content into the message div.
	}
	
// }}}	
	,
	
// {{{ ()
    /**
     *	Display the modal dialog box
    *	
     *
    *@public	
     */	
	setShadowDivVisible:function(visible)
	{
	this.shadowDivVisible=visible;
	}
	
// }}}	
	,
	
// {{{ close()
    /**
     *	Close the modal dialog box
    *	
     *
    *@public	
     */	
	close:function()
	{
	document.documentElement.style.overflow='';	
// Setting the CSS overflow attribute of the <html> tag back to default.
	/* Hiding divs */
	this.divs_transparentDiv.style.display='none';
	this.divs_content.style.display='none';
	this.divs_shadow.style.display='none';
	if(this.iframeEl)this.iframeEl.style.display='none';
	
	}
	
// }}}
	,
	
// {{{ __clearProperties()
    /**
     *	Clear content properties
    *	
     *
    *@private	
     */	
	__clearProperties:function()
	{
	if(this.domRef)DHTMLSuite.discardElement(this.domRef);
	this.domRef=null;
	this.url=false;
	this.htmlOfModalMessage=false;
	}
	
// }}}	
	,
	
// {{{ __createDivElements()
    /**
     *	Create the divs for the modal dialog box
    *	
     *
    *@private	
     */	
	__createDivElements:function()
	{
	
// Creating transparent div
	this.divs_transparentDiv=document.createElement('DIV');
	this.divs_transparentDiv.className='DHTMLSuite_modalDialog_transparentDivs';
	this.divs_transparentDiv.style.left='0px';
	this.divs_transparentDiv.style.top='0px';
	this.divs_transparentDiv.id='transparentDiv';
	document.body.appendChild(this.divs_transparentDiv);
	
// Creating content div
	if(!document.getElementById('DHTMLSuite_modalBox_contentDiv')){
		this.divs_content=document.createElement('DIV');
		this.divs_content.className='DHTMLSuite_modalDialog_contentDiv';
		this.divs_content.id='DHTMLSuite_modalBox_contentDiv';
		document.body.appendChild(this.divs_content);
	}else{
		this.divs_content=document.getElementById('DHTMLSuite_modalBox_contentDiv');
	}
	
// Creating shadow div
	this.divs_shadow=document.createElement('DIV');
	this.divs_shadow.className='DHTMLSuite_modalDialog_contentDiv_shadow';
	document.body.appendChild(this.divs_shadow);

	
	
	if(DHTMLSuite.clientInfoObj.isMSIE){
		this.iframeEl=document.createElement('<iframe frameborder=0 src="about:blank" scrolling="no">');
		this.iframeEl.style.filter='alpha(opacity=0)';
		this.iframeEl.style.cssText='filter:alpha(opacity=0)';
		this.iframeEl.style.position='absolute';
		this.iframeEl.style.zIndex=100001;
		this.iframeEl.style.display='none';
		this.iframeEl.style.left='0px';
		this.iframeEl.style.top='0px';
		document.body.appendChild(this.iframeEl);
	}
	}
	
// }}}	
	,
	
// {{{ __resizeAndPositionDivElements()
    /**
     *	Resize the message divs
    *	
     *
    *@private	
     */	
    __resizeAndPositionDivElements:function()
    {
    	var topOffset=Math.max(document.body.scrollTop,document.documentElement.scrollTop);
	if(this.cssClassOfMessageBox)
		this.divs_content.className=this.cssClassOfMessageBox;
	else
		this.divs_content.className='DHTMLSuite_modalDialog_contentDiv';	
    	if(!this.divs_transparentDiv)return;
    	
    	var bodyWidth=DHTMLSuite.clientInfoObj.getBrowserWidth();
    	var bodyHeight=DHTMLSuite.clientInfoObj.getBrowserHeight();
    	
// Setting width and height of content div
      	this.divs_content.style.width=this.width+'px';
    	this.divs_content.style.height= this.height+'px';  	
    	
    	
// Creating temporary width variables since the actual width of the content div could be larger than this.width and this.height(i.e. padding and border)
    	var tmpWidth=this.divs_content.offsetWidth;	
    	var tmpHeight=this.divs_content.offsetHeight;
    	
	
    	this.divs_content.style.left=Math.ceil((bodyWidth-tmpWidth)/ 2)+'px';;
    	this.divs_content.style.top=(Math.ceil((bodyHeight-tmpHeight)/ 2)+ topOffset)+'px';
    	this.divs_shadow.style.left=(this.divs_content.style.left.replace('px','')/1+this.shadowOffset)+'px';
    	this.divs_shadow.style.top=(this.divs_content.style.top.replace('px','')/1+this.shadowOffset)+'px';
    	this.divs_shadow.style.height=tmpHeight+'px';
    	this.divs_shadow.style.width=tmpWidth+'px';



		
    	if(!this.shadowDivVisible)this.divs_shadow.style.display='none';	
// Hiding shadow if it has been disabled
    	this.__resizeTransparentDiv();
    	
    }	
    
// }}}
    ,
   	
// {{{ __resizeTransparentDiv()
    /**
     *	Resize transparent div
    *	
     *
    *@private	
     */	 
    __resizeTransparentDiv:function()
    {
    	if(!this.divs_transparentDiv)return;
    	var divHeight=DHTMLSuite.clientInfoObj.getBrowserHeight();
    	var divWidth=DHTMLSuite.clientInfoObj.getBrowserWidth();
    	this.divs_transparentDiv.style.height=divHeight +'px';   
    	this.divs_transparentDiv.style.width=divWidth+'px';
    	   	
	if(this.iframeEl){
		this.iframeEl.style.width=this.divs_transparentDiv.style.width;
		this.iframeEl.style.height=this.divs_transparentDiv.style.height;
	}
	    	
    	
    }
	
// }}}	
	,
	
// {{{ __addHTMLContent()
    /**
     *	Insert content into the content div
    *	
     *
    *@private	
     */	
    __addHTMLContent:function()
    {
	if(!this.dynContentObj){
// dynamic content object doesn't exists?
		try{
		this.dynContentObj=new DHTMLSuite.dynamicContent();	
// Create new DHTMLSuite_dynamicContent object.
		}catch(e){
		alert('You need to include dhtmlSuite-dynamicContent.js');
		}
	}
	if(this.url){	
// url specified-load content dynamically
		this.dynContentObj.loadContent('DHTMLSuite_modalBox_contentDiv',this.url);
	}
	if(this.htmlOfModalMessage){	
// no url set, put static content inside the message box
		this.divs_content.innerHTML=this.htmlOfModalMessage;	
		
	}
	
	if(this.domRef){
		this.divs_content.innerHTML ='';
		this.divs_content.appendChild(this.domRef);	
		var dis=DHTMLSuite.commonObj.getStyle(this.domRef,'display');
		if(dis=='none')this.domRef.style.display='block';
		this.domRef.style.visibility='visible';		
	}
    }	
}
