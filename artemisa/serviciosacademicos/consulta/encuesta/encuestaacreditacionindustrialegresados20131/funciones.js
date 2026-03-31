function manejadorUsuarioRespuesta()
{
    // when readyState is 4, we are ready to read the server response
    if (xmlHttp2.readyState == 4)
    {
        // continue only if HTTP status is "OK"
        if (xmlHttp2.status == 200)
        {
            try
            {
                // do something with the response from the server
                //handleServerResponse2();
                responsetext=xmlHttp2.responseText
                //alert(responsetext);
                pasaestado=false;
                var preguntasdpendencia=ArregloXMLObj('preguntadependencia');
                for(i=0;i<preguntasdpendencia.length;i++){
                    var preguntaobligatorio=document.getElementById('h'+preguntasdpendencia[i]);
                    //alert('div'+preguntasdpendencia[i]);
                    var muestrapregunta=document.getElementById('div'+preguntasdpendencia[i]);
                    if(muestrapregunta!=null){
                        // alert("muestra="+muestrapregunta.id);
                        muestrapregunta.style.visibility='visible';
                        muestrapregunta.style.position='static';
                    }
                    if(preguntaobligatorio!=null){                        
                        preguntaobligatorio.value='';                        
                    // alert("pregunta="+preguntasdpendencia[i]);
                    }
                }
                var preguntasnodependencia=ArregloXMLObj('preguntanodependencia');
                for(i=0;i<preguntasnodependencia.length;i++){
                    var preguntanoobligatorio=document.getElementById('h'+preguntasnodependencia[i]);
                    //alert('div'+preguntasnodependencia[i]);

                    var ocultapregunta=document.getElementById('div'+preguntasnodependencia[i]);
                    if(ocultapregunta!=null){                       
                       // alert("oculta="+ocultapregunta.id);
                        ocultapregunta.style.visibility='hidden';
                        ocultapregunta.style.position='fixed';
                    }
                    if(preguntanoobligatorio!=null){   
                        preguntanoobligatorio.value='1';
                    //alert("nopregunta="+preguntasnodependencia[i]);
                    }
                }
            }
            catch(e)
            {
                // display error message
                //alert("Error reading the response: " + e.toString());
                alert("Error reading the response: " + e.toString());
            }
        }
        else
        {
            // display status message
            alert("There was a problem retrieving the data:\n" + xmlHttp2.statusText);
        }
    }
}

function enviarrespuesta(obj,idpregunta,idusuario,idencuesta){
    var params="idpregunta="+idpregunta+"&idusuario="+idusuario+"&idencuesta="+idencuesta+"&valorrespuesta="+obj.value;

    //process("../../../funciones/sala_genericas/encuesta/actualizarespuestapregunta.php",params);
    ajaxFuncion("actualizarencuestaeducontinuada.php",params);
    var preguntaobligatorio=document.getElementById('h'+idpregunta);
    if(preguntaobligatorio!=null){
        preguntaobligatorio.value='1';
    }
    // alert("actualizarencuestaeducontinuada.php?"+params);
    return true;
}
var preguntadetalle=new Array();
var ajaxObjects = new Array();
function enviarrespuestadetalle(obj,idpregunta,idusuario,idencuesta,iddetallepregunta,cantidadvalida,esabierta){
    var preguntaobligatorio=document.getElementById('h'+idpregunta);
    //alert('h'+idpregunta)
    if(esabierta){
        var preguntaabierta=document.getElementById('a'+obj.value);
        if(obj.checked){
            preguntaabierta.disabled=false;
        }
        else{
            preguntaabierta.disabled=true;
        }
    }
    if(obj.checked){
        var estado='100';
        if(preguntaobligatorio!=null){
            preguntaobligatorio.value='1';
        }
    }
    else{
        var  estado='200';
    }
    if(obj.disabled==false){
        var params="idpregunta="+idpregunta+"&idusuario="+idusuario+
        "&idencuesta="+idencuesta+
        "&valorrespuesta="+obj.value+
        "&estado="+estado+
        "&cantidadvalida="+cantidadvalida;
        // process("actualizardetalle.php",params);

        var ajaxIndex = ajaxObjects.length;
        ajaxObjects[ajaxIndex] = new sack();
        var url = "actualizardetalle.php?" + params;
        //alert(url);
        ajaxObjects[ajaxIndex].requestFile = url;	// Specifying which file to get
        ajaxObjects[ajaxIndex].onCompletion = function() { //saveComplete(ajaxIndex);
            //alert("Entro aqui response="+url+"\n"+ajaxObjects[ajaxIndex].response);
            if(ajaxObjects[ajaxIndex].response=='OK'){
                //alert('OK papa');
                return true;
            }
            else{
                if(obj.checked){
                    alert('No puede seleccionar mas opciones');
                    obj.checked=false;
                    if(esabierta){
                        var preguntaabierta=document.getElementById('a'+obj.value);
                        if(obj.checked){
                            preguntaabierta.disabled=false;
                        }
                        else{
                            preguntaabierta.disabled=true;
                        }
                    }
                }
                return false;
            }

        } ;	// Specify function that will be executed after file has been found
        ajaxObjects[ajaxIndex].runAJAX();
    }
//process("../../../funciones/sala_genericas/encuesta/actualizarespuestapregunta.php",params);

//alert("actualizarespuestapregunta.php?"+params);

}
function bloqueachequeopregunta(obj,iddetallepregunta,idpregunta){
    var observaciondetalle=document.getElementById(iddetallepregunta);
    var estadodetallepregunta=true;
    var detallepreguntavalor=null;
    var detallepregunta=null;
    var i=0;
    if(obj.checked){
        observaciondetalle.disabled=false;
        while(estadodetallepregunta){
            i++;
            //alert('mirando='+idpregunta+'c'+i);
            detallepreguntavalor=document.getElementById(idpregunta+'c'+i);
            if(detallepreguntavalor==null){
                estadodetallepregunta=false;
            }
            else{
                //alert('mirando='+idpregunta+'c'+i+' y su valor'+detallepreguntavalor.value);
                detallepregunta=document.getElementById(detallepreguntavalor.value);
                detallepregunta.disabled=true;
                detallepregunta.checked=false;
            }
        }
    }
    else{
        observaciondetalle.disabled=true;
        while(estadodetallepregunta){
            i++;
            //alert('mirando='+idpregunta+'c'+i);
            detallepreguntavalor=document.getElementById(idpregunta+'c'+i);
            if(detallepreguntavalor==null){
                estadodetallepregunta=false;
            }
            else{
                //alert('mirando='+idpregunta+'c'+i+' y su valor'+detallepreguntavalor.value);
                detallepregunta=document.getElementById(detallepreguntavalor.value);
                detallepregunta.disabled=false;
            }
        }
    }


}
function enviarmateria(){
    //alert(pagina);

    var formulario=document.getElementById("formescogemateria");
    //formulario.action="encuestaenfermeria.php";
    //alert(formulario.action);
    formulario.submit();
//return false;
}

            //open("../seguridad.html" , "ventana1" , "width=290,height=200,scrollbars=NO");
            //quitarFrame()