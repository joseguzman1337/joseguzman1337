<?php
   include("../templates/templateObservatorio.php");
   $db =writeHeader("Resultados<br>SaberPro",true,"Saber Pro",1,'Saber Pro Gestion de resultados nacionales');
   include("funciones.php");
    $fun = new Observatorio();
   
   $roles=$fun->roles_permi($db,$_SESSION['MM_Username'],'Saber Pro Gestion de resultados nacionales');
   
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
   $anioI=  date('Y')-10;
   ?>
<script>

    
    function Buscar(){
        var periodo=jQuery("select[name='codigoperiodo']").val();        
        var tipo=2;
           // alert('aca');
           $('#result').html('<blink>Cargando...</blink>');
            $.ajax({//Ajax
                      type: 'POST',
                      url: 'generaestudiantessaberpro.php',
                      async: false,
                      //dataType: 'json',
                      data:({periodo:periodo, tipo:tipo }),
                     error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                     success:function(data){
                                    $('#result').html(data);
               }
            }); //AJAX   
        
    }
    $(document).ready(function(){
    	// Smart Tab
  		$('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'vSlide'});
	});
        
</script>
 <form action="ficheroExcel.php" method="post" id="form_test">
     <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
     <input type="hidden" id="tipo" name="tipo" value="2" />
     <input type="hidden" id="tipo2" name="tipo2" value="<?php echo $tipo2 ?>" />
 </form>
        <div id="container" style="margin-left: 70px; ">
           <div id="tabs">
            <ul>    
            <li><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Criterios<br />Institucionales</span></a></li>
            </ul>
            <div id="tabs-1">
                <table border="0" class="CSSTableGenerator">
                    <tr>
                        <td><label class="titulo_label"><b>Periodo:</b></label></td>
                        <td> 
                        <select name="codigoperiodo" id="codigoperiodo">
                            <option value=''>-Seleccione-</option>
				<?php
				for($anio=(date("Y")); $anioI<=$anio; $anio--) {
                                        echo "<option value=".$anio.">".$anio."</option>";
				}
				?>
			</select> 
                        </td>
                     
                    </tr>
                </table>
            </div>
           </div>
           
            <button type="button" id="buscar" name="buscar" onclick="Buscar()" class="submit">Buscar</button>
             &nbsp;&nbsp;
             <?php if ($roles['editar']==1){?>
             <a href="form_nacional_saberpro.php" class="submit" tabindex="4">Nuevo</a>
              &nbsp;&nbsp;
             <?php } ?>
            <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>

            <div id="result" style="width: 1030px;">
                
            </div>
            </div>
    
<?php   

writeFooter();
        ?>  