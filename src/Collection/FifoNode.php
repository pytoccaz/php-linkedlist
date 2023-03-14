<?php

declare(strict_types=1);

namespace Obernard\LinkedList\Collection;

use Obernard\LinkedList\AbstractDoublyLinkedNode;

/**
 * Node class defines a concrete node inside a List.
 *
 *  $this->next is arbitrary considered at the right of the node.
 *  $this->prev is arbitrary considered at the left of the node.
 *
 * @author Olivier Bernard
 */
class FifoNode extends AbstractDoublyLinkedNode
{
    // data stored in a FifoList node.
    public mixed $data;

    public function __construct(mixed $data)
    {
        $this->data = $data;
    }

    /**
     * IterableNodeInterface getValue method's implementation.
     * Returns the data property as value when iterated.
     */
    public function getValue(): mixed
    {
        return $this->data;
    }
}
