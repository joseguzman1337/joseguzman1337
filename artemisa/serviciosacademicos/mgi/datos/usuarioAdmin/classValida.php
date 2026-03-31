<?php

class Valida{
	public function comprobarLargo($nombre_usuario){
		//compruebo que el tamaño del string sea válido.
	   if (strlen($nombre_usuario)<3 || strlen($nombre_usuario)>25){
		  echo " <script>alert('La cantidad de caracteres digitados debe estar entre 3 y 25 permitidos');</script>";
		  die;
	   }
	}
	public function comprobar_nombre_usuario($nombre_usuario){
	   //compruebo que los caracteres sean los permitidos
	   $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_.";
	   for ($i=0; $i<strlen($nombre_usuario); $i++){
		  if (strpos($permitidos, substr($nombre_usuario,$i,1))===false){
			echo "<script> alert('El usuario digitado no es válido') ;</script>";
			exit();
		  }
	   }
	   
	   return true;
	}
	public function validarString($valor){
		/*
         * Caso 94006.
         * @modified Luis Dario Gualteros 
         * <castroluisd@unbosque.edu.co>
         * Se modifica la expresión regular para que permita el ingreso de caracteres especiales.
         * @since Septiembre 18 de 2017
        */
        $permitidos = '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s.,]*$/';
        // End Caso 94006.
		if(empty($valor))
		 {
			   return false; // Campo vacio no validar
		  }
		  else
		 {
			   if (preg_match($permitidos,$valor))
			  {
					return false; // Campo permitido 
			  } 
			  else 
			  { 
					echo " <script>alert('Los caracteres digitados no son validos');</script>";
					die; // Error uno de los caracteres no hace parte de la expresión regular 
			  } 
		 } 
	}
	public function validaVacio($dato){
		
		if($dato === ""){
			echo '<script>alert("No fue posible guardar los cambios recuerde que debe digitar los campos completos");</script>';
			die;
		}
	}
	public function esNumerico($dato){
		if(is_numeric($dato)==false){
			echo '<script>alert("Recuerde que debe digitar solo números en el número de documento");</script>';
			exit;
		}
	}
	public function validaFecha($dato){
		
		$d = DateTime::createFromFormat('Y-m-d', $dato);
		if(!($d && $d->format('Y-m-d') == $dato))
		{
			echo '<script>alert("Debe digitar una fecha de vencimiento correcta con el formato Y-m-d");</script>';
			exit;
		}
		
	}
	public function validaFormato($input,$format="ymd"){
		      $separator_type= array(
            "-"
        );
        foreach ($separator_type as $separator) {
            $find= stripos($input,$separator);
            if($find<>false){
                $separator_used= $separator;
            }
        }
        $input_array= explode($separator_used,$input);
        if ($format=="mdy") {
            return checkdate($input_array[0],$input_array[1],$input_array[2]);
        } elseif ($format=="ymd") {
            return checkdate($input_array[1],$input_array[2],$input_array[0]);
        } else {
            return checkdate($input_array[1],$input_array[0],$input_array[2]);
        }
        $input_array=array();
	}
	public function VerificarrDireccionCorreo($direccion)
	{
	   $Sintaxis='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
	   if(preg_match($Sintaxis,$direccion))
	      return true;
	   else
	     	echo $direccion. '<script>alert("La dirección de correo no tiene un formato valido");</script>';
			exit;
	}
	public function alfanumerico($dato){
		if (preg_match("/\\A(\\w|\\#| |\\@|\\$|\\%|\\&|\\*|\\(|\\))*\\Z/",$dato)) {
		   
		} else {
		   echo $dato. '<script>alert("Existen caracteres invalidos en el formulario");</script>';
			exit;
		} 
	}
}