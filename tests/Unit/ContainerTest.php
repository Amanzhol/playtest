<?php

namespace Tests\Unit;

use App\For_Test\Container;
use App\For_Test\Newsletter;
use Tests\TestCase;

class ContainerTest extends TestCase
{
    public $flag = true;



    /** @test */
    public function LEVEL_ONE_it_can_bind_keys_to_values()
    {
        $container = new Container;

        $container->bind('foo','bar');

        $this->assertEquals($container->get('foo'),'bar');
    }

    /** @test */
    public function LEVEL_TWO_it_can_lazily_resolve_functions()
    {
        $container = new Container();

//        $container->bind('newsletter', function (){
//            return new Newsletter(uniqid());
//        });

        $container->singleton('newsletter', function (){
            return new Newsletter(uniqid());
        });

        var_dump($container->get('newsletter'));
        var_dump($container->get('newsletter'));
        var_dump($container->get('newsletter'));
        var_dump($container->get('newsletter'));

        $this->assertInstanceOf(Newsletter::class, $container->get('newsletter'));
    }



}
