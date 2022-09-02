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

use Obernard\LinkedList\Exception\ListException;

/**
 * 
 * Doubly-linked list abstract class.
 * 
 * A node in the list is linked to a next node, arbitrary assumed at its right;
 *  and to a previous node at its left.
 *  
 * By definition, the right most node (ie the last node) is not linked to a next node;
 *  and the left most node is not linked to a previous node.
 * 
 * @author Olivier Bernard
 */

abstract class AbstractDoublyLinkedList extends AbstractCommonList
{

    /**
     * Points to the "right most" node
     * @var AbstractDoublyLinkedNode|null
     */
    protected $tail = null;

    /**
     * Returns the tail node (ie the right most node) by default
     * Returns the N'th previous linked node when $offset = N with N >= 1.
     * @param int $offset 
     * @return AbstractDoublyLinkedNode|null
     * 
     */
    public function tail($offset = 0): ?AbstractDoublyLinkedNode
    {
        if ($offset === 0)
            return $this->tail;

        if ($offset >= 1 and $offset <= $this->length)
            return $this->tail->prev($offset);

        if ($offset < 0)
            throw (new ListException("Offset is not a positive integer!"));

        if ($offset > 0)
            throw (new ListException("Offset is out off range!"));
    }
    /**
     * Pushes a node at the left of the list. 
     * @return $this
     */
    public function pushToHead(AbstractDoublyLinkedNode $node): self
    {
        if ($node->next())
            throw new ListException('The node is already linked to a next node !');

        if ($node->prev())
            throw new ListException('The node is already linked to a previous node !');

        /**
         * substitute head node with the new node
         * 
         */

        // if there are nodes in the list
        if (!$this->isEmpty())
            // the pushed node is linked to head node as a previous node
            $node->setNext($this->head->setPrev($node));
        else
            // the first pushed node is linked to the tail 
            $this->tail = $node;

        // the node takes the head position    
        $this->head = $node;

        $this->length += 1; // increment length

        return $this;
    }

    /**
     * Pops head node from the list.
     * The poped node is detached from its next Node.
     * @return AbstractDoublyLinkedNode|null poped node 
     */
    public function popFromHead(): ?AbstractDoublyLinkedNode
    {

        // if the list is empty just returns null 
        if ($this->isEmpty())
            return null;

        // the node to pop is at head position 
        $nodeToPop = $this->head;

        // if the node to pop is alone...
        if ($nodeToPop->isAlone()) {

            $this->tail = null;
            $this->head = null;
        } else {
            // the next node of the node to pop is detached from it's previous node (ie node to pop) 
            //  and takes the head. 
            $this->head = $nodeToPop->next()->setPrev(null);
        }

        $this->length -= 1; // deincrement length

        // detach poped node from its next brother node
        return $nodeToPop->setNext(null);
    }

    /**
     * Pushes a node at the tail of the list. 
     * @return $this
     */
    public function pushToTail(AbstractDoublyLinkedNode $node): self
    {
        if ($node->next())
            throw new ListException('The node is already linked to a next node !');

        if ($node->prev())
            throw new ListException('The node is already linked to a previous node !');

        /**
         * substitute tail node with the new node
         * 
         */

        // if there are nodes in the list
        if (!$this->isEmpty())
            // the pushed node is linked to tail node as a next node
            $node->setPrev($this->tail->setNext($node));
        else
            // the first pushed node is linked to the head 
            $this->head = $node;

        // the node takes the tail position    
        $this->tail = $node;

        $this->length += 1; // increment length

        return $this;
    }

    /**
     * Pops tail node from the list.
     * The poped node is detached from its previous Node.
     * @return AbstractDoublyLinkedNode|null poped node 
     */
    public function popFromTail(): ?AbstractDoublyLinkedNode
    {

        // if the list is empty just returns null 
        if ($this->isEmpty())
            return null;

        // the node to pop is at tail position 
        $nodeToPop = $this->tail;

        // if the node to pop is alone...
        if ($nodeToPop->isAlone()) {

            $this->tail = null;
            $this->head = null;
        } else {
            // the previous node of the node to pop is detached from it's next node (ie node to pop) 
            //  and takes the tail. 
            $this->tail = $nodeToPop->prev()->setNext(null);
        }

        $this->length -= 1; // reduce length

        // detach poped node from its previous brother node
        return $nodeToPop->setPrev(null);
    }
};
