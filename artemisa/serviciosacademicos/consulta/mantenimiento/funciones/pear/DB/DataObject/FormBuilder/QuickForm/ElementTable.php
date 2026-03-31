<?php
/**
 * This is a new element type for HTML_QuickForm which defines a table of QuickForm elements
 *
 * PHP Versions 4 and 5
 *
 * @category DB
 * @package  DB_DataObject_FormBuilder
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @author   Justin Patrin <papercrane@reversefold.com>
 * @version  $Id: ElementTable.php,v 1.4 2007/02/07 16:40:26 Abraham Castro Exp $
 */

require_once('HTML/QuickForm/element.php');

/**
 * An HTML_QuickForm element which holds any number of other elements in a table.
 * Used in DB_DataObject_FormBuilder for tripleLinks and crossLinks when there are
 * crossLinkExtraFields. This element type makes these tables of elements behave the
 * same as normal elements in the form. i.e. they will freeze correctly and get
 * values (defaults) set correctly.
 */
class DB_DataObject_FormBuilder_QuickForm_ElementTable extends HTML_QuickForm_element {

    /**
     * Array of arrays of HTML_QuickForm elements
     *
     * @var array
     */
    var $_rows = array();

    /**
     * Array of column names (strings)
     *
     * @var array
     */
    var $_columnNames = array();

    /**
     * Array of row names (strings)
     *
     * @var array
     */
    var $_rowNames = array();

    /**
     * Holds this element's name
     *
     * @var string
     */
    var $_name;

    /**
     * Constructor
     *
     * @param string name for the element
     * @param string label for the element
     */
    function DB_DataObject_FormBuilder_QuickForm_ElementTable($name = null, $label = null/*, $columnNames = null,
                                                              $rowNames = null, $rows = null, $attributes = null*/) {
        parent::HTML_QuickForm_element($name, $label);
        //$this->setRows($rows);
        //$this->setColumnNames($columnNames);
        //$this->setRowNames($rowNames);
    }

    /**
     * Sets this element's name
     *
     * @param string name
     */
    function setName($name) {
        $this->_name = $name;
    }

    /**
     * Gets this element's name
     *
     * @return string name
     */
    function getName() {
        return $this->_name;
    }

    /**
     * Sets the column names
     *
     * @param array array of column names (strings)
     */
    function setColumnNames($columnNames) {
        $this->_columnNames = $columnNames;
    }

    /**
     * Adds a column name
     *
     * @param string name of the column
     */
    function addColumnName($columnName) {
        $this->_columnNames[] = $columnName;
    }
    
    /**
     * Set the row names
     *
     * @param array array of row names (strings)
     */
    function setRowNames($rowNames) {
        $this->_rowNames = $rowNames;
    }

    /**
     * Sets the rows
     *
     * @param array array of HTML_QuickForm elements
     */
    function setRows(&$rows) {
        $this->_rows =& $rows;
    }

    /**
     * Adds a row to the table
     *
     * @param array array of HTML_QuickForm elements
     * @param string name of the row
     */
    function addRow(&$row, $rowName = null) {
        $this->_rows[] =& $row;
        if ($rowName !== null) {
            $this->addRowName($rowName);
        }
    }

    /**
     * Adds a row name
     *
     * @param string name of the row
     */
    function addRowName($rowName) {
        $this->_rowNames[] = $rowName;
    }

    /**
     * Freezes all checkboxes in the table
     */
    function freeze() {
        parent::freeze();
        foreach (array_keys($this->_rows) as $key) {
            foreach (array_keys($this->_rows[$key]) as $key2) {
                $this->_rows[$key][$key2]->freeze();
            }
        }
    }

    /**
     * Returns Html for the group
     * 
     * @access      public
     * @return      string
     */
    function toHtml()
    {
        include_once ('HTML/Table.php');
        $tripleLinkTable = new HTML_Table();
        $tripleLinkTable->setAutoGrow(true);
        $tripleLinkTable->setAutoFill('');
        $tripleLinkTable->updateAttributes($this->getAttributes());
        $row = 0;
        $col = 0;

        if ($this->_columnNames) {
            foreach ($this->_columnNames as $key => $value) {
                ++$col;
                $tripleLinkTable->setCellContents($row, $col, $value);
                $tripleLinkTable->setCellAttributes($row, $col, array('style' => 'text-align: center'));
            }
            ++$row;
        }

        foreach (array_keys($this->_rows) as $key) {
            $col = 0;
            $tripleLinkTable->setCellContents($row, $col, $this->_rowNames[$key]);
            foreach (array_keys($this->_rows[$key]) as $key2) {
                ++$col;
                $tripleLinkTable->setCellContents($row, $col, $this->_rows[$key][$key2]->toHTML());
                $tripleLinkTable->setCellAttributes($row, $col, array('style' => 'text-align: center'));
            }
            ++$row;
        }
        if ($this->_columnNames) {
            $tripleLinkTable->setRowAttributes(0, array('class' => 'elementTableColumnLabel'), true);
        }
        $tripleLinkTable->setColAttributes(0, array('class' => 'elementTableRowLabel'));
        return $tripleLinkTable->toHTML();

        /*include_once('HTML/QuickForm/Renderer/Default.php');
        $renderer =& new HTML_QuickForm_Renderer_Default();
        $renderer->setElementTemplate('{element}');
        $this->accept($renderer);
        return $renderer->toHtml();*/
    } //end func toHtml

    /**
     * Called by HTML_QuickForm whenever form event is made on this element
     *
     * @param     string  Name of event
     * @param     mixed   event arguments
     * @param     object  calling object
     * @access    public
     * @return    bool    true
     */
    function onQuickFormEvent($event, $arg, &$caller)
    {
        switch ($event) {
            case 'updateValue':
                foreach (array_keys($this->_rows) as $key) {
                    foreach (array_keys($this->_rows[$key]) as $key2) {
                        $this->_rows[$key][$key2]->onQuickFormEvent('updateValue', null, $caller);
                    }
                }
                break;

            default:
                parent::onQuickFormEvent($event, $arg, $caller);
        }
        return true;
    }
}

?>