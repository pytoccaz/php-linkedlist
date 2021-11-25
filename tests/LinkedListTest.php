<?php
/**
 * @author olivier Bernard
 */

namespace Obernard\LinkedList\Tests;
use  Obernard\LinkedList\FiloList;

use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase 
{

  public function testFiloList():void
  {
    $list = new FiloList();
    $this->assertInstanceOf(FiloList::class, $list);
    
    $this->assertEquals($list->key(), null,  "Test of key internal method when list is empty."); 
    $this->assertEquals($list->valid(), false,  "Test of valid method when list is empty."); 

    $this->assertTrue($list->isEmpty(), "List is empty."); 
  
    $list->add(1)->add(2)->add(3);

    $this->assertEquals(3, $list->length(), "The list contains 3 items.");

    $this->assertEquals($list->toArray(), [3,2,1], "Expected toArray() return."); 

    $this->assertEquals(3, $list->pop(), "Pops the last added value.");

    $this->assertEquals(2, $list->length(), "The list now contains 2 items.");


    $ar=[];
    foreach ($list as $value) {
        $ar[]= $value;
    }
    $this->assertEquals($list->toArray(), $ar, "Comparison of toArray and foreach results."); 

  }

}