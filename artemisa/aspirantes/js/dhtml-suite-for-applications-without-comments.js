if (!String.trim) {
  String.prototype.trim = function () {
    return this.replace(/^\s+|\s+$/, "");
  };
}
const DHTMLSuite_funcs = new Object();
if (!window.DHTML_SUITE_THEME) var DHTML_SUITE_THEME = "blue";
if (!window.DHTML_SUITE_THEME_FOLDER) {
  var DHTML_SUITE_THEME_FOLDER = "../themes/";
}
if (!window.DHTML_SUITE_JS_FOLDER) {
  var DHTML_SUITE_JS_FOLDER = "../js/separateFiles/";
}
let DHTMLSuite = new Object();
let standardObjectsCreated = false;
DHTMLSuite.eventEls = new Array();
const widgetDep = new Object();
widgetDep.formValidator = ["dhtmlSuite-formUtil.js"];
widgetDep.paneSplitter = [
  "dhtmlSuite-paneSplitter.js",
  "dhtmlSuite-paneSplitterModel.js",
  "dhtmlSuite-dynamicContent.js",
  "ajax.js",
];
widgetDep.menuBar = [
  "dhtmlSuite-menuBar.js",
  "dhtmlSuite-menuItem.js",
  "dhtmlSuite-menuModel.js",
];
widgetDep.windowWidget = [
  "dhtmlSuite-windowWidget.js",
  "dhtmlSuite-resize.js",
  "dhtmlSuite-dragDropSimple.js",
  "ajax.js",
  "dhtmlSuite-dynamicContent.js",
];
widgetDep.colorWidget = [
  "dhtmlSuite-colorWidgets.js",
  "dhtmlSuite-colorUtil.js",
];
widgetDep.colorSlider = [
  "dhtmlSuite-colorWidgets.js",
  "dhtmlSuite-colorUtil.js",
  "dhtmlSuite-slider.js",
];
widgetDep.colorPalette = [
  "dhtmlSuite-colorWidgets.js",
  "dhtmlSuite-colorUtil.js",
];
widgetDep.calendar = ["dhtmlSuite-calendar.js", "dhtmlSuite-dragDropSimple.js"];
widgetDep.dragDropTree = ["dhtmlSuite-dragDropTree.js"];
widgetDep.slider = ["dhtmlSuite-slider.js"];
widgetDep.dragDrop = ["dhtmlSuite-dragDrop.js"];
widgetDep.imageEnlarger = [
  "dhtmlSuite-imageEnlarger.js",
  "dhtmlSuite-dragDropSimple.js",
];
widgetDep.imageSelection = ["dhtmlSuite-imageSelection.js"];
widgetDep.floatingGallery = [
  "dhtmlSuite-floatingGallery.js",
  "dhtmlSuite-mediaModel.js",
];
widgetDep.contextMenu = [
  "dhtmlSuite-contextMenu.js",
  "dhtmlSuite-menuBar.js",
  "dhtmlSuite-menuItem.js",
  "dhtmlSuite-menuModel.js",
];
widgetDep.dynamicContent = ["dhtmlSuite-dynamicContent.js", "ajax.js"];
widgetDep.textEdit = [
  "dhtmlSuite-textEdit.js",
  "dhtmlSuite-textEditModel.js",
  "dhtmlSuite-listModel.js",
];
widgetDep.listModel = ["dhtmlSuite-listModel.js"];
widgetDep.resize = ["dhtmlSuite-resize.js"];
widgetDep.dragDropSimple = ["dhtmlSuite-dragDropSimple.js"];
widgetDep.dynamicTooltip = [
  "dhtmlSuite-dynamicTooltip.js",
  "dhtmlSuite-dynamicContent.js",
  "ajax.js",
];
widgetDep.modalMessage = [
  "dhtmlSuite-modalMessage.js",
  "dhtmlSuite-dynamicContent.js",
  "ajax.js",
];
widgetDep.tableWidget = ["dhtmlSuite-tableWidget.js", "ajax.js"];
widgetDep.progressBar = ["dhtmlSuite-progressBar.js"];
widgetDep.tabView = [
  "dhtmlSuite-tabView.js",
  "dhtmlSuite-dynamicContent.js",
  "ajax.js",
];
widgetDep.infoPanel = [
  "dhtmlSuite-infoPanel.js",
  "dhtmlSuite-dynamicContent.js",
  "ajax.js",
];
widgetDep.form = [
  "dhtmlSuite-formUtil.js",
  "dhtmlSuite-dynamicContent.js",
  "ajax.js",
];
const depCache = new Object();
DHTMLSuite.include = function (widget) {
  if (!widgetDep[widget]) {
    alert(
      "Cannot find the files for widget " +
        widget +
        ". Please verify that the name is correct"
    );
    return;
  }
  const files = widgetDep[widget];
  for (let no = 0; no < files.length; no++) {
    if (!depCache[files[no]]) {
      document.write("<" + "script");
      document.write(' language="javascript"');
      document.write(' type="text/javascript"');
      document.write(' src="' + DHTML_SUITE_JS_FOLDER + files[no] + '">');
      document.write("</" + "script" + ">");
      depCache[files[no]] = true;
    }
  }
};
DHTMLSuite.discardElement = function (element) {
  element = DHTMLSuite.commonObj.getEl(element);
  let gBin = document.getElementById("IELeakGBin");
  if (!gBin) {
    gBin = document.createElement("DIV");
    gBin.id = "IELeakGBin";
    gBin.style.display = "none";
    document.body.appendChild(gBin);
  }
  gBin.appendChild(element);
  gBin.innerHTML = "";
};
DHTMLSuite.createStandardObjects = function () {
  DHTMLSuite.clientInfoObj = new DHTMLSuite.clientInfo();
  DHTMLSuite.clientInfoObj.init();
  if (!DHTMLSuite.configObj) {
    DHTMLSuite.configObj = new DHTMLSuite.config();
    DHTMLSuite.configObj.init();
  }
  DHTMLSuite.commonObj = new DHTMLSuite.common();
  DHTMLSuite.variableStorage = new DHTMLSuite.globalVariableStorage();
  DHTMLSuite.commonObj.init();
  DHTMLSuite.domQueryObj = new DHTMLSuite.domQuery();
  DHTMLSuite.commonObj.addEvent(window, "unload", function () {
    DHTMLSuite.commonObj.__clearMemoryGarbage();
  });
  standardObjectsCreated = true;
};
DHTMLSuite.config = function () {
  let imagePath;
  let cssPath;
  let defaultCssPath;
  let defaultImagePath;
};
DHTMLSuite.config.prototype = {
  init: function () {
    this.imagePath = DHTML_SUITE_THEME_FOLDER + DHTML_SUITE_THEME + "/images/";
    this.cssPath = DHTML_SUITE_THEME_FOLDER + DHTML_SUITE_THEME + "/css/";
    this.defaultCssPath = this.cssPath;
    this.defaultImagePath = this.imagePath;
  },
  setCssPath: function (newCssPath) {
    this.cssPath = newCssPath;
  },
  resetCssPath: function () {
    this.cssPath = this.defaultCssPath;
  },
  resetImagePath: function () {
    this.imagePath = this.defaultImagePath;
  },
  setImagePath: function (newImagePath) {
    this.imagePath = newImagePath;
  },
};
DHTMLSuite.globalVariableStorage = function () {
  let menuBar_highlightedItems;
  this.menuBar_highlightedItems = new Array();
  let arrayDSObjects;
  let arrayOfDhtmlSuiteObjects;
  this.arrayDSObjects = new Array();
  this.arrayOfDhtmlSuiteObjects = this.arrayDSObjects;
  let ajaxObjects;
  this.ajaxObjects = new Array();
};
DHTMLSuite.globalVariableStorage.prototype = {};
DHTMLSuite.common = function () {
  let loadedCSSFiles;
  let cssCacheStatus;
  let eventEls;
  let isOkToSelect;
  this.okToSelect = true;
  this.cssCacheStatus = true;
  this.eventEls = new Array();
};
DHTMLSuite.common.prototype = {
  init: function () {
    this.loadedCSSFiles = new Array();
  },
  loadCSS: function (cssFile, prefixConfigPath) {
    if (!prefixConfigPath && prefixConfigPath !== false) {
      prefixConfigPath = true;
    }
    if (!this.loadedCSSFiles[cssFile]) {
      this.loadedCSSFiles[cssFile] = true;
      const lt = document.createElement("LINK");
      if (!this.cssCacheStatus) {
        cssFile = cssFile.indexOf("?") >= 0 ? cssFile + "&" : cssFile + "?";
        cssFile = cssFile + "rand=" + Math.random();
      }
      if (prefixConfigPath) {
        lt.href = DHTMLSuite.configObj.cssPath + cssFile;
      } else {
        lt.href = cssFile;
      }
      lt.rel = "stylesheet";
      lt.media = "screen";
      lt.type = "text/css";
      document.getElementsByTagName("HEAD")[0].appendChild(lt);
    }
  },
  __setTextSelOk: function (okToSelect) {
    this.okToSelect = okToSelect;
  },
  __isTextSelOk: function () {
    return this.okToSelect;
  },
  setCssCacheStatus: function (cssCacheStatus) {
    this.cssCacheStatus = cssCacheStatus;
  },
  getEl: function (elRef) {
    if (typeof elRef === "string") {
      if (document.getElementById(elRef)) return document.getElementById(elRef);
      if (document.forms[elRef]) return document.forms[elRef];
      if (document[elRef]) return document[elRef];
      if (window[elRef]) return window[elRef];
    }
    return elRef;
  },
  isArray: function (el) {
    if (el.constructor.toString().indexOf("Array") != -1) return true;
    return false;
  },
  getStyle: function (el, property) {
    el = this.getEl(el);
    if (document.defaultView && document.defaultView.getComputedStyle) {
      var retVal = null;
      const comp = document.defaultView.getComputedStyle(el, "");
      if (comp) {
        retVal = comp[property];
      }
      return el.style[property] || retVal;
    }
    if (
      document.documentElement.currentStyle &&
      DHTMLSuite.clientInfoObj.isMSIE
    ) {
      var retVal = null;
      if (el.currentStyle) value = el.currentStyle[property];
      return el.style[property] || retVal;
    }
    return el.style[property];
  },
  getLeftPos: function (el) {
    if (document.getBoxObjectFor) {
      if (
        el.tagName != "INPUT" &&
        el.tagName != "SELECT" &&
        el.tagName != "TEXTAREA"
      ) {
        return document.getBoxObjectFor(el).x;
      }
    }
    let returnValue = el.offsetLeft;
    while ((el = el.offsetParent) !== null) {
      if (el.tagName != "HTML") {
        returnValue += el.offsetLeft;
        if (document.all) returnValue += el.clientLeft;
      }
    }
    return returnValue;
  },
  getTopPos: function (el) {
    if (document.getBoxObjectFor) {
      if (
        el.tagName != "INPUT" &&
        el.tagName != "SELECT" &&
        el.tagName != "TEXTAREA"
      ) {
        return document.getBoxObjectFor(el).y;
      }
    }
    let returnValue = el.offsetTop;
    while ((el = el.offsetParent) !== null) {
      if (el.tagName != "HTML") {
        returnValue += el.offsetTop - el.scrollTop;
        if (document.all) returnValue += el.clientTop;
      }
    }
    return returnValue;
  },
  getCookie: function (name) {
    const start = document.cookie.indexOf(name + "=");
    const len = start + name.length + 1;
    if (!start && name != document.cookie.substring(0, name.length)) {
      return null;
    }
    if (start == -1) return null;
    let end = document.cookie.indexOf(";", len);
    if (end == -1) end = document.cookie.length;
    return unescape(document.cookie.substring(len, end));
  },
  setCookie: function (name, value, expires, path, domain, secure) {
    expires = expires * 60 * 60 * 24 * 1000;
    const today = new Date();
    const expires_date = new Date(today.getTime() + expires);
    const cookieString =
      name +
      "=" +
      escape(value) +
      (expires ? ";expires=" + expires_date.toGMTString() : "") +
      (path ? ";path=" + path : "") +
      (domain ? ";domain=" + domain : "") +
      (secure ? ";secure" : "");
    document.cookie = cookieString;
  },
  deleteCookie: function (name, path, domain) {
    if (this.getCookie(name)) {
      document.cookie =
        name +
        "=" +
        (path ? ";path=" + path : "") +
        (domain ? ";domain=" + domain : "") +
        ";expires=Thu,01-Jan-1970 00:00:01 GMT";
    }
  },
  cancelEvent: function () {
    return false;
  },
  addEvent: function (obj, type, fn, suffix) {
    if (!suffix) suffix = "";
    if (obj.attachEvent) {
      if (typeof DHTMLSuite_funcs[type + fn + suffix] !== "function") {
        DHTMLSuite_funcs[type + fn + suffix] = function () {
          fn.apply(window.event.srcElement);
        };
        obj.attachEvent("on" + type, DHTMLSuite_funcs[type + fn + suffix]);
      }
      obj = null;
    } else {
      obj.addEventListener(type, fn, false);
    }
    this.__addEventEl(obj);
  },
  removeEvent: function (obj, type, fn, suffix) {
    if (obj.detachEvent) {
      obj.detachEvent("on" + type, DHTMLSuite_funcs[type + fn + suffix]);
      DHTMLSuite_funcs[type + fn + suffix] = null;
      obj = null;
    } else {
      obj.removeEventListener(type, fn, false);
    }
  },
  __clearMemoryGarbage: function () {
    if (!DHTMLSuite.clientInfoObj.isMSIE) return;
    for (var no = 0; no < DHTMLSuite.eventEls.length; no++) {
      try {
        let el = DHTMLSuite.eventEls[no];
        el.onclick = null;
        el.onmousedown = null;
        el.onmousemove = null;
        el.onmouseout = null;
        el.onmouseover = null;
        el.onmouseup = null;
        el.onfocus = null;
        el.onblur = null;
        el.onkeydown = null;
        el.onkeypress = null;
        el.onkeyup = null;
        el.onselectstart = null;
        el.ondragstart = null;
        el.oncontextmenu = null;
        el.onscroll = null;
        el = null;
      } catch (e) {}
    }
    for (var no in DHTMLSuite.variableStorage.arrayDSObjects) {
      DHTMLSuite.variableStorage.arrayDSObjects[no] = null;
    }
    window.onbeforeunload = null;
    window.onunload = null;
    DHTMLSuite = null;
  },
  __addEventEl: function (el) {
    DHTMLSuite.eventEls[DHTMLSuite.eventEls.length] = el;
  },
  getSrcElement: function (e) {
    let el;
    if (e.target) el = e.target;
    else if (e.srcElement) el = e.srcElement;
    if (el.nodeType == 3) el = el.parentNode;
    return el;
  },
  getKeyFromEvent: function (e) {
    const code = this.getKeyCode(e);
    return String.fromCharCode(code);
  },
  getKeyCode: function (e) {
    if (e.keyCode) code = e.keyCode;
    else if (e.which) code = e.which;
    return code;
  },
  isObjectClicked: function (obj, e) {
    let src = this.getSrcElement(e);
    let string = src.tagName + "(" + src.className + ")";
    if (src == obj) return true;
    while (src.parentNode && src.tagName.toLowerCase() != "html") {
      src = src.parentNode;
      string = string + "," + src.tagName + "(" + src.className + ")";
      if (src == obj) return true;
    }
    return false;
  },
  getObjectByClassName: function (e, className) {
    let src = this.getSrcElement(e);
    if (src.className == className) return src;
    while (src && src.tagName.toLowerCase() != "html") {
      src = src.parentNode;
      if (src.className == className) return src;
    }
    return false;
  },
  getObjectByAttribute: function (e, attribute) {
    let src = this.getSrcElement(e);
    var att = src.getAttribute(attribute);
    if (!att) att = src[attribute];
    if (att) return src;
    while (src && src.tagName.toLowerCase() != "html") {
      src = src.parentNode;
      var att = src.getAttribute("attribute");
      if (!att) att = src[attribute];
      if (att) return src;
    }
    return false;
  },
  getUniqueId: function () {
    let no = String(Math.random());
    no = no.replace(".", "");
    let no2 = String(Math.random());
    no2 = no2.replace(".", "");
    return no + no2;
  },
  getAssociativeArrayFromString: function (propertyString) {
    if (!propertyString) return;
    const retArray = new Array();
    const items = propertyString.split(/,/g);
    for (let no = 0; no < items.length; no++) {
      const tokens = items[no].split(/:/);
      retArray[tokens[0]] = tokens[1];
    }
    return retArray;
  },
  correctPng: function (el) {
    el = DHTMLSuite.commonObj.getEl(el);
    const img = el;
    const width = img.width;
    const height = img.height;
    const html =
      "<span style=\"display:inline-block;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" +
      img.src +
      "',sizingMethod='scale');width:" +
      width +
      ";height:" +
      height +
      '"></span>';
    img.outerHTML = html;
  },
  __evaluateJs: function (obj) {
    obj = this.getEl(obj);
    const scriptTags = obj.getElementsByTagName("SCRIPT");
    const string = "";
    let jsCode = "";
    for (let no = 0; no < scriptTags.length; no++) {
      if (scriptTags[no].src) {
        const head = document.getElementsByTagName("head")[0];
        const scriptObj = document.createElement("script");
        scriptObj.setAttribute("type", "text/javascript");
        scriptObj.setAttribute("src", scriptTags[no].src);
      } else {
        jsCode = DHTMLSuite.clientInfoObj.isOpera
          ? jsCode + scriptTags[no].text + "\n"
          : jsCode + scriptTags[no].innerHTML;
      }
    }
    if (jsCode) this.__installScript(jsCode);
  },
  __installScript: function (script) {
    try {
      if (!script) return;
      if (window.execScript) {
        window.execScript(script);
      } else if (window.jQuery && jQuery.browser.safari) {
        window.setTimeout(script, 0);
      } else {
        window.setTimeout(script, 0);
      }
    } catch (e) {}
  },
  __evaluateCss: function (obj) {
    obj = this.getEl(obj);
    const cssTags = obj.getElementsByTagName("STYLE");
    const head = document.getElementsByTagName("HEAD")[0];
    for (let no = 0; no < cssTags.length; no++) {
      head.appendChild(cssTags[no]);
    }
  },
};
DHTMLSuite.clientInfo = function () {
  let browser;
  let isOpera;
  let isMSIE;
  var isOldMSIE;
  let isFirefox;
  let navigatorVersion;
  var isOldMSIE;
};
DHTMLSuite.clientInfo.prototype = {
  init: function () {
    this.browser = navigator.userAgent;
    this.isOpera = this.browser.toLowerCase().indexOf("opera") >= 0;
    this.isFirefox = this.browser.toLowerCase().indexOf("firefox") >= 0;
    this.isMSIE = this.browser.toLowerCase().indexOf("msie") >= 0;
    this.isOldMSIE = Boolean(this.browser.toLowerCase().match(/msie\s[0-6]/gi));
    this.isSafari = this.browser.toLowerCase().indexOf("safari") >= 0;
    this.navigatorVersion =
      navigator.appVersion.replace(/.*?MSIE\s(\d\.\d).*/g, "$1") / 1;
    this.isOldMSIE = Boolean(this.isMSIE && this.navigatorVersion < 7);
  },
  getBrowserWidth: function () {
    if (self.innerWidth) return self.innerWidth;
    return document.documentElement.offsetWidth;
  },
  getBrowserHeight: function () {
    if (self.innerHeight) return self.innerHeight;
    return document.documentElement.offsetHeight;
  },
};
DHTMLSuite.domQuery = function () {
  document.getElementsByClassName = this.getElementsByClassName;
  document.getElementsByAttribute = this.getElementsByAttribute;
};
DHTMLSuite.domQuery.prototype = {};
DHTMLSuite.tableWidgetPageHandler = function () {
  let tableRef;
  let targetRef;
  let txtPrevious;
  let txtNext;
  let txtFirst;
  let txtLast;
  let txtResultPrefix;
  let txtResultTo;
  let txtResultOf;
  let totalNumberOfRows;
  let rowsPerPage;
  let layoutCSS;
  let activePageNumber;
  let mainDivEl;
  let resultDivElement;
  let pageListDivEl;
  let objectIndex;
  let linkPagePrefix;
  let linkPageSuffix;
  let maximumNumberOfPageLinks;
  let callbackOnAfterNavigate;
  this.txtPrevious = "Previous";
  this.txtNext = "Next";
  this.txtResultPrefix = "Result: ";
  this.txtResultTo = "to";
  this.txtResultOf = "of";
  this.txtFirst = "First";
  this.txtLast = "Last";
  this.tableRef = false;
  this.targetRef = false;
  this.totalNumberOfRows = false;
  this.activePageNumber = 0;
  this.layoutCSS = "table-widget-page-handler.css";
  this.linkPagePrefix = "";
  this.linkPageSuffix = "";
  this.maximumNumberOfPageLinks = false;
  this.callbackOnAfterNavigate = false;
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.tableWidgetPageHandler.prototype = {
  setTableRef: function (tableRef) {
    this.tableRef = tableRef;
    this.tableRef.setPageHandler(this);
  },
  setTargetId: function (idOfHTMLElement) {
    if (!document.getElementById(idOfHTMLElement)) {
      alert(
        "ERROR IN tableWidgetPageHandler.setTargetId:\nElement with id " +
          idOfHTMLElement +
          " does not exists"
      );
      return;
    }
    this.targetRef = document.getElementById(idOfHTMLElement);
  },
  setTxtPrevious: function (newText) {
    this.txtPrevious = newText;
  },
  setLinkPagePrefix: function (linkPagePrefix) {
    this.linkPagePrefix = linkPagePrefix;
  },
  setLinkPageSuffix: function (linkPageSuffix) {
    this.linkPageSuffix = linkPageSuffix;
  },
  setTxtNext: function (newText) {
    this.txtNext = newText;
  },
  setTxtResultOf: function (txtResultOf) {
    this.txtResultOf = txtResultOf;
  },
  setTxtResultTo: function (txtResultTo) {
    this.txtResultTo = txtResultTo;
  },
  setTxtResultPrefix: function (txtResultPrefix) {
    this.txtResultPrefix = txtResultPrefix;
  },
  setTxtFirstPage: function (txtFirst) {
    this.txtFirst = txtFirst;
  },
  setTxtLastPage: function (txtLast) {
    this.txtLast = txtLast;
  },
  setTotalNumberOfRows: function (totalNumberOfRows) {
    this.totalNumberOfRows = totalNumberOfRows;
  },
  setCallbackOnAfterNavigate: function (callbackOnAfterNavigate) {
    this.callbackOnAfterNavigate = callbackOnAfterNavigate;
  },
  setLayoutCss: function (layoutCSS) {
    this.layoutCSS = layoutCSS;
  },
  setMaximumNumberOfPageLinks: function (maximumNumberOfPageLinks) {
    this.maximumNumberOfPageLinks = maximumNumberOfPageLinks;
  },
  init: function () {
    this.rowsPerPage = this.tableRef.getServersideSortNumberOfRows();
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    this.__createMainDivEls();
    this.setHTMLOfResultList();
    this.__createPageLinks();
    this.goToPage(1);
  },
  __createMainDivEls: function () {
    if (!this.targetRef) {
      alert(
        "Error creating table widget page handler. Remember to specify targetRef"
      );
      return;
    }
    this.mainDivEl = document.createElement("DIV");
    this.mainDivEl.className = "DHTMLSuite_tableWidgetPageHandler_mainDiv";
    this.targetRef.appendChild(this.mainDivEl);
    this.resultDivElement = document.createElement("DIV");
    this.resultDivElement.className =
      "DHTMLSuite_tableWidgetPageHandler_result";
    this.mainDivEl.appendChild(this.resultDivElement);
    this.pageListDivEl = document.createElement("DIV");
    this.pageListDivEl.className = "DHTMLSuite_tableWidgetPageHandler_pageList";
    this.mainDivEl.appendChild(this.pageListDivEl);
  },
  setHTMLOfResultList: function () {
    this.resultDivElement.innerHTML = "";
    const html =
      this.txtResultPrefix +
      ((this.activePageNumber - 1) * this.rowsPerPage + 1) +
      " " +
      this.txtResultTo +
      " " +
      Math.min(
        this.totalNumberOfRows,
        this.activePageNumber * this.rowsPerPage
      ) +
      " " +
      this.txtResultOf +
      " " +
      this.totalNumberOfRows;
    this.resultDivElement.innerHTML = html;
  },
  __createPageLinks: function () {
    const ind = this.objectIndex;
    this.pageListDivEl.innerHTML = "";
    const numberOfPages = Math.ceil(this.totalNumberOfRows / this.rowsPerPage);
    if (
      this.maximumNumberOfPageLinks &&
      this.maximumNumberOfPageLinks < numberOfPages
    ) {
      var span = document.createElement("SPAN");
      span.innerHTML = this.linkPagePrefix;
      this.pageListDivEl.appendChild(span);
      span.className = "DHTMLSuite_pageHandler_firstLink";
      const fl = document.createElement("A");
      fl.innerHTML = this.txtFirst;
      fl.href = "#";
      fl.id = "pageLink_1";
      fl.onclick = function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__navigate(e);
      };
      span.appendChild(fl);
      DHTMLSuite.commonObj.__addEventEl(fl);
    }
    var span = document.createElement("SPAN");
    span.innerHTML = this.linkPagePrefix;
    this.pageListDivEl.appendChild(span);
    span.className = "DHTMLSuite_pageHandler_previousLink";
    const previousLink = document.createElement("A");
    previousLink.innerHTML = this.txtPrevious;
    previousLink.href = "#";
    previousLink.id = "previous";
    previousLink.onclick = function (e) {
      return DHTMLSuite.variableStorage.arrayDSObjects[ind].__navigate(e);
    };
    span.appendChild(previousLink);
    DHTMLSuite.commonObj.__addEventEl(previousLink);
    if (this.activePageNumber == 1) {
      previousLink.className = "previousLinkDisabled";
    } else previousLink.className = "previousLink";
    let startNumberToShow = 1;
    let endNumberToShow = numberOfPages;
    if (
      this.maximumNumberOfPageLinks &&
      this.maximumNumberOfPageLinks < numberOfPages
    ) {
      startNumberToShow = Math.max(
        1,
        Math.round(this.activePageNumber - this.maximumNumberOfPageLinks / 2)
      );
      endNumberToShow = Math.min(
        numberOfPages,
        startNumberToShow + this.maximumNumberOfPageLinks - 1
      );
      if (endNumberToShow - startNumberToShow < this.maximumNumberOfPageLinks) {
        startNumberToShow = Math.max(
          1,
          endNumberToShow - this.maximumNumberOfPageLinks + 1
        );
      }
    }
    for (let no = startNumberToShow; no <= endNumberToShow; no++) {
      var span = document.createElement("SPAN");
      span.innerHTML = this.linkPagePrefix;
      this.pageListDivEl.appendChild(span);
      const pageLink = document.createElement("A");
      if (no == this.activePageNumber) {
        pageLink.className = "DHTMLSuite_tableWidgetPageHandler_activePage";
      } else {
        pageLink.className = "DHTMLSuite_tableWidgetPageHandler_inactivePage";
      }
      pageLink.innerHTML = no;
      pageLink.href = "#";
      pageLink.id = "pageLink_" + no;
      pageLink.onclick = function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__navigate(e);
      };
      DHTMLSuite.commonObj.__addEventEl(pageLink);
      this.pageListDivEl.appendChild(pageLink);
      var span = document.createElement("SPAN");
      span.innerHTML = this.linkPageSuffix;
      this.pageListDivEl.appendChild(span);
    }
    var span = document.createElement("SPAN");
    span.innerHTML = this.linkPagePrefix;
    this.pageListDivEl.appendChild(span);
    span.className = "DHTMLSuite_pageHandler_nextLink";
    const nextLink = document.createElement("A");
    nextLink.innerHTML = this.txtNext;
    nextLink.id = "next";
    nextLink.href = "#";
    nextLink.onclick = function (e) {
      return DHTMLSuite.variableStorage.arrayDSObjects[ind].__navigate(e);
    };
    DHTMLSuite.commonObj.__addEventEl(nextLink);
    span.appendChild(nextLink);
    if (this.activePageNumber == numberOfPages) {
      nextLink.className = "nextLinkDisabled";
    } else nextLink.className = "nextLink";
    if (
      this.maximumNumberOfPageLinks &&
      this.maximumNumberOfPageLinks < numberOfPages
    ) {
      var span = document.createElement("SPAN");
      span.innerHTML = this.linkPagePrefix;
      this.pageListDivEl.appendChild(span);
      span.className = "DHTMLSuite_pageHandler_lastLink";
      const ll = document.createElement("A");
      ll.innerHTML = this.txtLast;
      ll.href = "#";
      ll.id = "pageLink_" + numberOfPages;
      ll.onclick = function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__navigate(e);
      };
      span.appendChild(ll);
      DHTMLSuite.commonObj.__addEventEl(ll);
    }
  },
  __navigate: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    const initActivePageNumber = this.activePageNumber;
    const numberOfPages = Math.ceil(this.totalNumberOfRows / this.rowsPerPage);
    if (src.id.indexOf("pageLink_") >= 0) {
      const pageNo = src.id.replace(/[^0-9]/gi, "") / 1;
      this.activePageNumber = pageNo;
    }
    if (src.id == "next") {
      this.activePageNumber++;
      if (this.activePageNumber > numberOfPages) {
        this.activePageNumber = numberOfPages;
      }
    }
    if (src.id == "previous") {
      this.activePageNumber--;
      if (this.activePageNumber < 1) this.activePageNumber = 1;
    }
    if (this.activePageNumber != initActivePageNumber) {
      this.tableRef.serversideSortCurrentStartIndex =
        (this.activePageNumber - 1) * this.rowsPerPage;
      this.tableRef.__getItemsFromServer(this.callbackOnAfterNavigate);
      this.setHTMLOfResultList();
      this.__createPageLinks();
    }
    return false;
  },
  __resetActivePageNumber: function () {
    this.activePageNumber = 1;
    this.setHTMLOfResultList();
    this.__createPageLinks();
  },
  goToPage: function (pageNo) {
    const initActivePageNumber = this.activePageNumber;
    this.activePageNumber = pageNo;
    if (this.activePageNumber != initActivePageNumber) {
      this.tableRef.serversideSortCurrentStartIndex =
        (this.activePageNumber - 1) * this.rowsPerPage;
      this.tableRef.__getItemsFromServer(this.callbackOnAfterNavigate);
      this.setHTMLOfResultList();
      this.__createPageLinks();
    }
  },
};
DHTMLSuite.tableWidget = function () {
  let tableWidget_okToSort;
  let activeColumn;
  let idOfTable;
  let tableObj;
  let widthOfTable;
  let heightOfTable;
  let columnSortArray;
  let layoutCSS;
  let noCssLayout;
  let serversideSort;
  let serversideSortAscending;
  let tableCurrentlySortedBy;
  let serversideSortFileName;
  let serversideSortNumberOfRows;
  let serversideSortCurrentStartIndex;
  let serversideSortExtraSearchCriterias;
  let pageHandler;
  let rowClickCallBackFunction;
  let objectIndex;
  this.serversideSort = false;
  this.serversideSortAscending = true;
  this.tableCurrentlySortedBy = false;
  this.serversideSortFileName = false;
  this.serversideSortCurrentStartIndex = 0;
  this.serversideSortExtraSearchCriterias = "";
  this.rowClickCallBackFunction = false;
  this.setRowDblClickCallBackFunction = false;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.tableWidget.prototype = {
  init: function () {
    this.tableWidget_okToSort = true;
    this.activeColumn = false;
    if (!this.layoutCSS) this.layoutCSS = "table-widget.css";
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    this.__initTableWidget();
  },
  setLayoutCss: function (newCssFile) {
    this.layoutCSS = newCSSFile;
  },
  setRowClickCallBack: function (rowClickCallBackFunction) {
    this.rowClickCallBackFunction = rowClickCallBackFunction;
  },
  setRowDblClickCallBack: function (setRowDblClickCallBackFunction) {
    this.setRowDblClickCallBackFunction = setRowDblClickCallBackFunction;
  },
  setServerSideSort: function (serversideSort) {
    this.serversideSort = serversideSort;
  },
  setServersideSearchCriterias: function (serversideSortExtraSearchCriterias) {
    this.serversideSortExtraSearchCriterias =
      serversideSortExtraSearchCriterias;
  },
  getServersideSortNumberOfRows: function (serversideSort) {
    return this.serversideSortNumberOfRows;
  },
  setServersideSortNumberOfRows: function (serversideSortNumberOfRows) {
    this.serversideSortNumberOfRows = serversideSortNumberOfRows;
  },
  setServersideSortFileName: function (serversideSortFileName) {
    this.serversideSortFileName = serversideSortFileName;
  },
  setNoCssLayout: function () {
    this.noCssLayout = true;
  },
  sortTableByColumn: function (columnIndex, howToSort) {
    if (!howToSort) howToSort = "ascending";
    const tableObj = document.getElementById(this.idOfTable);
    const firstRow = tableObj.rows[0];
    const tds = firstRow.cells;
    if (tds[columnIndex] && this.columnSortArray[columnIndex]) {
      this.__sortTable(tds[columnIndex], howToSort);
    }
  },
  setTableId: function (idOfTable) {
    this.idOfTable = idOfTable;
    try {
      this.tableObj = document.getElementById(idOfTable);
    } catch (e) {}
  },
  setTableWidth: function (width) {
    this.widthOfTable = width;
  },
  setTableHeight: function (height) {
    this.heightOfTable = height;
  },
  setColumnSort: function (columnSortArray) {
    this.columnSortArray = columnSortArray;
  },
  addNewRow: function (cellContent) {
    const tObj = document.getElementById(this.idOfTable);
    const tb = tObj.getElementsByTagName("TBODY")[0];
    const row = tb.insertRow(-1);
    for (let no = 0; no < cellContent.length; no++) {
      const cell = row.insertCell(-1);
      cell.innerHTML = cellContent[no];
    }
    this.__parseDataRows(tObj);
  },
  addNewColumn: function (columnContent, headerText, sortMethod) {
    this.columnSortArray[this.columnSortArray.length] = sortMethod;
    const tableObj = document.getElementById(this.idOfTable);
    const tbody = tableObj.getElementsByTagName("TBODY")[0];
    const thead = tableObj.getElementsByTagName("THEAD")[0];
    const bodyRows = tbody.rows;
    const headerRows = thead.rows;
    cellIndexSubtract = 1;
    if (DHTMLSuite.clientInfoObj.isMSIE) cellIndexSubtract = 0;
    const headerCell = headerRows[0].insertCell(
      headerRows[0].cells.length - cellIndexSubtract
    );
    if (!this.noCssLayout) {
      headerCell.className = "DHTMLSuite_tableWidget_headerCell";
    }
    headerCell.onselectstart = function () {
      return false;
    };
    DHTMLSuite.commonObj.__addEventEl(headerCell);
    headerCell.innerHTML = headerText;
    if (sortMethod) {
      this.__parseHeaderCell(headerCell);
    } else {
      headerCell.style.cursor = "default";
    }
    headerRows[0].cells[headerRows[0].cells.length - 1].style.borderRightWidth =
      "0px";
    headerRows[0].cells[headerRows[0].cells.length - 2].style.borderRightWidth =
      "1px";
    for (let no = 0; no < columnContent.length; no++) {
      const dataCell = bodyRows[no].insertCell(
        bodyRows[no].cells.length - cellIndexSubtract
      );
      dataCell.innerHTML = columnContent[no];
    }
    this.__parseDataRows(tableObj);
  },
  setPageHandler: function (ref) {
    this.pageHandler = ref;
  },
  __handleCallBackFromEvent: function (e, action) {
    if (document.all) e = event;
    let src = DHTMLSuite.commonObj.getSrcElement(e);
    if (
      (action == "rowClick" || action == "rowDblClick") &&
      src.tagName.toLowerCase() != "tr"
    ) {
      while (src.tagName.toLowerCase() != "tr") src = src.parentNode;
    }
    this.__createCallBackJavascriptString(action, src);
  },
  __createCallBackJavascriptString: function (action, el) {
    let callbackString = "";
    switch (action) {
      case "rowClick":
        if (!this.rowClickCallBackFunction) return;
        callbackString = this.rowClickCallBackFunction + "(el)";
        break;
      case "rowDblClick":
        if (!this.setRowDblClickCallBackFunction) return;
        callbackString = this.setRowDblClickCallBackFunction + "(el)";
        break;
    }
    this.__executeCallBack(callbackString, el);
  },
  __executeCallBack: function (callbackString, el) {
    if (!callbackString) return;
    try {
      eval(callbackString);
    } catch (e) {}
  },
  __parseHeaderCell: function (cellRef) {
    if (!this.noCssLayout) {
      cellRef.onmouseover = this.__highlightTableHeader;
      cellRef.onmouseout = this.__removeHighlightEffectFromTableHeader;
      cellRef.onmousedown = this.__mousedownOnTableHeader;
      cellRef.onmouseup = this.__highlightTableHeader;
    } else {
      cellRef.style.cursor = "pointer";
    }
    const refToThis = this;
    cellRef.onclick = function () {
      refToThis.__sortTable(this);
    };
    DHTMLSuite.commonObj.__addEventEl(cellRef);
    const img = document.createElement("IMG");
    img.src = DHTMLSuite.configObj.imagePath + "table-widget/arrow_up.gif";
    cellRef.appendChild(img);
    img.style.visibility = "hidden";
  },
  __parseDataRows: function (parentObj) {
    const ind = this.objectIndex;
    for (let no = 1; no < parentObj.rows.length; no++) {
      if (!this.noCssLayout) {
        parentObj.rows[no].onmouseover = this.__highlightTableRow;
        parentObj.rows[no].onmouseout =
          this.__removeHighlightEffectFromTableRow;
      }
      parentObj.rows[no].onclick = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[
          ind
        ].__handleCallBackFromEvent(e, "rowClick");
      };
      parentObj.rows[no].ondblclick = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[
          ind
        ].__handleCallBackFromEvent(e, "rowDblClick");
      };
      DHTMLSuite.commonObj.__addEventEl(parentObj.rows[no]);
      for (var no2 = 0; no2 < this.columnSortArray.length; no2++) {
        try {
          if (this.columnSortArray[no2] && this.columnSortArray[no2] == "N") {
            parentObj.rows[no].cells[no2].style.textAlign = "right";
          }
        } catch (e) {
          alert(
            "Error in __parseDataRows method-row: " + no + ",column:" + no2
          );
        }
      }
    }
    for (var no2 = 0; no2 < this.columnSortArray.length; no2++) {
      if (this.columnSortArray[no2] && this.columnSortArray[no2] == "N") {
        parentObj.rows[0].cells[no2].style.textAlign = "right";
      }
    }
  },
  __initTableWidget: function () {
    if (!this.columnSortArray) this.columnSortArray = new Array();
    this.widthOfTable = String(this.widthOfTable);
    this.heightOfTable = String(this.heightOfTable);
    const obj = document.getElementById(this.idOfTable);
    obj.parentNode.className = "DHTMLSuite_widget_tableDiv";
    if (
      navigator.userAgent.toLowerCase().indexOf("safari") == -1 &&
      !this.noCssLayout
    ) {
      if (!DHTMLSuite.clientInfoObj.isMSIE) {
        obj.parentNode.style.overflow = "hidden";
      } else {
        obj.parentNode.style.overflowX = "hidden";
        obj.parentNode.style.overflowY = "scroll";
      }
    }
    if (!this.noCssLayout) {
      if (this.widthOfTable.indexOf("%") >= 0) {
        obj.style.width = "100%";
        obj.parentNode.style.width = this.widthOfTable;
      } else {
        obj.style.width = this.widthOfTable + "px";
        obj.parentNode.style.width = this.widthOfTable + "px";
      }
      if (this.heightOfTable.indexOf("%") >= 0) {
        obj.parentNode.style.height = this.heightOfTable;
      } else {
        obj.parentNode.style.height = this.heightOfTable + "px";
      }
    }
    if (!DHTMLSuite.clientInfoObj.isMSIE) {
      this.__addEndCol(obj);
    } else {
      obj.style.cssText = "width:expression(this.parentNode.clientWidth)";
    }
    obj.cellSpacing = 0;
    obj.cellPadding = 0;
    if (!this.noCssLayout) obj.className = "DHTMLSuite_tableWidget";
    const tHead = obj.getElementsByTagName("THEAD")[0];
    const cells = tHead.getElementsByTagName("TD");
    var tBody = obj.getElementsByTagName("TBODY")[0];
    tBody.className = "DHTMLSuite_scrollingContent";
    for (let no = 0; no < cells.length; no++) {
      if (!this.noCssLayout) {
        cells[no].className = "DHTMLSuite_tableWidget_headerCell";
      }
      cells[no].onselectstart = function () {
        return false;
      };
      DHTMLSuite.commonObj.__addEventEl(cells[no]);
      if (no == cells.length - 1 && !this.noCssLayout) {
        cells[no].style.borderRightWidth = "0px";
      }
      if (this.columnSortArray[no]) {
        this.__parseHeaderCell(cells[no]);
      } else {
        cells[no].style.cursor = "default";
      }
    }
    if (!this.noCssLayout) {
      var tBody = obj.getElementsByTagName("TBODY")[0];
      if (document.all && navigator.userAgent.indexOf("Opera") < 0) {
        tBody.className = "DHTMLSuite_scrollingContent";
        tBody.style.display = "block";
      } else {
        if (!this.noCssLayout) tBody.className = "DHTMLSuite_scrollingContent";
        tBody.style.height =
          obj.parentNode.clientHeight - tHead.offsetHeight + "px";
        if (navigator.userAgent.indexOf("Opera") >= 0) {
          obj.parentNode.style.overflow = "auto";
        }
      }
    }
    this.__parseDataRows(obj);
    const ind = this.objectIndex;
  },
  __addEndCol: function (obj) {
    const rows = obj.getElementsByTagName("TR");
    for (let no = 0; no < rows.length; no++) {
      const cell = rows[no].insertCell(rows[no].cells.length);
      cell.innerHTML =
        '<img src="' +
        DHTMLSuite.configObj.imagePath +
        'table-widget/transparent.gif" width="10" style="visibility:hidden">';
      cell.style.width = "13px";
      cell.width = "13";
      cell.style.overflow = "hidden";
    }
  },
  __highlightTableHeader: function () {
    this.className = "DHTMLSuite_tableWigdet_headerCellOver";
    if (document.all) {
      const divObj = this.parentNode.parentNode.parentNode.parentNode;
      this.parentNode.style.top = divObj.scrollTop + "px";
    }
  },
  __removeHighlightEffectFromTableHeader: function () {
    this.className = "DHTMLSuite_tableWidget_headerCell";
  },
  __mousedownOnTableHeader: function () {
    this.className = "DHTMLSuite_tableWigdet_headerCellDown";
    if (document.all) {
      const divObj = this.parentNode.parentNode.parentNode.parentNode;
      this.parentNode.style.top = divObj.scrollTop + "px";
    }
  },
  __sortNumeric: function (a, b) {
    a = a.replace(/,/, ".");
    b = b.replace(/,/, ".");
    a = a.replace(/[^\d\.\/]/g, "");
    b = b.replace(/[^\d\.\/]/g, "");
    if (a.indexOf("/") >= 0) a = eval(a);
    if (b.indexOf("/") >= 0) b = eval(b);
    return a / 1 - b / 1;
  },
  __sortString: function (a, b) {
    if (a.toUpperCase() < b.toUpperCase()) return -1;
    if (a.toUpperCase() > b.toUpperCase()) return 1;
    return 0;
  },
  __parseDataContentFromServer: function (ajaxIndex) {
    const content = DHTMLSuite.variableStorage.ajaxObjects[ajaxIndex].response;
    if (content.indexOf("|||") == -1 && content.indexOf("###") == -1) {
      alert("Error in data from server\n" + content);
      return;
    }
    this.__clearDataRows();
    const rows = content.split("|||");
    for (let no = 0; no < rows.length; no++) {
      const items = rows[no].split("###");
      if (items.length > 1) this.__fillDataRow(items);
    }
    this.__parseDataRows(this.tableObj);
  },
  __clearDataRows: function () {
    if (!this.tableObj) this.tableObj = document.getElementById(this.idOfTable);
    while (this.tableObj.rows.length > 1) {
      DHTMLSuite.discardElement(
        this.tableObj.rows[this.tableObj.rows.length - 1]
      );
    }
  },
  __fillDataRow: function (data) {
    if (!this.tableObj) this.tableObj = document.getElementById(this.idOfTable);
    const tbody = this.tableObj.getElementsByTagName("TBODY")[0];
    const row = tbody.insertRow(-1);
    for (let no = 0; no < data.length; no++) {
      const cell = row.insertCell(no);
      cell.innerHTML = data[no];
    }
  },
  updateTableHeader: function (columnIndex, direction) {
    const tableObj = document.getElementById(this.idOfTable);
    const firstRow = tableObj.rows[0];
    const tds = firstRow.cells;
    const tdObj = tds[columnIndex];
    tdObj.setAttribute("direction", direction);
    tdObj.direction = direction;
    let sortBy = tdObj.getAttribute("sortBy");
    if (!sortBy) sortBy = tdObj.sortBy;
    this.tableCurrentlySortedBy = sortBy;
    this.__updateSortArrow(tdObj, direction);
  },
  reloadDataFromServer: function () {
    this.__getItemsFromServer();
    if (this.pageHandler) this.pageHandler.__resetActivePageNumber();
  },
  resetServersideSortCurrentStartIndex: function () {
    this.serversideSortCurrentStartIndex = 0;
  },
  __updateSortArrow: function (obj, direction) {
    var images = obj.getElementsByTagName("IMG");
    if (direction == "descending") {
      images[0].src = images[0].src.replace("arrow_up", "arrow_down");
      images[0].style.visibility = "visible";
    } else {
      images[0].src = images[0].src.replace("arrow_down", "arrow_up");
      images[0].style.visibility = "visible";
    }
    if (this.activeColumn && this.activeColumn != obj) {
      var images = this.activeColumn.getElementsByTagName("IMG");
      images[0].style.visibility = "hidden";
      this.activeColumn.removeAttribute("direction");
    }
    this.activeColumn = obj;
  },
  __getParsedCallbackString: function (functionName) {
    const objIndex = this.objectIndex;
    functionName = !functionName
      ? "true"
      : functionName +
        "(DHTMLSuite.variableStorage.arrayDSObjects[" +
        objIndex +
        "])";
    return functionName;
  },
  __getItemsFromServer: function (callbackFunction) {
    callbackFunction = this.__getParsedCallbackString(callbackFunction);
    const objIndex = this.objectIndex;
    const url =
      this.serversideSortFileName +
      "?sortBy=" +
      this.tableCurrentlySortedBy +
      "&numberOfRows=" +
      this.serversideSortNumberOfRows +
      "&sortAscending=" +
      this.serversideSortAscending +
      "&startIndex=" +
      this.serversideSortCurrentStartIndex +
      this.serversideSortExtraSearchCriterias;
    const index = DHTMLSuite.variableStorage.ajaxObjects.length;
    try {
      DHTMLSuite.variableStorage.ajaxObjects[index] = new sack();
    } catch (e) {
      alert(
        "Unable to create ajax object. Please make sure that the sack js file is included on your page(js/ajax.js)"
      );
      return;
    }
    DHTMLSuite.variableStorage.ajaxObjects[index].requestFile = url;
    DHTMLSuite.variableStorage.ajaxObjects[index].onCompletion = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[
        objIndex
      ].__parseDataContentFromServer(index);
      eval(callbackFunction);
    };
    DHTMLSuite.variableStorage.ajaxObjects[index].runAJAX();
  },
  __sortTable: function (obj, howToSort) {
    if (this.serversideSort) {
      if (!this.serversideSortFileName) {
        alert(
          "No server side file defined. Use the setServersideSortFileName to specify where to send the ajax request"
        );
        return;
      }
      let sortBy = obj.getAttribute("sortBy");
      if (!sortBy) sortBy = obj.sortBy;
      if (!sortBy) {
        alert(
          "Sort is not defined. Remember to set a sortBy attribute on the header <td> tags"
        );
        return;
      }
      if (sortBy == this.tableCurrentlySortedBy) {
        this.serversideSortAscending = !this.serversideSortAscending;
      } else this.serversideSortAscending = true;
      if (howToSort) {
        this.serversideSortAscending = howToSort == "ascending";
      }
      this.tableCurrentlySortedBy = sortBy;
      this.serversideSortCurrentStartIndex = 0;
      this.__getItemsFromServer();
      if (this.pageHandler) this.pageHandler.__resetActivePageNumber();
      this.__updateSortArrow(
        obj,
        this.serversideSortAscending ? "ascending" : "descending"
      );
      return;
    }
    if (!this.tableWidget_okToSort) return;
    this.tableWidget_okToSort = false;
    let indexThis = 0;
    let tmpObj = obj;
    while (tmpObj.previousSibling) {
      tmpObj = tmpObj.previousSibling;
      if (tmpObj.tagName == "TD") indexThis++;
    }
    if (obj.getAttribute("direction") || obj.direction) {
      direction = obj.getAttribute("direction");
      if (navigator.userAgent.indexOf("Opera") >= 0) direction = obj.direction;
      if (direction == "ascending" || howToSort == "descending") {
        direction = "descending";
        obj.setAttribute("direction", "descending");
        obj.direction = "descending";
      } else {
        direction = "ascending";
        obj.setAttribute("direction", "ascending");
        obj.direction = "ascending";
      }
    } else {
      let curDir = "ascending";
      if (howToSort) curDir = howToSort;
      direction = curDir;
      obj.setAttribute("direction", curDir);
      obj.direction = curDir;
    }
    this.__updateSortArrow(obj, direction);
    const tableObj = obj.parentNode.parentNode.parentNode;
    const tBody = tableObj.getElementsByTagName("TBODY")[0];
    const widgetIndex = tableObj.id.replace(/[^\d]/g, "");
    const sortMethod = this.columnSortArray[indexThis];
    let cellArray = new Array();
    const cellObjArray = new Array();
    for (var no = 1; no < tableObj.rows.length; no++) {
      const content = String(tableObj.rows[no].cells[indexThis].innerHTML);
      cellArray.push(content);
      cellObjArray.push(tableObj.rows[no].cells[indexThis]);
    }
    cellArray =
      sortMethod == "N"
        ? cellArray.sort(this.__sortNumeric)
        : cellArray.sort(this.__sortString);
    if (direction == "descending") {
      for (var no = cellArray.length; no >= 0; no--) {
        for (var no2 = 0; no2 < cellObjArray.length; no2++) {
          if (
            cellObjArray[no2].innerHTML == cellArray[no] &&
            !cellObjArray[no2].getAttribute("allreadySorted")
          ) {
            cellObjArray[no2].setAttribute("allreadySorted", "1");
            tBody.appendChild(cellObjArray[no2].parentNode);
          }
        }
      }
    } else {
      for (var no = 0; no < cellArray.length; no++) {
        for (var no2 = 0; no2 < cellObjArray.length; no2++) {
          if (
            cellObjArray[no2].innerHTML == cellArray[no] &&
            !cellObjArray[no2].getAttribute("allreadySorted")
          ) {
            cellObjArray[no2].setAttribute("allreadySorted", "1");
            tBody.appendChild(cellObjArray[no2].parentNode);
          }
        }
      }
    }
    for (var no2 = 0; no2 < cellObjArray.length; no2++) {
      cellObjArray[no2].removeAttribute("allreadySorted");
    }
    this.tableWidget_okToSort = true;
  },
  __highlightTableRow: function () {
    if (DHTMLSuite.clientInfoObj.isOpera) return;
    this.className = "DHTMLSuite_tableWidget_dataRollOver";
    if (document.all) {
      const divObj = this.parentNode.parentNode.parentNode;
      const tHead = divObj.getElementsByTagName("TR")[0];
      tHead.style.top = divObj.scrollTop + "px";
    }
  },
  __removeHighlightEffectFromTableRow: function () {
    if (DHTMLSuite.clientInfoObj.isOpera) return;
    this.className = null;
    if (document.all) {
      const divObj = this.parentNode.parentNode.parentNode;
      const tHead = divObj.getElementsByTagName("TR")[0];
      tHead.style.top = divObj.scrollTop + "px";
    }
  },
};
let DHTMLSuite_dragDropSimple_curZIndex = 100000;
let DHTMLSuite_dragDropSimple_curObjIndex = false;
DHTMLSuite.dragDropSimple = function (propertyArray) {
  let divElement;
  let dragTimer;
  let cloneNode;
  this.cloneNode = true;
  let callbackOnAfterDrag;
  let callbackOnBeforeDrag;
  let callbackOnDuringDrag;
  let mouse_x;
  let mouse_y;
  let positionSet;
  let dragHandle;
  let allowMoveX;
  let allowMoveY;
  let maxY;
  let minY;
  let minX;
  let maxX;
  let initialXPos;
  let initialYPos;
  this.positionSet = false;
  this.dragHandle = new Array();
  let initOffsetX;
  let initOffsetY;
  this.allowMoveX = true;
  this.allowMoveY = true;
  this.maxY = false;
  this.maxX = false;
  this.minX = false;
  this.minY = false;
  this.callbackOnAfterDrag = false;
  this.callbackOnBeforeDrag = false;
  this.dragStatus = -1;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  let objectIndex;
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
  this.__setInitProps(propertyArray);
  this.__init();
};
DHTMLSuite.dragDropSimple.prototype = {
  __setInitProps: function (props) {
    if (props.cloneNode === false || props.cloneNode) {
      this.cloneNode = props.cloneNode;
    }
    if (props.allowMoveX === false || props.allowMoveX) {
      this.allowMoveX = props.allowMoveX;
    }
    if (props.allowMoveY === false || props.allowMoveY) {
      this.allowMoveY = props.allowMoveY;
    }
    if (props.minY || props.minY === 0) this.minY = props.minY;
    if (props.maxY || props.maxY === 0) this.maxY = props.maxY;
    if (props.minX || props.minX === 0) this.minX = props.minX;
    if (props.maxX || props.maxX === 0) this.maxX = props.maxX;
    if (!props.initOffsetX) props.initOffsetX = 0;
    if (!props.initOffsetY) props.initOffsetY = 0;
    this.initOffsetX = props.initOffsetX;
    this.initOffsetY = props.initOffsetY;
    if (props.callbackOnBeforeDrag) {
      this.callbackOnBeforeDrag = props.callbackOnBeforeDrag;
    }
    if (props.callbackOnAfterDrag) {
      this.callbackOnAfterDrag = props.callbackOnAfterDrag;
    }
    if (props.callbackOnDuringDrag) {
      this.callbackOnDuringDrag = props.callbackOnDuringDrag;
    }
    props.elementReference = DHTMLSuite.commonObj.getEl(props.elementReference);
    this.divElement = props.elementReference;
    this.initialXPos = DHTMLSuite.commonObj.getLeftPos(this.divElement);
    this.initialYPos = DHTMLSuite.commonObj.getTopPos(this.divElement);
    if (props.dragHandle) {
      this.dragHandle[this.dragHandle.length] = DHTMLSuite.commonObj.getEl(
        props.dragHandle
      );
    }
  },
  __init: function () {
    const ind = this.objectIndex;
    this.divElement.objectIndex = ind;
    this.divElement.setAttribute("objectIndex", ind);
    this.divElement.style.padding = "0px";
    if (this.allowMoveX) {
      this.divElement.style.left =
        DHTMLSuite.commonObj.getLeftPos(this.divElement) +
        this.initOffsetX +
        "px";
    }
    if (this.allowMoveY) {
      this.divElement.style.top =
        DHTMLSuite.commonObj.getTopPos(this.divElement) +
        this.initOffsetY +
        "px";
    }
    this.divElement.style.position = "absolute";
    this.divElement.style.margin = "0px";
    if (
      this.divElement.style.zIndex &&
      this.divElement.style.zIndex / 1 > DHTMLSuite_dragDropSimple_curZIndex
    ) {
      DHTMLSuite_dragDropSimple_curZIndex = this.divElement.style.zIndex / 1;
    }
    DHTMLSuite_dragDropSimple_curZIndex =
      DHTMLSuite_dragDropSimple_curZIndex / 1 + 1;
    this.divElement.style.zIndex = DHTMLSuite_dragDropSimple_curZIndex;
    if (this.cloneNode) {
      const copy = this.divElement.cloneNode(true);
      this.divElement.parentNode.insertBefore(copy, this.divElement);
      copy.style.visibility = "hidden";
      document.body.appendChild(this.divElement);
    }
    DHTMLSuite.commonObj.addEvent(
      this.divElement,
      "mousedown",
      function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__initDragProcess(e);
      },
      ind
    );
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mousemove",
      function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveDragableElement(e);
      },
      ind
    );
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mouseup",
      function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__stopDragProcess(e);
      },
      ind
    );
    if (!document.documentElement.onselectstart) {
      document.documentElement.onselectstart = function () {
        return DHTMLSuite.commonObj.__isTextSelOk();
      };
    }
  },
  setCallbackOnAfterDrag: function (functionName) {
    this.callbackOnAfterDrag = functionName;
  },
  setCallbackOnBeforeDrag: function (functionName) {
    this.callbackOnBeforeDrag = functionName;
  },
  addDragHandle: function (dragHandle) {
    this.dragHandle[this.dragHandle.length] = dragHandle;
  },
  __initDragProcess: function (e) {
    if (document.all) e = event;
    const ind = this.objectIndex;
    DHTMLSuite_dragDropSimple_curObjIndex = ind;
    const thisObject = DHTMLSuite.variableStorage.arrayDSObjects[ind];
    if (!DHTMLSuite.commonObj.isObjectClicked(thisObject.divElement, e)) return;
    if (
      thisObject.divElement.style.zIndex &&
      thisObject.divElement.style.zIndex / 1 >
        DHTMLSuite_dragDropSimple_curZIndex
    ) {
      DHTMLSuite_dragDropSimple_curZIndex =
        thisObject.divElement.style.zIndex / 1;
    }
    DHTMLSuite_dragDropSimple_curZIndex =
      DHTMLSuite_dragDropSimple_curZIndex / 1 + 1;
    thisObject.divElement.style.zIndex = DHTMLSuite_dragDropSimple_curZIndex;
    if (thisObject.callbackOnBeforeDrag) {
      thisObject.__handleCallback("beforeDrag", e);
    }
    if (thisObject.dragHandle.length > 0) {
      let objectFound;
      for (let no = 0; no < thisObject.dragHandle.length; no++) {
        if (!objectFound) {
          objectFound = DHTMLSuite.commonObj.isObjectClicked(
            thisObject.dragHandle[no],
            e
          );
        }
      }
      if (!objectFound) return;
    }
    DHTMLSuite.commonObj.__setTextSelOk(false);
    thisObject.mouse_x = e.clientX;
    thisObject.mouse_y = e.clientY;
    thisObject.el_x = thisObject.divElement.style.left.replace("px", "") / 1;
    thisObject.el_y = thisObject.divElement.style.top.replace("px", "") / 1;
    thisObject.dragTimer = 0;
    thisObject.__waitBeforeDragProcessStarts();
    return false;
  },
  __waitBeforeDragProcessStarts: function () {
    const ind = this.objectIndex;
    if (this.dragTimer >= 0 && this.dragTimer < 5) {
      this.dragTimer++;
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__waitBeforeDragProcessStarts()",
        5
      );
    }
  },
  __moveDragableElement: function (e) {
    if (document.all) e = event;
    const ind = this.objectIndex;
    const thisObj = DHTMLSuite.variableStorage.arrayDSObjects[ind];
    if (DHTMLSuite.clientInfoObj.isMSIE && e.button != 1) {
      return thisObj.__stopDragProcess();
    }
    if (thisObj.dragTimer == 5) {
      if (thisObj.allowMoveX) {
        let leftPos = e.clientX - this.mouse_x + this.el_x;
        if (this.maxX !== false) {
          if (
            leftPos + document.documentElement.scrollLeft >
            this.initialXPos + this.maxX
          ) {
            leftPos = this.initialXPos + this.maxX;
          }
        }
        if (this.minX !== false) {
          if (
            leftPos + document.documentElement.scrollLeft <
            this.initialXPos + this.minX
          ) {
            leftPos = this.initialXPos + this.minX;
          }
        }
        thisObj.divElement.style.left = leftPos + "px";
      }
      if (thisObj.allowMoveY) {
        let topPos = e.clientY - thisObj.mouse_y + thisObj.el_y;
        if (this.maxY !== false) {
          if (topPos > this.initialYPos + this.maxY) {
            topPos = this.initialYPos + this.maxY;
          }
        }
        if (this.minY !== false) {
          if (topPos < this.initialYPos + this.minY) {
            topPos = this.initialYPos + this.minY;
          }
        }
        thisObj.divElement.style.top = topPos + "px";
      }
      if (this.callbackOnDuringDrag) this.__handleCallback("duringDrag", e);
    }
    return false;
  },
  __stopDragProcess: function (e) {
    const ind = this.objectIndex;
    DHTMLSuite.commonObj.__setTextSelOk(true);
    const thisObj = DHTMLSuite.variableStorage.arrayDSObjects[ind];
    if (thisObj.dragTimer == 5) {
      thisObj.__handleCallback("afterDrag", e);
    }
    thisObj.dragTimer = -1;
  },
  __handleCallback: function (action, e) {
    let callbackString = "";
    switch (action) {
      case "afterDrag":
        callbackString = this.callbackOnAfterDrag;
        break;
      case "beforeDrag":
        callbackString = this.callbackOnBeforeDrag;
        break;
      case "duringDrag":
        callbackString = this.callbackOnDuringDrag;
        break;
    }
    if (callbackString) {
      callbackString = callbackString + "(e)";
      try {
        eval(callbackString);
      } catch (e) {
        alert(
          "Could not execute callback function(" +
            callbackString +
            ")after drag"
        );
      }
    }
  },
  __setNewCurrentZIndex: function (zIndex) {
    if (zIndex > DHTMLSuite_dragDropSimple_curZIndex) {
      DHTMLSuite_dragDropSimple_curZIndex = zIndex / 1 + 1;
    }
  },
};
DHTMLSuite.dragDrop = function () {
  let mouse_x;
  let mouse_y;
  let el_x;
  let el_y;
  let dragDropTimer;
  let numericIdToBeDragged;
  let dragObjCloneArray;
  let dragDropSourcesArray;
  let dragDropTargetArray;
  let currentZIndex;
  let okToStartDrag;
  let moveBackBySliding;
  let dragX_allowed;
  let dragY_allowed;
  let currentEl_allowX;
  let currentEl_allowY;
  let drag_minX;
  let drag_maxX;
  let drag_minY;
  let drag_maxY;
  let dragInProgress;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.dragX_allowed = true;
  this.dragY_allowed = true;
  this.currentZIndex = 21000;
  this.dragDropTimer = -1;
  this.dragObjCloneArray = new Array();
  this.numericIdToBeDragged = false;
  this.okToStartDrag = true;
  this.moveBackBySliding = true;
  this.dragInProgress = false;
  let objectIndex;
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.dragDrop.prototype = {
  init: function () {
    this.__initDragDropScript();
  },
  addSource: function (
    sourceId,
    slideBackAfterDrop,
    xAxis,
    yAxis,
    dragOnlyWithinElId
  ) {
    if (!this.dragDropSourcesArray) this.dragDropSourcesArray = new Array();
    if (!document.getElementById(sourceId)) {
      alert(
        "The source element with id " +
          sourceId +
          " does not exists. Check your HTML code"
      );
      return;
    }
    if (xAxis !== false) xAxis = true;
    if (yAxis !== false) yAxis = true;
    const obj = document.getElementById(sourceId);
    this.dragDropSourcesArray[this.dragDropSourcesArray.length] = [
      obj,
      slideBackAfterDrop,
      xAxis,
      yAxis,
      dragOnlyWithinElId,
    ];
    obj.setAttribute("dragableElement", this.dragDropSourcesArray.length - 1);
    obj.dragableElement = this.dragDropSourcesArray.length - 1;
  },
  addTarget: function (targetId, functionToCallOnDrop) {
    if (!this.dragDropTargetArray) this.dragDropTargetArray = new Array();
    if (!document.getElementById(targetId)) {
      alert(
        "The target element with id " +
          targetId +
          " does not exists.  Check your HTML code"
      );
    }
    const obj = document.getElementById(targetId);
    this.dragDropTargetArray[this.dragDropTargetArray.length] = [
      obj,
      functionToCallOnDrop,
    ];
  },
  setSlide: function (isSlidingAnimationEnabled) {
    this.moveBackBySliding = isSlidingAnimationEnabled;
  },
  __initDragDropScript: function () {
    const ind = this.objectIndex;
    const refToThis = this;
    let startIndex = String(Math.random());
    startIndex = startIndex.replace(".", "") / 1;
    for (let no = 0; no < this.dragDropSourcesArray.length; no++) {
      const el = this.dragDropSourcesArray[no][0].cloneNode(true);
      const el2 = this.dragDropSourcesArray[no][0];
      eval(
        "el.onmousedown =function(e,index){DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__initializeDragProcess(e," +
          no +
          ")}"
      );
      DHTMLSuite.commonObj.__addEventEl(el);
      const tmpIndex = startIndex + no;
      el.id = el2.id;
      el.style.position = "absolute";
      el.style.visibility = "hidden";
      el.style.display = "none";
      document.body.appendChild(el);
      el.style.top =
        DHTMLSuite.commonObj.getTopPos(this.dragDropSourcesArray[no][0]) + "px";
      el.style.left =
        DHTMLSuite.commonObj.getLeftPos(this.dragDropSourcesArray[no][0]) +
        "px";
      eval(
        "el2.onmousedown =function(e,index){return DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__initializeDragProcess(e," +
          no +
          ")}"
      );
      DHTMLSuite.commonObj.__addEventEl(this.dragDropSourcesArray[no][0]);
      this.dragObjCloneArray[no] = el;
    }
    eval(
      'DHTMLSuite.commonObj.addEvent(document.documentElement,"mousemove",function(e){DHTMLSuite.variableStorage.arrayDSObjects[' +
        ind +
        "].__moveDragableElement(e)})"
    );
    eval(
      'DHTMLSuite.commonObj.addEvent(document.documentElement,"mouseup",function(e){DHTMLSuite.variableStorage.arrayDSObjects[' +
        ind +
        "].__stopDragProcess(e)});"
    );
    if (!document.documentElement.onselectstart) {
      document.documentElement.onselectstart = function () {
        return DHTMLSuite.commonObj.__isTextSelOk();
      };
    }
    document.documentElement.ondragstart = function () {
      return false;
    };
    DHTMLSuite.commonObj.__addEventEl(document.documentElement);
  },
  __initializeDragProcess: function (e, index) {
    const ind = this.objectIndex;
    if (!this.okToStartDrag) return false;
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].okToStartDrag=true;",
      100
    );
    if (document.all) e = event;
    this.numericIdToBeDragged = index;
    this.numericIdToBeDragged = String(this.numericIdToBeDragged);
    this.dragDropTimer = 0;
    DHTMLSuite.commonObj.__setTextSelOk(false);
    this.mouse_x = e.clientX;
    this.mouse_y = e.clientY;
    this.currentZIndex = this.currentZIndex + 1;
    this.dragObjCloneArray[this.numericIdToBeDragged].style.zIndex =
      this.currentZIndex;
    this.currentEl_allowX =
      this.dragDropSourcesArray[this.numericIdToBeDragged][2];
    this.currentEl_allowY =
      this.dragDropSourcesArray[this.numericIdToBeDragged][3];
    const parentEl = this.dragDropSourcesArray[this.numericIdToBeDragged][4];
    this.drag_minX = false;
    this.drag_minY = false;
    this.drag_maxX = false;
    this.drag_maxY = false;
    if (parentEl) {
      const obj = document.getElementById(parentEl);
      if (obj) {
        this.drag_minX = DHTMLSuite.commonObj.getLeftPos(obj);
        this.drag_minY = DHTMLSuite.commonObj.getTopPos(obj);
        this.drag_maxX = this.drag_minX + obj.clientWidth;
        this.drag_maxY = this.drag_minY + obj.clientHeight;
      }
    }
    if (this.dragDropSourcesArray[this.numericIdToBeDragged][1]) {
      this.dragObjCloneArray[this.numericIdToBeDragged].style.top =
        DHTMLSuite.commonObj.getTopPos(
          this.dragDropSourcesArray[this.numericIdToBeDragged][0]
        ) + "px";
      this.dragObjCloneArray[this.numericIdToBeDragged].style.left =
        DHTMLSuite.commonObj.getLeftPos(
          this.dragDropSourcesArray[this.numericIdToBeDragged][0]
        ) + "px";
    }
    this.el_x =
      this.dragObjCloneArray[this.numericIdToBeDragged].style.left.replace(
        "px",
        ""
      ) / 1;
    this.el_y =
      this.dragObjCloneArray[this.numericIdToBeDragged].style.top.replace(
        "px",
        ""
      ) / 1;
    this.__waitBeforeDragProcessStarts();
    return false;
  },
  __waitBeforeDragProcessStarts: function () {
    const ind = this.objectIndex;
    if (this.dragDropTimer >= 0 && this.dragDropTimer < 5) {
      this.dragDropTimer = this.dragDropTimer + 1;
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__waitBeforeDragProcessStarts()",
        2
      );
      return;
    }
    if (this.dragDropTimer >= 5) {
      if (
        this.dragObjCloneArray[this.numericIdToBeDragged].style.display ==
        "none"
      ) {
        this.dragDropSourcesArray[
          this.numericIdToBeDragged
        ][0].style.visibility = "hidden";
        const ref = this.dragObjCloneArray[this.numericIdToBeDragged];
        ref.style.display = "block";
        ref.style.visibility = "visible";
        ref.style.top =
          DHTMLSuite.commonObj.getTopPos(
            this.dragDropSourcesArray[this.numericIdToBeDragged][0]
          ) + "px";
        ref.style.left =
          DHTMLSuite.commonObj.getLeftPos(
            this.dragDropSourcesArray[this.numericIdToBeDragged][0]
          ) + "px";
      }
    }
  },
  __moveDragableElement: function (e) {
    const ind = this.objectIndex;
    if (document.all) e = event;
    if (this.dragDropTimer < 5) return false;
    if (this.dragInProgress) return false;
    this.dragInProgress = true;
    const dragObj = this.dragObjCloneArray[this.numericIdToBeDragged];
    if (this.currentEl_allowX) {
      let leftPos = e.clientX - this.mouse_x + this.el_x;
      if (this.drag_maxX) {
        const tmpMaxX = this.drag_maxX - dragObj.offsetWidth;
        if (leftPos > tmpMaxX) leftPos = tmpMaxX;
        if (leftPos < this.drag_minX) leftPos = this.drag_minX;
      }
      dragObj.style.left = leftPos + "px";
    }
    if (this.currentEl_allowY) {
      let topPos = e.clientY - this.mouse_y + this.el_y;
      if (this.drag_maxY) {
        const tmpMaxY = this.drag_maxY - dragObj.offsetHeight;
        if (topPos > tmpMaxY) topPos = tmpMaxY;
        if (topPos < this.drag_minY) topPos = this.drag_minY;
      }
      dragObj.style.top = topPos + "px";
    }
    this.dragInProgress = false;
    return false;
  },
  __stopDragProcess: function (e) {
    if (this.dragDropTimer < 5) return false;
    if (document.all) e = event;
    const dropDestination = DHTMLSuite.commonObj.getSrcElement(e);
    const leftPosMouse =
      e.clientX +
      Math.max(document.body.scrollLeft, document.documentElement.scrollLeft);
    const topPosMouse =
      e.clientY +
      Math.max(document.body.scrollTop, document.documentElement.scrollTop);
    if (!this.dragDropTargetArray) this.dragDropTargetArray = new Array();
    for (let no = 0; no < this.dragDropTargetArray.length; no++) {
      const leftPosEl = DHTMLSuite.commonObj.getLeftPos(
        this.dragDropTargetArray[no][0]
      );
      const topPosEl = DHTMLSuite.commonObj.getTopPos(
        this.dragDropTargetArray[no][0]
      );
      const widthEl = this.dragDropTargetArray[no][0].offsetWidth;
      const heightEl = this.dragDropTargetArray[no][0].offsetHeight;
      if (
        leftPosMouse > leftPosEl &&
        leftPosMouse < leftPosEl + widthEl &&
        topPosMouse > topPosEl &&
        topPosMouse < topPosEl + heightEl
      ) {
        if (this.dragDropTargetArray[no][1]) {
          try {
            eval(
              this.dragDropTargetArray[no][1] +
                '("' +
                this.dragDropSourcesArray[this.numericIdToBeDragged][0].id +
                '","' +
                this.dragDropTargetArray[no][0].id +
                '",' +
                e.clientX +
                "," +
                e.clientY +
                ")"
            );
          } catch (e) {
            alert(
              "Unable to execute \n" +
                this.dragDropTargetArray[no][1] +
                '("' +
                this.dragDropSourcesArray[this.numericIdToBeDragged][0].id +
                '","' +
                this.dragDropTargetArray[no][0].id +
                '",' +
                e.clientX +
                "," +
                e.clientY +
                ")"
            );
          }
        }
        break;
      }
    }
    if (this.dragDropSourcesArray[this.numericIdToBeDragged][1]) {
      this.__slideElementBackIntoItsOriginalPosition(this.numericIdToBeDragged);
    }
    this.dragDropTimer = -1;
    DHTMLSuite.commonObj.__setTextSelOk(true);
    this.numericIdToBeDragged = false;
  },
  __slideElementBackIntoItsOriginalPosition: function (numId) {
    const currentX =
      this.dragObjCloneArray[numId].style.left.replace("px", "") / 1;
    const currentY =
      this.dragObjCloneArray[numId].style.top.replace("px", "") / 1;
    const ref = this.dragDropSourcesArray[numId][0];
    const targetX = DHTMLSuite.commonObj.getLeftPos(ref);
    const targetY = DHTMLSuite.commonObj.getTopPos(ref);
    if (this.moveBackBySliding) {
      this.__processSlideByPixels(numId, currentX, currentY, targetX, targetY);
    } else {
      this.dragObjCloneArray[numId].style.display = "none";
      ref.style.visibility = "visible";
    }
  },
  __processSlideByPixels: function (
    numId,
    currentX,
    currentY,
    targetX,
    targetY
  ) {
    let slideX = Math.round(
      Math.abs(Math.max(currentX, targetX) - Math.min(currentX, targetX)) / 10
    );
    let slideY = Math.round(
      Math.abs(Math.max(currentY, targetY) - Math.min(currentY, targetY)) / 10
    );
    if (slideY < 3 && Math.abs(slideX) < 10) slideY = 3;
    if (slideX < 3 && Math.abs(slideY) < 10) slideX = 3;
    if (currentX > targetX) slideX *= -1;
    if (currentY > targetY) slideY *= -1;
    currentX = currentX + slideX;
    currentY = currentY + slideY;
    if (Math.max(currentX, targetX) - Math.min(currentX, targetX) < 4) {
      currentX = targetX;
    }
    if (Math.max(currentY, targetY) - Math.min(currentY, targetY) < 4) {
      currentY = targetY;
    }
    this.dragObjCloneArray[numId].style.left = currentX + "px";
    this.dragObjCloneArray[numId].style.top = currentY + "px";
    if (currentX != targetX || currentY != targetY) {
      window.thisRef = this;
      setTimeout(
        'window.thisRef.__processSlideByPixels("' +
          numId +
          '",' +
          currentX +
          "," +
          currentY +
          "," +
          targetX +
          "," +
          targetY +
          ")",
        5
      );
    } else {
      this.dragObjCloneArray[numId].style.display = "none";
      this.dragDropSourcesArray[numId][0].style.visibility = "visible";
    }
  },
};
const refToTabViewObjects = new Array();
DHTMLSuite.tabView = function () {
  let textPadding;
  let strictDocType;
  let DHTMLSuite_tabObj;
  let activeTabIndex;
  let initActiveTabIndex;
  let ajaxObjects;
  let tabView_countTabs;
  let tabViewHeight;
  let tabSetParentId;
  let tabTitles;
  let width;
  let height;
  let layoutCSS;
  let outsideObjectRefIndex;
  let maxNumberOfTabs;
  let dynamicContentObj;
  let closeButtons;
  let refActiveTabContent;
  let callbackOnTabSwitch;
  this.initActiveTabIndex = 0;
  this.callbackOnTabSwitch = "";
  this.refActiveTabContent = "";
  this.textPadding = 3;
  this.strictDocType = true;
  this.ajaxObjects = new Array();
  this.tabTitles = new Array();
  this.layoutCSS = "tab-view.css";
  this.maxNumberOfTabs = 6;
  this.dynamicContentObj = false;
  this.closeButtons = new Array();
  this.width = "100%";
  this.height = "500";
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
};
DHTMLSuite.tabView.prototype = {
  init: function () {
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    this.outsideObjectRefIndex = refToTabViewObjects.length;
    refToTabViewObjects[this.outsideObjectRefIndex] = this;
    try {
      this.dynamicContentObj = new DHTMLSuite.dynamicContent();
    } catch (e) {
      alert("Include DHTMLSuite-dynamicContent.js");
    }
    this.__initializeAndParseTabs(false, false);
  },
  setCallbackOnTabSwitch: function (callbackOnTabSwitch) {
    this.callbackOnTabSwitch = callbackOnTabSwitch;
  },
  getMaximumNumberOfTabs: function () {
    return this.maxNumberOfTabs;
  },
  setMaximumTabs: function (maximumNumberOfTabs) {
    this.maxNumberOfTabs = maximumNumberOfTabs;
  },
  setParentId: function (idOfParentHTMLElement) {
    this.tabSetParentId = idOfParentHTMLElement;
    this.DHTMLSuite_tabObj = document.getElementById(idOfParentHTMLElement);
  },
  setWidth: function (newWidth) {
    this.width = newWidth;
  },
  setHeight: function (newHeight) {
    this.height = newHeight;
  },
  setIndexActiveTab: function (indexOfNewActiveTab) {
    this.initActiveTabIndex = indexOfNewActiveTab;
  },
  setTabTitles: function (titleOfTabs) {
    this.tabTitles = titleOfTabs;
  },
  setCloseButtons: function (closeButtons) {
    this.closeButtons = closeButtons;
  },
  getReferenceToDivElementByTitle: function (tabTitle) {
    const index = this.getTabIndexByTitle(tabLabel);
    if (index != -1) {
      const obj = document.getElementById(
        "tabView" + this.tabSetParentId + "_" + index
      );
      return obj;
    }
    return false;
  },
  getReferenceToDivElementById: function (idOfTab) {
    const divs = this.DHTMLSuite_tabObj.getElementsByTagName("DIV");
    for (let no = 0; no < divs.length; no++) {
      let attr = divs[no].getAttribute("originalId");
      if (!attr) attr = divs[no].originalid;
      if (attr == idOfTab) return divs[no];
    }
    return false;
  },
  createNewTab: function (
    parentId,
    tabTitle,
    tabContent,
    tabContentUrl,
    closeButton
  ) {
    const index = this.getTabIndexByTitle(tabTitle);
    if (index != -1) {
      this.displayATab(tabTitle, index);
      return false;
    }
    if (this.tabView_countTabs >= this.maxNumberOfTabs) return;
    const div = document.createElement("DIV");
    div.className = "DHTMLSuite_aTab";
    this.DHTMLSuite_tabObj.appendChild(div);
    const tabId = this.__initializeAndParseTabs(true, tabTitle, closeButton);
    if (tabContent) div.innerHTML = tabContent;
    if (tabContentUrl) {
      this.dynamicContentObj.loadContent(
        "tabView" + parentId + "_" + tabId,
        tabContentUrl
      );
    }
    return true;
  },
  deleteTab: function (tabLabel, tabIndex) {
    if (tabLabel) {
      const index = this.getTabIndexByTitle(tabLabel);
      if (index != -1) {
        this.deleteTab(false, index);
      }
    } else if (tabIndex >= 0) {
      if (
        document.getElementById("tabTab" + this.tabSetParentId + "_" + tabIndex)
      ) {
        const obj = document.getElementById(
          "tabTab" + this.tabSetParentId + "_" + tabIndex
        );
        const id = obj.parentNode.parentNode.id;
        DHTMLSuite.discardElement(obj);
        const obj2 = document.getElementById(
          "tabView" + this.tabSetParentId + "_" + tabIndex
        );
        DHTMLSuite.discardElement(obj2);
        this.__resetTabIds(this.tabSetParentId);
        this.initActiveTabIndex = -1;
        const newIndex = 0;
        if (
          refToTabViewObjects[this.outsideObjectRefIndex].activeTabIndex ==
          tabIndex
        ) {
          refToTabViewObjects[this.outsideObjectRefIndex].activeTabIndex = -1;
        }
        this.__showTab(
          this.tabSetParentId,
          newIndex,
          this.outsideObjectRefIndex
        );
      }
    }
  },
  addContentToTab: function (tabLabel, filePath) {
    const index = this.getTabIndexByTitle(tabLabel);
    if (index != -1) {
      this.dynamicContentObj.loadContent(
        "tabView" + this.tabSetParentId + "_" + index,
        filePath
      );
    }
  },
  displayATab: function (tabLabel, tabIndex) {
    if (tabLabel) {
      const index = this.getTabIndexByTitle(tabLabel);
      if (index != -1) {
        this.initActiveTabIndex = index;
      } else return false;
    } else {
      this.initActiveTabIndex = tabIndex;
    }
    this.__showTab(
      this.tabSetParentId,
      this.initActiveTabIndex,
      this.outsideObjectRefIndex
    );
  },
  getTabIndex: function () {
    const divs = this.DHTMLSuite_tabObj.getElementsByTagName("DIV");
    let tabIndex = 0;
    for (let no = 0; no < divs.length; no++) {
      if (divs[no].id.indexOf("tabTab") >= 0) {
        if (divs[no].className != "tabInactive") return tabIndex;
        tabIndex++;
      }
    }
    return tabIndex;
  },
  __setPadding: function (obj, padding) {
    const span = obj.getElementsByTagName("SPAN")[0];
    span.style.paddingLeft = padding + "px";
    span.style.paddingRight = padding + "px";
  },
  __showTab: function (parentId, tabIndex, objectIndex) {
    const parentId_div = parentId + "_";
    if (!document.getElementById("tabView" + parentId_div + tabIndex)) {
      return;
    }
    if (refToTabViewObjects[objectIndex].activeTabIndex >= 0) {
      if (refToTabViewObjects[objectIndex].activeTabIndex == tabIndex) {
        return;
      }
      var obj = document.getElementById(
        "tabTab" +
          parentId_div +
          refToTabViewObjects[objectIndex].activeTabIndex
      );
      if (!obj) {
        refToTabViewObjects[objectIndex].activeTabIndex = 0;
        var obj = document.getElementById(
          "tabTab" +
            parentId_div +
            refToTabViewObjects[objectIndex].activeTabIndex
        );
      }
      obj.className = "tabInactive";
      obj.style.backgroundImage =
        "url('" +
        DHTMLSuite.configObj.imagePath +
        "tab-view/tab_left_inactive.gif" +
        "')";
      var imgs = obj.getElementsByTagName("IMG");
      var img = imgs[imgs.length - 1];
      img.src =
        DHTMLSuite.configObj.imagePath + "tab-view/tab_right_inactive.gif";
      document.getElementById(
        "tabView" +
          parentId_div +
          refToTabViewObjects[objectIndex].activeTabIndex
      ).style.display = "none";
    }
    const thisObj = document.getElementById("tabTab" + parentId_div + tabIndex);
    thisObj.className = "tabActive";
    thisObj.style.backgroundImage =
      "url('" +
      DHTMLSuite.configObj.imagePath +
      "tab-view/tab_left_active.gif" +
      "')";
    var imgs = thisObj.getElementsByTagName("IMG");
    var img = imgs[imgs.length - 1];
    img.src = DHTMLSuite.configObj.imagePath + "tab-view/tab_right_active.gif";
    document.getElementById("tabView" + parentId_div + tabIndex).style.display =
      "block";
    this.refActiveTabContent = document.getElementById(
      "tabView" + parentId_div + tabIndex
    );
    refToTabViewObjects[objectIndex].activeTabIndex = tabIndex;
    refToTabViewObjects[objectIndex].__handleCallback("tabSwitch");
    const parentObj = thisObj.parentNode;
    let aTab = parentObj.getElementsByTagName("DIV")[0];
    countObjects = 0;
    let startPos = 2;
    let previousObjectActive = false;
    while (aTab) {
      if (aTab.tagName == "DIV") {
        if (previousObjectActive) {
          previousObjectActive = false;
          startPos -= 2;
        }
        if (aTab == thisObj) {
          startPos -= 2;
          previousObjectActive = true;
          refToTabViewObjects[objectIndex].__setPadding(
            aTab,
            refToTabViewObjects[objectIndex].textPadding + 1
          );
        } else {
          refToTabViewObjects[objectIndex].__setPadding(
            aTab,
            refToTabViewObjects[objectIndex].textPadding
          );
        }
        aTab.style.left = startPos + "px";
        countObjects++;
        startPos += 2;
      }
      aTab = aTab.nextSibling;
    }
  },
  __handleCallback: function (action) {
    let callbackString = "";
    switch (action) {
      case "tabSwitch":
        callbackString = this.callbackOnTabSwitch;
        break;
    }
    if (callbackString) {
      callbackString = callbackString + "(this.refActiveTabContent)";
      eval(callbackString);
    }
  },
  __tabClick: function (inputObj, index) {
    const idArray = inputObj.id.split("_");
    let parentId = inputObj.getAttribute("parentRefId");
    if (!parentId) parentId = inputObj.parentRefId;
    this.__showTab(
      parentId,
      idArray[idArray.length - 1].replace(/[^0-9]/gi, ""),
      index
    );
  },
  __rolloverTab: function () {
    if (this.className.indexOf("tabInactive") >= 0) {
      this.className = "inactiveTabOver";
      this.style.backgroundImage =
        "url('" +
        DHTMLSuite.configObj.imagePath +
        "tab-view/tab_left_over.gif" +
        "')";
      const imgs = this.getElementsByTagName("IMG");
      const img = imgs[imgs.length - 1];
      img.src = DHTMLSuite.configObj.imagePath + "tab-view/tab_right_over.gif";
    }
  },
  __rolloutTab: function () {
    if (this.className == "inactiveTabOver") {
      this.className = "tabInactive";
      this.style.backgroundImage =
        "url('" +
        DHTMLSuite.configObj.imagePath +
        "tab-view/tab_left_inactive.gif" +
        "')";
      const imgs = this.getElementsByTagName("IMG");
      const img = imgs[imgs.length - 1];
      img.src =
        DHTMLSuite.configObj.imagePath + "tab-view/tab_right_inactive.gif";
    }
  },
  __initializeAndParseTabs: function (
    additionalTab,
    nameOfAdditionalTab,
    additionalCloseButton
  ) {
    this.DHTMLSuite_tabObj.className = " DHTMLSuite_tabWidget";
    window.refToThisTabSet = this;
    if (!additionalTab || additionalTab == "undefined") {
      this.DHTMLSuite_tabObj = document.getElementById(this.tabSetParentId);
      this.width = String(this.width);
      if (this.width.indexOf("%") < 0) this.width = this.width + "px";
      this.DHTMLSuite_tabObj.style.width = this.width;
      this.height = String(this.height);
      if (this.height.length > 0) {
        if (this.height.indexOf("%") < 0) this.height = this.height + "px";
        this.DHTMLSuite_tabObj.style.height = this.height;
      }
      var tabDiv = document.createElement("DIV");
      var firstDiv = this.DHTMLSuite_tabObj.getElementsByTagName("DIV")[0];
      this.DHTMLSuite_tabObj.insertBefore(tabDiv, firstDiv);
      tabDiv.className = "DHTMLSuite_tabContainer";
      this.tabView_countTabs = 0;
      var tmpTabTitles = this.tabTitles;
    } else {
      var tabDiv = this.DHTMLSuite_tabObj.getElementsByTagName("DIV")[0];
      var firstDiv = this.DHTMLSuite_tabObj.getElementsByTagName("DIV")[1];
      this.initActiveTabIndex = this.tabView_countTabs;
      var tmpTabTitles = Array(nameOfAdditionalTab);
    }
    for (var no = 0; no < tmpTabTitles.length; no++) {
      const aTab = document.createElement("DIV");
      aTab.id =
        "tabTab" + this.tabSetParentId + "_" + (no + this.tabView_countTabs);
      aTab.onmouseover = this.__rolloverTab;
      aTab.onmouseout = this.__rolloutTab;
      aTab.setAttribute("parentRefId", this.tabSetParentId);
      aTab.parentRefId = this.tabSetParentId;
      var numIndex = String(window.refToThisTabSet.outsideObjectRefIndex);
      aTab.onclick = function () {
        window.refToThisTabSet.__tabClick(this, numIndex);
      };
      DHTMLSuite.commonObj.__addEventEl(aTab);
      aTab.className = "tabInactive";
      aTab.style.backgroundImage =
        "url('" +
        DHTMLSuite.configObj.imagePath +
        "tab-view/tab_left_inactive.gif" +
        "')";
      tabDiv.appendChild(aTab);
      const span = document.createElement("SPAN");
      span.innerHTML = tmpTabTitles[no];
      aTab.appendChild(span);
      if (
        (!additionalTab && this.closeButtons[no]) ||
        (additionalTab && additionalCloseButton)
      ) {
        const closeButton = document.createElement("IMG");
        closeButton.src =
          DHTMLSuite.configObj.imagePath + "tab-view/tab-view-close.gif";
        closeButton.style.position = "absolute";
        closeButton.style.top = "4px";
        closeButton.style.right = "2px";
        closeButton.onmouseover = this.__mouseOverEffectCloseButton;
        closeButton.onmouseout = this.__mouseOutEffectForCloseButton;
        DHTMLSuite.commonObj.__addEventEl(closeButton);
        span.innerHTML =
          span.innerHTML + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        const deleteTxt = String(span.innerHTML);
        closeButton.onclick = function () {
          refToTabViewObjects[numIndex].deleteTab(this.parentNode.innerHTML);
        };
        span.appendChild(closeButton);
      }
      const img = document.createElement("IMG");
      img.valign = "bottom";
      img.src =
        DHTMLSuite.configObj.imagePath + "tab-view/tab_right_inactive.gif";
      if (
        (DHTMLSuite.clientInfoObj.navigatorVersion &&
          DHTMLSuite.clientInfoObj.navigatorVersion < 6) ||
        (DHTMLSuite.clientInfoObj.isMSIE && !this.strictDocType)
      ) {
        img.style.styleFloat = "none";
        img.style.position = "relative";
        img.style.top = "4px";
        span.style.paddingTop = "4px";
        aTab.style.cursor = "hand";
      }
      aTab.appendChild(img);
    }
    const tabs = this.DHTMLSuite_tabObj.getElementsByTagName("DIV");
    let divCounter = 0;
    for (var no = 0; no < tabs.length; no++) {
      if (
        tabs[no].className == "DHTMLSuite_aTab" &&
        tabs[no].parentNode == this.DHTMLSuite_tabObj
      ) {
        if (this.height.length > 0) {
          if (this.height.indexOf("%") == -1) {
            const tmpHeight = this.height.replace("px", "") / 1 - 22;
            tabs[no].style.height = tmpHeight + "px";
          } else tabs[no].style.height = this.height;
        }
        tabs[no].style.display = "none";
        if (tabs[no].id) {
          tabs[no].setAttribute("originalId", tabs[no].id);
          tabs[no].originalId = tabs[no].id;
        }
        tabs[no].id = "tabView" + this.tabSetParentId + "_" + divCounter;
        divCounter++;
      }
    }
    if (additionalTab) {
      this.tabView_countTabs++;
    } else {
      this.tabView_countTabs = this.tabView_countTabs + this.tabTitles.length;
    }
    this.__showTab(
      this.tabSetParentId,
      this.initActiveTabIndex,
      this.outsideObjectRefIndex
    );
    return this.activeTabIndex;
  },
  __mouseOutEffectForCloseButton: function () {
    this.src = this.src.replace("close-over.gif", "close.gif");
  },
  __mouseOverEffectCloseButton: function () {
    this.src = this.src.replace("close.gif", "close-over.gif");
  },
  __fillTabWithContentFromAjax: function (ajaxIndex, objId, tabId) {
    const obj = document.getElementById("tabView" + objId + "_" + tabId);
    obj.innerHTML = this.ajaxObjects[ajaxIndex].response;
  },
  __resetTabIds: function (parentId) {
    let tabTitleCounter = 0;
    let tabContentCounter = 0;
    const divs = this.DHTMLSuite_tabObj.getElementsByTagName("DIV");
    for (let no = 0; no < divs.length; no++) {
      if (
        divs[no].className == "DHTMLSuite_aTab" &&
        divs[no].parentNode == this.DHTMLSuite_tabObj
      ) {
        divs[no].id = "tabView" + parentId + "_" + tabTitleCounter;
        tabTitleCounter++;
      }
      if (
        divs[no].id.indexOf("tabTab") >= 0 &&
        divs[no].parentNode.parentNode == this.DHTMLSuite_tabObj
      ) {
        divs[no].id = "tabTab" + parentId + "_" + tabContentCounter;
        tabContentCounter++;
      }
    }
    this.tabView_countTabs = tabContentCounter;
  },
  getTabIndexByTitle: function (tabTitle) {
    tabTitle = tabTitle.replace(/(.*?)&nbsp.*$/gi, "$1");
    const divs = this.DHTMLSuite_tabObj.getElementsByTagName("DIV");
    for (let no = 0; no < divs.length; no++) {
      if (divs[no].id.indexOf("tabTab") >= 0) {
        const span = divs[no].getElementsByTagName("SPAN")[0];
        const spanTitle = span.innerHTML.replace(/(.*?)&nbsp.*$/gi, "$1");
        if (spanTitle == tabTitle) {
          const tmpId = divs[no].id.split("_");
          return tmpId[tmpId.length - 1].replace(/[^0-9]/g, "") / 1;
        }
      }
    }
    return -1;
  },
};
let JSTreeObj;
let treeUlCounter = 0;
const nodeId = 1;
DHTMLSuite.JSDragDropTree = function () {
  let idOfTree;
  let folderImage;
  let plusImage;
  let minusImage;
  let maximumDepth;
  let dragNode_source;
  let dragNode_parent;
  let dragNode_sourceNextSib;
  let dragNode_noSiblings;
  let dragNode_destination;
  let floatingContainer;
  let dragDropTimer;
  let dropTargetIndicator;
  let insertAsSub;
  let indicator_offsetX;
  let indicator_offsetX_sub;
  let indicator_offsetY;
  let messageMaximumDepthReached;
  let ajaxObjects;
  let layoutCSS;
  let cookieName;
  this.folderImage = "DHTMLSuite_folder.gif";
  this.plusImage = "DHTMLSuite_plus.gif";
  this.minusImage = "DHTMLSuite_minus.gif";
  this.maximumDepth = 6;
  this.layoutCSS = "drag-drop-folder-tree.css";
  this.floatingContainer = document.createElement("UL");
  this.floatingContainer.style.position = "absolute";
  this.floatingContainer.style.display = "none";
  this.floatingContainer.id = "floatingContainer";
  this.insertAsSub = false;
  document.body.appendChild(this.floatingContainer);
  this.dragDropTimer = -1;
  this.dragNode_noSiblings = false;
  this.cookieName = "DHTMLSuite_expandedNodes";
  if (document.all) {
    this.indicator_offsetX = 1;
    this.indicator_offsetX_sub = 1;
    this.indicator_offsetY = 13;
  } else {
    this.indicator_offsetX = 1;
    this.indicator_offsetX_sub = 3;
    this.indicator_offsetY = 5;
  }
  if (navigator.userAgent.indexOf("Opera") >= 0) {
    this.indicator_offsetX = 2;
    this.indicator_offsetX_sub = 3;
    this.indicator_offsetY = -7;
  }
  this.messageMaximumDepthReached = "";
  this.ajaxObjects = new Array();
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  let objectIndex;
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.JSDragDropTree.prototype = {
  init: function () {
    const ind = this.objectIndex;
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    JSTreeObj = this;
    this.__createDropIndicator();
    if (!document.documentElement.onselectstart) {
      document.documentElement.onselectstart = function () {
        return DHTMLSuite.commonObj.__isTextSelOk();
      };
    }
    document.documentElement.ondragstart =
      document.documentElement.ondragstart = function () {
        return false;
      };
    DHTMLSuite.commonObj.__addEventEl(document.documentElement);
    let nodeId = 0;
    const DHTMLSuite_tree = document.getElementById(this.idOfTree);
    const menuItems = DHTMLSuite_tree.getElementsByTagName("LI");
    for (var no = 0; no < menuItems.length; no++) {
      let noChildren = false;
      var tmpVar = menuItems[no].getAttribute("noChildren");
      if (!tmpVar) tmpVar = menuItems[no].noChildren;
      if (tmpVar == "true") noChildren = true;
      let noDrag = false;
      var tmpVar = menuItems[no].getAttribute("noDrag");
      if (!tmpVar) tmpVar = menuItems[no].noDrag;
      if (tmpVar == "true") noDrag = true;
      nodeId++;
      const subItems = menuItems[no].getElementsByTagName("UL");
      const img = document.createElement("IMG");
      img.src =
        DHTMLSuite.configObj.imagePath + "drag-drop-tree/" + this.plusImage;
      img.onclick = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].showHideNode(e);
      };
      DHTMLSuite.commonObj.__addEventEl(img);
      if (subItems.length == 0) img.style.visibility = "hidden";
      else {
        subItems[0].id = "tree_ul_" + treeUlCounter;
        treeUlCounter++;
      }
      const aTag = menuItems[no].getElementsByTagName("A")[0];
      if (!noDrag) aTag.onmousedown = this.__initializeDragProcess;
      if (!noChildren) {
        aTag.onmousemove = function (e) {
          DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveDragableNodes(
            e,
            "text"
          );
        };
        DHTMLSuite.commonObj.__addEventEl(aTag);
      }
      DHTMLSuite.commonObj.__addEventEl(aTag);
      menuItems[no].insertBefore(img, aTag);
      const folderImg = document.createElement("IMG");
      if (!noDrag) folderImg.onmousedown = this.__initializeDragProcess;
      if (!noChildren) {
        folderImg.onmousemove = function (e) {
          DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveDragableNodes(
            e,
            "folder"
          );
        };
        DHTMLSuite.commonObj.__addEventEl(folderImg);
      }
      if (menuItems[no].className) {
        folderImg.src =
          DHTMLSuite.configObj.imagePath +
          "drag-drop-tree/" +
          menuItems[no].className;
      } else {
        folderImg.src =
          DHTMLSuite.configObj.imagePath + "drag-drop-tree/" + this.folderImage;
      }
      DHTMLSuite.commonObj.__addEventEl(folderImg);
      menuItems[no].insertBefore(folderImg, aTag);
    }
    initExpandedNodes = DHTMLSuite.commonObj.getCookie(this.cookieName);
    if (initExpandedNodes) {
      const nodes = initExpandedNodes.split(",");
      for (var no = 0; no < nodes.length; no++) {
        if (nodes[no]) this.showHideNode(false, nodes[no]);
      }
    }
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mousemove",
      DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex]
        .__moveDragableNodes
    );
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mouseup",
      DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex]
        .__dropDragableNodes
    );
  },
  setCookieName: function (cookieName) {
    this.cookieName = cookieName;
  },
  setLayoutCss: function (cssFileName) {
    this.layoutCSS = cssFileName;
  },
  setFolderImage: function (newFolderImage) {
    this.folderImage = newFolderImage;
  },
  setPlusImage: function (newPlusImage) {
    this.plusImage = newPlusImage;
  },
  setMinusImage: function (newMinusImage) {
    this.minusImage = newMinusImage;
  },
  setMaximumDepth: function (maxDepth) {
    this.maximumDepth = maxDepth;
  },
  setMessageMaximumDepthReached: function (newMessage) {
    this.messageMaximumDepthReached = newMessage;
  },
  setTreeId: function (idOfTree) {
    this.idOfTree = idOfTree;
  },
  expandAll: function () {
    const menuItems = document
      .getElementById(this.idOfTree)
      .getElementsByTagName("LI");
    for (let no = 0; no < menuItems.length; no++) {
      const subItems = menuItems[no].getElementsByTagName("UL");
      if (subItems.length > 0 && subItems[0].style.display != "block") {
        this.showHideNode(false, menuItems[no].id);
      }
    }
  },
  collapseAll: function () {
    const menuItems = document
      .getElementById(this.idOfTree)
      .getElementsByTagName("LI");
    for (let no = 0; no < menuItems.length; no++) {
      const subItems = menuItems[no].getElementsByTagName("UL");
      if (subItems.length > 0 && subItems[0].style.display == "block") {
        this.showHideNode(false, menuItems[no].id);
      }
    }
  },
  showHideNode: function (e, inputId) {
    if (inputId) {
      if (!document.getElementById(inputId)) return;
      thisNode = document
        .getElementById(inputId)
        .getElementsByTagName("IMG")[0];
    } else {
      if (document.all) e = event;
      const srcEl = DHTMLSuite.commonObj.getSrcElement(e);
      thisNode = srcEl;
      if (srcEl.tagName == "A") {
        thisNode = srcEl.parentNode.getElementsByTagName("IMG")[0];
      }
    }
    if (thisNode.style.visibility == "hidden") return;
    const parentNode = thisNode.parentNode;
    inputId = parentNode.id.replace(/[^0-9]/g, "");
    if (thisNode.src.indexOf(this.plusImage) >= 0) {
      thisNode.src = thisNode.src.replace(this.plusImage, this.minusImage);
      const ul = parentNode.getElementsByTagName("UL")[0];
      ul.style.display = "block";
      if (!initExpandedNodes) initExpandedNodes = ",";
      if (initExpandedNodes.indexOf("," + inputId + ",") < 0) {
        initExpandedNodes = initExpandedNodes + inputId + ",";
      }
    } else {
      thisNode.src = thisNode.src.replace(this.minusImage, this.plusImage);
      parentNode.getElementsByTagName("UL")[0].style.display = "none";
      initExpandedNodes = initExpandedNodes.replace("," + inputId, "");
    }
    DHTMLSuite.commonObj.setCookie(this.cookieName, initExpandedNodes, 500);
    return false;
  },
  getSaveString: function (initObj, saveString) {
    if (!saveString) var saveString = "";
    if (!initObj) {
      initObj = document.getElementById(this.idOfTree);
    }
    const lis = initObj.getElementsByTagName("LI");
    if (lis.length > 0) {
      let li = lis[0];
      while (li) {
        if (li.id) {
          if (saveString.length > 0) saveString = saveString + ",";
          saveString = saveString + li.id.replace(/[^0-9]/gi, "");
          saveString = saveString + "-";
          saveString =
            li.parentNode.id != this.idOfTree
              ? saveString + li.parentNode.parentNode.id.replace(/[^0-9]/gi, "")
              : saveString + "0";
          const ul = li.getElementsByTagName("UL");
          if (ul.length > 0) {
            saveString = this.getSaveString(ul[0], saveString);
          }
        }
        li = li.nextSibling;
      }
    }
    if (initObj.id == this.idOfTree) {
      return saveString;
    }
    return saveString;
  },
  __initializeDragProcess: function (e) {
    if (document.all) e = event;
    const subs = JSTreeObj.floatingContainer.getElementsByTagName("LI");
    if (subs.length > 0) {
      if (JSTreeObj.dragNode_sourceNextSib) {
        JSTreeObj.dragNode_parent.insertBefore(
          JSTreeObj.dragNode_source,
          JSTreeObj.dragNode_sourceNextSib
        );
      } else {
        JSTreeObj.dragNode_parent.appendChild(JSTreeObj.dragNode_source);
      }
    }
    JSTreeObj.dragNode_source = this.parentNode;
    JSTreeObj.dragNode_parent = this.parentNode.parentNode;
    JSTreeObj.dragNode_sourceNextSib = false;
    if (JSTreeObj.dragNode_source.nextSibling) {
      JSTreeObj.dragNode_sourceNextSib = JSTreeObj.dragNode_source.nextSibling;
    }
    JSTreeObj.dragNode_destination = false;
    JSTreeObj.dragDropTimer = 0;
    DHTMLSuite.commonObj.__setTextSelOk(false);
    JSTreeObj.__waitBeforeDragProcessStarts();
    return false;
  },
  __waitBeforeDragProcessStarts: function () {
    if (this.dragDropTimer >= 0 && this.dragDropTimer < 10) {
      this.dragDropTimer = this.dragDropTimer + 1;
      setTimeout("JSTreeObj.__waitBeforeDragProcessStarts()", 20);
      return;
    }
    if (this.dragDropTimer == 10) {
      JSTreeObj.floatingContainer.style.display = "block";
      JSTreeObj.floatingContainer.appendChild(JSTreeObj.dragNode_source);
    }
  },
  __moveDragableNodes: function (e, tagType) {
    if (JSTreeObj.dragDropTimer < 10) return;
    if (document.all) e = event;
    dragDrop_x = e.clientX / 1 + 5 + document.body.scrollLeft;
    dragDrop_y = e.clientY / 1 + 5 + document.documentElement.scrollTop;
    JSTreeObj.floatingContainer.style.left = dragDrop_x + "px";
    JSTreeObj.floatingContainer.style.top = dragDrop_y + "px";
    let thisObj = DHTMLSuite.commonObj.getSrcElement(e);
    const thisObjOrig = DHTMLSuite.commonObj.getSrcElement(e);
    if (thisObj.tagName == "A" || thisObj.tagName == "IMG") {
      thisObj = thisObj.parentNode;
    }
    JSTreeObj.dragNode_noSiblings = false;
    let tmpVar = thisObj.getAttribute("noSiblings");
    if (!tmpVar) tmpVar = thisObj.noSiblings;
    if (tmpVar == "true") JSTreeObj.dragNode_noSiblings = true;
    if (thisObj && tagType) {
      JSTreeObj.dragNode_destination = thisObj;
      const img = thisObj.getElementsByTagName("IMG")[1];
      const tmpObj = JSTreeObj.dropTargetIndicator;
      tmpObj.style.display = "block";
      let eventSourceObj = thisObjOrig;
      if (JSTreeObj.dragNode_noSiblings && eventSourceObj.tagName == "IMG") {
        eventSourceObj = eventSourceObj.nextSibling;
      }
      const tmpImg = tmpObj.getElementsByTagName("IMG")[0];
      if (thisObjOrig.tagName == "A" || JSTreeObj.dragNode_noSiblings) {
        tmpImg.src = tmpImg.src.replace("ind1", "ind2");
        JSTreeObj.insertAsSub = true;
        tmpObj.style.left =
          DHTMLSuite.commonObj.getLeftPos(eventSourceObj) +
          JSTreeObj.indicator_offsetX_sub +
          "px";
      } else {
        tmpImg.src = tmpImg.src.replace("ind2", "ind1");
        JSTreeObj.insertAsSub = false;
        tmpObj.style.left =
          DHTMLSuite.commonObj.getLeftPos(eventSourceObj) +
          JSTreeObj.indicator_offsetX +
          "px";
      }
      tmpObj.style.top =
        DHTMLSuite.commonObj.getTopPos(thisObj) +
        JSTreeObj.indicator_offsetY +
        "px";
    }
    return false;
  },
  __dropDragableNodes: function () {
    if (JSTreeObj.dragDropTimer < 10) {
      JSTreeObj.dragDropTimer = -1;
      DHTMLSuite.commonObj.__setTextSelOk(true);
      return;
    }
    let showMessage = false;
    if (JSTreeObj.dragNode_destination) {
      const countUp = JSTreeObj.__getDepthOfABranchInTheTree(
        JSTreeObj.dragNode_destination,
        "up"
      );
      const countDown = JSTreeObj.__getDepthOfABranchInTheTree(
        JSTreeObj.dragNode_source,
        "down"
      );
      const countLevels =
        countUp / 1 + countDown / 1 + (JSTreeObj.insertAsSub ? 1 : 0);
      if (countLevels > JSTreeObj.maximumDepth) {
        JSTreeObj.dragNode_destination = false;
        showMessage = true;
      }
    }
    if (JSTreeObj.dragNode_destination) {
      if (JSTreeObj.insertAsSub) {
        const uls = JSTreeObj.dragNode_destination.getElementsByTagName("UL");
        if (uls.length > 0) {
          ul = uls[0];
          ul.style.display = "block";
          var lis = ul.getElementsByTagName("LI");
          if (lis.length > 0) {
            ul.insertBefore(JSTreeObj.dragNode_source, lis[0]);
          } else {
            ul.appendChild(JSTreeObj.dragNode_source);
          }
        } else {
          var ul = document.createElement("UL");
          ul.style.display = "block";
          JSTreeObj.dragNode_destination.appendChild(ul);
          ul.appendChild(JSTreeObj.dragNode_source);
        }
        var img = JSTreeObj.dragNode_destination.getElementsByTagName("IMG")[0];
        img.style.visibility = "visible";
        img.src = img.src.replace(JSTreeObj.plusImage, JSTreeObj.minusImage);
      } else {
        if (JSTreeObj.dragNode_destination.nextSibling) {
          const nextSib = JSTreeObj.dragNode_destination.nextSibling;
          nextSib.parentNode.insertBefore(JSTreeObj.dragNode_source, nextSib);
        } else {
          JSTreeObj.dragNode_destination.parentNode.appendChild(
            JSTreeObj.dragNode_source
          );
        }
      }
      const tmpObj = JSTreeObj.dragNode_parent;
      var lis = tmpObj.getElementsByTagName("LI");
      if (lis.length == 0) {
        var img = tmpObj.parentNode.getElementsByTagName("IMG")[0];
        img.style.visibility = "hidden";
        DHTMLSuite.discardElement(tmpObj);
      }
    } else {
      if (JSTreeObj.dragNode_sourceNextSib) {
        JSTreeObj.dragNode_parent.insertBefore(
          JSTreeObj.dragNode_source,
          JSTreeObj.dragNode_sourceNextSib
        );
      } else {
        JSTreeObj.dragNode_parent.appendChild(JSTreeObj.dragNode_source);
      }
    }
    JSTreeObj.dropTargetIndicator.style.display = "none";
    JSTreeObj.dragDropTimer = -1;
    DHTMLSuite.commonObj.__setTextSelOk(true);
    if (showMessage && JSTreeObj.messageMaximumDepthReached) {
      alert(JSTreeObj.messageMaximumDepthReached);
    }
  },
  __createDropIndicator: function () {
    this.dropTargetIndicator = document.createElement("DIV");
    this.dropTargetIndicator.style.zIndex = 240000;
    this.dropTargetIndicator.style.position = "absolute";
    this.dropTargetIndicator.style.display = "none";
    const img = document.createElement("IMG");
    img.src =
      DHTMLSuite.configObj.imagePath + "drag-drop-tree/" + "dragDrop_ind1.gif";
    img.id = "dragDropIndicatorImage";
    this.dropTargetIndicator.appendChild(img);
    document.body.appendChild(this.dropTargetIndicator);
  },
  __getDepthOfABranchInTheTree: function (obj, direction, stopAtObject) {
    let countLevels = 0;
    if (direction == "up") {
      while (obj.parentNode && obj.parentNode != stopAtObject) {
        obj = obj.parentNode;
        if (obj.tagName == "UL") countLevels = countLevels / 1 + 1;
      }
      return countLevels;
    }
    if (direction == "down") {
      const subObjects = obj.getElementsByTagName("LI");
      for (let no = 0; no < subObjects.length; no++) {
        countLevels = Math.max(
          countLevels,
          JSTreeObj.__getDepthOfABranchInTheTree(subObjects[no], "up", obj)
        );
      }
      return countLevels;
    }
  },
};
DHTMLSuite.ajaxUtil = function () {
  let ajaxObjects;
  this.ajaxObjects = new Array();
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  let objectIndex;
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.ajaxUtil.prototype = {
  sendRequest: function (url, paramString, functionNameOnComplete) {
    const ind = this.objectIndex;
    const ajaxIndex = this.ajaxObjects.length;
    try {
      this.ajaxObjects[ajaxIndex] = new sack();
    } catch (e) {
      alert(
        "Could not create ajax object. Please make sure that ajax.js is included"
      );
    }
    if (paramString) {
      const params = this.__getArrayByParamString(paramString);
      for (let no = 0; no < params.length; no++) {
        this.ajaxObjects[ajaxIndex].setVar(params[no].key, params[no].value);
      }
    }
    this.ajaxObjects[ajaxIndex].requestFile = url;
    this.ajaxObjects[ajaxIndex].onCompletion = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__onComplete(
        ajaxIndex,
        functionNameOnComplete
      );
    };
    this.ajaxObjects[ajaxIndex].onError = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__onError(ajaxIndex, url);
    };
    this.ajaxObjects[ajaxIndex].runAJAX();
  },
  __getArrayByParamString: function (paramString) {
    const retArray = new Array();
    const items = paramString.split(/&/g);
    for (let no = 0; no < items.length; no++) {
      const tokens = items[no].split(/[=]/);
      const index = retArray.length;
      retArray[index] = { key: tokens[0], value: tokens[1] };
    }
    return retArray;
  },
  __onError: function (ajaxIndex, url) {
    alert("Could not send Ajax request to " + url);
  },
  __onComplete: function (ajaxIndex, functionNameOnComplete) {
    const ind = this.objectIndex;
    if (functionNameOnComplete) {
      eval(
        functionNameOnComplete +
          "(DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].ajaxObjects[" +
          ajaxIndex +
          "])"
      );
    }
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__deleteAjaxObject(" +
        ajaxIndex +
        ")",
      3000
    );
  },
  __deleteAjaxObject: function (ajaxIndex) {
    this.ajaxObjects[ajaxIndex] = false;
  },
};
DHTMLSuite.ajax = new DHTMLSuite.ajaxUtil();
DHTMLSuite.dynamicContent = function () {
  let enableCache;
  let jsCache;
  let ajaxObjects;
  let waitMessage;
  this.enableCache = true;
  this.jsCache = new Object();
  this.ajaxObjects = new Array();
  this.waitMessage = "Loading content-please wait...";
  this.waitImage = "dynamic-content/ajax-loader-darkblue.gif";
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  let objectIndex;
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.dynamicContent.prototype = {
  loadContent: function (divId, url, functionToCallOnLoaded) {
    const ind = this.objectIndex;
    if (this.enableCache && this.jsCache[url]) {
      document.getElementById(divId).innerHTML = this.jsCache[url];
      DHTMLSuite.commonObj.__evaluateJs(divId);
      DHTMLSuite.commonObj.__evaluateCss(divId);
      if (functionToCallOnLoaded) eval(functionToCallOnLoaded);
      return;
    }
    var ajaxIndex = 0;
    let waitMessageToShow = "";
    if (this.waitImage) {
      waitMessageToShow =
        waitMessageToShow +
        '<div style="text-align:center;padding:10px"><img src="' +
        DHTMLSuite.configObj.imagePath +
        this.waitImage +
        '" border="0" alt=""></div>';
    }
    if (this.waitMessage) {
      waitMessageToShow =
        waitMessageToShow +
        '<div style="text-align:center">' +
        this.waitMessage +
        "</div>";
    }
    try {
      document.getElementById(divId).innerHTML = waitMessageToShow;
    } catch (e) {}
    waitMessageToShow = false;
    var ajaxIndex = this.ajaxObjects.length;
    try {
      this.ajaxObjects[ajaxIndex] = new sack();
    } catch (e) {
      alert(
        "Could not create ajax object. Please make sure that ajax.js is included"
      );
    }
    if (url.indexOf("?") >= 0) {
      this.ajaxObjects[ajaxIndex].method = "GET";
      let string = url.substring(url.indexOf("?"));
      url = url.replace(string, "");
      string = string.replace("?", "");
      const items = string.split(/&/g);
      for (let no = 0; no < items.length; no++) {
        const tokens = items[no].split("=");
        if (tokens.length == 2) {
          this.ajaxObjects[ajaxIndex].setVar(tokens[0], tokens[1]);
        }
      }
      url = url.replace(string, "");
    }
    this.ajaxObjects[ajaxIndex].requestFile = url;
    this.ajaxObjects[ajaxIndex].onCompletion = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__ajax_showContent(
        divId,
        ajaxIndex,
        url,
        functionToCallOnLoaded
      );
    };
    this.ajaxObjects[ajaxIndex].onError = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__ajax_displayError(
        divId,
        ajaxIndex,
        url,
        functionToCallOnLoaded
      );
    };
    this.ajaxObjects[ajaxIndex].runAJAX();
  },
  setWaitMessage: function (newWaitMessage) {
    this.waitMessage = newWaitMessage;
  },
  setWaitImage: function (newWaitImage) {
    this.waitImage = newWaitImage;
  },
  setCache: function (enableCache) {
    this.enableCache = enableCache;
  },
  __ajax_showContent: function (divId, ajaxIndex, url, functionToCallOnLoaded) {
    document.getElementById(divId).innerHTML = "";
    document.getElementById(divId).innerHTML =
      this.ajaxObjects[ajaxIndex].response;
    if (this.enableCache) {
      this.jsCache[url] = String(document.getElementById(divId).innerHTML);
    }
    DHTMLSuite.commonObj.__evaluateJs(divId);
    DHTMLSuite.commonObj.__evaluateCss(divId);
    if (functionToCallOnLoaded) eval(functionToCallOnLoaded);
    this.ajaxObjects[ajaxIndex] = null;
    return false;
  },
  __ajax_displayError: function (
    divId,
    ajaxIndex,
    url,
    functionToCallOnLoaded
  ) {
    document.getElementById(divId).innerHTML =
      "<h2>Message from DHTMLSuite.dynamicContent</h2><p>The ajax request for " +
      url +
      " failed</p>";
  },
};
DHTMLSuite.sliderObjects = new Array();
DHTMLSuite.indexOfCurrentlyActiveSlider = false;
DHTMLSuite.slider_generalMouseEventsAdded = false;
DHTMLSuite.slider = function () {
  let width;
  let height;
  let targetObj;
  let sliderWidth;
  let sliderDirection;
  let functionToCallOnChange;
  let layoutCss;
  let sliderMaxValue;
  let sliderMinValue;
  let initialValue;
  let sliderSize;
  let directionOfPointer;
  let slideInProcessTimer;
  let indexThisSlider;
  let numberOfSteps;
  let stepLinesVisibility;
  let slide_event_pos;
  let slide_start_pos;
  let sliderHandleImg;
  let sliderName;
  let sliderValueReversed;
  this.sliderWidth = 9;
  this.layoutCss = "slider.css";
  this.sliderDirection = "hor";
  this.width = 0;
  this.height = 0;
  this.sliderMaxValue = 100;
  this.sliderMinValue = 0;
  this.initialValue = 0;
  this.targetObj = false;
  this.directionOfPointer = "up";
  this.slideInProcessTimer = -1;
  this.sliderName = "";
  this.numberOfSteps = false;
  this.stepLinesVisibility = true;
  this.sliderValueReversed = false;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  let objectIndex;
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.slider.prototype = {
  init: function () {
    if (!this.targetObj) {
      alert("Error!-No target for slider specified");
      return;
    }
    this.__setWidthAndHeightDynamically();
    DHTMLSuite.commonObj.loadCSS(this.layoutCss);
    this.__createSlider();
    if (!document.documentElement.onselectstart) {
      document.documentElement.onselectstart = function () {
        return DHTMLSuite.commonObj.__isTextSelOk();
      };
    }
  },
  setSliderTarget: function (targetRef) {
    targetRef = DHTMLSuite.commonObj.getEl(targetRef);
    this.targetObj = targetRef;
  },
  setSliderDirection: function (newDirection) {
    newDirection = String(newDirection);
    newDirection = newDirection.toLowerCase();
    if (newDirection != "hor" && newDirection != "ver") {
      alert('Invalid slider direction-possible values: "hor" or "ver"');
      return;
    }
    this.sliderDirection = newDirection;
  },
  setSliderWidth: function (newWidth) {
    newWidth = String(newWidth);
    if (newWidth.indexOf("%") == -1) newWidth = newWidth + "px";
    this.width = newWidth;
  },
  setSliderHeight: function (newHeight) {
    newHeight = String(newHeight);
    if (newHeight.indexOf("%") == -1) newHeight = newHeight + "px";
    this.height = height;
  },
  setSliderReversed: function () {
    this.sliderValueReversed = true;
  },
  setOnChangeEvent: function (nameOfFunction) {
    this.functionToCallOnChange = nameOfFunction;
  },
  setSliderMaxValue: function (newMaxValue) {
    this.sliderMaxValue = newMaxValue;
  },
  setSliderMinValue: function (newMinValue) {
    this.sliderMinValue = newMinValue;
  },
  setSliderName: function (nameOfSlider) {
    this.sliderName = nameOfSlider;
  },
  setLayoutCss: function (nameOfNewCssFile) {
    this.layoutCss = nameOfNewCssFile;
  },
  setInitialValue: function (newInitialValue) {
    this.initialValue = newInitialValue;
  },
  setSliderPointerDirection: function (directionOfPointer) {
    this.directionOfPointer = directionOfPointer;
  },
  setSliderValue: function (newValue) {
    const position = Math.floor(
      (newValue / this.sliderMaxValue) * this.sliderSize
    );
    if (this.sliderDirection == "hor") {
      this.sliderHandleImg.style.left = position + "px";
    } else {
      this.sliderHandleImg.style.top = position + "px";
    }
  },
  setNumberOfSliderSteps: function (numberOfSteps) {
    this.numberOfSteps = numberOfSteps;
  },
  setStepLinesVisible: function (visible) {
    this.stepLinesVisibility = visible;
  },
  __setWidthAndHeightDynamically: function () {
    if (!this.width || this.width == 0) {
      this.width = String(this.targetObj.clientWidth);
    }
    if (!this.height || this.height == 0) {
      this.height = String(this.targetObj.clientHeight);
    }
    if (!this.width || this.width == 0) {
      this.width = String(this.targetObj.offsetWidth);
    }
    if (!this.height || this.height == 0) {
      this.height = String(this.targetObj.offsetHeight);
    }
    if (this.width == 0) return;
    if (this.height == 0) return;
    if (this.width.indexOf("px") == -1 && this.width.indexOf("%") == -1) {
      this.width = this.width + "px";
    }
    if (this.height.indexOf("px") == -1 && this.height.indexOf("%") == -1) {
      this.height = this.height + "px";
    }
  },
  __createSlider: function (initWidth) {
    if (this.targetObj.clientWidth == 0 || initWidth == 0) {
      const timeoutTime = 100;
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          this.objectIndex +
          "].__createSlider(" +
          this.targetObj.clientWidth +
          ")",
        timeoutTime
      );
      return;
    }
    this.__setWidthAndHeightDynamically();
    this.indexThisSlider = DHTMLSuite.sliderObjects.length;
    DHTMLSuite.sliderObjects[this.indexThisSlider] = this;
    window.refToThisObject = this;
    const div = document.createElement("DIV");
    div.style.width = this.width;
    div.style.cursor = "default";
    div.style.height = this.height;
    div.style.position = "relative";
    div.id = "sliderNumber" + this.indexThisSlider;
    div.onmousedown = this.__setPositionFromClick;
    DHTMLSuite.commonObj.__addEventEl(div);
    this.targetObj.appendChild(div);
    const sliderObj = document.createElement("DIV");
    if (this.sliderDirection == "hor") {
      sliderObj.className = "DHTMLSuite_slider_horizontal";
      sliderObj.style.width = div.clientWidth + "px";
      this.sliderSize = div.offsetWidth - this.sliderWidth;
      var sliderHandle = document.createElement("IMG");
      var srcHandle = "slider_handle_down.gif";
      sliderHandle.style.bottom = "2px";
      if (this.directionOfPointer == "up") {
        srcHandle = "slider_handle_up.gif";
        sliderHandle.style.bottom = "0px";
      }
      sliderHandle.src = DHTMLSuite.configObj.imagePath + "slider/" + srcHandle;
      div.appendChild(sliderHandle);
      let leftPos;
      leftPos = this.sliderValueReversed
        ? Math.round(
            ((this.sliderMaxValue - this.initialValue) / this.sliderMaxValue) *
              this.sliderSize
          ) - 1
        : Math.round(
            (this.initialValue / this.sliderMaxValue) * this.sliderSize
          );
      sliderHandle.style.left = leftPos + "px";
    } else {
      sliderObj.className = "DHTMLSuite_slider_vertical";
      sliderObj.style.height = div.clientHeight + "px";
      this.sliderSize = div.clientHeight - this.sliderWidth;
      var sliderHandle = document.createElement("IMG");
      var srcHandle = "slider_handle_right.gif";
      sliderHandle.style.left = "0px";
      if (this.directionOfPointer == "left") {
        srcHandle = "slider_handle_left.gif";
        sliderHandle.style.left = "0px";
      }
      sliderHandle.src = DHTMLSuite.configObj.imagePath + "slider/" + srcHandle;
      div.appendChild(sliderHandle);
      let topPos;
      topPos = !this.sliderValueReversed
        ? Math.floor(
            ((this.sliderMaxValue - this.initialValue) / this.sliderMaxValue) *
              this.sliderSize
          )
        : Math.floor(
            (this.initialValue / this.sliderMaxValue) * this.sliderSize
          );
      sliderHandle.style.top = topPos + "px";
    }
    sliderHandle.id = "sliderForObject" + this.indexThisSlider;
    sliderHandle.style.position = "absolute";
    sliderHandle.style.zIndex = 5;
    sliderHandle.onmousedown = this.__initializeSliderDrag;
    sliderHandle.ondragstart = function () {
      return false;
    };
    sliderHandle.onselectstart = function () {
      return false;
    };
    DHTMLSuite.commonObj.__addEventEl(sliderHandle);
    this.sliderHandleImg = sliderHandle;
    if (!DHTMLSuite.slider_generalMouseEventsAdded) {
      DHTMLSuite.commonObj.addEvent(
        document.documentElement,
        "mousemove",
        this.__moveSlider
      );
      DHTMLSuite.commonObj.addEvent(
        document.documentElement,
        "mouseup",
        this.__stopSlideProcess
      );
      DHTMLSuite.slider_generalMouseEventsAdded = true;
    }
    sliderObj.innerHTML = '<span style="cursor:default"></span>';
    div.appendChild(sliderObj);
    if (this.numberOfSteps && this.stepLinesVisibility) {
      const stepSize = this.sliderSize / this.numberOfSteps;
      for (let no = 0; no <= this.numberOfSteps; no++) {
        const lineDiv = document.createElement("DIV");
        lineDiv.style.position = "absolute";
        lineDiv.innerHTML = "<span></span>";
        div.appendChild(lineDiv);
        if (this.sliderDirection == "hor") {
          lineDiv.className = "DHTMLSuite_smallLines_vertical";
          lineDiv.style.left =
            Math.floor(stepSize * no + this.sliderWidth / 2) + "px";
        } else {
          lineDiv.className = "DHTMLSuite_smallLines_horizontal";
          lineDiv.style.top =
            Math.floor(stepSize * no + this.sliderWidth / 2) + "px";
          lineDiv.style.left = "14px";
        }
      }
    }
  },
  __initializeSliderDrag: function (e) {
    if (document.all) e = event;
    DHTMLSuite.commonObj.__setTextSelOk(false);
    const numIndex = this.id.replace(/[^0-9]/gi, "");
    const sliderObj = DHTMLSuite.sliderObjects[numIndex];
    DHTMLSuite.indexOfCurrentlyActiveSlider = numIndex;
    sliderObj.slideInProcessTimer = 0;
    if (sliderObj.sliderDirection == "hor") {
      sliderObj.slide_event_pos = e.clientX;
      sliderObj.slide_start_pos = this.style.left.replace("px", "") / 1;
    } else {
      sliderObj.slide_event_pos = e.clientY;
      sliderObj.slide_start_pos = this.style.top.replace("px", "") / 1;
    }
    sliderObj.__waitBeforeSliderDragStarts();
    return false;
  },
  __setPositionFromClick: function (e) {
    if (document.all) e = event;
    if (e.target) srcEvent = e.target;
    else if (e.srcElement) srcEvent = e.srcElement;
    if (srcEvent.nodeType == 3) srcEvent = srcEvent.parentNode;
    if (srcEvent.tagName != "DIV") return;
    const numIndex = this.id.replace(/[^0-9]/gi, "");
    const sliderObj = DHTMLSuite.sliderObjects[numIndex];
    if (sliderObj.numberOfSteps) {
      modValue = sliderObj.sliderSize / sliderObj.numberOfSteps;
    }
    if (sliderObj.sliderDirection == "hor") {
      var handlePos =
        e.clientX -
        DHTMLSuite.commonObj.getLeftPos(this) -
        Math.ceil(sliderObj.sliderWidth / 2);
    } else {
      var handlePos =
        e.clientY -
        DHTMLSuite.commonObj.getTopPos(this) -
        Math.ceil(sliderObj.sliderWidth / 2);
    }
    if (sliderObj.numberOfSteps) {
      let mod = handlePos % modValue;
      if (mod > modValue / 2) mod = modValue - mod;
      else mod *= -1;
      handlePos = handlePos + mod;
    }
    if (handlePos < 0) handlePos = 0;
    if (handlePos > sliderObj.sliderSize) handlePos = sliderObj.sliderSize;
    if (sliderObj.sliderDirection == "hor") {
      sliderObj.sliderHandleImg.style.left = handlePos + "px";
      returnValue = !sliderObj.sliderValueReversed
        ? Math.round(
            (handlePos / sliderObj.sliderSize) *
              (sliderObj.sliderMaxValue - sliderObj.sliderMinValue)
          )
        : Math.round(
            ((sliderObj.sliderSize - handlePos) / sliderObj.sliderSize) *
              (sliderObj.sliderMaxValue - sliderObj.sliderMinValue)
          );
    } else {
      sliderObj.sliderHandleImg.style.top = handlePos + "px";
      returnValue = sliderObj.sliderValueReversed
        ? Math.round(
            (handlePos / sliderObj.sliderSize) *
              (sliderObj.sliderMaxValue - sliderObj.sliderMinValue)
          )
        : Math.round(
            ((sliderObj.sliderSize - handlePos) / sliderObj.sliderSize) *
              (sliderObj.sliderMaxValue - sliderObj.sliderMinValue)
          );
    }
    returnValue = returnValue + sliderObj.sliderMinValue;
    if (sliderObj.functionToCallOnChange) {
      eval(
        sliderObj.functionToCallOnChange +
          "(" +
          returnValue +
          ',"' +
          sliderObj.sliderName +
          '")'
      );
    }
    DHTMLSuite.indexOfCurrentlyActiveSlider = numIndex;
    sliderObj.slideInProcessTimer = 10;
    if (sliderObj.sliderDirection == "hor") {
      sliderObj.slide_event_pos = e.clientX;
      sliderObj.slide_start_pos = handlePos;
    } else {
      sliderObj.slide_event_pos = e.clientY;
      sliderObj.slide_start_pos = handlePos;
    }
    DHTMLSuite.commonObj.__setTextSelOk(false);
  },
  __waitBeforeSliderDragStarts: function () {
    if (this.slideInProcessTimer < 10 && this.slideInProcessTimer >= 0) {
      this.slideInProcessTimer += 2;
      window.refToThisSlider = this;
      setTimeout("window.refToThisSlider.__waitBeforeSliderDragStarts()", 5);
    }
  },
  __moveSlider: function (e) {
    if (DHTMLSuite.indexOfCurrentlyActiveSlider === false) return;
    const sliderObj =
      DHTMLSuite.sliderObjects[DHTMLSuite.indexOfCurrentlyActiveSlider];
    if (document.all) e = event;
    if (sliderObj.slideInProcessTimer < 10) return;
    let returnValue;
    if (sliderObj.numberOfSteps) {
      modValue = sliderObj.sliderSize / sliderObj.numberOfSteps;
    }
    if (sliderObj.sliderDirection == "hor") {
      var handlePos =
        e.clientX - sliderObj.slide_event_pos + sliderObj.slide_start_pos;
    } else {
      var handlePos =
        e.clientY - sliderObj.slide_event_pos + sliderObj.slide_start_pos;
    }
    if (sliderObj.numberOfSteps) {
      let mod = handlePos % modValue;
      if (mod > modValue / 2) mod = modValue - mod;
      else mod *= -1;
      handlePos = handlePos + mod;
    }
    if (handlePos < 0) handlePos = 0;
    if (handlePos > sliderObj.sliderSize) handlePos = sliderObj.sliderSize;
    if (sliderObj.sliderDirection == "hor") {
      sliderObj.sliderHandleImg.style.left = handlePos + "px";
      returnValue = !sliderObj.sliderValueReversed
        ? Math.round(
            (handlePos / sliderObj.sliderSize) *
              (sliderObj.sliderMaxValue - sliderObj.sliderMinValue)
          )
        : Math.round(
            ((sliderObj.sliderSize - handlePos) / sliderObj.sliderSize) *
              (sliderObj.sliderMaxValue - sliderObj.sliderMinValue)
          );
    } else {
      sliderObj.sliderHandleImg.style.top = handlePos + "px";
      returnValue = sliderObj.sliderValueReversed
        ? Math.round(
            (handlePos / sliderObj.sliderSize) *
              (sliderObj.sliderMaxValue - sliderObj.sliderMinValue)
          )
        : Math.round(
            ((sliderObj.sliderSize - handlePos) / sliderObj.sliderSize) *
              (sliderObj.sliderMaxValue - sliderObj.sliderMinValue)
          );
    }
    returnValue = returnValue + sliderObj.sliderMinValue;
    if (sliderObj.functionToCallOnChange) {
      eval(
        sliderObj.functionToCallOnChange +
          "(" +
          returnValue +
          ',"' +
          sliderObj.sliderName +
          '")'
      );
    }
  },
  __stopSlideProcess: function (e) {
    DHTMLSuite.commonObj.__setTextSelOk(true);
    if (!DHTMLSuite.indexOfCurrentlyActiveSlider) return;
    const sliderObj =
      DHTMLSuite.sliderObjects[DHTMLSuite.indexOfCurrentlyActiveSlider];
    sliderObj.slideInProcessTimer = -1;
  },
};
DHTMLSuite.modalMessage = function (props) {
  let url;
  let htmlOfModalMessage;
  let domRef;
  let divs_transparentDiv;
  let divs_content;
  let iframeEl;
  let layoutCss;
  let width;
  let height;
  let isModal;
  let existingBodyOverFlowStyle;
  let dynContentObj;
  let cssClassOfMessageBox;
  let shadowDivVisible;
  let shadowOffset;
  let objectIndex;
  this.url = "";
  this.htmlOfModalMessage = "";
  this.layoutCss = "modal-message.css";
  this.height = 200;
  this.width = 400;
  this.cssClassOfMessageBox = false;
  this.shadowDivVisible = true;
  this.shadowOffset = 5;
  this.isModal = true;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
  const ind = this.objectIndex;
  DHTMLSuite.commonObj.addEvent(window, "resize", function () {
    DHTMLSuite.variableStorage.arrayDSObjects[ind].__resizeTransparentDiv();
  });
  if (props) this.__setInitialProps(props);
};
DHTMLSuite.modalMessage.prototype = {
  __setInitialProps: function (props) {
    if (props.url) this.setSource(props.url);
    if (props.htmlOfModalMessage) this.setHtmlContent(props.htmlOfModalMessage);
    if (props.domRef) this.setDomReference(props.domRef);
    if (props.width) this.width = props.width;
    if (props.height) this.height = props.height;
    if (props.cssClassOfMessageBox) {
      this.cssClassOfMessageBox = props.cssClassOfMessageBox;
    }
    if (props.shadowOffset) this.shadowOffset = props.shadowOffset;
    if (props.shadowDivVisible) this.shadowDivVisible = props.shadowDivVisible;
    if (props.isModal || props.isModal === false || props.isModal === 0) {
      this.isModal = props.isModal;
    }
    if (props.waitMessage) this.setWaitMessage(waitMessage);
  },
  setIsModal: function (isModal) {
    this.isModal = isModal;
  },
  setSource: function (urlOfSource) {
    if (urlOfSource) this.__clearProperties();
    this.url = urlOfSource;
  },
  setHtmlContent: function (newHtmlContent) {
    if (newHtmlContent) this.__clearProperties();
    this.htmlOfModalMessage = newHtmlContent;
  },
  setDomReference: function (domRef) {
    if (domRef) this.__clearProperties();
    if (domRef) domRef = DHTMLSuite.commonObj.getEl(domRef);
    if (domRef) {
      domRef = domRef.cloneNode(true);
    }
    this.domRef = domRef;
  },
  setSize: function (width, height) {
    if (width) this.width = width;
    if (height) this.height = height;
  },
  setCssClassMessageBox: function (newCssClass) {
    this.cssClassOfMessageBox = newCssClass;
    if (this.divs_content) {
      if (this.cssClassOfMessageBox) {
        this.divs_content.className = this.cssClassOfMessageBox;
      } else this.divs_content.className = "modalDialog_contentDiv";
    }
  },
  setShadowOffset: function (newShadowOffset) {
    this.shadowOffset = newShadowOffset;
  },
  setWaitMessage: function (newMessage) {
    if (!this.dynContentObj) {
      try {
        this.dynContentObj = new DHTMLSuite.dynamicContent();
      } catch (e) {
        alert("Include dhtmlSuite-dynamicContent.js");
      }
    }
    this.dynContentObj.setWaitMessage(newMessage);
  },
  setWaitImage: function (newImage) {
    if (!this.dynContentObj) {
      try {
        this.dynContentObj = new DHTMLSuite.dynamicContent();
      } catch (e) {
        alert("Include dhtmlSuite-dynamicContent.js");
      }
    }
    this.dynContentObj.setWaitImage(newImage);
  },
  setCache: function (cacheStatus) {
    if (!this.dynContentObj) {
      try {
        this.dynContentObj = new DHTMLSuite.dynamicContent();
      } catch (e) {
        alert("Include dhtmlSuite-dynamicContent.js");
      }
    }
    this.dynContentObj.setCache(cacheStatus);
  },
  display: function () {
    const ind = this.objectIndex;
    if (!this.divs_transparentDiv) {
      DHTMLSuite.commonObj.loadCSS(this.layoutCss);
      this.__createDivElements();
    }
    this.__resizeAndPositionDivElements();
    if (this.isModal) {
      this.divs_transparentDiv.style.display = "block";
    } else {
      this.divs_transparentDiv.style.display = "none";
    }
    this.divs_content.style.display = "block";
    this.divs_shadow.style.display = "block";
    if (this.iframeEl) {
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          '].iframeEl.style.display="block"',
        150
      );
    }
    this.__resizeAndPositionDivElements();
    window.refToThisModalBoxObj = this;
    setTimeout(
      "window.refToThisModalBoxObj.__resizeAndPositionDivElements()",
      100
    );
    this.__addHTMLContent();
  },
  setShadowDivVisible: function (visible) {
    this.shadowDivVisible = visible;
  },
  close: function () {
    document.documentElement.style.overflow = "";
    this.divs_transparentDiv.style.display = "none";
    this.divs_content.style.display = "none";
    this.divs_shadow.style.display = "none";
    if (this.iframeEl) this.iframeEl.style.display = "none";
  },
  __clearProperties: function () {
    if (this.domRef) DHTMLSuite.discardElement(this.domRef);
    this.domRef = null;
    this.url = false;
    this.htmlOfModalMessage = false;
  },
  __createDivElements: function () {
    this.divs_transparentDiv = document.createElement("DIV");
    this.divs_transparentDiv.className =
      "DHTMLSuite_modalDialog_transparentDivs";
    this.divs_transparentDiv.style.left = "0px";
    this.divs_transparentDiv.style.top = "0px";
    document.body.appendChild(this.divs_transparentDiv);
    if (!document.getElementById("DHTMLSuite_modalBox_contentDiv")) {
      this.divs_content = document.createElement("DIV");
      this.divs_content.className = "DHTMLSuite_modalDialog_contentDiv";
      this.divs_content.id = "DHTMLSuite_modalBox_contentDiv";
      document.body.appendChild(this.divs_content);
    } else {
      this.divs_content = document.getElementById(
        "DHTMLSuite_modalBox_contentDiv"
      );
    }
    this.divs_shadow = document.createElement("DIV");
    this.divs_shadow.className = "DHTMLSuite_modalDialog_contentDiv_shadow";
    document.body.appendChild(this.divs_shadow);
    if (DHTMLSuite.clientInfoObj.isMSIE) {
      this.iframeEl = document.createElement(
        '<iframe frameborder=0 src="about:blank" scrolling="no">'
      );
      this.iframeEl.style.filter = "alpha(opacity=0)";
      this.iframeEl.style.cssText = "filter:alpha(opacity=0)";
      this.iframeEl.style.position = "absolute";
      this.iframeEl.style.zIndex = 100001;
      this.iframeEl.style.display = "none";
      this.iframeEl.style.left = "0px";
      this.iframeEl.style.top = "0px";
      document.body.appendChild(this.iframeEl);
    }
  },
  __resizeAndPositionDivElements: function () {
    const topOffset = Math.max(
      document.body.scrollTop,
      document.documentElement.scrollTop
    );
    if (this.cssClassOfMessageBox) {
      this.divs_content.className = this.cssClassOfMessageBox;
    } else this.divs_content.className = "DHTMLSuite_modalDialog_contentDiv";
    if (!this.divs_transparentDiv) return;
    const bodyWidth = DHTMLSuite.clientInfoObj.getBrowserWidth();
    const bodyHeight = DHTMLSuite.clientInfoObj.getBrowserHeight();
    this.divs_content.style.width = this.width + "px";
    this.divs_content.style.height = this.height + "px";
    const tmpWidth = this.divs_content.offsetWidth;
    const tmpHeight = this.divs_content.offsetHeight;
    this.divs_content.style.left = Math.ceil((bodyWidth - tmpWidth) / 2) + "px";
    this.divs_content.style.top =
      Math.ceil((bodyHeight - tmpHeight) / 2) + topOffset + "px";
    this.divs_shadow.style.left =
      this.divs_content.style.left.replace("px", "") / 1 +
      this.shadowOffset +
      "px";
    this.divs_shadow.style.top =
      this.divs_content.style.top.replace("px", "") / 1 +
      this.shadowOffset +
      "px";
    this.divs_shadow.style.height = tmpHeight + "px";
    this.divs_shadow.style.width = tmpWidth + "px";
    if (!this.shadowDivVisible) this.divs_shadow.style.display = "none";
    this.__resizeTransparentDiv();
  },
  __resizeTransparentDiv: function () {
    if (!this.divs_transparentDiv) return;
    const divHeight = DHTMLSuite.clientInfoObj.getBrowserHeight();
    const divWidth = DHTMLSuite.clientInfoObj.getBrowserWidth();
    this.divs_transparentDiv.style.height = divHeight + "px";
    this.divs_transparentDiv.style.width = divWidth + "px";
    if (this.iframeEl) {
      this.iframeEl.style.width = this.divs_transparentDiv.style.width;
      this.iframeEl.style.height = this.divs_transparentDiv.style.height;
    }
  },
  __addHTMLContent: function () {
    if (!this.dynContentObj) {
      try {
        this.dynContentObj = new DHTMLSuite.dynamicContent();
      } catch (e) {
        alert("Include dhtmlSuite-dynamicContent.js");
      }
    }
    if (this.url) {
      this.dynContentObj.loadContent(
        "DHTMLSuite_modalBox_contentDiv",
        this.url
      );
    }
    if (this.htmlOfModalMessage) {
      this.divs_content.innerHTML = this.htmlOfModalMessage;
    }
    if (this.domRef) {
      this.divs_content.innerHTML = "";
      this.divs_content.appendChild(this.domRef);
      const dis = DHTMLSuite.commonObj.getStyle(this.domRef, "display");
      if (dis == "none") this.domRef.style.display = "block";
      this.domRef.style.visibility = "visible";
    }
  },
};
DHTMLSuite.dynamicTooltip = function () {
  let x_offset_tooltip;
  let y_offset_tooltip;
  let ajax_tooltipObj;
  let ajax_tooltipObj_iframe;
  let dynContentObj;
  let layoutCss;
  let waitMessage;
  this.x_offset_tooltip = 5;
  this.y_offset_tooltip = 0;
  this.ajax_tooltipObj = false;
  this.ajax_tooltipObj_iframe = false;
  this.layoutCss = "dynamic-tooltip.css";
  this.waitMessage = "";
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
};
DHTMLSuite.dynamicTooltip.prototype = {
  setWaitMessage: function (waitMessage) {
    this.waitMessage = waitMessage;
  },
  displayTooltip: function (externalFile, inputObj, staticContent) {
    DHTMLSuite.commonObj.loadCSS(this.layoutCss);
    if (!this.dynContentObj) {
      try {
        this.dynContentObj = new DHTMLSuite.dynamicContent();
        if (this.waitMessage) {
          this.dynContentObj.setWaitMessage(this.waitMessage);
        }
      } catch (e) {
        alert("Include dhtmlSuite-dynamicContent.js");
      }
    }
    if (
      !this.ajax_tooltipObj &&
      document.getElementById("DHTMLSuite_ajax_tooltipObj")
    ) {
      DHTMLSuite.discardElement("DHTMLSuite_ajax_tooltipObj");
    }
    if (!this.ajax_tooltipObj) {
      this.ajax_tooltipObj = document.createElement("DIV");
      this.ajax_tooltipObj.style.position = "absolute";
      this.ajax_tooltipObj.id = "DHTMLSuite_ajax_tooltipObj";
      document.body.appendChild(this.ajax_tooltipObj);
      const leftDiv = document.createElement("DIV");
      leftDiv.className = "DHTMLSuite_ajax_tooltip_arrow";
      leftDiv.id = "DHTMLSuite_ajax_tooltip_arrow";
      leftDiv.style.backgroundImage =
        "url('" +
        DHTMLSuite.configObj.imagePath +
        "dynamic-tooltip/dyn-tooltip-arrow.gif" +
        "')";
      this.ajax_tooltipObj.appendChild(leftDiv);
      const contentDiv = document.createElement("DIV");
      contentDiv.className = "DHTMLSuite_ajax_tooltip_content";
      this.ajax_tooltipObj.appendChild(contentDiv);
      contentDiv.id = "DHTMLSuite_ajax_tooltip_content";
      if (DHTMLSuite.clientInfoObj.isMSIE) {
        this.ajax_tooltipObj_iframe = document.createElement(
          '<IFRAME frameborder="0">'
        );
        const fr = this.ajax_tooltipObj_iframe;
        fr.style.position = "absolute";
        fr.id = "DHTMLSuite_ajax_tooltipObjIframe";
        fr.border = "0";
        fr.frameborder = 0;
        fr.style.backgroundColor = "#FFF";
        fr.src = "about:blank";
        contentDiv.appendChild(fr);
        fr.style.left = "0px";
        fr.style.top = "0px";
      }
    }
    this.ajax_tooltipObj.style.display = "block";
    if (externalFile) {
      this.dynContentObj.loadContent(
        "DHTMLSuite_ajax_tooltip_content",
        externalFile
      );
    } else {
      this.ajax_tooltipObj.innerHTML = staticContent;
    }
    if (DHTMLSuite.clientInfoObj.isMSIE) {
      this.ajax_tooltipObj_iframe.style.width =
        this.ajax_tooltipObj.clientWidth + "px";
      this.ajax_tooltipObj_iframe.style.height =
        this.ajax_tooltipObj.clientHeight + "px";
    }
    this.__positionTooltip(inputObj);
  },
  setLayoutCss: function (newCssFileName) {
    this.layoutCss = newCssFileName;
  },
  hideTooltip: function () {
    this.ajax_tooltipObj.style.display = "none";
  },
  __positionTooltip: function (inputObj) {
    const leftPos =
      DHTMLSuite.commonObj.getLeftPos(inputObj) + inputObj.offsetWidth;
    const topPos = DHTMLSuite.commonObj.getTopPos(inputObj);
    const tooltipWidth =
      document.getElementById("DHTMLSuite_ajax_tooltip_content").offsetWidth +
      document.getElementById("DHTMLSuite_ajax_tooltip_arrow").offsetWidth;
    this.ajax_tooltipObj.style.left = leftPos + "px";
    this.ajax_tooltipObj.style.top = topPos + "px";
  },
};
DHTMLSuite.infoPanel = function () {
  let xpPanel_slideActive;
  let xpPanel_slideSpeed;
  let xpPanel_onlyOneExpandedPane;
  let savedActivePane;
  let savedActiveSub;
  let xpPanel_currentDirection;
  let cookieNames;
  let layoutCSS;
  let arrayOfPanes;
  let dynamicContentObj;
  let paneHeights;
  const currentlyExpandedPane = false;
  this.xpPanel_slideActive = true;
  this.xpPanel_slideSpeed = 20;
  this.xpPanel_onlyOneExpandedPane = false;
  this.savedActivePane = false;
  this.savedActiveSub = false;
  this.xpPanel_currentDirection = new Object();
  this.cookieNames = new Array();
  this.currentlyExpandedPane = false;
  this.layoutCSS = "info-pane.css";
  this.arrayOfPanes = new Array();
  this.paneHeights = new Object();
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  try {
    this.dynamicContentObj = new DHTMLSuite.dynamicContent();
  } catch (e) {
    alert("Include dhtmlSuite-dynamicContent.js");
  }
};
DHTMLSuite.infoPanel.prototype = {
  addPane: function (idOfPane, labelOfPane, state, nameOfCookie, width) {
    const index = this.arrayOfPanes.length;
    this.arrayOfPanes[index] = [
      idOfPane,
      labelOfPane,
      state,
      nameOfCookie,
      width,
    ];
  },
  addContentToPane: function (idOfPane, pathToExternalFile) {
    const obj = document.getElementById(idOfPane);
    const subDivs = obj.getElementsByTagName("DIV");
    for (let no = 0; no < subDivs.length; no++) {
      if (subDivs[no].className == "DHTMLSuite_infoPaneContent") {
        window.refToThisPane = this;
        this.__slidePane(this.xpPanel_slideSpeed, subDivs[no].id);
        this.dynamicContentObj.loadContent(
          subDivs[no].id,
          pathToExternalFile,
          "window.refToThisPane.__resizeAndRepositionPane('" + idOfPane + "')"
        );
        if (
          subDivs[no].parentNode.style.display == "none" ||
          subDivs[no].parentNode.style.height == "0px"
        ) {
          const topBarObj = DHTMLSuite.domQueryObj.getElementsByClassName(
            "DHTMLSuite_infoPaneTopBar",
            subDivs[no].parentNode.parentNode
          );
          this.__showHidePaneContent(topBarObj[0]);
        }
        return;
      }
    }
  },
  addStaticContentToPane: function (idOfPane, newContent) {
    const obj = document.getElementById(idOfPane);
    const subDivs = obj.getElementsByTagName("DIV");
    for (let no = 0; no < subDivs.length; no++) {
      if (subDivs[no].className == "DHTMLSuite_infoPaneContent") {
        window.refToThisPane = this;
        this.__slidePane(this.xpPanel_slideSpeed, subDivs[no].id);
        subDivs[no].innerHTML = newContent;
        if (
          subDivs[no].parentNode.style.display == "none" ||
          subDivs[no].parentNode.style.height == "0px"
        ) {
          const topBarObj = DHTMLSuite.domQueryObj.getElementsByClassName(
            "DHTMLSuite_infoPaneTopBar",
            subDivs[no].parentNode.parentNode
          );
          this.__showHidePaneContent(topBarObj[0]);
        }
        this.__resizeAndRepositionPane(idOfPane);
        return;
      }
    }
  },
  init: function () {
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    for (let no = 0; no < this.arrayOfPanes.length; no++) {
      const tmpDiv = document.getElementById(this.arrayOfPanes[no][0]);
      tmpDiv.className = "DHTMLSuite_panel";
      const panelTitle = this.arrayOfPanes[no][1];
      let panelDisplayed = this.arrayOfPanes[no][2];
      const nameOfCookie = this.arrayOfPanes[no][3];
      const widthOfPane = this.arrayOfPanes[no][4];
      if (widthOfPane) tmpDiv.style.width = widthOfPane;
      const outerContentDiv = document.createElement("DIV");
      const contentDiv = tmpDiv.getElementsByTagName("DIV")[0];
      contentDiv.className = "DHTMLSuite_infoPaneContent";
      contentDiv.id = "infoPaneContent" + no;
      outerContentDiv.appendChild(contentDiv);
      this.cookieNames[this.cookieNames.length] = nameOfCookie;
      outerContentDiv.id = "paneContent" + no;
      outerContentDiv.className = "DHTMLSuite_panelContent";
      outerContentDiv.style.backgroundImage =
        "url('" +
        DHTMLSuite.configObj.imagePath +
        "info-pane/xp-info-pane-bg_pane_right.gif" +
        "')";
      const topBar = document.createElement("DIV");
      topBar.onselectstart = function () {
        return false;
      };
      topBar.className = "DHTMLSuite_infoPane_topBar";
      topBar.style.position = "relative";
      DHTMLSuite.commonObj.__addEventEl(topBar);
      const span = document.createElement("SPAN");
      span.innerHTML = panelTitle;
      topBar.appendChild(span);
      topBar.style.backgroundImage =
        "url('" +
        DHTMLSuite.configObj.imagePath +
        "info-pane/xp-info-pane-bg_panel_top_right.gif" +
        "')";
      window.refToXpPane = this;
      topBar.onclick = function () {
        window.refToXpPane.__showHidePaneContent(this);
      };
      if (document.all) {
        topBar.ondblclick = function () {
          window.refToXpPane.__showHidePaneContent(this);
        };
      }
      topBar.onmouseover = this.__mouseoverTopbar;
      topBar.onmouseout = this.__mouseoutTopbar;
      topBar.style.position = "relative";
      const btnDiv = document.createElement("DIV");
      btnDiv.className = "DHTMLSuite_infoPane_topBar_button";
      topBar.appendChild(btnDiv);
      if (nameOfCookie) {
        cookieValue = DHTMLSuite.commonObj.getCookie(nameOfCookie);
        if (cookieValue) panelDisplayed = cookieValue == 1;
      }
      if (!panelDisplayed) {
        outerContentDiv.style.height = "0px";
        contentDiv.style.top = 0 - contentDiv.offsetHeight + "px";
        if (document.all) outerContentDiv.style.display = "none";
        btnDiv.className =
          btnDiv.className + " DHTMLSuite_infoPane_topBar_buttonDown";
      }
      topBar.className = "DHTMLSuite_infoPaneTopBar";
      topBar.id = "infoPane_topBar" + no;
      tmpDiv.appendChild(topBar);
      tmpDiv.appendChild(outerContentDiv);
    }
  },
  __resizeAndRepositionPane: function (idOfPane) {
    const obj = document.getElementById(idOfPane);
    const subDivs = obj.getElementsByTagName("DIV");
    for (let no = 0; no < subDivs.length; no++) {
      if (subDivs[no].className == "DHTMLSuite_panelContent") {
        subDivs[no].style.overflow = "auto";
        subDivs[no].style.height = "";
        const contentDiv = subDivs[no].getElementsByTagName("DIV")[0];
        let tmpHeight = subDivs[no].clientHeight;
        tmpHeight = subDivs[no].offsetHeight;
        subDivs[no].style.height = tmpHeight + "px";
        if (tmpHeight) this.paneHeights[subDivs[no].id] = tmpHeight;
        subDivs[no].style.top = "0px";
        subDivs[no].style.overflow = "hidden";
        const subSub = subDivs[no].getElementsByTagName("DIV")[0];
        subSub.style.top = "0px";
      }
    }
  },
  __showHidePaneContent: function (inputObj, methodWhenFinished) {
    const div = inputObj.getElementsByTagName("div")[0];
    const numericId = inputObj.id.replace(/[^0-9]/g, "");
    const obj = document.getElementById("paneContent" + numericId);
    if (div.className.indexOf("DHTMLSuite_infoPane_topBar_buttonDown") == -1) {
      this.currentlyExpandedPane = false;
      div.className = div.className + " DHTMLSuite_infoPane_topBar_buttonDown";
      if (this.xpPanel_slideActive) {
        obj.style.display = "block";
        this.xpPanel_currentDirection[obj.id] = this.xpPanel_slideSpeed * -1;
        this.__slidePane(
          this.xpPanel_slideSpeed * -1,
          obj.id,
          methodWhenFinished
        );
      } else {
        obj.style.display = "none";
      }
      if (this.cookieNames[numericId]) {
        DHTMLSuite.commonObj.setCookie(
          this.cookieNames[numericId],
          "0",
          100000
        );
      }
    } else {
      if (inputObj) {
        if (this.currentlyExpandedPane && this.xpPanel_onlyOneExpandedPane) {
          this.__showHidePaneContent(this.currentlyExpandedPane);
        }
        this.currentlyExpandedPane = inputObj;
      }
      div.className = div.className.replace(
        " DHTMLSuite_infoPane_topBar_buttonDown",
        ""
      );
      if (this.xpPanel_slideActive) {
        if (document.all) {
          obj.style.display = "block";
        }
        this.xpPanel_currentDirection[obj.id] = this.xpPanel_slideSpeed;
        this.__slidePane(this.xpPanel_slideSpeed, obj.id, methodWhenFinished);
      } else {
        obj.style.display = "block";
        subDiv = obj.getElementsByTagName("DIV")[0];
        obj.style.height = subDiv.offsetHeight + "px";
      }
      if (this.cookieNames[numericId]) {
        DHTMLSuite.commonObj.setCookie(
          this.cookieNames[numericId],
          "1",
          100000
        );
      }
    }
    return true;
  },
  __slidePane: function (slideValue, id, methodWhenFinished) {
    if (slideValue != this.xpPanel_currentDirection[id]) {
      return false;
    }
    const activePane = document.getElementById(id);
    if (activePane == this.savedActivePane) {
      var subDiv = this.savedActiveSub;
    } else {
      var subDiv = activePane.getElementsByTagName("DIV")[0];
    }
    this.savedActivePane = activePane;
    this.savedActiveSub = subDiv;
    let height = activePane.offsetHeight;
    let innerHeight = subDiv.offsetHeight;
    if (this.paneHeights[activePane.id]) {
      innerHeight = this.paneHeights[activePane.id];
    }
    height += slideValue;
    if (height < 0) height = 0;
    if (height > innerHeight) height = innerHeight;
    if (document.all) {
      activePane.style.filter =
        "alpha(opacity=" + Math.round((height / innerHeight) * 100) + ")";
    } else {
      let opacity = height / innerHeight;
      if (opacity == 0) opacity = 0.01;
      if (opacity == 1) opacity = 0.99;
      activePane.style.opacity = opacity;
    }
    window.refToThisInfoPane = this;
    if (slideValue < 0) {
      activePane.style.height = height + "px";
      subDiv.style.top = height - innerHeight + "px";
      if (height > 0) {
        setTimeout(
          "window.refToThisInfoPane.__slidePane(" +
            slideValue +
            ',"' +
            id +
            '","' +
            methodWhenFinished +
            '")',
          10
        );
      } else {
        if (document.all) activePane.style.display = "none";
        if (methodWhenFinished) eval(methodWhenFinished);
      }
    } else {
      subDiv.style.top = height - innerHeight + "px";
      activePane.style.height = height + "px";
      if (height < innerHeight) {
        setTimeout(
          "window.refToThisInfoPane.__slidePane(" +
            slideValue +
            ',"' +
            id +
            '","' +
            methodWhenFinished +
            '")',
          10
        );
      } else {
        if (methodWhenFinished) eval(methodWhenFinished);
      }
    }
  },
  __mouseoverTopbar: function () {
    const div = this.getElementsByTagName("DIV")[0];
    div.className = div.className + " DHTMLSuite_infoPaneButton_over";
    const span = this.getElementsByTagName("SPAN")[0];
    span.className = "DHTMLSuite_infoPanelOver";
  },
  __mouseoutTopbar: function () {
    const div = this.getElementsByTagName("DIV")[0];
    div.className = div.className.replace(
      " DHTMLSuite_infoPaneButton_over",
      ""
    );
    const span = this.getElementsByTagName("SPAN")[0];
    span.className = "";
  },
};
DHTMLSuite.progressBar = function () {
  let progressBar_steps;
  let div_progressPane;
  let div_progressBar_bg;
  let div_progressBar_outer;
  let div_progressBar_txt;
  let progressBarWidth;
  let currentStep;
  let layoutCSS;
  this.progressBar_steps = 50;
  this.progressPane = false;
  this.progressBar_bg = false;
  this.progressBar_outer = false;
  this.progressBar_txt = false;

  this.currentStep = 0;
  this.layoutCSS = "progress-bar.css";
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
};
DHTMLSuite.progressBar.prototype = {
  setSteps: function (numberOfSteps) {
    this.progressBar_steps = numberOfSteps;
  },
  init: function () {
    document.body.style.width = "100%";
    document.body.style.height = "100%";
    document.documentElement.style.overflow = "hidden";
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    this.__createDivElementsForTheProgressBar();
  },
  moveProgressBar: function (steps) {
    this.progressBarWidth = this.div_progressBar_bg.clientWidth;
    if (!steps) {
      this.div_progressBar_outer.style.width = progressBarWidth + "px";
      this.div_progressBar_txt.innerHTML = "100%";
      this.__hideProgressBar();
    } else {
      this.currentStep += steps;
      if (this.currentStep > this.progressBar_steps) {
        this.currentStep = this.progressBar_steps;
      }
      const width = Math.ceil(
        this.progressBarWidth * (this.currentStep / this.progressBar_steps)
      );
      this.div_progressBar_outer.style.width = width + "px";
      const percent = Math.ceil(
        (this.currentStep / this.progressBar_steps) * 100
      );
      this.div_progressBar_txt.innerHTML = percent + "%";
      if (this.currentStep == this.progressBar_steps) {
        this.__hideProgressBar();
      }
    }
  },
  __hideProgressBar: function () {
    document.body.style.width = null;
    document.body.style.height = null;
    document.documentElement.style.overflow = "";
    setTimeout(
      'document.getElementById("DHTMLSuite_progressPane").style.display="none"',
      50
    );
  },
  __createDivElementsForTheProgressBar: function () {
    this.div_progressPane = document.createElement("DIV");
    this.div_progressPane.id = "DHTMLSuite_progressPane";
    document.body.appendChild(this.div_progressPane);
    this.div_progressBar_bg = document.createElement("DIV");
    this.div_progressBar_bg.id = "DHTMLSuite_progressBar_bg";
    this.div_progressPane.appendChild(this.div_progressBar_bg);
    this.div_progressBar_outer = document.createElement("DIV");
    this.div_progressBar_outer.id = "DHTMLSuite_progressBar_outer";
    this.div_progressBar_bg.appendChild(this.div_progressBar_outer);
    const div = document.createElement("DIV");
    div.id = "DHTMLSuite_progressBar";
    this.div_progressBar_outer.appendChild(div);
    this.div_progressBar_txt = document.createElement("DIV");
    this.div_progressBar_txt.id = "DHTMLSuite_progressBar_txt";
    this.div_progressBar_txt.innerHTML = "0 %";
    this.div_progressBar_bg.appendChild(this.div_progressBar_txt);
  },
};
DHTMLSuite.menuModelItem = function () {
  let id;
  let itemText;
  let itemIcon;
  let url;
  let parentId;
  let separator;
  let jsFunction;
  let depth;
  let hasSubs;
  let type;
  let helpText;
  let state;
  let submenuWidth;
  let visible;
  this.state = "regular";
};
DHTMLSuite.menuModelItem.prototype = {
  setMenuVars: function (
    id,
    itemText,
    itemIcon,
    url,
    parentId,
    helpText,
    jsFunction,
    type,
    submenuWidth
  ) {
    this.id = id;
    this.itemText = itemText;
    this.itemIcon = itemIcon;
    this.url = url;
    this.parentId = parentId;
    this.jsFunction = jsFunction;
    this.separator = false;
    this.depth = false;
    this.hasSubs = false;
    this.helpText = helpText;
    this.submenuWidth = submenuWidth;
    this.visible = true;
    if (!type) {
      if (this.parentId) this.type = "top";
      else this.type = "sub";
    } else this.type = type;
  },
  setAsSeparator: function (id, parentId) {
    this.id = id;
    this.parentId = parentId;
    this.separator = true;
    this.visible = true;
    if (this.parentId) this.type = "top";
    else this.type = "sub";
  },
  setVisibility: function (visible) {
    this.visible = visible;
  },
  getState: function () {
    return this.state;
  },
  setState: function (newState) {
    this.state = newState;
  },
  setSubMenuWidth: function (newWidth) {
    this.submenuWidth = newWidth;
  },
  setIcon: function (iconPath) {
    this.itemIcon = iconPath;
  },
  setText: function (newText) {
    this.itemText = newText;
  },
};
DHTMLSuite.menuModel = function () {
  let menuItems;
  let menuItemsOrder;
  let submenuType;
  let mainMenuGroupWidth;
  this.menuItems = new Object();
  this.menuItemsOrder = new Array();
  this.submenuType = new Array();
  this.submenuType[1] = "top";
  for (let no = 2; no < 20; no++) {
    this.submenuType[no] = "sub";
  }
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
};
DHTMLSuite.menuModel.prototype = {
  addItem: function (
    id,
    itemText,
    itemIcon,
    url,
    parentId,
    helpText,
    jsFunction,
    type,
    submenuWidth
  ) {
    if (!id) id = this.__getUniqueId();
    try {
      this.menuItems[id] = new DHTMLSuite.menuModelItem();
    } catch (e) {
      alert("Error: Include dhtmlSuite-menuModel.js in your html file");
    }
    this.menuItems[id].setMenuVars(
      id,
      itemText,
      itemIcon,
      url,
      parentId,
      helpText,
      jsFunction,
      type,
      submenuWidth
    );
    this.menuItemsOrder[this.menuItemsOrder.length] = id;
    return this.menuItems[id];
  },
  addItemsFromMarkup: function (ulId) {
    if (!document.getElementById(ulId)) {
      alert("<UL> tag with id " + ulId + " does not exist");
      return;
    }
    const ulObj = document.getElementById(ulId);
    const liTags = ulObj.getElementsByTagName("LI");
    for (var no = 0; no < liTags.length; no++) {
      var id = liTags[no].id.replace(/[^0-9]/gi, "");
      if (!id || this.menuItems[id]) id = this.__getUniqueId();
      try {
        this.menuItems[id] = new DHTMLSuite.menuModelItem();
      } catch (e) {
        alert("Error: Include dhtmlSuite-menuModel.js in your html file");
      }
      this.menuItemsOrder[this.menuItemsOrder.length] = id;
      let parentId = 0;
      if (liTags[no].parentNode != ulObj) {
        parentId = liTags[no].parentNode.parentNode.id;
      }
      let type = liTags[no].getAttribute("itemType");
      if (!type) type = liTags[no].itemType;
      if (type == "separator") {
        this.menuItems[id].setAsSeparator(id, parentId);
        continue;
      }
      type = parentId ? "sub" : "top";
      const aTag = liTags[no].getElementsByTagName("A")[0];
      if (!aTag) {
        continue;
      }
      if (aTag) var itemText = aTag.innerHTML;
      const itemIcon = liTags[no].getAttribute("itemIcon");
      let url = aTag.href;
      if (url == "#" || url.substr(url.length - 1, 1) == "#") url = "";
      const jsFunction = liTags[no].getAttribute("jsFunction");
      const submenuWidth = false;
      let helpText = aTag.getAttribute("title");
      if (!helpText) helpText = aTag.title;
      this.menuItems[id].setMenuVars(
        id,
        itemText,
        itemIcon,
        url,
        parentId,
        helpText,
        jsFunction,
        type,
        submenuWidth
      );
    }
    const subUls = ulObj.getElementsByTagName("UL");
    for (var no = 0; no < subUls.length; no++) {
      let width = subUls[no].getAttribute("width");
      if (!width) width = subUls[no].width;
      if (width) {
        var id = subUls[no].parentNode.id.replace(/[^0-9]/gi, "");
        this.setSubMenuWidth(id, width);
      }
    }
    ulObj.style.display = "none";
  },
  setSubMenuWidth: function (id, newWidth) {
    this.menuItems[id].setSubMenuWidth(newWidth);
  },
  setMainMenuGroupWidth: function (newWidth) {
    this.mainMenuGroupWidth = newWidth;
  },
  addSeparator: function (parentId) {
    id = this.__getUniqueId();
    if (!parentId) parentId = 0;
    try {
      this.menuItems[id] = new DHTMLSuite.menuModelItem();
    } catch (e) {
      alert("Error: Include dhtmlSuite-menuModel.js in your html file");
    }
    this.menuItems[id].setAsSeparator(id, parentId);
    this.menuItemsOrder[this.menuItemsOrder.length] = id;
    return this.menuItems[id];
  },
  init: function () {
    this.__getDepths();
    this.__setHasSubs();
  },
  setMenuItemVisibility: function (id, visible) {
    this.menuItems[id].setVisibility(visible);
  },
  setSubMenuType: function (depth, newType) {
    this.submenuType[depth] = newType;
    this.__getDepths();
  },
  getItems: function (parentId, returnArray) {
    if (!parentId) return this.menuItems;
    if (!returnArray) returnArray = new Array();
    for (let no = 0; no < this.menuItemsOrder.length; no++) {
      const id = this.menuItemsOrder[no];
      if (!id) continue;
      if (this.menuItems[id].parentId == parentId) {
        returnArray[returnArray.length] = this.menuItems[id];
        if (this.menuItems[id].hasSubs) {
          return this.getItems(this.menuItems[id].id, returnArray);
        }
      }
    }
    return returnArray;
  },
  __getUniqueId: function () {
    let num = String(Math.random());
    num = num.replace(".", "");
    num = "99" + num;
    num = num / 1;
    while (this.menuItems[num]) {
      num = String(Math.random());
      num = num.replace(".", "");
      num = num / 1;
    }
    return num;
  },
  __getDepths: function () {
    for (let no = 0; no < this.menuItemsOrder.length; no++) {
      const id = this.menuItemsOrder[no];
      if (!id) continue;
      this.menuItems[id].depth = 1;
      if (this.menuItems[id].parentId) {
        this.menuItems[id].depth =
          this.menuItems[this.menuItems[id].parentId].depth + 1;
      }
      this.menuItems[id].type = this.submenuType[this.menuItems[id].depth];
    }
  },
  __setHasSubs: function () {
    for (let no = 0; no < this.menuItemsOrder.length; no++) {
      const id = this.menuItemsOrder[no];
      if (!id) continue;
      if (this.menuItems[id].parentId) {
        this.menuItems[this.menuItems[id].parentId].hasSubs = 1;
      }
    }
  },
  __hasSubs: function (id) {
    for (let no = 0; no < this.menuItemsOrder.length; no++) {
      var id = this.menuItemsOrder[no];
      if (!id) continue;
      if (this.menuItems[id].parentId == id) return true;
    }
    return false;
  },
  __deleteChildNodes: function (parentId, recursive) {
    const itemsToDeleteFromOrderArray = new Array();
    for (var prop = 0; prop < this.menuItemsOrder.length; prop++) {
      const id = this.menuItemsOrder[prop];
      if (!id) continue;
      if (this.menuItems[id].parentId == parentId && parentId) {
        this.menuItems[id] = false;
        itemsToDeleteFromOrderArray[itemsToDeleteFromOrderArray.length] = id;
        this.__deleteChildNodes(id, true);
      }
    }
    if (!recursive) {
      for (var prop = 0; prop < itemsToDeleteFromOrderArray.length; prop++) {
        if (!itemsToDeleteFromOrderArray[prop]) continue;
        this.__deleteItemFromItemOrderArray(itemsToDeleteFromOrderArray[prop]);
      }
    }
    this.__setHasSubs();
  },
  __deleteANode: function (id) {
    this.menuItems[id] = false;
    this.__deleteItemFromItemOrderArray(id);
  },
  __deleteItemFromItemOrderArray: function (id) {
    for (let no = 0; no < this.menuItemsOrder.length; no++) {
      const tmpId = this.menuItemsOrder[no];
      if (!tmpId) continue;
      if (this.menuItemsOrder[no] == id) {
        this.menuItemsOrder.splice(no, 1);
        return;
      }
    }
  },
  __appendMenuModel: function (newModel, parentId) {
    if (!newModel) return;
    const items = newModel.getItems();
    for (let no = 0; no < newModel.menuItemsOrder.length; no++) {
      const id = newModel.menuItemsOrder[no];
      if (!id) continue;
      if (!items[id].parentId) items[id].parentId = parentId;
      this.menuItems[id] = items[id];
      for (let no2 = 0; no2 < this.menuItemsOrder.length; no2++) {
        if (!this.menuItemsOrder[no2]) continue;
        if (this.menuItemsOrder[no2] == items[id].id) {
          this.menuItemsOrder.splice(no2, 1);
        }
      }
      this.menuItemsOrder[this.menuItemsOrder.length] = items[id].id;
    }
    this.__getDepths();
    this.__setHasSubs();
  },
};
DHTMLSuite.menuItem = function () {
  let layoutCSS;
  let divElement;
  let expandElement;
  let cssPrefix;
  let modelItemRef;
  this.layoutCSS = "menu-item.css";
  this.cssPrefix = "DHTMLSuite_";
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  let objectIndex;
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
};
DHTMLSuite.menuItem.prototype = {
  createItem: function (menuModelItemObj) {
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
    this.modelItemRef = menuModelItemObj;
    this.divElement = "DHTMLSuite_menuItem" + menuModelItemObj.id;
    const div = document.createElement("DIV");
    document.body.appendChild(div);
    div.id = this.divElement;
    div.className =
      this.cssPrefix + "menuItem_" + menuModelItemObj.type + "_regular";
    div.onselectstart = function () {
      return false;
    };
    if (menuModelItemObj.helpText) {
      div.title = menuModelItemObj.helpText;
    }
    if (menuModelItemObj.type == "top") {
      this.__createMenuElementsOfTypeTop(div);
    }
    if (menuModelItemObj.type == "sub") {
      this.__createMenuElementsOfTypeSub(div);
    }
    if (menuModelItemObj.separator) {
      div.className =
        this.cssPrefix + "menuItem_separator_" + menuModelItemObj.type;
      div.innerHTML = "<span></span>";
    } else {
      const tmpVar = this.objectIndex / 1;
      div.onclick = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[tmpVar].__navigate(e);
      };
      div.onmousedown = this.__clickMenuItem;
      div.onmouseup = this.__rolloverMenuItem;
      div.onmouseover = this.__rolloverMenuItem;
      div.onmouseout = this.__rolloutMenuItem;
    }
    DHTMLSuite.commonObj.__addEventEl(div);
    return div;
  },
  setLayoutCss: function (newLayoutCss) {
    this.layoutCSS = newLayoutCss;
  },
  __createMenuElementsOfTypeTop: function (parentEl) {
    if (this.modelItemRef.itemIcon) {
      const iconDiv = document.createElement("DIV");
      iconDiv.innerHTML = '<img src="' + this.modelItemRef.itemIcon + '">';
      iconDiv.id = "menuItemIcon" + this.modelItemRef.id;
      parentEl.appendChild(iconDiv);
    }
    if (this.modelItemRef.itemText) {
      var div = document.createElement("DIV");
      div.innerHTML = this.modelItemRef.itemText;
      div.className = this.cssPrefix + "menuItem_textContent";
      div.id = "menuItemText" + this.modelItemRef.id;
      parentEl.appendChild(div);
    }
    if (this.modelItemRef.hasSubs) {
      var div = document.createElement("DIV");
      div.className = this.cssPrefix + "menuItem_top_arrowShowSub";
      div.id = "DHTMLSuite_menuBar_arrow" + this.modelItemRef.id;
      parentEl.appendChild(div);
      this.expandElement = div.id;
    }
  },
  __createMenuElementsOfTypeSub: function (parentEl) {
    if (this.modelItemRef.itemIcon) {
      parentEl.style.backgroundImage =
        "url('" + this.modelItemRef.itemIcon + "')";
      parentEl.style.backgroundRepeat = "no-repeat";
      parentEl.style.backgroundPosition = "left center";
    }
    if (this.modelItemRef.itemText) {
      var div = document.createElement("DIV");
      div.className = "DHTMLSuite_textContent";
      div.innerHTML = this.modelItemRef.itemText;
      div.className = this.cssPrefix + "menuItem_textContent";
      div.id = "menuItemText" + this.modelItemRef.id;
      parentEl.appendChild(div);
    }
    if (this.modelItemRef.hasSubs) {
      var div = document.createElement("DIV");
      div.className = this.cssPrefix + "menuItem_sub_arrowShowSub";
      parentEl.appendChild(div);
      div.id = "DHTMLSuite_menuBar_arrow" + this.modelItemRef.id;
      this.expandElement = div.id;
      div.previousSibling.style.paddingRight = "15px";
    }
  },
  setCssPrefix: function (cssPrefix) {
    this.cssPrefix = cssPrefix;
  },
  setIcon: function (newPath) {
    this.modelItemRef.setIcon(newPath);
    if (this.modelItemRef.type == "top") {
      const div = document.getElementById(
        "menuItemIcon" + this.modelItemRef.id
      );
      let img = div.getElementsByTagName("IMG")[0];
      if (!img) {
        img = document.createElement("IMG");
        div.appendChild(img);
      }
      img.src = newPath;
      if (!newPath) DHTMLSuite.discardElement(img);
    }
    if (this.modelItemRef.type == "sub") {
      document.getElementById(this.divElement).style.backgroundImage =
        "url('" + newPath + "')";
    }
  },
  setText: function (newText) {
    this.modelItemRef.setText(newText);
    document.getElementById("menuItemText" + this.modelItemRef.id).innerHTML =
      newText;
  },
  __clickMenuItem: function () {
    this.className = this.className.replace("_regular", "_click");
    this.className = this.className.replace("_over", "_click");
  },
  __rolloverMenuItem: function () {
    this.className = this.className.replace("_regular", "_over");
    this.className = this.className.replace("_click", "_over");
  },
  __rolloutMenuItem: function () {
    this.className = this.className.replace("_over", "_regular");
  },
  setState: function (newState) {
    document.getElementById(this.divElement).className =
      this.cssPrefix + "menuItem_" + this.modelItemRef.type + "_" + newState;
    this.modelItemRef.setState(newState);
  },
  getState: function () {
    let state = this.modelItemRef.getState();
    if (!state) {
      if (
        document.getElementById(this.divElement).className.indexOf("_over") >= 0
      ) {
        state = "over";
      }
      if (
        document.getElementById(this.divElement).className.indexOf("_click") >=
        0
      ) {
        state = "click";
      }
      this.modelItemRef.setState(state);
    }
    return state;
  },
  __setHasSub: function (hasSubs) {
    this.modelItemRef.hasSubs = hasSubs;
    if (!hasSubs) {
      document.getElementById(
        this.cssPrefix + "menuBar_arrow" + this.modelItemRef.id
      ).style.display = "none";
    } else {
      document.getElementById(
        this.cssPrefix + "menuBar_arrow" + this.modelItemRef.id
      ).style.display = "block";
    }
  },
  hide: function () {
    this.modelItemRef.setVisibility(false);
    document.getElementById(this.divElement).style.display = "none";
  },
  show: function () {
    this.modelItemRef.setVisibility(true);
    document.getElementById(this.divElement).style.display = "block";
  },
  __hideGroup: function () {
    if (this.modelItemRef.parentId) {
      document.getElementById(this.divElement).parentNode.style.visibility =
        "hidden";
      if (DHTMLSuite.clientInfoObj.isMSIE) {
        try {
          const tmpId = document
            .getElementById(this.divElement)
            .parentNode.id.replace(/[^0-9]/gi, "");
          document.getElementById(
            "DHTMLSuite_menuBarIframe_" + tmpId
          ).style.visibility = "hidden";
        } catch (e) {}
      }
    }
  },
  __navigate: function (e) {
    if (document.all) e = event;
    if (e) {
      const srcEl = DHTMLSuite.commonObj.getSrcElement(e);
      if (srcEl.id.indexOf("arrow") >= 0) return;
    }
    if (this.modelItemRef.state == "disabled") return;
    if (this.modelItemRef.url) {
      location.href = this.modelItemRef.url;
    }
    if (this.modelItemRef.jsFunction) {
      try {
        eval(this.modelItemRef.jsFunction);
      } catch (e) {
        alert(
          "Defined Javascript code for the menu item(" +
            this.modelItemRef.jsFunction +
            ")cannot be executed"
        );
      }
    }
  },
};
DHTMLSuite.menuBar = function () {
  let menuItemObj;
  let layoutCSS;
  let menuBarBackgroundImage;
  let menuItem_objects;
  let menuBarObj;
  let menuBarHeight;
  let menuItems;
  let highlightedItems;
  let menuBarState;
  let activeSubItemsOnMouseOver;
  let submenuGroups;
  let submenuIframes;
  let createIframesForOldIeBrowsers;
  let targetId;
  let menuItemCssPrefix;
  let cssPrefix;
  let menuItemLayoutCss;
  let objectIndex;
  this.cssPrefix = "DHTMLSuite_";
  this.menuItemLayoutCss = false;
  this.layoutCSS = "menu-bar.css";
  this.menuBarBackgroundImage = "menu_strip_bg.jpg";
  this.menuItem_objects = new Object();
  DHTMLSuite.variableStorage.menuBar_highlightedItems = new Array();
  this.menuBarState = false;
  this.menuBarObj = false;
  this.menuBarHeight = 26;
  this.submenuGroups = new Array();
  this.submenuIframes = new Array();
  this.targetId = false;
  this.activeSubItemsOnMouseOver = false;
  this.menuItemCssPrefix = false;
  this.createIframesForOldIeBrowsers = true;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.menuBar.prototype = {
  init: function () {
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    this.__createMainMenuDiv();
    this.__createMenuItems();
    this.__setBasicEvents();
    window.refToThismenuBar = this;
  },
  setTarget: function (idOfHTMLElement) {
    this.targetId = idOfHTMLElement;
  },
  setLayoutCss: function (nameOfNewCssFile) {
    this.layoutCSS = nameOfNewCssFile;
  },
  setMenuItemLayoutCss: function (nameOfNewCssFile) {
    this.menuItemLayoutCss = nameOfNewCssFile;
  },
  setCreateIframesForOldIeBrowsers: function (createIframesForOldIeBrowsers) {
    this.createIframesForOldIeBrowsers = createIframesForOldIeBrowsers;
  },
  addMenuItems: function (menuItemObj) {
    this.menuItemObj = menuItemObj;
    this.menuItems = menuItemObj.getItems();
  },
  setActiveSubItemsOnMouseOver: function (activateSubOnMouseOver) {
    this.activeSubItemsOnMouseOver = activateSubOnMouseOver;
  },
  setMenuItemState: function (menuItemId, state) {
    try {
      this.menuItem_objects[menuItemId].setState(state);
    } catch (e) {
      alert(
        "menu item with id " +
          menuItemId +
          " does not exists or you have called the setMenuItemState method before the menu has been initialized"
      );
    }
  },
  setMenuItemCssPrefix: function (newCssPrefix) {
    this.menuItemCssPrefix = newCssPrefix;
  },
  setCssPrefix: function (newCssPrefix) {
    this.cssPrefix = newCssPrefix;
  },
  deleteAllMenuItems: function () {
    this.hideSubMenus();
    this.__deleteMenuItems(0, false);
    this.__clearAllMenuItems();
  },
  replaceMenuItems: function (idOfParentMenuItem, newMenuModel) {
    this.hideSubMenus();
    this.__deleteMenuItems(idOfParentMenuItem);
    this.menuItemObj.__appendMenuModel(newMenuModel, idOfParentMenuItem);
    this.__clearAllMenuItems();
    this.__createMenuItems();
  },
  deleteMenuItems: function (idOfParentMenuItem, deleteParentElement) {
    this.__deleteMenuItems(idOfParentMenuItem, deleteParentElement);
    this.__clearAllMenuItems();
    this.__createMenuItems();
  },
  appendMenuItems: function (idOfParentMenuItem, newMenuModel) {
    this.hideSubMenus();
    this.menuItemObj.__appendMenuModel(newMenuModel, idOfParentMenuItem);
    this.__clearAllMenuItems();
    this.__createMenuItems();
  },
  hideMenuItem: function (menuItemId) {
    this.menuItem_objects[menuItemId].hide();
  },
  showMenuItem: function (menuItemId) {
    this.menuItem_objects[menuItemId].show();
  },
  setText: function (menuItemId, newText) {
    this.menuItem_objects[menuItemId].setText(newText);
  },
  setIcon: function (menuItemId, newPath) {
    this.menuItem_objects[menuItemId].setIcon(newPath);
  },
  __clearAllMenuItems: function () {
    for (let prop = 0; prop < this.menuItemObj.menuItemsOrder.length; prop++) {
      const id = this.menuItemObj.menuItemsOrder[prop];
      if (!id) continue;
      if (this.submenuGroups[id]) {
        const div = document.getElementById(this.submenuGroups[id]);
        DHTMLSuite.discardElement(div);
        this.submenuGroups[id] = null;
      }
      if (this.submenuIframes[id]) {
        const ref = document.getElementById(this.submenuIframes[id]);
        DHTMLSuite.discardElement(ref);
        this.submenuIframes[id] = null;
      }
    }
    this.submenuGroups = new Array();
    this.submenuIframes = new Array();
    this.menuBarObj.innerHTML = "";
  },
  __deleteMenuItems: function (idOfParentMenuItem, includeParent) {
    if (includeParent) this.menuItemObj.__deleteANode(idOfParentMenuItem);
    if (!this.submenuGroups[idOfParentMenuItem]) return;
    this.menuItem_objects[idOfParentMenuItem].__setHasSub(false);
    this.menuItemObj.__deleteChildNodes(idOfParentMenuItem);
    const groupBox = document.getElementById(
      this.submenuGroups[idOfParentMenuItem]
    );
    DHTMLSuite.discardElement(groupBox);
    if (this.submenuIframes[idOfParentMenuItem]) {
      DHTMLSuite.discardElement(this.submenuIframes[idOfParentMenuItem]);
    }
    this.submenuGroups.splice(idOfParentMenuItem, 1);
    this.submenuIframes.splice(idOfParentMenuItem, 1);
  },
  __changeMenuBarState: function () {
    const objectIndex = this.getAttribute("objectRef");
    const obj = DHTMLSuite.variableStorage.arrayDSObjects[objectIndex];
    const parentId = this.id.replace(/[^0-9]/gi, "");
    const state = obj.menuItem_objects[parentId].getState();
    if (state == "disabled") return;
    obj.menuBarState = !obj.menuBarState;
    if (!obj.menuBarState) obj.hideSubMenus();
    else {
      obj.hideSubMenus();
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          objectIndex +
          "].__expandGroup(" +
          parentId +
          ")",
        10
      );
    }
  },
  __createMainMenuDiv: function () {
    window.refTomenuBar = this;
    this.menuBarObj = document.createElement("DIV");
    this.menuBarObj.className =
      this.cssPrefix + "menuBar_" + this.menuItemObj.submenuType[1];
    if (!document.getElementById(this.targetId)) {
      alert("No target defined for the menu object");
      return;
    }
    const target = document.getElementById(this.targetId);
    target.appendChild(this.menuBarObj);
  },
  hideSubMenus: function (e) {
    if (this && this.tagName) {
      if (document.all) e = event;
      let srcEl = DHTMLSuite.commonObj.getSrcElement(e);
      if (srcEl.tagName.toLowerCase() == "img") srcEl = srcEl.parentNode;
      if (srcEl.className && srcEl.className.indexOf("arrow") >= 0) {
        return;
      }
    }
    for (
      let no = 0;
      no < DHTMLSuite.variableStorage.menuBar_highlightedItems.length;
      no++
    ) {
      if (
        DHTMLSuite.variableStorage.menuBar_highlightedItems[no].getState() !=
        "disabled"
      ) {
        DHTMLSuite.variableStorage.menuBar_highlightedItems[no].setState(
          "regular"
        );
      }
      DHTMLSuite.variableStorage.menuBar_highlightedItems[no].__hideGroup();
    }
    DHTMLSuite.variableStorage.menuBar_highlightedItems = new Array();
  },
  __hideSubMenusAfterSmallDelay: function () {
    const ind = this.objectIndex;
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" + ind + "].hideSubMenus()",
      15
    );
  },
  __expandGroup: function (idOfParentMenuItem) {
    const groupRef = document.getElementById(
      this.submenuGroups[idOfParentMenuItem]
    );
    var subDiv = groupRef.getElementsByTagName("DIV")[0];
    const numericId = subDiv.id.replace(/[^0-9]/g, "");
    groupRef.style.visibility = "visible";
    if (this.submenuIframes[idOfParentMenuItem]) {
      document.getElementById(
        this.submenuIframes[idOfParentMenuItem]
      ).style.visibility = "visible";
    }
    DHTMLSuite.variableStorage.menuBar_highlightedItems[
      DHTMLSuite.variableStorage.menuBar_highlightedItems.length
    ] = this.menuItem_objects[numericId];
    this.__positionSubMenu(idOfParentMenuItem);
    if (DHTMLSuite.clientInfoObj.isOpera) {
      var subDiv = groupRef.getElementsByTagName("DIV")[0];
      subDiv.className = subDiv.className.replace("_over", "_over");
    }
  },
  __activateMenuElements: function (e, firstIteration, parentMenuItemObject) {
    if (!parentMenuItemObject) {
      if (document.all) e = event;
      parentMenuItemObject = DHTMLSuite.commonObj.getSrcElement(e);
      if (!parentMenuItemObject.getAttribute("DHTMLSuite_menuItem")) {
        parentMenuItemObject = parentMenuItemObject.parentNode;
      }
      if (!parentMenuItemObject.getAttribute("DHTMLSuite_menuItem")) {
        parentMenuItemObject = parentMenuItemObject.parentNode;
      }
    }
    const numericId = parentMenuItemObject.id.replace(/[^0-9]/g, "");
    const state = this.menuItem_objects[numericId].getState();
    if (state == "disabled") return;
    this.menuItem_objects[numericId].setState("over");
    if (!this.menuBarState && !this.activeSubItemsOnMouseOver) return;
    if (
      firstIteration &&
      DHTMLSuite.variableStorage.menuBar_highlightedItems.length > 0
    ) {
      this.hideSubMenus();
    }
    let newState = "over";
    if (!firstIteration) newState = "active";
    this.menuItem_objects[numericId].setState(newState);
    if (this.submenuGroups[numericId]) {
      this.__expandGroup(numericId);
    }
    DHTMLSuite.variableStorage.menuBar_highlightedItems[
      DHTMLSuite.variableStorage.menuBar_highlightedItems.length
    ] = this.menuItem_objects[numericId];
    if (this.menuItems[numericId].parentId) {
      this.__activateMenuElements(
        false,
        false,
        document.getElementById(
          this.menuItem_objects[this.menuItems[numericId].parentId].divElement
        )
      );
    }
  },
  __createMenuItems: function () {
    const index = this.objectIndex;
    let firstChild = false;
    const firstChilds = document.getElementsByTagName("DIV");
    if (firstChilds.length > 0) firstChild = firstChilds[0];
    for (let no = 0; no < this.menuItemObj.menuItemsOrder.length; no++) {
      const indexThis = this.menuItemObj.menuItemsOrder[no];
      if (!this.menuItems[indexThis].id) continue;
      try {
        this.menuItem_objects[this.menuItems[indexThis].id] =
          new DHTMLSuite.menuItem();
      } catch (e) {
        alert("Error: Include dhtmlSuite-menuItem.js in your html file");
      }
      if (this.menuItemCssPrefix) {
        this.menuItem_objects[this.menuItems[indexThis].id].setCssPrefix(
          this.menuItemCssPrefix
        );
      }
      if (this.menuItemLayoutCss) {
        this.menuItem_objects[this.menuItems[indexThis].id].setLayoutCss(
          this.menuItemLayoutCss
        );
      }
      const ref = this.menuItem_objects[
        this.menuItems[indexThis].id
      ].createItem(this.menuItems[indexThis]);
      ref.setAttribute("DHTMLSuite_menuItem", 1);
      if (!this.menuItems[indexThis].separator) {
        ref.onmouseover = function (e) {
          DHTMLSuite.variableStorage.arrayDSObjects[
            index
          ].__activateMenuElements(e, true);
        };
      }
      if (
        !this.menuItems[indexThis].jsFunction &&
        !this.menuItems[indexThis].url
      ) {
        ref.setAttribute("objectRef", index);
        ref.onclick = this.__changeMenuBarState;
      }
      DHTMLSuite.commonObj.__addEventEl(ref);
      if (
        this.menuItem_objects[this.menuItems[indexThis].id].expandElement &&
        1 === 2
      ) {
        try {
          const expandRef = document.getElementById(
            this.menuItem_objects[this.menuItems[indexThis].id].expandElement
          );
          const parentId = String(
            DHTMLSuite.variableStorage.arrayDSObjects[index].menuItems[
              indexThis
            ].parentId
          );
          const tmpId = expandRef.id.replace(/[^0-9]/gi, "");
          expandRef.setAttribute("objectRef", index / 1);
          expandRef.objectRef = index / 1;
        } catch (e) {}
      }
      let target = this.menuBarObj;
      if (
        this.menuItems[indexThis].depth == 1 &&
        this.menuItemObj.submenuType[this.menuItems[indexThis].depth] !=
          "top" &&
        this.menuItemObj.mainMenuGroupWidth
      ) {
        let tmpWidth = String(this.menuItemObj.mainMenuGroupWidth);
        if (tmpWidth.indexOf("%") == -1) tmpWidth = tmpWidth + "px";
        target.style.width = tmpWidth;
      }
      if (this.menuItems[indexThis].depth == "1") {
        if (
          this.menuItemObj.submenuType[this.menuItems[indexThis].depth] == "top"
        ) {
          ref.style.styleFloat = "left";
          ref.style.cssText = "float:left";
        }
      } else {
        if (!this.menuItems[indexThis].depth) {
          alert(
            "Error in menu model(depth not defined for a menu item). Remember to call the init()method for the menuModel object."
          );
          return;
        }
        if (!this.submenuGroups[this.menuItems[indexThis].parentId]) {
          this.submenuGroups[this.menuItems[indexThis].parentId] =
            "DHTMLSuite_menuBarSubGroup" + this.menuItems[indexThis].parentId;
          const div = document.createElement("DIV");
          div.style.zIndex = 30000;
          div.style.position = "absolute";
          div.id = this.submenuGroups[this.menuItems[indexThis].parentId];
          div.style.visibility = "hidden";
          div.className =
            this.cssPrefix +
            "menuBar_" +
            this.menuItemObj.submenuType[this.menuItems[indexThis].depth];
          if (firstChild) {
            firstChild.parentNode.insertBefore(div, firstChild);
          } else {
            document.body.appendChild(div);
          }
          if (
            DHTMLSuite.clientInfoObj.isMSIE &&
            this.createIframesForOldIeBrowsers
          ) {
            this.submenuIframes[this.menuItems[indexThis].parentId] =
              "DHTMLSuite_menuBarIframe_" + this.menuItems[indexThis].parentId;
            const iframe = document.createElement(
              '<IFRAME src="about:blank" frameborder=0>'
            );
            iframe.id = this.submenuIframes[this.menuItems[indexThis].parentId];
            iframe.style.position = "absolute";
            iframe.style.zIndex = 9000;
            iframe.style.visibility = "hidden";
            if (firstChild) {
              firstChild.parentNode.insertBefore(iframe, firstChild);
            } else {
              document.body.appendChild(iframe);
            }
          }
        }
        target = document.getElementById(
          this.submenuGroups[this.menuItems[indexThis].parentId]
        );
      }
      target.appendChild(ref);
      if (this.menuItems[indexThis].visible == false) {
        this.hideMenuItem(this.menuItems[indexThis].id);
      }
      if (this.menuItems[indexThis].state != "regular") {
        this.menuItem_objects[this.menuItems[indexThis].id].setState(
          this.menuItems[indexThis].state
        );
      }
    }
    this.__setSizeOfAllSubMenus();
    this.__positionAllSubMenus();
    if (DHTMLSuite.clientInfoObj.isOpera) this.__fixMenuLayoutForOperaBrowser();
  },
  __fixMenuLayoutForOperaBrowser: function () {
    for (let no = 0; no < this.menuItemObj.menuItemsOrder.length; no++) {
      const id = this.menuItemObj.menuItemsOrder[no];
      if (!id) continue;
      document.getElementById(this.menuItem_objects[id].divElement).className =
        document
          .getElementById(this.menuItem_objects[id].divElement)
          .className.replace("_regular", "_regular");
    }
  },
  __setSizeOfAllSubMenus: function () {
    for (let no = 0; no < this.menuItemObj.menuItemsOrder.length; no++) {
      const prop = this.menuItemObj.menuItemsOrder[no];
      if (!prop) continue;
      this.__setSizeOfSubMenus(prop);
    }
  },
  __positionAllSubMenus: function () {
    for (let no = 0; no < this.menuItemObj.menuItemsOrder.length; no++) {
      const prop = this.menuItemObj.menuItemsOrder[no];
      if (!prop) continue;
      if (this.submenuGroups[prop]) this.__positionSubMenu(prop);
    }
  },
  __positionSubMenu: function (parentId) {
    try {
      const shortRef = document.getElementById(this.submenuGroups[parentId]);
      const depth = this.menuItems[parentId].depth;
      const dir = this.menuItemObj.submenuType[depth];
      const ref = document.getElementById(
        this.menuItem_objects[parentId].divElement
      );
      if (dir == "top") {
        shortRef.style.left = DHTMLSuite.commonObj.getLeftPos(ref) + "px";
        shortRef.style.top =
          DHTMLSuite.commonObj.getTopPos(ref) + ref.offsetHeight + "px";
      } else {
        shortRef.style.left =
          DHTMLSuite.commonObj.getLeftPos(ref) + ref.offsetWidth + "px";
        shortRef.style.top = DHTMLSuite.commonObj.getTopPos(ref) + "px";
      }
      if (DHTMLSuite.clientInfoObj.isMSIE) {
        const iframeRef = document.getElementById(
          this.submenuIframes[parentId]
        );
        iframeRef.style.left = shortRef.style.left;
        iframeRef.style.top = shortRef.style.top;
        iframeRef.style.width = shortRef.clientWidth + "px";
        iframeRef.style.height = shortRef.clientHeight + "px";
      }
    } catch (e) {}
  },
  __setSizeOfSubMenus: function (parentId) {
    try {
      const shortRef = document.getElementById(this.submenuGroups[parentId]);
      let subWidth = Math.max(
        shortRef.offsetWidth,
        document.getElementById(this.menuItem_objects[parentId].divElement)
          .offsetWidth
      );
      if (this.menuItems[parentId].submenuWidth) {
        subWidth = this.menuItems[parentId].submenuWidth;
      }
      if (subWidth > 400) subWidth = 150;
      subWidth = String(subWidth);
      if (subWidth.indexOf("%") == -1) subWidth = subWidth + "px";
      shortRef.style.width = subWidth;
      if (DHTMLSuite.clientInfoObj.isMSIE) {
        const ref = document.getElementById(this.submenuIframes[parentId]);
        ref.style.width = shortRef.style.width;
        ref.style.height = shortRef.style.height;
      }
    } catch (e) {}
  },
  __repositionMenu: function (inputObj) {
    inputObj.menuBarObj.style.top = document.documentElement.scrollTop + "px";
  },
  __menuItemRollOver: function (menuItemHTMLElementRef) {
    const numericId = menuItemHTMLElementRef.id.replace(/[^0-9]/g, "");
    menuItemHTMLElementRef.className =
      "DHTMLSuite_menuBar_menuItem_over_" + this.menuItems[numericId].depth;
  },
  __menuItemRollOut: function (menuItemHTMLElementRef) {
    const numericId = menuItemHTMLElementRef.id.replace(/[^0-9]/g, "");
    menuItemHTMLElementRef.className =
      "DHTMLSuite_menuBar_menuItem_" + this.menuItems[numericId].depth;
  },
  __menuNavigate: function (menuItemHTMLElementRef) {
    const numericIndex = menuItemHTMLElementRef.id.replace(/[^0-9]/g, "");
    const url = this.menuItems[numericIndex].url;
    if (!url) return;
  },
  __setBasicEvents: function () {
    const ind = this.objectIndex;
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "click",
      this.hideSubMenus
    );
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mouseup",
      this.hideSubMenus
    );
  },
};
DHTMLSuite.paneSplitterModel = function (arrayOfProperties) {
  let panes;
  let collapseButtonsInTitleBars;
  this.collapseButtonsInTitleBars = false;
  this.panes = new Array();
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.__setInitProps(arrayOfProperties);
};
DHTMLSuite.paneSplitterModel.prototype = {
  addPane: function (paneModelRef) {
    this.panes[this.panes.length] = paneModelRef;
  },
  getItems: function () {
    return this.panes;
  },
  __setInitProps: function (propArray) {
    if (!propArray) return;
    if (
      propArray.collapseButtonsInTitleBars ||
      propArray.collapseButtonsInTitleBars === false
    ) {
      this.collapseButtonsInTitleBars = propArray.collapseButtonsInTitleBars;
    }
  },
};
DHTMLSuite.paneSplitterPaneModel = function (inputArray) {
  let id;
  let position;
  let size;
  let minSize;
  let maxSize;
  let resizable;
  let visible;
  let scrollbars;
  let contents;
  let collapsable;
  let state;
  let callbackOnCollapse;
  let callbackOnHide;
  let callbackOnShow;
  let callbackOnExpand;
  let callbackOnSlideOut;
  let callbackOnSlideIn;
  let callbackOnCloseContent;
  let callbackOnBeforeCloseContent;
  let callbackOnTabSwitch;
  let callbackOnResize;
  this.contents = new Array();
  this.scrollbars = true;
  this.resizable = true;
  this.collapsable = true;
  this.state = "expanded";
  this.visible = true;
  if (inputArray) this.setData(inputArray);
};
DHTMLSuite.paneSplitterPaneModel.prototype = {
  setData: function (inputArray) {
    if (inputArray.collapsable) {
      inputArray.collapsable = eval(inputArray.collapsable);
    }
    if (inputArray.id) this.id = inputArray.id;
    if (inputArray.position) this.position = inputArray.position;
    if (inputArray.resizable === false || inputArray.resizable === true) {
      this.resizable = inputArray.resizable;
    }
    if (inputArray.size) this.size = inputArray.size;
    if (inputArray.minSize) this.minSize = inputArray.minSize;
    if (inputArray.maxSize) this.maxSize = inputArray.maxSize;
    if (inputArray.visible === false || inputArray.visible === true) {
      this.visible = inputArray.visible;
    }
    if (inputArray.collapsable === false || inputArray.collapsable === true) {
      this.collapsable = inputArray.collapsable;
    }
    if (inputArray.scrollbars === false || inputArray.scrollbars === true) {
      this.scrollbars = inputArray.scrollbars;
    }
    if (inputArray.state) this.state = inputArray.state;
    if (inputArray.callbackOnCollapse) {
      this.callbackOnCollapse = inputArray.callbackOnCollapse;
    }
    if (inputArray.callbackOnHide) {
      this.callbackOnHide = inputArray.callbackOnHide;
    }
    if (inputArray.callbackOnShow) {
      this.callbackOnShow = inputArray.callbackOnShow;
    }
    if (inputArray.callbackOnExpand) {
      this.callbackOnExpand = inputArray.callbackOnExpand;
    }
    if (inputArray.callbackOnSlideIn) {
      this.callbackOnSlideIn = inputArray.callbackOnSlideIn;
    }
    if (inputArray.callbackOnSlideOut) {
      this.callbackOnSlideOut = inputArray.callbackOnSlideOut;
    }
    if (inputArray.callbackOnCloseContent) {
      this.callbackOnCloseContent = inputArray.callbackOnCloseContent;
    }
    if (inputArray.callbackOnBeforeCloseContent) {
      this.callbackOnBeforeCloseContent =
        inputArray.callbackOnBeforeCloseContent;
    }
    if (inputArray.callbackOnTabSwitch) {
      this.callbackOnTabSwitch = inputArray.callbackOnTabSwitch;
    }
    if (inputArray.callbackOnResize) {
      this.callbackOnResize = inputArray.callbackOnResize;
    }
  },
  setSize: function (newSizeInPixels) {
    this.size = newSizeInPixels;
  },
  addContent: function (paneSplitterContentObj) {
    for (let no = 0; no < this.contents.length; no++) {
      if (this.contents[no].id == paneSplitterContentObj.id) return false;
    }
    this.contents[this.contents.length] = paneSplitterContentObj;
    return true;
  },
  getContents: function () {
    return this.contents;
  },
  getCountContent: function () {
    return this.contents.length;
  },
  getPosition: function () {
    return this.position.toLowerCase();
  },
  __setState: function (state) {
    this.state = state;
  },
  __getState: function (state) {
    return this.state;
  },
  __deleteContent: function (indexOfContentObjectToDelete) {
    try {
      this.contents.splice(indexOfContentObjectToDelete, 1);
    } catch (e) {}
    let retVal = indexOfContentObjectToDelete;
    if (this.contents.length > indexOfContentObjectToDelete - 1) retVal--;
    if (retVal < 0 && this.contents.length == 0) return false;
    if (retVal < 0) retVal = 0;
    return retVal;
  },
  __getIndexById: function (id) {
    for (let no = 0; no < this.contents.length; no++) {
      if (this.contents[no].id == id) return no;
    }
    return false;
  },
  __setVisible: function (visible) {
    this.visible = visible;
  },
};
DHTMLSuite.paneSplitterContentModel = function (inputArray) {
  let id;
  let htmlElementId;
  let title;
  let tabTitle;
  let closable;
  let contentUrl;
  this.closable = true;
  let refreshAfterSeconds;
  let displayRefreshButton;
  this.displayRefreshButton = false;
  this.refreshAfterSeconds = 0;
  if (inputArray) this.setData(inputArray);
};
DHTMLSuite.paneSplitterContentModel.prototype = {
  setData: function (inputArray) {
    if (inputArray.id) this.id = inputArray.id;
    else this.id = inputArray.htmlElementId;
    if (inputArray.closable === false || inputArray.closable === true) {
      this.closable = inputArray.closable;
    }
    if (
      inputArray.displayRefreshButton === false ||
      inputArray.displayRefreshButton
    ) {
      this.displayRefreshButton = inputArray.displayRefreshButton;
    }
    if (inputArray.title) this.title = inputArray.title;
    if (inputArray.tabTitle) this.tabTitle = inputArray.tabTitle;
    if (inputArray.contentUrl) this.contentUrl = inputArray.contentUrl;
    if (inputArray.htmlElementId) {
      this.htmlElementId = inputArray.htmlElementId;
    }
    if (inputArray.refreshAfterSeconds) {
      this.refreshAfterSeconds = inputArray.refreshAfterSeconds;
    }
  },
  __setTitle: function (newTitle) {
    this.title = newTitle;
  },
  __setTabTitle: function (newTabTitle) {
    this.tabTitle = newTabTitle;
  },
  __setIdOfContentElement: function (htmlElementId) {
    this.htmlElementId = htmlElementId;
  },
  __setRefreshAfterSeconds: function (refreshAfterSeconds) {
    this.refreshAfterSeconds = refreshAfterSeconds;
  },
  __setContentUrl: function (contentUrl) {
    this.contentUrl = contentUrl;
  },
  __getClosable: function () {
    return this.closable;
  },
};
DHTMLSuite.paneSplitterPane = function (parentRef) {
  let divElement;
  let divElCollapsed;
  let divElCollapsedInner;
  let contentDiv;
  let headerDiv;
  let titleSpan;
  let paneModel;
  let resizeDiv;
  let tabDiv;
  let divTransparentForResize;
  var parentRef;
  let divClose;
  let divCollapse;
  let divExpand;
  let divRefresh;
  let slideIsInProgress;
  let reloadIntervalHandlers;
  let contentScrollTopPositions;
  this.contents = new Array();
  this.reloadIntervalHandlers = new Object();
  this.contentScrollTopPositions = new Object();
  this.parentRef = parentRef;
  let activeContentIndex;
  this.activeContentIndex = false;
  this.slideIsInProgress = false;
  let objectIndex;
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.paneSplitterPane.prototype = {
  addDataSource: function (paneModelRef) {
    this.paneModel = paneModelRef;
  },
  addContent: function (paneContentModelObject, jsCodeToExecuteWhenComplete) {
    const retValue = this.paneModel.addContent(paneContentModelObject);
    if (!retValue) return false;
    this.__addOneContentDiv(
      paneContentModelObject,
      jsCodeToExecuteWhenComplete
    );
    this.__updateTabContent();
    this.__updateView();
    if (this.paneModel.getCountContent() == 1) {
      this.showContent(paneContentModelObject.id);
    }
    return retValue;
  },
  showContent: function (idOfContentObject) {
    for (let no = 0; no < this.paneModel.contents.length; no++) {
      if (this.paneModel.contents[no].id == idOfContentObject) {
        this.__updatePaneView(no);
        return;
      }
    }
  },
  loadContent: function (
    idOfContentObject,
    url,
    refreshAfterSeconds,
    internalCall,
    onCompleteJsCode
  ) {
    if (!url) return;
    for (let no = 0; no < this.paneModel.contents.length; no++) {
      if (this.paneModel.contents[no].id == idOfContentObject) {
        if (internalCall && !this.paneModel.contents[no].refreshAfterSeconds) {
          return;
        }
        const ajaxWaitMsg = this.parentRef.waitMessage;
        this.paneModel.contents[no].__setContentUrl(url);
        if (refreshAfterSeconds && !internalCall) {
          this.paneModel.contents[no].__setRefreshAfterSeconds(
            refreshAfterSeconds
          );
        }
        if (refreshAfterSeconds) {
          this.__handleContentReload(idOfContentObject, refreshAfterSeconds);
        }
        try {
          var dynContent = new DHTMLSuite.dynamicContent();
        } catch (e) {
          alert("Include dhtmlSuite-dynamicContent.js");
        }
        dynContent.setWaitMessage(ajaxWaitMsg);
        dynContent.loadContent(
          this.paneModel.contents[no].htmlElementId,
          url,
          onCompleteJsCode
        );
        dynContent = false;
        return;
      }
    }
  },
  isUrlLoadedInPane: function (idOfContentObject, url) {
    const contentIndex = this.paneModel.__getIndexById(idOfContentObject);
    if (contentIndex !== false) {
      if (this.paneModel.contents[contentIndex].contentUrl == url) return true;
    }
    return false;
  },
  reloadContent: function (idOfContentObject) {
    const contentIndex = this.paneModel.__getIndexById(idOfContentObject);
    if (contentIndex !== false) {
      this.loadContent(
        idOfContentObject,
        this.paneModel.contents[contentIndex].contentUrl
      );
    }
  },
  setRefreshAfterSeconds: function (idOfContentObject, refreshAfterSeconds) {
    for (let no = 0; no < this.paneModel.contents.length; no++) {
      if (this.paneModel.contents[no].id == idOfContentObject) {
        if (!this.paneModel.contents[no].refreshAfterSeconds) {
          this.loadContent(
            idOfContentObject,
            this.paneModel.contents[no].contentUrl,
            refreshAfterSeconds
          );
        }
        this.paneModel.contents[no].__setRefreshAfterSeconds(
          refreshAfterSeconds
        );
        this.__handleContentReload(idOfContentObject);
      }
    }
  },
  setContentTitle: function (idOfContent, newTitle) {
    const contentModelIndex = this.paneModel.__getIndexById(idOfContent);
    if (contentModelIndex !== false) {
      const contentModelObj = this.paneModel.contents[contentModelIndex];
      contentModelObj.__setTitle(newTitle);
      this.__updateHeaderBar(this.activeContentIndex);
    }
  },
  setContentTabTitle: function (idOfContent, newTitle) {
    const contentModelIndex = this.paneModel.__getIndexById(idOfContent);
    if (contentModelIndex !== false) {
      const contentModelObj = this.paneModel.contents[contentModelIndex];
      contentModelObj.__setTabTitle(newTitle);
      this.__updateTabContent();
    }
  },
  hidePane: function () {
    this.paneModel.__setVisible(false);
    this.expand();
    this.divElement.style.display = "none";
    this.__executeCallBack(
      "hide",
      this.paneModel.contents[this.activeContentIndex]
    );
  },
  showPane: function () {
    this.paneModel.__setVisible(true);
    this.divElement.style.display = "block";
    this.__executeCallBack(
      "show",
      this.paneModel.contents[this.activeContentIndex]
    );
  },
  collapse: function () {
    this.__collapse();
    if (!this.parentRef.dataModel.collapseButtonsInTitleBars) {
      this.parentRef.__toggleCollapseExpandButton(
        this.paneModel.getPosition(),
        "collapse"
      );
    }
  },
  expand: function () {
    this.__expand();
    if (!this.parentRef.dataModel.collapseButtonsInTitleBars) {
      this.parentRef.__toggleCollapseExpandButton(
        this.paneModel.getPosition(),
        "expand"
      );
    }
  },
  getIdOfCurrentlyDisplayedContent: function () {
    return this.paneModel.contents[this.activeContentIndex].id;
  },
  getHtmlElIdOfCurrentlyDisplayedContent: function () {
    return this.paneModel.contents[this.activeContentIndex].htmlElementId;
  },
  __getSizeOfPaneInPixels: function () {
    const retArray = new Object();
    retArray.width = this.divElement.offsetWidth;
    retArray.height = this.divElement.offsetHeight;
    return retArray;
  },
  __reloadDisplayedContent: function () {
    this.reloadContent(this.paneModel.contents[this.activeContentIndex].id);
  },
  __getReferenceTomainDivEl: function () {
    return this.divElement;
  },
  __executeResizeCallBack: function () {
    this.__executeCallBack("resize");
  },
  __executeCallBack: function (whichCallBackAction, contentObj) {
    let callbackString = false;
    switch (whichCallBackAction) {
      case "show":
        if (!this.paneModel.callbackOnShow) return;
        callbackString = this.paneModel.callbackOnShow;
        break;
      case "collapse":
        if (!this.paneModel.callbackOnCollapse) return;
        callbackString = this.paneModel.callbackOnCollapse;
        break;
      case "expand":
        if (!this.paneModel.callbackOnExpand) return;
        callbackString = this.paneModel.callbackOnExpand;
        break;
      case "hide":
        if (!this.paneModel.callbackOnHide) return;
        callbackString = this.paneModel.callbackOnHide;
        break;
      case "slideIn":
        if (!this.paneModel.callbackOnSlideIn) return;
        callbackString = this.paneModel.callbackOnSlideIn;
        break;
      case "slideOut":
        if (!this.paneModel.callbackOnSlideOut) return;
        callbackString = this.paneModel.callbackOnSlideOut;
        break;
      case "closeContent":
        if (!this.paneModel.callbackOnCloseContent) return;
        callbackString = this.paneModel.callbackOnCloseContent;
        break;
      case "beforeCloseContent":
        if (!this.paneModel.callbackOnBeforeCloseContent) return true;
        callbackString = this.paneModel.callbackOnBeforeCloseContent;
        break;
      case "tabSwitch":
        if (!this.paneModel.callbackOnTabSwitch) return;
        callbackString = this.paneModel.callbackOnTabSwitch;
        break;
      case "resize":
        if (!this.paneModel.callbackOnResize) return;
        callbackString = this.paneModel.callbackOnResize;
        break;
    }
    if (!callbackString) return;
    if (!contentObj) contentObj = false;
    callbackString = this.__getCallBackString(
      callbackString,
      whichCallBackAction,
      contentObj
    );
    return this.__executeCallBackString(callbackString, contentObj);
  },
  __getCallBackString: function (
    callbackString,
    whichCallBackAction,
    contentObj
  ) {
    if (callbackString.indexOf("(") >= 0) return callbackString;
    callbackString = contentObj
      ? callbackString +
        '(this.paneModel,"' +
        whichCallBackAction +
        '",contentObj)'
      : callbackString + '(this.paneModel,"' + whichCallBackAction + '")';
    callbackString = callbackString;
    return callbackString;
  },
  __executeCallBackString: function (callbackString, contentObj) {
    try {
      return eval(callbackString);
    } catch (e) {
      alert(
        "Could not execute specified call back function:\n" +
          callbackString +
          "\n\nError:\n" +
          e.name +
          "\n" +
          e.message +
          "\n" +
          "\nMake sure that there aren't any errors in your function.\nAlso remember that contentObj would not be present when you click close on the last tab\n(In case a close tab event triggered this callback function)"
      );
    }
  },
  __handleContentReload: function (id) {
    const ind = this.objectIndex;
    const contentIndex = this.paneModel.__getIndexById(id);
    if (contentIndex !== false) {
      const contentRef = this.paneModel.contents[contentIndex];
      if (contentRef.refreshAfterSeconds) {
        if (this.reloadIntervalHandlers[id]) {
          clearInterval(this.reloadIntervalHandlers[id]);
        }
        this.reloadIntervalHandlers[id] = setInterval(
          "DHTMLSuite.variableStorage.arrayDSObjects[" +
            ind +
            '].loadContent("' +
            id +
            '","' +
            contentRef.contentUrl +
            '",' +
            contentRef.refreshAfterSeconds +
            ",true)",
          contentRef.refreshAfterSeconds * 1000
        );
      } else {
        if (this.reloadIntervalHandlers[id]) {
          clearInterval(this.reloadIntervalHandlers[id]);
        }
      }
    }
  },
  __createPane: function () {
    this.divElement = document.createElement("DIV");
    this.divElement.style.position = "absolute";
    this.divElement.className = "DHTMLSuite_pane";
    this.divElement.id = "DHTMLSuite_pane_" + this.paneModel.getPosition();
    document.body.appendChild(this.divElement);
    this.__createHeaderBar();
    this.__createContentPane();
    this.__createTabBar();
    this.__createCollapsedPane();
    this.__createTransparentDivForResize();
    this.__updateView();
    this.__addContentDivs();
    this.__setSize();
  },
  __createTransparentDivForResize: function () {
    this.divTransparentForResize = document.createElement("DIV");
    const ref = this.divTransparentForResize;
    ref.style.opacity = "0";
    ref.style.display = "none";
    ref.style.filter = "alpha(opacity=0)";
    ref.style.position = "absolute";
    ref.style.left = "0px";
    ref.style.top = this.headerDiv.offsetHeight + "px";
    ref.style.height = "90%";
    ref.style.width = "100%";
    ref.style.backgroundColor = "#FFF";
    ref.style.zIndex = "1000";
    this.divElement.appendChild(ref);
  },
  __createCollapsedPane: function () {
    const ind = this.objectIndex;
    var pos = this.paneModel.getPosition();
    let buttonSuffix = "Vertical";
    if (pos == "west" || pos == "east") buttonSuffix = "Horizontal";
    if (pos == "center") buttonSuffix = "";
    this.divElCollapsed = document.createElement("DIV");
    const obj = this.divElCollapsed;
    obj.className = "DHTMLSuite_pane_collapsed_" + pos;
    obj.style.visibility = "hidden";
    obj.style.position = "absolute";
    this.divElCollapsedInner = document.createElement("DIV");
    this.divElCollapsedInner.className = "DHTMLSuite_pane_collapsedInner";
    this.divElCollapsedInner.onmouseover = this.__mouseoverHeaderButton;
    this.divElCollapsedInner.onmouseout = this.__mouseoutHeaderButton;
    this.divElCollapsedInner.onclick = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__slidePane(e);
    };
    DHTMLSuite.commonObj.__addEventEl(this.divElCollapsedInner);
    obj.appendChild(this.divElCollapsedInner);
    const buttonDiv = document.createElement("DIV");
    buttonDiv.className = "buttonDiv";
    this.divElCollapsedInner.appendChild(buttonDiv);
    document.body.appendChild(obj);
    if (this.parentRef.dataModel.collapseButtonsInTitleBars) {
      if (
        this.paneModel.getPosition() == "east" ||
        this.paneModel.getPosition() == "west"
      ) {
        this.divElCollapsedInner.style.width =
          this.parentRef.paneSizeCollapsed - 6 + "px";
        this.divElCollapsed.style.width =
          this.parentRef.paneSizeCollapsed + "px";
        if (this.paneModel.getPosition() == "east") {
          this.divElCollapsedInner.style.marginLeft = "3px";
        }
      } else {
        this.divElCollapsedInner.style.height =
          this.parentRef.paneSizeCollapsed - 6 + "px";
        this.divElCollapsed.style.height =
          this.parentRef.paneSizeCollapsed + "px";
        buttonDiv.style.cssText = "float:right;clear:both";
      }
      var pos = this.paneModel.getPosition();
      this.divExpand = document.createElement("DIV");
      if (pos == "south" || pos == "east") {
        this.divExpand.className = "collapseButton" + buttonSuffix;
      } else this.divExpand.className = "expandButton" + buttonSuffix;
      this.divExpand.onclick = function () {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__expand();
      };
      this.divExpand.onmouseover = this.__mouseoverHeaderButton;
      this.divExpand.onmouseout = this.__mouseoutHeaderButton;
      DHTMLSuite.commonObj.__addEventEl(this.divExpand);
      buttonDiv.appendChild(this.divExpand);
    }
  },
  __autoSlideInPane: function (e) {
    if (document.all) e = event;
    const state = this.paneModel.__getState();
    if (state == "collapsed" && this.divElement.style.visibility != "hidden") {
      if (!DHTMLSuite.commonObj.isObjectClicked(this.divElement, e)) {
        this.__slidePane(e, true);
      }
    }
  },
  __slidePane: function (e, forceSlide) {
    if (this.slideIsInProgress) return;
    this.parentRef.paneZIndexCounter++;
    if (document.all) e = event;
    let src = DHTMLSuite.commonObj.getSrcElement(e);
    if (src.className == "buttonDiv") src = src.parentNode;
    if (src.className.indexOf("collapsed") < 0 && !forceSlide) return;
    this.slideIsInProgress = true;
    const state = this.paneModel.__getState();
    let hideWhenComplete = true;
    if (this.divElement.style.visibility == "hidden") {
      this.__executeCallBack(
        "slideOut",
        this.paneModel.contents[this.activeContentIndex]
      );
      this.__setSlideInitPosition();
      this.divElement.style.visibility = "visible";
      this.divElement.style.zIndex = 16000 + this.parentRef.paneZIndexCounter;
      this.divElCollapsed.style.zIndex =
        16000 + this.parentRef.paneZIndexCounter;
      var slideTo = this.__getSlideToCoordinates(true);
      hideWhenComplete = false;
      var slideSpeed = this.__getSlideSpeed(true);
    } else {
      this.__executeCallBack(
        "slideIn",
        this.paneModel.contents[this.activeContentIndex]
      );
      var slideTo = this.__getSlideToCoordinates(false);
      var slideSpeed = this.__getSlideSpeed(false);
    }
    this.__processSlideByPixels(
      slideTo,
      slideSpeed * this.parentRef.slideSpeed,
      this.__getCurrentCoordinateInPixels(),
      hideWhenComplete
    );
  },
  __setSlideInitPosition: function () {
    const bw = DHTMLSuite.clientInfoObj.getBrowserWidth();
    const bh = DHTMLSuite.clientInfoObj.getBrowserHeight();
    const pos = this.paneModel.getPosition();
    switch (pos) {
      case "west":
        this.divElement.style.left = 0 - this.paneModel.size + "px";
        break;
      case "east":
        this.divElement.style.left = bw + "px";
        break;
      case "north":
        this.divElement.style.top = 0 - this.paneModel.size + "px";
        break;
      case "south":
        this.divElement.style.top = bh + "px";
        break;
    }
  },
  __getCurrentCoordinateInPixels: function () {
    const pos = this.paneModel.getPosition();
    const left = this.divElement.style.left.replace("px", "") / 1;
    const top = this.divElement.style.top.replace("px", "") / 1;
    switch (pos) {
      case "west":
        return left;
      case "east":
        return left;
      case "south":
        return top;
      case "north":
        return top;
    }
  },
  __getSlideSpeed: function (slideOut) {
    const pos = this.paneModel.getPosition();
    switch (pos) {
      case "west":
      case "north":
        return slideOut ? 1 : -1;
      case "south":
      case "east":
        return slideOut ? -1 : 1;
    }
  },
  __processSlideByPixels: function (
    slideTo,
    slidePixels,
    currentPos,
    hideWhenComplete
  ) {
    const pos = this.paneModel.getPosition();
    currentPos = currentPos + slidePixels;
    let repeatSlide = true;
    if (slidePixels > 0 && currentPos > slideTo) {
      currentPos = slideTo;
      repeatSlide = false;
    }
    if (slidePixels < 0 && currentPos < slideTo) {
      currentPos = slideTo;
      repeatSlide = false;
    }
    switch (pos) {
      case "west":
      case "east":
        this.divElement.style.left = currentPos + "px";
        break;
      case "north":
      case "south":
        this.divElement.style.top = currentPos + "px";
    }
    if (repeatSlide) {
      const ind = this.objectIndex;
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__processSlideByPixels(" +
          slideTo +
          "," +
          slidePixels +
          "," +
          currentPos +
          "," +
          hideWhenComplete +
          ")",
        10
      );
    } else {
      if (hideWhenComplete) {
        this.divElement.style.visibility = "hidden";
        this.divElement.style.zIndex = 11000;
        this.divElCollapsed.style.zIndex = 12000;
      }
      this.slideIsInProgress = false;
    }
  },
  __getSlideToCoordinates: function (slideOut) {
    const bw = DHTMLSuite.clientInfoObj.getBrowserWidth();
    const bh = DHTMLSuite.clientInfoObj.getBrowserHeight();
    const pos = this.paneModel.getPosition();
    switch (pos) {
      case "west":
        return slideOut
          ? this.parentRef.paneSizeCollapsed +
              this.parentRef.verticalSplitterSize
          : 0 - this.paneModel.size;
      case "east":
        return slideOut
          ? bw -
              this.parentRef.paneSizeCollapsed -
              this.paneModel.size -
              this.parentRef.verticalSplitterSize -
              1
          : bw;
      case "north":
        return slideOut
          ? this.parentRef.paneSizeCollapsed +
              this.parentRef.horizontalSplitterSize
          : 0 - this.paneModel.size;
      case "south":
        return slideOut
          ? bh -
              this.parentRef.paneSizeCollapsed -
              this.paneModel.size -
              this.parentRef.horizontalSplitterSize -
              1
          : bh;
    }
  },
  __updateCollapsedSize: function () {
    const pos = this.paneModel.getPosition();
    let size;
    if (pos == "west" || pos == "east") size = this.divElCollapsed.offsetWidth;
    if (pos == "north" || pos == "south") {
      size = this.divElCollapsed.offsetHeight;
    }
    if (size) this.parentRef.__setPaneSizeCollapsed(size);
  },
  __createHeaderBar: function () {
    const ind = this.objectIndex;
    const pos = this.paneModel.getPosition();
    let buttonSuffix = "Vertical";
    if (pos == "west" || pos == "east") buttonSuffix = "Horizontal";
    if (pos == "center") buttonSuffix = "";
    this.headerDiv = document.createElement("DIV");
    this.headerDiv.className = "DHTMLSuite_paneHeader";
    this.headerDiv.style.position = "relative";
    this.divElement.appendChild(this.headerDiv);
    this.titleSpan = document.createElement("SPAN");
    this.titleSpan.className = "paneTitle";
    this.headerDiv.appendChild(this.titleSpan);
    const buttonDiv = document.createElement("DIV");
    buttonDiv.style.position = "absolute";
    buttonDiv.style.right = "0px";
    buttonDiv.style.top = "0px";
    buttonDiv.className = "DHTMLSuite_paneHeader_buttonDiv";
    this.headerDiv.appendChild(buttonDiv);
    this.divClose = document.createElement("DIV");
    this.divClose.className = "closeButton";
    this.divClose.onmouseover = this.__mouseoverHeaderButton;
    this.divClose.onmouseout = this.__mouseoutHeaderButton;
    this.divClose.innerHTML = "<span></span>";
    this.divClose.onclick = function () {
      return DHTMLSuite.variableStorage.arrayDSObjects[ind].__close();
    };
    DHTMLSuite.commonObj.__addEventEl(this.divClose);
    buttonDiv.appendChild(this.divClose);
    if (
      pos != "center" &&
      this.parentRef.dataModel.collapseButtonsInTitleBars
    ) {
      this.divCollapse = document.createElement("DIV");
      if (pos == "south" || pos == "east") {
        this.divCollapse.className = "expandButton" + buttonSuffix;
      } else this.divCollapse.className = "collapseButton" + buttonSuffix;
      this.divCollapse.innerHTML = "<span></span>";
      this.divCollapse.onclick = function () {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__collapse();
      };
      this.divCollapse.onmouseover = this.__mouseoverHeaderButton;
      this.divCollapse.onmouseout = this.__mouseoutHeaderButton;
      DHTMLSuite.commonObj.__addEventEl(this.divCollapse);
      buttonDiv.appendChild(this.divCollapse);
    }
    this.divRefresh = document.createElement("DIV");
    this.divRefresh.className = "refreshButton";
    this.divRefresh.onmouseover = this.__mouseoverHeaderButton;
    this.divRefresh.onmouseout = this.__mouseoutHeaderButton;
    this.divRefresh.onclick = function () {
      return DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__reloadDisplayedContent();
    };
    DHTMLSuite.commonObj.__addEventEl(this.divRefresh);
    buttonDiv.appendChild(this.divRefresh);
    this.headerDiv.onselectstart = function () {
      return false;
    };
  },
  __mouseoverHeaderButton: function () {
    if (this.className.indexOf("Over") == -1) {
      this.className = this.className + "Over";
    }
  },
  __mouseoutHeaderButton: function () {
    this.className = this.className.replace("Over", "");
  },
  __close: function (e) {
    const id = this.paneModel.contents[this.activeContentIndex].id;
    const ok = this.__getOnBeforeCloseResult(this.activeContentIndex);
    if (!ok) return;
    if (id) {
      this.__executeCallBack(
        "closeContent",
        this.paneModel.contents[this.activeContentIndex]
      );
      DHTMLSuite.discardElement(
        this.paneModel.contents[this.activeContentIndex].htmlElementId
      );
    }
    this.activeContentIndex = this.paneModel.__deleteContent(
      this.activeContentIndex
    );
    if (this.activeContentIndex || this.activeContentIndex == 0) {
      this.__executeCallBack(
        "tabSwitch",
        this.paneModel.contents[this.activeContentIndex]
      );
    }
    this.__updatePaneView(this.activeContentIndex);
  },
  __closeAllClosableTabs: function () {
    for (let no = 0; no < this.paneModel.contents.length; no++) {
      const closable = this.paneModel.contents[no].__getClosable();
      if (closable) {
        const id = this.paneModel.contents[no].id;
        DHTMLSuite.discardElement(this.paneModel.contents[no].htmlElementId);
        this.activeContentIndex = this.paneModel.__deleteContent(no);
        this.__updatePaneView(this.activeContentIndex);
        no--;
      }
    }
  },
  __getOnBeforeCloseResult: function (contentIndex) {
    return this.__executeCallBack(
      "beforeCloseContent",
      this.paneModel.contents[contentIndex]
    );
  },
  __deleteContentByIndex: function (contentIndex) {
    if (this.paneModel.getCountContent() == 0) return;
    if (!this.__getOnBeforeCloseResult(contentIndex)) return;
    const htmlId = this.paneModel.contents[contentIndex].htmlElementId;
    if (htmlId) {
      try {
        DHTMLSuite.discardElement(htmlId);
      } catch (e) {}
    }
    const tmpIndex = this.paneModel.__deleteContent(contentIndex);
    if (contentIndex == this.activeContentIndex) {
      this.activeContentIndex = tmpIndex;
    }
    if (this.activeContentIndex > contentIndex) this.activeContentIndex--;
    if (tmpIndex === false) this.activeContentIndex = false;
    this.__updatePaneView(this.activeContentIndex);
  },
  __deleteContentById: function (id) {
    const index = this.paneModel.__getIndexById(id);
    if (index !== false) this.__deleteContentByIndex(index);
  },
  __collapse: function () {
    this.__updateCollapsedSize();
    this.paneModel.__setState("collapsed");
    this.divElCollapsed.style.visibility = "visible";
    this.divElement.style.visibility = "hidden";
    this.__updateView();
    this.parentRef.__hideResizeHandle(this.paneModel.getPosition());
    this.parentRef.__positionPanes();
    this.__executeCallBack(
      "collapse",
      this.paneModel.contents[this.activeContentIndex]
    );
  },
  __expand: function () {
    this.paneModel.__setState("expanded");
    this.divElCollapsed.style.visibility = "hidden";
    this.divElement.style.visibility = "visible";
    this.__updateView();
    this.parentRef.__showResizeHandle(this.paneModel.getPosition());
    this.parentRef.__positionPanes();
    this.__executeCallBack(
      "expand",
      this.paneModel.contents[this.activeContentIndex]
    );
  },
  __updateHeaderBar: function (index) {
    if (index === false) {
      this.divClose.style.display = "none";
      this.divRefresh.style.display = "none";
      try {
        if (
          this.paneModel.getPosition() != "center" &&
          this.paneModel.collapsable
        ) {
          this.divCollapse.style.display = "block";
        } else this.divCollapse.style.display = "none";
      } catch (e) {}
      this.titleSpan.innerHTML = "";
      return;
    }
    this.divClose.style.display = "block";
    this.divRefresh.style.display = "block";
    if (this.divCollapse) this.divCollapse.style.display = "block";
    this.titleSpan.innerHTML = this.paneModel.contents[index].title;
    const contentObj = this.paneModel.contents[index];
    if (!contentObj.closable) this.divClose.style.display = "none";
    if (!contentObj.displayRefreshButton || !contentObj.contentUrl) {
      this.divRefresh.style.display = "none";
    }
    if (!this.paneModel.collapsable) {
      if (this.divCollapse) this.divCollapse.style.display = "none";
    }
  },
  __showButtons: function () {
    const div = this.headerDiv.getElementsByTagName("DIV")[0];
    div.style.visibility = "visible";
  },
  __hideButtons: function () {
    const div = this.headerDiv.getElementsByTagName("DIV")[0];
    div.style.visibility = "hidden";
  },
  __updateView: function () {
    if (
      this.paneModel.getCountContent() > 0 &&
      this.activeContentIndex === false
    ) {
      this.activeContentIndex = 0;
    }
    this.tabDiv.style.display = "block";
    this.headerDiv.style.display = "block";
    const pos = this.paneModel.getPosition();
    if (pos == "south" || pos == "north") {
      this.divElCollapsed.style.height = this.parentRef.paneSizeCollapsed;
    }
    if (this.paneModel.getCountContent() < 2) {
      this.tabDiv.style.display = "none";
    }
    if (this.activeContentIndex !== false) {
      if (!this.paneModel.contents[this.activeContentIndex].title) {
        this.headerDiv.style.display = "none";
      }
    }
    if (this.paneModel.state == "expanded") this.__showButtons();
    else this.__hideButtons();
    this.__setSize();
  },
  __createContentPane: function () {
    this.contentDiv = document.createElement("DIV");
    this.contentDiv.className = "DHTMLSuite_paneContent";
    this.contentDiv.id =
      "DHTMLSuite_paneContent" + this.paneModel.getPosition();
    if (!this.paneModel.scrollbars) this.contentDiv.style.overflow = "hidden";
    this.divElement.appendChild(this.contentDiv);
  },
  __createTabBar: function () {
    this.tabDiv = document.createElement("DIV");
    this.tabDiv.className = "DHTMLSuite_paneTabs";
    this.divElement.appendChild(this.tabDiv);
    this.__updateTabContent();
  },
  __updateTabContent: function () {
    this.tabDiv.innerHTML = "";
    const tableObj = document.createElement("TABLE");
    tableObj.style.padding = "0px";
    tableObj.style.margin = "0px";
    tableObj.cellPadding = 0;
    tableObj.cellSpacing = 0;
    this.tabDiv.appendChild(tableObj);
    const tbody = document.createElement("TBODY");
    tableObj.appendChild(tbody);
    const row = tbody.insertRow(0);
    const contents = this.paneModel.getContents();
    const ind = this.objectIndex;
    for (let no = 0; no < contents.length; no++) {
      const cell = row.insertCell(-1);
      const divTag = document.createElement("DIV");
      divTag.className = "paneSplitterInactiveTab";
      cell.appendChild(divTag);
      const aTag = document.createElement("A");
      aTag.title = contents[no].tabTitle;
      contents[no].tabTitle = String(contents[no].tabTitle);
      aTag.innerHTML = String(contents[no].tabTitle.replace(" ", "&nbsp;"));
      aTag.id = "paneTabLink" + no;
      aTag.href = "#";
      aTag.onclick = function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__tabClick(e);
      };
      divTag.appendChild(aTag);
      DHTMLSuite.commonObj.__addEventEl(aTag);
      divTag.appendChild(document.createElement("SPAN"));
    }
    this.__updateTabView(0);
  },
  __updateTabView: function (activeTab) {
    const tabDivs = this.tabDiv.getElementsByTagName("DIV");
    for (let no = 0; no < tabDivs.length; no++) {
      if (no == activeTab) {
        tabDivs[no].className = "paneSplitterActiveTab";
      } else tabDivs[no].className = "paneSplitterInactiveTab";
    }
  },
  __tabClick: function (e) {
    if (document.all) e = event;
    let inputObj = DHTMLSuite.commonObj.getSrcElement(e);
    if (inputObj.tagName != "A") inputObj = inputObj.parentNode;
    const numIdClickedTab = inputObj.id.replace(/[^0-9]/gi, "");
    if (numIdClickedTab != this.activeContentIndex) {
      this.__updatePaneContentScrollTopPosition(
        this.activeContentIndex,
        numIdClickedTab
      );
    }
    this.__updatePaneView(numIdClickedTab);
    this.__executeCallBack(
      "tabSwitch",
      this.paneModel.contents[this.activeContentIndex]
    );
    return false;
  },
  __updatePaneContentScrollTopPosition: function (
    idOfContentToHide,
    idOfContentToShow
  ) {
    let newScrollTop = 0;
    if (this.contentScrollTopPositions[idOfContentToShow]) {
      newScrollTop = this.contentScrollTopPositions[idOfContentToShow];
    }
    const contentParentContainer = document.getElementById(
      this.paneModel.contents[idOfContentToHide].htmlElementId
    ).parentNode;
    this.contentScrollTopPositions[idOfContentToHide] =
      contentParentContainer.scrollTop;
    setTimeout(
      'document.getElementById("' +
        contentParentContainer.id +
        '").scrollTop=' +
        newScrollTop,
      20
    );
  },
  __addContentDivs: function (onCompleteJsCode) {
    const contents = this.paneModel.getContents();
    for (let no = 0; no < contents.length; no++) {
      this.__addOneContentDiv(this.paneModel.contents[no], onCompleteJsCode);
    }
    this.__updatePaneView(this.activeContentIndex);
  },
  __addOneContentDiv: function (contentObj, onCompleteJsCode) {
    const htmlElementId = contentObj.htmlElementId;
    const contentUrl = contentObj.contentUrl;
    const refreshAfterSeconds = contentObj.refreshAfterSeconds;
    if (htmlElementId) {
      try {
        this.contentDiv.appendChild(document.getElementById(htmlElementId));
        document.getElementById(htmlElementId).className =
          "DHTMLSuite_paneContentInner";
        document.getElementById(htmlElementId).style.display = "none";
      } catch (e) {}
    }
    if (contentUrl) {
      if (
        !contentObj.htmlElementId ||
        htmlElementId.indexOf("dynamicCreatedDiv__") == -1
      ) {
        if (!document.getElementById(htmlElementId)) {
          this.__createAContentDivDynamically(contentObj);
          this.loadContent(
            contentObj.id,
            contentUrl,
            refreshAfterSeconds,
            false,
            onCompleteJsCode
          );
        }
      }
    }
  },
  __createAContentDivDynamically: function (contentObj) {
    const d = new Date();
    let divId =
      "dynamicCreatedDiv__" +
      d.getSeconds() +
      String(Math.random()).replace(".", "");
    if (!document.getElementById(contentObj.id)) divId = contentObj.id;
    contentObj.__setIdOfContentElement(divId);
    const div = document.createElement("DIV");
    div.id = divId;
    div.className = "DHTMLSuite_paneContentInner";
    if (contentObj.contentUrl) div.innerHTML = this.parentRef.waitMessage;
    this.contentDiv.appendChild(div);
    div.style.display = "none";
  },
  __updatePaneView: function (index) {
    if (!index && index !== 0) index = this.activeContentIndex;
    this.__updateTabContent();
    this.__updateView();
    this.__updateHeaderBar(index);
    this.__showHideContentDiv(index);
    this.__updateTabView(index);
    this.activeContentIndex = index;
  },
  __showHideContentDiv: function (index) {
    if (index !== false) {
      var htmlElementId =
        this.paneModel.contents[this.activeContentIndex].htmlElementId;
      try {
        document.getElementById(htmlElementId).style.display = "none";
      } catch (e) {}
      var htmlElementId = this.paneModel.contents[index].htmlElementId;
      if (htmlElementId) {
        try {
          document.getElementById(htmlElementId).style.display = "block";
        } catch (e) {}
      }
    }
  },
  __setSize: function (recursive) {
    const pos = this.paneModel.getPosition().toLowerCase();
    if (pos == "west" || pos == "east") {
      this.divElement.style.width = this.paneModel.size + "px";
    }
    if (pos == "north" || pos == "south") {
      this.divElement.style.height = this.paneModel.size + "px";
      this.divElement.style.width = "100%";
    }
    try {
      this.contentDiv.style.height =
        this.divElement.clientHeight -
        this.tabDiv.offsetHeight -
        this.headerDiv.offsetHeight +
        "px";
    } catch (e) {}
    if (!recursive) {
      window.obj = this;
      setTimeout("window.obj.__setSize(true)", 100);
    }
  },
  __setTopPosition: function (newTop) {
    this.divElement.style.top = newTop + "px";
  },
  __setLeftPosition: function (newLeft) {
    this.divElement.style.left = newLeft + "px";
  },
  __setWidth: function (newWidth) {
    if (
      this.paneModel.getPosition() == "west" ||
      this.paneModel.getPosition() == "east"
    ) {
      this.paneModel.setSize(newWidth);
    }
    newWidth = String(newWidth);
    if (newWidth.indexOf("%") == -1) newWidth = Math.max(1, newWidth) + "px";
    this.divElement.style.width = newWidth;
  },
  __setHeight: function (newHeight) {
    if (
      this.paneModel.getPosition() == "north" ||
      this.paneModel.getPosition() == "south"
    ) {
      this.paneModel.setSize(newHeight);
    }
    this.divElement.style.height = Math.max(1, newHeight) + "px";
    this.__setSize();
  },
  __showTransparentDivForResize: function () {
    this.divTransparentForResize.style.display = "block";
    const ref = this.divTransparentForResize;
    ref.style.height = this.contentDiv.clientHeight + "px";
    ref.style.width = this.contentDiv.clientWidth + "px";
  },
  __hideTransparentDivForResize: function () {
    this.divTransparentForResize.style.display = "none";
  },
};
DHTMLSuite.paneSplitter = function () {
  let dataModel;
  let panes;
  let panesAssociative;
  let paneContent;
  let layoutCSS;
  let horizontalSplitterSize;
  let horizontalSplitterBorderSize;
  let verticalSplitterSize;
  let paneSplitterHandles;
  let paneSplitterHandleOnResize;
  let resizeInProgress;
  let resizeCounter;
  let currentResize;
  let currentResize_min;
  let currentResize_max;
  let paneSizeCollapsed;
  let paneBorderLeftPlusRight;
  let slideSpeed;
  let waitMessage;
  let collapseExpandButtons;
  let paneZIndexCounter;
  this.collapseExpandButtons = new Object();
  this.resizeCounter = -1;
  this.horizontalSplitterSize = 6;
  this.verticalSplitterSize = 6;
  this.paneBorderLeftPlusRight = 2;
  this.slideSpeed = 10;
  this.horizontalSplitterBorderSize = 1;
  this.resizeInProgress = false;
  this.paneSplitterHandleOnResize = false;
  this.paneSizeCollapsed = 18;
  this.paneSplitterHandles = new Object();
  this.dataModel = false;
  this.layoutCSS = "pane-splitter.css";
  this.waitMessage = "Loading content-please wait";
  this.panes = new Array();
  this.panesAssociative = new Object();
  this.paneZIndexCounter = 1;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  let objectIndex;
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.paneSplitter.prototype = {
  addModel: function (newModel) {
    this.dataModel = newModel;
  },
  setLayoutCss: function (layoutCSS) {
    this.layoutCSS = layoutCSS;
  },
  setAjaxWaitMessage: function (newWaitMessage) {
    this.waitMessage = newWaitMessage;
  },
  setSizeOfPane: function (panePosition, newSize) {
    if (!this.panesAssociative[panePosition.toLowerCase()]) return;
    if (panePosition == "east" || panePosition == "west") {
      this.panesAssociative[panePosition.toLowerCase()].__setWidth(newSize);
    }
    if (panePosition == "north" || panePosition == "south") {
      this.panesAssociative[panePosition.toLowerCase()].__setHeight(newSize);
    }
    this.__positionPanes();
  },
  setSlideSpeed: function (slideSpeed) {
    this.slideSpeed = slideSpeed;
  },
  init: function () {
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    if (this.dataModel.collapseButtonsInTitleBars) this.paneSizeCollapsed = 25;
    this.__createPanes();
    this.__positionPanes();
    this.__createResizeHandles();
    this.__addEvents();
    this.__initCollapsePanes();
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        this.objectIndex +
        "].__positionPanes();",
      100
    );
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        this.objectIndex +
        "].__positionPanes();",
      500
    );
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        this.objectIndex +
        "].__positionPanes();",
      1500
    );
  },
  isUrlLoadedInPane: function (id, url) {
    const ref = this.__getPaneReferenceFromContentId(id);
    return ref ? ref.isUrlLoadedInPane(id, url) : false;
  },
  loadContent: function (id, url, refreshAfterSeconds, onCompleteJsCode) {
    const ref = this.__getPaneReferenceFromContentId(id);
    if (ref) {
      ref.loadContent(id, url, refreshAfterSeconds, false, onCompleteJsCode);
    }
  },
  reloadContent: function (id) {
    const ref = this.__getPaneReferenceFromContentId(id);
    if (ref) {
      ref.reloadContent(id);
    }
  },
  setRefreshAfterSeconds: function (idOfContentObject, refreshAfterSeconds) {
    const ref = this.__getPaneReferenceFromContentId(idOfContentObject);
    if (ref) {
      ref.setRefreshAfterSeconds(idOfContentObject, refreshAfterSeconds);
    }
  },
  setContentTabTitle: function (idOfContentObject, newTitle) {
    const ref = this.__getPaneReferenceFromContentId(idOfContentObject);
    if (ref) ref.setContentTabTitle(idOfContentObject, newTitle);
  },
  setContentTitle: function (idOfContentObject, newTitle) {
    const ref = this.__getPaneReferenceFromContentId(idOfContentObject);
    if (ref) ref.setContentTitle(idOfContentObject, newTitle);
  },
  showContent: function (id) {
    const ref = this.__getPaneReferenceFromContentId(id);
    if (ref) ref.showContent(id);
  },
  closeAllClosableTabs: function (panePosition) {
    return this.panesAssociative[panePosition.toLowerCase()]
      ? this.panesAssociative[
          panePosition.toLowerCase()
        ].__closeAllClosableTabs()
      : false;
  },
  addContent: function (panePosition, contentModel, onCompleteJsCode) {
    return this.panesAssociative[panePosition.toLowerCase()]
      ? this.panesAssociative[panePosition.toLowerCase()].addContent(
          contentModel,
          onCompleteJsCode
        )
      : false;
  },
  getState: function (panePosition) {
    if (this.panesAssociative[panePosition.toLowerCase()]) {
      return this.panesAssociative[
        panePosition.toLowerCase()
      ].paneModel.__getState();
    }
  },
  deleteContentById: function (id) {
    const ref = this.__getPaneReferenceFromContentId(id);
    if (ref) ref.__deleteContentById(id);
  },
  deleteContentByIndex: function (panePosition, contentIndex) {
    if (this.panesAssociative[panePosition]) {
      this.panesAssociative[panePosition].__deleteContentByIndex(contentIndex);
    }
  },
  hidePane: function (panePosition) {
    if (this.panesAssociative[panePosition] && panePosition != "center") {
      this.panesAssociative[panePosition].hidePane();
      if (this.paneSplitterHandles[panePosition]) {
        this.paneSplitterHandles[panePosition].style.display = "none";
      }
      this.__positionPanes();
    } else return false;
  },
  showPane: function (panePosition) {
    if (this.panesAssociative[panePosition] && panePosition != "center") {
      this.panesAssociative[panePosition].showPane();
      if (this.paneSplitterHandles[panePosition]) {
        this.paneSplitterHandles[panePosition].style.display = "block";
      }
      this.__positionPanes();
    } else return false;
  },
  getReferenceToMainDivElOfPane: function (panePosition) {
    if (this.panesAssociative[panePosition]) {
      return this.panesAssociative[panePosition].__getReferenceTomainDivEl();
    }
    return false;
  },
  getIdOfCurrentlyDisplayedContent: function (panePosition) {
    if (this.panesAssociative[panePosition]) {
      return this.panesAssociative[
        panePosition
      ].getIdOfCurrentlyDisplayedContent();
    }
    return false;
  },
  getHtmlElIdOfCurrentlyDisplayedContent: function (panePosition) {
    if (this.panesAssociative[panePosition]) {
      return this.panesAssociative[
        panePosition
      ].getHtmlElIdOfCurrentlyDisplayedContent();
    }
    return false;
  },
  getSizeOfPaneInPixels: function (panePosition) {
    if (this.panesAssociative[panePosition]) {
      return this.panesAssociative[panePosition].__getSizeOfPaneInPixels();
    }
    return false;
  },
  expandPane: function (panePosition) {
    if (panePosition == "center") return;
    if (this.panesAssociative[panePosition]) {
      this.panesAssociative[panePosition].__expand();
    }
    if (!this.dataModel.collapseButtonsInTitleBars) {
      this.__toggleCollapseExpandButton(panePosition, "expand");
    }
  },
  collapsePane: function (panePosition) {
    if (panePosition == "center") return;
    if (this.panesAssociative[panePosition]) {
      this.panesAssociative[panePosition].__collapse();
    }
    if (!this.dataModel.collapseButtonsInTitleBars) {
      this.__toggleCollapseExpandButton(panePosition, "collapse");
    }
  },
  __setPaneSizeCollapsed: function (newSize) {},
  __createPanes: function () {
    const dataObjects = this.dataModel.getItems();
    for (let no = 0; no < dataObjects.length; no++) {
      const index = this.panes.length;
      this.panes[index] = new DHTMLSuite.paneSplitterPane(this);
      this.panes[index].addDataSource(dataObjects[no]);
      this.panes[index].__createPane();
      this.panesAssociative[dataObjects[no].position.toLowerCase()] =
        this.panes[index];
    }
  },
  __collapseAPane: function (e, panePosition) {
    const ind = this.objectIndex;
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    src.className = src.className.replace(" DHTMLSuite_collapseExpandOver", "");
    this.__toggleCollapseExpandButton(panePosition, "collapse");
    if (this.panesAssociative[panePosition]) {
      this.panesAssociative[panePosition].__collapse();
    }
    src.onclick = function (e) {
      return DHTMLSuite.variableStorage.arrayDSObjects[ind].__expandAPane(
        e,
        panePosition
      );
    };
  },
  __toggleCollapseExpandButton: function (panePosition, state) {
    const src = this.collapseExpandButtons[panePosition];
    const ind = this.objectIndex;
    if (state == "expand") {
      switch (panePosition) {
        case "east":
          src.className = src.className.replace("Left", "Right");
          src.parentNode.className = src.parentNode.className.replace(
            " DHTMLSuite_paneSplitter_vertical_noresize",
            ""
          );
          break;
        case "west":
          src.className = src.className.replace("Right", "Left");
          src.parentNode.className = src.parentNode.className.replace(
            " DHTMLSuite_paneSplitter_vertical_noresize",
            ""
          );
          break;
        case "south":
          src.className = src.className.replace("Up", "Down");
          src.parentNode.className = src.parentNode.className.replace(
            " DHTMLSuite_paneSplitter_horizontal_noresize",
            ""
          );
          break;
        case "north":
          src.className = src.className.replace("Down", "Up");
          src.parentNode.className = src.parentNode.className.replace(
            " DHTMLSuite_paneSplitter_horizontal_noresize",
            ""
          );
          break;
      }
      src.onclick = function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__collapseAPane(
          e,
          panePosition
        );
      };
    }
    if (state == "collapse") {
      switch (panePosition) {
        case "west":
          src.className = src.className.replace("Left", "Right");
          src.parentNode.className =
            src.parentNode.className +
            " DHTMLSuite_paneSplitter_vertical_noresize";
          break;
        case "east":
          src.className = src.className.replace("Right", "Left");
          src.parentNode.className =
            src.parentNode.className +
            " DHTMLSuite_paneSplitter_vertical_noresize";
          break;
        case "north":
          src.className = src.className.replace("Up", "Down");
          src.parentNode.className =
            src.parentNode.className +
            " DHTMLSuite_paneSplitter_horizontal_noresize";
          break;
        case "south":
          src.className = src.className.replace("Down", "Up");
          src.parentNode.className =
            src.parentNode.className +
            " DHTMLSuite_paneSplitter_horizontal_noresize";
          break;
      }
      src.onclick = function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__expandAPane(
          e,
          panePosition
        );
      };
    }
  },
  __expandAPane: function (e, panePosition) {
    const ind = this.objectIndex;
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    src.className = src.className.replace(" DHTMLSuite_collapseExpandOver", "");
    this.__toggleCollapseExpandButton(panePosition, "expand");
    if (this.panesAssociative[panePosition]) {
      this.panesAssociative[panePosition].__expand();
    }
    src.onclick = function (e) {
      return DHTMLSuite.variableStorage.arrayDSObjects[ind].__collapseAPane(
        e,
        panePosition
      );
    };
  },
  __createResizeHandles: function () {
    const ind = this.objectIndex;
    if (
      this.panesAssociative.north &&
      (this.panesAssociative.north.paneModel.resizable ||
        (this.panesAssociative.north.paneModel.collapsable &&
          !this.dataModel.collapseButtonsInTitleBars))
    ) {
      this.paneSplitterHandles.north = document.createElement("DIV");
      var obj = this.paneSplitterHandles.north;
      obj.className = "DHTMLSuite_paneSplitter_horizontal";
      obj.innerHTML = "<span></span>";
      obj.style.position = "absolute";
      obj.style.height = this.horizontalSplitterSize + "px";
      obj.style.width = "100%";
      obj.style.zIndex = 10000;
      obj.setAttribute("resizeHandle", "1");
      DHTMLSuite.commonObj.addEvent(obj, "mousedown", function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__initResizePane(
          e,
          "north"
        );
      });
      document.body.appendChild(obj);
      if (!this.dataModel.collapseButtonsInTitleBars) {
        var subElement = document.createElement("DIV");
        subElement.className = "DHTMLSuite_resizeButtonUp";
        subElement.onclick = function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[ind].__collapseAPane(
            e,
            "north"
          );
        };
        subElement.onmouseover = this.__mouseoverCollapseButton;
        subElement.onmouseout = this.__mouseoutCollapseButton;
        subElement.innerHTML = "<span></span>";
        DHTMLSuite.commonObj.__addEventEl(subElement);
        obj.appendChild(subElement);
        this.collapseExpandButtons.north = subElement;
        if (this.panesAssociative.north.paneModel.state == "collapsed") {
          this.__toggleCollapseExpandButton("north", "collapse");
        }
        if (!this.panesAssociative.north.paneModel.collapsable) {
          subElement.style.display = "none";
          obj.className =
            obj.className + " DHTMLSuite_paneSplitter_horizontal_expInTitle";
        }
      } else {
        obj.className =
          obj.className + " DHTMLSuite_paneSplitter_horizontal_expInTitle";
      }
      if (!this.panesAssociative.north.paneModel.resizable) {
        obj.className =
          obj.className + " DHTMLSuite_paneSplitter_horizontal_noresize";
      }
    }
    if (this.panesAssociative.west) {
      this.paneSplitterHandles.west = document.createElement("DIV");
      var obj = this.paneSplitterHandles.west;
      obj.innerHTML = "<span></span>";
      obj.className = "DHTMLSuite_paneSplitter_vertical";
      obj.style.position = "absolute";
      obj.style.width = this.verticalSplitterSize + "px";
      obj.style.zIndex = 11000;
      obj.setAttribute("resizeHandle", "1");
      DHTMLSuite.commonObj.addEvent(obj, "mousedown", function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__initResizePane(
          e,
          "west"
        );
      });
      document.body.appendChild(obj);
      if (!this.dataModel.collapseButtonsInTitleBars) {
        var subElement = document.createElement("DIV");
        subElement.className = "DHTMLSuite_resizeButtonLeft";
        subElement.onclick = function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[ind].__collapseAPane(
            e,
            "west"
          );
        };
        DHTMLSuite.commonObj.__addEventEl(subElement);
        subElement.onmouseover = this.__mouseoverCollapseButton;
        subElement.onmouseout = this.__mouseoutCollapseButton;
        subElement.innerHTML = "<span></span>";
        obj.appendChild(subElement);
        this.collapseExpandButtons.west = subElement;
        if (this.panesAssociative.west.paneModel.state == "collapsed") {
          this.__toggleCollapseExpandButton("west", "collapse");
        }
        if (!this.panesAssociative.west.paneModel.collapsable) {
          subElement.style.display = "none";
          obj.className =
            obj.className + " DHTMLSuite_paneSplitter_vertical_expInTitle";
        }
      } else {
        obj.className =
          obj.className + " DHTMLSuite_paneSplitter_vertical_expInTitle";
      }
      if (!this.panesAssociative.west.paneModel.resizable) {
        obj.className =
          obj.className + " DHTMLSuite_paneSplitter_vertical_noresize";
      }
    }
    if (this.panesAssociative.east) {
      this.paneSplitterHandles.east = document.createElement("DIV");
      var obj = this.paneSplitterHandles.east;
      obj.innerHTML = "<span></span>";
      obj.className = "DHTMLSuite_paneSplitter_vertical";
      obj.style.position = "absolute";
      obj.style.width = this.verticalSplitterSize + "px";
      obj.style.zIndex = 11000;
      obj.setAttribute("resizeHandle", "1");
      DHTMLSuite.commonObj.addEvent(obj, "mousedown", function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__initResizePane(
          e,
          "east"
        );
      });
      document.body.appendChild(obj);
      if (!this.dataModel.collapseButtonsInTitleBars) {
        var subElement = document.createElement("DIV");
        subElement.className = "DHTMLSuite_resizeButtonRight";
        subElement.onclick = function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[ind].__collapseAPane(
            e,
            "east"
          );
        };
        subElement.onmouseover = this.__mouseoverCollapseButton;
        subElement.onmouseout = this.__mouseoutCollapseButton;
        subElement.innerHTML = "<span></span>";
        DHTMLSuite.commonObj.__addEventEl(subElement);
        obj.appendChild(subElement);
        this.collapseExpandButtons.east = subElement;
        if (this.panesAssociative.east.paneModel.state == "collapsed") {
          this.__toggleCollapseExpandButton("east", "collapse");
        }
        if (!this.panesAssociative.east.paneModel.collapsable) {
          subElement.style.display = "none";
          obj.className =
            obj.className + " DHTMLSuite_paneSplitter_vertical_expInTitle";
        }
      } else {
        obj.className =
          obj.className + " DHTMLSuite_paneSplitter_vertical_expInTitle";
      }
      if (!this.panesAssociative.east.paneModel.resizable) {
        obj.className =
          obj.className + " DHTMLSuite_paneSplitter_vertical_noresize";
      }
    }
    if (
      this.panesAssociative.south &&
      (this.panesAssociative.south.paneModel.resizable ||
        (this.panesAssociative.south.paneModel.collapsable &&
          !this.dataModel.collapseButtonsInTitleBars))
    ) {
      this.paneSplitterHandles.south = document.createElement("DIV");
      var obj = this.paneSplitterHandles.south;
      obj.innerHTML = "<span></span>";
      obj.className = "DHTMLSuite_paneSplitter_horizontal";
      obj.style.position = "absolute";
      obj.style.height = this.horizontalSplitterSize + "px";
      obj.style.width = "100%";
      obj.setAttribute("resizeHandle", "1");
      obj.style.zIndex = 10000;
      DHTMLSuite.commonObj.addEvent(obj, "mousedown", function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__initResizePane(
          e,
          "south"
        );
      });
      document.body.appendChild(obj);
      if (!this.dataModel.collapseButtonsInTitleBars) {
        var subElement = document.createElement("DIV");
        subElement.style.position = "absolute";
        subElement.className = "DHTMLSuite_resizeButtonDown";
        subElement.onclick = function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[ind].__collapseAPane(
            e,
            "south"
          );
        };
        subElement.onmouseover = this.__mouseoverCollapseButton;
        subElement.onmouseout = this.__mouseoutCollapseButton;
        subElement.innerHTML = "<span></span>";
        DHTMLSuite.commonObj.__addEventEl(subElement);
        obj.appendChild(subElement);
        this.collapseExpandButtons.south = subElement;
        if (this.panesAssociative.south.paneModel.state == "collapsed") {
          this.__toggleCollapseExpandButton("south", "collapse");
        }
        if (!this.panesAssociative.south.paneModel.collapsable) {
          subElement.style.display = "none";
          obj.className =
            obj.className + " DHTMLSuite_paneSplitter_horizontal_expInTitle";
        }
      } else {
        obj.className =
          obj.className + " DHTMLSuite_paneSplitter_horizontal_expInTitle";
      }
      if (!this.panesAssociative.south.paneModel.resizable) {
        obj.className =
          obj.className + " DHTMLSuite_paneSplitter_vertical_noresize";
      }
    }
    this.paneSplitterHandleOnResize = document.createElement("DIV");
    var obj = this.paneSplitterHandleOnResize;
    obj.innerHTML = "<span></span>";
    obj.className = "DHTMLSuite_paneSplitter_onResize";
    obj.style.position = "absolute";
    obj.style.zIndex = 955000;
    obj.style.display = "none";
    document.body.appendChild(obj);
  },
  __mouseoverCollapseButton: function () {
    this.className = this.className + " DHTMLSuite_collapseExpandOver";
  },
  __mouseoutCollapseButton: function () {
    this.className = this.className.replace(
      " DHTMLSuite_collapseExpandOver",
      ""
    );
  },
  __getPaneReferenceFromContentId: function (id) {
    for (let no = 0; no < this.panes.length; no++) {
      const contents = this.panes[no].paneModel.getContents();
      for (let no2 = 0; no2 < contents.length; no2++) {
        if (contents[no2].id == id) return this.panes[no];
      }
    }
    return false;
  },
  __initCollapsePanes: function () {
    for (let no = 0; no < this.panes.length; no++) {
      if (this.panes[no].paneModel.state == "collapsed") {
        this.panes[no].__collapse();
      }
    }
  },
  __getMinimumPos: function (pos) {
    const browserWidth = DHTMLSuite.clientInfoObj.getBrowserWidth();
    const browserHeight = DHTMLSuite.clientInfoObj.getBrowserHeight();
    if (pos == "west" || pos == "north") {
      return this.panesAssociative[pos].paneModel.minSize;
    } else {
      if (pos == "east") {
        return browserWidth - this.panesAssociative[pos].paneModel.maxSize;
      }
      if (pos == "south") {
        return browserHeight - this.panesAssociative[pos].paneModel.maxSize;
      }
    }
  },
  __getMaximumPos: function (pos) {
    const browserWidth = DHTMLSuite.clientInfoObj.getBrowserWidth();
    const browserHeight = DHTMLSuite.clientInfoObj.getBrowserHeight();
    if (pos == "west" || pos == "north") {
      return this.panesAssociative[pos].paneModel.maxSize;
    } else {
      if (pos == "east") {
        return browserWidth - this.panesAssociative[pos].paneModel.minSize;
      }
      if (pos == "south") {
        return browserHeight - this.panesAssociative[pos].paneModel.minSize;
      }
    }
  },
  __initResizePane: function (e, pos) {
    if (document.all) e = event;
    const obj = DHTMLSuite.commonObj.getSrcElement(e);
    let attr = obj.getAttribute("resizeHandle");
    if (!attr) attr = obj.resizeHandle;
    if (!attr) return;
    if (obj.className.indexOf("noresize") >= 0) return;
    this.currentResize = pos;
    this.currentResize_min = this.__getMinimumPos(pos);
    this.currentResize_max = this.__getMaximumPos(pos);
    this.paneSplitterHandleOnResize.style.left =
      this.paneSplitterHandles[pos].style.left;
    this.paneSplitterHandleOnResize.style.top =
      this.paneSplitterHandles[pos].style.top;
    this.paneSplitterHandleOnResize.style.width =
      this.paneSplitterHandles[pos].offsetWidth + "px";
    this.paneSplitterHandleOnResize.style.height =
      this.paneSplitterHandles[pos].offsetHeight + "px";
    this.paneSplitterHandleOnResize.style.display = "block";
    this.resizeCounter = 0;
    DHTMLSuite.commonObj.__setTextSelOk(false);
    this.__timerResizePane(pos);
  },
  __timerResizePane: function (pos) {
    if (this.resizeCounter >= 0 && this.resizeCounter < 5) {
      this.resizeCounter++;
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          this.objectIndex +
          "].__timerResizePane()",
        2
      );
      return;
    }
    if (this.resizeCounter == 5) {
      this.__showTransparentDivForResize("show");
    }
  },
  __showTransparentDivForResize: function () {
    if (DHTMLSuite.clientInfoObj.isOpera) return;
    if (this.panesAssociative.west) {
      this.panesAssociative.west.__showTransparentDivForResize();
    }
    if (this.panesAssociative.south) {
      this.panesAssociative.south.__showTransparentDivForResize();
    }
    if (this.panesAssociative.east) {
      this.panesAssociative.east.__showTransparentDivForResize();
    }
    if (this.panesAssociative.north) {
      this.panesAssociative.north.__showTransparentDivForResize();
    }
    if (this.panesAssociative.center) {
      this.panesAssociative.center.__showTransparentDivForResize();
    }
  },
  __hideTransparentDivForResize: function () {
    if (this.panesAssociative.west) {
      this.panesAssociative.west.__hideTransparentDivForResize();
    }
    if (this.panesAssociative.south) {
      this.panesAssociative.south.__hideTransparentDivForResize();
    }
    if (this.panesAssociative.east) {
      this.panesAssociative.east.__hideTransparentDivForResize();
    }
    if (this.panesAssociative.north) {
      this.panesAssociative.north.__hideTransparentDivForResize();
    }
    if (this.panesAssociative.center) {
      this.panesAssociative.center.__hideTransparentDivForResize();
    }
  },
  __resizePane: function (e) {
    if (document.all) e = event;
    if (DHTMLSuite.clientInfoObj.isMSIE && e.button != 1) this.__endResize();
    if (this.resizeCounter == 5) {
      if (this.currentResize == "west" || this.currentResize == "east") {
        let leftPos = e.clientX;
        if (leftPos < this.currentResize_min) leftPos = this.currentResize_min;
        if (leftPos > this.currentResize_max) leftPos = this.currentResize_max;
        this.paneSplitterHandleOnResize.style.left = leftPos + "px";
      } else {
        let topPos = e.clientY;
        if (topPos < this.currentResize_min) topPos = this.currentResize_min;
        if (topPos > this.currentResize_max) topPos = this.currentResize_max;
        this.paneSplitterHandleOnResize.style.top = topPos + "px";
      }
    }
  },
  __endResize: function () {
    if (this.resizeCounter == 5) {
      this.__hideTransparentDivForResize();
      const browserWidth = DHTMLSuite.clientInfoObj.getBrowserWidth();
      const browserHeight = DHTMLSuite.clientInfoObj.getBrowserHeight();
      const obj = this.panesAssociative[this.currentResize];
      switch (this.currentResize) {
        case "west":
          obj.__setWidth(
            this.paneSplitterHandleOnResize.style.left.replace("px", "") / 1 - 2
          );
          break;
        case "north":
          obj.__setHeight(
            this.paneSplitterHandleOnResize.style.top.replace("px", "") / 1
          );
          break;
        case "east":
          obj.__setWidth(
            browserWidth -
              this.paneSplitterHandleOnResize.style.left.replace("px", "") / 1 -
              8
          );
          break;
        case "south":
          obj.__setHeight(
            browserHeight -
              this.paneSplitterHandleOnResize.style.top.replace("px", "") / 1 -
              7
          );
          break;
      }
      this.__positionPanes();
      obj.__executeResizeCallBack();
      this.paneSplitterHandleOnResize.style.display = "none";
      this.resizeCounter = -1;
      DHTMLSuite.commonObj.__setTextSelOk(true);
    }
  },
  __hideResizeHandle: function (pos) {
    if (!this.paneSplitterHandles[pos]) return;
    switch (pos) {
      case "east":
      case "west":
        this.paneSplitterHandles[pos].className =
          this.paneSplitterHandles[pos].className +
          " DHTMLSuite_paneSplitter_vertical_noresize";
        break;
      case "north":
      case "south":
        this.paneSplitterHandles[pos].className =
          this.paneSplitterHandles[pos].className +
          " DHTMLSuite_paneSplitter_horizontal_noresize";
    }
  },
  __showResizeHandle: function (pos) {
    if (!this.paneSplitterHandles[pos]) return;
    switch (pos) {
      case "east":
      case "west":
        this.paneSplitterHandles[pos].className = this.paneSplitterHandles[
          pos
        ].className.replace(" DHTMLSuite_paneSplitter_vertical_noresize", "");
        break;
      case "north":
      case "south":
        this.paneSplitterHandles[pos].className = this.paneSplitterHandles[
          pos
        ].className.replace(" DHTMLSuite_paneSplitter_horizontal_noresize", "");
    }
  },
  __positionResizeHandles: function () {
    if (this.paneSplitterHandles.north) {
      if (this.panesAssociative.north.paneModel.state == "expanded") {
        this.paneSplitterHandles.north.style.top =
          this.panesAssociative.north.divElement.style.height.replace(
            "px",
            ""
          ) + "px";
      } else {
        this.paneSplitterHandles.north.style.top =
          this.paneSizeCollapsed + "px";
      }
    }
    let heightHandler =
      this.panesAssociative.center.divElement.offsetHeight + 1;
    var topPos = 0;
    if (this.panesAssociative.center) {
      topPos +=
        this.panesAssociative.center.divElement.style.top.replace("px", "") / 1;
    }
    if (this.paneSplitterHandles.west) {
      if (this.paneSplitterHandles.east) {
        heightHandler += this.horizontalSplitterBorderSize / 2;
      }
      if (this.panesAssociative.west.paneModel.state == "expanded") {
        this.paneSplitterHandles.west.style.left =
          this.panesAssociative.west.divElement.offsetWidth + "px";
      } else {
        this.paneSplitterHandles.west.style.left =
          this.paneSizeCollapsed + "px";
      }
      this.paneSplitterHandles.west.style.height = heightHandler + "px";
      this.paneSplitterHandles.west.style.top = topPos + "px";
    }
    if (this.paneSplitterHandles.east) {
      const leftPos =
        this.panesAssociative.center.divElement.style.left.replace("px", "") /
          1 +
        this.panesAssociative.center.divElement.offsetWidth;
      this.paneSplitterHandles.east.style.left = leftPos + "px";
      this.paneSplitterHandles.east.style.height = heightHandler + "px";
      this.paneSplitterHandles.east.style.top = topPos + "px";
    }
    if (this.paneSplitterHandles.south) {
      var topPos =
        this.panesAssociative.south.divElement.style.top.replace("px", "") / 1;
      topPos =
        topPos -
        this.horizontalSplitterSize -
        this.horizontalSplitterBorderSize;
      this.paneSplitterHandles.south.style.top = topPos + "px";
    }
    this.resizeInProgress = false;
  },
  __positionPanes: function () {
    if (this.resizeInProgress) return;
    const ind = this.objectIndex;
    this.resizeInProgress = true;
    const browserWidth = DHTMLSuite.clientInfoObj.getBrowserWidth();
    const browserHeight = DHTMLSuite.clientInfoObj.getBrowserHeight();
    let posTopMiddlePanes = 0;
    if (
      this.panesAssociative.north &&
      this.panesAssociative.north.paneModel.visible
    ) {
      if (this.panesAssociative.north.paneModel.state == "expanded") {
        posTopMiddlePanes = this.panesAssociative.north.divElement.offsetHeight;
        this.panesAssociative.north.__setHeight(
          this.panesAssociative.north.divElement.offsetHeight
        );
      } else {
        posTopMiddlePanes += this.paneSizeCollapsed;
      }
      if (this.paneSplitterHandles.north) {
        posTopMiddlePanes +=
          this.horizontalSplitterSize + this.horizontalSplitterBorderSize;
      }
    }
    if (this.panesAssociative.center) {
      this.panesAssociative.center.__setTopPosition(posTopMiddlePanes);
    }
    if (this.panesAssociative.west) {
      this.panesAssociative.west.__setTopPosition(posTopMiddlePanes);
    }
    if (this.panesAssociative.east) {
      this.panesAssociative.east.__setTopPosition(posTopMiddlePanes);
    }
    if (this.panesAssociative.west) {
      this.panesAssociative.west.divElCollapsed.style.top =
        posTopMiddlePanes + "px";
    }
    if (this.panesAssociative.east) {
      this.panesAssociative.east.divElCollapsed.style.top =
        posTopMiddlePanes + "px";
    }
    let posLeftCenterPane = 0;
    if (this.panesAssociative.west) {
      if (this.panesAssociative.west.paneModel.state == "expanded") {
        posLeftCenterPane = this.panesAssociative.west.divElement.offsetWidth;
        this.panesAssociative.west.__setLeftPosition(0);
      } else {
        posLeftCenterPane += this.paneSizeCollapsed;
      }
      posLeftCenterPane += this.verticalSplitterSize;
    }
    this.panesAssociative.center.__setLeftPosition(posLeftCenterPane);
    let sizeCenterPane = browserWidth;
    if (
      this.panesAssociative.west &&
      this.panesAssociative.west.paneModel.visible
    ) {
      sizeCenterPane -=
        this.panesAssociative.west.paneModel.state == "expanded"
          ? this.panesAssociative.west.divElement.offsetWidth
          : this.paneSizeCollapsed;
    }
    if (
      this.panesAssociative.east &&
      this.panesAssociative.east.paneModel.visible
    ) {
      if (this.panesAssociative.east.paneModel.state == "expanded") {
        sizeCenterPane -= this.panesAssociative.east.divElement.offsetWidth;
      } else {
        sizeCenterPane -= this.paneSizeCollapsed;
        if (DHTMLSuite.clientInfoObj.isOldMSIE) sizeCenterPane -= 4;
      }
    }
    sizeCenterPane -= this.paneBorderLeftPlusRight;
    if (this.paneSplitterHandles.west) {
      sizeCenterPane -= this.verticalSplitterSize;
    }
    if (this.paneSplitterHandles.east) {
      sizeCenterPane -= this.verticalSplitterSize;
    }
    this.panesAssociative.center.__setWidth(sizeCenterPane);
    let posEastPane =
      posLeftCenterPane + this.panesAssociative.center.divElement.offsetWidth;
    if (this.paneSplitterHandles.east) {
      posEastPane += this.verticalSplitterSize;
    }
    if (this.panesAssociative.east) {
      if (this.panesAssociative.east.paneModel.state == "expanded") {
        this.panesAssociative.east.__setLeftPosition(posEastPane);
      }
      this.panesAssociative.east.divElCollapsed.style.left = "";
      this.panesAssociative.east.divElCollapsed.style.right = "0px";
    }
    let heightMiddleFrames = browserHeight;
    if (
      this.panesAssociative.north &&
      this.panesAssociative.north.paneModel.visible
    ) {
      heightMiddleFrames -=
        this.panesAssociative.north.paneModel.state == "expanded"
          ? this.panesAssociative.north.divElement.offsetHeight
          : this.paneSizeCollapsed;
      if (this.paneSplitterHandles.north) {
        heightMiddleFrames -=
          this.horizontalSplitterSize + this.horizontalSplitterBorderSize;
      }
    }
    if (
      this.panesAssociative.south &&
      this.panesAssociative.south.paneModel.visible
    ) {
      heightMiddleFrames -=
        this.panesAssociative.south.paneModel.state == "expanded"
          ? this.panesAssociative.south.divElement.offsetHeight
          : this.paneSizeCollapsed;
      if (this.paneSplitterHandles.south) {
        heightMiddleFrames -=
          this.horizontalSplitterSize + this.horizontalSplitterBorderSize;
      }
    }
    if (this.panesAssociative.center) {
      this.panesAssociative.center.__setHeight(heightMiddleFrames);
    }
    if (this.panesAssociative.west) {
      this.panesAssociative.west.__setHeight(heightMiddleFrames);
    }
    if (this.panesAssociative.east) {
      this.panesAssociative.east.__setHeight(heightMiddleFrames);
    }
    let posSouth = 0;
    if (this.panesAssociative.north) {
      posSouth =
        this.panesAssociative.north.paneModel.state == "expanded"
          ? this.panesAssociative.north.divElement.offsetHeight
          : this.paneSizeCollapsed;
    }
    posSouth += heightMiddleFrames;
    if (this.paneSplitterHandles.south) {
      posSouth +=
        this.horizontalSplitterSize + this.horizontalSplitterBorderSize;
    }
    if (this.paneSplitterHandles.north) {
      posSouth +=
        this.horizontalSplitterSize + this.horizontalSplitterBorderSize;
    }
    if (this.panesAssociative.south) {
      this.panesAssociative.south.__setTopPosition(posSouth);
      this.panesAssociative.south.divElCollapsed.style.top = posSouth + "px";
      this.panesAssociative.south.__setWidth("100%");
    }
    try {
      if (this.panesAssociative.west) {
        this.panesAssociative.west.divElCollapsed.style.height =
          heightMiddleFrames + "px";
        this.panesAssociative.west.divElCollapsedInner.style.height =
          heightMiddleFrames - 1 + "px";
      }
    } catch (e) {}
    if (this.panesAssociative.east) {
      try {
        this.panesAssociative.east.divElCollapsed.style.height =
          heightMiddleFrames + "px";
        this.panesAssociative.east.divElCollapsedInner.style.height =
          heightMiddleFrames - 1 + "px";
      } catch (e) {}
    }
    if (this.panesAssociative.south) {
      this.panesAssociative.south.divElCollapsed.style.width =
        browserWidth + "px";
      if (
        this.panesAssociative.south.paneModel.state == "collapsed" &&
        this.panesAssociative.south.divElCollapsed.offsetHeight
      ) {
        const rest =
          browserHeight -
          this.panesAssociative.south.divElCollapsed.style.top.replace(
            "px",
            ""
          ) /
            1 -
          this.panesAssociative.south.divElCollapsed.offsetHeight;
        if (rest > 0) {
          this.panesAssociative.south.divElCollapsed.style.height =
            this.panesAssociative.south.divElCollapsed.offsetHeight +
            rest +
            "px";
        }
      }
    }
    if (this.panesAssociative.north) {
      this.panesAssociative.north.divElCollapsed.style.width =
        browserWidth + "px";
    }
    this.__positionResizeHandles();
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__positionResizeHandles()",
      50
    );
  },
  __autoSlideInPanes: function (e) {
    if (document.all) e = event;
    if (this.panesAssociative.south) {
      this.panesAssociative.south.__autoSlideInPane(e);
    }
    if (this.panesAssociative.west) {
      this.panesAssociative.west.__autoSlideInPane(e);
    }
    if (this.panesAssociative.north) {
      this.panesAssociative.north.__autoSlideInPane(e);
    }
    if (this.panesAssociative.east) {
      this.panesAssociative.east.__autoSlideInPane(e);
    }
  },
  __addEvents: function () {
    const ind = this.objectIndex;
    DHTMLSuite.commonObj.addEvent(window, "resize", function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__positionPanes();
    });
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mouseup",
      function () {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__endResize();
      }
    );
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mousemove",
      function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__resizePane(e);
      }
    );
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "click",
      function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__autoSlideInPanes(e);
      }
    );
    document.documentElement.onselectstart = function () {
      return DHTMLSuite.commonObj.__isTextSelOk();
    };
    DHTMLSuite.commonObj.__addEventEl(window);
  },
};
DHTMLSuite.listModel = function (inputArray) {
  let options;
  this.options = new Array();
};
DHTMLSuite.listModel.prototype = {
  addElement: function (value, text) {
    const index = this.options.length;
    this.options[index] = new Object();
    this.options[index].value = value;
    this.options[index].text = text;
  },
  deleteAll: function () {
    this.options.length = 0;
  },
  deleteOptionByValue: function (value) {
    for (let no = 0; no < this.options.length; no++) {
      if (this.options[no].value == value) {
        this.options.splice(no, 1);
        return;
      }
    }
  },
  createFromMarkupSelect: function (elId) {
    let obj = document.getElementById(elId);
    if (obj && obj.tagName.toLowerCase() != "select") obj = false;
    if (!obj) {
      alert(
        "Error in listModel.createFromMarkupSelect-cannot create elements from select box with id " +
          elId
      );
      return;
    }
    for (let no = 0; no < obj.options.length; no++) {
      const index = this.options.length;
      this.options[index] = new Object();
      this.options[index].value = obj.options[no].value;
      this.options[index].text = obj.options[no].text;
    }
    obj.style.display = "none";
  },
  createFromMarkupUlLi: function (elId) {
    let obj = document.getElementById(elId);
    if (obj && obj.tagName.toLowerCase() != "ul") obj = false;
    if (!obj) {
      alert(
        "Error in listModel.createFromMarkupSelect-cannot create elements from select box with id " +
          elId
      );
      return;
    }
    const lis = obj.getElementsByTagName("LI");
    for (let no = 0; no < lis.length; no++) {
      const index = this.options.length;
      this.options[index] = new Object();
      this.options[index].value = lis[no].getAttribute("title");
      if (!this.options[index].value) this.options[index].value = lis[no].title;
      this.options[index].text = lis[no].innerHTML;
    }
    obj.style.display = "none";
  },
};
DHTMLSuite.textEditModel = function (inputArray) {
  let labelId;
  let targetId;
  let serversideFile;
  let optionObj;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  if (inputArray) this.addElement(inputArray);
};
DHTMLSuite.textEditModel.prototype = {
  addElement: function (inputArray) {
    if (inputArray.labelId) this.labelId = inputArray.labelId;
    if (inputArray.elementId) this.elementId = inputArray.elementId;
    if (inputArray.serverFile) this.serverFile = inputArray.serverFile;
    if (inputArray.listModel) this.listModel = inputArray.listModel;
  },
};
DHTMLSuite.textEdit = function () {
  let layoutCSS;
  let elements;
  let elementsAssociative;
  let serversideFile;
  let objectIndex;
  let inputObjects;
  this.layoutCSS = "text-edit.css";
  this.elements = new Array();
  this.elementsAssociative = new Object();
  this.inputObjects = new Object();
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.textEdit.prototype = {
  setLayoutCss: function (layoutCSS) {
    this.layoutCSS = layoutCSS;
  },
  setServersideFile: function (serversideFile) {
    this.serversideFile = serversideFile;
  },
  addElement: function (inputArray) {
    const index = this.elements.length;
    try {
      this.elements[index] = new DHTMLSuite.textEditModel(inputArray);
    } catch (e) {
      alert("Error: Include dhtmlSuite-textEditModel.js in your html file");
    }
    this.elementsAssociative[inputArray.elementId] = this.elements[index];
  },
  init: function () {
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    const index = this.objectIndex;
    for (let no = 0; no < this.elements.length; no++) {
      const obj = this.elements[no];
      const label = document.getElementById(obj.labelId);
      if (label) {
        label.setAttribute("elementId", obj.elementId);
        if (!label.getAttribute("elementId")) label.elementId = obj.elementId;
        if (label.className) {
          label.setAttribute("origClassname", label.className);
          label.origClassname = label.className;
        }
        label.onclick = function (e) {
          DHTMLSuite.variableStorage.arrayDSObjects[index].__clickOnLabel(e);
        };
        DHTMLSuite.commonObj.__addEventEl(label);
      }
      const el = document.getElementById(obj.elementId);
      DHTMLSuite.commonObj.__addEventEl(el);
      if (el) {
        el.onclick = function (e) {
          DHTMLSuite.variableStorage.arrayDSObjects[index].__clickOnElement(e);
        };
        if (obj.listModel) {
          this.inputObjects[obj.elementId] = document.createElement("SELECT");
          const selObj = this.inputObjects[obj.elementId];
          selObj.className = "DHTMLSuite_textEdit_select";
          for (let no2 = 0; no2 < obj.listModel.options.length; no2++) {
            selObj.options[selObj.options.length] = new Option(
              obj.listModel.options[no2].text,
              obj.listModel.options[no2].value
            );
          }
          selObj.id = "input___" + el.id;
          selObj.onblur = function (e) {
            DHTMLSuite.variableStorage.arrayDSObjects[index].__exitEditMode(e);
          };
          DHTMLSuite.commonObj.__addEventEl(selObj);
          el.parentNode.insertBefore(selObj, el);
          selObj.style.display = "none";
        } else {
          this.inputObjects[obj.elementId] = document.createElement("INPUT");
          const input = this.inputObjects[obj.elementId];
          input.onblur = function (e) {
            DHTMLSuite.variableStorage.arrayDSObjects[index].__exitEditMode(e);
          };
          DHTMLSuite.commonObj.__addEventEl(input);
          input.className = "DHTMLSuite_textEdit_input";
          input.id = "input___" + el.id;
          input.value = el.innerHTML;
          el.parentNode.insertBefore(input, el);
          input.style.display = "none";
        }
      }
    }
  },
  __setLabelClassName: function (obj, state) {
    if (state == "active") obj.className = "DHTMLSuite_textEdit_label";
    else {
      let className = "";
      className = obj.getAttribute("origClassname");
      if (!className) className = obj.origClassname;
      obj.className = className;
    }
  },
  __clickOnLabel: function (e) {
    if (document.all) e = event;
    const obj = DHTMLSuite.commonObj.getSrcElement(e);
    this.__setLabelClassName(obj, "active");
    const elementId = obj.getAttribute("elementId");
    this.__clickOnElement(false, document.getElementById(elementId));
  },
  __clickOnElement: function (e, obj) {
    if (document.all) e = event;
    if (!obj) var obj = DHTMLSuite.commonObj.getSrcElement(e);
    const id = obj.id;
    const dataSource = this.elementsAssociative[id];
    if (dataSource.listModel) this.__setSelectBoxValue(id, obj.innerHTML);
    if (dataSource.labelId) {
      this.__setLabelClassName(
        document.getElementById(dataSource.labelId),
        "active"
      );
    }
    this.inputObjects[id].style.display = "";
    this.inputObjects[id].focus();
    if (!dataSource.listModel) this.inputObjects[id].select();
    obj.style.display = "none";
  },
  __setSelectBoxValue: function (id, value) {
    const selObj = this.inputObjects[id];
    for (let no = 0; no < selObj.options.length; no++) {
      if (selObj.options[no].text == value) {
        selObj.selectedIndex = no;
        return;
      }
    }
  },
  __exitEditMode: function (e) {
    if (document.all) e = event;
    const obj = DHTMLSuite.commonObj.getSrcElement(e);
    const elementId = obj.id.replace("input___", "");
    const dataSource = this.elementsAssociative[elementId];
    let newValue;
    let valueToSendToAjax;
    if (dataSource.listModel) {
      newValue = obj.options[obj.options.selectedIndex].text;
      valueToSendToAjax = obj.options[obj.options.selectedIndex].value;
    } else {
      newValue = obj.value;
      valueToSendToAjax = newValue;
    }
    if (e.keyCode && e.keyCode == 27) {
      newValue = document.getElementById(dataSource.elementId).innerHTML;
    }
    if (
      newValue &&
      newValue != document.getElementById(dataSource.elementId).innerHTML
    ) {
      this.__sendRequest(dataSource.elementId, valueToSendToAjax);
    }
    document.getElementById(dataSource.elementId).innerHTML = newValue;
    document.getElementById(dataSource.elementId).style.display = "";
    obj.style.display = "none";
    if (dataSource.labelId) {
      this.__setLabelClassName(
        document.getElementById(dataSource.labelId),
        "inactive"
      );
    }
  },
  __sendRequest: function (elementId, value) {
    const index = DHTMLSuite.variableStorage.ajaxObjects.length;
    const ind = this.objectIndex;
    try {
      DHTMLSuite.variableStorage.ajaxObjects[index] = new sack();
    } catch (e) {
      alert(
        "Unable to create ajax object. Please make sure that the sack js file is included on your page"
      );
      return;
    }
    let url;
    url = this.elementsAssociative[elementId].serverFile
      ? this.elementsAssociative[elementId].serverFile
      : this.serversideFile;
    url = url.indexOf("?") >= 0 ? url + "&" : url + "?";
    url =
      url +
      "saveTextEdit=1&textEditElementId=" +
      elementId +
      "&textEditValue=" +
      escape(value);
    DHTMLSuite.variableStorage.ajaxObjects[index].requestFile = url;
    DHTMLSuite.variableStorage.ajaxObjects[index].onCompletion = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__handleServerSideResponse(
        index,
        url
      );
    };
    DHTMLSuite.variableStorage.ajaxObjects[index].onError = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__handleAjaxError(
        index,
        url
      );
    };
    DHTMLSuite.variableStorage.ajaxObjects[index].runAJAX();
  },
  __handleServerSideResponse: function (ajaxIndex, url) {
    if (DHTMLSuite.variableStorage.ajaxObjects[ajaxIndex].response != "OK") {
      alert(
        "An error occured in the textEdit widget when calling the url\n" + url
      );
    }
    DHTMLSuite.variableStorage.ajaxObjects[ajaxIndex] = null;
  },
  __handleAjaxError: function (ajaxIndex, url) {
    alert("Error when calling the url:\n" + url);
    DHTMLSuite.variableStorage.ajaxObjects[ajaxIndex] = null;
  },
};
let referenceToDHTMLSuiteContextMenu;
DHTMLSuite.contextMenu = function () {
  let menuModels;
  let defaultMenuModel;
  let menuItems;
  let menuObject;
  let layoutCSS;
  let menuUls;
  let width;
  let srcElement;
  let indexCurrentlyDisplayedMenuModel;
  let menuBar;
  this.menuModels = new Object();
  this.menuObject = false;
  this.menuUls = new Array();
  this.width = 100;
  this.srcElement = false;
  this.indexCurrentlyDisplayedMenuModel = false;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
};
DHTMLSuite.contextMenu.prototype = {
  setWidth: function (newWidth) {
    this.width = newWidth;
  },
  setLayoutCss: function (cssFileName) {},
  attachToElement: function (element, elementId, menuModel) {
    window.refToThisContextMenu = this;
    if (!element && elementId) element = document.getElementById(elementId);
    if (!element.id) {
      element.id = "context_menu" + Math.random();
      element.id = element.id.replace(".", "");
    }
    this.menuModels[element.id] = menuModel;
    menuModel.setSubMenuType(1, "sub");
    menuModel.setMainMenuGroupWidth(this.width);
    if (!this.defaultMenuModel) this.defaultMenuModel = menuModel;
    element.oncontextmenu = this.__displayContextMenu;
    element.onmousedown = function () {
      window.refToThisContextMenu.__setReference(window.refToThisContextMenu);
    };
    DHTMLSuite.commonObj.__addEventEl(element);
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "click",
      this.__hideContextMenu
    );
  },
  __setReference: function (obj) {
    referenceToDHTMLSuiteContextMenu = obj;
  },
  __displayContextMenu: function (e) {
    if (document.all) e = event;
    const ref = referenceToDHTMLSuiteContextMenu;
    ref.srcElement = DHTMLSuite.commonObj.getSrcElement(e);
    if (
      !ref.indexCurrentlyDisplayedMenuModel ||
      ref.indexCurrentlyDisplayedMenuModel != this.id
    ) {
      if (ref.indexCurrentlyDisplayedMenuModel) {
        ref.menuObject.innerHTML = "";
      } else {
        ref.__createDivs();
      }
      ref.menuItems = ref.menuModels[this.id].getItems();
      ref.__createMenuItems(ref.menuModels[this.id]);
    }
    ref.indexCurrentlyDisplayedMenuModel = this.id;
    ref.menuObject.style.left =
      e.clientX +
      Math.max(document.body.scrollLeft, document.documentElement.scrollLeft) +
      "px";
    ref.menuObject.style.top =
      e.clientY +
      Math.max(document.body.scrollTop, document.documentElement.scrollTop) +
      "px";
    ref.menuObject.style.display = "block";
    return false;
  },
  __hideContextMenu: function () {
    const ref = referenceToDHTMLSuiteContextMenu;
    if (!ref) return;
    if (ref.menuObject) ref.menuObject.style.display = "none";
  },
  __createDivs: function () {
    let firstChild = false;
    const firstChilds = document.getElementsByTagName("DIV");
    if (firstChilds.length > 0) firstChild = firstChilds[0];
    this.menuObject = document.createElement("DIV");
    this.menuObject.style.cssText = "position:absolute;z-index:100000;";
    this.menuObject.className = "DHTMLSuite_contextMenu";
    this.menuObject.id =
      "DHTMLSuite_contextMenu" + DHTMLSuite.commonObj.getUniqueId();
    this.menuObject.style.backgroundImage =
      "url('" +
      DHTMLSuite.configObj.imagePath +
      "context-menu/context-menu-gradient.gif" +
      "')";
    this.menuObject.style.backgroundRepeat = "repeat-y";
    if (this.width) this.menuObject.style.width = this.width + "px";
    if (firstChild) {
      firstChild.parentNode.insertBefore(this.menuObject, firstChild);
    } else {
      document.body.appendChild(this.menuObject);
    }
    this.menuBar = new DHTMLSuite.menuBar();
    this.menuBar.setActiveSubItemsOnMouseOver(true);
    this.menuBar.setTarget(this.menuObject.id);
    this.menuBar.addMenuItems(this.defaultMenuModel);
    this.menuBar.init();
  },
  __mouseOver: function () {
    this.className = "DHTMLSuite_item_mouseover";
    if (!document.all) {
      this.style.backgroundPosition = "left center";
    }
  },
  __mouseOut: function () {
    this.className = "";
    if (!document.all) {
      this.style.backgroundPosition = "1px center";
    }
  },
  __createMenuItems: function (menuModel) {
    this.menuBar.deleteAllMenuItems();
    this.menuBar.addMenuItems(menuModel);
    this.menuBar.init();
  },
};
DHTMLSuite.mediaModel = function (inputArray) {
  let id;
  let thumbnailPathSmall;
  let thumbnailPath;
  let largeImagePath;
  let title;
  let caption;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  if (inputArray) this.addItem(inputArray);
};
DHTMLSuite.mediaModel.prototype = {
  addItem: function (inputArray) {
    this.id = inputArray.id;
    if (inputArray.thumbnailPathSmall) {
      this.thumbnailPathSmall = inputArray.thumbnailPathSmall;
    }
    if (inputArray.thumbnailPath) {
      this.thumbnailPath = inputArray.thumbnailPath;
    }
    if (inputArray.largeImagePath) {
      this.largeImagePath = inputArray.largeImagePath;
    }
    if (inputArray.title) this.title = inputArray.title;
    if (inputArray.caption) this.caption = inputArray.caption;
  },
};
DHTMLSuite.mediaCollection = function () {
  let mediaObjects;
  this.mediaObjects = new Array();
};
DHTMLSuite.mediaCollection.prototype = {
  addItemsFromMarkup: function (elementId) {
    const ul = document.getElementById(elementId);
    const lis = ul.getElementsByTagName("LI");
    for (let no = 0; no < lis.length; no++) {
      const img = lis[no].getElementsByTagName("IMG")[0];
      const index = this.mediaObjects.length;
      const mediaArray = new Object();
      mediaArray.id = lis[no].id;
      if (img) {
        mediaArray.thumbnailPath = img.src;
      }
      mediaArray.title = lis[no].title;
      mediaArray.caption = lis[no].getAttribute("caption");
      mediaArray.largeImagePath = lis[no].getAttribute("largeImagePath");
      mediaArray.thumbnailPathSmall =
        lis[no].getAttribute("thumbnailPathSmall");
      this.mediaObjects[index] = new DHTMLSuite.mediaModel(mediaArray);
    }
    DHTMLSuite.discardElement(ul);
  },
  __removeImage: function (idOfMedia) {
    for (let no = 0; no < this.mediaObjects.length; no++) {
      if (this.mediaObjects[no].id == idOfMedia) {
        const retVal = this.mediaObjects[no].id;
        this.mediaObjects.splice(no, 1);
        return retVal;
      }
    }
    return false;
  },
  getMediaById: function (idOfMedia) {
    for (let no = 0; no < this.mediaObjects.length; no++) {
      if (this.mediaObjects[no].id == idOfMedia) {
        return this.mediaObjects[no];
      }
    }
    return false;
  },
};
DHTMLSuite.floatingGallery = function () {
  let collectionModel;
  let layoutCSS;
  let divElement;
  let divElementImageBoxes;
  let idOfParentElementToGallery;
  let callBackFunction_onClick;
  let callBackFunction_onDblClick;
  let callBackFunction_onMouseOver;
  let callBackFunction_onMouseMove;
  let imageSelectionObj;
  let objectIndex;
  this.layoutCSS = "floating-gallery.css";
  this.divElementImageBoxes = new Array();
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.floatingGallery.prototype = {
  setMediaCollectionRef: function (mediaCollectionRef) {
    this.collectionModel = mediaCollectionRef;
  },
  init: function () {
    try {
      DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    } catch (e) {
      alert("loadCSS method missing. Include dhtmlSuite-common.js");
    }
    this.__createMainDivEl();
    this.__createImageBoxes();
    this.__initiallyHandleimageSelection();
  },
  setTargetId: function (idOfParentElementToGallery) {
    this.idOfParentElementToGallery = idOfParentElementToGallery;
  },
  setCallBackFunctionOnClick: function (functionName) {
    this.callBackFunction_onClick = functionName;
  },
  setCallBackFunctionOnDblClick: function (functionName) {
    this.callBackFunction_onDblClick = functionName;
  },
  setCallBackFunctionOnMouseOver: function (functionName) {
    this.callBackFunction_onMouseOver = functionName;
  },
  setCallBackFunctionOnMouseMove: function (functionName) {
    this.callBackFunction_onMouseMove = functionName;
  },
  deleteImageFromGallery: function (idOfImage) {
    const retId = this.collectionModel.__removeImage(idOfImage);
    if (retId) {
      const obj = document.getElementById(retId);
      DHTMLSuite.discardElement(obj);
    } else {
      for (let no = 0; no < this.divElementImageBoxes.length; no++) {
        if (this.divElementImageBoxes[no].id == idOfImage) {
          let mediaRefId =
            this.divElementImageBoxes[no].getAttribute("mediaRefId");
          if (!mediaRefId) {
            mediaRefId = this.divElementImageBoxes[no].mediaRefId;
          }
          const mediaRef = this.collectionModel.getMediaById(mediaRefId);
          this.collectionModel.__removeImage(mediaRef.id);
          DHTMLSuite.discardElement(this.divElementImageBoxes[no]);
        }
      }
    }
  },
  destroy: function () {
    DHTMLSuite.discardElement(this.divElement);
  },
  addImageSelectionObject: function (imageSelectionObj) {
    this.imageSelectionObj = imageSelectionObj;
  },
  __createMainDivEl: function () {
    this.divElement = document.createElement("DIV");
    this.divElement.className = "DHTMLSuite_floatingGalleryContainer";
    if (this.idOfParentElementToGallery) {
      document
        .getElementById(this.idOfParentElementToGallery)
        .appendChild(this.divElement);
    } else document.body.appendChild(this.divElement);
  },
  __createImageBoxes: function () {
    const ind = this.objectIndex;
    for (let no = 0; no < this.collectionModel.mediaObjects.length; no++) {
      this.divElementImageBoxes[no] = document.createElement("DIV");
      this.divElementImageBoxes[no].className =
        "DHTMLSuite_floatingGalleryImageBox";
      this.divElementImageBoxes[no].id =
        this.collectionModel.mediaObjects[no].id;
      this.divElementImageBoxes[no].style.backgroundImage =
        'url("' + this.collectionModel.mediaObjects[no].thumbnailPath + '")';
      this.divElementImageBoxes[no].setAttribute(
        "mediaRefId",
        this.collectionModel.mediaObjects[no].id
      );
      this.divElementImageBoxes[no].mediaRefId =
        this.collectionModel.mediaObjects[no].id;
      this.divElement.appendChild(this.divElementImageBoxes[no]);
      const titleDiv = document.createElement("DIV");
      titleDiv.className = "DHTMLSuite_floatingGalleryImageTitle";
      titleDiv.innerHTML = this.collectionModel.mediaObjects[no].title;
      this.divElementImageBoxes[no].appendChild(titleDiv);
      if (this.callBackFunction_onClick) {
        eval(
          "DHTMLSuite.commonObj.addEvent(this.divElementImageBoxes[no],'click',function(){DHTMLSuite.variableStorage.arrayDSObjects[" +
            ind +
            "].__parseCallBackFunction('click'," +
            no +
            ")});"
        );
      }
      if (this.callBackFunction_onDblClick) {
        eval(
          "DHTMLSuite.commonObj.addEvent(this.divElementImageBoxes[no],'dblclick',function(){DHTMLSuite.variableStorage.arrayDSObjects[" +
            ind +
            "].__parseCallBackFunction('dblClick'," +
            no +
            ")});"
        );
      }
      if (this.callBackFunction_onMouseOver) {
        eval(
          "DHTMLSuite.commonObj.addEvent(this.divElementImageBoxes[no],'mouseover',function(){DHTMLSuite.variableStorage.arrayDSObjects[" +
            ind +
            "].__parseCallBackFunction('mouseOver'," +
            no +
            ")});"
        );
      }
      if (this.callBackFunction_onMouseMove) {
        eval(
          "DHTMLSuite.commonObj.addEvent(this.divElementImageBoxes[no],'mousemove',function(){DHTMLSuite.variableStorage.arrayDSObjects[" +
            ind +
            "].__parseCallBackFunction('mouseOver'," +
            no +
            ")});"
        );
      }
    }
    const clearingDiv = document.createElement("DIV");
    clearingDiv.style.clear = "both";
    this.divElement.appendChild(clearingDiv);
  },
  __parseCallBackFunction: function (action, mediaIndex) {
    let callBackString = false;
    switch (action) {
      case "click":
        callBackString = this.callBackFunction_onClick;
        break;
      case "dblClick":
        callBackString = this.callBackFunction_onDblClick;
        break;
      case "mouseOver":
        callBackString = this.callBackFunction_onMouseOver;
        break;
      case "mouseMove":
        callBackString = this.callBackFunction_onMouseMove;
        break;
    }
    if (callBackString) {
      callBackString =
        callBackString +
        "(this.collectionModel.mediaObjects[" +
        mediaIndex +
        "])";
    }
    if (!callBackString) return;
    try {
      eval(callBackString);
    } catch (e) {
      alert("Error in callback :\n" + callBackString + "\n" + e.message);
    }
  },
  __initiallyHandleimageSelection: function () {
    if (!this.imageSelectionObj) return;
    this.imageSelectionObj.__setMediaCollectionModelReference(
      this.collectionModel
    );
    for (let no = 0; no < this.divElementImageBoxes.length; no++) {
      this.imageSelectionObj.addSelectableElement(
        this.divElementImageBoxes[no]
      );
      this.divElementImageBoxes[no].onselectstart = function () {
        return false;
      };
      DHTMLSuite.commonObj.__addEventEl(this.divElementImageBoxes[no]);
      const subs = this.divElementImageBoxes[no].getElementsByTagName("*");
      for (let no2 = 0; no2 < subs.length; no2++) {
        subs[no2].onselectstart = function () {
          return false;
        };
        DHTMLSuite.commonObj.__addEventEl(subs[no2]);
      }
    }
  },
};
DHTMLSuite.imageSelection = function () {
  let layoutCSS;
  let callBackFunction_onDrop;
  let objectIndex;
  let divElementSelection;
  let divElementSelection_transparent;
  let selectableEls;
  let selectedEls;
  let selectableElsScreenProps;
  let collectionModelReference;
  let destinationEls;
  let currentDestEl;
  let selectionStatus;
  let dragStatus;
  let startCoordinates;
  let selectionResizeInProgress;
  let selectionStartArea;
  let selectionOrDragStartEl;
  this.selectionResizeInProgress = false;
  this.selectionStatus = -1;
  this.dragStatus = -1;
  this.startCoordinates = new Object();
  this.layoutCSS = "image-selection.css";
  this.selectableEls = new Array();
  this.destinationEls = new Array();
  this.collectionModelReference = false;
  this.selectableElsScreenProps = new Object();
  this.selectedEls = new Array();
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.imageSelection.prototype = {
  init: function () {
    try {
      DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    } catch (e) {
      alert(
        "Unable to load css file dynamically. Include dhtmlSuite-common.js"
      );
    }
    this.__createdivElementsForSelection();
    this.__createdivElementsForDrag();
    this.__addEvents();
    this.__setSelectableElsScreenProps();
  },
  addDestinationElement: function (elementReference) {
    elementReference = DHTMLSuite.commonObj.getEl(elementReference);
    this.destinationEls[this.destinationEls.length] = elementReference;
  },
  addDestinationElementsByTagName: function (
    parentElementReference,
    tagName,
    className
  ) {
    parentElementReference = DHTMLSuite.commonObj.getEl(parentElementReference);
    if (!parentElementReference) {
      return false;
    }
    const subs = parentElementReference.getElementsByTagName(tagName);
    for (let no = 0; no < subs.length; no++) {
      if (className && subs[no].className != className) continue;
      this.destinationEls[this.destinationEls.length] = subs[no];
    }
    this.__addEventsTodestinationEls(subs);
    return true;
  },
  addSelectableElements: function (parentElementReference) {
    const obj = DHTMLSuite.commonObj.getEl(parentElementReference);
    let subElement = obj.getElementsByTagName("*")[0];
    while (subElement) {
      this.selectableEls[this.selectableEls.length] = subElement;
      this.__addPropertiesToSelectableElement(subElement);
      subElement = subElement.nextSibling;
    }
  },
  addSelectableElement: function (elementReference) {
    this.selectableEls[this.selectableEls.length] =
      DHTMLSuite.commonObj.getEl(elementReference);
    this.__addPropertiesToSelectableElement(elementReference);
  },
  setCallBackFunctionOnDrop: function (functionName) {
    this.callBackFunction_onDrop = functionName;
  },
  setSelectionStartArea: function (elementReference) {
    elementReference = DHTMLSuite.commonObj.getEl(elementReference);
    this.selectionStartArea = elementReference;
  },
  __createdivElementsForSelection: function () {
    this.divElementSelection = document.createElement("DIV");
    this.divElementSelection.style.display = "none";
    this.divElementSelection.id = "DHTMLSuite_imageSelectionSel";
    this.divElementSelection.innerHTML = "<span></span>";
    document.body.insertBefore(
      this.divElementSelection,
      document.body.firstChild
    );
    this.divElementSelection_transparent = document.createElement("DIV");
    this.divElementSelection_transparent.id =
      "DHTMLSuite_imageSelection_transparentDiv";
    this.divElementSelection.appendChild(this.divElementSelection_transparent);
    this.divElementSelection_transparent.innerHTML = "<span></span>";
  },
  __setMediaCollectionModelReference: function (collectionModelReference) {
    this.collectionModelReference = collectionModelReference;
  },
  __createdivElementsForDrag: function () {
    this.divElementDrag = document.createElement("DIV");
    this.divElementDrag.innerHTML = "<span></span>";
    this.divElementDrag.style.display = "none";
    this.divElementDrag.id = "DHTMLSuite_imageSelectionDrag";
    document.body.insertBefore(this.divElementDrag, document.body.firstChild);
    this.divElementDragContent = document.createElement("DIV");
    this.divElementDragContent.innerHTML = "<span></span>";
    this.divElementDragContent.id = "DHTMLSuite_imageSelectionDragContent";
    this.divElementDrag.appendChild(this.divElementDragContent);
    const divElementTrans = document.createElement("DIV");
    divElementTrans.className = "DHTMLSuite_imageSelectionDrag_transparentDiv";
    this.divElementDrag.appendChild(divElementTrans);
  },
  __initImageSelection: function (e) {
    let initImageSelector;
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    if (src.onmousedown) {
    }
    if (
      src.className.indexOf("paneSplitter_vertical") >= 0 ||
      src.className.indexOf("paneSplitter_horizontal") >= 0
    ) {
      return;
    }
    this.selectionOrDragStartEl = src;
    this.startCoordinates.x =
      e.clientX + document.documentElement.scrollLeft + 3;
    this.startCoordinates.y =
      e.clientY + document.documentElement.scrollTop + 3;
    if (!this.__isReadyForDrag(e)) {
      if (!e.shiftKey && !e.ctrlKey) this.__clearselectedElsArray();
      this.selectionStatus = 0;
      this.divElementSelection.style.left = this.startCoordinates.x + "px";
      this.divElementSelection.style.top = this.startCoordinates.y + "px";
      this.divElementSelection.style.width = "1px";
      this.divElementSelection.style.height = "1px";
      this.__setSelectableElsScreenProps();
      this.__countDownToSelectionStart();
    } else {
      this.divElementDrag.style.left = this.startCoordinates.x + "px";
      this.divElementDrag.style.top = this.startCoordinates.y + "px";
      this.dragStatus = 0;
      this.__countDownToDragStart();
    }
    return false;
  },
  __isReadyForDrag: function (e) {
    const src = DHTMLSuite.commonObj.getObjectByAttribute(
      e,
      "DHTMLSuite_selectableElement"
    );
    if (!src) return false;
    if (this.selectedEls.length > 0) return true;
    return false;
  },
  __countDownToDragStart: function () {
    if (this.dragStatus >= 0 && this.dragStatus < 5) {
      const ind = this.objectIndex;
      this.dragStatus++;
      let timeOut = 60;
      if (this.selectedEls.length > 1) timeOut = 10;
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__countDownToDragStart()",
        timeOut
      );
    }
    if (this.dragStatus == 5) {
      this.__fillDragBoxWithSelectedItems();
      this.divElementDrag.style.display = "block";
    }
  },
  __fillDragBoxWithSelectedItems: function () {
    this.divElementDragContent.innerHTML = "";
    if (this.collectionModelReference) {
      for (var no = 0; no < this.selectedEls.length; no++) {
        const obj = this.selectedEls[no];
        const mediaRefId = obj.getAttribute("mediaRefId");
        if (!mediaRef) mediaRef = obj.mediaRefId;
        var mediaRef = this.collectionModelReference.getMediaById(mediaRefId);
        const div = document.createElement("DIV");
        div.innerHTML = "<span></span>";
        div.className = "DHTMLSuite_imageSelectionDragBox";
        div.style.backgroundImage =
          "url('" + mediaRef.thumbnailPathSmall + "')";
        this.divElementDragContent.appendChild(div);
      }
    } else {
      for (var no = 0; no < this.selectedEls.length; no++) {
        const el = this.selectedEls.cloneNode(true);
        this.divElementDragContent.appendChild(el);
      }
    }
  },
  __countDownToSelectionStart: function () {
    if (this.selectionStatus >= 0 && this.selectionStatus < 5) {
      const ind = this.objectIndex;
      this.selectionStatus++;
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__countDownToSelectionStart()",
        10
      );
    }
    if (this.selectionStatus == 5) {
      this.divElementSelection.style.display = "block";
    }
    return false;
  },
  __moveDragBox: function (e) {
    if (this.dragStatus < 5) return;
    if (document.all) e = event;
    this.divElementDrag.style.left =
      this.startCoordinates.x +
      (e.clientX + 3 - this.startCoordinates.x) +
      "px";
    this.divElementDrag.style.top =
      this.startCoordinates.y +
      (e.clientY + 3 - this.startCoordinates.y) +
      "px";
  },
  __resizeSelectionDivBox: function (e) {
    if (this.selectionStatus < 5) return;
    if (this.selectionResizeInProgress) return;
    this.selectionResizeInProgress = true;
    if (document.all) e = event;
    const width = e.clientX - this.startCoordinates.x;
    const height =
      e.clientY + document.documentElement.scrollTop - this.startCoordinates.y;
    if (width > 0) {
      this.divElementSelection.style.left = this.startCoordinates.x + "px";
      this.divElementSelection.style.width = width + "px";
    } else {
      this.divElementSelection.style.width =
        this.startCoordinates.x - (this.startCoordinates.x + width) + "px";
      this.divElementSelection.style.left =
        this.startCoordinates.x + width + "px";
    }
    if (height > 0) {
      this.divElementSelection.style.top = this.startCoordinates.y + "px";
      this.divElementSelection.style.height = height + "px";
    } else {
      this.divElementSelection.style.height =
        this.startCoordinates.y - (this.startCoordinates.y + height) + "px";
      this.divElementSelection.style.top =
        this.startCoordinates.y + height + "px";
    }
    this.__highlightElementsWithinSelectionArea();
    this.selectionResizeInProgress = false;
  },
  __clearSingleElementFromSelectedArray: function (el) {
    for (let no = 0; no < this.selectedEls.length; no++) {
      if (this.selectedEls[no] == el) {
        this.selectedEls[no].className = this.selectedEls[no].className.replace(
          " imageSelection",
          ""
        );
        this.selectedEls.splice(no, 1);
        return;
      }
    }
  },
  __clearselectedElsArray: function () {
    for (let no = 0; no < this.selectedEls.length; no++) {
      if (this.selectedEls[no].className.indexOf("imageSelection") >= 0) {
        this.selectedEls[no].className = this.selectedEls[no].className.replace(
          " imageSelection",
          ""
        );
      }
    }
    this.selectedEls = new Array();
  },
  __highlightElementsWithinSelectionArea: function () {
    const x1 = this.divElementSelection.style.left.replace("px", "") / 1;
    const y1 = this.divElementSelection.style.top.replace("px", "") / 1;
    const x2 = x1 + this.divElementSelection.style.width.replace("px", "") / 1;
    const y2 = y1 + this.divElementSelection.style.height.replace("px", "") / 1;
    for (let no = 0; no < this.selectableEls.length; no++) {
      if (
        this.__isElementWithinSelectionArea(
          this.selectableEls[no],
          x1,
          y1,
          x2,
          y2
        )
      ) {
        this.__addSelectedElement(this.selectableEls[no]);
      } else {
        this.__clearSingleElementFromSelectedArray(this.selectableEls[no]);
      }
    }
  },
  __isElementInSelectedArray: function (el) {
    for (let no = 0; no < this.selectedEls.length; no++) {
      if (this.selectedEls[no] == el) return true;
    }
    return false;
  },
  __addSelectedElement: function (el) {
    if (el.className.indexOf("imageSelection") == -1) {
      if (el.className) el.className = el.className + " imageSelection";
      else el.className = "imageSelection";
    }
    if (this.__isElementInSelectedArray(el)) return;
    this.selectedEls[this.selectedEls.length] = el;
  },
  __isElementWithinSelectionArea: function (el, x1, y1, x2, y2) {
    const elX1 = this.selectableElsScreenProps[el.id].x;
    const elY1 = this.selectableElsScreenProps[el.id].y;
    const elX2 =
      this.selectableElsScreenProps[el.id].x +
      this.selectableElsScreenProps[el.id].width;
    const elY2 =
      this.selectableElsScreenProps[el.id].y +
      this.selectableElsScreenProps[el.id].height;
    if (elX2 < x1) return false;
    if (elY2 < y1) return false;
    if (elX1 > x2) return false;
    if (elY1 > y2) return false;
    if (
      (elY1 <= y1 && elY2 >= y1) ||
      (elY1 >= y1 && elY2 <= y2) ||
      (elY1 <= y2 && elY2 >= y2)
    ) {
      if (elX1 <= x1 && elX2 >= x1) return true;
      if (elX1 >= x1 && elX2 <= x2) return true;
      if (elX1 <= x2 && elX2 >= x2) return true;
    }
    return false;
  },
  __setSelectableElsScreenProps: function () {
    for (let no = 0; no < this.selectableEls.length; no++) {
      const obj = this.selectableEls[no];
      if (!obj.parentNode) {
        this.selectableEls.splice(no, 1);
        this.__setSelectableElsScreenProps();
        return;
      }
      const id = obj.id;
      this.selectableElsScreenProps[id] = new Object();
      const ref = this.selectableElsScreenProps[id];
      ref.x = DHTMLSuite.commonObj.getLeftPos(obj);
      ref.y = DHTMLSuite.commonObj.getTopPos(obj);
      ref.width = obj.offsetWidth;
      ref.height = obj.offsetHeight;
    }
  },
  __endImageSelection: function (e) {
    if (document.all) e = event;
    if (this.selectionStatus >= 0) {
      this.divElementSelection.style.display = "none";
      if (this.__isReadyForDrag(e) && this.selectionStatus == -1) {
        this.__clearselectedElsArray();
      }
      this.selectionStatus = -1;
    }
    if (this.dragStatus >= 0) {
      const src = DHTMLSuite.commonObj.getSrcElement(e);
      if (this.currentDestEl) this.__handleCallBackFunctions("drop");
      this.divElementDrag.style.display = "none";
      if (src != this.selectionOrDragStartEl || !src.className) {
        this.__clearselectedElsArray();
      }
      this.__deselectDestinationElement();
      this.dragStatus = -1;
    }
  },
  __handleCallBackFunctions: function (action) {
    let callbackString = "";
    switch (action) {
      case "drop":
        if (this.callBackFunction_onDrop) {
          callbackString = this.callBackFunction_onDrop;
        }
        break;
    }
    if (callbackString) {
      eval(callbackString + "(this.selectedEls,this.currentDestEl)");
    }
  },
  __deselectDestinationElement: function (e) {
    if (this.dragStatus < 5) return;
    if (!this.currentDestEl) return;
    if (document.all) e = event;
    if (e && !DHTMLSuite.commonObj.isObjectClicked(this.currentDestEl, e)) {
      return;
    }
    this.currentDestEl.className = this.currentDestEl.className.replace(
      " imageSelection",
      ""
    );
    this.currentDestEl.className = this.currentDestEl.className.replace(
      "imageSelection",
      ""
    );
    this.currentDestEl = false;
  },
  __selectDestinationElement: function (e) {
    if (this.dragStatus < 5) return;
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getObjectByAttribute(
      e,
      "imageSelectionDestination"
    );
    this.currentDestEl = src;
    if (this.currentDestEl.className) {
      this.currentDestEl.className =
        this.currentDestEl.className + " imageSelection";
    } else this.currentDestEl.className = "imageSelection";
  },
  __selectSingleElement: function (e, eventType) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getObjectByAttribute(
      e,
      "DHTMLSuite_selectableElement"
    );
    const elementAllreadyInSelectedArray = this.__isElementInSelectedArray(src);
    if (!e.ctrlKey && !elementAllreadyInSelectedArray) {
      this.__clearselectedElsArray();
    }
    if (e.ctrlKey && elementAllreadyInSelectedArray) {
      this.__clearSingleElementFromSelectedArray(src);
    } else {
      this.__addSelectedElement(src);
    }
  },
  __addPropertiesToSelectableElement: function (elementReference) {
    const ind = this.objectIndex;
    elementReference.onmousedown = function (e) {
      return DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__selectSingleElement(e);
    };
    elementReference.setAttribute("DHTMLSuite_selectableElement", "1");
    this.__addOnScrollEventsToSelectableEls(elementReference);
  },
  __addEventsTodestinationEls: function (inputElements) {
    const ind = this.objectIndex;
    if (inputElements) {
      for (var no = 0; no < inputElements.length; no++) {
        inputElements[no].onmouseover = function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__selectDestinationElement(e);
        };
        inputElements[no].onmouseout = function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__deselectDestinationElement(e);
        };
        inputElements[no].setAttribute("imageSelectionDestination", "1");
        inputElements[no].imageSelectionDestination = "1";
        DHTMLSuite.commonObj.__addEventEl(inputElements[no]);
      }
    } else {
      for (var no = 0; no < this.destinationEls.length; no++) {
        this.destinationEls[no].onmouseover = function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__selectDestinationElement(e);
        };
        this.destinationEls[no].onmouseout = function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__deselectDestinationElement(e);
        };
        DHTMLSuite.commonObj.__addEventEl(this.destinationEls[no]);
        this.destinationEls[no].setAttribute("imageSelectionDestination", "1");
        this.destinationEls[no].imageSelectionDestination = "1";
      }
    }
  },
  __addOnScrollEventsToSelectableEls: function (el) {
    const ind = this.objectIndex;
    let src = el;
    while (src && src.tagName.toLowerCase() != "body") {
      src = src.parentNode;
      if (!src.onscroll) {
        DHTMLSuite.commonObj.addEvent(src, "scroll", function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__endImageSelection(e);
        });
      }
    }
  },
  __addEvents: function () {
    const ind = this.objectIndex;
    document.documentElement.onselectstart = function () {
      return false;
    };
    DHTMLSuite.commonObj.__addEventEl(document.documentElement.onselectstart);

    if (this.selectionStartArea) {
      DHTMLSuite.commonObj.addEvent(
        this.selectionStartArea,
        "mousedown",
        function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__initImageSelection(e);
        }
      );
    } else {
      DHTMLSuite.commonObj.addEvent(
        document.documentElement,
        "mousedown",
        function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__initImageSelection(e);
        }
      );
    }
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mousemove",
      function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[
          ind
        ].__resizeSelectionDivBox(e);
      }
    );
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mousemove",
      function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveDragBox(e);
      }
    );
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mouseup",
      function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[
          ind
        ].__endImageSelection(e);
      }
    );
    DHTMLSuite.commonObj.addEvent(window, "resize", function () {
      return DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__setSelectableElsScreenProps();
    });
    const imgs = document.getElementsByTagName("IMG");
    for (let no = 0; no < imgs.length; no++) {
      imgs[no].ondragstart = function () {
        return false;
      };
      if (!imgs[no].onmousedown) {
        imgs[no].onmousedown = function () {
          return false;
        };
      }
      DHTMLSuite.commonObj.__addEventEl(imgs[no]);
    }
    this.__addEventsTodestinationEls();
  },
};
DHTMLSuite.imageEnlarger = function (props) {
  let layoutCSS;
  this.layoutCSS = "image-enlarger.css";
  let divElement;
  let divElementImageBox;
  let divElInner;
  let iframeEl;
  let currentImagePath;
  let objectIndex;
  let transparentDiv;
  let captionDiv;
  let msieOpacity;
  let isDragable;
  let isModal;
  this.isDragable = false;
  this.msieOpacity = 50;
  this.isModal = true;
  let resizeTransparentAllowed;
  let closeLinkTxt;
  let dragObject;
  let dragOffsetX;
  let dragOffsetY;
  this.dragOffsetX = 0;
  this.dragOffsetY = 0;
  this.closeLinkTxt = "Close";
  this.resizeTransparentAllowed = true;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
  if (props) this.__setInitProps(props);
};
DHTMLSuite.imageEnlarger.prototype = {
  __setInitProps: function (props) {
    if (props.closeLinkTxt) this.closeLinkTxt = props.closeLinkTxt;
    if (props.isDragable) this.isDragable = props.isDragable;
    if (props.isModal || props.isModal === false) this.isModal = props.isModal;
  },
  displayImage: function (imagePath, title, description) {
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    if (!this.divElement) this.__createHTMLElements();
    this.__resizeTransparentDiv();
    this.__clearHTMLElement();
    this.__addImageElement(imagePath);
    this.__setCaptionText(title, description);
    this.__displayDivElement();
    this.currentImagePath = imagePath;
  },
  setIsDragable: function (isDragable) {
    this.isDragable = isDragable;
  },
  setIsModal: function (isModal) {
    this.isModal = isModal;
  },
  setDragOffset: function (dragOffsetX, dragOffsetY) {
    this.dragOffsetX = dragOffsetX;
    this.dragOffsetY = dragOffsetY;
  },
  hide: function () {
    this.__hideDivElement();
    return false;
  },
  setCloseLinkTxt: function (closeLinkTxt) {
    this.closeLinkTxt = closeLinkTxt;
  },
  setLayoutCss: function (newLayoutCss) {
    this.layoutCSS = newLayoutCss;
  },
  __createHTMLElements: function () {
    const ind = this.objectIndex;
    this.divElement = document.createElement("DIV");
    this.divElement.className = "DHTMLSuite_imageEnlarger";
    this.divElement.ondragstart = function () {
      return false;
    };
    DHTMLSuite.commonObj.__addEventEl(this.divElement);
    document.body.appendChild(this.divElement);
    this.divElInner = document.createElement("DIV");
    this.divElInner.className = "DHTMLSuite_imageEnlarger_imageBox";
    this.divElement.appendChild(this.divElInner);
    this.divElementImageBox = document.createElement("DIV");
    this.divElInner.appendChild(this.divElementImageBox);
    this.transparentDiv = document.createElement("DIV");
    this.transparentDiv.className = "DHTMLSuite_imageEnlarger_transparentDivs";
    document.body.appendChild(this.transparentDiv);
    this.transparentDiv.style.display = "none";
    this.transparentDiv.style.filter =
      "alpha(opacity=" + this.msieOpacity + ")";
    DHTMLSuite.commonObj.addEvent(window, "resize", function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__resizeTransparentDiv();
    });
    const closeButton = document.createElement("DIV");
    closeButton.className = "DHTMLSuite_imageEnlarger_close";
    closeButton.onmouseover = this.__mouseOverEffectCloseButton;
    closeButton.onmouseout = this.__mouseoutCalendarButton;
    closeButton.onclick = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].hide();
    };
    DHTMLSuite.commonObj.__addEventEl(closeButton);
    this.divElInner.appendChild(closeButton);
    this.captionDiv = document.createElement("DIV");
    this.captionDiv.className = "DHTMLSuite_imageEnlarger_caption";
    this.divElInner.appendChild(this.captionDiv);
    if (DHTMLSuite.clientInfoObj.isMSIE) {
      this.iframeEl = document.createElement(
        '<iframe frameborder=0 src="about:blank" scrolling="no">'
      );
      this.iframeEl.className = "DHTMLSuite_imageEnlarger_iframe";
      this.divElement.appendChild(this.iframeEl);
    }
    if (this.isDragable) {
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__makeElementDragable()",
        1
      );
    }
  },
  __makeElementDragable: function () {
    try {
      this.dragObject = new DHTMLSuite.dragDropSimple({
        elementReference: this.divElement,
        offsetX: this.dragOffsetX,
        offsetY: this.dragOffsetY,
        cloneNode: false,
      });
    } catch (e) {
      alert("Include DHTMLSuite-dragDropSimple.js for the drag feature");
    }
  },
  __mouseOverEffectCloseButton: function () {
    this.className = "DHTMLSuite_imageEnlarger_closeOver";
  },
  __mouseoutCalendarButton: function () {
    this.className = "DHTMLSuite_imageEnlarger_close";
  },
  __clearHTMLElement: function () {
    this.divElementImageBox.innerHTML = "";
  },
  __displayDivElement: function () {
    this.divElement.style.visibility = "hidden";
    if (this.isModal) this.transparentDiv.style.display = "block";
    if (this.iframeEl) this.iframeEl.style.display = "block";
  },
  __hideDivElement: function () {
    DHTMLSuite.discardElement(this.divElement);
    DHTMLSuite.discardElement(this.transparentDiv);
    this.divElement = false;
  },
  __resizeTransparentDiv: function () {
    const ind = this.objectIndex;
    if (!this.resizeTransparentAllowed) return;
    this.resizeTransparentAllowed = false;
    const divHeight = Math.max(
      DHTMLSuite.clientInfoObj.getBrowserHeight(),
      document.documentElement.scrollHeight
    );
    const divWidth = Math.max(
      DHTMLSuite.clientInfoObj.getBrowserWidth(),
      document.documentElement.scrollWidth
    );
    this.transparentDiv.style.width = divWidth + "px";
    this.transparentDiv.style.height = divHeight + "px";
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].resizeTransparentAllowed=true",
      10
    );
  },
  __addImageElement: function (imagePath) {
    const ind = this.objectIndex;
    const img = document.createElement("IMG");
    this.divElementImageBox.appendChild(img);
    img.onresize = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__repositionHTMLElement();
    };
    img.onload = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__repositionHTMLElement();
    };
    DHTMLSuite.commonObj.__addEventEl(img);
    img.src = imagePath;
  },
  __setCaptionText: function (title, description) {
    const ind = this.objectIndex;
    let txt = "";
    if (title) {
      txt =
        '<span class="DHTMLSuite_imageEnlarger_captionTitle">' +
        title +
        "</span>";
    }
    if (description) {
      txt =
        txt +
        '<span class="DHTMLSuite_imageEnlarger_captionDescription">' +
        description +
        "</span>";
    }
    if (this.closeLinkTxt) {
      txt =
        txt +
        '<a class="DHTMLSuite_imageEnlarger_closeLink" href="#" onclick="return DHTMLSuite.variableStorage.arrayDSObjects[' +
        ind +
        '].hide()">' +
        this.closeLinkTxt +
        "</a>";
    }
    this.captionDiv.innerHTML = txt;
  },
  __repositionHTMLElement: function (internalCall) {
    const ind = this.objectIndex;
    const imgs = this.divElementImageBox.getElementsByTagName("IMG");
    const img = imgs[0];
    this.divElementImageBox.style.width = img.width + "px";
    this.divElementImageBox.style.height = img.height + "px";
    this.divElement.style.width = this.divElInner.offsetWidth + "px";
    this.divElement.style.height = this.divElInner.offsetHeight + "px";
    this.divElInner.style.width = this.divElementImageBox.offsetWidth + "px";
    this.divElInner.style.height =
      this.divElementImageBox.offsetHeight +
      this.captionDiv.offsetHeight +
      "px";
    if (this.isDragable) {
      this.divElement.style.left =
        DHTMLSuite.clientInfoObj.getBrowserWidth() / 2 -
        this.divElement.offsetWidth / 2 +
        "px";
      this.divElement.style.top =
        DHTMLSuite.clientInfoObj.getBrowserHeight() / 2 -
        this.divElement.offsetHeight / 2 +
        "px";
      this.divElement.style.marginLeft = "0px";
      this.divElement.style.marginTop = "0px";
      this.divElement.style.cursor = "move";
    } else {
      this.divElement.style.marginLeft =
        Math.round((this.divElementImageBox.offsetWidth / 2) * -1) + "px";
      this.divElement.style.marginTop =
        Math.round((this.divElementImageBox.offsetHeight / 2) * -1) + "px";
    }
    if (this.iframeEl) {
      this.iframeEl.style.width = this.divElInner.style.width;
      this.iframeEl.style.height = this.divElInner.style.height;
    }
    if (!internalCall) {
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__repositionHTMLElement(true)",
        50
      );
    } else this.divElement.style.visibility = "visible";
  },
};
DHTMLSuite.calendarLanguageModel = function (languageCode) {
  let monthArray;
  let monthArrayShort;
  let dayArray;
  let weekString;
  let todayString;
  let todayIsString;
  let timeString;
  this.monthArray = new Array();
  this.monthArrayShort = new Array();
  this.dayArray = new Array();
  if (!languageCode) languageCode = "en";
  this.languageCode = languageCode;
  this.__setCalendarProperties();
};
DHTMLSuite.calendarLanguageModel.prototype = {
  __setCalendarProperties: function () {
    switch (this.languageCode) {
      case "ge":
        this.monthArray = [
          "Januar",
          "Februar",
          "März",
          "April",
          "Mai",
          "Juni",
          "Juli",
          "August",
          "September",
          "Oktober",
          "November",
          "Dezember",
        ];
        this.monthArrayShort = [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "Mai",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Okt",
          "Nov",
          "Dez",
        ];
        this.dayArray = ["Mon", "Die", "Mit", "Don", "Fre", "Sam", "Son"];
        this.weekString = "Woche";
        this.todayIsString = "Heute";
        this.todayString = "Heute";
        this.timeString = "";
        break;
      case "no":
        this.monthArray = [
          "Januar",
          "Februar",
          "Mars",
          "April",
          "Mai",
          "Juni",
          "Juli",
          "August",
          "September",
          "Oktober",
          "November",
          "Desember",
        ];
        this.monthArrayShort = [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "Mai",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Okt",
          "Nov",
          "Des",
        ];
        this.dayArray = [
          "Man",
          "Tir",
          "Ons",
          "Tor",
          "Fre",
          "L&oslash;r",
          "S&oslash;n",
        ];
        this.weekString = "Uke";
        this.todayIsString = "Dagen i dag er";
        this.todayString = "I dag";
        this.timeString = "Tid";
        break;
      case "nl":
        this.monthArray = [
          "Januari",
          "Februari",
          "Maart",
          "April",
          "Mei",
          "Juni",
          "Juli",
          "Augustus",
          "September",
          "Oktober",
          "November",
          "December",
        ];
        this.monthArrayShort = [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "Mei",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Okt",
          "Nov",
          "Dec",
        ];
        this.dayArray = ["Ma", "Di", "Wo", "Do", "Vr", "Za", "Zo"];
        this.weekString = "Week";
        this.todayIsString = "Vandaag";
        this.todayString = "Vandaag";
        this.timeString = "";
        break;
      case "es":
        this.monthArray = [
          "Enero",
          "Febrero",
          "Marzo",
          "April",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Septiembre",
          "Octubre",
          "Noviembre",
          "Diciembre",
        ];
        this.monthArrayShort = [
          "Ene",
          "Feb",
          "Mar",
          "Abr",
          "May",
          "Jun",
          "Jul",
          "Ago",
          "Sep",
          "Oct",
          "Nov",
          "Dic",
        ];
        this.dayArray = ["Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"];
        this.weekString = "Semana";
        this.todayIsString = "Hoy es";
        this.todayString = "Hoy";
        this.timeString = "";
        break;
      case "pt-br":
        this.monthArray = [
          "Janeiro",
          "Fevereiro",
          "Mar&ccedil;o",
          "Abril",
          "Maio",
          "Junho",
          "Julho",
          "Agosto",
          "Setembro",
          "Outubro",
          "Novembro",
          "Dezembro",
        ];
        this.monthArrayShort = [
          "Jan",
          "Fev",
          "Mar",
          "Abr",
          "Mai",
          "Jun",
          "Jul",
          "Ago",
          "Set",
          "Out",
          "Nov",
          "Dez",
        ];
        this.dayArray = [
          "Seg",
          "Ter",
          "Qua",
          "Qui",
          "Sex",
          "S&aacute;b",
          "Dom",
        ];
        this.weekString = "Sem.";
        this.todayIsString = "Hoje &eacute;";
        this.todayString = "Hoje";
        this.timeString = "";
        break;
      case "fr":
        this.monthArray = [
          "Janvier",
          "Février",
          "Mars",
          "Avril",
          "Mai",
          "Juin",
          "Juillet",
          "Août",
          "Septembre",
          "Octobre",
          "Novembre",
          "Décembre",
        ];
        this.monthArrayShort = [
          "Jan",
          "Fev",
          "Mar",
          "Avr",
          "Mai",
          "Jun",
          "Jul",
          "Aou",
          "Sep",
          "Oct",
          "Nov",
          "Dec",
        ];
        this.dayArray = ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"];
        this.weekString = "Sem";
        this.todayIsString = "Aujourd'hui";
        this.todayString = "Aujourd";
        this.timeString = "";
        break;
      case "da":
        this.monthArray = [
          "januar",
          "februar",
          "marts",
          "april",
          "maj",
          "juni",
          "juli",
          "august",
          "september",
          "oktober",
          "november",
          "december",
        ];
        this.monthArrayShort = [
          "jan",
          "feb",
          "mar",
          "apr",
          "maj",
          "jun",
          "jul",
          "aug",
          "sep",
          "okt",
          "nov",
          "dec",
        ];
        this.dayArray = [
          "man",
          "tirs",
          "ons",
          "tors",
          "fre",
          "l&oslash;r",
          "s&oslash;n",
        ];
        this.weekString = "Uge";
        this.todayIsString = "I dag er den";
        this.todayString = "I dag";
        this.timeString = "Tid";
        break;
      case "it":
        this.monthArray = [
          "Gennaio",
          "Febbraio",
          "Marzo",
          "Aprile",
          "Maggio",
          "Giugno",
          "Luglio",
          "Agosto",
          "Settembre",
          "Ottobre",
          "Novembre",
          "Dicembre",
        ];
        this.monthArrayShort = [
          "Gen",
          "Feb",
          "Mar",
          "Apr",
          "Mag",
          "Giu",
          "Lugl",
          "Ago",
          "Set",
          "Ott",
          "Nov",
          "Dic",
        ];
        this.dayArray = ["Lun", "Mar", "Mer", "Gio", "Ven", "Sab", "Dom"];
        this.weekString = "Sett";
        this.todayIsString = "Oggi &egrave;il";
        this.todayString = "Oggi &egrave;il";
        this.timeString = "";
        break;
      case "sv":
        this.monthArray = [
          "Januari",
          "Februari",
          "Mars",
          "April",
          "Maj",
          "Juni",
          "Juli",
          "Augusti",
          "September",
          "Oktober",
          "November",
          "December",
        ];
        this.monthArrayShort = [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "Maj",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Okt",
          "Nov",
          "Dec",
        ];
        this.dayArray = [
          "M&aring;n",
          "Tis",
          "Ons",
          "Tor",
          "Fre",
          "L&ouml;r",
          "S&ouml;n",
        ];
        this.weekString = "Vecka";
        this.todayIsString = "Idag &auml;r det den";
        this.todayString = "Idag &auml;r det den";
        this.timeString = "";
        break;
      default:
        this.monthArray = [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December",
        ];
        this.monthArrayShort = [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec",
        ];
        this.dayArray = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
        this.weekString = "Week";
        this.todayIsString = "";
        this.todayString = "Today";
        this.timeString = "Time";
        break;
    }
  },
};
DHTMLSuite.calendarModel = function (inputArray) {
  let initialDay;
  let initialMonth;
  let initialYear;
  let initialHour;
  let initialMinute;
  let displayedDay;
  let displayedMonth;
  let displayedYear;
  let displayedMinute;
  let displayedHour;
  let languageCode;
  let languageModel;
  let invalidDateRange;
  let weekStartsOnMonday;
  this.weekStartsOnMonday = true;
  this.languageCode = "en";
  this.invalidDateRange = new Array();
  this.__createDefaultModel(inputArray);
};
DHTMLSuite.calendarModel.prototype = {
  setCallbackFunctionOnMonthChange: function (functionName) {
    this.callbackFunctionOnMonthChange = functionName;
  },
  addInvalidDateRange: function (fromDateAsArray, toDateAsArray) {
    const index = this.invalidDateRange.length;
    this.invalidDateRange[index] = new Object();
    if (fromDateAsArray) {
      fromDateAsArray.day = String(fromDateAsArray.day);
      fromDateAsArray.month = String(fromDateAsArray.month);
      fromDateAsArray.year = String(fromDateAsArray.year);
      if (!fromDateAsArray.month) {
        fromDateAsArray.month = fromDateAsArray.month = "1";
      }
      if (!fromDateAsArray.day) fromDateAsArray.day = fromDateAsArray.day = "1";
      if (fromDateAsArray.day.length == 1) {
        fromDateAsArray.day = "0" + fromDateAsArray.day;
      }
      if (fromDateAsArray.month.length == 1) {
        fromDateAsArray.month = "0" + fromDateAsArray.month;
      }
      this.invalidDateRange[index].fromDate =
        fromDateAsArray.year + fromDateAsArray.month + fromDateAsArray.day;
    } else {
      this.invalidDateRange[index].fromDate = false;
    }
    if (toDateAsArray) {
      toDateAsArray.day = String(toDateAsArray.day);
      toDateAsArray.month = String(toDateAsArray.month);
      toDateAsArray.year = String(toDateAsArray.year);
      if (!toDateAsArray.month) toDateAsArray.month = toDateAsArray.month = "1";
      if (!toDateAsArray.day) toDateAsArray.day = toDateAsArray.day = "1";
      if (toDateAsArray.day.length == 1) {
        toDateAsArray.day = "0" + toDateAsArray.day;
      }
      if (toDateAsArray.month.length == 1) {
        toDateAsArray.month = "0" + toDateAsArray.month;
      }
      this.invalidDateRange[index].toDate =
        toDateAsArray.year + toDateAsArray.month + toDateAsArray.day;
    } else {
      this.invalidDateRange[index].toDate = false;
    }
  },
  isDateWithinValidRange: function (inputDate) {
    if (this.invalidDateRange.length == 0) return true;
    let month = String(inputDate.month);
    if (month.length == 1) month = "0" + month;
    let day = String(inputDate.day);
    if (day.length == 1) day = "0" + day;
    const dateToCheck = inputDate.year + month + day;
    for (let no = 0; no < this.invalidDateRange.length; no++) {
      if (
        !this.invalidDateRange[no].fromDate &&
        this.invalidDateRange[no].toDate >= dateToCheck
      ) {
        return false;
      }
      if (
        !this.invalidDateRange[no].toDate &&
        this.invalidDateRange[no].fromDate <= dateToCheck
      ) {
        return false;
      }
      if (
        this.invalidDateRange[no].fromDate <= dateToCheck &&
        this.invalidDateRange[no].toDate >= dateToCheck
      ) {
        return false;
      }
    }
    return true;
  },
  setInitialDateFromInput: function (inputReference, format) {
    if (inputReference.value.length > 0) {
      if (!format.match(/^[0-9]*?$/gi)) {
        const items = inputReference.value.split(/[^0-9]/gi);
        const positionArray = new Object();
        positionArray.m = format.indexOf("mm");
        if (positionArray.m == -1) positionArray.m = format.indexOf("m");
        positionArray.d = format.indexOf("dd");
        if (positionArray.d == -1) positionArray.d = format.indexOf("d");
        positionArray.y = format.indexOf("yyyy");
        positionArray.h = format.indexOf("hh");
        positionArray.i = format.indexOf("ii");
        let positionArrayNumeric = Array();
        positionArrayNumeric[0] = positionArray.m;
        positionArrayNumeric[1] = positionArray.d;
        positionArrayNumeric[2] = positionArray.y;
        positionArrayNumeric[3] = positionArray.h;
        positionArrayNumeric[4] = positionArray.i;
        positionArrayNumeric = positionArrayNumeric.sort(
          this.__calendarSortItems
        );
        let itemIndex = -1;
        this.initialHour = "00";
        this.initialMinute = "00";
        for (let no = 0; no < positionArrayNumeric.length; no++) {
          if (positionArrayNumeric[no] == -1) continue;
          itemIndex++;
          if (positionArrayNumeric[no] == positionArray.m) {
            this.initialMonth = items[itemIndex];
            continue;
          }
          if (positionArrayNumeric[no] == positionArray.y) {
            this.initialYear = items[itemIndex];
            continue;
          }
          if (positionArrayNumeric[no] == positionArray.d) {
            tmpDay = items[itemIndex];
            continue;
          }
          if (positionArrayNumeric[no] == positionArray.h) {
            this.initialHour = items[itemIndex];
            continue;
          }
          if (positionArrayNumeric[no] == positionArray.i) {
            this.initialMinute = items[itemIndex];
            continue;
          }
        }
        this.initialMonth = this.initialMonth / 1;
        tmpDay = tmpDay / 1;
        this.initialDay = tmpDay;
      } else {
        const monthPos = format.indexOf("mm");
        this.initialMonth = inputReference.value.substr(monthPos, 2) / 1;
        const yearPos = format.indexOf("yyyy");
        this.initialYear = inputReference.value.substr(yearPos, 4);
        const dayPos = format.indexOf("dd");
        tmpDay = inputReference.value.substr(dayPos, 2);
        this.initialDay = tmpDay;
        const hourPos = format.indexOf("hh");
        if (hourPos >= 0) {
          tmpHour = inputReference.value.substr(hourPos, 2);
          this.initialHour = tmpHour;
        } else {
          this.initialHour = "00";
        }
        const minutePos = format.indexOf("ii");
        if (minutePos >= 0) {
          tmpMinute = inputReference.value.substr(minutePos, 2);
          this.initialMinute = tmpMinute;
        } else {
          this.initialMinute = "00";
        }
      }
    }
    this.__setDisplayedDateToInitialData();
  },
  __setDisplayedDateToInitialData: function () {
    this.displayedYear = this.initialYear;
    this.displayedMonth = this.initialMonth;
    this.displayedDay = this.initialDay;
    this.displayedHour = this.initialHour;
    this.displayedMinute = this.initialMinute;
  },
  __calendarSortItems: function (a, b) {
    return a / 1 - b / 1;
  },
  setWeekStartsOnMonday: function (weekStartsOnMonday) {
    this.weekStartsOnMonday = weekStartsOnMonday;
  },
  setLanguageCode: function (languageCode) {
    this.languageModel = new DHTMLSuite.calendarLanguageModel(languageCode);
  },
  __isLeapYear: function (inputYear) {
    if (inputYear % 400 == 0 || (inputYear % 4 == 0 && inputYear % 100 != 0)) {
      return true;
    }
    return false;
  },
  getWeekStartsOnMonday: function () {
    return this.weekStartsOnMonday;
  },
  __createDefaultModel: function (inputArray) {
    const d = new Date();
    this.initialYear = d.getFullYear();
    this.initialMonth = d.getMonth() + 1;
    this.initialDay = d.getDate();
    this.initialHour = d.getHours();
    if (inputArray) {
      if (inputArray.initialYear) this.initialYear = inputArray.initialYear;
      if (inputArray.initialMonth) this.initialMonth = inputArray.initialMonth;
      if (inputArray.initialDay) this.initialDay = inputArray.initialDay;
      if (inputArray.initialHour) this.initialHour = inputArray.initialHour;
      if (inputArray.initialMinute) {
        this.initialMinute = inputArray.initialMinute;
      }
      if (inputArray.languageCode) this.languageCode = inputArray.languageCode;
    }
    this.displayedYear = this.initialYear;
    this.displayedMonth = this.initialMonth;
    this.displayedDay = this.initialDay;
    this.displayedHour = this.initialHour;
    this.displayedMinute = this.initialMinute;
    this.languageModel = new DHTMLSuite.calendarLanguageModel();
  },
  __getDisplayedDay: function () {
    return this.displayedDay;
  },
  __getDisplayedHourWithLeadingZeros: function () {
    let retVal = String(this.__getDisplayedHour());
    if (retVal.length == 1) retVal = "0" + retVal;
    return retVal;
  },
  __getDisplayedMinuteWithLeadingZeros: function () {
    let retVal = String(this.__getDisplayedMinute());
    if (retVal.length == 1) retVal = "0" + retVal;
    return retVal;
  },
  __getDisplayedDayWithLeadingZeros: function () {
    let retVal = String(this.__getDisplayedDay());
    if (retVal.length == 1) retVal = "0" + retVal;
    return retVal;
  },
  __getDisplayedMonthNumberWithLeadingZeros: function () {
    let retVal = String(this.__getDisplayedMonthNumber());
    if (retVal.length == 1) retVal = "0" + retVal;
    return retVal;
  },
  __getDisplayedYear: function () {
    return this.displayedYear;
  },
  __getDisplayedHour: function () {
    if (!this.displayedHour) this.displayedHour = 0;
    return this.displayedHour;
  },
  __getDisplayedMinute: function () {
    if (!this.displayedMinute) this.displayedMinute = 0;
    return this.displayedMinute;
  },
  __getDisplayedMonthNumber: function () {
    return this.displayedMonth;
  },
  __getInitialDay: function () {
    return this.initialDay;
  },
  __getInitialYear: function () {
    return this.initialYear;
  },
  __getInitialMonthNumber: function () {
    return this.initialMonth;
  },
  __getMonthNameByMonthNumber: function (monthNumber) {
    return this.languageModel.monthArray[monthNumber - 1];
  },
  __moveOneYearBack: function () {
    this.displayedYear--;
  },
  __moveOneYearForward: function () {
    this.displayedYear++;
  },
  __moveOneMonthBack: function () {
    this.displayedMonth--;
    if (this.displayedMonth < 1) {
      this.displayedMonth = 12;
      this.displayedYear--;
    }
  },
  __moveOneMonthForward: function () {
    this.displayedMonth++;
    if (this.displayedMonth > 12) {
      this.displayedMonth = 1;
      this.displayedYear++;
    }
  },
  __setDisplayedYear: function (year) {
    const success = year != this.displayedYear;
    this.displayedYear = year;
    return success;
  },
  __setDisplayedMonth: function (month) {
    const success = month != this.displayedMonth;
    this.displayedMonth = month;
    return success;
  },
  __setDisplayedDay: function (day) {
    this.displayedDay = day;
  },
  __setDisplayedHour: function (hour) {
    this.displayedHour = hour / 1;
  },
  __setDisplayedMinute: function (minute) {
    this.displayedMinute = minute / 1;
  },
  __getPreviousYearAndMonthAsArray: function () {
    let month = this.displayedMonth - 1;
    let year = this.displayedYear;
    if (month == 0) {
      month = 12;
      year = year - 1;
    }
    const retArray = [year, month];
    return retArray;
  },
  __getNumberOfDaysInCurrentDisplayedMonth: function () {
    return this.__getNumberOfDaysInAMonthByMonthAndYear(
      this.displayedYear,
      this.displayedMonth
    );
  },
  __getNumberOfDaysInAMonthByMonthAndYear: function (year, month) {
    const daysInMonthArray = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    let daysInMonth = daysInMonthArray[month - 1];
    if (daysInMonth == 28) {
      if (this.__isLeapYear(year)) daysInMonth = 29;
    }
    return daysInMonth / 1;
  },
  __getStringWeek: function () {
    return this.languageModel.weekString;
  },
  __getDaysMondayToSunday: function () {
    return this.languageModel.dayArray;
  },
  __getDaysSundayToSaturday: function () {
    const retArray = this.languageModel.dayArray.concat();
    const lastDay = new Array(retArray[retArray.length - 1]);
    retArray.pop();
    return lastDay.concat(retArray);
  },
  __getWeekNumberFromDayMonthAndYear: function (year, month, day) {
    day = day / 1;
    year = year / 1;
    month = month / 1;
    if (!this.weekStartsOnMonday) {
      return this.__getWeekNumberFromDayMonthAndYear_S(year, month, day);
    }
    const a = Math.floor((14 - month) / 12);
    const y = year + 4800 - a;
    const m = month + 12 * a - 3;
    const jd =
      day +
      Math.floor((153 * m + 2) / 5) +
      365 * y +
      Math.floor(y / 4) -
      Math.floor(y / 100) +
      Math.floor(y / 400) -
      32045;
    const d4 = (((jd + 31741 - (jd % 7)) % 146097) % 36524) % 1461;
    const L = Math.floor(d4 / 1460);
    const d1 = ((d4 - L) % 365) + L;
    NumberOfWeek = Math.floor(d1 / 7) + 1;
    return NumberOfWeek;
  },
  __getWeekNumberFromDayMonthAndYear_S: function (year, month, day) {
    month--;
    now = Date.UTC(year, month, day + 1, 0, 0, 0);
    const firstDay = new Date();
    firstDay.setYear(year);
    firstDay.setMonth(0);
    firstDay.setDate(1);
    then = Date.UTC(year, 0, 1, 0, 0, 0);
    let Compensation = firstDay.getDay();
    if (Compensation > 3) Compensation -= 4;
    else Compensation += 3;
    NumberOfWeek = Math.round(((now - then) / 86400000 + Compensation) / 7);
    return NumberOfWeek;
  },
  __getDayNumberFirstDayInYear: function (year) {
    const d = new Date();
    d.setFullYear(year);
    d.setDate(1);
    d.setMonth(0);
    return d.getDay();
  },
  __getRemainingDaysInPreviousMonthAsArray: function () {
    const d = new Date();
    d.setFullYear(this.displayedYear);
    d.setDate(1);
    d.setMonth(this.displayedMonth - 1);
    let dayStartOfMonth = d.getDay();
    if (this.weekStartsOnMonday) {
      if (dayStartOfMonth == 0) dayStartOfMonth = 7;
      dayStartOfMonth--;
    }
    const previousMonthArray = this.__getPreviousYearAndMonthAsArray();
    const daysInPreviousMonth = this.__getNumberOfDaysInAMonthByMonthAndYear(
      previousMonthArray[0],
      previousMonthArray[1]
    );
    const returnArray = new Array();
    for (let no = 0; no < dayStartOfMonth; no++) {
      returnArray[returnArray.length] =
        daysInPreviousMonth - dayStartOfMonth + no + 1;
    }
    return returnArray;
  },
  __getMonthNames: function () {
    return this.languageModel.monthArray;
  },
  __getTodayAsString: function () {
    return this.languageModel.todayString;
  },
  __getTimeAsString: function () {
    return this.languageModel.timeString;
  },
};
DHTMLSuite.calendar = function (propertyArray) {
  let id;
  let divElement;
  let divElContent;
  let divElHeading;
  let divElNavBar;
  let divElMonthView;
  let divElMonthNInHead;
  let divElYearInHeading;
  let divElBtnPreviousYear;
  let divElBtnNextYear;
  let divElBtnPrvMonth;
  let divElBtnNextMonth;
  let divElYearDropdown;
  let divElYearDropdownParentYears;
  let divElHourDropdownParentHours;
  let divElHourDropdown;
  let divElMinuteDropdownParent;
  let divElMinuteDropdown;
  let divElTodayInNavBar;
  let divElHrInTimeBar;
  let divElMinInTimeBar;
  let divElTimeStringInTimeBar;
  let iframeEl;
  let iframeElDropDowns;
  let calendarModelReference;
  let objectIndex;
  let targetReference;
  let layoutCSS;
  let isDragable;
  let referenceToDragDropObject;
  let scrollInYearDropDownActive;
  let scrollInHourDropDownActive;
  let scrollInMinuteDropDownActive;
  let yearDropDownOffsetInYear;
  let hourDropDownOffsetInHour;
  let minuteDropDownOffsetInHour;
  let displayCloseButton;
  let displayNavigationBar;
  let displayTodaysDateInNavigationBar;
  let displayTimeBar;
  let posRefToHtmlEl;
  let positioningOffsetXInPixels;
  let positioningOffsetYInPixels;
  let htmlElementReferences;
  let minuteDropDownInterval;
  let numberOfRowsInMinuteDropDown;
  let numberOfRowsInHourDropDown;
  let numberOfRowsInYearDropDown;
  this.displayTimeBar = false;
  this.minuteDropDownInterval = 5;
  this.htmlElementReferences = new Object();
  this.posRefToHtmlEl = false;
  this.displayCloseButton = true;
  this.displayNavigationBar = true;
  this.displayTodaysDateInNavigationBar = true;
  this.yearDropDownOffsetInYear = 0;
  this.hourDropDownOffsetInHour = 0;
  this.minuteDropDownOffsetInHour = 0;
  this.minuteDropDownOffsetInMinute = 0;
  this.layoutCSS = "calendar.css";
  this.isDragable = false;
  this.scrollInYearDropDownActive = false;
  this.scrollInHourDropDownActive = false;
  this.scrollInMinuteDropDownActive = false;
  this.numberOfRowsInMinuteDropDown = 10;
  this.numberOfRowsInHourDropDown = 10;
  this.numberOfRowsInYearDropDown = 10;
  let callbackFunctionOnDayClick;
  let callbackFunctionOnClose;
  let callbackFunctionOnMonthChange;
  let dateOfToday;
  this.dateOfToday = new Date();
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
  if (propertyArray) this.__setInitialData(propertyArray);
};
DHTMLSuite.calendar.prototype = {
  setCallbackFunctionOnDayClick: function (functionName) {
    this.callbackFunctionOnDayClick = functionName;
  },
  setCallbackFunctionOnMonthChange: function (functionName) {
    if (!this.calendarModelReference) {
      this.calendarModelReference = new DHTMLSuite.calendarModel();
    }
    this.callbackFunctionOnMonthChange = functionName;
  },
  setCallbackFunctionOnClose: function (functionName) {
    this.callbackFunctionOnClose = functionName;
  },
  setCalendarModelReference: function (calendarModelReference) {
    this.calendarModelReference = calendarModelReference;
  },
  setCalendarPositionByHTMLElement: function (
    refToHtmlEl,
    offsetXInPx,
    offsetYInPx
  ) {
    refToHtmlEl = DHTMLSuite.commonObj.getEl(refToHtmlEl);
    this.posRefToHtmlEl = refToHtmlEl;
    if (!offsetXInPx) offsetXInPx = 0;
    if (!offsetYInPx) offsetYInPx = 0;
    this.positioningOffsetXInPixels = offsetXInPx;
    this.positioningOffsetYInPixels = offsetYInPx;
  },
  addHtmlElementReference: function (key, referenceToHtmlEl) {
    referenceToHtmlEl = DHTMLSuite.commonObj.getEl(referenceToHtmlEl);
    if (key) {
      this.htmlElementReferences[key] = referenceToHtmlEl;
    }
  },
  getHtmlElementReferences: function () {
    return this.htmlElementReferences;
  },
  setDisplayCloseButton: function (displayCloseButton) {
    this.displayCloseButton = displayCloseButton;
  },
  setTargetReference: function (targetRef) {
    targetRef = DHTMLSuite.commonObj.getEl(targetRef);
    this.targetReference = targetRef;
  },
  setIsDragable: function (isDragable) {
    this.isDragable = isDragable;
  },
  resetViewDisplayedMonth: function () {
    if (!this.divElement) return;
    if (!this.calendarModelReference) {
      this.calendarModelReference = new DHTMLSuite.calendarModel();
    }
    this.calendarModelReference.__setDisplayedDateToInitialData();
    this.__populateCalHeading();
    this.__populateMonthView();
  },
  setLayoutCss: function (nameOfCssFile) {
    this.layoutCSS = nameOfCssFile;
  },
  __init: function () {
    if (!this.divElement) {
      DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
      if (!this.calendarModelReference) {
        this.calendarModelReference = new DHTMLSuite.calendarModel();
      }
      this.__createMainHtmlEls();
      this.__createHeadingElements();
      this.__createNavigationBar();
      this.__populateNavigationBar();
      this.__populateCalHeading();
      this.__createCalMonthView();
      this.__populateMonthView();
      this.__createTimeBar();
      this.__populateTimeBar();
      this.__createDropDownYears();
      this.__populateDropDownYears();
      this.__positionDropDownYears();
      this.__createDropDownMonth();
      this.__populateDropDownMonths();
      this.__positionDropDownMonths();
      this.__createDropDownHours();
      this.__populateDropDownHours();
      this.__positionDropDownHours();
      this.__createDropDownMinutes();
      this.__populateDropDownMinutes();
      this.__positionDropDownMinutes();
      this.__addEvents();
    } else {
      this.divElement.style.display = "block";
      this.__populateCalHeading();
      this.__populateMonthView();
    }
    this.__resizePrimaryiframeEl();
  },
  display: function () {
    if (!this.divElement) this.__init();
    this.__positionCalendar();
    this.divElement.style.display = "block";
    this.__resizePrimaryiframeEl();
  },
  hide: function () {
    if (this.__handleCalendarCallBack("calendarClose") === false) return false;
    this.divElement.style.display = "none";
    this.divElYearDropdown.style.display = "none";
    this.divElMonthDropdown.style.display = "none";
  },
  isVisible: function () {
    if (!this.divElement) return false;
    return this.divElement.style.display == "block";
  },
  setInitialDateFromInput: function (inputReference, format) {
    if (!this.calendarModelReference) {
      this.calendarModelReference = new DHTMLSuite.calendarModel();
    }
    this.calendarModelReference.setInitialDateFromInput(inputReference, format);
  },
  setDisplayedYear: function (year) {
    const success = this.calendarModelReference.__setDisplayedYear(year);
    this.__populateCalHeading();
    this.__populateMonthView();
    if (success) this.__handleCalendarCallBack("monthChange");
  },
  setDisplayedMonth: function (month) {
    const success = this.calendarModelReference.__setDisplayedMonth(month);
    this.__populateCalHeading();
    this.__populateMonthView();
    if (success) this.__handleCalendarCallBack("monthChange");
  },
  setDisplayedHour: function (hour) {
    this.calendarModelReference.__setDisplayedHour(hour);
    this.__populateTimeBar();
  },
  setDisplayedMinute: function (minute) {
    this.calendarModelReference.__setDisplayedMinute(minute);
    this.__populateTimeBar();
  },
  __createDropDownMonth: function () {
    this.divElMonthDropdown = document.createElement("DIV");
    this.divElMonthDropdown.style.display = "none";
    this.divElMonthDropdown.className = "DHTMLSuite_calendar_monthDropDown";
    document.body.appendChild(this.divElMonthDropdown);
  },
  __populateDropDownMonths: function () {
    this.divElMonthDropdown.innerHTML = "";
    const ind = this.objectIndex;
    const months = this.calendarModelReference.__getMonthNames();
    for (let no = 0; no < months.length; no++) {
      const div = document.createElement("DIV");
      div.className = "DHTMLSuite_calendar_dropDownAMonth";
      if (no + 1 == this.calendarModelReference.__getDisplayedMonthNumber()) {
        div.className = "DHTMLSuite_calendar_yearDropDownCurrentMonth";
      }
      div.innerHTML = months[no];
      div.id = "DHTMLSuite_calendarMonthPicker" + (no + 1);
      div.onmouseover = this.__mouseoverMonthInDropDown;
      div.onmouseout = this.__mouseoutMonthInDropDown;
      div.onclick = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__setMonthFromDropdown(
          e
        );
      };
      this.divElMonthDropdown.appendChild(div);
      DHTMLSuite.commonObj.__addEventEl(div);
    }
  },
  __createDropDownYears: function () {
    this.divElYearDropdown = document.createElement("DIV");
    this.divElYearDropdown.style.display = "none";
    this.divElYearDropdown.className = "DHTMLSuite_calendar_yearDropDown";
    document.body.appendChild(this.divElYearDropdown);
  },
  __createDropDownHours: function () {
    this.divElHourDropdown = document.createElement("DIV");
    this.divElHourDropdown.style.display = "none";
    this.divElHourDropdown.className = "DHTMLSuite_calendar_hourDropDown";
    document.body.appendChild(this.divElHourDropdown);
  },
  __createDropDownMinutes: function () {
    this.divElMinuteDropdown = document.createElement("DIV");
    this.divElMinuteDropdown.style.display = "none";
    this.divElMinuteDropdown.className = "DHTMLSuite_calendar_minuteDropDown";
    document.body.appendChild(this.divElMinuteDropdown);
  },
  __populateDropDownMinutes: function () {
    const ind = this.objectIndex;
    this.divElMinuteDropdown.innerHTML = "";
    const divPrevious = document.createElement("DIV");
    divPrevious.className = "DHTMLSuite_calendar_dropDown_arrowUp";
    divPrevious.onmouseover = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__mouseoverUpAndDownArrowsInDropDownMinutes(e);
    };
    divPrevious.onmouseout = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__mouseoutUpAndDownArrowsInDropDownMinutes(e);
    };
    this.divElMinuteDropdown.appendChild(divPrevious);
    DHTMLSuite.commonObj.__addEventEl(divPrevious);
    this.divElMinuteDropdownParent = document.createElement("DIV");
    this.divElMinuteDropdown.appendChild(this.divElMinuteDropdownParent);
    this.__populateMinutesInsideDropDownMinutes(this.divElMinuteDropdownParent);
    const divNext = document.createElement("DIV");
    divNext.className = "DHTMLSuite_calendar_dropDown_arrowDown";
    divNext.innerHTML = "<span></span>";
    divNext.onmouseover = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__mouseoverUpAndDownArrowsInDropDownMinutes(e);
    };
    divNext.onmouseout = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__mouseoutUpAndDownArrowsInDropDownMinutes(e);
    };
    DHTMLSuite.commonObj.__addEventEl(divNext);
    this.divElMinuteDropdown.appendChild(divNext);
    if (60 / this.minuteDropDownInterval < this.numberOfRowsInMinuteDropDown) {
      divPrevious.style.display = "none";
      divNext.style.display = "none";
    }
  },
  __populateMinutesInsideDropDownMinutes: function () {
    const ind = this.objectIndex;
    this.divElMinuteDropdownParent.innerHTML = "";
    if (60 / this.minuteDropDownInterval < this.numberOfRowsInMinuteDropDown) {
      startMinute = 0;
    } else {
      var startMinute = Math.max(
        0,
        this.calendarModelReference.__getDisplayedMinute() -
          Math.round(this.numberOfRowsInMinuteDropDown / 2)
      );
      startMinute +=
        this.minuteDropDownOffsetInMinute * this.minuteDropDownInterval;
      if (startMinute < 0) {
        startMinute += this.minuteDropDownInterval;
        this.minuteDropDownOffsetInMinute++;
      }
      if (
        startMinute +
          this.numberOfRowsInMinuteDropDown * this.minuteDropDownInterval >
        60
      ) {
        /* start minute in drop down+number of records shown*interval larger than 60-> adjust it */
        startMinute -= this.minuteDropDownInterval;
        this.minuteDropDownOffsetInMinute--;
      }
    }
    for (
      let no = startMinute;
      no <
      Math.min(
        60,
        startMinute +
          this.numberOfRowsInMinuteDropDown * this.minuteDropDownInterval
      );
      no += this.minuteDropDownInterval
    ) {
      const div = document.createElement("DIV");
      div.className = "DHTMLSuite_calendar_dropDownAMinute";
      if (no == this.calendarModelReference.__getDisplayedMinute()) {
        div.className = "DHTMLSuite_calendar_minuteDropDownCurrentMinute";
      }
      let prefix = "";
      if (no < 10) prefix = "0";
      div.innerHTML = prefix + no;
      div.onmouseover = this.__mouseoverMinuteInDropDown;
      div.onmouseout = this.__mouseoutMinuteInDropDown;
      div.onclick = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__setMinuteFromDropdown(
          e
        );
      };
      this.divElMinuteDropdownParent.appendChild(div);
      DHTMLSuite.commonObj.__addEventEl(div);
    }
  },
  __populateDropDownHours: function () {
    const ind = this.objectIndex;
    this.divElHourDropdown.innerHTML = "";
    var div = document.createElement("DIV");
    div.className = "DHTMLSuite_calendar_dropDown_arrowUp";
    div.onmouseover = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__mouseoverUpAndDownArrowsInDropDownHours(e);
    };
    div.onmouseout = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__mouseoutUpAndDownArrowsInDropDownHours(e);
    };
    this.divElHourDropdown.appendChild(div);
    DHTMLSuite.commonObj.__addEventEl(div);
    this.divElHourDropdownParentHours = document.createElement("DIV");
    this.divElHourDropdown.appendChild(this.divElHourDropdownParentHours);
    this.__populateHoursInsideDropDownHours(this.divElHourDropdownParentHours);
    var div = document.createElement("DIV");
    div.className = "DHTMLSuite_calendar_dropDown_arrowDown";
    div.innerHTML = "<span></span>";
    div.onmouseover = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__mouseoverUpAndDownArrowsInDropDownHours(e);
    };
    div.onmouseout = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__mouseoutUpAndDownArrowsInDropDownHours(e);
    };
    DHTMLSuite.commonObj.__addEventEl(div);
    this.divElHourDropdown.appendChild(div);
  },
  __populateHoursInsideDropDownHours: function () {
    const ind = this.objectIndex;
    this.divElHourDropdownParentHours.innerHTML = "";
    let startHour = Math.max(
      0,
      this.calendarModelReference.__getDisplayedHour() -
        Math.round(this.numberOfRowsInHourDropDown / 2)
    );
    startHour = Math.min(14, startHour);
    if (
      startHour +
        this.hourDropDownOffsetInHour +
        this.numberOfRowsInHourDropDown >
      24
    ) {
      this.hourDropDownOffsetInHour =
        24 - startHour - this.numberOfRowsInHourDropDown;
    }
    if (startHour + this.hourDropDownOffsetInHour < 0) {
      this.hourDropDownOffsetInHour = startHour * -1;
    }
    startHour += this.hourDropDownOffsetInHour;
    if (startHour < 0) startHour = 0;
    if (startHour > 24 - this.numberOfRowsInHourDropDown) {
      startHour = 24 - this.numberOfRowsInHourDropDown;
    }
    for (
      let no = startHour;
      no < startHour + this.numberOfRowsInHourDropDown;
      no++
    ) {
      const div = document.createElement("DIV");
      div.className = "DHTMLSuite_calendar_dropDownAnHour";
      if (no == this.calendarModelReference.__getDisplayedHour()) {
        div.className = "DHTMLSuite_calendar_hourDropDownCurrentHour";
      }
      let prefix = "";
      if (no < 10) prefix = "0";
      div.innerHTML = prefix + no;
      div.onmouseover = this.__mouseoverHourInDropDown;
      div.onmouseout = this.__mouseoutHourInDropDown;
      div.onclick = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__setHourFromDropdown(e);
      };
      this.divElHourDropdownParentHours.appendChild(div);
      DHTMLSuite.commonObj.__addEventEl(div);
    }
  },
  __populateDropDownYears: function () {
    const ind = this.objectIndex;
    this.divElYearDropdown.innerHTML = "";
    var div = document.createElement("DIV");
    div.className = "DHTMLSuite_calendar_dropDown_arrowUp";
    div.onmouseover = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__mouseoverUpAndDownArrowsInDropDownYears(e);
    };
    div.onmouseout = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__mouseoutUpAndDownArrowsInDropDownYears(e);
    };
    this.divElYearDropdown.appendChild(div);
    DHTMLSuite.commonObj.__addEventEl(div);
    this.divElYearDropdownParentYears = document.createElement("DIV");
    this.divElYearDropdown.appendChild(this.divElYearDropdownParentYears);
    this.__populateYearsInsideDropDownYears(this.divElYearDropdownParentYears);
    var div = document.createElement("DIV");
    div.className = "DHTMLSuite_calendar_dropDown_arrowDown";
    div.innerHTML = "<span></span>";
    div.onmouseover = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__mouseoverUpAndDownArrowsInDropDownYears(e);
    };
    div.onmouseout = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__mouseoutUpAndDownArrowsInDropDownYears(e);
    };
    DHTMLSuite.commonObj.__addEventEl(div);
    this.divElYearDropdown.appendChild(div);
  },
  __populateYearsInsideDropDownYears: function (divElementToPopulate) {
    const ind = this.objectIndex;
    this.divElYearDropdownParentYears.innerHTML = "";
    const startYear =
      this.calendarModelReference.__getDisplayedYear() -
      5 +
      this.yearDropDownOffsetInYear;
    for (
      let no = startYear;
      no < startYear + this.numberOfRowsInYearDropDown;
      no++
    ) {
      const div = document.createElement("DIV");
      div.className = "DHTMLSuite_calendar_dropDownAYear";
      if (no == this.calendarModelReference.__getDisplayedYear()) {
        div.className = "DHTMLSuite_calendar_yearDropDownCurrentYear";
      }
      div.innerHTML = no;
      div.onmouseover = this.__mouseoverYearInDropDown;
      div.onmouseout = this.__mouseoutYearInDropDown;
      div.onclick = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__setYearFromDropdown(e);
      };
      this.divElYearDropdownParentYears.appendChild(div);
      DHTMLSuite.commonObj.__addEventEl(div);
    }
  },
  __positionDropDownMonths: function () {
    this.divElMonthDropdown.style.left =
      DHTMLSuite.commonObj.getLeftPos(this.divElMonthNInHead) + "px";
    this.divElMonthDropdown.style.top =
      DHTMLSuite.commonObj.getTopPos(this.divElMonthNInHead) +
      this.divElMonthNInHead.offsetHeight +
      "px";
    if (this.iframeElDropDowns) {
      const st = this.iframeElDropDowns.style;
      st.left = this.divElMonthDropdown.style.left;
      st.top = this.divElMonthDropdown.style.top;
      st.width = this.divElMonthDropdown.clientWidth + "px";
      st.height = this.divElMonthDropdown.clientHeight + "px";
      st.display = this.divElMonthDropdown.style.display;
    }
  },
  __positionDropDownYears: function () {
    this.divElYearDropdown.style.left =
      DHTMLSuite.commonObj.getLeftPos(this.divElYearInHeading) + "px";
    this.divElYearDropdown.style.top =
      DHTMLSuite.commonObj.getTopPos(this.divElYearInHeading) +
      this.divElYearInHeading.offsetHeight +
      "px";
    if (this.iframeElDropDowns) {
      const st = this.iframeElDropDowns.style;
      st.left = this.divElYearDropdown.style.left;
      st.top = this.divElYearDropdown.style.top;
      st.width = this.divElYearDropdown.clientWidth + "px";
      st.height = this.divElYearDropdown.clientHeight + "px";
      st.display = this.divElYearDropdown.style.display;
    }
  },
  __positionDropDownHours: function () {
    this.divElHourDropdown.style.left =
      DHTMLSuite.commonObj.getLeftPos(this.divElHrInTimeBar) + "px";
    this.divElHourDropdown.style.top =
      DHTMLSuite.commonObj.getTopPos(this.divElHrInTimeBar) +
      this.divElHrInTimeBar.offsetHeight +
      "px";
    if (this.iframeElDropDowns) {
      const st = this.iframeElDropDowns.style;
      st.left = this.divElHourDropdown.style.left;
      st.top = this.divElHourDropdown.style.top;
      st.width = this.divElHourDropdown.clientWidth + "px";
      st.height = this.divElHourDropdown.clientHeight + "px";
      st.display = this.divElHourDropdown.style.display;
    }
  },
  __positionDropDownMinutes: function () {
    this.divElMinuteDropdown.style.left =
      DHTMLSuite.commonObj.getLeftPos(this.divElMinInTimeBar) + "px";
    this.divElMinuteDropdown.style.top =
      DHTMLSuite.commonObj.getTopPos(this.divElMinInTimeBar) +
      this.divElMinInTimeBar.offsetHeight +
      "px";
    if (this.iframeElDropDowns) {
      const st = this.iframeElDropDowns.style;
      st.left = this.divElMinuteDropdown.style.left;
      st.top = this.divElMinuteDropdown.style.top;
      st.width = this.divElMinuteDropdown.clientWidth + "px";
      st.height = this.divElMinuteDropdown.clientHeight + "px";
      st.display = this.divElMinuteDropdown.style.display;
    }
  },
  __setMonthFromDropdown: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    this.__showHideDropDownBoxMonth();
    this.setDisplayedMonth(src.id.replace(/[^0-9]/gi, ""));
  },
  __setYearFromDropdown: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    this.__showHideDropDownBoxYear();
    this.setDisplayedYear(src.innerHTML);
  },
  __setHourFromDropdown: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    this.__showHideDropDownBoxHour();
    this.setDisplayedHour(src.innerHTML);
  },
  __setMinuteFromDropdown: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    this.__showHideDropDownBoxMinute();
    this.setDisplayedMinute(src.innerHTML);
  },
  __autoHideDropDownBoxes: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    if (
      src.className.indexOf("MonthAndYear") >= 0 ||
      src.className.indexOf("HourAndMinute") >= 0
    ) {
      if (DHTMLSuite.commonObj.isObjectClicked(this.divElement, e)) return;
    }
    this.__showHideDropDownBoxMonth("none");
    this.__showHideDropDownBoxYear("none");
    this.__showHideDropDownBoxHour("none");
    this.__showHideDropDownBoxMinute("none");
  },
  __showHideDropDownBoxMonth: function (forcedDisplayAttribute) {
    if (!forcedDisplayAttribute) {
      this.__showHideDropDownBoxYear("none");
      this.__showHideDropDownBoxHour("none");
    }
    if (forcedDisplayAttribute) {
      this.divElMonthDropdown.style.display = forcedDisplayAttribute;
    } else {
      this.divElMonthDropdown.style.display =
        this.divElMonthDropdown.style.display == "block" ? "none" : "block";
    }
    this.__populateDropDownMonths();
    this.__positionDropDownMonths();
  },
  __showHideDropDownBoxYear: function (forcedDisplayAttribute) {
    if (!forcedDisplayAttribute) {
      this.__showHideDropDownBoxMonth("none");
      this.__showHideDropDownBoxHour("none");
      this.__showHideDropDownBoxMinute("none");
    }
    if (forcedDisplayAttribute) {
      this.divElYearDropdown.style.display = forcedDisplayAttribute;
    } else {
      this.divElYearDropdown.style.display =
        this.divElYearDropdown.style.display == "block" ? "none" : "block";
    }
    if (this.divElYearDropdown.style.display == "none") {
      this.yearDropDownOffsetInYear = 0;
    } else {
      this.__populateDropDownYears();
    }
    this.__positionDropDownYears();
  },
  __showHideDropDownBoxHour: function (forcedDisplayAttribute) {
    if (!forcedDisplayAttribute) {
      this.__showHideDropDownBoxYear("none");
      this.__showHideDropDownBoxMonth("none");
      this.__showHideDropDownBoxMinute("none");
    }
    if (forcedDisplayAttribute) {
      this.divElHourDropdown.style.display = forcedDisplayAttribute;
    } else {
      this.divElHourDropdown.style.display =
        this.divElHourDropdown.style.display == "block" ? "none" : "block";
    }
    if (this.divElHourDropdown.style.display == "none") {
      this.hourDropDownOffsetInHour = 0;
    } else {
      this.__populateDropDownHours();
    }
    this.__positionDropDownHours();
  },
  __showHideDropDownBoxMinute: function (forcedDisplayAttribute) {
    if (!forcedDisplayAttribute) {
      this.__showHideDropDownBoxYear("none");
      this.__showHideDropDownBoxMonth("none");
      this.__showHideDropDownBoxHour("none");
    }
    if (forcedDisplayAttribute) {
      this.divElMinuteDropdown.style.display = forcedDisplayAttribute;
    } else {
      this.divElMinuteDropdown.style.display =
        this.divElMinuteDropdown.style.display == "block" ? "none" : "block";
    }
    if (this.divElMinuteDropdown.style.display == "none") {
      this.minuteDropDownOffsetInMinute = 0;
    } else {
      this.__populateDropDownMinutes();
    }
    this.__positionDropDownMinutes();
  },
  __createMainHtmlEls: function () {
    this.divElement = document.createElement("DIV");
    this.divElement.className = "DHTMLSuite_calendar";
    this.divElContent = document.createElement("DIV");
    this.divElement.appendChild(this.divElContent);
    this.divElContent.className = "DHTMLSuite_calendarContent";
    if (this.targetReference) this.targetReference.appendChild(this.divElement);
    else document.body.appendChild(this.divElement);
    if (this.isDragable) {
      try {
        this.referenceToDragDropObject = new DHTMLSuite.dragDropSimple({
          elementReference: this.divElement,
        });
      } catch (e) {
        alert("Include DHTMLSuite-dragDropSimple.js for the drag feature");
      }
    }
    if (
      DHTMLSuite.clientInfoObj.isMSIE &&
      DHTMLSuite.clientInfoObj.navigatorVersion < 8
    ) {
      this.iframeEl = document.createElement(
        '<iframe src="about:blank" frameborder="0">'
      );
      this.iframeEl.className = "DHTMLSuite_calendar_iframe";
      this.iframeEl.style.left = "0px";
      this.iframeEl.style.top = "0px";
      this.iframeEl.style.position = "absolute";
      this.divElement.appendChild(this.iframeEl);
      this.iframeElDropDowns = document.createElement(
        '<iframe src="about:blank" frameborder="0">'
      );
      this.iframeElDropDowns.className = "DHTMLSuite_calendar_iframe";
      this.iframeElDropDowns.style.display = "none";
      document.body.appendChild(this.iframeElDropDowns);
    }
  },
  __createHeadingElements: function () {
    this.divElHeading = document.createElement("DIV");
    if (this.isDragable) {
      this.referenceToDragDropObject.addDragHandle(this.divElHeading);
      this.divElHeading.style.cursor = "move";
    }
    this.divElHeading.className = "DHTMLSuite_calendarHeading";
    this.divElContent.appendChild(this.divElHeading);
    this.divElHeading.style.position = "relative";
    this.divElClose = document.createElement("DIV");
    this.divElClose.innerHTML = "<span></span>";
    this.divElClose.className = "DHTMLSuite_calendarCloseButton";
    this.divElHeading.appendChild(this.divElClose);
    if (!this.displayCloseButton) this.divElClose.style.display = "none";
    this.divElHeadingTxt = document.createElement("DIV");
    this.divElHeadingTxt.className = "DHTMLSuite_calendarHeadingTxt";
    if (DHTMLSuite.clientInfoObj.isMSIE) {
      var table = document.createElement(
        '<TABLE cellpadding="0" cellspacing="0" border="0">'
      );
    } else {
      var table = document.createElement("TABLE");
      table.setAttribute("cellpadding", 0);
      table.setAttribute("cellspacing", 0);
      table.setAttribute("border", 0);
    }
    table.style.margin = "0 auto";
    const tbody = document.createElement("TBODY");
    table.appendChild(tbody);
    this.divElHeadingTxt.appendChild(table);
    const row = tbody.insertRow(0);
    var cell = row.insertCell(-1);
    this.divElMonthNInHead = document.createElement("DIV");
    this.divElMonthNInHead.className = "DHTMLSuite_calendarHeaderMonthAndYear";
    cell.appendChild(this.divElMonthNInHead);
    var cell = row.insertCell(-1);
    const span = document.createElement("SPAN");
    span.innerHTML = ",";
    cell.appendChild(span);
    var cell = row.insertCell(-1);
    this.divElYearInHeading = document.createElement("DIV");
    this.divElYearInHeading.className = "DHTMLSuite_calendarHeaderMonthAndYear";
    cell.appendChild(this.divElYearInHeading);
    this.divElHeading.appendChild(this.divElHeadingTxt);
  },
  __createNavigationBar: function () {
    this.divElNavBar = document.createElement("DIV");
    this.divElNavBar.className = "DHTMLSuite_calendar_navigationBar";
    this.divElContent.appendChild(this.divElNavBar);
    this.divElBtnPreviousYear = document.createElement("DIV");
    this.divElBtnPreviousYear.className = "DHTMLSuite_calendar_btnPreviousYear";
    this.divElBtnPreviousYear.innerHTML = "<span></span>";
    this.divElNavBar.appendChild(this.divElBtnPreviousYear);
    this.divElBtnNextYear = document.createElement("DIV");
    this.divElBtnNextYear.className = "DHTMLSuite_calendar_btnNextYear";
    this.divElBtnNextYear.innerHTML = "<span></span>";
    this.divElNavBar.appendChild(this.divElBtnNextYear);
    this.divElBtnPrvMonth = document.createElement("DIV");
    this.divElBtnPrvMonth.className = "DHTMLSuite_calendar_btnPreviousMonth";
    this.divElBtnPrvMonth.innerHTML = "<span></span>";
    this.divElNavBar.appendChild(this.divElBtnPrvMonth);
    this.divElBtnNextMonth = document.createElement("DIV");
    this.divElBtnNextMonth.className = "DHTMLSuite_calendar_btnNextMonth";
    this.divElBtnNextMonth.innerHTML = "<span></span>";
    this.divElNavBar.appendChild(this.divElBtnNextMonth);
    this.divElTodayInNavBar = document.createElement("DIV");
    this.divElTodayInNavBar.className =
      "DHTMLSuite_calendar_navigationBarToday";
    this.divElNavBar.appendChild(this.divElTodayInNavBar);
    if (!this.displayNavigationBar) this.divElNavBar.style.display = "none";
    if (!this.displayTodaysDateInNavigationBar) {
      this.divElTodayInNavBar.style.display = "none";
    }
  },
  __populateNavigationBar: function () {
    const ind = this.objectIndex;
    this.divElTodayInNavBar.innerHTML = "";
    const span = document.createElement("SPAN");
    span.innerHTML = this.calendarModelReference.__getTodayAsString();
    span.onclick = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__displayMonthOfToday();
    };
    this.divElTodayInNavBar.appendChild(span);
    DHTMLSuite.commonObj.__addEventEl(span);
  },
  __createCalMonthView: function () {
    this.divElMonthView = document.createElement("DIV");
    this.divElMonthView.className = "DHTMLSuite_calendar_monthView";
    this.divElContent.appendChild(this.divElMonthView);
  },
  __populateMonthView: function () {
    const ind = this.objectIndex;
    this.divElMonthView.innerHTML = "";
    const modelRef = this.calendarModelReference;
    if (DHTMLSuite.clientInfoObj.isMSIE) {
      var table = document.createElement(
        '<TABLE cellpadding="1" cellspacing="0" border="0" width="100%">'
      );
    } else {
      var table = document.createElement("TABLE");
      table.setAttribute("cellpadding", 1);
      table.setAttribute("cellspacing", 0);
      table.setAttribute("border", 0);
      table.width = "100%";
    }
    const tbody = document.createElement("TBODY");
    table.appendChild(tbody);
    this.divElMonthView.appendChild(table);
    var row = tbody.insertRow(-1);
    row.className = "DHTMLSuite_calendar_monthView_headerRow";
    var cell = row.insertCell(-1);
    cell.className = "DHTMLSuite_calendar_monthView_firstColumn";
    cell.innerHTML = modelRef.__getStringWeek();
    if (modelRef.getWeekStartsOnMonday()) {
      var days = modelRef.__getDaysMondayToSunday();
    } else {
      var days = modelRef.__getDaysSundayToSaturday();
    }
    for (var no = 0; no < days.length; no++) {
      var cell = row.insertCell(-1);
      cell.innerHTML = days[no];
      cell.className = "DHTMLSuite_calendar_monthView_headerCell";
      if (modelRef.getWeekStartsOnMonday() && no == 6) {
        cell.className = "DHTMLSuite_calendar_monthView_headerSunday";
      }
      if (!modelRef.getWeekStartsOnMonday() && no == 0) {
        cell.className = "DHTMLSuite_calendar_monthView_headerSunday";
      }
    }
    var row = tbody.insertRow(-1);
    var cell = row.insertCell(-1);
    cell.className = "DHTMLSuite_calendar_monthView_firstColumn";
    let week = modelRef.__getWeekNumberFromDayMonthAndYear(
      modelRef.__getDisplayedYear(),
      modelRef.__getDisplayedMonthNumber(),
      1
    );
    cell.innerHTML = week > 0 ? week : 53;
    const daysRemainingInPreviousMonth =
      modelRef.__getRemainingDaysInPreviousMonthAsArray();
    for (var no = 0; no < daysRemainingInPreviousMonth.length; no++) {
      var cell = row.insertCell(-1);
      cell.innerHTML = daysRemainingInPreviousMonth[no];
      cell.className = "DHTMLSuite_calendar_monthView_daysInOtherMonths";
    }
    const daysInCurrentMonth =
      modelRef.__getNumberOfDaysInCurrentDisplayedMonth();
    let cellCounter = daysRemainingInPreviousMonth.length + 1;
    for (var no = 1; no <= daysInCurrentMonth; no++) {
      var cell = row.insertCell(-1);
      cell.innerHTML = no;
      cell.className = "DHTMLSuite_calendar_monthView_daysInThisMonth";
      DHTMLSuite.commonObj.__addEventEl(cell);
      if (cellCounter % 7 == 0 && modelRef.getWeekStartsOnMonday()) {
        cell.className = "DHTMLSuite_calendar_monthView_sundayInThisMonth";
      }
      if (cellCounter % 7 == 1 && !modelRef.getWeekStartsOnMonday()) {
        cell.className = "DHTMLSuite_calendar_monthView_sundayInThisMonth";
      }
      if (
        no == modelRef.__getInitialDay() &&
        modelRef.__getDisplayedYear() == modelRef.__getInitialYear() &&
        modelRef.__getDisplayedMonthNumber() ==
          modelRef.__getInitialMonthNumber()
      ) {
        cell.className = "DHTMLSuite_calendar_monthView_initialDate";
      }
      if (
        !modelRef.isDateWithinValidRange({
          year: modelRef.__getDisplayedYear(),
          month: modelRef.__getDisplayedMonthNumber(),
          day: no,
        })
      ) {
        cell.className = "DHTMLSuite_calendar_monthView_invalidDate";
      } else {
        cell.onmousedown = function (e) {
          DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__mousedownOnDayInCalendar(e);
        };
        cell.onmouseover = this.__mouseoverCalendarDay;
        cell.onmouseout = this.__mouseoutCalendarDay;
        DHTMLSuite.commonObj.__addEventEl(cell);
      }
      if (
        no == this.dateOfToday.getDate() &&
        modelRef.__getDisplayedYear() == this.dateOfToday.getFullYear() &&
        modelRef.__getDisplayedMonthNumber() == this.dateOfToday.getMonth() + 1
      ) {
        cell.className = "DHTMLSuite_calendar_monthView_currentDate";
      }
      if (cellCounter % 7 == 0 && no < daysInCurrentMonth) {
        var row = tbody.insertRow(-1);
        var cell = row.insertCell(-1);
        cell.className = "DHTMLSuite_calendar_monthView_firstColumn";
        week++;
        cell.innerHTML = week;
      }
      cellCounter++;
    }
    if ((cellCounter - 1) % 7 > 0) {
      let dayCounter = 1;
      for (var no = (cellCounter - 1) % 7; no < 7; no++) {
        var cell = row.insertCell(-1);
        cell.innerHTML = dayCounter;
        cell.className = "DHTMLSuite_calendar_monthView_daysInOtherMonths";
        dayCounter++;
      }
    }
  },
  __createTimeBar: function () {
    this.divElTimeBar = document.createElement("DIV");
    this.divElTimeBar.className = "DHTMLSuite_calendar_timeBar";
    this.divElContent.appendChild(this.divElTimeBar);
    if (DHTMLSuite.clientInfoObj.isMSIE) {
      var table = document.createElement(
        '<TABLE cellpadding="0" cellspacing="0" border="0">'
      );
    } else {
      var table = document.createElement("TABLE");
      table.setAttribute("cellpadding", 0);
      table.setAttribute("cellspacing", 0);
      table.setAttribute("border", 0);
    }
    table.style.margin = "0 auto";
    this.divElTimeBar.appendChild(table);
    const row = table.insertRow(0);
    var cell = row.insertCell(-1);
    this.divElHrInTimeBar = document.createElement("DIV");
    this.divElHrInTimeBar.className =
      "DHTMLSuite_calendar_timeBarHourAndMinute";
    cell.appendChild(this.divElHrInTimeBar);
    var cell = row.insertCell(-1);
    const span = document.createElement("SPAN");
    span.innerHTML = ":";
    cell.appendChild(span);
    var cell = row.insertCell(-1);
    this.divElMinInTimeBar = document.createElement("DIV");
    this.divElMinInTimeBar.className =
      "DHTMLSuite_calendar_timeBarHourAndMinute";
    cell.appendChild(this.divElMinInTimeBar);
    this.divElTimeStringInTimeBar = document.createElement("DIV");
    this.divElTimeStringInTimeBar.className =
      "DHTMLSuite_calendarTimeBarTimeString";
    this.divElTimeBar.appendChild(this.divElTimeStringInTimeBar);
    if (!this.displayTimeBar) this.divElTimeBar.style.display = "none";
  },
  __populateTimeBar: function () {
    this.divElHrInTimeBar.innerHTML =
      this.calendarModelReference.__getDisplayedHourWithLeadingZeros();
    this.divElMinInTimeBar.innerHTML =
      this.calendarModelReference.__getDisplayedMinuteWithLeadingZeros();
    this.divElTimeStringInTimeBar.innerHTML =
      this.calendarModelReference.__getTimeAsString() + ":";
  },
  __populateCalHeading: function () {
    this.divElMonthNInHead.innerHTML =
      this.calendarModelReference.__getMonthNameByMonthNumber(
        this.calendarModelReference.__getDisplayedMonthNumber()
      );
    this.divElYearInHeading.innerHTML =
      this.calendarModelReference.__getDisplayedYear();
  },
  __mousedownOnDayInCalendar: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    this.calendarModelReference.__setDisplayedDay(src.innerHTML);
    this.__handleCalendarCallBack("dayClick");
  },
  __handleCalendarCallBack: function (action) {
    let callbackString = "";
    switch (action) {
      case "dayClick":
        if (this.callbackFunctionOnDayClick) {
          callbackString = this.callbackFunctionOnDayClick;
        }
        break;
      case "monthChange":
        if (this.callbackFunctionOnMonthChange) {
          callbackString = this.callbackFunctionOnMonthChange;
        }
        break;
      case "calendarClose":
        if (this.callbackFunctionOnClose) {
          callbackString = this.callbackFunctionOnClose;
        }
        break;
    }
    if (callbackString) {
      callbackString =
        callbackString +
        "({" +
        " year:" +
        this.calendarModelReference.__getDisplayedYear() +
        ',month:"' +
        this.calendarModelReference.__getDisplayedMonthNumberWithLeadingZeros() +
        '"' +
        ',day:"' +
        this.calendarModelReference.__getDisplayedDayWithLeadingZeros() +
        '"' +
        ',hour:"' +
        this.calendarModelReference.__getDisplayedHourWithLeadingZeros() +
        '"' +
        ',minute:"' +
        this.calendarModelReference.__getDisplayedMinuteWithLeadingZeros() +
        '"' +
        ",calendarRef:this";
      callbackString = callbackString + "})";
    }
    if (callbackString) return this.__evaluateCallBackString(callbackString);
  },
  __evaluateCallBackString: function (callbackString) {
    try {
      return eval(callbackString);
    } catch (e) {
      alert(
        "Could not excute call back function " +
          callbackString +
          "\n" +
          e.message
      );
    }
  },
  __displayMonthOfToday: function () {
    const d = new Date();
    const month = d.getMonth() + 1;
    const year = d.getFullYear();
    this.setDisplayedYear(year);
    this.setDisplayedMonth(month);
  },
  __moveOneYearBack: function () {
    this.calendarModelReference.__moveOneYearBack();
    this.__populateCalHeading();
    this.__populateMonthView();
    this.__handleCalendarCallBack("monthChange");
  },
  __moveOneYearForward: function () {
    this.calendarModelReference.__moveOneYearForward();
    this.__populateCalHeading();
    this.__populateMonthView();
    this.__handleCalendarCallBack("monthChange");
  },
  __moveOneMonthBack: function () {
    this.calendarModelReference.__moveOneMonthBack();
    this.__populateCalHeading();
    this.__populateMonthView();
    this.__handleCalendarCallBack("monthChange");
  },
  __moveOneMonthForward: function () {
    this.calendarModelReference.__moveOneMonthForward();
    this.__populateCalHeading();
    this.__populateMonthView();
    this.__handleCalendarCallBack("monthChange");
  },
  __addEvents: function () {
    const ind = this.objectIndex;
    this.divElClose.onmouseover = this.__mouseoverCalendarButton;
    this.divElClose.onmouseout = this.__mouseoutCalendarButton;
    this.divElClose.onclick = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].hide();
    };
    DHTMLSuite.commonObj.__addEventEl(this.divElClose);
    this.divElBtnPreviousYear.onmouseover = this.__mouseoverCalendarButton;
    this.divElBtnPreviousYear.onmouseout = this.__mouseoutCalendarButton;
    this.divElBtnPreviousYear.onclick = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOneYearBack();
    };
    DHTMLSuite.commonObj.__addEventEl(this.divElBtnPreviousYear);
    this.divElBtnNextYear.onmouseover = this.__mouseoverCalendarButton;
    this.divElBtnNextYear.onmouseout = this.__mouseoutCalendarButton;
    this.divElBtnNextYear.onclick = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOneYearForward();
    };
    DHTMLSuite.commonObj.__addEventEl(this.divElBtnNextYear);
    this.divElBtnPrvMonth.onmouseover = this.__mouseoverCalendarButton;
    this.divElBtnPrvMonth.onmouseout = this.__mouseoutCalendarButton;
    this.divElBtnPrvMonth.onclick = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOneMonthBack();
    };
    DHTMLSuite.commonObj.__addEventEl(this.divElBtnPrvMonth);
    this.divElBtnNextMonth.onmouseover = this.__mouseoverCalendarButton;
    this.divElBtnNextMonth.onmouseout = this.__mouseoutCalendarButton;
    this.divElBtnNextMonth.onclick = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOneMonthForward();
    };
    DHTMLSuite.commonObj.__addEventEl(this.divElBtnNextMonth);
    this.divElYearInHeading.onmouseover = this.__mouseoverMonthAndYear;
    this.divElYearInHeading.onmouseout = this.__mouseoutMonthAndYear;
    this.divElYearInHeading.onclick = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__showHideDropDownBoxYear();
    };
    DHTMLSuite.commonObj.__addEventEl(this.divElYearInHeading);
    this.divElMonthNInHead.onmouseover = this.__mouseoverMonthAndYear;
    this.divElMonthNInHead.onmouseout = this.__mouseoutMonthAndYear;
    this.divElMonthNInHead.onclick = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__showHideDropDownBoxMonth();
    };
    DHTMLSuite.commonObj.__addEventEl(this.divElMonthNInHead);
    this.divElHrInTimeBar.onmouseover = this.__mouseoverHourAndMinute;
    this.divElHrInTimeBar.onmouseout = this.__mouseoutHourAndMinute;
    this.divElHrInTimeBar.onclick = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__showHideDropDownBoxHour();
    };
    DHTMLSuite.commonObj.__addEventEl(this.divElHrInTimeBar);
    this.divElMinInTimeBar.onmouseover = this.__mouseoverHourAndMinute;
    this.divElMinInTimeBar.onmouseout = this.__mouseoutHourAndMinute;
    this.divElMinInTimeBar.onclick = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__showHideDropDownBoxMinute();
    };
    DHTMLSuite.commonObj.__addEventEl(this.divElMinInTimeBar);
    this.divElHeading.onselectstart = function () {
      return false;
    };
    DHTMLSuite.commonObj.__addEventEl(this.divElHeading);
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "click",
      function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__autoHideDropDownBoxes(
          e
        );
      },
      String(ind)
    );
  },
  __resizePrimaryiframeEl: function () {
    if (!this.iframeEl) return;
    this.iframeEl.style.width = this.divElement.clientWidth + "px";
    this.iframeEl.style.height = this.divElement.clientHeight + "px";
  },
  __scrollInYearDropDown: function (scrollDirection) {
    if (!this.scrollInYearDropDownActive) return;
    const ind = this.objectIndex;
    this.yearDropDownOffsetInYear += scrollDirection;
    this.__populateYearsInsideDropDownYears();
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__scrollInYearDropDown(" +
        scrollDirection +
        ")",
      150
    );
  },
  __mouseoverUpAndDownArrowsInDropDownYears: function (e) {
    const ind = this.objectIndex;
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    const scrollDirection =
      src.className.toLowerCase().indexOf("up") >= 0 ? -1 : 1;
    src.className =
      src.className + " DHTMLSuite_calendarDropDown_dropDownArrowOver";
    this.scrollInYearDropDownActive = true;
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__scrollInYearDropDown(" +
        scrollDirection +
        ")",
      100
    );
  },
  __mouseoutUpAndDownArrowsInDropDownYears: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    src.className = src.className.replace(
      " DHTMLSuite_calendarDropDown_dropDownArrowOver",
      ""
    );
    this.scrollInYearDropDownActive = false;
  },
  __scrollInHourDropDown: function (scrollDirection) {
    if (!this.scrollInHourDropDownActive) return;
    const ind = this.objectIndex;
    this.hourDropDownOffsetInHour += scrollDirection;
    this.__populateHoursInsideDropDownHours();
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__scrollInHourDropDown(" +
        scrollDirection +
        ")",
      150
    );
  },
  __mouseoverUpAndDownArrowsInDropDownHours: function (e) {
    const ind = this.objectIndex;
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    const scrollDirection =
      src.className.toLowerCase().indexOf("up") >= 0 ? -1 : 1;
    src.className =
      src.className + " DHTMLSuite_calendarDropDown_dropDownArrowOver";
    this.scrollInHourDropDownActive = true;
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__scrollInHourDropDown(" +
        scrollDirection +
        ")",
      100
    );
  },
  __mouseoutUpAndDownArrowsInDropDownHours: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    src.className = src.className.replace(
      " DHTMLSuite_calendarDropDown_dropDownArrowOver",
      ""
    );
    this.scrollInHourDropDownActive = false;
  },
  __scrollInMinuteDropDown: function (scrollDirection) {
    if (!this.scrollInMinuteDropDownActive) return;
    const ind = this.objectIndex;
    this.minuteDropDownOffsetInMinute += scrollDirection;
    this.__populateMinutesInsideDropDownMinutes();
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__scrollInMinuteDropDown(" +
        scrollDirection +
        ")",
      150
    );
  },
  __mouseoverUpAndDownArrowsInDropDownMinutes: function (e) {
    const ind = this.objectIndex;
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    const scrollDirection =
      src.className.toLowerCase().indexOf("up") >= 0 ? -1 : 1;
    src.className =
      src.className + " DHTMLSuite_calendarDropDown_dropDownArrowOver";
    this.scrollInMinuteDropDownActive = true;
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__scrollInMinuteDropDown(" +
        scrollDirection +
        ")",
      100
    );
  },
  __mouseoutUpAndDownArrowsInDropDownMinutes: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    src.className = src.className.replace(
      " DHTMLSuite_calendarDropDown_dropDownArrowOver",
      ""
    );
    this.scrollInMinuteDropDownActive = false;
  },
  __mouseoverYearInDropDown: function () {
    this.className = this.className + " DHTMLSuite_calendar_dropdownAYearOver";
  },
  __mouseoutYearInDropDown: function () {
    this.className = this.className.replace(
      " DHTMLSuite_calendar_dropdownAYearOver",
      ""
    );
  },
  __mouseoverHourInDropDown: function () {
    this.className = this.className + " DHTMLSuite_calendar_dropdownAnHourOver";
  },
  __mouseoutHourInDropDown: function () {
    this.className = this.className.replace(
      " DHTMLSuite_calendar_dropdownAnHourOver",
      ""
    );
  },
  __mouseoverMinuteInDropDown: function () {
    this.className =
      this.className + " DHTMLSuite_calendar_dropdownAMinuteOver";
  },
  __mouseoutMinuteInDropDown: function () {
    this.className = this.className.replace(
      " DHTMLSuite_calendar_dropdownAMinuteOver",
      ""
    );
  },
  __mouseoverMonthInDropDown: function () {
    this.className = this.className + " DHTMLSuite_calendar_dropdownAMonthOver";
  },
  __mouseoutMonthInDropDown: function () {
    this.className = this.className.replace(
      " DHTMLSuite_calendar_dropdownAMonthOver",
      ""
    );
  },
  __mouseoverCalendarDay: function () {
    this.className = this.className + " DHTMLSuite_calendarDayOver";
  },
  __mouseoutCalendarDay: function () {
    this.className = this.className.replace(" DHTMLSuite_calendarDayOver", "");
  },
  __mouseoverCalendarButton: function () {
    this.className = this.className + " DHTMLSuite_calendarButtonOver";
  },
  __mouseoutCalendarButton: function () {
    this.className = this.className.replace(
      " DHTMLSuite_calendarButtonOver",
      ""
    );
  },
  __mouseoverMonthAndYear: function () {
    this.className =
      this.className + " DHTMLSuite_calendarHeaderMonthAndYearOver";
  },
  __mouseoutMonthAndYear: function () {
    this.className = this.className.replace(
      " DHTMLSuite_calendarHeaderMonthAndYearOver",
      ""
    );
  },
  __mouseoverHourAndMinute: function () {
    this.className =
      this.className + " DHTMLSuite_calendarTimeBarHourAndMinuteOver";
  },
  __mouseoutHourAndMinute: function () {
    this.className = this.className.replace(
      " DHTMLSuite_calendarTimeBarHourAndMinuteOver",
      ""
    );
  },
  __positionCalendar: function () {
    if (!this.posRefToHtmlEl) return;
    if (this.divElement.parentNode != document.body) {
      document.body.appendChild(this.divElement);
    }
    this.divElement.style.position = "absolute";
    this.divElement.style.left =
      DHTMLSuite.commonObj.getLeftPos(this.posRefToHtmlEl) +
      this.positioningOffsetXInPixels +
      "px";
    this.divElement.style.top =
      DHTMLSuite.commonObj.getTopPos(this.posRefToHtmlEl) +
      this.positioningOffsetYInPixels +
      "px";
  },
  __setInitialData: function (props) {
    if (props.id) this.id = props.id;
    if (props.targetReference) this.targetReference = props.targetReference;
    if (props.calendarModelReference) {
      this.calendarModelReference = props.calendarModelReference;
    }
    if (props.callbackFunctionOnDayClick) {
      this.callbackFunctionOnDayClick = props.callbackFunctionOnDayClick;
    }
    if (props.callbackFunctionOnMonthChange) {
      this.callbackFunctionOnMonthChange = props.callbackFunctionOnMonthChange;
    }
    if (props.callbackFunctionOnClose) {
      this.callbackFunctionOnClose = props.callbackFunctionOnClose;
    }
    if (props.displayCloseButton || props.displayCloseButton === false) {
      this.displayCloseButton = props.displayCloseButton;
    }
    if (props.displayNavigationBar || props.displayNavigationBar === false) {
      this.displayNavigationBar = props.displayNavigationBar;
    }
    if (
      props.displayTodaysDateInNavigationBar ||
      props.displayTodaysDateInNavigationBar === false
    ) {
      this.displayTodaysDateInNavigationBar =
        props.displayTodaysDateInNavigationBar;
    }
    if (props.minuteDropDownInterval) {
      this.minuteDropDownInterval = props.minuteDropDownInterval;
    }
    if (props.numberOfRowsInHourDropDown) {
      this.numberOfRowsInHourDropDown = props.numberOfRowsInHourDropDown;
    }
    if (props.numberOfRowsInMinuteDropDown) {
      this.numberOfRowsInHourDropDown = props.numberOfRowsInMinuteDropDown;
    }
    if (props.numberOfRowsInYearDropDown) {
      this.numberOfRowsInYearDropDown = props.numberOfRowsInYearDropDown;
    }
    if (props.isDragable || props.isDragable === false) {
      this.isDragable = props.isDragable;
    }
    if (props.displayTimeBar || props.displayTimeBar === false) {
      this.displayTimeBar = props.displayTimeBar;
    }
  },
};
DHTMLSuite.windowModel = function (arrayOfProperties) {
  let id;
  let title;
  let icon;
  let isDragable;
  let isResizable;
  let isMinimizable;
  let isClosable;
  let xPos;
  let yPos;
  let width;
  let height;
  let cookieName;
  let state;
  let activeTabId;
  let tabsVisible;
  let zIndex;
  let minWidth;
  let maxWidth;
  let minHeight;
  let maxHeight;
  let isVisible;
  let callbackOnClose;
  let windowsTheme;
  let windowContents;
  this.windowContents = new Array();
  this.isDragable = true;
  this.isMinimizable = true;
  this.isResizable = true;
  this.isClosable = true;
  this.windowsTheme = false;
  this.isVisible = true;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file\n" + e.message);
  }
  if (arrayOfProperties) this.__setInitialWindowProperties(arrayOfProperties);
};
DHTMLSuite.windowModel.prototype = {
  createWindowModelFromMarkUp: function (referenceToHTMLElement) {
    referenceToHTMLElement = DHTMLSuite.commonObj.getEl(referenceToHTMLElement);
    if (!referenceToHTMLElement) {
      alert(
        "Error in windowModel class-Could not get a reference to element " +
          referenceToHTMLElement
      );
      return;
    }
    this.id = referenceToHTMLElement.id;
    let properties = referenceToHTMLElement.getAttribute("windowProperties");
    if (!properties) properties = referenceToHTMLElement.windowProperties;
    this.__setInitialWindowProperties(
      DHTMLSuite.commonObj.getAssociativeArrayFromString(properties)
    );
    const subDivs = referenceToHTMLElement.getElementsByTagName("DIV");
    for (let no = 0; no < subDivs.length; no++) {
      if (subDivs[no].className.toLowerCase() == "dhtmlsuite_windowcontent") {
        const index = this.windowContents.length;
        this.windowContents[index] = new DHTMLSuite.windowTabModel();
        this.windowContents[index].__createContentModelFromHTMLElement(
          subDivs[no]
        );
      }
    }
  },
  __setInitialWindowProperties: function (props) {
    if (props.isClosable) props.isClosable = eval(props.isClosable);
    if (props.isDragable) props.isDragable = eval(props.isDragable);
    if (props.isResizable) props.isResizable = eval(props.isResizable);
    if (props.isMinimizable) props.isMinimizable = eval(props.isMinimizable);
    if (props.isVisible) props.isVisible = eval(props.isVisible);
    if (props.cookieName) this.cookieName = props.cookieName;
    if (props.title) this.title = props.title;
    if (props.icon) this.icon = props.icon;
    if (props.width) this.width = props.width;
    if (props.height) this.height = props.height;
    if (
      props.isMinimizable ||
      props.isMinimizable === false ||
      props.isMinimizable === 0
    ) {
      this.isMinimizable = props.isMinimizable;
    }
    if (props.isClosable || props.isClosable == false) {
      this.isClosable = props.isClosable;
    }
    if (props.state) this.state = props.state;
    if (props.xPos) this.xPos = props.xPos;
    if (props.yPos) this.yPos = props.yPos;
    if (props.activeTabId) this.activeTabId = props.activeTabId;
    if (props.minWidth) this.minWidth = props.minWidth;
    if (props.maxWidth) this.maxWidth = props.maxWidth;
    if (props.minHeight) this.minHeight = props.minHeight;
    if (props.maxHeight) this.maxHeight = props.maxHeight;
    if (props.windowsTheme) this.windowsTheme = props.windowsTheme;
    if (props.callbackOnClose) this.callbackOnClose = props.callbackOnClose;
    if (props.isResizable || props.isResizable == false) {
      this.isResizable = props.isResizable;
    }
    if (props.isDragable || props.isDragable == false) {
      this.isDragable = props.isDragable;
    }
    if (props.isVisible || props.isVisible == false) {
      this.isVisible = props.isVisible;
    }
  },
  __getTitle: function () {
    return this.title;
  },
  __getContentObjects: function () {
    return this.windowContents;
  },
  __setActiveTabIdAutomatically: function () {
    for (let no = 0; no < this.windowContents.length; no++) {
      if (!this.windowContents[no].isDeleted) {
        this.activeTabId = this.windowContents[no].id;
        return;
      }
    }
  },
  __setContentUrl: function (contentId, url) {
    for (let no = 0; no < this.windowContents.length; no++) {
      if (this.windowContents[no].id == contentId) {
        this.windowContents[no].__setContentUrl(url);
        return true;
      }
    }
    return false;
  },
  __getContentObjectById: function (contentId) {
    for (let no = 0; no < this.windowContents.length; no++) {
      if (this.windowContents[no].id == contentId) {
        return this.windowContents[no];
      }
    }
    return false;
  },
  __setWidth: function (newWidth) {
    if (this.minWidth && newWidth / 1 < this.minWidth / 1) {
      newWidth = this.minWidth;
    }
    if (this.maxWidth && newWidth / 1 > this.maxWidth / 1) {
      newWidth = this.maxWidth;
    }
    this.width = newWidth;
  },
  __setHeight: function (newHeight) {
    if (this.minHeight && newHeight / 1 < this.minHeight / 1) {
      newHeight = this.minHeight;
    }
    if (this.maxHeight && newHeight / 1 > this.maxHeight / 1) {
      newHeight = this.maxHeight;
    }
    this.height = newHeight;
  },
  __setXPos: function (newXPos) {
    if (newXPos > DHTMLSuite.clientInfoObj.getBrowserWidth()) {
      newXPos = DHTMLSuite.clientInfoObj.getBrowserWidth() - 30;
    }
    this.xPos = newXPos;
  },
  __setYPos: function (newYPos) {
    if (newYPos > DHTMLSuite.clientInfoObj.getBrowserHeight()) {
      newYPos = DHTMLSuite.clientInfoObj.getBrowserHeight() - 30;
    }
    this.yPos = newYPos;
  },
  __setActiveTabId: function (newActiveTabId) {
    const index = this.__getIndexOfTabById(newActiveTabId);
    if (index !== false && !this.__getIsDeleted(newActiveTabId)) {
      this.activeTabId = newActiveTabId;
      return;
    }
    this.__setActiveTabIdAutomatically();
  },
  __setZIndex: function (zIndex) {
    this.zIndex = zIndex;
  },
  __setState: function (state) {
    this.state = state;
  },
  __getWidth: function () {
    return this.width;
  },
  __getHeight: function () {
    return this.height;
  },
  __getXPos: function () {
    if (this.xPos > DHTMLSuite.clientInfoObj.getBrowserWidth()) {
      xPos = DHTMLSuite.clientInfoObj.getBrowserWidth() - 30;
    }
    return this.xPos;
  },
  __getYPos: function () {
    return this.yPos;
  },
  __getActiveTabId: function () {
    return this.activeTabId;
  },
  __getZIndex: function () {
    if (!this.zIndex) return 0;
    return this.zIndex;
  },
  __getState: function () {
    return this.state;
  },
  __deleteTab: function (idOfTab) {
    const index = this.__getIndexOfTabById(idOfTab);
    if (index !== false) {
      this.windowContents[index].__setDeleted(true);
      return true;
    }
    return false;
  },
  __restoreTab: function (idOfTab) {
    const index = this.__getIndexOfTabById(idOfTab);
    if (index !== false) {
      this.windowContents[index].__setDeleted(false);
      return true;
    }
    return false;
  },
  __getIndexOfTabById: function (idOfTab) {
    for (let no = 0; no < this.windowContents.length; no++) {
      if (this.windowContents[no].id == idOfTab) return no;
    }
    return false;
  },
  __getIsDeleted: function (idOfTab) {
    const index = this.__getIndexOfTabById(idOfTab);
    if (index !== false) {
      return this.windowContents[index].isDeleted;
    }
  },
  addTab: function (properties) {
    for (let no = 0; no < this.windowContents.length; no++) {
      if (this.windowContents[no].id == properties.id) return false;
    }
    const newIndex = this.windowContents.length;
    this.windowContents[newIndex] = new DHTMLSuite.windowTabModel(properties);
    return this.windowContents[newIndex];
  },
};
DHTMLSuite.windowTabModel = function (tabProperties) {
  let tabTitle;
  let textContent;
  let id;
  let htmlElementId;
  let contentUrl;
  let isDeleted;
  let overflow;
  this.overflow = "auto";
  if (tabProperties) this.__setInitProps(tabProperties);
};
DHTMLSuite.windowTabModel.prototype = {
  __createContentModelFromHTMLElement: function (elementReference) {
    elementReference = DHTMLSuite.commonObj.getEl(elementReference);
    this.textContent = elementReference.innerHTML;
    let properties = elementReference.getAttribute("tabProperties");
    if (!properties) properties = referenceToHTMLElement.tabProperties;
    this.id = elementReference.id;
    this.htmlElementId = elementReference.id;
    this.__setInitProps(
      DHTMLSuite.commonObj.getAssociativeArrayFromString(properties)
    );
  },
  __setInitProps: function (arrayOfProperties) {
    if (arrayOfProperties.tabTitle) this.tabTitle = arrayOfProperties.tabTitle;
    if (arrayOfProperties.contentUrl) {
      this.contentUrl = arrayOfProperties.contentUrl;
    }
    if (arrayOfProperties.id) this.id = arrayOfProperties.id;
    if (arrayOfProperties.textContent) {
      this.textContent = arrayOfProperties.textContent;
    }
    if (arrayOfProperties.htmlElementId) {
      this.htmlElementId = arrayOfProperties.htmlElementId;
    }
    if (arrayOfProperties.isDeleted) {
      this.htmlElementId = arrayOfProperties.isDeleted;
    }
    if (arrayOfProperties.overflow) this.overflow = arrayOfProperties.overflow;
    if (this.id && !this.htmlElementId) this.htmlElementId = this.id;
  },
  __setContentUrl: function (url) {
    this.contentUrl = url;
  },
  __setDeleted: function (isDeleted) {
    this.isDeleted = isDeleted;
  },
};
DHTMLSuite.windowWidget = function (windowModel) {
  var windowModel;
  let layoutCSS;
  let objectIndex;
  let divElement;
  let divElInner;
  let divTitleBar;
  let divElContent;
  let divCloseButton;
  let divMinimizeButton;
  let divStatusBarTxt;
  let divTitleIcon;
  let divResizeHandle;
  let iframeEl;
  let divElementTitle_txt;
  let referenceToDragDropObject;
  let contentDivs;
  let resizeObj;
  let slideSpeed;
  let layoutOffsetHeightForTheStatusBar;
  let scrollPositions;
  this.scrollPositions = new Object();
  this.layoutOffsetHeightForTheStatusBar = 8;
  this.layoutCSS = "window.css";
  this.contentDivs = new Object();
  this.slideSpeed = 25;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
  if (windowModel) this.addWindowModel(windowModel);
};
DHTMLSuite.windowWidget.prototype = {
  show: function () {
    this.windowModel.isVisible = true;
    this.divElement.style.visibility = "visible";
    this.divElement.style.display = "block";
    if (this.iframeEl) this.iframeEl.style.visibility = "visible";
  },
  addWindowModel: function (windowModel) {
    this.windowModel = windowModel;
    if (windowModel.windowsTheme) this.setLayoutThemeWindows();
  },
  setLayoutThemeWindows: function () {
    this.setLayoutCss("window-theme-windows.css");
    this.layoutOffsetHeightForTheStatusBar = 1;
  },
  appendContent: function (idOfTab, contentReference) {
    contentReference = DHTMLSuite.commonObj.getEl(contentReference);
    try {
      document.getElementById(idOfTab).appendChild(contentReference);
    } catch (e) {}
  },
  setLayoutCss: function (cssFileName) {
    this.layoutCSS = cssFileName;
    if (cssFileName == "window-theme-windows.css") {
      this.layoutOffsetHeightForTheStatusBar = 1;
    }
  },
  setStatusBarText: function (text) {
    this.divStatusBarTxt.innerHTML = text;
  },
  setSlideSpeed: function (slideSpeed) {
    this.slideSpeed = slideSpeed;
  },
  init: function () {
    const ind = this.objectIndex;
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    this.__getWindowPropertiesFromCookie();
    if (!this.windowModel.activeTabId) {
      this.windowModel.__setActiveTabIdAutomatically();
    }
    this.__createPrimaryDivElements();
    this.__createiframeEl();
    this.__createTitleBar();
    this.__createTabRow();
    this.__createContentArea();
    this.__createStatusBar();
    this.__initiallyPopulateContentArea();
    this.__displayActiveContent();
    this.__populateTabRow();
    this.__populateTitleBar();
    this.__showHideButtonElements();
    this.__makeWindowDragable();
    this.__makeWindowResizable();
    this.__initiallySetPositionAndSizeOfWindow();
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__setSizeOfDivElements()",
      200
    );
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__setSizeOfDivElements()",
      500
    );
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__setSizeOfDivElements()",
      1000
    );
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__setSizeOfDivElements()",
      2000
    );
  },
  loadContent: function (idOfWindowContentObject, url) {
    this.windowModel.__setContentUrl(idOfWindowContentObject, url);
    try {
      var dynContent = new DHTMLSuite.dynamicContent();
    } catch (e) {
      alert("Include dhtmlSuite-dynamicContent.js");
    }
    const ref = this.windowModel.__getContentObjectById(
      idOfWindowContentObject
    );
    if (ref) dynContent.loadContent(ref.htmlElementId, url);
  },
  activateTab: function (idOfContent) {
    const c = this.__getActiveContentElement();
    this.scrollPositions[this.windowModel.activeTabId] = c.parentNode.scrollTop;
    this.windowModel.__setActiveTabId(idOfContent);
    this.__setLayoutOfTabs();
    this.__displayActiveContent();
    this.__saveCookie();
  },
  setLayoutOffsetHeightForTheStatusBar: function (
    layoutOffsetHeightForTheStatusBar
  ) {
    this.layoutOffsetHeightForTheStatusBar = layoutOffsetHeightForTheStatusBar;
  },
  deleteTab: function (idOfTab) {
    this.windowModel.__deleteTab(idOfTab);
    if (this.windowModel.__getActiveTabId() == idOfTab) {
      this.windowModel.__setActiveTabIdAutomatically();
    }
    this.__populateTabRow();
    this.__setLayoutOfTabs();
    this.__displayActiveContent();
  },
  restoreTab: function (idOfTab) {
    this.windowModel.__restoreTab(idOfTab);
    this.__populateTabRow();
    this.__setLayoutOfTabs();
    this.__displayActiveContent();
  },
  addTab: function (tabProperties) {
    const contentObj = this.windowModel.addTab(tabProperties);
    if (contentObj) {
      this.__createContentForATab(contentObj);
      this.__populateTabRow();
      this.__setLayoutOfTabs();
      this.__displayActiveContent();
    }
  },
  setWidthOfWindow: function (newWidth) {
    this.windowModel.__setWidth(newWidth);
    this.divElement.style.width = this.windowModel.__getWidth() + "px";
    this.__updateWindowModel();
  },
  setHeightOfWindow: function (newHeight) {
    this.windowModel.__setHeight(newHeight);
    this.divElement.style.height = this.windowModel.__getHeight() + "px";
    this.__setSizeOfDivElements();
    this.__updateWindowModel();
  },
  __createPrimaryDivElements: function () {
    this.divElement = document.createElement("DIV");
    this.divElement.className = "DHTMLSuite_window";
    document.body.appendChild(this.divElement);
    if (!this.windowModel.isVisible) {
      this.divElement.style.visibility = "hidden";
    }
    this.divElInner = document.createElement("DIV");
    this.divElInner.className = "DHTMLSuite_windowInnerDiv";
    this.divElInner.style.position = "relative";
    this.divElInner.style.left = "0px";
    this.divElInner.style.top = "0px";
    this.divElInner.style.zIndex = 5;
    this.divElement.appendChild(this.divElInner);
  },
  __createiframeEl: function () {
    if (DHTMLSuite.clientInfoObj.isMSIE) {
      this.iframeEl = document.createElement(
        '<IFRAME src="about:blank" frameborder=0>'
      );
      this.iframeEl.style.position = "absolute";
      this.iframeEl.style.top = "0px";
      this.iframeEl.style.left = "0px";
      this.iframeEl.style.width = "105%";
      this.iframeEl.style.height = "105%";
      this.iframeEl.style.zIndex = 1;
      this.iframeEl.style.visibility = "visible";
      if (!this.windowModel.isVisible) {
        this.iframeEl.style.visibility = "hidden";
      }
      this.divElement.appendChild(this.iframeEl);
    }
  },
  __createTitleBar: function () {
    const ind = this.objectIndex;
    this.divTitleBar = document.createElement("DIV");
    this.divTitleBar.className = "DHTMLSuite_windowTitleBar";
    this.divElInner.appendChild(this.divTitleBar);
    const buttonDiv = document.createElement("DIV");
    buttonDiv.className = "DHTMLSuite_windowButtonDiv";
    this.divTitleBar.appendChild(buttonDiv);
    if (this.windowModel.icon) {
      const iconDiv = document.createElement("DIV");
      iconDiv.style.position = "absolute";
      iconDiv.className = "DHTMLSuite_windowIcon";
      iconDiv.style.backgroundImage = 'url("' + this.windowModel.icon + '")';
      iconDiv.style.backgroundPosition = "left center";
      iconDiv.style.backgroundRepeat = "no-repeat";
      iconDiv.style.left = "0px";
      iconDiv.style.top = "0px";
      const img = document.createElement("IMG");
      img.style.visibility = "hidden";
      img.src = this.windowModel.icon;
      iconDiv.appendChild(img);
      this.divTitleIcon = iconDiv;
      this.divTitleBar.appendChild(iconDiv);
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__repositionTitleText()",
        50
      );
    }
    this.divCloseButton = document.createElement("DIV");
    this.divCloseButton.onmouseover = this.__mouseoverCloseButton;
    this.divCloseButton.onmouseout = this.__mouseoutCloseButton;
    this.divCloseButton.className = "DHTMLSuite_windowCloseButton";
    this.divCloseButton.onclick = function () {
      return DHTMLSuite.variableStorage.arrayDSObjects[ind].close();
    };
    this.divCloseButton.innerHTML = "<span></span>";
    buttonDiv.appendChild(this.divCloseButton);
    DHTMLSuite.commonObj.__addEventEl(this.divCloseButton);
    if (this.windowModel.isMinimizable) {
      this.divMinimizeButton = document.createElement("DIV");
      this.divMinimizeButton.onmouseover = this.__mouseoverMinimizeButton;
      this.divMinimizeButton.onmouseout = this.__mouseoutMinimizeButton;
      this.divMinimizeButton.className = "DHTMLSuite_windowMinimizeButton";
      this.divMinimizeButton.onclick = function () {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].minimizeWindow();
      };
      this.divMinimizeButton.innerHTML = "<span></span>";
      buttonDiv.appendChild(this.divMinimizeButton);
      DHTMLSuite.commonObj.__addEventEl(this.divMinimizeButton);
      this.divMaximizeButton = document.createElement("DIV");
      this.divMaximizeButton.onmouseover = this.__mouseoverMaximizeButton;
      this.divMaximizeButton.onmouseout = this.__mouseoutMaximizeButton;
      this.divMaximizeButton.className = "DHTMLSuite_windowMaximizeButton";
      this.divMaximizeButton.onclick = function () {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].maximizeWindow();
      };
      this.divMaximizeButton.innerHTML = "<span></span>";
      buttonDiv.appendChild(this.divMaximizeButton);
      this.divMaximizeButton.style.display = "none";
      DHTMLSuite.commonObj.__addEventEl(this.divMaximizeButton);
    }
    this.divElementTitle_txt = document.createElement("DIV");
    this.divElementTitle_txt.className = "DHTMLSuite_windowTitleInTitleBar";
    this.divTitleBar.onselectstart = function () {
      return false;
    };
    this.divTitleBar.appendChild(this.divElementTitle_txt);
    DHTMLSuite.commonObj.__addEventEl(this.divTitleBar);
  },
  __repositionTitleText: function () {
    this.divElementTitle_txt.style.marginLeft =
      this.divTitleIcon.clientWidth + "px";
  },
  __createTabRow: function () {
    this.divElementTabRow = document.createElement("DIV");
    this.divElementTabRow.className = "DHTMLSuite_windowTabRow";
    this.divElInner.appendChild(this.divElementTabRow);
  },
  __createContentArea: function () {
    this.divElContent = document.createElement("DIV");
    this.divElContent.className = "DHTMLSuite_windowContent";
    this.divElContent.style.overflow = "auto";
    this.divElInner.appendChild(this.divElContent);
  },
  __createStatusBar: function () {
    this.divStatusBar = document.createElement("DIV");
    this.divStatusBar.className = "DHTMLSuite_windowStatusBar";
    this.divElInner.appendChild(this.divStatusBar);
    this.divResizeHandle = document.createElement("DIV");
    this.divResizeHandle.className = "DHTMLSuite_windowResizeHandle";
    this.divResizeHandle.innerHTML = "<span></span>";
    this.divStatusBar.appendChild(this.divResizeHandle);
    this.divStatusBarTxt = document.createElement("DIV");
    this.divStatusBarTxt.className = "DHTMLSuite_windowStatusBarText";
    this.divStatusBar.appendChild(this.divStatusBarTxt);
  },
  __populateTitleBar: function () {
    this.divElementTitle_txt.innerHTML = this.windowModel.__getTitle();
  },
  __initiallyPopulateContentArea: function () {
    const contentObjects = this.windowModel.__getContentObjects();
    for (let no = 0; no < contentObjects.length; no++) {
      this.__createContentForATab(contentObjects[no]);
    }
  },
  __createContentForATab: function (contentObj) {
    if (contentObj.htmlElementId) {
      if (document.getElementById(contentObj.htmlElementId)) {
        this.contentDivs[contentObj.id] = document.getElementById(
          contentObj.htmlElementId
        );
      } else {
        this.contentDivs[contentObj.id] = document.createElement("DIV");
        this.contentDivs[contentObj.id].id = contentObj.htmlElementId;
      }
      this.divElContent.appendChild(this.contentDivs[contentObj.id]);
    }
    if (contentObj.contentUrl) {
      this.loadContent(contentObj.id, contentObj.contentUrl);
    }
    if (contentObj.textContent) {
      this.contentDivs[contentObj.id].innerHTML = contentObj.textContent;
    }
    this.contentDivs[contentObj.id].className = "DHTMLSuite_windowContentInner";
    this.contentDivs[contentObj.id].style.display = "none";
  },
  __getActiveContentElement: function () {
    const contentObjects = this.windowModel.__getContentObjects();
    for (let no = 0; no < contentObjects.length; no++) {
      if (contentObjects[no].id == this.windowModel.activeTabId) {
        return this.contentDivs[contentObjects[no].id];
      }
    }
  },
  __displayActiveContent: function () {
    const contentObjects = this.windowModel.__getContentObjects();
    for (let no = 0; no < contentObjects.length; no++) {
      if (contentObjects[no].id == this.windowModel.activeTabId) {
        this.contentDivs[contentObjects[no].id].style.display = "block";
        if (this.scrollPositions[contentObjects[no].id]) {
          this.contentDivs[contentObjects[no].id].parentNode.scrollTop =
            this.scrollPositions[contentObjects[no].id];
        }
        try {
          this.divElContent.style.overflow = contentObjects[no].overflow;
        } catch (e) {}
      } else {
        this.contentDivs[contentObjects[no].id].style.display = "none";
      }
    }
  },
  __populateTabRow: function () {
    const ind = this.objectIndex;
    this.divElementTabRow.innerHTML = "";
    const contentObjects = this.windowModel.__getContentObjects();
    if (DHTMLSuite.clientInfoObj.isMSIE) {
      var table = document.createElement(
        '<TABLE cellpadding="0" cellspacing="0" border="0">'
      );
    } else {
      var table = document.createElement("TABLE");
      table.setAttribute("cellpadding", 0);
      table.setAttribute("cellspacing", 0);
      table.setAttribute("border", 0);
    }
    this.divElementTabRow.appendChild(table);
    const tbody = document.createElement("TBODY");
    table.appendChild(tbody);
    const row = tbody.insertRow(0);
    for (let no = 0; no < contentObjects.length; no++) {
      if (!this.windowModel.__getIsDeleted(contentObjects[no].id)) {
        const cell = row.insertCell(-1);
        cell.className = "DHTMLSuite_windowATab";
        cell.id = "windowTab_" + contentObjects[no].id;
        cell.setAttribute("contentId", contentObjects[no].id);
        cell.onclick = function (e) {
          DHTMLSuite.variableStorage.arrayDSObjects[ind].__activateTabByClick(
            e
          );
        };
        DHTMLSuite.commonObj.__addEventEl(cell);
        const innerDiv = document.createElement("DIV");
        innerDiv.className = "DHTMLSuite_windowATabInnerDiv";
        innerDiv.innerHTML = contentObjects[no].tabTitle;
        cell.appendChild(innerDiv);
      }
    }
    this.__setLayoutOfTabs();
  },
  __clearActiveAndInactiveStylingFromTabs: function () {
    const cells = this.divElementTabRow.getElementsByTagName("TD");
    const divs = this.divElementTabRow.getElementsByTagName("DIV");
    for (var no = 0; no < cells.length; no++) {
      cells[no].className = cells[no].className.replace(
        "DHTMLSuite_windowActiveTabCell",
        ""
      );
      cells[no].className = cells[no].className.replace(
        "DHTMLSuite_windowInactiveTabCell",
        ""
      );
      cells[no].style.left = "0px";
    }
    for (var no = 0; no < divs.length; no++) {
      divs[no].className = divs[no].className.replace(
        " DHTMLSuite_windowActiveTabCellContent",
        ""
      );
      divs[no].className = divs[no].className.replace(
        " DHTMLSuite_windowInactiveTabCellContent",
        ""
      );
    }
  },
  __setLayoutOfTabs: function () {
    this.__clearActiveAndInactiveStylingFromTabs();
    const cells = this.divElementTabRow.getElementsByTagName("TD");
    const contentObjects = this.windowModel.__getContentObjects();
    let activeTabIndex = 0;
    for (var no = 0; no < cells.length; no++) {
      if (cells[no].id == "windowTab_" + this.windowModel.activeTabId) {
        activeTabIndex = no;
        break;
      }
    }
    let leftPadding = 0;
    if (activeTabIndex > 0) {
      leftPadding = -7;
    }
    cells[0].style.zIndex = 1;
    for (var no = 1; no < activeTabIndex; no++) {
      cells[no].style.left = leftPadding + "px";
      cells[no].style.zIndex = no + 1;
      leftPadding -= 7;
    }
    for (var no = activeTabIndex; no < cells.length; no++) {
      cells[no].style.left = leftPadding + "px";
      cells[no].style.zIndex = 100 - no;
      leftPadding -= 7;
    }
    cells[activeTabIndex].style.zIndex = 200;
    for (var no = 0; no < cells.length; no++) {
      const div = cells[no].getElementsByTagName("DIV")[0];
      if (no == activeTabIndex) {
        cells[no].className =
          cells[no].className + " DHTMLSuite_windowActiveTabCell";
        div.className =
          div.className + " DHTMLSuite_windowActiveTabCellContent";
      } else {
        cells[no].className =
          cells[no].className + " DHTMLSuite_windowInactiveTabCell";
        div.className =
          div.className + " DHTMLSuite_windowInactiveTabCellContent";
      }
    }
  },
  __setSizeOfDivElements: function () {
    try {
      this.divElContent.style.height =
        this.divElement.clientHeight -
        (this.divTitleBar.offsetHeight +
          this.divStatusBar.offsetHeight +
          this.divElementTabRow.offsetHeight +
          this.layoutOffsetHeightForTheStatusBar) +
        "px";
      if (
        DHTMLSuite.clientInfoObj.isMSIE &&
        DHTMLSuite.clientInfoObj.navigatorVersion < 7
      ) {
        this.divElContent.style.width = this.divStatusBar.clientWidth + "px";
      }
    } catch (e) {
      this.divElContent.style.height = "1px";
    }
    try {
      if (this.windowModel.__getState() == "minimized") {
        this.divElement.style.height =
          this.divTitleBar.offsetHeight +
          this.divElementTabRow.offsetHeight +
          this.divStatusBar.offsetHeight +
          "px";
      }
    } catch (e) {}
  },
  __activateTabByClick: function (e) {
    if (document.all) e = event;
    let src = DHTMLSuite.commonObj.getSrcElement(e);
    if (src.tagName.toLowerCase() == "div") src = src.parentNode;
    const idOfContent = src.getAttribute("contentId");
    this.activateTab(idOfContent);
  },
  __updateWindowModel: function () {
    this.windowModel.__setWidth(
      this.divElement.style.width.replace("px", "") / 1
    );
    if (this.windowModel.__getState() != "minimized") {
      this.windowModel.__setHeight(
        this.divElement.style.height.replace("px", "") / 1
      );
    }
    this.windowModel.__setXPos(
      this.divElement.style.left.replace("px", "") / 1
    );
    this.windowModel.__setYPos(this.divElement.style.top.replace("px", "") / 1);
    this.windowModel.__setZIndex(this.divElement.style.zIndex);
    this.__saveCookie();
  },
  __saveCookie: function () {
    if (!this.windowModel.cookieName) return;
    let cookieValue = "width:" + this.windowModel.__getWidth();
    cookieValue += ",height:" + this.windowModel.__getHeight();
    cookieValue += ",xPos:" + this.windowModel.__getXPos();
    cookieValue += ",yPos:" + this.windowModel.__getYPos();
    cookieValue += ",zIndex:" + this.divElement.style.zIndex;
    cookieValue += ",activeTabId:" + this.windowModel.__getActiveTabId();
    cookieValue += ",state:" + this.windowModel.__getState();
    DHTMLSuite.commonObj.setCookie(
      this.windowModel.cookieName,
      cookieValue,
      500
    );
  },
  __getWindowPropertiesFromCookie: function () {
    if (!this.windowModel.cookieName) return;
    const cookieValue = DHTMLSuite.commonObj.getCookie(
      this.windowModel.cookieName
    );
    const propertyArray =
      DHTMLSuite.commonObj.getAssociativeArrayFromString(cookieValue);
    if (!propertyArray) return;
    if (propertyArray.width) this.windowModel.__setWidth(propertyArray.width);
    if (propertyArray.height) {
      this.windowModel.__setHeight(propertyArray.height);
    }
    if (propertyArray.xPos) this.windowModel.__setXPos(propertyArray.xPos);
    if (propertyArray.yPos) this.windowModel.__setYPos(propertyArray.yPos);
    if (propertyArray.zIndex) {
      this.windowModel.__setZIndex(propertyArray.zIndex);
    }
    if (propertyArray.state) this.windowModel.__setState(propertyArray.state);
    if (propertyArray.activeTabId) {
      this.windowModel.__setActiveTabId(propertyArray.activeTabId);
    }
  },
  __initiallySetPositionAndSizeOfWindow: function () {
    this.divElement.style.position = "absolute";
    const width = this.windowModel.__getWidth();
    const height = this.windowModel.__getHeight();
    const xPos = this.windowModel.__getXPos();
    const yPos = this.windowModel.__getYPos();
    const zIndex = this.windowModel.__getZIndex();
    const state = this.windowModel.__getState();
    if (width && width != "0") this.divElement.style.width = width + "px";
    if (height && height != "0") this.divElement.style.height = height + "px";
    if (xPos) this.divElement.style.left = xPos + "px";
    if (yPos) this.divElement.style.top = yPos + "px";
    if (zIndex) this.divElement.style.zIndex = zIndex;
    if (state && state == "minimized") this.minimizeWindow();
  },
  __deleteTabByClick: function () {},
  __makeWindowResizable: function () {
    if (!this.windowModel.isResizable) {
      this.divResizeHandle.style.visibility = "hidden";
      return;
    }
    const ind = this.objectIndex;
    try {
      this.resizeObj = new DHTMLSuite.resize({
        minWidth: this.windowModel.minWidth,
        minHeight: this.windowModel.minHeight,
        maxWidth: this.windowModel.maxWidth,
        maxHeight: this.windowModel.maxHeight,
      });
    } catch (e) {
      alert("Include dhtmlSuite-resize.js");
    }
    this.resizeObj.setElementRoResize(this.divElement);
    this.resizeObj.addResizeHandle(this.divResizeHandle, "southeast");
    this.resizeObj.setCallbackOnBeforeResize(
      "DHTMLSuite.variableStorage.arrayDSObjects[" + ind + "].__isOkToResize"
    );
    this.resizeObj.setCallbackOnAfterResize(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__updateWindowModel"
    );
    this.resizeObj.setCallbackOnDuringResize(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__setSizeOfDivElements"
    );
    this.resizeObj.init();
    this.divStatusBarTxt.onselectstart = function () {
      return false;
    };
    this.divStatusBar.onselectstart = function () {
      return false;
    };
    DHTMLSuite.commonObj.__addEventEl(this.divStatusBarTxt);
    DHTMLSuite.commonObj.__addEventEl(this.divStatusBar);
  },
  __isOkToResize: function () {
    if (this.windowModel.__getState() == "minimized") return false;
    return true;
  },
  __makeWindowDragable: function () {
    const ind = this.objectIndex;
    if (this.windowModel.isDragable) {
      try {
        this.referenceToDragDropObject = new DHTMLSuite.dragDropSimple({
          elementReference: this.divElement,
          cloneNode: false,
        });
      } catch (e) {
        alert("Include dhtmlSuite-dragDropSimple.js");
      }
      this.referenceToDragDropObject.setCallbackOnAfterDrag(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__updateWindowModel"
      );
      this.referenceToDragDropObject.setCallbackOnBeforeDrag(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__updateWindowModel"
      );
      this.referenceToDragDropObject.addDragHandle(this.divTitleBar);
      this.divTitleBar.style.cursor = "move";
      this.referenceToDragDropObject.__setNewCurrentZIndex(
        this.windowModel.__getZIndex()
      );
    }
  },
  deleteWindow: function () {
    this.close();
  },
  close: function () {
    this.windowModel.isVisible = true;
    this.divElement.style.visibility = "hidden";
    this.divElement.style.display = "none";
    if (this.iframeEl) this.iframeEl.style.visibility = "hidden";
    this.__handleCallback("onClose");
  },
  purge: function () {
    DHTMLSuite.discardElement(this.divElement);
  },
  getDivElement: function () {
    return this.divElement;
  },
  restoreWindow: function () {
    this.show();
  },
  __handleCallback: function (action) {
    let callbackString = "";
    switch (action) {
      case "onClose":
        callbackString = this.windowModel.callbackOnClose;
        break;
    }
    if (callbackString) {
      const ind = this.objectIndex;
      callbackString =
        callbackString +
        "(DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "])";
      return eval(callbackString);
    }
  },
  minimizeWindow: function () {
    this.windowModel.__setState("minimized");
    this.divElContent.style.display = "none";
    this.divStatusBar.style.display = "none";
    this.divElementTabRow.style.display = "none";
    this.divMinimizeButton.style.display = "none";
    this.divMaximizeButton.style.display = "block";
    this.__setSizeOfDivElements();
    this.__saveCookie();
  },
  maximizeWindow: function () {
    this.windowModel.__setState("maximized");
    this.divElContent.style.display = "block";
    this.divStatusBar.style.display = "block";
    this.divElementTabRow.style.display = "block";
    this.divMinimizeButton.style.display = "block";
    this.divMaximizeButton.style.display = "none";
    this.divElement.style.height = this.windowModel.__getHeight() + "px";
    this.__setSizeOfDivElements();
    this.__saveCookie();
  },
  slideWindowToXAndY: function (toX, toY) {
    const slideFactors = this.__getSlideFactors(toX, toY);
    const slideDirections = this.__getSlideDirections(toX, toY);
    const slideTo = new Object();
    slideTo.x = toX;
    slideTo.y = toY;
    const currentPos = new Object();
    currentPos.x = this.windowModel.__getXPos();
    currentPos.y = this.windowModel.__getYPos();
    if (currentPos.x == slideTo.x && currentPos.y == slideTo.y) return;
    this.__performSlide(slideTo, currentPos, slideFactors, slideDirections);
  },
  __performSlide: function (
    slideTo,
    currentPos,
    slideFactors,
    slideDirections
  ) {
    const ind = this.objectIndex;
    currentPos.x =
      currentPos.x / 1 + this.slideSpeed * slideFactors.y * slideDirections.x;
    currentPos.y =
      currentPos.y / 1 + this.slideSpeed * slideFactors.x * slideDirections.y;
    repeatSlide = false;
    if (slideDirections.x < 0) {
      if (currentPos.x <= slideTo.x) {
        currentPos.x = slideTo.x;
      } else {
        repeatSlide = true;
      }
    } else {
      if (currentPos.x >= slideTo.x) {
        currentPos.x = slideTo.x;
      } else {
        repeatSlide = true;
      }
    }
    if (slideDirections.y < 0) {
      if (currentPos.y <= slideTo.y) {
        currentPos.y = slideTo.y;
      } else {
        repeatSlide = true;
      }
    } else {
      if (currentPos.y >= slideTo.y) {
        currentPos.y = slideTo.y;
      } else {
        repeatSlide = true;
      }
    }
    this.divElement.style.left = Math.round(currentPos.x) + "px";
    this.divElement.style.top = Math.round(currentPos.y) + "px";
    if (repeatSlide) {
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__performSlide({x:" +
          slideTo.x +
          ",y:" +
          slideTo.y +
          "},{x:" +
          currentPos.x +
          ",y:" +
          currentPos.y +
          "},{x:" +
          slideFactors.x +
          ",y:" +
          slideFactors.y +
          "},{x:" +
          slideDirections.x +
          ",y:" +
          slideDirections.y +
          "})",
        10
      );
    } else {
      this.__updateWindowModel();
    }
  },
  __getSlideFactors: function (toX, toY) {
    const retArray = new Object();
    const currentX = this.windowModel.__getXPos();
    const currentY = this.windowModel.__getYPos();
    const distance_x = Math.abs(toX - currentX);
    const distance_y = Math.abs(toY - currentY);
    if (distance_x < distance_y) {
      retArray.x = distance_y / distance_x;
      retArray.y = 1;
    } else {
      retArray.y = distance_x / distance_y;
      retArray.x = 1;
    }
    return retArray;
  },
  __getSlideDirections: function (toX, toY) {
    const retArray = new Object();
    if (toX < this.windowModel.__getXPos()) retArray.x = -1;
    else retArray.x = 1;
    if (toY < this.windowModel.__getYPos()) retArray.y = -1;
    else retArray.y = 1;
    return retArray;
  },
  __showHideButtonElements: function () {
    if (this.windowModel.isClosable) {
      this.divCloseButton.style.display = "block";
    } else this.divCloseButton.style.display = "none";
  },
  __mouseoverCloseButton: function () {
    this.className = this.className + " DHTMLSuite_windowCloseButtonOver";
  },
  __mouseoutCloseButton: function () {
    this.className = this.className.replace(
      " DHTMLSuite_windowCloseButtonOver",
      ""
    );
  },
  __mouseoverMinimizeButton: function () {
    this.className = this.className + " DHTMLSuite_windowMinimizeButtonOver";
  },
  __mouseoutMinimizeButton: function () {
    this.className = this.className.replace(
      " DHTMLSuite_windowMinimizeButtonOver",
      ""
    );
  },
  __mouseoverMaximizeButton: function () {
    this.className = this.className + " DHTMLSuite_windowMaximizeButtonOver";
  },
  __mouseoutMaximizeButton: function () {
    this.className = this.className.replace(
      " DHTMLSuite_windowMaximizeButtonOver",
      ""
    );
  },
};
DHTMLSuite.windowCollection = function () {
  let windowWidgets;
  let spaceBetweenEachWindowWhenCascaded;
  let numberOfColumnsWhenTiled;
  let divWindowsArea;
  this.windowWidgets = new Array();
  this.spaceBetweenEachWindowWhenCascaded = 20;
  this.numberOfColumnsWhenTiled = 2;
};
DHTMLSuite.windowCollection.prototype = {
  addWindow: function (windowWidgetReference) {
    this.windowWidgets[this.windowWidgets.length] = windowWidgetReference;
  },
  tile: function () {
    this.windowWidgets = this.windowWidgets.sort(this.__sortItems);
    let browserWidth = DHTMLSuite.clientInfoObj.getBrowserWidth() - 20;
    let browserHeight = DHTMLSuite.clientInfoObj.getBrowserHeight() - 20;
    let offsetX = 10;
    let offsetY = 10;
    if (this.divWindowsArea) {
      browserWidth = this.divWindowsArea.clientWidth;
      browserHeight = this.divWindowsArea.clientHeight;
      offsetX = DHTMLSuite.commonObj.getLeftPos(this.divWindowsArea);
      offsetY = DHTMLSuite.commonObj.getTopPos(this.divWindowsArea);
    }
    const windowWidth = Math.floor(
      browserWidth / this.numberOfColumnsWhenTiled
    );
    const windowHeight = Math.floor(
      browserHeight /
        Math.ceil(this.windowWidgets.length / this.numberOfColumnsWhenTiled)
    );
    for (let no = 0; no < this.windowWidgets.length; no++) {
      this.windowWidgets[no].setWidthOfWindow(windowWidth);
      this.windowWidgets[no].setHeightOfWindow(windowHeight - 5);
      const xPos = offsetX + windowWidth * (no % this.numberOfColumnsWhenTiled);
      const yPos =
        offsetY + windowHeight * Math.floor(no / this.numberOfColumnsWhenTiled);
      this.windowWidgets[no].slideWindowToXAndY(xPos, yPos);
    }
  },
  cascade: function () {
    this.windowWidgets = this.windowWidgets.sort(this.__sortItems);
    let browserWidth = DHTMLSuite.clientInfoObj.getBrowserWidth() - 50;
    let browserHeight = DHTMLSuite.clientInfoObj.getBrowserHeight() - 50;
    let offsetX = 10;
    let offsetY = 10;
    if (this.divWindowsArea) {
      browserWidth = this.divWindowsArea.clientWidth;
      browserHeight = this.divWindowsArea.clientHeight;
      offsetX = DHTMLSuite.commonObj.getLeftPos(this.divWindowsArea);
      offsetY = DHTMLSuite.commonObj.getTopPos(this.divWindowsArea);
    }
    const windowWidth =
      browserWidth -
      (this.windowWidgets.length - 1) * this.spaceBetweenEachWindowWhenCascaded;
    const windowHeight =
      browserHeight -
      (this.windowWidgets.length - 1) * this.spaceBetweenEachWindowWhenCascaded;
    for (let no = 0; no < this.windowWidgets.length; no++) {
      this.windowWidgets[no].setWidthOfWindow(windowWidth);
      this.windowWidgets[no].setHeightOfWindow(windowHeight);
      this.windowWidgets[no].slideWindowToXAndY(
        offsetX + this.spaceBetweenEachWindowWhenCascaded * no,
        offsetY + this.spaceBetweenEachWindowWhenCascaded * no
      );
    }
  },
  minimize: function () {
    for (let no = 0; no < this.windowWidgets.length; no++) {
      this.windowWidgets[no].minimizeWindow();
    }
  },
  maximize: function () {
    for (let no = 0; no < this.windowWidgets.length; no++) {
      this.windowWidgets[no].maximizeWindow();
    }
  },
  setNumberOfColumnsWhenTiled: function (numberOfColumnsWhenTiled) {
    this.numberOfColumnsWhenTiled = numberOfColumnsWhenTiled;
  },
  setDivWindowsArea: function (divWindowsArea) {
    divWindowsArea = DHTMLSuite.commonObj.getEl(divWindowsArea);
    this.divWindowsArea = divWindowsArea;
  },
  __sortItems: function (a, b) {
    return a.windowModel.__getZIndex() / 1 - b.windowModel.__getZIndex() / 1;
  },
};
DHTMLSuite.resize = function (propertyArray) {
  let resizeWhichElement;
  let resizeHandles;
  this.resizeHandles = new Array();
  let preserveRatio;
  let minWidth;
  let maxWidth;
  let minHeight;
  let maxHeight;
  let callbackOnBeforeResize;
  let callbackOnAfterResize;
  let callbackOnDuringResize;
  let resizeTimer;
  let resizeInWhichDirections;
  let resizeHandleelativePath;
  let objectIndex;
  let mouseStartPos;
  let initElementSize;
  let currentResizeDirection;
  let classNameOfResizeHandles;
  let layoutCSS;
  let resizeHandlerOffsetInPixels;
  let elementToResizeIsAbsolutePositioned;
  let sizeOfWidthRelativeToHeight;
  this.minWidth = 0;
  this.minHeight = 0;
  this.maxWidth = 150000;
  this.maxHeight = 150000;
  this.classNameOfResizeHandles = "DHTMLSuite_resize_handle";
  this.layoutCSS = "resize.css";
  this.resizeHandleelativePath = "resize/small_square.gif";
  this.resizeTimer = -1;
  this.mouseStartPos = new Object();
  this.initElementSize = new Object();
  this.resizeHandlerOffsetInPixels = 4;
  this.elementToResizeIsAbsolutePositioned = false;
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  if (propertyArray) this.__setInitProps(propertyArray);
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.resize.prototype = {
  setLayoutCss: function (cssFileName) {
    this.layoutCSS = cssFileName;
  },
  setCssClassNameForResizeHandles: function (classNameOfResizeHandles) {
    this.classNameOfResizeHandles = classNameOfResizeHandles;
  },
  setElementRoResize: function (elementReference) {
    elementReference = DHTMLSuite.commonObj.getEl(elementReference);
    this.resizeWhichElement = elementReference;
  },
  addResizeHandle: function (resizeHandle, direction) {
    resizeHandle = DHTMLSuite.commonObj.getEl(resizeHandle);
    const index = this.resizeHandles.length;
    this.resizeHandles[index] = new Object();
    this.resizeHandles[index].element = resizeHandle;
    this.resizeHandles[index].direction = direction;
  },
  setMinWidthInPixels: function (pixels) {
    this.minWidth = pixels;
  },
  setMaxWidthInPixels: function (pixels) {
    this.maxWidth = pixels;
  },
  setMinHeightInPixels: function (pixels) {
    this.minHeight = pixels;
  },
  setMaxHeightInPixels: function (pixels) {
    this.maxHeight = pixels;
  },
  setCallbackOnBeforeResize: function (functionName) {
    this.callbackOnBeforeResize = functionName;
  },
  setCallbackOnAfterResize: function (functionName) {
    this.callbackOnAfterResize = functionName;
  },
  setCallbackOnDuringResize: function (functionName) {
    this.callbackOnDuringResize = functionName;
  },
  setResizeHandlerOffsetInPixels: function (offsetInPx) {
    this.resizeHandlerOffsetInPixels = offsetInPx;
  },
  setIsResizeElementAbsolutePositioned: function (absolutePositioned) {
    this.elementToResizeIsAbsolutePositioned = absolutePositioned;
  },
  getReferenceToResizedElement: function () {
    return this.resizeWhichElement;
  },
  init: function () {
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    this.__setAspectRatio();
    this.__createResizeHandlesAutomatically();
    this.__setCursorOfResizeHandles();
    this.__addEventsToResizeHandles();
    this.__addBasicEvents();
  },
  __setAspectRatio: function () {
    this.sizeOfWidthRelativeToHeight =
      this.resizeWhichElement.offsetWidth /
      this.resizeWhichElement.offsetHeight;
  },
  __setInitProps: function (propertyArray) {
    if (propertyArray.minWidth) this.minWidth = propertyArray.minWidth;
    if (propertyArray.maxWidth) this.maxWidth = propertyArray.maxWidth;
    if (propertyArray.minHeight) this.minHeight = propertyArray.minHeight;
    if (propertyArray.maxHeight) this.maxHeight = propertyArray.maxHeight;
    if (propertyArray.preserveRatio) {
      this.preserveRatio = propertyArray.preserveRatio;
    }
    if (propertyArray.callbackOnBeforeResize) {
      this.callbackOnBeforeResize = propertyArray.callbackOnBeforeResize;
    }
    if (propertyArray.callbackOnAfterResize) {
      this.callbackOnAfterResize = propertyArray.callbackOnAfterResize;
    }
    if (propertyArray.callbackOnDuringResize) {
      this.callbackOnDuringResize = propertyArray.callbackOnDuringResize;
    }
    if (propertyArray.resizeInWhichDirections) {
      this.resizeInWhichDirections = propertyArray.resizeInWhichDirections;
    }
  },
  __createResizeHandlesAutomatically: function () {
    if (this.resizeHandles.length > 0) return;
    if (
      !this.resizeInWhichDirections ||
      this.resizeInWhichDirections == "all"
    ) {
      this.resizeInWhichDirections =
        "west,east,north,south,southeast,southwest,northwest,northeast";
    }
    const directions = this.resizeInWhichDirections.split(/,/g);
    for (let no = 0; no < directions.length; no++) {
      this.resizeHandles[no] = new Object();
      this.resizeHandles[no].element = document.createElement("DIV");
      this.resizeHandles[no].element.className = this.classNameOfResizeHandles;
      this.resizeWhichElement.appendChild(this.resizeHandles[no].element);
      this.resizeHandles[no].direction = directions[no];
      const el = this.resizeHandles[no].element;
      el.style.position = "absolute";
      el.style.top = "50%";
      el.style.left = "50%";
      if (directions[no].indexOf("west") >= 0) {
        el.style.left = 0 - this.resizeHandlerOffsetInPixels + "px";
      }
      if (directions[no].indexOf("east") >= 0) {
        el.style.right = 0 - this.resizeHandlerOffsetInPixels + "px";
        el.style.left = "";
      }
      if (directions[no].indexOf("north") >= 0) {
        el.style.top = 0 - this.resizeHandlerOffsetInPixels + "px";
      }
      if (directions[no].indexOf("south") >= 0) {
        el.style.bottom = 0 - this.resizeHandlerOffsetInPixels + "px";
        el.style.top = "";
      }
      if (el.style.top == "50%") {
        el.style.marginTop = "-" + Math.round(el.offsetHeight / 2) + "px";
      }
      if (el.style.left == "50%") {
        el.style.marginLeft = "-" + Math.round(el.offsetWidth / 2) + "px";
      }
    }
  },
  __setCursorOfResizeHandles: function () {
    for (let no = 0; no < this.resizeHandles.length; no++) {
      switch (this.resizeHandles[no].direction) {
        case "west":
        case "east":
          this.resizeHandles[no].element.style.cursor = "e-resize";
          break;
        case "north":
        case "south":
          this.resizeHandles[no].element.style.cursor = "s-resize";
          break;
        case "northeast":
          this.resizeHandles[no].element.style.cursor = "ne-resize";
          break;
        case "northwest":
          this.resizeHandles[no].element.style.cursor = "nw-resize";
          break;
        case "southwest":
          this.resizeHandles[no].element.style.cursor = "sw-resize";
          break;
        case "southeast":
          this.resizeHandles[no].element.style.cursor = "se-resize";
          break;
      }
    }
  },
  __addEventsToResizeHandles: function () {
    const ind = this.objectIndex;
    for (let no = 0; no < this.resizeHandles.length; no++) {
      this.resizeHandles[no].element.onmousedown = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__initResize(e);
      };
      this.resizeHandles[no].element.onselectstart = function () {
        return false;
      };
      DHTMLSuite.commonObj.__addEventEl(this.resizeHandles[no].element);
      this.resizeHandles[no].element.setAttribute(
        "resizeInDirection",
        this.resizeHandles[no].direction
      );
      this.resizeHandles[no].element.resizeInDirection =
        this.resizeHandles[no].direction;
    }
  },
  __addBasicEvents: function () {
    const ind = this.objectIndex;
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mousemove",
      function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__processResize(e);
      },
      ind
    );
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mouseup",
      function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__endResize(e);
      },
      ind
    );
    if (!document.documentElement.onselectstart) {
      document.documentElement.onselectstart = function () {
        return DHTMLSuite.commonObj.__isTextSelOk();
      };
    }
  },
  __initResize: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    if (this.callbackOnBeforeResize) {
      const ok = this.__handleCallback("beforeResize");
      if (!ok) return;
    }
    DHTMLSuite.commonObj.__setTextSelOk(false);
    this.resizeTimer = 0;
    this.mouseStartPos.x = e.clientX;
    this.mouseStartPos.y = e.clientY;
    this.initElementSize.width = this.resizeWhichElement.offsetWidth;
    this.initElementSize.height = this.resizeWhichElement.offsetHeight;
    this.initElementSize.top =
      this.resizeWhichElement.style.top.replace("px", "") / 1;
    if (this.elementToResizeIsAbsolutePositioned && !this.initElementSize.top) {
      this.initElementSize.top = DHTMLSuite.commonObj.getTopPos(
        this.resizeWhichElement
      );
    }
    this.initElementSize.left =
      this.resizeWhichElement.style.left.replace("px", "") / 1;
    if (
      this.elementToResizeIsAbsolutePositioned &&
      !this.initElementSize.left
    ) {
      this.initElementSize.left = DHTMLSuite.commonObj.getLeftPos(
        this.resizeWhichElement
      );
    }
    this.currentResizeDirection = src.getAttribute("resizeInDirection");
    this.__delayBeforeResize();
    return false;
  },
  __delayBeforeResize: function () {
    if (this.resizeTimer >= 0 && this.resizeTimer < 5) {
      const ind = this.objectIndex;
      this.resizeTimer++;
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].__delayBeforeResize()",
        20
      );
    }
  },
  __processResize: function (e) {
    if (document.all) e = event;
    if (this.resizeTimer < 5) return;
    if (DHTMLSuite.clientInfoObj.isMSIE && e.button != 1) {
      return this.__endResize();
    }
    let newWidth = this.initElementSize.width;
    let newHeight = this.initElementSize.height;
    let newTop = this.initElementSize.top;
    let newLeft = this.initElementSize.left;
    switch (this.currentResizeDirection) {
      case "east":
      case "northeast":
      case "southeast":
        newWidth =
          this.initElementSize.width + e.clientX - this.mouseStartPos.x;
        break;
    }
    switch (this.currentResizeDirection) {
      case "south":
      case "southeast":
      case "southwest":
        newHeight =
          this.initElementSize.height + e.clientY - this.mouseStartPos.y;
        break;
    }
    if (this.currentResizeDirection.indexOf("north") >= 0) {
      newTop = this.initElementSize.top + e.clientY - this.mouseStartPos.y;
      newHeight = newHeight - (newTop - this.initElementSize.top);
      if (this.preserveRatio && this.currentResizeDirection == "north") {
        newWidth = Math.round(newHeight * this.sizeOfWidthRelativeToHeight);
      }
      if (newHeight < this.minHeight) {
        newTop -= this.minHeight - newHeight;
      }
    }
    if (this.currentResizeDirection.indexOf("west") >= 0) {
      newLeft = this.initElementSize.left + e.clientX - this.mouseStartPos.x;
      newWidth = newWidth - (newLeft - this.initElementSize.left);
      if (this.preserveRatio && this.currentResizeDirection == "west") {
        newHeight = Math.round(newWidth / this.sizeOfWidthRelativeToHeight);
      }
      if (newWidth < this.minWidth) {
        newLeft -= this.minWidth - newWidth;
      }
      if (newWidth > this.maxWidth) {
        newLeft += newWidth - this.maxWidth;
      }
    }
    if (newWidth < this.minWidth) newWidth = this.minWidth;
    if (newHeight < this.minHeight) newHeight = this.minHeight;
    if (this.maxWidth && newWidth > this.maxWidth) newWidth = this.maxWidth;
    if (this.maxHeight && newHeight > this.maxHeight) {
      newHeight = this.maxHeight;
    }
    if (
      this.currentResizeDirection.indexOf("east") >= 0 &&
      this.preserveRatio
    ) {
      newHeight = Math.round(newWidth / this.sizeOfWidthRelativeToHeight);
    }
    if (
      this.currentResizeDirection.indexOf("south") >= 0 &&
      this.preserveRatio
    ) {
      newWidth = Math.round(newHeight * this.sizeOfWidthRelativeToHeight);
    }
    if (this.currentResizeDirection == "northwest" && this.preserveRatio) {
      if (newWidth / newHeight > this.sizeOfWidthRelativeToHeight) {
        newHeight = Math.round(newWidth / this.sizeOfWidthRelativeToHeight);
      } else {
        newWidth = Math.round(newHeight * this.sizeOfWidthRelativeToHeight);
      }
    }
    this.resizeWhichElement.style.width = newWidth + "px";
    this.resizeWhichElement.style.height = newHeight + "px";
    this.resizeWhichElement.style.top = newTop + "px";
    this.resizeWhichElement.style.left = newLeft + "px";
    if (this.callbackOnDuringResize) this.__handleCallback("duringResize");
  },
  __endResize: function (e) {
    DHTMLSuite.commonObj.__setTextSelOk(true);
    if (this.resizeTimer == 5) {
      this.__handleCallback("afterResize");
    }
    this.resizeTimer = -1;
  },
  __handleCallback: function (action) {
    const ind = this.objectIndex;
    let callbackString = "";
    switch (action) {
      case "afterResize":
        callbackString = this.callbackOnAfterResize;
        break;
      case "duringResize":
        callbackString = this.callbackOnDuringResize;
        break;
      case "beforeResize":
        callbackString = this.callbackOnBeforeResize;
        break;
    }
    if (callbackString) {
      callbackString =
        callbackString +
        "(DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "])";
    }
    try {
      return eval(callbackString);
    } catch (e) {
      alert("Could not execute call back string after resize");
    }
  },
};
DHTMLSuite.colorPalette = function (propertyArray) {
  let divElement;
  let layoutCSS;
  let colors;
  let colorHelper;
  let width;
  let callbackOnColorClick;
  let objectIndex;
  let currentColor;
  try {
    this.colorHelper = new DHTMLSuite.colorUtil();
  } catch (e) {
    alert("Include dhtmlSuite-colorUtil.js");
  }
  this.layoutCSS = "color-palette.css";
  this.colors = new Array();
  this.currentColor = new Object();
  if (propertyArray) this.__setInitProps(propertyArray);
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
};
DHTMLSuite.colorPalette.prototype = {
  setCallbackOnColorClick: function (functionName) {
    this.callbackOnColorClick = functionName;
  },
  __setInitProps: function (propertyArray) {
    if (propertyArray.width) {
      propertyArray.width = String(propertyArray.width);
      if (propertyArray.width.match(/^[^0-9]*?$/)) {
        propertyArray.width = propertyArray.width + "px";
      }
      this.width = propertyArray.width;
    }
    if (propertyArray.callbackOnColorClick) {
      this.callbackOnColorClick = propertyArray.callbackOnColorClick;
    }
  },
  addAllWebColors: function () {
    const colors = this.colorHelper.getAllWebColors();
    for (let no = 0; no < colors.length; no++) {
      this.colors[this.colors.length] = ["#" + colors[no], "#" + colors[no]];
    }
  },
  addAllNamedColors: function () {
    const colors = this.colorHelper.getAllNamedColors();
    for (let no = 0; no < colors.length; no++) {
      this.colors[this.colors.length] = ["#" + colors[no][1], colors[no][0]];
    }
  },
  addGrayScaleColors: function (numberOfColors, rangeFrom, rangeTo) {
    if (!numberOfColors) numberOfColors = 16;
    if (!rangeFrom) rangeFrom = 0;
    if (!rangeTo) rangeTo = 255;
    if (rangeFrom > rangeTo) {
      const tmpRange = rangeFrom;
      rangeFrom = rangeTo;
      rangeTo = tmpRange;
    }
    const step = (rangeTo - rangeFrom) / numberOfColors;
    for (let no = rangeFrom; no <= rangeTo; no += step) {
      let color = String(
        this.colorHelper.baseConverter(Math.round(no), 10, 16)
      );
      while (color.length < 2) color = "0" + color;
      this.colors[this.colors.length] = [
        "#" + color + color + color,
        "#" + color + color + color,
      ];
    }
  },
  addColor: function (color, name) {
    if (!name) name = color;
    this.colors[this.colors.length] = [color, name];
  },
  setLayoutCss: function (cssFileName) {
    this.layoutCSS = cssFileName;
  },
  getDivElement: function () {
    return this.divElement;
  },
  init: function () {
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    this.__createMainDivEl();
    this.__createColorDivs();
  },
  __createMainDivEl: function () {
    this.divElement = document.createElement("DIV");
    this.divElement.className = "DHTMLSuite_colorPalette";
    if (this.width) {
      this.divElement.style.width = this.width;
    }
  },
  __createColorDivs: function () {
    const ind = this.objectIndex;
    for (let no = 0; no < this.colors.length; no++) {
      const div = document.createElement("DIV");
      div.className = "DHTMLSuite_colorPaletteColor";
      div.setAttribute("rgb", this.colors[no][0]);
      try {
        div.style.backgroundColor = this.colors[no][0];
      } catch (e) {
        div.style.display = "none";
      }
      div.onclick = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__clickOnColor(e);
      };
      DHTMLSuite.commonObj.__addEventEl(div);
      div.title = this.colors[no][1];
      this.divElement.appendChild(div);
    }
    const clearDiv = document.createElement("DIV");
    clearDiv.style.clear = "both";
    this.divElement.appendChild(clearDiv);
  },
  __clickOnColor: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    this.currentColor.rgb = src.getAttribute("rgb");
    if (!this.currentColor.rgb) this.currentColor.rgb = src.rgb;
    this.currentColor.name = src.title;
    this.__handleCallback("colorClick");
  },
  __handleCallback: function (action) {
    let callbackString = "";
    switch (action) {
      case "colorClick":
        if (this.callbackOnColorClick) {
          callbackString = this.callbackOnColorClick;
        }
        break;
    }
    if (callbackString) {
      callbackString =
        callbackString +
        "({rgb:this.currentColor.rgb,name:this.currentColor.name})";
      eval(callbackString);
    }
  },
};
DHTMLSuite.colorSlider = function (propertyArray) {
  let divElement;
  let layoutCSS;
  let colorHelper;
  let currentRgb;
  let currentRed;
  let currentGreen;
  let currentBlue;
  let objectIndex;
  let frmFieldRed;
  let frmFieldGreen;
  let frmFieldBlue;
  let callbackOnChangeRgb;
  this.currentRgb = "FF0000";
  this.currentRed = 255;
  this.currentBlue = 0;
  this.currentGreen = 0;
  this.currentRedHex = "FF";
  this.currentGreenHex = "00";
  this.currentBlueHex = "00";
  this.layoutCSS = "color-slider.css";
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  try {
    this.colorHelper = new DHTMLSuite.colorUtil();
  } catch (e) {
    alert("Include dhtmlSuite-colorUtil.js");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
  if (propertyArray) this.__setInitProps(propertyArray);
};
DHTMLSuite.colorSlider.prototype = {
  __setInitProps: function (props) {
    if (props.callbackOnChangeRgb) {
      this.callbackOnChangeRgb = props.callbackOnChangeRgb;
    }
  },
  init: function () {
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    this.__createMainDivEl();
    this.__createDivPreview();
    this.__createSliderDiv();
    this.__createColorDiv();
    this.__setPreviewDivBgColor();
  },
  setRgbColor: function (rgbCode) {
    rgbCode = String(rgbCode);
    rgbCode = rgbCode.replace(/[^0-9A-F]/gi, "");
    if (rgbCode.length != 6) return false;
    this.currentRgb = rgbCode;
    this.__setParamsFromCurrentRgb();
    try {
      this.__updateSliderHandles();
      this.__updateFormFields();
      this.__setPreviewDivBgColor();
    } catch (e) {}
  },
  getDivElement: function () {
    return this.divElement;
  },
  __createMainDivEl: function () {
    this.divElement = document.createElement("DIV");
    this.divElement.className = "DHTMLSuite_colorSlider";
  },
  __createDivPreview: function () {
    const div = document.createElement("DIV");
    div.className = "DHTMLSuite_colorSliderPreviewParent";
    this.divPreview = document.createElement("DIV");
    this.divPreview.className = "DHTMLSuite_colorSliderPreview";
    div.appendChild(this.divPreview);
    this.divElement.appendChild(div);
  },
  __createSliderDiv: function () {
    const ind = this.objectIndex;
    const div = document.createElement("DIV");
    div.className = "DHTMLSuite_colorSliderSliderParent";
    this.divElement.appendChild(div);
    const divRed = document.createElement("DIV");
    divRed.className = "DHTMLSuite_colorSliderSliderColorRow";
    div.appendChild(divRed);
    var labelDiv = document.createElement("DIV");
    labelDiv.className = "DHTMLSuite_colorSliderSliderLabelDiv";
    labelDiv.innerHTML = "R";
    divRed.appendChild(labelDiv);
    var sliderDiv = document.createElement("DIV");
    sliderDiv.className = "DHTMLSuite_colorSliderSlider";
    divRed.appendChild(sliderDiv);
    try {
      var sliderObj = new DHTMLSuite.slider();
    } catch (e) {
      alert("Error-you need to include dhtmlSuite-slider.js");
    }
    sliderObj.setSliderTarget(sliderDiv);
    sliderObj.setSliderWidth(240);
    sliderObj.setOnChangeEvent(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__receiveRedFromSlider"
    );
    sliderObj.setSliderName("red");
    sliderObj.setInitialValue(this.currentRed);
    sliderObj.setSliderMaxValue(255);
    sliderObj.init();
    this.sliderObjRed = sliderObj;
    var inputDiv = document.createElement("DIV");
    inputDiv.className = "DHTMLSuite_colorSliderSliderInputDiv";
    this.frmFieldRed = document.createElement("INPUT");
    this.frmFieldRed.value = this.currentRed;
    this.frmFieldRed.maxLength = 3;
    inputDiv.appendChild(this.frmFieldRed);
    divRed.appendChild(inputDiv);
    this.frmFieldRed.onchange = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveRedFromForm(e);
    };
    DHTMLSuite.commonObj.__addEventEl(this.frmFieldRed);
    const divGreen = document.createElement("DIV");
    divGreen.className = "DHTMLSuite_colorSliderSliderColorRow";
    div.appendChild(divGreen);
    var labelDiv = document.createElement("DIV");
    labelDiv.className = "DHTMLSuite_colorSliderSliderLabelDiv";
    labelDiv.innerHTML = "G";
    divGreen.appendChild(labelDiv);
    var sliderDiv = document.createElement("DIV");
    sliderDiv.className = "DHTMLSuite_colorSliderSlider";
    divGreen.appendChild(sliderDiv);
    var sliderObj = new DHTMLSuite.slider();
    sliderObj.setSliderTarget(sliderDiv);
    sliderObj.setSliderWidth(240);
    sliderObj.setOnChangeEvent(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__receiveGreenFromSlider"
    );
    sliderObj.setSliderName("green");
    sliderObj.setInitialValue(this.currentGreen);
    sliderObj.setSliderMaxValue(255);
    sliderObj.init();
    this.sliderObjGreen = sliderObj;
    var inputDiv = document.createElement("DIV");
    inputDiv.className = "DHTMLSuite_colorSliderSliderInputDiv";
    this.frmFieldGreen = document.createElement("INPUT");
    this.frmFieldGreen.value = this.currentGreen;
    this.frmFieldGreen.maxLength = 3;
    inputDiv.appendChild(this.frmFieldGreen);
    divGreen.appendChild(inputDiv);
    this.frmFieldGreen.onchange = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveGreenFromForm(e);
    };
    DHTMLSuite.commonObj.__addEventEl(this.frmFieldGreen);
    const divBlue = document.createElement("DIV");
    divBlue.className = "DHTMLSuite_colorSliderSliderColorRow";
    div.appendChild(divBlue);
    var labelDiv = document.createElement("DIV");
    labelDiv.className = "DHTMLSuite_colorSliderSliderLabelDiv";
    labelDiv.innerHTML = "B";
    divBlue.appendChild(labelDiv);
    var sliderDiv = document.createElement("DIV");
    sliderDiv.className = "DHTMLSuite_colorSliderSlider";
    divBlue.appendChild(sliderDiv);
    var sliderObj = new DHTMLSuite.slider();
    sliderObj.setSliderTarget(sliderDiv);
    sliderObj.setSliderWidth(240);
    sliderObj.setOnChangeEvent(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].__receiveBlueFromSlider"
    );
    sliderObj.setSliderName("blue");
    sliderObj.setInitialValue(this.currentBlue);
    sliderObj.setSliderMaxValue(255);
    sliderObj.init();
    this.sliderObjBlue = sliderObj;
    var inputDiv = document.createElement("DIV");
    inputDiv.className = "DHTMLSuite_colorSliderSliderInputDiv";
    this.frmFieldBlue = document.createElement("INPUT");
    this.frmFieldBlue.value = this.currentBlue;
    this.frmFieldBlue.maxLength = 3;
    this.frmFieldBlue.onchange = function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveBlueFromForm(e);
    };
    DHTMLSuite.commonObj.__addEventEl(this.frmFieldBlue);
    inputDiv.appendChild(this.frmFieldBlue);
    divBlue.appendChild(inputDiv);
  },
  __getValidatedFormVar: function (e) {
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    let val = src.value;
    val = val.replace(/[^0-9]/gi, "");
    if (!val) val = 0;
    val = val / 1;
    if (val < 0) val = 0;
    if (val > 255) val = 255;
    return val;
  },
  __receiveRedFromForm: function (e) {
    if (document.all) e = event;
    this.currentRed = this.__getValidatedFormVar(e);
    this.currentRedHex = String(
      this.colorHelper.baseConverter(this.currentRed, 10, 16)
    );
    while (this.currentRedHex.length < 2) {
      this.currentRedHex = "0" + this.currentRedHex;
    }
    this.currentRgb =
      this.currentRedHex + this.currentGreenHex + this.currentBlueHex;
    this.__updateSliderHandles();
    this.__updateFormFields();
    this.__setPreviewDivBgColor();
  },
  __receiveGreenFromForm: function (e) {
    if (document.all) e = event;
    this.currentGreen = this.__getValidatedFormVar(e);
    this.currentGreenHex = String(
      this.colorHelper.baseConverter(this.currentGreen, 10, 16)
    );
    while (this.currentGreenHex.length < 2) {
      this.currentGreenHex = "0" + this.currentGreenHex;
    }
    this.currentRgb =
      this.currentRedHex + this.currentGreenHex + this.currentBlueHex;
    this.__updateSliderHandles();
    this.__updateFormFields();
    this.__setPreviewDivBgColor();
  },
  __receiveBlueFromForm: function (e) {
    if (document.all) e = event;
    this.currentBlue = this.__getValidatedFormVar(e);
    this.currentBlueHex = String(
      this.colorHelper.baseConverter(this.currentBlue, 10, 16)
    );
    while (this.currentBlueHex.length < 2) {
      this.currentBlueHex = "0" + this.currentBlueHex;
    }
    this.currentRgb =
      this.currentRedHex + this.currentGreenHex + this.currentBlueHex;
    this.__updateSliderHandles();
    this.__updateFormFields();
    this.__setPreviewDivBgColor();
  },
  __createColorDiv: function () {
    const ind = this.objectIndex;
    const div = document.createElement("DIV");
    div.className = "DHTMLSuite_colorSliderRgbBgParent";
    this.divElement.appendChild(div);
    this.colorDiv = document.createElement("DIV");
    this.colorDiv.className = "DHTMLSuite_colorSliderRgbBg";
    div.appendChild(this.colorDiv);
    DHTMLSuite.commonObj.addEvent(this.colorDiv, "click", function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__clickOnRgbBg(e);
    });
  },
  __setPreviewDivBgColor: function () {
    try {
      this.divPreview.style.backgroundColor = "#" + this.currentRgb;
      this.__handleCallback("rgbChange");
    } catch (e) {
      alert(this.currentRgb);
    }
  },
  __setParamsFromCurrentRgb: function () {
    this.currentRedHex = this.currentRgb.substr(0, 2);
    this.currentGreenHex = this.currentRgb.substr(2, 2);
    this.currentBlueHex = this.currentRgb.substr(4, 2);
    this.currentRed = this.colorHelper.baseConverter(
      this.currentRedHex,
      16,
      10
    );
    this.currentGreen = this.colorHelper.baseConverter(
      this.currentGreenHex,
      16,
      10
    );
    this.currentBlue = this.colorHelper.baseConverter(
      this.currentBlueHex,
      16,
      10
    );
  },
  __clickOnRgbBg: function (e) {
    const left = DHTMLSuite.commonObj.getLeftPos(this.colorDiv);
    const top = DHTMLSuite.commonObj.getTopPos(this.colorDiv);
    if (document.all) e = event;
    const width = 350;
    const height = 20;
    let y = e.clientY - top;
    let x = e.clientX - left - 1;
    if (e.layerX) {
      x = e.layerX;
      y = e.layerY;
    }
    if (y > height) y = height;
    if (x <= 350) {
      this.currentRgb = this.__getHorizColor(y * width + x - 1, width, height);
      this.__setParamsFromCurrentRgb();
    } else {
      this.currentRgb = "000000";
      this.currentRedHex = "00";
      this.currentGreenHex = "00";
      this.currentBlueHex = "00";
      this.currentRed = 0;
      this.currentGreen = 0;
      this.currentBlue = 0;
    }
    this.__updateSliderHandles();
    this.__updateFormFields();
    this.__setPreviewDivBgColor();
  },
  __updateSliderHandles: function () {
    this.sliderObjRed.setSliderValue(this.currentRed);
    this.sliderObjGreen.setSliderValue(this.currentGreen);
    this.sliderObjBlue.setSliderValue(this.currentBlue);
  },
  __updateFormFields: function () {
    this.frmFieldRed.value = this.currentRed;
    this.frmFieldGreen.value = this.currentGreen;
    this.frmFieldBlue.value = this.currentBlue;
  },
  __receiveRedFromSlider: function (value) {
    this.frmFieldRed.value = value;
    this.currentRed = value;
    this.currentRedHex = String(this.colorHelper.baseConverter(value, 10, 16));
    if (this.currentRedHex.length == 1) {
      this.currentRedHex = "0" + this.currentRedHex;
    }
    this.currentRgb =
      this.currentRedHex + this.currentGreenHex + this.currentBlueHex;
    this.__setPreviewDivBgColor();
  },
  __receiveGreenFromSlider: function (value) {
    this.frmFieldGreen.value = value;
    this.currentGreen = value;
    this.currentGreenHex = String(
      this.colorHelper.baseConverter(value, 10, 16)
    );
    if (this.currentGreenHex.length == 1) {
      this.currentGreenHex = "0" + this.currentGreenHex;
    }
    this.currentRgb =
      this.currentRedHex + this.currentGreenHex + this.currentBlueHex;
    this.__setPreviewDivBgColor();
  },
  __receiveBlueFromSlider: function (value) {
    this.frmFieldBlue.value = value;
    this.currentBlue = value;
    this.currentBlueHex = String(this.colorHelper.baseConverter(value, 10, 16));
    if (this.currentBlueHex.length == 1) {
      this.currentBlueHex = "0" + this.currentBlueHex;
    }
    this.currentRgb =
      this.currentRedHex + this.currentGreenHex + this.currentBlueHex;
    this.__setPreviewDivBgColor();
  },
  __getHorizColor: function (i, width, height) {
    const sWidth = width / 7;
    const C = i % width;
    const R = Math.floor(i / (sWidth * 7));
    const c = i % sWidth;
    let r, g, b, h;
    const l = (255 / sWidth) * c;
    if (C >= sWidth * 6) {
      r = g = b = 255 - l;
    } else {
      h = 255 - l;
      r =
        C < sWidth
          ? 255
          : C < sWidth * 2
          ? h
          : C < sWidth * 4
          ? 0
          : C < sWidth * 5
          ? l
          : 255;
      g = C < sWidth ? l : C < sWidth * 3 ? 255 : C < sWidth * 4 ? h : 0;
      b = C < sWidth * 2 ? 0 : C < sWidth * 3 ? l : C < sWidth * 5 ? 255 : h;
      if (R < height / 2) {
        var base = 255 - ((255 * 2) / height) * R;
        r = base + (r * R * 2) / height;
        g = base + (g * R * 2) / height;
        b = base + (b * R * 2) / height;
      } else if (R > height / 2) {
        var base = (height - R) / (height / 2);
        r = r * base;
        g = g * base;
        b = b * base;
      }
    }
    let red = String(this.colorHelper.baseConverter(r, 10, 16));
    if (red.length == "1") red = "0" + red;
    let green = String(this.colorHelper.baseConverter(g, 10, 16));
    if (green.length == "1") green = "0" + green;
    let blue = String(this.colorHelper.baseConverter(b, 10, 16));
    if (blue.length == "1") blue = "0" + blue;
    return red + green + blue;
  },
  __handleCallback: function (action) {
    let callbackString = "";
    switch (action) {
      case "rgbChange":
        if (this.callbackOnChangeRgb) callbackString = this.callbackOnChangeRgb;
        break;
    }
    if (callbackString) {
      const rgb = this.currentRgb.toUpperCase();
      callbackString =
        callbackString + '({rgb:"#' + rgb + '",name:"#' + rgb + '"})';
      return eval(callbackString);
    }
  },
};
DHTMLSuite.colorWidget = function (propertyArray) {
  let divElement;
  let divElPalette;
  let divElPaletteCircle;
  let divElHueBar;
  let sliderDiv;
  let updateFormDuringMoveOnPalette;
  let layoutCSS;
  let objectIndex;
  let currentHue;
  let currentBrightness;
  let currentSaturation;
  let currentRgbCode;
  let colorHelper;
  let dragObject;
  let topPosHueBar;
  let paletteSize;
  let formFieldHue;
  let formFieldSaturation;
  let formFieldBrightness;
  let formFieldBlue;
  let formFieldGreen;
  let formFieldRed;
  let displayHsv;
  let displayRgb;
  let displayRgbCode;
  this.displayRgb = true;
  this.displayHsv = true;
  this.displayRgbCode = true;
  this.updateFormDuringMoveOnPalette = true;
  let hueSliderPosition;
  let circleOffsetSize;
  let posdivElPalette;
  let parentRef;
  this.posdivElPalette = new Object();
  let circleOffsetBecauseOfWinWidget;
  let callbackOnChangeRgb;
  this.circleOffsetBecauseOfWinWidget = 0;
  this.circleOffsetSize = 7;
  this.hueSliderPosition = "vertical";
  this.layoutCSS = "color-widget.css";
  this.currentHue = 0;
  this.currentBrightness = 100;
  this.currentSaturation = 100;
  this.paletteSize = 256;
  this.currentRgbCode = "FF0000";
  try {
    this.colorHelper = new DHTMLSuite.colorUtil();
  } catch (e) {
    alert("Include dhtmlSuite-colorUtil.js");
  }
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
  this.__setInitProps(propertyArray);
};
DHTMLSuite.colorWidget.prototype = {
  __setInitProps: function (propertyArray) {
    if (!propertyArray) return;
    if (propertyArray.hueSliderPosition) {
      this.hueSliderPosition = propertyArray.hueSliderPosition;
    }
    if (propertyArray.callbackOnChangeRgb) {
      this.callbackOnChangeRgb = propertyArray.callbackOnChangeRgb;
    }
    if (propertyArray.displayHsv || propertyArray.displayHsv === false) {
      this.displayHsv = propertyArray.displayHsv;
    }
    if (propertyArray.displayRgb || propertyArray.displayRgb === false) {
      this.displayRgb = propertyArray.displayRgb;
    }
    if (
      propertyArray.displayRgbCode ||
      propertyArray.displayRgbCode === false
    ) {
      this.displayRgbCode = propertyArray.displayRgbCode;
    }
    if (
      propertyArray.updateFormDuringMoveOnPalette ||
      propertyArray.updateFormDuringMoveOnPalette === false
    ) {
      this.updateFormDuringMoveOnPalette =
        propertyArray.updateFormDuringMoveOnPalette;
    }
    if (propertyArray.parentRef) {
      this.parentRef = DHTMLSuite.commonObj.getEl(propertyArray.parentRef);
    }
  },
  setHueSliderPosition: function (hueSliderPosition) {
    this.hueSliderPosition = hueSliderPosition;
    if (hueSliderPosition == "vertical") {
      this.sliderDivHorMain.style.display = "none";
      this.sliderDivMain.style.display = "block";
      const ind = this.objectIndex;
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          "].sliderDiv.style.marginTop=(2-Math.floor(DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          '].sliderDiv.offsetHeight/2))+"px"',
        100
      );
    }
    if (hueSliderPosition == "horizontal") {
      if (this.sliderDivMain) {
        this.sliderDivHorMain.style.display = "block";
        this.sliderDivMain.style.display = "none";
      }
    }
  },
  setCallbackOnChangeRgb: function (functionName) {
    this.callbackOnChangeRgb = functionName;
  },
  setRgbColor: function (rgbColor) {
    const hsv = this.colorHelper.getHsvByRgbCode(rgbColor);
    this.currentHue = Math.round(hsv.hue);
    this.currentBrightness = Math.round(hsv.brightness * 100);
    this.currentSaturation = Math.round(hsv.saturation * 100);
    this.__changeViewAfterColorChange();
  },
  setHue: function (hue) {
    hue = String(hue);
    if (hue.match(/^[0-9]+$/)) {
      while (hue >= 360) hue -= 360;
      this.currentHue = hue;
      this.__changeViewAfterColorChange();
    }
  },
  setSaturation: function (saturation) {
    saturation = String(saturation);
    if (saturation.match(/^[0-9]+$/)) {
      while (saturation > 100) saturation -= 100;
      this.currentSaturation = saturation;
      this.__changeViewAfterColorChange();
    }
  },
  setBrightness: function (brightness) {
    brightness = String(brightness);
    if (brightness.match(/^[0-9]+$/)) {
      while (brightness > 100) brightness -= 100;
      this.currentBrightness = brightness;
      this.__changeViewAfterColorChange();
    }
  },
  getDivElement: function () {
    return this.divElement;
  },
  init: function () {
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
    this.__createMainDivEl();
    this.__createdivElPalette();
    this.__createHueBar();
    this.__createFormDiv();
    this.__createHueBarHorizontal();
    this.__addEvents();
    this.__setPaletteBgColor();
    this.__updateHsvInForm();
    this.__setBgColorPreviewDiv();
    this.__updateRgbInForm();
  },
  __changeViewAfterColorChange: function () {
    this.__setCurrentRgbCode();
    this.__setPaletteBgColor();
    this.__setBgColorPreviewDiv();
    this.__setSliderPos();
    this.__updateRgbInForm();
    this.__updateHsvInForm();
    this.__setSmallCirclePosition();
  },
  __updateHsvInForm: function () {
    if (!this.displayHsv) return;
    this.fieldHue.value = this.currentHue;
    this.fieldSaturation.value = this.currentSaturation;
    this.fieldBrightness.value = this.currentBrightness;
  },
  __updateRgbInForm: function () {
    const rgbColors = this.colorHelper.getRgbColorsByRgbCode(
      this.currentRgbCode
    );
    if (this.displayRgb) {
      this.fieldBlue.value = rgbColors.blue;
      this.fieldRed.value = rgbColors.red;
      this.fieldGreen.value = rgbColors.green;
    }
    if (this.displayRgbCode) {
      this.fieldRgbCode.value = this.currentRgbCode;
    }
    if (this.callbackOnChangeRgb) this.__handleCallback("rgbChange");
  },
  __setSliderPos: function () {
    const topPos =
      Math.round(
        this.paletteSize - (this.currentHue / 360) * this.paletteSize
      ) - 3;
    this.sliderDiv.style.top = topPos;
    this.sliderDivHor.style.left = this.currentHue - 4 + "px";
  },
  __setBgColorPreviewDiv: function () {
    this.divElPreviewDiv.style.backgroundColor = "#" + this.currentRgbCode;
  },
  __setPaletteBgColor: function () {
    try {
      this.divElPalette.style.backgroundColor =
        "#" + this.colorHelper.getRgbCodeByHsv(this.currentHue, 1, 1);
    } catch (e) {}
  },
  __createFormDiv: function () {
    const ind = this.objectIndex;
    this.divElForm = document.createElement("DIV");
    this.divElForm.className = "DHTMLSuite_colorSliderFormDiv";
    this.divElement.appendChild(this.divElForm);
    this.divElPreviewDiv = document.createElement("DIV");
    this.divElPreviewDiv.className = "DHTMLSuite_colorSlider_colorPreview";
    this.divElForm.appendChild(this.divElPreviewDiv);
    const table = document.createElement("TABLE");
    table.cellpadding = 0;
    table.cellspacing = 0;
    table.className = "DHTMLSuite_colorSliderFormTable";
    const form = document.createElement("FORM");
    table.appendChild(form);
    this.divElForm.appendChild(table);
    if (this.displayHsv) {
      var row = table.insertRow(-1);
      var cell = row.insertCell(-1);
      cell.innerHTML = "H:";
      var cell = row.insertCell(-1);
      this.fieldHue = document.createElement("INPUT");
      this.fieldHue.onchange = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveHueFromForm(e);
      };
      DHTMLSuite.commonObj.__addEventEl(this.fieldHue);
      this.fieldHue.maxLength = 3;
      cell.appendChild(this.fieldHue);
      var row = table.insertRow(-1);
      var cell = row.insertCell(-1);
      cell.innerHTML = "S:";
      var cell = row.insertCell(-1);
      this.fieldSaturation = document.createElement("INPUT");
      this.fieldSaturation.maxLength = 3;
      this.fieldSaturation.onchange = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveSatFromForm(e);
      };
      DHTMLSuite.commonObj.__addEventEl(this.fieldSaturation);
      cell.appendChild(this.fieldSaturation);
      var row = table.insertRow(-1);
      var cell = row.insertCell(-1);
      cell.innerHTML = "B:";
      var cell = row.insertCell(-1);
      this.fieldBrightness = document.createElement("INPUT");
      this.fieldBrightness.onchange = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveBriFromForm(e);
      };
      DHTMLSuite.commonObj.__addEventEl(this.fieldBrightness);
      this.fieldBrightness.maxLength = 3;
      cell.appendChild(this.fieldBrightness);
    }
    if (this.displayRgb) {
      var row = table.insertRow(-1);
      var cell = row.insertCell(-1);
      cell.innerHTML = "R:";
      var cell = row.insertCell(-1);
      this.fieldRed = document.createElement("INPUT");
      this.fieldRed.onchange = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__setRedColorFromForm(e);
      };
      DHTMLSuite.commonObj.__addEventEl(this.fieldRed);
      this.fieldRed.maxLength = 3;
      cell.appendChild(this.fieldRed);
      var row = table.insertRow(-1);
      var cell = row.insertCell(-1);
      cell.innerHTML = "G:";
      var cell = row.insertCell(-1);
      this.fieldGreen = document.createElement("INPUT");
      this.fieldGreen.onchange = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__setGreenColorFromForm(
          e
        );
      };
      DHTMLSuite.commonObj.__addEventEl(this.fieldGreen);
      this.fieldGreen.maxLength = 3;
      cell.appendChild(this.fieldGreen);
      var row = table.insertRow(-1);
      var cell = row.insertCell(-1);
      cell.innerHTML = "B:";
      var cell = row.insertCell(-1);
      this.fieldBlue = document.createElement("INPUT");
      this.fieldBlue.onchange = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__setBlueColorFromForm(
          e
        );
      };
      DHTMLSuite.commonObj.__addEventEl(this.fieldBlue);
      this.fieldBlue.maxLength = 3;
      cell.appendChild(this.fieldBlue);
    }
    if (this.displayRgbCode) {
      var row = table.insertRow(-1);
      var cell = row.insertCell(-1);
      cell.innerHTML = "#";
      var cell = row.insertCell(-1);
      this.fieldRgbCode = document.createElement("INPUT");
      this.fieldRgbCode.maxLength = 6;
      this.fieldRgbCode.className = "DHTMLSuite_colorSlider_rgbCode";
      this.fieldRgbCode.onchange = function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__receiveRgbCodeFromForm(
          e
        );
      };
      DHTMLSuite.commonObj.__addEventEl(this.fieldRgbCode);
      cell.appendChild(this.fieldRgbCode);
    }
  },
  __createMainDivEl: function () {
    this.divElement = document.createElement("DIV");
    this.divElement.className = "DHTMLSuite_colorSlider";
    if (this.parentRef) this.parentRef.appendChild(this.divElement);
  },
  __correctPng: function (id) {
    try {
      const img = document.getElementById(id);
      const html =
        "<span style=\"display:inline-block;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" +
        img.src +
        "',sizingMethod='scale');width:" +
        this.paletteSize +
        ";height:" +
        this.paletteSize +
        '"></span>';
      img.outerHTML = html;
    } catch (e) {
      const ind = this.objectIndex;
      setTimeout(
        "DHTMLSuite.variableStorage.arrayDSObjects[" +
          ind +
          '].__correctPng("' +
          id +
          '")',
        20
      );
    }
  },
  __createdivElPalette: function () {
    const ind = this.objectIndex;
    const div = document.createElement("DIV");
    div.className = "DHTMLSuite_colorSlider_palette_border";
    div.style.position = "relative";
    this.divElement.appendChild(div);
    this.divElPaletteBorder = div;
    this.divElPalette = document.createElement("DIV");
    this.divElPalette.className = "DHTMLSuite_colorSlider_palette";
    this.divElPalette.style.position = "relative";
    DHTMLSuite.commonObj.__addEventEl(this.divElPalette);
    const img = document.createElement("IMG");
    img.src = DHTMLSuite.configObj.imagePath + "colorPalettes/bgGradient.png";
    img.setAttribute("width", this.paletteSize);
    img.setAttribute("height", this.paletteSize);
    img.ondragstart = function () {
      return false;
    };
    img.onselectstart = function () {
      return false;
    };
    img.onmousedown = function () {
      return false;
    };
    img.id = String(DHTMLSuite.commonObj.getUniqueId());
    this.divElPalette.appendChild(img);
    DHTMLSuite.commonObj.__addEventEl(img);
    if (
      (DHTMLSuite.clientInfoObj.isMSIE &&
        DHTMLSuite.clientInfoObj.navigatorVersion < 7) ||
      DHTMLSuite.clientInfoObj.isOpera
    ) {
      this.__correctPng(img.id);
    }
    div.appendChild(this.divElPalette);
    this.divElPaletteCircle = document.createElement("DIV");
    this.divElPaletteCircle.className = "DHTMLSuite_colorSlider_palette_circle";
    this.divElPalette.appendChild(this.divElPaletteCircle);
    this.divElPaletteCircle.display = "block";
    this.divElPaletteCircle.style.top = "-" + this.circleOffsetSize + "px";
    this.divElPaletteCircle.style.left =
      this.paletteSize - this.circleOffsetSize + "px";
  },
  __setSmallCirclePosition: function () {
    const leftPos =
      Math.round(this.currentSaturation * (this.paletteSize / 100)) -
      this.circleOffsetSize;
    const topPos =
      this.paletteSize -
      Math.round(this.currentBrightness * (this.paletteSize / 100)) -
      this.circleOffsetSize;
    this.divElPaletteCircle.style.left = leftPos + "px";
    this.divElPaletteCircle.style.top = topPos + "px";
    this.divElPaletteCircle.className =
      this.divElPaletteCircle.className.replace(
        " DHTMLSuite_colorSlider_palette_circleBlack",
        ""
      );
    if (this.currentBrightness > 80) {
      this.divElPaletteCircle.className =
        this.divElPaletteCircle.className +
        " DHTMLSuite_colorSlider_palette_circleBlack";
    }
  },
  __createHueBar: function () {
    const ind = this.objectIndex;
    const mainDiv = document.createElement("DIV");
    mainDiv.className = "DHTMLSuite_colorSlider_hue";
    this.sliderDivMain = mainDiv;
    this.divElement.appendChild(mainDiv);
    this.sliderDiv = document.createElement("DIV");
    this.sliderDiv.className = "DHTMLSuite_colorSlider_sliderHandle";
    mainDiv.appendChild(this.sliderDiv);
    this.sliderDiv.innerHTML = "<div><span></span></div>";
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].sliderDiv.style.marginTop=(2-Math.floor(DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        '].sliderDiv.offsetHeight/2))+"px"',
      100
    );
    const div = document.createElement("DIV");
    div.className = "DHTMLSuite_colorSlider_hueBar_border";
    mainDiv.appendChild(div);
    this.divElHueBar = document.createElement("DIV");
    this.divElHueBar.className = "DHTMLSuite_colorSlider_hueBar";
    div.appendChild(this.divElHueBar);
    if (this.hueSliderPosition == "horizontal") mainDiv.style.display = "none";
  },
  __createHueBarHorizontal: function () {
    const ind = this.objectIndex;
    this.sliderDivHorMain = document.createElement("DIV");
    this.sliderDivHorMain.className = "DHTMLSuite_colorSlider_hueHorizontal";
    this.divElement.appendChild(this.sliderDivHorMain);
    this.sliderDivHor = document.createElement("DIV");
    this.sliderDivHor.className =
      "DHTMLSuite_colorSlider_sliderHandleHorizontal";
    this.sliderDivHorMain.appendChild(this.sliderDivHor);
    this.sliderDivHor.innerHTML = "<div><span></span></div>";
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        "].sliderDiv.style.marginTop=(2-Math.floor(DHTMLSuite.variableStorage.arrayDSObjects[" +
        ind +
        '].sliderDiv.offsetHeight/2))+"px"',
      100
    );
    const div = document.createElement("DIV");
    div.className = "DHTMLSuite_colorSlider_hueBarHorizontal_border";
    this.sliderDivHorMain.appendChild(div);
    this.divElHueBarHorizontal = document.createElement("DIV");
    this.divElHueBarHorizontal.className =
      "DHTMLSuite_colorSlider_hueBarHorizontal";
    div.appendChild(this.divElHueBarHorizontal);
    if (this.hueSliderPosition == "vertical") {
      this.sliderDivHorMain.style.display = "none";
    }
  },
  __setHueFromHorizontalSlider: function (e) {
    if (document.all) e = event;
    let hue = this.sliderDivHor.offsetLeft + 4;
    if (hue > 359 || hue < 0) hue = 0;
    this.currentHue = hue;
    this.__setPaletteBgColor();
    this.__setBgColorPreviewDiv();
    this.__updateRgbInForm();
    this.__updateHsvInForm();
  },
  __setHueFromSlider: function (e) {
    if (document.all) e = event;
    let hue =
      360 -
      Math.round((this.sliderDiv.offsetTop + 4) * (360 / this.paletteSize));
    if (hue > 359 || hue < 0) hue = 0;
    this.currentHue = hue;
    this.__setPaletteBgColor();
    this.__setBgColorPreviewDiv();
    this.__updateHsvInForm();
    this.__updateRgbInForm();
  },
  __addEvents: function () {
    const ind = this.objectIndex;
    DHTMLSuite.commonObj.addEvent(
      this.sliderDivHorMain,
      "mousedown",
      function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__initHorHueMove(
          e
        );
      }
    );
    DHTMLSuite.commonObj.addEvent(
      this.sliderDivMain,
      "mousedown",
      function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__initHueMove(e);
      }
    );
    DHTMLSuite.commonObj.addEvent(this.divElPalette, "mousedown", function (e) {
      return DHTMLSuite.variableStorage.arrayDSObjects[ind].__initPaletteMove(
        e
      );
    });
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mousemove",
      function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOnPalette(e);
      }
    );
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mousemove",
      function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOnHorizHueBar(e);
      }
    );
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mousemove",
      function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOnHueBar(e);
      }
    );
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      "mouseup",
      function (e) {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__endDrag(e);
      }
    );
    DHTMLSuite.commonObj.addEvent(this.divElHueBar, "mousedown", function (e) {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveOnHueBar(e);
    });
    if (!document.documentElement.onselectstart) {
      document.documentElement.onselectstart = function () {
        return DHTMLSuite.commonObj.__isTextSelOk();
      };
      DHTMLSuite.commonObj.__addEventEl(document.documentElement);
    }
  },
  __moveOnHueBar: function (e) {
    if (this.hueStatus != 1) return;
    if (document.all) e = event;
    const topPos = this.poxYHue;
    let diff = e.clientY + document.documentElement.scrollTop - topPos;
    if (diff > this.paletteSize) diff = this.paletteSize;
    if (diff < 0) diff = 0;
    this.sliderDiv.style.top = diff + "px";
    let hue = Math.round((this.paletteSize - diff) * (360 / this.paletteSize));
    if (hue == 360) hue = 0;
    this.currentHue = hue;
    this.__setCurrentRgbCode();
    this.__setPaletteBgColor();
    this.__setBgColorPreviewDiv();
    this.__updateHsvInForm();
    this.__updateRgbInForm();
  },
  __moveOnHorizHueBar: function (e) {
    if (this.hueHorStatus != 1) return;
    if (document.all) e = event;
    const leftPos = this.posXHorHue;
    let diff = e.clientX - leftPos - this.circleOffsetBecauseOfWinWidget;
    if (diff < 0) diff = 0;
    if (diff > 362) diff = 362;
    this.sliderDivHor.style.left = diff - 4 + "px";
    let hue = diff;
    if (hue >= 360) hue = 0;
    this.currentHue = hue;
    this.__setCurrentRgbCode();
    this.__setPaletteBgColor();
    this.__setBgColorPreviewDiv();
    this.__updateHsvInForm();
    this.__updateRgbInForm();
  },
  __setHueFromRgbColorsInForm: function () {
    const color = this.colorHelper.getRgbCodeByRgbColors(
      this.fieldRed.value,
      this.fieldGreen.value,
      this.fieldBlue.value
    );
    const hsv = this.colorHelper.getHsvByRgbCode(color);
    this.currentHue = Math.round(hsv.hue);
    this.currentSaturation = Math.round(hsv.saturation * 100);
    this.currentBrightness = Math.round(hsv.brightness * 100);
    this.__changeViewAfterColorChange();
  },
  __setRedColorFromForm: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    let red = src.value;
    if (red.match(/^[0-9]+$/)) {
      if (red / 1 > 255) red = 255;
    } else {
      red = 0;
    }
    src.value = red;
    this.__setHueFromRgbColorsInForm();
    this.__changeViewAfterColorChange();
  },
  __setGreenColorFromForm: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    var green = src.value;
    var green = src.value;
    if (green.match(/^[0-9]+$/)) {
      if (green / 1 > 255) green = 255;
    } else {
      green = 0;
    }
    src.value = green;
    this.__setHueFromRgbColorsInForm();
    this.__changeViewAfterColorChange();
  },
  __setBlueColorFromForm: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    var blue = src.value;
    var blue = src.value;
    if (blue.match(/^[0-9]+$/)) {
      if (blue / 1 > 255) blue = 255;
    } else {
      blue = 0;
    }
    src.value = blue;
    this.__setHueFromRgbColorsInForm();
  },
  __receiveRgbCodeFromForm: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    let rgbCode = src.value;
    if (!rgbCode.match(/^[0-9A-F][0-9A-F][0-9A-F][0-9A-F][0-9A-F][0-9A-F]$/i)) {
      rgbCode = "FF0000";
    }
    const hsv = this.colorHelper.getHsvByRgbCode(rgbCode);
    this.currentHue = Math.round(hsv.hue);
    this.currentSaturation = Math.round(hsv.saturation * 100);
    this.currentBrightness = Math.round(hsv.brightness * 100);
    this.__changeViewAfterColorChange();
  },
  __receiveHueFromForm: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    let hue = src.value;
    hue = String(hue);
    if (hue.match(/^[0-9]+$/)) {
      if (hue / 1 > 360) hue = 360;
    } else {
      hue = 0;
    }
    if (hue == 360) hue = 0;
    this.currentHue = hue;
    src.value = hue;
    this.__changeViewAfterColorChange();
  },
  __receiveBriFromForm: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    let brightness = src.value;
    brightness = String(brightness);
    if (brightness.match(/^[0-9]+$/)) {
      if (brightness / 1 > 100) brightness = 100;
    } else {
      brightness = 0;
    }
    this.currentBrightness = brightness;
    src.value = brightness;
    this.__changeViewAfterColorChange();
  },
  __receiveSatFromForm: function (e) {
    if (document.all) e = event;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    let saturation = src.value;
    saturation = String(saturation);
    if (saturation.match(/^[0-9]+$/)) {
      if (saturation / 1 > 100) saturation = 100;
    } else {
      saturation = 0;
    }
    this.currentSaturation = saturation;
    src.value = saturation;
    this.__changeViewAfterColorChange();
  },
  __ffHackWinWidget: function () {
    if (
      this.divElement.parentNode.className &&
      this.divElement.parentNode.className.indexOf("windowContent") >= 0 &&
      !document.all
    ) {
      this.circleOffsetBecauseOfWinWidget = 0;
    }
  },
  __initHorHueMove: function (e) {
    this.hueHorStatus = 1;
    this.__ffHackWinWidget();
    this.posXHorHue = DHTMLSuite.commonObj.getLeftPos(
      this.divElHueBarHorizontal
    );
    DHTMLSuite.commonObj.__setTextSelOk(false);
    this.__moveOnHorizHueBar(e);
    return false;
  },
  __initHueMove: function (e) {
    this.hueStatus = 1;
    this.poxYHue = DHTMLSuite.commonObj.getTopPos(this.divElHueBar);
    DHTMLSuite.commonObj.__setTextSelOk(false);
    this.__moveOnHueBar(e);
    return false;
  },
  __initPaletteMove: function (e) {
    if (document.all) e = event;
    this.__ffHackWinWidget();
    this.posdivElPalette.x =
      DHTMLSuite.commonObj.getLeftPos(this.divElPalette) +
      this.circleOffsetBecauseOfWinWidget;
    this.posdivElPalette.y =
      DHTMLSuite.commonObj.getTopPos(this.divElPalette) +
      this.circleOffsetBecauseOfWinWidget;
    this.dragStatus = 1;
    this.paletteMaxX = this.divElPalette.clientWidth - this.circleOffsetSize;
    this.paletteMaxY = this.divElPalette.clientHeight - this.circleOffsetSize;
    this.__moveOnPalette(e);
    DHTMLSuite.commonObj.__setTextSelOk(false);
    return false;
  },
  __setCurrentRgbCode: function () {
    this.currentRgbCode = this.colorHelper.getRgbCodeByHsv(
      this.currentHue,
      this.currentSaturation / 100,
      this.currentBrightness / 100
    );
  },
  __endDrag: function () {
    if (this.dragStatus == 1) {
      this.__updateHsvInForm();
      this.__updateRgbInForm();
    }
    this.dragStatus = 0;
    this.hueHorStatus = 0;
    this.hueStatus = 0;
    DHTMLSuite.commonObj.__setTextSelOk(true);
  },
  __moveOnPalette: function (e) {
    if (this.dragStatus != 1) return;
    if (this.clickOnPaletteInProgress) return;
    this.clickOnPaletteInProgress = true;
    if (document.all) e = event;
    const leftEl = this.posdivElPalette.x;
    const topEl = this.posdivElPalette.y;
    let left =
      e.clientX +
      document.documentElement.scrollLeft -
      leftEl -
      this.circleOffsetSize;
    let top =
      e.clientY +
      document.documentElement.scrollTop -
      topEl -
      this.circleOffsetSize;
    if (left < this.circleOffsetSize * -1) left = this.circleOffsetSize * -1;
    if (top < this.circleOffsetSize * -1) top = this.circleOffsetSize * -1;
    if (left > this.paletteMaxX) left = this.paletteMaxX;
    if (top > this.paletteMaxY) top = this.paletteMaxY;
    this.divElPaletteCircle.style.left = left + "px";
    this.divElPaletteCircle.style.top = top + "px";
    this.currentSaturation = Math.round(
      ((left + this.circleOffsetSize) / this.paletteSize) * 100
    );
    this.currentBrightness =
      100 -
      Math.round(((top + this.circleOffsetSize) / this.paletteSize) * 100);
    this.__setCurrentRgbCode();
    this.__setBgColorPreviewDiv();
    if (this.updateFormDuringMoveOnPalette) {
      this.__updateHsvInForm();
      this.__updateRgbInForm();
    }
    this.clickOnPaletteInProgress = false;
  },
  __handleCallback: function (action) {
    let callbackString = "";
    switch (action) {
      case "rgbChange":
        if (this.callbackOnChangeRgb) callbackString = this.callbackOnChangeRgb;
        break;
    }
    if (callbackString) {
      callbackString =
        callbackString +
        '({rgb:"#"+this.currentRgbCode,hue:this.currentHue,brightness:this.currentBrightness,saturation:this.currentSaturation })';
      eval(callbackString);
    }
  },
};
DHTMLSuite.colorUtil = function () {};
DHTMLSuite.colorUtil.prototype = {
  baseConverter: function (numberToConvert, oldBase, newBase) {
    if (newBase == 10) {
      return parseInt(numberToConvert, 16);
    }
    if (newBase == 16) {
      return parseInt(numberToConvert).toString(16);
    }
    numberToConvert = String(numberToConvert);
    numberToConvert = numberToConvert.toUpperCase();
    const listOfCharacters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let dec = 0;
    for (var i = 0; i <= numberToConvert.length; i++) {
      dec +=
        listOfCharacters.indexOf(numberToConvert.charAt(i)) *
        Math.pow(oldBase, numberToConvert.length - i - 1);
    }
    numberToConvert = "";
    const magnitude = Math.floor(Math.log(dec) / Math.log(newBase));
    for (var i = magnitude; i >= 0; i--) {
      const amount = Math.floor(dec / Math.pow(newBase, i));
      numberToConvert = numberToConvert + listOfCharacters.charAt(amount);
      dec -= amount * Math.pow(newBase, i);
    }
    if (numberToConvert.length == 0) numberToConvertToConvert = 0;
    if (!numberToConvert) numberToConvert = 0;
    return numberToConvert;
  },
  getHsvByRgbCode: function (rgbColor) {
    rgbColor = rgbColor.replace("#", "");
    red = this.baseConverter(rgbColor.substr(0, 2), 16, 10);
    green = this.baseConverter(rgbColor.substr(2, 2), 16, 10);
    blue = this.baseConverter(rgbColor.substr(4, 2), 16, 10);
    if (red == 0 && green == 0 && blue == 0) {
      var returnArray = new Object();
      returnArray.hue = 0;
      returnArray.saturation = 0;
      returnArray.brightness = 0;
      return returnArray;
    }
    red = red / 255;
    green = green / 255;
    blue = blue / 255;
    maxValue = Math.max(red, green, blue);
    minValue = Math.min(red, green, blue);
    let hue = 0;
    if (maxValue == minValue) {
      hue = 0;
      saturation = 0;
    } else {
      if (red == maxValue) {
        hue = (green - blue) / (maxValue - minValue) / 1;
      } else if (green == maxValue) {
        hue = 2 + (blue - red) / 1 / (maxValue - minValue) / 1;
      } else if (blue == maxValue) {
        hue = 4 + (red - green) / (maxValue - minValue) / 1;
      }
      saturation = (maxValue - minValue) / maxValue;
    }
    hue = hue * 60;
    valueBrightness = maxValue;
    if (hue < 0) hue += 360;
    var returnArray = new Object();
    returnArray.hue = hue;
    returnArray.saturation = saturation;
    returnArray.brightness = valueBrightness;
    return returnArray;
  },
  getContrastColorByRgb: function (rgbCode) {
    const hsv = this.getHsvByRgbCode(rgbCode);
    hsv.hue += 180;
    if (hsv.hue >= 360) hsv.hue -= 360;
    return this.getRgbCodeByHsv(hsv.hue, hsv.saturation, hsv.brightness);
  },
  getTriadeColorsByRgb: function (rgbCode) {
    const hsv = this.getHsvByRgbCode(rgbCode);
    const colors = new Array();
    for (let no = 120; no < 360; no += 120) {
      colors[colors.length] = this.getRgbCodeByHsv(
        hsv.hue + no,
        hsv.saturation,
        hsv.brightness
      );
    }
    return colors;
  },
  getTetradeColorsByRgb: function (rgbCode) {
    const hsv = this.getHsvByRgbCode(rgbCode);
    const colors = new Array();
    for (let no = 90; no < 360; no += 90) {
      colors[colors.length] = this.getRgbCodeByHsv(
        hsv.hue + no,
        hsv.saturation,
        hsv.brightness
      );
    }
    return colors;
  },
  getAnalogicColors: function (rgbCode, degrees) {
    degrees = String(degrees);
    if (!degrees) degrees = 25;
    if (!degrees.match(/^[0-9]{2}$/)) {
      degrees = 25;
    }
    if (degrees < 15) degrees = 15;
    if (degrees > 30) degrees = 30;
    degrees /= 1;
    const hsv = this.getHsvByRgbCode(rgbCode);
    const colors = new Array();
    for (var no = 1; no <= 2; no++) {
      colors[colors.length] = this.getRgbCodeByHsv(
        hsv.hue + no * degrees,
        hsv.saturation,
        hsv.brightness
      );
    }
    for (var no = -1; no >= -2; no--) {
      colors[colors.length] = this.getRgbCodeByHsv(
        hsv.hue + no * degrees,
        hsv.saturation,
        hsv.brightness
      );
    }
    return colors;
  },
  getRgbCodeByRgbColors: function (red, green, blue) {
    red = this.baseConverter(red, 10, 16);
    green = this.baseConverter(green, 10, 16);
    blue = this.baseConverter(blue, 10, 16);
    red = String(red);
    green = String(green);
    blue = String(blue);
    while (red.length < 2) {
      red = "0" + red;
    }
    while (green.length < 2) {
      green = "0" + green;
    }
    while (blue.length < 2) {
      blue = "0" + "" + blue;
    }
    rgbColor = String(String(red) + green) + blue;
    return rgbColor.toUpperCase();
  },
  getRgbColorsByRgbCode: function (rgbCode) {
    const retArray = new Object();
    retArray.red = this.baseConverter(rgbCode.substr(0, 2), 16, 10);
    retArray.green = this.baseConverter(rgbCode.substr(2, 2), 16, 10);
    retArray.blue = this.baseConverter(rgbCode.substr(4, 2), 16, 10);
    return retArray;
  },
  getRgbColorsByHsv: function (hue, saturation, valueBrightness) {
    Hi = Math.floor(hue / 60);
    if (hue == 360) hue = 0;
    f = hue / 60 - Hi;
    if (saturation > 1) saturation /= 100;
    if (valueBrightness > 1) valueBrightness /= 100;
    p = valueBrightness * (1 - saturation);
    q = valueBrightness * (1 - f * saturation);
    t = valueBrightness * (1 - (1 - f) * saturation);
    switch (Hi) {
      case 0:
        red = valueBrightness;
        green = t;
        blue = p;
        break;
      case 1:
        red = q;
        green = valueBrightness;
        blue = p;
        break;
      case 2:
        red = p;
        green = valueBrightness;
        blue = t;
        break;
      case 3:
        red = p;
        green = q;
        blue = valueBrightness;
        break;
      case 4:
        red = t;
        green = p;
        blue = valueBrightness;
        break;
      default:
        red = valueBrightness;
        green = p;
        blue = q;
        break;
    }
    if (saturation == 0) {
      red = valueBrightness;
      green = valueBrightness;
      blue = valueBrightness;
    }
    red *= 255;
    green *= 255;
    blue *= 255;
    red = Math.round(red);
    green = Math.round(green);
    blue = Math.round(blue);
    const retArray = new Object();
    retArray.red = red;
    retArray.green = green;
    retArray.blue = blue;
    return retArray;
  },
  getRgbCodeByHsv: function (hue, saturation, valueBrightness) {
    while (hue >= 360) hue -= 360;
    const colors = this.getRgbColorsByHsv(hue, saturation, valueBrightness);
    const red = colors.red;
    const green = colors.green;
    const blue = colors.blue;
    return this.getRgbCodeByRgbColors(red, green, blue);
  },
  getColorByDegrees: function (rgbColor, degrees) {
    rgbColor = rgbColor.replace("#", "");
    myArray = this.getHsvByRgbCode(rgbColor);
    myArray.hue += degrees;
    if (myArray.hue >= 360) myArray.hue -= 360;
    if (myArray.hue < 0) myArray.hue += 360;
    return this.getRgbCodeByHsv(
      myArray.hue,
      myArray.saturation,
      myArray.brightness
    );
  },
  findColorByBrightness: function (rgbColor, brightness) {
    rgbColor = rgbColor.replace("#", "");
    myArray = this.getHsvByRgbCode(rgbColor);
    myArray.brightness += brightness / 100;
    if (myArray.brightness > 1) myArray.brightness = 1;
    if (myArray.brightness < 0) myArray.brightness = 0;
    if (myArray.saturation > 1) myArray.saturation = 1;
    if (myArray.saturation < 0) myArray.saturation = 0;
    return this.getRgbCodeByHsv(
      myArray.hue,
      myArray.saturation,
      myArray.brightness
    );
  },
  getRgbFromNumbers: function (red, green, blue) {
    red = this.baseConverter(red, 10, 16);
    if (red.length == 0) red = "0" + red;
    green = this.baseConverter(green, 10, 16);
    if (green.length == 0) green = "0" + green;
    blue = this.baseConverter(blue, 10, 16);
    if (blue.length == 0) blue = "0" + blue;
    return "#" + red + green + blue;
  },
  getAllWebColors: function () {
    const retArray = new Array();
    for (let red = 0; red <= 15; red += 3) {
      for (let green = 0; green <= 15; green += 3) {
        for (let blue = 0; blue <= 15; blue += 3) {
          const newRed = this.baseConverter(red, 10, 16);
          const newGreen = this.baseConverter(green, 10, 16);
          const newBlue = this.baseConverter(blue, 10, 16);
          retArray[retArray.length] =
            String(
              String(
                String(String(String(newRed) + newRed) + newGreen) + newGreen
              ) + newBlue
            ) + newBlue;
        }
      }
    }
    return retArray;
  },
  getAllNamedColors: function () {
    const c = new Array();
    c[c.length] = ["AliceBlue", "F0F8FF"];
    c[c.length] = ["AntiqueWhite", "FAEBD7"];
    c[c.length] = ["Aqua", "00FFFF"];
    c[c.length] = ["Aquamarine", "7FFFD4"];
    c[c.length] = ["Azure", "F0FFFF"];
    c[c.length] = ["Beige", "F5F5DC"];
    c[c.length] = ["Bisque", "FFE4C4"];
    c[c.length] = ["Black", "000000"];
    c[c.length] = ["BlanchedAlmond", "FFEBCD"];
    c[c.length] = ["Blue", "0000FF"];
    c[c.length] = ["BlueViolet", "8A2BE2"];
    c[c.length] = ["Brown", "A52A2A"];
    c[c.length] = ["BurlyWood", "DEB887"];
    c[c.length] = ["CadetBlue", "5F9EA0"];
    c[c.length] = ["Chartreuse", "7FFF00"];
    c[c.length] = ["Chocolate", "D2691E"];
    c[c.length] = ["Coral", "FF7F50"];
    c[c.length] = ["CornflowerBlue", "6495ED"];
    c[c.length] = ["Cornsilk", "FFF8DC"];
    c[c.length] = ["Crimson", "DC143C"];
    c[c.length] = ["Cyan", "00FFFF"];
    c[c.length] = ["DarkBlue", "00008B"];
    c[c.length] = ["DarkCyan", "008B8B"];
    c[c.length] = ["DarkGoldenRod", "B8860B"];
    c[c.length] = ["DarkGray", "A9A9A9"];
    c[c.length] = ["DarkGrey", "A9A9A9"];
    c[c.length] = ["DarkGreen", "006400"];
    c[c.length] = ["DarkKhaki", "BDB76B"];
    c[c.length] = ["DarkMagenta", "8B008B"];
    c[c.length] = ["DarkOliveGreen", "556B2F"];
    c[c.length] = ["Darkorange", "FF8C00"];
    c[c.length] = ["DarkOrchid", "9932CC"];
    c[c.length] = ["DarkRed", "8B0000"];
    c[c.length] = ["DarkSalmon", "E9967A"];
    c[c.length] = ["DarkSeaGreen", "8FBC8F"];
    c[c.length] = ["DarkSlateBlue", "483D8B"];
    c[c.length] = ["DarkSlateGray", "2F4F4F"];
    c[c.length] = ["DarkSlateGrey", "2F4F4F"];
    c[c.length] = ["DarkTurquoise", "00CED1"];
    c[c.length] = ["DarkViolet", "9400D3"];
    c[c.length] = ["DeepPink", "FF1493"];
    c[c.length] = ["DeepSkyBlue", "00BFFF"];
    c[c.length] = ["DimGray", "696969"];
    c[c.length] = ["DimGrey", "696969"];
    c[c.length] = ["DodgerBlue", "1E90FF"];
    c[c.length] = ["FireBrick", "B22222"];
    c[c.length] = ["FloralWhite", "FFFAF0"];
    c[c.length] = ["ForestGreen", "228B22"];
    c[c.length] = ["Fuchsia", "FF00FF"];
    c[c.length] = ["Gainsboro", "DCDCDC"];
    c[c.length] = ["GhostWhite", "F8F8FF"];
    c[c.length] = ["Gold", "FFD700"];
    c[c.length] = ["GoldenRod", "DAA520"];
    c[c.length] = ["Gray", "808080"];
    c[c.length] = ["Grey", "808080"];
    c[c.length] = ["Green", "008000"];
    c[c.length] = ["GreenYellow", "ADFF2F"];
    c[c.length] = ["HoneyDew", "F0FFF0"];
    c[c.length] = ["HotPink", "FF69B4"];
    c[c.length] = ["IndianRed ", "CD5C5C"];
    c[c.length] = ["Indigo  ", "4B0082"];
    c[c.length] = ["Ivory", "FFFFF0"];
    c[c.length] = ["Khaki", "F0E68C"];
    c[c.length] = ["Lavender", "E6E6FA"];
    c[c.length] = ["LavenderBlush", "FFF0F5"];
    c[c.length] = ["LawnGreen", "7CFC00"];
    c[c.length] = ["LemonChiffon", "FFFACD"];
    c[c.length] = ["LightBlue", "ADD8E6"];
    c[c.length] = ["LightCoral", "F08080"];
    c[c.length] = ["LightCyan", "E0FFFF"];
    c[c.length] = ["LightGoldenRodYellow", "FAFAD2"];
    c[c.length] = ["LightGray", "D3D3D3"];
    c[c.length] = ["LightGrey", "D3D3D3"];
    c[c.length] = ["LightGreen", "90EE90"];
    c[c.length] = ["LightPink", "FFB6C1"];
    c[c.length] = ["LightSalmon", "FFA07A"];
    c[c.length] = ["LightSeaGreen", "20B2AA"];
    c[c.length] = ["LightSkyBlue", "87CEFA"];
    c[c.length] = ["LightSlateGray", "778899"];
    c[c.length] = ["LightSlateGrey", "778899"];
    c[c.length] = ["LightSteelBlue", "B0C4DE"];
    c[c.length] = ["LightYellow", "FFFFE0"];
    c[c.length] = ["Lime", "00FF00"];
    c[c.length] = ["LimeGreen", "32CD32"];
    c[c.length] = ["Linen", "FAF0E6"];
    c[c.length] = ["Magenta", "FF00FF"];
    c[c.length] = ["Maroon", "800000"];
    c[c.length] = ["MediumAquaMarine", "66CDAA"];
    c[c.length] = ["MediumBlue", "0000CD"];
    c[c.length] = ["MediumOrchid", "BA55D3"];
    c[c.length] = ["MediumPurple", "9370D8"];
    c[c.length] = ["MediumSeaGreen", "3CB371"];
    c[c.length] = ["MediumSlateBlue", "7B68EE"];
    c[c.length] = ["MediumSpringGreen", "00FA9A"];
    c[c.length] = ["MediumTurquoise", "48D1CC"];
    c[c.length] = ["MediumVioletRed", "C71585"];
    c[c.length] = ["MidnightBlue", "191970"];
    c[c.length] = ["MintCream", "F5FFFA"];
    c[c.length] = ["MistyRose", "FFE4E1"];
    c[c.length] = ["Moccasin", "FFE4B5"];
    c[c.length] = ["NavajoWhite", "FFDEAD"];
    c[c.length] = ["Navy", "000080"];
    c[c.length] = ["OldLace", "FDF5E6"];
    c[c.length] = ["Olive", "808000"];
    c[c.length] = ["OliveDrab", "6B8E23"];
    c[c.length] = ["Orange", "FFA500"];
    c[c.length] = ["OrangeRed", "FF4500"];
    c[c.length] = ["Orchid", "DA70D6"];
    c[c.length] = ["PaleGoldenRod", "EEE8AA"];
    c[c.length] = ["PaleGreen", "98FB98"];
    c[c.length] = ["PaleTurquoise", "AFEEEE"];
    c[c.length] = ["PaleVioletRed", "D87093"];
    c[c.length] = ["PapayaWhip", "FFEFD5"];
    c[c.length] = ["PeachPuff", "FFDAB9"];
    c[c.length] = ["Peru", "CD853F"];
    c[c.length] = ["Pink", "FFC0CB"];
    c[c.length] = ["Plum", "DDA0DD"];
    c[c.length] = ["PowderBlue", "B0E0E6"];
    c[c.length] = ["Purple", "800080"];
    c[c.length] = ["Red", "FF0000"];
    c[c.length] = ["RosyBrown", "BC8F8F"];
    c[c.length] = ["RoyalBlue", "4169E1"];
    c[c.length] = ["SaddleBrown", "8B4513"];
    c[c.length] = ["Salmon", "FA8072"];
    c[c.length] = ["SandyBrown", "F4A460"];
    c[c.length] = ["SeaGreen", "2E8B57"];
    c[c.length] = ["SeaShell", "FFF5EE"];
    c[c.length] = ["Sienna", "A0522D"];
    c[c.length] = ["Silver", "C0C0C0"];
    c[c.length] = ["SkyBlue", "87CEEB"];
    c[c.length] = ["SlateBlue", "6A5ACD"];
    c[c.length] = ["SlateGray", "708090"];
    c[c.length] = ["SlateGrey", "708090"];
    c[c.length] = ["Snow", "FFFAFA"];
    c[c.length] = ["SpringGreen", "00FF7F"];
    c[c.length] = ["SteelBlue", "4682B4"];
    c[c.length] = ["Tan", "D2B48C"];
    c[c.length] = ["Teal", "008080"];
    c[c.length] = ["Thistle", "D8BFD8"];
    c[c.length] = ["Tomato", "FF6347"];
    c[c.length] = ["Turquoise", "40E0D0"];
    c[c.length] = ["Violet", "EE82EE"];
    c[c.length] = ["Wheat", "F5DEB3"];
    c[c.length] = ["White", "FFFFFF"];
    c[c.length] = ["WhiteSmoke", "F5F5F5"];
    c[c.length] = ["Yellow", "FFFF00"];
    c[c.length] = ["YellowGreen", "9ACD32"];
    return c;
  },
};
DHTMLSuite.formValidator = function (propArray) {
  let formRef;
  let indicateWithCss;
  let indicateWithBars;
  let keyValidation;
  let objectIndex;
  let layoutCSS;
  let callbackOnFormValid;
  let callbackOnFormInvalid;
  let formElements;
  let masks;
  let radios;
  let indicationImages;
  let indicationBars;
  let equalToEls;
  let formUtil;
  this.equalToEls = new Object();
  this.equalToEls.from = new Object();
  this.equalToEls.to = new Object();
  this.formUtil = new DHTMLSuite.formUtil();
  this.masks = new Object();
  this.indicationImages = new Array();
  this.indicationBars = new Array();
  const domainString =
    "(com|org|net|mil|edu|info|a[cdfgilmnoqrstuwxz]|b[abdefghijmnorstwyz]|c[acdfghiklmnoruvxyz]|d[ejkmoz]|e[cegrstu]|f[ijkmor]|g[adefghilmnpqrstuwy]|h[kmnrtu]|i[delmnoqrst]|j[emop]|k[eghimnrwyz]|l[abcikrstuvy]|m[acdghklmnopqrstuvwxyz]|n[acefgilopruz]|om|p[aefghklmnrstwy]|qa|r[eouw]|s[abcdeghiklmnrtvyz]|t[cdfghjklmnortvwz]|u[agksyz]|v[aceginu]|w[fs]|y[etu]|z[amw])";
  this.masks.email = new RegExp(
    "^[A-Z0-9._%-]+@[A-Z0-9.-]+\\." + domainString + "$",
    "gi"
  );
  this.masks.numeric = /^[0-9]+$/gi;
  this.masks.letter = /^[A-Zæøå]+$/gi;
  this.masks.domain = new RegExp(
    "^(https?://)?[a-zA-Z0-9]+([a-zA-Z0-9-.]+)?\\." + domainString + "$",
    "gi"
  );
  this.layoutCSS = "form-validator.css";
  this.indicateWithCss = false;
  this.indicateWithBars = false;
  this.keyValidation = false;
  this.formElements = new Object();
  this.radios = new Object();
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
  if (propArray) this.__setInitProps(propArray);
  this.__init();
};
DHTMLSuite.formValidator.prototype = {
  addMask: function (maskName, regexpPattern, regexpFlags) {
    try {
      this.masks[maskName] = new RegExp(regexpPattern, regexpFlags);
    } catch (e) {
      alert(
        "Could not create regexp mask of " +
          regexpPattern +
          ",flags: " +
          regexpFlags
      );
    }
  },
  __setInitProps: function (props) {
    if (props.formRef) {
      const obj = DHTMLSuite.commonObj.getEl(props.formRef);
      this.formRef = obj;
    }
    if (props.indicateWithCss || props.indicateWithCss === false) {
      this.indicateWithCss = props.indicateWithCss;
    }
    if (props.keyValidation) this.keyValidation = props.keyValidation;
    if (props.callbackOnFormValid) {
      this.callbackOnFormValid = props.callbackOnFormValid;
    }
    if (props.callbackOnFormInvalid) {
      this.callbackOnFormInvalid = props.callbackOnFormInvalid;
    }
    if (props.indicateWithBars || props.indicateWithBars === false) {
      this.indicateWithBars = props.indicateWithBars;
    }
    if (this.indicateWithCss) this.indicateWithBars = false;
  },
  __init: function () {
    if (this.formRef) {
      const ind = this.objectIndex;
      this.__initiallyParseAForm();
      this.formRef.onreset = function () {
        setTimeout(
          "DHTMLSuite.variableStorage.arrayDSObjects[" +
            ind +
            "].__validateAllFields()",
          50
        );
      };
      DHTMLSuite.commonObj.__addEventEl(this.formRef);
      DHTMLSuite.commonObj.addEvent(window, "resize", function () {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__positionIndImages();
      });
    }
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
  },
  __validateAllFields: function () {
    for (const prop in this.formElements) {
      this.__validateInput(this.formElements[prop].el);
    }
  },
  __addRadiosToArray: function (el) {
    if (!this.radios[el.name]) {
      this.radios[el.name] = new Array();
      for (let no = 0; no < this.formRef.elements.length; no++) {
        const formEl = this.formRef.elements[no];
        if (formEl.name == el.name) {
          this.radios[el.name][this.radios[el.name].length] = formEl;
        }
      }
    }
  },
  __initiallyParseAForm: function () {
    const ind = this.objectIndex;
    const formRef = this.formRef;
    const vElements = new Array();
    const inputs = formRef.getElementsByTagName("INPUT");
    for (var no = 0; no < inputs.length; no++) {
      if (!this.__hasValidationAttr(inputs[no])) continue;
      if (
        inputs[no].type.toLowerCase() == "text" ||
        inputs[no].type.toLowerCase() == "checkbox" ||
        inputs[no].type.toLowerCase() == "radio"
      ) {
        vElements[vElements.length] = inputs[no];
      }
      if (inputs[no].type.toLowerCase() == "radio") {
        this.__addRadiosToArray(inputs[no]);
      }
      if (inputs[no].type.toLowerCase() == "checkbox") {
        this.__addRadiosToArray(inputs[no]);
      }
    }
    const ta = formRef.getElementsByTagName("TEXTAREA");
    for (var no = 0; no < ta.length; no++) {
      if (!this.__hasValidationAttr(ta[no])) continue;
      vElements[vElements.length] = ta[no];
    }
    const sel = formRef.getElementsByTagName("SELECT");
    for (var no = 0; no < sel.length; no++) {
      if (!this.__hasValidationAttr(sel[no])) continue;
      vElements[vElements.length] = sel[no];
    }
    for (var no = 0; no < vElements.length; no++) {
      let elType = vElements[no].tagName.toLowerCase();
      if (elType == "input") elType = vElements[no].type.toLowerCase();
      if (!elType) elType = "text";
      if (this.indicateWithCss) {
        if (elType == "select") this.__addParentToSelect(vElements[no]);
        if (elType == "textarea") {
          vElements[no].className =
            vElements[no].className + " DHTMLSuite_validInput";
        }
        if (
          vElements[no].tagName.toLowerCase() == "input" &&
          elType == "text"
        ) {
          vElements[no].className =
            vElements[no].className + " DHTMLSuite_validInput";
        }
        if (
          vElements[no].tagName.toLowerCase() == "input" &&
          elType == "checkbox"
        ) {
          vElements[no].className =
            vElements[no].className + " DHTMLSuite_validInput";
        }
      }
      if (document.getElementById("_" + vElements[no].name)) {
        if (!this.indicationImages[vElements[no].name]) {
          this.indicationImages[vElements[no].name] =
            document.createElement("DIV");
          var el = this.indicationImages[vElements[no].name];
          document.getElementById("_" + vElements[no].name).appendChild(el);
          el.className =
            "DHTMLSuite_validationImage DHTMLSuite_invalidInputImage";
          el.style.height =
            document.getElementById("_" + vElements[no].name).clientHeight +
            "px";
        }
      }
      if (this.indicateWithBars) {
        if (
          !this.indicationBars[vElements[no].name] &&
          elType != "radio" &&
          elType != "checkbox"
        ) {
          this.indicationBars[vElements[no].name] =
            document.createElement("DIV");
          var el = this.indicationBars[vElements[no].name];
          const parent = vElements[no].parentNode;
          parent.insertBefore(el, vElements[no].parentNode.firstChild);
          if (DHTMLSuite.clientInfoObj.isMSIE) {
            el.style.left = "0px";
            el.style.top = "0px";
            if (
              DHTMLSuite.commonObj.getStyle(parent, "position") != "absolute"
            ) {
              parent.style.position = "relative";
            }
          }
          el.innerHTML = "<span></span>";
          el.className =
            "DHTMLSuite_validationBar DHTMLSuite_validationBarValid";
          el.style.position = "absolute";
        }
      }
      if (!vElements[no].id) {
        vElements[no].id = DHTMLSuite.commonObj.getUniqueId();
      }
      vElements[no].setAttribute("elementIndex", no);
      this.formElements[vElements[no].name] = new Array();
      this.formElements[vElements[no].name].el = vElements[no].id;
      this.formElements[vElements[no].name].result = false;
      this.__setRegExpPattern(vElements[no]);
      this.__validateInput(vElements[no]);
      this.__addEvent(vElements[no]);
    }
    setTimeout(
      "DHTMLSuite.variableStorage.arrayDSObjects[" +
        this.objectIndex +
        "].__positionIndImages()",
      50
    );
  },
  __positionIndImages: function () {
    for (const prop in this.indicationBars) {
      try {
        const el = this.indicationBars[prop];
        const formEl = DHTMLSuite.commonObj.getEl(this.formElements[prop].el);
        const left = formEl.offsetLeft - el.offsetWidth;
        el.style.marginLeft = left + "px";
        el.style.marginTop = "0px";
        if (DHTMLSuite.clientInfoObj.isMSIE) {
          el.style.marginTop =
            DHTMLSuite.commonObj.getTopPos(formEl) -
            DHTMLSuite.commonObj.getTopPos(formEl.parentNode) +
            "px";
        }
        el.style.height = formEl.offsetHeight + "px";
      } catch (e) {}
    }
  },
  __setRegExpPattern: function (formEl) {
    var pat = formEl.getAttribute("regexpPattern");
    if (pat) {
      if (pat.indexOf("/") == -1) {
        pat = "/" + pat + "/";
        formEl.setAttribute("regexpPattern", pat);
      }
      return;
    }
    const req = formEl.getAttribute("required");
    if (req || req === "") {
      pat = "/./";
    }
    const minLength = formEl.getAttribute("minLength");
    if (minLength) {
      var pat = "/";
      for (let no = 0; no < minLength; no++) pat = pat + ".";
      pat = pat + "/";
    }
    const sp = formEl.getAttribute("simplePattern");
    let freemask = formEl.getAttribute("freemask");
    if (freemask) {
      let cs = formEl.getAttribute("caseInsensitive");
      cs = String(cs);
      freemask = freemask.replace(/([^NSs])/g, "\\$1");
      freemask = freemask.replace(/N/gi, "[0-9]");
      freemask = freemask.replace(/s/g, "[a-z]");
      freemask = freemask.replace(/S/g, "[A-Z]");
      freemask = "/^" + freemask + "$/";
      if (cs || cs === "") freemask = freemask + "i";
      pat = freemask;
    }
    const mask = formEl.getAttribute("mask");
    if (mask) {
      try {
        pat = mask;
      } catch (e) {}
    }
    formEl.setAttribute("regexpPattern", pat);
    formEl.setAttribute("regexpFlag", pat);
    const equalTo = formEl.getAttribute("equalTo");
    if (equalTo) {
      try {
        this.equalToEls.from[formEl.name] = DHTMLSuite.commonObj.getEl(equalTo);
        this.equalToEls.to[equalTo] = formEl;
        this.equalToEls.from[equalTo] = false;
        this.equalToEls.to[formEl.name] = false;
      } catch (e) {}
    }
  },
  __addEvent: function (formEl) {
    const ind = this.objectIndex;
    const id = formEl.id;
    formEl.onchange = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__validateInput(id);
    };
    formEl.onpaste = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__validateInput(id);
    };
    formEl.onblur = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__validateInput(id);
    };
    formEl.onkeyup = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__validateInput(id);
    };
    formEl.onclick = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__validateInput(id);
    };
    if (this.keyValidation) {
      formEl.onkeypress = function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__validateKey(
          e,
          id
        );
      };
      formEl.onpaste = function () {
        setTimeout(
          "DHTMLSuite.variableStorage.arrayDSObjects[" +
            ind +
            '].__validatePaste("' +
            id +
            '")',
          2
        );
      };
    }
    DHTMLSuite.commonObj.__addEventEl(formEl);
  },
  __validatePaste: function (elRef) {
    const src = DHTMLSuite.commonObj.getEl(elRef);
    const pat = src.getAttribute("regexpPattern");
    if (pat == "letter") src.value = src.value.replace(/[^a-z]/gi, "");
    if (pat == "numeric") src.value = src.value.replace(/[^0-9]/g, "");
    if (pat == "letter" || pat == "numeric") this.__validateInput(elRef);
  },
  __validateKey: function (e, elRef) {
    if (document.all) e = event;
    if (e.ctrlKey || e.altKey) return true;
    const src = DHTMLSuite.commonObj.getSrcElement(e);
    const pat = src.getAttribute("regexpPattern");
    const code = DHTMLSuite.commonObj.getKeyCode(e);
    const key = DHTMLSuite.commonObj.getKeyFromEvent(e);
    if (code < 48 && code != 32) return true;
    if (key == "\t") return true;
    if (pat == "letter") {
      if (code == 192 || code == 222 || code == 221) return true;
      if (!key.match(/[a-z]/gi)) return false;
    }
    if (pat == "numeric" && !key.match(/[0-9]/g)) return false;
    return true;
  },
  __hasValidationAttr: function (el) {
    const req = el.getAttribute("required");
    if (req || req === "") return true;
    var mask = el.getAttribute("mask");
    if (mask) return true;
    var mask = el.getAttribute("freemask");
    if (mask) return true;
    const regexp = el.getAttribute("regexpPattern");
    if (regexp) return true;
    const equalTo = el.getAttribute("equalTo");
    if (equalTo) return true;
    return false;
  },
  __addParentToSelect: function (selectRef) {
    const div = document.createElement("DIV");
    selectRef.parentNode.insertBefore(div, selectRef);
    div.appendChild(selectRef);
    div.className = "DHTMLSuite_validInput";
    div.style.cssText = "display:inline-block;";
    div.style.width = selectRef.offsetWidth + "px";
  },
  __validateInput: function (inputRef) {
    inputRef = DHTMLSuite.commonObj.getEl(inputRef);
    const index = inputRef.name;
    if (this.__isInputValid(inputRef)) {
      this.formElements[index].result = true;
      this.__toggleInput(inputRef, "valid");
    } else {
      this.formElements[index].result = false;
      this.__toggleInput(inputRef, "invalid");
    }
    this.__validateForm();
  },
  __isInputValid: function (inputRef, circular) {
    let elType = "select";
    if (
      (inputRef.tagName.toLowerCase() == "input" &&
        inputRef.type.toLowerCase() == "text") ||
      inputRef.tagName.toLowerCase() == "textarea"
    ) {
      elType = "text";
    }
    if (
      inputRef.tagName.toLowerCase() == "input" &&
      inputRef.type.toLowerCase() == "checkbox"
    ) {
      elType = "checkbox";
    }
    if (
      inputRef.tagName.toLowerCase() == "input" &&
      inputRef.type.toLowerCase() == "radio"
    ) {
      elType = "radio";
    }
    if (this.equalToEls.from[inputRef.name]) {
      const equal = this.formUtil.areEqual(
        inputRef,
        this.equalToEls.from[inputRef.name]
      );
      if (!equal) return false;
    }
    if (this.equalToEls.to[inputRef.name]) {
      this.__validateInput(this.equalToEls.to[inputRef.name]);
    }
    if (elType == "text") {
      let pat = inputRef.getAttribute("regexpPattern");
      pat = pat.indexOf("/") == -1 ? this.masks[pat] : eval(pat);
      if (inputRef.value.trim().match(pat)) {
        const matches = inputRef.value.trim().match(pat);
        const minLength = inputRef.getAttribute("minLength");
        if (minLength) {
          if (inputRef.value.trim().length < minLength) return false;
        }
        return true;
      } else return false;
    }
    if (elType == "select") {
      const required = inputRef.getAttribute("required");
      const multiple = inputRef.getAttribute("multiple");
      if (multiple || multiple === "") {
        if (required || required === "") {
          for (var no = 0; no < inputRef.options.length; no++) {
            if (inputRef.options[no].selected && inputRef.options[no].value) {
              return true;
            }
          }
          return false;
        }
      } else {
        if (
          required ||
          (required === "" && !inputRef.options[inputRef.selectedIndex].value)
        ) {
          return false;
        }
      }
    }
    if (elType == "radio" || elType == "checkbox") {
      const name = inputRef.name;
      let elChecked = false;
      for (var no = 0; no < this.radios[name].length; no++) {
        if (this.radios[name][no].checked) elChecked = true;
      }
      if (!elChecked) return false;
    }
    return true;
  },
  __toggleInput: function (inputRef, style) {
    let el = inputRef;
    if (this.indicationImages[el.name]) {
      var obj = this.indicationImages[el.name];
      obj.className = obj.className.replace(
        " DHTMLSuite_invalidInputImage",
        ""
      );
      obj.className = obj.className.replace(" DHTMLSuite_validInputImage", "");
      if (style == "valid") {
        obj.className = obj.className + " DHTMLSuite_validInputImage";
      } else {
        obj.className = obj.className + " DHTMLSuite_invalidInputImage";
      }
    }
    if (this.indicateWithBars) {
      var obj = this.indicationBars[el.name];
      if (!obj) return;
      obj.className = obj.className.replace(
        " DHTMLSuite_validationBarValid",
        ""
      );
      obj.className = obj.className.replace(
        " DHTMLSuite_validationBarInvalid",
        ""
      );
      if (style == "valid") {
        obj.className = obj.className + " DHTMLSuite_validationBarValid";
      } else {
        obj.className = obj.className + " DHTMLSuite_validationBarInvalid";
      }
    }
    if (this.indicateWithCss) {
      if (el.tagName.toLowerCase() == "select") el = el.parentNode;
      if (el.className.indexOf("DHTMLSuite_") == -1) return;
      el.className = el.className.replace(" DHTMLSuite_invalidInput", "");
      el.className = el.className.replace(" DHTMLSuite_validInput", "");
      if (style == "valid") {
        el.className = el.className + " DHTMLSuite_validInput";
      } else {
        el.className = el.className + " DHTMLSuite_invalidInput";
      }
    }
  },
  isFormValid: function () {
    for (const no in this.formElements) {
      if (!this.formElements[no].result) {
        return false;
      }
    }
    return true;
  },
  __validateForm: function () {
    if (this.isFormValid()) {
      this.__handleCallback("formValid");
    } else {
      this.__handleCallback("formInvalid");
    }
  },
  __handleCallback: function (action) {
    let callbackString = "";
    switch (action) {
      case "formValid":
        if (this.callbackOnFormValid) callbackString = this.callbackOnFormValid;
        break;
      case "formInvalid":
        if (this.callbackOnFormInvalid) {
          callbackString = this.callbackOnFormInvalid;
        }
        break;
    }
    if (callbackString) {
      callbackString = callbackString + "(this.formElements)";
      eval(callbackString);
    }
  },
};
DHTMLSuite.formUtil = function () {};
DHTMLSuite.formUtil.prototype = {
  getFamily: function (el, formRef) {
    const els = formRef.elements;
    const retArray = new Array();
    for (let no = 0; no < els.length; no++) {
      if (els[no].name == el.name) retArray[retArray.length] = els[no];
    }
    return retArray;
  },
  hasFileInputs: function (formRef) {
    const els = formRef.elements;
    for (let no = 0; no < els.length; no++) {
      if (
        els[no].tagName.toLowerCase() == "input" &&
        els[no].type.toLowerCase() == "file"
      ) {
        return true;
      }
    }
    return false;
  },
  getValuesAsArray: function (formRef) {
    const retArray = new Object();
    formRef = DHTMLSuite.commonObj.getEl(formRef);
    const els = formRef.elements;
    for (let no = 0; no < els.length; no++) {
      if (els[no].disabled) continue;
      const tag = els[no].tagName.toLowerCase();
      switch (tag) {
        case "input":
          var type = els[no].type.toLowerCase();
          if (!type) type = "text";
          switch (type) {
            case "text":
            case "image":
            case "hidden":
              retArray[els[no].name] = els[no].value;
              break;
            case "checkbox":
              var boxes = this.getFamily(els[no], formRef);
              if (boxes.length > 1) {
                retArray[els[no].name] = new Array();
                for (var no2 = 0; no2 < boxes.length; no2++) {
                  if (boxes[no2].checked) {
                    var index = retArray[els[no].name].length;
                    retArray[els[no].name][index] = boxes[no2].value;
                  }
                }
              } else {
                if (els[no].checked) retArray[els[no].name] = els[no].value;
              }
              break;
            case "radio":
              if (els[no].checked) retArray[els[no].name] = els[no].value;
              break;
          }
          break;
        case "select":
          var string = "";
          var mult = els[no].getAttribute("multiple");
          if (mult || mult === "") {
            retArray[els[no].name] = new Array();
            for (var no2 = 0; no2 < els[no].options.length; no2++) {
              var index = retArray[els[no].name].length;
              if (els[no].options[no2].selected) {
                retArray[els[no].name][index] = els[no].options[no2].value;
              }
            }
          } else {
            retArray[els[no].name] =
              els[no].options[els[no].selectedIndex].value;
          }
          break;
        case "textarea":
          retArray[els[no].name] = els[no].value;
          break;
      }
    }
    return retArray;
  },
  getValue: function (formEl) {
    switch (formEl.tagName.toLowerCase()) {
      case "input":
      case "textarea":
        return formEl.value;
      case "select":
        return formEl.options[formEl.selectedIndex].value;
    }
  },
  areEqual: function (input1, input2) {
    input1 = DHTMLSuite.commonObj.getEl(input1);
    input2 = DHTMLSuite.commonObj.getEl(input2);
    if (this.getValue(input1) == this.getValue(input2)) return true;
    return false;
  },
};
DHTMLSuite.form = function (propArray) {
  let formRef;
  let method;
  let responseEl;
  let action;
  let responseFile;
  let formUtil;
  let objectIndex;
  let sackObj;
  let coverDiv;
  let layoutCSS;
  let iframeName;
  this.method = "POST";
  this.sackObj = new Array();
  this.formUtil = new DHTMLSuite.formUtil();
  this.layoutCSS = "form.css";
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects();
  } catch (e) {
    alert("Include the dhtmlSuite-common.js file");
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length;
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this;
  DHTMLSuite.commonObj.loadCSS(this.layoutCSS);
  if (propArray) this.__setInitProperties(propArray);
};
DHTMLSuite.form.prototype = {
  submit: function () {
    this.__createCoverDiv();
    const index = this.sackObj.length;
    if (this.formUtil.hasFileInputs(this.formRef)) {
      this.__createIframe();
      this.formRef.submit();
    } else {
      this.__createSackObject(index);
      this.__populateSack(index);
      this.sackObj[index].runAJAX();
    }
    this.__positionCoverDiv();
    return false;
  },
  __createIframe: function () {
    if (this.iframeName) return;
    const ind = this.objectIndex;
    const div = document.createElement("DIV");
    document.body.appendChild(div);
    this.iframeName = "DHTMLSuiteForm" + DHTMLSuite.commonObj.getUniqueId();
    div.innerHTML =
      '<iframe style="visibility:hidden;width:5px;height:5px" id="' +
      this.iframeName +
      '" name="' +
      this.iframeName +
      '" onload="parent.DHTMLSuite.variableStorage.arrayDSObjects[' +
      ind +
      '].__getIframeResponse()"></iframe>';
    this.formRef.method = this.method;
    this.formRef.action = this.action;
    this.formRef.target = this.iframeName;
    if (!this.formRef.enctype) this.formRef.enctype = "multipart/form-data";
  },
  __getIframeResponse: function () {
    if (this.responseEl) {
      if (this.responseFile) {
        if (!this.responseEl.id) {
          this.responseEl.id =
            "DHTMLSuite_formResponse" + DHTMLSuite.getUniqueId();
        }
        const dynContent = new DHTMLSuite.dynamicContent();
        dynContent.loadContent(this.responseEl.id, this.responseFile);
      } else {
        this.responseEl.innerHTML =
          self.frames[this.iframeName].document.body.innerHTML;
        DHTMLSuite.commonObj.__evaluateJs(this.responseEl);
        DHTMLSuite.commonObj.__evaluateCss(this.responseEl);
      }
    }
    this.coverDiv.style.display = "none";
    this.__handleCallback("onComplete");
  },
  __positionCoverDiv: function () {
    if (!this.responseEl) return;
    try {
      const st = this.coverDiv.style;
      st.left = DHTMLSuite.commonObj.getLeftPos(this.responseEl) + "px";
      st.top = DHTMLSuite.commonObj.getTopPos(this.responseEl) + "px";
      st.width = this.responseEl.offsetWidth + "px";
      st.height = this.responseEl.offsetHeight + "px";
      st.display = "block";
    } catch (e) {}
  },
  __createCoverDiv: function () {
    if (this.coverDiv) return;
    this.coverDiv = document.createElement("DIV");
    const el = this.coverDiv;
    el.style.overflow = "hidden";
    el.style.zIndex = 1000;
    el.style.position = "absolute";
    document.body.appendChild(el);
    const innerDiv = document.createElement("DIV");
    innerDiv.style.width = "105%";
    innerDiv.style.height = "105%";
    innerDiv.className = "DHTMLSuite_formCoverDiv";
    innerDiv.style.opacity = "0.2";
    innerDiv.style.filter = "alpha(opacity=20)";
    el.appendChild(innerDiv);
    const ajaxLoad = document.createElement("DIV");
    ajaxLoad.className = "DHTMLSuite_formCoverDiv_ajaxLoader";
    el.appendChild(ajaxLoad);
  },
  __createSackObject: function (ajaxIndex) {
    const ind = this.objectIndex;
    this.sackObj[ajaxIndex] = new sack();
    this.sackObj[ajaxIndex].requestFile = this.action;
    this.sackObj[ajaxIndex].method = this.method;
    this.sackObj[ajaxIndex].onCompletion = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__getResponse(ajaxIndex);
    };
  },
  __getResponse: function (ajaxIndex) {
    if (this.responseEl) {
      if (this.responseFile) {
        if (!this.responseEl.id) {
          this.responseEl.id =
            "DHTMLSuite_formResponse" + DHTMLSuite.getUniqueId();
        }
        const dynContent = new DHTMLSuite.dynamicContent();
        dynContent.loadContent(this.responseEl.id, this.responseFile);
      } else {
        this.responseEl.innerHTML = this.sackObj[ajaxIndex].response;
        DHTMLSuite.commonObj.__evaluateJs(this.responseEl);
        DHTMLSuite.commonObj.__evaluateCss(this.responseEl);
      }
    }
    this.coverDiv.style.display = "none";
    this.sackObj[ajaxIndex] = null;
    this.__handleCallback("onComplete");
  },
  __populateSack: function (ajaxIndex) {
    const els = this.formUtil.getValuesAsArray(this.formRef);
    for (const prop in els) {
      if (DHTMLSuite.commonObj.isArray(els[prop])) {
        for (let no = 0; no < els[prop].length; no++) {
          let name = prop + "[" + no + "]";
          if (prop.indexOf("[") >= 0) {
            name = prop.replace("[", "[" + no);
          }
          this.sackObj[ajaxIndex].setVar(name, els[prop][no]);
        }
      } else {
        this.sackObj[ajaxIndex].setVar(prop, els[prop]);
      }
    }
  },
  __setInitProperties: function (props) {
    if (props.formRef) this.formRef = DHTMLSuite.commonObj.getEl(props.formRef);
    if (props.method) this.method = props.method;
    if (props.responseEl) {
      this.responseEl = DHTMLSuite.commonObj.getEl(props.responseEl);
    }
    if (props.action) this.action = props.action;
    if (props.responseFile) this.responseFile = props.responseFile;
    if (props.callbackOnComplete) {
      this.callbackOnComplete = props.callbackOnComplete;
    }
    if (!this.action) this.action = this.formRef.action;
    if (!this.method) this.method = this.formRef.method;
  },
  __handleCallback: function (action) {
    let callbackString = "";
    switch (action) {
      case "onComplete":
        callbackString = this.callbackOnComplete;
        break;
    }
    if (callbackString) {
      if (callbackString.indexOf("(") == -1) {
        callbackString = callbackString + '("' + this.formRef.name + '")';
      }
      eval(callbackString);
    }
  },
};
