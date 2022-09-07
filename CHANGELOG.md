CHANGELOG
=========
4.0
-----
 * rename `FiloList` class into `LifoList`
 * fix `FifoList` iteration order mode  

3.0
-----
 * List methods `headn` and `tailn` are replaced by `head` and `tail` 
 * Node methods `lrank` and `rrank` are replaced by `distanceToFirstNode` and `distanceToLastNode` 
 * List methods `lpushn` and `lpopn` are replaced by `pushToHead` and `popFromHead` 
 * List methods `rpushn` and `rpopn` are replaced by `pushToTail` and `popFromTail`

 
2.0.4
-----
 * format code with php intelephense linter
 * make `AbstractNode` class implement default `IterableNodeInterface` `getValue` and `getKey` methods 

2.0.3 2022-01-11
-----
 * fix typo FiFoList->Fifolist 


2.0.2 2022-01-11
-----
 * add .gitattributes to exclude some files from composer installation.


2.0.1 2021-12-31
-----
 * fix php8 deprecation warnings on fifo & filo classes

2.0 2021-12-31
-----
 * fix php8 deprecation warnings


1.3.1 2021-12-16
-----
 * Iterator interface next and rewind methods return void (fix php8 deprecation warning)

1.3 2021-12-05
-----
 * next and prev Node methods return node itself when offset is 0


1.2 2021-12-03
-----
 * add offset access to nodes: @see list `headn` and `tailn` methods. 


1.1.1 2021-12-01
-----
 * Suppression of unused class AbstactCommmonNode


1.1 2021-11-30
-----
 * List classes implement Countable interface
 * add `composer test` command 


1.0 2021-11-29
-----
 * refactor abstract classes refactoring
 * Item classes become Node classes 
 * refactor project tree 


0.1 2021-11-25
-----
 * add `LinkItemException` class 
 * add `AbstractItem` class 
 * add `Item` class 
 * add `AbstractCommonList` class  
 * add `AbstractSinglyLinkedList` class 
 * add `AbstractDoubledLinkedList` class 
 * add `FiloList` class
 * add `FifoList` class
 * add `IterableItemInterface` class
 * add tests 


 