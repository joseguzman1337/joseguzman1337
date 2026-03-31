<?php
if(isset($_REQUEST['salir']))
{
    $_SERVER['PHP_AUTH_USER'] = '';
    $_SERVER['PHP_AUTH_PW'] = '';
    $_REQUEST['salir']=true;
    require('autenticacion.php');
    exit();
?>
<script type="text/javascript">
    window.location.href='https://artemisa.unbosque.edu.co';
</script>
<?php
}
?>