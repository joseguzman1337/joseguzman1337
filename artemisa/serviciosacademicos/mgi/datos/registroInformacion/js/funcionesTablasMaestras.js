function changeFormModalidad(formName,ruta){
					if (typeof(ruta) == "undefined") { ruta = './';}
                    var mod = $(formName + ' #modalidad').val();
                    var carrera = $(formName + ' #unidadAcademica').val();
					if($(formName + ' #unidadAcademica').val()!=""){
						$.ajax({
									dataType: 'json',
									type: 'POST',
									url: ruta+'formularios/academicos/_elegirProgramaAcademico.php',
									data: { modalidad: mod, carrera: carrera, action: "setSession" },     
									success:function(data){
										 $(".formModalidad").load(ruta+'formularios/academicos/_elegirProgramaAcademico.php'); 
										 //cuando acabe todos los load por ajax
										 $(document).bind("ajaxStop", function() {
											$(this).unbind("ajaxStop"); //esto es porque sino queda en ciclo infinito por lo que vuelvo a llamar un ajax
											
										});                         
									},
									error: function(data,error,errorThrown){alert(error + errorThrown);}
						 });  
					 }
                }
        
        function getCarreras(formName){
                    $(formName + " .unidadAcademica").html("");
                    $(formName + " .unidadAcademica").css("width","auto");   
                    if($(formName + ' .modalidad').val()!=""){
                        var mod = $(formName + ' .modalidad').val();
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: '../searchs/lookForCareersByModalidad.php',
                                data: { modalidad: mod },     
                                success:function(data){
                                     var html = '<option value="" selected></option>';
                                     var i = 0;
                                        while(data.length>i){
                                            html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
                                            i = i + 1;
                                        }                                    
                            
                                        $(formName + " .unidadAcademica").html(html);
                                        $(formName + " .unidadAcademica").css("width","500px");                                        
                                },
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                            });  
                    }
         }
		 
function pintarValoresConsulta(name, funcion, valores, campos, totalizar, conCategoria,nombresCategorias){
	//if(typeof conCategoria == "undefined" ){
	//	conCategoria = true;
	//}
	var totalCampos = campos.length;
	var totales = new Array(); 
	//console.log(campos);console.log(totalCampos);
	//console.log(valores);
								
	var row;
	var key;
	var keyR;
	var resultados=new Array(); 
	//calculando resultados
	for (row in valores){
		//console.log(row);
		//console.log("cat " + conCategoria);
		for (key in valores[row]){
			//console.log(key);
			keyR = key;
			if(conCategoria===false){
				keyR = 0;
			} else if(conCategoria===true) {
				keyR = resultados.length;
			}
			//console.log(valores[row][key]);
			//console.log("llave" + keyR);
			//console.log("es indefinido?" + resultados[keyR]);
			if(typeof resultados[keyR] != "undefined"){
				//sumar
				if(funcion==="sum"){
					for (var i=0;i<totalCampos;i++)
					{
			//console.log("resultados " + resultados[keyR][campos[i][0]]);
			//console.log("valores " + valores[row][key][campos[i][0]]);
						if(campos[i][1]==="int"){
							resultados[keyR][campos[i][0]] = parseInt(resultados[keyR][campos[i][0]]) + parseInt(valores[row][key][campos[i][0]]);
						}
					}
				}
			} else {
				//console.log("valores en else " + valores[row][key]);				
				resultados[keyR] = valores[row][key];
			}
		}
	}  
		//console.log(resultados);
		//pintando resultados
		var unicaColumna = false;
		var x = 0;
		var y = 0;
		var enteros=0;
		for (key in resultados){	
				html = '<tr class="dataColumns">';
				for (var i=0;i<totalCampos;i++)
				{
					if(campos[i][1]==="int"){	
						x = x + 1;			
						enteros	= enteros + 1;					
						if(totalizar===true){  
							if(typeof totales[i]== "undefined"){
								totales[i] = 0;
							}
							totales[i] = totales[i] + parseInt(resultados[key][campos[i][0]]); 
						}
						html = html + '<td class="column borderR center">'+resultados[key][campos[i][0]]+'</td>';
					} else if(campos[i][1]==="texto"){
						html = html + '<td class="column borderR">'+resultados[key][campos[i][0]]+'</td>';
					}else if(campos[i][1]==="categoria"){
						if(typeof nombresCategorias[resultados[key][campos[i][0]]] !== "undefined"){
							html = html + '<td class="column borderR">'+nombresCategorias[resultados[key][campos[i][0]]]+'</td>';
						} else {
							html = html + '<td class="column borderR"></td>';
						}
					}else if(campos[i][1]==="textoFijo"){
						if(html.slice(0,-5)==="</tr>" && html.slice(0,-24)!=='<tr class="dataColumns">'){
							html = html + "<tr>";
						} else if(html.slice(0,-24)!=='<tr class="dataColumns">' && html.slice(0,-24)!==''){
							html = html + "</tr><tr>";
						}
						y = y + 1;
						html = html + '<td class="column borderR">'+campos[i][0]+'</td>';
						x = x + 1;
						unicaColumna = true;
					}
				}
                html = html + '</tr>';
                $(name + ' tbody').append(html);
		}
		//console.log(totales);
		
		//columna de totales
		var totalizado = 0;
		var columnasTotales = parseInt(x/y);
		var columnasEnteras = parseInt(enteros/y);
		var grupos = 0;
		if(x==1){
			grupos = 1;
		} else {
			grupos = parseInt(totales.length/x);
		}
		var x = 1;
		var indice = 1;
		var totalizado=new Array(); 
		var contadorTotales = 1;
		//console.log(columnasTotales);
		//console.log(unicaColumna);
		//console.log(totales);
        if(totalizar===true){  
                html = '<tr class="dataColumns">';
                html = html + '<th class="column total right borderR"><span>Total</span></th>"';
				for (key in totales){	
					if(unicaColumna && columnasTotales==1){
						if(typeof totalizado[0]== "undefined"){
								totalizado[0] = 0;
						}
						totalizado[0] += totales[key];
					} else if(unicaColumna){ 
						/*if(indice>=columnasTotales){
							x = x + 1;
							indice = 1;
						}*/
						if(typeof totalizado[x]== "undefined"){
								totalizado[x] = 0;
						}
						totalizado[x] += totales[key];
						if(x==(columnasTotales-1)){
							x = 1;
						} else {
							x = x + 1;
						}
						//indice = indice + 1;
					} else {
						contadorTotales = contadorTotales + 1;
						html = html + '<th class="column total borderR center">'+totales[key]+'</th>"'; 
					}					
				}   
				//console.log(totalizado);
				if(unicaColumna){
					for (key in totalizado){	
						contadorTotales = contadorTotales + 1;
						html = html + '<th class="column total borderR center">'+totalizado[key]+'</th>"'; 
					}
				}
				if(y>0){
					var filasRestantes = parseInt(totalCampos/y) - contadorTotales;
				} else {
					var filasRestantes = parseInt(totalCampos) - contadorTotales;
				}
				for (var b=0;b<filasRestantes;b++)
				{
					html = html + '<th class="column total borderR center"></th>"'; 
				}
                html = html + '</tr>';
				$(name + ' tbody').append(html);
		}
}

function cambiarFormato(periodos, formatoActual, formato){
	//console.log("periodos " + periodos);
	var arreglo = periodos.trim().split(",");
	var total = arreglo.length;
	var valoresPeriodos = "";
	for (var i = 0; i < total; i++) {
	//console.log("arreglo " + arreglo[i]);
		if(formatoActual=="Yp" && formato=="Y-p"){
			//cada 4 caracteres me corta el string o me devuelve un arreglo vacio
			periodoArray = arreglo[i].trim().match(/.{1,4}/g) || [];
			//console.log(periodoArray);
			periodo = periodoArray[0]+"-"+periodoArray[1];
		}
		if(valoresPeriodos!==""){
			valoresPeriodos += ", "
		}
		valoresPeriodos += periodo;
	}
	return valoresPeriodos;
}