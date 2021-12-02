<?php

/**
 * @author olivier Bernard
 */

namespace Obernard\LinkedList\Tests;

ini_set('xdebug.remote_autostart', 0);
ini_set('xdebug.remote_enable', 0);
ini_set('xdebug.profiler_enable', 0);

ini_set('xdebug.max_nesting_level=100000 ', 0);


use Symfony\Component\Stopwatch\Stopwatch;

use  Obernard\LinkedList\Collection\FiloList;
use PHPUnit\Framework\TestCase;

class PerfTest extends TestCase
{
    public function testPerf()
    {

        $nNode = 200000;

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
  

        $collection->headn($collection->length());    

        $stopwatch->start('rank');

        // get head rank
        $collection->headn()->rrank();
   
        $rankEvent  =  $stopwatch->stop('rank');
        $rankTime   = $rankEvent->getDuration();
        printf ("head rank time took %s ms.\n", $rankTime);
  
        $stopwatch->start('pop');

        foreach ($array as $item) {
            $collection->pop();
        }   
 

        $popEvent  = $stopwatch->stop('pop');
        $popTime   = $popEvent->getDuration();
        printf ("pop all time took %s ms.\n", $popTime);

        $this->assertTrue($iterTime <= $feedTime, "iter time lower than feed time" );
    }
}
