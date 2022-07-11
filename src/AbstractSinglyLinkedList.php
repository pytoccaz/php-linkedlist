<?php
/*
 * This file is part of the Obernard package.
 *
 * (c) Olivier Bernard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Obernard\LinkedList;

use Obernard\LinkedList\Exception\NodeException;

/**
 * 
 * Singly linked-list abstract class.
 * 
 * A node in the list is linked to a next node, arbitrary assumed at its right.
 *  
 * By definition, the right most node (ie the last node) is not linked to a next node.
 * 
 * The link between two nodes is an unidirectionnal relation:
 * 
 * lpushn() and lpopn() methods makes AbstractSinglyLinkedList similar
 *  to first-in/last-out queue-lists.  
 * 
 * 
 * @author Olivier Bernard
 */

abstract class AbstractSinglyLinkedList extends AbstractCommonList
{

   /**
    * Pushes a node at the head of the list. 
    * @return $this
    */
   public function lpushn(AbstractSinglyLinkedNode $node): self
   {
      if ($node->next())
         throw new NodeException('Next node is already set !');

      // substitute head node with the new node
      $node->setNext($this->head);
      $this->head = $node;

      $this->length += 1; // increment length
      return $this;
   }

   /**
    * Pops head node from the list.
    * The poped node is detached from its next Node.
    * @return AbstractSinglyLinkedNode|null poped node 
    */
   public function lpopn(): ?AbstractSinglyLinkedNode
   {
      if ($this->length == 0)
         return null;
      else {
         $nodeToPop = $this->head;
         $this->head = $this->head->next();
         $this->length -= 1; // deincrement length

         // detach poped node from its brother next node
         return $nodeToPop->setNext(null);
      }
   }
};
