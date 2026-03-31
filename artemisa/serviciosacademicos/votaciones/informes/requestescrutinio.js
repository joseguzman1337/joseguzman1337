// holds an instance of XMLHttpRequest
var xmlHttpEscrutinio = createXmlHttpRequestObject();
var xmlRoot;
// creates an XMLHttpRequest instance
function createXmlHttpRequestObject()
{
	// will store the reference to the XMLHttpRequest object
	var xmlHttpEscrutinio;
	// this should work for all browsers except IE6 and older
	try
	{
		// try to create XMLHttpRequest object
		xmlHttpEscrutinio = new XMLHttpRequest();
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
		for (var i=0; i<XmlHttpVersions.length && !xmlHttpEscrutinio; i++)
		{
			try
			{
				// try to create XMLHttpRequest object
				xmlHttpEscrutinio = new ActiveXObject(XmlHttpVersions[i]);
			}
				catch (e) {}
		}
	}
	// return the created object or display an error message
	if (!xmlHttpEscrutinio)
	alert("Error creating the XMLHttpRequest object.");
	else
	return xmlHttpEscrutinio;
}
// read a file from the server
function process(file,params)
{
	// only continue if xmlHttpEscrutinio isn't void
	if (xmlHttpEscrutinio)
	{
		// try to connect to the server
		try
		{
			// get the two values entered by the user
			//var firstNumber = document.getElementById("firstNumber").value;
			//var secondNumber = document.getElementById("secondNumber").value;
			// create the params string
			//var params = "firstNumber=" + firstNumber +
			//"&secondNumber=" + secondNumber;
			// initiate the asynchronous HTTP request
			
			xmlHttpEscrutinio.open("GET",file +'?'+ params,true);
			xmlHttpEscrutinio.onreadystatechange = handleRequestStateChange2;
			//xmlHttpEscrutinio.send("param1=x&param2=y");
			xmlHttpEscrutinio.send(null);
			//alert('otra vez'+file +'?'+ params);

}
		// display the error in case of failure
		catch (e)
		{
			alert("Can't connect to server:\n" + e.toString());
		}
	}
}
//
function requestEscrutinioTXT(file,params)
{
	// only continue if xmlHttpEscrutinio isn't void
	if (xmlHttpEscrutinio)
	{
		// try to connect to the server
		try
		{
			// get the two values entered by the user
			//var firstNumber = document.getElementById("firstNumber").value;
			//var secondNumber = document.getElementById("secondNumber").value;
			// create the params string
			//var params = "firstNumber=" + firstNumber +
			//"&secondNumber=" + secondNumber;
			// initiate the asynchronous HTTP request
			
			xmlHttpEscrutinio.open("GET",file +'?'+ params,true);
			xmlHttpEscrutinio.onreadystatechange = handleRequestStateChangeEscrutinioTXT;
			//xmlHttpEscrutinio.send("param1=x&param2=y");
			xmlHttpEscrutinio.send(null);
			//alert('otra vez'+file +'?'+ params);

}
		// display the error in case of failure
		catch (e)
		{
			alert("Can't connect to server:\n" + e.toString());
		}
	}
}
// function called when the state of the HTTP request changes
function handleRequestStateChangeEscrutinioTXT()
{
// when readyState is 4, we are ready to read the server response
	if (xmlHttpEscrutinio.readyState == 4)
	{
		// continue only if HTTP status is "OK"
		if (xmlHttpEscrutinio.status == 200)
		{
			try
			{
			// do something with the response from the server
			handleServerResponseEscrutinioTXT();
			}
			catch(e)
			{
			// display error message
			//alert("Error reading the response: " + e.toString());
			alert("Error reading the response: " + e.toString());
			}
		}
		else
		{
			// display status message
			alert("There was a problem retrieving the data:\n" + xmlHttpEscrutinio.statusText);
		}
	}
}
// handles the response received from the server
function handleServerResponseEscrutinioTXT()
{
	// retrieve the server's response packaged as an XML DOM object
	//var xmlResponse = xmlHttpEscrutinio.responseXML;
	
	// catching potential errors with IE and Opera
	//if (!xmlResponse || !xmlResponse.documentElement)
	//throw("Invalid XML structure:\n" + xmlHttpEscrutinio.responseText);
	//alert("Entro 1");
	// catching potential errors with Firefox
	//var rootNodeName = xmlResponse.documentElement.nodeName;
	//if (rootNodeName == "parsererror")
	//throw("Invalid XML structure:\n" + xmlHttpEscrutinio.responseText);
		//alert("Entro 2");
	// getting the root element (the document element)
	//xmlRoot = xmlResponse.documentElement;
	// testing that we received the XML document we expect
	//if (rootNodeName != "response" || !xmlRoot.firstChild)
	//throw("Invalid XML structure:\n" + xmlHttpEscrutinio.responseText);
		//alert("Entro 3");
	// the value we need to display is the child of the root <response> element
	//responseText = xmlRoot.firstChild.data;
	// display the user message
	//myDiv = document.getElementById("myDivElement");
	//myDiv.innerHTML = "Server says the answer is: " + responseText;
}
// function called when the state of the HTTP request changes
function handleRequestStateChange2()
{
// when readyState is 4, we are ready to read the server response
	if (xmlHttpEscrutinio.readyState == 4)
	{
		// continue only if HTTP status is "OK"
		if (xmlHttpEscrutinio.status == 200)
		{
			try
			{
			// do something with the response from the server
			handleServerResponse2();
			}
			catch(e)
			{
			// display error message
			//alert("Error reading the response: " + e.toString());
			alert("Error reading the response: " + e.toString());
			}
		}
		else
		{
			// display status message
			alert("There was a problem retrieving the data:\n" + xmlHttpEscrutinio.statusText);
		}
	}
}
// handles the response received from the server
function handleServerResponse2()
{
	// retrieve the server's response packaged as an XML DOM object
	var xmlResponse = xmlHttpEscrutinio.responseXML;
	
	// catching potential errors with IE and Opera
	if (!xmlResponse || !xmlResponse.documentElement)
	throw("Invalid XML structure:\n" + xmlHttpEscrutinio.responseText);
	//alert("Entro 1");
	// catching potential errors with Firefox
	var rootNodeName = xmlResponse.documentElement.nodeName;
	if (rootNodeName == "parsererror")
	throw("Invalid XML structure:\n" + xmlHttpEscrutinio.responseText);
		//alert("Entro 2");
	// getting the root element (the document element)
	xmlRoot = xmlResponse.documentElement;
	// testing that we received the XML document we expect
	//if (rootNodeName != "response" || !xmlRoot.firstChild)
	//throw("Invalid XML structure:\n" + xmlHttpEscrutinio.responseText);
		//alert("Entro 3");
	// the value we need to display is the child of the root <response> element
	//responseText = xmlRoot.firstChild.data;
	// display the user message
	//myDiv = document.getElementById("myDivElement");
	//myDiv.innerHTML = "Server says the answer is: " + responseText;
}
function botecheckbox(nombre,valorsi,valorno,archivo,obj,msjconfirmar){
var confirma=true;
if(msjconfirmar!='')
confirma=confirm(msjconfirmar);

	if(confirma){
		if(obj.checked){
		 params=nombre+"="+valorsi;
		 process(archivo,params);
		}
		else{
		 params=nombre+"="+valorno;
		 process(archivo,params);
		}
   }
   return confirma;
}
function ArregloXMLObj(campoXml){
response = xmlHttpEscrutinio.responseXML.documentElement;
resultsXml=response.getElementsByTagName(campoXml);

var resultsArray= new Array();
// loop through all the xml nodes retrieving the content
for(i=0;i<resultsXml.length;i++){
if(resultsXml.item(i).firstChild == null)
resultsArray[i]="";
else
resultsArray[i]=resultsXml.item(i).firstChild.data;
//alert(resultsArray[i]);
}
// return the node's content as an array
return resultsArray;
}