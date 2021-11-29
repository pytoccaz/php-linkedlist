<?php

/**
 * @author olivier Bernard
 */

namespace Obernard\LinkedList\Tests;

use Symfony\Component\Stopwatch\Stopwatch;

use  Obernard\LinkedList\Collection\FiloList;
use PHPUnit\Framework\TestCase;

class PerfTest extends TestCase
{
    public function testPerf()
    {
        $stopwatch = new Stopwatch();

        $array = range(1, 100000);
        $collection = new FiloList;

        $stopwatch->start('feed');

        foreach ($array as $item) {
            $collection->add($item);
        }   

        $feedEvent  =  $stopwatch->stop('feed');
        $feedTime   = $feedEvent->getDuration();

        $this->assertTrue($feedTime <=  500, "feed time lower than 500ms" );


        $stopwatch->start('iter');
        foreach ($collection as $item) {
        }
        
        $iterEvent  =  $stopwatch->stop('iter');
        $iterTime   = $iterEvent->getDuration();
        

        $stopwatch->start('pop');

        foreach ($array as $item) {
            $collection->pop();
        }   
 

        $popEvent  = $stopwatch->stop('pop');
        $popTime   = $popEvent->getDuration();
 

        $this->assertTrue($popTime <=  $feedTime, "pop time lower than feed time" );
        $this->assertTrue($iterTime <= $feedTime, "iter time lower than feed time" );
    }
}
