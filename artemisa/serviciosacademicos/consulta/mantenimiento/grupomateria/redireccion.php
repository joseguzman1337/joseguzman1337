<?php
/*
 * Archivo de redireccionamiento
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Creado 14 de Noviembre de 2017.
 */
?>
 <script language="javascript">
    function redireccion() {
    <?php
    switch ($_GET['flag']){
        case 1:
            ?>
            location.href="detallegrupomateria_nuevo_lista.php?idgrupomateria=<?php echo $_GET['idgrupomateria'] ?>&codigotipomateria=4-5&nombregrupomateria=<?php echo $_GET['nombregrupomateria'] ?>";
            <?php
            break;
        case 2:
            ?>
            location.href="detallegrupomateria_nuevo_lista.php?idgrupomateria=<?php echo $_GET['idgrupomateria'] ?>&nombregrupomateria=<?php echo $_GET['nombregrupomateria'] ?>&Filtrar=<?php echo $_GET['Filtrar'] ?>&f_nombremateria=<?php echo $_GET['f_nombremateria'] ?>&f_codigocarrera=<?php echo $_GET['f_codigocarrera'] ?>&f_codigotipomateria=<?php echo $_GET['f_codigotipomateria'] ?>";
            <?php
            break;
    }
    ?>
    }
    window.onload = redireccion();
</script>
<!--end-->