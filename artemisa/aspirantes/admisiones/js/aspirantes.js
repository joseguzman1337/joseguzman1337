$(document).ready(function () {
  $('#Ingresar').click(function () {
    let valid = ''
    let flag = 0
    const usuario = $('#usuario').val()
    const clave = $('#clave').val()

    if (usuario === null || usuario == '') {
      valid += 'Debe llenar el campo Usuario \n'
      flag = 1
    }
    if (usuario != '') {
      if (
        !/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i.test(
          usuario
        )
      ) {
        valid += 'Debe Ingresar un usuario valido \n'
        flag = 1
      }
    }
    if (clave === null || clave == '') {
      valid += 'Debe llenar el campo Contraseña'
      flag = 1
    }
    if (valid != '') {
      swal(valid)
    }

    if (flag === 0) {
      $.ajax({
        type: 'POST',
        url: '../usuarioaspirante/redireccionaingresousuario.php',
        dataType: 'json',
        data: {
          usuario: usuario,
          clave: clave,
          ingresar: 'ingresar',
          ajax: 'ajax'
        },
        success: function (data) {
          if (data.val === true) {
            window.location =
              '../../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariopreinscripcion.php?documentoingreso=' +
              data.doc
          } else {
            swal(data.msg)
          }
        },
        error: function (error) {}
      })
    } // if
  })
})
