<?php

namespace Cristopherm\SimpleScraper;

use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * @test 
     */
    public function it_loads_a_file_from_a_string()
    {
        $rawFile = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                
            </body>
            </html>
        ';

        $file = new HtmlParser();
        $file->loadString($rawFile);

        $this->assertInstanceOf('DOMDocument', $file->document);
    }

    /**
     * @test 
     */
    public function it_loads_from_a_url()
    {
        $file = new HtmlParser();
        $file->loadUrl('http://www.itubombas.institucional.ws/carreira');

        $this->assertInstanceOf('DOMDocument', $file->document);
    }

    /**
     * @test 
     */
    public function it_cleans_a_page()
    {
        $rawFile = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document test</title>
            </head>
            <body>
                <style>Some inline style... Why?</style>
                <header>Some header...</header>
                <p>Hello world!</p>
                <footer>Some footer...</footer>
                <script>Some script</script>
                <script>Yet another script</script>
                <script>Even more scripts</script>
            </body>
            </html>
        ';

        $file = new HtmlParser();
        $result = $file
            ->loadString($rawFile)
            ->parse();

        $this->assertStringNotContainsString('Some inline style', $result->content);
        $this->assertStringNotContainsString('Some header', $result->content);
        $this->assertStringNotContainsString('Some footer', $result->content);
        $this->assertStringNotContainsString('Some script', $result->content);
        $this->assertStringNotContainsString('Yet another script', $result->content);
        $this->assertStringNotContainsString('Even more scripts', $result->content);
    }

    /**
     * @test 
     */
    public function it_cleans_an_id()
    {
        $rawFile = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document test</title>
            </head>
            <body>
                <p>Hello world!</p>
                <p id="t1">Noooo!</p>
                <p id="t2">Another...</p>
            </body>
            </html>
        ';

        $file = new HtmlParser();

        $result = $file->loadString($rawFile)
            ->idsForCleaning(['t1', 't2'])
            ->parse();

        $this->assertStringNotContainsString('Another...', $result->content);
    }

    /**
     * @test 
     */
    public function it_parses_a_title()
    {
        $rawFile = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document test</title>
            </head>
            <body>
                <p>Hello world!</p>
            </body>
            </html>
        ';

        $file = new HtmlParser();
        $file->loadString($rawFile);
        $result = $file->parse();

        $this->assertEquals('Document test', $result->title);
    }

    /**
     * @test 
     */
    public function it_parses_a_title_without_prefix()
    {
        $rawFile = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Big Company - Page Title</title>
            </head>
            <body>
                <p>Hello world!</p>
            </body>
            </html>
        ';

        $file = new HtmlParser();
        $result = $file
            ->loadString($rawFile)
            ->parse('Big Company - ');

        $this->assertEquals('Page Title', $result->title);
    }

    /**
     * @test 
     */
    public function it_parses_tags()
    {
        $rawFile = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="keywords" content="tag1, tag2">
                <title>Document test</title>
            </head>
            <body>
                <p>Hello world!</p>
            </body>
            </html>
        ';

        $file = new HtmlParser();
        $file->loadString($rawFile);
        $result = $file->parse();

        $this->assertEquals('tag1, tag2', $result->tags);
    }

    public function it_parses_content()
    {
        $rawFile = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document test</title>
            </head>
            <body>
                <p>Hello world!</p>
            </body>
            </html>
        ';

        $file = new HtmlParser();
        $file->loadString($rawFile);
        $result = $file->parse();

        $this->stringContains('Hello world!', $result->content);
    }

    public function it_parses_a_description()
    {
        $rawFile = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document test</title>
            </head>
            <body>
                <p>Hello world!</p>
            </body>
            </html>
        ';

        $file = new HtmlParser();
        $file->loadString($rawFile);
        $result = $file->parse();

        $this->stringContains('Hello world!', $result->description);
    }
}
