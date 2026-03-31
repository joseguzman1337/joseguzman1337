// stores the reference to the XMLHttpRequest object
var xmlHttp = createXmlHttpRequestObject();
// the name of the XSLT file
var xsltFileUrl = "grid.xsl";
// the file that returns the requested data in XML format
var feedGridUrl = "grid.php";
// the id of the grid div
var gridDivId = "gridDiv";
// the grid of the status div
var statusDivId = "statusDiv";
// stores temporary row data
var tempRow;
// the ID of the product being edited
var editableId = null;
// the XSLT document
var stylesheetDoc;
// eveything starts here
var selectTabla="Interesados";
// columnas
var columnas=new Array();
var rows_x_page=new Array();
var filasxpagina=10 ;

function init()
{
	// test if user has browser that supports native XSLT functionality
	if(window.XMLHttpRequest && window.XSLTProcessor && window.DOMParser)
	{
		// load the grid
		loadStylesheet();
		loadGridPage(1);

		return;
	}
	// test if user has Internet Explorer with proper XSLT support
	if (window.ActiveXObject && createMsxml2DOMDocumentObject())
	{
		// load the grid
		loadStylesheet();
		loadGridPage(1);
		// exit the function
		return;
	}
	// if browser functionality testing failed, alert the user
	alert("Your browser doesn't support the necessary functionality.");
}
function createMsxml2DOMDocumentObject()
{
	// will store the reference to the MSXML object
	var msxml2DOM;
	// MSXML versions that can be used for our grid
	var msxml2DOMDocumentVersions = new Array("Msxml2.DOMDocument.6.0",
	"Msxml2.DOMDocument.5.0",
	"Msxml2.DOMDocument.4.0");
	// try to find a good MSXML object
	for (var i=0; i<msxml2DOMDocumentVersions.length && !msxml2DOM; i++)
	{
		try
		{
			// try to create an object
			msxml2DOM = new ActiveXObject(msxml2DOMDocumentVersions[i]);
		}
		catch (e) {}
	}
	// return the created object or display an error message
	if (!msxml2DOM)
		alert("Please upgrade your MSXML version from \n" +
		"http://msdn.microsoft.com/XML/XMLDownloads/default.aspx");
	else
		return msxml2DOM;
}
// creates an XMLHttpRequest instance
function createXmlHttpRequestObject()
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
// loads the stylesheet from the server using a synchronous request
function loadStylesheet()
{
	// load the file from the server
	xmlHttp.open("GET", xsltFileUrl, false);
	xmlHttp.send(null);
	//
	// try to load the XSLT document
	if (this.DOMParser) // browsers with native functionality
	{
		var dp = new DOMParser();
		stylesheetDoc = dp.parseFromString(xmlHttp.responseText, "text/xml");
	}
	else if (window.ActiveXObject) // Internet Explorer?
	{
		//alert("Entro esta guachafa");
		stylesheetDoc = createMsxml2DOMDocumentObject();
		stylesheetDoc.async = false;
		stylesheetDoc.load(xmlHttp.responseXML);

	}
	//alert(xmlHttp.responseText);
	//document.write(xmlHttp.responseText);
}

function enviaOrdenColumna(order){
		// disable edit mode when loading new page
	editableId = false;
	// continue only if the XMLHttpRequest object isn't busy
	if (xmlHttp && (xmlHttp.readyState == 4 || xmlHttp.readyState == 0))
	{
		var query = feedGridUrl + "?action=ORDER&order=" +order+"&tabla="+selectTabla+"&filasporpagina="+filasxpagina;
		xmlHttp.open("GET", query, true);
		xmlHttp.onreadystatechange = handleGridPageLoad;
		xmlHttp.send(null);
	}
	
	delayCambiosFormulario();
	return false;

}
// makes asynchronous request to load a new page of the grid
function loadGridPage(pageNo)
{
	// disable edit mode when loading new page
	editableId = false;
	// continue only if the XMLHttpRequest object isn't busy
	if (xmlHttp && (xmlHttp.readyState == 4 || xmlHttp.readyState == 0))
	{
		var query = feedGridUrl + "?action=FEED_GRID_PAGE&page=" + pageNo+"&tabla="+selectTabla+"&filasporpagina="+filasxpagina;
		xmlHttp.open("GET", query, true);
		xmlHttp.onreadystatechange = handleGridPageLoad;
		xmlHttp.send(null);
	}
	var yaentro=false;
	delayCambiosFormulario();
}
//make load the page in the select menu
function loadSelectPage(obj){
	page=obj.options[obj.selectedIndex].value;
	loadGridPage(page);
}
//Load parameters to find result
function findParameter(){
	// disable edit mode when loading new page
	editableId = false;
	//alert("entro a find");
	// continue only if the XMLHttpRequest object isn't busy
	if (xmlHttp && (xmlHttp.readyState == 4 || xmlHttp.readyState == 0))
	{

		var parametros = document.getElementById("parametros").value;
			var query = feedGridUrl + "?action=FILTER&parametros=" + parametros+"&tabla="+selectTabla+"&filasporpagina="+filasxpagina;
			//alert(query); 
		xmlHttp.open("GET", query, true);
		xmlHttp.onreadystatechange = handleGridPageLoad;
		xmlHttp.send(null);
	}

}
function cambietabla(obj){
selectTabla=obj.options[obj.selectedIndex].value;
resetParameter();
/*if(selectTabla!="Interesados")
	document.getElementById("framecorreomasivo").innerHTML="";
else
	document.getElementById("framecorreomasivo").innerHTML="<iframe src='correomasivo.php' height='200' width='600'></iframe>";*/
//alert(selectTabla+" "+document.getElementById("framecorreomasivo").innerHTML);

}
function manejaKeyPress(e,obj){
	if(obj.value<100){
		e = (!e) ? window.event : e;
		// get the event's target
		code = (e.charCode) ? e.charCode :
		((e.keyCode) ? e.keyCode :
		((e.which) ? e.which : 0));
		if(code==13){
			filasxpagina = obj.value;
			resetParameter();
		}
	}
	else{
		alert("Los registros por pagina no pueden ser mas de 100");
	}
	
}
function resetParameter(){
	//alert("entro a reset");
	editableId = false;
	// continue only if the XMLHttpRequest object isn't busy
		if (xmlHttp && (xmlHttp.readyState == 4 || xmlHttp.readyState == 0))
		{
	
			var parametros = document.getElementById("parametros").value;
			//alert(filasxpagina);
			var query = feedGridUrl + "?action=RESET&parametros=" + parametros+"&tabla="+selectTabla+"&filasporpagina="+filasxpagina;
				//alert(query); 
			xmlHttp.open("GET", query, true);
			xmlHttp.onreadystatechange = handleGridPageLoad;
			xmlHttp.send(null);
		}
yaentro=false;
delayCambiosFormulario();
}

// handle receiving the server response with a new page of products
function handleGridPageLoad()
{
	// when readyState is 4, we read the server response
	if (xmlHttp.readyState == 4)
	{
		// continue only if HTTP status is "OK"
		if (xmlHttp.status == 200)
		{
			// read the response
			response = xmlHttp.responseText;
			//alert(xmlHttp.responseText);
			//document.write(xmlHttp.responseText);

			// server error?
			if (response.indexOf("ERRNO") >= 0
			|| response.indexOf("error") >= 0
			|| response.length == 0)
			{
				// display error message
				alert(response.length == 0 ? "Server serror." : response);
				// exit function
				return;
			}
			// the server response in XML format
			try {
				xmlResponse = xmlHttp.responseXML;			
				if(xmlResponse.documentElement!=null){
					columnas=xmlToArray(xmlResponse.documentElement.getElementsByTagName("col"));
					rows_x_page=xmlToArray(xmlResponse.documentElement.getElementsByTagName("rows_x_page"));
				}
				else{
					alert("ERROR: XML mal formado=\n"+response);
				}
			}
			catch(e){
			}
			/*for(i=0;i<columnas.length;i++){
			alert(columnas[i]);
			}*/
			//alert(columnas);
			// browser with native functionality?
			if (window.XMLHttpRequest && window.XSLTProcessor && window.DOMParser)
			{
				// load the XSLT document
				var xsltProcessor = new XSLTProcessor();
				xsltProcessor.importStylesheet(stylesheetDoc);
				// generate the HTML code for the new page of products
				page = xsltProcessor.transformToFragment(xmlResponse, document);
				// display the page of products
				var gridDiv = document.getElementById(gridDivId);
				gridDiv.innerHTML = "";
				gridDiv.appendChild(page);
			}
			// Internet Explorer code
			else if (window.ActiveXObject)
			{
				// load the XSLT document
				var theDocument = createMsxml2DOMDocumentObject();
				theDocument.async = false;
				theDocument.load(xmlResponse);
				//display the page of products
				//alert(response);
				var gridDiv = document.getElementById(gridDivId);
				gridDiv.innerHTML = theDocument.transformNode(stylesheetDoc);
				//document.write(stylesheetDoc);
			}
		}
		else
		{
			alert("Error reading server response.")
		}
	}
}
// enters the product specified by id into edit mode if editMode is true,
// and cancels edit mode if editMode is false
function editId(id, editMode)
{
	// gets the <tr> element of the table that contains the table
	alert("id="+id);
	var productRow = document.getElementById(id).cells;
	// are we enabling edit mode?
	if(editMode)
	{
		// we can have only one row in edit mode at one time
		if(editableId) editId(editableId, false);
		// store current data, in case the user decides to cancel the changes
		save(id);
		// create editable text boxes
		productRow[1].innerHTML =
		'<input class="editName" type="text" name="name" ' +
		'value="' + productRow[1].innerHTML+'">';
		productRow[2].innerHTML =
		'<input class="editPrice" type="text" name="price" ' +
		'value="' + productRow[2].innerHTML+'">';
		productRow[3].getElementsByTagName("input")[0].disabled = false;
		productRow[4].innerHTML = '<a href="#" ' +
		'onclick="updateRow(document.forms.grid_form_id,' + id +
		')">Update</a><br/><a href="#" onclick="editId(' + id +
		',false)">Cancel</a>';
		// save the id of the product being edited
		editableId = id;
	}
	// if disabling edit mode...
	else
	{
		productRow[1].innerHTML = document.forms.grid_form_id.name.value;
		productRow[2].innerHTML = document.forms.grid_form_id.price.value;
		productRow[3].getElementsByTagName("input")[0].disabled = true;
		productRow[4].innerHTML = '<a href="#" onclick="editId(' + id +
		',true)">Edit</a>';
		// no product is being edited
		editableId = null;
	}
}
// saves the original product data before editing row
function save(id)
{
	// retrieve the product row
	var tr = document.getElementById(id).cells;
	// save the data
	tempRow = new Array(tr.length);
	for(var i=0; i<tr.length; i++)
	tempRow[i] = tr[i].innerHTML;
}
// cancels editing a row, restoring original values
function undo(id)
{
	// retrieve the product row
	var tr = document.getElementById(id).cells;
	// copy old values
	for(var i=0; i<tempRow.length; i++)
	tr[i].innerHTML = tempRow[i];
	// no editable row
	editableId = null;
}
// update one row in the grid if the connection is clear
function updateRow(grid, productId)
{
	// continue only if the XMLHttpRequest object isn't busy
	if (xmlHttp && (xmlHttp.readyState == 4 || xmlHttp.readyState == 0))
	{
		var query = feedGridUrl + "?action=UPDATE_ROW&tabla="+selectTabla+"&id=" + productId +
		"&" + createUpdateUrl(grid);
		xmlHttp.open("GET", query, true);
		xmlHttp.onreadystatechange = handleUpdatingRow;
		xmlHttp.send(null);
	}
}// handle receiving a response from the server when updating a product
function handleUpdatingRow()
{
	// when readyState is 4, we read the server response
	if(xmlHttp.readyState == 4)
	{
		// continue only if HTTP status is "OK"
		if(xmlHttp.status == 200)
		{
			// read the response
			response = xmlHttp.responseText;
			// server error?
			if (response.indexOf("ERRNO") >= 0
			|| response.indexOf("error") >= 0
			|| response.length == 0)
				alert(response.length == 0 ? "Server serror." : response);
				// if everything went well, cancel edit mode
			else
				editId(editableId, false);
		}
		else
		{
			// undo any changes in case of error
			undo(editableId);
			alert("Error on server side.");
		}
	}
}
// creates query string parameters for updating a row
function createUpdateUrl(grid)
{
	// initialize query string
	var str = "";
	// build a query string with the values of the editable grid elements
	for(var i=0; i<grid.elements.length; i++)
	switch(grid.elements[i].type)
	{
		case "text":
		case "textarea":
		str += grid.elements[i].name + "=" +
		escape(grid.elements[i].value) + "&";
		break;
		case "checkbox":
		if (!grid.elements[i].disabled)
		str += grid.elements[i].name + "=" +
		(grid.elements[i].checked ? 1 : 0) + "&";
		break;
	}
	// return the query string
	return str;
}
