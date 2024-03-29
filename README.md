# 🖇 LinkedList

Linked List implementation in PHP.

## Installation

```shell
composer require obernard/linkedlist
```

## Usage of final class LifoList

Final classes like `LifoList` are given as examples of implementation of abstract linked-list classes but extending `AbstractSinglyLinkedList` or `AbstractDoublyLinkedList` offers much more coding potentials.

Create an empty list and add nodes.
```php
$stack = new Obernard\LinkedList\Collection\LifoList;

$stack->push('hello');
$stack->push(1);
$stack->push(['test1', 'test2']);

foreach ($stack as $key, $value) {
    // do something 
}

$l = $stack->length() // 3

$node = $stack->pop(); // ['test1', 'test2']

$l = $stack->length() // 2

$node = $stack->pop(); // 1

$l = $stack->length() // 1

```

## Usage of Abstract classes 

Abstract singly-linked list supports the use of abstract doubly-linked nodes but as a good practice use singly linked nodes inside singly-linked lists.

Your concrete list class links instances of your concrete node classe. Concrete list classes may create node objects - like `LifoList` class does - or may not.   

In this example, `MyList` class does not create nodes by itself:

```php
// MyList.php

class MyList extends AbstractSinglyLinkedList {
    
}

// MyNode.php
class MyNode extends AbstractSinglyLinkedNode {

    public $data;
    public function __construct($data) {
        $this->data = $data;
    }

    // IterableNodeInterface getValue method:
    public function getValue() {
        return $this->data;
    }

}

// program.php

$list= new MyList();

$list->pushToHead(new MyNode("test1"))->pushToHead(new MyNode("test2"));

foreach ($list as $key => $value) {
    // do something with $value string (returned by MyNode->getValue()) and $key (MyNode->getKey())
}


```
A Node classe implements `IterableNodeInterface` `getKey` and `getValue` methods through `AbstractNode`. You may need to replace one or the other. 

- `getValue` method determines what is returned as value when iterating the list. 

In above example, we decide that `foreach` statement iterate over `$data` node property.

If you want to iterate over Node objects, do not replace `getValue` because `AbstractNode->getValue()` already returns `$this`.

- `getKey` method determines what is returned as key when iterating the list. `AbstractNode->getkey()` argument `$index` is binded with the iterator position index. But you can replace the method and make it return whatever suites your needs. 

@see `AbstractCommonList` `key()` and `current()` methods to see how the magic works.


## Dialogue between nodes 

An interesting design pattern is to make nodes communicate through the list. 

See `AbstractNode` `distanceToLastNode()` method as an example of inter-nodes communication:

```php
// AbstractNode.php

    /**
     *  Returns the node's rank beginning at tail node (ie at the end).
     *  !! Time complexity is O(n) !!
     *  @return int 
     */
    public function distanceToLastNode():int {
        if ($this->isLast()) // if you Node are the last node just say 0
            return 0;
        else {
            // just ask your next node for its rank and increment 
            $nextNodeRrank=$this->next->distanceToLastNode();    
            return ++$nextNodeRrank; 
        }
    }

```

This design pattern is based on recursivity.

The time complexity of such recursive methods is `0(n)` where `n` is the number of nodes.

**If your configuration has `xdebug` module enabled, the use of such recursive function calls may raise the following error if your list length get close to 256:** 

```
Error: Maximum function nesting level of '256' reached, aborting!    
```

If you don't want to modify your `xdebug` config by increasing the `xdebug.max_nesting_level` setting, just don't use that pattern design for long lists.     


**Be carefull not to use recursive communication methods between nodes when iterating over nodes because the time complexity would be O(n2) leading to very poor performance.**


```php
// very low 0(n) < perf < 0(n^2)
for ($i=0; $i<$list->length(); $i++) {
    $list->head($i);
}
// very very low perf ~ O(n^2)  ...
for ($i=0; $i<$list->length(); $i++) {
    $list->head($i)->distanceToLastNode();
}

```

## Tests

Run `composer test`.


## Contributing

Improvements are welcome! Feel free to submit pull requests.

## Licence

MIT

Copyright (c) 2021 Olivier BERNARD