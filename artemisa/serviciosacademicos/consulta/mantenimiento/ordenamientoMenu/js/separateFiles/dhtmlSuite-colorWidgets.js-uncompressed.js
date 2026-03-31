if(!window.DHTMLSuite)var DHTMLSuite=new Object();/************************************************************************************************************
*	DHTML window scripts
*
*	Created:			January, 27th, 2006
*	@class Purpose of class:	Color palette
*		
*	Css files used by this script:	
*
*	Demos of this class:		demo-color-window-1.html
*
* 	Update log:
*
************************************************************************************************************/
/**
* @constructor
* @class 	This class simply creates a color palette
* @version 1.0
* @param colorProperties-associative array of palette properties, possible keys: width, callbackOnColorClick
* @author	Alf Magne Kalleland(www.dhtmlgoodies.com)
*
*	css file used for this widget: color-widget.css
*	Demo: (<a href="../../demos/demo-color-window-1.html" target="_blank">demo 1</a>)
**/

DHTMLSuite.colorPalette=function(propertyArray)
{
	var divElement;
	var layoutCSS;
	var colors;
	var colorHelper;
	var width;
	var callbackOnColorClick;
	var objectIndex;
	var currentColor;
	
	try{
	this.colorHelper=new DHTMLSuite.colorUtil();
	}catch(e){
	alert('You need to include dhtmlSuite-colorUtil.js');
	}
	this.layoutCSS='color-palette.css';
	this.colors=new Array();
	this.currentColor=new Object();
	
	if(propertyArray)this.__setInitProps(propertyArray);
	
	try{
	if(!standardObjectsCreated)DHTMLSuite.createStandardObjects();	
// This line starts all the init methods
	}catch(e){
	alert('You need to include the dhtmlSuite-common.js file');
	}	
	this.objectIndex=DHTMLSuite.variableStorage.arrayDSObjects.length;
	DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex]=this;
}

DHTMLSuite.colorPalette.prototype=
{
	
// {{{ setCallbackOnColorClick()
    /**
    *Specify callback function executed when user clicks on a color. A callback function cal also be specified in the constructor.
     *	
    *@public	
     */	
	setCallbackOnColorClick:function(functionName)
	{
	this.callbackOnColorClick=functionName;
	}
	
// }}}
	,	
	
// {{{ __setInitProps()
    /**
    *Save initial palette properties sent to the constructor
     *	
    *@private	
     */	
	__setInitProps:function(propertyArray)
	{
	if(propertyArray.width){
		propertyArray.width=propertyArray.width+'';
		if(propertyArray.width.match(/^[^0-9]*?$/)){
		propertyArray.width=propertyArray.width+'px';
		}
		this.width=propertyArray.width;
	}
	if(propertyArray.callbackOnColorClick)this.callbackOnColorClick=propertyArray.callbackOnColorClick;
	}
	
// }}}
	,	
	
// {{{ addAllWebColors()
    /**
    *Add all 216 web colors to the palette.
     *	
    *@public	
     */	
	addAllWebColors:function()
	{
	var colors=this.colorHelper.getAllWebColors();
	for(var no=0;no<colors.length;no++){
		this.colors[this.colors.length]=['#'+colors[no],'#'+colors[no]];
		
	}
	
	}
	
// }}}
	,
	
// {{{ addAllNamedColors()
    /**
    *Add all named colors to the palette
     *	
    *@public	
     */	
	addAllNamedColors:function()
	{
	var colors=this.colorHelper.getAllNamedColors();	
	for(var no=0;no<colors.length;no++){
		this.colors[this.colors.length]=['#'+colors[no][1],colors[no][0]];		
	}	
	
	}
	
// }}}
	,
	
// {{{ addGrayScaleColors()
    /**
    *Add gray scale colors to the palette
     *	
     *	@param Int numberOfColors-Number of colors to add
     *	@param Int rangeFrom-Optional parameter between 0 and 255(default is 0)
     *	@param Int rangeTo-Optional parameter between 0 and 255 ( default is 255)
    *@public	
     */	
	addGrayScaleColors:function(numberOfColors,rangeFrom,rangeTo)
	{
	if(!numberOfColors)numberOfColors=16;
	if(!rangeFrom)rangeFrom=0;
	if(!rangeTo)rangeTo=255;
	if(rangeFrom>rangeTo){
		var tmpRange=rangeFrom;
		rangeFrom=rangeTo;
		rangeTo=tmpRange;	
	}	
	var step=(rangeTo-rangeFrom)/ numberOfColors;
	for(var no=rangeFrom;no<=rangeTo;no+=step){
		var color=this.colorHelper.baseConverter(Math.round(no),10,16)+'';
		while(color.length<2)color='0'+color;
		this.colors[this.colors.length]=['#'+color+color+color,'#'+color+color+color];		
	}	
	}
	
// }}}
	,
	
// {{{ addColor()
    /**
    *Add a single color to the palette
     *	
     *	@param String color-Rgb code of color, example. #FF0000
     *	@param String name-Name of color (optional parameter)
     *	
    *@public	
     */	
	addColor:function(color,name)
	{	
	if(!name)name=color;
	this.colors[this.colors.length]=[color,name];	
	}
	
// }}}
	,
	
// {{{ setLayoutCss()
    /**
    *Specify name of css file.
     *	
     *	@param String cssFileName-Name of css file. path will be the config path+this name.(DHTMLSuite.configObj.cssPath)
     *	
     *	
    *@public	
     */	
	setLayoutCss:function(cssFileName)
	{
	this.layoutCSS=cssFileName;
	}
	
// }}}
	,
	
// {{{ getDivElement()
    /**
    *Returns a reference to the div element for this widget.
     *	
     *	@return Object DivElement-Reference to div element.
     *	
     *	
    *@public	
     */	
	getDivElement:function()
	{
	return this.divElement;
	}
	
// }}}
	,
	
// {{{ init()
    /**
    *Initializes the widget. Call this method after all colors has been added to the palette.
     *	
     *	
    *@public	
     */	
	init:function()
	{
	DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
	this.__createMainDivEl();	
	this.__createColorDivs();
	}
	
// }}}
	,
	
// {{{ __createMainDivEl()
    /**
    *Create main div element for the widget.
     *	
    *@private	
     */	
	__createMainDivEl:function()
	{
	this.divElement=document.createElement('DIV');
	this.divElement.className='DHTMLSuite_colorPalette';
	if(this.width){
		this.divElement.style.width=this.width;
	}
	}	
	
// }}}
	,
	
// {{{ __createColorDivs()
    /**
    *Create small color divs for the widget.
     *	
    *@private	
     */	
	__createColorDivs:function()
	{
	var ind=this.objectIndex;
	for(var no=0;no<this.colors.length;no++){
		var div=document.createElement('DIV');
		div.className='DHTMLSuite_colorPaletteColor';
		div.setAttribute('rgb',this.colors[no][0]);
		try{
		div.style.backgroundColor=this.colors[no][0];
		}catch(e){
		div.style.display='none';
		}
		div.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__clickOnColor(e); };
		DHTMLSuite.commonObj.__addEventEl(div)
		div.title=this.colors[no][1];
		this.divElement.appendChild(div);	
		
	}	
	var clearDiv=document.createElement('DIV');
	clearDiv.style.clear='both';
	this.divElement.appendChild(clearDiv);
	}
	
// }}}
	,
	
// {{{ __clickOnColor()
    /**
    *Called when users clicks on a color
     *	@param Event e-Event object-used to get a reference to the clicked color div.
     *	
    *@private	
     */	
	__clickOnColor:function(e)
	{
	if(document.all)e=event;
	var src=DHTMLSuite.commonObj.getSrcElement(e);
	
	this.currentColor.rgb=src.getAttribute('rgb');
	if(!this.currentColor.rgb)this.currentColor.rgb=src.rgb;
	this.currentColor.name=src.title;
	this.__handleCallback('colorClick');
	
	}
	
// }}}
	,
	
// {{{ __handleCallback()
    /**
    *Handle call back actions.
     *	@param String Action-Callback action to execute
     *	
    *@private	
     */	
	__handleCallback:function(action)
	{
	var callbackString='';
	switch(action)
	{
		case "colorClick":
		if(this.callbackOnColorClick)callbackString=this.callbackOnColorClick;
		break;
		
	}
	
	if(callbackString){
		callbackString=callbackString+'({ rgb:this.currentColor.rgb, name:this.currentColor.name})';
		eval(callbackString);
	}	
	}
}


/**
* @constructor
* @class This is a color slider class
* @version 1.0
* @param Array properties-Possible keys:
*
*
*	css file used for this widget: color-widget.css
*	Demo: (<a href="../../demos/demo-color-window-1.html" target="_blank">demo 1</a>)
* @author	Alf Magne Kalleland(www.dhtmlgoodies.com)
**/


DHTMLSuite.colorSlider=function(propertyArray)
{
	var divElement;
	var layoutCSS;
	var colorHelper;	
// Object of class DHTMLSuite.colorUtil
	
	var currentRgb;	
	var currentRed;
	var currentGreen;
	var currentBlue;
	var objectIndex;
	var frmFieldRed;
	var frmFieldGreen;
	var frmFieldBlue;
	var callbackOnChangeRgb;
	
	this.currentRgb='FF0000';
	this.currentRed=255;
	this.currentBlue=0;
	this.currentGreen=0;
	
	this.currentRedHex='FF';
	this.currentGreenHex='00';
	this.currentBlueHex='00';
	
	this.layoutCSS='color-slider.css';
	try{
	if(!standardObjectsCreated)DHTMLSuite.createStandardObjects();	
// This line starts all the init methods
	}catch(e){
	alert('You need to include the dhtmlSuite-common.js file');
	}	
	
	try{
	this.colorHelper=new DHTMLSuite.colorUtil();
	}catch(e){
	alert('You need to include dhtmlSuite-colorUtil.js');
	}
	
	this.objectIndex=DHTMLSuite.variableStorage.arrayDSObjects.length;
	DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex]=this;
	
	if(propertyArray)this.__setInitProps(propertyArray);
}


DHTMLSuite.colorSlider.prototype=
{	
	
// {{{ __setInitProps()
    /**
    *Handle call back actions.
    *@param Array props-Array of properties
     *	
    *@private	
     */	
	__setInitProps:function(props)
	{
	if(props.callbackOnChangeRgb)this.callbackOnChangeRgb=props.callbackOnChangeRgb;	
	}
	
// }}}
	,
	
// {{{ init()
    /**
    *Initializes the script
     *	
    *@public	
     */	
	init:function()
	{
	DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
	this.__createMainDivEl();	
	this.__createDivPreview();
	this.__createSliderDiv();
	this.__createColorDiv();	
	this.__setPreviewDivBgColor();	
	}
	
// }}}
	,
	
// {{{ setRgbColor()
    /**
    *Set new rgb code
     *
     *	@param String rgbCode-New RGB code in the format RRGGBB
     *	
    *@public	
     */	
	setRgbColor:function(rgbCode)
	{
	rgbCode=rgbCode+'';
	rgbCode=rgbCode.replace(/[^0-9A-F]/gi,'');
	if(rgbCode.length!=6)return false;
	this.currentRgb=rgbCode;
	this.__setParamsFromCurrentRgb();
	try{
		this.__updateSliderHandles();
		this.__updateFormFields();
		this.__setPreviewDivBgColor();	
	}catch(e){
		
// Widget not yet initialized by the init()method
	}	
	}
	
// }}}
	,
	
// {{{ getDivElement()
    /**
    *Return a reference to the main div element for this widget. you can use appendChild()to append it to an element on your web page.
     *	example: document.body.appendChild(colorSlider.getDivElement()).
     *
     *	@return Object divElement-Reference to div element for this widget
     *	
    *@public	
     */	
	getDivElement:function()
	{
	return this.divElement;
	}
	
// }}}
	,
	
// {{{ __createMainDivEl()
    /**
    *Create main div element for the widget. This is the top most parent div.
     *	
    *@private	
     */	
	__createMainDivEl:function()
	{
	this.divElement=document.createElement('DIV');
	this.divElement.className='DHTMLSuite_colorSlider';
	}
	
// }}}
	,
	
// {{{ __createDivPreview()
    /**
    *Create color preview div.
     *	
    *@private	
     */	
	__createDivPreview:function()
	{
	var div=document.createElement('DIV');
	div.className='DHTMLSuite_colorSliderPreviewParent';
	this.divPreview=document.createElement('DIV');
	this.divPreview.className='DHTMLSuite_colorSliderPreview';
	div.appendChild(this.divPreview);
	this.divElement.appendChild(div);		
	}
	
// }}}
	,
	
// {{{ __createSliderDiv()
    /**
    *Create divs for the sliders.
     *	
    *@private	
     */	
	__createSliderDiv:function()
	{
	var ind=this.objectIndex;
	
	var div=document.createElement('DIV');
	div.className='DHTMLSuite_colorSliderSliderParent';
	this.divElement.appendChild(div);
	
	
// Red slider
	var divRed=document.createElement('DIV');
	divRed.className='DHTMLSuite_colorSliderSliderColorRow';
	div.appendChild(divRed);
	
	var labelDiv=document.createElement('DIV');
	labelDiv.className='DHTMLSuite_colorSliderSliderLabelDiv';
	labelDiv.innerHTML='R';
	divRed.appendChild(labelDiv);
	
	var sliderDiv=document.createElement('DIV');
	sliderDiv.className='DHTMLSuite_colorSliderSlider';
	divRed.appendChild(sliderDiv);
	try{
		var sliderObj=new DHTMLSuite.slider();
	}catch(e){
		alert('Error-you need to include dhtmlSuite-slider.js');
	}
	sliderObj.setSliderTarget(sliderDiv);
	sliderObj.setSliderWidth(240);
	sliderObj.setOnChangeEvent('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__receiveRedFromSlider');
	sliderObj.setSliderName('red');
	sliderObj.setInitialValue(this.currentRed);
	sliderObj.setSliderMaxValue(255);
	sliderObj.init();	
	this.sliderObjRed=sliderObj;
	
	var inputDiv=document.createElement('DIV');
	inputDiv.className='DHTMLSuite_colorSliderSliderInputDiv';
	this.frmFieldRed=document.createElement('INPUT');
	this.frmFieldRed.value=this.currentRed;
	this.frmFieldRed.maxLength=3;
	inputDiv.appendChild(this.frmFieldRed);	
	divRed.appendChild(inputDiv);
	this.frmFieldRed.onchange=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveRedFromForm(e); };
	DHTMLSuite.commonObj.__addEventEl(this.frmFieldRed);	

	
	
// Green slider
	var divGreen=document.createElement('DIV');
	divGreen.className='DHTMLSuite_colorSliderSliderColorRow';
	div.appendChild(divGreen);
	
	var labelDiv=document.createElement('DIV');
	labelDiv.className='DHTMLSuite_colorSliderSliderLabelDiv';
	labelDiv.innerHTML='G';
	divGreen.appendChild(labelDiv);
	
	var sliderDiv=document.createElement('DIV');
	sliderDiv.className='DHTMLSuite_colorSliderSlider';
	divGreen.appendChild(sliderDiv);

	var sliderObj=new DHTMLSuite.slider();
	sliderObj.setSliderTarget(sliderDiv);
	sliderObj.setSliderWidth(240);
	sliderObj.setOnChangeEvent('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__receiveGreenFromSlider');
	sliderObj.setSliderName('green');
	sliderObj.setInitialValue(this.currentGreen);
	sliderObj.setSliderMaxValue(255);
	sliderObj.init();	
	this.sliderObjGreen=sliderObj;
	
	var inputDiv=document.createElement('DIV');
	inputDiv.className='DHTMLSuite_colorSliderSliderInputDiv';
	this.frmFieldGreen=document.createElement('INPUT');
	this.frmFieldGreen.value=this.currentGreen;
	this.frmFieldGreen.maxLength=3;
	inputDiv.appendChild(this.frmFieldGreen);	
	divGreen.appendChild(inputDiv);
	this.frmFieldGreen.onchange=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveGreenFromForm(e); };
	DHTMLSuite.commonObj.__addEventEl(this.frmFieldGreen);
		
	
// Blue slider
	var divBlue=document.createElement('DIV');
	divBlue.className='DHTMLSuite_colorSliderSliderColorRow';
	div.appendChild(divBlue);
	
	var labelDiv=document.createElement('DIV');
	labelDiv.className='DHTMLSuite_colorSliderSliderLabelDiv';
	labelDiv.innerHTML='B';
	divBlue.appendChild(labelDiv);
	
	var sliderDiv=document.createElement('DIV');
	sliderDiv.className='DHTMLSuite_colorSliderSlider';
	divBlue.appendChild(sliderDiv);

	var sliderObj=new DHTMLSuite.slider();
	sliderObj.setSliderTarget(sliderDiv);
	sliderObj.setSliderWidth(240);
	sliderObj.setOnChangeEvent('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__receiveBlueFromSlider');
	sliderObj.setSliderName('blue');
	sliderObj.setInitialValue(this.currentBlue);
	sliderObj.setSliderMaxValue(255);
	sliderObj.init();	
	this.sliderObjBlue=sliderObj;
	
	var inputDiv=document.createElement('DIV');
	inputDiv.className='DHTMLSuite_colorSliderSliderInputDiv';
	this.frmFieldBlue=document.createElement('INPUT');
	this.frmFieldBlue.value=this.currentBlue;
	this.frmFieldBlue.maxLength=3;
	this.frmFieldBlue.onchange=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveBlueFromForm(e); };
	DHTMLSuite.commonObj.__addEventEl(this.frmFieldBlue);
	inputDiv.appendChild(this.frmFieldBlue);	
	divBlue.appendChild(inputDiv);
	
	}
	
// }}}
	,
	
// {{{ __getValidatedFormVar()
    /**
    *Return form variable(red,green or blue)from event
     *	
     *	@param Event e-Reference to the Event object.
    *@private	
     */	
	__getValidatedFormVar:function(e)
	{
	var src=DHTMLSuite.commonObj.getSrcElement(e);
	var val=src.value;
	val=val.replace(/[^0-9]/gi,'');
	if(!val)val=0;
	val=val/1;
	if(val<0)val=0;
	if(val>255)val=255;	
	return val;	
	}
	,
	
// {{{ __receiveRedFromForm()
    /**
    *Receive color from the red text input.
     *	@param Event e-Reference to the Event object
     *	
    *@private	
     */	
	__receiveRedFromForm:function(e)
	{
	if(document.all)e=event;
	this.currentRed=this.__getValidatedFormVar(e);	
	this.currentRedHex=this.colorHelper.baseConverter(this.currentRed,10,16)+'';
	while(this.currentRedHex.length<2)this.currentRedHex='0'+this.currentRedHex;
	this.currentRgb=this.currentRedHex+this.currentGreenHex+this.currentBlueHex;
	this.__updateSliderHandles();
	this.__updateFormFields();
	this.__setPreviewDivBgColor();	
	}
	
// }}}
	,
	
// {{{ __receiveGreenFromForm()
    /**
    *Receive color from the green text input.
     *	
    *@private	
     */	
	__receiveGreenFromForm:function(e)
	{
	if(document.all)e=event;
	this.currentGreen=this.__getValidatedFormVar(e);
	this.currentGreenHex=this.colorHelper.baseConverter(this.currentGreen,10,16)+'';
	while(this.currentGreenHex.length<2)this.currentGreenHex='0'+this.currentGreenHex;
	this.currentRgb=this.currentRedHex+this.currentGreenHex+this.currentBlueHex;		
	this.__updateSliderHandles();
	this.__updateFormFields();
	this.__setPreviewDivBgColor();		
	}
	
// }}}
	,
	
// {{{ __receiveBlueFromForm()
    /**
    *Receive blue color from form.
     *	
    *@private	
     */	
	__receiveBlueFromForm:function(e)
	{
	if(document.all)e=event;
	this.currentBlue=this.__getValidatedFormVar(e);
	this.currentBlueHex=this.colorHelper.baseConverter(this.currentBlue,10,16)+'';
	while(this.currentBlueHex.length<2)this.currentBlueHex='0'+this.currentBlueHex;
	this.currentRgb=this.currentRedHex+this.currentGreenHex+this.currentBlueHex;	
	this.__updateSliderHandles();
	this.__updateFormFields();
	this.__setPreviewDivBgColor();		
	}
	
// }}}
	,
	
// {{{ __createColorDiv()
    /**
    *Create color div at the bottom, the div users can click on in order to select a color.
     *	
    *@private	
     */	
	__createColorDiv:function()
	{
	var ind=this.objectIndex;	
	var div=document.createElement('DIV');
	div.className='DHTMLSuite_colorSliderRgbBgParent';
	this.divElement.appendChild(div);
	this.colorDiv=document.createElement('DIV');
	this.colorDiv.className='DHTMLSuite_colorSliderRgbBg';
	div.appendChild(this.colorDiv);	
	DHTMLSuite.commonObj.addEvent(this.colorDiv,'click',function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__clickOnRgbBg(e); });	
	}
	
// }}}
	,
	
// {{{ __setPreviewDivBgColor()
    /**
    *Update the background color of the preview div..
     *	
    *@private	
     */	
	__setPreviewDivBgColor:function()
	{
	try{
		this.divPreview.style.backgroundColor='#'+this.currentRgb;
		this.__handleCallback('rgbChange');
	}catch(e){
		alert(this.currentRgb);
	}
	}
	
// }}}
	,
	
// {{{ __setParamsFromCurrentRgb()
    /**
    *Save properties by parsing rgbCode
     *	
    *@private	
     */	
	__setParamsFromCurrentRgb:function()
	{
	this.currentRedHex=this.currentRgb.substr(0,2); 
	this.currentGreenHex=this.currentRgb.substr(2,2); 
	this.currentBlueHex=this.currentRgb.substr(4,2); 		
	this.currentRed=this.colorHelper.baseConverter(this.currentRedHex,16,10);
	this.currentGreen=this.colorHelper.baseConverter(this.currentGreenHex,16,10);
	this.currentBlue=this.colorHelper.baseConverter(this.currentBlueHex,16,10);		
	}
	
// }}}
	,	
	
// {{{ __clickOnRgbBg()
    /**
    *Click event on the color gradient at the bottom.
     *	@param Object e-reference to the Event object.
     *	
    *@private	
     */	
	__clickOnRgbBg:function(e)
	{
	var left=DHTMLSuite.commonObj.getLeftPos(this.colorDiv);
	var top=DHTMLSuite.commonObj.getTopPos(this.colorDiv);
	if(document.all)e=event;
	
	var width=350;
	var height=20;
	var y=e.clientY-top;
	var x=e.clientX-left-1;
	if(e.layerX){ 
// For those browsers who supports layerX, example: Firefox.
		x=e.layerX;	
		y=e.layerY;
	}
	if(y>height)y=height;
	if(x<=350){
		this.currentRgb=this.__getHorizColor(y*width+x-1, width, height);	
		this.__setParamsFromCurrentRgb();
	}else{
		this.currentRgb='000000';
		this.currentRedHex='00';
		this.currentGreenHex='00';
		this.currentBlueHex='00';
		this.currentRed=0;
		this.currentGreen=0;
		this.currentBlue=0;
	}
	this.__updateSliderHandles();
	this.__updateFormFields();
	this.__setPreviewDivBgColor();
	}
	
// }}}
	,
	
// {{{ __updateSliderHandles()
    /**
    * Users has clicked on color bar at the bottom or changed the values of the inputs->Update position of sliders.
     *	
    *@private	
     */	
	__updateSliderHandles:function()
	{
	this.sliderObjRed.setSliderValue(this.currentRed);
	this.sliderObjGreen.setSliderValue(this.currentGreen);
	this.sliderObjBlue.setSliderValue(this.currentBlue);	
	}
	
// }}}
	,
	
// {{{ __updateFormFields()
    /**
    * Update values of form fields
     *	
    *@private	
     */	
	__updateFormFields:function()
	{	
	this.frmFieldRed.value=this.currentRed;
	this.frmFieldGreen.value=this.currentGreen;
	this.frmFieldBlue.value=this.currentBlue;	
	}
	
// }}}
	,
	
// {{{ __receiveRedFromSlider()
    /**
    * Receive red color from slider
     *	@param Integer value-New red value(0-255)
     *	
    *@private	
     */	
	__receiveRedFromSlider:function(value)
	{
	this.frmFieldRed.value=value;	
	this.currentRed=value;	
	this.currentRedHex=this.colorHelper.baseConverter(value,10,16)+'';
	if(this.currentRedHex.length==1)this.currentRedHex='0'+this.currentRedHex;	
	this.currentRgb=this.currentRedHex+this.currentGreenHex+this.currentBlueHex;
	this.__setPreviewDivBgColor();
	}
	
// }}}
	,
	
// {{{ __receiveGreenFromSlider()
    /**
    * Receive green color from slider
     *	@param Integer value-New green value(0-255)
     *	
    *@private	
     */	
	__receiveGreenFromSlider:function(value)
	{
	this.frmFieldGreen.value=value;	
	this.currentGreen=value;
	this.currentGreenHex=this.colorHelper.baseConverter(value,10,16)+'';	
	if(this.currentGreenHex.length==1)this.currentGreenHex='0'+this.currentGreenHex;	
	this.currentRgb=this.currentRedHex+this.currentGreenHex+this.currentBlueHex;
	this.__setPreviewDivBgColor();
	}
	
// }}}
	,
	
// {{{ __receiveBlueFromSlider()
    /**
    * Receive blue color from slider
     *	@param Integer value-New green value(0-255)
     *	
    *@private	
     */	
	__receiveBlueFromSlider:function(value)
	{
	this.frmFieldBlue.value=value;	
	this.currentBlue=value;
	this.currentBlueHex=this.colorHelper.baseConverter(value,10,16)+'';
	if(this.currentBlueHex.length==1)this.currentBlueHex='0'+this.currentBlueHex;	
	this.currentRgb=this.currentRedHex+this.currentGreenHex+this.currentBlueHex;	
	this.__setPreviewDivBgColor();	
	}
	
// }}}
	,
	
// {{{ ____getHorizColor()
    /**
     /* This function is from the great article at http:
//www.webreference.com/programming/javascript/mk/column3/index.html 
     *
    * Click events on color bar -> this method returns the correct color based on where the mouse was on the bar
     *
     *	@param Integer i-Combination of x and y position on the bar
     *	@param Integer width-Width of bar
     *	@param Integer height-Height of bar
     *	
    *@private	
     */	
    __getHorizColor:function (i, width, height){
	var sWidth=(width)/7;         
// "section" width
	var C=i%width;                  
// column
	var R=Math.floor(i/(sWidth*7)); 
// row
	var c=i%sWidth;                 
// column in current group
	var r, g, b, h;
	
	var l=(255/sWidth)*c;           
// color percentage
	
	if(C>=sWidth*6){
		r=g=b=255-l;
	} else {
		h=255-l;	
		r=C<sWidth?255:C<sWidth*2?h:C<sWidth*4?0:C<sWidth*5?l:255;
		g=C<sWidth?l:C<sWidth*3?255:C<sWidth*4?h:0;
		b=C<sWidth*2?0:C<sWidth*3?l:C<sWidth*5?255:h;	
		if(R<(height/2)){
		var base=255-(255*2/height)*R;	
		r=base+(r*R*2/height);
		g=base+(g*R*2/height);
		b=base+(b*R*2/height);
		}else if(R>(height/2)){
		var base=(height-R)/(height/2);	
		r=r*base;
		g=g*base;
		b=b*base;
		}
	}	
	var red=this.colorHelper.baseConverter(r,10,16)+'';
	if(red.length=='1')red='0'+red;
	var green=this.colorHelper.baseConverter(g,10,16)+'';
	if(green.length=='1')green='0'+green;
	var blue=this.colorHelper.baseConverter(b,10,16)+'';
	if(blue.length=='1')blue='0'+blue;
	return red+green+blue;

	}
	
// }}}
	,
	
// {{{ __handleCallback()
    /**
    * Handle callback
     *	@param String action-Action to execute
     *	
    *@private	
     */	
	__handleCallback:function(action)
	{
	var callbackString='';
	switch(action){
		case "rgbChange":
		if(this.callbackOnChangeRgb)callbackString=this.callbackOnChangeRgb;
		break;
	}
	if(callbackString){		
		var rgb=this.currentRgb.toUpperCase();
		callbackString=callbackString+'({ rgb:"#'+rgb+'",name:"#'+rgb+'"})';
		return eval(callbackString);
	}
	}
}


/**
* @constructor
* @class This class provides some methods for working with colors.
* @version 1.0
* @param Array properties-Possible keys:
*	hueSliderPosition("horizontal" or "vertical"(default): 
*	displayHsv (true or false if hsv form fields should be shown-true is default)
*	displayRgb (true or false if rgb form fields should be shown-true is default)
*	displayRgbCode ( true or false if the rgb code field should be shown-true is default)
*	callbackOnChangeRgb ( callback function to execute when rgb code changes)
*	updateFormDuringMoveOnPalette-Update the form with hsv and rgb codes during drag on palette(default=true)- setting this value to false spees up the widget a little bit
*
*
*	css file used for this widget: color-widget.css
*	Demo: (<a href="../../demos/demo-color-window-1.html" target="_blank">demo 1</a>)
* @author	Alf Magne Kalleland(www.dhtmlgoodies.com)
**/


DHTMLSuite.colorWidget=function(propertyArray)
{
	var divElement;
	var divElPalette;
	var divElPaletteCircle;
	var divElHueBar;
	var sliderDiv;
	var updateFormDuringMoveOnPalette;
	
	var layoutCSS;
	var objectIndex;
	
	var currentHue;
	var currentBrightness;
	var currentSaturation;
	var currentRgbCode;
	
	var colorHelper;
	var dragObject;
	var topPosHueBar;
	var paletteSize;
	
	var formFieldHue;
	var formFieldSaturation;
	var formFieldBrightness;
	var formFieldBlue;
	var formFieldGreen;
	var formFieldRed;
	
	var displayHsv;
	var displayRgb;
	var displayRgbCode;
	
	this.displayRgb=true;
	this.displayHsv=true;
	this.displayRgbCode=true;
	this.updateFormDuringMoveOnPalette=true;
	
	var hueSliderPosition;
	var circleOffsetSize;		
// Size of small circle / 2 rounded
	var posdivElPalette;
	var parentRef;
	
	this.posdivElPalette=new Object();
	
	var circleOffsetBecauseOfWinWidget;
	
	var callbackOnChangeRgb;
	
	this.circleOffsetBecauseOfWinWidget=0;
	
	this.circleOffsetSize=7;
	this.hueSliderPosition='vertical';
	this.layoutCSS='color-widget.css';
	this.currentHue=0;
	this.currentBrightness=100;
	this.currentSaturation=100;
	this.paletteSize=256;
	this.currentRgbCode='FF0000';

	try{
	this.colorHelper=new DHTMLSuite.colorUtil();
	}catch(e){
	alert('You need to include dhtmlSuite-colorUtil.js');
	}
	try{
	if(!standardObjectsCreated)DHTMLSuite.createStandardObjects();	
// This line starts all the init methods
	}catch(e){
	alert('You need to include the dhtmlSuite-common.js file');
	}

	
	this.objectIndex=DHTMLSuite.variableStorage.arrayDSObjects.length;
	DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex]=this;
	
	this.__setInitProps(propertyArray);
}

DHTMLSuite.colorWidget.prototype=
{
	
// {{{ __setInitProps()
    /**
    *Set initial properties sent to the constructor
     *
    *@private
     */	
	__setInitProps:function(propertyArray)
	{
	if(!propertyArray)return;
	if(propertyArray.hueSliderPosition)this.hueSliderPosition=propertyArray.hueSliderPosition;
	if(propertyArray.callbackOnChangeRgb)this.callbackOnChangeRgb=propertyArray.callbackOnChangeRgb;
	if(propertyArray.displayHsv||propertyArray.displayHsv===false)this.displayHsv=propertyArray.displayHsv;
	if(propertyArray.displayRgb||propertyArray.displayRgb===false)this.displayRgb=propertyArray.displayRgb;
	if(propertyArray.displayRgbCode||propertyArray.displayRgbCode===false)this.displayRgbCode=propertyArray.displayRgbCode;
	if(propertyArray.updateFormDuringMoveOnPalette||propertyArray.updateFormDuringMoveOnPalette===false)this.updateFormDuringMoveOnPalette=propertyArray.updateFormDuringMoveOnPalette;
	if(propertyArray.parentRef)this.parentRef=DHTMLSuite.commonObj.getEl(propertyArray.parentRef);
	}
	
// }}}
	,
	
// {{{ setHueSliderPosition()
    /**
    *Specify position of hue slider, vertical or horizontal
     *
    *@param String hueSliderPosition-Hue slider position-"vertical" or "horizontal"
    *@public
     */	
	setHueSliderPosition:function(hueSliderPosition)
	{
	this.hueSliderPosition=hueSliderPosition;
	if(hueSliderPosition=='vertical'){		
		this.sliderDivHorMain.style.display='none';
		this.sliderDivMain.style.display='block';
		var ind=this.objectIndex;
		setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].sliderDiv.style.marginTop=(2 -Math.floor(DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].sliderDiv.offsetHeight/2))+"px"',100);
		
		
	}
	if(hueSliderPosition=='horizontal'){
		if(this.sliderDivMain){
		this.sliderDivHorMain.style.display='block';
		this.sliderDivMain.style.display='none';
		}	
	}
	

	}
	
// }}}
	,
	
// {{{ setCallbackOnChangeRgb()
    /**
    *Specify call back function which is executed when the rgb value is modified. Only the name of the function should be sent to this method. 
     *	When the callback is executed, an associative array will be sent as argument. Keys in this array will be rgb,hue,saturation and brightness.
     *
    *@param String functionName-Name of function to execute when the rgb color is changed.
    *@public
     */	
	setCallbackOnChangeRgb:function(functionName)
	{
	this.callbackOnChangeRgb=functionName;
	}
	
// }}}
	,
	
// {{{ setRgbColor()
    /**
    *Set new rgb color for the slider.
     *
    *@public
     */	
	setRgbColor:function(rgbColor)
	{
	var hsv=this.colorHelper.getHsvByRgbCode(rgbColor);
	this.currentHue=Math.round(hsv.hue);
	this.currentBrightness=Math.round(hsv.brightness*100);
	this.currentSaturation=Math.round(hsv.saturation*100);
	this.__changeViewAfterColorChange();

	}
	
// }}}
	,
	
// {{{ setHue()
    /**
    *Set new hue, i.e. position on the color circle.
     *
     *	@param Int hue-value between 0 and 359
     *
    *@public
     */	
	setHue:function(hue)
	{
	hue=hue+'';
	if(hue.match(/^[0-9]+$/)){
		while(hue>=360)hue-=360;
		this.currentHue=hue;
		this.__changeViewAfterColorChange();
	}	
	}
	
// }}}
	,
	
// {{{ setSaturation()
    /**
    *Set new saturation, i.e. amount of color(hue)
     *
     *	@param Int saturation-value between 0 and 100
     *
    *@public
     */	
	setSaturation:function(saturation)
	{
	saturation=saturation+'';
	if(saturation.match(/^[0-9]+$/)){
		while(saturation>100)saturation-=100;
		this.currentSaturation=saturation;
		this.__changeViewAfterColorChange();
	}	
	}
	
// }}}
	,
	
// {{{ setBrightness()
    /**
    *Set new brightness
     *
     *	@param Int brightness-value between 0 and 100
     *
    *@public
     */	
	setBrightness:function(brightness)
	{
	brightness=brightness+'';
	if(brightness.match(/^[0-9]+$/)){
		while(brightness>100)brightness-=100;
		this.currentBrightness=brightness;
		this.__changeViewAfterColorChange();
	}	
	}
	
// }}}
	,
	
// {{{ getDivElement()
    /**
    *Return a reference to main div element for the widget.
     *
    *@public
     */	
	getDivElement:function()
	{
	return this.divElement;
	
	}	
	
// }}}
	,
	
// {{{ init()
    /**
    *Initializes the widget
     *
    *@public
     */	
	init:function()
	{
	DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
	this.__createMainDivEl();	
	this.__createdivElPalette();
	this.__createHueBar();
	
	this.__createFormDiv();
	this.__createHueBarHorizontal();
	this.__addEvents();
	this.__setPaletteBgColor();
	this.__updateHsvInForm();
	this.__setBgColorPreviewDiv();
	this.__updateRgbInForm();
	}
	
// }}}
	,
	
// {{{ __changeViewAfterColorChange()
    /**
    *This method is called after a color has been changed by external calls(example: setRgbColor)
     *
    *@private
     */	
	__changeViewAfterColorChange:function()
	{	
	this.__setCurrentRgbCode();
	this.__setPaletteBgColor();	
	this.__setBgColorPreviewDiv();
	this.__setSliderPos();
	this.__updateRgbInForm();
	this.__updateHsvInForm();
	this.__setSmallCirclePosition();	
	}
	
// }}}
	,
	
// {{{ __updateHsvInForm()
    /**
    *Update Hsv colors in form.
     *
    *@private
     */	
	__updateHsvInForm:function()
	{
	if(!this.displayHsv)return;
	this.fieldHue.value=this.currentHue;
	this.fieldSaturation.value=this.currentSaturation;
	this.fieldBrightness.value=this.currentBrightness;
	return;
	if(this.currentBrightness > 80){		
		this.divElPaletteCircle.className ='DHTMLSuite_colorSlider_palette_circle DHTMLSuite_colorSlider_palette_circleBlack';
	}else{
		this.divElPaletteCircle.className  ='DHTMLSuite_colorSlider_palette_circle';
	}
	}
	
// }}}
	,
	
// {{{ __updateRgbInForm()
    /**
    *Update rgb colors in form.
     *
    *@private
     */	
	__updateRgbInForm:function()
	{
	
	var rgbColors=this.colorHelper.getRgbColorsByRgbCode(this.currentRgbCode);

	if(this.displayRgb){
		this.fieldBlue.value=rgbColors.blue;	
		this.fieldRed.value=rgbColors.red;	
		this.fieldGreen.value=rgbColors.green;	
	}	
	if(this.displayRgbCode){
		this.fieldRgbCode.value=this.currentRgbCode;
	}	
	if(this.callbackOnChangeRgb)this.__handleCallback('rgbChange');
	}
	
// }}}
	,
	
// {{{ __setSliderPos()
    /**
    *Position vertical and horizontal sliders-called after manually changes in the form
     *
    *@private
     */	
	__setSliderPos:function()
	{
	var topPos=Math.round(this.paletteSize-((this.currentHue / 360)* this.paletteSize))-3;
	this.sliderDiv.style.top=topPos; 
	this.sliderDivHor.style.left=(this.currentHue-4)+'px'; 	
	}
	
// }}}
	,
	
// {{{ __setBgColorPreviewDiv()
    /**
    *Set background color of preview div
     *
    *@private
     */	
	__setBgColorPreviewDiv:function()
	{
	this.divElPreviewDiv.style.backgroundColor='#'+this.currentRgbCode;
	}
	
// }}}
	,
	
// {{{ __setPaletteBgColor()
    /**
    *Set background color of gradient palette
     *
    *@private
     */	
	__setPaletteBgColor:function()
	{
	try{
		this.divElPalette.style.backgroundColor='#'+this.colorHelper.getRgbCodeByHsv(this.currentHue,1,1);
	}catch(e)
	{
		
	}
	}
	
// }}}
	,
	
// {{{ __createFormDiv()
    /**
    *Create form elements for the slider
     *
    *@private
     */	
	__createFormDiv:function()
	{
	var ind=this.objectIndex;
	
	this.divElForm=document.createElement('DIV');	
	this.divElForm.className='DHTMLSuite_colorSliderFormDiv';
	this.divElement.appendChild(this.divElForm);
	
	this.divElPreviewDiv=document.createElement('DIV');
	this.divElPreviewDiv.className='DHTMLSuite_colorSlider_colorPreview';
	this.divElForm.appendChild(this.divElPreviewDiv);
	
	
	var table=document.createElement('TABLE');
	table.cellpadding=0;
	table.cellspacing=0;
	table.className='DHTMLSuite_colorSliderFormTable';
	var form=document.createElement('FORM');
	table.appendChild(form);
	this.divElForm.appendChild(table);
	
	
	/* Hue */
	if(this.displayHsv){
		var row=table.insertRow(-1);
		var cell=row.insertCell(-1);
		cell.innerHTML='H:';
		var cell=row.insertCell(-1);
		this.fieldHue=document.createElement('INPUT');
		this.fieldHue.onchange=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveHueFromForm(e); }
		DHTMLSuite.commonObj.__addEventEl(this.fieldHue);
		this.fieldHue.maxLength=3;
		cell.appendChild(this.fieldHue);
		
		/* Saturation */
		var row=table.insertRow(-1);
		var cell=row.insertCell(-1);
		cell.innerHTML='S:';
		var cell=row.insertCell(-1);
		this.fieldSaturation=document.createElement('INPUT');
		this.fieldSaturation.maxLength=3;
		this.fieldSaturation.onchange=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveSatFromForm(e); }
		DHTMLSuite.commonObj.__addEventEl(this.fieldSaturation);
		cell.appendChild(this.fieldSaturation);
		
		/* Brightness */
		var row=table.insertRow(-1);
		var cell=row.insertCell(-1);
		cell.innerHTML='B:';
		var cell=row.insertCell(-1);
		this.fieldBrightness=document.createElement('INPUT');
		this.fieldBrightness.onchange=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveBriFromForm(e); }
		DHTMLSuite.commonObj.__addEventEl(this.fieldBrightness);
		this.fieldBrightness.maxLength=3;
		cell.appendChild(this.fieldBrightness);
	}
	
	if(this.displayRgb){	
		var row=table.insertRow(-1);
		var cell=row.insertCell(-1);
		cell.innerHTML='R:';
		var cell=row.insertCell(-1);
		this.fieldRed=document.createElement('INPUT');
		this.fieldRed.onchange=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__setRedColorFromForm(e); }
		DHTMLSuite.commonObj.__addEventEl(this.fieldRed);	
		this.fieldRed.maxLength=3;
		cell.appendChild(this.fieldRed);
		
		var row=table.insertRow(-1);
		var cell=row.insertCell(-1);
		cell.innerHTML='G:';
		var cell=row.insertCell(-1);
		this.fieldGreen=document.createElement('INPUT');
		this.fieldGreen.onchange=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__setGreenColorFromForm(e); }
		DHTMLSuite.commonObj.__addEventEl(this.fieldGreen);		
		this.fieldGreen.maxLength=3;
		cell.appendChild(this.fieldGreen);
		
		var row=table.insertRow(-1);
		var cell=row.insertCell(-1);
		cell.innerHTML='B:';
		var cell=row.insertCell(-1);
		this.fieldBlue=document.createElement('INPUT');
		this.fieldBlue.onchange=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__setBlueColorFromForm(e); }
		DHTMLSuite.commonObj.__addEventEl(this.fieldBlue);		
		this.fieldBlue.maxLength=3;
		cell.appendChild(this.fieldBlue);
	}	
	if(this.displayRgbCode){
		var row=table.insertRow(-1);
		var cell=row.insertCell(-1);
		cell.innerHTML='#';
		var cell=row.insertCell(-1);
		this.fieldRgbCode=document.createElement('INPUT');
		this.fieldRgbCode.maxLength=6;
		this.fieldRgbCode.className='DHTMLSuite_colorSlider_rgbCode';
		this.fieldRgbCode.onchange=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveRgbCodeFromForm(e); }
		DHTMLSuite.commonObj.__addEventEl(this.fieldRgbCode);	
		cell.appendChild(this.fieldRgbCode);	
	}	
	}
	
// }}}
	,	
	
// {{{ __createMainDivEl()
    /**
    *Create main div element
     *
    *@private
     */	
	__createMainDivEl:function()
	{
	this.divElement=document.createElement('DIV');
	this.divElement.className='DHTMLSuite_colorSlider';	
	if(this.parentRef)this.parentRef.appendChild(this.divElement);
	}
	
// }}}
	,
	
// {{{ __correctPng()
    /**
    *Correct png gradient for IE6 and below.
     *
    *@private
     */	
	__correctPng:function(id)
	{	
	try{
		var img=document.getElementById(id);
		var html='<span style="display:inline-block;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\''+img.src+'\',sizingMethod=\'scale\');width:'+this.paletteSize+';height:'+this.paletteSize+'"></span>';
		img.outerHTML=html;	
	}catch(e){
		var ind=this.objectIndex;
		setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__correctPng("'+id+'")',20);
	}	
	}
	
// }}}
	,
	
// {{{ __createdivElPalette()
    /**
    *Create div element for the palette
     *
    *@private
     */	
	__createdivElPalette:function()
	{
	var ind=this.objectIndex;
	var div=document.createElement('DIV');
	div.className='DHTMLSuite_colorSlider_palette_border';
	div.style.position='relative';
	this.divElement.appendChild(div);
	this.divElPaletteBorder=div;
	
	this.divElPalette=document.createElement('DIV');
	this.divElPalette.className='DHTMLSuite_colorSlider_palette';	
	this.divElPalette.style.position='relative';
	
	DHTMLSuite.commonObj.__addEventEl(this.divElPalette);
	
	var img=document.createElement('IMG');
	img.src=DHTMLSuite.configObj.imagePath+'colorPalettes/bgGradient.png';
	img.setAttribute('width',this.paletteSize);
	img.setAttribute('height',this.paletteSize);
	img.ondragstart=function(){ return false; };	
	img.onselectstart=function(){ return false; };	
	img.onmousedown=function(){ return false; };
	img.id=''+DHTMLSuite.commonObj.getUniqueId();
	this.divElPalette.appendChild(img);
	DHTMLSuite.commonObj.__addEventEl(img);
	
	if((DHTMLSuite.clientInfoObj.isMSIE&&DHTMLSuite.clientInfoObj.navigatorVersion<7)||DHTMLSuite.clientInfoObj.isOpera){
		this.__correctPng(img.id);	
	}	
	div.appendChild(this.divElPalette);		
	this.divElPaletteCircle=document.createElement('DIV');
	this.divElPaletteCircle.className='DHTMLSuite_colorSlider_palette_circle';	
	this.divElPalette.appendChild(this.divElPaletteCircle);	
	this.divElPaletteCircle.display='block';	
	this.divElPaletteCircle.style.top='-'+this.circleOffsetSize+'px';
	this.divElPaletteCircle.style.left=(this.paletteSize-this.circleOffsetSize)+'px';

	}
	
// }}}
	,
	
// {{{ __setSmallCirclePosition()
    /**
    *Position the small circle.
     *
    *@private
     */		
	__setSmallCirclePosition:function()
	{
	var leftPos=Math.round(this.currentSaturation*(this.paletteSize / 100))- this.circleOffsetSize;
	var topPos=this.paletteSize-Math.round(this.currentBrightness*(this.paletteSize / 100))- this.circleOffsetSize;	
	this.divElPaletteCircle.style.left=leftPos+'px';
	this.divElPaletteCircle.style.top=topPos +'px';	
	this.divElPaletteCircle.className=this.divElPaletteCircle.className.replace(' DHTMLSuite_colorSlider_palette_circleBlack','');
	if(this.currentBrightness > 80){		
		this.divElPaletteCircle.className =this.divElPaletteCircle.className+' DHTMLSuite_colorSlider_palette_circleBlack';
	}	
	
	}
	
// }}}
	,
	
// {{{ __createHueBar()
    /**
    *Create vertical hue bar
     *
    *@private
     */	
	__createHueBar:function()
	{
	var ind=this.objectIndex;	
	var mainDiv=document.createElement('DIV');
	mainDiv.className='DHTMLSuite_colorSlider_hue';
	this.sliderDivMain=mainDiv;
	this.divElement.appendChild(mainDiv);
	this.sliderDiv=document.createElement('DIV');
	this.sliderDiv.className='DHTMLSuite_colorSlider_sliderHandle';
	mainDiv.appendChild(this.sliderDiv);
	this.sliderDiv.innerHTML='<div><span></span></div>';
	setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].sliderDiv.style.marginTop=(2 -Math.floor(DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].sliderDiv.offsetHeight/2))+"px"',100);
	var div=document.createElement('DIV');
	div.className='DHTMLSuite_colorSlider_hueBar_border';
	mainDiv.appendChild(div);
	this.divElHueBar=document.createElement('DIV');
	this.divElHueBar.className='DHTMLSuite_colorSlider_hueBar';
	div.appendChild(this.divElHueBar);
	if(this.hueSliderPosition=='horizontal')mainDiv.style.display='none';
	}	
	
// }}}
	,
	
// {{{ __createHueBarHorizontal()
    /**
    *Create horizontal hue bar
     *
    *@private
     */	
	__createHueBarHorizontal:function()
	{	
	var ind=this.objectIndex;
	this.sliderDivHorMain=document.createElement('DIV');
	this.sliderDivHorMain.className='DHTMLSuite_colorSlider_hueHorizontal';
	this.divElement.appendChild(this.sliderDivHorMain);
	this.sliderDivHor=document.createElement('DIV');
	this.sliderDivHor.className='DHTMLSuite_colorSlider_sliderHandleHorizontal';
	this.sliderDivHorMain.appendChild(this.sliderDivHor);
	this.sliderDivHor.innerHTML='<div><span></span></div>';
	setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].sliderDiv.style.marginTop=(2 -Math.floor(DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].sliderDiv.offsetHeight/2))+"px"',100);
	var div=document.createElement('DIV');
	div.className='DHTMLSuite_colorSlider_hueBarHorizontal_border';
	this.sliderDivHorMain.appendChild(div);
	this.divElHueBarHorizontal=document.createElement('DIV');
	this.divElHueBarHorizontal.className='DHTMLSuite_colorSlider_hueBarHorizontal';
	div.appendChild(this.divElHueBarHorizontal);
	if(this.hueSliderPosition=='vertical')this.sliderDivHorMain.style.display='none';	
	}	

	
// }}}
	,
	
// {{{ __setHueFromHorizontalSlider()
    /**
    *User has dragged the hrozintal scrollbar-we need to update the view.
     *
    *@private
     */	
	__setHueFromHorizontalSlider:function(e)
	{
	if(document.all)e=event;
	var hue=this.sliderDivHor.offsetLeft+4;
	if(hue>359||hue<0)hue=0;
	this.currentHue=hue;
	this.__setPaletteBgColor();
	this.__setBgColorPreviewDiv();	
	this.__updateRgbInForm();	
	this.__updateHsvInForm();	
	}
	
// }}}
	,
	
// {{{ __setHueFromSlider()
    /**
    *User has dragged the vertical scrollbar-we need to update the view.
     *
    *@private
     */	
	__setHueFromSlider:function(e)
	{
	if(document.all)e=event;
	var hue=360-Math.round((this.sliderDiv.offsetTop+4)* (360/this.paletteSize))
	if(hue>359||hue<0)hue=0;
	this.currentHue=hue;
	this.__setPaletteBgColor();	
	this.__setBgColorPreviewDiv();	
	this.__updateHsvInForm();
	this.__updateRgbInForm();
	
	}
	
// }}}
	,
	
// {{{ __addEvents()
    /**
    *Add basic events.
     *
    *@private
     */	
	__addEvents:function()
	{
	var ind=this.objectIndex;
	DHTMLSuite.commonObj.addEvent(this.sliderDivHorMain,'mousedown',function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__initHorHueMove(e); });	
	DHTMLSuite.commonObj.addEvent(this.sliderDivMain,'mousedown',function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__initHueMove(e); });	
	DHTMLSuite.commonObj.addEvent(this.divElPalette,'mousedown',function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__initPaletteMove(e); });	
	DHTMLSuite.commonObj.addEvent(document.documentElement,'mousemove',function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOnPalette(e); });	
	DHTMLSuite.commonObj.addEvent(document.documentElement,'mousemove',function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOnHorizHueBar(e); });	
	DHTMLSuite.commonObj.addEvent(document.documentElement,'mousemove',function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOnHueBar(e); });	
	DHTMLSuite.commonObj.addEvent(document.documentElement,'mouseup',function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__endDrag(e); });		
	DHTMLSuite.commonObj.addEvent(this.divElHueBar,'mousedown',function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOnHueBar(e); });	
	
	if(!document.documentElement.onselectstart){
		document.documentElement.onselectstart=function(){ return DHTMLSuite.commonObj.__isTextSelOk(); };
		DHTMLSuite.commonObj.__addEventEl(document.documentElement);	
	}
	}
	
// }}}
	,
	
// {{{ __moveOnHueBar()
    /**
    *Click on hue bar-move the slider and update the view.
     *
    *@private
     */	
	__moveOnHueBar:function(e)
	{
	if(this.hueStatus!=1)return;
	if(document.all)e=event;
	var topPos=this.poxYHue;	
	var diff=e.clientY+document.documentElement.scrollTop-topPos;
	if(diff>this.paletteSize)diff=this.paletteSize;
	if(diff<0)diff=0;
	this.sliderDiv.style.top=diff+'px';
	var hue=Math.round(((this.paletteSize-diff)* (360/this.paletteSize))); 
	if(hue==360)hue=0;
	this.currentHue=hue;
	this.__setCurrentRgbCode();
	this.__setPaletteBgColor();	
	this.__setBgColorPreviewDiv();	
	this.__updateHsvInForm();	
	this.__updateRgbInForm();	
	}
	
// }}}
	,
	
// {{{ __moveOnHorizHueBar()
    /**
    *Click on hue bar-move the slider and update the view.
     *
    *@private
     */	
	__moveOnHorizHueBar:function(e)
	{
	if(this.hueHorStatus!=1)return;
	if(document.all)e=event;
	var leftPos=this.posXHorHue;	
	var diff=e.clientX-leftPos-this.circleOffsetBecauseOfWinWidget;	
	if(diff<0)diff=0;
	if(diff>362)diff=362;
	this.sliderDivHor.style.left=(diff -4)+'px';
	var hue=diff; 
	if(hue>=360)hue=0;
	this.currentHue=hue;
	this.__setCurrentRgbCode();
	this.__setPaletteBgColor();	
	this.__setBgColorPreviewDiv();
	this.__updateHsvInForm();	
	this.__updateRgbInForm();	
	}
	
// }}}
	,
	
// {{{ __setHueFromRgbColorsInForm()
    /**
    *User have changed value in the rgb code text input
     *
    *@private
     */	
	__setHueFromRgbColorsInForm:function()
	{
	var color=this.colorHelper.getRgbCodeByRgbColors(this.fieldRed.value,this.fieldGreen.value,this.fieldBlue.value);	
	var hsv=this.colorHelper.getHsvByRgbCode(color);
	this.currentHue=Math.round(hsv.hue);
	this.currentSaturation=Math.round(hsv.saturation*100);
	this.currentBrightness=Math.round(hsv.brightness*100);
	this.__changeViewAfterColorChange();
	}
	
// }}}
	,
	
// {{{ __setRedColorFromForm()
    /**
    *Receive red value from form
     *
    *@private
     */	
	__setRedColorFromForm:function(e)
	{
	if(document.all)e=event;
	var src=DHTMLSuite.commonObj.getSrcElement(e);
	var red=src.value;	
	if(red.match(/^[0-9]+$/)){
		if(red/1>255)red=255;
	}else{
		red=0;
	}
	src.value=red;
	this.__setHueFromRgbColorsInForm();
	this.__changeViewAfterColorChange();			
	}
	
// }}}
	,
	
// {{{ __setGreenColorFromForm()
    /**
    *Receive green value from form
     *
    *@private
     */	
	__setGreenColorFromForm:function(e)
	{
	if(document.all)e=event;
	var src=DHTMLSuite.commonObj.getSrcElement(e);
	var green=src.value;	
	var green=src.value;	
	if(green.match(/^[0-9]+$/)){
		if(green/1>255)green=255;
	}else{
		green=0;
	}
	src.value=green;
	this.__setHueFromRgbColorsInForm();	
	this.__changeViewAfterColorChange();	
	}
	
// }}}
	,
	
// {{{ __setBlueColorFromForm()
    /**
    *Receive blue value from form
     *
    *@private
     */
	__setBlueColorFromForm:function(e)
	{
	if(document.all)e=event;
	var src=DHTMLSuite.commonObj.getSrcElement(e);
	var blue=src.value;
	var blue=src.value;	
	if(blue.match(/^[0-9]+$/)){
		if(blue/1>255)blue=255;
	}else{
		blue=0;
	}
	src.value=blue;
	this.__setHueFromRgbColorsInForm();		
	}
	
// }}}
	,
	
// {{{ __receiveRgbCodeFromForm()
    /**
    *Receive rgb code from form
     *
    *@private
     */
	__receiveRgbCodeFromForm:function(e)
	{
	if(document.all)e=event;
	var src=DHTMLSuite.commonObj.getSrcElement(e);
	var rgbCode=src.value;
	if(!rgbCode.match(/^[0-9A-F][0-9A-F][0-9A-F][0-9A-F][0-9A-F][0-9A-F]$/i)){
		rgbCode='FF0000';
	}
	var hsv=this.colorHelper.getHsvByRgbCode(rgbCode);
	this.currentHue=Math.round(hsv.hue);
	this.currentSaturation=Math.round(hsv.saturation*100);
	this.currentBrightness=Math.round(hsv.brightness*100);
	this.__changeViewAfterColorChange();
	}
	
// }}}
	,
	
// {{{ __receiveHueFromForm()
    /**
    *Receive hue from form
     *
    *@private
     */
	__receiveHueFromForm:function(e)
	{
	if(document.all)e=event;
	var src=DHTMLSuite.commonObj.getSrcElement(e);
	var hue=src.value;
	hue=hue+'';
	if(hue.match(/^[0-9]+$/)){
		if(hue/1>360)hue=360;
	}else{
		hue=0;
	}	
	if(hue==360)hue=0;
	this.currentHue=hue;
	src.value=hue;
	this.__changeViewAfterColorChange();	
	}
	
// }}}
	,
	
// {{{ __receiveBriFromForm()
    /**
    *Receive brightness from form
     *
    *@private
     */
	__receiveBriFromForm:function(e)
	{
	if(document.all)e=event;
	var src=DHTMLSuite.commonObj.getSrcElement(e);
	var brightness=src.value;
	brightness=brightness+'';
	if(brightness.match(/^[0-9]+$/)){
		if(brightness/1>100)brightness=100;
	}else{
		brightness=0;
	}
	this.currentBrightness=brightness;
	src.value=brightness;
	this.__changeViewAfterColorChange();	
	}
	
// }}}
	,
	
// {{{ __receiveSatFromForm()
    /**
    *Receive saturation from form
     *
    *@private
     */
	__receiveSatFromForm:function(e)
	{
	if(document.all)e=event;
	var src=DHTMLSuite.commonObj.getSrcElement(e);
	var saturation=src.value;
	saturation=saturation+'';
	if(saturation.match(/^[0-9]+$/)){
		if(saturation/1>100)saturation=100;
	}else{
		saturation=0;
	}
	this.currentSaturation=saturation;
	src.value=saturation;
	this.__changeViewAfterColorChange();
	
	}
	
// }}}
	,
	
// {{{ __ffHackWinWidget()
    /**
    *Firefox hack-should be replaced when we find a good way to extract the correct x and y position of an element. The current DHTMLSuite.getLeftPos function doesn't work well there.
     *
    *@private
     */	
	__ffHackWinWidget:function()
	{
	if(this.divElement.parentNode.className&&this.divElement.parentNode.className.indexOf('windowContent')>=0&&!document.all){
		this.circleOffsetBecauseOfWinWidget=0; 
// Firefox hack because of problems with the getLeftPos()method. Need to figure out a better way to do this. the getLeftPos method returns wrong position in Firefox for window widget content
	}		
	}
	
// }}}
	,
	__initHorHueMove:function(e)
	{
	this.hueHorStatus=1;
	this.__ffHackWinWidget();
	this.posXHorHue=DHTMLSuite.commonObj.getLeftPos(this.divElHueBarHorizontal);	
	DHTMLSuite.commonObj.__setTextSelOk(false);
	this.__moveOnHorizHueBar(e);	
	return false;
	}	
	
// }}}
	,
	__initHueMove:function(e)
	{
	this.hueStatus=1;
	this.poxYHue=DHTMLSuite.commonObj.getTopPos(this.divElHueBar);
	DHTMLSuite.commonObj.__setTextSelOk(false);
	this.__moveOnHueBar(e);	
	return false;
	}	
	
// }}}
	,
	
// {{{ __initPaletteMove()
    /**
    *Initiate move on palette.
     *
    *@private
     */	
	__initPaletteMove:function(e)
	{
	if(document.all)e=event;
	this.__ffHackWinWidget();
	
// Cache x and y position position of palette	
	this.posdivElPalette.x=DHTMLSuite.commonObj.getLeftPos(this.divElPalette)+this.circleOffsetBecauseOfWinWidget;
	this.posdivElPalette.y=DHTMLSuite.commonObj.getTopPos(this.divElPalette)+this.circleOffsetBecauseOfWinWidget;	
	this.dragStatus=1;	
	
	this.paletteMaxX=(this.divElPalette.clientWidth -this.circleOffsetSize); 
	this.paletteMaxY=(this.divElPalette.clientHeight -this.circleOffsetSize); 
	this.__moveOnPalette(e);	
	DHTMLSuite.commonObj.__setTextSelOk(false);
	return false;	
	}
	
// }}}
	,
	
// {{{ __setCurrentRgbCode()
    /**
    *Save current rgb code
     *
    *@private
     */	
	__setCurrentRgbCode:function()
	{
	this.currentRgbCode=this.colorHelper.getRgbCodeByHsv(this.currentHue,this.currentSaturation/100,this.currentBrightness/100);

	}
	
// }}}
	,
	
// {{{ __endDrag()
    /**
    *End moving circle on palette
     *
    *@private
     */	
	__endDrag:function()
	{
	if(this.dragStatus==1){
		this.__updateHsvInForm();
		this.__updateRgbInForm();
	}		
	this.dragStatus=0;
	this.hueHorStatus=0;
	this.hueStatus=0;
	
	

			
	DHTMLSuite.commonObj.__setTextSelOk(true);
	}
	
// }}}
	,
	
// {{{ __moveOnPalette()
    /**
    *Click on palette
     *
    *@private
     */	
	__moveOnPalette:function(e)
	{
	if(this.dragStatus!=1)return;
	if(this.clickOnPaletteInProgress)return;
	this.clickOnPaletteInProgress= true;	
	if(document.all)e=event;	
	var leftEl=this.posdivElPalette.x;
	var topEl=this.posdivElPalette.y;		
	
	var left=e.clientX+ document.documentElement.scrollLeft-leftEl -this.circleOffsetSize;
	var top=e.clientY+document.documentElement.scrollTop-topEl -this.circleOffsetSize;
	
	if(left<this.circleOffsetSize*-1)left=this.circleOffsetSize*-1;
	if(top<this.circleOffsetSize*-1)top=this.circleOffsetSize*-1;
	
	if(left>this.paletteMaxX)left=this.paletteMaxX;
	if(top>this.paletteMaxY)top=this.paletteMaxY;		
	
	this.divElPaletteCircle.style.left=left+'px';
	this.divElPaletteCircle.style.top=top+'px';
	
	this.currentSaturation=Math.round(((left+this.circleOffsetSize)/ this.paletteSize)* 100);
	this.currentBrightness=100-Math.round(((top+this.circleOffsetSize)/ this.paletteSize)* 100);
	
	this.__setCurrentRgbCode();
	this.__setBgColorPreviewDiv();
	
	if(this.updateFormDuringMoveOnPalette){
		this.__updateHsvInForm();
		this.__updateRgbInForm();	
	}
	this.clickOnPaletteInProgress=false;	
	}
	
// }}}
	,
	
// {{{ __handleCallback()
    /**
    *Handle/Evaluate call back
     *
    *@private
     */	
	__handleCallback:function(action)
	{
	var callbackString='';
	switch(action){
		case 'rgbChange':
		if(this.callbackOnChangeRgb)callbackString=this.callbackOnChangeRgb;
		break;	
		
	}	
	if(callbackString){
		callbackString=callbackString+'({ rgb:"#"+this.currentRgbCode,hue:this.currentHue,brightness:this.currentBrightness,saturation:this.currentSaturation })';
		eval(callbackString);	
	}
	}	
}
