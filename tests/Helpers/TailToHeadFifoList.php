<?php

declare(strict_types=1);

namespace Obernard\LinkedList\Tests\Helpers;

use Obernard\LinkedList\AbstractDoublyLinkedList;
use Obernard\LinkedList\Collection\FifoNode;

/**
 * First-in/first-out doubly-linked list implementation.
 *
 * The entry point is the tail and the exit is the head.
 *
 * @author Olivier Bernard
 */
final class TailToHeadFifoList extends AbstractDoublyLinkedList
{
    /**
     * Pushes data at the tail of the list.
     */
    public function add($data): self
    {
        $this->pushToTail(new FifoNode($data));

        return $this;
    }

    /**
     * Pops head data content from the list.
     */
    public function pop(): mixed
    {
        return $this->popFromHead()->getValue();
    }
}
