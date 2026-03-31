            $("#areadetexto").maxlength( {statusText: "Caracteres faltantes", maxCharacters: long, slider: true});
            $.ajax({
                url: "<?php echo $rutaPHP; ?>funcionessic.php?iditemsic=" + iditemsic + "&funcion=obtenerValoritemsiccarrera",
                success: function(datos){
                    $("#areadetexto").val(datos);
                    //$("#dialog").append(datos);
                    //alert(datos);
                }
            });
            $("#iditemsicoculto").val(iditemsic);
            $("#descripcionitem").text(desc);
            $("#titulotextogeneral").fadeIn("slow").text(texto);

            $("#botonaceptar").click(function(){
                //alert('assssasd');
                var iditemsic = $("#iditemsicoculto").val();
                var valoritemsiccarrera = $("#areadetexto").val();
                if(valoritemsiccarrera != '')
                {
                    //alert(iditemsic + valoritemsiccarrera);
                    $.ajax({
                        url: "<?php echo $rutaPHP; ?>funcionessic.php?iditemsic=" + iditemsic + "&valoritemsiccarrera=" + valoritemsiccarrera + "&funcion=insertarItemsiccarrera",
                        success: function(datos){
                            //$("#areadetexto").val(datos);
                            //$("#dialog").append(datos);
                            if(datos == 'insertado')
                            {
                                alert("El valor fue insertado satisfactoriamente");
                                $("#img" + iditemsic).attr("src", "imagenes/poraprobar.gif");
                            }
                            else if(datos == 'actualizado')
                            {
                                alert("El valor fue actualizado satisfactoriamente");
                            }
                            else
                            {
                                alert("ERROR:" + datos);
                            }
                        }
                    });
                }
                else
                {
                    alert("El campo de texto es requerido");
                }
            });

            /*$("#adjuntos").newWindow({
                windowTitle:"Adjuntar Archivos",
                content: "<iframe id='#idadjunto' width='300px' height='300px' src='aplicaciones/textogeneral/controlador/php/adjunto.php'>",
                windowType: "iframe",
                posx : 400,
                posy : 80,
                width: 300,
                height: 180
            });*/
