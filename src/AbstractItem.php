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
 *  AbstractItem class defines an item inside a SinglyLinkedList or a DoubledLinkedList
 *  Inside DoubledLinkedList, an item is linked to a next item and a previous item. 
 *  Inside SinglyLinkedList, an item is linked to a next item only. 
 * 
 *  - $this->next is arbitrary considered at the right of the item.
 *  - $this->prev is arbitrary considered at the left of the item.
 * 
 *  Final Item class must implement 2 methods:
 *  - getValue that defines the values retuned during list iteration.
 *  - getKey that defines the key returned during list iteration.
 * 
 * AbstractItem makes no assumption about data associated with final Item classes.
 * 
 * @author Olivier Bernard
*/   
abstract class AbstractItem implements IterableItemInterface {

 
    private ?AbstractItem $next = null; 
    private ?AbstractItem $prev = null; 

    
    /**
     * Returns the following item (the item at $this right).
     * @return AbstractItem|null
     */
    public function next():?AbstractItem {
        return $this->next;
    }

    /**
     * Returns the previous item (the item at $this left). 
     * @return AbstractItem|null
     */
    public function prev():?AbstractItem {
        return $this->prev;
    }

    /**
     * Sets the previous item.   
     * @return $this
     */
    public function setPrev(?AbstractItem $item):self {
        $this->prev = $item;
        return $this;
    }

    /**
     * Sets the next item. 
     * @return AbstractItem
     */
    public function setNext(?AbstractItem $item):self {
        $this->next = $item;
        return $this;
    }


    /**
     * Is the item last inside a List ?
     * @return bool
     */
    public function isLast():bool {
        return $this->next === null;
    }

    /**
     * Is the item first inside a a List ?
     * @return bool
     */
    public function isFirst():bool {
        return $this->prev === null;
    }

    /**
     * Is the item alone inside a a List ?
     * @return bool
     */
    public function isAlone():bool {
        return $this->isFirst() &&  $this->isLast();
    }
    /**
     *  Returns the item's rank beginning at right (ie at the end).
     *  @return int 
     */
    public function rrank():int {
        if ($this->isLast()) // the first entered item has rank 0
            return 0;
        else {
            // ask for your brother at left and increment its rank
            $nextItemRrank=$this->next->rrank();    
            return ++$nextItemRrank; 
        }
    }

    /**
     *  Returns the rank beginning at left (ie at the beginning).
     *  @return int 
     */
    public function lrank():?int {
        if ($this->isFirst())  
            return 0;
        else {
            // ask for your brother at right and increment its rank.
            $prevItemRrank=$this->prev->lrank();    
            return ++$prevItemRrank; 
        }
    }
}
