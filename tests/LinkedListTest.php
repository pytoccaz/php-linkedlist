<?php
/**
 * @author olivier Bernard
 */

namespace Obernard\LinkedList\Tests;
use  Obernard\LinkedList\FiloList;
use  Obernard\LinkedList\FifoList;
use  Obernard\LinkedList\TailToHeadFiFoList;
use Obernard\LinkedList\Item;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase 
{

    public function nonEmptyFifoListAlwaysVerify($list) {
        $this->assertInstanceOf(Item::class, $list->ihead(), "The head item.");
        $this->assertInstanceOf(Item::class, $list->itail(), "The tail item.");
    
        $this->assertEquals($list->ihead()->prev(), null, "The head item has no previous item.");
    
        $this->assertInstanceOf(Item::class, $list->ihead()->next(), "The head item has a next item.");
    
        $this->assertEquals($list->itail()->next(), null, "The tail item has no next item.");
        $this->assertInstanceOf(Item::class, $list->itail()->prev(), "The tail item has a previous item.");
    
        $this->assertEquals($list->itail()->isLast(), true, "The tail item is the last one.");
        $this->assertEquals($list->ihead()->isFirst(), true, "The head item is the first one.");
        
    } 


  /**
   * Test AbstractSinglyLinkedList through FiloList
   * 
   */
  public function testFiloList():void
  {
    $list = new FiloList();
    $this->assertInstanceOf(FiloList::class, $list);
    
    $this->assertEquals($list->key(), null,  "Test of key internal method when list is empty."); 
    $this->assertEquals($list->valid(), false,  "Test of valid method when list is empty."); 

    $this->assertTrue($list->isEmpty(), "List is empty."); 
  
    $list->add(1)->add(2)->add(3);

    $this->assertEquals(3, $list->length(), "The list contains 3 items.");

    $this->assertEquals( [3,2,1], $list->toArray(), "Expected toArray() return."); 


    $ar=[];
    foreach ($list as $value) {
        $ar[]= $value;
    }
    $this->assertEquals($list->toArray(), $ar, "Comparison of toArray and foreach results."); 


    // pops all the items
    $i=0;
    $lengthBeforePops = $list->length();
    $arrayOfPopedValues = [];

    while ($list->length()) {
        $i++;
        $popedItem = $list->ipop();
        $arrayOfPopedValues[] = $popedItem->getValue();
        $this->assertEquals($popedItem->next(), null, "Poped item has no next item."); 
        $this->assertEquals($popedItem->prev(), null, "Poped item has no prev item."); 
    }
    $this->assertEquals($list->length(), 0, "1/ The list is empty."); 
    $this->assertEquals($list->isEmpty(), true, "1/ The list is empty.");

    $this->assertEquals($lengthBeforePops, $i, "Controles number of iterations."); 

    $this->assertEquals($arrayOfPopedValues, [3, 2, 1], "Poped values order"); 
    
  }


  /**
   * Test AbstractDoubledLinkedList through FifoList
   * 
   */
  public function testFifoList():void
  {
    $list = new FifoList();
    $this->assertInstanceOf(FifoList::class, $list);
    
    $this->assertEquals($list->key(), null,  "Test of key internal method when list is empty."); 
    $this->assertEquals($list->valid(), false,  "Test of valid method when list is empty."); 

    $this->assertTrue($list->isEmpty(), "List is empty."); 
  

    /**
     * Test left push (internal ilpush method).
     */

    // A first item is pushed
    $list->add(1);
   
    $this->assertEquals(1, $list->length(), "The list contains 1 item.");

    $this->assertInstanceOf(Item::class, $list->ihead(), "The head item.");

    $this->assertEquals($list->ihead(), $list->itail(), "The item is at both head and tail positions.");

    $this->assertEquals($list->ihead()->prev(), null, "The item has no previous item.");

    $this->assertEquals($list->ihead()->next(), null, "The item has no next item.");
 
     // A second item is pushed
    $list->add(2);
    $this->nonEmptyFifoListAlwaysVerify($list);
    $this->assertEquals(2, $list->length(), "The list contains 2 items.");

    $this->assertEquals($list->itail()->prev(), $list->ihead(), "The head item is the tail previous item.");
    $this->assertEquals($list->ihead()->next(), $list->itail(), "The tail item is the head next item.");

    $this->assertEquals($list->ihead()->getValue(), 2, "data are pushed at the head.");
    $this->assertEquals($list->itail()->getValue(), 1, "data pushes shift data to toward the tail.");

     // A third item is pushed
     $list->add(3);
     $this->nonEmptyFifoListAlwaysVerify($list);
     $this->assertEquals(3, $list->length(), "The list contains 3 items.");
     $this->assertEquals($list->ihead()->getValue(), 3, "data are pushed at the head.");
     $this->assertEquals($list->ihead()->next()->getValue(), 2, "1/ data pushes shift data toward the tail.");
     $this->assertEquals($list->itail()->getValue(), 1, "2/ data pushes shift data toward the tail.");


    $this->assertEquals($list->toArray(), [3,2,1], "Expected toArray() return."); 

    $ar=[];
    foreach ($list as $value) {
        $ar[]= $value;
    }
    $this->assertEquals($list->toArray(), $ar, "Comparison of toArray and foreach results."); 


    // pops all the items
    $i=0;
    $lengthBeforePops = $list->length();
    $arrayOfPopedValues = [];

    while ($list->length()) {
        $i++;
        $popedItem = $list->irpop();
        $arrayOfPopedValues[] = $popedItem->getValue();
        $this->assertEquals($popedItem->next(), null, "Poped item has no next item."); 
        $this->assertEquals($popedItem->prev(), null, "Poped item has no prev item."); 
    }
    $this->assertEquals($list->length(), 0, "1/ The list is empty."); 
    $this->assertEquals($list->isEmpty(), true, "1/ The list is empty.");

    $this->assertEquals($lengthBeforePops, $i, "Controles number of iterations."); 

    $this->assertEquals($arrayOfPopedValues, [1, 2, 3], "Poped values order"); 
    
    

  }


  /**
   * Test AbstractDoubledLinkedList through TailToHeadFiFoList
   * 
   */
  public function testTailToHeadFiFoList():void
  {
    $list = new TailToHeadFiFoList();
    $this->assertInstanceOf(TailToHeadFiFoList::class, $list);
    
    $this->assertEquals($list->key(), null,  "Test of key internal method when list is empty."); 
    $this->assertEquals($list->valid(), false,  "Test of valid method when list is empty."); 

    $this->assertTrue($list->isEmpty(), "List is empty."); 
  

    /**
     * Test left push (internal ilpush method).
     */

    // A first item is pushed
    $list->add(1);
   
    $this->assertEquals(1, $list->length(), "The list contains 1 item.");

    $this->assertInstanceOf(Item::class, $list->ihead(), "The head item.");

    $this->assertEquals($list->ihead(), $list->itail(), "The item is at both head and tail positions.");

    $this->assertEquals($list->ihead()->prev(), null, "The item has no previous item.");

    $this->assertEquals($list->ihead()->next(), null, "The item has no next item.");
 
     // A second item is pushed
    $list->add(2);
    $this->nonEmptyFifoListAlwaysVerify($list);
    $this->assertEquals(2, $list->length(), "The list contains 2 items.");

    $this->assertEquals([1,2], $list->toArray(), "Expected toArray() return.");
 
    $this->assertEquals($list->itail()->prev(), $list->ihead(), "The head item is the tail previous item.");
    $this->assertEquals($list->ihead()->next(), $list->itail(), "The tail item is the head next item.");


    $this->assertEquals($list->itail()->getValue(), 2, "data are pushed at the tail.");
    $this->assertEquals($list->ihead()->getValue(), 1, "data pushes shift data to toward the head.");

     // A third item is pushed
     $list->add(3);
     $this->nonEmptyFifoListAlwaysVerify($list);
     $this->assertEquals(3, $list->length(), "The list contains 3 items.");
     $this->assertEquals($list->itail()->getValue(), 3, "data are pushed at the tail.");

     $this->assertEquals([1,2,3], $list->toArray(), "Expected toArray() return.");


     $this->assertEquals($list->itail()->prev()->getValue(), 2, "1/ data pushes shift data toward the head.");
     $this->assertEquals($list->ihead()->getValue(), 1, "2/ data pushes shift data toward the head.");


    $ar=[];
    foreach ($list as $value) {
        $ar[]= $value;
    }
    $this->assertEquals($list->toArray(), $ar, "Comparison of toArray and foreach results."); 


    // pops all the items
    $i=0;
    $lengthBeforePops = $list->length();
    $arrayOfPopedValues = [];

    while ($list->length()) {
        $i++;
        $popedItem = $list->ilpop();
        $arrayOfPopedValues[] = $popedItem->getValue();
        $this->assertEquals($popedItem->next(), null, "Poped item has no next item."); 
        $this->assertEquals($popedItem->prev(), null, "Poped item has no prev item."); 
    }
    $this->assertEquals($list->length(), 0, "1/ The list is empty."); 
    $this->assertEquals($list->isEmpty(), true, "1/ The list is empty.");

    $this->assertEquals($lengthBeforePops, $i, "Controles number of iterations."); 

    $this->assertEquals($arrayOfPopedValues, [1, 2, 3], "Poped values order"); 
    
    

  }




}