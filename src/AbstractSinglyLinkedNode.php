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
 *  Final Node classes must implement 2 methods:
 *  - getValue that defines the values retuned during list iteration.
 *  - getKey that defines the key returned during list iteration.
 * 
 * AbstractSinglyLinkedNode makes no assumption about data associated with final Node classes.
 * 
 * @author Olivier Bernard
*/   
abstract class AbstractSinglyLinkedNode extends AbstractNode {
 

}
