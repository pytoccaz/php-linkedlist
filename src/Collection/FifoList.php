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
use  Obernard\LinkedList\AbstractDoublyLinkedList;
/**
 * 
 * First-in/first-out doubly-linked list implementation.
 *  
 * 
 * @author Olivier Bernard
 */   

final class FiFoList extends AbstractDoublyLinkedList {

    /**
     * Pushes data at the head of the stack. 
     * @return $this
     */
    public function add($data):self {
        $this->lpushn(new FifoNode($data));
        return $this;
    }

    /**
     * Pops tail data content from the stack.
     * @return mixed
     */
    public function pop() 
    {
         return $this->rpopn()->getValue();
    }

};