<?php
namespace emmy\Press;

use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use emmy\Press\MarkdownParser;

class PressFileParser
{
    protected $filename;
    protected $data;

    public function __construct($filename)
    {
        $this->filename = $filename;

        $this->splitFile();

        $this->explodeData();

        $this->processFields();
    }

    public function getData()
    {
        return $this->data;
    }

    protected function splitFile()
    {
        // regular expression
        preg_match('/^\-{3}(.*?)\-{3}(.*)/s',
            File::exists($this->filename) ? File::get($this->filename) : $this->filename,
            $this->data
        );

        // dd($this->data);
    }

    public function explodeData()
    {
        foreach (explode("\n", trim($this->data[1])) as $fieldString) {
            // regular expression
            preg_match('/(.*):\s?(.*)/', $fieldString, $fieldArray);

            $this->data[$fieldArray[1]] = $fieldArray[2];
            // dd($fieldArray);
        }

        // save the blog body
        $this->data['body'] = trim($this->data[2]);
        //   dd(trim($this->data[2]));
    }

    public function processFields()
    {
        foreach ($this->data as $field => $value) {
            if ($field === 'date') {
                $this->data[$field] = Carbon::parse($value);
                // dd($value);
            } else if ($field === 'body') {
               $this->data[$field] = MarkdownParser::parse($value);
            }
        }
    }
}
