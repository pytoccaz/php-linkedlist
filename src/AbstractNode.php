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
 *  AbstractNode class defines a node inside a SinglyLinkedList or a DoublyLinkedList
 *  Inside DoublyLinkedList, a node is linked to a next node and a previous node. 
 *  Inside SinglyLinkedList, a node is linked to a next node only. 
 * 
 *  - $this->next is arbitrary considered at the right of the node.
 *  - $this->prev is arbitrary considered at the left of the node.
 * 
 *  Final Node class must implement 2 methods:
 *  - getValue that defines the values retuned during list iteration.
 *  - getKey that defines the key returned during list iteration.
 * 
 * AbstractNode makes no assumption about data associated with final Node classes.
 * 
 * @author Olivier Bernard
*/   
abstract class AbstractNode implements IterableNodeInterface {

 
    private ?AbstractNode $next = null; 
    private ?AbstractNode $prev = null; 

    
    /**
     * Returns the following node (the node at $this right).
     * @return AbstractNode|null
     */
    public function next():?AbstractNode {
        return $this->next;
    }

    /**
     * Returns the previous node (the node at $this left). 
     * @return AbstractNode|null
     */
    public function prev():?AbstractNode {
        return $this->prev;
    }

    /**
     * Sets the previous node.   
     * @return $this
     */
    public function setPrev(?AbstractNode $node):self {
        $this->prev = $node;
        return $this;
    }

    /**
     * Sets the next node. 
     * @return AbstractNode
     */
    public function setNext(?AbstractNode $node):self {
        $this->next = $node;
        return $this;
    }


    /**
     * Is the node last inside a List ?
     * @return bool
     */
    public function isLast():bool {
        return $this->next === null;
    }

    /**
     * Is the node first inside a a List ?
     * @return bool
     */
    public function isFirst():bool {
        return $this->prev === null;
    }

    /**
     * Is the node alone inside a a List ?
     * @return bool
     */
    public function isAlone():bool {
        return $this->isFirst() &&  $this->isLast();
    }
    /**
     *  Returns the node's rank beginning at right (ie at the end).
     *  @return int 
     */
    public function rrank():int {
        if ($this->isLast()) // the first entered node has rank 0
            return 0;
        else {
            // ask for your brother at left and increment its rank
            $nextNodeRrank=$this->next->rrank();    
            return ++$nextNodeRrank; 
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
            $prevNodeRrank=$this->prev->lrank();    
            return ++$prevNodeRrank; 
        }
    }
}
