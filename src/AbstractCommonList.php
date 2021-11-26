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

use Obernard\LinkedList\Exception\LinkItemException;

/**
 * 
 * Defines common properties and methods for all other List classes.
 * 
 * @author Olivier Bernard
 */   

abstract class AbstractCommonList implements \Iterator {


    /**
     * Points to the "left most" item
     * @var AbstractItem|null
     */
    protected $head = null; 

    /**
     * Points to the item returned during iteration.
     * @var AbstractItem|null
     */
    private $current = null; // points to the item returned during iteration
    
    /**
     * @var int the iterator index position.
     */
    private $index = 0; 


    /**
     * @var int the number of items in the list
     */
    protected $length = 0;

    /**
     * Returns the number of items inside the list.
     * @return int 
     */
    public function length():int {
        return $this->length;
    }

    /**
     * Returns true when the list is empty.
     * @return bool 
     */
    public function isEmpty():bool {
        return $this->length === 0;
    }

    /**
     * Returns the the head item (ie the left most item)
     * Mainly used for internal logic.
     * @return AbstractItem|null
     */
    public function ihead():?AbstractItem 
    {
        return $this->head;
    }

    /**
     * Returns into an array whatever the final class decides to (depends on the current() method implementation).  
     * @return array[mixed]
     */ 
    public function toArray():array 
    {
        $ar = [];
        foreach ($this as $item) {
            $ar[] = $item;
        }
        return $ar;
    }


    /**
    *   foreach Iterator functions implementation
    *   !! Be carefull: key() and current() methods'logic is left to the item class !!  
    */

    public function rewind() {
        $this->index = 0;
        $this->current = $this->head;
    }

    public function next() {
         $this->current = $this->current->next();
         $this->index++;
    }

    public function valid():bool {
        return $this->current !=null ;
    }

    /**
    *  !! Be carefull: key() and current() methods'logic is left to the item class
    *     through its getKey and getValue methods !!
    *   
    */

    /**
     * Returns the key associated with an item when the list is iterated.
     * Even if the logic is left to the item final class, the method is kind 
     *  enough to pass the iterator index to the item. 
     * @param int index position of the iterator.
     * @return mixed key associated with the iterated item.
     */
    public function key() {
         if (!$this->valid())
            return null;

         return  $this->current->getKey($this->index); 
    }

    /**
     * Returns the value associated with an item when the list is iterated.
     * The logic is left to the item final class.
     * @return mixed value associated with the iterated item.
     */  
    public function current() {
        return $this->current->getValue() ;
    }
};