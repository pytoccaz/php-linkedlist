<?php

namespace  Obernard\LinkedList;

use Obernard\LinkedList\Exception\LinkItemException;

/**
 * 
 * First in Last out linked-list abstract class.
 * 
 * An item in the list is linked to a next item, arbitrary assumed at its right.
 *  
 * By definition, the right most item (ie the last item) is not linked to a next item.
 * 
 * The link between two items is an unidirectionnal relation:
 *   Whatever the $item index is inside the list, $item->prev() === null.    
 * 
 * @author Olivier Bernard
 */   

abstract class AbstractSimpleLinkedList implements \Iterator {


    /**
     * Points to the "left most" item
     * @var AbstractItem|null
     */
    private $head = null; 

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
    private $length = 0;

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
     * Returns the value of the head item (ie the left most item)
     * Mainly used for internal logic.
     * @return AbstractItem|null
     */
    public function head():?AbstractItem 
    {
        return $this->head;
    }

    /**
     * Returns the value associated with the head item (ie the left most item)
     * @return mixed|null
     */
    public function get()
    {
        return $this->head->getValue();
    }


    /**
     * Pushes an item at the left of list. 
     * @return $this
     */
    public function lpush(AbstractItem $item):self {
        if ($item->next())
            throw new LinkItemException('Next item is already set !');

        $item->setNext($this->head);
        $this->head = $item;
        $this->length+=1; // increment length
        return $this;
    }

    /**
     * Pops head item from the list.
     * The poped item is detached from its next Item.
     * @return mixed|null poped item associated value  
     */
    public function lpop()  
    {
         if ($this->length == 0)
            return null;
         else {
            $itemToPop = $this->head;
            $this->head = $this->head->next();
            $this->length-=1; // deincrement length
 
            // detach poped item from its brother next item
            return $itemToPop->setNext(null)->getValue();
         }
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