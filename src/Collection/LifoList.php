<?php

declare(strict_types=1);

namespace Obernard\LinkedList\Collection;

use Obernard\LinkedList\AbstractSinglyLinkedList;

/**
 * Last-in/first-out singly-linked list implementation.
 *
 * @author Olivier Bernard
 */
final class LifoList extends AbstractSinglyLinkedList
{
    /**
     * Pushes data at the head of the stack.
     */
    public function push($data): self
    {
        $this->pushToHead(new LifoNode($data));

        return $this;
    }

    /**
     * Pops head data content from the stack.
     */
    public function pop(): mixed
    {
        return $this->popFromHead()->getValue();
    }
}
