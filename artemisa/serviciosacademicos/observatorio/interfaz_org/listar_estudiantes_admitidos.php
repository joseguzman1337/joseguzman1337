<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

   include("../templates/templateObservatorio.php");
   $db =writeHeader("Estudantes<br>Entrevista",true,"Amidiones",1);
   /* include("./menu.php");
    writeMenu(0);*/
   $tipo=$_REQUEST['tipo'];
   //print_r($_SESSION);
   
      $entity1 = new ManagerEntity("usuario");
    $entity1->prefix = "";
    $entity1->sql_where = "usuario = '".$_SESSION['MM_Username']."'";
  // $entity1->debug = true;
    $dataD = $entity1->getData();
    $n_doc=$dataD[0]['numerodocumento']; 
    
   $entity2 = new ManagerEntity("usuarios_roles");
   $entity2 ->sql_where = "cedula_usuario= '".$n_doc."'";
  // $entity2->debug = true;
   $dataD2 = $entity2->getData();
   $total=  count($dataD2);
   $modulo=$dataD2[0]['modulo'];
   
   if ($total>0 && $modulo=='Entrevistador'){
    ?>

<script>

  
      $(document).ready(function(){    
               jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera2();});
              // jQuery("select[name='codigofacultad']").change(function(){displayFacultad();});
      
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
    
      function displayFacultad(){
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
    }
    
    
    function Buscar(){
        var modalidad=jQuery("select[name='codigomodalidadacademica']").val();
        var facultad=jQuery("select[name='codigofacultad']").val();
        var tipo=$("#tipo").val();
        var nestudiante=$("#documento").val();
        var periodo=jQuery("select[name='codigoperiodo']").val();
        var carrera=jQuery("select[name='codigocarrera']").val();
        
       
        if (modalidad==0 && nestudiante==''){
            alert("Debe escoger minimo la modalidad academica");
                 $('#codigomodalidadacademica').css('border-color','#F00');
                 $('#codigomodalidadacademica').effect("pulsate", {times:3}, 500);
                 $("#codigomodalidadacademica").focus();
        }else if (periodo=='' && nestudiante==''){
            alert("Debe escoger el periodo");
                 $('#codigoperiodo').css('border-color','#F00');
                 $('#codigoperiodo').effect("pulsate", {times:3}, 500);
                 $("#codigoperiodo").focus();
        }else{    
           $('#result').html('<blink>Cargando...</blink>');
            $.ajax({//Ajax
                      type: 'POST',
                      url: 'generaadmitidos.php',
                      async: false,
                      //dataType: 'json',
                      data:({periodo:periodo, modalidad:modalidad, facultad:facultad,
                             nestudiante:nestudiante, carrera:carrera, Utipo:'entrevistador', tipo:tipo}),
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
     <input type="hidden" id="tipo" name="tipo" value="<?php echo $_REQUEST['tipo']?>" />
 </form>
        <div id="container" style="margin-left: 70px; ">
           <div id="tabs">
            <ul>    
            <li><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Criterios<br />Institucionales</span></a></li>
            </ul>
            <div id="tabs-1">
                <table border="0" class="CSSTableGenerator">
                    <?PHP
                       if ($_SESSION['nombrefacultad']=='GENERAL'){
                    ?>
                    <tr>
                       <td><label class="titulo_label"><b>Modalidas Academica:</b></label></td>
                        <td><?php
                                        $query_programa = "SELECT ' ' as nombremodalidadacademica, '0' as codigomodalidadacademica UNION SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],false,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                 ?>
                        </td>
                        <td><!--<label class="titulo_label"><b>Facultad:</b></label>--></td>
                        <td><!--<?php
                                        $query_programa = "SELECT ' ' as nombrefacultad, '0' as codigofacultad UNION SELECT nombrefacultad, codigofacultad FROM facultad";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigofacultad',$data['codigofacultad'],false,false,1,' id=codigofacultad  style="width:150px;"');
                                 ?>--></td>   
                    </tr>
                    <tr>
                        <td><label class="titulo_label"><b>Programa:</b></label></td>
                        <td colspan="3"><div  id="carreraAjax" style="display: none;"></div></td>
                    </tr>
                    <?PHP
                        }else {
                           $query_carr = "Select d.numerodocumento, nombredocente, apellidodocente, d.iddocente,
                                f.nombrefacultad, f.codigofacultad, c.nombrecarrera, c.codigomodalidadacademica
                                from docente as d
                                inner join grupo as g on (g.numerodocumento=d.numerodocumento and codigogrupo<>0) 
                                INNER JOIN materia as m on (g.codigomateria=m.codigomateria)
                                INNER JOIN carrera as c on (m.codigocarrera=c.codigocarrera) 
                                INNER JOIN facultad as f  ON (f.codigofacultad=c.codigofacultad)
                                where d.codigoestado=100 and d.numerodocumento='".$n_doc."'
                                Group By iddocente";
                         // echo $query_carr.'<br>';
                           $reg_fal =$db->Execute($query_carr);
                           $F_data= $reg_fal->GetArray();
                          
                           
                           $query_carrera = "SELECT nombrecarrera, codigocarrera 
                               FROM carrera 
                               where codigofacultad='".$F_data[0]['codigofacultad']."' and codigomodalidadacademica='".$F_data[0]['codigomodalidadacademica']."' ";
                          // echo $query_carrera;
                           $reg_programa =$db->Execute($query_carrera);
                    ?>
                    <tr>
                        <td><label class="titulo_label"><b>Programa:</b></label></td>
                        <td colspan="3"><?php echo $reg_programa->GetMenu2('codigocarrera','',false,false,1,' id=codigocarrera  style="width:150px;"');?></td>
                    </tr>
                    <?php } ?>
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
           
            <button type="button" id="buscar" name="buscar" onclick="Buscar()" class="submit">Buscar</button>
            &nbsp;
            <div id="result" style="width: 1030px;">
                
            </div>
            </div>
    
<?php    
}else{
       echo "Este Usuario no tiene rol de Entrevistador";
   }
writeFooter();
        ?>  