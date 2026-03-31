<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
// Validacion del formulario
/* if(!isset($_SESSION['nombreprograma']))
{
?>
<script language="javascript">
	window.location.reload("../../login.php");
</script>
<?php	
}
else if($_SESSION['nombreprograma'] <> "materiasgrupos.php")
{
	if($_SESSION['nombreprograma'] <> "plandeestudioinicial.php")
{

?>
 <script>
   window.location.reload("../../login.php");
 </script>
<?php
	}	
}
 */
// Fin validacion del formulario
?>