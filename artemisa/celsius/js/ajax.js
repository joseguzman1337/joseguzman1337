function retrieveNoResultURL (url) {
  processAsynchronousURL(url, processStateChangeNoResult)
}

function retrieveURL (url) {
  return processSynchronousURL(url)
}

function processSynchronousURL (url) {
  if (window.XMLHttpRequest) {
    // Non-IE browsers
    req = new XMLHttpRequest()
    try {
      req.open('GET', url, false)
      // req.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
    } catch (e) {
      alert(e)
    }
    req.send(null)
  } else if (window.ActiveXObject) {
    // IE
    req = new ActiveXObject('Microsoft.XMLHTTP')
    if (req) {
      req.open('GET', url, false)
      req.setRequestHeader('If-Modified-Since', 'Sat, 1 Jan 2000 00:00:00 GMT')
      req.send()
    }
  }
  return req.status == 200 ? req.responseText : false
}

function processAsynchronousURL (url, processStateChange) {
  if (window.XMLHttpRequest) {
    // Non-IE browsers
    req = new XMLHttpRequest()
    req.onreadystatechange = processStateChange
    try {
      req.open('GET', url, true)
      // req.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
    } catch (e) {
      alert(e)
    }
    req.send(null)
  } else if (window.ActiveXObject) {
    // IE
    req = new ActiveXObject('Microsoft.XMLHTTP')
    if (req) {
      req.onreadystatechange = processStateChange
      req.open('GET', url, true)
      req.setRequestHeader('If-Modified-Since', 'Sat, 1 Jan 2000 00:00:00 GMT')
      req.send()
    }
  }
}

function processStateChangeNoResult () {
  if (req.readyState == 4) {
    // Complete
    if (req.status == 200) {
      // OK response

      location.reload() // href = goToURL;
    } else {
      alert('Problem: ' + req.statusText)
    }
  }
}
