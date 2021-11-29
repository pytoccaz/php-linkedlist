<?php
/**
 * @author olivier Bernard
 */

namespace Obernard\LinkedList\Tests;
use  Obernard\LinkedList\Collection\FiloList;
use  Obernard\LinkedList\Collection\FifoList;
use Obernard\LinkedList\Collection\FifoNode;
use PHPUnit\Framework\TestCase;
use Obernard\LinkedList\Tests\Helpers\TailToHeadFiFoList;


class CollectionTest extends TestCase 
{

    private function nonEmptyFifoListAlwaysVerify($list) {
        $this->assertInstanceOf(FifoNode::class, $list->headn(), "The head node.");
        $this->assertInstanceOf(FifoNode::class, $list->tailn(), "The tail node.");
    
        $this->assertEquals($list->headn()->prev(), null, "The head node has no previous node.");
    
        $this->assertInstanceOf(FifoNode::class, $list->headn()->next(), "The head node has a next node.");
    
        $this->assertEquals($list->tailn()->next(), null, "The tail node has no next node.");
        $this->assertInstanceOf(FifoNode::class, $list->tailn()->prev(), "The tail node has a previous node.");
    
        $this->assertEquals($list->tailn()->isLast(), true, "The tail node is the last one.");
        $this->assertEquals($list->headn()->isFirst(), true, "The head node is the first one.");


        $this->assertEquals($list->tailn()->lrank(), $list->length()-1, "Tail node lrank always equals length - 1.");
        $this->assertEquals($list->headn()->rrank(), $list->length()-1, "Head node rrank always equals length - 1.");
        $this->assertEquals($list->tailn()->rrank(), 0, "Tail node rrank is 0");
        $this->assertEquals($list->headn()->lrank(), 0, "Head node lrank is 0");

        
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
    $this->assertEquals($list->headn()->rrank(), $list->length()-1, "Head node rrank always equals length - 1.");

    $this->assertEquals(3, $list->length(), "The list contains 3 nodes.");

    $this->assertEquals( [3,2,1], $list->toArray(), "Expected toArray() return."); 


    $ar=[];
    foreach ($list as $value) {
        $ar[]= $value;
    }
    $this->assertEquals($list->toArray(), $ar, "Comparison of toArray and foreach results."); 


    // pops all the nodes
    $i=0;
    $lengthBeforePops = $list->length();
    $arrayOfPopedValues = [];

    while ($list->length()) {
        $i++;
        $popedNode = $list->lpopn();
        $arrayOfPopedValues[] = $popedNode->getValue();
        $this->assertEquals($popedNode->next(), null, "Poped node has no next node."); 
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
     * Test left push (internal lpushn method).
     */

    // A first node is pushed
    $list->add(1);
   
    $this->assertEquals(1, $list->length(), "The list contains 1 node.");

    $this->assertInstanceOf(FifoNode::class, $list->headn(), "The head node.");

    $this->assertEquals($list->headn(), $list->tailn(), "The node is at both head and tail positions.");

    $this->assertEquals($list->headn()->prev(), null, "The node has no previous node.");

    $this->assertEquals($list->headn()->next(), null, "The node has no next node.");
 
     // A second node is pushed
    $list->add(2);
    $this->nonEmptyFifoListAlwaysVerify($list);
    $this->assertEquals(2, $list->length(), "The list contains 2 nodes.");

    $this->assertEquals($list->tailn()->prev(), $list->headn(), "The head node is the tail previous node.");
    $this->assertEquals($list->headn()->next(), $list->tailn(), "The tail node is the head next node.");

    $this->assertEquals($list->headn()->getValue(), 2, "data are pushed at the head.");
    $this->assertEquals($list->tailn()->getValue(), 1, "data pushes shift data to toward the tail.");

     // A third node is pushed
     $list->add(3);
     $this->nonEmptyFifoListAlwaysVerify($list);
     $this->assertEquals(3, $list->length(), "The list contains 3 nodes.");
     $this->assertEquals($list->headn()->getValue(), 3, "data are pushed at the head.");
     $this->assertEquals($list->headn()->next()->getValue(), 2, "1/ data pushes shift data toward the tail.");
     $this->assertEquals($list->tailn()->getValue(), 1, "2/ data pushes shift data toward the tail.");


    $this->assertEquals($list->toArray(), [3,2,1], "Expected toArray() return."); 

    $ar=[];
    foreach ($list as $value) {
        $ar[]= $value;
    }
    $this->assertEquals($list->toArray(), $ar, "Comparison of toArray and foreach results."); 


    // pops all the nodes
    $i=0;
    $lengthBeforePops = $list->length();
    $arrayOfPopedValues = [];

    while ($list->length()) {
        $i++;
        $popedNode = $list->rpopn();
        $arrayOfPopedValues[] = $popedNode->getValue();
        $this->assertEquals($popedNode->next(), null, "Poped node has no next node."); 
        $this->assertEquals($popedNode->prev(), null, "Poped node has no prev node."); 
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
     * Test left push (internal lpushn method).
     */

    // A first node is pushed
    $list->add(1);
   
    $this->assertEquals(1, $list->length(), "The list contains 1 node.");

    $this->assertInstanceOf(FifoNode::class, $list->headn(), "The head node.");

    $this->assertEquals($list->headn(), $list->tailn(), "The node is at both head and tail positions.");

    $this->assertEquals($list->headn()->prev(), null, "The node has no previous node.");

    $this->assertEquals($list->headn()->next(), null, "The node has no next node.");
 
     // A second node is pushed
    $list->add(2);
    $this->nonEmptyFifoListAlwaysVerify($list);
    $this->assertEquals(2, $list->length(), "The list contains 2 nodes.");

    $this->assertEquals([1,2], $list->toArray(), "Expected toArray() return.");
 
    $this->assertEquals($list->tailn()->prev(), $list->headn(), "The head node is the tail previous node.");
    $this->assertEquals($list->headn()->next(), $list->tailn(), "The tail node is the head next node.");


    $this->assertEquals($list->tailn()->getValue(), 2, "data are pushed at the tail.");
    $this->assertEquals($list->headn()->getValue(), 1, "data pushes shift data to toward the head.");

     // A third node is pushed
     $list->add(3);
     $this->nonEmptyFifoListAlwaysVerify($list);
     $this->assertEquals(3, $list->length(), "The list contains 3 nodes.");
     $this->assertEquals($list->tailn()->getValue(), 3, "data are pushed at the tail.");

     $this->assertEquals([1,2,3], $list->toArray(), "Expected toArray() return.");


     $this->assertEquals($list->tailn()->prev()->getValue(), 2, "1/ data pushes shift data toward the head.");
     $this->assertEquals($list->headn()->getValue(), 1, "2/ data pushes shift data toward the head.");


    $ar=[];
    foreach ($list as $value) {
        $ar[]= $value;
    }
    $this->assertEquals($list->toArray(), $ar, "Comparison of toArray and foreach results."); 


    // pops all the nodes
    $i=0;
    $lengthBeforePops = $list->length();
    $arrayOfPopedValues = [];

    while ($list->length()) {
        $i++;
        $popedNode = $list->lpopn();
        $arrayOfPopedValues[] = $popedNode->getValue();
        $this->assertEquals($popedNode->next(), null, "Poped node has no next node."); 
        $this->assertEquals($popedNode->prev(), null, "Poped node has no prev node."); 
    }
    $this->assertEquals($list->length(), 0, "1/ The list is empty."); 
    $this->assertEquals($list->isEmpty(), true, "1/ The list is empty.");

    $this->assertEquals($lengthBeforePops, $i, "Controles number of iterations."); 

    $this->assertEquals($arrayOfPopedValues, [1, 2, 3], "Poped values order"); 
    
    

  }




}