<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
// Validacion del formulario
if(!isset($_SESSION['nombreprograma']))
{
?>
<script language="javascript">
	window.location.reload("../../login.php");
</script>
<?php	
}
else if($_SESSION['nombreprograma'] <> "menucrearnuevoestudiante.php")
{
?>
 <script>
   window.location.href="../../login.php";
 </script>
<?php	
}
// Fin validacion del formulario
?>