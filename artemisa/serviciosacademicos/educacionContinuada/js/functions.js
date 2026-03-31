function calculateWidthMenu(){
    $('#menuPrincipal').css('width','auto');
    $('#pageContainer').css('width','auto');
    $('#body').css('width','auto');
    
    var actualWidth = $('#pageContainer').width();
    var totalLIWidth = 0;
    
    // Calculate total width of list items
    var lis = $('#menuPrincipal ul li');

    lis.each(function(){
        totalLIWidth += $(this).width();
    });
    
    //alert(actualWidth + " - " + totalLIWidth);
    
    //si el menu es mas grande que la pantalla, agranda la pantalla
    if(actualWidth<=totalLIWidth){
        $('#menuPrincipal').css('width',totalLIWidth+5);
        $('#pageContainer').css('width',totalLIWidth+5);
        $('#body').css('width',totalLIWidth+5);
    } 
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function calculateWidthMenuTabs(){
    $('#tabs').css('width','auto');
    $('#pageContainer').css('width','auto');
    $('#body').css('width','auto');
    
    var actualWidth = $('#pageContainer').width();
    var totalLIWidth = 0;
    
    // Calculate total width of list items
    var lis = $('#tabs ul li');

    lis.each(function(){
        totalLIWidth += $(this).width()+5;
    });
    
    //alert(actualWidth + " - " + totalLIWidth);
    
    //si el menu es mas grande que la pantalla, agranda la pantalla
    if(actualWidth<=totalLIWidth){
        $('#tabs').css('width',totalLIWidth);
        $('#pageContainer').css('width',totalLIWidth);
        $('#body').css('width',totalLIWidth);
    } 
}

//Para que al cambiar el tamaño de la página se arreglen las tablas
function resizeWindow(tableContainer,table){
     //window.location.href=window.location.href;
     //alert("aja ey");
     var maxWidth = $(tableContainer).width();  
     table.width(maxWidth);
}

function updateForm(){            
    if(aSelected.length==1){
          var id = aSelected[0];
             window.location.href= "editar.php?id="+id;
          }else{
             return false;
          }
}

        function deleteForm(entity,action){
            if(confirm('Esta seguro de '+action+' este registro?')){                
                if(aSelected.length==1){
                var id = aSelected[0];
                id=id.substring(4,id.length);                
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'process.php',
                    data: 'id='+id+'&entity='+entity+'&action=inactivate',
                    success:function(data){ 
                        if (data.success == true){
							 alert(data.message);
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

function updateForm(){            
    if(aSelected.length==1){
          var id = aSelected[0];
             window.location.href= "editar.php?id="+id;
          }else{
             return false;
          }
}

function gotodetalle(){            
     if(aSelected.length==1){
         var id = aSelected[0];
         id=id.substring(4,id.length);
         window.location.href= "detalle.php?id="+id;
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
        trimvalue = $.trim(value);
        if( $(this).hasClass('required') && (($(this).hasClass('number') && !$.isNumeric(value)) || (!$(this).hasClass('number') && (value.length<2 || trimvalue==""))) && !$(this).attr('disabled') ) {
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
            } else if($(this).hasClass('number') && !$(this).attr('disabled') && value!=""){
                if(!$.isNumeric(value)){
                    $(this).addClass('error');
                    $(this).effect("pulsate", { times:3 }, 500);
                     error++;
                }
            }else {
                 $(this).addClass('valid'); }
        }
    });
    
    fields = $(name + ' input[type=hidden]');
    
    fields.each(function(){
        var value = $(this).val();
        trimvalue = $.trim(value);
        if( $(this).hasClass('required') && (value.length<1 || trimvalue=="") && !$(this).attr('disabled') ) {
            $(this).addClass('error');
            error++;
        } else {
            $(this).addClass('valid'); 
        }
    });
    
    $(name + ' select').removeClass('error').removeClass('valid');
    fields = $(name + ' select');
    
    fields.each(function(){
        var value = $(this).val();
        trimvalue = $.trim(value);
        if( $(this).hasClass('required') && (value.length<1 || trimvalue=="") && !$(this).attr('disabled') ) {
            $(this).addClass('error');
            $(this).effect("pulsate", { times:3 }, 500);
            error++;
        } else {
            $(this).addClass('valid'); 
        }
    });
    
    $(name + ' textarea').removeClass('error').removeClass('valid');
    fields = $(name + ' textarea');
    
    fields.each(function(){
        var value = $(this).val();
        trimvalue = $.trim(value);
        if( $(this).hasClass('required') && (value.length<1 || trimvalue=="") && !$(this).attr('disabled') ) {
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

function gotonuevo(pag){  
    window.location.href=pag;
}

function isNumberKey(evt)
{
	var e = evt; 
	var charCode = (e.which) ? e.which : e.keyCode
        console.log(charCode);
        
        //el comentado me acepta negativos
	//if ( (charCode > 31 && (charCode < 48 || charCode > 57)) ||  charCode == 109 || charCode == 173 )
        if( charCode > 31 && (charCode < 48 || charCode > 57) ){
            //si no es - ni borrar
            if((charCode!=8 && charCode!=45)){
                return false;
            }
        }

	return true;

}


function daysInMonth(iMonth, iYear)
{
	return 32 - new Date(iYear, iMonth, 32).getDate();
}

function popup_carga(url){        
        
            var centerWidth = (window.screen.width - 800) / 2;
            var centerHeight = (window.screen.height - 700) / 2;
    
          var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
          var mypopup = window.open(url,"",opciones);
          //Para que me refresque la página apenas se cierre el popup
          //mypopup.onunload = windowClose;​
          
          //para poner la ventana en frente
          window.focus();
          mypopup.focus();
          
      }
