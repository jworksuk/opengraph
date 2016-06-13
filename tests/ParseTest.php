<?php

namespace JWorksUK\OpenGraph;

class ParseTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $html = '<!DOCTYPE html><html><head>'.
        '<meta property="og:title" content="Title" />'.
        '<meta property="og:type" content="website" />'.
        '<meta property="og:url" content="http://example.com" />'.
        '<meta property="og:image" content="http://example.com/image.jpg" />'.
        '<meta property="og:site_name" content="Site Name" />'.
        '<meta property="og:description" content="Description"/>'.
        '</head><body><h1>Test</h1></body></html>';

        $opengraph = OpenGraph::parse($html);
        $this->assertSame('Title', $opengraph->tags['title']);
        $this->assertSame('website', $opengraph->tags['type']);
        $this->assertSame('http://example.com', $opengraph->tags['url']);
        $this->assertSame('http://example.com/image.jpg', $opengraph->tags['image']);
        $this->assertSame('Site Name', $opengraph->tags['site_name']);
        $this->assertSame('Description', $opengraph->tags['description']);
    }
}
