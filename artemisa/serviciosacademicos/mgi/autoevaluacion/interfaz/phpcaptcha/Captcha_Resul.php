<?php

include ('../../../templates/template.php');
    
$db=writeHeader('Plataforma',true,'','../../../','body','',false,false);


//echo '<pre>';print_r($db);
?>


<style type="text/css">
body{ background: url("http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/bg_exito.jpg") repeat scroll 0 0 rgba(0, 0, 0, 0);
font-family: 'PT Sans', sans-serif;
margin:0;
padding:0;
color: #3E4729;
}
    #encabezado {
	    background-color: #3E4729;
	    border-bottom: 7px solid #88AB0C;
	    height: 80px;
	    width: 100%;
	    z-index: 100;
	}

	.cajon {
	    clear: both;
	    left: 50%;
	    margin-left: -480px;
	    position: relative;
	    width: 960px;
	}

	#encabezado > div > a {
	    display: block;
	    width: 172px;
	}
   
    
h1{
	font-weight:normal;
	padding-left:2em;
	color: #3E4729;
	}   
h2 {
	background-color: #2F79E7;
	color: #FFFFFF;
	padding: 5px;
	position: relative;
	border-bottom: 2px solid #88AB0C;
	margin-top:0;
	text-align:center;
} 
 img{
        margin-bottom: 8px;
    }
fieldset{
	padding:0;
	   position: relative;
    width: 50%;
	margin:2em;
	background:white;
	box-shadow: 0 0 5px 0 #CCCCCC;
	border:0;}
 .ui-autocomplete-loading {
background: white url('../../../images/ui-anim_basic_16x16.gif') right center no-repeat;
}
legend{ font-weight:bold}

fieldset > table{
	margin:1em 2em;
	}	
	
td{padding:1em 0;}
input[type="text"]{
   background: url("http://www.uelbosque.edu.co/sites/default/themes/ueb/images/campo_fondo.gif") repeat-x scroll 0 0 #EFF2DC;
    border-color: #E3E8CC #E3E8CC -moz-use-text-color;
    border-style: solid solid none;
    border-width: 2px 1px 0;
    font-size: 1em;
    width: 99%;
	padding:0.3em 0.2em;
	}
	
input[type="submit"] {
    background: url("http://www.uelbosque.edu.co/sites/default/themes/ueb/images/boton-de-busqueda.gif") repeat-x scroll 0 0 rgba(0, 0, 0, 0);
    border-color: #DDE2BC;
    border-style: solid;
    border-width: 1px;
    height: 25px;
    line-height: 25px;
    margin: 5px 0 0;
    padding: 3px;
    text-align: center;
}
</style>
<script>
    function CargarCarrera(){
        
        var modalidad  = $('#Modalidad').val();
        
        if(modalidad==0 || modalidad=='0'){
            /****************************************/
            alert('Selecione una Modalidad Academica');
            $('#Modalidad').effect("pulsate", {times:3}, 500);
            $('#Modalidad').css('border-color','#F00');  
            return false;
            /****************************************/
        }
        
        /***********************************************************************************/
        
        $.ajax({//Ajax
		      type: 'POST',
		      url: 'validar.php',
		      async: false,
		      dataType: 'html',
		      data:({actionID: 'Carreras',
                     modalidad:modalidad}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		      success: function(data){
					$('#Div_Carrera').html(data);
		   } 
	}); //AJAX
        
        /***********************************************************************************/
    }  
    function validar(){ 
        /****************************/
        
        if(!$.trim($('#cedula').val())){
            alert('Digite un Numero de Documento...');
            $('#cedula').effect("pulsate", {times:3}, 500);
            $('#cedula').css('border-color','#F00');  
            return false;
        }
        
//        if(!$.trim($('#Uno_apellido').val())){
//            alert('Digite Su Primer Apellido...');
//            $('#Uno_apellido').effect("pulsate", {times:3}, 500);
//            $('#Uno_apellido').css('border-color','#F00');  
//            return false;
//        }
//        
//        /*if(!$.trim($('#Sdo_apellido').val())){
//            alert('Digite Su Segundo Apellido...');
//            $('#Sdo_apellido').effect("pulsate", {times:3}, 500);
//            $('#Sdo_apellido').css('border-color','#F00');  
//            return false;
//        }*/
//        
//        if(!$.trim($('#Uno_nombre').val())){
//            alert('Digite Su Primer Nombre...');
//            $('#Uno_nombre').effect("pulsate", {times:3}, 500);
//            $('#Uno_nombre').css('border-color','#F00');  
//            return false;
//        }
        
        /*if(!$.trim($('#Sdo_nombre').val())){
            alert('Digite Su Segundo Nombre...');
            $('#Sdo_nombre').effect("pulsate", {times:3}, 500);
            $('#Sdo_nombre').css('border-color','#F00');  
            return false;
        }*/
        
        <?PHP 
        if($_REQUEST['actionID']=='Graduado'){
            ?>
            if($('#Modalidad').val()==0 || $('#Modalidad').val()=='0'){
                /*****************************************************/
                alert('Digite La Modalidad Academica');
                $('#Modalidad').effect("pulsate", {times:3}, 500);
                $('#Modalidad').css('border-color','#F00');  
                return false;
                /*****************************************************/
            }
            if($('#Carrera').val()==0 || $('#Carrera').val()=='0'){
                /*****************************************************/
                alert('Digite El Programa Academico');
                $('#Carrera').effect("pulsate", {times:3}, 500);
                $('#Carrera').css('border-color','#F00');  
                return false;
                /*****************************************************/
            }
            <?PHP
        }
        ?>
        
        if(!$.trim($('#captcha').val())){
            alert('Digite El Codigo Que Aprece en la Imagen...');
            $('#captcha').effect("pulsate", {times:3}, 500);
            $('#captcha').css('border-color','#F00');  
            return false;
        }
        /****************************/
    }
   	function isNumberKey(evt){
   	    
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
</script>
<br />
<br />
	<div style='margin:0 auto'>
        <form id="Capchat" name="Capchat" action="validar.php"  method="post">
             <div id="encabezado">
		<div class="cajon">
			<a title="Ir a la página principal" href="http://www.uelbosque.edu.co"><img id="logoU" alt="Universidad El Bosque" src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png"></a>			<!-- herramientas -->									
		</div>
	</div>   
            <div id="datos" aling="center" style="width: 100%; margin-left: 320px;">
           <fieldset> 
               <legend>Datos Personales</legend>
                    <table border="0" aling="center" >
                        <tr>
                            <td>
                               N&deg; de Documento:<span style="color:red; font-size:9px">(*)</span> 
                               <br>
                            </td>
  
                            <td>
                                <input type="text" name="cedula" id="cedula" value="" onkeypress="return isNumberKey(event)">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Ingrese el contenido de la imagen<span style="color:red; font-size:9px">(*)</span></td>
                        </tr>
                        <tr>
                            <td><img src="captcha.php"/></td>
                            <td width="60px">                           
                                <input type="text" name="captcha" id="captcha" maxlength="6" size="6"/>
                            </td>    
                        </tr>
                        <tr>
                        <?PHP 
                           if($_REQUEST['instrumento']){
                            ?>
                            <td>&nbsp;<input type="hidden" id="id_instrumento" name="id_instrumento" value="<?PHP echo $_REQUEST['instrumento']?>" /></td>
                            <?PHP
                           }
                           if($_REQUEST['actionID']){
                            ?>
                            <td>&nbsp;<input type="hidden" id="actionID" name="actionID" value="<?PHP echo $_REQUEST['actionID']?>" /></td>
                            <?PHP
                           }
                           
                        ?>
                            
                            <td colspan="3" aling="center"><input type="submit"  value="Ingresar" id="submit" onclick="return validar(this);"  /><!--button type="submit"--></td>
                        </tr>
                    </table>
          </fieldset>
       </div>
