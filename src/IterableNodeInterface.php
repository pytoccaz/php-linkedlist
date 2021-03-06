<?php
/*
 * This file is part of the Obernard package.
 *
 * (c) Olivier Bernard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Obernard\LinkedList;


/**
 *  IterableNodeInterface forces a node to finalize the implemention of current and key LinkedList methods. 
 *  - getValue method returns the node's associated value when it's owning list is iterated.
 *    It is notably called by the key() list iterator method. 
 *  - getKey method returns the node's associated key when it's owning list is iterated.
 *    It is notably called by the current() list iterator method. 
 *  
 * @author Olivier Bernard
*/   
interface IterableNodeInterface {

    /**
     * Returns the node's associated value when it's owning $list is iterated.  
     * It is called by $list->current(). 
     * @return mixed
     */
    public function getValue() ; 


    /**
     * Returns the node's associated key when it's owning $list is iterated.   
     * It is called by $list->key(). 
     * @return mixed
     */    
    public function getKey($index);
 
}
