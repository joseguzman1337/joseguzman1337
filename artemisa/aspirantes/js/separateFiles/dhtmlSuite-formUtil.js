if (!window.DHTMLSuite) var DHTMLSuite = new Object()
DHTMLSuite.formValidator = function (propArray) {
  let formRef
  let indicateWithCss
  let indicateWithBars
  let keyValidation
  let objectIndex
  let layoutCSS
  let callbackOnFormValid
  let callbackOnFormInvalid
  let formElements
  let masks
  let radios
  let indicationImages
  let indicationBars
  let equalToEls
  let formUtil
  this.equalToEls = new Object()
  this.equalToEls.from = new Object()
  this.equalToEls.to = new Object()
  this.formUtil = new DHTMLSuite.formUtil()
  this.masks = new Object()
  this.indicationImages = new Array()
  this.indicationBars = new Array()
  const domainString =
    '(com|org|net|mil|edu|info|a[cdfgilmnoqrstuwxz]|b[abdefghijmnorstwyz]|c[acdfghiklmnoruvxyz]|d[ejkmoz]|e[cegrstu]|f[ijkmor]|g[adefghilmnpqrstuwy]|h[kmnrtu]|i[delmnoqrst]|j[emop]|k[eghimnrwyz]|l[abcikrstuvy]|m[acdghklmnopqrstuvwxyz]|n[acefgilopruz]|om|p[aefghklmnrstwy]|qa|r[eouw]|s[abcdeghiklmnrtvyz]|t[cdfghjklmnortvwz]|u[agksyz]|v[aceginu]|w[fs]|y[etu]|z[amw])'
  this.masks.email = new RegExp(
    '^[A-Z0-9._%-]+@[A-Z0-9.-]+\\.' + domainString + '$',
    'gi'
  )
  this.masks.numeric = /^[0-9]+$/gi
  this.masks.letter = /^[A-Zæøå]+$/gi
  this.masks.domain = new RegExp(
    '^(https?://)?[a-zA-Z0-9]+([a-zA-Z0-9-.]+)?\\.' + domainString + '$',
    'gi'
  )
  this.layoutCSS = 'form-validator.css'
  this.indicateWithCss = false
  this.indicateWithBars = false
  this.keyValidation = false
  this.formElements = new Object()
  this.radios = new Object()
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects()
  } catch (e) {
    alert('Include the dhtmlSuite-common.js file')
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this
  if (propArray) this.__setInitProps(propArray)
  this.__init()
}
DHTMLSuite.formValidator.prototype = {
  addMask: function (maskName, regexpPattern, regexpFlags) {
    try {
      this.masks[maskName] = new RegExp(regexpPattern, regexpFlags)
    } catch (e) {
      alert(
        'Could not create regexp mask of ' +
          regexpPattern +
          ',flags: ' +
          regexpFlags
      )
    }
  },
  __setInitProps: function (props) {
    if (props.formRef) {
      const obj = DHTMLSuite.commonObj.getEl(props.formRef)
      this.formRef = obj
    }
    if (props.indicateWithCss || props.indicateWithCss === false) {
      this.indicateWithCss = props.indicateWithCss
    }
    if (props.keyValidation) this.keyValidation = props.keyValidation
    if (props.callbackOnFormValid) {
      this.callbackOnFormValid = props.callbackOnFormValid
    }
    if (props.callbackOnFormInvalid) {
      this.callbackOnFormInvalid = props.callbackOnFormInvalid
    }
    if (props.indicateWithBars || props.indicateWithBars === false) {
      this.indicateWithBars = props.indicateWithBars
    }
    if (this.indicateWithCss) this.indicateWithBars = false
  },
  __init: function () {
    if (this.formRef) {
      const ind = this.objectIndex
      this.__initiallyParseAForm()
      this.formRef.onreset = function () {
        setTimeout(
          'DHTMLSuite.variableStorage.arrayDSObjects[' +
            ind +
            '].__validateAllFields()',
          50
        )
      }
      DHTMLSuite.commonObj.__addEventEl(this.formRef)
      DHTMLSuite.commonObj.addEvent(window, 'resize', function () {
        DHTMLSuite.variableStorage.arrayDSObjects[ind].__positionIndImages()
      })
    }
    DHTMLSuite.commonObj.loadCSS(this.layoutCSS)
  },
  __validateAllFields: function () {
    for (const prop in this.formElements) {
      this.__validateInput(this.formElements[prop].el)
    }
  },
  __addRadiosToArray: function (el) {
    if (!this.radios[el.name]) {
      this.radios[el.name] = new Array()
      for (let no = 0; no < this.formRef.elements.length; no++) {
        const formEl = this.formRef.elements[no]
        if (formEl.name == el.name) {
          this.radios[el.name][this.radios[el.name].length] = formEl
        }
      }
    }
  },
  __initiallyParseAForm: function () {
    const ind = this.objectIndex
    const formRef = this.formRef
    const vElements = new Array()
    const inputs = formRef.getElementsByTagName('INPUT')
    for (var no = 0; no < inputs.length; no++) {
      if (!this.__hasValidationAttr(inputs[no])) continue
      if (
        inputs[no].type.toLowerCase() == 'text' ||
        inputs[no].type.toLowerCase() == 'checkbox' ||
        inputs[no].type.toLowerCase() == 'radio'
      ) {
        vElements[vElements.length] = inputs[no]
      }
      if (inputs[no].type.toLowerCase() == 'radio') {
        this.__addRadiosToArray(inputs[no])
      }
      if (inputs[no].type.toLowerCase() == 'checkbox') {
        this.__addRadiosToArray(inputs[no])
      }
    }
    const ta = formRef.getElementsByTagName('TEXTAREA')
    for (var no = 0; no < ta.length; no++) {
      if (!this.__hasValidationAttr(ta[no])) continue
      vElements[vElements.length] = ta[no]
    }
    const sel = formRef.getElementsByTagName('SELECT')
    for (var no = 0; no < sel.length; no++) {
      if (!this.__hasValidationAttr(sel[no])) continue
      vElements[vElements.length] = sel[no]
    }
    for (var no = 0; no < vElements.length; no++) {
      let elType = vElements[no].tagName.toLowerCase()
      if (elType == 'input') elType = vElements[no].type.toLowerCase()
      if (!elType) elType = 'text'
      if (this.indicateWithCss) {
        if (elType == 'select') this.__addParentToSelect(vElements[no])
        if (elType == 'textarea') {
          vElements[no].className =
            vElements[no].className + ' DHTMLSuite_validInput'
        }
        if (
          vElements[no].tagName.toLowerCase() == 'input' &&
          elType == 'text'
        ) {
          vElements[no].className =
            vElements[no].className + ' DHTMLSuite_validInput'
        }
        if (
          vElements[no].tagName.toLowerCase() == 'input' &&
          elType == 'checkbox'
        ) {
          vElements[no].className =
            vElements[no].className + ' DHTMLSuite_validInput'
        }
      }
      if (document.getElementById('_' + vElements[no].name)) {
        if (!this.indicationImages[vElements[no].name]) {
          this.indicationImages[vElements[no].name] =
            document.createElement('DIV')
          var el = this.indicationImages[vElements[no].name]
          document.getElementById('_' + vElements[no].name).appendChild(el)
          el.className =
            'DHTMLSuite_validationImage DHTMLSuite_invalidInputImage'
          el.style.height =
            document.getElementById('_' + vElements[no].name).clientHeight +
            'px'
        }
      }
      if (this.indicateWithBars) {
        if (
          !this.indicationBars[vElements[no].name] &&
          elType != 'radio' &&
          elType != 'checkbox'
        ) {
          this.indicationBars[vElements[no].name] =
            document.createElement('DIV')
          var el = this.indicationBars[vElements[no].name]
          const parent = vElements[no].parentNode
          parent.insertBefore(el, vElements[no].parentNode.firstChild)
          if (DHTMLSuite.clientInfoObj.isMSIE) {
            el.style.left = '0px'
            el.style.top = '0px'
            if (
              DHTMLSuite.commonObj.getStyle(parent, 'position') != 'absolute'
            ) {
              parent.style.position = 'relative'
            }
          }
          el.innerHTML = '<span></span>'
          el.className =
            'DHTMLSuite_validationBar DHTMLSuite_validationBarValid'
          el.style.position = 'absolute'
        }
      }
      if (!vElements[no].id) {
        vElements[no].id = DHTMLSuite.commonObj.getUniqueId()
      }
      vElements[no].setAttribute('elementIndex', no)
      this.formElements[vElements[no].name] = new Array()
      this.formElements[vElements[no].name].el = vElements[no].id
      this.formElements[vElements[no].name].result = false
      this.__setRegExpPattern(vElements[no])
      this.__validateInput(vElements[no])
      this.__addEvent(vElements[no])
    }
    setTimeout(
      'DHTMLSuite.variableStorage.arrayDSObjects[' +
        this.objectIndex +
        '].__positionIndImages()',
      50
    )
  },
  __positionIndImages: function () {
    for (const prop in this.indicationBars) {
      try {
        const el = this.indicationBars[prop]
        const formEl = DHTMLSuite.commonObj.getEl(this.formElements[prop].el)
        const left = formEl.offsetLeft - el.offsetWidth
        el.style.marginLeft = left + 'px'
        el.style.marginTop = '0px'
        if (DHTMLSuite.clientInfoObj.isMSIE) {
          el.style.marginTop =
            DHTMLSuite.commonObj.getTopPos(formEl) -
            DHTMLSuite.commonObj.getTopPos(formEl.parentNode) +
            'px'
        }
        el.style.height = formEl.offsetHeight + 'px'
      } catch (e) {}
    }
  },
  __setRegExpPattern: function (formEl) {
    var pat = formEl.getAttribute('regexpPattern')
    if (pat) {
      if (pat.indexOf('/') == -1) {
        pat = '/' + pat + '/'
        formEl.setAttribute('regexpPattern', pat)
      }
      return
    }
    const req = formEl.getAttribute('required')
    if (req || req === '') {
      pat = '/./'
    }
    const minLength = formEl.getAttribute('minLength')
    if (minLength) {
      var pat = '/'
      for (let no = 0; no < minLength; no++) pat = pat + '.'
      pat = pat + '/'
    }
    const sp = formEl.getAttribute('simplePattern')
    let freemask = formEl.getAttribute('freemask')
    if (freemask) {
      let cs = formEl.getAttribute('caseInsensitive')
      cs = String(cs)
      freemask = freemask.replace(/([^NSs])/g, '\\$1')
      freemask = freemask.replace(/N/gi, '[0-9]')
      freemask = freemask.replace(/s/g, '[a-z]')
      freemask = freemask.replace(/S/g, '[A-Z]')
      freemask = '/^' + freemask + '$/'
      if (cs || cs === '') freemask = freemask + 'i'
      pat = freemask
    }
    const mask = formEl.getAttribute('mask')
    if (mask) {
      try {
        pat = mask
      } catch (e) {}
    }
    formEl.setAttribute('regexpPattern', pat)
    formEl.setAttribute('regexpFlag', pat)
    const equalTo = formEl.getAttribute('equalTo')
    if (equalTo) {
      try {
        this.equalToEls.from[formEl.name] = DHTMLSuite.commonObj.getEl(equalTo)
        this.equalToEls.to[equalTo] = formEl
        this.equalToEls.from[equalTo] = false
        this.equalToEls.to[formEl.name] = false
      } catch (e) {}
    }
  },
  __addEvent: function (formEl) {
    const ind = this.objectIndex
    const id = formEl.id
    formEl.onchange = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__validateInput(id)
    }
    formEl.onpaste = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__validateInput(id)
    }
    formEl.onblur = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__validateInput(id)
    }
    formEl.onkeyup = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__validateInput(id)
    }
    formEl.onclick = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__validateInput(id)
    }
    if (this.keyValidation) {
      formEl.onkeypress = function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__validateKey(
          e,
          id
        )
      }
      formEl.onpaste = function () {
        setTimeout(
          'DHTMLSuite.variableStorage.arrayDSObjects[' +
            ind +
            '].__validatePaste("' +
            id +
            '")',
          2
        )
      }
    }
    DHTMLSuite.commonObj.__addEventEl(formEl)
  },
  __validatePaste: function (elRef) {
    const src = DHTMLSuite.commonObj.getEl(elRef)
    const pat = src.getAttribute('regexpPattern')
    if (pat == 'letter') src.value = src.value.replace(/[^a-z]/gi, '')
    if (pat == 'numeric') src.value = src.value.replace(/[^0-9]/g, '')
    if (pat == 'letter' || pat == 'numeric') this.__validateInput(elRef)
  },
  __validateKey: function (e, elRef) {
    if (document.all) e = event
    if (e.ctrlKey || e.altKey) return true
    const src = DHTMLSuite.commonObj.getSrcElement(e)
    const pat = src.getAttribute('regexpPattern')
    const code = DHTMLSuite.commonObj.getKeyCode(e)
    const key = DHTMLSuite.commonObj.getKeyFromEvent(e)
    if (code < 48 && code != 32) return true
    if (key == '\t') return true
    if (pat == 'letter') {
      if (code == 192 || code == 222 || code == 221) return true
      if (!key.match(/[a-z]/gi)) return false
    }
    if (pat == 'numeric' && !key.match(/[0-9]/g)) return false
    return true
  },
  __hasValidationAttr: function (el) {
    const req = el.getAttribute('required')
    if (req || req === '') return true
    var mask = el.getAttribute('mask')
    if (mask) return true
    var mask = el.getAttribute('freemask')
    if (mask) return true
    const regexp = el.getAttribute('regexpPattern')
    if (regexp) return true
    const equalTo = el.getAttribute('equalTo')
    if (equalTo) return true
    return false
  },
  __addParentToSelect: function (selectRef) {
    const div = document.createElement('DIV')
    selectRef.parentNode.insertBefore(div, selectRef)
    div.appendChild(selectRef)
    div.className = 'DHTMLSuite_validInput'
    div.style.cssText = 'display:inline-block;'
    div.style.width = selectRef.offsetWidth + 'px'
  },
  __validateInput: function (inputRef) {
    inputRef = DHTMLSuite.commonObj.getEl(inputRef)
    const index = inputRef.name
    if (this.__isInputValid(inputRef)) {
      this.formElements[index].result = true
      this.__toggleInput(inputRef, 'valid')
    } else {
      this.formElements[index].result = false
      this.__toggleInput(inputRef, 'invalid')
    }
    this.__validateForm()
  },
  __isInputValid: function (inputRef, circular) {
    let elType = 'select'
    if (
      (inputRef.tagName.toLowerCase() == 'input' &&
        inputRef.type.toLowerCase() == 'text') ||
      inputRef.tagName.toLowerCase() == 'textarea'
    ) {
      elType = 'text'
    }
    if (
      inputRef.tagName.toLowerCase() == 'input' &&
      inputRef.type.toLowerCase() == 'checkbox'
    ) {
      elType = 'checkbox'
    }
    if (
      inputRef.tagName.toLowerCase() == 'input' &&
      inputRef.type.toLowerCase() == 'radio'
    ) {
      elType = 'radio'
    }
    if (this.equalToEls.from[inputRef.name]) {
      const equal = this.formUtil.areEqual(
        inputRef,
        this.equalToEls.from[inputRef.name]
      )
      if (!equal) return false
    }
    if (this.equalToEls.to[inputRef.name]) {
      this.__validateInput(this.equalToEls.to[inputRef.name])
    }
    if (elType == 'text') {
      let pat = inputRef.getAttribute('regexpPattern')
      pat = pat.indexOf('/') == -1 ? this.masks[pat] : eval(pat)
      if (inputRef.value.trim().match(pat)) {
        const matches = inputRef.value.trim().match(pat)
        const minLength = inputRef.getAttribute('minLength')
        if (minLength) {
          if (inputRef.value.trim().length < minLength) return false
        }
        return true
      } else return false
    }
    if (elType == 'select') {
      const required = inputRef.getAttribute('required')
      const multiple = inputRef.getAttribute('multiple')
      if (multiple || multiple === '') {
        if (required || required === '') {
          for (var no = 0; no < inputRef.options.length; no++) {
            if (inputRef.options[no].selected && inputRef.options[no].value) {
              return true
            }
          }
          return false
        }
      } else {
        if (
          required ||
          (required === '' && !inputRef.options[inputRef.selectedIndex].value)
        ) {
          return false
        }
      }
    }
    if (elType == 'radio' || elType == 'checkbox') {
      const name = inputRef.name
      let elChecked = false
      for (var no = 0; no < this.radios[name].length; no++) {
        if (this.radios[name][no].checked) elChecked = true
      }
      if (!elChecked) return false
    }
    return true
  },
  __toggleInput: function (inputRef, style) {
    let el = inputRef
    if (this.indicationImages[el.name]) {
      var obj = this.indicationImages[el.name]
      obj.className = obj.className.replace(
        ' DHTMLSuite_invalidInputImage',
        ''
      )
      obj.className = obj.className.replace(' DHTMLSuite_validInputImage', '')
      if (style == 'valid') {
        obj.className = obj.className + ' DHTMLSuite_validInputImage'
      } else {
        obj.className = obj.className + ' DHTMLSuite_invalidInputImage'
      }
    }
    if (this.indicateWithBars) {
      var obj = this.indicationBars[el.name]
      if (!obj) return
      obj.className = obj.className.replace(
        ' DHTMLSuite_validationBarValid',
        ''
      )
      obj.className = obj.className.replace(
        ' DHTMLSuite_validationBarInvalid',
        ''
      )
      if (style == 'valid') {
        obj.className = obj.className + ' DHTMLSuite_validationBarValid'
      } else {
        obj.className = obj.className + ' DHTMLSuite_validationBarInvalid'
      }
    }
    if (this.indicateWithCss) {
      if (el.tagName.toLowerCase() == 'select') el = el.parentNode
      if (el.className.indexOf('DHTMLSuite_') == -1) return
      el.className = el.className.replace(' DHTMLSuite_invalidInput', '')
      el.className = el.className.replace(' DHTMLSuite_validInput', '')
      if (style == 'valid') {
        el.className = el.className + ' DHTMLSuite_validInput'
      } else {
        el.className = el.className + ' DHTMLSuite_invalidInput'
      }
    }
  },
  isFormValid: function () {
    for (const no in this.formElements) {
      if (!this.formElements[no].result) {
        return false
      }
    }
    return true
  },
  __validateForm: function () {
    if (this.isFormValid()) {
      this.__handleCallback('formValid')
    } else {
      this.__handleCallback('formInvalid')
    }
  },
  __handleCallback: function (action) {
    let callbackString = ''
    switch (action) {
      case 'formValid':
        if (this.callbackOnFormValid) callbackString = this.callbackOnFormValid
        break
      case 'formInvalid':
        if (this.callbackOnFormInvalid) {
          callbackString = this.callbackOnFormInvalid
        }
        break
    }
    if (callbackString) {
      callbackString = callbackString + '(this.formElements)'
      eval(callbackString)
    }
  }
}
DHTMLSuite.formUtil = function () {}
DHTMLSuite.formUtil.prototype = {
  getFamily: function (el, formRef) {
    const els = formRef.elements
    const retArray = new Array()
    for (let no = 0; no < els.length; no++) {
      if (els[no].name == el.name) retArray[retArray.length] = els[no]
    }
    return retArray
  },
  hasFileInputs: function (formRef) {
    const els = formRef.elements
    for (let no = 0; no < els.length; no++) {
      if (
        els[no].tagName.toLowerCase() == 'input' &&
        els[no].type.toLowerCase() == 'file'
      ) {
        return true
      }
    }
    return false
  },
  getValuesAsArray: function (formRef) {
    const retArray = new Object()
    formRef = DHTMLSuite.commonObj.getEl(formRef)
    const els = formRef.elements
    for (let no = 0; no < els.length; no++) {
      if (els[no].disabled) continue
      const tag = els[no].tagName.toLowerCase()
      switch (tag) {
        case 'input':
          var type = els[no].type.toLowerCase()
          if (!type) type = 'text'
          switch (type) {
            case 'text':
            case 'image':
            case 'hidden':
              retArray[els[no].name] = els[no].value
              break
            case 'checkbox':
              var boxes = this.getFamily(els[no], formRef)
              if (boxes.length > 1) {
                retArray[els[no].name] = new Array()
                for (var no2 = 0; no2 < boxes.length; no2++) {
                  if (boxes[no2].checked) {
                    var index = retArray[els[no].name].length
                    retArray[els[no].name][index] = boxes[no2].value
                  }
                }
              } else {
                if (els[no].checked) retArray[els[no].name] = els[no].value
              }
              break
            case 'radio':
              if (els[no].checked) retArray[els[no].name] = els[no].value
              break
          }
          break
        case 'select':
          var string = ''
          var mult = els[no].getAttribute('multiple')
          if (mult || mult === '') {
            retArray[els[no].name] = new Array()
            for (var no2 = 0; no2 < els[no].options.length; no2++) {
              var index = retArray[els[no].name].length
              if (els[no].options[no2].selected) {
                retArray[els[no].name][index] = els[no].options[no2].value
              }
            }
          } else {
            retArray[els[no].name] =
              els[no].options[els[no].selectedIndex].value
          }
          break
        case 'textarea':
          retArray[els[no].name] = els[no].value
          break
      }
    }
    return retArray
  },
  getValue: function (formEl) {
    switch (formEl.tagName.toLowerCase()) {
      case 'input':
      case 'textarea':
        return formEl.value
      case 'select':
        return formEl.options[formEl.selectedIndex].value
    }
  },
  areEqual: function (input1, input2) {
    input1 = DHTMLSuite.commonObj.getEl(input1)
    input2 = DHTMLSuite.commonObj.getEl(input2)
    if (this.getValue(input1) == this.getValue(input2)) return true
    return false
  }
}
DHTMLSuite.form = function (propArray) {
  let formRef
  let method
  let responseEl
  let action
  let responseFile
  let formUtil
  let objectIndex
  let sackObj
  let coverDiv
  let layoutCSS
  let iframeName
  this.method = 'POST'
  this.sackObj = new Array()
  this.formUtil = new DHTMLSuite.formUtil()
  this.layoutCSS = 'form.css'
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects()
  } catch (e) {
    alert('Include the dhtmlSuite-common.js file')
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this
  DHTMLSuite.commonObj.loadCSS(this.layoutCSS)
  if (propArray) this.__setInitProperties(propArray)
}
DHTMLSuite.form.prototype = {
  submit: function () {
    this.__createCoverDiv()
    const index = this.sackObj.length
    if (this.formUtil.hasFileInputs(this.formRef)) {
      this.__createIframe()
      this.formRef.submit()
    } else {
      this.__createSackObject(index)
      this.__populateSack(index)
      this.sackObj[index].runAJAX()
    }
    this.__positionCoverDiv()
    return false
  },
  __createIframe: function () {
    if (this.iframeName) return
    const ind = this.objectIndex
    const div = document.createElement('DIV')
    document.body.appendChild(div)
    this.iframeName = 'DHTMLSuiteForm' + DHTMLSuite.commonObj.getUniqueId()
    div.innerHTML =
      '<iframe style="visibility:hidden;width:5px;height:5px" id="' +
      this.iframeName +
      '" name="' +
      this.iframeName +
      '" onload="parent.DHTMLSuite.variableStorage.arrayDSObjects[' +
      ind +
      '].__getIframeResponse()"></iframe>'
    this.formRef.method = this.method
    this.formRef.action = this.action
    this.formRef.target = this.iframeName
    if (!this.formRef.enctype) this.formRef.enctype = 'multipart/form-data'
  },
  __getIframeResponse: function () {
    if (this.responseEl) {
      if (this.responseFile) {
        if (!this.responseEl.id) {
          this.responseEl.id =
            'DHTMLSuite_formResponse' + DHTMLSuite.getUniqueId()
        }
        const dynContent = new DHTMLSuite.dynamicContent()
        dynContent.loadContent(this.responseEl.id, this.responseFile)
      } else {
        this.responseEl.innerHTML =
          self.frames[this.iframeName].document.body.innerHTML
        DHTMLSuite.commonObj.__evaluateJs(this.responseEl)
        DHTMLSuite.commonObj.__evaluateCss(this.responseEl)
      }
    }
    this.coverDiv.style.display = 'none'
    this.__handleCallback('onComplete')
  },
  __positionCoverDiv: function () {
    if (!this.responseEl) return
    try {
      const st = this.coverDiv.style
      st.left = DHTMLSuite.commonObj.getLeftPos(this.responseEl) + 'px'
      st.top = DHTMLSuite.commonObj.getTopPos(this.responseEl) + 'px'
      st.width = this.responseEl.offsetWidth + 'px'
      st.height = this.responseEl.offsetHeight + 'px'
      st.display = 'block'
    } catch (e) {}
  },
  __createCoverDiv: function () {
    if (this.coverDiv) return
    this.coverDiv = document.createElement('DIV')
    const el = this.coverDiv
    el.style.overflow = 'hidden'
    el.style.zIndex = 1000
    el.style.position = 'absolute'
    document.body.appendChild(el)
    const innerDiv = document.createElement('DIV')
    innerDiv.style.width = '105%'
    innerDiv.style.height = '105%'
    innerDiv.className = 'DHTMLSuite_formCoverDiv'
    innerDiv.style.opacity = '0.2'
    innerDiv.style.filter = 'alpha(opacity=20)'
    el.appendChild(innerDiv)
    const ajaxLoad = document.createElement('DIV')
    ajaxLoad.className = 'DHTMLSuite_formCoverDiv_ajaxLoader'
    el.appendChild(ajaxLoad)
  },
  __createSackObject: function (ajaxIndex) {
    const ind = this.objectIndex
    this.sackObj[ajaxIndex] = new sack()
    this.sackObj[ajaxIndex].requestFile = this.action
    this.sackObj[ajaxIndex].method = this.method
    this.sackObj[ajaxIndex].onCompletion = function () {
      DHTMLSuite.variableStorage.arrayDSObjects[ind].__getResponse(ajaxIndex)
    }
  },
  __getResponse: function (ajaxIndex) {
    if (this.responseEl) {
      if (this.responseFile) {
        if (!this.responseEl.id) {
          this.responseEl.id =
            'DHTMLSuite_formResponse' + DHTMLSuite.getUniqueId()
        }
        const dynContent = new DHTMLSuite.dynamicContent()
        dynContent.loadContent(this.responseEl.id, this.responseFile)
      } else {
        this.responseEl.innerHTML = this.sackObj[ajaxIndex].response
        DHTMLSuite.commonObj.__evaluateJs(this.responseEl)
        DHTMLSuite.commonObj.__evaluateCss(this.responseEl)
      }
    }
    this.coverDiv.style.display = 'none'
    this.sackObj[ajaxIndex] = null
    this.__handleCallback('onComplete')
  },
  __populateSack: function (ajaxIndex) {
    const els = this.formUtil.getValuesAsArray(this.formRef)
    for (const prop in els) {
      if (DHTMLSuite.commonObj.isArray(els[prop])) {
        for (let no = 0; no < els[prop].length; no++) {
          let name = prop + '[' + no + ']'
          if (prop.indexOf('[') >= 0) {
            name = prop.replace('[', '[' + no)
          }
          this.sackObj[ajaxIndex].setVar(name, els[prop][no])
        }
      } else {
        this.sackObj[ajaxIndex].setVar(prop, els[prop])
      }
    }
  },
  __setInitProperties: function (props) {
    if (props.formRef) this.formRef = DHTMLSuite.commonObj.getEl(props.formRef)
    if (props.method) this.method = props.method
    if (props.responseEl) {
      this.responseEl = DHTMLSuite.commonObj.getEl(props.responseEl)
    }
    if (props.action) this.action = props.action
    if (props.responseFile) this.responseFile = props.responseFile
    if (props.callbackOnComplete) {
      this.callbackOnComplete = props.callbackOnComplete
    }
    if (!this.action) this.action = this.formRef.action
    if (!this.method) this.method = this.formRef.method
  },
  __handleCallback: function (action) {
    let callbackString = ''
    switch (action) {
      case 'onComplete':
        callbackString = this.callbackOnComplete
        break
    }
    if (callbackString) {
      if (callbackString.indexOf('(') == -1) {
        callbackString = callbackString + '("' + this.formRef.name + '")'
      }
      eval(callbackString)
    }
  }
}
