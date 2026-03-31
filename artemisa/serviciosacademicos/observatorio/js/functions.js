function updateForm(){            
    if(aSelected.length==1){
          var id = aSelected[0];
             window.location.href= "editar.php?id="+id;
          }else{
             return false;
          }
}

function updateForm2(url){            
    if(aSelected.length==1){
          var id = aSelected[0];
             window.location.href= url+"?id="+id;
          }else{
             return false;
          }
}

function excel2(sql){
    window.location.href='excel.php?sql='+sql;
}

function updateForm3(url){            
      window.location.href= url;
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
                    data: 'idobs_'+entity+'='+id+'&entity='+entity+'&action=inactivate',
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


function gotonuevo(pag){  
    window.location.href=pag;
}

function exportar(pag){  
    window.location.href=pag;
}

function deleteRegistro(entity,id,form){
            if(confirm('Esta seguro que desea eliminar este registro?')){                
             
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'process.php',
                    data: 'id_del='+id+'&entity='+entity+'&action=inactivate',
                    success:function(data){ 
                        if (data.success == true){
                            alert('Se elimino satisfactoriamente')
                             $(location).attr('href',form);
                        }
                    },
                    error: function(data,error){}
                }); 
           
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
                    data: 'idobs_'+entity+'='+id+'&entity='+entity+'&action=inactivate',
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
function validateEmail(emailElement) {
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var address = emailElement;
    //alert("correo: " + address + " =" + reg.test(address));
    if(reg.test(address) == false) {
        return false;
    }
        return true;
}

function displayCarrera(){
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionValue = jQuery("select[name='codigomodalidadacademica']").val();
        //alert(optionValue);
        jQuery("#carreraAjax")
            .html(ajaxLoader)
            .load('generacarrera.php', {id: optionValue, opt:'sin_ind', status: 1}, function(response){					
            if(response) {
                jQuery("#carreraAjax").css('display', '');                         
            } else {                    
                jQuery("#carreraAjax").css('display', 'none');                     
            }
        });     
    }
    
    function displayMateria(){
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionValue = jQuery("select[name='codigocarrera']").val();
        jQuery("#materiaAjax")
            .html(ajaxLoader)
            .load('generamateria.php', {id: optionValue, opt:'sin_ind', status: 1}, function(response){					
            if(response) {
                jQuery("#materiaAjax").css('display', '');                         
            } else {                    
                jQuery("#materiaAjax").css('display', 'none');                     
            }
        });     
    }
    
    function displayCarrera1(){
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionValue = jQuery("select[name='codigomodalidadacademica1']").val();
        jQuery("#carrera1Ajax")
            .html(ajaxLoader)
            .load('generacarrera.php', {id: optionValue, opt:'sin_ind', status: 1, nom:1}, function(response){					
            if(response) {
                jQuery("#carrera1Ajax").css('display', '');                         
            } else {                    
                jQuery("#carrera1Ajax").css('display', 'none');                     
            }
        });     
    }

 
  function displayCarrera2(){
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionValue = jQuery("select[name='codigomodalidadacademica']").val();
        var optionFacultad = jQuery("select[name='codigofacultad']").val();
        jQuery("#carreraAjax")
            .html(ajaxLoader)
            .load('generacarrera.php', {id: optionValue, opt:'sin_ind', status: 2, idfacultad:optionFacultad }, function(response){					
            if(response) {
                jQuery("#carreraAjax").css('display', '');                         
            } else {                    
                jQuery("#carreraAjax").css('display', 'none');                     
            }
        });     
    }
    
    function displayCarrera3(){
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionValue = jQuery("select[name='codigomodalidadacademica']").val();
        jQuery("#carreraAjax")
            .html(ajaxLoader)
            .load('generacarrera.php', {id: optionValue, opt:'sin_ind', status: 3}, function(response){					
            if(response) {
                jQuery("#carreraAjax").css('display', '');                         
            } else {                    
                jQuery("#carreraAjax").css('display', 'none');                     
            }
        });     
    }
    
        function displayCarrera4(){
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionValue = jQuery("select[name='codigomodalidadacademica']").val();
        var periodo = jQuery("select[name='codigoperiodo']").val();
        var entity=$("#entity").val();
        jQuery("#carreraAjax")
            .html(ajaxLoader)
            .load('generacarrera.php', {id: optionValue, opt:'sin_ind', status: 4, Periodo:periodo, entity:entity}, function(response){					
            if(response) {
                jQuery("#carreraAjax").css('display', '');                         
            } else {                    
                jQuery("#carreraAjax").css('display', 'none');                     
            }
        });     
    }
    
      function displayFacultad(){
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionFacultad = jQuery("select[name='codigofacultad']").val();
        var optionValue = jQuery("select[name='codigomodalidadacademica']").val();
        jQuery("#carreraAjax")
            .html(ajaxLoader)
            .load('generacarrera.php', {id: optionValue, opt:'sin_ind', status: 2, idfacultad:optionFacultad  }, function(response){					
            if(response) {
                jQuery("#carreraAjax").css('display', '');                        
            } else {                    
                jQuery("#carreraAjax").css('display', 'none');                    
            }
        });     
    }
    
    function checkTodos (pID) {
           $("."+pID+":checkbox:not(:checked)").attr("checked", "checked");
    }
    
    function checkNinguno(pID){
        $("."+pID+":checkbox:checked").removeAttr("checked");
    }
    
    function excel(tabla,form,div){
  		$("#"+div).val( $("<div>").append( $("#"+tabla).eq(0).clone()).html());
                $("#"+form).submit(); 
}

function buscarestu(id){
       // alert(id)
        var nombre=$("#nombre").val();
        var apellido=$("#apellido").val();
        var numero=$("#numero").val();
        var mod=jQuery("select[name='codigomodalidadacademica']").val();
        var prog=jQuery("select[name='codigocarrera']").val();
        var materia = jQuery("select[name='codigomateria']").val();
       // alert(materia);
        var ajaxLoader = "<img src='../img/ajax-loader.gif' alt='loading...' />";           
        var esta=0;
       // alert (Periodo);
        if ( (nombre!='' && apellido=='') || (nombre=='' && apellido!='')){
            esta=1
             alert('Debe Buscar por nombre y apellido')
        }
        if (mod!='' && prog==''){
            alert("Debe escoger la carrera");
                 $('#codigocarrera').css('border-color','#F00');
                 $('#codigocarrera').effect("pulsate", {times:3}, 500);
                 $("#codigocarrera").focus();
           
        }
        else{
            if (esta==0){
                jQuery("#EstudianteAjax")
                .html(ajaxLoader)
                .load('generaestudiante.php', {id:id, nombre: nombre, apellido:apellido, identificacion:numero, modalidad:mod, codigocarrera:prog, materia:materia}, function(response){					
                if(response) {
                        jQuery("#EstudianteAjax").css('display', '');   
                        jQuery("#EstudianteAjax2").css('display', 'none');                    
                } else {                    
                    jQuery("#EstudianteAjax").css('display', 'none'); 
                    jQuery("#EstudianteAjax2").css('display', '');                    
                }
            });  
            }
        }
    }

    function buscardoc(id){
        var nombre=$("#nombreD").val();
        var apellido=$("#apellidoD").val();
        var numero=$("#numeroD").val();
        var mod=jQuery("select[name='codigomodalidadacademica1']").val();
        var prog=jQuery("select[name='codigocarrera1']").val();
        var ajaxLoader = "<img src='../img/ajax-loader.gif' alt='loading...' />";           
        var esta=0;
       // alert (Periodo);
        if ( (nombre!='' && apellido=='') || (nombre=='' && apellido!='')){
            esta=1
             alert('Debe Buscar por nombre y apellido')
        }
        
        if (esta==0){
            jQuery("#DocenteAjax")
            .html(ajaxLoader)
            .load('generadocente.php', {status:1, id:id, nombre: nombre, apellido:apellido, identificacion:numero, modalidad:mod, carrera:prog}, function(response){					
            if(response) {
                    jQuery("#DocenteAjax").css('display', '');   
                    jQuery("#DocenteAjax2").css('display', 'none');                    
            } else {                    
                jQuery("#DocenteAjax").css('display', 'none'); 
                jQuery("#DocenteAjax2").css('display', '');                    
            }
        });  
        }
    }
    
        function SINO(cual,t) {
            if ($("#"+cual+"").is (':visible')){
                   $("#"+cual+"").css("display", "none"); 
            } else {

               for ( var i = 1; i <= 10; i++ ) {
                    if (i==t){
                      $("#"+cual+"").css("display", "block");   
                    }else{
                      $("#demo"+i+"").css("display", "none");    
                    }
               }
            }
         }
         
function suma(){
    
    var total=0;
    var c=0;
    if ($('#prueba_tipo').length){
        if($('#prueba_tipo').val()=="1"){
            for(i=1;i<parseInt($("#totalmaterias").val());i++){
                if($("#puntaje"+i).val()!=''){ total=total+parseFloat($("#puntaje"+i).val());}
            }
            
            var promedio1=(total/(parseInt($("#totalmaterias").val())-1));
            
        }else{
            
            for(i=1;i<parseInt($("#totalmateriasdos").val());i++){
                
                if($("#puntajedos"+i).val()!=''){ total=total+parseFloat($("#puntajedos"+i).val());}
                 
            }
            var promedio1=(total/(parseInt($("#totalmaterias").val())-1));
        }
    
    }else{
         for(i=1;i<parseInt($("#totalmaterias").val());i++){
            if($("#puntaje"+i).val()!=''){ total=total+parseFloat($("#puntaje"+i).val());}
         }
         var promedio1=(total/parseInt($("#totalmaterias").val()));
    }
    
    
    
    
    $("#ponderado").val(promedio1);
}

 function puntajeF(i){
       // alert('aca')    
        
            var total=0;
            for (j=0;j<i;j++){
            var pun=parseInt($("input[id='puntaje_"+j+"']:checked").val());
                if (isNaN(pun)){
                    //total=0;
                }else{
                    total=pun+total;
                    //alert(pun+'-->'+j+'-->'+total)
                }

            }
            $("#puntajeT").val(total)
        }
function promedio(){
    var total=0;
    var c=0;
    if ($('#prueba_tipo').length){
        if($('#prueba_tipo').val()=="1"){
            for(i=0;i<=parseInt($("#totalmaterias").val());i++){
                if ($("#puntaje"+i).val()!='' && $('#checkfacultad'+i).is(':checked')){ total=total+parseFloat($("#puntaje"+i).val()); c=c+1 }  
            }
        }
        if($('#prueba_tipo').val()=="2")
        {    
            for(i=1;i<parseInt($("#totalmateriasdos").val());i++){
                if ($("#puntajedos"+i).val()!='' && $('#checkfacultados'+i).is(':checked')){ total=total+parseFloat($("#puntajedos"+i).val()); c=c+1 }         
            }
            
        }
        if($('#prueba_tipo').val()=="3")
        {    
            for(i=1;i<parseInt($("#totalmateriasdos").val());i++){
                if ($("#puntajetres"+i).val()!='' && $('#checkfacultatres'+i).is(':checked')){ total=total+parseFloat($("#puntajetres"+i).val()); c=c+1 }         
            }
            
        }
    
    }else{
         for(i=0;i<=parseInt($("#totalmaterias").val());i++){
            if ($("#puntaje"+i).val()!='' && $('#checkfacultad'+i).is(':checked')){ total=total+parseFloat($("#puntaje"+i).val()); c=c+1 }  
         }
        
    }
   
    /*
    if ($("#lenguaje").val()!='' && $('#lenguajef').is(':checked')){ mat1=parseFloat($("#lenguaje").val()); c=c+1 }
    if ($("#matematicas").val()!='' && $('#matematicasf').is(':checked')){ mat2=parseFloat($("#matematicas").val()); c=c+1 }
    if ($("#sociales").val()!='' && $('#socialesf').is(':checked')){ mat3=parseFloat($("#sociales").val()); c=c+1}
    if ($("#biologia").val()!='' && $('#biologiaf').is(':checked')){ mat4=parseFloat($("#biologia").val()); c=c+1}
    if ($("#filosofia").val()!='' && $('#filosofiaf').is(':checked')){ mat5=parseFloat($("#filosofia").val()); c=c+1}
    if ($("#quimica").val()!='' && $('#quimicaf').is(':checked')){ mat6=parseFloat($("#quimica").val()); c=c+1}
    if ($("#fisica").val()!='' && $('#fisicaf').is(':checked')){ mat7=parseFloat($("#fisica").val()); c=c+1}
    var total=mat1+mat2+mat3+mat4+mat5+mat6+mat7;*/
    var promedio1=(total/c);
    $("#puntajef").val(promedio1); 
    if (promedio1>=60){
        $('input:radio[id=puntaje_9]')[3].checked = true;
    }else if (promedio1>=50 && promedio1<=59){
        $('input:radio[id=puntaje_9]')[2].checked = true;
    }else if (promedio1>=40 && promedio1<=49){  
         $('input:radio[id=puntaje_9]')[1].checked = true;
    }else if (promedio1<=39){
         $('input:radio[id=puntaje_9]')[0].checked = true;
    } 
}//promedio


function parseDate(input) {
  var parts = input.split('-');
  // new Date(year, month [, day [, hours[, minutes[, seconds[, ms]]]]])
  return new Date(parts[0], parts[1]-1, parts[2]); // Note: months are 0-based
}


function fechasaber11(fechaprueba) {
    var fech1 = document.getElementById(fechaprueba).value;
    var fech2 = '2014-07-31';
    var fech3 = '2016-03-01';
    
    if((parseDate(fech1)) > (parseDate(fech2))){
        if((parseDate(fech1)) > (parseDate(fech3))){
            //muestra formulario tipo 3
            document.getElementById('tipo1').style.display = 'none';
            document.getElementById('tipo2').style.display = 'none';
            document.getElementById('tipo3').style.display = '';
            document.getElementById('prueba_tipo').value = '3';
        }else
        {
            //muestra formulario tipo 2
            document.getElementById('tipo1').style.display = 'none';
            document.getElementById('tipo3').style.display = 'none';
            document.getElementById('tipo2').style.display = '';
            document.getElementById('prueba_tipo').value = '2';
        }
    }else{
        //muestra formulario tipo 1
        document.getElementById('tipo2').style.display = 'none';
        document.getElementById('tipo3').style.display = 'none';
        document.getElementById('tipo1').style.display = '';
        document.getElementById('prueba_tipo').value = '1';
    }
}



//////////////////////////////
function promedioold(){
     var mat1=0; var mat2=0; var mat3=0; var mat4=0;
    var mat5=0; var mat6=0; var mat7=0; var c=0;
    for(i=0;i>parseInt("5");i++){
        
        
    }
    if ($("#lenguaje").val()!='' && $('#lenguajef').is(':checked')){ mat1=parseFloat($("#lenguaje").val()); c=c+1 }
    if ($("#matematicas").val()!='' && $('#matematicasf').is(':checked')){ mat2=parseFloat($("#matematicas").val()); c=c+1 }
    if ($("#sociales").val()!='' && $('#socialesf').is(':checked')){ mat3=parseFloat($("#sociales").val()); c=c+1}
    if ($("#biologia").val()!='' && $('#biologiaf').is(':checked')){ mat4=parseFloat($("#biologia").val()); c=c+1}
    if ($("#filosofia").val()!='' && $('#filosofiaf').is(':checked')){ mat5=parseFloat($("#filosofia").val()); c=c+1}
    if ($("#quimica").val()!='' && $('#quimicaf').is(':checked')){ mat6=parseFloat($("#quimica").val()); c=c+1}
    if ($("#fisica").val()!='' && $('#fisicaf').is(':checked')){ mat7=parseFloat($("#fisica").val()); c=c+1}
    var total=mat1+mat2+mat3+mat4+mat5+mat6+mat7;
    var promedio1=(total/c);
    $("#puntajef").val(promedio1); 
    if (promedio1>=60){
        $('input:radio[id=puntaje_9]')[3].checked = true;
    }else if (promedio1>=50 && promedio1<=59){
        $('input:radio[id=puntaje_9]')[2].checked = true;
    }else if (promedio1>=40 && promedio1<=49){  
         $('input:radio[id=puntaje_9]')[1].checked = true;
    }else if (promedio1<=39){
         $('input:radio[id=puntaje_9]')[0].checked = true;
    } 

}


function displayRiesgo(i){
            var sec=jQuery("select[id='idobs_admitidos_contexto_"+i+"']").val();
            //alert(sec)
            var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />"; 
            jQuery("#nivel_"+i)
            .html(ajaxLoader)
            .load('generariesgo.php', {id: sec  }, function(response){					
            if(response) {
                jQuery("#nivel_"+i).css('display', '');                        
            } 
        });      
        }
        
        function buscardocente(i){
            var doc=$("#numerodocumento_"+i).val();
            var tipo=jQuery("select[name='codigotipousuario_"+i+"']").val();
            var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />"; 
            jQuery("#docente_"+i)
            .html(ajaxLoader)
            .load('generarusuario.php', {ndocumento: doc, status:2, i:i, tipo:tipo }, function(response){					
            if(response) {
                jQuery("#docente_"+i).css('display', '');                        
                } 
            });
            
        }
        
        function masdoc(i){
            jQuery("#tr"+i).css('display', ''); 
        }