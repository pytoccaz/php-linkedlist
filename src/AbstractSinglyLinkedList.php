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
 * Singly linked-list abstract class.
 * 
 * An item in the list is linked to a next item, arbitrary assumed at its right.
 *  
 * By definition, the right most item (ie the last item) is not linked to a next item.
 * 
 * The link between two items is an unidirectionnal relation:
 *   Whatever the $item index is inside the list, $item->prev() === null.    
 * 
 * ipush() and ipop() methods makes AbstractSinglyLinkedList very similar
 *  to first-in/last-out queue-list.  
 * 
 * 
 * @author Olivier Bernard
 */   

abstract class AbstractSinglyLinkedList extends AbstractCommonList  {
  
    /**
     * Pushes an item at the head of the list. 
     * @return $this
     */
    public function ipush(AbstractItem $item):self {
        if ($item->next())
            throw new LinkItemException('Next item is already set !');

         // substitute head item with the new item
        $item->setNext($this->head);
        $this->head = $item;

        $this->length+=1; // increment length
        return $this;
    }

    /**
     * Pops head item from the list.
     * The poped item is detached from its next Item.
     * @return AbstractItem|null poped item 
     */
    public function ipop():?AbstractItem  
    {
         if ($this->length == 0)
            return null;
         else {
            $itemToPop = $this->head;
            $this->head = $this->head->next();
            $this->length-=1; // deincrement length
 
            // detach poped item from its brother next item
            return $itemToPop->setNext(null);
         }
    }
   
};