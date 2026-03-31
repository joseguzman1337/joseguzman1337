<?php

 // include("../../templates/templateAutoevaluacion.php");
  // $db =writeHeader("Respuestas",true,"Autoevaluacion");
   
function writeForm($edit, $id="", $db) {
    $data = array();
    $action = "save1";
     $utils = new Utils_numericos();
     
   // var_dump("Insertar"+$id);
    if($edit){
        $action = "update1";
        if($id!=""){  
           // var_dump($id);
            $data = $utils->getDataEntity("funcionTipo2", $id); 
            //$data =$data['valor'];
         //var_dump($data);
          
            
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
                                                inner join sala.siq_funcionTipo2 as b on a.idsiq_funcionIndicadores =  b.funcionIndicadores
                                                where b.idsiq_funciontipo2 = '.$id);
         
                  while($row3 = mysql_fetch_array($result3))
                        {
                   //  echo $row['nombre'] . " " . $row['nombre'];
                     $indicador = $row3['idIndicador'];
                    echo "<br />";
                         }
                         // var_dump($indicador); 
                         
                          $result4 = mysql_query('select a.idsiq_funcionTipo1,id.nombre as nombre ,c.nombrecarrera as carrera , a.valor as valor from siq_funcionTipo1 a  
inner join siq_funcionIndicadores b on a.funcionIndicadores = b.idsiq_funcionIndicadores 
inner join siq_indicador g  on b.idIndicador = g.idsiq_indicador 
 inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico 
 left join carrera c on c.codigocarrera = g.idCarrera 
where a.idsiq_funcionTipo1 = '.$data['idtipo1valor1']);
         
                  while($row4 = mysql_fetch_array($result4))
                        {
                   //  echo $row['nombre'] . " " . $row['nombre'];
                     $nombreInd = $row4['nombre']." ".$row4['carrera'];
                      $valorInd = $row4['valor'];
                    echo "<br />";
                         }
                         // var_dump($nombreInd); 
                         // var_dump($valorInd); 
                          
                          
                            $result5 = mysql_query('select a.idsiq_funcionTipo1,id.nombre as nombre ,c.nombrecarrera as carrera , a.valor as valor from siq_funcionTipo1 a  
inner join siq_funcionIndicadores b on a.funcionIndicadores = b.idsiq_funcionIndicadores 
inner join siq_indicador g  on b.idIndicador = g.idsiq_indicador 
 inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico 
 left join carrera c on c.codigocarrera = g.idCarrera 
where a.idsiq_funcionTipo1 = '.$data['idtipo1valor2']);
         
                  while($row5 = mysql_fetch_array($result5))
                        {
                   //  echo $row['nombre'] . " " . $row['nombre'];
                     $nombre2Ind = $row5['nombre']." ".$row5['carrera'];
                      $valor2Ind = $row5['valor'];
                    echo "<br />";
                         }
                          //var_dump($nombre2Ind); 
                          // var_dump($valor2Ind); 
                  
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
                echo 'Error en Información Indicador.. <br>'.$SQL_info;
		     die;
	}

     while(!$indirespuesta->EOF){
                        $indicador =$indirespuesta->fields['idIndicador'];
                        //var_dump($indicador);
			$indirespuesta->MoveNext();
			}
                        
                        
                        
                             $SQL_validarPeriodo='SELECT idPeriodo FROM siq_funcionTipo2 where funcionIndicadores ='.$id;

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

 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
     var cargar = "<?php echo $action; ?>" ;
     if(cargar == "save1"){
         //document.write("save = " + cargar);
         cargar_paises();

     }else if (cargar == "update1"){
            //document.write("update = " + cargar);
         cargar_paises_editar();
     }
	
	$("#pais").change(function(){dependencia_estado();});
        $("#pais").change(function(){dependencia_estado2();});
        //$("#pais").change(function(){dependencia_ciudad();});
        //$("#pais").change(function(){dependencia_ciudad2();});
	$("#estado").change(function(){dependencia_ciudad();});
        $("#estado2").change(function(){dependencia_ciudad2();});
	$("#estado").attr("disabled",true);
	$("#ciudad").attr("disabled",true);
        $("#estado2").attr("disabled",true);
	$("#ciudad2").attr("disabled",true);
});


function editarcargar()
{
    //alert("Ingrese a editar Cargar");
    $("#pais").change(function(){dependencia_estado();});
        $("#pais").change(function(){dependencia_estado2();});
        //$("#pais").change(function(){dependencia_ciudad();});
        //$("#pais").change(function(){dependencia_ciudad2();});
	$("#estado").change(function(){dependencia_ciudad();});
        $("#estado2").change(function(){dependencia_ciudad2();});
	$("#estado").attr("disabled",true);
	$("#ciudad").attr("disabled",true);
        $("#estado2").attr("disabled",true);
	$("#ciudad2").attr("disabled",true);
}


function valores()
{
    $("#estado").attr("disabled",false);
   //$("#estado").change(function(){dependencia_ciudad();});
}


function cargar_paises()
{
	$.get("scripts/cargar-paises.php", function(resultado){
		if(resultado == false)
		{
			alert("No se encontraron Periodos");
		}
		else
		{
			$('#pais').append(resultado);		
		}
	});	
}

function cargar_paises_editar()
{
	$.get("scripts/cargar-paises2.php?id=<?php echo $data['idPeriodo']; ?>", function(resultado){
		if(resultado == false)
		{
			alert("No se encontraron Periodos");
		}
		else
		{
			$('#pais').append(resultado);		
		}
	});	
}

function dependencia_estado()
{
	var code = $("#pais").val();
	$.get("scripts/dependencia-estado.php", { code: code },
		function(resultado)
		{
			if(resultado == false)
			{
				alert("No se encontraron Indicadores para este Periodo");
			}
			else
			{
				$("#estado").attr("disabled",false);
                                
				document.getElementById("estado").options.length=1;
				$('#estado').append(resultado);	
                        }
                }

	); 
}

function dependencia_estado2()
{
    var code = $("#pais").val();
     $.get("scripts/dependencia-estado2.php", { code: code },
		function(resultado)
		{
			if(resultado == false)
			{
                            alert("No se encontraron Indicadores para este Periodo");
			}
			else
			{
				$("#estado2").attr("disabled",false);
				document.getElementById("estado2").options.length=1;
				$('#estado2').append(resultado);			
			}
		}

	);
}

function dependencia_ciudad()
{
	var code = $("#estado").val();
         //document.write("code = " + code);
	$.get("scripts/dependencia-ciudades.php?", { code: code }, function(resultado){
		if(resultado == false)
		{
			alert("No se encontraron Valores para este Indicador");
		}
		else
		{
			$("#ciudad").attr("disabled",false);
			document.getElementById("ciudad").options.length=1;
			$('#ciudad').append(resultado);
                var seleccion = $("#ciudad").val();	
                //document.write("Seleccion = " + seleccion);	

		}
	});		
	
}
function dependencia_ciudad2()
{
	var code = $("#estado2").val();
        $.get("scripts/dependencia-ciudades2.php?", { code: code }, function(resultado){
		if(resultado == false)
		{
			alert("No se encontraron Valores para este Indicador");
		}
		else
		{
			$("#ciudad2").attr("disabled",false);
			document.getElementById("ciudad2").options.length=1;
			$('#ciudad2').append(resultado);			
		}
	});
}
        
        
</script>

<style type="text/css">
dt{font-size:200%;}
dd{font-size:150%;}
</style>

</head>


<div id="form"> 
    <div id="msg-error"></div>
   
         <form action="save.php" method="post" id="form_test" >
            <input type="hidden" name="entity" value="funcionTipo2" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="idsiq_funcionTipo2" value="'.$id.'">';
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
                 <?php if($edit){ 
                    ?>   
                
                <tr>  
                    <td class="Border">
                        <select id="pais" name="idPeriodo" style="width: auto" onfocus="editarcargar()">   
                               <option value="<?php if(!empty($edit)){ echo $data['idPeriodo']; } ?>"><?php if(!empty($edit)){ echo $periodovalor ;} ?></option>
                     </select>
                    </td>
               </tr>
                 <?php } else { ?>
               
                  <tr>  
                 <td class="Border">
                        <select id="pais" name="idPeriodo">
                        <option value="0">Selecciona Uno...</option>
                        </select>
                      </td>
                 </tr>
                 
                    <?php } ?>
                 <label for="estado" class="grid-2-12">Valor 1 : <span class="mandatory">(*)</span></label>
                  <?php if($edit){ 
                    //  var_dump($data['idtipo1valor1']);
                      ?> 

                 <tr>  
                 <td class="Border">
                     <select id="estado" name="idtipo1valor1" style="width: auto" onload="valores()">
                 <option value='<?php if(!empty($edit)){ echo $data['idtipo1valor1']; } ?>'><?php if(!empty($edit)){ echo $nombreInd ; } ?></option>
                      </select>
                      </td>
                 </tr>    
                 
                  <tr>  
                 <td class="Border">
                     <select id="ciudad"  name="valor1">
            <option value="<?php if(!empty($edit)){ echo $valorInd; } ?>"><?php if(!empty($edit)){ echo $valorInd ; } ?></option>
                      </select>  
                      </td>
                 </tr>   
                 
                  <?php } else { ?>
                <tr>  
                 <td class="Border">
                       <select id="estado" name="idtipo1valor1" style="width: auto">
                 <option value="0">Selecciona Uno...</option>
                      </select>
                      </td>
                 </tr>    
                 
                <tr>  
                 <td class="Border">
                     <select id="ciudad" name="valor1" >
            <option value="0">Selecciona Uno...</option>
            <option selected="selected" value="<?php if(empty($edit)){ echo $valorIndIng; } ?>"><?php if(empty($edit)){ echo $valorIndIng ; } ?></option>
                      </select>  
                      </td>
                 </tr>   
                 
                   <?php } ?>
                    <label for="estado2" class="grid-2-12">Valor 2 : <span class="mandatory">(*)</span></label>
                     
                        <?php if($edit){ 
                        //  var_dump($data['idtipo1valor2']);?>
                      <tr>  
                 <td class="Border">
                     <select id="estado2" name="idtipo1valor2" style="width: auto" >
                 <option value="<?php if(!empty($edit)){ echo $data['idtipo1valor2']; } ?>"><?php if(!empty($edit)){ echo $nombre2Ind ; } ?></option>
                      </select>
                      </td>
                 </tr>    
                      <tr>  
                 <td class="Border">
                          <select id="ciudad2" name="valor2" >
            <option value="<?php if(!empty($edit)){ echo $valor2Ind; } ?>"><?php if(!empty($edit)){  echo $valor2Ind; } ?></option>
                      </select>  
                      </td>
                 </tr> 
                     <?php } else { ?>
                    
                <tr>  
                 <td class="Border">
                       <select id="estado2" name="idtipo1valor2" style="width: auto">
                 <option value="0">Selecciona Uno...</option>
                      </select>
                      </td>
                 </tr>     
               <tr>  
                 <td class="Border">
                          <select id="ciudad2" name="valor2">
            <option value="0">Selecciona Uno...</option>
             <option selected="selected" value="<?php if(empty($edit)){ echo $valor2IndIng; } ?>"><?php if(empty($edit)){ echo $valor2IndIng ; } ?></option>
                      </select>  
                      </td>
                 </tr>   
                 
                  <?php } ?>
                 
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first"/>
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
            //alert("Lista es "+a[i]);
   if(a[i] == 0){
        insertar = true;
        // a[i] = 100;
    //  alert("Valida p es  TRUE= ");

   }else {
            if( a[i] == campo){
                grabar = false; 
            }
    }         

}
     // alert(" grabar  " + grabar );
if (grabar){
insertar = true; 
}else{
insertar = false;       
}
    //alert(" insertar  " + insertar );
return insertar;
}  
</script>   

<?php }
?>
