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
function validateForm() { //v4.0
  var campo,i,p,q,nm,test,num,min,max,errors='',args=validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=args[i];
    if (val) { nm=val; if ((val)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) {errors+='-El campo debe ser numerico.\n'; campo=nm;}
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') {errors += '- El campo no puede quedar vacio.\n'; campo=nm;} }
  } if (errors) {alert('El siguiente error ha ocurrido:\n'+errors); eval(" document.form1."+campo+".focus()"); }
  document.returnValue = (errors == '');
}
function findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function char_vacio(s)
{
		var i;
		var con=0;
		for (i = 0 ; i<s.length; i++)
		{
			var c = s.charAt(i);
			if (c==' ')
			con++;
		}
		  //todos los caracteres son espacios en blanco
	 	if((con==s.length)&&(s.length>0))
			return true; 
		else
			return false; 
	
}
function char_inval(s)
{
	 	var i;
	 	//buscar la cadena a ver si tiene caracteres que no sean espacios en 
	 	//blanco
	 	for (i = 0 ; i<s.length; i++)
	    {
			var c = s.charAt(i);
			if ((c == "\'")||(c == "\\")||(c == "\"")||(c == "?"))
			return true;
		}
		//todos los caracteres son espacios en blanco
		return false; 
}


//Ej = validateForm('apellidos','','R','nombre','','R','dcident','','','telefono','','NisNum','ccpadre','','NisNum','telpadre','','NisNum','ccmadre','','NisNum','telmadre','','NisNum','nomacud','','R','apellacud','','R','ccacud','','RisNum','telacud','','NisNum');
