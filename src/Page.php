<?php

namespace Cristopherm\SimpleScraper;

class Page
{
    public $title;

    public $tags;

    public $description;

    public $content;

    public function __construct(
        string $title = null,
        string $tags = null,
        string $description = null,
        string $content = null
    ) {
        $this->title = $title;
        $this->tags = $tags;
        $this->description = $description;
        $this->content = $content;
    }
}
