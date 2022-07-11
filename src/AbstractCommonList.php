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

use Obernard\LinkedList\Exception\ListException;

/**
 * 
 * Defines common properties and methods for all other List classes.
 * 
 * @author Olivier Bernard
 */

abstract class AbstractCommonList implements \Iterator, \Countable
{


    /**
     * Points to the "left most" node
     * @var AbstractNode|null
     */
    protected $head = null;

    /**
     * Points to the node returned during iteration.
     * @var AbstractNode|null
     */
    private $current = null; // points to the node returned during iteration

    /**
     * @var int the iterator index position.
     */
    private $index = 0;


    /**
     * @var int the number of nodes in the list
     */
    protected $length = 0;

    /**
     * Returns the number of nodes inside the list.
     * @return int 
     */
    public function length(): int
    {
        return $this->length;
    }

    /**
     * Returns true when the list is empty.
     * @return bool 
     */
    public function isEmpty(): bool
    {
        return $this->length === 0;
    }

    /**
     * Returns the head node (ie the left most node) by default.
     * Returns the N'th next linked node when $offset = N with N >= 1.
     * Mainly used for internal logic.
     * @param int $offset 
     * @return AbstractNode|null
     * 
     */
    public function headn($offset = 0): ?AbstractNode
    {
        if ($offset === 0)
            return $this->head;

        if ($offset >= 1 and $offset <= $this->length - 1)
            return $this->head->next($offset);

        if ($offset < 0)
            throw (new ListException("Offset is not a positive integer!"));

        if ($offset > 0)
            throw (new ListException("Offset is out off range!"));
    }

    /**
     * Returns into an array whatever the final class decides to (depends on the current() method implementation).  
     * @return array[mixed]
     */
    public function toArray(): array
    {
        $ar = [];
        foreach ($this as $node) {
            $ar[] = $node;
        }
        return $ar;
    }

    /**
     *   Countable interface implementation
     */
    public function count(): int
    {
        return $this->length;
    }

    /**
     *   foreach Iterator functions implementation
     *   !! Be carefull: key() and current() methods'logic is left to the node class !!  
     */

    /**
     * Rewind the Iterator to the first element
     * @return void 
     */
    public function rewind(): void
    {
        $this->index = 0;
        $this->current = $this->head;
    }

    /**
     * Move forward to next element
     * @return void
     */
    public function next(): void
    {
        $this->current = $this->current->next();
        $this->index++;
    }

    /**
     * Checks if current position is valid
     * @return bool
     */
    public function valid(): bool
    {
        return $this->current != null;
    }

    /**
     *  !! Be carefull: key() and current() methods'logic is left to the node class
     *     through its getKey and getValue methods !!
     *   
     */

    /**
     * Returns the key associated with a node when the list is iterated.
     * Even if the logic is left to the node final class, the method is kind 
     *  enough to pass the iterator index to the node. 
     * @param int index position of the iterator.
     * @return mixed key associated with the iterated node.
     */
    public function key(): mixed
    {
        if (!$this->valid())
            return null;

        return  $this->current->getKey($this->index);
    }

    /**
     * Returns the value associated with a node when the list is iterated.
     * The logic is left to the node final class.
     * @return mixed value associated with the iterated node.
     */
    public function current(): mixed
    {
        return $this->current->getValue();
    }
};
