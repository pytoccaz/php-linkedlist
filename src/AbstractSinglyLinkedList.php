<?php

declare(strict_types=1);

namespace Obernard\LinkedList;

use Obernard\LinkedList\Exception\NodeException;

/**
 * Singly linked-list abstract class.
 *
 * A node in the list is linked to a next node, arbitrary assumed at its right.
 *
 * By definition, the right most node (ie the last node) is not linked to a next node.
 *
 * The link between two nodes is an uni-directional relation.
 *
 * @author Olivier Bernard
 */
abstract class AbstractSinglyLinkedList extends AbstractCommonList
{
    // Pushes a node at the head of the list
    public function pushToHead(AbstractSinglyLinkedNode $node): self
    {
        if ($node->next()) {
            throw new NodeException('Next node is already set !');
        }

        // substitute head node with the new node
        $node->setNext($this->head);
        $this->head = $node;
        ++$this->length; // increment length

        return $this;
    }

    /**
     * Pops head node from the list.
     * The pop-node is detached from its next Node.
     */
    public function popFromHead(): ?AbstractSinglyLinkedNode
    {
        if (0 === $this->length) {
            return null;
        }

        $nodeToPop = $this->head;
        $this->head = $this->head->next();
        --$this->length; // reduce length

        // detach node from its brother next node
        return $nodeToPop->setNext(null);
    }
}
