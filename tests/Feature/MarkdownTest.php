<?php
namespace emmy\Press\Tests;

use Parsedown;
use emmy\Press\MarkdownParser;

class MarkdownTest extends TestCase
{
    /** @test */
    public function simple_markdown_is_parsed()
    {
        $this->assertEquals("<h1>Heading</h1>", MarkdownParser::parse('# Heading'));
    }
}
