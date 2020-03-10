<?php

namespace emmy\Press;

class MarkdownParser
{
    public static function parse($string)
    {
      // $parsedown = new \Parsedown();

      // return $parsedown->text($string);

      /**code refactoring */
      return \Parsedown::instance()->text($string);
    }
}
