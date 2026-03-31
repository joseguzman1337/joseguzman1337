if (!window.DHTMLSuite) var DHTMLSuite = new Object()
if (!String.trim) {
  String.prototype.trim = function () {
    return this.replace(/^\s+|\s+$/, '')
  }
}
const DHTMLSuite_funcs = new Object()
if (!window.DHTML_SUITE_THEME) var DHTML_SUITE_THEME = 'blue'
if (!window.DHTML_SUITE_THEME_FOLDER) {
  var DHTML_SUITE_THEME_FOLDER = '../themes/'
}
if (!window.DHTML_SUITE_JS_FOLDER) {
  var DHTML_SUITE_JS_FOLDER = '../js/separateFiles/'
}
var DHTMLSuite = new Object()
let standardObjectsCreated = false
DHTMLSuite.eventEls = new Array()
const widgetDep = new Object()
widgetDep.formValidator = ['dhtmlSuite-formUtil.js']
widgetDep.paneSplitter = [
  'dhtmlSuite-paneSplitter.js',
  'dhtmlSuite-paneSplitterModel.js',
  'dhtmlSuite-dynamicContent.js',
  'ajax.js'
]
widgetDep.menuBar = [
  'dhtmlSuite-menuBar.js',
  'dhtmlSuite-menuItem.js',
  'dhtmlSuite-menuModel.js'
]
widgetDep.windowWidget = [
  'dhtmlSuite-windowWidget.js',
  'dhtmlSuite-resize.js',
  'dhtmlSuite-dragDropSimple.js',
  'ajax.js',
  'dhtmlSuite-dynamicContent.js'
]
widgetDep.colorWidget = [
  'dhtmlSuite-colorWidgets.js',
  'dhtmlSuite-colorUtil.js'
]
widgetDep.colorSlider = [
  'dhtmlSuite-colorWidgets.js',
  'dhtmlSuite-colorUtil.js',
  'dhtmlSuite-slider.js'
]
widgetDep.colorPalette = [
  'dhtmlSuite-colorWidgets.js',
  'dhtmlSuite-colorUtil.js'
]
widgetDep.calendar = ['dhtmlSuite-calendar.js', 'dhtmlSuite-dragDropSimple.js']
widgetDep.dragDropTree = ['dhtmlSuite-dragDropTree.js']
widgetDep.slider = ['dhtmlSuite-slider.js']
widgetDep.dragDrop = ['dhtmlSuite-dragDrop.js']
widgetDep.imageEnlarger = [
  'dhtmlSuite-imageEnlarger.js',
  'dhtmlSuite-dragDropSimple.js'
]
widgetDep.imageSelection = ['dhtmlSuite-imageSelection.js']
widgetDep.floatingGallery = [
  'dhtmlSuite-floatingGallery.js',
  'dhtmlSuite-mediaModel.js'
]
widgetDep.contextMenu = [
  'dhtmlSuite-contextMenu.js',
  'dhtmlSuite-menuBar.js',
  'dhtmlSuite-menuItem.js',
  'dhtmlSuite-menuModel.js'
]
widgetDep.dynamicContent = ['dhtmlSuite-dynamicContent.js', 'ajax.js']
widgetDep.textEdit = [
  'dhtmlSuite-textEdit.js',
  'dhtmlSuite-textEditModel.js',
  'dhtmlSuite-listModel.js'
]
widgetDep.listModel = ['dhtmlSuite-listModel.js']
widgetDep.resize = ['dhtmlSuite-resize.js']
widgetDep.dragDropSimple = ['dhtmlSuite-dragDropSimple.js']
widgetDep.dynamicTooltip = [
  'dhtmlSuite-dynamicTooltip.js',
  'dhtmlSuite-dynamicContent.js',
  'ajax.js'
]
widgetDep.modalMessage = [
  'dhtmlSuite-modalMessage.js',
  'dhtmlSuite-dynamicContent.js',
  'ajax.js'
]
widgetDep.tableWidget = ['dhtmlSuite-tableWidget.js', 'ajax.js']
widgetDep.progressBar = ['dhtmlSuite-progressBar.js']
widgetDep.tabView = [
  'dhtmlSuite-tabView.js',
  'dhtmlSuite-dynamicContent.js',
  'ajax.js'
]
widgetDep.infoPanel = [
  'dhtmlSuite-infoPanel.js',
  'dhtmlSuite-dynamicContent.js',
  'ajax.js'
]
widgetDep.form = [
  'dhtmlSuite-formUtil.js',
  'dhtmlSuite-dynamicContent.js',
  'ajax.js'
]
const depCache = new Object()
DHTMLSuite.include = function (widget) {
  if (!widgetDep[widget]) {
    alert(
      'Cannot find the files for widget ' +
        widget +
        '. Please verify that the name is correct'
    )
    return
  }
  const files = widgetDep[widget]
  for (let no = 0; no < files.length; no++) {
    if (!depCache[files[no]]) {
      document.write('<' + 'script')
      document.write(' language="javascript"')
      document.write(' type="text/javascript"')
      document.write(' src="' + DHTML_SUITE_JS_FOLDER + files[no] + '">')
      document.write('</' + 'script' + '>')
      depCache[files[no]] = true
    }
  }
}
DHTMLSuite.discardElement = function (element) {
  element = DHTMLSuite.commonObj.getEl(element)
  let gBin = document.getElementById('IELeakGBin')
  if (!gBin) {
    gBin = document.createElement('DIV')
    gBin.id = 'IELeakGBin'
    gBin.style.display = 'none'
    document.body.appendChild(gBin)
  }
  gBin.appendChild(element)
  gBin.innerHTML = ''
}
DHTMLSuite.createStandardObjects = function () {
  DHTMLSuite.clientInfoObj = new DHTMLSuite.clientInfo()
  DHTMLSuite.clientInfoObj.init()
  if (!DHTMLSuite.configObj) {
    DHTMLSuite.configObj = new DHTMLSuite.config()
    DHTMLSuite.configObj.init()
  }
  DHTMLSuite.commonObj = new DHTMLSuite.common()
  DHTMLSuite.variableStorage = new DHTMLSuite.globalVariableStorage()
  DHTMLSuite.commonObj.init()
  DHTMLSuite.domQueryObj = new DHTMLSuite.domQuery()
  DHTMLSuite.commonObj.addEvent(window, 'unload', function () {
    DHTMLSuite.commonObj.__clearMemoryGarbage()
  })
  standardObjectsCreated = true
}
DHTMLSuite.config = function () {
  let imagePath
  let cssPath
  let defaultCssPath
  let defaultImagePath
}
DHTMLSuite.config.prototype = {
  init: function () {
    this.imagePath = DHTML_SUITE_THEME_FOLDER + DHTML_SUITE_THEME + '/images/'
    this.cssPath = DHTML_SUITE_THEME_FOLDER + DHTML_SUITE_THEME + '/css/'
    this.defaultCssPath = this.cssPath
    this.defaultImagePath = this.imagePath
  },
  setCssPath: function (newCssPath) {
    this.cssPath = newCssPath
  },
  resetCssPath: function () {
    this.cssPath = this.defaultCssPath
  },
  resetImagePath: function () {
    this.imagePath = this.defaultImagePath
  },
  setImagePath: function (newImagePath) {
    this.imagePath = newImagePath
  }
}
DHTMLSuite.globalVariableStorage = function () {
  let menuBar_highlightedItems
  this.menuBar_highlightedItems = new Array()
  let arrayDSObjects
  let arrayOfDhtmlSuiteObjects
  this.arrayDSObjects = new Array()
  this.arrayOfDhtmlSuiteObjects = this.arrayDSObjects
  let ajaxObjects
  this.ajaxObjects = new Array()
}
DHTMLSuite.globalVariableStorage.prototype = {}
DHTMLSuite.common = function () {
  let loadedCSSFiles
  let cssCacheStatus
  let eventEls
  let isOkToSelect
  this.okToSelect = true
  this.cssCacheStatus = true
  this.eventEls = new Array()
}
DHTMLSuite.common.prototype = {
  init: function () {
    this.loadedCSSFiles = new Array()
  },
  loadCSS: function (cssFile, prefixConfigPath) {
    if (!prefixConfigPath && prefixConfigPath !== false) {
      prefixConfigPath = true
    }
    if (!this.loadedCSSFiles[cssFile]) {
      this.loadedCSSFiles[cssFile] = true
      const lt = document.createElement('LINK')
      if (!this.cssCacheStatus) {
        cssFile = cssFile.indexOf('?') >= 0 ? cssFile + '&' : cssFile + '?'
        cssFile = cssFile + 'rand=' + Math.random()
      }
      if (prefixConfigPath) {
        lt.href = DHTMLSuite.configObj.cssPath + cssFile
      } else {
        lt.href = cssFile
      }
      lt.rel = 'stylesheet'
      lt.media = 'screen'
      lt.type = 'text/css'
      document.getElementsByTagName('HEAD')[0].appendChild(lt)
    }
  },
  __setTextSelOk: function (okToSelect) {
    this.okToSelect = okToSelect
  },
  __isTextSelOk: function () {
    return this.okToSelect
  },
  setCssCacheStatus: function (cssCacheStatus) {
    this.cssCacheStatus = cssCacheStatus
  },
  getEl: function (elRef) {
    if (typeof elRef === 'string') {
      if (document.getElementById(elRef)) return document.getElementById(elRef)
      if (document.forms[elRef]) return document.forms[elRef]
      if (document[elRef]) return document[elRef]
      if (window[elRef]) return window[elRef]
    }
    return elRef
  },
  isArray: function (el) {
    if (el.constructor.toString().indexOf('Array') != -1) return true
    return false
  },
  getStyle: function (el, property) {
    el = this.getEl(el)
    if (document.defaultView && document.defaultView.getComputedStyle) {
      var retVal = null
      const comp = document.defaultView.getComputedStyle(el, '')
      if (comp) {
        retVal = comp[property]
      }
      return el.style[property] || retVal
    }
    if (
      document.documentElement.currentStyle &&
      DHTMLSuite.clientInfoObj.isMSIE
    ) {
      var retVal = null
      if (el.currentStyle) value = el.currentStyle[property]
      return el.style[property] || retVal
    }
    return el.style[property]
  },
  getLeftPos: function (el) {
    if (document.getBoxObjectFor) {
      if (
        el.tagName != 'INPUT' &&
        el.tagName != 'SELECT' &&
        el.tagName != 'TEXTAREA'
      ) {
        return document.getBoxObjectFor(el).x
      }
    }
    let returnValue = el.offsetLeft
    while ((el = el.offsetParent) !== null) {
      if (el.tagName != 'HTML') {
        returnValue += el.offsetLeft
        if (document.all) returnValue += el.clientLeft
      }
    }
    return returnValue
  },
  getTopPos: function (el) {
    if (document.getBoxObjectFor) {
      if (
        el.tagName != 'INPUT' &&
        el.tagName != 'SELECT' &&
        el.tagName != 'TEXTAREA'
      ) {
        return document.getBoxObjectFor(el).y
      }
    }
    let returnValue = el.offsetTop
    while ((el = el.offsetParent) !== null) {
      if (el.tagName != 'HTML') {
        returnValue += el.offsetTop - el.scrollTop
        if (document.all) returnValue += el.clientTop
      }
    }
    return returnValue
  },
  getCookie: function (name) {
    const start = document.cookie.indexOf(name + '=')
    const len = start + name.length + 1
    if (!start && name != document.cookie.substring(0, name.length)) {
      return null
    }
    if (start == -1) return null
    let end = document.cookie.indexOf(';', len)
    if (end == -1) end = document.cookie.length
    return unescape(document.cookie.substring(len, end))
  },
  setCookie: function (name, value, expires, path, domain, secure) {
    expires = expires * 60 * 60 * 24 * 1000
    const today = new Date()
    const expires_date = new Date(today.getTime() + expires)
    const cookieString =
      name +
      '=' +
      escape(value) +
      (expires ? ';expires=' + expires_date.toGMTString() : '') +
      (path ? ';path=' + path : '') +
      (domain ? ';domain=' + domain : '') +
      (secure ? ';secure' : '')
    document.cookie = cookieString
  },
  deleteCookie: function (name, path, domain) {
    if (this.getCookie(name)) {
      document.cookie =
        name +
        '=' +
        (path ? ';path=' + path : '') +
        (domain ? ';domain=' + domain : '') +
        ';expires=Thu,01-Jan-1970 00:00:01 GMT'
    }
  },
  cancelEvent: function () {
    return false
  },
  addEvent: function (obj, type, fn, suffix) {
    if (!suffix) suffix = ''
    if (obj.attachEvent) {
      if (typeof DHTMLSuite_funcs[type + fn + suffix] !== 'function') {
        DHTMLSuite_funcs[type + fn + suffix] = function () {
          fn.apply(window.event.srcElement)
        }
        obj.attachEvent('on' + type, DHTMLSuite_funcs[type + fn + suffix])
      }
      obj = null
    } else {
      obj.addEventListener(type, fn, false)
    }
    this.__addEventEl(obj)
  },
  removeEvent: function (obj, type, fn, suffix) {
    if (obj.detachEvent) {
      obj.detachEvent('on' + type, DHTMLSuite_funcs[type + fn + suffix])
      DHTMLSuite_funcs[type + fn + suffix] = null
      obj = null
    } else {
      obj.removeEventListener(type, fn, false)
    }
  },
  __clearMemoryGarbage: function () {
    if (!DHTMLSuite.clientInfoObj.isMSIE) return
    for (var no = 0; no < DHTMLSuite.eventEls.length; no++) {
      try {
        let el = DHTMLSuite.eventEls[no]
        el.onclick = null
        el.onmousedown = null
        el.onmousemove = null
        el.onmouseout = null
        el.onmouseover = null
        el.onmouseup = null
        el.onfocus = null
        el.onblur = null
        el.onkeydown = null
        el.onkeypress = null
        el.onkeyup = null
        el.onselectstart = null
        el.ondragstart = null
        el.oncontextmenu = null
        el.onscroll = null
        el = null
      } catch (e) {}
    }
    for (var no in DHTMLSuite.variableStorage.arrayDSObjects) {
      DHTMLSuite.variableStorage.arrayDSObjects[no] = null
    }
    window.onbeforeunload = null
    window.onunload = null
    DHTMLSuite = null
  },
  __addEventEl: function (el) {
    DHTMLSuite.eventEls[DHTMLSuite.eventEls.length] = el
  },
  getSrcElement: function (e) {
    let el
    if (e.target) el = e.target
    else if (e.srcElement) el = e.srcElement
    if (el.nodeType == 3) el = el.parentNode
    return el
  },
  getKeyFromEvent: function (e) {
    const code = this.getKeyCode(e)
    return String.fromCharCode(code)
  },
  getKeyCode: function (e) {
    if (e.keyCode) code = e.keyCode
    else if (e.which) code = e.which
    return code
  },
  isObjectClicked: function (obj, e) {
    let src = this.getSrcElement(e)
    let string = src.tagName + '(' + src.className + ')'
    if (src == obj) return true
    while (src.parentNode && src.tagName.toLowerCase() != 'html') {
      src = src.parentNode
      string = string + ',' + src.tagName + '(' + src.className + ')'
      if (src == obj) return true
    }
    return false
  },
  getObjectByClassName: function (e, className) {
    let src = this.getSrcElement(e)
    if (src.className == className) return src
    while (src && src.tagName.toLowerCase() != 'html') {
      src = src.parentNode
      if (src.className == className) return src
    }
    return false
  },
  getObjectByAttribute: function (e, attribute) {
    let src = this.getSrcElement(e)
    var att = src.getAttribute(attribute)
    if (!att) att = src[attribute]
    if (att) return src
    while (src && src.tagName.toLowerCase() != 'html') {
      src = src.parentNode
      var att = src.getAttribute('attribute')
      if (!att) att = src[attribute]
      if (att) return src
    }
    return false
  },
  getUniqueId: function () {
    let no = String(Math.random())
    no = no.replace('.', '')
    let no2 = String(Math.random())
    no2 = no2.replace('.', '')
    return no + no2
  },
  getAssociativeArrayFromString: function (propertyString) {
    if (!propertyString) return
    const retArray = new Array()
    const items = propertyString.split(/,/g)
    for (let no = 0; no < items.length; no++) {
      const tokens = items[no].split(/:/)
      retArray[tokens[0]] = tokens[1]
    }
    return retArray
  },
  correctPng: function (el) {
    el = DHTMLSuite.commonObj.getEl(el)
    const img = el
    const width = img.width
    const height = img.height
    const html =
      "<span style=\"display:inline-block;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" +
      img.src +
      "',sizingMethod='scale');width:" +
      width +
      ';height:' +
      height +
      '"></span>'
    img.outerHTML = html
  },
  __evaluateJs: function (obj) {
    obj = this.getEl(obj)
    const scriptTags = obj.getElementsByTagName('SCRIPT')
    const string = ''
    let jsCode = ''
    for (let no = 0; no < scriptTags.length; no++) {
      if (scriptTags[no].src) {
        const head = document.getElementsByTagName('head')[0]
        const scriptObj = document.createElement('script')
        scriptObj.setAttribute('type', 'text/javascript')
        scriptObj.setAttribute('src', scriptTags[no].src)
      } else {
        jsCode = DHTMLSuite.clientInfoObj.isOpera
          ? jsCode + scriptTags[no].text + '\n'
          : jsCode + scriptTags[no].innerHTML
      }
    }
    if (jsCode) this.__installScript(jsCode)
  },
  __installScript: function (script) {
    try {
      if (!script) return
      if (window.execScript) {
        window.execScript(script)
      } else if (window.jQuery && jQuery.browser.safari) {
        window.setTimeout(script, 0)
      } else {
        window.setTimeout(script, 0)
      }
    } catch (e) {}
  },
  __evaluateCss: function (obj) {
    obj = this.getEl(obj)
    const cssTags = obj.getElementsByTagName('STYLE')
    const head = document.getElementsByTagName('HEAD')[0]
    for (let no = 0; no < cssTags.length; no++) {
      head.appendChild(cssTags[no])
    }
  }
}
DHTMLSuite.clientInfo = function () {
  let browser
  let isOpera
  let isMSIE
  var isOldMSIE
  let isFirefox
  let navigatorVersion
  var isOldMSIE
}
DHTMLSuite.clientInfo.prototype = {
  init: function () {
    this.browser = navigator.userAgent
    this.isOpera = this.browser.toLowerCase().indexOf('opera') >= 0
    this.isFirefox = this.browser.toLowerCase().indexOf('firefox') >= 0
    this.isMSIE = this.browser.toLowerCase().indexOf('msie') >= 0
    this.isOldMSIE = Boolean(this.browser.toLowerCase().match(/msie\s[0-6]/gi))
    this.isSafari = this.browser.toLowerCase().indexOf('safari') >= 0
    this.navigatorVersion =
      navigator.appVersion.replace(/.*?MSIE\s(\d\.\d).*/g, '$1') / 1
    this.isOldMSIE = Boolean(this.isMSIE && this.navigatorVersion < 7)
  },
  getBrowserWidth: function () {
    if (self.innerWidth) return self.innerWidth
    return document.documentElement.offsetWidth
  },
  getBrowserHeight: function () {
    if (self.innerHeight) return self.innerHeight
    return document.documentElement.offsetHeight
  }
}
DHTMLSuite.domQuery = function () {
  document.getElementsByClassName = this.getElementsByClassName
  document.getElementsByAttribute = this.getElementsByAttribute
}
DHTMLSuite.domQuery.prototype = {}
