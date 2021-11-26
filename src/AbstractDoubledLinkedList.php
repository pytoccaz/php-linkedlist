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
 * Doubled-linked list abstract class.
 * 
 * An item in the list is linked to a next item, arbitrary assumed at its right;
 *  and to a previous item at its left.
 *  
 * By definition, the right most item (ie the last item) is not linked to a next item;
 *  and the left most item is not linked to a previous item.
 * 
 * @author Olivier Bernard
 */   

abstract class AbstractDoubledLinkedList extends AbstractCommonList  {
  
    /**
     * Points to the "right most" item
     * @var AbstractItem|null
     */
    protected $tail = null; 

    /**
     * Returns the the tail item (ie the right most item)
     * Mainly used for internal logic.
     * @return AbstractItem|null
     */
    public function itail():?AbstractItem 
    {
        return $this->tail;
    }


     /**
     * Pushes an item at the left of the list. 
     * @return $this
     */
    public function ilpush(AbstractItem $item):self {
        if ($item->next())
            throw new LinkItemException('Next item is already set !');
        
        if ($item->prev())
            throw new LinkItemException('Previous item is already set !');

        /**
         * substitute head item with the new item
         * 
         */

        // if there are items in the list
        if (!$this->isEmpty())
            // the pushed item is linked to head item as a previous item
            $item->setNext($this->head->setPrev($item));  
        else 
            // the first pushed item is linked to the tail 
            $this->tail = $item; 

            // the item takes the head position    
        $this->head = $item; 

        $this->length+=1; // increment length
    
        return $this;
    }

    /**
     * Pops head item from the list.
     * The poped item is detached from its next Item.
     * @return AbstractItem|null poped item 
     */
    public function ilpop():?AbstractItem 
    {

        // if the list is empty just returns null 
        if ($this->isEmpty())
            return null;

        // the item to pop is at head position 
        $itemToPop = $this->head;
        
        // if the item to pop is alone...
        if ($itemToPop->isAlone()) {

            $this->tail = null;
            $this->head = null;

        }
        else {
            // the next item of the item to pop is detached from it's previous item (ie item to pop) 
            //  and takes the head. 
            $this->head = $itemToPop->next()->setPrev(null);  
        }

        $this->length-=1; // deincrement length
 
            // detach poped item from its next brother item
        return $itemToPop->setNext(null);

    }

     /**
     * Pushes an item at the right of the list. 
     * @return $this
     */
    public function irpush(AbstractItem $item):self {
        if ($item->next())
            throw new LinkItemException('Next item is already set !');
        
        if ($item->prev())
            throw new LinkItemException('Previous item is already set !');

        /**
         * substitute tail item with the new item
         * 
         */

        // if there are items in the list
        if (!$this->isEmpty())
            // the pushed item is linked to tail item as a next item
            $item->setPrev($this->tail->setNext($item));  
        else 
            // the first pushed item is linked to the head 
            $this->head = $item; 

        // the item takes the tail position    
        $this->tail = $item; 

        $this->length+=1; // increment length
    
        return $this;
    }
  
    /**
     * Pops tail item from the list.
     * The poped item is detached from its previous Item.
     * @return AbstractItem|null poped item 
     */
    public function irpop():?AbstractItem 
    {

        // if the list is empty just returns null 
        if ($this->isEmpty())
            return null;

        // the item to pop is at tail position 
        $itemToPop = $this->tail;
        
        // if the item to pop is alone...
        if ($itemToPop->isAlone()) {

            $this->tail = null;
            $this->head = null;

        }
        else {
            // the previous item of the item to pop is detached from it's next item (ie item to pop) 
            //  and takes the tail. 
            $this->tail = $itemToPop->prev()->setNext(null);  
        }

        $this->length-=1; // deincrement length
 
            // detach poped item from its previous brother item
        return $itemToPop->setPrev(null);

    }



};