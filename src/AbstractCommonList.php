<?php

declare(strict_types=1);

namespace Obernard\LinkedList;

use Obernard\LinkedList\Exception\ListException;

/**
 * Defines common properties and methods for all other List classes.
 *
 * @author Olivier Bernard
 */
abstract class AbstractCommonList implements \Iterator, \Countable
{
    // Points to the 'left most' node
    protected ?AbstractNode $head = null;

    // Points to the node returned during iteration
    private ?AbstractNode $current = null;

    // the iterator index position
    private int $index = 0;

    // the number of nodes in the list
    protected int $length = 0;

    // Returns the number of nodes inside the list
    public function length(): int
    {
        return $this->length;
    }

    // Returns true when the list is empty
    public function isEmpty(): bool
    {
        return 0 === $this->length;
    }

    /**
     * Returns the head node (ie the left most node) by default.
     * Returns the N'th next linked node when $offset = N with N >= 1.
     */
    public function head(int $offset = 0): ?AbstractNode
    {
        if (0 === $offset) {
            return $this->head;
        }

        if (1 <= $offset && $this->length - 1 >= $offset) {
            return $this->head->next($offset);
        }

        if ($offset < 0) {
            throw new ListException('Offset is not a positive integer!');
        }

        throw new ListException('Offset is out off range!');
    }

    /**
     * Returns into an array whatever the final class decides to (depends on the current() method implementation).
     */
    public function toArray(): array
    {
        $ar = [];
        foreach ($this as $nodeIterationValue) {
            $ar[] = $nodeIterationValue;
        }

        return $ar;
    }

    // Countable interface implementation
    public function count(): int
    {
        return $this->length;
    }

    /**
     *   foreach Iterator functions implementation
     *   !! key() and current() methods logic is left to the node class !!
     */

    // Rewind the Iterator to the first element
    public function rewind(): void
    {
        $this->index = 0;
        $this->current = $this->head;
    }

    // Move forward to next element
    public function next(): void
    {
        $this->current = $this->current->next();
        ++$this->index;
    }

    // Checks if current position is valid
    public function valid(): bool
    {
        return null !== $this->current;
    }

    /**
     *  !! key() and current() methods logic is left to the node class through its getKey and getValue methods !!
     */

    /**
     * Returns the key associated with a node when the list is iterated.
     * Even if the logic is left to the node final class, the method is kind enough to pass the iterator index to the node.
     */
    public function key(): mixed
    {
        if (!$this->valid()) {
            return null;
        }

        return $this->current->getKey($this->index);
    }

    /**
     * Returns the value associated with a node when the list is iterated.
     * The logic is left to the node final class.
     */
    public function current(): mixed
    {
        return $this->current->getValue();
    }
}
