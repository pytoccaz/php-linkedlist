<?php

/**
 * @author olivier Bernard
 */

namespace Obernard\LinkedList\Tests;

use  Obernard\LinkedList\Collection\LifoList;
use  Obernard\LinkedList\Collection\FifoList;
use Obernard\LinkedList\Collection\FifoNode;
use PHPUnit\Framework\TestCase;
use Obernard\LinkedList\Tests\Helpers\TailToHeadFifoList;


class CollectionTest extends TestCase
{

    private function nonEmptyFifoListAlwaysVerify($list)
    {
        $this->assertInstanceOf(FifoNode::class, $list->head(), "The head node.");
        $this->assertInstanceOf(FifoNode::class, $list->tail(), "The tail node.");

        $this->assertEquals($list->head()->prev(), null, "The head node has no previous node.");

        // $this->assertEquals(null, $list->head($list->length()), "when offset === length, return null.");


        $this->assertEquals(true, $list->head($list->length() - 1)->isLast(), "when offset === length-1, return tail node.");



        if ($list->length() > 1)
            $this->assertInstanceOf(FifoNode::class, $list->head()->next(), "The head node has a next node.");


        $this->assertEquals($list->tail()->next(), null, "The tail node has no next node.");

        if ($list->length() > 1)
            $this->assertInstanceOf(FifoNode::class, $list->tail()->prev(), "The tail node has a previous node.");

        $this->assertEquals(true, $list->head()->isFirst(), "1/ The head node is the first one.");
        $this->assertEquals(true, $list->head(0)->isFirst(), "2/ The head node is the first one.");
        $this->assertEquals(true, $list->head()->next(0)->isFirst(), "4/ The head node is the first one.");
        $this->assertEquals(true, $list->head(0)->next(0)->isFirst(), "5/ The head node is the first one.");


        $this->assertEquals(true, $list->tail()->isLast(), "The tail node is the last one.");
        $this->assertEquals(true, $list->tail(0)->isLast(), "2/ The tail node is the last one.");
        $this->assertEquals(true, $list->tail()->prev(0)->isLast(), "4/ The tail node is the last one.");
        $this->assertEquals(true, $list->tail(0)->prev(0)->prev(0)->isLast(), "5/ The tail node is the last one.");


        $this->assertEquals($list->tail()->distanceToFirstNode(), $list->length() - 1, "Tail node distanceToFirstNode always returns length - 1.");
        $this->assertEquals($list->head()->distanceToLastNode(), $list->length() - 1, "Head node distanceToLastNode always returns length - 1.");
        $this->assertEquals(0, $list->tail()->distanceToLastNode(), "Tail node distanceToLastNode returns 0");
        $this->assertEquals(0, $list->head()->distanceToFirstNode(), "Head node distanceToFirstNode returns 0");


        $this->assertEquals($list->length(), count($list), "List obj are countable");

        $this->assertEquals($list->tail($list->length() - 1), $list->head(), "Get the head node through tail offset");
        $this->assertEquals($list->head($list->length() - 1), $list->tail(), "Get the tail node through head offset");
    }


    /**
     * Test AbstractSinglyLinkedList through LifoList
     * 
     */
    public function testLifoList(): void
    {
        $list = new LifoList();
        $this->assertInstanceOf(LifoList::class, $list);

        $this->assertEquals($list->key(), null,  "Test of key internal method when list is empty.");
        $this->assertEquals($list->valid(), false,  "Test of valid method when list is empty.");

        $this->assertTrue($list->isEmpty(), "List is empty.");

        $list->push(1)->push(2)->push(3);

        $this->assertEquals($list->head(0), $list->head(), "Get head node through head");
        $this->assertEquals($list->head(1), $list->head()->next(), "Get n'th node through head");
        $this->assertEquals($list->head(2), $list->head()->next()->next(), "Get n'th node through head");
        // $this->assertEquals($list->head(3), $list->head()->next()->next()->next(), "Get n'th node through head");
        // $this->assertEquals(NULL, $list->head()->next()->next()->next(), "Get n'th node through head");
        $this->assertEquals($list->head()->distanceToLastNode(), $list->length() - 1, "Head node distanceToLastNode always returns length - 1.");

        $this->assertEquals(3, $list->length(), "The list contains 3 nodes.");

        $this->assertEquals([3, 2, 1], $list->toArray(), "Expected toArray() return.");
        $this->assertEquals($list->head($list->length() - 1)->getValue(), 1, "Get the tail node through head offset");

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
            $popedNode = $list->popFromHead();
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
         * Test left push (push to head).
         */

        // A first node is pushed
        $list->push(1);

        $this->assertEquals(1, $list->length(), "The list contains 1 node.");

        $this->assertInstanceOf(FifoNode::class, $list->head(), "The head node.");

        $this->assertEquals($list->head(), $list->tail(), "The node is at both head and tail positions.");

        $this->assertEquals($list->head()->prev(), null, "The node has no previous node.");

        $this->assertEquals($list->head()->next(), null, "The node has no next node.");

        $this->nonEmptyFifoListAlwaysVerify($list);

        // A second node is pushed
        $list->push(2);
        $this->nonEmptyFifoListAlwaysVerify($list);
        $this->assertEquals(2, $list->length(), "The list contains 2 nodes.");

        $this->assertEquals($list->tail()->prev(), $list->head(), "The head node is the tail previous node.");
        $this->assertEquals($list->head()->next(), $list->tail(), "The tail node is the head next node.");

        $this->assertEquals($list->head()->getValue(), 1, "data are pushed at the tail.");
        $this->assertEquals($list->tail()->getValue(), 2, "data are pushed at the tail.");

        // A third node is pushed
        $list->push(3);
        $this->nonEmptyFifoListAlwaysVerify($list);
        $this->assertEquals(3, $list->length(), "The list contains 3 nodes.");
        $this->assertEquals($list->tail()->getValue(), 3, "data are pushed at the tail.");
        $this->assertEquals($list->tail()->prev()->getValue(), 2, "ata are pushed at the tail.");
        $this->assertEquals($list->head()->getValue(), 1, "ata are pushed at the tail.");


        $this->assertEquals($list->toArray(), [1, 2, 3], "Expected toArray() return.");

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
            $popedNode = $list->popFromTail();
            $arrayOfPopedValues[] = $popedNode->getValue();
            $this->assertEquals($popedNode->next(), null, "Poped node has no next node.");
            $this->assertEquals($popedNode->prev(), null, "Poped node has no prev node.");
        }
        $this->assertEquals($list->length(), 0, "1/ The list is empty.");
        $this->assertEquals($list->isEmpty(), true, "1/ The list is empty.");

        $this->assertEquals($lengthBeforePops, $i, "Controles number of iterations.");

        $this->assertEquals($arrayOfPopedValues, [3, 2, 1], "Poped values order");
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
         * Test left push (pushToHead).
         */

        // A first node is pushed
        $list->add(1);

        $this->assertEquals(1, $list->length(), "The list contains 1 node.");

        $this->assertInstanceOf(FifoNode::class, $list->head(), "The head node.");

        $this->assertEquals($list->head(), $list->tail(), "The node is at both head and tail positions.");

        $this->assertEquals($list->head()->prev(), null, "The node has no previous node.");

        $this->assertEquals($list->head()->next(), null, "The node has no next node.");

        // A second node is pushed
        $list->add(2);
        $this->nonEmptyFifoListAlwaysVerify($list);
        $this->assertEquals(2, $list->length(), "The list contains 2 nodes.");

        $this->assertEquals([1, 2], $list->toArray(), "Expected toArray() return.");

        $this->assertEquals($list->tail()->prev(), $list->head(), "The head node is the tail previous node.");
        $this->assertEquals($list->head()->next(), $list->tail(), "The tail node is the head next node.");


        $this->assertEquals($list->tail()->getValue(), 2, "data are pushed at the tail.");
        $this->assertEquals($list->head()->getValue(), 1, "data pushes shift data to toward the head.");

        // A third node is pushed
        $list->add(3);
        $this->nonEmptyFifoListAlwaysVerify($list);
        $this->assertEquals(3, $list->length(), "The list contains 3 nodes.");
        $this->assertEquals($list->tail()->getValue(), 3, "data are pushed at the tail.");

        $this->assertEquals([1, 2, 3], $list->toArray(), "Expected toArray() return.");


        $this->assertEquals($list->tail()->prev()->getValue(), 2, "1/ data pushes shift data toward the head.");
        $this->assertEquals($list->head()->getValue(), 1, "2/ data pushes shift data toward the head.");


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
            $popedNode = $list->popFromHead();
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
