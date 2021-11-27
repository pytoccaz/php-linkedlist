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
 *  AbstractSinglyLinkedNode class defines a node inside a SinglyLinkedList or a DoublyLinkedList
 *  Inside SinglyLinkedList, a node is linked to a next node only. 
 * 
 *  - $this->next is arbitrary considered at the right of the node.
 * 
 *  Final Node class must implement 2 methods:
 *  - getValue that defines the values retuned during list iteration.
 *  - getKey that defines the key returned during list iteration.
 * 
 * AbstractSinglyLinkedNode makes no assumption about data associated with final Node classes.
 * 
 * @author Olivier Bernard
*/   
abstract class AbstractSinglyLinkedNode implements IterableNodeInterface {

 
    private ?AbstractSinglyLinkedNode $next = null; 

    
    /**
     * Returns the following node (the node at $this right).
     * @return AbstractSinglyLinkedNode|null
     */
    public function next():?AbstractSinglyLinkedNode {
        return $this->next;
    }

    /**
     * Sets the next node. 
     * @return AbstractSinglyLinkedNode
     */
    public function setNext(?AbstractSinglyLinkedNode $node):self {
        $this->next = $node;
        return $this;
    }


    /**
     * Is the node last inside a singly-linked List ?
     * @return bool
     */
    public function isLast():bool {
        return $this->next === null;
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

}
