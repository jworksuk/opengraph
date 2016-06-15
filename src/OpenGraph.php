<?php

namespace JWorksUK\OpenGraph;

use DomDocument;
use DOMXPath;

class OpenGraph
{
    public $tags;
    /**
     * Create a new OpenGraph Instance
     */
    public function __construct()
    {
        // constructor body
    }

    /**
     * Fetches html content
     *
     * @param  string $url
     *
     * @return OpenGraph
     */
    public static function fetch($url)
    {
        // Is URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception('Invalid URL');
        }

        // Get cURL resource
        $curl = curl_init();

        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
        ]);

        // Send the request & save response to $resp
        $html = curl_exec($curl);

        // Close request to clear up some resources
        curl_close($curl);

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

        $metas = $doc->getElementsByTagName('meta');

        foreach ($metas as $meta) {
            if ($meta->hasAttribute('property') &&
                strpos($meta->getAttribute('property'), 'og:') === 0) {
                $key = trim(
                    str_replace('og:', '', $meta->getAttribute('property'))
                );

                $page->tags[$key] = $meta->getAttribute('content');
            }
        }

        if (count($page->tags) == 0) {
            throw new \Exception('No Tags Found.');
        }

        return $page;
    }
}
