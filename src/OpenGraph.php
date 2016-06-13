<?php

namespace JWorksUK\OpenGraph;

use DomDocument;
use DOMXPath;

class OpenGraph
{
    public $tags;
    /**
     * Create a new Skeleton Instance
     */
    public function __construct()
    {
        // constructor body
    }

    /**
     * [fetch description]
     *
     * @param string $url Page url
     *
     * @return [type]      [description]
     */
    public static function fetch($url)
    {
        // Update to CURL
        $html = file_get_contents($url);

        return self::parse($html);
    }

    /**
     * Parse HTML
     *
     * @param string $html html
     *
     * @return OpenGraph
     */
    public static function parse($html)
    {
        if (empty($html)) {
            throw new \LengthException('HTML is blank.');
        }

        libxml_use_internal_errors(true);

        $page = new self;
        $doc = new DomDocument();
        $doc->loadHTML($html);
        $xpath = new DOMXPath($doc);
        $query = '//*/meta[starts-with(@property, \'og:\')]';
        $metas = $xpath->query($query);
        foreach ($metas as $meta) {
            $property = str_replace('og:', '', $meta->getAttribute('property'));
            $content = $meta->getAttribute('content');
            $page->tags[$property] = $content;
        }

        if (count($page->tags) == 0) {
            throw new \Exception('No Tags Found.');
        }

        return $page;
    }
}
