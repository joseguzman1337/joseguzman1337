<?php

//Formulario de tipo 2 columnas con etiqueta y campo en cada columna respectivamente

class formulariobaseestudiante extends formulario {

    var $filatmp;
    var $contcalendario = 0;

    //Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
    //donde se puede aï¿½adir una condicion $condicion y una operacion (max(),min(),sum()...) basica
    function recuperar_datos_tabla($tabla, $nombreidtabla, $idtabla, $condicion = "", $operacion = "") {
        $query = "select * $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        return $row_operacion;
    }

    //crea un input con todos los parametros correspondientes
    function boton_tipo($tipo, $nombre, $valor, $funcion = "") {
        echo "<input type='$tipo' name='$nombre' id='$nombre'  value='$valor' $funcion>";
    }

    function boton_link_emergente($url, $nombrelink, $ancho, $alto, $menubar = "no", $javascript = "", $activafuncion = 1, $retorno = 0) {

        $htmlgenerado = "
		<script LANGUAGE=\"JavaScript\">\n
		function  nuevaVentanaLink(pagina,nombre,width,height){\n
		parametro=\"width=\"+width+\",height=\"+height+\",menubar=$menubar,scrollbars=yes,resizable=yes\";\n
		//alert('entro');\n
		window.open(pagina,nombre,parametro);\n

		return false;\n
		}
		</script>\n";

        if ($activafuncion)
            $funcion = "onclick=\"return nuevaVentanaLink('" . $url . "','" . $nombrelink . "'," . $ancho . "," . $alto . ");\";";
        else
            $funcion = "";
        $htmlgenerado .= "<a href='$url' $javascript $funcion>$nombrelink</a>";
        if ($retorno)
            return $htmlgenerado;
        else
            echo $htmlgenerado;
    }

    function ayuda($ayuda = "") {
        if ($ayuda != "") {
            //echo "<br>AYUDA=".$ayuda." ".$this->rutaraiz."imagenes/pregunta.gif'";;
            //$globo=$this->globo($ayuda);
            $archivoayuda = $this->rutaraiz . "archivoayuda.php?ayuda=" . str_replace(" ", "_", $ayuda);
            $globo = "onmouseover='ajax_showTooltip(window.event,\"" . $archivoayuda . "\",this); return false' onmouseout='ajax_hideTooltip()'";
            $imagen = "<img src='" . $this->rutaraiz . "pregunta.gif'";
            echo $cadena = $imagen . $globo . "'>";
        }
    }

    //
    function campo_fecha($tipo, $nombre, $valor, $funcion = "", $ayuda = "") {
        $this->contcalendario++;
        $this->boton_tipo($tipo, $nombre, $valor, $funcion);
        $this->boton_tipo("button", "lanzador" . $this->contcalendario, "...", "");
        echo "\n<script type=\"text/javascript\">
		var cal" . $this->contcalendario . " = new Calendar.setup({
				 inputField     :    \"$nombre\",   // id of the input field
				 button         :    \"lanzador" . $this->contcalendario . "\",  // What will trigger the popup of the calendar
				//button	: \"$nombre\",
				 ifFormat       :    \"%d/%m/%Y\"       // format of the input field: Mar 18, 2005
		});
		</script>
                ";
    }

    //
    function campo_fecha_nacimiento($tipo, $nombre, $valor, $funcion = "", $ayuda = "") {
        $year = date("Y") - 13;
        $min = $year - 90;
        $this->contcalendario++;
        $this->boton_tipo($tipo, $nombre, $valor, $funcion);
        $this->boton_tipo("button", "lanzador" . $this->contcalendario, "...", "");
        echo "\n<script type=\"text/javascript\">
		var cal" . $this->contcalendario . " = new Calendar.setup({
				 inputField     :    \"$nombre\",   // id of the input field
				 button         :    \"lanzador" . $this->contcalendario . "\",  // What will trigger the popup of the calendar
				//button	: \"$nombre\",
				range         : [" . $min . ", " . $year . "],
				 ifFormat       :    \"%d/%m/%Y\"       // format of the input field: Mar 18, 2005
		});
		</script>
                ";
    }

    function ventana_emergente_submit($url, $nombre, $valor, $ancho, $alto, $form = "form1", $menubar = "no") {
        echo "<script LANGUAGE=\"JavaScript\">
	function  nuevaVentana(pagina,nombre,width,height){\n
	parametro=\"width=\"+width+\",height=\"+height+\",menubar=$menubar,scrollbars=yes,resizable=yes\";\n

	window.open(pagina,nombre,parametro);\n
	target=" . $form . ".target;\n
	action=" . $form . ".action;\n

	" . $form . ".target=nombre;\n
	" . $form . ".action=pagina;\n
	" . $form . ".submit();\n
	
	" . $form . ".target=target;\n
	" . $form . ".action=action;\n
	
	}
	</script>";
        $funcion = "onclick=\"nuevaVentana('" . $url . "','" . $nombre . "'," . $ancho . "," . $alto . ")\";";
        $this->boton_tipo("button", $nombre, $valor, $funcion);
    }

    function caja_chequeo($nombre, $valor, $check = '', $mensajeconfirma = '', $funcionadicional = "") {

        $cajachequeo = "<input type='checkbox' id='$nombre' name='$nombre'  value='$valor' $funcionadicional $check>";
        echo $cajachequeo;
    }

    //Dibuja una  caja de chequeo de tipo ajax
    function cajax_chequeo($nombre, $valorsi, $valorno, $archivo, $check = '', $mensajeconfirma = '', $tipogeneracion = 1, $funcionadicional = "") {
        if ($tipogeneracion) {
            echo "<input type='checkbox'  name='$nombre'  value='$valor' onclick='$funcionadicional return botecheckbox(\"$nombre\",$valorsi,$valorno,\"$archivo\",this,\"$mensajeconfirma\");' $check>";
        } else {
            $cajachequeo = "<input type='checkbox'  name='$nombre'  value='$valor' onclick='$funcionadicional return botecheckbox(\"$nombre\",$valorsi,$valorno,\"$archivo\",this,\"$mensajeconfirma\");' $check>";
            return $cajachequeo;
        }
    }

    //Dibuja varias  cajax_chequeo de tipo ajax
    function dibujar_cajax_chequeos($arrayparametroscajax, $archivo, $tipoestilo = 'labelresaltado', $funcionadicional = "") {
        for ($i = 0; $i < count($arrayparametroscajax); $i++) {
            $enunciado = $arrayparametroscajax[$i]["enunciado"];
            $nombre = $arrayparametroscajax[$i]["nombre"];
            $valorsi = $arrayparametroscajax[$i]["valorsi"];
            $valorno = $arrayparametroscajax[$i]["valorno"];
            $check = $arrayparametroscajax[$i]["check"];
            $campo = 'cajax_chequeo';
            $parametros = "'$nombre','$valorsi','$valorno','$archivo','$check','','1','$funcionadicional'";
            $this->dibujar_campo($campo, $parametros, "$enunciado", "labelresaltado", '$nombre', '');
        }
    }

    //
    function menu_fila($nombre, $selecciona, $condicion = "", $ayuda = "") {

        echo "<select name='$nombre' id='$nombre' $condicion>";
        while (list ($clave, $val) = each($this->filatmp)) {
            if ($selecciona == $clave)
                echo "<option value='$clave' selected>$val</option>";
            else
                echo "<option value='$clave'>$val</option>";
        }
        echo "</select>";
    }

    function label_fila($nombre, $selecciona, $condicion = "") {

        echo "<table width=100%><tr>";
        //while (list ($clave, $val) = each ($this->filatmp))
        foreach ($this->filatmp as $clave => $val)
            echo "<td>" . $clave . "</td>";
        echo "</tr>";

        echo "<tr>";

        $i = 0;
        foreach ($this->filatmp as $clave => $val) {
            /* if($i==0)
              echo "<td>".$val."</td>"; */

            echo "<td>" . $val . "</td>";
            //echo "<td>".$val."</td>";
            $i++;
        }
        //echo "<td>".$val."</td>";
        echo "</tr>";
        echo "</table>";
        unset($this->filatmp);
    }

    function radio_fila2($nombre, $selecciona, $condicion = "") {
        echo "<table width=100%><tr>";
        foreach ($this->filatmp as $clave => $val) {
            echo "<td>$val<input type=radio name='$nombre' id='$nombre' value='$clave' $condicion";
            if ($selecciona == $clave)
                echo " checked";
            echo "></td>";
        }
        echo "</tr></table>";
    }

    function radio_fila($nombre, $selecciona, $condicion = "") {

        echo "<table width='100%' border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align='left'><tr>";
        //while (list ($clave, $val) = each ($this->filatmp))
        /* foreach($this->filatmp as $clave => $val)
          echo "<td>".$val."</td>";
          echo "</tr>";

          echo "<tr>"; */
        $i = 0;
        foreach ($this->filatmp as $clave => $val) {
            if ($i == 0)
                echo "<td width='30%'>" . $val . "</td>";

            if ($selecciona == $clave)
                echo "<td><input type=radio name='$nombre' id='$nombre' value='$clave' $condicion checked></td>";
            else
                echo "<td><input type=radio name='$nombre' id='$nombre' value='$clave' $condicion ></td>";
            //echo "<td>".$val."</td>";
            $i++;
        }
        echo "<td width='30%'>" . $val . "</td>";
        echo "</tr>";
        echo "</table>";
    }

    function radio_fila_unico($nombre, $selecciona, $condicion = "", $clave = "", $val = "") {

        echo "<table align='left' border='0' cellspacing='0' cellpadding='0'><tr>";
        //while (list ($clave, $val) = each ($this->filatmp))
        /* foreach($this->filatmp as $clave => $val)
          echo "<td>".$val."</td>";
          echo "</tr>";

          echo "<tr>"; */
        //$i=0;

        echo "<td>" . $val . "</td>";

        if ($selecciona == $clave)
            echo "<td><input type=radio name='$nombre' id='$nombre' value='$clave' $condicion checked></td>";
        else
            echo "<td><input type=radio name='$nombre' id='$nombre' value='$clave' $condicion ></td>";
        //echo "<td>".$val."</td>";
        //$i++;
        //echo "<td>".$val."</td>";
        echo "</tr>";
        echo "</table>";
    }

    function menu_fila_multi($nombre, $selecciona, $tamano, $condicion = "") {

        echo "<select name='" . $nombre . "[]' id='" . $nombre . "' multiple='multiple' size='$tamano' $condicion>";
        while (list ($clave, $val) = each($this->filatmp)) {
            if ($selecciona == $clave)
                echo "<option value='$clave' selected>$val</option> require_once($urlcaptcha.'/securimage.php');";
            else
                echo "<option value='$clave'>$val</option>";
        }
        echo "</select>";
    }

    function captcha($id, $valor = "", $funcion = "") {
        echo "<table border='0' cellpadding='0' cellspacing='0' width=100% ><tr>";
        require_once($this->rutaraiz . 'securimage/securimage.php');
        echo "<td>";
        echo "<img id='captcha" . $id . "' id='captcha" . $id . "' src='" . $this->rutaraiz . "securimage/securimage_show.php' alt='CAPTCHA Image' />";
        echo "</td></tr><tr><td>";
        echo "<br>" . $this->boton_tipo("textfield", $id, $valor, $funcion);
        echo "</td></tr>";
        echo "</table>";
    }

    function cambiar_valor_campo($campo, $valor, $form = "form1") {
        echo "\n<script type=\"text/javascript\">
			var campo=document.getElementById('" . $campo . "');
			campo.value=\"" . $valor . "\";
		</script>\n
		";
    }

    //
    function campo_sugerido($tablas, $campollave, $camponombre, $condicion, $valorcampo, $valorcamponombre, $nombrecampo, $direccionsuggest, $imprimir = 0, $javascript = "") {

        $_SESSION["id" . $nombrecampo . 'tablas'] = $tablas;
        $_SESSION["id" . $nombrecampo . 'campollave'] = $campollave;
        $_SESSION["id" . $nombrecampo . 'camponombre'] = $camponombre;
        $_SESSION["id" . $nombrecampo . 'condicion'] = $condicion;

        echo "<script LANGUAGE=\"JavaScript\">
	var getFunctionsUrl = \"$direccionsuggest\";
	var " . $campollave . "functiononclick='" . $javascript . "';
	//alert(" . $campollave . "functiononclick);
	</script>";
//	echo "<div id='content' onclick='hideSuggestions();'>";
        echo "<input name='id$nombrecampo' type='text' id='id$nombrecampo' size='40' class='editParameter' onkeyup=\"handleKeyUp(event,this,'$campollave','$nombrecampo')\" value='$valorcamponombre'>";
        echo "<input name='" . $nombrecampo . "' type='hidden' id='" . $nombrecampo . "' value='$valorcampo'>";
        echo "<div id='scroll'></div>
		  <div id='suggest'></div>";
    }

    //
    function dibujar_campos($tipo, $parametros, $titulo, $estilo_titulo, $idtitulo, $tipo_titulo = "", $imprimir = 0, $tdcomentario = "") {
        echo "
			<tr>
			<td id='$estilo_titulo' $tdcomentario>";
        $this->etiqueta("$idtitulo", "$titulo", "$tipo_titulo");
        //echo "etiqueta($idtitulo,$titulo,$tipo_titulo);";
        echo "</td>
			<td $tdcomentario>";
        for ($i = 0; $i < count($tipo); $i++) {
            if ($imprimir)
                echo "\$this->" . $tipo[$i] . "(" . $parametros[$i] . ");";
            eval("\$this->" . $tipo[$i] . "(" . $parametros[$i] . ");");
        }
        $this->ayuda(@$ayuda);
        echo "</td>
	</tr><em></em>
	";
    }

    function dibujar_camposseparados($tipo, $parametros, $titulo, $estilo_titulo, $idtitulo, $tipo_titulo = "", $imprimir = 0, $tdcomentario = "", $ayuda = "") {
        echo "
			<tr>
			<td id='$estilo_titulo' $tdcomentario>";
        $this->etiqueta("$idtitulo", "$titulo", "$tipo_titulo");
        //echo "etiqueta($idtitulo,$titulo,$tipo_titulo);";
        echo "</td>";

        for ($i = 0; $i < count($tipo); $i++) {
            echo "<td $tdcomentario>";
            if ($imprimir)
                echo "\$this->" . $tipo[$i] . "(" . $parametros[$i] . ");";
            eval("\$this->" . $tipo[$i] . "(" . $parametros[$i] . ");");
            echo "</td>";
        }

        echo "
			
			</tr><em></em>
			";
    }

    //
    function dibujar_campo($tipo, $parametros, $titulo, $estilo_titulo, $idtitulo, $tipo_titulo = "", $imprimir = 0, $tdcomentario = "", $ayuda = "", $arraytamanoayuda = "") {
        echo "
			<tr>
			<td id='$estilo_titulo' $tdcomentario>";
        $this->etiqueta("$idtitulo", "$titulo", "$tipo_titulo");
        //echo "etiqueta($idtitulo,$titulo,$tipo_titulo);";
        echo "</td>
			<td $tdcomentario>";

        if ($imprimir)
            echo "\$this->" . $tipo . "(" . $parametros . ");";
        //echo $parametros;
        if (is_array($arraytamanoayuda) && count($arraytamanoayuda) > 0) {
            echo "<script LANGUAGE=\"JavaScript\">
						var ajaxtooltiptamanowidth='" . $arraytamanoayuda["width"] . "';
						var ajaxtooltiptamanoheight='" . $arraytamanoayuda["height"] . "';
				</script>";
        }
        eval("\$this->" . $tipo . "(" . $parametros . ");");
        $this->ayuda($ayuda);

        echo "
			</td>
			</tr>
			";
    }

    //
    function dibujar_fila_titulo($titulo, $estilo_titulo, $colspan = "2", $condicion = "", $tipotitulo = "label") {
        if ($tipotitulo == "label") {
            echo "<tr>
			<td colspan='$colspan' $condicion ><label id='$estilo_titulo'>$titulo</label></td>
			</tr>
            ";
        } else {
            echo "<tr>
			<td colspan='$colspan' $condicion id='$estilo_titulo'>$titulo</td>
			</tr>
            ";
        }
    }

    //
    function dibujar_filas_texto($fila, $idestilotitulos, $idestiloceldas, $comentariotitulo, $comentariocelda) {
        echo "<tr>";
        while (list ($clave, $val) = each($fila)) {
            $claves[] = $clave;
            $valores[] = $val;
        }
        for ($i = 0; $i < count($claves); $i++)
            echo "<td id='$idestilotitulos' $comentariotitulo>" . str_replace("_", " ", $claves[$i]) . "</td>\n";
        echo "</tr>";
        echo "<tr>";
        for ($i = 0; $i < count($valores); $i++)
            echo "<td id='$idestiloceldas' $comentariocelda>" . $valores[$i] . "</td>\n";
        echo "</tr>";
    }

    function dibujar_fila_texto($fila, $idestilotitulos, $idestiloceldas, $comentariotitulo, $comentariocelda) {
        echo "<tr>";
        for ($i = 0; $i < count($fila); $i++)
            echo "<td id='$idestiloceldas' $comentariocelda>" . $fila[$i] . "</td>\n";
        echo "</tr>";
    }

    //
    function recuperar_carrera($codigoestudiante) {
        $query = "select * from carrera c, estudiante e where codigoestudiante=" . $codigoestudiante .
                " and c.codigocarrera=e.codigocarrera";
        $operacion = $this->conexion->query($query);
        while ($row_operacion = $operacion->fetchRow()) {
            $nombrecortocarrera = $row_operacion['nombrecortocarrera'];
        }
        return $nombrecortocarrera;
    }

    //
    function recuperar_recurso_imagen($codigoestudiante, $nivel) {

        $query = "select ed.numerodocumento, ed.fechainicioestudiantedocumento,
	ed.fechavencimientoestudiantedocumento, u.linkidubicacionimagen,
	max(ed.idestudiantedocumento), ed.idestudiantegeneral
	from estudiantedocumento ed, estudiante e, ubicacionimagen u
	where ed.idestudiantegeneral = e.idestudiantegeneral
	and e.codigoestudiante = '$codigoestudiante'
	and u.idubicacionimagen like '1%'
	and u.codigoestado like '1%'
	group by ed.idestudiantegeneral
	order by 2 desc";
        /* 	$query="select ed.numerodocumento, ed.fechainicioestudiantedocumento, ed.fechavencimientoestudiantedocumento, u.linkidubicacionimagen
          from estudiantedocumento ed, estudiante e, ubicacionimagen u
          where ed.idestudiantegeneral = e.idestudiantegeneral
          and e.codigoestudiante = '$codigoestudiante'
          and u.idubicacionimagen like '1%'
          and u.codigoestado like '1%'
          order by 2 desc";
         */ //echo $query;
        $operacion = $this->conexion->query($query);
        //$row_operacion=$operacion->fetchRow();
        while ($row_operacion = $operacion->fetchRow()) {
            $link = substr($row_operacion['linkidubicacionimagen'], 9);
            $imagenjpg = $row_operacion['numerodocumento'] . ".jpg";
            $imagenJPG = $row_operacion['numerodocumento'] . ".JPG";
            //echo $imagecreator=$nivel.$link.$imagenJPG;
            //$linkimagen=$imagecreator;
            if (@imagecreatefromjpeg($nivel . $link . $imagenjpg)) {
                $linkimagen = $nivel . $link . $imagenjpg;
                break;
            } else if (@imagecreatefromjpeg($nivel . $link . $imagenJPG)) {
                $linkimagen = $nivel . $link . $imagenJPG;
                break;
            }
        }

        return $linkimagen;
    }

    //
    function dibujar_tabla_informacion_estudiante($nivel, $bordecolortabla = "#003333", $estiloceldavalor = "Estilo1", $estiloceldatitulo = "Estilo2", $colorfondoceldatitulo = "#C5D5D6") {

        echo "<table width='100%' border='2' align='center' cellpadding='2' bordercolor='$bordecolortabla'>
    <tr>
	<td>
	<table width='100%' border='0' align='center' cellpadding='0' bordercolor='$bordecolortabla'>
      <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Apellidos</div></td>
        <td class='$estiloceldavalor'>
          <div align='center'>";


        echo $this->array_datos_cargados['estudiantegeneral']->apellidosestudiantegeneral;
        echo "</div></td>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Nombres</div></td>
        <td class='$estiloceldavalor'><div align='center'>";

        echo $this->array_datos_cargados['estudiantegeneral']->nombresestudiantegeneral;
        echo "
		 </div></td>
        <td rowspan='6' valign='middle' class='$estiloceldavalor' align='center'>";
        /* $linkimagen=$this->recuperar_recurso_imagen($_GET['codigoestudiante'],$nivel); */
        echo "
          <div align='center'>";
        echo"<img src='";
        echo $linkimagen;
        echo "' width='80' height='120'></div></td>
      </tr>
      <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Tipo de Documento</div></td>
        <td class='$estiloceldavalor'><div align='center'>";
        $datosdocumento = $this->recuperar_datos_tabla('documento', 'tipodocumento', $this->array_datos_cargados['estudiantegeneral']->tipodocumento);
        echo $datosdocumento['nombredocumento'];
        echo "</div></td>
        <td colspan='1' bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>N&uacute;mero</div></td>
		<td colspan='1' class='$estiloceldavalor'><div align='center'>";
        echo $this->array_datos_cargados['estudiantegeneral']->numerodocumento;
        echo "</div></td>
        </tr>     
	  <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Expedido en</div></td>
        <td class='$estiloceldavalor'><div align='center'>";
        echo $this->array_datos_cargados['estudiantegeneral']->expedidodocumento;
        echo "</div></td>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Fecha de Nacimiento</div></td>
        <td class='$estiloceldavalor'><div align='center'>
        ";
        echo ereg_replace(' [0-9]+:[0-9]+:[0-9]+', '', $this->array_datos_cargados['estudiantegeneral']->fechanacimientoestudiantegeneral);
        echo "
        </div></td>
        </tr>
	   <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>G&eacute;nero</div></td>
        <td class='$estiloceldavalor'><div align='center'>";
        $datosgenero = $this->recuperar_datos_tabla('genero', 'codigogenero', $this->array_datos_cargados['estudiantegeneral']->codigogenero);
        echo $datosgenero['nombregenero'];
        echo "</div></td>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Id</div></td>
		<td class='$estiloceldavalor' ><div align='center'>";
        echo $this->array_datos_cargados['estudiantegeneral']->idestudiantegeneral;
        echo "</div></td>
        </tr>
      <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Celular</div></td>
        <td class='$estiloceldavalor'><div align='center'>";
        echo $this->array_datos_cargados['estudiantegeneral']->celularestudiantegeneral;
        echo "</div></td>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>E-mail</div></td>
		<td class='$estiloceldavalor' ><div align='center'>
        ";
        echo $this->array_datos_cargados['estudiantegeneral']->emailestudiantegeneral;
        echo "	</div></td>
        </tr>
      <tr>        
      <td  bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Dir. Estudiante</div></td>
      <td class='$estiloceldavalor'><div align='center'>";
        echo $this->array_datos_cargados['estudiantegeneral']->direccionresidenciaestudiantegeneral;
        echo "</div></td>
      <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Tel&eacute;fono</div></td>
      <td class='$estiloceldavalor'><div align='center'>";
        echo $this->array_datos_cargados['estudiantegeneral']->telefonoresidenciaestudiantegeneral;
        echo "</div></td>
      </tr>
      <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Dir. Correspondencia</div></td>
        <td class='$estiloceldavalor'><div align='center'>";
        echo $this->array_datos_cargados['estudiantegeneral']->direccioncorrespondenciaestudiantegeneral;
        echo "</div></td>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Tel&eacute;fono</div></td>
        <td class='$estiloceldavalor'><div align='center'>";
        echo $this->array_datos_cargados['estudiantegeneral']->telefonocorrespondenciaestudiantegeneral;
        echo "</div></td>
        <td class='$estiloceldavalor'>&nbsp;</td>
      </tr>
   
      <tr>
        <td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Carrera</div></td>
        <td class='$estiloceldavalor' ><div align='center'>";
        echo $this->recuperar_carrera($_GET['codigoestudiante']);
        echo "</div></td>";
        echo "<td bgcolor='$colorfondoceldatitulo' class='$estiloceldatitulo'><div align='center'>Ciudad</div></td>
       <td class='$estiloceldavalor'><div align='center'>" . $this->array_datos_cargados['estudiantegeneral']->nombreciudadresidenciaestudiantegeneral . "";
        echo "</div></td>";
        echo "<td class='$estiloceldavalor'></td>
      </tr>	  
	  	  
		</table>
		</table>";
    }

}

?>
