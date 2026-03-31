if (!window.DHTMLSuite) var DHTMLSuite = new Object()
DHTMLSuite.menuModelItem = function () {
  let id
  let itemText
  let itemIcon
  let url
  let parentId
  let separator
  let jsFunction
  let depth
  let hasSubs
  let type
  let helpText
  let state
  let submenuWidth
  let visible
  this.state = 'regular'
}
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
    this.id = id
    this.itemText = itemText
    this.itemIcon = itemIcon
    this.url = url
    this.parentId = parentId
    this.jsFunction = jsFunction
    this.separator = false
    this.depth = false
    this.hasSubs = false
    this.helpText = helpText
    this.submenuWidth = submenuWidth
    this.visible = true
    if (!type) {
      if (this.parentId) this.type = 'top'
      else this.type = 'sub'
    } else this.type = type
  },
  setAsSeparator: function (id, parentId) {
    this.id = id
    this.parentId = parentId
    this.separator = true
    this.visible = true
    if (this.parentId) this.type = 'top'
    else this.type = 'sub'
  },
  setVisibility: function (visible) {
    this.visible = visible
  },
  getState: function () {
    return this.state
  },
  setState: function (newState) {
    this.state = newState
  },
  setSubMenuWidth: function (newWidth) {
    this.submenuWidth = newWidth
  },
  setIcon: function (iconPath) {
    this.itemIcon = iconPath
  },
  setText: function (newText) {
    this.itemText = newText
  }
}
DHTMLSuite.menuModel = function () {
  let menuItems
  let menuItemsOrder
  let submenuType
  let mainMenuGroupWidth
  this.menuItems = new Object()
  this.menuItemsOrder = new Array()
  this.submenuType = new Array()
  this.submenuType[1] = 'top'
  for (let no = 2; no < 20; no++) {
    this.submenuType[no] = 'sub'
  }
  try {
    if (!standardObjectsCreated) DHTMLSuite.createStandardObjects()
  } catch (e) {
    alert('Include the dhtmlSuite-common.js file')
  }
}
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
    if (!id) id = this.__getUniqueId()
    try {
      this.menuItems[id] = new DHTMLSuite.menuModelItem()
    } catch (e) {
      alert('Error: Include dhtmlSuite-menuModel.js in your html file')
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
    )
    this.menuItemsOrder[this.menuItemsOrder.length] = id
    return this.menuItems[id]
  },
  addItemsFromMarkup: function (ulId) {
    if (!document.getElementById(ulId)) {
      alert('<UL> tag with id ' + ulId + ' does not exist')
      return
    }
    const ulObj = document.getElementById(ulId)
    const liTags = ulObj.getElementsByTagName('LI')
    for (var no = 0; no < liTags.length; no++) {
      var id = liTags[no].id.replace(/[^0-9]/gi, '')
      if (!id || this.menuItems[id]) id = this.__getUniqueId()
      try {
        this.menuItems[id] = new DHTMLSuite.menuModelItem()
      } catch (e) {
        alert('Error: Include dhtmlSuite-menuModel.js in your html file')
      }
      this.menuItemsOrder[this.menuItemsOrder.length] = id
      let parentId = 0
      if (liTags[no].parentNode != ulObj) {
        parentId = liTags[no].parentNode.parentNode.id
      }
      let type = liTags[no].getAttribute('itemType')
      if (!type) type = liTags[no].itemType
      if (type == 'separator') {
        this.menuItems[id].setAsSeparator(id, parentId)
        continue
      }
      type = parentId ? 'sub' : 'top'
      const aTag = liTags[no].getElementsByTagName('A')[0]
      if (!aTag) {
        continue
      }
      if (aTag) var itemText = aTag.innerHTML
      const itemIcon = liTags[no].getAttribute('itemIcon')
      let url = aTag.href
      if (url == '#' || url.substr(url.length - 1, 1) == '#') url = ''
      const jsFunction = liTags[no].getAttribute('jsFunction')
      const submenuWidth = false
      let helpText = aTag.getAttribute('title')
      if (!helpText) helpText = aTag.title
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
      )
    }
    const subUls = ulObj.getElementsByTagName('UL')
    for (var no = 0; no < subUls.length; no++) {
      let width = subUls[no].getAttribute('width')
      if (!width) width = subUls[no].width
      if (width) {
        var id = subUls[no].parentNode.id.replace(/[^0-9]/gi, '')
        this.setSubMenuWidth(id, width)
      }
    }
    ulObj.style.display = 'none'
  },
  setSubMenuWidth: function (id, newWidth) {
    this.menuItems[id].setSubMenuWidth(newWidth)
  },
  setMainMenuGroupWidth: function (newWidth) {
    this.mainMenuGroupWidth = newWidth
  },
  addSeparator: function (parentId) {
    id = this.__getUniqueId()
    if (!parentId) parentId = 0
    try {
      this.menuItems[id] = new DHTMLSuite.menuModelItem()
    } catch (e) {
      alert('Error: Include dhtmlSuite-menuModel.js in your html file')
    }
    this.menuItems[id].setAsSeparator(id, parentId)
    this.menuItemsOrder[this.menuItemsOrder.length] = id
    return this.menuItems[id]
  },
  init: function () {
    this.__getDepths()
    this.__setHasSubs()
  },
  setMenuItemVisibility: function (id, visible) {
    this.menuItems[id].setVisibility(visible)
  },
  setSubMenuType: function (depth, newType) {
    this.submenuType[depth] = newType
    this.__getDepths()
  },
  getItems: function (parentId, returnArray) {
    if (!parentId) return this.menuItems
    if (!returnArray) returnArray = new Array()
    for (let no = 0; no < this.menuItemsOrder.length; no++) {
      const id = this.menuItemsOrder[no]
      if (!id) continue
      if (this.menuItems[id].parentId == parentId) {
        returnArray[returnArray.length] = this.menuItems[id]
        if (this.menuItems[id].hasSubs) {
          return this.getItems(this.menuItems[id].id, returnArray)
        }
      }
    }
    return returnArray
  },
  __getUniqueId: function () {
    let num = String(Math.random())
    num = num.replace('.', '')
    num = '99' + num
    num = num / 1
    while (this.menuItems[num]) {
      num = String(Math.random())
      num = num.replace('.', '')
      num = num / 1
    }
    return num
  },
  __getDepths: function () {
    for (let no = 0; no < this.menuItemsOrder.length; no++) {
      const id = this.menuItemsOrder[no]
      if (!id) continue
      this.menuItems[id].depth = 1
      if (this.menuItems[id].parentId) {
        this.menuItems[id].depth =
          this.menuItems[this.menuItems[id].parentId].depth + 1
      }
      this.menuItems[id].type = this.submenuType[this.menuItems[id].depth]
    }
  },
  __setHasSubs: function () {
    for (let no = 0; no < this.menuItemsOrder.length; no++) {
      const id = this.menuItemsOrder[no]
      if (!id) continue
      if (this.menuItems[id].parentId) {
        this.menuItems[this.menuItems[id].parentId].hasSubs = 1
      }
    }
  },
  __hasSubs: function (id) {
    for (let no = 0; no < this.menuItemsOrder.length; no++) {
      var id = this.menuItemsOrder[no]
      if (!id) continue
      if (this.menuItems[id].parentId == id) return true
    }
    return false
  },
  __deleteChildNodes: function (parentId, recursive) {
    const itemsToDeleteFromOrderArray = new Array()
    for (var prop = 0; prop < this.menuItemsOrder.length; prop++) {
      const id = this.menuItemsOrder[prop]
      if (!id) continue
      if (this.menuItems[id].parentId == parentId && parentId) {
        this.menuItems[id] = false
        itemsToDeleteFromOrderArray[itemsToDeleteFromOrderArray.length] = id
        this.__deleteChildNodes(id, true)
      }
    }
    if (!recursive) {
      for (var prop = 0; prop < itemsToDeleteFromOrderArray.length; prop++) {
        if (!itemsToDeleteFromOrderArray[prop]) continue
        this.__deleteItemFromItemOrderArray(itemsToDeleteFromOrderArray[prop])
      }
    }
    this.__setHasSubs()
  },
  __deleteANode: function (id) {
    this.menuItems[id] = false
    this.__deleteItemFromItemOrderArray(id)
  },
  __deleteItemFromItemOrderArray: function (id) {
    for (let no = 0; no < this.menuItemsOrder.length; no++) {
      const tmpId = this.menuItemsOrder[no]
      if (!tmpId) continue
      if (this.menuItemsOrder[no] == id) {
        this.menuItemsOrder.splice(no, 1)
        return
      }
    }
  },
  __appendMenuModel: function (newModel, parentId) {
    if (!newModel) return
    const items = newModel.getItems()
    for (let no = 0; no < newModel.menuItemsOrder.length; no++) {
      const id = newModel.menuItemsOrder[no]
      if (!id) continue
      if (!items[id].parentId) items[id].parentId = parentId
      this.menuItems[id] = items[id]
      for (let no2 = 0; no2 < this.menuItemsOrder.length; no2++) {
        if (!this.menuItemsOrder[no2]) continue
        if (this.menuItemsOrder[no2] == items[id].id) {
          this.menuItemsOrder.splice(no2, 1)
        }
      }
      this.menuItemsOrder[this.menuItemsOrder.length] = items[id].id
    }
    this.__getDepths()
    this.__setHasSubs()
  }
}
