// Title: Timestamp picker
// Description: See the demo at url
// URL: http://www.geocities.com/tspicker/
// Version: 1.0
// Date: 12-05-2001 (mm-dd-yyyy)
// Author: Denis Gritcyuk <denis@softcomplex.com>; <tspicker@yahoo.com>
// Notes: Permission given to use this script in any kind of applications if
//    header lines are left unchanged. Feel free to contact the author
//    for feature requests and/or donations

function show_calendar (str_target, str_datetime) {
  const arr_months = [
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Septiembre',
    'Octubre',
    'Noviembre',
    'Diciembre'
  ]
  const week_days = ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  const n_weekstart = 1 // day week starts from (normally 0 or 1)

  const dt_datetime =
    str_datetime === null || str_datetime == ''
      ? new Date()
      : str2dt(str_datetime)
  const dt_prev_month = new Date(dt_datetime)
  dt_prev_month.setMonth(dt_datetime.getMonth() - 1)
  const dt_next_month = new Date(dt_datetime)
  dt_next_month.setMonth(dt_datetime.getMonth() + 1)
  const dt_firstday = new Date(dt_datetime)
  dt_firstday.setDate(1)
  dt_firstday.setDate(1 - ((7 + dt_firstday.getDay() - n_weekstart) % 7))
  const dt_lastday = new Date(dt_next_month)
  dt_lastday.setDate(0)

  // html generation (feel free to tune it for your particular application)
  // print calendar header
  let str_buffer = String(
    '<html>\n' +
      '<head>\n' +
      '	<title> Calendario CELSIUS </title> \n' +
      '</head>\n' +
      '<body bgcolor="White">\n' +
      '<table class="clsOTable" cellspacing="0" border="0" width="100%">\n' +
      '<tr><td bgcolor="#4682B4">\n' +
      '<table cellspacing="1" cellpadding="3" border="0" width="100%">\n' +
      '<tr>\n	<td bgcolor="#4682B4"><a href="javascript:window.opener.show_calendar(\'' +
      str_target +
      "', '" +
      dt2dtstr(dt_prev_month) +
      "');\">" +
      '<img src="prev.gif" width="16" height="16" border="0"' +
      ' alt="mes anterior"></a></td>\n' +
      '	<td bgcolor="#4682B4" colspan="5">' +
      '<font color="white" face="tahoma, verdana" size="2">' +
      arr_months[dt_datetime.getMonth()] +
      ' ' +
      dt_datetime.getFullYear() +
      '</font></td>\n' +
      '	<td bgcolor="#4682B4" align="right"><a href="javascript:window.opener.show_calendar(\'' +
      str_target +
      "', '" +
      dt2dtstr(dt_next_month) +
      "');\">" +
      '<img src="next.gif" width="16" height="16" border="0"' +
      ' alt="mes siguiente"></a></td>\n</tr>\n'
  )
  const dt_current_day = new Date(dt_firstday)
  // print weekdays titles
  str_buffer += '<tr>\n'
  for (let n = 0; n < 7; n++) {
    str_buffer +=
      '	<td bgcolor="#87CEFA">' +
      '<font color="white" face="tahoma, verdana" size="2">' +
      week_days[(n_weekstart + n) % 7] +
      '</font></td>\n'
  }
  // print calendar table
  str_buffer += '</tr>\n'
  while (
    dt_current_day.getMonth() == dt_datetime.getMonth() ||
    dt_current_day.getMonth() == dt_firstday.getMonth()
  ) {
    // print row heder
    str_buffer += '<tr>\n'
    for (let n_current_wday = 0; n_current_wday < 7; n_current_wday++) {
      if (
        dt_current_day.getDate() == dt_datetime.getDate() &&
        dt_current_day.getMonth() == dt_datetime.getMonth()
      ) {
        // print current date
        str_buffer += '	<td bgcolor="#FFB6C1" align="right">'
      } else if (dt_current_day.getDay() == 0 || dt_current_day.getDay() == 6) {
        // weekend days
        str_buffer += '	<td bgcolor="#DBEAF5" align="right">'
      }
      // print working days of current month
      else str_buffer += '	<td bgcolor="white" align="right">'

      if (dt_current_day.getMonth() == dt_datetime.getMonth()) {
        // print days of current month
        str_buffer +=
          '<a href="javascript:window.opener.' +
          str_target +
          ".value='" +
          dt2dtstr(dt_current_day) +
          "'; window.close();\">" +
          '<font color="black" face="tahoma, verdana" size="2">'
      }
      // print days of other months
      else {
        str_buffer +=
          '<a href="javascript:window.opener.' +
          str_target +
          ".value='" +
          dt2dtstr(dt_current_day) +
          "'; window.close();\">" +
          '<font color="gray" face="tahoma, verdana" size="2">'
      }
      str_buffer += dt_current_day.getDate() + '</font></a></td>\n'
      dt_current_day.setDate(dt_current_day.getDate() + 1)
    }
    // print row footer
    str_buffer += '</tr>\n'
  }
  // print calendar footer

  str_buffer +=
    '</table>\n' + '</tr>\n</td>\n</table>\n' + '</body>\n' + '</html>\n'

  const vWinCal = window.open(
    '',
    'Calendar',
    'width=200,height=200,status=no,resizable=no,title=no,top=200,left=200'
  )
  vWinCal.opener = self
  vWinCal.focus()
  const calc_doc = vWinCal.document
  calc_doc.write(str_buffer)
  calc_doc.close()
}
// datetime parsing and formatting routimes. modify them if you wish other datetime format
function str2dt (str_datetime) {
  //	var re_date = /^(\d+)\-(\d+)\-(\d+)\s+(\d+)\:(\d+)\:(\d+)$/;
  /* var re_date = /^(\d+)\-(\d+)\-(\d+)\$/;
	if (!re_date.exec(str_datetime))
		return alert("Invalid Datetime format: "+ str_datetime); */

  if (str_datetime === null || str_datetime == '') return new Date()
  else {
    var pos = str_datetime.lastIndexOf('-')
    const dia = str_datetime.substring(pos + 1, str_datetime.length)
    str_datetime = str_datetime.substring(0, pos)
    var pos = str_datetime.lastIndexOf('-')
    const mes = str_datetime.substring(pos + 1, str_datetime.length)
    str_datetime = str_datetime.substring(0, pos)
    const anio = str_datetime
    return new Date(anio, mes - 1, dia)
  }
}

function dt2dtstr (dt_datetime) {
  return String(
    dt_datetime.getFullYear() +
      '-' +
      (dt_datetime.getMonth() + 1) +
      '-' +
      dt_datetime.getDate() +
      ' '
  )
}
function dt2tmstr (dt_datetime) {
  return String(
    dt_datetime.getHours() +
      ':' +
      dt_datetime.getMinutes() +
      ':' +
      dt_datetime.getSeconds()
  )
}
