$(function(){
	// GET ID OF last row and increment it by one
	var $lastChar =1, $newRow;
	$get_lastID = function(){
		var $id = $('#expense_table tr:last-child td:first-child input').attr("id");        
        $lastChar = parseInt($id.substr (1));
		//console.log('GET id: ' + $lastChar + ' | $id :'+$id);
		$lastChar = $lastChar + 1;
		$newRow = "<tr> \
					<td><input type='text' class='actividad' id='e"+$lastChar+"' name='subjects[]' maxlength='255' id='subjects' />\
                    <input type='hidden' value='0' id='oculto_e"+$lastChar+"' /></td> \
					<td><input type='button' value='Delete' class='del_ExpenseRow' /></td> \
				</tr>"
		return $newRow;
	}
    
    $get_lastID_laboratorios = function(){
		var $id = $('#expense_table_laboratorios tr:last-child td:first-child input').attr("id");
        $lastChar = parseInt($id.substr (1));
		//console.log('GET id: ' + $lastChar + ' | $id :'+$id);
		$lastChar = $lastChar + 1;
		$newRow = "<tr> \
					<td><input type='text' class='actividad' id='l"+$lastChar+"' name='laboratorios[]' maxlength='255' />\
                    <input type='hidden' value='0' id='oculto_l"+$lastChar+"' /></td> \
					<td><input type='button' value='Delete' class='del_ExpenseRow_laboratorios' /></td> \
				</tr>"
		return $newRow;
	}
    
    $get_lastID_pae = function(){
		var $id = $('#expense_table_pae tr:last-child td:first-child input').attr("id");
        $lastChar = parseInt($id.substr (1));
		//console.log('GET id: ' + $lastChar + ' | $id :'+$id);
		$lastChar = $lastChar + 1;
		$newRow = "<tr> \
					<td><input type='text' class='actividad' id='p"+$lastChar+"' name='pae[]' maxlength='255' />\
                    <input type='hidden' value='0' id='oculto_p"+$lastChar+"' /></td> \
					<td><input type='button' value='Delete' class='del_ExpenseRow_pae' /></td> \
				</tr>"
		return $newRow;
	}
    
    $get_lastID_tic = function(){
        var $id = $('#expense_table_tic tr:last-child td:first-child input').attr("id");
        $lastChar = parseInt($id.substr (1));
		//console.log('GET id: ' + $lastChar + ' | $id :'+$id);
		$lastChar = $lastChar + 1;
		$newRow = "<tr> \
					<td><input type='text' class='actividad' id='t"+$lastChar+"' name='tic[]' maxlength='255' />\
                    <input type='hidden' value='0' id='oculto_t"+$lastChar+"' /></td> \
					<td><input type='button' value='Delete' class='del_ExpenseRow_tic' /></td> \
				</tr>"
		return $newRow;
	}
    /*
    * Caso 87930
    * @modified Luis Dario Gualteros 
    * <castroluisd@unbosque.edu.co>
    * Se crea la opcion para visulización del nuevo campo de innovación para nueva funcionalidad de Innovación según
    * solicitud de Liliana Ahumada.
    * @since Marzo 6 de 2017
    */ 
    $get_lastID_Innovar = function(){
        var $id = $('#expense_table_Innovar tr:last-child td:first-child input').attr("id");
        $lastChar = parseInt($id.substr (1));
		$lastChar = $lastChar + 1;
		$newRow = "<tr> \
					<td><input type='text' class='actividad' id='i"+$lastChar+"' name='Innovar[]' maxlength='255' />\
                    <input type='hidden' value='0' id='oculto_t"+$lastChar+"' /></td> \
					<td><input type='button' value='Delete' class='del_ExpenseRow_Innovar' /></td> \
				</tr>"
		return $newRow;
	}
    /*END Caso 87930*/
    $get_lastID_descubrimiento = function(valor,id){
		var $id = $('#expense_table_descubrimiento tr:last-child td:first-child input').attr("name");
        $lastChar = parseInt($id.substr (1));
		//console.log('GET id: ' + $lastChar + ' | $id :'+$id);
		$lastChar = $lastChar + 1;
		$newRow = "<tr> \
					<td><input type='text' class='actividad' name='descubrimiento[]' id='d"+$lastChar+"' maxlength='255' /></td> \
                    <input type='hidden' value='0' id='oculto_d"+$lastChar+"' /></td> \
					<td><input type='button' value='Delete' class='del_ExpenseRow_descubrimiento' /></td> \
				</tr>";
		return $newRow;
	}
    
    $get_lastID_orientacion = function(){
		var $id = $('#expense_table_orientacion tr:last-child td:first-child input').attr("name");
        $lastChar = parseInt($id.substr($id.length - 2), 10);
		//console.log('GET id: ' + $lastChar + ' | $id :'+$id);
		$lastChar = $lastChar + 1;
		/*$newRow = "<tr> \
					<td><input type='text' class='actividad' name='compromiso[]"+$lastChar+"' maxlength='255' /></td> \
					<td><input type='button' value='Delete' class='del_ExpenseRow_orientacion' /></td> \
				</tr>"*/
        $newRow = "<tr> \
					<td><input type='text' class='actividad' name='compromiso[]' id='o"+$lastChar+"' maxlength='255' />\
					<input type='hidden' value='0' id='oculto_o"+$lastChar+"' /></td> \
					<td><input type='button' value='Delete' class='del_ExpenseRow_orientacion' /></td> \
				</tr>"
		return $newRow;
	}
    
    $get_lastID_gestion = function(){
		var $id = $('#expense_table_gestion tr:last-child td:first-child input').attr("name");
        $lastChar = parseInt($id.substr($id.length - 2), 10);
		//console.log('GET id: ' + $lastChar + ' | $id :'+$id);
		$lastChar = $lastChar + 1;
		/*$newRow = "<tr> \
					<td><input type='text' class='actividad' name='gestion[]"+$lastChar+"' maxlength='255' /></td> \
					<td><input type='button' value='Delete' class='del_ExpenseRow_gestion' /></td> \
				</tr>"*/
        $newRow = "<tr> \
					<td><input type='text' class='actividad' name='gestion[]' id='g"+$lastChar+"' maxlength='255' />\
					<input type='hidden' value='0' id='oculto_g"+$lastChar+"' /></td> \
					<td><input type='button' value='Delete' class='del_ExpenseRow_gestion' /></td> \
				</tr>"
		return $newRow;
	}
	
	// ***** -- START ADDING NEW ROWS
	$('#add_ExpenseRow').live("click", function(){
		if($('#expense_table tr').size() <= 99){
			$get_lastID();
			$('#expense_table tbody').append($newRow);
		} else {
			alert("Reached Maximum Rows!");
		};
	});
	
	$(".del_ExpenseRow").live("click", function(){ 
		$(this).closest('tr').remove();
		$lastChar = $lastChar-2;
	});	
	
	$(".del_ExpenseRow_subjects").live("click", function(){ 
		$(this).closest('tr').remove();
		$lastChar = $lastChar-2;
	});
    
    
    $('#add_ExpenseRow_descubrimiento').live("click", function(){
		if($('#expense_table_descubrimiento tr').size() <= 99){
			$get_lastID_descubrimiento('','');
			$('#expense_table_descubrimiento tbody').append($newRow);
		} else {
			alert("Reached Maximum Rows!");
		};
	});
	
	$(".del_ExpenseRow_descubrimiento").live("click", function(){ 
		$(this).closest('tr').remove();
		$lastChar = $lastChar-2;
	});
    
    
    $('#add_ExpenseRow_orientacion').live("click", function(){
		if($('#expense_table_orientacion tr').size() <= 99){
			$get_lastID_orientacion();
			$('#expense_table_orientacion tbody').append($newRow);
		} else {
			alert("Reached Maximum Rows!");
		};
	});
	
	$(".del_ExpenseRow_compromiso").live("click", function(){ 
		$(this).closest('tr').remove();
		$lastChar = $lastChar-2;
	});
    
    $('#add_ExpenseRow_gestion').live("click", function(){
		if($('#expense_table_gestion tr').size() <= 99){
			$get_lastID_gestion();
			$('#expense_table_gestion tbody').append($newRow);
		} else {
			alert("Reached Maximum Rows!");
		};
	});
	
	$(".del_ExpenseRow_gestion").live("click", function(){ 
		$(this).closest('tr').remove();
		$lastChar = $lastChar-2;
	});
    
    $('#add_ExpenseRow_laboratorios').live("click", function(){
		if($('#expense_table_laboratorios tr').size() <= 99){
			$get_lastID_laboratorios();
			$('#expense_table_laboratorios tbody').append($newRow);
		} else {
			alert("Reached Maximum Rows!");
		};
	});
	
	$(".del_ExpenseRow_laboratorios").live("click", function(){ 
		$(this).closest('tr').remove();
		$lastChar = $lastChar-2;
	});
    
    $('#add_ExpenseRow_pae').live("click", function(){
		if($('#expense_table_pae tr').size() <= 99){
			$get_lastID_pae();
			$('#expense_table_pae tbody').append($newRow);
		} else {
			alert("Reached Maximum Rows!");
		};
	});
	
	$(".del_ExpenseRow_pae").live("click", function(){
		$(this).closest('tr').remove();
		$lastChar = $lastChar-2;
	});
    
    $('#add_ExpenseRow_tic').live("click", function(){
		if($('#expense_table_tic tr').size() <= 99){
			$get_lastID_tic();
			$('#expense_table_tic tbody').append($newRow);
		} else {
			alert("Reached Maximum Rows!");
		};
	});
	
	$(".del_ExpenseRow_tic").live("click", function(){
		$(this).closest('tr').remove();
		$lastChar = $lastChar-2;
	});
    
    /*
    * Caso 87930
    * @modified Luis Dario Gualteros 
    * <castroluisd@unbosque.edu.co>
    * Se crea la opcion para visulización del nuevo campo de innovación para nueva funcionalidad de Innovación según
    * solicitud de Liliana Ahumada.
    * @since Marzo 6 de 2017
    */ 
    
     $('#add_ExpenseRow_Innovar').live("click", function(){
		if($('#expense_table_Innovar tr').size() <= 99){
			$get_lastID_Innovar();
			$('#expense_table_Innovar tbody').append($newRow);
		} else {
			alert("Reached Maximum Rows!");
		};
	});
    /*END Caso 87930*/
	$(".del_ExpenseRow_Innovar").live("click", function(){
		$(this).closest('tr').remove();
		$lastChar = $lastChar-2;
	});
});