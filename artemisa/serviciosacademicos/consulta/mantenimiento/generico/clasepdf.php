<?
	/////////////////////////////////////////////////////
	// Autor: Moisés Márquez Gil
        // Versión: 0.2
	// Email: marquez_moi@gva.es
	// Fecha: 13/05/2003
	//
	// Descripción: Clase que encapsula parte de la funcionalidad
	// del API para crear documentos PDF para hacer más fácil
	// su utilización.
  //
	// Por hacer:
	//  · Pasar más funciones del API
	//  · Buscar la forma para que se calcule la variable $anchoMedio de los
	//    estilos y solucionar la funcion de escritura de texto subrayado.
	//  · Definir regiones de texto donde escribir. (Antes hace falta saber
	//    calcular el ancho del texto.
	define (\"_CODIF\", \"winansi\");
	define (\"_W_A4\", 595);
	define (\"_H_A4\", 842);
	
	class Estilos
	{
		var $Fuente;
		var $Puntos;
		// Valor medio del ancho del estilo, para aplicar los subrayados
		var $anchoMedio;
	}
	
	class Hojas
	{
		var $Ancho;
		var $Alto;
	}
	
	class PDF_doc
	{
		var $estilos;
		var $hojas;
		var $documento;
		var $estiloActual;

		function iniciarHojas ()
		{
			$this->hojas[\"A4 Vertical\"] = new Hojas;
			$this->hojas[\"A4 Vertical\"]->Ancho = _W_A4;
			$this->hojas[\"A4 Vertical\"]->Alto = _H_A4;
			$this->hojas[\"A4 Horizontal\"] = new Hojas;
			$this->hojas[\"A4 Horizontal\"]->Ancho = _H_A4;
			$this->hojas[\"A4 Horizontal\"]->Alto = _W_A4;
		}
		
		function iniciarEstilos ()
		{
			$this->estilos[\"Título 1\"] = new Estilos;
			$this->estilos[\"Título 1\"]->Fuente = \"Helvetica-Bold\";
			$this->estilos[\"Título 1\"]->Puntos = 12;
			$this->estilos[\"Título 2\"] = new Estilos;
			$this->estilos[\"Título 2\"]->Fuente = \"Helvetica\";
			$this->estilos[\"Título 2\"]->Puntos = 12;
			$this->estilos[\"Normal\"] = new Estilos;
			$this->estilos[\"Normal\"]->Fuente = \"Helvetica\";
			$this->estilos[\"Normal\"]->Puntos = 10;
			$this->estilos[\"Normal\"]->anchoMedio = 5.6;
			$this->estilos[\"Normal Negrita\"] = new Estilos;
			$this->estilos[\"Normal Negrita\"]->Fuente = \"Helvetica-Bold\";
			$this->estilos[\"Normal Negrita\"]->Puntos = 10;
		}

		function PDF_doc ()
		{
			$this->iniciarHojas ();
			$this->iniciarEstilos ();
			$this->documento = PDF_new ();
			PDF_open_file ($this->documento);
		}
		
		function finalizarDocumento ($nombre)
		{
			PDF_close ($this->documento);

			$buffer = PDF_get_buffer ($this->documento); 
			
			header (\"Content-type: application/pdf\");
			header (\"Content-Length: \" . strlen ($buffer));
			header (\"Content-Disposition: inline; filename=$nombre\");
			
			print $buffer;

			PDF_delete ($this->documento);
		}
		
		function aplicarEstilo ($nombre)
		{
			PDF_set_font ($this->documento, $this->estilos[$nombre]->Fuente,
				$this->estilos[$nombre]->Puntos, _CODIF);
			$this->estiloActual = $nombre;	
		}

		function nuevaPagina ($titulo, $tipoHoja)
		{
			PDF_begin_page ($this->documento, $this->hojas[$tipoHoja]->Ancho,
				$this->hojas[$tipoHoja]->Alto);
			PDF_add_outline ($this->documento, $titulo);	
		}

		function finalPagina ()
		{
			PDF_end_page ($this->documento);
		}

		function pintarCuadro ($colAbjIzq, $filAbjIzq, $ancho, $alto)
		{
			PDF_rect ($this->documento, $colAbjIzq, $filAbjIzq, $ancho, $alto);
			PDF_stroke ($this->documento);
		}

		function escribirXY ($texto, $columna, $fila)
		{
			PDF_show_xy ($this->documento, $texto, $columna, $fila);
		}

		function escribirXYSub ($texto, $columna, $fila)
		{
			$this->escribirXY ($texto, $columna, $fila);
			$colFinal = round ($columna + (strlen ($texto) * $this->estilos[$this->estiloActual]->anchoMedio));
			$this->pintarLinea ($columna, $fila - 2, $colFinal, $fila - 2);
		}

		function pintarLinea ($colIni, $filaIni, $colFinal, $filaFinal)
		{
			PDF_moveto ($this->documento, $colIni, $filaIni);
			PDF_lineto ($this->documento, $colFinal, $filaFinal);
			PDF_stroke ($this->documento);
		}

		function pintarCirculo ($col, $fila, $radio)
		{
			PDF_circle ($this->documento, $col, $fila, $radio);
			PDF_fill ($this->documento);
		}
	}	
?>