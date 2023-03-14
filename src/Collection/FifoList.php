<?php

declare(strict_types=1);

namespace Obernard\LinkedList\Collection;

use Obernard\LinkedList\AbstractDoublyLinkedList;

/**
 * First-in/first-out doubly-linked list implementation.
 *
 * @author Olivier Bernard
 */
final class FifoList extends AbstractDoublyLinkedList
{
    /**
     * Pushes data at the head of the stack.
     */
    public function push($data): self
    {
        $this->pushToTail(new FifoNode($data));

        return $this;
    }

    /**
     * Pops tail data content from the stack.
     */
    public function pop(): mixed
    {
        return $this->popFromTail()->getValue();
    }
}
