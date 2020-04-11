<?php
namespace emmy\Press\Fields;
use emmy\Press\MarkdownParser;

class Body extends FieldContract
{
    public static function process($type, $value, $data)
    {
        return [
            $type => MarkDownParser::parse($value),
        ];
    }
}
