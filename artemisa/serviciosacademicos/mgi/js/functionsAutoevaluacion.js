function updateForm2(url){            
    if(aSelected.length==1){
          var id = aSelected[0];
			if(url.indexOf('?') === -1){
				window.location.href= url+"?id="+id;
			 } else {
				window.location.href= url+"&id="+id;
			 }
          }else{
             return false;
          }
}
        
function gotonuevo(pag){  
    window.location.href=pag;
}
   
function asignarPOB(url){
    if(aSelected.length==1){
          var id = aSelected[0];
             window.location.href= url+"&id_instrumento="+id;
          }else{
             return false;
          }
}

function deleteForm(entity){
    if(confirm('Esta seguro de inactivar este registro?')){                
        if(aSelected.length==1){
        var id = aSelected[0];
        id=id.substring(4,id.length);   
        // alert(id);
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'process.php',
            data: 'idsiq_'+entity+'='+id+'&entity='+entity+'&action=inactivate',
            success:function(data){ 
                if (data.success == true){
                        location.reload();
                }
            },
            error: function(data,error){}
        }); 
        }else{
            return false;
        }               
    }
}
        
function activateForm(entity){               
           if(aSelected.length==1){
                var id = aSelected[0];
                id=id.substring(4,id.length);                
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'process.php',
                    data: 'idsiq_'+entity+'='+id+'&entity='+entity+'&action=activate',
                    success:function(data){ 
                        if (data.success == true){
                             location.reload();
                        }
                    },
                    error: function(data,error){}
                }); 
            }else{
                    return false;
           }    
}

//Validacion del formulario de editar
function validateForm(name){
    //remove classes
    $(name + ' input').removeClass('error').removeClass('valid');
    var fields = $(name + ' input[type=text]');
    var error = 0;
    
    fields.each(function(){
        var value = $(this).val();
        if( $(this).hasClass('required') && (value.length<2 || value=="") && !$(this).attr('disabled') ) {
            $(this).addClass('error');
            $(this).effect("pulsate", { times:3 }, 500);
            error++;
        } else {
            if($(this).hasClass('correo') && !$(this).attr('disabled')){
                if(!validateEmail(value)){
                    $(this).addClass('error');
                    $(this).effect("pulsate", { times:3 }, 500);
                     error++;
                }
            } else {
                 $(this).addClass('valid'); }
        }
    });
    
    $(name + ' select').removeClass('error').removeClass('valid');
    var fields = $(name + ' select');
    
    fields.each(function(){
        var value = $(this).val();
        if( $(this).hasClass('required') && (value.length<1 || value=="") && !$(this).attr('disabled') ) {
            $(this).addClass('error');
            $(this).effect("pulsate", { times:3 }, 500);
            error++;
        } else {
            $(this).addClass('valid'); 
        }
    });
    
    if(error>0)
    { return false;}
    else { return true; }
    
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

function clearField(elem){
    if(!$("#"+elem.id).hasClass("Clicked")){
        elem.value = "";
        $("#"+elem.id).addClass("Clicked");
    }
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