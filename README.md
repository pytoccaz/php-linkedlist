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
$list = new Obernard\LinkedList\FiloList;

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

## Contributing

Improvements are welcome! Feel free to submit pull requests.

## Licence

MIT

Copyright (c) 2021 Olivier BERNARD