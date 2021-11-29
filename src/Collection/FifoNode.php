<?php
/*
 * This file is part of the Obernard package.
 *
 * (c) Olivier Bernard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace  Obernard\LinkedList\Collection;

use  Obernard\LinkedList\AbstractDoublyLinkedNode;
/**
 * Node class defines a concrete node inside a List  
 * 
 *  $this->next is arbitrary considered at the right of the node.
 *  $this->prev is arbitrary considered at the left of the node.
 * 
 * @author Olivier Bernard
*/   
class FifoNode extends AbstractDoublyLinkedNode {

    /**
     * @var mixed data stored in a FiloList node.
     * 
     */
    public $data ;  

    public function __construct($data)
    {
        $this->data = $data;
    } 
    

    /**
     * IterableNodeInterface getKey method's implementation
     * Returns the iterator index position as key when iterated 
     * @param int $index 
     * 
     */
    public function getKey($index) {
        return $index;
    }

    /**
     * IterableNodeInterface getValue method's implementation
     * Returns the data property as value when iterated 
     * @param int $index 
     * 
     */
    public function getValue() {
        return $this->data;
    }

}