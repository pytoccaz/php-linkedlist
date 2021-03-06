<?php

/**
 * @author olivier Bernard
 */

namespace Obernard\LinkedList\Tests;

use  Obernard\LinkedList\Collection\FiloList;
use  Obernard\LinkedList\Collection\FifoList;
use Obernard\LinkedList\Collection\FifoNode;
use PHPUnit\Framework\TestCase;
use Obernard\LinkedList\Tests\Helpers\TailToHeadFifoList;


class CollectionTest extends TestCase
{

    private function nonEmptyFifoListAlwaysVerify($list)
    {
        $this->assertInstanceOf(FifoNode::class, $list->headn(), "The head node.");
        $this->assertInstanceOf(FifoNode::class, $list->tailn(), "The tail node.");

        $this->assertEquals($list->headn()->prev(), null, "The head node has no previous node.");

        // $this->assertEquals(null, $list->headn($list->length()), "when offset === length, return null.");


        $this->assertEquals(true, $list->headn($list->length() - 1)->isLast(), "when offset === length-1, return tail node.");



        if ($list->length() > 1)
            $this->assertInstanceOf(FifoNode::class, $list->headn()->next(), "The head node has a next node.");


        $this->assertEquals($list->tailn()->next(), null, "The tail node has no next node.");

        if ($list->length() > 1)
            $this->assertInstanceOf(FifoNode::class, $list->tailn()->prev(), "The tail node has a previous node.");

        $this->assertEquals(true, $list->headn()->isFirst(), "1/ The head node is the first one.");
        $this->assertEquals(true, $list->headn(0)->isFirst(), "2/ The head node is the first one.");
        $this->assertEquals(true, $list->headn()->next(0)->isFirst(), "4/ The head node is the first one.");
        $this->assertEquals(true, $list->headn(0)->next(0)->isFirst(), "5/ The head node is the first one.");


        $this->assertEquals(true, $list->tailn()->isLast(), "The tail node is the last one.");
        $this->assertEquals(true, $list->tailn(0)->isLast(), "2/ The tail node is the last one.");
        $this->assertEquals(true, $list->tailn()->prev(0)->isLast(), "4/ The tail node is the last one.");
        $this->assertEquals(true, $list->tailn(0)->prev(0)->prev(0)->isLast(), "5/ The tail node is the last one.");


        $this->assertEquals($list->tailn()->lrank(), $list->length() - 1, "Tail node lrank always equals length - 1.");
        $this->assertEquals($list->headn()->rrank(), $list->length() - 1, "Head node rrank always equals length - 1.");
        $this->assertEquals(0, $list->tailn()->rrank(), "Tail node rrank is 0");
        $this->assertEquals(0, $list->headn()->lrank(), "Head node lrank is 0");


        $this->assertEquals($list->length(), count($list), "List obj are countable");

        $this->assertEquals($list->tailn($list->length() - 1), $list->headn(), "Get the head node through tailn offset");
        $this->assertEquals($list->headn($list->length() - 1), $list->tailn(), "Get the tail node through headn offset");
    }


    /**
     * Test AbstractSinglyLinkedList through FiloList
     * 
     */
    public function testFiloList(): void
    {
        $list = new FiloList();
        $this->assertInstanceOf(FiloList::class, $list);

        $this->assertEquals($list->key(), null,  "Test of key internal method when list is empty.");
        $this->assertEquals($list->valid(), false,  "Test of valid method when list is empty.");

        $this->assertTrue($list->isEmpty(), "List is empty.");

        $list->add(1)->add(2)->add(3);

        $this->assertEquals($list->headn(0), $list->headn(), "Get head node through headn");
        $this->assertEquals($list->headn(1), $list->headn()->next(), "Get n'th node through headn");
        $this->assertEquals($list->headn(2), $list->headn()->next()->next(), "Get n'th node through headn");
        // $this->assertEquals($list->headn(3), $list->headn()->next()->next()->next(), "Get n'th node through headn");
        // $this->assertEquals(NULL, $list->headn()->next()->next()->next(), "Get n'th node through headn");
        $this->assertEquals($list->headn()->rrank(), $list->length() - 1, "Head node rrank always equals length - 1.");

        $this->assertEquals(3, $list->length(), "The list contains 3 nodes.");

        $this->assertEquals([3, 2, 1], $list->toArray(), "Expected toArray() return.");
        $this->assertEquals($list->headn($list->length() - 1)->getValue(), 1, "Get the tail node through headn offset");

        $ar = [];
        foreach ($list as $value) {
            $ar[] = $value;
        }
        $this->assertEquals($list->toArray(), $ar, "Comparison of toArray and foreach results.");


        // pops all the nodes
        $i = 0;
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
    public function testFifoList(): void
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

        $this->nonEmptyFifoListAlwaysVerify($list);

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


        $this->assertEquals($list->toArray(), [3, 2, 1], "Expected toArray() return.");

        $ar = [];
        foreach ($list as $value) {
            $ar[] = $value;
        }
        $this->assertEquals($list->toArray(), $ar, "Comparison of toArray and foreach results.");


        // pops all the nodes
        $i = 0;
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
     * Test AbstractDoubledLinkedList through TailToHeadFifoList
     * 
     */
    public function testTailToHeadFifoList(): void
    {
        $list = new TailToHeadFifoList();
        $this->assertInstanceOf(TailToHeadFifoList::class, $list);

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

        $this->assertEquals([1, 2], $list->toArray(), "Expected toArray() return.");

        $this->assertEquals($list->tailn()->prev(), $list->headn(), "The head node is the tail previous node.");
        $this->assertEquals($list->headn()->next(), $list->tailn(), "The tail node is the head next node.");


        $this->assertEquals($list->tailn()->getValue(), 2, "data are pushed at the tail.");
        $this->assertEquals($list->headn()->getValue(), 1, "data pushes shift data to toward the head.");

        // A third node is pushed
        $list->add(3);
        $this->nonEmptyFifoListAlwaysVerify($list);
        $this->assertEquals(3, $list->length(), "The list contains 3 nodes.");
        $this->assertEquals($list->tailn()->getValue(), 3, "data are pushed at the tail.");

        $this->assertEquals([1, 2, 3], $list->toArray(), "Expected toArray() return.");


        $this->assertEquals($list->tailn()->prev()->getValue(), 2, "1/ data pushes shift data toward the head.");
        $this->assertEquals($list->headn()->getValue(), 1, "2/ data pushes shift data toward the head.");


        $ar = [];
        foreach ($list as $value) {
            $ar[] = $value;
        }
        $this->assertEquals($list->toArray(), $ar, "Comparison of toArray and foreach results.");


        // pops all the nodes
        $i = 0;
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
