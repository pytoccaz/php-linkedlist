# 🖇 LinkedList

Linked List implementation in PHP.

## Installation

```shell
composer require obernard/linkedlist
```

## Usage of final class FiloList

Final classes like `FiloList` are given as examples of implementation of abstract linked-list classes but extending `AbstractSinglyLinkedList` or `AbstractDoublyLinkedList` offers much more coding potentials.

Create an empty list and add nodes.
```php
$list = new Obernard\LinkedList\Collection\FiloList;

$list->add('hello');
$list->add(1);
$list->add(['test1', 'test2']);

foreach ($list as $key, $value) {
    // do something 
}

$l = $list->length() // 3

$node = $list->pop(); // ['test1', 'test2']

$l = $list->length() // 2

$node = $list->pop(); // 1

$l = $list->length() // 1

```

## Usage of Abstract classes 

Abstract singly-linked list supports the use of abstract doubly-linked nodes but as a good practice use singly linked nodes inside singly-linked lists.

Your concrete list classe links instances of your concrete node classe. Like FifoList class, they may create themselves node objects or may not.   

In this example, `MyList` class does not create nodes by itself:

```php
// MyList.php

class MyList extends AbstractSinglyLinkedList {
    
}

// MyNode.php
class MyNode extends AbstractSinglyNode {

    public $data;
    public function __construct($data) {
        $this->data = $data;
    }

    // IterableNodeInterface 2 methods:
    public function getKey($index) {
        return $index;
    }

    public function getValue() {
        return $this->data;
    }

}

// program.php

$list= new MyList();

$list->rpushn(new MyNode("test1"))->rpushn(new MyNode("test2"));

foreach ($list as $value) {
    // do something with $value string (returned by MyNode->getValue())
}


```

A concrete Node class has to implement IterableNodeInterface `getKey` and `getValue` methods. 

`getValue` method determines what is returned when iterating the list.

In above, example, we decide that `foreach` statement iterate over `$data` node property.

If you want to iterate over Node objects, just make `getValue` return `$this`.


## Contributing

Improvements are welcome! Feel free to submit pull requests.

## Licence

MIT

Copyright (c) 2021 Olivier BERNARD