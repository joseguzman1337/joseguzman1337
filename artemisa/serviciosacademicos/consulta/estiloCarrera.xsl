<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="resultado">
   <html>
   <body>
    <strong>Seleccione Carrera</strong>
    <table border="1">
      <tr>
        <td id="tdtitulogris">Codigo</td>
        <td id="tdtitulogris">Nombre</td>
      </tr>
   <xsl:for-each select="carreras">
   <tr>
	<td align="center"><xsl:value-of select="codigocarrera"/></td>	
	<td>
		<xsl:element name="a">
		<xsl:attribute name = "href">#</xsl:attribute>
		<xsl:attribute name = "onclick">seleccionaCarrera(<xsl:value-of select="codigocarrera" />)</xsl:attribute>
		<xsl:value-of select="nombrecarrera"/>
		</xsl:element>
	</td>
	</tr>
   </xsl:for-each>
   </table>
   </body>
   </html>
</xsl:template> 
</xsl:stylesheet>
