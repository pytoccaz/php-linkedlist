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

        $nNode = 50000;

        print("Singly-linked Performance report ().\n");
        print("==============================.\n");
        printf("Number of nodes is %s.\n",  $nNode);

        $stopwatch = new Stopwatch();

        $array = range(1, $nNode);
        
        $collection = new FiloList;

        $stopwatch->start('feed');

        foreach ($array as $item) {
            $collection->add($item);
        }   

        $feedEvent  =  $stopwatch->stop('feed');
        $feedTime   = $feedEvent->getDuration();

        $this->assertTrue($feedTime <=  500, "feed time lower than 500ms" );
        printf ("feed time took %s ms.\n", $feedTime);

        $stopwatch->start('iter');
        foreach ($collection as $item) {
        }
        

        $iterEvent  =  $stopwatch->stop('iter');
        $iterTime   = $iterEvent->getDuration();
        printf ("iter time took %s ms.\n", $iterTime);
  
        

        $stopwatch->start('pop');

        foreach ($array as $item) {
            $collection->pop();
        }   
 

        $popEvent  = $stopwatch->stop('pop');
        $popTime   = $popEvent->getDuration();
        printf ("pop time took %s ms.\n", $popTime);

        $this->assertTrue($popTime <=  $feedTime, "pop time lower than feed time" );
        $this->assertTrue($iterTime <= $feedTime, "iter time lower than feed time" );
    }
}
