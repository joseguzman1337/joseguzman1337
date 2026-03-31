function CambioRolPerfil(id)
{
    if(id)
    {
        var rol;
        switch(id)
        {
            case '1':{       
                $ingreso = confirm('Cambio a rol de Estudiante');
                if($ingreso)
                { 
                    rol = '600';
                    $.ajax({//Ajax
                        type: 'POST',
                        url: '../facultades/facultadeslv2.php',                     
                        data:({cambiorol:rol, rol:'1'}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                        success: function(data){  
                            window.open("../facultades/creacionestudiante/estudiante.php?sinestadocuenta", "contenidocentral");
                            window.open("../facultades/facultadeslv2.php", "leftFrame");
                        }//data
                    });// AJAX
                }
            }break;
            case '2':{                   
                $ingreso = confirm('Cambio a rol de docente');
                if($ingreso)
                {
                    window.open("../facultades/central.php", "contenidocentral");
                    rol = '500';
                    //var contra = prompt("Digite por favor su segunda contraseña", "*******");                 
                    $.ajax({//Ajax
                        type: 'POST',
                        url: '../facultades/facultadeslv2.php',                     
                        data:({cambiorol:rol, rol:'2', segClave:'segClave'}), 
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                        success: function(data){  
                            alert('Ahora debe digitar la segunda clave');
                            window.open("../facultades/facultadeslv2.php?segClave", "leftFrame");
                        }//data
                    });// AJAX
                }
            }break;
            case '3':{
                $ingreso = confirm('Cambio a rol Administrador');  
                if($ingreso)
                {
                    rol = '400';
                    $.ajax({//Ajax
                        type: 'POST',
                        url: '../facultades/facultadeslv2.php',                    
                        data:({cambiorol:rol, rol:'3'}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                        success: function(data){                        
                            window.open("../facultades/facultadeslv2.php", "leftFrame");
                            window.open("../facultades/central.php", "contenidocentral");
                        }//data
                    });// AJAX
                }
            }break;
                 case '4':{
                $ingreso = confirm('Cambio a rol Padre');  
                if($ingreso)
                {
                    rol = '900';
                    $.ajax({//Ajax
                        type: 'POST',
                        url: '../facultades/facultadeslv2.php',                    
                        data:({cambiorol:rol, rol:'4'}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                        success: function(data){                        
                            window.open("../facultades/facultadeslv2.php", "leftFrame");
                            window.open("../facultades/creacionestudiante/estudiante.php?sinestadocuenta", "contenidocentral");
                        }//data
                    });// AJAX
                }
            }break;
        }//switch
        
    }
}//CambioRolPerfil
