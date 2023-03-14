<?php

declare(strict_types=1);

namespace Obernard\LinkedList\Tests;

use Obernard\LinkedList\Collection\LifoList;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * @author olivier Bernard
 */
class PerfTest extends TestCase
{
    public function testPerf(): void
    {
        $nNode = 100000;
        echo "\n==================================\n";
        echo 'Singly-linked Performance report.';
        echo "\n==================================\n";
        printf("Number of nodes is %s.\n", $nNode);

        $stopwatch = new Stopwatch();

        $array = range(1, $nNode);

        $collection = new LifoList();

        $stopwatch->start('feed');

        foreach ($array as $item) {
            $collection->push($item);
        }

        $feedEvent = $stopwatch->stop('feed');
        $feedTime = $feedEvent->getDuration();

        self::assertLessThan(500, $feedTime, 'feed time lower than 500ms');
        printf("O(n) feed time took %s ms.\n", $feedTime);

        $stopwatch->start('iter');

        foreach ($collection as $item) {
        }

        $iterEvent = $stopwatch->stop('iter');
        $iterTime = $iterEvent->getDuration();
        printf("O(n) iter time took %s ms.\n", $iterTime);

        $stopwatch->start('rank');

        // get head rank from the right
        $collection->head()->distanceToLastNode();

        $rankEvent = $stopwatch->stop('rank');
        $rankTime = $rankEvent->getDuration();
        printf("O(n) head distanceToLastNode time took %s ms.\n", $rankTime);

        $stopwatch->start('pop');

        foreach ($array as $item) {
            $collection->pop();
        }

        $popEvent = $stopwatch->stop('pop');
        $popTime = $popEvent->getDuration();
        printf("pop-all time took %s ms.\n", $popTime);

        self::assertTrue($iterTime <= $feedTime, 'iter time lower than feed time');
    }
}
