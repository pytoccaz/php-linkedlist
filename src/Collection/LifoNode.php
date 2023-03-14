<?php

declare(strict_types=1);

namespace Obernard\LinkedList\Collection;

use Obernard\LinkedList\AbstractSinglyLinkedNode;

/**
 * Node class defines a concrete node inside a List.
 *
 *  $this->next is arbitrary considered at the right of the node.
 *  $this->prev is arbitrary considered at the left of the node.
 *
 * @author Olivier Bernard
 */
class LifoNode extends AbstractSinglyLinkedNode
{
    // data stored in a LifoList node.
    public mixed $data;

    public function __construct($data)
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
