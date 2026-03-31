if (!window.DHTMLSuite) var DHTMLSuite = new Object()
DHTMLSuite.imageSelection = function () {
  let layoutCSS
  let callBackFunction_onDrop
  let objectIndex
  let divElementSelection
  let divElementSelection_transparent
  let selectableEls
  let selectedEls
  let selectableElsScreenProps
  let collectionModelReference
  let destinationEls
  let currentDestEl
  let selectionStatus
  let dragStatus
  let startCoordinates
  let selectionResizeInProgress
  let selectionStartArea
  let selectionOrDragStartEl
  this.selectionResizeInProgress = false
  this.selectionStatus = -1
  this.dragStatus = -1
  this.startCoordinates = new Object()
  this.layoutCSS = 'image-selection.css'
  this.selectableEls = new Array()
  this.destinationEls = new Array()
  this.collectionModelReference = false
  this.selectableElsScreenProps = new Object()
  this.selectedEls = new Array()
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects()
  } catch (e) {
    alert('Include the dhtmlSuite-common.js file')
  }
  this.objectIndex = DHTMLSuite.variableStorage.arrayDSObjects.length
  DHTMLSuite.variableStorage.arrayDSObjects[this.objectIndex] = this
}
DHTMLSuite.imageSelection.prototype = {
  init: function () {
    try {
      DHTMLSuite.commonObj.loadCSS(this.layoutCSS)
    } catch (e) {
      alert(
        'Unable to load css file dynamically. Include dhtmlSuite-common.js'
      )
    }
    this.__createdivElementsForSelection()
    this.__createdivElementsForDrag()
    this.__addEvents()
    this.__setSelectableElsScreenProps()
  },
  addDestinationElement: function (elementReference) {
    elementReference = DHTMLSuite.commonObj.getEl(elementReference)
    this.destinationEls[this.destinationEls.length] = elementReference
  },
  addDestinationElementsByTagName: function (
    parentElementReference,
    tagName,
    className
  ) {
    parentElementReference = DHTMLSuite.commonObj.getEl(parentElementReference)
    if (!parentElementReference) {
      return false
    }
    const subs = parentElementReference.getElementsByTagName(tagName)
    for (let no = 0; no < subs.length; no++) {
      if (className && subs[no].className != className) continue
      this.destinationEls[this.destinationEls.length] = subs[no]
    }
    this.__addEventsTodestinationEls(subs)
    return true
  },
  addSelectableElements: function (parentElementReference) {
    const obj = DHTMLSuite.commonObj.getEl(parentElementReference)
    let subElement = obj.getElementsByTagName('*')[0]
    while (subElement) {
      this.selectableEls[this.selectableEls.length] = subElement
      this.__addPropertiesToSelectableElement(subElement)
      subElement = subElement.nextSibling
    }
  },
  addSelectableElement: function (elementReference) {
    this.selectableEls[this.selectableEls.length] =
      DHTMLSuite.commonObj.getEl(elementReference)
    this.__addPropertiesToSelectableElement(elementReference)
  },
  setCallBackFunctionOnDrop: function (functionName) {
    this.callBackFunction_onDrop = functionName
  },
  setSelectionStartArea: function (elementReference) {
    elementReference = DHTMLSuite.commonObj.getEl(elementReference)
    this.selectionStartArea = elementReference
  },
  __createdivElementsForSelection: function () {
    this.divElementSelection = document.createElement('DIV')
    this.divElementSelection.style.display = 'none'
    this.divElementSelection.id = 'DHTMLSuite_imageSelectionSel'
    this.divElementSelection.innerHTML = '<span></span>'
    document.body.insertBefore(
      this.divElementSelection,
      document.body.firstChild
    )
    this.divElementSelection_transparent = document.createElement('DIV')
    this.divElementSelection_transparent.id =
      'DHTMLSuite_imageSelection_transparentDiv'
    this.divElementSelection.appendChild(this.divElementSelection_transparent)
    this.divElementSelection_transparent.innerHTML = '<span></span>'
  },
  __setMediaCollectionModelReference: function (collectionModelReference) {
    this.collectionModelReference = collectionModelReference
  },
  __createdivElementsForDrag: function () {
    this.divElementDrag = document.createElement('DIV')
    this.divElementDrag.innerHTML = '<span></span>'
    this.divElementDrag.style.display = 'none'
    this.divElementDrag.id = 'DHTMLSuite_imageSelectionDrag'
    document.body.insertBefore(this.divElementDrag, document.body.firstChild)
    this.divElementDragContent = document.createElement('DIV')
    this.divElementDragContent.innerHTML = '<span></span>'
    this.divElementDragContent.id = 'DHTMLSuite_imageSelectionDragContent'
    this.divElementDrag.appendChild(this.divElementDragContent)
    const divElementTrans = document.createElement('DIV')
    divElementTrans.className = 'DHTMLSuite_imageSelectionDrag_transparentDiv'
    this.divElementDrag.appendChild(divElementTrans)
  },
  __initImageSelection: function (e) {
    let initImageSelector
    if (document.all) e = event
    const src = DHTMLSuite.commonObj.getSrcElement(e)
    if (src.onmousedown) {
    }
    if (
      src.className.indexOf('paneSplitter_vertical') >= 0 ||
      src.className.indexOf('paneSplitter_horizontal') >= 0
    ) {
      return
    }
    this.selectionOrDragStartEl = src
    this.startCoordinates.x =
      e.clientX + document.documentElement.scrollLeft + 3
    this.startCoordinates.y =
      e.clientY + document.documentElement.scrollTop + 3
    if (!this.__isReadyForDrag(e)) {
      if (!e.shiftKey && !e.ctrlKey) this.__clearselectedElsArray()
      this.selectionStatus = 0
      this.divElementSelection.style.left = this.startCoordinates.x + 'px'
      this.divElementSelection.style.top = this.startCoordinates.y + 'px'
      this.divElementSelection.style.width = '1px'
      this.divElementSelection.style.height = '1px'
      this.__setSelectableElsScreenProps()
      this.__countDownToSelectionStart()
    } else {
      this.divElementDrag.style.left = this.startCoordinates.x + 'px'
      this.divElementDrag.style.top = this.startCoordinates.y + 'px'
      this.dragStatus = 0
      this.__countDownToDragStart()
    }
    return false
  },
  __isReadyForDrag: function (e) {
    const src = DHTMLSuite.commonObj.getObjectByAttribute(
      e,
      'DHTMLSuite_selectableElement'
    )
    if (!src) return false
    if (this.selectedEls.length > 0) return true
    return false
  },
  __countDownToDragStart: function () {
    if (this.dragStatus >= 0 && this.dragStatus < 5) {
      const ind = this.objectIndex
      this.dragStatus++
      let timeOut = 60
      if (this.selectedEls.length > 1) timeOut = 10
      setTimeout(
        'DHTMLSuite.variableStorage.arrayDSObjects[' +
          ind +
          '].__countDownToDragStart()',
        timeOut
      )
    }
    if (this.dragStatus == 5) {
      this.__fillDragBoxWithSelectedItems()
      this.divElementDrag.style.display = 'block'
    }
  },
  __fillDragBoxWithSelectedItems: function () {
    this.divElementDragContent.innerHTML = ''
    if (this.collectionModelReference) {
      for (var no = 0; no < this.selectedEls.length; no++) {
        const obj = this.selectedEls[no]
        const mediaRefId = obj.getAttribute('mediaRefId')
        if (!mediaRef) mediaRef = obj.mediaRefId
        var mediaRef = this.collectionModelReference.getMediaById(mediaRefId)
        const div = document.createElement('DIV')
        div.innerHTML = '<span></span>'
        div.className = 'DHTMLSuite_imageSelectionDragBox'
        div.style.backgroundImage =
          "url('" + mediaRef.thumbnailPathSmall + "')"
        this.divElementDragContent.appendChild(div)
      }
    } else {
      for (var no = 0; no < this.selectedEls.length; no++) {
        const el = this.selectedEls.cloneNode(true)
        this.divElementDragContent.appendChild(el)
      }
    }
  },
  __countDownToSelectionStart: function () {
    if (this.selectionStatus >= 0 && this.selectionStatus < 5) {
      const ind = this.objectIndex
      this.selectionStatus++
      setTimeout(
        'DHTMLSuite.variableStorage.arrayDSObjects[' +
          ind +
          '].__countDownToSelectionStart()',
        10
      )
    }
    if (this.selectionStatus == 5) {
      this.divElementSelection.style.display = 'block'
    }
    return false
  },
  __moveDragBox: function (e) {
    if (this.dragStatus < 5) return
    if (document.all) e = event
    this.divElementDrag.style.left =
      this.startCoordinates.x +
      (e.clientX + 3 - this.startCoordinates.x) +
      'px'
    this.divElementDrag.style.top =
      this.startCoordinates.y +
      (e.clientY + 3 - this.startCoordinates.y) +
      'px'
  },
  __resizeSelectionDivBox: function (e) {
    if (this.selectionStatus < 5) return
    if (this.selectionResizeInProgress) return
    this.selectionResizeInProgress = true
    if (document.all) e = event
    const width = e.clientX - this.startCoordinates.x
    const height =
      e.clientY + document.documentElement.scrollTop - this.startCoordinates.y
    if (width > 0) {
      this.divElementSelection.style.left = this.startCoordinates.x + 'px'
      this.divElementSelection.style.width = width + 'px'
    } else {
      this.divElementSelection.style.width =
        this.startCoordinates.x - (this.startCoordinates.x + width) + 'px'
      this.divElementSelection.style.left =
        this.startCoordinates.x + width + 'px'
    }
    if (height > 0) {
      this.divElementSelection.style.top = this.startCoordinates.y + 'px'
      this.divElementSelection.style.height = height + 'px'
    } else {
      this.divElementSelection.style.height =
        this.startCoordinates.y - (this.startCoordinates.y + height) + 'px'
      this.divElementSelection.style.top =
        this.startCoordinates.y + height + 'px'
    }
    this.__highlightElementsWithinSelectionArea()
    this.selectionResizeInProgress = false
  },
  __clearSingleElementFromSelectedArray: function (el) {
    for (let no = 0; no < this.selectedEls.length; no++) {
      if (this.selectedEls[no] == el) {
        this.selectedEls[no].className = this.selectedEls[no].className.replace(
          ' imageSelection',
          ''
        )
        this.selectedEls.splice(no, 1)
        return
      }
    }
  },
  __clearselectedElsArray: function () {
    for (let no = 0; no < this.selectedEls.length; no++) {
      if (this.selectedEls[no].className.indexOf('imageSelection') >= 0) {
        this.selectedEls[no].className = this.selectedEls[no].className.replace(
          ' imageSelection',
          ''
        )
      }
    }
    this.selectedEls = new Array()
  },
  __highlightElementsWithinSelectionArea: function () {
    const x1 = this.divElementSelection.style.left.replace('px', '') / 1
    const y1 = this.divElementSelection.style.top.replace('px', '') / 1
    const x2 = x1 + this.divElementSelection.style.width.replace('px', '') / 1
    const y2 = y1 + this.divElementSelection.style.height.replace('px', '') / 1
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
        this.__addSelectedElement(this.selectableEls[no])
      } else {
        this.__clearSingleElementFromSelectedArray(this.selectableEls[no])
      }
    }
  },
  __isElementInSelectedArray: function (el) {
    for (let no = 0; no < this.selectedEls.length; no++) {
      if (this.selectedEls[no] == el) return true
    }
    return false
  },
  __addSelectedElement: function (el) {
    if (el.className.indexOf('imageSelection') == -1) {
      if (el.className) el.className = el.className + ' imageSelection'
      else el.className = 'imageSelection'
    }
    if (this.__isElementInSelectedArray(el)) return
    this.selectedEls[this.selectedEls.length] = el
  },
  __isElementWithinSelectionArea: function (el, x1, y1, x2, y2) {
    const elX1 = this.selectableElsScreenProps[el.id].x
    const elY1 = this.selectableElsScreenProps[el.id].y
    const elX2 =
      this.selectableElsScreenProps[el.id].x +
      this.selectableElsScreenProps[el.id].width
    const elY2 =
      this.selectableElsScreenProps[el.id].y +
      this.selectableElsScreenProps[el.id].height
    if (elX2 < x1) return false
    if (elY2 < y1) return false
    if (elX1 > x2) return false
    if (elY1 > y2) return false
    if (
      (elY1 <= y1 && elY2 >= y1) ||
      (elY1 >= y1 && elY2 <= y2) ||
      (elY1 <= y2 && elY2 >= y2)
    ) {
      if (elX1 <= x1 && elX2 >= x1) return true
      if (elX1 >= x1 && elX2 <= x2) return true
      if (elX1 <= x2 && elX2 >= x2) return true
    }
    return false
  },
  __setSelectableElsScreenProps: function () {
    for (let no = 0; no < this.selectableEls.length; no++) {
      const obj = this.selectableEls[no]
      if (!obj.parentNode) {
        this.selectableEls.splice(no, 1)
        this.__setSelectableElsScreenProps()
        return
      }
      const id = obj.id
      this.selectableElsScreenProps[id] = new Object()
      const ref = this.selectableElsScreenProps[id]
      ref.x = DHTMLSuite.commonObj.getLeftPos(obj)
      ref.y = DHTMLSuite.commonObj.getTopPos(obj)
      ref.width = obj.offsetWidth
      ref.height = obj.offsetHeight
    }
  },
  __endImageSelection: function (e) {
    if (document.all) e = event
    if (this.selectionStatus >= 0) {
      this.divElementSelection.style.display = 'none'
      if (this.__isReadyForDrag(e) && this.selectionStatus == -1) {
        this.__clearselectedElsArray()
      }
      this.selectionStatus = -1
    }
    if (this.dragStatus >= 0) {
      const src = DHTMLSuite.commonObj.getSrcElement(e)
      if (this.currentDestEl) this.__handleCallBackFunctions('drop')
      this.divElementDrag.style.display = 'none'
      if (src != this.selectionOrDragStartEl || !src.className) {
        this.__clearselectedElsArray()
      }
      this.__deselectDestinationElement()
      this.dragStatus = -1
    }
  },
  __handleCallBackFunctions: function (action) {
    let callbackString = ''
    switch (action) {
      case 'drop':
        if (this.callBackFunction_onDrop) {
          callbackString = this.callBackFunction_onDrop
        }
        break
    }
    if (callbackString) {
      eval(callbackString + '(this.selectedEls,this.currentDestEl)')
    }
  },
  __deselectDestinationElement: function (e) {
    if (this.dragStatus < 5) return
    if (!this.currentDestEl) return
    if (document.all) e = event
    if (e && !DHTMLSuite.commonObj.isObjectClicked(this.currentDestEl, e)) {
      return
    }
    this.currentDestEl.className = this.currentDestEl.className.replace(
      ' imageSelection',
      ''
    )
    this.currentDestEl.className = this.currentDestEl.className.replace(
      'imageSelection',
      ''
    )
    this.currentDestEl = false
  },
  __selectDestinationElement: function (e) {
    if (this.dragStatus < 5) return
    if (document.all) e = event
    const src = DHTMLSuite.commonObj.getObjectByAttribute(
      e,
      'imageSelectionDestination'
    )
    this.currentDestEl = src
    if (this.currentDestEl.className) {
      this.currentDestEl.className =
        this.currentDestEl.className + ' imageSelection'
    } else this.currentDestEl.className = 'imageSelection'
  },
  __selectSingleElement: function (e, eventType) {
    if (document.all) e = event
    const src = DHTMLSuite.commonObj.getObjectByAttribute(
      e,
      'DHTMLSuite_selectableElement'
    )
    const elementAllreadyInSelectedArray = this.__isElementInSelectedArray(src)
    if (!e.ctrlKey && !elementAllreadyInSelectedArray) {
      this.__clearselectedElsArray()
    }
    if (e.ctrlKey && elementAllreadyInSelectedArray) {
      this.__clearSingleElementFromSelectedArray(src)
    } else {
      this.__addSelectedElement(src)
    }
  },
  __addPropertiesToSelectableElement: function (elementReference) {
    const ind = this.objectIndex
    elementReference.onmousedown = function (e) {
      return DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__selectSingleElement(e)
    }
    elementReference.setAttribute('DHTMLSuite_selectableElement', '1')
    this.__addOnScrollEventsToSelectableEls(elementReference)
  },
  __addEventsTodestinationEls: function (inputElements) {
    const ind = this.objectIndex
    if (inputElements) {
      for (var no = 0; no < inputElements.length; no++) {
        inputElements[no].onmouseover = function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__selectDestinationElement(e)
        }
        inputElements[no].onmouseout = function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__deselectDestinationElement(e)
        }
        inputElements[no].setAttribute('imageSelectionDestination', '1')
        inputElements[no].imageSelectionDestination = '1'
        DHTMLSuite.commonObj.__addEventEl(inputElements[no])
      }
    } else {
      for (var no = 0; no < this.destinationEls.length; no++) {
        this.destinationEls[no].onmouseover = function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__selectDestinationElement(e)
        }
        this.destinationEls[no].onmouseout = function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__deselectDestinationElement(e)
        }
        DHTMLSuite.commonObj.__addEventEl(this.destinationEls[no])
        this.destinationEls[no].setAttribute('imageSelectionDestination', '1')
        this.destinationEls[no].imageSelectionDestination = '1'
      }
    }
  },
  __addOnScrollEventsToSelectableEls: function (el) {
    const ind = this.objectIndex
    let src = el
    while (src && src.tagName.toLowerCase() != 'body') {
      src = src.parentNode
      if (!src.onscroll) {
        DHTMLSuite.commonObj.addEvent(src, 'scroll', function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__endImageSelection(e)
        })
      }
    }
  },
  __addEvents: function () {
    const ind = this.objectIndex
    document.documentElement.onselectstart = function () {
      return false
    }
    DHTMLSuite.commonObj.__addEventEl(document.documentElement.onselectstart)
    if (this.selectionStartArea) {
      DHTMLSuite.commonObj.addEvent(
        this.selectionStartArea,
        'mousedown',
        function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__initImageSelection(e)
        }
      )
    } else {
      DHTMLSuite.commonObj.addEvent(
        document.documentElement,
        'mousedown',
        function (e) {
          return DHTMLSuite.variableStorage.arrayDSObjects[
            ind
          ].__initImageSelection(e)
        }
      )
    }
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      'mousemove',
      function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[
          ind
        ].__resizeSelectionDivBox(e)
      }
    )
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      'mousemove',
      function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[ind].__moveDragBox(e)
      }
    )
    DHTMLSuite.commonObj.addEvent(
      document.documentElement,
      'mouseup',
      function (e) {
        return DHTMLSuite.variableStorage.arrayDSObjects[
          ind
        ].__endImageSelection(e)
      }
    )
    DHTMLSuite.commonObj.addEvent(window, 'resize', function () {
      return DHTMLSuite.variableStorage.arrayDSObjects[
        ind
      ].__setSelectableElsScreenProps()
    })
    const imgs = document.getElementsByTagName('IMG')
    for (let no = 0; no < imgs.length; no++) {
      imgs[no].ondragstart = function () {
        return false
      }
      if (!imgs[no].onmousedown) {
        imgs[no].onmousedown = function () {
          return false
        }
      }
      DHTMLSuite.commonObj.__addEventEl(imgs[no])
    }
    this.__addEventsTodestinationEls()
  }
}
