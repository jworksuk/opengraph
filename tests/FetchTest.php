<?php

namespace JWorksUK\OpenGraph;

class FetchTest extends \PHPUnit_Framework_TestCase
{
    public function testFetch()
    {
        $opengraph = OpenGraph::fetch(
            'http://www.thingsofmyinterest.com/2013/02/urbance-trailer/'
        );
        $this->assertArrayHasKey('title', $opengraph->tags);
        $this->assertArrayHasKey('type', $opengraph->tags);
        $this->assertArrayHasKey('url', $opengraph->tags);
        $this->assertArrayHasKey('image', $opengraph->tags);
    }
}
