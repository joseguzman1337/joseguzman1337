<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Certificados</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
                <style>
                    .buttonGraduadoEstudiante{
                        margin: auto;
                        width: 40%;
                    }
                    .buttonGraduadoEstudiante input{
                        margin: auto;
                        width: 40%;
                        padding: 29px 0 !important;
                        margin-top: 5%;
                        font-size: 20px;
                    }
                </style>
                <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
                <script type="text/javascript" src="../../../../assets/js/sweetalert.min.js"></script>
	</head>

	<body>
            <div align="center" class="buttonGraduadoEstudiante">
                <h3>Verificación de Títulos Universidad el Bosque</h3>
                <p>La información sobre los títulos que otorga la Universidad El Bosque a sus
                estudiantes es considerada pública, y por lo tanto se encuentra dentro de las
                excepciones establecidas en la Ley 1581 de 2012 (Protección de Datos
                Personales). Es por esto que la Universidad El Bosque, tiene la facultad de
                suministrar los datos de contenido público a quien tenga un interés por
                conocerlos.</p>
                
                <p>Sin embargo, el acceso y consulta de los datos personales contenidos en la
                base de datos de títulos, quedará de igual forma supeditado, y se deberá dar
                cumplimiento por parte de los usuarios, a lo previsto y dispuesto en la política
                sobre manejo de datos personales expedida por la Universidad El Bosque.</p>
                
                <p><a target="_blank" href="https://www.uelbosque.edu.co/sites/default/files/2017-06/politica_tratamiento_datos_personales.pdf">Click aquí</a> 
                para conocer nuestra politica de protección de datos personales.</p>
                <form method="post" action="formulario.php">
                    <input name="tipoCertificado" id="tipoCertificado" value="0" type="hidden" />
                    <input type="submit" onclick="$('#tipoCertificado').val('0')" id="graduados" value="Graduados">
                    <input type="submit" onclick="$('#tipoCertificado').val('1')" id="estudiantes" value="Estudiantes">
                </form>		
            </div>
	</body>
        <?php if(isset($_GET['token'])){ ?>
        <script>
            $(document).ready(function (){
                var token = "<?php echo $_GET['token']; ?>";
                $.ajax({
                    type: 'POST',
                    url: 'controllerCertificado.php',
                    async: false,
                    dataType: 'json',
                    data:({ 
                        actionID: 'consultaEgresado',
                        token:token
                    }),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        if(data.numeroDocumento == 0){
                            swal('Este link ya no es valido para consulta, favor diligenciar el formulario nuevamente');
                        }
                        else if(data.tipoCertificado == 0){
                          window.location.href='../../certificadosgraduadoantiguo/'+data.redirect+'?token='+data.numeroDocumento;
                        }else{
                            window.location.href='../../certificadosgraduadoantiguo/'+data.redirect+'?token='+data.numeroDocumento;
                        }
                    }
                });
            });
                
        </script>
	<?php } ?>
</html>