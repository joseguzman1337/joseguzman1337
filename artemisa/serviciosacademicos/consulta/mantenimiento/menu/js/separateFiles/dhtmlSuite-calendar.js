if(!window.DHTMLSuite)var DHTMLSuite=new Object();/************************************************************************************************************

*	Calendar model

*

*	Created:			January, 20th, 2007

*	@class Purpose of class:	Handle language parameters for a calendar

*		

* 	Update log:

*

************************************************************************************************************/

/**

* @constructor

* @class Purpose of class:	Store language specific data for calendar.<br>

*	Demo: (<a href="../../demos/demo-calendar-1.html" target="_blank">Demo</a>)

* @version 1.0

* @author	Alf Magne Kalleland(www.dhtmlgoodies.com)

*/

DHTMLSuite.calendarLanguageModel=function(languageCode){

	

	var monthArray;				

// An array of months.

	var monthArrayShort;			

// An array of the months, short version

	var dayArray;				

// An array of the days in a week

	var weekString;				

// String representation of the string "Week"

	var todayString;			

// String representatinon of the string "Today"

	var todayIsString;			

// String representation of the string "Today is"

	var timeString;				

// String representation of the string "Time"

	this.monthArray=new Array();

	this.monthArrayShort=new Array();

	this.dayArray=new Array();

	

	if(!languageCode)languageCode='en';

	this.languageCode=languageCode;

	this.__setCalendarProperties();	

}



DHTMLSuite.calendarLanguageModel.prototype={

	

// {{{ __setCalendarProperties()

    /**

     *	Fill object with string values according to chosen language

     *

    *@private	

     */		

	__setCalendarProperties:function()

	{

	switch(this.languageCode){

		case "ge":	/* German */

		this.monthArray=['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'];

		this.monthArrayShort=['Jan','Feb','Mar','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'];

		this.dayArray=['Mon','Die','Mit','Don','Fre','Sam','Son'];	

		this.weekString='Woche';

		this.todayIsString='Heute';	

		this.todayString='Heute';	

		this.timeString='';

		break;

		case "no":	/* Norwegian */

		this.monthArray=['Januar','Februar','Mars','April','Mai','Juni','Juli','August','September','Oktober','November','Desember'];

		this.monthArrayShort=['Jan','Feb','Mar','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Des'];

		this.dayArray=['Man','Tir','Ons','Tor','Fre','L&oslash;r','S&oslash;n'];	

		this.weekString='Uke';

		this.todayIsString='Dagen i dag er';

		this.todayString='I dag';

		this.timeString='Tid';

		break;	

		case "nl":	/* Dutch */

		this.monthArray=['Januari','Februari','Maart','April','Mei','Juni','Juli','Augustus','September','Oktober','November','December'];

		this.monthArrayShort=['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Okt','Nov','Dec'];

		this.dayArray=['Ma','Di','Wo','Do','Vr','Za','Zo'];

		this.weekString='Week';

		this.todayIsString='Vandaag';

		this.todayString='Vandaag';

		this.timeString='';

		break;	

		case "es": /* Spanish */

		this.monthArray=['Enero','Febrero','Marzo','April','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

		this.monthArrayShort =['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];

		this.dayArray=['Lun','Mar','Mie','Jue','Vie','Sab','Dom'];

		this.weekString='Semana';

		this.todayIsString='Hoy es';

		this.todayString='Hoy';

		this.timeString='';

		break; 	

		case "pt-br":  /* Brazilian portuguese (pt-br)*/

		this.monthArray=['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];

		this.monthArrayShort=['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];

		this.dayArray=['Seg','Ter','Qua','Qui','Sex','S&aacute;b','Dom'];

		this.weekString='Sem.';

		this.todayIsString='Hoje &eacute;';

		this.todayString='Hoje';

		this.timeString='';		

		break;

		case "fr":      /* French */

		this.monthArray=['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];	

		this.monthArrayShort=['Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aou','Sep','Oct','Nov','Dec'];

		this.dayArray=['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'];

		this.weekString='Sem';

		this.todayIsString="Aujourd'hui";

		this.todayString='Aujourd';

		this.timeString='';

		break; 	

		case "da": /*Danish*/

		this.monthArray=['januar','februar','marts','april','maj','juni','juli','august','september','oktober','november','december'];

		this.monthArrayShort=['jan','feb','mar','apr','maj','jun','jul','aug','sep','okt','nov','dec'];

		this.dayArray=['man','tirs','ons','tors','fre','l&oslash;r','s&oslash;n'];

		this.weekString='Uge';

		this.todayIsString='I dag er den';

		this.todayString='I dag';

		this.timeString='Tid';

		break;	

		case "it":	/* Italian*/

		this.monthArray=['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'];

		this.monthArrayShort=['Gen','Feb','Mar','Apr','Mag','Giu','Lugl','Ago','Set','Ott','Nov','Dic'];

		this.dayArray=['Lun','Mar','Mer','Gio','Ven','Sab','Dom'];

		this.weekString='Sett';

		this.todayIsString='Oggi &egrave; il';

		this.todayString='Oggi &egrave; il';

		this.timeString='';

		break;	

		case "sv":	/* Swedish */

		this.monthArray=['Januari','Februari','Mars','April','Maj','Juni','Juli','Augusti','September','Oktober','November','December'];

		this.monthArrayShort=['Jan','Feb','Mar','Apr','Maj','Jun','Jul','Aug','Sep','Okt','Nov','Dec'];

		this.dayArray=['M&aring;n','Tis','Ons','Tor','Fre','L&ouml;r','S&ouml;n'];

		this.weekString='Vecka';

		this.todayIsString='Idag &auml;r det den';

		this.todayString='Idag &auml;r det den';

		this.timeString='';

		break;

		default:	/* English */

		this.monthArray=['January','February','March','April','May','June','July','August','September','October','November','December'];

		this.monthArrayShort=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

		this.dayArray=['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];

		this.weekString='Week';

		this.todayIsString='';

		this.todayString='Today';

		this.timeString='Time';

		break;

	}

	}

}





/************************************************************************************************************

*	Calendar model

*

*	Created:			January, 19th, 2007

*	@class Purpose of class:	Deal with dates and other calendar stuff

*		

*

* 	Update log:

*

************************************************************************************************************/

/**

* @constructor

* @class Purpose of class:	Data source for a calendar.

* @version 1.0

* @author	Alf Magne Kalleland(www.dhtmlgoodies.com)

*/



DHTMLSuite.calendarModel=function(inputArray){

	var initialDay;				

// Initial day (i.e. day in month)

	var initialMonth;			

// Initial month(1-12)

	var initialYear;			

// Initial Year(4 digits)

	var initialHour;			

// Initial Hour(0-23)

	var initialMinute;			

// Initial Minute

	

	var displayedDay;			

// Currently displayed day

	var displayedMonth;			

// Currently displayed month

	var displayedYear;			

// Current displayed year	

	var displayedMinute;			

// Currently displayed Minute

	var displayedHour;			

// Current displayed Hour

	var languageCode;			

// Current language code

	var languageModel;			

// Reference to object of class DHTMLSuite.calendarLanguageModel

	var invalidDateRange;			

// Array of invalid date ranges

	var weekStartsOnMonday;			

// Should the week start on monday?	

	this.weekStartsOnMonday=true;	

// Default-start week on monday	

	this.languageCode='en';

	this.invalidDateRange=new Array();

	

	this.__createDefaultModel(inputArray);

	

	

}



DHTMLSuite.calendarModel.prototype=

{

	

// {{{ setCallbackFunctionOnMonthChange()

    /**

     *	Automatically set start date from input field

     *	

     *	@param String functionName-Name of function to call when someone clicks on a date in the calendar. Argument to this function will be an array containing year,month,day,hour and minute

     *				 

     *

     *

    *@public	

     */	

	setCallbackFunctionOnMonthChange:function(functionName)

	{

	this.callbackFunctionOnMonthChange=functionName;

	}

	

// }}}

	,

	

// {{{ setInitialDateFromInput()

    /**

     *	Automatically set start date from input field

     *	

     *	@param Object inputReference-Reference to form input, i.e. id of form element, or a reference to the form element it's self

     *	@param String dateFormat-Format of value(examples: dd.mm.yyyy, yyyy.mm.dd, yyyy-mm-dd HH:

     *

    *@public	

     */	

	addInvalidDateRange:function(fromDateAsArray,toDateAsArray)

	{

	var index=this.invalidDateRange.length;

	this.invalidDateRange[index]=new Object();

	

	if(fromDateAsArray){

		fromDateAsArray.day=fromDateAsArray.day+'';

		fromDateAsArray.month=fromDateAsArray.month+'';

		fromDateAsArray.year=fromDateAsArray.year+'';

		if(!fromDateAsArray.month)fromDateAsArray.month=fromDateAsArray.month='1';

		if(!fromDateAsArray.day)fromDateAsArray.day=fromDateAsArray.day='1';

		if(fromDateAsArray.day.length==1)fromDateAsArray.day='0'+fromDateAsArray.day;

		if(fromDateAsArray.month.length==1)fromDateAsArray.month='0'+fromDateAsArray.month;

		this.invalidDateRange[index].fromDate=fromDateAsArray.year+fromDateAsArray.month+fromDateAsArray.day;

		

		

	}else{

		this.invalidDateRange[index].fromDate=false;

	}

	

	if(toDateAsArray){

		toDateAsArray.day=toDateAsArray.day+'';

		toDateAsArray.month=toDateAsArray.month+'';

		toDateAsArray.year=toDateAsArray.year+'';		

		if(!toDateAsArray.month)toDateAsArray.month=toDateAsArray.month='1';

		if(!toDateAsArray.day)toDateAsArray.day=toDateAsArray.day='1';

		if(toDateAsArray.day.length==1)toDateAsArray.day='0'+toDateAsArray.day;

		if(toDateAsArray.month.length==1)toDateAsArray.month='0'+toDateAsArray.month;

		this.invalidDateRange[index].toDate=toDateAsArray.year+toDateAsArray.month+toDateAsArray.day;

	}else{

		this.invalidDateRange[index].toDate=false;

	}

	

	}

	

// }}}

	,

	

// {{{ isDateWithinValidRange()

    /**

     *	Return true if given date is within valid date range.

     *

     *	@param Array inputDate-Associative array representing a date, keys in array:year,month and day

     *	@return Boolean dateWithinRange

    *@public	

     */	

	isDateWithinValidRange:function(inputDate)

	{

	if(this.invalidDateRange.length==0)return true;

	var month=inputDate.month+'';

	if(month.length==1)month='0'+month;

	var day=inputDate.day+'';

	if(day.length==1)day='0'+day;	

	var dateToCheck=inputDate.year+month+day;

	for(var no=0;no<this.invalidDateRange.length;no++){

		if(!this.invalidDateRange[no].fromDate&&this.invalidDateRange[no].toDate>=dateToCheck)return false;

		if(!this.invalidDateRange[no].toDate&&this.invalidDateRange[no].fromDate<=dateToCheck)return false;

		if(this.invalidDateRange[no].fromDate<=dateToCheck&&this.invalidDateRange[no].toDate>=dateToCheck)return false;

	}	

	return true;

	

	}

	,	

	

// {{{ setInitialDateFromInput()

    /**

     *	Automatically set start date from input field

     *	

     *	@param Object inputReference-Reference to form input, i.e. id of form element, or a reference to the form element it's self

     *	@param String dateFormat-Format of value(examples: dd.mm.yyyy, yyyy.mm.dd, yyyy-mm-dd HH:

     *

    *@public	

     */	

	setInitialDateFromInput:function(inputReference,format)

	{	

	if(inputReference.value.length>0){		

		if(!format.match(/^[0-9]*?$/gi)){

		var items=inputReference.value.split(/[^0-9]/gi);

		var positionArray=new Object();

		positionArray.m=format.indexOf('mm');

		if(positionArray.m==-1)positionArray.m=format.indexOf('m');

		positionArray.d=format.indexOf('dd');

		if(positionArray.d==-1)positionArray.d=format.indexOf('d');

		positionArray.y=format.indexOf('yyyy');

		positionArray.h=format.indexOf('hh');

		positionArray.i=format.indexOf('ii');

		

		var positionArrayNumeric=Array();

		positionArrayNumeric[0]=positionArray.m;

		positionArrayNumeric[1]=positionArray.d;

		positionArrayNumeric[2]=positionArray.y;

		positionArrayNumeric[3]=positionArray.h;

		positionArrayNumeric[4]=positionArray.i;

		

		

		positionArrayNumeric=positionArrayNumeric.sort(this.__calendarSortItems);

		var itemIndex=-1;

		this.initialHour='00';

		this.initialMinute='00';

		for(var no=0;no<positionArrayNumeric.length;no++){

			if(positionArrayNumeric[no]==-1)continue;

			itemIndex++;

			if(positionArrayNumeric[no]==positionArray['m']){

			this.initialMonth=items[itemIndex];

			continue;

			}

			if(positionArrayNumeric[no]==positionArray['y']){

			this.initialYear=items[itemIndex];

			continue;

			}	

			if(positionArrayNumeric[no]==positionArray['d']){

			tmpDay=items[itemIndex];

			continue;

			}	

			if(positionArrayNumeric[no]==positionArray['h']){

			this.initialHour=items[itemIndex];

			continue;

			}	

			if(positionArrayNumeric[no]==positionArray['i']){

			this.initialMinute=items[itemIndex];

			continue;

			}	

		}

	

		this.initialMonth=this.initialMonth / 1;

		tmpDay=tmpDay / 1;

		this.initialDay=tmpDay;

		}else{	

		var monthPos=format.indexOf('mm');

		this.initialMonth=inputReference.value.substr(monthPos,2)/1;	

		var yearPos=format.indexOf('yyyy');

		this.initialYear=inputReference.value.substr(yearPos,4);	

		var dayPos=format.indexOf('dd');

		tmpDay=inputReference.value.substr(dayPos,2);	

		this.initialDay=tmpDay;

		var hourPos=format.indexOf('hh');

		if(hourPos>=0){

			tmpHour=inputReference.value.substr(hourPos,2);	

			this.initialHour=tmpHour;

		}else{

			this.initialHour='00';

		}

		var minutePos=format.indexOf('ii');

		if(minutePos>=0){

			tmpMinute=inputReference.value.substr(minutePos,2);	

			this.initialMinute=tmpMinute;

		}else{

			this.initialMinute='00';

		}	

		}

	}	

	this.__setDisplayedDateToInitialData();

	}

	

// }}}

	,

	

// {{{ __setDisplayedDateToInitialData()

    /**

     *	Set displayed date equal to initial data.

     *	

    *@private	

     */		

	__setDisplayedDateToInitialData:function()

	{

	this.displayedYear=this.initialYear;

	this.displayedMonth=this.initialMonth;

	this.displayedDay=this.initialDay;

	this.displayedHour=this.initialHour;

	this.displayedMinute=this.initialMinute;	

	}

	

// }}}

	,

	

// {{{ __calendarSortItems()

    /**

     *	Sort calendar items.

     *	

    *@private	

     */	

	__calendarSortItems:function(a,b)

	{

	return a/1-b/1;

	}

	

// }}}

	,

	

// {{{ setLanguageCode()

    /**

     *	Set language code.

     *	

    *@public	

     */	

	setWeekStartsOnMonday:function(weekStartsOnMonday)

	{

	this.weekStartsOnMonday=weekStartsOnMonday;

	}

	

// }}}

	,

	

// {{{ setLanguageCode()

    /**

     *	Set language code.

     *	

    *@public	

     */	

	setLanguageCode:function(languageCode)

	{

	this.languageModel=new DHTMLSuite.calendarLanguageModel(languageCode);	

// Default english language model

	}

	

// }}}

	,

	

// {{{ __isLeapYear()

    /**

     *	Check for leap years.

     *	

    *@private	

     */		

	__isLeapYear:function(inputYear)

	{

	if(inputYear%400==0||(inputYear%4==0&&inputYear%100!=0))return true;

	return false;	

	}

	

// }}}

	,

	

// {{{ getWeekStartsOnMonday()

    /**

     *	Return true if week starts on monday

     *	

    *@private	

     */	

	getWeekStartsOnMonday:function()

	{

	return this.weekStartsOnMonday;

	}

	

// }}}

	,

	

// {{{ __createDefaultModel()

    /**

     *	Create default calendar model

     *	

    *@private	

     */	

	__createDefaultModel:function(inputArray)

	{

	var d=new Date();

	this.initialYear=d.getFullYear();

	this.initialMonth=d.getMonth()+1;

	this.initialDay=d.getDate();

	this.initialHour=d.getHours();



	if(inputArray){	/* Initial date data sent to the constructor?*/

		if(inputArray.initialYear)this.initialYear=inputArray.initialYear;

		if(inputArray.initialMonth)this.initialMonth=inputArray.initialMonth;

		if(inputArray.initialDay)this.initialDay=inputArray.initialDay;

		if(inputArray.initialHour)this.initialHour=inputArray.initialHour;

		if(inputArray.initialMinute)this.initialMinute=inputArray.initialMinute;

		if(inputArray.languageCode)this.languageCode=inputArray.languageCode;

	}	

	this.displayedYear=this.initialYear;

	this.displayedMonth=this.initialMonth;

	this.displayedDay=this.initialDay;

	this.displayedHour=this.initialHour;

	this.displayedMinute=this.initialMinute;

	

	this.languageModel=new DHTMLSuite.calendarLanguageModel();	

// Default english language model

	}	

	

// }}}

	,

	

// {{{ __getDisplayedYear()

    /**

     *	Return current displayed day

     *	

    *@private	

     */	

	__getDisplayedDay:function()

	{

	return this.displayedDay;

	}

	,

	

// {{{ __getDisplayedHourWithLeadingZeros()

    /**

     *	Return current displayed day

	 *

    *@private	

     */	

	__getDisplayedHourWithLeadingZeros:function()

	{

	var retVal=this.__getDisplayedHour()+'';

	if(retVal.length==1)retVal='0'+retVal;

	return retVal;

	}

	

// }}}

	,

	

// {{{ __getDisplayedMinuteWithLeadingZeros()

    /**

     *	Return current displayed day

     *	

    *@private	

     */	

	__getDisplayedMinuteWithLeadingZeros:function()

	{

	var retVal=this.__getDisplayedMinute()+'';

	if(retVal.length==1)retVal='0'+retVal;

	return retVal;

	}

	

// }}}

	,

	

// {{{ __getDisplayedDayWithLeadingZeros()

    /**

     *	Return current displayed day

     *	

    *@private	

     */	

	__getDisplayedDayWithLeadingZeros:function()

	{

	var retVal=this.__getDisplayedDay()+'';

	if(retVal.length==1)retVal='0'+retVal;

	return retVal;

	}

	

// }}}

	,

	

// {{{ __getDisplayedMonthNumberWithLeadingZeros()

    /**

     *	Return current displayed day

     *

    *@private	

     */	

	__getDisplayedMonthNumberWithLeadingZeros:function()

	{

	var retVal=this.__getDisplayedMonthNumber()+'';

	if(retVal.length==1)retVal='0'+retVal;

	return retVal;

	}

	

// }}}

	,	

	

// {{{ __getDisplayedYear()

    /**

     *	Return current displayed year

     *	

    *@private	

     */	

	__getDisplayedYear:function()

	{

	return this.displayedYear;

	}

	

// }}}

	,

	

// {{{ __getDisplayedHour()

    /**

     *	Return current displayed hour

     *	

    *@private	

     */	

	__getDisplayedHour:function()

	{

	if(!this.displayedHour)this.displayedHour=0;

	return this.displayedHour;

	}

	

// }}}

	,

	

// {{{ __getDisplayedMinute()

    /**

     *	Return current displayed minute

     *	

    *@private	

     */	

	__getDisplayedMinute:function()

	{

	if(!this.displayedMinute)this.displayedMinute=0;

	return this.displayedMinute;

	}

	

// }}}

	,

	

// {{{ __getDisplayedMonthNumber()

    /**

     *	Return month number (1-12)

     *	

    *@private	

     */	

	__getDisplayedMonthNumber:function()

	{

	return this.displayedMonth;

	}	,

	

// {{{ __getInitialYear()

    /**

     *	Return current initial day

     *	

    *@private	

     */	

	__getInitialDay:function()

	{

	return this.initialDay;

	}

	

// }}}

	,	

	

// {{{ __getInitialYear()

    /**

     *	Return current initial year

	 *

    *@private	

     */	

	__getInitialYear:function()

	{

	return this.initialYear;

	}

	

// }}}

	,

	

// {{{ __getInitialMonthNumber()

    /**

     *	Return month number (1-12)

     *	

    *@private	

     */	

	__getInitialMonthNumber:function()

	{

	return this.initialMonth;

	}

	,

	

// {{{ __getMonthNameByMonthNumber()

    /**

     *	Return month name from month number(1-12)

     *	

     *	@param Integer monthNumber-Month from 1 to 12.

     *

    *@private	

     */	

	__getMonthNameByMonthNumber:function(monthNumber)

	{

	return this.languageModel.monthArray[monthNumber-1];	

	}

	

// }}}

	,

	

// {{{ __moveOneYearBack()

    /**

     *	Set currently displayed year one year back.

     *

    *@private	

     */	

	__moveOneYearBack:function()

	{

	this.displayedYear--;	

	}

	

// }}}

	,

	

// {{{ __moveOneYearForward()

    /**

     *	Move the display one year ahead in time.

     *

    *@private	

     */	

	__moveOneYearForward:function()

	{

	this.displayedYear++;

	}

	

// }}}

	,	

	

// {{{ __moveOneMonthBack()

    /**

     *	Set currently displayed month one back.

     *

    *@private	

     */	

	__moveOneMonthBack:function()

	{

	this.displayedMonth--;

	if(this.displayedMonth<1){

		this.displayedMonth=12;

		this.displayedYear--;

	}

	}

	

// }}}

	,

	

// {{{ __moveOneMonthForward()

    /**

     *	Set currently displayed month one month ahead.

     *	

    *@private	

     */	

	__moveOneMonthForward:function()

	{

	this.displayedMonth++;

	if(this.displayedMonth>12){

		this.displayedMonth=1;

		this.displayedYear++;

	}	

	}	

	

// }}}

	,

	

// {{{ __setDisplayedYear()

    /**

     *	Set new year

     *	

     *	@param Integer year (4 digits)

     *

	 *	@return Boolean success-return true if year have actually changed, false otherwise

    *@private	

     */	

	__setDisplayedYear:function(year)

	{

	var success=year!=this.displayedYear;

	this.displayedYear=year;

	return success

	}

	

// }}}

	,

	

// {{{ __setDisplayedMonth()

    /**

     *	Set new month

     *	

     *	@param Integer month ( 1-12)

     *

     *	@return Boolean success-return true if month have actually changed, false otherwise

    *@private	

     */	

	__setDisplayedMonth:function(month)

	{

	var success=month!=this.displayedMonth;

	this.displayedMonth=month;

	return success;

	}

	,

	

// {{{ __setDisplayedDay()

    /**

     *	Set new displayed day

     *	

     *	@param day in month

    *    

    *@private	

     */	

	__setDisplayedDay:function(day)

	{

	this.displayedDay=day;

	}

	

// }}}

	,

	

// {{{ __setDisplayedHour()

    /**

     *	Set new displayed hour

     *	

     *	@param hour (0-23)

    *    

    *@private	

     */	

	__setDisplayedHour:function(hour)

	{

	this.displayedHour=hour/1;

	}

	

// }}}

	,

	

// {{{ __setDisplayedMinute()

    /**

     *	Set new displayed minute

     *	

     *	@param minute (0-59)

    *    

    *@private	

     */		

	__setDisplayedMinute:function(minute)

	{

	this.displayedMinute=minute/1;

	}

	

// }}}

	,

	

// {{{ __getPreviousYearAndMonthAsArray()

    /**

     *	Return previous month as an array(year and month)

     *	

     *	@return Array year and month(numeric)

     *

    *@private	

     */	

	__getPreviousYearAndMonthAsArray:function()

	{

	var month=this.displayedMonth-1;

	var year=this.displayedYear;

	if(month==0){

		month=12;

		year=year-1;

	}	

	var retArray=[year,month];

	return retArray;

	

	}

	

// }}}

	,

	

// {{{ __getNumberOfDaysInCurrentDisplayedMonth()

    /**

     *	Return number of days in currently displayed month.

     *	

     *	@param Integer monthNumber-Month from 1 to 12.

     *

    *@private	

     */	

	__getNumberOfDaysInCurrentDisplayedMonth:function()

	{

	return this.__getNumberOfDaysInAMonthByMonthAndYear(this.displayedYear,this.displayedMonth);

	}

	

// }}}

	,

	

// {{{ __getNumberOfDaysInAMonthByMonthAndYear()

    /**

     *	Return number of days in given month.

     *	

     *	@param Integer year-Year(4 digits)

     *	@param Integer month-Month(1-12)

     *

    *@private	

     */	

	__getNumberOfDaysInAMonthByMonthAndYear:function(year,month)

	{	

	var daysInMonthArray=[31,28,31,30,31,30,31,31,30,31,30,31];

	var daysInMonth=daysInMonthArray[month-1];

	if(daysInMonth==28){

		if(this.__isLeapYear(year))daysInMonth=29;

	}

	return daysInMonth/1;		

	}

	

// }}}

	,

	

// {{{ __getStringWeek()

    /**

     *	Return the string "Week"

     *	

    *@private	

     */	

	__getStringWeek:function()

	{	

	return this.languageModel.weekString;

	}	

	

// }}}

	,

	

// {{{ __getDaysMondayToSunday()

    /**

     *	Return an array of days from monday to sunday

     *	

    *@private	

     */	

	__getDaysMondayToSunday:function()

	{

	return this.languageModel.dayArray;	

	}

	

// }}}

	,

	

// {{{ __getDaysSundayToSaturday()

    /**

     *	Return an array of days from sunday to saturday

     *	

    *@private	

     */	

	__getDaysSundayToSaturday:function()

	{

	var retArray=this.languageModel.dayArray.concat();

	var lastDay=new Array(retArray[retArray.length-1]);

	retArray.pop();	

	return lastDay.concat(retArray);	

	}

	

// }}}

	,

	

// {{{ __getWeekNumberFromDayMonthAndYear()

    /**

     *	Return week in year from year,month and day

     *	

    *@private	

     */	

	__getWeekNumberFromDayMonthAndYear:function(year,month,day)

	{

	day=day/1;

	year=year /1;

	    month=month/1;

	    

	if(!this.weekStartsOnMonday)return this.__getWeekNumberFromDayMonthAndYear_S(year,month,day);



	    var a=Math.floor((14-(month))/12);

	    var y=year+4800-a;

	    var m=(month)+(12*a)-3;

	    var jd=day+Math.floor(((153*m)+2)/5)+

	                 (365*y)+Math.floor(y/4)- Math.floor(y/100)+

	                 Math.floor(y/400)- 32045;      

// (gregorian calendar)

	    var d4=(jd+31741-(jd%7))%146097%36524%1461;

	    var L=Math.floor(d4/1460);

	    var d1=((d4-L)%365)+L;

	    NumberOfWeek=Math.floor(d1/7)+1;

	    return NumberOfWeek;    	

	}

	

// }}}

	,

	

// {{{ __getWeekNumberFromDayMonthAndYear_S()

    /**

     *	Return week in year from year,month and day (Week starts on sunday)

     *	

    *@private	

     */	

	__getWeekNumberFromDayMonthAndYear_S:function(year,month,day)

	{

	

	month--;

	/* The code below is from http:

//www.quirksmode.org/js/week.html */

	now=Date.UTC(year,month,day+1,0,0,0);

	var firstDay=new Date();

	firstDay.setYear(year);

	firstDay.setMonth(0);

	firstDay.setDate(1);

	then=Date.UTC(year,0,1,0,0,0);

	var Compensation=firstDay.getDay();

	if (Compensation > 3)Compensation -= 4;

	else Compensation += 3;

	NumberOfWeek= Math.round((((now-then)/86400000)+Compensation)/7);

	return NumberOfWeek;

	

	}	

	

// }}}

	,

	

// {{{ __getDayNumberFirstDayInYear()

    /**

     *	Day number first day in year(0-6)

     *	

    *@private	

     */	

	__getDayNumberFirstDayInYear:function(year)

	{

	var d=new Date();

	d.setFullYear(year);	

	d.setDate(1);	

	d.setMonth(0);

	return d.getDay();

	

	}	

	

// }}}

	,

	

// {{{ __getRemainingDaysInPreviousMonthAsArray()

    /**

     *	Return number of days remaining in previous month, i.e. in the view before first day of current month starts some day in the week.

     *	

    *@private	

     */	

	__getRemainingDaysInPreviousMonthAsArray:function()

	{

	

// Figure out when this month starts

	var d=new Date();

	d.setFullYear(this.displayedYear);	

	d.setDate(1);	

	d.setMonth(this.displayedMonth-1);

		

	var dayStartOfMonth=d.getDay();

	if(this.weekStartsOnMonday){

		if(dayStartOfMonth==0)dayStartOfMonth=7;

		dayStartOfMonth--;

	}

	

	var previousMonthArray=this.__getPreviousYearAndMonthAsArray();



	var daysInPreviousMonth=this.__getNumberOfDaysInAMonthByMonthAndYear(previousMonthArray[0],previousMonthArray[1]);

	var returnArray=new Array();

	for(var no=0;no<dayStartOfMonth;no++){

		returnArray[returnArray.length]=daysInPreviousMonth-dayStartOfMonth+no+1;

	}

	return returnArray;

	

	

	}

	

// }}}

	,

	

// {{{ __getMonthNames()

    /**

     *	Return an array of month names

     *	

    *@private	

     */	

	__getMonthNames:function()

	{

	return this.languageModel.monthArray;		

	}

	

// }}}

	,

	

// {{{ __getTodayAsString()

    /**

     *	Return the string "Today" in the specified language

     *

    *@private	

     */	

	__getTodayAsString:function()

	{

	return this.languageModel.todayString;

	}

	

// }}}

	,

	

// {{{ __getTimeAsString()

    /**

     *	Return the string "Time" in the specified language

     *

    *@private	

     */	

	__getTimeAsString:function()

	{

	return this.languageModel.timeString;

	}

}







/**

* @constructor

* @class Calendar widget (<a href="../../demos/demo-calendar-1.html" target="_blank">demo</a>).

* @version		1.0

* @version 1.0

* 

* @author	Alf Magne Kalleland(www.dhtmlgoodies.com)

**/







DHTMLSuite.calendar=function(propertyArray)

{

	var id;				

// Unique identifier-optional

	var divElement;

	var divElContent;	

// Div element for the content inside the calendar

	var divElHeading;

	var divElNavBar;

	var divElMonthView;		

// Div for the main view-weeks, days, months etc.

	var divElMonthNInHead;

	var divElYearInHeading;

	var divElBtnPreviousYear;	

// Button-previous year

	var divElBtnNextYear;		

// Button-next year

	var divElBtnPrvMonth;	

// Button-previous Month

	var divElBtnNextMonth;		

// Button-next Month

	var divElYearDropdown;		

// Dropdown box-years

	var divElYearDropdownParentYears;	

// Inner div inside divElYearDropdown which is parent to all the small year divs.

	var divElHourDropdownParentHours;	

// Inner div inside divElYearDropdown which is parent to all the small year hours.

	var divElHourDropdown;		

// Drop down hours

	var divElMinuteDropdownParent;	

// Inner div inside divElYearDropdown which is parent to all the small year Minutes.

	var divElMinuteDropdown;		

// Drop down Minutes

	var divElTodayInNavBar;	

// Today in navigation bar.

	var divElHrInTimeBar;	

// Div for hour in timer bar

	var divElMinInTimeBar;	

// Div for minute in timer bar

	var divElTimeStringInTimeBar;	

// Div for "Time" string in timer bar

	

	var iframeEl;

	var iframeElDropDowns;	

	var calendarModelReference;		

// Reference to object of class calendarModel

	var objectIndex;

	var targetReference;		

// Where to insert the calendar.

	var layoutCSS;

	var isDragable;			

// Is the calendar dragable-default=false

	var referenceToDragDropObject;	

// Reference to object of class DHTMLSuite.dragDropSimple

	var scrollInYearDropDownActive;	

// true when mouse is over up and down arrows in year dropdown

	var scrollInHourDropDownActive;	

// true when mouse is over up and down arrows in hour dropdown

	var scrollInMinuteDropDownActive;	

// true when mouse is over up and down arrows in minute dropdown

	var yearDropDownOffsetInYear;	

// Offset in year relative to current displayed year.

	var hourDropDownOffsetInHour;	

// Offset in hours relative to current displayed hour.

	var minuteDropDownOffsetInHour;	

// Offset in minute relative to current displayed minute.

	

	var displayCloseButton;			

// Display close button at the top right corner

	var displayNavigationBar;		

// Display the navigation bar?( default=true)

	var displayTodaysDateInNavigationBar;	

// Display the string "Today" in the navigation bar(default=true)

	var displayTimeBar;			

// Display timer bar-default=false;

	

	var posRefToHtmlEl;	

// reference to html element to position the calendar at

	var positioningOffsetXInPixels;		

// Offset in positioning when positioning calendar at a element

	var positioningOffsetYInPixels;		

// Offset in positioning when positioning calendar at a element

	var htmlElementReferences;

	var minuteDropDownInterval;		

// Minute drop down interval(interval between each row in the minute drop down list)

	

	var numberOfRowsInMinuteDropDown;	

// Number of rows in minute drop down. (default=10)

	var numberOfRowsInHourDropDown;		

// Number of rows in hour drop down. (default=10)

	var numberOfRowsInYearDropDown;		

// Number of rows in year drop down. (default=10)

	

	this.displayTimeBar=false;

	this.minuteDropDownInterval=5;

	this.htmlElementReferences=new Object();

	this.posRefToHtmlEl=false;

	this.displayCloseButton=true;	

// Default value-close button visible at the top right corner.

	this.displayNavigationBar=true;

	this.displayTodaysDateInNavigationBar=true;

	this.yearDropDownOffsetInYear=0;

	this.hourDropDownOffsetInHour=0;

	this.minuteDropDownOffsetInHour=0;

	this.minuteDropDownOffsetInMinute=0;

	this.layoutCSS='calendar.css';

	this.isDragable=false;

	this.scrollInYearDropDownActive=false;

	this.scrollInHourDropDownActive=false;

	this.scrollInMinuteDropDownActive=false;

	

	this.numberOfRowsInMinuteDropDown=10;

	this.numberOfRowsInHourDropDown=10;

	this.numberOfRowsInYearDropDown=10;

	

	var callbackFunctionOnDayClick;		

// Name of call back function to call when you click on a day

	var callbackFunctionOnClose;		

// Name of call back function to call when the calendar is closed.

	var callbackFunctionOnMonthChange;	

// Name of call back function to call when the month is changed in the view

	var dateOfToday;



	

	this.dateOfToday=new Date();

	

	try{

	if(!standardObjectsCreated)DHTMLSuite.createStandardObjects();	

// This line starts all the init methods

	}catch(e){

	alert('You need to include the dhtmlSuite-common.js file');

	}

	

	this.objectIndex=DHTMLSuite.variableStorage.arrayDSObjects.length;

	DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex]=this;	

	

	if(propertyArray)this.__setInitialData(propertyArray);

	

	

}



DHTMLSuite.calendar.prototype=

{

	

// {{{ callbackFunctionOnDayClick()

    /**

     *	Specify call back function-click on days in calendar

     *	

     *	@param String functionName-Name of function to call when someone clicks on a date in the calendar. Argument to this function will be an array containing year,month,day,hour and minute

     *				 

    *@public	

     */	

	setCallbackFunctionOnDayClick:function(functionName)

	{

	this.callbackFunctionOnDayClick=functionName;	

	}

	

// }}}

	,

	

// {{{ setCallbackFunctionOnMonthChange()

    /**

     *	Automatically set start date from input field

     *	

     *	@param String functionName-Name of function to call when someone clicks on a date in the calendar. Argument to this function will be an array containing year,month,day,hour and minute

     *				 

    *@public	

     */	

	setCallbackFunctionOnMonthChange:function(functionName)

	{

	if(!this.calendarModelReference){

		this.calendarModelReference=new DHTMLSuite.calendarModel();

	}

	this.callbackFunctionOnMonthChange=functionName;

	}

	

// }}}

	,

	

// {{{ setCallbackFunctionOnClose()

    /**

     *	Specify call back function-calendar close

     *	

     *	@param String functionName-Function name to call when the calendar is closed. This function will receive one argument which is an associative array of the properties year,month,day,hour,minute and calendarRef. calendarRef is a reference to the DHTMLSuite.calendar object.

     *

    *@public	

     */	

	setCallbackFunctionOnClose:function(functionName)

	{

	this.callbackFunctionOnClose=functionName;

	}

	,

	

// {{{ setCalendarModelReference()

    /**

     *	Automatically set start date from input field

     *	

     *	@param Object calendarModelReference-Reference to an object of class DHTMLSuite.calendarModel

     *

    *@public	

     */	

	setCalendarModelReference:function(calendarModelReference)

	{

	this.calendarModelReference=calendarModelReference;

	}

	

// }}}

	,

	

// {{{ setCalendarPositionByHTMLElement()

    /**

     *	Make the calendar absolute positoned and positioning it next by a HTML element

     *	

     *	@param Object refToHtmlEl-Reference to html element

     *	@param Integer offsetXInPx-X offset in pixels

     *	@param Integer offsetYInPx-Y offset in pixels.

     *

     *

    *@public	

     */	

	setCalendarPositionByHTMLElement:function(refToHtmlEl,offsetXInPx,offsetYInPx)

	{

	refToHtmlEl=DHTMLSuite.commonObj.getEl(refToHtmlEl);	

	this.posRefToHtmlEl=refToHtmlEl;

	if(!offsetXInPx)offsetXInPx=0;

	if(!offsetYInPx)offsetYInPx=0;

	this.positioningOffsetXInPixels=offsetXInPx;

	this.positioningOffsetYInPixels=offsetYInPx;

	}

	

// }}}

	,

	

// {{{ addHtmlElementReference()

    /**

     *	Add a reference to form field element-a reference to this object will be sent back in the call back function.

     *	

     *	@param String key-Key in the array for this element-To make it easier for you to pick it up later.

     *	@param Object referenceToHtmlEl-Reference to html element

     *

    *@public	

     */	

	addHtmlElementReference:function(key,referenceToHtmlEl)

	{

	referenceToHtmlEl=DHTMLSuite.commonObj.getEl(referenceToHtmlEl);	

	if(key){

		this.htmlElementReferences[key]=referenceToHtmlEl;

	}

	}

	

// }}}

	,	

	

// {{{ setDisplayCloseButton()

    /**

     *	Specify close button visibility

     *	

     *	@param Boolean displayCloseButton-Display close button.

     *

     *

    *@public	

     */	

	getHtmlElementReferences:function()

	{

	return this.htmlElementReferences;	

	}

	

// }}}

	,

	

// {{{ setDisplayCloseButton()

    /**

     *	Specify close button visibility

     *	

     *	@param Boolean displayCloseButton-Display close button.

     *

    *@public	

     */	

	setDisplayCloseButton:function(displayCloseButton)

	{

	this.displayCloseButton=displayCloseButton;

	}

	

// }}}

	,

	

// {{{ setTargetReference()

    /**

     *	Automatically set start date from input field

     *	

     *	@param Object targetReference-Id or direct reference to an element on your web page. The calender will be inserted as child of this element

     *

    *@public	

     */	

	setTargetReference:function(targetRef)

	{

	targetRef=DHTMLSuite.commonObj.getEl(targetRef);	

	this.targetReference=targetRef;	

	}

	

// }}}

	,

	

// {{{ setIsDragable()

    /**

     *	Automatically set start date from input field

     *	

     *	@param Boolean isDragable-Should the calendar be dragable?

     *

    *@public	

     */	

	setIsDragable:function(isDragable){

	this.isDragable=isDragable;

	}

	

// }}}

	,

	

// {{{ resetViewDisplayedMonth()

    /**

     *	Reset current display, i.e. display data for the inital set month.

     *	

    *@public	

     */	

	resetViewDisplayedMonth:function()

	{

	if(!this.divElement)return;

	if(!this.calendarModelReference){

		this.calendarModelReference=new DHTMLSuite.calendarModel();

	}

	this.calendarModelReference.__setDisplayedDateToInitialData();

	this.__populateCalHeading();	

// Populate heading with data

	this.__populateMonthView();	

// Populate month view with month data

	}

	

// }}}

	,

	

// {{{ setLayoutCss()

    /**

     *	Specify new name of css file

     *	

     *	@param String nameOfCssFile-Name of css file

     *

    *@public	

     */	

	setLayoutCss:function(nameOfCssFile)

	{

	this.layoutCSS=nameOfCssFile;	

	}

	

// }}}

	,

	

// {{{ __init()

    /**

     *	Initializes the widget

     *	

    *@private	

     */		

	__init:function()

	{

	if(!this.divElement){

		DHTMLSuite.commonObj.loadCSS(this.layoutCSS);	

// Load css

		if(!this.calendarModelReference){

		this.calendarModelReference=new DHTMLSuite.calendarModel();

		}

		this.__createMainHtmlEls();	

// Create main html elements for the calendar		

		this.__createHeadingElements();	

// Create html elements for the heading

		this.__createNavigationBar();	

// Create the navigation bar below the heading.		

		this.__populateNavigationBar();	

// Fill navigation bar with todays date.

		this.__populateCalHeading();	

// Populate heading with data

		this.__createCalMonthView();	

// Create div element for the main view, i.e. days, weeks months, etc.

		this.__populateMonthView();	

// Populate month view with month data

		this.__createTimeBar();		

// Create div elements for the timer bar.

		this.__populateTimeBar();		

// Populate the timer bar

		this.__createDropDownYears();

		

		this.__populateDropDownYears();

		this.__positionDropDownYears();

		this.__createDropDownMonth();

		this.__populateDropDownMonths();

		this.__positionDropDownMonths();		

		this.__createDropDownHours();

		this.__populateDropDownHours();

		this.__positionDropDownHours();		

		this.__createDropDownMinutes();

		this.__populateDropDownMinutes();

		this.__positionDropDownMinutes();		

		this.__addEvents();	

	}else{

		this.divElement.style.display='block';

		this.__populateCalHeading();	

// Populate heading with data	

		this.__populateMonthView();	

// Populate month view with month data

	}	

	this.__resizePrimaryiframeEl();

	

	}

	

// }}}

	,

	

// {{{ display()

    /**

     *	Displays the calendar

     *	

    *@public	

     */	

	display:function()

	{

	if(!this.divElement)this.__init();

	this.__positionCalendar();

	this.divElement.style.display='block';
	
	this.__resizePrimaryiframeEl();

	return this.divElement;

	}
	
	

	

// }}}

	,

	// {{{ cambiaZindex(zBase)

    /**

     *	Cambia el zindex

     *	

    *@public	

     */	
	cambiaZindex:function(zBase){
		this.divElement.style.zIndex=zBase+10;
	}

	
// }}}

	,
	
// {{{ hide()

    /**

     *	Closes the calendar

     *	

    *@public	

     */	

	hide:function()

	{

	if(this.__handleCalendarCallBack('calendarClose')===false)return false;

	this.divElement.style.display='none';

	this.divElYearDropdown.style.display='none';

	this.divElMonthDropdown.style.display='none';

	}

	

// }}}

	,

	

// {{{ isVisible()

    /**

     *	Is the calendar visible

     *	

    *@private	

     */	

	isVisible:function()

	{

	if(!this.divElement)return false;

	return this.divElement.style.display=='block'?true:false;	

	}

	

// }}}

	,

	

// {{{ setInitialDateFromInput()

    /**

     *	Set intial date from form input

     *	

     *

    *@private	

     */	

	setInitialDateFromInput:function(inputReference,format)

	{

	if(!this.calendarModelReference){

		this.calendarModelReference=new DHTMLSuite.calendarModel();

	}

	this.calendarModelReference.setInitialDateFromInput(inputReference,format);

	}

	

// }}}

	,

	

// {{{ setDisplayedYear()

    /**

     *	Set a new displayed year

     *

     *

    *@public	

     */	

	setDisplayedYear:function(year)

	{

	var success=this.calendarModelReference.__setDisplayedYear(year);	

// Year has actually changed	

	this.__populateCalHeading();

	this.__populateMonthView();		

	if(success)this.__handleCalendarCallBack('monthChange');

	}

	

// }}}

	,

	

// {{{ setDisplayedMonth()

    /**

     *	Set a new displayed month

     *

     *

    *@public	

     */	

	setDisplayedMonth:function(month)

	{

	var success=this.calendarModelReference.__setDisplayedMonth(month);	

// Month have actually changed	

	this.__populateCalHeading();

	this.__populateMonthView();		

	if(success)this.__handleCalendarCallBack('monthChange');

	}

	

// }}}

	,

	

// {{{ setDisplayedHour()

    /**

     *	Set new displayed hour.

     *

    *@private	

     */		

	setDisplayedHour:function(hour)

	{

	this.calendarModelReference.__setDisplayedHour(hour);	

// Month have actually changed	

	this.__populateTimeBar();

	

	}

	

// }}}

	,

	

// {{{ setDisplayedMinute()

    /**

     *	Set new displayed minute.

     *

    *@private	

     */		

	setDisplayedMinute:function(minute)

	{

	this.calendarModelReference.__setDisplayedMinute(minute);	

// Month have actually changed	

	this.__populateTimeBar();

	

	}

	

// }}}

	,

	

// {{{ __createDropDownMonth()

    /**

     *	Create main div elements for the month drop down.

     *	

    *@private	

     */	

	__createDropDownMonth:function()

	{

	this.divElMonthDropdown=document.createElement('DIV');

	this.divElMonthDropdown.style.display='none';

	this.divElMonthDropdown.className='DHTMLSuite_calendar_monthDropDown';

	document.body.appendChild(this.divElMonthDropdown);		

	}

	

// }}}

	,

	

// {{{ __populateDropDownMonths()

    /**

     *	Populate month drop down.

     *	

    *@private	

     */	

	__populateDropDownMonths:function()

	{

	this.divElMonthDropdown.innerHTML='';	

// Initially clearing drop down.

	var ind=this.objectIndex;	

// Get a reference to this object in the global object array.

	var months=this.calendarModelReference.__getMonthNames();	

// Get an array of month name according to current language settings

	for(var no=0;no<months.length;no++){	

// Loop through names

		var div=document.createElement('DIV');	

// Create div element

		div.className='DHTMLSuite_calendar_dropDownAMonth';

		if((no+1)==this.calendarModelReference.__getDisplayedMonthNumber())div.className='DHTMLSuite_calendar_yearDropDownCurrentMonth';	

// Highlight current month.

		div.innerHTML=months[no];	

// Set text of div

		div.id='DHTMLSuite_calendarMonthPicker'+(no+1);	

// Set id of div. this is used inside the __setMonthFromDropdown in order to pick up the date.

		div.onmouseover=this.__mouseoverMonthInDropDown;

		div.onmouseout=this.__mouseoutMonthInDropDown;

		div.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__setMonthFromDropdown(e); } 

		this.divElMonthDropdown.appendChild(div);	

		DHTMLSuite.commonObj.__addEventEl(div);			

	}

	

	}

	

// }}}

	,

	

// {{{ __createDropDownYears()

    /**

     *	Create drop down box for years

     *	

    *@private	

     */	

	__createDropDownYears:function()

	{

	this.divElYearDropdown=document.createElement('DIV');

	this.divElYearDropdown.style.display='none';

	this.divElYearDropdown.className='DHTMLSuite_calendar_yearDropDown';

	document.body.appendChild(this.divElYearDropdown);

	

	}

	,

	

// {{{ __createDropDownHours()

    /**

     *	Create drop down box for years

     *	

    *@private	

     */	

	__createDropDownHours:function()

	{

	this.divElHourDropdown=document.createElement('DIV');

	this.divElHourDropdown.style.display='none';

	this.divElHourDropdown.className='DHTMLSuite_calendar_hourDropDown';

	document.body.appendChild(this.divElHourDropdown);

	

	}

	

// }}}

	,

	

// {{{ __createDropDownMinutes()

    /**

     *	Create minute drop down box.

     *	

    *@private	

     */	

	__createDropDownMinutes:function()

	{

	this.divElMinuteDropdown=document.createElement('DIV');

	this.divElMinuteDropdown.style.display='none';

	this.divElMinuteDropdown.className='DHTMLSuite_calendar_minuteDropDown';

	document.body.appendChild(this.divElMinuteDropdown);	

	

	}

	

// }}}

	,

	

// {{{ __populateDropDownMinutes()

    /**

     *	Populate-minute dropdown.

     *	

    *@private	

     */	

	__populateDropDownMinutes:function()

	{

	var ind=this.objectIndex;	

	this.divElMinuteDropdown.innerHTML='';	

	

	

// Previous minute

	var divPrevious=document.createElement('DIV');

	divPrevious.className='DHTMLSuite_calendar_dropDown_arrowUp';

	divPrevious.onmouseover=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mouseoverUpAndDownArrowsInDropDownMinutes(e); } ;

	divPrevious.onmouseout =function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mouseoutUpAndDownArrowsInDropDownMinutes(e); } ;	

	this.divElMinuteDropdown.appendChild(divPrevious);	

	DHTMLSuite.commonObj.__addEventEl(divPrevious);		



	this.divElMinuteDropdownParent=document.createElement('DIV');

	this.divElMinuteDropdown.appendChild(this.divElMinuteDropdownParent);

	this.__populateMinutesInsideDropDownMinutes(this.divElMinuteDropdownParent);

	

	

// Next Minute	

	var divNext=document.createElement('DIV');

	divNext.className='DHTMLSuite_calendar_dropDown_arrowDown';

	divNext.innerHTML='<span></span>';

	divNext.onmouseover=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mouseoverUpAndDownArrowsInDropDownMinutes(e); } ;

	divNext.onmouseout =function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mouseoutUpAndDownArrowsInDropDownMinutes(e); } ;

	DHTMLSuite.commonObj.__addEventEl(divNext);

	this.divElMinuteDropdown.appendChild(divNext);	

	

	if(60 / this.minuteDropDownInterval	< this.numberOfRowsInMinuteDropDown){

		divPrevious.style.display='none';

		divNext.style.display='none';

	}		

	}

	

// }}}

	,

	

// {{{ __populateMinutesInsideDropDownMinutes()

    /**

     *	Populate-minutes inside minute drop down

     *	

    *@private	

     */	

	__populateMinutesInsideDropDownMinutes:function()

	{

	var ind=this.objectIndex;

	this.divElMinuteDropdownParent.innerHTML='';	

	

	

	if(60 / this.minuteDropDownInterval	< this.numberOfRowsInMinuteDropDown){

		startMinute=0;

	}else{

		var startMinute=Math.max(0,(this.calendarModelReference.__getDisplayedMinute()-Math.round(this.numberOfRowsInMinuteDropDown/2)));

		startMinute+=(this.minuteDropDownOffsetInMinute*this.minuteDropDownInterval)

		if(startMinute<0){	/* Start minute negative-adjust it and change offset value */			

		startMinute+=this.minuteDropDownInterval;

		this.minuteDropDownOffsetInMinute++;

		}

		if(startMinute+(this.numberOfRowsInMinuteDropDown*this.minuteDropDownInterval)>60){	/* start minute in drop down+number of records shown*interval larger than 60 -> adjust it */	

		startMinute-=this.minuteDropDownInterval;

		this.minuteDropDownOffsetInMinute--;

		}

	}

	for(var no=startMinute;no<Math.min(60,startMinute+this.numberOfRowsInMinuteDropDown*(this.minuteDropDownInterval));no+=this.minuteDropDownInterval){

		var div=document.createElement('DIV');

		div.className='DHTMLSuite_calendar_dropDownAMinute';

		if(no==this.calendarModelReference.__getDisplayedMinute())div.className='DHTMLSuite_calendar_minuteDropDownCurrentMinute';

		var prefix="";

		if(no<10)prefix="0";

		div.innerHTML=prefix+no;

		

		div.onmouseover=this.__mouseoverMinuteInDropDown;

		div.onmouseout=this.__mouseoutMinuteInDropDown;

		div.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__setMinuteFromDropdown(e); } 

		this.divElMinuteDropdownParent.appendChild(div);	

		DHTMLSuite.commonObj.__addEventEl(div);		

	}	

	

	}

	

// }}}	

	,

	

// {{{ __populateDropDownHours()

    /**

     *	Populate-hour dropdown.

     *	

    *@private	

     */	

	__populateDropDownHours:function()

	{

	var ind=this.objectIndex;	

	this.divElHourDropdown.innerHTML='';	

	

	

// Previous hour

	var div=document.createElement('DIV');

	div.className='DHTMLSuite_calendar_dropDown_arrowUp';

	div.onmouseover=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mouseoverUpAndDownArrowsInDropDownHours(e); } ;

	div.onmouseout =function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mouseoutUpAndDownArrowsInDropDownHours(e); } ;	

	this.divElHourDropdown.appendChild(div);	

	DHTMLSuite.commonObj.__addEventEl(div);		



	this.divElHourDropdownParentHours=document.createElement('DIV');

	this.divElHourDropdown.appendChild(this.divElHourDropdownParentHours);

	this.__populateHoursInsideDropDownHours(this.divElHourDropdownParentHours);

	

	

// Next Hour	

	var div=document.createElement('DIV');

	div.className='DHTMLSuite_calendar_dropDown_arrowDown';

	div.innerHTML='<span></span>';

	div.onmouseover=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mouseoverUpAndDownArrowsInDropDownHours(e); } ;

	div.onmouseout =function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mouseoutUpAndDownArrowsInDropDownHours(e); } ;

	DHTMLSuite.commonObj.__addEventEl(div);

	this.divElHourDropdown.appendChild(div);		

		

	}

	

// }}}

	,

	

// {{{ __populateHoursInsideDropDownHours()

    /**

     *	Populate-hours inside hour drop down

     *	

    *@private	

     */	

	__populateHoursInsideDropDownHours:function()

	{

	

	var ind=this.objectIndex;

	this.divElHourDropdownParentHours.innerHTML='';

	var startHour=Math.max(0,(this.calendarModelReference.__getDisplayedHour()-Math.round(this.numberOfRowsInHourDropDown/2)));

	startHour=Math.min(14,startHour);

	if((startHour+this.hourDropDownOffsetInHour+this.numberOfRowsInHourDropDown)>24){

		this.hourDropDownOffsetInHour=(24-startHour-this.numberOfRowsInHourDropDown);		

	}

	if((startHour+this.hourDropDownOffsetInHour)<0){

		this.hourDropDownOffsetInHour=startHour*-1;		

	}

		

	startHour+=this.hourDropDownOffsetInHour;

	if(startHour<0)startHour=0;

	if(startHour>(24-this.numberOfRowsInHourDropDown))startHour=(24-this.numberOfRowsInHourDropDown);

	for(var no=startHour;no<startHour+this.numberOfRowsInHourDropDown;no++){

		var div=document.createElement('DIV');

		div.className='DHTMLSuite_calendar_dropDownAnHour';

		if(no==this.calendarModelReference.__getDisplayedHour())div.className='DHTMLSuite_calendar_hourDropDownCurrentHour';

		var prefix="";

		if(no<10)prefix="0";

		div.innerHTML=prefix+no;

		

		div.onmouseover=this.__mouseoverHourInDropDown;

		div.onmouseout=this.__mouseoutHourInDropDown;

		div.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__setHourFromDropdown(e); } 

		this.divElHourDropdownParentHours.appendChild(div);	

		DHTMLSuite.commonObj.__addEventEl(div);		

	}	

	

	}

	

// }}}

	,

	

// {{{ __populateDropDownYears()

    /**

     *	Populate-year dropdown.

     *	

    *@private	

     */	

	__populateDropDownYears:function()

	{

	var ind=this.objectIndex;	

	this.divElYearDropdown.innerHTML='';	

	

	

// Previous year 

	var div=document.createElement('DIV');

	div.className='DHTMLSuite_calendar_dropDown_arrowUp';

	div.onmouseover=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mouseoverUpAndDownArrowsInDropDownYears(e); } ;

	div.onmouseout =function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mouseoutUpAndDownArrowsInDropDownYears(e); } ;	

	this.divElYearDropdown.appendChild(div);	

	DHTMLSuite.commonObj.__addEventEl(div);		

	this.divElYearDropdownParentYears=document.createElement('DIV');

	this.divElYearDropdown.appendChild(this.divElYearDropdownParentYears);

	this.__populateYearsInsideDropDownYears(this.divElYearDropdownParentYears);

	

	

// Next year	

	var div=document.createElement('DIV');

	div.className='DHTMLSuite_calendar_dropDown_arrowDown';

	div.innerHTML='<span></span>';

	div.onmouseover=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mouseoverUpAndDownArrowsInDropDownYears(e); } ;

	div.onmouseout =function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mouseoutUpAndDownArrowsInDropDownYears(e); } ;

	DHTMLSuite.commonObj.__addEventEl(div);

	this.divElYearDropdown.appendChild(div);		

	}

	

// }}}

	,

	

// {{{ __populateYearsInsideDropDownYears()

    /**

     *	Populate inner div inside the year drop down with months.

     *	

    *@private	

     */	

	__populateYearsInsideDropDownYears:function(divElementToPopulate)

	{

	var ind=this.objectIndex;

	this.divElYearDropdownParentYears.innerHTML='';

	var startYear=this.calendarModelReference.__getDisplayedYear()-5+this.yearDropDownOffsetInYear;

	for(var no=startYear;no<startYear+this.numberOfRowsInYearDropDown;no++){

		var div=document.createElement('DIV');

		div.className='DHTMLSuite_calendar_dropDownAYear';

		if(no==this.calendarModelReference.__getDisplayedYear())div.className='DHTMLSuite_calendar_yearDropDownCurrentYear';

		div.innerHTML=no;

		

		div.onmouseover=this.__mouseoverYearInDropDown;

		div.onmouseout=this.__mouseoutYearInDropDown;

		div.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__setYearFromDropdown(e); } 

		this.divElYearDropdownParentYears.appendChild(div);	

		DHTMLSuite.commonObj.__addEventEl(div);		

	}		

	}

	

// }}}

	,

	

// {{{ __positionDropDownMonths()

    /**

     *	Position the year dropdown below the year in the heading.

     *	

    *@private	

     */	

	__positionDropDownMonths:function()

	{

	this.divElMonthDropdown.style.left=DHTMLSuite.commonObj.getLeftPos(this.divElMonthNInHead)+'px';

	this.divElMonthDropdown.style.top=(DHTMLSuite.commonObj.getTopPos(this.divElMonthNInHead)+this.divElMonthNInHead.offsetHeight)+'px';

	

	if(this.iframeElDropDowns){

		var st=this.iframeElDropDowns.style;

		st.left=this.divElMonthDropdown.style.left;

		st.top=this.divElMonthDropdown.style.top;

		st.width=(this.divElMonthDropdown.clientWidth)+'px';

		st.height=this.divElMonthDropdown.clientHeight+'px';

		st.display=this.divElMonthDropdown.style.display;

	}

	

	}

	

// }}}

	,

	

// {{{ __positionDropDownYears()

    /**

     *	Position the month dropdown below the month in the heading.

     *	

    *@private	

     */	

	__positionDropDownYears:function()

	{

	this.divElYearDropdown.style.left=DHTMLSuite.commonObj.getLeftPos(this.divElYearInHeading)+'px';

	this.divElYearDropdown.style.top=(DHTMLSuite.commonObj.getTopPos(this.divElYearInHeading)+this.divElYearInHeading.offsetHeight)+'px';

	if(this.iframeElDropDowns){

		var st=this.iframeElDropDowns.style;

		st.left=this.divElYearDropdown.style.left;

		st.top=this.divElYearDropdown.style.top;

		st.width=(this.divElYearDropdown.clientWidth)+'px';

		st.height=this.divElYearDropdown.clientHeight+'px';

		st.display=this.divElYearDropdown.style.display;

	}	

	

	}

	

// }}}

	,

	

// {{{ __positionDropDownHours()

    /**

     *	Position the month dropdown below the month in the heading.

     *	

    *@private	

     */	

	__positionDropDownHours:function()

	{

	this.divElHourDropdown.style.left=DHTMLSuite.commonObj.getLeftPos(this.divElHrInTimeBar)+'px';

	this.divElHourDropdown.style.top=(DHTMLSuite.commonObj.getTopPos(this.divElHrInTimeBar)+this.divElHrInTimeBar.offsetHeight)+'px';

	if(this.iframeElDropDowns){

		var st=this.iframeElDropDowns.style;

		st.left=this.divElHourDropdown.style.left;

		st.top=this.divElHourDropdown.style.top;

		st.width=(this.divElHourDropdown.clientWidth)+'px';

		st.height=this.divElHourDropdown.clientHeight+'px';

		st.display=this.divElHourDropdown.style.display;

	}	

	

	}

	

// }}}

	,

	

// {{{ __positionDropDownMinutes()

    /**

     *	Position the month dropdown below the month in the heading.

     *	

    *@private	

     */	

	__positionDropDownMinutes:function()

	{

	this.divElMinuteDropdown.style.left=DHTMLSuite.commonObj.getLeftPos(this.divElMinInTimeBar)+'px';

	this.divElMinuteDropdown.style.top=(DHTMLSuite.commonObj.getTopPos(this.divElMinInTimeBar)+this.divElMinInTimeBar.offsetHeight)+'px';

	if(this.iframeElDropDowns){

		var st=this.iframeElDropDowns.style;

		st.left=this.divElMinuteDropdown.style.left;

		st.top=this.divElMinuteDropdown.style.top;

		st.width=(this.divElMinuteDropdown.clientWidth)+'px';

		st.height=this.divElMinuteDropdown.clientHeight+'px';

		st.display=this.divElMinuteDropdown.style.display;

	}	

	

	}

	

// }}}

	,

	

// {{{ __setMonthFromDropdown()

    /**

     *	Select new month from drop down box. The id is fetched by looking at the id of the element triggering this event, i.e. a month div in the dropdown.

     *	

    *@private	

     */	

	__setMonthFromDropdown:function(e)

	{

	if(document.all)e=event;

	var src=DHTMLSuite.commonObj.getSrcElement(e);	

	this.__showHideDropDownBoxMonth();	

	this.setDisplayedMonth(src.id.replace(/[^0-9]/gi,''));

	

	}

	

// }}}

	,

	

// {{{ __setYearFromDropdown()

    /**

     *	Select new year from drop down box. The id is fetched by looking at the innerHTML of the element triggering this event, i.e. a year div in the dropdown.

     *	

    *@private	

     */	

	__setYearFromDropdown:function(e)

	{

	if(document.all)e=event;

	var src=DHTMLSuite.commonObj.getSrcElement(e);	

	this.__showHideDropDownBoxYear();	

	this.setDisplayedYear(src.innerHTML);

	

	}

	

// }}}

	,

	

// {{{ __setHourFromDropdown()

    /**

     *	Set displayed hour from drop down box

     *	

    *@private	

     */		

	__setHourFromDropdown:function(e)

	{

	if(document.all)e=event;

	var src=DHTMLSuite.commonObj.getSrcElement(e);	

	this.__showHideDropDownBoxHour();	

	this.setDisplayedHour(src.innerHTML);	

	

	}

	,

	

// {{{ __setMinuteFromDropdown()

    /**

     *	Set displayed hour from drop down box

     *

    *@private	

     */		

	__setMinuteFromDropdown:function(e)

	{

	if(document.all)e=event;

	var src=DHTMLSuite.commonObj.getSrcElement(e);	

	this.__showHideDropDownBoxMinute();	

	this.setDisplayedMinute(src.innerHTML);	

	

	}

	

	

// }}}

	,

	

// {{{ __autoHideDropDownBoxes()

    /**

     *	Automatically hide drop down boxes when users click someplace on the page except in the headings triggering these dropdowns.

     *	

    *@private	

     */	

	__autoHideDropDownBoxes:function(e)

	{

	if(document.all)e=event;

	var src=DHTMLSuite.commonObj.getSrcElement(e);

	if(src.className.indexOf('MonthAndYear')>=0||src.className.indexOf('HourAndMinute')>=0){	

// class name of element same as element triggering the dropdowns ?

		if(DHTMLSuite.commonObj.isObjectClicked(this.divElement,e))return;	

// if element clicked is a sub element of main calendar div-return

	

	}

	this.__showHideDropDownBoxMonth('none');

	this.__showHideDropDownBoxYear('none');

	this.__showHideDropDownBoxHour('none');

	this.__showHideDropDownBoxMinute('none');

	

	}

	

// }}}

	,

	

// {{{ __showHideDropDownBoxMonth()

    /**

     *	Show or hide month drop down box

     *	

    *@private	

     */	

	__showHideDropDownBoxMonth:function(forcedDisplayAttribute)

	{

	if(!forcedDisplayAttribute){

		this.__showHideDropDownBoxYear('none');	

// Hide year drop down.

		this.__showHideDropDownBoxHour('none');	

// Hide year drop down.		

	}

	if(forcedDisplayAttribute){

		this.divElMonthDropdown.style.display=forcedDisplayAttribute;

	}else{

		this.divElMonthDropdown.style.display=(this.divElMonthDropdown.style.display=='block'?'none':'block');

	}

	this.__populateDropDownMonths();

	this.__positionDropDownMonths();	



	

	}

	

// }}}

	,

	

// {{{ __showHideDropDownBoxYear()

    /**

     *	Create main div elements for the calendar

     *	

    *@private	

     */	

	__showHideDropDownBoxYear:function(forcedDisplayAttribute)

	{

	if(!forcedDisplayAttribute){

		this.__showHideDropDownBoxMonth('none');	

// Hide year drop down.

		this.__showHideDropDownBoxHour('none');	

// Hide year drop down.

		this.__showHideDropDownBoxMinute('none');	

// Hide year drop down.

	}

	if(forcedDisplayAttribute){

		this.divElYearDropdown.style.display=forcedDisplayAttribute;

	}else{

		this.divElYearDropdown.style.display=(this.divElYearDropdown.style.display=='block'?'none':'block');

	}

	if(this.divElYearDropdown.style.display=='none' ){

		this.yearDropDownOffsetInYear=0;

	}else{

		this.__populateDropDownYears();

	}

	this.__positionDropDownYears();

	

	}	

	

// }}}

	,	

	

// {{{ __showHideDropDownBoxHour()

    /**

     *	Create main div elements for the calendar

     *	

    *@private	

     */	

	__showHideDropDownBoxHour:function(forcedDisplayAttribute)

	{

	if(!forcedDisplayAttribute){

		this.__showHideDropDownBoxYear('none');	

// Hide Hour drop down.

		this.__showHideDropDownBoxMonth('none');	

// Hide Hour drop down.

		this.__showHideDropDownBoxMinute('none');	

// Hide Hour drop down.

		

	}

	if(forcedDisplayAttribute){

		this.divElHourDropdown.style.display=forcedDisplayAttribute;

	}else{

		this.divElHourDropdown.style.display=(this.divElHourDropdown.style.display=='block'?'none':'block');

	}

	if(this.divElHourDropdown.style.display=='none' ){

		this.hourDropDownOffsetInHour=0;

	}else{

		this.__populateDropDownHours();

	}

	this.__positionDropDownHours();

	

	}

	

// }}}

	,	

	

// {{{ __showHideDropDownBoxMinute()

    /**

     *	Create main div elements for the calendar

     *	

    *@private	

     */	

	__showHideDropDownBoxMinute:function(forcedDisplayAttribute)

	{

	if(!forcedDisplayAttribute){

		this.__showHideDropDownBoxYear('none');	

// Hide Minute drop down.

		this.__showHideDropDownBoxMonth('none');	

// Hide Minute drop down.

		this.__showHideDropDownBoxHour('none');	

// Hide Minute drop down.

		

	}

	if(forcedDisplayAttribute){

		this.divElMinuteDropdown.style.display=forcedDisplayAttribute;

	}else{

		this.divElMinuteDropdown.style.display=(this.divElMinuteDropdown.style.display=='block'?'none':'block');

	}

	if(this.divElMinuteDropdown.style.display=='none' ){

		this.minuteDropDownOffsetInMinute=0;

	}else{

		this.__populateDropDownMinutes();

	}

	this.__positionDropDownMinutes();

	

	}	

	

// }}}

	,	

	

// {{{ __createMainHtmlEls()

    /**

     *	Create main div elements for the calendar

     *

    *@private	

     */	

	__createMainHtmlEls:function()

	{

	this.divElement=document.createElement('DIV');

	this.divElement.className='DHTMLSuite_calendar';

	this.divElContent=document.createElement('DIV');

	this.divElement.appendChild(this.divElContent);

	this.divElContent.className='DHTMLSuite_calendarContent';

	if(this.targetReference)this.targetReference.appendChild(this.divElement);else document.body.appendChild(this.divElement);

	if(this.isDragable){

		try{

		this.referenceToDragDropObject=new DHTMLSuite.dragDropSimple({ elementReference: this.divElement });	

		}catch(e){

		alert('You need to include DHTMLSuite-dragDropSimple.js for the drag feature');

		}

	}

	if(DHTMLSuite.clientInfoObj.isMSIE&&DHTMLSuite.clientInfoObj.navigatorVersion<8){		

		this.iframeEl=document.createElement('<iframe src="about:blank" frameborder="0">');

		this.iframeEl.className='DHTMLSuite_calendar_iframe';

		this.iframeEl.style.left='0px';

		this.iframeEl.style.top='0px';

		this.iframeEl.style.position='absolute';

		this.divElement.appendChild(this.iframeEl);

		

		this.iframeElDropDowns=document.createElement('<iframe src="about:blank" frameborder="0">');

		this.iframeElDropDowns.className='DHTMLSuite_calendar_iframe';

		this.iframeElDropDowns.style.display='none';

		document.body.appendChild(this.iframeElDropDowns);		

	}

	}

	

// }}}

	,

	

// {{{ __createHeadingElements()

    /**

     *	Create main div elements for the calendar

     *

    *@private	

     */	

	__createHeadingElements:function()

	{

	this.divElHeading=document.createElement('DIV');	

	

	if(this.isDragable){	/* Calendar is dragable */

		this.referenceToDragDropObject.addDragHandle(this.divElHeading);

		this.divElHeading.style.cursor='move';

	}	

	

	this.divElHeading.className='DHTMLSuite_calendarHeading';

	this.divElContent.appendChild(this.divElHeading);

	this.divElHeading.style.position='relative';

	

	this.divElClose=document.createElement('DIV');

	this.divElClose.innerHTML='<span></span>';

	this.divElClose.className='DHTMLSuite_calendarCloseButton';

	this.divElHeading.appendChild(this.divElClose);

	if(!this.displayCloseButton)this.divElClose.style.display='none';

	

	this.divElHeadingTxt=document.createElement('DIV');

	this.divElHeadingTxt.className='DHTMLSuite_calendarHeadingTxt';

	

	if(DHTMLSuite.clientInfoObj.isMSIE){

		var table=document.createElement('<TABLE cellpadding="0" cellspacing="0" border="0">');

	}else{

		var table=document.createElement('TABLE');

		table.setAttribute('cellpadding',0);

		table.setAttribute('cellspacing',0);

		table.setAttribute('border',0);

	}

	table.style.margin='0 auto';

	var tbody=document.createElement('TBODY');

	table.appendChild(tbody);

	this.divElHeadingTxt.appendChild(table);

	

	var row=tbody.insertRow(0);

	

	var cell=row.insertCell(-1);	

	this.divElMonthNInHead=document.createElement('DIV');

	this.divElMonthNInHead.className='DHTMLSuite_calendarHeaderMonthAndYear';

	

	cell.appendChild(this.divElMonthNInHead);	

	

	var cell=row.insertCell(-1);	

	var span=document.createElement('SPAN');

	span.innerHTML=', ';

	cell.appendChild(span);

	

	var cell=row.insertCell(-1);	

	this.divElYearInHeading=document.createElement('DIV');

	

	this.divElYearInHeading.className='DHTMLSuite_calendarHeaderMonthAndYear';

	cell.appendChild(this.divElYearInHeading);

	

	this.divElHeading.appendChild(this.divElHeadingTxt);



	}

	

// }}}

	,

	

// {{{ __createNavigationBar()

    /**

     *	Create navigation bar elements below the heading.

    *@private	

     */	

	__createNavigationBar:function()

	{

	this.divElNavBar=document.createElement('DIV');

	this.divElNavBar.className='DHTMLSuite_calendar_navigationBar';

	this.divElContent.appendChild(this.divElNavBar);	

	

	this.divElBtnPreviousYear=document.createElement('DIV');	

	this.divElBtnPreviousYear.className='DHTMLSuite_calendar_btnPreviousYear';

	this.divElBtnPreviousYear.innerHTML='<span></span>';

	this.divElNavBar.appendChild(this.divElBtnPreviousYear);

	

	

	this.divElBtnNextYear=document.createElement('DIV');	

	this.divElBtnNextYear.className='DHTMLSuite_calendar_btnNextYear';

	this.divElBtnNextYear.innerHTML='<span></span>';

	this.divElNavBar.appendChild(this.divElBtnNextYear);

	

	

	this.divElBtnPrvMonth=document.createElement('DIV');	

	this.divElBtnPrvMonth.className='DHTMLSuite_calendar_btnPreviousMonth';

	this.divElBtnPrvMonth.innerHTML='<span></span>';

	this.divElNavBar.appendChild(this.divElBtnPrvMonth);

	

	

	this.divElBtnNextMonth=document.createElement('DIV');	

	this.divElBtnNextMonth.className='DHTMLSuite_calendar_btnNextMonth';

	this.divElBtnNextMonth.innerHTML='<span></span>';

	this.divElNavBar.appendChild(this.divElBtnNextMonth);

	

	this.divElTodayInNavBar=document.createElement('DIV');

	this.divElTodayInNavBar.className='DHTMLSuite_calendar_navigationBarToday';

	this.divElNavBar.appendChild(this.divElTodayInNavBar);

	

	if(!this.displayNavigationBar)this.divElNavBar.style.display='none';

	if(!this.displayTodaysDateInNavigationBar)this.divElTodayInNavBar.style.display='none';

	

	}

	

// }}}

	,

	

// {{{ __populateNavigationBar()

    /**

     *	Populate navigation bar, i.e. display the "Today" string and add an onclick event on this span tag. this onclick events makes the calendar display current month.

     *	

    *@private	

     */	

	__populateNavigationBar:function()

	{

	var ind=this.objectIndex;

	this.divElTodayInNavBar.innerHTML='';

	var span=document.createElement('SPAN');

	span.innerHTML=this.calendarModelReference.__getTodayAsString();

	span.onclick=function(){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__displayMonthOfToday(); } 

	this.divElTodayInNavBar.appendChild(span);

	DHTMLSuite.commonObj.__addEventEl(span);

	}

	

// }}}

	,

	

// {{{ __createCalMonthView()

    /**

     *	Create div element for the month view

     *	

    *@private	

     */	

	__createCalMonthView:function()

	{

	this.divElMonthView=document.createElement('DIV');

	this.divElMonthView.className='DHTMLSuite_calendar_monthView';

	this.divElContent.appendChild(this.divElMonthView);

	}

	

// }}}

	,

	

// {{{ __populateMonthView()

    /**

     *	Populate month view with month data, i.e. heading weeks, days, months.

     *	

    *@private	

     */	

	__populateMonthView:function()

	{

	var ind=this.objectIndex;



	this.divElMonthView.innerHTML='';

	var modelRef=this.calendarModelReference;

		

	if(DHTMLSuite.clientInfoObj.isMSIE){

		var table=document.createElement('<TABLE cellpadding="1" cellspacing="0" border="0" width="100%">');

	}else{

		var table=document.createElement('TABLE');

		table.setAttribute('cellpadding',1);

		table.setAttribute('cellspacing',0);

		table.setAttribute('border',0);

		table.width='100%';

	}

	

	var tbody=document.createElement('TBODY');

	table.appendChild(tbody);

	this.divElMonthView.appendChild(table);

	

	var row=tbody.insertRow(-1);	

// Insert a new row at the end of the table

	row.className='DHTMLSuite_calendar_monthView_headerRow';

	

	var cell=row.insertCell(-1);

	cell.className='DHTMLSuite_calendar_monthView_firstColumn';

	cell.innerHTML=modelRef.__getStringWeek();

	

	if(modelRef.getWeekStartsOnMonday()){

		var days=modelRef.__getDaysMondayToSunday();

	}else{

		var days=modelRef.__getDaysSundayToSaturday();

	}

	

	/* Outputs days in the week */

	for(var no=0;no<days.length;no++){

		var cell=row.insertCell(-1);

		cell.innerHTML=days[no];

		cell.className='DHTMLSuite_calendar_monthView_headerCell';

		if(modelRef.getWeekStartsOnMonday()&&no==6){

		cell.className='DHTMLSuite_calendar_monthView_headerSunday';

		}

		if(!modelRef.getWeekStartsOnMonday()&&no==0){

		cell.className='DHTMLSuite_calendar_monthView_headerSunday';

		}		

	}	

	

	

// First row of days

	var row=tbody.insertRow(-1);

	var cell=row.insertCell(-1);

	cell.className='DHTMLSuite_calendar_monthView_firstColumn';

	var week=modelRef.__getWeekNumberFromDayMonthAndYear(modelRef.__getDisplayedYear(),modelRef.__getDisplayedMonthNumber(),1);

	

	cell.innerHTML=week>0?week:53;

	

	var daysRemainingInPreviousMonth=modelRef.__getRemainingDaysInPreviousMonthAsArray();

	for(var no=0;no<daysRemainingInPreviousMonth.length;no++){

		var cell=row.insertCell(-1);

		cell.innerHTML=daysRemainingInPreviousMonth[no];	

		cell.className='DHTMLSuite_calendar_monthView_daysInOtherMonths';	

	}

	

	var daysInCurrentMonth=modelRef.__getNumberOfDaysInCurrentDisplayedMonth();

	var cellCounter=daysRemainingInPreviousMonth.length+1;

	/* Loop through days in this month */

	for(var no=1;no<=daysInCurrentMonth;no++){		

		var cell=row.insertCell(-1);

		cell.innerHTML=no;

		cell.className='DHTMLSuite_calendar_monthView_daysInThisMonth';



		DHTMLSuite.commonObj.__addEventEl(cell);	

		if(cellCounter%7==0&&modelRef.getWeekStartsOnMonday()){

		cell.className='DHTMLSuite_calendar_monthView_sundayInThisMonth';

		}

		if(cellCounter%7==1&&!modelRef.getWeekStartsOnMonday()){

		cell.className='DHTMLSuite_calendar_monthView_sundayInThisMonth';

		}

		

// Day displayed the same as inital date ?

		if(no==modelRef.__getInitialDay()&&modelRef.__getDisplayedYear()==modelRef.__getInitialYear()&&modelRef.__getDisplayedMonthNumber()==modelRef.__getInitialMonthNumber()){

		cell.className='DHTMLSuite_calendar_monthView_initialDate';	

		}

		if(!modelRef.isDateWithinValidRange({year:modelRef.__getDisplayedYear(),month:modelRef.__getDisplayedMonthNumber(),day:no})){

		cell.className='DHTMLSuite_calendar_monthView_invalidDate';	

		}else{

		cell.onmousedown=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__mousedownOnDayInCalendar(e); } 

		cell.onmouseover=this.__mouseoverCalendarDay;

		cell.onmouseout=this.__mouseoutCalendarDay;

		DHTMLSuite.commonObj.__addEventEl(cell);		

		

		}

		

// Day displayed the same as date of today ?

		if(no==this.dateOfToday.getDate()&&modelRef.__getDisplayedYear()==this.dateOfToday.getFullYear()&&modelRef.__getDisplayedMonthNumber()==(this.dateOfToday.getMonth()+1)){

		cell.className='DHTMLSuite_calendar_monthView_currentDate';	

		}		

		if(cellCounter%7==0&&no<daysInCurrentMonth){

		var row=tbody.insertRow(-1);	

		var cell=row.insertCell(-1)

		cell.className='DHTMLSuite_calendar_monthView_firstColumn';

		week++

		cell.innerHTML=week;		

		}

		cellCounter++;

	}

	

	

// Adding the first days of the next month to the view	

	if((cellCounter-1)%7>0){

		var dayCounter=1;

		for(var no=(cellCounter-1)%7;no<7;no++){

		var cell=row.insertCell(-1);

		cell.innerHTML=dayCounter;

		cell.className='DHTMLSuite_calendar_monthView_daysInOtherMonths';	

		dayCounter++;

		}

	}

	

	}

	

// }}}

	,

	

// {{{ __createTimeBar()

    /**

     *	Create bar where users can select hours and minutes.

     *	

    *@private	

     */	

	__createTimeBar:function()

	{

	this.divElTimeBar=document.createElement('DIV');

	this.divElTimeBar.className='DHTMLSuite_calendar_timeBar';

	this.divElContent.appendChild(this.divElTimeBar);	

	

	

	if(DHTMLSuite.clientInfoObj.isMSIE){

		var table=document.createElement('<TABLE cellpadding="0" cellspacing="0" border="0">');

	}else{

		var table=document.createElement('TABLE');

		table.setAttribute('cellpadding',0);

		table.setAttribute('cellspacing',0);

		table.setAttribute('border',0);

	}

	table.style.margin='0 auto';

	this.divElTimeBar.appendChild(table);

	

	var row=table.insertRow(0);

	

	var cell=row.insertCell(-1);	

	this.divElHrInTimeBar=document.createElement('DIV');

	this.divElHrInTimeBar.className='DHTMLSuite_calendar_timeBarHourAndMinute';	

	cell.appendChild(this.divElHrInTimeBar);	



	var cell=row.insertCell(-1);	

	var span=document.createElement('SPAN');

	span.innerHTML=':';

	cell.appendChild(span);

		

	var cell=row.insertCell(-1);	

	this.divElMinInTimeBar=document.createElement('DIV');	

	this.divElMinInTimeBar.className='DHTMLSuite_calendar_timeBarHourAndMinute';

	cell.appendChild(this.divElMinInTimeBar);

	

	this.divElTimeStringInTimeBar=document.createElement('DIV');

	this.divElTimeStringInTimeBar.className='DHTMLSuite_calendarTimeBarTimeString'; 

	this.divElTimeBar.appendChild(this.divElTimeStringInTimeBar);

	

	if(!this.displayTimeBar)this.divElTimeBar.style.display='none';

		

	}

	

// }}}

	,

	

// {{{ __populateTimeBar()

    /**

     *	Populate time time bar with hour and minutes.

     *	

    *@private	

     */	

	__populateTimeBar:function()

	{

	this.divElHrInTimeBar.innerHTML=this.calendarModelReference.__getDisplayedHourWithLeadingZeros();

	this.divElMinInTimeBar.innerHTML=this.calendarModelReference.__getDisplayedMinuteWithLeadingZeros();	

	this.divElTimeStringInTimeBar.innerHTML=this.calendarModelReference.__getTimeAsString()+':';

	

	}

	

// }}}

	,

	

// {{{ __populateCalHeading()

    /**

     *	Populate heading of calendar

     *	

    *@private	

     */	

	__populateCalHeading:function()

	{	

	

	this.divElMonthNInHead.innerHTML=this.calendarModelReference.__getMonthNameByMonthNumber(this.calendarModelReference.__getDisplayedMonthNumber());

	this.divElYearInHeading.innerHTML=this.calendarModelReference.__getDisplayedYear();

	}

	

// }}}

	,

	

// {{{ __mousedownOnDayInCalendar()

    /**

     *	Mouse down day inside the calendar view. Set current displayed date to the clicked date and check for call back functions.

     *	

    *@private	

     */	

	__mousedownOnDayInCalendar:function(e)

	{

	if(document.all)e=event;

	var src=DHTMLSuite.commonObj.getSrcElement(e);

	this.calendarModelReference.__setDisplayedDay(src.innerHTML);

	this.__handleCalendarCallBack('dayClick');

	}

	

// }}}

	,

	

// {{{ __handleCalendarCallBack()

    /**

     *	This method handles all call backs from the calendar

     *	

    *@private	

     */	

	__handleCalendarCallBack:function(action)

	{

	var callbackString='';

	switch(action){

		case 'dayClick':

		if(this.callbackFunctionOnDayClick)callbackString=this.callbackFunctionOnDayClick;

		break;	

		case "monthChange":

		if(this.callbackFunctionOnMonthChange)callbackString=this.callbackFunctionOnMonthChange;

		break;	

		case "calendarClose":

		if(this.callbackFunctionOnClose)callbackString=this.callbackFunctionOnClose;

		break;

			

	}	

	

	if(callbackString){

		callbackString=callbackString+

		'({'

		+ ' year:'+this.calendarModelReference.__getDisplayedYear()

		+ ',month:"'+this.calendarModelReference.__getDisplayedMonthNumberWithLeadingZeros()+'"'

		+ ',day:"'+this.calendarModelReference.__getDisplayedDayWithLeadingZeros()+'"'

		+ ',hour:"'+this.calendarModelReference.__getDisplayedHourWithLeadingZeros()+'"'

		+ ',minute:"'+this.calendarModelReference.__getDisplayedMinuteWithLeadingZeros()+'"'

		+ ',calendarRef:this'

		

		callbackString=callbackString+'})';

	}

	

	if(callbackString)return this.__evaluateCallBackString(callbackString);	

	}

	

// }}}

	,

	

// {{{ __evaluateCallBackString()

    /**

     *	Evaluate call back string.

     *	

     *

     *

    *@private	

     */	

	__evaluateCallBackString:function(callbackString)

	{

	try{

		return eval(callbackString);

	}catch(e){

		alert('Could not excute call back function '+callbackString+'\n'+e.message);

	}	

	}

	

// }}}

	,

	

// {{{ __displayMonthOfToday()

    /**

     *	Show calendar data for present day

     *	

    *@private	

     */	

	__displayMonthOfToday:function()

	{

	var d=new Date();

	var month=d.getMonth()+1;

	var year=d.getFullYear();

	this.setDisplayedYear(year);

	this.setDisplayedMonth(month);		

	}

	

// }}}

	,

	

// {{{ __moveOneYearBack()

    /**

     *	Show calendar data for the same month in previous year

     *	

    *@private	

     */	

	__moveOneYearBack:function()

	{	

	this.calendarModelReference.__moveOneYearBack();

	this.__populateCalHeading();

	this.__populateMonthView();

	this.__handleCalendarCallBack('monthChange');

	}

	

// }}}

	,

	

// {{{ __moveOneYearForward()

    /**

     *	Show calendar data for the same month in next year

     *	

     *

     *

    *@private	

     */	

	__moveOneYearForward:function()

	{

	this.calendarModelReference.__moveOneYearForward();

	this.__populateCalHeading();

	this.__populateMonthView();

	this.__handleCalendarCallBack('monthChange');	

	}

	

// }}}

	,

	

// {{{ __moveOneMonthBack()

    /**

     *	Show calendar data for previous month

     *

     *

    *@private	

     */	

	__moveOneMonthBack:function()

	{

	this.calendarModelReference.__moveOneMonthBack();

	this.__populateCalHeading();

	this.__populateMonthView();

	this.__handleCalendarCallBack('monthChange');

	}

	

// }}}

	,

	

// {{{ __moveOneMonthForward()

    /**

     *	Move one month forward

     *

     *

    *@private	

     */	

	__moveOneMonthForward:function()

	{

	this.calendarModelReference.__moveOneMonthForward();

	this.__populateCalHeading();

	this.__populateMonthView();

	this.__handleCalendarCallBack('monthChange');	

	}

	

// }}}

	,

	

// {{{ __addEvents()

    /**

     *	Add events to calendar elements.

     *	

     *

     *

    *@private	

     */	

	__addEvents:function()

	{

	var ind=this.objectIndex;

	this.divElClose.onmouseover=this.__mouseoverCalendarButton;

	this.divElClose.onmouseout=this.__mouseoutCalendarButton;

	this.divElClose.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].hide(); }

	DHTMLSuite.commonObj.__addEventEl(this.divElClose);	

	

	

// Button-previous year

	this.divElBtnPreviousYear.onmouseover=this.__mouseoverCalendarButton;

	this.divElBtnPreviousYear.onmouseout=this.__mouseoutCalendarButton;

	this.divElBtnPreviousYear.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOneYearBack(); }

	DHTMLSuite.commonObj.__addEventEl(this.divElBtnPreviousYear);	

	

	

// Button-next year

	this.divElBtnNextYear.onmouseover=this.__mouseoverCalendarButton;

	this.divElBtnNextYear.onmouseout=this.__mouseoutCalendarButton;

	this.divElBtnNextYear.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOneYearForward(); }

	DHTMLSuite.commonObj.__addEventEl(this.divElBtnNextYear);	

	

	

// Button previous month

	this.divElBtnPrvMonth.onmouseover=this.__mouseoverCalendarButton;

	this.divElBtnPrvMonth.onmouseout=this.__mouseoutCalendarButton;

	this.divElBtnPrvMonth.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOneMonthBack(); }

	DHTMLSuite.commonObj.__addEventEl(this.divElBtnPrvMonth);	

	

	

// Button next month

	this.divElBtnNextMonth.onmouseover=this.__mouseoverCalendarButton;

	this.divElBtnNextMonth.onmouseout=this.__mouseoutCalendarButton;

	this.divElBtnNextMonth.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOneMonthForward(); }

	DHTMLSuite.commonObj.__addEventEl(this.divElBtnNextMonth);		

	

	

// Year in the heading

	this.divElYearInHeading.onmouseover=this.__mouseoverMonthAndYear;

	this.divElYearInHeading.onmouseout=this.__mouseoutMonthAndYear;

	this.divElYearInHeading.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__showHideDropDownBoxYear(); }

	DHTMLSuite.commonObj.__addEventEl(this.divElYearInHeading);	



	

// Month in the heading	

	this.divElMonthNInHead.onmouseover=this.__mouseoverMonthAndYear;

	this.divElMonthNInHead.onmouseout=this.__mouseoutMonthAndYear;

	this.divElMonthNInHead.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__showHideDropDownBoxMonth(); }

	DHTMLSuite.commonObj.__addEventEl(this.divElMonthNInHead);	

	

	

// Hour in timer bar

	this.divElHrInTimeBar.onmouseover=this.__mouseoverHourAndMinute;

	this.divElHrInTimeBar.onmouseout=this.__mouseoutHourAndMinute;

	this.divElHrInTimeBar.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__showHideDropDownBoxHour(); }

	DHTMLSuite.commonObj.__addEventEl(this.divElHrInTimeBar);	



	

// Minute in timer bar	

	this.divElMinInTimeBar.onmouseover=this.__mouseoverHourAndMinute;

	this.divElMinInTimeBar.onmouseout=this.__mouseoutHourAndMinute;

	this.divElMinInTimeBar.onclick=function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__showHideDropDownBoxMinute(); }

	DHTMLSuite.commonObj.__addEventEl(this.divElMinInTimeBar);	

	

	

// Disable text selection in the heading

	this.divElHeading.onselectstart=function(){ return false; };

	DHTMLSuite.commonObj.__addEventEl(this.divElHeading);

	

	DHTMLSuite.commonObj.addEvent(document.documentElement,'click',function(e){ DHTMLSuite.variableStorage.arrayDSObjects[ind].__autoHideDropDownBoxes(e); },ind+'');

	

	}

	

// }}}

	,

	

// {{{ __resizePrimaryiframeEl()

    /**

     *	Resize primary iframe element.

     *	

     *

     *

    *@private	

     */	

	__resizePrimaryiframeEl:function()

	{

	if(!this.iframeEl)return;

	this.iframeEl.style.width=this.divElement.clientWidth+'px';

	this.iframeEl.style.height=this.divElement.clientHeight+'px';

	

	}

	

// }}}

	,

	

// {{{ __scrollInYearDropDown()

    /**

     *	Scroll the year drop down as long as the scrollInYearDropDownActive is true

     *	

     *

     *

    *@private	

     */	

	__scrollInYearDropDown:function(scrollDirection)

	{

	if(!this.scrollInYearDropDownActive)return;

	var ind=this.objectIndex;	

	this.yearDropDownOffsetInYear+=scrollDirection;

	this.__populateYearsInsideDropDownYears();

	setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__scrollInYearDropDown('+scrollDirection+')',150);

	}

	

	

// }}}

	,

	

// {{{ __mouseoverUpAndDownArrowsInDropDownYears()

    /**

     *	Mouse over year drop down arrow

     *	

    *@private	

     */	

	__mouseoverUpAndDownArrowsInDropDownYears:function(e)

	{

	var ind=this.objectIndex;

	

	if(document.all)e=event;

	var src=DHTMLSuite.commonObj.getSrcElement(e);

	var scrollDirection=(src.className.toLowerCase().indexOf('up')>=0?-1:1);

	src.className=src.className+' DHTMLSuite_calendarDropDown_dropDownArrowOver';	

	this.scrollInYearDropDownActive=true;	

	setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__scrollInYearDropDown('+scrollDirection+')',100);

	}

	

// }}}

	,

	

// {{{ __mouseoutUpAndDownArrowsInDropDownYears()

    /**

     *	Mouse away from year drop down arrow

     *	

    *@private	

     */	

	__mouseoutUpAndDownArrowsInDropDownYears:function(e)

	{

	if(document.all)e=event;

	var src=DHTMLSuite.commonObj.getSrcElement(e);

	src.className=src.className.replace(' DHTMLSuite_calendarDropDown_dropDownArrowOver','');	

	this.scrollInYearDropDownActive=false;	

	}

	

// }}}

	,

	

// {{{ __scrollInYearDropDown()

    /**

     *	Scroll the year drop down as long as the scrollInYearDropDownActive is true

     *	

     *

     *

    *@private	

     */	

	__scrollInHourDropDown:function(scrollDirection)

	{

	if(!this.scrollInHourDropDownActive)return;

	var ind=this.objectIndex;	

	this.hourDropDownOffsetInHour+=scrollDirection;

	this.__populateHoursInsideDropDownHours();

	setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__scrollInHourDropDown('+scrollDirection+')',150);

	}

	

	

// }}}

	,	

	

// {{{ __mouseoverUpAndDownArrowsInDropDownHours()

    /**

     *	Mouse over arrows inside drop down (hour)

     *	

     *

     *

    *@private	

     */	

	__mouseoverUpAndDownArrowsInDropDownHours:function(e)

	{

	var ind=this.objectIndex;	

	if(document.all)e=event;

	var src=DHTMLSuite.commonObj.getSrcElement(e);

	var scrollDirection=(src.className.toLowerCase().indexOf('up')>=0?-1:1);

	src.className=src.className+' DHTMLSuite_calendarDropDown_dropDownArrowOver';	

	this.scrollInHourDropDownActive=true;	

	setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__scrollInHourDropDown('+scrollDirection+')',100);

	}

	

// }}}

	,

	

// {{{ __mouseoutUpAndDownArrowsInDropDownHours()

    /**

     *	Mouse out from arrow inside hour drop down.

     *	

     *

     *

    *@private	

     */	

	__mouseoutUpAndDownArrowsInDropDownHours:function(e)

	{

	if(document.all)e=event;

	var src=DHTMLSuite.commonObj.getSrcElement(e);

	src.className=src.className.replace(' DHTMLSuite_calendarDropDown_dropDownArrowOver','');	

	this.scrollInHourDropDownActive=false;	

	}

	

// }}}	

	,

	

// {{{ __scrollInYearDropDown()

    /**

     *	Scroll the year drop down as long as the scrollInYearDropDownActive is true

     *	

     *

     *

    *@private	

     */	

	__scrollInMinuteDropDown:function(scrollDirection)

	{

	if(!this.scrollInMinuteDropDownActive)return;

	var ind=this.objectIndex;	

	this.minuteDropDownOffsetInMinute+=scrollDirection;

	this.__populateMinutesInsideDropDownMinutes();

	setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__scrollInMinuteDropDown('+scrollDirection+')',150);

	}

	

	

// }}}

	,	

	

// {{{ __mouseoverUpAndDownArrowsInDropDownMinutes()

    /**

     *	Mouse over arrows inside drop down (minute)

     *	

    *@private	

     */	

	__mouseoverUpAndDownArrowsInDropDownMinutes:function(e)

	{

	var ind=this.objectIndex;	

	if(document.all)e=event;

	var src=DHTMLSuite.commonObj.getSrcElement(e);

	var scrollDirection=(src.className.toLowerCase().indexOf('up')>=0?-1:1);

	src.className=src.className+' DHTMLSuite_calendarDropDown_dropDownArrowOver';	

	this.scrollInMinuteDropDownActive=true;	

	setTimeout('DHTMLSuite.variableStorage.arrayDSObjects['+ind+'].__scrollInMinuteDropDown('+scrollDirection+')',100);

	}

	

// }}}

	,

	

// {{{ __mouseoutUpAndDownArrowsInDropDownMinutes()

    /**

     *	Mouse out from arrow inside minute drop down.

     *	

    *@private	

     */	

	__mouseoutUpAndDownArrowsInDropDownMinutes:function(e)

	{

	if(document.all)e=event;

	var src=DHTMLSuite.commonObj.getSrcElement(e);

	src.className=src.className.replace(' DHTMLSuite_calendarDropDown_dropDownArrowOver','');	

	this.scrollInMinuteDropDownActive=false;	

	}

	

// }}}

	,

	

// {{{ __mouseoverYearInDropDown()

    /**

     *	Mouse over-year in year drop down.

     *	

    *@private	

     */	

	__mouseoverYearInDropDown:function()

	{

	this.className=this.className+' DHTMLSuite_calendar_dropdownAYearOver';	

	

	}

	

// }}}

	,

	

// {{{ __mouseoutYearInDropDown()

    /**

     *	Mouse over-year in year drop down.

     *	

    *@private	

     */	

	__mouseoutYearInDropDown:function()

	{

	this.className=this.className.replace(' DHTMLSuite_calendar_dropdownAYearOver','');

	

	}

	

// }}}

	,

	

// {{{ __mouseoverHourInDropDown()

    /**

     *	Mouse over-hour in hour drop down.

     *	

    *@private	

     */	

	__mouseoverHourInDropDown:function()

	{

	this.className=this.className+' DHTMLSuite_calendar_dropdownAnHourOver';	

	

	}

	

// }}}

	,

	

// {{{ __mouseoutHourInDropDown()

    /**

     *	Mouse out-hour in hour drop down.

     *	

    *@private	

     */	

	__mouseoutHourInDropDown:function()

	{

	this.className=this.className.replace(' DHTMLSuite_calendar_dropdownAnHourOver','');

	

	}

	

// }}}

	,

	

// {{{ __mouseoverMinuteInDropDown()

    /**

     *	Mouse over effect-minute in minute drop down.

     *	

    *@private	

     */	

	__mouseoverMinuteInDropDown:function()

	{

	this.className=this.className+' DHTMLSuite_calendar_dropdownAMinuteOver';	

	

	}

	

// }}}	

	,

	

// {{{ __mouseoutMinuteInDropDown()

    /**

     *	Mouse over effect-month in minute drop down.

     *	

    *@private	

     */	

	__mouseoutMinuteInDropDown:function()

	{

	this.className=this.className.replace(' DHTMLSuite_calendar_dropdownAMinuteOver','');

	

	}

	

// }}}

	,

	

// {{{ __mouseoverMonthInDropDown()

    /**

     *	Mouse over effect-minute in month drop down.

     *	

    *@private	

     */	

	__mouseoverMonthInDropDown:function()

	{

	this.className=this.className+' DHTMLSuite_calendar_dropdownAMonthOver';	

	

	}

	

// }}}

	,

	

// {{{ __mouseoutMonthInDropDown()

    /**

     *	Mouse out effect-month in month drop down.

     *	

    *@private	

     */	

	__mouseoutMonthInDropDown:function()

	{

	this.className=this.className.replace(' DHTMLSuite_calendar_dropdownAMonthOver','');

	

	}

	

// }}}

	,

	

// {{{ __mouseoverCalendarDay()

    /**

     *	Mouse over effect-a day in the calendar view

     *	

    *@private	

     */	

	__mouseoverCalendarDay:function()

	{

	this.className=this.className+' DHTMLSuite_calendarDayOver';	

	}

	

// }}}

	,

	

// {{{ __mouseoutCalendarDay()

    /**

     *	Mouse out effect-a day in the calendar view

     *	

    *@private	

     */	

	__mouseoutCalendarDay:function()

	{	

	this.className=this.className.replace(' DHTMLSuite_calendarDayOver','');

	}

	

// }}}

	,

	

// {{{ __mouseoverCalendarButton()

    /**

     *	Mouse over effect-close button

     *	

    *@private	

     */	

	__mouseoverCalendarButton:function()

	{

	this.className=this.className+' DHTMLSuite_calendarButtonOver';

	}

	

// }}}

	,

	

// {{{ __mouseoutCalendarButton()

    /**

     *	Remove mouse over effect from close button

     *	

    *@private	

     */	

	__mouseoutCalendarButton:function()

	{

	this.className=this.className.replace(' DHTMLSuite_calendarButtonOver','');

	}	

	

// }}}

	,

	

// {{{ __mouseoverMonthAndYear()

    /**

     *	Mouse over effect-month and year in the heading

     *	

    *@private	

     */	

	__mouseoverMonthAndYear:function()

	{

	this.className=this.className+' DHTMLSuite_calendarHeaderMonthAndYearOver';	

		

	}

	

// }}}

	,

	

// {{{ __mouseoutMonthAndYear()

    /**

     *	Remove mouse over effect-month and year in the heading

     *	

    *@private	

     */		

	__mouseoutMonthAndYear:function()

	{

	this.className=this.className.replace(' DHTMLSuite_calendarHeaderMonthAndYearOver','');

	}	,

	

// {{{ __mouseoverHourAndMinute()

    /**

     *	Mouse over effect-Hour and minute in timer bar

     *	

    *@private	

     */	

	__mouseoverHourAndMinute:function()

	{

	this.className=this.className+' DHTMLSuite_calendarTimeBarHourAndMinuteOver';	

		

	}

	

// }}}

	,

	

// {{{ __mouseoutHourAndMinute()

    /**

     *	Remove mouse over effect-Hour and minute in timer bar

     *	

    *@private	

     */		

	__mouseoutHourAndMinute:function()

	{

	this.className=this.className.replace(' DHTMLSuite_calendarTimeBarHourAndMinuteOver','');

	}

	,

	

// {{{ __positionCalendar()

    /**

     *	Position the calendar

     *

    *@private	

     */	

	__positionCalendar:function()

	{

	if(!this.posRefToHtmlEl)return;

	if(this.divElement.parentNode!=document.body)document.body.appendChild(this.divElement);

	this.divElement.style.position='absolute';

	this.divElement.style.left=(DHTMLSuite.commonObj.getLeftPos(this.posRefToHtmlEl)+this.positioningOffsetXInPixels)+'px';

	this.divElement.style.top=(DHTMLSuite.commonObj.getTopPos(this.posRefToHtmlEl)+this.positioningOffsetYInPixels)+'px';

	

	}

	

// }}}	

	,

	

// {{{ __setInitialData()

    /**

     *	Set initial calendar properties sent to the constructor in an associative array

     *	

     *	@param Array props-Array of calendar properties

     *				 

    *@private	

     */	

	__setInitialData:function(props)

	{

	

	if(props.id)this.id=props.id;	

	if(props.targetReference)this.targetReference=props.targetReference;	

	if(props.calendarModelReference)this.calendarModelReference=props.calendarModelReference;	

	if(props.callbackFunctionOnDayClick)this.callbackFunctionOnDayClick=props.callbackFunctionOnDayClick;	

	if(props.callbackFunctionOnMonthChange)this.callbackFunctionOnMonthChange=props.callbackFunctionOnMonthChange;	

	if(props.callbackFunctionOnClose)this.callbackFunctionOnClose=props.callbackFunctionOnClose;

	if(props.displayCloseButton||props.displayCloseButton===false)this.displayCloseButton=props.displayCloseButton;

	if(props.displayNavigationBar||props.displayNavigationBar===false)this.displayNavigationBar=props.displayNavigationBar;

	if(props.displayTodaysDateInNavigationBar||props.displayTodaysDateInNavigationBar===false)this.displayTodaysDateInNavigationBar=props.displayTodaysDateInNavigationBar;

	if(props.minuteDropDownInterval)this.minuteDropDownInterval=props.minuteDropDownInterval;

	if(props.numberOfRowsInHourDropDown)this.numberOfRowsInHourDropDown=props.numberOfRowsInHourDropDown;

	if(props.numberOfRowsInMinuteDropDown)this.numberOfRowsInHourDropDown=props.numberOfRowsInMinuteDropDown;

	if(props.numberOfRowsInYearDropDown)this.numberOfRowsInYearDropDown=props.numberOfRowsInYearDropDown;

	if(props.isDragable||props.isDragable===false)this.isDragable=props.isDragable;

	if(props.displayTimeBar||props.displayTimeBar===false)this.displayTimeBar=props.displayTimeBar;

		

	}

	

// }}}	

	

}
