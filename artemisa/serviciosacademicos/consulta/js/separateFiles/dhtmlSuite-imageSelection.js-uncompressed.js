if(!window.DHTMLSuite)var DHTMLSuite=new Object();/************************************************************************************************************
*	DHTML Image enlarger.
*
*	Created:			January, 14th, 2006
*	@class Purpose of class:	Tool for selecting and dragging images
*		
*	Css files used by this script:	image-selection.css
*
*	Demos of this class:		
*
* 	Update log:
*
************************************************************************************************************/
/**
* @constructor
* @class Purpose of class:	Tool to select objects(example: images)by dragging a rectangle around them. The objects will be made dragable<br>
*	Demo: (<a href="../../demos/demo-image-gallery-1.html" target="_blank">Demo</a>)
*
* @version 1.0
* @author	Alf Magne Kalleland(www.dhtmlgoodies.com)
*/

DHTMLSuite.imageSelection=function(){	
	var layoutCSS;	
	var callBackFunction_onDrop;	
// Call back function on drop	
	var objectIndex;
	var divElementSelection;
	var divElementSelection_transparent;
	var selectableEls;
	var selectedEls;			
// Array of selected elements
	var selectableElsScreenProps;
	var collectionModelReference;	
// Reference to media collection ( data source for images )
	var destinationEls;			
// Array of destination elements.
	var currentDestEl;			
// Reference to current destination element
	
	var selectionStatus;		
// -1 when selection isn't in progress, 0 when it's being initialized, 5 when it's ready
	var dragStatus;			
// -1=drag not started, 0-5=drag initializing, 5=drag in process.
	var startCoordinates;
	var selectionResizeInProgress;	
// variable which is true when code for the selection area is running
	var selectionStartArea;		
// Selection can only starts within this element
	var selectionOrDragStartEl;		
// Element triggering drag or selection
	
	this.selectionResizeInProgress=false;
	this.selectionStatus=-1;
	this.dragStatus=-1;
	this.startCoordinates=new Object();
	this.layoutCSS='image-selection.css';
	this.selectableEls=new Array();
	this.destinationEls=new Array();
	this.collectionModelReference=false;
	this.selectableElsScreenProps=new Object();
	this.selectedEls=new Array();
	
	try{
	if(!standardObjectsCreated)DHTMLSuite.createStandardObjects();	
// This line starts all the init methods
	}catch(e){
	alert('You need to include the dhtmlSuite-common.js file');
	}	

	this.objectIndex=DHTMLSuite.variableStorage.arrayDSObjects.length;
	DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex]=this;	
	
}

DHTMLSuite.imageSelection.prototype={
	
// {{{ init()
    /**
     *	Initializes the script
     *
     *
    *@public	
     */	
	init:function()
	{
	try{
		DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
	}catch(e){
		alert('Unable to load css file dynamically. You need to include dhtmlSuite-common.js');
	}
	this.__createdivElementsForSelection();
	this.__createdivElementsForDrag();
	this.__addEvents();
	this.__setSelectableElsScreenProps();
	}
	
// }}}
	,
	
// {{{ addDestinationElement()
    /**
     *	Add single destination element
     *
     *	Object elementReference-Element reference, id of element or the element it's self.
     *
    *@public	
     */	
	addDestinationElement:function(elementReference)
	{
	elementReference=DHTMLSuite.commonObj.getEl(elementReference);
	this.destinationEls[this.destinationEls.length]=elementReference;
	}
	
// }}}
	,
	
// {{{ addselectableEls()
    /**
     *	Add selectable elements
     *
     *	@param Object parentElementReference-id of parent html element or the parent element it's self. all direct children will be dragable
     *	@param String tagName-Which tag, example "td","li" or "a"
     *	@param String className-optional element
     *	@return Boolean success-true if parent element was found, false otherwise.
     *
    *@public	
     */	
	addDestinationElementsByTagName:function(parentElementReference,tagName,className)
	{
	parentElementReference=DHTMLSuite.commonObj.getEl(parentElementReference);
	if(!parentElementReference){
		return false;
	}
	var subs=parentElementReference.getElementsByTagName(tagName);
	for(var no=0;no<subs.length;no++){
		if(className&&subs[no].className!=className)continue;
		this.destinationEls[this.destinationEls.length]=subs[no];	
	}
	this.__addEventsTodestinationEls(subs);
	return true;
	
	}
	
// }}}
	,
	
// {{{ addSelectableElements()
    /**
     *	Add selectable elements
     *
     *	Object parentElementReference-id of parent html element or the parent element it's self. all direct children will be dragable
     *
    *@public	
     */	
	addSelectableElements:function(parentElementReference)
	{
	var obj=DHTMLSuite.commonObj.getEl(parentElementReference);
	var subElement=obj.getElementsByTagName('*')[0];	
	while(subElement){
		this.selectableEls[this.selectableEls.length]=subElement;
		this.__addPropertiesToSelectableElement(subElement);
		subElement=subElement.nextSibling;	
	}	
	}	
	
// }}}
	,
	
// {{{ addSelectableElement()
    /**
     *	Add single selectable element
     *
     *	Object elementReference-id of html element or the reference to the element it's self. all direct children will be dragable
     *
    *@public	
     */	
	addSelectableElement:function(elementReference)
	{
	this.selectableEls[this.selectableEls.length]=DHTMLSuite.commonObj.getEl(elementReference);
	this.__addPropertiesToSelectableElement(elementReference);
	
	}	
	
// }}}
	,
	
// {{{ setCallBackFunctionOnDrop()
    /**
     *	Specify call back function-on drop 
     *	This function will be called when elements are dropped on a destination node
     *	Arguments to this function will be an array of the dragged elements and a reference to the destionation object.
     *
     *
    *@public	
     */	
	setCallBackFunctionOnDrop:function(functionName)
	{
	this.callBackFunction_onDrop=functionName;
	}
	
// }}}
	,
	
// {{{ setSelectionStartArea()
    /**
     *	Restrict where the selection may start.
     *
     *
    *@public	
     */	
	setSelectionStartArea:function(elementReference)
	{
	elementReference=DHTMLSuite.commonObj.getEl(elementReference);
	this.selectionStartArea=elementReference;
	
	}
	
// }}}
	,
	
// {{{ __createdivElementSelectionsForSelection()
    /**
     *	Create div elements for the selection
     *
     *
    *@private	
     */	
	__createdivElementsForSelection:function()
	{
	/* Div elements for selection */
	this.divElementSelection=document.createElement('DIV');
	this.divElementSelection.style.display='none';
	this.divElementSelection.id='DHTMLSuite_imageSelectionSel';	
	this.divElementSelection.innerHTML='<span></span>';
	document.body.insertBefore(this.divElementSelection,document.body.firstChild);
	this.divElementSelection_transparent=document.createElement('DIV');
	this.divElementSelection_transparent.id='DHTMLSuite_imageSelection_transparentDiv';
	this.divElementSelection.appendChild(this.divElementSelection_transparent);
	this.divElementSelection_transparent.innerHTML='<span></span>';
	
	}
	
// }}}
	,
	
// {{{ __setMediaCollectionModelReference()
    /**
     *	Specify media collection model reference. 
     *
     *
    *@private	
     */		
	__setMediaCollectionModelReference:function(collectionModelReference){
	this.collectionModelReference=collectionModelReference;
	}
	,
	
// {{{ __createdivElementsForDrag()
    /**
     *	Create div elements for the drag
     *
     *
    *@private	
     */	
	__createdivElementsForDrag:function()
	{
	/* Div elements for selection */
	this.divElementDrag=document.createElement('DIV');
	this.divElementDrag.innerHTML='<span></span>';
	this.divElementDrag.style.display='none';
	this.divElementDrag.id='DHTMLSuite_imageSelectionDrag';
	document.body.insertBefore(this.divElementDrag,document.body.firstChild);	
	
	this.divElementDragContent=document.createElement('DIV');
	this.divElementDragContent.innerHTML='<span></span>';
	this.divElementDragContent.id='DHTMLSuite_imageSelectionDragContent';
	this.divElementDrag.appendChild(this.divElementDragContent);
	
	var divElementTrans=document.createElement('DIV');
	divElementTrans.className='DHTMLSuite_imageSelectionDrag_transparentDiv';
	this.divElementDrag.appendChild(divElementTrans);
	
	
	}
	
// }}}
	,
	
// {{{ __initImageSelection()
    /**
     *	Mouse down-start selection or drag.
     *
     *
    *@private	
     */	
	__initImageSelection:function(e)
	{
	var initImageSelector;
	if(document.all)e=event;
	var src=DHTMLSuite.commonObj.getSrcElement(e);
	
	if(src.onmousedown){	/* Exception for the drag */	
		
//if(src.onmousedown.toString().indexOf('initImageSelector')<0)return;	
	}
	if(src.className.indexOf('paneSplitter_vertical')>=0||src.className.indexOf('paneSplitter_horizontal')>=0 ){	/* Exception for the drag */
		return;	
	}
	
	this.selectionOrDragStartEl=src;
	this.startCoordinates.x=e.clientX+document.documentElement.scrollLeft+3;
	this.startCoordinates.y=e.clientY+document.documentElement.scrollTop+3; 
			
	if(!this.__isReadyForDrag(e)){	/* Image selection */
		if(!e.shiftKey&&!e.ctrlKey)this.__clearselectedElsArray();
		this.selectionStatus=0;
		this.divElementSelection.style.left=this.startCoordinates.x+'px';
		this.divElementSelection.style.top=this.startCoordinates.y+'px';
		this.divElementSelection.style.width='1px';
		this.divElementSelection.style.height='1px';
		this.__setSelectableElsScreenProps();
		this.__countDownToSelectionStart();
		
	}else{	/* Drag selected images */
		this.divElementDrag.style.left=this.startCoordinates.x+'px';
		this.divElementDrag.style.top=this.startCoordinates.y+'px';		
		this.dragStatus=0;	
		this.__countDownToDragStart();
		
		
	}	
	
	return false;	
	}
	
// }}}
	,
	
// {{{ __isReadyForDrag()
    /**
     *	A small delay before selection starts.
     *
     *
    *@private	
     */	
	__isReadyForDrag:function(e)
	{
	var src=DHTMLSuite.commonObj.getObjectByAttribute(e,'DHTMLSuite_selectableElement');
	if(!src)return false;
	if(this.selectedEls.length>0)return true;
	return false;
	
	}
	
// }}}
	,
	
// {{{ __countDownToDragStart()
    /**
     *	A small delay before drag starts.
     *
     *
    *@private	
     */	
	__countDownToDragStart:function()
	{
	if(this.dragStatus>=0&&this.dragStatus<5){
		var ind=this.objectIndex;
		this.dragStatus++;
		var timeOut=60;
		if(this.selectedEls.length>1)timeOut=10;
		setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__countDownToDragStart()',timeOut);		
	}
	if(this.dragStatus==5){
		this.__fillDragBoxWithSelectedItems();
		this.divElementDrag.style.display='block';	
// Show selection box.
	}
	
	}
	
// }}}
	,
	
// {{{ __fillDragBoxWithSelectedItems()
    /**
     *	Fill drag box with selected items.
     *
     *
    *@private	
     */		
	__fillDragBoxWithSelectedItems:function()
	{
	this.divElementDragContent.innerHTML='';
	if(this.collectionModelReference){	/* Media model exists */
		
		for(var no=0;no<this.selectedEls.length;no++){
		var obj=this.selectedEls[no];
		var mediaRefId=obj.getAttribute('mediaRefId');
		if(!mediaRef)mediaRef=obj.mediaRefId;
		var mediaRef=this.collectionModelReference.getMediaById(mediaRefId);
		

		var div=document.createElement('DIV');
		div.innerHTML='<span></span>';
		div.className='DHTMLSuite_imageSelectionDragBox';
		div.style.backgroundImage='url(\''+mediaRef.thumbnailPathSmall+'\')';
		this.divElementDragContent.appendChild(div);
		}		
	}else{	/* No media model-Just clone the node-May have to figure out something more clever here as this hasn't been tested fully yet */
		for(var no=0;no<this.selectedEls.length;no++){
		var el=this.selectedEls.cloneNode(true);	
		this.divElementDragContent.appendChild(el);		
		}		
	}	
	}
	
// }}}
	,
	
// {{{ __countDownToSelectionStart()
    /**
     *	A small delay before selectino starts.
     *
     *
    *@private	
     */	
	__countDownToSelectionStart:function()
	{
	if(this.selectionStatus>=0&&this.selectionStatus<5){
		var ind=this.objectIndex;
		this.selectionStatus++;
		setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__countDownToSelectionStart()',10);	
	}
	if(this.selectionStatus==5)this.divElementSelection.style.display='block';	
// Show selection box.
	return false;
	}
	
// }}}
	,
	
// {{{ __moveDragBox()
    /**
     *	Move div with the dragged elements
     *
     *
    *@private	
     */	
	__moveDragBox:function(e)
	{	
	if(this.dragStatus<5)return;	
	if(document.all)e=event;
	this.divElementDrag.style.left=(this.startCoordinates.x+(e.clientX+3-this.startCoordinates.x))+'px';		
	this.divElementDrag.style.top=(this.startCoordinates.y+(e.clientY+3-this.startCoordinates.y))+'px';		
	}
	
// }}}	
	,
	
// {{{ __resizeSelectionDivBox()
    /**
     *	Resize selection div box.
     *
     *
    *@private	
     */	
	__resizeSelectionDivBox:function(e)
	{
	if(this.selectionStatus<5)return;	
// Selection in progress ?
	if(this.selectionResizeInProgress)return;	
// If this function is allready running, don't start another iteration until it's finished.
			
	this.selectionResizeInProgress=true;	
// Selection code is running!

	if(document.all)e=event;
	var width=e.clientX-this.startCoordinates.x;
	var height=e.clientY+document.documentElement.scrollTop-this.startCoordinates.y;
	
	if(width>0){
		this.divElementSelection.style.left=(this.startCoordinates.x)+'px'; 	
		this.divElementSelection.style.width=width+'px'; 	
		
	}else{
		this.divElementSelection.style.width=(this.startCoordinates.x-(this.startCoordinates.x+width))+'px'; 	
		this.divElementSelection.style.left =(this.startCoordinates.x+width)+'px'; 
	}		
	if(height>0){
		this.divElementSelection.style.top=(this.startCoordinates.y)+'px'; 	
		this.divElementSelection.style.height=height+'px'; 
	}else{
		this.divElementSelection.style.height=(this.startCoordinates.y-(this.startCoordinates.y+height))+'px'; 	
		this.divElementSelection.style.top =(this.startCoordinates.y+height)+'px'; 
	}
	
// this.__clearselectedElsArray();
	this.__highlightElementsWithinSelectionArea();
	this.selectionResizeInProgress=false;
	}
	
// }}}
	,
	
// {{{ __clearSingleElementFromSelectedArray()
    /**
     *	Clear a single element from the selected array
     *
    * @param Object-HTML element
     *
    *@private	
     */	
	__clearSingleElementFromSelectedArray:function(el)
	{
	for(var no=0;no<this.selectedEls.length;no++){
		if(this.selectedEls[no]==el){
		this.selectedEls[no].className=this.selectedEls[no].className.replace(' imageSelection','');
		this.selectedEls.splice(no,1);
		return;
		}
	}	
	}
	
// }}}
	,
	
// {{{ __clearselectedElsArray()
    /**
     *	Remove highlight effect from all previous selected elements.
     *
     *
    *@private	
     */	
	__clearselectedElsArray:function()
	{
	
	for(var no=0;no<this.selectedEls.length;no++){
		if(this.selectedEls[no].className.indexOf('imageSelection')>=0)this.selectedEls[no].className=this.selectedEls[no].className.replace(' imageSelection','');
	}	
	this.selectedEls=new Array();	
	}
	
// }}}
	,
	
// {{{ __highlightElementsWithinSelectionArea()
    /**
     *	Loop through selectable elements and highlight those within the selection area.
     *
     *
    *@private	
     */	
	__highlightElementsWithinSelectionArea:function()
	{	
	var x1=this.divElementSelection.style.left.replace('px','')/1;
	var y1=this.divElementSelection.style.top.replace('px','')/1;
	var x2=x1+this.divElementSelection.style.width.replace('px','')/1;
	var y2=y1+this.divElementSelection.style.height.replace('px','')/1;
	for(var no=0;no<this.selectableEls.length;no++){
		if(this.__isElementWithinSelectionArea(this.selectableEls[no],x1,y1,x2,y2)){
		this.__addSelectedElement(this.selectableEls[no]);
		}else{
		this.__clearSingleElementFromSelectedArray(this.selectableEls[no]);
		}
	}	
	}
	
// }}}
	,
	
// {{{ __isElementInSelectedArray()
    /**
     *	Is element allready added to the selected item array ?
     *
     *
    *@private	
     */	
	__isElementInSelectedArray:function(el)
	{
	for(var no=0;no<this.selectedEls.length;no++){	/* element allready added?*/
		if(this.selectedEls[no]==el)return true;
	}	
	return false;	
	}
	,
	
// {{{ __addSelectedElement()
    /**
     *	Highlight element and add it to the collection of selected elements.
     *
     *
    *@private	
     */	
	__addSelectedElement:function(el)
	{
	if(el.className.indexOf('imageSelection')==-1){
		if(el.className)
		el.className=el.className+' imageSelection';	
// Adding " imageSelection" to the class name
		else
		el.className='imageSelection';
	}
	if(this.__isElementInSelectedArray(el))return;	
	this.selectedEls[this.selectedEls.length]=el;	
// Add element to selected elements array
	
	}
	
// }}}
	,
	
// {{{ __setSelectableElsScreenProps()
    /**
     *	Save selectable elements x,y, width and height-this is done when the selection process is initiated. 
     *
     *	@return Boolean element within selection area. If the selection box is over an element, return true, otherwise return false
     *
    *@private	
     */	
	__isElementWithinSelectionArea:function(el,x1,y1,x2,y2)
	{	
	var elX1=this.selectableElsScreenProps[el.id].x;
	var elY1=this.selectableElsScreenProps[el.id].y;
	var elX2=this.selectableElsScreenProps[el.id].x+this.selectableElsScreenProps[el.id].width;
	var elY2=this.selectableElsScreenProps[el.id].y+this.selectableElsScreenProps[el.id].height;
	
	/*	
	ILLUSTRATION-Image boxes within the boundaries of a selection area.
	
	|-----------|   |-----------|   |-----------|
	|	BOX	|	|	BOX	|	|	BOX	|
	|	|-----------------------------------|	|
	|	|	|	|		|	|	|	|
	|---|-------|   |-----------|	|-----------|
		|	SELECTION AREA			|	
		|					|	
	|-----------|	|-----------|	|-----------|
	|	|	BOX	|	|	BOX	|	|	BOX	|	|
	|	|	|	|		|	|	|	|
	|	|	|	|		|	|	|	|
	|-----------|	|-----------|	|-----------|
		|					|
		|					|	
	|-----------|	|-----------|	|-----------|
	|	|	|	|		|	|	|	|
	|	|-------|---|-----------|---|-------|	|
	|BOX	|	|BOX	|	|	BOX	|	|
	|-----------|	|-----------|	|-----------|	
	
	*/
	if(elX2<x1)return false;
	if(elY2<y1)return false;
	if(elX1>x2)return false;
	if(elY1>y2)return false;
	if((elY1<=y1&&elY2>=y1)||(elY1>=y1&&elY2<=y2)||(elY1<=y2&&elY2>=y2)){	/* Y coordinates of element within selection area */
		if(elX1<=x1&&elX2>=x1)return true;	/* left edge of element at the left of selection area, but right edge within */
		if(elX1>=x1&&elX2<=x2)return true;	/* Both left and right edge of element within selection area */
		if(elX1<=x2&&elX2>=x2)return true;	/* Left edge of element within selection area, but right element outside */	
	}
	
	return false;
	
	}
	
// }}}
	,
	
// {{{ __setSelectableElsScreenProps()
    /**
     *	Save selectable elements x,y, width and height-this is done when the selection process is initiated. 
     *
     *
    *@private	
     */	
	__setSelectableElsScreenProps:function()
	{

	for(var no=0;no<this.selectableEls.length;no++){
		var obj=this.selectableEls[no];
		if(!obj.parentNode){	
// Element has been deleted from the view ?
		this.selectableEls.splice(no,1);
		this.__setSelectableElsScreenProps();
		return;		
		}
		var id=obj.id;
		this.selectableElsScreenProps[id]=new Object();
		var ref=this.selectableElsScreenProps[id];
		ref.x=DHTMLSuite.commonObj.getLeftPos(obj);
		ref.y=DHTMLSuite.commonObj.getTopPos(obj);
		ref.width=obj.offsetWidth;
		ref.height=obj.offsetHeight;
	}
		
	}
	
// }}}
	,
	
// {{{ __endImageSelection()
    /**
     *	Mouse up event-hide the rectangle
     *
     *
    *@private	
     */	
	__endImageSelection:function(e)
	{
	if(document.all)e=event;
	if(this.selectionStatus>=0){
		this.divElementSelection.style.display='none';
		if(this.__isReadyForDrag(e)&&this.selectionStatus==-1)this.__clearselectedElsArray();
		this.selectionStatus=-1;	
	}
	if(this.dragStatus>=0){		
		var src=DHTMLSuite.commonObj.getSrcElement(e);
		if(this.currentDestEl)this.__handleCallBackFunctions('drop');	
		this.divElementDrag.style.display='none';		
		if(src!=this.selectionOrDragStartEl||!src.className)this.__clearselectedElsArray();	
		this.__deselectDestinationElement();	
		this.dragStatus=-1;		
	}	
	}
	
// }}}
	,
	
// {{{ __handleCallBackFunctions()
    /**
     *	Handle call back function, i.e. evaluate js
     *	 
     *	String action-Which call back
     *
    *@private	
     */	
	__handleCallBackFunctions:function(action)
	{
	var callbackString='';
	switch(action)
	{
		case 'drop':
		if(this.callBackFunction_onDrop)callbackString=this.callBackFunction_onDrop;
		break;
		
	}
	
	if(callbackString)eval(callbackString+'(this.selectedEls,this.currentDestEl)');
	
	}
	
// }}}
	,
	
// {{{ __deselectDestinationElement()
    /**
     *	Mouse away from destination element
     *	Deselect it and clear the property currentDestEl  
     *
     *
    *@private	
     */	
	__deselectDestinationElement:function(e)
	{
	if(this.dragStatus<5)return;
	if(!this.currentDestEl)return;
	if(document.all)e=event;
	
	if(e&&!DHTMLSuite.commonObj.isObjectClicked(this.currentDestEl,e))return;
	
	this.currentDestEl.className=this.currentDestEl.className.replace(' imageSelection','');
	this.currentDestEl.className=this.currentDestEl.className.replace('imageSelection','');
	this.currentDestEl=false;
	}
	
// }}}
	,
	
// {{{ __selectDestinationElement()
    /**
     *	Mouse over a destination element. 
     *
     *
    *@private	
     */	
	__selectDestinationElement:function(e){
	if(this.dragStatus<5)return;
	if(document.all)e=event;
	var src=DHTMLSuite.commonObj.getObjectByAttribute(e,'imageSelectionDestination');
	this.currentDestEl=src;
	if(this.currentDestEl.className)
		this.currentDestEl.className=this.currentDestEl.className+' imageSelection';
	else
		this.currentDestEl.className='imageSelection';	
	}
	
// }}}
	,
	
// {{{ __selectSingleElement()
    /**
     *	Mouse down on a specific element
     *
     *
    *@private	
     */	
	__selectSingleElement:function(e,eventType)
	{
	
	if(document.all)e=event;
	var src=DHTMLSuite.commonObj.getObjectByAttribute(e,'DHTMLSuite_selectableElement');
	
	var elementAllreadyInSelectedArray =this.__isElementInSelectedArray(src); 
	if(!e.ctrlKey&&!elementAllreadyInSelectedArray)this.__clearselectedElsArray();
	if(e.ctrlKey&&elementAllreadyInSelectedArray){
		this.__clearSingleElementFromSelectedArray(src);		
	}else{
		this.__addSelectedElement(src);	
	}
	
	}
	
// }}}
	,
	
// {{{ __addPropertiesToSelectableElement()
    /**
     *	Add mouse down event and assigne custom property to selectable element.
     *
     *
    *@private	
     */	
	__addPropertiesToSelectableElement:function(elementReference)
	{
	var ind=this.objectIndex;
	elementReference.onmousedown=function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__selectSingleElement(e); };
	
//DHTMLSuite.commonObj.addEvent(elementReference,'mousedown',function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__selectSingleElement(e,'mousedown'); });	
// Add click event to single element
	elementReference.setAttribute('DHTMLSuite_selectableElement','1');	
	this.__addOnScrollEventsToSelectableEls(elementReference);	
	}	
	
// }}}
	,
	
// {{{ __addEventsTodestinationEls()
    /**
     *	Add mouse over event to destination objects.
     *	
     *	@param Array inputElements-optional-if given, only these elements will be parsed, if not give, all destination elements will be parsed
    *@private	
     */	
	__addEventsTodestinationEls:function(inputElements)
	{
	var ind=this.objectIndex;
	
	if(inputElements){
		for(var no=0;no<inputElements.length;no++){
		inputElements[no].onmouseover=function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__selectDestinationElement(e); };
		inputElements[no].onmouseout=function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__deselectDestinationElement(e); };
		inputElements[no].setAttribute('imageSelectionDestination','1');
		inputElements[no].imageSelectionDestination='1';	
		DHTMLSuite.commonObj.__addEventEl(inputElements[no]);	
		}		
	}else{
		for(var no=0;no<this.destinationEls.length;no++){
		this.destinationEls[no].onmouseover=function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__selectDestinationElement(e); };
		this.destinationEls[no].onmouseout=function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__deselectDestinationElement(e); };
		DHTMLSuite.commonObj.__addEventEl(this.destinationEls[no]);	
		this.destinationEls[no].setAttribute('imageSelectionDestination','1');
		this.destinationEls[no].imageSelectionDestination='1';
		
		}
	}
	
	}
	
// }}}
	,
	
// {{{ __addOnScrollEventsToSelectableEls()
    /**
     *	Don't allow selection on scroll
     *
     *
    *@private	
     */		
	__addOnScrollEventsToSelectableEls:function(el)
	{
	var ind=this.objectIndex;
	var src=el;
	while(src&&src.tagName.toLowerCase()!='body'){
		src=src.parentNode;	
		if(!src.onscroll)DHTMLSuite.commonObj.addEvent(src,'scroll',function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__endImageSelection(e); });
	}		
	}
	
// }}}}
	,
	
// {{{ __addEvents()
    /**
     *	Add basic events for this widget
     *
     *
    *@private	
     */	
	__addEvents:function()
	{
	var ind=this.objectIndex;
	document.documentElement.onselectstart=function(){ return false; };	
// disable text selection
	DHTMLSuite.commonObj.__addEventEl(document.documentElement.onselectstart);
	
	this.destinationEls[no]
	if(this.selectionStartArea){
		DHTMLSuite.commonObj.addEvent(this.selectionStartArea,'mousedown',function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__initImageSelection(e); });
	}else{
		DHTMLSuite.commonObj.addEvent(document.documentElement,'mousedown',function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__initImageSelection(e); });
	}
	DHTMLSuite.commonObj.addEvent(document.documentElement,'mousemove',function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__resizeSelectionDivBox(e); });
	DHTMLSuite.commonObj.addEvent(document.documentElement,'mousemove',function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveDragBox(e); });
	DHTMLSuite.commonObj.addEvent(document.documentElement,'mouseup',function(e){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__endImageSelection(e); });
	DHTMLSuite.commonObj.addEvent(window,'resize',function(){ return DHTMLSuite.variableStorage.arrayDSObjects[ind].__setSelectableElsScreenProps(); });
	
	var imgs=document.getElementsByTagName('IMG');
	for(var no=0;no<imgs.length;no++){
		imgs[no].ondragstart=function(){ return false; };
		if(!imgs[no].onmousedown)imgs[no].onmousedown=function(){ return false; };
		DHTMLSuite.commonObj.__addEventEl(imgs[no]);
	}
	
	this.__addEventsTodestinationEls();

	}
	
}
