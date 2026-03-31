<?php 
   $modalidades = $utils->getActives($db,"codigomodalidadacademica,nombremodalidadacademica", "modalidadacademica","nombremodalidadacademica","ASC","","");
   $modalidades2 = array();
?>
<div id="dialog-carreras" title="Seleccionar Programas">
    <input type="hidden" name="modalidadEditable" id="modalidadEditable" value="false" />
    <fieldset class="noBorder">
        <label class="grid-4-12" for="idModalidades">Modalidad académica:</label>
        <select class="grid-8-12" id="idModalidades" size="1" name="idModalidades">
            <option value=""></option>
            <?php $i = 0;
            while($row = $modalidades->FetchRow()){
                $modalidades2[$i] = $row;
                $i = $i + 1;
            ?>
                <option value="<?php echo $row['codigomodalidadacademica']; ?>"><?php echo $row['nombremodalidadacademica']; ?></option>
            <?php } ?>
        </select>
        
        <div>
            <br/><input type="checkbox" name="carreras" id="carreras-all" value="si" class="hidden" /><span class="hidden" id="carreras-span"> Seleccionar todas</span><br/>
        </div>
        
        <div id="checkboxes">
            
        </div>
        
        <div id="selected-checkboxes" class="hidden">
        </div>
        
        <div id="modalidadesElegidas" style="border-top:1px solid #ccc;padding-top:5px;margin-top:10px;">
            <h4>Modalidades seleccionadas:</h4>
        </div>
    </fieldset>
</div>

<script type="text/javascript">    
    
    <?php //solo php 5.2 pa arriba
    $js_array = json_encode($modalidades2);
    echo "var myArray = ". $js_array . ";\n";
    ?>
    var selectedArray = new Array();
    
    $(function() {
        $( "#carreras-all" ).click(function() {
            if($(this).is(":checked")){
                $('#checkboxes input:checkbox:not(:disabled)').attr('checked','checked');
            } else {
                $('#checkboxes input:checkbox').removeAttr('checked');
            }
        });       
        
    });
    
    $('#idModalidades').bind("change", function(){
                    //cargo los datos de las carreras por ajax
                    if($('#idModalidades').val()==""){
                        $('#checkboxes input:checkbox').removeAttr('checked');
                        $("#carreras-all").addClass('hidden');
                        $("#carreras-span").addClass('hidden');
                        //innerHTML no funciona en IE o.O
                        $('#checkboxes').html("");
                        //document.getElementById("checkboxes").innerHTML = "";
                    } else{             
                           $('#modalidadEditable').val("false");
                           selectCarreras($("#idModalidades").val(),false); 
                    }
     });
     
     function changeSelect(removeID){
            var select = "<option value=''></option>";
           for (var i=0; i<myArray.length; i++) {
                if(removeID != myArray[i][0]){
                    select = select+"<option value='"+myArray[i][0]+"'>"+myArray[i][1]+"</option>";
                } else {
                    selectedArray.push(myArray[i][0]);
                    selectedArray.push(myArray[i][1]);
                    selectedArray.push(i);
                    //lo quito de mi arreglo de modalidades por elegir
                    myArray.splice(i,1); 
                    //porque como acabo de quitar uno, se joden los indices
                    i = i - 1;
                }
            }
            //innerHTML no funciona en IE o.O
            $('#idModalidades').html(select);
     }
     
          function returnSelect(returnID){
              //los checkbox
              $("#modalidadC-"+returnID).remove();
              //el enlace
             $("#modalidad-"+returnID).remove();
                                    
             //devuelvo la modalidad al select             
            var select = "<option value=''></option>";
            var index = 0;
            var value = "";
            var name = "";
            var stop = false;
           for (var i=0; i<selectedArray.length && !stop; i++) {
               if(returnID == selectedArray[i]){
                   value = selectedArray[i];
                   name = selectedArray[i+1];
                   index = selectedArray[i+2];
                   stop = true;
               }
           }
           myArray.splice(index,0,{"0":value,"1":name}); 
           for (var i=0; i<myArray.length; i++) {
               if(myArray[i][0]==returnID){
                   select = select+"<option value='"+myArray[i][0]+"' selected>"+myArray[i][1]+"</option>";
               }else{
                   select = select+"<option value='"+myArray[i][0]+"'>"+myArray[i][1]+"</option>";
               }
            }
            //innerHTML no funciona en IE o.O
            $('#idModalidades').html(select);
                                    
            $('#modalidadEditable').val("false");
     }
     
     function updateSelect(returnID){
              //los checkbox
              $("#modalidadC-"+returnID).remove();
              //el enlace
             $("#modalidad-"+returnID).remove();
             var selected = $('#idModalidades').val();
                                    
             //devuelvo la modalidad al select             
            var select = "<option value=''></option>";
            var index = 0;
            var value = "";
            var name = "";
            var stop = false;
           for (var i=0; i<selectedArray.length && !stop; i++) {
               if(returnID == selectedArray[i]){
                   value = selectedArray[i];
                   name = selectedArray[i+1];
                   index = selectedArray[i+2];
                   stop = true;
               }
           }
           myArray.splice(index,0,{"0":value,"1":name}); 
           for (var i=0; i<myArray.length; i++) {
               if(myArray[i][0]==selected){
                   select = select+"<option value='"+myArray[i][0]+"' selected>"+myArray[i][1]+"</option>";
               }else{
                   select = select+"<option value='"+myArray[i][0]+"'>"+myArray[i][1]+"</option>";
               }
            }
            //innerHTML no funciona en IE o.O
            $('#idModalidades').html(select);
     }
     
     function resetModalidades(){
         <?php echo " myArray = ". $js_array . ";\n"; ?>         
            var select = "<option value=''></option>";
           for (var i=0; i<myArray.length; i++) {
                select = select+"<option value='"+myArray[i][0]+"'>"+myArray[i][1]+"</option>";
            }
            selectedArray = new Array();
            //innerHTML no funciona en IE o.O
            $('#idModalidades').html(select);
     }
     
     function selectCarreras(mod,edit){
         $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: "../searchs/lookForCareers.php",
                                data: {
                                    modalidad: mod,
                                    indicador: $('#idGenerico').val()
                                },
                                success:function(data){ 
                                    var select = "";
                                    for (var i=0;i<data.length;i++)
                                    {          
                                        if(data[i]["enable"]){
                                            select = select+"<input type='checkbox' name='carrera[]' value='"+data[i]["value"]+"' /> "+data[i]["label"]+"<br/>";
                                        } else {
                                            select = select+"<input type='checkbox' name='carrera[]' value='"+data[i]["value"]+"' disabled='disabled' /> "+data[i]["label"]+"<br/>";
                                        }
                                    }
                                    
                                    $("#carreras-all").removeClass('hidden');
                                    $("#carreras-span").removeClass('hidden');
                                    //innerHTML no funciona en IE o.O
                                    $('#checkboxes').html(select);
                                    //document.getElementById("checkboxes").innerHTML = select;                                   
          
                                    //es una modalidad a la que ya se le seleccionaron varias carreras
                                    if(edit){
                                        $('#modalidadEditable').val(mod);
                                        $('#modalidadC-'+mod+' input:checked').each(function() {
                                            //alert($(this).val());
                                                $("#checkboxes input:checkbox[value='"+$(this).val()+"']").attr('checked','checked');
                                        });
                                        returnSelect(mod);
                                        //$("#idModalidades").val("");   
                                    } else {
                                        $('#modalidadEditable').val("false");
                                    }
                                    
                                },
                                error: function(data,error){}
          }); 
     }
</script>
