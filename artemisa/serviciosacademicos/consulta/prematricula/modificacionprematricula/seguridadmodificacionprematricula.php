<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php' );
?>
<?php
// Validacion del formulario
if(!isset($_SESSION['nombreprograma']))
{
?>
<script language="javascript">
	window.location.href="../../login.php";
</script>
<?php
}
else if($_SESSION['nombreprograma'] <> "modificacionprematriculabusqueda.php")
{
	if($_SESSION['nombreprograma'] <> "matriculaautomaticabusquedaestudiante.php")
	{
?>
 <script>
   window.location.href="../../login.php";
 </script>
<?php
	}
}
// Fin validacion del formulario
?>