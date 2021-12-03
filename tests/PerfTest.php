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

        $nNode = 100000;
        print("\n==================================\n");
        print("Singly-linked Performance report.");
        print("\n==================================\n");
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
        printf ("O(n) feed time took %s ms.\n", $feedTime);

        $stopwatch->start('iter');

        foreach ($collection as $item) {
        }
        

        $iterEvent  =  $stopwatch->stop('iter');
        $iterTime   = $iterEvent->getDuration();
        printf ("O(n) iter time took %s ms.\n", $iterTime);
  

        $stopwatch->start('rank');

        // get head rank from the right
        $collection->headn()->rrank();
   
        $rankEvent  =  $stopwatch->stop('rank');
        $rankTime   = $rankEvent->getDuration();
        printf ("O(n) head rrank time took %s ms.\n", $rankTime);
  
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
