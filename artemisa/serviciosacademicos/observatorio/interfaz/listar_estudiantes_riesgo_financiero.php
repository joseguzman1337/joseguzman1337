<?php
   include("../templates/templateObservatorio.php");
   $db =writeHeader("Financiaci&oacute;n <br>Estudiantes",true,"PAE",1);
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
  
    
    
    function Buscar(){
        var modalidad=jQuery("select[name='codigomodalidadacademica']").val();
        var facultad=jQuery("select[name='codigofacultad']").val();
        var tipo=$("#tipo").val();
        var tipo2=$("#tipo2").val();
        var nestudiante=$("#documento").val();
        var periodo=jQuery("select[name='codigoperiodo']").val();
        var carrera=jQuery("select[name='codigocarrera']").val();
        var idtipoestudianterecursofinanciero=jQuery("select[name='idtipoestudianterecursofinanciero']").val();
        
       
        if (modalidad==0 && nestudiante==''){
            alert("Debe escoger la modalidad academica");
                 $('#codigomodalidadacademica').css('border-color','#F00');
                 $('#codigomodalidadacademica').effect("pulsate", {times:3}, 500);
                 $("#codigomodalidadacademica").focus();
        }else if (idtipoestudianterecursofinanciero==''){
            alert("Debe escoger el tipo de financiemiento");
                 $('#idtipoestudianterecursofinancieroa').css('border-color','#F00');
                 $('#idtipoestudianterecursofinanciero').effect("pulsate", {times:3}, 500);
                 $("#idtipoestudianterecursofinanciero").focus();
        }else{    
           // alert('aca');
           $('#result').html('<blink>Cargando...</blink>');
            $.ajax({//Ajax
                      type: 'POST',
                      url: 'generaalertas.php',
                      async: false,
                      //dataType: 'json',
                      data:({periodo:periodo, modalidad:modalidad, facultad:facultad,idtipoestudianterecursofinanciero:idtipoestudianterecursofinanciero,
                             nestudiante:nestudiante, carrera:carrera, tipo:tipo, vtipo:'1' }),
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
        
</script>
 <form action="ficheroExcel.php" method="post" id="form_test">
     <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
     <input type="hidden" id="tipo" name="tipo" value="por" />
     <input type="hidden" id="tipo2" name="tipo2" value="<?php echo $tipo2 ?>" />
 </form>
<div id="container" style="margin-left: 70px; ">
           <div id="tabs">
               <ul>    
            <li><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Criterios<br />Institucionales</span></a></li>
            <li><div class="stepNumber">2</div><a href="#tabs-2"><span class="stepDesc">Criterios<br />Alertas</span></a></li>
            </ul>
            <div id="tabs-1">
                <table border="0" class="CSSTableGenerator">

                    <tr>
                        <td><label class="titulo_label"><b>Modalidad Acad&eacute;mica:</b></label></td>
                        <td><?php
                                        $query_programa = "SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],true,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                 ?>
                        </td>
                         <tr>
                            <td><label class="titulo_label"><b>Programa:</b></label></td>
                            <td colspan="3"><div  id="carreraAjax" style="display: none;"></div></td>
                        </tr> 
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="3"><br></td>
                        </tr> 
                </table>
            </div>
            <div id="tabs-2">
                <table border="0" class="CSSTableGenerator">

                    <tr>
                       <td><label class="titulo_label"><b>Recurso Financiero:</b></label></td>
                        <td  colspan="3"><?php
                                        $query_finan = "SELECT nombretipoestudianterecursofinanciero, idtipoestudianterecursofinanciero FROM tipoestudianterecursofinanciero where idtipoestudianterecursofinanciero in (3,4,5,7,9,10,11)";
                                        $reg_finan =$db->Execute($query_finan);
                                        echo $reg_finan->GetMenu2('idtipoestudianterecursofinanciero',$data['idtipoestudianterecursofinanciero'],true,false,1,' id=idtipoestudianterecursofinanciero  style="width:150px;"');
                                 ?>
                        </td>
                    </tr>


                    <tr>
                        <td><label class="titulo_label"><b>Periodo:</b></label></td>
                        <td><?php
                                             $query_tipo_periodo = "SELECT nombreperiodo, codigoperiodo FROM periodo order by codigoperiodo desc";
                                             $reg_tipoper = $db->Execute ($query_tipo_periodo);
                                             echo $reg_tipoper->GetMenu2('codigoperiodo',$data['codigoperiodo'],true,false,1,' tabindex="17" id="codigoperiodo" ');
                                        ?>
                        </td>
                        <td><label class="titulo_label"><b>Numero Documuento Estudiante:</b></label></td>
                        <td><input type="text" name="documento" id="documento" /></td>
                        
                    </tr>
                </table>
            </div>
           </div>
    <br>
            <button type="button" id="buscar" name="buscar" onclick="Buscar()" class="submit">Buscar</button>
 &nbsp;&nbsp;
            <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
            <div id="result" style="width: 1030px;">
                
            </div>
            </div>
    
<?php   

writeFooter();
        ?>  