<?php
// +-----------------------------------------------------------------------+
// | Copyright (c) 2002-2003, Richard Heyes                                |
// | All rights reserved.                                                  |
// |                                                                       |
// | Redistribution and use in source and binary forms, with or without    |
// | modification, are permitted provided that the following conditions    |
// | are met:                                                              |
// |                                                                       |
// | o Redistributions of source code must retain the above copyright      |
// |   notice, this list of conditions and the following disclaimer.       |
// | o Redistributions in binary form must reproduce the above copyright   |
// |   notice, this list of conditions and the following disclaimer in the |
// |   documentation and/or other materials provided with the distribution.|
// | o The names of the authors may not be used to endorse or promote      |
// |   products derived from this software without specific prior written  |
// |   permission.                                                         |
// |                                                                       |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
// | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
// | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
// | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
// | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
// | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
// | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
// | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
// | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
// |                                                                       |
// +-----------------------------------------------------------------------+
// | Author: Richard Heyes <richard@phpguru.org>                           |
// +-----------------------------------------------------------------------+

/**
* An OO tree class based on various things, including the MS treeview control
* If you use this class and wish to show your appreciation then visit my
* wishlist here:   http://www.amazon.co.uk/exec/obidos/wishlist/S8H2UOGMPZK6
*
* Structure of one of these trees:
*
*  Tree Object
*    |
*    +- Tree_NodeCollection object (nodes property)
*          |
*          +- Array of Tree_Node objects (nodes property)
*
* Usage:
*   $tree = &new Tree();
*   $node  = &$tree->nodes->addNode(new Tree_Node('1'));
*   $node2 = &$tree->nodes->addNode(new Tree_Node('2'));
*   $node3 = &$tree->nodes->addNode(new Tree_Node('3'));
*   $node4 = &$node3->nodes->addNode(new Tree_Node('3_1'));
*   $tree->nodes->removeNodeAt(0);
*   print_r($tree);
* 
* The data for a node is supplied by giving it as the argument to the Tree_Node
* constructor. You can retreive the data by using a nodes getTag() method, and alter
* it using the setTag() method.
*
* Public methods for Tree class:
*   createFromList(array data [, string separator])   (static) Returns a tree structure create from the supplied list
*   createFromMySQL(array $params)                    (static) Returns a tree structure created using a common DB storage technique
*
* Public methods for Tree_Node class:
*   setTag(mixed tag)                                 Sets the tag data
*   getTag()                                          Retreives the tag data
*   &prevSibling()                                    Retreives a reference to the previous sibling node
*   &nextSibling()                                    Retreives a reference to the next sibling node
*   remove()                                          Removes this node from the collection
*   
* Public variables for Tree_Node class:
*   $nodes
*
* Public methods for Tree_NodeCollection class:
*   &addNode(Tree_Node node)                           Adds a node to the collection
*   &firstNode()                                       Retreives a reference to the first node in the collection
*   &lastNode()                                        Retreives a reference to the last node in the collection
*   &removeNodeAt(int index)                           Removes the node at the specified index (nodes are re-ordered)
*   removeNode(Tree_Node node [, boolean search])      Removes the given node (nodes are re-ordered)
*   indexOf(Tree_Node node)                            Retreives the index of the given node
*   getNodeCount([boolean recurse])                    Retreives the number of nodes in the collection, optionally recursing
*   getFlatList()                                      Retrieves an indexed array of the nodes from top to bottom, left to right
*   traverse(callback function)                        Traverses the tree supply each node to the callback function
*   search(mixed searchData [, bool strict])           Basic search function for searching the Trees' "tag" data
*/

class Tree
{
    /**
    * UID counter
    * @var integer
    */
    var $uidCounter;
    
    /**
    * Child nodes
    * @var object
    */
    var $nodes;

    /**
    * Constructor
    */
    function Tree()
    {
        $this->nodes = new Tree_NodeCollection($this);
        $this->uidCounter = 0;
    }
    
    /**
    * Creates a tree structure from a list of items.
    * Items must be separated using the supplied separator.
    * Eg:    array('foo',
    *              'foo/bar',
    *              'foo/bar/jello',
    *              'foo/bar/jello2',
    *              'foo/bar2/jello')
    *
    * Would create a structure thus:
    *   foo
    *    +-bar
    *    |  +-jello
    *    |  +-jello2
    *    +-bar2
    *       +-jello
    * 
    * Example code:
    *   $list = array('Foo/Bar/blaat', 'Foo', 'Foo/Bar', 'Foo/Bar/Jello', 'Foo/Bar/Jello2', 'Foo/Bar2/Jello/Jello2');
    *   $tree = Tree::createFromList($list);
    *
    * @param  array  $data      The list as an indexed array
    * @param  string $separator The separator to use
    * @return object            A tree structure (Tree object)
    */
    function &createFromList($data, $separator = '/')
    {
        $nodeList = array();
        $tree     = new Tree();

        for ($i=0; $i<count($data); $i++) {
            $pathParts = explode($separator, $data[$i]);

            // If only one part then add it as a root node if
            // it's not already present.
            if (count($pathParts) == 1) {
                if (!empty($nodeList[$pathParts[0]])) {
                    continue;
                } else {
                    $nodeList[$pathParts[0]] = &new Tree_Node(array($pathParts[0], $data[$i]));
                    $tree->nodes->addNode($nodeList[$pathParts[0]]);
                }

            // Multiple parts means each part/parent combination
            // needs checking to see if it needs adding.
            } else {
                $parentObj = &$tree;

                for ($j=0; $j<count($pathParts); $j++) {
                    $currentPath = implode($separator, array_slice($pathParts, 0, $j + 1));
                    if (!empty($nodeList[$currentPath])) {
                        // Update parent object to be the existing node
                        $parentObj = &$nodeList[$currentPath];
                        continue;
                    } else {
                        $nodeList[$currentPath] = &new Tree_Node(array($pathParts[$j], $currentPath));
                        // Update parent object to be the new node
                        $parentObj = &$parentObj->nodes->addNode($nodeList[$currentPath]);
                    }
                }
            }
        }
        
        return $tree;
    }
    
    /**
    * This method imports a tree from a database using the common
    * id/parent_id method of storing the structure. Example code:
    *
    * $tree = &Tree::createFromMySQL(array('host'     => 'localhost',
    *                                      'user'     => 'root',
    *                                      'pass'     => '',
    *                                      'database' => 'treetest',
    *                                      'query'    => 'SELECT id, parent_id, text, icon, expandedIcon FROM structure ORDER BY parent_id, id'));
    *
    * @param array $params An associative array of information which can
    *                      consist of the following:
    *                      host       Hostname to use for connection
    *                      user       Username to use for connection
    *                      pass       Password to use for connection
    *                      connection In place of the above, you can instead supply
    *                                 this, which must be a mysql connection resource.
    *                      database   The database to use.
    *                      query      The query to perform. This must return
    *                                 at least two columns, "id", and "parent_id".
    *                                 other columns will be used as tag data. An example:
    *                                 SELECT id, parent_id FROM structure ORDER BY parent_id, id
    *                                 The query MUST be ordered by parent_id, then id.
    */
    function createFromMySQL($params)
    {
        $tree     = &new Tree();
        $nodeList = array();

        // Connect to server and select db
        if (!isset($params['connection'])) {
            $connection = mysql_connect($params['host'], $params['user'], $params['pass']);
            mysql_select_db($params['database']);
        } else {
            $connection = $params['connection'];
            if (!empty($params['database'])) {
                mysql_select_db($params['database']);
            }
        }

        // Perform query
        if ($result = mysql_query($params['query'])) {
            if (mysql_num_rows($result)) {

                // Loop thru results
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                    // Parent id is 0, thus root node.
                    if (!$row['parent_id']) {
                        unset($row['parent_id']);
                        $nodeList[$row['id']] = &new Tree_Node($row);
                        $tree->nodes->addNode($nodeList[$row['id']]);

                    // Parent node has already been added to tree
                    } elseif (!empty($nodeList[$row['parent_id']])) {
                        $parentNode = &$nodeList[$row['parent_id']];
                        unset($row['parent_id']);
                        $nodeList[$row['id']] = &new Tree_Node($row);
                        $parentNode->nodes->addNode($nodeList[$row['id']]);
                        
                    } else {
                        // Orphan node ?
                    }
                }
            }
        }
        
        return $tree;
    }
    
    /**
    * Merges two or more tree structures into one. Can take either 
    * Tree objects or Tree_Node objects as arguments to merge. This merge
    * simply means the nodes from the second+ argument(s) are added to
    * the first.
    *
    * @param object $tree The Tree/Tree_Node object to merge subsequent
    *                     Tree/Tree_Node objects with.
    * @param ...          Any number of Tree or Tree_Node objects to be merged
    *                     with the first argument.
    * @return object      Resulting merged Tree/Tree_Node object
    */
    function &merge(&$tree)
    {
        $args = func_get_args();
        array_shift($args);

        for ($i=0; $i<count($args); $i++) {
            for ($j=0; $j<count($args[$i]->nodes->nodes); $j++) {
                $tree->nodes->addNode($args[$i]->nodes->nodes[$j]);
            }
        }
        
        return $tree;
    }
}


/**
* A node class to complement the above
* tree class
*/
class Tree_Node
{
    /**
    * The data that this node holds
    * @var mixed
    */
    var $tag;

    /**
    * Parent node
    * @var object
    */
    var $parent;
    
    /**
    * The master Tree object
    * @var object
    */
    var $tree;
    
    /**
    * The nodes collection
    * @var object
    */
    var $nodes;

    /**
    * Constructor
    *
    * @param mixed $tag The data that this node represents
    */
    function Tree_Node($tag = null)
    {
        $this->parent = null;
        $this->nodes  = new Tree_NodeCollection($this);

        if (!is_null($tag)) {
            $this->tag = $tag;
        }
    }
    
    /**
    * Sets the tag data
    *
    * @param mixed $tag The data to set the tag to
    */
    function setTag($tag)
    {
        $this->tag = $tag;
    }
    
    /**
    * Returns the tag data
    *
    * @return mixed The tag data
    */
    function getTag()
    {
        return $this->tag;
    }

    /**
    * Sets the nodes UID
    * 
    * @param integer $uid The UID
    */
    function setUID(&$uid)
    {
        $this->uid = ++$uid;

        // Set uid for child nodes
        for ($i=0; $i<count($this->nodes->nodes); $i++) {
            $this->nodes->nodes[$i]->setUID($uid);
        }
    }

    /**
    * Returns the node UID
    * 
    * @return integer The UID
    */
    function getUID()
    {
        return $this->uid;
    }

    /**
    * Returns the previous child node in the parents node array,
    * or null if this node is the first.
    *
    * @return object A reference to the previous node in the parent
    *                node collection
    */
    function &prevSibling()
    {
        if (!empty($this->parent)) {
            $parentObj = &$this->parent;
        } else {
            $parentObj = &$this->tree;
        }

        $myIndex = $parentObj->nodes->indexOf($this);

        if ($myIndex > 0) {
            return $parentObj->nodes->nodes[$myIndex - 1];
        }

        return null;
    }

    /**
    * Returns the next child node in the parents node array,
    * or null if this node is the last.
    *
    * @return object A reference to the next node in the parent
    *                node collection.
    */
    function &nextSibling()
    {
        if (!empty($this->parent)) {
            $parentObj = &$this->parent;
        } else {
            $parentObj = &$this->tree;
        }

        $myIndex = $parentObj->nodes->indexOf($this);

        if ($myIndex < ($parentObj->nodes->getNodeCount() - 1)) {
            return $parentObj->nodes->nodes[$myIndex + 1];
        }

        return null;
    }
    
    /**
    * Removes this node from its' parent. If this
    * node has no parent (ie its not been added to
    * a Tree or Tree_Node object) then this method
    * will do nothing.
    */
    function remove()
    {
        if (!is_null($this->parent)) {
            $this->parent->nodes->removeNode($this);
        }
    }

    /**
    * Sets the master Tree object for this
    * node.
    *
    * @param object $tree The Tree object reference
    */
    function setTree(&$tree)
    {
        $this->tree = &$tree;

        // Set tree for child nodes
        for ($i=0; $i<count($this->nodes->nodes); $i++) {
            $this->nodes->nodes[$i]->setTree($tree);
        }
    }

    /**
    * Sets the parent node of the node.
    *
    * @param object $node The parent node
    */
    function setParent(&$node)
    {
        $this->parent = &$node;
    }
}

/**
* A class to represent a collection of child nodes
*/
class Tree_NodeCollection
{
    /**
    * An array of child nodes
    * @var array
    */
    var $nodes;
    
    /**
    * The containing node/tree object
    * @var object
    */
    var $container;
    
    /**
    * Whether the container is a tree object or not
    * @var boolean
    */
    var $containerIsTree;
    
    /**
    * Whether the container is a tree node object or not
    * @var boolean
    */
    var $containerIsNode;
	
	/**
    * Temporary holder for the found node used in the
	* search function.
	* @var object
    */
	var $searchFoundNode;

    /**
    * Constructor
    */
    function Tree_NodeCollection(&$container)
    {
        $this->nodes = array();
        $this->container = &$container;
        $this->containerIsTree = (get_class($container) == 'tree');
        $this->containerIsNode = (get_class($container) == 'tree_node');
    }

    /**
    * Adds a node to this node
    *
    * @param  object $node The Tree_Node object
    * @return object       A reference to the new node inside the tree
    */
    function &addNode(&$node)
    {
        // Container is a node
        if ($this->containerIsNode) {
            $node->setParent($this->container);
            
            if (!empty($this->container->tree)) {
                $node->setTree($this->tree);
            }
            
            if (!empty($this->container->uid)) {
                $node->setUID($this->container->tree->uidCounter);
            }

        // Container is a tree
        } else {
            $node->setTree($this->container);
            $node->setUID($this->container->uidCounter);
        }

        $this->nodes[] = &$node;

        return $node;
    }

    /**
    * Returns the first node in this particular collection
    *
    * @return object The first node. NULL if no nodes.
    */
    function &firstNode()
    {
        if (!empty($this->nodes)) {
            return $this->nodes[0];
        }
        
        return null;
    }
    
    /**
    * Returns the last node in this particular collection
    *
    * @return object The last node. NULL if no nodes.
    */
    function &lastNode()
    {
        if (!empty($this->nodes)) {
            return $this->nodes[count($this->nodes) - 1];
        }

        return null;
    }

    /**
    * Removes a node from the child nodes array at the
    * specified (zero based) index.
    *
    * @parm   integer $index The index to remove
    * @return object         The node that was removed, or null
    *                        if this index did not exist
    */
    function &removeNodeAt($index)
    {
        $node = null;
        if (!empty($this->nodes[$index])) {
            $node = &$this->nodes[$index];

            // Unset parent, tree and uid values
            unset($node->uid);
            unset($node->parent);
            unset($node->tree);
            unset($this->nodes[$index]);
            $this->nodes = array_values($this->nodes);
        }

        return $node;
    }
    
    /**
    * Removes a node from the child nodes array by using
    * the unique ID stored in each instance
    *
    * @param  object $node   The node to remove
    * @param  bool   $search Whether to search child nodes
    * @return bool           True/False
    */
    function removeNode(&$node, $search = false)
    {
        for ($i=0; $i<count($this->nodes); $i++) {
            if ($this->nodes[$i]->getUID() == $node->getUID()) {

                // Unset parent, tree and uid values
                unset($node->uid);
                unset($node->parent);
                unset($node->tree);
                unset($this->nodes[$i]);
                $this->nodes = @array_values($this->nodes);
                return true;
            } elseif ($search AND !empty($this->nodes[$i]->nodes)) {
                $searchNodes[] = $i;
            }
        }
        
        if ($search AND !empty($searchNodes)) {
            foreach ($searchNodes as $index) {
                if ($this->nodes[$index]->removeNode($node, true)) {
                    return true;
                }
            }
        }

        return false;
    }
    
    /**
    * Returns the index in the nodes array at which
    * the given node resides. Used in the prev/next Sibling
    * methods.
    *
    * @param  object $node The node to return the index of
    * @return integer      The index of the node or null if
    *                      not found.
    */
    function indexOf($node)
    {
        for ($i=0; $i<count($this->nodes); $i++) {
            if ($this->nodes[$i]->getUID() == $node->getUID()) {
                return $i;
            }
        }
        
        return null;
    }
    
    /**
    * Returns the number of child nodes in this node/tree.
    * Optionally searches the tree and returns the cumulative count.
    *
    * @param  bool    $search Search tree for nodecount too
    * @return integer         The number of nodes found
    */
    function getNodeCount($search = false)
    {
        if ($search) {
            $count = count($this->nodes);
            for ($i=0; $i<count($this->nodes); $i++) {
                $count += $this->nodes[$i]->nodes->getNodeCount(true);
            }
            
            return $count;
        } else {
            return count($this->nodes);
        }
    }
    
    /**
    * Returns a flat list of the node collection. This array will contain
    * copies, and not references to the nodes.
    *
    * @return array Flat list of the nodes from top to bottom, left to right.
    */
    function getFlatList()
    {
        $return = array();

        foreach ($this->nodes as $node) {
            $return[] = $node;
            
            // Recurse
            if (!empty($node->nodes)) {
                $return = array_merge($return, $node->nodes->getFlatList());
            }
        }
        
        return $return;
    }
    
    /**
    * Traverses the node collection applying a function to each and every node.
    * The function name given (though this can be anything you can supply to 
    * call_user_func(), not just a name) should take a single argument which is the
    * node object (Tree_Node class). You can then access the nodes data by using
    * the getTag() method. The traversal goes from top to bottom, left to right
    * (ie same order as what you get from getFlatList()).
    *
    * ** The node is passed by reference to the function! **
    *
    * @param callback $function The callback function to use
    */
    function traverse($function)
    {
        for ($i=0; $i<count($this->nodes); $i++) {
            call_user_func($function, &$this->nodes[$i]);
            
            // Recurse
            if (!empty($this->nodes[$i])) {
                $this->nodes[$i]->nodes->traverse($function);
            }
        }
    }
	
	/**
    * Searches the node collection for a node with a tag matching
	* what you supply. This is a simply "tag == your data" comparison, (=== if strict option is applied)
	* and more advanced comparisons can be made using the traverse() method.
	* This function returns null if nothing is found, and a reference to the
	* first found node if a match is made.
	*
	* @param  mixed $data   Data to try to find and match
	* @param  mixed $strict Whether to use === or simply == to compare
	* @return mixed         Null if no match, a reference to the first found node
	*                       if a match is made.
    */
	function &search($data, $strict = false)
	{
		static $searchData;
		static $comparisonType;

		if (is_object($data) AND strcasecmp(get_class($data), 'Tree_Node') == 0) {
			// Inside traversion
			if (empty($this->searchFoundNode) AND ($comparisonType ? ($data->getTag() === $searchData) : ($data->getTag() == $searchData))) {
				$this->searchFoundNode = &$data;
			}
			return;

		} else {
			// Start traversing
			$searchData     = $data;
			$comparisonType = $strict;

			$this->traverse(array(&$this, 'search'));
		}

		if (!empty($this->searchFoundNode)) {
			$node = &$this->searchFoundNode;
			unset($this->searchFoundNode);
			return $node;
		}

		return null;
	}
}
?>