<?php

namespace JWorksUK\OpenGraph;

class OpenGraphTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->og = new OpenGraph;
    }

    public function invalidUrls()
    {
        return [
            ['www.google.com'],
            ['google.com'],
            ['/posts/1']
        ];
    }

    public function validUrls()
    {
        return [
            ['http://www.imdb.com/title/tt3498820/'],
            ['https://soundcloud.com/lifeofdesiigner/desiigner-panda/']
        ];
    }

    /**
     * @dataProvider validUrls
     */
    public function testFetch($url)
    {
        $opengraph = $this->og->fetch($url);
        $this->assertArrayHasKey('title', $opengraph->tags);
        $this->assertArrayHasKey('type', $opengraph->tags);
        $this->assertArrayHasKey('url', $opengraph->tags);
        $this->assertArrayHasKey('image', $opengraph->tags);
    }

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

        $opengraph = $this->og->parse($html);
        $this->assertSame('Title', $opengraph->tags['title']);
        $this->assertSame('website', $opengraph->tags['type']);
        $this->assertSame('http://example.com', $opengraph->tags['url']);
        $this->assertSame('http://example.com/image.jpg', $opengraph->tags['image']);
        $this->assertSame('Site Name', $opengraph->tags['site_name']);
        $this->assertSame('Description', $opengraph->tags['description']);
    }

    /**
     * @expectedException \LengthException
     */
    public function testLengthException()
    {
        $opengraph = $this->og->parse('');
    }

    /**
     * @expectedException \Exception
     */
    public function testNoTagsException()
    {
        $html = '<!DOCTYPE html><html><body><h1>Test</h1></body></html>';

        $opengraph = $this->og->parse($html);
    }

    /**
     * @dataProvider invalidUrls
     * @expectedException \Exception
     */
    public function testInvalidUrl($url)
    {
        $opengraph = $this->og->fetch($url);
    }
}
