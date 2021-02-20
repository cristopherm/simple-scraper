<?php

namespace Cristopherm\SimpleScraper;

use DOMDocument;
use GuzzleHttp\Client;

class HtmlParser
{
    public $document;
    private $cleaningIds;

    public function __construct()
    {
        $this->cleaningIds = [];
    }

    public function loadString(string $string)
    {
        $this->load($string);

        return $this;
    }

    public function loadUrl(string $url)
    {
        $client = new Client();

        $response = $client->request(
            'GET', $url, [
            'headers' => ['Accept-Language' => 'pt'],
            ]
        );

        $response = (string) $response->getBody();

        $this->load($response);

        return $this;
    }

    public function parse(string $titlePrefix = null)
    {
        $this->cleanHtml();

        $title = null;
        $tags = null;
        $description = null;
        $content = null;

        foreach ($this->document->getElementsByTagName('body') as $dom) {
            $content = trim($dom->textContent);

            break;
        }

        foreach ($this->document->getElementsByTagName('title') as $dom) {
            $title = trim($dom->textContent);

            if ($titlePrefix) {
                $title = str_replace($titlePrefix, '', $title);
            }

            break;
        }

        foreach ($this->document->getElementsByTagName('meta') as $dom) {
            if ($dom->getAttribute('name') === 'keywords') {
                $tags = trim($dom->getAttribute('content'));
            }
        }

        foreach ($this->document->getElementsByTagName('p') as $dom) {
            $description = trim($dom->textContent);

            break;
        }

        return new Page($title, $tags, $description, $content);
    }

    private function load(string $rawDocument)
    {
        libxml_use_internal_errors(true);

        $this->document = new DOMDocument();
        $this->document->loadHTML($rawDocument);

        libxml_use_internal_errors(false);

        return $this;
    }

    private function cleanHtml()
    {
        $tags = [
            'header',
            'footer',
            'style',
            'script',
        ];

        foreach ($tags as $tag) {
            $items = $this->document->getElementsByTagName($tag);

            $itemsForRemoving = [];

            foreach ($items as $item) {
                $itemsForRemoving[] = $item;
            }

            foreach ($itemsForRemoving as $item) {
                $item->parentNode->removeChild($item); 
            }

        }

        foreach ($this->cleaningIds as $id) {
            $dom = $this->document->getElementById($id);

            if ($dom) {
                $dom->parentNode->removeChild($dom);
            }
        }
    }

    public function idsForCleaning(array $ids)
    {
        $this->cleaningIds = $ids;

        return $this;
    }
}
