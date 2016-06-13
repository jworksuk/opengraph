<?php

namespace JWorksUK\OpenGraph;

class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \LengthException
     */
    public function testLengthException()
    {
        $opengraph = OpenGraph::parse('');
    }

    /**
     * @expectedException \Exception
     */
    public function testNoTagsException()
    {
        $html = '<!DOCTYPE html><html><body><h1>Test</h1></body></html>';

        $opengraph = OpenGraph::parse($html);
    }
}
