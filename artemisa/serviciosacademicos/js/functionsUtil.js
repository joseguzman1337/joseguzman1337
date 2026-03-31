function openPopUp(url){        
        
     var centerWidth = (window.screen.width - 850) / 2;
     var centerHeight = (window.screen.height - 700) / 2;
     
     var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
     
     var mypopup = window.open(url,"",opciones);
     //Para que me refresque la página apenas se cierre el popup
     //mypopup.onunload = windowClose;​

     //para poner la ventana en frente
     window.focus();
     mypopup.focus();  
}

function mainfunc (func){
            this[func].apply(this, Array.prototype.slice.call(arguments, 1));
        }


function validateEmail(emailElement) {
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var address = emailElement;
    //alert("correo: " + address + " =" + reg.test(address));
    if(reg.test(address) == false) {
        return false;
    }
        return true;
}

function roundNumber(num, dec) {
    var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
    return result;
}

// function to format a number with separators. returns formatted number.
// num - the number to be formatted
// decpoint - the decimal point character. if skipped, "." is used
// sep - the separator character. if skipped, "," is used
function FormatNumberBy3(num, decpoint, sep) {
    // check for missing parameters and use defaults if so
    if (arguments.length == 2) {
        sep = ",";
    }
    if (arguments.length == 1) {
        sep = ",";
        decpoint = ".";
    }
    // need a string for operations
    num = num.toString();
    // separate the whole number and the fraction if possible
    a = num.split(decpoint);
    x = a[0]; // decimal
    y = a[1]; // fraction
    z = "";
    if (typeof(x) != "undefined") {
    // reverse the digits. regexp works from left to right.
        for (i=x.length-1;i>=0;i--)
        z += x.charAt(i);
        // add seperators. but undo the trailing one, if there
        z = z.replace(/(\d{3})/g, "$1" + sep);
        if (z.slice(-sep.length) == sep)
        z = z.slice(0, -sep.length);
        x = "";
        // reverse again to get back the number
        for (i=z.length-1;i>=0;i--)
        x += z.charAt(i);
        // add the fraction back in, if it was there
        if (typeof(y) != "undefined" && y.length > 0)
        x += decpoint + y;
    }
    return x;
}

function gotonuevo(pag){  
    window.location.href=pag;
}