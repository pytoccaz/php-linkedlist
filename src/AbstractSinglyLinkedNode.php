<?php
/*
 * This file is part of the Obernard package.
 *
 * (c) Olivier Bernard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace  Obernard\LinkedList;


/**
 *  AbstractSinglyLinkedNode class defines a node inside a SinglyLinkedList
 *  Inside SinglyLinkedList, a node is linked to a next node only. 
 * 
 *  - $this->next is arbitrary considered at the right of the node.
 * 
 *  Final Node class must implement 2 methods (@see IterableNodeInterface):
 *  - getValue that defines the values retuned during list iteration.
 *  - getKey that defines the key returned during list iteration.
 * 
 * Apart those 2 IterableNodeInterface methods, AbstractDoublyLinkedNode does not 
 * impose contraints about concrete Node classes properties.
 *   
 * @author Olivier Bernard
*/   
abstract class AbstractSinglyLinkedNode extends AbstractNode {
 

}
