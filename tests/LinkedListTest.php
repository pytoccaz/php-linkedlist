<?php

declare(strict_types=1);

namespace Obernard\LinkedList\Tests;

use Obernard\LinkedList\Collection\FifoList;
use Obernard\LinkedList\Collection\FifoNode;
use Obernard\LinkedList\Collection\LifoList;
use Obernard\LinkedList\Tests\Helpers\TailToHeadFifoList;
use PHPUnit\Framework\TestCase;

/**
 * @author olivier Bernard
 */
class LinkedListTest extends TestCase
{
    private function nonEmptyFifoListAlwaysVerify($list): void
    {
        self::assertInstanceOf(FifoNode::class, $list->head(), 'The head node.');
        self::assertInstanceOf(FifoNode::class, $list->tail(), 'The tail node.');
        self::assertNull($list->head()->prev(), 'The head node has no previous node.');
        self::assertTrue($list->head($list->length() - 1)->isLast(), 'when offset === length-1, return tail node.');

        if ($list->length() > 1) {
            self::assertInstanceOf(FifoNode::class, $list->head()->next(), 'The head node has a next node.');
        }

        $this->assertEquals($list->tail()->next(), null, 'The tail node has no next node.');

        if ($list->length() > 1) {
            self::assertInstanceOf(FifoNode::class, $list->tail()->prev(), 'The tail node has a previous node.');
        }

        self::assertTrue($list->head()->isFirst(), '1/ The head node is the first one.');
        self::assertTrue($list->head(0)->isFirst(), '2/ The head node is the first one.');
        self::assertTrue($list->head()->next(0)->isFirst(), '4/ The head node is the first one.');
        self::assertTrue($list->head(0)->next(0)->isFirst(), '5/ The head node is the first one.');
        self::assertTrue($list->tail()->isLast(), 'The tail node is the last one.');
        self::assertTrue($list->tail(0)->isLast(), '2/ The tail node is the last one.');
        self::assertTrue($list->tail()->prev(0)->isLast(), '4/ The tail node is the last one.');
        self::assertTrue($list->tail(0)->prev(0)->prev(0)->isLast(), '5/ The tail node is the last one.');
        self::assertEquals($list->length() - 1, $list->tail()->distanceToFirstNode(), 'Tail node distanceToFirstNode always returns length - 1.');
        self::assertEquals($list->length() - 1, $list->head()->distanceToLastNode(), 'Head node distanceToLastNode always returns length - 1.');
        self::assertEquals(0, $list->tail()->distanceToLastNode(), 'Tail node distanceToLastNode returns 0');
        self::assertEquals(0, $list->head()->distanceToFirstNode(), 'Head node distanceToFirstNode returns 0');
        self::assertEquals($list->length(), \count($list), 'List obj are countable');
        self::assertSame($list->head(), $list->tail($list->length() - 1), 'Get the head node through tail offset');
        self::assertSame($list->tail(), $list->head($list->length() - 1), 'Get the tail node through head offset');
    }

    public function testAbstractSinglyLinkedListWithLifoList(): void
    {
        $list = new LifoList();
        self::assertInstanceOf(LifoList::class, $list);
        self::assertNull($list->key(), 'Test of key internal method when list is empty.');
        self::assertFalse($list->valid(), 'Test of valid method when list is empty.');
        self::assertTrue($list->isEmpty(), 'List is empty.');

        $list->push(1)->push(2)->push(3);
        self::assertEquals($list->head(0), $list->head(), 'Get head node through head');
        self::assertEquals($list->head(1), $list->head()->next(), 'Get n\'th node through head');
        self::assertEquals($list->head(2), $list->head()->next()->next(), 'Get n\'th node through head');
        self::assertEquals($list->length() - 1, $list->head()->distanceToLastNode(), 'Head node distanceToLastNode always returns length - 1.');
        self::assertEquals(3, $list->length(), 'The list contains 3 nodes.');
        self::assertEquals([3, 2, 1], $list->toArray(), 'Expected toArray() return.');
        self::assertEquals(1, $list->head($list->length() - 1)->getValue(), 'Get the tail node through head offset');

        $ar = [];
        foreach ($list as $value) {
            $ar[] = $value;
        }
        self::assertEquals($ar, $list->toArray(), 'Comparison of toArray and foreach results.');

        // pops all the nodes
        $i = 0;
        $lengthBeforePops = $list->length();
        $arrayOfPopedValues = [];

        while ($list->length()) {
            ++$i;
            $popedNode = $list->popFromHead();
            $arrayOfPopedValues[] = $popedNode->getValue();
            $this->assertEquals($popedNode->next(), null, 'Poped node has no next node.');
        }
        self::assertEquals(0, $list->length(), '1/ The list is empty.');
        self::assertTrue($list->isEmpty(), '1/ The list is empty.');
        self::assertEquals($i, $lengthBeforePops, 'Controles number of iterations.');
        self::assertEquals([3, 2, 1], $arrayOfPopedValues, 'Poped values order');
    }

    public function testAbstractDoubledLinkedListWithFifoList(): void
    {
        $list = new FifoList();
        self::assertInstanceOf(FifoList::class, $list);
        self::assertNull($list->key(), 'Test of key internal method when list is empty.');
        self::assertFalse($list->valid(), 'Test of valid method when list is empty.');
        self::assertTrue($list->isEmpty(), 'List is empty.');

        /*
         * Test left push (push to head).
         */

        // A first node is pushed
        $list->push(1);
        self::assertEquals(1, $list->length(), 'The list contains 1 node.');
        self::assertInstanceOf(FifoNode::class, $list->head(), 'The head node.');
        self::assertSame($list->head(), $list->tail(), 'The node is at both head and tail positions.');
        self::assertNull($list->head()->prev(), 'The node has no previous node.');
        self::assertNull($list->head()->next(), 'The node has no next node.');
        $this->nonEmptyFifoListAlwaysVerify($list);

        // A second node is pushed
        $list->push(2);
        $this->nonEmptyFifoListAlwaysVerify($list);
        self::assertEquals(2, $list->length(), 'The list contains 2 nodes.');
        self::assertSame($list->tail()->prev(), $list->head(), 'The head node is the tail previous node.');
        self::assertSame($list->head()->next(), $list->tail(), 'The tail node is the head next node.');
        self::assertEquals(1, $list->head()->getValue(), 'data are pushed at the tail.');
        self::assertEquals(2, $list->tail()->getValue(), 'data are pushed at the tail.');

        // A third node is pushed
        $list->push(3);
        $this->nonEmptyFifoListAlwaysVerify($list);
        self::assertEquals(3, $list->length(), 'The list contains 3 nodes.');
        self::assertEquals(3, $list->tail()->getValue(), 'data are pushed at the tail.');
        self::assertEquals(2, $list->tail()->prev()->getValue(), 'data are pushed at the tail.');
        self::assertEquals(1, $list->head()->getValue(), 'data are pushed at the tail.');
        self::assertEquals([1, 2, 3], $list->toArray(), 'Expected toArray() return.');

        $ar = [];
        foreach ($list as $value) {
            $ar[] = $value;
        }
        self::assertEquals($ar, $list->toArray(), 'Comparison of toArray and foreach results.');

        // pops all the nodes
        $i = 0;
        $lengthBeforePops = $list->length();
        $arrayOfPopedValues = [];

        while ($list->length()) {
            ++$i;
            $popedNode = $list->popFromTail();
            $arrayOfPopedValues[] = $popedNode->getValue();
            self::assertNull($popedNode->next(), 'Poped node has no next node.');
            self::assertNull($popedNode->prev(), 'Poped node has no prev node.');
        }
        self::assertEquals(0, $list->length(), '1/ The list is empty.');
        self::assertTrue($list->isEmpty(), '1/ The list is empty.');
        self::assertEquals($i, $lengthBeforePops, 'Controles number of iterations.');
        self::assertEquals([3, 2, 1], $arrayOfPopedValues, 'Poped values order');
    }

    public function testAbstractDoubledLinkedListWithTailToHeadFifoList(): void
    {
        $list = new TailToHeadFifoList();
        self::assertInstanceOf(TailToHeadFifoList::class, $list);
        self::assertNull($list->key(), 'Test of key internal method when list is empty.');
        self::assertFalse($list->valid(), 'Test of valid method when list is empty.');
        self::assertTrue($list->isEmpty(), 'List is empty.');

        /*
         * Test left push (pushToHead).
         */

        // A first node is pushed
        $list->add(1);

        self::assertEquals(1, $list->length(), 'The list contains 1 node.');
        self::assertInstanceOf(FifoNode::class, $list->head(), 'The head node.');
        self::assertEquals($list->head(), $list->tail(), 'The node is at both head and tail positions.');
        self::assertNull($list->head()->prev(), 'The node has no previous node.');
        self::assertNull($list->head()->next(), 'The node has no next node.');

        // A second node is pushed
        $list->add(2);
        $this->nonEmptyFifoListAlwaysVerify($list);
        self::assertEquals(2, $list->length(), 'The list contains 2 nodes.');
        self::assertEquals([1, 2], $list->toArray(), 'Expected toArray() return.');
        self::assertSame($list->tail()->prev(), $list->head(), 'The head node is the tail previous node.');
        self::assertSame($list->head()->next(), $list->tail(), 'The tail node is the head next node.');
        self::assertEquals(2, $list->tail()->getValue(), 'data are pushed at the tail.');
        self::assertEquals(1, $list->head()->getValue(), 'data pushes shift data to toward the head.');

        // A third node is pushed
        $list->add(3);
        $this->nonEmptyFifoListAlwaysVerify($list);
        self::assertEquals(3, $list->length(), 'The list contains 3 nodes.');
        self::assertEquals(3, $list->tail()->getValue(), 'data are pushed at the tail.');
        self::assertEquals([1, 2, 3], $list->toArray(), 'Expected toArray() return.');
        self::assertEquals(2, $list->tail()->prev()->getValue(), '1/ data pushes shift data toward the head.');
        self::assertEquals(1, $list->head()->getValue(), '2/ data pushes shift data toward the head.');

        $ar = [];
        foreach ($list as $value) {
            $ar[] = $value;
        }
        self::assertEquals($ar, $list->toArray(), 'Comparison of toArray and foreach results.');

        // pops all the nodes
        $i = 0;
        $lengthBeforePops = $list->length();
        $arrayOfPopedValues = [];

        while ($list->length()) {
            ++$i;
            $popedNode = $list->popFromHead();
            $arrayOfPopedValues[] = $popedNode->getValue();
            self::assertNull($popedNode->next(), 'Poped node has no next node.');
            self::assertNull($popedNode->prev(), 'Poped node has no prev node.');
        }
        self::assertEquals(0, $list->length(), '1/ The list is empty.');
        self::assertTrue($list->isEmpty(), '1/ The list is empty.');
        self::assertEquals($i, $lengthBeforePops, 'Controles number of iterations.');
        self::assertEquals([1, 2, 3], $arrayOfPopedValues, 'Poped values order');
    }
}
