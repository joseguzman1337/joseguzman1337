if(!window.DHTMLSuite)var DHTMLSuite=new Object();/************************************************************************************************************
*	DHTML menu item class
*
*	Created:			October, 21st, 2006
*	@class Purpose of class:	Creates the HTML for a single menu item.
*		
*	Css files used by this script:	menu-item.css
*
*	Demos of this class:		demo-menu-strip.html
*
* 	Update log:
*
************************************************************************************************************/

/**
* @constructor
* @class Purpose of class:	Creates the div(s)for a menu item. This class is used by the menuBar class. You can 
*	also create a menu item and add it where you want on your page. the createItem()method will return the div
*	for the item. You can use the appendChild()method to add it to your page. 
*
* @version 1.0
* @author	Alf Magne Kalleland(www.dhtmlgoodies.com)
*/


DHTMLSuite.menuItem=function(){
	var layoutCSS;	
	var divElement;				
// the <div> element created for this menu item
	var expandElement;			
// Reference to the arrow div (expand sub items)
	var cssPrefix;				
// Css prefix for the menu items.
	var modelItemRef;			
// Reference to menuModelItem
	
	this.layoutCSS='menu-item.css';
	this.cssPrefix='DHTMLSuite_';
	
	try{
	if(!standardObjectsCreated)DHTMLSuite.createStandardObjects();	
	}catch(e){
	alert('You need to include the dhtmlSuite-common.js file');
	}
	
	var objectIndex;
	this.objectIndex=DHTMLSuite.variableStorage.arrayDSObjects.length;

	
}

DHTMLSuite.menuItem.prototype=
{
	
	/*
	*	Create a menu item.
	*
	*	@param menuModelItem menuModelItemObj=An object of class menuModelItem
	*/
	createItem:function(menuModelItemObj)
	{
	DHTMLSuite.commonObj.loadCSS(this.layoutCSS);	
// Load css
	
	DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex]=this;
		
	this.modelItemRef=menuModelItemObj;
	
	this.divElement='DHTMLSuite_menuItem'+menuModelItemObj.id;
	
	var div=document.createElement('DIV');	
// Create main div
	document.body.appendChild(div);
	div.id=this.divElement;	
// Giving this menu item it's unque id
	div.className=this.cssPrefix+'menuItem_'+menuModelItemObj.type+'_regular'; 
	div.onselectstart=function(){ return false; };
	if(menuModelItemObj.helpText){	
// Add "title" attribute to the div tag if helpText is defined
		div.title=menuModelItemObj.helpText;
	}
	
	
// Menu item of type "top"
	if(menuModelItemObj.type=='top'){		
		this.__createMenuElementsOfTypeTop(div);
	}

	if(menuModelItemObj.type=='sub'){
		this.__createMenuElementsOfTypeSub(div);
	}
	
	if(menuModelItemObj.separator){
		div.className=this.cssPrefix+'menuItem_separator_'+menuModelItemObj.type;
		div.innerHTML='<span></span>';
	}else{	
		/* Add events */
		var tmpVar=this.objectIndex/1;
		div.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[tmpVar].__navigate(e); }
		div.onmousedown=this.__clickMenuItem;		
// on mouse down effect
		div.onmouseup=this.__rolloverMenuItem;	
// on mouse up effect
		div.onmouseover=this.__rolloverMenuItem;	
// mouse over effect
		div.onmouseout=this.__rolloutMenuItem;	
// mouse out effect.
		
	}
	DHTMLSuite.commonObj.__addEventEl(div);
	return div;
	}
	
// }}}
	,
	
// {{{ setLayoutCss()
    /**
     *	Creates the different parts of a menu item of type "top".
     *
    * @param String newLayoutCss=Name of css file used for the menu items.
     *
    *@public	
     */	
	setLayoutCss:function(newLayoutCss)
	{
	this.layoutCSS=newLayoutCss;
	
	}
	
// }}}
	,
	
// {{{ __createMenuElementsOfTypeTop()
    /**
     *	Creates the different parts of a menu item of type "top".
     *
    * @param menuModelItem menuModelItemObj=Object of type menuModelItemObj
    * @param Object parentEl=Reference to parent element
     *
    *@private	
     */	
	__createMenuElementsOfTypeTop:function(parentEl){
	if(this.modelItemRef.itemIcon){
		var iconDiv=document.createElement('DIV');
		iconDiv.innerHTML='<img src="'+this.modelItemRef.itemIcon+'">';
		iconDiv.id='menuItemIcon'+this.modelItemRef.id
		parentEl.appendChild(iconDiv);	
	}
	if(this.modelItemRef.itemText){
		var div=document.createElement('DIV');
		div.innerHTML=this.modelItemRef.itemText;	
		div.className=this.cssPrefix+'menuItem_textContent';
		div.id='menuItemText'+this.modelItemRef.id;	
		parentEl.appendChild(div);
	}
	if(this.modelItemRef.hasSubs){
		/* Create div for the arrow -> Show sub items */
		var div=document.createElement('DIV');
		div.className=this.cssPrefix+'menuItem_top_arrowShowSub';
		div.id='DHTMLSuite_menuBar_arrow'+this.modelItemRef.id;
		parentEl.appendChild(div);
		this.expandElement=div.id;
	}
		
	}
	
// }}}
	,	
	
	
// {{{ __createMenuElementsOfTypeSub()
    /**
     *	Creates the different parts of a menu item of type "sub".
     *
    * @param menuModelItem menuModelItemObj=Object of type menuModelItemObj
    * @param Object parentEl=Reference to parent element
     *
    *@private	
     */	
	__createMenuElementsOfTypeSub:function(parentEl){	
	if(this.modelItemRef.itemIcon){
		parentEl.style.backgroundImage='url(\''+this.modelItemRef.itemIcon+'\')';	
		parentEl.style.backgroundRepeat='no-repeat';
		parentEl.style.backgroundPosition='left center';	
	}
	if(this.modelItemRef.itemText){
		var div=document.createElement('DIV');
		div.className='DHTMLSuite_textContent';
		div.innerHTML=this.modelItemRef.itemText;	
		div.className=this.cssPrefix+'menuItem_textContent';
		div.id='menuItemText'+this.modelItemRef.id;
		parentEl.appendChild(div);
	}
	
	if(this.modelItemRef.hasSubs){
		/* Create div for the arrow -> Show sub items */
		var div=document.createElement('DIV');
		div.className=this.cssPrefix+'menuItem_sub_arrowShowSub';
		parentEl.appendChild(div);	
		div.id='DHTMLSuite_menuBar_arrow'+this.modelItemRef.id;
		this.expandElement=div.id;
		div.previousSibling.style.paddingRight='15px';	
	}
	}
	
// }}}
	,
	
// {{{ setCssPrefix()
    /**
     *	Set css prefix for the menu item. default is 'DHTMLSuite_'. This is useful in case you want to have different menus on a page with different layout.
     *
    * @param String cssPrefix=New css prefix. 
     *
    *@public	
     */	
	setCssPrefix:function(cssPrefix)
	{
	this.cssPrefix=cssPrefix;
	}
	
// }}}
	,
	
// {{{ setMenuIcon()
    /**
     *	Replace menu icon.
     *
     *	@param String newPath-Path to new icon (false if no icon);
     *
    *@public	
     */	
	setIcon:function(newPath)
	{
	this.modelItemRef.setIcon(newPath);
	if(this.modelItemRef.type=='top'){	
// Menu item is of type "top"
		var div=document.getElementById('menuItemIcon'+this.modelItemRef.id);	
// Get a reference to the div where the icon is located.
		var img=div.getElementsByTagName('IMG')[0];	
// Find the image
		if(!img){	
// Image doesn't exists ?
		img=document.createElement('IMG');	
// Create new image
		div.appendChild(img);
		}
		img.src=newPath;	
// Set image path
		if(!newPath)DHTMLSuite.discardElement(img);	
// No newPath defined, remove the image.		
	}
	if(this.modelItemRef.type=='sub'){	
// Menu item is of type "sub"
		document.getElementById(this.divElement).style.backgroundImage='url(\''+newPath+'\')';	
// Set backgroundImage for the main div(i.e. menu item div)	
	}	
	}
	
// }}}
	,
	
// {{{ setText()
    /**
     *	Replace the text of a menu item
     *
     *	@param String newText-New text for the menu item.
     *
    *@public	
     */	
	setText:function(newText)
	{
	this.modelItemRef.setText(newText);
	document.getElementById('menuItemText'+this.modelItemRef.id).innerHTML=newText;
	
	
	}
	
	
// }}}
	,
	
// {{{ __clickMenuItem()
    /**
     *	Effect-click on menu item
     *
     *
    *@private	
     */	
	__clickMenuItem:function()
	{
	this.className=this.className.replace('_regular','_click');
	this.className=this.className.replace('_over','_click');
	}
	
// }}}	
	,	
	
// {{{ __rolloverMenuItem()
    /**
     *	Roll over effect
     *
     *
    *@private	
     */	
	__rolloverMenuItem:function()
	{
	this.className=this.className.replace('_regular','_over');
	this.className=this.className.replace('_click','_over');
	}	
	
// }}}
	,	
	
// {{{ __rolloutMenuItem()
    /**
     *	Roll out effect
     *
     *
    *@private	
     */	
	__rolloutMenuItem:function()
	{
	this.className=this.className.replace('_over','_regular');
	
	}
	
// }}}
	,	
	
// {{{ setState()
    /**
     *	Set state of a menu item.
     *
     *	@param String newState=New state for the menu item
     *
    *@public	
     */	
	setState:function(newState)
	{
	document.getElementById(this.divElement).className=this.cssPrefix+'menuItem_'+this.modelItemRef.type+'_'+newState; 	
	this.modelItemRef.setState(newState);
	}
	
// }}}
	,
	
// {{{ getState()
    /**
     *	Return state of a menu item. 
     *
     *
    *@public	
     */	
	getState:function()
	{
	var state=this.modelItemRef.getState();
	if(!state){
		if(document.getElementById(this.divElement).className.indexOf('_over')>=0)state='over';	
		if(document.getElementById(this.divElement).className.indexOf('_click')>=0)state='click';	
		this.modelItemRef.setState(state);	
	}
	return state;
	}	
	
// }}}
	,
	
// {{{ __setHasSub()
    /**
     *	Update the item, i.e. show/hide the arrow if the element has subs or not. 
     *
     *
    *@private	
     */	
    __setHasSub:function(hasSubs)
    {
    	this.modelItemRef.hasSubs=hasSubs;
    	if(!hasSubs){
    	document.getElementById(this.cssPrefix +'menuBar_arrow'+this.modelItemRef.id).style.display='none';    	
    	}else{
    	document.getElementById(this.cssPrefix +'menuBar_arrow'+this.modelItemRef.id).style.display='block';
    	}    	
    }
    
// }}}	
    ,
	
// {{{ hide()
    /**
     *	Hide the menu item.
     *
     *
    *@public	
     */	    
    hide:function()
    {
    	this.modelItemRef.setVisibility(false);
    	document.getElementById(this.divElement).style.display='none';    	
    }    
    ,
 	
// {{{ show()
    /**
     *	Show the menu item.
     *
     *
    *@public	
     */	     
    show:function()
    {
    	this.modelItemRef.setVisibility(true);
    	document.getElementById(this.divElement).style.display='block';    	
    }    
	
// }}}
	,
	
// {{{ __hideGroup()
    /**
     *	Hide the group the menu item is a part of. Example: if we're dealing with menu item 2.1, hide the group for all sub items of 2
     *
     *
    *@private	
     */		
	__hideGroup:function()
	{	
	if(this.modelItemRef.parentId){
		document.getElementById(this.divElement).parentNode.style.visibility='hidden';	
		if(DHTMLSuite.clientInfoObj.isMSIE){
		try{
			var tmpId=document.getElementById(this.divElement).parentNode.id.replace(/[^0-9]/gi,'');
			document.getElementById('DHTMLSuite_menuBarIframe_'+tmpId).style.visibility='hidden';
		}catch(e){
			
// IFRAME hasn't been created.
		}	
		}
	}	

	}
	
// }}}	
	,
	
// {{{ __navigate()
    /**
     *	Navigate after click on a menu item.
     *
     *
    *@private	
     */	
	__navigate:function(e)
	{
	/* Check to see if the expand sub arrow is clicked. if it is, we shouldn't navigate from this click */
	if(document.all)e=event;
	if(e){
		var srcEl=DHTMLSuite.commonObj.getSrcElement(e);
		if(srcEl.id.indexOf('arrow')>=0)return;
	}
	if(this.modelItemRef.state=='disabled')return;
	if(this.modelItemRef.url){
		location.href=this.modelItemRef.url;
	}
	if(this.modelItemRef.jsFunction){
		try{
		eval(this.modelItemRef.jsFunction);
		}catch(e){
		alert('Defined Javascript code for the menu item( '+this.modelItemRef.jsFunction+' )cannot be executed');
		}
	}
	} 
}
