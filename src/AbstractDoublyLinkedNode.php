<?php

declare(strict_types=1);

namespace Obernard\LinkedList;

use Obernard\LinkedList\Exception\NodeException;

/**
 *  AbstractDoublyLinkedNode class defines a node inside a DoublyLinkedList.
 *  Inside DoublyLinkedList, a node is linked to a next node and a previous node.
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
abstract class AbstractDoublyLinkedNode extends AbstractSinglyLinkedNode
{
    protected ?AbstractDoublyLinkedNode $prev = null;

    /**
     * Returns the previous node (the node at $this left) by default.
     * Returns the N'th previous linked node when $offset = N with N > 1.
     */
    public function prev(int $offset = 1): ?self
    {
        if (1 === $offset) {
            return $this->prev;
        }

        if (0 === $offset) {
            return $this;
        }

        if (0 > $offset) {
            throw new NodeException('Offset cannot be lower than 0!');
        }

        if ($this->isFirst()) {
            throw new NodeException('Offset out of range!');
        }

        return $this->prev->prev(--$offset);
    }

    /**
     * Sets the previous node.
     */
    public function setPrev(?self $node): self
    {
        $this->prev = $node;

        return $this;
    }

    /**
     * Is the node first inside a a List ?
     */
    public function isFirst(): bool
    {
        return null === $this->prev;
    }

    /**
     * Is the node alone inside a a List ?
     */
    public function isAlone(): bool
    {
        return $this->isFirst() && $this->isLast();
    }

    /**
     *  Returns the rank beginning at head.
     *  !! Time complexity is O(n) !!
     */
    public function distanceToFirstNode(): int
    {
        if ($this->isFirst()) {
            return 0;
        }

        // just ask your previous node for its rank and increment
        $prevNodeRrank = $this->prev->distanceToFirstNode();

        return ++$prevNodeRrank;
    }
}
