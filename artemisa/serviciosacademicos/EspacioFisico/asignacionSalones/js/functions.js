function calculateWidthMenuTabs(){
    $('#tabs').css('width','auto');
    $('#pageContainer').css('width','auto');
    $('#body').css('width','auto');
    
    var actualWidth = $('#pageContainer').width();
    var actualWidthSmaller = $('#contenido').width();
    if(typeof actualWidthSmaller != 'undefined' && actualWidthSmaller>0){
        actualWidth = actualWidthSmaller;
    }
    var totalLIWidth = 0;
    
    // Calculate total width of list items
    var lis = $('#tabs ul li');

    if(!$("#tabs").hasClass("ui-tabs-vertical")&&!$("#tabs").hasClass("dontCalculate")){        
        lis.each(function(){
            totalLIWidth += $(this).width()+10;
        });
    } else if($("#tabs").hasClass("ui-tabs-vertical")){
        totalLIWidth = $(".ui-tabs-nav").width() + $(".ui-tabs-panel").width() + 60;
    } else {
        totalLIWidth = $(".ui-tabs-nav").width() + 25;
    }
    //console.log(totalLIWidth);
    //console.log(actualWidth);

        //alert(actualWidth + " - " + totalLIWidth);

        //si el menu es mas grande que la pantalla, agranda la pantalla
        if(actualWidth<=totalLIWidth){
            $('#tabs').css('width',totalLIWidth);
            $('#pageContainer').css('margin',"0 10px");
            $('#pageContainer').css('width',totalLIWidth);
            $('#body').css('width',totalLIWidth);
        } 
}

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
        $('#menuPrincipal').css('width',totalLIWidth);
        $('#pageContainer').css('width',totalLIWidth);
        $('#body').css('width',totalLIWidth);
    } 
}

//Para que al cambiar el tamaño de la página se arreglen las tablas
function resizeWindow(tableContainer,table){
     //window.location.href=window.location.href;
     //alert("aja ey");
     if(typeof table != 'undefined'){
        var maxWidth = $(tableContainer).width();  
        table.width(maxWidth);
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

function deleteResponsable(entity){
            if(confirm('Esta seguro que desea eliminar este registro?')){                
                if(aSelected.length==1){
                var id = aSelected[0];
                id=id.substring(4,id.length);                
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



        function deleteForm(entity){
            if(confirm('Esta seguro de inactivar este registro?')){                
                if(aSelected.length==1){
                var id = aSelected[0];
                id=id.substring(4,id.length);                
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
        trimvalue = $.trim(value);
        if( $(this).hasClass('required') && (($(this).hasClass('number') && (!$.isNumeric(value) || (value.indexOf('-') !== -1) || (value.indexOf('+') !== -1))) || (!$(this).hasClass('number') && (value.length<1 || trimvalue==""))) && !$(this).attr('disabled') ) {
            $(this).addClass('error');
            $(this).effect("pulsate", {times:3}, 500);
            error++;
        } else {
            if($(this).hasClass('correo') && !$(this).attr('disabled')){
                if(!validateEmail(value)){
                    $(this).addClass('error');
                    $(this).effect("pulsate", {times:3}, 500);
                     error++;
                }
            } else {
                 $(this).addClass('valid');}
        }
    });
    
    $(name + ' select').removeClass('error').removeClass('valid');
    var fields = $(name + ' select');
    
    fields.each(function(){
        var value = $(this).val();
        trimvalue = $.trim(value);
        if( $(this).hasClass('required') && (value.length<1 || trimvalue=="") && !$(this).attr('disabled') ) {
            $(this).addClass('error');
            $(this).effect("pulsate", {times:3}, 500);
            error++;
        } else {
            $(this).addClass('valid'); 
        }
    });
    
    $(name + ' textarea').removeClass('error').removeClass('valid');
    var fields = $(name + ' textarea');
    
    fields.each(function(){
        var value = $(this).val();
        trimvalue = $.trim(value);
        if( $(this).hasClass('required') && (value.length<1 || trimvalue=="") && !$(this).attr('disabled') ) {
            $(this).addClass('error');
            $(this).effect("pulsate", {times:3}, 500);
            error++;
        } else {
            $(this).addClass('valid'); 
        }
    });
    
    if(error>0)
    {return false;}
    else {return true;}
    
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
        //console.log(charCode);
        
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

function isNumberVal(val,key)
{
    //console.log(val);
    
    //si no es numero
    if (!isNaN(new Number(val))){
        return false;
    }
    
    return true;

}

function isInteger(val){
	if(Math.floor(id) == id && $.isNumeric(id)){
		return true;
	} 
	
	return false;
}

function daysInMonth(iMonth, iYear)
{
	return 32 - new Date(iYear, iMonth, 32).getDate();
}

function popup_cargarDocumento(idFormulario,numTab,periodo,carrera){        
        
     var centerWidth = (window.screen.width - 850) / 2;
     var centerHeight = (window.screen.height - 700) / 2;
     var url = "";
     if (carrera === undefined){
        url = "../../SQI_Documento/Carga_Documento.html.php?actionID=Huerfana&idFormulario="+idFormulario+"&tab="+numTab+"&periodo="+periodo;
     } else {
        url = "../../SQI_Documento/Carga_Documento.html.php?actionID=Huerfana&idFormulario="+idFormulario+"&tab="+numTab+"&periodo="+periodo+"&carrera="+carrera;
     }
     var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
     if(carrera === ""){
        alert("Debe elegir el programa antes de continuar."); 
     } else {
        var mypopup = window.open(url,"",opciones);
        //Para que me refresque la página apenas se cierre el popup
        //mypopup.onunload = windowClose;​

        //para poner la ventana en frente
        window.focus();
        mypopup.focus(); 
     }
}

function popup_verDocumentos(idFormulario,numTab,periodo,carrera){        
        
     var centerWidth = (window.screen.width - 850) / 2;
     var centerHeight = (window.screen.height - 700) / 2;
     var url = "";
     if (carrera === undefined){
        url = "../../SQI_Documento/Documento_VerHuerfana.html.php?idFormulario="+idFormulario+"&tab="+numTab+"&periodo="+periodo;
     } else {
        url = "../../SQI_Documento/Documento_VerHuerfana.html.php?idFormulario="+idFormulario+"&tab="+numTab+"&periodo="+periodo+"&carrera="+carrera;
     }
     var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
     if(carrera === ""){
        alert("Debe elegir el programa antes de continuar."); 
     } else {
        var mypopup = window.open(url,"",opciones);
        //Para que me refresque la página apenas se cierre el popup
        //mypopup.onunload = windowClose;​

        //para poner la ventana en frente
        window.focus();
        mypopup.focus();  
     }        
}



function addTableRowGeneric(formName) {
         var row = $(formName + ' table').children('tbody').children('tr:last').clone(true);
         row.find( 'input' ).each( function(){
            $( this ).val( '' )
        });
         $(formName + ' table').children('tbody').find('tr:last').after(row);  
         return true;
   }
   
   function removeTableRowGeneric(formName,inputName,action) {
       action = typeof action !== 'undefined' ? action : 'save2';
       
        if($(formName + ' table > tbody > tr').length>1){
         $(formName + ' table').children('tbody').children('tr:last').remove(); 
        } else if ($(formName + ' table').children('tbody').children('tr:last').find(inputName).val()=="") {
            alert("No puede eliminar la única fila. Debe por lo menos ingresar 1 dato.");
        } else {
            $(formName + ' table tbody input').each(function() {                                     
                   $(this).val("");                                       
             });
             $(formName + ' #action').val(action);
        }
         return true;
   }
   
   function replaceCommas(formName){
       $( formName + " input[type='text']" ).each(function(  ) {
                        $(this).val($(this).val().replace(/\,/g, ''));
                    });
   }
   
   function addCommas(formName){
         $( formName + " input[type='text']" ).each(function(  ) {
                        $(this).val(FormatNumberBy3($(this).val(), '.', ','));
        });
   }
   
    function convertArray(arreglo){
             var length = arreglo.length;
             var result = new Array();
             for (var i = 0; i < length; i++) {
                result[arreglo[i].id] = arreglo[i].nombre;
                // Do something with element i.
               }
               return result;
         }
         
         
         function mainfunc (func){
            this[func].apply(this, Array.prototype.slice.call(arguments, 1));
        }
         