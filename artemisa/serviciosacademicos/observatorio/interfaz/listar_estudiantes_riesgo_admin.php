<?php
include("../templates/templateObservatorio.php");
$db =writeHeader("Alertas  <br> Tempranas",true,"PAE",1,'Registro de riesgo');
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
   
   $entity2 = new ManagerEntity("usuarios_roles");
   $entity2 ->sql_where = "cedula_usuario= '".$n_doc."'";
   //$entity2->debug = true;
   $dataD2 = $entity2->getData();
   $total=  count($dataD2);
   $modulo=$dataD2[0]['modulo'];
   ?>
   <script>

   
   $(document).ready(function(){    
     jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera2();});
     
   });
   
   function displayCarrera2(){
    var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
    var optionValue = jQuery("select[name='codigomodalidadacademica']").val();
    var optionFacultad = '';
    jQuery("#carreraAjax")
    .html(ajaxLoader)
    .load('generacarrera.php', {id: optionValue, opt:'sin_ind', status: 1, idfacultad:optionFacultad }, function(response){					
      if(response) {
        jQuery("#carreraAjax").css('display', '');                         
      } else {                    
        jQuery("#carreraAjax").css('display', 'none');                     
      }
    });     
  }
  
     /* function displayFacultad(){
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionFacultad = jQuery("select[name='codigofacultad']").val();
        var optionValue = jQuery("select[name='codigomodalidadacademica']").val();
        jQuery("#carreraAjax")
            .html(ajaxLoader)
            .load('generaadmitidos.php', {id: optionValue, opt:'sin_ind', status: 1, idfacultad:optionFacultad  }, function(response){					
            if(response) {
                jQuery("#carreraAjax").css('display', '');                        
            } else {                    
                jQuery("#carreraAjax").css('display', 'none');                    
            }
        });     
}*/


function Buscar(){
  var modalidad=jQuery("select[name='codigomodalidadacademica']").val();
  var facultad=jQuery("select[name='codigofacultad']").val();
  var tipo=$("#tipo").val();
  var tipo2=$("#tipo2").val();
  var nestudiante=$("#documento").val();
  var periodo=jQuery("select[name='codigoperiodo']").val();
  var carrera=jQuery("select[name='codigocarrera']").val();
  
  
  if (modalidad==0 && nestudiante==''){
    alert("Debe escoger la modalidad academica");
    $('#codigomodalidadacademica').css('border-color','#F00');
    $('#codigomodalidadacademica').effect("pulsate", {times:3}, 500);
    $("#codigomodalidadacademica").focus();
  }else if (periodo==0 && nestudiante==''){
    alert("Debe escoger el periodo");
    $('#codigoperiodo').css('border-color','#F00');
    $('#codigoperiodo').effect("pulsate", {times:3}, 500);
    $("#codigoperiodo").focus();
  }else{    
           // alert('aca');
           $('#result').html('<blink>Cargando...</blink>');
            $.ajax({//Ajax
              type: 'POST',
              url: 'alertas_tempranas_riesgo.php',
              async: false,
                      //dataType: 'json',
                      data:({periodo:periodo, modalidad:modalidad, facultad:facultad,
                       nestudiante:nestudiante, carrera:carrera, tipo:tipo, Utipo:'', tipo2:tipo2, vtipo:'' }),
                      error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                      success:function(data){
                        $('#result').html(data);
                      }
            }); //AJAX   
          }
        }
        $(document).ready(function(){
    	// Smart Tab
      $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'vSlide'});
    });
        

        $(document).ready(function(){
          $('#tabs').smartTab({
            selected: 0,
            autoHeight:true,
            autoProgress: false,
            stopOnFocus:true,
            transitionEffect:'vSlide'})
        });   
        </script>
        <form action="ficheroExcel.php" method="post" id="form_test">
         <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
         <input type="hidden" id="tipo" name="tipo" value="por" />
         <input type="hidden" id="tipo2" name="tipo2" value="<?php echo $tipo2 ?>" />
       </form>
       <div id="container" style="margin-left: 70px; ">
         <div id="tabs">
          <ul>    
            <li>
              <div class="stepNumber">Aquí usted podrá encontrar la información correspondiente a estudiantes con necesidades de apoyo detectados en el proceso de admisión, los cuales son priorizados para seguimiento desde el Programa de Apoyo al Estudiante (PAE)</div><a href="#tabs-1"><span class="stepDesc"></span></a></li>
              </ul>
              <!--  <input  name="texto"type="text"   width="160px" height="50px" class="titulo_label" style="background-color:#F90"  value="Criterios " disabled="disabled"   /> <br /><input  name="texto"type="text"  width="160px" height="50px" class="titulo_label" style="background-color:#F90"  value=" Institucionales" /> -->
              <div id="tabs-1">
                <table  bgcolor="#ea8511" >
                  <tr>
                    <td style="font-size:12px ; color:#FFF ; padding-top:6px ; padding-left:28px " >      Criterios                 </td>
                  </tr>
                  <tr>
                    <td style="font-size:12px ; color:#FFF  ;padding-bottom:6px ; padding-left:28px ;padding-top:0" width="180px" >      Institucionales            </td>
                  </tr>
                </table>
                <table border="0" class="CSSTableGenerator">

                  <tr>
                    <td><label class="titulo_label"><b>Modalidad Acad&eacute;mica:</b></label></td>
                    <td colspan="3"><?php
                    $query_programa = "SELECT ' ' as nombremodalidadacademica, '0' as codigomodalidadacademica UNION SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica as m WHERE  m.codigoestado = 100 
AND    m.codigomodalidadacademica NOT IN(100, 700, 500, 501, 502, 503, 506, 507, 400);";
                    $reg_programa =$db->Execute($query_programa);
                    echo $reg_programa->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],false,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                    ?>
                  </td>
                  
                        <!--<?php
                                        $query_programa = "SELECT ' ' as nombrefacultad, '0' as codigofacultad UNION SELECT nombrefacultad, codigofacultad FROM facultad";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigofacultad',$data['codigofacultad'],false,false,1,' id=codigofacultad  style="width:150px;"');
                                        ?>-->  
                                      </tr>
                                      <tr>
                                        <td><label class="titulo_label"><b>Programa:</b></label></td>
                                        <td colspan="3"><div  id="carreraAjax" style="display: none;"></div></td>
                                      </tr>

                                      <tr>
                                        <td><label class="titulo_label"><b>Periodo:</b></label></td>
                                        <td colspan="3"><?php
                                        $query_tipo_periodo = "SELECT nombreperiodo, codigoperiodo FROM periodo order by codigoperiodo desc";
                                        $reg_tipoper = $db->Execute ($query_tipo_periodo);
                                        echo $reg_tipoper->GetMenu2('codigoperiodo',$data['codigoperiodo'],true,false,1,' tabindex="17" id="codigoperiodo" ');
                                        ?>
                                      </td>
                        <!--td><label class="titulo_label"><b>N&uacute;mero Documento Estudiante:</b></label></td>
                        <td><input type="text" name="documento" id="documento"  width="170px"/></td-->
                          
                        </tr>
                      </table>
                    </div>
                  </div>
                  <br>
                  <button type="button" id="buscar" name="buscar" onclick="Buscar()" class="submit">Buscar</button>
                  &nbsp;&nbsp;
				  <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
                  <!--a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a-->
                  
                </div>
                <div id="result" style="width: 1030px;">
                  
                </div>

                
                
                <?php   
                mysql_close($sala);	

                ?>  