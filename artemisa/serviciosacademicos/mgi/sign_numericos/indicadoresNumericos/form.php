<?php

 // include("../../templates/templateAutoevaluacion.php");
  // $db =writeHeader("Respuestas",true,"Autoevaluacion");
   
function writeForm($edit, $id="", $db) {
    $data = array();
    $action = "save";
     $utils = new Utils_numericos();
     
      //var_dump("Insertar"+$id);
    if($edit){
        $action = "update";
        if($id!=""){  
           // var_dump($id);
            $data = $utils->getDataEntity("funcionTipo1", $id); 
            //$data =$data['valor'];
         // var_dump($data);
          
            
           // echo ($db);
           // var_dump($db);
           //die();
        
            $con = $db;
            //echo ($con);
            if (!$con)
            {
                echo("conection fail");
                die('Could not connect: ' . mysql_error());
              }else{
                  
                  mysql_select_db("sala", $con);
                  $result = mysql_query('SELECT nombre FROM sala.siq_infoIndicador where codigoestado = 100 and idsiq_infoIndicador = '.$datas =$data['tipo']);
                  
                  while($row = mysql_fetch_array($result))
                        {
                   //  echo $row['nombre'] . " " . $row['nombre'];
                     $tipovalor = $row['nombre'];
                    echo "<br />";
                         }
                          //var_dump($tipovalor);
                          //die();
                          
                          $result2 = mysql_query('SELECT nombre FROM sala.siq_periodo where codigoestado = 100 and idsiq_periodo = '.$datas =$data['idPeriodo']);
                  
                  while($row2 = mysql_fetch_array($result2))
                        {
                   //  echo $row['nombre'] . " " . $row['nombre'];
                     $periodovalor = $row2['nombre'];
                    echo "<br />";
                         }
                        //  var_dump($periodovalor);
                         
                         $result3 = mysql_query('SELECT a.idIndicador FROM sala.siq_funcionIndicadores as a
                                                inner join sala.siq_funcionTipo1 as b on a.idsiq_funcionIndicadores =  b.funcionIndicadores
                                                where b.idsiq_funciontipo1 = '.$id);
         
                  while($row3 = mysql_fetch_array($result3))
                        {
                   //  echo $row['nombre'] . " " . $row['nombre'];
                     $indicador = $row3['idIndicador'];
                    echo "<br />";
                         }
                         // var_dump($indicador); 
                  
                  /*
                  $sql="SELECT nombre FROM sala.siq_infoIndicador where codigoestado = 100 and idsiq_infoIndicador = 1";
                    if (!mysql_query($sql,$con))
                         {
                            die('Error: ' . mysql_error());
                        }
                       // var_dump($sql);
                        echo "Consultado";
                       // mysql_close($con);
                    */
                }
        }   
    }else{
          // $entitys = new ManagerEntity("tipoIndicador");
         //  $tipo = $entitys->getData();
         //  $tipo =$tipo[0];
           //var_dump($tipo);
        
    //$infoIndicador = $utils->getActives($db, "nombre,idsiq_infoIndicador", "infoIndicador");
    //$periodo = $utils->getActives($db, "nombre,idsiq_periodo", "periodo");
            
      //  var_dump($id);
    
            //echo ($db);
           // var_dump($db);
           // die();
    $SQL_info='SELECT idsiq_infoIndicador,nombre FROM siq_infoIndicador WHERE codigoestado=100';

           if($infoIndicador=&$db->Execute($SQL_info)===false){
                echo 'Error en Información Indicador.. <br>'.$SQL_info;
		     die;
	}
    //var_dump($SQL_info);
        
    $SQL_Per='SELECT idsiq_periodo,nombre FROM siq_periodo WHERE codigoestado=100';

           if($Periodo=&$db->Execute($SQL_Per)===false){
                echo 'Error en Informacion Periodo..<br>'.$SQL_Per;
		     die;
	}  
        
        
     $SQL_indicador='SELECT idIndicador  FROM  sala.siq_funcionIndicadores where idsiq_funcionIndicadores='.$id;

           if($indirespuesta=&$db->Execute($SQL_indicador)===false){
                echo 'Error en Información Indicador.. <br>'.$SQL_indicador;
		     die;
	}

     while(!$indirespuesta->EOF){
                        $indicador =$indirespuesta->fields['idIndicador'];
                        //var_dump($indicador);
			$indirespuesta->MoveNext();
			}
                        
     $SQL_validarPeriodo='SELECT idPeriodo FROM siq_funcionTipo1 where funcionIndicadores ='.$id;

           if($validarperiodo=&$db->Execute($SQL_validarPeriodo)===false){
                echo 'Error en Información Periodos Repetidos.. <br>'.$SQL_validarPeriodo;
		     die;
	       }
$cca = false;
     while(!$validarperiodo->EOF){
                        $consultaperiodos =$validarperiodo->fields['idPeriodo'];
                        /**
                         *  $a[] = contiene enteros
                         *  $consultaperiodos contiene strings
                         */
                         $a[] = $consultaperiodos;
                        // var_dump($consultaperiodos);
			$validarperiodo->MoveNext();
                        $cca = true;
			}
                        
                        if ($cca){
                        }else {
                             $a[] = 0;
                             $cca = true;
                        }
                        
   }        
             
?>
<div id="form"> 
    <div id="msg-error"></div>
    
    <form action="save.php" method="post" id="form_test" >
            <input type="hidden" name="entity" value="funcionTipo1" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="idsiq_funcionTipo1" value="'.$id.'">';
            }
             if(!$edit&&$id!=""){
                echo '<input type="hidden" name="funcionIndicadores" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Valores: </legend>
                
                <label for="idsiq_infoIndicador" class="grid-2-12">Tipo Indicador: <span class="mandatory">(*)</span></label>
                <?php if($edit){ ?>
               
                 <tr>  
                    <td class="Border">
                     <select id="idsiq_infoIndicador" name="tipo" style="width: auto" disabled="true" >
                               <option value="<?php if(!empty($edit)){ echo $data['tipo']; } ?>"><?php if(!empty($edit)){ echo $tipovalor; } ?></option>
                     </select>
                    </td>
                 </tr>
                 
                     <?php } else { ?>
              
                 <tr>  
                 <td class="Border">
                        <select id="idsiq_periodo" name="tipo" style="width: auto">
                                <!--<option value="-1">Seleccionar...</option> -->
                                     <?PHP 
					while(!$infoIndicador->EOF){
					?>
                                         <option  value="<?PHP echo $infoIndicador->fields['idsiq_infoIndicador']?>"><?PHP echo $infoIndicador->fields['nombre']?></option>
					<?PHP
					$infoIndicador->MoveNext();
					}
					?>
                                </select>
                      </td>
                 </tr>
                
                
                     <?php } ?>
                <label for="idsiq_periodo" class="grid-2-12">Periodo: <span class="mandatory">(*)</span></label>
                 <?php if($edit){ ?>
                
                <tr>  
                    <td class="Border">
                     <select id="idsiq_periodo" name="idPeriodo" style="width: auto" disabled="true" >
                               <option value="<?php if(!empty($edit)){ echo $data['idPeriodo']; } ?>"><?php if(!empty($edit)){ echo $periodovalor; } ?></option>
                     </select>
                    </td>
               </tr>
                 <?php } else { ?>
               
                  <tr>  
                 <td class="Border">
                        <select id="idsiq_periodo" name="idPeriodo" style="width: auto">
                                <!--<option value="-1">Seleccionar...</option> -->
                                     <?PHP 
					while(!$Periodo->EOF){
					?>
                                         <option  value="<?PHP echo $Periodo->fields['idsiq_periodo']?>"><?PHP echo $Periodo->fields['nombre']?></option>
					<?PHP
					$Periodo->MoveNext();
					}
					?>
                                </select>
                      </td>
                 </tr>
                 
                    <?php } ?>
                 
                <label for="valor" class="grid-2-12">Valor Indicador: <span class="mandatory">(*)</span></label>
                <input type="text" onKeyPress="return val(event)" maxlength="4" class="grid-5-12 required"   name="valor" id="valor" title="Valor del Indicador Numérico" tabindex="1" autocomplete="off" value="<?php if(!empty($edit)){ echo $data['valor']; } ?>" />      
                                
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Registrar Valor" class="first" /> <?php } ?>
        </form>
</div>

<script type="text/javascript">
    $(':submit').click(function(event) {
        //var buttonName = $(this).attr('name');

        //if (buttonName.indexOf('edit') >= 0) {
            //confirm("some text") logic...
        //}
        event.preventDefault();
        var valido= validateForm("#form_test");
        if(valido){
            sendForm();
        }
    });
    
 function sendForm(){
        //alert("Ingrese a sendForm");
                  var cal = showValues();
		 if(cal){
         $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'process.php',
            data: $('#form_test').serialize(),                
            success:function(data){
                //alert("Ingrese a Enviar");
                         if (data.success == true){
                             alert("Se ha registrado satisfactoriamente, El valor del indicador numérico.");
                                window.location.href="documentos.php?ver=2&id="+ <?php echo $indicador ; ?>;
                                }
                             else{                        
                    $('#msg-error').html('<p>' + data.message + '</p>');
                    $('#msg-error').addClass('msg-error');
                                  }
                                    },
					error: function(data,error,errorThrown){alert(error + errorThrown);}
				}); 
				}else{
                              //  alert("Fallee a Enviar");
                                  $('#msg-error').html('<p>' + 'Ya existe un valor para este periodo' + '</p>');
                                 $('#msg-error').addClass('msg-error');
                         } //fin de cal		 
    }
</script>
<script> 
      function val(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; 
    patron = /\d/; 
    te = String.fromCharCode(tecla); 
    return patron.test(te); 
} 
      </script> 
	  <script> 
     function vals(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; 
    patron =/[A-Za-zÑ-ñ\s]/; 
    te = String.fromCharCode(tecla); 
    return patron.test(te); 
} 
      </script> 
      
      <script language="javascript">  
function showValues(){  
var a=new Array;  

<?php  
for($i=0;$i<count($a); $i++){  
echo "a[$i]='".$a[$i]."';";  
}    
?>
   var campo = form_test.idPeriodo.value ;
  var insertar = false;
  var grabar = true; 
for(i=0;i<a.length;i++){
          //  alert("Lista es "+a[i]);
   if(a[i] == 0){
        insertar = true;
        // a[i] = 100;
     // alert("Valida p es  TRUE= ");

   }else {
            if( a[i] == campo){
                grabar = false; 
            }
    }         

}
    //  alert(" grabar  " + grabar );
if (grabar){
insertar = true; 
}else{
insertar = false;       
}
   // alert(" insertar  " + insertar );
return insertar;
}  
</script>   

<?php } ?>
