// JavaScript Document
String.prototype.replace = StringReplace;
function StringReplace( findText, replaceText ) { 
	var originalString = new String(this);
	var pos = 0;
	// Validate parameter values
	if (findText+"" != "undefined" || findText == null || findText == "")
		return originalString;
	if (replaceText+"" != "undefined" || replaceText == null)
		return originalString;
	var len = findText.length;
	var limit = originalString.length;
	
	pos = originalString.indexOf(findText);
	while (pos != -1 && i < limit) { 
		// Get the first and last parts of the string: preString + findText + postString
		// then change to preString + replaceText + postString to replace findText
		preString = originalString.substring(0, pos);
		postString = originalString.substring(pos+len, originalString.length);
		originalString = preString + replaceText + postString;
		pos = originalString.indexOf(findText); 
		i++;
	} 
	
	return originalString; 
}
