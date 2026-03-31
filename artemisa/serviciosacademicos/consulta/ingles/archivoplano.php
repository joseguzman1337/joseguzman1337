<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <form name="form1"  method="POST" action="">
            <TABLE  border="1" align="left" cellpadding="3">
                <TR >
                    <TD align="center" colspan="2"><label id="labelresaltadogrande">Informe Cargue Masivo Notas Tell Me More</label> </TD>
                </TR>
                <TR >
                    <TD align="left" colspan="2"><?php
                            $generador=fopen("tellmemore.txt",'r');
                            $bufer="";
                            while (!feof($generador)) {
                                $bufer = fgets($generador);
                                echo $bufer."<br>";
                            }
                            fclose($generador);

                            ?>
                    </TD>
                </TR>
                <TR >
                    <TD align="center" colspan="2"><INPUT type="button" value="Regresar" onclick="window.location.href='notastellmemore.php'"></TD>
                </TR>
            </TABLE>
        </form>
    </body>
</html>
