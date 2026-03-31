<?php 
   //$facultades = $utils->getAll($db,"codigofacultad,nombrefacultad", "facultad","nombrefacultad","ASC","","");
    $facultades = $utils->getFacultadesConProgramas($db);
   $facultades2 = array();
?>
<div id="dialog-carreras" title="Seleccionar Programas">
    <input type="hidden" name="modalidadEditable" id="modalidadEditable" value="false" />
    <fieldset class="noBorder">
        <label class="grid-4-12" for="idModalidades">Facultades:</label>
        <select class="grid-8-12" id="idModalidades" size="1" name="idModalidades">
            <option value=""></option>
            <?php $i = 0;
            while($row = $facultades->FetchRow()){
                $facultades2[$i] = $row;
                $i = $i + 1;
            ?>
                <option value="<?php echo $row['codigofacultad']; ?>"><?php echo $row['nombrefacultad']; ?></option>
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
            <h4>Facultades seleccionadas:</h4>
        </div>
    </fieldset>
</div>

<script type="text/javascript">    
    
    <?php //solo php 5.2 pa arriba
    $js_array = json_encode($facultades2);
    echo "var myArray = ". $js_array . ";\n";    
    ?>
    var selectedArray = new Array();
    
    $(function() {
        $( "#carreras-all" ).click(function() {
            if($(this).is(":checked")){
                $('#checkboxes input:checkbox:not(:disabled)').attr('checked','checked');
                var checked = $("#checkboxes input:checked").length > 0;
                if(!checked){
                    alert("No hay ningún programa disponible para seleccionar.");
                    $(this).removeAttr("checked");
                }
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
                           selectCarreras(''+$("#idModalidades").val(),false); 
                    }
     });
     
     function changeSelect(removeID){
            var select = "<option value=''></option>";
           for (var i=0; i<myArray.length; i++) {
                if(removeID != myArray[i][0]){
                    select = select+"<option value='"+myArray[i][0]+"'>"+myArray[i][1]+"</option>";
                } else {
                    selectedArray.push(""+myArray[i][0]);
                    selectedArray.push(""+myArray[i][1]);
                    selectedArray.push("index"+i);
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
              returnID = "" + returnID;
              
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
                   value = ""+selectedArray[i];
                   name = ""+selectedArray[i+1];
                   index = selectedArray[i+2].replace("index","");
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
                   value = ""+selectedArray[i];
                   name = ""+selectedArray[i+1];
                   index = selectedArray[i+2].replace("index","");
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
     
     function selectAllCareers(){
         var num = myArray.length;
         if(num>0){
            //reseteo por si tenia elegidas
            resetModalidades();
         }   
         
         //las elijo todas uno por uno
         var j=0;
         while(myArray.length!=0) {
             $('#modalidadEditable').val("false");
             //console.log(myArray.length);
             
             var modalidad = myArray[j][0];
             
             //mando a buscar las carreras de la facultad
             selectCarreras(''+modalidad,false,true);   
             
             //elijo todas las carreras que encontro
             $('#checkboxes input:checkbox:not(:disabled)').attr('checked','checked'); 
             var checked = $("#checkboxes input:checked").length > 0;
             if(checked){
                    //guardo todos las carreras seleccionadas                                
                    $("#selected-checkboxes").append( "<div id='modalidadC-"+modalidad+"'>" );
                    $("#selected-checkboxes").append( "</div>" );
                    var i = 0;
                    $('#checkboxes input:checked').each(function() {
                    i = i + 1;
                    $("#modalidadC-"+modalidad).append( $(this) );
                    });

                    //Lo paso a la lista de elegidos                                    
                    $("#modalidadesElegidas").append( "<span id='modalidad-"+modalidad+"'><a href='javascript:selectCarreras(\""+modalidad+"\",true)'>"+ myArray[j][1]+" ( "+i+" programas seleccionados )</a><br/></span>" );

              }

              if($('#modalidadEditable').val()=="false"){
                       //remuevo la modalidad de los que falta por elegir
                       changeSelect(modalidad);  
              }   
          }
         
             myArray = new Array();

             $("#idModalidades").val("");    
             $("#carreras-all").addClass('hidden');
             $("#carreras-span").addClass('hidden');                                
             //innerHTML no funciona en IE o.O
             $('#checkboxes').html("");

             $('#carreras-all').removeAttr('checked');

             var select = "<option value=''></option>";
             $('#idModalidades').html(select); 
     }
     
     function selectCarreras(mod,edit){
        //selectALL = (typeof selectALL === "undefined") ? false : selectALL;
        //le agregue el async: false para que no sea asincronico porque sino puede hacer el resto del método antes de acabar el llamado
         $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                async: false,
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
                                        $('#modalidadEditable').val(""+mod);
                                        $('#modalidadC-'+mod+' input:checked').each(function() {
                                            //alert($(this).val());
                                                $("#checkboxes input:checkbox[value='"+$(this).val()+"']").attr('checked','checked');
                                        });
                                        returnSelect(""+mod);
                                        //$("#idModalidades").val("");   
                                    } else {
                                        $('#modalidadEditable').val("false");
                                    }                                    
                                    
                                },
                                error: function(data,error){}
          }); 
          
     }
</script>
