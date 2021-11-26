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
 * 
 * First-in/first-out doubled-linked list implementation.
 *  
 * 
 * @author Olivier Bernard
 */   

final class FiFoList extends AbstractDoubledLinkedList {

    /**
     * Pushes data at the head of the stack. 
     * @return $this
     */
    public function add($data):self {
        $this->ilpush(new Item($data));
        return $this;
    }

    /**
     * Pops tail data content from the stack.
     * @return mixed
     */
    public function pop() 
    {
         return $this->irpop()->getValue();
    }

};