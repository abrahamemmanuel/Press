<?php
namespace emmy\Press;

use Illuminate\Support\Facades\File;

class PressFileParser
{
    protected $filename;
    protected $data;

    public function __construct($filename)
    {
        $this->filename = $filename;

        $this->splitFile();
    }

    public function getData()
    {
      return $this->data;
    }

    protected function splitFile()
    {
      preg_match_all('/^\-{3}(.*?)\-{3}(.*)/s', 
      File::get($this->filename), 
      $this->data
    );

    dd($this->data);
    }
}
