<?





function devuelve_validacion_revistas($Campos) 
{
	// Inserta las expresiones regulares 
	// Jscript previus sirve para validar todas las presencias alternativas
	// es decir si debe existir tal campo en combinación con tal otro y así sucesivamnete
	// Las expresiones regulares comprueban la forma una vez que existe, Eg:
	// Con el Jscript previous puedo comprobar si existe o el campo Nombre de Artículo
	// o el numero de página desde, con la exp.regular puedo comprobar que en caso de
	// existir, sea solo numérica... 
	

	if ($Campos[998][2]!="")
	{

       echo "   ".$Campos[998][3]."\n";
	}
	
	if ($Campos[1][2]!="")
	{

        echo "       if (document.forms.form1.elements['Titulo_Revista'].value!='')\n {";
		echo "         valor1 = ".$Campos[1][2].".exec(document.forms.form1.elements['Titulo_Revista'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[1][3]."'); return false; }\n }";
	}
	
	if ($Campos[2][2]!="")
	{

     echo "       if (document.forms.form1.elements['Volumen'].value!='')\n {";		
		echo "         valor1 = ".$Campos[2][2].".exec(document.forms.form1.elements['Volumen'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[2][3]."'); return false; }\n }";

	}

	if ($Campos[3][2]!="")
	{
    	echo "       if (document.forms.form1.elements['Numero'].value!='')\n {";		
		echo "         valor1 = ".$Campos[3][2].".exec(document.forms.form1.elements['Numero'].value);\n";
                     
        echo "         if (!valor1) {  alert ('".$Campos[3][3]."'); return false; }\n }";
        
	}
	
	if ($Campos[4][2]!="")
	{
		echo "       if (document.forms.form1.elements['AnioRevista'].value!='')\n {";		
		echo "         valor1 = ".$Campos[4][2].".exec(document.forms.form1.elements['AnioRevista'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[4][3]."'); return false; }\n }";
	}

	if ($Campos[5][2]!="")
	{
		echo "       if (document.forms.form1.elements['NombreArticulo']..value!='')\n {";		
		echo "         valor1 = ".$Campos[5][2].".exec(document.forms.form1.elements['NombreArticulo'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[5][3]."'); return false; }\n }";
	}

	if ($Campos[7][2]!="")
	{
		echo "       if (document.forms.form1.elements['PagDesde'].value!='')\n {";		
		echo "         valor1 = ".$Campos[7][2].".exec(document.forms.form1.elements['PagDesde'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[7][3]."'); return false; }\n }";
	}

	if ($Campos[8][2]!="")
	{
		echo "       if (document.forms.form1.elements['PagHasta'].value!='')\n {";		
		echo "         valor1 = ".$Campos[8][2].".exec(document.forms.form1.elements['PagHasta'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[8][3]."'); return false; }\n }";
	}
    echo "return true;";

}

function devuelve_validacion_libros($Campos) 
{
	
	if ($Campos[998][2]!="")
	{
		echo "   ".$Campos[998][3]."\n";
	}
	
	if ($Campos[1][2]!="")
	{
		echo "       if (document.forms.form1.elements['Titulo'].value!='')\n {";		
		echo "         valor1 = ".$Campos[1][2].".exec(document.forms.form1.elements['Titulo'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[1][3]."'); return false; }\n }";
	}
	
	if ($Campos[2][2]!="")
	{
    	echo "       if (document.forms.form1.elements['AutorTitulo'].value!='')\n {";		
		echo "         valor1 = ".$Campos[2][2].".exec(document.forms.form1.elements['AutorTitulo'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[2][3]."'); return false; }\n }";

	}

	if ($Campos[3][2]!="")
	{
    	echo "       if (document.forms.form1.elements['Editorial'].value!='')\n {";		
		echo "         valor1 = ".$Campos[3][2].".exec(document.forms.form1.elements['Editorial'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[3][3]."'); return false; }\n }";

	}
	
	if ($Campos[4][2]!="")
	{
		echo "       if (document.forms.form1.elements['AnioLibro'].value!='')\n {";		
		echo "         valor1 = ".$Campos[4][2].".exec(document.forms.form1.elements['AnioLibro'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[4][3]."'); return false; }\n }";
	}

	if ($Campos[6][2]!="")
	{
		echo "       if (document.forms.form1.elements['Capitulo_Libro']..value!='')\n {";		
		echo "         valor1 = ".$Campos[6][2].".exec(document.forms.form1.elements['Capitulo_Libro'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[6][3]."'); return false; }\n }";
	}

	if ($Campos[8][2]!="")
	{
		echo "       if (document.forms.form1.elements['PagDesde'].value!='')\n {";		
		echo "         valor1 = ".$Campos[8][2].".exec(document.forms.form1.elements['PagDesde'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[8][3]."'); return false; }\n }";
	}

	if ($Campos[9][2]!="")
	{
		echo "       if (document.forms.form1.elements['PagHasta'].value!='')\n {";		
		echo "         valor1 = ".$Campos[9][2].".exec(document.forms.form1.elements['PagHasta'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[9][3]."'); return false; }\n }";
	}

}

function devuelve_validacion_congresos($Campos) 
{    echo " /* entro*/ ";
	
	if ($Campos[998][2]!="")
	{
		echo "   ".$Campos[998][3]."\n";
	}
	
	if ($Campos[1][2]!="")
	{
		echo "       if (document.forms.form1.elements['TituloCongreso'].value!='')\n {";		
		echo "         valor1 = ".$Campos[1][2].".exec(document.forms.form1.elements['TituloCongreso'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[1][3]."'); return false; }\n }";
	}
	
	if ($Campos[2][2]!="")
	{
    	echo "       if (document.forms.form1.elements['Organizador'].value!='')\n {";		
		echo "         valor1 = ".$Campos[2][2].".exec(document.forms.form1.elements['Organizador'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[2][3]."'); return false; }\n }";

	}

	if ($Campos[3][2]!="")
	{
    	echo "       if (document.forms.form1.elements['NumeroLugar'].value!='')\n {";		
		echo "         valor1 = ".$Campos[3][2].".exec(document.forms.form1.elements['NumeroLugar'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[3][3]."'); return false; }\n }";

	}
	
	if ($Campos[4][2]!="")
	{
		echo "       if (document.forms.form1.elements['AnioCongreso'].value!='')\n {";		
		echo "         valor1 = ".$Campos[4][2].".exec(document.forms.form1.elements['AnioCongreso'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[4][3]."'); return false; }\n }";
	}

	if ($Campos[5][2]!="")
	{
		echo "       if (document.forms.form1.elements['PaginaCapitulo'].value!='')\n {";		
		echo "         valor1 = ".$Campos[5][2].".exec(document.forms.form1.elements['PaginaCapitulo'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[5][3]."'); return false; }\n }";
	}

	if ($Campos[6][2]!="")
	{
		echo "       if (document.forms.form1.elements['PonenciaActa'].value!='')\n {";		
		echo "         valor1 = ".$Campos[6][2].".exec(document.forms.form1.elements['PonenciaActa'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[6][3]."'); return false; }\n }";
	}

	if ($Campos[8][2]!="")
	{
		echo "       if (document.forms.form1.elements['OtroPaisCongreso'].value!='')\n {";		
		echo "         valor1 = ".$Campos[8][2].".exec(document.forms.form1.elements['OtroPaisCongreso'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[8][3]."'); return false; }\n }";
	}


}

function devuelve_validacion_patentes($Campos) 
{
	
	if ($Campos[998][2]!="")
	{
		echo "   ".$Campos[998][3]."\n";
	}
	
	if ($Campos[1][2]!="")
	{
		echo "       if (document.forms.form1.elements['NumeroPatente'].value!='')\n {";		
		echo "         valor1 = ".$Campos[1][2].".exec(document.forms.form1.elements['NumeroPatente'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[1][3]."'); return false; }\n }";
	}
	

	if ($Campos[3][2]!="")
	{
    	echo "       if (document.forms.form1.elements['OtroPais'].value!='')\n {";		
		echo "         valor1 = ".$Campos[3][2].".exec(document.forms.form1.elements['OtroPais'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[3][3]."'); return false; }\n }";

	}
	
	if ($Campos[4][2]!="")
	{
		echo "       if (document.forms.form1.elements['AnioPatente'].value!='')\n {";		
		echo "         valor1 = ".$Campos[4][2].".exec(document.forms.form1.elements['AnioPatente'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[4][3]."'); return false; }\n }";
	}


}

function devuelve_validacion_tesis($Campos) 
{  
	
	if (isset($Campos[998][2]) && ($Campos[998][2] != ""))
	{
	
		echo "   ".$Campos[998][3]."\n";
	
	}
	
	if (isset($Campos[1][2]) && ($Campos[1][2] != ""))
       {
	
		echo "       if (document.forms.partea.elements['TituloTesis'].value!='')\n {";		
		echo "         valor1 = ".$Campos[1][2].".exec(document.forms.partea.elements['TituloTesis'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[1][3]."'); return false; }\n }";

	}
	

	if (isset($Campos[2][2]) && ($Campos[2][2] != ""))
      {
    	echo "       if (document.forms.partea.elements['AutorTesis'].value!='')\n {";		
		echo "         valor1 = ".$Campos[2][2].".exec(document.forms.partea.elements['AutorTesis'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[2][3]."'); return false; }\n }";

	}
	
	if (isset($Campos[3][2]) && ($Campos[3][2] != ""))
	{
		echo "       if (document.forms.partea.elements['DirectorTesis'].value!='')\n {";		
		echo "         valor1 = ".$Campos[3][2].".exec(document.forms.partea.elements['DirectorTesis'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[3][3]."'); return false; }\n }";
	}
	
	if (isset($Campos[4][2]) && ($Campos[4][2] != ""))
	{
		echo "       if (document.forms.partea.elements['GradoAccede'].value!='')\n {";		
		echo "         valor1 = ".$Campos[4][2].".exec(document.forms.partea.elements['GradoAccede'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[4][3]."'); return false; }\n }";
	}

	if (isset($Campos[5][2]) && ($Campos[5][2] != ""))
	{
		echo "       if (document.forms.partea.elements['AnioTesis'].value!='')\n {";		
		echo "         valor1 = ".$Campos[5][2].".exec(document.forms.partea.elements['AnioTesis'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[5][3]."'); return false; }\n }";
	}
	
	if (isset($Campos[6][2]) && ($Campos[6][2] != ""))
	{
	
		echo "       if (document.forms.partea.elements['PagCapitulo'].value!='')\n {";		
		echo "         valor1 = ".$Campos[6][2].".exec(document.forms.partea.elements['PagCapitulo'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[6][3]."'); return false; }\n }";
	}

	if (isset($Campos[8][2]) && ($Campos[8][2] != ""))
	{
		echo "       if (document.forms.partea.elements['OtroPaisTesis'].value!='')\n {";		
		echo "         valor1 = ".$Campos[8][2].".exec(document.forms.partea.elements['OtroPaisTesis'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[8][3]."'); return false; }\n }";
	}

	if (isset($Campos[10][2]) && ($Campos[10][2] != ""))
	{
		echo "       if (document.forms.partea.elements['OtraInstitucionTesis'].value!='')\n {";		
		echo "         valor1 = ".$Campos[10][2].".exec(document.forms.partea.elements['OtraInstitucionTesis'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[10][3]."'); return false; }\n }";
	}
	
	if (isset($Campos[12][2]) && ($Campos[12][2] != ""))
	{
		echo "       if (document.forms.partea.elements['OtraDependenciaTesis'].value!='')\n {";		
		echo "         valor1 = ".$Campos[12][2].".exec(document.forms.partea.elements['OtraDependenciaTesis'].value);\n";
		echo "         if (!valor1) {  alert ('".$Campos[12][3]."'); return false; }\n }";
	}


}


?>
