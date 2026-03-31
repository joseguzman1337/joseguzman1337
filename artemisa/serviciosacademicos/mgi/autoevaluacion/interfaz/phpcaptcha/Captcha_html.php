<?php
/*
 * Ivan Dario quintero Rios
 * Junio 15 del 2018
 * Ajustes de google anaitycs
 */
    include ('../../../templates/template.php');    
    $db=writeHeader3('Plataforma',true,'','../../../','body','',false,false);
?>


<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <style type="text/css">
        html{
            height:100%;
        }
        body{ 
            background: url("http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/bg_exito.jpg") repeat scroll 0 0 rgba(0, 0, 0, 0);
            font-family: 'PT Sans', sans-serif;
            margin:0;
            padding:0;
            color: #3E4729;
            height:100%;
        }

        #pageContainer{
            background: url("http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/bg_exito.jpg") repeat scroll 0 0 rgba(0, 0, 0, 0);    
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
            border:0;
        }
        .ui-autocomplete-loading {
            background: white url('../../../images/ui-anim_basic_16x16.gif') right center no-repeat;
        }
        legend{ 
            font-weight:bold
        }
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
        $(document).ready(function(){
            $( "#idinstitucioneducativa1" ).autocomplete({
                source: "../generacolegio.php",
                minLength: 2
            });

            $("#idinstitucioneducativa1").focusout(function(){
                $.ajax({
                    url:'../colegio.php',
                    type:'POST',
                    dataType:'json',
                    data:{ matricula:$('#idinstitucioneducativa1').val()}
                }).done(function(respuesta){
                    $("#idinstitucioneducativa1").val(respuesta.nombre);
                    $("#idinstitucioneducativa").val(respuesta.id);
                });
            });
        });

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
                error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                    success: function(data){
                        $('#Div_Carrera').html(data);
                    } 
            }); //AJAX
            /***********************************************************************************/
        }
    
        function agregar_encuestado(){
            var id_instrumento=$("#id_instrumento").val();
            var dependencia=$("#dependencia1").val();
            var area=$("#areadependencia").val();
            var tipoencuestado=$("#tipoencuestado").val();
            var Num=$("#cedula").val();
                
            $.ajax({//Ajax
                type: 'POST',
                url: 'validar.php',
                async: false,
                dataType: 'json',
                data:({ actionID: 'Bienestar_laboral',
                    id_instrumento:id_instrumento,
                    dependencia:dependencia,
                    area:area,
                    Num:Num,
                    tipoencuestado:tipoencuestado}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert(data.descrip);
                        return false;
                    }
                }//data
            }); //AJAX
        }
      
        function validar(){ 
            /****************************/
            <?php    
            if($_REQUEST['instrumento']=="138"){
                ?>
                ////dependencia  
                if($('#dependencia1').val()=='null'){
                    alert('Elija una dependencia...');
                    $('#dependencia1').effect("pulsate", {times:3}, 500);
                    $('#dependencia1').css('border-color','#F00'); 
                    return false; 
                }                          
                ///areas
                if($('#areadependencia').val()=='null'){
                    alert('Elija una Area...');
                    $('#areadependencia').effect("pulsate", {times:3}, 500);
                    $('#areadependencia').css('border-color','#F00'); 
                    return false; 
                }
                //tipo empleado
                if($('#tipoencuestado').val()=='null'){
                    alert('Elija una tipo de encuestado...');
                    $('#tipoencuestado').effect("pulsate", {times:3}, 500);
                    $('#tipoencuestado').css('border-color','#F00'); 
                    return false; 
                }
                agregar_encuestado();
                /////////////
                <?php }else{ ?>
                if(!$.trim($('#cedula').val())){
                    alert('Digite un Numero de Documento...');
                    $('#cedula').effect("pulsate", {times:3}, 500);
                    $('#cedula').css('border-color','#F00');  
                    return false;
                }
        
                if(!$.trim($('#Uno_apellido').val())){
                    alert('Digite Su Primer Apellido...');
                    $('#Uno_apellido').effect("pulsate", {times:3}, 500);
                    $('#Uno_apellido').css('border-color','#F00');  
                    return false;
                }
        
           /*if(!$.trim($('#Sdo_apellido').val())){
            alert('Digite Su Segundo Apellido...');
            $('#Sdo_apellido').effect("pulsate", {times:3}, 500);
            $('#Sdo_apellido').css('border-color','#F00');  
            return false;
        }*/
       
      /* if($("#correo").val().indexOf('@', 0) == -1 || $("#correo").val().indexOf('.', 0) == -1) {
                    alert('Digite el correo...');
                    $('#correo').effect("pulsate", {times:3}, 500);
                    $('#correo').css('border-color','#F00');  
                    return false;
       }*/  
                if(!$.trim($('#Uno_nombre').val())){
                    alert('Digite Su Primer Nombre...');
                    $('#Uno_nombre').effect("pulsate", {times:3}, 500);
                    $('#Uno_nombre').css('border-color','#F00');  
                    return false;
                }
        
                if($("#actionID").val()=='PlanDocente'){
                    if($("#correo").val().indexOf('@', 0) == -1 || $("#correo").val().indexOf('.', 0) == -1) {
                        alert('Digite el correo...');
                        $('#correo').effect("pulsate", {times:3}, 500);
                        $('#correo').css('border-color','#F00');  
                        return false;
                    }
                }
        
                if($("#actionID").val()=='Externo'){
                    if($("#correo").val().indexOf('@', 0) == -1 || $("#correo").val().indexOf('.', 0) == -1) {
                        alert('Digite el correo...');
                        $('#correo').effect("pulsate", {times:3}, 500);
                        $('#correo').css('border-color','#F00');  
                        return false;
                    }else if(!$.trim($('#telefono').val())){
                        alert('Digite Su Telefono...');
                        $('#telefono').effect("pulsate", {times:3}, 500);
                        $('#telefono').css('border-color','#F00');  
                        return false;
                    }
                }
                <?php } ?>
        
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
    
        /**********funcion para llenar combobox de area*************/
        function cargaAreas(obj){
            $('#areadependencia').empty()
            var dropDown = document.getElementById("dependencia1");
            var carId = dropDown.options[dropDown.selectedIndex].value;
            $.ajax({
                type: "POST",
                url: "../genera_area.php",
                data: { 'id': carId  },
                success: function(data){
                    // Parse the returned json data
                    var opts = $.parseJSON(data);
                    // Use jQuery's each to iterate over the opts value
                    $('#areadependencia').append('<option value="null">Seleccione:</option>');
                    $.each(opts, function(i,areas){
                        //modelo de datos en json
                        $('#areadependencia').append('<option value="' + areas+ '">' + areas + '</option>');
                    });
                }
            });
        }
        /**************/
    </script>
    
    <div id="encabezado">
        <div class="cajon">
            <a title="Ir a la página principal" href="http://www.uelbosque.edu.co"><img id="logoU" alt="Universidad El Bosque" src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png"></a>			<!-- herramientas -->									
        </div>
	</div>
        <form id="Capchat" name="Capchat" action="validar.php"  method="post">
            <div id="datos" align="center" style="margin-left: 0 auto;">
            <fieldset> 
                <?PHP if($_REQUEST['actionID']=='Externo'){ ?>
                <h2>Pruebas de Inter&eacute;s</h2>
                <?php } ?>
                <h1 style="font-weight: bold;padding:0;padding-top: 20px;">Datos Personales</h1>
                <?PHP if(!isset($_REQUEST['actionID'])){ ?>
                <div style="border:3px solid #e6b63a;margin:5px 80px;padding:10px 30px;text-align:left;">
                    <p style="margin-bottom:15px;">Todas sus respuestas son confidenciales. Por favor responda con total honestidad, teniendo en cuenta que no hay respuestas correctas o incorrectas.</p>
                    <p>Los datos que se piden a continuación sólo son una validación para el ingreso y no quedan registrados en el sistema.</p>
                </div>
                <?php } ?>
                <table border="0" aling="center" >     
                    <tr>
                        <td>&nbsp;</td>
                        <?php 
                        if($_REQUEST['instrumento']=="138"){            
                            $nombre="USUARIO";
                            $apellido="ANONIMO";
                            $numdoc=rand(1,10000000);
                            ?>
                            <td>
                                <?PHP 
                                $db=writeHeaderBD();
                                $SQL_dependencia="SELECT
                                    siq_Apublicoobjetivocsv.texto        
                                    FROM siq_Apublicoobjetivocsv
                                    WHERE texto2 != ''
                                    GROUP BY siq_Apublicoobjetivocsv.texto";
                                if($Dependencia=&$db->Execute($SQL_dependencia)===false){
                                    echo 'Error En el SQL de la dependencia...<br><br>'.$SQL_dependencia;
                                    die;
                                }?>
                                Dependencia:<span style="color:red; font-size:9px">(*)</span> 
                            </td>
                            <td>&nbsp;</td>    
                            <td>
                                <select name="dependencia1" id="dependencia1" onchange="cargaAreas();">
                                    <option value="null">Seleccione:</option>
                                    <?PHP   
                                    while(!$Dependencia->EOF){
                                        #################################################
                                        ?>
                                        <option value="<?PHP echo $Dependencia->fields['texto']?>"><?PHP echo $Dependencia->fields['texto']?></option>
                                        <?PHP
                                        #################################################
                                        $Dependencia->MoveNext();
                                    } 
                                    ?>    
                                </select>
                                <input type="hidden" name="cedula" id="cedula" value="<?php echo $numdoc; ?>" onkeypress="return isNumberKey(event)">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>Area:<span style="color:red; font-size:9px">(*)</span></td>
                            <td>&nbsp;</td>
                            <td>
                                <select name="areadependencia" id="areadependencia">
                                    <option value="null">Seleccione:</option>
                                </select>
                                <input type="hidden" name="Uno_apellido" id="Uno_apellido" value="<?php echo $apellido; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>Tipo de usuario:<span style="color:red; font-size:9px">(*)</td>
                            <td>&nbsp;</td>
                            <td>
                                <?PHP 
                                //$db=writeHeaderBD();
                                $SQL_tipousuario="SELECT
                                siq_Apublicoobjetivocsv.texto3    
                                FROM siq_Apublicoobjetivocsv
                                WHERE texto3 != ''
                                GROUP BY siq_Apublicoobjetivocsv.texto3";                                        
                                if($tipousuario=&$db->Execute($SQL_tipousuario)===false){
                                    echo 'Error En el SQL de la dependencia...<br><br>'.$SQL_tipousuario;
                                    die;
                                }     
                                ?>
                                <select name="tipoencuestado" id="tipoencuestado">
                                    <option value="null">Seleccione:</option>
                                    <?PHP   
                                    while(!$tipousuario->EOF){
                                        #################################################
                                        ?>
                                        <option value="<?PHP echo $tipousuario->fields['texto3']?>"><?PHP echo $tipousuario->fields['texto3']?></option>
                                        <?PHP
                                        #################################################
                                        $tipousuario->MoveNext();
                                    } 
                                    ?>
                                </select>
                                <input type="hidden" style="width:250px;" name="Uno_nombre" id="Uno_nombre" value="<?php echo $nombre; ?>">
                            </td>
                        </tr>             
                        <?php   
                        }else{        
                            ?>
                            <td>N&deg; de Documento:<span style="color:red; font-size:9px">(*)</span></td>
                            <td>&nbsp;</td>    
                            <td>
                                <input type="text" name="cedula" id="cedula" value="" onkeypress="return isNumberKey(event)">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                Primer Apellido:<span style="color:red; font-size:9px">(*)</span>  
                            </td>
                            <td>&nbsp;</td>
                            <td>
                            <input type="text" name="Uno_apellido" id="Uno_apellido" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                Segundo Apellido:  
                            </td>
                            <td>&nbsp;</td>
                            <td>
                            <input type="text" name="Sdo_apellido" id="Sdo_apellido" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                               Primer Nombre:<span style="color:red; font-size:9px">(*)</span>  
                            </td>
                            <td>&nbsp;</td>
                            <td>
                            <input type="text" style="width:250px;" name="Uno_nombre" id="Uno_nombre" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                               Segundo Nombre:  
                            </td>
                            <td>&nbsp;</td>
                            <td>
                            <input type="text" name="Sdo_nombre" id="Sdo_nombre" value="">
                            </td>
                        </tr>
                                                                
                                <?php    
                                }
                            
                            ?>
                               
                        <?PHP 
                        if($_REQUEST['actionID']=='Graduado'){
                            $db=writeHeaderBD();// 
                            ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>Modalidad Academica:<span style="color:red; font-size:9px">(*)</span></td>
                                <td>&nbsp;</td>
                                <?PHP 
                                $SQL_M='SELECT 

                                        codigomodalidadacademica  AS id,
                                        nombremodalidadacademica  AS Nombre
                                        
                                        FROM 
                                        
                                        modalidadacademica
                                        
                                        WHERE
                                        
                                        codigomodalidadacademica IN(200,300)';
                                        
                                  if($Modalidad=&$db->Execute($SQL_M)===false){
                                    echo 'Error En el SQL de la Modalidad Academica...<br><br>'.$SQL_M;
                                    die;
                                  }     
                               ?>
                               <td>
                                    <select id="Modalidad" name="Modalidad" onchange="CargarCarrera()">
                                        <option value="0"></option>
                                        <?PHP   
                                          while(!$Modalidad->EOF){
                                            #################################################
                                            ?>
                                            <option value="<?PHP echo $Modalidad->fields['id']?>"><?PHP echo $Modalidad->fields['Nombre']?></option>
                                            <?PHP
                                            #################################################
                                            $Modalidad->MoveNext();
                                          } 
                                        ?>         
                                    </select>
                               </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>Programa Academico:<span style="color:red; font-size:9px">(*)</span></td>
                                <td>&nbsp;</td>
                                <td>
                                    <div id="Div_Carrera">
                                        <select id="Carrera" name="Carrera">
                                            <option value="0"></option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <?PHP
                        }
                        ?>
                            <?PHP 
                        if(($_REQUEST['actionID']!=='EC')&&($_REQUEST['instrumento']!="138")){
                        ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                Correo:<?PHP if($_REQUEST['actionID']=='Externo' || $_REQUEST['actionID']=='PlanDocente'){ echo '<span style="color:red; font-size:9px">(*)</span> '; }?>
                            </td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="text" style="width:250px;" name="correo" id="correo" value="">
                            </td>
                        </tr>
                         <?PHP }
                        if($_REQUEST['actionID']=='Externo'){
                            ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    Tel&eacute;fono:<?php if($_REQUEST['IDIn']==53){ echo '<span style="color:red; font-size:9px">(*)</span>';}?>
                                </td>
                                <td>&nbsp;</td>
                                   <td><input type="text" style="width:250px;" name="telefono" id="telefono" value=""></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    Colegio:
                                </td>
                                <td>&nbsp;</td>
                                   <td>
                                        <input type="text" id="idinstitucioneducativa1" name="idinstitucioneducativa1" value="" />
                                        <input type="hidden" id="idinstitucioneducativa" name="idinstitucioneducativa" value="" />
                                   </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    Si su colegio no esta en la lista Escriba cual:
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <input type="text" style="width:250px;" name="colegio" id="colegio" value="">
                                </td>

                            </tr>
                            <?php
                          }
                        ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">Ingrese el contenido de la imagen<span style="color:red; font-size:9px">(*)</span></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><img src="captcha.php"/></td>
                            <td>&nbsp;</td>
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
                                if($_REQUEST['IDIn']){
                                ?>
                                <td>&nbsp;<input type="hidden" id="IDIn" name="IDIn" value="<?PHP echo $_REQUEST['IDIn']?>" /></td>
                                <?PHP
                                    
                               }
                            ?>

                                <td colspan="3" align="center"><input type="submit"  value="Ingresar" id="submit" onclick="return validar(this);"  style="cursor:pointer;line-height: 0;padding: 0 3px;" /><!--button type="submit"--></td>
                        </tr>
                    </table>
          </fieldset>
               <div style="height:1px; width:100%; clear:both;"></div>
       </div>
    
<?php    writeFooter();
        ?>    