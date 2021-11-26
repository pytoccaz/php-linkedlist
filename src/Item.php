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
 * Item class defines a concrete item inside a List  
 * 
 *  $this->next is arbitrary considered at the right of the item.
 *  $this->prev is arbitrary considered at the left of the item.
 * 
 * @author Olivier Bernard
*/   
final class Item extends AbstractItem {

    /**
     * @var mixed data stored in a FiloList item.
     * 
     */
    public $data ;  

    public function __construct($data)
    {
        $this->data = $data;
    } 
    

    /**
     * IterableItemInterface getKey method's implementation
     * Returns the iterator index position as key when iterated 
     * @param int $index 
     * 
     */
    public function getKey($index) {
        return $index;
    }

    /**
     * IterableItemInterface getValue method's implementation
     * Returns the data property as value when iterated 
     * @param int $index 
     * 
     */
    public function getValue() {
        return $this->data;
    }

}
