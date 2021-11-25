<?php

namespace  Obernard\LinkedList;

/**
 * 
 * First in Last out linked-list implementation.
 *  
 * 
 * @author Olivier Bernard
 */   

final class FiloList extends AbstractSimpleLinkedList {

    /**
     * Pushes data at the head of the stack. 
     * @return FiloList $this
     */
    public function add($data):self {
        $this->lpush(new FiloItem($data));
        return $this;
    }

    /**
     * Pops head data content from the stack.
     * @return mixed
     */
    public function pop() 
    {
         return $this->lpop();
    }

     /**
     * See Filo item class to  
     * foreach statements iterate over item's data content 
     */

 
};