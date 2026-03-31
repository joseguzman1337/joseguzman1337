	function generar_password(campoNombre,campoApellido, campoLogin, campoPassword){
		var nombres = document.getElementsByName(campoNombre).item(0).value;
		var apellido = document.getElementsByName(campoApellido).item(0).value;
		generar_password_con(nombres,apellido, campoLogin, campoPassword);
	}

	function generar_password_con(nombres,apellido, campoLogin, campoPassword){
		var nombres = nombres.replace(/[ ]/g,"").toLowerCase().replace(/[^a-z]/g,"");
		var apellido = apellido.replace(/[ ]/g,"").toLowerCase().replace(/[^a-z]/g,"");
		if ((nombres =="") || (apellido ==""))
			return;
		var apeLogin = apellido.substring(0, Math.min(apellido.length,4));
		var login = apeLogin + nombres.substring(0, Math.min(nombres.length,8 - apeLogin.length));
		var sup = Math.pow(10,(7 - apeLogin.length));
		var password = apeLogin + aleatorio(sup / 10, sup - 1);
		document.getElementsByName(campoPassword).item(0).value =password;
		document.getElementsByName(campoLogin).item(0).value =login;
	}
	
	function aleatorio(inferior,superior){
		numPosibilidades = superior - inferior
		aleat = Math.random() * numPosibilidades
		aleat = Math.round(aleat)
		return (parseInt(inferior) + aleat);
	} 