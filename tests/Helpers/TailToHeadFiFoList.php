<?php


/*
 * This file is part of the Obernard package.
 *
 * (c) Olivier Bernard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Obernard\LinkedList\Tests\Helpers;

use Obernard\LinkedList\AbstractDoublyLinkedList;
use Obernard\LinkedList\Collection\FifoNode;

/**
 * 
 * First-in/first-out doubly-linked list implementation.
 * 
 * The entry point is the tail and the exit is the head.
 *  
 * 
 * @author Olivier Bernard
 */   

final class TailToHeadFiFoList extends AbstractDoublyLinkedList {

    /**
     * Pushes data at the tail of the list. 
     * @return $this
     */
    public function add($data):self {
        $this->rpushn(new FifoNode($data));
        return $this;
    }

    /**
     * Pops head data content from the list.
     * @return mixed
     */
    public function pop() 
    {
         return $this->lpopn()->getValue();
    }

};