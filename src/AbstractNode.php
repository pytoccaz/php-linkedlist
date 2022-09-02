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

use Obernard\LinkedList\Exception\NodeException;

/**
 * AbstractNode is the top class of SinglyLinkedListNode and by this way of DoublyLinkedListNode
 * Inside SinglyLinkedList, a node is linked to a next node only. 
 * 
 * - $this->next is arbitrary considered at the right of the node.
 * 
 * Final Node class must implement 2 methods:
 * - getValue that defines the values retuned during list iteration.
 * - getKey that defines the key returned during list iteration.
 * 
 * Apart those 2 IterableNodeInterface methods, AbstractNode and all abstract node classes 
 * do not impose contraints about concrete Node classes properties.
 * 
 * @author Olivier Bernard
 */
abstract class AbstractNode implements IterableNodeInterface
{


    protected ?AbstractNode $next = null;


    /**
     * Returns the following node (the node at $this right) by default.
     * Returns the N'th next linked node when $offset = N with N > 1.
     * @param int $offset (optional): N'th node (beginning to $this) 
     * @return AbstractNode|null
     */
    public function next(int $offset = 1): ?AbstractNode
    {

        if ($offset === 1)
            return $this->next;

        if ($offset === 0)
            return $this;


        if ($offset < 1)
            throw (new NodeException("Offset cannot be lower than 0!"));

        if ($this->islast())
            throw (new NodeException("Offset out of range!"));

        return $this->next->next(--$offset);
    }

    /**
     * Sets the next node. 
     * @return AbstractNode
     */
    public function setNext(?AbstractNode $node): self
    {
        $this->next = $node;
        return $this;
    }


    /**
     * Is the node last inside a singly-linked List ?
     * @return bool
     */
    public function isLast(): bool
    {
        return $this->next === null;
    }

    /**
     *  Returns the node's rank beginning at the tail (ie at the end).
     *  !! Time complexity is O(n) !!
     *  @return int 
     */
    public function distanceToLastNode(): int
    {
        if ($this->isLast()) // if you Node are the most-right node just say 0
            return 0;
        else {
            // just ask your next node for its rank and increment 
            $nextNodeRrank = $this->next->distanceToLastNode();
            return ++$nextNodeRrank;
        }
    }


    /**
     * IterableNodeInterface getKey method's implementation
     * Returns the iterator index position as key when iterated 
     * @param int $index 
     * @return int $index
     */
    public function getKey($index): mixed
    {
        return $index;
    }


    /**
     * IterableNodeInterface getValue method's implementation
     * Returns the Node itself 
     * @return mixed $this
     */
    public function getValue(): mixed
    {
        return $this;
    }
}
