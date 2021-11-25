# 🖇 LinkedList

Linked List implementation in PHP.

## Installation

```shell
composer require obernard/linkedlist
```

## Usage of final class FiloList

FiloList is given as an example of implementation of AbstractSimpleLinkedList but extending AbstractSimpleLinkedList and AbstractItem offers much more coding potentials.

Create an empty list and add items.
```php
$list = new Obernard\LinkedList\FiloList;

$list->add('hello');
$list->add(1);
$list->add(['test1', 'test2']);

foreach ($list as $key, $value) {
    // do something 
}

$item = $list->get(); //  ['test1', 'test2']
$l = $list->length() // 3

$item = $list->pop(); // ['test1', 'test2']

$l = $list->length() // 2

$item = $list->pop(); // 1

$l = $list->length() // 1

```

## Contributing

Improvements are welcome! Feel free to submit pull requests.

## Licence

MIT

Copyright (c) 2021 Olivier BERNARD