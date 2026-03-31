<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:variable name="t">
	<xsl:for-each select="data/params">
		<xsl:call-template name="escogetotalpaginas">
					<xsl:with-param name="i" >
						<xsl:value-of select="total_pages" />
					</xsl:with-param>
		</xsl:call-template>
	</xsl:for-each>
</xsl:variable>

<xsl:variable name="p">
<xsl:for-each select="data/params">
<xsl:value-of select="returned_page" />
</xsl:for-each>
</xsl:variable>
		<xsl:variable name="con">
		<xsl:value-of select="1" />
		</xsl:variable>

<xsl:variable name="tabla">
<xsl:for-each select="data/params">
<xsl:value-of select="tablaseleccionada" />
</xsl:for-each>
</xsl:variable>


<xsl:template name="sume">
	<xsl:param name="i"/>
	<xsl:choose>
	<xsl:when test="$i=0">seleccionar</xsl:when>
	<xsl:otherwise>
		<xsl:call-template name="sume">
			<xsl:with-param name="i" select="$i - 1" />
		</xsl:call-template>
			<xsl:element name="option">
			<xsl:attribute name="value">
			<xsl:value-of select="$i" />
			</xsl:attribute>
				<xsl:choose>
					<xsl:when test="$i=$p">
						<xsl:attribute name="selected">
						</xsl:attribute>
					</xsl:when>
				</xsl:choose>
			<xsl:value-of select="$i" />
			</xsl:element>
	</xsl:otherwise>
	</xsl:choose>
</xsl:template>	

<xsl:template name="escogetabla">
	<xsl:param name="i"/>
	<xsl:choose>
		<xsl:when test="$i=$tabla">
			<xsl:attribute name="selected">
			</xsl:attribute>
		</xsl:when>
	</xsl:choose>
</xsl:template>



<xsl:template name="escogeclasefila">
	<xsl:param name="i"/>
	<xsl:choose>
	<xsl:when test="$i mod 2 = 0">filapar</xsl:when>
	<xsl:otherwise>filainpar</xsl:otherwise>
	</xsl:choose>
</xsl:template>	

<xsl:template name="escogetotalpaginas">
	<xsl:param name="i"/>
	<xsl:choose>
	<xsl:when test="$i > 5000">5000</xsl:when>
	<xsl:otherwise>
		<xsl:value-of select="$i"/>
	</xsl:otherwise>
	</xsl:choose>
</xsl:template>	



<xsl:template match="/">
<table width="500">
<tr><td>
<h2>
	<xsl:element name="a">
	<xsl:attribute name="onclick">return ventanaAutoFormulario('<xsl:value-of select="$tabla" />');</xsl:attribute>
	<xsl:attribute name="style">cursor:hand</xsl:attribute>
	<xsl:value-of select="$tabla" />
	</xsl:element>
</h2>

<table class="list2">
<tr><td>
<select id="columnastabla" class="selParam" onchange="cambietabla(this)">
<xsl:for-each select="data/tablas">
		<xsl:element name="option">
			<xsl:attribute name="value">
				<xsl:value-of select="tab"/>
			</xsl:attribute>
				<xsl:call-template name="escogetabla">
						<xsl:with-param name="i">
							<xsl:value-of select="tab"/>
						</xsl:with-param>
				</xsl:call-template>
		<xsl:value-of select="tab"/>
	</xsl:element>
</xsl:for-each>
</select>
</td></tr>

<tr><td>
<select id="columnastabla" class="selParam" onchange="cambiecolumna(this)">
<xsl:for-each select="data/columnas">
		<xsl:element name="option">
			<xsl:attribute name="value">
				<xsl:number value="position()" format="1" />
			</xsl:attribute>
		<xsl:value-of select="col"/>
	</xsl:element>
</xsl:for-each>
</select>
</td></tr>


<tr><td>
<input name="parametros" type="text" id="parametros" class="editParameter" onkeyup="handleKeyUp(event,this)"/>
<input type="button" name="enviaparametros" id="enviaparametros" value="Reset" onclick="resetParameter()" />

<div id="scroll"></div>
<div id="suggest"></div>
</td></tr>
</table>
<xsl:call-template name="menu"/>
</td><td>
	<xsl:choose>
	<xsl:when test="$tabla='Interesados'">
		<div id="framecorreomasivo"><iframe src='correomasivo.php' height="200" width="600"></iframe></div>
	</xsl:when>
	</xsl:choose>

</td></tr></table>
<form id="grid_form_id">

<table class="list" id="tablagrid">
<tr>
<xsl:for-each select="data/columnas">
		<th><xsl:element name="div">
			<xsl:attribute name="title">
				<xsl:value-of select="col"/>
			</xsl:attribute>
			<xsl:attribute name="id">c<xsl:number value="position()" format="1" /></xsl:attribute>

		<xsl:element name="a">
			<xsl:attribute name="name">
				<xsl:value-of select="col"/>
			</xsl:attribute>
			<xsl:attribute name="href">
			</xsl:attribute>

			<xsl:attribute name="onclick">
					return enviaOrdenColumna("<xsl:value-of select="col"/>");
			</xsl:attribute>
			<xsl:value-of select="col"/>
		</xsl:element>

	</xsl:element>
	</th>
</xsl:for-each>
</tr>
<tr>

<xsl:for-each select="data/columnas">
	<th align="left">
		<xsl:element name="input">
			<xsl:attribute name="name">
				<xsl:number value="position()" format="1" />
			</xsl:attribute>
			<xsl:attribute name="id">
				<xsl:number value="position()" format="1" />
			</xsl:attribute>
			<xsl:attribute name="class">editColum</xsl:attribute>
			<xsl:attribute name="onkeyup">handleKeyUp(event,this)</xsl:attribute>
		</xsl:element>
	</th>
</xsl:for-each>

		<!--<xsl:element name="div">
			<xsl:attribute name="id">scroll</xsl:attribute>
		</xsl:element>
		<xsl:element name="div">
			<xsl:attribute name="id">suggest</xsl:attribute>
		</xsl:element>-->

</tr>

<xsl:for-each select="data/grid/row">
	<xsl:element name="tr">
			<xsl:attribute name="class">
				<xsl:call-template name="escogeclasefila">
					<xsl:with-param name="i">
						<xsl:number level='multiple' count='row' />
					</xsl:with-param>
				</xsl:call-template>
			</xsl:attribute>

	<xsl:attribute name="id">tr<xsl:value-of select="id"/></xsl:attribute>
	<xsl:attribute name="onclick">modificarFila(<xsl:value-of select="id"/>)</xsl:attribute>
			<xsl:for-each select="column">
				<td><xsl:element name="div">

				<xsl:attribute name="id">f_<xsl:number level='multiple' count='row' />_<xsl:number level='multiple' count='column'  /></xsl:attribute>
				<xsl:value-of select="campo" />
				</xsl:element>
				</td>
			</xsl:for-each>

		<!--<td>
		<xsl:choose>
			<xsl:when test="on_promotion &gt; 0">
				<input type="checkbox" name="on_promotion"
				disabled="disabled" checked="checked"/>
			</xsl:when>
			<xsl:otherwise>
				<input type="checkbox" name="on_promotion" disabled="disabled"/>
			</xsl:otherwise>
		</xsl:choose>
		</td>
		<td>
		<xsl:element name="a">
		<xsl:attribute name = "href">#</xsl:attribute>
		<xsl:attribute name = "onclick">
		editId(<xsl:value-of select="idrol" />, true)
		</xsl:attribute>
		Edit
		</xsl:element>
		</td>-->
	</xsl:element>
</xsl:for-each>
</table>
</form>
<xsl:call-template name="menu" />
</xsl:template>
<xsl:template name="menu">
<xsl:for-each select="data/params">
<table>
<tr>
<td class="left">
<xsl:value-of select="items_count" /> Resultados X 

		<xsl:element name="input" >
		<xsl:attribute name="id" >filasxpagina</xsl:attribute>
		<xsl:attribute name="name" >filasxpagina</xsl:attribute>
		<xsl:attribute name="type" >text</xsl:attribute>
		<xsl:attribute name="size" >2</xsl:attribute>
		<xsl:attribute name="value" ><xsl:value-of select="rows_x_page" /></xsl:attribute>
		<xsl:attribute name="onkeypress" >manejaKeyPress(event,this)</xsl:attribute>
		
		</xsl:element>


</td>
<td class="right">
	<xsl:choose>
		<xsl:when test="previous_page>0">
			<xsl:element name="a" >
			<xsl:attribute name="href" >#</xsl:attribute>
			<xsl:attribute name="onclick">
			loadGridPage(<xsl:value-of select="previous_page"/>)
			</xsl:attribute>
			Anterior
			</xsl:element>
		</xsl:when>
	</xsl:choose>
</td>
<td>
		<xsl:element name="select" >
		<xsl:attribute name="id" >pagina</xsl:attribute>
		<xsl:attribute name="onchange">
		loadSelectPage(this)
		</xsl:attribute>
		<xsl:call-template name="sume">
			<xsl:with-param name="i" select="$t"/>
		</xsl:call-template>
		</xsl:element>
</td>
<td class="left">
<xsl:choose>
<xsl:when test="next_page>0">
<xsl:element name="a">
<xsl:attribute name = "href" >#</xsl:attribute>
<xsl:attribute name = "onclick">
loadGridPage(<xsl:value-of select="next_page"/>)
</xsl:attribute>
Siguiente
</xsl:element>
</xsl:when>
</xsl:choose>
</td>
<td class="right">
Pagina <xsl:value-of select="returned_page" />
de <xsl:value-of select="total_pages" />
</td>
</tr>
</table>
</xsl:for-each>
</xsl:template>
</xsl:stylesheet>