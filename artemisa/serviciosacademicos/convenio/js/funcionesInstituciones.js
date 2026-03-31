function validarDatos(from){
    
    var NombreInstitucion = $('#NombreInstitucion').val();
    var Direccion = $('#Direccion').val();
    var Ciudad = $('#Ciudad').val();
    var Email = $('#Email').val();

    if(NombreInstitucion === ''){
        alert("Debe digitar el nombre de la institución");
        document.getElementById("NombreInstitucion").focus();
        return false;
    }if(Direccion === ''){
        alert("Debe digitar la dirección de la institución");
        document.getElementById("Direccion").focus();
        return false;
    }if(Ciudad === '0'){
        alert("Debe seleccionar la ciudad de la institución");
        document.getElementById("Ciudad").focus();
        return false;
    }if(Email === ''){
        alert("Debe digitar el Email de la institución");
        document.getElementById("Email").focus();
        return false;
    }
        expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(Email) ){
        alert("Error: La dirección de correo " + Email + " es incorrecta.");
        document.getElementById("Email").focus();
        return false;
    }
    var data = validateForm(from);    
    if(data==true){
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/nuevaInstitucion.php',
         async: false,
         dataType: 'json',
         data:$(from).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert(data.descrip);
                       location.href="../convenio/listaInstituciones.php";
                   }
        }//data
       });// AJAX
    }    
}//function validarDatos

function validarDatosDetalle(from){
    var dato = validateForm(from);    
    if(dato==true){
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/detalleInstitucion.php',
         async: false,
         dataType: 'json',
         data:$(from).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert(data.descrip);
                       location.href="../convenio/listaInstituciones.php";
                   }
        }//dato
       });// AJAX
    }    
}//function validarDatosDetalle

function CambioClass(i){ 
    $('#Tr_File_'+i).removeClass('even');
    $('#Tr_File_'+i).removeClass('odd');
  $.ajax({//Ajax  
         type:'POST',
         url: 'listaInstituciones.php',
         async: false,
         dataType: 'json',
         data:({actionID:'TipoNumber',Numero:i}),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.num==1){
                   
                   $('#Tr_File_'+i).addClass('odd');
              }else{
                    
                   $('#Tr_File_'+i).addClass('even');
              }
        }//data
           
      });//AJAX
 $('#Tr_File_'+i).removeClass('ClasOnclikColor');
}//function CambioClass
  
function CargarNum(i,id,num){
  $('#IdInstitucion').val('');
  $('#Tr_File_'+i).removeClass('even');
  $('#Tr_File_'+i).removeClass('odd');
  $('#Tr_File_'+i).addClass('ClasOnclikColor');
  $('#IdInstitucion').val(id);
  for(j=0;j<num;j++){
       if(j!=i){
           $('#Tr_File_'+j).removeClass('ClasOnclikColor');
           //$('#Tr_File_'+j).addClass('even');
            CambioClass(j);
       }
  }
}//function CargarNum


function NuevaUbicacion(id){
    if(!$.trim(id)){
        alert('Selecione un Item...');
        return false;
    }else{
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/NuevaUbicacionInstitucion.php',
         dataType: 'html',
         data:({idinstitucion:id}),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
                location.href= "../convenio/NuevaUbicacionInstitucion.php?idinstitucion="+id;
              //$('#container').html(data);
           }
       });// AJAX     
    }
}//function NuevaUbicaion


function ListaUbicacion(id){
    if(!$.trim(id)){
        alert('Selecione un Item...');
        return false;
    }else{
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/ListaUbicacionInstitucion.php',
         dataType: 'html',
         data:({idinstitucion:id}),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              //$('#container').html(data);
              location.href= "../convenio/ListaUbicacionInstitucion.php?idinstitucion="+id;
           }
       });// AJAX     
    }
}//function ListaUbicacion



function validarDatosUbicacion(form){
    var nombreubicacion = $('#nombreubicacion').val();
     if(nombreubicacion === ''){
        alert("Debe digitar el nombre de la ubicación");
        document.getElementById("NombreInstitucion").focus();
        return false;
    }
    var data = validateForm(form);    
    if(data==true){
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/NuevaUbicacionInstitucion.php',
         async: false,
         dataType: 'json',
         data:$(form).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert(data.descrip);
                       location.href="../convenio/listaInstituciones.php";
                   }
        }//data
       });// AJAX
    }    
}//function validarDatosUbicacion

function validarDatosUbicacionDetalle(from){
    var data = validateForm(from);    
    if(data==true){
        $.ajax({//Ajax
         type: 'POST',
         url: '../convenio/DetallesUbicacionInstitucion.php',
         async: false,
         dataType: 'json',
         data:$(from).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert(data.descrip);
                       location.href="../convenio/listaInstituciones.php";
                   }
        }//data
       });// AJAX
    }    
}//function validarDatosUbicacion

function Regresar(){
    location.href="../convenio/listaInstituciones.php";
}

function NuevaInstitucion(){
    location.href="../convenio/nuevaInstitucion.php";
}

function RegresarConvenio(){
    location.href="../convenio/listaInstituciones.php";
}


function cambiarciudad()
{
    var Pais = $('#pais').val(); 
    $.ajax({//Ajax
         type: 'POST',
         url: 'NuevaUbicacionInstitucion.php',
         async: false,
         dataType:'html',
         data:({Action_id:'Ciudades',Pais:Pais}),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              $('#Tr_Ciudad').html(data);
              //alert(data);
        }//data
    });// AJAX
    
}
