$(document).ready(function(){
    $('#tipoanexos').change(function(){
        var result;
        var tipo = $('#tipoanexos option:selected').val();
        var idconvenio = $('#idconvenio').val();
        $.ajax({
        type: 'POST',
        url: 'AnexosConvenios_ajax.php',
        async: false,
        dataType: 'html',
        data:({actionID: 'validar',
            tipoanexo:tipo, id:idconvenio
        }),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
            if(data.val=='FALSE'){
                alert(data.descrip);
                return false;
            }else{
               $('#div_Anexos').html(data);  
            }
        }
        });
    });
});


function ValidarAnexo(form)
{
    var detalleconvenio = $('#idconvenio').val(); 
    var nombrearchivo = $('#archivo').val(); 
    var inputFile = object.get('dato');
    var file = inputFile.files[0];
    var archivo = $('archivo').val(file);
    var formdata = new FormData($(form));
    $.ajax({//Ajax
    type: 'POST',
    url: '../convenio/AnexosConvenios_ajax.php',
    async: false,
    dataType: 'json',
    data:formdata,
    cache: false,
    contentType: false,
    processData: false,
    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    success: function(data){
      if(data.val==false){
               alert('Error de Actualización');
               //return false;
          }else{
              alert('Datos Actualizados Correctamente');
               //location.href="../convenio/DetalleConvenio.php?Detalle="+detalleconvenio;
           }
    }//data
    });// AJAX
}
function Carreras(id){
    $.ajax({
        type: 'POST',
        url: 'AnexosConvenios_ajax.php',
        async: false,
        dataType: 'html',
        data:({actionID: 'Carrera',id:id}),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
               $('#Td_Carrera').html(data);  
        }
    });
}//function Carreras

function SemestreCarreras()
{
   var Carrera = $('#carrera').val();
    $.ajax({//Ajax
         type: 'POST',
         url: 'AnexosConvenios_ajax.php',
         async: false,
         dataType:'html',
         data:({actionID:'Semestre',Carrera:Carrera}),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              $('#Td_Semestres').html(data);
        }//data
    });// AJAX 
}