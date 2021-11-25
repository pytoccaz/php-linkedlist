<?php
/*
 * This file is part of the Obernard package.
 *
 * (c) Olivier Bernard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace  Obernard\LinkedList;


/**
 *  IterableItemInterface forces an item to implement current and key methods. 
 *  - getValue method returns the item's associated value when it's owning list is iterated.
 *  - getKey method returns the item's associated key when it's owning list is iterated.
 *  
 * @author Olivier Bernard
*/   
interface IterableItemInterface {

    /**
     * Returns the item's associated value when it's owning list is iterated.  
     * @return mixed
     */
    public function getValue() ; 


    /**
     * Returns the item's associated key when it's owning list is iterated.   
     * @return mixed
     */    
    public function getKey($index);
 
}
