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
 * FiloItem class defines an item inside a FiloList  
 *  An FiloItem is linked to a next item and has no previous item 
 * 
 *  $this->next is arbitrary considered at the right of the item.
 * 
 * @author Olivier Bernard
*/   
final class FiloItem extends AbstractItem {

    /**
     * @var mixed data stored in a FiloList item.
     * 
     */
    public $data ;  

    public function __construct($data)
    {
        $this->data = $data;
    } 
    

    /**
     * Just returns the iterator index position when iterated 
     * @param int $index 
     * 
     */
    public function getKey($index) {
        return $index;
    }

    /**
     * Just returns the data property when iterated 
     * @param int $index 
     * 
     */
    public function getValue() {
        return $this->data;
    }

}
