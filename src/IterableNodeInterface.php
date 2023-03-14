<?php

declare(strict_types=1);

namespace Obernard\LinkedList;

/**
 *  IterableNodeInterface forces a node to finalize the implementation of current and key LinkedList methods.
 *  - getValue method returns the node's associated value when it's owning list is iterated.
 *    It is called by the key() list iterator method.
 *  - getKey method returns the node's associated key when it's owning list is iterated.
 *    It is called by the current() list iterator method.
 *
 * @author Olivier Bernard
 */
interface IterableNodeInterface
{
    /**
     * Returns the node's associated value when it's owning $list is iterated.
     * It is called by $list->current().
     */
    public function getValue(): mixed;

    /**
     * Returns the node's associated key when it's owning $list is iterated.
     * It is called by $list->key().
     */
    public function getKey($index): mixed;
}
