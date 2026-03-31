<script type="text/javascript">
    window.open("certificados.php?documento=<?php echo $_REQUEST['documento']."&iddiploma=".$_REQUEST['iddiploma']; ?>" , "ventana1" , "width=500,height=500,resizable=yes");
</script>
<?php
unset($_SERVER['PHP_AUTH_USER']);
unset($_SERVER['PHP_AUTH_PW']);
?>
<a href="./autenticacion.php?iddiploma=<?php echo $_REQUEST['iddiploma'];?>" title="retornar">Volver a Buscar</a>

<!--<a href="javascript:window.close();">Terminar</a>

