const date = new Date()
// GET YYYY, MM AND DD FROM THE DATE OBJECT
const yyyy = date.getFullYear().toString()
const mm = (date.getMonth() + 1).toString()
const dd = date.getDate().toString()
// CONVERT mm AND dd INTO chars
const mmChars = mm.split('')
const ddChars = dd.split('')
// CONCAT THE STRINGS IN YYYY-MM-DD FORMAT
const datestring =
  yyyy +
  '-' +
  (mmChars[1] ? mm : '0' + mmChars[0]) +
  '-' +
  (ddChars[1] ? dd : '0' + ddChars[0])

const pasado = parseInt(yyyy) - 13

const fechapasada = pasado + '-12-31'

function val_tipodocumento (value) {
  const tipodocumento = value.split('|*||*|')
  $('#tipodoc').val(tipodocumento[0])
  $('#documento').val('')
}

$(document).ready(function () {
  jQuery.validator.addMethod(
    'lettersonly',
    function (value, element) {
      return this.optional(element) || /^[a-zA-Z\s ñáéíóú]+$/i.test(value)
    },
    'Solo letras'
  )
  jQuery.validator.addMethod(
    'emailvalido',
    function (value, element) {
      return (
        this.optional(element) ||
        /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i.test(value)
      )
    },
    'E-Mail Valido'
  )
  jQuery.validator.addMethod(
    'confirmaremailvalido',
    function (value, element) {
      return (
        this.optional(element) ||
        /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i.test(value)
      )
    },
    'Confirmar E-Mail Valido'
  )
  jQuery.validator.addMethod(
    'mayorfechanacimiento',
    function (value) {
      let result = true
      if (value > datestring) {
        result = false
      }
      return result
    },
    'Fecha'
  )
  jQuery.validator.addMethod(
    'menorfechanacimiento',
    function (value) {
      let result = true
      if (value > fechapasada) {
        result = false
      }
      return result
    },
    'Fecha'
  )
  jQuery.validator.addMethod(
    'check',
    function (value) {
      let result = true
      if (!$('#politica').is(':checked')) {
        result = false
      }
      return result
    },
    'Invalido'
  )

  jQuery.validator.setDefaults({
    highlight: function (element) {
      $(element)
        .closest('.form-group')
        .removeClass('has-success')
        .addClass('has-error')
    },
    unhighlight: function (element) {
      $(element)
        .closest('.form-group')
        .removeClass('has-error')
        .addClass('has-success')
    },
    errorElement: 'span',
    errorClass: 'help-block',
    errorPlacement: function (error, element) {
      if (element.parent('.input-group').length) {
        error.insertAfter(element.parent())
      } else {
        error.insertAfter(element)
      }
    }
  })

  $('#Enviar').click(function () {
    $('#inscripcion').validate({
      rules: {
        nombre: { required: true, maxlength: 50 },
        apellido: { required: true, maxlength: 50 },
        idpaisnacimiento: { required: true },
        fechanacimiento: {
          required: true,
          mayorfechanacimiento: true,
          menorfechanacimiento: true
        },
        tipodocumento: { required: true },
        documento: { required: true, minlength: 7, maxlength: 15 },
        codigogenero: { required: true },
        telefonoresidencia: { minlength: 7, maxlength: 15 },
        celular: { required: true, minlength: 10, maxlength: 15 },
        correo: {
          required: true,
          email: true,
          emailvalido: true,
          maxlength: 100
        },
        confirmacorreo: {
          required: true,
          email: true,
          confirmaremailvalido: true,
          maxlength: 50,
          equalTo: '#correo'
        },
        clave: { required: true, minlength: 6, maxlength: 100 },
        confirmarclave: {
          required: true,
          minlength: 6,
          maxlength: 100,
          equalTo: '#clave'
        },
        politica: { check: true }
      },
      messages: {
        nombre: {
          required: 'Debe ingresar Nombres',
          maxlength: 'Maximo 50 caracteres'
        },
        apellido: {
          required: 'Debe ingresar Apellidos',
          maxlength: 'Maximo 50 caracteres'
        },
        idpaisnacimiento: {
          required: 'Debe seleccionar el Pais de nacimiento'
        },
        fechanacimiento: {
          required: 'Debe ingresar Fecha de nacimiento',
          mayorfechanacimiento: 'No debe ser mayor a la fecha actual',
          menorfechanacimiento: 'Debe ser mayor de 13 años'
        },
        tipodocumento: {
          required: 'Debe seleccionar Tipo documento'
        },
        documento: {
          required: 'Debe Ingresar el Documento',
          minlength: 'Minimo 7 digitos',
          maxlength: 'Maximo 15 digitos'
        },
        codigogenero: { required: 'Debe seleccionar Genero' },
        telefonoresidencia: {
          minlength: 'Minimo 7 digitos',
          maxlength: 'Maximo 15 digitos'
        },
        celular: {
          required: 'Debe ingresar Celular',
          minlength: 'Minimo 10 digitos',
          maxlength: 'Maximo 15 digitos'
        },
        correo: {
          required: 'Debe Ingresar E-Mail',
          email: 'E-Mail debe ser valido',
          maxlength: 'Maximo 100 caracteres'
        },
        confirmacorreo: {
          required: 'Debe Confirmar E-Mail',
          email: 'Confirmar E-Mail debe ser valido',
          maxlength: 'Maximo 100 caracteres',
          equalTo: 'Debe coincidir con E-Mail'
        },
        clave: {
          required: 'Debe ingresar Clave',
          minlength: 'Clave debe contener por lo menos 6 caracteres',
          maxlength: 'Maximo 100 caracteres'
        },
        confirmarclave: {
          required: 'Debe Confirmar Clave',
          minlength: 'Confirmar Clave debe contener por lo menos 6 caracteres',
          maxlength: 'Maximo 100 caracteres',
          equalTo: 'Debe coincidir con Clave'
        },
        politica: { check: '?' }
      }
    })

    if ($('#inscripcion').valid()) {
      const nombre = $('#nombre').val()
      const apellido = $('#apellido').val()
      const idpaisnacimiento = $('#idpaisnacimiento').val()
      const tipodocumento = $('#tipodocumento').val()
      const fechanacimiento = $('#fechanacimiento').val()
      const documento = $('#documento').val()
      const codigogenero = $('#codigogenero').val()
      const telefonoresidencia = $('#telefonoresidencia').val()
      const celular = $('#celular').val()
      const correo = $('#correo').val()
      const clave = $('#clave').val()
      const politica = $('#politica').val()
      const url = $('#url').val()

      $.ajax({
        type: 'POST',
        url: 'funciones/FuncionesUsuarioAspirante.php',
        dataType: 'html',
        data: {
          nombre: nombre,
          apellido: apellido,
          fechanacimiento: fechanacimiento,
          tipodocumento: tipodocumento,
          documento: documento,
          correo: correo,
          action: 'Validar'
        },
        beforeSend: function () {},
        success: function (data) {
          // se realiza un filtrado con respecto a inyecciones de código de f5
          const limpiezaF5 = data.indexOf('/script')

          if (limpiezaF5 !== -1) {
            data = data.substring(limpiezaF5 + 8, data.lenght)
            data = data.trim()
          }

          if (data !== '') {
            bootbox.dialog({
              title: 'Sus datos',
              message: data,
              buttons: {
                danger: {
                  label: 'Recuperar Clave',
                  className: 'btn btn-line-green-XL',
                  callback: function () {
                    location.href =
                      url + '/aspirantes/usuarioaspirante/recuperarclave.php'
                  }
                }
              }
            })
          } else {
            confirmar(
              nombre,
              apellido,
              idpaisnacimiento,
              fechanacimiento,
              tipodocumento,
              documento,
              codigogenero,
              telefonoresidencia,
              celular,
              correo,
              clave,
              politica,
              'Nuevo'
            )
          }
        },
        error: function (data, error) {
          alert('Error en la consulta de los datos.')
        }
      })
    }
  })
})

function confirmar (
  nombre,
  apellido,
  idpaisnacimiento,
  fechanacimiento,
  tipodocumento,
  documento,
  codigogenero,
  telefonoresidencia,
  celular,
  correo,
  clave,
  politica,
  action
) {
  const pais = idpaisnacimiento.split('|**|')
  const tipdoc = tipodocumento.split('|*||*|')
  const genero = codigogenero.split('*|**|*')
  let datos = ''
  datos += '<strong>Nombres:</strong> ' + nombre + '<br>'
  datos += '<strong>Apellidos:</strong> ' + apellido + '<br>'
  datos += '<strong>País de nacimiento:</strong> ' + pais[1] + '<br>'
  datos += '<strong>Fecha de nacimiento:</strong> ' + fechanacimiento + '<br>'
  datos += '<strong>Tipo de documento:</strong> ' + tipdoc[1] + '<br>'
  datos += '<strong>Documento:</strong> ' + documento + '<br>'
  datos += '<strong>Genero:</strong> ' + genero[1] + '<br>'
  datos +=
    '<strong>Teléfono de residencia:</strong> ' + telefonoresidencia + '<br>'
  datos += '<strong>Celular:</strong> ' + celular + '<br>'
  datos += '<strong>E-mail:</strong> ' + correo + '<br>'
  datos += '<strong>Clave:</strong> ' + clave + '<br>'
  bootbox.dialog({
    title: 'Desea guardar los datos?',
    message: datos,
    buttons: {
      success: {
        label: 'Si',
        className: 'btn btn-fill-green-XL',
        callback: function () {
          guardarInfo(
            nombre,
            apellido,
            pais[0],
            fechanacimiento,
            tipdoc[0],
            documento,
            genero[0],
            telefonoresidencia,
            celular,
            correo,
            clave,
            politica,
            action
          )
        }
      },
      danger: {
        label: 'No',
        className: 'btn btn-line-green-XL'
      }
    }
  })
}

function guardarInfo (
  nombre,
  apellido,
  idpaisnacimiento,
  fechanacimiento,
  tipodocumento,
  documento,
  codigogenero,
  telefonoresidencia,
  celular,
  correo,
  clave,
  politica,
  action
) {
  $.ajax({
    type: 'POST',
    url: 'funciones/FuncionesUsuarioAspirante.php',
    dataType: 'html',
    data: {
      nombre: nombre,
      apellido: apellido,
      idpaisnacimiento: idpaisnacimiento,
      fechanacimiento: fechanacimiento,
      tipodocumento: tipodocumento,
      documento: documento,
      codigogenero: codigogenero,
      telefonoresidencia: telefonoresidencia,
      celular: celular,
      correo: correo,
      clave: clave,
      politica: politica,
      action: action
    },
    beforeSend: function () {},
    success: function (data) {
      if (data != '') {
        bootbox.alert({
          message: 'Datos Guardados Exitosamente',
          buttons: {
            ok: {
              className: 'btn btn-fill-green-XL'
            }
          },
          callback: function () {
            location.href = data
          }
        })
      } else {
        bootbox.alert({
          message: 'Los Datos no han sido Guardados',
          buttons: {
            ok: {
              className: 'btn btn-fill-green-XL'
            }
          }
        })
      }
    },
    error: function (data, error) {
      bootbox.alert('Error en la consulta de los datos.')
    }
  })
}

$(function () {
  $(document).on('cut copy paste', '#confirmacorreo', function (e) {
    e.preventDefault()
  })
})

function val_texto (e) {
  tecla = document.all ? e.keyCode : e.which
  if (tecla == 8) return true
  patron = /[a-zA-ZñÑ\s]+$/
  te = String.fromCharCode(tecla)
  return patron.test(te)
}

function val_numero (e) {
  tecla = document.all ? e.keyCode : e.which
  if (tecla == 8) return true
  patron = /[0-9]+$/
  te = String.fromCharCode(tecla)
  return patron.test(te)
}
function val_numero_documento (e) {
  const tip = $('#tipodoc').val()
  switch (tip) {
    case '05':
      // para que se pueda ingresar el pasaporte se deja vacio este case
      break
    default:
      tecla = document.all ? e.keyCode : e.which
      if (tecla == 8) return true
      patron = /[0-9]+$/
      te = String.fromCharCode(tecla)
      return patron.test(te)
  }
}
