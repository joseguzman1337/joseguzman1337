<?php
require_once('../../../Connections/sala2.php' );
$fechahoy=date("Y-m-d H:i:s");
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
?>
<html>
<head>

<title>Autorización al empleo.com</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
<body>
<form name="f1" method="get" >
        
    <table width="60%" align="center"  border="0"  cellpadding="3" cellspacing="3">
            
        <tr id="trtitulogris">
            <TD align="center"  colspan="2"><LABEL  id="labelasterisco">Autorización Envió de Información a elempleo.com</LABEL></TD>
        </tr>
        <TR><TD></TD></TR>        
        <TR id="trtitulogris">
            <?php 
            if ($totalRows_egresado != 0) { ?>
                <TD style="text-align:justify; color:#999B8E;" >Señor egresado: Dentro de los intereses y prioridades de la Universidad están el brindarle colaboración y apoyo en el ejercicio de su profesión, es por esto que deseamos informarle que contamos a la fecha con un convenio con la empresa elempleo.com, éste busca promover y facilitar la consecución de puestos de trabajo para sus egresados. A través de dicha empresa usted tiene la posibilidad de evaluar el mercado laboral y si así lo requiere ubicar nuevas o mejores oportunidades de trabajo que se ajusten a sus expectativas ya que cuentan con más de 800 empresas nacionales y multinacionales que continuamente están haciendo ofertas laborales en diversas áreas.</BR></BR>
                Autoriza usted a la Universidad para realizar el envió de su información de contacto a elempleo.com
                
                </td>            
            <?php
            }
            if ($totalRows_estadoestudiante != 0) { ?>
                <TD style="text-align:justify; color:#999B8E;" >Señor estudiante de último año: Dentro de los intereses y prioridades de la Universidad están el brindarle colaboración y apoyo en su próxima condición de egresado, es por esto que deseamos informarle que contamos a la fecha con un convenio con la empresa elempleo.com, éste busca promover y facilitar la consecución de puestos de trabajo por parte de sus alumnos de último año y egresados. A través de dicha empresa usted tiene la posibilidad de evaluar el mercado laboral y si así lo requiere ubicar oportunidades de trabajo que se ajusten a sus expectativas ya que cuentan con más de 800 empresas nacionales y multinacionales que continuamente están haciendo ofertas laborales en diversas áreas.</BR></BR>
                Autoriza usted a la Universidad para realizar el envió de su información de contacto a elempleo.com
                </td>
            <?php 
            }
            ?>            
        </tr>
        <TR id="trtitulogris">
            <TD align="center"><INPUT type="submit" name="IngresoEmpleosi" id="IngresoEmpleosi" value="SI AUTORIZO"><INPUT type="submit" name="IngresoEmpleono" id="IngresoEmpleono" value="NO AUTORIZO"><INPUT type="submit" name="decidir" id="decidir" value="DECIDIR MAS TARDE"></TD>
        </TR>        
        
    </table>  
    
    
    
</form>
</body>
</html>
<?php 
//exit();
?>
