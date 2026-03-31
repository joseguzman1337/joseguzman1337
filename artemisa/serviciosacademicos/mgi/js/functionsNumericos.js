function assignFuncion(){            
     if(aSelected.length==1){
         //alert("ingrese");
          var id = aSelected[0];
          id=id.substring(4,id.length);
          window.location.href= "asignarFuncion.php?action=save&id="+id;
     }else{
          return false;
     }
}


function updateForm2(url){            
    if(aSelected.length==1){
          var id = aSelected[0];
             window.location.href= url+".php?id="+id;
          }else{
             return false;
          }
}
        
function gotodetalle(){            
     if(aSelected.length==1){
          //alert("ingrese  detalle");
         var id = aSelected[0];
         id=id.substring(4,id.length);
         window.location.href= "detalle.php?id="+id;
     }else{
        // alert("false  detalle");
         return false;
     }
}
        
function assignResponsable(){            
     if(aSelected.length==1){
          var id = aSelected[0];
          id=id.substring(4,id.length);
          window.location.href= "responsable.php?action=save&id="+id;
     }else{
          return false;
     }
}

function assignDestinatary(){            
     if(aSelected.length==1){
          var id = aSelected[0];
          id=id.substring(4,id.length);
          window.location.href= "destinatario.php?action=save&id="+id;
     }else{
          return false;
     }
     
}

