CHANGELOG
=========


1.3.2 2022-01-11
-----
 * add .gitattributes to exclude some files from composer installation


1.3.1 2022-12-16
-----
 * iterator interface next and rewind explicitly marked @return void (to fix php8 warnings)


1.3 2021-12-05
-----
 * next and prev Node methods return node itself when offset is 0


1.2 2021-12-03
-----
 * Added offset access to nodes: @see list `headn` and `tailn` methods


1.1.1 2021-12-01
-----
 * Suppression of unused class AbstactCommmonNode


1.1 2021-11-30
-----
 * List classes implement Countable interface
 * added `composer test` command 


1.0 2021-11-29
-----
 * complete abstract classes refactoring
 * Item classes become Node classes 
 * refactor project tree 


0.1 2021-11-25
-----
 * added `LinkItemException` class 
 * added `AbstractItem` class 
 * added `Item` class 
 * added `AbstractCommonList` class  
 * added `AbstractSinglyLinkedList` class 
 * added `AbstractDoubledLinkedList` class 
 * added `FiloList` class
 * added `FifoList` class
 * added `IterableItemInterface` class
 * Tested classes


 