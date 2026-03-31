<?php
class ValidarSesion
{
    public function Validar()
    {
        if(!isset ($_SESSION['MM_Username'])){
            echo "<script>alert('No ha iniciado sesión en el sistema');
            window.location.href='https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm';
            </script>";
			exit();
        }
    } 
}

?>