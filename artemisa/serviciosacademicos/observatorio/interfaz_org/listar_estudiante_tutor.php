<?php
   include("../templates/templateObservatorio.php");
   
   $db =writeHeader("Estudiante <br> Tutor",true,"PAE",1);
   /* include("./menu.php");
    writeMenu(0);*/
   $tipo=$_REQUEST['tipo'];
    ?>
<script>

  
      $(document).ready(function(){    
               jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera2();});
               jQuery("select[name='codigofacultad']").change(function(){displayFacultad();});
      
    });
  
  
    
    function Buscar(){
        var modalidad=jQuery("select[name='codigomodalidadacademica']").val();
        var facultad=jQuery("select[name='codigofacultad']").val();
        var tipo=$("#tipo").val();
        var nestudiante=$("#documento").val();
        var periodo=jQuery("select[name='codigoperiodo']").val();
        var semestre = ""; var nivel= ""; var causas_asis= ""; var causas_fin= ""; var causas_psico= ""; var otras_cau= ""; var carrera="";
        $('input[name="semestre_1[]"]:checked').each(function() { semestre += "'"+$(this).val() + "',"; });
        semestre = semestre.substring(0, semestre.length-1);
        $('input[name="nivel_1[]"]:checked').each(function() { nivel += "'"+$(this).val() + "',";  });

        if (modalidad==0){
            alert("Debe escoger minimo la modalidad academica");
                 $('#codigomodalidadacademica').css('border-color','#F00');
                 $('#codigomodalidadacademica').effect("pulsate", {times:3}, 500);
                 $("#codigomodalidadacademica").focus();
        }else{    
           $('#result').html('<blink>Cargando...</blink>');
            $.ajax({//Ajax
                      type: 'POST',
                      url: 'buscar_estudiantes_tutor.php',
                      async: false,
                      //dataType: 'json',
                      data:({periodo:periodo, modalidad:modalidad, facultad:facultad,
                             nestudiante:nestudiante, semestre:semestre,
                             carrera:carrera, tipo:tipo}),
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
                    <tr>
                        <td><label class="titulo_label"><b>Modalidas Academica:</b></label></td>
                        <td><?php
                                        $query_programa = "SELECT ' ' as nombremodalidadacademica, '0' as codigomodalidadacademica UNION SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],false,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                 ?>
                        </td>
                        <td><label class="titulo_label"><b>Facultad:</b></label></td>
                        <td><?php
                                        $query_programa = "SELECT ' ' as nombrefacultad, '0' as codigofacultad UNION SELECT nombrefacultad, codigofacultad FROM facultad";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigofacultad',$data['codigofacultad'],false,false,1,' id=codigofacultad  style="width:150px;"');
                                 ?></td>   
                    </tr>
                    <tr>
                        <td><label class="titulo_label"><b>Programa:</b></label></td>
                        <td colspan="3"><div  id="carreraAjax" style="display: none; overflow-x: hidden; overflow-y: scroll; width: 100%; height: 100px;"></div></td>
                    </tr>
                    <tr>
                        <td><label class="titulo_label"><b>Semestre:</b></label>
                            <br>
                            <a href="javascript:void(0)" onclick="checkTodos('ck')">Todos</a>/<a href="javascript:void(0)" onclick="checkNinguno('ck')">Ninguno</a>
                        </td>
                        <td><div style="overflow-x: hidden; overflow-y: scroll; width: 100%; height: 100px;">
                            <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
                                <?php
                                    for ($i=1;$i<=12;$i++){
                                        ?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><input type="checkbox" id="semestre_1" class="ck" name="semestre_1[]" value="<?php echo  $i ?>"   /></td>
                                        </tr>
                                       <?php
                                    }
                                ?>
                            </table>
                            </div>
                        </td>  
                        <td><label class="titulo_label"><b>Numero Documuento Estudiante:</b></label></td>
                        <td><input type="text" name="documento" id="documento" /></td>
                    </tr>
                </table>
            </div>
           </div>
            <br>
            <button type="button" id="buscar" name="buscar" onclick="Buscar()" class="submit">Buscar</button>
            &nbsp;
            <a href="form_estudiante_tutor.php" class="submit" tabindex="4">Nuevo</a>
            &nbsp;&nbsp;
            <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
            <div id="result" style="width: 1030px;">
                
            </div>
            </div>
    
<?php    
writeFooter();
        ?>  