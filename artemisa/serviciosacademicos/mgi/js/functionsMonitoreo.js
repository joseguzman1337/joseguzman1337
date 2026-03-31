

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
         var id = aSelected[0];
         id=id.substring(4,id.length);
         window.location.href= "detalle.php?id="+id;
     }else{
         return false;
     }
}
        
function assignResponsable(id){    
    if (id != undefined) {
        window.location.href= "responsable.php?action=save&id="+id;
    } else {
        if(aSelected.length==1){
            var id = aSelected[0];
            id=id.substring(4,id.length);
            window.location.href= "responsable.php?action=save&id="+id;
        }else{
            return false;
        }
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

