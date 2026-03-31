
		
			function inactivarProceso(idproceso,idfactor,tipo){
				var txt = "el proceso";
				if(tipo=="va"){
					txt = "el archivo";
				}
				var r = confirm("¿Está seguro que desea elimininar "+txt+"?");
				if (r == true) {
					$.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'emergente.php',
                        data: 'idsiq_factorautoevaluacion='+idproceso+'&idsiq_factor='+idfactor+'&tp='+tipo+'&action=inactivate',
                        success:function(data){ 
                            if (data.success == true){
                                location.reload();
                            }
                        },
                        error: function(data,error){}
                    }); 
				} 
			}
			