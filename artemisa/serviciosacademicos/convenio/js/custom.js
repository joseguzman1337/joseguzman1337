$(function(){
	// GET ID OF last row and increment it by one
	var $lastChar =1, $newRow;
	$get_lastID = function(){
		var $id = $('#expense_table tr:last-child td:first-child select').attr("name");
        //alert($id);
		$lastChar = parseInt($id.substr($id.length - 2), 10);
		//console.log('GET id: ' + $lastChar + ' | $id :'+$id);
		$lastChar = $lastChar + 1;
        var selec = $('#instituciones_01').html();
		$newRow = "<tr name='lista_0"+$lastChar+"'><td><select id='instituciones_0"+$lastChar+"' name='instituciones_0"+$lastChar+"'>"+selec+"</select></td>\
					<td><center><input type='number' id='cupos_0"+$lastChar+"' name='cupos_0"+$lastChar+"' maxlength='40' onkeypress='return val_numero(event)'/></center></td> \
					<td><input type='button' value='Borrar' class='del_ExpenseRow' /></td></tr>"
		return $newRow;
	}
	
	// ***** -- START ADDING NEW ROWS
	$('#add_ExpenseRow').live("click", function(){
		if($('#expense_table tr').size() <= 200){
			$get_lastID();
            var $contar = parseInt($('#contador').val());
            $contar = $contar + 1;  
            //alert($contar)          
            $('#contador').val($contar);
			$('#expense_table tbody:#1').append($newRow);
		}else {
			alert("Maximo de instiutuciones que se pueden agregar!");
		};
	});
	
	$(".del_ExpenseRow").live("click", function(){ 
		$(this).closest('tr').remove();
		$lastChar = $lastChar-2;
	});	
});
/* Agregar Actividades Convenio */
$(function(){
	// GET ID OF last row and increment it by one
	var $lastChar =1, $newRow;
	$add_fieldText = function($valText){
		$lastChar = $valText;
		$lastChar = $lastChar + 1;
        
		$newRow = "<tr name='activi_0"+$lastChar+"'>\
					<td><center><input type='text' size='50' id='actividadN[]' name='actividadN[]' maxlength='40' /></center></td> \
					<td><img class='del_ExpenseRowActividad' width='25' src='../mgi/images/delete.png' title='Eliminar Actividad' style='cursor: pointer;' /></td></tr>"
		return $newRow;
	}
	$valText = 0;
	// ***** -- START ADDING NEW ROWS
	$('#add_Actividad').live("click", function(){
		if($('#expense_tableActividad tr').size() <= 200){
			$valText = $valText+1;
			/*if($valText !== 0)
			{
				$valText=$valText+1;	
			}*/
            $add_fieldText($valText);
			var $contar = parseInt($('#contador').val());
            $contar = $contar + 1;  
            $('#contador').val($contar);
			$('#expense_tableActividad tbody:#1').append($newRow);
		}else {
			alert("Maximo de instiutuciones que se pueden agregar!");
		};
	});
	
	$(".del_ExpenseRowActividad").live("click", function(){ 
		$(this).closest('tr').remove();
		$lastChar = $lastChar-2;
	});	
});
