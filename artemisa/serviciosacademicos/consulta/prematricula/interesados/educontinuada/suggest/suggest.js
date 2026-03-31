/* URL to the PHP page called for receiving suggestions for a keyword*/
var getFunctionsUrl = "grid.php?keyword=";
/* URL for seeing the results for the selected suggestion */
var phpHelpUrl="grid.php";
/* the keyword for which an HTTP request has been initiated */
var httpRequestKeyword = "";
/* the last keyword for which suggests have been requested */
var userKeyword = "";
/* number of suggestions received as results for the keyword */
var suggestions = 0;
/* the maximum number of characters to be displayed for a suggestion */
var suggestionMaxLength = 30;
/* flag that indicates if the up or down arrow keys were pressed
the last time a keyup event occurred */
var isKeyUpDownPressed = false;
/* the last suggestion that has been used for autocompleting the keyword */
var autocompletedKeyword = "";
/* flag that indicates if there are results for the current requested keyword*/
var hasResults = false;
/* the identifier used to cancel the evaluation with the clearTimeout method. */
var timeoutId = -1;
/* the currently selected suggestion (by arrow keys or mouse)*/
var position = -1;
/* cache object containing the retrieved suggestions for different keywords */
var oCache = new Object();
/* the minimum and maximum position of the visible suggestions */
var minVisiblePosition = 0;
var maxVisiblePosition = 9;
// when set to true, display detailed error messages
var debugMode = true;
/* the XMLHttp object for communicating with the server */
var xmlHttpGetSuggestions = createXmlHttpRequestObject2();
/* Columna seleccionada*/
var columna=1;
var selectColumna=1;
var buscaParametro=false;
/* the onload event is handled by our init function */
var seleccionado="";
var conini=0;
//window.onload = init2();

function ajaxTooltip_getTopPos(inputObj)
{		
  var returnValue = inputObj.offsetTop;
  while((inputObj = inputObj.offsetParent) != null){
  	if(inputObj.tagName!='HTML')returnValue += inputObj.offsetTop;
  }
  return returnValue;
}

function ajaxTooltip_getLeftPos(inputObj)
{
  var returnValue = inputObj.offsetLeft;
  while((inputObj = inputObj.offsetParent) != null){
  	if(inputObj.tagName!='HTML')returnValue += inputObj.offsetLeft;
  }
  return returnValue;
}

// creates an XMLHttpRequest instance

function createXmlHttpRequestObject2()
{
// will store the reference to the XMLHttpRequest object
var xmlHttp;
// this should work for all browsers except IE6 and older
try
{
// try to create XMLHttpRequest object
xmlHttp = new XMLHttpRequest();
}
catch(e)
{
// assume IE6 or older
var XmlHttpVersions = new Array("MSXML2.XMLHTTP.6.0",
"MSXML2.XMLHTTP.5.0",
"MSXML2.XMLHTTP.4.0",
"MSXML2.XMLHTTP.3.0",
"MSXML2.XMLHTTP",
"Microsoft.XMLHTTP");
// try every prog id until one works
for (var i=0; i<XmlHttpVersions.length && !xmlHttp; i++)
{
try
{
// try to create XMLHttpRequest object
xmlHttp = new ActiveXObject(XmlHttpVersions[i]);
}
catch (e) {}
}
}
// return the created object or display an error message
if (!xmlHttp)
alert("Error creating the XMLHttpRequest object.");
else
return xmlHttp;
}
/* function that initializes the page */
function init2()
{
// retrieve the input control for the keyword
//alert("1");

var oKeyword = document.getElementById(columna);
//alert("2");
// prevent browser from starting the autofill function
oKeyword.setAttribute("autocomplete", "off");
//alert("3");
// reset the content of the keyword and set the focus on it
oKeyword.value = "";
//alert("4");
oKeyword.focus();
//alert("5");
// set the timeout for checking updates in the keyword's value
setTimeout("checkForChanges()", 500);
}
/* function that adds to a keyword an array of values */
function addToCache(keyword, values)
{
// create a new array entry in the cache
oCache[keyword] = new Array();
// add all the values to the keyword's entry in the cache
for(i=0; i<values.length; i++)
oCache[keyword][i] = values[i];
}
/*
function that checks to see if the keyword specified as parameter is in
the cache or tries to find the longest matching prefixes in the cache
and adds them in the cache for the current keyword parameter
*/
function checkCache(keyword)
{
// check to see if the keyword is already in the cache
if(oCache[keyword])
return true;
// try to find the biggest prefixes
for(i=keyword.length-2; i>=0; i--)
{
// compute the current prefix keyword
var currentKeyword = keyword.substring(0, i+1);
// check to see if we have the current prefix keyword in the cache
if(oCache[currentKeyword])
{
// the current keyword's results already in the cache
var cacheResults = oCache[currentKeyword];
// the results matching the keyword in the current cache results
var keywordResults = new Array();
var keywordResultsSize = 0;
// try to find all matching results starting with the current prefix
for(j=0;j<cacheResults.length;j++)
{
	if(cacheResults[j].indexOf(keyword) == 0)
keywordResults[keywordResultsSize++] = cacheResults[j];
}
// add all the keyword's prefix results to the cache
addToCache(keyword, keywordResults);
return true;
}
}
// no match found
return false;
}
/* initiate HTTP request to retrieve suggestions for the current keyword */
function getSuggestions(keyword)
{
/* continue if keyword isn't null and the last pressed key wasn't up or down */
if(keyword != "" && !isKeyUpDownPressed)
{
// check to see if the keyword is in the cache
//isInCache = checkCache(keyword);
isInCache = false;
// if keyword is in cache...
if(isInCache == true)
{
// retrieve the results from the cache
//alert("entro cache");

httpRequestKeyword=keyword;
userKeyword=keyword;
// display the results in the cache
displayResults(keyword, oCache[keyword]);
}
// if the keyword isn't in cache, make an HTTP request
else
{
//alert("entro no cache");

if(xmlHttpGetSuggestions)
{
try
{
/* if the XMLHttpRequest object isn't busy with a previous request... */
if (xmlHttpGetSuggestions.readyState == 4 ||
xmlHttpGetSuggestions.readyState == 0)
{
httpRequestKeyword = keyword;
userKeyword = keyword;
if(buscaParametro==true)
xmlHttpGetSuggestions.open("GET",getFunctionsUrl + encode(keyword) + '&columna='+ (selectColumna-1) + "&action=SUGGEST"+"&tabla="+selectTabla, true);
else
xmlHttpGetSuggestions.open("GET",getFunctionsUrl + encode(keyword) + '&columna='+ (columna-1) + "&action=SUGGEST"+"&tabla="+selectTabla, true);


//alert(getFunctionsUrl + encode(keyword) + '&columna='+ (columna-1) + "&action=SUGGEST")
xmlHttpGetSuggestions.onreadystatechange = handleGettingSuggestions;
xmlHttpGetSuggestions.send(null);
}
// if the XMLHttpRequest object is busy...
else
{
// retain the keyword the user wanted
userKeyword = keyword;
// clear any previous timeouts already set
if(timeoutId != -1)
clearTimeout(timeoutId);
// try again in 0.5 seconds
timeoutId = setTimeout("getSuggestions(userKeyword);", 500);
}
}
catch(e)
{
displayError("Can't connect to server:\n" + e.toString());
}
}
}
}
}
/* transforms all the children of an xml node into an array */
function xmlToArray(resultsXml)
{
// initiate the resultsArray
var resultsArray= new Array();
// loop through all the xml nodes retrieving the content
for(i=0;i<resultsXml.length;i++){
resultsArray[i]=resultsXml.item(i).firstChild.data;
//alert(resultsArray[i]);
}
// return the node's content as an array
return resultsArray;
}
/* handles the server's response containing the suggestions
for the requested keyword */
function handleGettingSuggestions()
{
//if the process is completed, decide what to do with the returned data
if (xmlHttpGetSuggestions.readyState == 4)
{
// only if HTTP status is "OK"
if (xmlHttpGetSuggestions.status == 200)
{
try
{
// process the server's response
//alert(xmlHttpGetSuggestions.responseText);
updateSuggestions();
}
catch(e)
{
// display the error message
displayError(e.toString());
alert(xmlHttpGetSuggestions.responseText);

}
}
else
{
displayError("There was a problem retrieving the data:\n" +
xmlHttpGetSuggestions.statusText);
}
}
}
/* function that processes the server's response */
function updateSuggestions()
{
// retrieve the server's response
var response = xmlHttpGetSuggestions.responseText;
// server error?
if (response.indexOf("ERRNO") >= 0
|| response.indexOf("error:") >= 0
|| response.length == 0)
throw(response.length == 0 ? "Void server response." : response);
// retrieve the document element
response = xmlHttpGetSuggestions.responseXML.documentElement;
// initialize the new array of functions' names
nameArray = new Array();
// check to see if we have any results for the searched keyword
if(response.childNodes.length)
{
/* we retrieve the new functions' names from the document element as an array */
nameArray= xmlToArray(response.getElementsByTagName("name"));
}

// check to see if other keywords are already being searched for
if(httpRequestKeyword == userKeyword)
{
// display the results array
//alert("entro resultados="+httpRequestKeyword);
displayResults(httpRequestKeyword, nameArray);
}
else
{
// add the results to the cache
// we don't need to display the results since they are no longer useful
addToCache(httpRequestKeyword, nameArray);
}


}
/* populates the list with the current suggestions */
function displayResults(keyword, results_array)
{
// start building the HTML table containing the results
var div = "<table with='250px'>";
// if the searched for keyword is not in the cache then add it to the cache
//if(!oCache[keyword] && keyword){
if(keyword){
//alert("actualiza cache");
addToCache(keyword, results_array);
}
// if the array of results is empty display a message

if(results_array.length == 0)
{
div += "<tr><td>No results found for <strong>" + keyword + "</strong></td></tr>";
// set the flag indicating that no results have been found
// and reset the counter for results
hasResults = false;
suggestions = 0;
}
// display the results
else
{
// resets the index of the currently selected suggestion
position = -1;
// resets the flag indicating whether the up or down key has been pressed
isKeyUpDownPressed = false;
/* sets the flag indicating that there are results for the searched for keyword */
hasResults = true;
// get the number of results from the cache
suggestions = oCache[keyword].length;
// loop through all the results and generate the HTML list of results
for (var i=0; i<oCache[keyword].length; i++)
{
// retrieve the current function
crtFunction = oCache[keyword][i];
// set the string link for the for the current function
// to the name of the function
crtFunctionLink = crtFunction;
// replace the _ with - in the string link
while(crtFunctionLink.indexOf("_") !=-1)
crtFunctionLink = crtFunctionLink.replace("_","-");
// start building the HTML row that contains the link to the
seleccionado=crtFunctionLink;
// PHP help page of the current function
//tmpObjKeyword=document.getElementById(columna);
//tmpObjKeyword.focus();
//alert("c"+selectColumna);
if(buscaParametro==true)
xcolumna=document.getElementById("c"+selectColumna);
else
xcolumna=document.getElementById("c"+columna);

xparametros=""+xcolumna.title+" like "+crtFunctionLink;
//alert(xcolumna.title);
//alert("Entro 5  ="+"c"+columna+"  "+crtFunctionLink);

div += "<tr id='tr" + i + "' onclick=\"return makeSearching('" + xparametros +
"')\" href='' onmouseover='handleOnMouseOver(this);' " +
"onmouseout='handleOnMouseOut(this);'>" +
"<td align='left'><a><input type='hidden' id='a" + i +
"' value='"+xparametros;
// check to see if the current function name length exceeds the maximum
// number of characters that can be displayed for a function name
if(crtFunction.length <= suggestionMaxLength)
{
// bold the matching prefix of the function name and of the keyword
div += "'><b>" +
crtFunction.substring(0, httpRequestKeyword.length) +
"</b>"
div += crtFunction.substring(httpRequestKeyword.length,
crtFunction.length) +
"</a></td></tr>";
}
else
{
// check to see if the length of the current keyword exceeds
// the maximum number of characters that can be displayed
if(httpRequestKeyword.length < suggestionMaxLength)
{
/* bold the matching prefix of the function name and that of the
keyword */
div += "'><b>" +
crtFunction.substring(0, httpRequestKeyword.length) +
"</b>"
div += crtFunction.substring(httpRequestKeyword.length,
suggestionMaxLength) +
"</a></td></tr>";
}
else
{
// bold the entire function name
div += "'><b>" +
crtFunction.substring(0,suggestionMaxLength) +
"</b></td></tr>"
}
}
}
}
// end building the HTML table
div += "</table>";
// retrieve the suggest and scroll object

var tmpObjKeyword = document.getElementById(columna);
topObjKeyword=ajaxTooltip_getTopPos(tmpObjKeyword)+20;
leftObjKeyword=ajaxTooltip_getLeftPos(tmpObjKeyword);

var oSuggest = document.getElementById("suggest");
oSuggest.style.visibility="visible";
oSuggest.style.top=topObjKeyword+"px";
oSuggest.style.left=leftObjKeyword+"px";
//oSuggest.style.zindex=1;
var oScroll = document.getElementById("scroll");
oScroll.style.top=topObjKeyword+"px";
oScroll.style.left=leftObjKeyword+"px";
// scroll to the top of the list
oScroll.scrollTop = 0;
// update the suggestions list and make it visible
oSuggest.innerHTML = div;
oScroll.style.visibility = "visible";
// if we had results we apply the type ahead for the current keyword
if(results_array.length > 0)
autocompleteKeyword();
}
/*Searching */
function makeSearching(parametro){
	document.getElementById("parametros").value=parametro;
	findParameter();
	yaentro=false;
	delayCambiosFormulario();
	return false;
 	//loadSelectPage(obj);
}
/* function that periodically checks to see if the typed keyword has changed */
function checkForChanges()
{
// retrieve the keyword object
if(columna!=""&&columna!=null){
		if(document.getElementById(columna)!=null){
			var keyword = document.getElementById(columna).value;
			// check to see if the keyword is empty
			if(keyword == "")
			{
			// hide the suggestions
			hideSuggestions();
			// reset the keywords
			userKeyword="";
			httpRequestKeyword="";
			}
			// set the timer for a new check
			setTimeout("checkForChanges()", 500);
			// check to see if there are any changes
			if((userKeyword != keyword) &&
			(autocompletedKeyword != keyword) &&
			(!isKeyUpDownPressed))
			// update the suggestions
			//alert(keyword);
			getSuggestions(keyword);
		}
		else
			setTimeout("checkForChanges()", 500);

	}
}
function cambiecolumna(obj){
selectColumna=obj.options[obj.selectedIndex].value;
}
/* function that handles the keys that are pressed */

function handleKeyUp(e,obj)
{
//get columna selected
if(conini<1){
init2();
conini++;
}

if(obj.id=="parametros"){
//columna=selectColumna;
columna="parametros";
buscaParametro=true;
}
else{
columna=obj.id;
buscaParametro=false;
}
// get the event
e = (!e) ? window.event : e;
// get the event's target
target = (!e.target) ? e.srcElement : e.target;
if (target.nodeType == 3)
target = target.parentNode;
// get the character code of the pressed button
code = (e.charCode) ? e.charCode :
((e.keyCode) ? e.keyCode :
((e.which) ? e.which : 0));
// check to see if the event was keyup
if (e.type == "keyup")
{
isKeyUpDownPressed =false;
// check to see we if are interested in the current character
//escape borra todito
	if(code==27){
		hideSuggestions();
	}

if ((code < 13 && code != 8) ||
(code >=14 && code < 32) ||
(code >= 33 && code <= 46 && code != 38 && code != 40) ||
(code >= 112 && code <= 123))
{
// simply ignore non-interesting characters
}
else
/* if Enter is pressed we jump to the PHP help page of the current function */
if(code == 13)
{
// check to see if any function is currently selected
if(position>=0)
{
//	location.href = 
makeSearching(document.getElementById("a" + position).value);
}
}
else
// if the down arrow is pressed we go to the next suggestion
if(code == 40)
{
	newTR=document.getElementById("tr"+(++position));
	oldTR=document.getElementById("tr"+(--position));
	// deselect the old selected suggestion
	if(position>=0 && position<suggestions-1)
	oldTR.className = "";
	// select the new suggestion and update the keyword
	if(position < suggestions - 1)
	{
		newTR.className = "highlightrow";
		updateKeywordValue(newTR);
		position++;
	}
	e.cancelBubble = true;
	e.returnValue = false;
	isKeyUpDownPressed = true;
	// scroll down if the current window is no longer valid
	if(position > maxVisiblePosition)
	{
		oScroll = document.getElementById("scroll");
		//oScroll.style.width="250px"; 
		oScroll.scrollTop += 18;
		maxVisiblePosition += 1;
		minVisiblePosition += 1;
	}
}
else
// if the up arrow is pressed we go to the previous suggestion
if(code == 38)
{
	newTR=document.getElementById("tr"+(--position));
	oldTR=document.getElementById("tr"+(++position));
	// deselect the old selected position
	if(position>=0 && position <= suggestions - 1)
	{
		oldTR.className = "";
	}
	// select the new suggestion and update the keyword
	if(position > 0)
	{
		newTR.className = "highlightrow";
		updateKeywordValue(newTR);
		position--;
		// scroll up if the current window is no longer valid
		if(position<minVisiblePosition)
		{
			oScroll = document.getElementById("scroll");
			oScroll.style.width="250px"; 
			oScroll.scrollTop -= 18;
			maxVisiblePosition -= 1;
			minVisiblePosition -= 1;
		}
	}
	else
		if(position == 0)
			position--;
	e.cancelBubble = true;
	e.returnValue = false;
	isKeyUpDownPressed = true;
}


}
}
/* function that updates the keyword value with the value
of the currently selected suggestion */
function updateKeywordValue(oTr)
{
// retrieve the keyword object
//alert(columna);
var oKeyword = document.getElementById(columna);

//var oKeyword = document.getElementById(columna);

// retrieve the link for the current function
var crtLink = document.getElementById("a" + oTr.id.substring(2,oTr.id.length)).toString();
// replace - with _ and leave out the .php extension
crtLink = crtLink.replace("-", "_");
crtLink = crtLink.substring(0, crtLink.length - 4);
// update the keyword's value

oKeyword.value = seleccionado;
//oKeyword.value=unescape(crtLink.substring(phpHelpUrl.length, crtLink.length));
//alert("KEYWORD="+oKeyword.value);

}
/* function that removes the style from all suggestions*/
function deselectAll()
{
	for(i=0; i<suggestions; i++)
	{
		var oCrtTr = document.getElementById("tr" + i);
		oCrtTr.className = "";
	}
}
/* function that handles the mouse entering over a suggestion's area event */
function handleOnMouseOver(oTr)
{
deselectAll();
oTr.className = "highlightrow";
position = oTr.id.substring(2, oTr.id.length);
}
/* function that handles the mouse exiting a suggestion's area event */
function handleOnMouseOut(oTr)
{
oTr.className = "";
position = -1;
}
/* function that escapes a string */
function encode(uri)
{
if (encodeURIComponent)
{
return encodeURIComponent(uri);
}
if (escape)
{
return escape(uri);
}
}
/* function that hides the layer containing the suggestions */
function hideSuggestions()
{
var oScroll = document.getElementById("scroll");
//oScroll.style.width="250px"; 
oScroll.style.visibility = "hidden";
//oScroll.innerHTML="";
var oSuggest = document.getElementById("suggest");
//oSuggest.style.width="250px"; 
oSuggest.style.visibility = "hidden";
var objKeyWord=document.getElementById(columna);
objKeyWord.value="";
//oSuggest.innerHTML="";
}
/* function that selects a range in the text object passed as parameter */
function selectRange(oText, start, length)
{
// check to see if in IE or FF
if (oText.createTextRange)
{
//IE
var oRange = oText.createTextRange();
oRange.moveStart("character", start);
oRange.moveEnd("character", length - oText.value.length);
oRange.select();
}
else
// FF
if (oText.setSelectionRange)
{
oText.setSelectionRange(start, length);
}
oText.focus();
}
/* function that autocompletes the typed keyword*/
function autocompleteKeyword()
{
//retrieve the keyword object
var oKeyword = document.getElementById(columna);
// reset the position of the selected suggestion
position=0;
// deselect all suggestions
deselectAll();
// highlight the selected suggestion
document.getElementById("tr0").className="highlightrow";
// update the keyword's value with the suggestion
updateKeywordValue(document.getElementById("tr0"));
// apply the type-ahead style
selectRange(oKeyword,httpRequestKeyword.length,oKeyword.value.length);
// set the autocompleted word to the keyword's value
autocompletedKeyword=oKeyword.value;
}
/* function that displays an error message */
function displayError(message)
{
// display error message, with more technical details if debugMode is true
alert("Error accessing the server! "+
(debugMode ? "\n" + message : ""));
}