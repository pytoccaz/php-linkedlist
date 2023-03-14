<?php

declare(strict_types=1);

namespace Obernard\LinkedList;

use Obernard\LinkedList\Exception\NodeException;

/**
 * AbstractNode is the top class of SinglyLinkedListNode and by this way of DoublyLinkedListNode.
 * Inside SinglyLinkedList, a node is linked to a next node only.
 *
 * - $this->next is arbitrary considered at the right of the node.
 *
 * Final Node class may re-define the 2 IterableNodeInterface methods:
 * - getValue that defines the values retuned during list iteration.
 * - getKey that defines the key returned during list iteration.
 *
 * @author Olivier Bernard
 */
abstract class AbstractNode implements IterableNodeInterface
{
    protected ?AbstractNode $next = null;

    /**
     * Returns the following node (the node at $this right) by default.
     * Returns the N'th next linked node when $offset = N with N > 1.
     */
    public function next(int $offset = 1): ?self
    {
        if (1 === $offset) {
            return $this->next;
        }

        if (0 === $offset) {
            return $this;
        }

        if (0 > $offset) {
            throw new NodeException('Offset cannot be lower than 0!');
        }

        if ($this->islast()) {
            throw new NodeException('Offset out of range!');
        }

        return $this->next->next(--$offset);
    }

    /**
     * Sets the next node.
     */
    public function setNext(?self $node): self
    {
        $this->next = $node;

        return $this;
    }

    /**
     * Is the node last inside a singly-linked List ?
     */
    public function isLast(): bool
    {
        return null === $this->next;
    }

    /**
     *  Returns the node's rank beginning at the tail (ie at the end).
     *  !! Time complexity is O(n) !!
     */
    public function distanceToLastNode(): int
    {
        if ($this->isLast()) {
            return 0;
        }

        // just ask your next node for its rank and increment
        $nextNodeRrank = $this->next->distanceToLastNode();

        return ++$nextNodeRrank;
    }

    /**
     * IterableNodeInterface getKey method's implementation.
     * Returns the iterator index position as key when iterated.
     */
    public function getKey($index): mixed
    {
        return $index;
    }

    /**
     * IterableNodeInterface getValue method's implementation.
     * Returns the Node itself.
     */
    public function getValue(): mixed
    {
        return $this;
    }
}
