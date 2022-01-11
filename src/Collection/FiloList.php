<?php
/*
 * This file is part of the Obernard package.
 *
 * (c) Olivier Bernard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Obernard\LinkedList\Collection;
use  Obernard\LinkedList\AbstractSinglyLinkedList;
/**
 * 
 * First-in/last-out singly-linked list implementation.
 *  
 * 
 * @author Olivier Bernard
 */   

final class FiloList extends AbstractSinglyLinkedList {

    /**
     * Pushes data at the head of the stack. 
     * @return $this
     */
    public function add($data):self {
        $this->lpushn(new FiloNode($data));
        return $this;
    }

    /**
     * Pops head data content from the stack.
     * @return mixed the head node's data property 
     */
    public function pop():mixed 
    {
         return $this->lpopn()->getValue();
    }

};