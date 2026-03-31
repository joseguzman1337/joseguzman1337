<?php

/** 
 * Clase Paginado
 *  
 * Clase que permite la consulta a bases de datos
 * mientras que ofrece un sistema de paginado y 
 * navegación de resultados de manera automática.
 *
 * @author Webstudio <ws2000@web-studio.com.ar>
 * @version 0.1
 **/
class paginado
{
    /**
     * Identificador de recurso de conexion a la Base de Datos.
     *
     * Este atributo es pasado al objeto en el momento de instanciarlo.
	 * Debe ser un recurso válido
     * @access private
     * @since 25/02/2002 05:29:43 p.m.
     **/
    var $_conn;
	
	/**
	 * Información interna de Error
	 *
	 * Contiene información sobre el último error generado en la ejecución
	 * del objeto.
	 * @access private
	 * @since 25/02/2002 05:30:27 p.m.
	 **/
	var $_error;
	
	/**
	 * Página actual de Resultados.
	 *
	 * Indica que página actual de resultados es la que se quiere pedir de
	 * la base.
	 * @access private
	 * @since 25/02/2002 05:56:59 p.m.
	 **/
	var $_pagina;
	
	/**
	 * Resultados por cada página.
	 *
	 * Indica la cantidad de resultados que poseerá cada página de resultados.
	 * @access private
	 * @since 25/02/2002 05:31:22 p.m.
	 **/
	var $_porPagina = 10;
	
	/**
	 * Query SQL provisto por el usuario.
	 *
	 * Este Query debe ser un SELECT, sin la sentencia LIMIT (es agregada
	 * automáticamente por el Objeto).
	 * De no ser una sentencia SQL válida o si contiene algún tipo de 
	 * error, el objeto cancelará su ejecución devolviendo FALSE y seteando
	 * internamente un mensaje de error.
	 * @access private
	 * @since 25/02/2002 05:31:51 p.m.
	 **/
	var $_query;
	
	/**
	 * Identificador de Recurso de ResultSet.
	 *
	 * Contiene el identificador de resurso de las consultas realizadas
	 * en la base de datos.
	 * @access private
	 * @since 25/02/2002 05:54:45 p.m.
	 **/
	var $_rs;
	
	/**
	 * Total de Resultados.
	 *
	 * Indica la cantidad total de resultados que devuelve la consulta
	 * contenida en _query.
	 * @access private
	 * @since 26/02/2002 11:12:57 a.m.
	 **/
	var $_total;

	/**
	 * Total de Páginas.
	 *
	 * Indica la cantidad total de páginas que devuelve la consulta
	 * contenida en _query.
	 * @access private
	 * @since 26/02/2002 12:23:20 p.m.
	 **/
	var $_totalPaginas;
	
	/**
	 * Total de Registros.
	 *
	 * Indica la cantidad de registros leidos en la última consulta
	 * desde la base de datos.
	 * @access private
	 * @since 26/02/2002 12:17:22 p.m.
	 **/
	var $_registros;
	
	/**
	 * Código de Siguiente.
	 *
	 * Este atributo contiene el código HTML que representará al link
	 * para avanzar a la siguiente página de resultados.
	 * Puede ser cualquier código HTML permitido dentro dentro de un 
	 * tag <A>.
	 * @access private
	 * @since 26/02/2002 01:53:58 p.m.
	 **/
	var $_siguiente = "Siguiente >";
	
	/**
	 * Código de Anterior.
	 *
	 * Este atributo contiene el código HTML que representará al link
	 * para retroceder a la página anterior de resultados.
	 * Puede ser cualquier código HTML permitido dentro dentro de un 
	 * tag <A>.
	 * @access private
	 * @since 26/02/2002 01:54:04 p.m.
	 **/
	var $_anterior = "< Anterior";
	
	/**
	 * Constructor de la clase
	 * 
	 * Recibe como parámetro un link hacia la base de datos y lo guarda.
	 * @since 26/02/2002 10:29:09 a.m.
	 * @return 
	 **/
	function paginado($Conn)
	{
		$this->conn($Conn);
	} // function
	
    /**
     * Método para acceder a $_conn
     *
     * @access public
     * @since 25/02/2002 05:29:59 p.m.
     **/
    function conn()
    {
    	switch (func_num_args())
    	{
    		case 1:
    			$this->_conn = func_get_arg(0);
    		break;
    		default:
    			return $this->_conn;
    		break;
    	}
    } // function
	
	/**
	 * Método para acceder a $_error
	 *
	 * @access public
	 * @since 25/02/2002 05:30:39 p.m.
	 **/
	function error()
	{
		switch (func_num_args())
		{
			case 1:
				$this->_error = func_get_arg(0);
			break;
			default:
				return $this->_error;
			break;
		}
	} // function
	
	/**
	 * Método para acceder a $_pagina
	 *
	 * @access public
	 * @since 25/02/2002 05:57:18 p.m.
	 **/
	function pagina()
	{
		switch (func_num_args())
		{
			case 1:
				$this->_pagina = func_get_arg(0);
				$this->_pagina = empty($this->_pagina)?1:$this->_pagina;
			break;
			default:
				return $this->_pagina;
			break;
		}
	} // function

	/**
	 * Método para acceder a $_porPagina
	 *
	 * @access public
	 * @since 25/02/2002 05:31:31 p.m.
	 **/
	function porPagina()
	{
		switch (func_num_args())
		{
			case 1:
				$this->_porPagina = func_get_arg(0);
			break;
			default:
				return $this->_porPagina;
			break;
		}
	} // function
	
	/**
	 * Método para acceder a $_total
	 *
	 * @access public
	 * @since 26/02/2002 11:13:19 a.m.
	 **/
	function total()
	{
		switch (func_num_args())
		{
			case 1:
				$this->_total = func_get_arg(0);
			break;
			default:
				return $this->_total;
			break;
		}
	} // function
	
	/**
	 * Método para acceder a $_totalPaginas
	 *
	 * @access public
	 * @since 26/02/2002 12:22:59 p.m.
	 **/
	function totalPaginas()
	{
		switch (func_num_args())
		{
			case 1:
				$this->_totalPaginas = func_get_arg(0);
			break;
			default:
				return $this->_totalPaginas;
			break;
		}
	} // function
	
	/**
	 * Método para acceder a $_rs
	 *
	 * En caso de ser un link inválido, el método retorna FALSE.
	 * @access public
	 * @since 25/02/2002 05:55:15 p.m.
	 **/
	function rs()
	{
		switch (func_num_args())
		{
			case 1:
				$this->_rs = func_get_arg(0);
				if(!$this->_rs)
				{
					return false;
				}// Fin If
				return true;
			break;
			default:
				return $this->_rs;
			break;
		}
	} // function
	
	/**
	 * Método para acceder a $_registros
	 *
	 * @access public
	 * @since 26/02/2002 12:17:44 p.m.
	 **/
	function registros()
	{
		switch (func_num_args())
		{
			case 1:
				$this->_registros = func_get_arg(0);
			break;
			default:
				return $this->_registros;
			break;
		}
	} // function

	/**
	 * Retorna el indice dentro del Result Set del primer
	 * elemento de la página actual.
	 * 
	 * @since 26/02/2002 12:00:12 p.m.
	 * @return 
	 **/
	function desde()
	{
		return (($this->pagina()-1)*$this->porPagina())+1;
	} // function
	
	/**
	 * Retorna el índice dentro del Result Set del último
	 * elemento de la página actual.
	 *
	 * @since 26/02/2002 12:18:08 p.m.
	 * @return 
	 **/
	function hasta()
	{
		return ($this->desde()-1)+$this->registros();
	} // function
	
	/**
	 * Ejecuta el Query el base, averiguando previamente la cantidad total de 
	 * registros que devuelve la consulta
	 *
	 * @access public
	 * @since 25/02/2002 05:31:59 p.m.
	 **/
	function query($query)
	{
		// Primero modificamos el query para averiguar la cantidad total
		// de registros que devuelve el query.
		$query_count = eregi_replace("select (.*) from", "SELECT COUNT(*) FROM",$query);
		if(!$this->rs( @mysql_query($query_count, $this->conn()) ))
		{
			$this->error("Ocurrió un error al ejecutar el query <i><b>\"$query_count\"</b></i>. La base dijo : <b>".mysql_error()."</b>.");
			return false;
		}// Fin If
		$this->total( mysql_result($this->rs(), 0) );
		$this->totalPaginas(ceil($this->total() / $this->porPagina()));

		// Comprobamos que no se intenta acceder a una página que no existe.
		if( $this->pagina() > $this->totalPaginas() )
		{
			$this->error("No exite la página ".$this->pagina()." de resutados. Hay solo un total de ".$this->totalPaginas());
			return false;
		}// Fin If

		// Ahora modificamos el Query del usuario, para poder agregarle
		// los límites para realizar la paginación
		$query .= " LIMIT ".($this->desde()-1).",".$this->porPagina();
		if(!$this->rs( @mysql_query($query, $this->conn()) ))
		{
			$this->error("Ocurrió un error al ejecutar el query \"$query\". La base dijo : ".mysql_error());
			return false;
		}// Fin If
		$this->registros( mysql_num_rows( $this->rs() ));
		return true;
	} // function

	/**
	 * Retorna un Array asociativo con los datos del siguiente
	 * registro dentro del Result Set.
	 *
	 * @since 26/02/2002 11:21:46 a.m.
	 * @return 
	 **/
	function obtenerArray()
	{
		return mysql_fetch_array( $this->rs() );
	} // function

	/**
	 * Despliega el link hacia la siguiente página
	 *
	 * Siempre que quede una página siguiente, se muestra un link
	 * hacia la siguiente página de resultados.
	 * El método acepta ser llamado con un parámetro que contenga el
	 * código HTML que representará al link y que pueda ser representado
	 * encerrado dentro de un tag <A>.
	 * @access public
	 * @since 26/02/2002 01:49:29 p.m.
	 **/
	function siguiente()
	{
		switch (func_num_args())
		{
			case 1:
				$this->_siguiente = func_get_arg(0);
			default:
				if($this->hasta() < $this->total())
				{
					return "<a href=\"?pagina=".($this->pagina()+1).$this->propagar()."\">".$this->_siguiente."</a>";
				}// Fin If
			break;
		}
	} // function	
	
	/**
	 * Despliega el link hacia la página anterior.
	 *
	 * Siempre que no estemos en la primer página, se muestra un link
	 * hacia la página anterior de resultados.
	 * El método acepta ser sllamado con un parámetro que contenga el
	 * código HTML que representará al link y que pueda ser representado
	 * encerrado dentro de un tag <A>.
	 * @access public
	 * @since 26/02/2002 01:49:29 p.m.
	 **/
	function anterior()
	{
		switch (func_num_args())
		{
			case 1:
				$this->_anterior = func_get_arg(0);
			default:
				if($this->pagina() != 1)
				{
					return "<a href=\"?pagina=".($this->pagina()-1).$this->propagar()."\">".$this->_anterior."</a>";
				}// Fin If
			break;
		}
	} // function
	
	/**
	 * Despliega los números de páginas posibles
     *
     * Este método muestra una lista de todas las páginas posibles como
	 * links, excepto la página actual, que se encuentra sin link y resaltada
	 * en negrita.
	 * @since 26/02/2002 02:15:36 p.m.
	 * @return 
	 **/
	function nroPaginas()
	{
		for($i = 1; $i <= $this->totalPaginas() ; $i++)
		{
			$temp[$i] = "<a href=\"?pagina=$i".$this->propagar()."\">$i</a>";
		} // for
		$temp[$this->pagina()] = "<b>".$this->pagina()."</b>";
		return implode(" | ", $temp);
	} // function
	
	/**
	 * Indica que variables se desean propagar en los links.
     *
     * Este metodo recibe una lista de nombres que son guarados internamente
	 * hasta que son creados los links para navegar los resultados. En ese 
	 * momento, son agregados los nombres de las variables con sus valores
	 * para que puedan ser propagados.
	 * @since 26/02/2002 02:15:36 p.m.
	 * @return 
	 **/
	function propagar()
	{
        switch(func_num_args()){
            case 0: 
                foreach($this->_variables as $var)
                    $ret.= "&$var=".$GLOBALS[$var];
                return $ret;
                break;
            default:
                for($i = 0; $i < func_num_args(); $i++)
                {
                    $this->_variables[] = func_get_arg($i);
                } // for
                break;
        } // switch
	} // function


} // end of class
?>
