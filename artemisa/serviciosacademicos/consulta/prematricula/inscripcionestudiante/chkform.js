/* This script and many more are available free online at
The JavaScript Source :: http://javascript.internet.com
Created by: Viala :: http://www.viala.hu
Based on: Travis Beckham :: http://www.squidfingers.com | http://www.podlob.com
Based on: Manzi Olivier :: http://www.imanzi.com/ 
Based on: jgw (jgwang@csua.berkeley.edu )/ */

// |||||||||||||||||||||||||||||||||||||||||||||||||||||
//
// Coded by Viala
// http://www.viala
// If want to use this code, feel free to do so, but
// please leave this message intact.
//
// |||||||||||||||||||||||||||||||||||||||||||||||||||||
// --- version date: 23/10/2006-------------------------


function checkCapsLock( e ) {
	var myKeyCode=0;
	var myShiftKey=false;

	// Internet Explorer 4+
	if ( document.all ) {
		myKeyCode=e.keyCode;
		myShiftKey=e.shiftKey;

	// Netscape 4
	} else if ( document.layers ) {
		myKeyCode=e.which;
		myShiftKey=( myKeyCode == 16 ) ? true : false;

	// Netscape 6
	} else if ( document.getElementById ) {
		myKeyCode=e.which;
		myShiftKey=( myKeyCode == 16 ) ? true : false;

	}

	// Upper case letters are seen without depressing the Shift key, therefore Caps Lock is on
	if ( ( myKeyCode >= 65 && myKeyCode <= 90 ) && !myShiftKey ) {
		alert( errormsg[100] );

	// Lower case letters are seen while depressing the Shift key, therefore Caps Lock is on
	} else if ( ( myKeyCode >= 97 && myKeyCode <= 122 ) && myShiftKey ) {
		alert( errormsg[100] );

	}
}

function CalcKeyCode(aChar) {
  var character = aChar.substring(0,1);
  var code = aChar.charCodeAt(0);
  return code;
}

function checkNumber(val) {
  var strPass = val.value;
  var strLength = strPass.length;
  var lchar = val.value.charAt((strLength) - 1);
  var cCode = CalcKeyCode(lchar);
 

  /* Check if the keyed in character is a number
     do you want alphabetic UPPERCASE only ?
     or lower case only just check their respective
     codes and replace the 48 and 57 */

  if (cCode < 48 || cCode > 57 ) {
    var myNumber = val.value.substring(0, (strLength) - 1);
    val.value = myNumber;
  }
  return false;
}
function isEmpty(str){
  return (str == null) || (str.length == 0);
}
// returns true if the string is a valid email
function isEmail(str){
  if(isEmpty(str)) return false;
  var re = /^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i
  return re.test(str);
}

// returns true if the string only contains characters 0-9
function isNumeric(str){
  var re = /[\D]/g
  if (re.test(str)) return false;
  return true;
}
// returns true if the string only contains characters A-Z, a-z or 0-9
function isAlphaNumeric(str){
  var re = /[^a-zA-Z0-9]/g
  if (re.test(str)) return false;
  return true;
}
// returns true if the string's length equals "len"
function isLength(str, len){
  return str.length == len;
}
// returns true if the string's length is between "min" and "max"
function isLengthBetween(str, min, max){
  return (str.length >= min)&&(str.length <= max);
}
// returns true if the string is a US phone number formatted as...
// (000)000-0000, (000) 000-0000, 000-000-0000, 000.000.0000, 000 000 0000, 0000000000
function isPhoneNumber(str){
  //var re = /^\(?[2-9]\d{2}[\)\.-]?\s?\d{3}[\s\.-]?\d{4}$/
  var re = /^\+\d{2,3}\ \(\d{2,3}\)\ \d{6,7}$/
  return re.test(str);
}
// returns true if the string is a valid date formatted as...
// mm dd yyyy, mm/dd/yyyy, mm.dd.yyyy, mm-dd-yyyy
function isDate(str){
  //var re = /^(\d{1,2})[\s\.\/-](\d{1,2})[\s\.\/-](\d{4})$/
  var re = /^(\d{4})[-\s\.\/](\d{1,2})[-\s\.\/](\d{1,2})$/
  if (!re.test(str)) return false;
  var result = str.match(re);
  var y = parseInt(result[1]);
  var m = parseInt(result[2]);
  var d = parseInt(result[3]);
  if(m < 1 || m > 12 || y < 1900 || y > 2100) return false;
  if(m == 2){
          var days = ((y % 4) == 0) ? 29 : 28;
  }else if(m == 4 || m == 6 || m == 9 || m == 11){
          var days = 30;
  }else{
          var days = 31;
  }
  return (d >= 1 && d <= days);
}
// returns true if "str1" is the same as the "str2"
function isMatch(str1, str2){
  return str1 == str2;
}
// returns true if the string contains only whitespace
// cannot check a password type input for whitespace
function isWhitespace(str){ // NOT USED IN FORM VALIDATION
  var re = /[\S]/g
  if (re.test(str)) return false;
  return true;
}
// removes any whitespace from the string and returns the result
// the value of "replacement" will be used to replace the whitespace (optional)
function stripWhitespace(str, replacement){// NOT USED IN FORM VALIDATION
  if (replacement == null) replacement = '';
  var result = str;
  var re = /\s/g
  if(str.search(re) != -1){
    result = str.replace(re, replacement);
  }
  return result;
}
// validate the form
function validateForm(f, preCheck, newClass, alerttype){
  var errors = '';
  var errorsa = '';
  var errordivs = '';
  if(preCheck != null) errors += preCheck;
  var i,e,t,n,v;
  for(i=0; i < f.elements.length; i++){
    e = f.elements[i];
    
    if(e.optional) continue;
    t = e.type;
    n = e.id;
    v = e.value;
    if(t == 'text' || t == 'password' || t == 'textarea'){
      
      if(isEmpty(v)){
        errors += n+errormsg[1]+ '<br>';
        errorsa += n+errormsg[1]+'\n';
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[1];
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
      if(v == e.defaultValue){
        errors += n+errormsg[2]+ '<br>';
        errorsa += n+errormsg[2]+'\n';
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[2];
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
      if(e.isAlpha){
        if(!isAlpha(v)){
        errors += n+errormsg[3]+ '<br>';
        errorsa += n+errormsg[3]+'\n';
        overlib('eaaaa');
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[3];
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
      }                              
      if(e.isNumeric){
        if(!isNumeric(v)){
        errors += n+errormsg[4]+ '<br>';
        errorsa += n+errormsg[4]+'\n';
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[4];
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
      }
      if(e.isAlphaNumeric){
        if(!isAlphaNumeric(v)){
        errors += n+errormsg[5]+ '<br>';
        errorsa += n+errormsg[5]+'\n';
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[5];
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
      }
      if(e.isEmail){
        if(!isEmail(v)){
        errors += v+errormsg[6]+ '<br>';
        errorsa += n+errormsg[6]+'\n';
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[6];
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
      }
      if(e.isLength != null){
        var len = e.isLength;
        if(!isLength(v,len)){
        errors += n+errormsg[7]+ len + '<br>'; 
        errorsa += n+errormsg[7]+'\n';
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[7]+ len;
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
      }
      if(e.isLengthBetween != null){
        var min = e.isLengthBetween[0];
        var max = e.isLengthBetween[1];
        if(!isLengthBetween(v,min,max)){
        errors += n+errormsg[8] + min + '-' + max + '<br>';
        errorsa += n+errormsg[8] + min + '-' + max + '\n';
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[8] + min + '-' + max;
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
      }
      if(e.isPhoneNumber){
        if(!isPhoneNumber(v)){
        errors += v+errormsg[9]+ '<br>';
        errorsa += n+errormsg[9]+'\n';
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[9];
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
      }
      if(e.isDate){
        if(!isDate(v)){
        errors += v+errormsg[10]+ '<br>'; 
        errorsa += n+errormsg[10]+'\n';
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[10];
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
      }
      if(e.isMatch != null){
        if(!isMatch(v, e.isMatch)){
        errors += n+errormsg[11]+ '<br>';
        errorsa += n+errormsg[11]+'\n';
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[11];
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
      }
    }
    if(t.indexOf('select') != -1){
      if(isEmpty(e.options[e.selectedIndex].value)){
        errors += n+errormsg[12]+ '<br>';
        errorsa += n+errormsg[12]+'\n';
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[12];
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
    }
    if(t == 'file'){
      if(isEmpty(v)){
        errors += n+errormsg[13]+'<br>';
        errorsa += n+errormsg[13]+'\n';
        e.className=newClass;
        errordivs = 'errordiv_' + e.name;
        if ((alerttype == '4' || alerttype == '5') && document.getElementById(errordivs)) {
	        document.getElementById(errordivs).innerHTML = n+errormsg[13];
	        document.getElementById(errordivs).style.display = 'block';
	        
	    }
        continue;
      }
      else {
        e.className='checkit';
      }
    }
  }
  div = document.getElementById('errordiv');
  if(errors != '') {
	  if(alerttype == '2' || alerttype == '3' || alerttype == '5') {
      alert(errorsa);
      }    
	  if(alerttype == '1' || alerttype == '3') {
      return dispErr(errors, div);
      }    
  }
  div.style.display="none";
  return errors == '';
}

dispErr = function(error, divo) {
  divo.style.display="block";
  divo.innerHTML = error;
  return false;
}


/*
The following elements are not validated...

button   type="button"
checkbox type="checkbox"
hidden   type="hidden"
radio    type="radio"
reset    type="reset"
submit   type="submit"

All elements are assumed required and will only be validated for an
empty value or defaultValue unless specified by the following properties.

isEmail = true;          // valid email address
isAlpha = true;          // A-Z a-z characters only
isNumeric = true;        // 0-9 characters only
isAlphaNumeric = true;   // A-Z a-z 0-9 characters only
isLength = number;       // must be exact length
isLengthBetween = array; // [lowNumber, highNumber] must be between lowNumber and highNumber
isPhoneNumber = true;    // valid phone number. See "isPhoneNumber()" comments for the formatting rules
isDate = true;           // valid date. See "isDate()" comments for the formatting rules
isMatch = string;        // must match string
optional = true;         // element will not be validated

alerttype = 0            // no error msg
alerttype = 1            // error msg in div
alerttype = 2            // error msg in alert
alerttype = 3            // error msg in div and alert
alerttype = 4            // error msg in separated div
alerttype = 5            // error msg in separated div and alert
*/

