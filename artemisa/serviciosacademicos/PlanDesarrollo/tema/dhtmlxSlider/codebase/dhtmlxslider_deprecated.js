/*
Product Name: dhtmlxSlider 
Version: 5.0 
Edition: Standard 
License: content of this file is covered by GPL. Usage outside GPL terms is prohibited. To obtain Commercial or Enterprise license contact sales@dhtmlx.com
Copyright UAB Dinamenta http://www.dhtmlx.com
*/

window.dhtmlxAjax={get:function(a,c,b){if(b){return dhx4.ajax.getSync(a)}else{dhx4.ajax.get(a,c)}},post:function(a,b,d,c){if(c){return dhx4.ajax.postSync(a,b)}else{dhx4.ajax.post(a,b,d)}},getSync:function(a){return dhx4.ajax.getSync(a)},postSync:function(a,b){return dhx4.ajax.postSync(a,b)}};window.dhtmlxSlider=window.dhtmlXSlider;dhtmlXSlider.prototype.setOnChangeHandler=function(a){if(typeof a=="function"){this.attachEvent("onChange",a)}};dhtmlXSlider.prototype.init=function(){};dhtmlXSlider.prototype.setImagePath=function(){};