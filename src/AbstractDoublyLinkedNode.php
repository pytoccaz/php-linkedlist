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
 *  AbstractDoublyLinkedNode class defines a node inside a DoublyLinkedList
 *  Inside DoublyLinkedList, a node is linked to a next node and a previous node. 
 * 
 *  - $this->next is arbitrary considered at the right of the node.
 *  - $this->prev is arbitrary considered at the left of the node.
 * 
 *  Final Node class must implement 2 methods (@see IterableNodeInterface):
 *  - getValue that defines the values retuned during list iteration.
 *  - getKey that defines the key returned during list iteration.
 * 
 * Apart those 2 IterableNodeInterface methods, AbstractDoublyLinkedNode 
 * does not impose contraints about concrete Node classes properties.
 * 
 * @author Olivier Bernard
*/   
abstract class AbstractDoublyLinkedNode extends AbstractSinglyLinkedNode  {

 
    protected ?AbstractDoublyLinkedNode $prev = null; 

    
    /**
     * Returns the previous node (the node at $this left). 
     * @return AbstractDoublyLinkedNode|null
     */
    public function prev():?AbstractDoublyLinkedNode {
        return $this->prev;
    }

    /**
     * Sets the previous node.   
     * @return $this
     */
    public function setPrev(?AbstractDoublyLinkedNode $node):self {
        $this->prev = $node;
        return $this;
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
     *  Returns the rank beginning at left (ie at the beginning).
     *  !! Time complexity is O(n) !!
     *  @return int 
     */
    public function lrank():?int {
        if ($this->isFirst()) // if you Node is the most-left node just say 0 
            return 0;
        else {
            // just ask your previous node for its rank and increment 
            $prevNodeRrank=$this->prev->lrank();    
            return ++$prevNodeRrank; 
        }
    }
}
