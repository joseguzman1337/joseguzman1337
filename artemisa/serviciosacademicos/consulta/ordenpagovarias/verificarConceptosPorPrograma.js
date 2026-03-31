var ClassOrdenesPago = function (urlRoot) {
    this.urlRoot = urlRoot,
        this.idCodigoEstudiante
};

ClassOrdenesPago.prototype = {

    /*
     * Validar que el concepto seleccionado tenga relación con la carrera/programa
     */
    validarConcepto: function(idConcepto, idCodigoEstudiante, inputCheck){

        var idConcepto = idConcepto;
        var inputCheck = inputCheck;

        url = this.urlRoot;
        url += '/serviciosacademicos/consulta/ordenpagovarias/verificarConceptoPorPrograma.php';
        data = {accion: 'verificarConcepto', idconcepto : idConcepto, idCodigoEstudiante : idCodigoEstudiante};

        $.ajax({
            'method' : 'GET',
            'url' : url,
            'data' : data,
            'success' : function (response) {

                validVinculo = response.status;
                programa = response.vinculo.nombrecarrera;

                if(validVinculo === 'Sin Vinculo')
                {

                    objDefaultOrdenesPago.respuestaFallida();
                    console.log('El programa ' + programa + ' no tiene vinculo con el concepto : ' + idConcepto);
                    $(inputCheck).prop('checked', false);
                }

            },
            'error' : function(response){
                swal('Error!', 'Al verificar el concepto seleccionado con el programa', 'error');
                $(inputCheck).prop('checked', false);
                console.log(response);
            }
        });


    },

    respuestaFallida: function(){

        msg = 'No se puede generar la orden para este concepto (falta homologación de item), ' +
            'por favor comunicar a la facultad y al departamento de finanzas estudiantiles!';

        swal('Alerta!', msg, 'warning');

    }


};

var objDefaultOrdenesPago = new ClassOrdenesPago('');
