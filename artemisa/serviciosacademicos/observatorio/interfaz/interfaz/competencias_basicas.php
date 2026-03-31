<?php

   require("../templates/templateObservatorio.php");
   $db =writeHeader("Reporte de<br>Competencias B&aacute;sicas",true,"SALAS DE APRENDIZAJE",1);
   /* include("./menu.php");
    writeMenu(0);*/
   $tipo=$_REQUEST['tipo'];
   $tipo2=$_REQUEST['tipo2'];
   
   //print_r($_SESSION);
   
   $entity1 = new ManagerEntity("usuario");
   
    $entity1->prefix = "";
    $entity1->sql_where = "usuario = '".$_SESSION['MM_Username']."'";
   // $entity1->debug = true;
    $dataD = $entity1->getData();
    $n_doc=$dataD[0]['numerodocumento']; 
    
   ?>
   <meta http-equiv="X-UA-Compatible" content="IE=9" />
   <head>
   	<link rel="stylesheet" href="css/jquery.nice-file-input.min.css" type="text/css" />
   </head>
<script>

  
      $(document).ready(function(){    
             jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera2();});
                
    
    });
    $(document).ready(function(){    
    	$(".nicefile").niceFileInput({
				  'width'         : '400', //width of button - minimum 150
				  'height'		  : '30',  //height of text
				  'btnText'       : 'Examinar', //text of the button     
				  'btnWidth'	  : '100' ,  // width of button
				  'margin'        : '14',	// gap between textbox and button - minimum 14 		  
		});			
	});
	
	 
    function Buscar(){
        var modalidad=jQuery("select[name='codigomodalidadacademica']").val();
        var nestudiante=$("#documento").val();
        var periodo=jQuery("select[name='codigoperiodo']").val();
      //  var carrera=jQuery("select[name='codigocarrera']").val();
        var materia=jQuery("select[name='codigomateria']").val();
        var carrera="";
        $('input[name="Carrera_1[]"]:checked').each(function() { carrera+= +$(this).val() + ",";});
               carrera= carrera.substring(0, carrera.length-1);
        if (modalidad==0){
            alert("Debe escoger la modalidad academica");
                 $('#codigomodalidadacademica').css('border-color','#F00');
                 $('#codigomodalidadacademica').effect("pulsate", {times:3}, 500);
                 $("#codigomodalidadacademica").focus();
        }else if (periodo==''){
            alert("Debe escoger el periodo");
                 $('#codigoperiodo').css('border-color','#F00');
                 $('#codigoperiodo').effect("pulsate", {times:3}, 500);
                 $("#codigoperiodo").focus();
        }else{    
           // alert('aca');
           $('#result').html('<blink>Cargando...</blink>');
            $.ajax({//Ajax
                      type: 'POST',
                      url: 'buscar_competencias.php',
                      async: false,
                      //dataType: 'json',
                      data:({periodo:periodo, modalidad:modalidad, 
                             nestudiante:nestudiante, carrera:carrera, tipo:'1' }),
                     error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                     success:function(data){
                                    $('#result').html(data);
               }
            }); //AJAX   
        }
    }
    
    function cargueMasivo(){
    	var inputFileImage = document.getElementById("cargueMasivoC");
    	var file = inputFileImage.files[0];
    	var data = new FormData();
    	data.append("archivo",file);
    	$.ajax({//Ajax
                  type: 'POST',
                  url: 'servicio/cargueMasivo.php',
                  contentType:false,
				  data:data,
				  processData:false,
				  cache:false,
				  success: function( data ){
                     alert( data );
                     location.reload();  
                  }
        }); //AJAX  
    }
        
</script>
<style type="text/css">
	#btnCargar{
		border-radius: 8px;
		z-index: 99;
	}
</style>
<script src="js/jquery.nice-file-input.min.js"></script> 
 <form action="ficheroExcel.php" method="post" id="form_test">
     <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
     <input type="hidden" id="tipo" name="tipo" value="por" />
     <input type="hidden" id="tipo2" name="tipo2" value="<?php echo $tipo2 ?>" />
 </form>
<div id="container" style="margin-left: 70px; ">
      
                <table border="0" class="CSSTableGenerator">

                    <tr>
                        <td><label class="titulo_label"><b>Modalidad Acad&eacute;mica:</b></label></td>
                        <td><?php
                                        $query_programa = "SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],true,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                 ?>
                        </td>
                    </tr>
                    <tr>
                        <?php if($prog==false){ ?>
                        <td><label class="titulo_label"><b>Programa:</b></label></td>
                        <td colspan="3"><div  id="carreraAjax" style="display: none; overflow-x: hidden; overflow-y: scroll; width: 100%; height: 100px;"></div></td>
                        <?php } ?>
                    </tr>
                         <!--<tr>
                            <td><label class="titulo_label"><b>Programa:</b></label></td>
                            <td colspan="3"><div  id="carreraAjax" style="display: none;"></div></td>
                        </tr>--> 
                    <tr>
                        <td><label class="titulo_label"><b>Periodo:</b></label></td>
                        <td><?php
                                             $query_tipo_periodo = "SELECT nombreperiodo, codigoperiodo FROM periodo order by codigoperiodo desc";
                                             $reg_tipoper = $db->Execute ($query_tipo_periodo);
                                             echo $reg_tipoper->GetMenu2('codigoperiodo',$data['codigoperiodo'],true,false,1,' tabindex="17" id="codigoperiodo" ');
                                        ?>
                        </td>
                    </tr>
                </table>
           
    <br>
            <button type="button" id="buscar" name="buscar" onclick="Buscar()" class="submit">Buscar</button>
 &nbsp;&nbsp;
            <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
            &nbsp;&nbsp;
            
            <div style="margin-top: 20px; ">
            	<form id="formCargueMasivo" method="post" enctype="multipart/form-data">
					<input type="file" class="nicefile" id="cargueMasivoC" />&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" id="btnCargar" name="btnCargar" onclick="cargueMasivo()" class="submit">Cargar</button>
					
				</form>
			</div>
            <!--<input type="submit">-->
            <!--<button type="file" id="cargueMasivoC" name="cargueMasivoC" >Cargar Archivo</button>-->
            <div id="result" style="width: 1030px;">
                
            </div>
            </div>
    
<?php   

writeFooter();
        ?>  